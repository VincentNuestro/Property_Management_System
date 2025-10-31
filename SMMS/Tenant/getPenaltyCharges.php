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
$startdate = $_POST["startdate"];
$enddate = $_POST["enddate"];
$TenantID = $_POST["TenantID"];
//$appid = $_POST["appid"];
//$appid = "APP-2018-0000001";
$response["all"] = array();

$charges = mysql_query("SELECT SUM(balance) as charges FROM tbltransaction WHERE tenantid = '$TenantID' AND xdescription = 'Penalty' 
  AND xdate <= '$enddate' AND balance != '0.00' AND isMerchant = '0'");

if (mysql_num_rows($charges) != 0) {

	while($rowItem = mysql_fetch_array($charges)){

				$list = array();
			
				if ($rowItem["charges"] == "null" || $rowItem["charges"] == ""){$list["charges"]= "";}else{$list["charges"] = $rowItem["charges"];}
				
				array_push($response["all"], $list);
	}
		
		$response["success"] = 1;
}

else {
	$response["success"] = 0;
} 


echo json_encode($response);

?>	

