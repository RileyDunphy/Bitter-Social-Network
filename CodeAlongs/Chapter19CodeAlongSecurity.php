<?php
//chapter 19 secure PHP programming
$myString = "Hello world";
echo md5($myString) . "<BR>";
//iv means initialization vector
//cbc cipher block chaining
$iv = openssl_random_pseudo_bytes(16);
$key = "123";
$message = openssl_encrypt($myString, "AES-128-CBC", OPENSSL_RAW_DATA, $key, $iv);
echo $message . "<BR>";
echo bin2hex("Hello world") . "<BR>";