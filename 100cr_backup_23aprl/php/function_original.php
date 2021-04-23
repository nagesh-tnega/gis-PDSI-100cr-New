<?php
	include ('session.php');
	require_once ('dbHandler.php');
	require_once('../phpDoc/vendor/autoload.php');
	/* error_reporting(-1);
	ini_set('display_errors', 'on'); */

	
	if (isset($_POST['case']) || isset($_GET['case']))
	{
		if(isset($_POST['case'])){
			$case = $_POST['case'];
		}else if(isset($_GET['case'])){
			$case = $_GET['case'];
		}
		
		switch ($case)
		{
			case 'getDept':
            $getDept = getDept();
            echo json_encode($getDept);
			break;
			case 'getExtent':
            $getExtent = getExtent();
			echo json_encode($getExtent);
            break;
			case 'checkLatLong':
            $checkLatLong = checkLatLong();
			echo json_encode($checkLatLong);
            break;
			case 'fillValues':
            $fillValues = fillValues();
			echo json_encode($fillValues);
            break;
			case 'enterData':
            $enterData = enterData();
		    echo json_encode($enterData);
            break;
			case 'loadDist':
            $loadDist = loadDist();
			echo json_encode($loadDist);
            break;
			case 'loadTaluk':
            $loadTaluk = loadTaluk();
			echo json_encode($loadTaluk);
            break;
			case 'loadVill':
            $loadVill = loadVill();
			echo json_encode($loadVill);
            break;
			case 'getProjects':
            $getProjects = getProjects();
			//echo json_encode($getProjects);
            break;
			case 'viewContact':
            $viewContact = viewContact();
			
            break;
			case 'viewContactById':
            $viewContactById = viewContactById();
			
            break;
			case 'getHodProj':
            $getHodProj = getHodProj();
			//echo json_encode($getProjects);
            break;			
			case 'getValues':
            $getValues = getValues();
			echo json_encode($getValues);
            break;
			case 'editData':
            $editData = editData();
			echo json_encode($editData);
            break;
			case 'getInfo':
            $getInfo = getInfo();
			//echo json_encode($getInfo);
            break;
			case 'addContact':
			$addContact = addContact();
			echo json_encode($addContact);
            break;
			case 'ediContact':
			$ediContact = ediContact();
			echo json_encode($ediContact);
            break;		
			case 'delContact':
			$delContact = delContact();
			//echo json_encode($delContact);
            break;
			case 'getReport':
			$getReport = getReport();
			echo json_encode($getReport);
            break;
		    case 'getContInfo':
			$getContInfo = getContInfo();
			echo json_encode($getContInfo);
            break;
			case 'getAllExtent':
			$getAllExtent = getAllExtent();
			echo json_encode($getAllExtent);
            break;
            case 'getAllProjectDetailsForReport':
            $getAllProjectsReports = getAllProjectsForReports();
            echo json_encode($getAllProjectsReports);
            break;
           case 'downloadProjectReport':
            $downloadProjectReport = downloadProjectReport();
            break;
            case 'getCausesOfDelayReport':
            $getCausesOfDelayReport = getCausesOfDelayReport();
            echo json_encode($getCausesOfDelayReport);
            break;
            case 'getImplementingAgencyByDeptId':
            $getImplAgency = getImplementingAgencyByDeptId();
            echo json_encode($getImplAgency);
            break;
            case 'getProjectNameByImplAgency':
            $getProjectName = getProjectNameByImplAgency();
            echo json_encode($getProjectName);
            break;
            case 'getProjectAbstract':
            $getProjectAbstract = getProjectAbstract();
            echo json_encode($getProjectAbstract);
            break;
            case 'downloadAbstractReport':
            $downloadAbstractReport = downloadAbstractReport();
            break;
             case 'birdViewProj':
            $birdViewProj = birdViewProj();
            break;
            case 'getBVDept':
            $getBVDept = getBVDept();
            echo json_encode($getBVDept);
			break;
			case 'departments':
			$departments = departments();
            echo json_encode($departments);
			break;
			case 'hods':
            $hods = hods();
            echo json_encode($hods);
			break;
			case 'projects':
            $projects = projects();
            echo json_encode($projects);
			break;
			case 'project_details':
			$project_details = project_details();
            echo json_encode($project_details);
			break;
			case 'project_search':
			$project_search = project_search();
            echo json_encode($project_search);
			break;
			case 'deletePrj':
			$deletePrj = deletePrj();
            echo json_encode($deletePrj);
			break;
			default:
            //echo $_POST['case'];
			break;
		}
	}


	
	function getDept()
    {
		
		
        $query = pg_query(DBCON, "select distinct a.hod_name  as hod_cod,b.hod_name as hod_name from sp_index as a, masters.dept_users as b where a.hod_name = b.hod_dept_code order by b.hod_name asc");
		
        $html = '<option value="null">Select Departments</option>';
		
		
        while ($rs = pg_fetch_array($query))
        {
            $html .= '<option value="' . $rs['hod_cod'] . '">' . $rs['hod_name'] . '</option>';
		}
		
		
		
        return array(
		"html" => $html,
		
        );
		
	}
	
	
	function getExtent() {
		
		
		
		$dept = $_POST['dept'];
		
		$sql = "SELECT ST_Extent(ST_Transform(geom,3857)) as extent FROM sp_index where hod_name='$dept'";
		
		
		
		$query = pg_query(DBCON,$sql);
		
		$fetch = pg_fetch_assoc($query);
		
		//echo $query1['extent'];
		$extent = str_replace(" ",",",$fetch['extent']);
		
		$extent = str_replace("BOX","",$extent);
		
		$extent = str_replace("(","",$extent);
		
		$extent = str_replace(")","",$extent);
		
		
		return $extent;
		
	}
	
	
    function fillValues() {
		
		
		
		$sql = "select distinct dist_name from rv order by dist_name asc";
		$sql1 = "select distinct talukname from rv order by talukname asc";
		$sql2 = "select distinct vill_name from rv order by vill_name asc";
		
		
		
		$query = pg_query(DBCON,$sql);
		$query1 = pg_query(DBCON,$sql1);
		$query2 = pg_query(DBCON,$sql2);
		
		
		
		$html = '[';
		$html1 = null;
		$html2 = null;
		
		while ($rs = pg_fetch_array($query)) {
			$html.= '{"value":"'.$rs['dist_name'].'"},';
		}
		
		while ($rs1 = pg_fetch_array($query1)) {
			$html1.= '<option value="' . $rs1['talukname'] . '">' . $rs1['talukname'] . '</option>';
		}
		
 		while ($rs2 = pg_fetch_array($query2)) {
			$html2.= '<option value="' . $rs2['vill_name'] . '">' . $rs2['vill_name'] . '</option>';
		}
		
		$html = substr($html, 0, -1);
		$html.= "]";
		
        return array("html" => $html, "html1" => $html1, "html2" => $html2);
        //return array("html" => $html, "html1" => $html1);
		
	}
	
	
	function checkLatLong() {
		
		
		
		$lat = $_POST['lat'];
		$lon = $_POST['lon'];
		
		$sql = "select ST_WITHIN(ST_SetSRID(ST_MakePoint($lon,$lat),4326), the_geom) from sp_tnstate";
		
		
		
		$query = pg_query(DBCON,$sql);
		
		$fetch = pg_fetch_assoc($query);
		
		$status = $fetch['st_within'];
		
		
        return $status;
		
	}
	
	
	function enterData() {
		
		
		$layer_array = array();
		
		$upload_message;
		
	    if (file_exists($_FILES['shp_import']['tmp_name']) || is_uploaded_file($_FILES['shp_import']['tmp_name'])) 
		{
			$messsege = uploadShp($_FILES['shp_import']);
			if ($messsege['u_status'] == 't') {
				array_push($layer_array,$messsege['u_name']);
			}
		}
		
		


		if (file_exists($_FILES['shp_import_2']['tmp_name']) || is_uploaded_file($_FILES['shp_import_2']['tmp_name'])) 
		{
			
			$messsege2 = uploadShp($_FILES['shp_import_2']);
			if ($messsege2['u_status'] == 't') {
				array_push($layer_array,$messsege2['u_name']);
			}
		}
	
		
		
		if (file_exists($_FILES['shp_import_3']['tmp_name']) || is_uploaded_file($_FILES['shp_import_3']['tmp_name'])) 
		{
			$messsege3 = uploadShp($_FILES['shp_import_3']);
			if ($messsege3['u_status'] == 't') {
				array_push($layer_array,$messsege3['u_name']);
			}
		}
		
		
		
		$lat = replaceBadChars($_POST['lat']);
		$lon = replaceBadChars($_POST['long']);
		$implementing_agency = $_SESSION['100c_user_info']['hod_name'];
		$dept_name = $_SESSION['100c_user_info']['dept_name'];
		$prj_id = replaceBadChars($_POST['prj_id']);
		$prj_name = replaceBadChars($_POST['prj_name']);
		// $fund_agency = replaceBadChars($_POST['fund_agency']);
		$gov_orders = replaceBadChars($_POST['gov_orders']);
		$prj_desc = replaceBadChars($_POST['prj_desc']);
		$start_date = replaceBadChars($_POST['start_date']);
		$end_date = replaceBadChars($_POST['end_date']);
		$prj_cost = replaceBadChars($_POST['prj_cost']);
		$fund_recieved = replaceBadChars($_POST['fund_recieved']);
		$fund_yet_to_received = replaceBadChars($_POST['fund_yet_to_received']);
		$prj_dist = replaceBadChars($_POST['hidden-prj_dist']);
		$taluk = replaceBadChars($_POST['hidden-prj_taluk']);
		$village = replaceBadChars($_POST['hidden-prj_vill']);
		$survey_no = replaceBadChars($_POST['survey_no']);
		$total_project_extend = replaceBadChars($_POST['total_project_extend']);
		$work_completed = replaceBadChars($_POST['work_completed']);
		$work_in_progress = replaceBadChars($_POST['work_in_progress']);
		$work_to_be_completed = replaceBadChars($_POST['work_to_be_completed']);
		$fund_agency = $_POST['fun_agency'];
		$remarks = $_POST['remarks'];
		$eot = $_POST['extend_date'];
		$image1 = $_POST['image1'];
		$image2 = $_POST['image2']; 
		$layers =  implode(",",$layer_array);
		$hod_code = $_SESSION['100c_user_info']['hod_dept_code'];

		$rev_start_date = replaceBadChars($_POST['revised_start_date']);
		$rev_end_date = replaceBadChars($_POST['revised_end_date']);
		// $present_status = replaceBadChars($_POST['present_status']);
		 $present_status = $_POST['present_status'];
		$causes_of_delay = replaceBadChars($_POST['causes_of_delay']);
		// $causes_of_other_delay = replaceBadChars($_POST['delay_other_reason']);
		$causes_of_delay = 'null';
    	$causes_of_other_delay = 'null';
		
		  
    $insert_query = "INSERT INTO sp_index_v2(
	project_id, department_name, implementing_agency, name_of_the_project, funding_agency, government_orders, short_description_of_the_project, project_start_date, project_end_date, project_cost, fund_received, fund_yet_to_be_received, district_name, taluk_name, village_name, survey_no, latitude, longitude, total_project_extend, work_completed_details_with_extend, work_in_progress_details_with_extend, work_to_be_completed_details_with_extend, photo_prior_to_commencement_of_work, photo_current_status, remarks, layers, geom, hod_name, created_time,eot, revised_start_date, revised_end_date, present_status, causes_of_delay, other_reasons_delay)
	VALUES 
	('$prj_id','$dept_name','$implementing_agency','$prj_name','$fund_agency','$gov_orders','$prj_desc','$start_date','$end_date','$prj_cost','$fund_recieved','$fund_yet_to_received','$prj_dist','$taluk','$village','$survey_no','$lat','$lon','$total_project_extend','$work_completed','$work_in_progress','$work_to_be_completed','$image1','$image2','$remarks','$layers',ST_SetSRID(ST_MakePoint($lon, $lat),4326),'$hod_code', current_timestamp, '$eot', '$rev_start_date','$rev_end_date','$present_status','$causes_of_delay','$causes_of_other_delay')";
		
		
		
		$insert_index_data = pg_query(DBCON, $insert_query); 
		if ($insert_index_data) {
			$attr_insert_message = "<p><b class='text-success'>Attribute data saved</b></p>";
		}
		
		else  {
		    $attr_insert_message = "<p><b class='text-danger'>Attribute data failed to save contact administrator</b></p>";
		}
		
		
		return array ("upload_message" => $messsege['upload_message'],"upload_message1" => $messsege2['upload_message'], "upload_message2" => $messsege3['upload_message'], "attr_insert_message" => $attr_insert_message);
		
		
		
		
	}
	
	function loadDist() {
		$query = strtoupper($_POST['query']);
		
		$sql = "select distinct(dist_name) from rv where dist_name like '%$query%'";
		$result = pg_query(DBCON,$sql);
		
		$data = [];
		while($row = pg_fetch_assoc($result)){
			$data[] = $row['dist_name'];
		}
		return $data;
		
		
	}
	
	function loadTaluk() {
		$query = strtoupper($_POST['query']);
		$d = strtoupper($_POST['d']);
		$condition = "talukname ILIKE '%$query%' AND";
		$d_array = explode(',',$d);
		foreach($d_array as $val){
			$condition .= " dist_name ILIKE '%$val%' OR" ;
		}
		$cond = substr($condition, 0, -2);
		$sql = "select distinct(talukname) from rv where $cond";
		
		$result = pg_query(DBCON,$sql);
		
		$data = [];
		while($row = pg_fetch_assoc($result)){
			$data[] = $row['talukname'];
		}
		return $data;
		
		
	}
	
	
	function loadVill() {
		$query = strtoupper($_POST['query']);
		$t = strtoupper($_POST['t']);
		$condition = "vill_name ILIKE '%$query%' AND";
		$t_array = explode(',',$t);
		foreach($t_array as $val){
			$condition .= " talukname ILIKE '%$val%' OR" ;
		}
		$cond = substr($condition, 0, -2);
		
		$sql = "select distinct(vill_name) from rv where $cond";
		
		$result = pg_query(DBCON,$sql);
		
		$data = [];
		while($row = pg_fetch_assoc($result)){
			$data[] = $row['vill_name'];
		}
		return $data;
		
		
	}
	
	
	function unzip_file($file, $destination){
		// create object
		$zip = new ZipArchive() ;
		// open archive
		if ($zip->open($file) !== TRUE) {
			return false;
		}
		// extract contents to destination directory
		$zip->extractTo($destination);
		// close archive
		$zip->close();
        return true;
	}
	
	
	function getProjects(){
		
		$hod_dept = $_SESSION['100c_user_info']['hod_dept_code'];
		
		$query = "select project_id, name_of_the_project, project_start_date, layers as GIS_layers, DATE(created_time) as Created_Date,DATE(updated_time) as Last_Updated, id, layers, latitude, longitude from sp_index where hod_name = '$hod_dept' order by updated_time desc";
		
		$result = pg_query(DBCON, $query);
		
		$count = pg_num_rows($result);
		
		if ($count > 0) {
			echo '<h4 class="mt-1 mb-2">Total Projects ' . $count . '</h4><table class="table table-hover table-bordered ml-1px"><tr style="background-color:#28a745;color:white;">';
			$i = 0;
			while ($i < 6) {
				$fieldName = pg_field_name($result, $i);
				$fieldName = str_replace('_', ' ', $fieldName);
				if ($fieldName == 'gis layers'){
					$fieldName = "GIS Layers";
				}
				echo '<th>' . ucfirst($fieldName) . '</th>';
				$i = $i + 1;
			}
			echo "<th>Update</th>";
			echo '</tr>';
			//print_r(pg_fetch_row($result));
			while ($row = pg_fetch_row($result)) {
				$uid = trim($row[0]);
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
				echo "<tr style='line-height:20px;cursor:pointer'>";
				$count = 7;
				$y = 1;
				while ($y < $count) {
					$c_row = current($row);
					echo "<td>" . ucwords($c_row) . "</td>";
					next($row);
					$y = $y + 1;
				}
				echo '<td><button onClick="editPrj('.$row[6].')" class="btn-primary">Update Project</button></td></tr>';
				$i = $i + 1;
			}
			echo '</table>';
		} else echo "<h6>No Porjects</h6>";
		pg_free_result($result);
		
		
		
	}
	
	
	function getValues() {
		
		$id = $_POST['id'];
		
		$query = "select * from sp_index_v2 where id = $id";
		
		$result = pg_query(DBCON, $query);
		
		return pg_fetch_assoc($result);
		
	}
	
	function uploadShp ($fileName){
		
		// var_dump ($fileName);
		
		$filename = $fileName['name'];
		
		$filename = substr($filename,0,-4);
	
		
		$path = ROOTDIR."/upload/";
		
	
		
		$uni_name = $filename.'_'.uniqid();
		$uni_name = strtolower($uni_name);
		$uni_name = str_replace(' ', '_', $uni_name);
	    $hod_dept = $_SESSION['100c_user_info']['hod_dept_code']."/";
		
		if (!file_exists($path.$hod_dept)) {
			mkdir($path.$hod_dept, 0777, true);
			$path = $path.$hod_dept;
		} else {
			$path = $path.$hod_dept;
		}
		
		mkdir($path.$uni_name, 0777, true);
		
		$move_location = $path.$uni_name."/".$uni_name.'.zip';
		
		move_uploaded_file($fileName['tmp_name'],$move_location);
		
		unzip_file($move_location, $path.$uni_name."/");
		
		$folderPath = $path.$uni_name."/";
		
		$shp_location = glob($folderPath."*.shp");
		
		
		
		$shx_location = glob($folderPath."*.shx");
		$dbf_location = glob($folderPath."*.dbf");
		$prj_location = glob($folderPath."*.prj");
		
		if ($shp_location && $shx_location && $dbf_location && $prj_location) {
			
		/* 	$mv_cmd =  "cd ";
			
			exec($mv_cmd);
			 */
			 
			 $cd_cmd = 'cd /usr/pgsql-10/bin/'; //Staging
			//$cd_cmd = 'cd C:\Program Files\PostgreSQL\11\bin'; //local
			shell_exec($cd_cmd);
			$cmd = 'shp2pgsql -s 4326 "'.$shp_location[0].'" '.$uni_name;
			
		
			$queries = shell_exec($cmd);
	
				
			
			$insert_to_postgis = pg_query(DBCON, $queries);
			
		
			
			/* $test_query = pg_query(DBCON, "select st_contains(a.the_geom, st_union(b.the_geom)) from sp_tnstate as a , $uni_name as b group by a.the_geom
			"); */
			
			
			
			$test_query = pg_query(DBCON, "select st_contains(a.the_geom,b.the_geom) from sp_tnstate as a ,$uni_name as b;");

            $intersect_array = array();	
			
			$test['st_contains'] = 't';

	         while($row = pg_fetch_assoc($test_query)){
			   
				if ($row['st_contains'] == 'f'){
					$test['st_contains'] = 'f';
				}
				
				}
				
	
		
			
			if ($test['st_contains'] == 't'){
				
				exec('curl -v -u '.GSUSER.':'.GSPASS.' -XPOST -H "Content-type: text/xml" -d "<featureType><name>'.$uni_name.'</name><advertised>false</advertised></featureType>" '.GSURL.'/rest/workspaces/'.WORKSPACE.'/datastores/'.DATASTORE.'/featuretypes', $output, $return); 
				
				
				
				
				$style_apply_check = pg_query(DBCON, "select column_name from information_schema.columns where column_name = 'status_cod' and table_name = '$uni_name';");
				
				if (pg_num_rows($style_apply_check) > 0) {
					
					
					
					exec('curl -v -u '.GSUSER.':'.GSPASS.' -XPUT -H "Content-type: text/xml" -d "<layer><defaultStyle><name>c100_status</name></defaultStyle></layer>" '.GSURL.'/rest/layers/'.$uni_name, $output, $return);
					
					return array ("upload_message" => "<p class='text-success'><b>".$filename." is valid GIS Data and upload sucessfull with status completion</b></p>", "u_status" => 't', "u_name" => $uni_name);
					
				}
				
				else {
				return array ("upload_message" => "<p class='text-success'><b>".$filename." is valid GIS Data and upload sucessfull without status completion</b></p>", "u_status" => 't', "u_name" => $uni_name);
				}
				
				
				
			}
			
			else {
				$delete_table = pg_query(DBCON, "drop table $uni_name");
				
				
				return array ("upload_message" => "<p class='text-danger'><b>".$filename." Data is not in proper projection change the projection and then upload", "u_status" => 'f');
				
				
				
			} 
			
			
			
			
		}
		
		else {
			
			
			return array ("upload_message" => "<p class='text-danger'><b>".$filename." is invalid GIS Data and Not Uploaded Correct the data and then upload", "u_status" => 'f');
			
			
			return $upload_message = "";
			
		} 
		
		return $upload_message = $filename;
		
	}
	
	
    function editData() {
    	//print_r($_POST);
    	//print_r($_FILES);exit;
		$layer_array = array();
		$id = $_POST['e_id'];
		//echo $id;
		
		$query = "select * from sp_index_v2 where id = $id";
		$result = pg_query(DBCON, $query);
		$results = pg_fetch_assoc($result);
		$layers = $results['layers'];
		
		if ($layers != "" ){
			
			$layer_array = explode(",",$layers);
			$count_layers = count($layer_array);
			
			
		};
		
		$upload_message;
		
		
			if (file_exists($_FILES['edi_shp_import_1']['tmp_name']) || is_uploaded_file($_FILES['edi_shp_import_1']['tmp_name'])) 
			{
				
				$messsege = uploadShp($_FILES['edi_shp_import_1']);
				if ($messsege['u_status'] == 't') {
					if ($layer_array[0]) {
					    delete_layer($layer_array[0]);
					    $replacements = array(0 => $messsege['u_name']);
						$layer_array = array_replace($layer_array, $replacements);
					}
					else{
						array_push($layer_array,$messsege['u_name']);
					}
					
				} 
			}else{
				$messsege['upload_message'] = '';
			}
		
		
			if(isset($_FILES['edi_shp_import_2'])){
			if (file_exists($_FILES['edi_shp_import_2']['tmp_name']) || is_uploaded_file($_FILES['edi_shp_import_2']['tmp_name'])) 
			{
				
				$messsege2 = uploadShp($_FILES['edi_shp_import_2']);
				if ($messsege2['u_status'] == 't') {
					if ($layer_array[1]) {
						delete_layer($layer_array[1]);
					    $replacements = array(1 => $messsege2['u_name']);
						$layer_array = array_replace($layer_array, $replacements);
					}
					else{
						array_push($layer_array,$messsege2['u_name']);
					}
					
				} 
			}else{
				$messsege2['upload_message'] = '';
			}
		}else{
			$messsege2['upload_message'] = '';
		}
		
		if(isset($_FILES['edi_shp_import_3'])){
			if (file_exists($_FILES['edi_shp_import_3']['tmp_name']) || is_uploaded_file($_FILES['edi_shp_import_3']['tmp_name'])) 
			{
				$messsege3 = uploadShp($_FILES['edi_shp_import_3']);
				if ($messsege3['u_status'] == 't') {
					if ($layer_array[2]) {
						delete_layer($layer_array[2]);
						$replacements = array(2 => $messsege['u_name']);
						$layer_array = array_replace($layer_array, $replacements);
					}
					else{
						array_push($layer_array,$messsege3['u_name']);
					}
					
				} 
			}else{
				$messsege3['upload_message'] = '';
			}
		}else{
			$messsege3['upload_message'] = '';
		}
		
		
		$lat = replaceBadChars($_POST['edi_lat']);
		$lon = replaceBadChars($_POST['edi_long']);
		
		$prj_id = replaceBadChars($_POST['edi_prj_id']);
		$implementing_agency = replaceBadChars($_POST['edi_implementing_agency']);
		$prj_name = replaceBadChars($_POST['edi_prj_name']);
		// $fund_agency = replaceBadChars($_POST['edi_fund_agency']);
		$gov_orders = replaceBadChars($_POST['edi_gov_orders']);
		$prj_desc = replaceBadChars($_POST['edi_prj_desc']);
		$start_date = replaceBadChars($_POST['edi_start_date']);
		$end_date = replaceBadChars($_POST['edi_end_date']);
		$prj_cost = replaceBadChars($_POST['edi_prj_cost']);
		$fund_recieved = replaceBadChars($_POST['edi_fund_recieved']);
		$fund_yet_to_received = replaceBadChars($_POST['edi_fund_yet_to_received']);
		$prj_dist = replaceBadChars($_POST['hidden-edi_prj_dist']);
		$taluk = replaceBadChars($_POST['hidden-edi_prj_taluk']);
		$village = replaceBadChars($_POST['hidden-edi_prj_vill']);
		$survey_no = replaceBadChars($_POST['edi_survey_no']);
		$total_project_extend = replaceBadChars($_POST['edi_total_project_extend']);
		$work_completed = replaceBadChars($_POST['edi_work_completed']);
		$work_in_progress = replaceBadChars($_POST['edi_work_in_progress']);
		$work_to_be_completed = replaceBadChars($_POST['edi_work_to_be_completed']);
		$remarks = replaceBadChars($_POST['edi_remarks']);	
		$edi_extend_date = replaceBadChars($_POST['edi_extend_date']);	
		$fund_agency = $_POST['ed_fun_agency'];
		$image1 = $_POST['image1'];
		$image2 = $_POST['image2']; 
		$layers =  implode(",",$layer_array);

		$revised_start_date = replaceBadChars($_POST['edi_revised_start_date']);
		$revised_end_date = replaceBadChars($_POST['edi_revised_end_date']);
		$present_status = replaceBadChars($_POST['edi_present_status']);
		$causes_of_delay = replaceBadChars($_POST['edi_causes_of_delay']);
		$causes_of_other_delay = replaceBadChars($_POST['edi_delay_other_reason']);
		$cost_overrun = replaceBadChars($_POST['edi_cost_overrun']);
		$cost_overrun_reasons = replaceBadChars($_POST['edi_reason_for_cost_overrun']);
		
		
		
		
		$update_query = "update sp_index_v2 set project_id = '$prj_id', 
		
		name_of_the_project= '$prj_name', 
		implementing_agency= '$implementing_agency', 
		funding_agency = '$fund_agency', 
		government_orders = '$gov_orders', 
		short_description_of_the_project  = '$prj_desc', 
		project_start_date = '$start_date', 
		project_end_date  = '$end_date', 
		project_cost  = '$prj_cost', 
		fund_received  = '$fund_recieved', 
		fund_yet_to_be_received  = '$fund_yet_to_received', 
		district_name  = '$prj_dist', 
		taluk_name  = '$taluk', 
		village_name = '$village', 
		survey_no  = '$survey_no', 
		latitude = '$lat', 
		longitude = '$lon' ,
		total_project_extend = '$total_project_extend',
		work_completed_details_with_extend = '$work_completed', work_in_progress_details_with_extend = '$work_in_progress', work_to_be_completed_details_with_extend = '$work_to_be_completed', 
		remarks = '$remarks',
		layers = '$layers',
		eot = '$edi_extend_date',
		updated_time = current_timestamp,
		revised_start_date = '$revised_start_date',
		revised_end_date = '$revised_end_date',
		present_status = '$present_status',
		causes_of_delay = '$causes_of_delay',
		other_reasons_delay = '$causes_of_other_delay',
				cost_overrun = '$cost_overrun',
		cost_overrun_reasons = '$cost_overrun_reasons'
		where id = $id" ;
		
		
		$insert_index_data = pg_query(DBCON, $update_query); 
		if ($insert_index_data) {
			pg_query(DBCON,	"update sp_index_v2 set geom = ST_SetSRID(ST_MakePoint(longitude::float, latitude::float),4326) where id = $id");
			
			$attr_insert_message = "<p><b class='text-success'>Attribute data Updated</b></p>";
		}
		
		else  {
		    $attr_insert_message = "<p><b class='text-danger'>Attribute data failed to save contact administrator</b></p>";
		}
		
		if ($image1 != "undefined"){
			
			pg_query(DBCON, "update sp_index_v2 set photo_prior_to_commencement_of_work = '$image1' where id = $id");
			
		}
		
		if ($image2 != "undefined"){
			
			pg_query(DBCON, "update sp_index_v2 set photo_current_status = '$image2' where id = $id");
			
		}
		
		
		
		
		return array ("upload_message" => $messsege['upload_message'],"upload_message1" => $messsege2['upload_message'], "upload_message2" => $messsege3['upload_message'], "attr_insert_message" => $attr_insert_message); 
		
		
	}
	
	function delete_layer($name){
		
		pg_query(DBCON, "drop table $name");
		
		
		
		$command = 'curl -v -u '.GSUSER.':'.GSPASS.' -XDELETE "'.GSURL.'/rest/layers/'.$name.'?recurse=true"';
		
		exec($command);
		
	}
	
	
	
	function replaceBadChars($string) {
		$splChars=array("<",">","&","select ","drop ","insert ","delete ","update ","# ",'"',"="," script ","type="," like "," where "," and "," or ","%");
		$replaceChars=array("","","","","","","","","","","","","","","","","","","","","","","","","","","","","");
		$string=str_replace($splChars,$replaceChars,$string);
		$string=stripslashes($string);  
		$string=trim(pg_escape_string(strip_tags($string))); 
		return $string;
	}  
	
	function replaceBadCharsCond($string) {
		$splChars=array("select ","SELECT ","union " ,"drop ","insert ","delete ","update ","script","--"," where ");
		$replaceChars=array("","","","","","","","","","","","","","","","","");
		$string=str_replace($splChars,$replaceChars,$string);
		$string=stripslashes($string);  
		//$string=trim(pg_escape_string(strip_tags($string)));
		return $string;
	}
	
	
	function getInfo() {
		$id = $_POST['id'];
		$query = pg_query(DBCON, "select * from sp_index where id=$id");
		$assoc = pg_fetch_assoc($query);
		
		echo "<p class='text-center bg-info mr-2'><b><i class='fa fa-briefcase' aria-hidden='true'></i> Project Details</b></p>&nbsp";
		echo "<h6 class=' mr-3 font-italic text-primary'>".$assoc['name_of_the_project']."</h6>";
		
		
		echo "<div style='overflow:auto;height:47vh'><p class='text-left text-light bg-dark mr-2 mb-0'><b>&nbspProject ID</b> : ".$assoc['project_id']."</p>";
		echo "<p class='text-left text-light bg-dark mr-2 mb-0'><b>&nbspDepartment Name</b> : ".$assoc['department_name']."</p>";
		echo "<p class='text-left text-light bg-dark mr-2 mb-0'><b>&nbsp<i class='fa fa-calendar-check-o' aria-hidden='true'></i>&nbspProject Start Date</b> : ".$assoc['project_start_date']."</p>";
		echo "<p class='text-left text-light bg-dark mr-2 mb-0'><b>&nbsp<i class='fa fa-calendar-check-o' aria-hidden='true'></i>&nbspProject End Date</b> : ".$assoc['project_end_date']."</p>";
		echo "<p class='text-left text-light bg-dark mr-2 mb-0'><b>&nbsp<i class='fa fa-calendar-check-o' aria-hidden='true'></i>&nbspExtend Of Date</b> : ".$assoc['eot']."</p>";
		echo "<p class='text-left text-light bg-dark mr-2 mb-0'><b>&nbsp<i class='fa fa-wrench' aria-hidden='true'></i>&nbspImplementing Agency</b> : ".$assoc['implementing_agency']."</p>";
		echo "<p class='text-left text-light bg-dark mr-2 mb-0'><b>&nbsp<i class='fa fa-credit-card' aria-hidden='true'></i>&nbspFunding Agency</b> : ".$assoc['funding_agency']."</p>";
		echo "</br><h5 class='text-center'><b>Location Details</b></h5>";
			echo "<p class='text-left text-light bg-dark mr-2 mb-0'><b>&nbspDistrict</b> : ".$assoc['district_name']."</p>";
			echo "<p class='text-left text-light bg-dark mr-2 mb-0'><b>&nbspTaluk</b> : ".$assoc['taluk_name']."</p>";
			echo "<p class='text-left text-light bg-dark mr-2 mb-0'><b>&nbspVillages</b> : ".$assoc['village_name']."</p>";
			echo "<p class='text-left text-light bg-dark mr-2 mb-0'><b>&nbsp<i class='fa fa-map-marker' aria-hidden='true'></i>&nbspLocation</b> : ".$assoc['latitude'].", ".$assoc['longitude']."</p>&nbsp";
			
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
			echo "<p class='text-left font-italic'><b>Project Description</b> : <medium>".$assoc['short_description_of_the_project']."</medium></p>&nbsp";
			$img1 = $assoc['photo_prior_to_commencement_of_work'];
			$img2 = $assoc['photo_current_status'];
			
			
			if ($img1 != null) {
			echo "<p class='text-left font-italic'><b>Project Prior:</b></br>";
			echo "<img style='width:200px;height150px' src='$img1' onclick='openImg(this)'>";
	        }
			
			else {
				echo "<p class='text-left font-italic'><b>Project Prior:</b>  <span class='text-danger'> <i class='fa fa-exclamation' aria-hidden='true'></i> No Image added</span>";
				
			} 
			
		if ($img2 != null) {
			echo "<p class='text-left font-italic'><b>Current Status photo :</b></br>";
			echo "<img style='width:200px;height150px' src='$img2'  onclick='openImg(this)'>";
			
		}
			else {
				echo "<p class='text-left font-italic'><b>Current Status photo :</b> <span class='text-danger'> <i class='fa fa-exclamation' aria-hidden='true'></i> No Image added</span>";
				
			}
			
			$go = $assoc['government_orders'];
		
		  if ($assoc['government_orders'] != ''){ 
		  echo "<p class='text-left font-italic'><b>Government Orders :</b> $go</p>";
		  }
		  
		  else 
		  {
			    echo "<p class='text-left font-italic'><b>Government Orders :</b> <span class='text-danger'> <i class='fa fa-exclamation' aria-hidden='true'></i>&nbspNot Updated</span></p>";
		  }
		  
		 
		
		  if ($assoc['total_project_extend'] != ''){ 
		  echo "<p class='text-left font-italic'><b>Total Project Extent : </b> &nbsp".$assoc['total_project_extend']."</p>";
		  }
		  
		  else 
		  {
			    echo "<p class='text-left font-italic'><b>Total Project Extent :</b> <span class='text-danger'> <i class='fa fa-exclamation' aria-hidden='true'></i>&nbspNot Updated</span></p>";
		  }
		   if ($assoc['work_completed_details_with_extend'] != ''){ 
		  echo "<p class='text-left font-italic'><b>Work completed details with extend : </b> &nbsp".$assoc['work_completed_details_with_extend']."</p>";
		  }
		  
		  else 
		  {
			    echo "<p class='text-left font-italic'><b>Work completed details with extend : </b> <span class='text-danger'> <i class='fa fa-exclamation' aria-hidden='true'></i>&nbspNot Updated</span></p>";
		  }
		  
	  if ($assoc['work_in_progress_details_with_extend'] != ''){ 
		  echo "<p class='text-left font-italic'><b>Work in progress details with extend :</b> &nbsp".$assoc['work_in_progress_details_with_extend']."</p>";
		  }
		  
		  else 
		  {
			    echo "<p class='text-left font-italic'><b>Work in progress details with extend : </b> <span class='text-danger'> <i class='fa fa-exclamation' aria-hidden='true'></i>&nbspNot Updated</span></p>";
		  }
		  
	 if ($assoc['work_to_be_completed_details_with_extend'] != ''){ 
		  echo "<p class='text-left font-italic'><b>Work to be completed details with extend :</b> &nbsp".$assoc['work_to_be_completed_details_with_extend']."</p>";
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
	
	function getReport() {
		
		
		
		 $result = pg_query(DBCON, "select a.dept_name,a.dept_code, a.hod_name,a.hod_dept_code, b.name_of_the_project, b.funding_agency, b.short_description_of_the_project, b.project_start_date, b.project_end_date, b.project_cost, b.fund_received, b.fund_yet_to_be_received,b.remarks,b.eot, b.id,b.layers, b.latitude, b.longitude, b.causes_of_delay,b.cost_overrun_reasons,b.cost_overrun,DATE(b.updated_time) as updated_date,b.district_name,b.taluk_name,b.village_name from masters.dept_users as a , sp_index_v2 as b where a.hod_dept_code = b.hod_name and a.dept_name != '' order by a.dept_name asc");
		
		
		$result = pg_fetch_all($result);
		
		return $result;
	}		
	
	function getHodProj() {
		
		
		$dept_name = $_POST['dept'];
		$result = pg_query(DBCON, "select id, name_of_the_project, ST_Extent(ST_Transform(geom,3857)) as extent from sp_index where hod_name = '$dept_name' group by name_of_the_project, id order by name_of_the_project asc");
		
		
         echo '<option value="null" uid="null">Select Projects</option>';
		
		
        while ($rs = pg_fetch_array($result))
			
		
        {
			
		$extent = str_replace(" ",",",$rs['extent']);
		
		$extent = str_replace("BOX","",$extent);
		
		$extent = str_replace("(","",$extent);
		
		$extent = str_replace(")","",$extent);
            echo '<option value="' . $extent . '" uid = "' . $rs['id'] . '">' . $rs['name_of_the_project'] . '</option>';
		}
		
		
		
	}
	
	
	function addContact() {
		
		$name =  $_POST['add_name_contact'];
		$desig =  $_POST['add_desig_contact'];
		$m1 =  $_POST['add_m1_contact'];
		$m2 =  $_POST['add_m2_contact'];
		if ($m2 == ''){
			$m2 = 'null';
		}
		$email =  $_POST['add_email_contact'];
		$addr =  $_POST['add_addr_contact'];
		$remarks =  $_POST['add_remark_contact'];
		$hod_dept = $_SESSION['100c_user_info']['hod_dept_code'];
		
		$sql = "insert into masters.contacts(name, hod_dept_code, designation, contact_no, contact_no_1, address, email, remarks) values ('$name', '$hod_dept', '$desig', $m1, $m2, '$addr', '$email', '$remarks')";
     // return array ("add_message" => "insert into masters.contacts(name, hod_dept_code, designation, contact_no, contact_no_1, address, email) values ('$name', '$hod_dept', '$desig', $m1, '$m2', '$addr', '$email')"); 
		
   $query = pg_query(DBCON, $sql);
	  
	   
	   if ($query) {
		   
		   return array ("add_message" => 'Contact added Sucessfull'); 
		   
	   }  
		
	}
	
	

	
	
	function viewContact(){
		
		$hod_dept = $_SESSION['100c_user_info']['hod_dept_code'];
		

		$result = pg_query(DBCON, "select * from masters.contacts where hod_dept_code = '$hod_dept'");
		
		if (pg_num_rows($result) > 0) {
		echo "<div class='container mt-3'><div class='row'>";
		 while ($rs = pg_fetch_array($result)){
			 
		echo  "<div class='col-sm-6'> <div class='business-card'> <div class='media'> <div class='media-left'> <img class='media-object img-circle profile-img' src='http://s3.amazonaws.com/37assets/svn/765-default-avatar.png' style='width:100px'> </div> <div class='media-body'> <h2 class='media-heading'>".$rs['name']."</h2> <div class='job'>Designation : ".$rs['designation']."</div><div class='job'>Contact : ".$rs['contact_no']."</div> <div class='job'>Alternate Contact : ".$rs['contact_no_1']."</div><div class='job'>Address : ".$rs['address']."</div><div class='job'>Remarks : ".$rs['remarks']."</div><div class='mail'>e-Mail : <a href='mailto:".$rs['email']."'>".$rs['email']."</a> </div><div class='mail'><button class='btn btn-primary' onClick='editContact(".$rs['id'].")'><i class='fa fa-pencil'></i> Edit</button> <button class='btn btn-danger' onClick='deleteContact(".$rs['id'].")'><i class=' fa fa-trash-o'></i> Delete</button> </div></div> </div> </div> </div>";
			 
			
			
		 }
		 
		 
		 echo "</div></div>";
		 
		}
		
		else {
			
			echo '<h2 class="mt-3">No Contacts To show Kindly Add Contacts from <b>Add Contacts</b> Section</h2>';
			
		}
		
		
	}
	
	
		function delContact() {
		
		$id =  $_POST['id'];
		
		
		$sql = "delete from masters.contacts where id = '$id'";
		
	    $query = pg_query(DBCON, $sql);
	 
	   
	   if ($query) {
		   
		  echo 'Contact Deleted Sucessfull'; 
		   
	   }
		
	}
	
	
	function getContInfo() {
		
		$id = $_POST['id'];
		
		$result = pg_query(DBCON, "select * from masters.contacts where id = '$id'");
		
		$result = pg_fetch_all($result);
		
		return $result;
	}
	
	
	function ediContact() {
		
		$name =  $_POST['edi_name_contact'];
		$desig =  $_POST['edi_desig_contact'];
		$m1 =  $_POST['edi_m1_contact'];
		$m2 =  $_POST['edi_m2_contact'];
		
		if ($m2 == ''){
			$m2 = 'null';
		}
		$email =  $_POST['edi_email_contact'];
		$addr =  $_POST['edi_addr_contact'];
		$remarks =  $_POST['edi_remark_contact'];
		$id = $_POST['edi_contact_id'];
		
		$sql = "update masters.contacts set name ='$name', designation = '$desig', contact_no = $m1,  contact_no_1 = $m2, address = '$addr', email = '$email', remarks = '$remarks' where id = $id";
		
	    $query = pg_query(DBCON, $sql);
		
		//return array ("add_message" => "update masters.contacts set name ='$name', designation = '$desig', contact_no = $mi,  contact_no_1 = $m2, address = '$addr', email = '$email' where id = $id"); 

	   
	   if ($query) {
		   
		   return array ("edi_message" => "Contact Editied Sucessfully"); 
		   
	   }
		
	}
	
	
		function viewContactById(){
		
		$id = $_POST['id'];
		

		$result = pg_query(DBCON, "select * from masters.contacts where hod_dept_code = '$id'");
		
		if (pg_num_rows($result) > 0) {
		echo "<div class='container mt-3'><div class='row'>";
		 while ($rs = pg_fetch_array($result)){
			 
		echo  "<div class='col-sm-6'> <div class='business-card'> <div class='media'> <div class='media-left'> <img class='media-object img-circle profile-img' src='http://s3.amazonaws.com/37assets/svn/765-default-avatar.png' style='width:100px'> </div> <div class='media-body'> <h2 class='media-heading'>".$rs['name']."</h2> <div class='job'>Designation : ".$rs['designation']."</div><div class='job'>Contact : ".$rs['contact_no']."</div> <div class='job'>Alternate Contact : ".$rs['contact_no_1']."</div><div class='job'>Address : ".$rs['address']."</div><div class='mail'>e-Mail : <a href='mailto:".$rs['email']."'>".$rs['email']."</a> </div></div> </div> </div> </div>";
			 
			
			 
		 }
		 
		 
		 echo "</div></div>";
		 
		}
		
		else {
			
			echo '<h2 class="mt-3">No Contacts Added</h2>';
			
		}
		
		
	}
	
	
		function getAllExtent(){
		
		$layer1 = $_POST['layer1'];
		$layer2 = $_POST['layer2'];
		$layer3 = $_POST['layer3'];
		
		
		$layer1Geom = getGeomCol($layer1);
		$layer2Geom = getGeomCol($layer2);
		$layer3Geom = getGeomCol($layer3);
		
		if ($layer1 != 'null' && $layer2 == 'null' && $layer3 == 'null') {
			
			$query  = pg_query(DBCON, "SELECT ST_Extent(ST_Transform($layer1Geom,3857)) FROM $layer1");
			if ($query)  {
				
				  $data =  pg_fetch_assoc($query);
				  
				  
			}
			
		}
		
		
		else if ($layer1 != 'null' && $layer2 != 'null' && $layer3 == 'null') {
			
			$query  = pg_query(DBCON, "select ST_Extent(ST_Transform(ST_Union(a.$layer1Geom, b.$layer2Geom), 3857))  from $layer1 as a, $layer2 as b");
			 
			if ($query)  {
				
				  $data =  pg_fetch_assoc($query);
				 	   
				 
			}
			
			
		}
		
		else {
			
			$query  = pg_query(DBCON, "select ST_Extent(ST_Transform(ST_Union(ST_Union(a.$layer1Geom, b.$layer2Geom ), c.$layer3Geom ), 3857))  from $layer1 as a, $layer2 as b, $layer3 as c");
			 
			if ($query)  {
				
				  $data =  pg_fetch_assoc($query);
				  
				  
			}
			
			
		}
	
	
		$extent = str_replace(" ",",",$data['st_extent']);
		

		$extent = str_replace("BOX","",$extent);
		
		$extent = str_replace("(","",$extent);
		
		$extent = str_replace(")","",$extent);
		
	
		return $extent;
		
		
		
	}
	
	
  function getGeomCol($table) {
		
	if ($table != 'null') {
		
		
	$query = pg_query(DBCON, "SELECT column_name FROM information_schema.columns WHERE table_schema = 'public' AND table_name = '$table' and data_type = 'USER-DEFINED'");
	
	$col =  pg_fetch_assoc($query);
	
	return $col['column_name'];
	
	}
	
	
	else { return 'null';}
	

	
	}
	
	
	
	function getExt($data) {
		
		
		//$fetch = pg_fetch_assoc($query);
		
		//echo $query1['extent'];
		$extent = str_replace(" ",",",$data['extent']);
		
		$extent = str_replace("BOX","",$extent);
		
		$extent = str_replace("(","",$extent);
		
		$extent = str_replace(")","",$extent);
		
		
		return $extent;
		
		
	}

	function getAllProjectsForReports(){

		$role=$_SESSION['100c_user_info']['role'];
		
		if($role == 11){
			$query = "select sp.department_name, sp.implementing_agency, sp.name_of_the_project, sp.funding_agency,sp.project_start_date,sp.project_end_date,sp.revised_start_date, sp.revised_end_date, sp.id, sp.project_cost, sp.present_status, cd.delay_desc,sp.other_reasons_delay,sp.cost_overrun,sp.cost_overrun_reasons,DATE(updated_time) updated_time  from sp_index_v2 as sp left join mst_causes_of_delay as cd on sp.causes_of_delay = cast(cd.delay_id as text)  order by sp.department_name,sp.id";
		}else{
			$hod_code = $_SESSION['100c_user_info']['hod_dept_code'];
			$query = "select sp.department_name, sp.implementing_agency, sp.name_of_the_project, sp.funding_agency,sp.project_start_date,sp.project_end_date,sp.revised_start_date, sp.revised_end_date, sp.id, sp.project_cost, sp.present_status, cd.delay_desc,sp.other_reasons_delay,sp.cost_overrun,sp.cost_overrun_reasons,DATE(updated_time) updated_time
			 from sp_index_v2 as sp left join mst_causes_of_delay as cd on sp.causes_of_delay = cast(cd.delay_id as text) where sp.hod_name='$hod_code' order by sp.department_name,sp.id";
		}
		
		//echo $query;
		$result = pg_query(DBCON, $query);

		//print_r($result);exit;
		
		$rs = pg_fetch_all($result);//pg_fetch_object(result)

		return $rs;

		//print_r($rs);exit;
	}


	function downloadProjectReport(){

		$role=$_SESSION['100c_user_info']['role'];
		$filepath = $_SERVER['DOCUMENT_ROOT'].'/major_infra/reports/';
		$filename = 'project_details.xlsx';
		$my_file = $filepath.$filename;
		try{

			if($role == 11){
				$query = "select sp.department_name, sp.implementing_agency, sp.name_of_the_project, sp.funding_agency,sp.project_start_date,sp.project_end_date,sp.revised_start_date, sp.revised_end_date, sp.id, sp.project_cost, sp.present_status, cd.delay_desc,sp.other_reasons_delay from sp_index as sp left join mst_causes_of_delay as cd on sp.causes_of_delay = cast(cd.delay_id as text)  order by sp.department_name,sp.id";
			}else{
				$hod_code = $_SESSION['100c_user_info']['hod_dept_code'];
				$query = "select sp.department_name, sp.implementing_agency, sp.name_of_the_project, sp.funding_agency,sp.project_start_date,sp.project_end_date,sp.revised_start_date, sp.revised_end_date, sp.id, sp.project_cost, sp.present_status, cd.delay_desc,sp.other_reasons_delay from sp_index as sp left join mst_causes_of_delay as cd on sp.causes_of_delay = cast(cd.delay_id as text) where sp.hod_name='$hod_code' order by sp.department_name,sp.id";
			}
			
		
			$result = pg_query(DBCON, $query);
			$rs = pg_fetch_all($result);

			if($rs){

				require_once('../Classes/PHPExcel/IOFactory.php');
				$objPHPExcel = new PHPExcel();
				$objPHPExcel->setActiveSheetIndex(0);
				$index = 1;
				//put column name in Excel Sheet.
				$sheet = $objPHPExcel->getActiveSheet();
				$sheet->setCellValue('A1', 'S.No');
				$sheet->setCellValue('B1', 'Department Name');
				$sheet->setCellValue('C1', 'Implementing Agency');
				$sheet->setCellValue('D1', 'Name Of The Project' );
				$sheet->setCellValue('E1', 'Funding Agency');
				$sheet->setCellValue('F1', 'Project Start Date');
				$sheet->setCellValue('G1', 'Project End Date');
				$sheet->setCellValue('H1', 'Revised Project Start Date');
				$sheet->setCellValue('I1', 'Revised Project End Date');
				$sheet->setCellValue('J1', 'Project Cost');
				$sheet->setCellValue('K1', 'Present Status');
				$sheet->setCellValue('L1', 'Causes Of Delay');

				//Style
				
				
				
					$col = 0;
					$row = 2;
					foreach($rs as $key=>$val){

						$sheet->setCellValue('A'.(string)($row), $index);
						$sheet->setCellValue('B'.(string)($row), $val['department_name']);
						$sheet->setCellValue('C'.(string)($row), $val['implementing_agency']);
						$sheet->setCellValue('D'.(string)($row), $val['name_of_the_project']);
						$sheet->setCellValue('E'.(string)($row), $val['funding_agency']);
						$sheet->setCellValue('F'.(string)($row), $val['project_start_date']);
						$sheet->setCellValue('G'.(string)($row), $val['project_end_date']);
						$sheet->setCellValue('H'.(string)($row), $val['revised_start_date']);
						$sheet->setCellValue('I'.(string)($row), $val['revised_end_date']);
						$sheet->setCellValue('J'.(string)($row), $val['project_cost']);
						$sheet->setCellValue('K'.(string)($row), $val['present_status']);
						$sheet->setCellValue('L'.(string)($row), $val['delay_desc']);

						$row++;
						$index++;
						//echo $val['department_name'] . "<br />";

					}
					// Rename worksheet
					$sheet->setTitle('Project List');
					// Set active sheet index to the first sheet, so Excel opens this as the first sheet
					$objPHPExcel->setActiveSheetIndex(0);
					$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
					$objWriter->save($my_file);
					header('Content-type: application/ms-excel');
					header('Content-Disposition: attachment; filename='.$filename);
			
			header("Content-length: " . filesize($filename));
			header("Pragma: no-cache");
			header("Expires: 0");
			}else{
				//No project found.
			}
		}
		catch(PDOException $e)
		{
			//echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
		

		//print_r($result);exit;
		
		



		//return $rs;

	}


	function getCausesOfDelayReport(){
		$role=$_SESSION['100c_user_info']['role'];
		
		if($role == 11){
			$query = "select sp.department_name, sp.implementing_agency, sp.name_of_the_project, sp.funding_agency,sp.project_start_date,sp.project_end_date,sp.revised_start_date, sp.revised_end_date, sp.id, sp.project_cost, sp.present_status, cd.delay_desc,sp.other_reasons_delay from sp_index as sp left join mst_causes_of_delay as cd on sp.causes_of_delay = cast(cd.delay_id as text)  order by sp.department_name,sp.id";
		}else{
			$hod_code = $_SESSION['100c_user_info']['hod_dept_code'];
			$query = "select sp.department_name, sp.implementing_agency, sp.name_of_the_project, sp.funding_agency,sp.project_start_date,sp.project_end_date,sp.revised_start_date, sp.revised_end_date, sp.id, sp.project_cost, sp.present_status, cd.delay_desc,sp.other_reasons_delay from sp_index as sp left join mst_causes_of_delay as cd on sp.causes_of_delay = cast(cd.delay_id as text) where sp.hod_name='$hod_code' order by sp.department_name,sp.id";
		}
		
		//echo $query;
		$result = pg_query(DBCON, $query);

		//print_r($result);exit;
		
		$rs = pg_fetch_all($result);//pg_fetch_object(result)

		return $rs;

	}
	
	
	function getImplementingAgencyByDeptId(){

		if(isset($_GET['dId'])){
			$dept_code = $_GET['dId'];
			$query = "select distinct hod_name,hod_dept_code from masters.dept_users where dept_code='$dept_code' ";
			$result = pg_query(DBCON, $query);
			$rs = pg_fetch_all($result);
			return $rs;

		}else{
			return null;
		}

	}

	function getProjectNameByImplAgency(){
		if(isset($_GET['hId'])){
			$hod_code = $_GET['hId'];
			$query = "select project_id,name_of_the_project as project_name from sp_index_v2  where hod_name='$hod_code' and created_time is not null";
			$result = pg_query(DBCON, $query);
			$rs = pg_fetch_all($result);
			return $rs;

		}else{
			return null;
		}
	}

	function getProjectAbstract(){
		if(isset($_POST['dId']) && isset($_POST['hId']) && isset($_POST['pId'])){
			$dept_code = $_POST['dId'];
			$hod_code = $_POST['hId'];
			$project_id = $_POST['pId'];

			if($dept_code == "ALL"){
				$where = "";
			}else if($dept_code != "ALL" && $hod_code == "ALL"){
				$where = " where sp.hod_name like '$dept_code%'";
			}else if($dept_code != "ALL" && $hod_code != "ALL" && $project_id == "ALL"){
				$where = " where sp.hod_name like '$dept_code%' and sp.hod_name='$hod_code'";
			}else if($dept_code != "ALL" && $hod_code != "ALL" && $project_id != "ALL"){
				$where = " where sp.hod_name like '$dept_code%' and sp.hod_name='$hod_code' and sp.project_id='$project_id'";
			}
			$query = "select sp.department_name,d.hod_name,sp.implementing_agency,sp.project_id,name_of_the_project as project_name,sp.funding_agency,sp.government_orders,sp.short_description_of_the_project as project_desc,sp.project_start_date,sp.project_end_date,sp.project_cost,sp.district_name,sp.taluk_name,sp.village_name,sp.remarks,cost_overrun,cost_overrun_reasons,causes_of_delay,DATE(updated_time) updated_time from sp_index_v2 as sp inner join masters.dept_users as d on sp.hod_name=d.hod_dept_code" . $where . " order by sp.department_name,sp.implementing_agency,sp.name_of_the_project";
			$result = pg_query(DBCON, $query);
			$rs = pg_fetch_all($result);
			return $rs;
		}else{
			return null;
		}
	}

	function downloadAbstractReport(){
		if(isset($_POST['dId']) && isset($_POST['hId']) && isset($_POST['pId'])){
			$dept_code = $_POST['dId'];
			$hod_code = $_POST['hId'];
			$project_id = $_POST['pId'];
			if($dept_code == "ALL"){
				$where = "";
			}else if($dept_code != "ALL" && $hod_code == "ALL"){
				$where = " where sp.hod_name like '$dept_code%'";
			}else if($dept_code != "ALL" && $hod_code != "ALL" && $project_id == "ALL"){
				$where = " where sp.hod_name like '$dept_code%' and sp.hod_name='$hod_code'";
			}else if($dept_code != "ALL" && $hod_code != "ALL" && $project_id != "ALL"){
				$where = " where sp.hod_name like '$dept_code%' and sp.hod_name='$hod_code' and sp.project_id='$project_id'";
			}
			$query = "select sp.department_name,d.hod_name,sp.implementing_agency,sp.project_id,name_of_the_project as project_name,sp.funding_agency,sp.government_orders,sp.short_description_of_the_project as project_desc,sp.project_start_date,sp.project_end_date,sp.project_cost,sp.district_name,sp.taluk_name,sp.village_name,sp.remarks,cost_overrun,cost_overrun_reasons,causes_of_delay from sp_index as sp inner join masters.dept_users as d on sp.hod_name=d.hod_dept_code" . $where . " order by sp.department_name,sp.implementing_agency,sp.name_of_the_project";
			$result = pg_query(DBCON, $query);
			$rs = pg_fetch_all($result);
			if($rs){
				$content = '<span>Abstract Report</span>';
				foreach ($rs as $key => $val) {
					
					$content .= '<span>Project Name: ' . $val['project_name'] . '</span>';
					$content .= '<span>Department Name: ' . $val['department_name'] . '</span>';
					$content .= '<span><strong>Head Of Department:</strong> ' . $val['hod_name'] . '</span>';
					$content .= '<span><strong>Implementing Agency:</strong> ' . $val['implementing_agency'] . '</span>';
					$content .= '<span><strong>Project Description:</strong> ' . $val['project_desc'] . '</span>';
					$content .= '<span><strong>Government Order:</strong> ' . $val['government_orders'] . '</span>';
					$content .= '<span><strong>Funding Agency:</strong> ' . $val['funding_agency'] . '</span>';
					$content .= '<span><strong>Project Start Date:</strong> ' . $val['project_start_date'] . '</span>';
					$content .= '<span><strong>Project End Date:</strong> ' . $val['project_end_date'] . '</span>';
					$content .= '<span><strong>Project Cost:</strong> ' . $val['project_cost'] . '</span>';
				
				}
				//echo $content;
				//create document.
				$phpWord = new PhpOffice\PhpWord\PhpWord();
				$section = $phpWord->addSection();
				\PhpOffice\PhpWord\Shared\Html::addHtml($section, $content, false, false);
				$filename = 'ProjectAbstractReport.docx';
				$filepath = $_SERVER['DOCUMENT_ROOT'].'/major_infra/reports/Download/';
				$file = $filepath . $filename;
				//echo $file;
				$phpWord->save($file, "Word2007");
				chmod($file, 0777);
				header('Content-type: application/ms-word');
				header('Content-Disposition: attachment; filename='.$filename);
			
			//header("Content-length: " . filesize($filename));
			header("Pragma: no-cache");
			header("Expires: 0");
			
			}
			return $rs;
		}else{
			return null;
		}
		
	}

	function getBVDept()
    {
		
		
        $query = pg_query(DBCON, "select distinct a.hod_name  as hod_cod,b.hod_name as hod_name from sp_index as a, masters.dept_users as b where a.hod_name = b.hod_dept_code  and  a.layers is not null and a.layers !='' order by b.hod_name asc");
		
        $html = '<option value="null">Select Departments</option><option value="all">All Departments</option>';
		
		
        while ($rs = pg_fetch_array($query))
        {
            $html .= '<option value="' . $rs['hod_cod'] . '">' . $rs['hod_name'] . '</option>';
		}
		
		
		
        return array(
		"html" => $html,
		
        );
		
	}
	
	function birdViewProj() {
		$dbacon = DBCON;
		$dept_name = $_POST['dept'];
		
		if ($dept_name == 'all'){
			$query = "select * from sp_index where layers is not null and layers !='' and hod_name !='' order by name_of_the_project asc";
		}
else {
		$query = "select * from sp_index where hod_name = '$dept_name' and layers is not null and layers !='' order by name_of_the_project asc";
	}
		    $result = pg_query($dbacon, $query);
		 $count = pg_num_rows($result);
    if ($count > 0) {
        echo "<html><body><h6 style='color:#343a40'></h6><table id='bv_table' class='table table-hover table-bordered'><tr style='background-color:#343a40;color:white;'>";
      
            echo '<th class="text-capitalize">Name of the Projects</th>';
          
        while ($row =  pg_fetch_assoc($result)) {
		  $lat = $row['latitude'];
		   $lon = $row['longitude'];
		   $layers = $row['layers'];
		    $flyto = $row['id'];


            // echo $flyto;
            echo "<tr style='line-height:20px' onClick=ZoomTo('$layers','$lat','$lon')>";
                // $c_row = current($row);
                $pr_id = $row['name_of_the_project'];
                echo "<td >" . ucwords($pr_id) . "</td>";
                next($row);
               
          
            echo "</tr>";
          

        }
        echo '</table></body></html>';
    }
    pg_free_result($result);
    } 
	
	function projects(){
    	$dbacon = DBCON;
		$dept_code = $_POST['dept'];
		$hod_code = $_POST['hod'];
		if ($dept_code == 'all'){
			$query = "select * from sp_index_v1 where dept_code != '' and hod_name = '$hod_code' and created_time IS NOT NULL order by name_of_the_project asc";
		}else {
			$query = "select * from sp_index_v1 where dept_code = '$dept_code' and hod_name = '$hod_code' and created_time IS NOT NULL order by name_of_the_project asc";
		}
		$result = pg_query($dbacon, $query);
		$count = pg_num_rows($result);
    	if ($count > 0) {
    		$html = '<option value="null">Select Projects</option>';
    		while ($row =  pg_fetch_assoc($result)) {
    			$html .= '<option value="'.$row['project_id'].'">'.$row['name_of_the_project'].'</option>';
	        }
    	}else{
    		$html = '<option value="null">No Projects</option>';
    	}
    	return array(
				"html" => $html,
        	);
    	pg_free_result($result);
    }

    function departments(){
    	$query = pg_query(DBCON, "select * from departments order by short_name asc");
		
        $html = '<option value="null" selected>Select Departments</option><option value="all">All Departments</option>';
        while ($rs = pg_fetch_array($query))
        {
            $html .= '<option value="' . $rs['dept_code'] . '">' . $rs['short_name'] . '</option>';
		}
				
        return array(
		"html" => $html,
		
        );
    }

    function project_details(){
    	$dbacon = DBCON;
		$proj_id = $_POST['proj_id'];
		// $dept_code = $_POST['dept_code'];
		$query = "select * from sp_index_v1 where project_id = '$proj_id'";
		$result = pg_query($dbacon, $query);
		$count = pg_num_rows($result);
    	if ($count > 0) {
    		while ($row =  pg_fetch_assoc($result)) {
    			$html = $row;
	        }
    	}else{
    		$html = '';
    	}
    	return array(
				"html" => $html,
        	);
    	pg_free_result($result);
    }

    function project_search(){
    	$dbacon = DBCON;
		// $search = $_POST['search'];
		$query = "select project_id,name_of_the_project from sp_index_v1 where created_time IS NOT NULL order by name_of_the_project asc";
		$result = pg_query($dbacon, $query);
		$count = pg_num_rows($result);
		$html = '<option value="null">Search for Projects</option>';
    	if ($count > 0) {
    		while ($row = pg_fetch_assoc($result)) {
    			$html .= '<option value="' . $row['project_id'] . '">' . $row['name_of_the_project'] . '</option>';
	        }
    	}else{
    		$html = '<option value="null">No Projects</option>';
    	}
    	return array(
				"html" => $html,
        	);
    	pg_free_result($result);
    }

    function hods(){
    	$dbacon = DBCON;
		$dept_code = $_POST['dept'];
		if ($dept_code == 'all'){
			$query = "select * from masters.dept_users where dept_code != '' and hod_dept_code IS NOT NULL and hod_dept_code != '' order by hod_dept_code asc";
		}else {
			$query = "select * from masters.dept_users where dept_code = '$dept_code' and hod_dept_code IS NOT NULL and hod_dept_code != '' order by hod_dept_code asc";
		}
		$result = pg_query($dbacon, $query);
		$count = pg_num_rows($result);
    	if ($count > 0) {
    		$html = '<option value="null">Select HOD</option>';
    		while ($row =  pg_fetch_assoc($result)) {
    			$html .= '<option value="'.$row['hod_dept_code'].'">'.$row['hod_name'].'</option>';
	        }
    	}else{
    		$html = '<option value="null">No HOD found</option>';
    	}
    	return array(
				"html" => $html,
        	);
    	pg_free_result($result);
    }
	
   	function deletePrj(){
		$dbacon = DBCON;
		$id = $_POST['id'];
		$query = "select * from public.sp_index_v2 where id = $id";
		$result = pg_query(DBCON, $query);
		$count = pg_num_rows($result);
    	if ($count > 0) {
    		$copy_query = "INSERT INTO public.deleted_projects SELECT * FROM public.sp_index_v2 WHERE id= $id";
    		$copy_result = pg_query(DBCON, $copy_query);
    		if($copy_result){
    			$delete_query = "DELETE FROM public.sp_index_v2  WHERE id= $id";
    			$delete_result = pg_query(DBCON, $delete_query);
    			if($delete_result){
	    			return array(
						"html"=>"Success",
						"status"=>1,
					);
	    		}else{
	    			return array(
						"html"=>"Please try later",
						"status"=>0,
					);
	    		}
    		}else{
    			return array(
					"html"=>"Please try later",
					"status"=>0,
				);
    		}
			
		}else{
			return array(
				"html"=>"Please try later",
				"status"=>0,
			);
		}
	}
	
	
?>
