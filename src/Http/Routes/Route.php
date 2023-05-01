<?php

namespace Src\Http\Routes;

use Src\Http\Request\Request;
use Src\Http\Response\Response;
use Src\Http\Routes\handle\ErrorHandle;
use Src\Http\Routes\handle\RouteHandle;

class Route
{
    use RouteHandle, ErrorHandle;

    private static $method = '';

    public function __construct(private Request $request, private Response $response)
    {
    }

    public static function get(string $url, callable|array|string|null $action)
    {
        self::$method = __FUNCTION__;
        self::routeExists(slach_handle($url));
        self::$routes['get'][slach_handle($url)] = [$action, self::handlePrams($url)];
        return  new self(new Request, new Response);
    }

    public static function post(string $url, callable|array|string|null $action)
    {
        self::$method = __FUNCTION__;
        self::routeExists(slach_handle($url), 'post');
        self::$routes['post'][slach_handle($url)] = [$action, self::handlePrams($url)];
        return  new self(new Request, new Response);
    }


    public static function put(string $url, callable|array|string|null $action)
    {
        self::$method = __FUNCTION__;
        self::routeExists(slach_handle($url), 'put');
        self::$routes['put'][slach_handle($url)] = [$action, self::handlePrams($url)];
        return  new self(new Request, new Response);
    }

    public static function patch(string $url, callable|array|string|null $action)
    {
        self::$method = __FUNCTION__;
        self::routeExists(slach_handle($url), 'patch');
        self::$routes['patch'][slach_handle($url)] = [$action, self::handlePrams($url)];
        return  new self(new Request, new Response);
    }

    public static function delete(string $url, callable|array|string|null $action)
    {
        self::$method = __FUNCTION__;
        self::routeExists(slach_handle($url), 'delete');
        self::$routes['delete'][slach_handle($url)] = [$action, self::handlePrams($url)];
        return  new self(new Request, new Response);
    }


    public static function resource(string $parentPrefix, string $controller, string $prameterName = 'id')
    {
        $as = str_replace('/', '.', ltrim(rtrim($parentPrefix, '/'), '/'));
        Route::get($parentPrefix, [$controller, 'index'])->name($as . '.index');
        Route::get($parentPrefix . 'create/', [$controller, 'create'])->name($as . '.create');
        Route::post($parentPrefix . 'store/', [$controller, 'store'])->name($as . '.store');
        Route::get($parentPrefix . "show/{{$prameterName}}", [$controller, 'show'])->name($as . '.show');
        Route::get($parentPrefix . "edit/{{$prameterName}}", [$controller, 'edit'])->name($as . '.edit');
        Route::put($parentPrefix . "update/{{$prameterName}}", [$controller, 'update'])->name($as . '.update');
        Route::delete($parentPrefix . "destroy/{{$prameterName}}", [$controller, 'index'])->name($as . '.destroy');
    }


    public function name(string $as)
    {
        $this->uniqueAliasName($as);
        self::$routes[self::$method][array_key_last(self::$routes[self::$method])]['as'] = $as;
        return $this;
    }

    private function uniqueAliasName(string $as)
    {
        foreach (self::$routes as $method => $routes) {
            foreach ($routes as $route) {
                if ($as == ($route['as'] ?? '')) {
                    throw new \Exception(" Alias name \"{$as}\" already Exists, The Alias Name Must be unique. ");
                }
            }
        }
    }
}
