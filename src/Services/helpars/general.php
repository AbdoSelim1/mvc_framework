<?php

use Src\Services\Support\Inflect;
use Src\Services\Support\Application;

if (!function_exists('slach_handle')) {
    function slach_handle(string $url)
    {
        $url =  str_starts_with($url, '/') ?  $url : '/' . $url;
        $url =  str_ends_with($url, '/') ?  $url :  $url . '/';
        return $url;
    }
}


if (!function_exists('start_slach_handle')) {
    function start_slach_handle(string $url)
    {
        return str_starts_with($url, '/') ?  $url : '/' . $url;
    }
}

if (!function_exists('getRepeatedElements')) {
    function getRepeatedElements(array $raw_array): array
    {
        $dupes = array();
        natcasesort($raw_array);
        reset($raw_array);
        $old_key   = NULL;
        $old_value = "";
        foreach ($raw_array as $key => $value) {
            if ($value === NULL) {
                continue;
            }
            if (strcasecmp($old_value, $value) === 0) {
                $dupes[$old_key] = $old_value;
                $dupes[$key]     = $value;
            }
            $old_value = $value;
            $old_key   = $key;
        }
        return $dupes;
    }
}

if (!function_exists('implodeRepeatedPrams')) {
    function implodeRepeatedPrams(array $raw_array): string
    {
        return str_replace('}', "", str_replace('/{', "", implode(' , ', array_unique(getRepeatedElements($raw_array)))));
    }
}


if (!function_exists('app')) {
    function app(): Application
    {
        static $instance = null;
        if (!$instance) {
          
            $instance = new Application;
        }
        return $instance;
    }
}


if (!function_exists('env')) {
    function env($key, $default = null)
    {
        return $_ENV[$key] ?? $default;
    }
}



if(! function_exists('class_basename')){
    function class_basename(string $namespace){
        $namespace = str_replace('\\','/',$namespace);
        $basename = strtolower(basename($namespace));
        return Inflect::pluralize($basename);
    }
}