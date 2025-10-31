<?php
	
	function delTree($dir) {
		$files = array_diff(scandir($dir), array('.','..'));
		foreach ($files as $file) {
			(is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
		}
		return rmdir($dir);
	}

    session_start();
	include "../../../connect.php";
	$file = $_FILES['attachment_profilepic']['name'];
	$filetype = $_FILES["attachment_profilepic"]["type"];
	$filesize = $_FILES["attachment_profilepic"]["size"];
	$tmp_name = $_FILES["attachment_profilepic"]["tmp_name"];
	$title = mysql_fetch_array(mysql_query("SELECT softwaretype FROM tblsys_setup;", $connection));
	if($title[0] == "0"){
		$label =  "Mall";
	}else if($title[0] == "1"){
		$label =  "Property";
	}else if($title[0] == "2"){
		$label =  "Building";
	}
	$CurrentImage = mysql_fetch_array(mysql_query("SELECT code FROM tblref_employee WHERE code = '". $_REQUEST["txtmallid_forms"] ."';", $connection));
	$ext = explode(".", $_FILES["attachment_profilepic"]["name"]);
	if($file != ""){
		delTree("../../../../Mall_Attachments/employee/".$_REQUEST["txtmallid_forms"]);
		$FileName = preg_replace("/[^a-zA-Z0-9]+/", "", $_REQUEST["txtmallid_forms"].date('Y-m-d H:i:s')) . "." . end($ext);
		$result = mysql_query("UPDATE tblref_employee SET ximageid = '". $FileName ."' WHERE code = '". $_REQUEST["txtmallid_forms"] ."';", $connection);
		if($result == true){
			mkdir("../../../../Mall_Attachments/employee/".$_REQUEST["txtmallid_forms"], 0777, true);
			move_uploaded_file($tmp_name, "../../../../Mall_Attachments/employee/".$_REQUEST["txtmallid_forms"]."/". $FileName);
		}
	}
?>