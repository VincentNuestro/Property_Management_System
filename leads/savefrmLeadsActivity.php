<?php
	session_start();
include('../connect.php');
	if (!file_exists("../server/Leads/" . $_REQUEST["frmactivityLeadsID"] . "/" . $_REQUEST['frmactivityid'])) {
		mkdir("../server/Leads/" . $_REQUEST["frmactivityLeadsID"] . "/" . $_REQUEST['frmactivityid'], 0777, true);
	}
	for ($i= 1; $i <= floatval($_REQUEST['leadsactivityattachmentcount']); $i++) { 
		if($_FILES['leadsactivityattachment'.$i]['name'] != ""){
			$res = mysql_query("INSERT INTO tbltrans_leads_attachments SET ActivityID = '". $_REQUEST['frmactivityid'] ."', leadsID = '". $_REQUEST["frmactivityLeadsID"] ."', filename = '". $_FILES['leadsactivityattachment'.$i]['name'] ."', filetype = '". $_FILES['leadsactivityattachment'.$i]['type'] ."' ", $connection);
			if($res == true){
				move_uploaded_file($_FILES['leadsactivityattachment'.$i]['tmp_name'], "../server/Leads/". $_REQUEST["frmactivityLeadsID"] ."/". $_REQUEST['frmactivityid'] . "/" . $_FILES['leadsactivityattachment'.$i]['name']);
			}
		}
	}
	mysql_close($connection);
?>