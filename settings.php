<!DOCTYPE html lang="en">
<html>
    <head>
        <title>Mensapp</title>
		<meta name="description" content="content. coasi.">
		<meta name="author" content="Mensa Camp Dev Team">
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="style.css">
        <!-- <link rel="stylesheet" href="style-dark.css"> -->
    </head>

    <body class="settings">

        <?php include 'navigation.php'; ?>
        
        <div class="content">
            <form action="save-settings.php" method="post">
                <table>
                    <tr><td colspan="2"><h3>App</h3></td></tr>
                    <tr><td><label for="nav-show">Color theme:</label></td><td><select name="nav-show">
                        <option value="0">Light (default)</option>
                        <option value="1">Dark</option>
                        <option value="2">High contrast</option>
                    </select></td></tr>
                    <tr><td><label for="nav-show">Show in navigation:</label></td><td><select name="nav-show">
                        <option value="0">Just icons</option>
                        <option value="1">Just text</option>
                        <option value="2">Text and icons</option>
                    </select></td></tr>
                </table>
                <button type="submit">Save changes</button>
            </form>
        </div>

        <br id="end">
        
    </body>
</html>