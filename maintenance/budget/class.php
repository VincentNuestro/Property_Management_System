<?php
session_start();
	include("../../connect.php");
	switch ( $_POST['form'] ) {
		case 'showtypeofbudget':
			echo "<option value=''>-- Select Utilities --</option>";
			$res = mysql_query("SELECT category_id, category FROM tblmaintenance_category", $connection);
			while($row = mysql_fetch_array($res)){
				echo "<option value='".$row[0]."'>".$row[1]."</option>";
			}
		break;

		case 'savebudgetperyear':
			$action = "";
			$checkyear = mysql_fetch_array(mysql_query("SELECT xyear FROM tblref_budget WHERE xyear = '". $_POST['year'] ."' AND category_id = '". $_POST['utility'] ."' AND mallid = '". $_POST['mall'] ."' ", $connection));
			$catname = mysql_fetch_array(mysql_query("SELECT category FROM tblmaintenance_category WHERE category_id = '". $_POST['utility'] ."' ", $connection));
			if($checkyear[0] == ""){
				$sql = "INSERT INTO tblref_budget SET xyear = '". $_POST['year'] ."', xjan = '". $_POST['xjan'] ."', xfeb = '". $_POST['xfeb'] ."', xmar = '". $_POST['xmar'] ."', xapr = '". $_POST['xapr'] ."', xmay = '". $_POST['xmay'] ."', xjun = '". $_POST['xjun'] ."', xjul = '". $_POST['xjul'] ."', xaug = '". $_POST['xaug'] ."', xsep = '". $_POST['xsep'] ."', xoct = '". $_POST['xoct'] ."', xnov = '". $_POST['xnov'] ."', xdec = '". $_POST['xdec'] ."', category_id = '". $_POST['utility'] ."', category = '". $catname[0] ."', mallid = '". $_POST['mall']."' ";
				$action = "created";
			}else{
				$sql = "UPDATE tblref_budget SET xjan = '". $_POST['xjan'] ."', xfeb = '". $_POST['xfeb'] ."', xmar = '". $_POST['xmar'] ."', xapr = '". $_POST['xapr'] ."', xmay = '". $_POST['xmay'] ."', xjun = '". $_POST['xjun'] ."', xjul = '". $_POST['xjul'] ."', xaug = '". $_POST['xaug'] ."', xsep = '". $_POST['xsep'] ."', xoct = '". $_POST['xoct'] ."', xnov = '". $_POST['xnov'] ."', xdec = '". $_POST['xdec'] ."', category = '". $catname[0] ."', xdateupdate = '". date('Y-m-d H:i:s') ."', mallid = '". $_POST['mall']."' WHERE xyear = '". $_POST['year'] ."' AND category_id = '". $_POST['utility'] ."' ";
				$action = "updated";
			}
			$res = mysql_query($sql, $connection);
			if($res == true){
				echo $catname[0]."|".$_POST['year']."|".$action;
			}
		break;

		case 'addbudgetperyear':
			$catname = mysql_fetch_array(mysql_query("SELECT category FROM tblmaintenance_category WHERE category_id = '". $_POST['utility'] ."' ", $connection));
			$budget = mysql_fetch_array(mysql_query("SELECT category, xjan, xfeb, xmar, xapr, xmay, xjun, xjul, xaug, xsep, xoct, xnov, xdec FROM tblref_budget WHERE category_id = '". $_POST['utility'] ."' AND xyear = '".  $_POST['year'] ."' ", $connection));
			echo $catname[0] . "|" . $budget[1] . "|" . $budget[2] . "|" . $budget[3] . "|" . $budget[4] . "|" . $budget[5] . "|" . $budget[6] . "|" . $budget[7] . "|" . $budget[8] . "|" . $budget[9] . "|" . $budget[10] . "|" . $budget[11] . "|" . $budget[12];
		break;

		case 'tblbudget':
			// if($_POST['mall'] != '' && ($_POST['type'] == '' || $_POST['type'] == 'null') && $_POST['year'] == ''){

			// 	$ext = " WHERE mallid = '". $_POST['mall'] ."'";

			// }else if($_POST['mall'] == '' && ($_POST['type'] != '' || $_POST['type'] != 'null') && $_POST['year'] == ''){

			// 	$ext = " WHERE category_id = '". $_POST['type'] ."'";

			// }else if($_POST['mall'] == '' && ($_POST['type'] == '' || $_POST['type'] == 'null') && $_POST['year'] != ''){

			// 	$ext = " WHERE xyear = '". $_POST['year'] ."'";

			// }else if($_POST['mall'] != '' && ($_POST['type'] != '' || $_POST['type'] != 'null')){

			// 	$ext = " WHERE category_id = '". $_POST['type'] ."' AND mallid = '". $_POST['mall'] ."'";

			// }else{

			// 	$ext = "";

			// }
			if($_POST['mall'] != ''){
				$ext = " WHERE mallid = '". $_POST['mall'] ."'";
			}else{
				$ext = "";
			}
			$res = mysql_query("SELECT category, xyear, xjan, xfeb, xmar, xapr, xmay, xjun, xjul, xaug, xsep, xoct, xnov, xdec FROM tblref_budget ". $ext ." ". getMallAccess("mallid", "AND") .";", $connection);
			while($row = mysql_fetch_array($res)){
				?>
					<tr>
						<td><?php echo $row[0]; ?></td>
						<td><?php echo $row[1]; ?></td>
						<td><?php echo number_format($row[2], 2, '.', ','); ?></td>
						<td><?php echo number_format($row[3], 2, '.', ','); ?></td>
						<td><?php echo number_format($row[4], 2, '.', ','); ?></td>
						<td><?php echo number_format($row[5], 2, '.', ','); ?></td>
						<td><?php echo number_format($row[6], 2, '.', ','); ?></td>
						<td><?php echo number_format($row[7], 2, '.', ','); ?></td>
						<td><?php echo number_format($row[8], 2, '.', ','); ?></td>
						<td><?php echo number_format($row[9], 2, '.', ','); ?></td>
						<td><?php echo number_format($row[10], 2, '.', ','); ?></td>
						<td><?php echo number_format($row[11], 2, '.', ','); ?></td>
						<td><?php echo number_format($row[12], 2, '.', ','); ?></td>
						<td><?php echo number_format($row[13], 2, '.', ','); ?></td>
					</tr>
				<?php
			}
		break;
	}
?>