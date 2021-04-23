<?php
//Start session
session_start();
//Check whether the session variable SESS_MEMBER_ID is present or not
if (!isset($_SESSION['100c_user_info']) ) {
    header("location: index.php");
    exit();
}


?>