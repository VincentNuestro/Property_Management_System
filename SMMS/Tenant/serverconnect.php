<?php

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


$response = array();
if ($connection) {
	
	$selectCompanyInformation= mysql_query ("SELECT * FROM `mall_setup`");
	$row = mysql_fetch_array($selectCompanyInformation);
	
	if (empty($row["mall_id"])) {$response["mall_id"] = "";} else {$response["mall_id"] = $row["mall_id"];}
	if (empty($row["prepby"])) {$response["prepby"] = "";} else {$response["prepby"] = $row["prepby"];}
	if (empty($row["chkdby"])) {$response["chkdby"] = "";} else {$response["chkdby"] = $row["chkdby"];}
	if (empty($row["apprby"])) {$response["apprby"] = "";} else {$response["apprby"] = $row["apprby"];}
	if (empty($row["rcvdby"])) {$response["rcvdby"] = "";} else {$response["rcvdby"] = $row["rcvdby"];}
	if (empty($row["vatable_rent"])) {$response["vatable_rent"] = "";} else {$response["vatable_rent"] = $row["vatable_rent"];}
	if (empty($row["vat_rent_type"])) {$response["vat_rent_type"] = "";} else {$response["vat_rent_type"] = $row["vat_rent_type"];}
	if (empty($row["vat_rent_prcnt"])) {$response["vat_rent_prcnt"] = "";} else {$response["vat_rent_prcnt"] = $row["vat_rent_prcnt"];}
	if (empty($row["penalty_type"])) {$response["penalty_type"] = "";} else {$response["penalty_type"] = $row["penalty_type"];}
	if (empty($row["penalty_percent"])) {$response["penalty_percent"] = "";} else {$response["penalty_percent"] = $row["penalty_percent"];}
	if (empty($row["penalty_amount"])) {$response["penalty_amount"] = "";} else {$response["penalty_amount"] = $row["penalty_amount"];}
	if (empty($row["associationdues"])) {$response["associationdues"] = "";} else {$response["associationdues"] = $row["associationdues"];}
	if (empty($row["depositperc"])) {$response["depositperc"] = "";} else {$response["depositperc"] = $row["depositperc"];}
	if (empty($row["spotperc"])) {$response["spotperc"] = "";} else {$response["spotperc"] = $row["spotperc"];}
	if (empty($row["downperc"])) {$response["downperc"] = "";} else {$response["downperc"] = $row["downperc"];}
	if (empty($row["promo_disc"])) {$response["promo_disc"] = "";} else {$response["promo_disc"] = $row["promo_disc"];}
	if (empty($row["company_disc"])) {$response["company_disc"] = "";} else {$response["company_disc"] = $row["company_disc"];}
	if (empty($row["standard_disc"])) {$response["standard_disc"] = "";} else {$response["standard_disc"] = $row["standard_disc"];}
	if (empty($row["reg_fee"])) {$response["reg_fee"] = "";} else {$response["reg_fee"] = $row["reg_fee"];}
	if (empty($row["doc_tax"])) {$response["doc_tax"] = "";} else {$response["doc_tax"] = $row["doc_tax"];}
	if (empty($row["trans_tax"])) {$response["trans_tax"] = "";} else {$response["trans_tax"] = $row["trans_tax"];}
	if (empty($row["legal_fee"])) {$response["legal_fee"] = "";} else {$response["legal_fee"] = $row["legal_fee"];}
	if (empty($row["WE_connection"])) {$response["WE_connection"] = "";} else {$response["WE_connection"] = $row["WE_connection"];}
	if (empty($row["misc_fee"])) {$response["misc_fee"] = "";} else {$response["misc_fee"] = $row["misc_fee"];}
	if (empty($row["typeofreservationfee"])) {$response["typeofreservationfee"] = "";} else {$response["typeofreservationfee"] = $row["typeofreservationfee"];}
	if (empty($row["reservationfee"])) {$response["reservationfee"] = "";} else {$response["reservationfee"] = $row["reservationfee"];}
	if (empty($row["typeofretentionfee"])) {$response["typeofretentionfee"] = "";} else {$response["typeofretentionfee"] = $row["typeofretentionfee"];}
	if (empty($row["retentionfee"])) {$response["retentionfee"] = "";} else {$response["retentionfee"] = $row["retentionfee"];}	
	$response["success"] = 1;
	
	}
	else{
		$response["success"] = 0;
		}
echo json_encode($response);
?>	
