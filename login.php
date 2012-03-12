<?php

require_once("config.php");
include 'dbo.php';

// Check user not logged in already
checkLoggedIn("no");

// Page title:
$title="Member Login Page";

// if $submit variable set, login info submitted:
if(isset($_POST["submit"])) {

	// login must be between 4 and 15 chars containing alphanumeric chars only:
	field_validator("login name", $_POST["login"], "alphanumeric", 4, 15);
	// password must be between 4 and 15 chars - any characters can be used:
	field_validator("password", $_POST["password"], "string", 4, 15);

	// if there are $messages, errors were found in validating form data
	// show the index page (where the messages will be displayed):
	if($messages){
		doIndex();
		// explicity 'exit' from the script
		exit;
	}

    if( !($row = checkPass($_POST["login"], $_POST["password"])) ) {
		// login/passwd string not correct, create an error message:
        $messages[]="Incorrect login/password, try again";
    }

	//If there are error $messages, errors were found in validating form data above.
	if($messages){
		doIndex();
		exit;
	}

	// no errors log in
    cleanMemberSession($row->cookie_hash);

	header("Location: index.php?u=" . $row->cookie_hash . "");
} else {
	// The login form wasn't filled out yet, display the login form for the user to fill in:
	doIndex();
}

function doIndex() {
	/*
	Import the global $messages array.
	If any errors were detected above, they will be stored in the $messages array:
	*/
	global $messages;

	global $title;

	// drop out of PHP mode to display the plain HTML:
?>
<html>
<head>
<title><?php print $title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<?php doCSS(); ?>
<body>
<h1><?php print $title; ?></h1>
<p>Not signed up? <a href="join.php">join</a></p>
<?php
// if there are any messages stored in the $messages array, call the displayErrors
// function to output them to the browser:
if($messages) { displayErrors($messages); }

?>
<form action="<?php print $_SERVER["PHP_SELF"]; ?>" method="POST">
<table>
<tr><td>Login:</td><td><input type="text" name="login"
value="<?php print isset($_POST["login"]) ? $_POST["login"] : "" ; ?>"
maxlength="15"></td></tr>
<tr><td>Password:</td><td><input type="password" name="password" value="" maxlength="15"></td></tr>
<tr><td>&nbsp;</td><td><input name="submit" type="submit" value="Submit"></td></tr>
</table>
</form>
</body>
</html>
<?php
}
?>
