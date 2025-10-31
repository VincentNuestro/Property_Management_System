<?php
    session_start();
	include "../connect.php";
	switch ($_POST['form']) {
		case 'fncSaveBillSetup':
			$getRecord = mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM tblref_msbilling WHERE MallID = '". $_POST['MallID'] ."';", $connection));
			if($getRecord[0] == 0){
				$res = mysql_query("INSERT INTO tblref_msbilling SET MallID = '". $_POST['MallID'] ."', MonthlyRent = '". $_POST['MonthlyRent'] ."', OperationalCharges = '". $_POST['OperationalCharges'] ."';", $connection);
				if($res == true){
					echo "1";
				}else{
					echo "3";
				}
			}else{
				$res = mysql_query("UPDATE tblref_msbilling SET MonthlyRent = '". $_POST['MonthlyRent'] ."', OperationalCharges = '". $_POST['OperationalCharges'] ."' WHERE MallID = '". $_POST['MallID'] ."';", $connection);
				if($res == true){
					echo "2";
				}else{
					echo "3";
				}
			}
		break;

		case 'loadBillSetup':
			$BillSetup = mysql_fetch_array(mysql_query("SELECT MonthlyRent, OperationalCharges FROM tblref_msbilling WHERE MallID = '". $_POST['MallID'] ."' LIMIT 1;", $connection));
			echo $BillSetup['MonthlyRent'] . "|" . $BillSetup['OperationalCharges'];
		break;

		case 'fnctbodySchedMaintenance':
			$sql = "SELECT SchedID, xPeriod, xPersonnel, xDOTW1, xDOTW2, xDOTM1, xDOTM2, FQ_Date1, FQ_Date2, SQ_Date1, SQ_Date2, TQ_Date1, TQ_Date2, LQ_Date1, LQ_Date2 FROM tblref_MSMaintenance_h WHERE mallID = '". $_SESSION['MMS-Designation'] ."' GROUP BY SchedID ORDER BY SchedID ASC;";
			$res = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($res)){
				$MallName = mysql_fetch_array(mysql_query("SELECT b.mallname FROM tblref_MSMaintenance_h AS a LEFT JOIN tblref_mall AS b ON a.mallID = b.mallid WHERE a.SchedID = '". $row['SchedID'] ."';", $connection));
				$Department = mysql_fetch_array(mysql_query("SELECT b.groupname FROM tblref_MSMaintenance_h AS a LEFT JOIN tblref_groupaccess AS b ON a.GroupAccess = b.groupid WHERE a.SchedID = '". $row['SchedID'] ."'", $connection));

				if($row['xPeriod'] == "Daily"){

					$Occurence = "<span class='blue fa fa-angle-double-right'></span>&nbsp;Every end of day";

				}else if($row['xPeriod'] == "Weekly"){

					$Occurence = "<span class='blue fa fa-angle-double-right'></span>&nbsp;Day of Creation: <br>&emsp;<span class='fa fa-angle-right blue'></span>&nbsp;". $row['xDOTW1'] ."<br><span class='blue fa fa-angle-double-right'></span>&nbsp;Work Order Day: <br>&emsp;<span class='fa fa-angle-right blue'></span>&nbsp;". $row['xDOTW2'];

				}else if($row['xPeriod'] == "Monthly"){

					$ends = array('th','st','nd','rd','th','th','th','th','th','th');
				    if((($row['xDOTM1'] % 100) >= 11) && (($row['xDOTM1']%100) <= 13)){
				    	$DOTM1 = $row['xDOTM1'] . $ends[$row['xDOTM'] % 10];
				    }else{
				    	$DOTM1 = $row['xDOTM1'] . $ends[$row['xDOTM1'] % 10];
				    }

				    if((($row['xDOTM2'] % 100) >= 11) && (($row['xDOTM2']%100) <= 13)){
				    	$DOTM2 = $row['xDOTM2'] . $ends[$row['xDOTM2'] % 10];
				    }else{
				    	$DOTM2 = $row['xDOTM2'] . $ends[$row['xDOTM2'] % 10];
				    }

			       $Occurence = "<span class='blue fa fa-angle-double-right'></span>&nbsp;Create Date: <br>&emsp;<span class='fa fa-angle-right blue'></span>&nbsp;". $DOTM1 ." day of the month<br><span class='blue fa fa-angle-double-right'></span>&nbsp;Work Order Date: <br>&emsp;<span class='fa fa-angle-right blue'></span>&nbsp;". $DOTM2 ." day of the month";

				}else if($row['xPeriod'] == "Quarterly"){

					$Occurence = "
								<span class='blue fa fa-angle-double-right'></span>&nbsp;1st Quarter: <br>&emsp;Create Date: <span class='fa fa-angle-right blue'></span>&nbsp;". date('F d, Y', strtotime($row['FQ_Date1'])) ."<br>&emsp; Work Order Date: <span class='fa fa-angle-right blue'></span>&nbsp;". date('F d, Y', strtotime($row['FQ_Date2'])) ."<br>

								<span class='blue fa fa-angle-double-right'></span>&nbsp;2nd Quarter: <br>&emsp;Create Date: <span class='fa fa-angle-right blue'></span>&nbsp;". date('F d, Y', strtotime($row['SQ_Date1'])) ."<br>&emsp; Work Order Date: <span class='fa fa-angle-right blue'></span>&nbsp;". date('F d, Y', strtotime($row['SQ_Date2'])) ."<br>

								<span class='blue fa fa-angle-double-right'></span>&nbsp;3rd Quarter: <br>&emsp;Create Date: <span class='fa fa-angle-right blue'></span>&nbsp;". date('F d, Y', strtotime($row['TQ_Date1'])) ."<br>&emsp; Work Order Date: <span class='fa fa-angle-right blue'></span>&nbsp;". date('F d, Y', strtotime($row['TQ_Date2'])) ."<br>

								<span class='blue fa fa-angle-double-right'></span>&nbsp;4th Quarter: <br>&emsp;Create Date: <span class='fa fa-angle-right blue'></span>&nbsp;". date('F d, Y', strtotime($row['LQ_Date1'])) ."<br>&emsp; Work Order Date: <span class='fa fa-angle-right blue'></span>&nbsp;". date('F d, Y', strtotime($row['LQ_Date2'])) ."<br>";

				}else if($row['xPeriod'] == "Biannually"){

					$Occurence = "<span class='blue fa fa-angle-double-right'></span>&nbsp;1st Quarter: <br>&emsp;Create Date: <span class='fa fa-angle-right blue'></span>&nbsp;". date('F d, Y', strtotime($row['FQ_Date1'])) ."<br>&emsp; Work Order Date: <span class='fa fa-angle-right blue'></span>&nbsp;". date('F d, Y', strtotime($row['FQ_Date2'])) ."<br>

								<span class='blue fa fa-angle-double-right'></span>&nbsp;2nd Quarter: <br>&emsp;Create Date: <span class='fa fa-angle-right blue'></span>&nbsp;". date('F d, Y', strtotime($row['SQ_Date1'])) ."<br>&emsp; Work Order Date: <span class='fa fa-angle-right blue'></span>&nbsp;". date('F d, Y', strtotime($row['SQ_Date2']));

				}else if($row['xPeriod'] == "Annually"){

			       $Occurence = "<span class='blue fa fa-angle-double-right'></span>&nbsp;Create Date: <br>&emsp;<span class='fa fa-angle-right blue'></span>&nbsp;". date('F d, Y', strtotime($row['FQ_Date1'])) ."<br><span class='blue fa fa-angle-double-right'></span>&nbsp;Work Order Date: <br>&emsp;<span class='fa fa-angle-right blue'></span>&nbsp;". date('F d, Y', strtotime($row['FQ_Date2']));

				}else{

					$Occurence = "";
				}

				echo "	<tr>
							<td>". $row['xPeriod'] ."</td>
							<td>". $Occurence ."</td>
							<td>". $Department[0] ."</td>
							<td>";
							$mgaMeron = "";
							$arr = explode(",", $row['xPersonnel']);
							for ($i = 0; $i <= count($arr)-1; $i++) { 
								$mgaMeron .= "'" . $arr[$i] . "'" . ",";
							}
							$resWorkerName = mysql_query("SELECT CASE WHEN middlename = '' OR middlename IS NULL THEN CONCAT(lastname, ', ', firstname) ELSE CONCAT(lastname, ', ', firstname, ' ', LEFT(middlename, '1'), '.') END, isActive FROM tbluser WHERE userid IN (". substr(trim($mgaMeron), 0, -1) .");", $connection);
							while($rowWorkerName = mysql_fetch_array($resWorkerName)){
								if($rowWorkerName['isActive'] == "1"){
									$isActive = "<span class='fa fa-user green'></span>";
								}else{
									$isActive = "<span class='fa fa-user red'></span>";
								}
								echo $isActive . "&nbsp;&nbsp;". $rowWorkerName[0] . "<br>";
							}
				echo		"</td>
							<td style='width: 19%;'>";
								$resMaintenance = mysql_query("SELECT xCategory, xTask FROM tblref_msmaintenance_d WHERE SchedID = '". $row['SchedID'] ."' GROUP BY xTask;", $connection);
								while($rowMaintenance = mysql_fetch_array($resMaintenance)){
									$Task = mysql_fetch_array(mysql_query("SELECT description FROM tblmaintenance_tasklist WHERE taskid = '". $rowMaintenance['xTask'] ."' ", $connection));
										echo "<span class='fa fa-wrench blue'></span> ". $Task['description'] ."<br>";
								}
				echo		"</td>
							<td style='z-index: 0';>
								<button class='btn btn-sm btn-round btn-info' title='Edit Schedule' style='margin: 2px;' onclick='OpenThisOnModal(\"". $row['SchedID'] ."\")'><img src='assets/images/resume.png' style='width: 100%; height: auto;' /></button>
							</td>
						</tr>";
			}
		break;

		case 'loadSchedSetup':
			$row = mysql_fetch_array(mysql_query("SELECT TenantID, GroupAccess, xPeriod, xPersonnel, xDOTW1, xDOTW2, xDOTM1, xDOTM2, FQ_Date1, FQ_Date2, SQ_Date1, SQ_Date2, TQ_Date1, TQ_Date2, LQ_Date1, LQ_Date2, isAllTenant, isAllPersonnel FROM tblref_MSMaintenance_h WHERE SchedID = '". $_POST['SchedID'] ."';", $connection));

			if($row['FQ_Date1'] == ""){
				$FirstQuarter1 = "";
			}else{
				$FirstQuarter1 = date('m/d/Y', strtotime($row['FQ_Date1']));
			}

			if($row['FQ_Date2'] == ""){
				$FirstQuarter2 = "";
			}else{
				$FirstQuarter2 = date('m/d/Y', strtotime($row['FQ_Date2']));
			}

			if($row['SQ_Date1'] == ""){
				$SecondQuarter1 = "";
			}else{
				$SecondQuarter1 = date('m/d/Y', strtotime($row['SQ_Date1']));
			}

			if($row['SQ_Date2'] == ""){
				$SecondQuarter2 = "";
			}else{
				$SecondQuarter2 = date('m/d/Y', strtotime($row['SQ_Date2']));
			}

			if($row['TQ_Date1'] == ""){
				$ThirdQuarter1 = "";
			}else{
				$ThirdQuarter1 = date('m/d/Y', strtotime($row['TQ_Date1']));
			}

			if($row['TQ_Date2'] == ""){
				$ThirdQuarter2 = "";
			}else{
				$ThirdQuarter2 = date('m/d/Y', strtotime($row['TQ_Date2']));
			}

			if($row['LQ_Date1'] == ""){
				$LastQuarter1 = "";
			}else{
				$LastQuarter1 = date('m/d/Y', strtotime($row['LQ_Date1']));
			}

			if($row['LQ_Date2'] == ""){
				$LastQuarter2 = "";
			}else{
				$LastQuarter2 = date('m/d/Y', strtotime($row['LQ_Date2']));
			}

			echo $row['TenantID'] . "|" . $row['GroupAccess'] . "|" . $row['xPersonnel'] . "|" . $row['xPeriod'] . "|" . $row['xDOTW1'] . "|" . $row['xDOTW2'] . "|" . $row['xDOTM1'] . "|" . $row['xDOTM2'] . "|" . $FirstQuarter1 . "|" . $FirstQuarter2 . "|" . $SecondQuarter1 . "|" . $SecondQuarter2 . "|" . $ThirdQuarter1 . "|" . $ThirdQuarter2 . "|" . $LastQuarter1 . "|" . $LastQuarter2 . "|" . $row['isAllTenant'] . "|" .  $row['isAllPersonnel'];
		break;

		case 'loadSchedSetup2':
			$resSchedDetails = mysql_query("SELECT xCategory, xTask FROM tblref_msmaintenance_d WHERE SchedID = '". $_POST['SchedID'] ."' GROUP BY xTask;", $connection);
			while($rowSchedDetails = mysql_fetch_array($resSchedDetails)){
				$CatInfo = mysql_fetch_array(mysql_query("SELECT category FROM tblmaintenance_category WHERE category_id = '". $rowSchedDetails['xCategory'] ."';", $connection));
				$TaskInfo = mysql_fetch_array(mysql_query("SELECT description, amount FROM tblmaintenance_tasklist WHERE taskid = '". $rowSchedDetails['xTask'] ."';", $connection));
				echo 	"<tr id=". $rowSchedDetails['xTask'] .">
							<td class='TaskAmount2 hide'>". $TaskInfo['amount'] ."</td>
							<td>". $CatInfo['category'] ."</td>
							<td>". $TaskInfo['description'] ."</td>
							<td style='text-align: right;'>". number_format($TaskInfo['amount'], 2, '.', ',') ."</td>
						</tr>";
			}
		break;

		case 'SchedDepartment':
			$res = mysql_query("SELECT groupid, groupname FROM tblref_groupaccess ORDER BY groupname ASC", $connection);
			while($row = mysql_fetch_array($res)){
				echo "<option value='" . $row[0] . "'>" . $row[1] . "</option>";
			}
		break;

		case 'SchedPersonnel':
			if($_POST['val'] != ""){
				$res = mysql_query("SELECT userid, firstname, middlename, lastname FROM tbluser WHERE groupaccess = '". $_POST['val'] ."'", $connection);
				while($row = mysql_fetch_array($res)){
					if($row['middlename'] == ""){
						$FullName = $row['firstname'] . " " . $row['lastname'];
					}else{
						$FullName = $row['firstname'] . " " . $row['middlename'][0] . ". " . $row['lastname'];
					}
					echo "<option value='" . $row['userid'] . "'>" . $FullName . "</option>";
				}
			}
		break;

		case 'fncMSloadSelectFilterCategory':
			echo "<option value='' disabled>-- Select Category --</option>";
			$res = mysql_query("SELECT category_id, category FROM tblmaintenance_category ORDER BY category ASC;", $connection);
			while($row = mysql_fetch_array($res)){
				echo "<option value='". $row[0] ."'>". $row[1] ."</option>";
			}
		break;

		case 'fncMSLoadAddTask':
			$MgaTaskID = "";
			$arr = explode("|", $_POST['TaskIDs']);
			for ($i=0; $i <= count($arr)-2; $i++) { 
				$MgaTaskID .= "'" . $arr[$i] . "'" . ",";
			}
			if($_POST['TaskIDs'] == ''){
				$isTaskID = "";
			}else{
				$isTaskID = "AND a.taskid NOT IN (". substr(trim($MgaTaskID), 0, -1) .")";
			}
			if($_POST['Category'] == "" || $_POST['Category'] == "undefined" || $_POST['Category'] == 'null'){
				$isCategory = "";
			}else{
				$isCategory = "AND b.category_id = '". $_POST['Category'] ."'";
			}
			$res = mysql_query("SELECT b.category_id, a.taskid, b.category, a.description, a.amount FROM tblmaintenance_tasklist AS a LEFT JOIN tblmaintenance_category AS b ON a.xcategory = b.category_id WHERE (b.category LIKE '%". $_POST['key'] ."%' OR a.description LIKE '%". $_POST['key'] ."%') ". $isCategory ." ". $isTaskID ." ORDER BY b.category, a.description ASC;", $connection);
			while($row = mysql_fetch_array($res)){
				echo 	"<tr id='". $row['category_id'] ."-". $row['taskid'] ."'>
							<td class='TaskID hide'>". $row['taskid'] ."</td>
							<td class='TaskAmount2 hide'>". $row['amount'] ."</td>
							<td class='MaintenanceCategory'>". $row['category'] ."</td>
							<td class='TaskDescription'>". $row['description'] ."</td>
							<td class='TaskAmount' style='text-align: right;'>". number_format($row['amount'], 2, '.', ',') ."</td>
						</tr>";
			}
		break;

		case 'SaveSchedSetup':
			$SchedID = "";
			if($_POST['SchedID'] == ""){
				$SchedID = createidno("MMS", "tblref_MSMaintenance_h", "SchedID");
			}else{
				$Erase = mysql_query("DELETE FROM tblref_MSMaintenance_h WHERE SchedID = '". $_POST['SchedID'] ."'", $connection);
				$Erase2 = mysql_query("DELETE FROM tblref_MSMaintenance_d WHERE SchedID = '". $_POST['SchedID'] ."'", $connection);
				if($Erase == true && $Erase2 == true){
					$SchedID = $_POST['SchedID'];
				}
			}

			$TaskIDs = "";
			$arr = explode("|", $_POST['TaskIDs']);
			for ($i=0; $i <= count($arr)-2; $i++) { 
				$TaskIDs .= "'" . $arr[$i] . "'" . ",";
			}

				if($_POST['AllTenant'] == "Yes"){
					$isAllTenant = 1;
				}else{
					$isAllTenant = 0;
				}

				if($_POST['AllPersonnel'] == "Yes"){
					$isAllPersonnel = 1;
				}else{
					$isAllPersonnel = 0;
				}

			$forHeader = 0;
			$resTaskInfo = mysql_query("SELECT a.taskid, a.xcategory, a.amount FROM tblmaintenance_tasklist AS a LEFT JOIN tblmaintenance_category AS b ON a.xcategory = b.category_id WHERE a.taskid IN (". substr(trim($TaskIDs), 0, -1) .");", $connection);
			while($rowTaskInfo = mysql_fetch_array($resTaskInfo)){
				$resSchedDetails = mysql_query("INSERT INTO tblref_MSMaintenance_d SET SchedID = '". $SchedID ."', xCategory = '". $rowTaskInfo['xcategory'] ."', xTask = '". $rowTaskInfo['taskid'] ."'", $connection);
				if($resSchedDetails == true){
					$forHeader++;
				}
			}

			if($forHeader >= 1){

				$TenantIDList = "";
				$TenantCount = "";
				if($_POST['AllTenant'] == "Yes"){
					$resGetTenantIDs = mysql_query("SELECT TenantID FROM tbltrans_tenants WHERE (Status = 'Active' OR Status = 'ForEviction' OR Status = 'ForRenewal') AND ustatus = 'Occupied' AND mallID = '". $_SESSION['MMS-Designation'] ."';", $connection);
					$numGetTenantIDs = mysql_num_rows($resGetTenantIDs);
					if($numGetTenantIDs == 1){
						$rowGetTenantIDs = mysql_fetch_array($resGetTenantIDs);
						$TenantIDList = $rowGetTenantIDs['TenantID'];
						$TenantID = explode(",", $TenantIDList);
						$TenantCount = COUNT($TenantID);
					}else{
						while($rowGetTenantIDs = mysql_fetch_array($resGetTenantIDs)){
							$TenantIDList .= $rowGetTenantIDs['TenantID'] .",";
						}
						$TenantID = explode(",", $TenantIDList);
						$TenantCount = COUNT($TenantID)-2;
					}
				}else{
					$TenantIDList = $_POST['TenantID'];
					$TenantID = explode(",", $TenantIDList);
					$TenantCount = COUNT($TenantID)-1;
				}

				$PersonnelList = "";
				$TrimYesNo = 0;
				if($_POST['AllPersonnel'] == "Yes"){
					$resGetUserID = mysql_query("SELECT userid FROM tbluser WHERE isActive = '1' AND groupaccess = '". $_POST['GroupAccess'] ."';", $connection);
					$numGetUserID = mysql_num_rows($resGetUserID);
					if($numGetUserID == 1){
						$rowGetUserID = mysql_fetch_array($resGetUserID);
						$PersonnelList = $rowGetUserID['userid'];
						$TrimYesNo = 0;
					}else{
						while($rowGetUserID = mysql_fetch_array($resGetUserID)){
							$PersonnelList .= $rowGetUserID['userid'] .",";
							$TrimYesNo = 1;
						}
					}
				}else{
					$PersonnelList = $_POST['xPersonnel'];
				}

				if($TrimYesNo == 1){
					$PersonnelList = substr(trim($PersonnelList), 0, -1);
				}else{
					$PersonnelList = $PersonnelList;
				}

				$arr = explode(",", $TenantIDList);
				for ($i=0; $i <= $TenantCount; $i++) {
					$TenantInfo = mysql_fetch_array(mysql_query("SELECT TenantID, mallID FROM tbltrans_tenants WHERE TenantID = '". $arr[$i] ."';", $connection));
						if($_POST['xPeriod'] == "Weekly"){
							$QueryDate = ", xDOTW1 = '". $_POST['SchedWeek1'] ."', xDOTW2 = '". $_POST['SchedWeek2'] ."'";
						}else if($_POST['xPeriod'] == "Monthly"){
							$QueryDate = ", xDOTM1 = '". $_POST['SchedMonth1'] ."', xDOTM2 = '". $_POST['SchedMonth2'] ."'";
						}else if($_POST['xPeriod'] == "Quarterly"){
							$QueryDate = ", FQ_Date1 = '". date('Y-m-d', strtotime($_POST['SchedDate1'])) ."', FQ_Date2 = '". date('Y-m-d', strtotime($_POST['SchedDate2'])) ."', SQ_Date1 = '". date('Y-m-d', strtotime($_POST['SchedDate3'])) ."', SQ_Date2 = '". date('Y-m-d', strtotime($_POST['SchedDate4'])) ."', TQ_Date1 = '". date('Y-m-d', strtotime($_POST['SchedDate5'])) ."', TQ_Date2 = '". date('Y-m-d', strtotime($_POST['SchedDate6'])) ."', LQ_Date1 = '". date('Y-m-d', strtotime($_POST['SchedDate7'])) ."', LQ_Date2 = '". date('Y-m-d', strtotime($_POST['SchedDate8'])) ."'";
						}else if($_POST['xPeriod'] == "Biannually"){
							$QueryDate = ", FQ_Date1 = '". date('Y-m-d', strtotime($_POST['SchedDate1'])) ."', FQ_Date2 = '". date('Y-m-d', strtotime($_POST['SchedDate2'])) ."', SQ_Date1 = '". date('Y-m-d', strtotime($_POST['SchedDate3'])) ."', SQ_Date2 = '". date('Y-m-d', strtotime($_POST['SchedDate4'])) ."'";
						}else if($_POST['xPeriod'] == "Annually"){
							$QueryDate = ", FQ_Date1 = '". date('Y-m-d', strtotime($_POST['SchedDate1'])) ."', FQ_Date2 = '". date('Y-m-d', strtotime($_POST['SchedDate2'])) ."'";
						}else{
							$QueryDate = "";
						}
						$resInsertHeader = mysql_query("INSERT INTO tblref_MSMaintenance_h SET SchedID = '". $SchedID ."', TenantID = '". $TenantInfo['TenantID'] ."', mallID = '". $TenantInfo['mallID'] ."', GroupAccess = '". $_POST['GroupAccess'] ."', xPersonnel = '". $PersonnelList ."', xPeriod = '". $_POST['xPeriod'] ."', xDateAdded = '". date('Y-m-d', strtotime(getsysdate())) ."', xTimeAdded = '". date('H:i:s') ."', isAllTenant = '". $isAllTenant ."', isAllPersonnel = '". $isAllPersonnel ."' ". $QueryDate .";", $connection);
				}
			}
			if($forHeader >= 1){
				echo "1|Maintenance successfully saved.";
			}else{
				echo "2|Failed to save schedule.";
			}
		break;
	}
?>