<?php
    include "includes/db.php";

    if(isset($_POST['register'])){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm-password'];
        $role = 'student'; // Default role for new users

        if($password !== $confirm_password){
            echo "<script>alert('Passwords do not match!');</script>";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt1 = $conn->prepare("INSERT INTO users(name, email, password, role) VALUES (?, ?, ?, ?)");
            $stmt1->bind_param("ssss", $name, $email, $hashed_password, $role);
            

            if($stmt1->execute()){
                // Get the newly created user ID
                $user_id = $conn->insert_id;

                // Create student record using the user ID
                $stmt2 = $conn->prepare("INSERT INTO students(user_id) VALUES (?)");
                $stmt2->bind_param("i", $user_id);
                $stmt2->execute();
                $stmt2->close();
                
                echo "<script>alert('Registration successful! Please login.'); window.location.href='login.php';</script>";
            } else {
                echo "<script>alert('Error: ". $stmt1->error ."');</script>";
            }
            $stmt1->close();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/student_management/images/logo.png">
    <title>Student Hub | Register</title>
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

        .register-container {
            width: 100%;
            max-width: 400px;
            padding: 30px;
            background-color: #ffffff;
            border: 1px solid #dce8e0;
            border-top: 4px solid #e6b422;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(4, 63, 46, 0.08);
        }

        .logo {
            display: block;
            width: 60px;
            height: 60px;
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
            margin: 0 0 24px;
            text-align: center;
            font-size: 14px;
            color: #6b7c74;
        }

        .form-group {
            margin-bottom: 17px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-size: 14px;
            font-weight: 600;
            color: #244c3d;
        }

        .form-group input {
            width: 100%;
            padding: 11px 12px;
            border: 1px solid #cbd9d0;
            border-radius: 5px;
            font-size: 14px;
            background-color: #ffffff;
            outline: none;
        }

        .form-group input:focus {
            border-color: #087f5b;
            box-shadow: 0 0 0 2px rgba(8, 127, 91, 0.12);
        }

        .password-wrapper {
            display: flex;
            gap: 7px;
        }

        .password-wrapper input {
            flex: 1;
            min-width: 0;
        }

        .toggle-password {
            padding: 0 10px;
            border: 1px solid #cbd9d0;
            border-radius: 5px;
            background-color: #f2f7f4;
            color: #043f2e;
            cursor: pointer;
        }

        .toggle-password:hover {
            background-color: #e1eee6;
        }

        .register-button {
            width: 100%;
            padding: 12px;
            margin-top: 3px;
            border: none;
            border-radius: 5px;
            background-color: #043f2e;
            color: #ffffff;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .register-button:hover {
            background-color: #086448;
        }

        .message {
            margin-bottom: 17px;
            padding: 10px;
            border-radius: 5px;
            background-color: #fff4e5;
            color: #8a4b08;
            font-size: 13px;
            line-height: 1.5;
            text-align: center;
        }

        .login-link {
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
            margin-top: 18px;
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
            let confirmPassword = document.getElementById("confirm-password");
            if (confirmPassword.type === "password") {
                confirmPassword.type = "text";
            } else {
                confirmPassword.type = "password";
            }
        }
        function validatePassword() {
            let password = document.getElementById("password").value;
            if (password.length < 8) {
                alert("Password must have at least 8 characters!");
                return false;
            }
            if (password.match(/[0-9]/) == null) {
                alert("Password must contain at least one number!");
                return false;
            }
            if (password.match(/[!@#$%^&*]/) == null) {
                alert("Password must contain at least one special character!");
                return false;
            }

         return true;
        }
        function validateForm() {
            let password = document.getElementById("password").value;
            let confirmPassword = document.getElementById("confirm-password").value;
            if (password !== confirmPassword) {
                alert("Passwords do not match!");
                return false;
            }
            return true;
        }   
    </script>
</head>
<body>
    
    <div class="register-container">

        <img class="logo" src="/student_management/images/logo.png" alt="Student Hub Logo">

        <h1>Create Your Account</h1>
        <p class="subtitle">Join Student Hub to manage your academic journey</p>

        <form action="register.php" method="post"
      onsubmit="return validatePassword() && validateForm()">

            <div class="form-group">
            <label for="name">Full Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your full name" autocomplete="name" required>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" autocomplete="email" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>

                <div class="password-wrapper">
                    <input type="password" id="password" name="password" placeholder="Create a password" autocomplete="new-password" required>

                    <button type="button" class="toggle-password" onclick="togglePassword('password', this)">
                        Show
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label for="confirm-password">Confirm Password</label>

                <div class="password-wrapper">
                    <input type="password" id="confirm-password" name="confirm-password" placeholder="Re-enter your password" autocomplete="new-password" required>

                    <button type="button" class="toggle-password" onclick="togglePassword('confirm-password', this)">
                        Show
                    </button>
                </div>
            </div>

            <button type="submit" name="register" value="register" class="register-button">
                Create Account
            </button>

        </form>

        <p class="login-link">
            Already have an account?
            <a href="login.php">Login here</a>
        </p>

        <a class="home-link" href="index.php">
            &larr; Back to Home
        </a>

    </div>
</body>
</html>