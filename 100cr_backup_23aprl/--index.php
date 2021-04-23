<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Major Infrastructure Projects of Tamil Nadu</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- IonIcons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini sidebar-collapse">
<div class="wrapper">
  
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.html" class="brand-link">
      <span class="brand-text font-weight-light">=</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
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
          <li class="nav-item">
            <a href="projects.php" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Projects
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
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0" style="text-align: center;">Major Infrastructure Projects of Tamil Nadu</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <!-- <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v3</li>
            </ol> -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Departments:</h3>
                    <span>
                      <select style="margin-left: -209px;">
                        <option>All</option>
                        <option>Energy Department</option>
                        <option>Highways Department</option>
                        <option>Housing & Urban Department</option>
                        <option>Industries Department</option>
                        <option>MAWS</option>
                        <option>Other Departments</option>
                      </select>
                    </span>
                    <a href="javascript:void(0);">...</a>
                </div>
              </div>
              <div class="card-body">
                <div class="position-relative mb-4">
                    <div class="row" style="padding-bottom: 10px;">
                      <div class="col-12">
                        Project Data Availability Status
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-12 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                          <div class="inner">
                            <h3>155</h3>
                            <p>Total number of projects</p>
                          </div>
                          <!-- <div class="icon">
                            <i class="ion ion-bag"></i>
                          </div> -->
                          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                      </div>
                      <!-- ./col -->
                      <div class="col-xs-12 col-6">
                      <!-- small box -->
                        <div class="small-box bg-success">
                          <div class="inner">
                            <h3>32</h3>
                            <p>Projects with both MIS and GIS data</p>
                          </div>
                          <!-- <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                          </div> -->
                          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                      </div>
                      <!-- ./col -->
                    </div>
                    <div class="row">
                      <div class="col-xs-12 col-6">
                      <!-- small box -->
                        <div class="small-box bg-warning" style="color: #fff !important">
                          <div class="inner">
                            <h3>16</h3>
                            <p>Projects with only MIS data</p>
                          </div>
                          <!-- <div class="icon">
                            <i class="ion ion-person-add"></i>
                          </div> -->
                          <a href="#" class="small-box-footer" style="color:#fff !important">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                      </div>
                      <!-- ./col -->
                      <div class="col-xs-12 col-6">
                      <!-- small box -->
                        <div class="small-box bg-danger">
                          <div class="inner">
                            <h3>107</h3>
                            <p>Projects with no data</p>
                          </div>
                          <!-- <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                          </div> -->
                          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                      </div>
                      <!-- ./col -->
                    </div>
                    <div class="row">
                      <div class="col-12">
                        Project Overdue Status
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-12">
                          <canvas id="chart1" data-height="400" class="bar-chart-ex chartjs"></canvas>
                      </div>
                    </div>

                </div>
              </div>
            </div>
            <!-- /.card -->
            
            <!-- /.card -->
          </div>
          <!-- /.col-md-6 -->
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Department-wise Project Data Availability Status</h3>
                  <a href="javascript:void(0);"><i class="ion ion-android-download"></i></a>
                </div>
              </div>
              <div class="card-body">
                <div class="position-relative mb-4">
                  <canvas id="chart" data-height="400" class="bar-chart-ex chartjs"></canvas>
                </div>
              </div>
            </div>
            <!-- /.card -->
            <div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Department-wise Project Data Updation Status</h3>
                    <a href="javascript:void(0);"><i class="ion ion-android-download"></i></a>
                </div>
              </div>
              <div class="card-body">
                <div class="position-relative mb-4">
                  <canvas id="chart2" data-height="400" class="bar-chart-ex chartjs"></canvas>
                </div>
              </div>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
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
<script src="assets/js/chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
<script>
    // Return with commas in between
      var numberWithCommas = function(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      };

    var gis_mis =[32,0,14,4,2,12,0] ;
    var mis = [16,0,6,0,4,6,0];
    var no_data = [107,41,10,5,1,40,10];
    var display = ['All Department','Energy','Highways','Housing & Urban','Industries','MAWS','Others'];
    var display1 = ['Overdue','In-progress','Completed'];
    // Chart.defaults.global.elements.rectangle.backgroundColor = '#FF0000';
    var bar_ctx = document.getElementById('chart');
    var bar_chart = new Chart(bar_ctx, {
        type: 'bar',
        data: {
            labels: display,
            datasets: [
            {
                label: 'No data',
                data: no_data,
                backgroundColor: "#DC3545",
                hoverBackgroundColor: "#BB2D3B",
                hoverBorderWidth: 2,
                hoverBorderColor: 'lightgrey',
            },
            {
                label: 'Only MIS data',
                data: mis,
                backgroundColor: "#FFC107",
                hoverBackgroundColor: "#D9A406",
                hoverBorderWidth: 2,
                hoverBorderColor: 'lightgrey'
            },
            {
                label: 'Both GIS & MIS data',
                data: gis_mis,
                backgroundColor: "#008000",
                hoverBackgroundColor: "#228B22",
                hoverBorderWidth: 2,
                hoverBorderColor: 'lightgrey'
            },            
            ]
        },
        options: {
          responsive: true,
          legend: {
                position: 'bottom',
            },
          animation: {
              duration: 10,
            },
            tooltips: {
          mode: 'label',
                callbacks: {
                  label: function(tooltipItem, data) {
                    return data.datasets[tooltipItem.datasetIndex].label + ": " + numberWithCommas(tooltipItem.yLabel);
                  }
                }
            },
            scales: {
                xAxes: [{
                  stacked: true,
                  gridLines: { display: false },
                }],
                yAxes: [{
                  stacked: true,
                  ticks: {
                  callback: function(value) { return numberWithCommas(value); },
              },
                }],
            }, // scales
            legend: {display: true},
            plugins: {
              datalabels: {
                display: true,
                align: 'center',
                anchor: 'center',
                color: '#fff'
              }
            },
        } // options
      });

    var bar_ctx1 = document.getElementById('chart1');
    var bar_chart1 = new Chart(bar_ctx1, {
        type: 'pie',
        data: {
            labels: display1,
            datasets: [
            {
                label: 'Project Overdue Status',
                data: [107,16,32],
                backgroundColor: [
                      '#DC3545',
                      '#FFC107',
                      '#008000',
                ],
            },       
            ]
        },
        options: {
          responsive: true,
          legend: {display: true},
        } // options
      });

    var bar_ctx2 = document.getElementById('chart2');
    var bar_chart2 = new Chart(bar_ctx2, {
        type: 'bar',
        data: {
            labels: display,
            datasets: [
            {
                label: '< 1 Month',
                data: no_data,
          backgroundColor: "#DC3545",
          hoverBackgroundColor: "#BB2D3B",
          hoverBorderWidth: 2,
          hoverBorderColor: 'lightgrey'
            },
            {
                label: '1-3 Months',
                data: mis,
          backgroundColor: "#FFC107",
          hoverBackgroundColor: "#D9A406",
          hoverBorderWidth: 2,
          hoverBorderColor: 'lightgrey'
            },
            {
                label: '> 3 Months',
                data: gis_mis,
          backgroundColor: "#008000",
          hoverBackgroundColor: "#228B22",
          hoverBorderWidth: 2,
          hoverBorderColor: 'lightgrey'
            },            
            ]
        },
        options: {
          responsive: true,
          legend: {
            position: 'bottom',
          },
          animation: {
              duration: 10,
            },
            tooltips: {
          mode: 'label',
                callbacks: {
                  label: function(tooltipItem, data) {
                    return data.datasets[tooltipItem.datasetIndex].label + ": " + numberWithCommas(tooltipItem.yLabel);
                  }
                }
            },
            scales: {
                xAxes: [{
                  stacked: true,
                  gridLines: { display: false },
                }],
                yAxes: [{
                  stacked: true,
                  ticks: {
                  callback: function(value) { return numberWithCommas(value); },
              },
                }],
            }, // scales
            legend: {display: true},
            plugins: {
              datalabels: {
                display: true,
                align: 'center',
                anchor: 'center',
                color: '#fff'
              }
            },
        } // options
      });
  </script>
</body>
</html>
