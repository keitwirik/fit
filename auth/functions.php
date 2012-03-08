<?php


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

    $STH = $DBH->prepare("SELECT cookie_hash 
                          FROM users WHERE name = :name");
    $STH->bindParam(':name', $name);
    $STH->setFetchMode(PDO::FETCH_OBJ);
    $STH->execute();
    $user = $STH->fetch();
    $hash_id = $user->cookie_hash;
	return $hash_id;
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
				header("Location: auth/login.php");
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


function checkPass($login, $password) {
    
    global $DBH;
    $STH = $DBH->prepare("SELECT name, password, cookie_hash FROM users 
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


function cleanMemberSession($hash_id) {
	$_SESSION["login"]=$hash_id;
	$_SESSION["loggedIn"]=true;
} 


function flushMemberSession() {
	// use unset to destroy the session variables
	unset($_SESSION["login"]);
	unset($_SESSION["password"]);
	unset($_SESSION["loggedIn"]);

	// and use session_destroy to destroy all data associated
	// with current session:
	session_destroy();

	return true;
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
	$email_regexp="^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|";
	$email_regexp.="(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$";

	# a hash array of "types of data" pointing to "regexps" used to validate the data:
	$data_types=array(
		"email"=>$email_regexp,
		"digit"=>"^[0-9]$",
		"number"=>"^[0-9]+$",
		"alpha"=>"^[a-zA-Z]+$",
		"alpha_space"=>"^[a-zA-Z ]+$",
		"alphanumeric"=>"^[a-zA-Z0-9]+$",
		"alphanumeric_space"=>"^[a-zA-Z0-9 ]+$",
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
		$field_ok = ereg($data_types[$field_type], $field_data);
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
