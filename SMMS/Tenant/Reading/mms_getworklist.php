<?php

date_default_timezone_get();
date_default_timezone_set('Asia/Manila');
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));
$connection = mysql_connect('localhost', 'gates', 'g@tes2009');
if (!$connection) {
	die('Could not connect: ' . mysql_error());
}

$db =  mysql_select_db("gates_smm", $connection); //or die("Error on database: " . mysql_error());
mysql_query("SET NAMES 'utf8'");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET COLLATION_CONNECTION = 'utf8_unicode_ci'");

$response = array();
$IDWork = $_POST["IDWork"];
//$IDWork = "JO-0000042";
$response["workorderlist"] = array();

$selectData = mysql_query("SELECT w.workorderid AS id, w.xcategory AS CatCode, w.taskstatus AS Stat, w.meter_reading AS Read1,
w.sub_total AS Total, w.meter_img AS Img, w.reading_date AS Xdate, C.category as CatName, C.icon AS Icon
FROM tblmaintenance_workorderlist W
LEFT JOIN `tblmaintenance_category` C ON W.xcategory = C.category_id
WHERE W.workorderid = '$IDWork'");
if(mysql_num_rows($selectData) <> 0){
	while($rowItem = mysql_fetch_array($selectData)){
	$list = array();
	$list["id"] = isset($rowItem['id']) ? $rowItem['id'] : ""; 
	$list["CatCode"] = isset($rowItem['CatCode']) ? $rowItem['CatCode'] : ""; 
	$list["Stat"] = isset($rowItem['Stat']) ? $rowItem['Stat'] : ""; 
	$list["Read1"] = isset($rowItem['Read1']) ? $rowItem['Read1'] : ""; 
	$list["Total"] = isset($rowItem['Total']) ? $rowItem['Total'] : ""; 
	
			if(empty($rowItem["Img"])){
				$list["Img"] = "";
			}
			else{
				$img_name = $rowItem["Img"];
				if (false !== ($contents = @file_get_contents('http://localhost/mms_mall/'.$img_name))) {
				$list["Img"] = base64_encode(file_get_contents('http://localhost/mms_mall/'.$img_name));
				}
				else{
				$list["Img"] = "";
				}
			}
	
	$list["Xdate"] = isset($rowItem['Xdate']) ? $rowItem['Xdate'] : ""; 	
	$list["CatName"] = isset($rowItem['CatName']) ? $rowItem['CatName'] : ""; 
	
			if(empty($rowItem["Icon"])){
				$list["Icon"] = "";
			}
			else{	
				$img_name = $rowItem["Icon"];
				//echo $img_name;
				if (false !== ($contents = @file_get_contents('http://localhost/mms_mall/server/Maintenance/Category/'.$img_name))) {
				$list["Icon"] = base64_encode(file_get_contents('http://localhost/mms_mall/server/Maintenance/Category/'.$img_name));
				}
				else{
				$list["Icon"] = "";
				}
			}
	
	array_push($response["workorderlist"], $list);
	}
	$response["success"] = 1;
}
else{
	$response["success"] = 2;
}
echo json_encode($response);
?>	