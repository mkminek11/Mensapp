<html>
    <head>
        <title>Mensapp</title>
        <meta http-equiv="X-UA-Compatible" content="IE-edge" charset="UTF-8">
		<meta name="description" content="content. coasi.">
		<meta name="author" content="Mensa Camp Dev Team">
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="style.css">
    </head>

    <body class="projects">
        <?php
            include 'navigation.php';
            $pid = $_GET["p"];

            $conn = mysqli_connect("sql6.webzdarma.cz", "mensappwzcz5668", "*0Q22^zX29JC@p%e4DG0", "mensappwzcz5668");
            $user = mysqli_query($conn, "SELECT * FROM `users` WHERE `id`='$uid'");
            $data = mysqli_fetch_array($project);
            // $w = mysqli_query($conn, "SELECT * FROM `projects-users` WHERE `projectid`='$pid'");

            // $title   = $data["title"];
            // $created = $data["created"];
            // $description = $data["description"];
            // $state   = ["Not started yet", "In progress", "Completed"][$data["state"]];
            // $workers = mysqli_num_rows($w);
        ?>

        <div class="content">
            <img style="float: left; padding: 30px; border-radius: 50%; width: 150px; height: 150px;" src="gren-profil.png">

            <div style="float: left">
                <h2>User '<?php echo $name; ?>'</h2>
                <table>
                    <tr>
                        <td>Account Created:</td>
                        <td>17.2. 2023</td>
                    </tr>
                    <tr>
                        <td>Projects finished:</td>
                        <td>2</td>
                    </tr>
                    <tr>
                        <td>Projects in progress:</td>
                        <td>8</td>
                    </tr>
                    <tr>
                        <td>Worktime:</td>
                        <td>432hr</td>
                    </tr>
                    <tr>
                        <td>Hobbies:</td>
                        <td>Programming, Rock climbing, guitar</td>
                    </tr>
                </table>
            </div>
        </div>
        
        <div class="divider">
        <div class="cards" style="width: 100%;">
            <a href="project-inf.html" class="card">
                <p>Dino</p>
            </a>
            <div class="card">
                <p>Breathe air</p>
            </div>
            <div class="card">
                <p>Eat</p>
            </div>
            <div class="card">
                <p>don't vape</p>
            </div>
            <div class="card">
                <p>Game</p>
            </div>
            <div class="card">
                <p>Sleep</p>
            </div>
            <div class="card">
                <p>Drink wo'oh</p>
            </div>
            <div class="card">
                <p>Do push ups</p>
            </div>
        </div>
        
        <br id="end">
    </body>
</html>