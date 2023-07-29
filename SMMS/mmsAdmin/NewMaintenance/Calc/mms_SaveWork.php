<?php
/*
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
*/
include("../../../android_connect.php");

$response = array();
$UserID = $_POST["UserID"];
$TenantID = $_POST["TenantID"];
$tradename = $_POST["tradename"];
$OwnerName = $_POST["ownerName"];
$UserName;
$xdate = $_POST["xdate"];
$workerid = $_POST["workerid"];
$remarks = $_POST["remarks"];
$startdate = $_POST["startdate"];
$departmentid = $_POST["departmentid"];
$mallid = $_POST["mallid"];

/*
$UserID = "USER-0000002";
$TenantID = "TENANT-0000004";
$tradename = "18 Cakes Takeaway";
$xdate = "2018-12-18";
$workerid = "USER-0000002";
$remarks = "Remark";
$startdate = "2018-18-18";
$departmentid = "0000001";
$mallid = "MALL-0000001";
*/

$valid = 1; // for roll back 
mysql_query('START TRANSACTION' , $connection );
mysql_query('BEGIN' , $connection );		

function addleadingzero_Karl($num){
		$maxid = "";
		$str = strlen($num);
		if($str == 1){ 
			$maxid = "000000" . $num; 
		}else if($str == 2){ 
			$maxid = "00000" . $num; 
		}else if($str == 3){ 
			$maxid = "0000" . $num; 
		}else if($str == 4){ 
			$maxid = "000" . $num; 
		}else if($str == 5){ 
			$maxid = "00" . $num; 
		}else if($str == 6){ 
			$maxid = "0" . $num; 
		}else{ 
			$maxid = $num; 
		}
		return $maxid;
	}
	
function createidno_Karl($tagname, $table, $tblid){
		$myid = "";
		$getmaxno = "SELECT lastid FROM refrecordid WHERE tablename = '" . $table . "'";
		$maxno = mysql_fetch_array(mysql_query($getmaxno));
		$gettblid = "SELECT " . $tblid . " FROM " . $table . " ORDER BY ID DESC LIMIT 0, 1";
		$tblid = mysql_fetch_array(mysql_query($gettblid));
		if($tagname == ""){
			if($maxno[0] == ""){
				if($tblid[0] == ""){ 
					$myid = addleadingzero_Karl("1"); 
				}else{ 
					$myid = addleadingzero_Karl($tblid[0]); 
				}
				$sql = "INSERT INTO refrecordid(tablename, lastid, dateadded) VALUES('" . $table . "', '" . $myid . "', '" . date("Y-m-d") . "')";
				$result = mysql_query($sql);
			}else{
				if(is_numeric($maxno[0])){
					$myid = addleadingzero_Karl($maxno[0]+1);
					$sql = "UPDATE refrecordid SET lastid = '" . $myid . "', dateadded = '" . date("Y-m-d") . "' where tablename = '" . $table . "'";
					$result = mysql_query($sql);
				}else{
					$myid = addleadingzero_Karl("1");
					$sql = "INSERT INTO refrecordid(tablename, lastid, dateadded) VALUES('" . $table . "', '" . $myid . "', '" . date("Y-m-d") . "')";
					$result = mysql_query($sql);
				}
			}
		}else{
			if($maxno[0] == ""){
				if($tblid[0] == ""){ 
					$myid = $tagname . "-" . addleadingzero_Karl("1"); 
				}else{
					if(is_numeric($tblid[0])){
						$myarr = explode("-", $tblid[0]);
						$myid = $tagname . "-" . addleadingzero_Karl($myarr[1]);
					}else{ 
						$myid = $tagname . "-" . addleadingzero_Karl("1"); 
					}
				}
				$sql = "INSERT INTO refrecordid(tablename, lastid, dateadded) VALUES('" . $table . "', '" . $myid . "', '" . date("Y-m-d") . "')";
				$result = mysql_query($sql);
			}else{
				$arr = explode("-", $maxno[0]);
				if(is_numeric(end($arr))){
					$myid = $tagname . "-" . addleadingzero_Karl(end($arr)+1);
					$sql = "UPDATE refrecordid SET lastid = '" . $myid . "', dateadded = '" . date("Y-m-d") . "' where tablename = '" . $table . "'";
					$result = mysql_query($sql);
				}else{
					$myid = $tagname . "-" . addleadingzero_Karl("1");
					$sql = "INSERT INTO refrecordid(tablename, lastid, dateadded) VALUES('" . $table . "', '" . $myid . "', '" . date("Y-m-d") . "')";
					$result = mysql_query($sql);
				}
			}
		}
		return $myid;
	}
	
$logID = createidno_Karl("JO", "tblmaintenance_workorder", "logID");

$SelectOwner = mysql_query ("select CONCAT(owner_firstname, ' ', owner_lastname)  as newName from `tbltrans_tenants`
WHERE TenantID = '$TenantID'");
if(mysql_num_rows($SelectOwner) <> 0){
	$rowItem = mysql_fetch_array($SelectOwner);
	$OwnerName = $rowItem["newName"];
}else{$OwnerName="";}

$SelectUser = mysql_query("SELECT CONCAT(firstname, ' ', lastname)  AS UserName FROM  `tbluser`
WHERE userid = '$UserID'");
if(mysql_num_rows($SelectUser) <> 0){
	$rowItem = mysql_fetch_array($SelectUser);
	$UserName = $rowItem["UserName"];
}else{$UserName="";}

$InsertWorkOrder = "insert into `tblmaintenance_workorder` set workorderid = '$logID', TenantID = '$TenantID',
ownername = '$OwnerName', tradename = '$tradename', xdate = '".getsysdate()."', 
remarks = '$remarks', departmentid = '$departmentid', mallid = '$mallid', xtime ='".date('H:i:s')."', startdate = '$startdate', starttime = '".date('H:i:s')."'";
mysql_query( $InsertWorkOrder , $connection ) or $valid = 0;


//for rollback				
if( $valid == 0 ) {
	mysql_query('ROLBACK',$connection);
		$response["success"] = 2;
} else {
	mysql_query('COMMIT',$connection);
		$response["success"] = 1;
		$response["WorkOrderID"] = $logID;
}
echo json_encode($response);
?>	