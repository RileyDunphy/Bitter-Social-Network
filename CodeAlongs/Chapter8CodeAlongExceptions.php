<?php
//chapter 8 - errors and exception handling
try{
    if(!mysqli_connect("localhost", "username", "password", "schema")){
        throw new Exception("error connecting to database");
    }//end if
    else{
        echo "SUCCESSFUL<BR>";
    }
}//end try
catch(Exception $ex){
    error_log("ERROR IN FILE " . $ex->getFile() . " on line# ". $ex.getLine() . $ex.getMessage());
    echo "could not connect to database";
    exit;//stops execution of the program
}//end catch
echo "MORE LOGIC HERE<BR>";
?>