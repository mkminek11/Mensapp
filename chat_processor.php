<?php

$conn = mysqli_connect("sql6.webzdarma.cz", "mensappwzcz5668", "*0Q22^zX29JC@p%e4DG0", "mensappwzcz5668");

if ($_REQUEST["p"] == "search")   {search();}
if ($_REQUEST["p"] == "messages") {messages();}
if ($_REQUEST["p"] == "post")     {post_message();}
if ($_REQUEST["p"] == "info")     {msg_info();}
if ($_REQUEST["p"] == "del")      {msg_delete();}


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

    $results = 0;
    while ($user = mysqli_fetch_array($found)) {
        echo "$user[fname] $user[lname]<br>";
        $results ++;
    }
    if ($results == 0) {echo '<font style="color: red; font-weight: 500;">No matching results</font>';}
}

function messages() {  // REQUIRES: user1, user2
    global $conn;

    $myuser = $_REQUEST["user1"];
    $user2 =  $_REQUEST["user2"];

    $chat = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `chats` WHERE (`user1` = '$myuser' AND `user2` = '$user2') OR (`user1` = '$user2' AND `user2` = '$myuser')"));

    $i = 0;
    foreach (json_decode($chat["messages"]) as $message) {
        if ($message[4] == "Visible") {message($message[1], $message[0] == $myuser, $i);}
        $i ++;
    }
}

function message($msg, $from, $i) {
    echo '<div id="msg'.$i.'" class="message ';
    if ($from) {
        echo 'from">
        <span class="message_content">'.$msg.'</span>
        <div class="context_menu" anchor="msg'.$i.'">
            <a title="Edit"   ><img class="material-symbols-rounded" src="img/icons/edit.png"     onclick=" edit('.$i.')"></a>
            <a title="Delete" ><img class="material-symbols-rounded" src="img/icons/delete.png"   onclick="
                                if (confirm(\'Do you really want to permanently delete this message?\')) {     del('.$i.');}"></a>
            <a title="Forward"><img class="material-symbols-rounded" src="img/icons/forward.png"  onclick="  fwd('.$i.')"></a>
            <a title="Reply"  ><img class="material-symbols-rounded" src="img/icons/reply.png"    onclick="reply('.$i.')"></a>
            <a title="React"  ><img class="material-symbols-rounded" src="img/icons/reaction.png" onclick="react('.$i.')"></a>
            <a title="Info"   ><img class="material-symbols-rounded" src="img/icons/info.png"     onclick=" info('.$i.')"></a>
        </div>';
    } else {
        echo 'to">
        <span class="message_content">'.$msg.'</span>
        <div class="context_menu" anchor="msg'.$i.'">
            <a title="Forward"><img class="material-symbols-rounded" src="img/icons/forward.png"  onclick="  fwd('.$i.')"></a>
            <a title="Reply"  ><img class="material-symbols-rounded" src="img/icons/reply.png"    onclick="reply('.$i.')"></a>
            <a title="React"  ><img class="material-symbols-rounded" src="img/icons/reaction.png" onclick="react('.$i.')"></a>
            <a title="Info"   ><img class="material-symbols-rounded" src="img/icons/info.png"     onclick=" info('.$i.')"></a>
        </div>';
    }
    // echo "<span class='message_content'>$msg</span>";
    echo "</div>";
}

function post_message() {  // REQUIRES: user1, user2, msg
    global $conn;
    $myuser = intval(trim($_REQUEST["user1"]));
    $user2  = intval(trim($_REQUEST["user2"]));
    $chat = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `chats` WHERE (`user1` = '$myuser' AND `user2` = '$user2') OR (`user1` = '$user2' AND `user2` = '$myuser')"));
    $chat_i = $chat["id"];

    $old = json_decode($chat["messages"]);
    $now = strtotime("now");
    array_push($old, [$myuser, $_REQUEST["msg"], $now, "Unedited"]);
    $new = addslashes(json_encode($old, JSON_UNESCAPED_SLASHES));
    // print_r($new);
    $date = date("Y-m-d");
    mysqli_query($conn, "UPDATE `chats` SET `messages` = '$new', `last_message` = '$date' WHERE `id` = '$chat_i'");
    /* echo "UPDATE `chats` SET `messages` = '$new', `last_message` = '$date' WHERE `id` = '$chat_i'"; */
}

function msg_info() {  // REQUIRES: chat_i, message
    global $conn;
    
    $chat_i  = $_REQUEST["chat_i"];
    $message = $_REQUEST["message"];
    $chat = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `chats` WHERE `id` = '$chat_i'"));

    // echo $message;
    echo json_encode(json_decode($chat["messages"])[$message]);

    // echo $message;
    // echo $chat_i;
    // print_r($_REQUEST);
}

function msg_delete() {  // REQUIRES: chat_i, message
    global $conn;

    $chat_i  = $_REQUEST["chat_i"];
    $message = $_REQUEST["message"];
    $chat = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `chats` WHERE `id` = '$chat_i'"));

    $m = json_decode($chat["messages"]);
    $m[$message][4] = "Deleted";
    $json = json_encode($m);

    // print_r($json);

    mysqli_query($conn, "UPDATE `chats` SET `messages` = '$json' WHERE `id` = '$chat_i'");
}

?>