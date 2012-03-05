<?php

include 'dbo.php';
//include 'mappings.php';

//convert timestamp to short_date
function short_time($timestamp){
    $short_date = date("j-M-Y", strtotime($timestamp));
    return $short_date;
}

//skips days without records
function miss_date($var){
    if($var[1] != 0){
        return $var;
    }
}

//FIXME hardcoding the user id
$user_id = 1;

// start chart class
class chart  {
    private $titles = array();
    private $labels = array();
    function __construct($chart_name) {
        global $DBH;
        global $user_id;
        global $ranges; 
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
        $this->axes->xaxis->pad = '0';
        $this->axes->xaxis->renderer = 'dar';
        $this->axes->yaxis->label = 'yaxis';
//        $this->axes->yaxis->min = $ranges->min_weight;
//        $this->axes->yaxis->max = $ranges->max_weight;
        $this->highlighter->show = 'true';
        $this->highlighter->sizeAdjust = '7.5';
        $this->cursor->show = 'false';
        $this->series->color = 'orange';

        $STH = $DBH->query("SELECT id, timestamp, weight, bmi, 
                            body_fat, muscle, body_age,
                            visceral_fat, rm, waist
                            FROM records
                            WHERE user = '$user_id' 
                            ORDER BY timestamp"
                           );

        $STH->setFetchMode(PDO::FETCH_OBJ);

        while($row = $STH->fetch()) {
            $date = short_time($row->timestamp);
            $this->data[] = array(
                $date,
                floatval($row->$chart_name)
            );
        }
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
$s = new stdClass;
$s->weight = new chart('weight');
$s->bmi =  new chart('bmi');
$s->body_fat = new chart('body_fat');
$s->muscle = new chart('muscle');
$s->body_age = new chart('body_age');
$s->visceral_fat = new chart('visceral_fat');
$s->waist = new chart('waist');
$s->rm = new chart('rm');


// correct for days with missing entries, waist only
$s->waist->data = array_values(array_filter($s->waist->data, "miss_date"));

$s->ranges = $ranges;

//print_r($s);
echo json_encode($s);
?>
