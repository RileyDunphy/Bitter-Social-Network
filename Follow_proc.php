<?php

session_start();
include("connect.php");
include("Includes/User.php");
if (isset($_GET["user_id"])) {
    //won't get here the first time you visit the page
    //will only get if a form has been submitted via post
    $theirid = $_GET["user_id"];
    $yourid = $_SESSION["SESS_MEMBER_ID"];
    $u = new User();
    $msg = $u->followUser($yourid, $theirid);
}

header("location:index.php?message=$msg");
?>