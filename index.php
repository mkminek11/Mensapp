<html>
    <head>
        <title>Mensapp</title>
        <meta http-equiv="X-UA-Compatible" content="IE-edge" charset="UTF-8">
		<meta name="description" content="content. coasi.">
		<meta name="author" content="Mensa Camp Dev Team">
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="style.css">
    </head>
    <body class="index">
        <div class="content">
            <h2>Welcome to Mensapp</h2>
            <form action="authenticate.php" method="post">
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
            <p style="font-size: small; text-align: center;">Don't have an account? Sign up <a href="signup.html">here</a>.</p>
            <?php echo "<p style=\"text-align: center; color: red;\">$_GET[m]</p>"; ?>
        </div>
    </body>
</html>