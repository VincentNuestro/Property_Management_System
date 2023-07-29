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
$username = $_POST["username"];
$pass = $_POST["pass"];
//$indicator = $_POST["indicator"];
$response["User"] = array();
$indicator ="1";

if ($indicator == "0"){
	//-------------------------------------------------------
	
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
	
	//-------------------------------------------------------
}else{
	//-------------------------------------------------------
	$SelectUser = mysql_query("SELECT userid FROM `tbluser` WHERE username = '$username'");
	if(mysql_num_rows($SelectUser) <> 0){
		$Data = mysql_fetch_array($SelectUser);
			
			$SelectUsers = mysql_query("SELECT * FROM `tbluser` WHERE username = '$username' and password = '".md5($pass."".$Data["userid"]."@GS")."'");
				if(mysql_num_rows($SelectUsers) <> 0){
					$Datas = mysql_fetch_array($SelectUsers);
					
					if($Datas["isAdmin"] == "1"){
						$response["CreateWorkOrder"]  = 1;
					}else{
						$getAccess = mysql_fetch_array(mysql_query("SELECT id FROM `tblref_usergroupaccess` WHERE groupid = '".$Datas["groupaccess"]."' AND functionid = 'view1createworkorder'"));
						if($getAccess['id'] != ''){	$response["CreateWorkOrder"]  = 1; } else { $response["CreateWorkOrder"]  = 0; }
					}
					
					$response["userid"]  = $Datas["userid"];
					$response["firstname"]  = $Datas["firstname"];
					$response["middlename"]  = $Datas["middlename"];
					$response["lastname"]  = $Datas["lastname"];
					$response["groupaccess"]  = $Datas["groupaccess"];
					$response["mallid"]  = $Datas["MallAccess"];
					
					$response["success"] = 1;
				}
				else{
					$response["success"] = 2;
				}
	}
	else{
		$response["success"] = 2;
	}
	//-------------------------------------------------------
}


echo json_encode($response);
?>	