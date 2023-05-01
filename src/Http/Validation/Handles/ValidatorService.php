<?php

namespace Src\Http\Validation\Handles;

class ValidatorService
{
    private $value  = null;
    
    public function __construct(array $data, string $field)
    {
        $this->explodedField($data, $field);
    }

    private function explodedField($data, $field)
    {
        $field = $field . ".";
        $pranet = substr($field, 0, strpos($field, '.'));
        $field = substr($field, strpos($field, '.') + 1);
        $data = $data[$pranet] ?? null;
        if (is_array($data)) {
            $this->explodedField($data, $field);
        } else {
            $this->value = $data;
        }
    }

    public function getValue()
    {
        return $this->value;
    }
}
