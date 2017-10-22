<?php

session_start();
require_once "config/functions.php";

logout();
redirect_to(APP_ROOT . "/login.php"); //Redirect user to Login if not logged in