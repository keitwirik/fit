<?php

// FIXME hardcoding the user id for now
require_once('dbo.php');
require_once('dbconfig.php');
require_once('config.php');

checkLoggedIn("yes");
if(isset($_GET['u'])){
    $u = $_GET['u'];
    // query user info
    $STH = $DBH->query("SELECT * FROM users 
                        WHERE cookie_hash = '$u'");
    $STH ->setFetchMode(PDO::FETCH_OBJ);
    $user = $STH->fetch();
    $user_id = $user->id;
    $user_hash = $user->cookie_hash;
//print_r($user_hash);die;
}

$db = mysql_connect($dbhost, $dbuser, $dbpassword) 
    or die("Connection Error:" . mysql_error());
// select the database 
mysql_select_db($database) or die("Error connecting to db.");

// intercept first timers with no data
$qry = mysql_query("SELECT COUNT(*) AS count FROM records WHERE user = '$user_id'");
$result = mysql_fetch_array($qry);
if($result['count'] < 1){
    header("Location: first_timers.php?u=$user_hash");
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

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Body Monitor</title>
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" /> 
<link rel="stylesheet" 
    type="text/css" media="screen" 
    href="css/reset.css" />
<link rel="stylesheet" 
    type="text/css" media="screen" 
    href="css/humanity/jquery-ui-1.8.17.custom.css" />
<link rel="stylesheet" 
    type="text/css" media="screen" 
    href="css/ui.jqgrid.css" />
<link rel="stylesheet" type="text/css" href="css/jquery.jqplot.css" /> 
<link rel="stylesheet" type="text/css" href="css/style.css" /> 
<link href='http://fonts.googleapis.com/css?family=Ubuntu:500italic,700italic,500,300,700,400italic,300italic,400' rel='stylesheet' type='text/css'>
<script type="text/javascript">
    var hash = '<?php echo $user_hash; ?>';
</script> 
<script src="js/jquery-1.7.1.min.js" type="text/javascript"></script>
<script src="js/i18n/grid.locale-en.js" type="text/javascript"></script>
<script src="js/jquery.jqGrid.min.js" type="text/javascript"></script>
<script src="js/jquery.jqplot.min.js" type="text/javascript"></script>
<script type="text/javascript" 
    src="js/plugins/jqplot.canvasTextRenderer.min.js"></script>
<script type="text/javascript" 
    src="js/plugins/jqplot.canvasAxisLabelRenderer.min.js"></script>
<script type="text/javascript" 
    src="js/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
<script type="text/javascript" 
    src="js/plugins/jqplot.dateAxisRenderer.min.js"></script>
<script type="text/javascript" 
    src="js/plugins/jqplot.trendline.min.js"></script>
<script type="text/javascript" 
    src="js/plugins/jqplot.highlighter.min.js"></script>
<script type="text/javascript" 
    src="js/plugins/jqplot.cursor.min.js"></script>
<script type="text/javascript" 
    src="js/plugins/jqplot.canvasOverlay.min.js"></script>
<script type="text/javascript" src="js/script.js"></script>
<!--[if lt IE 9]><script language="javascript" type="text/javascript" src="/js/excanvas.js"></script><![endif]-->
</head>
<body>
<div id="envelope">
    <header>
        <h1 class="user"><?php echo $user->name; ?> <span class="edit"><a href="profile.php?u=<?php echo $user->cookie_hash; ?>">edit</a></h1>
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
 
    <table id="list"><tr><td/></tr></table> 
    <div id="pager"></div>
</div>
</body>
</html>
