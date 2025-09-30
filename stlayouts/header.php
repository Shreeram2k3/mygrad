<?php
session_start();

if (!isset($_SESSION['student_id']) ) {
    header("Location: index.php");
    exit;
}

// Student page here
$name = $_SESSION['student_name'];
$regno = $_SESSION['student_regno'];

$current_page = basename($_SERVER['PHP_SELF']); // get current file name
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Dashboard</title>
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
    padding: 10px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    z-index: 1000;
}
nav .logo {
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 600;
    font-size: 1.3rem;
    color: #2d3436;
    text-decoration: none;
}
nav .logo img {
    display: block;
    width: 30px;
    height: 30px;
}
nav .nav-links {
    display: flex;
    gap: 25px;
    align-items: center;
}
nav .nav-links a {
    text-decoration: none;
    color: #636e72;
    font-weight: 500;
    transition: color 0.3s ease, border-bottom 0.3s ease;
    padding-bottom: 2px;
}
nav .nav-links a:hover,
nav .nav-links a.active {
    color: #0984e3;
    border-bottom: 2px solid #0984e3;
}
nav .profile {
    position: relative;
    cursor: pointer;
    display: flex;
    align-items: center;
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
        <img src="assets/colorlogo.png" alt="">
        MyGrade
    </a>
    <div class="nav-links">
        <a href="dashboard.php" class="<?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>">Dashboard</a>
        <a href="gpa.php" class="<?php echo ($current_page == 'gpa.php') ? 'active' : ''; ?>">GPA</a>
        <a href="leaderboard.php" class="<?php echo ($current_page == 'leaderboard.php') ? 'active' : ''; ?>">Leaderboard</a>
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

<main style="margin-top:80px;">