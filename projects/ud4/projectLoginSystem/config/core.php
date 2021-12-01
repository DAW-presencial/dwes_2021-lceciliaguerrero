<?php
error_reporting(E_ALL);
session_start();
date_default_timezone_set('Europe/Madrid');
$applicationUrl = 'http://lcecilia.php.github.public.local/projects/ud4/projectLoginSystem/';
$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
$registrosPagina = 5;
//Calcular para la cláusula de límite de consulta
$limiteConsulaPagina = ($registrosPagina * $pagina) - $registrosPagina;
