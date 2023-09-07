<html>
    <head>
        <title>Mensapp</title>
        <meta http-equiv="X-UA-Compatible" content="IE-edge" charset="UTF-8">
		<meta name="description" content="content. coasi.">
		<meta name="author" content="Mensa Camp Dev Team">
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body class="index">
        <div class="content">
            <h2>Welcome to Mensapp</h2>
            <form action="index.php" method="post">
                <table>
                    <tr>
                        <td><label for="ma-login-email">Email:</label></td>
                        <td><input type="email" name="ma-login-email"></td>
                    </tr>
                    <tr>
                        <td><label for="ma-login-password">Password:</label></td>
                        <td><input type="password" name="ma-login-password"></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <button type="submit" name="submit" id="submit">Log in</button>
                        </td>
                    </tr>
                </table>
            </form>
            <p style="font-size: small; text-align: center;">Don't have an account? Sign up <a href="signup.php">here</a>.</p>
            <?php
            if (array_key_exists("ma-login-email", $_POST)) {
                $email    = $_POST["ma-login-email"];
                $password = md5($_POST["ma-login-password"]);
                
                $conn = mysqli_connect("sql6.webzdarma.cz", "mensappwzcz5668", "*0Q22^zX29JC@p%e4DG0", "mensappwzcz5668");
                $sql = "SELECT * FROM `users` WHERE `email`='$email' AND `password`='$password'";
                $user = mysqli_query($conn, $sql);
                mysqli_close($conn);
                
                if (mysqli_num_rows($user)) {

                    session_start();
                    $_SESSION["user"] = mysqli_fetch_array($user)["id"];
                    $_SESSION["expire"] = strtotime("Next hour");
                
                    echo "<script>window.location.replace('projects.php');</script>";
                } else {
                    echo "<p style=\"text-align: center; color: red;\">Wrong password.</p>";
                    // echo $password;
                }
            }

            if (array_key_exists("m", $_GET)) {
                echo "<p style=\"text-align: center; color: red;\">$_GET[m]</p>";
            }
            // echo "<p style=\"text-align: center; color: red;\">$_GET[m]</p>";
            ?>
        </div>
        <br id="end">
    </body>
</html>