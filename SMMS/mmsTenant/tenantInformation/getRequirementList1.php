<?php
include("../mms_database.php");
$response = array();		
$response["RequirementList"] = array();
//$InquiryID = $_POST["InquiryID"];
$InquiryID = "IIP-0000069";
$getRequirement = mysql_query("SELECT type_req_ID, filename, docname, docdesc, appID, filetype 
FROM tbltrans_leasingapplicationreq WHERE reqID = '$InquiryID'");
if(mysql_num_rows($getRequirement)<>0){
	while($items = mysql_fetch_assoc($getRequirement)){
		$list = array();
		
		$getDocument = mysql_fetch_assoc(mysql_query("SELECT requirements FROM tblref_applicationrequirements WHERE id = '".$items["type_req_ID"]."'"));
	
		$list["type_req_ID"] = $getDocument["requirements"];
		$list["filename"] = $items["filename"];
		$list["docname"] = $items["docname"];
		$list["docdesc"] = $items["docdesc"];
		$list["appID"] = $items["appID"];
		
		if(empty($list["filename"])){
			$list["item_picture"] = "";
		}
		else{
			$img_name = $items["appID"] . '/' . $list["type_req_ID"] . '/'. $items["filename"];
			//echo 'http://localhost/mms_mall/server/Requirements/' . $items["appID"] . '/' . $list["type_req_ID"] . '/'. $img_name . " </br> </br>" ;
			//additional 07-9-18
			if (false !== ($contents = @file_get_contents('http://localhost/mms_mall/server/Requirements/' . $img_name))){
			//echo 'http://localhost/mms_mall/server/Requirements/' . $img_name . "</br>";
			$list["item_picture"] = base64_encode(file_get_contents('http://localhost/mms_mall/server/Requirements/' . $img_name));
			}
			else {
			$list["item_picture"] = "";
			}
			
			/*
			if (false !== ($contents = @file_get_contents('http://localhost/mms_mall/server/Requirements/' . $list["appID"]. '/' . $list["type_req_ID"] . '/' . $img_name))) {
			$list["filename"] = base64_encode(file_get_contents('http://localhost/mms_mall/server/Requirements/'$list["appID"]. '/' . $list["type_req_ID"] . '/' . $img_name));
			} 
			else {
				$list["filename"] = "";
				}
			*/
			
		}
		
		$list["filetype"] = $items["filetype"];
		
		array_push($response["RequirementList"], $list);
	}
	$response["success"] = 1;
}else{
	$response["success"] = 2;
}
echo json_encode($response);
?>