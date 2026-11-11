<?php
    include "../includes/student-auth.php";
    include "../includes/db.php";

    $user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="/student_management/css/style.css">
    <link rel="icon" type="image/png"
          href="/student_management/images/logo.png">

    <title>Student Hub | Dashboard</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background-color: #f5f7fb;
            color: #263247;
        }

        /* Welcome section */
        .welcome-section {
            margin: 30px 35px;
            padding: 25px 30px;
            background: linear-gradient(135deg, #ffffff, #eaf1ff);
            border-radius: 18px;
            border: 1px solid #e1e8f5;
        }

        .welcome-section h2 {
            margin: 0 0 10px;
            font-size: 27px;
            color: #243b65;
        }

        .welcome-section p {
            margin: 0;
            color: #64748b;
            font-size: 15px;
        }

        /* Dashboard cards */
        .cards {
            display: flex;
            gap: 22px;
            margin: 25px 35px 35px;
        }

        .dashboard-card {
            position: relative;
            overflow: hidden;
            flex: 1;
            min-width: 0;
            min-height: 180px;
            padding: 25px;
            display: flex;
            align-items: center;
            gap: 18px;
            border-radius: 18px;
            border: 1px solid transparent;
            box-shadow: 0 5px 15px rgba(35, 50, 80, 0.06);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .dashboard-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 22px rgba(35, 50, 80, 0.12);
        }

        .books {
            background:
                linear-gradient(
                    110deg,
                    rgba(232, 242, 255, 0.97),
                    rgba(200, 221, 255, 0.86)
                ),
                url("/student_management/images/books.png");

            background-size: cover;
            background-position: center;
            border-color: #d2e1fb;
        }

        .tick {
            background:
                linear-gradient(
                    110deg,
                    rgba(232, 250, 239, 0.97),
                    rgba(190, 239, 210, 0.86)
                ),
                url("/student_management/images/tick.png");

            background-size: cover;
            background-position: center;
            border-color: #c8ebd4;
        }

        .stat {
            background:
                linear-gradient(
                    110deg,
                    rgba(247, 239, 255, 0.97),
                    rgba(224, 204, 255, 0.86)
                ),
                url("/student_management/images/stat.png");

            background-size: cover;
            background-position: center;
            border-color: #e4d3fa;
        }

        .card-icon {
            width: 65px;
            height: 65px;
            object-fit: contain;
            flex-shrink: 0;
        }

        .card-content h3 {
            margin: 0 0 12px;
            font-size: 16px;
            font-weight: 600;
            color: #334155;
        }

        .card-number {
            margin: 0;
            font-size: 32px;
            font-weight: bold;
            color: #1e293b;
        }

        .card-label {
            margin: 6px 0 0;
            font-size: 13px;
            color: #64748b;
        }

        /* Course and results sections */
        .content-section {
            margin: 30px 35px;
            padding: 25px;
            background-color: #ffffff;
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

        .section-heading h2 {
            margin: 0;
            font-size: 21px;
            color: #263b60;
        }

        .view-link {
            padding: 10px 15px;
            border-radius: 9px;
            background-color: #edf3ff;
            color: #315a9d;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
            white-space: nowrap;
            transition: background-color 0.2s;
        }

        .view-link:hover {
            background-color: #dce8ff;
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
            background-color: #f0f4fa;
            color: #475569;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            border-bottom: 1px solid #e2e8f0;
        }

        .dashboard-table td {
            padding: 16px 15px;
            color: #475569;
            font-size: 14px;
            border-bottom: 1px solid #edf0f5;
            background-color: #ffffff;
        }

        .dashboard-table tbody tr:hover td {
            background-color: #f8faff;
        }

        .dashboard-table tbody tr:last-child td {
            border-bottom: none;
        }

        .course-code {
            color: #315a9d;
            font-weight: bold;
        }

        .grade {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 7px;
            background-color: #e6f7ed;
            color: #207748;
            font-weight: bold;
        }

        .empty-message {
            text-align: center;
            color: #94a3b8;
            padding: 25px !important;
        }

        /* Smaller screens */
        @media (max-width: 1000px) {
            .cards {
                flex-wrap: wrap;
            }

            .dashboard-card {
                flex: 1 1 280px;
            }
        }

        @media (max-width: 600px) {
            .welcome-section,
            .cards,
            .content-section {
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

            .content-section {
                padding: 17px;
            }

            .section-heading h2 {
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

    <?php include "../includes/student-navbar.php"; ?>

    <!-- Welcome section -->
    <div class="welcome-section">
        <h2>
            Welcome back,
            <?php
                echo htmlspecialchars($_SESSION['name']);
            ?>! 👋
        </h2>

        <p>Here's an overview of your academic activities.</p>
    </div>

    <!-- Dashboard cards -->
    <div class="cards">

        <!-- Enrolled courses -->
        <div class="dashboard-card books">
            <img
                src="/student_management/images/books.png"
                alt="Books icon"
                class="card-icon"
            >

            <div class="card-content">
                <h3>Enrolled Courses</h3>

                <p class="card-number">
                    <?php
                        $stmt = $conn->prepare("
                            SELECT COUNT(*) AS total_courses
                            FROM enrollments e
                            JOIN students s ON e.student_id = s.student_id
                            WHERE s.user_id = ?
                        ");

                        $stmt->bind_param("i", $user_id);
                        $stmt->execute();

                        $result = $stmt->get_result();
                        $row = $result->fetch_assoc();

                        echo $row['total_courses'];

                        $stmt->close();
                    ?>
                </p>

                <p class="card-label">Your enrolled courses</p>
            </div>
        </div>

        <!-- Completed courses -->
        <div class="dashboard-card tick">
            <img
                src="/student_management/images/tick.png"
                alt="Completed icon"
                class="card-icon"
            >

            <div class="card-content">
                <h3>Completed Courses</h3>

                <p class="card-number">
                    <?php
                        $stmt = $conn->prepare("
                            SELECT COUNT(*) AS total_completed
                            FROM enrollments e
                            JOIN students s ON e.student_id = s.student_id
                            WHERE s.user_id = ?
                            AND e.status = 'completed'
                        ");

                        $stmt->bind_param("i", $user_id);
                        $stmt->execute();

                        $result = $stmt->get_result();
                        $row = $result->fetch_assoc();

                        echo $row['total_completed'];

                        $stmt->close();
                    ?>
                </p>

                <p class="card-label">Successfully completed</p>
            </div>
        </div>

        <!-- GPA -->
        <div class="dashboard-card stat">
            <img
                src="/student_management/images/stat.png"
                alt="GPA icon"
                class="card-icon"
            >

            <div class="card-content">
                <h3>Grade Point Average</h3>

                <p class="card-number">
                    <?php
                        $grade_points = [
                            "A+" => 4.0,
                            "A"  => 4.0,
                            "A-" => 3.7,
                            "B+" => 3.3,
                            "B"  => 3.0,
                            "B-" => 2.7,
                            "C+" => 2.3,
                            "C"  => 2.0,
                            "C-" => 1.7,
                            "D"  => 1.0,
                            "F"  => 0.0
                        ];

                        $stmt = $conn->prepare("
                            SELECT r.grade, c.credits
                            FROM results r
                            JOIN courses c ON r.course_id = c.course_id
                            JOIN students s ON r.student_id = s.student_id
                            WHERE s.user_id = ?
                        ");

                        $stmt->bind_param("i", $user_id);
                        $stmt->execute();

                        $result = $stmt->get_result();

                        $total_points = 0;
                        $total_credits = 0;

                        while ($row = $result->fetch_assoc()) {
                            $grade = $row['grade'];
                            $credits = (float) $row['credits'];

                            if (isset($grade_points[$grade])) {
                                $point = $grade_points[$grade];

                                $total_points += $point * $credits;
                                $total_credits += $credits;
                            }
                        }

                        if ($total_credits > 0) {
                            $gpa = $total_points / $total_credits;
                        } else {
                            $gpa = 0;
                        }

                        echo number_format($gpa, 2);

                        $stmt->close();
                    ?>
                </p>

                <p class="card-label">Based on available results</p>
            </div>
        </div>

    </div>

    <!-- My courses -->
    <div class="content-section">

        <div class="section-heading">
            <h2>📚 My Courses</h2>

            <a href="../student/my_courses.php" class="view-link">
                View All →
            </a>
        </div>

        <div class="table-container">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Course</th>
                        <th>Credits</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                        $stmt = $conn->prepare("
                            SELECT c.course_code, c.course_name, c.credits
                            FROM courses c
                            JOIN enrollments e ON c.course_id = e.course_id
                            JOIN students s ON s.student_id = e.student_id
                            WHERE s.user_id = ?
                            LIMIT 3
                        ");

                        $stmt->bind_param("i", $user_id);
                        $stmt->execute();

                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                    <td class='course-code'>" .
                                        htmlspecialchars($row['course_code']) .
                                    "</td>
                                    <td>" .
                                        htmlspecialchars($row['course_name']) .
                                    "</td>
                                    <td>" .
                                        htmlspecialchars((string) $row['credits']) .
                                    "</td>
                                </tr>";
                            }
                        } else {
                            echo "<tr>
                                <td colspan='3' class='empty-message'>
                                    No courses found.
                                </td>
                            </tr>";
                        }

                        $stmt->close();
                    ?>
                </tbody>
            </table>
        </div>

    </div>

    <!-- Recent results -->
    <div class="content-section">

        <div class="section-heading">
            <h2>📊 Recent Results</h2>

            <a href="../student/results.php" class="view-link">
                View Results →
            </a>
        </div>

        <div class="table-container">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Course</th>
                        <th>Marks</th>
                        <th>Grade</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                        $stmt = $conn->prepare("
                            SELECT c.course_name, r.marks, r.grade
                            FROM courses c
                            JOIN results r ON c.course_id = r.course_id
                            JOIN students s ON s.student_id = r.student_id
                            WHERE s.user_id = ?
                            ORDER BY r.result_id DESC
                            LIMIT 3
                        ");

                        $stmt->bind_param("i", $user_id);
                        $stmt->execute();

                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                    <td>" .
                                        htmlspecialchars($row['course_name']) .
                                    "</td>
                                    <td>" .
                                        htmlspecialchars((string) $row['marks']) .
                                    "</td>
                                    <td><span class='grade'>" .
                                        htmlspecialchars($row['grade']) .
                                    "</span></td>
                                </tr>";
                            }
                        } else {
                            echo "<tr>
                                <td colspan='3' class='empty-message'>
                                    No results available yet.
                                </td>
                            </tr>";
                        }

                        $stmt->close();
                    ?>
                </tbody>
            </table>
        </div>

    </div>

    <?php include "../includes/footer.php"; ?>

</body>
</html>