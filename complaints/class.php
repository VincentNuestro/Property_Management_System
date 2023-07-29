<?php 
session_start();
include "../connect.php";
	switch ($_POST['form']) {
		case 'LoadtblComplaints':
			$getFilters = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'Complaints' AND userid = '". $_SESSION['MMS-UserID'] ."';", $connection));
			$Status = explode("|", $getFilters["bystat"]);
			$Status2 = explode("|", $getFilters["xcheck"]);
			$Search = explode("|", $getFilters["checked_value"]);
			$Date = explode("|", $getFilters["datefilter"]);

			// FILTER BY STATUS
			$StatusCount = 0; $SelectedStatus = "";
			for($a = 0; $a<=count($Status)-2; $a++){
				if($Status[$a] == "High"){ 
					$StatusVal = "Priority_Status = 'High'"; 
				}else if($Status[$a] == "Medium"){ 
					$StatusVal = "Priority_Status = 'Medium'"; 
				}else if($Status[$a] == "Low"){
					$StatusVal = "Priority_Status = 'Low'"; 
				}

				if($Status[$a] != ""){
					$StatusCount++;
					if($StatusCount == 1){
						$SelectedStatus .= $StatusVal;
					}else{
						$SelectedStatus .= " OR " . $StatusVal;
					}
				}
			}

			if($StatusCount > 1){
				$getAllStatus = "(". $SelectedStatus .")";
			}else{
				$getAllStatus = $SelectedStatus;
			}

			if($getAllStatus == ""){
				$StatFilter = "";
			}else{
				$StatFilter = "AND ". $getAllStatus;
			}

			 // FILTER BY STATUS2
			$StatusCount2 = 0; $SelectedStatus2 = "";
			for($a = 0; $a<=count($Status2)-2; $a++){
				if($Status2[$a] == "Resolved"){ 
					$StatusVal2 = "Complaint_Status = 'Resolved'";
				}else if($Status2[$a] == "Pending"){
					$StatusVal2 = "Complaint_Status = 'Pending'"; 
				}else if($Status2[$a] == "Ongoing"){
					$StatusVal2 = "Complaint_Status = 'Ongoing'"; 
				}

				if($Status2[$a] != ""){
					$StatusCount2++;
					if($StatusCount2 == 1){
						$SelectedStatus2 .= $StatusVal2;
					}else{
						$SelectedStatus2 .= " OR " . $StatusVal2;
					}
				}
			}

			if($StatusCount2 > 1){
				$getAllStatus2 = "(". $SelectedStatus2 .")";
			}else{
				$getAllStatus2 = $SelectedStatus2;
			}

			if($getAllStatus2 == ""){
				$StatFilter2 = "Complaint_Status = 'Pending'"; 
			}else{
				$StatFilter2 = $getAllStatus2;
			}

			// FILTER BY SEARCHED KEYWORD
			$SearchCount = 0; $SearchVal = "";
			for($c = 0; $c<=count($Search)-1; $c++){
				if($Search[$c] != ""){
					$SearchCount++;
					if($SearchCount == 1){
						$SearchVal .= $Search[$c] . " LIKE '%".$_POST["key"]."%'";
					}else{
						$SearchVal .= " OR ". $Search[$c] . " LIKE '%".$_POST["key"]."%'";
					}
				}
			}

			if($SearchCount > 0){
				if($SearchCount > 1){
					$SearchFilter = "AND (". $SearchVal .")";
				}else{
					$SearchFilter = "AND ". $SearchVal;
				}
			}else{
				if($SearchCount > 1){
					$SearchFilter = "(". $SearchVal .")";
				}else{
					$SearchFilter = $SearchVal;
				}
			}

			// FILTER BY DATE RANGE
			if($Date[0] != "" && $Date[1] != ""){
				$DateFilter = "AND (Date_Entry BETWEEN '". date("Y-m-d", strtotime($Date[0])) ."' AND '". date("Y-m-d", strtotime($Date[1])) ."')";
			}else{
				$DateFilter = "";
			}
		
			$page = $_POST['page'];
			$limit = ($page-1) * 20;
			$res = mysql_query("SELECT TenantID, TradeName, Complaint_Code, Complete_Description, Time_Received, Time_Resolved, Complaint_Status, Priority_Status, MallID, Complaint_Series_No FROM tblcomplaints WHERE ". $StatFilter2 ." ". $StatFilter ." ". $SearchFilter ." ". $DateFilter ." GROUP BY Complaint_Code ORDER BY ". $_POST['ComplaintsListSortBy'] ." ". $_POST['ComplaintsListSortType'] ." LIMIT ".$limit.",20;", $connection);

			while($row = mysql_fetch_array($res)){
				$assignperson = mysql_fetch_array(mysql_query("SELECT workername FROM tblmaintenance_workorder WHERE Complaint_Series_No = '". $row['Complaint_Series_No'] ."' ", $connection));
				if($row['Time_Received'] == "" || $row['Time_Received'] == "0000-00-00 00:00:00"){
					$TimeReceived = "";
				}else{
					$TimeReceived = date('m/d/Y h:i A', strtotime($row['Time_Received']));
				}

				if($row['Time_Resolved'] == "" || $row['Time_Resolved'] == "0000-00-00 00:00:00"){
					$TimeResolved = "";
				}else{
					$TimeResolved = date('m/d/Y h:i A', strtotime($row['Time_Resolved']));
				}

				if($row['Priority_Status'] == "High"){
					$PrioStat = "<span class='label label-lg label-danger arrowed-in-right arrowed' style='z-index: 0;'>High Priority</span>";
				}else if($row['Priority_Status'] == "Medium"){
					$PrioStat = "<span class='label label-lg label-warning arrowed-in-right arrowed' style='z-index: 0;'>Medium Priority</span>";
				}else if($row['Priority_Status'] == "Low"){
					$PrioStat = "<span class='label label-lg label-yellow arrowed-in-right arrowed' style='z-index: 0;'>Low Priority</span>";
				}

				echo "	<tr>
							<td>". $row['TenantID'] ."</td>
							<td>". $row['TradeName'] ."</td>
							<td>". $row['Complaint_Code'] ."</td>
							<td>". $row['Complete_Description'] ."</td>
							<td>". $TimeReceived ."</td>
							<td>". $TimeResolved ."</td>
							<td>". $assignperson[0] ."</td>
							<td>". $row['Complaint_Status'] ."</td>
							<td>". $PrioStat ."</td>
							<td class='isadmin hide select-printcomplaints center' style='z-index: 0;'><button class='btn btn-sm btn-default btn-round' onclick='printcomplaint(\"". $row['Complaint_Series_No'] ."\", \"". $row['MallID'] ."\");' style='margin: 2px;'><img src='assets/images/printer.png' style='width: 100%; height: auto;' title='Print Complaint'></button></td>
						</tr>";
			}
		break;

		case 'LoadComplaintsEntries':
			$getFilters = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'Complaints' AND userid = '". $_SESSION['MMS-UserID'] ."';", $connection));
			$Status = explode("|", $getFilters["bystat"]);
			$Status2 = explode("|", $getFilters["xcheck"]);
			$Search = explode("|", $getFilters["checked_value"]);
			$Date = explode("|", $getFilters["datefilter"]);

			// FILTER BY STATUS
			$StatusCount = 0; $SelectedStatus = "";
			for($a = 0; $a<=count($Status)-2; $a++){
				if($Status[$a] == "High"){ 
					$StatusVal = "Priority_Status = 'High'"; 
				}else if($Status[$a] == "Medium"){ 
					$StatusVal = "Priority_Status = 'Medium'"; 
				}else if($Status[$a] == "Low"){
					$StatusVal = "Priority_Status = 'Low'"; 
				}

				if($Status[$a] != ""){
					$StatusCount++;
					if($StatusCount == 1){
						$SelectedStatus .= $StatusVal;
					}else{
						$SelectedStatus .= " OR " . $StatusVal;
					}
				}
			}

			if($StatusCount > 1){
				$getAllStatus = "(". $SelectedStatus .")";
			}else{
				$getAllStatus = $SelectedStatus;
			}

			if($getAllStatus == ""){
				$StatFilter = "";
			}else{
				$StatFilter = "AND ". $getAllStatus;
			}

			 // FILTER BY STATUS2
			$StatusCount2 = 0; $SelectedStatus2 = "";
			for($a = 0; $a<=count($Status2)-2; $a++){
				if($Status2[$a] == "Resolved"){ 
					$StatusVal2 = "Complaint_Status = 'Resolved'";
				}else if($Status2[$a] == "Pending"){
					$StatusVal2 = "Complaint_Status = 'Pending'"; 
				}else if($Status2[$a] == "Ongoing"){
					$StatusVal2 = "Complaint_Status = 'Ongoing'"; 
				}

				if($Status2[$a] != ""){
					$StatusCount2++;
					if($StatusCount2 == 1){
						$SelectedStatus2 .= $StatusVal2;
					}else{
						$SelectedStatus2 .= " OR " . $StatusVal2;
					}
				}
			}

			if($StatusCount2 > 1){
				$getAllStatus2 = "(". $SelectedStatus2 .")";
			}else{
				$getAllStatus2 = $SelectedStatus2;
			}

			if($getAllStatus2 == ""){
				$StatFilter2 = "Complaint_Status = 'Pending'"; 
			}else{
				$StatFilter2 = $getAllStatus2;
			}

			// FILTER BY SEARCHED KEYWORD
			$SearchCount = 0; $SearchVal = "";
			for($c = 0; $c<=count($Search)-1; $c++){
				if($Search[$c] != ""){
					$SearchCount++;
					if($SearchCount == 1){
						$SearchVal .= $Search[$c] . " LIKE '%".$_POST["key"]."%'";
					}else{
						$SearchVal .= " OR ". $Search[$c] . " LIKE '%".$_POST["key"]."%'";
					}
				}
			}

			if($SearchCount > 0){
				if($SearchCount > 1){
					$SearchFilter = "AND (". $SearchVal .")";
				}else{
					$SearchFilter = "AND ". $SearchVal;
				}
			}else{
				if($SearchCount > 1){
					$SearchFilter = "(". $SearchVal .")";
				}else{
					$SearchFilter = $SearchVal;
				}
			}

			// FILTER BY DATE RANGE
			if($Date[0] != "" && $Date[1] != ""){
				$DateFilter = "AND (Date_Entry BETWEEN '". date("Y-m-d", strtotime($Date[0])) ."' AND '". date("Y-m-d", strtotime($Date[1])) ."')";
			}else{
				$DateFilter = "";
			}

			if($_POST["page"] == ""){
				$page = 1;
			}else{
				$page = $_POST["page"];
			}
			$limit = ($page-1) * 20;
			$rowCount = mysql_fetch_row(mysql_query("SELECT COUNT(id) FROM tblcomplaints WHERE ". $StatFilte2 ." ". $StatFilter ." ". $SearchFilter ." ". $DateFilter .";", $connection));
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

		case "LoadPageComplaints":
			$getFilters = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'Complaints' AND userid = '". $_SESSION['MMS-UserID'] ."';", $connection));
			$Status = explode("|", $getFilters["bystat"]);
			$Status2 = explode("|", $getFilters["xcheck"]);
			$Search = explode("|", $getFilters["checked_value"]);
			$Date = explode("|", $getFilters["datefilter"]);

			// FILTER BY STATUS
			$StatusCount = 0; $SelectedStatus = "";
			for($a = 0; $a<=count($Status)-2; $a++){
				if($Status[$a] == "High"){ 
					$StatusVal = "Priority_Status = 'High'"; 
				}else if($Status[$a] == "Medium"){ 
					$StatusVal = "Priority_Status = 'Medium'"; 
				}else if($Status[$a] == "Low"){
					$StatusVal = "Priority_Status = 'Low'"; 
				}

				if($Status[$a] != ""){
					$StatusCount++;
					if($StatusCount == 1){
						$SelectedStatus .= $StatusVal;
					}else{
						$SelectedStatus .= " OR " . $StatusVal;
					}
				}
			}

			if($StatusCount > 1){
				$getAllStatus = "(". $SelectedStatus .")";
			}else{
				$getAllStatus = $SelectedStatus;
			}

			if($getAllStatus == ""){
				$StatFilter = "";
			}else{
				$StatFilter = "AND ". $getAllStatus;
			}

			 // FILTER BY STATUS2
			$StatusCount2 = 0; $SelectedStatus2 = "";
			for($a = 0; $a<=count($Status2)-2; $a++){
				if($Status2[$a] == "Resolved"){ 
					$StatusVal2 = "Complaint_Status = 'Resolved'";
				}else if($Status2[$a] == "Pending"){
					$StatusVal2 = "Complaint_Status = 'Pending'"; 
				}else if($Status2[$a] == "Ongoing"){
					$StatusVal2 = "Complaint_Status = 'Ongoing'"; 
				}

				if($Status2[$a] != ""){
					$StatusCount2++;
					if($StatusCount2 == 1){
						$SelectedStatus2 .= $StatusVal2;
					}else{
						$SelectedStatus2 .= " OR " . $StatusVal2;
					}
				}
			}

			if($StatusCount2 > 1){
				$getAllStatus2 = "(". $SelectedStatus2 .")";
			}else{
				$getAllStatus2 = $SelectedStatus2;
			}

			if($getAllStatus2 == ""){
				$StatFilter2 = "Complaint_Status = 'Pending'"; 
			}else{
				$StatFilter2 = $getAllStatus2;
			}

			// FILTER BY SEARCHED KEYWORD
			$SearchCount = 0; $SearchVal = "";
			for($c = 0; $c<=count($Search)-1; $c++){
				if($Search[$c] != ""){
					$SearchCount++;
					if($SearchCount == 1){
						$SearchVal .= $Search[$c] . " LIKE '%".$_POST["key"]."%'";
					}else{
						$SearchVal .= " OR ". $Search[$c] . " LIKE '%".$_POST["key"]."%'";
					}
				}
			}

			if($SearchCount > 0){
				if($SearchCount > 1){
					$SearchFilter = "AND (". $SearchVal .")";
				}else{
					$SearchFilter = "AND ". $SearchVal;
				}
			}else{
				if($SearchCount > 1){
					$SearchFilter = "(". $SearchVal .")";
				}else{
					$SearchFilter = $SearchVal;
				}
			}

			// FILTER BY DATE RANGE
			if($Date[0] != "" && $Date[1] != ""){
				$DateFilter = "AND (Date_Entry BETWEEN '". date("Y-m-d", strtotime($Date[0])) ."' AND '". date("Y-m-d", strtotime($Date[1])) ."')";
			}else{
				$DateFilter = "";
			}

			$page = $_POST["page"];
			$rowCount = mysql_fetch_row(mysql_query("SELECT COUNT(id) FROM tblcomplaints WHERE ". $StatFilter2 ." ". $StatFilter ." ". $SearchFilter ." ". $DateFilter .";", $connection));
			$num = $nums[0];
			$rowsperpage = 20;
			$range = 3;
			$totalpages = ceil($rowCount[0] / $rowsperpage);
			$prevpage;
			$nextpage;
			if($page > 1 ){
				echo "<li style='width:50px !important;' onclick='pagination(1)'><< First</li>";
				$prevpage = $page - 1;
				echo "<li style='width:70px !important;' onclick='pagination(". $prevpage .")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if(($x > 0) && ($x <= $totalpages)){
					if ($x == $page){
						echo "<li id='pgcomplaints" . $x . "' class='pgnumpcomplaints active' onclick='pagination(" . $x . ",". $x .")'>" . $x . "</li>";
					}else{
						echo "<li id='pgcomplaints" . $x . "' class='pgnumpcomplaints' onclick='pagination(" . $x . ",". $x .")'>" . $x . "</li>";
					}
				}
			}
			if($page < ($totalpages - $range)){
				echo "<li>...</li>";
			}
			if($page != $totalpages && $rowCount[0] != 0){
				$nextpage = $page + 1;
				echo "<li style='width:50px !important;' onclick='pagination(". $nextpage .", ". $nextpage .")'>Next ></li>";
				echo "<li style='width:50px !important;' onclick='pagination(". $totalpages .", ". $totalpages .")'>Last >></li>";
			}
		break;

		case 'showTenantList':
			$title = mysql_fetch_array(mysql_query("SELECT softwaretype FROM tblsys_setup;", $connection));
			if($title[0] == "5"){
				$label =  "Buyer";
			}else{
				$label =  "Tenant";
			}
			echo "<option value=''>-- Select ". $label ." --</option>";
			$res = mysql_query("SELECT TenantID, tradename FROM tbltrans_tenants WHERE (Status = 'Active' OR Status = 'ForEviction' OR Status = 'ForRenewal') AND ustatus = 'Occupied'", $connection);
			while($row = mysql_fetch_array($res)){
				echo "<option value='". $row['TenantID'] ."'>". $row['tradename'] ."</option>";
			}
		break;

		case 'printcomplaints':
			$sql = "SELECT Complaint_Series_No, TenantID, xdate, Complaint_Code, Complete_Description, TradeName, Time_Received, Time_Resolved, Complaint_Status, Priority_Status, UserID, Date_Entry FROM tblcomplaints WHERE Date_Entry BETWEEN '".date("Y-m-d", strtotime($_POST['dateFrom']))."' AND '".date("Y-m-d", strtotime($_POST['dateTo']))."' AND MallID = '". $_POST['mallid'] ."' ORDER BY xdate desc";
			$res = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($res)){

				$workername = mysql_fetch_array(mysql_query("SELECT workername FROM tblmaintenance_workorder WHERE Complaint_Series_No = '". $row[0] ."'", $connection));

				$username = mysql_fetch_array(mysql_query("SELECT CONCAT(firstname, ' ', lastname) FROM tbluser WHERE userid = '". $row['UserID'] ."'", $connection));

				if($row['Time_Received'] == "" || $row['Time_Received'] == "0000-00-00 00:00:00"){
					$startdate = "";
				}else{
					$startdate = date('m/d/Y h:i A', strtotime($row['Time_Received']));
				}

				if($row['Time_Resolved'] == "" || $row['Time_Resolved'] == "0000-00-00 00:00:00"){
					$enddate = "";
				}else{
					$enddate = date('m/d/Y h:i A', strtotime($row['Time_Resolved']));
				}

			$tables .= "	
						<tr>
							<td>".$row['TenantID']."</td>
							<td>".$row['TradeName']."</td>
							<td>".date('m/d/Y', strtotime($row['Date_Entry']))."</td>
							<td>".$row['Complete_Description']."</td>
							<td>".$startdate."</td>
							<td>".$enddate."</td>
							<td>".$workername[0]."</td>
							<td>".$row['Complaint_Status']."</td>
							<td>".$username[0]."</td>
						</tr>
						";
			}

			echo $tables . "|" . date('F d, Y', strtotime($_POST['dateFrom'])) . "|" . date('F d, Y', strtotime($_POST['dateTo']));
		break;

		case 'printcomplaint':
			$printcomplaint = mysql_fetch_array(mysql_query("SELECT TradeName, MallID, FloorID, UnitID, Date_Entry, UserID, Complaint_Code, Complete_Description, TenantID FROM tblcomplaints WHERE Complaint_Series_No = '". $_POST['csn'] ."' ", $connection));
			$mallname = mysql_fetch_array(mysql_query("SELECT mallname FROM tblref_mall WHERE mallid = '". $printcomplaint[1] ."' ", $connection));
			$floorname = mysql_fetch_array(mysql_query("SELECT floor FROM tblref_floorsetup WHERE FloorID = '". $printcomplaint[2] ."' ", $connection));
			$unitname = mysql_fetch_array(mysql_query("SELECT unitname, buildingname FROM tblref_unit WHERE UnitID = '". $printcomplaint[3] ."' ", $connection));
			$username = mysql_fetch_array(mysql_query("SELECT workername FROM tblmaintenance_workorder WHERE Complaint_Series_No = '". $_POST['csn'] ."' ", $connection));
			$username2 = mysql_fetch_array(mysql_query("SELECT CONCAT(firstname, ' ', lastname) FROM tbluser WHERE userid = '". $printcomplaint['UserID'] ."'", $connection));
			echo $printcomplaint[0] . "|" . $mallname[0] . "|" . $unitname[1] . "|" . $floorname[0] . "|" . $unitname[0] . "|" . date('F d, Y', strtotime($printcomplaint[4])) . "|" . $username2[0] . "|" . $printcomplaint[6] . "|" . $printcomplaint[7] . "|" . $username[0] . "|" . $printcomplaint[8];
		break;

		case 'fncIRLoadViolators':
			$mgaMeron = "";
			$arr = explode("|", $_POST['ids']);
			for ($i=0; $i <= count($arr)-2; $i++) { 
				$mgaMeron .= "'" . $arr[$i] . "'" . ",";
			}
			if($_POST['ids'] != ""){
				$tanong = "AND TenantID NOT IN (". substr(trim($mgaMeron), 0, -1) .")";
			}else{
				$tanong = "";
			}
			$res = mysql_query("SELECT TenantID, tradename FROM tbltrans_tenants WHERE mallID = '". $_POST['mallID'] ."' AND (Status = 'Active' OR Status = 'ForEviction' OR Status = 'ForRenewal') AND (tradename LIKE '%". $_POST['key'] ."%' OR TenantID LIKE '%". $_POST['key'] ."%') AND ustatus = 'Occupied' ". $tanong ." GROUP BY tradename ORDER BY ". $_POST['TenantListSortBy'] ." ". $_POST['TenantListSortType'] .";", $connection);
			while($row = mysql_fetch_array($res)){
				echo    "<tr id='tr". $row['TenantID'] ."'>
							<td class='IRTenantID'>". $row['TenantID'] ."</td>
							<td class='IRTenantName'>". $row['tradename'] ."</td>
						</tr>";
			}
		break;

		case 'tblviolationlist':
			$mgaMeron = "";
			$arr = explode("|", $_POST['ids']);
			for ($i=0; $i <= count($arr)-2; $i++) { 
				$mgaMeron .= "'" . $arr[$i] . "'" . ",";
			}
			if($_POST['ids'] != ""){
				$tanong = "WHERE Code NOT IN (". substr(trim($mgaMeron), 0, -1) .")";
			}else{
				$tanong = "";
			}
			$res = mysql_query("SELECT Code, Violation, 1st_offense, 2nd_offense, 3rd_offense, xsucceeding FROM tblmaintenance_houserules ". $tanong .";", $connection);
			while ($row = mysql_fetch_array($res)) {
				?>
					<tr id="<?php echo "tr".$row[0]; ?>">
						<td width='10%' class="HRCode"><?php echo $row[0]; ?></td>
						<td width='40%' class="HRDesc"><?php echo $row[1]; ?></td>
						<td width='10%'><?php echo $row[2]; ?></td>
						<td width='10%'><?php echo $row[3]; ?></td>
						<td width='10%'><?php echo $row[4]; ?></td>
						<td width='10%'><?php echo $row[5]; ?></td>
					</tr>
				<?php
			}
		break;

		case 'saveviolationticket':
			$Success = 0;
			$TenantID = explode("|", $_POST['TenantID']);
			for ($a = 0; $a <= COUNT($TenantID)-2; $a++) { 
				$VSeriesNumber = createidno("VSN", "tblmaintenance_hrviolators", "VSeriesNumber");
				$TenantName = mysql_fetch_array(mysql_query("SELECT tradename, mallID FROM tbltrans_tenants WHERE TenantID = '". $TenantID[$a] ."';", $connection));
				$resInsertHeader = mysql_query("INSERT INTO tblmaintenance_hrviolatorsheader SET VSeriesNumber = '". $VSeriesNumber ."', ViolatorID = '". $TenantID[$a] ."', ViolatorName = '". $TenantName[0] ."', xdate = '". getsysdate() ."', xtime = '". date('H:i:s') ."', xtype = 'Tenant', mallid = '". $TenantName['mallID'] ."', addedBy = '". $_SESSION['MMS-UserID'] ."';", $connection);
				$ViolationCode = "";
				if($resInsertHeader == true){
					$arr2 = explode("@", $_POST['ViolationList']);
					for ($b=0; $b <= COUNT($arr2)-2; $b++) { 
						$arr3 = explode("|", $arr2[$b]);
						$CntOffense = mysql_fetch_array(mysql_query("SELECT COUNT(Code) FROM tblmaintenance_hrviolators WHERE Code = '". $arr3[0] ."' AND ViolatorID = '". $TenantID[$a] ."';", $connection));
						$Violation = mysql_fetch_array(mysql_query("SELECT Violation, 1st_offense, 2nd_offense, 3rd_offense, xsucceeding FROM tblmaintenance_houserules WHERE Code = '". $arr3[0] ."' ", $connection));
						if($CntOffense[0] == "0"){
							$OffenseCount = "1st Offense";
							$IRPunishment = $Violation['1st_offense'];
						}else if($CntOffense[0] == "1"){
							$OffenseCount = "2nd Offense";
							$IRPunishment = $Violation['2nd_offense'];
						}else if($CntOffense[0] == "2"){
							$OffenseCount = "3rd Offense";
							$IRPunishment = $Violation['3rd_offense'];
						}else{
							$OffenseCount = "Succeeding";
							$IRPunishment = $Violation['xsucceeding'];
						}

						if($OffenseCount == "1st Offense"){
							$setViolation = "1st_offense, 1stFine, 1stwithVat, 1stVat";
						}else if($OffenseCount == "2nd Offense"){
							$setViolation = "2nd_offense, 2ndFine, 2ndwithVat, 2ndVat";
						}else if($OffenseCount == "3rd Offense"){
							$setViolation = "3rd_offense, 3rdFine, 3rdwithVat, 3rdVat";
						}else{
							$setViolation = "xsucceeding, sucFine, sucwithVat, sucVat";
						}

						$getMC = " SELECT merchant_code FROM tbltrans_inquiry WHERE TenantID = '". $TenantID[$a] ."'; ";
						$resMC = mysql_query($getMC, $connection);
						$rowMC = mysql_fetch_array($resMC);

						$sqlHR = " SELECT Code, Violation, " . $setViolation . " FROM tblmaintenance_houserules WHERE code = '". $arr3[0] ."'; ";
						$resHR = mysql_query($sqlHR, $connection);
						$rowHR = mysql_fetch_array($resHR);

						$TenantInfo = mysql_fetch_array(mysql_query("SELECT a.mallID, b.isRent FROM tbltrans_tenants AS a INNER JOIN tbltrans_proposal AS b ON a.inqID = b.inquiryID AND a.ActiveProposal = b.proposalNum WHERE a.TenantID = '". $TenantID[$a] ."';", $connection));
						$getSetup = explode("|", getrentvattype($TenantName['mallID']));
						$isVatable = $getSetup[1];
						$isInclusive = $getSetup[2];
						$VATPercent = floatval($getSetup[0]) / 100;
						if($TenantInfo['isRent'] == 0){
							if($isVatable == "yes"){
								if($isInclusive == "inc"){ //VAT IS INCLUSIVE
									$VATAmount = ( floatval($rowHR[3]) / 1.12 ) * $VATPercent;
									$RentLessVAT = floatval($rowHR[3]) - $VATAmount;
									$Amount = $RentLessVAT;
									$VAT = $VATAmount;
									$TotalAmount = $VAT + $Amount;
								}else{ //VAT IS EXCLUSIVE
									$VATAmount = floatval($rowHR[3]) * $VATPercent;
									$RentPlusVAT = floatval($rowHR[3]);
									$Amount = floatval($rowHR[3]);
									$VAT = $VATAmount;
									$TotalAmount = floatval($rowHR[3]) + $VATAmount;
								}
							}else{
								$Amount = $rowHR[3];
								$VAT = "0.00";
								$TotalAmount = floatval($rowHR[3]);
							}
						}else{
							$Amount = $rowHR[3];
							$VAT = "0.00";
							$TotalAmount = floatval($rowHR[3]);
						}

						$resInsertDetails = mysql_query("INSERT INTO tblmaintenance_hrviolators SET VSeriesNumber = '". $VSeriesNumber ."', Code = '". $arr3[0] ."', Violation = '". $Violation[0] ."', Remarks = '". $arr3[1] ."', ViolatorID = '". $TenantID[$a] ."', ViolatorName = '". $TenantName[0] ."', offensetype = '". $OffenseCount ."', xtype = 'Tenant', xdate = '". getsysdate() ."', xtime = '". date('H:i:s') ."', xfine = '". $IRPunishment ."', fine = '". $Amount ."', xvat = '". $VAT ."', TotalAmount = '". $TotalAmount ."';", $connection);
						if($resInsertDetails == true){
							$Success++;
							$ViolationCode .=  "<br/>&emsp;&emsp;&emsp;&emsp;<span class='fa fa-angle-double-right blue'></span>&nbsp;". $arr3[0] . "<br/>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Description&nbsp;<span class='fa fa-angle-right blue'></span>&nbsp;". $Violation[0] ."<br/>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Remarks&nbsp;<span class='fa fa-angle-right blue'></span>&nbsp;". $arr3[1] ."<br/>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Resolution&nbsp;<span class='fa fa-angle-right blue'></span>&nbsp;<br/>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Violation Level&nbsp;<span class='fa fa-angle-right blue'></span>&nbsp;". $OffenseCount ."<br/>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Violation Status&nbsp;<span class='fa fa-angle-right blue'></span>&nbsp;Pending<br/>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Charge/Punishment&nbsp;<span class='fa fa-angle-right blue'></span>&nbsp;". $IRPunishment;
						}
					}
				}

				$arrHeader = ["Violation Series Number", "Tenant ID", "Tenant Name", "Date", "Time", "Violation"];
				$arrValue = [$VSeriesNumber, $TenantID[$a], $TenantName['tradename'], date('m/d/Y', strtotime(getsysdate())), date('H:i:s'), $ViolationCode];
				$tran_logs = create_logs_per_transaction("created an incident report.", "Incident Report", createXinfo("INSERT", $arrHeader, "", $arrValue, "", "", ""), "" ,"ADD", $VSeriesNumber);
				// INSERT LOGS JONAS
			}
			if($Success >= 1){
				echo 1;
			}else{
				echo 2;
			}
		break;

		// MODIFIED BY PETER ADDED CHECKING OF VIOLATIONS - NOV. 19, 2019
		case 'tblviolation':
			$getFilters = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'HouseRules' AND userid = '". $_SESSION['MMS-UserID'] ."';", $connection));
			$Status = explode("|", $getFilters["bystat"]);
			$Search = explode("|", $getFilters["checked_value"]);
			$UnitType = explode("|", $getFilters["xcheck"]);
			$Date = explode("|", $getFilters["datefilter"]);

			$StatusCount = 0; $SelectedStatus = "";
			for($a = 0; $a<=count($Status)-2; $a++){
				if($Status[$a] == "Resolved"){ 
					$StatusVal = "xstatus = 'Resolved'"; 
				}else if($Status[$a] == "Pending"){
					$StatusVal = "xstatus = 'Pending'"; 
				}

				if($Status[$a] != ""){
					$StatusCount++;
					if($StatusCount == 1){
						$SelectedStatus .= $StatusVal;
					}else{
						$SelectedStatus .= " OR " . $StatusVal;
					}
				}
			}

			if($StatusCount > 1){
				$getAllStatus = "(". $SelectedStatus .")";
			}else{
				$getAllStatus = $SelectedStatus;
			}

			if($getAllStatus == ""){
				$StatFilter = "xstatus = 'Pending'";
			}else{
				$StatFilter = $getAllStatus;
			}

			// FILTER BY SEARCHED KEYWORD
			$SearchCount = 0; $SearchVal = "";
			for($c = 0; $c<=count($Search)-1; $c++){
				if($Search[$c] != ""){
					$SearchCount++;
					if($SearchCount == 1){
						$SearchVal .= $Search[$c] . " LIKE '%".$_POST["key"]."%'";
					}else{
						$SearchVal .= " OR ". $Search[$c] . " LIKE '%".$_POST["key"]."%'";
					}
				}
			}

			if($SearchCount > 0){
				if($SearchCount > 1){
					$SearchFilter = "AND (". $SearchVal .")";
				}else{
					$SearchFilter = "AND ". $SearchVal;
				}
			}else{
				if($SearchCount > 1){
					$SearchFilter = "(". $SearchVal .")";
				}else{
					$SearchFilter = $SearchVal;
				}
			}
			
			// FILTER BY DATE RANGE
			if($Date[0] != "" && $Date[1] != ""){
				$DateFilter = "AND (xdate BETWEEN '". date("Y-m-d", strtotime($Date[0])) ."' AND '". date("Y-m-d", strtotime($Date[1])) ."')";
			}else{
				$DateFilter = "";
			}

			// ADDED SAVING OF USER WHO CREATED THE VIOLATION
			// FIELD - addedBy
			// NOV. 19, 2019 - PETER
			$res = mysql_query("SELECT VSeriesNumber, ViolatorID, ViolatorName, xstatus, xdate, xtime, xtype, isPosted, mallid, addedBy FROM tblmaintenance_hrviolatorsheader WHERE ". $StatFilter ." ". $SearchFilter ." ". $DateFilter ." ". getMallAccess("MallID", "AND") .";", $connection);
			while($row = mysql_fetch_array($res)){

				// CHECKING OF VIOLATIONS - PETER
				$sql = " SELECT COUNT(id) counter FROM tblmaintenance_hrviolators WHERE VSeriesNumber = '". $row[0] ."' AND xstatus = 'Pending'; ";
				$resz = mysql_query($sql, $connection);
				$rowz = mysql_fetch_array($resz);
				// END CHECKING OF VIOLATIONS

				// GET USER DETAILS
				if ( $row[9] == 'GatessoftCorp' ) {
					$uzerName = 'GatessoftCorp';
				} else {
					$sql2 = " SELECT CONCAT(firstname, ' ', lastname) userName FROM tbluser WHERE userid = '". $row[9] ."'; ";
					$resz2 = mysql_query($sql2, $connection);
					$rowz2 = mysql_fetch_array($resz2);

					$uzerName = $rowz2[0];
				}

				if($rowz[0] == 0){
					$stat2 = '<span class="label label-lg label-success arrowed-in-right arrowed" style="z-index: 0;"> Resolved</span>';
				}else{
					$stat2 = '<span class="label label-lg label-warning arrowed-in-right arrowed" style="z-index: 0;">Pending</span>';
				}
				echo    "<tr>
							<td>". $row['VSeriesNumber'] ."</td>
							<td>". $row['ViolatorName'] ."</td>
							<td>";
									// ADDED FIELD XSTATUS - PETER
									$res2 = mysql_query("SELECT Violation, offensetype, xstatus FROM tblmaintenance_hrviolators WHERE VSeriesNumber = '". $row['VSeriesNumber'] ."' ", $connection);
									while($row2 = mysql_fetch_array($res2)){

										// MODIFIED THE COLOR FOR THE STATUS OF EACH VIOLATION - NOV 19, 2019 - PETER
										// if ( $row2[2] == 'Pending' ) {
											if($row2['offensetype'] == "1st Offense"){
												$statColor = "#F89406";
											}else if($row2['offensetype'] == "2nd Offense"){
												$statColor = "#D6487E";
											}else if($row2['offensetype'] == "3rd Offense"){
												$statColor = "#D15B47";
											}else{
												$statColor = "#333;";
											}
										// } else {
										// 	$statColor = "#82AF6F";
										// }

										// if($row2['offensetype'] == "1st Offense"){
										// 	$stat = ;
										// }else if($row2['offensetype'] == "2nd Offense"){
										// 	$stat = '<i class="fa fa-circle" style="color: #D6487E;"></i>&nbsp;'.$row2['Violation'];
										// }else if($row2['offensetype'] == "3rd Offense"){
										// 	$stat = '<i class="fa fa-circle" style="color: #D15B47;"></i>&nbsp;'.$row2['Violation'];
										// }else{
										// 	$stat = '<i class="fa fa-circle" style="color: #333;"></i>&nbsp;'.$row2['Violation'];
										// }
										$forStat = '<i class="fa fa-circle" style="color: '. $statColor .';"></i>&nbsp;'.$row2[0] ."<br/>";

										echo $forStat;
									}
				echo		"</td>
							<td>". date('m/d/Y', strtotime($row['xdate'])) ."</td>
							<td>". date('h:i A', strtotime($row['xtime'])) ."</td>
							<td>". $stat2 ."</td>
							<td>".$uzerName ."</td>
							<td style='z-index: 0;width: 10%;'>
								<div class='btn-group'>
									<button class='btn btn-sm btn-info hide isadmin select-resolveir btn-round' title='View violation' onclick='viewticket(\"". $row['VSeriesNumber'] ."\", \"". $row['xstatus'] ."\", \"". $row['isPosted'] ."\")' style='margin: 2px;'><img src='assets/images/resume.png' style='width: 100%; height: auto;' /></button>";

								if($row['xstatus'] != "Resolved"){
									echo "<button class='btn btn-sm btn-danger hide isadmin select-deleteir btn-round' title='Delete Incident Report' onclick='deletethisticket(\"". $row['VSeriesNumber'] ."\");' style='margin: 2px;'><img src='assets/images/remove.png' style='width: 100%; height: auto;' /></button>";
								}
									echo "<button class='btn btn-sm btn-default hide isadmin select-printir btn-round' title='Print Incident Report' onclick='printnotificationofviolation(\"". $row['VSeriesNumber'] ."\", \"". $row['mallid'] ."\");' style='margin: 2px;'><img src='assets/images/printer.png' style='width: 100%; height: auto;'></button>
								</div>
							</td>
						</tr>";
			}
		break;

		case 'loadentriesofhr':
			$getFilters = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'HouseRules' AND userid = '". $_SESSION['MMS-UserID'] ."';", $connection));
			$Status = explode("|", $getFilters["bystat"]);
			$Search = explode("|", $getFilters["checked_value"]);
			$UnitType = explode("|", $getFilters["xcheck"]);
			$Date = explode("|", $getFilters["datefilter"]);

			$StatusCount = 0; $SelectedStatus = "";
			for($a = 0; $a<=count($Status)-2; $a++){
				if($Status[$a] == "Resolved"){ 
					$StatusVal = "xstatus = 'Resolved'"; 
				}else if($Status[$a] == "Pending"){
					$StatusVal = "xstatus = 'Pending'"; 
				}

				if($Status[$a] != ""){
					$StatusCount++;
					if($StatusCount == 1){
						$SelectedStatus .= $StatusVal;
					}else{
						$SelectedStatus .= " OR " . $StatusVal;
					}
				}
			}

			if($StatusCount > 1){
				$getAllStatus = "(". $SelectedStatus .")";
			}else{
				$getAllStatus = $SelectedStatus;
			}

			if($getAllStatus == ""){
				$StatFilter = "xstatus = 'Pending'";
			}else{
				$StatFilter = $getAllStatus;
			}

			// FILTER BY SEARCHED KEYWORD
			$SearchCount = 0; $SearchVal = "";
			for($c = 0; $c<=count($Search)-1; $c++){
				if($Search[$c] != ""){
					$SearchCount++;
					if($SearchCount == 1){
						$SearchVal .= $Search[$c] . " LIKE '%".$_POST["key"]."%'";
					}else{
						$SearchVal .= " OR ". $Search[$c] . " LIKE '%".$_POST["key"]."%'";
					}
				}
			}

			if($SearchCount > 0){
				if($SearchCount > 1){
					$SearchFilter = "AND (". $SearchVal .")";
				}else{
					$SearchFilter = "AND ". $SearchVal;
				}
			}else{
				if($SearchCount > 1){
					$SearchFilter = "(". $SearchVal .")";
				}else{
					$SearchFilter = $SearchVal;
				}
			}
			
			// FILTER BY DATE RANGE
			if($Date[0] != "" && $Date[1] != ""){
				$DateFilter = "AND (xdate BETWEEN '". date("Y-m-d", strtotime($Date[0])) ."' AND '". date("Y-m-d", strtotime($Date[1])) ."')";
			}else{
				$DateFilter = "";
			}

			if($_POST["page"] == ""){
				$page = 1;
			}else{
				$page = $_POST["page"];
			}
			$limit = ($page-1) * 20;
			$rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM tblmaintenance_hrviolatorsheader WHERE ". $StatFilter ." ". $SearchFilter ." ". $DateFilter ." ". getMallAccess("MallID", "AND") .";", $connection));
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

		case 'loadpagehr':
			$getFilters = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'HouseRules' AND userid = '". $_SESSION['MMS-UserID'] ."';", $connection));
			$Status = explode("|", $getFilters["bystat"]);
			$Search = explode("|", $getFilters["checked_value"]);
			$UnitType = explode("|", $getFilters["xcheck"]);
			$Date = explode("|", $getFilters["datefilter"]);

			$StatusCount = 0; $SelectedStatus = "";
			for($a = 0; $a<=count($Status)-2; $a++){
				if($Status[$a] == "Resolved"){ 
					$StatusVal = "xstatus = 'Resolved'"; 
				}else if($Status[$a] == "Pending"){
					$StatusVal = "xstatus = 'Pending'"; 
				}

				if($Status[$a] != ""){
					$StatusCount++;
					if($StatusCount == 1){
						$SelectedStatus .= $StatusVal;
					}else{
						$SelectedStatus .= " OR " . $StatusVal;
					}
				}
			}

			if($StatusCount > 1){
				$getAllStatus = "(". $SelectedStatus .")";
			}else{
				$getAllStatus = $SelectedStatus;
			}

			if($getAllStatus == ""){
				$StatFilter = "xstatus = 'Pending'";
			}else{
				$StatFilter = $getAllStatus;
			}

			// FILTER BY SEARCHED KEYWORD
			$SearchCount = 0; $SearchVal = "";
			for($c = 0; $c<=count($Search)-1; $c++){
				if($Search[$c] != ""){
					$SearchCount++;
					if($SearchCount == 1){
						$SearchVal .= $Search[$c] . " LIKE '%".$_POST["key"]."%'";
					}else{
						$SearchVal .= " OR ". $Search[$c] . " LIKE '%".$_POST["key"]."%'";
					}
				}
			}

			if($SearchCount > 0){
				if($SearchCount > 1){
					$SearchFilter = "AND (". $SearchVal .")";
				}else{
					$SearchFilter = "AND ". $SearchVal;
				}
			}else{
				if($SearchCount > 1){
					$SearchFilter = "(". $SearchVal .")";
				}else{
					$SearchFilter = $SearchVal;
				}
			}
			
			// FILTER BY DATE RANGE
			if($Date[0] != "" && $Date[1] != ""){
				$DateFilter = "AND (xdate BETWEEN '". date("Y-m-d", strtotime($Date[0])) ."' AND '". date("Y-m-d", strtotime($Date[1])) ."')";
			}else{
				$DateFilter = "";
			}

			$page = $_POST["page"];
			$rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM tblmaintenance_hrviolatorsheader WHERE ". $StatFilter ." ". $SearchFilter ." ". $DateFilter ." ". getMallAccess("MallID", "AND") .";", $connection));
			$rowsperpage = 20;
			$range = 3;
			$totalpages = ceil($rowCount[0] / $rowsperpage);
			$prevpage;
			$nextpage;
			if($page > 1 ){
				echo "<li style='width:50px !important;' onclick='pagination(1)'><< First</li>";
				$prevpage = $page - 1;
				echo "<li style='width:70px !important;' onclick='pagination(". $prevpage .")'>< Previous</li>";
			}

			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if(($x > 0) && ($x <= $totalpages)){
					if($x == $page){
						echo "<li id='pgcomplaints" . $x . "' class='pgnumpcomplaints active' onclick='pagination(" . $x . ",". $x .")'>" . $x . "</li>";
					}else{
						echo "<li id='pgcomplaints" . $x . "' class='pgnumpcomplaints' onclick='pagination(" . $x . ",". $x .")'>" . $x . "</li>";
					}
				}
			}
			if($page < ($totalpages - $range)){
				echo "<li>...</li>";
			}

			if($page != $totalpages && $rowCount[0] != 0){
				$nextpage = $page + 1;
				echo "<li style='width:50px !important;' onclick='pagination(". $nextpage .", ". $nextpage .")'>Next ></li>";
				echo "<li style='width:50px !important;' onclick='pagination(". $totalpages .", ". $totalpages .")'>Last >></li>";
			}
		break;

		case 'printcomplaintshr': 
			$res = mysql_query("SELECT VSeriesNumber, ViolatorName, xdate, xtime, xstatus FROM tblmaintenance_hrviolatorsheader WHERE xdate BETWEEN '".date("Y-m-d", strtotime($_POST['dateFrom']))."' AND '".date("Y-m-d", strtotime($_POST['dateTo']))."' AND mallid = '". $_POST['mallid'] ."' ", $connection);
			while($row = mysql_fetch_array($res)){
				?>
				<tr>
					<td style="vertical-align: top;"><?php echo $row[0]; ?></td>
					<td style="vertical-align: top;"><?php echo $row[1]; ?></td>
					<td>
						<?php 
							$res2 = mysql_query("SELECT Violation, offensetype FROM tblmaintenance_hrviolators WHERE VSeriesNumber = '". $row[0] ."' ", $connection);
							while($row2 = mysql_fetch_array($res2)){
								if($row2[1] == "1st Offense"){
									$stat = '<span class="fa fa-circle" style="color: #F89406;"></span>&nbsp;'.$row2[0];
								}else if($row2[1] == "2nd Offense"){
									$stat = '<span class="fa fa-circle" style="color: #D6487E;"></span>&nbsp;'.$row2[0];
								}else if($row2[1] == "3rd Offense"){
									$stat = '<span class="fa fa-circle" style="color: #D15B47;"></span>&nbsp;'.$row2[0];
								}else{
									$stat = '<span class="fa fa-circle" style="color: black;"></span>&nbsp;'.$row2[0];
								}
								echo $stat."<br/>";
							}
						?>
					</td>
					<td><?php echo date('m/d/Y', strtotime($row[2])); ?></td>
					<td width="8%"><?php echo date('h:i A', strtotime($row[3])); ?></td>
					<td><?php echo $row[4]; ?></td>
				</tr>
				<?php
			}
			echo "|". date('F d, Y', strtotime($_POST['dateFrom'])) . "|" . date('F d, Y', strtotime($_POST['dateTo']));
		break;

		case 'deletethisticket':
			//INSERT LOGS START
			$IRHeader = mysql_fetch_array(mysql_query("SELECT ViolatorID, ViolatorName, xdate, xtime FROM tblmaintenance_hrviolatorsheader WHERE VSeriesNumber = '". $_POST['vsn'] ."';", $connection));
			$resIRDetails = mysql_query("SELECT Code, Violation, Remarks, Resolution, offensetype, xstatus, xfine, xdatetimeresolved FROM tblmaintenance_hrviolators WHERE VSeriesNumber = '". $_POST['vsn'] ."';", $connection);
			while($rowIRDetails = mysql_fetch_array($resIRDetails)){
				$ViolationCode .= "<br/>&emsp;&emsp;&emsp;&emsp;<span class='fa fa-angle-double-right blue'></span>&nbsp;". $rowIRDetails[0] ."<br/>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Description&nbsp;<span class='fa fa-angle-right blue'></span>&nbsp;". $rowIRDetails[1] ."<br/>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Remarks&nbsp;<span class='fa fa-angle-right blue'></span>&nbsp;". $rowIRDetails[2] ."<br/>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Resolution&nbsp;<span class='fa fa-angle-right blue'></span>&nbsp;". $rowIRDetails[3] ."<br/>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Violation Level&nbsp;<span class='fa fa-angle-right blue'></span>&nbsp;". $rowIRDetails[4] ."<br/>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Violation Status&nbsp;<span class='fa fa-angle-right blue'></span>&nbsp;". $rowIRDetails[5] ."<br/>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Charge/Punishment&nbsp;<span class='fa fa-angle-right blue'></span>&nbsp;". $rowIRDetails[6];
			}
			$arrHeader = ["Violation Series Number", "Tenant ID", "Tenant Name", "Date", "Time", "Violation"];
			$arrValue = [$_POST['vsn'], $IRHeader['ViolatorID'], $IRHeader['ViolatorName'], date('m/d/Y', strtotime($IRHeader['xdate'])), date('H:i:s', strtotime($IRHeader['xtime'])), $ViolationCode];
			$tran_logs = create_logs_per_transaction("deleted an incident report.", "Incident Report", createXinfo("INSERT", $arrHeader, "", $arrValue, "", "", ""), "" ,"ADD", $arr[1]);
			//INSERT LOGS END
			$res = mysql_query("DELETE FROM tblmaintenance_hrviolatorsheader WHERE VSeriesNumber = '". $_POST['vsn'] ."';", $connection);
			if($res == true){
				$res2 = mysql_query("DELETE FROM tblmaintenance_hrviolators WHERE VSeriesNumber = '". $_POST['vsn'] ."';", $connection);
				if($res2 == true){
					echo 1;
				}else{
					echo 2;
				}
			}
		break;
// ruth
		case 'fncloadViolationList':
			$TotalAmount = 0;
			$bayad2 = "";
			$res = mysql_query("SELECT Code, Violation, offensetype, resolution, xstatus, xfine, Remarks, xdatetimeresolved, violatorID, totalAmount, VSeriesNumber FROM tblmaintenance_hrviolators WHERE VSeriesNumber = '". $_POST['vsn'] ."' GROUP BY VSeriesNumber ORDER BY ". $_POST['ViolationsSortBy'] ." ". $_POST['ViolationsSortType'] .";", $connection);

			while($row = mysql_fetch_array($res)){
				$fine = mysql_fetch_array(mysql_query("SELECT 1st_offense, 1stFine, 1stVat, 2nd_offense, 2ndFine, 2ndVat, 3rd_offense, 3rdFine, 3rdVat, xsucceeding, sucFine, sucVat FROM tblmaintenance_houserules WHERE Code = '". $row[0] ."' GROUP BY VSeriesNumber ORDER BY ". $_POST['ViolationsSortBy'] ." ". $_POST['ViolationsSortType'] .";", $connection));

				if($row['xfine'] != ""){
					if($row['offensetype'] == "1st Offense"){
						$bayad = $fine[0];
						$bayad2 = $fine[1];
					}else if($row['offensetype'] == "2nd Offense"){
						$bayad = $fine[3];
						$bayad2 = $fine[4];
					}else if($row['offensetype'] == "3rd Offense"){
						$bayad = $fine[6];
						$bayad2 = $fine[7];
					}else{
						$bayad = $fine[9];
						$bayad2 = $fine[10];
					}
				}else{
					$bayad = $row['xfine'];
				}

				$bayad2 = $bayad2;

				if($row['xstatus'] == "Resolved"){
					$Status = "<span class='label label-lg label-success arrowed-in-right arrowed' style='z-index: 0;' title='". date('F d, Y h:i A', strtotime($row['xdatetimeresolved'])) ."'>". $row['xstatus'] ."</span>";
					$isDisabled = "disabled";
					$delBtn = "";
				}else{
					$Status = "<span class='label label-lg label-warning arrowed-in-right arrowed' style='z-index: 0;'>". $row['xstatus'] ."</span>";
					$isDisabled = "";
					$delBtn = "<button class='btn btn-xs btn-danger hide isadmin select-deleteir btn-round' title='Delete Incident Report' onclick='deleteViolationz(\"". $row[10] ."\", \"". $row[0] ."\");' style='margin: 2px;'><img src='assets/images/remove.png' style='width: 100%; height: auto;' /></button>";;
				}

				echo	"<tr>
							<td>". $row[1] ."</td>
							<td>". $row[2] ."</td>
							<td>". $bayad ."</td>
							<td align='right'>". number_format($row[9], 2) ."</td>
							<td>". $Status ."</td>
							
							<td class='batayan'>";
								$resRemarks = mysql_query("SELECT RemarksCode, Remarks, xdatetime FROM tblmaintenance_hrviolatorremarks WHERE VSeriesNumber = '". $_POST['vsn'] ."' AND Code = '". $row['Code'] ."';", $connection);
								while ($rowRemarks = mysql_fetch_array($resRemarks)) {
									echo "<label style='cursor: pointer' onclick='fncAddRemarks(\"". $row['Code'] ."\", \"". $_POST['vsn'] ."\", \"". $row['xstatus'] ."\", \"". $rowRemarks['Remarks'] ."\", \"". $rowRemarks['RemarksCode'] ."\");'><span class='fa fa-angle-double-right blue'></span>&nbsp;". date('m/d/Y h:i A', strtotime($rowRemarks['xdatetime'])) ."</label><br>";
								}
								if($row['xstatus'] == "Pending"){
									echo "<a class='ilalabas' onclick='fncAddRemarks(\"". $row['Code'] ."\", \"". $_POST['vsn'] ."\", \"". $row['xstatus'] ."\", \"\", \"\");' title='Add remarks'>Add Remarks</a>";
								}
				echo        "</td>
							<td class='batayan'>";
								$resResponse = mysql_query("SELECT ResponseCode, Resolution, xdatetime FROM tblmaintenance_hrviolatorsresponse WHERE VSeriesNumber = '". $_POST['vsn'] ."' AND Code = '". $row['Code'] ."';", $connection);
								while ($rowResponse = mysql_fetch_array($resResponse)) {
									echo "<label style='cursor: pointer' onclick='fncAddResponse(\"". $row['Code'] ."\", \"". $_POST['vsn'] ."\", \"". $row['xstatus'] ."\", \"". $rowResponse['Resolution'] ."\", \"". $rowResponse['ResponseCode'] ."\");'><span class='fa fa-angle-double-right blue'></span>&nbsp;". date('m/d/Y h:i A', strtotime($rowResponse['xdatetime'])) ."</label><br>";
								}
								if($row['xstatus'] == "Pending"){
									echo "<a class='ilalabas' onclick='fncAddResponse(\"". $row['Code'] ."\", \"". $_POST['vsn'] ."\", \"". $row['xstatus'] ."\", \"". $row['resolution'] ."\", \"". $rowResponse['ResponseCode'] ."\");' title='Add remarks'>Add Response</a>";
								}
				echo        "</td>
							<td><button class='btn btn-xs btn-info btn-round' title='Update Status' onclick='fncModifyViolation(\"". $_POST['vsn'] ."\", \"". $row['Code'] ."\", \"". $row['xstatus'] ."\", \"". number_format($row[9],2) ."\")' style='margin: 2px;' ". $isDisabled ."><img src='assets/images/resume.png' style='width: 100%; height: auto;' /></button>". $delBtn ."</td>
						</tr>";
				$TotalAmount += $row[9];
			}
			$IRHeader = mysql_fetch_array(mysql_query("SELECT ViolatorID, ViolatorName, xdate, xtime FROM tblmaintenance_hrviolatorsheader WHERE VSeriesNumber = '". $_POST['vsn'] ."';", $connection));
			$TenantInfo = mysql_fetch_array(mysql_query("SELECT unitname FROM tbltrans_tenants WHERE TenantID = '". $IRHeader['ViolatorID'] ."';", $connection));
			echo "|" . "Total Amount: ". number_format($TotalAmount, 2, '.', ',') . "|" . $IRHeader['ViolatorName'] . "|" . $TenantInfo['unitname'] . "|" . date('m/d/Y', strtotime($IRHeader['xdate'])) . "|" . date('h:i A', strtotime($IRHeader['xtime']));
		break;

		case 'fncPrintIncidentReport':
			$bayad2 = "";
			$res = mysql_query("SELECT Code, Violation, offensetype FROM tblmaintenance_hrviolators WHERE VSeriesNumber = '". $_POST['vsn'] ."' ", $connection);
			while($row = mysql_fetch_array($res)){
				$fine = mysql_fetch_array(mysql_query("SELECT 1st_offense, 2nd_offense, 3rd_offense, xsucceeding FROM tblmaintenance_houserules WHERE Code = '". $row[0] ."' ", $connection));

				if($row[2] == "1st Offense"){
					$bayad = $fine[0];
				}else if($row[2] == "2nd Offense"){
					$bayad = $fine[1];
				}else if($row[2] == "3rd Offense"){
					$bayad = $fine[2];
				}else{
					$bayad = $fine[3];
				}
				$bayad2 = $bayad2+$bayad;
				echo	"<tr>
							<td style='border: 1px solid;'>". $row[1] ."</td>
							<td style='border: 1px solid;'>". $row[2] ."</td>
							<td style='border: 1px solid;'>". $bayad ."</td>
						</tr>";
			}
				echo    "<tr>
							<td style='border: 1px solid;' colspan='2' align='right'>Total Amount: </td>
							<td style='border: 1px solid;'><label style='color: red;'>Php " .number_format($bayad2, 2, '.', ',') ."</label></td>
						</tr>";
			echo "|";
		break;

		case 'checkmunabagopost':
			$res = mysql_query("SELECT xstatus FROM tblmaintenance_hrviolators WHERE VSeriesNumber = '". $_POST['vsn'] ."' ORDER BY xstatus ASC LIMIT 1", $connection);
			$row = mysql_fetch_array($res);
			echo $row[0];
		break;

		case 'postmonabes':
			$count = 0;
			$res = mysql_query("SELECT Code, Violation, Remarks, Resolution, offensetype, xstatus, xfine, xdatetimeresolved FROM tblmaintenance_hrviolators WHERE VSeriesNumber = '". $_POST['vsn'] ."';", $connection);
			while($row = mysql_fetch_array($res)){
				if(is_numeric($row[3])){
					$res2 = mysql_query("INSERT INTO tbltransaction SET tenantid = '". $row['ViolatorID'] ."', xcode = '". $row['Code'] ."', description = '". $row['Violation'] ."', xdescription = 'Violation', amount = '". floatval($row['xfine']) ."', qty = '1', balance = '". floatval($row['xfine']) ."', xdate = '". $row['xdate'] ."', totalamount = '". floatval($row['xfine']) ."', userid = '". $_SESSION['MMS-UserID'] ."';", $connection);
				}
				$res3 = mysql_query("UPDATE tblmaintenance_hrviolatorsheader SET isPosted = '1' WHERE VSeriesNumber = '". $_POST['vsn'] ."';", $connection);
				$count++;
				$ViolationCode .= "<br/>&emsp;&emsp;&emsp;&emsp;<span class='fa fa-angle-double-right blue'></span>&nbsp;". $row[0] ."<br/>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Description&nbsp;<span class='fa fa-angle-right blue'></span>&nbsp;". $row[1] ."<br/>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Remarks&nbsp;<span class='fa fa-angle-right blue'></span>&nbsp;". $row[2] ."<br/>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Resolution&nbsp;<span class='fa fa-angle-right blue'></span>&nbsp;". $row[3] ."<br/>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Violation Level&nbsp;<span class='fa fa-angle-right blue'></span>&nbsp;". $row[4] ."<br/>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Violation Status&nbsp;<span class='fa fa-angle-right blue'></span>&nbsp;". $row[5] ."<br/>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Charge/Punishment&nbsp;<span class='fa fa-angle-right blue'></span>&nbsp;". $row[6];
				
			}
			if($count >= 1){
				//INSERT LOGS START
				$IRHeader = mysql_fetch_array(mysql_query("SELECT ViolatorID, ViolatorName, xdate, xtime FROM tblmaintenance_hrviolatorsheader WHERE VSeriesNumber = '". $_POST['vsn'] ."';", $connection));
				$arrHeader = ["Violation Series Number", "Tenant ID", "Tenant Name", "Date", "Time", "Violation"];
				$arrValue = [$_POST['vsn'], $IRHeader['ViolatorID'], $IRHeader['ViolatorName'], date('m/d/Y', strtotime($IRHeader['xdate'])), date('H:i:s', strtotime($IRHeader['xtime'])), $ViolationCode];
				$tran_logs = create_logs_per_transaction("posted an incident report to billing.", "Incident Report", createXinfo("INSERT", $arrHeader, "", $arrValue, "", "", ""), "" ,"ADD", $arr[1]);
				//INSERT LOGS END
				echo 1;
			}else{
				echo 2;
			}
		break;

		case 'fncRemarksAttachment':
			$count = 0;
			$res = mysql_query("SELECT FileName, FileType2, FileType, VSeriesNumber, Code, xdatetime FROM tblmaintenance_hrviolatorremarks_attachment WHERE RemarksCode = '". $_POST['RemarksCode'] ."';", $connection);
			while ($row = mysql_fetch_array($res)) {
				if(explode("/", $row['FileType'])[0] == "image"){
					$btn = "<a class='btn btn-xs btn-info btn-round' onclick='viewdocuimgindex(\"../Mall_Attachments/Incident Reports/". $row['VSeriesNumber'] ."/". $row['Code'] ."/". $_POST['RemarksCode'] ."/". $row['FileName'] ." ". date('m.d.Y H.i.s', strtotime($row['xdatetime'])) .".". $row['FileType2'] ."\");' title='View Image'><i class='fa fa-picture-o'></i></a>";
				}else{
					$btn = "<a href='../Mall_Attachments/Incident Reports/". $row['VSeriesNumber'] ."/". $row['Code'] ."/". $_POST['RemarksCode'] ."/". $row['FileName'] ." ". date('m.d.Y H.i.s', strtotime($row['xdatetime'])) .".". $row['FileType2'] ."' download='". $row['FileName'] .".". $row['FileType2'] ."' class='btn btn-xs btn-purple btn-round' title='Download Attachment'><i class='fa fa-download'></i></a>";
				}

				if($count == 0){
					echo    "<div class='col-md-4' style='margin-top: 10px;'>
								Attachment
							</div>
							<div class='col-md-7' style='margin-top: 10px;'>
								". $row['FileName'] .".". $row['FileType2'] ."
							</div>
							<div class='col-md-1' style='margin-top: 10px;'>
								". $btn ."
							</div>";
				}else{
					echo    "<div class='col-md-4' style='margin-top: 10px;'></div>
							<div class='col-md-7' style='margin-top: 10px;'>
								". $row['FileName'] .".". $row['FileType2'] ."
							</div>
							<div class='col-md-1' style='margin-top: 10px;'>
								". $btn ."
							</div>";
				}
				$count++;
			}
		break;

		case 'fncRespoAttachment':
			$count = 0;
			$res = mysql_query("SELECT FileName, FileType2, FileType, VSeriesNumber, Code, xdatetime FROM tblmaintenance_hrviolatorsresponse_attachment WHERE ResponseCode = '". $_POST['ResponseCode'] ."';", $connection);
			while ($row = mysql_fetch_array($res)) {
				if(explode("/", $row['FileType'])[0] == "image"){
					$btn = "<a class='btn btn-xs btn-info btn-round' onclick='viewdocuimgindex(\"../Mall_Attachments/Incident Reports/". $row['VSeriesNumber'] ."/". $row['Code'] ."/". $_POST['ResponseCode'] ."/". $row['FileName'] ." ". date('m.d.Y H.i.s', strtotime($row['xdatetime'])) .".". $row['FileType2'] ."\");' title='View Image'><i class='fa fa-picture-o'></i></a>";
				}else{
					$btn = "<a href='../Mall_Attachments/Incident Reports/". $row['VSeriesNumber'] ."/". $row['Code'] ."/". $_POST['ResponseCode'] ."/". $row['FileName'] ." ". date('m.d.Y H.i.s', strtotime($row['xdatetime'])) .".". $row['FileType2'] ."' download='". $row['FileName'] .".". $row['FileType2'] ."' class='btn btn-xs btn-purple btn-round' title='Download Attachment'><i class='fa fa-download'></i></a>";
				}

				if($count == 0){
					echo    "<div class='col-md-4' style='margin-top: 10px;'>
								Attachment
							</div>
							<div class='col-md-7' style='margin-top: 10px;'>
								". $row['FileName'] .".". $row['FileType2'] ."
							</div>
							<div class='col-md-1' style='margin-top: 10px;'>
								". $btn ."
							</div>";
				}else{
					echo    "<div class='col-md-4' style='margin-top: 10px;'></div>
							<div class='col-md-7' style='margin-top: 10px;'>
								". $row['FileName'] .".". $row['FileType2'] ."
							</div>
							<div class='col-md-1' style='margin-top: 10px;'>
								". $btn ."
							</div>";
				}
				$count++;
			}
		break;

		// MODIFIED BY PETER 2019-11-01
		case 'fncSaveModifiedViolation':
			// GET THE VIOLATION DETAILS
			// ADDED BY PETER 2019-11-01
			$violationInfo = " SELECT violation, ViolatorID, offensetype, fine, xvat, totalAmount FROM tblmaintenance_hrviolators WHERE VSeriesNumber = '". $_POST['VSN'] ."'; ";
			$resViolator = mysql_query($violationInfo, $connection);
			$rowViolator = mysql_fetch_array($resViolator);

			$setViolation = "";

			// LEVEL OF VIOLATION
			if($rowViolator[2] == "1st Offense"){
				$setViolation = "1st_offense, 1stFine, 1stwithVat, 1stVat";
			}else if($rowViolator[2] == "2nd Offense"){
				$setViolation = "2nd_offense, 2ndFine, 2ndwithVat, 2ndVat";
			}else if($rowViolator[2] == "3rd Offense"){
				$setViolation = "3rd_offense, 3rdFine, 3rdwithVat, 3rdVat";
			}else{
				$setViolation = "xsucceeding, sucFine, sucwithVat, sucVat";
			}

			$VATAmount = 0;
			$RentLessVAT = 0;
			$Amount = 0;
			$VAT = 0;
			$TotalAmount = 0;

			$getMC = " SELECT merchant_code FROM tbltrans_inquiry WHERE TenantID = '". $rowViolator[1] ."'; ";
			$resMC = mysql_query($getMC, $connection);
			$rowMC = mysql_fetch_array($resMC);

			$sqlHR = " SELECT Code, Violation, " . $setViolation . " FROM tblmaintenance_houserules WHERE code = '". $_POST['HRCode'] ."'; ";
			$resHR = mysql_query($sqlHR, $connection);
			$rowHR = mysql_fetch_array($resHR);

			if($_POST['Status'] == "Resolved"){
				$isResolved = ", xstatus = 'Resolved', xdateresolved = '". getsysdate() ."', xtimeresolved = '". date('H:i:s') ."', xdatetimeresolved = '". date('Y-m-d H:i:s', strtotime(getsysdate() ." ". date('H:i:s'))) ."'";
			}else{
				$isResolved = "";
			}
			$res = mysql_query("UPDATE tblmaintenance_hrviolators SET xfine = '". $_POST['xFine'] ."' ". $isResolved ." WHERE VSeriesNumber = '". $_POST['VSN'] ."' AND Code = '". $_POST['HRCode'] ."';", $connection);
			if($res = true){
				echo 1;
				$checkViolations = mysql_fetch_array(mysql_query("SELECT xstatus FROM tblmaintenance_hrviolators WHERE VSeriesNumber = '". $_POST['VSN'] ."' AND Code = '". $_POST['HRCode'] ."' ORDER BY xstatus ASC LIMIT 1;", $connection));
				if($checkViolations[0] == 'Resolved'){
					$resUpdateHeader = mysql_query("UPDATE tblmaintenance_hrviolatorsheader SET xstatus = 'Resolved', xdateresolved = '". getsysdate() ."', xtimeresolved = '". date('H:i:s') ."', xdatetimeresolved = '". date('Y-m-d H:i:s', strtotime(getsysdate() ." ". date('H:i:s'))) ."' WHERE VSeriesNumber = '". $_POST['VSN'] ."';", $connection);
				}

				if ( str_replace(",", "", $_POST['xFine']) == $rowViolator[5] ) {
					$sqlSave = " SELECT fine, xvat, totalAmount FROM tblmaintenance_hrviolators WHERE VSeriesNumber = '". $_POST['VSN'] ."' AND CODE = '". $_POST['HRCode'] ."'; ";
					$resSave = mysql_query($sqlSave, $connection);
					$rowSave = mysql_fetch_array($resSave);

					$fineAmount = $rowSave[0];
					$VAT = $rowSave[1];
					$TotalAmount = $rowSave[2];
				} else {
					$fineAmount = str_replace(",", "", $_POST['xFine']);
					$TenantInfo = mysql_fetch_array(mysql_query("SELECT a.mallID, b.isRent FROM tbltrans_tenants AS a INNER JOIN tbltrans_proposal AS b ON a.inqID = b.inquiryID AND a.ActiveProposal = b.proposalNum WHERE a.TenantID = '". $rowViolator[1] ."';", $connection));
					$getSetup = explode("|", getrentvattype($TenantInfo[0]));
					$isVatable = $getSetup[1];
					$isInclusive = $getSetup[2];
					$VATPercent = floatval($getSetup[0]) / 100;
					if($TenantInfo['isRent'] == 0){
						if($isVatable == "yes"){
							if($isInclusive == "inc"){ //VAT IS INCLUSIVE
								$VATAmount = ( floatval($fineAmount) / 1.12 ) * $VATPercent;
								$RentLessVAT = floatval($fineAmount) - $VATAmount;
								$Amount = $RentLessVAT;
								$VAT = $VATAmount;
								$TotalAmount = $VAT + $Amount;
							}else{ //VAT IS EXCLUSIVE
								$VATAmount = floatval($fineAmount) * $VATPercent;
								$RentPlusVAT = floatval($fineAmount);
								$Amount = floatval($fineAmount);
								$VAT = $VATAmount;
								$TotalAmount = floatval($fineAmount) + $VATAmount;
							}
						}else{
							$Amount = $fineAmount;
							$VAT = "0.00";
							$TotalAmount = floatval($fineAmount);
						}
					}else{
						$Amount = $fineAmount;
						$VAT = "0.00";
						$TotalAmount = floatval($fineAmount);
					}
				}

				$updateAmount = " UPDATE tblmaintenance_hrviolators SET fine = '". $fineAmount ."', xvat = '". $VAT ."', totalAmount = '". $TotalAmount ."' WHERE VSeriesNumber = '". $_POST['VSN'] ."' AND Code = '". $_POST['HRCode'] ."'; ";
				$resUpAmount = mysql_query($updateAmount, $connection);

				// PAG SAVE SA TBLTRANSACTION
				// ADDED BY PETER - 2019-11-01
				if ( ($_POST['xFine'] != 0) && ($_POST['Status'] == "Resolved") ) {
					$saveCharge = " INSERT INTO tbltransaction SET tenantid = '". $rowViolator[1] ."', xcode = '". $_POST['HRCode'] ."', description = '". mysql_real_escape_string($rowViolator[0]) ."', amount = '". $fineAmount ."', qty = '1', paymentamount = '', paymentor = '', vatamount = '". $VAT ."', balance = '". $TotalAmount ."', xdate = '". date('Y-m-d', strtotime(getsysdate())) ."', isPenalty = 0, totalamount = '". $TotalAmount ."', xdescription = '". mysql_real_escape_string($rowHR[1]) ."', userid = '". $_SESSION['MMS-UserID'] ."', merchant_code = '". $rowMC[0] ."'; ";
					$resCharge = mysql_query($saveCharge, $connection);
					// echo $saveCharge;

					$pdt = " UPDATE tblmaintenance_hrviolators SET postingDate = '". date('Y-m-d', strtotime(getsysdate())) ."', postingTime = '". date('H:i:s') ."',  postingDate2 = '". date('Y-m-d') ."', postingTime2 = '". date('H:i:s') ."' WHERE VSeriesNumber = '". $_POST['VSN'] ."' AND Code = '". $_POST['HRCode'] ."'; ";
					$respdt = mysql_query($pdt, $connection);
				}

				//INSERT LOGS START
				$VioHeader = mysql_fetch_array(mysql_query("SELECT ViolatorID, ViolatorName FROM tblmaintenance_hrviolatorsheader WHERE VSeriesNumber = '". $_POST['VSN'] ."';", $connection));
				$VioDetails = mysql_fetch_array(mysql_query("SELECT Violation FROM tblmaintenance_hrviolators WHERE Code = '". $_POST['HRCode'] ."' AND VSeriesNumber = '". $_POST['VSN'] ."';", $connection));
				$arrHeader = ["Violation Series Number", "Remarks Code", "Tenant ID", "Tenant Name", "Date", "Time", "Violation Status", "Remarks", "Violation"];
				$arrValue = [$_POST['VSN'], $RemarksCode, $VioHeader['ViolatorID'], $VioHeader['ViolatorName'], date('m/d/Y', strtotime(getsysdate())), date('H:i:s'), $_POST['Status'], $_POST['txtIRRemarks'], "<br/>&emsp;&emsp;&emsp;&emsp;<span class='fa fa-angle-double-right blue'></span>&nbsp;". $_POST['HRCode'] ."<br/>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Description&nbsp;<span class='fa fa-angle-right blue'></span>&nbsp;". $VioDetails['Violation'] ."<br/>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Charge/Punishment&nbsp;<span class='fa fa-angle-right blue'></span>&nbsp;". $_POST['xFine']];
				$tran_logs = create_logs_per_transaction("updated a modified a violation.", "Incident Report", createXinfo("INSERT", $arrHeader, "", $arrValue, "", "", ""), "" ,"ADD", $_POST['VSN']);
				//INSERT LOGS END
			}else{
				echo 2;
			}
		break;

		// DELETING OF VIOLATION
		// ADDED BY PETER - NOV. 19, 2019
		case 'deleteViolation':
			$sql = " DELETE FROM tblmaintenance_hrviolators WHERE VSeriesNumber = '". $_POST['id'] ."' AND Code = '". $_POST['vCode'] ."'; ";
			$res = mysql_query($sql, $connection);

			if ( $res == true ) {
				echo 1;
			} else {
				echo $sql;
			}
		break;
	}				
?>