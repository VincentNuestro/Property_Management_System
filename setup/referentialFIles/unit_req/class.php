<?php
	session_start();
	include "../../../connect.php";
	switch ($_POST['form']) {
		case 'displayReq':
			$page = $_POST['page'];
			$limit = ($page-1) * 20;
			$res = mysql_query("SELECT reqCode, requirements, override, id FROM tblref_applicationrequirements WHERE requirements LIKE '%". $_POST['key'] ."%'  GROUP BY reqCode ORDER BY ". $_POST['RequirementsSortBy'] ." ". $_POST['RequirementsSortType'] ."  LIMIT ". $limit .",20;", $connection);
			while($row = mysql_fetch_array($res)){
				if($row[2] == "1"){
					$lol = "Yes";
				}else{
					$lol = "No";
				}
				echo 	"<tr id=". $row['id'] .">
							<td>". $row['reqCode'] ."</td>
							<td>". $row['requirements'] ."</td>
						</tr>";
			}
		break;

		case 'loadEntriesRequirements':
			if($_POST["page"] == ""){
	            $page = 1;
	        }else{
	            $page = $_POST["page"];
	        }
    		$limit = ($page-1) * 20;
            $rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM tblref_applicationrequirements WHERE requirements LIKE '%". $_POST['key'] ."%';", $connection));
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

		case "loadPageRequirements":
			$page = $_POST["page"];
			$rowCount = mysql_fetch_row(mysql_query("SELECT COUNT(id) FROM tblref_applicationrequirements WHERE requirements LIKE '%". $_POST['key'] ."%';", $connection));
			$rowsperpage = 20;
			$range = 1;
			$totalpages = ceil($rowCount[0] / $rowsperpage);
			$prevpage;
			$nextpage;
			// if not on page 1, don't show back links
			if($page > 1 ){
			   	echo "<li style='width:50px !important;' onclick='fncPageRequirements(1)'><< First</li>";
			   	$prevpage = $page - 1;
			   	echo "<li style='width:70px !important;' onclick='fncPageRequirements(". $prevpage .")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if(($x > 0) && ($x <= $totalpages)){
    			    if($x == $page){
                        echo "<li id='pgRequirements" . $x . "' class='pgnumRequirements active' onclick='fncPageRequirements(" . $x . ",". $x .")'>" . $x . "</li>";
                    }else{
    			        echo "<li id='pgRequirements" . $x . "' class='pgnumRequirements' onclick='fncPageRequirements(" . $x . ",". $x .")'>" . $x . "</li>";
                    }
		       	}
		    }
		    if($page < ($totalpages - $range)){
                echo "<li>...</li>";
            }
		    if($page != $totalpages && $rowCount[0] != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='fncPageRequirements(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='fncPageRequirements(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'selectedReq':
			$row = mysql_fetch_array(mysql_query("SELECT id, requirements, override, reqCode FROM tblref_applicationrequirements WHERE id = '". $_POST['id'] ."';", $connection));
			if($row['override'] == 1){
				$Yes = "1";
			}else{
				$Yes = "2";
			}
			echo $row['id'] ."|". utf8_encode($row['requirements']) ."|". $Yes ."|". $row['reqCode'];
		break;

		case 'saveReq':
			//INSERT LOG FIRST - JONAS - 12/5/2018
			$arrHeader = ["Requirement Code", "Requirement", "Override"];
			$arrValue = [$_POST['reqCode'], $_POST['reqDesc'], $_POST['override']];
			$Logs = createXinfo("INSERT", $arrHeader, "", $arrValue, "", "", "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("added a new requirement referential.", "Referential Module", $Logs, "" ,"ADD", "");
			}
			// INSERT LOG FIRST - JONAS - 12/5/2018
			$rowcheck = mysql_fetch_array(mysql_query("SELECT reqCode FROM tblref_applicationrequirements WHERE reqCode = '". $_POST['reqCode'] ."';", $connection));
			if($rowcheck[0] == ""){
				$res = mysql_query("INSERT INTO tblref_applicationrequirements SET reqCode = '". mysql_escape_string(strtoupper($_POST['reqCode'])) ."', requirements = '". mysql_escape_string(ucfirst($_POST['reqDesc'])) ."', override = '". $_POST['override'] ."';", $connection);
				if($res == true){
					echo 1;
				}
			}else{
				echo "Requirement Code already exist.";
			}
		break;

		case 'clickUpdateReq':
			$ifBlank = mysql_fetch_array(mysql_query("SELECT COUNT(type_req_ID) FROM tbltrans_leasingapplicationreq WHERE type_req_ID = '". $_POST['hiddenreqid'] ."';", $connection));
			if($ifBlank[0] >= 1){
				echo 1;
			}else{
				echo 0;
			}
		break;

		case 'updateReq':
			//INSERT UPDATE LOG FIRST - JONAS - 12/5/2018
			$arrHeader = ["Requirement Code", "Requirement", "Override"];
			$arrValue = [$_POST['reqCode'], $_POST['reqDesc'], $_POST['override']];
			$arrValue = [$_POST['reqDesc'], $_POST['override']];
			$Logs = createXinfo("UPDATE", $arrHeader, $arrFields, $arrValue, "tblref_applicationrequirements", $_POST['hiddenreqid'], "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("modified a requirement referential.", "Referential Module", $Logs, "" ,"UPDATE", "");
			}
			//INSERT UPDATE LOG FIRST - JONAS - 12/5/2018
			$res = mysql_query("UPDATE tblref_applicationrequirements SET reqCode = '". mysql_escape_string(strtoupper($_POST['reqCode'])) ."', requirements = '". mysql_escape_string(ucfirst($_POST['reqDesc'])) ."', override = '". $_POST['override'] ."' WHERE id = '". $_POST['hiddenreqid'] ."';", $connection);
			if($res == true){
				echo 1;
			}
		break;

		case 'deleteReq':
			//INSERT DELETE LOG FIRST - JONAS - 12/5/2018
			$arrHeader = ["Requirement", "Override"];
			$arrFields = ["requirements", "override"];
			$Logs = createXinfo("DELETE", $arrHeader, $arrFields, "", "tblref_applicationrequirements", $_POST['hiddenreqid'], "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("deleted a requirement referential.", "Referential Module", $Logs, "", "DELETE", "");
			}
			//INSERT DELETE LOG FIRST - JONAS - 12/5/2018
			$res = mysql_query("DELETE FROM tblref_applicationrequirements WHERE id = '". $_POST['hiddenreqid'] ."';", $connection);
			if($res == true){
				echo 1;
			}
		break;

		// xmer 09162019
		case 'AutoConsolidateReq':
			$Req = "SELECT reqCode, requirements, override, id FROM tblref_applicationrequirements WHERE requirements LIKE '%". $_POST['key'] ."%' ORDER BY requirements ASC ";
			$resclassification = mysql_query($Req, $connection);
			$data = "Code,Description,Override\r\n";
			while($rowclassification = mysql_fetch_array($resclassification)){
				$data .= $rowclassification[0].",".$rowclassification[1].",".$rowclassification[2]."\r\n";
			}
			$filepath = mysql_fetch_array(mysql_query("SELECT filepath FROM tblsys_setup", $connection));
			$syspath = str_replace("\\", "/", $filepath[0]);
			if (!file_exists($syspath)){
				mkdir($syspath, 0777, true);
			}
			$file = $syspath."Requirements_".date('mdY').".csv";
			chmod($file, 0777);
			if (file_put_contents($file, $data)){
			create_logs_per_transaction('exported a referential to excel', 'Requirements', '', '', 'EXPORT', '');
				echo 1;
			}else{
				echo 0;
			}
		break;
		// xmer 09162019
	}
?>