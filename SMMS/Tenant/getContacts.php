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

$charges = mysql_query("SELECT contactname
FROM `emergency_header` GROUP BY contactname");

if (mysql_num_rows($charges) != 0) {

	while($rowItem = mysql_fetch_array($charges)){

				$list = array();
			
				if ($rowItem["contactname"] == "null" || $rowItem["contactname"] == ""){$list["contactname"]= "";}else{$list["contactname"] = $rowItem["contactname"];}
				/*if ($rowItem["contactnum"] == "null" || $rowItem["contactnum"] == ""){$list["contactnum"]= "";}else{$list["contactnum"] = $rowItem["contactnum"];}*/
				/*if ($rowItem["hotline2"] == "null" || $rowItem["hotline2"] == ""){$list["hotline2"]= "";}else{$list["hotline2"] = $rowItem["hotline2"];}
				if ($rowItem["hotline3"] == "null" || $rowItem["hotline3"] == ""){$list["hotline3"]= "";}else{$list["hotline3"] = $rowItem["hotline3"];}
				if ($rowItem["phone_num"] == "null" || $rowItem["phone_num"] == ""){$list["phone_num"]= "";}else{$list["phone_num"] = $rowItem["phone_num"];}
*/
				array_push($response["all"], $list);
	}
		
		$response["success"] = 1;
}

else {
	$response["success"] = 0;
} 


echo json_encode($response);

?>	

