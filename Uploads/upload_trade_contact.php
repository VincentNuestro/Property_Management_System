<?php
	session_start();
	include('../connect.php');
	$file = $_FILES['attachment_profilepic']['name'];
	$filetype = $_FILES["attachment_profilepic"]["type"];
	$filesize = $_FILES["attachment_profilepic"]["size"];
	$tmp_name = $_FILES["attachment_profilepic"]["tmp_name"];
	if($file != ""){
		if (!file_exists("../../Mall_Attachments/company/" . $_REQUEST["txtcon_compid"]  . "/trades/". $_REQUEST['txtcon_trade'] ."/contact_person/".$_REQUEST["txtcon_id"])) {
			mkdir("../../Mall_Attachments/company/" . $_REQUEST["txtcon_compid"]  . "/trades/". $_REQUEST['txtcon_trade'] ."/contact_person/".$_REQUEST["txtcon_id"], 0777, true);
		}
			move_uploaded_file($tmp_name, "../../Mall_Attachments/company/" . $_REQUEST["txtcon_compid"]  . "/trades/". $_REQUEST['txtcon_trade'] ."/contact_person/".$_REQUEST["txtcon_id"] . "/" . $file);
			$sql = "UPDATE tbltrans_trade_contact_person SET filename = '". $file ."' WHERE TradeID = '".$_REQUEST["txtcon_trade"]."' AND ContactID = '".$_REQUEST["txtcon_id"]."';";
			$result = mysql_query($sql, $connection);
	}		
	mysql_close($connection);
?>