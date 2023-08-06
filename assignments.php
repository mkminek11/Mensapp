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
    </head>

    <body class="assignments">

        <?php include 'navigation.php'; ?>
        
        <div class="content">
            <table>
                <thead>
                    <td style="width: 10%; border-top-left-radius: 5px; border-bottom-left-radius: 5px;">Project</td>
                    <td style="width: 15%;">Assignment</td>
                    <td style="width: 45%;">Description</td>
                    <td style="width: 10%;">Priority</td>
                    <td style="width: 10%;">Deadline</td>
                    <td style="width: 20%; border-top-right-radius: 5px; border-bottom-right-radius: 5px;">State</td>
                </thead>
                <?php
                    // $userid = $_SESSION["user"];
                    $userid = 1;

                    $conn = mysqli_connect("sql6.webzdarma.cz", "mensappwzcz5668", "*0Q22^zX29JC@p%e4DG0", "mensappwzcz5668");
        
                    function output($conn, $input) {
                        $project_i = $input["projectid"];
                        $title     = $input["title"];
                        $desc      = $input["description"];
                        $deadline  = $input["deadline"];
                        $project  = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `projects` WHERE `id` = '$project_i'"))["title"];
                        $priority = ["-", "low", "medium", "high", "very high"][$input["priority"]];
                        $state    = ["Not started yet", "Work in progress", "Done"][$input["state"]];
                        $highlight = (array_key_exists("highlight", $_GET)) ? (($_GET["highlight"]*86400 == strtotime($deadline)+3600) ? " class='highlight'" : "") : "";
                        echo "<tr$highlight>
                                  <td>$project</td>
                                  <td>$title</td>
                                  <td>$desc</td>
                                  <td class='$priority'>$priority</td>
                                  <td>$deadline</td>
                                  <td>$state</td>
                              </tr>";
                    }

                    
                    $my_assignments = mysqli_query($conn, "SELECT * FROM `users-assignments` WHERE `userid` = '$userid'");
                    while ($a = mysqli_fetch_array($my_assignments)) {
                        $adata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `assignments` WHERE `id` = '$a[assignmentid]'"));
                        output($conn, $adata);
                    }
                ?>
            </table>
        </div>
        
        <br id="end">

    </body>
</html> 