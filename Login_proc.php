<?php 
//insert the user's data into the users table of the DB
//if everything is successful, redirect them to the login page.
//if there is an error, redirect back to the signup page with a friendly message
include("connect.php");
include("Includes/User.php");
if (isset($_POST["username"])) {
    $u = new User();
    $u->userName = mysqli_real_escape_string($con, $_POST["username"]);
    //don't escape sql characters on password because we are just verifying it against the hashed password in PHP, not using it in mySQL
    $u->password = $_POST["password"];
    $u->login();
}

?>