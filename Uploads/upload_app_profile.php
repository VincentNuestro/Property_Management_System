<?php
	session_start();
	include('../connect.php');
	if (!file_exists("../../Mall_Attachments/company/". $_REQUEST["hidden_company_id"])) {
		mkdir("../../Mall_Attachments/company/". $_REQUEST["hidden_company_id"], 0777, true);
	}
	$file = $_FILES["attachment_profilepic"]["name"];
	$filetype = $_FILES["attachment_profilepic"]["type"];
	$filesize = $_FILES["attachment_profilepic"]["size"];
	$tmp_name = $_FILES["attachment_profilepic"]["tmp_name"];
	$image = getimagesize($tmp_name);
	if($file != ""){
		$prevImage = mysql_fetch_array(mysql_query("SELECT ext FROM tbltrans_company WHERE CompanyID = '". $_REQUEST["hidden_company_id"] ."';", $connection));
		if (!file_exists("../../Mall_Attachments/company/". $_REQUEST["hidden_company_id"]  ."/profile")) {
			mkdir("../../Mall_Attachments/company/". $_REQUEST["hidden_company_id"] ."/profile", 0777, true);
		}
		$ext = explode(".", $file);
		$_FILES['attachment_profilepic']['name'] = $_REQUEST["hidden_company_id"] .".". end($ext);
		$file2 = $_FILES['attachment_profilepic']['name'];

		unlink("../../Mall_Attachments/company/". $_REQUEST["hidden_company_id"] ."/profile/". $_REQUEST["hidden_company_id"] .".".$prevImage['ext']);
		move_uploaded_file($tmp_name, "../../Mall_Attachments/company/" . $_REQUEST["hidden_company_id"]  . "/profile/" . $file2);
		
		$result = mysql_query("UPDATE tbltrans_company SET filename = '". $file2 ."', ext = '" . end($ext) . "', width = '".$image[0]."', height = '".$image[1]."' WHERE CompanyID = '".$_REQUEST["hidden_company_id"]."';", $connection);
	}
	mysql_close($connection);
?>