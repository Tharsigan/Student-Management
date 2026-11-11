<?php
    include "../includes/admin-auth.php";
    include "../includes/db.php";
    $errors = [];

    if(isset($_POST['submit'])){
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $student_number = trim($_POST['student_number']);
        $nic = trim($_POST['nic']);
        $mobile = trim($_POST['mobile']);
        $address = trim($_POST['address']);

        if( empty($name) || empty($nic) || empty($mobile) || empty($email) || empty($password) || empty($student_number) || empty($address) ){
            $errors[] = "All fields are required";
        }
        if(empty($errors)){
            // Insert into users table
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt1 = $conn->prepare("INSERT INTO users(name, email, password, role) VALUES (?, ?, ?, ?)");
            $role = "student";
            $stmt1->bind_param("ssss", $name, $email, $hashed_password, $role);
            if($stmt1->execute()){
                // Get the newly created user_id - Get the ID that MySQL just automatically generated from the most recent INSERT query.
                $user_id = $conn->insert_id;
                $stmt1->close();

                // Insert into students table using the same user_id
                $stmt2 = $conn->prepare("INSERT INTO students(user_id, student_number, nic, mobile, address) VALUES (?, ?, ?, ?, ?)");
                $stmt2->bind_param("issss",$user_id,$student_number,$nic,$mobile, $address);
                if($stmt2->execute()){
                    $stmt2->close();

                    header("Location: students.php");
                    exit();
                }else {
                    $errors[] = "Error adding student details: ";
                }
            }
            else {
                $errors[] = "Error creating user account. Email may already exist. ";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/student_management/images/logo.png">
    <title>Student Hub | Add Student</title>
    <link rel="stylesheet" href="/student_management/css/style.css">
    <style>
        /* Main form card */
        body .content {
            width: 600px !important;
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
            flex: 0 0 120px;
            color: #334155;
            font-size: 14px;
            font-weight: 600;
        }

        /* Input fields */
        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="password"],
        .form-group textarea {
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
    <script>
        function togglePassword() {
            let password = document.getElementById("password");
            if (password.type === "password") {
                password.type = "text";
            } else {
                password.type = "password";
            }
        }   
    </script>
</head>
<body>
    <div class="content">
        <h1>Add Student</h1>
        <br>
        <form action="add_student.php" method="POST">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
                <input type="button" onclick="togglePassword()" value="👁">
            </div>
            <div class="form-group">
                <label for="student_number">Student Number:</label>
                <input type="text" name="student_number" id="student_number" required>
            </div>
            <div class="form-group">
                <label for="nic">NIC:</label>
                <input type="text" name="nic" id="nic" required>
            </div>
            <div class="form-group">
                <label for="mobile">Mobile:</label>
                <input type="text" name="mobile" id="mobile" required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <textarea name="address" id="address" required></textarea>
            </div>
            <input class="submit-button" type="submit" name="submit" value="Add Student">
        </form>

        <a class="back-link" href="students.php">Back to Students</a>
    </div>
    <?php
        include "../includes/footer.php";
    ?>
</body>
</html>

