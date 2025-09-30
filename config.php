<?php
$server = "localhost";
$username = "root";
$pass = "1234";
$dbname = "mygrad";

$conn = mysqli_connect($server, $username, $pass, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// echo "Connected successfully!";
?>
