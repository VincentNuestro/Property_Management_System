<?php
/*
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
*/

include("../../android_connect.php");

$response = array();
$id = $_POST['id'];
//$id = "USER-0000002";
$response["task"] = array();
$getDates = mysql_query("select xdate from tblmaintenance_workorder where xstatus like 
'Pending' and workerid like '$id'");
if(mysql_num_rows($getDates) <> 0){
	while($row = mysql_fetch_array($getDates)){
		$list["sched"] = date('Y-m-d', strtotime($row["xdate"]));
		array_push($response["task"], $list);
	}
	$response["success"] = 1;
}else{
	$response["success"] = 0;
}
echo json_encode($response);
?>