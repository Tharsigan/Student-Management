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
    <link rel="icon" type="image/png" href="/student_management/images/logo.png">
    <title>Student Hub | My Courses</title>
    <link rel="stylesheet" href="/student_management/css/style.css">    
</head>
<body>
    <?php
        include "../includes/student-navbar.php";
    ?>
    <main class="content">
        <section class="content-section">
            <div class="section-heading">
                <div>
                    <h1>My Courses</h1>
                    <p>Explore the courses enrolled by you.</p>
                </div>
            </div>

            <div class="table-container">
                <table class="dtable">
                    <thead>
                        <tr>
                            <th>Course Id</th>
                            <th>Course Code</th>
                            <th>Course Name</th>
                            <th>Credits</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php  
                            $result = $conn->query("SELECT c.course_id, c.course_code, c.course_name, c.credits, c.description FROM courses c JOIN enrollments e ON c.course_id = e.course_id JOIN students s ON e.student_id = s.student_id WHERE s.user_id = $user_id");     
                            if ($result->num_rows == 0) {
                                echo "<tr>
                                        <td colspan='5'>No courses available yet.</td>
                                    </tr>";
                            }
                            else{    
                                while($row = $result->fetch_assoc()){
                                    echo"<tr>
                                        <td>{$row['course_id']}</td>
                                        <td>{$row['course_code']}</td>
                                        <td>{$row['course_name']}</td>
                                        <td>{$row['credits']}</td>
                                        <td>{$row['description']}</td>
                                    </tr>
                                    ";
                                }
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