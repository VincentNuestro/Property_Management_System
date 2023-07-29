<?php
    session_start();
	include('../connect.php');
	$info = explode("|", $_REQUEST['conbondid']);
	if (!file_exists("../server/Construction Bond/" . $info[1])) {
		mkdir("../server/Construction Bond/" . $info[1], 0777, true);
	}
	$file = $_FILES['conbondupload']['name'];
	$filetype = $_FILES["conbondupload"]["type"];
	$filesize = $_FILES["conbondupload"]["size"];
	$tmp_name = $_FILES["conbondupload"]["tmp_name"];

	if($file != ""){
		$sql = " INSERT INTO tblref_conbond SET TenantID = '". $info[0] ."', filename = '". $file ."', filetype = '". $filetype ."', description = '". $_REQUEST['conbonddesc'] ."', datestart = '". date('Y-m-d', strtotime($_REQUEST['condbonddatefrom'])) ."', enddate = '". date('Y-m-d', strtotime($_REQUEST['condbonddateto'])) ."' ";
		$res = mysql_query($sql, $connection);
		if($res == true){
			move_uploaded_file($tmp_name, "../server/Construction Bond/" . $info[1] . "/". $file);
			echo "1|Construction Bond successfully added.";
		}else{
			echo "3|Failed to add Construction Bond.";
		}
	}else{
		echo "2|Please select a file to upload.";
	}
?>
