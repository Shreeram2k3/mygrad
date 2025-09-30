<?php

session_start();
include 'config.php';
if (!isset($_SESSION['admin_id']) || !isset($_SESSION['admin_name'])) {
    header("Location: adminlogin.php");
    exit;
}

$name =  $_SESSION['admin_name'] ?? 'Guest';

$success="";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reg_no = $_POST['reg'];
    $name   = $_POST['name'];
    $dob    = $_POST['dob'];

    // Insert query
    $stmt = $conn->prepare("INSERT INTO students (reg_no, name, dob) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $reg_no, $name, $dob);

    if ($stmt->execute()) {
        $success="Student added successfully!";
    } else {
        $error="please enter valid details";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}
body {
    background: #f8f9fa;
}
nav {
    position: fixed;
    top: 0;
    width: 100%;
    background: #ffffff;
    padding: 10px 30px; /* slightly smaller padding for better vertical alignment */
    display: flex;
    justify-content: space-between;
    align-items: center; /* ensures all items are vertically centered */
    box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    z-index: 1000;
}

nav .logo {
    display: flex;
    align-items: center; /* vertically centers img and text */
    gap: 10px; /* space between logo image and text */
    font-weight: 600;
    font-size: 1.3rem;
    color: #2d3436;
    text-decoration: none;
}

nav .logo img {
    display: block; /* ensures no extra space under image */
    width: 30px;
    height: 30px;
}

nav .nav-links {
    display: flex;
    gap: 25px;
    align-items: center; /* vertically centers the links */
}

nav .nav-links a {
    text-decoration: none;
    color: #636e72;
    font-weight: 500;
    transition: color 0.3s ease;
}

nav .nav-links a:hover,
nav .nav-links a.active { /* active link styling */
    color: #0984e3;
}

nav .profile {
    position: relative;
    cursor: pointer;
    display: flex;
    align-items: center; /* vertically centers the circle */
}

nav .profile-circle {
    width: 40px;
    height: 40px;
    background: #dfe6e9;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #2d3436;
    font-weight: bold;
    font-size: 1rem;
}
.dropdown {
    position: absolute;
    top: 50px;
    right: 0;
    background: #ffffff;
    border: 1px solid #dcdde1;
    border-radius: 10px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    display: none;
    min-width: 160px;
    overflow: hidden;
}
.dropdown a, .dropdown button {
    display: block;
    width: 100%;
    text-align: left;
    padding: 10px 15px;
    text-decoration: none;
    color: #2d3436;
    font-size: 0.95rem;
    border: none;
    background: none;
    cursor: pointer;
}
.dropdown a:hover, .dropdown button:hover {
    background: #f1f2f6;
}


.logout {
    text-align: center;
    margin: 40px 0;
}
.logout a {
    text-decoration: none;
    background: #d63031;
    color: #fff;
    padding: 10px 25px;
    border-radius: 10px;
    font-weight: bold;
    transition: background 0.3s ease;
}
.logout a:hover {
    background: #e17055;
}
footer {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    background: #ffffff;
    border-top: 1px solid #dcdde1;
    padding: 10px 20px;
    text-align: right;
    font-size: 0.8rem;
    color: #636e72;
}
footer a {
    color: #0984e3;
    text-decoration: none;
}
footer a:hover {
    text-decoration: underline;
}
@media (max-width: 500px) {
    .container {
        grid-template-columns: 1fr;
    }
}

.form-container {
    width: 400px;
    margin: 90px auto; /* centers form */
    background: #fff;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.1);
}

.form-container h2 {
    margin-bottom: 10px;
    color: #2d3436;
    text-align: center;
}

.form-container hr {
    margin: 15px 0;
    border: 0;
    border-top: 1px solid #dfe6e9;
}

form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

form label {
    display: flex;
    flex-direction: column;
    font-weight: 500;
    color: #636e72;
    font-size: 0.9rem;
}

form input {
    margin-top: 5px;
    padding: 10px;
    border: 1px solid #dcdde1;
    border-radius: 8px;
    outline: none;
    transition: border 0.3s ease;
}

form input:focus {
    border: 1px solid #0984e3;
}

form button {
    padding: 12px;
    background: #0984e3;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: bold;
    cursor: pointer;

}

form button:hover {
    background: #74b9ff;
}

.messages {
   
    width: 400px;
    margin: 100px auto;
    text-align: center;
}

.success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
    padding: 12px;
    border-radius: 8px;
    margin-bottom: 15px;
    font-size: 0.95rem;
    font-weight: 500;
}

.error {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
    padding: 12px;
    border-radius: 8px;
    margin-bottom: 15px;
    font-size: 0.95rem;
    font-weight: 500;
}

</style>
<script>
function toggleDropdown() {
    const dropdown = document.getElementById('profileDropdown');
    dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
}
document.addEventListener('click', function(event){
    const dropdown = document.getElementById('profileDropdown');
    const profile = document.getElementById('profileBtn');
    if (!profile.contains(event.target) && !dropdown.contains(event.target)) {
        dropdown.style.display = 'none';
    }
});
</script>
</head>
<body>

<nav>
    <a href="#" class="logo">
        <img src="assets/colorlogo.png" style="height: 30px; width:30px" alt="">
    MyGrade</a>
    <div class="nav-links">
        <a href="http://localhost/mygrad/admindashboard.php">Admin Dashboard</a>
        <a href="#"></a>
        <a href="http://localhost/mygrad/manage_students.php">Manage students</a>
    </div>
    <div class="profile" id="profileBtn" onclick="toggleDropdown()">
        <div class="profile-circle"><?php echo strtoupper(substr($name ?? '?',0,1)); ?></div>
        <div class="dropdown" id="profileDropdown">
            <a href="#">Profile</a>
            <form method="POST" action="logout.php">
                <button type="submit">Logout</button>
            </form>
        </div>
    </div>
</nav>
<div class="messages" id="messages">
    <?php if ($success): ?>
        <p class="success"><?php echo $success; ?></p>
    <?php endif; ?>

    <?php if ($error): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>
</div>

    <div class="form-container">
      <h2>Add Student</h2>
      <hr>
        <form action="manage_students.php" method="POST">
          <label>
            <span>Register Number</span>
            <input type="text" name="reg" required>
          </label>

          <label>
            <span>Name</span>
            <input type="text" name="name" required>
          </label>

          <label>
            <span>Date of Birth</span>
            <input type="date" name="dob" required>
          </label>

          <button type="submit">Add Student</button>
        </form>
    </div>



<script>
  setTimeout(() => {
      const msgBox = document.getElementById('messages');
      if (msgBox) msgBox.style.display = "none";
  }, 4000);
</script>

</body>
</html>