<?php
	session_start();
	include "../../../connect.php";
	switch ($_POST['form']) {
		case 'displaySetTask':
			$page = $_POST['page'];
			$limit = ($page-1) * 20;
			$sql = "SELECT b.category, a.taskid, a.description, a.amount, a.equipmentname FROM tblmaintenance_tasklist AS a LEFT JOIN tblmaintenance_category AS b ON a.xcategory = b.category_id WHERE a.description LIKE '%". $_POST['key'] ."%' OR b.category LIKE '%". $_POST['key'] ."%' OR a.taskid LIKE '%". $_POST['key'] ."%' OR a.amount LIKE '%". $_POST['key'] ."%' OR a.equipmentname LIKE '%". $_POST['key'] ."%' GROUP BY a.taskid ORDER BY ". $_POST['MainTaskSortBy'] ." ". $_POST['MainTaskSortType'] ." LIMIT ".$limit.",20;";
			$res = mysql_query($sql, $connection);
			while ( $row = mysql_fetch_array( $res ) ) {
				?>
					<tr id="<?php echo $row[1]; ?>">
						<td><?php echo $row[0]; ?></td>
						<td><?php echo $row[1]; ?></td>
						<td><?php echo $row[2]; ?></td>
						<td style="text-align: right;"><?php echo number_format($row[3], 2, '.', ','); ?></td>
						<td class="hide"><?php echo utf8_encode($row[4]); ?></td>
					</tr>
				<?php
			}
		break;

		case 'loadEntriesMainTask':
			if($_POST["page"] == ""){
	            $page = 1;
	        }else{
	            $page = $_POST["page"];
	        }
    		$limit = ($page-1) * 20;
            $rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(a.id) FROM tblmaintenance_tasklist AS a LEFT JOIN tblmaintenance_category AS b ON a.xcategory = b.category_id WHERE a.description LIKE '%". $_POST['key'] ."%' OR b.category LIKE '%". $_POST['key'] ."%' OR a.taskid LIKE '%". $_POST['key'] ."%' OR a.amount LIKE '%". $_POST['key'] ."%' OR a.equipmentname LIKE '%". $_POST['key'] ."%';", $connection));
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

		case "loadPageMainTask":
			$page = $_POST["page"];
			$rowCount = mysql_fetch_row(mysql_query("SELECT COUNT(a.id) FROM tblmaintenance_tasklist AS a LEFT JOIN tblmaintenance_category AS b ON a.xcategory = b.category_id WHERE a.description LIKE '%". $_POST['key'] ."%' OR b.category LIKE '%". $_POST['key'] ."%' OR a.taskid LIKE '%". $_POST['key'] ."%' OR a.amount LIKE '%". $_POST['key'] ."%' OR a.equipmentname LIKE '%". $_POST['key'] ."%';", $connection));
			$rowsperpage = 20;
			$range = 1;
			$totalpages = ceil($rowCount[0] / $rowsperpage);
			$prevpage;
			$nextpage;
			// if not on page 1, don't show back links
			if($page > 1 ){
			   	echo "<li style='width:50px !important;' onclick='fncPageMainTask(1)'><< First</li>";
			   	$prevpage = $page - 1;
			   	echo "<li style='width:70px !important;' onclick='fncPageMainTask(". $prevpage .")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if(($x > 0) && ($x <= $totalpages)){
    			    if($x == $page){
                        echo "<li id='pgMainTask" . $x . "' class='pgnumMainTask active' onclick='fncPageMainTask(" . $x . ",". $x .")'>" . $x . "</li>";
                    }else{
    			        echo "<li id='pgMainTask" . $x . "' class='pgnumMainTask' onclick='fncPageMainTask(" . $x . ",". $x .")'>" . $x . "</li>";
                    }
		       	}
		    }
		    if($page < ($totalpages - $range)){
                echo "<li>...</li>";
            }
		    if($page != $totalpages && $rowCount[0] != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='fncPageMainTask(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='fncPageMainTask(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'selectedSetTask':
			$row = mysql_fetch_array(mysql_query("SELECT xcategory, taskid, description, amount, equipmentid, id FROM tblmaintenance_tasklist WHERE taskid = '". $_POST['id'] ."';", $connection));
			echo $row['xcategory'] . "|" . utf8_encode($row['taskid']) . "|" . utf8_encode($row['description']) . "|" . number_format($row['amount'], 2, '.', ',') . "|" . utf8_encode($row['equipmentid']) . "|" . $row['id'];
		break;

		case 'saveSetTask':
			$rowequip = mysql_fetch_array(mysql_query("SELECT description FROM tblmaintenance_equip WHERE code = '". $_POST['setEquip'] ."' ", $connection));
			//INSERT LOG FIRST - JONAS - 12/7/2018
			$arrHeader = ["Task ID", "Task Description", "Task Category", "Amount", "Equipment"];
			$arrValue = [$_POST['setTaskCode'], $_POST['setTaskDesc'], $_POST['taskcat'], number_format($_POST['setTaskAmount'], 2, '.', ','), $rowequip[0]];
			$Logs = createXinfo("INSERT", $arrHeader, "", $arrValue, "", "", "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("added a new maintenance task referential.", "Referential Module", $Logs, "" ,"ADD", "");
			}
			//INSERT LOG FIRST - JONAS - 12/7/2018
			$rescheck = mysql_query("SELECT taskid FROM tblmaintenance_tasklist WHERE taskid = '". $_POST['setTaskCode'] ."';", $connection);
			$rowcheck = mysql_fetch_array($rescheck);
			if($rowcheck[0] == ""){
				// $rowdesc = mysql_fetch_array(mysql_query("SELECT description FROM tblmaintenance_tasklist WHERE description = '". $_POST['setTaskDesc'] ."';", $connection));
				// if($rowdesc[0] == ""){
					$res = mysql_query("INSERT INTO tblmaintenance_tasklist SET taskid = '". mysql_escape_string(strtoupper($_POST['setTaskCode'])) ."', description = '". mysql_escape_string(ucfirst($_POST['setTaskDesc'])) ."', xcategory = '". $_POST['taskcat'] ."', amount = '". $_POST['setTaskAmount'] ."', equipmentid = '". $_POST['setEquip'] ."', equipmentname = '". $rowequip[0] ."';", $connection);
					if($res == true){
						echo 1;
						forAccIntegration($_POST['setTaskCode'], $_POST['setTaskDesc'], "", "INSERT");
					}
				// }else{
				// 	echo "Task Description already exist.";
				// }
			}else{
				echo "Task Code already exist";
			}
		break;

		case 'updateSetTask':
			$rowequip = mysql_fetch_array(mysql_query("SELECT description FROM tblmaintenance_equip WHERE code = '". $_POST['setEquip'] ."';", $connection));
			//INSERT UPDATE LOG FIRST - JONAS - 12/7/2018
			$arrHeader = ["Task ID", "Task Description", "Task Category", "Amount", "Equipment"];
			$arrFields = ["taskid", "description", "xcategory", "amount", "equipmentname"];
			$arrValue = [$_POST['setTaskCode'], $_POST['setTaskDesc'], $_POST['taskcat'], number_format($_POST['setTaskAmount'], 2, '.', ','), $rowequip[0]];
			$Logs = createXinfo("UPDATE", $arrHeader, $arrFields, $arrValue, "tblmaintenance_tasklist", $_POST['hiddensettaskid'], "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("modified a maintenance task referential.", "Referential Module", $Logs, "" ,"UPDATE", "");
			}
			//INSERT UPDATE LOG FIRST - JONAS - 12/7/2018
			$CurrCode = mysql_fetch_array(mysql_query("SELECT taskid, description, xcategory, amount, equipmentid, equipmentname FROM tblmaintenance_tasklist WHERE id = '". $_POST['hiddensettaskid'] ."'", $connection));
			$res = mysql_query("UPDATE tblmaintenance_tasklist SET taskid = '". mysql_escape_string(strtoupper($_POST['setTaskCode'])) ."', description = '". mysql_escape_string(ucfirst($_POST['setTaskDesc'])) ."', xcategory = '". $_POST['taskcat'] ."', amount = '". $_POST['setTaskAmount'] ."', equipmentid = '". $_POST['setEquip'] ."', equipmentname = '". $rowequip[0] ."' WHERE id = '". $_POST['hiddensettaskid'] ."';", $connection);
			if($res == true){
				echo 1;
				forAccIntegration($_POST['setTaskCode'], $_POST['setTaskDesc'], $CurrCode['taskid'], "UPDATE");
			}
		break;

		case 'deleteSetTask':
			//INSERT DELETE LOG FIRST - JONAS - 12/7/2018
			$arrHeader = ["Task ID", "Task Description", "Task Category", "Amount", "Equipment"];
			$arrFields = ["taskid", "description", "xcategory", "amount", "equipmentname"];
			$Logs = createXinfo("DELETE", $arrHeader, $arrFields, "", "tblmaintenance_tasklist", $_POST['hiddensettaskid'], "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("deleted a maintenance task referential.", "Referential Module", $Logs, "" ,"DELETE", "");
			}
			//INSERT DELETE LOG FIRST - JONAS - 12/7/2018
			$CurrCode = mysql_fetch_array(mysql_query("SELECT taskid FROM tblmaintenance_tasklist WHERE id = '". $_POST['hiddensettaskid'] ."'", $connection));
			$res = mysql_query("DELETE FROM tblmaintenance_tasklist WHERE id = '". $_POST['hiddensettaskid'] ."';", $connection);
			if($res == true){
				echo 1;
				forAccIntegration($CurrCode['taskid'], "", "", "DELETE");
			}
		break;

		case 'showtaskcats':
			echo "<option value=''>-- Select Category --</option>";
			$res = mysql_query("SELECT category_id, category FROM tblmaintenance_category ORDER BY category ASC;", $connection);
			while($row = mysql_fetch_array($res)){
				echo "<option value='".$row[0]."'>".$row[1]."</option>";
			}
		break;

		case 'showsetEquip':
			echo "<option value=''>-- Select Equipment --</option>";
			$res = mysql_query("SELECT code, description FROM tblmaintenance_equip WHERE status = 'Operational' AND xcategory = 'Equipment';", $connection);
			while($row = mysql_fetch_array($res)){
				echo "<option value='".$row[0]."'>".$row[1]."</option>";	
			}
		break;

		case 'clickUpdateSetTask':
			$row = mysql_fetch_array(mysql_query("SELECT COUNT(xtaskid) FROM tblmaintenance_workorderlist WHERE xtaskid = '". $_POST['setTaskCode'] ."';", $connection));
			if($row[0] >= 1){
				echo 1;
			}else{
				echo 0;
			}
		break;

		case 'fncCheckisReading':
			$isReading = mysql_fetch_array(mysql_query("SELECT isReading FROM tblmaintenance_category WHERE category_id = '". $_POST['catid'] ."';", $connection));
			echo $isReading['isReading'];
		break;

		case 'AutoConsolidateTask':
			$Task = "SELECT b.category, a.taskid, a.description, a.amount, a.equipmentname FROM tblmaintenance_tasklist AS a LEFT JOIN tblmaintenance_category AS b ON a.xcategory = b.category_id WHERE a.description LIKE '%". $_POST['key'] ."%' OR b.category LIKE '%". $_POST['key'] ."%' OR a.taskid LIKE '%". $_POST['key'] ."%' OR a.amount LIKE '%". $_POST['key'] ."%' OR a.equipmentname LIKE '%". $_POST['key'] ."%' ORDER BY a.description ASC";
			$resclassification = mysql_query($Task, $connection);
			$data = "Code,Category,Description,Amount,EquipmentName\r\n";
			while($rowclassification = mysql_fetch_array($resclassification)){
				$data .= $rowclassification[1].",".$rowclassification[0].",".$rowclassification[2].",".$rowclassification[3].",".$rowclassification[4]."\r\n";
			}
			$filepath = mysql_fetch_array(mysql_query("SELECT filepath FROM tblsys_setup", $connection));
			$syspath = str_replace("\\", "/", $filepath[0]);
			if (!file_exists($syspath)){
				mkdir($syspath, 0777, true);
			}
			$file = $syspath."Maintenance_Task_".date('mdY').".csv";
			chmod($file, 0777);
			if (file_put_contents($file, $data)){
			create_logs_per_transaction('exported a referential to excel', 'Maintenance Task', '', '', 'EXPORT', '');
				echo 1;
			}else{
				echo 0;
			}
		break;
	}
?>