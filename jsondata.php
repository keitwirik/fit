<?php
include 'dbo.php';

function short_time($timestamp){
    $short_date = date("j-M-Y", strtotime($timestamp));
    return $short_date;
}

function miss_date($var){
    if($var[1] != 0){
        return $var;
    }
}

//FIXME hardcoding the user id
$user_id = 1;

// default chart options
$chartopts = new stdClass;

$chartopts->title = array(
        'weight' => 'Weight Graph',
        'bmi' => 'BMI Graph',
        'body_fat' => 'Body Fat Percentage',
        'muscle' => 'Muscle Percentage"',
        'body_age' => 'Body Age Graph',
        'visceral_fat' => 'Visceral Fat Graph',
        'waist' => 'Waist (inches) Graph',
        'rm' => 'Resting Metabolism Graph'
    );    
$chartopts->label = array(
        'weight' => 'Weight',
        'bmi' => 'BMI',
        'body_fat' => 'Body Fat %',
        'muscle' => 'Muscle %"',
        'body_age' => 'Body Age',
        'visceral_fat' => 'Visceral Fat',
        'waist' => 'Waist (inches)',
        'rm' => 'Resting Metabolism'
    );

$chartopts->axesDefaults->labelRenderer = 
        '$.jqplot.CanvasAxisLabelRenderer';
$chartopts->axesDefaults->tickRenderer = 
        '$.jqplot.CanvasAxisTickRenderer';

$chartopts->axes->xaxis->label = 'Days';
$chartopts->axes->xaxis->min = '';
$chartopts->axes->xaxis->max = '';
$chartopts->axes->yaxis->label = 'Days';
$chartopts->axes->yaxis->min = '';
$chartopts->axes->yaxis->max = '';
$chartopts->highlighter->show = 'true';
$chartopts->highlighter->sizeAdjust = '7.5';
$chartopts->cursor->show = 'false';
$chartopts->series = array(
        'color' => 'orange'
);





// query for graph ranges

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

$ranges_arr = array();
foreach($ranges as $k => $v){ 
    $ranges_arr[$k] = floatval($v);
}


$s = new stdClass;

// apply default chartopts to s obj
$s->weight->chartoptions = $chartopts;
$s->bmi->chartoptions = $chartopts;
$s->body_fat->chartoptions = $chartopts;
$s->muscle->chartoptions = $chartopts;
$s->body_age->chartoptions = $chartopts;
$s->visceral_fat->chartoptions = $chartopts;
$s->rm->chartoptions = $chartopts;
$s->waist->chartoptions = $chartopts;

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
    $s->weight->data[] = array(
        $date,
        floatval($row->weight)
    );
    $s->bmi->data[] = array(
        $date,
        floatval($row->bmi)
    );
    $s->body_fat->data[] = array(
        $date,
        floatval($row->body_fat)
    );
    $s->muscle->data[] = array(
        $date,
        floatval($row->muscle)
    );
    $s->body_age->data[] = array(
        $date,
        floatval($row->body_age)
    );
    $s->visceral_fat->data[] = array(
        $date,
        intval($row->visceral_fat)
    );
    $s->rm->data[] = array(
        $date,
        floatval($row->rm)
    );
    $s->waist->data[] = array(
            $date,
            floatval($row->waist)
    );
}

// correct for days with missing entries, waist only
$s->waist->data = array_values(array_filter($s->waist->data, "miss_date"));

//$s->weight->chartoptions->axes->yaxis->label = $labels->weight;
$s->ranges = $ranges_arr;
$s->labels = $chartopts->label;
//print_r($s);
echo json_encode($s);
?>
