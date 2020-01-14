<?php
$format = "xml";
$url = "http://localhost/codealongs/chap18/MyFirstWS.php?temp=20&format=$format";
//cURL is versatile set of libraries that allow PHP to send/retrieve data via HTTP
//Google and Amazon (AWS) use web services a lot
$cobj = curl_init($url);
curl_setopt($cobj, CURLOPT_RETURNTRANSFER, 1);//returns the results to me, 
//instead of displaying it directly on the screen
$data = curl_exec($cobj);
curl_close($cobj); // don't forget to close it

if ($format == "json" ) {
    $object = array(json_decode($data));//convert it back to an array
    echo $object->{"temp"};//dereferencing the array object
    //echo $object[0];
    echo var_dump($object);
}
else {//xml
    $xmlObject = simplexml_load_string($data);
    //print_r($xmlObject);
    echo "the temp in F is" . $xmlObject->temp;
}

//call another weather APP
$url = "api.openweathermap.org/data/2.5/weather?q=Fredericton&units=metric&APPID=45bfb762ed60106a45fd68fdcc0848fa";
$client = curl_init($url);
curl_setopt($client, CURLOPT_RETURNTRANSFER, 1);
$data = curl_exec($client); 
$httpCode = curl_getinfo($client, CURLINFO_HTTP_CODE); 
//echo $httpCode . "  CODE<BR>";
curl_close($client); 

//echo ($data . "<BR>");
//echo "  2<BR>";
//true means associative array
$myArray = json_decode($data, true);
print_r($myArray);
echo $myArray["coord"]["lon"] . "<BR><BR>";
echo $myArray["weather"][0]["main"] . "  main<BR>";
echo $myArray["main"]["temp"] . "  temp<BR>";
echo $myArray["wind"]["speed"] . "  wind speed<BR>";
foreach ($myArray as $x) {
    
    echo print_r($x) . "<BR>";
}