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
$response["Property"] = array();
$id = $_POST['id'];
//$id = 'USER-0000002';

$GetUser = mysql_fetch_array(mysql_query("SELECT MallAccess FROM tbluser WHERE userid = '$id'"));
		$MallAccesList;
		$ConnArr = explode("@", $GetUser['MallAccess']);
		for ($i = 0; $i <= COUNT($ConnArr)-2; $i++) { 
			$MallAccesList .= "'" . $ConnArr[$i] . "'" . ",";
		}
		if($GetUser['MallAccess'] != ""){
			$Additional = " AND mallid IN (". substr(trim($MallAccesList), 0, -1) .")";
		}else{
			$Additional = "";
		}

		//echo "SELECT mallid, mallname FROM tblref_mall WHERE mallstat = '1' " . $Additional . "";	

$SelectMall = mysql_query("SELECT mallid, mallname, malladdress, telephone_number, email FROM tblref_mall 
WHERE mallstat = '1' " . $Additional . "");

if(mysql_num_rows($SelectMall) <> 0){
	while($row = mysql_fetch_array($SelectMall)){
		$list = array();
		$list["mallid"] = $row["mallid"];
		$list["mallname"] = $row["mallname"];
		$list["malladdress"] = $row["malladdress"];
		$list["telephone_number"] = $row["telephone_number"];
		$list["email"] = $row["email"];
		array_push($response["Property"],$list);
	}
	$response["success"] = 1;
}else{
	$response["success"] = 0;
}
echo json_encode($response);
?>