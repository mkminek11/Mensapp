<!DOCTYPE html>
<html>
    <head>
        <title>Mensapp</title>
        <meta http-equiv="X-UA-Compatible" content="IE-edge" charset="UTF-8">
		<meta name="description" content="content. coasi.">
		<meta name="author" content="Mensa Camp Dev Team">
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="calendar.css">
    </head>
    <body>
        <?php
        include 'navigation.php';

        $month = (array_key_exists("month", $_GET)) ? date("F", strtotime($_GET["month"])) : date("F");
        $year =  (array_key_exists("year", $_GET))  ? date("Y", strtotime("1.1.".$_GET["year"])) :  date("Y");

        $prev = strtotime("previous month", strtotime("$month $year"));
        $next = strtotime("next month",     strtotime("$month $year"));
        echo "$month, $year - next: ".date("F", $next);
        ?>

        <div class="content">
            <div class="center">
                <button style="margin-right: 30px;" onclick="location.assign('calendar.php<?php echo '?year='.date('Y', $prev).'&month='.date('F', $prev); ?>')">
                    <img src="img/icons/arrow_left.png">
                </button>
                <table>
                    <thead>
                        <tr>
                            <td></td>
                            <td colspan="5"><h2><?php echo "$month, $year"; ?></h2></td>
                            <td><button onclick="location.assign('calendar.php')">○</button></td>
                        </tr>
                        <tr>
                            <td><p class="day-name">Mon</p></td>
                            <td><p class="day-name">Tue</p></td>
                            <td><p class="day-name">Wed</p></td>
                            <td><p class="day-name">Thu</p></td>
                            <td><p class="day-name">Fri</p></td>
                            <td><p class="day-name">Sat</p></td>
                            <td><p class="day-name">Sun</p></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            include 'calendar_embed.php';
                            $dl = deadlines(1);
                            calendar($dl, $year, $month);
                            date_default_timezone_set('Europe/Prague');
                        ?>
                    </tbody>
                </table>
                <button style="margin-left: 30px;"  onclick="location.assign('calendar.php<?php echo '?year='.date('Y', $next).'&month='.date('F', $next); ?>')">
                    <img src="img/icons/arrow_right.png">
                </button>
                <br style="clear: both; display: none;">
            </div>
        </div>

        <br id="end">
    </body>
</html>