<?php
$myPassword = "opensesame";//would normally be passed via a POST
//add this to signup_proc.php
$myHashedPassword = password_hash($myPassword,PASSWORD_DEFAULT);
echo $myHashedPassword . "<BR>";
//this will go on the login_proc.php
echo password_verify($myPassword, $myHashedPassword) . "<BR>";
?>