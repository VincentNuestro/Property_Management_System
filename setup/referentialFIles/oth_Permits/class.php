<?php  
	session_start();
	include "../../../connect.php";
	switch ($_POST['form']) {
		case 'displayListofTypes':
			$page = $_POST['page'];
			$limit = ($page-1) * 20;
			$res = mysql_query("SELECT PermitCode, DESCRIPTION, override, id FROM tblref_typeofpermits WHERE DESCRIPTION LIKE '%". $_POST['key'] ."%' GROUP BY PermitCode ORDER BY ". $_POST['PermitsSortBy'] ." ". $_POST['PermitsSortType'] ." LIMIT ". $limit .",20;", $connection);
			while($row = mysql_fetch_array($res)){
				if($row[2] == "1"){
					$lol = "Yes";
				}else{
					$lol = "No";
				}
				echo 	"<tr id=". $row['id'] .">
							<td>". $row['PermitCode'] ."</td>
							<td>". $row['DESCRIPTION'] ."</td>
						</tr>";
			}
		break;

		case 'loadEntriesPermits':
			if($_POST["page"] == ""){
	            $page = 1;
	        }else{
	            $page = $_POST["page"];
	        }
    		$limit = ($page-1) * 20;
            $rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM tblref_typeofpermits WHERE DESCRIPTION LIKE '%". $_POST['key'] ."%';", $connection));
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

		case "loadPagePermits":
			$page = $_POST["page"];
			$rowCount = mysql_fetch_row(mysql_query("SELECT COUNT(id) FROM tblref_typeofpermits WHERE DESCRIPTION LIKE '%". $_POST['key'] ."%';", $connection));
			$rowsperpage = 20;
			$range = 1;
			$totalpages = ceil($rowCount[0] / $rowsperpage);
			$prevpage;
			$nextpage;
			// if not on page 1, don't show back links
			if($page > 1 ){
			   	echo "<li style='width:50px !important;' onclick='fncPagePermits(1)'><< First</li>";
			   	$prevpage = $page - 1;
			   	echo "<li style='width:70px !important;' onclick='fncPagePermits(". $prevpage .")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if(($x > 0) && ($x <= $totalpages)){
    			    if($x == $page){
                        echo "<li id='pgPermits" . $x . "' class='pgnumPermits active' onclick='fncPagePermits(" . $x . ",". $x .")'>" . $x . "</li>";
                    }else{
    			        echo "<li id='pgPermits" . $x . "' class='pgnumPermits' onclick='fncPagePermits(" . $x . ",". $x .")'>" . $x . "</li>";
                    }
		       	}
		    }
		    if($page < ($totalpages - $range)){
                echo "<li>...</li>";
            }
		    if($page != $totalpages && $rowCount[0] != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='fncPagePermits(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='fncPagePermits(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'selectedTOP':
			$row = mysql_fetch_array(mysql_query("SELECT id, DESCRIPTION, override, PermitCode FROM tblref_typeofpermits WHERE id = '". $_POST['id'] ."';", $connection));
			if($row['override'] == 1){
				$Yes = "1";
			}else{
				$Yes = "2";
			}
			echo $row['id'] ."|". utf8_encode($row['DESCRIPTION']) ."|". $Yes . "|" . $row['PermitCode'];
		break;

		case 'saveTypeOfPermit':
			$arrHeader = ["Permit Code", "Permit", "Override"];
			$arrValue = [$_POST['PermitCode'], $_POST['PermitDesc'], $_POST['override']];
			$Logs = createXinfo("INSERT", $arrHeader, "", $arrValue, "", "", "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("added a new permit referential.", "Referential Module", $Logs, "" ,"ADD", "");
			}
			//INSERT UPDATE LOG FIRST - JONAS - 12/5/2018
			$rowcheck = mysql_fetch_array(mysql_query("SELECT DESCRIPTION FROM tblref_typeofpermits WHERE PermitCode = '". $_POST['PermitCode'] ."';", $connection));
			if($rowcheck[0] == ""){
				$res = mysql_query("INSERT INTO tblref_typeofpermits SET PermitCode = '". mysql_escape_string(strtoupper($_POST['PermitCode'])) ."', DESCRIPTION = '". mysql_escape_string(ucfirst($_POST['PermitDesc'])) ."', override = '". $_POST['override'] ."';", $connection);
				if($res == true){
					echo 1;
				}
			}else{
				echo "Permit Code already exist.";
			}
		break;

		case 'clickUpdatetypeofpermits':
			$ifBlank = mysql_fetch_array(mysql_query("SELECT COUNT(documentid) FROM tblref_tenantsdocs WHERE documentid = '". $_POST['hiddenTOPID'] ."';", $connection));
			if($ifBlank[0] >= 1){
				echo 1;
			}else{
				echo 0;
			}
		break;

		case 'updatetypeofpermits':
			//INSERT UPDATE LOG FIRST - JONAS - 12/5/2018
			$arrHeader = ["Permit Code", "Permit", "Override"];
			$arrFields = ["PermitCode", "DESCRIPTION", "override"];
			$arrValue = [$_POST['PermitCode'], $_POST['PermitDesc'], $_POST['override']];
			$Logs = createXinfo("UPDATE", $arrHeader, $arrFields, $arrValue, "tblref_typeofpermits", $_POST['hiddenTOPID'], "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("modified a permit referential.", "Referential Module", $Logs, "" ,"UPDATE", "");
			}
			//INSERT UPDATE LOG FIRST - JONAS - 12/5/2018
			$res = mysql_query("UPDATE tblref_typeofpermits SET PermitCode = '". mysql_escape_string(strtoupper($_POST['PermitCode'])) ."', DESCRIPTION = '". mysql_escape_string(ucfirst($_POST['PermitDesc'])) ."', override = '". $_POST['override'] ."' WHERE id = '". $_POST['hiddenTOPID'] ."';", $connection);
			if($res == true){
				echo 1;
			}
		break;

		case 'deletetypeofpermits':
			//INSERT DELETE LOG FIRST - JONAS - 12/5/2018
			$arrHeader = ["Permit", "Override"];
			$arrFields = ["DESCRIPTION", "override"];
			$Logs = createXinfo("DELETE", $arrHeader, $arrFields, "", "tblref_typeofpermits", $_POST['hiddenTOPID'], "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("deleted a permit referential.", "Referential Module", $Logs, "", "DELETE", "");
			}
			//INSERT DELETE LOG FIRST - JONAS - 12/5/2018
			$res = mysql_query("DELETE FROM tblref_typeofpermits WHERE id = '". $_POST['hiddenTOPID'] ."';", $connection);
			if($res == true){
				echo 1;
			}
		break;

		// xmer 09162019
		case 'AutoConsolidatePermits':
			$Permit = "SELECT PermitCode, DESCRIPTION, override, id FROM tblref_typeofpermits WHERE DESCRIPTION LIKE '%". $_POST['key'] ."%' ";
			$resclassification = mysql_query($Permit, $connection);
			$data = "Code,Description,Override\r\n";
			while($rowclassification = mysql_fetch_array($resclassification)){
				$data .= $rowclassification[0].",".$rowclassification[1].",".$rowclassification[2]."\r\n";
			}
			$filepath = mysql_fetch_array(mysql_query("SELECT filepath FROM tblsys_setup", $connection));
			$syspath = str_replace("\\", "/", $filepath[0]);
			if (!file_exists($syspath)){
				mkdir($syspath, 0777, true);
			}
			$file = $syspath."Permits_".date('mdY').".csv";
			chmod($file, 0777);
			if (file_put_contents($file, $data)){
				create_logs_per_transaction('exported a referential to excel', 'Permits', '', '', 'EXPORT', '');
				echo 1;
			}else{
				echo 0;
			}
		break;
		// xmer 09162019
	}
?>
