<?php

include("../../android_connect.php");

$response = array();
$TenantID = $_POST["TenantID"];
$response["Incident"] = array();
$selectIncident = mysql_query("SELECT VSeriesNumber, ViolatorID, ViolatorName, xstatus, xtype, xdate, xtime,
xdateresolved, xtimeresolved, xdatetimeresolved FROM `tblmaintenance_hrviolatorsheader`
WHERE ViolatorID = '$TenantID' order by VSeriesNumber desc");
if(mysql_num_rows($selectIncident) <> 0){
	while($rowItem = mysql_fetch_array($selectIncident)){
	$list = array();
	$list["VSeriesNumber"] = isset($rowItem['VSeriesNumber']) ? $rowItem['VSeriesNumber'] : ""; 
	$list["ViolatorID"] = isset($rowItem['ViolatorID']) ? $rowItem['ViolatorID'] : ""; 
	$list["ViolatorName"] = isset($rowItem['ViolatorName']) ? $rowItem['ViolatorName'] : ""; 
	$list["xstatus"] = isset($rowItem['xstatus']) ? $rowItem['xstatus'] : ""; 
	$list["xtype"] = isset($rowItem['xtype']) ? $rowItem['xtype'] : ""; 
	$list["xdate"] = isset($rowItem['xdate']) ? $rowItem['xdate'] : ""; 
	$list["xtime"] = isset($rowItem['xtime']) ? $rowItem['xtime'] : ""; 
	$list["xdateresolved"] = isset($rowItem['xdateresolved']) ? $rowItem['xdateresolved'] : ""; 
	$list["xtimeresolved"] = isset($rowItem['xtimeresolved']) ? $rowItem['xtimeresolved'] : ""; 
	$list["xdatetimeresolved"] = isset($rowItem['xdatetimeresolved']) ? $rowItem['Entry'] : ""; 
	array_push($response["Incident"], $list);		
	}
	$response["success"] = 1;
}else{
	$response["success"] = 2;
}
echo json_encode($response);
?>	