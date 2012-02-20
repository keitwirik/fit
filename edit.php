<?php

//FIXME hardcoding the user
$user_id = 1;

require_once('dbconfig.php');

$db = mysql_connect($dbhost, $dbuser, $dbpassword) 
    or die("Connection Error:" . mysql_error());
// select the database 
mysql_select_db($database) or die("Error connecting to db.");

function get_user($user_id){
    $user_qry = mysql_query("SELECT * FROM users WHERE id = '$user_id'")
        or die("Couldn't execute query.".mysql_error());
    $user = mysql_fetch_object($user_qry);
    return $user;
}

if((isset($_POST['oper'])) && ($_POST['oper'] == 'add')){
    if(isset($_POST['bmi'])) $bmi = mysql_real_escape_string($_POST['bmi']);
    if(isset($_POST['body_age'])) $body_age = mysql_real_escape_string($_POST['body_age']);
    if(isset($_POST['rm'])) $rm = mysql_real_escape_string($_POST['rm']);
    if(isset($_POST['body_fat'])) $body_fat = mysql_real_escape_string($_POST['body_fat']);
    if(isset($_POST['muscle'])) $muscle = mysql_real_escape_string($_POST['muscle']);
    if(isset($_POST['visceral_fat'])) $visceral_fat = mysql_real_escape_string($_POST['visceral_fat']);
    if(isset($_POST['weight'])) $weight = mysql_real_escape_string($_POST['weight']);
    if(isset($_POST['waist'])) $waist = mysql_real_escape_string($_POST['waist']);
}

$insert = mysql_query("INSERT INTO records (
                                            user, 
                                            bmi, 
                                            body_age, 
                                            body_fat, 
                                            muscle, 
                                            visceral_fat, 
                                            weight,
                                            rm,
                                            waist) 
                                    VALUES (
                                            '$user_id',
                                            '$bmi',
                                            '$body_age',
                                            '$body_fat',
                                            '$muscle',
                                            '$visceral_fat',
                                            '$weight',
                                            '$rm',
                                            '$waist')
                      "); 
?>









