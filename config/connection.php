<?php

require "config.php";

//SQL Should throw Exceptions
mysqli_report(MYSQLI_REPORT_STRICT);

try{
    //SQL Connection
    $connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD);
}catch (Exception $e){
    die(sprintf("Connection Failed: %s",$e->getMessage()));
}

echo "Connection Successful";