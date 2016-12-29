<?php namespace VKBot;

abstract class Command
{
    public $name = '';
    public $aliases = [];

    abstract public function execute($message);

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function setAliases($aliases)
    {
        if (is_array($aliases)) {
            $this->aliases = $aliases;
        } else {
            $this->aliases[] = $aliases;
        }
        return $this;
    }
}