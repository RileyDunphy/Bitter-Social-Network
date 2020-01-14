<?php
session_start();
//insert a tweet into the database
include("connect.php");
include("Includes/User.php");
if (isset($_POST["to"])) {
    //won't get here the first time you visit the page
    //will only get if a form has been submitted via post
    $message = mysqli_real_escape_string($con, $_POST["message"]);
    $to = mysqli_real_escape_string($con, $_POST["to"]);
    $u = new User();
    $msg = $u->AddMessage($message, $to);
}//end of big if(isset)
else{
    $msg = "Please enter a user id";
}
header("location:DirectMessage.php?message=$msg");
?>