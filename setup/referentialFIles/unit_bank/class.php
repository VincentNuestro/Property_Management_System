<?php
	session_start();
	include "../../../connect.php";
	switch ($_POST['form']) {
		case 'displayBank':
			$page = $_POST['page'];
			$limit = ($page-1) * 20;
			$res = mysql_query("SELECT xCODE, description FROM tblrefbank WHERE Description LIKE '%". $_POST['key'] ."%' OR XCODE LIKE '%". $_POST['key'] ."%' GROUP BY xCODE ORDER BY ". $_POST['unitBankSortBy'] ." ". $_POST['unitBankSortType'] ." LIMIT ". $limit .",20;", $connection);
			while($row = mysql_fetch_array($res)){
				?>
					<tr id="<?php echo $row[0]; ?>">
						<td><?php echo $row[0]; ?></td>
						<td><?php echo utf8_encode($row[1]); ?></td>
					</tr>
				<?php
			}
		break;

		case 'loadEntriesBank':
			if($_POST["page"] == ""){
	            $page = 1;
	        }else{
	            $page = $_POST["page"];
	        }
    		$limit = ($page-1) * 20;
            $rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(xCODE) FROM tblrefbank WHERE Description LIKE '%". $_POST['key'] ."%' OR XCODE LIKE '%". $_POST['key'] ."%';", $connection));
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

		case "loadPageBank":
			$page = $_POST["page"];
			$rowCount = mysql_fetch_row(mysql_query("SELECT COUNT(xCODE) FROM tblrefbank WHERE Description LIKE '%". $_POST['key'] ."%' OR XCODE LIKE '%". $_POST['key'] ."%';", $connection));
			$rowsperpage = 20;
			$range = 1;
			$totalpages = ceil($rowCount[0] / $rowsperpage);
			$prevpage;
			$nextpage;
			// if not on page 1, don't show back links
			if($page > 1 ){
			   	echo "<li style='width:50px !important;' onclick='fncPageBank(1)'><< First</li>";
			   	$prevpage = $page - 1;
			   	echo "<li style='width:70px !important;' onclick='fncPageBank(". $prevpage .")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if(($x > 0) && ($x <= $totalpages)){
    			    if($x == $page){
                        echo "<li id='pgBank" . $x . "' class='pgnumBank active' onclick='fncPageBank(" . $x . ",". $x .")'>" . $x . "</li>";
                    }else{
    			        echo "<li id='pgBank" . $x . "' class='pgnumBank' onclick='fncPageBank(" . $x . ",". $x .")'>" . $x . "</li>";
                    }
		       	}
		    }
		    if($page < ($totalpages - $range)){
                echo "<li>...</li>";
            }
		    if($page != $totalpages && $rowCount[0] != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='fncPageBank(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='fncPageBank(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'selectedBank':
			$row = mysql_fetch_array(mysql_query("SELECT xCODE, description, id FROM tblrefbank WHERE xCODE = '". $_POST['id'] ."';", $connection));
			echo $row[0] . "|" . utf8_encode($row[1]) . "|" . $row[2];
		break;

		case 'saveBank':
			//INSERT LOG FIRST - JONAS - 12/5/2018
			$arrHeader = ["Code", "Description"];
			$arrValue = [$_POST['bankCode'], $_POST['bankDesc']];
			$Logs = createXinfo("INSERT", $arrHeader, "", $arrValue, "", "", "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("added a bank referential.", "Referential Module", $Logs, "" ,"ADD", "");
			}
			//INSERT LOG FIRST - JONAS - 12/5/2018
			$rowcheck = mysql_fetch_array(mysql_query("SELECT xCODE FROM tblrefbank WHERE xCode = '". $_POST['bankCode'] ."';", $connection));
				if($rowdesc[0] == ""){
					$res = mysql_query("INSERT INTO tblrefbank SET xCODE = '". mysql_escape_string(strtoupper($_POST['bankCode'])) ."', description = '". mysql_escape_string(ucfirst($_POST['bankDesc'])) ."';", $connection);
					if($res == true){
						echo 1;
					}
				}
			else{
				echo "Bank Code already exist.";
			}
		break;

		case 'updateBank':
			//INSERT UPDATE LOG FIRST - JONAS - 12/5/2018
			$arrHeader = ["Code", "Description"];
			$arrFields = ["xCODE", "description"];
			$arrValue = [$_POST['bankCode'], $_POST['bankDesc']];
			$Logs = createXinfo("UPDATE", $arrHeader, $arrFields, $arrValue, "tblrefbank", $_POST['hiddenbankid'], "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("modified a bank referential.", "Referential Module", $Logs, "" ,"UPDATE", "");
			}
			//INSERT UPDATE LOG FIRST - JONAS - 12/5/2018
			$res = mysql_query("UPDATE tblrefbank SET xCODE = '". mysql_escape_string(strtoupper($_POST['bankCode'])) ."', description = '". mysql_escape_string(ucfirst($_POST['bankDesc'])) ."' WHERE id = '". $_POST['hiddenbankid'] ."';", $connection);
			if($res == true){
				echo 1;
			}
		break;

		case 'deleteBank':
			//INSERT DELETE LOG FIRST - JONAS - 12/5/2018
			$arrHeader = ["Code", "Violation"];
			$arrFields = ["xCODE", "description"];
			$Logs = createXinfo("DELETE", $arrHeader, $arrFields, "", "tblrefbank", $_POST['hiddenbankid'], "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("deleted a bank referential.", "Referential Module", $Logs, "", "DELETE", "");
			}
			//INSERT DELETE LOG FIRST - JONAS - 12/5/2018
			$res = mysql_query("DELETE FROM tblrefbank WHERE id = '". $_POST['hiddenbankid'] ."';", $connection);
			if($res == true){
				echo 1;
			}
		break;

		case 'clickUpdateBank':
			$tbltransaction = mysql_fetch_array(mysql_query("SELECT COUNT(bankname) FROM tbltransaction WHERE bankname = '". $_POST['bankCode'] ."'", $connection));
			$PDC = mysql_fetch_array(mysql_query("SELECT COUNT(bank) FROM tbltrans_pdc WHERE bank = '". $_POST['bankCode'] ."'", $connection));
			$InqBankFrom = mysql_fetch_array(mysql_query("SELECT COUNT(bankfrom) FROM tbltrans_inquiry WHERE bankfrom = '". $_POST['bankCode'] ."'", $connection));
			$InqBankTo = mysql_fetch_array(mysql_query("SELECT COUNT(bankto) FROM tbltrans_inquiry WHERE bankto = '". $_POST['bankCode'] ."'", $connection));
			$TenantBankFrom = mysql_fetch_array(mysql_query("SELECT COUNT(bankfrom) FROM tbltrans_tenants WHERE bankfrom = '". $_POST['bankCode'] ."'", $connection));
			$TenantBankTo = mysql_fetch_array(mysql_query("SELECT COUNT(bankto) FROM tbltrans_tenants WHERE bankto = '". $_POST['bankCode'] ."'", $connection));
			if($tbltransaction[0] >= 1 || $PDC[0] >= 1 || $InqBankFrom[0] >= 1 || $InqBankTo[0] >= 1 || $TenantBankFrom[0] >= 1 || $TenantBankTo[0] >= 1){
				echo 1;
			}else{
				echo 0;
			}
		break;

		case 'AutoConsolidateBank':
			$Bank = "SELECT xCODE, description FROM tblrefbank WHERE Description LIKE '%". $_POST['key'] ."%' OR XCODE LIKE '%". $_POST['key'] ."%' ORDER BY description ASC ";
			$resclassification = mysql_query($Bank, $connection);
			$data = "Code,Description\r\n";
			while($rowclassification = mysql_fetch_array($resclassification)){
				$data .= $rowclassification[0].",".$rowclassification[1]."\r\n";
			}
			$filepath = mysql_fetch_array(mysql_query("SELECT filepath FROM tblsys_setup", $connection));
			$syspath = str_replace("\\", "/", $filepath[0]);
			if (!file_exists($syspath)){
				mkdir($syspath, 0777, true);
			}
			$file = $syspath."Bank_".date('mdY').".csv";
			chmod($file, 0777);
			if (file_put_contents($file, $data)){
			create_logs_per_transaction('exported a referential to excel', 'Bank', '', '', 'EXPORT', '');
				echo 1;
			}else{
				echo 0;
			}
		break;
	}
?>