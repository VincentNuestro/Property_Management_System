<?php
	session_start();
	include("../../connect.php");
	switch($_POST["form"]){
		case "saveaddhiecode":
			$checkexisting = mysql_fetch_array(mysql_query("SELECT COUNT(reqdesc) FROM tbltrans_hierarchy_reqgroup WHERE reqdesc = '". $_POST['txthiecodeadd'] ."';", $connection));
			if($checkexisting[0] == "0"){
				$hieID = createidno("HIE", "tbltrans_hierarchy_reqgroup", "reqid");
				$result = mysql_query("INSERT INTO tbltrans_hierarchy_reqgroup(reqid, reqdesc,xaddedby, xadddt) VALUES('" . $hieID . "', '" .mysql_real_escape_string($_POST['txthiecodeadd']) . "', '".$_SESSION['MMS-UserID']."', now() );", $connection);
				if($result == true){ 
					echo "1|Hierarchy Code successfully added."; 

					//INSERT LOG - JONAS - 2/14/2019
					$arrHeader = ["ID", "Hierarchy Code"];
					$arrValue = [$groupid, $_POST['txthiecodeadd']];
					$Logs = CreateLogsArray("INSERT", $arrHeader, "", $arrValue, "", "", "", "");
					if($Logs != ""){
						$tran_logs = create_logs_per_transaction("created a new hierarchy code.", "User and Accessibility", $Logs, "" ,"ADD", "");
					}
					//INSERT LOG - JONAS - 2/14/2019

				}
				else{ 
					echo "2|Error: " . mysql_error() . "!"; 
				}
			}else{
				echo "3|Hierarchy Code already exist."; 
			}
		break;


		case 'showtblhiecodelist':
			$res = mysql_query("SELECT reqid, reqdesc FROM tbltrans_hierarchy_reqgroup WHERE reqid LIKE '%". $_POST['key'] ."%' OR reqdesc LIKE '%". $_POST['key'] ."%' LIMIT ". $_POST['bilang'] .",10;", $connection);
			while($row = mysql_fetch_array($res)){
				?>
				<tr id="<?php echo $row[0]; ?>">
					<td class="textreqhieid"><?php echo $row[0]; ?></td>
					<td class="textreqhiedesc"><?php echo $row[1]; ?></td>
				</tr>
				<?php
			}
		    $count = mysql_fetch_array(mysql_query("SELECT COUNT(reqid) FROM tbltrans_hierarchy_reqgroup WHERE reqid LIKE '%". $_POST['key'] ."%' OR reqdesc LIKE '%". $_POST['key'] ."%';", $connection));

		    echo "|" . $count[0];
		break;


		case 'savedithiecode':
			//INSERT LOG - JONAS - 2/14/2019
			$arrHeader = ["Hierarchy Code"];
			$arrFields = ["reqid"];
			$arrValue = [$_POST['txthiecodeadd']];
			$Logs = CreateLogsArray("UPDATE", $arrHeader, $arrFields, $arrValue, "tbltrans_hierarchy_reqgroup", "reqid", $_POST['txthiecodeaddid']);
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("modified a hieararchy code.", "User and Accessibility", $Logs, "" ,"EDIT", "");
			}
			//INSERT LOG - JONAS - 2/14/2019
			$checkexisting = mysql_fetch_array(mysql_query("SELECT COUNT(reqdesc) FROM tbltrans_hierarchy_reqgroup WHERE reqdesc = '". $_POST['txthiecodeadd'] ."' AND reqid != '". $_POST['txthiecodeaddid'] ."' ;", $connection));
			if($checkexisting[0] == "0"){
				$sqlupdate = mysql_query("UPDATE tbltrans_hierarchy_reqgroup SET reqdesc = '". mysql_real_escape_string($_POST['txthiecodeadd']) ."' WHERE reqid = '". $_POST['txthiecodeaddid'] ."';", $connection);
				if($sqlupdate == true){
					echo "1|Hierarchy code successfully updated."; 
				}
				else{ 
					echo "2|Error: " . mysql_error() . "!"; 
				}
			}else{
				echo "2|Hierarchy Code already Exist."; 
			}
		break;


		case 'deletehierarchycode2':
			//INSERT LOG - JONAS - 2/14/2019
			$arrHeader = ["Hierarchy Code"];
			$arrFields = ["reqid"];
			$Logs = CreateLogsArray("DELETE", $arrHeader, $arrFields, "", "tbltrans_hierarchy_reqgroup", "reqid", $_POST['txthiecodeaddid']);
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("deleted a hieararchy code.", "User and Accessibility", $Logs, "" ,"DELETE", "");
			}
			//INSERT LOG - JONAS - 2/14/2019
			$res = mysql_query("DELETE FROM tbltrans_hierarchy_reqgroup WHERE reqid = '". $_POST['txthiecodeaddid'] ."';", $connection);
			if($res == true){
				$updateuser = mysql_query("UPDATE tbluser SET hierarchycode = '' WHERE hierarchycode = '". $_POST['txthiecodeaddid'] ."' ");
				echo "1|".$_POST['txthiecodeadd']." has been deleted.";
			}else{
				echo "2|Error: " . mysql_error() . "!";
			}
		break;

		case "loadhiecode":
			echo "<option value=''>-- Select Code --</option>";
        	$sql = "SELECT reqid, reqdesc FROM tbltrans_hierarchy_reqgroup;";
       		$result = mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{ echo "<option value='" . $row[0] . "'>" . $row[1] . "</option>"; }
		break;

		case "loadhieproperty":
			echo "<option value=''>-- Can be blank --</option>";
        	$sql = "SELECT mallid, mallname FROM tblref_mall;";
       		$result = mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{ echo "<option value='" . $row[0] . "'>" . $row[1] . "</option>"; }
		break;

		case 'savenew_hierar':
			if($_POST['id'] == ""){
				$sql = "INSERT INTO tbltrans_hierarchy SET hiecode = '". $_POST['txthiemaincode'] ."', module = '". $_POST['txthiemainmodule'] ."', role = '". $_POST['txthiemainrole'] ."', ulevel = '". $_POST['txthiemainlevel'] ."', appdfault = '". $_POST['txthiemaindefault'] ."', property = '". $_POST['txthiemainproperty'] ."', xadded = '". $_SESSION['MMS-UserID'] ."', xadddt = NOW()  ;";
				$res = mysql_query($sql, $connection) or die(mysql_error());
				if($res == true){ 
					//INSERT LOG - JONAS - 2/14/2019
					$arrHeader = ["Code", "Module", "Role", "Approval Level","Default","Property"];
					$arrValue = [$_POST['txthiemaincode'], $_POST['module'], $_POST['txthiemainrole'], $_POST['txthiemainlevel'], $_POST['txthiemaindefault'], $_POST['txthiemainproperty']];
					$Logs = CreateLogsArray("INSERT", $arrHeader, "", $arrValue, "", "", "", "");
					if($Logs != ""){
						$tran_logs = create_logs_per_transaction("created a new hierarchy of approver.", "User and Accessibility", $Logs, "" ,"ADD", "");
					}


					echo "1|Hierarcy Approver list successfully added."; 
				}
				else{ 
					echo "2|Error: " . mysql_error() . "!"; 
				}
			}else{
				//INSERT LOG - JONAS - 2/14/2019
				$arrHeader = ["Code", "Module", "Role", "Approval Level","Default","Property"];
				$arrFields = ["hiecode", "module", "role", "ulevel", "appdfault","property","xadded","xadddt"];
				$arrValue = [$_POST['txthiemaincode'], $_POST['module'], $_POST['txthiemainrole'], $_POST['txthiemainlevel'], $_POST['txthiemaindefault'], $_POST['txthiemainproperty']];
				$Logs = CreateLogsArray("UPDATE", $arrHeader, $arrFields, $arrValue, "tblref_apprlist", "id", $_POST['id']);
				if($Logs != ""){
					$tran_logs = create_logs_per_transaction("modified an hierarchy of approver.", "User and Accessibility", $Logs, "" ,"EDIT", $_POST['id']);
				}


				$sql = "UPDATE tbltrans_hierarchy SET hiecode = '". $_POST['txthiemaincode'] ."', module = '". $_POST['txthiemainmodule'] ."', role = '". $_POST['txthiemainrole'] ."', ulevel = '". $_POST['txthiemainlevel'] ."', appdfault = '". $_POST['txthiemaindefault'] ."', property = '". $_POST['txthiemainproperty'] ."' WHERE id = '". $_POST['id'] ."';";
				$res = mysql_query($sql, $connection);
				if($res == true){ 
					echo "1|Hierarcy Approver successfully updated."; 
				}
				else{ 
					echo "2|Error: " . mysql_error() . "!"; 
				}
			}
		break;

		case 'tbldisplayhierarchy':
			$ctr = 1;
			$res = mysql_query("SELECT a.id, a.hiecode, a.module, a.role, a.ulevel, a.appdfault,a.property,b.reqdesc,c.groupname  FROM tbltrans_hierarchy a INNER JOIN tbltrans_hierarchy_reqgroup b ON a.hiecode = b.reqid INNER JOIN tblref_groupaccess c ON a.role = c.groupid WHERE b.reqdesc  LIKE '%". $_POST['key'] ."%' OR a.module LIKE '%". $_POST['key'] ."%' OR c.groupname LIKE '%". $_POST['key'] ."%' ORDER BY a.xadddt DESC  LIMIT ". $_POST['bilang2'] .",10;", $connection);
			while($row = mysql_fetch_array($res)){
				if($row['ulevel']=='1'){
					$applevel = '1st Approver';
				}elseif($row['ulevel']=='2'){
					$applevel = '2nd Approver';
				}elseif($row['ulevel']=='3'){
					$applevel = '3rd Approver';
				}
				if($row['appdfault']==0){
					$dfault = 'No';
				}elseif($row['appdfault']==1){
					$dfault = 'Yes';
				}else{
					$dfault = '';
				}
				$property = mysql_fetch_array(mysql_query("SELECT  mallname FROM tblref_mall WHERE mallid = '".$row['property']."' "))
				?>
				<tr id="<?php echo $row[0]; ?>">
					<td class="hierarchycode"><?php echo $row['reqdesc']; ?></td>
					<td class="hierarchymodule"><?php echo $row['module']; ?></td>
					<td class="hierarchyrole"><?php echo $row['groupname']; ?></td>
					<td class="hierarchyulevel"><?php echo $applevel; ?></td>
					<td class="hierarchyappdfault"><?php echo $dfault; ?></td>
					<td class="hierarchyproperty"><?php echo $property['mallname']; ?></td>
				</tr>
				<?php
				$ctr++;
			}
		    $count = mysql_fetch_array(mysql_query("SELECT COUNT(a.id)  FROM tbltrans_hierarchy a INNER JOIN tbltrans_hierarchy_reqgroup b ON a.hiecode = b.reqid INNER JOIN tblref_groupaccess c ON a.role = c.groupid WHERE b.reqdesc  LIKE '%". $_POST['key'] ."%' OR a.module LIKE '%". $_POST['key'] ."%' OR c.groupname LIKE '%". $_POST['key'] ."%' ", $connection));

		    echo "|" . $count[0];
		break;

		case 'getthispick_hie':
			$hierachy = mysql_fetch_array(mysql_query("SELECT hiecode,module,role,ulevel,appdfault,property FROM tbltrans_hierarchy WHERE id = '". $_POST['id'] ."';", $connection));
			echo $hierachy['hiecode']."|".$hierachy['module']."|".$hierachy['role']."|".$hierachy['ulevel']."|".$hierachy['appdfault']."|".$hierachy['property'];
		break;


		case 'delete_hierarchy2':
			//INSERT LOG - JONAS - 2/14/2019
			$arrHeader = ["Code", "Module", "Role", "Approval Level","Default","Property"];
			$arrValue = [$_POST['txthiemaincode'], $_POST['module'], $_POST['txthiemainrole'], $_POST['txthiemainlevel'], $_POST['txthiemaindefault'], $_POST['txthiemainproperty']];
			$Logs = CreateLogsArray("DELETE", $arrHeader, $arrFields, "", "tbltrans_hierarchy", "id", $_POST['id']);
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("deleted an hierrarchy of approvers.", "User and Accessibility", $Logs, "" ,"DELETE", "");
			}
			//INSERT LOG - JONAS - 2/14/2019

			$res = mysql_query("DELETE FROM tbltrans_hierarchy WHERE id = '". $_POST['id'] ."';", $connection);
			if($res == true){
				echo "1| Has been deleted.";
			}else{
				echo "2|Error: " . mysql_error() . "!";
			}
		break;

	}
?>