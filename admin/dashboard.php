<?php
    include "../includes/admin-auth.php";
    include "../includes/db.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" type="image/png"
          href="/student_management/images/logo.png">
    <link rel="stylesheet"
          href="/student_management/css/style.css">

    <title>Student Hub | Admin Dashboard</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #f5f7fb;
            color: #263247;
            font-family: Arial, sans-serif;
        }

        /* Welcome section */
        .welcome-section {
            margin: 30px 35px;
            padding: 28px 30px;
            border-radius: 18px;
            background: linear-gradient(135deg, #ffffff, #eaf1ff);
            border: 1px solid #e1e8f5;
        }

        .welcome-section h2 {
            margin: 0 0 10px;
            color: #243b65;
            font-size: 27px;
        }

        .welcome-section p {
            margin: 0;
            color: #64748b;
            font-size: 15px;
        }

        /* Summary cards */
        .cards {
            display: flex;
            gap: 20px;
            margin: 25px 35px 35px;
        }

        .dashboard-card {
            flex: 1;
            min-width: 0;
            min-height: 180px;
            padding: 22px;
            display: flex;
            align-items: center;
            gap: 15px;
            border: 1px solid transparent;
            border-radius: 18px;
            box-shadow: 0 5px 15px rgba(35, 50, 80, 0.06);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .dashboard-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 22px rgba(35, 50, 80, 0.12);
        }

        .student-card {
            background: linear-gradient(135deg, #e8f2ff, #c8ddff);
            border-color: #d2e1fb;
        }

        .course-card {
            background: linear-gradient(135deg, #f3e8ff, #dfc5ff);
            border-color: #e4d3fa;
        }

        .enrollment-card {
            background: linear-gradient(135deg, #e8faef, #c2eed3);
            border-color: #c8ebd4;
        }

        .result-card {
            background: linear-gradient(135deg, #fff3e7, #ffdfbd);
            border-color: #f5ddc7;
        }

        .card-icon {
            width: 60px;
            height: 60px;
            object-fit: contain;
            flex-shrink: 0;
        }

        .card-content h3 {
            margin: 0 0 12px;
            color: #475569;
            font-size: 15px;
            font-weight: 600;
        }

        .card-number {
            margin: 0;
            color: #1e293b;
            font-size: 32px;
            font-weight: bold;
        }

        .card-description {
            margin: 6px 0 0;
            color: #64748b;
            font-size: 12px;
        }

      
        .content-section {
            margin: 30px 35px;
            padding: 25px;
            background: #ffffff;
            border: 1px solid #e7ebf2;
            border-radius: 18px;
            box-shadow: 0 4px 14px rgba(35, 50, 80, 0.04);
        }

        .section-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 22px;
        }

        .section-heading h2,
        .quick-actions h2 {
            margin: 0;
            color: #263b60;
            font-size: 21px;
        }

        .view-link {
            padding: 10px 15px;
            border-radius: 9px;
            background: #edf3ff;
            color: #315a9d;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
            white-space: nowrap;
        }

        .view-link:hover {
            background: #dce8ff;
        }

        /* Tables */
        .table-container {
            width: 100%;
            overflow-x: auto;
        }

        .dashboard-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .dashboard-table th {
            padding: 15px;
            background: #f0f4fa;
            color: #475569;
            border-bottom: 1px solid #e2e8f0;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .dashboard-table td {
            padding: 15px;
            background: #ffffff;
            color: #475569;
            border-bottom: 1px solid #edf0f5;
            font-size: 14px;
        }

        .dashboard-table tbody tr:hover td {
            background: #f8faff;
        }

        .dashboard-table tbody tr:last-child td {
            border-bottom: none;
        }

        .empty-message {
            padding: 25px !important;
            text-align: center;
            color: #94a3b8 !important;
        }

       
        .quick-actions {
            margin: 30px 35px;
            padding: 25px;
            background: #ffffff;
            border: 1px solid #e7ebf2;
            border-radius: 18px;
            box-shadow: 0 4px 14px rgba(35, 50, 80, 0.04);
        }

        .quick-actions h2 {
            margin-bottom: 22px;
        }

        .action-links {
            display: flex;
            flex-wrap: wrap;
            gap: 50px;
        }

        .action-link {
            display: inline-block;
            padding: 13px 20px;
            border-radius: 10px;
            background: #315a9d;
            color: #ffffff;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
            transition: background 0.2s, transform 0.2s;
        }

        .action-link:hover {
            background: #244579;
            transform: translateY(-2px);
        }

        .action-link.secondary {
            background: #eaf1ff;
            color: #315a9d;
        }

        .action-link.secondary:hover {
            background: #dce8ff;
        }

        /* Responsive layout */
        @media (max-width: 1100px) {
            .cards {
                flex-wrap: wrap;
            }

            .dashboard-card {
                flex: 1 1 250px;
            }
        }

        @media (max-width: 600px) {
            .welcome-section,
            .cards,
            .content-section,
            .quick-actions {
                margin: 18px 15px;
            }

            .welcome-section {
                padding: 22px;
            }

            .welcome-section h2 {
                font-size: 22px;
            }

            .cards {
                flex-direction: column;
                gap: 15px;
            }

            .dashboard-card {
                min-height: 145px;
                padding: 20px;
            }

            .card-icon {
                width: 50px;
                height: 50px;
            }

            .content-section,
            .quick-actions {
                padding: 17px;
            }

            .section-heading h2,
            .quick-actions h2 {
                font-size: 18px;
            }

            .dashboard-table th,
            .dashboard-table td {
                padding: 12px 10px;
            }
        }
    </style>
</head>

<body>

    <?php include "../includes/admin-navbar.php"; ?>

    <!-- Welcome section -->
    <div class="welcome-section">
        <h2>
            Welcome back,
            <?php echo htmlspecialchars($_SESSION['name']); ?>! 👋
        </h2>
        <p>Here's an overview of the student management system.</p>
    </div>

    
    <div class="cards">

        <div class="dashboard-card student-card">
            <img src="/student_management/images/student.png"
                 alt="Students" class="card-icon">

            <div class="card-content">
                <h3>Total Students</h3>
                <p class="card-number">
                    <?php
                        $result = $conn->query(
                            "SELECT COUNT(*) AS total_students FROM students"
                        );
                        $row = $result->fetch_assoc();
                        echo $row['total_students'];
                    ?>
                </p>
                <p class="card-description">Registered students</p>
            </div>
        </div>

        <div class="dashboard-card course-card">
            <img src="/student_management/images/books.png"
                 alt="Courses" class="card-icon">

            <div class="card-content">
                <h3>Total Courses</h3>
                <p class="card-number">
                    <?php
                        $result = $conn->query(
                            "SELECT COUNT(*) AS total_courses FROM courses"
                        );
                        $row = $result->fetch_assoc();
                        echo $row['total_courses'];
                    ?>
                </p>
                <p class="card-description">Available courses</p>
            </div>
        </div>

        <div class="dashboard-card enrollment-card">
            <img src="/student_management/images/enroll.png"
                 alt="Enrollments" class="card-icon">

            <div class="card-content">
                <h3>Total Enrollments</h3>
                <p class="card-number">
                    <?php
                        $result = $conn->query(
                            "SELECT COUNT(*) AS total_enrollments FROM enrollments"
                        );
                        $row = $result->fetch_assoc();
                        echo $row['total_enrollments'];
                    ?>
                </p>
                <p class="card-description">Course registrations</p>
            </div>
        </div>

        <div class="dashboard-card result-card">
            <img src="/student_management/images/result.png"
                 alt="Results" class="card-icon">

            <div class="card-content">
                <h3>Results Added</h3>
                <p class="card-number">
                    <?php
                        $result = $conn->query(
                            "SELECT COUNT(*) AS total_results FROM results"
                        );
                        $row = $result->fetch_assoc();
                        echo $row['total_results'];
                    ?>
                </p>
                <p class="card-description">Recorded results</p>
            </div>
        </div>

    </div>

    <!-- Recent students -->
    <div class="content-section">

        <div class="section-heading">
            <h2>👥 Recent Students</h2>
            <a href="students.php" class="view-link">View All →</a>
        </div>

        <div class="table-container">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                        $result = $conn->query("
                            SELECT s.student_id, u.name, u.email
                            FROM students s
                            JOIN users u ON s.user_id = u.user_id
                            ORDER BY s.student_id DESC
                            LIMIT 3
                        ");

                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                    <td>" . htmlspecialchars((string) $row['student_id']) . "</td>
                                    <td>" . htmlspecialchars($row['name']) . "</td>
                                    <td>" . htmlspecialchars($row['email']) . "</td>
                                </tr>";
                            }
                        } else {
                            echo "<tr>
                                <td colspan='3' class='empty-message'>
                                    No students found.
                                </td>
                            </tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>

    </div>

    <!-- Recent enrollments -->
    <div class="content-section">

        <div class="section-heading">
            <h2>📚 Recent Enrollments</h2>
            <a href="enrollments.php" class="view-link">View All →</a>
        </div>

        <div class="table-container">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Course</th>
                        <th>Date</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                        $result = $conn->query("
                            SELECT u.name, c.course_code, e.enrollment_date
                            FROM enrollments e
                            JOIN students s ON e.student_id = s.student_id
                            JOIN users u ON s.user_id = u.user_id
                            JOIN courses c ON e.course_id = c.course_id
                            ORDER BY e.enrollment_id DESC
                            LIMIT 3
                        ");

                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                    <td>" . htmlspecialchars($row['name']) . "</td>
                                    <td>" . htmlspecialchars($row['course_code']) . "</td>
                                    <td>" . htmlspecialchars($row['enrollment_date']) . "</td>
                                </tr>";
                            }
                        } else {
                            echo "<tr>
                                <td colspan='3' class='empty-message'>
                                    No enrollments found.
                                </td>
                            </tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>

    </div>

    <!-- Quick actions -->
    <div class="quick-actions">
        <h2>⚡ Quick Actions</h2>

        <div class="action-links">
            <a href="add_student.php" class="action-link">
                + Add Student
            </a>

            <a href="add_Course.php" class="action-link secondary">
                + Add Course
            </a>

            <a href="add_result.php" class="action-link secondary">
                + Add Result
            </a>
        </div>
    </div>

    <?php include "../includes/footer.php"; ?>

</body>
</html>
