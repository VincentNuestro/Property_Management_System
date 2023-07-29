<?php
	session_start();
	include('../connect.php');
	if($_REQUEST['txtIRRespoCode'] != ""){
        $ResponseCode = $_REQUEST['txtIRRespoCode'];
        $resUpdate = mysql_query("UPDATE tblmaintenance_hrviolatorsresponse SET Resolution = '". $_REQUEST['modaltxtReso'] ."' WHERE ResponseCode = '". $ResponseCode ."' AND VSeriesNumber = '". $_REQUEST['txtIRAttachVSNRes'] ."' AND Code = '". $_REQUEST['txtIRAttachHRCodeRes'] ."';", $connection);
        if($resUpdate == true){
            echo 3;
            //INSERT LOGS START
            $VioHeader = mysql_fetch_array(mysql_query("SELECT ViolatorID, ViolatorName FROM tblmaintenance_hrviolatorsheader WHERE VSeriesNumber = '". $_REQUEST['txtIRAttachVSNRes'] ."';", $connection));
            $VioDetails = mysql_fetch_array(mysql_query("SELECT Violation FROM tblmaintenance_hrviolators WHERE Code = '". $_REQUEST['txtIRAttachHRCodeRes'] ."' AND VSeriesNumber = '". $_REQUEST['txtIRAttachVSNRes'] ."';", $connection));
            $arrHeader = ["Violation Series Number", "Response Code", "Tenant ID", "Tenant Name", "Date", "Time", "Violation Status", "Response", "Violation"];
            $arrValue = [$_REQUEST['txtIRAttachVSNRes'], $ResponseCode, $VioHeader['ViolatorID'], $VioHeader['ViolatorName'], date('m/d/Y', strtotime(getsysdate())), date('H:i:s'), $_REQUEST['Status'], $_REQUEST['modaltxtReso'], "<br/>&emsp;&emsp;&emsp;&emsp;<span class='fa fa-angle-double-right blue'></span>&nbsp;". $_REQUEST['txtIRAttachHRCodeRes'] ."<br/>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Description&nbsp;<span class='fa fa-angle-right blue'></span>&nbsp;". $VioDetails['Violation']];
            $tran_logs = create_logs_per_transaction("updated a violation remarks.", "Incident Report", createXinfo("INSERT", $arrHeader, "", $arrValue, "", "", ""), "" ,"ADD", $_REQUEST['txtIRAttachVSNRes']);
            //INSERT LOGS END
        }else{
            echo 4;
        }
    }else{
        $ResponseCode = createidno("RSC", "tblmaintenance_hrviolatorsresponse", "ResponseCode");
        $resInsert = mysql_query("INSERT INTO tblmaintenance_hrviolatorsresponse SET ResponseCode = '". $ResponseCode ."', VSeriesNumber = '". $_REQUEST['txtIRAttachVSNRes'] ."', Code = '". $_REQUEST['txtIRAttachHRCodeRes'] ."', Resolution = '". $_REQUEST['modaltxtReso'] ."', xdatetime = '". date('Y-m-d H:iS') ."';", $connection);
        if($resInsert == true){
            echo 1;
            //INSERT LOGS START
            $VioHeader = mysql_fetch_array(mysql_query("SELECT ViolatorID, ViolatorName FROM tblmaintenance_hrviolatorsheader WHERE VSeriesNumber = '". $_REQUEST['txtIRAttachVSNRes'] ."';", $connection));
            $VioDetails = mysql_fetch_array(mysql_query("SELECT Violation FROM tblmaintenance_hrviolators WHERE Code = '". $_REQUEST['txtIRAttachHRCodeRes'] ."' AND VSeriesNumber = '". $_REQUEST['txtIRAttachVSNRes'] ."';", $connection));
            $arrHeader = ["Violation Series Number", "Response Code", "Tenant ID", "Tenant Name", "Date", "Time", "Violation Status", "Response", "Violation"];
            $arrValue = [$_REQUEST['txtIRAttachVSNRes'], $ResponseCode, $VioHeader['ViolatorID'], $VioHeader['ViolatorName'], date('m/d/Y', strtotime(getsysdate())), date('H:i:s'), $_REQUEST['Status'], $_REQUEST['modaltxtReso'], "<br/>&emsp;&emsp;&emsp;&emsp;<span class='fa fa-angle-double-right blue'></span>&nbsp;". $_REQUEST['txtIRAttachHRCodeRes'] ."<br/>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Description&nbsp;<span class='fa fa-angle-right blue'></span>&nbsp;". $VioDetails['Violation']];
            $tran_logs = create_logs_per_transaction("created a violation remarks.", "Incident Report", createXinfo("INSERT", $arrHeader, "", $arrValue, "", "", ""), "" ,"ADD", $_REQUEST['txtIRAttachVSNRes']);
            //INSERT LOGS END
        }else{
            echo 2;
        }
    }
    if (!file_exists("../../Mall_Attachments/Incident Reports/". $_REQUEST['txtIRAttachVSNRes'] ."/". $_REQUEST['txtIRAttachHRCodeRes'] ."/". $ResponseCode)) {
        mkdir("../../Mall_Attachments/Incident Reports/". $_REQUEST['txtIRAttachVSNRes'] ."/". $_REQUEST['txtIRAttachHRCodeRes'] ."/". $ResponseCode, 0777, true);
    }

	for ($i= 1; $i <= floatval($_REQUEST['txtIRAttachCountRes']); $i++) { 
		if($_FILES['txtIRImages'.$i]['name'] != ""){
            $arr = explode(".", $_FILES['txtIRImages'.$i]['name']);
            $xDateTime = date('Y-m-d H:i:s');
			$res = mysql_query("INSERT INTO tblmaintenance_hrviolatorsresponse_attachment SET ResponseCode = '". $ResponseCode ."', FileName = '". $arr[0] ."', FileType = '". $_FILES['txtIRImages'.$i]['type'] ."', FileType2 = '". end($arr) ."', VSeriesNumber = '". $_REQUEST['txtIRAttachVSNRes'] ."', Code = '". $_REQUEST['txtIRAttachHRCodeRes'] ."', xdatetime = '". date('Y-m-d H:i:s', strtotime($xDateTime)) ."';", $connection);
			if($res == true){
				move_uploaded_file($_FILES['txtIRImages'.$i]['tmp_name'], "../../Mall_Attachments/Incident Reports/". $_REQUEST['txtIRAttachVSNRes'] ."/". $_REQUEST['txtIRAttachHRCodeRes'] ."/". $ResponseCode ."/". $arr[0] ." ". date('m.d.Y H.i.s', strtotime($xDateTime)) .".". end($arr));
			}
		}
	}
	mysql_close($connection);
?>