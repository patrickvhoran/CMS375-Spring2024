<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Form</title>
    <style>
        /* Style for the form container */
        .form-container {
            width: 300px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #f9f9f9;
        }

        /* Style for the form inputs */
        .form-container input[type=text] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        /* Style for the submit button */
        .form-container input[type=submit] {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            box-sizing: border-box;
            border: none;
            border-radius: 3px;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }

        /* Style for the submit button on hover */
        .form-container input[type=submit]:hover {
            background-color: #45a049;
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

    <!-- HTML form -->
    <form action="" method="post">
        <label>Username:</label>
        <input type="text" name="username" required><br>
        <label>Password:</label>
        <input type="password" name="password" required><br>
        <input type="submit" name="login" value="Login">
    </form>

</body>
</html>