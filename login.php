<?php

/*
    * Class: csci303fa23
    * User: skhonosky
    * Date: 2/11/2024
    * Time: 4:03 AM
*/

$pageName = "Login";
require_once "header.php";

$showForm = 1;
$errmsg = 0;
$erremail = "";
$errpwd = "";


if($_SERVER['REQUEST_METHOD'] == "POST") {

// create local variables
    $email = ($_POST['email']);
    $pwd = $_POST['pwd'];

//check for empty fields
    if (empty($email)) {
        $errmsg = 1;
        $erremail = "Missing Email.";
    }

    if (empty($pwd)) {
        $errmsg = 1;
        $errpwd = "Missing Password.";
    }

    if ($errmsg == 1) {
        echo "<p class='error'> There are errors. Please make changes and try again.</p>";
    } else {
        $sql = "SELECT * FROM user_registration WHERE (email=:email)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $row = $stmt->fetch();

        if (password_verify($pwd, $row['pwd'])) {
            // SET SESSION VARIABLES
            $_SESSION['user_no'] = $row['user_no'];
            $_SESSION['first_name'] = $row['first_name'];
            $_SESSION['user_status'] = $row['user_status'];
            $_SESSION['state'] = 1;

            // REDIRECT TO CONFIRMATION PAGE
            header("Location: confirm.php?state=2");
            echo "<p class='success'>Welcome {$_POST['first_name']}!</p>";
            echo "<hr>";

        } else {
            echo "<p class='error'>Login unsuccessful. Please try again.</p>";
        }
    }

    var_dump($_POST);
    echo "<hr>";

    $showForm = 0;
}

if ($showForm ==1) {

    ?>
    <div class="login-form">
    <p>Login:</p>
    <form name="login-form" id="login-form" method="post" action="<?php echo $currentFile; ?>">
        <label for="email">Email:</label>
        <input type="text" id="email" name="email" maxlength="255" size="30" value="<?php if (isset($email)) {echo $email;}?>">
        <?php if (!empty($erremail)) {echo "<span class='error'>$erremail</span>";}?>
        <br>

        <label for="pwd">Password:</label>
        <input type="password" id="pwd" name="pwd" maxlength="255" size="30" placeholder="Minimum 8 Characters">
        <?php if (!empty($errpwd)) {echo "<span class='error'>$errpwd</span>";}?>
        <br>

        <label for="submit">Submit</label>
        <input type="submit" id="submit" name="submit" value="Submit">
    </form>
    </div>
    <?php

} // closing if showform
require_once "footer.php";
?>