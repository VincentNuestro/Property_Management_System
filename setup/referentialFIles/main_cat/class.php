<?php
	session_start();
	include "../../../connect.php";
	switch ($_POST['form']) {
		case 'displayMainCat':
			$page = $_POST['page'];
			$limit = ($page-1) * 20;
			$sql = "SELECT category_id, category, icon, Maintenance_Type FROM tblmaintenance_category WHERE Category LIKE '%". $_POST['key'] ."%' OR category_id LIKE '%". $_POST['key'] ."%' OR Maintenance_Type LIKE '%". $_POST['key'] ."%' GROUP BY category_id ORDER BY ". $_POST['MainCatSortBy'] ." ". $_POST['MainCatSortType'] ." LIMIT ".$limit.",20;";
			$res = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($res)){

				if($row["icon"] == ""){
					$img = "assets/images/noimage5.png";
				}else{
					if(!file_exists("../../../../Mall_Attachments/Maintenance/Category/".$row[2])){ 
						$img = "assets/images/noimage5.png";
					}else{
						$img = "../Mall_Attachments/Maintenance/Category/".$row[2];
					}
				}

				if($row['isReading'] == "1"){
					$MeterReading = "Electric Reading";
				}else if($row['isReading'] == "2"){
					$MeterReading = "Water Reading";
				}else if($row['isReading'] == "3"){
					$MeterReading = "Gas Reading";
				}else{
					$MeterReading = "";
				}
				echo "	<tr id=". $row[0] .">
						<td class='center'><img style='margin-right: 5px;' src='". $img ."' width='20px' height='20px' /></td>
						<td>". $row[0] ."</td>
						<td>". $row[1] ."</td>
						<td>". $row[3] ."</td>
						<td>". $MeterReading ."</td>
					</tr>";
			}
		break;

		case 'loadEntriesMainCat':
			if($_POST["page"] == ""){
	            $page = 1;
	        }else{
	            $page = $_POST["page"];
	        }
    		$limit = ($page-1) * 20;
            $rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM tblmaintenance_category WHERE Category LIKE '%". $_POST['key'] ."%' OR category_id LIKE '%". $_POST['key'] ."%' OR Maintenance_Type LIKE '%". $_POST['key'] ."%'", $connection));
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

		case "loadPageMainCat":
			$page = $_POST["page"];
			$rowCount = mysql_fetch_row(mysql_query("SELECT COUNT(id) FROM tblmaintenance_category WHERE Category LIKE '%". $_POST['key'] ."%' OR category_id LIKE '%". $_POST['key'] ."%' OR Maintenance_Type LIKE '%". $_POST['key'] ."%'", $connection));
			$rowsperpage = 20;
			$range = 1;
			$totalpages = ceil($rowCount[0] / $rowsperpage);
			$prevpage;
			$nextpage;
			// if not on page 1, don't show back links
			if($page > 1 ){
			   	echo "<li style='width:50px !important;' onclick='fncPageMainCat(1)'><< First</li>";
			   	$prevpage = $page - 1;
			   	echo "<li style='width:70px !important;' onclick='fncPageMainCat(". $prevpage .")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if(($x > 0) && ($x <= $totalpages)){
    			    if($x == $page){
                        echo "<li id='pgMainCat" . $x . "' class='pgnumMainCat active' onclick='fncPageMainCat(" . $x . ",". $x .")'>" . $x . "</li>";
                    }else{
    			        echo "<li id='pgMainCat" . $x . "' class='pgnumMainCat' onclick='fncPageMainCat(" . $x . ",". $x .")'>" . $x . "</li>";
                    }
		       	}
		    }
		    if($page < ($totalpages - $range)){
                echo "<li>...</li>";
            }
		    if($page != $totalpages && $rowCount[0] != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='fncPageMainCat(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='fncPageMainCat(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'selectedMainCat':
			$row = mysql_fetch_array(mysql_query("SELECT category_id, category, icon, Maintenance_Type, isFixed, FixedAmount, AddTask, id, isReading FROM tblmaintenance_category WHERE category_id = '". $_POST['id'] ."';", $connection));

			if($row[2] == ""){
				$image = "assets/images/noimage5.png";
			}else{
				if(!file_exists("../../../../Mall_Attachments/Maintenance/Category/".$row[2])){ 
					$image = "assets/images/noimage5.png";
				}else{
					$image = "../Mall_Attachments/Maintenance/Category/".$row[2];
				}
			}
			echo $row[0] . "|" . utf8_encode($row[1]) . "|" . $image . "|" . $row[3] . "|" . $row[4] . "|" . $row[5] . "|" . $row[6] . "|" . $row['id'] . "|" . $row['isReading'];
		break;

		case 'saveMainCat':
			$rowcheck = mysql_fetch_array(mysql_query("SELECT category_id FROM tblmaintenance_category WHERE category_id = '". $_POST['MainCatCode'] ."';", $connection));
			if($rowcheck[0] == ""){	
				$rowdesc = mysql_fetch_array(mysql_query("SELECT category, id FROM tblmaintenance_category WHERE category = '". $_POST['MainCatDesc'] ."';", $connection));
				if($rowdesc[0] == ""){
					$res = mysql_query("INSERT INTO tblmaintenance_category SET category_id = '". mysql_escape_string(strtoupper($_POST['MainCatCode'])) ."', category = '". mysql_escape_string(ucfirst($_POST['MainCatDesc'])) ."', Maintenance_Type = '". $_POST['MainCatType'] ."', isFixed = '". $_POST['isFixed'] ."', FixedAmount = '". $_POST['FixedAmount'] ."', AddTask = '". $_POST['AddTask'] ."', isReading = '". $_POST['MainisReading'] ."';", $connection);
					if($res == true){
						echo "1"."|".$rowdesc['id'];
						forAccIntegration($_POST['MainCatCode'], $_POST['MainCatDesc'], "", "INSERT");
						//INSERT LOG FIRST - JONAS - 12/7/2018
						if($_POST['MainCatCode'] != ""){
							$Logs .= "Category ID : ". $_POST['MainCatCode'] . "|";
						}
						if($_POST['MainCatDesc'] != ""){
							$Logs .= "Category : ". $_POST['MainCatDesc'] . "|";
						}
						if($_POST['MainCatType'] != ""){
							$Logs .= "Maintenance Type : ". $_POST['MainCatType'] . "|";
						}
						if($_POST['isFixed'] != ""){
							$Logs .= "Fixed Payment : ". $_POST['isFixed'] . "|";
							if($_POST['isFixed'] == "Yes"){
								if($_POST['FixedAmount'] != "" || $_POST['FixedAmount'] == 0){
									$Logs .= "Amount : ". number_format($_POST['FixedAmount'], 2, '.', ',') . "|";
								}
							}
						}
						if($_POST['AddTask'] != ""){
							$Logs .= "Can Add Task : ". $_POST['AddTask'] . "|";
						}
						if($Logs != ""){
							$tran_logs = create_logs_per_transaction("added a new maintenance category referential.", "Referential Module", $Logs, "" ,"ADD", "");
						}
						// INSERT LOG FIRST - JONAS - 12/7/2018
					}
				}
				else{
					echo "Category description already exist.";
				}
			}else {
				echo "Category Code already exist.";
			}
		break;

		case 'updateMainCat':
			$CurrentRef = mysql_fetch_array(mysql_query("SELECT id, category_id, category, Maintenance_Type, isFixed, FixedAmount, AddTask FROM tblmaintenance_category WHERE id = '". $_POST['MainCatID'] ."' "));
			$res = mysql_query("UPDATE tblmaintenance_category SET category_id = '". mysql_escape_string(strtoupper($_POST['MainCatCode'])) ."', category = '". mysql_escape_string(ucfirst($_POST['MainCatDesc'])) ."', Maintenance_Type = '". $_POST['MainCatType'] ."', isFixed = '". $_POST['isFixed'] ."', FixedAmount = '". $_POST['FixedAmount'] ."', AddTask = '". $_POST['AddTask'] ."', isReading = '". $_POST['MainisReading'] ."' WHERE id = '". $_POST['MainCatID'] ."';", $connection);
			if($res == true){
				echo "1"."|".$CurrentRef['id'];
				forAccIntegration($_POST['MainCatCode'], $_POST['MainCatDesc'], $id['category_id'], "UPDATE");
				//INSERT UPDATE LOG FIRST - JONAS - 12/7/2018
				if($CurrentRef['category_id'] != $_POST['MainCatCode']){
					if($CurrentRef['category_id'] == ""){
						$Logs .= "Category ID : ". $_POST['MainCatCode'] . "|";
					}else{
						$Logs .= "Category ID : From ". $CurrentRef['category_id'] ." To ". $_POST['MainCatCode'] . "|";
					}
				}
				if($CurrentRef['category'] != $_POST['MainCatDesc']){
					if($CurrentRef['category'] == ""){
						$Logs .= "Category : ". $_POST['MainCatDesc'] . "|";
					}else{
						$Logs .= "Category : From ". $CurrentRef['category'] ." To ". $_POST['MainCatDesc'] . "|";
					}
				}
				if($CurrentRef['Maintenance_Type'] != $_POST['MainCatType']){
					if($CurrentRef['Maintenance_Type'] == ""){
						$Logs .= "Fixed Payment : ". $_POST['MainCatType'] . "|";
					}else{
						$Logs .= "Fixed Payment : From ". $CurrentRef['Maintenance_Type'] ." To ". $_POST['MainCatType'] . "|";
					}
				}
				if($CurrentRef['isFixed'] != $_POST['isFixed']){
					if($CurrentRef['isFixed'] == ""){
						$Logs .= "Maintenance Type : ". $_POST['isFixed'] . "|";
					}else{
						$Logs .= "Maintenance Type : From ". $CurrentRef['isFixed'] ." To ". $_POST['isFixed'] . "|";
					}
					if($_POST['isFixed'] == "Yes"){
						if($CurrentRef['FixedAmount'] == "" || $CurrentRef['FixedAmount'] == 0){
							$Logs .= "Amount : ". number_format($_POST['FixedAmount'], 2, '.', ',') . "|";
						}else{
							$Logs .= "Amount : From ". $CurrentRef['FixedAmount'] ." To ". number_format($_POST['FixedAmount'], 2, '.', ',') . "|";
						}
					}
				}
				if($CurrentRef['AddTask'] != $_POST['AddTask']){
					if($CurrentRef['AddTask'] == ""){
						$Logs .= "Can Add Task : ". $_POST['AddTask'] . "|";
					}else{
						$Logs .= "Can Add Task : From ". $CurrentRef['AddTask'] ." To ". $_POST['AddTask'] . "|";
					}
				}
				if($Logs != ""){
					$tran_logs = create_logs_per_transaction("modified a maintenance category referential.", "Referential Module", $Logs, "" ,"UPDATE", "");
				}
				//INSERT UPDATE LOG FIRST - JONAS - 12/7/2018
			}
		break;

		case 'deleteMainCat':
			//INSERT DELETE LOG FIRST - JONAS - 12/7/2018
			$arrHeader = ["Category ID", "Category", "Maintenance Type", "Fixed Payment", "Amount", "Can Add Task"];
			$arrFields = ["category_id", "category", "Maintenance_Type", "isFixed", "FixedAmount", "AddTask"];
			$Logs = createXinfo("DELETE", $arrHeader, $arrFields, "", "tblmaintenance_category", $_POST['MainCatID'], "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("deleted a maintenance category referential.", "Referential Module", $Logs, "" ,"DELETE", "");
			}
			//INSERT DELETE LOG FIRST - JONAS - 12/7/2018
			$CurrentRef = mysql_fetch_array(mysql_query("SELECT category_id, icon FROM tblmaintenance_category WHERE id = '". $_POST['MainCatID'] ."';", $connection));
			$res = mysql_query("DELETE FROM tblmaintenance_category WHERE id = '". $_POST['MainCatID'] ."';", $connection);
			if($res == true){
				echo 1;
				unlink("../../../../Mall_Attachments/Maintenance/Category/" . $CurrentRef['icon']);
				forAccIntegration($CurrentRef['category_id'], "", "", "DELETE");
			}
		break;

		case 'clickUpdateMainCat':
			$row = mysql_fetch_array(mysql_query("SELECT isFixed FROM tblmaintenance_category WHERE category_id = '". $_POST['MainCatCode'] ."';", $connection));
			$row2 = mysql_fetch_array(mysql_query("SELECT COUNT(xcategory) FROM tblmaintenance_workorderlist WHERE xcategory = '". $_POST['MainCatCode'] ."'", $connection));
			if($row2[0] >= 1){
				echo "1|".$row[0];
			}else{
				echo "0|".$row[0];
			}
		break;

		case 'AutoConsolidateCategory':
			$Category = "SELECT category_id, category, icon, Maintenance_Type FROM tblmaintenance_category WHERE Category LIKE '%". $_POST['key'] ."%' OR category_id LIKE '%". $_POST['key'] ."%' OR Maintenance_Type LIKE '%". $_POST['key'] ."%' ORDER BY category ASC ";
			$resclassification = mysql_query($Category, $connection);
			$data = "CategoryID,Category,icon,Maintenance_Type\r\n";
			while($rowclassification = mysql_fetch_array($resclassification)){
				$data .= $rowclassification[0].",".$rowclassification[1].",".$rowclassification[2].",".$rowclassification[3]."\r\n";
			}
			$filepath = mysql_fetch_array(mysql_query("SELECT filepath FROM tblsys_setup", $connection));
			$syspath = str_replace("\\", "/", $filepath[0]);
			if (!file_exists($syspath)){
				mkdir($syspath, 0777, true);
			}
			$file = $syspath."Maintenance_Category_".date('mdY').".csv";
			chmod($file, 0777);
			if (file_put_contents($file, $data)){
			create_logs_per_transaction('exported a referential to excel', 'Maintenance Category', '', '', 'EXPORT', '');
				echo 1;
			}else{
				echo 0;
			}
		break;
	}
?>