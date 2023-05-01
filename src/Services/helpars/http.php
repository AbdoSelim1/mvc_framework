<?php

use Src\Resouces\Views\ErrorViews;
use Src\Http\Routes\handle\RouteAlias;
use Src\Http\Request\RedirectWithFeatures;
use Src\Support\Session\Session;

if (!function_exists('url')) {
    function url(string $url = ''): string
    {
        return 'http://' . $_SERVER['HTTP_HOST'] . start_slach_handle($url);
    }
}


if (!function_exists('asset')) {
    function asset(string $url = ''): string
    {
        if (isset($_SERVER['HTTPS'])) {
            if ($_SERVER['HTTPS'] == "on") {
                return 'https://' . $_SERVER['HTTP_HOST'] . start_slach_handle($url);
            }
        }
        return 'http://' . $_SERVER['HTTP_HOST'] . start_slach_handle($url);
    }
}

if (!function_exists('route')) {
    function route(string $as, array $prams = []): string
    {
        $route = (new RouteAlias($as, $prams))->get();
        if (isset($_SERVER['HTTPS'])) {
            if ($_SERVER['HTTPS'] == "on") {
                return 'https://' . $_SERVER['HTTP_HOST'] . $route;
            }
        }
        return 'http://' . $_SERVER['HTTP_HOST'] . $route;
    }
}

if (!function_exists('abort')) {
    function abort(int $status)
    {
        echo ErrorViews::getView($status);
    }
}

if (!function_exists('redirect')) {
    function redirect(string $url = ''): RedirectWithFeatures
    {
        $redirect = new RedirectWithFeatures;
        return $redirect->redirect($url);
    }
}

if (!function_exists('session')) {
    function session(): Session
    {
        return new Session; 
    }
}
