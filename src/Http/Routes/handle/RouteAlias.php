<?php

namespace Src\Http\Routes\handle;

use Src\Http\Routes\Route;

class RouteAlias
{
    private $route = '';

    public function __construct(string $as, array $prams = [])
    {
        $this->route = $this->routeHandle($as, $prams);
    }

    public function get(): string
    {
        return $this->route;
    }

    private  function getRoute(string $as)
    {

        foreach (Route::routes() as $method => $routes) {
            foreach ($routes as $url => $attr) {
                if (($attr['as'] ?? null) == $as) {
                    return $url;
                }
            }
        }
        return false;
    }

    private function routeHandle(string $as, array $prams = []): string
    {
        $route = $this->getRoute($as);
        if ($route == false) {
            throw new \Exception('this Route is Not Exists');
        }

        return  $this->routeNewFormat($route, $prams);
    }

    private function routeNewFormat(string $route, array $prams): string
    {
        $url = $route;
        if (array_is_list($prams)) {
            foreach ($prams as $key => $value) {
                $url =  preg_replace("/{\w+}/", $value, $url, 1);
            }
        } else {
            preg_match_all("/{\w+}/", $url, $matches);
            foreach ($prams as $key => $value) {
                if (is_int(array_search("{{$key}}", $matches[0]))) {
                    $url = str_replace("{{$key}}", $value, $url);
                }
            }
        }
        $this->missRequiredPrameters($url);
        return $url;
    }

    private function missRequiredPrameters(string $url): bool
    {
        $miss =  preg_match_all("/{\w+}/", $url, $matches);
        if ($miss) {
            throw new \Exception("Missing Required Prameters in this Route [ " . implode(" , ", $matches[0]) . " ]");
        }
        return true;
    }
}
