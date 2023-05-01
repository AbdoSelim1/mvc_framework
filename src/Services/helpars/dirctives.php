<?php

use Src\Resouces\Views\View;



if (!function_exists('view')) {
    function view($view_path, array $data = [])
    {
        $view  = new View;
        echo $view->openView($view_path, $data);
    }
}

if (!function_exists('view_extends')) {
    function view_extends($view_path)
    {
        $view = new View();
        echo  $view->extends($view_path);
    }
}

if (!function_exists('view_include')) {
    function view_include(string $view_path)
    {
        $view = new View();
        echo  $view->extends($view_path);
    }
}
