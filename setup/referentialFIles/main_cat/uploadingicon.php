<?php
	session_start();
	include "../../../connect.php";
	$file = $_FILES['txtCatIcon']['name'];
	$filetype = $_FILES["txtCatIcon"]["type"];
	$filesize = $_FILES["txtCatIcon"]["size"];
	$tmp_name = $_FILES["txtCatIcon"]["tmp_name"];
	if (!file_exists("../../../../Mall_Attachments/Maintenance/Category")) {
		mkdir("../../../../Mall_Attachments/Maintenance/Category", 0777, true);
	}
	if($file != ""){
		$ext = explode(".", $_FILES["txtCatIcon"]["name"]);
		$CategoryName = mysql_fetch_array(mysql_query("SELECT category_id, icon FROM tblmaintenance_category WHERE id = '". $_POST['pinaghuhugutan'] ."';", $connection));
		$filename = $CategoryName['category_id'] . "." . end($ext);
		$updateresult = mysql_query("UPDATE tblmaintenance_category SET icon = '" . $filename . "' WHERE id = '" . $_POST['pinaghuhugutan'] . "';", $connection);
		unlink("../../../../Mall_Attachments/Maintenance/Category/" . $CategoryName['icon']);
		move_uploaded_file($_FILES["txtCatIcon"]["tmp_name"], "../../../../Mall_Attachments/Maintenance/Category/".$filename);
	}
?>