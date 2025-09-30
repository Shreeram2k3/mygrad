<!-- student login page  -->

<?php
session_start();
include 'config.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $regno = $_POST['regno'];
    $dob = $_POST['dob']; 

    // Prepare SQL
    $stmt = $conn->prepare("SELECT * FROM students WHERE reg_no = ? AND dob = ?");
    $stmt->bind_param("ss", $regno, $dob);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $student = $result->fetch_assoc();

        // Set session
        $_SESSION['student_id'] = $student['id'];
        $_SESSION['student_name'] = $student['name'];
        $_SESSION['student_regno'] = $student['reg_no'];

        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid registration number or date of birth.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Login</title>
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
    background-image: url("assets/eseccse.jpg");
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.login-container {
    background: rgba(255, 255, 255, 0.2); /* semi-transparent white */
    backdrop-filter: blur(15px); /* blur effect on background */
    -webkit-backdrop-filter: blur(15px); /* for Safari */
    padding: 40px 30px;
    border-radius: 20px;
    box-shadow: 0 15px 25px rgba(0,0,0,0.3);
    width: 100%;
    max-width: 400px;
    border: 1px solid rgba(255, 255, 255, 0.3); /* subtle border */
}

.login-container h2 {
    text-align: center;
    margin-bottom: 30px;
    font-size: 2rem;
    color: #fff; /* text visible on blurred background */
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

.login-container input[type="text"],
.login-container input[type="date"] {
    width: 100%;
    padding: 12px 15px;
    margin-bottom: 20px;
    border: 1px solid rgba(255, 255, 255, 0.6);
    border-radius: 12px;
    outline: none;
    background: rgba(255, 255, 255, 0.3);
    color: #fff;
    transition: all 0.3s ease;
}

.login-container input[type="text"]::placeholder,
.login-container input[type="date"]::placeholder {
    color: rgba(255,255,255,0.7);
}

.login-container input[type="text"]:focus,
.login-container input[type="date"]:focus {
    border-color: #667eea;
    box-shadow: 0 0 8px rgba(102,126,234,0.5);
    background: rgba(255, 255, 255, 0.4);
}

.login-container button {
    width: 100%;
    padding: 12px;
    border: none;
    border-radius: 12px;
    background: #667eea;
    color: #fff;
    font-size: 1rem;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.3s ease;
}

.login-container button:hover {
    background: #764ba2;
}

.error {
    color: #ff6b6b;
    text-align: center;
    margin-bottom: 15px;
    font-weight: bold;
}

</style>
</head>
<body>

<div class="login-container">
    <h2>Student Login</h2>

    <?php if ($error): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST" action="index.php">
        <input type="text" name="regno" placeholder="Register Number" required>
        <input type="date" name="dob" required>
        <button type="submit">Login</button>
    </form>
</div>

</body>
</html>
