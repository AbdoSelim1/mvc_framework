<?php

namespace Src\Http\Request;

use Src\Http\Request\RequestServise;
use Src\Http\Validation\Handles\Validator;

class Request extends Validator
{

    public function all()
    {
        return $_REQUEST;
    }

    public function url()
    {
        $url = $_SERVER['REQUEST_URI'];
        $position = strpos($url, '?');
        if ($position) {
            $url = substr($url, 0, $position);
        }
        return  str_ends_with($url, '/') ? $url : $url . '/';
    }

    public function method()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function validate(array $rules, array $messages = [], array $attributes = [])
    {
        $validator =  $this->make($this->all(), $rules, $messages, $attributes);
        if ($validator->fails()) {
            redirect()->back()->withErrors('errors', $validator->getErrors());
            die;
        }
        return $this->validated();
    }
}
