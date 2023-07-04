<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-top: 0;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="password"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4caf50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .registration-form {
            display: none;
        }

        #register-button {
            margin-top: 10px;
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #register-button:hover {
            background-color: #2980b9;
        }
    </style>
    <script>
        function toggleRegistrationForm() {
            var registrationForm = document.getElementById("registration-form");
            var registerButton = document.getElementById("register-button");

            if (registrationForm.style.display === "none") {
                registrationForm.style.display = "block";
                registerButton.textContent = "Cancel";
            } else {
                registrationForm.style.display = "none";
                registerButton.textContent = "Register";
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <form action="login.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>
            <input type="submit" value="Login">
        </form>

        <button id="register-button" onclick="toggleRegistrationForm()">Register</button>

        <div id="registration-form" class="registration-form">
            <h1>Registration</h1>
            <form action="register.php" method="POST">
                <label for="new-username">New Username:</label>
                <input type="text" id="new-username" name="username" required><br>
                <label for="new-password">New Password:</label>
                <input type="password" id="new-password" name="password" required><br>
                <label for="role">Role:</label>
                <select id="role" name="role" required>
                    <option value="admin">Admin</option>
                    <option value="teacher">Teacher</option>
                    <option value="student">Student</option>
                </select><br>
                <input type="submit" value="Register">
            </form>
        </div>

        <?php
  
        if (isset($_GET["registration_success"])) {
            echo "<p>Registration successful! Please log in.</p>";
        }
        ?>
    </div>
</body>
</html>
