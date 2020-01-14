<?php
 $colors[0] = "Red";
 $colors[1] = "Blue";
 $colors[2] = "White";
 //easier way
 $colors = [5=>"Red", "blue", "White"];
 //associative array
 //$grades = ["jimmy" => 98, "johnny" => 66];
 $grades = array("jimmy" => 98, "johnny" => 66);
 //2-dimensional array
 $twoDArray = array("jimmy"=>array("math"=>98,"science"=>99, "french"=>91), 
     "Johnny" => array("math" => 87, "science" => 93, "french"=>100));
 foreach($twoDArray as $student){
     echo $student["math"] . " " . $student["science"] . "<BR>";
 }
 $students = file("Students.txt");//read the file as an array
 foreach($students as $student){
     list($name, $hometown, $gpa) = explode("|", $student);
     echo $name . " " . $hometown . " " . $gpa . "<BR>";
 }
 //populate an array with a range
 $myNums = range(0,100);//or range("A", "F")
//print_r($myNums);//print out an array
 array_unshift($colors, "purple");//add to the beginning of an array
 array_push($colors, "yellow");
 array_shift($colors);//removes element from the beginning of the array
 array_pop($colors);//removes from the end of the array
 print_r($colors);
 //echo $colors[7] . "<BR>";
 if(in_array("Red", $colors)){
     echo "FOUND<BR>";
 }
 else{
     echo "NOT FOUND<BR>";
 }
//how many items are in my array
echo count($colors) . " elements<br>";
echo sizeof($colors) . " alias of count<BR>";

print_r(array_reverse($colors));
echo "<BR>";
//$colors = array_flip($colors);

print_r(array_flip($colors));
echo "<BR>";
//sort (ascii order by default)
sort($colors, SORT_NATURAL);
natcasesort($colors);
$colors2 = array("black", "orange");
//merge array

$newArray = array_merge($colors, $colors2);
print_r($newArray);
