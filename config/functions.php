<?php

require_once "connection.php";

function is_logged_in(){
    if(isset($_SESSION['user_id']) && $_SESSION['username']){
        return true;
    }else{
        return false;
    }
}

function redirect_to($path){
    Header(sprintf("Location: %s",$path));
    exit();
}

function login_user($username,$password){
    $connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD);

    try{
        $query = sprintf("SELECT * FROM app_user WHERE username='%s' AND userPass='%s'",$username,sha1($password));
        $result = $connection->query($query);
        if(!$result){
            return false;
        }else{
            $user = $result->fetch_assoc();
            $_SESSION['user_id'] = $user['userID'];
            $_SESSION['username'] = $user['username'];
            return true;
        }

    }catch (Exception $e){
        error_log(sprintf("Login Attempt Failed: %s",$e->getMessage()));
        return false;
    }
}