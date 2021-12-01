<?php
include_once "config/core.php";
$page_title = "Index";
$require_login = true;
include_once ("login_checker.php");
include_once ("layout_head.php");
echo "<div class='col-md-12'>";
$action = isset($_GET['action']) ? $_GET['action'] : "";
if ($action == 'login_success') {
    echo "<div class='alert alert-info'>";
    echo "<strong>Hi " . $_SESSION['name'] . ", welcome back!</strong>";
    echo "</div>";
} else if ($action == 'already_logged_in') {
    echo "<div class='alert alert-info'>";
    echo "<strong>You are already logged in.</strong>";
    echo "</div>";
}
echo "<div class='alert alert-info'>";
echo "Content when logged in will be here. For example, your premium products or services.";
echo "</div>";
echo "</div>";
include_once("layout_foot.php");
