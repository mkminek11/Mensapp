<?php
$fname    = $_POST["ma-login-fname"];
$lname    = $_POST["ma-login-lname"];
$email    = $_POST["ma-login-email"];
$password = $_POST["ma-login-password"];

$conn = mysqli_connect("sql6.webzdarma.cz", "mensappwzcz5668", "*0Q22^zX29JC@p%e4DG0", "mensappwzcz5668");
$sql = "INSERT INTO users (fname, lname, email, password) VALUES ('$fname', '$lname', '$email', '$password')";
mysqli_query($conn, $sql);
mysqli_close($conn);

echo "<h2>Account successfully created.</h2>";

echo "<button onclick=\"window.location.replace('projects.html');\">OK</button>";
?>