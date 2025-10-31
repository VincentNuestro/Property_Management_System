<?php
	session_start();
	include('../connect.php');
	if (!file_exists("../server/Leads/" . $_REQUEST["frmSubLeadsID"] . "/" . $_REQUEST['frmSubLeadsModuleID'])) {
		mkdir("../server/Leads/" . $_REQUEST["frmSubLeadsID"] . "/" . $_REQUEST['frmSubLeadsModuleID'], 0777, true);
	}
	for ($i= 1; $i <= floatval($_REQUEST['leadsSubLeadsttachmentcount']); $i++) { 
		if($_FILES['leadsattachment'.$i]['name'] != ""){
			$res = mysql_query("INSERT INTO tbltrans_leads_attachments SET SubLeadsID = '". $_REQUEST['frmSubLeadsModuleID'] ."', leadsID = '". $_REQUEST["frmSubLeadsID"] ."', filename = '". $_FILES['leadsattachment'.$i]['name'] ."', filetype = '". $_FILES['leadsattachment'.$i]['type'] ."'", $connection);
			if($res == true){
				move_uploaded_file($_FILES['leadsattachment'.$i]['tmp_name'], "../server/Leads/". $_REQUEST["frmSubLeadsID"] ."/". $_REQUEST['frmSubLeadsModuleID'] . "/" . $_FILES['leadsattachment'.$i]['name']);
			}
		}
	}
	mysql_close($connection);
?>