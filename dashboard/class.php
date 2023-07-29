<?php  
session_start();
include("../connect.php");
	$filepath = mysql_fetch_array(mysql_query("SELECT filepath, dbsetup, SFTPHost, SFTPPort FROM tblsys_setup;", $connection)); //Get System Setup
	switch ($_POST['form']) {
		case 'ShowPanelValPage1':
			$inq = mysql_fetch_array(mysql_query("SELECT COUNT(date_inquired) FROM tbltrans_inquiry WHERE date_inquired = '". date('Y-m-d') ."' ". getMallAccess("Mall_ID", "AND") .";", $connection));
			$totalunit = mysql_fetch_array(mysql_query("SELECT COUNT(unitid) FROM tblref_unit WHERE status = 'Reserved' ". getMallAccess("mallid", "AND") .";", $connection));
			$occupied = mysql_fetch_array(mysql_query("SELECT COUNT(status) FROM tblref_unit WHERE status = 'Occupied' ". getMallAccess("mallid", "AND") .";", $connection));
			$vacant = mysql_fetch_array(mysql_query("SELECT COUNT(status) FROM tblref_unit WHERE status = 'Vacant' ". getMallAccess("mallID", "AND") .";", $connection));
			echo $inq[0] . "|" . $totalunit[0] . "|" . $occupied[0] . "|" . $vacant[0];
		break;

		case 'viewInquiryListToday':
			$res = mysql_query("SELECT a.Mall, a.Company_Name, a.Industry, b.unitname FROM tbltrans_inquiry AS a LEFT JOIN tblref_unit AS b ON a.UnitID = b.unitid WHERE date_inquired = '". date('Y-m-d') ."' AND (a.Mall LIKE '%". $_POST['key'] ."%' OR a.Company_Name LIKE '%". $_POST['key'] ."%' OR a.Industry LIKE '%". $_POST['key'] ."%' OR b.unitname LIKE '%". $_POST['key'] ."%') ". getMallAccess("a.Mall_ID", "AND") .";", $connection);
			while($row = mysql_fetch_array($res)){
				echo 	"<tr>
							<td>". $row[0] ."</td>
							<td>". $row[1] ."</td>
							<td>". $row[2] ."</td>
							<td>". $row[3] ."</td>
						</tr>";
			}
		break;

		case 'viewDashbboardUnits':
			if($_POST['Mall'] == ""){
				$MallFilter .= "";
			}else{
				$MallFilter .= " AND mallid = '". $_POST['Mall'] ."'";
			}
			if($_POST['Wing'] == ""){
				$WingFilter .= "";
			}else{
				$WingFilter .= " AND wingid = '". $_POST['Wing'] ."'";
			}
			if($_POST['Floor'] == ""){
				$FloorFilter .= "";
			}else{
				$FloorFilter .= " AND floorid = '". $_POST['Floor'] ."'";
			}
			if($_POST['Classification'] == ""){
				$ClassificationFilter .= "";
			}else{
				$ClassificationFilter .= " AND classid = '". $_POST['Classification'] ."'";
			}
			if($_POST['Department'] == ""){
				$DepartmentFilter .= "";
			}else{
				$DepartmentFilter .= " AND depid = '". $_POST['Department'] ."'";
			}
			if($_POST['Category'] == ""){
				$CategoryFilter .= "";
			}else{
				$CategoryFilter .= " AND catid = '". $_POST['Category'] ."'";
			}
			$res = mysql_query("SELECT unitname, startDate, endDate, unitid FROM tblref_unit WHERE status = '". $_POST['type'] ."' AND unitname LIKE '%". $_POST['key'] ."%' ". getMallAccess("mallid", "AND") .";", $connection);
			while($row = mysql_fetch_array($res)){
				if($row['startDate'] == "" || $row['startDate'] == "0000-00-00"){
					$startdate = "";
				}else{
					$startdate = date('m/d/Y', strtotime($row['startDate']));
				}

				if($row['endDate'] == "" || $row['endDate'] == "0000-00-00"){
					$enddate = "";
				}else{
					$enddate = date('m/d/Y', strtotime($row['endDate']));
				}

				if($_POST['Type'] == "Occupied"){
					$daterange = $startdate ." - ". $enddate;
				}else{
					$daterange = $startdate;
				}

				if($_POST['type'] == "Vacant"){
					echo 	"<tr>
								<td>". $row['unitname'] ."</td>
							</tr>";
				}else{
					echo 	"<tr>
								<td>". $row['unitname'] ."</td>
								<td>". $daterange ."</td>
							</tr>";
				}
			}
		break;

		case 'MonthlyTotalSalesFromTenants':
			$tblSales = tblSales($filepath['dbsetup']);
			$return_arr = array();
			$res = mysql_query("SELECT a.monthname, SUM(CASE WHEN b.". $tblSales[6] ." != '' THEN b.". $tblSales[6] ." ELSE 0 END) AS SalesFromTenants FROM tbl_month as a LEFT JOIN ". $tblSales[0] ." as b ON a.month = MONTH(". $tblSales[1] .") ". getMallAccess("mallid", "WHERE") ." GROUP BY a.monthname ORDER BY a.month;", $connection);
			while($row = mysql_fetch_array($res)){
				$row_array['name'] = date('F', strtotime($row[0]));
				$row_array['y'] = floatval($row[1]);
				array_push($return_arr,$row_array);
			}
			echo json_encode($return_arr);
		break;

		case 'ShowTenantSalesTable':
			$tblSales = tblSales($filepath['dbsetup']);
			echo "<div style='height: 400px;'>
					<table class='table table-bordered table-striped fixTable'>
						<thead>
							<tr>
								<th>Month</th>
								<th>Total Sales</th>
							</tr>
						</thead>
						<tbody>";

				$res = mysql_query("SELECT a.monthname, SUM(CASE WHEN b.".$tblSales[6]." != '' THEN b.".$tblSales[6]." ELSE 0 END) AS SalesFromTenants FROM tbl_month as a LEFT JOIN ". $tblSales[0] ." as b ON a.month = MONTH(".$tblSales[1].") ". getMallAccess("mallid", "WHERE") ." GROUP BY a.monthname ORDER BY a.month;", $connection);
				while($row = mysql_fetch_array($res)){
						echo "	<tr>
									<td>". date('F', strtotime($row[0])) ."</td>
									<td>P ". number_format($row[1], "2", ".", ",") ."</td>
								</tr>";
				}
			echo "		</tbody>	
					</table>
				</div>";
		break;

		case 'ShowListOfTopTenants':
			$tblSales = tblSales($filepath['dbsetup']);
			$count = 1;
			$syslogo = mysql_fetch_array(mysql_query("SELECT corporatelogo FROM tblsys_setup;", $connection));
			$res = mysql_query("SELECT SUM(a.".$tblSales[6]."), a.tenantid, b.companyid, b.tradeid, b.tradename, c.filename FROM ".$tblSales[0]." AS a LEFT JOIN tbltrans_tenants AS b ON a.tenantid = b.tenantid LEFT JOIN tbltrans_tradename AS c ON b.tradeid = c.tradeid ". getMallAccess("a.mallid", "WHERE") ." GROUP BY a.tenantid ORDER BY SUM(a.".$tblSales[6].") DESC, b.tradename ASC LIMIT 10;", $connection);
			while($row = mysql_fetch_array($res)){

				if($row[5] == ""){
					$image = "assets/images/noimage5.png";
				}else{
					if(!file_exists("../../Mall_Attachments/company/".$row[2]."/trades/".$row[3]."/".$row[5])){ 
						$image = "assets/images/noimage5.png";
					}else{
						$image = "../Mall_Attachments/company/".$row[2]."/trades/".$row[3]."/".$row[5];
					}
				}

				if($count == 1){
					$ranking = "<i class='fa fa-star' style='color: yellow;'></i><i class='fa fa-star' style='color: yellow;'></i><i class='fa fa-star' style='color: yellow;'></i>";
				}else if($count == 2){
					$ranking = "<i class='fa fa-star' style='color: yellow;'></i><i class='fa fa-star' style='color: yellow;'></i>";
				}else if($count == 3){
					$ranking = "<i class='fa fa-star' style='color: yellow;'></i>";
				}else{
					$ranking = $count;
				}
				echo "	<div class='row form-group'>
							<div class='col-md-2 center'>". $ranking ."</div>
							<div class='col-md-1'><img class='img-circle' src='". $image ."' width='30px' height='30px'></div>
							<div class='col-md-4'>". $row[4] ."</div>
							<div class='col-md-1'></div>
							<div class='col-md-4'>P ". number_format($row[0], "2", ".", ",") ."</div>
						</div>";
			$count++;
			}
		break;

		case 'MonthlyOccupancyReport':
			$color[1] = "grey";
			$color[2] = "blue";
			$color[3] = "orange";
			$return_arr = array();
			$ctr = 1;
			$res = mysql_query("SELECT DISTINCT(status) FROM tblref_unit ". getMallAccess("mallid", "WHERE") ." ORDER BY status DESC;", $connection);
			while($row = mysql_fetch_array($res)){
				$num_arr[$ctr] = array();
				for($a = 1; $a <= 12; $a++){
					$row2 = mysql_fetch_array(mysql_query("SELECT COUNT(status) FROM tblref_unit WHERE status = '". $row[0] ."' AND MONTH(startdate) = '". $a ."' ". getMallAccess("mallid", "AND") .";", $connection));
					array_push($num_arr[$ctr],floatval($row2[0]));
				}
				$row_array['name'] = $row[0];
				$row_array['data'] = $num_arr[$ctr];
				$row_array['color'] = $color[$ctr];
				array_push($return_arr, $row_array);
				$ctr++;
			}
			echo json_encode($return_arr);
		break;

		case 'OccpancyBasedonClassification':
			$color[1] = "#D24D57";
			$color[2] = "#AEA8D3";
			$color[3] = "#446CB3";
			$color[4] = "#A2DED0";
			$color[5] = "#E9D460";
			$color[6] = "#6C7A89";
			$color[7] = "#D64541";
			$color[8] = "#F1A9A0";
			$color[9] = "#90C695";
			$color[10] = "#FABE58";
			$color[11] = "#ECECEC";
			$color[12] = "#FDE3A7";
			$return_arr2 = array();
			$ctr = 1;
			$result2 = mysql_query("SELECT classificationname, COUNT(*) FROM tblref_unit WHERE STATUS = 'Occupied' ". getMallAccess("mallid", "AND") ." GROUP BY classificationname;", $connection);
			while($row1_2 = mysql_fetch_array($result2)){
				$row_array2['name'] = $row1_2[0];
				$row_array2['y'] = floatval($row1_2[1]);
				$row_array2['color'] =  $color[$ctr];
				array_push($return_arr2,$row_array2);
				$ctr++;
			}
			echo json_encode($return_arr2);
		break;

		case 'VacancyBasedonClassification':
			$color[1] = "#D24D57";
			$color[2] = "#AEA8D3";
			$color[3] = "#446CB3";
			$color[4] = "#A2DED0";
			$color[5] = "#E9D460";
			$color[6] = "#6C7A89";
			$color[7] = "#D64541";
			$color[8] = "#F1A9A0";
			$color[9] = "#90C695";
			$color[10] = "#FABE58";
			$color[11] = "#ECECEC";
			$color[12] = "#FDE3A7";
			$return_arr2 = array();
			$ctr = 1;
			$result2 = mysql_query("SELECT classificationname, COUNT(*) FROM tblref_unit WHERE STATUS = 'Vacant' ". getMallAccess("mallid", "AND") ." GROUP BY classificationname;", $connection);
			while($row1_2 = mysql_fetch_array($result2)){
				$row_array2['name'] = $row1_2[0];
				$row_array2['y'] = floatval($row1_2[1]);
				$row_array2['color'] =  $color[$ctr];
				array_push($return_arr2,$row_array2);
				$ctr++;
			}
			echo json_encode($return_arr2);
		break;

		case 'MonthlyTotalRevenueFromLease':
			$return_arr = array();
			$res = mysql_query("SELECT A.monthname, SUM(CASE WHEN b.totalamount != '' AND xdescription = 'Rent Fee' THEN b.`totalamount` ELSE 0 END) AS SalesFromLease FROM tbl_month AS a LEFT JOIN tbltransaction AS b ON a.month = MONTH(b.xdate) LEFT JOIN tbltrans_tenants AS c ON b.TenantID = c.tenantid ". getMallAccess("c.mallid", "WHERE") ." GROUP BY a.monthname ORDER BY a.month;", $connection);
			while($row = mysql_fetch_array($res)){
				$row_array['name'] = date('F', strtotime($row[0]));
				$row_array['y'] = floatval($row[1]);
				array_push($return_arr,$row_array);
			}
			echo json_encode($return_arr);
		break;

		case 'MonthlySet':
			$color[1] = "grey";
			$color[2] = "orange";
			$return_arr = array();
			$ctr = 1;
			$res = mysql_query("SELECT DISTINCT(status) FROM tblref_unit WHERE typeofbusiness = 'SET' AND (status = 'Vacant' OR status = 'Occupied') ". getMallAccess("mallid", "AND") ." ORDER BY status DESC;", $connection);
			while($row = mysql_fetch_array($res)){
				$num_arr[$ctr] = array();
				for($a = 1; $a <= 12; $a++){
					$row2 = mysql_fetch_array(mysql_query("SELECT COUNT(status) FROM tblref_unit WHERE status = '". $row[0] ."' AND MONTH(startdate) = '". $a ."' AND typeofbusiness = 'SET' ". getMallAccess("mallid", "AND") .";", $connection));
					array_push($num_arr[$ctr],floatval($row2[0]));
				}
				$row_array['name'] = $row[0];
				$row_array['data'] = $num_arr[$ctr];
				$row_array['color'] =  $color[$ctr];
				array_push($return_arr,$row_array);
				$ctr++;
			}
			echo json_encode($return_arr);
		break;

		case 'MonthlyLCA':
			$color[1] = "grey";
			$color[2] = "orange";
			$return_arr = array();
			$ctr = 1;
			$res = mysql_query("SELECT DISTINCT(status) FROM tblref_unit WHERE typeofbusiness = 'LCA' AND (status = 'Vacant' OR status = 'Occupied') ". getMallAccess("mallid", "AND") ." ORDER BY status DESC;", $connection);
			while($row = mysql_fetch_array($res)){
				$num_arr[$ctr] = array();
				for($a = 1; $a <= 12; $a++){
					$row2 = mysql_fetch_array(mysql_query("SELECT COUNT(status) FROM tblref_unit WHERE status = '". $row[0] ."' AND MONTH(startdate) = '". $a ."' AND typeofbusiness = 'LCA' ". getMallAccess("mallid", "AND") .";", $connection));
					array_push($num_arr[$ctr],floatval($row2[0]));
				}
				$row_array['name'] = $row[0];
				$row_array['data'] = $num_arr[$ctr];
				$row_array['color'] =  $color[$ctr];
				array_push($return_arr,$row_array);
				$ctr++;
			}
			echo json_encode($return_arr);
		break;

		case 'ShowPanelValPage2':
			$workorders = mysql_fetch_array(mysql_query("SELECT COUNT(workorderid) FROM tblmaintenance_workorder WHERE xstatus = 'Pending' ". getMallAccess("mallid", "AND") .";", $connection));
			$complaints = mysql_fetch_array(mysql_query("SELECT COUNT(Complaint_Series_No) FROM tblcomplaints WHERE Complaint_Status = 'Pending' ". getMallAccess("MallID", "AND") .";", $connection));
			$incidentreports = mysql_fetch_array(mysql_query("SELECT COUNT(VSeriesNumber) FROM tblmaintenance_hrviolatorsheader WHERE xstatus = 'Pending' ". getMallAccess("mallid", "AND") .";", $connection));
			$maintenanceexpense = mysql_fetch_array(mysql_query("SELECT SUM(totalamount) FROM tbltransaction WHERE tenantid = '' AND balance NOT LIKE '%-%';", $connection));
			echo $workorders[0] . "|" . $complaints[0] . "|" . $incidentreports[0] . "|" . number_format($maintenanceexpense[0], "2", ".", ",");
		break;

		case 'ViewMaintenanceExp':
			$res = mysql_query("SELECT xdate, reference, description, amount, balance FROM tbltransaction WHERE tenantid = '' AND balance NOT LIKE '%-%' AND (reference LIKE '%". $_POST['key'] ."%' OR description LIKE '%". $_POST['key'] ."%') ORDER BY id DESC", $connection);
			while($row = mysql_fetch_array($res)){
				echo "	<tr>
							<td>". date('m/d/Y', strtotime($row[0])) ."</td>
							<td>". $row[1] ."</td>
							<td>". $row[2] ."</td>
							<td>". number_format($row[3], "2", ".", ",") ."</td>
							<td>". number_format($row[4], "2", ".", ",") ."</td>
						</tr>";
			}
		break;

		case 'ViewMaintenanceIR':
			$res = mysql_query("SELECT xdate, ViolatorName, VSeriesNumber FROM tblmaintenance_hrviolatorsheader WHERE xstatus = 'Pending' AND ViolatorName LIKE '%". $_POST['key'] ."%' ". getMallAccess("mallid", "AND") .";", $connection);
			while($row = mysql_fetch_array($res)){
				echo "	<tr>
							<td width='10%'>". date('m/d/Y', strtotime($row[0])) ."</td>
							<td width='25%'>". $row[1] ."</td>
							<td width='65%'>";
								$res2 = mysql_query("SELECT Violation, offensetype FROM tblmaintenance_hrviolators WHERE VSeriesNumber = '". $row[2] ."'", $connection);
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
					echo 	"</td>
						</tr>";
			}
		break;

		case 'ViewMaintenanceComplaints':
			$res = mysql_query("SELECT Date_Entry, Complaint_Code, Complete_Description, Priority_Status FROM tblcomplaints WHERE Complaint_Status = 'Pending' AND (Complaint_Code LIKE '%". $_POST['key'] ."%' OR Complete_Description LIKE '%". $_POST['key'] ."%' OR Priority_Status LIKE '%". $_POST['key'] ."%') ". getMallAccess("MallID", "AND") .";", $connection);
			while($row = mysql_fetch_array($res)){
				if($row[3] == "High"){
					$stat = "<span class='label label-danger arrowed-in-right arrowed' style='color: black;'>". $row[3] ."' Priority'</span>";
				}else if($row[3] == "Medium"){
					$stat = "<span class='label label-warning arrowed-in-right arrowed' style='color: black;'>". $row[3] ."' Priority'</span>";
				}else if($row[3] == "Low"){
					$stat = "<span class='label label-yellow arrowed-in-right arrowed' style='color: black;'>". $row[3] ."' Priority'</span>";
				}

				echo "	<tr>
							<td>". date('m/d/Y', strtotime($row[0])) ."</td>
							<td>". $row[1] ."</td>
							<td>". $row[2] ."</td>
							<td>". $stat ."</td>
						</tr>";
			}
		break;

		case 'ViewMaintenanceWorkOrders':
			$res = mysql_query("SELECT xdate, tradename, workorderid, workername, Complaint_Series_No FROM tblmaintenance_workorder WHERE xstatus = 'Pending' AND (tradename LIKE '%". $_POST['key'] ."%' OR workername LIKE '%". $_POST['key'] ."%') ". getMallAccess("mallid", "AND") .";", $connection);
			while($row = mysql_fetch_array($res)){
				$complaints = mysql_fetch_array(mysql_query("SELECT Complaint_Status, Complaint_Code FROM tblcomplaints WHERE Complaint_Series_No = '". $row[4] ."' ", $connection));
				if($complaints[0] == "Ongoing"){
					$complaintstatus = '<span class="blue fa fa-circle"></span>';
				}else{
					$complaintstatus = '<span class="green fa fa-circle"></span>';
				}

				echo "	<tr>
							<td width='10%'>". date('m/d/Y', strtotime($row[0])) ."</td>
							<td width='20%'>". $row[1] ."</td>
							<td width='50%'>";
								if($row[4] == ""){
									$res2 = mysql_query("SELECT xcategory, taskstatus, xtaskid FROM tblmaintenance_workorderlist WHERE workorderid = '". $row[2] ."'", $connection);
									while($row2 = mysql_fetch_array($res2)){
										$catname = mysql_fetch_array(mysql_query("SELECT category FROM tblmaintenance_category WHERE category_id = '". $row2[0] ."' ", $connection));
										$taskname = mysql_fetch_array(mysql_query("SELECT description FROM tblmaintenance_tasklist WHERE taskid = '". $row2[2] ."' ", $connection));

										if($row2[2] == ""){
											$trabaho = $catname[0];
										}else{
											$trabaho = $taskname[0];
										}

										if($row2[1] == 'Resolved'){
											$span = '<span class="green fa fa-circle"></span>';
										}else if($row2[1] == 'Pending'){
											$span = '<span class="orange fa fa-circle"></span>';
										}else if($row2[1] == 'Ongoing'){
											$span = '<span class="blue fa fa-circle"></span>';
										}
										echo $span." ".$trabaho."<br/>";
									}
								}else{
									echo $complaintstatus." ".$complaints[1];
								}
					echo 	"</td>
							<td width='20%'>". $row[3] ."</td>
						</tr>";
			}
		break;

		case 'MonthlyAverageTurnAroundTimeWO':
			$return_arr = array();
			$ctr = 1;
			$res = mysql_query("SELECT a.monthname, SUM(DATEDIFF(b.enddate, b.startdate))/COUNT(b.workorderid) AS 'TAT' FROM tbl_month AS a LEFT JOIN tblmaintenance_workorder AS b ON a.month = MONTH(b.xdate) ". getMallAccess("mallid", "WHERE") ." GROUP BY a.monthname ORDER BY a.month;", $connection);
			while($row = mysql_fetch_array($res)){
				$row_array['name'] = date('F', strtotime($row[0]));
				$row_array['y'] = floatval($row[1]);
				array_push($return_arr,$row_array);
			}
			echo json_encode($return_arr);
		break;

		case 'MonthlyAverageTurnAroundTimeComplaints':
			$return_arr = array();
			$ctr = 1;
			$res = mysql_query("SELECT a.monthname, SUM(DATEDIFF(b.Time_Resolved, b.Time_Received))/COUNT(b.Complaint_Series_No) AS 'TAT' FROM tbl_month AS a LEFT JOIN tblcomplaints AS b ON a.month = MONTH(b.xdate) ". getMallAccess("MallID", "WHERE") ." GROUP BY a.monthname ORDER BY a.month;", $connection);
			while($row = mysql_fetch_array($res)){
				$row_array['name'] = date('F', strtotime($row[0]));
				$row_array['y'] = floatval($row[1]);
				array_push($return_arr,$row_array);
			}
			echo json_encode($return_arr);
		break;

		case 'MonthlyAverageTurnAroundTimeIR':
			$return_arr = array();
			$ctr = 1;
			$res = mysql_query("SELECT a.monthname, SUM(DATEDIFF(b.xdateresolved, b.xdate))/COUNT(b.id) AS 'TAT' FROM tbl_month AS a LEFT JOIN tblmaintenance_hrviolators AS b ON a.month = MONTH(b.xdate) GROUP BY a.monthname ORDER BY a.month;", $connection);
			while($row = mysql_fetch_array($res)){
				$row_array['name'] = date('F', strtotime($row[0]));
				$row_array['y'] = floatval($row[1]);
				array_push($return_arr,$row_array);
			}
			echo json_encode($return_arr);
		break;

		case 'ShowWorkOrderLogs':
			$res = mysql_query("SELECT TenantID, workorderid, tradename, xdate, TIMEDIFF('". date('Y-m-d H:i:s') ."', xdateandtime), Complaint_Series_No FROM tblmaintenance_workorder ". getMallAccess("mallid", "WHERE") ." ORDER BY workorderid DESC LIMIT 10;", $connection);
			while($row = mysql_fetch_array($res)){
				$tenantinfo = mysql_fetch_array(mysql_query("SELECT CompanyID, tradeID FROM tbltrans_tenants WHERE tenantid = '". $row[0] ."'", $connection));
				$filename = mysql_fetch_array(mysql_query("SELECT filename FROM tbltrans_tradename WHERE tradeID = '". $tenantinfo[1] ."'", $connection));
				$syslogo = mysql_fetch_array(mysql_query("SELECT corporatelogo FROM tblsys_setup", $connection));

				if($row[0] == ""){
					$image = "assets/images/noimage5.png";
				}else{
					if(!file_exists("../../Mall_Attachments/company/".$tenantinfo[0]."/trades/".$tenantinfo[1]."/".$filename[0])){ 
						$image = "assets/images/noimage5.png";
					}else{
						$image = "../Mall_Attachments/company/".$tenantinfo[0]."/trades/".$tenantinfo[1]."/".$filename[0];
					}
				}

				if($row[4] > '24:00:00'){
					$nakalipas = "<i class='ace-icon fa fa-calendar'></i><span class='green'> ".date('m/d/Y', strtotime($row[3]))."</span>";
				}else{
					if($row[4] > '00:59:00'){
						$nakalipas = "<i class='ace-icon fa fa-clock-o'></i><span class='green'> ".date('g', strtotime($row[4]))." hr</span>";
					}else{
						$nakalipas = "<i class='ace-icon fa fa-clock-o'></i><span class='green'> ".date('i', strtotime($row[4]))." min</span>";
					}
				}

				echo "	<div class='itemdiv dialogdiv'>
							<div class='user'>
								<img alt='". $row[2] ."' src='". $image ."'>
							</div>
							<div class='body'>
								<div class='time'>
									". $nakalipas ."
								</div>
								<div class='name'>
									<b class='blue'>". $row[2] ."</b>
								</div>
								<div class='name'>
									<b>". $row[1] ."</b>
								</div>
								<div class='text'>";
									if($row[5] == ""){
										$res2 = mysql_query("SELECT DISTINCT xcategory, taskstatus FROM tblmaintenance_workorderlist WHERE workorderid = '". $row[1] ."' ORDER BY taskstatus ASC", $connection);
										while($row2 = mysql_fetch_array($res2)){
											$catname = mysql_fetch_array(mysql_query("SELECT category FROM tblmaintenance_category WHERE category_id = '". $row2[0] ."'", $connection));
											if($row2[1] == "Resolved"){
												echo "<span class='green fa fa-circle'></span> ". $catname[0] ."</br>";
											}else{
												echo "<span class='orange fa fa-circle'></span> ". $catname[0] ."</br>";
											}
										}
									}else{
										$res2 = mysql_query("SELECT Complaint_Code, Complaint_Status FROM tblcomplaints WHERE Complaint_Series_No = '". $row[5] ."'", $connection);
										while($row2 = mysql_fetch_array($res2)){

											if($row1[1] == "Resolved"){
												echo "<span class='green fa fa-circle'></span> ". $row2[0] ."</br>";
											}else if($row2[1]){
												echo "<span class='blue fa fa-circle'></span> ". $row2[0] ."</br>";
											}else{
												echo "<span class='orange fa fa-circle'></span> ". $row2[0] ."</br>";
											}
										}
									}
						echo	"</div>
							</div>
						</div>";
			}
		break;

		case 'MonthlyWorkOrdersPending':
			$return_arr = array();
			$sql = "SELECT a.monthname, SUM(CASE WHEN b.xstatus = 'Pending' THEN 1 ELSE 0 END) AS 'Pending' FROM tbl_month AS a LEFT JOIN tblmaintenance_workorder AS b ON a.month = MONTH(b.xdate) ". getMallAccess("b.mallid", "WHERE") ." GROUP BY a.monthname ORDER BY a.month;";
			$res = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($res)){
				$row_array['name'] = date('F', strtotime($row[0]));
				$row_array['y'] = floatval($row[1]);
				array_push($return_arr,$row_array);
			}
			echo json_encode($return_arr);
		break;

		case 'MonthlyWorkOrdersResolved':
			$return_arr = array();
			$sql = "SELECT a.monthname, SUM(CASE WHEN b.xstatus = 'Resolved' THEN 1 ELSE 0 END) AS 'Resolved' FROM tbl_month AS a LEFT JOIN tblmaintenance_workorder AS b ON a.month = MONTH(b.xdate) ". getMallAccess("b.mallid", "WHERE") ." GROUP BY a.monthname ORDER BY a.month;";
			$res = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($res)){
				$row_array['name'] = date('F', strtotime($row[0]));
				$row_array['y'] = floatval($row[1]);
				array_push($return_arr,$row_array);
			}
			echo json_encode($return_arr);
		break;

		case 'MonthlyComplaintsPending':
			$return_arr = array();
			$sql = "SELECT a.monthname, SUM(CASE WHEN b.Complaint_Status = 'Pending' THEN 1 ELSE 0 END) AS 'Pending' FROM tbl_month AS a LEFT JOIN tblcomplaints AS b ON a.month = MONTH(b.xdate) ". getMallAccess("b.mallid", "WHERE") ." GROUP BY a.monthname ORDER BY a.month;";
			$res = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($res)){
				$row_array['name'] = date('F', strtotime($row[0]));
				$row_array['y'] = floatval($row[1]);
				array_push($return_arr,$row_array);
			}
			echo json_encode($return_arr);
		break;

		case 'MonthlyComplaintsResolved':
			$return_arr = array();
			$sql = "SELECT a.monthname, SUM(CASE WHEN b.Complaint_Status = 'Resolved' THEN 1 ELSE 0 END) AS 'Resolved' FROM tbl_month AS a LEFT JOIN tblcomplaints AS b ON a.month = MONTH(b.xdate) ". getMallAccess("b.mallid", "WHERE") ." GROUP BY a.monthname ORDER BY a.month;";
			$res = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($res)){
				$row_array['name'] = date('F', strtotime($row[0]));
				$row_array['y'] = floatval($row[1]);
				array_push($return_arr,$row_array);
			}
			echo json_encode($return_arr);
		break;

		case 'MonthlyIncidentReportsPending':
			$return_arr = array();
			$sql = "SELECT a.monthname, SUM(CASE WHEN b.xstatus = 'Pending' THEN 1 ELSE 0 END) AS 'Pending' FROM tbl_month AS a LEFT JOIN tblmaintenance_hrviolatorsheader AS b ON a.month = MONTH(b.xdate) ". getMallAccess("b.mallid", "WHERE") ." GROUP BY a.monthname ORDER BY a.month;";
			$res = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($res)){
				$row_array['name'] = date('F', strtotime($row[0]));
				$row_array['y'] = floatval($row[1]);
				array_push($return_arr,$row_array);
			}
			echo json_encode($return_arr);
		break;

		case 'MonthlyIncidentReportsResolved':
			$return_arr = array();
			$sql = "SELECT a.monthname, SUM(CASE WHEN b.xstatus = 'Resolved' THEN 1 ELSE 0 END) AS 'Resolved' FROM tbl_month AS a LEFT JOIN tblmaintenance_hrviolatorsheader AS b ON a.month = MONTH(b.xdate) ". getMallAccess("b.mallid", "WHERE") ." GROUP BY a.monthname ORDER BY a.month;";
			$res = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($res)){
				$row_array['name'] = date('F', strtotime($row[0]));
				$row_array['y'] = floatval($row[1]);
				array_push($return_arr,$row_array);
			}
			echo json_encode($return_arr);
		break;

		case 'MaintenanceBudgetPrev':
			$return_arr = array();
			
			$ctr = 1;
			$sql = "SELECT category_id, category FROM tblmaintenance_category ORDER BY category ASC;";
			$res = mysql_query($sql, $connection);
			$rownum = mysql_num_rows($res);
			while ( $row = mysql_fetch_array($res) ) {
				$num_arr[$ctr] = array();

				$sql2 = " SELECT xjan + xfeb + xmar + xapr + xmay + xjun + xjul + xaug + xsep + xoct + xnov + xdec FROM tblref_budget WHERE category_id = '". $row[0] ."' AND xyear = '". date('Y', strtotime('-1 year')) ."'";
				$res2 = mysql_query($sql2, $connection);
				$row2 = mysql_fetch_array($res2);
				$total = floatval($row2[0])+floatval($row2[1])+floatval($row2[2])+floatval($row2[3])+floatval($row2[4])+floatval($row2[5])+floatval($row2[6])+floatval($row2[7])+floatval($row2[8])+floatval($row2[9])+floatval($row2[10])+floatval($row2[11]);
				$row_array['y'] = floatval($total);
				$row_array['name'] = $row[1];
				$row_array['drilldown'] = $row[1]."Prev";
				array_push($return_arr,$row_array);
				$ctr++;
			}
			echo json_encode($return_arr);
		break;

		case 'MaintenanceBudgetCurr':
			$return_arr = array();
			
			$ctr = 1;
			$sql = "SELECT category_id, category FROM tblmaintenance_category ORDER BY category ASC";
			$res = mysql_query($sql, $connection);
			$rownum = mysql_num_rows($res);
			while ( $row = mysql_fetch_array($res) ) {
				$num_arr[$ctr] = array();

				$sql2 = " SELECT xjan + xfeb + xmar + xapr + xmay + xjun + xjul + xaug + xsep + xoct + xnov + xdec FROM tblref_budget WHERE category_id = '". $row[0] ."' AND xyear = '". date('Y') ."'";
				$res2 = mysql_query($sql2, $connection);
				$row2 = mysql_fetch_array($res2);
				$total = floatval($row2[0])+floatval($row2[1])+floatval($row2[2])+floatval($row2[3])+floatval($row2[4])+floatval($row2[5])+floatval($row2[6])+floatval($row2[7])+floatval($row2[8])+floatval($row2[9])+floatval($row2[10])+floatval($row2[11]);
				$row_array['name'] = $row[1];
				$row_array['y'] = floatval($total);
				$row_array['drilldown'] = $row[1]."Curr";

				array_push($return_arr,$row_array);
				$ctr++;
			}
			echo json_encode($return_arr);
		break;

		case 'MaintenanceBudgetPrevDD':
			$return_arr = array();
			$sql = "SELECT category_id, category FROM tblmaintenance_category ORDER BY category ASC";
			$res = mysql_query($sql, $connection);
			$rownum = mysql_num_rows($res);
			while ( $row = mysql_fetch_array($res) ) {
				$row_array['name'] = $row[1];
				$row_array['id'] = $row[1]."Prev";

				$name_arr = array();
				$sql2 = "SELECT xjan, xfeb, xmar, xapr, xmay, xjun, xjul, xaug, xsep, xoct, xnov, xdec FROM tblref_budget WHERE category_id = '". $row[0] ."' AND xyear = '". date('Y', strtotime('-1 year')) ."'";
				$res2 = mysql_query($sql2, $connection);
				$row2 = mysql_fetch_array($res2);
				
				for ( $a = 0; $a <= 11; $a++ ) {
					$arr_month = array();
					$b = $a+1;
					if($b == "1"){
						$month = "January"." ".date('Y', strtotime('-1 year'));
					}else if($b == "2"){
						$month = "February"." ".date('Y', strtotime('-1 year'));
					}else if($b == "3"){
						$month = "March"." ".date('Y', strtotime('-1 year'));
					}else if($b == "4"){
						$month = "April"." ".date('Y', strtotime('-1 year'));
					}else if($b == "5"){
						$month = "May"." ".date('Y', strtotime('-1 year'));
					}else if($b == "6"){
						$month = "June"." ".date('Y', strtotime('-1 year'));
					}else if($b == "7"){
						$month = "July"." ".date('Y', strtotime('-1 year'));
					}else if($b == "8"){
						$month = "August"." ".date('Y', strtotime('-1 year'));
					}else if($b == "9"){
						$month = "September"." ".date('Y', strtotime('-1 year'));
					}else if($b == "10"){
						$month = "October"." ".date('Y', strtotime('-1 year'));
					}else if($b == "11"){
						$month = "November"." ".date('Y', strtotime('-1 year'));
					}else if($b == "12"){
						$month = "December"." ".date('Y', strtotime('-1 year'));
					}
					array_push($arr_month, $month, floatval($row2[$a]));
					array_push($name_arr,$arr_month);
				}

				$row_array['data'] = $name_arr;
				array_push($return_arr,$row_array);
			}

			$sql = "SELECT category_id, category FROM tblmaintenance_category ORDER BY category ASC";
			$res = mysql_query($sql, $connection);
			$rownum = mysql_num_rows($res);
			while ( $row = mysql_fetch_array($res) ) {
				$row_array['name'] = $row[1];
				$row_array['id'] = $row[1]."Curr";

				$name_arr = array();
				$sql2 = "SELECT xjan, xfeb, xmar, xapr, xmay, xjun, xjul, xaug, xsep, xoct, xnov, xdec FROM tblref_budget WHERE category_id = '". $row[0] ."' AND xyear = '". date('Y') ."'";
				$res2 = mysql_query($sql2, $connection);
				$row2 = mysql_fetch_array($res2);
				
				for ( $a = 0; $a <= 11; $a++ ) {
					$arr_month = array();
					$b = $a+1;
					if($b == "1"){
						$month = "January"." ".date('Y');
					}else if($b == "2"){
						$month = "February"." ".date('Y');
					}else if($b == "3"){
						$month = "March"." ".date('Y');
					}else if($b == "4"){
						$month = "April"." ".date('Y');
					}else if($b == "5"){
						$month = "May"." ".date('Y');
					}else if($b == "6"){
						$month = "June"." ".date('Y');
					}else if($b == "7"){
						$month = "July"." ".date('Y');
					}else if($b == "8"){
						$month = "August"." ".date('Y');
					}else if($b == "9"){
						$month = "September"." ".date('Y');
					}else if($b == "10"){
						$month = "October"." ".date('Y');
					}else if($b == "11"){
						$month = "November"." ".date('Y');
					}else if($b == "12"){
						$month = "December"." ".date('Y');
					}
					array_push($arr_month, $month, floatval($row2[$a]));
					array_push($name_arr,$arr_month);
				}

				$row_array['data'] = $name_arr;
				array_push($return_arr,$row_array);
			}

			echo json_encode($return_arr);
		break;

		case 'MonthlyConsumptionofElectricReportPrevious':
			$catid = mysql_fetch_array(mysql_query("SELECT category_id FROM tblmaintenance_category WHERE category LIKE '%Electric Reading%'", $connection));
			$return_arr = array();
			$sql = "SELECT a.monthname, SUM(CASE WHEN b.meter_reading != '' AND b.xcategory = '". $catid[0] ."' AND YEAR(b.reading_date) = '". date('Y', strtotime('-1 year')) ."' THEN b.meter_reading ELSE 0 END) AS MeterReading FROM tbl_month AS a LEFT JOIN tblmaintenance_workorderlist AS b ON a.month = MONTH(b.reading_date) GROUP BY a.monthname ORDER BY a.month;";
			$res = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($res)){
				$row_array['name'] = date('F', strtotime($row[0]));
				$row_array['y'] = floatval($row[1]);
				array_push($return_arr,$row_array);
			}
			echo json_encode($return_arr);
		break;

		case 'MonthlyConsumptionofElectricReportCurrent':
			$catid = mysql_fetch_array(mysql_query("SELECT category_id FROM tblmaintenance_category WHERE category LIKE '%Electric Reading%'", $connection));
			$return_arr = array();
			$sql = "SELECT a.monthname, SUM(CASE WHEN b.meter_reading != '' AND b.xcategory = '". $catid[0] ."' AND YEAR(b.reading_date) = '". date('Y') ."' THEN b.meter_reading ELSE 0 END) AS MeterReading FROM tbl_month AS a LEFT JOIN tblmaintenance_workorderlist AS b ON a.month = MONTH(b.reading_date) GROUP BY a.monthname ORDER BY a.month;";
			$res = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($res)){
				$row_array['name'] = date('F', strtotime($row[0]));
				$row_array['y'] = floatval($row[1]);
				array_push($return_arr,$row_array);
			}
			echo json_encode($return_arr);
		break;

		case 'MonthlyConsumptionofWaterReportPrevious':
			$catid = mysql_fetch_array(mysql_query("SELECT category_id FROM tblmaintenance_category WHERE category LIKE '%Water Reading%'", $connection));
			$return_arr = array();
			$sql = "SELECT a.monthname, SUM(CASE WHEN b.meter_reading != '' AND b.xcategory = '". $catid[0] ."' AND YEAR(b.reading_date) = '". date('Y', strtotime('-1 year')) ."' THEN b.meter_reading ELSE 0 END) AS MeterReading FROM tbl_month AS a LEFT JOIN tblmaintenance_workorderlist AS b ON a.month = MONTH(b.reading_date) GROUP BY a.monthname ORDER BY a.month;";
			$res = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($res)){
				$row_array['name'] = date('F', strtotime($row[0]));
				$row_array['y'] = floatval($row[1]);
				array_push($return_arr,$row_array);
			}
			echo json_encode($return_arr);
		break;

		case 'MonthlyConsumptionofWaterReportCurrent':
			$catid = mysql_fetch_array(mysql_query("SELECT category_id FROM tblmaintenance_category WHERE category LIKE '%Water Reading%'", $connection));
			$return_arr = array();
			$sql = "SELECT a.monthname, SUM(CASE WHEN b.meter_reading != '' AND b.xcategory = '". $catid[0] ."' AND YEAR(b.reading_date) = '". date('Y') ."' THEN b.meter_reading ELSE 0 END) AS MeterReading FROM tbl_month AS a LEFT JOIN tblmaintenance_workorderlist AS b ON a.month = MONTH(b.reading_date) GROUP BY a.monthname ORDER BY a.month;";
			$res = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($res)){
				$row_array['name'] = date('F', strtotime($row[0]));
				$row_array['y'] = floatval($row[1]);
				array_push($return_arr,$row_array);
			}
			echo json_encode($return_arr);
		break;

		case 'MonthlyThirdPartyContractors':
			$return_arr = array();
			
			$ctr = 1;
			$sql = "SELECT category_id, category FROM tblmaintenance_category WHERE category NOT LIKE '%Electric Reading%' AND category NOT LIKE '%Water Reading%' AND category NOT LIKE '%Gas Reading%'";
			$res = mysql_query($sql, $connection);
			while ( $row = mysql_fetch_array($res) ) {
				$num_arr[$ctr] = array();
				for ( $a = 1; $a <= 12; $a++ ) {
					$sql2 = " SELECT COUNT(xcategory) FROM tblmaintenance_workorderlist WHERE xcategory = '". $row[0] ."' AND MONTH(xdatetime) = '". $a ."' ";
					$res2 = mysql_query($sql2, $connection);
					$row2 = mysql_fetch_array($res2);
					array_push($num_arr[$ctr],floatval($row2[0]));
				}
				$row_array['name'] = $row[1];
				$row_array['data'] = $num_arr[$ctr];
				array_push($return_arr,$row_array);
				$ctr++;
			}
			echo json_encode($return_arr);
		break;
	}
?>