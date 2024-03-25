<!DOCTYPE html>
<html>
<head>
  <title>Go Button</title>
</head>
<body>
  <div style="border: 1px solid black; padding: 10px;">
    <button onclick="goToOtherPage()">GO</button>
  </div>

  <script>
    function goToOtherPage() {
      // Replace 'other.php' with the actual filename of your other page
      window.location.href = "index2.php";
    }
  </script>
</body>
</html>
