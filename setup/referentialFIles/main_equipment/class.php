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

		case 'saveequipCat':
			//INSERT DELETE LOG FIRST - JONAS - 12/5/2018
			$arrHeader = ["Equipment Code", "Equipment Description", "Floor", "Unit", "Status"];
			$arrValue = [$_POST['equipCatCode'], $_POST['equipCatDesc'], $_POST['eqfloor'], $_POST['equnit'], $_POST['equipCatstatus']];
			$Logs = createXinfo("INSERT", $arrHeader, "", $arrValue, "", "", "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("added a new equipment referential.", "Referential Module", $Logs, "" ,"ADD", "");
			}
			//INSERT DELETE LOG FIRST - JONAS - 12/5/2018
			$rowcheck = mysql_fetch_array(mysql_query("SELECT code FROM tblmaintenance_equip WHERE code = '". $_POST['equipCatCode'] ."';", $connection));
			if($rowcheck[0] == ""){
				$rowdesc = mysql_fetch_array(mysql_query("SELECT description FROM tblmaintenance_equip WHERE description = '". $_POST['equipCatDesc'] ."' "));
				if($rowdesc[0] == ""){
					$res = mysql_query("INSERT INTO tblmaintenance_equip SET xcategory = 'Equipment', Code = '". $_POST['equipCatCode'] ."', description = '". $_POST['equipCatDesc'] ."', floor = '". $_POST['eqfloor'] ."', unit = '". $_POST['equnit'] ."', status = '". $_POST['equipCatstatus'] ."';", $connection);
					if($res == true){
						echo 1;
					}
				}else{
					echo "Equipment Description already exist.";
				}
			}else{
				echo "Equipment Code already exist.";
			}
		break;

		case 'updateequipCat':
			//INSERT UPDATE LOG FIRST - JONAS - 12/5/2018
			$arrHeader = ["Equipment Code", "Equipment Description", "Floor", "Unit", "Status"];
			$arrFields = ["code", "description", "floor", "unit", "status"];
			$arrValue = [$_POST['equipCatCode'], $_POST['equipCatDesc'], $_POST['eqfloor'], $_POST['equnit'], $_POST['equipCatstatus']];
			$Logs = createXinfo("UPDATE", $arrHeader, $arrFields, $arrValue, "tblmaintenance_equip", $_POST['hiddenideqid'], "");
			if($Logs != ""){
					$tran_logs = create_logs_per_transaction("modified an equipment referential.", "Referential Module", $Logs, "" ,"UPDATE", "");
			}
			//INSERT UPDATE LOG FIRST - JONAS - 12/5/2018
			$CurrCode = mysql_fetch_array(mysql_query("SELECT code, description, floor, unit, status FROM tblmaintenance_equip WHERE id = '". $_POST['hiddenideqid'] ."';", $connection));
			$res = mysql_query("UPDATE tblmaintenance_equip SET description = '". $_POST['equipCatDesc'] ."', floor = '". $_POST['eqfloor'] ."', unit = '". $_POST['equnit'] ."', status = '". $_POST['equipCatstatus'] ."', code = '". $_POST['equipCatCode'] ."' WHERE id = '". $_POST['hiddenideqid'] ."';", $connection);
			if($res == true){
				echo 1;
			}
		break;

		case 'showmainequip':
			$res = mysql_query("SELECT a.code, a.description, a.floor, b.mallname, a.status FROM tblmaintenance_equip AS a LEFT JOIN tblref_mall AS b ON a.unit = b.mallid WHERE (a.description LIKE '%". $_POST['key'] ."%' OR a.code LIKE '%". $_POST['key'] ."%' OR a.floor LIKE '%". $_POST['key'] ."%' OR b.mallname LIKE '%". $_POST['key'] ."%' OR a.status LIKE '%". $_POST['key'] ."%') AND a.xcategory = 'Equipment' ORDER BY a.description ASC LIMIT ". $_POST['countEquipment'] .", 10;", $connection);
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
			$row2 = mysql_fetch_array(mysql_query("SELECT COUNT(a.id) FROM tblmaintenance_equip AS a LEFT JOIN tblref_mall AS b ON a.unit = b.mallid WHERE (a.description LIKE '%". $_POST['key'] ."%' OR a.code LIKE '%". $_POST['key'] ."%' OR a.floor LIKE '%". $_POST['key'] ."%' OR b.mallname LIKE '%". $_POST['key'] ."%' OR a.status LIKE '%". $_POST['key'] ."%') AND a.xcategory = 'Equipment';", $connection));
			$refcount = explode(".", $row2[0] / 10);
			echo "|" . $refcount[0];
		break;

		case 'selectedequipCat':
			$row = mysql_fetch_array(mysql_query("SELECT code, description, floor, unit, status, id FROM tblmaintenance_equip WHERE Code = '". $_POST['id'] ."';", $connection));
			echo $row[0] . "|" . $row[1] . "|" . $row[2] . "|" . $row[3] . "|" . $row[4] . "|" . $row[5];
		break;

		case 'clickDeleteequipCat':
			//INSERT DELETE LOG FIRST - JONAS - 12/5/2018
			$arrHeader = ["Equipment Code", "Equipment Description", "Floor", "Unit", "Status"];
			$arrFields = ["code", "description", "floor", "unit", "status"];
			$Logs = createXinfo("DELETE", $arrHeader, $arrFields, "", "tblmaintenance_equip", $_POST['hiddenideqid'], "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("deleted an equipment referential.", "Referential Module", $Logs, "" ,"DELETE", "");
			}
			//INSERT DELETE LOG FIRST - JONAS - 12/5/2018
			$res = mysql_query("DELETE FROM tblmaintenance_equip WHERE id = '". $_POST['hiddenideqid'] ."';", $connection);
			if($res == true){
				echo 1;
				$Logs .= "Equipment Code : ". $CurrCode['code'] . "|";
				$Logs .= "Equipment Description : ". $CurrCode['description'] . "|";
				$Logs .= "Floor : ". $CurrCode['floor'] . "|";
				$Logs .= "Unit : ". $CurrCode['unit'] . "|";
				$Logs .= "Status : ". $CurrCode['status'] . "|";
				if($Logs != ""){
					$tran_logs = create_logs_per_transaction("deleted an equipment referential.", "Referential Module", $Logs, "" ,"DELETE", "");
				}
			}
		break;

		case 'clickUpdateequipCat':
			$row = mysql_fetch_array(mysql_query("SELECT COUNT(equipmentid) FROM tblmaintenance_tasklist WHERE equipmentid = '". $_POST['equipCatCode'] ."';", $connection));
			if($row[0] >= 1){
				echo 1;
			}else{
				echo 0;
			}
		break;
	}
 ?>