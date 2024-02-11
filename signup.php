<?php

/*
    * Class: csci303fa23
    * User: skhonosky
    * Date: 2/11/2024
    * Time: 4:03 AM
*/

$pageName = "Account Registration";
require_once "header.php";
$showForm = 1;
$errmsg = 0;
$errfirst_name = "";
$errlast_name = "";
$errbirth_date = "";
$erremail = "";
$errpwd ="";
$errfav_recipe="";
$errbio = "";


if($_SERVER['REQUEST_METHOD'] == "POST") {

    // Creating local variables
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $birth_date = $_POST['birth_date'];
    $email = strtolower(trim($_POST['email']));
    $pwd = $_POST['pwd'];
    $fav_recipe = $_POST['fav_recipe'];
    $bio = $_POST['bio'];

    //Check empty fields
    if (empty($first_name)) {
        $errmsg = 1;
        $errfirst_name = "Missing First Name.";
    }

    if (empty($last_name)) {
        $errmsg = 1;
        $errlast_name = "Missing Last Name.";
    }

    if (empty($birth_date)) {
        $errmsg = 1;
        $errbirth_date = "Missing Birth Date.";
    } else {
        $strtotime = strtotime($birth_date);
        if (!$strtotime) {
            $errbirth_date = "Invalid Birth Date.";
        }
    }

    if (empty($email)) {
        $errmsg = 1;
        $erremail = "Missing Email.";
    } else {
        // Validating Email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errmsg = 1;
            $erremail = "This is not a valid email.";
        }
        else {
            $sql = "SELECT email FROM user_registration WHERE email = :field";
            $dupemail = check_duplicates($pdo, $sql, $email);
            if ($dupemail) {
                $errmsg = 1;
                $erremail = "This email is already taken.";
            }

        }
    }

    if (empty($pwd)) {
        $errmsg = 1;
        $errpwd = "Missing Password.";
    } else {
        //Checking Password Length
        if (strlen($pwd) < 8) {
            $errmsg = 1;
            $errpwd = "Insufficient Password Length.";
        }else{
            $hashedpwd = password_hash($pwd, PASSWORD_DEFAULT);
        }
    }

    if (empty($fav_recipe)) {
        $errmsg = 1;
        $errfav_recipe = "Missing Favorite Recipe.";
    }

    if (empty($bio)) {
        $errmsg = 1;
        $errbio = "Missing Biography.";
    }


    //Control for form
    if ($errmsg == 1) {
        echo "<p class='error'> There are errors. Please make changes and try again.</p>";

    }
    else {
        $entered = date('Y-m-d H:i:s');

        echo "<p class='success'>Thank you {$_POST['first_name']} for your input, your submission has been recieved.</p>";
        echo "<hr>";
        var_dump($_POST);
        echo "<hr>";


        $sql = "INSERT INTO user_registration (first_name, last_name, birth_date, email, pwd, fav_recipe, bio, entered) VALUES (:first_name, :last_name, :birth_date, :email, :pwd, :fav_recipe, :bio, :entered)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':first_name', $first_name);
        $stmt->bindValue(':last_name', $last_name);
        $stmt->bindValue(':birth_date', $birth_date);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':pwd', $hashedpwd);
        $stmt->bindValue(':fav_recipe', $fav_recipe);
        $stmt->bindValue(':bio', $bio);
        $stmt->bindValue(':entered', $entered);
        $stmt->execute();

        $showForm = 0;
    }

}

if ($showForm ==1) {

    ?>
    <div class="bodydiv1">
    <p>Please fill out this required information:</p>
    <form name="user_reg" id="user_reg" method="post" action="<?php echo $currentFile; ?>">

        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" maxlength="50" size="30"
               value="<?php if (isset($first_name)) {echo htmlspecialchars($first_name);}?>">
        <?php if (!empty($errfirst_name)) {echo "<span class='error'>$errfirst_name</span>";}?>
        <br>

        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" maxlength="100" size="30"
               value="<?php if (isset($last_name)) {echo htmlspecialchars($last_name);}?>">
        <?php if (!empty($errlast_name)) {echo "<span class='error'>$errlast_name</span>";}?>
        <br>

        <label for="birth_date">Select Date of Birth:</label>
        <input type="date" id="birth_date" name="birth_date" value="<?php if (isset($birth_date)) {echo $birth_date;}?>">
        <?php if(!empty($errbirth_date)) {echo "<span class='error'>$errbirth_date</span>";}?><br>

        <label for="email">Email:</label>
        <input type="text" id="email" name="email" maxlength="255" size="30" value="<?php if (isset($email)) {echo $email;}?>">
        <?php if (!empty($erremail)) {echo "<span class='error'>$erremail</span>";}?>
        <br>

        <label for="pwd">Password:</label>
        <input type="password" id="pwd" name="pwd" maxlength="255" size="30" placeholder="Minimum 8 Characters">
        <?php if (!empty($errpwd)) {echo "<span class='error'>$errpwd</span>";}?>
        <br>

        <label for="fav_recipe">Favorite Recipe:</label>
        <input type="text" id="fav_recipe" name="fav_recipe" maxlength="100" size="30"
               value="<?php if (isset($fav_recipe)) {echo htmlspecialchars($fav_recipe);}?>">
        <?php if (!empty($errfav_recipe)) {echo "<span class='error'>$errfav_recipe</span>";}?>
        <br>

        <label for="bio">Biography:</label>
        <?php if (!empty($errbio)) {echo "<span class='error'>$errbio</span>";}?><br>
        <textarea id="bio" name="bio" placeholder="Tell Us About Yourself."><?php if (isset($bio)) {echo $bio;}?></textarea>
        <br>

        <label for="submit">Submit</label>
        <input type="submit" id="submit" name="submit" value="Submit">
    </form>
    </div>
<?php
}
require_once "footer.php";
?>