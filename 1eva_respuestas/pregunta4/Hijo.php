<?php

class Hijo extends Padre
{
    private $privateName;

    public function crear($privateName)
    {
        return $this->privateName = $privateName;
    }

    public function leer() {
        return $this->privateName;

    }
}
