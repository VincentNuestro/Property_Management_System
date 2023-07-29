<?php
	session_start();
	include "../../../connect.php";
	switch ($_POST['form']) {
		case 'fncPromotionalpList':
			$page = $_POST['page'];
			$limit = ($page-1) * 20;
			$resPromotionalp = mysql_query("SELECT PromotionalpCode, PromotionalpDesc FROM tblref_promotionalp WHERE PromotionalpCode LIKE '%". $_POST['key'] ."%' OR PromotionalpDesc LIKE '%". $_POST['key'] ."%' GROUP BY PromotionalpCode ORDER BY ". $_POST['PromotionalpSortBy'] ." ". $_POST['PromotionalpSortType'] .";", $connection) or die(mysql_error());
	
			while($rowPromotionalp = mysql_fetch_array($resPromotionalp)){
				echo 	"<tr id='". $rowPromotionalp['PromotionalpCode'] ."'>
							<td>". $rowPromotionalp['PromotionalpCode'] ."</td>
							<td>". $rowPromotionalp['PromotionalpDesc'] ."</td>
						</tr>";
			}
		break;

		case 'loadEntriesPromotionalp':
			if($_POST["page"] == ""){
	            $page = 1;
	        }else{
	            $page = $_POST["page"];
	        }
    		$limit = ($page-1) * 20;
            $rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM tblref_promotionalp WHERE PromotionalpCode LIKE '%". $_POST['key'] ."%' OR PromotionalpDesc LIKE '%". $_POST['key'] ."%';", $connection));
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

		case "loadPagePromotionalp":
			$page = $_POST["page"];
			$rowCount = mysql_fetch_row(mysql_query("SELECT COUNT(id) FROM tblref_promotionalp WHERE PromotionalpCode LIKE '%". $_POST['key'] ."%' OR PromotionalpDesc LIKE '%". $_POST['key'] ."%';", $connection));
			$rowsperpage = 20;
			$range = 1;
			$totalpages = ceil($rowCount[0] / $rowsperpage);
			$prevpage;
			$nextpage;
			// if not on page 1, don't show back links
			if($page > 1 ){
			   	echo "<li style='width:50px !important;' onclick='fncPagePromotionalp(1)'><< First</li>";
			   	$prevpage = $page - 1;
			   	echo "<li style='width:70px !important;' onclick='fncPagePromotionalp(". $prevpage .")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if(($x > 0) && ($x <= $totalpages)){
    			    if($x == $page){
                        echo "<li id='pgPromotionalp" . $x . "' class='pgnumPromotionalp active' onclick='fncPagePromotionalp(" . $x . ",". $x .")'>" . $x . "</li>";
                    }else{
    			        echo "<li id='pgPromotionalp" . $x . "' class='pgnumPromotionalp' onclick='fncPagePromotionalp(" . $x . ",". $x .")'>" . $x . "</li>";
                    }
		       	}
		    }
		    if($page < ($totalpages - $range)){
                echo "<li>...</li>";
            }
		    if($page != $totalpages && $rowCount[0] != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='fncPagePromotionalp(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='fncPagePromotionalp(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'fncSavePromotionalp':
			//INSERT LOG FIRST - JONAS - 12/5/2018
			$arrHeader = ["Promotionalp Code", "Promotionalp"];
			$arrValue = [$_POST['Code'], $_POST['Promotionalp']];
			$Logs = createXinfo("INSERT", $arrHeader, "", $arrValue, "", "", "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("added a new Organizer Material referential.", "Referential Module", $Logs, "" ,"ADD", "");
			}
			//INSERT LOG FIRST - JONAS - 12/5/2018
			$CheckExisting = mysql_num_rows(mysql_query("SELECT PromotionalpCode FROM tblref_promotionalp WHERE PromotionalpCode = '". $_POST['Code'] ."';", $connection));
			if($CheckExisting == 0){
				$resInsertPromotionalp = mysql_query("INSERT INTO tblref_promotionalp SET PromotionalpCode = '". mysql_escape_string(strtoupper($_POST['Code'])) ."', PromotionalpDesc = '". mysql_escape_string(ucfirst($_POST['Promotionalp'])) ."' ;", $connection);
				if($resInsertPromotionalp == true){
					echo 1;
					//forAccIntegration($_POST['Code'], $_POST['Promotionalp'], "", "INSERT");
				}
			}else{
				echo "Promotionalp code already exist.";
			}
		break;

		case 'fncPromotionalpSelected':
			$PromotionalpInfo = mysql_fetch_array(mysql_query("SELECT PromotionalpDesc, id FROM tblref_promotionalp WHERE PromotionalpCode = '". $_POST['id'] ."';", $connection));
			echo $PromotionalpInfo['PromotionalpDesc'] . "|" . $PromotionalpInfo['id'];
		break;

		case 'fncUpdatePromotionalp':
			//INSERT UPDATE LOG FIRST - JONAS - 12/5/2018
			$arrHeader = ["Promotionalp Code", "Promotionalp"];
			$arrFields = ["PromotionalpCode", "PromotionalpDesc"];
			$arrValue = [$_POST['Code'], $_POST['Promotionalp']];
			$Logs = createXinfo("UPDATE", $arrHeader, $arrFields, $arrValue, "tblref_promotionalp", $_POST['PromotionalpID'], "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("modified a Organizer Material referential.", "Referential Module", $Logs, "" ,"UPDATE", "");
			}
			//INSERT UPDATE LOG FIRST - JONAS - 12/5/2018
			$CurrCode = mysql_fetch_array(mysql_query("SELECT PromotionalpCode FROM tblref_promotionalp WHERE id = '". $_POST['PromotionalpID'] ."';", $connection));
			$resUpdate = mysql_query("UPDATE tblref_promotionalp SET PromotionalpCode = '". mysql_escape_string(strtoupper($_POST['Code'])) ."', PromotionalpDesc = '". mysql_escape_string(ucfirst($_POST['Promotionalp'])) ."' WHERE id = '". $_POST['PromotionalpID'] ."';", $connection) or die(mysql_error());
			if($resUpdate == true){
				echo 1;
				//forAccIntegration($_POST['Code'], $_POST['Promotionalp'], $CurrCode[0], "UPDATE");
			}
		break;

		case 'fncClickDeletePromotionalp':
			//INSERT DELETE LOG FIRST - JONAS - 12/5/2018
			$arrHeader = ["Promotionalp Code", "Promotionalp"];
			$arrFields = ["PromotionalpCode", "PromotionalpDesc"];
			$Logs = createXinfo("DELETE", $arrHeader, $arrFields, "", "tblref_promotionalp", $_POST['Code'], "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("deleted a Organizer Material referential.", "Referential Module", $Logs, "", "DELETE", "");
			}
			//INSERT DELETE LOG FIRST - JONAS - 12/5/2018
			$resDelete = mysql_query("DELETE FROM tblref_promotionalp WHERE id = '". $_POST['Code'] ."';", $connection);
			if($resDelete == true){
				echo 1;
				//forAccIntegration($_POST['Code'], "", "", "DELETE");
			}
		break;

		case 'fncClickUpdatePromotionalp':
			$row = mysql_fetch_array(mysql_query("SELECT COUNT(xcode) FROM tbltransaction WHERE xcode = '". $_POST['Code'] ."' AND isPenalty = '1';", $connection));
			if($row[0] >= 1){
				echo 1;
			}else{
				echo 0;
			}
		break;

		// xmer 09162019
		case 'AutoConsolidatePromotionalp':
			$Penalty = "SELECT PromotionalpCode, PromotionalpDesc FROM tblref_promotionalp WHERE PromotionalpCode LIKE '%". $_POST['key'] ."%' OR PromotionalpDesc LIKE '%". $_POST['key'] ."%' ORDER BY PromotionalpDesc ASC ";
			$resclassification = mysql_query($Penalty, $connection);
			$data = "Code,Description\r\n";
			while($rowclassification = mysql_fetch_array($resclassification)){
				$data .= $rowclassification[0].",".$rowclassification[1].",".$rowclassification[2]."\r\n";
			}
			$filepath = mysql_fetch_array(mysql_query("SELECT filepath FROM tblsys_setup", $connection));
			$syspath = str_replace("\\", "/", $filepath[0]);
			if (!file_exists($syspath)){
				mkdir($syspath, 0777, true);
			}
			$file = $syspath."Promotionalp_".date('mdY').".csv";
			chmod($file, 0777);
			if (file_put_contents($file, $data)){
				create_logs_per_transaction('exported a referential to excel', 'Promotionalp', '', '', 'EXPORT', '');
				echo 1;
			}else{
				echo 0;
			}
		break;
		// xmer 09162019
	}
?>