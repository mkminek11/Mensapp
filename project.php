<!DOCTYPE html lang="en">
<html>
    <head>
        <title>Mensapp</title>
        <meta http-equiv="X-UA-Compatible" content="IE-edge" charset="UTF-8">
		<meta name="description" content="content. coasi.">
		<meta name="author" content="Mensa Camp Dev Team">
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="style.css">
        <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" /> -->

    </head>

    <body class="projects">

        <?php
            include 'navigation.php';
            $pid = $_GET["p"];

            $conn = mysqli_connect("sql6.webzdarma.cz", "mensappwzcz5668", "*0Q22^zX29JC@p%e4DG0", "mensappwzcz5668");
            $project = mysqli_query($conn, "SELECT * FROM `projects` WHERE `id`='$pid'");
            $data = mysqli_fetch_array($project);
            $w = mysqli_query($conn, "SELECT * FROM `projects-users` WHERE `projectid`='$pid'");

            $title   = $data["title"];
            $created = $data["created"];
            $description = $data["description"];
            $state   = ["Not started yet", "In progress", "Completed"][$data["state"]];
            $workers = mysqli_num_rows($w);
        ?>

        <div class="content">
            <div style="float: left;" class="card">
                <p><?php echo $title; ?></p>
            </div>

            <div style="float: left">
                <h2>About Project '<?php echo $title; ?>'</h2>
                <table>
                    <tr>
                        <td>Created:</td>
                        <td><?php echo $created; ?></td>
                    </tr>
                    <tr>
                        <td>Workers:</td>
                        <td><?php echo $workers; ?></td>
                    </tr>
                    <tr>
                        <td>Worktime:</td>
                        <td> - </td>
                    </tr>
                    <tr>
                        <td>Description:</td>
                        <td><?php echo $description; ?></td>
                    </tr>
                    <tr>
                        <td>State:</td>
                        <td><?php echo $state; ?></td>
                    </tr>
                </table>
            </div>
        </div>
<!--         
        <div class="divider">
            <a href="profile-inf.html"><img style="position: relative; left: -600px; padding: 30px; border-radius: 50%; width: 150px; height: 150px;" src="gren-profil.png"></a>
            <a><img style="position: relative; left: -600px; padding: 30px; border-radius: 50%; width: 150px; height: 150px;" src="blu-profil.png"></a>
        </div>
        <div class="divider">
            <p>Lorem ipsum, finally we broke the google chrome dino game. It was really fun and it tought us something. It taught us that javascript doesn't work as intended.</p>
        </div>
        <div class="content">
        </div>
         -->
         <br id="end">
         
    </body>
</html>