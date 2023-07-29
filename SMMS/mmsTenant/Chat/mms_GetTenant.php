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
$response['TenantChat'] = array();

$SelectTenant = mysql_query("Select TenantID, tradename from `tbltrans_tenants` ORDER BY tradename ASC");

if(mysql_num_rows($SelectTenant) <> 0){
	while($rowClass = mysql_fetch_array($SelectTenant)){
		$list1 = array();
		$list1["TenantID"] = $rowClass["TenantID"];
		$list1["tradename"] = $rowClass["tradename"];
		array_push($response["TenantChat"], $list1);
	}
	$response["success"] = 1;
}else {
	$response["success"] = 0;
}

	
echo json_encode($response);
?>	
