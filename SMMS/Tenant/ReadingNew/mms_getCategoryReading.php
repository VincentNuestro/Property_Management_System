<?php
include("../../android_connect.php");

$response = array();
$response["Category"] = array();
$id = $_POST["id"];
$date = $_POST["date"];

//$id = "USER-0000002";
//$date = "2018-12-11";
$xcategory;

$geticonFirst = mysql_query("SELECT category_id, category, icon FROM `tblmaintenance_category`");
if(mysql_num_rows($geticonFirst) <> 0){
	while($rowItem = mysql_fetch_array($geticonFirst)){
		
		$list = array();
		
		$xcategory = $rowItem["category_id"];

		$getDetails = mysql_query("SELECT COUNT(W.id) as counter, W.xcategory, C.category, C.icon
		FROM tblmaintenance_workorderlist W
		INNER JOIN `tblmaintenance_workorder` H ON W.workorderid = H.workorderid
		INNER JOIN `tblmaintenance_category` C ON C.category_id = W.xcategory
		where H.TenantID = '$id' and 
		W.xcategory = '".$rowItem["category_id"]."' AND H.startdate = '$date' GROUP BY W.xcategory");
		$Items = mysql_fetch_array($getDetails);
		$list["counter"] = isset($Items["counter"]) ? $Items["counter"] : "0";
		//--------------------------------------------------------------------------------------------------------
		$list["xcategory"] = $xcategory;
		$list["category"] = isset($rowItem["category"]) ? $rowItem["category"] : "";
		
		if(empty($rowItem["icon"])){
			$list["icon"] = "";
		}
		else{	
			$img_name = $rowItem["icon"];
			if (false !== ($contents = @file_get_contents('http://localhost/mms_mall/server/Maintenance/Category/'.$img_name))) {
			$list["icon"] = base64_encode(file_get_contents('http://localhost/mms_mall/server/Maintenance/Category/'.$img_name));
			}
			else{
			$list["icon"] = "";
			}
		}
		array_push($response["Category"], $list);
	}
	$response["success"] = 1;
}else{
	$response["success"] = 0;
}
echo json_encode($response);
?>