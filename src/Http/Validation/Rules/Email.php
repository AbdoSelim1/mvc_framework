<?php

namespace Src\Http\Validation\Rules;

use Src\Http\Validation\Rules\contracts\Rule;

class Email implements Rule
{
    public function apply($field, $value, $data): bool
    {
        return true;
    }

    public function message(): string
    {
        return "";
    }

    public function __toString(): string
    {
        return "email";
    }
}
