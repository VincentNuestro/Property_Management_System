<?php
include("../../android_connect.php");
$response = array();
$response["information"] = array();

$selectDataHeader = mysql_query("SELECT C.category, W.xcategory
FROM `tblmaintenance_workorderlist` W
INNER JOIN tblmaintenance_category C ON C.category_id = W.xcategory
WHERE workorderid = 'JO-0000318' GROUP BY W.xcategory");

if(mysql_num_rows($selectDataHeader) <> 0){
	while($rowItem = mysql_fetch_array($selectDataHeader)){
		$items = array();
		$items["Header"] = $rowItem["category"];
		$items["SubItem"] = array();
		
		if($rowItem["category"] == 'Electric Reading' || $rowItem["category"] == 'Water Reading' || $rowItem["category"] == 'Gas Reading'){
			
			$selectDataSecond = mysql_query("SELECT W.MeterID, W.taskstatus, W.CurrentMeterUsage, W.meter_reading, 
			W.UsageStartDate, W.reading_date, W.sub_total,
			W.schedduration
			FROM `tblmaintenance_workorderlist` W
			INNER JOIN tblmaintenance_category C ON C.category_id = W.xcategory
			WHERE workorderid = 'JO-0000318' AND W.xcategory = '".$rowItem["xcategory"]."'");
			if(mysql_num_rows($selectDataSecond) <> 0){
				while($SecondData = mysql_fetch_array($selectDataSecond)){
					$list1 = array();
					$list1["MeterID"] = isset($SecondData["MeterID"]) ? $SecondData["MeterID"] : "";
					$list1["taskstatus"] = isset($SecondData["taskstatus"]) ? $SecondData["taskstatus"] : "";
					$list1["CurrentMeterUsage"] = isset($SecondData["CurrentMeterUsage"]) ? $SecondData["CurrentMeterUsage"] : "";
					$list1["meter_reading"] = isset($SecondData["meter_reading"]) ? $SecondData["meter_reading"] : "";
					$list1["UsageStartDate"] = isset($SecondData["UsageStartDate"]) ? $SecondData["UsageStartDate"] : "";
					$list1["reading_date"] = isset($SecondData["reading_date"]) ? $SecondData["reading_date"] : "";
					$list1["sub_total"] = isset($SecondData["sub_total"]) ? $SecondData["sub_total"] : "0.0";
					$list1["schedduration"] = isset($SecondData["schedduration"]) ? $SecondData["schedduration"] : "0.0";
					array_push($items["SubItem"], $list1);
				}
			}
			
		}
		else{
			
			$selectDataThird = mysql_query("SELECT T.description, W.taskstatus, W.CurrentMeterUsage, W.meter_reading, 
			W.UsageStartDate, W.reading_date, T.amount,
			W.schedduration
			FROM `tblmaintenance_workorderlist` W
			INNER JOIN `tblmaintenance_tasklist` T ON T.taskid = W.xtaskid
			WHERE workorderid = 'JO-0000318' AND W.xcategory = '".$rowItem["xcategory"]."'");
		
			if(mysql_num_rows($selectDataThird) <> 0){
				while($SecondThird = mysql_fetch_array($selectDataThird)){
					$list2 = array();
					$list2["MeterID"] = isset($SecondThird["description"]) ? $SecondThird["description"] : "";
					$list2["taskstatus"] = isset($SecondThird["taskstatus"]) ? $SecondThird["taskstatus"] : "";
					$list2["CurrentMeterUsage"] = isset($SecondThird["CurrentMeterUsage"]) ? $SecondThird["CurrentMeterUsage"] : "";
					$list2["meter_reading"] = isset($SecondThird["meter_reading"]) ? $SecondThird["meter_reading"] : "";
					$list2["UsageStartDate"] = isset($SecondThird["UsageStartDate"]) ? $SecondThird["UsageStartDate"] : "";
					$list2["reading_date"] = isset($SecondThird["reading_date"]) ? $SecondThird["reading_date"] : "";
					$list2["sub_total"] = isset($SecondThird["amount"]) ? $SecondThird["amount"] : "";
					$list2["schedduration"] = isset($SecondThird["schedduration"]) ? $SecondThird["schedduration"] : "";
					array_push($items["SubItem"], $list2);
				}
			}
			else{
				
				$selectDataAlternative = mysql_query("SELECT FixedAmount FROM `tblmaintenance_category` WHERE category_id = '".$rowItem["xcategory"]."'");
				if(mysql_num_rows($selectDataAlternative) <> 0){
					while($Secondfourth = mysql_fetch_array($selectDataAlternative)){
					$list3 = array();
					$list3["MeterID"] = "";
					$list3["taskstatus"] = "";
					$list3["CurrentMeterUsage"] = "";
					$list3["meter_reading"] = "";
					$list3["UsageStartDate"] = "";
					$list3["reading_date"] = "";
					$list3["sub_total"] = $Secondfourth["FixedAmount"];
					array_push($items["SubItem"], $list3);
					}
				}
			}
			
		}
		array_push($response["information"],$items);
	}
}	

echo json_encode($response);
?>