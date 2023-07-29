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
$response['UserChat'] = array();

$SelectUser = mysql_query("SELECT userid, firstname, middlename, lastname FROM `tbluser` ORDER BY firstname ASC");

if(mysql_num_rows($SelectUser) <> 0){
	while($rowClass = mysql_fetch_array($SelectUser)){
		$list1 = array();
		$list1["userid"] = $rowClass["userid"];
		$list1["firstname"] = $rowClass["firstname"];
		$list1["middlename"] = $rowClass["middlename"];
		$list1["lastname"] = $rowClass["lastname"];
		array_push($response["UserChat"], $list1);
	}
	$response["success"] = 1;
}else {
	$response["success"] = 0;
}

	
echo json_encode($response);
?>	
