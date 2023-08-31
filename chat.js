var data = document.getElementById("data").innerHTML.split("<br>");
var myuser = data[0];
var user2  = data[1];

function update_messages() {
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