<?php

include("../android_connect.php");

$response = array();
$response["Tenant"] = array();

//Karl 01-15-19
$TenantID = $_POST["TenantID"];

$Tenant = mysql_query("SELECT TenantID, companyname, mallID , unitID FROM tbltrans_tenants WHERE TenantID = '$TenantID'");
if(mysql_num_rows($Tenant) <> 0){
			if(mysql_num_rows($Tenant) <> 0){
			while($rowItem = mysql_fetch_array($Tenant)){
				$list = array();
				$list["TenantID"] = $rowItem["TenantID"];
				$list["companyname"] = $rowItem["companyname"];	
				$list["mallID"] = $rowItem["mallID"];
				$list["unitID"] = $rowItem["unitID"];	
				array_push($response["Tenant"], $list);
			}
	}
	$response["success"] = 1;
}else{
	$response["success"] = 0;
}


$response["Complaint_Code"] = array();
$Complaint_Code = mysql_query("SELECT Complaints_Code, Complete_Description, Priority_Status FROM tblcomplaintscode");
if(mysql_num_rows($Complaint_Code) <> 0){
			if(mysql_num_rows($Complaint_Code) <> 0){
			while($rowItem = mysql_fetch_array($Complaint_Code)){
				$list = array();
				$list["Complaints_Code"] = $rowItem["Complaints_Code"];
				$list["Complete_Description"] = $rowItem["Complete_Description"];			
				$list["Priority_Status"] = $rowItem["Priority_Status"];		
				array_push($response["Complaint_Code"], $list);
			}
	}
	$response["success"] = 1;
}else{
	$response["success"] = 0;
}








echo json_encode($response);
?>	