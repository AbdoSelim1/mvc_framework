<?php

if (!function_exists('ds')) {
    function ds(): string
    {
        return DIRECTORY_SEPARATOR;
    }
}

if (!function_exists('slach_handle_path')) {
    function slach_handle_path($path = '')
    {
        if (str_starts_with($path, "/")) {
            return   str_replace('/', ds(), $path);
        } elseif (str_starts_with($path, "\\")) {
            return   str_replace('/', ds(), $path);
        } else {
            return ds() . str_replace('/', ds(), $path);
        }
    }
}

if (!function_exists('view_path')) {
    function view_path($view = '')
    {
        $view =  str_replace('.', ds(), $view);
        return __DIR__ . ds() . ".." . ds() . ".." . ds() . ".." . ds() .
            "resources" . ds() . "views" . ds() .   $view . '.blade.php';
    }
}


if (!function_exists('resource_path')) {
    function resource_path($path = '')
    {
        return __DIR__ . ds() . ".." . ds() . ".." . ds() . ".." . ds() .
            "resources" . slach_handle_path($path);
    }
}

if (!function_exists('public_path')) {
    function public_path($path = '')
    {
        return __DIR__ . ds() . ".." . ds() . ".." . ds() . ".." . ds() .
            "public" . slach_handle_path($path);
    }
}


if (!function_exists('storage_path')) {
    function storage_path($path = '')
    {
        return __DIR__ . ds() . ".." . ds() . ".." . ds() . ".." . ds() .
            "storage" . slach_handle_path($path);
    }
}


if (!function_exists('base_path')) {
    function base_path($path = '')
    {
        return __DIR__ . ds() . ".." . ds() . ".." . ds() . ".."  . slach_handle_path($path);
    }
}

if (!function_exists('route_path')) {
    function route_path($path = '')
    {
        return __DIR__ . ds() . ".." . ds() . ".." . ds() . ".." . ds() . "routes" . slach_handle_path($path);
    }
}
