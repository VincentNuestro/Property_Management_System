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

include("../../../android_connect.php");

$response = array();
$oldData = array();


$workorderid = $_POST["workorderid"];
$tenantid = $_POST["tenantid"];
$xcategory = $_POST["xcategory"];
$xtaskid = $_POST["xtaskid"];
$reading_date = $_POST["reading_date"];

/*
$workorderid="JO-0000312";
$tenantid="TENANT-0000004";
$xcategory="CAT-000005";
$xtaskid='';
$reading_date="2018-12-25";
*/

$MeterType;

$selectCategory = mysql_query("SELECT category FROM `tblmaintenance_category` WHERE category_id = '$xcategory'");
if(mysql_num_rows($selectCategory) <> 0){
	$rowItem = mysql_fetch_array($selectCategory);
	//echo $rowItem["category"];
	if($rowItem["category"] == 'Electric Reading'){
		$MeterType = 'Electric';
	}else if ($rowItem["category"] == 'Water Reading'){
		$MeterType = 'Water';
	}else if ($rowItem["category"] == 'Gas Reading'){
		$MeterType = 'Gas';
	}else{
		$MeterType = '';
	}
	//echo "Meter Type " . $MeterType;
}

if($MeterType == ""){
	//---------------------------------------------------------------------------------
	$valid = 1; // for roll back 
	mysql_query('START TRANSACTION' , $connection );
	mysql_query('BEGIN' , $connection );

	//$getDataValue = mysql_query("SELECT COUNT(id) as countendRow FROM `tblmaintenance_workorderlist`
	//WHERE workorderid = '$workorderid' AND tenantid = '$tenantid'
	//AND xcategory = '$xcategory' AND xtaskid = '' AND taskstatus = 'Pending'");
	//if(mysql_num_rows($getDataValue) <> 0){
	//		$response["success"] = 2;
	//}else{
		//------------------------------------------------------------------------------------------
		$InsertWorkOrder = "INSERT INTO `tblmaintenance_workorderlist` SET workorderid = '$workorderid', tenantid = '$tenantid',
		xcategory = '$xcategory', xtaskid = '$xtaskid'";
		mysql_query( $InsertWorkOrder , $connection ) or $valid = 0;

		//for rollback				
		if( $valid == 0 ) {
			mysql_query('ROLBACK',$connection);
			$response["success"] = 0;
		} 
		else {
			mysql_query('COMMIT',$connection);
			$response["success"] = 1;
		}
		//------------------------------------------------------------------------------------------
//	}
	
	
	

	//---------------------------------------------------------------------------------
}

else if ($MeterType == 'Electric' || $MeterType == 'Water' || $MeterType == 'Gas') {
	
	$GetlastDate = mysql_fetch_array (mysql_query("select reading_date, MeterID, CurrentMeterUsage from `tblmaintenance_workorderlist` where 
	tenantid = '$tenantid' and xcategory = '$xcategory' group by MeterID order by reading_date Desc limit 1"));
	
	if($GetlastDate["reading_date"] != "" || $GetlastDate["reading_date"] != "1970-01-01"){
		$GetValue = mysql_query("select MeterID, CurrentMeterUsage, Multiplier, SysDate from `tblref_meterlogs` 
		where MeterType = '$MeterType' and AssignedTenant = '$tenantid' and SysDate > '". $GetlastDate["reading_date"] ."' 
		GROUP BY MeterID order by SysDate DESC");
		
		if(mysql_num_rows($GetValue) <> 0){
			while($row = mysql_fetch_array($GetValue)){
				$list = array();
				$list["MeterID"] = $row["MeterID"];
				$list["CurrentMeterUsage"] = $row["CurrentMeterUsage"];
				array_push($oldData, $list);
			}
		}
		
	}
	else{
		$readingDate;
			$SelectLastReadingINtenant = mysql_fetch_array(mysql_query("SELECT LMRWater, LMRElectric, LMRGas 
			FROM `tbltrans_tenants` WHERE TenantID = '$tenantid'"));
		
		//echo "Here";
		
		if($MeterType == 'Electric'){
			$readingDate = $SelectLastReadingINtenant["LMRElectric"];
		}else if($MeterType == 'Water'){
			$readingDate = $SelectLastReadingINtenant["LMRWater"];
		}else if($MeterType == 'Gas'){
			$readingDate = $SelectLastReadingINtenant["LMRGas"];
		}
		
		//echo "<br> Reading Date" . $readingDate;
		
		if($readingDate != ""){
		$GetValue = mysql_query("select MeterID, CurrentMeterUsage, Multiplier, SysDate from `tblref_meterlogs` 
		where MeterType = '$MeterType' and AssignedTenant = '$tenantid' and SysDate > '$readingDate' 
		GROUP BY MeterID order by SysDate DESC");
			if(mysql_num_rows($GetValue) <> 0){
				while($row = mysql_fetch_array($GetValue)){
					$list = array();
					$list["MeterID"] = $row["MeterID"];
					$list["CurrentMeterUsage"] = $row["CurrentMeterUsage"];
					$list["SysDate"] = $row["SysDate"];
					array_push($oldData, $list);
				}
			}
		}
		
	}
	
	$valid = count($oldData);
	//echo "<br> old Data " . $valid;
	
	
	if (count($oldData) > 0){
		for ($x = 0; $x <= count($oldData); $x++) {
			if($oldData[$x]["MeterID"] == ''){
				
			}else{
			//----------------------------------------------------------------------------------------------------------
			mysql_query('START TRANSACTION' , $connection );
			mysql_query('BEGIN' , $connection );

			//echo "<br> " . $oldData[$x]["MeterID"];
 			
			$getDataValueMeter = mysql_query("SELECT COUNT(id) as countendRow FROM `tblmaintenance_workorderlist`
			WHERE workorderid = '$workorderid' AND tenantid = '$tenantid'
			AND xcategory = '$xcategory' AND MeterID ='".$oldData[$x]["MeterID"]."' AND taskstatus = 'Pending'");
			if(mysql_num_rows($getDataValueMeter) == 0 ){
				//echo "Sample";
			}else{
				$InsertWorkOrder = "INSERT INTO `tblmaintenance_workorderlist` SET workorderid = '$workorderid', tenantid = '$tenantid',
				xcategory = '$xcategory', xtaskid = '$xtaskid', 
				MeterID ='".$oldData[$x]["MeterID"]."', CurrentMeterUsage ='".$oldData[$x]["CurrentMeterUsage"]."', UsageStartDate = '".$oldData[$x]["SysDate"]."',
				reading_date='".getsysdate()."'";
				mysql_query( $InsertWorkOrder , $connection ) or $valid = $valid - 1;	
			}
			
			
			//----------------------------------------------------------------------------------------------------------
			}
		} 
		
		if( $valid == count($oldData) ) {
			mysql_query('COMMIT',$connection);
			$response["success"] = 1;
		} else {
			mysql_query('ROLBACK',$connection);
			$response["success"] = 0;
		}
	}
}


	
echo json_encode($response);
?>	