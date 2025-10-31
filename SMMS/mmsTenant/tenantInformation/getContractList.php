<?php
include("../mms_database.php");
$response = array();		
$response["ContractList"] = array();
$tenantID = $_POST["TenantID"];

//$tenantID = "TENANT-0000065";

$getContract = mysql_query("SELECT datefrom, dateto, unitid, contractID FROM tblcontract WHERE tenantid = '$tenantID'");
if(mysql_num_rows($getContract)<>0){
	while($items = mysql_fetch_assoc($getContract)){
		$list = array();
		$list["contractID"] = $items["contractID"];
		$list["unitid"] = $items["unitid"];
		$list["datefrom"] = $items["datefrom"];
		$list["dateto"] = $items["dateto"];
		array_push($response["ContractList"], $list);
		}
	$response["success"] = 1;
}else{
	$response["success"] = 2;
}
echo json_encode($response);
?>