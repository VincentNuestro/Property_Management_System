<?php
	session_start();
	include('../../connect.php');
	$file = $_FILES['txtBGImage']['name'];
	$filetype = $_FILES["txtBGImage"]["type"];
	$filesize = $_FILES["txtBGImage"]["size"];
	$tmp_name = $_FILES["txtBGImage"]["tmp_name"];
	if(!file_exists("../../../Mall_Attachments/SysLogo")){
		mkdir("../../../Mall_Attachments/SysLogo", 0777, true);
	}
	$SysSetup = mysql_fetch_array(mysql_query("SELECT LP_BGImage, corporatename FROM tblsys_setup;", $connection));
	$ext = explode(".", $_FILES["txtBGImage"]["name"]);
	if($file != ""){
		$FileName = preg_replace("/[^a-zA-Z]+/", "", $SysSetup['corporatename']) . "." . end($ext);
		$updateresult = mysql_query("UPDATE tblsys_setup SET LP_BGImage = '". $FileName . "';", $connection);
		unlink("../../../Mall_Attachments/SysLogo/" . $SysSetup['LP_BGImage']);
		move_uploaded_file($_FILES["txtBGImage"]["tmp_name"], "../../../Mall_Attachments/SysLogo/" . $FileName);
		$tran_logs = create_logs_per_transaction("modified the landing page background image.", "System Setup", "", "" ,"UPDATE", "1");
	}
?>