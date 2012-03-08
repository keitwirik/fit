<?php

// error reporting
error_reporting(E_ALL);

// require db and authentication user functions 
require_once("dbo.php");
require_once("auth/functions.php");

//  Register session variables for auth
//FIXME these are depreciated
session_register("login");
session_register("password");
session_register("loggedIn");

// auth message stack
$messages=array();


?>
