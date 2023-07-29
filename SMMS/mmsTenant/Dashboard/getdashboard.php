<?php
include("../mms_database.php");
$response = array();
$tenantid = $_POST["ID"];

$getDashboard = mysql_query("SELECT COUNT(W.id) AS Workorder, COUNT(C.`id`) AS Complaint, COUNT(V.`id`) AS Violation
FROM `tblmaintenance_workorder` W
LEFT JOIN `tblcomplaints` C ON C.`TenantID` = W.`TenantID`
LEFT JOIN `tblmaintenance_hrviolatorsheader` V ON W.`TenantID` = V.`ViolatorID`
WHERE W.`TenantID` = '$tenantid' AND V.`xstatus` = 'Pending'
AND C.`Complaint_Status` = 'Pending' AND W.`xstatus` = 'Pending'");

$getWorkCount = mysql_fetch_assoc(mysql_query("SELECT COUNT(id) AS ID FROM `tblmaintenance_workorder` WHERE TenantID = '$tenantid' AND xstatus = 'Pending'"));

$getComplaintkCount = mysql_fetch_assoc(mysql_query("SELECT COUNT(id) AS ID FROM `tblmaintenance_hrviolatorsheader` WHERE ViolatorID = '$tenantid' AND xstatus = 'Pending'"));

$getViolationkCount = mysql_fetch_assoc(mysql_query("SELECT COUNT(id) AS ID FROM `tblcomplaints` WHERE TenantID = '$tenantid' AND Complaint_Status = 'Pending'"));

$getGatepass = mysql_fetch_assoc(mysql_query("SELECT COUNT(id) AS ID FROM `tbltrans_tenantsrequest` WHERE TenantID = '$tenantid' AND APP_STATUS = 'Pending'"));

$response["Workorder"] = isset($getWorkCount["ID"]) ? $getWorkCount["ID"]: "0";
$response["Complaint"] = isset($getViolationkCount["ID"]) ? $getViolationkCount["ID"]: "0";
$response["Violation"] = isset($getComplaintkCount["ID"]) ? $getComplaintkCount["ID"]: "0";
$response["Gatepass"] = isset($getGatepass["ID"]) ? $getGatepass["ID"]: "0";
$response["success"] = 1;


echo json_encode($response);
?>