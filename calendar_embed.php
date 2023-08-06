<?php

date_default_timezone_set('Europe/London');

function calendar($deadlines, $syear, $smonth) {
    $notifications = array_count_values($deadlines);
    // print_r($deadlines);
    // print_r();
    // print_r(array_count_values($deadlines));
    // print_r(array_count_values([19600, 19722]));
    // echo $deadlines == [19600, 19722];
    $start = strtotime("first Monday of $smonth $syear") + 3600 - 7 * 86400;
    for ($i = 0; $i < 6; $i++) {
        for ($j = 0; $j < 7; $j++) {
            $day = $start + ($i * 7 + $j) * 86400;
            $dom = date("j", $day);
            $month = ($smonth == date("F", $day)) ? " this-month" : "";
            $dayid = round($day / 86400);
            $n = $notifications[$dayid];
            $today = ($dayid == round(strtotime(date("d-m-Y"))/86400)) ? " today' title='today" : "";
            echo "<td class='day$month$today' id='d$dayid'>$dom" . (($n > 0) ? "<sup><a href='assignments.php?highlight=$dayid'>$n</a></sup>" : "") . "</td>";
        }
        echo "</tr>";
    }
}

function deadlines($user) {
    $conn = mysqli_connect("sql6.webzdarma.cz", "mensappwzcz5668", "*0Q22^zX29JC@p%e4DG0", "mensappwzcz5668");
    $assignments = mysqli_query($conn, "SELECT * FROM `users-assignments` WHERE `userid` = '$user'");
    $dates = array();
    while ($a = mysqli_fetch_array($assignments)) {
        $assignment = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `assignments` WHERE `id` = '$a[assignmentid]'"));
        array_push($dates, intval(round((strtotime($assignment["deadline"])+3600)/86400)));
        // echo $assignment["deadline"] . " - " . (strtotime($assignment["deadline"])+3600)/86400;
    }
    // print_r($dates);
    return $dates;
}

?>