var data = document.getElementById("data").innerHTML.split("<br>");
var myuser = data[0].trim();
var user2  = data[1].trim();
var chat_i = data[2].trim();

function chat_processor_request(process, args, fun) {
    var arg = [];
    for (const [key, value] of Object.entries(args)) {arg.push("&" + key.toString() + "=" + value.toString());}

    var xhttp = new XMLHttpRequest();
    xhttp.open("GET", "chat_processor.php?p="+process + arg.join(""), true);
    xhttp.onload = function () {
        fun(this.responseText.split("<!--WZ-REKLAMA-1.0IK-->")[1]);
    }
    xhttp.send();
}

function update_messages(args=null) {
    var xhttp = new XMLHttpRequest();
    xhttp.open("GET", "chat_processor.php?p=messages&user1="+myuser+"&user2="+user2, true);
    xhttp.onload = function () {
        document.getElementById("main").innerHTML = this.responseText.split("<!--WZ-REKLAMA-1.0IK-->")[1];
    }
    xhttp.send();
}

function search() {
    let search_name = document.getElementById("search-name");
    if (!/^\s*$/.test(search_name.value)) {
        var xhttp = new XMLHttpRequest();
        xhttp.open("GET", "chat_processor.php?p=search&query="+search_name.value, true);
        xhttp.onload = function () {
            document.getElementById("output").innerHTML = this.responseText.split("<!--WZ-REKLAMA-1.0IK-->")[1];
        }
        xhttp.send();
    } else {
        document.getElementById("output").innerHTML = "";
    }
}

function post() {
    let value = document.getElementById("textbox").value;
    if (!/^\s*$/.test(value)) {
        var xhttp = new XMLHttpRequest();
        xhttp.open("GET", "chat_processor.php?p=post&user1="+myuser+"&user2="+user2+"&msg="+value, true);
        xhttp.onload = function () {
            // document.getElementById("main").innerHTML = this.responseText.split("<!--WZ-REKLAMA-1.0IK-->")[1];
            update_messages();
            document.getElementById("textbox").value = "";

        }
        xhttp.send();
    }
}

function  edit(i) {chat_processor_request("edit",  {"id": i}, console.log);}
function   del(i) {chat_processor_request("del",   {"chat_i": chat_i, "message": i}, update_messages);}
function   fwd(i) {chat_processor_request("fwd",   {"id": i}, console.log);}
function reply(i) {chat_processor_request("reply", {"id": i}, console.log);}
function react(i) {chat_processor_request("react", {"id": i}, console.log);}
function  info(i) {chat_processor_request("info",  {"chat_i": chat_i, "message": i}, format_info);}

const message_shown_length = 30;

function format_info(text) {
    console.log(text)
    let x = JSON.parse(text);
    let message = (x[1].length > message_shown_length) ? x[1].substring(0, message_shown_length-3) + "..." : x[1];
    let utc = new Date(1000 * x[2]);

    let time = utc.getDate() + ". " + (utc.getMonth()+1) + ". " + utc.getFullYear() + ", " + utc.getHours() + ":" + utc.getMinutes();

    var utcSeconds = x[2];
    var d = new Date(0);
    d.setUTCSeconds(utcSeconds);

    alert("Message: " + message + "\nPosted: " + time + "\n" + x[3] + "\n" + x[4]);
}