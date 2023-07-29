<?php

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

$response = array();
//$response["Category"] = array();
$response["OFFLINEDATA"] = array();
$response["PROPERTY"] = array();
$response["MallInfo"] = array();
$NewDummy = array();
$DummyHeader = array();
$counter = 0;

//12-4-18 Remove
//$selectAllData = mysql_query("select category_id, category, icon from `tblmaintenance_category` order by id");
//if(mysql_num_rows($selectAllData) <> 0){
//	while($Items = mysql_fetch_array($selectAllData)){
//		$list = array();
//		$list["category_id"] = $Items["category_id"];
//		$list["category"] = $Items["category"];
//		$iconHolder = $Items["icon"];
		
//		if(empty($iconHolder)){
//			$Items["icon"] = "";
//		}
//		else{	
//			$img_name = $iconHolder;
//			if (false !== ($contents = @file_get_contents('http://localhost/mms_mall/server/Maintenance/Category/'.$img_name))) {
//			$list["icon"] = base64_encode(file_get_contents('http://localhost/mms_mall/server/Maintenance/Category/'.$img_name));
//			}
//			else{
//			$list["icon"] = "";
//			}
//		}
		
//		array_push($response["Category"], $list);
//	}
//	$counter = $counter + 1;
//}


//--------------------------------------------------------------------------------------------------------------------------------------
$GetMall = mysql_query("select mallid, mallname, email, telephone_number, malladdress from `tblref_mall`");
if(mysql_num_rows($GetMall) <> 0){
	while($rowItem = mysql_fetch_array($GetMall)){
		$items = array();
		$items["mallid"] = isset( $rowItem["mallid"]) ?  $rowItem["mallid"] : "";
		$items["mallname"] = isset( $rowItem["mallname"]) ?  $rowItem["mallname"] : "";
		$items["email"] = isset( $rowItem["email"]) ?  $rowItem["email"] : "";
		$items["telephone_number"] = isset( $rowItem["telephone_number"]) ?  $rowItem["telephone_number"] : "";
		$items["malladdress"] = isset( $rowItem["malladdress"]) ?  $rowItem["malladdress"] : "";
		array_push($response["MallInfo"], $items);
	}
}
//--------------------------------------------------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------------------------------------------------
$SelectUserAndMallAccess = mysql_query("Select userid, MallAccess from `tbluser`");
if(mysql_num_rows($SelectUserAndMallAccess) <> 0){
		while($rowItem = mysql_fetch_array($SelectUserAndMallAccess)){
		$data = explode('@', $rowItem[1]);
			foreach ($data as $key => $value){
				if($value != ""){
					//echo " sample " .  $value . " / " . $rowItem["userid"] ;
					$list = array();
					$list["UserId"] = $rowItem["userid"];
					$list["MallId"] = $value;
					array_push($response["PROPERTY"], $list);
				}
			}
		}
}
//--------------------------------------------------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------------------------------------------------
$selectHeaderInformation = mysql_query("SELECT workorderid, tradename, xdate FROM 
`tblmaintenance_workorder`WHERE xstatus = 'Pending'");
if(mysql_num_rows($selectHeaderInformation) <> 0){
	
	$selectPrimaryInformation = mysql_query("SELECT  L.`startdate`, W.workorderid, W.tenantid, W.xcategory, 
	W.taskstatus, W.reading_date, L.`tradename`,C.category, C.icon, T.mallID,
	L.workerid
	FROM `tblmaintenance_workorderlist` W
	INNER JOIN tblmaintenance_workorder L ON W.workorderid = L.workorderid
	INNER JOIN tblmaintenance_category C ON W.xcategory = C.category_id
	INNER JOIN tbltrans_tenants T ON W.tenantid = T.TenantID
	WHERE W.taskstatus = 'Pending' and L.`startdate` != '' ORDER BY DATE(W.reading_date) ASC");
	
	if(mysql_num_rows($selectPrimaryInformation) <> 0){
		while($Items = mysql_fetch_array($selectPrimaryInformation)){
		$listItem = array();
			$listItem["startdate"] = $Items["startdate"];
			$listItem["workorderid"] = $Items["workorderid"];
			$listItem["tenantid"] = $Items["tenantid"];
			$listItem["xcategory"] = $Items["xcategory"];
			$listItem["taskstatus"] = $Items["taskstatus"];
			$listItem["reading_date"] = $Items["reading_date"];
			$listItem["category"] = $Items["category"];
			$iconHolder = $Items["icon"];
			$workerid = $Items["workerid"];
			
			$workorderid = isset( $Items["workorderid"]) ?  $Items["workorderid"] : "";
			$tradename = isset( $Items["tradename"]) ?  $Items["tradename"] : "";
			$reading_date = isset( $Items["reading_date"]) ?  $Items["reading_date"] : "";
			
			
			//----------------------------------------------------------------
			$getPreviousReading = mysql_query("SELECT meter_reading, sub_total FROM 
			`tblmaintenance_workorderlist` WHERE tenantid = '".$Items["tenantid"]."' 
			AND xcategory = '".$Items["category"]."' AND reading_date < '".$Items["reading_date"]."' ORDER BY id DESC");
			if(mysql_num_rows($getPreviousReading) <> 0){
			$Items = mysql_fetch_array($selectPrimaryInformation);
			$listItem["meter_reading"] = $Items ["meter_reading"];
			$listItem["sub_total"] = $Items ["sub_total"];
			}
			else{
			$listItem["meter_reading"] = "0000000";
			$listItem["sub_total"] = "0";
			}
			//----------------------------------------------------------------
			
			//----------------------------------------------------------------
			$Type;
			$Push;
			if ($Items["category"] == "Electric Reading"){
				$Type = "Electric";
				//echo "YES " . $Items["category"] . "\n";
				$Push = 1;
			}
			else if ($Items["category"] == "Water Reading"){
				$Type = "Water";
				//echo "YES " . $Items["category"] . "\n";
				$Push = 1;
			}
			else if ($Items["category"] == "Gas Reading"){
				$Type = "Gas";
				//echo "YES " . $Items["category"] . "\n";
				$Push = 1;
			}else{
				$Type = "";
				//echo "NO " . $Items["category"] . "\n";
				$Push = 0;
			}
			//----------------------------------------------------------------
					
			$listItem["MallID"] = $Items["mallID"];
			//----------------------------------------------------------------
			$getRate = mysql_query("select UtilRate from `tblref_utilrate` where mallid = '".$Items["mallID"]."' and
			type = '$Type' and EffDate <= '".$Items["reading_date"]."' order by id DESC LIMIT 1 ");
			if(mysql_num_rows($getRate) <> 0){
				$Items = mysql_fetch_array($getRate);
				$listItem["Rate"] = (float) $Items["UtilRate"];
			}else{
				$listItem["Rate"] = (float) "0";
			}
			//----------------------------------------------------------------
			
			$listItem["workerid"] = $workerid;
	
			
			//----------------------------------------------------------------
			if($Push == 1){
					array_push($response["OFFLINEDATA"], $listItem);
					//$list = array();
					//$list["workorderid"] = $workorderid;
					//$list["tradename"] = $tradename;
					//$list["xdate"] = $reading_date;
					//$list["workerid"] = $workerid;
					//array_push($DummyHeader, $list);				
			}
			//----------------------------------------------------------------
		}
	}
	$counter = $counter + 1;
}

if($counter == 1){
	$response["success"] = 1;
}else{
	$response["success"] = 2;
}

echo json_encode($response);
?>	