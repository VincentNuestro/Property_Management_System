<?php
    session_start();
	include('../connect.php');
	$resTenant = mysql_query("SELECT mallid, merchant_code, withPOS FROM tbltrans_tenants WHERE TenantID = '". $_REQUEST['TenantID'] ."'AND ustatus = 'Occupied' AND datefrom <= '". date('Y-m-d', strtotime($_REQUEST['txtInputDateCSV'])) ."' AND dateto >= '". date('Y-m-d', strtotime($_REQUEST['txtInputDateCSV'])) ."'", $connection);
	$rowTenantCount = mysql_num_rows($resTenant);
	$rowTenant = mysql_fetch_array($resTenant);

	$dbsetup = mysql_fetch_array(mysql_query("SELECT dbsetup FROM tblsys_setup", $connection));

	if($dbsetup['dbsetup'] == "1"){
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
	
	$PaymentCSV = $_FILES["txtInputPaymentCSV"]["name"];
	$TMP_PaymentCSV = $_FILES["txtInputPaymentCSV"]["tmp_name"];

	$TargetPaymentCSV1 = $rowTenant['merchant_code'] . $Month . $Day . date('y', strtotime($_REQUEST['txtInputDateCSV'])) . "P.csv";
	$TargetPaymentCSV2 = $rowTenant['merchant_code'] . $Month . $Day . date('y', strtotime($_REQUEST['txtInputDateCSV'])) . "P.CSV";

	if($rowTenantCount > 0){
		if($TargetPaymentCSV1 == $PaymentCSV || $TargetPaymentCSV2 == $PaymentCSV){
			$PaymentRowCount = 0;
			$OpenPaymentCSV = fopen($TMP_PaymentCSV, "r");
			$resPaymentCSV = fgetcsv($OpenPaymentCSV, 1000, ";"); //Remove if CSV file does not have column headings
			while(($resPaymentCSV = fgetcsv($OpenPaymentCSV)) != FALSE){
				if($resPaymentCSV[0] != "" || $resPaymentCSV[1] != "" || $resPaymentCSV[2] != "" || $resPaymentCSV[3] != "" || $resPaymentCSV[4] != "" || $resPaymentCSV[5] != "" || $resPaymentCSV[6] != ""){

					if(date('Y-m-d', strtotime($resPaymentCSV[0])) != date('Y-m-d', strtotime($_REQUEST['txtInputDateCSV'])) || $resPaymentCSV[1] != $rowTenant['merchant_code']){
						$PaymentRowCount++;
					}

				}				
			}
			if($PaymentRowCount == 0){
				echo "4|Success";
			}else{
				echo "3|CSV file doesn't meet the required standard.";
			}
		}else{
			echo "2|Filename of the selected CSV file doesn't match with your target date.";
		}
	}else{
		echo "1|Your target date is either less than the date you occupy or exceeds the date of your occupancy.";
	}
	mysql_close($connection);
?>