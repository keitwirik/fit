<?php


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

// fills in missing dates with a value of zero
function missing_dates($arr) {
    foreach($arr as $a){
        $b[] = array(date("d-m-Y", strtotime($a[0])), $a[1]);
        $c[] = date("d-m-Y", strtotime($a[0]));
    }
    $begin=date_create(date("d-m-Y", strtotime($c[0])));
    $now=date_create(date("d-m-Y"));
    $i = new DateInterval('P1D');
    $period=new DatePeriod($begin,$i,$now);
    foreach ($period as $d){
      $day=$d->format('d-m-Y'); 
      if(in_array($day, $c)) {
        $q = array_search($day, $c);
        $f[] = array(date("j-M-Y", strtotime($day)), $b[$q][1]);   
      } else {
        $f[] = array(date("j-M-Y", strtotime($day)), '0');
      }
    }
    
    return $f;
}

function newUser($login, $password) {
    global $DBH;
    $STH = $DBH->prepare("INSERT INTO users (
                          name, password, cookie_hash) 
                          VALUES (
                          :name, :password, :cookie_hash)"
                        );
    $STH->bindParam(':name', $name);
    $STH->bindParam(':password', $password);
    $STH->bindParam(':cookie_hash', $cookie_hash);
    // insert new user
    $name = $login;
    $password = crypt($password, 
                      '$dif$saltisforlicking%$ydheks8e$3idkd93$');
    $cookie_hash =  crypt($name, '$mmcookies$');

    $STH->execute();

    $STH = $DBH->prepare("SELECT id 
                          FROM users WHERE name = :name
                          AND cookie_hash = :cookie_hash");
    $STH->bindParam(':name', $name);
    $STH->bindParam(':cookie_hash', $cookie_hash);
    $STH->setFetchMode(PDO::FETCH_OBJ);
    $STH->execute();
    $user = $STH->fetch();
    $user_id = $user->id;
	return $user_id;
} 


function displayErrors($messages) {
	print("<b>There were problems with the previous action.  Following is a list of the error messages generated:</b>\n<ul>\n");

	foreach($messages as $msg){
		print("<li>$msg</li>\n");
	}
	print("</ul>\n");
} 


function checkLoggedIn($status){
	switch($status){
		// if yes, check user is logged in:
		case "yes":
			if(!isset($_SESSION["loggedIn"])){
				header("Location: login.php");
				exit;
			}
			break;

		// if no, check NOT logged in:
		case "no":
			if(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true ){
				header("Location: index.php");
			}
			break;
	}
	// if got here, all ok, return true:
	return true;
} 

function getLoggedInUser(){
    global $DBH;
    $STH = $DBH->prepare("SELECT user_id 
                          FROM sessions
                          WHERE session_id = :session_id");
    $session_id = session_id();
    $STH->bindParam(':session_id', $session_id);
    $STH->setFetchMode(PDO::FETCH_OBJ);
    $STH->execute();
    $row = $STH->fetch();
    $user_id = $row->user_id;
    return $user_id;
}

function checkPass($login, $password) {
    
    global $DBH;
    $STH = $DBH->prepare("SELECT id, name, password
                          FROM users 
                          WHERE name = :name 
                          AND password = :password");
    
    $name = $login;
    $password = crypt($password, 
                      '$dif$saltisforlicking%$ydheks8e$3idkd93$');

    $STH->bindParam(':name', $name);
    $STH->bindParam(':password', $password);
    $STH->setFetchMode(PDO::FETCH_OBJ);

    $STH->execute();
    if($row = $STH->fetch()){
        $user = $row;
        return $user;
    }
    // bad login
    return false;
} 


function cleanMemberSession($id) {
    global $DBH;
    $STH = $DBH->prepare("INSERT INTO sessions (user_id, session_id)
                          values (:id, :session)");
	$_SESSION["user"]=$id;
    $_SESSION["loggedIn"]=true;
    $session = session_id();
	$STH->bindParam(':id', $id);
	$STH->bindParam(':session', $session);
    $STH->execute();
} 


function flushMemberSession() {
	// use unset to destroy the session variables
	unset($_SESSION["login"]);
	unset($_SESSION["password"]);
	unset($_SESSION["loggedIn"]);
    unset($_SESSION["user"]);


    global $DBH;
    $STH = $DBH->prepare("DELETE FROM sessions WHERE
                          session_id =  :session");
    $session = session_id();
	$STH->bindParam(':session', $session);
    $STH->execute();
	// and use session_destroy to destroy all data associated
	// with current session:
    session_unset();
	session_destroy();
	return true;
}
// calculates projected goal values
// takes an array of data, index and value. 
// projection_n is the goal value
// returns the projected index for the projection_n value.
// $ret can be "index" or "value"
// if "value" the function uses projection_n as the index
// and returns the projected value for that index  
function calc_goal($data, $projection_n, $ret = "index") {

    $x = array();
    $y = array();
    $n = 0;
    $xx = array();
    $xy = array();
    $sum_x = 0;
    $sum_y = 0;
    $sum_xy = 0;
    $sum_xx = 0;
    $slope = 0;
    $intercept = 0;

    if($ret == "value") {
        foreach($data as $k => $v) {
            $k++;
            $x[] = $k;      // index of days
            $y[] = $v[1];   // values of measurment
        }

    } elseif($ret == "index") {
        foreach($data as $k => $v) {
            $k++;
            $y[] = $k;      // index of days
            $x[] = $v[1];   // values of measurment
        }
    }

    $n = count($x);

    
    foreach($x as $k => $v) {
        $xx[] = ($v * $v);
        $xy[] = ($y[$k] * $v);
        $sum_x = ($sum_x + $v);
        $sum_xy = ($sum_xy + ($v * $y[$k]));
        $sum_xx = ($sum_xx + ($v * $v));
    }
    foreach($y as $k => $v) {
        $sum_y = ($sum_y + $v);
    }

    $slope = round((($n * $sum_xy) - ($sum_x * $sum_y)) / 
                    ($n * $sum_xx - ($sum_x * $sum_x)), 2);  

    $intercept = round((($sum_y - ($slope * $sum_x)) / $n), 4);

    $projection_val = $intercept + ($slope * $projection_n);

    if($ret == "value") {
         $projection_val = round($projection_val);
    }
    if($ret == "index") {
        $projection_val = intval($projection_val);
    }

    return $projection_val;

}


function doCSS() {
	?>
<style type="text/css">
body{font-family: Arial, Helvetica; font-size: 10pt}
h1{font-size: 12pt}
</style>
	<?php
} // end func doCSS()

# function validates HTML form field data passed to it:
function field_validator($field_descr, $field_data,
  $field_type, $min_length="", $max_length="",
  $field_required=1) {

	global $messages;

	# first, if no data and field is not required, just return now:
	if(!$field_data && !$field_required){ return; }

	# initialize a flag variable - used to flag whether data is valid or not
	$field_ok=false;

	# this is the regexp for email validation:
	$email_regexp="/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|/";
	$email_regexp.="/(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/";

	# a hash array of "types of data" pointing to "regexps" used to validate the data:
	$data_types=array(
		"email"=>$email_regexp,
		"digit"=>"/^[0-9]$/",
		"number"=>"/^[0-9]+$/",
		"alpha"=>"/^[a-zA-Z]+$/",
		"alpha_space"=>"/^[a-zA-Z ]+$/",
		"alphanumeric"=>"/^[a-zA-Z0-9]+$/",
		"alphanumeric_space"=>"/^[a-zA-Z0-9 ]+$/",
		"string"=>""
	);

	# check for required fields
	if ($field_required && empty($field_data)) {
		$messages[] = "$field_descr is a required field.";
		return;
	}

	# if field type is a string, no need to check regexp:
	if ($field_type == "string") {
		$field_ok = true;
	} else {
		# Check the field data against the regexp pattern:
		$field_ok = preg_match($data_types[$field_type], $field_data);
	}

	# if field data is bad, add message:
	if (!$field_ok) {
		$messages[] = "Please enter a valid $field_descr.";
		return;
	}

	# field data min length checking:
	if ($field_ok && ($min_length > 0)) {
		if (strlen($field_data) < $min_length) {
			$messages[] = "$field_descr is invalid, it should be at least $min_length character(s).";
			return;
		}
	}

	# field data max length checking:
	if ($field_ok && ($max_length > 0)) {
		if (strlen($field_data) > $max_length) {
			$messages[] = "$field_descr is invalid, it should be less than $max_length characters.";
			return;
		}
	}
}
?>
