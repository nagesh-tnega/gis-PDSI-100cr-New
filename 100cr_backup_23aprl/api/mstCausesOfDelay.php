<?php


class mstCausesOfDelay{

	public static function getCausesOfDelay($conn){
		$res;
		try{
			$sql = "select * from mst_causes_of_delay order by delay_id";
			$result=pg_query($conn,$sql);
			$row = pg_fetch_all($result);
			$res =  $row;
		}
		catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}'; 
		}
		return $res;
	}
}

?>