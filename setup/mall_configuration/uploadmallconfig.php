<?php
	session_start();
	include("../../connect.php");
	require_once '../../assets/Classes/PHPExcel.php';
	$UnitMeasurement = SysLeaseSetup('floorandunitmeasurement');
	$isAssocDues = SysLeaseSetup('isAssocDues');
	$excel = PHPExcel_IOFactory::load($_FILES["txtImportedFile"]["tmp_name"]);
	if(!file_exists("../../../Mall_Attachments/Mall Config/". $_REQUEST['txtImportMallID'])){
		mkdir("../../../Mall_Attachments/Mall Config/". $_REQUEST['txtImportMallID'], 0777, true);
	}

	$Movefile = 0;

	$excel->setActiveSheetIndex(0); //FIRST SHEET OF EXCEL / WING
	$Sheet1 = 2;
	while ($excel->getActiveSheet()->getCell('A'.$Sheet1)->getValue()!='') {
		$ifExisting = mysql_num_rows(mysql_query("SELECT id FROM tblref_wing WHERE wing = '". $excel->getActiveSheet()->getCell('A'.$Sheet1)->getValue() ."';", $connection));
		if($ifExisting == 0){
			$CreateWingID = createidno("WING", "tblref_wing", "wingID");
			$resInsertWing = mysql_query("INSERT INTO tblref_wing SET wingID = '". $CreateWingID ."', wing = '". $excel->getActiveSheet()->getCell('A'.$Sheet1)->getValue() ."', mallID = '". $_REQUEST['txtImportMallID'] ."';", $connection);
			if($resInsertWing == true){
				$Movefile++;
			}
		}
		$Sheet1++;
	}

	$excel->setActiveSheetIndex(1); //SECOND SHEET OF EXCEL / FLOOR
	$Sheet2 = 2;
	while ($excel->getActiveSheet()->getCell('A'.$Sheet2)->getValue()!='') {

		$CreateFloorID = createidno("FLOOR", "tblref_floorsetup", "floorid");
		$getWingID = mysql_fetch_array(mysql_query("SELECT wingID FROM tblref_wing WHERE wing = '".  $excel->getActiveSheet()->getCell('A'.$Sheet2)->getValue() ."';", $connection));
		$ifExistingFlr = mysql_num_rows(mysql_query("SELECT id FROM tblref_flr WHERE floor = '". $excel->getActiveSheet()->getCell('B'.$Sheet2)->getValue() ."';", $connection));
		if($ifExistingFlr == 0){
			$resInsertFloor = mysql_query("INSERT INTO tblref_flr SET floor = '". $excel->getActiveSheet()->getCell('B'.$Sheet2)->getValue() ."';", $connection);
		}
		$ifExistingFlrRef = mysql_num_rows(mysql_query("SELECT id FROM tblref_floorsetup WHERE floor = '". $excel->getActiveSheet()->getCell('B'.$Sheet2)->getValue() ."' AND wingid = '". $getWingID[0] ."' AND mallid = '". $_REQUEST['txtImportMallID'] ."'", $connection));
		if($ifExistingFlrRef == 0){

			if($UnitMeasurement == 'Area'){
				$FloorMeasurement = ", TLA = '". $excel->getActiveSheet()->getCell('C'.$Sheet2)->getValue() ."', GLA = '". $excel->getActiveSheet()->getCell('D'.$Sheet2)->getValue() ."'";
			}else{
				$FloorMeasurement = ", width2 = '". $excel->getActiveSheet()->getCell('C'.$Sheet2)->getValue() ."', length2 = '". $excel->getActiveSheet()->getCell('D'.$Sheet2)->getValue() ."', minarea = '". $excel->getActiveSheet()->getCell('E'.$Sheet2)->getValue() ."'";
			}

			$resInsertFlrSetup = mysql_query("INSERT INTO tblref_floorsetup SET floorid = '". $CreateFloorID ."', wingid = '". $getWingID[0] ."', mallid = '". $_REQUEST['txtImportMallID'] ."', floor = '". $excel->getActiveSheet()->getCell('B'.$Sheet2)->getValue() ."' ". $FloorMeasurement .";", $connection);
			if($resInsertFlrSetup == true){
				$Movefile++;
			}

		}
		$Sheet2++;
	}

	$excel->setActiveSheetIndex(2); //THIRD SHEET OF EXCEL / UNIT
	$Sheet3 = 2;
	while ($excel->getActiveSheet()->getCell('A'.$Sheet3)->getValue()!='') {
		$CreateUnitID = createidno("U", "tblref_unit", "unitid");
		$getWingID = mysql_fetch_array(mysql_query("SELECT wingID FROM tblref_wing WHERE wing = '". $excel->getActiveSheet()->getCell('C'.$Sheet3)->getValue() ."';", $connection));
		$getFloorID = mysql_fetch_array(mysql_query("SELECT floorid FROM tblref_floorsetup WHERE floor = '". $excel->getActiveSheet()->getCell('D'.$Sheet3)->getValue() ."' AND wingid = '". $getWingID[0] ."' AND mallid = '". $_REQUEST['txtImportMallID'] ."';", $connection));
		$ifExistingUnit = mysql_num_rows(mysql_query("SELECT id FROM tblref_unit WHERE unitname = '". $excel->getActiveSheet()->getCell('A'.$Sheet3)->getValue() ."' AND mallid = '". $_REQUEST['txtImportMallID'] ."' AND wingid = '". $getWingID[0] ."' AND floorid = '". $getFloorID[0] ."';", $connection));
		$getMainUnitID = mysql_fetch_array(mysql_query("SELECT unitid FROM tblref_unit WHERE unitname = '". $excel->getActiveSheet()->getCell('E'.$Sheet3)->getValue() ."' AND mallid = '". $_REQUEST['txtImportMallID'] ."' AND wingid = '". $getWingID[0] ."' AND floorid = '". $getFloorID[0] ."';", $connection));
		if($ifExistingUnit == 0){

			if($UnitMeasurement == 'Area'){
				$Condition2 = ", sqmunitsetup = '0', pricepersqmunitsetup = '". $excel->getActiveSheet()->getCell('G'.$Sheet3)->getValue() ."', totalamountunitsetup = '". floatval($excel->getActiveSheet()->getCell('F'.$Sheet3)->getValue() * $excel->getActiveSheet()->getCell('G'.$Sheet3)->getValue()) ."', area = '". $excel->getActiveSheet()->getCell('G'.$Sheet3)->getValue() ."'";
				if($isAssocDues == 1){
					$Condition3 = ", assocdues = '". $excel->getActiveSheet()->getCell('H'.$Sheet3)->getValue() ."'";
				}else{
					$Condition3 = "";
				}
			}else{
				$Condition2 = ", sqmunitsetup = '". floatval($excel->getActiveSheet()->getCell('F'.$Sheet3)->getValue() * $excel->getActiveSheet()->getCell('G'.$Sheet3)->getValue()) ."', pricepersqmunitsetup = '". $excel->getActiveSheet()->getCell('H'.$Sheet3)->getValue() ."', totalamountunitsetup = '". floatval(($excel->getActiveSheet()->getCell('E'.$Sheet3)->getValue() * $excel->getActiveSheet()->getCell('H'.$Sheet3)->getValue()) * $excel->getActiveSheet()->getCell('H'.$Sheet3)->getValue()) ."', sqm_width = '". $excel->getActiveSheet()->getCell('F'.$Sheet3)->getValue() ."', sqm_height = '". $excel->getActiveSheet()->getCell('G'.$Sheet3)->getValue() ."'";
				if($isAssocDues == 1){
					$Condition3 = ", assocdues = '". $excel->getActiveSheet()->getCell('I'.$Sheet3)->getValue() ."'";
				}else{
					$Condition3 = "";
				}
			}

			if($excel->getActiveSheet()->getCell('E'.$Sheet3)->getValue() != ''){
				$Condition4 = ", MainUnit = '". $getMainUnitID[0] ."'";
			}else{
				$Condition4 = "";
			}

			$resInsertUnit = mysql_query("INSERT INTO tblref_unit SET unitid = '". $CreateUnitID ."', unitname = '". $excel->getActiveSheet()->getCell('A'.$Sheet3)->getValue() ."', buildingname = '". $excel->getActiveSheet()->getCell('C'.$Sheet3)->getValue() ."', typeofbusiness = '". $excel->getActiveSheet()->getCell('B'.$Sheet3)->getValue() ."', mallid = '". $_REQUEST['txtImportMallID'] ."', floorid = '". $getFloorID[0] ."', wingid = '". $getWingID[0] ."', dateadded = '". getsysdate() ."', startDate = '". getsysdate() ."' ". $Condition2 . $Condition3 . $Condition4 .";", $connection);
			if($resInsertUnit == true){
				$Movefile++;
			}
		}
		$Sheet3++;
	}

	if($Movefile >= 1){
		$CreateMCLogs = createidno("MC", "tbltrans_mallconf", "TransID");
		$resInsertLogs = mysql_query("INSERT INTO tbltrans_mallconf SET TransID = '". $CreateMCLogs ."', userid = '". $_SESSION['MMS-UserID'] ."', TransDate = '". getsysdate() ."', TransTime = '". date('H:i:s') ."', MallID = '". $_REQUEST['txtImportMallID'] ."', FileType = '". explode(".", $_FILES['txtImportedFile']['name'])[1] ."';", $connection);
		$Filename = $CreateMCLogs .".". explode(".", $_FILES['txtImportedFile']['name'])[1];
		move_uploaded_file($_FILES["txtImportedFile"]["tmp_name"], "../../../Mall_Attachments/Mall Config/". $_REQUEST['txtImportMallID'] ."/". $Filename);
		echo 1;
	}
?>