<?php
    session_start();
	include('../../connect.php');
	mkdir("../../../Mall_Attachments/Unit Image/". $_REQUEST['refunitid'], 0777, true);
	if(is_array($_FILES)){
		foreach ($_FILES['txtUnitImage']['name'] as $image => $value) {
			$file_name = explode(".", $_FILES['txtUnitImage']['name'][$image]);
			$allowed_extension = array("jpg", "jpeg", "png", "gif");
			if(in_array($file_name[1], $allowed_extension)){
				$res = mysql_query("INSERT tblref_unitimage SET UnitID = '". $_REQUEST['refunitid'] ."', ImageName = '". $_FILES['txtUnitImage']['name'][$image] ."';", $connection);
				move_uploaded_file($_FILES['txtUnitImage']['tmp_name'][$image], "../../../Mall_Attachments/Unit Image/". $_REQUEST['refunitid'] ."/". $_FILES['txtUnitImage']['name'][$image]);
			}			
		}
	}
?>