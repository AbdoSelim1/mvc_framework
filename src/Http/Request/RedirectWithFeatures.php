<?php

namespace Src\Http\Request;

use Src\Support\Session\Session;

class RedirectWithFeatures
{

    public function redirect($url = "", $statusCode = 303): self
    {
        if (headers_sent() === false) {
            header('Location: ' . asset($url), true, $statusCode);
        }
        return $this;
    }

    public function back()
    {
        if (headers_sent() === false) {
            header('Location: ' . $_SERVER['HTTP_REFERER'], true, 303);
        }
        return $this;
    }

    public function with(array|string $key, string $message = null)
    {
        if (is_array($key)) {
            foreach ($key as $elem => $mess) {
                Session::push($elem, $mess);
            }
        }
        Session::push($key, $message);
        return;
    }

    public function withErrors(string $key, $errors)
    {
        Session::push($key, $errors);
        return;
    }
}
