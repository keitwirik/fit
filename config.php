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

// temp goals
class goal {
    function __construct($user) {
        $this->weight = 155;
        $this->body_fat = 18;
        $this->muscle = 45;
        $this->body_age = 40;
        $this->visceral_fat = 5;
        $this->waist = 36;
    }
}

$goal_obj = new goal('a');

?>
