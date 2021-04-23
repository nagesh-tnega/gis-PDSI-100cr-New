
<?php
	include ('session.php');
	require_once ('dbHandler.php');

$query = strtoupper($_POST['query']);
	
	$sql = "select distinct(dist_name) from rv where dist_name like '%$query%'";
		$result = pg_query(DBCON,$sql);
		
		 $data = [];
    while($row = pg_fetch_assoc($result)){
         $data[] = $row['dist_name'];
    }
		echo json_encode ($data);
	
	
?>
	
		
		