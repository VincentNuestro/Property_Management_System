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
$TenantID = $_POST["TenantID"];
//$appid = $_POST["appid"];
//$appid = "APP-2018-0000001";
$response["all"] = array();

$charges = mysql_query(" SELECT SUM(balance) as balance FROM tbltransaction WHERE xdate < '$startdate' AND tenantid='$TenantID'");

if (mysql_num_rows($charges) != 0) {

	while($rowItem = mysql_fetch_array($charges)){

				$list = array();
			
				if ($rowItem["balance"] == "null" || $rowItem["balance"] == ""){$list["balance"]= "";}else{$list["balance"] = $rowItem["balance"];}
				
				array_push($response["all"], $list);
	}
		
		$response["success"] = 1;
}

else {
	$response["success"] = 0;
} 


echo json_encode($response);

?>	

