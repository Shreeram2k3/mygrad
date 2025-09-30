<?php

session_start();

if (!isset($_SESSION['admin_id']) || !isset($_SESSION['admin_name'])) {
    header("Location: index.php");
    exit;
}

// Admin content here


?>