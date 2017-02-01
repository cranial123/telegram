<?php
session_start();
require_once('constants.php');
date_default_timezone_set('Asia/Jakarta');
$ip_user = $_SERVER['REMOTE_ADDR'];
$time = time();
$link = DATABASE_LINK;
$conn = mysqli_connect(DATABASE_LINK, DATABASE_USER, DATABASE_PASSWORD,DATABASE_NAME) or die('error ketika connect mysql');
//mysql_select_db(DATABASE_NAME) or die('error ketika get Database');
require_once('functions.php');
?>
