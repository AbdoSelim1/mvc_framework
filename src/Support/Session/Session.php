<?php

namespace Src\Support\Session;

session_start();
class Session
{
    public static function push(string $key, $value)
    {
        $_SESSION[$key] = $value;
        return true;
    }

    public static function get(string $key)
    {
        return $_SESSION[$key] ?? null;
    }

    public static function destroy(string $key)
    {
        unset($_SESSION[$key]);
        return true;
    }

    public static function has(string $key): bool
    {
        return isset($_SESSION[$key]) ? true : false;
    }

    public static function flash(string $key)
    {
        $value =  $_SESSION[$key] ?? null;
        unset($_SESSION[$key]);
        return $value;
    }
}
