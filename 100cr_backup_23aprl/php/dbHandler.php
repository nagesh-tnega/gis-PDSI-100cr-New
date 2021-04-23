<?php
require_once('config.php');

define ('DBCON', pg_connect("host=".HOST." dbname=".DB_NAME." user=".USER." password=".PASS));





?>