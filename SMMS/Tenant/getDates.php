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
$TenantID = $_POST["tenantID"];
//$appid = $_POST["appid"];
//$appid = "APP-2018-0000001";
$response["all"] = array();

$charges = mysql_query("SELECT DISTINCT soaperiod, soaperiod2, hperiod, duedate,
 soaid FROM dunn_tblsoaheader WHERE isMerchant = '0' AND 
 soaperiod2 != '0000-00-00' ORDER BY soaperiod DESC");

if (mysql_num_rows($charges) != 0) {

	while($rowItem = mysql_fetch_array($charges)){

				$list = array();
			
				if ($rowItem["soaperiod"] == "null" || $rowItem["soaperiod"] == ""){$list["soaperiod"]= "";}else{$list["soaperiod"] = $rowItem["soaperiod"];}
				if ($rowItem["soaperiod2"] == "null" || $rowItem["soaperiod2"] == ""){$list["soaperiod2"]= "";}else{$list["soaperiod2"] = $rowItem["soaperiod2"];}
				if ($rowItem["hperiod"] == "null" || $rowItem["hperiod"] == ""){$list["hperiod"]= "";}else{$list["hperiod"] = $rowItem["hperiod"];}
				if ($rowItem["duedate"] == "null" || $rowItem["duedate"] == ""){$list["duedate"]= "";}else{$list["duedate"] = $rowItem["duedate"];}
				if ($rowItem["soaid"] == "null" || $rowItem["soaid"] == ""){$list["soaid"]= "";}else{$list["soaid"] = $rowItem["soaid"];}

				array_push($response["all"], $list);
	}
		
		$response["success"] = 1;
}

else {
	$response["success"] = 0;
} 


echo json_encode($response);

?>	

