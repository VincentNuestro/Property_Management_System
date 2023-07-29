<?php
	session_start();
	include('../connect.php');
	if($_REQUEST['txtIRRemarksCode'] != ""){
        $RemarksCode = $_REQUEST['txtIRRemarksCode'];
        $resUpdate = mysql_query("UPDATE tblmaintenance_hrviolatorremarks SET Remarks = '". $_REQUEST['txtIRRemarks'] ."' WHERE RemarksCode = '". $RemarksCode ."' AND VSeriesNumber = '". $_REQUEST['txtIRAttachVSN'] ."' AND Code = '". $_REQUEST['txtIRAttachHRCode'] ."';", $connection);
        if($resUpdate == true){
            echo 3;
            //INSERT LOGS START
            $VioHeader = mysql_fetch_array(mysql_query("SELECT ViolatorID, ViolatorName FROM tblmaintenance_hrviolatorsheader WHERE VSeriesNumber = '". $_REQUEST['txtIRAttachVSN'] ."';", $connection));
            $VioDetails = mysql_fetch_array(mysql_query("SELECT Violation FROM tblmaintenance_hrviolators WHERE Code = '". $_REQUEST['txtIRAttachHRCode'] ."' AND VSeriesNumber = '". $_REQUEST['txtIRAttachVSN'] ."';", $connection));
            $arrHeader = ["Violation Series Number", "Remarks Code", "Tenant ID", "Tenant Name", "Date", "Time", "Violation Status", "Remarks", "Violation"];
            $arrValue = [$_REQUEST['txtIRAttachVSN'], $RemarksCode, $VioHeader['ViolatorID'], $VioHeader['ViolatorName'], date('m/d/Y', strtotime(getsysdate())), date('H:i:s'), $_REQUEST['Status'], $_REQUEST['txtIRRemarks'], "<br/>&emsp;&emsp;&emsp;&emsp;<span class='fa fa-angle-double-right blue'></span>&nbsp;". $_REQUEST['txtIRAttachHRCode'] ."<br/>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Description&nbsp;<span class='fa fa-angle-right blue'></span>&nbsp;". $VioDetails['Violation']];
            $tran_logs = create_logs_per_transaction("updated a violation response.", "Incident Report", createXinfo("INSERT", $arrHeader, "", $arrValue, "", "", ""), "" ,"ADD", $_REQUEST['txtIRAttachVSN']);
            //INSERT LOGS END
        }else{
            echo 4;
        }
    }else{
        $RemarksCode = createidno("RMC", "tblmaintenance_hrviolatorremarks", "RemarksCode");
        $resInsert = mysql_query("INSERT INTO tblmaintenance_hrviolatorremarks SET RemarksCode = '". $RemarksCode ."', VSeriesNumber = '". $_REQUEST['txtIRAttachVSN'] ."', Code = '". $_REQUEST['txtIRAttachHRCode'] ."', Remarks = '". $_REQUEST['txtIRRemarks'] ."', xdatetime = '". date('Y-m-d H:iS') ."';", $connection);
        if($resInsert == true){
            echo 1;
            //INSERT LOGS START
            $VioHeader = mysql_fetch_array(mysql_query("SELECT ViolatorID, ViolatorName FROM tblmaintenance_hrviolatorsheader WHERE VSeriesNumber = '". $_REQUEST['txtIRAttachVSN'] ."';", $connection));
            $VioDetails = mysql_fetch_array(mysql_query("SELECT Violation FROM tblmaintenance_hrviolators WHERE Code = '". $_REQUEST['txtIRAttachHRCode'] ."' AND VSeriesNumber = '". $_REQUEST['txtIRAttachVSN'] ."';", $connection));
            $arrHeader = ["Violation Series Number", "Remarks Code", "Tenant ID", "Tenant Name", "Date", "Time", "Violation Status", "Remarks", "Violation"];
            $arrValue = [$_REQUEST['txtIRAttachVSN'], $RemarksCode, $VioHeader['ViolatorID'], $VioHeader['ViolatorName'], date('m/d/Y', strtotime(getsysdate())), date('H:i:s'), $_REQUEST['Status'], $_REQUEST['txtIRRemarks'], "<br/>&emsp;&emsp;&emsp;&emsp;<span class='fa fa-angle-double-right blue'></span>&nbsp;". $_REQUEST['txtIRAttachHRCode'] ."<br/>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Description&nbsp;<span class='fa fa-angle-right blue'></span>&nbsp;". $VioDetails['Violation']];
            $tran_logs = create_logs_per_transaction("created a violation response.", "Incident Report", createXinfo("INSERT", $arrHeader, "", $arrValue, "", "", ""), "" ,"ADD", $_REQUEST['txtIRAttachVSN']);
            //INSERT LOGS END
        }else{
            echo 2;
        }
    }
    if (!file_exists("../../Mall_Attachments/Incident Reports/". $_REQUEST['txtIRAttachVSN'] ."/". $_REQUEST['txtIRAttachHRCode'] ."/". $RemarksCode)) {
        mkdir("../../Mall_Attachments/Incident Reports/". $_REQUEST['txtIRAttachVSN'] ."/". $_REQUEST['txtIRAttachHRCode'] ."/". $RemarksCode, 0777, true);
    }

	for ($i= 1; $i <= floatval($_REQUEST['txtIRAttachCount']); $i++) { 
		if($_FILES['txtIRImages'.$i]['name'] != ""){
            $arr = explode(".", $_FILES['txtIRImages'.$i]['name']);
            $xDateTime = date('Y-m-d H:i:s');
			$res = mysql_query("INSERT INTO tblmaintenance_hrviolatorremarks_attachment SET RemarksCode = '". $RemarksCode ."', FileName = '". $arr[0] ."', FileType = '". $_FILES['txtIRImages'.$i]['type'] ."', FileType2 = '". end($arr) ."', VSeriesNumber = '". $_REQUEST['txtIRAttachVSN'] ."', Code = '". $_REQUEST['txtIRAttachHRCode'] ."', xdatetime = '". date('Y-m-d H:i:s', strtotime($xDateTime)) ."';", $connection);
			if($res == true){
				move_uploaded_file($_FILES['txtIRImages'.$i]['tmp_name'], "../../Mall_Attachments/Incident Reports/". $_REQUEST['txtIRAttachVSN'] ."/". $_REQUEST['txtIRAttachHRCode'] ."/". $RemarksCode ."/". $arr[0] ." ". date('m.d.Y H.i.s', strtotime($xDateTime)) .".". end($arr));
			}
		}
	}
	mysql_close($connection);
?>