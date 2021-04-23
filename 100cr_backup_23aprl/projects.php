<?php 
  require_once('php/dbHandler.php');
  include('php/session.php');
  $type = false;
  $vist = 0;
  $method = false;
  if(strpos($_SERVER['REQUEST_URI'], "type") !== false){
    $type = $_GET['type'];
    $visit = 1;
    if(strpos($_SERVER['REQUEST_URI'], "method") !== false){
      $method = $_GET['method'];
    }
  }
  // echo $type.'-'.$method;die();
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
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <style type="text/css">
    .css-serial {
      counter-reset: serial-number;  /* Set the serial number counter to 0 */
      }
      
      .css-serial td:first-child:before {
      counter-increment: serial-number;  /* Increment the serial number counter */
      content: counter(serial-number);  /* Display the counter */
    }
    .bg-overdue{
      background-color: #ff006e !important;
    }
    .bg-overdue,
    .bg-overdue > a {
      color: #fff !important;
    }
    .bg-inprogress{
      background-color: #8338ec !important;
    }
    .bg-inprogress,
    .bg-inprogress > a {
      color: #fff !important;
    }
    .bg-completed{
      background-color: #3a86ff !important;
    }
    .bg-completed,
    .bg-completed > a {
      color: #fff !important;
    }
    .bg-greater{
      background-color: #6c584c !important;
    }
    .bg-greater,
    .bg-greater > a {
      color: #fff !important;
    }
    .bg-onetothree{
      background-color: #a98467 !important;
    }
    .bg-onetothree,
    .bg-onetothree > a {
      color: #fff !important;
    }
    .bg-lesser{
      background-color: #adc178 !important;
    }
    .bg-lesser,
    .bg-lesser > a {
      color: #fff !important;
    }
    .acc:after {
      content: '\2796'; /* Unicode character for "plus" sign (+) */
      font-size: 13px;
      color: #fff;
      float: left;
      margin-left: 5px;
    }
    .collapsed:after {
      content: "\02795"; /* Unicode character for "minus" sign (-) */
    }
    .vl:after {
      content:"";
      position: absolute;
      /*z-index: -1;*/
      top: 0;
      bottom: 0;
      left: 100%;
      border-left: 2px dotted #ff0000;
      transform: translate(-50%);
    }
  </style>
</head>
<body class="hold-transition sidebar-mini sidebar-collapse layout-fixed">
<div class="wrapper">
  
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
     <a href="index.php" class="brand-link">
      <!-- <img src="images/logo2.png" alt="Major Infrastructure" class="brand-image img-circle elevation-3" style="opacity: .8"> -->
      <!-- <span class="brand-text font-weight-light"></span> -->

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
            <a href="projects.php" class="nav-link active">
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
              <h4 href="#"> <img src="<?php echo DOMAIN . 'images/logo.png'; ?>" width="70" height="70" class="d-inline-block align-top" alt=""> WebGIS for Monitoring the Major Infrastructure Projects of Tamil Nadu<img src="<?php echo DOMAIN . 'images/logo2.png'; ?>" width="70" height="70" class="" alt="">
              </h4>
            </div>
          </div><!-- /.col -->
        </div><!-- /.row -->
        <!-- <div class="row">
          <div class="col-sm-6"></div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">MIS</li>
            </ol>
          </div>
        </div> -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        
        <!-- /.row -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Department-wise Project List:</h3>
                <div class="card-tools">
                  <!-- <a style="float:right;color:#000;cursor: pointer;" id="downloadAbstractReport"><i class="fas fa-download"></i></a> -->
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group vl">
                      <div class="row">
                        <div class="col-md-2">
                          <div class="form-check">
                            <label class="form-check-label">Coloring:</label>
                          </div>
                        </div>
                        <div class="col-md-1" style="padding-left: inherit;">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="list_type" value="all" onclick="handleClick('all');" <?php if($type == "all") echo "checked"; ?> >
                            <label class="form-check-label">None</label>
                          </div>
                        </div>
                        <div class="col-md-3" style="padding-left: 12px;">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="list_type" value="data_avail" onclick="handleClick('data_avail');" <?php if($type == "data_avail") echo "checked"; ?>>
                            <label class="form-check-label">Data Availability</label>
                          </div>
                        </div>
                        <div class="col-md-3" style="margin-left: inherit;">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="list_type" value="data_update" onclick="handleClick('data_update');" <?php if($type == "data_update") echo "checked"; ?>>
                            <label class="form-check-label">Data Updation</label>
                          </div>
                        </div>
                        <div class="col-md-3" style="margin-right: inherit;">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="list_type" value="time_overrun" onclick="handleClick('time_overrun');" <?php if($type == "time_overrun") echo "checked"; ?>>
                            <label class="form-check-label">Time Overrun</label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6"> 
                    <div class="form-group">
                      <div class="row" id="data_type_1" style="display:none;">
                        <div class="col-md-2">
                          <div class="form-check">
                            <label class="form-check-label">Show:</label>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="data_type_1_list" value="all_data" checked>
                            <label class="form-check-label">All</label>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-check">
                            
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-check">
                            
                          </div>
                        </div>
                      </div>
                      <div class="row" id="data_type_2" style="display:none;">
                        <div class="col-md-2">
                          <div class="form-check">
                            <label class="form-check-label">Show:</label>
                          </div>
                        </div>
                        <div class="col-md-1">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="data_type_2_list" value="all_data" onclick="getData();">
                            <label class="form-check-label">All</label>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="data_type_2_list" value="mis_gis" onclick="getData();" <?php if($method == "mis_gis") echo "checked"; ?>>
                            <label class="form-check-label bg-success">Both MIS & GIS</label>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="data_type_2_list" value="mis" onclick="getData();" <?php if($method == "mis") echo "checked"; ?>>
                            <label class="form-check-label bg-warning">Only MIS Data</label>
                          </div>
                        </div>
                        <div class="col-md-2">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="data_type_2_list" value="no_data" onclick="getData();" <?php if($method == "no_data") echo "checked"; ?>>
                            <label class="form-check-label bg-danger">No Data</label>
                          </div>
                        </div>
                        <div class="col-md-1"></div>
                      </div>
                      <div class="row" id="data_type_3" style="display:none;">
                        <div class="col-md-2">
                          <div class="form-check">
                            <label class="form-check-label">Show:</label>
                          </div>
                        </div>
                        <div class="col-md-1">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="data_type_3_list" value="all_data" onclick="getData();">
                            <label class="form-check-label">All</label>
                          </div>
                        </div>
                        <div class="col-md-2">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="data_type_3_list" value="completed" onclick="getData();" <?php if($method == "completed") echo "checked"; ?>>
                            <label class="form-check-label bg-completed">Completed</label>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="data_type_3_list" value="in_progress" onclick="getData();" <?php if($method == "in_progress") echo "checked"; ?>>
                            <label class="form-check-label bg-inprogress">In-Progress</label>
                          </div>
                        </div>
                        <div class="col-md-2">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="data_type_3_list" value="delay" onclick="getData();" <?php if($method == "delay") echo "checked"; ?>>
                            <label class="form-check-label bg-overdue">Delayed</label>
                          </div>
                        </div>
                        <div class="col-md-2"></div>
                      </div>
                      <div class="row" id="data_type_4" style="display:none;">
                        <div class="col-md-2">
                          <div class="form-check">
                            <label class="form-check-label">Show:</label>
                          </div>
                        </div>
                        <div class="col-md-1">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="data_type_4_list" value="all_data" onclick="getData();">
                            <label class="form-check-label">All</label>
                          </div>
                        </div>
                        <div class="col-md-2">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="data_type_4_list" value="less1" onclick="getData();" <?php if($method == "less1") echo "checked"; ?>>
                            <label class="form-check-label bg-lesser">&lt;1 Month</label>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="data_type_4_list" value="oneto3" onclick="getData();" <?php if($method == "oneto3") echo "checked"; ?>>
                            <label class="form-check-label bg-onetothree">1-3 Months</label>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="data_type_4_list" value="less3" onclick="getData();" <?php if($method == "less3") echo "checked"; ?>>
                            <label class="form-check-label bg-greater">&gt;3 Months</label>
                          </div>
                        </div>
                        <div class="col-md-1"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
                <!-- we are adding the accordion ID so Bootstrap's collapse plugin detects it -->
                <div id="accordion" role="tablist" aria-multiselectable="true">
              
                </div>
                <div class="row" id="abstractReportContent"></div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
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

<!-- PDF -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.min.js"></script>

<script type="text/javascript">
  window.onload = checkChecked;
  function checkChecked(){
    const rbs = document.querySelectorAll('input[name="list_type"]');
    let selectedValue;
    let count = 0;
    for (const rb of rbs) {
      if (rb.checked) {
        count = 1;
        break;
      }
    }
    if(count == 0){
      $("input[name=list_type][value='all']").prop("checked",true);
    }
    for (const rb of rbs) {
      if (rb.checked) {
        selectedValue = rb.value;
        break;
      }
    }
    handleClick(selectedValue);
    // getData();
  }
  function handleClick(val){
    if(val == 'all'){
      $('#data_type_2').hide();
      $('#data_type_3').hide();
      $('#data_type_4').hide();
      $('#data_type_1').show();
      let rbs = document.querySelectorAll('input[name="data_type_1_list"]');
      let selectedValue;
      let count = 0;
      for (let rb of rbs) {
        if (rb.checked) {
          count = 1;
          break;
        }
      }
      if(count == 0){
        $("input[name=data_type_1_list][value='all_data']").attr('checked', true);
      }
      getData();
    }else if(val == 'data_avail'){
      $('#data_type_1').hide();
      $('#data_type_3').hide();
      $('#data_type_4').hide();
      $('#data_type_2').show();
      let rbs = document.querySelectorAll('input[name="data_type_2_list"]');
      let selectedValue;
      let count = 0;
      for (let rb of rbs) {
        if (rb.checked) {
          count = 1;
          break;
        }
      }
      if(count == 0){
        $("input[name=data_type_2_list][value='all_data']").attr('checked', true);
      }
      getData();
    }else if(val == 'time_overrun'){
      $('#data_type_1').hide();
      $('#data_type_2').hide();
      $('#data_type_4').hide();
      $('#data_type_3').show();
      let rbs = document.querySelectorAll('input[name="data_type_3_list"]');
      let selectedValue;
      let count = 0;
      for (let rb of rbs) {
        if (rb.checked) {
          count = 1;
          break;
        }
      }
      if(count == 0){
        $("input[name=data_type_3_list][value='all_data']").attr('checked', true);
      }
      getData();
    }else if(val == 'data_update'){
      $('#data_type_1').hide();
      $('#data_type_2').hide();
      $('#data_type_3').hide();
      $('#data_type_4').show();
      let rbs = document.querySelectorAll('input[name="data_type_4_list"]');
      let selectedValue;
      let count = 0;
      for (let rb of rbs) {
        if (rb.checked) {
          count = 1;
          break;
        }
      }
      if(count == 0){
        $("input[name=data_type_4_list][value='all_data']").attr('checked', true);
      }
      getData();
    }
  }
  function getData() {
    $('#accordion').empty();
    let list_type = $('input[name="list_type"]:checked').val();
    if(list_type == 'all'){
      data_type_list = $("input[name='data_type_1_list']:checked").val();
    }else if(list_type == 'data_avail'){
      data_type_list = $("input[name='data_type_2_list']:checked").val();
    }else if(list_type == 'time_overrun'){
      data_type_list = $("input[name='data_type_3_list']:checked").val();
    }else if(list_type == 'data_update'){
      data_type_list = $("input[name='data_type_4_list']:checked").val();
    }
    $.ajax({
      url: 'php/function.php',
      type: 'POST',
      data: 'list_type='+list_type+'&data_type_list='+ data_type_list+'&case=projectFilter',
      success: function (response) {
        if(response == 'false'){
          let div = '<div class="card card-default"><div class="card-body"><h3>no data to display</h3></div></div>'
          $('#accordion').append(div);
        }else{
          var output = $.parseJSON(response);
          
          var unique_dept_name = output.filter((value, index, self) => self.map(x => x.dept_name).indexOf(value.dept_name) == index);      
          console.log(unique_dept_name);
          unique_dept_name.forEach((value, index, self) => {
            var id = value['dept_code'];
            var name = value['dept_name'];
            var hod_dept_code = value['hod_dept_code'];            
            
            var count = output.reduce(function(n, val) {
              return n + (val['dept_name'] === name);
            }, 0);
            // console.log(count);
            
            var div = '<div class="card card-default"><h4 class="card-title w-100"><a class="d-block w-100 acc" data-toggle="collapse"  href="#'+id+'" aria-expanded="true" >'+name+'</a></h4></div><div id="'+id+'" class="collapse show" role="tabpanel"><div class="card-body"><table class="table-bordered css-serial table-hover" id="tab_'+id+'" style="width:100%"><tr class="text-center"><th>Sno</th><th>Project Name</th><th>Funding Agency</th><th>Location(District/Taluk)</th><th>Updated Date</th><th>Project Cost(in Cr)</th><th>More Info</th></tr></table></div></div></div>';
            $('#accordion').append(div);
          }) 
          var sno_i = 1; 
          output.forEach((value, index, self) => {
            let dept_id = value['dept_code'];
            let hod_id = value['hod_dept_code'];
            let prj_name_full = value['name_of_the_project'];
            let updated_date = value['updated_date'];
            let funding_agency_full = value['funding_agency'];
            let project_cost = value['project_cost'];
            let latitude = value['latitude'];
            let longitude = value['longitude'];
            let layers = value['layers'];
            let id = value['id'];
            let district_name = value['district_name'];
            let taluk_name = value['taluk_name'];
            let village_name = value['village_name'];
            let proj_id =value['project_id'];
            let created_time = value['created_time'];
            if(district_name == null){
              district_name = 'nil';
            }
            if(taluk_name == null){
              taluk_name = 'nil';
            }
            if(village_name == null){
              village_name = 'nil';
            }
            let addrs_full = district_name+'/'+taluk_name;
            let addrs = addrs_full.substr(0, 15) + "...";
            if(funding_agency_full == null){
              funding_agency = 'nil';
              funding_agency_full = 'nil';
            }else{
              funding_agency = funding_agency_full.substr(0, 10) + "...";
            }
            prj_name = prj_name_full.substr(0, 30) + "...";
            let button = '<center><a href="search.php?proj_id='+id+'"><button class="btn btn-primary">View More</button></a></center>';
            let cus_class = '';
            if(list_type != 'all' && data_type_list == 'all_data'){
              if(list_type == 'data_avail'){
                if(layers != '' && layers != null && created_time != null){
                  cus_class = 'bg-success';
                }else if((layers == '' || layers == null) && created_time != null){
                  cus_class = 'bg-warning';
                }else if((layers == '' || layers == null) && created_time == null){
                  cus_class = 'bg-danger';
                }
              }else if(list_type == 'time_overrun'){
                let present_status = value['present_status'];
                // console.log(present_status.match(/.*completed.*/));
                // if(present_status)
                if((present_status == '' || present_status == null || present_status == 'Yet to be started' )){
                  cus_class = 'bg-overdue';
                }else if(present_status == 'In progress'){
                  cus_class = 'bg-inprogress';
                }else if(present_status == 'Completed'){
                  // console.log(present_status);
                  cus_class = 'bg-completed';
                }
              }else if(list_type == 'data_update'){
                if(updated_date != null){
                  let d1 = new Date(updated_date);
                  let d2 = new Date();
                  let month = monthDiff(d1, d2);
                  console.log(month);
                  if(month == 0){
                    cus_class = 'bg-lesser';
                  }else if(month >= 1 && month <= 3){
                    cus_class = 'bg-onetothree';
                  }else if(month > 3){
                    cus_class = 'bg-greater';
                  }
                }else if(updated_date == null){
                  cus_class = 'bg-greater';
                }
              }
            }
            if(list_type == 'data_avail'){
              if(data_type_list == 'mis_gis'){
                cus_class = 'bg-success';
              }else if(data_type_list == 'mis'){
                cus_class = 'bg-warning';
              }else if(data_type_list == 'no_data'){
                cus_class = 'bg-danger';   
              }
            }else if(list_type == 'time_overrun'){
              if(data_type_list == 'completed'){
                cus_class = 'bg-completed';
              }else if(data_type_list == "in_progress"){
                cus_class = 'bg-inprogress';  
              }else if(data_type_list == "delay"){
                cus_class = 'bg-overdue';   
              }
            }else if(list_type == 'data_update'){
              if(data_type_list == 'less1'){
                cus_class = 'bg-lesser';
              }else if(data_type_list == 'oneto3'){
                cus_class = 'bg-onetothree';
              }else if(data_type_list == 'less3'){
                cus_class = 'bg-greater';
              }
            }
            let div = '<tr class="'+cus_class+'"><td></td><td title="'+ prj_name_full +'">'+prj_name+'</td><td title="'+ funding_agency_full +'">'+funding_agency+'</td><td  title="'+ addrs_full +'">'+addrs+'</td><td>'+updated_date+'</td><td>'+project_cost+'</td><td>'+button+'</td></tr>';
            $('#tab_'+dept_id+' tr:last').after(div);
            sno_i++;
          })
        } 
      }  
    });
  }

  function monthDiff(d1, d2) {
    var months;
    months = (d2.getFullYear() - d1.getFullYear()) * 12;
    months -= d1.getMonth();
    months += d2.getMonth();
    return months <= 0 ? 0 : months;
  }
</script>

<!-- Overall Report Dowload -->
<script type="text/javascript">
  $(document).ready(function() {
    $("#abstractReportContent").hide();
  });
  $("#downloadAbstractReport").click(function(){
    var dept_code = "ALL";
    var hod_code = "ALL";
    var project_id = "ALL";
    // if(dept_code == ""){
    //   $("#err-dept-name").text("Please select department name");return false;
    // }
    // if(hod_code == ""){
    //   $("#err-hod-name").text("Please select HOD name");return false;
    // }
    // if(project_id == ""){
    //   $("#err-project-name").text("Please select project name");return false;
    // }
    $.ajax({
      url: 'php/function.php',
      type: 'POST',
      data: 'case=getProjectAbstract&dId='+dept_code+'&hId='+hod_code+'&pId='+project_id,
      success: function (response) {
        $("#abstractReportContent").hide();
        $("#abstractReportContent").empty();
        // $("#hid_dept_code").val(dept_code);
        // $("#hid_dept_hod_code").val(hod_code);
        // $("#hid_project_id").val(project_id);
        // alert(response);
        var res = JSON.parse(response);
        var content = '<div class="col-sm-12"><br /><h4 style="text-align:center;">Abstract Report</h4><hr /></div>';
        for(i=0;i<res.length;i++){
          content +='<div class="col-sm-12" style="border-bottom: 1px solid black;margin:20px 0px;">';
          content += '<p><strong>Project Name:</strong> '+ res[i].project_name +'</p>';
          content += '<p><strong>Department Name:</strong> '+ res[i].department_name +'</p>';
          content += '<p><strong>Head Of Department:</strong> '+ res[i].hod_name +'</p>';
          content += '<p><strong>Implementing Agency:</strong> '+ res[i].implementing_agency +'</p>';
          content += '<p><strong>Project Description:</strong> '+ res[i].project_desc +'</p>';
          content += '<p><strong>Government Order:</strong> '+ res[i].government_orders +'</p>';
          content += '<p><strong>Funding Agency:</strong> '+ res[i].funding_agency +'</p>';
          if(res[i].project_start_date){
            var pro_start_dt = res[i].project_start_date
          }else{
            var pro_start_dt = " - ";
          }
          content += '<p><strong>Project Start Date:</strong> '+ pro_start_dt +'</p>';
          if(res[i].project_end_date){
            var pro_end_dt = res[i].project_end_date
          }else{
            var pro_end_dt = " - ";
          }
          content += '<p><strong>Project End Date:</strong> '+ pro_end_dt +'</p>';
          content += '<p><strong>Project Cost:</strong> '+ res[i].project_cost +' Cr</p>';
          function getDuration(milli){
            let minutes = Math.floor(milli / 60000);
            let hours = Math.round(minutes / 60);
            let days = Math.round(hours / 24);
            return ( (days && {value: days, unit: 'days'}) || (hours && {value: hours, unit: 'hours'}) ||{value: minutes, unit: 'minutes'}
                            )
          };
          if(res[i].project_end_date == null ){
            time_overrun = "0"
          } else if(res[i].project_end_date){
            var endDate = new Date(res[i].project_end_date);
            var todayDate = new Date();
            var timeOverRun = 0;
            if(endDate < todayDate){
              timeOverRun = getDuration(todayDate - endDate);
            }
            if(!(timeOverRun.value == undefined)){
              time_overrun = timeOverRun.value;
            }else{
              time_overrun = "0"
            }  
          }
          if(res[i].cost_overrun_reasons == null){
            cost_overrun_reasons = "0";
          }else{
            cost_overrun_reasons = res[i].cost_overrun_reasons;
          }
          if(res[i].cost_overrun == null){
            cost_overrun = "0";
          }else{
            cost_overrun = res[i].cost_overrun;
          }
          if(res[i].causes_of_delay == null){
            causes_of_delay = "None";
          }else{
            causes_of_delay = res[i].causes_of_delay;
          }
          content += '<p><strong>Project Time Overrun:</strong> '+ time_overrun +' Days</p>';
          content += '<p><strong>Project Time Overrun Reasons:</strong> '+ causes_of_delay +'</p>';
          content += '<p><strong>Project Cost Overrun:</strong> '+ cost_overrun +' Cr</p>';
          content += '<p><strong>Project Cost Overrun Reasons:</strong> '+ cost_overrun_reasons +' </p>';
          content += '<p><strong>Updated Date:</strong> '+ res[i].updated_time +'</p>';
          content += '</div>';
        }
        $("#abstractReportContent").append(content);
        $("#downloadAbstractReport").show();

        var content = $("#abstractReportContent").html();
        // var content = document.getElementById('abstractReportContent');
        // Generate the PDF.
        var opt = {
          margin:1,
          filename:     'abstract_report.pdf',
          // html2canvas:  { scale: 2 },
          jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' },
          pagebreak: { mode: 'avoid-all' }
        };
        html2pdf().set(opt).from(content).save();
      }
    });
    
  });
</script>

</body>
</html>
