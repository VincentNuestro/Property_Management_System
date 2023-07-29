<?php
include("../../android_connect.php");
$response = array();


$response = array();
$validation = $_POST["validation"];


if($validation == "1"){
	$id = $_POST["id"];
	$response["Calendar"] = array();
	$getSelectedDate = mysql_query("Select Date_Entry, Complaint_Status from `tblcomplaints` 
	where TenantID = '$id' Group by Date_Entry order by Date_Entry");
	if(mysql_num_rows($getSelectedDate) <> 0){
		while($row = mysql_fetch_array($getSelectedDate)){	
			$items = array();
			$items["xdate"] = $row["Date_Entry"];
			$items["numberOfTask"] = "0";
			$items["subject"] = $row["Complaint_Status"];
			$items["description"] = "0";
			array_push($response["Calendar"],$items);
		}
		$response["success"] =1;
	}else{
			$items = array();
			$items["xdate"] = "0000-00-00";
			$items["numberOfTask"] = "0";
			$items["subject"] = "";
			$items["description"] = "0";
			array_push($response["Calendar"],$items);
		$response["success"] =2;
	}
}
elseif($validation == "2"){
	
}

	


echo json_encode($response);
?>