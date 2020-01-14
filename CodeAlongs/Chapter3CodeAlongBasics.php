<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>chapter 3 PHP</title>
    </head>
    <body>
        <?php
        // put your code here
        /*mult line
         * comment
         */
        $x = 5;
        $myName = "Riley";
        echo $myName . "<BR>"; //. is string concatenation
        echo ++$x . "<BR>";
        echo $myName .= " Dunphy";//concatenation and assign
        print "Hello world<BR>";
        printf("hello %s<BR>", $myName);
        //scalar variables is used to hold a single value
        //booleans, int, float, string
        $value = (bool) true;
        $value = 'hello world';
        $value = 0755;//octal
        $value=0xabc;//hex
        echo $value . " value <BR>";
        
        //arrays will be covered chapter 5
        $students[0] = "Jimmy";
        $students[1] = "John";
        $students[2] = "suzie";
        //php variables are case-sensitive
        $X = 50;//this is different than $x
        $myVar = "5";
        $myVar2 = "10";
        //type-juggling
        echo $myVar + $myVar2 . "<BR>";
        echo gettype($myVar2) . "<BR>";
        //reference variables
        $myVar2 =& $myVar;
        $myVar = 5600;
        echo $myVar2 . "<BR>";
        
        const PI = 3.14159;//NO DOLLAR SIGN ON CONSTs
        //define("PI", 3.14);
        
        echo PI . "<BR>";
        echo "<pre>";
        $count = 0;
        $count++; //increment the count variable
        echo $count . "<BR>";
        if($count ==0){
            echo "ZERO<BR>";
        }
        elseif($count >0){//THIS IS DIFFERENT
            echo "greater then 0\r\n";
        }
        else{
            echo $count . " count<BR>";
        }
        echo "</pre>";
        $a = 5;
        $b = "5";
        if($a === $b){
            echo "EQUAL<BR>";
        }
        else{
            echo "NOT EQUAL<BR>";
        }
        //<=> spaceship operator
        echo ($a <=> $b) . "<BR>";
        //switch statement
        $color = "red";
        switch ($color){
            case "red":
                echo "RED<BR>";
                break;
            case "blue":
                echo "BLUE<BR>";
                break;
            default:
                echo "DEFAULT<BR>";
        }//end switch
        while(true){
            if($color == "red") break;
            
        }//end while
        echo "<script>alert(\"HELLO\")</script>";
        $i=0;
        do{
            echo pow($i, 2) . "<BR>";
            $i++;//DON"T FORGET TO INCREMENT THE COUNTER
        }while($i<10);
        for($i=0; $i<10; $i++){
            if($i==5) continue; //skip the current iteration
        }
        ?>
        <!--short circuit tag-->
        This is a <?=$myName?> sentence using a short circuit tag.
    </body>
</html>
