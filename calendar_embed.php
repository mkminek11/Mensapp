<?php
date_default_timezone_set('Europe/London');

$smonth    = intval(array_key_exists("month", $_REQUEST) ? $_REQUEST["month"] : date("m")) - 1;
$syear     = intval(array_key_exists("year",  $_REQUEST) ? $_REQUEST["year"]  : date("Y"));
$user = array_key_exists("user", $_REQUEST) ? $_REQUEST["user"] : "non-existing user id";

$_MONTHS = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

if ($user) {
    $deadlines = deadlines($user);
    $notifications = array_count_values($deadlines);
}

$start_sun = time2days(strtotime("first Sunday of $_MONTHS[$smonth] $syear"));  // number of days from 01-01-1970 to first sunday of given month + year
$start_day = round($start_sun - 6);

// $start_day = time2days(strtotime("1st $_MONTHS[$smonth] $syear"));

$month_first = time2days(strtotime("first day of $_MONTHS[$smonth] $syear"));
$month_last  = time2days(strtotime("last day of $_MONTHS[$smonth] $syear"));

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

for ($i = 0; $i < 6; $i ++) { 
    echo "<tr>";
    for ($j = 0; $j < 7; $j ++) { 
        $current_day = $start_day + 7 * $i + $j;
        $this_month = (($current_day >= $month_first) and ($current_day <= $month_last)) ? " this-month" : "";
        $day_of_month = date("d", $current_day * 86400);
        $current_notificatoins = ($user and array_key_exists($current_day, $notifications) > 0) ? "<sup><a href='assignments.php?highlight=$current_day'>$notifications[$current_day]</a></sup>" : "";

        echo "<td class='day$this_month'>";
        echo $day_of_month.$current_notificatoins;
        echo "</td>";
        echo "\n";
    }
    echo "</tr>";
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function dt($time=null) {return date("d-m-Y H:i:s", $time);}
function time2days($time) {return (strtotime("midnight", $time) + 3600) / 86400;}
function days2time($days) {return $days * 86400;}

function deadlines($user) {
    $conn = mysqli_connect("sql6.webzdarma.cz", "mensappwzcz5668", "*0Q22^zX29JC@p%e4DG0", "mensappwzcz5668");
    $assignments = mysqli_query($conn, "SELECT * FROM `users-assignments` WHERE `userid` = '$user'");
    $dates = array();
    while ($a = mysqli_fetch_array($assignments)) {
        $assignment = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `assignments` WHERE `id` = '$a[assignmentid]'"));
        array_push($dates, intval(round((strtotime($assignment["deadline"])+3600)/86400)));
        // echo $assignment["deadline"] . " - " . (strtotime($assignment["deadline"])+3600)/86400;
    }
    return $dates;
}

?>