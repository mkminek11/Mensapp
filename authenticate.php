<?php
$email    = $_POST["ma-login-email"];
$password = $_POST["ma-login-password"];

$conn = mysqli_connect("sql6.webzdarma.cz", "mensappwzcz5668", "*0Q22^zX29JC@p%e4DG0", "mensappwzcz5668");
$sql = "SELECT * FROM `users` WHERE `email`='$email' AND `password`='$password'";
$user = mysqli_query($conn, $sql);
mysqli_close($conn);

if (mysqli_num_rows($user)) {
    
    session_start();
    $_SESSION["user"] = mysqli_fetch_array($user)["id"];
    echo "<script>window.location.replace('projects.php');</script>";
} else {
    echo "<script>window.location.replace('index.php?m=Wrong password');</script>";
}
?>