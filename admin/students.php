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
    <title>Student Hub | Student</title>
    <link rel="stylesheet" href="/student_management/css/style.css">
</head>
<body>
    <?php
        include "../includes/admin-navbar.php";
    ?>
    <div class="content">
        <h1>Student Management</h1>
        <br>
        <label for="search">Search:</label>
        <input class="searchbtn" type="text" id="search" oninput="liveSearch()">
        <br><br>
    
        <?php
        if (isset($_SESSION['error'])) {
            echo "<p class='error'>" . htmlspecialchars($_SESSION['error']) . "</p>";
            unset($_SESSION['error']);
        }

        if (isset($_SESSION['success'])) {
            echo "<p class='success'>" . htmlspecialchars($_SESSION['success']) . "</p>";
            unset($_SESSION['success']);
        }
        ?>

        <a class="addbtn" href="add_student.php">Add Student</a>
        <br><br>
        <table id="tableID" class="tadmin dtable">
            <thead>
                <tr>
                    <th>Student Id</th>
                    <th>Student Number</th>
                    <th>Name</th>
                    <th>NIC</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php  
                    $result = $conn->query("SELECT s.student_id, s.student_number, u.name, s.nic, s.mobile, u.email FROM students s JOIN users u ON s.user_id = u.user_id");
                    while($row = $result->fetch_assoc()){
                        echo"<tr>
                            <td>{$row['student_id']}</td>
                            <td>{$row['student_number']}</td>
                            <td>{$row['name']}</td>
                            <td>{$row ['nic']}</td>
                            <td>{$row['mobile']}</td>
                            <td>{$row['email']}</td>
                            <td>
                                <a class='editbtn' href='edit_student.php?id={$row['student_id']}'>Edit</a>
                                <a class='deletebtn' href='delete_student.php?id={$row['student_id']}' onclick=\"return confirm('Delete this student record?')\">Delete</a>
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
