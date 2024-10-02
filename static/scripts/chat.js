
let attachments = [];
let last_message = 0;

function attach(files) {
    const d = document.querySelector("#attachments");
    let order = d.childElementCount;
    for (const f of files) {
        if (!is_already_attached(f)) {
            d.innerHTML += '<div class="attachment" data-n="' + order + '">\
                        <button class="cancel-attachment" onclick="cancel(this)">×</button>' + f.name + '\
                    </div>';
        
            attachments.push(f);
            order++;
        }
    }
}


function is_already_attached(file) {
    for (const saved of attachments) {
        if (saved.name == file.name && saved.lastModified == file.lastModified && saved.size == file.size) {
            return true;
        }
    }

    return false;
}


function cancel(attachment) {
    attachment.parentNode.remove();
    const order = attachment.parentNode.dataset.n;
    if (order && order < attachments.length) {
        attachments.splice(parseInt(order), 1);
    }
}


function cancel_all_attachments() {
    attachments = [];
    document.querySelector("#attachments").innerHTML = "";
}


function update_messages() {
    console.log("Fetching values")
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "/_get_messages?chat=" + document.getElementById("chat_id").value);
    xhr.onload = function () {write_messages(this.responseText)}
    xhr.send()
}


function write_messages(messages) {
    const chat_parent = document.querySelector(".messages");
    let text = "";
    const current_last = last_message;

    for (const message of JSON.parse(messages)) {
        const message_user    = message[0];
        const user_id         = message[1];
        const message_text    = message[2];
        const msg_attachments = message[3];
        const msg_datetime    = message[4];

        text += '<div class="message-row">';
        text += '   <div class="message ' + ((message_user == user_id) ? 'from' : 'to') + '">';
        text +=        message_text;

        for (const attachment of msg_attachments) {
            text += '<div class="attachment">'
            text += '<a href="/static/user_upload/' + attachment[1] + '">' + attachment[0] + '</a>';
            text += '</div>'
        }

        text += '   </div>';
        text += '</div>';

        last_message = msg_datetime;
    }

    chat_parent.innerHTML = text;
}


function post() {
    const value = document.querySelector("#message").value;
    if (!(/^\s*$/.test(value) || attachments)) {return;}  // check if the message is not empty or consists only of spaces

    if (attachments) {
        const fxhr = new XMLHttpRequest();
        const fd  = new FormData();
        
        for (const file of attachments) {fd.append(file.name, file)}

        fxhr.open("POST", "/_upload");
        fxhr.onload = function() {send(value, this.responseText.split("\n"))};

        fxhr.send(fd);
    } else if (value) {
        send(value)
    }
}

function send(message, attachments_names = []) {
    const chat_id = parseInt(document.getElementById("chat_id").value);
    const xhr = new XMLHttpRequest();
    let atms = [];
    
    if (attachments_names) {    
        for (let i = 0; i < attachments.length; i++) {
            atms.push([attachments[i].name, attachments_names[i]])
        }
    }
    
    xhr.open("POST", "/_send", true)
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
    xhr.onload = function () {update_messages();}

    const params = "chat=" + chat_id + "&message=" + encodeURIComponent(message) + "&attachments=" + encodeURIComponent(JSON.stringify(atms));
    console.log(params);

    xhr.send(params);

    document.querySelector("#message").value = "";
    cancel_all_attachments();
}


setInterval(update_messages, 5000);