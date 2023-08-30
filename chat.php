<?php
    /*// $userid = $_SESSION["user"];
    $userid = 1;

    $conn = mysqli_connect("sql6.webzdarma.cz", "mensappwzcz5668", "*0Q22^zX29JC@p%e4DG0", "mensappwzcz5668");
    $my_chats = mysqli_query($conn, "SELECT * FROM `chats` WHERE `user1` = '$userid' OR `user2` = '$userid' ORDER BY `last_message` DESC");

    $find_user = false;

    if (array_key_exists("find_user", $_GET)) {
        $find_user = true;
        $username = $_GET["find_user"];
        $user_first_name = explode(" ", $username)[0];
        $user_last_name = end(explode(" ", $username));
    }

    function message($msg, $side) {
        echo '<div class="message ';
        echo  $side ? "from" : "to";
        echo "\">$msg</div>";
    }

    $chat_i = 1;

    $chat = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `chats` WHERE `id` = '$chat_i'"));

    if (array_key_exists("m", $_POST)) {
        $old = json_decode($chat["messages"]);
        array_push($old, [$userid, $_POST["m"]]);
        $new = addslashes(json_encode($old, JSON_UNESCAPED_SLASHES));
        $date = date("Y-m-d");
        mysqli_query($conn, "UPDATE `chats` SET `messages` = '$new', `last_message` = '$date' WHERE `id` = '$chat_i'");
        // echo "UPDATE `chats` SET `messages` = '$new', `last_message` = '$date' WHERE `id` = '$chat_i'";
        header("Location: http://mensapp.wz.cz/chat.php");
        exit();
    } else {
        echo "Else";
    }*/
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Mensapp</title>
        <meta http-equiv="X-UA-Compatible" content="IE-edge" charset="UTF-8">
		<meta name="description" content="content. coasi.">
		<meta name="author" content="Mensa Camp Dev Team">
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="style.css">
        <script src="dialog.js"></script>
    </head>
    
    <body <?php echo $find_user ? "onload='showDialog()'" : "onload='closeDialog()'"; ?>>

        <?php include 'navigation.php'; ?>

        <dialog id="dialog">
            <form action="chat.php" method="get">
                <div class="row">
                    <h2>New chat</h2>
                    <a href="chat.php" class="close-button">&#x2716</a>
                </div>
                <div class="row">
                    Search for a person:
                </div>
                <div class="row">
                    <input type="text" placeholder="John Doe" id="search-name" name="find_user"<?php echo $find_user ? " value='$username'" : "" ?> autofocus autocomplete="off">
                    <button class="search" type="submit"><img src="img/icons/search.png"></button>
                </div>
                <hr>
                <div class="row">
                <output>
                    <?php
                        if ($find_user) {
                            $conn = mysqli_connect("sql6.webzdarma.cz", "mensappwzcz5668", "*0Q22^zX29JC@p%e4DG0", "mensappwzcz5668");
                            $found = mysqli_query($conn, "SELECT * FROM `users` WHERE
                                `fname` LIKE '%$username%' OR
                                `fname` LIKE '%$user_first_name%' OR
                                `fname` LIKE '%$user_last_name%' OR
                                `lname` LIKE '%$username%' OR
                                `lname` LIKE '%$user_first_name%' OR
                                `lname` LIKE '%$user_last_name%'");

                            while ($user = mysqli_fetch_array($found)) {
                                echo "$user[fname] $user[lname]<br>";
                            }
                        }
                    ?>
                </output>
                </div>
            </form>
        </dialog>

        <div class="sidebar">
            <div class="chats">
                <?php
                    /*$chats_list = [];
                    while ($row = mysqli_fetch_array($my_chats)) {
                        $tchat = $row["user1"]==$userid ? $row["user2"] : $row["user1"];
                        $tchatname = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `users` WHERE `id` = '$tchat'"))["fname"];
                        echo "<div class='chat'><h3>$tchatname</h3></div>";
                        array_push($chats_list, $row["id"]);
                    }*/
                    // $chat_i = (isset($_GET["c"]) && in_array($chats_list, $_GET["c"]) == 1) ? $_GET["c"] : end($chats_list);
                    // $chat = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `chats` WHERE `id` = '$chat_i'"));
                ?>
            </div>
            <button id="add-chat" onclick="showDialog()">+ New chat</button>
        </div>

        <div class="main">
            <?php
                /*foreach (json_decode($chat["messages"]) as $message) {
                    message($message[1], $message[0] == $userid);
                }*/
            ?>
        </div>

        <div class="write">
            <form method="post">
                <button type="submit" class="submit"><img src="img/icons/send.png"></button>
                <input type="text" class="textbox" name="m" autocomplete="off">
            </form>
        </div>

        <br id="end">

    </body>
</html>