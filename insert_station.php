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
        <h2>Add Station</h2>
        <form method="post" id="station_form">
            
            <label>Station Name:</label>
            <input type="text" id = "station_name" name="station_name" placeholder=" Ex: Grand Central Station" required><br>

            <label>Number of Gates</label>
            <input type="number" id="gates" name="gates" min="1" max="100" step="1">
            
            <input type="submit" name="submit_station" value="Submit">
        </form>
    </div>

    <div class="form-container">
        <h3>Delete Station</h3>
            <form method="post" id="delete_form">
                <label>Select Station</label>
                <select name="deleted_station" required>
                    <option value="">----</option>
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
                    </select>
                <input type="submit" name="delete_button" value="Delete">
            </form>
    </div>



    <script>
    document.getElementById("station_form").addEventListener("submit", function(event) {
    var confirmation = confirm('Station:\n\n' + 
        'Station Name: ' + document.getElementsByName('station_name')[0].value + '\n' +
        'Gates: ' + document.getElementsByName('gates')[0].value + '\n\n' +
        'Do you want to confirm?');
    if (!confirmation) {
        event.preventDefault();
    }
    });
    
    document.getElementById("delete_form").addEventListener("submit", function(event) {
    var confirmation = confirm('Please confirm that you would like to delete Station #' +
        document.getElementsByName('deleted_station')[0].value + '.\n' +
        'This action cannot be undone');
    if (!confirmation) {
        event.preventDefault();
    }
    });
    </script>

    <?php
    // Check if station form is submitted
    if (isset($_POST['submit_station'])) {
        
        // Extract route information from the form data
        $station_name = $_POST['station_name'];
        $gates = $_POST['gates'];
        
        // Start transaction
        $conn->begin_transaction();
        
        // Execute SQL query to insert data into database
        
        $sql = "INSERT INTO Station (StationName, Gates) 
                VALUES ('$station_name', '$gates')";
        
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

        $stationID = $_POST['deleted_station'];

        $sql = "DELETE FROM Routes WHERE DepartureLocationID = '$stationID';";

        if ($conn->query($sql) === TRUE) {
            
            $conn->commit();

            $sql2 = "DELETE FROM Routes WHERE ArrivalLocationID = '$stationID';";

            if ($conn->query($sql2) === TRUE) {
                // Commit transaction
                $conn->commit();

                $sql3 = "DELETE FROM Station WHERE StationID = '$stationID';";

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
