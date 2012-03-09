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
  var jsonurl = "./jsondata.php?u=" + hash;
  s4 = ajaxDataRenderer(jsonurl);
  console.log(s4);
  
  // vars for the jquery functions which get messed up in the json
  var calr = $.jqplot.CanvasAxisLabelRenderer;
  var catr = $.jqplot.CanvasAxisTickRenderer;
  var dar  = $.jqplot.DateAxisRenderer;
  
  // defaults
  weight = new Object(s4.weight);
  weight.axes.yaxis.max = 
    (parseFloat(s4.ranges.max_weight) + 2);
  weight.axes.yaxis.min =
    (parseFloat(s4.ranges.min_weight) - 2);
  weight.series = new Array(
    {'color': weight.series.color}
  );
  (weight.cursor.show == 'true') ?
    weight.cursor.show = true :
    weight.cursor.show = false;
  (weight.highlighter.show == 'true') ? 
    weight.highlighter.show = true :
    weight.highlighter.show = false;
  weight.highlighter.sizeAdjust =
    parseFloat(weight.highlighter.sizeAdjust);
  if(weight.axesDefaults.labelRenderer == 'calr'){
    weight.axesDefaults.labelRenderer = calr;
  }
  if(weight.axesDefaults.tickRenderer == 'catr'){
    weight.axesDefaults.tickRenderer = catr;
  }
  if(weight.axes.xaxis.renderer == 'dar'){
    weight.axes.xaxis.renderer = dar;
  }
 console.log(weight);   

  bmi = new Object(s4.bmi);
  bmi.axes.yaxis.max = 
    (parseFloat(s4.ranges.max_bmi) + .2);
  bmi.axes.yaxis.min =
    (parseFloat(s4.ranges.min_bmi) - .2);
  bmi.series = new Array(
    {'color': bmi.series.color}
  );
  bmi.canvasOverlay.name = 'max normal';
  bmi.canvasOverlay.show = s4.overlay_bmi.show;
  bmi.canvasOverlay.objects = [
    {
         horizontalLine: {
           y: s4.overlay_bmi.u3,
           lineWidth: 5,
           color: 'rgba(250, 128, 114, 0.2)',
         }
    },
    {
         horizontalLine: {
           y: s4.overlay_bmi.n3,
           lineWidth: 5,
           color: 'rgba(250, 128, 114, 0.2)',
         }
    },
    {
         horizontalLine: {
           y: s4.overlay_bmi.o3,
           lineWidth: 5,
           color: 'rgba(250, 128, 114, 0.2)',
         }
    }
  ];
  (bmi.cursor.show == 'true') ?
    bmi.cursor.show = true :
    bmi.cursor.show = false;
  (bmi.highlighter.show == 'true') ? 
    bmi.highlighter.show = true :
    bmi.highlighter.show = false;
  bmi.highlighter.sizeAdjust =
    parseFloat(bmi.highlighter.sizeAdjust);
  if(bmi.axesDefaults.labelRenderer == 'calr'){
    bmi.axesDefaults.labelRenderer = calr;
  }
  if(bmi.axesDefaults.tickRenderer == 'catr'){
    bmi.axesDefaults.tickRenderer = catr;
  }
  if(bmi.axes.xaxis.renderer == 'dar'){
    bmi.axes.xaxis.renderer = dar;
  }
 console.log(bmi);   

  body_fat = new Object(s4.body_fat);
  body_fat.axes.yaxis.max = 
    (parseFloat(s4.ranges.max_body_fat) + 2);
  body_fat.axes.yaxis.min =
    (parseFloat(s4.ranges.min_body_fat) - 2);
  body_fat.series = new Array(
    {'color': body_fat.series.color}
  );
  (body_fat.cursor.show == 'true') ?
    body_fat.cursor.show = true :
    body_fat.cursor.show = false;
  (body_fat.highlighter.show == 'true') ? 
    body_fat.highlighter.show = true :
    body_fat.highlighter.show = false;
  body_fat.highlighter.sizeAdjust =
    parseFloat(body_fat.highlighter.sizeAdjust);
  body_fat.canvasOverlay.show = s4.overlay_body_fat.show;
  body_fat.canvasOverlay.objects = [
      {
        horizontalLine: {
          y: s4.overlay_body_fat.u,
          lineWidth: 1,
          color: 'rgb(250, 128, 114)'
        }
      },
      {
        horizontalLine: {
          y: s4.overlay_body_fat.n,
          lineWidth: 1,
          color: 'rgb(250, 128, 114)'
        }
      },
      {  
        horizontalLine: {
          y: s4.overlay_body_fat.o,
          lineWidth: 1,
          color: 'rgb(250, 128, 114)'
        }
      }
  ];    
  if(body_fat.axesDefaults.labelRenderer == 'calr'){
    body_fat.axesDefaults.labelRenderer = calr;
  }
  if(body_fat.axesDefaults.tickRenderer == 'catr'){
    body_fat.axesDefaults.tickRenderer = catr;
  }
  if(body_fat.axes.xaxis.renderer == 'dar'){
    body_fat.axes.xaxis.renderer = dar;
  }
 console.log(body_fat);   

  muscle = new Object(s4.muscle);
  muscle.axes.yaxis.max = 
    (parseFloat(s4.ranges.max_muscle) + 2);
  muscle.axes.yaxis.min =
    (parseFloat(s4.ranges.min_muscle) - 2);
  muscle.series = new Array(
    {'color': muscle.series.color}
  );
  (muscle.cursor.show == 'true') ?
    muscle.cursor.show = true :
    muscle.cursor.show = false;
  (muscle.highlighter.show == 'true') ? 
    muscle.highlighter.show = true :
    muscle.highlighter.show = false;
  muscle.highlighter.sizeAdjust =
    parseFloat(muscle.highlighter.sizeAdjust);
  if(s4.overlay_muscle){
  muscle.canvasOverlay.name = 'max normal';
  muscle.canvasOverlay.show = s4.overlay_muscle.show;
  muscle.canvasOverlay.objects = [
    {
         horizontalLine: {
           y: s4.overlay_muscle.u,
           lineWidth: 5,
           color: 'rgba(250, 128, 114, 0.2)',
         }
    },
    {
         horizontalLine: {
           y: s4.overlay_muscle.n,
           lineWidth: 5,
           color: 'rgba(250, 128, 114, 0.2)',
         }
    },
    {
         horizontalLine: {
           y: s4.overlay_muscle.o,
           lineWidth: 5,
           color: 'rgba(250, 128, 114, 0.2)',
         }
    }
  ];
  }
  if(muscle.axesDefaults.labelRenderer == 'calr'){
    muscle.axesDefaults.labelRenderer = calr;
  }
  if(muscle.axesDefaults.tickRenderer == 'catr'){
    muscle.axesDefaults.tickRenderer = catr;
  }
  if(muscle.axes.xaxis.renderer == 'dar'){
    muscle.axes.xaxis.renderer = dar;
  }
 console.log(muscle);   

  body_age = new Object(s4.body_age);
  body_age.axes.yaxis.max = 
    (parseFloat(s4.ranges.max_body_age) + 2);
  body_age.axes.yaxis.min =
    (parseFloat(s4.ranges.min_body_age) - 2);
  body_age.series = new Array(
    {'color': body_age.series.color}
  );
  (body_age.cursor.show == 'true') ?
    body_age.cursor.show = true :
    body_age.cursor.show = false;
  (body_age.highlighter.show == 'true') ? 
    body_age.highlighter.show = true :
    body_age.highlighter.show = false;
  body_age.highlighter.sizeAdjust =
    parseFloat(body_age.highlighter.sizeAdjust);
  if(s4.overlay_body_age){
  body_age.canvasOverlay.name = 'max normal';
  body_age.canvasOverlay.show = s4.overlay_body_age.show;
  body_age.canvasOverlay.objects = [
    {
         horizontalLine: {
           y: s4.overlay_body_age.u,
           lineWidth: 5,
           color: 'rgba(250, 128, 114, 0.2)',
         }
    },
    {
         horizontalLine: {
           y: s4.overlay_body_age.n,
           lineWidth: 5,
           color: 'rgba(250, 128, 114, 0.2)',
         }
    },
    {
         horizontalLine: {
           y: s4.overlay_body_age.o,
           lineWidth: 5,
           color: 'rgba(250, 128, 114, 0.2)',
         }
    }
  ];
  }
  if(body_age.axesDefaults.labelRenderer == 'calr'){
    body_age.axesDefaults.labelRenderer = calr;
  }
  if(body_age.axesDefaults.tickRenderer == 'catr'){
    body_age.axesDefaults.tickRenderer = catr;
  }
  if(body_age.axes.xaxis.renderer == 'dar'){
    body_age.axes.xaxis.renderer = dar;
  }
 console.log(body_age);   

  visceral_fat = new Object(s4.visceral_fat);
  visceral_fat.axes.yaxis.max = 
    (parseFloat(s4.ranges.max_visceral_fat) + 2);
  visceral_fat.axes.yaxis.min =
    (parseFloat(s4.ranges.min_visceral_fat) - 2);
  visceral_fat.series = new Array(
    {'color': visceral_fat.series.color}
  );
  (visceral_fat.cursor.show == 'true') ?
    visceral_fat.cursor.show = true :
    visceral_fat.cursor.show = false;
  (visceral_fat.highlighter.show == 'true') ? 
    visceral_fat.highlighter.show = true :
    visceral_fat.highlighter.show = false;
  visceral_fat.highlighter.sizeAdjust =
    parseFloat(visceral_fat.highlighter.sizeAdjust);
  if(s4.overlay_visceral_fat){
  visceral_fat.canvasOverlay.name = 'max normal';
  visceral_fat.canvasOverlay.show = s4.overlay_visceral_fat.show;
  visceral_fat.canvasOverlay.objects = [
    {
         horizontalLine: {
           y: s4.overlay_visceral_fat.u,
           lineWidth: 5,
           color: 'rgba(250, 128, 114, 0.2)',
         }
    },
    {
         horizontalLine: {
           y: s4.overlay_visceral_fat.n,
           lineWidth: 5,
           color: 'rgba(250, 128, 114, 0.2)',
         }
    },
    {
         horizontalLine: {
           y: s4.overlay_visceral_fat.o,
           lineWidth: 5,
           color: 'rgba(250, 128, 114, 0.2)',
         }
    }
  ];
  }
  if(visceral_fat.axesDefaults.labelRenderer == 'calr'){
    visceral_fat.axesDefaults.labelRenderer = calr;
  }
  if(visceral_fat.axesDefaults.tickRenderer == 'catr'){
    visceral_fat.axesDefaults.tickRenderer = catr;
  }
  if(visceral_fat.axes.xaxis.renderer == 'dar'){
    visceral_fat.axes.xaxis.renderer = dar;
  }
 console.log(visceral_fat);   

  waist = new Object(s4.waist);
  waist.axes.yaxis.max = 
    (parseFloat(s4.ranges.max_waist) + 2);
  waist.axes.yaxis.min =
    (parseFloat(s4.ranges.min_waist) - 2);
  waist.series = new Array(
    {'color': waist.series.color}
  );
  (waist.cursor.show == 'true') ?
    waist.cursor.show = true :
    waist.cursor.show = false;
  (waist.highlighter.show == 'true') ? 
    waist.highlighter.show = true :
    waist.highlighter.show = false;
  waist.highlighter.sizeAdjust =
    parseFloat(waist.highlighter.sizeAdjust);
  if(s4.overlay_waist){
  waist.canvasOverlay.name = 'max normal';
  waist.canvasOverlay.show = s4.overlay_waist.show;
  waist.canvasOverlay.objects = [
    {
         horizontalLine: {
           y: s4.overlay_waist.u,
           lineWidth: 5,
           color: 'rgba(250, 128, 114, 0.2)',
         }
    },
    {
         horizontalLine: {
           y: s4.overlay_waist.n,
           lineWidth: 5,
           color: 'rgba(250, 128, 114, 0.2)',
         }
    },
    {
         horizontalLine: {
           y: s4.overlay_waist.o,
           lineWidth: 5,
           color: 'rgba(250, 128, 114, 0.2)',
         }
    }
  ];
  }
  if(waist.axesDefaults.labelRenderer == 'calr'){
    waist.axesDefaults.labelRenderer = calr;
  }
  if(waist.axesDefaults.tickRenderer == 'catr'){
    waist.axesDefaults.tickRenderer = catr;
  }
  if(waist.axes.xaxis.renderer == 'dar'){
    waist.axes.xaxis.renderer = dar;
  }
 console.log(waist);   

  rm = new Object(s4.rm);
  rm.axes.yaxis.max = 
    (parseFloat(s4.ranges.max_rm) + 2);
  rm.axes.yaxis.min =
    (parseFloat(s4.ranges.min_rm) - 2);
  rm.series = new Array(
    {'color': rm.series.color}
  );
  (rm.cursor.show == 'true') ?
    rm.cursor.show = true :
    rm.cursor.show = false;
  (rm.highlighter.show == 'true') ? 
    rm.highlighter.show = true :
    rm.highlighter.show = false;
  rm.highlighter.sizeAdjust =
    parseFloat(rm.highlighter.sizeAdjust);
  if(rm.axesDefaults.labelRenderer == 'calr'){
    rm.axesDefaults.labelRenderer = calr;
  }
  if(rm.axesDefaults.tickRenderer == 'catr'){
    rm.axesDefaults.tickRenderer = catr;
  }
  if(rm.axes.xaxis.renderer == 'dar'){
    rm.axes.xaxis.renderer = dar;
  }
 console.log(rm);   
/*
  bmi = new Object();
  bmi.chartoptions.axes.yaxis.min = 
    (parseFloat(s4.ranges.min_bmi) - .4);
  bmi.chartoptions.axes.yaxis.max = 
    (parseFloat(s4.ranges.max_bmi) + .2);
  console.log(bmi);

  body_fat = new Object();
  body_fat.chartoptions.axes.yaxis.min = 
    (parseFloat(s4.ranges.min_body_fat) - .4);
  body_fat.chartoptions.axes.yaxis.max = 
    (parseFloat(s4.ranges.max_body_fat) + .2);
  console.log(body_fat);

  muscle = new Object();
  muscle.chartoptions.axes.yaxis.min = 
    (parseFloat(s4.ranges.min_muscle) - .4);
  muscle.chartoptions.axes.yaxis.max = 
    (parseFloat(s4.ranges.max_muscle) + .2);
  console.log(muscle);
  
  body_age = new Object();
  body_age.chartoptions.axes.yaxis.min = 
    (parseFloat(s4.ranges.min_body_age) - 2);
  body_age.chartoptions.axes.yaxis.max = 
    (parseFloat(s4.ranges.max_body_age) + 2);
  console.log(body_age);
  
  visceral_fat = new Object();
  visceral_fat.chartoptions.axes.yaxis.min = 
    (parseFloat(s4.ranges.min_visceral_fat) - 2);
  visceral_fat.chartoptions.axes.yaxis.max = 
    (parseFloat(s4.ranges.max_visceral_fat) + 2);
  console.log(visceral_fat);

  waist = new Object();
  waist.chartoptions.axes.yaxis.min = 
    (parseFloat(s4.ranges.min_waist) - .4);
  waist.chartoptions.axes.yaxis.max = 
    (parseFloat(s4.ranges.max_waist) + .2);
  console.log(waist);

  rm = new Object();
  rm.chartoptions.axes.yaxis.min = 
    (parseFloat(s4.ranges.min_rm) - 10);
  rm.chartoptions.axes.yaxis.max = 
    (parseFloat(s4.ranges.max_rm) + 10);
  console.log(rm);

// jplot chart options
      
  var chartoptions_bmi = {
    title: 'BMI Graph',
    },
  }
  var chartoptions_body_fat = {
    title: 'Body Fat Graph',
    },
  }
  var chartoptions_muscle = {
    title: 'Muscle Graph',
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
  }
  var chartoptions_body_age = {
    title: 'Body Age Graph',
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
  }
  var chartoptions_visceral_fat = {
    title: 'Viceral Fat Graph',
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
  }
  var chartoptions_waist = {
    title: 'Waist Graph',
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
  }
  var chartoptions_rm = {
    title: 'Rest Metabolism Graph',
    },
    canvasOverlay: {
      name: 'max normal',
      show: true,
    },
  }
*/
//  var plot1 = $.jqplot('plot1', [weight.data], chartoptions_weight);  
  var plot1 = $.jqplot('plot1', [weight.data], weight);  
  var plot2 = $.jqplot('plot2', [bmi.data], bmi);  
  var plot3 = $.jqplot('plot3', [body_fat.data], body_fat);  
  var plot4 = $.jqplot('plot4', [muscle.data], muscle);  
  var plot5 = $.jqplot('plot5', [body_age.data], body_age);  
  var plot6 = $.jqplot('plot6', [visceral_fat.data], visceral_fat);  
  var plot7 = $.jqplot('plot7', [waist.data], waist);  
  var plot8 = $.jqplot('plot8', [rm.data], rm);  

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
    url:'generate_grid.php?u=' + hash,
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
    caption: 'Your name here\'s Progress',
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

