<?php

// FIXME hardcoding the user id for now
$user_id = 1;

require_once('dbconfig.php');

$db = mysql_connect($dbhost, $dbuser, $dbpassword) 
    or die("Connection Error:" . mysql_error());
// select the database 
mysql_select_db($database) or die("Error connecting to db.");


function get_user($user_id){
    $user_qry = mysql_query("SELECT * FROM users WHERE id = '$user_id'")
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
<link rel="stylesheet" type="text/css" media="screen" href="css/reset.css" />
<link rel="stylesheet" type="text/css" media="screen" href="css/humanity/jquery-ui-1.8.17.custom.css" />
<link rel="stylesheet" type="text/css" media="screen" href="css/ui.jqgrid.css" />
<link rel="stylesheet" type="text/css" href="css/jquery.jqplot.css" /> 

<style>
html, body {
    margin: 0;
    padding: 0;
    font-size: 75%;
}

#envelope {
    margin:10px auto;
    width:775px;
    border:1px dotted #aaa;
    padding:10px;
    border-radius:10px;
}

#envelope header h1 {float:left;margin-right:10px;}

header {display:block;}

div.ui-jqgrid-bdiv {height:250px;}

.chart {
    width:750px;
    margin:10px 0;
}

nav.chart_nav ul li {
    list-style:none;
    display:inline;
    margin:0 15px;
    font-size:16px;
    cursor:pointer;
}

.ui-jqgrid {
    font-size:15px;
}

body #editmodlist {
    font-size:18px;
    position:fixed!important;
    top:10px!important;
    margin:0 auto!important;
    left:33%!important;
}

#plot2, #plot3, #plot4, #plot5, #plot6, #plot7, #plot8 {
    display:none;
}

</style>
 
<script src="js/jquery-1.7.1.min.js" type="text/javascript"></script>
<script src="js/i18n/grid.locale-en.js" type="text/javascript"></script>
<script src="js/jquery.jqGrid.min.js" type="text/javascript"></script>
<script src="js/jquery.jqplot.min.js" type="text/javascript"></script>
<script type="text/javascript" src="js/plugins/jqplot.canvasTextRenderer.min.js"></script>
<script type="text/javascript" src="js/plugins/jqplot.canvasAxisLabelRenderer.min.js"></script>
<script type="text/javascript" src="js/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
<script type="text/javascript" src="js/plugins/jqplot.dateAxisRenderer.min.js"></script>
<script type="text/javascript" src="js/plugins/jqplot.trendline.min.js"></script>
<script type="text/javascript" src="js/plugins/jqplot.highlighter.min.js"></script>
<script type="text/javascript" src="js/plugins/jqplot.cursor.min.js"></script>
<script type="text/javascript" src="js/plugins/jqplot.canvasOverlay.min.js"></script>
<script type="text/javascript">

$(document).ready(function(){

  $.jqplot.config.enablePlugins = true;


  var ajaxDataRenderer = function(url, plot, options) {
    var ret = null;
    $.ajax({
      async: false,
      url: url,
      dataType:"json",
      success: function(data) {
        ret = data;
      }
    });
    return ret;
  };
  var jsonurl = "./jsontest.php";
  s4 = ajaxDataRenderer(jsonurl);
  console.log(s4);

  // defaults
  cat = new Object();
  cat.data = s4.weight.data;
  cat.label = s4.labels.weight;
  cat.min_range = s4.ranges.min_weight;
  cat.max_range = s4.ranges.max_weight;
  console.log(cat);

  bmi = new Object();
  bmi.data = s4.bmi.data;
  bmi.label = s4.labels.bmi;
  bmi.min_range = s4.ranges.min_bmi;
  bmi.max_range = s4.ranges.max_bmi;  
  console.log(bmi);
  // jplot chart options
  var chartoptions = {
    title: 'Weight Graph',
    axesDefaults: {
      labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
      tickRenderer: $.jqplot.CanvasAxisTickRenderer
    },
    axes: {
      xaxis: {
        label: "Days",
        pad: 0,
        renderer: $.jqplot.DateAxisRenderer,
      },
      yaxis: {
        label: cat.label,
        min: (cat.min_range - 2),
        max: (cat.max_range + 2)
      }
    },
    highlighter: {
      show: true,
      sizeAdjust: 7.5
    },
    cursor: {
      show: false
    },
    series: [{
      color:'orange'
    }]
    }
  var chartoptions_bmi = {
    title: 'BMI Graph',
    axesDefaults: {
      labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
      tickRenderer: $.jqplot.CanvasAxisTickRenderer
    },
    axes: {
      xaxis: {
        label: "Days",
        pad: 0,
        renderer: $.jqplot.DateAxisRenderer,
      },
      yaxis: {
        label: bmi.label,
        min: (bmi.min_range - .4),
        max: (bmi.max_range + .2)
      }
    },
    canvasOverlay: {
      name: 'max normal',
      show: true,
      objects: [{
        horizontalLine: {
          y: 25,
          lineWidth: 1,
          color: 'rgb(250, 128, 114)',
        }
      }]
    },
    highlighter: {
      show: true,
      sizeAdjust: 7.5
    },
    cursor: {
      show: false
    },
    series: [{
      color:'orange'
    }]
    }
  var plot1 = $.jqplot('plot1', [cat.data], chartoptions);  
  var plot2 = $.jqplot('plot2', [bmi.data], chartoptions_bmi);  


$('.nav_weight').click(function(){
  $('.chart').hide();
  $('#plot1').show();
  plot1.replot();
});
$('.nav_bmi').click(function(){
  $('.chart').hide();
  $('#plot2').show();
  plot2.replot();
});

// end of jqplot

  var formEditSize = 15;
  var gridColModel = [ 
    {name:'timestamp', index:'timestamp', width:135, 
      cellattr: function (rowId, tv, rawObject, cm, rdata) { 
                return 'style="background:LightGray"'; 
                },
      editable:false,editoptions:{size:10}
    }, 
    {name:'weight', index:'weight', width:70, align:'right', 
      cellattr: function(rowId, val, rawObject, cm, rdata){
          //      weight_arr.push([parseFloat(rowId), parseFloat(val)]);
          //      console.log('weight_ar ' +weight_arr);
                return cell_bg(val,cm) },editable:true,editoptions:{size:formEditSize}
    },
    {name:'bmi', index:'bmi', width:70, align:'right',
      cellattr: function(rowId, val, rawObject, cm, rdata){
                return cell_bg(val,cm) },editable:true,editoptions:{size:formEditSize}
    }, 
    {name:'body_fat', index:'body_fat', width:70, align:'right',
      cellattr: function(rowId, val, rawObject, cm, rdata){
                return cell_bg(val,cm) },editable:true,editoptions:{size:formEditSize}
    }, 
    {name:'muscle', index:'muscle', width:70, align:'right',
      cellattr: function(rowId, val, rawObject, cm, rdata){
                return cell_bg(val,cm) },editable:true,editoptions:{size:formEditSize}
    }, 
    {name:'body_age', index:'body_age', width:70, align:'right', 
      cellattr: function(rowId, val, rawObject, cm, rdata){
                return cell_bg(val,cm) },editable:true,editoptions:{size:formEditSize}
    },
    {name:'visceral_fat', index:'visceral_fat', width:70, align:'right',
      cellattr: function(rowId, val, rawObject, cm, rdata){
                return cell_bg(val,cm) },editable:true,editoptions:{size:formEditSize}
    }, 
    {name:'waist', index:'waist', width:60, align:'right',
      cellattr: function(rowId, val, rawObject, cm, rdata){
                return cell_bg(val,cm) },editable:true,editoptions:{size:formEditSize}
    },
    {name:'rm', index:'rm', width:45, align:'right',
      editable:true,editoptions:{size:formEditSize} 
    } 
  ]

  // return value ranges for various cols
  function col_vals(cm){
    if(cm.index == 'weight')return 185;
    if(cm.index == 'bmi')return 25;
    if(cm.index == 'body_fat'){
        var range_arr = new Array(11,22,28);
        return range_arr;
    }    
    if(cm.index == 'muscle')return 33;
    if(cm.index == 'visceral_fat')return 9;
    if(cm.index == 'body_age'){
        var range_arr = new Array(42,42,52);
        return range_arr;
    }
    if(cm.index == 'waist'){
        var range_arr = new Array(34,36,40);
        return range_arr;
    }    
  }

  // style the cell backgrounds
  function cell_bg(val,cm){
    var range = col_vals(cm);
    var bgcolor = "LightGreen";
    if(range instanceof Array){
        if(val < range[0]){bgcolor = "LighBlue";}
        if(val > range[1]){bgcolor = "Salmon";}
        if(val > range[2]){bgcolor = "Red";}
    } else {
        bgcolor =  val > range?"Salmon":"LightGreen";
        if(cm.index == 'muscle'){
            bgcolor =  val > range?"LightGreen":"Salmon";
        }
    }
    return 'style="background:' + bgcolor + '"';
  }

  // update grid for different users
  function reloadEvents(){
    $('h1.user').click(function(){
      $('#list').setGridParam({url:'example.php'}); 
      $('#list').trigger("reloadGrid");  
    });
  }

  $("#list").jqGrid({
    url:'example.php',
    datatype: 'xml',
    mtype: 'GET',
    colNames:[
      'timestamp', 
      'weight',
      'bmi',
      'body fat',
      'muscle',
      'body age',
      'visceral fat',
      'waist',
      'rm'
    ],
    colModel : gridColModel,
    pager: '#pager',
    rowNum:20,
    rowList:[10,20,30],
    sortname: 'timestamp',
    sortorder: 'asc',
    viewrecords: true,
    gridview: true,
    autowidth: true,
    caption: '<?php echo $user->name; ?>\'s Progress',
    editurl: 'edit.php',
    //loadComplete: [reloadEvents, $.jqplot('plot1', chartoptions).replot()]
    loadComplete: [reloadEvents],
    beforeShowForm: function(formid) {
       $("#editmodlist").css({
            'position': 'absolute',
            'top': '10px',
            'margin':'auto'
        });
    } 
  })
 // .setGridHeight(225,true)
  .navGrid('#pager',{edit:false,add:false,del:false,search:false})
  .navButtonAdd('#pager',{
    caption:"Add a new measurment", 
    buttonicon:"ui-icon-add", 
    onClickButton: function(){ 
      $("#list").jqGrid('editGridRow', "new", {
        width:400,
        height:400,
        reloadAfterSubmit:true,
        closeAfterAdd:true
      });
    }, 
    position:"last"
   }) 
}); // end of big long function 
</script>

<!--[if lt IE 9]><script language="javascript" type="text/javascript" src="/js/excanvas.js"></script><![endif]-->

</head>
<body>
<div id="envelope">
    <header>
        <h1 class="user"><?php echo $user->name; ?></h1>
        <h2 class="motd">motd - daily aphorism here</h2>
    </header>   
    <nav class="chart_nav">
        <ul>
            <li class="nav_weight">weight</li>
            <li class="nav_bmi">bmi</li>
            <li class="nav_body_fat">body fat</li>
            <li class="nav_muscle">muscle</li>
            <li class="nav_body_age">body age</li>
            <li class="nav_viseral_fat">visceral fat</li>
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
