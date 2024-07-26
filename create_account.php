<?php
$fname    = $_POST["ma-login-fname"];
$lname    = $_POST["ma-login-lname"];
$email    = $_POST["ma-login-email"];
$password = md5($_POST["ma-login-password"]);


$conn = mysqli_connect("sql6.webzdarma.cz", "mensappwzcz5668", "*0Q22^zX29JC@p%e4DG0", "mensappwzcz5668");
$sql = "INSERT INTO users (fname, lname, email, password, type) VALUES ('$fname', '$lname', '$email', '$password', '0')";
mysqli_query($conn, $sql);
mysqli_close($conn);

echo "<script>window.location.assign('index.php?m=Account successfully created.');</script>";
?>