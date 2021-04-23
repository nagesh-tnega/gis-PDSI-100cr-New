<?php 
require_once('php/dbHandler.php');
include('php/session.php');
require_once('api/mstCausesOfDelay.php');
//get Causes of delay list from the master table.
$causes_of_delay = mstCausesOfDelay::getCausesOfDelay(DBCON);

$hod_dept = $_SESSION['100c_user_info']['hod_dept_code'];

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
                      <th>Name of the project</th>
                      <th>Project start date</th>
                      <th>GIS Layers</th>
                      <th>Created date</th>
                      <th>Last updated</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $query = "select project_id, name_of_the_project, project_start_date, layers as GIS_layers, DATE(created_time) as Created_Date,DATE(updated_time) as Last_Updated, id, layers, latitude, longitude from sp_index_v2 where hod_name = '$hod_dept' order by updated_time desc";
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
                          <td><?php echo $row[1];?></td>
                          <td><?php echo $row[2];?></td>
                          <td><?php echo $row[3];?></td>
                          <td><?php echo $row[4];?></td>
                          <td><?php echo $row[5];?></td>
                          <td>
                            <button class="btn btn-primary btn-sm" onClick="editPrj(<?php echo $row[6]; ?>)">
                              <i class="fas fa-pencil-alt"></i>
                                Edit
                            </button>
                            <button class="btn btn-danger btn-sm" title="Delete Project" onClick="deletePrj(<?php echo $row[6]; ?>)">
                              <i class="fas fa-trash-alt"></i>
                                Delete
                            </button>
                          </td>
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
        <!-- Add Project Model -->
        <div class="modal fade" id="myModal" role="dialog">
          <div class="modal-dialog" style="max-width:90%;margin: 30px auto;overflow-y: initial !important">   
            <div class="modal-content">  
              <div class="modal-header">
                <h6 class="modal-title">Add New Infrastructure Project</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body" style=" max-height: calc(100vh - 200px);overflow-y: auto;">
                <form id="data_form" action=""> 
                  <!-- Latitude | Text input-->
                  <div class="form-group row">
                    <label class="col-md-4 col-form-label" for="lat">Latitude<span class="required">*</span></label>
                    <div class="col-md-4">
                      <input aria-describedby="latHelpBlock" id="lat" name="lat" type="number" placeholder="latitude" class="form-control input-md" required step=".0001">
                      <small id="latHelpBlock" class="text-muted">eg: 13.0827</small>
                      <span class="err" id="lat-err"></span>
                    </div>
                  </div> 
                  <!-- Longitude | Text input-->
                  <div class="form-group row">
                    <label class="col-md-4 col-form-label" for="long">Longitude<span class="required">*</span></label>
                    <div class="col-md-4">
                      <input aria-describedby="longHelpBlock" id="long" name="long" type="number"  placeholder="Longitude" class="form-control input-md" required step='.0001'>
                      <small id="longHelpBlock" class="text-muted">eg: 80.2707</small>
                      <span class="err" id="lon-err"></span>
                    </div>
                  </div>
                    <!--  | Button -->
                  <div class="form-group row">  
                    <div class="col-md-4">
                      <button id="checkLatLong" name="checkLatLong" class="btn btn-primary" type="button">Check</button>
                    </div>
                  </div>
                  <div id="prj_particulars" style="display:none">
                    <!-- Implementing Agency | Text input-->
                    <div class="form-group row">
                      <label class="col-md-4 col-form-label" for="implementing_agency">Implementing Agency<span class="required">*</span></label>
                      <div class="col-md-4">
                        <input id="implementing_agency" name="implementing_agency" type="text" placeholder="Implementing Agency" class="form-control input-md" required>
                        <span class="err" id="impl-agency-err"></span>
                        
                      </div>
                    </div>
                    <!-- Department Name | Text input-->
                    <div class="form-group row">
                      <label class="col-md-4 col-form-label" for="dept_name">Department Name<span class="required">*</span></label>
                      <div class="col-md-4">
                        <input id="dept_name" name="dept_name" type="text" placeholder="Department Name" class="form-control input-md" value="<?php echo $_SESSION['100c_user_info']['dept_name']; ?>" disabled required>
                        <span class="err" id="dept-name-err"></span>
                        
                      </div>
                    </div>
                    <!-- Project ID | Text input-->
                    <div class="form-group row">
                      <label class="col-md-4 col-form-label" for="prj_id">Project ID<span class="required">*</span></label>
                      <div class="col-md-4">
                        <input id="prj_id" name="prj_id" type="text" placeholder="Project ID" class="form-control input-md" required>
                        <span class="err" id="prj-id-err"></span>
                        
                      </div>
                    </div>
                    <!-- Name of the Project | Textarea -->
                    <div class="form-group row">
                      <label class="col-md-4 col-form-label" for="prj_name">Name of the Project<span class="required">*</span></label>
                      <div class="col-md-8">
                        <textarea class="form-control" id="prj_name" name="prj_name" placeholder="Project Name" required ></textarea>
                        <span class="err" id="prj-name-err"></span>
                      </div>
                    </div>
                    <!-- Funding Agency | Text input-->
                    <div class="form-group row">
                      <label class="col-md-4 col-form-label" for="fund_agency">Funding Agency<span class="required">*</span></label>
                      <div class="col-md-4">
                        <select id="fund_agency" class="form-control input-md"  required>
                          <option value="null">Select the funding Agency</option>
                          <option value="central">Central</option>
                          <option value="state">State</option>
                          <option value="out_agency">Loan from outside agency</option>
                          <option value="others">others</option>
                        </select>
                        <!-- <input id="fund_agency" name="fund_agency" type="text" placeholder="Funding Agency" class="form-control input-md" required>
                        -->                   <span class="err" id="fund-agency-err"></span>
                      </div>
                    </div>               
                    <!-- Government orders | Text input-->
                    <div class="form-group row">
                      <label class="col-md-4 col-form-label" for="gov_orders">Government orders</label>
                      <div class="col-md-4">
                        <input id="gov_orders" name="gov_orders" type="text" placeholder="Government orders" class="form-control input-md" >        
                      </div>
                    </div>
                    <!-- Select the district | Select Multiple -->
                    <div class="form-group row">
                      <label class="col-md-4 col-form-label" for="prj_dist">Select the district<span class="required">*</span></label>
                      <div class="col-md-5">
                        <input id="prj_dist" name="prj_dist"  class="form-control typeahead tm-input form-control tm-input-info" placeholder="search district" >
                        <span class="err" id="prj-dist-err"></span>
                      </div>
                    </div>
                    <!-- Select the taluk | Select Multiple -->
                    <div class="form-group row">
                      <label class="col-md-4 col-form-label" for="prj_taluk">Select the Taluk<span class="required">*</span></label>
                      <div class="col-md-5">
                        <input id="prj_taluk" name="prj_taluk"  class="form-control typeahead tm-input form-control tm-input-info" placeholder="search taluk" >
                        <span class="err" id="prj-taluk-err"></span>
                      </div>
                    </div>
                    <!-- Select the Village | Select Multiple -->
                    <div class="form-group row">
                      <label class="col-md-4 col-form-label" for="prj_vill">Select the Village<span class="required">*</span></label>
                      <div class="col-md-5">
                        <input id="prj_vill" name="prj_vill"  class="form-control typeahead tm-input form-control tm-input-info" placeholder="search village">
                        <span class="err" id="prj-village-err"></span>
                      </div>
                    </div>
                    <!-- Survey Numbers | Textarea -->
                    <div class="form-group row">
                      <label class="col-md-4 col-form-label" for="survey_no">Survey Numbers<span class="required">*</span></label>
                      <div class="col-md-8">
                        <textarea class="form-control" id="survey_no" name="survey_no" required></textarea>
                        <span class="err" id="survey-no-err"></span>
                      </div>
                    </div>
                    <!-- Short Description of the Project | Textarea -->
                    <div class="form-group row">
                      <label class="col-md-4 col-form-label" for="prj_desc">Short Description of the Project<span class="required">*</span></label>
                      <div class="col-md-8">
                        <textarea class="form-control" id="prj_desc" name="prj_desc" placeholder="project description" required></textarea>
                        <span class="err" id="prj-desc-err"></span>
                      </div>
                    </div>
                    <!-- Project Start Date | Text input-->
                    <div class="form-group row">
                      <label class="col-md-4 col-form-label" for="start_date">Project Start Date</label>
                      <div class="col-md-4">
                        <input id="start_date" name="start_date" type="date"  class="form-control input-md">
                        <span class="err" id="start-date-err"></span>
                      </div>
                    </div>
                    <!-- Project End Date | Text input-->
                    <div class="form-group row">
                      <label class="col-md-4 col-form-label" for="end_date">Project End Date</label>
                      <div class="col-md-4">
                        <input id="end_date" name="end_date" type="date"  class="form-control input-md">
                        <span class="err" id="end-date-err"></span>
                      </div>
                    </div>  
                    <!-- Project Cost(in Crores) | Text input-->
                    <div class="form-group row">
                      <label class="col-md-4 col-form-label" for="prj_cost">Project Cost (in Crores)<span class="required">*</span></label>
                      <div class="col-md-4">
                        <input id="prj_cost" name="prj_cost" type="number" placeholder="" class="form-control input-md" required step="any" required>
                        <span class="err" id="prj-cost-err"></span>
                      </div>
                    </div>
                    <!-- Fund Received | Text input-->
                    <div class="form-group row">
                      <label class="col-md-4 col-form-label" for="fund_recieved">Fund Received (in Crores)<span class="required">*</span></label>
                      <div class="col-md-4">
                        <input id="fund_recieved" name="fund_recieved" type="number" placeholder="" class="form-control input-md" step=any required>
                        <span class="err" id="fund-received-err"></span>
                      </div>
                    </div>
                    <!-- Fund yet to be received | Text input-->
                    <div class="form-group row">
                      <label class="col-md-4 col-form-label" for="fund_yet_to_received">Fund yet to be received (in Crores)<span class="required">*</span></label>
                      <div class="col-md-4">
                        <input id="fund_yet_to_received" name="fund_yet_to_received" type="number" placeholder="" class="form-control input-md" step=any required>
                        <span class="err" id="fund-yet-to-received-err"></span>
                      </div>
                    </div>
                    <!-- Total project extend | Text input-->
                    <div class="form-group row">
                      <label class="col-md-4 col-form-label" for="total_project_extend">Total project extend<span class="required">*</span></label>
                      <div class="col-md-8">
                        <textarea id="total_project_extend" name="total_project_extend" type="text" placeholder="project extend" class="form-control input-md" required></textarea>
                        <span class="err" id="total-prj-extend-err"></span>
                      </div>
                    </div>
                    <!-- Work completed details with extend | Text input-->
                    <div class="form-group row">
                      <label class="col-md-4 col-form-label" for="work_completed">Work completed details with extend<span class="required">*</span></label>
                      <div class="col-md-8">
                        <textarea id="work_completed" name="work_completed" type="text" placeholder="" class="form-control input-md" required></textarea>
                        <span class="err" id="work-completed-err"></span>
                      </div>
                    </div>
                    <!-- Work in progress details with extend | Text input-->
                    <div class="form-group row">
                      <label class="col-md-4 col-form-label" for="work_in_progress">Work in progress details with extend<span class="required">*</span></label>
                      <div class="col-md-8">
                        <textarea id="work_in_progress" name="work_in_progress" type="text" placeholder="" class="form-control input-md" required></textarea>
                        <span class="err" id="work-inprog-err"></span>
                      </div>
                    </div>
                    <!-- work to be completed details with extend | Text input-->
                    <div class="form-group row">
                      <label class="col-md-4 col-form-label" for="work_to_be_completed">work to be completed details with extend<span class="required">*</span></label>
                      <div class="col-md-8">
                        <textarea id="work_to_be_completed" name="work_to_be_completed" type="text" placeholder="" class="form-control input-md" required></textarea>
                        <span class="err" id="work-to-be-completed-err"></span>
                      </div>
                    </div>
                    <!-- photo_prior| Text input-->
                    <div class="form-group row">
                      <label class="col-md-4 col-form-label" for="photo_prior">Photo prior to commencement of work<span class="required">*</span></label>
                      <div class="col-md-4">
                        <input id="photo_prior" name="photo_prior" type="file" placeholder="" class="form-control input-md" onchange="encodeImageFileAsURL(this)" required>
                        <span class="err" id="photo-prior-err"></span>
                        <small  class="text-muted">supported formats: jpeg, png, gif</small>
                      </div>
                    </div>
                    <!-- photo_current| Text input-->
                    <div class="form-group row">
                      <label class="col-md-4 col-form-label" for="photo_current">Current status photo<span class="required">*</span></label>
                      <div class="col-md-4">
                        <input id="photo_current" name="photo_current" type="file" placeholder="" class="form-control input-md" onchange="encodeImageFileAsURL1(this)" required>
                        <span class="err" id="photo-current-err"></span>
                        <small  class="text-muted">supported formats: jpeg, png, gif</small> 
                      </div>
                    </div>
                    <!-- Project status -->
                    <div class="form-group row">
                      <label class="col-md-4 col-form-label" for="present_status">Present Status<span class="required">*</span></label>
                      <div class="col-md-4">
                        <select id="present_status" class="form-control input-md" required>
                          <option value="0">Select the Status of the work</option>
                          <option value="1">Completed</option>
                          <option value="2">In progress</option>
                          <option value="3">Yet to be started</option>
                          <option value="4">Others</option>
                        </select> 
                        <!-- <span class="err" id="present_status"></span> -->
                      </div>
                    </div> 
                    <!-- remarks | Textarea -->
                    <div class="form-group row">
                      <label class="col-md-4 col-form-label" for="remarks">Remarks<span class="required">*</span></label>
                      <div class="col-md-8">
                        <textarea class="form-control" id="remarks" name="remarks" required></textarea>
                        <span class="err" id="remarks-err"></span>
                      </div>
                    </div>
                    <!-- Causes of Delay -->
                    <div class="form-group row"  id="divDelayOtherReason">
                      <label class="col-md-4 col-form-label" for="delay_other_reason">Other Reasons for causes of delay<span class="required">*</span></label>
                      <div class="col-md-4">
                        <input id="delay_other_reason" name="delay_other_reason" type="text" placeholder="Other Reasons" class="form-control input-md">
                        <span class="err" id="other-delays-err"></span>
                      </div>
                    </div>
                    <!-- Shapefile Import | files -->   
                    <div class="form-group row">
                      <label class="col-md-4 col-form-label" for="shp_import">Import Shapefile</label>
                      <div class="col-md-8">
                        <div id="shp_div">
                          <input type="file" id="shp_import" name="shp_import">
                          <button class="btn btn-success btn-sm" type="button" id="add" title='Add new file'/ onClick="addFiles()">Add new file</button>
                        </div>
                        <small id="" class="text-muted">shapefile compressed with .zip(containing .shp, .prj, .shx, .dbf)</small>
                      </div>
                    </div>
                    <div id="upload-progress-bar" class="form-group col-sm-12" style="display:none">
                      <div class="progress">
                        <div class="progress-bar bg-primary upload-progress" role="progressbar" style="width:0%">0%</div>
                      </div>
                    </div>
                    <!--  | Button -->
                    <div class="form-group row"> 
                      <div class="col-md-4" style="margin-left:50%">
                        <button id="submit_data" name="submit_data" class="btn btn-success" type="submit">Submit</button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              <div class="modal-footer">  
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
        <!-- End Add Project Model -->
        <!-- Edit Project Model -->
        <div class="modal fade" id="editModal" role="dialog">
          <div class="modal-dialog" style="max-width:90%;margin: 30px auto;overflow-y: initial !important"> 
            <!-- Modal content-->
            <div class="modal-content">   
              <div class="modal-header">
                <h6 class="modal-title">Edit Infrastructure Project</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body" style=" max-height: calc(100vh - 200px);overflow-y: auto;">
                <form id="edit_data_form" action="">
                  <!-- Latitude | Text input-->
                  <div class="form-group row">
                    <label class="col-md-4 col-form-label" for="edi_lat">Latitude<span class="required">*</span></label>
                    <div class="col-md-4">
                      <input aria-describedby="latHelpBlock" id="edi_lat" name="edi_lat" type="number"  placeholder="latitude" class="form-control input-md" required step='.0001'>
                      <small id="edi_latHelpBlock" class="text-muted">eg: 13.0827</small>
                    </div>
                  </div>
                  <!-- Longitude | Text input-->
                  <div class="form-group row">
                    <label class="col-md-4 col-form-label" for="edi_long">Longitude<span class="required">*</span></label>
                    <div class="col-md-4">
                      <input aria-describedby="longHelpBlock" id="edi_long" name="edi_long" type="number" placeholder="Longitude" class="form-control input-md" required step='.0001'>
                      <small id="edi_longHelpBlock" class="text-muted">eg: 80.2707</small>
                    </div>
                  </div>            
                  <!-- Implementing Agency | Text input-->
                  <div class="form-group row">
                    <label class="col-md-4 col-form-label" for="edi_implementing_agency">Implementing Agency<span class="required">*</span></label>
                    <div class="col-md-4">
                      <input id="edi_implementing_agency" name="edi_implementing_agency" type="text" placeholder="Implementing Agency" class="form-control input-md" value="<?php echo $_SESSION['100c_user_info']['hod_name']; ?>" required>  
                    </div>
                  </div>
                  <!-- Department Name | Text input-->
                  <div class="form-group row">
                    <label class="col-md-4 col-form-label" for="edi_dept_name">Department Name<span class="required">*</span></label>
                    <div class="col-md-4">
                      <input id="edi_dept_name" name="edi_dept_name" type="text" placeholder="Department Name" class="form-control input-md" value="<?php echo $_SESSION['100c_user_info']['dept_name']; ?>" disabled required>
                    </div>
                  </div>
                  <!-- Project ID | Text input-->
                  <div class="form-group row">
                    <label class="col-md-4 col-form-label" for="edi_prj_id">Project ID<span class="required">*</span></label>
                    <div class="col-md-4">
                      <input id="edi_prj_id" name="edi_prj_id" type="text" placeholder="Project ID" class="form-control input-md" required>
                    </div>
                  </div>
                  <!-- Name of the Project | Textarea -->
                  <div class="form-group row">
                    <label class="col-md-4 col-form-label" for="edi_prj_name">Name of the Project<span class="required">*</span></label>
                    <div class="col-md-8">
                      <textarea class="form-control" id="edi_prj_name" name="edi_prj_name" placeholder="Project Name" required ></textarea>
                    </div>
                  </div>
                  <!-- Funding Agency | Text input-->
                  <div class="form-group row">
                    <label class="col-md-4 col-form-label" for="edi_fund_agency">Funding Agency<span class="required">*</span></label>
                    <div class="col-md-4">
                      <select id="edi_fund_agency" class="form-control input-md"  required>
                        <option  value="null">Select the funding Agency</option>
                        <option value="central">Central</option>
                        <option value="state">State</option>
                        <option value="out_agen">Loan from outside agency</option>
                        <option value="others">others</option>
                      </select>
                      <!-- <input id="edi_fund_agency" name="edi_fund_agency" type="text" placeholder="Funding Agency" class="form-control input-md" required> -->
                    </div>
                  </div>
                  <!-- Government orders | Text input-->
                  <div class="form-group row">
                    <label class="col-md-4 col-form-label" for="edi_gov_orders">Government orders</label>
                    <div class="col-md-4">
                      <input id="edi_gov_orders" name="edi_gov_orders" type="text" placeholder="Government orders" class="form-control input-md" >
                    </div>
                  </div>
                  <!-- Select the district | Select Multiple -->
                  <div class="form-group row">
                    <label class="col-md-4 col-form-label" for="edi_prj_dist">Select the district<span class="required">*</span></label>
                    <div class="col-md-5">
                      <input id="edi_prj_dist" name="edi_prj_dist"  class="form-control typeahead tm-input form-control tm-input-info" placeholder="search district">  
                    </div>
                  </div>
                  <!-- Select the taluk | Select Multiple -->
                  <div class="form-group row">
                    <label class="col-md-4 col-form-label" for="edi_prj_taluk">Select the Taluk<span class="required">*</span></label>
                    <div class="col-md-5">
                      <input id="edi_prj_taluk" name="edi_prj_taluk"  class="form-control typeahead tm-input form-control tm-input-info" placeholder="search taluk" > 
                    </div>
                  </div>
                  <!-- Select the Village | Select Multiple -->
                  <div class="form-group row">
                    <label class="col-md-4 col-form-label" for="edi_prj_vill">Select the Village<span class="required">*</span></label>
                    <div class="col-md-5">
                      <input id="edi_prj_vill" name="edi_prj_vill"  class="form-control typeahead tm-input form-control tm-input-info" placeholder="search village" >  
                    </div>
                  </div>
                  <!-- Survey Numbers | Textarea -->
                  <div class="form-group row">
                    <label class="col-md-4 col-form-label" for="edi_survey_no">Survey Numbers<span class="required">*</span></label>
                    <div class="col-md-8">
                      <textarea class="form-control" id="edi_survey_no" name="edi_survey_no" required></textarea>
                    </div>
                  </div>
                  <!-- Short Description of the Project | Textarea -->
                  <div class="form-group row">
                    <label class="col-md-4 col-form-label" for="edi_prj_desc">Short Description of the Project<span class="required">*</span></label>
                    <div class="col-md-8">
                      <textarea class="form-control" id="edi_prj_desc" name="edi_prj_desc" placeholder="project description" required></textarea>
                    </div>
                  </div>
                  <!-- Project Start Agency | Text input-->
                  <div class="form-group row">
                    <label class="col-md-4 col-form-label" for="edi_start_date">Project Start Date</label>
                    <div class="col-md-4">
                      <input id="edi_start_date" name="edi_start_date" type="date"  class="form-control input-md">
                    </div>
                  </div>
                  <!-- Project End Date | Text input-->
                  <div class="form-group row">
                    <label class="col-md-4 col-form-label" for="edi_end_date">Project End Date</label>
                    <div class="col-md-4">
                      <input id="edi_end_date" name="edi_end_date" type="date"  class="form-control input-md">
                    </div>
                  </div>  
                  <!-- Project Cost(in Crores) | Text input-->
                  <div class="form-group row">
                    <label class="col-md-4 col-form-label" for="edi_prj_cost">Project Cost(in Crores)<span class="required">*</span></label>
                    <div class="col-md-4">
                      <input id="edi_prj_cost" name="edi_prj_cost" type="number" placeholder="" class="form-control input-md" required step=any >
                    </div>
                  </div>
                  <!-- Fund Received | Text input-->
                  <div class="form-group row">
                    <label class="col-md-4 col-form-label" for="edi_fund_recieved">Fund Received<span class="required">*</span></label>
                    <div class="col-md-4">
                      <input id="edi_fund_recieved" name="edi_fund_recieved" type="number" placeholder="" class="form-control input-md" step=any required>
                    </div>
                  </div>
                  <!-- Fund yet to be received | Text input-->
                  <div class="form-group row">
                    <label class="col-md-4 col-form-label" for="edi_fund_yet_to_received">Fund yet to be received<span class="required">*</span></label>
                    <div class="col-md-4">
                      <input id="edi_fund_yet_to_received" name="edi_fund_yet_to_received" type="number" placeholder="" class="form-control input-md" step=any required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-md-4 col-form-label" for="edi_cost_overrun">Cost overrun</label>
                    <div class="col-md-4">
                      <input id="edi_cost_overrun" name="edi_cost_overrun" type="number" step=".01"placeholder="0.00" class="form-control input-md" >
                    </div> <span> Crore Rupees</span>
                  </div>
                  <div class="form-group row" id="div_reason_for_cost_overrun">
                    <label class="col-md-4 col-form-label" for="edi_reason_for_cost_overrun">Reasons for cost overrun<span>*</span></label>
                    <div class="col-md-4">
                      <input id="edi_reason_for_cost_overrun" name="edi_reason_for_cost_overrun" type="text" placeholder="Reasons for cost overrun" class="form-control input-md">
                    </div>
                  </div>
                  <!-- photo_prior| Text input-->
                  <div class="form-group row">
                    <label class="col-md-4 col-form-label" for="edi_photo_prior">Photo prior to commencement of work</label>
                    <div class="col-md-8">
                      <img id="edi_photo_prior" style="width:200px;height150px" src=""/>
                      <input id="edi_photo_prior_replace" name="edi_photo_prior_replace" type="file" placeholder="" class="form-control input-md" onchange="encodeImageFileAsURL3(this)">
                      <small  class="text-muted">supported formats: jpeg, png, gif</small>   
                    </div>
                  </div>
                  <!-- Work completed details with extent | Text input-->
                  <div class="form-group row">
                    <label class="col-md-4 col-form-label" for="edi_work_completed">Work completed details with extent<span class="required">*</span></label>
                    <div class="col-md-8">
                      <textarea id="edi_work_completed" name="edi_work_completed" type="text" placeholder="" class="form-control input-md" required></textarea>
                    </div>
                  </div>
                  <!-- Work in progress details with extent | Text input-->
                  <div class="form-group row">
                    <label class="col-md-4 col-form-label" for="edi_work_in_progress">Work in progress details with extent<span class="required">*</span></label>
                    <div class="col-md-8">
                      <textarea id="edi_work_in_progress" name="edi_work_in_progress" type="text" placeholder="" class="form-control input-md" required></textarea>
                    </div>
                  </div>     
                  <!-- work to be completed details with extent | Text input-->
                  <div class="form-group row">
                    <label class="col-md-4 col-form-label" for="edi_work_to_be_completed">work to be completed details with extent<span class="required">*</span></label>
                    <div class="col-md-8">
                      <textarea id="edi_work_to_be_completed" name="edi_work_to_be_completed" type="text" placeholder="" class="form-control input-md" required></textarea>                  
                    </div>
                  </div>
                  <!-- Total project extend | Text input-->
                  <div class="form-group row">
                    <label class="col-md-4 col-form-label" for="edi_total_project_extend">Total project extend<span class="required">*</span></label>
                    <div class="col-md-8">
                      <textarea id="edi_total_project_extend" name="edi_total_project_extend" type="text" placeholder="project extend" class="form-control input-md" required></textarea>
                    </div>
                  </div>
                  <!-- photo_current| Text input-->
                  <div class="form-group row">
                    <label class="col-md-4 col-form-label" for="edi_photo_current">Current status photo<span class="required">*</span></label>
                    <div class="col-md-8">
                      <img id="edi_photo_current" style="width:200px;height150px" src=""/>
                      <input id="edi_photo_current_replace" name="edi_photo_current_replace" type="file" placeholder="" class="form-control input-md" onchange="encodeImageFileAsURL4(this)" required>
                      <small  class="text-muted">supported formats: jpeg, png, gif</small>  
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-md-4 col-form-label" for="edi_present_status">Present Status<span class="required">*</span></label>
                    <div class="col-md-4">
                      <!-- <input id="edi_present_status" name="edi_present_status" type="text" placeholder="Present Status" class="form-control input-md" required> -->
                      <select id="edi_present_status" name="edi_present_status" type="text" placeholder="Present Status" class="form-control input-md" required="">
                            <option value="0">Select the Status of the work</option>
                            <option value="1">Completed</option>
                            <option value="2">In progress</option>
                            <option value="3">Yet to be started</option>
                            <option value="4">Others</option>
                          </select>

                    </div>
                  </div>
                  <!-- remarks | Textarea -->
                  <div class="form-group row">
                    <label class="col-md-4 col-form-label" for="edi_remarks">Remarks<span class="required">*</span></label>
                    <div class="col-md-8">
                      <textarea class="form-control" id="edi_remarks" name="edi_remarks" required></textarea>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-md-4 col-form-label" for="edi_causes_of_delay">Causes of Delay</label>
                    <div class="col-md-4">
                      <select class="form-control input-md" id="edi_causes_of_delay" name="edi_causes_of_delay">
                        <option value="" selected="selected">Select</option>
                        <?php
                        $opt = '';
                        if(count($causes_of_delay) > 0){
                          for($i = 0;$i<count($causes_of_delay);$i++) {
                            $opt .= '<option value="'.$causes_of_delay[$i]['delay_id'].'">'.$causes_of_delay[$i]["delay_desc"].'</option>';
                          }
                          echo $opt;
                        }
                        ?>
                      </select> 
                    </div>
                  </div>
                  <div id= "edi_divIfDelayed">
                    <!-- Project Extend of time | Text input-->
                    <div class="form-group row">
                      <label class="col-md-4 col-form-label" for="edi_extend_date">Extend of Date</label>
                      <div class="col-md-4">
                        <input id="edi_extend_date" name="edi_extend_date" type="date"  class="form-control input-md">
                      </div>
                    </div>  
                    <div class="form-group row">
                      <label class="col-md-4 col-form-label" for="edi_revised_start_date">Revised Project Start Date</label>
                      <div class="col-md-4">
                        <input id="edi_revised_start_date" name="edi_revised_start_date" type="date"  class="form-control input-md"> 
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-md-4 col-form-label" for="edi_revised_end_date">Revised Project End Date</label>
                      <div class="col-md-4">
                        <input id="edi_revised_end_date" name="edi_revised_end_date" type="date"  class="form-control input-md">  
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-md-4 col-form-label" for="edi_present_status">Time overrun<span class="required">*</span></label>
                      <div class="col-md-4">
                        <input id="edi_time_overrun" name="edi_time_overrun" type="number" placeholder="0" class="form-control input-md" >
                      </div> <span> Days</span>
                    </div>
                  </div>
                  <div class="form-group row"  id="divEditDelayOtherReason">
                    <label class="col-md-4 col-form-label" for="edi_delay_other_reason">Other Reasons for causes of delay<span class="required">*</span></label>
                    <div class="col-md-4">
                      <input id="edi_delay_other_reason" name="edi_delay_other_reason" type="text" placeholder="Other Reasons" class="form-control input-md">
                    </div>
                  </div>
                  <!--show shapefiles -->
                  <div class="form-group row">
                    <label class="col-md-4 col-form-label" for="">Shapefiles</label>
                    <div class="col-md-8">
                      <div id="edi_layers_div">

                      </div>
                      <small id="" class="text-muted">shapefile compressed with .zip(containing .shp, .prj, .shx, .dbf)</small>
                    </div>
                  </div>
                  <!-- Shapefile Import | files -->   
                  <div id="edi_upload-progress-bar" class="form-group col-sm-12" style="display:none">
                    <div class="progress">
                      <div class="edi_progress-bar bg-primary edi_upload-progress text-center" role="progressbar" style="width:0%">0%</div>
                    </div>
                  </div>
                  <!--  | Button -->
                  <div class="form-group row"> 
                    <div class="col-md-4" style="margin-left:50%">
                      <button id="update_data" name="update_data" class="btn btn-success" type="submit">Update</button>
                    </div>
                  </div>
                </form>
                <div class="modal-footer"> 
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Edit project model -->
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
                    columns: [0,1,2,3,4,5]
                }
            },
            "csv",
            {
              extend: 'excelHtml5',
              autoFilter: true,
              sheetName: '<?php echo $hod_dept; ?>',
              exportOptions: {
                columns: [0,1,2,3,4,5]
              }
            }, 
            {
              extend: 'pdfHtml5',
              exportOptions: {
                columns: [0,1,2,3,4,5]
              }
            }, 
            {
              extend: 'print',
              exportOptions: {
                columns: [0,1,2,3,4,5]
              }
            },
            "colvis",
            
      ]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  });
</script>
<!-- Add Projects -->
<script type="text/javascript">
  $("#divDelayOtherReason").hide();
  //Add Project.
  $("#lat").change(function(){
    $("#lat-err").text("");
  });
  $("#long").change(function(){
    $("#lon-err").text("");
  });
  $("#implementing_agency").change(function(){
    $("#impl-agency-err").text("");
  });
  $("#dept_name").change(function(){
    $("#dept-name-err").text("");
  });
  $("#prj_id").change(function(){
    $("#prj-id-err").text("");
  });
  $("#prj_name").change(function(){
    $("#prj-name-err").text("");
  });
  $("#fund_agency").change(function(){
    $("#fund-agency-err").text("");
  });
  $("#prj_desc").change(function(){
    $("#prj-desc-err").text("");
  });
  $("#start_date").change(function(){
    $("#start-date-err").text("");
  });
  $("#end_date").change(function(){
    $("#end-date-err").text("");
  });
  $("#prj_cost").change(function(){
    $("#prj-cost-err").text("");
  });
  $("#fund_received").change(function(){
    $("#fund-received-err").text("");
  });
  $("#fund_yet_to_received").change(function(){
    $("#fund-yet-to-received-err").text("");
  });
  $("#prj_dist").change(function(){
    $("#prj-dist-err").text("");
  });
  $("#prj_taluk").change(function(){
    $("#prj-taluk-err").text("");
  });
  $("#prj_vill").change(function(){
    $("#prj-village-err").text("");
  });
  $("#survey_no").change(function(){
    $("#survey-no-err").text("");
  });
  $("#total_project_extend").change(function(){
    $("#total-prj-extend-err").text("");
  });
  $("#work_completed").change(function(){
    $("#work-completed-err").text("");
  });
  $("#work_in_progress").change(function(){
    $("#work-inprog-err").text("");
  });
  $("#work_to_be_completed").change(function(){
    $("#work-to-be-completed-err").text("");
  });
  $("#photo_prior").change(function(){
    $("#photo-prior-err").text("");
  });
  $("#photo_current").change(function(){
    $("#photo-current-err").text("");
  });
  $("#present_status").change(function(){
    $("#present-status-err").text("");
  });
  $("#remarks").change(function(){
    $("#remarks-err").text("");
  });

  // Show Popup
  function add_prj() {
    $('#myModal').modal('show');
    $('#submit_data').attr('disabled', false);
    resetProgressBar();
  }
  function resetProgressBar() {
    $('.upload-progress').removeClass('bg-danger').removeClass('bg-success').addClass('bg-primary');
    $('.upload-progress').css('width', '0');
    $('#upload-progress-bar').hide();
  }
  // Check Lat & Long
  $("#checkLatLong").click(function(){ 
    var lat = $("#lat").val().trim();
    var lon = $("#long").val().trim();
    if(lat == null || lat == ""){
      $("#lat-err").text("Please enter Latitude.");
      return false;
    }
    if(lon == null || lon == ""){
      $("#lon-err").text("Please enter Longitude.");
      return false;
    } 
    $.ajax({
      url: 'php/function.php',
      type: 'POST',
      data: 'lat=' + lat +'&lon=' + lon +'&case=checkLatLong',
      success: function (data) {     
        if (data == '"t"') {
          $.notify({
            title: '<strong>SUCESS!!!</strong>',
            message: 'Latitude and Longitude are correct'
            },{
            type: 'success',
            z_index: 2000,
          });
          $("#lat").attr('onkeydown', 'return false');
          $("#long").attr('onkeydown', 'return false');       
          $('#checkLatLong').hide();
          $('#prj_particulars').show();          
        }else{
          $.notify({
            title: '<strong>INVALID!!!</strong>',
            message: 'Latitude and Longitude are not Valid'
            },{
            type: 'danger',
            z_index: 2000,
          });  
        }
      }
    });
  });

  var d_tags = $("#prj_dist").tagsManager();
  jQuery("#prj_dist").typeahead({
    source: function (query, process) {
      return $.post('php/function.php', { query: query, 'case': 'loadDist'}, function (data) {
        data = $.parseJSON(data);
        return process(data);
      });
    },
    afterSelect :function (item){
      d_tags.tagsManager("pushTag", item);
    }
  }); 
  var t_tags = $("#prj_taluk").tagsManager();
  jQuery("#prj_taluk").typeahead({
    source: function (query, process) {
      return $.post('php/function.php', { query: query, 'case': 'loadTaluk', 'd':$('input[name=hidden-prj_dist]').val()}, function (data) {
        data = $.parseJSON(data);
        return process(data);
      });
    },
    afterSelect :function (item){
      t_tags.tagsManager("pushTag", item);
    }
  });
  
  var v_tags = $("#prj_vill").tagsManager();
  jQuery("#prj_vill").typeahead({
    source: function (query, process) {
      return $.post('php/function.php', { query: query, 'case': 'loadVill', 't':$('input[name=hidden-prj_taluk]').val()}, function (data) {
        data = $.parseJSON(data);
        return process(data);
      });
    },
    afterSelect :function (item){
      v_tags.tagsManager("pushTag", item);
    }
  });
  //Save Project
  $( "#data_form" ).on( "submit", function( event ) {
    event.preventDefault();
    if ($('#fund_recieved').val() != ""){
      if ($('#prj_cost').val() != (parseFloat($('#fund_recieved').val()) + parseFloat($('#fund_yet_to_received').val()))){       
        alert('In valid Funds data');
        return;     
      }
    }
    if ($('#shp_import').val() && $('#shp_import').val() != "") {
      var shp1 = Math.round((document.getElementById('shp_import').files[0].size/ 1024));
      var type1 = document.getElementById('shp_import').files[0].type;
      if (shp1 > 50000){     
        alert('Shape File size exceeds(upload less than 50 mb)');
        return;     
      }  
      if (type1 != 'application/x-zip-compressed'){   
        alert('Invalid Shapefile');
        return;  
      }
    }
    if ($('#shp_import_2').val() && $('#shp_import_2').val() != "") {
      var shp2 = Math.round((document.getElementById('shp_import_2').files[0].size/ 1024));
      var type2 = document.getElementById('shp_import_2').files[0].type;
      if (shp2 > 50000){   
        alert('Shape File size exceeds(upload less than 50 mb)');
        return;  
      }
      if (type2 != 'application/x-zip-compressed'){
        alert('Invalid Shapefile');
        return;
      }
    }
    if ($('#shp_import_3').val() && $('#shp_import_3').val() != "") {
      var shp3 = Math.round((document.getElementById('shp_import_3').files[0].size/ 1024));
      var type3 = document.getElementById('shp_import_3').files[0].type;
      if (shp3 > 50000){   
        alert('Shape File size exceeds(upload less than 50 mb)');
        return;  
      } 
      if (type3 != 'application/x-zip-compressed'){   
        alert('Invalid Shapefile');
        return; 
      }
    }
    $('#submit_data').attr('disabled', true);
    var data =  new FormData(this);
    var fun_agency =  $('#fund_agency option:selected').text();
    var present_status =  $('#present_status option:selected').text();
    data.append( 'fun_agency', fun_agency);
    data.append( 'present_status', present_status);
    data.append( 'image1', image1);
    data.append( 'image2', image2);
    data.append( 'case', 'enterData');
    $.ajax({
      url: 'php/function.php',
      type: 'POST',
      data: data,
      dataType: 'json',
      contentType: false,
      cache: false,
      processData:false,
      xhr: function () {
        var xhr = new window.XMLHttpRequest();
        xhr.upload.addEventListener("progress", function (evt) {
          if (evt.lengthComputable) {
            resetProgressBar();
            $('#upload-progress-bar').show(); 
            var percentComplete = evt.loaded / evt.total;
            percentComplete = parseInt(percentComplete * 100);
            $('.upload-progress').text(percentComplete + '%');
            $('.upload-progress').css('width', percentComplete + '%'); 
            if (percentComplete >= 100) {
              $('.upload-progress').text('Processing...');
            }
          }
        }, false);
        return xhr;
      },
      success: function (response) { 
        $('.upload-progress').text('Completed');
        $('.progress-bar').addClass('bg-success').removeClass('bg-primary');
        if (response.upload_message == null){
          response.upload_message = "";
        }
        if (response.upload_message1 == null){
          response.upload_message1 = "";
        }
        if (response.upload_message2 == null){
          response.upload_message2 = "";
        }
        if (response.upload_message == null && response.upload_message1 == null && response.upload_message2 == null){ 
          response.upload_message = "No GIS Data";
        }
        $.notify({
          title: '<strong>Upload Messege</strong>',
          message: response.upload_message + response.upload_message1 + response.upload_message2
          },{
          type: 'success',
          z_index: 2000,
          hideDuration: 5000
        });
        $.notify({
          title: '<strong>Attribute Messege</strong>',
          message: response.attr_insert_message
          },{
          type: 'success',
          z_index: 2000,
          hideDuration: 5000
        });
        $("#prj_dist").tagsManager('empty');
        $("#prj_taluk").tagsManager('empty');
        $("#prj_vill").tagsManager('empty');
        $('#data_form').trigger("reset");
        $('#prj_particulars').hide();
        $("#lat").attr('onkeydown', 'return true');
        $("#long").attr('onkeydown', 'return true');
        location.reload(false);
      }
    })  
  });

  var image1,image2,image3,image4;
  function encodeImageFileAsURL(element) {
    var file = element.files[0];
    var reader = new FileReader();
    var fileType = file["type"];
    var size = Math.round((file['size'] / 1024));
    //console.log(size);
    var validImageTypes = ["image/gif", "image/jpeg", "image/png"];
    if ($.inArray(fileType, validImageTypes) < 0 ) {
      $('#photo_prior').val('');
      alert('Not a Valid image file');
      return;  
    }
    if (size > 15000) {
      $('#photo_prior').val('');
      alert('Image File size exceeds');
      return; 
    }
    reader.onloadend = function() { 
      image1 = reader.result;
    }
    reader.readAsDataURL(file);
  }
  function encodeImageFileAsURL1(element) {
    var file = element.files[0];
    var reader = new FileReader();
    var fileType = file["type"];
    var size = Math.round((file['size'] / 1024));
    var validImageTypes = ["image/gif", "image/jpeg", "image/png"];
    if ($.inArray(fileType, validImageTypes) < 0) {
      $('#photo_current').val('');
      alert('Not a Valid image file');
      return;
    }
    if (size > 15000) {
      $('#photo_prior').val('');
      alert('Image File size exceeds');
      return;  
    }
    reader.onloadend = function() { 
      image2 = reader.result;
    }
    reader.readAsDataURL(file);
  }
  function encodeImageFileAsURL3(element) {
    var file = element.files[0];
    var reader = new FileReader();
    var fileType = file["type"];
    var size = Math.round((file['size'] / 1024));
    var validImageTypes = ["image/gif", "image/jpeg", "image/png"];
    if ($.inArray(fileType, validImageTypes) < 0 ) {
      $('#photo_prior').val('');
      alert('Not a Valid image file');
      return;
    }
    if (size > 15000) {
      $('#photo_prior').val('');
      alert('Image File size exceeds');
      return;      
    }  
    reader.onloadend = function() {  
      image3 = reader.result;
    }
    reader.readAsDataURL(file);
  } 
  function encodeImageFileAsURL4(element) {
    var file = element.files[0];
    var reader = new FileReader();
    var fileType = file["type"];
    var size = Math.round((file['size'] / 1024));
    var validImageTypes = ["image/gif", "image/jpeg", "image/png"];
    if ($.inArray(fileType, validImageTypes) < 0 ) {
      $('#photo_prior').val('');
      alert('Not a Valid image file');
      return;
    }   
    if (size > 15000) {
      $('#photo_prior').val('');
      alert('Image File size exceeds');
      return;     
    }   
    reader.onloadend = function() {     
      image4 = reader.result;
    }
    reader.readAsDataURL(file);
  }

  function addFiles(e) {
    var len = $("input[id^='shp_import']").length;
    if (len == 3){
      alert("Maximum 3 files")
      return;
    }
    var id = len + 1;
    var a_id = "shp_import_"+id;
    $('#shp_div').append('<span></br><input name="'+a_id+'" type="file" id="'+a_id+'" /><button type="button" class="btn btn-danger btn-sm" id="delete" title="Delete file">Delete file</button></span>');
  }
  // Delete row
  $('#shp_div').on('click', "#delete", function(e) {
    if (!confirm("Are you sure you want to delete this file?"))
    return false;
    $(this).closest('span').remove();
    e.preventDefault();
  });

</script>
<!-- Edit Projects -->
<script type="text/javascript">
  var edit_id;
  function editPrj(id){
    resetEditProgressBar();
    $('#editModal').modal('show');
    $('#update_data').attr('disabled',false);
    $("#divEditDelayOtherReason").hide();
    $("#div_reason_for_cost_overrun").hide();
    $("#edi_reason_for_cost_overrun").removeClass("required");
    $("#edi_divIfDelayed").hide();
    var selectedFundAgencyElement=document.getElementById("edi_fund_agency");
    var editPresentStatusElement=document.getElementById("edi_present_status");
    var fun_agency =  $('#edi_fund_agency option:selected').text();
    var present_status =  $('#edi_present_status option:selected').text();
    edit_id = id;
    $.ajax({
      url: 'php/function.php',
      type: 'POST',
      data: 'id='+ id +'&case=getValues',
      success: function (response) {    
        var output = $.parseJSON(response);
        console.log(output);    
        $('#edi_lat').val(output.latitude);
        $('#edi_long').val(output.longitude);
        $('#edi_implementing_agency').val(output.implementing_agency);
        $('#edi_dept_name').val(output.department_name);
        $('#edi_prj_id').val(output.project_id);
        $('#edi_prj_name').val(output.name_of_the_project);
        switch (output.funding_agency) { 
          case 'Central':
            selectedFundAgencyElement.selectedIndex=1;
            break;
          case 'State':selectedFundAgencyElement.selectedIndex=2;break;
          case 'Loan from outside agency':selectedFundAgencyElement.selectedIndex=3;break;
          case 'others':selectedFundAgencyElement.selectedIndex=3;break;
          default:
            selectedFundAgencyElement.selectedIndex=0;break;
        };
        // $('#edi_fund_agency').val(output.funding_agency);
        $('#edi_gov_orders').val(output.government_orders);
        $('#edi_prj_desc').val(output.short_description_of_the_project);
        $('#edi_start_date').val(output.project_start_date);
        $('#edi_end_date').val(output.project_end_date);
        $('#edi_prj_cost').val(output.project_cost)
        $('#edi_fund_recieved').val(output.fund_received);
        $('#edi_fund_yet_to_received').val(output.fund_yet_to_be_received);
        //$('#edi_prj_dist').val(output.district_name);
        $('#edi_survey_no').val(output.survey_no);
        $('#edi_total_project_extend').val(output.total_project_extend);
        $('#edi_work_completed').val(output.work_completed_details_with_extend);
        $('#edi_work_in_progress').val(output.work_in_progress_details_with_extend);
        $('#edi_work_to_be_completed').val(output.work_to_be_completed_details_with_extend);
        $('#edi_photo_prior').attr('src', output.photo_prior_to_commencement_of_work);
        $('#edi_photo_current').attr('src', output.photo_current_status);
        $('#edi_remarks').val(output.remarks);  
        $('#edi_extend_date').val(output.eot);  

        $("#edi_revised_start_date").val(output.revised_start_date);
        $("#edi_revised_end_date").val(output.revised_end_date);
        switch (output.present_status) {
          case 'Completed':
            editPresentStatusElement.selectedIndex=1;
            break;
          case 'In progress':editPresentStatusElement.selectedIndex=2;break;
          case 'Yet to be started':editPresentStatusElement.selectedIndex=3;break;
          case 'Others':editPresentStatusElement.selectedIndex=3;break;
          default:
            editPresentStatusElement.selectedIndex=0;break;
        };
        // $("#edi_present_status").val(output.present_status);
        $("#edi_causes_of_delay").val(output.causes_of_delay);
        if(!(output.causes_of_delay === "null" || output.causes_of_delay === null || output.causes_of_delay === "")){
          $("#edi_divIfDelayed").show();
          if(output.causes_of_delay == 8){
            $("#divEditDelayOtherReason").show();
            $("#edi_delay_other_reason").val(output.other_reasons_delay);
          }
          var startDate = new Date($("#edi_end_date").val());
          var endDate = new Date();
          var timeOverRun = getDuration(endDate - startDate);
          $("#edi_time_overrun").val(timeOverRun.value);
        }else{
          $("#edi_divIfDelayed").hide();
          $("#divEditDelayOtherReason").hide();
          $("#edi_delay_other_reason").val("");
          $("#edi_causes_of_delay").val("");
        }
        $("#edi_causes_of_delay").change(function(){
          document.getElementById("causes_of_delay")
          var causes_of_delay = $(this).val().trim();
          if(!(causes_of_delay === "null" || causes_of_delay === null || causes_of_delay === "")){
            $("#edi_divIfDelayed").show();
            if(causes_of_delay == 8){
              $("#divEditDelayOtherReason").show();
              $("#edi_delay_other_reason").val(output.other_reasons_delay);
            }
            var startDate = new Date($("#edi_end_date").val());
            var endDate = new Date();
            var timeOverRun = getDuration(endDate - startDate);
            $("#edi_time_overrun").val(timeOverRun.value);
          }else {
            $("#edi_divIfDelayed").hide();
            $("#divEditDelayOtherReason").hide();
            $("#edi_delay_other_reason").val("");
            $("#edi_causes_of_delay").val("");
          }
        });
        $("#edi_cost_overrun").val('0.00');//val(output.cost_overrun);  
        if(!(output.cost_overrun === null || output.cost_overrun === "" || output.cost_overrun === 0)){
          $("#div_reason_for_cost_overrun").show();
          $("#div_reason_for_cost_overrun").val(output.cost_overrun_reasons);
        }
        $("#edi_reason_for_cost_overrun").addClass("required");
        $("#edi_cost_overrun").change(function(){
          var cost_overrun = $(this).val().trim();
          if(!(cost_overrun < 0.01)){
            $("#div_reason_for_cost_overrun").show();
            $("#edi_reason_for_cost_overrun").addClass("required");
            $("#div_reason_for_cost_overrun").val(output.cost_overrun_reason);
          } else{
            $("#div_reason_for_cost_overrun").hide();
            $("#edi_reason_for_cost_overrun").removeClass("required");
          }
        });
        console.log(output.district_name);
        output.district_name.split(',').forEach(add_tags.bind(null, '#edi_prj_dist'));
        output.taluk_name.split(',').forEach(add_tags.bind(null, '#edi_prj_taluk'));
        output.village_name.split(',').forEach(add_tags.bind(null, '#edi_prj_vill'));  
        var layers = output.layers;  
        if (layers == ""){
          $('#edi_layers_div').html('<p class="text-danger">No Layers</p>');
          $('#edi_layers_div').append('<input type="file" id="edi_shp_import" name="edi_shp_import_1" ><button class="btn btn-success btn-sm" type="button" id="edi_add" onClick="e_addFiles()">Add new file</button>');
        } 
        else {
          $('#edi_layers_div').html('<button class="btn btn-success btn-sm" type="button" id="edi_add" onClick="e_addFiles()">Add new file</button></br>');
          var layerArray = layers.split(',');
          layerArray.forEach(addLayerDiv.bind(null,output.latitude,output.longitude))
        }
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
        function addLayerDiv(lat,lon,value){
          
          //var id = "edi_shp_import_"+(layerArray.indexOf(value)+1);
          //$('#edi_layers_div').html('');
          //$('#edi_layers_div').append(value +'&nbsp<button class="btn-sm btn-primary" onClick=ShowLayers("'+value+'","'+lat+'","'+lon+'")>View LAYER</button>&nbsp<input type="file" id="'+ id +'" name="edi_shp_import"></br>');
          d_value = value.substring(0, value.length-14);
          var val = d_value +'&nbsp<button class="btn-sm btn-primary"  type="button" onClick=ShowLayers("'+value+'","'+lat+'","'+lon+'")>View LAYER</button>' 
          e_addFiles(val);
        }  
      }
    })   
  }

  var ed_tags = $("#edi_prj_dist").tagsManager();
  jQuery("#edi_prj_dist").typeahead({
    source: function (query, process) {
      return $.post('php/function.php', { query: query, 'case': 'loadDist'}, function (data) {
        data = $.parseJSON(data);
        return process(data);
      });
    },
    afterSelect :function (item){
      ed_tags.tagsManager("pushTag", item);
    }
  });
  var et_tags = $("#edi_prj_taluk").tagsManager();
  jQuery("#edi_prj_taluk").typeahead({
    source: function (query, process) {
      return $.post('php/function.php', { query: query, 'case': 'loadTaluk', 'd':$('input[name=hidden-edi_prj_dist]').val()}, function (data) {
        data = $.parseJSON(data);
        return process(data);
      });
    },
    afterSelect :function (item){
      et_tags.tagsManager("pushTag", item);
    }
  });
  var ev_tags = $("#edi_prj_vill").tagsManager();
  jQuery("#edi_prj_vill").typeahead({
    source: function (query, process) {
      return $.post('php/function.php', { query: query, 'case': 'loadVill','t':$('input[name=hidden-edi_prj_taluk]').val()}, function (data) {
        data = $.parseJSON(data);
        return process(data);
      });
    },
    afterSelect :function (item){
      ev_tags.tagsManager("pushTag", item);
    }
  });


  $( "#edit_data_form" ).on( "submit", function( event ) {
    event.preventDefault();
    if ($('#edi_shp_import_1').val() && $('#edi_shp_import_1').val() != "") {
      var shp1 = Math.round((document.getElementById('edi_shp_import_1').files[0].size/ 1024));
      var type1 = document.getElementById('edi_shp_import_1').files[0].type;
      if (shp1 > 50000){ 
        alert('Shape File size exceeds(upload less than 50 mb)');
        return; 
      }
      if (type1 != 'application/x-zip-compressed'){ 
        alert('Invalid Shapefile');
        return; 
      }
    }
    if ($('#edi_shp_import_2').val() && $('#edi_shp_import_2').val() != "") {
      var shp2 = Math.round((document.getElementById('edi_shp_import_2').files[0].size/ 1024));
      var type2 = document.getElementById('edi_shp_import_2').files[0].type;
      if (shp2 > 50000){   
        alert('Shape File size exceeds(upload less than 50 mb)');
        return;  
      }
      if (type2 != 'application/x-zip-compressed'){
        alert('Invalid Shapefile');
        return;
      }
    }
    if ($('#edi_shp_import_3').val() && $('#edi_shp_import_3').val() != "") {
      var shp3 = Math.round((document.getElementById('edi_shp_import_3').files[0].size/ 1024));
      var type3 = document.getElementById('edi_shp_import_3').files[0].type;
      if (shp3 > 50000){ 
        alert('Shape File size exceeds(upload less than 50 mb)');
        return; 
      }
      if (type3 != 'application/x-zip-compressed'){  
        alert('Invalid Shapefile');
        return;  
      }
    }
    //$('#update_data').attr('disabled', true);
    var data =  new FormData(this);
    var ed_fun_agency =  $('#edi_fund_agency option:selected').text();
    console.log(ed_fun_agency);
    var edi_present_status =  $('#edi_present_status option:selected').text();
    var edi_cost_overrun = $('#edi_cost_overrun').text();
    var edi_causes_of_delay = $('#edi_causes_of_delay').val();
    //data.append( 'image1', image1);
    //data.append( 'image2', image2);
    data.append( 'ed_fun_agency', ed_fun_agency);
    data.append( 'e_id', edit_id);
    data.append( 'case', 'editData');
    // data.append( 'image1', image3);
    data.append( 'image2', image4);
    data.append('edi_present_status', edi_present_status);
    data.append('cost_overrun', edi_cost_overrun);
    data.append('causes_of_delay',edi_causes_of_delay);
    $.ajax({
      url: 'php/function.php',
      type: 'POST',
      data: data,
      dataType: 'json',
      contentType: false,
      cache: false,
      processData:false, 
      xhr: function () {
        var xhr = new window.XMLHttpRequest();
        xhr.upload.addEventListener("progress", function (evt) {
          if (evt.lengthComputable) {
            resetEditProgressBar();
            $('#edi_upload-progress-bar').show();
            
            var percentComplete = evt.loaded / evt.total;
            percentComplete = parseInt(percentComplete * 100);
            $('.edi_upload-progress').text(percentComplete + '%');
            $('.edi_upload-progress').css('width', percentComplete + '%');
            
            
            if (percentComplete >= 100) {
              $('.edi_upload-progress').text('Processing...');
            }
          }
        }, false);
        return xhr;
      },
      success: function (response) {  
        $('.edi_upload-progress').text('Completed');
        $('.edi_progress-bar').addClass('bg-success').removeClass('bg-primary');
        if (response.upload_message == null){
          response.upload_message = "";
        }
        if (response.upload_message1 == null){
          response.upload_message1 = "";
        }
        if (response.upload_message2 == null){
          response.upload_message2 = "";
        }  
        $.notify({
          title: '<strong>Upload Messege</strong>',
          message: response.upload_message + response.upload_message1 + response.upload_message2
          },{
          type: 'success',
          z_index: 2000,
          hideDuration: 5000
        });
        
        $.notify({
          title: '<strong>Attribute Messege</strong>',
          message: response.attr_insert_message
          },{
          type: 'success',
          z_index: 2000,
          hideDuration: 5000
        }); 
        $("#prj_dist").tagsManager('empty');
        $("#prj_taluk").tagsManager('empty');
        $("#prj_vill").tagsManager('empty');
        //$('#edit_data_form').trigger("reset");
        //location.reload(false); 
      }
    })
  });

  function e_addFiles(name) {
    var len = $("input[id^='edi_shp_import']").length;
    if (len == 3){
      alert("Maximum 3 files")
      return;
    }
    var id = len + 1;
    var a_id = "edi_shp_import_"+id;
    if (!name){
      $('#edi_layers_div').append('<span></br><input name="'+a_id+'" type="file" id="'+a_id+'" /></span>');
    }else {  
      $('#edi_layers_div').append('<span></br>'+name+'<input name="'+a_id+'" type="file" id="'+a_id+'" /></span>');
    }
  }
  // Delete row
  $('#edi_layers_div').on('click', "#delete", function(e) {
    if (!confirm("Are you sure you want to delete this file?"))
    return false;
    $(this).closest('span').remove();
    e.preventDefault();
  });
  function resetEditProgressBar() {
    $('.edi_upload-progress').removeClass('bg-danger').removeClass('bg-success').addClass('bg-primary');
    $('.edi_upload-progress').css('width', '0');
    $('#edi_upload-progress-bar').hide();
  }
  function add_tags(id,value) {
    var tag = $(id).tagsManager();
    tag.tagsManager("pushTag", value); 
  }
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
    // map1.addLayer(raster);
    // map1.addLayer(satellite);
    addLayer('sp_water_bodies','Water Bodies',false);
    addLayer('sp_river','Rivers',false);
    addLayer('rv','Village',false);
    addLayer('sp_taluk','Taluk',true);
    addLayer('sp_district','District',true);
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
<!-- Delete Project -->
<script type="text/javascript">
  function deletePrj(id) {
    var result = confirm("Want to delete?");
    if (result) {
      delete_id = id;
      $.ajax({
        url: 'php/function.php',
        type: 'POST',
        data: 'id='+ delete_id +'&case=deletePrj',
        success: function (response) {    
          console.log(response);
          var html = JSON.parse(response);
          if(html.status == 1){
            alert("Deleted Successfully");
            location.reload(true); 
          }else if(html.status == 0){
            alert("Please try again.");
          }
        },
        error:function (err) {
          console.log(err);
          alert("Try Later");
        }
      })
    }
  }
</script>
</body>
</html>
