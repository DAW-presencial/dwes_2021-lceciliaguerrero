<?php

if (isset($_SESSION['accessLevel']) && $_SESSION['accessLevel'] == 'Admin') {
    //si el nivel de acceso no era 'Admin', redirigirlo a la página de inicio de sesión
    header("Location: {$applicationUrl}admin/index.php?action=logged_in_as_admin");
} else if (isset($require_login) && $require_login == true) {
    //si se estableció $require_login y el valor es 'verdadero'
    if (!isset($_SESSION['accessLevel'])) {
        //si el usuario aún no ha iniciado sesión, redirigir a la página de inicio de sesión
        header("Location: {$applicationUrl}login.php?action=please_login");
    }
} else if (isset($page_title) && ($page_title == "Login" || $page_title == "Sign Up")) {
    // si era la página de 'iniciar sesión' o 'registrarse' o 'registrarse'
    if (isset($_SESSION['access_level']) && $_SESSION['access_level'] == "Customer") {
        //si el usuario aún no ha iniciado sesión, redirigir a la página de inicio de sesión
        header("Location: {$applicationUrl}index.php?action=already_logged_in");
    }
} else {

}
