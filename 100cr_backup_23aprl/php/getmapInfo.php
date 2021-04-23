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
    $id = $data['uid'];

    $url = $data['url'];
     if ($k == 0)
    {

        $style = 'display:show';

    }

    else
    {

        $style = 'display:none';
    }

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
				
			}

			
			$query = pg_query(DBCON, "select * from sp_index_v2 where id = $id");
			
			$assoc = pg_fetch_assoc($query);
		}
			$view_id = $assoc['id'];
		   $lat = $assoc['latitude'];
		   $lon = $assoc['longitude'];
		   $layers = $assoc['layers'];
		   $class = $id . '_tr';
		   $project_name = $assoc['name_of_the_project'];
		   $prj_name = substr($project_name,0,14);
		   // $prj_name = substr($project_name, 15, strlen($project_name) -80);
		   $government_order =  $assoc['government_orders'];
		   $gov_order = substr($government_order,0,14); 

		   // $up_dte = substr($cql, 0, strlen($cql) - 4);
		  $html = "<table class='table table-bordered table-sm'><tr style='background-color:#85be00' onClick=toggle_popup('" . $id . "')><th colspan='2' style='text-align: center;color:#FFF'>".$assoc['department_name']."</th</tr>
		  <tr class = $class  style='background-color:#ffffff;$style'><td>Name</td><td title= '$project_name' >".$prj_name."...  </td></tr>
		  <tr class = $class  style='background-color:#ffffff;$style'><td>G.O.</td><td title= '$government_order' >".$gov_order."...  </td></tr>
		  <tr class = $class  style='background-color:#ffffff;$style'><td>Cost</td><td>".$assoc['project_cost']."</td></tr>
		  <tr class = $class  style='background-color:#ffffff;$style'><td>District</td><td>".$assoc['district_name']."</td></tr>
		  <tr class = $class  style='background-color:#ffffff;$style'><td>Status</td><td>&nbsp".$assoc['present_status']."</td></tr>
		  <tr class = text-center  style='background-color:#ffffff;$style'><td colspan=2><a href='search.php?proj_id=".$view_id."'>View More</td></tr>
		  <tr class = text-center style='background-color:#ffffff;$style'><td colspan=2><a href='#' onclick=ShowLayers('$layers','$lat','$lon')>Show Project Layers</td></tr>
		  </table>";
		   echo $html;
		  
echo "</div>";


}
}


?>
