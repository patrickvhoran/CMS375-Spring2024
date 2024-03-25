<!DOCTYPE html>
<html>

<head>
    <title>
        Testing HTML
    </title>
</head>

<body style="text-align:center;">

<?php
// Check if the form has been submitted
if (isset($_POST['submit'])) {
    // Get the input text
    $text = $_POST['textInput'];
    // Display the input text above the form
    echo "<p>$text</p>";
}


?>

<form method="post">
    <input type="text" id="textInput" name="textInput" placehonder="Enter:"><br><br>
    <input type="submit" name="submit" value="Submit">
	<br>
</form>
<form action="edward.php" method="post">
  <button type="submit">Go</button>
</form>

</body>
</html>