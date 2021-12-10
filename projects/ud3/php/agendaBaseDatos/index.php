<?php
require_once 'config/Database.php';
require_once 'clases/Contact.php';
$titulo = "Index";
$pagina = isset($_GET['page']) ? $_GET['page'] : 1;
$registrosPagina = 5;
//Calcular para la cláusula de límite de consulta
$limiteConsulaPagina = ($registrosPagina * $pagina) - $registrosPagina;

$db = Database::getConnection();
$contacto = new Contact($db);


(string)$nombre = filter_input(INPUT_POST, 'nameForm', FILTER_CALLBACK, array('options' => 'validateNombre'));
$correo = filter_input(INPUT_POST, 'emailForm', FILTER_VALIDATE_EMAIL, array('options' => 'validateEmail'));
(string)$telefono = filter_input(INPUT_POST, 'telephoneForm', FILTER_CALLBACK, array('options' => 'validateTelf'));


function validateNombre(string $name)
{
    if (is_string(trim($name)) && (strlen(trim($name)) > 2)) {
        return $name;
    }
    return false;
}

function validateEmail(mixed $email)
{
    if (!($email === false) && !is_null($email)) {
        return $email;
    }
    return false;
}

function validateTelf(string $telf)
{
    if ((strlen(trim($telf)) <= 11)) {
        return $telf;
    }
    return false;
}

include_once 'layout_head.php';
include_once 'contacto.php';
if (isset($_POST['createUpdateForm'])) {
    global $nombre;
    global $correo;
    global $telefono;
    $contacto->create($nombre, $correo, $telefono);
} elseif (isset($_POST['deleteForm'])) {
    global $nombre;
    global $correo;
    global $telefono;
    $contacto->destroy($nombre, $correo, $telefono);
}
/*$myList = $contacto->list($limiteConsulaPagina, $registrosPagina);*/
$myList = $contacto->listComplete();
$lista = $myList;
include_once 'listaContactos.php';
include_once 'layout_foot.php';