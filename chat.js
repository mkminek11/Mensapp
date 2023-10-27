var data, myuser, user2, chat_i, replying, attachments_count, attachment_files, message_shown_length;

window.addEventListener("load", function () {

    data = document.getElementById("data").innerHTML.split("<br>");
    myuser = data[0].trim();
    user2  = data[1].trim();
    chat_i = data[2].trim();

    replying = null;
    attachments_count = 0;
    attachment_files = [];

    message_shown_length = 30;

    update_messages();
});


function chat_processor_request(process, args, fun) {
    var arg = [];
    for (const [key, value] of Object.entries(args)) {arg.push("&" + key + "=" + value);}

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
        document.getElementById("messages").innerHTML = this.responseText.split("<!--WZ-REKLAMA-1.0IK-->")[1];
        for (const element of document.querySelectorAll(".attachment")) {
            bind_menu(element, "attachment-menu");
        }
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
    if (!/^\s*$/.test(value)) {  // if message is neither empty nor made just out of spaces
        const xhr = new XMLHttpRequest();
        const fd  = new FormData();
        const f   = document.querySelector("#file_upload");
        
        for (const file of f.files) {
            fd.append("file[]", file, file.name)
        }

        xhr.open("POST", "chat_processor.php?p=post&user1="+myuser+"&user2="+user2+"&msg="+value);
        xhr.onload = function () {
            console.log(this.responseText.split("<!--WZ-REKLAMA-1.0IK-->")[1]);
            update_messages();
            cancel_reply();
        }

        xhr.send(fd);

        cancel_all_attachments();
        document.querySelector("#textbox").value = "";
    }
}

function  info(i) {chat_processor_request("info",  {"chat_i": chat_i, "message": i}, format_info);}
function   del(i) {chat_processor_request("del",   {"chat_i": chat_i, "message": i}, update_messages);}
function  edit(i) {chat_processor_request("edit",  {"chat_i": chat_i, "message": i, "new": prompt("Edit message:")}, update_messages);}
function   fwd(i) {chat_processor_request("fwd",   {"id": i}, console.log);}
function react(i) {chat_processor_request("react", {"id": i}, console.log);}
function reply(i) {
    let output   = document.getElementById("reply_output");
    let main     = document.getElementById("main");
    let messages = main.getElementsByClassName("message");
    let message = messages[i].getElementsByClassName("message_content")[0].innerHTML;
    replying = i;
    output.innerHTML = "<li>Replying to:&nbsp;</li><li style='flex: 1'>" + trim_max(message, message_shown_length) + "</li><li><button onclick='cancel_reply()'>&#x2716</button>";
    output.style.flex = 2;
}

function cancel_reply() {
    let output = document.getElementById("reply_output");
    replying = null;
    output.innerHTML = "";
    output.style.flex = 0;
}

function trim_max(text="", max_length=10) {
    return (text.length > max_length) ? text.substring(0, max_length - 3) + "..." : text;
}

function format_info(text) {
    console.log(text)
    let x = JSON.parse(text);
    let message = trim_max(x[1], message_shown_length)
    let utc = new Date(1000 * x[2]);

    let time = utc.getDate() + ". " + (utc.getMonth()+1) + ". " + utc.getFullYear() + ", " + utc.getHours() + ":" + utc.getMinutes();

    var utcSeconds = x[2];
    var d = new Date(0);
    d.setUTCSeconds(utcSeconds);

    alert("Message: " + message + "\nPosted: " + time + "\n" + x[3] + "\n" + x[4]);
}



function file_open(element_id) {
    let element = document.querySelector("#" + element_id);
    window.open(element.getAttribute("target"), "_blank");
}

function file_download(element_id) {
    let element = document.querySelector("#" + element_id);
    
    var link = document.createElement("a");
    link.setAttribute('download', '');
    link.href = element.getAttribute("target");;
    document.body.appendChild(link);
    link.click();
    link.remove();
}



function attach(files) {
    for (let file of files) {
        if (!attachment_files.includes(file)) {
            document.getElementById("main").style.bottom = "calc(var(--layout-footer-height) + var(--attachments-height))";
            let attachments = document.getElementById("attachments");
            attachments.style.display = "flex";
            attachments.innerHTML += "&nbsp;" + // invisible character, just for splitting
                    "<div><img class='material-symbols-rounded' src='img/icons/attach_file.png' style='width: 16px'>" + 
                    "<span style='margin: 0px 10px;'>" + trim_max(file.name, 30) + "</span>" +
                    "<button onclick='cancel_attachment(" + attachments_count + ")'>&#x2716</button></div>";  
            attachments_count ++;
            attachment_files.push(file);
        } else {
            console.log("This file is already attached. (" + file.name + ")");
            console.log(attachment_files)
        }
    }
}

function cancel_attachment(att_id) {
    attachment_files.splice(att_id, 1);
    
    let obj = document.getElementById("attachments");
    let attachments = obj.innerHTML.split("&nbsp;");
    
    attachments.splice(att_id + 1, 1)
    
    attachments.forEach((v, i, a) => {a[i] = v.replace(new RegExp("cancel_attachment\\(.+\\)","gm"), "cancel_attachment("+i+")")})

    obj.innerHTML = attachments.join("&nbsp;")

    if (attachments.length <= 1) {
        document.getElementById("main").style.bottom = "calc(var(--layout-footer-height))";
        document.getElementById("attachments").style.display = "none";
    }
}

function cancel_all_attachments() {
    attachment_files = [];

    let obj = document.getElementById("attachments");
    obj.innerHTML = obj.innerHTML.split("&nbsp;")[0];

    document.getElementById("main").style.bottom = "calc(var(--layout-footer-height))";
    document.getElementById("attachments").style.display = "none";
}