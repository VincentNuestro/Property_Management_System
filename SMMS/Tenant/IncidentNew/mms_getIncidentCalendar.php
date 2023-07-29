<?php
include("../../android_connect.php");
$response = array();

$validation = $_POST["validation"];

if($validation == "1"){
	$response["Calendar"] = array();
	$id = $_POST["id"];	
	$getIncident = mysql_query("SELECT xdate, xstatus FROM `tblmaintenance_hrviolatorsheader`
	WHERE ViolatorID = '$id' ORDER BY xdate ASC");
	if(mysql_num_rows($getIncident) <> 0){
			while($row = mysql_fetch_array($getIncident)){
			$list = array();
			$list["xdate"] = $row["xdate"];
			$list["numberOfTask"] = "0";
			$list["subject"] = $row["xstatus"];
			$list["description"] = "0";
			array_push($response["Calendar"],$list);
		}
		$response["success"] = 1;
		}
		else{
		$response["success"] = 2;
		}
}elseif ($validation == "2"){
	$response["Incident"] = array();
	$TenantID = $_POST["TenantID"];
	$date = $_POST["date"];
	$selectIncident = mysql_query("SELECT VSeriesNumber, ViolatorID, ViolatorName, xstatus, xtype, xdate, xtime,
	xdateresolved, xtimeresolved, xdatetimeresolved FROM `tblmaintenance_hrviolatorsheader`
	WHERE ViolatorID = '$TenantID' and xdate = '$date' 
	order by VSeriesNumber desc");
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
}

echo json_encode($response);
?>