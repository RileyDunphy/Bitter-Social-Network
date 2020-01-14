<?php
session_start();
include("Includes/header.php");
if (isset($_GET["message"])) {
    $message = $_GET["message"];
    echo "<script>alert('$message')</script>";
}
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
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.js"></script>
        <script type="text/javascript" src="../includes/jquery.simplemodal.js"></script>

    </head>

    <body>
        <BR><BR>
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="mainprofile img-rounded">
                        <div class="bold">
                            <?php
                            echo "<a href=userpage.php?user_id=" . $_SESSION["SESS_MEMBER_ID"] . ">";
                            $u = new User();
                            $u->getUserById($_SESSION["SESS_MEMBER_ID"]);
                            if ($u->profImage != "") {
                                echo "<img class=\"bannericons\" src=\"images/profilepics/" . $_SESSION["SESS_MEMBER_ID"] . "/" . $u->profImage . "\">";
                            } else {
                                echo "<img class=\"bannericons\" src=\"images/profilepics/default.jfif\">";
                            }
                            echo " " . $u->firstName . " " . $u->lastName . "<BR></div>";
                            echo "</a>";
                            $u->getUserStats($_SESSION["SESS_MEMBER_ID"]);
                            ?><img class="icon" src="images/location_icon.jpg"><?php echo $u->province; ?>
                            <div class="bold">Member Since:</div>
                            <div><?php echo date("F d, Y", strtotime($u->dateAdded)); ?></div>
                        </div><BR><BR>
                        <div class="trending img-rounded">
                            <div class="bold">Trending</div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="img-rounded">
                            <!--display list of tweets here-->
                            <?php
                            $t = new Tweet();
                            echo "<b>Likes:</b><hr>";
                            $t->GetLikeNotifications();
                            echo "<b>Retweets:</b><hr>";
                            $t->GetRetweetNotifications();
                            echo "<b>Replies:</b><hr>";
                            $t->GetReplyNotifications();
                            ?>
                        </div>

                    </div>
                    <div class="col-md-3">
                        <div class="whoToTroll img-rounded">
                            <div class="bold">Who to Troll?<BR></div>
                            <!-- display people you may know here-->
                            <?php
                            $u = new User();
                            $u->getUsersToFollow();
                            ?>
                        </div><BR>
                        <!--don't need this div for now 
                        <div class="trending img-rounded">
                        © 2018 Bitter
                        </div>-->
                    </div>
                </div> <!-- end row -->
            </div><!-- /.container -->


            <!-- Bootstrap core JavaScript
            ================================================== -->
            <!-- Placed at the end of the document so the pages load faster -->

            <script src="includes/bootstrap.min.js"></script>

    </body>
</html>
