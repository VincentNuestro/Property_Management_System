<?php  
	session_start();
	include("../connect.php");
	switch ($_POST['form']) {
		case 'saveFilters':
	      	$num = mysql_num_rows(mysql_query("SELECT id FROM tblref_filters WHERE module = '".$_POST["module"]."' AND userid = '". $_SESSION['MMS-UserID'] ."'", $connection));
	      	if($num == 0){
	        	$sql = "INSERT INTO tblref_filters SET module = '". $_POST['module'] ."', checked_value = '". $_POST['checked'] ."', filters = '". $_POST['checked2'] ."', datefilter = '". $_POST["Date1"]."|".$_POST["Date2"]."|".$_POST["Date3"]."|".$_POST["Date4"]."|".$_POST["Date5"]."|".$_POST["Date6"]."|".$_POST["Date7"]."|".$_POST["Date8"] ."', bystat = '". $_POST['checked3'] ."', xcheck = '". $_POST['xcheck'] ."', userid = '". $_SESSION['MMS-UserID'] ."';";
	      	}else{	
        		$sql = "UPDATE tblref_filters SET checked_value = '". $_POST['checked'] ."', filters = '". $_POST['checked2'] ."', datefilter = '". $_POST["Date1"]."|".$_POST["Date2"]."|".$_POST["Date3"]."|".$_POST["Date4"]."|".$_POST["Date5"]."|".$_POST["Date6"]."|".$_POST["Date7"]."|".$_POST["Date8"] ."', bystat = '". $_POST['checked3'] ."', xcheck = '". $_POST['xcheck'] ."' WHERE module = '".$_POST["module"]."' AND userid = '". $_SESSION['MMS-UserID'] ."';";
	      	}
	      	$res = mysql_query($sql, $connection);
	        if($res == true){
	          	echo 1;
	        }  
		break;

		case 'loadFilters':
			$sql = "SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = '".$_POST["module"]."' AND userid = '". $_SESSION['MMS-UserID'] ."';";
			$result = mysql_query($sql, $connection);
			$row = mysql_fetch_array($result);

			echo $row["checked_value"] . "#" . $row["datefilter"] . "#" . $row["bystat"] . "#" . $row["xcheck"];
		break;
	}
?>