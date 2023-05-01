<?php

namespace Src\Http\Validation\Request;

use Src\Http\Request\Request;

abstract class FormRequest extends Request
{
    protected abstract function authrize(): bool;
    protected abstract function rules(): array;

    public function __construct()
    {
        if (!$this->authrize()) {
            abort(403);
            die;
        }

        $validator =  $this->make($this->all(), $this->rules(), $this->messages(), $this->attributes());
        if ($validator->fails()) {
            redirect()->back()->withErrors('errors', $validator);
            die;
        }
    }

    public function __call($name, $arguments)
    {
        return [];
    }
}
