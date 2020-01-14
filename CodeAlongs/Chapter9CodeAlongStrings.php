<?php
session_start();
if (isset($_SESSION["name"])){
    echo "You are logged in<BR>";
}
else{
    echo "you are not logged in<BR>";
}

$students = array("Riley", "Jim", "John", "Jill");
$jStudents = preg_grep("/^J/i", $students);
print_r($jStudents);
echo "<BR>";

$myString = "The lion, the witch and the wardrobe";
echo preg_match_all("/the/i", $myString, $myMatches) . "<BR>";
print_r($myMatches);
echo "<BR>";

$myString = "the price is $19.99";
echo preg_quote($myString) . "<BR>";

$myString = "PHP is my favorite programming language";
//$myString = preg_replace("/PHP/", "Java", $myString);
$myString = preg_filter("/PHP2/", "Java", $myString);
echo $myString . "<BR>";

$myString = "this|is|a|sentence";
$myArray = preg_split("/\|/", $myString);
print_r($myArray);
echo "<BR>";

echo strlen($myString) . "<BR>";
$string1 = "HELLO WORLD";
$string2 = "hello world";
echo strcasecmp($string2, $string1) . "<BR>";

echo strtolower($string1) . "<BR>";
echo ucfirst($string2) . "<BR>";

$myString ="Cafe Francaise + & ^ % $";
echo htmlentities($myString) . "<BR>";

$myString = "Billy o'donnel";
echo addslashes($myString) . "<BR>";
//echo mysqli_real_escape_string($con, $myString) . "<BR>";

$myString = "Java <BR> is <BR> awesome<BR>";
echo strip_tags($myString)  . "<BR>";
