<?php
/*
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
*/

include("../../android_connect.php");

$response = array();
$VSeriesNumber = $_POST["VSeriesNumber"];
$response["Incident"] = array();
//$VSeriesNumber = "VHR-0000002";
$Select = mysql_query("SELECT Code, Violation, Resolution, ViolatorName, offensetype, xstatus, xdate, xtime, 
xfine, xdateresolved, xtimeresolved FROM `tblmaintenance_hrviolators` WHERE VSeriesNumber = '$VSeriesNumber'");

if(mysql_num_rows($Select) <> 0){
	while($rowItem = mysql_fetch_array($Select)){
		$list = array();
		$list["Code"] = isset($rowItem['Code']) ? $rowItem['Code'] : ""; 
		$list["Violation"] = isset($rowItem['Violation']) ? $rowItem['Violation'] : ""; 
		$list["Resolution"] = isset($rowItem['Resolution']) ? $rowItem['Resolution'] : ""; 
		$list["ViolatorName"] = isset($rowItem['ViolatorName']) ? $rowItem['ViolatorName'] : ""; 
		$list["offensetype"] = isset($rowItem['offensetype']) ? $rowItem['offensetype'] : ""; 
		$list["xstatus"] = isset($rowItem['xstatus']) ? $rowItem['xstatus'] : ""; 
		$list["xdate"] = isset($rowItem['xdate']) ? $rowItem['xdate'] : ""; 
		$list["xtime"] = isset($rowItem['xtime']) ? $rowItem['xtime'] : ""; 
		$list["xfine"] = isset($rowItem['xfine']) ? $rowItem['xfine'] : ""; 
		$list["xdateresolved"] = isset($rowItem['xdateresolved']) ? $rowItem['xdateresolved'] : ""; 
		$list["xtimeresolved"] = isset($rowItem['xtimeresolved']) ? $rowItem['xtimeresolved'] : ""; 
		array_push($response["Incident"], $list);		
	}
	$response["success"] = 1;		
}
else{
	$response["success"] = 2;
}
echo json_encode($response);
?>