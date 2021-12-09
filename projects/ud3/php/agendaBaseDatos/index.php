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
    if ((strlen(trim($telf)) === 9)) {
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
$myList = $contacto->list($limiteConsulaPagina, $registrosPagina);
$lista = $myList;

$cuanto = 0;
$output = "";
$tablaIni = "<table>";
$tablaHead = "<thead><tr><th>Id</th><th>Nombre</th><th>Correo Electrónico</th><th>Numero de Teléfono</th></tr></thead>";
$tablaBodyIni = "<tbody>";
$medio = "";
foreach ($lista as $row) {
    $medio .= "<tr>" . "<th>" . $row['id'] . "</th>" . "<th>" . $row['name'] . "</th>" . "<th>" . $row['email'] . "</th>" . "<th>" . $row['telephone_number'] . "</th>" . "</tr>";
    $cuanto++;
}
$tablaBodyFin = "</tbody>";
$tablaFoot = "<tfoot><tr><th colspan='3'>Total</th><th>$cuanto</th></tr></tfoot>";
$tablaFin = "</table>";
$output .= $tablaIni . $tablaHead . $tablaBodyIni . $medio . $tablaBodyFin . $tablaFoot . $tablaFin;
echo "<section>" . $output . "</section>";

/*include_once 'listaContactos.php';*/