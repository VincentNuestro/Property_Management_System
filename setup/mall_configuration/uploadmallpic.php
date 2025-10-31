<?php
    session_start();
	include('../../connect.php');
	$file = $_FILES['attachment_profilepic']['name'];
	$filetype = $_FILES["attachment_profilepic"]["type"];
	$filesize = $_FILES["attachment_profilepic"]["size"];
	$tmp_name = $_FILES["attachment_profilepic"]["tmp_name"];
	if(!file_exists("../../../Mall_Attachments/mall_image")){
		mkdir("../../../Mall_Attachments/mall_image", 0777, true);
	}
	$title = mysql_fetch_array(mysql_query("SELECT softwaretype FROM tblsys_setup;", $connection));
	if($title[0] == "0"){
		$label =  "Mall";
	}else if($title[0] == "1"){
		$label =  "Property";
	}else if($title[0] == "2"){
		$label =  "Building";
	}
	$CurrentImage = mysql_fetch_array(mysql_query("SELECT mallname, mall_image FROM tblref_mall WHERE mallid = '". $_REQUEST["txtmallid_forms"] ."';", $connection));
	$ext = explode(".", $_FILES["attachment_profilepic"]["name"]);
	if($file != ""){
		$FileName = preg_replace("/[^a-zA-Z]+/", "", $CurrentImage['mallname']) . "." . end($ext);
		$result = mysql_query("UPDATE tblref_mall SET mall_image = '". $FileName ."' WHERE mallid = '". $_REQUEST["txtmallid_forms"] ."';", $connection);
		unlink("../../../Mall_Attachments/SysLogo/" . $SysSetup['LP_BGImage']);
		move_uploaded_file($tmp_name, "../../../Mall_Attachments/mall_image/" . $FileName);
	}
?>