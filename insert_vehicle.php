<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Vehicle</title>
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

        .back-button {
            padding: 10px 20px; /* Padding around the text */
            background-color: #4CAF50; /* Background color */
            color: white; /* Text color */
            border: none; /* No border */
            border-radius: 5px; /* Rounded corners */
            cursor: pointer; /* Cursor on hover */
        }

        /* Hover style for the back-button class */
        .back-button:hover {
            background-color: #45a049; /* Darker green background color on hover */
        }
    </style>
</head>

<body>

<a href="admin.php">
    <img src="back-button.png" alt="Button Image" style="width: 30px; height: 30px;">
</a>



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
        <h2>Add Vehicle</h2>
        <form method="post" id="vehicle_form">
            
            <label>Vehicle Type:</label>       
            <select name ="trans_type">
                <option value="">Select Vehicle</option>
                <option value='Train'>Train</option>
                <option value='Bus'>Bus</option>
                <option value='Plane'>Plane</option>
                <option value='Subway'>Subway</option>
            </select><br>

            <label>Capacity</label>
            <input type="number" id="capacity" name="capacity" min="1" max="500" step="1">
            
            <input type="submit" name="submit_vehicle" value="Submit">
        </form>
    </div>

    <div class="form-container">
        <h3>Delete Vehicle</h3>
            <form method="post" id="delete_form">
                <label>Select Vehicle</label>
                <select name="deleted_vehicle" required>
                    <option value="">----</option>
                    <?php
                    $query = "SELECT VehicleID FROM Vehicle;";
                    $result = mysqli_query($conn, $query);
                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            // Generate an option for each row
                            echo "<option value='{$row['VehicleID']}'>{$row['VehicleID']}</option>";
                        }
                    }
                    ?>
                    </select>
                <input type="submit" name="delete_button" value="Delete">
            </form>
    </div>



    <script>
    document.getElementById("vehicle_form").addEventListener("submit", function(event) {
    var confirmation = confirm('Vehicle:\n\n' + 
        'Vehicle Type: ' + document.getElementsByName('trans_type')[0].value + '\n' +
        'Capacity: ' + document.getElementsByName('capacity')[0].value + '\n\n' +
        'Do you want to confirm?');
    if (!confirmation) {
        event.preventDefault();
    }
    });
    
    document.getElementById("delete_form").addEventListener("submit", function(event) {
    var confirmation = confirm('Please confirm that you would like to delete Vehicle #' +
        document.getElementsByName('deleted_vehicle')[0].value + '.\n' +
        'This action cannot be undone');
    if (!confirmation) {
        event.preventDefault();
    }
    });
    </script>

    <?php
    // Check if station form is submitted
    if (isset($_POST['submit_vehicle'])) {
        
        // Extract route information from the form data
        $trans_type = $_POST['trans_type'];
        $capacity = $_POST['capacity'];
        
        // Start transaction
        $conn->begin_transaction();
        
        // Execute SQL query to insert data into database
        
        $sql = "INSERT INTO Vehicle (TransportType, Capacity) 
                VALUES ('$trans_type', $capacity);";
        
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Record created successfully');</script>";
            // Commit transaction
            $conn->commit();


        } else {
            echo "<script>alert('Error: " . $sql . '\\n' . $conn->error . "');</script>";
            // Rollback transaction
            $conn->rollback();
        }

        

    }

    if (isset($_POST['delete_button'])){

        $vehicleID = $_POST['deleted_vehicle'];

        $query = "SELECT RouteID FROM Drives WHERE VehicleID = '$vehicleID';";
        $result = mysqli_query($conn, $vquery);
        $row = mysqli_fetch_assoc($result);

        

        $sql = "DELETE FROM Routes WHERE RouteID = (SELECT RouteID from Drives WHERE VehicleID = '$vehicleID');";
        echo "<p>" . $sql . "<p>";
        if ($conn->query($sql) === TRUE) {
            
            $conn->commit();

            $sql2 = "DELETE FROM Drives WHERE VehicleID = '$vehicleID';";

            if ($conn->query($sql2) === TRUE) {
                // Commit transaction
                $conn->commit();

                $sql3 = "DELETE FROM Vehicle WHERE VehicleID = '$vehicleID';";

                if ($conn->query($sql3) === TRUE) {
                    echo "<script>alert('Record successfully deleted');</script>";
                    // Commit transaction
                    $conn->commit();
                    
                } else { //
                    echo "<script>alert('Error: " . $sql . '\\n' . $conn->error . "');</script>";
                    // Rollback transaction
                    $conn->rollback();
                }
                    
            } else {
                echo "<script>alert('Error: " . $sql . '\\n' . $conn->error . "');</script>";
                // Rollback transaction
                $conn->rollback();
            }
            
        } else {

            echo "<script>alert('Error: " . $sql . '\\n' . $conn->error . "');</script>";
            // Rollback transaction
            $conn->rollback();
        }

        

    }

    // Close connection
    $conn->close();

    ?>


</body>

</html>
