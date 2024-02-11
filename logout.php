<?php

/*
    * Class: csci303fa23
    * User: skhonosky
    * Date: 2/11/2024
    * Time: 4:03 AM
*/

session_start();
session_unset();
session_destroy();

header("Location: confirm.php?state=1");

?>