<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        .login-container h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .login-form input[type="text"],
        .login-form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        .login-form input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            box-sizing: border-box;
            border: none;
            border-radius: 4px;
            background-color: #007bff;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }

        .login-form input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .login-form p {
            margin-top: 15px;
            font-size: 14px;
        }

        .login-form p a {
            color: #007bff;
            text-decoration: none;
        }

        .login-form p a:hover {
            text-decoration: underline;
        }

        .image-container {
            position: absolute;
            top: 150px;

            margin: auto;
            width: 300px; /* Adjust the width as needed */
            height: auto; /* This will maintain the aspect ratio */
        }
    </style>
        
</head>

<body>
        
    <?php
    // Database credentials
    $servername = "localhost";
    $username = "root"; 
    $password = "edwArd1608!"; 
    $database = "transport"; 

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    // Check if login form is submitted
    if (isset($_POST['login'])) {
        // Extract username and password from the form data
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Query the database to check if the username and password exist
        $query = "SELECT * FROM Passenger WHERE username = '$username' AND password = '$password'";
        $result = $conn->query($query);

        // Check if any rows are returned (valid credentials)
        if ($result->num_rows > 0) {
            // Valid credentials
            echo '<script>alert("Login successful!");</script>';
            header("Location: home.php?username=$username");
        } else {
            // Invalid credentials
            echo '<script>alert("Invalid username or password.");</script>';
        }
    }
    ?>

<img src="https://fdotwww.blob.core.windows.net/sitefinity/images/default-source/content1/info/logo/png/fdot_logo_color.png?sfvrsn=293c15a8_2" alt="Logo" class="image-container">

<div class="login-container">
    <!-- HTML form -->
    <form class="login-form" action="" method="post">
        <label>Username:</label>
        <input type="text" name="username" required><br>
        <label>Password:</label>
        <input type="password" name="password" required><br>
        <input type="submit" name="login" value="Login">
    </form>

</div>

</body>
</html>