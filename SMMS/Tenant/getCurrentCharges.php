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
$startdate = $_POST["startdate"];
$enddate = $_POST["enddate"];
$TenantID = $_POST["TenantID"];
//$appid = $_POST["appid"];
//$appid = "APP-2018-0000001";
$response["all"] = array();

$charges = mysql_query(" SELECT xcode, description, amount, qty, SUM(vatamount + amount) as total, xdate, reference, xdescription 
 FROM dunn_tblsoadetails WHERE xdate BETWEEN '$startdate' AND '$enddate' AND tenantid = '$TenantID' 
 AND paymenttype = '' AND (description LIKE '%Rent%' OR description LIKE '%Association Dues%') 
  AND isMerchant = '0' GROUP BY id");

if (mysql_num_rows($charges) != 0) {

	while($rowItem = mysql_fetch_array($charges)){

				$list = array();
			
				if ($rowItem["xcode"] == "null" || $rowItem["xcode"] == ""){$list["xcode"]	= "";}else{$list["xcode"] = $rowItem["xcode"];}
				if ($rowItem["description"] == "null" || $rowItem["description"] == ""){$list["description"]= "";}else{$list["description"] = $rowItem["description"];}
				
				if ($rowItem["amount"] == "null" || $rowItem["amount"] == ""){$list["amount"]= "";}else{$list["amount"] = $rowItem["amount"];}
				
				if ($rowItem["qty"] == "null" || $rowItem["qty"] == ""){$list["qty"]= "";}else{$list["qty"] = $rowItem["qty"];}
				if ($rowItem["total"] == "null" || $rowItem["total"] == ""){$list["total"]= "";}else{$list["total"] = $rowItem["total"];}
				if ($rowItem["xdate"] == "null" || $rowItem["xdate"] == ""){$list["xdate"]= "";}else{$list["xdate"] = $rowItem["xdate"];}
				if ($rowItem["reference"] == "null" || $rowItem["reference"] == ""){$list["reference"]= "";}else{$list["reference"] = $rowItem["reference"];}
				if ($rowItem["xdescription"] == "null" || $rowItem["xdescription"] == ""){$list["xdescription"]= "";}else{$list["xdescription"] = $rowItem["xdescription"];}

				

				
				array_push($response["all"], $list);
	}
		
		$response["success"] = 1;
}

else {
	$response["success"] = 0;
} 


echo json_encode($response);

?>	

