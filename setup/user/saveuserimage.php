<?php
	session_start();
	include('../../connect.php');
	if(!file_exists("../../../Mall_Attachments/User")){
		mkdir("../../../Mall_Attachments/User", 0777, true);
	}
	$CurrentExt = mysql_fetch_array(mysql_query("SELECT ext FROM tbluser WHERE userid = '". $_REQUEST['txtuserid'] ."';", $connection));
	if($_FILES['txtfile']['name'] != ""){
		$ext = explode(".", $_FILES["txtfile"]["name"]);
		$updateresult = mysql_query("UPDATE tbluser SET ext = '" . end($ext) . "' WHERE userid = '" . $_REQUEST['txtuserid'] . "';", $connection);
		$FileName = $_REQUEST['txtuserid'] . "." . end($ext);
		unlink("../../../Mall_Attachments/User/". $_REQUEST['txtuserid'] .".". $CurrentExt['ext']);
		move_uploaded_file($_FILES["txtfile"]["tmp_name"], "../../../Mall_Attachments/User/" . $FileName);
	}
?>