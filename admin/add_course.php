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
        /* Main form card */
        body .content {
            width: 550px !important;
            max-width: calc(100% - 60px);
            box-sizing: border-box;

            /* Left alignment and vertical spacing */
            margin: 30px 0 40px 30px;

            padding: 30px;

            background-color: #ffffff;
            border: 1px solid #dce8e0;
            border-top: 4px solid #e6b422;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(4, 63, 46, 0.08);
        }

        /* Heading */
        body .content h1 {
            margin: 0 0 30px;
            text-align: left;
            font-size: 26px;
            color: #043f2e;
        }

        /* Form rows */
        .form-group {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 22px;
        }

        .form-group label {

            flex: 0 0 95px;
            color: #334155;
            font-size: 14px;
            font-weight: 600;
        }

        /* Input fields */
        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group textarea{
            flex: 1;
            min-width: 0;
            height: 36px;
            padding: 8px 10px;
            border: 1px solid #cbd5d1;
            border-radius: 5px;
            font-size: 14px;
            outline: none;
        }

        .form-group input:focus {
            border-color: #043f2e;
            box-shadow: 0 0 0 2px rgba(4, 63, 46, 0.1);
        }

        /* Password visibility button */
        .form-group input[type="button"] {
            padding: 7px 10px;
            border: 1px solid #cbd5d1;
            border-radius: 5px;
            background-color: #f1f5f9;
            color: #123b70;
            cursor: pointer;
        }

        /* Submit button */
        .submit-button {
            display: block;
            width: 100%;
            margin-top: 25px;
            padding: 11px;
            border: none;
            border-radius: 6px;
            background-color: #123b70;
            color: white;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
        }

        .submit-button:hover {
            background-color: #0b2a52;
        }

        /* Back link */
        .back-link {
            display: block;
            margin-top: 22px;
            text-align: left;
            color: #123b70;
        }

    </style>

</head>
<body>

    <div class="content">
        <h1>Add Course</h1>
        <br>
        <form action="add_course.php" method="POST">
            <div class="form-group">
                <label for="course_code">Course Code:</label>
                <input type="text" name="course_code" id="course_code" required>
            </div>
            <div class="form-group">
                <label for="course_name">Course Name:</label>
                <input type="text" name="course_name" id="course_name" required>
            </div>
            <div class="form-group">
                <label for="credits">Credits:</label>
                <input type="number" name="credits" id="credits" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea name="description" id="description" required></textarea>
            </div>
            <input class="submit-button" type="submit" name="submit" value="Add Course">
        </form>

        <a class="back-link" href="course.php">Back to Courses</a>
    </div>
    <?php
        include "../includes/footer.php";
    ?>
</body>
</html>

