<?php

namespace Src\Http\Validation\Handles;

use Src\Http\Validation\Rules\AlphNumaric;
use Src\Http\Validation\Rules\contracts\Rule;
use Src\Http\Validation\Rules\Required;

class MapperRules
{
    private static array $mapRules =  [
        "required" => Required::class,
        "alnum" => AlphNumaric::class
    ];

    public static function getRuleFromMapper(string $rule, array $args): Rule
    {
        return new self::$mapRules[$rule](...$args);
    }
}
