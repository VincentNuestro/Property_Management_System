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
$response["message"] = array();

$messageID = $_POST["messageID"];
//$messageID = "msg-0000003";

$getMessegeChat = mysql_query ("Select messageid,message, sender_id, date(xdatetime) as xdate, time(xdatetime) as xtime from 
`tblchat_log` where messageid= '$messageID' order by xdatetime asc limit 50");

if(mysql_num_rows($getMessegeChat) <> 0){
		while($rowItem = mysql_fetch_array($getMessegeChat)){
				$list = array();
				$list["messageid"] = $rowItem["messageid"];
				$list["message"] = $rowItem["message"];
				$list["sender_id"] = $rowItem["sender_id"];
				$list["xdate"] = $rowItem["xdate"];
				$list["xtime"] = date('h:i:s a', strtotime($rowItem["xtime"]));
				array_push($response["message"], $list);
			}
		$response["success"] = 1;
}
else{
	$response["success"] = 0;
}
echo json_encode($response);
?>	