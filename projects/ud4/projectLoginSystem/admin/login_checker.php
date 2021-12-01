<?php
if (empty($_SESSION['logged_in'])) {
    header("Location: {$applicationUrl}login.php?action=not_yet_logged_in");
} else if ($_SESSION['access_level'] != "Admin") {
    header("Location: {$applicationUrl}login.php?action=not_admin");
} else {
}
