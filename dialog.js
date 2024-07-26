function showDialog(dialogID = "dialog") {
    let dialog = document.querySelector("#" + dialogID);
    dialog.showModal();
}

function closeDialog(dialogID = "dialog") {
    let dialog = document.querySelector("#" + dialogID);
    dialog.close();
}