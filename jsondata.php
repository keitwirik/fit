<?php
include 'dbconfig.php';

function short_time($timestamp){
    $short_date = date("j-M-Y", strtotime($timestamp));
    return $short_date;
}
$db = mysql_connect($dbhost, $dbuser, $dbpassword) or die("Connection Error: " . mysql_error());
 
// select the database 
mysql_select_db($database) or die("Error connecting to db.");

// the actual query for the grid data 
$SQL = "SELECT id, timestamp, weight, bmi, body_fat, muscle, body_age,
         visceral_fat, rm, waist FROM records 
         ORDER BY timestamp";
$result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error());

$s = '[[';
$i = 1;

while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
    //if($s != '[') $s .= ',';
   //$s .= '[';
   // $s .= short_time($row['timestamp']);
   // $s .=  ',';
    $s .= $row['weight'];
   // $s .= ']';
    $s .= ',';
    //$i++;
}
$s = substr($s,0,-1);
$s .= ']]';

echo $s;
//echo '[[[2, 3], [2, 4], [6, 9]]]';


?>
