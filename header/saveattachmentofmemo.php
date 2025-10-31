<?php
	session_start();
	include('../connect.php');
	$MemoID = createidno("MEMO", "tbltrans_memo", "MemoID");
	if (!file_exists("../../Mall_Attachments/Memo Attachments/". $MemoID)) {
		mkdir("../../Mall_Attachments/Memo Attachments/". $MemoID, 0777, true);
	}
	for ($i= 1; $i <= floatval($_REQUEST['attachmentcount']); $i++) { 
		if($_FILES['attachment'.$i]['name'] != ""){
			$res = mysql_query("INSERT INTO tbltrans_memo_attachment SET MemoID = '". $MemoID ."', MemoAttachment = '". $_FILES['attachment'.$i]['name'] ."', filetype = '". $_FILES['attachment'.$i]['type'] ."'", $connection);
			if($res == true){
				move_uploaded_file($_FILES['attachment'.$i]['tmp_name'], "../../Mall_Attachments/Memo Attachments/". $MemoID ."/". $_FILES['attachment'.$i]['name']);
			}
		}
	}
	echo $MemoID;
	mysql_close($connection);
?>