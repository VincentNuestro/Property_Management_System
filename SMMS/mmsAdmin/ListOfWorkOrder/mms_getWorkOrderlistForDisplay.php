<?php
include("../../android_connect.php");

$response = array();
$Validation = $_POST["Validation"];	

//$Validation = '3';

if($Validation == "1"){
	$response["WorkOrderList"] = array();
	$SelectWorkOrderList = mysql_query("select workorderid, xdate, tradename, workername, 
	xstatus from `tblmaintenance_workorder`  ORDER BY id DESC");
	if(mysql_num_rows($SelectWorkOrderList) <> 0){
		while($rowItem = mysql_fetch_array($SelectWorkOrderList)){
			$list = array();
			$list["workorderid"] = isset($rowItem["workorderid"]) ? $rowItem["workorderid"] : "";
			$list["xdate"] = isset($rowItem["xdate"]) ? $rowItem["xdate"] : "";
			$list["tradename"] = isset($rowItem["tradename"]) ? $rowItem["tradename"] : "";
			$list["workername"] = isset($rowItem["workername"]) ? $rowItem["workername"] : "";
			$list["xstatus"] =  isset($rowItem["xstatus"]) ? $rowItem["xstatus"] : "";
			array_push($response["WorkOrderList"], $list);
		}
		$response["success"] = 1;
	}
	else{
		$response["success"] = 0;
	}
}
else if ($Validation == "2"){
	$response["WorkOrderList"] = array();
	$TaskID = $_POST["TaskID"];
	
	//----------------------------------------------------------------------------------------New 12-26-18
	$SelectNewDetails = mysql_query("select W.xcategory, W.xtaskid, W.taskstatus, W.MeterID
	from `tblmaintenance_workorderlist` W
	where W.workorderid = '$TaskID'");
	if(mysql_num_rows($SelectNewDetails) <> 0){
		while($rowItem = mysql_fetch_array($SelectNewDetails)){
			

			
			if($rowItem["MeterID"] != ""){
			//---------------------------------------------------------------------------
			//echo "1 <br>";
			$list = array();
			$list["taskstatus"] = isset($rowItem["taskstatus"]) ? $rowItem["taskstatus"] : "";
			$list["MeterID"] = isset($rowItem["MeterID"]) ? $rowItem["MeterID"] : "";
			$GetCategory = mysql_fetch_array(mysql_query("SELECT category from `tblmaintenance_category` where category_id = '".$rowItem["xcategory"]."'"));
			$list["category"] = isset($GetCategory["category"]) ? $GetCategory["category"] : "";
			array_push($response["WorkOrderList"], $list);
			//---------------------------------------------------------------------------
			}else if ($rowItem["xtaskid"] != ""){
			//---------------------------------------------------------------------------
			//echo "2 <br>";
			$list = array();
			$list["taskstatus"] = isset($rowItem["taskstatus"]) ? $rowItem["taskstatus"] : "";
			$GetTask = mysql_fetch_array(mysql_query("SELECT description FROM `tblmaintenance_tasklist` WHERE taskid = '".$rowItem["xtaskid"]."'"));
			$list["MeterID"] = isset($GetTask["description"]) ? $GetTask["description"] : "";
			$GetCategory = mysql_fetch_array(mysql_query("SELECT category from `tblmaintenance_category` where category_id = '".$rowItem["xcategory"]."'"));
			$list["category"] = isset($GetCategory["category"]) ? $GetCategory["category"] : "";
			array_push($response["WorkOrderList"], $list);
			//---------------------------------------------------------------------------			
			}else if ($rowItem["xtaskid"] == "" && $rowItem["MeterID"] == ""){
			//---------------------------------------------------------------------------
			//echo "3 <br>";
			$list = array();			
			$GetCategory = mysql_fetch_array(mysql_query("SELECT category from `tblmaintenance_category` where category_id = '".$rowItem["xcategory"]."'"));
			$list["taskstatus"] = isset($rowItem["taskstatus"]) ? $rowItem["taskstatus"] : "";
			$list["MeterID"] = isset($GetCategory["category"]) ? $GetCategory["category"] : "";
			$list["category"] = "";
			array_push($response["WorkOrderList"], $list);
			//---------------------------------------------------------------------------
			}
			//MainTotal
		}
		$response["success"] = 1;
	}
	else{
		$response["success"] = 0;
	}
	
	
}
else if ($Validation == "3"){
	$response["WorkOrderList"] = array();
	//$response["Header"] = array();
	$TaskID = $_POST["TaskID"];
	//$TaskID = 'JO-0000316';
	$value = 0;
	
	$SelectInformation = mysql_query("SELECT M.mall_image, M.mallname, M.malladdress, M.telephone_number,  M.email,
	T.TenantID, T.tradename, CONCAT(T.owner_firstname,' ', T.owner_midname,' ',T.owner_lastname) AS cperson, C.content
	FROM `tbltrans_tenants` T 
	INNER JOIN `tblmaintenance_workorderlist` W ON T.TenantID = W.`tenantid`
	INNER JOIN `tblref_mall` M ON T.mallID = M.mallid
	INNER JOIN `tbltrans_company_owner_contacts` C ON C.CompanyID = T.CompanyID
	WHERE W.workorderid = '$TaskID' LIMIT 1");
	
	if(mysql_num_rows($SelectInformation)<>0){
		$rowItem = mysql_fetch_array($SelectInformation);
		
		if(empty($rowItem["mall_image"])){
			$response["mall_image"] = "";
		}
		else{	
			$img_name = $rowItem["mall_image"];
			if (false !== ($contents = @file_get_contents('http://localhost/mms_mall/server/mall_image/'.$img_name))) {
			$response["mall_image"] = base64_encode(file_get_contents('http://localhost/mms_mall/server/mall_image/'.$img_name));
			}
			else{
			$response["mall_image"] = "";
			}
		}
		
		//$response["mall_image"] = $rowItem["mall_image"];
		$response["mallname"] = $rowItem["mallname"];
		$response["malladdress"] = $rowItem["malladdress"];
		$response["telephone_number"] = $rowItem["telephone_number"];
		$response["email"] = $rowItem["email"];
		$response["TenantID"] = $rowItem["TenantID"];
		$response["tradename"] = $rowItem["tradename"];
		$response["cperson"] = $rowItem["cperson"];
		$response["buildingname"] = "";//$rowItem["buildingname"];
		$response["floor"] = "";//$rowItem["floor"];
		$response["unitname"] = "";//$rowItem["unitname"];
		$response["content"] = $rowItem["content"];
		$value = $value + 1;
	}
	else{
		$value = $value + 0;
	}
	

	//12-25-18
	//---------------------------------------------------------------------------------------------------------------
	
	$selectDataHeader = mysql_query("SELECT C.category, W.xcategory
	FROM `tblmaintenance_workorderlist` W
	LEFT JOIN tblmaintenance_category C ON C.category_id = W.xcategory
	WHERE workorderid = '$TaskID' GROUP BY W.xcategory
	ORDER BY W.xtaskid ASC, W.reading_date DESC;");
	
	$MainTotal = 0;

	if(mysql_num_rows($selectDataHeader) <> 0){
		while($rowItem = mysql_fetch_array($selectDataHeader)){
			$items = array();
			$items["Header"] = $rowItem["category"];
			$items["SubItem"] = array();
			
			$totalsub = 0;
			
			if($rowItem["category"] == 'Electric Reading' || $rowItem["category"] == 'Water Reading' || $rowItem["category"] == 'Gas Reading'){
				
				$selectDataSecond = mysql_query("SELECT W.MeterID, W.taskstatus, W.CurrentMeterUsage, W.meter_reading, 
				W.UsageStartDate, W.reading_date, W.sub_total,
				W.schedduration, C.`isFixed`, C.`FixedAmount`
				FROM `tblmaintenance_workorderlist` W
				INNER JOIN tblmaintenance_category C ON C.category_id = W.xcategory
				WHERE workorderid = '$TaskID' AND W.xcategory = '".$rowItem["xcategory"]."'");
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
						$totalsub += (float)$list1["sub_total"];
						$list1["schedduration"] = isset($SecondData["schedduration"]) ? $SecondData["schedduration"] : "0.0";
						array_push($items["SubItem"], $list1);
					}
				}
				
				$items["indicator"] = "1";
				$items["Status"] = "";
				$items["SubTotal"] = $totalsub;
				$MainTotal += (float)$totalsub;
			}
			else{
				
				$selectDataThird = mysql_query("SELECT T.description, W.taskstatus, W.CurrentMeterUsage, W.meter_reading, 
				W.UsageStartDate, W.reading_date, T.amount,
				W.schedduration, C.`isFixed`, C.`FixedAmount`
				FROM `tblmaintenance_workorderlist` W
				INNER JOIN `tblmaintenance_tasklist` T ON T.taskid = W.xtaskid
				INNER JOIN tblmaintenance_category C ON C.category_id = W.xcategory
				WHERE workorderid = '$TaskID' AND W.xcategory = '".$rowItem["xcategory"]."'");
			
				if(mysql_num_rows($selectDataThird) <> 0){
					while($SecondThird = mysql_fetch_array($selectDataThird)){
						$list2 = array();
						$list2["MeterID"] = isset($SecondThird["description"]) ? $SecondThird["description"] : "";
						$list2["taskstatus"] = isset($SecondThird["taskstatus"]) ? $SecondThird["taskstatus"] : "";
							$list2["CurrentMeterUsage"] = isset($SecondThird["CurrentMeterUsage"]) ? $SecondThird["CurrentMeterUsage"] : "";
						$list2["meter_reading"] = isset($SecondThird["meter_reading"]) ? $SecondThird["meter_reading"] : "";
						$list2["UsageStartDate"] = isset($SecondThird["UsageStartDate"]) ? $SecondThird["UsageStartDate"] : "";
						$list2["reading_date"] = isset($SecondThird["reading_date"]) ? $SecondThird["reading_date"] : "";
						
						if($SecondThird["isFixed"] == 'Yes'){
						$list2["sub_total"] = isset($SecondThird["FixedAmount"]) ? $SecondThird["FixedAmount"] : "0.0";		
						}else{
						$list2["sub_total"] = isset($SecondThird["amount"]) ? $SecondThird["amount"] : "0.0";						
						}
						$totalsub += (float)$list2["sub_total"];
						$list2["schedduration"] = isset($SecondThird["schedduration"]) ? $SecondThird["schedduration"] : "";
						array_push($items["SubItem"], $list2);
					}
					$items["indicator"] = "2";
					$items["Status"] = "";
					$items["SubTotal"] = $totalsub;
					$MainTotal += (float)$totalsub;
				}
				else{
					
					$selectDataAlternative = mysql_query("SELECT FixedAmount FROM `tblmaintenance_category` WHERE category_id = '".$rowItem["xcategory"]."'");
					if(mysql_num_rows($selectDataAlternative) <> 0){
						while($Secondfourth = mysql_fetch_array($selectDataAlternative)){
							
						//echo "Category id "  . $rowItem["xcategory"] . "<br>";
						
						$list3 = array();
						$list3["MeterID"] = "";
						$list3["taskstatus"] = "";
						$list3["CurrentMeterUsage"] = "";
						$list3["meter_reading"] = "";
						$list3["UsageStartDate"] = "";
						$list3["reading_date"] = "";
						$list3["sub_total"] = $Secondfourth["FixedAmount"];
						$totalsub += (float)$list3["sub_total"];
						$list3["schedduration"] = "0";
						array_push($items["SubItem"], $list3);
						}
						$items["indicator"] = "3";
						
						//Karl 01-28-19
						$getStatus = mysql_fetch_assoc(mysql_query("SELECT taskstatus FROM `tblmaintenance_workorderlist` WHERE 
						xcategory = '".$rowItem["xcategory"]."' AND workorderid = '$TaskID'"));
						
						$items["Status"] = $getStatus["taskstatus"];
						$items["SubTotal"] = $totalsub;
						$MainTotal += (float)$totalsub;
					}
				}
				//indicator
			}
			array_push($response["WorkOrderList"],$items);
		}
	$response["MainTotal"] = $MainTotal;
	$value = $value + 1;
	}
	else{
	$value = $value + 0;
	}
	
	//---------------------------------------------------------------------------------------------------------------
	
	
	if($value == 2){
		$response["success"] = 1;
	}else{
		$response["success"] = 0;
	}
	
}


echo json_encode($response);
?>