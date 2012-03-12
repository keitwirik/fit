<?php
// view and edit user data

require_once('dbo.php');
require_once('config.php');

function edit_user($u,$a,$g,$h,$e) {
    global $DBH;
    $STH = $DBH->prepare("UPDATE users SET 
                          age = :age,
                          height = :height,
                          gender = :gender,
                          email = :email
                          WHERE cookie_hash = :u_hash");

    //FIXME should sanitize something here
    $STH->bindParam(':u_hash', $u);
    $STH->bindParam(':age', $a);
    $STH->bindParam(':gender', $g);
    $STH->bindParam(':height', $h);
    $STH->bindParam(':email', $e);

    $STH->execute();
    
    return true;    
}


checkLoggedIn("yes");


if(isset($_GET['u'])) {
    $u = $_GET['u'];

    if((isset($_GET['age'])) &&
       (isset($_GET['gender'])) &&
       (isset($_GET['email'])) &&
       (isset($_GET['height']))) {
            // edit user data
            $user_age = $_GET['age'];
            $user_gender = $_GET['gender'];
            $user_height = $_GET['height'];
            $user_email = $_GET['email'];
            $edit_user = edit_user($u,$user_age,$user_gender,$user_height,$user_email);
    }

    // get current user data
    $STH = $DBH->query("SELECT * FROM users 
                        WHERE cookie_hash = '$u'");
    $STH ->setFetchMode(PDO::FETCH_OBJ);
    $user = $STH->fetch();
} else {
    echo "no user string";die;
    header("Location: index.php");
}



?>
<style type="text/css">
    label, input, select {display:block;}
</style>
<div id="user_profile">
    <header>
        <h1 class="user"><?php echo $user->name; ?></h1>
    </header>
    <form id="edit_user" method="GET" action="<?php echo $_SERVER["PHP_SELF"] . "?u=" . $user->cookie_hash;?>">
        <label for="age">Age <span class="required">*</span></label>
        <input type="text" 
               name="age" 
               size="2" 
               value="<?php echo $user->age;?>" 
        /> 
        <label for="gender">Gender <span class="required">*</span></label>
        <select name="gender">
            <option value="Female" 
            <?php if($user->gender == 'Female') {echo 'selected="selected"';} ?>
            >Female</option>
            <option value="Male" 
            <?php if($user->gender == 'Male'){echo 'selected="selected"';} ?>
            >Male</option>
        </select>
        <!-- <input type="text" name="gender" value="<?php echo $user->gender;?>" /> -->
        <label for="height">Height cm <span class="required">*</span> Note the 'cm'. That's centimeters, nobody wants to smell your imperial feet!</label>
        <input type="text" name="height" value="<?php echo $user->height;?>" />
        <label for="email">email</label>
        <input type="text" name="email" value="<?php echo $user->email;?>" />
        <input type="hidden" name="u" value="<?php echo $user->cookie_hash;?>">
        <input type="submit" value="Submit" /> 
    </form>
    <nav>
        <a href="index.php?u=<?php echo $user->cookie_hash;?>">That looks good. Let's go back to the app</a>
    </nav>

</div>



