<?php
include 'stlayouts/header.php';
include 'config.php';


$student_id = $_SESSION['student_id'];

// Fetch student data (name & GPA)
$stmt = mysqli_prepare($conn, "SELECT name, gpa FROM students WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $student_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $name, $gpa);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

$maxGPA = 10; 
$percentage = ($gpa / $maxGPA) * 100;


if ($gpa >= 8) {
    $ringColor = "#22c55e"; // green
} elseif ($gpa >= 5) {
    $ringColor = "#f97316"; // orange
} else {
    $ringColor = "#ef4444"; // red
}
?>

<style>
    .welcome-card {
        background-color: #ffffff;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 24px;
        border-radius: 16px;
        margin: 40px 40px 0 40px;
        
    }

    .welcome-card h1 {
        font-size: 1.875rem;
        font-weight: bold;
        color: #111827;
        margin-top: 20px;
        margin-bottom: 40px;
    }

    .welcome-card hr {
        border: none;
        border-top: 1px solid #e5e7eb;
        margin-bottom: 30px;
    }

    .gpa-ring {
        position: relative;
        width: 200px;
        height: 200px;
        margin: 0 auto;
    }

    .gpa-ring svg {
        transform: rotate(-90deg);
        width: 100%;
        height: 100%;
    }

    .gpa-ring circle {
        fill: none;
        stroke-width: 12;
        stroke-linecap: round;
    }

    .gpa-ring .bg {
        stroke: #e5e7eb; /* light gray */
    }

    .gpa-ring .progress {
        stroke: <?php echo $ringColor; ?>;
        stroke-dasharray: 565.48; /* circumference (2πr, r=90) */
        stroke-dashoffset: calc(565.48 - (565.48 * <?php echo $percentage; ?> / 100));
        transition: stroke-dashoffset 1s ease, stroke 0.5s ease;
    }

    .gpa-center {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
    }

    .gpa-center h2 {
        margin: 0;
        font-size: 2.2rem;
        font-weight: bold;
        color: #111827;
    }

    .gpa-center p {
        margin: 5px 0 0;
        font-size: 0.95rem;
        color: #6b7280;
    }
</style>

<div class="welcome-card">
    <h1>
        Welcome back, <?php echo htmlspecialchars($name); ?> <span>👋</span>
    </h1>
    <hr>

    <!-- GPA Ring -->
    <div class="gpa-ring">
        <svg>
            <!-- background circle -->
            <circle class="bg" cx="100" cy="100" r="90"></circle>
            <!-- progress circle -->
            <circle class="progress" cx="100" cy="100" r="90"></circle>
        </svg>

        <div class="gpa-center">
            <h2><?php echo number_format($gpa, 2); ?>/<?php echo $maxGPA; ?></h2>
            <p> Your Current GPA</p>
        </div>
    </div>
</div>

<?php include 'stlayouts/footer.php'; ?>
