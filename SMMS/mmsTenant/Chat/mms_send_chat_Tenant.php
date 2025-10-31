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
$message = $_POST['message'];
$messageID = $_POST['messageID'];
$userid = $_POST['userid'];

$insertintChatLogs = mysql_query("INSERT INTO tblchat_log set messageid = '$messageID', message = '$message', sender_id = '$userid'");
$selectxdateTimeinChatlOgs = mysql_query ("SELECT xdatetime FROM tblchat_log where messageid = '$messageID' and message = '$message' and sender_id = '$userid' ORDER BY id DESC");
$data = mysql_fetch_array($selectxdateTimeinChatlOgs);
$xdatetime = $data["xdatetime"];
$updatechat_record = mysql_query ("UPDATE tblchat_record set xdatetime = '$xdatetime' where messageid = '$messageID'"); 


$response["success"] = 1;
echo json_encode($response);
?>	