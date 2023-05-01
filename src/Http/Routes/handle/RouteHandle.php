<?php

namespace Src\Http\Routes\handle;

use App\Http\Requests\StoreUserRequest;
use ReflectionParameter;
use Src\Http\Request\Request;
use Src\Http\Validation\Request\FormRequest;


trait  RouteHandle
{
    private static $routes = ['get' => [], 'post' => [], 'put' => [], 'patch' => [], 'delete' => []];

    private static function uniquePramter(array $prams)
    {
        if (!(count(array_unique($prams)) == count($prams))) {
            throw new \Exception('Route pattern "' . implode('', $prams) . '" cannot reference variable name "' . implodeRepeatedPrams($prams) . '" more than once.');
        }
    }


    private static function getParmsFromRoute($url): array
    {
        preg_match_all("/\/{\w+}/", $url, $matches);
        self::uniquePramter($matches[0]);
        return $matches[0] ?? [];
    }

    protected static function handlePrams(string $url): array
    {
        $prams = [];
        foreach (self::getParmsFromRoute($url) as $pram) {
            $prams[] = substr($pram, 2, -1);
        }
        return $prams;
    }

    private  function checkPramsForRoute(array $route): bool|int
    {
        if (empty($route)) {
            return false;
        }
        return count($route);
    }

    protected function  validRoute(array $route): array
    {
        $routePrams = $this->checkPramsForRoute($route[1]);
        $urlContains = $this->explodeUrl($this->request->url());
        $routeContains = $this->explodeUrl($route[0]);

        $pramsWithValues = [];
        $routePath = '/';
        if ($routePrams) {
            if (count($urlContains) == count($routeContains)) {
                foreach ($routeContains as $index => $item) {
                    if (str_starts_with($item, '{')) {
                        $i =  array_key_first($route[1]);
                        $pramsWithValues[$route[1][$i]] = $urlContains[$index];
                        unset($route[1][$i]);
                        $routePath .= $routeContains[$index] . "/";
                    } elseif ($item == $urlContains[$index]) {
                        $routePath .= $routeContains[$index] . "/";
                    } else {
                        return ['url' => null, 'prams' => []];
                    }
                }
            } else {
                return ['url' => null, 'prams' => []];
            }
        } else {
            return ['url' => $this->request->url(), 'prams' => []];
        }
        return ['url' => $routePath, 'prams' => $pramsWithValues];
    }

    private function explodeUrl(string $url)
    {
        return explode('/', ltrim(rtrim($url, '/'), '/'));
    }

    protected function actionHandle(callable|array|string|null $action, $routePrams)
    {
        if (is_callable($action)) {
            call_user_func_array($action, [$this->getRequestTypePerCallable($action),  ...$routePrams]);
        } elseif (is_array($action)) {
            call_user_func_array([new $action[0], $action[1]], [$this->getRequestType($action[0], $action[1]), ...$routePrams]);
        } elseif (is_string($action)) {
            $action = explode('@', $action);
            call_user_func_array([new $action[0], $action[1]], [$this->getRequestType($action[0], $action[1]), ...$routePrams]);
        } else {
            return;
        }
    }

    public function resolve()
    {
        $method = $this->request->method();
        $routeHandle = $this->errorHandle();
        $this->displayErrors($routeHandle);
        $url = $routeHandle['routeValidation']['url'] ?? null;
        $action = self::$routes[$method][$url][0] ?? null;
        $this->actionHandle($action, $routeHandle['routeValidation']['prams'] ?? []);
    }

    private function getRequestType($class, $method,)
    {
        $reflection = new \ReflectionParameter([$class, $method], 0);
        $class =  $reflection->getClass()->name ?? Request::class;
        return new $class;
    }

    private function getRequestTypePerCallable($action)
    {
        $refFunction = new \ReflectionFunction($action);
        $parameters = $refFunction->getParameters();
        $class =  $parameters[0]?->getType()?->getName() ?? Request::class;
        return new $class;
    }

    public static function routes()
    {
        return self::$routes;
    }
}
