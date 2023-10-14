<!DOCTYPE html>
<html>
    <head>
        <title>Mensapp</title>
        <meta http-equiv="X-UA-Compatible" content="IE-edge" charset="UTF-8">
		<meta name="description" content="content. coasi.">
		<meta name="author" content="Mensa Camp Dev Team">
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="context_menu.css">
        <script src="dialog.js"></script>
        <script src="menu.js"></script>
        <script src="chat.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    
    <body id="chat">
        <iframe id="download" style="display:none;"></iframe>

        <dialog id="search">
            <main>
                <div class="row">
                    <h2>New chat</h2>
                    <button class="close-button" onclick="closeDialog('search')">&#x2716</button>
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

        <?php include 'navigation.php'; ?>

        <div style="display:none;" id="data">
            <?php
                $userid = $_SESSION["user"];
                // $userid = 1;
                
                $conn = mysqli_connect("sql6.webzdarma.cz", "mensappwzcz5668", "*0Q22^zX29JC@p%e4DG0", "mensappwzcz5668");
                $my_chats = mysqli_query($conn, "SELECT * FROM `chats` WHERE `user1` = '$userid' OR `user2` = '$userid' ORDER BY `last_message` DESC");
                
                $chats_list = [];
                while ($row = mysqli_fetch_array($my_chats)) {
                    $tchat = $row["user1"] == $userid ? $row["user2"] : $row["user1"];
                    // $tchat = $row["id"];
                    $tchatname = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `users` WHERE `id` = '$tchat'"));
                    array_push($chats_list, $tchatname);
                }
                
                $user2 = array_key_exists("i", $_GET) ? $_GET["i"] : $chats_list[0]["id"];

                echo $userid;
                echo "<br>";
                echo $user2;
                echo "<br>";
                echo mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `chats` WHERE (`user1` = '$userid' AND `user2` = '$user2') OR (`user1` = '$user2' AND `user2` = '$userid')"))["id"];
            ?>
        </div>

        <div class="sidebar">
            <div class="chats">
                <?php
                    foreach ($chats_list as $value) {
                        echo "<div class='chat'><h3><a href='chat.php?i=$value[id]'>$value[fname] $value[lname]</a></div>";
                    }
                    // $chat_i = (isset($_GET["c"]) && in_array($chats_list, $_GET["c"]) == 1) ? $_GET["c"] : end($chats_list);
                    // $chat = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `chats` WHERE `id` = '$chat_i'"));
                ?>
            </div>
            <button id="add-chat" onclick="showDialog('search')">+ New chat</button>
        </div>

        <div class="main" id="main">
            <div id="messages"></div>
        </div>

        <div id="attachments"><button onclick='cancel_all_attachments()' class="close-all" title="Cancel all attachments">&#x2716</button></div></div>

        <div class="write">
            <button><img class="material-symbols-rounded" src="img/icons/reaction.png"></button>
            <label for="file_upload"><img class="material-symbols-rounded" src="img/icons/attach_file.png" style="position:relative;left:50%;transform:translateX(-50%) rotate(45deg);"></label>
            <input type="file" id="file_upload" style="display:none;" onchange="attach(this.files);" name="file[]" multiple>
            <input type="text" class="textbox" name="m" id="textbox" autocomplete="off" onkeydown="if (event.keyCode == 13) post();"> <!-- On <enter> pressed, call `post()` -->
            <span id="reply_output"></span>
        </div>

        <div id="attachment-menu" trigger="">
            <a href="#" onclick="file_open(this.parentElement.getAttribute('trigger'));">
                <img src="img/icons/file_open.png" />
                Open
            </a>
            <a href="#" onclick="file_download(this.parentElement.getAttribute('trigger'));">
                <img src="img/icons/download.png" />
                Download
            </a>
        </div>

        <br id="end">

    </body>
</html>