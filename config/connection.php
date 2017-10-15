<?php

require "config.php";

$connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD);

if($connection->connect_errno){
    die(sprintf("Connection Failed:%s",$connection->connect_error));
}

echo "Connection Successful";