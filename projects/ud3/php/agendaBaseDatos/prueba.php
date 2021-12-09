<?php
require_once 'config/Database.php';
require_once 'clases/Contact.php';

$db = Database::getConnection();

/*'prueba', 'prueba@cifpfbmoll.eu', '111 111 114'*/
$contacto = new Contact($db);


$contacto->create('prueba2', 'prueba2@cifpfbmoll.eu', '111 111 115');
echo $contacto->index();
$lista = array();
/*var_dump($contacto->list(0, 2));*/
/*foreach ( as $item) {
    echo "<p> id: '" . $item['id'] . "' name: '" . $item['name'] . "' email: '" . $item['email'] . "' telf: '" . $item['telephone_number'] . "'.</p>";
}*/


/*foreach ($stmtQuery as $item)*/
/*$value $value*/