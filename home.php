<!DOCTYPE html>
<html>

<head>
    <title>Testing HTML</title>
    <style>
    .filters {
        position: absolute;
        top: 10px;
        width: 75%;
        height: 100px; 
        left: 12.5%;
        background-color: #f0f0f0; /* Example background color */
        border: 1px solid #ccc; /* Example border */
        box-sizing: border-box; /* Ensure border and padding are included in width and height */
        padding: 10px; /* Example padding */
        z-index: 1000;
    }

    .container {
        margin-top: 150px;
        display: flex;
        justify-content: center;
        align-items: center;
        height: calc(100vh - 150px); /* Set the height of the container to the full viewport height */
    }

    table {
        width: 75%; /* Adjust width as needed */
        margin: 0 auto; /* Center the table horizontally */
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

    button[type="register"] {
        width: 100px; /* Set your desired width */
        padding: 10px; /* Add padding */
        background-color: #4CAF50; /* Set background color */
        color: white; /* Set text color */
        border: none; /* Remove border */
        border-radius: 5px; /* Add border radius */
        cursor: pointer; /* Add cursor style */
    }

    /* Hover style for the buttons */
    button[type="register"]:hover {
        background-color: #45a049; /* Change background color on hover */
    }

    /* Style for the button */
    .account-button {
            background-color: #42cbf5; 
            text-align: right;
            color: black; /* White text color */
            padding: 10px 20px; /* Padding around the text */
            border: none; /* No border */
            border-radius: 5px; /* Rounded corners */
            cursor: pointer; /* Cursor on hover */
            position: fixed; /* Fixed position */
            top: 20px; /* Distance from the top */
            right: 20px; /* Distance from the right */
            height: 75px;
            width: 8%;
            background-image: url('account-image.png'); /* Path to your image */
            background-size: 25%; /* Adjust the image size */
            background-repeat: no-repeat; /* Do not repeat the image */
            background-position: left; /* Center the image */
            background-origin: content-box;
        }

        /* Style for the button on hover */
        .account-button:hover {
            background-color: #267891; /* Darker green background color */
        }

    </style>

</head>

<body style="text-align:center;">

<div class="container">
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

<?php
$username=$_GET['username'];


// Prepare and execute query
function load_routes($conn, $text){
    
    $result = mysqli_query($conn, $text);

    // Check if query was successful

    if ($result) {
        // Display column names
        echo "<form id='registrationForm' action='' method='post'>";
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
        echo "<button type='register' name='register'>Register</button>";
        echo "</form>";

    } else {
        echo "Error: " . $conn->error;
    }
}


$text = "select s1.StationName as DepartureLocation, s2.StationName as ArrivalLocation, r.DepartureTime, r.TransportType, r.OpenSeats, r.Price, r.RouteID from routes r right join station s1 on r.DepartureLocationID = s1.StationID right join station s2 on r.ArrivalLocationID = s2.StationID";
$date_filter = "";
$vehicle_filter = "";
$depart_filter = "";
$arrive_filter = "";
$price_filter = "";

if (isset($_POST['apply_filter'])) {
    
    // Check if the date field is set and not empty
    if (isset($_POST['date']) && !empty($_POST['date'])) {
        // Echo the value of the date field
        $date_filter  = "(DepartureTime > '" . $_POST['date'] . " 00:00:00' AND DepartureTime < '" . $_POST['date'] . " 23:59:59')"; 
    }

    // Check if the vehicle field is set and not empty
    if (isset($_POST['vehicle']) && !empty($_POST['vehicle'])) {
        // Echo the value of the vehicle field
        $vehicle_filter = " (TransportType = '" . $_POST['vehicle'] . "')";
    }

    if (isset($_POST['dep_stat_id']) && !empty($_POST['dep_stat_id'])) {
        
        $depart_filter = " (DepartureLocationID = " . $_POST['dep_stat_id'] . ")";
    }

    if (isset($_POST['arr_stat_id']) && !empty($_POST['arr_stat_id'])) {
        
        $arrive_filter = " (ArrivalLocationID = " . $_POST['arr_stat_id'] . ")";
    }

    if (isset($_POST['price']) && !empty($_POST['price'])) {
        
        $price_filter = " (Price < " . $_POST['price'] . ")";
    }
    
    // Construct the SQL query based on the applied filters
    $filters = [];
    if ($date_filter != "") {
        $filters[] = $date_filter;
    }
    if ($vehicle_filter != "") {
        $filters[] = $vehicle_filter;
    }
    if ($depart_filter != "") {
        $filters[] = $depart_filter;
    }
    if ($arrive_filter != "") {
        $filters[] = $arrive_filter;
    }
    if ($price_filter != "") {
        $filters[] = $price_filter;
    }

    // Apply active filters
    if (!empty($filters)) {
        $text .= " WHERE " . implode(" AND ", $filters);
        #echo "<p>" . $text . "<p>";
        load_routes($conn, $text);
        
    } else {
        $text = "select s1.StationName as DepartureLocation, s2.StationName as ArrivalLocation, r.DepartureTime, r.TransportType, r.OpenSeats, r.Price, r.RouteID from routes r right join station s1 on r.DepartureLocationID = s1.StationID right join station s2 on r.ArrivalLocationID = s2.StationID";
        load_routes($conn, $text);
    }

} else {
    $text = "select s1.StationName as DepartureLocation, s2.StationName as ArrivalLocation, r.DepartureTime, r.TransportType, r.OpenSeats, r.Price, r.RouteID from routes r right join station s1 on r.DepartureLocationID = s1.StationID right join station s2 on r.ArrivalLocationID = s2.StationID";
    load_routes($conn, $text);
}

// Check if the register button is clicked
if (isset($_POST['register'])) {
    // Check if any rows are selected
    if (isset($_POST['row']) && !empty($_POST['row'])) {
        // Loop through selected rows
        foreach ($_POST['row'] as $rowId) {
            
            $query = "INSERT INTO Takes (PassengerID, RouteID) VALUES ((SELECT PassengerID FROM Passenger WHERE username ='$username'),'$rowId')";
            
            if ($conn->query($query) === TRUE) {

                echo "<script>alert('Registered for Route!');</script>";
                // Commit transaction
                $conn->commit();
                
            } else {
                echo "<script>alert('Error: " . $sql . '\\n' . $conn->error . "');</script>";
                // Rollback transaction
                $conn->rollback();
            }
        }

    } else {
        echo 'No rows selected.';
    }
}


// Close connection

?>
</div>

<div class="filters">
    <p>Filters</p>
    <form action="" method="post" id="filters">

        <label>Date:</label>
        <input type="date" id="date" name="date">

        <label>Vehicle:</label>
        <select name ="vehicle">
            <option value="">Select Vehicle</option>
            <option value='Train'>Train</option>
            <option value='Bus'>Bus</option>
            <option value='Plane'>Plane</option>
            <option value='Subway'>Subway</option>
        </select>

        <label>Depart:</label>
        <select name="dep_stat_id">
            <option value="">Select Departure Location</option>
            <?php
                $query = "SELECT StationID, StationName FROM Station;";
                $result = mysqli_query($conn, $query);
                
                if ($result) {
                    
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Generate an option for each row
                        echo "<option value='{$row['StationID']}'>{$row['StationName']}</option>";
                    }
                } else {
                    echo "<option value=''>Error</option>";
                }
            ?>
        </select>

        <label>Arrive: </label>
        <select name="arr_stat_id">
            <option value="">Select Arrival Location</option>
            <?php
                $query = "SELECT StationID, StationName FROM Station;";
                echo "<p>" . $query . "<p>";
                $result = mysqli_query($conn, $query);
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Generate an option for each row
                        echo "<option value='{$row['StationID']}'>{$row['StationName']}</option>";
                    }
                }
            ?>
        </select>

        <label>Max Price: $</label>
        <input type="text" style="width:25px;" id="price" name="price" placehonder="1000.00">

        <button type='submit' name='apply_filter'>Apply Filter</button>
    </form>
</div>

<form action="account.php?username=$username" method="get">
        <button type="submit" class="account-button">Your Account</button>
</form>



</body>
</html>
