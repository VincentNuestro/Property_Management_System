<?php
include("../mms_database.php");
$response = array();		
$TenantID = $_POST["TenantID"];
	//$TenantID = "TENANT-0000065";
	//$_SESSION['TenantID']
	
	$sql = "SELECT datefrom, dateto, unitID, tradename, merchant_code, CompanyID, tenanttype, revpercent, MallID, owner_lastname, owner_firstname, owner_midname, noofmonths, noofdays, monthly_dues, assoc_dues, daily_dues, inqID FROM tbltrans_tenants WHERE TenantID = '". $TenantID ."'; ";
	$res = mysql_query($sql, $connection);
	$TenantInfo = mysql_fetch_array($res);

	$sql2 = " SELECT Company, automerchant_code FROM tbltrans_company WHERE CompanyID = '". $TenantInfo['CompanyID'] ."'; ";
	$res2 = mysql_query($sql2, $connection);
	$CompanyName = mysql_fetch_array($res2);

	$sql3 = " SELECT filename, tradeID FROM tbltrans_tradename WHERE companyID = '".$TenantInfo['CompanyID']."'; ";
	$res3 = mysql_query($sql3, $connection);
	$TradeName = mysql_fetch_array($res3);

	$sql4 = " SELECT mallname FROM tblref_mall WHERE mallid = '". $TenantInfo['MallID'] ."'; ";
	$res4 = mysql_query($sql4, $connection);
	$MallName = mysql_fetch_array($res4);

	$sql5 = " SELECT unitname, floorid, wingid, classid, depid, catid, typeofbusiness, area, sqmunitsetup, totalamountunitsetup, pricepersqmunitsetup FROM tblref_unit WHERE unitid = '". $TenantInfo['unitID'] ."'; ";
	$res5 = mysql_query($sql5, $connection);
	$UnitInfo = mysql_fetch_array($res5);

	$sql6 = " SELECT wing FROM tblref_wing WHERE wingID = '". $UnitInfo['wingid'] ."'; ";
	$res6 = mysql_query($sql6, $connection);
	$WingName = mysql_fetch_array($res6);

	$sql7 = " SELECT floor FROM tblref_floorsetup WHERE floorid = '". $UnitInfo['floorid'] ."'; ";
	$res7 = mysql_query($sql7, $connection);
	$FloorName = mysql_fetch_array($res7);

	$sql8 = "SELECT classification FROM tblref_merchandise_class WHERE classificationID = '". $UnitInfo['classid'] ."';";
	$res8 = mysql_query($sql8, $connection);
	$Classification = mysql_fetch_array($res8);

	$sql9 = " SELECT department FROM tblref_merchandise_depa WHERE departmentID = '". $UnitInfo['depid'] ."'; ";
	$res9 = mysql_query($sql9, $connection);
	$Department = mysql_fetch_array($res9);

	$sql10 = " SELECT category FROM tblref_merchandisedep_cat WHERE categoryID = '". $UnitInfo['catid'] ."'; ";
	$res10 = mysql_query($sql10, $connection);
	$Category = mysql_fetch_array($res10);

	$sql11 = " SELECT escalation_rate, year_start, year_basis FROM tbltrans_proposal WHERE inquiryID = '". $TenantInfo['inqID'] ."' AND stats = '1'; ";
	$res11 = mysql_query($sql11, $connection);
	$ProposalInfo = mysql_fetch_array($res11);

	if($TradeName['filename'] == ""){
		$Image = "assets/images/ai1logo.png";
	}else{
	if(!file_exists("../server/company/". $TenantInfo['CompanyID'] ."/trades/". $TradeName['tradeID'] ."/". $TradeName['filename'])){ 
		$Image = "assets/images/ai1logo.png";
	}else{
		$Image = "server/company/". $TenantInfo['CompanyID'] ."/trades/". $TradeName['tradeID'] ."/". $TradeName['filename'];
	}
	}

	if($TenantInfo['tenanttype'] == "Rent | Rev"){
		$BillingType = "Rent + Rev" . " (" . $TenantInfo['revpercent'] . "%)";
	}else if($TenantInfo['tenanttype'] == "Rent or Share"){
		$BillingType = $TenantInfo['tenanttype'] . " (" . $TenantInfo['revpercent'] . "%)";
	}else{
		$BillingType = $TenantInfo['tenanttype'];
	}

	if($TenantInfo['owner_midname'] == ""){
		$ContactPerson = $TenantInfo['owner_firstname'] . " " . $TenantInfo['owner_lastname'];
	}else{
		$ContactPerson = $TenantInfo['owner_firstname'] . " " . $TenantInfo['owner_midname'][0] . " " . $TenantInfo['owner_lastname'];
	}

	if(SysLeaseSetup('floorandunitmeasurement') == 'Area'){
		$UnitArea = $UnitInfo['area'];
	}else{  
		$UnitArea = $UnitInfo['sqmunitsetup'];
	}

	if(SysLeaseSetup('automerchantcode') == "1"){
		$MerchantCode = $TenantInfo['merchant_code']."-".$CompanyName['automerchant_code'];
	}else{
		$MerchantCode = $TenantInfo['merchant_code'];
	}

	$TotalMonthly = (floatval($TenantInfo['monthly_dues']) + floatval($TenantInfo['assoc_dues'])) * floatval($TenantInfo['noofmonths']);
	$TotalDaily =  floatval($TenantInfo['daily_dues']) * floatval($TenantInfo['noofdays']);
	$GrandTotal = $TotalMonthly + $TotalDaily;

/*
	echo $Image . "</br>" . 
	$TenantInfo['tradename'] . "</br>" . 
	$MerchantCode . "</br>" . 
	$CompanyName['Company'] . "</br>" . 
	$ContactPerson . "</br>" . 
	$BillingType . "</br>" . 
	date('m/d/Y', strtotime($TenantInfo['datefrom'])) . "</br>" . 
	date('m/d/Y', strtotime($TenantInfo['dateto'])) . "</br>" . 
	$MallName['mallname'] . "</br>" . 
	$WingName['wing'] . "</br>" . 
	$FloorName['floor'] . "</br>" . 
	$UnitInfo['unitname'] . "</br>" . 
	$UnitInfo['typeofbusiness'] . "</br>" . 
	$Classification['classification'] . "</br>" . 
	$Department['department'] . "</br>" .
	$Category['category'] . "</br>" . 
	number_format($UnitArea, 0, ".", ",") . " SQM</br>" .
	number_format($UnitInfo['pricepersqmunitsetup'], 2, ".", ",") . "</br>" . 
	number_format($UnitInfo['totalamountunitsetup'], 2, ".", ",") . "</br>" . 
	floatval($TenantInfo['noofdays']) . "</br>" . 
	floatval($TenantInfo['noofmonths']) . "</br>" . 
	number_format($TenantInfo['monthly_dues'], 2, ".", ",") . "</br>" . 
	number_format($TenantInfo['assoc_dues'], 2, ".", ",") . "</br>" . 
	number_format($GrandTotal, 2, ".", ",") . "</br>" . 
	$ProposalInfo['escalation_rate'] . "%</br>" . 
	$ProposalInfo['year_start'] . "</br>" . 
	$ProposalInfo['year_basis'];
*///classid

	$response["Image"] = isset($Image) ? $Image : "";
	$response["TenantInfo"] = isset($TenantInfo['tradename']) ? $TenantInfo['tradename']: "";
	$response["MerchantCode"] = isset($MerchantCode) ? $MerchantCode : "";
	$response["CompanyName"] =  isset($CompanyName['Company']) ? $CompanyName['Company'] : "";
	$response["ContactPerson"] = isset( $ContactPerson) ?  $ContactPerson: "";
	$response["BillingType"] = isset($BillingType) ? $BillingType : "";
	$response["datefrom"] = $TenantInfo['datefrom'];
	$response["dateto"] = $TenantInfo['dateto'];
	$response["MallName"] = isset($MallName['mallname']) ? $MallName['mallname'] : "" ;
	$response["WingName"] = isset($WingName['wing']) ? $WingName['wing'] : "";
	$response["FloorName"] = isset($FloorName['floor']) ? $FloorName['floor'] : "";
	$response["unitname"] = isset($UnitInfo['unitname']) ? $UnitInfo['unitname'] : "";
	$response["typeofbusiness"] = isset($UnitInfo['typeofbusiness']) ? $UnitInfo['typeofbusiness'] : "";
	$response["classification"] = isset($Classification['classification']) ? $Classification['classification'] : "";
	$response["department"] = isset($Department['department']) ? $Department['department'] : "";
	$response["category"] = isset($Category['category']) ? $Category['category'] : "";
	$response["UnitArea"] = number_format($UnitArea, 0, ".", ",") . " SQM";
	$response["pricepersqmunitsetup"] = number_format($UnitInfo['pricepersqmunitsetup'], 2, ".", ",");
	$response["totalamountunitsetup"] = number_format($UnitInfo['totalamountunitsetup'], 2, ".", ",");
	$response["noofdays"] = floatval($TenantInfo['noofdays']);
	$response["noofmonths"] = floatval($TenantInfo['noofmonths']);
	$response["monthly_dues"] = number_format($TenantInfo['monthly_dues'], 2, ".", ",");
	$response["assoc_dues"] = number_format($TenantInfo['assoc_dues'], 2, ".", ",") ;
	$response["GrandTotal"] = number_format($GrandTotal, 2, ".", ",") ;
	$response["escalation_rate"] = isset($ProposalInfo['escalation_rate']) ? $ProposalInfo['escalation_rate'] : "";
	$response["year_start"] = isset($ProposalInfo['year_start']) ? $ProposalInfo['year_start'] : "";
	$response["year_basis"] = isset($ProposalInfo['year_basis']) ? $ProposalInfo['year_basis'] : "";
	
	$response["success"] = 1;
	
	function SysLeaseSetup($field){
	$LeaseSys = mysql_fetch_array(mysql_query("SELECT ". $field ." FROM tblsys_setup;"));
	return $LeaseSys[0];
	}
	
echo json_encode($response);
?>	