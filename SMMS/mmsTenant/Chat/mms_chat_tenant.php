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

//$tenantHeader = mysql_query("SELECT tbltenant_chat_header.sender_userid AS sender, tbltenant_chat_header.receiver_userid AS receiver, 
//tbltenant_chat_header.messageid  as messageid, tbltenant_chat.xdatetime as xdate FROM tbltenant_chat_header 
//LEFT JOIN tbltenant_chat ON tbltenant_chat_header.messageid = tbltenant_chat.messageid group by tbltenant_chat.messageid
//order by tbltenant_chat.xdatetime ASC");

$tenantHeader = mysql_query("select sender_userid, receiver_userid, messageid from tbltenant_chat_header order by xdatetime desc");

if(mysql_num_rows($tenantHeader) <> 0){
	while($rowClass = mysql_fetch_array($tenantHeader)){
			$list1 = array();
			$list1["sender_userid"] = $rowClass["sender_userid"];
			$list1["receiver_userid"] = $rowClass["receiver_userid"];
			$list1["messageid"] = $rowClass["messageid"];
			array_push($response["TenantChat"], $list1);
	$response["success"] = 1;
	}
}
else{
	$response["success"] = 0;
}
echo json_encode($response);
?>	
