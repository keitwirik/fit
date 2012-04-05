<?php
$nogd = true;
require_once('app_top.php');
require_once('dbo.php');
require_once('dbconfig.php');
require_once('config.php');

$db = mysql_connect($dbhost, $dbuser, $dbpassword) 
    or die("Connection Error:" . mysql_error());
// select the database 
mysql_select_db($database) or die("Error connecting to db.");

// intercept first timers with no data
$qry = mysql_query("SELECT COUNT(*) AS count FROM records WHERE user = '$user_id'");
$result = mysql_fetch_array($qry);
if($result['count'] < 1){
   // header("Location: first_timers.php");
}

function get_user($user_id){
    $user_qry = mysql_query("SELECT * FROM users 
                             WHERE id = '$user_id'")
        or die("Couldn't execute query.".mysql_error());
    $user = mysql_fetch_object($user_qry);
    return $user;
}

$user= get_user($user_id);
?>

<?php
    include 'html_head.php';
?>

<body>
<div id="envelope">
    <header>
        <h1 class="user"><?php echo $user->name; ?> <span class="edit"><a href="profile.php">edit</a></h1>
        <h2 class="motd">motd - daily aphorism here</h2>
        <p class="logout"><a href="logout.php">log out</a></p>
    </header>   
    <nav class="chart_nav">
        <ul>
            <li class="nav_weight nav_active">weight</li>
            <li class="nav_bmi">bmi</li>
            <li class="nav_body_fat">body fat</li>
            <li class="nav_muscle">muscle</li>
            <li class="nav_body_age">body age</li>
            <li class="nav_visceral_fat">visceral fat</li>
            <li class="nav_waist">waist</li>
            <li class="nav_rm">rm</li>
        </ul> 
    </nav>
    <div id="plot1" class="chart"></div>
    <div id="plot2" class="chart"></div>
    <div id="plot3" class="chart"></div>
    <div id="plot4" class="chart"></div>
    <div id="plot5" class="chart"></div>
    <div id="plot6" class="chart"></div>
    <div id="plot7" class="chart"></div>
    <div id="plot8" class="chart"></div>
 
</div>
</body>
</html>
