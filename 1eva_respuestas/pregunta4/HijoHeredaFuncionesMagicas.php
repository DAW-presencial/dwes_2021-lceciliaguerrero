<?php

class HijoHeredaFuncionesMagicas extends Padre
{
    private $privateName;

    public function crear($privateName)
    {
        return $this->privateName = $privateName;
    }

    public function leer() {
        return $this->privateName;
    }

    public function __set(string $name, $value): void
    {
        parent::__set($name, $value);
    }

    public function __get(string $name)
    {
        parent::__get($name);
    }


}