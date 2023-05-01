<?php

if (!function_exists("getError")) {
    function getError($key)
    {
        return session()
            ->flash('errors')
            ?->getError($key);
    }
}


if (!function_exists("error")) {
    function error($key)
    {
        return isset(session()->get('errors')?->getErrors()[$key]);
    }
}

if (!function_exists("getErrors")) {
    function getErrors()
    {
        return session()
            ->flash('errors')
            ?->getErrors();
    }
}