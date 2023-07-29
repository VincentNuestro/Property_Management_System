<?php
	session_start();
	include "../../../connect.php";
	switch ($_POST['form']) {
		case 'fncManpowerList':
			$page = $_POST['page'];
			$limit = ($page-1) * 20;
			$resManpower = mysql_query("SELECT ManpowerCode, ManpowerDesc, Amount FROM tblref_Manpower WHERE ManpowerCode LIKE '%". $_POST['key'] ."%' OR ManpowerDesc LIKE '%". $_POST['key'] ."%' GROUP BY ManpowerCode ORDER BY ". $_POST['ManpowerSortBy'] ." ". $_POST['ManpowerSortType'] ." LIMIT ". $limit .",20;", $connection) or die(mysql_error());
			while($rowManpower = mysql_fetch_array($resManpower)){
				echo 	"<tr id='". $rowManpower['ManpowerCode'] ."'>
							<td>". $rowManpower['ManpowerCode'] ."</td>
							<td>". $rowManpower['ManpowerDesc'] ."</td>
							<td style='text-align: right;'>". number_format($rowManpower['Amount'], 2, '.', ',') ."</td>
						</tr>";
			}
		break;

		case 'loadEntriesManpower':
			if($_POST["page"] == ""){
	            $page = 1;
	        }else{
	            $page = $_POST["page"];
	        }
    		$limit = ($page-1) * 20;
            $rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM tblref_Manpower WHERE ManpowerCode LIKE '%". $_POST['key'] ."%' OR ManpowerDesc LIKE '%". $_POST['key'] ."%';", $connection));
            $rowsperpage = 20;
            $totalpages = ceil($rowCount[0] / $rowsperpage);
            $upto = $limit + 20;
            $from = $limit + 1;
            if($page == $totalpages && $rowCount[0] != 0){
                echo "Showing " . $from . " to " . $rowCount[0] . " of " . $rowCount[0] . " entries";
            }else{
             	if($rowCount[0] == 0){
               		echo "";
              	}else if($rowCount[0] <= 19 && $rowCount[0] != 0){
               		echo "Showing 1 to " . $rowCount[0] . " of " . $rowCount[0] . " entries";
              	}else if($rowCount[0] >= 20 && $rowCount[0] != 0){
               		echo "Showing " . $from . " to " . $upto . " of " . $rowCount[0] . " entries";
              	}
            }
       	break;

		case "loadPageManpower":
			$page = $_POST["page"];
			$rowCount = mysql_fetch_row(mysql_query("SELECT COUNT(id) FROM tblref_Manpower WHERE ManpowerCode LIKE '%". $_POST['key'] ."%' OR ManpowerDesc LIKE '%". $_POST['key'] ."%';", $connection));
			$rowsperpage = 20;
			$range = 1;
			$totalpages = ceil($rowCount[0] / $rowsperpage);
			$prevpage;
			$nextpage;
			// if not on page 1, don't show back links
			if($page > 1 ){
			   	echo "<li style='width:50px !important;' onclick='fncPageManpower(1)'><< First</li>";
			   	$prevpage = $page - 1;
			   	echo "<li style='width:70px !important;' onclick='fncPageManpower(". $prevpage .")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if(($x > 0) && ($x <= $totalpages)){
    			    if($x == $page){
                        echo "<li id='pgManpower" . $x . "' class='pgnumManpower active' onclick='fncPageManpower(" . $x . ",". $x .")'>" . $x . "</li>";
                    }else{
    			        echo "<li id='pgManpower" . $x . "' class='pgnumManpower' onclick='fncPageManpower(" . $x . ",". $x .")'>" . $x . "</li>";
                    }
		       	}
		    }
		    if($page < ($totalpages - $range)){
                echo "<li>...</li>";
            }
		    if($page != $totalpages && $rowCount[0] != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='fncPageManpower(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='fncPageManpower(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'fncSaveManpower':
			//INSERT LOG FIRST - JONAS - 12/5/2018
			$arrHeader = ["Manpower Code", "Manpower", "Amount"];
			$arrValue = [$_POST['Code'], $_POST['Manpower'], number_format($_POST['Amount'], 2, '.', ',')];
			$Logs = createXinfo("INSERT", $arrHeader, "", $arrValue, "", "", "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("added a new Manpower referential.", "Referential Module", $Logs, "" ,"ADD", "");
			}
			//INSERT LOG FIRST - JONAS - 12/5/2018
			$CheckExisting = mysql_num_rows(mysql_query("SELECT ManpowerCode FROM tblref_Manpower WHERE ManpowerCode = '". $_POST['Code'] ."';", $connection));
			if($CheckExisting == 0){
				$resInsertManpower = mysql_query("INSERT INTO tblref_Manpower SET ManpowerCode = '". mysql_escape_string(strtoupper($_POST['Code'])) ."', ManpowerDesc = '". mysql_escape_string(ucfirst($_POST['Manpower'])) ."', Amount = '". floatval($_POST['Amount']) ."';", $connection);
				if($resInsertManpower == true){
					echo 1;
					//forAccIntegration($_POST['Code'], $_POST['Manpower'], "", "INSERT");
				}
			}else{
				echo "Manpower code already exist.";
			}
		break;

		case 'fncManpowerSelected':
			$ManpowerInfo = mysql_fetch_array(mysql_query("SELECT ManpowerDesc, Amount, id FROM tblref_Manpower WHERE ManpowerCode = '". $_POST['id'] ."';", $connection));
			echo $ManpowerInfo['ManpowerDesc'] . "|" . number_format($ManpowerInfo['Amount'], 2, '.', ',') . "|" . $ManpowerInfo['id'];
		break;

		case 'fncUpdateManpower':
			//INSERT UPDATE LOG FIRST - JONAS - 12/5/2018
			$arrHeader = ["Manpower Code", "Manpower", "Amount"];
			$arrFields = ["ManpowerCode", "ManpowerDesc", "Amount"];
			$arrValue = [$_POST['Code'], $_POST['Manpower'], number_format($_POST['Amount'], 2, '.', ',')];
			$Logs = createXinfo("UPDATE", $arrHeader, $arrFields, $arrValue, "tblref_Manpower", $_POST['ManpowerID'], "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("modified a ound System & Personnel referential.", "Referential Module", $Logs, "" ,"UPDATE", "");
			}
			//INSERT UPDATE LOG FIRST - JONAS - 12/5/2018
			$CurrCode = mysql_fetch_array(mysql_query("SELECT ManpowerCode FROM tblref_Manpower WHERE id = '". $_POST['ManpowerID'] ."';", $connection));
			$resUpdate = mysql_query("UPDATE tblref_Manpower SET ManpowerCode = '". mysql_escape_string(strtoupper($_POST['Code'])) ."', ManpowerDesc = '". mysql_escape_string(ucfirst($_POST['Manpower'])) ."', Amount = '". floatval($_POST['Amount']) ."' WHERE id = '". $_POST['ManpowerID'] ."';", $connection);
			if($resUpdate == true){
				echo 1;
				//forAccIntegration($_POST['Code'], $_POST['Manpower'], $CurrCode[0], "UPDATE");
			}
		break;

		case 'fncClickDeleteManpower':
			//INSERT DELETE LOG FIRST - JONAS - 12/5/2018
			$arrHeader = ["Manpower Code", "Manpower", "Amount"];
			$arrFields = ["ManpowerCode", "ManpowerDesc", "Amount"];
			$Logs = createXinfo("DELETE", $arrHeader, $arrFields, "", "tblref_Manpower", $_POST['Code'], "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("deleted a Manpower referential.", "Referential Module", $Logs, "", "DELETE", "");
			}
			//INSERT DELETE LOG FIRST - JONAS - 12/5/2018
			$resDelete = mysql_query("DELETE FROM tblref_Manpower WHERE id = '". $_POST['Code'] ."';", $connection);
			if($resDelete == true){
				echo 1;
				//forAccIntegration($_POST['Code'], "", "", "DELETE");
			}
		break;

		case 'fncClickUpdateManpower':
			$row = mysql_fetch_array(mysql_query("SELECT COUNT(xcode) FROM tbltransaction WHERE xcode = '". $_POST['Code'] ."' AND isPenalty = '1';", $connection));
			if($row[0] >= 1){
				echo 1;
			}else{
				echo 0;
			}
		break;

		// xmer 09162019
		case 'AutoConsolidateManpower':
			$Penalty = "SELECT ManpowerCode, ManpowerDesc, Amount FROM tblref_Manpower WHERE ManpowerCode LIKE '%". $_POST['key'] ."%' OR ManpowerDesc LIKE '%". $_POST['key'] ."%' ORDER BY ManpowerDesc ASC ";
			$resclassification = mysql_query($Penalty, $connection);
			$data = "Code,Description,Amount\r\n";
			while($rowclassification = mysql_fetch_array($resclassification)){
				$data .= $rowclassification[0].",".$rowclassification[1].",".$rowclassification[2]."\r\n";
			}
			$filepath = mysql_fetch_array(mysql_query("SELECT filepath FROM tblsys_setup", $connection));
			$syspath = str_replace("\\", "/", $filepath[0]);
			if (!file_exists($syspath)){
				mkdir($syspath, 0777, true);
			}
			$file = $syspath."Manpower_".date('mdY').".csv";
			chmod($file, 0777);
			if (file_put_contents($file, $data)){
				create_logs_per_transaction('exported a referential to excel', 'Manpower', '', '', 'EXPORT', '');
				echo 1;
			}else{
				echo 0;
			}
		break;
		// xmer 09162019
	}
?>