<?php
	session_start();
	include "../../connect.php";
	$file = $_FILES['txtBillAttachment']['name'];
	$filetype = $_FILES["txtBillAttachment"]["type"];
	$filesize = $_FILES["txtBillAttachment"]["size"];
	$tmp_name = $_FILES["txtBillAttachment"]["tmp_name"];
	if (!file_exists("../../../Mall_Attachments/Billing")) {
		mkdir("../../../Mall_Attachments/Billing", 0777, true);
	}
	if($file != ""){
		$ext = explode(".", $_FILES["txtBillAttachment"]["name"]);	
		$FileName = $_POST['txtpaymentorno'] . "." . end($ext);
		$res = mysql_query("UPDATE tbltransaction SET image_file_name = '". $FileName ."' WHERE orno = '". $_POST['txtpaymentorno'] ."';", $connection);
		move_uploaded_file($_FILES["txtBillAttachment"]["tmp_name"], "../../../Mall_Attachments/Billing/". $FileName);
		echo "UPDATE tbltransaction SET image_file_name = '". $FileName ."' WHERE orno = '". $_POST['txtpaymentorno'] ."';";
	}
?>