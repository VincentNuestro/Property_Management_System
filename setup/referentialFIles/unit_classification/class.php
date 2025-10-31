<?php
	session_start();
	include "../../../connect.php";
	switch ($_POST['form']) {
		case 'displayUnitClass':
			$page = $_POST['page'];
			$limit = ($page-1) * 20;
			if($_POST['ClassificationSortBy'] != "" && $_POST['ClassificationSortType'] != ""){
				$res = mysql_query("SELECT classificationID, classification FROM tblref_merchandise_class WHERE classification LIKE '%". $_POST['key'] ."%' OR classificationID LIKE '%". $_POST['key'] ."%' GROUP BY classificationID ORDER BY ". $_POST['ClassificationSortBy'] ." ". $_POST['ClassificationSortType'] ." LIMIT ".$limit.",20;", $connection);
			}else{
				$res = mysql_query("SELECT classificationID, classification FROM tblref_merchandise_class WHERE classification LIKE '%". $_POST['key'] ."%' OR classificationID LIKE '%". $_POST['key'] ."%' GROUP BY classificationID LIMIT 0,".$limit.",20;", $connection);
			}
			while($row = mysql_fetch_array($res)){
				echo   "<tr id='". $row[0] ."'>
							<td>". $row[0] ."</td>
							<td>". $row[1] ."</td>
						</tr>";
			}
		break;

		case 'loadEntriesClassification':
			if($_POST["page"] == ""){
	            $page = 1;
	        }else{
	            $page = $_POST["page"];
	        }
    		$limit = ($page-1) * 20;
            $rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM tblref_merchandise_class WHERE classification LIKE '%". $_POST['key'] ."%' OR classificationID LIKE '%". $_POST['key'] ."%';", $connection));
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

		case "loadPageClassification":
			$page = $_POST["page"];
			$rowCount = mysql_fetch_row(mysql_query("SELECT COUNT(id) FROM tblref_merchandise_class WHERE classification LIKE '%". $_POST['key'] ."%' OR classificationID LIKE '%". $_POST['key'] ."%';", $connection));
			$rowsperpage = 20;
			$range = 1;
			$totalpages = ceil($rowCount[0] / $rowsperpage);
			$prevpage;
			$nextpage;
			// if not on page 1, don't show back links
			if($page > 1 ){
			   	echo "<li style='width:50px !important;' onclick='fncPageClassification(1)'><< First</li>";
			   	$prevpage = $page - 1;
			   	echo "<li style='width:70px !important;' onclick='fncPageClassification(". $prevpage .")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if(($x > 0) && ($x <= $totalpages)){
    			    if($x == $page){
                        echo "<li id='pgClassification" . $x . "' class='pgnumClassification active' onclick='fncPageClassification(" . $x . ",". $x .")'>" . $x . "</li>";
                    }else{
    			        echo "<li id='pgClassification" . $x . "' class='pgnumClassification' onclick='fncPageClassification(" . $x . ",". $x .")'>" . $x . "</li>";
                    }
		       	}
		    }
		    if($page < ($totalpages - $range)){
                echo "<li>...</li>";
            }
		    if($page != $totalpages && $rowCount[0] != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='fncPageClassification(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='fncPageClassification(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'selectedClass':
			$row = mysql_fetch_array(mysql_query("SELECT id, classificationID, classification FROM tblref_merchandise_class WHERE classificationID = '". $_POST['id'] ."';", $connection));
			echo $row[0] . "|" . utf8_encode($row[1]) . "|" . utf8_encode($row[2]);
		break;

		case 'saveClass':
			$rowcheck = mysql_fetch_array(mysql_query("SELECT classificationID FROM tblref_merchandise_class WHERE classificationID = '". $_POST['classCode'] ."';", $connection));
			if($rowcheck[0] == ""){
				// $rowdesc = mysql_fetch_array(mysql_query("SELECT classification FROM tblref_merchandise_class WHERE classification = '". $_POST['classDesc'] ."' "));
				// if($rowdesc[0] == "")
				// {
					$res = mysql_query("INSERT INTO tblref_merchandise_class SET classificationID = '". mysql_escape_string(strtoupper($_POST['classCode'])) ."', classification = '". mysql_escape_string(ucfirst($_POST['classDesc'])) ."';", $connection);
					if($res == true){
						echo 1;
					}
					if($_POST['classCode'] != ""){
						$Logs .= "Classification Code : ". $_POST['classCode'] . "|";
					}
					// if($_POST['classDesc'] != ""){
					// 	$Logs .= "Classification Description : ". utf8_encode($_POST['classDesc']) . "|";
					// }
					if($Logs != ""){
						$tran_logs = create_logs_per_transaction("added a new classification referential.", "Referential Module", $Logs, "" ,"ADD", "");
					}
				// }
				// else{
				// 	echo "Classification description already exist.";
				// }
			}
			else{
				echo "Classification code already exist.";
			}
		break;

		case 'updateClass':
			$CurrentRef = mysql_fetch_array(mysql_query("SELECT classificationID, classification FROM tblref_merchandise_class WHERE id = '". $_POST['hiddenclassid'] ."';", $connection));
			$res = mysql_query("UPDATE tblref_merchandise_class SET classificationID = '". mysql_escape_string(strtoupper($_POST['classCode'])) ."', classification = '". mysql_escape_string(ucfirst($_POST['classDesc'])) ."' WHERE id = '". $_POST['hiddenclassid'] ."';", $connection);
			if($res == true){
				echo 1;
				if($CurrentRef['classificationID'] != $_POST['classCode']){
					if($CurrentRef['classificationID'] == ""){
						$Logs .= "Classification Code : ". $_POST['classCode'] . "|";
					}else{
						$Logs .= "Classification Code : From ". $CurrentRef['classificationID'] ." To ". $_POST['classCode'] . "|";
					}
				}
				if($CurrentRef['classification'] != $_POST['classDesc']){
					if($CurrentRef['classification'] == ""){
						$Logs .= "Classification Description : ". $_POST['classDesc'] . "|";
					}else{
						$Logs .= "Classification Description : From ". $CurrentRef['classification'] ." To ". $_POST['classDesc'] . "|";
					}
				}
				if($Logs != ""){
					$tran_logs = create_logs_per_transaction("modified a classification referential.", "Referential Module", $Logs, "" ,"UPDATE", "");
				}
			}
		break;

		case 'deleteClass':
			$CurrentRef = mysql_fetch_array(mysql_query("SELECT classificationID, classification FROM tblref_merchandise_class WHERE classificationID = '". $_POST['classCode'] ."';", $connection));
			$res = mysql_query("DELETE FROM tblref_merchandise_class WHERE classificationID = '". $_POST['classCode'] ."';", $connection);
			if($res == true){
				echo 1;
				$Logs .= "Classification Code : ". $CurrentRef['classCode'] . "|";
				$Logs .= "Classification Description : ". $CurrentRef['classification'] . "|";
				if($Logs != ""){
					$tran_logs = create_logs_per_transaction("deleted a classification referential.", "Referential Module", $Logs, "" ,"DELETE", "");
				}
			}
		break;

		case 'chkRecord':
			$row = mysql_fetch_array(mysql_query("SELECT COUNT(classid) FROM tblref_unit WHERE classid = '". $_POST['classCode'] ."';", $connection));
			if($row[0] >= 1){
				echo 1;
			}else{
				echo 0;
			}
		break;

		case 'AutoConsolidateClassification':
			$Classification = "SELECT classificationID, classification FROM tblref_merchandise_class WHERE classification LIKE '%". $_POST['key'] ."%' OR classificationID LIKE '%". $_POST['key'] ."%' ORDER BY classification ASC ";
			$resclassification = mysql_query($Classification, $connection);
			$data = "ClassificationID,Classification\r\n";
			while($rowclassification = mysql_fetch_array($resclassification)){
				$data .= $rowclassification[0].",".$rowclassification[1]."\r\n";
			}
			$filepath = mysql_fetch_array(mysql_query("SELECT filepath FROM tblsys_setup", $connection));
			$syspath = str_replace("\\", "/", $filepath[0]);
			if (!file_exists($syspath)){
				mkdir($syspath, 0777, true);
			}
			$file = $syspath."Unit_Classification_".date('mdY').".csv";
			chmod($file, 0777);
			if (file_put_contents($file, $data)){
			create_logs_per_transaction('exported a referential to excel', 'Unit Classification', '', '', 'EXPORT', '');
				echo 1;
			}else{
				echo 0;
			}
		break;
	}
?>