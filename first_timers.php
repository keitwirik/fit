<?php

include_once("config.php");

// Check user logged in already:
checkLoggedIn("yes");


include 'html_head.php';

?>

<body id="first_timer">
<div id="envelope">
    <h2>First Entry</h2>
    <p>Now that we have your profile information set, we're ready to take your first reading</p>
    <div>
        <form style="width: 100%; overflow: auto; position: relative; height: auto;" onsubmit="return false;" class="FormGrid" id="FrmGrid_list" name="FormPost">
            <label for="weight">weight</label>
            <input type="text" size="15" id="weight" name="weight">
            <label for="bmi">bmi</label>
            <input type="text" size="15" id="bmi" name="bmi">
            <label for="body_fat">body_fat</label>
            <input type="text" size="15" id="body_fat" name="body_fat">
            <label for="muscle">muscle</label>
            <input type="text" size="15" id="muscle" name="muscle">
            <label for="body_age">body_age</label>
            <input type="text" size="15" id="body_age" name="body_age">
            <label for="visceral_fat">visceral_fat</label>
            <input type="text" size="15" id="visceral_fat" name="visceral_fat">
            <label for="waist">waist</label>
            <input type="text" size="15" id="waist" name="waist">
            <label for="rm">rm</label>
            <input type="text" size="15" id="rm" name="rm">
            <input type="submit" value="Submit" />
</div>
</body>
</html>



<?php
// Log user out:
flushMemberSession();


?>
