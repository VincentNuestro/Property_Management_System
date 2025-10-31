<?php
    session_start();
	include('../connect.php');

	$docname = mysql_fetch_array(mysql_query("SELECT requirements FROM tblref_applicationrequirements WHERE id = '". $_REQUEST["docname"] ."' ", $connection));

	if (!file_exists("../../../Mall_Attachments/Requirements/" . $_REQUEST["inqidreq"] . "/". $docname[0])) {
		mkdir("../../Mall_Attachments/Requirements/" . $_REQUEST["inqidreq"] . "/". $docname[0], 0777, true);
	}

	$file = $_FILES['file_uploads']['name'];
	$filetype = $_FILES["file_uploads"]["type"];
	$filesize = $_FILES["file_uploads"]["size"];
	$tmp_name = $_FILES["file_uploads"]["tmp_name"];

	$sqlexist = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM tbltrans_leasingapplicationreq WHERE filename = '".$file."' AND reqID = '". $_REQUEST["inqidreq"] ."' ", $connection));
	if($sqlexist[0] == 0){
		move_uploaded_file($tmp_name, "../../Mall_Attachments/Requirements/" . $_REQUEST["inqidreq"] . "/" .$docname[0] . "/" . $file);
        $getProposal = mysql_fetch_array(mysql_query("SELECT ActiveProposal FROM tbltrans_inquiry WHERE Inquiry_ID = '". $_REQUEST['inqidreq'] ."';", $connection));
		$res = mysql_query("INSERT INTO tbltrans_leasingapplicationreq SET appID = '". $_REQUEST["appidreq"] ."', reqID = '". $_REQUEST["inqidreq"] ."', docname = '". $docname[0] ."', docdesc = '". $_REQUEST["description"] ."', filename = '". $file ."', filetype = '". $filetype ."', filesize = '". $filesize ."', type_req_id = '". $_REQUEST["docname"] ."', proposalNum = '". $getProposal['ActiveProposal'] ."';", $connection);
		$Requirement = mysql_fetch_array(mysql_query("SELECT requirement_list FROM tbltrans_proposal WHERE inquiryID = '". $_REQUEST["inqidreq"] ."' AND proposalnum = '". $getProposal['ActiveProposal'] ."';", $connection));
		$Permit = mysql_fetch_array(mysql_query("SELECT permit_list FROM tbltrans_proposal WHERE inquiryID = '". $_REQUEST["inqidreq"] ."' AND proposalnum = '". $getProposal['ActiveProposal'] ."';", $connection));
		$UploadedRequirement = mysql_fetch_array(mysql_query("SELECT COUNT(type_req_ID) FROM tbltrans_leasingapplicationreq WHERE reqID = '". $_REQUEST["inqidreq"] ."';", $connection));
		$UploadedPermit = mysql_fetch_array(mysql_query("SELECT COUNT(documentid) FROM tblref_tenantsdocs WHERE reqID = '". $_REQUEST["inqidreq"] ."';", $connection));

		if($UploadedRequirement[0] == floatval(COUNT(explode("|", $Requirement[0])) - 1) && $UploadedPermit[0] == floatval(COUNT(explode("|", $Permit[0])) - 1)){
			$resUpdateInquiry = mysql_query("UPDATE tbltrans_inquiry SET req_status = 'Complete' WHERE Inquiry_ID = '". $_REQUEST["inqidreq"] ."';", $connection);
		}

		mysql_close($connection);
		echo "Requirement successfully added.";
	}else{
		echo "Filename already exists.";
	}
?>