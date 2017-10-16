<?php

session_start();
require_once "config/functions.php";

logout();
redirect_to('login.php');