<?php
	session_start();
	include "../../../connect.php";
	switch ($_POST['form']) {
		case 'fncFacilitiesList':
			$page = $_POST['page'];
			$limit = ($page-1) * 20;
			$resFacilities = mysql_query("SELECT FacilitiesCode, FacilitiesDesc, Amount FROM tblref_facilities WHERE FacilitiesCode LIKE '%". $_POST['key'] ."%' OR FacilitiesDesc LIKE '%". $_POST['key'] ."%' GROUP BY FacilitiesCode ORDER BY ". $_POST['FacilitiesSortBy'] ." ". $_POST['FacilitiesSortType'] ." LIMIT ". $limit .",20;", $connection) or die(mysql_error());
			while($rowFacilities = mysql_fetch_array($resFacilities)){
				echo 	"<tr id='". $rowFacilities['FacilitiesCode'] ."'>
							<td>". $rowFacilities['FacilitiesCode'] ."</td>
							<td>". $rowFacilities['FacilitiesDesc'] ."</td>
							<td style='text-align: right;'>". number_format($rowFacilities['Amount'], 2, '.', ',') ."</td>
						</tr>";
			}
		break;

		case 'loadEntriesFacilities':
			if($_POST["page"] == ""){
	            $page = 1;
	        }else{
	            $page = $_POST["page"];
	        }
    		$limit = ($page-1) * 20;
            $rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM tblref_facilities WHERE FacilitiesCode LIKE '%". $_POST['key'] ."%' OR FacilitiesDesc LIKE '%". $_POST['key'] ."%';", $connection));
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

		case "loadPageFacilities":
			$page = $_POST["page"];
			$rowCount = mysql_fetch_row(mysql_query("SELECT COUNT(id) FROM tblref_Facilities WHERE FacilitiesCode LIKE '%". $_POST['key'] ."%' OR FacilitiesDesc LIKE '%". $_POST['key'] ."%';", $connection));
			$rowsperpage = 20;
			$range = 1;
			$totalpages = ceil($rowCount[0] / $rowsperpage);
			$prevpage;
			$nextpage;
			// if not on page 1, don't show back links
			if($page > 1 ){
			   	echo "<li style='width:50px !important;' onclick='fncPageFacilities(1)'><< First</li>";
			   	$prevpage = $page - 1;
			   	echo "<li style='width:70px !important;' onclick='fncPageFacilities(". $prevpage .")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if(($x > 0) && ($x <= $totalpages)){
    			    if($x == $page){
                        echo "<li id='pgFacilities" . $x . "' class='pgnumFacilities active' onclick='fncPageFacilities(" . $x . ",". $x .")'>" . $x . "</li>";
                    }else{
    			        echo "<li id='pgFacilities" . $x . "' class='pgnumFacilities' onclick='fncPageFacilities(" . $x . ",". $x .")'>" . $x . "</li>";
                    }
		       	}
		    }
		    if($page < ($totalpages - $range)){
                echo "<li>...</li>";
            }
		    if($page != $totalpages && $rowCount[0] != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='fncPageFacilities(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='fncPageFacilities(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'fncSaveFacilities':
			//INSERT LOG FIRST - JONAS - 12/5/2018
			$arrHeader = ["Facilities Code", "Facilities", "Amount"];
			$arrValue = [$_POST['Code'], $_POST['Facilities'], number_format($_POST['Amount'], 2, '.', ',')];
			$Logs = createXinfo("INSERT", $arrHeader, "", $arrValue, "", "", "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("added a new facilities referential.", "Referential Module", $Logs, "" ,"ADD", "");
			}
			//INSERT LOG FIRST - JONAS - 12/5/2018
			$CheckExisting = mysql_num_rows(mysql_query("SELECT FacilitiesCode FROM tblref_facilities WHERE FacilitiesCode = '". $_POST['Code'] ."';", $connection));
			if($CheckExisting == 0){
				$resInsertFacilities = mysql_query("INSERT INTO tblref_Facilities SET FacilitiesCode = '". mysql_escape_string(strtoupper($_POST['Code'])) ."', FacilitiesDesc = '". mysql_escape_string(ucfirst($_POST['Facilities'])) ."', Amount = '". floatval($_POST['Amount']) ."';", $connection);
				if($resInsertFacilities == true){
					echo 1;
					//forAccIntegration($_POST['Code'], $_POST['Facilities'], "", "INSERT");
				}
			}else{
				echo "Facilities code already exist.";
			}
		break;

		case 'fncFacilitiesSelected':
			$FacilitiesInfo = mysql_fetch_array(mysql_query("SELECT FacilitiesDesc, Amount, id FROM tblref_facilities WHERE FacilitiesCode = '". $_POST['id'] ."';", $connection));
			echo $FacilitiesInfo['FacilitiesDesc'] . "|" . number_format($FacilitiesInfo['Amount'], 2, '.', ',') . "|" . $FacilitiesInfo['id'];
		break;

		case 'fncUpdateFacilities':
			//INSERT UPDATE LOG FIRST - JONAS - 12/5/2018
			$arrHeader = ["Facilities Code", "Facilities", "Amount"];
			$arrFields = ["FacilitiesCode", "FacilitiesDesc", "Amount"];
			$arrValue = [$_POST['Code'], $_POST['Facilities'], number_format($_POST['Amount'], 2, '.', ',')];
			$Logs = createXinfo("UPDATE", $arrHeader, $arrFields, $arrValue, "tblref_facilities", $_POST['FacilitiesID'], "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("modified a facilities referential.", "Referential Module", $Logs, "" ,"UPDATE", "");
			}
			//INSERT UPDATE LOG FIRST - JONAS - 12/5/2018
			$CurrCode = mysql_fetch_array(mysql_query("SELECT FacilitiesCode FROM tblref_facilities WHERE id = '". $_POST['FacilitiesID'] ."';", $connection));
			$resUpdate = mysql_query("UPDATE tblref_facilities SET FacilitiesCode = '". mysql_escape_string(strtoupper($_POST['Code'])) ."', FacilitiesDesc = '". mysql_escape_string(ucfirst($_POST['Facilities'])) ."', Amount = '". floatval($_POST['Amount']) ."' WHERE id = '". $_POST['FacilitiesID'] ."';", $connection);
			if($resUpdate == true){
				echo 1;
				//forAccIntegration($_POST['Code'], $_POST['Facilities'], $CurrCode[0], "UPDATE");
			}
		break;

		case 'fncClickDeleteFacilities':
			//INSERT DELETE LOG FIRST - JONAS - 12/5/2018
			$arrHeader = ["Facilities Code", "Facilities", "Amount"];
			$arrFields = ["FacilitiesCode", "FacilitiesDesc", "Amount"];
			$Logs = createXinfo("DELETE", $arrHeader, $arrFields, "", "tblref_facilities", $_POST['Code'], "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("deleted a facilities referential.", "Referential Module", $Logs, "", "DELETE", "");
			}
			//INSERT DELETE LOG FIRST - JONAS - 12/5/2018
			$resDelete = mysql_query("DELETE FROM tblref_facilities WHERE id = '". $_POST['Code'] ."';", $connection);
			if($resDelete == true){
				echo 1;
				//forAccIntegration($_POST['Code'], "", "", "DELETE");
			}
		break;

		case 'fncClickUpdateFacilities':
			$row = mysql_fetch_array(mysql_query("SELECT COUNT(xcode) FROM tbltransaction WHERE xcode = '". $_POST['Code'] ."' AND isPenalty = '1';", $connection));
			if($row[0] >= 1){
				echo 1;
			}else{
				echo 0;
			}
		break;

		// xmer 09162019
		case 'AutoConsolidateFacilities':
			$Penalty = "SELECT FacilitiesCode, FacilitiesDesc, Amount FROM tblref_facilities WHERE FacilitiesCode LIKE '%". $_POST['key'] ."%' OR FacilitiesDesc LIKE '%". $_POST['key'] ."%' ORDER BY FacilitiesDesc ASC ";
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
			$file = $syspath."Facilities_".date('mdY').".csv";
			chmod($file, 0777);
			if (file_put_contents($file, $data)){
				create_logs_per_transaction('exported a referential to excel', 'Facilities', '', '', 'EXPORT', '');
				echo 1;
			}else{
				echo 0;
			}
		break;
		// xmer 09162019
	}
?>