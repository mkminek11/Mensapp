function bind_menu(element, menu_id) {
    var i = document.getElementById(menu_id).style;
    
    element.addEventListener('contextmenu', function(e) {
        const el = document.querySelector("#" + menu_id)
        el.addEventListener('contextmenu', function(f) {f.preventDefault()})
        console.log(element.id);
        var posX = e.clientX;
        var posY = e.clientY;
        el.classList.add("context-menu")
        menu(posX, posY, i);
        el.setAttribute("trigger", element.id);
        e.preventDefault();
    }, false);

    document.addEventListener('click', function(e) {
        i.opacity = "0";
        setTimeout(function() {i.visibility = "hidden";}, 200);
    }, false);
}

function menu(x, y, i) {
    i.top = y + "px";
    i.left = x + "px";
    i.visibility = "visible";
    i.opacity = "1";
}