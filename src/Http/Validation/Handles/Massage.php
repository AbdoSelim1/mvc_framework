<?php

namespace Src\Http\Validation\Handles;

use Src\Http\Validation\Rules\contracts\Rule;

class Massage
{
    public function __construct(protected array $massages, protected array $attributes)
    {
    }

    public function generate(string $field, Rule $rule)
    {
        if (array_key_exists($field . '.' . $rule, $this->massages)) {
            return $this->massages[$field . '.' . $rule]; //field.rule custom message
        }

        if (array_key_exists((string)$rule, $this->massages)) {
            return $this->massages[(string)$rule]; //rule custom message
        }

        return str_replace(':attribute', $this->getAttrVal($field), $rule->message()); // default message
    }

    public  function getAttrVal($field)
    {
        return $this->attributes[$field] ?? $field;
    }
}
