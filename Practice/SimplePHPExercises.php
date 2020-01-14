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
        $var1=10;
        $var2=10;
        echo ($var1==$var2) ? "EQUAL<BR>" : "not equal<br>";
        echo "<table border=1>";
        for ($row=1;$row<=7;$row++){
            echo"<tr>";
            for($col=1; $col<=7; $col++)
            {
                $value = $col * $row;
                echo "<td>$value</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
        echo "<table border=1>
            <tr><td style='color:blue;'>Apples cost</td>
            <td>$4</td></tr>
            <tr><td style='color:blue;'>Oranges cost</td>
            <td>$1.99</td></tr>
            <tr><td style='color:blue;'>Bananas cost</td>
            <td>$0.89</td>
            </tr></table>";
        ?>
    </body>
</html>
