<?php

//create an instance of the student classi
include("Student.php");
$s = new Student("riley", 12345); //uses the default constructor
$s->studentId = 123456;
echo $s->studentId . "<BR>";
//call the static method
Student::PrintSchool();
DoStuff($s);

//type-hinting
function DoStuff(Student $s) {
    echo $s->name . "<BR>";
}

?>