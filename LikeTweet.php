<?php
session_start();
//insert a tweet into the database
include("connect.php");
include("Includes/Tweet.php");
if (isset($_GET["tweet_id"])) {
    //won't get here the first time you visit the page
    //will only get if a form has been submitted via post
    $tweet_id = mysqli_real_escape_string($con, $_GET["tweet_id"]);

    $t = new Tweet();
    $msg = $t->likeTweet($tweet_id);
}//end of big if(isset)

header("location:index.php?message=$msg");
?>