<?php

include_once("config.php");

// Check user logged in already:
checkLoggedIn("yes");

// Log user out:
flushMemberSession();

// Redirect:
header("Location: login.php");
?>
