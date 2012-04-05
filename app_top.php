<?php

include 'config.php';
include 'dbo.php';
include 'mappings.php';
include 'functions.php';

if(isset($_GET['u'])){
    $u = $_GET['u'];
    // query user info
    $STH = $DBH->query("SELECT * FROM users 
                        WHERE cookie_hash = '$u'");
    $STH ->setFetchMode(PDO::FETCH_OBJ);
    $user = $STH->fetch();
    $user_id = $user->id;
}

$date_range = 0;
if(isset($_GET['r'])) {
    $date_range = $_GET['r'];
}
$date_range = date_ranges($date_range);
$begin_date = $date_range->format('Y-m-d');
?>
