<?php

session_start();

if (!array_key_exists("user", $_SESSION)) {
    header("Location: index.php?m=You have to log in first.");
} elseif (!array_key_exists("expire", $_SESSION) or $_SESSION["expire"] < strtotime("now")) {
    header("Location: index.php?m=Your login has expired.");
}

$_SESSION["expire"] = strtotime("Next hour");

echo '
        <nav>
            <h2>Mensapp</h2>
            <div style="flex: 1;"></div>
            <!--<input type="text" name="search" id="search" placeholder="Try to search...">-->
            <a href="logout.php" class="profile"> <img src="http://mensapp.wz.cz/img/profiles/red.png" style="border-radius: 50%; width: 40px; height: 40px;"></a>
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