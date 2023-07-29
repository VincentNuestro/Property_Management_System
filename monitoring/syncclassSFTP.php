<?php
	session_start();
	include "../connect.php";
	set_include_path(get_include_path() . PATH_SEPARATOR . 'phpseclib');
	include('phpseclib/Net/SFTP.php');
	switch ($_POST['form']) {
		case 'importcsvtoday':
			$filepath = mysql_fetch_array(mysql_query("SELECT dbsetup, SFTPHost, SFTPPort FROM tblsys_setup;", $connection));
			$tblPayment = tblPayment($filepath['dbsetup']);

			if($filepath['dbsetup'] == "1"){
				// FOR MONTH
				if(date('n', strtotime(getsysdate())) == "1"){
					$Month = "1";
				}else if(date('n', strtotime(getsysdate())) == "2"){
					$Month = "2";
				}else if(date('n', strtotime(getsysdate())) == "3"){
					$Month = "3";
				}else if(date('n', strtotime(getsysdate())) == "4"){
					$Month = "4";
				}else if(date('n', strtotime(getsysdate())) == "5"){
					$Month = "5";
				}else if(date('n', strtotime(getsysdate())) == "6"){
					$Month = "6";
				}else if(date('n', strtotime(getsysdate())) == "7"){
					$Month = "7";
				}else if(date('n', strtotime(getsysdate())) == "8"){
					$Month = "8";
				}else if(date('n', strtotime(getsysdate())) == "9"){
					$Month = "9";
				}else if(date('n', strtotime(getsysdate())) == "10"){
					$Month = "A";
				}else if(date('n', strtotime(getsysdate())) == "11"){
					$Month = "B";
				}else if(date('n', strtotime(getsysdate())) == "12"){
					$Month = "C";
				}

				// FOR DAY
				if(date('j', strtotime(getsysdate())) == "1"){
					$Day = "1";
				}else if(date('j', strtotime(getsysdate())) == "2"){
					$Day = "2";
				}else if(date('j', strtotime(getsysdate())) == "3"){
					$Day = "3";
				}else if(date('j', strtotime(getsysdate())) == "4"){
					$Day = "4";
				}else if(date('j', strtotime(getsysdate())) == "5"){
					$Day = "5";
				}else if(date('j', strtotime(getsysdate())) == "6"){
					$Day = "6";
				}else if(date('j', strtotime(getsysdate())) == "7"){
					$Day = "7";
				}else if(date('j', strtotime(getsysdate())) == "8"){
					$Day = "8";
				}else if(date('j', strtotime(getsysdate())) == "9"){
					$Day = "9";
				}else if(date('j', strtotime(getsysdate())) == "10"){
					$Day = "A";
				}else if(date('j', strtotime(getsysdate())) == "11"){
					$Day = "B";
				}else if(date('j', strtotime(getsysdate())) == "12"){
					$Day = "C";
				}else if(date('j', strtotime(getsysdate())) == "13"){
					$Day = "D";
				}else if(date('j', strtotime(getsysdate())) == "14"){
					$Day = "E";
				}else if(date('j', strtotime(getsysdate())) == "15"){
					$Day = "F";
				}else if(date('j', strtotime(getsysdate())) == "16"){
					$Day = "G";
				}else if(date('j', strtotime(getsysdate())) == "17"){
					$Day = "H";
				}else if(date('j', strtotime(getsysdate())) == "18"){
					$Day = "I";
				}else if(date('j', strtotime(getsysdate())) == "19"){
					$Day = "J";
				}else if(date('j', strtotime(getsysdate())) == "20"){
					$Day = "K";
				}else if(date('j', strtotime(getsysdate())) == "21"){
					$Day = "L";
				}else if(date('j', strtotime(getsysdate())) == "22"){
					$Day = "M";
				}else if(date('j', strtotime(getsysdate())) == "23"){
					$Day = "N";
				}else if(date('j', strtotime(getsysdate())) == "24"){
					$Day = "O";
				}else if(date('j', strtotime(getsysdate())) == "25"){
					$Day = "P";
				}else if(date('j', strtotime(getsysdate())) == "26"){
					$Day = "Q";
				}else if(date('j', strtotime(getsysdate())) == "27"){
					$Day = "R";
				}else if(date('j', strtotime(getsysdate())) == "28"){
					$Day = "S";
				}else if(date('j', strtotime(getsysdate())) == "29"){
					$Day = "T";
				}else if(date('j', strtotime(getsysdate())) == "30"){
					$Day = "U";
				}else if(date('j', strtotime(getsysdate())) == "31"){
					$Day = "V";
				}
			}else{
				// FOR MONTH
				if(date('n', strtotime(getsysdate())) == "1"){
					$Month = "1";
				}else if(date('n', strtotime(getsysdate())) == "2"){
					$Month = "2";
				}else if(date('n', strtotime(getsysdate())) == "3"){
					$Month = "3";
				}else if(date('n', strtotime(getsysdate())) == "4"){
					$Month = "4";
				}else if(date('n', strtotime(getsysdate())) == "5"){
					$Month = "5";
				}else if(date('n', strtotime(getsysdate())) == "6"){
					$Month = "6";
				}else if(date('n', strtotime(getsysdate())) == "7"){
					$Month = "7";
				}else if(date('n', strtotime(getsysdate())) == "8"){
					$Month = "8";
				}else if(date('n', strtotime(getsysdate())) == "9"){
					$Month = "9";
				}else if(date('n', strtotime(getsysdate())) == "10"){
					$Month = "10";
				}else if(date('n', strtotime(getsysdate())) == "11"){
					$Month = "11";
				}else if(date('n', strtotime(getsysdate())) == "12"){
					$Month = "12";
				}

				// FOR DAY
				if(date('j', strtotime(getsysdate())) == "1"){
					$Day = "1";
				}else if(date('j', strtotime(getsysdate())) == "2"){
					$Day = "2";
				}else if(date('j', strtotime(getsysdate())) == "3"){
					$Day = "3";
				}else if(date('j', strtotime(getsysdate())) == "4"){
					$Day = "4";
				}else if(date('j', strtotime(getsysdate())) == "5"){
					$Day = "5";
				}else if(date('j', strtotime(getsysdate())) == "6"){
					$Day = "6";
				}else if(date('j', strtotime(getsysdate())) == "7"){
					$Day = "7";
				}else if(date('j', strtotime(getsysdate())) == "8"){
					$Day = "8";
				}else if(date('j', strtotime(getsysdate())) == "9"){
					$Day = "9";
				}else if(date('j', strtotime(getsysdate())) == "10"){
					$Day = "10";
				}else if(date('j', strtotime(getsysdate())) == "11"){
					$Day = "11";
				}else if(date('j', strtotime(getsysdate())) == "12"){
					$Day = "12";
				}else if(date('j', strtotime(getsysdate())) == "13"){
					$Day = "13";
				}else if(date('j', strtotime(getsysdate())) == "14"){
					$Day = "14";
				}else if(date('j', strtotime(getsysdate())) == "15"){
					$Day = "15";
				}else if(date('j', strtotime(getsysdate())) == "16"){
					$Day = "16";
				}else if(date('j', strtotime(getsysdate())) == "17"){
					$Day = "17";
				}else if(date('j', strtotime(getsysdate())) == "18"){
					$Day = "18";
				}else if(date('j', strtotime(getsysdate())) == "19"){
					$Day = "19";
				}else if(date('j', strtotime(getsysdate())) == "20"){
					$Day = "20";
				}else if(date('j', strtotime(getsysdate())) == "21"){
					$Day = "21";
				}else if(date('j', strtotime(getsysdate())) == "22"){
					$Day = "22";
				}else if(date('j', strtotime(getsysdate())) == "23"){
					$Day = "23";
				}else if(date('j', strtotime(getsysdate())) == "24"){
					$Day = "24";
				}else if(date('j', strtotime(getsysdate())) == "25"){
					$Day = "25";
				}else if(date('j', strtotime(getsysdate())) == "26"){
					$Day = "26";
				}else if(date('j', strtotime(getsysdate())) == "27"){
					$Day = "27";
				}else if(date('j', strtotime(getsysdate())) == "28"){
					$Day = "28";
				}else if(date('j', strtotime(getsysdate())) == "29"){
					$Day = "29";
				}else if(date('j', strtotime(getsysdate())) == "30"){
					$Day = "30";
				}else if(date('j', strtotime(getsysdate())) == "31"){
					$Day = "31";
				}
			}

			$SuccessCount = 0;
			$ExistingCount = 0;
			$resTenant = mysql_query("SELECT mallID, merchant_code, TenantID, withPOS, SFTP_User, SFTP_Pass, unitID FROM tbltrans_tenants WHERE (Status = 'Active' OR Status = 'ForEviction' OR Status = 'ForRenewal') AND ustatus = 'Occupied' AND uploadingoffiles = '1' AND datefrom <= '". date('Y-m-d', strtotime(getsysdate())) ."' AND dateto >= '". date('Y-m-d', strtotime(getsysdate())) ."' ORDER BY tradename ASC;", $connection);
			while($rowTenant = mysql_fetch_array($resTenant)){
				$Log = "";

				$FileName = str_replace("\\", "/", getcwd()) ."/". $rowTenant['merchant_code'] . $Month . $Day . date('y', strtotime(getsysdate()));
				$FileName2 = $rowTenant['merchant_code'] . $Month . $Day . date('y', strtotime(getsysdate()));
				$UploadStat = mysql_num_rows(mysql_query("SELECT id FROM db_syncfilestat WHERE reportDate = '". date('Y-m-d', strtotime(getsysdate())) ."' AND tenantID = '". $rowTenant['TenantID'] ."';", $connection));
				if($UploadStat == 0){

					try{
						mysql_query("START transaction;");
						$sftp = new Net_SFTP($filepath['SFTPHost']);
				    	if($sftp->login(trim($rowTenant['SFTP_User']), trim($rowTenant['SFTP_Pass']))){
							if($sftp->file_exists($FileName2 . "D.csv")){
								$sftp->get($FileName2 . "D.csv", $FileName2 . "D.csv");
								$DiscRowCount = 0;
								$OpenDiscountCSV = fopen($FileName . "D.csv", "r");
								$resDiscountCSV = fgetcsv($OpenDiscountCSV, 1000, ";"); //REMOVE CSV HEADERS
								while(($rowDiscountCSV = fgetcsv($OpenDiscountCSV)) != FALSE){
									if($rowDiscountCSV[0] != "" || $rowDiscountCSV[1] != "" || $rowDiscountCSV[2] != "" || $rowDiscountCSV[3] != "" || $rowDiscountCSV[4] != "" || $rowDiscountCSV[5] != "" || $rowDiscountCSV[6] != "" || $rowDiscountCSV[7] != ""){

										if(date('Y-m-d', strtotime($rowDiscountCSV[0])) != date('Y-m-d', strtotime(getsysdate())) || $rowDiscountCSV[1] != $rowTenant['merchant_code']){
											$DiscRowCount++;
										}

									}
								}
								$DiscountVal = 0;
								if($DiscRowCount == 0){
									$OpenDiscountCSV = fopen($FileName . "D.csv", "r");
									$resDiscountCSV = fgetcsv($OpenDiscountCSV, 1000, ";"); //REMOVE CSV HEADERS
									while(($rowDiscountCSV = fgetcsv($OpenDiscountCSV)) != FALSE){
										$sqlDiscount = genUploadCSVQuery($filepath['dbsetup'], json_encode($rowDiscountCSV), $rowTenant['TenantID'], $rowTenant['mallID'], "Discount");
										$resDiscount = mysql_query($sqlDiscount, $connection);
									}
									$DiscountVal = 1;
								}else{
									$DiscountVal = 0;
								}
							}else{
								$DiscountVal = 2;
							}

							if($sftp->file_exists($FileName2 . "H.csv")){
								$sftp->get($FileName2 . "H.csv", $FileName2 . "H.csv");
								$HourlyRowCount = 0;
								$OpenHourlyCSV = fopen($FileName . "H.csv", "r");
								$rowHourlyCSV = fgetcsv($OpenHourlyCSV, 1000, ";"); //REMOVE CSV HEADERS
								while(($rowHourlyCSV = fgetcsv($OpenHourlyCSV)) != FALSE){
									if($rowHourlyCSV[0] != "" || $rowHourlyCSV[1] != "" || $rowHourlyCSV[2] != "" || $rowHourlyCSV[3] != "" || $rowHourlyCSV[4] != "" || $rowHourlyCSV[5] != "" || $rowHourlyCSV[6] != ""){

										if($rowHourlyCSV[1] != $rowTenant['merchant_code']){
											$HourlyRowCount++;
										}

									}
								}
								$HourlyVal = 0;
								if($HourlyRowCount == 0){
									$OpenHourlyCSV = fopen($FileName . "H.csv", "r");
									$resHourlyCSV = fgetcsv($OpenHourlyCSV, 1000, ";"); //REMOVE CSV HEADERS
									while(($rowHourlyCSV = fgetcsv($OpenHourlyCSV)) != FALSE){
										$sqlHourly = genUploadCSVQuery($filepath['dbsetup'], json_encode($rowHourlyCSV), $rowTenant['TenantID'], $rowTenant['mallID'], "Hourly");
										$resHourly = mysql_query($sqlHourly, $connection);
									}
									$HourlyVal = 1;
								}else{
									$HourlyVal = 0;
								}
							}else{
								$HourlyVal = 2;
							}

							if($sftp->file_exists($FileName2 . "P.csv")){
								$sftp->get($FileName2 . "P.csv", $FileName2 . "P.csv");
								$PaymentRowCount = 0;
								$OpenPaymentCSV = fopen($FileName . "P.csv", "r");
								$resPaymentCSV = fgetcsv($OpenPaymentCSV, 1000, ";"); //REMOVE CSV HEADERS
								while(($rowPaymentCSV = fgetcsv($OpenPaymentCSV)) != FALSE){
									if($rowPaymentCSV[0] != "" || $rowPaymentCSV[1] != "" || $rowPaymentCSV[2] != "" || $rowPaymentCSV[3] != "" || $rowPaymentCSV[4] != "" || $rowPaymentCSV[5] != "" || $rowPaymentCSV[6] != ""){

										if(date('Y-m-d', strtotime($rowPaymentCSV[0])) != date('Y-m-d', strtotime(getsysdate())) || $rowPaymentCSV[1] != $rowTenant['merchant_code']){  
											$PaymentRowCount++;
										}

									}
								}
								$PaymentVal = 0;
								if($PaymentRowCount == 0){
									// SELECT ACCREDITED PAYMENT TYPE
									$AccreditedPType = mysql_fetch_array(mysql_query("SELECT PaymentType FROM tblaccreditation WHERE TenantID = '". $rowTenant['TenantID'] ."'", $connection));
									$mgaMeron = "";
									$arr = explode("|", $AccreditedPType[0]);
									for($i=0; $i <= count($arr)-2; $i++){ 
										$mgaMeron .= "'" . $arr[$i] . "'" . ",";
									}

									$OpenPaymentCSV = fopen($FileName . "P.csv", "r");
									$resPaymentCSV = fgetcsv($OpenPaymentCSV, 1000, ";"); //REMOVE CSV HEADERS
									while(($rowPaymentCSV = fgetcsv($OpenPaymentCSV)) != FALSE){
										$sqlPayment = genUploadCSVQuery($filepath['dbsetup'], json_encode($rowPaymentCSV), $rowTenant['TenantID'], $rowTenant['mallID'], "Payment");
										$resPayment = mysql_query($sqlPayment, $connection);
									}

									if($AccreditedPType[0] != ""){
										$FilterPayment = "AND ". $tblPayment[3] ." NOT IN (". substr(trim($mgaMeron), 0, -1) .")";
									}else{
										$FilterPayment = "";
									}
									
									$resNotAccreditedPType = mysql_query("SELECT mallID, tenantID, ". $tblPayment[1] .", ". $tblPayment[2] .", ". $tblPayment[3] .", ". $tblPayment[4] .", ". $tblPayment[5] .", ". $tblPayment[6] .", ". $tblPayment[7] .", id FROM ". $tblPayment[0] ." WHERE tenantID = '". $rowTenant['TenantID'] ."' ". $FilterPayment .";", $connection);
									$numNotAccreditedRows = mysql_num_rows($resNotAccreditedPType);
									if($numNotAccreditedRows == 0){
										$PaymentVal = 1;
									}else{
										$PaymentVal = 0;
										while($rowNotAccreditedPType = mysql_fetch_array($resNotAccreditedPType)){

											// INSERT INTO A SEPARATE TABLE FOR FUTURE TRACKING
											$resTransferNotAccredited = mysql_query("INSERT INTO ". $tblPayment[8] ." SET mallID = '". $rowNotAccreditedPType[0] ."', tenantID = '". $rowNotAccreditedPType[1] ."', ". $tblPayment[1] ." = '". $rowNotAccreditedPType[2] ."', fvcMrchntCd = '". $rowNotAccreditedPType[3] ."', ". $tblPayment[3] ." = '". $rowNotAccreditedPType[4] ."', fvcPymntDsc = '". $rowNotAccreditedPType[5] ."', fvcPymntCdCLSCd = '". $rowNotAccreditedPType[6] ."', fvcPymntCdCLSDsc = '". $rowNotAccreditedPType[7] ."', fnmPymnt = '". $rowNotAccreditedPType[8] ."';", $connection);

											if($resTransferNotAccredited == true){ // DELETE NOT ACCREDITED PAYMENT TYPE
												$resDeleteNotAccredited = mysql_query("DELETE FROM ". $tblPayment[0] ." WHERE ". $tblPayment[3] ." = '". $rowNotAccreditedPType[4] ."' AND tenantID = '". $rowNotAccreditedPType[1] ."' AND ". $tblPayment[1] ." = '". date('Y-m-d', strtotime($StartDate)) ."' AND id = '". $rowNotAccreditedPType['id'] ."';", $connection);
											}

										}
									}
								}else{
									$PaymentVal = 0;
								}
							}else{
								$PaymentVal = 2;
							}

							if($sftp->file_exists($FileName2 . "R.csv")){
								$sftp->get($FileName2 . "R.csv", $FileName2 . "R.csv");
								$VoidRowCount = 0;
								$OpenVoidCSV = fopen($FileName . "R.csv", "r");
								$resVoidCSV = fgetcsv($OpenVoidCSV, 1000, ";"); //REMOVE CSV HEADERS
								while(($rowVoidCSV = fgetcsv($OpenVoidCSV)) != FALSE){
									if($rowVoidCSV[0] != "" || $rowVoidCSV[1] != "" || $rowVoidCSV[2] != "" || $rowVoidCSV[3] != "" || $rowVoidCSV[4] != "" || $rowVoidCSV[5] != "" || $rowVoidCSV[6] != "" || $rowVoidCSV[7] != ""){

										if(date('Y-m-d', strtotime($rowVoidCSV[0])) != date('Y-m-d', strtotime(getsysdate())) || $rowVoidCSV[1] != $rowTenant['merchant_code']){
											$VoidRowCount++;
										}

									}
								}
								$VoidVal = 0;
								if($VoidRowCount == 0){
									$OpenVoidCSV = fopen($FileName . "R.csv", "r");
									$resVoidCSV = fgetcsv($OpenVoidCSV, 1000, ";"); //REMOVE CSV HEADERS
									while(($rowVoidCSV = fgetcsv($OpenVoidCSV)) != FALSE){
										$sqlVoid = genUploadCSVQuery($filepath['dbsetup'], json_encode($rowVoidCSV), $rowTenant['TenantID'], $rowTenant['mallID'], "Void");
										$resVoid = mysql_query($sqlVoid, $connection);
									}
									$VoidVal = 1;
								}else{
									$VoidVal = 0;
								}
							}else{
								$VoidVal = 2;
							}

							if($sftp->file_exists($FileName2 . "S.csv")){
								$sftp->get($FileName2 . "S.csv", $FileName2 . "S.csv");
								$SalesCSVRowCount = 0;
								$SalesRowCount = 0;
								$OpenSalesCSV = fopen($FileName . "S.csv", "r");
								$resSalesCSV = fgetcsv($OpenSalesCSV, 1000, ";"); //REMOVE CSV HEADERS
								while(($rowSalesCSV = fgetcsv($OpenSalesCSV)) != FALSE){
									if($rowSalesCSV[0] != "" || $rowSalesCSV[1] != "" || $rowSalesCSV[2] != "" || $rowSalesCSV[3] != "" || $rowSalesCSV[4] != "" || $rowSalesCSV[5] != "" || $rowSalesCSV[6] != "" || $rowSalesCSV[7] != "" || $rowSalesCSV[8] != "" || $rowSalesCSV[9] != "" || $rowSalesCSV[10] != "" || $rowSalesCSV[11] != "" || $rowSalesCSV[12] != "" || $rowSalesCSV[13] != "" || $rowSalesCSV[14] != "" || $rowSalesCSV[15] != "" || $rowSalesCSV[16] != "" || $rowSalesCSV[17] != "" || $rowSalesCSV[18] != "" || $rowSalesCSV[19] != "" || $rowSalesCSV[20] != "" || $rowSalesCSV[21] != "" || $rowSalesCSV[22] != "" || $rowSalesCSV[23] != "" || $rowSalesCSV[24] != "" || $rowSalesCSV[25] != "" || $rowSalesCSV[26] != "" || $rowSalesCSV[27] != "" || $rowSalesCSV[28] != "" || $rowSalesCSV[29] != "" || $rowSalesCSV[30] != "" || $rowSalesCSV[31] != "" || $rowSalesCSV[32] != ""){

										if(date('Y-m-d', strtotime($rowSalesCSV[0])) == date('Y-m-d', strtotime(getsysdate())) && $rowSalesCSV[1] == $rowTenant['merchant_code']){
											$SalesCSVRowCount++;
										}

										if(date('Y-m-d', strtotime($rowSalesCSV[0])) != date('Y-m-d', strtotime(getsysdate())) && $rowSalesCSV[1] != $rowTenant['merchant_code']){
											$SalesRowCount++;
										}

									}
								}
								$SalesVal = 0;
								if($SalesRowCount == 0 && $SalesCSVRowCount == $rowTenant['withPOS']){
									$OpenSalesCSV = fopen($FileName . "S.csv", "r");
									$resSalesCSV = fgetcsv($OpenSalesCSV, 1000, ";"); //REMOVE CSV HEADERS
									while(($rowSalesCSV = fgetcsv($OpenSalesCSV)) != FALSE){
										$sqlSales = genUploadCSVQuery($filepath['dbsetup'], json_encode($rowSalesCSV), $rowTenant['TenantID'], $rowTenant['mallID'], "Sales");
										$resSales = mysql_query($sqlSales, $connection);
									}
									$SalesVal = genSumSales($filepath['dbsetup'], $rowTenant['TenantID'], date('Y-m-d', strtotime(getsysdate())));
								}else{
									$SalesVal = 0;
								}
							}else{
								$SalesVal = 2;
							}

							if($DiscountVal == 1){ $DiscountVal2 = 1; }else{ $DiscountVal2 = 0; }
							if($HourlyVal == 1){ $HourlyVal2 = 1; }else{ $HourlyVal2 = 0; }
							if($PaymentVal == 1){ $PaymentVal2 = 1; }else{ $PaymentVal2 = 0; }
							if($VoidVal == 1){ $VoidVal2 = 1; }else{ $VoidVal2 = 0; }
							if($SalesVal == 1){ $SalesVal2 = 1; }else{ $SalesVal2 = 0; }
							$CSVStats = $DiscountVal2 + $HourlyVal2 + $PaymentVal2 + $VoidVal2 + $SalesVal2;
						}else{
							$DiscountVal = 3;
							$HourlyVal = 3;
							$PaymentVal = 3;
							$VoidVal = 3;
							$SalesVal = 3;
							$CSVStats = 0;
						}

						$rowID = mysql_fetch_array(mysql_query(" SELECT refno FROM db_syncfilestat ORDER BY id DESC LIMIT 1 ", $connection));
						if($rowID[0] == ""){
							$refno = str_pad(1, 10, 0, STR_PAD_LEFT);
						}else{
							$refno = str_pad($rowID[0] + 1, 10, 0, STR_PAD_LEFT);
						}

						$resSyncStat = mysql_query("INSERT INTO db_syncfilestat SET tenantID = '". $rowTenant['TenantID'] ."', sales = '". $SalesVal ."', discount = '". $DiscountVal ."', void_refund = '". $VoidVal ."', salesperhour = '". $HourlyVal ."', paymenttype = '". $PaymentVal ."', reportDate = '". date('Y-m-d', strtotime(getsysdate())) ."', countSync = '". $CSVStats ."', refno = '". $refno ."';", $connection);
						if($resSyncStat == 1){
							if($CSVStats == 5){
								$FloorPlanStat = 1;
							}else{
								$FloorPlanStat = 0;
							}

							$resUnitStatLogs = mysql_query("UPDATE tblunit_statuslogs SET txtStat = '". $FloorPlanStat ."' WHERE tenantID = '". $rowTenant['TenantID'] ."' AND unitID = '". $rowUnit[0] ."' AND xdate = '". date('Y-m-d', strtotime(getsysdate())) ."';", $connection);
							if($resUnitStatLogs == true){

								$Log .= "CSV Date : ". date('m/d/Y', strtotime(getsysdate())) ."|";
								if($DiscountVal == 1){
									$Log .= "Discount : Success|";
								}else if($DiscountVal == 2){
									$Log .= "Discount : File Not Found|";
								}else if($DiscountVal == 3){
									$Log .= "Discount : SFTP Access Denied|";
								}else{
									$Log .= "Discount : Failed|";
								}

								if($HourlyVal == 1){
									$Log .= "Hourly : Success|";
								}else if($HourlyVal == 2){
									$Log .= "Hourly : File Not Found|";
								}else if($HourlyVal == 3){
									$Log .= "Hourly : SFTP Access Denied|";
								}else{
									$Log .= "Hourly : Failed|";
								}

								if($PaymentVal == 1){
									$Log .= "Payment Type : Success|";
								}else if($PaymentVal == 2){
									$Log .= "Payment Type : File Not Found|";
								}else if($PaymentVal == 3){
									$Log .= "Payment Type : SFTP Access Denied|";
								}else{
									$Log .= "Payment Type : Failed|";
								}

								if($VoidVal == 1){
									$Log .= "Void : Success|";
								}else if($VoidVal == 2){
									$Log .= "Void : File Not Found|";
								}else if($VoidVal == 3){
									$Log .= "Void : SFTP Access Denied|";
								}else{
									$Log .= "Void : Failed|";
								}

								if($SalesVal == 1){
									$Log .= "Sales : Success|";
								}else if($SalesVal == 2){
									$Log .= "Sales : File Not Found|";
								}else if($SalesVal == 3){
									$Log .= "Sales : SFTP Access Denied|";
								}else{
									$Log .= "Sales : Failed|";
								}

								if($Log != ""){
									$tran_logs = create_logs_per_transaction("uploaded a CSV File", "File Monitoring Module", $Log, "", "ADD", $rowTenant['TenantID']);
								}

							}
							$SuccessCount++;
						}
						mysql_query("COMMIT;", $connection);
					}catch(Exception $e){
						echo $e;
						mysql_query("ROLLBACK;", $connection);
					}
				}else{
					$ExistingCount++;
				}
			}

			if($SuccessCount >= 1 && $ExistingCount == 0){
				echo "1|";
			}else if($SuccessCount == 0 && $ExistingCount >= 1){
				echo "2|";
			}else if($SuccessCount >= 1 && $ExistingCount >= 1){
				echo "1|";
			}else{
				echo "3|";
			}
		break;

		case 'importcsvdaterange':
			$filepath = mysql_fetch_array(mysql_query("SELECT dbsetup, SFTPHost, SFTPPort FROM tblsys_setup;", $connection));
			$tblPayment = tblPayment($filepath['dbsetup']);

			$SuccessCount = 0;
			$ExistingCount = 0;
			$StartDate = date('Y-m-d', strtotime($_POST['dateFrom']));
			while(date('Y-m-d', strtotime($StartDate)) <= date('Y-m-d', strtotime($_POST['dateTo']))){

				if($filepath['dbsetup'] == "1"){
					// FOR MONTH
					if(date('n', strtotime($StartDate)) == "1"){
						$Month = "1";
					}else if(date('n', strtotime($StartDate)) == "2"){
						$Month = "2";
					}else if(date('n', strtotime($StartDate)) == "3"){
						$Month = "3";
					}else if(date('n', strtotime($StartDate)) == "4"){
						$Month = "4";
					}else if(date('n', strtotime($StartDate)) == "5"){
						$Month = "5";
					}else if(date('n', strtotime($StartDate)) == "6"){
						$Month = "6";
					}else if(date('n', strtotime($StartDate)) == "7"){
						$Month = "7";
					}else if(date('n', strtotime($StartDate)) == "8"){
						$Month = "8";
					}else if(date('n', strtotime($StartDate)) == "9"){
						$Month = "9";
					}else if(date('n', strtotime($StartDate)) == "10"){
						$Month = "A";
					}else if(date('n', strtotime($StartDate)) == "11"){
						$Month = "B";
					}else if(date('n', strtotime($StartDate)) == "12"){
						$Month = "C";
					}

					// FOR DAY
					if(date('j', strtotime($StartDate)) == "1"){
						$Day = "1";
					}else if(date('j', strtotime($StartDate)) == "2"){
						$Day = "2";
					}else if(date('j', strtotime($StartDate)) == "3"){
						$Day = "3";
					}else if(date('j', strtotime($StartDate)) == "4"){
						$Day = "4";
					}else if(date('j', strtotime($StartDate)) == "5"){
						$Day = "5";
					}else if(date('j', strtotime($StartDate)) == "6"){
						$Day = "6";
					}else if(date('j', strtotime($StartDate)) == "7"){
						$Day = "7";
					}else if(date('j', strtotime($StartDate)) == "8"){
						$Day = "8";
					}else if(date('j', strtotime($StartDate)) == "9"){
						$Day = "9";
					}else if(date('j', strtotime($StartDate)) == "10"){
						$Day = "A";
					}else if(date('j', strtotime($StartDate)) == "11"){
						$Day = "B";
					}else if(date('j', strtotime($StartDate)) == "12"){
						$Day = "C";
					}else if(date('j', strtotime($StartDate)) == "13"){
						$Day = "D";
					}else if(date('j', strtotime($StartDate)) == "14"){
						$Day = "E";
					}else if(date('j', strtotime($StartDate)) == "15"){
						$Day = "F";
					}else if(date('j', strtotime($StartDate)) == "16"){
						$Day = "G";
					}else if(date('j', strtotime($StartDate)) == "17"){
						$Day = "H";
					}else if(date('j', strtotime($StartDate)) == "18"){
						$Day = "I";
					}else if(date('j', strtotime($StartDate)) == "19"){
						$Day = "J";
					}else if(date('j', strtotime($StartDate)) == "20"){
						$Day = "K";
					}else if(date('j', strtotime($StartDate)) == "21"){
						$Day = "L";
					}else if(date('j', strtotime($StartDate)) == "22"){
						$Day = "M";
					}else if(date('j', strtotime($StartDate)) == "23"){
						$Day = "N";
					}else if(date('j', strtotime($StartDate)) == "24"){
						$Day = "O";
					}else if(date('j', strtotime($StartDate)) == "25"){
						$Day = "P";
					}else if(date('j', strtotime($StartDate)) == "26"){
						$Day = "Q";
					}else if(date('j', strtotime($StartDate)) == "27"){
						$Day = "R";
					}else if(date('j', strtotime($StartDate)) == "28"){
						$Day = "S";
					}else if(date('j', strtotime($StartDate)) == "29"){
						$Day = "T";
					}else if(date('j', strtotime($StartDate)) == "30"){
						$Day = "U";
					}else if(date('j', strtotime($StartDate)) == "31"){
						$Day = "V";
					}
				}else{
					// FOR MONTH
					if(date('n', strtotime($StartDate)) == "1"){
						$Month = "1";
					}else if(date('n', strtotime($StartDate)) == "2"){
						$Month = "2";
					}else if(date('n', strtotime($StartDate)) == "3"){
						$Month = "3";
					}else if(date('n', strtotime($StartDate)) == "4"){
						$Month = "4";
					}else if(date('n', strtotime($StartDate)) == "5"){
						$Month = "5";
					}else if(date('n', strtotime($StartDate)) == "6"){
						$Month = "6";
					}else if(date('n', strtotime($StartDate)) == "7"){
						$Month = "7";
					}else if(date('n', strtotime($StartDate)) == "8"){
						$Month = "8";
					}else if(date('n', strtotime($StartDate)) == "9"){
						$Month = "9";
					}else if(date('n', strtotime($StartDate)) == "10"){
						$Month = "10";
					}else if(date('n', strtotime($StartDate)) == "11"){
						$Month = "11";
					}else if(date('n', strtotime($StartDate)) == "12"){
						$Month = "12";
					}

					// FOR DAY
					if(date('j', strtotime($StartDate)) == "1"){
						$Day = "1";
					}else if(date('j', strtotime($StartDate)) == "2"){
						$Day = "2";
					}else if(date('j', strtotime($StartDate)) == "3"){
						$Day = "3";
					}else if(date('j', strtotime($StartDate)) == "4"){
						$Day = "4";
					}else if(date('j', strtotime($StartDate)) == "5"){
						$Day = "5";
					}else if(date('j', strtotime($StartDate)) == "6"){
						$Day = "6";
					}else if(date('j', strtotime($StartDate)) == "7"){
						$Day = "7";
					}else if(date('j', strtotime($StartDate)) == "8"){
						$Day = "8";
					}else if(date('j', strtotime($StartDate)) == "9"){
						$Day = "9";
					}else if(date('j', strtotime($StartDate)) == "10"){
						$Day = "10";
					}else if(date('j', strtotime($StartDate)) == "11"){
						$Day = "11";
					}else if(date('j', strtotime($StartDate)) == "12"){
						$Day = "12";
					}else if(date('j', strtotime($StartDate)) == "13"){
						$Day = "13";
					}else if(date('j', strtotime($StartDate)) == "14"){
						$Day = "14";
					}else if(date('j', strtotime($StartDate)) == "15"){
						$Day = "15";
					}else if(date('j', strtotime($StartDate)) == "16"){
						$Day = "16";
					}else if(date('j', strtotime($StartDate)) == "17"){
						$Day = "17";
					}else if(date('j', strtotime($StartDate)) == "18"){
						$Day = "18";
					}else if(date('j', strtotime($StartDate)) == "19"){
						$Day = "19";
					}else if(date('j', strtotime($StartDate)) == "20"){
						$Day = "20";
					}else if(date('j', strtotime($StartDate)) == "21"){
						$Day = "21";
					}else if(date('j', strtotime($StartDate)) == "22"){
						$Day = "22";
					}else if(date('j', strtotime($StartDate)) == "23"){
						$Day = "23";
					}else if(date('j', strtotime($StartDate)) == "24"){
						$Day = "24";
					}else if(date('j', strtotime($StartDate)) == "25"){
						$Day = "25";
					}else if(date('j', strtotime($StartDate)) == "26"){
						$Day = "26";
					}else if(date('j', strtotime($StartDate)) == "27"){
						$Day = "27";
					}else if(date('j', strtotime($StartDate)) == "28"){
						$Day = "28";
					}else if(date('j', strtotime($StartDate)) == "29"){
						$Day = "29";
					}else if(date('j', strtotime($StartDate)) == "30"){
						$Day = "30";
					}else if(date('j', strtotime($StartDate)) == "31"){
						$Day = "31";
					}
				}

				$resTenant = mysql_query("SELECT mallID, merchant_code, TenantID, withPOS, SFTP_User, SFTP_Pass, unitID FROM tbltrans_tenants WHERE (Status = 'Active' OR Status = 'ForEviction' OR Status = 'ForRenewal') AND ustatus = 'Occupied' AND uploadingoffiles = '1' AND datefrom <= '". date('Y-m-d', strtotime($StartDate)) ."' AND dateto >= '". date('Y-m-d', strtotime($StartDate)) ."' ORDER BY tradename ASC;", $connection);
				while($rowTenant = mysql_fetch_array($resTenant)){
					$Log = "";

					$FileName = str_replace("\\", "/", getcwd()) ."/". $rowTenant['merchant_code'] . $Month . $Day . date('y', strtotime($StartDate));
					$FileName2 = $rowTenant['merchant_code'] . $Month . $Day . date('y', strtotime($StartDate));
					$UploadStat = mysql_num_rows(mysql_query("SELECT id FROM db_syncfilestat WHERE reportDate = '". date('Y-m-d', strtotime($StartDate)) ."' AND tenantID = '". $rowTenant['TenantID'] ."';", $connection));
					if($UploadStat == 0){
						try{
							mysql_query("START transaction;");
						    $sftp = new Net_SFTP($filepath['SFTPHost']);
						    if($sftp->login(trim($rowTenant['SFTP_User']), trim($rowTenant['SFTP_Pass']))){
								if($sftp->file_exists($FileName2 . "D.csv")){
									$sftp->get($FileName2 . "D.csv", $FileName2 . "D.csv");
									$DiscRowCount = 0;
									$OpenDiscountCSV = fopen($FileName . "D.csv", "r");
									$resDiscountCSV = fgetcsv($OpenDiscountCSV, 1000, ";"); //REMOVE CSV HEADERS
									while(($rowDiscountCSV = fgetcsv($OpenDiscountCSV)) != FALSE){
										if($rowDiscountCSV[0] != "" || $rowDiscountCSV[1] != "" || $rowDiscountCSV[2] != "" || $rowDiscountCSV[3] != "" || $rowDiscountCSV[4] != "" || $rowDiscountCSV[5] != "" || $rowDiscountCSV[6] != "" || $rowDiscountCSV[7] != ""){
											if(date('Y-m-d', strtotime($rowDiscountCSV[0])) != date('Y-m-d', strtotime($StartDate)) || $rowDiscountCSV[1] != $rowTenant['merchant_code']){  
												$DiscRowCount++;
											}


										}
									}
									$DiscountVal = 0;
									if($DiscRowCount == 0){
										$OpenDiscountCSV = fopen($FileName . "D.csv", "r");
										$resDiscountCSV = fgetcsv($OpenDiscountCSV, 1000, ";"); //REMOVE CSV HEADERS
										while(($rowDiscountCSV = fgetcsv($OpenDiscountCSV)) != FALSE){
											$sqlDiscount = genUploadCSVQuery($filepath['dbsetup'], json_encode($rowDiscountCSV), $rowTenant['TenantID'], $rowTenant['mallID'], "Discount");
											$resDiscount = mysql_query($sqlDiscount, $connection);
										}
										$DiscountVal = 1;
									}else{
										$DiscountVal = 0;
									}
								}else{
									$DiscountVal = 2;
								}

								if($sftp->file_exists($FileName2 . "H.csv")){
									$sftp->get($FileName2 . "H.csv", $FileName2 . "H.csv");
									$HourlyRowCount = 0;
									$OpenHourlyCSV = fopen($FileName . "H.csv", "r");
									$resHourlyCSV = fgetcsv($OpenHourlyCSV, 1000, ";"); //REMOVE CSV HEADERS
									while(($rowHourlyCSV = fgetcsv($OpenHourlyCSV)) != FALSE){
										if($rowHourlyCSV[0] != "" || $rowHourlyCSV[1] != "" || $rowHourlyCSV[2] != "" || $rowHourlyCSV[3] != "" || $rowHourlyCSV[4] != "" || $rowHourlyCSV[5] != "" || $rowHourlyCSV[6] != ""){

											if($rowHourlyCSV[1] != $rowTenant['merchant_code']){
												$HourlyRowCount++;
											}

										}
									}
									$HourlyVal = 0;
									if($HourlyRowCount == 0){
										$OpenHourlyCSV = fopen($FileName . "H.csv", "r");
										$resHourlyCSV = fgetcsv($OpenHourlyCSV, 1000, ";"); //REMOVE CSV HEADERS
										while(($rowHourlyCSV = fgetcsv($OpenHourlyCSV)) != FALSE){
											$sqlHourly = genUploadCSVQuery($filepath['dbsetup'], json_encode($rowHourlyCSV), $rowTenant['TenantID'], $rowTenant['mallID'], "Hourly");
											$resHourly = mysql_query($sqlHourly, $connection);
										}
										$HourlyVal = 1;
									}else{
										$HourlyVal = 0;
									}
								}else{
									$HourlyVal = 2;
								}

								if($sftp->file_exists($FileName2 . "P.csv")){
									$sftp->get($FileName2 . "P.csv", $FileName2 . "P.csv");
									$PaymentRowCount = 0;
									$OpenPaymentCSV = fopen($FileName . "P.csv", "r");
									$resPaymentCSV = fgetcsv($OpenPaymentCSV, 1000, ";"); //REMOVE CSV HEADERS
									while(($rowPaymentCSV = fgetcsv($OpenPaymentCSV)) != FALSE){
										if($rowPaymentCSV[0] != "" || $rowPaymentCSV[1] != "" || $rowPaymentCSV[2] != "" || $rowPaymentCSV[3] != "" || $rowPaymentCSV[4] != "" || $rowPaymentCSV[5] != "" || $rowPaymentCSV[6] != ""){

											if(date('Y-m-d', strtotime($rowPaymentCSV[0])) != date('Y-m-d', strtotime($StartDate)) || $rowPaymentCSV[1] != $rowTenant['merchant_code']){  
												$PaymentRowCount++;
											}

										}
									}
									$PaymentVal = 0;
									if($PaymentRowCount == 0){
										// SELECT ACCREDITED PAYMENT TYPE
										$AccreditedPType = mysql_fetch_array(mysql_query("SELECT PaymentType FROM tblaccreditation WHERE TenantID = '". $rowTenant['TenantID'] ."'", $connection));
										$mgaMeron = "";
										$arr = explode("|", $AccreditedPType[0]);
										for ($i=0; $i <= count($arr)-2; $i++) { 
											$mgaMeron .= "'" . $arr[$i] . "'" . ",";
										}

										$OpenPaymentCSV = fopen($FileName . "P.csv", "r");
										$resPaymentCSV = fgetcsv($OpenPaymentCSV, 1000, ";"); //REMOVE CSV HEADERS
										while(($rowPaymentCSV = fgetcsv($OpenPaymentCSV)) != FALSE){
											$sqlPayment = genUploadCSVQuery($filepath['dbsetup'], json_encode($rowPaymentCSV), $rowTenant['TenantID'], $rowTenant['mallID'], "Payment");
											$resPayment = mysql_query($sqlPayment, $connection);
										}

										if($AccreditedPType[0] != ""){
											$FilterPayment = "AND ". $tblPayment[3] ." NOT IN (". substr(trim($mgaMeron), 0, -1) .")";
										}else{
											$FilterPayment = "";
										}
										
										$resNotAccreditedPType = mysql_query("SELECT mallID, tenantID, ". $tblPayment[1] .", ". $tblPayment[2] .", ". $tblPayment[3] .", ". $tblPayment[4] .", ". $tblPayment[5] .", ". $tblPayment[6] .", ". $tblPayment[7] .", id FROM ". $tblPayment[0] ." WHERE tenantID = '". $rowTenant['TenantID'] ."' ". $FilterPayment .";", $connection);
										$numNotAccreditedRows = mysql_num_rows($resNotAccreditedPType);
										if($numNotAccreditedRows == 0){
											$PaymentVal = 1;
										}else{
											$PaymentVal = 0;
											while($rowNotAccreditedPType = mysql_fetch_array($resNotAccreditedPType)){

												// INSERT INTO A SEPARATE TABLE FOR FUTURE TRACKING
												$resTransferNotAccredited = mysql_query("INSERT INTO ". $tblPayment[8] ." SET mallID = '". $rowNotAccreditedPType[0] ."', tenantID = '". $rowNotAccreditedPType[1] ."', ". $tblPayment[1] ." = '". $rowNotAccreditedPType[2] ."', fvcMrchntCd = '". $rowNotAccreditedPType[3] ."', ". $tblPayment[3] ." = '". $rowNotAccreditedPType[4] ."', fvcPymntDsc = '". $rowNotAccreditedPType[5] ."', fvcPymntCdCLSCd = '". $rowNotAccreditedPType[6] ."', fvcPymntCdCLSDsc = '". $rowNotAccreditedPType[7] ."', fnmPymnt = '". $rowNotAccreditedPType[8] ."';", $connection);

												if($resTransferNotAccredited == true){ // DELETE NOT ACCREDITED PAYMENT TYPE
													$resDeleteNotAccredited = mysql_query("DELETE FROM ". $tblPayment[0] ." WHERE ". $tblPayment[3] ." = '". $rowNotAccreditedPType[4] ."' AND tenantID = '". $rowNotAccreditedPType[1] ."' AND ". $tblPayment[1] ." = '". date('Y-m-d', strtotime($StartDate)) ."' AND id = '". $rowNotAccreditedPType['id'] ."';", $connection);
												}

											}
										}
									}else{
										$PaymentVal = 0;
									}
								}else{
									$PaymentVal = 2;
								}

								if($sftp->file_exists($FileName2 . "R.csv")){
									$sftp->get($FileName2 . "R.csv", $FileName2 . "R.csv");
									$VoidRowCount = 0;
									$VoidDateFormat1 = 0;
									$VoidDateFormat2 = 0;
									$OpenVoidCSV = fopen($FileName . "R.csv", "r");
									$resVoidCSV = fgetcsv($OpenVoidCSV, 1000, ";"); //REMOVE CSV HEADERS
									while(($rowVoidCSV = fgetcsv($OpenVoidCSV)) != FALSE){
										if($rowVoidCSV[0] != "" || $rowVoidCSV[1] != "" || $rowVoidCSV[2] != "" || $rowVoidCSV[3] != "" || $rowVoidCSV[4] != "" || $rowVoidCSV[5] != "" || $rowVoidCSV[6] != "" || $rowVoidCSV[7] != ""){

											if(date('Y-m-d', strtotime($rowVoidCSV[0])) != date('Y-m-d', strtotime($StartDate)) || $rowVoidCSV[1] != $rowTenant['merchant_code']){
												$VoidRowCount++;
											}

										}
									}
									$VoidVal = 0;
									if($VoidRowCount == 0){
										$OpenVoidCSV = fopen($FileName . "R.csv", "r");
										$resVoidCSV = fgetcsv($OpenVoidCSV, 1000, ";"); //REMOVE CSV HEADERS
										while(($rowVoidCSV = fgetcsv($OpenVoidCSV)) != FALSE){
											$sqlVoid = genUploadCSVQuery($filepath['dbsetup'], json_encode($rowVoidCSV), $rowTenant['TenantID'], $rowTenant['mallID'], "Void");
											$resVoid = mysql_query($sqlVoid, $connection);
										}
										$VoidVal = 1;
									}else{
										$VoidVal = 0;
									}
								}else{
									$VoidVal = 2;
								}

								if($sftp->file_exists($FileName2 . "S.csv")){
									$sftp->get($FileName2 . "S.csv", $FileName2 . "S.csv");
									$SalesCSVRowCount = 0;
									$SalesRowCount = 0;
									$OpenSalesCSV = fopen($FileName . "S.csv", "r");
									$resSalesCSV = fgetcsv($OpenSalesCSV, 1000, ";"); //REMOVE CSV HEADERS
									while(($resSalesCSV = fgetcsv($OpenSalesCSV)) != FALSE){
									if($resSalesCSV[0] != "" || $resSalesCSV[1] != "" || $resSalesCSV[2] != "" || $resSalesCSV[3] != "" || $resSalesCSV[4] != "" || $resSalesCSV[5] != "" || $resSalesCSV[6] != "" || $resSalesCSV[7] != "" || $resSalesCSV[8] != "" || $resSalesCSV[9] != "" || $resSalesCSV[10] != "" || $resSalesCSV[11] != "" || $resSalesCSV[12] != "" || $resSalesCSV[13] != "" || $resSalesCSV[14] != "" || $resSalesCSV[15] != "" || $resSalesCSV[16] != "" || $resSalesCSV[17] != "" || $resSalesCSV[18] != "" || $resSalesCSV[19] != "" || $resSalesCSV[20] != "" || $resSalesCSV[21] != "" || $resSalesCSV[22] != "" || $resSalesCSV[23] != "" || $resSalesCSV[24] != "" || $resSalesCSV[25] != "" || $resSalesCSV[26] != "" || $resSalesCSV[27] != "" || $resSalesCSV[28] != "" || $resSalesCSV[29] != "" || $resSalesCSV[30] != "" || $resSalesCSV[31] != "" || $resSalesCSV[32] != ""){

											if(date('Y-m-d', strtotime($resSalesCSV[0])) == date('Y-m-d', strtotime($StartDate)) && $resSalesCSV[1] == $rowTenant['merchant_code']){
												$SalesCSVRowCount++; //GET CORRECT ROW COUNT
											}

											if(date('Y-m-d', strtotime($resSalesCSV[0])) != date('Y-m-d', strtotime($StartDate)) && $resSalesCSV[1] != $rowTenant['merchant_code']){
												$SalesRowCount++;
											}

										}
									}
									$SalesVal = 0;
									if($SalesRowCount == 0 && $SalesCSVRowCount == $rowTenant['withPOS']){
										$OpenSalesCSV = fopen($FileName . "S.csv", "r");
										$resSalesCSV = fgetcsv($OpenSalesCSV, 1000, ";"); //REMOVE CSV HEADERS
										while(($rowSalesCSV = fgetcsv($OpenSalesCSV)) != FALSE){
											$sqlSales = genUploadCSVQuery($filepath['dbsetup'], json_encode($rowSalesCSV), $rowTenant['TenantID'], $rowTenant['mallID'], "Sales");
											$resSales = mysql_query($sqlSales, $connection);
										}
										$SalesVal = genSumSales($filepath['dbsetup'], $rowTenant['TenantID'], date('Y-m-d', strtotime($StartDate)));
									}else{
										$SalesVal = 0;
									}
								}else{
									$SalesVal = 2;
								}

								if($DiscountVal == 1){ $DiscountVal2 = 1; }else{ $DiscountVal2 = 0; }
								if($HourlyVal == 1){ $HourlyVal2 = 1; }else{ $HourlyVal2 = 0; }
								if($PaymentVal == 1){ $PaymentVal2 = 1; }else{ $PaymentVal2 = 0; }
								if($VoidVal == 1){ $VoidVal2 = 1; }else{ $VoidVal2 = 0; }
								if($SalesVal == 1){ $SalesVal2 = 1; }else{ $SalesVal2 = 0; }
								$CSVStats = $DiscountVal2 + $HourlyVal2 + $PaymentVal2 + $VoidVal2 + $SalesVal2;
							}else{
								$DiscountVal = 3;
								$HourlyVal = 3;
								$PaymentVal = 3;
								$VoidVal = 3;
								$SalesVal = 3;
								$CSVStats = 0;
							}

							$rowID = mysql_fetch_array(mysql_query(" SELECT refno FROM db_syncfilestat ORDER BY id DESC LIMIT 1 ", $connection));
							if($rowID[0] == ""){
								$refno = str_pad(1, 10, 0, STR_PAD_LEFT);
							}else{
								$refno = str_pad($rowID[0] + 1, 10, 0, STR_PAD_LEFT);
							}

							$resSyncStat = mysql_query("INSERT INTO db_syncfilestat SET tenantID = '". $rowTenant['TenantID'] ."', sales = '". $SalesVal ."', discount = '". $DiscountVal ."', void_refund = '". $VoidVal ."', salesperhour = '". $HourlyVal ."', paymenttype = '". $PaymentVal ."', reportDate = '".date('Y-m-d', strtotime($StartDate)) ."', countSync = '". $CSVStats ."', refno = '". $refno ."';", $connection);
							if($resSyncStat == 1){

								if($CSVStats == 5){
									$FloorPlanStat = 1;
								}else{
									$FloorPlanStat = 0;
								}

								$updateStats = " UPDATE tblunit_statuslogs SET txtStat = '". $FloorPlanStat ."' WHERE tenantID = '". $rowTenant['TenantID'] ."' AND unitID = '". $rowTenant['unitID'] ."' AND xdate = '". date('Y-m-d', strtotime($StartDate)) ."' ";
								$resupdate = mysql_query($updateStats, $connection);
								if($resupdate == true){

									$Log .= "CSV Date : ". date('m/d/Y', strtotime($StartDate)) ."|";
									if($DiscountVal == 1){
										$Log .= "Discount : Success|";
									}else if($DiscountVal == 2){
										$Log .= "Discount : File Not Found|";
									}else if($DiscountVal == 3){
										$Log .= "Discount : SFTP Access Denied|";
									}else{
										$Log .= "Discount : Failed|";
									}

									if($HourlyVal == 1){
										$Log .= "Hourly : Success|";
									}else if($HourlyVal == 2){
										$Log .= "Hourly : File Not Found|";
									}else if($HourlyVal == 3){
										$Log .= "Hourly : SFTP Access Denied|";
									}else{
										$Log .= "Hourly : Failed|";
									}

									if($PaymentVal == 1){
										$Log .= "Payment Type : Success|";
									}else if($PaymentVal == 2){
										$Log .= "Payment Type : File Not Found|";
									}else if($PaymentVal == 3){
										$Log .= "Payment Type : SFTP Access Denied|";
									}else{
										$Log .= "Payment Type : Failed|";
									}

									if($VoidVal == 1){
										$Log .= "Void : Success|";
									}else if($VoidVal == 2){
										$Log .= "Void : File Not Found|";
									}else if($VoidVal == 3){
										$Log .= "Void : SFTP Access Denied|";
									}else{
										$Log .= "Void : Failed|";
									}

									if($SalesVal == 1){
										$Log .= "Sales : Success|";
									}else if($SalesVal == 2){
										$Log .= "Sales : File Not Found|";
									}else if($SalesVal == 3){
										$Log .= "Sales : SFTP Access Denied|";
									}else{
										$Log .= "Sales : Failed|";
									}

									if($Log != ""){
										$tran_logs = create_logs_per_transaction("uploaded a CSV File", "File Monitoring Module", $Log, "", "ADD", $rowTenant['TenantID']);
									}
									
								}
								$SuccessCount++;
							}
						mysql_query("COMMIT;", $connection);
						}catch(Exception $e){
							echo $e;
							mysql_query("ROLLBACK;", $connection);
						}
				    }else{
						$ExistingCount++;
				    }

				}
				$StartDate = date('Y-m-d', strtotime($StartDate.'+1 day'));
			}

			if($SuccessCount >= 1 && $ExistingCount == 0){
				echo "1|";
			}else if($SuccessCount == 0 && $ExistingCount >= 1){
				echo "2|";
			}else if($SuccessCount >= 1 && $ExistingCount >= 1){
				echo "1|";
			}else{
				echo "3|";
			}
		break;

		case 'importcsvlate':
			$rowRefNo = mysql_fetch_array(mysql_query("SELECT refno, tenantID, sales, discount, void_refund, salesperhour, paymenttype, reportDate, countSync FROM db_syncfilestat where refno = '". $_POST['refno'] ."';", $connection));
			$rowTenant = mysql_fetch_array(mysql_query("SELECT mallID, merchant_code, TenantID, withPOS, SFTP_User, SFTP_Pass FROM tbltrans_tenants WHERE TenantID = '". $rowRefNo['tenantID'] ."';", $connection));
			$filepath = mysql_fetch_array(mysql_query("SELECT dbsetup, SFTPHost, SFTPPort FROM tblsys_setup;", $connection));
			$tblPayment = tblPayment($filepath['dbsetup']);

			if($filepath['dbsetup'] == "1"){
				// FOR MONTH
				if(date('n', strtotime($rowRefNo[7])) == "1"){
					$Month = "1";
				}else if(date('n', strtotime($rowRefNo[7])) == "2"){
					$Month = "2";
				}else if(date('n', strtotime($rowRefNo[7])) == "3"){
					$Month = "3";
				}else if(date('n', strtotime($rowRefNo[7])) == "4"){
					$Month = "4";
				}else if(date('n', strtotime($rowRefNo[7])) == "5"){
					$Month = "5";
				}else if(date('n', strtotime($rowRefNo[7])) == "6"){
					$Month = "6";
				}else if(date('n', strtotime($rowRefNo[7])) == "7"){
					$Month = "7";
				}else if(date('n', strtotime($rowRefNo[7])) == "8"){
					$Month = "8";
				}else if(date('n', strtotime($rowRefNo[7])) == "9"){
					$Month = "9";
				}else if(date('n', strtotime($rowRefNo[7])) == "10"){
					$Month = "A";
				}else if(date('n', strtotime($rowRefNo[7])) == "11"){
					$Month = "B";
				}else if(date('n', strtotime($rowRefNo[7])) == "12"){
					$Month = "C";
				}

				// FOR DAY
				if(date('j', strtotime($rowRefNo[7])) == "1"){
					$Day = "1";
				}else if(date('j', strtotime($rowRefNo[7])) == "2"){
					$Day = "2";
				}else if(date('j', strtotime($rowRefNo[7])) == "3"){
					$Day = "3";
				}else if(date('j', strtotime($rowRefNo[7])) == "4"){
					$Day = "4";
				}else if(date('j', strtotime($rowRefNo[7])) == "5"){
					$Day = "5";
				}else if(date('j', strtotime($rowRefNo[7])) == "6"){
					$Day = "6";
				}else if(date('j', strtotime($rowRefNo[7])) == "7"){
					$Day = "7";
				}else if(date('j', strtotime($rowRefNo[7])) == "8"){
					$Day = "8";
				}else if(date('j', strtotime($rowRefNo[7])) == "9"){
					$Day = "9";
				}else if(date('j', strtotime($rowRefNo[7])) == "10"){
					$Day = "A";
				}else if(date('j', strtotime($rowRefNo[7])) == "11"){
					$Day = "B";
				}else if(date('j', strtotime($rowRefNo[7])) == "12"){
					$Day = "C";
				}else if(date('j', strtotime($rowRefNo[7])) == "13"){
					$Day = "D";
				}else if(date('j', strtotime($rowRefNo[7])) == "14"){
					$Day = "E";
				}else if(date('j', strtotime($rowRefNo[7])) == "15"){
					$Day = "F";
				}else if(date('j', strtotime($rowRefNo[7])) == "16"){
					$Day = "G";
				}else if(date('j', strtotime($rowRefNo[7])) == "17"){
					$Day = "H";
				}else if(date('j', strtotime($rowRefNo[7])) == "18"){
					$Day = "I";
				}else if(date('j', strtotime($rowRefNo[7])) == "19"){
					$Day = "J";
				}else if(date('j', strtotime($rowRefNo[7])) == "20"){
					$Day = "K";
				}else if(date('j', strtotime($rowRefNo[7])) == "21"){
					$Day = "L";
				}else if(date('j', strtotime($rowRefNo[7])) == "22"){
					$Day = "M";
				}else if(date('j', strtotime($rowRefNo[7])) == "23"){
					$Day = "N";
				}else if(date('j', strtotime($rowRefNo[7])) == "24"){
					$Day = "O";
				}else if(date('j', strtotime($rowRefNo[7])) == "25"){
					$Day = "P";
				}else if(date('j', strtotime($rowRefNo[7])) == "26"){
					$Day = "Q";
				}else if(date('j', strtotime($rowRefNo[7])) == "27"){
					$Day = "R";
				}else if(date('j', strtotime($rowRefNo[7])) == "28"){
					$Day = "S";
				}else if(date('j', strtotime($rowRefNo[7])) == "29"){
					$Day = "T";
				}else if(date('j', strtotime($rowRefNo[7])) == "30"){
					$Day = "U";
				}else if(date('j', strtotime($rowRefNo[7])) == "31"){
					$Day = "V";
				}
			}else{
				// FOR MONTH
				if(date('n', strtotime($rowRefNo[7])) == "1"){
					$Month = "1";
				}else if(date('n', strtotime($rowRefNo[7])) == "2"){
					$Month = "2";
				}else if(date('n', strtotime($rowRefNo[7])) == "3"){
					$Month = "3";
				}else if(date('n', strtotime($rowRefNo[7])) == "4"){
					$Month = "4";
				}else if(date('n', strtotime($rowRefNo[7])) == "5"){
					$Month = "5";
				}else if(date('n', strtotime($rowRefNo[7])) == "6"){
					$Month = "6";
				}else if(date('n', strtotime($rowRefNo[7])) == "7"){
					$Month = "7";
				}else if(date('n', strtotime($rowRefNo[7])) == "8"){
					$Month = "8";
				}else if(date('n', strtotime($rowRefNo[7])) == "9"){
					$Month = "9";
				}else if(date('n', strtotime($rowRefNo[7])) == "10"){
					$Month = "10";
				}else if(date('n', strtotime($rowRefNo[7])) == "11"){
					$Month = "11";
				}else if(date('n', strtotime($rowRefNo[7])) == "12"){
					$Month = "12";
				}

				// FOR DAY
				if(date('j', strtotime($rowRefNo[7])) == "1"){
					$Day = "1";
				}else if(date('j', strtotime($rowRefNo[7])) == "2"){
					$Day = "2";
				}else if(date('j', strtotime($rowRefNo[7])) == "3"){
					$Day = "3";
				}else if(date('j', strtotime($rowRefNo[7])) == "4"){
					$Day = "4";
				}else if(date('j', strtotime($rowRefNo[7])) == "5"){
					$Day = "5";
				}else if(date('j', strtotime($rowRefNo[7])) == "6"){
					$Day = "6";
				}else if(date('j', strtotime($rowRefNo[7])) == "7"){
					$Day = "7";
				}else if(date('j', strtotime($rowRefNo[7])) == "8"){
					$Day = "8";
				}else if(date('j', strtotime($rowRefNo[7])) == "9"){
					$Day = "9";
				}else if(date('j', strtotime($rowRefNo[7])) == "10"){
					$Day = "10";
				}else if(date('j', strtotime($rowRefNo[7])) == "11"){
					$Day = "11";
				}else if(date('j', strtotime($rowRefNo[7])) == "12"){
					$Day = "12";
				}else if(date('j', strtotime($rowRefNo[7])) == "13"){
					$Day = "13";
				}else if(date('j', strtotime($rowRefNo[7])) == "14"){
					$Day = "14";
				}else if(date('j', strtotime($rowRefNo[7])) == "15"){
					$Day = "15";
				}else if(date('j', strtotime($rowRefNo[7])) == "16"){
					$Day = "16";
				}else if(date('j', strtotime($rowRefNo[7])) == "17"){
					$Day = "17";
				}else if(date('j', strtotime($rowRefNo[7])) == "18"){
					$Day = "18";
				}else if(date('j', strtotime($rowRefNo[7])) == "19"){
					$Day = "19";
				}else if(date('j', strtotime($rowRefNo[7])) == "20"){
					$Day = "20";
				}else if(date('j', strtotime($rowRefNo[7])) == "21"){
					$Day = "21";
				}else if(date('j', strtotime($rowRefNo[7])) == "22"){
					$Day = "22";
				}else if(date('j', strtotime($rowRefNo[7])) == "23"){
					$Day = "23";
				}else if(date('j', strtotime($rowRefNo[7])) == "24"){
					$Day = "24";
				}else if(date('j', strtotime($rowRefNo[7])) == "25"){
					$Day = "25";
				}else if(date('j', strtotime($rowRefNo[7])) == "26"){
					$Day = "26";
				}else if(date('j', strtotime($rowRefNo[7])) == "27"){
					$Day = "27";
				}else if(date('j', strtotime($rowRefNo[7])) == "28"){
					$Day = "28";
				}else if(date('j', strtotime($rowRefNo[7])) == "29"){
					$Day = "29";
				}else if(date('j', strtotime($rowRefNo[7])) == "30"){
					$Day = "30";
				}else if(date('j', strtotime($rowRefNo[7])) == "31"){
					$Day = "31";
				}
			}

			$FileName = str_replace("\\", "/", getcwd()) ."/". $rowTenant['merchant_code'] . $Month . $Day . date('y', strtotime($rowRefNo['reportDate']));
			$FileName2 = $rowTenant['merchant_code'] . $Month . $Day . date('y', strtotime($rowRefNo['reportDate']));

			$sftp = new Net_SFTP($filepath['SFTPHost']);
		    if($sftp->login(trim($rowTenant['SFTP_User']), trim($rowTenant['SFTP_Pass']))){
		    	try{
					mysql_query("START transaction;");
					$DiscountVal = 0;
					if($rowRefNo['discount'] != 1){
						if($sftp->file_exists($FileName2 . "D.csv")){
							$sftp->get($FileName2 . "D.csv", $FileName2 . "D.csv");
							$DiscRowCount = 0;
							$OpenDiscountCSV = fopen($FileName . "D.csv", "r");
							$resDiscountCSV = fgetcsv($OpenDiscountCSV, 1000, ";"); //REMOVE CSV HEADERS
							while(($rowDiscountCSV = fgetcsv($OpenDiscountCSV)) != FALSE){
								if($rowDiscountCSV[0] != "" || $rowDiscountCSV[1] != "" || $rowDiscountCSV[2] != "" || $rowDiscountCSV[3] != "" || $rowDiscountCSV[4] != "" || $rowDiscountCSV[5] != "" || $rowDiscountCSV[6] != "" || $rowDiscountCSV[7] != ""){

									if(date('Y-m-d', strtotime($rowDiscountCSV[0])) != date('Y-m-d', strtotime($rowRefNo['reportDate'])) || $rowDiscountCSV[1] != $rowTenant['merchant_code']){  
										$DiscRowCount++;
									}

								}
							}
							if($DiscRowCount == 0){
								$OpenDiscountCSV = fopen($FileName . "D.csv", "r");
								$resDiscountCSV = fgetcsv($OpenDiscountCSV, 1000, ";"); //REMOVE CSV HEADERS
								while(($rowDiscountCSV = fgetcsv($OpenDiscountCSV)) != FALSE){
									$sqlDiscount = genUploadCSVQuery($filepath['dbsetup'], json_encode($rowDiscountCSV), $rowTenant['TenantID'], $rowTenant['mallID'], "Discount");
									$resDiscount = mysql_query($sqlDiscount, $connection);
								}
								$DiscountVal = 1;
							}else{
								$DiscountVal = 0;
							}
						}else{
							$DiscountVal = 2;
						}
					}else{
						$DiscountVal = $rowRefNo['discount'];
					}

					$HourlyVal = 0;
					if($rowRefNo['salesperhour'] != 1){
						if($sftp->file_exists($FileName2 . "H.csv")){
							$sftp->get($FileName2 . "H.csv", $FileName2 . "H.csv");
							$HourlyRowCount = 0;
							$OpenHourlyCSV = fopen($FileName . "H.csv", "r");
							$resHourlyCSV = fgetcsv($OpenHourlyCSV, 1000, ";"); //REMOVE CSV HEADERS
							while(($rowHourlyCSV = fgetcsv($OpenHourlyCSV)) != FALSE){
								if($rowHourlyCSV[0] != "" || $rowHourlyCSV[1] != "" || $rowHourlyCSV[2] != "" || $rowHourlyCSV[3] != "" || $rowHourlyCSV[4] != "" || $rowHourlyCSV[5] != "" || $rowHourlyCSV[6] != ""){

									if($rowHourlyCSV[1] != $rowTenant['merchant_code']){
										$HourlyRowCount++;
									}

								}
							}
							if($HourlyRowCount == 0){
								$OpenHourlyCSV = fopen($FileName . "H.csv", "r");
								$resHourlyCSV = fgetcsv($OpenHourlyCSV, 1000, ";"); //REMOVE CSV HEADERS
								while(($rowHourlyCSV = fgetcsv($OpenHourlyCSV)) != FALSE){
									$sqlHourly = genUploadCSVQuery($filepath['dbsetup'], json_encode($rowHourlyCSV), $rowTenant['TenantID'], $rowTenant['mallID'], "Hourly");
									$resHourly = mysql_query($sqlHourly, $connection);
								}
								$HourlyVal = 1;
							}else{
								$HourlyVal = 0;
							}
						}else{
							$HourlyVal = 2;
						}
					}else{
						$HourlyVal = $rowRefNo['salesperhour'];
					}

					$PaymentVal = 0;
					if($rowRefNo['paymenttype'] != 1){
						if($sftp->file_exists($FileName2 . "P.csv")){
							$sftp->get($FileName2 . "P.csv", $FileName2 . "P.csv");
							$PaymentRowCount = 0;
							$OpenPaymentCSV = fopen($FileName . "P.csv", "r");
							$resPaymentCSV = fgetcsv($OpenPaymentCSV, 1000, ";"); //REMOVE CSV HEADERS
							while(($rowPaymentCSV = fgetcsv($OpenPaymentCSV)) != FALSE){
								if($rowPaymentCSV[0] != "" || $rowPaymentCSV[1] != "" || $rowPaymentCSV[2] != "" || $rowPaymentCSV[3] != "" || $rowPaymentCSV[4] != "" || $rowPaymentCSV[5] != "" || $rowPaymentCSV[6] != ""){

									if(date('Y-m-d', strtotime($rowPaymentCSV[0])) != date('Y-m-d', strtotime($rowRefNo['reportDate'])) || $rowPaymentCSV[1] != $rowTenant['merchant_code']){  
										$PaymentRowCount++;
									}

								}
							}
							if($PaymentRowCount == 0){
								// SELECT ACCREDITED PAYMENT TYPE
								$AccreditedPType = mysql_fetch_array(mysql_query("SELECT PaymentType FROM tblaccreditation WHERE TenantID = '". $rowTenant['TenantID'] ."';", $connection));
								$mgaMeron = "";
								$arr = explode("|", $AccreditedPType[0]);
								for ($i=0; $i <= count($arr)-2; $i++) { 
									$mgaMeron .= "'" . $arr[$i] . "'" . ",";
								}

								$OpenPaymentCSV = fopen($FileName . "P.csv", "r");
								$resPaymentCSV = fgetcsv($OpenPaymentCSV, 1000, ";"); //REMOVE CSV HEADERS
								while(($rowPaymentCSV = fgetcsv($OpenPaymentCSV)) != FALSE){
									$sqlPayment = genUploadCSVQuery($filepath['dbsetup'], json_encode($rowPaymentCSV), $rowTenant['TenantID'], $rowTenant['mallID'], "Payment");
									$resPayment = mysql_query($sqlPayment, $connection);
								}

								if($AccreditedPType[0] != ""){
									$FilterPayment = "AND ". $tblPayment[3] ." NOT IN (". substr(trim($mgaMeron), 0, -1) .")";
								}else{
									$FilterPayment = "";
								}
								
								$resNotAccreditedPType = mysql_query("SELECT mallID, tenantID, ". $tblPayment[1] .", ". $tblPayment[2] .", ". $tblPayment[3] .", ". $tblPayment[4] .", ". $tblPayment[5] .", ". $tblPayment[6] .", ". $tblPayment[7] .", id FROM ". $tblPayment[0] ." WHERE tenantID = '". $rowTenant['TenantID'] ."' ". $FilterPayment .";", $connection);
								$numNotAccreditedRows = mysql_num_rows($resNotAccreditedPType);
								if($numNotAccreditedRows == 0){
									$PaymentVal = 1;
								}else{
									$PaymentVal = 0;
									while($rowNotAccreditedPType = mysql_fetch_array($resNotAccreditedPType)){

										// INSERT INTO A SEPARATE TABLE FOR FUTURE TRACKING
										$resTransferNotAccredited = mysql_query("INSERT INTO ". $tblPayment[8] ." SET mallID = '". $rowNotAccreditedPType[0] ."', tenantID = '". $rowNotAccreditedPType[1] ."', ". $tblPayment[1] ." = '". $rowNotAccreditedPType[2] ."', fvcMrchntCd = '". $rowNotAccreditedPType[3] ."', ". $tblPayment[3] ." = '". $rowNotAccreditedPType[4] ."', fvcPymntDsc = '". $rowNotAccreditedPType[5] ."', fvcPymntCdCLSCd = '". $rowNotAccreditedPType[6] ."', fvcPymntCdCLSDsc = '". $rowNotAccreditedPType[7] ."', fnmPymnt = '". $rowNotAccreditedPType[8] ."';", $connection);

										if($resTransferNotAccredited == true){ // DELETE NOT ACCREDITED PAYMENT TYPE
											$resDeleteNotAccredited = mysql_query("DELETE FROM ". $tblPayment[0] ." WHERE ". $tblPayment[3] ." = '". $rowNotAccreditedPType[4] ."' AND tenantID = '". $rowNotAccreditedPType[1] ."' AND ". $tblPayment[1] ." = '". date('Y-m-d', strtotime($StartDate)) ."' AND id = '". $rowNotAccreditedPType['id'] ."';", $connection);
										}

									}
								}
							}else{
								$PaymentVal = 0;
							}
						}else{
							$PaymentVal = 2;
						}
					}else{
						$PaymentVal = $rowRefNo['paymenttype'];
					}

					$VoidVal = 0;
					if($rowRefNo['void_refund'] != 1){
						if($sftp->file_exists($FileName2 . "R.csv")){
							$sftp->get($FileName2 . "R.csv", $FileName2 . "R.csv");
							$VoidRowCount = 0;
							$OpenVoidCSV = fopen($FileName . "R.csv", "r");
							$resVoidCSV = fgetcsv($OpenVoidCSV, 1000, ";"); //REMOVE CSV HEADERS
							while (($resVoidCSV = fgetcsv($OpenVoidCSV)) != FALSE) {
								if($resVoidCSV[0] != "" || $resVoidCSV[1] != "" || $resVoidCSV[2] != "" || $resVoidCSV[3] != "" || $resVoidCSV[4] != "" || $resVoidCSV[5] != "" || $resVoidCSV[6] != "" || $resVoidCSV[7] != ""){

									if(date('Y-m-d', strtotime($resVoidCSV[0])) != date('Y-m-d', strtotime($rowRefNo['reportDate'])) || $resVoidCSV[1] != $rowTenant['merchant_code']){
										$VoidRowCount++;
									}

								}
							}
							if($VoidRowCount == 0){
								$OpenVoidCSV = fopen($FileName . "R.csv", "r");
								$resVoidCSV = fgetcsv($OpenVoidCSV, 1000, ";"); //REMOVE CSV HEADERS
								while(($rowVoidCSV = fgetcsv($OpenVoidCSV)) != FALSE){
									$sqlVoid = genUploadCSVQuery($filepath['dbsetup'], json_encode($rowVoidCSV), $rowTenant['TenantID'], $rowTenant['mallID'], "Void");
									$resVoid = mysql_query($sqlVoid, $connection);
								}
								$VoidVal = 1;
							}else{
								$VoidVal = 0;
							}
						}else{
							$VoidVal = 2;
						}
					}else{
						$VoidVal = $rowRefNo['void_refund'];
					}

					$SalesVal = 0;
					if($rowRefNo['sales'] != 1){
						if($sftp->file_exists($FileName2 . "S.csv")){
							$sftp->get($FileName2 . "S.csv", $FileName2 . "S.csv");
							$SalesCSVRowCount = 0;
							$SalesRowCount = 0;
							$OpenSalesCSV = fopen($FileName . "S.csv", "r");
							$resSalesCSV = fgetcsv($OpenSalesCSV, 1000, ";"); //REMOVE CSV HEADERS
							while(($resSalesCSV = fgetcsv($OpenSalesCSV)) != FALSE){
								if($resSalesCSV[0] != "" || $resSalesCSV[1] != "" || $resSalesCSV[2] != "" || $resSalesCSV[3] != "" || $resSalesCSV[4] != "" || $resSalesCSV[5] != "" || $resSalesCSV[6] != "" || $resSalesCSV[7] != "" || $resSalesCSV[8] != "" || $resSalesCSV[9] != "" || $resSalesCSV[10] != "" || $resSalesCSV[11] != "" || $resSalesCSV[12] != "" || $resSalesCSV[13] != "" || $resSalesCSV[14] != "" || $resSalesCSV[15] != "" || $resSalesCSV[16] != "" || $resSalesCSV[17] != "" || $resSalesCSV[18] != "" || $resSalesCSV[19] != "" || $resSalesCSV[20] != "" || $resSalesCSV[21] != "" || $resSalesCSV[22] != "" || $resSalesCSV[23] != "" || $resSalesCSV[24] != "" || $resSalesCSV[25] != "" || $resSalesCSV[26] != "" || $resSalesCSV[27] != "" || $resSalesCSV[28] != "" || $resSalesCSV[29] != "" || $resSalesCSV[30] != "" || $resSalesCSV[31] != "" || $resSalesCSV[32] != ""){

									if(date('Y-m-d', strtotime($resSalesCSV[0])) == date('Y-m-d', strtotime($rowRefNo['reportDate'])) && $resSalesCSV[1] == $rowTenant['merchant_code']){
										$SalesCSVRowCount++; //GET CORRECT ROW COUNT
									}

									if(date('Y-m-d', strtotime($resSalesCSV[0])) != date('Y-m-d', strtotime($rowRefNo['reportDate'])) && $resSalesCSV[1] != $rowTenant['merchant_code']){
										$SalesRowCount++;
									}

								}
							}
							if($SalesRowCount == 0 && $SalesCSVRowCount == $rowTenant['withPOS']){
								$OpenSalesCSV = fopen($FileName . "S.csv", "r");
								$resSalesCSV = fgetcsv($OpenSalesCSV, 1000, ";"); //REMOVE CSV HEADERS
								while(($rowSalesCSV = fgetcsv($OpenSalesCSV)) != FALSE){
									$sqlSales = genUploadCSVQuery($filepath['dbsetup'], json_encode($rowSalesCSV), $rowTenant['TenantID'], $rowTenant['mallID'], "Sales");
									$resSales = mysql_query($sqlSales, $connection);
								}
								$SalesVal = genSumSales($filepath['dbsetup'], $rowTenant['TenantID'], date('Y-m-d', strtotime($rowRefNo['reportDate'])));
							}else{
								$SalesVal = 0;
							}
						}else{
							$SalesVal = 2;
						}
					}else{
						$SalesVal = $rowRefNo['sales'];
					}

					if($DiscountVal == 1){ $DiscountVal2 = 1; }else{ $DiscountVal2 = 0; }
					if($HourlyVal == 1){ $HourlyVal2 = 1; }else{ $HourlyVal2 = 0; }
					if($PaymentVal == 1){ $PaymentVal2 = 1; }else{ $PaymentVal2 = 0; }
					if($VoidVal == 1){ $VoidVal2 = 1; }else{ $VoidVal2 = 0; }
					if($SalesVal == 1){ $SalesVal2 = 1; }else{ $SalesVal2 = 0; }
					$CSVStats = $DiscountVal2 + $HourlyVal2 + $PaymentVal2 + $VoidVal2 + $SalesVal2;

					$resSync = mysql_query("UPDATE db_syncfilestat SET sales = '". $SalesVal ."', discount = '". $DiscountVal ."', void_refund = '". $VoidVal ."', salesperhour = '". $HourlyVal ."', paymenttype = '". $PaymentVal ."', countSync = '". $CSVStats ."', VAL_STAT = '". $VALSTAT ."' WHERE refno = '". $_POST['refno'] ."';", $connection);
					if($resSync == true){
						$newTotal = $rowRefNo[8] + $CSVStats;
						if($newTotal == 5){
							$resUploads = mysql_query("UPDATE db_syncfilestat SET uploaded = '1' WHERE refno = '". $_POST['refno'] ."';", $connection);
							$resUnitStatLogs = mysql_query("UPDATE tblunit_statuslogs SET txtStat = '1' WHERE tenantID = '". $rowTenant['TenantID'] ."' AND unitID = '". $rowTenant['unitID'] ."' AND xdate = '". date('Y-m-d', strtotime($rowRefNo['reportDate'])) ."';", $connection);
						}

						$Log .= "CSV Date : ". date('m/d/Y', strtotime($rowRefNo['reportDate'])) ."|";
						if($rowRefNo['discount'] == 1){
							$Discount = "Success";
						}else if($rowRefNo['discount'] == 2){
							$Discount = "File Not Found";
						}else if($rowRefNo['discount'] == 3){
							$Discount = "SFTP Access Denied";
						}else{
							$Discount = "Failed";
						}

						if($DiscountVal == 1){
							$Discount2 = "Success";
						}else if($DiscountVal == 2){
							$Discount2 = "File Not Found";
						}else if($DiscountVal == 3){
							$Discount2 = "SFTP Access Denied";
						}else{
							$Discount2 = "Failed";
						}

						if($rowRefNo['salesperhour'] == 1){
							$Hourly = "Success";
						}else if($rowRefNo['salesperhour'] == 2){
							$Hourly = "File Not Found";
						}else if($rowRefNo['salesperhour'] == 3){
							$Hourly = "SFTP Access Denied";
						}else{
							$Hourly = "Failed";
						}

						if($HourlyVal == 1){
							$Hourly2 = "Success";
						}else if($HourlyVal == 2){
							$Hourly2 = "File Not Found";
						}else if($HourlyVal == 3){
							$Hourly2 = "SFTP Access Denied";
						}else{
							$Hourly2 = "Failed";
						}

						if($rowRefNo['paymenttype'] == 1){
							$Payment = "Success";
						}else if($rowRefNo['paymenttype'] == 2){
							$Payment = "File Not Found";
						}else if($rowRefNo['paymenttype'] == 3){
							$Payment = "SFTP Access Denied";
						}else{
							$Payment = "Failed";
						}

						if($PaymentVal == 1){
							$Payment2 = "Success";
						}else if($PaymentVal == 2){
							$Payment2 = "File Not Found";
						}else if($PaymentVal == 3){
							$Payment2 = "SFTP Access Denied";
						}else{
							$Payment2 = "Failed";
						}

						if($rowRefNo['void_refund'] == 1){
							$Void = "Success";
						}else if($rowRefNo['void_refund'] == 2){
							$Void = "File Not Found";
						}else if($rowRefNo['void_refund'] == 3){
							$Void = "SFTP Access Denied";
						}else{
							$Void = "Failed";
						}

						if($VoidVal == 1){
							$Void2 = "Success";
						}else if($VoidVal == 2){
							$Void2 = "File Not Found";
						}else if($VoidVal == 3){
							$Void2 = "SFTP Access Denied";
						}else{
							$Void2 = "Failed";
						}

						if($rowRefNo['sales'] == 1){
							$Sales = "Success";
						}else if($rowRefNo['sales'] == 2){
							$Sales = "File Not Found";
						}else if($rowRefNo['sales'] == 3){
							$Sales = "SFTP Access Denied";
						}else{
							$Sales = "Failed";
						}

						if($SalesVal == 1){
							$Sales2 = "Success";
						}else if($SalesVal == 2){
							$Sales2 = "File Not Found";
						}else if($SalesVal == 3){
							$Sales2 = "SFTP Access Denied";
						}else{
							$Sales2 = "Failed";
						}

						if($rowRefNo['discount'] != $DiscountVal){
							$Log .= "Discount : From ". $Discount ." To ". $Discount2 ."|";
						}
						if($rowRefNo['salesperhour'] != $Hourly){
							$Log .= "Hourly : From ". $Hourly ." To ". $Hourly2 ."|";
						}
						if($rowRefNo['paymenttype'] != $PaymentVal){
							$Log .= "Payment Type : From ". $Payment ." To ". $Payment2 ."|";
						}
						if($rowRefNo['void_refund'] != $VoidVal){
							$Log .= "Void : From ". $Void ." To ". $Void2 ."|";
						}
						if($rowRefNo['sales'] != $SalesVal){
							$Log .= "Sales : From ". $Sales ." To ". $Sales2 ."|";
						}

						if($Log != ""){
							$tran_logs = create_logs_per_transaction("uploaded a CSV File", "File Monitoring Module", $Log, "", "EDIT", $rowTenant['TenantID']);
						}
					}
					mysql_query("COMMIT;", $connection);
				}catch(Exception $e){
					echo $e;
					mysql_query("ROLLBACK;", $connection);
				}
			}
		break;

		case 'deletethis':
			array_map('unlink', glob(str_replace("\\", "/", getcwd())."/*.csv"));
		break;
	}
?>