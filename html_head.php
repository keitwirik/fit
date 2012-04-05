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
    var hash = '<?php  echo $user->cookie_hash;?>';
    var begin_date = '<?php echo $begin_date;?>';
    <?php if($nogd == true) echo 'var nogd = true;';?>
    <?php if($result['count'] < 1) {
        echo 'var no_plot = true;';
    } else {
        echo 'var no_plot = false;';
    }?>
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

