<?php
include("../mms_database.php");
$response = array();
$tenantid = $_POST["ID"];
$response["Request"] = array();

$getItems = mysql_query("select RequestID, RequestCat, RequestTag, APPROVAL_STATUS, APPROVAL_STAGE, APP_STATUS, Remarks, date(xdatetime) as xDATE from `tbltrans_tenantsrequest` WHERE TENANTID = '$tenantid'");
if(mysql_num_rows($getItems)<>0){
	while($Items = mysql_fetch_assoc($getItems)){
		$list = array();
		$list["RequestID"] = isset($Items["RequestID"]) ? $Items["RequestID"]: "";
		
		$getCat = mysql_fetch_assoc(mysql_query("SELECT reqCatDesc FROM `tblreqcategory` WHERE reqCatCode = '".$Items["RequestCat"]."'"));
		$list["RequestCat"] = isset($getCat["reqCatDesc"]) ? $getCat["reqCatDesc"]: "";
		
		$getTag = mysql_fetch_assoc(mysql_query("select reqTagDesc from `tblreqtags` where reqTagCode = '".$Items["RequestTag"]."'"));
		$list["RequestTag"] = isset($getTag["reqTagDesc"]) ? $getTag["reqTagDesc"]: "";
		
		$list["APPROVAL_STATUS"] = isset($Items["APPROVAL_STATUS"]) ? $Items["APPROVAL_STATUS"]: "";
		$list["APPROVAL_STAGE"] = isset($Items["APPROVAL_STAGE"]) ? $Items["APPROVAL_STAGE"]: "";
		$list["APP_STATUS"] = isset($Items["APP_STATUS"]) ? $Items["APP_STATUS"]: "";
		$list["Remarks"] = isset($Items["Remarks"]) ? $Items["Remarks"]: "";
		$list["xDATE"] = isset($Items["xDATE"]) ? $Items["xDATE"]: "";
		array_push($response["Request"], $list);	
	}
$response["success"] = 1;
}else{
$response["success"] = 0;
}
echo json_encode($response);
?>