<?php 
require_once('php/dbHandler.php');
include('php/session.php');
$proj_id = false;
if(strpos($_SERVER['REQUEST_URI'], "proj_id") !== false){
  $proj_id = $_GET['proj_id'];
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
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.css">
   <!-- Select2 -->
  <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
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
            <a href="search.php" class="nav-link active">
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
          </div>
        </div>
       
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid" id="search_div" style="display: none;">
          <h2 class="text-center display-4">Search</h2>
          <form action="#">
            <div class="row">
              <div class="col-md-10 offset-md-1">
                <div class="row">
                  <div class="col-4">
                    <div class="form-group">
                      <label>Departments</label>
                      <select class="form-control select2bs4" id="dept" style="width: 100%;">    
                      </select>
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="form-group" id="hod_div">
                      <label>HOD</label>
                      <select class="form-control select2bs4" id="hod" style="width: 100%;">
                        <!-- <option value="null">Select HOD</option> -->
                      </select>
                    </div>  
                  </div>
                  <div class="col-4">
                    <div class="form-group" id="project_div" style="display: none;">
                      <label>Projects</label>
                      <select class="form-control select2bs4" id ="project" style="width: 100%;" onchange="getProjectDetails()">
                        <option value="null">Select Project</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <select id="search_data" class="form-control form-control-lg select2bs4">
                    </select>
                    <div class="input-group-append">
                      <button type="submit" class="btn btn-lg btn-default">
                        <i class="fa fa-search"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
      </div>
      <div class="row mt-3">
        <div class="col-md-12">
          <div class="list-group" id="search_result" style="display:none;">
            
          </div>
        </div>
      </div>
    </section>

    
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
<!-- Select2 -->
<script src="plugins/select2/js/select2.full.min.js"></script>
<script>
    $(function () {
      //Initialize Select2 Elements
      $('.select2').select2();
      //Initialize Select2 Elements
      $('.select2bs4').select2({
        theme: 'bootstrap4'
      })
      // $("#search_data").select2({
      //     theme: 'bootstrap4',
      //     minimumInputLength: 1
      //   });
    });
</script>

<script type="text/javascript">
  getDept();
  $("#dept").change(function() {
    if ($("#dept").val() == 'null' ) {
      $('#hod_div').show();
      $('#hod').empty();
      $('#project_div').hide();
      $('#project').empty();
      $("#search_data").empty();
      loadprojectdata();
    }
    else if ($("#dept").val() == 'all' ) {
      $('#hod_div').show();
      $('#project_div').hide();
      $('#project').empty();
      $("#search_data").empty();
      HODs();     
    }
    else{
      $('#hod_div').show();
      $('#project_div').hide();
      $("#search_data").empty();
      HODs(); 
    }
  });
  $("#hod").change(function() {
    if ($("#hod").val() == 'null' ) {
      $('#project_div').hide();
      $('#project').empty();
      $("#search_data").empty();
    }else{
      $('#project_div').hide();
      $('#project').empty();
      Projects();
    }
  });
  function getDept() {
      $.ajax({
      url: 'php/function.php',
      type: 'POST',
      data: 'case=departments',
      success: function(response) {
        // console.log(response);
        var html = JSON.parse(response);
        $('#dept').html(html.html);
      }
    })
  }
  function HODs() {
    var dept = $("#dept").val();
    $('#project').empty();
    $('#hod').empty();
    $.ajax({
      url: 'php/function.php',
      type: 'POST',
      data: 'dept='+ dept +'&case=hods',
      success: function(response) {
        var html = JSON.parse(response);
        $('#hod').html(html.html);
      }
    });
  }
  function Projects() {
    var dept = $("#dept").val();
    var hod = $("#hod").val();
    $('#project').empty();
    $.ajax({
      url: 'php/function.php',
      type: 'POST',
      data: 'dept='+ dept +'&case=projects'+'&hod='+ hod,
      success: function(response) {
        var html = JSON.parse(response);
        $('#search_data').html(html.html);
      }
    });
  }
</script>
<!-- Search bar big -->
<script type="text/javascript">
  loadprojectdata();
  function loadprojectdata() { 
    $("#search_data").empty();
    $.ajax({
      url: 'php/function.php',
      type: 'POST',
      data: 'case=project_search',
      success: function(response) {
        // console.log(response);
        var ps = JSON.parse(response);
        $('#search_data').html(ps.html);
      }
    })
  }
  $("#search_data").change(function() {
    let proj_id = $("#search_data").val();
    $('#search_result').empty();
    $.ajax({
      url: 'php/function.php',
      type: 'POST',
      data: 'proj_id='+ proj_id +'&case=project_details',
      success: function(response) {
        let project_detail = JSON.parse(response);
        console.log(project_detail);
        // populateFromId(project_detail);
        $('#search_result').empty();
        $('#search_result').show();
        let data = search_data(project_detail);
        $('#search_result').html(data);
      }
    });
  });
</script>
<!-- Populate Dept & HOD from id -->
<script type="text/javascript">
  function populateFromId(data) {
    let dept_code = data.html.dept_code;
    let hod_code = data.html.hod_name;
    let id = data.html.id;
    // console.log(hod_code);
    // $('#dept').val(dept_code).trigger("change");
    $('#dept').val(dept_code).change();
    $("#hod").val(hod_code);
    $("#hod").change();
    // let s = document.getElementById("hod");
    // console.log(s.options.length);
    let hod1 = $("#hod").val();
    console.log(hod1);
  }
</script>
<!-- Display Details -->
<script type="text/javascript">
  function getProjectDetails() {
    let proj_id = document.getElementById("project").value;
    // let dept_code = $("#dept").val();
    $('#search_result').empty();
    $.ajax({
      url: 'php/function.php',
      type: 'POST',
      data: 'proj_id='+ proj_id +'&case=project_details',
      success: function(response) {
        var project_detail = JSON.parse(response);
        $('#search_result').empty();
        $('#search_result').show();
        let data = search_data(project_detail);
        $('#search_result').html(data);
        
      }
    });
  }

  function search_data(data) {
    // return '<div class="list-group-item"><div class="row"><div class="col px-4"><center><h3>'+data.html.department_name+'</h3></center><div><h5>'+data.html.name_of_the_project+'-'+data.html.project_id+'</h5><p class="mb-0"><b>Description:</b>'+data.html.short_description_of_the_project+'</p></div></div></div></div>';
    let div = "<div class='list-group-item'><div class='row'><div class='col px-4'>";
    div += "<p class='text-center bg-info mr-2'><b><i class='fa fa-briefcase' aria-hidden='true'></i> Project Details</b></p>&nbsp<div><h6 class=' mr-3 font-italic text-primary'>"+data.html.name_of_the_project+"</h6><div><p class='text-left text-light bg-dark mr-2 mb-0'><b>&nbspProject ID</b> :"+data.html.project_id+"</p><p class='text-left text-light bg-dark mr-2 mb-0'><b>&nbspDepartment Name</b> :"+data.html.department_name+"</p><p class='text-left text-light bg-dark mr-2 mb-0'><b>&nbsp<i class='fa fa-calendar-check-o' aria-hidden='true'></i>&nbspProject Start Date</b> :"+data.html.project_start_date+"</p><p class='text-left text-light bg-dark mr-2 mb-0'><b>&nbsp<i class='fa fa-calendar-check-o' aria-hidden='true'></i>&nbspProject End Date</b> : "+data.html.project_end_date+"</p><p class='text-left text-light bg-dark mr-2 mb-0'><b>&nbsp<i class='fa fa-calendar-check-o' aria-hidden='true'></i>&nbspExtend Of Date</b> :"+data.html.eot+"</p><p class='text-left text-light bg-dark mr-2 mb-0'><b>&nbsp<i class='fa fa-wrench' aria-hidden='true'></i>&nbspImplementing Agency</b> :"+data.html.implementing_agency+"</p><p class='text-left text-light bg-dark mr-2 mb-0'><b>&nbsp<i class='fa fa-credit-card' aria-hidden='true'></i>&nbspFunding Agency</b> :"+data.html.funding_agency+"</p></br><h5 class='text-center'><b>Location Details</b></h5><p class='text-left text-light bg-dark mr-2 mb-0'><b>&nbspDistrict</b> :"+data.html.district_name+"</p><p class='text-left text-light bg-dark mr-2 mb-0'><b>&nbspTaluk</b> :"+data.html.taluk_name+"</p><p class='text-left text-light bg-dark mr-2 mb-0'><b>&nbspVillages</b> :"+data.html.village_name+"</p><p class='text-left text-light bg-dark mr-2 mb-0'><b>&nbsp<i class='fa fa-map-marker' aria-hidden='true'></i>&nbspLocation</b> :"+data.html.latitude+","+data.html.longitude+"</p>&nbsp";
    div += "<h5 class='text-center'><b>Cost</b></h5><p class='text-center h4 text-warning'><i class='fa fa-inr' aria-hidden='true'></i>&nbsp"+data.html.project_cost+" Crores</p>&nbsp<h5 class='text-center'><b>Fund Recieved</b></h5>";
    if(data.html.fund_received != ''){
      div += "<p class='text-center h4 text-warning'><i class='fa fa-inr' aria-hidden='true'></i>&nbsp"+data.html.fund_received+" Crores</p>&nbsp";
    }else {
      div += "<p class='text-center h4 text-danger'><i class='fa fa-exclamation' aria-hidden='true'></i>&nbspNot Updated</p>&nbsp";
    }
    div += "<h5 class='text-center'><b>Fund Yet To Be Recieved</b></h5>";
    if(data.html.fund_yet_to_be_received != ''){
      div += "<p class='text-center h4 text-warning'><i class='fa fa-inr' aria-hidden='true'></i>&nbsp"+data.html.fund_yet_to_be_received+" Crores</p>&nbsp";
    }else{
      div += "<p class='text-center h4 text-danger'><i class='fa fa-exclamation' aria-hidden='true'></i>&nbspNot Updated</p>&nbsp";
    }
    div += "<p class='text-left font-italic'><b>Project Description</b> : <medium>"+data.html.short_description_of_the_project+"</medium></p>&nbsp";
    if(data.html.government_orders != ''){
      div += "<p class='text-left font-italic'><b>Government Orders :</b>"+data.html.government_orders+"</p>";
    }else{
      div += "<p class='text-left font-italic'><b>Government Orders :</b> <span class='text-danger'> <i class='fa fa-exclamation' aria-hidden='true'></i>&nbspNot Updated</span></p>";
    }
    if(data.html.total_project_extend != ''){
      div += "<p class='text-left font-italic'><b>Total Project Extent : </b> &nbsp"+data.html.total_project_extend+"</p>";
    }else{
      div += "<p class='text-left font-italic'><b>Total Project Extent :</b> <span class='text-danger'> <i class='fa fa-exclamation' aria-hidden='true'></i>&nbspNot Updated</span></p>";
    }
    if(data.html.work_completed_details_with_extend != ''){
      div += "<p class='text-left font-italic'><b>Work completed details with extend : </b> &nbsp"+data.html.work_completed_details_with_extend+"</p>";
    }else{
      div += "<p class='text-left font-italic'><b>Work completed details with extend : </b> <span class='text-danger'> <i class='fa fa-exclamation' aria-hidden='true'></i>&nbspNot Updated</span></p>";
    }
    if(data.html.work_in_progress_details_with_extend != ''){
      div += "<p class='text-left font-italic'><b>Work in progress details with extend :</b> &nbsp"+data.html.work_in_progress_details_with_extend+"</p>";
    }else{
      div += "<p class='text-left font-italic'><b>Work in progress details with extend : </b> <span class='text-danger'> <i class='fa fa-exclamation' aria-hidden='true'></i>&nbspNot Updated</span></p>";
    }
    if(data.html.work_to_be_completed_details_with_extend != ''){
      div += "<p class='text-left font-italic'><b>Work to be completed details with extend :</b> &nbsp"+data.html.work_to_be_completed_details_with_extend+"</p>";
    }else{
      div += "<p class='text-left font-italic'><b>Work to be completed details with extend : </b> <span class='text-danger'> <i class='fa fa-exclamation' aria-hidden='true'></i>&nbspNot Updated</span></p>";
    }
    if(data.html.remarks != ''){
      div += "<p class='text-left font-italic'><b>Remarks :</b> &nbsp"+data.html.remarks+"</p>";
    }else{
      div += "<p class='text-left font-italic'><b>Remarks : </b> <span class='text-danger'> <i class='fa fa-exclamation' aria-hidden='true'></i>&nbspNot Updated</span></p>";
    }
    if(data.html.photo_prior_to_commencement_of_work != null){
      div += "<p class='text-left font-italic'><b>Project Prior (as on "+data.html.created_time+"):</b></br><img style='width:200px;height150px' src='"+data.html.photo_prior_to_commencement_of_work+"' onclick='openImg(this)'>";
    }else{
      div += "<p class='text-left font-italic'><b>Project Prior (as on "+data.html.created_time+"):</b>  <span class='text-danger'> <i class='fa fa-exclamation' aria-hidden='true'></i> No Image added</span>";
    }
    if(data.html.photo_current_status != null){
      div += "<p class='text-left font-italic'><b>Current Status photo (as on "+data.html.updated_time+") :</b></br><img style='width:200px;height150px' src='"+data.html.photo_current_status+"'  onclick='openImg(this)'>";
    }else{
      div += "<p class='text-left font-italic'><b>Current Status photo (as on "+data.html.updated_time+") :</b><span class='text-danger'> <i class='fa fa-exclamation' aria-hidden='true'></i> No Image added</span></p>";
    }


    div += "</div></div></div></div></div>";
    return div;

  }
</script>
<!-- //Function for displaying data from Another Page -->
<?php
  if($proj_id){
?> 
  <script type="text/javascript">
    let proj_id = "<?php echo $proj_id; ?>";
    $('#search_result').empty();
    $.ajax({
      url: 'php/function.php',
      type: 'POST',
      data: 'proj_id='+ proj_id +'&case=project_details',
      success: function(response) {
        var project_detail = JSON.parse(response);
        // populateFromId(response);
        $('#search_div').hide();
        $('#search_result').empty();
        $('#search_result').show();
        let data = search_data(project_detail);
        $('#search_result').html(data);
        
      }
    });
  </script>
<?php  
  }
?>
</body>
</html>
