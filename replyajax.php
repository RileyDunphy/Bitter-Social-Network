<?php
session_start();
//insert a tweet into the database
include("connect.php");
include("Includes/Tweet.php");
if (isset($_POST["comment"])) {
    //won't get here the first time you visit the page
    //will only get if a form has been submitted via post
    $reply = mysqli_real_escape_string($con, $_POST["comment"]);
    $tweetid = mysqli_real_escape_string($con, $_POST["tweetid"]);

    $t = new Tweet();
    $msg = $t->reply($reply,$tweetid);
    echo $msg;
}//end of big if(isset)