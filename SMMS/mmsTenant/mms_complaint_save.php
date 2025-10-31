<?php

include("../android_connect.php");

$response = array();

$TenantID = $_POST["TenantID"];
$Tradename = $_POST["Tradename"];
$mallID = $_POST["mallID"];
$unitID = $_POST["unitID"];
$Complaint_code = $_POST["Complaint_code"];
$Complete_Description = $_POST["Complete_Description"];
$UserID = $_POST["UserID"];
$Priority_Status = $_POST["Priority_Status"];


$getWingAndFloorID = mysql_query("SELECT wingid, floorid FROM tblref_unit WHERE unitid = '$unitID'");
$data=mysql_fetch_assoc($getWingAndFloorID);
$wingID = $data['wingid'];
$floorid = $data['floorid'];

if ($wingID == "" || $floorid == ""){
	$response["success"] = 2;
}
else { 
	$getComplaint_Series = mysql_query("SELECT Complaint_Series_No FROM tblcomplaints ORDER BY Complaint_Series_No DESC LIMIT 1");
	$data=mysql_fetch_assoc($getComplaint_Series);
	$Complaint_Series_No = $data['Complaint_Series_No']; //echo "Complaint_Series_No " . $Complaint_Series_No;
	if(mysql_num_rows($getComplaint_Series) <> 0){
				$row = mysql_fetch_array($getComplaint_Series);
				$arrID1 = array();
				$arrID1 = explode("-", $row["Complaint_Series_No"]);
				$NewComplaint_No = "CSN-".str_pad(((int)str_replace('CSN-','',$Complaint_Series_No)+1), 7, "0", STR_PAD_LEFT);
			}else{
				$NewComplaint_No = "CSN-0000001";
			}//echo "NewComplaint_No. " . $NewComplaint_No;
$response["success"] = 3;


$insertToComplaint = mysql_query ("INSERT INTO tblcomplaints SET TenantID = '$TenantID', Date_Entry = NOW(), Complaint_Series_No = '$NewComplaint_No', 
Complaint_Code = '$Complaint_code', Complete_Description = '$Complete_Description', TradeName = '$Tradename', MallID = '$mallID', WingID = '$wingID', 
FloorID = '$floorid', UnitID = '$unitID', Complaint_Status = 'Pending', Priority_Status='$Priority_Status', UserID ='$UserID'");


$response["send"] = "send";
}


echo json_encode($response);
?>	
