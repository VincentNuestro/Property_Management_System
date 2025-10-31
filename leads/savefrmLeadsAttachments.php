<?php
	session_start();
	include('../connect.php');
	if (!file_exists("../server/Leads/" . $_REQUEST["frmLeadsID"] . "/Attachment")) {
		mkdir("../server/Leads/" . $_REQUEST["frmLeadsID"] . "/Attachment", 0777, true);
	}
	for ($i= 1; $i <= floatval($_REQUEST['leadsattachmentcount']); $i++) { 
		if($_FILES['leadsattachment'.$i]['name'] != ""){

			$res = mysql_query("INSERT INTO tbltrans_leads_attachments SET leadsID = '". $_REQUEST["frmLeadsID"] ."', filename = '". $_FILES['leadsattachment'.$i]['name'] ."', filetype = '". $_FILES['leadsattachment'.$i]['type'] ."'", $connection);
			if($res == true){
				move_uploaded_file($_FILES['leadsattachment'.$i]['tmp_name'], "../server/Leads/". $_REQUEST["frmLeadsID"] ."/Attachment/". $_FILES['leadsattachment'.$i]['name']);
			}
		}
	}
	mysql_close($connection);
?>