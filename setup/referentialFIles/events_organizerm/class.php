<?php
	session_start();
	include "../../../connect.php";
	switch ($_POST['form']) {
		case 'fncOrganizermList':
			$page = $_POST['page'];
			$limit = ($page-1) * 20;
			$resOrganizerm = mysql_query("SELECT OrganizermCode, OrganizermDesc FROM tblref_organizerm WHERE OrganizermCode LIKE '%". $_POST['key'] ."%' OR OrganizermDesc LIKE '%". $_POST['key'] ."%' GROUP BY OrganizermCode ORDER BY ". $_POST['OrganizermSortBy'] ." ". $_POST['OrganizermSortType'] ." LIMIT ". $limit .",20;", $connection) or die(mysql_error());
			while($rowOrganizerm = mysql_fetch_array($resOrganizerm)){
				echo 	"<tr id='". $rowOrganizerm['OrganizermCode'] ."'>
							<td>". $rowOrganizerm['OrganizermCode'] ."</td>
							<td>". $rowOrganizerm['OrganizermDesc'] ."</td>
						</tr>";
			}
		break;

		case 'loadEntriesOrganizerm':
			if($_POST["page"] == ""){
	            $page = 1;
	        }else{
	            $page = $_POST["page"];
	        }
    		$limit = ($page-1) * 20;
            $rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM tblref_organizerm WHERE OrganizermCode LIKE '%". $_POST['key'] ."%' OR OrganizermDesc LIKE '%". $_POST['key'] ."%';", $connection));
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

		case "loadPageOrganizerm":
			$page = $_POST["page"];
			$rowCount = mysql_fetch_row(mysql_query("SELECT COUNT(id) FROM tblref_organizerm WHERE OrganizermCode LIKE '%". $_POST['key'] ."%' OR OrganizermDesc LIKE '%". $_POST['key'] ."%';", $connection));
			$rowsperpage = 20;
			$range = 1;
			$totalpages = ceil($rowCount[0] / $rowsperpage);
			$prevpage;
			$nextpage;
			// if not on page 1, don't show back links
			if($page > 1 ){
			   	echo "<li style='width:50px !important;' onclick='fncPageOrganizerm(1)'><< First</li>";
			   	$prevpage = $page - 1;
			   	echo "<li style='width:70px !important;' onclick='fncPageOrganizerm(". $prevpage .")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if(($x > 0) && ($x <= $totalpages)){
    			    if($x == $page){
                        echo "<li id='pgOrganizerm" . $x . "' class='pgnumOrganizerm active' onclick='fncPageOrganizerm(" . $x . ",". $x .")'>" . $x . "</li>";
                    }else{
    			        echo "<li id='pgOrganizerm" . $x . "' class='pgnumOrganizerm' onclick='fncPageOrganizerm(" . $x . ",". $x .")'>" . $x . "</li>";
                    }
		       	}
		    }
		    if($page < ($totalpages - $range)){
                echo "<li>...</li>";
            }
		    if($page != $totalpages && $rowCount[0] != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='fncPageOrganizerm(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='fncPageOrganizerm(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'fncSaveOrganizerm':
			//INSERT LOG FIRST - JONAS - 12/5/2018
			$arrHeader = ["Organizerm Code", "Organizerm"];
			$arrValue = [$_POST['Code'], $_POST['Organizerm']];
			$Logs = createXinfo("INSERT", $arrHeader, "", $arrValue, "", "", "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("added a new Organizer Material referential.", "Referential Module", $Logs, "" ,"ADD", "");
			}
			//INSERT LOG FIRST - JONAS - 12/5/2018
			$CheckExisting = mysql_num_rows(mysql_query("SELECT OrganizermCode FROM tblref_organizerm WHERE OrganizermCode = '". $_POST['Code'] ."';", $connection));
			if($CheckExisting == 0){
				$resInsertOrganizerm = mysql_query("INSERT INTO tblref_organizerm SET OrganizermCode = '". mysql_escape_string(strtoupper($_POST['Code'])) ."', OrganizermDesc = '". mysql_escape_string(ucfirst($_POST['Organizerm'])) ."' ;", $connection);
				if($resInsertOrganizerm == true){
					echo 1;
					//forAccIntegration($_POST['Code'], $_POST['Organizerm'], "", "INSERT");
				}
			}else{
				echo "Organizerm code already exist.";
			}
		break;

		case 'fncOrganizermSelected':
			$OrganizermInfo = mysql_fetch_array(mysql_query("SELECT OrganizermDesc, id FROM tblref_organizerm WHERE OrganizermCode = '". $_POST['id'] ."';", $connection));
			echo $OrganizermInfo['OrganizermDesc'] . "|" . $OrganizermInfo['id'];
		break;

		case 'fncUpdateOrganizerm':
			//INSERT UPDATE LOG FIRST - JONAS - 12/5/2018
			$arrHeader = ["Organizerm Code", "Organizerm"];
			$arrFields = ["OrganizermCode", "OrganizermDesc"];
			$arrValue = [$_POST['Code'], $_POST['Organizerm']];
			$Logs = createXinfo("UPDATE", $arrHeader, $arrFields, $arrValue, "tblref_organizerm", $_POST['OrganizermID'], "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("modified a Organizer Material referential.", "Referential Module", $Logs, "" ,"UPDATE", "");
			}
			//INSERT UPDATE LOG FIRST - JONAS - 12/5/2018
			$CurrCode = mysql_fetch_array(mysql_query("SELECT OrganizermCode FROM tblref_organizerm WHERE id = '". $_POST['OrganizermID'] ."';", $connection));
			$resUpdate = mysql_query("UPDATE tblref_organizerm SET OrganizermCode = '". mysql_escape_string(strtoupper($_POST['Code'])) ."', OrganizermDesc = '". mysql_escape_string(ucfirst($_POST['Organizerm'])) ."' WHERE id = '". $_POST['OrganizermID'] ."';", $connection) or die(mysql_error());
			if($resUpdate == true){
				echo 1;
				//forAccIntegration($_POST['Code'], $_POST['Organizerm'], $CurrCode[0], "UPDATE");
			}
		break;

		case 'fncClickDeleteOrganizerm':
			//INSERT DELETE LOG FIRST - JONAS - 12/5/2018
			$arrHeader = ["Organizerm Code", "Organizerm"];
			$arrFields = ["OrganizermCode", "OrganizermDesc"];
			$Logs = createXinfo("DELETE", $arrHeader, $arrFields, "", "tblref_organizerm", $_POST['Code'], "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("deleted a Organizer Material referential.", "Referential Module", $Logs, "", "DELETE", "");
			}
			//INSERT DELETE LOG FIRST - JONAS - 12/5/2018
			$resDelete = mysql_query("DELETE FROM tblref_organizerm WHERE id = '". $_POST['Code'] ."';", $connection);
			if($resDelete == true){
				echo 1;
				//forAccIntegration($_POST['Code'], "", "", "DELETE");
			}
		break;

		case 'fncClickUpdateOrganizerm':
			$row = mysql_fetch_array(mysql_query("SELECT COUNT(xcode) FROM tbltransaction WHERE xcode = '". $_POST['Code'] ."' AND isPenalty = '1';", $connection));
			if($row[0] >= 1){
				echo 1;
			}else{
				echo 0;
			}
		break;

		// xmer 09162019
		case 'AutoConsolidateOrganizerm':
			$Penalty = "SELECT OrganizermCode, OrganizermDesc FROM tblref_organizerm WHERE OrganizermCode LIKE '%". $_POST['key'] ."%' OR OrganizermDesc LIKE '%". $_POST['key'] ."%' ORDER BY OrganizermDesc ASC ";
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
			$file = $syspath."Organizerm_".date('mdY').".csv";
			chmod($file, 0777);
			if (file_put_contents($file, $data)){
				create_logs_per_transaction('exported a referential to excel', 'Organizerm', '', '', 'EXPORT', '');
				echo 1;
			}else{
				echo 0;
			}
		break;
		// xmer 09162019
	}
?>