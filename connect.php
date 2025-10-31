<?php
	set_time_limit(0);
	date_default_timezone_set("Asia/Manila");
	$mydate = date("Y-m-d");
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));
	$connection = mysql_connect($_SESSION['GS-MMS'], 'gates', 'g@tes2009');
	// $connection = mysql_connect($_SESSION['GS-MMS'], 'gates', 'G@+35_@!1_p@$$');
	if (!$connection) { 
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db("gates_smm2", $connection) or die("Error on database: " . mysql_error());
	mysql_query("SET NAMES 'utf8'");
	mysql_query("SET CHARACTER SET utf8");
	mysql_query("SET COLLATION_CONNECTION = 'utf8_unicode_ci'");


	function CreateLogsArray($type, $arrHeader, $arrFields, $arrValue, $TableName, $ConditionalField, $ConditionBasis){
		$Log = "";
		if($type == "INSERT"){
			for ($i = 0; $i <= COUNT($arrHeader); $i++) { 
				if($arrHeader[$i] != '' && $arrHeader[$i] != undefined){
					$Log .= $arrHeader[$i] . " : " . $arrValue[$i] . "|";
				}
			}
		}else if($type == "UPDATE"){
			for ($i = 0; $i <= COUNT($arrHeader); $i++) { 
				if($arrHeader[$i] != '' && $arrHeader[$i] != undefined){
					$getPreviousData = mysql_fetch_array(mysql_query("SELECT ". $arrFields[$i] ." FROM ". $TableName ." WHERE ". $ConditionalField ." = '". $ConditionBasis ."';"));
					if($TableName == 'tbluser' && $arrHeader[$i] == 'Group Access'){
						$PrevData = getValueofThis('groupid', 'groupname', 'tblref_groupaccess', $getPreviousData[0]);
						$CurrentData = $arrValue[$i];
					}else if($TableName == 'tbluser' && $arrHeader[$i] == 'User Type'){
						// $PrevData = $getPreviousData[0];
						$CurrentData = $arrValue[$i];
					}else if($TableName == 'tbluser' && $arrHeader[$i] == 'Mall Access'){
						$PrevData = BreakThisDown('mallid', 'mallname', 'tblref_mall', $getPreviousData[0], "@");
						$CurrentData = $arrValue[$i];
					}else{
						$PrevData = $getPreviousData[0];
						$CurrentData = $arrValue[$i];
					}
					if($PrevData != $CurrentData){
						$Log .= $arrHeader[$i] . " : From ". $PrevData ." To ". $CurrentData ."|";
					}
				}
			}
		}else if($type == "DELETE"){
			$Log = "";
			for ($i = 0; $i <= COUNT($arrHeader); $i++) {
				$getPreviousData = mysql_fetch_array(mysql_query("SELECT ". $arrFields[$i] ." FROM ". $TableName ." WHERE ". $ConditionalField ." = '". $ConditionBasis ."';"));
				if($getPreviousData[0] != ''){
					$Log .= $arrHeader[$i] . " : " . $getPreviousData[0] . "|";
				}
			}
		}
		return $Log;
	}

	function BreakThisDown($ConditionalField, $TableField, $TableName, $ForBreakdown, $Connector){
		$Breakdown = "";
		$arr = explode($Connector, $ForBreakdown);
		for($a = 0; $a <= COUNT($arr)-2; $a++){
			if($arr[$a] != '' && $arr[$a] != undefined){
				$Breakdown .= mysql_fetch_array(mysql_query("SELECT ". $TableField ." FROM ". $TableName ." WHERE ". $ConditionalField ." = '". $arr[$a] ."';"))[0]."<br/>&emsp;&emsp;";
			}
		}
		return "<br/>&emsp;&emsp;".$Breakdown;
	}

	function getValueofThis($ConditionalField ,$TableField ,$TableName ,$ValueofThis){
		$DBValue = "";
		if($ValueofThis != '' && $ValueofThis != undefined){
			$DBValue .= mysql_fetch_array(mysql_query("SELECT ". $TableField ." FROM ". $TableName ." WHERE ". $ConditionalField ." = '". $ValueofThis ."';"))[0];
		}
		return $DBValue;
	}

	// Added Ronaldo 10222018 else if($type == "UPDATE"){
	function createXinfo($type ,$arrHeader ,$arrFields ,$arrValue ,$table ,$id ,$multiple){
		$Log = "";
		if($type == 'INSERT' || $type == 'UPDATE'){
			foreach($arrValue as $key => $value){
				if($value != '' && $value != undefined){
					$arr = array_filter(explode('|' , $value));
					$isNewLine = "";
					if(COUNT($arr) > 1){
						$isNewLine = "<br/>&emsp;&emsp;";
					}
					$Log .= $arrHeader[$key] . " : ". $isNewLine ." " . implode('<br/>&emsp;&emsp;', $arr) . "|";
				}
			}
		}else if($type == 'DELETE'){
			$checkPrev = "SELECT ". implode(',' , $arrFields) ." FROM ". $table ." WHERE id = '". $id ."';";
			$result = mysql_fetch_array(mysql_query($checkPrev));
			foreach($arrHeader as $key => $value){
				$Log .= $arrHeader[$key] . " : ". $result[$key] ."|";
			}
		}
		return $Log;
	}

	function fncBreakdownArray($arr){
		$Breakdown = "";
		$var = explode("|", $arr);
		for ($i=0; $i <= COUNT($var)-2; $i++) { 
			$Breakdown .= $var[$i] . "<br/>&emsp;&emsp;&emsp;&emsp;";
		}
		return $Breakdown;
	}

	function create_logs_per_transaction($remarks, $module, $xinfo, $xattach, $action, $mainID){
       	$name = mysql_fetch_array(mysql_query("SELECT firstname, middlename, lastname FROM tbluser WHERE userid = '". $_SESSION['MMS-UserID'] ."';"));

       	if($_SESSION['MMS-UserID'] == "GatessoftCorp"){
       		$username = "Gatessoft Corp";
       	}else if($_SESSION['MMS-UserID'] == "Superuser"){
       		$username = "Superuser";
       	}else{
       		$username = $name["lastname"].", ".$name["firstname"]." ".$name["middlename"];
       	}

		$logID = createidno("LOG", "tbllogs_per_trans", "logID");
		$sql_logs = "INSERT INTO tbllogs_per_trans SET logID = '". $logID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date("Y-m-d") ."', mytime = '". date("H:i:s") ."', remarks = '". $username . " " . $remarks ."', module = '". $module ."', xinfo = '". mysql_real_escape_string($xinfo) ."', xattach = '". $xattach ."', xaction = '". $action ."', mainID = '". $mainID ."';";
		$result_logs = mysql_query($sql_logs);
		return 1;
	}

	function getThisRealValue($tablecode ,$tabledesc ,$table ,$data){
		$print = "";
		foreach(explode('|',$data) as $key => $value){
			if($value != ''){
				$sql = "SELECT ". $tabledesc ." FROM ". $table ." WHERE ". $tablecode ." = '". $value ."';";
				$res = mysql_query($sql);
				$print .= mysql_fetch_array($res)[0]."|";
			}
		}
		return $print;
	}

	function getThisRealValue2($tablecode ,$tabledesc ,$table ,$data){
		$print = "";
		foreach(explode('@',$data) as $key => $value){
			if($value != ''){
				$sql = "SELECT ". $tabledesc ." FROM ". $table ." WHERE ". $tablecode ." = '". $value ."';";
				$res = mysql_query($sql);
				$print .= mysql_fetch_array($res)[0]."|";
			}
		}
		return $print;
	}

	function separateConDates($data){
		$arr = array();
		foreach(explode('#' , $data) as $key => $value){
			if($value != ''){
				array_push( $arr , explode( 'P' , $value )[0] . " - P" . explode( 'P' , $value )[1] );
			}
		}
		$response = "";
		if(count($arr) > 1){
			$response .= "<br/>&emsp;&emsp;";
		}
		$response .= implode('<br/>&emsp;&emsp;' , $arr);
		return $response;
	}
	// END Added Ronaldo 10222018

	function getID($Field, $TableName, $Condition){
		$MyID = mysql_fetch_array(mysql_query("SELECT id FROM ". $TableName ." WHERE ". $Field ." = '". $Condition ."';"));
		return $MyID[0];
	}

	function addleadingzero($num){
		$maxid = "";
		$str = strlen($num);
		if($str == 1){ 
			$maxid = "000000" . $num; 
		}else if($str == 2){ 
			$maxid = "00000" . $num; 
		}else if($str == 3){ 
			$maxid = "0000" . $num; 
		}else if($str == 4){ 
			$maxid = "000" . $num; 
		}else if($str == 5){ 
			$maxid = "00" . $num; 
		}else if($str == 6){ 
			$maxid = "0" . $num; 
		}else{ 
			$maxid = $num; 
		}
		return $maxid;
	}
	
	function createidno($tagname, $table, $tblid){
		$myid = "";
		$maxno = mysql_fetch_array(mysql_query("SELECT lastid FROM refrecordid WHERE tablename = '". $table ."' ORDER BY id ASC;"));
		$tblid = mysql_fetch_array(mysql_query("SELECT ". $tblid ." FROM ". $table ." ORDER BY ID DESC LIMIT 0, 1;"));
		if($tagname == ""){
			if($maxno[0] == ""){
				if($tblid[0] == ""){
					$myid = addleadingzero("1");
				}else{
					$myid = addleadingzero($tblid[0]);
				}
				$result = mysql_query("INSERT INTO refrecordid(tablename, lastid, dateadded) VALUES('". $table ."', '". $myid ."', '". date("Y-m-d") ."')");
			}else{
				if(is_numeric($maxno[0])){
					$myid = addleadingzero($maxno[0]+1);
					$result = mysql_query("UPDATE refrecordid SET lastid = '". $myid ."', dateadded = '". date("Y-m-d") ."' WHERE tablename = '". $table ."'");
				}else{
					$myid = addleadingzero("1");
					$result = mysql_query("INSERT INTO refrecordid(tablename, lastid, dateadded) VALUES('". $table ."', '". $myid ."', '". date("Y-m-d") ."')");
				}
			}
		}else{
			if($maxno[0] == ""){
				if($tblid[0] == ""){
					$myid = $tagname . "-" . addleadingzero("1");
				}else{
					if(is_numeric($tblid[0])){
						$myarr = explode("-", $tblid[0]);
						$myid = $tagname . "-" . addleadingzero($myarr[1]);
					}else{
						$myid = $tagname . "-" . addleadingzero("1");
					}
				}
				$result = mysql_query("INSERT INTO refrecordid(tablename, lastid, dateadded) VALUES('". $table ."', '". $myid ."', '". date("Y-m-d") ."')");
			}else{
				$arr = explode("-", $maxno[0]);
				if(is_numeric(end($arr))){
					$myid = $tagname . "-" . addleadingzero(end($arr)+1);
					$result = mysql_query("UPDATE refrecordid SET lastid = '". $myid ."', dateadded = '". date("Y-m-d") ."' WHERE tablename = '". $table ."';");
				}else{
					$myid = $tagname . "-" . addleadingzero("1");
					$result = mysql_query("INSERT INTO refrecordid(tablename, lastid, dateadded) VALUES('". $table ."', '". $myid ."', '". date("Y-m-d") ."')");
				}
			}
		}
		return $myid;
	}

	function createidno_permall($tagname, $table, $tblid){
		$myid = "";
		$getmaxno = "SELECT lastid FROM refrecordid_mall WHERE tablename = '" . $table . "' AND mallid = '". $_SESSION['MMS-Designation'] ."' ORDER BY id DESC";
		$maxno = mysql_fetch_array(mysql_query($getmaxno));
		$gettblid = "SELECT ". $tblid ." FROM ". $table ." ORDER BY ID DESC LIMIT 0, 1";
		$tblid = mysql_fetch_array(mysql_query($gettblid));
		if($tagname == ""){
			if($maxno[0] == ""){
				if($tblid[0] == ""){ 
					$myid = addleadingzero("1"); 
				}else{ 
					$myid = addleadingzero($tblid[0]); 
				}
				$sql = "INSERT INTO refrecordid_mall(tablename, lastid, dateadded, mallid) VALUES('". $table ."', '". $myid ."', '". date("Y-m-d") ."', '". $_SESSION['MMS-Designation'] ."')";
				$result = mysql_query($sql);
			}else{
				if(is_numeric($maxno[0])){
					$myid = addleadingzero($maxno[0]+1);
					$sql = "UPDATE refrecordid_mall SET lastid = '". $myid ."', dateadded = '". date("Y-m-d") ."' WHERE tablename = '". $table ."' AND mallid = '". $_SESSION['MMS-Designation'] ."'";
					$result = mysql_query($sql);
				}else{
					$myid = addleadingzero("1");
					$sql = "INSERT INTO refrecordid_mall(tablename, lastid, dateadded, mallid) VALUES('". $table ."', '". $myid ."', '". date("Y-m-d") ."', '". $_SESSION['MMS-Designation'] ."')";
					$result = mysql_query($sql);
				}
			}
		}else{
			if($maxno[0] == ""){
				if($tblid[0] == ""){ 
					$myid = $tagname . "-" . addleadingzero("1"); 
				}else{
					if(is_numeric($tblid[0])){
						$myarr = explode("-", $tblid[0]);
						$myid = $tagname . "-" . addleadingzero($myarr[1]);
					}else{ 
						$myid = $tagname . "-" . addleadingzero("1"); 
					}
				}
				$sql = "INSERT INTO refrecordid_mall(tablename, lastid, dateadded, mallid) VALUES('". $table ."', '". $myid ."', '". date("Y-m-d") ."', '". $_SESSION['MMS-Designation'] ."')";
				$result = mysql_query($sql);
			}else{
				$arr = explode("-", $maxno[0]);
				if(is_numeric(end($arr))){
					$myid = $tagname . "-" . addleadingzero(end($arr)+1);
					$sql = "UPDATE refrecordid_mall SET lastid = '". $myid ."', dateadded = '". date("Y-m-d") ."' WHERE tablename = '". $table ."' AND mallid = '". $_SESSION['MMS-Designation'] ."'";
					$result = mysql_query($sql);
				}else{
					$myid = $tagname . "-" . addleadingzero("1");
					$sql = "INSERT INTO refrecordid_mall(tablename, lastid, dateadded, mallid) VALUES('". $table ."', '". $myid ."', '". date("Y-m-d") ."', '". $_SESSION['MMS-Designation'] ."')";
					$result = mysql_query($sql);
				}
			}
		}
		return $myid;
	}

	function createctrlno($tagname, $table, $tblid){
		$myid = "";
		$getmaxno = "SELECT lastid FROM refrecordid WHERE tablename = '" . $table . "'";
		$maxno = mysql_fetch_array(mysql_query($getmaxno));
		$gettblid = "select " . $tblid . " from " . $table . " ORDER BY ID DESC LIMIT 0, 1";
		$tblid = mysql_fetch_array(mysql_query($gettblid));
		if($tagname == ""){
			if($maxno[0] == ""){
				if($tblid[0] == ""){ 
					$myid = addleadingzeroctrl("1"); 
				}else{ 
					$myid = addleadingzeroctrl($tblid[0]); 
				}
				$sql = "INSERT INTO refrecordid(tablename, lastid, dateadded) VALUES('" . $table . "', '" . $myid . "', '" . date("Y-m-d") . "')";
				$result = mysql_query($sql);
			}else{
				if(is_numeric($maxno[0])){
					$myid = addleadingzeroctrl($maxno[0]+1);
					$sql = "UPDATE refrecordid SET lastid = '" . $myid . "', dateadded = '" . date("Y-m-d") . "' where tablename = '" . $table . "'";
					$result = mysql_query($sql);
				}else{
					$myid = addleadingzeroctrl("1");
					$sql = "INSERT INTO refrecordid(tablename, lastid, dateadded) VALUES('" . $table . "', '" . $myid . "', '" . date("Y-m-d") . "')";
					$result = mysql_query($sql);
				}
			}
		}else{
			if($maxno[0] == ""){
				if($tblid[0] == ""){ 
					$myid = $tagname . "-" . addleadingzeroctrl("1"); 
				}else{
					if(is_numeric($tblid[0])){
						$myarr = explode("-", $tblid[0]);
						$myid = $tagname . "-" . addleadingzeroctrl($myarr[1]);
					}else{ 
						$myid = $tagname . "-" . addleadingzeroctrl("1"); 
					}
				}
				$sql = "INSERT INTO refrecordid(tablename, lastid, dateadded) VALUES('" . $table . "', '" . $myid . "', '" . date("Y-m-d") . "')";
				$result = mysql_query($sql);
			}else{
				$arr = explode("-", $maxno[0]);
				if(is_numeric(end($arr))){
					$myid = $tagname . "-" . addleadingzeroctrl(end($arr)+1);
					$sql = "UPDATE refrecordid SET lastid = '" . $myid . "', dateadded = '" . date("Y-m-d") . "' where tablename = '" . $table . "'";
					$result = mysql_query($sql);
				}else{
					$myid = $tagname . "-" . addleadingzeroctrl("1");
					$sql = "INSERT INTO refrecordid(tablename, lastid, dateadded) VALUES('" . $table . "', '" . $myid . "', '" . date("Y-m-d") . "')";
					$result = mysql_query($sql);
				}
			}
		}
		return $myid;
	}

	function addleadingzeroctrl($num){
		$maxid = "";
		$str = strlen($num);
		if($str == 1){ 
			$maxid = "000" . $num; 
		}else if($str == 2){ 
			$maxid = "00" . $num; 
		}else if($str == 3){ 
			$maxid = "0" . $num; 
		}else{ 
			$maxid = $num; 
		}
		return $maxid;
	}

	function getusername(){
       	$name = mysql_fetch_array(mysql_query("SELECT firstname, middlename, lastname FROM tbluser WHERE userid = '".$_SESSION['MMS-UserID']."';"));
       	if($_SESSION['MMS-UserID'] == "GatessoftCorp"){
			$UN = "GatessoftCorp";
		}else if($_SESSION['MMS-UserID'] == "Superuser"){
			$UN = "Superuser";
		}else{
			$UN = $name["lastname"].", ".$name["firstname"]." ".$name["middlename"];
		}

       	return $UN;
	}

	function getrentvattype($mall){
		$sql = "SELECT vat_rent_prcnt, vatable_rent, vat_rent_type, penalty_type, vat_penalty_prcnt, vatable_penalty, vat_penalty_type, penalty_amount, penalty_percent, MinElectric, MinWater, MinGas FROM mall_setup WHERE mall_id = '" . $mall . "'";
       	$res = mysql_query($sql);
       	$charge = mysql_fetch_array($res);

       	if($charge["vatable_rent"] == "yes"){
       		if($charge["vat_rent_type"] == "inc"){
       			$theader = "VAT ".$charge["vat_rent_prcnt"]."% (Inc)";
       		}else{
       			$theader = "VAT ".$charge["vat_rent_prcnt"]."% (Exc)";
       		}
       	}else{
       		$theader = "VAT";
       	}
       	
       	return $charge["vat_rent_prcnt"] . "|" . $charge["vatable_rent"] . "|" . $charge["vat_rent_type"] . "|" . $theader . "|" . $charge["penalty_type"]. "|" .$charge["vat_penalty_prcnt"] . "|" . $charge["vatable_penalty"]. "|" .$charge["vat_penalty_type"] . "|" . $charge["penalty_amount"] . "|" . $charge["penalty_percent"] . "|" . $charge["MinElectric"] . "|" . $charge["MinWater"] . "|" . $charge["MinGas"];
	}

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

	function SysLeaseSetup($field){
		$LeaseSys = mysql_fetch_array(mysql_query("SELECT ". $field ." FROM tblsys_setup;"));
		return $LeaseSys[0];
	}

	function getUtilRate($type, $mallid, $xdate){
		$UtilRate = mysql_fetch_array(mysql_query("SELECT UtilRate, AdminFee, AdminFeeType, EffDate FROM tblref_UtilRate WHERE type = '". $type ."' AND mallid = '". $mallid ."' AND EffDate <= '". $xdate ."' ORDER BY EffDate DESC LIMIT 1;"));
		if($UtilRate['AdminFeeType'] == 0){
			$AdminFee = (floatval($UtilRate[0]) * (floatval($UtilRate['AdminFee']) / 100)) + floatval($UtilRate[0]);
		}else{
			$AdminFee = floatval($UtilRate[0]) + floatval($UtilRate['AdminFee']);
		}
		return $AdminFee;
	}

	function getMallAccess($Field, $Conjunction){
		if($_SESSION['MMS-UserID'] == "GatessoftCorp" || $_SESSION['MMS-UserID'] == 'Superuser'){
			$resgetAllMall = mysql_query("SELECT mallid FROM tblref_mall WHERE mallstat = '1';");
			while($rowgetAllMall = mysql_fetch_array($resgetAllMall)){
				$MallAccessList .= "'" . $rowgetAllMall['mallid'] . "'" . ",";
			}
			return $Conjunction ." ". $Field ." IN (". substr(trim($MallAccessList), 0, -1) .")";
		}else{
			return $Conjunction ." ". $Field ." = '". $_SESSION['MMS-Designation'] ."'";
		}
	}

	function forAccIntegration($NewCode, $NewDescription, $OldCode, $Type){
		if($Type == "INSERT"){
			$res = mysql_query("INSERT INTO tblref_hardcodedid SET HC_ID = '". $NewCode ."', HC_DESC = '". $NewDescription ."';");
		}else if($Type == "UPDATE"){
			$res = mysql_query("UPDATE tblref_hardcodedid SET HC_ID = '". $NewCode ."', HC_DESC = '". $NewDescription ."' WHERE HC_ID = '". $OldCode ."';");
		}else if($Type == "DELETE"){
			$res = mysql_query("DELETE FROM tblref_hardcodedid WHERE HC_ID = '". $NewCode ."';");
		}
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

	function numberTowords($num){ 
		$ones = array(1 => "one", 2 => "two", 3 => "three", 4 => "four", 5 => "five", 6 => "six", 7 => "seven", 8 => "eight", 9 => "nine", 10 => "ten", 11 => "eleven", 12 => "twelve", 13 => "thirteen", 14 => "fourteen", 15 => "fifteen", 16 => "sixteen", 17 => "seventeen", 18 => "eighteen", 19 => "nineteen" ); 
		$tens = array(1 => "ten",2 => "twenty", 3 => "thirty", 4 => "forty", 5 => "fifty", 6 => "sixty", 7 => "seventy", 8 => "eighty", 9 => "ninety"); 
		$hundreds = array("hundred", "thousand", "million", "billion", "trillion", "quadrillion" ); //limit t quadrillion 
		$num = number_format($num,2,".",","); 
		$num_arr = explode(".",$num); 
		$wholenum = $num_arr[0]; 
		$decnum = $num_arr[1]; 
		$whole_arr = array_reverse(explode(",",$wholenum)); 
		krsort($whole_arr); 
		$rettxt = ""; 
		foreach($whole_arr as $key => $i){ 
			if($i < 20){ 
				$rettxt .= $ones[$i]; 
			}else if($i < 100){ 
				$rettxt .= $tens[substr($i,0,1)]; 
				$rettxt .= " ".$ones[substr($i,1,1)]; 
			}else{ 
				$rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0]; 
				$rettxt .= " ".$tens[substr($i,1,1)]; 
				$rettxt .= " ".$ones[substr($i,2,1)]; 
			} 
			if($key > 0){ 
				$rettxt .= " ".$hundreds[$key]." "; 
			} 
		} 
		if($decnum > 0){ 
			$rettxt .= " and "; 
			if($decnum < 20){ 
				$rettxt .= $ones[$decnum]; 
			}else if($decnum < 100){ 
				$rettxt .= $tens[substr($decnum,0,1)]; 
				$rettxt .= " ".$ones[substr($decnum,1,1)]; 
			} 
		} 
	return $rettxt; 
	} 
?>
