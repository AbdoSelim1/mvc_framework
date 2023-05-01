<?php

namespace Src\Http\Validation\Handles;

use Src\Http\Validation\Handles\Massage;
use Src\Http\Validation\Handles\ErrorBag;
use Src\Http\Validation\Handles\MapperRules;
use Src\Http\Validation\Rules\contracts\Rule;
use Src\Http\Validation\Handles\ValidatorService;

class Validator
{
    protected static $data;
    protected static $rules;
    protected static ErrorBag $errorBag;
    protected static Massage $massage;
    protected static array $dataValidated = [];
    protected static $fieldValue = ''; 

    public static function make(array $data, array $rules, array $massages = [], array $attributes = [])
    {
        self::$data = $data;
        self::$rules = $rules;
        self::$errorBag = new ErrorBag;
        self::$massage = new Massage($massages, $attributes);
        self::validate();
        return self::$errorBag;
    }

    private static function validate()
    {
        foreach (self::$rules as $field => $rules) {
            foreach (self::handleRules($rules) as $rule) {
                self::appayRule($field, self::resolve($rule));
            }
            self::$dataValidated[$field] = self::$fieldValue;
        }
    }

    private static function handleRules(array|string $rules)
    {
        if (is_string($rules)) {
            return explode("|", $rules);
        }
        return $rules;
    }
    private static function resolve($rule): Rule
    {
        $args = [];
        if (is_string($rule)) {
            if (str_contains($rule, ":")) {
                $explodedRule = explode(":", $rule);
                $rule = $explodedRule[0];
                $args = explode(",", $explodedRule[1]);
            }
            $rule = MapperRules::getRuleFromMapper($rule, $args);
        }
        return $rule;
    }

    private static function getFieldValue(string $field): ?string
    {
        if (str_contains($field, ".")) {
            $valiSer = new ValidatorService(self::$data, $field);
            self::$fieldValue = $valiSer->getValue();
            return $valiSer->getValue();
        }
        self::$fieldValue = self::$data[$field] ?? null;
        return self::$data[$field] ?? null;
    }

    private static function  appayRule(string $field, Rule $rule)
    {
        if (!$rule->apply($field, self::getFieldValue($field), self::$data)) {
            self::$errorBag->append($field, self::$massage->generate($field, $rule));
        }
    }

    public function validated()
    {
        return self::$dataValidated;
    }
}
