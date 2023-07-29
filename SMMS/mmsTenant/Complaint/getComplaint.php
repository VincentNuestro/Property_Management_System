<?php
include("../mms_database.php");
$response = array();
$TenantID = $_POST["id"];
$response["Header"] = array();

$getComplaint = mysql_query("SELECT Complaint_Code, Complete_Description, Time_Received, Time_Resolved, ResolvedBy, Complaint_Status, Priority_Status, Remarks
FROM tblcomplaints WHERE TenantID = '$TenantID'");
if(mysql_num_rows($getComplaint)<>0){
	while($items = mysql_fetch_assoc($getComplaint)){
		$list = array();
		$list["Complaint_Code"] = isset($items["Complaint_Code"]) ? $items["Complaint_Code"]: "";
		$list["Complete_Description"] = isset($items["Complete_Description"]) ? $items["Complete_Description"]: "";
		$list["Time_Received"] = isset($items["Time_Received"]) ? $items["Time_Received"]: "";
		$list["Time_Resolved"] = isset($items["Time_Resolved"]) ? $items["Time_Resolved"]: "";
		$list["ResolvedBy"] = isset($items["ResolvedBy"]) ? $items["ResolvedBy"]: "";
		$list["Complaint_Status"] = isset($items["Complaint_Status"]) ? $items["Complaint_Status"]: "";
		$list["Priority_Status"] = isset($items["Priority_Status"]) ? $items["Priority_Status"]: "";
		$list["Remarks"] = isset($items["Remarks"]) ? $items["Remarks"]: "";
		array_push($response["Header"], $list);
	}
$response["success"] = 1;
}else{
$response["success"] = 0;
}
echo json_encode($response);
?>