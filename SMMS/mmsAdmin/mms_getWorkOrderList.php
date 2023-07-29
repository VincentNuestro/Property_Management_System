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
$response["WorkList"] = array();
$WorkHeader = $_POST["WorkHeader"];
//$WorkHeader = 'JO-0000042';
//asdsad
$SelectWorkOrderList = mysql_query("SELECT a.xcategory AS Cat, a.`tenantid` AS tenantID, b.category AS Cname, b.icon AS icon, 
a.taskstatus AS xSTATUS, a.reading_date AS xdate
FROM `tblmaintenance_workorderlist` a
LEFT JOIN `tblmaintenance_category` b ON a.xcategory = b.category_id
WHERE a.`workorderid` = '$WorkHeader'");
if(mysql_num_rows($SelectWorkOrderList) <> 0){
	while($rowItem = mysql_fetch_array($SelectWorkOrderList)){
		$list = array();
		$list["Cat"] = $rowItem["Cat"];
		$list["tenantID"] = $rowItem["tenantID"];
		$list["Cname"] = $rowItem["Cname"];
		
		if(empty($rowItem["icon"])){
			$list["icon"] = "";
		}
		else{	
			$img_name = $rowItem["icon"];
			if (false !== ($contents = @file_get_contents('http://localhost/mms_mall/server/Maintenance/Category/'.$img_name))) {
			$list["icon"] = base64_encode(file_get_contents('http://localhost/mms_mall/server/Maintenance/Category/'.$img_name));
			}
			else{
			$list["icon"] = "";
			}
		}
		
		$list["status"] = $rowItem["xSTATUS"];
		$list["xdate"] = $rowItem["xdate"];
		array_push($response["WorkList"], $list);
	}
		$response["success"] = 1;
}
else{
	$response["success"] = 2;
}
echo json_encode($response);
?>	