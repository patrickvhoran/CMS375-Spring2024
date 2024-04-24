<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Form</title>
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
            margin: 20px;
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
            top: 100px;
            margin: 20px;
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
    ?>

    <img src="https://fdotwww.blob.core.windows.net/sitefinity/images/default-source/content1/info/logo/png/fdot_logo_color.png?sfvrsn=293c15a8_2" alt="Logo" class="image-container">

    <div class="login-container">
        <h2>Create Account</h2>
        <form class="login-form" action="" method="post" id="create_account">
            
            <label>Name:</label>
            <input type="text" name="name" placeholder="Ex: John Doe" required><br>
            
            <label>Username:</label>
            <input type="text" name="username" placeholder="Ex: user123" required><br>

            <label>Password:</label>
            <input type="text" name="password" placeholder="Ex: *******" required><br>
            
            <input type="submit" name="create" value="Create Account">
            
        </form>
    </div>



    <script>
    document.getElementById("create_account").addEventListener("submit", function(event) {
    var confirmation = confirm('Account Information:\n\n' + 
        'Name: ' + document.getElementsByName('name')[0].value + '\n' +
        'Username: ' + document.getElementsByName('username')[0].value + '\n' +
        'Password: ' + document.getElementsByName('password')[0].value + '\n\n'
        'Do you want to confirm?');
    if (!confirmation) {
        event.preventDefault();
    }
    });

    </script>

    <?php
    // Check if station form is submitted
    if (isset($_POST['create'])) {
        
        // Extract route information from the form data
        $name = $_POST['name'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        

        //check if username is taken
        $query = "SELECT * FROM Passenger WHERE username = '$username';";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) != 0) {
            echo "<script>alert('Username taken');</script>";

        } else {
            
            // Start transaction
            $conn->begin_transaction();
            
            // Execute SQL query to insert data into database
            
            $sql = "INSERT INTO Passenger (Name, Username, Password) 
                    VALUES ('$name', '$username', '$password')";

            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Record created successfully');</script>";
                // Commit transaction
                $conn->commit();
                header("Location: home.php?username=$username");
                
            } else {
                echo "<script>alert('Error: " . $sql . '\\n' . $conn->error . "');</script>";
                // Rollback transaction
                $conn->rollback();
            }

        }
    }

    // Close connection
    $conn->close();

    ?>


</body>

</html>
