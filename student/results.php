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
    <link rel="icon" type="image/png" href="/student_management/images/logo.png">
    <title>Student Hub | Results</title>
</head>
<body>
    <?php
        include "../includes/student-navbar.php";
    ?>
    <main class="content">
        <section class="content-section">
            <div class="section-heading">
                <div>
                    <h1>Results</h1>
                    <p>Get the results.</p>
                </div>
            </div>

            <div class="table-container">
                <table class="dtable">
                    <thead>
                        <tr>
                            <th>Result Id</th>
                            <th>Course Code</th>
                            <th>Course Name</th>
                            <th>Marks</th>
                            <th>Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php  
                            $result = $conn->query("SELECT r.result_id, c.course_code, c.course_name, r.marks, r.grade FROM results r JOIN courses c ON r.course_id = c.course_id JOIN students s ON r.student_id = s.student_id WHERE s.user_id = $user_id");
                            if ($result->num_rows == 0) {
                                echo "<tr>
                                        <td colspan='5'>No results available yet.</td>
                                    </tr>";
                            }
                            else{
                                while($row = $result->fetch_assoc()){
                                    echo"<tr>
                                        <td>{$row['result_id']}</td>
                                        <td>{$row['course_code']}</td>
                                        <td>{$row['course_name']}</td>
                                        <td>{$row['marks']}</td>
                                        <td>{$row['grade']}</td>
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
    <?php
        include "../includes/footer.php";
    ?>
</body>
</html>
