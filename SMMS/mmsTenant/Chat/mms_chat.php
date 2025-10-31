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
$response["chat"] = array();
$userid = $_POST['userid'];



$selectMessageInheader = mysql_query("Select sender_userid, receiver_userid, messageid from `tbltenant_chat_header`");
if(mysql_num_rows($selectMessageInheader) <> 0){
	while($rowClass = mysql_fetch_array($selectMessageInheader)){
		$list1 = array();
		$list1["sender_userid"] = $rowClass["sender_userid"];
		$list1["receiver_userid"] = $rowClass["receiver_userid"];
		$list1["messageid"] = $rowClass["messageid"];
		$list1["message"] = array();
		
			$messageList = mysql_query("SELECT messageid, message, sender_id, DATE(xdatetime) AS xdate, 
			TIME(xdatetime) AS xtime FROM `tbltenant_chat` WHERE messageid = '".$rowClass["messageid"]."'");
				if(mysql_num_rows($messageList) <> 0){
					while($rowItem = mysql_fetch_array($messageList)){
						$list2 = array();
						$list2["messageid"] = $rowItem["messageid"];
						$list2["message"] = $rowItem["message"];
						$list2["sender_id"] = $rowItem["sender_id"];
						$list2["xdate"] = $rowItem["xdate"];
						$list2["xtime"] = $rowItem["xtime"];
						array_push($list1["message"], $list2);
					}
				}
		array_push($response["chat"], $list1);
	}
	$response["success"] = 1;
}else{
	$response["success"] = 0;
}

	
echo json_encode($response);
?>	
