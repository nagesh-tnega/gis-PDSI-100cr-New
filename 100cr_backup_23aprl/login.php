<?php
require_once('php/dbHandler.php');

ini_set('session.cookie_httponly', 1);
//ini_set('session.cookie_secure', 1);


	
	session_start();
    
    session_regenerate_id(TRUE);


	
	
	
	// if ($_SERVER["REQUEST_METHOD"] == "POST") {
		 
		
		
		 $dbcon = DBCON;
		 
		
		 
	
            $user = pg_escape_string(trim($_POST['u']));
            $password = pg_escape_string(trim($_POST['p']));
			
		
		 $sql = "select * from masters.dept_users where user_name = '$user' and password = '$password' ";
		 
		 //echo $sql;
		 
		
		 
		  $query = pg_query($dbcon, $sql);
		  if($query && pg_num_rows($query) == 1) {
		  $userInfo = pg_fetch_assoc($query);
		  $role = $userInfo['role'];
          //$userInfo = pg_fetch_assoc($query);
		  $_SESSION['100c_user_info'] = $userInfo;
 		  
		    if($role == '') {
				header('location: dashboard.php');
               
               
            }
		  else if($role == 11) {

				header('location: dashboard.php');
               
               
            }
		  }
    	else {
		 
		  
		  
    		header('location: index.php');
            $_SESSION['error']['message'] = "Invalid credentials!";
            exit();
        }
		 
		 
		 
		 
		 
		 
		 
		 
		 
	// }

?>