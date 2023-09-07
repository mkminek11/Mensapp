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
        <script src="calendar.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body onload="display()">
        <?php include 'navigation.php'; ?>

        <div class="content">
            <div class="center">
                <button style="margin-right: 30px;" onclick="prev()">
                    <img src="img/icons/arrow_left.png">
                </button>
                <table>
                    <thead>
                        <tr>
                            <td></td>
                            <td colspan="5"><h2 id="month"></h2></td>
                            <td><button onclick="now()">○</button></td>
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
                    <tbody id="output">

                    </tbody>
                </table>
                <button style="margin-left: 30px;"  onclick="next()">
                    <img src="img/icons/arrow_right.png">
                </button>
                <br style="clear: both; display: none;">
            </div>
        </div>

        <br id="end">
    </body>
</html>