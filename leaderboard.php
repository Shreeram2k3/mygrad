<?php include 'stlayouts/header.php'; ?>
<?php include 'config.php'; ?>

<?php
// Get top 3 students
$top3 = $conn->query("SELECT * FROM students ORDER BY gpa DESC LIMIT 3");
$leaders = [];
while($row = $top3->fetch_assoc()){
    $leaders[] = $row;
}

// Get all students sorted by GPA (limit to prevent memory issues)
$all_students = $conn->query("SELECT * FROM students ORDER BY gpa DESC LIMIT 100");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Leaderboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f9fafb, #eef2f7);
            margin: 0;
            color: #2d3436;
        }

        .container {
            padding: 20px 40px;
        }

        h2 {
            text-align: center;
            font-size: 32px;
            color: #111827;
            margin: 20px 0 50px;
            font-weight: 700;
            letter-spacing: 0.5px;
            position: relative;
        }

        h2 i {
            margin: 0 8px;
        }

        .leaderboard {
            display: flex;
            justify-content: center;
            gap: 25px;
            margin-bottom: 50px;
            flex-wrap: wrap;
        }

        .card {
            background: #ffffff;
            padding: 28px 20px;
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
            text-align: center;
            width: 230px;
            transition: all 0.35s ease;
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.25), transparent 70%);
            transform: rotate(25deg);
            opacity: 0;
            transition: opacity 0.4s;
        }

        .card:hover::before {
            opacity: 1;
        }

        .card:hover {
            transform: translateY(-12px) scale(1.03);
            box-shadow: 0 16px 32px rgba(0,0,0,0.15);
        }

        .first {
            border-top: 6px solid #FFD700;
            background: linear-gradient(145deg, #fffde7, #fff9c4);
        }
        .second {
            border-top: 6px solid #C0C0C0;
            background: linear-gradient(145deg, #f5f5f5, #e0e0e0);
        }
        .third {
            border-top: 6px solid #cd7f32;
            background: linear-gradient(145deg, #ffe0b2, #ffcc80);
        }

        .medal {
            font-size: 40px;
            margin-bottom: 14px;
        }

        .first .medal { color: #FFD700; text-shadow: 0 0 12px rgba(255,215,0,0.6); }
        .second .medal { color: #C0C0C0; text-shadow: 0 0 12px rgba(192,192,192,0.6); }
        .third .medal { color: #cd7f32; text-shadow: 0 0 12px rgba(205,127,50,0.6); }

        .card h3 {
            font-size: 19px;
            font-weight: 700;
            margin: 10px 0;
            color: #1f2937;
        }

        .card p {
            margin: 6px 0;
            font-size: 15px;
            color: #374151;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 6px 18px rgba(0,0,0,0.08);
        }

        table th, table td {
            padding: 14px;
            border-bottom: 1px solid #e5e7eb;
            text-align: center;
            font-size: 15px;
        }

        table th {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: #fff;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        table tr:nth-child(even) td {
            background: #f9fafb;
        }

        table tr:hover td {
            background: #eef2ff;
        }
    </style>
</head>
<body>
<div class="container">
    <h2><i class="fas fa-trophy" style="color:#FFD700;"></i> Student GPA Leaderboard </h2>

    <!-- Top 3 cards -->
    <div class="leaderboard">
        <?php if(isset($leaders[1])): ?>
            <div class="card second">
                <div class="medal"><i class="fas fa-medal"></i></div>
                <h3><?php echo $leaders[1]['name']; ?></h3>
                <p>GPA: <strong><?php echo $leaders[1]['gpa']; ?></strong></p>
                <p>2nd Place</p>
            </div>
        <?php endif; ?>

        <?php if(isset($leaders[0])): ?>
            <div class="card first">
                <div class="medal"><i class="fas fa-crown"></i></div>
                <h3><?php echo $leaders[0]['name']; ?></h3>
                <p>GPA: <strong><?php echo $leaders[0]['gpa']; ?></strong></p>
                <p>1st Place</p>
            </div>
        <?php endif; ?>

        <?php if(isset($leaders[2])): ?>
            <div class="card third">
                <div class="medal"><i class="fas fa-award"></i></div>
                <h3><?php echo $leaders[2]['name']; ?></h3>
                <p>GPA: <strong><?php echo $leaders[2]['gpa']; ?></strong></p>
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
</div>
</body>
</html>

<?php include 'stlayouts/footer.php'; ?>