<?php 
require_once('php/dbHandler.php');
include('php/session.php');

//map data
 $ind_dept =  pg_query(DBCON,"SELECT * from sp_index_v2 where layers !='' and layers is not null and dept_code='D10' ");$ind_count=pg_num_rows($ind_dept);
   $trans_dept = pg_query(DBCON,"SELECT * from sp_index_v2 where layers !='' and layers is not null and dept_code='D20'");$trans_count=pg_num_rows($trans_dept);
   $hudd_dept = pg_query(DBCON,"SELECT * from sp_index_v2 where layers !='' and layers is not null and dept_code='D30'");$hudd_count=pg_num_rows($hudd_dept);
   $pwd_dept = pg_query(DBCON,"SELECT * from sp_index_v2 where layers !='' and layers is not null and dept_code='D40'");$pwd_count=pg_num_rows($pwd_dept);
   $maws_dept = pg_query(DBCON,"SELECT * from sp_index_v2 where layers !='' and layers is not null and dept_code='D50'");$maws_count=pg_num_rows($maws_dept);
   $engy_dept = pg_query(DBCON,"SELECT * from sp_index_v2 where layers !='' and layers is not null and dept_code='D60'");$engy_count=pg_num_rows($engy_dept);

// Card Data
$sql = "SELECT * from sp_index_v2 where dept_code!=''";
$total_projects = pg_query(DBCON, $sql);
$sql1 = "SELECT * from sp_index_v2 WHERE layers !='' and layers IS NOT NULL and created_time IS NOT NULL and dept_code!=''";
$mis_gis_data = pg_query(DBCON,$sql1);
$sql2 = "SELECT * from sp_index_v2 WHERE (layers = '' OR layers IS NULL) and (created_time IS NOT NULL and dept_code!='') ";
$mis_data = pg_query(DBCON, $sql2);
$sql3 = "SELECT * from sp_index_v2 WHERE (layers = '' OR layers IS NULL) and (created_time IS NULL and dept_code!='')";
$no_data = pg_query(DBCON,$sql3);
// Deptartment List
$departments = array();
$depts = array();
$department_code = array();
$dept_code = array();
$sql4 = "SELECT * FROM departments order by short_name asc";
$all_dept = pg_query(DBCON, $sql4);
if(pg_num_rows($all_dept)>0){
  $raw_data = pg_fetch_all($all_dept);
  for($i = 0;$i<count($raw_data);$i++){
    $dept_code1 = $raw_data[$i]["dept_code"];
    $dept_name = $raw_data[$i]["short_name"];
    array_push($departments,'"'.$dept_name.'"');
    array_push($depts,$dept_name);
    array_push($department_code,$dept_code1);
    array_push($dept_code,'"'.$dept_code1.'"');
  }
}
// no_data List
$no_project_data = array();
if(count($department_code)>0){
  foreach($department_code as $depts_code){
    $sql5 = "SELECT * from sp_index_v2 WHERE (dept_code='$depts_code') and (layers = '' OR layers IS NULL) and (created_time IS NULL)";
    $get_no_data = pg_query(DBCON,$sql5);
    array_push($no_project_data,pg_num_rows($get_no_data));
  }
}
// only mis_data
$only_mis_data = array();
if(count($department_code)>0){
  foreach($department_code as $depts_code){
    $sql6 = "SELECT * from sp_index_v2 WHERE (dept_code='$depts_code') and (layers = '' OR layers IS NULL) and (created_time IS NOT NULL)";
    $get_only_mis_data = pg_query(DBCON,$sql6);
    array_push($only_mis_data,pg_num_rows($get_only_mis_data));
  }
}

// both_mis_gis_data
$both_mis_gis_data = array();
if(count($department_code)>0){
  foreach($department_code as $depts_code){
    $sql7 = "SELECT * from sp_index_v2 WHERE dept_code='$depts_code' and layers !='' and layers IS NOT NULL and created_time IS NOT NULL";
    $get_only_mis_data = pg_query(DBCON,$sql7);
    array_push($both_mis_gis_data,pg_num_rows($get_only_mis_data));
  }
}

// Card time overrun status
$sql8 = "SELECT * from sp_index_v2 
WHERE present_status = '' OR present_status IS NULL OR present_status = 'Yet to be started' and dept_code!=''";
$overdue_data = pg_query(DBCON,$sql8);
$sql9 = "SELECT * from sp_index_v2 WHERE present_status = 'In progress' and dept_code!=''";
$inprogress_data = pg_query(DBCON,$sql9);
$sql10 = "SELECT * from sp_index_v2 WHERE present_status like '%ompleted%' and dept_code!=''";
$completed_data = pg_query(DBCON,$sql10);
// chart overdue data
$overdue_department_data = array();
if(count($department_code)>0){
  foreach($department_code as $depts_code){
    $sql11 = "SELECT * from sp_index_v2 WHERE dept_code='$depts_code' and  (present_status = '' OR present_status IS NULL OR present_status = 'Yet to be started')";
    $overdue_dept_data = pg_query(DBCON,$sql11);
    array_push($overdue_department_data,pg_num_rows($overdue_dept_data));
  }
}
// chart Inprogress data
$inprogress_department_data = array();
if(count($department_code)>0){
  foreach($department_code as $depts_code){
    $sql12 = "SELECT * from sp_index_v2 WHERE dept_code='$depts_code' and present_status = 'In progress'";
    $inprogress_dept_data = pg_query(DBCON,$sql12);
    array_push($inprogress_department_data,pg_num_rows($inprogress_dept_data));
  }
}
// chart completed data
$completed_department_data = array();
if(count($department_code)>0){
  foreach($department_code as $depts_code){
    $sql13 = "SELECT * from sp_index_v2 WHERE dept_code='$depts_code' and present_status like '%ompleted%'";
    $completed_dept_data = pg_query(DBCON,$sql13);
    array_push($completed_department_data,pg_num_rows($completed_dept_data));
  }
}

// Card Updation status
$sql14 = "SELECT * from sp_index_v2 WHERE updated_time = date_trunc('month', current_date) and dept_code!=''";
$less1 = pg_query(DBCON,$sql14);
$sql15 = "SELECT * from sp_index_v2 WHERE updated_time >= date_trunc('month', current_date-interval '3' month) AND updated_time < date_trunc('month', current_date) and dept_code!=''";
$oneto3 = pg_query(DBCON,$sql15);
$sql16 = "SELECT * from sp_index_v2 WHERE (updated_time < date_trunc('month', current_date-interval '3' month) OR updated_time IS NULL) and dept_code!=''";
$less3 = pg_query(DBCON,$sql16);
// chart less1
$less1_data = array();
if(count($department_code)>0){
  foreach($department_code as $depts_code){
    $sql17 = "SELECT * from sp_index_v2 WHERE dept_code='$depts_code' and updated_time = date_trunc('month', current_date)";
    $less1_dept_data = pg_query(DBCON,$sql17);
    array_push($less1_data,pg_num_rows($less1_dept_data));
  }
}
// chart oneto3
$oneto3_data = array();
if(count($department_code)>0){
  foreach($department_code as $depts_code){
    $sql18 = "SELECT * from sp_index_v2 WHERE dept_code='$depts_code' and updated_time >= date_trunc('month', current_date-interval '3' month) AND updated_time < date_trunc('month', current_date)";
    $oneto3_dept_data = pg_query(DBCON,$sql18);
    array_push($oneto3_data,pg_num_rows($oneto3_dept_data));
  }
}
// chart less3
$less3_data = array();
if(count($department_code)>0){
  foreach($department_code as $depts_code){
    $sql19 = "SELECT * from sp_index_v2 WHERE dept_code='$depts_code' and (updated_time < date_trunc('month', current_date-interval '3' month) OR updated_time IS NULL)";
    $less3_dept_data = pg_query(DBCON,$sql19);
    array_push($less3_data,pg_num_rows($less3_dept_data));
  }
}
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
<body class="hold-transition sidebar-mini sidebar-collapse layout-fixed">
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
      <div class="user-panel mt-2 pb-2 mb-2 pl-2 d-flex">
        <div class="image">
          <i class="nav-icon fas fa-user-alt"></i>
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $_SESSION['100c_user_info']['user_name']; ?></a>
        </div>
      </div>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="dashboard.php" class="nav-link active">
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
                List View
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="gis_map.php" class="nav-link">
              <i class="nav-icon fas fa-globe"></i>
              <p>
                Map View
              </p>
            </a>
          </li>
          <!-- <li class="nav-item">
            <a href="search.php" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>
                Search
              </p>
            </a>
          </li> -->
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
                Project Abstracts
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
          <div class="col-lg-6">
            <div class="card" style="display: block !important;">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Total Projects:<span style="font-size: 1.5rem;padding-left: 10px;"><a href="<?php echo DOMAIN . 'projects.php?type=all'; ?>" style="color: #000;">
                    <?php  echo pg_num_rows($total_projects) ?>
                  </a></span></h3>
                </div>
              </div>
              <div class="card-body" style="padding-bottom: 1px !important;padding-top: 27px !important;">
                <div class="position-relative mb-4">
                    <div class="row">
                      <div class="col-xs-12 col-3">
                        <div style="padding-top: 35px;">
                          <h6>Data Availability</h6> 
                        </div>
                      </div>
                      <div class="col-xs-12 col-3">
                        <div class="small-box bg-success">
                          <div class="inner">
                            <a href="<?php echo DOMAIN . 'projects.php?type=data_avail&method=mis_gis'; ?>" style="color: #fff;">
                              <h3><?php  echo pg_num_rows($mis_gis_data) ?></h3>
                            </a>
                            <p>Both MIS & GIS</p>
                          </div>
                        </div>
                      </div>
                      <div class="col-xs-12 col-3">
                        <div class="small-box bg-warning" style="color: #fff !important">
                          <div class="inner">
                            <a href="<?php echo DOMAIN . 'projects.php?type=data_avail&method=mis'; ?>" style="color: #fff;">
                              <h3><?php  echo pg_num_rows($mis_data) ?></h3>
                            </a>
                            <p>Only MIS Data</p>
                          </div>
                          <!-- <a href="#" class="small-box-footer" style="color:#fff !important">More Details <i class="fas fa-arrow-circle-right"></i></a> -->
                        </div>
                      </div>
                      <div class="col-xs-12 col-3">
                        <div class="small-box bg-danger">
                          <div class="inner">
                            <a href="<?php echo DOMAIN . 'projects.php?type=data_avail&method=no_data'; ?>" style="color: #fff;">
                              <h3><?php  echo pg_num_rows($no_data) ?></h3>
                            </a>
                            <p>No Data</p>
                          </div>
                          <!-- <a href="#" class="small-box-footer">More Detaials <i class="fas fa-arrow-circle-right"></i></a> -->
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-12 col-3">
                        <div style="padding-top: 35px;">
                          <h6>Data Updation</h6> 
                        </div>
                      </div>
                      <div class="col-xs-12 col-3">
                        <div class="small-box bg-lesser">
                          <div class="inner">
                            <a href="<?php echo DOMAIN . 'projects.php?type=data_update&method=less1'; ?>" style="color: #fff;">
                              <h3><?php  echo pg_num_rows($less1) ?></h3>
                            </a>
                            <p> <1 Month</p>
                          </div>
                          <!-- <a href="#" class="small-box-footer">More Detaials <i class="fas fa-arrow-circle-right"></i></a> -->
                        </div>
                      </div>
                      <div class="col-xs-12 col-3">
                        <div class="small-box bg-onetothree">
                          <div class="inner">
                            <a href="<?php echo DOMAIN . 'projects.php?type=data_update&method=oneto3'; ?>" style="color: #fff;">
                              <h3><?php  echo pg_num_rows($oneto3) ?></h3>
                            </a>
                            <p>1-3 Months</p>
                          </div>
                          <!-- <a href="#" class="small-box-footer" style="color:#fff !important">More Details <i class="fas fa-arrow-circle-right"></i></a> -->
                        </div>
                      </div>
                      <div class="col-xs-12 col-3">
                        <div class="small-box bg-greater">
                          <div class="inner">
                            <a href="<?php echo DOMAIN . 'projects.php?type=data_update&method=less3'; ?>" style="color: #fff;">
                              <h3><?php  echo pg_num_rows($less3) ?></h3>
                            </a>
                            <p>>3 Months</p>
                          </div>
                          <!-- <a href="#" class="small-box-footer">More Details <i class="fas fa-arrow-circle-right"></i></a> -->
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-12 col-3">
                        <div style="padding-top: 35px;">
                          <h6>Time Overrun</h6> 
                        </div>
                      </div>
                      <div class="col-xs-12 col-3">
                        <div class="small-box bg-completed">
                          <div class="inner">
                            <a href="<?php echo DOMAIN . 'projects.php?type=time_overrun&method=completed'; ?>" style="color: #fff;">
                              <h3><?php  echo pg_num_rows($completed_data) ?></h3>
                            </a>
                            <p>Completed</p>
                          </div>
                          <!-- <a href="#" class="small-box-footer">More Detaials <i class="fas fa-arrow-circle-right"></i></a> -->
                        </div>
                      </div>
                      <div class="col-xs-12 col-3">
                        <div class="small-box bg-inprogress" style="color: #fff !important">
                          <div class="inner">
                            <a href="<?php echo DOMAIN . 'projects.php?type=time_overrun&method=in_progress'; ?>" style="color: #fff;">
                              <h3><?php  echo pg_num_rows($inprogress_data) ?></h3>
                            </a>
                            <p>In-progress</p>
                          </div>
                          <!-- <a href="#" class="small-box-footer" style="color:#fff !important">More Details <i class="fas fa-arrow-circle-right"></i></a> -->
                        </div>
                      </div>
                      <div class="col-xs-12 col-3">
                        <div class="small-box bg-overdue">
                          <div class="inner">
                            <a href="<?php echo DOMAIN . 'projects.php?type=time_overrun&method=delay'; ?>" style="color: #fff;">
                              <h3><?php  echo pg_num_rows($overdue_data) ?></h3>
                            </a>
                            <p>Delayed</p>
                          </div>
                          <!-- <a href="#" class="small-box-footer">More Details <i class="fas fa-arrow-circle-right"></i></a> -->
                        </div>
                      </div>
                    </div>  
                </div>
              </div>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col-md-6 -->
          <div class="col-lg-6">
            <div class="card">
              <div class="card-body">
                <div class="position-relative mb-4" style="padding-bottom: 25px;">
                  <h3 class="card-title" style="padding-bottom: 25px;">Data Availability</h3>
                  <div id="chart1">
                  </div>
                </div>
              </div>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
        <div class="row">
          <div class="col-lg-6">
            <div class="card">
              <div class="card-body">
                <div class="position-relative mb-4">
                  <h3 class="card-title">Data Updation</h3>
                  <div id="chart2">
                  </div>
                </div>
              </div>
            </div>
            <!-- /.card -->
          </div>
          <div class="col-lg-6">
            <div class="card">
              <div class="card-body">
                <div class="position-relative mb-4">
                  <h3 class="card-title">Time Overrun</h3>
                  <div id="chart3">
                  </div>
                </div>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
        <!-- Map -->
        <div class="row">
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header border-0">
                <h3 class="card-title">Causes Of Delay</h3>
                <!-- <div class="card-tools">
                  <a href="#" class="btn btn-tool btn-sm">
                    <i class="fas fa-download"></i>
                  </a>
                </div> -->
              </div>
              <div class="card-body table-responsive p-0">
                <table class="table table-striped table-valign-middle" id="example1">
                  <thead>
                  <tr>
                    <th style="transform: rotate(-45deg);font-size: smaller;">Department</th>
                    <th style="transform: rotate(-45deg);font-size: smaller;">Land Acquisition</th>
                    <th style="transform: rotate(-45deg);font-size: smaller;">Government Clearance</th>
                    <th style="transform: rotate(-45deg);font-size: smaller;">Court Cases</th>
                    <th style="transform: rotate(-45deg);font-size: smaller;">No LA Unit</th>
                    <th style="transform: rotate(-45deg);font-size: smaller;">Contractor Termination</th>
                    <th style="transform: rotate(-45deg);font-size: smaller;">Other</th>
                    <th style="transform: rotate(-45deg);font-size: smaller;">Slow Work</th>
                    <th style="transform: rotate(-45deg);font-size: smaller;">Techinical Reason</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                      $i=0;
                      foreach($department_code as $depts_code){
                        $delay_sql = "SELECT mst_causes_of_delay.delay_desc,sp_index_v2.dept_code,(SELECT COUNT(*) FROM sp_index_v2 WHERE sp_index_v2.causes_of_delay = mst_causes_of_delay.delay_desc::text and sp_index_v2.dept_code='$depts_code') AS TOT FROM mst_causes_of_delay,sp_index_v2 where sp_index_v2.dept_code='$depts_code' group by sp_index_v2.dept_code,mst_causes_of_delay.delay_desc order by mst_causes_of_delay.delay_desc asc;";
                        $delay_result = pg_query(DBCON,$delay_sql);
                        $dept = $depts[$i];
                        echo '<tr>';
                        echo '<td>'.$dept.'</td>';
                        while ($rs = pg_fetch_array($delay_result)){
                          echo '<td>'.$rs['tot'].'</td>';
                        }
                        echo '</tr>';
                        $i++;
                      }
                    ?>
                    
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header border-0">
                  <h3 class="card-title">
                    GIS
                  </h3>
                  <div class="card-tools">
                  <a href="gis_map.php" class="btn btn-tool btn-sm">
                    <i class="fas fa-expand"></i>
                  </a>
                </div>
              </div>
              <div class="card-body">
                <!-- <div id="world-map" style="height: 250px; width: 100%;"></div> -->
                <div id="map" style="height: 71vh; width: 100%;"></div>
              </div>
              <!-- /.card-body-->
            </div>
          </div>
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
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.15/lodash.min.js"></script> -->
<!-- map js -->
<!-- <script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.4.3/build/ol.js"></script> -->
<script src="js/ol6.js"></script>
<script src="js/ol-popup.js"></script>
<script src="js/olExt.js"></script>
<script type="text/javascript">
      const departments = [<?php echo implode(', ', $departments); ?>];
      console.log(<?php echo implode(', ', $dept_code); ?>);
      const department_code = [<?php echo implode(', ', $dept_code); ?>];
      var no_project_data = [<?php echo implode(', ', $no_project_data); ?>];
      var only_mis_data = [<?php echo implode(', ', $only_mis_data); ?>];
      var both_mis_gis_data = [<?php echo implode(', ', $both_mis_gis_data); ?>];
      console.log(departments);
      var options = {
        series: [
          {
            name: 'Both MIS & GIS Data',
            data: both_mis_gis_data
          },{
            name: 'Only MIS Data',
            data: only_mis_data
          },{
            name: 'No Data',
            data: no_project_data
          } 
        ],
        colors : ['#28a745', '#ffc107','#dc3545'],
        chart: {
          type: 'bar',
          height: 350,
          stacked: true,
          toolbar: {
            show: true,
            tools: {
              download: '<i class="fas fa-download"></i>',
            },
            
          },
          zoom: {
            enabled: true
          },
          events :{
            // mounted: (chartContext, config) => {
            //   console.log("mounted", chartContext, config, config.globals.yRange);
            //   setTimeout(() => {
            //     addAnnotations(config);
            //   });
            // },
            // updated: (chartContext, config) => {
            //   setTimeout(() => {
            //     addAnnotations(config);
            //   });
            // },
            dataPointSelection(event, chartContext,config) {
              console.log(chartContext, config);
               var chart_table1 = (config.w.config.xaxis.categories[config.dataPointIndex]);
              // alert(config.w.config.series[config.seriesIndex].name);
              // alert(config.w.config.series[config.seriesIndex].data[config.dataPointIndex]);
              let method = config.w.config.series[config.seriesIndex].name;
              if(method == "No Data"){
                method = "&method=no_data";
              }else if(method == "Only MIS Data"){
                method = "&method=mis";
              }else if(method == "Both MIS & GIS Data"){
                method = "&method=mis_gis";
              }else{
                method = "";
              }
              let dept = config.dataPointIndex;
              let dept_code = department_code[dept];
              // console.log(dept_code);
              location.href = "projects.php?type=data_avail"+method+"#tab_"+dept_code+"";
            },
            dataPointMouseEnter: function(event) {
              event.path[0].style.cursor = "pointer";
            }
          }
        },
        dataLabels: {
          // enabled: true,
          // offsetY: -20,
          // style: {
          //   fontSize: '12px',
          //   colors: ["#304758"]
          // },
          // formatter: function(value, { seriesIndex, dataPointIndex, w}) {
          //   let indices = w.config.series.map((item, i) => i);
          //   indices = indices.filter(i => !w.globals.collapsedSeriesIndices.includes(i) && _.get(w.config.series, `${i}.data.${dataPointIndex}`) > 0);
          //   if (seriesIndex == _.max(indices))
          //     return w.globals.stackedSeriesTotals[dataPointIndex];
          //   return '';
          // }
        },
        responsive: [{
          breakpoint: 480,
          options: {
            legend: {
              position: 'bottom',
              offsetX: -10,
              offsetY: 0
            }
          }
        }],
        plotOptions: {
          bar: {
            borderRadius: 8,
            horizontal: true,
          },
        },
        xaxis: {
          categories: departments,
        },
        legend: {
          position: 'top',
          offsetY: 10
        },
        fill: {
          opacity: 1
        }
      };
      // const addAnnotations = (config) => {
      //   var seriesTotals = config.globals.stackedSeriesTotals;
      //   var isHorizontal = options.plotOptions.bar.horizontal;
      //   chart1.clearAnnotations();
      //   try {
      //     departments.forEach((category, index) => {
      //       chart1.addPointAnnotation(
      //         {
      //           y: isHorizontal
      //             ? calcHorizontalY(config, index)
      //             : seriesTotals[index],
      //           x: isHorizontal ? 0 : category,
      //           label: {
      //             text: `${seriesTotals[index]}`
      //           }
      //         },
      //         false
      //       );

      //       if (isHorizontal) {
      //         adjustPointAnnotationXCoord(config, index);
      //       }
      //     });
      //   } catch (error) {
      //     console.log(`Add point annotation error: ${error.message}`);
      //   }
      // };
      // const calcHorizontalY = (config, index) => {
      //   var catLength = departments.length;
      //   var yRange = config.globals.yRange[0];
      //   var minY = config.globals.minY;
      //   var halfBarHeight = yRange / catLength / 2;
      //   return minY + halfBarHeight + 2 * halfBarHeight * (catLength - 1 - index)-6;
      // };

      // const adjustPointAnnotationXCoord = (config, index) => {
      //   var gridWidth = config.globals.gridWidth;
      //   var seriesTotal = config.globals.stackedSeriesTotals[index];
      //   var minY = config.globals.minY;
      //   var yRange = config.globals.yRange[0];
      //   var xOffset = (gridWidth * (seriesTotal + Math.abs(minY))) / yRange;
      //   var circle = document.querySelector(
      //     `.apexcharts-point-annotations circle:nth-of-type(${index + 1})`
      //   );
      //   var labelField = document.querySelector(
      //     `.apexcharts-point-annotations rect:nth-of-type(${index + 1}`
      //   );
      //   var labelFieldXCoord = parseFloat(labelField.getAttribute("x"));
      //   var text = document.querySelector(
      //     `.apexcharts-point-annotations text:nth-of-type(${index + 1}`
      //   );

      //   labelField.setAttribute("x", labelFieldXCoord + xOffset+20);
      //   text.setAttribute("x", xOffset+20);
      //   // console.log(xOffset);
      //   // console.log(labelFieldXCoord);
      //   circle.setAttribute("cx", xOffset+10000);
      // };
      var chart1 = new ApexCharts(document.querySelector("#chart1"), options);
      chart1.render();

      // Updation chart
      var less1_data = [<?php echo implode(', ', $less1_data); ?>];
      var oneto3_data = [<?php echo implode(', ', $oneto3_data); ?>];
      var less3_data = [<?php echo implode(', ', $less3_data); ?>];
      
      var options = {
        series: [
          {
            name: '<1 Month',
            data: less1_data
          },{
            name: '1-3 Months',
            data: oneto3_data
          },{
            name: '>3 Months',
            data: less3_data
          } 
        ],
        colors : ['#adc178', '#a98467','#6c584c'],
        chart: {
          type: 'bar',
          height: 350,
          stacked: true,
          toolbar: {
            show: true,
            tools: {
              download: '<i class="fas fa-download"></i>',
            },
          },
          zoom: {
            enabled: true
          },
          events :{
            dataPointSelection(event, chartContext,config) {
              // console.log(chartContext, config);
              var chart_table2 = (config.w.config.xaxis.categories[config.dataPointIndex]);
              let method = config.w.config.series[config.seriesIndex].name;
              if(method == "<1 Month"){
                method = "&method=less1";
              }else if(method == "1-3 Months"){
                method = "&method=oneto3";
              }else if(method == ">3 Months"){
                method = "&method=less3";
              }else{
                method = "";
              }
              let dept = config.dataPointIndex;
              let dept_code = department_code[dept];
              location.href = "projects.php?type=data_update"+method+"#tab_"+dept_code+"";
            },
            dataPointMouseEnter: function(event) {
              event.path[0].style.cursor = "pointer";
            }
          }
        },
        responsive: [{
          breakpoint: 480,
          options: {
            legend: {
              position: 'bottom',
              offsetX: -10,
              offsetY: 0
            }
          }
        }],
        plotOptions: {
          bar: {
            borderRadius: 8,
            horizontal: true,
          },
        },
        xaxis: {
          categories: departments,
        },
        legend: {
          position: 'top',
          offsetY: 20
        },
        fill: {
          opacity: 1
        }
      };
      
      var chart2 = new ApexCharts(document.querySelector("#chart2"), options);
      chart2.render();

      // Data Overrun status
      var overdue_department_data = [<?php echo implode(', ', $overdue_department_data); ?>];
      var inprogress_department_data = [<?php echo implode(', ', $inprogress_department_data); ?>];
      var completed_department_data = [<?php echo implode(', ', $completed_department_data); ?>];
      
      var options = {
        series: [
          {
            name: 'Completed',
            data: completed_department_data
          },{
            name: 'In-Progress',
            data: inprogress_department_data
          },{
            name: 'Delayed',
            data: overdue_department_data
          }
        ],
        colors : ['#3a86ff', '#8338ec','#ff006e'],
        chart: {
          type: 'bar',
          height: 350,
          stacked: true,
          toolbar: {
            show: true,
            tools: {
              download: '<i class="fas fa-download"></i>',
            },
          },
          zoom: {
            enabled: true
          },
          events :{
            dataPointSelection(event, chartContext,config) {
              // console.log(chartContext, config);
              var chart_table3 = (config.w.config.xaxis.categories[config.dataPointIndex]);
              let method = config.w.config.series[config.seriesIndex].name;
              if(method == "Completed"){
                method = "&method=completed";
              }else if(method == "In-Progress"){
                method = "&method=in_progress";
              }else if(method == "Delayed"){
                method = "&method=delay";
              }else{
                method = "";
              }
              let dept = config.dataPointIndex;
              let dept_code = department_code[dept];
              location.href = "projects.php?type=time_overrun"+method+"#tab_"+dept_code+"";
            },
            dataPointMouseEnter: function(event) {
              event.path[0].style.cursor = "pointer";
            }
          }
        },
        responsive: [{
          breakpoint: 480,
          options: {
            legend: {
              position: 'bottom',
              offsetX: -10,
              offsetY: 0
            }
          }
        }],
        plotOptions: {
          bar: {
            borderRadius: 8,
            horizontal: true,
          },
        },
        xaxis: {
          categories: departments,
        },
        legend: {
          position: 'top',
          offsetY: 20
        },
        fill: {
          opacity: 1
        }
      };
      var chart3 = new ApexCharts(document.querySelector("#chart3"), options);
      chart3.render();


  // map script

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
    collapsed: true
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

 var pro_layer = '<?php  $birdView = pg_query(DBCON, "SELECT STRING_AGG(layers, ',') AS layer
FROM sp_index_v2 where layers is not null and layers !=''");

while($row = pg_fetch_assoc($birdView)) {
    $bv_layers = $row['layer'];
}
echo $bv_layers;
       ?>'

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
