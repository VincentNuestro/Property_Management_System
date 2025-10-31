<?php
    session_start();
	include('../connect.php');

	$docname = mysql_fetch_array(mysql_query("SELECT DESCRIPTION FROM tblref_typeofpermits WHERE id = '".$_REQUEST["permitname"]."'", $connection));

	if (!file_exists("../../../Mall_Attachments/Permits/" . $_REQUEST["inqidper"] ."/" . $docname[0])) {
		mkdir("../../Mall_Attachments/Permits/" . $_REQUEST["inqidper"] ."/" . $docname[0], 0777, true);
	}

	$file = $_FILES['permit_upload']['name'];
	$filetype = $_FILES["permit_upload"]["type"];
	$filesize = $_FILES["permit_upload"]["size"];
	$tmp_name = $_FILES["permit_upload"]["tmp_name"];

	$sqlexist = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM tblref_tenantsdocs WHERE filename = '".$file."' AND reqID = '". $_REQUEST["inqidper"] ."' ", $connection));
	if($sqlexist[0] == 0){
		move_uploaded_file($tmp_name, "../../Mall_Attachments/Permits/" . $_REQUEST["inqidper"] . "/" . $docname["DESCRIPTION"] . "/" . $file);
        $getProposal = mysql_fetch_array(mysql_query("SELECT ActiveProposal FROM tbltrans_inquiry WHERE Inquiry_ID = '". $_REQUEST['inqidper'] ."';", $connection));
		$result = mysql_query("INSERT INTO tblref_tenantsdocs SET appID = '". $_REQUEST["appidper"] ."', reqID = '". $_REQUEST["inqidper"] ."', docname = '". $docname["DESCRIPTION"] ."', filename = '". $file ."', filetype = '". $filetype ."', filesize = '". $filesize ."', expirydate = '". date('Y-m-d', strtotime($_REQUEST['permit_expiration'])) ."', documentid = '". $_REQUEST["permitname"] ."', docdesc = '". $_REQUEST['PermitDescription'] ."', proposalNum = '". $getProposal['ActiveProposal'] ."';", $connection);
		$Requirement = mysql_fetch_array(mysql_query("SELECT requirement_list FROM tbltrans_proposal WHERE inquiryID = '". $_REQUEST["inqidper"] ."' AND proposalnum = '". $getProposal['ActiveProposal'] ."';", $connection));
		$Permit = mysql_fetch_array(mysql_query("SELECT permit_list FROM tbltrans_proposal WHERE inquiryID = '". $_REQUEST["inqidper"] ."' AND stats = '1' AND proposalnum = '". $getProposal['ActiveProposal'] ."';", $connection));
		$UploadedRequirement = mysql_fetch_array(mysql_query("SELECT COUNT(type_req_ID) FROM tbltrans_leasingapplicationreq WHERE reqID = '". $_REQUEST["inqidper"] ."';", $connection));
		$UploadedPermit = mysql_fetch_array(mysql_query("SELECT COUNT(documentid) FROM tblref_tenantsdocs WHERE reqID = '". $_REQUEST["inqidper"] ."';", $connection));

		if($UploadedRequirement[0] == floatval(COUNT(explode("|", $Requirement[0])) - 1) && $UploadedPermit[0] == floatval(COUNT(explode("|", $Permit[0])) - 1)){
			$resUpdateInquiry = mysql_query("UPDATE tbltrans_inquiry SET req_status = 'Complete' WHERE Inquiry_ID = '". $_REQUEST["inqidper"] ."';", $connection);
		}
		mysql_close($connection);
		echo "Requirement successfully added.";
	}else{
		echo "Filename already exists.";
	}
?>