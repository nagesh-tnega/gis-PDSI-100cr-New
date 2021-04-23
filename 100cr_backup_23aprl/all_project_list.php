<?php 
require_once('php/dbHandler.php');
// include('php/session.php');
require_once('api/mstCausesOfDelay.php');
//get Causes of delay list from the master table.
$causes_of_delay = mstCausesOfDelay::getCausesOfDelay(DBCON);

// $hod_dept = $_SESSION['100c_user_info']['hod_dept_code'];

?> 

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Major Infrastructure Projects of Tamil Nadu</title>
  <link rel="shortcut icon" type="image/png" href="images/logo2.png" />
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- IonIcons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" type="text/css" href="css/ol.css">
  <link rel="stylesheet" type="text/css" href="css/olExt.css">
</head>
<body class="hold-transition sidebar-mini sidebar-collapse">
<div class="wrapper">
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
      <!-- <img src="images/logo2.png" alt="Major Infrastructure" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Major Infrastructure</span> -->
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="dashboard.php" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-header">Projects</li>
          <li class="nav-item">
            <a href="projects.php" class="nav-link">
              <i class="nav-icon fas fa-tasks"></i>
              <p>
                MIS
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="gis_map.php" class="nav-link">
              <i class="nav-icon fas fa-globe"></i>
              <p>
                GIS
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="search.php" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>
                Search
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="projects_list.php" class="nav-link">
              <i class="nav-icon fas fa-database"></i>
              <p>
                Add Project 
              </p>
            </a>
          </li>
          <li class="nav-header">Reports</li>
          <li class="nav-item">
            <a href="report_abstract.php" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>
                Project Abstract
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="report_details.php" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>
                Project Details
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="report_delay.php" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>
                Causes of Delay
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="logout.php" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Logout
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-12">
            <div class="d-flex justify-content-center">
              <h4 href="#"> <img src="<?php echo DOMAIN . 'images/logo.png'; ?>" width="70" height="70" class="d-inline-block align-top" alt="">WebGIS for Monitoring the Major Infrastructure Projects of Tamil Nadu<img src="<?php echo DOMAIN . 'images/logo2.png'; ?>" width="70" height="70" class="" alt="">
              </h4>
            </div>
          </div>
        </div>
       
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Project List</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-primary btn-block btn-sm float-right" onClick="add_prj()"><i class="fa fa-plus"></i> Add Project</button>
                </div>
                <!--  /. Display only for Owner with active status-->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Department</th>
                      <th>HOD</th>
                      <th>Name of the project</th>
                      <th>GIS Layers</th>
                      <th>Created date</th>
                      <th>Last updated</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $query = "select project_id, name_of_the_project, project_start_date, layers as GIS_layers, DATE(created_time) as Created_Date,DATE(updated_time) as Last_Updated, id, layers, latitude, longitude,hod_name,dept_code from sp_index_v2 order by updated_time desc";
                      $result = pg_query(DBCON, $query);
                      $count = pg_num_rows($result);
                      if ($count > 0) {
                        $i = 1;
                        while ($row = pg_fetch_row($result)) {
                          $layers = trim($row[3]);
                          if ($layers == ''){  
                            $row[3] = '<p class="text-center" style="color:red">🗙</p>';
                          }
                          else {
                            $lat = $row[8];
                            $lon = $row[9];
                            $layers = $row[7];
                            $sp_id = $row[6];
                            $row[3] = "<p class='text-center'>&#9989;</p><button onClick = ShowLayers('$layers','$lat','$lon',$sp_id)>View Layers</button>";
                          }
                    ?>
                        <tr>
                          <td><?php echo $i; ?></td>
                          <td><?php echo $row[11];?></td>
                          <td><?php echo $row[10];?></td>
                          <td><?php echo $row[1];?></td>
                          <td><?php echo $row[3];?></td>
                          <td><?php echo $row[4];?></td>
                          <td><?php echo $row[5];?></td>
                        </tr>
                    <?php
                          $i++;
                        }
                      }else{
                    ?>
                    <tr>
                      <td colspan='7'>No data found</td>
                    </tr>
                    <?php
                      }
                    ?>
                  </tbody>          
                </table>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Show Layer Model -->
        <div class="modal fade" id="ShowLayerModal" role="dialog">
          <div class="modal-dialog" style="max-width:90%;margin: 30px auto;font-size: xx-small;">
          <!-- Modal content-->
            <div class="modal-content">  
              <div class="modal-header">
                <h6 class="modal-title" id="prj_tittle">View Layers</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">  
                <div class="row" id="maincontent">
                  <div id="map1" class="col-md-7"style="height:53vh">
                  </div>
                  <div id="popup2" class="ol-popup">
                    <a href="#" id="popup-closer" class="ol-popup-closer"></a>
                    <div id="popup-content-2"></div>
                  </div>
                  <div class="col-md-5 text-justify text-wrap" id="info_div" style="height:53vh;font-size:medium;overflow-wrap: anywhere;">
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
        <!--End layer model -->
      </div>
    </div>
  </div>
  <!-- /.content-wrapper -->
  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy;tnega.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0.1
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE -->
<script src="dist/js/adminlte.js"></script>
<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="js/notify.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tagmanager/3.0.2/tagmanager.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
<script src="js/data.js"></script>
<script src="js/ol.js"></script>
<script src="js/olExt.js"></script>
<script src="js/ol-popup.js"></script>

<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": [
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [0,1,2,3,4,5,6]
                }
            },
            "csv",
            {
              extend: 'excelHtml5',
              autoFilter: true,
              sheetName: 'All Projects List',
              exportOptions: {
                columns: [0,1,2,3,4,5,6]
              }
            }, 
            {
              extend: 'pdfHtml5',
              exportOptions: {
                columns: [0,1,2,3,4,5,6]
              }
            }, 
            {
              extend: 'print',
              exportOptions: {
                columns: [0,1,2,3,4,5,6]
              }
            },
            "colvis",
            
      ]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  });
</script>

<!-- Show Layers -->
<script type="text/javascript">
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
        }else {
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
    var ctrl = new ol.control.LayerSwitcher({
      show_progress: true,
      Opt: false,
      reordering: false,
      collapsed: true
    });  
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
    }else if (l_array.length == 2) { 
      layer1 = l_array[0];
      layer2 = l_array[1];
      layer3 = 'null'; 
    }else {  
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
          }else {
            var zoom_extent = JSON.parse(response);
            zoom_extent =  zoom_extent.split(",");
            setTimeout(function(){ map1.getView().fit(zoom_extent, map1.getSize()); }, 1000);
          } 
        }
      });
    }else { 
      map1.getView().setCenter(ol.proj.transform([lon, lat], 'EPSG:4326', 'EPSG:3857'));
      map1.getView().setZoom(15); 
    }
    for (i = 0; i < l_array.length; i++) {
        var d_layer_name = l_array[i].substring(0, l_array[i].length-14);
        addLayer(l_array[i],d_layer_name);
        $("#layerTree").append("<input type='checkbox' checked onChange=toogleLayer('"+l_array[i]+"')>&nbsp"+d_layer_name+"</br>")
    }
    map1.updateSize();
    map1.addControl(ctrl);
    $('.ol-layerswitcher').removeClass('ol-forceopen'); 
    $('#ShowLayerModal').modal('show'); 
    setTimeout( function() { map1.updateSize();}, 500); 
    lat = parseFloat(lat)
    lon = parseFloat(lon);
    //$('#prj_tittle').html(prj_tittle);
    if(id){
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
    }else {  
      $('#map1').addClass('col-md-12').removeClass('col-md-7');
      $('#info_div').hide();
    }    
  }
</script>
</body>
</html>
