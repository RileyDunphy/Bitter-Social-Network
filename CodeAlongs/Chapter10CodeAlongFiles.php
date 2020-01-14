<?php
   //chapter 10
    $path = "c:/php/students.txt";
    printf ("the size of the file is %s bytes<BR>", filesize($path));
    printf("the name of the file is %s <BR>", basename($path, ".txt"));
    printf("folder only %s <BR>", dirname($path));
    
    //relative file paths
    $relPath = "../images/logo.jpg";
    echo "absolute path is " . realpath($relPath) . "<BR>";
    printf ("the size of the file is %s kilobytes<BR>", round(filesize($relPath)/1024,2));
    echo "DISK SPACE REMAINING: " . disk_free_space("c:") . "<BR>";
    echo "DISK TOTAL SPACE: " . disk_total_space("c:") . "<BR>";
    date_default_timezone_set("America/Halifax");
    //g means 12 hour format, G means is 24 hours format
    //i means minutes with leading zeroes
    //s means seconds with leading zeroes
    //a means lowercase am/pm, A would be uppercase AM/PM
    echo "file last accessed " . date("m-d-y g:i:sa", fileatime($relPath)) . "<BR>";
    echo "file last modified " . date("m-d-y g:i:sa", filemtime($relPath)) . "<BR>";
    
    //open the file
    //r means read
    //w means write
    //x means create
    //w+ means read and write
    //a means append
    $myFile = fopen($path, "a+");
    fwrite($myFile,"Johnny\r\n");
    fwrite($myFile,"asdf\r\n");
    fwrite($myFile,"asdf\r\n");
    rewind($myFile); //move the file pointer to the beginning of the file
    while(!feof($myFile)){
        //fgets reads a line
        //fgetc reads a single character
        //fread ignores line feed 
        echo fread($myFile, 10) . "<BR>";
    }
    fclose($myFile);
    
?>