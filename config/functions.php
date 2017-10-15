<?php

require_once "connection.php";

function is_logged_in()
{
    if (isset($_SESSION['user_id']) && $_SESSION['username']) {
        return true;
    } else {
        return false;
    }
}

function redirect_to($path)
{
    Header(sprintf("Location: %s", $path));
    exit();
}

function login_user($connection, $username, $password)
{
    try {
        $query = sprintf("SELECT * FROM app_user WHERE username='%s' AND userPass='%s'", $username, sha1($password));
        $result = $connection->query($query);
        if (!$result) {
            return false;
        } else {
            $user = $result->fetch_assoc();
            $_SESSION['user_id'] = $user['userID'];
            $_SESSION['username'] = $user['username'];
            return true;
        }

    } catch (Exception $e) {
        error_log(sprintf("Login Attempt Failed: %s", $e->getMessage()));
        return false;
    }
}

function insert_query($connection, $table, $args)
{
    try {
        $field_names = implode(",", array_keys($args));
        $field_values = implode("','", array_values($args));
        $query = sprintf("INSERT INTO %s (%s) VALUES ('%s')", $table, $field_names, $field_values);
        $result = $connection->query($query);
        if (!$result) {
            return false;
        } else {
            return $connection->insert_id;
        }
    } catch (Exception $e) {
        error_log(sprintf("Insert Attempt Failed: %s", $e->getMessage()));
        error_log(sprintf("Insert Attempt Table: %s", $table));
        return false;
    }
}

function query_set(&$value,$key)
{
    $value = sprintf("%s='%s'", $key, $value);
}

function update_query($connection, $table, $args, $where)
{
    try {
        array_walk($args,"query_set");
        array_walk($where,"query_set");
        $field_args = implode(",",  array_values($args));
        $field_where = implode(" = ", array_values($where));
        $query = sprintf("UPDATE %s SET %s WHERE %s ", $table, $field_args, $field_where);
        $result = $connection->query($query);

        if (!$result) {
            return false;
        } else {
            return true;
        }
    } catch (Exception $e) {
        error_log(sprintf("Insert Attempt Failed: %s", $e->getMessage()));
        error_log(sprintf("Insert Attempt Table: %s", $table));
        return false;
    }
}

function upload_files($file, $sub_dir = "")
{
    $target_dir = sprintf("uploads/%s", $sub_dir);
    $target_file = $target_dir . basename($file["FILES"]["name"]);
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

    if (getimagesize($file["FILES"]["tmp_name"]) === false) {
        return [
            "status" => false,
            "message" => "File is Fake"
        ];
    }

    if ($file["FILES"]["size"] > 500000) {
        return [
            "status" => false,
            "message" => "File is too Large"
        ];
    }

    if (!in_array($imageFileType, $file["allowed_ext"])) {
        return [
            "status" => false,
            "message" => "Invalid Extension"
        ];
    }

    if (move_uploaded_file($file["FILES"]["tmp_name"], sprintf("%s%s%s.%s", APP_PATH, $target_dir, $file["filename"], $imageFileType))) {
        return [
            "status" => true,
            "name" => sprintf("%s.%s",$file["filename"],$imageFileType)
        ];
    } else {
        return [
            "status" => false,
            "message" => "There was an error uploading your file"
        ];
    }
}

