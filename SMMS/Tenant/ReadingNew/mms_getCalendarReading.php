<?php
include("../../android_connect.php");
$response = array();

$validation = $_POST["validation"];

$response["Details"] =array();

//$validation = "1";

if($validation == "1"){
	$id = $_POST["id"];		
	//$id = 'TENANT-0000004';
		$SelectCounted = mysql_query("SELECT startdate, workorderid FROM `tblmaintenance_workorder` WHERE TenantID = '$id'
		order by startdate ASC");
		if(mysql_num_rows($SelectCounted) <> 0){
			while($row = mysql_fetch_array($SelectCounted)){
				$list = array();
				//echo " workorderid " . $row["workorderid"];
				$list["xdate"] = $row["startdate"];
				
				$Pending = mysql_fetch_array(mysql_query("SELECT COUNT(C.id) AS Counted
				FROM `tblmaintenance_workorderlist` C
				INNER JOIN `tblmaintenance_workorder` W ON W.`workorderid`= C.`workorderid`
				WHERE W.`startdate` = '".$row["startdate"]."' AND C.`taskstatus` = 'Pending' AND W.TenantID = '$id'"));
				$list["numberOfTask"] = $Pending["Counted"];
				
				$All = mysql_fetch_array(mysql_query("SELECT COUNT(C.id) AS Counted
				FROM `tblmaintenance_workorderlist` C
				INNER JOIN `tblmaintenance_workorder` W ON W.`workorderid`= C.`workorderid`
				WHERE W.`startdate` = '".$row["startdate"]."' AND C.`taskstatus` = 'Resolved' AND W.TenantID = '$id'"));
				
				//echo " Pending " . $Pending["Counted"] . " Counted " . $Pending["Counted"];
				
				if($Pending["Counted"] == "0"){$list["subject"] = "Done";}
				else{
					if($All["Counted"] == "0" && $Pending["Counted"] != "0"){$list["subject"] = "Newly Made";}
					else{$list["subject"] = "Ongoing";}
				}
				
				$list["description"] = "0";
				
				array_push($response["Details"],$list);
			}
			$response["success"] = 1;
		}else{
			$response["success"] = 0;
		}
		
//------------------------------------------------------------------------------------------------------------
}else{
//------------------------------------------------------------------------------------------------------------

//------------------------------------------------------------------------------------------------------------
}
echo json_encode($response);
?>