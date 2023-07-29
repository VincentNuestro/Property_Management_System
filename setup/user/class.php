<?php
	session_start();
	include("../../connect.php");
	switch($_POST["form"]){
		case "loadgaccess":
			echo "<option value=''>-- Select Group Role --</option>";
        	$sql = "SELECT groupid, groupname FROM tblref_groupaccess;";
       		$result = mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{ echo "<option value='" . $row[0] . "'>" . $row[1] . "</option>"; }
		break;

		case "loadusers":
			$page = $_POST["page"];
			$limit = ($page-1) * 20;
			$added = "";
			if($_POST["gender"] != ""){ 
				$added .= " and gender = '" . $_POST["gender"] . "'"; 
			}
			if($_POST["usertype"] != ""){ 
				$added .= " and isadmin = '" . $_POST["usertype"] . "'"; 
			}
			$res = mysql_query("SELECT userid, CASE WHEN middlename = '' OR middlename IS NULL THEN CONCAT(lastname, ', ', firstname) ELSE CONCAT(lastname, ', ', firstname, ' ', LEFT(middlename, '1'), '.') END, gender, contactnumber, isadmin, emailaddress, ext, groupaccess, isActive FROM tbluser WHERE CONCAT(firstname, ' ', lastname) LIKE '%" . $_POST["key"] . "%'" . $added . " ORDER BY CASE WHEN middlename = '' OR middlename IS NULL THEN CONCAT(lastname, ', ', firstname) ELSE CONCAT(lastname, ', ', firstname, ' ', LEFT(middlename, '1'), '.') END ASC LIMIT ". $limit .",20;", $connection);
			$num = mysql_num_rows($res);
			while($row = mysql_fetch_array($res)){

				$getGroupName = mysql_fetch_array(mysql_query("SELECT groupname FROM tblref_groupaccess WHERE groupid = '". $row['groupaccess'] ."';", $connection));

				if($row[4] == "1"){
					$usertype = "Admin";
				}else{
					$usertype = "User";
				}

				if($row[6] == ""){
					$image = "assets/images/".$row[2].".png";
				}else{
					if(!file_exists("../../../Mall_Attachments/User/" . $row[0] . "." . $row[6])){ 
						$image = "assets/images/".$row[2].".png";
					}else{
						$image = "../Mall_Attachments/User/" . $row[0] . "." . $row[6];
					}
				}

				if($row['isActive'] == 1){
					$isActive = "<span style='z-index: 0;' class='label label-lg label-success arrowed-in-right arrowed'>Active</span>";
				}else{
					$isActive = "<span style='z-index: 0;' class='label label-lg label-danger arrowed-in-right arrowed'>Inactive</span>";
				}
				echo 	"<tr id='". $row[0] ."'>
							<td><img src='". $image ."' class='img-thumbnail img-circle'></td>
							<td style='vertical-align: middle;'>". $row[1] ."</td>
							<td style='vertical-align: middle;'>". $row[2] ."</td>
							<td style='vertical-align: middle;'>". $row[3] ."</td>
							<td style='vertical-align: middle;'>". $row[5] ."</td>
							<td style='vertical-align: middle;'>". $usertype ."</td>
							<td style='vertical-align: middle;'>". $getGroupName['groupname'] ."</td>
							<td style='vertical-align: middle;'>". $isActive ."</td>
							<td class='center' style='vertical-align: middle;'>
								<div class='btn-group'>
									<button class='btn btn-sm btn-info hide isadmin select-edituser btn-round' onclick='edituser(\"". $row[0] ."\", \"module\");' title='Edit User Information' style='z-index: 0;margin: 2px;'><img src='assets/images/edit.png' style='width: 100%; height: auto;'></button>
								</div>
							</td>
						</tr>";
			}

			// <button class='btn btn-sm btn-danger hide isadmin select-deleteuser' onclick='deleteuser(\"" . $row[0] . "\");' title='Delete User' style='z-index: 0;margin: 2px;'><img src='assets/images/remove.png' style='width: 100%; height: auto;'></button>
		break;

		case 'loadUsersEntries':
			$added = "";
			if($_POST["gender"] != ""){ 
				$added .= " and gender = '" . $_POST["gender"] . "'"; 
			}
			if($_POST["usertype"] != ""){ 
				$added .= " and isadmin = '" . $_POST["usertype"] . "'"; 
			}
			$sql = "SELECT COUNT(id) FROM tbluser WHERE CONCAT(firstname, ' ', lastname) LIKE '%" . $_POST["key"] . "%'" . $added;
  			$result = mysql_query($sql, $connection);
  			$row = mysql_fetch_array($result);
  			$rowsperpage = 20;
  			$totalpages = ceil($row[0] / $rowsperpage);
  			$upto = $limit + 20;
  			$from = $limit + 1;
  			if($page == $totalpages && $row[0] != 0){
  			    echo "Showing " . $from . " to " . $row[0] . " of " . $row[0] . " entries";
  			}else{
  			    if($row[0] == 0){
  			        echo 000;
  			    }else if($row[0] <= 19 && $row[0] != 0){
  			        echo "Showing 1 to " . $row[0] . " of " . $row[0] . " entries";
  			    }else if($row[0] >= 20 && $row[0] != 0){
  			        echo "Showing " . $from . " to " . $upto . " of " . $row[0] . " entries";
  			    }
  			}
		break;

		case 'loadUsersPagination':
			$added = "";
			if($_POST["gender"] != ""){ 
				$added .= " and gender = '" . $_POST["gender"] . "'"; 
			}
			if($_POST["usertype"] != ""){ 
				$added .= " and isadmin = '" . $_POST["usertype"] . "'"; 
			}
			$page = $_POST["page"];
			$sqlb = "SELECT COUNT(*) FROM tbluser WHERE CONCAT(firstname, ' ', lastname) LIKE '%" . $_POST["key"] . "%'" . $added;
			$aa = mysql_query($sqlb, $connection);
			$nums = mysql_fetch_row($aa);
			$num = $nums[0];
			$rowsperpage = 20;
			$range = 3;
			$totalpages = ceil($num / $rowsperpage);
			$prevpage;
			$nextpage;
			if($page > 1 ){
			   echo "<li style='width:50px !important;' onclick='UsersPageFunc(1)'><< First</li>";
			   $prevpage = $page - 1;
			   echo "<li style='width:70px !important;' onclick='UsersPageFunc(". $prevpage .")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   	if (($x > 0) && ($x <= $totalpages)){
			      	if ($x == $page){
		   				echo "<li id='pgLA" . $x . "' class='pgnumLA active' onclick='UsersPageFunc(" . $x . ",". $x .")'>" . $x . "</li>"; 
		   			}else{
						echo "<li id='pgLA" . $x . "' class='pgnumLA' onclick='UsersPageFunc(" . $x . ",". $x .")'>" . $x . "</li>"; 
					}
		       	}
		    }
		    if($page < ($totalpages - $range)){ 
		    	echo "<li>...</li>"; 
		    }
		    if ($page != $totalpages && $num != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='UsersPageFunc(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='UsersPageFunc(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'fncSaveUser':
			if($_POST['UserType'] == "Admin"){
				$isAdmin = "1";
			}else{
				$isAdmin = "0";
			}
			
			if($_POST['UserID'] == ""){
				$ExistingUsername = mysql_num_rows(mysql_query("SELECT username FROM tbluser WHERE username = '". $_POST['UserName'] ."';", $connection));
				if($ExistingUsername >= 1 || $_POST['UserName'] == "gates"){
					echo "2|Username already in use.";
				}else{
					$UserID = createidno("USER", "tbluser", "userid");
					$res = mysql_query("INSERT INTO tbluser SET userid = '". $UserID ."', firstname = '". ucwords($_POST['FirstName']) ."', middlename = '". ucwords($_POST['MiddleName']) ."', lastname = '". ucwords($_POST['LastName']) ."', contactnumber = '". $_POST['ContactNumber'] ."', emailaddress = '". $_POST['EmailAddress'] ."', gender = '". $_POST['Gender'] ."', username = '". $_POST['UserName'] ."', password = '". md5($_POST['Password'].$UserID."@GS") ."', dateadded = '". date('Y-m-d', strtotime(getsysdate())) ."', groupaccess = '". $_POST['GroupAccess'] ."', isAdmin = '". $isAdmin ."', MallAccess = '". $_POST['Malls'] ."', hierarchycode = '".$_POST['txthiearchycodex']."', ProcessOwner = '". $_POST['ProcessOwner'] ."';", $connection);
					if($res == true){
						echo "1|New user successfully added.|".$UserID;
						//INSERT LOG - JONAS - 2/14/2019
						$arrHeader = ["User ID", "First Name", "Middle Name", "Last Name", "Contact Number", "E-Mail Addess", "Gender", "Username", "Group Access", "User Type", "Mall Access"];
						$arrValue = [$UserID, $_POST['FirstName'], $_POST['MiddleName'], $_POST['LastName'], $_POST['ContactNumber'], $_POST['EmailAddress'], $_POST['Gender'], $_POST['UserName'], getValueofThis('groupid', 'groupname', 'tblref_groupaccess', $_POST['GroupAccess']), $_POST['UserType'], BreakThisDown('mallid', 'mallname', 'tblref_mall', $_POST['Malls'], "@")];
						$Logs = CreateLogsArray("INSERT", $arrHeader, "", $arrValue, "", "", "", "");
						if($Logs != ""){
							$tran_logs = create_logs_per_transaction("created a new user.", "User and Accessibility", $Logs, "" ,"ADD", "");
						}
						//INSERT LOG - JONAS - 2/14/2019
					}else{
						echo "2|Failed to add new user.|".$UserID;
					}
				}
			}else{
				$UserID = $_POST['UserID'];
				if($_POST['Password'] == ""){
					$isPassword = "";
				}else{
					$isPassword = ", password = '". md5($_POST['Password'].$UserID.'@GS') ."'";
				}
				$res = mysql_query("UPDATE tbluser SET firstname = '". ucwords($_POST['FirstName']) ."', middlename = '". ucwords($_POST['MiddleName']) ."', lastname = '". ucwords($_POST['LastName']) ."', contactnumber = '". $_POST['ContactNumber'] ."', emailaddress = '". $_POST['EmailAddress'] ."', gender = '". $_POST['Gender'] ."', dateadded = '". date('Y-m-d', strtotime(getsysdate())) ."', groupaccess = '". $_POST['GroupAccess'] ."', isAdmin = '". $isAdmin ."', MallAccess = '". $_POST['Malls'] ."', hierarchycode = '".$_POST['txthiearchycodex']."', username = '". $_POST['UserName'] ."', ProcessOwner = '". $_POST['ProcessOwner'] ."' ". $isPassword ." WHERE userid = '". $_POST['UserID'] ."';", $connection);
				if($res == true){
					echo "1|User information successfully updated.|".$_POST['UserID'];
					//INSERT LOG - JONAS - 2/14/2019
					$arrHeader = ["User ID", "First Name", "Middle Name", "Last Name", "Contact Number", "E-Mail Addess", "Gender", "Username", "Group Access", "User Type", "Mall Access"];
					$arrFields = ["userid", "firstname", "middlename", "lastname", "contactnumber", "emailaddress", "gender", "username", "groupaccess", "isAdmin", "MallAccess"];
					$arrValue = [$UserID, $_POST['FirstName'], $_POST['MiddleName'], $_POST['LastName'], $_POST['ContactNumber'], $_POST['EmailAddress'], $_POST['Gender'], $_POST['UserName'], getValueofThis('groupid', 'groupname', 'tblref_groupaccess', $_POST['GroupAccess']), $_POST['UserType'], BreakThisDown('mallid', 'mallname', 'tblref_mall', $_POST['Malls'], "@")];
					$Logs = CreateLogsArray("UPDATE", $arrHeader, $arrFields, $arrValue, "tbluser", "userid", $UserID);
					if($Logs != ""){
						$tran_logs = create_logs_per_transaction("modified a user information.", "User and Accessibility", $Logs, "" ,"EDIT", "");
					}
					//INSERT LOG - JONAS - 2/14/2019
				}else{
					echo "2|Failed to edit user information.|".$_POST['UserID'];
				}
			}
		break;

		case "edituser":
			$sql = "SELECT firstname, middlename, lastname, contactnumber, emailaddress, gender, username, isadmin, password, dateadded, groupaccess, userid, ext, MallAccess, isActive, hierarchycode, ProcessOwner FROM tbluser WHERE userid = '" . $_POST["userid"] . "';";
			$row = mysql_fetch_array(mysql_query($sql, $connection));

			if($row['ext'] == ""){
				$img = "assets/images/".$row['gender'].".png";
			}else{
				if(!file_exists("../../../Mall_Attachments/User/".$row['userid'].".".$row['ext'])){ 
					$img = "assets/images/".$row['gender'].".png";
				}else{
					$img = "../Mall_Attachments/User/".$row['userid'].".".$row['ext'];
				}
			}

			if($row[7] == "1"){
				$usertype = "Admin";
			}else{
				$usertype = "User";
			}

			echo $row['firstname'] . "|" . $row['middlename'] . "|" . $row['lastname'] . "|" . $row['gender'] . "|" . $row['username'] . "|" . $row['contactnumber'] . "|" . $row['emailaddress'] . "|" . $usertype . "|" . $row['groupaccess'] . "|" . $img . "|" . $row['MallAccess'] . "|" . $row['isActive'] . "|" . $row['hierarchycode'] . "|" . $row['ProcessOwner'];
		break;

		case 'deletegroupname':
			//INSERT LOG - JONAS - 2/14/2019
			$arrHeader = ["Group ID", "Group Name"];
			$arrFields = ["groupid", "groupname"];
			$Logs = CreateLogsArray("DELETE", $arrHeader, $arrFields, "", "tblref_groupaccess", "groupid", $_POST['id']);
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("deleted a group.", "User and Accessibility", $Logs, "" ,"DELETE", "");
			}
			//INSERT LOG - JONAS - 2/14/2019
			$res = mysql_query("DELETE FROM tblref_groupaccess WHERE groupid = '". $_POST['id'] ."';", $connection);
			if($res == true){
				echo "1|".$_POST['groupname']." has been deleted.";
			}else{
				echo "2|Error: " . mysql_error() . "!";
			}
		break;

		case "savegroupaccess":
			$checkexisting = mysql_fetch_array(mysql_query("SELECT COUNT(groupname) FROM tblref_groupaccess WHERE groupname = '". $_POST['groupname'] ."';", $connection));
			if($checkexisting[0] == "0"){
				$groupid = createidno("", "tblref_groupaccess", "groupid");
				$result = mysql_query("INSERT INTO tblref_groupaccess(groupid, groupname, dateadded) VALUES('" . $groupid . "', '" . $_POST["groupname"] . "', '" . date("Y-m-d") . "');", $connection);
				if($result == true){ 
					echo "1|Group name successfully added."; 

					//INSERT LOG - JONAS - 2/14/2019
					$arrHeader = ["Group ID", "Group Name"];
					$arrValue = [$groupid, $_POST['groupname']];
					$Logs = CreateLogsArray("INSERT", $arrHeader, "", $arrValue, "", "", "", "");
					if($Logs != ""){
						$tran_logs = create_logs_per_transaction("created a new group.", "User and Accessibility", $Logs, "" ,"ADD", "");
					}
					//INSERT LOG - JONAS - 2/14/2019

				}
				else{ 
					echo "2|Error: " . mysql_error() . "!"; 
				}
			}else{
				echo "3|Group name already exist."; 
			}
		break;

		case 'saveditgroupname':
			//INSERT LOG - JONAS - 2/14/2019
			$arrHeader = ["Group Name"];
			$arrFields = ["groupname"];
			$arrValue = [$_POST['groupname']];
			$Logs = CreateLogsArray("UPDATE", $arrHeader, $arrFields, $arrValue, "tblref_groupaccess", "groupid", $_POST['id']);
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("modified a group name.", "User and Accessibility", $Logs, "" ,"EDIT", "");
			}
			//INSERT LOG - JONAS - 2/14/2019

			$sqlupdate = mysql_query("UPDATE tblref_groupaccess SET groupname = '". $_POST['groupname'] ."' WHERE groupid = '". $_POST['id'] ."';", $connection);
			if($sqlupdate == true){
				echo "1|Group name successfully updated."; 
			}
			else{ 
				echo "2|Error: " . mysql_error() . "!"; 
			}
		break;

		case 'showtblgrouplist':
			$res = mysql_query("SELECT groupid, groupname FROM tblref_groupaccess WHERE groupid LIKE '%". $_POST['key'] ."%' OR groupname LIKE '%". $_POST['key'] ."%' LIMIT ". $_POST['bilang'] .",10;", $connection);
			while($row = mysql_fetch_array($res)){
				?>
				<tr id="<?php echo $row[0]; ?>">
					<td class="textgroupid"><?php echo $row[0]; ?></td>
					<td class="textgroupname"><?php echo $row[1]; ?></td>
				</tr>
				<?php
			}
		    $count = mysql_fetch_array(mysql_query("SELECT COUNT(groupid) FROM tblref_groupaccess WHERE groupid LIKE '%". $_POST['key'] ."%' OR groupname LIKE '%". $_POST['key'] ."%';", $connection));

		    echo "|" . $count[0];
		break;

		case 'adduseracce':
			$delete = mysql_query("DELETE FROM tblref_usergroupaccess WHERE groupid = '". $_POST['groupid'] ."';", $connection);
			if($delete == true){
				$arr = explode("#", $_POST['permissions']);
				for ( $a = 1; $a <= count($arr) -1; $a++ ) {
					$arr2 = explode("|", $arr[$a]);
					$arr3 = explode("-", $arr2[1]);
						if($arr3[0] == "page1" || $arr3[0] == "page2" || $arr3[0] == "page3" || $arr3[0] == "page4" || $arr3[0] == "page5" || $arr3[0] == "page6"){
							$seq = "1";
						}else if($arr3[0] == "leads"){
							$seq = "2";
						}else if($arr3[0] == "inquiry"){
							$seq = "3";
						}else if($arr3[0] == "leasingapplication"){
							$seq = "4";
						}else if($arr3[0] == "reservation"){
							$seq = "5";
						}else if($arr3[0] == "tenants"){
							$seq = "6";
						}else if($arr3[0] == "tenantportal"){
							$seq = "7";
						}else if($arr3[0] == "tenantrequest"){
							$seq = "8";
						}else if($arr3[0] == "billing"){
							$seq = "9";
						}else if($arr3[0] == "maintenance"){
							$seq = "10";
						}else if($arr3[0] == "complaints"){
							$seq = "11";
						}else if($arr3[0] == "baggagelogs"){
							$seq = "12";
						}else if($arr3[0] == "visitorlogs"){
							$seq = "13";
						}else if($arr3[0] == "floorplan"){
							$seq = "14";
						}else if($arr3[0] == "filemonitoring"){
							$seq = "15";
						}else if($arr3[0] == "reports"){
							$seq = "16";
						}else if($arr3[0] == "systemsetup"){
							$seq = "17";
						}

					$sql = " INSERT INTO tblref_usergroupaccess SET groupid = '". $_POST['groupid'] ."', module = '". $arr3[0] ."', functionid = '". $arr3[1] ."', sequence = '". $seq ."', moduletab = '". $arr2[0] ."';";
					$res = mysql_query($sql, $connection);
				}
			}
		break;

		case 'loadusergroupaccesslist':
			$selectaccesslist = mysql_query("SELECT module, functionid FROM tblref_usergroupaccess WHERE groupid = '". $_POST['groupid'] ."';", $connection);
			while ($row = mysql_fetch_array($selectaccesslist)) {
				echo $row[0]."-".$row[1]."|";
			}	
		break;

		case 'loadusergroupaccesslist2':
			$selectaccesslist = mysql_query("SELECT DISTINCT module FROM tblref_usergroupaccess WHERE groupid = '". $_POST['groupid'] ."';", $connection);
			while ($row = mysql_fetch_array($selectaccesslist)) {
				echo $row[0]."|";
			}	
		break;

		case 'loadusergroupaccesslist3':
			$selectaccesslist = mysql_query("SELECT DISTINCT moduletab FROM tblref_usergroupaccess WHERE groupid = '". $_POST['groupid'] ."';", $connection);
			while ($row = mysql_fetch_array($selectaccesslist)) {
				echo $row[0]."|";
			}	
		break;

		case 'tbldisplayapprlist':
			$res = mysql_query("SELECT id, code, module, personnel, designation, level  FROM tblref_apprlist WHERE code LIKE '%". $_POST['key'] ."%' OR module LIKE '%". $_POST['key'] ."%' OR personnel LIKE '%". $_POST['key'] ."%' OR designation LIKE '%". $_POST['key'] ."%' OR level LIKE '%". $_POST['key'] ."%' LIMIT ". $_POST['bilang2'] .",10;", $connection);
			while($row = mysql_fetch_array($res)){
				?>
				<tr id="<?php echo $row[0]; ?>">
					<td class="apprlistcode"><?php echo $row[1]; ?></td>
					<td class="apprlistmodule"><?php echo $row[2]; ?></td>
					<td class="apprlistpersonnel"><?php echo $row[3]; ?></td>
					<td class="apprlistdesignation"><?php echo $row[4]; ?></td>
					<td class="apprlistlist"><?php echo $row[5]; ?></td>
				</tr>
				<?php
			}
		    $count = mysql_fetch_array(mysql_query("SELECT COUNT(code) FROM tblref_apprlist WHERE code LIKE '%". $_POST['key'] ."%' OR module LIKE '%". $_POST['key'] ."%' OR personnel LIKE '%". $_POST['key'] ."%' OR designation LIKE '%". $_POST['key'] ."%' OR level LIKE '%". $_POST['key'] ."%';", $connection));

		    echo "|" . $count[0];
		break;

		case 'savenewall':
			if($_POST['id'] == ""){
				$sql = "INSERT INTO tblref_apprlist SET code = '". $_POST['code'] ."', module = '". $_POST['module'] ."', personnel = '". $_POST['personnel'] ."', designation = '". $_POST['designation'] ."', level = '". $_POST['level'] ."';";
				$res = mysql_query($sql, $connection);
				if($res == true){ 
					//INSERT LOG - JONAS - 2/14/2019
					$arrHeader = ["Code", "Module", "Personnel", "Designation", "Approval Level"];
					$arrValue = [$_POST['code'], $_POST['module'], $_POST['personnel'], $_POST['designation'], $_POST['level']];
					$Logs = CreateLogsArray("INSERT", $arrHeader, "", $arrValue, "", "", "", "");
					if($Logs != ""){
						$tran_logs = create_logs_per_transaction("created a new approval level.", "User and Accessibility", $Logs, "" ,"ADD", "");
					}
					//INSERT LOG - JONAS - 2/14/2019

					echo "1|Approval list successfully added."; 
				}
				else{ 
					echo "2|Error: " . mysql_error() . "!"; 
				}
			}else{
				//INSERT LOG - JONAS - 2/14/2019
				$arrHeader = ["Code", "Module", "Personnel", "Designation", "Approval Level"];
				$arrFields = ["code", "module", "personnel", "designation", "level"];
				$arrValue = [$_POST['code'], $_POST['module'], $_POST['personnel'], $_POST['designation'], $_POST['level']];
				$Logs = CreateLogsArray("UPDATE", $arrHeader, $arrFields, $arrValue, "tblref_apprlist", "id", $_POST['id']);
				if($Logs != ""){
					$tran_logs = create_logs_per_transaction("modified an approval level.", "User and Accessibility", $Logs, "" ,"EDIT", $_POST['id']);
				}
				//INSERT LOG - JONAS - 2/14/2019

				$sql = "UPDATE tblref_apprlist SET code = '". $_POST['code'] ."', module = '". $_POST['module'] ."', personnel = '". $_POST['personnel'] ."', designation = '". $_POST['designation'] ."', level = '". $_POST['level'] ."' WHERE id = '". $_POST['id'] ."';";
				$res = mysql_query($sql, $connection);
				if($res == true){ 
					echo "1|Approval list successfully updated."; 
				}
				else{ 
					echo "2|Error: " . mysql_error() . "!"; 
				}
			}
		break;

		case 'deleteappr2':
			//INSERT LOG - JONAS - 2/14/2019
			$arrHeader = ["Code", "Module", "Personnel", "Designation", "Approval Level"];
			$arrFields = ["code", "module", "personnel", "designation", "level"];
			$Logs = CreateLogsArray("DELETE", $arrHeader, $arrFields, "", "tblref_apprlist", "id", $_POST['id']);
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("deleted an approval level.", "User and Accessibility", $Logs, "" ,"DELETE", "");
			}
			//INSERT LOG - JONAS - 2/14/2019

			$res = mysql_query("DELETE FROM tblref_apprlist WHERE id = '". $_POST['id'] ."';", $connection);
			if($res == true){
				echo "1|".$_POST['groupname']." has been deleted.";
			}else{
				echo "2|Error: " . mysql_error() . "!";
			}
		break;

		case 'showtbluserlist':
			$res = mysql_query("SELECT a.userid, CONCAT(a.firstname, ' ', a.middlename, ' ', a.lastname), b.groupname FROM tbluser AS a INNER JOIN tblref_groupaccess AS b ON a.groupaccess = b.groupid WHERE a.userid LIKE '%". $_POST['key'] ."%' OR b.groupname LIKE '%". $_POST['key'] ."%' OR CONCAT(a.firstname, ' ', a.middlename, ' ', a.lastname) LIKE '%". $_POST['key'] ."%' LIMIT ". $_POST['bilang3'] .",10;", $connection);
			while($row = mysql_fetch_array($res)){
				echo "	<tr id=".$row[0].">
							<td>".$row[0]."</td>
							<td>".$row[1]."</td>
							<td>".$row[2]."</td>
						</tr>
					";
			}
			$count = mysql_fetch_array(mysql_query("SELECT COUNT(a.userid) FROM tbluser AS a INNER JOIN tblref_groupaccess AS b ON a.groupaccess = b.groupid WHERE a.userid LIKE '%". $_POST['key'] ."%' OR b.groupname LIKE '%". $_POST['key'] ."%' OR CONCAT(a.firstname, ' ', a.middlename, ' ', a.lastname) LIKE '%". $_POST['key'] ."%';", $connection));

		    echo "|" . $count[0];
		break;

		case 'showApprovalList':
			echo "<option value=''>-- Select Access --</option>";
        	$sql = "SELECT code FROM tblref_apprlist;";
       		$result = mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{ echo "<option value='" . $row[0] . "'>" . $row[0] . "</option>"; }
		break;

		case 'gettheblanks':
			$blanks = mysql_fetch_array(mysql_query("SELECT module, designation, level FROM tblref_apprlist WHERE code = '". $_POST['val'] ."';", $connection));
			if($blanks[0] == ""){
				$module = "-";
			}else{
				$module = $blanks[0];
			}
			if($blanks[1] == ""){
				$designation = "-";
			}else{
				$designation = $blanks[1];
			}
			if($blanks[2] == ""){
				$level = "-";
			}else{
				$level = $blanks[2];
			}

			echo $module . "|" . $designation . "|" . $level;
		break;

		case 'pickappruserlist':
			$count = 1;
			$res = mysql_query("SELECT code, module, designation, level FROM tblref_apprlistperuser WHERE userid = '". $_POST['id'] ."';", $connection);
			while ($row = mysql_fetch_array($res)) {

				echo "	<div class='row form-group addonslang' id='blankcontainer-".$count."'> 
                            <div class='col-md-1'> 
                                <label> 
                                    <input name='form-field-checkbox' class='ace ace-checkbox-2 checkedappr dimapindot' type='checkbox' id='apprchk-".$count."' disabled> 
                                    <span class='lbl'></span> 
                                </label> 
                            </div> 
                            <div class='col-md-4'> 
                                <select class='form-control ApprovalList dimapindot' id='approvallist-".$count."' onchange='fillintheblanks(this.value, this.id)' value='".$row[0]."' disabled>";
                                	echo "<option value='".$row[0]."'>".$row[0]."</option>";
                                	$res2 = mysql_query("SELECT code FROM tblref_apprlist WHERE code != '". $row[0] ."';", $connection);
                                	while($row2 = mysql_fetch_array($res2)){	
                                		echo "<option value='".$row2[0]."'>".$row2[0]."</option>";
                                	}
                echo "	         </select> 
                            </div> 
                            <div class='col-md-3'> 
                                <label id='apprmodule-".$count."'>".$row[1]."</label> 
                            </div> 
                            <div class='col-md-3'> 
                                <label id='apprdesignation-".$count."'>".$row[2]."</label> 
                            </div> 
                            <div class='col-md-1'> 
                                <label id='apprlevel-".$count."'>".$row[3]."</label> 
                            </div>
                   	 	</div>";
            $count++;
			}

			echo "|".$count;
		break;

		case 'saveaccesstouser':
			$sqlcheckexisting = mysql_fetch_array(mysql_query("SELECT COUNT(userid) FROM tblref_apprlistperuser WHERE userid = '". $_POST['userid'] ."';", $connection));
			if($sqlcheckexisting[0] > 0){
				$deletefirst = mysql_query("DELETE FROM tblref_apprlistperuser WHERE userid = '". $_POST['userid'] ."';", $connection);
				if($deletefirst == true){
					$arr = explode("|", $_POST['id']);
					for ($a=0; $a <= COUNT($arr)-2; $a++) { 
						$apprlist = mysql_fetch_array(mysql_query("SELECT module, designation, level FROM tblref_apprlist WHERE code = '". $arr[$a] ."';", $connection));
						$sql = "INSERT INTO tblref_apprlistperuser SET userid = '". $_POST['userid'] ."', code = '". $arr[$a] ."', module = '". $apprlist[0] ."', designation = '". $apprlist[1] ."', level = '". $apprlist[2] ."';";
						$res = mysql_query($sql, $connection);
					}
					echo "1|Approval access successfully updated.";
				}
			}else{
				$arr = explode("|", $_POST['id']);
				for ($a=0; $a <= COUNT($arr)-2; $a++) { 
					$apprlist = mysql_fetch_array(mysql_query("SELECT module, designation, level FROM tblref_apprlist WHERE code = '". $arr[$a] ."';", $connection));
					$sql = "INSERT INTO tblref_apprlistperuser SET userid = '". $_POST['userid'] ."', code = '". $arr[$a] ."', module = '". $apprlist[0] ."', designation = '". $apprlist[1] ."', level = '". $apprlist[2] ."';";
					$res = mysql_query($sql, $connection);
				}
					echo "1|Approval access successfully added.";
			}
		break;

		case 'olMallList':
			$res = mysql_query("SELECT mallid, mallname FROM tblref_mall WHERE mallstat = '1';", $connection);
			while($row = mysql_fetch_array($res)){
				echo 	"<li class='dd-item dd2-item'>
                         	<div class='dd2-content'>
                         		<div class='checkbox'>
									<label>
										<input type='checkbox' class='chkUserMallAccess ace disableifheader' value='". $row['mallid'] ."'>
										<span class='lbl' style='color: black;'>&nbsp;".$row['mallname']."</span>
									</label>
								</div>
                         	</div>
                     	</li>";
			}
		break;

		case 'checkNeededData':
			$rowGroupAccessCount = mysql_num_rows(mysql_query("SELECT id FROM tblref_groupaccess;", $connection));
			$rowMallCount = mysql_num_rows(mysql_query("SELECT id FROM tblref_mall WHERE mallstat = '1';", $connection));
			echo $rowGroupAccessCount . "|" . $rowMallCount;
		break;

		case 'fncChangeUserStatus':
			//INSERT LOG - JONAS - 5/21/2019
			$arrHeader = ["User Status"];
			$arrFields = ["isActive"];
			$arrValue = [$_POST['UserStatus']];
			$Logs = CreateLogsArray("UPDATE", $arrHeader, $arrFields, $arrValue, "tbluser", "userid", $_POST['UserID']);
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("change the user status.", "User and Accessibility", $Logs, "" ,"UPDATE", "");
			}
			//INSERT LOG - JONAS - 5/21/2019
			$res = mysql_query("UPDATE tbluser SET isActive = '". $_POST['UserStatus'] ."' WHERE userid = '". $_POST['UserID'] ."';", $connection);
		break;

		case 'fncSaveProcessOwner':
			$res = mysql_query("INSERT INTO tblref_process_owner SET deptCode = '". $_POST['Code'] ."', deptDesc = '". $_POST['Desc'] ."';", $connection);
			if($res == true){
				echo 1;
			}else{
				echo 2;
			}
		break;

		case 'fncLoadProcessOwner':
			echo "<option value=''>-- Select Process Owner --</option>";
			$res = mysql_query("SELECT deptCode, deptDesc FROM tblref_process_owner;", $connection);
			while($row = mysql_fetch_array($res)){
				echo "<option value='". $row['deptCode'] ."'>". $row['deptDesc'] ."</option>";
			}
		break;
	}
?>