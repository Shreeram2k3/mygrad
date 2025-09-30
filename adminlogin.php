<?php
session_start();
include 'config.php';
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

  
    $stmt = $conn->prepare("SELECT * FROM admin_users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_name'] = $admin['name'];
        header("Location: admindashboard.php");
        exit;
    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login</title>
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

body {
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(135deg, #2980b9, #6dd5fa);
}

.login-container {
    background: #ffffff;
    padding: 40px 30px;
    border-radius: 12px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.2);
    width: 350px;
    text-align: center;
}

.login-container h2 {
    color: #2c3e50;
    margin-bottom: 25px;
    font-size: 1.8rem;
    font-weight: 600;
}

.login-container form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.login-container label {
    text-align: left;
    font-weight: 500;
    color: #34495e;
    font-size: 0.95rem;
}

.login-container input {
    padding: 12px 10px;
    border: 1px solid #bdc3c7;
    border-radius: 8px;
    outline: none;
    font-size: 1rem;
    transition: border 0.3s ease, box-shadow 0.3s ease;
}

.login-container input:focus {
    border-color: #2980b9;
    box-shadow: 0 0 5px rgba(41, 128, 185, 0.4);
}

.login-container button {
    padding: 12px;
    border: none;
    border-radius: 8px;
    background: #2980b9;
    color: #fff;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.3s ease;
}

.login-container button:hover {
    background: #3498db;
}

.error-message {
    background: #ffdddd;
    color: #c0392b;
    padding: 10px 12px;
    border-radius: 6px;
    font-size: 0.95rem;
    margin-bottom: 10px;
    border: 1px solid #e74c3c;
}
</style>
</head>
<body>

<div class="login-container">
    <h2>Admin Login</h2>
    <?php if(!empty($error)) : ?>
        <div class="error-message"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="POST" action="adminlogin.php">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" required>

        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>

        <button type="submit">Login</button>
    </form>
</div>

</body>
</html>
