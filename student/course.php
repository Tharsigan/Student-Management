<?php
    include "../includes/student-auth.php";
    include "../includes/db.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" type="image/png" href="/student_management/images/logo.png">
    <title>Student Hub | All Courses</title>
    <link rel="stylesheet" href="/student_management/css/style.css">
</head>
<body>

    <?php include "../includes/student-navbar.php"; ?>

    <main class="content">
        <section class="content-section">
            <div class="section-heading">
                <div>
                    <h1>All Courses</h1>
                    <p>Explore the courses available to students.</p>
                </div>
            </div>

            <div class="table-container">
                <table class="dtable">
                    <thead>
                        <tr>
                            <th>Course ID</th>
                            <th>Course Code</th>
                            <th>Course Name</th>
                            <th>Credits</th>
                            <th>Description</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                            $result = $conn->query("SELECT * FROM courses");

                            if ($result && $result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo"<tr>
                                        <td>{$row['course_id']}</td>
                                        <td>{$row['course_code']}</td>
                                        <td>{$row['course_name']}</td>
                                        <td>{$row['credits']}</td>
                                        <td>{$row['description']}</td>
                                    </tr>
                                    ";
                                }
                            } else {
                        ?>
                                <tr>
                                    <td colspan="5" class="empty-message">
                                        No courses are available at the moment.
                                    </td>
                                </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <?php include "../includes/footer.php"; ?>

</body>
</html>