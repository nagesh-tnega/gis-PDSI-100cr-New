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
            <a href="report_abstract.php" class="nav-link active">
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
                  
<div class="row" style="margin:0px;">
    <div class="col-sm-3" style="margin-left:10px;">
       <div class="form-group row">
            
            <div class="col-md-10">
                <label class="col-md-12 col-form-label" for="department_name">Select Department<span class="required">*</span></label>
                <select class="form-control input-md" id="department_name" name="department_name">
                    <option value="" selected="selected">Select</option>
                    <option value="ALL">All</option>
                    <?php
                                            $opt = '';
                                            if(count($getDeptList) > 0){
                                                //print_r($transfer_category);
                                                for($i = 0;$i<count($getDeptList);$i++) {
                                                    $code = $getDeptList[$i]['dept_code'];
                                                    $query_1 = "select dept_code from sp_index_v2 where dept_code = '$code' ";
                                                    $result_1 = pg_query(DBCON, $query_1);
                                                    $count_1 = pg_num_rows($result_1);
                                                    $opt .= '<option value="'.$getDeptList[$i]['dept_code'].'">'.$getDeptList[$i]["dept_name"].' ('.$count_1.' Projects)</option>';
                                                }
                                                
                                                echo $opt;
                                            }

                                        ?>
                </select>
                <span class="err" id="err-dept-name"></span>
            </div>
        </div>

        <div class="form-group row">
             <div class="col-md-10">
                <label class="col-md-12 col-form-label" for="implementing_agency">Select Implementing Agency<span class="required">*</span></label>
                <select class="form-control input-md" id="implementing_agency" name="implementing_agency">
                    <option value="" selected="selected">Select</option>
                    <option value="ALL">All</option>
                </select>
                <span class="err" id="err-hod-name"></span>
            </div>
        </div>
        <div class="form-group row">
             <div class="col-md-10">
                <label class="col-md-12 col-form-label" for="project_name">Select Project<span class="required">*</span></label>
                <select class="form-control input-md" id="project_name" name="project_name">
                    <option value="" selected="selected">Select</option>
                    <option value="ALL">All</option>
                </select>
                <span class="err" id="err-project-name"></span>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-10">
                <center><button class="btn btn-primary" id="submit" >Submit</button></center>
            </div>
        </div>
    </div>
    <div class="col-sm-9" style="padding:0px !important;max-width: 72%;">

         <div class="row" style="background-color:#72A0C1;padding:7px; ">
        <div class="col-sm-8">
            <h5>Reports - Project Abstract</h5>
        </div>
        <div class="col-sm-4">
             <a style="float:right;color:#000;" id="downloadAbstractReport"><i class="fa fa-file-pdf-o"></i> Download</a>
        </div>
        <input type="hidden" class="form-control" id="hid_dept_code" name="hid_dept_code" />
        <input type="hidden" class="form-control" id="hid_dept_hod_code" name="hid_dept_hod_code" />
        <input type="hidden" class="form-control" id="hid_project_id" name="hid_project_id" />
    </div>
    
    

    <div class="row" style="border:2px solid #72A0C1;margin-top: 10px;overflow: scroll;height:480px;" id="abstractReportContent">
         
    
   
    </div>


    </div>
    <br />
   
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
<!-- pdf js-->
 <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.min.js"></script>

<script>
      $(document).ready(function() {
                $("#abstractReportContent").hide();
                $("#downloadAbstractReport").hide();

                //Change department
                $("#department_name").change(function(){
                    $("#err-dept-name").text("");
                    var dept_code = $(this).val().trim();
                    if(dept_code == 'ALL'){
                        $("#implementing_agency").val("ALL");
                        $("#project_name").val("ALL");
                    }else{
                        $("#implementing_agency").val("");
                        $("#project_name").val("");

                        //Get Implementing Agency Based on department name.
                        $.ajax({
                            url: 'php/function.php',
                            type: 'POST',
                            data: 'dept='+ dept_code +'&case=hods',
                            success: function (response) {
                                $("#implementing_agency").empty();
                                var res = JSON.parse(response);
                                // var content = '<option value="" selected>Select</option><option value="ALL">ALL</option>';
                                // for(i=0;i<res.length;i++){
                                //     content += '<option value="'+res[i].hod_dept_code+'">'+res[i].hod_name+'</option>';
                                // }
                                $('#implementing_agency').html(res.html);
                                // $("#implementing_agency").append(content);
                            }

                        });

                    }
                });

                //Change Implementing Agency
                $("#implementing_agency").change(function(){
                    $("#err-hod-name").text("");
                    var hod_code = $(this).val().trim();
                    if(hod_code == 'all_hod'){
                       
                        $("#project_name").val("ALL");
                    }else{
                        
                        $("#project_name").val("");

                        //Get Project Name Based on department name and Implementing Agency.
                        $.ajax({
                            url: 'php/function.php',
                            type: 'GET',
                            data: 'case=getProjectNameByImplAgency&hId='+hod_code,
                            success: function (response) {
                                $("#project_name").empty();
                                var res = JSON.parse(response);
                                console.log(res.length);
                                var content = '';
                                if(res.length != undefined){
                                  content += '<option value="" selected>Select</option><option value="ALL">ALL</option>';
                                }else{
                                  content += '<option value="">No Projects</option>';
                                }
                                for(i=0;i<res.length;i++){
                                    content += '<option value="'+res[i].project_id+'">'+res[i].project_name+'</option>';
                                }
                                $("#project_name").append(content);
                            }

                        });

                    }
                });

                //Project Change Event
                $("#project").change(function(){
                    $("#err-project-name").text("");
                });

                //Submit Form
                $("#submit").click(function(){
                    $("#err-project-name").text("");
                    var dept_code = $("#department_name").val().trim();
                    var hod_code = $("#implementing_agency").val().trim();
                    var project_id = $("#project_name").val().trim();
                    if(dept_code == ""){
                        $("#err-dept-name").text("Please select department name");return false;
                    }
                    if(hod_code == ""){
                        $("#err-hod-name").text("Please select HOD name");return false;
                    }
                    if(project_id == ""){
                        $("#err-project-name").text("Please select project name");return false;
                    }

                    $.ajax({
                        url: 'php/function.php',
                        type: 'POST',
                        data: 'case=getProjectAbstract&dId='+dept_code+'&hId='+hod_code+'&pId='+project_id,
                        success: function (response) {
                             $("#abstractReportContent").show();
                            $("#abstractReportContent").empty();
                            $("#hid_dept_code").val(dept_code);
                            $("#hid_dept_hod_code").val(hod_code);
                            $("#hid_project_id").val(project_id);
                            //alert(response);
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
        if(res[i].project_start_date){var pro_start_dt = res[i].project_start_date}else{var pro_start_dt = " - ";}
        content += '<p><strong>Project Start Date:</strong> '+ pro_start_dt +'</p>';
        if(res[i].project_end_date){var pro_end_dt = res[i].project_end_date}else{var pro_end_dt = " - ";}
        content += '<p><strong>Project End Date:</strong> '+ pro_end_dt +'</p>';
        content += '<p><strong>Project Cost:</strong> '+ res[i].project_cost +' Cr</p>';
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
                             //$("#hid_dept_code").val($("#abstractReportContent").html());
                        }
                    });


                });


                $("#downloadAbstractReport").click(function(){
                   /* var dept_code = $("#hid_dept_code").val().trim();
                    var hod_code = $("#hid_dept_hod_code").val().trim();
                    var project_id = $("#hid_project_id").val().trim();
                    $.ajax({
                        url: '../php/function.php',
                        type: 'POST',
                        data: 'case=downloadAbstractReport&dId='+dept_code+'&hId='+hod_code+'&pId='+project_id,
                        success: function (response) {
                            
                        }
                    });*/

                    var content = $("#abstractReportContent").html();
                    // Generate the PDF.
                    html2pdf().from(content).set({
                        margin: 1,
                        filename: 'abstract_report.pdf',
                        jsPDF: {orientation: 'portrait', unit: 'in', format: 'letter', compressPDF: true},
                        pagebreak : {mode:'avoid-all'}
                    }).save();

                });



    //new $.fn.dataTable.FixedHeader( table );
} );

    </script>
</body>
</html>
