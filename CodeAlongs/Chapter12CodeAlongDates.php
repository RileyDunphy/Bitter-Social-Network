<?php

//checkdate verifies if the date was valid and returns 1 if true
$valid = checkdate(2, 29, 2020);
echo $valid . "<BR>";
//set the locale
setlocale(LC_ALL, "can-EN");
//%A - means the day of the week
//$d - day of the month
//%F - full date
//%B - month
echo strftime("%A, %B %d, %Y") . "<BR>";
echo date("F d, y") . "<BR>";
//times
//i means minutes
date_default_timezone_set('America/Halifax');
echo date("h:i:sa") . "<BR>";
$dateArray = getdate();
print_r($dateArray);
//date last modified
echo "this page was last modified on " . date("F d, Y H:i:s", getlastmod()) . "<BR>";

//date_default_timezone_set('America/Halifax');
//
//$dateTweeted = "2019-10-01";  //Obviously, this should not be hard-coded, it should come from the database
//
////this is new in PHP 5.1
//$now = new DateTime();
//$tweetTime = new DateTime($dateTweeted );
//$interval = $tweetTime->diff($now);
//
//if ($interval->y > 1) echo $interval->format('%y years') . " ago";
//elseif ($interval->y > 0) echo $interval->format('%y year') . " ago";
//elseif ($interval->m > 1) echo $interval->format('%m months') . " ago";
//elseif ($interval->m > 0) echo $interval->format('%m month') . " ago";
//elseif ($interval->d > 1) echo $interval->format('%d days') . " ago";
//elseif ($interval->d > 0) echo $interval->format('%d day') . " ago";
//elseif ($interval->h > 1) echo $interval->format('%h hours') . " ago";
//elseif ($interval->h > 0) echo $interval->format('%h hour') . " ago";
//elseif ($interval->i > 1) echo $interval->format('%i minutes') . " ago";
//elseif ($interval->i > 0) echo $interval->format('%i minute') . " ago";
//elseif ($interval->s > 1) echo $interval->format('%s seconds') . " ago";
//elseif ($interval->s > 0) echo $interval->format('%s second') . " ago";