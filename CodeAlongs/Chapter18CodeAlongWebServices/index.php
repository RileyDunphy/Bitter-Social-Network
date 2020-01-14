<?php

$format = "xml";
$url = "http://localhost/CodeAlongs/Chapter18CodeAlongWebServices/MyFirstWS.php?temp=99&format=$format";
//cURL is versatile set of libraries that allow PHP to send/retrieve data via HTTP
//Google and Amazon (AWS) use web services a lot
$cobj = curl_init($url);
curl_setopt($cobj, CURLOPT_RETURNTRANSFER, 1); //returns the results to me, instead of displaying it directly on the screen
$data = curl_exec($cobj);
curl_close($cobj); //don't forget to close it

if ($format == "json") {
    $object = json_decode($data); //convert it back to an array
    echo $object->{"temp"}; //dereferencing the array object
    echo var_dump($object);
} else {
    $xmlObject = simplexml_load_string($data);
    //print_r($xmlObject);
    echo "The temp in F is " . $xmlObject->temp;
}