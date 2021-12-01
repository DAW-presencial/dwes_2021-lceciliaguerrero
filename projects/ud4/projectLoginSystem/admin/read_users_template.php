<?php
if ($num > 0) {
    echo "<table class='table table-hover table-responsive table-bordered'>";
    echo "<tr>";
    echo "<th>name</th>";
    echo "<th>Email</th>";
    echo "<th>Access Level</th>";
    echo "</tr>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        echo "<tr>";
        echo "<td>{$name}</td>";
        echo "<td>{$email}</td>";
        echo "<td>{$accessLevel}</td>";
        echo "</tr>";
    }
    echo "</table>";
    $page_url = "read_users.php?";
    $total_rows = $user->countAll();
    include_once 'paging.php';
} else {
    echo "<div class='alert alert-danger'>
        <strong>No users found.</strong>
    </div>";
}