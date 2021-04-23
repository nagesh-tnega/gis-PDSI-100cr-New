
<style>
  
 


</style>
<?php



if (!$_SESSION['100c_user_info']['role'] == 11){

	?>
	<nav class="navbar navbar-expand-sm bg-dark navbar-dark" style="padding:0 !important;margin-top:-7px;margin-bottom: 2px; ">
  <!-- Brand -->

  <!-- Links -->

  
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" href="<?php echo DOMAIN . 'dash.php';?>"><i class="fa fa-info-circle"></i>&nbsp;Dashboard</a>
    </li>
     <li class="nav-item">
    	<a class="nav-link" href="<?php echo DOMAIN . 'projects_management.php';?>">
        	<i class="fa fa-tasks"></i>&nbsp;Projects
      	</a>
    </li>

    <!-- Dropdown -->
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
        <i class="fa fa-list"></i>&nbsp;Reports
      </a>
      <div class="dropdown-menu">
       <a class="dropdown-item" href="<?php echo DOMAIN . 'reports/project_details.php';?>">Project Detailed Report</a>
        <a class="dropdown-item" href="<?php echo DOMAIN . 'reports/causes_of_delay.php';?>">Causes of Delay</a>
      </div>
    </li>
    <li class="nav-item" style="right:0px;position: absolute;"><a class="nav-link" href="<?php echo DOMAIN . 'logout.php';?>"><i class="fa fa-sign-out"></i>&nbsp;Logout</a></li>
  </ul>
</nav>
<?php
}else{?>


	<nav class="navbar navbar-expand-sm bg-dark navbar-dark" style="padding:0 !important;margin-top:-7px;margin-bottom: 2px;">
  <!-- Brand -->

  <!-- Links -->

  
  <ul class="navbar-nav" id="menu_list">
    <li class="nav-item">
      <a class="nav-link" href="<?php echo DOMAIN . 'dash.php';?>"><i class="fa fa-info-circle"></i>&nbsp;Dashboard</a>
    </li>
     <li class="nav-item">
    	<a class="nav-link" href="<?php echo DOMAIN . 'report.php';?>">
        	<i class="fa fa-tasks"></i>&nbsp;Projects
      	</a>
    </li>

    <!-- Dropdown -->
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-file-o"></i>&nbsp;Reports
      </a>
      <div class="dropdown-menu">
       <a class="dropdown-item" href="<?php echo DOMAIN . 'reports/project_details.php';?>">Project Details Report</a>
        <a class="dropdown-item" href="<?php echo DOMAIN . 'reports/causes_of_delay.php';?>">Causes of Delay</a>
        <a class="dropdown-item" href="<?php echo DOMAIN . 'reports/abstract_report.php';?>">Abstract Report</a>
      </div>
    </li>
	<li class="nav-item">
    	<a class="nav-link" href="<?php echo DOMAIN . 'bird_view.php';?>">
        	<i class="fa fa-map-o"></i>&nbsp;Bird View
      	</a>
    </li>

    <li class="nav-item" style="right:0px;position: absolute;"><a class="nav-link" href="<?php echo DOMAIN . 'logout.php';?>"><i class="fa fa-sign-out"></i>&nbsp;Logout</a></li>
  </ul>
</nav>
<?php
}?>




