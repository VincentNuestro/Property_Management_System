<?php  
	session_start();
	include "../../../connect.php";
	switch ($_POST['form']) {
		case 'displayListofSource':
			$page = $_POST['page'];
			$limit = ($page-1) * 20;
			$res = mysql_query("SELECT id, source_code, source_desc FROM tblref_source WHERE source_desc LIKE '%". $_POST['key'] ."%' GROUP BY source_code ORDER BY ". $_POST['SourceSortBy'] ." ". $_POST['SourceSortType'] ."  LIMIT ". $limit .",20;", $connection);
			while($row = mysql_fetch_array($res)){
				if($row[2] == "1"){
					$lol = "Yes";
				}else{
					$lol = "No";
				}
				echo 	"<tr id=". $row['id'] .">
							<td>". $row['source_code'] ."</td>
							<td>". $row['source_desc'] ."</td>
						</tr>";
			}
		break;

		case 'loadEntriesSource':
			if($_POST["page"] == ""){
	            $page = 1;
	        }else{
	            $page = $_POST["page"];
	        }
    		$limit = ($page-1) * 20;
            $rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM tblref_source WHERE source_desc LIKE '%". $_POST['key'] ."%';", $connection));
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

		case "loadPageSource":
			$page = $_POST["page"];
			$rowCount = mysql_fetch_row(mysql_query("SELECT COUNT(id) FROM tblref_source WHERE source_desc LIKE '%". $_POST['key'] ."%';", $connection));
			$rowsperpage = 20;
			$range = 1;
			$totalpages = ceil($rowCount[0] / $rowsperpage);
			$prevpage;
			$nextpage;
			// if not on page 1, don't show back links
			if($page > 1 ){
			   	echo "<li style='width:50px !important;' onclick='fncPageSource(1)'><< First</li>";
			   	$prevpage = $page - 1;
			   	echo "<li style='width:70px !important;' onclick='fncPageSource(". $prevpage .")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if(($x > 0) && ($x <= $totalpages)){
    			    if($x == $page){
                        echo "<li id='pgSource" . $x . "' class='pgnumSource active' onclick='fncPageSource(" . $x . ",". $x .")'>" . $x . "</li>";
                    }else{
    			        echo "<li id='pgSource" . $x . "' class='pgnumSource' onclick='fncPageSource(" . $x . ",". $x .")'>" . $x . "</li>";
                    }
		       	}
		    }
		    if($page < ($totalpages - $range)){
                echo "<li>...</li>";
            }
		    if($page != $totalpages && $rowCount[0] != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='fncPageSource(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='fncPageSource(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'fncloadSelectedSource':
			$row = mysql_fetch_array(mysql_query("SELECT source_code, source_desc FROM tblref_source WHERE id = '". $_POST['id'] ."';", $connection));
			if($row['override'] == 1){
				$Yes = "1";
			}else{
				$Yes = "2";
			}
			echo $row['source_code'] ."|". $row['source_desc'];
		break;

		case 'saveSource':
			$rowcheck = mysql_fetch_array(mysql_query("SELECT source_code FROM tblref_typeofpermits WHERE source_code = '". $_POST['SourceCode'] ."';", $connection));
			if($rowcheck[0] == ""){
				$res = mysql_query("INSERT INTO tblref_source SET source_code = '". mysql_escape_string(strtoupper($_POST['SourceCode'])) ."', source_desc = '". mysql_escape_string(ucfirst($_POST['SourceDesc'])) ."';", $connection);
				if($res == true){
					echo 1;
					//INSERT UPDATE LOG FIRST - JONAS - 12/5/2018
					$arrHeader = ["Code", "Description"];
					$arrValue = [mysql_escape_string(strtoupper($_POST['SourceCode'])), mysql_escape_string(ucfirst($_POST['SourceDesc']))];
					$Logs = createXinfo("INSERT", $arrHeader, "", $arrValue, "", "", "");
					if($Logs != ""){
						$tran_logs = create_logs_per_transaction("added a new source referential.", "Referential Module", $Logs, "" ,"ADD", "");
					}
					//INSERT UPDATE LOG FIRST - JONAS - 12/5/2018
				}
			}else{
				echo "Code already exist.";
			}
		break;

		case 'clickUpdateSource':
			$ifBlank = mysql_fetch_array(mysql_query("SELECT COUNT(inqSource) FROM tbltrans_inquiry WHERE inqSource = '". $_POST['SourceCode'] ."';", $connection));
			$ifBlank = mysql_fetch_array(mysql_query("SELECT COUNT(inqSource) FROM tbltrans_tenants WHERE inqSource = '". $_POST['SourceCode'] ."';", $connection));
			if($ifBlank[0] >= 1){
				echo 1;
			}else{
				echo 0;
			}
		break;

		case 'updateSource':
			//INSERT UPDATE LOG FIRST - JONAS - 12/5/2018
			$arrHeader = ["Code", "Description"];
			$arrFields = ["source_code", "source_desc"];
			$arrValue = [mysql_escape_string(strtoupper($_POST['SourceCode'])), mysql_escape_string(ucfirst($_POST['SourceDesc']))];
			$Logs = createXinfo("UPDATE", $arrHeader, $arrFields, $arrValue, "tblref_source", $_POST['hiddenSourceID'], "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("modified a source referential.", "Referential Module", $Logs, "" ,"UPDATE", "");
			}
			//INSERT UPDATE LOG FIRST - JONAS - 12/5/2018
			$res = mysql_query("UPDATE tblref_source SET source_code = '". mysql_escape_string(strtoupper($_POST['SourceCode'])) ."', source_desc = '". mysql_escape_string(ucfirst($_POST['SourceDesc'])) ."' WHERE id = '". $_POST['hiddenSourceID'] ."';", $connection);
			if($res == true){
				echo 1;
			}
		break;

		case 'deleteSource':
			//INSERT DELETE LOG FIRST - JONAS - 12/5/2018
			$arrHeader = ["Code", "Description"];
			$arrFields = ["source_code", "source_desc"];
			$Logs = createXinfo("DELETE", $arrHeader, $arrFields, "", "tblref_source", $_POST['hiddenSourceID'], "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("deleted a source referential.", "Referential Module", $Logs, "", "DELETE", "");
			}
			//INSERT DELETE LOG FIRST - JONAS - 12/5/2018
			$res = mysql_query("DELETE FROM tblref_source WHERE id = '". $_POST['hiddenSourceID'] ."';", $connection);
			if($res == true){
				echo 1;
			}
		break;

		// xmer 09162019
		case 'AutoConsolidateSource':
			$Permit = "SELECT source_code, source_desc FROM tblref_source WHERE source_desc LIKE '%". $_POST['key'] ."%'";
			$resclassification = mysql_query($Permit, $connection);
			$data = "Code,Description\r\n";
			while($rowclassification = mysql_fetch_array($resclassification)){
				$data .= $rowclassification[0].",".$rowclassification[1]."\r\n";
			}
			$filepath = mysql_fetch_array(mysql_query("SELECT filepath FROM tblsys_setup", $connection));
			$syspath = str_replace("\\", "/", $filepath[0]);
			if (!file_exists($syspath)){
				mkdir($syspath, 0777, true);
			}
			$file = $syspath."Source_".date('mdY').".csv";
			chmod($file, 0777);
			if (file_put_contents($file, $data)){
				create_logs_per_transaction('exported a referential to excel', 'Source', '', '', 'EXPORT', '');
				echo 1;
			}else{
				echo 0;
			}
		break;
		// xmer 09162019
	}
?>
