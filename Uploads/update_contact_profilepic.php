<?php
	session_start();
	include('../connect.php');
	$file = $_FILES['file_upload_trade_update']['name'];
	$filetype = $_FILES["file_upload_trade_update"]["type"];
	$filesize = $_FILES["file_upload_trade_update"]["size"];
	$tmp_name = $_FILES["file_upload_trade_update"]["tmp_name"];
		if($file != ""){
			if (!file_exists("../../Mall_Attachments/BillProfile/" . $_REQUEST["companyID"]  . "/contact_person/".$_REQUEST["contactID"])) {
				mkdir("../../Mall_Attachments/BillProfile/" . $_REQUEST["companyID"]  . "/contact_person/".$_REQUEST["contactID"], 0777, true);
			}
			move_uploaded_file($tmp_name, "../../Mall_Attachments/BillProfile/" . $_REQUEST["companyID"]  . "/contact_person/".$_REQUEST["contactID"] . "/" . $file);
			$sql = "UPDATE tbltrans_company_contact_person SET filename = '". $file ."' WHERE ConID = '".$_REQUEST["companyID"]."' AND custID = '".$_REQUEST["contactID"]."'";
			$result = mysql_query($sql, $connection);
		}
		mysql_close($connection);
?>