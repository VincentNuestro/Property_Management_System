<?php
	session_start();
	include "../../../connect.php";
	switch ($_POST['form']) {
		case 'displayFloor':
			$res = mysql_query("SELECT floor FROM tblref_flr WHERE floor LIKE '%". $_POST['key'] ."%' ORDER BY floor ASC LIMIT ". $_POST['countfloorplan'] .", 10;", $connection);
			while($row = mysql_fetch_array($res)){
				?>
					<tr id="<?php echo $row[0]; ?>">
						<td><?php echo $row[0]; ?></td>
					</tr>
				<?php
			}
			$row2 = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM tblref_flr WHERE floor LIKE '%". $_POST['key'] ."%';", $connection));
			$refcount = explode(".", $row2[0] / 10);
			echo "|" . $refcount[0];
		break;

		case 'selectedFloor':
			$row = mysql_fetch_array(mysql_query("SELECT id, floor FROM tblref_flr WHERE floor = '". $_POST['id'] ."';", $connection));
			echo $row[0] . "|" . utf8_encode($row[1]);
		break;

		case 'saveFloor':
			//INSERT LOG FIRST - JONAS - 12/7/2018
			$arrHeader = ["Floor"];
			$arrValue = [$_POST['FloorDesc']];
			$Logs = createXinfo("INSERT", $arrHeader, "", $arrValue, "", "", "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("added a new floor plan referential.", "Referential Module", $Logs, "" ,"ADD", "");
			}
			//INSERT LOG FIRST - JONAS - 12/7/2018
			$rescheck = mysql_query("SELECT floor FROM tblref_flr WHERE floor = '". $_POST['FloorDesc'] ."';", $connection);
			$rowcheck = mysql_fetch_array($rescheck);
			if($rowcheck[0] == ""){
				$sql = "INSERT INTO tblref_flr SET floor = '". utf8_encode($_POST['FloorDesc']) ."';";
				$res = mysql_query($sql, $connection);
				if($res == true){
					echo 1;
				}
			}else{
				echo "Description already exist.";
			}
		break;

		case 'updateFloor':
			//INSERT UPDATE LOG FIRST - JONAS - 12/7/2018
			$arrHeader = ["Floor"];
			$arrFields = ["floor"];
			$arrValue = [$_POST['FloorDesc']];
			$Logs = createXinfo("UPDATE", $arrHeader, $arrFields, $arrValue, "tblref_flr", $_POST['hiddenfloorid'], "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("modified a floor plan referential.", "Referential Module", $Logs, "" ,"UPDATE", "");
			}
			//INSERT UPDATE LOG FIRST - JONAS - 12/7/2018
			$CurrentRef = mysql_fetch_array(mysql_query("SELECT floor FROM tblref_flr WHERE id = '". $_POST['hiddenfloorid'] ."';", $connection));
			$res = mysql_query("UPDATE tblref_flr SET floor = '". utf8_encode($_POST['FloorDesc']) ."' WHERE id = '". $_POST['hiddenfloorid'] ."';", $connection);
			if($res == true){
				echo 1;
			}
		break;

		case 'deleteFloor':
			//INSERT DELETE LOG FIRST - JONAS - 12/7/2018
			$arrHeader = ["Floor"];
			$arrFields = ["floor"];
			$Logs = createXinfo("DELETE", $arrHeader, $arrFields, "", "tblref_flr", $_POST['hiddenfloorid'], "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("deleted a floor plan referential.", "Referential Module", $Logs, "" ,"DELETE", "");
			}
			//INSERT DELETE LOG FIRST - JONAS - 12/7/2018
			$CurrentRef = mysql_fetch_array(mysql_query("SELECT floor FROM tblref_flr WHERE id = '". $_POST['hiddenfloorid'] ."';", $connection));
			$res = mysql_query("DELETE FROM tblref_flr WHERE id = '". $_POST['hiddenfloorid'] ."';", $connection);
			if($res == true){
				echo 1;
			}
		break;
	}
?>