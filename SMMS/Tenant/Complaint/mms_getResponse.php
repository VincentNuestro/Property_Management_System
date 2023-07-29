<?php

include("../../android_connect.php");

$response = array();
$Indicator = $_POST["Indicator"];

$Value = "Response";
if (!file_exists("../../../server/" . $Value)) {
		mkdir("../../../server/".$Value, 0777, true);
}

if ($Indicator == "1"){
	$VSeriesNumber = $_POST["VSeriesNumber"];
	$Code = $_POST["Code"];
	
	$SelectResponse = mysql_query("Select xcomment, images from `tblmaintenance_hrviolatorsresponse`
	where VSeriesNumber = '$VSeriesNumber ' and xcode = '$Code'");
	if(mysql_num_rows($SelectResponse) <> 0){
		$rowItem = mysql_fetch_array($SelectResponse);
		$response["comment"] = $rowItem["xcomment"];
		
			if(empty($rowItem["images"])){
				$response["images"] = "";
			}
			else{	
				$img_name = $rowItem["images"];
				if (false !== ($contents = @file_get_contents('http://localhost/mms_mall/server/Response/'. $VSeriesNumber. '/' . $Code . '/' .$img_name))) {
				$response["images"] = base64_encode(file_get_contents('http://localhost/mms_mall/server/Response/'. $VSeriesNumber. '/' . $Code . '/' .$img_name));
				}
				else{
				$response["images"] = "";
				}
			}

		$response["success"] = 1;	
	}else{
		$response["success"] = 2;			
	}
	
}
else if ($Indicator == "2"){
	$VSeriesNumber = $_POST["VSeriesNumber"];
	$Code = $_POST["Code"];
	$images = $_POST["images"];	
	$Comment = $_POST["Comment"];
	$imagesName = $Code . ".JPG";
	
	if (!file_exists("../../../server/" . $Value . "/" . $VSeriesNumber)) {
		mkdir("../../../server/" . $Value . "/" . $VSeriesNumber, 0777, true);
		//-------------------------------------------------------------------------
		if (!file_exists("../../../server/".$Value."/". $VSeriesNumber. "/". $Code)) {
			mkdir("../../../server/".$Value."/". $VSeriesNumber. "/". $Code, 0777, true);
				if($images != ""){
				$images = str_replace('data:image/png;base64,', '', $images);
				$images = str_replace(' ', '+', $images);
				$data = base64_decode($images);
				file_put_contents("../../../server/" . $Value . "/" . $VSeriesNumber. "/" . $Code . "/" .$imagesName,$data);
				}
		}
		//-------------------------------------------------------------------------
	}
	
	$saveResponse = mysql_query("insert into `tblmaintenance_hrviolatorsresponse` set VSeriesNumber = '$VSeriesNumber', xcode='$Code',
	xcomment='$Comment' , images = '$imagesName'");
	$response["success"] = 1;
}
else if ($Indicator == "3"){
	$VSeriesNumber = $_POST["VSeriesNumber"];
	$Code = $_POST["Code"];
	$images = $_POST["images"];	
	$Comment = $_POST["Comment"];
	$imagesName = $Code . ".JPG";
	
	if (!file_exists("../../../server/" . $Value . "/" . $VSeriesNumber)) {
		mkdir("../../../server/" . $Value . "/" . $VSeriesNumber, 0777, true);
		//-------------------------------------------------------------------------
		if (!file_exists("../../../server/".$Value."/". $VSeriesNumber. "/". $Code)) {
			mkdir("../../../server/".$Value."/". $VSeriesNumber. "/". $Code, 0777, true);
				if($images != ""){
				$images = str_replace('data:image/png;base64,', '', $images);
				$images = str_replace(' ', '+', $images);
				$data = base64_decode($images);
				file_put_contents("../../../server/" . $Value . "/" . $VSeriesNumber. "/" . $Code . "/" .$imagesName,$data);
				}
		}
		//-------------------------------------------------------------------------
	}
	
	$saveResponse = mysql_query("UPDATE `tblmaintenance_hrviolatorsresponse` set xcomment='$Comment' , images = '$imagesName'
	WHERE VSeriesNumber = '$VSeriesNumber' AND xcode = '$Code'");
	$response["success"] = 1;
}
	
echo json_encode($response);
?>	