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
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
     <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
   <!-- <link rel="stylesheet" type="text/css" href="css/maps.css"> -->
    <link rel="stylesheet" type="text/css" href="css/ol.css">
    <link rel="stylesheet" type="text/css" href="css/olExt.css">
    <!-- Bootstrap CSS -->
    
	
    <!--<link rel="stylesheet" type="text/css" href="css/main.css">-->
   

    <style type="text/css">

    	p {
    font-weight: 400;
    font-family: 'Open Sans', sans-serif;
    margin: 0px;
    font-size: 14px;
    color: #1c1c1c;
}

a:hover {
        text-decoration: none;
    }

    a a:focus {
        outline: none;
    }


      .bg-green {
      background: #85be00;
      }
	  
	         .ol-scale-line{
         left:50%; 
         }
		 
	 .hello
         {	left: 1%;
         top: 8em;
         }
    

    </style>
  
    <script src="js/jquery-min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/ol.js"></script>
    <script src="js/ol-popup.js"></script>
    <script src="js/olExt.js"></script>
    
	
  </head>
  <body>
    <!-- Header Area wrapper Starts -->


 
		
		<?php 
			include('header.php');
			include('menu.php'); 
		?>

   
	
    <!--  <span id="clrheader">X</span>  -->
	<div class="container-fluid" id="mainpg" style = 'background: aliceblue;'>
		<div class="row" id="maincontent">
			<div class="col-md-3" id="querytool">
			<div class="mt-3 ml-3">
			<div class="card" style="width: 18rem;">
  <div class="card-body">
  <h1 class='text-center'><i class="fa fa-briefcase" aria-hidden="true"></i></h1>
    <p class="card-title text-center text-primary">Total Infrastructure Projects</p>
    <h4 class="card-title text-center"><span class="Count"><?php  echo pg_num_rows($tcquery) ?></span></h4>    
	<p class="card-title text-center text-primary">Total Infrastructure Projects With GIS Data</p>
    <h4 class="card-title text-center"><span class="Count"><?php  echo pg_num_rows($scquery) ?></span></h4>
	<i class="fas fa-clipboard-check"></i>
		
  </div>
</div>
			<label>Please Select the Department</label></br></br>
			<select id="dept" style="width:90%"></select></br></br>
			<div style="display:none" id="dept_proj_div">
			<label>Please Select the Projects</label></br></br>
			<select id="dept_proj" style="width:90%"></select></div>
	
	</div>
	</div>
    <div id="map" class="col-md-6" style="background-color: white;padding-left:0px;padding-right:0px">
    </div>
		<div class="col-md-3" id="info_data_div" style="overflow-wrap: anywhere;height:90vh" >
			<div class="mt-3 ml-3">
			<div id="info_data"></div>
			
	
	   </div>
	</div>

</div>


    </div>

	
	<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog" style="max-width:90%;margin: 30px auto;font-size: xx-medium;">
    
      <!-- Modal content-->
      <div class="modal-content">
	  
        <div class="modal-header">
          <h6 class="modal-title" id="prj_tittle"></h6>
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
		
		
			<div class="row" id="maincontent">
				<div id="map1" class="col-md-9"style="height:60vh">
				</div>
				<div id="popup2" class="ol-popup">
			 <a href="#" id="popup-closer" class="ol-popup-closer"></a>
			 <div id="popup-content-2"></div>
			</div>
				<div class="col-md-3">
				<div>
				<h5>LEGEND</h5>
				<div id="legendPanel" style="font-size:medium;background: azure;" class="border border-success">

				</div>			
				</div>		
				<div>
				<h5>Layers</h5>
				<div id="layerTree" style="font-size:medium;background: azure;" class="border border-success">
				
				</div>
				</div>
				</div>
			</div>
			<div class="ml-1 mb-1">
			<p class="lead">Color Code</p>
				<button type="button" class="btn btn-success">Completed</button>
				<button type="button" class="btn btn-warning">In Progress</button>
				<button type="button" class="btn btn-danger">Yet To be Implemented</button>
				<button type="button" class="btn" style="background-color:yellow">Others</button>
			</div>
          
        </div>
      
      </div>
      
    </div>
  </div>
  
  
   <div class="modal fade" id="imagemodal" style="z-index: 100000 !important;">
         <div class="modal-dialog" style="margin: 30px auto;min-width:44vw; height: 40vw;">
            <!-- Modal content-->
            <div class="modal-content">
  <button type="button" class="close" data-dismiss="modal">&times;</button>
               <div class="modal-body" style = "overflow:scroll;overflow:hidden" >
                  <div class="container-fluid">
                     <div class="row">
                        <div class="col-md-12">
                           <img src="" id="imagepreview" style="width:40vw; height: 40vw;" >
                        </div>
                      
                     </div>
                  </div>
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
  $('#map').animate({height:'90vh'}),
    
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
        visible: false,
        baseLayer: true,
        source: new ol.source.XYZ({
          url: 'https://1.aerial.maps.ls.hereapi.com/maptile/2.1/maptile/newest/satellite.day/{z}/{x}/{y}/256/png8?apiKey=IPTEDpK8mbJtwQAX-YIZRoty81BzpLwXwRHFxngkRqU',
          attributions: attr
        })
      }),
      new ol.layer.Tile({
        title: 'Here Terrain Map',
        visible: true,
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
		zoom: 7.5,
		minZoom: 7,
		maxZoom: 19,
		extent: [8395626.451712506, 892078.6691354283, 9167334.689279644, 1557386.5633296024]
	})
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

var un = 'sp_index';
var ln = 'Overall Projects '
var project_layer = new ol.layer.Tile({
		id: 1,
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
	$('#leg_end').append(project_layer.H.legend)


var un = 'sp_index';
var ln = 'Overall Projects';
var projecthg_layer = new ol.layer.Tile({
		id: 1,
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

//popup
var element = document.getElementById('popup');
var popup = new ol.Overlay.Popup();
map.addOverlay(popup);
var content = null;
map.on('singleclick', function(evt) {
	var iid, uid;

	function pop(pop_url1) {
		pop_url1 = pop_url1.substring(0, pop_url1.length - 1);
		pop_url1 = '[' + pop_url1 + ']';
		pop_url = pop_url1.replace(/&/g, '%26');
		console.log(pop_url);
		$.ajax({
			url: 'php/getStyleInfo.php',
			type: 'POST',
			data: 'pop_url=' + pop_url,
			success: function(data) {
				if (data) {
					//popup.show(evt.coordinate, data);
					$('#info_data').html(data);
					//$('#info_data_div').show();
						var idids= "id='"+$('#high_id').val()+"'";
					 
					 var filterParams = {
          'CQL_FILTER': '' +  idids + '',
          'STYLES': 'highlight'
          // selected_dept_100c
        };
        map.addLayer(projecthg_layer);
              projecthg_layer.getSource().updateParams(filterParams);

				}
			}
		});
	}
	//toggleEditor(null);
	var getPop = null;
	//if (!$('.tool-toggle').hasClass('active')) {
		// Hide existing popup and reset it's offset
		popup.hide();
		popup.setOffset([0, 0]);
		var prop = '';
		//Check for visible layers
		// var layers = map.getLayers();
		var pop_url = '';
		map.getLayers().forEach(function(layer) {
			//if (layer instanceof ol.layer.Group) {
				//layer.getLayers().forEach(function(sublayer) {
					if (layer.get('type') == 'wms' && layer.get('visible') == true) {
						iid = layer.get('title')
						uid = layer.get('id');
						pop_url = pop_url + '{"url":"' + encodeURI(layer.getSource().getGetFeatureInfoUrl(evt.coordinate, map.getView().getResolution(), map.getView().getProjection(), {
							'INFO_FORMAT': 'text/plain',
							'FEATURE_COUNT': 1
						})) + '","layer_name":"' + iid + '","uid":"' + uid + '"},';
		
					}
				//})
			//}
		
		})
		if (pop_url != '') {
			pop(pop_url);
			console.log(pop_url)
		}
	//}
});

function ShowLayers(layer,lat,lon){
	
       
		
	map1.getLayers().forEach(function(layer) {
			
	if (layer.get('type') == 'wms') {
		
		map1.removeLayer(layer);
	}
	
	})
	
	    

	
	$('#legendPanel').html('');
	$('#layerTree').html('');
	popup2.hide();
		popup2.setOffset([0, 0]);
	
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
			
			 map1.getView().setCenter(ol.proj.transform([lon, lat], 'EPSG:4326', 'EPSG:3857'));
		map1.getView().setZoom(15); 
		}
		
		else {
			
			var zoom_extent = JSON.parse(response);
			
           zoom_extent =  zoom_extent.split(",");
		   console.log(zoom_extent);
		   setTimeout(function(){ map1.getView().fit(zoom_extent, map1.getSize()); }, 1000);
		   
		}
			
			}
	});
	
	}
	
	else {
		
		 map1.getView().setCenter(ol.proj.transform([lon, lat], 'EPSG:4326', 'EPSG:3857'));
		map1.getView().setZoom(15); 
		
	}
	
	
	
     for (i = 0; i < l_array.length; i++) {
	   addLayer(l_array[i],l_array[i].substring(0, l_array[i].length-14), true);
	   $("#layerTree").append("<input style = 'margin-left:10px' type='checkbox' checked onChange=toogleLayer('"+l_array[i]+"')>&nbsp"+l_array[i].substring(0, l_array[i].length-14)+"</br>")
}
    
   $("#layerTree").append("<input style = 'margin-left:10px' type='checkbox'  onChange=toogleLayer('sp_water_bodies')>&nbspWater Bodies</br>");$("#layerTree").append("<input style = 'margin-left:10px' type='checkbox'  onChange=toogleLayer('sp_river')>&nbspRivers</br>");$("#layerTree").append("<input  style = 'margin-left:10px' type='checkbox'  onChange=toogleLayer('rv')>&nbspRevenue Villages Boundary</br>");$("#layerTree").append("<input style = 'margin-left:10px' type='checkbox'  onChange=toogleLayer('sp_taluk')>&nbspTaluk Boundary</br>");$("#layerTree").append("<input  style = 'margin-left:10px' type='checkbox'  onChange=toogleLayer('sp_district')>&nbspDistrict Boundary</br>");
	map1.updateSize();
	$('#myModal').modal('show');
	
	 setTimeout( function() { map1.updateSize();}, 500);
	 
	lat = parseFloat(lat)
	lon = parseFloat(lon);
	
	 map1.getView().setCenter(ol.proj.transform([lon, lat], 'EPSG:4326', 'EPSG:3857'));
    map1.getView().setZoom(15);
	//$('#prj_tittle').html(prj_tittle);
	
	addLayer('sp_water_bodies','Water Bodies', false);
		addLayer('sp_river','Rivers', false);
		addLayer('rv','Village', false);
	    addLayer('sp_taluk','Taluk', false);
		addLayer('sp_district','District', false);
	
  
	
}

var raster = new ol.layer.Tile({
				title: 'Here Terrain Map',
				visible: false,
				baseLayer: true,
				source: new ol.source.XYZ({
					url: 'https://1.aerial.maps.ls.hereapi.com/maptile/2.1/maptile/newest/terrain.day/{z}/{x}/{y}/256/png8?apiKey=IPTEDpK8mbJtwQAX-YIZRoty81BzpLwXwRHFxngkRqU',
					attributions: attr
				})
			});
			
 var satellite =   new ol.layer.Tile({
        title: 'Here Satellite Map',
        visible: true,
        baseLayer: true,
        source: new ol.source.XYZ({
          url: 'https://1.aerial.maps.ls.hereapi.com/maptile/2.1/maptile/newest/satellite.day/{z}/{x}/{y}/256/png8?apiKey=IPTEDpK8mbJtwQAX-YIZRoty81BzpLwXwRHFxngkRqU',
          attributions: attr
        })
      })

 map1 = new ol.Map({
	layers: [raster, satellite],
	target: 'map1',
	view: new ol.View({
		center: [8781480.570496075, 1224732.6162325153],
		zoom: 7,
		minZoom: 7})
});
map1.addControl(fullScreenControll);
map1.addControl(ctrl);

function addLayer(un, vis_name, visiblity) {

	var layer = new ol.layer.Tile({
		id:un,
		title:vis_name,
		type: 'wms',
		legend: '<nav id="leg_2"><img src="<?php echo GSURL; ?>/wms?REQUEST=GetLegendGraphic&VERSION=1.0.0&FORMAT=image/png&WIDTH=20&HEIGHT=20&LAYER=<?php echo WORKSPACE ?>:' + un + '"<p>&nbsp' + un + '</p></br></nav>',
		source: new ol.source.TileWMS({
			// TODO: Change URL
			url: '<?php echo (GSURL."/".WORKSPACE."/wms"); ?>',
			params: {
				'LAYERS': un
			},
			serverType: 'geoserver'
		}),
		visible: visiblity,
		displayInLayerSwitcher:false

	});
	
	map1.addLayer(layer);
	
	$('#legendPanel').append('<nav style="margin-left:50px" id="nav_legend"><img src="<?php echo GSURL; ?>/wms?REQUEST=GetLegendGraphic&VERSION=1.0.0&FORMAT=image/png&WIDTH=20&HEIGHT=20&LAYER=<?php echo WORKSPACE ?>:' + un + '"<p>&nbsp' + vis_name + '</p></br></nav>');
}

       

function toogleLayer(mid){
	

        var layer;
        map1.getLayers().getArray().forEach(function (lyr) {
	
			if (lyr.get('id') == mid){
				console.log(lyr);
                    if (lyr.getVisible() == true){
						console.log(lyr);
						lyr.setVisible(false);
					}
					
					else {
						lyr.setVisible(true);
						
					} 
						
			}
        });
        
    }
	
	
	var element = document.getElementById('popup2');
    var popup2 = new ol.Overlay.Popup();
    map1.addOverlay(popup2);
	
	map1.on('singleclick', function(evt) {
	var iid, uid;
  if ($('#type').val() == 'null' || $('#type').val() == undefined) {
	function pop(pop_url1) {
		pop_url1 = pop_url1.substring(0, pop_url1.length - 1);
		pop_url1 = '[' + pop_url1 + ']';
		pop_url = pop_url1.replace(/&/g, '%26');
		$.ajax({
			url: 'php/getPopup1.php',
			type: 'POST',
			data: 'pop_url=' + pop_url,
			success: function(data) {
				if (data) {
					popup2.show(evt.coordinate, data);
				}
			}
		});
	}
	//toggleEditor(null);
	var getPop = null;
	if (!$('.tool-toggle').hasClass('active')) {
		// Hide existing popup and reset it's offset
		popup2.hide();
		popup2.setOffset([0, 0]);
		var prop = '';
		//Check for visible layers
		// var layers = map.getLayers();
		var pop_url = '';
		map1.getLayers().forEach(function(layer) {
			//if (layer instanceof ol.layer.Group) {
				//layer.getLayers().forEach(function(sublayer) {
					if (layer.get('type') == 'wms' && layer.get('visible') == true) {
						iid = layer.get('title');
						uid = layer.get('id');
						
pop_url = pop_url + '{"url":"' + layer.getSource().getGetFeatureInfoUrl(evt.coordinate, map1.getView().getResolution(), map1.getView().getProjection(), {
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


getDept();

function getDept() {
	
		$.ajax({
		url: 'php/function.php',
		type: 'POST',
		data: 'case=getDept',
		success: function(response) {
			var html = JSON.parse(response);
			console.log(response);
			$('#dept').html(html.html);
			
		}
	})
}

 $("#dept").change(function() {
	 
	 	popup.hide();
		popup.setOffset([0, 0]);
	if ($("#dept").val() == 'null') {
		
		var filterParams = {
					'CQL_FILTER': null
				}
				
				map.getView().setCenter([8737452.842203801, 1166028.9785095]);
    map.getView().setZoom(5);
				$('#dept_proj_div').hide();

	}
	
	else {

	var filterParams = {
					'CQL_FILTER': "hod_name='"+$("#dept").val()+"'"
				}
				
		$.ajax({
		url: 'php/function.php',
		type: 'POST',
		data: 'dept='+ encodeURIComponent($("#dept").val()) +'&case=getExtent',
		success: function(response) {
			var zoom_extent = JSON.parse(response);
			console.log(zoom_extent);
           zoom_extent =  zoom_extent.split(",");
			map.getView().fit(zoom_extent, map.getSize());
			$('#dept_proj_div').show();
			LoadFilterPojects(encodeURIComponent($("#dept").val()));
			
		}
	});
				
	}
		
			project_layer.getSource().updateParams(filterParams);
			

  
});


$('.Count').each(function () {
    $(this).prop('Counter',0).animate({
        Counter: $(this).text()
    }, {
        duration: 3000,
        easing: 'swing',
        step: function (now) {
            $(this).text(Math.ceil(now));
        }
    });
});
  
  
  // measure
  
  
  var source = new ol.source.Vector();
var vectorLayer = new ol.layer.Vector({
	source: source,
	displayInLayerSwitcher: false,
	style: new ol.style.Style({
		fill: new ol.style.Fill({
			color: 'rgba(255, 255, 255, 0.2)'
		}),
		stroke: new ol.style.Stroke({
			color: '#ffcc33',
			width: 2
		}),
		image: new ol.style.Circle({
			radius: 7,
			fill: new ol.style.Fill({
				color: '#ffcc33'
			})
		})
	})
});
var measureCtrl = new ol.control.Button({
	html: '<i class="fa fa-share-alt" data-toggle="popover" data-html="true" title="Measure Tool" data-content="Select the Measurement Type</br><select id=type onChange=measure()><option value=null>Select</option><option value=LineString>Length</option><option value=Polygon>Area</option></select></br></br><label id=js-result></label></br></br><button class=btn-danger onclick=clearMeasure()>Clear Measurement</button>"</i>',
	className: "hello",
	title: "Measure Tool",
	handleClick: function() {
		clearMeasure();
	}
});
map1.addControl(measureCtrl);
$(document).ready(function() {
	$('[data-toggle="popover"]').popover();
});

function measure() {
	if ($('#type').val() == 'null') {
		clearMeasure()
	} else {
		map1.addLayer(vectorLayer);
		enableMeasuringTool();
	}
}

function clearMeasure() {
	map1.removeInteraction(measuringTool);
	map1.removeLayer(vectorLayer);
	vectorLayer.getSource().clear();
	$('#js-result').html('');
	$('#type').val('null');
}

 function LoadFilterPojects(name) {
	 
	 $.ajax({
		url: 'php/function.php',
		type: 'POST',
		data: 'dept='+ name +'&case=getHodProj',
		success: function(response) {
		
     $('#dept_proj').html(response);
		}
	});
	 
 }
 
 
  $("#dept_proj").change(function() {
	 
	 	popup.hide();
		popup.setOffset([0, 0]);
	if ($('option:selected', '#dept_proj').attr('uid') == 'null') {
			var filterParams = {
					'CQL_FILTER': "hod_name='"+$("#dept").val()+"'"
				}
				
		$.ajax({
		url: 'php/function.php',
		type: 'POST',
		data: 'dept='+ encodeURIComponent($("#dept").val()) +'&case=getExtent',
		success: function(response) {
			var zoom_extent = JSON.parse(response);
			console.log(zoom_extent);
           zoom_extent =  zoom_extent.split(",");
			map.getView().fit(zoom_extent, map.getSize());
			$('#dept_proj_div').show();
			LoadFilterPojects(encodeURIComponent($("#dept").val()));
			
		}
	});
	
				

	}
	
	else {

	var filterParams = {
					'CQL_FILTER': "id='"+$('option:selected', '#dept_proj').attr('uid') +"'"
				}
				
	 zoom_extent =  $('#dept_proj').val().split(",");
			map.getView().fit(zoom_extent, map.getSize());

				
	}
		
			project_layer.getSource().updateParams(filterParams);
			

  
});

function openImg(param) {
  var imgSrc = $(param).attr("src");
 
  $('#imagepreview').attr('src', imgSrc);
  $('#imagemodal').modal('show');
 
}


var fullScreenControll = new ol.control.FullScreen();
map1.addControl(fullScreenControll);
map.addControl(fullScreenControll);


</script>
<script src="js/tdraw.js"></script>
<img style="display:none" src="https://tngis.tn.gov.in/gsl/gsl.php"/>
</body>
</html>

 