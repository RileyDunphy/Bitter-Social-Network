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

        <script type="text/javascript">
            //just a little jquery to make the textbox appear/disappear like the real Twitter website does
            $(document).ready(function () {
                //hide the submit button on page load
                $("#button").hide();
                //reply modal stuff
                $("#submit_a_comment").hide();
                $("#frmComment").submit(function (event) {
                    event.preventDefault(); //prevent default action 
                    var post_url = $(this).attr("action"); //get form action url
                    var request_method = $(this).attr("method"); //get form GET/POST method
                    var form_data = $(this).serialize(); //Encode form elements for submission

                    jQuery.ajax({
                        url: post_url,
                        type: request_method,
                        data: form_data
                    }).done(function (response) {
                        $("#submit_a_comment").modal("toggle");
                        //alert(response);
                        post.parent().append(response);
                    });
                });
                $("#submit_comment_link a").click(function () {
                    post = $(this);
                    var data_id = '';
                    if (typeof $(this).data('id') !== 'undefined') {

                        data_id = $(this).data('id');
                    }

                    $('#tweetid').val(data_id);
                    $("#submit_a_comment").modal({
                        opacity: 80,
                        overlayCss: {backgroundColor: "#CCC"}


                    }); //end modal

                    return false;
                });
                $("#tweet_form").submit(function () {

                    $("#button").hide();
                });
                $("#myTweet").click(function () {
                    this.attributes["rows"].nodeValue = 5;
                    $("#button").show();
                }); //end of click event
                $("#myTweet").blur(function () {
                    this.attributes["rows"].nodeValue = 1;
                    //$("#button").hide();

                }); //end of click event
            });//end of ready event handler
            
        </script>

    </head>

    <body>
        <div class="modal" id="submit_a_comment">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Submit a Comment</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form id="frmComment" method="post" name="frmComment" action="replyajax.php">
                            <label for="comment">Comment:</label><br />
                            <textarea id="comment" name="comment" cols="40" rows="10"></textarea><br />
                            <input type="hidden" id="tweetid" name="tweetid">
                            <input type="submit" value="Submit" name="submit" />

                            <div id="server-results"><!-- For server results --></div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

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
                            <form method="post" id="tweet_form" action="tweet_proc.php">
                                <div class="form-group">
                                    <textarea class="form-control" name="myTweet" id="myTweet" rows="1" placeholder="What are you bitter about today?"></textarea>
                                    <input type="submit" name="button" id="button" value="Send" class="btn btn-primary btn-lg btn-block login-button"/>

                                </div>
                            </form>
                        </div>
                        <div class="img-rounded">
                            <!--display list of tweets here-->
                            <?php
                            $t = new Tweet();
                            $t->getTweets();
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
