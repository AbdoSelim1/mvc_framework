<?php

namespace Src\Resouces\Views;

use Src\Resouces\Views\ViewHandle\ContentHandle;


class View
{
    use ContentHandle;

    protected $contentView = '';

    public function extends(string $view)
    {
        return $this->getContentView($view);
    }

    public function openView(string $view, array $data)
    {
        $vars = $this->getViewForOpen($view, $data)->getDirctives()->handleDirctives()
        ->dirctiveAlreadyExists()
        ->getSectionsVars()
        ->handleSectionsVars();
        return $this->replacementContentView($vars);
    }

    private function getContentView(string $view)
    {
        ob_start();
        require view_path($view);
        return  ob_get_clean();
    }


    public function getViewForOpen(string $view, array $data)
    {
        ob_start();
        foreach ($data as $var => $value) {
            $$var = $value;
        }
        require_once view_path($view);
        $this->contentView =  ob_get_clean();
        return $this;
    }
}
