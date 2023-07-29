<?php
/*
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
*/
include("../android_connect.php");
$response = array();
$response["WorkWork"] = array();
$workerid = $_POST["workerid"];

$selectworkOrder = mysql_query ("SELECT a.workorderid AS workorderid, b.`mallID` AS MallID,
b.Tradename AS Tradename, a.startdate AS startdate
FROM tblmaintenance_workorder a
INNER JOIN `tbltrans_tenants` b ON a.TenantID = b.TenantID WHERE
a.workerid = '$workerid' AND a.xstatus = 'Pending' ORDER BY a.workorderid DESC");
if(mysql_num_rows($selectworkOrder) <> 0){
	while($rowItem = mysql_fetch_array($selectworkOrder)){
		$list = array();
		$list["workorderid"] = $rowItem["workorderid"];
		$list["MallID"] = $rowItem["MallID"];
		$list["Tradename"] = $rowItem["Tradename"];
		$list["startdate"] = $rowItem["startdate"];
		array_push($response["WorkWork"], $list);
	}
		$response["success"] = 1;
}
else{
	$response["success"] = 2;
}
echo json_encode($response);
?>	