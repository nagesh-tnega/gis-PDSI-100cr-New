
<?php 
	include('php/session.php');
	include('php/config.php');
    if (!$_SESSION['100c_user_info']['role'] == 11){
		echo "!!! UNAUTHORISED USAGE !!!";
		die;
	}
	
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Projects-Report Dashboard</title>
		<link rel="shortcut icon" type="image/png" href="<?php echo DOMAIN . 'images/logo2.png';?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="<?php echo DOMAIN . 'css/bootstrap.min.css';?>">
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
		<script src="<?php echo DOMAIN . 'js/jquery-min.js';?>"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
		<script src="<?php echo DOMAIN . 'js/bootstrap.min.js';?>"></script>
		<script src="<?php echo DOMAIN . 'js/ol.js';?>"></script>
		
		<link rel="stylesheet" type="text/css" href="<?php echo DOMAIN . 'css/ol.css';?>">
		<link rel="stylesheet" type="text/css" href="<?php echo DOMAIN . 'css/olExt.css'; ?>">
		<script src="js/olExt.js"></script>
		<script src="<?php echo DOMAIN . 'js/ol-popup.js'; ?>"></script>
		<style>
			.css-serial {
			counter-reset: serial-number;  /* Set the serial number counter to 0 */
			}
			
			.css-serial td:first-child:before {
			counter-increment: serial-number;  /* Increment the serial number counter */
			content: counter(serial-number);  /* Display the counter */
			}
			
			.ol-layerswitcher .panel li label {
			font-size:medium;
			}
			
			.business-card {
			  border: 1px solid #cccccc;
			  background: #f8f8f8;
			  padding: 10px;
			  border-radius: 4px;
			  margin-bottom: 10px;
			}
			.profile-img {
			  height: 120px;
			  background: white;
			}
			.job {
			  color: #666666;
			  font-size: 17px;
			}
			.mail {
			  font-size: 16px;
			 }
			 
			 td {
				 padding-left : 10px;
				 padding-right : 10px;
				 
			 }
			
			
		</style>
	</head>
	<body>
		
		
		<?php 
			include('header.php');
			include('menu.php');
		?>


		<div class="bg-dark">
			<div style="">
				
				
						
						
					
				<div id="accordion">
					
					
				</div>
			</div>
			
		</div>
		<div class="modal fade" id="ShowLayerModal" role="dialog">
			<div class="modal-dialog" style="max-width:90%;margin: 30px auto;font-size: xx-medium;">
				
				<!-- Modal content-->
				<div class="modal-content">
					
					<div class="modal-header">
						<h6 class="modal-title" id="prj_tittle">View Layers</h6>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body">
						
						
						<div class="row" id="maincontent">
							
							<div id="map1" style="height:60vh" class="col-md-7">
								
							</div>
							<div id="popup2" class="ol-popup">
								<a href="#" id="popup-closer" class="ol-popup-closer"></a>
								<div id="popup-content-2"></div>
							</div>
							
							
							<div class="col-md-5text-justify text-wrap" id="info_div" style="height:60vh;font-size:medium;overflow-wrap: anywhere;">
								
								
							</div>
							
							<div class="ml-1 mb-1" id="color_code_div">
								<p class="lead">Legend</p>
								<button type="button" class="btn btn-success">Completed</button>
								<button type="button" class="btn btn-warning">In Progress</button>
								<button type="button" class="btn btn-danger">Yet To be Implemented</button>
								<button type="button" class="btn" style="background-color:yellow">Others</button>
							</div>
							
						</div>
					</div>
					
				</div>
				
				
				
			</div>
			
		</div>
		
		
		<div class="modal fade" id="contact_persons_modal" role="dialog">
    <div class="modal-dialog" style="max-width:60%;margin: 30px auto;">
		
		<!-- Modal content-->
		<div class="modal-content">
			
			<div class="modal-header">
				<h6 class="modal-title">Contact Persons</h6>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
       <div class="modal-body" id="contact_persons_body">


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
		
		<script>
			$.ajax({
				url: 'php/function.php',
				type: 'POST',
				data: 'case=getReport',
				success: function (response) {
					
					var output = $.parseJSON(response);
					
					console.log(output);
					var unique_dept_name = output.filter((value, index, self) => self.map(x => x.dept_name).indexOf(value.dept_name) == index);
					
					
					
					unique_dept_name.forEach((value, index, self) => {
						var id = value['dept_code'];
						var name = value['dept_name'];
						
						
						var count = output.reduce(function(n, val) {
							return n + (val['dept_name'] === name);
						}, 0);
						
						console.log(count);
						
						
						var div = '<div class="card" style="max-height:72vh;overflow-y:auto"><div class="card-header"><a class="card-link" data-toggle="collapse" href="#'+id+'">'+name+' ( '+count+' Projects )</a></div><div id="'+id+'" class="collapse" data-parent="#accordion"><div class="card-body" id="'+id+'_div"></div></div></div>';
						$('#accordion').append(div);
					})  
					
					var unique_hod_name = output.filter((value, index, self) => self.map(x => x.hod_dept_code).indexOf(value.hod_dept_code) == index);
					
					
					
					unique_hod_name.forEach((value, index, self) => {
						var id = value['hod_dept_code'];
						var hod_name = value['hod_name'];
						var dept_id = value['dept_code'];
						var div = '<div class=""></br><h4 class="text-center text-danger">HOD Name - '+hod_name+' <button class="btn btn-info" onClick=showContacts("'+id+'")>View Contacts</button></h4><div id="'+id+'"><table class="table-bordered css-serial table-hover" id="tab_'+id+'"><tr class="text-center text-white bg-success"><th style="width:2% !important">Sno</th><th style="width:30% !important">Project Name</th><th style="width:3.8% !important">Funding Agency<th style="width:30%">Short Dectiption Of Project</th><th style="width:30%">Updated Date</th><th style="width:3.8%">Project Start Date</th><th style="width:3.8% !important">Project End Date</th><th style="width:3.8% !important">Project Cost</th><th style="width:3.8% !important">Total fund received</th><th style="width:3.8%!important">Total fund yet to be received</th><th style="width:3.8% !important">Extend Of Date</th><th style="width:3.8%!important">Remarks</th><th style="width:3.8% !important">GIS Layers</th><th style="width:3.8% !important">More Info</th></tr></table></div></div>';
						$('#'+dept_id).append(div);
					})
					var sno_i = 1;
					output.forEach((value, index, self) => {
						var hod_id = value['hod_dept_code'];
						var prj_name = value['name_of_the_project'];
						var short_description_of_the_project = value['short_description_of_the_project'];
						var updated_date = value['updated_date'];
						var funding_agency = value['funding_agency'];
						var project_start_date = value['project_start_date'];
						var project_end_date = value['project_end_date'];
						var project_cost = value['project_cost']+'Crores';
						var fund_received = value['fund_received'];
						var fund_yet_to_be_received = value['fund_yet_to_be_received'];
						var remarks = value['remarks'];
						var eot = value['eot'];
						var latitude = value['latitude'];
						var longitude = value['longitude'];
						var layers = value['layers'];
						var id = value['id'];
						if (layers != ''){
						var gis_data = "<p class='text-center'>&#9989;</p>";
						}
						else{
						var gis_data =	'<p class="text-center" style="color:red">🗙</p>';
							}
						var button = '<button class="btn btn-primary" onClick=ShowLayers("'+layers+'","'+latitude+'","'+longitude+'","'+id+'")>View More</button>'
						
						
						var div = '<tr class=""><td></td><td>'+prj_name+'</td><td>'+funding_agency+'</td><td>'+short_description_of_the_project+'</td><td>'+updated_date+'</td><td>'+project_start_date+'</td><td>'+project_end_date+'</td><td>'+project_cost+'</td><td>'+fund_received+'</td><td>'+fund_yet_to_be_received+'</td><td>'+eot+'</td><td>'+remarks+'</td><td>'+gis_data+'</td><td>'+button+'</td></tr>';
						$('#tab_'+hod_id+' tr:last').after(div);
						
					})
					
					
					
					
					
					
					
				}
				
			});
			
			
			var raster = new ol.layer.Tile({
				title: 'Here Terrain Map',
				visible: false,
				baseLayer: true,
				source: new ol.source.XYZ({
					url: 'https://1.aerial.maps.ls.hereapi.com/maptile/2.1/maptile/newest/terrain.day/{z}/{x}/{y}/256/png8?apiKey=IPTEDpK8mbJtwQAX-YIZRoty81BzpLwXwRHFxngkRqU'
					
				})
			});
			
	 var satellite =   new ol.layer.Tile({
        title: 'Here Satellite Map',
        visible: true,
        baseLayer: true,
        source: new ol.source.XYZ({
          url: 'https://1.aerial.maps.ls.hereapi.com/maptile/2.1/maptile/newest/satellite.day/{z}/{x}/{y}/256/png8?apiKey=IPTEDpK8mbJtwQAX-YIZRoty81BzpLwXwRHFxngkRqU'
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
			
			//map1.addControl(fullScreenControll);
			
			function addLayer(un,l_name,vis) {
				
				if (vis == null){
					vis = true;
				}
				
				var layer = new ol.layer.Tile({
					id:un,
					title:l_name,
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
					visible: vis
					
				});
				
				map1.addLayer(layer);
				
				
				
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
			
			
			function ShowLayers(layer,lat,lon,id){
				
				map1.getLayers().forEach(function(layer) {
					
					if (layer.get('type') == 'wms') {
						
						map1.removeLayer(layer);
						
					}
					
				});
				
				map1.getLayers().forEach(function(layer) {
					
					if (layer.get('type') == 'wms') {
						
						map1.removeLayer(layer);
						
					}
					
				});
				map1.setLayerGroup(new ol.layer.Group());
				//$('#additional_LayerTree').html('<h5>Additional Layers</h5><input type="checkbox" onChange=toogleLayer("sp_district")>District</li></br><input type="checkbox" onChange=toogleLayer("sp_taluk")>Taluk</li></br><input type="checkbox" onChange=toogleLayer("rv")>Village</li></br><input type="checkbox">Water Bodies</li></br><input type="checkbox">Road</li></br>');
				var ctrl = new ol.control.LayerSwitcher({
					show_progress: true,
					Opt: false,
					reordering: false,
					collapsed: true
				});
				map1.addControl(ctrl);
				map1.addLayer(raster);
				map1.addLayer(satellite);
				addLayer('sp_water_bodies','Water Bodies',false);
				addLayer('sp_river','Rivers',false);
				addLayer('rv','Village',false);
				addLayer('sp_taluk','Taluk',false);
				addLayer('sp_district','District',false);
				$('#legendPanel').html('');
				$('#layerTree').html('');
				popup2.hide();
				popup2.setOffset([0, 0]);
				
				var l_array = layer.split(",");
				
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
					var d_layer_name = l_array[i].substring(0, l_array[i].length-14);
					addLayer(l_array[i],d_layer_name);
					$("#layerTree").append("<input type='checkbox' checked onChange=toogleLayer('"+l_array[i]+"')>&nbsp"+d_layer_name+"</br>")
				}
				map1.updateSize();
				$('#ShowLayerModal').modal('show');
				
				setTimeout( function() { map1.updateSize();}, 500);
				
				lat = parseFloat(lat)
				lon = parseFloat(lon);
				
				map1.getView().setCenter(ol.proj.transform([lon, lat], 'EPSG:4326', 'EPSG:3857'));
				map1.getView().setZoom(15);
				//$('#prj_tittle').html(prj_tittle);
				
				
				$('#map1').addClass('col-md-7').removeClass('col-md-12');
				$('#info_div').show();
				$.ajax({
					url: 'php/function.php',
					type: 'POST',
					data: 'id='+ id +'&case=getInfo',
					success: function (response) {
						
						$('#info_div').html(response);
						
					}
				})
				
				
				
				if (layer == ''){
					
					$('#map1').hide();
					$('#color_code_div').hide();
					$('#info_div').addClass('col-md-12').removeClass('col-md-5');
					
				}
				
				else {
					
					$('#map1').show();
					$('#map1').addClass('col-md-7');
					$('#info_div').addClass('col-md-5').removeClass('col-md-12');
					$('#color_code_div').show();
				}
				
				
				
			}
			
			
			function showContacts(id){
				
				
				$('#contact_persons_modal').modal('show');
				
					$.ajax({
			        url: 'php/function.php',
					type: 'POST',
					data: 'id='+ id +'&case=viewContactById',
					success: function (response) {
						
						$('#contact_persons_body').html(response);

				
			         }
		            }) 

			}
			
			
			function openImg(param) {
				
				  var imgSrc = $(param).attr("src");
				 
				  $('#imagepreview').attr('src', imgSrc);
				  $('#imagemodal').modal('show');
 
          }
		  
 var fullScreenControll = new ol.control.FullScreen();
map1.addControl(fullScreenControll);
			
			
		</script>	
		
	</body>
</html>
