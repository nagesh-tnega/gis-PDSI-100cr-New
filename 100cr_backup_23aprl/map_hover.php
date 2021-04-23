<?php 
  require_once('php/dbHandler.php');
  include('php/session.php');
   $ind_dept =  pg_query(DBCON,"SELECT * from sp_index_v1 where layers !='' and layers is not null and dept_code='D10' ");$ind_count=pg_num_rows($ind_dept);
   $trans_dept = pg_query(DBCON,"SELECT * from sp_index_v1 where layers !='' and layers is not null and dept_code='D20'");$trans_count=pg_num_rows($trans_dept);
   $hudd_dept = pg_query(DBCON,"SELECT * from sp_index_v1 where layers !='' and layers is not null and dept_code='D30'");$hudd_count=pg_num_rows($hudd_dept);
   $pwd_dept = pg_query(DBCON,"SELECT * from sp_index_v1 where layers !='' and layers is not null and dept_code='D40'");$pwd_count=pg_num_rows($pwd_dept);
   $maws_dept = pg_query(DBCON,"SELECT * from sp_index_v1 where layers !='' and layers is not null and dept_code='D50'");$maws_count=pg_num_rows($maws_dept);
   $engy_dept = pg_query(DBCON,"SELECT * from sp_index_v1 where layers !='' and layers is not null and dept_code='D60'");$engy_count=pg_num_rows($engy_dept);

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
   <link rel="stylesheet" href="css/apex.css">
  <!-- map CSS -->

   <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.5.0/css/ol.css">
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
            <a href="gis_map.php" class="nav-link active">
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
          </div><!-- /.col -->
        </div><!-- /.row -->
        <!-- <div class="row">
          <div class="col-sm-6"></div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">GIS</li>
            </ol>
          </div>
        </div> -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <div class="position-relative mb-4" style="padding-bottom: 25px;">
                  <!-- <h3 class="card-title" style="padding-bottom: 25px;">GIS</h3> -->
                  <div id="map" style="height: 82vh; width: 100%;">
                    <div id="popup" class="ol-popup"> </div>
                    <div id="popup1" class="ol-popup"> </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- <div class="col-lg-5">
            <div class="card">
              <div class="card-body">
                <label>Please Select the Department</label></br>
                <select id="dept" style="width:90%"></select></br></br>
                <div id ="project" style="display:none;overflow:auto; max-height:60vh"> 

                </div>
              </div>
            </div>
          </div> -->
        </div>          
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
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

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard3.js"></script>
<script src="assets/js/apex.js"></script>
<!-- map js -->

<!-- <script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.4.3/build/ol.js"></script>
 -->
 <script src="js/ol6.js"></script>
 <script src="js/ol-popup.js"></script>
<script src="js/olExt.js"></script>

<script type="text/javascript">
  var attr = '<div style="text-align: left;font-size: .5rem"><b>DISCLAIMER</b><br>Due to variations in scale, layers may not depict exact locations on OSM or Other maps; Boundaries of Cadastral Map are displayed as received from the source and are not authentic nor meant to be authentic.</div>'
   var layers = [
    new ol.layer.Group({
      title: '<b style="color:black">Base Maps</b>',
      openInLayerSwitcher: true,
      layers: [
       
        new ol.layer.Tile({
          title: 'Satellite',
          visible: false,
          baseLayer: true,
          source: new ol.source.XYZ({
            url: 'https://1.base.maps.ls.hereapi.com/maptile/2.1/maptile/newest/normal.day/{z}/{x}/{y}/256/png8?apiKey=IPTEDpK8mbJtwQAX-YIZRoty81BzpLwXwRHFxngkRqU',
            attributions: attr
          })
        }),
         new ol.layer.Tile({
        title: "Default",
        baseLayer: true,
        visible: true,
        minZoom:9,
        source: new ol.source.OSM()
      })
      ]
    })
  ];
  var controls = ol.control.defaults({rotate: false}); 
var interactions = ol.interaction.defaults({altShiftDragRotate:false, pinchRotate:false,dragPan: true});
  var map = new ol.Map({
  controls: controls,
    interactions: interactions,
    layers: layers,
    target: 'map',
    view: new ol.View({
      center: [8781480.570496075, 1224732.6162325153],
      zoom:7,
      minZoom: 7
    }),
  });
  // adding ol-ext controls
  var ctrl = new ol.control.LayerSwitcher({
    show_progress: true,
      reordering: false,
    collapsed: false
  });

  map.addControl(ctrl);
   var zoomToExtentControl = new ol.control.ZoomToExtent({
        extent: [8395626.451712506, 892078.6691354283, 9167334.689279644, 1557386.5633296024]
      });
          map.addControl(zoomToExtentControl);

  var scaleLineControl = new ol.control.ScaleLine();
  map.addControl(scaleLineControl);
  var fullScreenControll = new ol.control.FullScreen();
  map.addControl(fullScreenControll);
  // var legend = new ol.control.Legend({
  //   title: '',
  //   collapsed: true
  // });
  // map.addControl(legend);
  // legend.addRow({
  //   title: '<b style="">Legend:</b><nav id="leg_end" style="min-width: 200px;"></br><nav>'
  // })

 var pro_layer = 'lat_long_5f631872eee96,overall_site_project2_5f632658b658b,site_boundary_project_5f6326590af24,sp_cmwssb_conveying,sp_cmwssb_ugt,oragadam_to_walajabath_2_5f72ddd7ea7b8,oragadam_to_walajabath_detailed_text_5f72ddd85935b,vandalur_to_oragadam_alignment_detailed_text_5f72d86213ba4,vandalur_to_oragadam_final_5f72d86287605,mrts_reproject_5f6464559b81f,madurai_orr_5f7304a90233c,madurai_text_details_5f73045836a0b,orr_central_alignment_reproject_5f64621d75be2,kilambakkam_bus_terminal_5f8d75f0eff78,sp_cmwssb_manapakkam1,sp_cmwssb_manapakkam,sp_tidco_heh,sp_tidco_heh1,sp_tidco_heh3,final_1_cwss_to_keeranur_5f5b0dd0714f1,final_1_cwss_to_keeranur_5f5b0e0e3ef91,sp_hg_medavakkam,sp_cmwssb_conveying,sp_cmwssb_ugt,sp_cmwssb_conveying,sp_cmwssb_ugt,sp_cmwssb_manali,sp_cmwssb_manali1,velachery_shape_file1_reprojected_5f69dc7f20ad1,sp_hg_omr_ecr,sp_hg_omr_ecr1234,11012020_5ffbe74a3f0bd,sp_hg_thepakulam_line,sp_hg_thepakulam_points,sp_hg_arapalayam_line,sp_hg_arapalayam_point,sp_lc_32,mullakadu_points,mullakadu_polygon,mullakadu_polylines,sp_cmwssb_chinnasekkadu1,sp_cmwssb_chinnasekkadu,sp_cmwssb_karampakkam,sp_cmwssb_karampakkam1,sp_cmwssb_conveying,sp_cmwssb_ugt,23102020_corr_phase_ii_5f97c2234a5e0,23102020_corr_phase_i_5f97c2310126d,kelambakk_shp_5f86b182d0ba8,thiruporur_shp_5f86b1833ce86,cprr_5f87df67044fa,otachathram_6007f65d10670,line_proj_5f55c138b3426,final_1_cwss_to_keeranur_5f5b0efc15c8f,sp_hg_thiruvanmaiyur2akkarai';

var user_layers = [
   {
    "lyr_grp_name": "Departments",
    "uid": "11",
    "lyr_display_name": "<b style='color:#E033FF'>Industries - <?php echo $ind_count; ?> </b>",
    "servicename": 'ind_dept',
    "visiblity": "t",
    "sp_label_column": null,
    "popup_field": "department_name,government_orders,project_cost,district_name,present_status",
    "t_visiblity": true
  },{
    "lyr_grp_name": "Departments",
    "uid": "10",
    "lyr_display_name": "<b style='color:#F1341A'>Highways - <?php echo $trans_count; ?></b>",
    "servicename": "trans_dept",
    "visiblity": "t",
    "sp_label_column": null,
    "popup_field":"department_name,government_orders,project_cost,district_name,present_status",
    "t_visiblity": true
  },
  {
    "lyr_grp_name": "Departments",
    "uid": "9",
    "lyr_display_name": "<b style='color:#9E4180'>Housing - <?php echo $hudd_count; ?></b>",
    "servicename": "hous_urban_dept",
    "visiblity": "t",
    "sp_label_column": null,
    "popup_field": "department_name,government_orders,project_cost,district_name,present_status",
    "t_visiblity": true
  },{
    "lyr_grp_name": "Departments",
    "uid": "8",
    "lyr_display_name": "<b style='color:#7E271B'>PWD - <?php echo $pwd_count; ?></b>",
    "servicename": "pwd_dept",
    "visiblity": "t",
    "sp_label_column": null,
    "popup_field": "department_name,government_orders,project_cost,district_name,present_status",
    "t_visiblity": true
  },{
    "lyr_grp_name": "Departments",
    "uid": "7",
    "lyr_display_name": "<b style='color:#D8AF2E'>MAWS - <?php echo $maws_count; ?></b>",
    "servicename": "maws_dept",
    "visiblity": "t",
    "sp_label_column": null,
    "popup_field": "department_name,government_orders,project_cost,district_name,present_status",
    "t_visiblity": true
  },{
    "lyr_grp_name": "Departments",
    "uid": "6",
    "lyr_display_name": "<b style='color:#CBE344'>Energy - <?php echo $engy_count; ?></b>",
    "servicename": "energy_dept",
    "visiblity": "t",
    "sp_label_column": null,
    "popup_field": "department_name,government_orders,project_cost,district_name,present_status",
    "t_visiblity": true
  }, {
     "lyr_grp_name": "Projects",
    "uid": "4",
    "lyr_display_name": "Shapefiles",
    "servicename": pro_layer,
    "visiblity": "f",
    "sp_label_column": null,
    "popup_field": null,
    "t_visiblity": true
  },{
    "lyr_grp_name": "Base Layers",
    "uid": "1",
    "lyr_display_name": "TN Districts - <img src='images/district_leg.png'>",
    "servicename": "event_district",
    "visiblity": "t",
    "sp_label_column": null,
    "popup_field": null,
    "t_visiblity": true
  },
   {
    "lyr_grp_name": "Base Layers",
    "uid": "2",
    "lyr_display_name": "TN Taluks -  <img src='images/taluk_leg.png'>",
    "servicename": "sp_taluk",
    "visiblity": "f",
    "sp_label_column": null,
    "popup_field": null,
    "t_visiblity": true
  },{
    "lyr_grp_name": "Base Layers",
    "uid": "3",
    "lyr_display_name": "Projects (As Point Data)",
    "servicename": "sp_index_v1",
    "visiblity": "f",
    "sp_label_column": null,
    "popup_field": null,
    "t_visiblity": false
  },
 {
    "lyr_grp_name": "Base Layers",
    "uid": "5",
    "lyr_display_name": "tn_out",
    "servicename": "sp_tnoutpolygon",
    "visiblity": "t",
    "sp_label_column": null,
    "popup_field": null,
    "t_visiblity": false
  }
  
 ];
var output = user_layers.reverse();

function addLayer(ln, id, un, lg, label, vis, dis_in_tree, popup_field) {
  if (vis == 'f') {
    v = false;
  } else {
    v = true;
  }


  {
    var layer_legend = '<nav id="leg_' + id + '"><img src="<?php echo GSURL; ?>/wms?REQUEST=GetLegendGraphic&VERSION=1.0.0&FORMAT=image/png&WIDTH=25&HEIGHT=25&SCALE=6000000&LAYER=<?php echo WORKSPACE ?>:' + un + '"<p> ' + ln + '</p></br></nav>';


  }
  var layer = new ol.layer.Tile({
    id: id,
    title: ln,
    layerGroup: lg,
    layerName: ln,
    uniName: un,
    type: 'wms',
    label: label,
    popup_field: popup_field,
    legend: layer_legend,
    source: new ol.source.TileWMS({
      // TODO: Change URL
      url: '<?php echo (GSURL."/".WORKSPACE."/wms"); ?>',
      params: {
        'LAYERS': un
      },
      serverType: 'geoserver'
    }),
    visible: v,
    displayInLayerSwitcher: dis_in_tree,
  });
  // if (v == true) {
  //   $('#leg_end').append(layer.H.legend)
  // }
  lg_find = findBy(map.getLayerGroup(), 'title', lg);
  grp = this.lg_find.getLayers().push(layer);
}
var lg = Array.from(new Set(output.map(x => x.lyr_grp_name)));
//adding layer groups
for (i = 0; i < lg.length; i++) {
  addLayerGroup(lg[i]);
}
//adding layers to layer groups
for (i = 0; i < output.length; i++) {
  addLayer(output[i].lyr_display_name, output[i].uid, output[i].servicename, output[i].lyr_grp_name, output[i].sp_label_column, output[i].visiblity, output[i].t_visiblity, output[i].popup_field);
}
// function for adding layer groups
function addLayerGroup(lg) {
  var lyr_grp_name = new ol.layer.Group({
    title: lg,
    openInLayerSwitcher: true,
    layers: []
  })
  map.addLayer(lyr_grp_name)
}
//code for search in openlayers
function findBy(layer, key, value) {
  if (layer.get(key) === value) {
    return layer;
  }
  // Find recursively if it is a group
  if (layer.getLayers) {
    var layers = layer.getLayers().getArray(),
      len = layers.length,
      result;
    for (var i = 0; i < len; i++) {
      result = findBy(layers[i], key, value);
      if (result) {
        return result;
      }
    }
  }
  return null;
}

ctrl.on('drawlist', function(e) {
  if (e.layer instanceof ol.layer.Group) {
    e.li.className = e.layer.get('visible') ? 'visible': 'hidden';
  }
})

function listenVisible(layer, group) {
  console.log(layer)
  
  layer.on('change:visible', function(e) {
      console.log(layer.get('visible'))
    // LayerGroup
    if (layer.getLayers) {
      var vis = layer.getVisible();
      layer.getLayers().forEach( function(l) { 
        if (l.getVisible() !== vis) {
          // Prevent inifnite loop
          l.set('visible', vis, true);
        }
      });
    }
    // if inside a group, check visibility of layers in it
    if (group) {
      var vis = false;
      group.getLayers().forEach( function(l) { 
        if (l.getVisible()) vis = true;
      });
      if (group.getVisible() !== vis) group.setVisible(vis);
    }
  });
  // Listen to layers in it
  if (layer.getLayers) {
    layer.getLayers().forEach( function(l) { 
       listenVisible(l, layer);
    });
  }
}
map.getLayers().getArray().forEach(function(l) {
  listenVisible(l);
});
  
  // Popup
 var element = document.getElementById('popup');
var popup = new ol.Overlay.Popup();
map.addOverlay(popup);
var content = null;
map.on('pointermove', function(evt) {
   // pointermove singleclick
  popup1.hide();
  popup1.setOffset([0, 0]);
  var iid, uid, popup_field;
  if ($('#type').val() == 'null' || $('#type').val() == undefined) {
    function pop(pop_url1) {
      pop_url1 = pop_url1.substring(0, pop_url1.length - 1);
      pop_url1 = '[' + pop_url1 + ']';
      pop_url = pop_url1.replace(/&/g, '%26');
      $.ajax({
        url: 'php/getmapInfo.php',
        type: 'POST',
        data: 'pop_url=' + pop_url,
        success: function(data) {
          console.log(data);
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
      //popup.hide();
      //popup.setOffset([0, 0]);
      var prop = '';
      //Check for visible layers
      // var layers = map.getLayers();
      var pop_url = '';
      map.getLayers().forEach(function(layer) {
        if (layer instanceof ol.layer.Group) {
          layer.getLayers().forEach(function(sublayer) {
            if (sublayer.get('type') == 'wms' && sublayer.get('visible') == true && layer.get('visible') == true && sublayer.get('popup_field') != null) {
              iid = sublayer.get('title');
              uid = sublayer.get('id');
              popup_field = sublayer.get('popup_field');
              pop_url = pop_url + '{"url":"' + sublayer.getSource().getFeatureInfoUrl(evt.coordinate, map.getView().getResolution(), map.getView().getProjection(), {
                'INFO_FORMAT': 'text/plain',
                'FEATURE_COUNT': 1
              }) + '","layer_name":"' + iid + '","uid":"' + uid + '","popup_field":"' + popup_field + '"},';
            }
          })
        }
      })
      if (pop_url != '') {
        pop(pop_url);
        console.log(pop_url);
      }
    }
  }
});
 

function findLayerByName(name) {
  var layer;
  map.getLayers().forEach(function(lyr) {
    if (name == lyr.get('uniName')) {
      layer = lyr;
    }
  });
  return layer;
}

function toggle_popup(table) {
  $('.pop_cr').hide();
  if ($('.' + table + '_tr').is(":visible") == false) {
    $('.' + table + '_tr').show();
  } else {
    $('.' + table + '_tr').hide();
  }
}
document.addEventListener('contextmenu', event => event.preventDefault());


var element = document.getElementById('popup1');
var popup1 = new ol.Overlay.Popup();
map.addOverlay(popup1);
var content = null;

map.on('singleclick', function(evt) {
   // pointermove singleclick
  popup.hide();
  popup.setOffset([0, 0]);
  var iid, uid, popup_field;
  if ($('#type').val() == 'null' || $('#type').val() == undefined) {
    function pop(pop_url1) {
      pop_url1 = pop_url1.substring(0, pop_url1.length - 1);
      pop_url1 = '[' + pop_url1 + ']';
      pop_url = pop_url1.replace(/&/g, '%26');
      $.ajax({
        url: 'php/getStyleinfo.php',
        type: 'POST',
        data: 'pop_url=' + pop_url,
        success: function(data) {
          console.log(data);
          if (data) {
            popup1.show(evt.coordinate, data);
          }
        }
      });
    }
    //toggleEditor(null);
    var getPop = null;
    if (!$('.tool-toggle').hasClass('active')) {
      // Hide existing popup and reset it's offset
      //popup.hide();
      //popup.setOffset([0, 0]);
      var prop = '';
      //Check for visible layers
      // var layers = map.getLayers();
      var pop_url = '';
      map.getLayers().forEach(function(layer) {
        if (layer instanceof ol.layer.Group) {
          layer.getLayers().forEach(function(sublayer) {
            if (sublayer.get('type') == 'wms' && sublayer.get('visible') == true && layer.get('visible') == true && sublayer.get('popup_field') != null) {
              iid = sublayer.get('title');
              uid = sublayer.get('id');
              popup_field = sublayer.get('popup_field');
              pop_url = pop_url + '{"url":"' + sublayer.getSource().getFeatureInfoUrl(evt.coordinate, map.getView().getResolution(), map.getView().getProjection(), {
                'INFO_FORMAT': 'text/plain',
                'FEATURE_COUNT': 1
              }) + '","layer_name":"' + iid + '","uid":"' + uid + '","popup_field":"' + popup_field + '"},';
            }
          })
        }
      })
      if (pop_url != '') {
        pop(pop_url);
        console.log(pop_url);
      }
    }
  }
});
 

function findLayerByName(name) {
  var layer;
  map.getLayers().forEach(function(lyr) {
    if (name == lyr.get('uniName')) {
      layer = lyr;
    }
  });
  return layer;
}

function toggle_popup(table) {
  $('.pop_cr').hide();
  if ($('.' + table + '_tr').is(":visible") == false) {
    $('.' + table + '_tr').show();
  } else {
    $('.' + table + '_tr').hide();
  }
}
document.addEventListener('contextmenu', event => event.preventDefault());

function ShowLayers(layer,lat,lon){
   
  popup.hide();
      popup.setOffset([0, 0]);

map.getLayers().forEach(function(layer) {
      
  if (layer.get('type') == 'wms') {
    
    map.removeLayer(layer);
  }
  
  })
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
  
   for (i = 0; i < l_array.length; i++) {
     addLayer(l_array[i],l_array[i].substring(0, l_array[i].length-14), true);
     $("#layerTree").append("<input style = 'margin-left:10px' type='checkbox' checked onChange=toogleLayer('"+l_array[i]+"')>&nbsp"+l_array[i].substring(0, l_array[i].length-14)+"</br>")
}

map.updateSize();  
   setTimeout( function() { map.updateSize();}, 500);
   
  lat = parseFloat(lat)
  lon = parseFloat(lon);
  
   map.getView().setCenter(ol.proj.transform([lon, lat], 'EPSG:4326', 'EPSG:3857'));
    map.getView().setZoom(15);
}



</script>

</body>
</html>
