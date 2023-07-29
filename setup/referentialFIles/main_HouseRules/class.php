<?php 
	session_start();
	include "../../../connect.php";
	switch ($_POST['form']) {
		case 'showmainHouseRules':
			$page = $_POST['page'];
			$limit = ($page-1) * 20;
			$res = mysql_query("SELECT id, code, violation, 1st_offense, 1stFine, 1stwithVat, 1stVat, 2nd_offense, 2ndFine, 2ndwithVat, 2ndVat, 3rd_offense, 3rdFine, 3rdwithVat, 3rdVat, xsucceeding, sucFine, sucwithVat, sucVat FROM tblmaintenance_houserules WHERE violation LIKE '%". $_POST['key'] ."%' OR code LIKE '%". $_POST['key'] ."%' OR 1st_offense LIKE '%". $_POST['key'] ."%' OR 2nd_offense LIKE '%". $_POST['key'] ."%' OR 3rd_offense LIKE '%". $_POST['key'] ."%' OR xsucceeding LIKE '%". $_POST['key'] ."%' GROUP BY violation ORDER BY ". $_POST['HouseruleSortBy'] ." ". $_POST['HouseruleSortType'] ." LIMIT ".$limit.",20;", $connection);
			while($row = mysql_fetch_array($res)){
				?>
					<tr id="<?php echo $row[0]; ?>">
						<td><?php echo $row[1]; ?></td>
						<td><?php echo $row[2]; ?></td>
						<!-- 1st -->
						<td><?php echo $row[3]; ?></td>
						<td align="right"><?php echo number_format($row[4], 2); ?></td>
						<!-- <td><?php echo $row[5]; ?></td>
						<td align="right"><?php echo number_format($row[6], 2); ?></td> -->

						<!-- 2nd -->
						<td><?php echo $row[7]; ?></td>
						<td align="right"><?php echo number_format($row[8], 2); ?></td>
						<!-- <td><?php echo $row[9]; ?></td>
						<td align="right"><?php echo number_format($row[10], 2); ?></td> -->

						<!-- 3rd -->
						<td><?php echo $row[11]; ?></td>
						<td align="right"><?php echo number_format($row[12], 2); ?></td>
						<!-- <td><?php echo $row[13]; ?></td>
						<td align="right"><?php echo number_format($row[14], 2); ?></td> -->

						<!-- succeeding -->
						<td><?php echo $row[15]; ?></td>
						<td align="right"><?php echo number_format($row[16], 2); ?></td>
						<!-- <td><?php echo $row[17]; ?></td>
						<td align="right"><?php echo number_format($row[18], 2); ?></td> -->
					</tr>
				<?php
			}
		break;

		case 'loadEntriesHouseRules':
			if($_POST["page"] == ""){
				$page = 1;
			}else{
				$page = $_POST["page"];
			}
			$limit = ($page-1) * 20;
			$rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM tblmaintenance_houserules WHERE violation LIKE '%". $_POST['key'] ."%' OR code LIKE '%". $_POST['key'] ."%' OR 1st_offense LIKE '%". $_POST['key'] ."%' OR 2nd_offense LIKE '%". $_POST['key'] ."%' OR 3rd_offense LIKE '%". $_POST['key'] ."%' OR xsucceeding LIKE '%". $_POST['key'] ."%';", $connection));
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

		case "loadPageHouseRules":
			$page = $_POST["page"];
			$rowCount = mysql_fetch_row(mysql_query("SELECT COUNT(id) FROM tblmaintenance_houserules WHERE violation LIKE '%". $_POST['key'] ."%' OR code LIKE '%". $_POST['key'] ."%' OR 1st_offense LIKE '%". $_POST['key'] ."%' OR 2nd_offense LIKE '%". $_POST['key'] ."%' OR 3rd_offense LIKE '%". $_POST['key'] ."%' OR xsucceeding LIKE '%". $_POST['key'] ."%';", $connection));
			$rowsperpage = 20;
			$range = 1;
			$totalpages = ceil($rowCount[0] / $rowsperpage);
			$prevpage;
			$nextpage;
			// if not on page 1, don't show back links
			if($page > 1 ){
				echo "<li style='width:50px !important;' onclick='fncPageHouseRules(1)'><< First</li>";
				$prevpage = $page - 1;
				echo "<li style='width:70px !important;' onclick='fncPageHouseRules(". $prevpage .")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if(($x > 0) && ($x <= $totalpages)){
					if($x == $page){
						echo "<li id='pgHouseRules" . $x . "' class='pgnumHouseRules active' onclick='fncPageHouseRules(" . $x . ",". $x .")'>" . $x . "</li>";
					}else{
						echo "<li id='pgHouseRules" . $x . "' class='pgnumHouseRules' onclick='fncPageHouseRules(" . $x . ",". $x .")'>" . $x . "</li>";
					}
				}
			}
			if($page < ($totalpages - $range)){
				echo "<li>...</li>";
			}
			if($page != $totalpages && $rowCount[0] != 0){
				$nextpage = $page + 1;
				echo "<li style='width:50px !important;' onclick='fncPageHouseRules(". $nextpage .", ". $nextpage .")'>Next ></li>";
				echo "<li style='width:50px !important;' onclick='fncPageHouseRules(". $totalpages .", ". $totalpages .")'>Last >></li>";
			}
		break;

		case 'saveHouseRules':
			//INSERT LOG FIRST - JONAS - 12/5/2018
			$arrHeader = ["Code", "Violation", "First Offense", "Second Offense", "Third Offense", "Succeeding"];
			$arrValue = [$_POST['Code'], $_POST['Violation'], $_POST['offense1'], $_POST['offense2'], $_POST['offense3'], $_POST['Succeeding']];
			$Logs = createXinfo("INSERT", $arrHeader, "", $arrValue, "", "", "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("added a new house rule referential.", "Referential Module", $Logs, "" ,"ADD", "");
			}
			//INSERT LOG FIRST - JONAS - 12/5/2018
			$rowcheck = mysql_fetch_array(mysql_query("SELECT code FROM tblmaintenance_houserules WHERE code = '". $_POST['Code'] ."';", $connection));
			if($rowcheck[0] == ""){
				$rowdesc = mysql_fetch_array(mysql_query("SELECT Violation FROM tblmaintenance_houserules WHERE Violation = '". $_POST['Violation'] ."';", $connection));
				if($rowdesc[0] == ""){
					// $res = mysql_query("INSERT INTO tblmaintenance_houserules SET Code = '". $_POST['Code'] ."', Violation = '". $_POST['Violation'] ."', 1st_offense = '". $_POST['offense1'] ."', 2nd_offense = '". $_POST['offense2'] ."', 3rd_offense = '". $_POST['offense3'] ."', xsucceeding = '". $_POST['Succeeding'] ."';", $connection);
					//<!-- MODIFIED BY PETER - 2019-10-29 -->
					//<!-- ADDED FIELDS FOR FINE FOR OFFENSE REQUESTED BY SIR JOHNNY -->

					$sql = " INSERT INTO
							tblmaintenance_houserules
						SET
							Code = '". $_POST['Code'] ."', Violation = '". mysql_real_escape_string($_POST['Violation']) ."', 1st_offense = '". mysql_real_escape_string($_POST['offense1']) ."', 1stFine = '". str_replace(",", "", $_POST['Fine1']) ."', 2nd_offense = '". mysql_real_escape_string($_POST['offense2']) ."', 2ndFine = '". str_replace(",", "", $_POST['Fine2']) ."', 3rd_offense = '". mysql_real_escape_string($_POST['offense3']) ."', 3rdFine = '". str_replace(",", "", $_POST['Fine3']) ."', xsucceeding = '". mysql_real_escape_string($_POST['Succeeding']) ."', sucFine = '". str_replace(",", "", $_POST['Fine4']) ."',
							1stwithVat = '". $_POST['vatopt1'] ."', 1stVat = '". str_replace(",", "", $_POST['vatamt1']) ."', 2ndwithVat = '". $_POST['vatopt2'] ."', 2ndVat = '". str_replace(",", "", $_POST['vatamt2']) ."', 3rdwithVat = '". $_POST['vatopt3'] ."', 3rdVat = '". str_replace(",", "", $_POST['vatamt3']) ."', sucwithVat = '". $_POST['vatopt4'] ."', sucVat = '". str_replace(",", "", $_POST['vatamt4']) ."'; ";
					$res = mysql_query($sql, $connection);
					if($res == true){
						echo 1;
						forAccIntegration($_POST['Code'], $_POST['Violation'], "", "INSERT");
					}					
				}else{
					echo "Violation already exist.";
				}
			}else{
				echo "Code already exist.";
			}
		break;

		case 'selectedHouseRules':
			// $HouseRules = mysql_fetch_array(mysql_query("SELECT code, violation, 1st_offense, 2nd_offense, 3rd_offense, xsucceeding, id FROM tblmaintenance_houserules WHERE id = '". $_POST['id'] ."';", $connection));
			$sql = " SELECT
						Code,
						Violation,
						1st_offense,
						1stFine,
						1stwithVat,
						1stVat,
						2nd_offense,
						2ndFine,
						2ndwithVat,
						2ndVat,
						3rd_offense,
						3rdFine,
						3rdwithVat,
						3rdVat,
						xsucceeding,
						sucFine,
						sucwithVat,
						sucVat,
						id
					FROM
						tblmaintenance_houserules
					WHERE id = '". $_POST['id'] ."'; ";
			$res = mysql_query($sql, $connection);
			$HouseRules = mysql_fetch_array($res);

			echo $HouseRules[0] . "|" . $HouseRules[1] . "|" . $HouseRules[2] . "|" . number_format($HouseRules[3], 2) . "|" . $HouseRules[4] . "|" . number_format($HouseRules[5], 2) . "|" . $HouseRules[6] . "|" . number_format($HouseRules[7],2) . "|" . $HouseRules[8] . "|" . number_format($HouseRules[9], 2) . "|" . $HouseRules[10] . "|" . number_format($HouseRules[11],2) . "|" . $HouseRules[12] . "|" . number_format($HouseRules[13],2) . "|" . $HouseRules[14] . "|" . number_format($HouseRules[15], 2) . "|" . $HouseRules[16] . "|" . number_format($HouseRules[17], 2) . "|" . $HouseRules[18];
		break;

		case 'clickDeleteHouseRulesCat':
			//INSERT DELETE LOG FIRST - JONAS - 12/5/2018
			$arrHeader = ["Code", "Violation", "First Offense", "Second Offense", "Third Offense", "Succeeding"];
			$arrFields = ["Code", "Violation", "1st_offense", "2nd_offense", "3rd_offense", "xsucceeding"];
			$Logs = createXinfo("DELETE", $arrHeader, $arrFields, "", "tblmaintenance_houserules", $_POST['id'], "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("deleted a house rule referential.", "Referential Module", $Logs, "", "DELETE", "");
			}
			//INSERT DELETE LOG FIRST - JONAS - 12/5/2018
			$res = mysql_query("DELETE FROM tblmaintenance_houserules WHERE id = '". $_POST['id'] ."';", $connection);
			if($res == true){
				forAccIntegration($_POST['Code'], "", "", "DELETE");
				echo 1;
			}
		break;

		case 'updateHouseRulesCat':
			//INSERT UPDATE LOG FIRST - JONAS - 12/5/2018
			$arrHeader = ["Code", "Violation", "First Offense", "Second Offense", "Third Offense", "Succeeding"];
			$arrFields = ["Code", "Violation", "1st_offense", "2nd_offense", "3rd_offense", "xsucceeding"];
			$arrValue = [$_POST['Code'], $_POST['Violation'], $_POST['offense1'], $_POST['offense2'], $_POST['offense3'], $_POST['Succeeding']];
			$Logs = createXinfo("UPDATE", $arrHeader, $arrFields, $arrValue, "tblmaintenance_houserules", $_POST['id'], "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("modified a house rule referential.", "Referential Module", $Logs, "" ,"UPDATE", "");
			}
			//INSERT UPDATE LOG FIRST - JONAS - 12/5/2018
			$CurrCode = mysql_fetch_array(mysql_query("SELECT Code, Violation, 1st_offense, 2nd_offense, 3rd_offense, xsucceeding FROM tblmaintenance_houserules WHERE id = '". $_POST['id'] ."';", $connection));
			// $res = mysql_query(" UPDATE tblmaintenance_houserules SET Code = '". $_POST['Code'] ."', Violation = '". $_POST['Violation'] ."', 1st_offense = '". $_POST['offense1'] ."', 2nd_offense = '". $_POST['offense2'] ."', 3rd_offense = '". $_POST['offense3'] ."', xsucceeding = '". $_POST['Succeeding'] ."' WHERE id = '". $_POST['id'] ."';", $connection);
			$sql = " UPDATE tblmaintenance_houserules SET Code = '". $_POST['Code'] ."', Violation = '". mysql_real_escape_string($_POST['Violation']) ."', 1st_offense = '". mysql_real_escape_string($_POST['offense1']) ."', 1stFine = '". str_replace(",", "", $_POST['Fine1']) ."', 2nd_offense = '". mysql_real_escape_string($_POST['offense2']) ."', 2ndFine = '". str_replace(",", "", $_POST['Fine2']) ."', 3rd_offense = '". mysql_real_escape_string($_POST['offense3']) ."', 3rdFine = '". str_replace(",", "", $_POST['Fine3']) ."', xsucceeding = '". mysql_real_escape_string($_POST['Succeeding']) ."', sucFine = '". str_replace(",", "", $_POST['Fine4']) ."',
					1stwithVat = '". $_POST['vatopt1'] ."', 1stVat = '". str_replace(",", "", $_POST['vatamt1']) ."', 2ndwithVat = '". $_POST['vatopt2'] ."', 2ndVat = '". str_replace(",", "", $_POST['vatamt2']) ."', 3rdwithVat = '". $_POST['vatopt3'] ."', 3rdVat = '". str_replace(",", "", $_POST['vatamt3']) ."', sucwithVat = '". $_POST['vatopt4'] ."', sucVat = '". str_replace(",", "", $_POST['vatamt4']) ."' WHERE id = '". $_POST['id'] ."'; ";
			$res = mysql_query($sql, $connection);
			if ($res == true) {
				echo 1;
				forAccIntegration($_POST['Code'], $_POST['Violation'], $CurrCode[0], "UPDATE");
			}
		break;

		case 'clickUpdateHouseRulesCat':
			$row = mysql_fetch_array(mysql_query("SELECT COUNT(Code) FROM tblmaintenance_hrviolators WHERE Code = '". $_POST['Code'] ."';", $connection));
			if($row[0] >= 1){
				echo 1;
			}else{
				echo 0;
			}
		break;

		case 'AutoConsolidateHouseRules':
			$HouseRules = "SELECT id, code, violation, 1st_offense, 2nd_offense, 3rd_offense, xsucceeding FROM tblmaintenance_houserules WHERE violation LIKE '%". $_POST['key'] ."%' OR code LIKE '%". $_POST['key'] ."%' OR 1st_offense LIKE '%". $_POST['key'] ."%' OR 2nd_offense LIKE '%". $_POST['key'] ."%' OR 3rd_offense LIKE '%". $_POST['key'] ."%' OR xsucceeding LIKE '%". $_POST['key'] ."%'";
			$resclassification = mysql_query($HouseRules, $connection);
			$data = "Id,code,vi'olation,1st_offense,2nd_offense,3rd_offense,xsucceeding\r\n";
			while($rowclassification = mysql_fetch_array($resclassification)){
				$data .= $rowclassification[0].",".$rowclassification[1].",".$rowclassification[2].",".$rowclassification[3].",".$rowclassification[4].",".$rowclassification[5].",".$rowclassification[6]."\r\n";
			}
			$filepath = mysql_fetch_array(mysql_query("SELECT filepath FROM tblsys_setup", $connection));
			$syspath = str_replace("\\", "/", $filepath[0]);
			if (!file_exists($syspath)){
				mkdir($syspath, 0777, true);
			}
			$file = $syspath."House_Rules_".date('mdY').".csv";
			chmod($file, 0777);
			if (file_put_contents($file, $data)){
			create_logs_per_transaction('exported a referential to excel', 'House Rules', '', '', 'EXPORT', '');
				echo 1;
			}else{
				echo 0;
			}
		break;

		case 'maglagayngComa':
			$num = number_format($_POST['num'], 2);

			echo $num;
		break;
	}
?>