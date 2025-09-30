<?php
session_start();
include 'config.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $regno = $_POST['regno'];
    $dob = $_POST['dob']; 

    // Prepare SQL
    $stmt = $conn->prepare("SELECT * FROM students WHERE regno = ? AND dob = ?");
    $stmt->bind_param("ss", $regno, $dob);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $student = $result->fetch_assoc();

        // Set session
        $_SESSION['student_id'] = $student['id'];
        $_SESSION['student_name'] = $student['name'];
        $_SESSION['student_regno'] = $student['regno'];

        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid registration number or date of birth.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Login</title>
</head>
<body>
    <h2>Login</h2>
    <?php if ($error): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Register Number:</label><br>
        <input type="text" name="regno" required><br><br>

        <label>Date of Birth:</label><br>
        <input type="date" name="dob" required><br><br>

        <button type="submit">Login</button>
    </form>
</body>
</html>
