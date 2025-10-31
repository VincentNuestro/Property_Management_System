<?php

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


$response = array();
$TenantID = $_POST["TenantID"];
$def_password = $_POST["pass"];
//TENANT-0000004
/*
$TenantID = 'TENANT-0000004';
$def_password = 'TAKEAWAY';*/

//$username = "Karl";
//$pass = "Karl";
	
$companyid= "";
	
$selectUser = mysql_query ("Select TenantID, mallID, owner_lastname, owner_firstname, owner_midname, appID, inqID, tradeID, 
tradename, Companyid, companyname, unitID, unitname, datefrom, dateto, status, noofmonths, noofdays, ustatus, dateevic, tenanttype, 
revpercent, withPOS, merchant_code, ContractID, owner_card_number, depamount, uploadingoffiles, payment_terms, payment_type, 
account_number, monthly_dues, daily_dues, assoc_dues, def_password, Contract_NumSAP, Company_CodeSAP, SFTP_User, SFTP_Pass, TP_Setup
from `tbltrans_tenants` where TenantID = '$TenantID' and def_password = '$def_password'");
if(mysql_num_rows($selectUser) != 0){
	
	$row = mysql_fetch_array($selectUser);
	$response["TenantID"] = $row["TenantID"];
	//$companyid =  $row["companyid"];
	$response["mallID"] =  $row["mallID"];
	$response["owner_lastname"] =  $row["owner_lastname"];
	$response["owner_firstname"] =  $row["owner_firstname"];
	$response["owner_midname"] =  $row["owner_midname"];
	$response["appID"] = $row["appID"];
	$response["inqID"] =  $row["inqID"];
	$response["tradeID"] =  $row["tradeID"];
	$response["tradename"] =  $row["tradename"];
	$response["Companyid"] =  $row["Companyid"];
	$response["companyname"] =  $row["companyname"];
	$response["unitID"] =  $row["unitID"];
	$response["unitname"] =  $row["unitname"];
	$response["datefrom"] =  $row["datefrom"];
	$response["dateto"] =  $row["dateto"];
	$response["status"] =  $row["status"];
	$response["noofmonths"] =  $row["noofmonths"];
	$response["noofdays"] =  $row["noofdays"];
	$response["ustatus"] =  $row["ustatus"];
	$response["dateevic"] =  $row["dateevic"];
	$response["tenanttype"] =  $row["tenanttype"];
	$response["revpercent"] =  $row["revpercent"];
	$response["withPOS"] =  $row["withPOS"];
	$response["merchant_code"] =  $row["merchant_code"];
	$response["ContractID"] =  $row["ContractID"];
	$response["owner_card_number"] =  $row["owner_card_number"];
	$response["depamount"] =  $row["depamount"];
	$response["uploadingoffiles"] =  $row["uploadingoffiles"];
	$response["payment_terms"] =  $row["payment_terms"];
	$response["payment_type"] =  $row["payment_type"];
	$response["account_number"] =  $row["account_number"];
	$response["monthly_dues"] =  $row["monthly_dues"];
	$response["daily_dues"] =  $row["daily_dues"];
	$response["assoc_dues"] =  $row["assoc_dues"];
	$response["def_password"] =  $row["def_password"];
	$response["Contract_NumSAP"] =  $row["Contract_NumSAP"];
	$response["Company_CodeSAP"] =  $row["Company_CodeSAP"];
	$response["SFTP_User"] =  $row["SFTP_User"];
	$response["SFTP_Pass"] =  $row["SFTP_Pass"];
	$response["TP_Setup"] =  $row["TP_Setup"];

	$response["success"] =  1;
}else{
	$response["success"] = 2;
}
echo json_encode($response);

?>	