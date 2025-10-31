<?php
	session_start();
	include "../../connect.php";
	$file = $_FILES['txtAssetFile']['name'];
	$filetype = $_FILES["txtAssetFile"]["type"];
	$filesize = $_FILES["txtAssetFile"]["size"];
	$tmp_name = $_FILES["txtAssetFile"]["tmp_name"];
	if (!file_exists("../../../Mall_Attachments/Asset/")) {
		mkdir("../../../Mall_Attachments/Asset/", 0777, true);
	}
	if($file != ""){
		$ext = explode(".", $_FILES["txtAssetFile"]["name"]);	
		$PrevAssetImage = mysql_fetch_array(mysql_query("SELECT AssetImage FROM tblref_asset WHERE AssetNo = '". $_POST['txtAssetControlNo'] ."';", $connection));
		$FileName = $_POST['txtAssetControlNo'] . "." . end($ext);
		$updateresult = mysql_query("UPDATE tblref_asset SET AssetImage = '" . $FileName . "' WHERE AssetNo = '" . $_POST['txtAssetControlNo'] . "';", $connection);
		unlink("../../../Mall_Attachments/Asset/". $PrevAssetImage['AssetImage']);
		move_uploaded_file($_FILES["txtAssetFile"]["tmp_name"], "../../../Mall_Attachments/Asset/". $FileName);
	}
?>