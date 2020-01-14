<?php
session_start();
//insert a tweet into the database
include("connect.php");
include("Includes/User.php");
if (isset($_GET["to"])) {
    //won't get here the first time you visit the page
    //will only get if a form has been submitted via post
    $userName = mysqli_real_escape_string($con,$_GET['to']);
    $users = array();
    $u = new User();
    $users = $u->GetUsers($userName);
    echo json_encode($users);
}//end of big if(isset)

//perform any server-side validation that may be needed
//if it's all good, go ahead and insert into the database or whatever
?>