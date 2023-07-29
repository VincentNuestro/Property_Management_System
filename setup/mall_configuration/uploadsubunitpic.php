<?php
	session_start();
	include('../../connect.php');
	$file = $_FILES['fileSubUnitImage']['name'];
	$filetype = $_FILES["fileSubUnitImage"]["type"];
	$filesize = $_FILES["fileSubUnitImage"]["size"];
	$tmp_name = $_FILES["fileSubUnitImage"]["tmp_name"];
	if($file != ""){
		if (!file_exists("../../../Mall_Attachments/Unit Image")) {
			mkdir("../../../Mall_Attachments/Unit Image", 0777, true);
		}
		$prevext = mysql_fetch_array(mysql_query("SELECT photoext FROM tblref_unit WHERE unitid = '". $_REQUEST['txtSubUnitID'] ."';", $connection));
		$ext = explode(".", $_FILES["fileSubUnitImage"]["name"]);
		$image = $_REQUEST["txtSubUnitID"].".".end($ext);
		$res = mysql_query("UPDATE tblref_unit SET photoext = '". end($ext) ."' WHERE unitid = '". $_REQUEST["txtSubUnitID"] ."';", $connection);
		if($res == true){
			unlink("../../../Mall_Attachments/Unit Image/". $_REQUEST['txtSubUnitID'] .".". $prevext[0]);
			move_uploaded_file($tmp_name, "../../../Mall_Attachments/Unit Image/" . $image);
		}
	}
?>