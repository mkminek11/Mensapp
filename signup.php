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
            <h2>Account creation</h2>
            <form action="create_account.php" method="post">
                <table>
                    <tr>
                        <td><label for="ma-login-password">First name:</label></td>
                        <td><input type="text" name="ma-login-fname"></td>
                    </tr>
                    <tr>
                        <td><label for="ma-login-password">Last name:</label></td>
                        <td><input type="text" name="ma-login-lname"></td>
                    </tr>
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
                            <button type="submit" name="submit" id="submit">Sign up</button>
                        </td>
                    </tr>
                </table>
            </form>
            <p style="font-size: small; text-align: center;">Already have an account? Log in <a href="index.php">here</a>.</p>
        </div>
    </body>
</html>