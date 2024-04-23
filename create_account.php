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
    ?>

    <div class="form-container">
        <h2>Create Account</h2>
        <form action="" method="post" id="create_account">
            
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