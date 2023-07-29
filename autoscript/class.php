<?php
	$open = fopen("../../ipaddress.txt", 'r');
	$size = filesize("../../ipaddress.txt");
	$txtIPAddress = str_replace("\n", "", fread($open, $size));
	fclose($open);
	set_time_limit(0);
	date_default_timezone_set("Asia/Manila");
	$mydate = date("Y-m-d");
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));
	// $connection = mysql_connect($txtIPAddress, 'gates', 'g@tes2009');
	$connection = mysql_connect($txtIPAddress, 'gates', 'G@+35_@!1_p@$$');
	if(!$connection){ 
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db("gates_smm", $connection) or die("Error on database: " . mysql_error());
	mysql_query("SET NAMES 'utf8'");
	mysql_query("SET CHARACTER SET utf8");
	mysql_query("SET COLLATION_CONNECTION = 'utf8_unicode_ci'");

	function getsysdate(){
		$sql = mysql_fetch_array(mysql_query("SELECT eoddate FROM tbltrans_eod ORDER BY eoddate DESC LIMIT 0,1"));
		if($sql[0] == ""){
			return date("Y-m-d"); //if eod table is empty
		}else{
			return date("Y-m-d", strtotime($sql[0]));
		}
	}

	function tblDiscount($db){
		if($db == "1"){
			$tblDiscount = array('fdb_discount', 'fdtTrnsctn', 'fvcMrchntCd', 'fvcDscntCd', 'fvcDscntPrcntg', 'fnmDscnt', 'fnmCntDcmnt', 'fnmCntCstmr', 'fnmCntSnrCtzn');
		}else{
			$tblDiscount = array('sdb_discount', 'DteTrnsctn', 'MrchntCd', 'DscntCd', 'DscntPrcntg', 'Dscnt', 'CntDcmnt', 'CntCstmr', 'CntSnrCtzn');
		}
		return $tblDiscount;
	}

	function tblHourly($db){
		if($db == "1"){
			$tblHourly = array('fdb_perhour', 'fdtTrnsctn', 'fvcMrchntCd', 'fvcHRLCd', 'fnmDlySls', 'fnmCntDcmnt', 'fnmCntCstmr', 'fnmCntSnrCtzn');
		}else{
			$tblHourly = array('sdb_perhour', 'DteTrnsctn', 'MrchntCd', 'HRLCd', 'DlySls', 'CntDcmnt', 'CntCstmr', 'CntSnrCtzn');
		}
		return $tblHourly;
	}

	function tblPayment($db){
		if($db == "1"){
			$tblPayment = array('fdb_paymenttypes', 'fdtTrnsctn', 'fvcMrchntCd', 'fvcPymntCd', 'fvcPymntDsc', 'fvcPymntCdCLSCd', 'fvcPymntCdCLSDsc', 'fnmPymnt', 'fdb_not_paymenttypes');
		}else{
			$tblPayment = array('sdb_paymenttypes', 'DteTrnsctn', 'MrchntCd', 'PymntCd', 'PymntDsc', 'PymntCdCLSCd', 'PymntCdCLSDsc', 'Pymnt', 'sdb_not_paymenttypes');
		}
		return $tblPayment;
	}

	function tblVoid($db){
		if($db == "1"){
			$tblVoid = array('fdb_void', 'fdtTrnsctn', 'fvcMrchntCd', 'fvcRfndCncldCd', 'fvcRfndCncldRsn', 'fnmAmt', 'fnmCntDcmnt', 'fnmCntCstmr', 'fnmCntSnrCtzn');
		}else{
			$tblVoid = array('sdb_void', 'DteTrnsctn', 'MrchntCd', 'RfndCncldCd', 'RfndCncldRsn', 'Amt', 'CntDcmnt', 'CntCstmr', 'CntSnrCtzn');
		}
		return $tblVoid;
	}

	function tblSales($db){
		if($db == "1"){
			$tblSales = array('fdb_sales', 'fdtTrnsctn', 'fvcMrchntCd', 'fvcMrcntDsc', 'fnmGrndTtlOld', 'fnmGrndTtlNew', 'fnmGTDlySls', 'fnmGTDscnt', 'fnmGTDscntSNR', 'fnmGTDscntPWD', 'fnmGTDscntGPC', 'fnmGTDscntVIP', 'fnmGTDscntEMP', 'fnmGTDscntREG', 'fnmGTDscntOTH', 'fnmGTRfnd', 'fnmGTCncld', 'fnmGTSlsVAT', 'fnmGTVATSlsInclsv', 'fnmGTVATSlsExclsv', 'fnmOffclRcptBeg', 'fnmOffclRcptEnd', 'fnmGTCntDcmnt', 'fnmGTCntCstmr', 'fnmGTCntSnrCtzn', 'fnmGTLclTax', 'fnmGTSrvcChrg', 'fnmGTSlsNonVat', 'fnmGTRwGrss', 'fnmGTLclTaxDly', 'fvcWrksttnNmbr', 'fnmGTPymntCSH', 'fnmGTPymntCRD', 'fnmGTPymntOTH', 'fdb_salesbymn');
		}else{
			$tblSales = array('sdb_sales', 'DteTrnsctn', 'MrchntCd', 'MrcntDsc', 'GrndTtlOld', 'GrndTtlNew', 'GTDlySls', 'GTDscnt', 'GTDscntSNR', 'GTDscntPWD', 'GTDscntGPC', 'GTDscntVIP', 'GTDscntEMP', 'GTDscntREG', 'GTDscntOTH', 'GTRfnd', 'GTCncld', 'GTSlsVAT', 'GTVATSlsInclsv', 'GTVATSlsExclsv', 'OffclRcptBeg', 'OffclRcptEnd', 'GTCntDcmnt', 'GTCntCstmr', 'GTCntSnrCtzn', 'GTLclTax', 'GTSrvcChrg', 'GTSlsNonVat', 'GTRwGrss', 'GTLclTaxDly', 'WrksttnNmbr', 'GTPymntCSH', 'GTPymntCRD', 'GTPymntOTH', 'sdb_salesbymn');
		}
		return $tblSales;
	}

	function genUploadCSVQuery($Table, $Data, $TenantID, $MallID, $CSVType){
		$tblDiscount = tblDiscount($Table);
		$tblHourly = tblHourly($Table);
		$tblPayment = tblPayment($Table);
		$tblVoid = tblVoid($Table);
		$tblSales = tblSales($Table);
		$rowCSVData = json_decode($Data , true);
		if($CSVType == "Discount"){
			return "INSERT INTO ". $tblDiscount[0] ." SET mallid = '". $MallID ."', tenantID = '". $TenantID ."', ". $tblDiscount[1] ." = '". date('Y-m-d', strtotime($rowCSVData[0])) ."', ". $tblDiscount[2] ." = '". $rowCSVData[1] ."', ". $tblDiscount[3] ." = '". $rowCSVData[2] ."', ". $tblDiscount[4] ." = '". floatval($rowCSVData[3]) ."', ". $tblDiscount[5] ." = '". floatval($rowCSVData[4]) ."', ". $tblDiscount[6] ." = '". floatval($rowCSVData[5]) ."', ". $tblDiscount[7] ." = '". floatval($rowCSVData[6]) ."', ". $tblDiscount[8] . " = '". floatval($rowCSVData[7]) ."';";
		}else if($CSVType == "Hourly"){
			return "INSERT INTO ". $tblHourly[0] ." SET mallid = '". $MallID ."', tenantID = '". $TenantID ."', ". $tblHourly[1] ." = '". date('Y-m-d', strtotime($rowCSVData[0])) ."', ". $tblHourly[2] ." = '". $rowCSVData[1] ."', ". $tblHourly[3] ." = '". date('H:i:s', strtotime($rowCSVData[2])) ."', ". $tblHourly[4] ." = '". floatval($rowCSVData[3]) ."', ". $tblHourly[5] ." = '". floatval($rowCSVData[4]) ."', ". $tblHourly[6] ." = '". floatval($rowCSVData[5]) ."', ". $tblHourly[7] ." = '". floatval($rowCSVData[6]) ."';";
		}else if($CSVType == "Payment"){
			return "INSERT INTO ". $tblPayment[0] ." SET mallid = '". $MallID ."', tenantID = '". $TenantID ."', ". $tblPayment[1] ." = '". date('Y-m-d', strtotime($rowCSVData[0])) ."', ". $tblPayment[2] ." = '". $rowCSVData[1] ."', ". $tblPayment[3] ." = '". $rowCSVData[2] ."', ". $tblPayment[4] ." = '". $rowCSVData[3] ."', ". $tblPayment[5] ." = '". $rowCSVData[4] ."', ". $tblPayment[6] ." = '". $rowCSVData[5] ."', ". $tblPayment[7] ." = '". floatval($rowCSVData[6]) ."';";
		}else if($CSVType == "Void"){
			return "INSERT INTO ". $tblVoid[0] ." SET mallid = '". $MallID ."', tenantID = '". $TenantID ."', ". $tblVoid[1] ." = '". date('Y-m-d', strtotime($rowCSVData[0])) ."', ". $tblVoid[2] ." = '". $rowCSVData[1] ."', ". $tblVoid[3] ." = '". $rowCSVData[2] ."', ". $tblVoid[4] ." = '". $rowCSVData[3] ."', ". $tblVoid[5] ." = '". floatval($rowCSVData[4]) ."', ". $tblVoid[6] ." = '". floatval($rowCSVData[5]) ."', ". $tblVoid[7] ." = '". floatval($rowCSVData[6]) ."';";
		}else if($CSVType == "Sales"){
			return "INSERT INTO ". $tblSales[34] ." SET mallid = '". $MallID ."', tenantID = '". $TenantID ."', ". $tblSales[1] ." = '". date('Y-m-d', strtotime($rowCSVData[0])) ."', ". $tblSales[2] ." = '". $rowCSVData[1] ."', ". $tblSales[3] ." = '". $rowCSVData[2] ."', ". $tblSales[4] ." = '". floatval($rowCSVData[3]) ."', ". $tblSales[5] ." = '". floatval($rowCSVData[4]) ."', ". $tblSales[6] ." = '". floatval($rowCSVData[5]) ."', ". $tblSales[7] ." = '". floatval($rowCSVData[6]) ."', ". $tblSales[8] ." = '". floatval($rowCSVData[7]) ."', ". $tblSales[9] ." = '". floatval($rowCSVData[8]) ."', ". $tblSales[10] ." = '". floatval($rowCSVData[9]) ."', ". $tblSales[11] ." = '". floatval($rowCSVData[10]) ."', ". $tblSales[12] ." = '". floatval($rowCSVData[11]) ."', ". $tblSales[13] ." = '". floatval($rowCSVData[12]) ."', ". $tblSales[14] ." = '". floatval($rowCSVData[13]) ."', ". $tblSales[15] ." = '". floatval($rowCSVData[14]) ."', ". $tblSales[16] ." = '". floatval($rowCSVData[15]) ."', ". $tblSales[17] ." = '". floatval($rowCSVData[16]) ."', ". $tblSales[18] ." = '". floatval($rowCSVData[17]) ."', ". $tblSales[19] ." = '". floatval($rowCSVData[18]) ."', ". $tblSales[20] ." = '". floatval($rowCSVData[19]) ."', ". $tblSales[21] ." = '". floatval($rowCSVData[20]) ."', ". $tblSales[22] ." = '". floatval($rowCSVData[21]) ."', ". $tblSales[23] ." = '". floatval($rowCSVData[22]) ."', ". $tblSales[24] ." = '". floatval($rowCSVData[23]) ."', ". $tblSales[25] ." = '". floatval($rowCSVData[24]) ."', ". $tblSales[26] ." = '". floatval($rowCSVData[25]) ."', ". $tblSales[27] ." = '". floatval($rowCSVData[26]) ."', ". $tblSales[28] ." = '". floatval($rowCSVData[27]) ."', ". $tblSales[29] ." = '". floatval($rowCSVData[28]) ."', ". $tblSales[30] ." = '". $rowCSVData[29] ."', ". $tblSales[31] ." = '". floatval($rowCSVData[30]) ."', ". $tblSales[32] ." = '". floatval($rowCSVData[31]) ."', ". $tblSales[33] ." = '". floatval($rowCSVData[32]) ."';";
		}
	}

	function genSumSales($Table, $TenantID, $Date){
		$tblSales = tblSales($Table);
		$SumSales = mysql_fetch_array(mysql_query("SELECT mallid, tenantID, ". $tblSales[1] .", ". $tblSales[2] .", ". $tblSales[3] .", SUM(". $tblSales[4] ."), SUM(". $tblSales[5] ."), SUM(". $tblSales[6] ."), SUM(". $tblSales[7] ."), SUM(". $tblSales[8] ."), SUM(". $tblSales[9] ."), SUM(". $tblSales[10] ."), SUM(". $tblSales[11] ."), SUM(". $tblSales[12] ."), SUM(". $tblSales[13] ."), SUM(". $tblSales[14] ."), SUM(". $tblSales[15] ."), SUM(". $tblSales[16] ."), SUM(". $tblSales[17] ."), SUM(". $tblSales[18] ."), SUM(". $tblSales[19] ."), SUM(". $tblSales[20] ."), SUM(". $tblSales[21] ."), SUM(". $tblSales[22] ."), SUM(". $tblSales[23] ."), SUM(". $tblSales[24] ."), SUM(". $tblSales[25] ."), SUM(". $tblSales[26] ."), SUM(". $tblSales[27] ."), SUM(". $tblSales[28] ."), SUM(". $tblSales[29] ."), SUM(". $tblSales[30] ."), SUM(". $tblSales[31] ."), SUM(". $tblSales[32] ."), SUM(". $tblSales[33] .") FROM ". $tblSales[34] ." WHERE tenantID = '". $TenantID ."' AND ". $tblSales[1] ." = '". date('Y-m-d', strtotime($Date)) ."';"));

		$InsertSumSales = mysql_query("INSERT INTO ". $tblSales[0] ." SET mallid = '". $SumSales['mallid'] ."', tenantID = '". $SumSales['tenantID'] ."', ". $tblSales[1] ." = '". $SumSales[2] ."', ". $tblSales[2] ." = '". $SumSales[3] ."', ". $tblSales[3] ." = '". $SumSales[4] ."', ". $tblSales[4] ." = '". $SumSales[5] ."', ". $tblSales[5] ." = '". $SumSales[6] ."', ". $tblSales[6] ." = '". $SumSales[7] ."', ". $tblSales[7] ." = '". $SumSales[8] ."', ". $tblSales[8] ." = '". $SumSales[9] ."', ". $tblSales[9] ." = '". $SumSales[10] ."', ". $tblSales[10] ." = '". $SumSales[11] ."', ". $tblSales[11] ." = '". $SumSales[12] ."', ". $tblSales[12] ." = '". $SumSales[13] ."', ". $tblSales[13] ." = '". $SumSales[14] ."', ". $tblSales[14] ." = '". $SumSales[15] ."', ". $tblSales[15] ." = '". $SumSales[16] ."', ". $tblSales[16] ." = '". $SumSales[17] ."', ". $tblSales[17] ." = '". $SumSales[18] ."', ". $tblSales[18] ." = '". $SumSales[19] ."', ". $tblSales[19] ." = '". $SumSales[20] ."', ". $tblSales[20] ." = '". $SumSales[21] ."', ". $tblSales[21] ." = '". $SumSales[22] ."', ". $tblSales[22] ." = '". $SumSales[23] ."', ". $tblSales[23] ." = '". $SumSales[24] ."', ". $tblSales[24] ." = '". $SumSales[25] ."', ". $tblSales[25] ." = '". $SumSales[26] ."', ". $tblSales[26] ." = '". $SumSales[27] ."', ". $tblSales[27] ." = '". $SumSales[28] ."', ". $tblSales[28] ." = '". $SumSales[29] ."', ". $tblSales[29] ." = '". $SumSales[30] ."', ". $tblSales[30] ." = '". $SumSales[31] ."', ". $tblSales[31] ." = '". $SumSales[32] ."', ". $tblSales[32] ." = '". $SumSales[33] ."', ". $tblSales[33] ." = '". $SumSales[34] ."';");
		if($InsertSumSales == true){
			return 1;
		}
	}

	switch ($_POST['form']) {
		case 'FetchScript':
			set_include_path(get_include_path() . PATH_SEPARATOR . 'phpseclib');
			include('phpseclib/Net/SFTP.php');
			$UploadSetup = mysql_fetch_array(mysql_query("SELECT synctype, CSVSource, datefrom, dateto FROM db_settimeupload;", $connection));  //Get FM Setup
			$filepath = mysql_fetch_array(mysql_query("SELECT filepath, dbsetup, SFTPHost, SFTPPort FROM tblsys_setup;", $connection)); //Get System Setup
			$SystemSetupPath = str_replace("\\", "/", $filepath[0]);
			$tblPayment = tblPayment($filepath['dbsetup']);
			try{
				mysql_query("START transaction;");
				if($UploadSetup['synctype'] == '1'){ //Date Range
					$StartDate = date('Y-m-d', strtotime($UploadSetup['datefrom']));
					while( date('Y-m-d', strtotime($StartDate)) <= date('Y-m-d', strtotime($UploadSetup['dateto'])) ){
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

						$resTenant = mysql_query("SELECT mallID, merchant_code, TenantID, withPOS, SFTP_User, SFTP_Pass, unitID, tradename FROM tbltrans_tenants WHERE (Status = 'Active' OR Status = 'ForEviction' OR Status = 'ForRenewal') AND ustatus = 'Occupied' AND uploadingoffiles = '1' AND datefrom <= '". date('Y-m-d', strtotime($StartDate)) ."' AND dateto >= '". date('Y-m-d', strtotime($StartDate)) ."' ORDER BY tradename ASC;", $connection);
						while($rowTenant = mysql_fetch_array($resTenant)){

							$UploadStat = mysql_num_rows(mysql_query("SELECT id FROM db_syncfilestat WHERE reportDate = '". date('Y-m-d', strtotime($StartDate)) ."' AND tenantID = '". $rowTenant['TenantID'] ."';", $connection));
							if($UploadStat == 0){

								if($UploadSetup['CSVSource'] == "Local"){ //Local Storage
									if(!file_exists($SystemSetupPath . $rowTenant['mallID'] ."/". $rowTenant['merchant_code'])){
										mkdir($SystemSetupPath . $rowTenant['mallID'] ."/". $rowTenant['merchant_code'], 0777, true);
									}
									$FileName = $SystemSetupPath . $rowTenant['mallID'] ."/". $rowTenant['merchant_code'] ."/". $rowTenant['merchant_code'] . $Month . $Day . date('y', strtotime($StartDate));
									if(file_exists($FileName . "D.csv")){
										$DiscRowCount = 0;
										$OpenDiscountCSV = fopen($FileName . "D.csv", "r");
										$resDiscountCSV = fgetcsv($OpenDiscountCSV, 1000, ";"); //Remove if CSV file does not have column headings
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

									if(file_exists($FileName . "H.csv")){
										$HourlyRowCount = 0;
										$OpenHourlyCSV = fopen($FileName . "H.csv", "r");
										$resHourlyCSV = fgetcsv($OpenHourlyCSV, 1000, ";"); //Remove if CSV file does not have column headings
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

									if(file_exists($FileName . "P.csv")){
										$PaymentRowCount = 0;
										$OpenPaymentCSV = fopen($FileName . "P.csv", "r");
										$resPaymentCSV = fgetcsv($OpenPaymentCSV, 1000, ";"); //Remove if CSV file does not have column headings
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
											$AccreditedPType = mysql_fetch_array(mysql_query("SELECT PaymentType FROM tblaccreditation WHERE TenantID = '". $rowTenant['TenantID'] ."';", $connection));
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

									if(file_exists($FileName . "R.csv")){
										$VoidRowCount = 0;
										$OpenVoidCSV = fopen($FileName . "R.csv", "r");
										$resVoidCSV = fgetcsv($OpenVoidCSV, 1000, ";"); //Remove if CSV file does not have column headings
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

									if(file_exists($FileName . "S.csv")){
										$SalesCSVRowCount = 0;
										$SalesRowCount = 0;
										$OpenSalesCSV = fopen($FileName . "S.csv", "r");
										$resSalesCSV = fgetcsv($OpenSalesCSV, 1000, ";"); //Remove if CSV file does not have column headings
										while(($rowSalesCSV = fgetcsv($OpenSalesCSV)) != FALSE){
											if($rowSalesCSV[0] != "" || $rowSalesCSV[1] != "" || $rowSalesCSV[2] != "" || $rowSalesCSV[3] != "" || $rowSalesCSV[4] != "" || $rowSalesCSV[5] != "" || $rowSalesCSV[6] != "" || $rowSalesCSV[7] != "" || $rowSalesCSV[8] != "" || $rowSalesCSV[9] != "" || $rowSalesCSV[10] != "" || $rowSalesCSV[11] != "" || $rowSalesCSV[12] != "" || $rowSalesCSV[13] != "" || $rowSalesCSV[14] != "" || $rowSalesCSV[15] != "" || $rowSalesCSV[16] != "" || $rowSalesCSV[17] != "" || $rowSalesCSV[18] != "" || $rowSalesCSV[19] != "" || $rowSalesCSV[20] != "" || $rowSalesCSV[21] != "" || $rowSalesCSV[22] != "" || $rowSalesCSV[23] != "" || $rowSalesCSV[24] != "" || $rowSalesCSV[25] != "" || $rowSalesCSV[26] != "" || $rowSalesCSV[27] != "" || $rowSalesCSV[28] != "" || $rowSalesCSV[29] != "" || $rowSalesCSV[30] != "" || $rowSalesCSV[31] != "" || $rowSalesCSV[32] != ""){

												if(date('Y-m-d', strtotime($rowSalesCSV[0])) == date('Y-m-d', strtotime($StartDate)) && $rowSalesCSV[1] == $rowTenant['merchant_code']){
													$SalesCSVRowCount++;
												}

												if(date('Y-m-d', strtotime($rowSalesCSV[0])) != date('Y-m-d', strtotime($StartDate)) && $rowSalesCSV[1] != $rowTenant['merchant_code']){
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

									$rowID = mysql_fetch_array(mysql_query("SELECT refno FROM db_syncfilestat ORDER BY id DESC LIMIT 1;", $connection));
									if($rowID[0] == ""){
										$refno = str_pad(1, 10, 0, STR_PAD_LEFT);
									}else{
										$refno = str_pad( $rowID[0] + 1, 10, 0, STR_PAD_LEFT);
									}

									$resSyncStat = mysql_query("INSERT INTO db_syncfilestat SET tenantID = '". $rowTenant['TenantID'] ."', sales = '". $SalesVal ."', discount = '". $DiscountVal ."', void_refund = '". $VoidVal ."', salesperhour = '". $HourlyVal ."', paymenttype = '". $PaymentVal ."', reportDate = '".date('Y-m-d', strtotime($StartDate)) ."', countSync = '". $CSVStats ."', refno = '". $refno ."';", $connection);
									if($resSyncStat == 1){

										if($CSVStats == 5){
											$FloorPlanStat = 1;
										}else{
											$FloorPlanStat = 0;
										}

										$resUnitStatLogs = mysql_query("UPDATE tblunit_statuslogs SET txtStat = '". $FloorPlanStat ."' WHERE tenantID = '". $rowTenant['TenantID'] ."' AND unitID = '". $rowTenant['unitID'] ."' AND xdate = '". date('Y-m-d', strtotime($StartDate)) ."';", $connection);
										if($resUnitStatLogs == true){
										}
									}
								}else{ //SFTP Storage
									$FileName = str_replace("\\", "/", getcwd()) ."/". $rowTenant['merchant_code'] . $Month . $Day . date('y', strtotime($StartDate));
									$FileName2 = $rowTenant['merchant_code'] . $Month . $Day . date('y', strtotime($StartDate));
									$sftp = new Net_SFTP($filepath['SFTPHost']);
								    if($sftp->login(trim($rowTenant['SFTP_User']), trim($rowTenant['SFTP_Pass']))){
										if($sftp->file_exists($FileName2 . "D.csv")){
											$sftp->get($FileName2 . "D.csv", $FileName2 . "D.csv");
											$DiscRowCount = 0;
											$OpenDiscountCSV = fopen($FileName . "D.csv", "r");
											$resDiscountCSV = fgetcsv($OpenDiscountCSV, 1000, ";"); //Remove if CSV file does not have column headings
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
											$resHourlyCSV = fgetcsv($OpenHourlyCSV, 1000, ";"); //Remove if CSV file does not have column headings
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
											$resPaymentCSV = fgetcsv($OpenPaymentCSV, 1000, ";"); //Remove if CSV file does not have column headings
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
											$resVoidCSV = fgetcsv($OpenVoidCSV, 1000, ";"); //Remove if CSV file does not have column headings
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
											$resSalesCSV = fgetcsv($OpenSalesCSV, 1000, ";"); //Remove if CSV file does not have column headings
											while(($rowSalesCSV = fgetcsv($OpenSalesCSV)) != FALSE){
												if($rowSalesCSV[0] != "" || $rowSalesCSV[1] != "" || $rowSalesCSV[2] != "" || $rowSalesCSV[3] != "" || $rowSalesCSV[4] != "" || $rowSalesCSV[5] != "" || $rowSalesCSV[6] != "" || $rowSalesCSV[7] != "" || $rowSalesCSV[8] != "" || $rowSalesCSV[9] != "" || $rowSalesCSV[10] != "" || $rowSalesCSV[11] != "" || $rowSalesCSV[12] != "" || $rowSalesCSV[13] != "" || $rowSalesCSV[14] != "" || $rowSalesCSV[15] != "" || $rowSalesCSV[16] != "" || $rowSalesCSV[17] != "" || $rowSalesCSV[18] != "" || $rowSalesCSV[19] != "" || $rowSalesCSV[20] != "" || $rowSalesCSV[21] != "" || $rowSalesCSV[22] != "" || $rowSalesCSV[23] != "" || $rowSalesCSV[24] != "" || $rowSalesCSV[25] != "" || $rowSalesCSV[26] != "" || $rowSalesCSV[27] != "" || $rowSalesCSV[28] != "" || $rowSalesCSV[29] != "" || $rowSalesCSV[30] != "" || $rowSalesCSV[31] != "" || $rowSalesCSV[32] != ""){

													if(date('Y-m-d', strtotime($rowSalesCSV[0])) == date('Y-m-d', strtotime($StartDate)) && $rowSalesCSV[1] == $rowTenant['merchant_code']){
														$SalesCSVRowCount++; //GET CORRECT ROW COUNT
													}

													if(date('Y-m-d', strtotime($rowSalesCSV[0])) != date('Y-m-d', strtotime($StartDate)) && $rowSalesCSV[1] != $rowTenant['merchant_code']){
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

									$rowID = mysql_fetch_array(mysql_query("SELECT refno FROM db_syncfilestat ORDER BY id DESC LIMIT 1;", $connection));
									if($rowID[0] == ""){
										$refno = str_pad(1, 10, 0, STR_PAD_LEFT);
									}else{
										$refno = str_pad( $rowID[0] + 1, 10, 0, STR_PAD_LEFT);
									}

									$resSyncStat = mysql_query("INSERT INTO db_syncfilestat SET tenantID = '". $rowTenant['TenantID'] ."', sales = '". $SalesVal ."', discount = '". $DiscountVal ."', void_refund = '". $VoidVal ."', salesperhour = '". $HourlyVal ."', paymenttype = '". $PaymentVal ."', reportDate = '".date('Y-m-d', strtotime($StartDate)) ."', countSync = '". $CSVStats ."', refno = '". $refno ."';", $connection);
									if($resSyncStat == 1){
										array_map('unlink', glob(str_replace("\\", "/", getcwd())."/*.csv"));
										if($CSVStats == 5){
											$FloorPlanStat = 1;
										}else{
											$FloorPlanStat = 0;
										}

										$resUnitStatLogs = mysql_query("UPDATE tblunit_statuslogs SET txtStat = '". $FloorPlanStat ."' WHERE tenantID = '". $rowTenant['TenantID'] ."' AND unitID = '". $rowTenant['unitID'] ."' AND xdate = '". date('Y-m-d', strtotime($StartDate)) ."';", $connection);
									}
								}

							}

						}
						$StartDate = date('Y-m-d', strtotime($StartDate.'+1 day'));
					}
				}else{ //Date Today
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
					$resTenant = mysql_query("SELECT mallID, merchant_code, TenantID, withPOS, SFTP_User, SFTP_Pass, unitID, tradename FROM tbltrans_tenants WHERE (Status = 'Active' OR Status = 'ForEviction' OR Status = 'ForRenewal') AND ustatus = 'Occupied' AND uploadingoffiles = '1' AND datefrom <= '". date('Y-m-d', strtotime(getsysdate())) ."' AND dateto >= '". date('Y-m-d', strtotime(getsysdate())) ."' ORDER BY tradename ASC;", $connection);
					while($rowTenant = mysql_fetch_array($resTenant)){

						$FileName = $SystemSetupPath . $rowTenant['mallID'] ."/". $rowTenant['merchant_code'] ."/". $rowTenant['merchant_code'] . $Month . $Day . date('y', strtotime(getsysdate()));

						$UploadStat = mysql_num_rows(mysql_query("SELECT id FROM db_syncfilestat WHERE reportDate = '". date('Y-m-d', strtotime(getsysdate())) ."' AND tenantID = '". $rowTenant['TenantID'] ."';", $connection));
						if($UploadStat == 0){

							if($UploadSetup['CSVSource'] == "Local"){ //Local Storage
								if(!file_exists($SystemSetupPath . $rowTenant['mallID'] ."/". $rowTenant['merchant_code'])){
									mkdir($SystemSetupPath . $rowTenant['mallID'] ."/". $rowTenant['merchant_code'], 0777, true);
								}

								if(file_exists($FileName . "D.csv")){
									$DiscRowCount = 0;
									$OpenDiscountCSV = fopen($FileName . "D.csv", "r");
									$resDiscountCSV = fgetcsv($OpenDiscountCSV, 1000, ";"); //Remove if CSV file does not have column headings
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

								if(file_exists($FileName . "H.csv")){
									$HourlyRowCount = 0;
									$OpenHourlyCSV = fopen($FileName . "H.csv", "r");
									$resHourlyCSV = fgetcsv($OpenHourlyCSV, 1000, ";"); //Remove if CSV file does not have column headings
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

								if(file_exists($FileName . "P.csv")){
									$PaymentRowCount = 0;
									$OpenPaymentCSV = fopen($FileName . "P.csv", "r");
									$resPaymentCSV = fgetcsv($OpenPaymentCSV, 1000, ";"); //Remove if CSV file does not have column headings
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

								if(file_exists($FileName . "R.csv")){
									$VoidRowCount = 0;
									$OpenVoidCSV = fopen($FileName . "R.csv", "r");
									$resVoidCSV = fgetcsv($OpenVoidCSV, 1000, ";"); //Remove if CSV file does not have column headings
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

								if(file_exists($FileName . "S.csv")){
									$SalesCSVRowCount = 0;
									$SalesRowCount = 0;
									$OpenSalesCSV = fopen($FileName . "S.csv", "r");
									$resSalesCSV = fgetcsv($OpenSalesCSV, 1000, ";"); //Remove if CSV file does not have column headings
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

								$rowID = mysql_fetch_array(mysql_query("SELECT refno FROM db_syncfilestat ORDER BY id DESC LIMIT 1;", $connection));
								if($rowID[0] == ""){
									$refno = str_pad(1, 10, 0, STR_PAD_LEFT);
								}else{
									$refno = str_pad($rowID[0] + 1, 10, 0, STR_PAD_LEFT);
								}

								$resSyncStat = mysql_query("INSERT INTO db_syncfilestat SET tenantID = '". $rowTenant['TenantID'] ."', sales = '". $SalesVal ."', discount = '". $DiscountVal ."', void_refund = '". $VoidVal ."', salesperhour = '". $HourlyVal ."', paymenttype = '". $PaymentVal ."', reportDate = '".date('Y-m-d', strtotime(getsysdate())) ."', countSync = '". $CSVStats ."', refno = '". $refno ."';", $connection);
								if($resSyncStat == 1){

									if($CSVStats == 5){
										$FloorPlanStat = 1;
									}else{
										$FloorPlanStat = 0;
									}

									$resUnitStatLogs = mysql_query("UPDATE tblunit_statuslogs SET txtStat = '". $FloorPlanStat ."' WHERE tenantID = '". $rowTenant['TenantID'] ."' AND unitID = '". $rowTenant['unitID'] ."' AND xdate = '". date('Y-m-d', strtotime(getsysdate())) ."';", $connection);
								}		
							}else{ //SFTP Storage
								$FileName = str_replace("\\", "/", getcwd()) ."/". $rowTenant['merchant_code'] . $Month . $Day . date('y', strtotime(getsysdate()));
								$FileName2 = $rowTenant['merchant_code'] . $Month . $Day . date('y', strtotime(getsysdate()));
								$sftp = new Net_SFTP($filepath['SFTPHost']);
							    if($sftp->login(trim($rowTenant['SFTP_User']), trim($rowTenant['SFTP_Pass']))){
									if($sftp->file_exists($FileName2 . "D.csv")){
										$sftp->get($FileName2 . "D.csv", $FileName2 . "D.csv");
										$DiscRowCount = 0;
										$OpenDiscountCSV = fopen($FileName . "D.csv", "r");
										$resDiscountCSV = fgetcsv($OpenDiscountCSV, 1000, ";"); //Remove if CSV file does not have column headings
										while(($resDiscountCSV = fgetcsv($OpenDiscountCSV)) != FALSE){
											if($resDiscountCSV[0] != "" || $resDiscountCSV[1] != "" || $resDiscountCSV[2] != "" || $resDiscountCSV[3] != "" || $resDiscountCSV[4] != "" || $resDiscountCSV[5] != "" || $resDiscountCSV[6] != "" || $resDiscountCSV[7] != ""){

												if(date('Y-m-d', strtotime($resDiscountCSV[0])) != date('Y-m-d', strtotime(getsysdate())) || $resDiscountCSV[1] != $rowTenant['merchant_code']){  
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
										$resHourlyCSV = fgetcsv($OpenHourlyCSV, 1000, ";"); //Remove if CSV file does not have column headings
										while(($resHourlyCSV = fgetcsv($OpenHourlyCSV)) != FALSE) {
											if($resHourlyCSV[0] != "" || $resHourlyCSV[1] != "" || $resHourlyCSV[2] != "" || $resHourlyCSV[3] != "" || $resHourlyCSV[4] != "" || $resHourlyCSV[5] != "" || $resHourlyCSV[6] != ""){

												if($resHourlyCSV[1] != $rowTenant['merchant_code']){
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
										$resPaymentCSV = fgetcsv($OpenPaymentCSV, 1000, ";"); //Remove if CSV file does not have column headings
										while(($resPaymentCSV = fgetcsv($OpenPaymentCSV)) != FALSE){
											if($resPaymentCSV[0] != "" || $resPaymentCSV[1] != "" || $resPaymentCSV[2] != "" || $resPaymentCSV[3] != "" || $resPaymentCSV[4] != "" || $resPaymentCSV[5] != "" || $resPaymentCSV[6] != ""){

												if(date('Y-m-d', strtotime($resPaymentCSV[0])) != date('Y-m-d', strtotime(getsysdate())) || $resPaymentCSV[1] != $rowTenant['merchant_code']){  
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
										$resVoidCSV = fgetcsv($OpenVoidCSV, 1000, ";"); //Remove if CSV file does not have column headings
										while(($resVoidCSV = fgetcsv($OpenVoidCSV)) != FALSE){
											if($resVoidCSV[0] != "" || $resVoidCSV[1] != "" || $resVoidCSV[2] != "" || $resVoidCSV[3] != "" || $resVoidCSV[4] != "" || $resVoidCSV[5] != "" || $resVoidCSV[6] != "" || $resVoidCSV[7] != ""){

												if(date('Y-m-d', strtotime($resVoidCSV[0])) != date('Y-m-d', strtotime(getsysdate())) || $resVoidCSV[1] != $rowTenant['merchant_code']){
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
										$resSalesCSV = fgetcsv($OpenSalesCSV, 1000, ";"); //Remove if CSV file does not have column headings
										while(($resSalesCSV = fgetcsv($OpenSalesCSV)) != FALSE){
										if($resSalesCSV[0] != "" || $resSalesCSV[1] != "" || $resSalesCSV[2] != "" || $resSalesCSV[3] != "" || $resSalesCSV[4] != "" || $resSalesCSV[5] != "" || $resSalesCSV[6] != "" || $resSalesCSV[7] != "" || $resSalesCSV[8] != "" || $resSalesCSV[9] != "" || $resSalesCSV[10] != "" || $resSalesCSV[11] != "" || $resSalesCSV[12] != "" || $resSalesCSV[13] != "" || $resSalesCSV[14] != "" || $resSalesCSV[15] != "" || $resSalesCSV[16] != "" || $resSalesCSV[17] != "" || $resSalesCSV[18] != "" || $resSalesCSV[19] != "" || $resSalesCSV[20] != "" || $resSalesCSV[21] != "" || $resSalesCSV[22] != "" || $resSalesCSV[23] != "" || $resSalesCSV[24] != "" || $resSalesCSV[25] != "" || $resSalesCSV[26] != "" || $resSalesCSV[27] != "" || $resSalesCSV[28] != "" || $resSalesCSV[29] != "" || $resSalesCSV[30] != "" || $resSalesCSV[31] != "" || $resSalesCSV[32] != ""){

												if(date('Y-m-d', strtotime($resSalesCSV[0])) == date('Y-m-d', strtotime(getsysdate())) && $resSalesCSV[1] == $rowTenant['merchant_code']){
													$SalesCSVRowCount++; //GET CORRECT ROW COUNT
												}

												if(date('Y-m-d', strtotime($resSalesCSV[0])) != date('Y-m-d', strtotime(getsysdate())) && $resSalesCSV[1] != $rowTenant['merchant_code']){
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

								$rowID = mysql_fetch_array(mysql_query("SELECT refno FROM db_syncfilestat ORDER BY id DESC LIMIT 1;", $connection));
								if($rowID[0] == ""){
									$refno = str_pad(1, 10, 0, STR_PAD_LEFT);
								}else{
									$refno = str_pad($rowID[0] + 1, 10, 0, STR_PAD_LEFT);
								}

								$resSyncStat = mysql_query("INSERT INTO db_syncfilestat SET tenantID = '". $rowTenant['TenantID'] ."', sales = '". $SalesVal ."', discount = '". $DiscountVal ."', void_refund = '". $VoidVal ."', salesperhour = '". $HourlyVal ."', paymenttype = '". $PaymentVal ."', reportDate = '".date('Y-m-d', strtotime(getsysdate())) ."', countSync = '". $CSVStats ."', refno = '". $refno ."';", $connection);
								if($resSyncStat == 1){
									array_map('unlink', glob(str_replace("\\", "/", getcwd())."/*.csv"));
									if($CSVStats == 5){
										$FloorPlanStat = 1;
									}else{
										$FloorPlanStat = 0;
									}

									$resUnitStatLogs = mysql_query("UPDATE tblunit_statuslogs SET txtStat = '". $FloorPlanStat ."' WHERE tenantID = '". $rowTenant['TenantID'] ."' AND unitID = '". $rowTenant['unitID'] ."' AND xdate = '". date('Y-m-d', strtotime(getsysdate())) ."';", $connection);
								}		
							}

						}

					}
				}
				mysql_query("COMMIT;", $connection);
			}catch(Exception $e){
				echo $e;
				mysql_query("ROLLBACK;", $connection);
			}
		break;

		case 'clearCSV':
			array_map('unlink', glob(str_replace("\\", "/", getcwd())."/*.csv"));
		break;

		case 'txtSysHeader':
			$header = mysql_fetch_array(mysql_query("SELECT softwaretype, corporatename, dbsetup FROM tblsys_setup", $connection));
			if($header[0] == "0"){
				if($header[2] == "1"){
					echo "<i class='fa'><img src='../assets/images/ai1logo.png' style='width: 25px; height: 25px;'></i>&nbsp;". $header[1] ." - Tenant Management System";
				}else{
					echo "<i class='fa'><img src='../assets/images/ai1logo.png' style='width: 25px; height: 25px;'></i>&nbsp;". $header[1] ." - Mall Management System";
				}
			}else if($header[0] == "1"){
				echo "<i class='fa'><img src='../assets/images/ai1logo.png' style='width: 25px; height: 25px;'></i>&nbsp;". $header[1] ." - Property Management System";
			}else if($header[0] == "2"){
				echo "<i class='fa'><img src='../assets/images/ai1logo.png' style='width: 25px; height: 25px;'></i>&nbsp;". $header[1] ." - Building Management System";
			}else if($header[0] == "3"){
				echo "<i class='fa'><img src='../assets/images/ai1logo.png' style='width: 25px; height: 25px;'></i>&nbsp;". $header[1] ." - Palengke Management System";
			}else if($header[0] == "4"){
				echo "<i class='fa'><img src='../assets/images/ai1logo.png' style='width: 25px; height: 25px;'></i>&nbsp;". $header[1] ." - Cemetery Management System";
			}
		break;

		case 'txtTabTitle':
			$title = mysql_fetch_array(mysql_query("SELECT softwaretype, dbsetup FROM tblsys_setup", $connection));
			if($title[0] == "0"){
				if($title[1] == "1"){
					echo "Tenant Management System";
				}else{
					echo "Mall Management System";
				}
			}else if($title[0] == "1"){
				echo "Property Leasing Management Application";
			}else if($title[0] == "2"){
				echo "Building Management System";
			}else if($title[0] == "3"){
				echo "Palengke Management System";
			}else if($title[0] == "4"){
				echo "Cemetery Management System";
			}
		break;

		case 'getsysdate':
			$sys = mysql_fetch_array(mysql_query("SELECT eoddate FROM tbltrans_eod ORDER BY eoddate DESC LIMIT 0,1"));
			if($sys[0] == "") {
				echo "System Date: ".date("l, F d, Y");
			}else{
				echo "System Date: ".date("l, F d, Y", strtotime($sys[0]));
			}
		break;

		case 'showLogs':
			$UploadSetup = mysql_fetch_array(mysql_query("SELECT synctype, CSVSource, datefrom, dateto FROM db_settimeupload;", $connection));  //Get FM Setup
			if($UploadSetup['synctype'] == '1'){
				$DateFilter = " AND a.reportDate BETWEEN '". date('Y-m-d', strtotime($UploadSetup['datefrom'])) ."' AND '". date('Y-m-d', strtotime($UploadSetup['dateto'])) ."' ";
			}else{
				$DateFilter = " AND a.reportDate = '". date('Y-m-d', strtotime(getsysdate())) ."' ";
			}

			$resFileMonitoring = mysql_query("SELECT a.reportDate, b.mallID, b.tradename, a.sales, a.discount, a.void_refund, a.salesperhour, a.paymenttype FROM db_syncfilestat as a INNER JOIN tbltrans_tenants as b ON a.tenantID = b.TenantID WHERE b.uploadingoffiles = '1' AND (b.Status = 'Active' OR b.Status = 'ForEviction' OR b.Status = 'ForRenewal') ". $DateFilter ." ORDER BY a.reportDate DESC, b.tradename ASC;", $connection);
			while($rowFileMonitoring = mysql_fetch_array($resFileMonitoring)){
				$rowMallName = mysql_fetch_array(mysql_query("SELECT mallname FROM tblref_mall WHERE mallid = '". $rowFileMonitoring['mallID'] ."';", $connection));

				if($rowFileMonitoring['discount'] == 3){
					$Discount = "<i class='center fa fa-times-circle blue bigger-120'></i>";
				}else if($rowFileMonitoring['discount'] == 2){
					$Discount = "<i class='center fa fa-times-circle orange bigger-120'></i>";
				}else if($rowFileMonitoring['discount'] == 1){
					$Discount = "<i class='center fa fa-check-circle green bigger-120'></i>";
				}else{
					$Discount = "<i class='center fa fa-times-circle red bigger-120'></i>";
				}

				if($rowFileMonitoring['salesperhour'] == 3){
					$HourlySales = "<i class='center fa fa-times-circle blue bigger-120'></i>";
				}else if($rowFileMonitoring['salesperhour'] == 2){
					$HourlySales = "<i class='center fa fa-times-circle orange bigger-120'></i>";
				}else if($rowFileMonitoring['salesperhour'] == 1){
					$HourlySales = "<i class='center fa fa-check-circle green bigger-120'></i>";
				}else{
					$HourlySales = "<i class='center fa fa-times-circle red bigger-120'></i>";
				}

				if($rowFileMonitoring['void_refund'] == 3){
					$Void = "<i class='center fa fa-times-circle blue bigger-120'></i>";
				}else if($rowFileMonitoring['void_refund'] == 2){
					$Void = "<i class='center fa fa-times-circle orange bigger-120'></i>";
				}else if($rowFileMonitoring['void_refund'] == 1){
					$Void = "<i class='center fa fa-check-circle green bigger-120'></i>";
				}else{
					$Void = "<i class='center fa fa-times-circle red bigger-120'></i>";
				}

				if($rowFileMonitoring['paymenttype'] == 3){
					$PaymentType = "<i class='center fa fa-times-circle blue bigger-120'></i>";
				}else if($rowFileMonitoring['paymenttype'] == 2){
					$PaymentType = "<i class='center fa fa-times-circle orange bigger-120'></i>";
				}else if($rowFileMonitoring['paymenttype'] == 1){
					$PaymentType = "<i class='center fa fa-check-circle green bigger-120'></i>";
				}else{
					$PaymentType = "<i class='center fa fa-times-circle red bigger-120'></i>";
				}

				if($rowFileMonitoring['sales'] == 3){
					$Sales = "<i class='center fa fa-times-circle blue bigger-120'></i>";
				}else if($rowFileMonitoring['sales'] == 2){
					$Sales = "<i class='center fa fa-times-circle orange bigger-120'></i>";
				}else if($rowFileMonitoring['sales'] == 1){
					$Sales = "<i class='center fa fa-check-circle green bigger-120'></i>";
				}else{
					$Sales = "<i class='center fa fa-times-circle red bigger-120'></i>";
				}

				echo 	"<tr>
							<td>". date('m/d/Y', strtotime($rowFileMonitoring['reportDate'])) ."</td>
							<td>". $rowMallName['mallname'] ."</td>
							<td>". $rowFileMonitoring['tradename'] ."</td>
							<td style='text-align: center;'>". $Discount ."</td>
							<td style='text-align: center;'>". $HourlySales ."</td>
							<td style='text-align: center;'>". $Void ."</td>
							<td style='text-align: center;'>". $PaymentType ."</td>
							<td style='text-align: center;'>". $Sales ."</td>
						</tr>";
				
			}
		break;

		case 'ExportReport':
			if($_POST['type'] == "Print"){
				$template = mysql_fetch_array(mysql_query("SELECT template FROM tblsys_setup"));
				$row = mysql_fetch_array(mysql_query("SELECT corporatename, address, contactnumber, emailaddress, corporatelogo from tblsys_setup;", $connection));
		      	$path = "../Mall_Attachments/SysLogo";

		      	if($row['corporatelogo'] == ""){
	                $image = "../assets/images/noimage5.png";
	            }else{
	                if(!file_exists("../../Mall_Attachments/SysLogo". $row['corporatelogo'])){ 
						$image = "../assets/images/noimage5.png";
					}else{
						$image = "../../Mall_Attachments/SysLogo". $row['corporatelogo'];
					}
	            }

	            if($template[0] == "1"){
					echo "<tr>
					      	<td width='130px;padding:0px !important;'><img src='".$image."' style='height: 130px; width: 150px !important;margin: 10px;'></td>
					      	<td style='padding-top:0px;'>
					      		<p style='padding: 0px; display: block;margin:0px;'><h1>".$row[0]."</h1></p>
					      		<p style='padding: 0px; display: block;margin:0px;'>".$row[1]."</p>
					      		<p style='padding: 0px; display: block;margin:0px;'>".$row[2]."</p>
					      		<p style='padding: 0px; display: block;margin:0px;'>".$row[3]."</p>
					      	</td>
					      </tr>";
				}else{
					echo "<tr>
						  	<td colspan='3' align='center'><img src='".$image."' style='height: 130px; width: 150px !important;margin: 10px;'></td>
						  </tr>
						  <tr>
						  	<td colspan='3' align='center'>
						  		<p style='padding: 0px; display: block;margin:0px;'><h1>".$row[0]."</h1></p>
						  		<p style='padding: 0px; display: block;margin:0px;'>".$row[1]."</p>
						  		<p style='padding: 0px; display: block;margin:0px;'>".$row[2]."</p>
						  		<p style='padding: 0px; display: block;margin:0px;'>".$row[3]."</p>
						  	</td>
						  </tr>";
				}
				echo "|";
				$resFileMonitoring = mysql_query("SELECT a.reportDate, b.mallID, b.tradename, a.sales, a.discount, a.void_refund, a.salesperhour, a.paymenttype FROM db_syncfilestat as a INNER JOIN tbltrans_tenants as b ON a.tenantID = b.TenantID WHERE b.uploadingoffiles = '1' AND (b.Status = 'Active' OR b.Status = 'ForEviction' OR b.Status = 'ForRenewal') ". $DateFilter ." ORDER BY a.reportDate DESC, b.tradename ASC;", $connection);
				while($rowFileMonitoring = mysql_fetch_array($resFileMonitoring)){
					$rowMallName = mysql_fetch_array(mysql_query("SELECT mallname FROM tblref_mall WHERE mallid = '". $rowFileMonitoring['mallID'] ."';", $connection));

					if($rowFileMonitoring['discount'] == 3){
						$Discount = "<i class='center fa fa-times-circle bigger-120' style='color: #478FCA;'></i>";
					}else if($rowFileMonitoring['discount'] == 2){
						$Discount = "<i class='center fa fa-times-circle bigger-120' style='color: #FF892A;'></i>";
					}else if($rowFileMonitoring['discount'] == 1){
						$Discount = "<i class='center fa fa-check-circle bigger-120' style='color: #69AA46;'></i>";
					}else{
						$Discount = "<i class='center fa fa-times-circle bigger-120' style='color: #DD5A43;'></i>";
					}

					if($rowFileMonitoring['salesperhour'] == 3){
						$HourlySales = "<i class='center fa fa-times-circle bigger-120' style='color: #478FCA;'></i>";
					}else if($rowFileMonitoring['salesperhour'] == 2){
						$HourlySales = "<i class='center fa fa-times-circle bigger-120' style='color: #FF892A;'></i>";
					}else if($rowFileMonitoring['salesperhour'] == 1){
						$HourlySales = "<i class='center fa fa-check-circle bigger-120' style='color: #69AA46;'></i>";
					}else{
						$HourlySales = "<i class='center fa fa-times-circle bigger-120' style='color: #DD5A43;'></i>";
					}

					if($rowFileMonitoring['void_refund'] == 3){
						$Void = "<i class='center fa fa-times-circle bigger-120' style='color: #478FCA;'></i>";
					}else if($rowFileMonitoring['void_refund'] == 2){
						$Void = "<i class='center fa fa-times-circle bigger-120' style='color: #FF892A;'></i>";
					}else if($rowFileMonitoring['void_refund'] == 1){
						$Void = "<i class='center fa fa-check-circle bigger-120' style='color: #69AA46;'></i>";
					}else{
						$Void = "<i class='center fa fa-times-circle bigger-120' style='color: #DD5A43;'></i>";
					}

					if($rowFileMonitoring['paymenttype'] == 3){
						$PaymentType = "<i class='center fa fa-times-circle bigger-120' style='color: #478FCA;'></i>";
					}else if($rowFileMonitoring['paymenttype'] == 2){
						$PaymentType = "<i class='center fa fa-times-circle bigger-120' style='color: #FF892A;'></i>";
					}else if($rowFileMonitoring['paymenttype'] == 1){
						$PaymentType = "<i class='center fa fa-check-circle bigger-120' style='color: #69AA46;'></i>";
					}else{
						$PaymentType = "<i class='center fa fa-times-circle bigger-120' style='color: #DD5A43;'></i>";
					}

					if($rowFileMonitoring['sales'] == 3){
						$Sales = "<i class='center fa fa-times-circle bigger-120' style='color: #478FCA;'></i>";
					}else if($rowFileMonitoring['sales'] == 2){
						$Sales = "<i class='center fa fa-times-circle bigger-120' style='color: #FF892A;'></i>";
					}else if($rowFileMonitoring['sales'] == 1){
						$Sales = "<i class='center fa fa-check-circle bigger-120' style='color: #69AA46;'></i>";
					}else{
						$Sales = "<i class='center fa fa-times-circle bigger-120' style='color: #DD5A43;'></i>";
					}

					echo 	"<tr>
								<td>". date('m/d/Y', strtotime($rowFileMonitoring['reportDate'])) ."</td>
								<td>". $rowMallName['mallname'] ."</td>
								<td>". $rowFileMonitoring['tradename'] ."</td>
								<td style='text-align: center;'>". $Discount ."</td>
								<td style='text-align: center;'>". $HourlySales ."</td>
								<td style='text-align: center;'>". $Void ."</td>
								<td style='text-align: center;'>". $PaymentType ."</td>
								<td style='text-align: center;'>". $Sales ."</td>
							</tr>";
					
				}
			}else{
				$resFileMonitoring = mysql_query("SELECT a.reportDate, b.mallID, b.tradename, a.sales, a.discount, a.void_refund, a.salesperhour, a.paymenttype FROM db_syncfilestat as a INNER JOIN tbltrans_tenants as b ON a.tenantID = b.TenantID WHERE b.uploadingoffiles = '1' AND (b.Status = 'Active' OR b.Status = 'ForEviction' OR b.Status = 'ForRenewal') ". $DateFilter ." ORDER BY a.reportDate DESC, b.tradename ASC;", $connection);
				while($rowFileMonitoring = mysql_fetch_array($resFileMonitoring)){
					$rowMallName = mysql_fetch_array(mysql_query("SELECT mallname FROM tblref_mall WHERE mallid = '". $rowFileMonitoring['mallID'] ."';", $connection));

					if($rowFileMonitoring['discount'] == 3){
						$Discount = "Access Denied";
					}else if($rowFileMonitoring['discount'] == 2){
						$Discount = "File Not Found";
					}else if($rowFileMonitoring['discount'] == 1){
						$Discount = "Success";
					}else{
						$Discount = "Failed";
					}

					if($rowFileMonitoring['salesperhour'] == 3){
						$HourlySales = "Access Denied";
					}else if($rowFileMonitoring['salesperhour'] == 2){
						$HourlySales = "File Not Found";
					}else if($rowFileMonitoring['salesperhour'] == 1){
						$HourlySales = "Success";
					}else{
						$HourlySales = "Failed";
					}

					if($rowFileMonitoring['void_refund'] == 3){
						$Void = "Access Denied";
					}else if($rowFileMonitoring['void_refund'] == 2){
						$Void = "File Not Found";
					}else if($rowFileMonitoring['void_refund'] == 1){
						$Void = "Success";
					}else{
						$Void = "Failed";
					}

					if($rowFileMonitoring['paymenttype'] == 3){
						$PaymentType = "Access Denied";
					}else if($rowFileMonitoring['paymenttype'] == 2){
						$PaymentType = "File Not Found";
					}else if($rowFileMonitoring['paymenttype'] == 1){
						$PaymentType = "Success";
					}else{
						$PaymentType = "Failed";
					}

					if($rowFileMonitoring['sales'] == 3){
						$Sales = "Access Denied";
					}else if($rowFileMonitoring['sales'] == 2){
						$Sales = "File Not Found";
					}else if($rowFileMonitoring['sales'] == 1){
						$Sales = "Success";
					}else{
						$Sales = "Failed";
					}

					echo	"<tr>
								<td>". date('m/d/Y', strtotime($rowFileMonitoring['reportDate'])) ."</td>
								<td>". $rowMallName['mallname'] ."</td>
								<td>". str_replace(",", "", $rowFileMonitoring['tradename']) ."</td>
								<td style='text-align: center;'>". $Discount ."</td>
								<td style='text-align: center;'>". $HourlySales ."</td>
								<td style='text-align: center;'>". $Void ."</td>
								<td style='text-align: center;'>". $PaymentType ."</td>
								<td style='text-align: center;'>". $Sales ."</td>
							</tr>";					
				}
			}
		break;

		case 'AutoConsolidate':
			$StartDate = date('Y-m-d', strtotime(date('Y', strtotime(getsysdate())) .'-'. date('m', strtotime(getsysdate())) .'-01 -1 month'));
			$LastDay = date('t', strtotime($StartDate));
			$EndDate = date('Y-m-d', strtotime(date('Y', strtotime($StartDate)) .'-'. date('m', strtotime($StartDate)) .'-'. $LastDay));

			$TenantInfo = "SELECT a.Contract_NumSAP, a.tradename, a.Company_CodeSAP, SUM(b.fnmGTDlySls) FROM tbltrans_tenants AS a LEFT JOIN fdb_sales AS b ON a.TenantID = b.tenantid WHERE b.fdtTrnsctn BETWEEN '". $StartDate ."' AND '". $EndDate ."' GROUP BY a.TenantID;";
			$resTenantInfo = mysql_query($TenantInfo, $connection);
			$data = "fvcCntrctNo,fvcCntrctNm,fvcCmpny,fdtSlsRng1,fdtSlsRng2,fnmGTMnthlySlsWthOutVat\r\n";
			while($rowTenantInfo = mysql_fetch_array($resTenantInfo)){
				$data .= $rowTenantInfo[0].",".str_replace(",", "", $rowTenantInfo[1]).",".$rowTenantInfo[2].",".date('m/d/Y', strtotime($StartDate)).",".date('m/d/Y', strtotime($EndDate)).",".$rowTenantInfo[3]."\r\n";
			}
			$filepath = mysql_fetch_array(mysql_query("SELECT filepath FROM tblsys_setup", $connection));
			$syspath = str_replace("\\", "/", $filepath[0]);
			if (!file_exists($syspath)){
				mkdir($syspath, 0777, true);
			}
			$file = $syspath."BBWM_Sales_".date('mdY', strtotime($StartDate))."_".date('mdY', strtotime($EndDate)).".csv";
			chmod($file, 0777);
			file_put_contents($file, $data);

			$CreateLogs = mysql_query("INSERT INTO tblref_consologs SET GenMonth = '". date('m', strtotime(getsysdate())) ."', GenYear = '". date('Y', strtotime(getsysdate())) ."', GenUser = 'Auto', GenType = '1';", $connection);

			echo date('F d, Y', strtotime($StartDate)) . "|" . date('F d, Y', strtotime($EndDate)) . "|" . $syspath."BBWM_Sales_".date('mdY', strtotime($StartDate))."_".date('mdY', strtotime($EndDate)).".csv";
		break;
	}
?>