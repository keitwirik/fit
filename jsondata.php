<?php
include 'dbconfig.php';

function short_time($timestamp){
    $short_date = date("j-M-Y", strtotime($timestamp));
    return $short_date;
}

$db = mysql_connect($dbhost, $dbuser, $dbpassword) or die("Connection Error: " . mysql_error());
 
mysql_select_db($database) or die("Error connecting to db.");

$SQL = "SELECT id, timestamp, weight, bmi, body_fat, muscle, body_age,
         visceral_fat, rm, waist FROM records 
         ORDER BY timestamp";
$result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error());

$s = array();

while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
    $s[] = array(
        short_time($row['timestamp']),
        $row['weight']
    );
}
echo json_encode($s);
?>
