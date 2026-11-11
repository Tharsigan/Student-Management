<?php
    include "../includes/admin-auth.php";
    include "../includes/db.php";
    $enrollment_id = (int)$_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM enrollments WHERE enrollment_id = ?");
    $stmt->bind_param("i", $enrollment_id);
    $stmt->execute();
    $enrollment = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    if (!$enrollment) {
        die("Enrollment not found");
    }

    if(isset($_POST['submit'])){
        $student_id = trim($_POST['student_id']);
        $course_id = trim($_POST['course_id']);
        $enrollment_date = trim($_POST['enrollment_date']);
        $status = trim($_POST['status']);

        // Update the enrollment
        $stmt = $conn->prepare("UPDATE enrollments SET student_id=?, course_id=?, enrollment_date=?, status=? WHERE enrollment_id=?");
        $stmt->bind_param("iissi", $student_id, $course_id, $enrollment_date, $status, $enrollment_id);
        $stmt->execute();
        $stmt->close();

        header("Location: enrollments.php");
        exit();
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/student_management/images/logo.png">
    <title>Student Hub | Edit Enrollment</title>
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
        .form-group input[type="date"],
        .form-group select {
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
        <h1>Edit Enrollment</h1>
        <br>
        <form action="edit_enrollment.php?id=<?php echo $enrollment_id; ?>" method="POST">
            <div class="form-group">
                <label for="student_id">Student:</label>
                <select name="student_id" id="student_id" required>
                <?php
                    $result = $conn->query("SELECT s.student_id, u.name FROM students s JOIN users u ON s.user_id = u.user_id");
                    while($row = $result->fetch_assoc()){
                        $selected = "";
                        if($row['student_id'] == $enrollment['student_id']){
                            $selected = "selected";
                        }
                        echo "<option value='{$row['student_id']}' $selected>
                                {$row['student_id']} - {$row['name']}
                            </option>";
                    }
                ?>
                </select>
            </div>
            <div class="form-group">
            <label for="course_id">Course:</label>
            <select name="course_id" id="course_id" required>
                <?php
                    $result = $conn->query("SELECT course_id, course_name, course_code FROM courses");
                    while($row = $result->fetch_assoc()){
                        $selected = "";
                        if($row['course_id'] == $enrollment['course_id']){
                            $selected = "selected";
                        }
                        echo "<option value='{$row['course_id']}' $selected>
                                {$row['course_code']} - {$row['course_name']}
                            </option>";
                    }
                ?>
            </select>
            </div>
            <div class="form-group">
                <label for="enrollment_date">Enrollment Date:</label>
                <input type="date" name="enrollment_date" id="enrollment_date" value="<?php echo $enrollment['enrollment_date']; ?>" required>
            </div>
                <div class="form-group">
                <label for="status">Status:</label>
                <select name="status" id="status" required>
                    <option value="active" <?php if($enrollment['status'] == 'active') echo 'selected'; ?>>Active</option>
                    <option value="completed" <?php if($enrollment['status'] == 'completed') echo 'selected'; ?>>Completed</option>
                    <option value="dropped" <?php if($enrollment['status'] == 'dropped') echo 'selected'; ?>>Dropped</option>
                </select>
            </div>
            <input class="submit-button" type="submit" name="submit" value="Update Enrollment">
        </form>

        <a class="back-link" href="enrollments.php">Back to Enrollments</a>
    </div>
    <?php
        include "../includes/footer.php";
    ?>
</body>
</html>