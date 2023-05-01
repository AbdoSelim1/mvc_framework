<?php

namespace Src\Http\Routes\handle;

use \Exception;

trait ErrorHandle
{

    protected function errorHandle(): array
    {
        $flag_is404 = true;
        $flag_is405 = true;
        foreach (self::$routes as $method => $routes) {
            foreach ($routes as $url => $route) {
                $routeValidation = $this->validRoute([$url, $route[1]]);
                if ($routeValidation['url'] == $url) {
                    $flag_is404 = false;
                    if ($method == $this->request->method()) {
                        $flag_is405 = false;
                        return [
                            'flag_is404' => $flag_is404,
                            'flag_is405' => $flag_is405,
                            'routeValidation' => $routeValidation
                        ];
                    }
                }
            }
        }

        return [
            'flag_is404' => $flag_is404,
            'flag_is405' => $flag_is405,
        ];
    }




    protected function displayErrors(array $routeHandle)
    {
        if (!array_key_exists('routeValidation', $routeHandle)) {
            if ($routeHandle['flag_is404']) {
               return  abort(404);
            } elseif ($routeHandle['flag_is405']) {
                return  abort(405);
            }
        }
        return 0;
    }

    protected static function routeExists(string $route, string $method = 'get')
    {
        if (isset(self::$routes[$method][$route])) {
            throw new \Exception('this Route is already Exists');
        }
        return true;
    }
}
