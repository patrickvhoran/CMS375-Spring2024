<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Form</title>
    <style>
    /* Add styles for the blue banner */
    .blue-banner {
        position: relative;
        z-index: 2;
        background-color: #007bff; /* Blue color */
        color: white;
        padding: 10px 0;
        text-align: center;
        position: relative; /* Needed for absolute positioning of the image */
    }
    /* Center the buttons and add space between them */
    form {
        text-align: center;
        margin: 20px 0;
    }
    
    button {
        font-size: 1.5em; /* Make buttons 3 times bigger */
        background-color: 
        margin: 10px; /* Add space between buttons */
        padding: 10px; /* Add padding */
        background-color: #007bff; /* Set background color */
        color: white; /* Set text color */
        border: none; /* Remove border */
        border-radius: 5px; /* Add border radius */
        cursor: pointer; /* Add cursor style */
    }

    /* Hover style for the buttons */
    button:hover {
        background-color: #204685; /* Change background color on hover */
    }
    
    /* Style for the image in the top right corner */
    .top-right-image {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 190px; /* Adjust the width as needed */
        height: auto; /* This will maintain the aspect ratio */
    }

    .back-button {
        position: absolute;
        top: 20px;
        left: 20px;
        width: 30px;
        height: 30px;
    }
    
       
    </style>
</head>

<body>
    
    <!-- Blue banner to hold the title and the image -->
    <div class="blue-banner">
        <a href="start_page.php" >
            <img src="back-button.png" alt="Button Image" class="back-button">
        </a>
        <h1>Welcome to Transportation Admin</h1>
        <img src="https://fdotwww.blob.core.windows.net/sitefinity/images/default-source/content1/info/logo/png/fdot_logo_color.png?sfvrsn=293c15a8_2" alt="Logo" class="top-right-image">
    </div>
    <!-- Button to login page -->
    <form action="insert_route.php" method="get">
        <button type="submit">Manage Routes</button>
    </form>
    
    <!-- Button to create account page -->
    <form action="insert_vehicle.php" method="get">
        <button type="submit">Manage Vehicles</button>
    </form>

    <!-- Button to admin page -->
    <form action="insert_station.php" method="get">
        <button type="submit">Manage Stations</button>
    </form>
</body>

</html>