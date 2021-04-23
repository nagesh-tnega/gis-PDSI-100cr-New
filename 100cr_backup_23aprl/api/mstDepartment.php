<?php


class mstDepartment{

	public static function getDepartmentList($conn){
		$res;
		try{
			$sql = "select distinct dept_name, dept_code from masters.dept_users  where dept_name!='' order by dept_name";
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