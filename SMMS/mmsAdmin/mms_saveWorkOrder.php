<?php

/*
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
*/
include("../android_connect.php");

$response = array();

$catcat = $_POST["catcat"];
$JobOrder = $_POST["JobOrder"];
$tenantID = $_POST["tenantID"];
$xDate = $_POST["xDate"];
$Reading = $_POST["Reading"];
$sub_total = $_POST["sub_total"];
$imagesSting = $_POST["imagesSting"];

$SignatureString = $_POST["SignatureString"];
$Comment = $_POST["Comment"];

//-------------------------------------------------------------------12-09-2018
$MeterID = $_POST["MeterID"];
$id = $_POST["id"];


$selectidforname = mysql_query("SELECT id FROM `tblmaintenance_workorderlist` 
WHERE workorderid = '$JobOrder' AND tenantid = '$tenantID' AND xcategory = '$catcat'
and id = '$id' and MeterID = '$MeterID'");
if(mysql_num_rows($selectidforname) <> 0){
$idname = mysql_fetch_array($selectidforname);
$NewIDname =  $idname["id"];
$reading = "Reading";
$stringPath = "server/Maintenance/" . $reading. "/" . $JobOrder . "/".$NewIDname.".JPG";

$signature = "Signature";
$signaturePath = "server/Maintenance/" . $signature. "/" . $JobOrder . "/".$NewIDname.".JPG";

	if($imagesSting != ""){
		
		//karl 10-22-2018
		if (!file_exists("../../server/Maintenance/" . $reading)) {
		mkdir("../../server/Maintenance/" . $reading , 0777, true);
	
			if (!file_exists("../../server/Maintenance/" . $reading. "/" . $JobOrder)) {
			mkdir("../../server/Maintenance/" . $reading. "/" . $JobOrder, 0777, true);
					if($imagesSting != ""){
					$imagesSting = str_replace('data:image/png;base64,', '', $imagesSting);
					$imagesSting = str_replace(' ', '+', $imagesSting);
					$data = base64_decode($imagesSting);
					file_put_contents("../../server/Maintenance/" . $reading. "/" . $JobOrder . "/" .$NewIDname.".JPG",$data);
					}
			}
		}else{
			if (!file_exists("../../server/Maintenance/" . $reading. "/" . $JobOrder)) {
			mkdir("../../server/Maintenance/" . $reading. "/" . $JobOrder, 0777, true);
				if($imagesSting != ""){
					$imagesSting = str_replace('data:image/png;base64,', '', $imagesSting);
					$imagesSting = str_replace(' ', '+', $imagesSting);
					$data = base64_decode($imagesSting);
					file_put_contents("../../server/Maintenance/" . $reading. "/" . $JobOrder . "/" .$NewIDname.".JPG",$data);
				}
			}else{
				if($imagesSting != ""){
					$imagesSting = str_replace('data:image/png;base64,', '', $imagesSting);
					$imagesSting = str_replace(' ', '+', $imagesSting);
					$data = base64_decode($imagesSting);
					file_put_contents("../../server/Maintenance/" . $reading. "/" . $JobOrder . "/" .$NewIDname.".JPG",$data);
				}
			}
		}
		
		
		//karl 11-13-2018
		if (!file_exists("../../server/Maintenance/" . $signature)) {
		mkdir("../../server/Maintenance/" . $signature , 0777, true);
	
			if (!file_exists("../../server/Maintenance/" . $signature. "/" . $JobOrder)) {
			mkdir("../../server/Maintenance/" . $signature. "/" . $JobOrder, 0777, true);
					if($SignatureString != ""){
					$SignatureString = str_replace('data:image/png;base64,', '', $SignatureString);
					$SignatureString = str_replace(' ', '+', $SignatureString);
					$data = base64_decode($SignatureString);
					file_put_contents("../../server/Maintenance/" . $signature. "/" . $JobOrder . "/" .$NewIDname.".JPG",$data);
					}
			}
		}else{
			if (!file_exists("../../server/Maintenance/" . $signature. "/" . $JobOrder)) {
			mkdir("../../server/Maintenance/" . $signature. "/" . $JobOrder, 0777, true);
				if($SignatureString != ""){
					$SignatureString = str_replace('data:image/png;base64,', '', $SignatureString);
					$SignatureString = str_replace(' ', '+', $SignatureString);
					$data = base64_decode($SignatureString);
					file_put_contents("../../server/Maintenance/" . $signature. "/" . $JobOrder . "/" .$NewIDname.".JPG",$data);
				}
			}else{
				if($SignatureString != ""){
					$SignatureString = str_replace('data:image/png;base64,', '', $SignatureString);
					$SignatureString = str_replace(' ', '+', $SignatureString);
					$data = base64_decode($SignatureString);
					file_put_contents("../../server/Maintenance/" . $signature. "/" . $JobOrder . "/" .$NewIDname.".JPG",$data);
				}
			}
		}
		
		
		$count = mysql_query("Select count(id) as idcount from `tblmaintenance_workorderlist` where workorderid = '$JobOrder' and 
		tenantid = '$tenantID' and reading_date = '$xDate' and taskstatus = 'Pending'");
			if(mysql_num_rows($count) <> 0){
			$countx = mysql_fetch_array($count);
			$toCount = $countx["idcount"];
			
				if (intval($toCount) == 1){
				$updateWork = mysql_query("update `tblmaintenance_workorderlist` set taskstatus = 'Resolved', 
				meter_reading = '$Reading', sub_total = '$sub_total', meter_img = '$stringPath', comment = '$Comment', signature = '$signaturePath'
				where workorderid = '$JobOrder' AND tenantid = '$tenantID' and xcategory = '$catcat'
				and MeterID = '$MeterID' and id= '$id'");
					
				$updateworkorder = mysql_query("UPDATE `tblmaintenance_workorder` SET xstatus = 'Resolved' WHERE workorderid = '$JobOrder'");
				}
				else{
				$updateWork = mysql_query("update `tblmaintenance_workorderlist` set taskstatus = 'Resolved', 
				meter_reading = '$Reading', sub_total = '$sub_total', meter_img = '$stringPath', comment = '$Comment', signature = '$signaturePath'
				where workorderid = '$JobOrder' AND tenantid = '$tenantID' and xcategory = '$catcat'
				and MeterID = '$MeterID' and id= '$id'");
				}
			
			}
			
		//Karl 03-28-2019	
		$Updatetblref_meter = mysql_query("UPDATE `tblref_meter` SET currentMeterUsage = '$Reading' WHERE meterID = '$MeterID'");
			
			
		$response["success"] = 1;	
		}
	
}
else{
	$response["success"] = 2;
}
echo json_encode($response);
?>	


