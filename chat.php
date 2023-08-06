<!DOCTYPE html>
<html>
    <head>
        <title>Mensapp</title>
        <meta http-equiv="X-UA-Compatible" content="IE-edge" charset="UTF-8">
		<meta name="description" content="content. coasi.">
		<meta name="author" content="Mensa Camp Dev Team">
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="style.css">
    </head>

    <body>

        <?php
            // $userid = $_SESSION["user"];
            $userid = 1;

            $conn = mysqli_connect("sql6.webzdarma.cz", "mensappwzcz5668", "*0Q22^zX29JC@p%e4DG0", "mensappwzcz5668");
            include 'navigation.php';

            $my_chats = mysqli_query($conn, "SELECT * FROM `chats` WHERE `user1` = '$userid' OR `user2` = '$userid' ORDER BY `last_message` DESC");
        ?>

        <div class="sidebar">
            <?php
                $chats_list = [];
                while ($row = mysqli_fetch_array($my_chats)) {
                    $tchat = $row["user1"]==$userid ? $row["user2"] : $row["user1"];
                    $tchatname = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `users` WHERE `id` = '$tchat'"))["fname"];
                    echo "<div><h3>$tchatname</h3></div><hr>";
                    array_push($chats_list, $row["id"]);
                }
                $chat_i = (isset($_GET["c"]) && in_array($chats_list, $_GET["c"]) == 1) ? $_GET["c"] : end($chats_list);
                $chat = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `chats` WHERE `id` = '$chat_i'"));
            ?>
        </div>

        <div class="main">
            <?php
                function message($msg, $side) {
                    echo '<div class="message ';
                    echo  $side ? "from" : "to";
                    echo "\">$msg</div>";
                }

                foreach (json_decode($chat["messages"]) as $message) {
                    message($message[1], $message[0] == $userid);
                }

                if (array_key_exists("m", $_POST)) {
                    $old = json_decode($chat["messages"]);
                    array_push($old, [$userid, $_POST["m"]]);
                    $new = json_encode($old, JSON_UNESCAPED_SLASHES);
                    // var_dump($new);
                    $date = date("Y-m-d");
                    mysqli_query($conn, "UPDATE `chats` SET `messages` = '$new', `last-message` = '$date' WHERE `id` = '$chat_i'"); 
                    message($_POST["m"], 1);
                }
            ?>
        </div>

        <div class="write">
            <form method="post">
                <button type="submit" class="submit"><img src="img/icons/send.png"></button>
                <input type="text" class="textbox" name="m">
            </form>
        </div>

        <br id="end">

    </body>
</html>