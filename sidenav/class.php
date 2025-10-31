<?php 
	session_start();
	include("../connect.php");
	switch ($_POST['form']) {
		case 'groupaccess':	
			$groupaccess = mysql_fetch_array(mysql_query("SELECT isadmin, groupaccess FROM tbluser WHERE userid = '". $_SESSION['MMS-UserID'] ."';", $connection));
			if($groupaccess[0] == 1 || $_SESSION['MMS-UserID'] == "GatessoftCorp" || $_SESSION['MMS-UserID'] == "Superuser"){
				echo 1;
			}else{
				$res = mysql_query("SELECT module, functionid, moduletab FROM tblref_usergroupaccess WHERE groupid = '". $groupaccess[1] ."';", $connection);
				while ($row = mysql_fetch_array($res)) {
					echo "#" . $row[0] . "|" .$row[1] . "|" . $row[2];
				}
			}
		break;

		case 'saveaddHCID':
			$sql = " INSERT INTO tblref_hardcodedid SET HC_ID = '". $_POST['id'] ."', HC_DESC = '". $_POST['description'] ."'";
			$res = mysql_query($sql, $connection);
			if($res == true){
				echo "1";
			}else{
				echo "2";
			}
		break;

		case 'HCIDList':
			$res = mysql_query(" SELECT id, HC_ID, HC_DESC FROM tblref_hardcodedid WHERE HC_ID LIKE '%". $_POST['key'] ."%' OR HC_DESC LIKE '%". $_POST['key'] ."%' LIMIT ". $_POST['HDCIDCount'] .", 10 ", $connection);
			while($row = mysql_fetch_array($res)){
				echo 	"
							<tr id=".$row[0].">
								<td>".$row[1]."</td>
								<td>".$row[2]."</td>
							</tr>
						";
			}

			$sql2 = " SELECT COUNT(*) FROM tblref_hardcodedid WHERE HC_ID LIKE '%". $_POST['key'] ."%' OR HC_DESC LIKE '%". $_POST['key'] ."%' ";
			$res2 = mysql_query($sql2, $connection);
			$row2 = mysql_fetch_array($res2);

			$refcount = explode(".", $row2[0] / 10);

			echo "|" . $refcount[0];
		break;

		case 'selectedHCID':
			$selected = mysql_fetch_array(mysql_query("SELECT HC_ID, HC_DESC FROM tblref_hardcodedid WHERE id = '". $_POST['id'] ."'", $connection));
			echo $_POST['id'] . "|" . $selected[0] . "|" . $selected[1];
		break;

		case 'updateaddHCID':
			$sql = " UPDATE tblref_hardcodedid SET HC_ID = '". $_POST['hcid'] ."', HC_DESC = '". $_POST['description'] ."' WHERE id = '". $_POST['id'] ."'";
			$res = mysql_query($sql, $connection);
			if($res == true){
				echo "1";
			}else{
				echo "2";
			}
		break;

		case 'clickdeleteHCID2':
			$res = mysql_query("DELETE FROM tblref_hardcodedid WHERE id = '". $_POST['id'] ."'", $connection);
			if($res == true){
				echo "1";
			}else{
				echo "2";
			}
		break;
	}
?>