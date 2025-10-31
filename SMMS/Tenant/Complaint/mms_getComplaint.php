<?php

include("../../android_connect.php");

$response = array();
$TenantID = $_POST["TenantID"];
$Date = $_POST["Date"];
$response["Complaint"] = array();
$selectcomplaint = mysql_query("SELECT C.Date_Entry AS Entry, C.Complaint_Series_No AS Num, C.Complaint_Code AS xCode,
C.Complete_Description AS Des, C.Complaint_Status AS Stat, C.Priority_Status AS Prio,
DATE(C.xdate) AS xdate, C.Resolvedby AS Resolve, C.Remarks AS Remarks
FROM `tblcomplaints` C WHERE TenantID = '$TenantID' and C.Date_Entry =  '$Date'
ORDER BY C.id DESC");

if(mysql_num_rows($selectcomplaint) <> 0){
	while($rowItem = mysql_fetch_array($selectcomplaint)){
	$list = array();
	$list["Entry"] = isset($rowItem['Entry']) ? $rowItem['Entry'] : ""; 
	$list["Num"] = isset($rowItem['Num']) ? $rowItem['Num'] : ""; 
	$list["xCode"] = isset($rowItem['xCode']) ? $rowItem['xCode'] : ""; 
	$list["Des"] = isset($rowItem['Des']) ? $rowItem['Des'] : ""; 
	$list["Stat"] = isset($rowItem['Stat']) ? $rowItem['Stat'] : ""; 
	$list["Prio"] = isset($rowItem['Prio']) ? $rowItem['Prio'] : ""; 
	$list["xdate"] = isset($rowItem['xdate']) ? $rowItem['xdate'] : ""; 
	$list["Resolve"] = isset($rowItem['Resolve']) ? $rowItem['Resolve'] : ""; 
	$list["Remarks"] = isset($rowItem['id']) ? $rowItem['Remarks'] : ""; 
	array_push($response["Complaint"], $list);		
	}
	$response["success"] = 1;
}else{
	$response["success"] = 2;
}
echo json_encode($response);
?>	