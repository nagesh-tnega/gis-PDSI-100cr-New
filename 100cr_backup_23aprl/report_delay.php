<?php 
  require_once('php/dbHandler.php');
  include('php/session.php');
  

$depts = array();
$department_code = array();
$sql4 = "SELECT * FROM departments order by short_name asc";
$all_dept = pg_query(DBCON, $sql4);
if(pg_num_rows($all_dept)>0){
  $raw_data = pg_fetch_all($all_dept);
  for($i = 0;$i<count($raw_data);$i++){
    $dept_code = $raw_data[$i]["dept_code"];
    $dept_name = $raw_data[$i]["short_name"];
    array_push($depts,$dept_name);
    array_push($department_code,$dept_code);
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
            <a href="report_delay.php" class="nav-link active">
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
                  
<div class="container">
    <br />
    <div class="row" style="background-color:#72A0C1;padding:7px; ">
        <div class="col-sm-8">
            <h5>Reports - Causes Of Delay</h5>
        </div>
        <div class="col-sm-4">
             <!--<a style="float:right;color:#000;" href="../php/function.php?case=downloadProjectReport"><i class="fa fa-file-excel-o"></i> Download</a>-->
        </div>
    </div>
    
    <br />
    <div class="row">

<table class="table table-striped table-valign-middle" id="example1">
                  <thead>
                  <tr>
                    <th >Department</th>
                    <th >Land Acquisition</th>
                    <th >Government Clearance</th>
                    <th >Court Cases</th>
                    <th >No LA Unit</th>
                    <th >Contractor Termination</th>
                    <th >Other</th>
                    <th >Slow Work</th>
                    <th >Techinical Reason</th>
                    <th>Total Delayed Projects</th>
                    <th>Total On-Time Projects</th>
                    <th>Total Number of Projects</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                      $i=0;
                      foreach($department_code as $depts_code){
                        $delay_sql = "SELECT mst_causes_of_delay.delay_desc,sp_index_v2.dept_code,(SELECT COUNT(*) FROM sp_index_v2 WHERE sp_index_v2.causes_of_delay = mst_causes_of_delay.delay_desc::text and sp_index_v2.dept_code='$depts_code') AS TOT FROM mst_causes_of_delay,sp_index_v2 where sp_index_v2.dept_code='$depts_code' group by sp_index_v2.dept_code,mst_causes_of_delay.delay_desc order by mst_causes_of_delay.delay_desc asc;";
                        $td_last ="SELECT count(*) from sp_index_v2 where dept_code='$depts_code'";
                        $td_last1 = "SELECT count(*)  from sp_index_v2 where dept_code='$depts_code' and created_time is not null";
                        $td_last2 = "SELECT count(*) from sp_index_v2 where causes_of_delay is not null and causes_of_delay != 'null' and causes_of_delay !='' and dept_code='$depts_code'";

                        $delay_result = pg_query(DBCON,$delay_sql);
                        $td1_result = pg_query(DBCON,$td_last);
                        $td2_result = pg_query(DBCON,$td_last1);
                        $td3_result = pg_query(DBCON,$td_last2);

                        $dept = $depts[$i];
                        echo '<tr>';
                        echo '<td>'.$dept.'</td>';
                        while ($rs = pg_fetch_array($delay_result)){
                          echo '<td>'.$rs['tot'].'</td>';
                        }
                        while ($rs = pg_fetch_array($td3_result)){
                          echo '<td>'.$rs['count'].'</td>';
                        }
                         while ($rs = pg_fetch_array($td2_result)){
                          echo '<td>'.$rs['count'].'</td>';
                        }
                        
                       while ($rs = pg_fetch_array($td1_result)){
                          echo '<td>'.$rs['count'].'</td>';
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
<!-- map js -->
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
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,"searching": false, "paging": false,
      "buttons": [
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [0,1,2,3,4,5,6,7,8,9,10,11]
                }
            },
            "csv",
            {
              extend: 'excelHtml5',
              autoFilter: true,
              sheetName: 'All Projects List',
              exportOptions: {
                 columns: [0,1,2,3,4,5,6,7,8,9,10,11]
              }
            }, 
            {
              extend: 'pdfHtml5'
            }, 
            {
              extend: 'print',
              exportOptions: {
                 columns: [0,1,2,3,4,5,6,7,8,9,10,11]
              }
            }
            
      ]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  });
  </script>
</body>
</html>
