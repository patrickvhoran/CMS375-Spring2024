<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
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

        table {
            width: 75%; /* Adjust width as needed */
            margin: 20px; /* Center the table horizontally */
            top: 50%;
            border-collapse: collapse; /* Collapse borders between cells */
        }

        /* Table row styles */
        tr:nth-child(even) {
            background-color: #f2f2f2; /* Light grey background for even rows */
        }

        tr:hover {
            background-color: #e6e6e6; /* Slightly darker background color on hover */
        }

        /* Table cell styles */
        td, th {
            padding: 8px; /* Adjust cell padding as needed */
            border: 1px solid #ddd; /* Example border color */
        }

        /* Table header styles */
        th {
            background-color: #f0f0f0; /* Example background color for header */
            color: black; /* Example text color for header */
        }
        .register-button {
            position: absolute;
            margin: 20px;
            right: 15%;
            width: 100px; /* Set your desired width */
            padding: 10px; /* Add padding */
            background-color: #4CAF50; /* Set background color */
            color: white; /* Set text color */
            border: none; /* Remove border */
            border-radius: 5px; /* Add border radius */
            cursor: pointer; /* Add cursor style */
        }

        /* Hover style for the buttons */
        .register-button:hover {
            background-color: #45a049; /* Change background color on hover */
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
    $username = $_GET['username'];
    $query = "SELECT password FROM Passenger WHERE username = '$username';";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
  
    $password = $row['password'];

    ?>

    <div class="form-container">
        <h2>Update Account</h2>

        <form action="" method="post" id="name_form">
            <label>Name:</label>
            <input type="text" name="new_name" placeholder="Ex: John Doe" required><br>
            <input type="submit" name="update_name" value="Update Name"><br><br>
        </form>

        <form action="" method="post" id="username_form">
            <label>Username:</label>
            <input type="text" name="new_username" placeholder="Ex: user123" required><br>
            <input type="submit" name="update_username" value="Update Username"><br><br>
        </form>

        <form action="" method="post" id="password_form">
            <label>Password:</label>
            <input type="text" name="new_password" placeholder="Ex: *******" required><br>
            <input type="submit" name="update_password" value="Update Password"><br><br>  
        </form>
    </div>



    <script>
    document.getElementById("name_form").addEventListener("submit", function(event) {
        // Ask the user for input
        var userInput = window.prompt("Attempting to change Name to: " +
        document.getElementsByName('new_name')[0].value + "\n" + 
        "Please enter your password to confirm:");
        
        var correct = "<?php echo $password; ?>";
        // Check if the input is correct

        if (userInput !== correct) {
            // If the input is not correct, prevent the form from submitting
            event.preventDefault();
            alert("Input is not correct. Please try again.");
        }
    });

    document.getElementById("username_form").addEventListener("submit", function(event) {
        // Ask the user for input
        var userInput = window.prompt("Attempting to change username to: " +
        document.getElementsByName('new_username')[0].value + "\n" + 
        "Please enter your password to confirm:");
        
        var correct = "<?php echo $password; ?>";
        // Check if the input is correct

        if (userInput !== correct) {
            // If the input is not correct, prevent the form from submitting
            event.preventDefault();
            alert("Input is not correct. Please try again.");
        }
    });

    document.getElementById("password_form").addEventListener("submit", function(event) {
        // Ask the user for input
        var userInput = window.prompt("Attempting to change password to: " +
        document.getElementsByName('new_password')[0].value + "\n" + 
        "Please enter your old password to confirm:");
        
        var correct = "<?php echo $password; ?>";
        // Check if the input is correct

        if (userInput !== correct) {
            // If the input is not correct, prevent the form from submitting
            event.preventDefault();
            alert("Input is not correct. Please try again.");
        }
    });

    </script>

    <?php
    function load_routes($conn, $text){
    
        $result = mysqli_query($conn, $text);
    
        // Check if query was successful
    
        if ($result) {
            // Display column names
            echo "<div style='width=75%'>";
            echo "<h1 style='margin-left: 12.5%;'>My Routes</h1>";
            echo "<form id='registrationForm' method='post'>";
            echo "<table id='myTable' border='1' style='margin: auto;'>";
            echo "<tr>";
            echo "<th></th>";
            echo "<th>Departure Locaiton</th>";
            echo "<th>Arrival Locaiton</th>";
            echo "<th>Departure Time</th>";
            echo "<th>Transport Type</th>";
            echo "<th>Open Seats</th>";
            echo "<th>Price</th>";
            echo "</tr>";
    
            // Display data rows
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                    echo "<td><input type='checkbox' name='row[]' value='{$row['RouteID']}'></td>";
                    echo "<td>{$row['DepartureLocation']}</td>";
                    echo "<td>{$row['ArrivalLocation']}</td>";
                    echo "<td>{$row['DepartureTime']}</td>";
                    echo "<td>{$row['TransportType']}</td>";
                    echo "<td>{$row['OpenSeats']}</td>";
                    echo "<td>{$row['Price']}</td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "<button type='submit' class='register-button' name='register'>Cancel Registration</button>";
            echo "</form>";
            echo "<div>";
    
        } else {
            echo "Error: " . $conn->error;
        }

    }

    if (isset($_POST['update_name'])){
        $new_name = $_POST['new_name'];

        $query = "UPDATE Passenger SET Name = '$new_name' WHERE username = '$username';";
        if ($conn->query($query) === TRUE) {
            echo "<script>alert('Name changed to " . $new_name . "');</script>";
            // Commit transaction
            $conn->commit();
        } else {
            echo "<script>alert('Error: " . $query . '\\n' . $conn->error . "');</script>";
            // Rollback transaction
            $conn->rollback();
        }
    }

    if (isset($_POST['update_username'])){
        $new_username = $_POST['new_username'];
        $query = "UPDATE Passenger SET username = '$new_username' WHERE username = '$username';";
        if ($conn->query($query) === TRUE) {
            echo "<script>alert('Username changed to " . $new_username . "');</script>";
            // Commit transaction
            $conn->commit();
        } else {
            echo "<script>alert('Error: " . $query . '\\n' . $conn->error . "');</script>";
            // Rollback transaction
            $conn->rollback();
        }
    }

    if (isset($_POST['update_password'])){
        $new_password = $_POST['new_password'];
        $query = "UPDATE Passenger SET password = '$new_password' WHERE username = '$username';";
        if ($conn->query($query) === TRUE) {
            echo "<script>alert('password changed to " . $new_password . "');</script>";
            // Commit transaction
            $conn->commit();
        } else {
            echo "<script>alert('Error: " . $query . '\\n' . $conn->error . "');</script>";
            // Rollback transaction
            $conn->rollback();
        }
    }

        // Check if the register button is clicked
    if (isset($_POST['register'])) {
        // Check if any rows are selected
        if (isset($_POST['row']) && !empty($_POST['row'])) {
            // Loop through selected rows
            foreach ($_POST['row'] as $rowId) {
                
                $query = "DELETE FROM Takes WHERE PassengerID = (SELECT PassengerID FROM Passenger WHERE username = '$username') AND RouteID = '$rowId';";
                
                if ($conn->query($query) === TRUE) {
                    echo "<script>alert('Reservation Cancelled');</script>";
                    // Commit transaction
                    $conn->commit();


                } else {
                    echo "<script>alert('Error: " . $query . '\\n' . $conn->error . "');</script>";
                    // Rollback transaction
                    $conn->rollback();
                }
            }
            

        } else {
            echo "<script>alert('No rows selected.');</script>";
        }
    }


        $text = "select s1.StationName as DepartureLocation, s2.StationName as ArrivalLocation, r.DepartureTime, r.TransportType, r.OpenSeats, r.Price, r.RouteID 
                    from Passenger p 
                    join takes t on p.PassengerID = t.PassengerID
                    join routes r on r.RouteID = t.RouteID
                    right join station s1 on r.DepartureLocationID = s1.StationID 
                    right join station s2 on r.ArrivalLocationID = s2.StationID 
                    WHERE p.username = '$username';";
        load_routes($conn, $text);

    ?>

<div style="position: fixed; top: 8px; left: 16px;">
    <form action="home.php" method="get">
        <input type="hidden" name="username" value="<?php echo $username; ?>">
        <button type="submit" style="background: none; border: none; padding: 0; margin: 0; cursor: pointer;">
            <img src="back-button.png" alt="Button" width="25" height="25">
        </button>
    </form>
</div>
</body>

</html>
