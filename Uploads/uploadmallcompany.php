<?php
    session_start();
	include('../connect.php');
	$file = $_FILES['txtMallCompanyImage']['name'];
	$filetype = $_FILES["txtMallCompanyImage"]["type"];
	$filesize = $_FILES["txtMallCompanyImage"]["size"];
	$tmp_name = $_FILES["txtMallCompanyImage"]["tmp_name"];
	if(!file_exists("../../Mall_Attachments/Mall_Company")){
		mkdir("../../Mall_Attachments/Mall_Company", 0777, true);
	}
	$MallCompanyName = mysql_fetch_array(mysql_query("SELECT MallCompanyName, MallCompanyImage FROM tblref_mallcompany WHERE MallCompanyID = '". $_REQUEST['txtMallCompanyID'] ."';", $connection));
	$ext = explode(".", $_FILES["txtMallCompanyImage"]["name"]);
	$CurrentDateTime = date('Y-m-d H:i:s');
	$FileName = $MallCompanyName['MallCompanyName'].date('mdYHis', strtotime($CurrentDateTime)).".".end($ext);
	if($file != ""){
		unlink("../../Mall_Attachments/Mall_Company/" . $MallCompanyName['MallCompanyImage']);
		$result = mysql_query("UPDATE tblref_mallcompany SET MallCompanyImage = '". $FileName ."', datetimeadded = '". $CurrentDateTime ."' WHERE MallCompanyID = '". $_REQUEST["txtMallCompanyID"] ."';", $connection);
		move_uploaded_file($tmp_name, "../../Mall_Attachments/Mall_Company/" . $FileName);
	}
?>