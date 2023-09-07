var cur_month = new Date().getMonth();
month_cycle(+1);
var cur_year  = new Date().getFullYear();

const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

function display(year=null, month=null) {
    var xhttp = new XMLHttpRequest();
    if (year) {xhttp.open("GET", "calendar_embed.php?month="+month+"&year="+year+"&user=1", true);} else {xhttp.open("GET", "calendar_embed.php?user=1", true);}
    xhttp.onload = function () {
        document.getElementById("output").innerHTML = this.responseText.split("<!--WZ-REKLAMA-1.0IK-->")[1];
        document.getElementById("month").innerHTML = months[cur_month-1] + " " + cur_year;
    }
    xhttp.send();
}

function next() {
    month_cycle(+1);
    display(cur_year, cur_month);
}

function prev() {
    month_cycle(-1);
    display(cur_year, cur_month);
}

function now() {
    cur_month = new Date().getMonth() + 1;
    cur_year  = new Date().getFullYear();
    display();
}

function month_cycle(dx) {
    cur_month += dx;

    while (cur_month > 12) {
        cur_month -= 12;
        cur_year ++;
    }
    while (cur_month < 1) {
        cur_month += 12;
        cur_year --;
    }
}