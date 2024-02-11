<?php

/*
    * Class: csci303fa23
    * User: skhonosky
    * Date: 2/11/2024
    * Time: 2:45 AM
*/

$currentFile = basename($_SERVER['SCRIPT_FILENAME']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>skhonosky</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.tiny.cloud/1/5o7mj88vhvtv3r2c5v5qo4htc088gcb5l913qx5wlrtjn81y/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>tinymce.init({ selector:'textarea' });</script>
</head>
<body>
<header>
    <div class="titlediv">
        <img class="hdr-img" src="images/header.jpg" alt="Header: The People's Cookbook." />
    </div>
    <div>
        <nav>
            <?php
            echo ($currentFile == "index.php") ? "Home" : "<a class='element' href='index.php'>Home</a>";
            echo ($currentFile == "about.php") ? "About" : "<a class='element' href='about.php'>About</a>";
            echo ($currentFile == "recipeadd.php") ? "Add Recipe" : "<a class='element' href='recipeadd.php'>Add Recipe</a>";
            echo ($currentFile == "recipeupdate.php") ? "Update Recipe" : "<a class='element' href='recipeupdate.php'>Update Recipe</a>";
            echo ($currentFile == "viewrecipes.php") ? "View All Recipes" : "<a class='element' href='viewrecipes.php'>View All Recipes</a>";
            echo ($currentFile == "signup.php") ? "Registration" : "<a class='element' href='signup.php'>Registration</a>";
            echo ($currentFile == "login.php") ? "Login" : "<a class='element' href='login.php'>Login</a>";
            echo ($currentFile == "logout.php") ? "Logout" : "<a class='element' href='logout.php'>Logout</a>";

            ?>
        </nav>
    </div>
</header>
<main>

