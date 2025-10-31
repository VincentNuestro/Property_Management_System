<?php 
	session_start();
	include "../../../connect.php";
	switch ($_POST['form']) {
		case 'showfloor':
			echo "<option value=''>-- Select Floor --</option>";
			$res = mysql_query("SELECT floor FROM tblref_flr;", $connection);
			while($row = mysql_fetch_array($res)){
				echo "<option value='".$row[0]."'>".$row[0]."</option>";
			}
		break;

		case 'savefacilitiesCat':
			//INSERT LOG FIRST - JONAS - 12/5/2018
			$arrHeader = ["Code", "Description", "Floor", "Unit", "Status"];
			$arrValue = [$_POST['facilitiesCatCode'], $_POST['facilitiesCatDesc'], $_POST['facilitiesfloor'], $_POST['facilitiesunit'], $_POST['facilitiesCatstatus']];
			$Logs = createXinfo("INSERT", $arrHeader, "", $arrValue, "", "", "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("added a new facility referential.", "Referential Module", $Logs, "" ,"ADD", "");
			}
			//INSERT LOG FIRST - JONAS - 12/5/2018
			$rowcheck = mysql_fetch_array(mysql_query("SELECT code FROM tblmaintenance_equip WHERE code = '". $_POST['facilitiesCatCode'] ."';", $connection));
			if($rowcheck[0] == ""){
				$rowdesc = mysql_fetch_array(mysql_query("SELECT description FROM tblmaintenance_equip WHERE description = '". $_POST['facilitiesCatDesc'] ."';", $connection));
				if($rowdesc[0] == ""){
					$res = mysql_query("INSERT INTO tblmaintenance_equip SET xcategory = 'Facilities', Code = '". $_POST['facilitiesCatCode'] ."', description = '". $_POST['facilitiesCatDesc'] ."', floor = '". $_POST['facilitiesfloor'] ."', unit = '". $_POST['facilitiesunit'] ."', status = '". $_POST['facilitiesCatstatus'] ."';", $connection);
					if($res == true){
						echo 1;
					}
				}else{
					echo "Description already exist.";
				}
			}else{
				echo "Code already exist.";
			}
		break;

		case 'updatefacilitiesCat':
			//INSERT UPDATE LOG FIRST - JONAS - 12/5/2018
			$arrHeader = ["Code", "Description", "Floor", "Unit", "Status"];
			$arrFields = ["Code", "description", "floor", "unit", "status"];
			$arrValue = [$_POST['facilitiesCatCode'], $_POST['facilitiesCatDesc'], $_POST['facilitiesfloor'], $_POST['facilitiesunit'], $_POST['facilitiesCatstatus']];
			$Logs = createXinfo("UPDATE", $arrHeader, $arrFields, $arrValue, "tblmaintenance_equip", $_POST['hiddenfacilitiescatid'], "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("modified a facility referential.", "Referential Module", $Logs, "" ,"UPDATE", "");
			}
			//INSERT UPDATE LOG FIRST - JONAS - 12/5/2018
			$CurrCode = mysql_fetch_array(mysql_query("SELECT Code, description, floor, unit, status FROM tblmaintenance_equip WHERE id = '". $_POST['hiddenfacilitiescatid'] ."';", $connection));
			$res = mysql_query("UPDATE tblmaintenance_equip SET Code = '". $_POST['facilitiesCatCode'] ."', description = '". $_POST['facilitiesCatDesc'] ."', floor = '". $_POST['facilitiesfloor'] ."', unit = '". $_POST['facilitiesunit'] ."', status = '". $_POST['facilitiesCatstatus'] ."' WHERE id = '". $_POST['hiddenfacilitiescatid'] ."';", $connection);
			if($res == true){
				echo 1;
			}
		break;

		case 'showmainfacilities':
			$res = mysql_query("SELECT a.code, a.description, a.floor, b.mallname, a.status FROM tblmaintenance_equip AS a LEFT JOIN tblref_mall AS b ON a.unit = b.mallid WHERE (a.description LIKE '%". $_POST['key'] ."%' OR a.code LIKE '%". $_POST['key'] ."%' OR a.floor LIKE '%". $_POST['key'] ."%' OR b.mallname LIKE '%". $_POST['key'] ."%' OR a.status LIKE '%". $_POST['key'] ."%') AND a.xcategory = 'Facilities' ORDER BY a.description ASC LIMIT ". $_POST['countmFacilities'] .", 10;", $connection);
			while($row = mysql_fetch_array($res)){
				?>
					<tr id="<?php echo $row[0]; ?>">
						<td><?php echo $row[0]; ?></td>
						<td><?php echo $row[1]; ?></td>
						<td><?php echo $row[2]; ?></td>
						<td><?php echo $row[3]; ?></td>
						<td><?php echo $row[4]; ?></td>
					</tr>
				<?php
			}
			$row2 = mysql_fetch_array(mysql_query("SELECT COUNT(a.id) FROM tblmaintenance_equip AS a LEFT JOIN tblref_mall AS b ON a.unit = b.mallid WHERE (a.description LIKE '%". $_POST['key'] ."%' OR a.code LIKE '%". $_POST['key'] ."%' OR a.floor LIKE '%". $_POST['key'] ."%' OR b.mallname LIKE '%". $_POST['key'] ."%' OR a.status LIKE '%". $_POST['key'] ."%') AND xcategory = 'Facilities';", $connection));
			$refcount = explode(".", $row2[0] / 10);
			echo "|" . $refcount[0];
		break;

		case 'selectedfacilitiesCat':
			$row = mysql_fetch_array(mysql_query("SELECT code, description, floor, unit, status, id FROM tblmaintenance_equip WHERE Code = '". $_POST['id'] ."';", $connection));
			echo $row[0] . "|" . $row[1] . "|" . $row[2] . "|" . $row[3] . "|" . $row[4] . "|" . $row[5];
		break;

		case 'clickDeletefacilitiesCat':
			//INSERT DELETE LOG FIRST - JONAS - 12/5/2018
			$arrHeader = ["Code", "Description", "Floor", "Unit", "Status"];
			$arrFields = ["Code", "description", "floor", "unit", "status"];
			$Logs = createXinfo("DELETE", $arrHeader, $arrFields, "", "tblmaintenance_equip", $_POST['hiddenfacilitiescatid'], "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("deleted a facility referential.", "Referential Module", $Logs, "" ,"DELETE", "");
			}
			//INSERT DELETE LOG FIRST - JONAS - 12/5/2018
			$res = mysql_query("DELETE FROM tblmaintenance_equip WHERE id = '". $_POST['hiddenfacilitiescatid'] ."';", $connection);
			if($res == true){
				echo 1;
			}
		break;

		case 'clickUpdatefacilitiesCat':
			$row = mysql_fetch_array(mysql_query("SELECT COUNT(joformanagement) FROM tblmaintenance_workorder WHERE joformanagement = '". $_POST['facilitiesCatCode'] ."';", $connection));
			if($row[0] >= 1){
				echo 1;
			}else{
				echo 0;
			}
		break;
	}
 ?>