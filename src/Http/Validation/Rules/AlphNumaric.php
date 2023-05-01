<?php

namespace Src\Http\Validation\Rules;

use Src\Http\Validation\Rules\contracts\Rule;

class AlphNumaric implements Rule
{
    public function apply($field, $value, $data): bool
    {
        return  (bool)preg_match('/^[\w ]+$/', $value);
    }
    public function message(): string
    {
        return ":attribute must be charchters and numbers only";
    }
    public function __toString(): string
    {
        return "alnum";
    }
}
