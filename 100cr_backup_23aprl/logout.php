<?php
session_start();
//include ('php/session.php');
unset($_SESSION["100c_user_info"]);
header("Location:index.php");
?>