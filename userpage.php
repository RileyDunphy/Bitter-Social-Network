<?php
session_start();
//displays all the details for a particular Bitter user
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="This is your user page for your Bitter account, where you will find the tweets and photo's you have uploaded as well as your account information">
        <meta name="author" content="Riley Dunphy, rileydunphy@live.ca">
        <link rel="icon" href="favicon.ico">

        <title>Bitter - Social Media for Trolls, Narcissists, Bullies and Presidents</title>

        <!-- Bootstrap core CSS -->
        <link href="includes/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="includes/starter-template.css" rel="stylesheet">
        <!-- Bootstrap core JavaScript-->
        <script src="https://code.jquery.com/jquery-1.10.2.js" ></script>
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

        <?php include("Includes/header.php"); ?>
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
                            $u = new User();
                            $u->getUserById($_GET["user_id"]);
                            if ($u->profImage != "") {
                                echo "<img class=\"bannericons\" src=\"images/profilepics/" . $_GET["user_id"] . "/" . $u->profImage . "\">";
                            } else {
                                echo "<img class=\"bannericons\" src=\"images/profilepics/default.jfif\">";
                            }
                            echo " " . $u->firstName . " " . $u->lastName . "<BR></div>";

                            $u->getUserStats($_GET["user_id"]);
                            ?>
                            <img class="icon" src="images/location_icon.jpg"><?php echo $u->province; ?>
                            <div class="bold">Member Since:</div>
                            <div><?php echo date("F d, Y", strtotime($u->dateAdded)); ?></div>
                        </div><BR><BR>

                        <div class="trending img-rounded">
                            <?php $u->getFollowersYouKnow($_GET["user_id"]); ?>

                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="img-rounded">

                        </div>
                        <div class="img-rounded">
                            <?php
                            $t = new Tweet();
                            $t->getTweetsForUser($_GET["user_id"]);
                            ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="whoToTroll img-rounded">
                            <div class="bold">Who to Troll?<BR></div>
                                <?php
                                $u = new User();
                                $u->getUsersToFollow();
                                ?>

                        </div><BR>

                    </div>
                </div> <!-- end row -->
            </div><!-- /.container -->



            <!-- Bootstrap core JavaScript
            ================================================== -->
            <!-- Placed at the end of the document so the pages load faster -->
            <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
            <script src="includes/bootstrap.min.js"></script>

    </body>
</html>
