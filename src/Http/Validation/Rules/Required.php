<?php

namespace Src\Http\Validation\Rules;

use Src\Http\Validation\Rules\contracts\Rule;

class Required implements Rule
{
    public function apply($field, $value, $data): bool
    {
        return !empty($value);
    }
    public function message(): string
    {
        return ":attribute is required";
    }
    public function __toString(): string
    {
        return "required";
    }
}
