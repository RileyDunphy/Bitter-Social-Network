<?php
session_start();
session_unset();//removes all variables from session
session_destroy();//kills the session completely
$msg = "You have been logged out";
header("location:login.php?message=$msg");
?>
