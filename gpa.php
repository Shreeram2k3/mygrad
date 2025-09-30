<?php include 'stlayouts/header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Minimal GPA Calculator</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');

    :root {
      --primary-color: #4a6cf7;
      --primary-hover: #3a56d4;
      --background-color: #f3f4f6;
      --card-background: #ffffff;
      --text-color: #111827;
      --muted-text: #6b7280;
      --border-color: #e5e7eb;
      --radius: 16px;
      --shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
      --transition: all 0.3s ease;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: var(--background-color);
      color: var(--text-color);
      margin: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      padding: 20px;
    }

    .form-card {
      width: 100%;
      max-width: 650px;
      background: var(--card-background);
      border-radius: var(--radius);
      padding: 50px;
      box-shadow: var(--shadow);
      animation: fadeIn 0.5s ease;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .form-header {
      text-align: center;
      margin-bottom: 40px;
    }
    .form-header h2 {
      font-weight: 600;
      margin-bottom: 8px;
      font-size: 1.8rem;
    }
    .form-header p {
      color: var(--muted-text);
      font-size: 0.95rem;
    }

    .result-card {
      background: #e0f7f4;
      
      padding: 15px 20px;
      margin-bottom: 20px;
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      animation: fadeIn 0.5s ease;
    }
    .result-card h3 {
      margin: 0;
      font-size: 1.2rem;
      color: var(--primary-color);
    }

    label {
      display: block;
      font-weight: 500;
      margin-bottom: 8px;
    }

    .form-control {
      width: 100%;
      padding: 14px 18px;
      border: 1px solid var(--border-color);
      border-radius: var(--radius);
      font-size: 1rem;
      margin-bottom: 24px;
      transition: var(--transition);
    }
    .form-control:focus {
      border-color: var(--primary-color);
      box-shadow: 0 0 0 3px rgba(74,108,247,0.2);
      outline: none;
    }

    .course-grid {
      display: grid;
      grid-template-columns: 1fr 1fr 1fr;
      gap: 20px;
      margin-bottom: 20px;
    }

    .btn {
      width: 100%;
      padding: 16px;
      border: none;
      border-radius: var(--radius);
      font-weight: 600;
      font-size: 1rem;
      cursor: pointer;
      transition: var(--transition);
    }
    .btn-primary {
      background: var(--primary-color);
      color: white;
    }
    .btn-primary:hover {
      background: var(--primary-hover);
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(74, 108, 247, 0.4);
    }

    .course-section {
      margin-top: 20px;
    }
    .course-title {
      font-weight: 500;
      margin-bottom: 10px;
      color: var(--muted-text);
    }
  </style>
</head>
<body>

  <div class="form-card">

    <?php if (isset($_GET['status']) && $_GET['status'] === 'success' && isset($_GET['gpa'])): ?>
      <div class="result-card">
        <h3>Your GPA: <?php echo htmlspecialchars($_GET['gpa']); ?></h3>
      </div>
    <?php endif; ?>

    <div class="form-header">
      <h2> Calculate Your GPA </h2>
      <p>Enter your course details and climb the leaderboard</p>
    </div>

    <form action="calculate_gpa.php" method="POST" id="gpaForm">
      <label for="numCourses">Number of Courses</label>
      <input type="number" id="numCourses" class="form-control" min="1" max="15" placeholder="e.g., 5" required>

      <div id="coursesContainer" class="course-section"></div>

      <button type="submit" class="btn btn-primary"> Calculate GPA</button>
    </form>
  </div>

  <script>
    const numCoursesInput = document.getElementById('numCourses');
    const coursesContainer = document.getElementById('coursesContainer');

    numCoursesInput.addEventListener('input', () => {
      const num = parseInt(numCoursesInput.value);
      coursesContainer.innerHTML = '';

      if (!isNaN(num) && num > 0) {
        for (let i = 1; i <= num; i++) {
          const row = document.createElement('div');
          row.className = 'course-grid';

          row.innerHTML = `
            <input type="text" class="form-control" name="course_code[]" placeholder="Course ${i} Code" required>
            <input type="number" class="form-control" name="grade_point[]" placeholder="Point (0-10)" min="0" max="10" required>
            <input type="number" class="form-control" name="credits[]" placeholder="Credits" min="1" max="5" required>
          `;
          coursesContainer.appendChild(row);
        }
      }
    });
  </script>

</body>
</html>

<?php include 'stlayouts/footer.php'; ?>
