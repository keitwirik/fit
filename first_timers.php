<?php

include_once("config.php");

// Check user logged in already:
checkLoggedIn("yes");

// Log user out:
flushMemberSession();

echo 'this is your first time here, or I don\'t have any records for you.<br>That\'s unfortunate cuz I haven\'t dealt with that yet. Your first record will have to be manually put into the database for us to get anywhere.<br> That is all.'; 

?>
