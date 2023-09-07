<!DOCTYPE html>
<html>
    <head>
        <title>Mensapp</title>
        <meta http-equiv="X-UA-Compatible" content="IE-edge" charset="UTF-8">
		<meta name="description" content="content. coasi.">
		<meta name="author" content="Mensa Camp Dev Team">
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="style.css">
        <!-- <link rel="stylesheet" href="style-dark.css"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <?php include 'navigation.php'; ?>

        <div class="content cards">
            <?php
                $userid = 1;

                $conn = mysqli_connect("sql6.webzdarma.cz", "mensappwzcz5668", "*0Q22^zX29JC@p%e4DG0", "mensappwzcz5668");
                $project_ids = mysqli_query($conn, "SELECT * FROM `projects-users` WHERE `userid`='$userid'");

                while ($project = mysqli_fetch_array($project_ids)) {
                    $data = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `projects` WHERE `id`='$project[projectid]'"));
                    echo "<a href='project.php?p=$data[id]' class='card'><p>$data[title]</p></a>";
                }
            ?>
        </div>

        <br id="end">

    </body>
</html>