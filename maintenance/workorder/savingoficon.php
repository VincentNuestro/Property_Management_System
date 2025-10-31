<?php
	session_start();
	include "../../connect.php";
	$file = $_FILES['fileIcon']['name'];
	$filetype = $_FILES["fileIcon"]["type"];
	$filesize = $_FILES["fileIcon"]["size"];
	$tmp_name = $_FILES["fileIcon"]["tmp_name"];
	if (!file_exists("../../../Mall_Attachments/Maintenance/Category")) {
		mkdir("../../../Mall_Attachments/Maintenance/Category", 0777, true);
	}
	if($file != ""){
		$ext = explode(".", $_FILES["fileIcon"]["name"]);	
		$CategoryName = mysql_fetch_array(mysql_query("SELECT category_id, icon FROM tblmaintenance_category WHERE id = '". $_POST['frmIconID'] ."';", $connection));
		$filename = $CategoryName['category_id'] . "." . end($ext);
		$updateresult = mysql_query("UPDATE tblmaintenance_category SET icon = '" . $filename . "' WHERE id = '" . $_POST['frmIconID'] . "';", $connection);
		unlink("../../../Mall_Attachments/Maintenance/Category/". $CategoryName['icon']);
		move_uploaded_file($_FILES["fileIcon"]["tmp_name"], "../../../Mall_Attachments/Maintenance/Category/". $filename);
	}
?>