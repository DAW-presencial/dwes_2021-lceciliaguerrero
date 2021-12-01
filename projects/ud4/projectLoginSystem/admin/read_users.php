<?php
include_once "config/core.php";
include_once "login_checker.php";
include_once 'config/database.php';
include_once '../objects/user.php';
$database = new database();
$db = $database->getConnectionDataBase();
$user = new User($db);
$page_title = "Users";
include_once "layout_head.php";
echo "<div class='col-md-12'>";
$stmt = $user->readAll($limiteConsulaPagina, $registrosPagina);
$num = $stmt->rowCount();
$page_url="read_users.php?";
include_once "read_users_template.php";
echo "</div>";
include_once "layout_foot.php";
?>
