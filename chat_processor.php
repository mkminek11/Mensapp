<?php

$conn = mysqli_connect("sql6.webzdarma.cz", "mensappwzcz5668", "*0Q22^zX29JC@p%e4DG0", "mensappwzcz5668");

if ($_REQUEST["p"] == "search")   {search();}
if ($_REQUEST["p"] == "messages") {messages();}
if ($_REQUEST["p"] == "post")     {post_message();}


function search() {  // REQUIRES: query
    global $conn;

    $username = $_REQUEST["query"];
    $user_first_name = explode(" ", $username)[0];
    $user_last_name = end(explode(" ", $username));

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

function messages() {  // REQUIRES: user1, user2
    global $conn;

    $myuser = $_REQUEST["user1"];
    $user2 =  $_REQUEST["user2"];

    $chat = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `chats` WHERE (`user1` = '$myuser' AND `user2` = '$user2') OR (`user1` = '$user2' AND `user2` = '$myuser')"));

    foreach (json_decode($chat["messages"]) as $message) {
        message($message[1], $message[0] == $myuser);
    }
}

function message($msg, $from) {
    echo '<div class="message ';
    if ($from) {
        echo 'from">
        <div class="context_menu" length="6">
            <a title="Edit"   ><img class="material-symbols-rounded" src="img/icons/edit.png"    ></a>
            <a title="Delete" ><img class="material-symbols-rounded" src="img/icons/delete.png"  ></a>
            <a title="Forward"><img class="material-symbols-rounded" src="img/icons/forward.png" ></a>
            <a title="Reply"  ><img class="material-symbols-rounded" src="img/icons/reply.png"   ></a>
            <a title="React"  ><img class="material-symbols-rounded" src="img/icons/reaction.png"></a>
            <a title="Info"   ><img class="material-symbols-rounded" src="img/icons/info.png"    ></a>
        </div>';
    } else {
        echo 'to">
        <div class="context_menu" length="4">
            <a title="Forward"><img class="material-symbols-rounded" src="img/icons/forward.png" ></a>
            <a title="Reply"  ><img class="material-symbols-rounded" src="img/icons/reply.png"   ></a>
            <a title="React"  ><img class="material-symbols-rounded" src="img/icons/reaction.png"></a>
            <a title="Info"   ><img class="material-symbols-rounded" src="img/icons/info.png"    ></a>
        </div>';
    }
    echo "<span class='message_content'>$msg</span>";
    echo "</div>";
}

function post_message() {  // REQUIRES: user1, user2, msg
    global $conn;
    $myuser = intval(trim($_REQUEST["user1"]));
    $user2  = intval(trim($_REQUEST["user2"]));
    $chat = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `chats` WHERE (`user1` = '$myuser' AND `user2` = '$user2') OR (`user1` = '$user2' AND `user2` = '$myuser')"));
    $chat_i = $chat["id"];

    $old = json_decode($chat["messages"]);
    array_push($old, [$myuser, $_REQUEST["msg"]]);
    $new = addslashes(json_encode($old, JSON_UNESCAPED_SLASHES));
    // print_r($new);
    $date = date("Y-m-d");
    mysqli_query($conn, "UPDATE `chats` SET `messages` = '$new', `last_message` = '$date' WHERE `id` = '$chat_i'");
    /* echo "UPDATE `chats` SET `messages` = '$new', `last_message` = '$date' WHERE `id` = '$chat_i'"; */
}

?>