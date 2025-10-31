<?php
	session_start();
	include('../connect.php');
	if (!file_exists("../../Mall_Attachments/Requirements/". $_REQUEST["txtRequirementInquiryID"])) {
		mkdir("../../Mall_Attachments/Requirements/". $_REQUEST["txtRequirementInquiryID"], 0777, true);
	}
	$file = $_FILES['attachment_filess']['name'];
	$filetype = $_FILES["attachment_filess"]["type"];
	$filesize = $_FILES["attachment_filess"]["size"];
	$tmp_name = $_FILES["attachment_filess"]["tmp_name"];
		if($file != ""){
			$req = mysql_fetch_array(mysql_query("SELECT requirements FROM tblref_applicationrequirements WHERE id = '". $_REQUEST["hiddenidss"] ."';", $connection));
			if (!file_exists("../../Mall_Attachments/Requirements/". $_REQUEST["txtRequirementInquiryID"]  ."/". $req["requirements"])) {
				mkdir("../../Mall_Attachments/Requirements/". $_REQUEST["txtRequirementInquiryID"] ."/". $req["requirements"], 0777, true);
			}
			move_uploaded_file($tmp_name, "../../Mall_Attachments/Requirements/". $_REQUEST["txtRequirementInquiryID"] ."/". $req["requirements"] ."/". $file);
			$result = mysql_query("INSERT INTO tbltrans_leasingapplicationreq (appID ,reqID, filename, filetype, filesize, type_req_ID, proposalNum)VALUES('". $_REQUEST["txtRequirementApplicationID"] ."', '". $_REQUEST["txtRequirementInquiryID"] ."', '". $file ."', '". $filetype ."', '". $filesize ."', '". $_REQUEST["hiddenidss"] ."', '". $_REQUEST['txtProposalNum'] ."');", $connection);
			if($result == true){

				$Requirement = mysql_fetch_array(mysql_query("SELECT requirement_list FROM tbltrans_proposal WHERE inquiryID = '". $_REQUEST["txtRequirementInquiryID"] ."' AND proposalnum = '". $_REQUEST['txtProposalNum'] ."';", $connection));
				$Permit = mysql_fetch_array(mysql_query("SELECT permit_list FROM tbltrans_proposal WHERE inquiryID = '". $_REQUEST["txtRequirementInquiryID"] ."' AND proposalnum = '". $_REQUEST['txtProposalNum'] ."';", $connection));
				$UploadedRequirement = mysql_fetch_array(mysql_query("SELECT COUNT(type_req_ID) FROM tbltrans_leasingapplicationreq WHERE reqID = '". $_REQUEST["txtRequirementInquiryID"] ."';", $connection));
				$UploadedPermit = mysql_fetch_array(mysql_query("SELECT COUNT(documentid) FROM tblref_tenantsdocs WHERE reqID = '". $_REQUEST["txtRequirementInquiryID"] ."';", $connection));

				if($UploadedRequirement[0] == floatval(COUNT(explode("|", $Requirement[0])) - 1) && $UploadedPermit[0] == floatval(COUNT(explode("|", $Permit[0])) - 1)){
					$resUpdateInquiry = mysql_query("UPDATE tbltrans_inquiry SET req_status = 'Complete' WHERE Inquiry_ID = '". $_REQUEST["txtRequirementInquiryID"] ."';", $connection);
				}

			}
		}
	mysql_close($connection);
?>