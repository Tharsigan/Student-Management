<?php
    include "../includes/admin-auth.php";
    include "../includes/db.php";
    $errors = [];

    if(isset($_POST['submit'])){
        $course_code = trim($_POST['course_code']);
        $course_name = trim($_POST['course_name']);
        $credits = trim($_POST['credits']);
        $description = trim($_POST['description']);

        if( empty($course_code) || empty($course_name) || empty($credits) || empty($description) ){
            $errors[] = "All fields are required";
        }
        if(empty($errors)){
            // Insert into courses table
            $stmt = $conn->prepare("INSERT INTO courses(course_code, course_name, credits, description) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssis", $course_code, $course_name, $credits, $description);
            $stmt->execute();
            $stmt->close();

            header("Location: course.php");
            exit();
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/student_management/images/logo.png">
    <title>Student Hub | Add Course</title>
    <link rel="stylesheet" href="/student_management/css/style.css">
    <style>
        .content{
            margin: 20px;
        }
        .content form{
            width: 300px;
            margin-left: 20px;
            background-color: lightskyblue;
            border-radius: 10px;
            border: 1px solid black;
            padding: 20px;
        }
        .content a{
            text-decoration: none;
            background-color: #e4b9a5;
            color: black;
            padding: 10px 20px;
            border-radius: 5px;
        }
        form input[type="submit"]{
            padding: 10px ;
        }
    </style>

</head>
<body>
    <?php
        include "../includes/admin-navbar.php";
    ?>
    <div class="content">
        <h1>Add Course</h1>
        <br>
        <form action="add_course.php" method="POST">
            <label for="course_code">Course Code:</label>
            <input type="text" name="course_code" id="course_code" required>
            <br><br>
            <label for="course_name">Course Name:</label>
            <input type="text" name="course_name" id="course_name" required>
            <br><br>
            <label for="credits">Credits:</label>
            <input type="number" name="credits" id="credits" required>
            <br><br>
            <label for="description">Description:</label>
            <textarea name="description" id="description" required></textarea>
            <br><br>
            <input type="submit" name="submit" value="Add Course">
        </form>
        <br><br>

        <a href="course.php">Back to Courses</a>
        <br>
    </div>
    <?php
        include "../includes/footer.php";
    ?>
</body>
</html>



