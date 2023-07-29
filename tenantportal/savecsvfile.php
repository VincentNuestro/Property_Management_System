<?php
    session_start();
	include('../connect.php');
	set_include_path(get_include_path() . PATH_SEPARATOR . 'phpseclib');
	include('phpseclib/Net/SFTP.php');
	$resTenant = mysql_query("SELECT mallID, merchant_code, withPOS, SFTP_User, SFTP_Pass, TP_Setup, unitID FROM tbltrans_tenants WHERE TenantID = '". $_REQUEST['TenantID'] ."'AND ustatus = 'Occupied' AND datefrom <= '". date('Y-m-d', strtotime($_REQUEST['txtInputDateCSV'])) ."' AND dateto >= '". date('Y-m-d', strtotime($_REQUEST['txtInputDateCSV'])) ."';", $connection);
	$rowTenant = mysql_fetch_array($resTenant);

	$SyncFileStat = mysql_fetch_array(mysql_query("SELECT sales, discount, void_refund, salesperhour, paymenttype, reportDate, countSync FROM db_syncfilestat WHERE reportDate = '". date('Y-m-d', strtotime($_REQUEST['txtInputDateCSV'])) ."' AND tenantID = '". $_REQUEST['TenantID'] ."' LIMIT 1;", $connection));

	$filepath = mysql_fetch_array(mysql_query("SELECT filepath, dbsetup, SFTPHost, SFTPPort FROM tblsys_setup;", $connection));
	$SystemSetupPath = str_replace("\\", "/", $filepath['filepath']);

	if(!file_exists($SystemSetupPath . $rowTenant['mallID'] ."/". $rowTenant['merchant_code'])){
		mkdir($SystemSetupPath . $rowTenant['mallID'] ."/". $rowTenant['merchant_code'], 0777, true);
	}

	$tblDiscount = tblDiscount($filepath['dbsetup']);
	$tblHourly = tblHourly($filepath['dbsetup']);
	$tblPayment = tblPayment($filepath['dbsetup']);
	$tblVoid = tblVoid($filepath['dbsetup']);
	$tblSales = tblSales($filepath['dbsetup']);

	if($filepath['dbsetup'] == "1"){
		// FOR MONTH
		if(date('n', strtotime($_REQUEST['txtInputDateCSV'])) == "1"){
			$Month = "1";
		}else if(date('n', strtotime($_REQUEST['txtInputDateCSV'])) == "2"){
			$Month = "2";
		}else if(date('n', strtotime($_REQUEST['txtInputDateCSV'])) == "3"){
			$Month = "3";
		}else if(date('n', strtotime($_REQUEST['txtInputDateCSV'])) == "4"){
			$Month = "4";
		}else if(date('n', strtotime($_REQUEST['txtInputDateCSV'])) == "5"){
			$Month = "5";
		}else if(date('n', strtotime($_REQUEST['txtInputDateCSV'])) == "6"){
			$Month = "6";
		}else if(date('n', strtotime($_REQUEST['txtInputDateCSV'])) == "7"){
			$Month = "7";
		}else if(date('n', strtotime($_REQUEST['txtInputDateCSV'])) == "8"){
			$Month = "8";
		}else if(date('n', strtotime($_REQUEST['txtInputDateCSV'])) == "9"){
			$Month = "9";
		}else if(date('n', strtotime($_REQUEST['txtInputDateCSV'])) == "10"){
			$Month = "A";
		}else if(date('n', strtotime($_REQUEST['txtInputDateCSV'])) == "11"){
			$Month = "B";
		}else if(date('n', strtotime($_REQUEST['txtInputDateCSV'])) == "12"){
			$Month = "C";
		}

		// FOR DAY
		if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "1"){
			$Day = "1";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "2"){
			$Day = "2";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "3"){
			$Day = "3";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "4"){
			$Day = "4";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "5"){
			$Day = "5";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "6"){
			$Day = "6";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "7"){
			$Day = "7";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "8"){
			$Day = "8";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "9"){
			$Day = "9";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "10"){
			$Day = "A";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "11"){
			$Day = "B";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "12"){
			$Day = "C";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "13"){
			$Day = "D";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "14"){
			$Day = "E";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "15"){
			$Day = "F";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "16"){
			$Day = "G";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "17"){
			$Day = "H";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "18"){
			$Day = "I";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "19"){
			$Day = "J";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "20"){
			$Day = "K";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "21"){
			$Day = "L";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "22"){
			$Day = "M";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "23"){
			$Day = "N";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "24"){
			$Day = "O";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "25"){
			$Day = "P";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "26"){
			$Day = "Q";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "27"){
			$Day = "R";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "28"){
			$Day = "S";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "29"){
			$Day = "T";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "30"){
			$Day = "U";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "31"){
			$Day = "V";
		}
	}else{
		// FOR MONTH
		if(date('n', strtotime($_REQUEST['txtInputDateCSV'])) == "1"){
			$Month = "1";
		}else if(date('n', strtotime($_REQUEST['txtInputDateCSV'])) == "2"){
			$Month = "2";
		}else if(date('n', strtotime($_REQUEST['txtInputDateCSV'])) == "3"){
			$Month = "3";
		}else if(date('n', strtotime($_REQUEST['txtInputDateCSV'])) == "4"){
			$Month = "4";
		}else if(date('n', strtotime($_REQUEST['txtInputDateCSV'])) == "5"){
			$Month = "5";
		}else if(date('n', strtotime($_REQUEST['txtInputDateCSV'])) == "6"){
			$Month = "6";
		}else if(date('n', strtotime($_REQUEST['txtInputDateCSV'])) == "7"){
			$Month = "7";
		}else if(date('n', strtotime($_REQUEST['txtInputDateCSV'])) == "8"){
			$Month = "8";
		}else if(date('n', strtotime($_REQUEST['txtInputDateCSV'])) == "9"){
			$Month = "9";
		}else if(date('n', strtotime($_REQUEST['txtInputDateCSV'])) == "10"){
			$Month = "10";
		}else if(date('n', strtotime($_REQUEST['txtInputDateCSV'])) == "11"){
			$Month = "11";
		}else if(date('n', strtotime($_REQUEST['txtInputDateCSV'])) == "12"){
			$Month = "12";
		}

		// FOR DAY
		if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "1"){
			$Day = "1";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "2"){
			$Day = "2";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "3"){
			$Day = "3";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "4"){
			$Day = "4";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "5"){
			$Day = "5";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "6"){
			$Day = "6";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "7"){
			$Day = "7";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "8"){
			$Day = "8";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "9"){
			$Day = "9";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "10"){
			$Day = "10";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "11"){
			$Day = "11";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "12"){
			$Day = "12";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "13"){
			$Day = "13";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "14"){
			$Day = "14";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "15"){
			$Day = "15";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "16"){
			$Day = "16";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "17"){
			$Day = "17";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "18"){
			$Day = "18";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "19"){
			$Day = "19";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "20"){
			$Day = "20";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "21"){
			$Day = "21";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "22"){
			$Day = "22";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "23"){
			$Day = "23";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "24"){
			$Day = "24";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "25"){
			$Day = "25";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "26"){
			$Day = "26";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "27"){
			$Day = "27";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "28"){
			$Day = "28";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "29"){
			$Day = "29";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "30"){
			$Day = "30";
		}else if(date('j', strtotime($_REQUEST['txtInputDateCSV'])) == "31"){
			$Day = "31";
		}
	}
	
	$DiscountCSV = $_FILES["txtInputDiscountCSV"]["name"];
	$TMP_DiscountCSV = $_FILES["txtInputDiscountCSV"]["tmp_name"];

	$HourlyCSV = $_FILES["txtInputHourlyCSV"]["name"];
	$TMP_HourlyCSV = $_FILES["txtInputHourlyCSV"]["tmp_name"];

	$PaymentCSV = $_FILES["txtInputPaymentCSV"]["name"];
	$TMP_PaymentCSV = $_FILES["txtInputPaymentCSV"]["tmp_name"];

	$VoidCSV = $_FILES["txtInputRoCCSV"]["name"];
	$TMP_VoidCSV = $_FILES["txtInputRoCCSV"]["tmp_name"];

	$SalesCSV = $_FILES["txtInputSalesCSV"]["name"];
	$TMP_SalesCSV = $_FILES["txtInputSalesCSV"]["tmp_name"];

	$TargetDiscountCSV1 = $rowTenant['merchant_code'] . $Month . $Day . date('y', strtotime($_REQUEST['txtInputDateCSV'])) . "D.csv";
	$TargetDiscountCSV2 = $rowTenant['merchant_code'] . $Month . $Day . date('y', strtotime($_REQUEST['txtInputDateCSV'])) . "D.CSV";

	$TargetHourlyCSV1 = $rowTenant['merchant_code'] . $Month . $Day . date('y', strtotime($_REQUEST['txtInputDateCSV'])) . "H.csv";
	$TargetHourlyCSV2 = $rowTenant['merchant_code'] . $Month . $Day . date('y', strtotime($_REQUEST['txtInputDateCSV'])) . "H.CSV";

	$TargetPaymentCSV1 = $rowTenant['merchant_code'] . $Month . $Day . date('y', strtotime($_REQUEST['txtInputDateCSV'])) . "P.csv";
	$TargetPaymentCSV2 = $rowTenant['merchant_code'] . $Month . $Day . date('y', strtotime($_REQUEST['txtInputDateCSV'])) . "P.CSV";

	$TargetVoidCSV1 = $rowTenant['merchant_code'] . $Month . $Day . date('y', strtotime($_REQUEST['txtInputDateCSV'])) . "R.csv";
	$TargetVoidCSV2 = $rowTenant['merchant_code'] . $Month . $Day . date('y', strtotime($_REQUEST['txtInputDateCSV'])) . "R.CSV";

	$TargetSalesCSV1 = $rowTenant['merchant_code'] . $Month . $Day . date('y', strtotime($_REQUEST['txtInputDateCSV'])) . "S.csv";
	$TargetSalesCSV2 = $rowTenant['merchant_code'] . $Month . $Day . date('y', strtotime($_REQUEST['txtInputDateCSV'])) . "S.CSV";

	if($DiscountCSV == "" && $HourlyCSV == "" && $PaymentCSV == "" && $VoidCSV == "" && $SalesCSV == ""){
		echo "1|NEED ATLEAST 1 FILE TO EXECUTE UPLOAD";
	}else{

		if($SyncFileStat['countSync'] <= 4){

			$DiscountVal = 0;
			if($SyncFileStat['discount'] == "0" || $SyncFileStat['discount'] == ""){
				if($TargetDiscountCSV1 == $DiscountCSV || $TargetDiscountCSV2 == $DiscountCSV){
					$DiscRowCount = 0;
					$OpenDiscountCSV = fopen($TMP_DiscountCSV, "r");	
					$resDiscountCSV = fgetcsv($OpenDiscountCSV, 1000, ";"); //Remove if CSV file does not have column headings
					while(($resDiscountCSV = fgetcsv($OpenDiscountCSV)) != FALSE){
						if($resDiscountCSV[0] != "" || $resDiscountCSV[1] != "" || $resDiscountCSV[2] != "" || $resDiscountCSV[3] != "" || $resDiscountCSV[4] != "" || $resDiscountCSV[5] != "" || $resDiscountCSV[6] != "" || $resDiscountCSV[7] != ""){

							if(date('Y-m-d', strtotime($resDiscountCSV[0])) != date('Y-m-d', strtotime($_REQUEST['txtInputDateCSV'])) || $resDiscountCSV[1] != $rowTenant['merchant_code']){  
								$DiscRowCount++;
							}

						}
					}
					if($DiscRowCount == 0){
						if($rowTenant['TP_Setup'] == "SFTP"){
							$sftp = new Net_SFTP($filepath['SFTPHost']);
						    if($sftp->login($rowTenant['SFTP_User'], $rowTenant['SFTP_Pass'])){
						    	$sftp->put($DiscountCSV, $TMP_DiscountCSV, NET_SFTP_LOCAL_FILE);
						    	if($sftp->file_exists($DiscountCSV)){
									$sftp->get($DiscountCSV, $DiscountCSV);
									$OpenDiscountCSV = fopen(str_replace("\\", "/", getcwd()) ."/". $DiscountCSV, "r");
									$resDiscountCSV = fgetcsv($OpenDiscountCSV, 1000, ";"); //REMOVE CSV HEADERS
									while(($rowDiscountCSV = fgetcsv($OpenDiscountCSV)) != FALSE){
										$sqlDiscount = genUploadCSVQuery($filepath['dbsetup'], json_encode($rowDiscountCSV), $_REQUEST['TenantID'], $rowTenant['mallID'], "Discount");
										$resDiscount = mysql_query($sqlDiscount, $connection);
									}
									$DiscountVal = 1;
								}else{
									$DiscountVal = 2;
								}
						    }else{
								$DiscountVal = 3;
						    }
						}else{
							move_uploaded_file($TMP_DiscountCSV, $SystemSetupPath . $rowTenant['mallID'] ."/". $rowTenant['merchant_code'] ."/". $DiscountCSV);
							if(file_exists($SystemSetupPath . $rowTenant['mallID'] ."/". $rowTenant['merchant_code'] ."/". $DiscountCSV)){
								$OpenDiscountCSV = fopen($SystemSetupPath . $rowTenant['mallID'] ."/". $rowTenant['merchant_code'] ."/". $DiscountCSV, "r");
								$resDiscountCSV = fgetcsv($OpenDiscountCSV, 1000, ";"); //REMOVE CSV HEADERS
								while(($rowDiscountCSV = fgetcsv($OpenDiscountCSV)) != FALSE){
									$sqlDiscount = genUploadCSVQuery($filepath['dbsetup'], json_encode($rowDiscountCSV), $_REQUEST['TenantID'], $rowTenant['mallID'], "Discount");
									$resDiscount = mysql_query($sqlDiscount, $connection);
								}
								$DiscountVal = 1;
							}else{
								$DiscountVal = 2;
							}
						}
					}else{
						$DiscountVal = 0;
					}
				}else{
					$DiscountVal = 0;
				}
			}else{
				$DiscountVal = $SyncFileStat['discount'];
			}

			$HourlyVal = 0;
			if($SyncFileStat['salesperhour'] == "0" || $SyncFileStat['salesperhour'] == ""){
				if($TargetHourlyCSV1 == $HourlyCSV || $TargetHourlyCSV2 == $HourlyCSV){
					$HourlyRowCount = 0;
					$OpenHourlyCSV = fopen($TMP_HourlyCSV, "r");
					$resHourlyCSV = fgetcsv($OpenHourlyCSV, 1000, ";"); //Remove if CSV file does not have column headings
					while(($resHourlyCSV = fgetcsv($OpenHourlyCSV)) != FALSE){
						if($resHourlyCSV[0] != "" || $resHourlyCSV[1] != "" || $resHourlyCSV[2] != "" || $resHourlyCSV[3] != "" || $resHourlyCSV[4] != "" || $resHourlyCSV[5] != "" || $resHourlyCSV[6] != ""){

							if($resHourlyCSV[1] != $rowTenant['merchant_code']){
								$HourlyRowCount++;
							}

						}
					}
					if($HourlyRowCount == 0){
						if($rowTenant['TP_Setup'] == "SFTP"){
							$sftp = new Net_SFTP($filepath['SFTPHost']);
						    if($sftp->login($rowTenant['SFTP_User'], $rowTenant['SFTP_Pass'])){
						    	$sftp->put($HourlyCSV, $TMP_HourlyCSV, NET_SFTP_LOCAL_FILE);
						    	if($sftp->file_exists($HourlyCSV)){
									$sftp->get($HourlyCSV, $HourlyCSV);
									$OpenHourlyCSV = fopen(str_replace("\\", "/", getcwd()) ."/". $HourlyCSV, "r");
									$resHourlyCSV = fgetcsv($OpenHourlyCSV, 1000, ";"); //REMOVE CSV HEADERS
									while(($rowHourlyCSV = fgetcsv($OpenHourlyCSV)) != FALSE){
										$sqlHourly = genUploadCSVQuery($filepath['dbsetup'], json_encode($rowHourlyCSV), $_REQUEST['TenantID'], $rowTenant['mallID'], "Hourly");
										$resHourly = mysql_query($sqlHourly, $connection);
									}
									$HourlyVal = 1;
								}else{
									$HourlyVal = 2;
								}
						    }else{
								$HourlyVal = 3;
						    }
						}else{
							move_uploaded_file($TMP_HourlyCSV, $SystemSetupPath . $rowTenant['mallID'] ."/". $rowTenant['merchant_code'] ."/". $HourlyCSV);
							if(file_exists($SystemSetupPath . $rowTenant['mallID'] ."/". $rowTenant['merchant_code'] ."/". $HourlyCSV)){
								$OpenHourlyCSV = fopen($SystemSetupPath . $rowTenant['mallID'] ."/". $rowTenant['merchant_code'] ."/". $HourlyCSV, "r");
								$resHourlyCSV = fgetcsv($OpenHourlyCSV, 1000, ";"); //REMOVE CSV HEADERS
								while(($rowHourlyCSV = fgetcsv($OpenHourlyCSV)) != FALSE){
									$sqlHourly = genUploadCSVQuery($filepath['dbsetup'], json_encode($rowHourlyCSV), $_REQUEST['TenantID'], $rowTenant['mallID'], "Hourly");
									$resHourly = mysql_query($sqlHourly, $connection);
								}
								$HourlyVal = 1;
							}else{
								$HourlyVal = 2;
							}
						}
					}else{
						$HourlyVal = 0;
					}
				}else{
					$HourlyVal = 0;
				}
			}else{
				$HourlyVal = $SyncFileStat['salesperhour'];
			}

			$PaymentVal = 0;
			if($SyncFileStat['paymenttype'] == "0" || $SyncFileStat['paymenttype'] == ""){
				if($TargetPaymentCSV1 == $PaymentCSV || $TargetPaymentCSV2 == $PaymentCSV){
					$PaymentRowCount = 0;
					$OpenPaymentCSV = fopen($TMP_PaymentCSV, "r");
					$resPaymentCSV = fgetcsv($OpenPaymentCSV, 1000, ";"); //Remove if CSV file does not have column headings
					while(($rowPaymentCSV = fgetcsv($OpenPaymentCSV)) != FALSE){
						if($rowPaymentCSV[0] != "" || $rowPaymentCSV[1] != "" || $rowPaymentCSV[2] != "" || $rowPaymentCSV[3] != "" || $rowPaymentCSV[4] != "" || $rowPaymentCSV[5] != "" || $rowPaymentCSV[6] != ""){

							if(date('Y-m-d', strtotime($rowPaymentCSV[0])) != date('Y-m-d', strtotime($_REQUEST['txtInputDateCSV'])) || $rowPaymentCSV[1] != $rowTenant['merchant_code']){  
								$PaymentRowCount++;
							}

						}
					}
					if($PaymentRowCount == 0){
						if($rowTenant['TP_Setup'] == "SFTP"){
							$sftp = new Net_SFTP($filepath['SFTPHost']);
						    if($sftp->login($rowTenant['SFTP_User'], $rowTenant['SFTP_Pass'])){
						    	$sftp->put($PaymentCSV, $TMP_PaymentCSV, NET_SFTP_LOCAL_FILE);
						    	if($sftp->file_exists($PaymentCSV)){
									$sftp->get($PaymentCSV, $PaymentCSV);
									$OpenPaymentCSV = fopen(str_replace("\\", "/", getcwd()) ."/". $PaymentCSV, "r");
									$resPaymentCSV = fgetcsv($OpenPaymentCSV, 1000, ";"); //REMOVE CSV HEADERS
									while(($rowPaymentCSV = fgetcsv($OpenPaymentCSV)) != FALSE){
										$sqlPayment = genUploadCSVQuery($filepath['dbsetup'], json_encode($rowPaymentCSV), $_REQUEST['TenantID'], $rowTenant['mallID'], "Payment");
										$resPayment = mysql_query($sqlPayment, $connection);
									}
								}else{
									$PaymentVal = 2;
								}
						    }else{
								$PaymentVal = 3;
						    }
						}else{
							move_uploaded_file($TMP_PaymentCSV, $SystemSetupPath . $rowTenant['mallID'] ."/". $rowTenant['merchant_code'] ."/". $PaymentCSV);
							if(file_exists($SystemSetupPath . $rowTenant['mallID'] ."/". $rowTenant['merchant_code'] ."/". $PaymentCSV)){
								$OpenPaymentCSV = fopen($SystemSetupPath . $rowTenant['mallID'] ."/". $rowTenant['merchant_code'] ."/". $PaymentCSV, "r");
								$resPaymentCSV = fgetcsv($OpenPaymentCSV, 1000, ";"); //REMOVE CSV HEADERS
								while(($rowPaymentCSV = fgetcsv($OpenPaymentCSV)) != FALSE){
									$sqlPayment = genUploadCSVQuery($filepath['dbsetup'], json_encode($rowPaymentCSV), $_REQUEST['TenantID'], $rowTenant['mallID'], "Payment");
									$resPayment = mysql_query($sqlPayment, $connection);
								}
							}else{
								$PaymentVal = 2;
							}
						}
						// SELECT ACCREDITED PAYMENT TYPE
						$AccreditedPType = mysql_fetch_array(mysql_query("SELECT PaymentType FROM tblaccreditation WHERE TenantID = '". $_REQUEST['TenantID'] ."'", $connection));
						$mgaMeron = "";
						$arr = explode("|", $AccreditedPType[0]);
						for ($i=0; $i <= count($arr)-2; $i++){ 
							$mgaMeron .= "'" . $arr[$i] . "'" . ",";
						}

						if($AccreditedPType[0] != ""){
							$FilterPayment = "AND ". $tblPayment[3] ." NOT IN (". substr(trim($mgaMeron), 0, -1) .")";
						}else{
							$FilterPayment = "";
						}

						if($PaymentVal == 0){
							$resNotAccreditedPType = mysql_query("SELECT mallID, tenantID, ". $tblPayment[1] .", ". $tblPayment[2] .", ". $tblPayment[3] .", ". $tblPayment[4] .", ". $tblPayment[5] .", ". $tblPayment[6] .", ". $tblPayment[7] .", id  FROM ". $tblPayment[0] ." WHERE tenantID = '". $_REQUEST['TenantID'] ."' ". $FilterPayment .";", $connection);
							$numNotAccreditedRows = mysql_num_rows($resNotAccreditedPType);
							if($numNotAccreditedRows == 0){
								$PaymentVal = 1;
							}else{
								$PaymentVal = 0;
								while($rowNotAccreditedPType = mysql_fetch_array($resNotAccreditedPType)){

									// INSERT INTO A SEPARATE TABLE FOR FUTURE TRACKING
									$resTransferNotAccredited = mysql_query("INSERT INTO ". $tblPayment[8] ." SET mallID = '". $rowNotAccreditedPType[0] ."', tenantID = '". $rowNotAccreditedPType[1] ."', ". $tblPayment[1] ." = '". $rowNotAccreditedPType[2] ."', fvcMrchntCd = '". $rowNotAccreditedPType[3] ."', ". $tblPayment[3] ." = '". $rowNotAccreditedPType[4] ."', fvcPymntDsc = '". $rowNotAccreditedPType[5] ."', fvcPymntCdCLSCd = '". $rowNotAccreditedPType[6] ."', fvcPymntCdCLSDsc = '". $rowNotAccreditedPType[7] ."', fnmPymnt = '". $rowNotAccreditedPType[8] ."';", $connection);

									if($resTransferNotAccredited == true){ // DELETE NOT ACCREDITED PAYMENT TYPE
										$resDeleteNotAccredited = mysql_query("DELETE FROM ". $tblPayment[0] ." WHERE ". $tblPayment[3] ." = '". $rowNotAccreditedPType[4] ."' AND tenantID = '". $rowNotAccreditedPType[1] ."' AND ". $tblPayment[1] ." = '". date('Y-m-d', strtotime($_REQUEST['txtInputDateCSV'])) ."' AND id = '". $rowNotAccreditedPType['id'] ."';", $connection);
									}

								}
							}
						}
					}else{
						$PaymentVal = 0;
					}
				}else{
					$PaymentVal = 0;
				}
			}else{
				$PaymentVal = $SyncFileStat['paymenttype'];
			}

			$VoidVal = 0;
			if($SyncFileStat['void_refund'] == "0" || $SyncFileStat['void_refund'] == ""){
				if($TargetVoidCSV1 == $VoidCSV || $TargetVoidCSV2 == $VoidCSV){
					$VoidRowCount = 0;
					$OpenVoidCSV = fopen($TMP_VoidCSV, "r");
					$resVoidCSV = fgetcsv($OpenVoidCSV, 1000, ";"); //Remove if CSV file does not have column headings
					while(($resVoidCSV = fgetcsv($OpenVoidCSV)) != FALSE){
						if($resVoidCSV[0] != "" || $resVoidCSV[1] != "" || $resVoidCSV[2] != "" || $resVoidCSV[3] != "" || $resVoidCSV[4] != "" || $resVoidCSV[5] != "" || $resVoidCSV[6] != "" || $resVoidCSV[7] != ""){


							if(date('Y-m-d', strtotime($resVoidCSV[0])) != date('Y-m-d', strtotime($_REQUEST['txtInputDateCSV'])) || $resVoidCSV[1] != $rowTenant['merchant_code']){
								$VoidRowCount++;
							}

						}
					}
					if($VoidRowCount == 0){
						if($rowTenant['TP_Setup'] == "SFTP"){
							$sftp = new Net_SFTP($filepath['SFTPHost']);
						    if($sftp->login($rowTenant['SFTP_User'], $rowTenant['SFTP_Pass'])){
						    	$sftp->put($VoidCSV, $TMP_VoidCSV, NET_SFTP_LOCAL_FILE);
						    	if($sftp->file_exists($VoidCSV)){
									$sftp->get($VoidCSV, $VoidCSV);
									$OpenVoidCSV = fopen(str_replace("\\", "/", getcwd()) ."/". $VoidCSV, "r");
									$resVoidCSV = fgetcsv($OpenVoidCSV, 1000, ";"); //REMOVE CSV HEADERS
									while(($rowVoidCSV = fgetcsv($OpenVoidCSV)) != FALSE){
										$sqlVoid = genUploadCSVQuery($filepath['dbsetup'], json_encode($rowVoidCSV), $_REQUEST['TenantID'], $rowTenant['mallID'], "Void");
										$resVoid = mysql_query($sqlVoid, $connection);
									}
									$VoidVal = 1;
								}else{
									$VoidVal = 2;
								}
						    }else{
								$VoidVal = 3;
						    }
						}else{
							move_uploaded_file($TMP_VoidCSV, $SystemSetupPath . $rowTenant['mallID'] ."/". $rowTenant['merchant_code'] ."/". $VoidCSV);
							if(file_exists($SystemSetupPath . $rowTenant['mallID'] ."/". $rowTenant['merchant_code'] ."/". $VoidCSV)){
								$OpenVoidCSV = fopen($SystemSetupPath . $rowTenant['mallID'] ."/". $rowTenant['merchant_code'] ."/". $VoidCSV, "r");
								$resVoidCSV = fgetcsv($OpenVoidCSV, 1000, ";"); //REMOVE CSV HEADERS
								while(($rowVoidCSV = fgetcsv($OpenVoidCSV)) != FALSE){
									$sqlVoid = genUploadCSVQuery($filepath['dbsetup'], json_encode($rowVoidCSV), $_REQUEST['TenantID'], $rowTenant['mallID'], "Void");
									$resVoid = mysql_query($sqlVoid, $connection);
								}
								$VoidVal = 1;
							}else{
								$VoidVal = 2;
							}
						}
					}else{
						$VoidVal = 0;
					}
				}
			}else{
				$VoidVal = $SyncFileStat['void_refund'];
			}

			$SalesVal = 0;
			if($SyncFileStat['sales'] == "0" || $SyncFileStat['sales'] == ""){
				if($TargetSalesCSV1 == $SalesCSV || $TargetSalesCSV2 == $SalesCSV){
					$SalesCSVRowCount = 0;
					$SalesRowCount = 0;
					$OpenSalesCSV = fopen($TMP_SalesCSV, "r");
					$resSalesCSV = fgetcsv($OpenSalesCSV, 1000, ";"); //Remove if CSV file does not have column headings
					while(($resSalesCSV = fgetcsv($OpenSalesCSV)) !== FALSE){
						if($resSalesCSV[0] != "" || $resSalesCSV[1] != "" || $resSalesCSV[2] != "" || $resSalesCSV[3] != "" || $resSalesCSV[4] != "" || $resSalesCSV[5] != "" || $resSalesCSV[6] != "" || $resSalesCSV[7] != "" || $resSalesCSV[8] != "" || $resSalesCSV[9] != "" || $resSalesCSV[10] != "" || $resSalesCSV[11] != "" || $resSalesCSV[12] != "" || $resSalesCSV[13] != "" || $resSalesCSV[14] != "" || $resSalesCSV[15] != "" || $resSalesCSV[16] != "" || $resSalesCSV[17] != "" || $resSalesCSV[18] != "" || $resSalesCSV[19] != "" || $resSalesCSV[20] != "" || $resSalesCSV[21] != "" || $resSalesCSV[22] != "" || $resSalesCSV[23] != "" || $resSalesCSV[24] != "" || $resSalesCSV[25] != "" || $resSalesCSV[26] != "" || $resSalesCSV[27] != "" || $resSalesCSV[28] != "" || $resSalesCSV[29] != "" || $resSalesCSV[30] != "" || $resSalesCSV[31] != "" || $resSalesCSV[32] != ""){


							if(date('Y-m-d', strtotime($resSalesCSV[0])) == date('Y-m-d', strtotime($_REQUEST['txtInputDateCSV'])) && $rowTenant['merchant_code'] == $resSalesCSV[1]){
								$SalesCSVRowCount++; //GET CORRECT ROW COUNT
							}

							if(date('Y-m-d', strtotime($resSalesCSV[0])) != date('Y-m-d', strtotime($_REQUEST['txtInputDateCSV'])) || $resSalesCSV[1] != $rowTenant['merchant_code']){
								$SalesRowCount++; //GET THE WRONG INPUT
							}

						}
					}
					if($SalesRowCount == 0 && $SalesCSVRowCount == $rowTenant['withPOS']){
						if($rowTenant['TP_Setup'] == "SFTP"){
							$sftp = new Net_SFTP($filepath['SFTPHost']);
						    if($sftp->login($rowTenant['SFTP_User'], $rowTenant['SFTP_Pass'])){
						    	$sftp->put($SalesCSV, $TMP_SalesCSV, NET_SFTP_LOCAL_FILE);
						    	if($sftp->file_exists($SalesCSV)){
									$sftp->get($SalesCSV, $SalesCSV);
									$OpenSalesCSV = fopen(str_replace("\\", "/", getcwd()) ."/". $SalesCSV, "r");
									$resSalesCSV = fgetcsv($OpenSalesCSV, 1000, ";"); //REMOVE CSV HEADERS
									while(($rowSalesCSV = fgetcsv($OpenSalesCSV)) != FALSE){
										$sqlSales = genUploadCSVQuery($filepath['dbsetup'], json_encode($rowSalesCSV), $_REQUEST['TenantID'], $rowTenant['mallID'], "Sales");
										$resSales = mysql_query($sqlSales, $connection);
									}
									$SalesVal = genSumSales($filepath['dbsetup'], $_REQUEST['TenantID'], date('Y-m-d', strtotime($_REQUEST['txtInputDateCSV'])));
								}else{
									$SalesVal = 2;
								}
						    }else{
								$SalesVal = 3;
						    }
						}else{
							move_uploaded_file($TMP_SalesCSV, $SystemSetupPath . $rowTenant['mallID'] ."/". $rowTenant['merchant_code'] . "/". $SalesCSV);
							if(file_exists($SystemSetupPath . $rowTenant['mallID'] ."/". $rowTenant['merchant_code'] ."/". $SalesCSV)){
								$OpenSalesCSV = fopen($SystemSetupPath . $rowTenant['mallID'] ."/". $rowTenant['merchant_code'] ."/". $SalesCSV, "r");
								$resSalesCSV = fgetcsv($OpenSalesCSV, 1000, ";"); //REMOVE CSV HEADERS
								while(($rowSalesCSV = fgetcsv($OpenSalesCSV)) != FALSE){
									$sqlSales = genUploadCSVQuery($filepath['dbsetup'], json_encode($rowSalesCSV), $_REQUEST['TenantID'], $rowTenant['mallID'], "Sales");
									$resSales = mysql_query($sqlSales, $connection);
								}
								$SalesVal = genSumSales($filepath['dbsetup'], $_REQUEST['TenantID'], date('Y-m-d', strtotime($_REQUEST['txtInputDateCSV'])));
							}else{
								$SalesVal = 2;
							}
						}
					}else{
						$SalesVal = 0;
					}
				}else{
					$SalesVal = 0;
				}
			}else{
				$SalesVal = $SyncFileStat['sales'];
			}

			$CSVStats = $DiscountVal + $HourlyVal + $PaymentVal + $VoidVal + $SalesVal;

			$rowID = mysql_fetch_array(mysql_query("SELECT refno FROM db_syncfilestat ORDER BY id DESC LIMIT 1;", $connection));
			if($rowID[0] == ""){
				$refno = str_pad(1, 10, 0, STR_PAD_LEFT);
			}else{
				$refno = str_pad($rowID[0] + 1, 10, 0, STR_PAD_LEFT);
			}

			if($SyncFileStat['reportDate'] == ""){
				$sqlSyncStat = "INSERT INTO db_syncfilestat SET tenantID = '". $_REQUEST['TenantID'] ."', sales = '". $SalesVal ."', discount = '". $DiscountVal ."', void_refund = '". $VoidVal ."', salesperhour = '". $HourlyVal ."', paymenttype = '". $PaymentVal ."', reportDate = '".date('Y-m-d', strtotime($_REQUEST['txtInputDateCSV'])) ."', countSync = '". $CSVStats ."', refno = '". $refno ."', sales_stat = '". $SalesVal ."', discount_stat = '". $DiscountVal ."', void_stat = '". $VoidVal ."', salesperhour_stat = '". $HourlyVal ."', paymenttype_stat = '". $PaymentVal ."';";
			}else{
				$sqlSyncStat = "UPDATE db_syncfilestat SET sales = '". $SalesVal ."', discount = '". $DiscountVal ."', void_refund = '". $VoidVal ."', salesperhour = '". $HourlyVal ."', paymenttype = '". $PaymentVal ."', countSync = '". $CSVStats ."', sales_stat = '". $SalesVal ."', discount_stat = '". $DiscountVal ."', void_stat = '". $VoidVal ."', salesperhour_stat = '". $HourlyVal ."', paymenttype_stat = '". $PaymentVal ."' WHERE tenantID = '". $_REQUEST['TenantID'] ."' AND reportDate = '".date('Y-m-d', strtotime($_REQUEST['txtInputDateCSV'])) ."';";
			}
			
			$resSyncStat = mysql_query($sqlSyncStat, $connection);
			if($resSyncStat == 1){
				if($CSVStats == 5){
					$FloorPlanStat = 1;
				}else{
					$FloorPlanStat = 0;
				}
			}

			if($CSVStats == 5){
				echo "1|5 out of 5 CSV files has been uploaded successfully."."|".date('Y-m-d', strtotime($_REQUEST['txtInputDateCSV']));
				array_map('unlink', glob(str_replace("\\", "/", getcwd())."/*.csv"));
			}else if($CSVStats <= 4){
				echo "1|". $CSVStats ." out of 5 CSV files has been uploaded successfully."."|".date('Y-m-d', strtotime($_REQUEST['txtInputDateCSV']));
				array_map('unlink', glob(str_replace("\\", "/", getcwd())."/*.csv"));
			}

			$resUnitStatLogs = mysql_query("UPDATE tblunit_statuslogs SET txtStat = '". $FloorPlanStat ."' WHERE tenantID = '". $_REQUEST['TenantID'] ."' AND unitID = '". $rowTenant['unitID'] ."' AND xdate = '". date('Y-m-d', strtotime($_REQUEST['txtInputDateCSV'])) ."'", $connection);

		}else{
			echo "2|All CSV file for this date is already uploaded.";
		}
	}
	mysql_close($connection);
?>