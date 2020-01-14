<?php

//insert the user's data into the users table of the DB
//if everything is successful, redirect them to the login page.
//if there is an error, redirect back to the signup page with a friendly message
include("connect.php");
include("Includes/User.php");
if (isset($_POST["firstname"])) {
    //won't get here the first time you visit the page
    //will only get if a form has been submitted via post
    $u = new User();
    $u->firstName = mysqli_real_escape_string($con, $_POST["firstname"]);
    $u->lastName = mysqli_real_escape_string($con, $_POST["lastname"]);
    $u->email = mysqli_real_escape_string($con, $_POST["email"]);
    $u->userName = mysqli_real_escape_string($con, $_POST["username"]);
    $myHashedPassword = password_hash($_POST["password"], PASSWORD_DEFAULT);
    //Once you hash the password don't think you can inject sql with it but doesn't hurt I guess
    $u->password = mysqli_real_escape_string($con, $myHashedPassword);
    $u->contactNo = mysqli_real_escape_string($con, $_POST["phone"]);
    $u->address = mysqli_real_escape_string($con, $_POST["address"]);
    $u->province = mysqli_real_escape_string($con, $_POST["province"]);
    $u->postalCode = mysqli_real_escape_string($con, $_POST["postalCode"]);
    $u->url = mysqli_real_escape_string($con, $_POST["url"]);
    $u->description = mysqli_real_escape_string($con, $_POST["desc"]);
    $u->location = mysqli_real_escape_string($con, $_POST["location"]);

    //FEDEX POSTAL CODE API STUFF

    require_once('includes/fedex/fedex-common.php');
    $path_to_wsdl = "includes/fedex/wsdl/CountryService/CountryService_v5.wsdl";

    ini_set("soap.wsdl_cache_enabled", "0");

    $client = new SoapClient($path_to_wsdl, array('trace' => 1));

    $request['WebAuthenticationDetail'] = array(
        'ParentCredential' => array(
            'Key' => getProperty('parentkey'),
            'Password' => getProperty('parentpassword')
        ),
        'UserCredential' => array(
            'Key' => getProperty('key'),
            'Password' => getProperty('password')
        )
    );

    $request['ClientDetail'] = array(
        'AccountNumber' => getProperty('shipaccount'),
        'MeterNumber' => getProperty('meter')
    );
    $request['TransactionDetail'] = array('CustomerTransactionId' => ' *** Validate Postal Code Request using PHP ***');
    $request['Version'] = array(
        'ServiceId' => 'cnty',
        'Major' => '5',
        'Intermediate' => '0',
        'Minor' => '1'
    );

    $request['Address'] = array(
        'PostalCode' => $u->postalCode,
        'CountryCode' => 'CA'
    );

    $request['CarrierCode'] = 'FDXE';
    $response = $client->validatePostal($request);
    if ($response->HighestSeverity == "ERROR") {
        $msg = "You have entered an invalid Postal Code!";
        header("location:signup.php?message=$msg");
    } else {
        $msg = $u->insert();
        header("location:login.php?message=$msg");
    }
}//end of biggest if(isset)
?>