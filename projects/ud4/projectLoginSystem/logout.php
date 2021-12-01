<?php
include_once("config/core.php");
session_destroy();
header("Location: {$applicationUrl}login.php");

