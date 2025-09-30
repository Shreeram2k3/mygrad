<?php
session_start();
include 'config.php';

if (!isset($_SESSION['admin_id']) || !isset($_SESSION['admin_name'])) {
    header("Location: adminlogin.php");
    exit;
}

$name = $_SESSION['admin_name'] ?? 'Guest';

// Fetch total students
$total_students = 0;
$result = $conn->query("SELECT COUNT(*) as total FROM students");
if ($result) {
    $row = $result->fetch_assoc();
    $total_students = $row['total'];
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
    background: #f4f6f8;
}

nav {
    position: fixed;
    top: 0;
    width: 100%;
    background: #fff;
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
    transition: color 0.3s ease;
}
nav .nav-links a:hover,
nav .nav-links a.active {
    color: #0984e3;
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


.main-content {
    margin-top: 80px; 
    padding: 30px;
}

.welcome-card {
    background: #0984e3;
    color: #fff;
    padding: 25px 30px;
    border-radius: 15px;
    box-shadow: 0 10px 20px rgba(0,0,0,0.08);
    margin-bottom: 30px;
    font-size: 1.2rem;
    font-weight: 500;
}

.stats-card {
    background: #fff;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 10px 20px rgba(0,0,0,0.08);
    display: flex;
    align-items: center;
    justify-content: space-between;
    max-width: 400px;
    margin-bottom: 20px;
}
.stats-card .icon {
    font-size: 2.5rem;
    color: #0984e3;
}
.stats-card .details {
    text-align: right;
}
.stats-card .details .number {
    font-size: 2rem;
    font-weight: bold;
    color: #2d3436;
}
.stats-card .details .label {
    font-size: 0.95rem;
    color: #636e72;
    margin-top: 5px;
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
        <img src="assets/colorlogo.png" alt=""> MyGrade
    </a>
    <div class="nav-links">
        <a href="admindashboard.php" class="active">Admin Dashboard</a>
        <a href="manage_students.php">Manage Students</a>
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

<div class="main-content">

    <div class="welcome-card">
        Welcome Admin, <?php echo htmlspecialchars($name); ?>!
    </div>

    <div class="stats-card">
        <div class="icon">&#128100;</div> 
        <div class="details">
            <div class="number"><?php echo $total_students; ?></div>
            <div class="label">Total Students</div>
        </div>
    </div>
</div>

</body>
</html>
