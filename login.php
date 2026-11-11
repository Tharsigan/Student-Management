<?php
    session_start();
    include "includes/db.php";

    if(isset($_POST['login'])){
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? ");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if email exists
        if($result->num_rows > 0){
            // Get the user's database row
            $user = $result->fetch_assoc();

            // Verify entered password with hashed password
            if(password_verify($password, $user['password'])){
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['role'] = $user['role'];

                if($user['role'] == 'admin'){
                    header("Location: admin/dashboard.php");
                } else {
                    header("Location: student/dashboard.php");
                }
                exit();
            }
            else {
                echo "<script>alert('Invalid email or password');</script>";
            }
        }
        else {
            echo "<script>alert('Invalid email or password');</script>";
        }
        $stmt->close();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/student_management/images/logo.png">
    <title>Student Hub | Login</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            font-family: Arial, sans-serif;
            background-color: #f2f7f4;
            color: #173d30;
        }

        .login-container {
            width: 100%;
            max-width: 380px;
            padding: 32px;
            background-color: #ffffff;
            border: 1px solid #dce8e0;
            border-top: 4px solid #e6b422;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(4, 63, 46, 0.08);
        }

        .logo {
            display: block;
            width: 65px;
            height: 65px;
            object-fit: contain;
            margin: 0 auto 12px;
        }

        h1 {
            margin: 0 0 8px;
            text-align: center;
            font-size: 25px;
            color: #043f2e;
        }

        .subtitle {
            margin: 0 0 25px;
            text-align: center;
            font-size: 14px;
            color: #6b7c74;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-size: 14px;
            font-weight: 600;
            color: #244c3d;
        }
        .form-group {
            margin-bottom: 18px;
        }

        .form-group input {
            width: 100%;
            padding: 11px 12px;
            border: 1px solid #cbd9d0;
            border-radius: 5px;
            font-size: 14px;
            outline: none;
            background-color: #ffffff;
        }

        .form-group input:focus {
            border-color: #087f5b;
            box-shadow: 0 0 0 2px rgba(8, 127, 91, 0.12);
        }

        .password-wrapper {
            display: flex;
            gap: 7px;
        }

        .password-wrapper .passwordInput {
            flex: 4;
            min-width: 0;
        }

        .toggle-password {
            flex: 1;
            padding: 5px;
            border: 1px solid #cbd9d0;
            border-radius: 5px;
            background-color: #f2f7f4;
            cursor: pointer;
            color: #043f2e;
        }

        .toggle-password:hover {
            background-color: #e1eee6;
        }

        .login-button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 5px;
            background-color: #043f2e;
            color: #ffffff;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .login-button:hover {
            background-color: #086448;
        }

        .register-link {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
            color: #63756c;
        }

        a {
            color: #087f5b;
            text-decoration: none;
            font-weight: 600;
        }

        a:hover {
            text-decoration: underline;
        }

        .home-link {
            display: block;
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
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
    <div class="login-container">
        <img class="logo" src="/student_management/images/logo.png" alt="Student Hub Logo">
        <h1>Welcome Back!</h1>
        <p class="subtitle">Login to your Student Hub account</p>

        <form action="login.php" method="post">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="text" id="email" name="email" placeholder="Enter your email" autocomplete="email" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="password-wrapper">
                    <input type="password" id="password" name="password" placeholder="Enter your password" autocomplete="current-password" required class="passwordInput">
                    <input type="button" onclick="togglePassword()" class="toggle-password" value="Show"> 
                </div>
            </div>
            <button name="login" id="login" value="login" class="login-button">Login</button>
        </form>

        <p class="register-link">Don't have an account?
            <a href="register.php">Register</a>
        </p>

        <a class="home-link" href="index.php">&larr; Back to Home</a>
    </div>

    
</body>
</html>

