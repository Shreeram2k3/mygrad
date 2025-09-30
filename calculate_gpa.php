<?php
include 'config.php'; 
session_start();


if (!isset($_SESSION['student_id'])) {
    die("Error: You must be logged in to perform this action.");
}

$student_id = $_SESSION['student_id'];


if (
    !isset($_POST['course_code'], $_POST['grade_point'], $_POST['credits']) ||
    !is_array($_POST['course_code']) ||
    !is_array($_POST['grade_point']) ||
    !is_array($_POST['credits'])
) {
    die("Error: Invalid form submission.");
}

$course_codes = $_POST['course_code'];
$grade_points = $_POST['grade_point'];
$credits      = $_POST['credits'];

$total_points  = 0;
$total_credits = 0;

$del = mysqli_prepare($conn, "DELETE FROM results WHERE student_id = ?");
if ($del) {
    mysqli_stmt_bind_param($del, "i", $student_id);
    mysqli_stmt_execute($del);
    mysqli_stmt_close($del);
}


foreach ($course_codes as $index => $code) {
    $code = trim($code);
    $current_point   = (int) $grade_points[$index];
    $current_credits = (int) $credits[$index];

    
    if ($current_point < 0 || $current_point > 10) continue;
    if ($current_credits < 1 || $current_credits > 5) continue;

    
    $total_points  += $current_point * $current_credits;
    $total_credits += $current_credits;

    
    $stmt = mysqli_prepare(
        $conn,
        "INSERT INTO results (student_id, course_code, grade_point, credits) VALUES (?, ?, ?, ?)"
    );
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "isii", $student_id, $code, $current_point, $current_credits);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    } else {
        die("Database error: " . mysqli_error($conn));
    }
}

// --- GPA CALCULATION ---
$gpa = ($total_credits > 0) ? ($total_points / $total_credits) : 0;

// --- UPDATE GPA IN STUDENTS TABLE ---
$stmt = mysqli_prepare($conn, "UPDATE students SET gpa = ? WHERE id = ?");
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "di", $gpa, $student_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
} else {
    die("Database error: " . mysqli_error($conn));
}

// --- REDIRECT  ---
header("Location: gpa.php?status=success&gpa=" . round($gpa, 2));
exit();
?>
