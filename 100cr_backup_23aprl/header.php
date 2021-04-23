<?php

if ($_SESSION['100c_user_info']['role'] == 11){

?>

<nav class="bg-dark text-center">
  <h4 class="text-white text-center" href="#"> <img src="<?php echo DOMAIN . 'images/logo.png'; ?>" width="70" height="70" class="d-inline-block align-top" alt=""> Major Infrastructure Projects of Tamil Nadu-Dashboard <img src="<?php echo DOMAIN . 'images/logo2.png'; ?>" width="70" height="70" class="" alt=""> <!--<span style="right:0px;position: absolute;"><a href="report.php" class="btn btn-primary" role="button"><i class="fa fa-list"></i> Reports</a><a href="logout.php" class="btn btn-danger" role="button"><i class="fa fa-sign-out"></i> Logout</a></span>--></h4>
  
 </nav>

 <?php
	}else{
 ?>


 <nav class="bg-dark text-center">
  <h4 class="text-white text-center" href="#"> <img src="<?php echo DOMAIN . 'images/logo.png'; ?>" width="70" height="70" class="d-inline-block align-top" alt=""><?php echo $_SESSION['100c_user_info']['hod_name']; ?><!--<img src="images/logo2.png" width="70" height="70" class="" alt=""> <span style="right:10px;position: absolute;top:10px"><a href="logout.php" class="btn btn-danger" role="button"><i class="fa fa-sign-out"></i> Logout</a></span>--></h4>
  
    </nav>

    <?php
}
    ?>