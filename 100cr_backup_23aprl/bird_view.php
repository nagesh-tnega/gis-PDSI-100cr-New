<?php 
 
require_once('php/dbHandler.php');

include('php/session.php');

//print_r($_SESSION["100c_user_info"]);



$tcquery = pg_query(DBCON, "select * from sp_index");
$scquery = pg_query(DBCON, "select * from sp_index where layers !=''");
//error_reporting(-1);

?> 

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Projects-Dashboard</title>
    <link rel="shortcut icon" type="image/png" href="images/logo2.png" />
    <!-- Maps css -->
    <link rel="stylesheet" type="text/css" href="css/maps.css">
<!--     <link rel="stylesheet" type="text/css" href="css/ol.css">
 -->    
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.5.0/css/ol.css">

    <link rel="stylesheet" type="text/css" href="css/olExt.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
   <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/main.css">
   

    <style type="text/css">
      .bg-green {
      background: #85be00;
      }
    
           .ol-scale-line{
         left:50%; 
         }
     
   .hello
         {  left: 1%;
         top: 8em;
         }
    

    </style>
  
    <script src="js/jquery-min.js"></script>
    <script src="js/popper.min.js"></script>
<!--     <script src="js/ol.js"></script>
 -->
     <script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.4.3/build/ol.js"></script>
   <script src="js/ol-popup.js"></script>
    <script src="js/olExt.js"></script>
    <script src="js/bootstrap.min.js"></script>
  
  </head>
  <body>
    <!-- Header Area wrapper Starts -->
<nav class="bg-dark text-center">
  <h4 class="text-white text-center" href="#"> <img src="images/logo.png" width="70" height="70" class="d-inline-block align-top" alt=""> Major Infrastructure Projects of Tamil Nadu-Dashboard <img src="images/logo2.png" width="70" height="70" class="" alt=""> <span style="right:0px;position: absolute;"><!--<a href="report.php" class="btn btn-primary" role="button"><i class="fa fa-list"></i> Reports</a>--><a href="logout.php" class="btn btn-danger" role="button"><i class="fa fa-sign-out"></i> Logout</a></span></</h4>
  
 </nav>

 
    
    <?php include('menu.php'); ?>

   
  
    <!--  <span id="clrheader">X</span>  -->
  <div class="container-fluid" id="mainpg" style = 'background: aliceblue;'>
    <div class="row" id="maincontent">
    
    <div id="map" class="col-md-9" style="background-color: white;padding-left:0px;padding-right:0px;">
      <div id="popup" class="ol-popup"> </div>
</div>

<div class="col-md-3" id="info_data_div" style="overflow-wrap: anywhere;height:90vh" >

  <label>Please Select the Department</label></br>
      <select id="dept" style="width:90%"></select></br></br>

    <div id ="project" style="display:none;overflow:auto; max-height:60vh"> 
    </div>
      
     </div>
</div>

</div>


  
  <script  type="text/javascript">
  var mobile;
  function detec() { 
            var isMobile = window.orientation > -1; 
             mobile = isMobile
        }
  detec();
$("#GotoGIS").click(function() {
  if ($("#header-wrap").is(":visible")) {

    $("#header-wrap").hide();
  } else if ($("#header-wrap").is(":hidden")) {
    $("#header-wrap").show();
  }
  // alert("qwerty dgdfgfd");
  // $('#map').animate({height:'90vh'}),
    
setTimeout(reSize, 250);
   
});

function reSize() {

   map.updateSize();
   console.log('size'); 
}
// Basemap layers
var attr = '<div style="text-align: left;font-size: .5rem"><b>DISCLAIMER</b><br>Due to variations in scale, layers may not depict exact locations on OSM or Other maps; Boundaries of Cadastral Map are displayed as received from the source and are not authentic nor meant to be authentic.</div>'
var layers = [
  new ol.layer.Group({
    title: '<b style="color:#00ff21e8">Base Maps</b>',
    openInLayerSwitcher: true,
    layers: [
      new ol.layer.Tile({
        title: "OSM Map",
        baseLayer: true,
        visible: false,
        source: new ol.source.OSM()
      }),
      new ol.layer.Tile({
        title: 'Here Satellite Map',
        visible: true,
        baseLayer: true,
        source: new ol.source.XYZ({
          url: 'https://1.aerial.maps.ls.hereapi.com/maptile/2.1/maptile/newest/satellite.day/{z}/{x}/{y}/256/png8?apiKey=IPTEDpK8mbJtwQAX-YIZRoty81BzpLwXwRHFxngkRqU',
          attributions: attr
        })
      }),
      new ol.layer.Tile({
        title: 'Here Terrain Map',
        visible: false,
        baseLayer: true,
        source: new ol.source.XYZ({
          url: 'https://1.aerial.maps.ls.hereapi.com/maptile/2.1/maptile/newest/terrain.day/{z}/{x}/{y}/256/png8?apiKey=IPTEDpK8mbJtwQAX-YIZRoty81BzpLwXwRHFxngkRqU',
          attributions: attr
        })
      }),
      new ol.layer.Tile({
        title: 'Here Map',
        visible: false,
        baseLayer: true,
        source: new ol.source.XYZ({
          url: 'https://1.base.maps.ls.hereapi.com/maptile/2.1/maptile/newest/normal.day/{z}/{x}/{y}/256/png8?apiKey=IPTEDpK8mbJtwQAX-YIZRoty81BzpLwXwRHFxngkRqU',
          attributions: attr
        })
      })
    ]
  })
];

var map = new ol.Map({
  layers: layers,
  target: 'map',
  view: new ol.View({
    center: [8781480.570496075, 1224732.6162325153],
    zoom:7.6,
  }),
});
 

 

// adding ol-ext controls
var ctrl = new ol.control.LayerSwitcher({
  show_progress: true,
    reordering: false,
  collapsed: true
});
map.addControl(ctrl);
var scaleLineControl = new ol.control.ScaleLine();
map.addControl(scaleLineControl);
var fullScreenControll = new ol.control.FullScreen();
map.addControl(fullScreenControll);
var legend = new ol.control.Legend({
  title: '',
  collapsed: true
});
map.addControl(legend);
legend.addRow({
  title: '<b style="">Legend:</b><nav id="leg_end" style="min-width: 200px;"></br><nav>'
})


var tn = new ol.layer.Tile({
  type: 'wms',
  source: new ol.source.TileWMS({
    // TODO: Change URL
    url: '<?php echo (GSURL."/".WORKSPACE."/wms"); ?>',
    params: {
      'LAYERS': 'c100:sp_tnoutpolygon'
    },
    serverType: 'geoserver'
  }),
  displayInLayerSwitcher: false
});
map.addLayer(tn);


// var un_1 = 'sp_tidco_heh,sp_tidco_heh1,sp_tidco_heh3,sp_cmwssb_conveying,sp_cmwssb_ugt,sp_cmwssb_conveying,sp_cmwssb_ugt,sp_tnrdc_kelam,sp_tnrdc_kelam1,sp_tnrdc_tiru,sp_tnrdc_tiru1,sp_hg_medavakkam,sp_hg_velacherry,sp_hg_thiruvanmaiyur2akkarai,sp_hg_omr_ecr,sp_hg_omr_ecr1234,sp_cmwssb_manali,sp_cmwssb_manali1,sp_cmwssb_conveying,sp_cmwssb_ugt,sp_hg_thepakulam_line,sp_hg_thepakulam_points,sp_hg_arapalayam_line,sp_hg_arapalayam_point,sp_lc_32,mullakadu_points,mullakadu_polygon,mullakadu_polylines,sp_cmwssb_chinnasekkadu1,sp_cmwssb_chinnasekkadu,sp_cmwssb_manapakkam1,sp_cmwssb_manapakkam,sp_cmwssb_karampakkam,sp_cmwssb_karampakkam1,sp_cmwssb_conveying,sp_cmwssb_ugt,sp_tnrdc_npar';

var un_1 = '<?php  $birdView = pg_query(DBCON, "SELECT STRING_AGG(layers, ',') AS layer
FROM sp_index where layers is not null and layers !=''");

while($row = pg_fetch_assoc($birdView)) {
    $bv_layers = $row['layer'];
}
echo $bv_layers;
       ?>'

      console.log(un_1);

var ln_1 = 'Bird View'
var project_layer = new ol.layer.Tile({
    id: 1,
    title: ln_1,
    layerName: ln_1,
    type: 'wms',
    legend: '<nav id="leg_1"><img src="<?php echo GSURL; ?>/wms?REQUEST=GetLegendGraphic&VERSION=1.0.0&FORMAT=image/png&WIDTH=20&HEIGHT=20&LAYER=<?php echo WORKSPACE ?>:' + un_1 + '"<p>&nbsp' + ln_1 + '</p></br></nav>',
    source: new ol.source.TileWMS({
      // TODO: Change URL
      url: '<?php echo (GSURL."/".WORKSPACE."/wms"); ?>',
      params: {
        'LAYERS': un_1
      },
      serverType: 'geoserver'
    }),
    visible: true
  });
  

  var un = 'sp_index';
var ln = 'Overall Projects';
var dept_layer = new ol.layer.Tile({
    id: 2,
    title: ln,
    layerGroup: 'Layers',
    layerName: ln,
    type: 'wms',
    legend: '<nav id="leg_1"><img src="<?php echo GSURL; ?>/wms?REQUEST=GetLegendGraphic&VERSION=1.0.0&FORMAT=image/png&WIDTH=20&HEIGHT=20&LAYER=<?php echo WORKSPACE ?>:' + un + '"<p>&nbsp' + ln + '</p></br></nav>',
    source: new ol.source.TileWMS({
      // TODO: Change URL
      url: '<?php echo (GSURL."/".WORKSPACE."/wms"); ?>',
      params: {
        'LAYERS': un,
        'STYLE': 'point'
      },
      serverType: 'geoserver'
    }),
    visible: true
  });

  map.addLayer(project_layer);

var bird_layers = '<?php  $birdView = pg_query(DBCON, "SELECT STRING_AGG(layers, ',') AS layer
FROM sp_index where layers !='' ");

// select regexp_split_to_table(sp_index.layers, E',') AS layers from 
// sp_index where layers != ''

while($row = pg_fetch_assoc($birdView)) {
    $bv_layers = $row['layer'];
}
echo $bv_layers;
       ?>';
      console.log(bird_layers);






  
  getDept();

function getDept() {
  
    $.ajax({
    url: 'php/function.php',
    type: 'POST',
    data: 'case=getBVDept',
    success: function(response) {
      var html = JSON.parse(response);
      console.log(response);
      $('#dept').html(html.html);
    }
  })
}

 function birdViewProjects() {
   var dept = $("#dept").val();
   console.log(dept);
   $.ajax({
    url: 'php/function.php',
    type: 'POST',
    data: 'dept='+ dept +'&case=birdViewProj',
    success: function(response) {
    console.log(response);
    $('#project').show();
     $('#project').html(response);
    }
  });
   
 }

$("#dept").change(function() {
  if ($("#dept").val() == 'null' ) {
        map.getView().setCenter( [8781480.570496075, 1224732.6162325153]);
    map.getView().setZoom(7.6);
    $('#project').hide();
     
     
       }

  else if ($("#dept").val() == 'all' ) {
        map.getView().setCenter( [8781480.570496075, 1224732.6162325153]);
    map.getView().setZoom(7.6);
    $('#project').show();
    birdViewProjects();     
  }
  
  else {
birdViewProjects();

  // $.ajax({
  //   url: 'php/function.php',
  //   type: 'POST',
  //   data: 'dept='+ encodeURIComponent($("#dept").val()) +'&case=getExtent',
  //   success: function(response) {
  //     var zoom_extent = JSON.parse(response);
  //     console.log(zoom_extent);
  //          zoom_extent =  zoom_extent.split(",");
  //     map.getView().fit(zoom_extent, map.getSize());
      
  //   }
  // });
}
});


function ZoomTo(layer,lat,lon){
   
  
  var l_array = layer.split(",");
  console.log(l_array);
  
  
  var layer1, layer2, layer3;
     
    if (l_array.length == 1) {
      
      layer1 = l_array[0];
      layer2 = 'null';
      layer3 = 'null';
      
    }
    
    else if (l_array.length == 2) {
      
      layer1 = l_array[0];
      layer2 = l_array[1];
      layer3 = 'null';
      
    }
    
    else {
      
      layer1 = l_array[0];
      layer2 = l_array[1];
      layer3 = l_array[2];
      
      
    }
    
  if (l_array.length > 0)  {  
  $.ajax({
    url: 'php/function.php',
    type: 'POST',
    data: 'layer1='+ layer1 + '&layer2='+ layer2 + '&layer3='+ layer3 +'&case=getAllExtent',
    success: function(response) {
      
      console.log(response);
      
    if (response == '""') {
      
       map.getView().setCenter(ol.proj.transform([lon, lat], 'EPSG:4326', 'EPSG:3857'));
    map.getView().setZoom(15); 
    }
    
    else {
      
      var zoom_extent = JSON.parse(response);
      
            zoom_extent = Array.from(zoom_extent.split(','), Number);
       console.log(zoom_extent);
  //server-code

// var features = project_layer.getSource();
//       var duration = 2000;
//      var size =(map.getSize());
//      var mapView = map.getView();
//     var resolution = mapView.getResolution(zoom_extent);
//     var center = map.getView().fit(zoom_extent, map.getSize());
//    var zoom =  mapView.getZoom();
//     var currentCenter = map.getView().getCenter();
//     var currentResolution = map.getView().getResolution();
//     var distance = Math.sqrt(Math.pow(center[0] - currentCenter[0], 2) + Math.pow(center[1] - currentCenter[1], 2));
//     var maxResolution = Math.max(distance/ map.getSize()[0], currentResolution);
//     // var up = Math.abs(maxResolution - currentResolution);
//     // var down = Math.abs(maxResolution - resolution);
//     // var adjustedDuration = duration + Math.sqrt(up + down) * 100;
// // var zoom_test = map.getView().getCenter(zoom_extent, map.getSize());
// // console.log(zoom_test);
//    mapView.animate({
//     center: center,
//       duration: duration,
//     });
//     mapView.animate({
//    zoom:zoom -1 ,
//       duration: duration/2
//     }, {
//       zoom:zoom-1,
     
//       duration: duration/2
//     });
var duration = 2000;
    let mapView = map.getView();
    var extentOfPolygon = zoom_extent;
    console.log(extentOfPolygon);
    var resolution = mapView.getResolutionForExtent(extentOfPolygon);
    console.log(resolution);
    var center = ol.extent.getCenter(extentOfPolygon);
    var currentCenter = map.getView().getCenter();
    var currentResolution = map.getView().getResolution();
    var distance = Math.sqrt(Math.pow(center[0] - currentCenter[0], 2) + Math.pow(center[1] - currentCenter[1], 2));
    var maxResolution = Math.max(distance/ map.getSize()[0], currentResolution);
    var up = Math.abs(maxResolution - currentResolution);
    var down = Math.abs(maxResolution - resolution);
    var adjustedDuration = duration + Math.sqrt(up + down) * 100;

    mapView.animate({
      center: center,
      duration: adjustedDuration
    });
    mapView.animate({
      resolution: maxResolution,
      duration: adjustedDuration * up / (up + down)
    }, {
      resolution: resolution,
      duration: adjustedDuration * down / (up + down)
    });

       
    }
      
      }
  });
  
  }
  
  else {
    
    map.getView().setCenter(ol.proj.transform([lon, lat], 'EPSG:4326', 'EPSG:3857'));
    map.getView().setZoom(15); 
    
  }
  
  
}

 
 var element = document.getElementById('popup');
    var popup = new ol.Overlay.Popup();
    map.addOverlay(popup);
  
  map.on('singleclick', function(evt) {
  var iid, uid;
  if ($('#type').val() == 'null' || $('#type').val() == undefined) {
function pop(pop_url1) {
    pop_url1 = pop_url1.substring(0, pop_url1.length - 1);
    pop_url1 = '[' + pop_url1 + ']';
    console.log(pop_url1);
    pop_url = pop_url1.replace(/&/g, '%26');
    console.log(pop_url);
    $.ajax({
      url: 'php/getPopup1.php',
      type: 'POST',
      data: 'pop_url=' + pop_url,
      success: function(data) {
        if (data) {
          popup.show(evt.coordinate, data);
        }
      }
    });
  }
  //toggleEditor(null);
  var getPop = null;
  if (!$('.tool-toggle').hasClass('active')) {
    // Hide existing popup and reset it's offset
    // popup2.hide();
    // popup2.setOffset([0, 0]);
    var prop = '';
    //Check for visible layers
    // var layers = map.getLayers();
    var pop_url = '';
    map.getLayers().forEach(function(layer) {
      //if (layer instanceof ol.layer.Group) {
        //layer.getLayers().forEach(function(sublayer) {
          if (layer.get('type') == 'wms' && layer.get('visible') == true) {
            iid = layer.get('title');
            uid = layer.get('id');
            
pop_url = pop_url + '{"url":"' + layer.getSource().getGetFeatureInfoUrl(evt.coordinate, map.getView().getResolution(), map.getView().getProjection(), {
              'INFO_FORMAT': 'text/plain',
              'FEATURE_COUNT': 1
            }) + '","layer_name":"' + iid + '","uid":"' + uid + '"},';
            
          }
        //})
      //}
    
    })
    if (pop_url != '') {
      pop(pop_url);
      console.log(pop_url)
    }
    }
  }
});

  function toggle_popup(table) {
  if ($('.' + table + '_tr').is(":visible") == false) {
    $('.' + table + '_tr').show();
  } else {
    $('.' + table + '_tr').hide();
  }
}
 
  


var fullScreenControll = new ol.control.FullScreen();
map.addControl(fullScreenControll);


</script>
<script src="js/tdraw.js"></script>
<img style="display:none" src="https://tngis.tn.gov.in/gsl/gsl.php"/>
</body>
</html>

 