<?php 
  require_once('php/dbHandler.php');
  include('php/session.php');
   require_once('api/mstDepartment.php');
    $getDeptList = mstDepartment::getDepartmentList(DBCON);
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
<style>
  .dt-buttons{
      margin-left: 92%;

  }
</style>

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
            <a href="report_details.php" class="nav-link active">
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
                  
<div class="row">

<div class="table-responsive">
  
    <table id="tblReport" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
             <tr>
                <th class="th-sm">Slno</th>
                <th class="th-sm">Department Name</th>
                <th class="th-sm">Implementing Agency</th>
                <th class="th-sm">Name of the Project</th>
                <th class="th-sm">Last updated time</th>
                <th class="th-sm">Funding Agency</th>
                <th class="th-sm">Project Start Date</th>
                <th class="th-sm">Project End Date</th>
                <th class="th-sm">Revised Project Start Date</th>
                <th class="th-sm">Revised Project End Date</th>
                <th class="th-sm">Project Cost</th>
                <th class="th-sm">Present Status</th>
                <th class="th-sm">Causes of Delay</th>
                <th class="th-sm">Time Overrun in Days</th>
                <th class="th-sm">Cost Over Run in Crores</th>
                <th class="th-sm">Reasons for Cost Over Run</th>
            </tr>
        </thead>
        <tbody>
           
           
           
           
            
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
<!-- print js -->
<script type="text/javascript" src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>

<script>
      $(document).ready(function() {

        $.ajax({
          url: 'php/function.php',
          type: 'POST',
          data: 'case=getAllProjectDetailsForReport',
          success: function (response) {
                        $("#tblReport tbody").empty();
                        var res = JSON.parse(response);
                        var content = "";
                        var slno =1;
                         var time_overrun = "";
                        function getDuration(milli){
                          let minutes = Math.floor(milli / 60000);
                          let hours = Math.round(minutes / 60);
                          let days = Math.round(hours / 24);

                          return (
                            (days && {value: days, unit: 'days'}) ||
                            (hours && {value: hours, unit: 'hours'}) ||
                            {value: minutes, unit: 'minutes'}
                            )
                      };
                        if(res.length != 0){
                            for(i=0;i<res.length;i++){

                                if(res[i].project_start_date == null){
                                    project_start_date = "-";
                                }else{
                                    project_start_date = res[i].project_start_date;
                                }

                                if(res[i].project_end_date == null){
                                    project_end_date = "-";
                                }else{
                                    project_end_date = res[i].project_end_date;
                                }

                                if(res[i].revised_start_date == null){
                                    revised_start_date = "-";
                                }else{
                                    revised_start_date = res[i].revised_start_date;
                                }

                                if(res[i].revised_end_date == null){
                                    revised_end_date = "-";
                                }else{
                                    revised_end_date = res[i].revised_end_date;
                                }

                                if(res[i].present_status == null){
                                    present_status = "-";
                                }else{
                                    present_status = res[i].present_status;
                                }

                                if(res[i].delay_desc == null){
                                    delay_desc = "-";
                                }else{
                                    delay_desc = res[i].delay_desc;
                                }
                                
                                 if(res[i].cost_overrun_reasons == null){
                                    cost_overrun_reasons = "-";
                                }else{
                                    cost_overrun_reasons = res[i].cost_overrun_reasons;
                                }

                                if(res[i].cost_overrun == null){
                                    cost_overrun = "-";
                                }else{
                                    cost_overrun = res[i].cost_overrun;
                                }

                                if(res[i].updated_time == null){
                                    updated_time = "-";
                                }else{
                                    updated_time = res[i].updated_time;
                                }

                                if(res[i].project_end_date == null || res[i].present_status == null ){
                                    time_overrun = "-"
                                } else if(res[i].project_end_date){
                                    if(!((res[i].present_status).toLowerCase() === "completed")){
                                        var endDate = new Date(res[i].project_end_date);
                                        var todayDate = new Date();
                                        var timeOverRun = 0;
                                        if(endDate < todayDate){


                                         timeOverRun = getDuration(todayDate - endDate);

                                        }
                                        if(!(timeOverRun.value == undefined)){
                                            time_overrun = timeOverRun.value;
                                        }else{
                                            time_overrun = "-"
                                        }
                                        
                                    }
                                }



                                 content += '<tr><td>'+ slno +'</td><td>'
                                        + res[i].department_name +'</td><td>'
                                        + res[i].implementing_agency +'</td><td>'
                                        + res[i].name_of_the_project +'</td><td>'
                                        + res[i].updated_time +'</td><td>'
                                        + res[i].funding_agency +'</td><td>'
                                        + project_start_date +'</td><td>'
                                        + project_end_date +'</td><td>'
                                        + revised_start_date +'</td><td>'
                                        + revised_end_date +'</td><td>'
                                        + res[i].project_cost +'</td><td>'
                                        + present_status +'</td><td>'
                                        + delay_desc +'</td><td>'
                                        + time_overrun +'</td><td>'
                                        + cost_overrun +'</td><td>'
                                        + cost_overrun_reasons   +'</td></tr>';
                                slno++;
                            }
                            $("#tblReport tbody").append(content);
                        }else{

                        }
            
                         $('#tblReport').dataTable({

                            scrollY:        "600px",
                            scrollX:        true,
                            scrollCollapse: false,
                            paging:         true,
                            dom: 'Bfrtip',
                            buttons: [
                                {
                                    extend: 'excel',
                                    text: '<i class="fa fa-file-excel-o"></i> <em>D</em>ownload',
                                    title: 'Project Details'
                                    
                                }
                            ]

                         });
   
            
            //$('#info_div').html(response);
            
          }
        });

               
 
    //new $.fn.dataTable.FixedHeader( table );
} );

    </script>
</body>
</html>
