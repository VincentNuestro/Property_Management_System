<?php
	session_start();
	include "../../../connect.php";
	switch ($_POST['form']) {
		case 'fncSoundnperList':
			$page = $_POST['page'];
			$limit = ($page-1) * 20;
			$resSoundnper = mysql_query("SELECT SoundnperCode, SoundnperDesc, Amount FROM tblref_soundnper WHERE SoundnperCode LIKE '%". $_POST['key'] ."%' OR SoundnperDesc LIKE '%". $_POST['key'] ."%' GROUP BY SoundnperCode ORDER BY ". $_POST['SoundnperSortBy'] ." ". $_POST['SoundnperSortType'] ." LIMIT ". $limit .",20;", $connection) or die(mysql_error());
			while($rowSoundnper = mysql_fetch_array($resSoundnper)){
				echo 	"<tr id='". $rowSoundnper['SoundnperCode'] ."'>
							<td>". $rowSoundnper['SoundnperCode'] ."</td>
							<td>". $rowSoundnper['SoundnperDesc'] ."</td>
							<td style='text-align: right;'>". number_format($rowSoundnper['Amount'], 2, '.', ',') ."</td>
						</tr>";
			}
		break;

		case 'loadEntriesSoundnper':
			if($_POST["page"] == ""){
	            $page = 1;
	        }else{
	            $page = $_POST["page"];
	        }
    		$limit = ($page-1) * 20;
            $rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM tblref_soundnper WHERE SoundnperCode LIKE '%". $_POST['key'] ."%' OR SoundnperDesc LIKE '%". $_POST['key'] ."%';", $connection));
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

		case "loadPageSoundnper":
			$page = $_POST["page"];
			$rowCount = mysql_fetch_row(mysql_query("SELECT COUNT(id) FROM tblref_soundnper WHERE SoundnperCode LIKE '%". $_POST['key'] ."%' OR SoundnperDesc LIKE '%". $_POST['key'] ."%';", $connection));
			$rowsperpage = 20;
			$range = 1;
			$totalpages = ceil($rowCount[0] / $rowsperpage);
			$prevpage;
			$nextpage;
			// if not on page 1, don't show back links
			if($page > 1 ){
			   	echo "<li style='width:50px !important;' onclick='fncPageSoundnper(1)'><< First</li>";
			   	$prevpage = $page - 1;
			   	echo "<li style='width:70px !important;' onclick='fncPageSoundnper(". $prevpage .")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if(($x > 0) && ($x <= $totalpages)){
    			    if($x == $page){
                        echo "<li id='pgSoundnper" . $x . "' class='pgnumSoundnper active' onclick='fncPageSoundnper(" . $x . ",". $x .")'>" . $x . "</li>";
                    }else{
    			        echo "<li id='pgSoundnper" . $x . "' class='pgnumSoundnper' onclick='fncPageSoundnper(" . $x . ",". $x .")'>" . $x . "</li>";
                    }
		       	}
		    }
		    if($page < ($totalpages - $range)){
                echo "<li>...</li>";
            }
		    if($page != $totalpages && $rowCount[0] != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='fncPageSoundnper(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='fncPageSoundnper(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'fncSaveSoundnper':
			//INSERT LOG FIRST - JONAS - 12/5/2018
			$arrHeader = ["Soundnper Code", "Soundnper", "Amount"];
			$arrValue = [$_POST['Code'], $_POST['Soundnper'], number_format($_POST['Amount'], 2, '.', ',')];
			$Logs = createXinfo("INSERT", $arrHeader, "", $arrValue, "", "", "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("added a new Soundnper referential.", "Referential Module", $Logs, "" ,"ADD", "");
			}
			//INSERT LOG FIRST - JONAS - 12/5/2018
			$CheckExisting = mysql_num_rows(mysql_query("SELECT SoundnperCode FROM tblref_soundnper WHERE SoundnperCode = '". $_POST['Code'] ."';", $connection));
			if($CheckExisting == 0){
				$resInsertSoundnper = mysql_query("INSERT INTO tblref_soundnper SET SoundnperCode = '". mysql_escape_string(strtoupper($_POST['Code'])) ."', SoundnperDesc = '". mysql_escape_string(ucfirst($_POST['Soundnper'])) ."', Amount = '". floatval($_POST['Amount']) ."';", $connection);
				if($resInsertSoundnper == true){
					echo 1;
					//forAccIntegration($_POST['Code'], $_POST['Soundnper'], "", "INSERT");
				}
			}else{
				echo "Soundnper code already exist.";
			}
		break;

		case 'fncSoundnperSelected':
			$SoundnperInfo = mysql_fetch_array(mysql_query("SELECT SoundnperDesc, Amount, id FROM tblref_soundnper WHERE SoundnperCode = '". $_POST['id'] ."';", $connection));
			echo $SoundnperInfo['SoundnperDesc'] . "|" . number_format($SoundnperInfo['Amount'], 2, '.', ',') . "|" . $SoundnperInfo['id'];
		break;

		case 'fncUpdateSoundnper':
			//INSERT UPDATE LOG FIRST - JONAS - 12/5/2018
			$arrHeader = ["Soundnper Code", "Soundnper", "Amount"];
			$arrFields = ["SoundnperCode", "SoundnperDesc", "Amount"];
			$arrValue = [$_POST['Code'], $_POST['Soundnper'], number_format($_POST['Amount'], 2, '.', ',')];
			$Logs = createXinfo("UPDATE", $arrHeader, $arrFields, $arrValue, "tblref_soundnper", $_POST['SoundnperID'], "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("modified a ound System & Personnel referential.", "Referential Module", $Logs, "" ,"UPDATE", "");
			}
			//INSERT UPDATE LOG FIRST - JONAS - 12/5/2018
			$CurrCode = mysql_fetch_array(mysql_query("SELECT SoundnperCode FROM tblref_soundnper WHERE id = '". $_POST['SoundnperID'] ."';", $connection));
			$resUpdate = mysql_query("UPDATE tblref_soundnper SET SoundnperCode = '". mysql_escape_string(strtoupper($_POST['Code'])) ."', SoundnperDesc = '". mysql_escape_string(ucfirst($_POST['Soundnper'])) ."', Amount = '". floatval($_POST['Amount']) ."' WHERE id = '". $_POST['SoundnperID'] ."';", $connection);
			if($resUpdate == true){
				echo 1;
				//forAccIntegration($_POST['Code'], $_POST['Soundnper'], $CurrCode[0], "UPDATE");
			}
		break;

		case 'fncClickDeleteSoundnper':
			//INSERT DELETE LOG FIRST - JONAS - 12/5/2018
			$arrHeader = ["Soundnper Code", "Soundnper", "Amount"];
			$arrFields = ["SoundnperCode", "SoundnperDesc", "Amount"];
			$Logs = createXinfo("DELETE", $arrHeader, $arrFields, "", "tblref_soundnper", $_POST['Code'], "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("deleted a Sound System & Personnel referential.", "Referential Module", $Logs, "", "DELETE", "");
			}
			//INSERT DELETE LOG FIRST - JONAS - 12/5/2018
			$resDelete = mysql_query("DELETE FROM tblref_soundnper WHERE id = '". $_POST['Code'] ."';", $connection);
			if($resDelete == true){
				echo 1;
				//forAccIntegration($_POST['Code'], "", "", "DELETE");
			}
		break;

		case 'fncClickUpdateSoundnper':
			$row = mysql_fetch_array(mysql_query("SELECT COUNT(xcode) FROM tbltransaction WHERE xcode = '". $_POST['Code'] ."' AND isPenalty = '1';", $connection));
			if($row[0] >= 1){
				echo 1;
			}else{
				echo 0;
			}
		break;

		// xmer 09162019
		case 'AutoConsolidateSoundnper':
			$Penalty = "SELECT SoundnperCode, SoundnperDesc, Amount FROM tblref_soundnper WHERE SoundnperCode LIKE '%". $_POST['key'] ."%' OR SoundnperDesc LIKE '%". $_POST['key'] ."%' ORDER BY SoundnperDesc ASC ";
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
			$file = $syspath."Soundnper_".date('mdY').".csv";
			chmod($file, 0777);
			if (file_put_contents($file, $data)){
				create_logs_per_transaction('exported a referential to excel', 'Soundnper', '', '', 'EXPORT', '');
				echo 1;
			}else{
				echo 0;
			}
		break;
		// xmer 09162019
	}
?>