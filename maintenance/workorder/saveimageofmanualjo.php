<?php
	session_start();
	include('../../connect.php');
	$file = $_FILES['meter_image']['name'];
	$filetype = $_FILES["meter_image"]["type"];
	$filesize = $_FILES["meter_image"]["size"];
	$tmp_name = $_FILES["meter_image"]["tmp_name"];

	if(!file_exists("../../../Mall_Attachments/Maintenance/Reading/". $_REQUEST['txtWorkOrderID'])){
		mkdir("../../../Mall_Attachments/Maintenance/Reading/". $_REQUEST['txtWorkOrderID'], 0777, true);
	}
	
	$TaskInfo = mysql_fetch_array(mysql_query("SELECT CurrentMeterUsage FROM tblmaintenance_workorderlist WHERE id = '". $_REQUEST['txtTaskID'] ."'", $connection));

	$TenantInfo = mysql_fetch_array(mysql_query("SELECT TenantID, xdate, mallid FROM tblmaintenance_workorder WHERE workorderid = '". $_REQUEST['txtWorkOrderID'] ."';", $connection));

	$getMultiplier = mysql_fetch_array(mysql_query("SELECT Multiplier FROM tblref_meter WHERE MeterID = '". $_REQUEST['txtMeterID'] ."';", $connection));

	if($_REQUEST['txtMeterType'] == "Electric"){
		$UtilRate = getUtilRate('Electric', $_SESSION['MMS-Designation'], date('Y-m-d', strtotime($_REQUEST['txtReadingDate'])));
		$MinimumConsumption = explode("|", getrentvattype($TenantInfo['mallid']))[10];
	}else if($_REQUEST['txtMeterType'] == "Water"){
		$UtilRate = getUtilRate('Water', $_SESSION['MMS-Designation'], date('Y-m-d', strtotime($_REQUEST['txtReadingDate'])));
		$MinimumConsumption = explode("|", getrentvattype($TenantInfo['mallid']))[11];
	}else if($_REQUEST['txtMeterType'] == "Gas"){
		$UtilRate = getUtilRate('Gas', $_SESSION['MMS-Designation'], date('Y-m-d', strtotime($_REQUEST['txtReadingDate'])));
		$MinimumConsumption = explode("|", getrentvattype($TenantInfo['mallid']))[12];
	}

	$TotalConsumption = str_replace(",", "", $_REQUEST['txtCurrentReading']) - floatval($TaskInfo['CurrentMeterUsage']);
	if($TotalConsumption > $MinimumConsumption){
		$Consumption = floatval($TotalConsumption);
	}else{
		$Consumption = floatval($MinimumConsumption);
	}

	$BillAmount = floatval($UtilRate) * floatval($Consumption * $getMultiplier['Multiplier']);

	$ext = explode(".", $file);
	if($file == ""){
		$MeterImg = "";
	}else{
		$MeterImg = "meter_img = '". "../Mall_Attachments/Maintenance/Reading/". $_REQUEST['txtWorkOrderID'] ."/". $_REQUEST['txtTaskID'] .".". end($ext) ."',";
	}
	$res = mysql_query("UPDATE tblmaintenance_workorderlist SET ". $MeterImg ." meter_reading = '". str_replace(",", "", $_REQUEST['txtCurrentReading']) ."', sub_total = '". $BillAmount ."', taskstatus = 'Resolved', reading_date = '". date('Y-m-d', strtotime($_REQUEST['txtReadingDate'])) ."' WHERE workorderid = '". $_REQUEST['txtWorkOrderID'] ."' AND xcategory = '". $_REQUEST['txtCategoryID'] ."' AND id = '". $_REQUEST['txtTaskID'] ."';", $connection);
	if($res == true){
		$UpdaterefMeter = mysql_query("UPDATE tblref_meter SET CurrentMeterUsage = '". str_replace(",", "", $_REQUEST['txtCurrentReading']) ."' WHERE AssignedTenant = '". $TenantInfo['TenantID'] ."' AND MeterID = '". $_REQUEST['txtMeterID'] ."' AND MeterType = '". $_REQUEST['txtMeterType'] ."';", $connection);
		$UpdaterefMeter = mysql_query("INSERT INTO tblref_meterlogs SET MeterID = '". $_REQUEST['txtMeterID'] ."', MeterType = '". $_REQUEST['txtMeterType'] ."', CurrentMeterUsage = '". str_replace(",", "", $_REQUEST['txtCurrentReading']) ."', AssignedTenant = '". $TenantInfo['TenantID'] ."', SysDate = '". date('Y-m-d', strtotime($_REQUEST['txtReadingDate'])) ."';", $connection);

		$getAllStatus = mysql_fetch_array(mysql_query("SELECT taskstatus FROM tblmaintenance_workorderlist WHERE workorderid = '". $_REQUEST['txtWorkOrderID'] ."' ORDER BY taskstatus ASC LIMIT 1;", $connection));
		$resUpdateWOHeader = mysql_fetch_array(mysql_query("UPDATE tblmaintenance_workorder SET xstatus = '". $getAllStatus['taskstatus'] ."' WHERE workorderid = '". $_REQUEST['txtWorkOrderID'] ."';", $connection));
		move_uploaded_file($tmp_name, "../../../Mall_Attachments/Maintenance/Reading/". $_REQUEST['txtWorkOrderID'] ."/" . $_REQUEST['txtTaskID'] .".". end($ext));


		echo $_REQUEST['txtWorkOrderID']."||";
	}

	mysql_close($connection);
?>