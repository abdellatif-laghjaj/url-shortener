<?php
    $user = "root";
    $db_name = "urlshortener";
    $password = "";
    $conn = mysqli_connect("localhost", $user, $password, $db_name);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
?>