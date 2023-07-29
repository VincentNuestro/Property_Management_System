<?php
include("mms_database.php");
$response = array();

$userName = $_POST['username'];
$password = md5($_POST["pass"]);

// $userName = "TENANT-0000001";
// $password = md5("jco");

$LoginQueryForUser = mysql_query ("select TenantID, mallID, owner_lastname, owner_firstname, owner_midname,appID, 
inqID, tradeID, tradename, CompanyID, companyname, unitID, unitname, tenanttype,
merchant_code, ContractID, depamount, uploadingoffiles, payment_terms, payment_type,
cardtype, cardholder, authno, seccode, expirydate, bankfrom, bf_accno, bankto, bt_accno,
account_number, monthly_dues, daily_dues, assoc_dues, Contract_NumSAP, Company_CodeSAP, datefrom, dateto, noofmonths
from `tbltrans_tenants` where TenantID = '".$userName ."' AND def_password2 = '".$password."'");

	if(mysql_num_rows($LoginQueryForUser) <> 0){
		$row = mysql_fetch_array($LoginQueryForUser);
		$response["TenantID"] = isset($row["TenantID"]) ? $row["TenantID"] : "";
		$response["mallID"] = isset($row["mallID"]) ? $row["mallID"] : "";
		$response["owner_lastname"] = isset($row["owner_lastname"]) ? $row["owner_lastname"] : "";
		$response["owner_firstname"] = isset($row["owner_firstname"]) ? $row["owner_firstname"] : "";
		$response["owner_midname"] = isset($row["owner_midname"]) ? $row["owner_midname"] : "";
		$response["appID"] = isset($row["appID"]) ? $row["appID"] : "";
		$response["inqID"] = isset($row["inqID"]) ? $row["inqID"] : "";
		$response["tradename"] = isset($row["tradename"]) ? $row["tradename"] : "";
		$response["CompanyID"] = isset($row["CompanyID"]) ? $row["CompanyID"] : "";
		$response["companyname"] = isset($row["companyname"]) ? $row["companyname"] : "";
		$response["unitID"] = isset($row["unitID"]) ? $row["unitID"] : "";
		$response["unitname"] = isset($row["unitname"]) ? $row["unitname"] : "";
		$response["tenanttype"] = isset($row["tenanttype"]) ? $row["tenanttype"] : "";
		$response["merchant_code"] = isset($row["merchant_code"]) ? $row["merchant_code"] : "";
		$response["ContractID"] = isset($row["ContractID"]) ? $row["ContractID"] : "";
		$response["depamount"] = isset($row["depamount"]) ? $row["depamount"] : "";
		$response["uploadingoffiles"] = isset($row["uploadingoffiles"]) ? $row["uploadingoffiles"] : "";
		$response["payment_terms"] = isset($row["payment_terms"]) ? $row["payment_terms"] : "";
		$response["payment_type"] = isset($row["payment_type"]) ? $row["payment_type"] : "";
		$response["cardtype"] = isset($row["cardtype"]) ? $row["cardtype"] : "";
		$response["cardholder"] = isset($row["cardholder"]) ? $row["cardholder"] : "";
		$response["authno"] = isset($row["authno"]) ? $row["authno"] : "";
		$response["seccode"] = isset($row["seccode"]) ? $row["seccode"] : "";
		$response["expirydate"] = isset($row["expirydate"]) ? $row["expirydate"] : "";
		$response["bankfrom"] = isset($row["bankfrom"]) ? $row["bankfrom"] : "";
		$response["bf_accno"] = isset($row["bf_accno"]) ? $row["bf_accno"] : "";
		$response["bankto"] = isset($row["bankto"]) ? $row["bankto"] : "";
		$response["bt_accno"] = isset($row["bt_accno"]) ? $row["bt_accno"] : "";
		$response["account_number"] = isset($row["account_number"]) ? $row["account_number"] : "";
		$response["monthly_dues"] = isset($row["monthly_dues"]) ? $row["monthly_dues"] : "";
		$response["daily_dues"] = isset($row["daily_dues"]) ? $row["daily_dues"] : "";
		$response["assoc_dues"] = isset($row["assoc_dues"]) ? $row["assoc_dues"] : "";
		$response["Contract_NumSAP"] = isset($row["Contract_NumSAP"]) ? $row["Contract_NumSAP"] : "";
		$response["Company_CodeSAP"] = isset($row["Company_CodeSAP"]) ? $row["Company_CodeSAP"] : "";
		$response["datefrom"] = isset($row["datefrom"]) ? $row["datefrom"] : "";
		$response["dateto"] = isset($row["dateto"]) ? $row["dateto"] : "";
		$response["noofmonths"] = isset($row["noofmonths"]) ? $row["noofmonths"] : "";
		$response["success"] = 1;
}else{
	$response["success"] = 2;
}
echo json_encode($response);
?>
