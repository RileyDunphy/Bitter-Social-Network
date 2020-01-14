<?php
//chapter 17 - sessions
//cookie is a small text file stored on your computer-limited size 4KB-security issues
//session replaced cookies
//session variables are stored on the RAM of the server
//echo $_SESSION["name"];//WON'T WORK!!!
session_start(); //USE THIS EVERY TIME YOU WANT TO USE SESSION VARIABLES
//set the session variable
$_SESSION["name"] = "Riley";//this would be similar to what will be on login_proc

//retrieve the session variable
echo $_SESSION["name"] . "<BR>";

echo session_id() . " my session ID<BR>";
$mySession = session_encode() . " ALL MY SESSION VARS<BR>";
echo session_decode($mySession) . "<BR>";
session_unset();//removes all variables from session
session_destroy();//kills the session completely