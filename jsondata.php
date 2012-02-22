<?php
include 'dbconfig.php';

function short_time($timestamp){
    $short_date = date("j-M-Y", strtotime($timestamp));
    return $short_date;
}
//FIXME hardcoding the user id
$user_id = 1;

$labels = array(
    'weight' => 'Weight',
    'bmi' => 'BMI'
);

$db = mysql_connect($dbhost, $dbuser, $dbpassword) or die("Connection Error: " . mysql_error());
 
mysql_select_db($database) or die("Error connecting to db.");

$ranges_sql = 
        "SELECT
         MIN(weight) AS min_weight, MAX(weight) AS max_weight,
         MIN(bmi) AS min_bmi, MAX(bmi) AS max_bmi,
         MIN(body_fat) AS min_body_fat, MAX(body_fat) AS max_body_fat,
         MIN(muscle) AS min_muscle, MAX(muscle) AS max_muscle,
         MIN(body_age) AS min_body_age, MAX(body_age) AS max_body_age,
         MIN(visceral_fat) AS min_visceral_fat, 
         MAX(visceral_fat) AS max_visceral_fat,
         MIN(rm) AS min_rm, MAX(rm) AS max_rm,
         MIN(waist) AS min_waist, MAX(waist) AS max_waist
         FROM records
         WHERE user = '$user_id'";

$ranges_qry = mysql_query($ranges_sql) or die("Couldn't execute query.".mysql_error());

$ranges_result = mysql_fetch_array($ranges_qry,MYSQL_ASSOC);

$ranges_arr = array();
foreach($ranges_result as $k => $v){ 
    $ranges_arr[$k] = floatval($v);
}


$SQL = "SELECT id, timestamp, weight, bmi, body_fat, muscle, body_age,
         visceral_fat, rm, waist
         FROM records
         WHERE user = '$user_id' 
         ORDER BY timestamp";
$result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error());

$s = array();

while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
    $date = short_time($row['timestamp']);
    $s['weight'][] = array(
        $date,
        floatval($row['weight'])
    );
    $s['bmi'][] = array(
        $date,
        floatval($row['bmi'])
    );
    $s['body_fat'][] = array(
        $date,
        floatval($row['body_fat'])
    );
    $s['muscle'][] = array(
        $date,
        floatval($row['muscle'])
    );
    $s['body_age'][] = array(
        $date,
        floatval($row['body_age'])
    );
    $s['visceral_fat'][] = array(
        $date,
        floatval($row['visceral_fat'])
    );
    $s['rm'][] = array(
        $date,
        floatval($row['rm'])
    );
    $s['waist'][] = array(
        $date,
        floatval($row['waist'])
    );
}

$s['ranges'] = $ranges_arr;
$s['labels'] = $labels;
echo json_encode($s);
?>
