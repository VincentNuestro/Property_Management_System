<?php
include("../../android_connect.php");
$response = array();

$validation = $_POST["validation"];

if($validation == "1"){
	
$id = $_POST["id"];
$MallID = $_POST["MallID"];
$Type = $_POST["Type"];
$xDate = $_POST["xDate"];

$getRate = mysql_fetch_array(mysql_query("select ROUND((UtilRate + (UtilRate * (AdminFee/100))),2) as Xrate, 
EffDate from `tblref_utilrate`
WHERE mallid = '$MallID' AND Effdate <='$xDate'
AND type = '$Type' ORDER BY EffDate DESC LIMIT 1"));

$getInformation = mysql_fetch_array(mysql_query("SELECT MeterID, CurrentMeterUsage, UsageStartDate, meter_reading, sub_total,
meter_img, reading_date,(reading_date - UsageStartDate) AS numberDays,
(meter_reading - CurrentMeterUsage) AS TotalConsumption
FROM `tblmaintenance_workorderlist` WHERE id = '$id'"));

$response["MeterID"] = isset($getInformation["MeterID"]) ? $getInformation["MeterID"] : "";
$response["BillingPeriod"] = $getInformation["UsageStartDate"] . " / " . $getInformation["reading_date"];
$response["NumberOfDays"] = isset($getInformation["numberDays"]) ? $getInformation["numberDays"] : "0";
$response["PreviousReading"] = isset($getInformation["CurrentMeterUsage"]) ? $getInformation["CurrentMeterUsage"] : "0";
$response["CurrentReading"] = isset($getInformation["meter_reading"]) ? $getInformation["meter_reading"] : "";
$response["TotalConsumption"] = isset($getInformation["TotalConsumption"]) ? $getInformation["TotalConsumption"] : "";
$response["BillingFactor"] = isset($getRate["Xrate"]) ? $getRate["Xrate"] : "";
$response["Amount"] = isset($getInformation["sub_total"]) ? $getInformation["sub_total"] : "";

		if(empty($getInformation["meter_img"])){
			$response["meter_img"] = "";
		}
		else{	
			$img_name = $getInformation["meter_img"];
			if (false !== ($contents = @file_get_contents('http://localhost/mms_mall/'.$img_name))) {
			$response["meter_img" ] = base64_encode(file_get_contents('http://localhost/mms_mall/'.$img_name));
			}
			else{
			$response["meter_img"] = "";
			}
		}
		
$response["success"] = 1;
}elseif ($validation == "2"){
	
	$taskID = $_POST["taskID"];
	$CatID = $_POST["CatID"];
	$JobOrder = $_POST["JobOrder"];
	
	if($taskID == ""){
		$GetData1 = mysql_fetch_assoc(mysql_query("select W.`schedduration`, W.`sub_total`, C.`isFixed`, C.`FixedAmount`
		from `tblmaintenance_workorderlist` W 
		INNER JOIN `tblmaintenance_category` C ON W.`xcategory` = C.`category_id`
		where W.`xcategory` = '$CatID' AND W.`workorderid` = '$JobOrder'"));
		
		if($GetData1["isFixed"] == "Yes"){
			$response["schedduration"] = isset($GetData1["schedduration"]) ? $GetData1["schedduration"] : "";
			$response["FixedAmount"] = isset($GetData1["FixedAmount"]) ? $GetData1["FixedAmount"] : "0.00";
		}else{
			$response["schedduration"] = isset($GetData1["schedduration"]) ? $GetData1["schedduration"] : "";
			$response["FixedAmount"] = isset($GetData1["sub_total"]) ? $GetData1["sub_total"] : "0.00";
		}
	}else{
		$GetData = mysql_fetch_assoc(mysql_query("select W.`schedduration`, W.`sub_total`, C.`isFixed`, C.`FixedAmount`
		from `tblmaintenance_workorderlist` W 
		INNER JOIN `tblmaintenance_category` C ON W.`xcategory` = C.`category_id`
		where W.`xtaskid` = '$taskID' AND W.`workorderid` = '$JobOrder'"));
		
		if($GetData["isFixed"] == "Yes"){
			$response["schedduration"] = isset($GetData["schedduration"]) ? $GetData["schedduration"] : "";
			$response["FixedAmount"] = isset($GetData["FixedAmount"]) ? $GetData["FixedAmount"] : "0.00";
		}else{
			
			$GetDataFromTasklist = mysql_fetch_assoc(mysql_query("Select amount from `tblmaintenance_tasklist` 
			where taskid = '$taskID'"));
			
			$response["schedduration"] = isset($GetData["schedduration"]) ? $GetData["schedduration"] : "";
			$response["FixedAmount"] = isset($GetDataFromTasklist["amount"]) ? $GetDataFromTasklist["amount"] : "0.00";
		}
	}
	
	$response["success"] = 1;
	
}

echo json_encode($response);
?>	