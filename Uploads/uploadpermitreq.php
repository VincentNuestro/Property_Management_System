<?php
	session_start();
	include('../connect.php');
	if (!file_exists("../../Mall_Attachments/Permits/". $_REQUEST["txtPermitInquiryID"])) {
		mkdir("../../Mall_Attachments/Permits/". $_REQUEST["txtPermitInquiryID"], 0777, true);
	}

	$file = $_FILES['attachment_filess']['name'];
	$filetype = $_FILES["attachment_filess"]["type"];
	$filesize = $_FILES["attachment_filess"]["size"];
	$tmp_name = $_FILES["attachment_filess"]["tmp_name"];
		if($file != ""){
			$sel_req = "SELECT DESCRIPTION FROM tblref_typeofpermits WHERE id = '". $_REQUEST["hiddenidss"] ."';";
			$res_req = mysql_query($sel_req, $connection);
			$req = mysql_fetch_array($res_req);
			if (!file_exists("../../Mall_Attachments/Permits/". $_REQUEST["txtPermitInquiryID"]  ."/". $req["DESCRIPTION"])) {
				mkdir("../../Mall_Attachments/Permits/". $_REQUEST["txtPermitInquiryID"]  ."/". $req["DESCRIPTION"], 0777, true);
			}
			move_uploaded_file($tmp_name, "../../Mall_Attachments/Permits/". $_REQUEST["txtPermitInquiryID"] ."/". $req["DESCRIPTION"] ."/". $file);
			$sql = "INSERT INTO tblref_tenantsdocs SET appID = '". $_REQUEST["txtPermitApplicationID"] ."', reqID = '". $_REQUEST["txtPermitInquiryID"] ."', docname = '". $req["DESCRIPTION"] ."', filename = '". $file ."', filetype = '". $filetype ."', filesize = '". $filesize ."', expirydate = '". date('Y-m-d', strtotime($_REQUEST['expiry_date'])) ."', documentid = '". $_REQUEST["hiddenidss"] ."', proposalNum = '". $_REQUEST['txtPermitProposalNum'] ."';";
			$result = mysql_query($sql, $connection);	
			if($result == true){
				$Requirement = mysql_fetch_array(mysql_query("SELECT requirement_list FROM tbltrans_proposal WHERE inquiryID = '". $_REQUEST["txtPermitInquiryID"] ."' AND proposalnum = '". $_REQUEST['txtPermitProposalNum'] ."';", $connection));
				$Permit = mysql_fetch_array(mysql_query("SELECT permit_list FROM tbltrans_proposal WHERE inquiryID = '". $_REQUEST["txtPermitInquiryID"] ."' AND proposalnum = '". $_REQUEST['txtPermitProposalNum'] ."';", $connection));
				$UploadedRequirement = mysql_fetch_array(mysql_query("SELECT COUNT(type_req_ID) FROM tbltrans_leasingapplicationreq WHERE reqID = '". $_REQUEST["txtPermitInquiryID"] ."';", $connection));
				$UploadedPermit = mysql_fetch_array(mysql_query("SELECT COUNT(documentid) FROM tblref_tenantsdocs WHERE reqID = '". $_REQUEST["txtPermitInquiryID"] ."';", $connection));

				if($UploadedRequirement[0] == floatval(COUNT(explode("|", $Requirement[0])) - 1) && $UploadedPermit[0] == floatval(COUNT(explode("|", $Permit[0])) - 1)){
					$resUpdateInquiry = mysql_query("UPDATE tbltrans_inquiry SET req_status = 'Complete' WHERE Inquiry_ID = '". $_REQUEST["txtPermitInquiryID"] ."';", $connection);
				}

			}	
		}
	mysql_close($connection);
?>