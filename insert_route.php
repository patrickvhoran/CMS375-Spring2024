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
    <img src="back-button.png" alt="Button Image" style="width: 30px; height: 30px">
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
        <h2>Add Route</h2>
        <form method="post" id="route_form">
            
            <select name="dep_stat_id" required>
                <option value="">Select Departure Location</option>
                <?php
                $query = "SELECT StationID, StationName FROM Station;";
                $result = mysqli_query($conn, $query);
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Generate an option for each row
                        echo "<option value='{$row['StationID']}'>{$row['StationName']}</option>";
                    }
                }
                ?>
            </select><br>

            
            <select name="arr_stat_id" required>
                <option value="">Select Arrival Location</option>
                <?php
                $query = "SELECT StationID, StationName FROM Station;";
                $result = mysqli_query($conn, $query);
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Generate an option for each row
                        echo "<option value='{$row['StationID']}'>{$row['StationName']}</option>";
                    }
                }
                ?>
            </select><br>

            <label for="date">Choose a date:</label>
            <input type="date" id="date" name="date" required>
            <br>

            <label for="time">Choose a time:</label>
            <input type="time" id="time" name="time" required>
            <br>

            <select name ="vehicle" required>
            <option value="">Select Vehicle</option>
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
            </select><br>
            

            <select id="price" name="price" required>
                <option value="">Price</option>
                <!-- Generate options for integers from 1 to 10 -->
                    <?php
                    for ($i = 10; $i <= 500; $i+=10) {
                        echo "<option value='{$i}'>{$i}</option>";
                    }
                    ?> 
            </select>
            
            <input type="submit" name="submit_route" value="Submit">
        </form>
    </div>

    <div class="form-container">
        <h3>Delete Route</h3>
            <form method="post" id="delete_form">
                <label>Select Route</label>
                <select name="deleted_route" required>
                    <option value="">----</option>
                    <?php
                    $query = "SELECT RouteID FROM Routes;";
                    $result = mysqli_query($conn, $query);
                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            // Generate an option for each row
                            echo "<option value='{$row['RouteID']}'>{$row['RouteID']}</option>";
                        }
                    }
                    ?>
                    </select>
                <input type="submit" name="delete_button" value="Delete">
            </form>
    </div>



    <script>
    document.getElementById("route_form").addEventListener("submit", function(event) {
    var confirmation = confirm('Route Information:\n\n' + 
        'Departure Location: ' + document.getElementsByName('dep_stat_id')[0].value + '\n' +
        'Arrival Location: ' + document.getElementsByName('arr_stat_id')[0].value + '\n' +
        'Date & Time: ' + document.getElementById('date').value + ' ' + document.getElementById('time').value + '\n' +
        'Vehicle: ' + document.getElementsByName('vehicle')[0].value + '\n' +
        'Price: ' + document.getElementById('price').value + '\n\n' +
        'Do you want to confirm?');
    if (!confirmation) {
        event.preventDefault();
    }
    });
    
    document.getElementById("delete_form").addEventListener("submit", function(event) {
    var confirmation = confirm('Please confirm that you would like to delete Route #' +
        document.getElementsByName('deleted_route')[0].value + '.\n' +
        'This action cannot be undone');
    if (!confirmation) {
        event.preventDefault();
    }
    });
    </script>

    <?php
    // Check if station form is submitted
    if (isset($_POST['submit_route'])) {
        
        // Extract route information from the form data
        $dep_stat_id = $_POST['dep_stat_id'];
        $arr_stat_id = $_POST['arr_stat_id'];
        $datetime = $_POST['date'] . ' ' . $_POST['time'];
        $vehicle = $_POST['vehicle'];
        $price = $_POST['price'];
        
        
        $vquery = "SELECT * FROM Vehicle WHERE VehicleID = '$vehicle';";
        
        $result = mysqli_query($conn, $vquery);

        $row = mysqli_fetch_assoc($result);
        $open_seats = $row['Capacity'] - $row['Passengers'];
        $trans_type = $row['TransportType'];
        
        // Start transaction
        $conn->begin_transaction();
        
        // Execute SQL query to insert data into database
        
        $sql = "INSERT INTO Routes (DepartureLocationID, ArrivalLocationID, DepartureTime, TransportType, OpenSeats, price) 
                VALUES ('$dep_stat_id', '$arr_stat_id', '$datetime', '$trans_type', '$open_seats', '$price')";
        
        if ($conn->query($sql) === TRUE) {
            // Commit transaction
            $conn->commit();

            $sql2 = "INSERT INTO Drives (RouteID, VehicleID) 
                    VALUES ((SELECT MAX(RouteID) FROM Routes),'$vehicle')";

            if ($conn->query($sql2) === TRUE) {
                echo "<script>alert('Record created successfully');</script>";
                // Commit transaction
                $conn->commit();
                
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

    if (isset($_POST['delete_button'])){

        $routeID = $_POST['deleted_route'];
        

        $sql = "DELETE FROM Drives WHERE RouteID = '$routeID';";
        
        if ($conn->query($sql) === TRUE) {
            
            $conn->commit();

            $sql2 = "DELETE FROM Takes WHERE RouteID = '$routeID';";
            
            if ($conn->query($sql2) === TRUE) {
                // Commit transaction
                $conn->commit();

                $sql3 = "DELETE FROM Routes WHERE RouteID = '$routeID';";
                
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
