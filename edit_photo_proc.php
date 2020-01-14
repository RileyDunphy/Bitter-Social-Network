<?php 
//this file will handle the file uploading and return the user back to the edit_photo page.
include("connect.php");
include("Includes/User.php");
session_start();
if(isset($_POST['submit'])) {
    //if the directory doesn't exist, make it
    if (!file_exists("images/profilepics/" . $_SESSION["SESS_MEMBER_ID"])) {
        mkdir("images/profilepics/" . $_SESSION["SESS_MEMBER_ID"], 0777, true);
    }
    //Attempt to upload file
    if(empty($_FILES['pic']['name'])){
        $msg = "ERROR: You must select a file";
    }
    if($_FILES['pic']['size'] > (1024 * 1024 * 256)){
        unlink($_FILES['pic']['tmp_name']);//delete the file
        $msg = "ERROR: image must be under 256MB";
    }
    else{
        if(move_uploaded_file($_FILES['pic']['tmp_name'], "images/profilepics/" . $_SESSION["SESS_MEMBER_ID"]."/".$_FILES['pic']['name'])){
            $u = new User();
            $u->profImage = mysqli_escape_string($con, $_FILES['pic']['name']);
            $msg = $u->editPhoto();
        }
        else {
            unlink($_FILES['pic']['tmp_name']);
            $msg = "ERROR HANDLING FILE";
        }
    }
    header("location:index.php?message=$msg");
}
?>