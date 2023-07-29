<?php

date_default_timezone_get();
date_default_timezone_set('Asia/Manila');
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));
$connection = mysql_connect('localhost', 'gates', 'g@tes2009');
if (!$connection) {
	die('Could not connect: ' . mysql_error());
}

$db =  mysql_select_db("gates_smm", $connection);
mysql_query("SET NAMES 'utf8'");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET COLLATION_CONNECTION = 'utf8_unicode_ci'");

$txtusername = $_POST['txtusername'];
$txtemail = $_POST['txtemail'];
$txtnumber = $_POST['txtnumber'];
$userID = $_POST['userID'];

//$txtusername = "sample jonas";
//$txtemail = "sample@gmail.com";
//$txtnumber = "(995) 911-1083";
//s$userID = "USER-0000002";
$response = array();	

$updatetbluser = mysql_query("update `tbluser` set username = '$txtusername', emailaddress = '$txtemail', 
contactnumber = '$txtnumber' where userid ='$userID'");

$response['success'] = 1 ;
echo json_encode($response);
?>	

