<?php
	session_start();
	include "../../../connect.php";
	switch ($_POST['form']) {
		case 'fncPenaltyList':
			$page = $_POST['page'];
			$limit = ($page-1) * 20;
			$resPenalty = mysql_query("SELECT PenaltyCode, PenaltyDesc, Amount FROM tblref_penalty WHERE PenaltyCode LIKE '%". $_POST['key'] ."%' OR PenaltyDesc LIKE '%". $_POST['key'] ."%' GROUP BY PenaltyCode ORDER BY ". $_POST['othPenaltySortBy'] ." ". $_POST['othPenaltySortType'] ." LIMIT ". $limit .",20;", $connection);
			while($rowPenalty = mysql_fetch_array($resPenalty)){
				echo 	"<tr id='". $rowPenalty['PenaltyCode'] ."'>
							<td>". $rowPenalty['PenaltyCode'] ."</td>
							<td>". $rowPenalty['PenaltyDesc'] ."</td>
							<td style='text-align: right;'>". number_format($rowPenalty['Amount'], 2, '.', ',') ."</td>
						</tr>";
			}
		break;

		case 'loadEntriesPenalty':
			if($_POST["page"] == ""){
	            $page = 1;
	        }else{
	            $page = $_POST["page"];
	        }
    		$limit = ($page-1) * 20;
            $rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM tblref_penalty WHERE PenaltyCode LIKE '%". $_POST['key'] ."%' OR PenaltyDesc LIKE '%". $_POST['key'] ."%';", $connection));
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

		case "loadPagePenalty":
			$page = $_POST["page"];
			$rowCount = mysql_fetch_row(mysql_query("SELECT COUNT(id) FROM tblref_penalty WHERE PenaltyCode LIKE '%". $_POST['key'] ."%' OR PenaltyDesc LIKE '%". $_POST['key'] ."%';", $connection));
			$rowsperpage = 20;
			$range = 1;
			$totalpages = ceil($rowCount[0] / $rowsperpage);
			$prevpage;
			$nextpage;
			// if not on page 1, don't show back links
			if($page > 1 ){
			   	echo "<li style='width:50px !important;' onclick='fncPagePenalty(1)'><< First</li>";
			   	$prevpage = $page - 1;
			   	echo "<li style='width:70px !important;' onclick='fncPagePenalty(". $prevpage .")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if(($x > 0) && ($x <= $totalpages)){
    			    if($x == $page){
                        echo "<li id='pgPenalty" . $x . "' class='pgnumPenalty active' onclick='fncPagePenalty(" . $x . ",". $x .")'>" . $x . "</li>";
                    }else{
    			        echo "<li id='pgPenalty" . $x . "' class='pgnumPenalty' onclick='fncPagePenalty(" . $x . ",". $x .")'>" . $x . "</li>";
                    }
		       	}
		    }
		    if($page < ($totalpages - $range)){
                echo "<li>...</li>";
            }
		    if($page != $totalpages && $rowCount[0] != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='fncPagePenalty(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='fncPagePenalty(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'fncSavePenalty':
			//INSERT LOG FIRST - JONAS - 12/5/2018
			$arrHeader = ["Penalty Code", "Penalty", "Amount"];
			$arrValue = [$_POST['Code'], $_POST['Penalty'], number_format($_POST['Amount'], 2, '.', ',')];
			$Logs = createXinfo("INSERT", $arrHeader, "", $arrValue, "", "", "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("added a new penalty referential.", "Referential Module", $Logs, "" ,"ADD", "");
			}
			//INSERT LOG FIRST - JONAS - 12/5/2018
			$CheckExisting = mysql_num_rows(mysql_query("SELECT PenaltyCode FROM tblref_penalty WHERE PenaltyCode = '". $_POST['Code'] ."';", $connection));
			if($CheckExisting == 0){
				$resInsertPenalty = mysql_query("INSERT INTO tblref_penalty SET PenaltyCode = '". mysql_escape_string(strtoupper($_POST['Code'])) ."', PenaltyDesc = '". mysql_escape_string(ucfirst($_POST['Penalty'])) ."', Amount = '". floatval($_POST['Amount']) ."';", $connection);
				if($resInsertPenalty == true){
					echo 1;
					forAccIntegration($_POST['Code'], $_POST['Penalty'], "", "INSERT");
				}
			}else{
				echo "Penalty code already exist.";
			}
		break;

		case 'fncPenaltySelected':
			$PenaltyInfo = mysql_fetch_array(mysql_query("SELECT PenaltyDesc, Amount, id FROM tblref_penalty WHERE PenaltyCode = '". $_POST['id'] ."';", $connection));
			echo $PenaltyInfo['PenaltyDesc'] . "|" . number_format($PenaltyInfo['Amount'], 2, '.', ',') . "|" . $PenaltyInfo['id'];
		break;

		case 'fncUpdatePenalty':
			//INSERT UPDATE LOG FIRST - JONAS - 12/5/2018
			$arrHeader = ["Penalty Code", "Penalty", "Amount"];
			$arrFields = ["PenaltyCode", "PenaltyDesc", "Amount"];
			$arrValue = [$_POST['Code'], $_POST['Penalty'], number_format($_POST['Amount'], 2, '.', ',')];
			$Logs = createXinfo("UPDATE", $arrHeader, $arrFields, $arrValue, "tblref_penalty", $_POST['PenaltyID'], "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("modified a penalty referential.", "Referential Module", $Logs, "" ,"UPDATE", "");
			}
			//INSERT UPDATE LOG FIRST - JONAS - 12/5/2018
			$CurrCode = mysql_fetch_array(mysql_query("SELECT PenaltyCode FROM tblref_penalty WHERE id = '". $_POST['PenaltyID'] ."';", $connection));
			$resUpdate = mysql_query("UPDATE tblref_penalty SET PenaltyCode = '". mysql_escape_string(strtoupper($_POST['Code'])) ."', PenaltyDesc = '". mysql_escape_string(ucfirst($_POST['Penalty'])) ."', Amount = '". floatval($_POST['Amount']) ."' WHERE id = '". $_POST['PenaltyID'] ."';", $connection);
			if($resUpdate == true){
				echo 1;
				forAccIntegration($_POST['Code'], $_POST['Penalty'], $CurrCode[0], "UPDATE");
			}
		break;

		case 'fncClickDeletePenalty':
			//INSERT DELETE LOG FIRST - JONAS - 12/5/2018
			$arrHeader = ["Penalty Code", "Penalty", "Amount"];
			$arrFields = ["PenaltyCode", "PenaltyDesc", "Amount"];
			$Logs = createXinfo("DELETE", $arrHeader, $arrFields, "", "tblref_penalty", $_POST['Code'], "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("deleted a penalty referential.", "Referential Module", $Logs, "", "DELETE", "");
			}
			//INSERT DELETE LOG FIRST - JONAS - 12/5/2018
			$resDelete = mysql_query("DELETE FROM tblref_penalty WHERE id = '". $_POST['Code'] ."';", $connection);
			if($resDelete == true){
				echo 1;
				forAccIntegration($_POST['Code'], "", "", "DELETE");
			}
		break;

		case 'fncClickUpdatePenalty':
			$row = mysql_fetch_array(mysql_query("SELECT COUNT(xcode) FROM tbltransaction WHERE xcode = '". $_POST['Code'] ."' AND isPenalty = '1';", $connection));
			if($row[0] >= 1){
				echo 1;
			}else{
				echo 0;
			}
		break;

		// xmer 09162019
		case 'AutoConsolidatePenalty':
			$Penalty = "SELECT PenaltyCode, PenaltyDesc, Amount FROM tblref_penalty WHERE PenaltyCode LIKE '%". $_POST['key'] ."%' OR PenaltyDesc LIKE '%". $_POST['key'] ."%' ORDER BY PenaltyDesc ASC ";
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
			$file = $syspath."Penalty_".date('mdY').".csv";
			chmod($file, 0777);
			if (file_put_contents($file, $data)){
				create_logs_per_transaction('exported a referential to excel', 'Unit Classification', '', '', 'EXPORT', '');
				echo 1;
			}else{
				echo 0;
			}
		break;
		// xmer 09162019
	}
?>