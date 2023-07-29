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
include("../../../android_connect.php");

$response = array();
$response["Tenant"] = array();
$response["Department"] = array();
$response["Maintenance"] = array();
$response["SelectTask"] = array();

$Count = 0;

$selectAllTenant = mysql_query("SELECT TenantID, tradename, mallid, owner_firstname, owner_lastname FROM `tbltrans_tenants` ORDER BY tradename");
if(mysql_num_rows($selectAllTenant) <> 0){
	while($rowItem = mysql_fetch_array($selectAllTenant)){
		$list = array();
		$list["TenantID"] = $rowItem["TenantID"];
		$list["tradename"] = $rowItem["tradename"];
		$list["mallid"] = $rowItem["mallid"];
		$list["ownerName"] = $rowItem["owner_firstname"] . " " . $rowItem["owner_lastname"];
		array_push($response["Tenant"], $list);
	}
	$response["success"] = 1;
	$Count = $Count + 1;
}

$selectAllDep = mysql_query("SELECT groupid, groupname FROM `tblref_groupaccess` ORDER BY groupname");
if(mysql_num_rows($selectAllDep) <> 0){
	while($rowItem = mysql_fetch_array($selectAllDep)){
		$list = array();
		$list["groupid"] = $rowItem["groupid"];
		$list["groupname"] = $rowItem["groupname"];
		array_push($response["Department"], $list);
	}
	$response["success"] = 1;
	$Count = $Count + 1;
}

$selectMaintenance = mysql_query("Select icon, category_id, category, Maintenance_Type from `tblmaintenance_category` order by category");
if(mysql_num_rows($selectMaintenance) <> 0){
	while($rowItem = mysql_fetch_array($selectMaintenance)){
		$list = array();
		
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
		
		$list["category_id"] = $rowItem["category_id"];
		$list["category"] = $rowItem["category"];
		$list["Maintenance_Type"] = $rowItem["Maintenance_Type"];
		array_push($response["Maintenance"], $list);
	}
	$response["success"] = 1;
	$Count = $Count + 1;
}

$SelectTask = mysql_query("SELECT xcategory, taskid, description, amount FROM `tblmaintenance_tasklist` ORDER BY description");
if(mysql_num_rows($SelectTask) <> 0){
	while($rowItem = mysql_fetch_array($SelectTask)){
		$list = array();
		$list["xcategory"] = $rowItem["xcategory"];
		$list["taskid"] = $rowItem["taskid"];
		$list["description"] = $rowItem["description"];
		$list["amount"] = $rowItem["amount"];
		array_push($response["SelectTask"], $list);
	}
	$response["success"] = 1;
	$Count = $Count + 1;
}



if ($Count == 4){
	$response["success"] = 2;
}else{
	$response["success"] = 0;
}

echo json_encode($response);
?>