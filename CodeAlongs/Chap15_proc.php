<?php
//chapter 15 processing
if(isset($_POST['submit'])) {
    //Attempt to upload file
    if(empty($_FILES['pic']['name'])){
        echo "ERROR: You must select a file";
    }
    //echo $_FILES['pic']['size'];
    echo $_FILES['pic']['tmp_name'] . "TEMP NAME<BR>";
    echo print_r($_FILES['pic']);
    if($_FILES['pic']['size'] > (1024 * 1024 * 256)){
        unlink($_FILES['pic']['tmp_name']);//delete the file
        echo "ERROR: image must be under 1MB";
    }
    else{
        if(move_uploaded_file($_FILES['pic']['tmp_name'], "../images/profilepics/" . $_FILES['pic']['name'])){
            echo "successful<BR>";
        }
        else {
            unlink($_FILES['pic']['tmp_name']);
            echo "ERROR HANDLING FILE";
        }
        //update the profilepic field in the users table of your DB
    }
}
?>