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
$userID = $_POST["userID"];
$tenantID = $_POST["tenantID"];

//$userID = "USER-0000002";
//$tenantID = "TENANT-0000053";

$getMessageID = mysql_query("select messageid from `tblchat_header` where sender_userid ='$userID' and receiver_userid = '$tenantID'");

if(mysql_num_rows($getMessageID) <> 0){
	$data = mysql_fetch_array($getMessageID);
	$messageID = $data["messageid"];
	$response["success"] = 1;
	$response['messageID'] = $messageID;
	//echo "first if check " . $messageID;
}
else{
	$getMessageID = mysql_query("select messageid from `tblchat_header` where sender_userid ='$tenantID' and receiver_userid = '$userID'");
	$data = mysql_fetch_array($getMessageID);
	$messageID = $data["messageid"];	
	
	
	if(mysql_num_rows($getMessageID) <> 0){
	$response["success"] = 1;
	$response['messageID'] = $messageID;
	//echo "second if check " . $messageID;
	}
	else{		
		$response["success"] = 0;
		
		$getLastMessageId = mysql_query("select messageid from `tblchat_header` order by messageid desc limit 1");
			  if(mysql_num_rows($getLastMessageId) <> 0){
				$rowheader = mysql_fetch_array($getLastMessageId);
				$arrheader = array();
				$arrheader = explode("-", $rowheader["messageid"]);
				//echo "Message id ". $arrheader[1];
				$newheader = "msg-".str_pad($arrheader[1] + 1, 7, '0', STR_PAD_LEFT);
				//echo "New id ".  $newheader;
				//$updateheader = mysql_query("update customer_header set customer_number = '$newheader'");
			  }else{
				  $newheader = "msg-0000001";
			  }
		$response['messageID'] = $newheader;
		
		
		$insertinchatHeader = mysql_query ("INSERT INTO	tblchat_header set sender_userid ='$userID', receiver_userid = '$tenantID', messageid = '$newheader'");
		$insertinchatRecord = mysql_query ("INSERT INTO tblchat_record set userid = '$userID', messageid = '$newheader'");
		$insertinchatRecord = mysql_query ("INSERT INTO tblchat_record set userid = '$tenantID', messageid = '$newheader'");
		
	}
}


echo json_encode($response);
?>	