<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de un Nuevo Usuario</title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
</head>
<body>
<?php
/**
 * Formulario registro de usuario
 * @author Laura Cecilia Guerrero <lcecilia@cifpfbmoll.eu>
 */
/**
 * Genero las variables junto con la matriz de errores
 */
$nameUser = "";
$yearsUser = "";
$emailUser = "";
$errorsArray = array(); //o $errorsArray = [];

if (isset($_GET['enviarDatos'])) {
    $nameUser = filter_input(INPUT_GET, 'name', FILTER_CALLBACK, array('options' => 'validateNameUser'));
    $yearsUser = filter_input(INPUT_GET, 'year', FILTER_CALLBACK, array('options' => 'validateYearsUser'));
    $emailUser = filter_input(INPUT_GET, 'email', FILTER_VALIDATE_EMAIL, array('options' => 'validateEmailUser'));
    if (!count($errorsArray)) {
        echo "Validación superada- Los datos introducidos son: $nameUser, $yearsUser y $emailUser";
    } else {
        echo "Validación Fallida: ";
        createFormValidateUser($errorsArray);
    }
} else {
    createFormValidateUser($errorsArray);
}

/**
 * Valido el correo electrónico
 * @return string
 */
function validateEmailUser() {
    global $errorsArray;
    global $emailUser;
    if (!($emailUser === true) && is_null($emailUser)) {
        $errorsArray[] .= "Error email: por favor introduzca el correo electrónico correctamente.";

    }
    return '';
}

/**
 * Valido el nombre
 * @param string $validateName
 * @return mixed|string
 */
function validateNameUser($validateName = "") {
    global $errorsArray;
    $valName = trim($validateName);

    if (is_string($valName) && (strlen($valName) > 2)) {
        return $validateName;
    }
    $errorsArray[] .= "Error nombre: debe tener al menos 2 caracteres alfanuméricos.";
    return '';
}

/**
 * Valido la edad
 * @param $validateYears
 * @return mixed|string
 */
function validateYearsUser($validateYears) {
    global $errorsArray;
    $valYears = trim($validateYears);
    if (is_numeric($valYears) && ($valYears >= 1 && $valYears <= 90)) {
        return $validateYears;
    }
    $errorsArray[] .= "Error edad: debe estar en el rango 1 a 90 años";
    return '';
}

/**
 * Cuento los errores y posteriormente los imprimo
 * @param $varErrorsArray
 */
function createFormValidateUser($varErrorsArray) {
    if (count($varErrorsArray)) {
        foreach ($varErrorsArray as $varError) {
            echo "<br/>$varError";
        }
        echo "<br/>Codificación JSON: " . json_encode($varErrorsArray);
    }
}
?>
<h1>Registro de usuario</h1>
<form method="get">
    <label for="nameUser">
        Escriba su nombre:
        <input id="nameUser" type="text" name="name"
               placeholder="escribe el nombre del usuario" value="<?php echo $nameUser; ?>"/>
    </label><br>
    <label for="yearsUser">
        Escriba su edad:
        <input id="yearsUser" type="text" name="year"
               placeholder="escribe la edad del usuario" value="<?php echo $yearsUser; ?>"/>
    </label><br>
    <label for="emailUser">
        Escriba su correo electrónico:
        <input id="emailUser" type="text" name="email"
               placeholder="escribe el correo electrónico del usuario" value="<?php echo $emailUser; ?>"/>
    </label>
    <input type="submit" name="enviarDatos" value="envíe sus datos"/>
</form>
</body>
</html>
