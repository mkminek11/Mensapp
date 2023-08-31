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
    
    <body onload="update_messages()" id="chat">
        <?php include 'navigation.php'; ?>

        <div style="display:none;" id="data">
            <?php
                // $userid = $_SESSION["user"];
                $userid = 1;
                $user2  = 2;

                $conn = mysqli_connect("sql6.webzdarma.cz", "mensappwzcz5668", "*0Q22^zX29JC@p%e4DG0", "mensappwzcz5668");
                $my_chats = mysqli_query($conn, "SELECT * FROM `chats` WHERE `user1` = '$userid' OR `user2` = '$userid' ORDER BY `last_message` DESC");

                echo $userid;
                echo "<br>";
                echo $user2;
            ?>
        </div>

        <dialog id="dialog">
            <main>
                <div class="row">
                    <h2>New chat</h2>
                    <button class="close-button" onclick="closeDialog()">&#x2716</button>
                </div>
                <div class="row">
                    Search for a person:
                </div>
                <div class="row">
                    <input type="text" placeholder="John Doe" id="search-name" name="find_user" autofocus autocomplete="off" onkeyup="search()">
                </div>
                <hr>
                <div class="row">
                    <output id="output"></output>
                </div>
            </main>
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
                    }
                    $chat_i = (isset($_GET["c"]) && in_array($chats_list, $_GET["c"]) == 1) ? $_GET["c"] : end($chats_list);
                    $chat = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `chats` WHERE `id` = '$chat_i'"));*/
                ?>
            </div>
            <button id="add-chat" onclick="showDialog()">+ New chat</button>
        </div>

        <div class="main" id="main">
            
        </div>

        <div class="write">
            <button class="submit" onclick="post()"><img src="img/icons/send.png"></button>
            <input type="text" class="textbox" name="m" id="textbox" autocomplete="off">
        </div>

        <script src="chat.js"></script>
        <br id="end">

    </body>
</html>