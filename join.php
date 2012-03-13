<?php

include_once("config.php");
require_once("dbo.php");

// Check user not logged in already:
checkLoggedIn("no");

// page title:
$title="Login";

// validate login form 

if(isset($_POST["submit"])){
	field_validator("login name", $_POST["login"], 
                    "alphanumeric", 4, 15);
	field_validator("password", $_POST["password"], 
                    "string", 4, 15);
	field_validator("confirmation password", $_POST["password2"], 
                    "string", 4, 15);

	// Check that password and password2 match:
	if(strcmp($_POST["password"], $_POST["password2"])) {
		// The password and confirmation password didn't match,
		// Add a message to be displayed to the user:
		$messages[]="Your passwords did not match";
	}

	//Checking the login name doesn't already exist in the users table

    $STH = $DBH->prepare("SELECT name FROM users 
                          WHERE name = :name");
    $name = $_POST["login"];
    $STH->bindParam(':name', $name);
    $STH->setFetchMode(PDO::FETCH_OBJ);

    $STH->execute();
    if($row = $STH->fetch()){
		$messages[]="Login ID \"".$row->name."\" already exists.  Try another.";
	}
	//Creating a new user entry in the users table

	if(empty($messages)) {
		// registration ok, get user id and update db with new info
		$user_id = newUser($_POST["login"], $_POST["password"]);

		// Log the user in:
		cleanMemberSession($user_id);

		// and then redirect them to the profile page:
		header("Location: profile.php");

	}
}
/*
the form with php FIXME this is a stupid way to do this 
*/
?>
<html>
<head>
<title><?php print $title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php doCSS(); ?>
</head>
<body>
<h1><?php print $title; ?></h1>
<?php
//Check if $message is set, and output it if it is:
if(!empty($messages)){
	displayErrors($messages);
}
?>
<form action="<?php print $_SERVER["PHP_SELF"]; ?>" method="POST">
<table>
<tr><td>Login:</td><td><input type="text" name="login"
value="<?php print isset($_POST["login"]) ? $_POST["login"] : "" ; ?>"
maxlength="15"></td></tr>
<tr><td>Password:</td><td><input type="password" name="password" value="" maxlength="15"></td></tr>
<tr><td>Confirm password:</td><td><input type="password" name="password2" value="" maxlength="15"></td></tr>
<tr><td>&nbsp;</td><td><input name="submit" type="submit" value="Submit"></td></tr>
</table>
</form>
</body>
</html>
