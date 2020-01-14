<?php
//this page will allow the user to edit their profile photo
session_start();
include("Includes/header.php");
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="The Home Page for the Bitter Social Network, where you can post content, follow users, and reply to user's tweets">
    <meta name="author" content="Riley Dunphy, rileydunphy@live.ca">
    <link rel="icon" href="favicon.ico">

    <title>Bitter - Social Media for Trolls, Narcissists, Bullies and Presidents</title>

    <!-- Bootstrap core CSS -->
    <link href="includes/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="includes/starter-template.css" rel="stylesheet">
	<!-- Bootstrap core JavaScript-->
    <script src="https://code.jquery.com/jquery-1.10.2.js" ></script>
  </head>

  <body>
      <br><BR>
	
    <form action="edit_photo_proc.php" method="post" enctype="multipart/form-data">
            Select your image (Must be under 1MB in size): 
            <input type="file" name="pic" accept="image/*" required><br><br>
            <input id="button" type="submit" name="submit" value="Submit">
    </form>
	

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="includes/bootstrap.min.js"></script>
    
  </body>
</html>
