<?php
include("../mms_database.php");
$response = array();		
$response["ContractDetials"] = array();
$tenantID = $_POST["TenantID"];
$InquiryID = $_POST["InquiryID"];
$ContractID = $_POST["ContractID"];
$mallid = $_POST["mallid"];
$CompanyID = $_POST["CompanyID"];

$getContract = mysql_query("SELECT Term_Name, Conditions FROM tblcontract WHERE InquiryID = '".$InquiryID."' AND TenantID = '".$tenantID."' AND ContractID = '".$ContractID."'");

$CompanyID = mysql_fetch_assoc(mysql_query("SELECT content FROM tbltrans_company_owner_contacts where CompanyID  = '".$CompanyID."'"));

$mallid = mysql_fetch_assoc(mysql_query("SELECT malladdress FROM tblref_mall WHERE mallid = '".$mallid."'"));
$InquiryID = mysql_fetch_assoc(mysql_query("SELECT Address FROM tbltrans_inquiry WHERE inquiry_id = '".$InquiryID."'"));


$response["content"] = isset($CompanyID["content"]) ? $CompanyID["content"] : "";
$response["malladdress"] = isset($mallid["malladdress"]) ? $mallid["malladdress"] : "";
$response["Address"] = isset($InquiryID["Address"]) ? $InquiryID["Address"] : ""; 

if(mysql_num_rows($getContract) <> 0){
	while($rowItem = mysql_fetch_array($getContract)){
		$list = array();
		$list["Term_Name"] = str_replace("|","@@",$rowItem["Term_Name"]);
		$list["Conditions"] = str_replace("|","@@",$rowItem["Conditions"]);
		array_push($response["ContractDetials"],$list);
	}
	$response["success"] = 1;
}else{
	$response["success"] = 2;
}
echo json_encode($response);
?>