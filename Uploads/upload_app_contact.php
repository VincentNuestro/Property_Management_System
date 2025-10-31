<?php
	session_start();
	include('../connect.php');
	$file = $_FILES['attachment_profilepic']['name'];
	$filetype = $_FILES["attachment_profilepic"]["type"];
	$filesize = $_FILES["attachment_profilepic"]["size"];
	$tmp_name = $_FILES["attachment_profilepic"]["tmp_name"];		
	if($file != ""){
		if (!file_exists("../../Mall_Attachments/BillProfile/" . $_REQUEST["txtcon_company"]  . "/contact_person/".$_REQUEST["txtcon_person"])) {
			mkdir("../../Mall_Attachments/BillProfile/" . $_REQUEST["txtcon_company"]  . "/contact_person/".$_REQUEST["txtcon_person"], 0777, true);
		}
			move_uploaded_file($tmp_name, "../../Mall_Attachments/BillProfile/" . $_REQUEST["txtcon_company"]  . "/contact_person/".$_REQUEST["txtcon_person"] . "/" . $file);		
			$sql = "UPDATE tbltrans_company_contact_person SET filename = '". $file ."' WHERE ConID = '".$_REQUEST["txtcon_company"]."' AND custID = '".$_REQUEST["txtcon_person"]."'";
			$result = mysql_query($sql, $connection);
	}		
	mysql_close($connection);
?>