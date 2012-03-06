<?php

// returns array zones
function zone_bmi() {
    $zones_bmi = array(
        'show' => true,
        'u1' => 10.7,
        'u2' => 14.5,
        'u3' => 18.4,
        'n1' => 20.5,
        'n2' => 22.7,
        'n3' => 24.9,
        'o1' => 26.5,
        'o2' => 28.2,
        'o3' => 29.9,
        'v1' => 34.9,
        'v2' => 39.9,
        'v3' => 90.0
    );
    return $zones_bmi;
}

function zone_body_fat($gender,$age) {
    if($gender == "Male") {
        switch($age) {
            case ($age < 20):
                break;
            case ($age < 39):    
                $zones_body_fat = array(
                    'show' => true,
                    'u' => 8,
                    'n' => 19.9,
                    'o' => 24.9,
                    'v' => 100
                );
                return $zones_body_fat;
            case ($age < 59):    
                $zones_body_fat = array(
                    'show' => true,
                    'u' => 11,
                    'n' => 21.9,
                    'o' => 27.9,
                    'v' => 100
                );
                return $zones_body_fat;
            case ($age < 79):    
                $zones_body_fat = array(
                    'show' => true,
                    'u' => 13,
                    'n' => 24.9,
                    'o' => 29.9,
                    'v' => 100
                );
                return $zones_body_fat;
            default:
                break;
        }
    } elseif($gender == "Female") {   
        switch($age) {
            case ($age < 20):
                break;
            case ($age < 39):    
                $zones_body_fat = array(
                    'show' => true,
                    'u' => 21,
                    'n' => 32.9,
                    'o' => 38.9,
                    'v' => 100
                );
                return $zones_body_fat;
            case ($age < 59):    
                $zones_body_fat = array(
                    'show' => true,
                    'u' => 23,
                    'n' => 33.9,
                    'o' => 39.9,
                    'v' => 100
                    );
                return $zones_body_fat;
            case ($age < 79):    
                $zones_body_fat = array(
                    'show' => true,
                    'u' => 24,
                    'n' => 35.9,
                    'o' => 41.9,
                    'v' => 100
                );
                return $zones_body_fat;
            default:
                break;
        }
    } else {
        return;
    }
}

function zone_muscle($gender,$age) {
    if($gender == "Male") {
        switch($age) {
            case ($age < 18):
                break;
            case ($age < 39):    
                $zones_muscle = array(
                    'show' => true,
                    'u' => 33.3,
                    'n' => 39.9,
                    'o' => 44,
                    'v' => 100
                );
                return $zones_muscle;
            case ($age < 59):    
                $zones_muscle = array(
                    'show' => true,
                    'u' => 33.1,
                    'n' => 39.1,
                    'o' => 43.8,
                    'v' => 100
                );
                return $zones_muscle;
            case ($age < 81):    
                $zones_muscle = array(
                    'show' => true,
                    'u' => 32.9,
                    'n' => 38.9,
                    'o' => 43.8,
                    'v' => 100
                );
                return $zones_muscle;
            default:
                break;
        }
    } elseif($gender == "Female") {   
        switch($age) {
            case ($age < 18):
                break;
            case ($age < 39):    
                $zones_muscle = array(
                    'show' => true,
                    'u' => 24.3,
                    'n' => 30.3,
                    'o' => 35.3,
                    'v' => 100
                );
                return $zones_muscle;
            case ($age < 59):    
                $zones_muscle = array(
                    'show' => true,
                    'u' => 24.1,
                    'n' => 30.1,
                    'o' => 35.1,
                    'v' => 100
                    );
                return $zones_muscle;
            case ($age < 81):    
                $zones_muscle = array(
                    'show' => true,
                    'u' => 23.9,
                    'n' => 29.9,
                    'o' => 34.9,
                    'v' => 100
                );
                return $zones_muscle;
            default:
                break;
        }
    } else {
        return;
    }
}

//print_r(zone_body_fat('Male', 80));
?>
