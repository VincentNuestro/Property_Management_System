<?php
	session_start();
	include('../../connect.php');
	if($_REQUEST['AccredLogsID'] == ""){
		if (!file_exists("../../../Mall_Attachments/Accreditation/".$_REQUEST['AccredID'])) {
			mkdir("../../../Mall_Attachments/Accreditation/".$_REQUEST['AccredID'], 0777, true);
		}
		for ($i= 1; $i <= floatval($_REQUEST['AccredDocCount']); $i++) { 
			if($_REQUEST['AccredDocName'.$i] != "" && $_FILES['AccredDoc'.$i]['name'] != ""){
				$ext = explode(".", $_FILES['AccredDoc'.$i]['name']);
				$res = mysql_query("INSERT INTO tblaccreditationdocs SET AccredID = '". $_REQUEST['AccredID'] ."', DocumentName = '". $_REQUEST['AccredDocName'.$i] ."', FileType = '". $_FILES['AccredDoc'.$i]['type'] ."', FileExt = '". end($ext) ."'", $connection);
				$_FILES['AccredDoc'.$i]['name'] = $_REQUEST['AccredDocName'.$i] . "." . end($ext);
				if($res == true){
					move_uploaded_file($_FILES['AccredDoc'.$i]['tmp_name'], "../../../Mall_Attachments/Accreditation/". $_REQUEST["AccredID"] . "/" . $_FILES['AccredDoc'.$i]['name']);
				}
			}
		}
	}else{
		if (!file_exists("../../../Mall_Attachments/Accreditation/".$_REQUEST['AccredID']."/".$_REQUEST['AccredLogsID'])) {
			mkdir("../../../Mall_Attachments/Accreditation/".$_REQUEST['AccredID']."/".$_REQUEST['AccredLogsID'], 0777, true);
		}
		for ($a= 1; $a <= floatval($_REQUEST['AccredDocCount']); $a++) { 
			if($_FILES['AccredDoc'.$a]['name'] != ""){
				$ext = explode(".", $_FILES['AccredDoc'.$a]['name']);
				$res = mysql_query("INSERT INTO tblaccreditationdocs SET AccredID = '". $_REQUEST['AccredID'] ."', AccredLogsID = '". $_REQUEST['AccredLogsID'] ."', DocumentName = '". $_FILES['AccredDoc'.$a]['name'] ."', FileType = '". $_FILES['AccredDoc'.$a]['type'] ."', FileExt = '". end($ext) ."'", $connection);
				if($res == true){
					move_uploaded_file($_FILES['AccredDoc'.$a]['tmp_name'], "../../../Mall_Attachments/Accreditation/". $_REQUEST["AccredID"] ."/".$_REQUEST['AccredLogsID'] . "/" . $_FILES['AccredDoc'.$a]['name']);
				}
			}
		}
	}
	mysql_close($connection);
?>