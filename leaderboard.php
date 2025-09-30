<?php include 'stlayouts/header.php'; ?>
<?php include 'config.php'; ?>

<?php
// Get top 3 students
$top3 = $conn->query("SELECT * FROM students ORDER BY gpa DESC LIMIT 3");
$leaders = [];
while($row = $top3->fetch_assoc()){
    $leaders[] = $row;
}

// Get all students sorted by GPA
$all_students = $conn->query("SELECT * FROM students ORDER BY gpa DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Leaderboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            padding: 20px;
        }

        .leaderboard {
            display: flex;
            justify-content: center;
            align-items: flex-end;
            gap: 20px;
            margin-bottom: 40px;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            text-align: center;
            width: 200px;
        }

        .first { 
            margin-bottom: 20px; /* makes it appear higher */
            border: 2px solid gold;
        }
        .second { border: 2px solid silver; }
        .third { border: 2px solid #cd7f32; } /* bronze */

        .card h3 {
            margin: 10px 0;
            font-size: 20px;
            color: #333;
        }
        .card p {
            margin: 5px 0;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        table th, table td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: center;
        }

        table th {
            background: #2980b9;
            color: white;
        }
    </style>
</head>
<body>

<h2 style="text-align:center; margin-bottom:30px;">Student GPA Leaderboard</h2>

<!-- Top 3 cards -->
<div class="leaderboard">
    <?php if(isset($leaders[1])): ?>
        <div class="card second">
            <h3><?php echo $leaders[1]['name']; ?></h3>
            <p>GPA: <?php echo $leaders[1]['gpa']; ?></p>
            <p>2nd Place</p>
        </div>
    <?php endif; ?>

    <?php if(isset($leaders[0])): ?>
        <div class="card first">
            <h3><?php echo $leaders[0]['name']; ?></h3>
            <p>GPA: <?php echo $leaders[0]['gpa']; ?></p>
            <p>1st Place</p>
        </div>
    <?php endif; ?>

    <?php if(isset($leaders[2])): ?>
        <div class="card third">
            <h3><?php echo $leaders[2]['name']; ?></h3>
            <p>GPA: <?php echo $leaders[2]['gpa']; ?></p>
            <p>3rd Place</p>
        </div>
    <?php endif; ?>
</div>


<table>
    <tr>
        <th>S.NO</th>
        <th>Name</th>
        <th>GPA</th>
    </tr>
    <?php $sno = 1;
    while($student = $all_students->fetch_assoc()): ?>
        <tr>
           <td><?= $sno++ ?></td>
            <td><?php echo $student['name']; ?></td>
            <td><?php echo $student['gpa']; ?></td>
        </tr>
    <?php endwhile; ?>
</table>

</body>
</html>

<?php include 'stlayouts/footer.php'; ?>
