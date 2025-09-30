<?php
session_start();

if (!isset($_SESSION['student_id']) ) {
    header("Location: index.php");
    exit;
}

// Student page here

// defaults if not set
$name = $_SESSION['student_name'] ?? 'Guest';
$regno = $_SESSION['student_regno'] ?? 'N/A';
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
        <a href="http://localhost/mygrad/dashboard.php">Dashboard</a>
        <a href="#">GPA</a>
        <a href="#">Leaderboard</a>
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





<footer>
    By <a href="https://www.linkedin.com/in/shreeram2k3/" target="_blank">Shreeram G</a> & <a href="https://www.linkedin.com/in/sathish-k-u-419593336/" target="_blank">Sathish KU</a>
</footer>

</body>
</html>
