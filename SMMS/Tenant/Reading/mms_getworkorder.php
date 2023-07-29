<?php

date_default_timezone_get();
date_default_timezone_set('Asia/Manila');
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));
$connection = mysql_connect('localhost', 'gates', 'g@tes2009');
if (!$connection) {
	die('Could not connect: ' . mysql_error());
}

$db =  mysql_select_db("gates_smm", $connection); //or die("Error on database: " . mysql_error());
mysql_query("SET NAMES 'utf8'");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET COLLATION_CONNECTION = 'utf8_unicode_ci'");

$response = array();
$Tenant = $_POST["Tenant"];

$response["workorderid"] = array();

$selectWorkerHearder = mysql_query("SELECT workorderid, workername, remarks, startdate, enddate
FROM `tblmaintenance_workorder` WHERE TenantID = '$Tenant' ORDER BY id DESC");
if(mysql_num_rows($selectWorkerHearder) <> 0){
	while($rowItem = mysql_fetch_array($selectWorkerHearder)){
		$list = array();
		$list["workorderid"] = isset($rowItem['workorderid']) ? $rowItem['workorderid'] : ""; 
		$list["workername"] = isset($rowItem['workername']) ? $rowItem['workername'] : ""; 
		$list["remarks"] = isset($rowItem['remarks']) ? $rowItem['remarks'] : ""; 
		$list["startdate"] = isset($rowItem['startdate']) ? $rowItem['startdate'] : ""; 
		$list["enddate"] = isset($rowItem['enddate']) ? $rowItem['enddate'] : ""; 
		array_push($response["workorderid"], $list);
	}
	$response["success"] = 1;
}
else{
	$response["success"] = 2;
}
echo json_encode($response);
?>	