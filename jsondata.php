<?php

include 'app_top.php';
//include 'config.php';
include 'dbo.php';
//include 'mappings.php';
//include 'functions.php';

if(isset($_GET['u'])){
    $u = $_GET['u'];
    // query user info
    $STH = $DBH->query("SELECT * FROM users 
                        WHERE cookie_hash = '$u'");
    $STH ->setFetchMode(PDO::FETCH_OBJ);
    $user = $STH->fetch();
    $user_id = $user->id;
//print_r($user_id);die;
}
if(isset($_GET['r'])) {
    $date_range = $_GET['r'];
}else{
    $date_range = 0;
}
$date_range = date_ranges($date_range);
$begin_date = $date_range->format('Y-m-d');

// start chart class
class chart  {
    private $titles = array();
    private $labels = array();
    function __construct($chart_name) {
        global $DBH;
        global $user_id;
        global $ranges;
        global $begin_date; 
        $this->chartoptions = $chart_name;
        $this->titles = array(
            'weight' => 'Weight Graph',
            'bmi' => 'BMI Graph',
            'body_fat' => 'Body Fat Percentage',
            'muscle' => 'Muscle Percentage"',
            'body_age' => 'Body Age Graph',
            'visceral_fat' => 'Visceral Fat Graph',
            'waist' => 'Waist (inches) Graph',
            'rm' => 'Resting Metabolism Graph'
        );
        $this->labels = array(
            'weight' => 'Weight',
            'bmi' => 'BMI',
            'body_fat' => 'Body Fat %',
            'muscle' => 'Muscle %"',
            'body_age' => 'Body Age',
            'visceral_fat' => 'Visceral Fat',
            'waist' => 'Waist (inches)',
            'rm' => 'Resting Metabolism'
        );
        $this->title = $this->titles[$this->chartoptions];
        $this->label = $this->labels[$this->chartoptions];
        $this->axesDefaults->labelRenderer = 'calr';
        $this->axesDefaults->tickRenderer = 'catr';
        $this->axes->xaxis->label = 'Days';
        $this->axes->xaxis->pad = '20';
        $this->axes->xaxis->renderer = 'dar';
        $this->axes->yaxis->label = $this->labels[$this->chartoptions];
//    these are dealt with in ranges obj below 
//        $this->axes->yaxis->min = $ranges->min_weight;
//        $this->axes->yaxis->max = $ranges->max_weight;
        $this->highlighter->show = 'true';
        $this->highlighter->sizeAdjust = '7.5';
        $this->canvasOverlay->show = 'true';
        $this->cursor->show = 'false';
        $this->series->color = 'orange';

        $STH = $DBH->prepare("SELECT id, timestamp, weight, bmi, 
                            body_fat, muscle, body_age,
                            visceral_fat, rm, waist
                            FROM records
                            WHERE user = :user_id 
                            AND timestamp >= :begin_date
                            ORDER BY timestamp"
                           );
        $STH->bindParam(':user_id', $user_id);
        $STH->bindParam(':begin_date', $begin_date);
        $STH->setFetchMode(PDO::FETCH_OBJ);
        $STH->execute();
        while($row = $STH->fetch()) {
            $date = short_time($row->timestamp);
            $this->data[] = array(
                $date,
                floatval($row->$chart_name)
            );
        }
        $this->goal_data = missing_dates($this->data);
        $this->data = array_values(array_filter($this->goal_data, "miss_date"));
    }
}

$STH = $DBH->query("SELECT
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
         WHERE user = '$user_id'");

$STH->setFetchMode(PDO::FETCH_OBJ);

$ranges = $STH->fetch();
// if bottom and top range are both in the same zone
// I should pass a background color for the whole chart
// maybe even a gradient for mixed zones

$s = new stdClass;
$s->weight = new chart('weight');
unset($s->weight->goal_data);
$s->bmi =  new chart('bmi');
unset($s->bmi->goal_data);
$s->body_fat = new chart('body_fat');
unset($s->body_fat->goal_data);
$s->muscle = new chart('muscle');
unset($s->muscle->goal_data);
$s->body_age = new chart('body_age');
unset($s->body_age->goal_data);
$s->visceral_fat = new chart('visceral_fat');
unset($s->visceral_fat->goal_data);
$s->waist = new chart('waist');
unset($s->waist->goal_data);
$s->rm = new chart('rm');
unset($s->rm->goal_data);

// gather user info needed for overlays
$gender = $user->gender;
$age = $user->age;
$height = $user->height;

// get overlays from mappings
$s->overlay_bmi = zone_bmi();
$s->overlay_body_fat = zone_body_fat($gender,$age);
$s->overlay_muscle = zone_muscle($gender,$age);
$s->overlay_body_age = zone_body_age($age);
$s->overlay_visceral_fat = zone_visceral_fat();
$s->overlay_waist = zone_waist($gender);

// collect goal values
$g = $goal_obj;
$s->goal->weight = calc_goal($s->weight->data, $g->weight, $ret='index'); 
$s->goal->body_fat = calc_goal($s->body_fat->data, $g->body_fat, $ret='index'); 
$s->goal->muscle = calc_goal($s->muscle->data, $g->muscle,$ret='index'); 
$s->goal->body_age = calc_goal($s->body_age->data, $g->body_age, $ret='index'); 
$s->goal->visceral_fat = calc_goal($s->visceral_fat->data, $g->visceral_fat, $ret='index'); 
$s->goal->waist = calc_goal($s->waist->data, $g->waist); 


$s->ranges = $ranges;

//print_r($s);
echo json_encode($s);
?>
