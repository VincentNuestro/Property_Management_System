<?php
include("../mms_database.php");
$response = array();
$ID = isset($_POST["ID"]) ? $_POST["ID"]: "";
$ApplicationDate = isset($_POST["ApplicationDate"]) ? $_POST["ApplicationDate"]: "";
$UnitID = isset($_POST["UnitID"]) ? $_POST["UnitID"]: "";
$MallID = isset($_POST["MallID"]) ? $_POST["MallID"]: "";
$RequestCat = isset($_POST["RequestCat"]) ? $_POST["RequestCat"]: "";
$RequestTag = isset($_POST["RequestTag"]) ? $_POST["RequestTag"]: "";
$txtremarks = isset($_POST["txtremarks"]) ? $_POST["txtremarks"]: "";
$login = isset($_POST["login"]) ? $_POST["login"]: "";
$logout = isset($_POST["logout"]) ? $_POST["logout"]: "";

$Visitor = isset($_POST["Visitor"]) ? $_POST["Visitor"]: "";
$Items = isset($_POST["Items"]) ? $_POST["Items"]: "";

$arr1 = json_decode( $Visitor , true );
$arr2 = json_decode( $Items , true );
$header = "";

$Getheader = mysql_query("SELECT RequestID FROM `tbltrans_tenantsrequest` ORDER BY RequestID DESC LIMIT 1");
if(mysql_num_rows($Getheader) <> 0){
$rowheader = mysql_fetch_array($Getheader);
$arrheader = array();
$arrheader = explode("-", $rowheader["RequestID"]);
$header = "REQ-". str_pad($arrheader[1] + 1, 7, '0', STR_PAD_LEFT);
}else{
$header = "REQ-0000001";
}

$value1 = 0;
$value2 = 0;

$InsertHeader = mysql_query("INSERT INTO `tbltrans_tenantsrequest` SET TENANTID = '$ID', RequestID = '$header',ApplicationDate = '$ApplicationDate', UnitID = '$UnitID', MallID = '$MallID', xdatetime = '".date("y-m-d")."', RequestCat = '$RequestCat',RequestTag = '$RequestTag' , Remarks = '$txtremarks'");

foreach ($arr1 as $key => $value) {
	$insertVisitor = mysql_query("INSERT INTO `tbltrans_tenantsrequest_visitor` SET RequestID = '$header', fname = '".$value["fname"]."', lname ='".$value["lname"]."', idpres = '".$value["idpress"]."', login = '$login', logout = '$logout', ximage = ''") or $value1 += 1;
}

foreach ($arr2 as $key => $value) {
	$insertItem = mysql_query("Insert Into `tbltrans_tenantsrequest_items` set RequestID = '$header', qty = '".$value["qty"]."', unitx = '".$value["unitx"]."', notes = '".$value["notes"]."', itemname = '".$value["itemname"]."'") or $value2 += 1;
}


if($value1 > 0 && $value2 >0){
	$response["success"] == 5; //error 
}else if ($value1 == 0 && $value2 > 0){
	$response["success"] == 4; // error item success visitor
}else if ($value1 > 0 && $value2 == 0){
	$response["success"] == 3; // error visitor sucess item
}else if ($value1 > 0){
	$response["success"] == 2; // error visitor 
}else if ($value1 == 0){
	$response["success"] == 1; // Success visitor 
}else if ($value2 > 0){
	$response["success"] == 6; // error Item 
}else if ($value2 == 0){
	$response["success"] == 7; // Success Item 
}
	
echo json_encode($response);
?>