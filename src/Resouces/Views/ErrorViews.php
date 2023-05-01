<?php
namespace Src\Resouces\Views;

class ErrorViews
{

    public static function getView(int $status)
    {
        ob_start();
        include_once resource_path("errors" . ds() . $status . ".blade.php");
        return ob_get_clean();
    }
}
