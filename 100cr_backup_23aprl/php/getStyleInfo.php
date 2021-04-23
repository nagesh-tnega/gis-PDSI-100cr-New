<?php
require_once ('dbHandler.php');

 

header('Access-Control-Allow-Origin: *');

$geousername = GSUSER;

$geopassword = GSPASS;

$var = $_POST['pop_url'];

$json = json_decode($var, true);
$json = array_reverse($json);
$k = 0;
foreach ($json as $data)
{

   
    //$ln = $data['layer_name'];
    $id = $data['uid'];



   // $html = "<table class='table table-bordered table-sm'><tr style='' onClick=toggle_popup('" . $id . "')><th colspan='2' style='text-align: center;color:#FFF'>Layer Name : $ln</th></tr>";
    $url = $data['url'];
     $html = ''; 
	

    $info = array(
        'grant_type' => 'client_credentials'
    );
    $post_field_string = http_build_query($info, '', '&');
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_USERPWD, "$geousername:$geopassword");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_field_string);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HEADER, false);
    $exec = curl_exec($ch);
	

	


    curl_close($ch);

   
    if (trim($exec) == 'no features were found')
    {


        
    }
    else
    {  
		
        $response = explode("\n\r\n", $exec);

        $infodata = explode("\n", $response[0]);
		
		//print_r($infodata);
		
		$header = explode("\n", $response[0]);
		
		$len = sizeof($header) - 3;
		
		
		
		for ($x = 2;$x <= $len;$x++)
        {
		
		$ret = explode('=', $header[$x]);
		
		// var_dump($header);
		
		$array = explode(' ', $ret[0]);
		
		if ($array[0]=='id'){
				
				$id = $ret[1];
				
				//echo $id;
				
				
			}

			
			$query = pg_query(DBCON, "select * from sp_index_v2 where id=$id");
			
			
			
			$assoc = pg_fetch_assoc($query);
		}
		   $lat = $assoc['latitude'];
		   $lon = $assoc['longitude'];
		   $layers = $assoc['layers'];
		   // $up_dte = substr($cql, 0, strlen($cql) - 4);
		   
		   echo "<input id='high_id' type='text' value='$id' style='display:none'>";
		    echo "<p class='text-center bg-info mr-2'><b><i class='fa fa-briefcase' aria-hidden='true'></i> Project Details</b></p>&nbsp";
		    echo "<h6 class=' mr-3 font-italic text-primary'>".$assoc['name_of_the_project']."</h6>";
			if ($layers != '') {
			echo "<div class='text-center'><button class='btn-success' onClick = ShowLayers('$layers','$lat','$lon')>View GIS Layers</button></div>&nbsp";
			}

			echo "<div style='overflow:auto;height:70vh'><p class='text-left text-light bg-dark mr-2'><b>&nbspProject ID</b> : ".$assoc['project_id']."</p>";
			echo "<p class='text-left text-light bg-dark mr-2'><b>&nbspDepartment Name</b> : ".$assoc['department_name']."</p>";
			echo "<p class='text-left text-light bg-dark mr-2'><b>&nbsp<i class='fa fa-calendar-check-o' aria-hidden='true'></i>&nbspProject Start Date</b> : ".$assoc['project_start_date']."</p>";
			echo "<p class='text-left text-light bg-dark mr-2'><b>&nbsp<i class='fa fa-calendar-check-o' aria-hidden='true'></i>&nbspProject End Date</b> : ".$assoc['project_end_date']."</p>";
			echo "<p class='text-left text-light bg-dark mr-2'><b>&nbsp<i class='fa fa-wrench' aria-hidden='true'></i>&nbspImplementing Agency</b> : ".$assoc['implementing_agency']."</p>";
			echo "<p class='text-left text-light bg-dark mr-2'><b>&nbsp<i class='fa fa-credit-card' aria-hidden='true'></i>&nbspFunding Agency</b> : ".$assoc['funding_agency']."</p>";
						echo "<p class='text-left text-light bg-dark mr-2'><b>&nbsp<i class='fa fa-credit-card' aria-hidden='true'></i>&nbspPresent Status</b> : ".$assoc['present_status']."</p>";
			echo "</br><h5 class='text-center'><b>Location Details</b></h5>";
			echo "<p class='text-left text-light bg-dark mr-2'><b>&nbspDistrict</b> : ".$assoc['district_name']."</p>";
			echo "<p class='text-left text-light bg-dark mr-2'><b>&nbspTaluk</b> : ".$assoc['taluk_name']."</p>";
			echo "<p class='text-left text-light bg-dark mr-2'><b>&nbspVillages</b> : ".$assoc['village_name']."</p>";
			echo "<p class='text-left text-light bg-dark mr-2'><b>&nbsp<i class='fa fa-map-marker' aria-hidden='true'></i>&nbspLocation</b> : ".$assoc['latitude'].", ".$assoc['longitude']."</p>&nbsp";
			
			echo "<h5 class='text-center'><b>Cost</b></h5>";
			echo "<p class='text-center h4 text-warning'><i class='fa fa-inr' aria-hidden='true'></i>&nbsp".$assoc['project_cost']." Crores</p>&nbsp";
			echo "<h5 class='text-center'><b>Fund Recieved</b></h5>";
			if ($assoc['fund_received'] != ''){
			echo "<p class='text-center h4 text-warning'><i class='fa fa-inr' aria-hidden='true'></i>&nbsp".$assoc['fund_received']." Crores</p>&nbsp";
			}
			else {
				echo "<p class='text-center h4 text-danger'><i class='fa fa-exclamation' aria-hidden='true'></i>&nbspNot Updated</p>&nbsp";
			}
		echo "<h5 class='text-center'><b>Fund Yet To Be Recieved</b></h5>";	
		if ($assoc['fund_yet_to_be_received'] != ''){
			echo "<p class='text-center h4 text-warning'><i class='fa fa-inr' aria-hidden='true'></i>&nbsp".$assoc['fund_yet_to_be_received']." Crores</p>&nbsp";
			}
			else {
				echo "<p class='text-center h4 text-danger'><i class='fa fa-exclamation' aria-hidden='true'></i>&nbspNot Updated</p>&nbsp";
			}
			echo "<h5 class='text-center'><b>Cost overrun</b></h5>";	
			if ($assoc['cost_overrun'] != ''){
			echo "<p class='text-center h4 text-warning'><i class='fa fa-inr' aria-hidden='true'></i>&nbsp".$assoc['cost_overrun']." Crores</p>&nbsp";
			}
			else {
				echo "<p class='text-center h4 text-danger'><i class='fa fa-exclamation' aria-hidden='true'></i>&nbspNot Updated</p>&nbsp";
			}
echo "<h5 class='text-center'><b>Reasons for cost overrun</b></h5>";	
			if ($assoc['cost_overrun_reasons'] != ''){
			echo "<p class='text-center h4 text-warning'>&nbsp".$assoc['cost_overrun_reasons']." </p>&nbsp";
			}
			else {
				echo "<p class='text-center h4 text-danger'><i class='fa fa-exclamation' aria-hidden='true'></i>&nbspNot Updated</p>&nbsp";
			}
	echo "<h5 class='text-center'><b>Updated Date</b></h5>";	
			if ($assoc['updated_time'] != ''){
			echo "<p class='text-center h4 text-warning'>&nbsp".substr($assoc['updated_time'],0,11)." </p>&nbsp";
			}
			else {
				echo "<p class='text-center h4 text-danger'><i class='fa fa-exclamation' aria-hidden='true'></i>&nbspNot Updated</p>&nbsp";
			}

			echo "<p class='text-left font-italic'><b>Project Description</b> : <medium>".$assoc['short_description_of_the_project']."</medium></p>&nbsp";
			$img1 = $assoc['photo_prior_to_commencement_of_work'];
			$img2 = $assoc['photo_current_status'];
			
			
			if ($img1 != null) {
			echo "<p class='text-left font-italic'><b>Project Prior:</b></br>";
			echo "<img style='width:200px;height150px' src='$img1' onclick='openImg(this)' >";
	        }
			
			else {
				echo "<p class='text-left font-italic'><b>Project Prior:</b>  <span class='text-danger'> <i class='fa fa-exclamation' aria-hidden='true'></i> No Image added</span>";
				
			} 
			
		if ($img2 != null) {
			echo "<p class='text-left font-italic'><b>Current Status photo :</b></br>";
			echo "<img style='width:200px;height150px' src='$img2' onclick='openImg(this)' >";
			
		}
			else {
				echo "<p class='text-left font-italic'><b>Current Status photo :</b> <span class='text-danger'> <i class='fa fa-exclamation' aria-hidden='true'></i> No Image added</span>";
				
			}
			
			$go = $assoc['government_orders'];
		
		  if ($assoc['government_orders'] != ''){ 
		  echo "</br></br><p class='text-left font-italic'><b>Government Orders :</b> $go</p>";
		  }
		  
		  else 
		  {
			    echo "</br></br><p class='text-left font-italic'><b>Government Orders :</b> <span class='text-danger'> <i class='fa fa-exclamation' aria-hidden='true'></i>&nbspNot Updated</span></p>";
		  }
		  
		 
		
		  if ($assoc['total_project_extend'] != ''){ 
		  echo "</br></br><p class='text-left font-italic'><b>Total Project Extent : </b> &nbsp".$assoc['total_project_extend']."</p>";
		  }
		  
		  else 
		  {
			    echo "<p class='text-left font-italic'><b>Total Project Extent :</b> <span class='text-danger'> <i class='fa fa-exclamation' aria-hidden='true'></i>&nbspNot Updated</span></p>";
		  }
		   if ($assoc['work_completed_details_with_extend'] != ''){ 
		  echo "</br></br><p class='text-left font-italic'><b>Work completed details with extend : </b> &nbsp".$assoc['work_completed_details_with_extend']."</p>";
		  }
		  
		  else 
		  {
			    echo "<p class='text-left font-italic'><b>Work completed details with extend : </b> <span class='text-danger'> <i class='fa fa-exclamation' aria-hidden='true'></i>&nbspNot Updated</span></p>";
		  }
		  
	  if ($assoc['work_in_progress_details_with_extend'] != ''){ 
		  echo "</br></br><p class='text-left font-italic'><b>Work in progress details with extend :</b> &nbsp".$assoc['work_in_progress_details_with_extend']."</p>";
		  }
		  
		  else 
		  {
			    echo "<p class='text-left font-italic'><b>Work in progress details with extend : </b> <span class='text-danger'> <i class='fa fa-exclamation' aria-hidden='true'></i>&nbspNot Updated</span></p>";
		  }
		  
	 if ($assoc['work_to_be_completed'] != ''){ 
		  echo "</br></br><p class='text-left font-italic'><b>Work to be completed details with extend :</b> &nbsp".$assoc['work_to_be_completed']."</p>";
		  }
		  
		  else 
		  {
			    echo "<p class='text-left font-italic'><b>Work to be completed details with extend : </b> <span class='text-danger'> <i class='fa fa-exclamation' aria-hidden='true'></i>&nbspNot Updated</span></p>";
		  }
		  
	 if ($assoc['remarks'] != ''){ 
		  echo "<p class='text-left font-italic'><b>Remarks :</b> &nbsp".$assoc['remarks']."</p>";
		  }
		  
		  else 
		  {
			    echo "<p class='text-left font-italic'><b>Remarks : </b> <span class='text-danger'> <i class='fa fa-exclamation' aria-hidden='true'></i>&nbspNot Updated</span></p>";
		  }
		echo "</div>";


}
}


?>
