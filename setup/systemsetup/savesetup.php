<?php
	session_start();
	include('../../connect.php');
	$file = $_FILES['file1']['name'];
	$filetype = $_FILES["file1"]["type"];
	$filesize = $_FILES["file1"]["size"];
	$tmp_name = $_FILES["file1"]["tmp_name"];
	if(!file_exists("../../../Mall_Attachments/SysLogo")){
		mkdir("../../../Mall_Attachments/SysLogo", 0777, true);
	}
	$SysSetup = mysql_fetch_array(mysql_query("SELECT id, corporatelogo FROM tblsys_setup;", $connection));
	$ext = explode(".", $_FILES["file1"]["name"]);
	if($file != ""){
		$FileName = $SysSetup['id'] . "." . end($ext);
		$updateresult = mysql_query("UPDATE tblsys_setup SET corporatelogo = '". $FileName . "';", $connection);
		unlink("../../../Mall_Attachments/SysLogo/" . $SysSetup['corporatelogo']);
		move_uploaded_file($_FILES["file1"]["tmp_name"], "../../../Mall_Attachments/SysLogo/" . $FileName);
		$tran_logs = create_logs_per_transaction("modified the system logo.", "System Setup", "", "" ,"UPDATE", "1");
	}
?>