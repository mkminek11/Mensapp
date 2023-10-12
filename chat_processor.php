<?php

$conn = mysqli_connect("sql6.webzdarma.cz", "mensappwzcz5668", "*0Q22^zX29JC@p%e4DG0", "mensappwzcz5668");

if ($_REQUEST["p"] == "search")   {search();}
if ($_REQUEST["p"] == "messages") {messages();}
if ($_REQUEST["p"] == "post")     {post_message();}
if ($_REQUEST["p"] == "upload")   {upload();}

if ($_REQUEST["p"] == "info")     {msg_info();}
if ($_REQUEST["p"] == "del")      {msg_delete();}
if ($_REQUEST["p"] == "edit")     {msg_edit();}


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
        if ($message[4] == "Visible") {message($message[1], $message[0] == $myuser, $i, $message[5]);}
        $i ++;
    }
}

function trim_file(string $file_name, int $max_length = 20) {
    $ff = end(explode($file_name, "."));
    $end = strlen($ff) + 5;
    return (strlen($file_name) <= $max_length) ? ($file_name) : (substr($file_name, 0, $max_length - $end - 3) . "..." . substr($file_name, -$end));
}

function message(string $msg, bool $from, int $i, string $att_json) {
    // "[[\"00000.txt\",\"fonty.txt\"]]"
    $a_names = json_decode($att_json);
    $attachments = [];
    foreach ($a_names as $data) {
        array_push($attachments, "<button class='attachment' onclick='window.open(\"img/user_upload/$data[0]\", \"_blank\")'>" . trim_file($data[1]) . "</button>");
    }

    echo '<div id="msg'.$i.'" class="message ' . ($from ? 'from' : 'to') . '">
            <div class="message_content"><span class="message_text">' . $msg . '</span>' . join("", $attachments) .'</div>
            <div class="context_menu" anchor="msg'.$i.'">';

    if ($from) {
        echo '
            <a title="Edit"   ><img class="material-symbols-rounded" src="img/icons/edit.png"     onclick=" edit('.$i.')"></a>
            <a title="Delete" ><img class="material-symbols-rounded" src="img/icons/delete.png"   onclick="
                                if (confirm(\'Do you really want to permanently delete this message?\')) {   del('.$i.');}"></a>';
    }

    echo '
            <a title="Forward"><img class="material-symbols-rounded" src="img/icons/forward.png"  onclick="  fwd('.$i.')"></a>
            <a title="Reply"  ><img class="material-symbols-rounded" src="img/icons/reply.png"    onclick="reply('.$i.')"></a>
            <a title="React"  ><img class="material-symbols-rounded" src="img/icons/reaction.png" onclick="react('.$i.')"></a>
            <a title="Info"   ><img class="material-symbols-rounded" src="img/icons/info.png"     onclick=" info('.$i.')"></a>
        </div>';

    // echo "<span class='message_content'>$msg</span>";
    echo "</div>";
}

function post_message() {  // REQUIRES: user1, user2, msg
    if (!empty($_FILES)) {
        upload();
    } else {
        _post_message_2("none");
    }
}

function _post_message_2($attachments) {
    global $conn;
    $myuser = intval(trim($_REQUEST["user1"]));
    $user2  = intval(trim($_REQUEST["user2"]));
    $chat = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `chats` WHERE (`user1` = '$myuser' AND `user2` = '$user2') OR (`user1` = '$user2' AND `user2` = '$myuser')"));
    $chat_i = $chat["id"];

    $old = json_decode($chat["messages"]);
    $now = strtotime("now");
    array_push($old, [
        $myuser,
        $_REQUEST["msg"],
        $now,
        "Unedited",
        "Visible",
        $attachments
    ]);
    $new = addslashes(json_encode($old, JSON_UNESCAPED_SLASHES));
    $date = date("Y-m-d h:i:s");
    mysqli_query($conn, "UPDATE `chats` SET `messages` = '$new', `last_message` = '$date' WHERE `id` = '$chat_i'");
}



function msg_info() {        // REQUIRES: chat_i, message
    global $conn;
    
    $chat_i  = $_REQUEST["chat_i"];
    $message = $_REQUEST["message"];
    $chat = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `chats` WHERE `id` = '$chat_i'"));

    echo json_encode(json_decode($chat["messages"])[$message]);
}

function msg_delete() {      // REQUIRES: chat_i, message
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

function msg_edit() {        // REQUIRES: chat_i, message, new
    $new = $_REQUEST["new"];

    if ($new == "null" || $new == "") {return;}

    global $conn;

    $chat_i  = $_REQUEST["chat_i"];
    $message = $_REQUEST["message"];

    $chat = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `chats` WHERE `id` = '$chat_i'"));

    $m = json_decode($chat["messages"]);
    $m[$message][1] = $new;
    $m[$message][3] = "Edited " . date("d. m. Y");

    $json = json_encode($m);

    mysqli_query($conn, "UPDATE `chats` SET `messages` = '$json' WHERE `id` = '$chat_i'");
}



function upload() {
    $files_count = count($_FILES["file"]["name"]);

    $target_dir = "img/user_upload/";
    $attachments = array();


    for ($i = 0; $i < $files_count; $i ++) {
        global $conn;

        $in_folder = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `media`"));

        $file_type = end(explode(".", $_FILES["file"]["name"][$i]));
        echo $file_type;
        $file_name = sprintf('%05d', $in_folder) . "." . $file_type;
        $org_name = $_FILES["file"]["name"][$i];
        // basename($_FILES["file"]["name"][$i])

        $target_file_path = $target_dir . $file_name;

        if (move_uploaded_file($_FILES["file"]["tmp_name"][$i], $target_file_path)) {
            mysqli_query($conn, "INSERT INTO `media` (`org_name`, `file`) VALUES ('$org_name', '$file_name')");
            array_push($attachments, [$file_name, $org_name]);
        }
    }

    _post_message_2(json_encode($attachments));
}



session_start();
$_SESSION["expire"] = strtotime("Next hour");

?>