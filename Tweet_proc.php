<?php
session_start();
//insert a tweet into the database
include("connect.php");
include("Includes/Tweet.php");
if (isset($_POST["myTweet"])) {
    //won't get here the first time you visit the page
    //will only get if a form has been submitted via post
    $tweet = mysqli_real_escape_string($con, $_POST["myTweet"]);

    $t = new Tweet();
    $msg = $t->insert($tweet);
}//end of big if(isset)

header("location:index.php?message=$msg");
?>