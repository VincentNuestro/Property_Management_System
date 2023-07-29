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

include("../android_connect.php");

$response = array();
$response["User"] = array();

if ($connection) {
	$getAlluser = mysql_query("Select userid, username, password from `tbluser`");
	if(mysql_num_rows($getAlluser) <> 0){
		while($Items = mysql_fetch_array($getAlluser)){
			$listItem = array();
			$listItem["userid"] = $Items["userid"];
			$listItem["username"] = $Items["username"];
			$listItem["passwordstr"] = $Items["passwordstr"];
			array_push($response["User"], $listItem);	
		}
		$response["success"] = 1;
	}
	else{
		$response["success"] = 2;
	}
}
else {
	$response["success"] = 0;
}
echo json_encode($response);
?>