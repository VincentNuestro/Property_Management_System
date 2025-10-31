<?php
	session_start();
	include('../connect.php');
	if(!file_exists("../../Mall_Attachments/BevLogs")){
		mkdir("../../Mall_Attachments/BevLogs", 0777, true);
	}

	$BevTempalte = $_FILES["txtImportedBevFile"]["name"];
	$TMPBevTemplate = $_FILES["txtImportedBevFile"]["tmp_name"];

	if($BevTempalte == ""){
		echo "2|Please select a file you want to upload.";
	}else{
		$UploadID = createidno("BEV", "tbltrans_BevList", "UploadID");
		$BevSuccessCount = 0;
		$BevSuccessHeader = 0;
		$OpenBevTemplate = fopen($TMPBevTemplate, "r");
		$rowBevTemplate = fgetcsv($OpenBevTemplate, 1000, ";"); //Remove if CSV file does not have column headings
		while(($rowBevTemplate = fgetcsv($OpenBevTemplate)) != FALSE){
			if($rowBevTemplate[0] != ''){
				$resInsertBev = mysql_query("INSERT INTO tbltrans_BevList SET UploadID = '". $UploadID ."', Trans_Date = '". date('Y-m-d', strtotime($rowBevTemplate[0])) ."', TenantID = '". $rowBevTemplate[1] ."', Trans_Code = '". $rowBevTemplate[2] ."', Trans_Desc = '". $rowBevTemplate[3] ."', Quantity = '". $rowBevTemplate[5] ."', Trans_Amount = '". $rowBevTemplate[4] ."', Trans_VAT = '". $rowBevTemplate[6] ."', Trans_TotAmount = '". $rowBevTemplate[7] ."', Reference = '". $rowBevTemplate[8] ."', Mall_ID = '". $rowBevTemplate[9] ."';", $connection);
				if($resInsertBev == true){
					$BevSuccessCount++;
				}
			}
		}
		if($BevSuccessCount >= 1){
			$resInsertBevLogs = mysql_query("INSERT INTO tbltrans_BevLogs SET UploadID = '". $UploadID ."', UploadDate = '". getsysdate() ."', UploadTime = '". date('H:i:a') ."', UploadStatus = 'Not Posted', UserID = '". $_SESSION['MMS-UserID'] ."', MallID = '". $_SESSION['MMS-Designation'] ."';", $connection);
			if($resInsertBevLogs == true){
				$BevSuccessHeader++;
			}
		}
		if($BevSuccessHeader >= 1){
			echo "1|Import success.";
		}else{
			echo "2|Failed import.";
		}
	}
?>