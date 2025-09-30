<?php
session_start();


if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit;
}

// Use safe defaults if not set
$name = $_SESSION['student_name'] ?? 'Guest';
$regno = $_SESSION['student_regno'] ?? 'N/A';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h2>Welcome, <?php echo htmlspecialchars($name ?? ''); ?>!</h2>
    <p>Your Register Number: <?php echo htmlspecialchars($regno ?? ''); ?></p>

    <a href="logout.php">Logout</a>
</body>
</html>
