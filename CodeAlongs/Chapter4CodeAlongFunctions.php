<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        // put your code here
            //type hinting will throw an exception if the type doesn't match
            function AddNumbers(int $x, int $y){
                return $x + $y;
            }//end function
            function PrintMessage(&$x, $z=2){//& means by reference
                $x = "Bonjour Monde";//change to argument inside the function
                echo $x . "<BR>";
                echo $z . "<BR>";
            }//end function
            
            function Factorial($num){//recursive function
                //if ($num == 1) return 1;//base case
                //else return $num * Factorial ($num -1);
                $sum = 1;
                for($i=2;$i<=$num;$i++){
                    $sum*=$i;
                }
                return $sum;
            }
            echo AddNumbers("5","123"). "<BR>";
            echo getrandmax() . "<BR>";
            echo Factorial(100);
            $myMessage = "Hello world";
            PrintMessage($myMessage);
            echo $myMessage . "<BR>";
        ?>
    </body>
</html>
