<?php
session_start();
//this is the main page for our Bitter website, 
//it will display all tweets from those we are trolling
//as well as recommend people we should be trolling.
//you can also post a tweet from here
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="The contact page for the Bitter Social Network, where you will find our address, email, telephone and fax numbers">
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
        <?php include("Includes/header.php"); ?>
        <BR><BR>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="img-rounded">
                        <?php
                        $search = strtolower($_GET["search"]);
                        echo "<b>Users found:</b>";
                        echo "<hr>";
                        $u = new User();
                        $u->getUsersSearch($search);
                        echo "<b>Tweets found:</b>";
                        echo "<hr>";
                        $t = new Tweet();
                        $t->getTweetsSearch($search);
                        ?>
                    </div>
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