<?php

namespace Src\Resouces\Views\ViewHandle;

trait ContentHandle
{
    protected $dirctives = [];
    protected $variables = [];
    protected $dirctivesReletedVars = [];
    protected $sectionVars = [];


    protected function getDirctives()
    {
        preg_match_all("/@yield\('\w+'\)|@yield\(\"\w+\"\)/", $this->contentView, $matches);
        $this->dirctives = $matches[0] ?? [];
        return $this;
    }

    protected function handleDirctives()
    {
        foreach ($this->dirctives as $dirctive) {
            $var = substr(rtrim($dirctive, "'\")"), 8);
            $this->variables[] =  $var;
            $this->dirctivesReletedVars[$var] = $dirctive;
        }
        return $this;
    }

    protected function dirctiveAlreadyExists()
    {
        if (!(count(array_unique($this->dirctives)) == count($this->dirctives))) {
            throw new \Exception('Variables must be unique and not duplicated , cannot reference variable name "'
                . implode(' , ', array_unique(getRepeatedElements($this->variables))) . '" more than once.');
        }
        return $this;
    }

    protected function getSectionsVars()
    {
        preg_match_all("/@section\('\w+'\)((.|\r\n)*?)@endsection|@section.*/", $this->contentView, $matches);
        $this->sectionVars =  $matches;
        return $this;
    }

    protected  function handleSectionsVars()
    {
        $varsWithValues = [];
        foreach ($this->sectionVars[0] as $index => $var) {
            preg_match("/\('\w+/", $var, $matchesVar);
            $newVar = substr(($matchesVar[0] ?? "@@@@"), 2);

            if ($this->sectionVars[1][$index] == "") {
                preg_match("/\,.*/", $var, $matchesValue);
                $value = ltrim(rtrim(($matchesValue[0] ?? ''), "\"')\r"), ",");
                $varsWithValues[$newVar] = [$this->sectionVars[0][$index], substr($value, strpos($value, "'") + 1)];
            } else {
                $varsWithValues[$newVar] = [$this->sectionVars[0][$index], $this->sectionVars[1][$index]];
            }
        }
        return $varsWithValues;
    }

    protected function replacementContentView(array $varsWithValues)
    {
        foreach ($varsWithValues as $var => $value) {
            if (array_key_exists($var, $this->dirctivesReletedVars)) {
                $this->contentView = str_replace($this->dirctivesReletedVars[$var], $value[1], $this->contentView);
                $this->contentView = str_replace($value[0], "", $this->contentView);
            }
        }

        foreach ($this->dirctives as $yelid) {
            $this->contentView = str_replace($yelid, "", $this->contentView);
        }
        return $this->contentView;
    }
}
