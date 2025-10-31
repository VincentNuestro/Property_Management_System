<?php
	session_start();
	include('../connect.php');
	include("../imagescale.php");
		$file = $_FILES['attachment_profilepic']['name'];
		$filetype = $_FILES["attachment_profilepic"]["type"];
		$filesize = $_FILES["attachment_profilepic"]["size"];
		$tmp_name = $_FILES["attachment_profilepic"]["tmp_name"];
			if($file != ""){
				foreach(glob("../../Mall_Attachments/company/" . $_REQUEST["companyID"]  . "/trades/" . $_REQUEST["tradeID"] . "/*.*") as $filename){
				    unlink($filename);
				}
				if (!file_exists("../../Mall_Attachments/company/" . $_REQUEST["companyID"]  . "/trades/".$_REQUEST["tradeID"])) {
					mkdir("../../Mall_Attachments/company/" . $_REQUEST["companyID"]  . "/trades/".$_REQUEST["tradeID"], 0777, true);
					$content = scaleImageFileToBlob($tmp_name);
					file_put_contents("../../Mall_Attachments/company/" . $_REQUEST["companyID"]  . "/trades/" . $_REQUEST["tradeID"] . "/thumb.png",  $content);
				}else{
					$content = scaleImageFileToBlob($tmp_name);
					file_put_contents("../../Mall_Attachments/company/" . $_REQUEST["companyID"]  . "/trades/" . $_REQUEST["tradeID"] . "/thumb.png",  $content);
				}
					move_uploaded_file($tmp_name, "../../Mall_Attachments/company/" . $_REQUEST["companyID"]  . "/trades/". $_REQUEST["tradeID"] . "/" . $file);
					$sql = "UPDATE tbltrans_tradename SET filename = '". $file ."' WHERE companyID = '".$_REQUEST["companyID"]."' AND tradeID = '".$_REQUEST["tradeID"]."'";
					$result = mysql_query($sql, $connection);
			}	
		mysql_close($connection);
?>