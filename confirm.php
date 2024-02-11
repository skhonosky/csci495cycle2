<?php

/*
    * Class: csci303fa23
    * User: skhonosky
    * Date: 2/11/2024
    * Time: 5:27 AM
*/

$pageName = "Confirm Login";
require_once "header.php";

if ($_GET['state']==1) {
    echo "<div class='logout-body'><p class='success'>You have been logged out. Have a great day!</p></div>";
    $_SESSION['state'] = 0;
} else {
    echo "<p class='success'>Welcome " . $_SESSION['first_name'] . ", you have successfully logged in.</p>";
    $_SESSION['state'] = 1;
}

require_once "footer.php";
?>
