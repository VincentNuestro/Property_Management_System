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
//$userid = "USER-0000002";
$title="";

$response["chats"] = array();

$getinfo = mysql_query ("SELECT tblchat_header.messageid AS messageid, tblchat_header.sender_userid AS sender, tblchat_header.receiver_userid 
AS receiver, tblchat_record.xdatetime AS xdatetime FROM tblchat_header INNER JOIN tblchat_record ON tblchat_header.messageid = tblchat_record.`messageid` 
WHERE tblchat_record.xdatetime !='' AND tblchat_record.`userid` = '$userid' GROUP BY tblchat_record.`messageid` ORDER BY tblchat_record.`xdatetime` DESC");

if(mysql_num_rows($getinfo) <> 0){
	while($rowItem = mysql_fetch_array($getinfo)){
			$list = array();
			$list["messageid"] = $rowItem["messageid"];
			$list["sender"] = $rowItem["sender"];
			$list["receiver"] = $rowItem["receiver"];
			$list["xdatetime"] = $rowItem["xdatetime"];
			
			
			$sender_userid = $rowItem["sender"];
			$receiver_userid = $rowItem["receiver"];
			
			//echo "sender_userid " . $sender_userid . " "; 
			//echo "receiver_userid " . $receiver_userid . " ";
			
			
			if ($receiver_userid === $userid){
				$title = $sender_userid;	
				//echo "first title " . $title; 
			}
			else if ($sender_userid == $userid){
				$title = $receiver_userid;
				//echo "Second title " . $title; 
			}
			
			
			$getInformation = mysql_query("SELECT tradename FROM `tbltrans_tenants` WHERE TenantID ='$title'");
			if(mysql_num_rows($getInformation) <> 0){
				$data = mysql_fetch_array($getInformation);
				$list["title"] = $data["tradename"];
			}
			else{
			$getInformation = mysql_query("SELECT firstname FROM `tbluser` WHERE userid ='$title'");
				$data = mysql_fetch_array($getInformation);
				$list["title"] = $data["firstname"];
			}
		array_push($response["chats"], $list);
	}
	$response["success"] = 1;
}
else{
	$response["success"] = 0;
}
echo json_encode($response);
?>	
