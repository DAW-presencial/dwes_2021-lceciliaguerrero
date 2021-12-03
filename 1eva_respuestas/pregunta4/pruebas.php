<?php

include_once 'Padre.php';
include_once 'Hijo.php';
include_once 'HijoHeredaFuncionesMagicas.php';
$obj = new Hijo();
$obj->nuevo = 'hola';

$objM = new HijoHeredaFuncionesMagicas();
$objM->nuevo = 'hola';
var_dump($objM);
