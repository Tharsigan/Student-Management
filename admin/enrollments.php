<?php
    include "../includes/admin-auth.php";
    include "../includes/db.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/student_management/images/logo.png">
    <title>Student Hub | Enrollment</title>
    <link rel="stylesheet" href="/student_management/css/style.css">
</head>
<body>
    <?php
        include "../includes/admin-navbar.php";
    ?>
    <div class="content">
        <h1>Enrollment Management</h1>
        <br>
        <label for="search">Search:</label>
        <input class="searchbtn" type="text" id="search" oninput="liveSearch()">
        <br><br>
        <a class="addbtn" href="add_enrollment.php">Add Enrollment</a>
        <br><br>
        <table class="tadmin dtable" id="tableID">
            <thead>
                <tr>
                    <th>Enrollment Id</th>
                    <th>Student Name</th>
                    <th>Course Name</th>
                    <th>Enrollment Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php  
                    $result = $conn->query("SELECT e.enrollment_id, u.name, c.course_name, e.course_id, e.enrollment_date, e.status FROM enrollments e JOIN students s ON e.student_id = s.student_id JOIN users u ON u.user_id = s.user_id JOIN courses c ON e.course_id = c.course_id");
                    while($row = $result->fetch_assoc()){
                        echo"<tr>
                            <td>{$row['enrollment_id']}</td>
                            <td>{$row['name']}</td>
                            <td>{$row['course_name']}</td>
                            <td>{$row['enrollment_date']}</td>
                            <td>{$row['status']}</td>
                            <td>
                                <a class='editbtn' href='edit_enrollment.php?id={$row['enrollment_id']}'>Edit</a>
                                <a class='deletebtn' href='delete_enrollment.php?id={$row['enrollment_id']}' onclick=\"return confirm('Delete this enrollment record?')\">Delete</a>
                            </td>
                        </tr>
                        ";
                    }
                ?>
            </tbody>
        </table>
    </div>
    <?php
        include "../includes/footer.php";
    ?>
    <script src="../js/search.js"></script>
</body>
</html>
