<?php

namespace Src\Http\Validation\Rules\contracts;

interface Rule
{
    public function apply($field, $value, $data): bool;
    public function message(): string;
    public function __toString(): string;
}
