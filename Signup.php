<?php
    session_start();
    if(isset($_GET["message"])){
        $message = $_GET["message"];
        echo "<script>alert('$message')</script>";
    }
?>
<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="This is where you enter your information and sign up to make an account for the Bitter website">
        <meta name="author" content="Riley Dunphy, rileydunphy@live.ca">
        <link rel="icon" href="favicon.ico">

        <title>Signup - Bitter</title>

        <!-- Bootstrap core CSS -->
        <link href="includes/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="includes/starter-template.css" rel="stylesheet">
        <!-- Bootstrap core JavaScript-->
        <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>

        <script src="includes/bootstrap.min.js"></script>

        <script type="text/javascript">
            var check = function () {
                if (document.getElementById('password').value ==
                        document.getElementById('confirm_password').value) {
                    document.getElementById('message').style.color = 'green';
                    document.getElementById('message').innerHTML = 'matching';
                    document.getElementById('postalCode').innerHTML = 'matching';
                    return true;
                } else {
                    document.getElementById('message').style.color = 'red';
                    document.getElementById('message').innerHTML = 'not matching';
                    return false;
                }
            }
        </script>
    </head>

    <body>

        <?php
        include("Includes/headernotloggedin.php");?>

        <BR><BR>
        <div class="container">
            <div class="row">

                <div class="main-login main-center">
                    <h5>Sign up once and troll as many people as you like!</h5>
                    <form method="post" id="registration_form" onsubmit="return check();" action="signup_proc.php">

                        <div class="form-group">
                            <label for="name" class="cols-sm-2 control-label">First Name</label>
                            <div class="cols-sm-10">
                                <div class="input-group">

                                    <input type="text" maxlength="50" class="form-control" required name="firstname" id="firstname"  placeholder="Enter your First Name"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="cols-sm-2 control-label">Last Name</label>
                            <div class="cols-sm-10">
                                <div class="input-group">

                                    <input type="text" maxlength="50" class="form-control" required name="lastname" id="lastname"  placeholder="Enter your Last Name"/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="cols-sm-2 control-label">Your Email</label>
                            <div class="cols-sm-10">
                                <div class="input-group">

                                    <input type="email" maxlength="100" class="form-control" required name="email" id="email"  placeholder="Enter your Email"/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="username" class="cols-sm-2 control-label">Screen Name</label>
                            <div class="cols-sm-10">
                                <div class="input-group">

                                    <input type="text" maxlength="50" class="form-control" required name="username" id="username"  placeholder="Enter your Screen Name"/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="cols-sm-2 control-label">Password</label>
                            <div class="cols-sm-10">
                                <div class="input-group">

                                    <input type="password" maxlength="250" class="form-control" required name="password" id="password" onkeyup='check();' placeholder="Enter your Password"/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="confirm" class="cols-sm-2 control-label">Confirm Password</label>
                            <div class="cols-sm-10">
                                <div class="input-group">

                                    <input type="password" maxlength="250" class="form-control" required name="confirm_password" id="confirm_password" onkeyup='check();' placeholder="Confirm your Password"/>
                                </div>
                            </div>
                        </div>
                        <!--Tells user if passwords match-->
                        <span id='message'></span>

                        <div class="form-group">
                            <label for="name" class="cols-sm-2 control-label">Phone Number</label>
                            <div class="cols-sm-10">
                                <div class="input-group">

                                    <input type="tel" maxlength="25" class="form-control" required name="phone" id="phone"  placeholder="Enter your Phone Number" pattern="\d{3}[\-]\d{3}[\-]\d{4}" title="Phone Number Format 123-456-7890"/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="cols-sm-2 control-label">Address</label>
                            <div class="cols-sm-10">
                                <div class="input-group">

                                    <input type="text" maxlength="200" class="form-control" required name="address" id="address"  placeholder="Enter your Address"/>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="name" class="cols-sm-2 control-label">Province</label>
                            <div class="cols-sm-10">
                                <div class="input-group">

                                    <select name="province" id="province" class="textfield1" required><?php echo $vprovince; ?> 
                                        <option> </option>
                                        <option value="British Columbia">British Columbia</option>
                                        <option value="Alberta">Alberta</option>
                                        <option value="Saskatchewan">Saskatchewan</option>
                                        <option value="Manitoba">Manitoba</option>
                                        <option value="Ontario">Ontario</option>
                                        <option value="Quebec">Quebec</option>
                                        <option value="New Brunswick">New Brunswick</option>
                                        <option value="Prince Edward Island">Prince Edward Island</option>
                                        <option value="Nova Scotia">Nova Scotia</option>
                                        <option value="Newfoundland and Labrador">Newfoundland and Labrador</option>
                                        <option value="Northwest Territories">Northwest Territories</option>
                                        <option value="Nunavut">Nunavut</option>
                                        <option value="Yukon">Yukon</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="cols-sm-2 control-label">Postal Code</label>
                            <div class="cols-sm-10">
                                <div class="input-group">

                                    <input type="text" maxlength="7" class="form-control" required name="postalCode" id="postalCode"  placeholder="Enter your Postal Code" pattern="[A-Za-z][0-9][A-Za-z] [0-9][A-Za-z][0-9]" title="Postal Code"/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="cols-sm-2 control-label">Url</label>
                            <div class="cols-sm-10">
                                <div class="input-group">

                                    <input type="text" maxlength="50" class="form-control" name="url" id="url"  placeholder="Enter your URL"/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="cols-sm-2 control-label">Description</label>
                            <div class="cols-sm-10">
                                <div class="input-group">

                                    <input type="text" maxlength="160" class="form-control" required name="desc" id="desc"  placeholder="Description of your profile"/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="cols-sm-2 control-label">Location</label>
                            <div class="cols-sm-10">
                                <div class="input-group">

                                    <input type="text" maxlength="50" class="form-control" name="location" id="location"  placeholder="Enter your Location"/>
                                </div>
                            </div>
                        </div>


                        <div class="form-group ">
                            <input type="submit" name="button" id="button" value="Register" class="btn btn-primary btn-lg btn-block login-button"/>

                        </div>

                    </form>
                </div>

            </div> <!-- end row -->
        </div><!-- /.container -->

    </body>
    <footer class="text-center"><a href="ContactUs.php"><br>Contact Us</a></footer>
</html>