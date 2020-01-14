<?php
if (isset($_POST["txtName"])) {
    //won't get here the first time you visit the page
    //will only get if a form has been submitted via post
    $name = $_POST["txtName"];
    $email = $_POST["txtEmail"];
    echo $name . " " . $email . "<BR>";
    include("connect.php");
    /*define("DB_HOST", "localhost");
    define("DB_USER", "root");
    define("DB_PASS", "");
    define("DB_NAME", "productsdemo");
    global $con;
    $con = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
    if(!$con)
    {
        die('Could not connect: ' . mysql_error());
    }
     */
    $sql = "select * from products";
    if ($result = mysqli_query($con, $sql)){
        //this is useful for putting number of rows
        //echo mysqli_num_rows($result) . "<BR>";
        while($row = mysqli_fetch_array($result)){
            echo $row["ID"] . " " . $row["Category"] . " " . $row["Description"] . "<BR>";
        }
    }//end if
    
    //insert statement
    $prodId = 10;
    $category = "Sportswear";
    $description = "Hockey Stick";
    $price = 29.99;
    $sql = "insert into products (ID, Category, Description, Image, Price) VALUES ($prodId, '$category', '$description', 1, $price)";
    mysqli_query($con, $sql);
    if(mysqli_affected_rows($con) == 1){
        $msg = "INSERT SUCCESSFUL";
    }
    else{
        $msg = "ERROR ON INSERT";
          
    }//end if
    //DELETE statement
    $sql = "delete from products where ID = $prodId";
    //mysqli_query($con, $sql);
    //echo (mysqli_affected_rows($con) == 1) ? "DELETE SUCCESSFUL<BR>" : "FAILED<BR>";
    
    //UPDATE statement
    $description = "baseball bat 2";
    $sql = "update products set Description = '$description' where ID = $prodId";
    echo $sql . "<BR>";
    mysqli_query($con, $sql);//execute the SQL statement
    if (mysqli_affected_rows($con) == 1) {
        $msg= "update SUCCESSFUL";
    }
    elseif (mysqli_affected_rows($con) == 0){
        $msg= "no records updated";
    }
    else{
        $msg= "multiple records updated";
    }
    
}//end BIG if statement
//a header redirect will send the user to another page
//? is a URL querystring
//used for sending data via a GET
header("location:chap27mysql.php?message=$msg");

    ?>

