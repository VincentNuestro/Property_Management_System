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
$userid = $_POST['userid'];
$response["header"] = array();
//$userid = "USER-0000003";

echo $userid;
$selectMessageId = mysql_query("SELECT messageid FROM tblchat_record WHERE userid = '$userid'");

if(mysql_num_rows($selectMessageId) <> 0){
	while($rowClass = mysql_fetch_array($selectMessageId)){
			$list1 = array();
			
			$list1["messageid"] = $rowClass["messageid"];
			array_push($response["header"], $list1);
	$response["success"] = 1;
	}
}
else{
	$response["success"] = 0;
}
echo json_encode($response);
?>	


