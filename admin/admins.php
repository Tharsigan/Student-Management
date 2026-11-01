<?php
    include "../includes/admin-auth.php";
    include "../includes/db.php";
    $user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/student_management/images/logo.png">
    <link rel="stylesheet" href="/student_management/css/style.css">
    <title>Student Hub | Admin</title>
</head>
<body>
    <?php
        include "../includes/admin-navbar.php";
    ?>
    <div class="content">
        <h1>Admin Management</h1>
        <br>
        <label for="search">Search:</label>
        <input class="searchbtn" type="text" id="search" oninput="liveSearch()">
        <br><br>
        <a class="addbtn" href="add_admin.php">Add Admin</a>
        <br><br>
        <table class="tadmin dtable" id="tableID">
            <thead>
                <tr>
                    <th>Admin Id</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php  
                    $result = $conn->query("SELECT user_id, name, email FROM users WHERE role = 'admin'");
                    while($row = $result->fetch_assoc()){
                        echo"<tr>
                            <td>{$row['user_id']}</td>
                            <td>{$row['name']}</td>
                            <td>{$row['email']}</td>
                            <td>
                                <a class='editbtn' href='edit_admin.php?id={$row['user_id']}'>Edit</a>";
                                if($row['user_id'] != $user_id){
                                    echo "<a class='deletebtn' href='delete_admin.php?id={$row['user_id']}' onclick=\"return confirm('Delete this admin record?')\">Delete</a>";
                                }
                        echo "</td>
                        </tr>";
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
