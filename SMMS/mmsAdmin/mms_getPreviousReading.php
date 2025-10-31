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
$tenantID = $_POST["tenantID"];
$Category = $_POST["Category"];
$xDate = $_POST["xDate"];
$MallID = $_POST["MallID"];
$Type = $_POST["Type"];

//--------karl added 12-07-2018
$MeterID = $_POST["MeterID"];
$workerid = $_POST["workerid"];
$workorderid = $_POST["workorderid"];

/*
$tenantID = "TENANT-0000004"; //check
$Category = "CAT-000005"; //check
$xDate = "2018-01-31"; //checl
$MallID = "MALL-0000001"; //check
$TYPE = "Electric"; //check
$MeterID = "Test Electric Meter 1";
$workerid = "USER-0000002";
$workorderid = "JO-0000304";
*/

/*
$MallID = "MALL-0000001,";
$Type = "Water";
$tenantID = "TENANT-0000004";
$Category = "CAT-000006";
$xDate = "2018-09-03";
*/


$response["tenantID"] = $tenantID;
$response["Category"] = $Category;
$response["xDate"] = $xDate;
$response["MallID"] = $MallID;
$response["Type"] = $Type;
$response["MeterID"] = $MeterID;
$response["workerid"] = $workerid;
$response["workorderid"] = $workorderid;

/*old
$getPrevious = mysql_query("SELECT meter_reading, sub_total FROM `tblmaintenance_workorderlist` WHERE 
tenantid = '$tenantID' AND xcategory = '$Category' AND
reading_date < '$xDate' ORDER BY id DESC");
if(mysql_num_rows($getPrevious) <> 0){
$rowItem = mysql_fetch_array($getPrevious);
$response["success"] = 1;
$response["meter_reading"] = $rowItem ["meter_reading"];
$response["sub_t
	$getRate = mysql_query("select UtilRate from `tblref_utilraotal"] = $rowItem ["sub_total"];

te` where mallid = '$MallID' and
	 type = '$Type' and EffDate <= '$xDate' order by id DESC LIMIT 1 ");
	if(mysql_num_rows($getRate) <> 0){
		$rowItem = mysql_fetch_array($getRate);
		$response["Rate"] = (float) $rowItem["UtilRate"];
	}else{
		$response["Rate"] = (float) "0";
	}

}
else{
$response["success"] = 2;
$response["meter_reading"] = "0";
$response["sub_total"] = "0";

	$getRate = mysql_query("select UtilRate from `tblref_utilrate` where mallid = '$MallID' and
	 type = '$Type' and EffDate <= '$xDate' order by id DESC LIMIT 1 ");
	if(mysql_num_rows($getRate) <> 0){
		$rowItem = mysql_fetch_array($getRate);
		$response["Rate"] = (float) $rowItem["UtilRate"];
	}else{
		$response["Rate"] = (float) "0";
	}
}
*/

//new 12-07-18 rate
//-------------------------------------------------------------------------------------Get Previous Reading
$getPrevious = mysql_query("SELECT CurrentMeterUsage 
FROM `tblmaintenance_workorderlist` W 
INNER JOIN tblmaintenance_workorder WU ON W.workorderid = WU.workorderid
WHERE W.MeterID = '$MeterID' 
AND W.tenantid= '$tenantID' AND W.workorderid = '$workorderid' 
AND W.xcategory = '$Category' AND WU.`workerid` = '$workerid'");

if(mysql_num_rows($getPrevious) <> 0){
$row = mysql_fetch_array($getPrevious);
	$response["meter_reading"] = $row["CurrentMeterUsage"];

$getRate = mysql_query("select (UtilRate + (UtilRate * (AdminFee/100))) as Xrate, 
	EffDate from `tblref_utilrate`
	WHERE mallid = '$MallID' AND Effdate <='$xDate'
	AND TYPE = '$Type' ORDER BY EffDate DESC LIMIT 1");
	if(mysql_num_rows($getRate) <> 0){
		$rowItem = mysql_fetch_array($getRate);
		$response["Xrate"] = (float) $rowItem["Xrate"];
	}
	else{
		$response["Xrate"] = (float) "0";
	}
	
$response["success"] = 1;
}
else{

$response["meter_reading"] = "0";
$getRate = mysql_query("select (UtilRate + (UtilRate * (AdminFee/100))) as Xrate, 
	EffDate from `tblref_utilrate`
	WHERE mallid = '$MallID' AND Effdate <='$xDate'
	AND TYPE = '$Type' ORDER BY EffDate DESC LIMIT 1");
	if(mysql_num_rows($getRate) <> 0){
		$rowItem = mysql_fetch_array($getRate);
		$response["Xrate"] = (float) $rowItem["Xrate"];
	}
	else{
		$response["Xrate"] = (float) "0";
	}
	$response["success"] = 2;
}

echo json_encode($response);
?>	