<?php
	session_start();
	include "../../../connect.php";
	switch ($_POST['form']) {
		case 'showRefCharges':
			$page = $_POST['page'];
			$limit = ($page-1) * 20;
			$sql = "SELECT CHARGE_ID, CHARGE_DESC, CHARGE_TYPE, RATE_TYPE, RATE, OTHER_REASON, isDefault FROM tblref_refcharges WHERE CHARGE_ID LIKE '%". $_POST['key'] ."%' OR CHARGE_DESC LIKE '%". $_POST['key'] ."%' ORDER BY CHARGE_DESC ASC LIMIT ". $limit .", 20;";
			$res = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($res)){
				if($row['isDefault'] == '1'){
					$isDefault = "Yes";
				}else{
					$isDefault = "No";
				}
				?>
					<tr id="<?php echo $row[0]; ?>">
						<td><?php echo $row[0]; ?></td>
						<td><?php echo $row[1]; ?></td>
						<td><?php echo $row[2]; ?></td>
						<td><?php echo $row[3]; ?></td>
						<td style='text-align: right;'><?php echo number_format($row[4], 2, '.', ','); ?></td>
						<td><?php echo $row[5]; ?></td>
						<td><?php echo $isDefault; ?></td>
					</tr>
				<?php
			}
		break;

		case 'loadEntriesCharges':
			if($_POST["page"] == ""){
	            $page = 1;
	        }else{
	            $page = $_POST["page"];
	        }
    		$limit = ($page-1) * 20;
            $rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM tblref_refcharges WHERE CHARGE_ID LIKE '%". $_POST['key'] ."%' OR CHARGE_DESC LIKE '%". $_POST['key'] ."%';", $connection));
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

		case "loadPageCharges":
			$page = $_POST["page"];
			$rowCount = mysql_fetch_row(mysql_query("SELECT COUNT(id) FROM tblref_refcharges WHERE CHARGE_ID LIKE '%". $_POST['key'] ."%' OR CHARGE_DESC LIKE '%". $_POST['key'] ."%';", $connection));
			$rowsperpage = 20;
			$range = 1;
			$totalpages = ceil($rowCount[0] / $rowsperpage);
			$prevpage;
			$nextpage;
			// if not on page 1, don't show back links
			if($page > 1 ){
			   	echo "<li style='width:50px !important;' onclick='fncPageCharges(1)'><< First</li>";
			   	$prevpage = $page - 1;
			   	echo "<li style='width:70px !important;' onclick='fncPageCharges(". $prevpage .")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if(($x > 0) && ($x <= $totalpages)){
    			    if($x == $page){
                        echo "<li id='pgCharges" . $x . "' class='pgnumCharges active' onclick='fncPageCharges(" . $x . ",". $x .")'>" . $x . "</li>";
                    }else{
    			        echo "<li id='pgCharges" . $x . "' class='pgnumCharges' onclick='fncPageCharges(" . $x . ",". $x .")'>" . $x . "</li>";
                    }
		       	}
		    }
		    if($page < ($totalpages - $range)){
                echo "<li>...</li>";
            }
		    if($page != $totalpages && $rowCount[0] != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='fncPageCharges(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='fncPageCharges(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'SelectedRefCharges':
			$SelectedrefCharges = mysql_fetch_array(mysql_query("SELECT CHARGE_ID, CHARGE_DESC, CHARGE_TYPE, RATE_TYPE, RATE, OTHER_REASON, isDefault, id FROM tblref_refcharges WHERE CHARGE_ID = '". mysql_escape_string($_POST['id']) ."';", $connection));
			echo $SelectedrefCharges['CHARGE_ID'] . "|" . $SelectedrefCharges['CHARGE_DESC'] . "|" . $SelectedrefCharges['CHARGE_TYPE'] . "|" . $SelectedrefCharges['RATE_TYPE'] . "|" . $SelectedrefCharges['RATE'] . "|" . $SelectedrefCharges['OTHER_REASON'] . "|" . $SelectedrefCharges['isDefault'] . "|" . $SelectedrefCharges['id'];
		break;
		
		case 'SaveNewRefCharges':
			//INSERT LOG FIRST - JONAS - 12/5/2018
			$arrHeader = ["Charge ID", "Charge Description", "Charge Type", "Rate Type", "Rate", "Charge Reason", "Default"];
			$arrValue = [$_POST['ChargeCode'], $_POST['ChargeDesc'], $_POST['ChargesType'], $_POST['ChargesRateType'], number_format($_POST['ChargesRate'], "2", ".", ","), $_POST['ChargesReason'], $_POST['isDefault']];
			$Logs = createXinfo("INSERT", $arrHeader, "", $arrValue, "", "", "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("added a new charge referential.", "Referential Module", $Logs, "" ,"ADD", "");
			}
			//INSERT LOG FIRST - JONAS - 12/5/2018
			$checkexist = mysql_num_rows(mysql_query("SELECT CHARGE_ID FROM tblref_refcharges WHERE CHARGE_ID = '". $_POST['ChargeCode'] ."';", $connection));
			if($checkexist == 0){
				$res = mysql_query("INSERT INTO tblref_refcharges SET CHARGE_ID = '". mysql_escape_string(strtoupper($_POST['ChargeCode'])) ."', CHARGE_DESC = '". mysql_escape_string(ucfirst($_POST['ChargeDesc'])) ."', CHARGE_TYPE = '". mysql_escape_string($_POST['ChargesType']) ."', RATE_TYPE = '". mysql_escape_string($_POST['ChargesRateType']) ."', RATE = '". mysql_escape_string($_POST['ChargesRate']) ."', OTHER_REASON = '". mysql_escape_string($_POST['ChargesReason']) ."', isDefault = '". $_POST['isDefault'] ."';", $connection);
				if($res == true){
					echo 1;
					forAccIntegration($_POST['ChargeCode'], $_POST['ChargeDesc'], "", "INSERT");
				}
			}else{
				echo "Charges type already exist.";
			}
		break;

		case 'UpdateRefCharges':
			//INSERT UPDATE LOG FIRST - JONAS - 12/5/2018
			$arrHeader = ["Charge ID", "Charge Description", "Charge Type", "Rate Type", "Rate", "Charge Reason", "Default"];
			$arrFields = ["CHARGE_ID", "CHARGE_DESC", "CHARGE_TYPE", "RATE_TYPE", "RATE", "OTHER_REASON", "isDefault"];
			$arrValue = [$_POST['ChargeCode'], $_POST['ChargeDesc'], $_POST['ChargesType'], $_POST['ChargesRateType'], number_format($_POST['ChargesRate'], "2", ".", ","), $_POST['ChargesReason'], $_POST['isDefault']];
			$Logs = createXinfo("UPDATE", $arrHeader, $arrFields, $arrValue, "tblref_refcharges", $_POST['ChargesID'], "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("modified a charge referential.", "Referential Module", $Logs, "" ,"UPDATE", "");
			}
			//INSERT UPDATE LOG FIRST - JONAS - 12/5/2018
			$CurrentCode = mysql_fetch_array(mysql_query("SELECT CHARGE_ID FROM tblref_refcharges WHERE id = '". $_POST['ChargesID'] ."'", $connection));
			$res = mysql_query("UPDATE tblref_refcharges SET CHARGE_ID = '". mysql_escape_string(strtoupper($_POST['ChargeCode'])) ."', CHARGE_DESC = '". mysql_escape_string(ucfirst($_POST['ChargeDesc'])) ."', CHARGE_TYPE = '". mysql_escape_string($_POST['ChargesType']) ."', RATE_TYPE = '". mysql_escape_string($_POST['ChargesRateType']) ."', RATE = '". mysql_escape_string($_POST['ChargesRate']) ."', OTHER_REASON = '". mysql_escape_string($_POST['ChargesReason']) ."', isDefault = '". $_POST['isDefault'] ."' WHERE id = '". $_POST['ChargesID'] ."';", $connection);
			if($res == true){
				echo 1;
				forAccIntegration($_POST['ChargeCode'], $_POST['ChargeDesc'], $CurrentCode[0], "UPDATE");
			}
		break;

		case 'clickDeleteRefCharges':
			//INSERT DELETE LOG FIRST - JONAS - 12/5/2018
			$arrHeader = ["Charge ID", "Charge Description", "Charge Type", "Rate Type", "Rate", "Charge Reason", "Default"];
			$arrFields = ["CHARGE_ID", "CHARGE_DESC", "CHARGE_TYPE", "RATE_TYPE", "RATE", "OTHER_REASON", "isDefault"];
			$Logs = createXinfo("DELETE", $arrHeader, $arrFields, "", "tblref_refcharges", $_POST['ChargesID'], "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("deleted a charge referential.", "Referential Module", $Logs, "", "DELETE", "");
			}
			//INSERT DELETE LOG FIRST - JONAS - 12/5/2018
			$res = mysql_query("DELETE FROM tblref_refcharges WHERE id = '". $_POST['ChargesID'] ."';", $connection);
			if($res == true){
				echo 1;
				forAccIntegration($_POST['ChargeCode'], "", "", "DELETE");
			}
		break;

		case 'clickUpdateCharges':
			$Proposal = mysql_fetch_array(mysql_query("SELECT COUNT(charges_list) FROM tbltrans_proposal WHERE charges_list LIKE '%". $_POST['txtChargeCode'] ."%';", $connection));
			$Transaction = mysql_fetch_array(mysql_query("SELECT COUNT(xcode) FROM tbltransaction WHERE xcode = '". $_POST['txtChargeCode'] ."'", $connection));
			if($Proposal[0] >= 1 || $Transaction[0] >= 1){
				echo 1;
			}else{
				echo 0;
			}
		break;

		// xmer 09162019
		case 'AutoConsolidateCharges':
			$Charges = "SELECT CHARGE_ID, CHARGE_DESC, CHARGE_TYPE, RATE_TYPE, RATE, OTHER_REASON, isDefault FROM tblref_refcharges WHERE CHARGE_ID LIKE '%". $_POST['key'] ."%' OR CHARGE_DESC LIKE '%". $_POST['key'] ."%' ORDER BY CHARGE_DESC ASC ";
			$resclassification = mysql_query($Charges, $connection);
			$data = "Code,Description,ChargeType,RateType,Rate,Reason,DefaultProposalStatus\r\n";
			while($rowclassification = mysql_fetch_array($resclassification)){
				$data .= $rowclassification[0].",".$rowclassification[1].",".$rowclassification[2].",".$rowclassification[3].",".$rowclassification[4].",".$rowclassification[5].",".$rowclassification[6]."\r\n";
			}
			$filepath = mysql_fetch_array(mysql_query("SELECT filepath FROM tblsys_setup", $connection));
			$syspath = str_replace("\\", "/", $filepath[0]);
			if (!file_exists($syspath)){
				mkdir($syspath, 0777, true);
			}
			$file = $syspath."Charges_".date('mdY').".csv";
			chmod($file, 0777);
			if (file_put_contents($file, $data)){
			create_logs_per_transaction('exported a referential to excel', 'Charges', '', '', 'EXPORT', '');
				echo 1;
			}else{
				echo 0;
			}
		break;
		// xmer 09162019
	}
?>