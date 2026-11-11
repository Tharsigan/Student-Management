<?php
    include "../includes/admin-auth.php";
    include "../includes/db.php";
    $errors = [];

    if(isset($_POST['submit'])){
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        if( empty($name) || empty($email) || empty($password) ){
            $errors[] = "All fields are required";
        }
        if(empty($errors)){
            // Insert into users table
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt1 = $conn->prepare("INSERT INTO users(name, email, password, role) VALUES (?, ?, ?, ?)");
            $role = "admin";
            $stmt1->bind_param("ssss", $name, $email, $hashed_password, $role);
            
            if($stmt1->execute()){
                $stmt1->close();
                header("Location: dashboard.php");
                exit();
            }else {
                    $errors[] = "Error adding admin details: " . $stmt1->error;
                    $stmt1->close();
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
    <title>Student Hub | Add Admin</title>
    <link rel="stylesheet" href="/student_management/css/style.css">
    <style>
        /* Main form card */
        body .content {
            width: 500px !important;
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
            flex: 0 0 85px;
            color: #334155;
            font-size: 14px;
            font-weight: 600;
        }

        /* Input fields */
        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="password"] {
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
        <h1>Add Admin</h1>
        <br>
        <form action="add_admin.php" method="POST">
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
            <input class="submit-button" type="submit" name="submit" value="Add Admin">
        </form>
        <a class="back-link" href="admins.php">Back to Admin</a>
    </div>
    <?php
        include "../includes/footer.php";
    ?>
</body>
</html>

