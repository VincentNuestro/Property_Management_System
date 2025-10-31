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
$response["HEADER"] = array();
$response["OFFLINEDATA"] = array();
$NewDummy = array();
$DummyHeader = array();
//$userid = $_POST["userid"];
//$userid = 'USER-0000002';

$selectHeaderInformation = mysql_query("SELECT workorderid, tradename, xdate FROM 
`tblmaintenance_workorder`WHERE xstatus = 'Pending'");
//`tblmaintenance_workorder`WHERE workerid = '$userid' AND xstatus = 'Pending'");
if(mysql_num_rows($selectHeaderInformation) <> 0){
	
	//while($Items = mysql_fetch_array($selectHeaderInformation)){
	//$listItem = array();
	//$listItem["workorderid"] = $Items["workorderid"];
	//$listItem["tradename"] = $Items["tradename"];
	//$listItem["xdate"] = $Items["xdate"];
	//array_push($response["HEADER"], $listItem);
	//}

	$selectPrimaryInformation = mysql_query("SELECT W.workorderid, W.tenantid, W.xcategory, 
	W.taskstatus, W.reading_date, L.`tradename`,C.category, C.icon, T.mallID,
	L.workerid
	FROM `tblmaintenance_workorderlist` W
	INNER JOIN tblmaintenance_workorder L ON W.workorderid = L.workorderid
	INNER JOIN tblmaintenance_category C ON W.xcategory = C.category_id
	INNER JOIN tbltrans_tenants T ON W.tenantid = T.TenantID
	WHERE W.taskstatus = 'Pending' ORDER BY DATE(W.reading_date) ASC");
	//	WHERE L.workerid = '$userid' AND W.taskstatus = 'Pending' order by W.id DESC");
	
	if(mysql_num_rows($selectPrimaryInformation) <> 0){
		while($Items = mysql_fetch_array($selectPrimaryInformation)){
			$listItem = array();
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
			
			//----------------------------------------------------------------
			if(empty($iconHolder)){
				$listItem["icon"] = "";
			}
			else{	
			$img_name = $iconHolder;
				//echo $img_name;
				if (false !== ($contents = @file_get_contents('http://localhost/mms_mall/server/Maintenance/Category/'.$img_name))) {
				$listItem["icon"] = base64_encode(file_get_contents('http://localhost/mms_mall/server/Maintenance/Category/'.$img_name));
				}
				else{
				$listItem["icon"] = "";
				}
			}
			//----------------------------------------------------------------

			$listItem["workerid"] = $workerid;
			
			//----------------------------------------------------------------
			if($Push == 1){
					array_push($response["OFFLINEDATA"], $listItem);
					$list = array();
					$list["workorderid"] = $workorderid;
					$list["tradename"] = $tradename;
					$list["xdate"] = $reading_date;
					$list["workerid"] = $workerid;
					array_push($DummyHeader, $list);				
			}
			//----------------------------------------------------------------
			
			
			
		}
		
		$NewDummy = array_unique($DummyHeader, SORT_REGULAR);
		
		$counter = count($DummyHeader);
		for ($x = 0; $x <= $counter; $x++) {
			if (isset($NewDummy[$x]["workorderid"])){
			$list["workorderid"] = $NewDummy[$x]["workorderid"];
			$list["tradename"] = $NewDummy[$x]["tradename"];
			$list["xdate"] = $NewDummy[$x]["xdate"];
			$list["workerid"] =$NewDummy[$x]["workerid"];
			array_push($response["HEADER"], $list);
			}
		} 
		
			
		$response["success"] = 1;
	}
	else{

	}
}
else{
		$response["success"] = 2;
}
echo json_encode($response);
?>	