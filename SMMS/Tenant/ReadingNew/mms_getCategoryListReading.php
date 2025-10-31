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

include("../../android_connect.php");

$response = array();
$response["Information"] = array();
$category = $_POST["category"];
$id = $_POST["id"];
$status = $_POST["status"];
$date = $_POST["date"];

/*
$category = 'CAT-000005';
$status = 'Pending';
$id = 'TENANT-0000004';
$date = '2018-12-26';
*/

$selectAllPending = mysql_query("SELECT W.workorderid, W.tenantid, 
CONCAT(T.`firstname` , ' ' , T.`middlename` , ' ' , T.`lastname`) AS tradename, W.taskstatus,
F.floor, WM.wing, M.mallname, M.mallid, W.`xcategory`, W.`reading_date`, WU.`remarks`,
W.`xtaskid`, W.`MeterID`, W.`id`
FROM `tblmaintenance_workorderlist` W
INNER JOIN tblmaintenance_workorder WU ON W.workorderid = WU.workorderid
INNER JOIN `tbluser` T ON T.userid = WU.workerid
INNER JOIN tblref_unit U ON W.tenantid = U.TenantID
INNER JOIN tblref_mall M ON U.mallid = M.mallid
INNER JOIN tblref_wing WM ON U.wingid = WM.wingID
INNER JOIN tblref_floorsetup F ON U.floorid = F.floorid
WHERE W.xcategory = '$category' AND W.taskstatus = '$status' 
AND WU.tenantid = '$id' and WU.startdate = '$date' ORDER BY WU.workorderid DESC");

if(mysql_num_rows($selectAllPending)<>0){
	while($rowItem = mysql_fetch_array($selectAllPending)){
		$list = array();
		$list['workorderid'] = isset($rowItem["workorderid"]) ? $rowItem["workorderid"] : "";
		$list['tenantid'] = isset($rowItem["tenantid"]) ? $rowItem["tenantid"] : "";
		$list['tradename'] = isset($rowItem["tradename"]) ? $rowItem["tradename"] : "";
		$list['taskstatus'] = isset($rowItem["taskstatus"]) ? $rowItem["taskstatus"] : "";
		$list['floor'] = isset($rowItem["floor"]) ? $rowItem["floor"] : "";
		$list['wing'] = isset($rowItem["wing"]) ? $rowItem["wing"] : "";
		$list['mallname'] = isset($rowItem["mallname"]) ? $rowItem["mallname"] : "";
		$list['mallid'] = isset($rowItem["mallid"]) ? $rowItem["mallid"] : "";
		$list['xcategory'] = isset($rowItem["xcategory"]) ? $rowItem["xcategory"] : "";
		$list['reading_date'] = isset($rowItem["reading_date"]) ? $rowItem["reading_date"] : "";
		$list['remarks'] = isset($rowItem["remarks"]) ? $rowItem["remarks"] : "";
		$list['xtaskid'] = isset($rowItem["xtaskid"]) ? $rowItem["xtaskid"] : "";
		
		$SelectTaskName = mysql_query("SELECT description FROM `tblmaintenance_tasklist` 
		WHERE taskid = '".$list['xtaskid']."'");
		if(mysql_num_rows($SelectTaskName)<>0){
		$SelectedRow = mysql_fetch_array($SelectTaskName);
		$list["description"] = isset($SelectedRow["description"]) ? $SelectedRow["description"] : "";
		}else{
		$list["description"] = "";
		}
		
		$list['MeterID'] = isset($rowItem["MeterID"]) ? $rowItem["MeterID"] : "";
		$list['id'] = isset($rowItem["id"]) ? $rowItem["id"] : "";
		array_push($response["Information"],$list);
	}	
	$response["success"] = 1;
}else{
	$response["success"] = 0;
}
echo json_encode($response);
?>
