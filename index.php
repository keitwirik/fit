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
    text-decoration:underline;
    color:blue;
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

nav.chart_nav ul li.nav_active {
    color:black; 
    cursor:default;
    text-decoration:none;
}

.jqplot-highlighter-tooltip {
    font-size:15px;
    background:#fff;
    border:2px solid #7473F7;
    border-radius:8px;
    padding:5px;
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
  var jsonurl = "./jsondata.php";
  s4 = ajaxDataRenderer(jsonurl);
  console.log(s4);

  // defaults
  weight = new Object();
  weight.data = s4.weight.data;
  weight.chartoptions = s4.weight.chartoptions;
  weight.label = s4.labels.weight;
  weight.min_range = s4.ranges.min_weight;
  weight.max_range = s4.ranges.max_weight;
  console.log(weight);

  bmi = new Object();
  bmi.data = s4.bmi.data;
  bmi.label = s4.labels.bmi;
  bmi.min_range = s4.ranges.min_bmi;
  bmi.max_range = s4.ranges.max_bmi;  
  console.log(bmi);

  body_fat = new Object();
  body_fat.data = s4.body_fat.data;
  body_fat.label = s4.labels.body_fat;
  body_fat.min_range = s4.ranges.min_body_fat;
  body_fat.max_range = s4.ranges.max_body_fat;  
  console.log(body_fat);

  muscle = new Object();
  muscle.data = s4.muscle.data;
  muscle.label = s4.labels.muscle;
  muscle.min_range = s4.ranges.min_muscle;
  muscle.max_range = s4.ranges.max_muscle;  
  console.log(muscle);
  
  body_age = new Object();
  body_age.data = s4.body_age.data;
  body_age.label = s4.labels.body_age;
  body_age.min_range = s4.ranges.min_body_age;
  body_age.max_range = s4.ranges.max_body_age;  
  console.log(body_age);
  
  visceral_fat = new Object();
  visceral_fat.data = s4.visceral_fat.data;
  visceral_fat.label = s4.labels.visceral_fat;
  visceral_fat.min_range = s4.ranges.min_visceral_fat;
  visceral_fat.max_range = s4.ranges.max_visceral_fat;  
  console.log(visceral_fat);

  waist = new Object();
  waist.data = s4.waist.data;
  waist.label = s4.labels.waist;
  waist.min_range = s4.ranges.min_waist;
  waist.max_range = s4.ranges.max_waist;  
  console.log(waist);

  rm = new Object();
  rm.data = s4.rm.data;
  rm.label = s4.labels.rm;
  rm.min_range = s4.ranges.min_rm;
  rm.max_range = s4.ranges.max_rm;  
  console.log(rm);

// jplot chart options
      
  var chartoptions_weight = {
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
        label: weight.label,
        min: (weight.min_range - 2),
        max: (weight.max_range + 2)
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
  var chartoptions_body_fat = {
    title: 'Body Fat Graph',
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
        label: body_fat.label,
        min: (body_fat.min_range - .4),
        max: (body_fat.max_range + .2)
      }
    },
    canvasOverlay: {
      name: 'max overweight',
      show: true,
      objects: [
      {
        horizontalLine: {
          y: 27.9,
          lineWidth: 1,
          color: 'rgb(250, 128, 114)'
        }
      },
      {  
        horizontalLine: {
          y: 21.9,
          lineWidth: 1,
          color: 'rgb(250, 128, 114)'
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
  var chartoptions_muscle = {
    title: 'Muscle Graph',
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
        label: muscle.label,
        min: (muscle.min_range - .4),
        max: (muscle.max_range + .2)
      }
    },
    canvasOverlay: {
      name: 'max normal',
      show: true,
      objects: [{
        horizontalLine: {
          y: 33.1,
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
  var chartoptions_body_age = {
    title: 'Body Age Graph',
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
        label: body_age.label,
        min: (body_age.min_range - .4),
        max: (body_age.max_range + .2)
      }
    },
    canvasOverlay: {
      name: 'max normal',
      show: true,
      objects: [{
        horizontalLine: {
          y: 42,
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
  var chartoptions_visceral_fat = {
    title: 'Viceral Fat Graph',
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
        label: visceral_fat.label,
        min: (visceral_fat.min_range - 2),
        max: (visceral_fat.max_range + 2)
      }
    },
    canvasOverlay: {
      name: 'max normal',
      show: true,
      objects: [{
        horizontalLine: {
          y: 9.9,
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
  var chartoptions_waist = {
    title: 'Waist Graph',
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
        label: waist.label,
        min: (waist.min_range - .4),
        max: (waist.max_range + .2)
      }
    },
    canvasOverlay: {
      name: 'max normal',
      show: true,
      objects: [{
        horizontalLine: {
          y: 40,
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
  var chartoptions_rm = {
    title: 'Rest Metabolism Graph',
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
        label: rm.label,
        min: (rm.min_range - 10),
        max: (rm.max_range + 10)
      }
    },
    canvasOverlay: {
      name: 'max normal',
      show: true,
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

  var plot1 = $.jqplot('plot1', [weight.data], chartoptions_weight);  
//  var plot1 = $.jqplot('plot1', [weight.data], weight.chartoptions);  
  var plot2 = $.jqplot('plot2', [bmi.data], chartoptions_bmi);  
  var plot3 = $.jqplot('plot3', [body_fat.data], chartoptions_body_fat);  
  var plot4 = $.jqplot('plot4', [muscle.data], chartoptions_muscle);  
  var plot5 = $.jqplot('plot5', [body_age.data], chartoptions_body_age);  
  var plot6 = $.jqplot('plot6', [visceral_fat.data], chartoptions_visceral_fat);  
  var plot7 = $.jqplot('plot7', [waist.data], chartoptions_waist);  
  var plot8 = $.jqplot('plot8', [rm.data], chartoptions_rm);  

$('.chart_nav ul li').click(function(){
  $('.chart_nav ul li').removeClass('nav_active');
  $(this).addClass('nav_active');  
});

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
$('.nav_body_fat').click(function(){
  $('.chart').hide();
  $('#plot3').show();
  plot3.replot();
});
$('.nav_muscle').click(function(){
  $('.chart').hide();
  $('#plot4').show();
  plot4.replot();
});
$('.nav_body_age').click(function(){
  $('.chart').hide();
  $('#plot5').show();
  plot5.replot();
});
$('.nav_visceral_fat').click(function(){
  $('.chart').hide();
  $('#plot6').show();
  plot6.replot();
});
$('.nav_waist').click(function(){
  $('.chart').hide();
  $('#plot7').show();
  plot7.replot();
});
$('.nav_rm').click(function(){
  $('.chart').hide();
  $('#plot8').show();
  plot8.replot();
});

// end of jqplot


// jqgrid settings
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
      $('#list').setGridParam({url:'generate_grid.php'}); 
      $('#list').trigger("reloadGrid");  
    });
  }

  $("#list").jqGrid({
    url:'generate_grid.php',
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
    rowNum:90,
    rowList:[20,30,50],
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

// post load events
//not the best way to scroll to the bottom of the grid 
$(window).bind("load", function(){
    $(".ui-jqgrid-bdiv").animate({ scrollTop: 1000 }, 9999);
});

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
