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


$nombre = filter_input(INPUT_POST, 'nameForm');
$correo = filter_input(INPUT_POST, 'emailForm');
$telefono = filter_input(INPUT_POST, 'telephoneForm');


/**
 * Valido nombre.
 * @param string $name
 * @return bool
 */
function validateNombre(string $name): bool
{
    if (is_string(trim($name)) && (strlen(trim($name)) <= 30)) {
        return true;
    }
    return false;
}

/**
 * Valido correo electrónico.
 * @param $email
 * @return bool
 */
function validateEmail($email): bool
{
    $countArroba = 0;
    $countPunto = 0;
    for ($i = strripos(trim($email), "@"); $i < strlen(trim($email)); $i++) {
        if (substr(trim($email), $i) === "@") {
            $countArroba++;
        }
    }

    for ($i = strripos(trim($email), "."); $i < strlen(trim($email)); $i++) {
        if (substr(trim($email), $i) === ".") {
           $countPunto++;
        }
    }

    $punto = ".";
    $arroba = "@";
    $nullCorreo = boolval(trim($email) !== "");
    $arrobaCorreo = boolval($countArroba !== 1);
    $puntoCorreo = boolval($countPunto !== 1);
    $arrobaPuntoCorreo = boolval(substr(trim($email), strripos(trim($email), $punto)) < substr(trim($email), strripos(trim($email), $arroba)));
    $primeraParteLetraMinus = boolval(substr(trim($email), 1, strripos(trim($email), substr(trim($email), strripos(trim($email), $arroba)))) !== strtolower(substr(trim($email), 1, strripos(trim($email), substr(trim($email), strripos(trim($email), $arroba))))));
    $segundaParteLong = boolval((strlen(substr(trim($email), strripos(trim($email), substr(trim($email), strripos(trim($email), $arroba))), strripos(trim($email), substr(trim($email), strripos(trim($email), $punto))))) >= 4) && (strlen(substr(trim($email), strripos(trim($email), substr(trim($email), strripos(trim($email), $arroba))), strripos(trim($email), substr(trim($email), strripos(trim($email), $punto))))) <= 12));
    $segundaParteLetraMinus = boolval(substr(trim($email), strripos(trim($email), substr(trim($email), strripos(trim($email), $arroba))), strripos(trim($email), substr(trim($email), strripos(trim($email), $punto)))) !== strtolower(substr(trim($email), strripos(trim($email), substr(trim($email), strripos(trim($email), $arroba))), strripos(trim($email), substr(trim($email), strripos(trim($email), $punto))))));
    $terceraParteMinus = boolval(substr(trim($email), strripos(trim($email), substr(trim($email), strripos(trim($email), $punto))), strlen(trim($email))) !== strtolower(substr(trim($email), strripos(trim($email), substr(trim($email), strripos(trim($email), $punto))), strlen(trim($email)))));
    $terceraParteLong = boolval((strlen(substr(trim($email), strripos(trim($email), substr(trim($email), strripos(trim($email), $punto))), strlen(trim($email)))) >= 2) && (strlen(substr(trim($email), strripos(trim($email), substr(trim($email), strripos(trim($email), $punto))), strlen(trim($email)))) <= 4));

    if (($nullCorreo === false) && ($arrobaCorreo === true) && ($puntoCorreo === true) && ($arrobaPuntoCorreo === true)
        && ($primeraParteLetraMinus === true) && ($segundaParteLong === true) && ($segundaParteLetraMinus === true)
        && ($terceraParteMinus === true) && ($terceraParteLong === true)) {
        return true;
    }
    return false;
}

/**
 * Valido numero de teléfono.
 * @param string $telf
 * @return bool
 */
function validateTelf(string $telf): bool
{
    if (is_string(trim($telf)) && (strlen(trim($telf)) <= 11)) {
        return true;
    }
    return false;
}

include_once 'layout_head.php';
include_once 'contacto.php';
if (isset($_POST['createUpdateForm'])) {
    global $nombre;
    global $correo;
    global $telefono;
    if (validateNombre($nombre) === true && validateEmail($correo) === true && validateTelf($telefono) === true) {
        $contacto->create($nombre, $correo, $telefono);
    } else {
        echo "Error, algún dato no ha sido puesto";
    }
} elseif (isset($_POST['deleteForm'])) {
    global $nombre;
    global $correo;
    global $telefono;
    if (validateNombre($nombre) === true && validateEmail($correo) === true && validateTelf($telefono) === true) {
        $contacto->destroy($nombre, $correo, $telefono);
    } else {
        echo "Error, algún dato no ha sido puesto";
    }
}
/*$myList = $contacto->list($limiteConsulaPagina, $registrosPagina);*/
$myList = $contacto->listComplete();
$lista = $myList;
include_once 'listaContactos.php';
include_once 'layout_foot.php';