<?php

// error reporting
error_reporting(E_ALL);

// require db and authentication user functions 
require_once("dbo.php");
require_once("functions.php");

//  start session 
session_start();

// auth message stack
$messages=array();


?>
