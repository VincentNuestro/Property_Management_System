<?php

date_default_timezone_get();
date_default_timezone_set('Asia/Manila');
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));
$connection = mysql_connect('localhost', 'gates', 'g@tes2009');
if (!$connection) {
	die('Could not connect: ' . mysql_error());
}

$db =  mysql_select_db("gates_smm", $connection);
mysql_query("SET NAMES 'utf8'");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET COLLATION_CONNECTION = 'utf8_unicode_ci'");

$response = array();
$response["Incident"] = array();
$SelectFromtblmaintenance_houserules = mysql_query("Select * from `tblmaintenance_houserules`");
if(mysql_num_rows($SelectFromtblmaintenance_houserules) <> 0){
	while($rowClass = mysql_fetch_array($SelectFromtblmaintenance_houserules)){
		$list1 = array();
		$list1["Code"] = $rowClass["Code"];
		$list1["Violation"] = $rowClass["Violation"];
		$list1["1st_offense"] = $rowClass["1st_offense"];
		$list1["2nd_offense"] = $rowClass["2nd_offense"];
		$list1["3rd_offense"] = $rowClass["3rd_offense"];
		array_push($response["Incident"], $list1);
	}
	$response["success"] = 1;
}else{$response["success"] = 0;}

echo json_encode($response);
?>	
