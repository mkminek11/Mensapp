<?php

// if (!isset($_SESSION["user"])) {
//     header("Location: index.php");
// }


echo '
        <!--<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />-->
        <nav>
            <h2>Mensapp</h2>
            <div style="flex: 1;"></div>
            <!--<input type="text" name="search" id="search" placeholder="Try to search...">-->
            <a href="profile.php" class="profile"> <img src="http://mensapp.wz.cz/img/profiles/red.png" style="border-radius: 50%; width: 40px; height: 40px;"></a>
            <div class="nav-front">
                <a href="projects.php"   > <img class="material-symbols-rounded" src="img/icons/web.png"           > <span class="nav-label"> Projects    </span> </a>
                <a href="chat.php"       > <img class="material-symbols-rounded" src="img/icons/chat.png"          > <span class="nav-label"> Chat        </span> </a>
                <a href="calendar.php"   > <img class="material-symbols-rounded" src="img/icons/calendar_month.png"> <span class="nav-label"> Calendar    </span> </a>
                <a href="assignments.php"> <img class="material-symbols-rounded" src="img/icons/lists.png"         > <span class="nav-label"> Assignments </span> </a>
                <a href="settings.php"   > <img class="material-symbols-rounded" src="img/icons/settings.png"      > <span class="nav-label"> Settings    </span> </a>
            </div>
        </nav>

';

?>