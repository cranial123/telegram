<?php
require_once('constants.php');
date_default_timezone_set('Asia/Jakarta');
//$ip_user = $_SERVER["HTTP_CF_CONNECTING_IP"];
//$country_user = $_SERVER["HTTP_CF_IPCOUNTRY"];
//$http_user = $_SERVER["HTTP_CF_VISITOR"];
$time = time();
$conn = mysqli_connect(DATABASE_LINK, DATABASE_USER, DATABASE_PASSWORD,DATABASE_NAME) or die('error ketika connect mysql');
require_once('functions.php');
?>
