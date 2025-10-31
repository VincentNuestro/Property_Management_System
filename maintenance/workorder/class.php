<?php
session_start();
	include("../../connect.php");
	switch ( $_POST['form'] ) {
		case 'tblworkorder':
			$getFilters = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'Maintenance' AND userid = '". $_SESSION['MMS-UserID'] ."';", $connection));
		    $Status = explode("|", $getFilters["bystat"]);
		    $Search = explode("|", $getFilters["checked_value"]);
			$UnitType = explode("|", $getFilters["xcheck"]);
		    $Date = explode("|", $getFilters["datefilter"]);

		    // FILTER BY STATUS
			$StatusCount = 0; $SelectedStatus = "";
			for($a = 0; $a<=count($Status)-2; $a++){
				if($Status[$a] == "Pending"){ 
					$StatusVal = "xstatus = 'Pending'"; 
				}else if($Status[$a] == "Resolved"){
					$StatusVal = "xstatus = 'Resolved'"; 
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

	      	$page = $_POST['page'];
			$limit = ($page-1) * 20;
			$res = mysql_query("SELECT workorderid, TenantID, ownername, xdate, xtime, workerid, remarks, xstatus, Complaint_Series_No, mallid, departmentid, postingstatus FROM tblmaintenance_workorder WHERE ". $StatFilter ." ". $SearchFilter ." ". $DateFilter ." ". getMallAccess("mallid", "AND") ." ORDER BY xdateandtime DESC limit ".$limit.",20;", $connection);
			while($row = mysql_fetch_array($res)){
				$tradename = mysql_fetch_array(mysql_query("SELECT tradename FROM tbltrans_tenants WHERE tenantID = '". $row['TenantID'] ."';", $connection));
				$complaints = mysql_fetch_array(mysql_query("SELECT Complaint_Status, Complaint_Code FROM tblcomplaints WHERE Complaint_Series_No = '". $row['Complaint_Series_No'] ."';", $connection));
					if ($row['xstatus'] == 'Pending') {
						$WOStat = '<span class="label label-lg label-warning arrowed-in-right arrowed" style="z-index: 0;">'.$row['xstatus'].'</span>';
					}else if($row['xstatus'] == 'Resolved'){
						$WOStat = '<span class="label label-lg label-success arrowed-in-right arrowed" style="z-index: 0;">'.$row['xstatus'].'</span>';
					}

					if($row['postingstatus'] == 'Posted'){
						$BillStat = '<span class="label label-lg label-primary arrowed-in-right arrowed" style="z-index: 0;">'.$row['postingstatus'].'</span>';
					}else{
						$BillStat = '<span class="label label-lg label-danger arrowed-in-right arrowed" style="z-index: 0;">'.$row['postingstatus'].'</span>';
					}

					if($complaints['Complaint_Status'] == "Ongoing"){
						$complaintstatus = '<span class="blue fa fa-circle"></span>';
					}else{
						$complaintstatus = '<span class="green fa fa-circle"></span>';
					}
			echo	"<tr>
						<td>". $row['workorderid'] ."</td>						
						<td>". date('m/d/Y', strtotime($row['xdate'])) ."</td>						
						<td>". $tradename['tradename'] ."</td>						
						<td>";
							if($row['Complaint_Series_No'] == ""){
								$res2 = mysql_query("SELECT xcategory, taskstatus, xtaskid, MeterID FROM tblmaintenance_workorderlist WHERE workorderid = '". $row['workorderid'] ."' ORDER BY xtaskid ASC, reading_date DESC;;", $connection);
								while($joblist = mysql_fetch_array($res2)){
									$catname = mysql_fetch_array(mysql_query("SELECT category FROM tblmaintenance_category WHERE category_id = '". $joblist['xcategory'] ."';", $connection));
									$taskname = mysql_fetch_array(mysql_query("SELECT description FROM tblmaintenance_tasklist WHERE taskid = '". $joblist['xtaskid'] ."';", $connection));

									if($joblist['xtaskid'] == ""){
										$trabaho = $catname['category'];
									}else{
										$trabaho = $taskname['description'];
									}

									if($joblist['taskstatus'] == 'Resolved'){
										$span = '<span class="green fa fa-circle"></span>';
									}else if($joblist['taskstatus'] == 'Pending'){
										$span = '<span class="orange fa fa-circle"></span>';
									}else if($joblist['taskstatus'] == 'Ongoing'){
										$span = '<span class="blue fa fa-circle"></span>';
									}

									if($catname['category'] == "Electric Reading"){
										$MeterID = " - " . $joblist['MeterID'];
									}else if($catname['category'] == "Water Reading"){
										$MeterID = " - " . $joblist['MeterID'];
									}else if($catname['category'] == "Gas Reading"){
										$MeterID = " - " . $joblist['MeterID'];
									}else{
										$MeterID = "";
									}

									echo $span ." ". $trabaho . $MeterID ."<br/>";
								}
							}else{
								echo $complaintstatus." ".$complaints['Complaint_Code'];
							}
				echo	"</td>						
						<td>";
							$mgaMeron = "";
							$arr = explode(",", $row['workerid']);
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
				echo	"</td>						
						<td style='z-index: 0;'>". $WOStat ."</td>
						<td style='z-index: 0;'>". $BillStat ."</td>
						<td style='z-index: 0;'>
							<div class='btn-group'>";
								if($row['Complaint_Series_No'] == ""){
									echo 	"<button class='btn btn-primary btn-sm hide isadmin select-viewworkorderlist select-resolveworkorder btn-round' title='View Work Order' onclick='fncViewWODetails(\"".  $row['workorderid'] ."\", \"". $row['TenantID'] . "\", \"". $row['xstatus'] . "\", \"". $row['Complaint_Series_No'] . "\");' style='margin: 2px;'><img src='assets/images/wrench.png' style='width: 100%; height: auto;' /></button>";
									if($row['xstatus'] == "Pending"){
										echo	"<button class='btn btn-danger btn-sm hide isadmin select-cancelworkorder btn-round' title='Cancel Work Order' onclick='cancelJO(\"".  $row['workorderid'] ."\")' style='margin: 2px;'><img src='assets/images/remove.png' style='width: 100%; height: auto;' /></button>";
									}else if($row['xstatus'] == "Resolved" && $row['postingstatus'] != "Posted"){
										echo 	"<button class='btn btn-warning btn-sm hide isadmin select-postingofcharges btn-round' title='Post to Billing' onclick='fncPostWorkOrder(\"".  $row['workorderid'] ."\");' style='margin: 2px;'><i class='fa fa-bank'></i></button>";
									}
									echo 	"<button class='btn btn-default btn-sm hide isadmin select-printworkorder btn-round' title='Print Work Order' onclick='printJO(\"".  $row['workorderid'] ."\",  \"". $row['TenantID'] . "\", \"". $row['mallid'] . "\")' style='margin: 2px;'><img src='assets/images/printer.png' style='width: 100%; height: auto;' /></button>";
								}else{
									echo 	"<button class='btn btn-primary btn-sm hide isadmin select-viewworkorderlist select-resolveworkorder btn-round' title='View Work Order' onclick='ViewWOdetailedcomplaint(\"".  $row['workorderid'] ."\", \"". $row['TenantID'] . "\", \"". $row['Complaint_Series_No'] . "\", \"".  $row['xstatus'] ."\", \"". $row['departmentid'] ."\")' style='margin: 2px;'><img src='assets/images/wrench.png' style='width: 100%; height: auto;' /></button>";
									if($row['xstatus'] == "Pending"){
										echo	"<button class='btn btn-danger btn-sm hide isadmin select-cancelworkorder btn-round' title='Cancel Work Order' onclick='cancelJO(\"".  $row['workorderid'] ."\")' style='margin: 2px;'><img src='assets/images/remove.png' style='width: 100%; height: auto;' /></button>";
									}
									echo		"<button class='btn btn-default btn-sm hide isadmin select-printworkorder btn-round' title='Print Work Order' onclick='printcomplaint(\"". $row['Complaint_Series_No'] . "\", \"". $row['mallid'] . "\")' style='margin: 2px;'><img src='assets/images/printer.png' style='width: 100%; height: auto;' /></button>";
								}
				echo		"</div>
						</td>
					</tr>";
			}
		break;      

		case 'loadentriesjo':
        	$getFilters = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'Maintenance' AND userid = '". $_SESSION['MMS-UserID'] ."';", $connection));
		    $Status = explode("|", $getFilters["bystat"]);
		    $Search = explode("|", $getFilters["checked_value"]);
			$UnitType = explode("|", $getFilters["xcheck"]);
		    $Date = explode("|", $getFilters["datefilter"]);

		    // FILTER BY STATUS
			$StatusCount = 0; $SelectedStatus = "";
			for($a = 0; $a<=count($Status)-2; $a++){
				if($Status[$a] == "Pending"){ 
					$StatusVal = "xstatus = 'Pending'"; 
				}else if($Status[$a] == "Resolved"){
					$StatusVal = "xstatus = 'Resolved'"; 
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

            $rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM tblmaintenance_workorder WHERE ". $StatFilter ." ". $SearchFilter ." ". $DateFilter ." ". getMallAccess("mallid", "AND") .";", $connection));
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

		case "loadpagejo":
		    $getFilters = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'Maintenance' AND userid = '". $_SESSION['MMS-UserID'] ."';", $connection));
		    $Status = explode("|", $getFilters["bystat"]);
		    $Search = explode("|", $getFilters["checked_value"]);
			$UnitType = explode("|", $getFilters["xcheck"]);
		    $Date = explode("|", $getFilters["datefilter"]);

		    // FILTER BY STATUS
			$StatusCount = 0; $SelectedStatus = "";
			for($a = 0; $a<=count($Status)-2; $a++){
				if($Status[$a] == "Pending"){ 
					$StatusVal = "xstatus = 'Pending'"; 
				}else if($Status[$a] == "Resolved"){
					$StatusVal = "xstatus = 'Resolved'"; 
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
			$rowCount = mysql_fetch_row(mysql_query("SELECT COUNT(*) FROM tblmaintenance_workorder WHERE ". $StatFilter ." ". $SearchFilter ." ". $DateFilter ." ". getMallAccess("mallid", "AND") .";", $connection));
			$rowsperpage = 20;
			$range = 3;
			$totalpages = ceil($rowCount[0] / $rowsperpage);
			$prevpage;
			$nextpage;
			// if not on page 1, don't show back links
			if($page > 1 ){
			   	echo "<li style='width:50px !important;' onclick='paginationjo(1)'><< First</li>";
			   	$prevpage = $page - 1;
			   	echo "<li style='width:70px !important;' onclick='paginationjo(". $prevpage .")'>< Previous</li>";
			}

			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if(($x > 0) && ($x <= $totalpages)){
    			    if($x == $page){
                        echo "<li id='pgjo" . $x . "' class='pgnumjo active' onclick='paginationjo(" . $x . ",". $x .")'>" . $x . "</li>";
                    }else{
    			        echo "<li id='pgjo" . $x . "' class='pgnumjo' onclick='paginationjo(" . $x . ",". $x .")'>" . $x . "</li>";
                    }
		       	}
		    }
		    if($page < ($totalpages - $range)){
                echo "<li>...</li>";
            }
		    if($page != $totalpages && $rowCount[0] != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='paginationjo(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='paginationjo(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'cancelJO':
			$tenantid = mysql_fetch_array(mysql_query("SELECT tenantid FROM tblmaintenance_workorder WHERE workorderid = '". $_POST['deletemokokoya'] ."';", $connection));
			$tenantinfo = mysql_fetch_array(mysql_query("SELECT unitid, ustatus FROM tbltrans_tenants WHERE tenantid = '". $tenantid[0] ."';", $connection));

			// UPDATING OF UNIT STATUS LOGS
			$getcatid = mysql_query("SELECT xcategory, reading_date, tenantid, meter_img FROM tblmaintenance_workorderlist WHERE workorderid = '". $_POST['deletemokokoya'] ."';", $connection);
			while($rowcatid = mysql_fetch_array($getcatid)){

				$catname = mysql_fetch_array(mysql_query("SELECT category FROM tblmaintenance_category WHERE category_id = '". $rowcatid[0] ."';", $connection));
				if($catname[0] == "Electric Reading"){
					$field = "electricstat = '0'";
				}else if($catname[0] == "Water Reading"){
					$field = "waterstat = '0'";
				}else if($catname[0] == "Gas Reading"){
					$field = "gasstat = '0'";
				}
				unlink("../".$rowcatid[3]);

				$updatefp = mysql_query("UPDATE tblunit_statuslogs SET ". $field ." WHERE tenantid = '". $rowcatid[2] ."' AND xdate = '". date('Y-m-d', strtotime($rowcatid[1])) ."';", $connection);
			}

			// DELETE WORK ORDER
			$sql = "DELETE FROM tblmaintenance_workorder WHERE workorderid = '". $_POST['deletemokokoya'] ."';";
			$res = mysql_query($sql, $connection);
			if($res == true){
				echo 1;
				$list = mysql_query("DELETE FROM tblmaintenance_workorderlist WHERE workorderid = '". $_POST['deletemokokoya'] ."';", $connection);
				if($list == true){
					// UPDATE PLOTTED UNIT STATUS
					$status = mysql_fetch_array(mysql_query("SELECT DISTINCT(xstatus) FROM tblmaintenance_workorder WHERE TenantID = '". $tenantid[0] ."' ORDER BY xstatus ASC;", $connection));
					if($status[0] == "Resolved" || $status[0] == ""){
						$updateup = mysql_query("UPDATE tblref_unitplot SET status = '". $tenantinfo[1] ."' WHERE unitid = '". $tenantinfo[0] ."';", $connection);
					}
				}
			}
		break;

		case 'fncShowUserDepartment':
            $result = mysql_query("SELECT groupid, groupname FROM tblref_groupaccess ORDER BY groupname ASC;", $connection);
            while( $row = mysql_fetch_array ($result)){
                echo "<option value='". $row[0] ."'>". $row[1] ."</option>";
            }
		break;

		case 'fncShowPersonnel':
			$res = mysql_query("SELECT userid, CONCAT(firstname, ' ', lastname) FROM tbluser WHERE (groupaccess = '". $_POST['Department'] ."' AND groupaccess != '') AND isActive = '1';", $connection);
			while($row = mysql_fetch_array($res)){
				echo "<option value='". $row[0] ."'>". $row[1] ."</option>";
			}
		break;

		case 'fncloadSelectFilterCategory':
			$res = mysql_query("SELECT category_id, category FROM tblmaintenance_category ORDER BY category ASC;", $connection);
			while($row = mysql_fetch_array($res)){
				echo "<option value='". $row[0] ."'>". $row[1] ."</option>";
			}
		break;

		case 'fncLoadAddTask':
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
			$res = mysql_query("SELECT b.category_id, a.taskid, b.category, a.description, a.amount, b.isReading FROM tblmaintenance_tasklist AS a LEFT JOIN tblmaintenance_category AS b ON a.xcategory = b.category_id WHERE (b.category LIKE '%". $_POST['key'] ."%' OR a.description LIKE '%". $_POST['key'] ."%') ". $isCategory ." ". $isTaskID ." ORDER BY b.category, a.description ASC;", $connection);
			while($row = mysql_fetch_array($res)){
				echo 	"<tr id='". $row['category_id'] ."-". $row['taskid'] ."'>
							<td class='TaskID hide'>". $row['taskid'] ."</td>
							<td class='TaskAmount2 hide'>". $row['amount'] ."</td>
							<td class='isReading hide'>". $row['isReading'] ."</td>
							<td class='MaintenanceCategory'>". $row['category'] ."</td>
							<td class='TaskDescription'>". $row['description'] ."</td>
							<td class='TaskAmount' style='text-align: right;'>". number_format($row['amount'], 2, '.', ',') ."</td>
						</tr>";
			}
		break;

		case 'fncCreateWorkOrder':
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
				$TenantIDList = $_POST['Tenant'];
				$TenantID = explode(",", $TenantIDList);
				$TenantCount = COUNT($TenantID)-1;
			}

			$PersonnelList = "";
			if($_POST['AllPersonnel'] == "Yes"){
				$resGetUserID = mysql_query("SELECT userid FROM tbluser WHERE isActive = '1' AND groupaccess = '". $_POST['Department'] ."';", $connection);
				$numGetUserID = mysql_num_rows($resGetUserID);
				if($numGetUserID == 1){
					$rowGetUserID = mysql_fetch_array($resGetUserID);
					$PersonnelList = $rowGetUserID['userid'];
				}else{
					while($rowGetUserID = mysql_fetch_array($resGetUserID)){
						$PersonnelList .= $rowGetUserID['userid'] .",";
					}
				}
			}else{
				$PersonnelList = $_POST['Personnel'];
			}

			$SomethingisCreated = 0;
			for ($a = 0; $a <= $TenantCount; $a++) { 
				$WorkorderID = createidno("WO", "tblmaintenance_workorder", "workorderid");
				$TenantInfo = mysql_fetch_array(mysql_query("SELECT TenantID, tradename, mallID, LMRElectric, LMRWater, LMRGas FROM tbltrans_tenants WHERE TenantID = '". $TenantID[$a] ."';", $connection));

				$forHeader = 0;
				$TaskID = explode("@", $_POST['TaskIDs']);
				for ($b = 0; $b <= count($TaskID)-2; $b++) { 
				$arr3 = explode("|", $TaskID[$b]);

					$getTaskWithMeterReading = mysql_query("SELECT a.taskid, a.xcategory, b.isReading, a.amount FROM tblmaintenance_tasklist AS a LEFT JOIN tblmaintenance_category AS b ON a.xcategory = b.category_id WHERE a.taskid = '". $arr3[0] ."';", $connection);
					while($rowgetTaskList = mysql_fetch_array($getTaskWithMeterReading)){

						if($rowgetTaskList['isReading'] == '1' || $rowgetTaskList['isReading'] == '2' || $rowgetTaskList['isReading'] == '3'){

							$getPrevReading = mysql_fetch_array(mysql_query("SELECT reading_date FROM tblmaintenance_workorderlist WHERE xtaskid = '". $rowgetTaskList['taskid'] ."' AND tenantid = '". $TenantID[$a] ."' ORDER BY reading_date DESC LIMIT 1;", $connection));

							if($getPrevReading['reading_date'] == "" || $getPrevReading['reading_date'] == "1970-01-01"){
								if($rowgetTaskList['isReading'] == '1'){
									$PrevReading = date('Y-m-d', strtotime($TenantInfo['LMRElectric']));
								}else if($rowgetTaskList['isReading'] == '2'){
									$PrevReading = date('Y-m-d', strtotime($TenantInfo['LMRWater']));
								}else if($rowgetTaskList['isReading'] == '3'){
									$PrevReading = date('Y-m-d', strtotime($TenantInfo['LMRGas']));
								}
							}else{
								$PrevReading = date('Y-m-d', strtotime($getPrevReading['reading_date']));
							}

							if($rowgetTaskList['isReading'] == '1'){
								$MeterType = "Electric";
							}else if($rowgetTaskList['isReading'] == '2'){
								$MeterType = "Water";
							}else if($rowgetTaskList['isReading'] == '3'){
								$MeterType = "Gas";
							}

							$resPrevReadingInfo = mysql_query("SELECT MAX(CurrentMeterUsage), MAX(SYSDATE), MeterID FROM tblref_meterLogs WHERE AssignedTenant = '". $TenantID[$a] ."' AND MeterType = '". $MeterType ."' AND SysDate >= '". date('Y-m-d', strtotime($PrevReading)) ."' GROUP BY MeterID ORDER BY SYSDATE ASC;", $connection);
							while($rowPrevReadingInfo = mysql_fetch_array($resPrevReadingInfo)){

								$resInsertWO = mysql_query("INSERT INTO tblmaintenance_workorderlist SET workorderid = '". $WorkorderID ."', xcategory = '". $rowgetTaskList['xcategory'] ."', xtaskid = '". $rowgetTaskList['taskid'] ."', xstatus = 'Not Posted', TenantID = '". $TenantID[$a] ."', reading_date = '". date('Y-m-d', strtotime($arr3[1])) ."', MeterID = '". $rowPrevReadingInfo['MeterID'] ."', CurrentMeterUsage = '". $rowPrevReadingInfo[0] ."', UsageStartDate = '". $rowPrevReadingInfo[1] ."';", $connection);

								if($resInsertWO == true){
									$forHeader++;
								}

							}

						}else{

							$resInsertWO = mysql_query("INSERT INTO tblmaintenance_workorderlist SET workorderid = '". $WorkorderID ."', xcategory = '". $rowgetTaskList['xcategory'] ."', xtaskid = '". $rowgetTaskList['taskid'] ."', xstatus = 'Not Posted', TenantID = '". $TenantID[$a] ."', sub_total = '". $rowgetTaskList['amount'] ."';", $connection);
							if($resInsertWO == true){
								$forHeader++;
							}

						}
					}

				}

				if($forHeader >= 1){
					$resInsertHeader = mysql_query("INSERT INTO tblmaintenance_workorder SET workorderid = '". $WorkorderID ."', TenantID = '". $TenantID[$a] ."', xdate = '". date('Y-m-d', strtotime(getsysdate())) ."', xtime = '". date('H:i:s') ."', departmentid = '". $_POST['Department'] ."', remarks = '". $_POST['Remarks'] ."', workerid = '". $PersonnelList ."', tradename = '". $TenantInfo['tradename'] ."', mallid = '". $TenantInfo['mallID'] ."';", $connection);
					$SomethingisCreated++;
				}
			}
			
			if($SomethingisCreated >= 1){
				echo "1|Work order successfully saved.";
			}else{
				echo "2|Failed to save work order.";
			}
		break;

		case 'fncViewWODetails':
			$TenantInfo = mysql_fetch_array(mysql_query("SELECT TenantID, tradename, companyname, mallid, tradeID, CompanyID FROM tbltrans_tenants WHERE TenantID = '". $_POST['TenantID'] ."';", $connection));
			$Mall = mysql_fetch_array(mysql_query("SELECT mallname FROM tblref_mall WHERE mallid = '". $TenantInfo['mallid'] ."';", $connection));
			$checkfilename = mysql_fetch_array(mysql_query("SELECT filename FROM tbltrans_tradename WHERE tradeID = '". $TenantInfo['tradeID'] ."';", $connection));
			$WODetails = mysql_fetch_array(mysql_query("SELECT departmentid, workerid, startdate, enddate, starttime, endtime, duration, xstatus FROM tblmaintenance_workorder WHERE workorderid = '". $_POST['WorkOrderID'] ."';", $connection));
            $getTradePrimaryContact = mysql_fetch_array(mysql_query("SELECT CASE WHEN MiddleName = '' OR MiddleName IS NULL THEN CONCAT(LastName, ', ', FirstName) ELSE CONCAT(LastName, ', ', FirstName, ' ', LEFT(MiddleName, '1'), '.') END FROM tbltrans_trade_contact_person WHERE TradeID = '". $TenantInfo['tradeID'] ."';", $connection));

			if($checkfilename['filename'] == ""){
				$Image = "assets/images/noimage5.png";
			}else{
				if(!file_exists("../../../Mall_Attachments/company/". $TenantInfo['CompanyID'] ."/trades/". $TenantInfo['tradeID'] ."/". $checkfilename['filename'])){ 
                	$Image = "assets/images/noimage5.png";
				}else{
					$Image = "../Mall_Attachments/company/". $TenantInfo['CompanyID'] ."/trades/". $TenantInfo['tradeID'] ."/". $checkfilename['filename'];
				}
			}

			if($WODetails['startdate'] == "" || $WODetails['startdate'] == "1970-01-01"){
				$StartDate = date('m/d/Y');
			}else{
				$StartDate = date('m/d/Y', strtotime($WODetails['startdate']));
			}

			if($WODetails['enddate'] == "" || $WODetails['enddate'] == "1970-01-01"){
				$EndDate = "";
			}else{
				$EndDate = date('m/d/Y', strtotime($WODetails['enddate']));
			}

			if($WODetails['starttime'] == "" || $WODetails['starttime'] == "00:00:00"){
				$StartTime = date('H:i');
			}else{
				$StartTime = $WODetails['starttime'];
			}

			if($WODetails['endtime'] == "" || $WODetails['endtime'] == "00:00:00"){
				$EndTime = "";
			}else{
				$EndTime = $WODetails['endtime'];
			}

			echo $Image . "|" . $TenantInfo['tradename'] . "|" . $TenantInfo['TenantID'] . "|" . $TenantInfo['companyname'] . "|" . $Mall['mallname'] . "|" . $getTradePrimaryContact[0] . "|" . $StartDate . "|" . $EndDate . "|" . $StartTime . "|" . $EndTime . "|" . $WODetails['departmentid'] . "|" . $WODetails['workerid'] . "|" . $WODetails['xstatus'];
		break;

		case 'fncSaveWOSchedule':
			if($_POST['EndDate'] == ""){
				$enddate = "";
			}else{
				$enddate = ", enddate = '". date('Y-m-d', strtotime($_POST['EndDate'])) ."'";
			}
			if($_POST['EndTime'] == ""){
				$endtime = "";
			}else{
				$endtime = ", endtime = '". $_POST['EndTime'] ."'";
			}
			$res = mysql_query("UPDATE tblmaintenance_workorder SET startdate = '". date('Y-m-d', strtotime($_POST['StartDate'])) ."', starttime = '". $_POST['StartTime'] ."',  departmentid = '". $_POST['AssignedDepartment'] ."', workerid = '". $_POST['AssignedPersonnel'] ."' ". $enddate ." ". $endtime ." WHERE workorderid = '". $_POST['WONumber'] ."';", $connection);
			if($res == true){
				echo 1;
			}else{
				echo 2;
			}
		break;

		case 'fncWorkOrderBreakdown':
			if($_POST['ComplaintSeriesNo'] == ""){
				$frmCount = 0;
				$resCatList = mysql_query("SELECT xcategory FROM tblmaintenance_workorderlist WHERE workorderid = '". $_POST['WorkOrderID'] ."' GROUP BY xcategory;", $connection);
				while($rowCatList = mysql_fetch_array($resCatList)){

					$refCategory = mysql_fetch_array(mysql_query("SELECT isReading, category FROM tblmaintenance_category WHERE category_id = '". $rowCatList['xcategory'] ."';", $connection));

                	$WorkOrderInfo = mysql_fetch_array(mysql_query("SELECT xdate, postingstatus FROM tblmaintenance_workorder WHERE workorderid = '". $_POST['WorkOrderID'] ."';", $connection));

	                if($refCategory['isReading'] == '1' || $refCategory['isReading'] == '2' || $refCategory['isReading'] == '3'){

						$resTaskList = mysql_query("SELECT xtaskid, xcategory, taskstatus, meter_reading, sub_total, id, tenantid, meter_img, MeterID, CurrentMeterUsage, UsageStartDate, reading_date FROM tblmaintenance_workorderlist WHERE workorderid = '". $_POST['WorkOrderID'] ."' AND xcategory = '". $rowCatList['xcategory'] ."';", $connection);
						while($rowTaskList = mysql_fetch_array($resTaskList)){

		                	$getMultiplier = mysql_fetch_array(mysql_query("SELECT Multiplier FROM tblref_meter WHERE MeterID = '". $rowTaskList['MeterID'] ."';", $connection));

			            	$TenantInfo = mysql_fetch_array(mysql_query("SELECT mallID, datefrom FROM tbltrans_tenants WHERE TenantID = '". $rowTaskList['tenantid'] ."';", $connection));

			            	if($refCategory['isReading'] == '1'){
			            		$BillingFactor = getUtilRate('Electric', $TenantInfo['mallID'], $rowTaskList['reading_date']);
			            		$MeterType = "Electric";
			            		$MinimumConsumption = explode("|", getrentvattype($TenantInfo['mallID']))[10];
			            	}else if($refCategory['isReading'] == '2'){
			            		$BillingFactor = getUtilRate('Water', $TenantInfo['mallID'], $rowTaskList['reading_date']);
			            		$MeterType = "Water";
			            		$MinimumConsumption = explode("|", getrentvattype($TenantInfo['mallID']))[11];
			            	}else  if($refCategory['isReading'] == '3'){
			            		$BillingFactor = getUtilRate('Gas', $TenantInfo['mallID'], $rowTaskList['reading_date']);
			            		$MeterType = "Gas";
			            		$MinimumConsumption = explode("|", getrentvattype($TenantInfo['mallID']))[12];
			            	}
			            	
							if($rowTaskList['meter_reading'] == 0){
			            		$Difference = 0;
			            	}else{
			            		$Difference = $rowTaskList['meter_reading'] - $rowTaskList['CurrentMeterUsage'];
			            	}

			            	if($rowTaskList['CurrentMeterUsage'] == ""){
			            		$PreviousReading = 0;
			            	}else{
			            		$PreviousReading = $rowTaskList['CurrentMeterUsage'];
			            	}

			            	if($WorkOrderInfo['postingstatus'] == 'Posted'){
			            		$CurrentReading = number_format($rowTaskList['meter_reading'], 5, '.', ',');
			            		$isPosted = "hide";
			            		$isPosted2 = "";
			            		$ReadingDate = date('m/d/Y',strtotime($rowTaskList['reading_date']));
			            		if($rowTaskList['meter_img'] == ""){
			            			$MeterImg = "No attached file.";
				            	}else{
				            		$MeterImg = "<a class='btn btn-xs btn-purple btn-round' onclick='viewdocuimgindex(\"". $rowTaskList['meter_img'] ."\")' title='view image' style='margin: 5px;'><i class='ace-icon fa fa-picture-o bigger-120'></i></a>
				            					<a href='". $rowTaskList['meter_img'] ."' download  class='btn btn-xs btn-info btn-round'><i style='color:white !important;' class='ace-icon fa fa-arrow-down bigger-120'></i></a>";
				            	}
			            	}else{
			            		$CurrentReading = "<input type='text' class='numberlang halaga2 input-sm form-control' name='txtCurrentReading' id='txtCurrentReading". $MeterType . $frmCount ."' value='". number_format($rowTaskList['meter_reading'], 5, '.', ',') ."' style='border: none;padding-left: 0; color: #393939; height: 21px;' onkeyup='fncGetTotalConsumpAmount(\"". $PreviousReading ."\", this.value, \"". $MeterType ."\", \"". $frmCount ."\", \"". $rowTaskList['MeterID'] ."\")'>";
			            		$isPosted = "";
			            		$isPosted2 = "style='background-color: white;'";
			            		$ReadingDate = "<input type='text' class='date-picker input-sm form-control' name='txtReadingDate' id='txtReadingDate". $MeterType . $frmCount ."' value='". date('m/d/Y',strtotime($rowTaskList['reading_date'])) ."' style='border: none;padding-left: 0; color: #393939; height: 21px;'>";
			            		if($rowTaskList['meter_img'] == ""){
				            		$MeterImg = "<input type='file' class='MainAttachFile' name='meter_image' accept='image/*' onChange='checkfiletype(this.value, \"". $MeterType . $frmCount . "\");' id='txtwofile". $MeterType . $frmCount ."'>";
				            	}else{
				            		$MeterImg = "<a class='btn btn-xs btn-purple btn-round' onclick='viewdocuimgindex(\"". $rowTaskList['meter_img'] ."\")' title='view image' style='margin-bottom: 10px;'><i class='ace-icon fa fa-picture-o bigger-120'></i></a>
				            					<a href='". $rowTaskList['meter_img'] ."' download  class='btn btn-xs btn-info btn-round' style='margin-bottom: 10px;'><i style='color:white !important;' class='ace-icon fa fa-arrow-down bigger-120'></i></a>";
				            	}
			            	}

			            	$Consumption = $Difference * $getMultiplier['Multiplier'];

			            	if($rowTaskList['meter_reading'] >= 1){
			            		if($Consumption >= $MinimumConsumption){
				            		$TotalConsumption = number_format($Consumption, 5, '.', ',');
				            		$TextColor = "#393939";
				            		$isAlert = "hide";
				            	}else{
				            		$TotalConsumption = number_format($MinimumConsumption, 5, '.', ',');
				            		$TextColor = "#a94442";
				            		$isAlert = "";
				            	}
			            	}else{
			            		$TotalConsumption = "0.00000";
			            		$TextColor = "#393939";
			            		$isAlert = "hide";
			            	}
				            	

							echo 	"<div class='row form-group'>
                                        <div class='col-xs-12'>
                                            <h4 class='blue header bolder'>". $refCategory['category'] ."</h4>
                                        </div>
                                        <div class='col-xs-6'>
                                            <div class='row form-group'>
                                                <div class='profile-user-info profile-user-info-striped'>
                                                    <div class='profile-info-row' style='padding: 10px;'>
                                                        <div class='profile-info-name' style='white-space: nowrap;'> Meter ID </div>
                                                        <div class='profile-info-value'>
                                                            <label>". $rowTaskList['MeterID'] ."</label>
                                                        </div>
                                                    </div>
                                                    <div class='profile-info-row' style='padding: 10px;'>
                                                        <div class='profile-info-name' style='white-space: nowrap;'> Previous Reading Date </div>
                                                        <div class='profile-info-value'>
                                                            <label>". date('m/d/Y',strtotime($rowTaskList['UsageStartDate'])) ."</label>
                                                        </div>
                                                    </div>
                                                    <div class='profile-info-row'>
                                                        <div class='profile-info-name' style='white-space: nowrap;'> Previous Reading </div>
                                                        <div class='profile-info-value'>
                                                            <label>". number_format($PreviousReading, 5, '.', ',') ."</label>
                                                        </div>
                                                    </div>
                                                    <div class='profile-info-row'>
                                                        <div class='profile-info-name' style='white-space: nowrap;'> Total Consumption </div>
                                                        <div class='profile-info-value'>
                                                            <label style='color: ". $TextColor ."' id='txtTC". $MeterType . $frmCount ."'>". $TotalConsumption ."</label>
                                                        </div>
                                                    </div>
                                                    <div class='profile-info-row'>
                                                        <div class='profile-info-name' style='white-space: nowrap;'> Amount </div>
                                                        <div class='profile-info-value'>
                                                            <label id='txtAmount". $MeterType . $frmCount ."'>". number_format($rowTaskList['sub_total'], 5, '.', ',') ."</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='col-xs-6'>
                                            <div class='row form-group'>
                                            <form id='postingmetereading". $MeterType . $frmCount ."' name='postingmetereading'>
	                        					<input type='hidden' name='txtWorkOrderID' value='". $_POST['WorkOrderID'] ."'>
				             					<input type='hidden' name='txtCategoryID' value='". $rowTaskList['xcategory'] ."'>
				             					<input type='hidden' name='txtCategoryName' value='". $refCategory['category'] ."'>
				             					<input type='hidden' name='txtTaskID' value='". $rowTaskList['id'] ."'>
				             					<input type='hidden' name='txtMeterID' value='". $rowTaskList['MeterID'] ."'>
				             					<input type='hidden' name='txtMeterType' value='". $MeterType ."'>
                                                <div class='profile-user-info profile-user-info-striped'>
                                                    <div class='profile-info-row'>
                                                        <div class='profile-info-name' style='white-space: nowrap;'> Multiplier </div>
                                                        <div class='profile-info-value'>
                                                            <label>". number_format($getMultiplier['Multiplier'], 5, '.', ',') ."</label>
                                                        </div>
                                                    </div>
	                            					
                                                    <div class='profile-info-row'>
                                                        <div class='profile-info-name' style='white-space: nowrap;'> Reading Date </div>
                                                        <div class='profile-info-value' ". $isPosted2 .">
                                                            <label>". $ReadingDate ."</label>
                                                        </div>
                                                    </div>
                                                    <div class='profile-info-row'>
                                                        <div class='profile-info-name' style='white-space: nowrap;'> Current Reading </div>
                                                        <div class='profile-info-value' ". $isPosted2 .">
                                                            <label>". $CurrentReading ."</label>
                                                        </div>
                                                    </div>
                                                    <div class='profile-info-row'>
                                                        <div class='profile-info-name' style='white-space: nowrap;'> Billing Factor </div>
                                                        <div class='profile-info-value'>
                                                            <label>". number_format($BillingFactor, 5, '.', ',') ."</label>
                                                        </div>
                                                    </div>
                                                    <div class='profile-info-row'>
                                                        <div class='profile-info-name' style='white-space: nowrap;'> Attachment </div>
                                                        <div class='profile-info-value' id='divRemovefile". $MeterType . $frmCount ."'>
                                                            <label style='height: 20px;'>". $MeterImg ."</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='row form-group'>
                                        <div class='col-md-6 ". $isAlert ."' id='divAlert". $MeterType . $frmCount ."'>
                                    		<div class='row form-group'>
                                        		<div class='col-md-12'>
													<div class='alert alert-danger'>
														<i class='ace-icon fa fa-exclamation-triangle'></i>
														Applied the min. consumption charge
													</div>
												</div>
                                        	</div>
                                        </div>
                                        <div class='col-md-2 pull-right ". $isPosted ."'>
                             				<div class='btn-group pull-right'>
                             					<button class='btn btn-sm btn-info btn-round' onclick='fncSaveMeterReading(\"". $MeterType . $frmCount ."\", \"". $PreviousReading ."\");'><i class='fa fa-check'></i> Save</button>
                             				</div>
                         				</div>
	                                </div>";
		                	$frmCount++;
			            }
	                }else{
	                	echo 	"<div class='row form-group'>
	                            	<h4 class='green smaller lighter center' style='font-weight: bold;'>". $refCategory['category'] ."</h4>
	                         		<div class='col-md-12'>
	                         			<table class='table table-bordered' style='width: 100%;'>
											<tr>
												<th style='width: 65%;'>Task Name</th>
						                        <th style='width: 10%;'>Status</th>
						                        <th style='width: 10%;'>Hours</th>
						                        <th style='width: 10%;'>Amount</th>
						                        <th style='width: 5%;'>Schedule</th>
						                    </tr>
						                    <tbody>";
						                    $resTaskList2 = mysql_query("SELECT xtaskid, id, taskstatus, schedduration, sub_total FROM tblmaintenance_workorderlist WHERE workorderid = '". $_POST['WorkOrderID'] ."' AND xcategory = '". $rowCatList[0] ."' ORDER BY id DESC;", $connection);
										            while($rowTaskList2 = mysql_fetch_array($resTaskList2)){
										            	$rowTaskInfo = mysql_fetch_array(mysql_query("SELECT description, amount, id FROM tblmaintenance_tasklist WHERE taskid = '". $rowTaskList2[0] ."';", $connection));
										            	if($rowTaskList2['xtaskid'] != ""){
										            		if($rowTaskList2['taskstatus'] == 'Pending') {
																$Status = '<span class="label label-lg label-warning arrowed-in-right arrowed" style="z-index: 0;">'. $rowTaskList2['taskstatus'] .'</span>';
															}else if($rowTaskList2['taskstatus'] == 'Resolved'){
																$Status = '<span class="label label-lg label-success arrowed-in-right arrowed" style="z-index: 0;">'. $rowTaskList2['taskstatus'] .'</span>';
															}
										            	echo 	"<tr>
											            			<td style='vertical-align: middle;'>". $rowTaskInfo[0] ."</td>
											            			<td style='vertical-align: middle;'>". $Status ."</td>
											            			<td style='vertical-align: middle;'>". number_format($rowTaskList2['schedduration'], 1, '.', '') ."</td>
											            			<td style='text-align: right; vertical-align: middle;'>". number_format($rowTaskList2['sub_total'], 2, '.', ',') ."</td>
											            			<td style='vertical-align: middle;'><button class='btn btn-sm btn-info btn-round' title='Edit Schedule' style='z-index: 0;margin: 2px;' onclick='showschedule(\"".  $rowCatList[0] ."\", \"".  $rowTaskList2['xtaskid'] ."\", \"".  $_POST['WorkOrderID'] ."\", \"". $rowTaskInfo[0] ."\", \"". $rowTaskList2['taskstatus'] ."\",  \"". $rowTaskList2['id'] ."\", \"". number_format($rowTaskList2['sub_total'], 2, '.', ',') ."\")'><img src='assets/images/calendar2.png' style='width: 100%; height: auto;' /></button></td>
										            			</tr>";
										            	}
										            } 
							        echo   	"</tbody>
						             	</table>
	                         		</div>
	                         	</div>";
	                }
				}
			}else{
				echo	"<table class='table table-bordered' style='width: 100%;margin-bottom: 20px;'>
							<tr>
								<th style='background-color: #666;' colspan='12'><center>Complaint</center></th>
							</tr>
							<tr>
								<th style='width: 30%;'>Complaint Code</th>
		                        <th style='width: 35%;'>Complaint Description</th>
		                        <th style='width: 10%;'>Status</th>
		                        <th style='width: 15%;'>Total Duration</th>
		                        <th style='width: 10%;'>Amount</th>
		                    </tr>";
		            $sql = "SELECT Complaint_Code, Complete_Description, Complaint_Status FROM tblcomplaints WHERE Complaint_Series_No = '". $_POST['ComplaintSeriesNo'] ."';";
		            $res = mysql_query($sql, $connection);
		            while($row = mysql_fetch_array($res)){
		            	$complaint = mysql_fetch_array(mysql_query("SELECT duration, totalamount FROM tblmaintenance_workorder WHERE Complaint_Series_No = '". $_POST['ComplaintSeriesNo'] ."';", $connection));
		            	echo "<tr onclick='resolvingofcomplaint(\"".  $_POST['ComplaintSeriesNo'] ."\", \"".  $row[2] ."\")'>
		            			<td style='width: 30%; vertical-align: middle;'>".$row[0]."</td>
		            			<td style='width: 35%; vertical-align: middle;'>".$row[1]."</td>
		            			<td style='width: 10%; vertical-align: middle;'>".$row[2]."</td>
		            			<td style='width: 15%; vertical-align: middle;'>".$complaint[0]."</td>
		            			<td style='width: 10%;text-align: right; vertical-align: middle;'>".$complaint[1]."</td>
		            		</tr>";
		            }
		        echo "</table>";
			}
		break;

		case 'fncGetTotalConsumpAmount':
			$getMultiplier = mysql_fetch_array(mysql_query("SELECT Multiplier FROM tblref_meter WHERE MeterID = '". $_POST['MeterID'] ."';", $connection));
			if($_POST['MeterType'] == "Electric"){
				$UtilRate = getUtilRate('Electric', $_SESSION['MMS-Designation'], date('Y-m-d', strtotime($_POST['ReadingDate'])));
				$MinimumConsumption = explode("|", getrentvattype($_SESSION['MMS-Designation']))[10];
			}else if($_POST['MeterType'] == "Water"){
				$UtilRate = getUtilRate('Water', $_SESSION['MMS-Designation'], date('Y-m-d', strtotime($_POST['ReadingDate'])));
				$MinimumConsumption = explode("|", getrentvattype($_SESSION['MMS-Designation']))[11];
			}else if($_POST['MeterType'] == "Gas"){
				$UtilRate = getUtilRate('Gas', $_SESSION['MMS-Designation'], date('Y-m-d', strtotime($_POST['ReadingDate'])));
				$MinimumConsumption = explode("|", getrentvattype($_SESSION['MMS-Designation']))[12];
			}

			$Consumption = floatval($_POST['CurrReading']) - floatval($_POST['PrevReading']);

			if($_POST['CurrReading'] >= $_POST['PrevReading']){
	    		if($Consumption >= $MinimumConsumption){
	        		$TotalConsumption = floatval($Consumption);
            		$TextColor = "#393939";
            		$isAlert = "0";
	    		}else{
	        		$TotalConsumption = floatval($MinimumConsumption);
            		$TextColor = "#a94442";
            		$isAlert = "1";
	    		}
			}else{
	    		$TotalConsumption = "0.00000";
        		$isAlert = "0";
			}

			$BillAmount = floatval($UtilRate) * floatval($TotalConsumption * $getMultiplier['Multiplier']);

			echo number_format($TotalConsumption, 5, '.', ',') . "|" . number_format($BillAmount, 5, '.', ',') . "|" . $TextColor . "|" . $isAlert;
		break;

		case 'saveschedline':
			$duration = explode("|", $_POST['duration']);
	    	for($i=0; $i<=count($duration)-2; $i++){
	    		$data2 = explode(".", $duration[$i]);
				$total += ($data2[0]*60) + $data2[1];
	    	}
	    	$hours2 = floor($total/60);
	    	$minutes = $total-($hours2*60);
	    	$totalduration = $hours2.".".$minutes;

			$arr = explode("|", $_POST['ids']);
			$res = mysql_query("UPDATE tblmaintenance_workorderlist SET schedline = '". $_POST['schedline'] ."', taskstatus = '". $_POST['stat'] ."', schedduration = '". $totalduration ."', sub_total = '". floatval($_POST['Amount']) ."' WHERE workorderid = '". $arr[2] ."' AND xtaskid = '". $arr[1] ."' AND xcategory = '". $arr[0] ."' AND id = '". $arr[3] ."';", $connection);
			$WorkOrderInfo = mysql_fetch_array(mysql_query("SELECT Complaint_Series_No FROM tblmaintenance_workorder WHERE workorderid = '". $arr[2] ."'", $connection));
			if($res == true){
				$getAllStatus = mysql_fetch_array(mysql_query("SELECT taskstatus FROM tblmaintenance_workorderlist WHERE workorderid = '". $arr[2] ."' ORDER BY taskstatus ASC LIMIT 1;", $connection));
				$resUpdateWOHeader = mysql_fetch_array(mysql_query("UPDATE tblmaintenance_workorder SET xstatus = '". $getAllStatus['taskstatus'] ."' WHERE workorderid = '". $arr[2] ."';", $connection));
				echo "1|". $arr[2] . "|" . $WorkOrderInfo['Complaint_Series_No'];
			}else{
				echo "2|";
			}
		break;

		case 'showschedule':
			$sql = " SELECT schedline, taskstatus FROM tblmaintenance_workorderlist WHERE xtaskid = '". $_POST['taskid'] ."' AND workorderid = '". $_POST['workorderid'] ."' AND xcategory = '". $_POST['catid'] ."' ";
			$res = mysql_query($sql, $connection);
			$row = mysql_fetch_array($res);

			if($row[0] == ""){
				?>
					<tr>
                        <td width="3%"><div class="checkbox"><label><input type="checkbox" class="ace cbschedline"><span class="lbl"></span></label></div></td>
                        <td><input type="text" class="date-picker schedline slstartdate" data-provide="datepicker" value="<?php echo date('m/d/Y'); ?>" id="slstartdate-1" onchange="getduration(this.id);"></td>
                        <td><input type="text" class="date-picker schedline slenddate" data-provide="datepicker" value="<?php echo date('m/d/Y'); ?>" id="slenddate-1" onchange="getduration(this.id);"></td>
                        <td><input type="time" class="schedline slstarttime schedlinetime" id="slstarttime-1" onchange="getduration(this.id);"></td>
                        <td><input type="time" class="schedline slendtime schedlinetime" id="slendtime-1" onchange="getduration(this.id);"></td>
                        <td><input type="text" size="4" class="schedline slduration numberlang" id="slduration1" disabled></td>
                    </tr>
				<?php
			}else{
				$schedline = explode("#", $row[0]);
	            	for($i=0; $i<=count($schedline)-2; $i++){
	            		$data = explode("|", $schedline[$i]);
	            		?> 
	            		<tr>
                                <td width="3%"><div class="checkbox"><label><input type="checkbox" class="ace cbschedline" disabled><span class="lbl"></span></label></div></td>
                                <td><input type="text" class="date-picker schedline slstartdate" value="<?php echo $data[0]; ?>" id="slstartdate-1" disabled onchange="getduration(this.id);"></td>
                                <td><input type="text" class="date-picker schedline slenddate" value="<?php echo $data[1]; ?>" id="slenddate-1" disabled onchange="getduration(this.id);"></td>
                                <td><input type="time" class="schedline slstarttime schedlinetime" id="slstarttime-1" value="<?php echo $data[2]; ?>" disabled onchange="getduration(this.id);"></td>
                                <td><input type="time" class="schedline slendtime schedlinetime" id="slendtime-1" value="<?php echo $data[3]; ?>" disabled onchange="getduration(this.id);"></td>
                                <td><input type="text" size="4" class="schedline slduration numberlang" id="slduration1" value="<?php echo $data[4]; ?>" disabled></td>
                            </tr>
                        <?php
	            	}
				}

			echo "|" . $row[1];
		break;

		case 'printJOtenantinformation':
			$TenantInfo = mysql_fetch_array(mysql_query("SELECT tradename, tradeID FROM tbltrans_tenants WHERE TenantID = '". $_POST['TenantID'] ."';", $connection));
            $getTradePrimaryContact = mysql_fetch_array(mysql_query("SELECT CASE WHEN MiddleName = '' OR MiddleName IS NULL THEN CONCAT(LastName, ', ', FirstName) ELSE CONCAT(LastName, ', ', FirstName, ' ', LEFT(MiddleName, '1'), '.') END, ContactID FROM tbltrans_trade_contact_person WHERE TradeID = '". $TenantInfo['tradeID'] ."' AND isPrimary = '1' AND isActive = '1';", $connection));
            $getTradePrimaryContactNumber = mysql_fetch_array(mysql_query("SELECT content FROM tbltrans_trade_contact_person_list WHERE ContactID = '". $getTradePrimaryContact['ContactID'] ."' AND (type = 'mobile' OR type = 'telephone');", $connection));
			echo $TenantInfo['tradename'] . "|" . $getTradePrimaryContact[0] . "|" . $getTradePrimaryContactNumber['content'];
		break;

		case 'printJOjotasklistcontainer':
			$TotalMaintenanceCost = 0;
			$resTaskList = mysql_query("SELECT xcategory FROM tblmaintenance_workorderlist WHERE workorderid = '". $_POST['workorderid'] ."' GROUP BY xcategory;", $connection);
			while($rowTaskID = mysql_fetch_array($resTaskList)){
				$MaintenanceCategory = mysql_fetch_array(mysql_query("SELECT isReading, category FROM tblmaintenance_category WHERE category_id = '". $rowTaskID['xcategory'] ."';", $connection));
				if($MaintenanceCategory['isReading'] == '1' || $MaintenanceCategory['isReading'] == '2' || $MaintenanceCategory['isReading'] == '3'){

		            echo	"<table style='width: 100%;margin-bottom: 20px;border-collapse: collapse;page-break-inside: avoid;'>
		            			<tr>
									<th style='background-color: #666;color: white;border: 1px #666 solid;' colspan='12'><center>".$MaintenanceCategory['category']."</center></th>
								</tr>
								<tr>
									<th rowspan='2' style='width: 20%; border: 1px #666 solid;padding-left: 5px;padding-right: 5px;'>Meter</th>
									<th style='width: 35%; border: 1px #666 solid;padding-left: 5px;padding-right: 5px;' colspan='2'>Date of Reading</th>
			                        <th style='width: 35%; border: 1px #666 solid;padding-left: 5px;padding-right: 5px;' colspan='2'>Meter Reading</th>
			                        <th style='width: 10%; border: 1px #666 solid;padding-left: 5px;padding-right: 5px;' rowspan='2'>Amount</th>
			                    </tr>
			                    <tr>
			                    	<th style='border: 1px #666 solid;padding-left: 5px;padding-right: 5px;'>From</th>
			                    	<th style='border: 1px #666 solid;padding-left: 5px;padding-right: 5px;'>To</th>
			                    	<th style='border: 1px #666 solid;padding-left: 5px;padding-right: 5px;'>Previous</th>
			                    	<th style='border: 1px #666 solid;padding-left: 5px;padding-right: 5px;'>Current</th>
			                    </tr>";

			        $ActiveMeterCost = 0;
                	$resMeterReading = mysql_query("SELECT meter_reading, CurrentMeterUsage, UsageStartDate, sub_total, MeterID, reading_date FROM tblmaintenance_workorderlist WHERE workorderid = '". $_POST['workorderid'] ."' AND xcategory = '". $rowTaskID['xcategory'] ."';", $connection);
                	while($rowMeterReading = mysql_fetch_array($resMeterReading)){

                		if($MaintenanceCategory['isReading'] == '1'){
							$MeterType = "Electric";
							$UnitofMeasurement = "kwh";
						}else if($MaintenanceCategory['isReading'] == '2'){
							$MeterType = "Water";
							$UnitofMeasurement = "m³";
						}else if($MaintenanceCategory['isReading'] == '3'){
							$MeterType = "Gas";
							$UnitofMeasurement = "m³";
						}

	                    if($rowMeterReading['CurrentMeterUsage'] == "" || $rowMeterReading['CurrentMeterUsage'] == 0){
		            		$PreviousReading = "";
		            	}else{
		            		$PreviousReading = number_format($rowMeterReading['CurrentMeterUsage'], 5, '.', ',') ." ". $UnitofMeasurement;
		            	}

		            	if($rowMeterReading['meter_reading'] == "" || $rowMeterReading['meter_reading'] == 0){
		            		$CurrentReading = "";
		            	}else{
		            		$CurrentReading = number_format($rowMeterReading['meter_reading'], 5, '.', ',') ." ". $UnitofMeasurement;
		            	}
		            	
						echo	"<tr>
			                    	<td style='border: 1px #666 solid;padding-left: 5px;padding-right: 5px;font-size 10px;'>". $rowMeterReading['MeterID'] ."</td>
			                    	<td style='border: 1px #666 solid;padding-left: 5px;padding-right: 5px;font-size 10px;'>". date('m/d/Y',strtotime($rowMeterReading['UsageStartDate'])) ."</td>
			                    	<td style='border: 1px #666 solid;padding-left: 5px;padding-right: 5px;font-size 10px;'>". date('m/d/Y',strtotime($rowMeterReading['reading_date'])) ."</td>
			                        <td style='border: 1px #666 solid;padding-left: 5px;padding-right: 5px;font-size 10px;'>".
			                         $PreviousReading ."</td>
			                        <td style='border: 1px #666 solid;padding-left: 5px;padding-right: 5px;font-size 10px;'>". $CurrentReading ."</td>
			                        <td style='border: 1px #666 solid;padding-left: 5px;padding-right: 5px;font-size 10px;' align='right'>". number_format($rowMeterReading['sub_total'], 5, '.', ',') ."</td>
			                    </tr>";
						$ActiveMeterCost += $rowMeterReading['sub_total'];
                	}
		            	echo	"<tr>
			        				<td></td><td></td><td></td><td></td>
					 				<td style='border: 1px #666 solid;padding-left: 5px;padding-right: 5px;text-align: right;font-size 10px;'>Subtotal</td>
					 				<td style='border: 1px #666 solid;padding-left: 5px;padding-right: 5px;font-size 10px;' align='right'>".number_format($ActiveMeterCost, 5, '.', ',')."</td>
					 			</tr>";	
					$TotalMaintenanceCost += $ActiveMeterCost;
                }else{
                	echo 	"<table style='width: 100%;margin-bottom: 20px;border-collapse: collapse;page-break-inside: avoid;'>
										<tr>
											<th style='background-color: #666;color: white;border: 1px #666 solid;' colspan='12'><center>".$MaintenanceCategory['category']."</center></th>
										</tr>
										<tr>
											<th width='50%' style='border: 1px #666 solid;padding-left: 5px;padding-right: 5px;'>Task Name</th>
					                        <th width='15%' style='border: 1px #666 solid;padding-left: 5px;padding-right: 5px;'>Status</th>
					                        <th width='20%' style='border: 1px #666 solid;padding-left: 5px;padding-right: 5px;'>Total Duration</th>
					                        <th width='15%' style='border: 1px #666 solid;padding-left: 5px;padding-right: 5px;'>Amount</th>
					                    </tr>";
		            		$amount = 0;
		                	$resNotReadingList = mysql_query("SELECT xtaskid, id, taskstatus, schedline, sub_total FROM tblmaintenance_workorderlist WHERE workorderid = '". $_POST['workorderid'] ."' AND xcategory = '". $rowTaskID['xcategory'] ."';", $connection);
				            while($rowNotReadingList = mysql_fetch_array($resNotReadingList)){
				            	$TaskInfo = mysql_fetch_array(mysql_query("SELECT description FROM tblmaintenance_tasklist WHERE taskid = '". $rowNotReadingList[0] ."';", $connection));
				            	$totalduration = 0;
				            	$duration = explode("#", $rowNotReadingList['schedline']);
				            	for($i=1; $i<=count($duration); $i++){
				            		$duration2 = explode("|", $duration[$i]);
				            		$totalduration = $totalduration + $duration2[4];
				            	}
				            	$amount += floatval($rowNotReadingList['sub_total']);
				            	echo "<tr>
				            			<td style='border: 1px #666 solid;padding-left: 5px;padding-right: 5px;'>". $TaskInfo['description']."</td>
				            			<td style='border: 1px #666 solid;padding-left: 5px;padding-right: 5px;'>". $rowNotReadingList['taskstatus']."</td>
				            			<td style='border: 1px #666 solid;padding-left: 5px;padding-right: 5px;'>". number_format($totalduration, 1, '.', '')."</td>
				            			<td style='border: 1px #666 solid;padding-left: 5px;padding-right: 5px;' align='right'>".number_format($rowNotReadingList['sub_total'], 2, '.', ',')."</td>
				            		</tr>";
				            }
				            	echo	"<tr>
				            				<td></td><td></td>
							 				<td style='border: 1px #666 solid;padding-left: 5px;padding-right: 5px;'>Subtotal</td>
							 				<td style='border: 1px #666 solid;padding-left: 5px;padding-right: 5px;' align='right'>".number_format($amount, 2, '.', ',')."</td>
							 			</tr>";
				 			$gawain = $gawain + $amount;
                }
			}
			$GrandTotalAmount = $gawain + $TotalMaintenanceCost;
				echo "<tr><td colspan='6'>&nbsp;</td></tr><tr>
						<td></td><td></td><td></td>
						<td style='text-align:right;'>Total Amount</td>
						<td colspan='2' style='color:red;padding-left:5px;font-weight:bold;text-align: right;'>Php ".number_format($GrandTotalAmount, 2, '.', ',')."</td></tr>";
			echo	"</table>";
		break;

		case 'printbydaterange':
			if($_POST['maintype'] != ""){
				if($_POST['catname'] != ""){
					$category = "AND category_id = '". $_POST['catname'] ."'";
				}else{
					$category = "";
				}
				$mgaMeron = "";
				$rescats = mysql_query("SELECT category_id FROM tblmaintenance_category WHERE Maintenance_Type = '". $_POST['maintype'] ."' ". $category ."", $connection);
				while($rowcats = mysql_fetch_array($rescats)){
					$mgaMeron .= "'" . $rowcats[0] . "'" . ",";
					$tanong = "xcategory IN (". substr(trim($mgaMeron), 0, -1) .")";
				}
			}else{
				$tanong = "xcategory = '". $_POST['catname'] ."'";
			}

			$mgaMeron2 = "";
			$wolist = mysql_query("SELECT DISTINCT(workorderid) FROM tblmaintenance_workorderlist WHERE ". $tanong ." ", $connection);
			while($rowwolist = mysql_fetch_array($wolist)){
				$mgaMeron2 .= "'" . $rowwolist[0] . "'" . ",";
			}

			$tanong2 = "AND workorderid IN (". substr(trim($mgaMeron2), 0, -1) .")";

			$sql = " SELECT workorderid, TenantID, ownername, xdate, xtime, workerid, workername, remarks, xstatus, Complaint_Series_No FROM tblmaintenance_workorder WHERE xdate BETWEEN '".date("Y-m-d", strtotime($_POST['datefrom']))."' AND '".date("Y-m-d", strtotime($_POST['dateto']))."' ". $tanong2 ." ORDER BY xdate DESC";
			$res = mysql_query($sql, $connection);
			while( $row = mysql_fetch_array($res) ){
				$tradename = mysql_fetch_array(mysql_query("SELECT tradename FROM tbltrans_tenants WHERE tenantID = '". $row[1] ."' ", $connection));
				$complaints = mysql_fetch_array(mysql_query("SELECT Complaint_Status, Complaint_Code FROM tblcomplaints WHERE Complaint_Series_No = '". $row['Complaint_Series_No'] ."' ", $connection));

					if($complaints[0] == "Ongoing"){
						$complaintstatus = '<span class="fa fa-circle" style="color: #428BCA;"></span>';
					}else if($complaints[0] == "Pending"){
						$complaintstatus = '<span class="fa fa-circle" style="color: #FF892A;"></span>';
					}else{
						$complaintstatus = '<span class="fa fa-circle" style="color: #69AA46;"></span>';
					}

					if ($row['xstatus'] == 'Pending') {
						$stats = '<span class="label label-warning">'.$row['xstatus'].'</span>';
					}
					else if($row['xstatus'] == 'Resolved'){
						$stats = '<span class="label label-success">'.$row['xstatus'].'</span>';
					}
				?>
					<tr>
						<td valign="top"><?php echo date('m/d/Y', strtotime($row['xdate'])); ?></td>						
						<td valign="top"><?php echo $row['workorderid']; ?></td>						
						<td valign="top"><?php echo $tradename[0]; ?></td>						
						<td>
						<?php
							if($row['Complaint_Series_No'] == ""){
								$res2 = mysql_query("SELECT xcategory, taskstatus FROM tblmaintenance_workorderlist WHERE workorderid = '". $row['workorderid'] ."' ", $connection);
								while($joblist = mysql_fetch_array($res2)){
									$catname = mysql_fetch_array(mysql_query("SELECT category FROM tblmaintenance_category WHERE category_id = '". $joblist[0] ."' ", $connection));
									if($joblist[1] == 'Resolved'){
										$span2 = '<span class="fa fa-circle" style="color: #69AA46;"></span>&nbsp;'.$catname[0].'<br/>';
									}else if($joblist[1] == 'Pending'){
										$span2 = '<span class="fa fa-circle" style="color: #FF892A;"></span>&nbsp;'.$catname[0].'<br/>';
									}else if($joblist[1] == 'Ongoing'){
										$span2 = '<span class="fa fa-circle" style="color: #428BCA;"></span>&nbsp;'.$catname[0].'<br/>';
									}
									echo $span2;
								}
							}
							else{
								echo $complaintstatus." ".$complaints[1];
							}
						?>
						</td>						
						<td valign="top"><?php echo $row['workername']; ?></td>						
						<td valign="top"><?php echo $stats; ?></td>
					</tr>
				<?php				
			}
			echo "|".date('F d, Y', strtotime($_POST['datefrom'])) . "|" . date('F d, Y', strtotime($_POST['dateto']));
		break;

		case 'resolvingofcomplaint':
			$sched = mysql_fetch_array(mysql_query("SELECT Time_Received, Time_Resolved, duration, remarks FROM tblcomplaints WHERE Complaint_Series_No = '". $_POST['csn'] ."' ", $connection));
			$amount = mysql_fetch_array(mysql_query("SELECT totalamount FROM tblmaintenance_workorder WHERE Complaint_Series_No = '". $_POST['csn'] ."' ", $connection));
			$arr = explode(" ", $sched[0]);
			$arr2 = explode(" ", $sched[1]);

			if($arr[0] == ""){
				$property = "";
				$val = date('m/d/Y');
			}else{
				$property = "disabled";
				$val = date('m/d/Y', strtotime($arr[0]));
			}

			if($arr[1] == ""){
				$property2 = "";
				$val2 = date('H:i');
			}else{
				$property2 = "disabled";
				$val2 = date('H:i', strtotime($arr[1]));
			}

			if($arr2[0] == ""){
				$property3 = "";
				$val3 = date('m/d/Y');
			}else{
				$property3 = "disabled";
				$val3 = date('m/d/Y', strtotime($arr2[0]));
			}

			if($arr2[1] == ""){
				$property4 = "";
				$val4 = date('H:i');
			}else{
				$property4 = "disabled";
				$val4 = date('H:i', strtotime($arr2[1]));
			}

			if($sched[2] == ""){
				$property5 = "";
			}else{
				$property5 = "disabled";
			}

			if($amount[0] == ""){
				$property6 = "";
			}else{
				$property6 = "disabled";
			}

			if($sched[3] == ""){
				$property7 = "";
			}else{
				$property7 = "disabled";
			}

				echo "
					<div class='col-xs-6 col-md-6 col-lg-6'>
                        <div class='row form-group'>
                            <div class='col-xs-4 col-md-4 col-lg-4'>
                                Start Date
                            </div>
                            <div class='col-xs-8 col-md-8 col-lg-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control date-picker' ".$property." id='complaintstartdate' value='". $val ."'>
                                    <label class='input-group-addon'><i class='fa fa-calendar'></i></label>
                                </div>
                            </div>
                        </div>
                        <div class='row form-group'>
                            <div class='col-xs-4 col-md-4 col-lg-4'>
                                End Date
                            </div>
                            <div class='col-xs-8 col-md-8 col-lg-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control date-picker' ".$property3." value='". $val3 ."' id='complaintenddate'>
                                    <label class='input-group-addon'><i class='fa fa-calendar'></i></label>
                                </div>
                            </div>
                        </div>
                        <div class='row form-group'>
                            <div class='col-xs-4 col-md-4 col-lg-4'>
                                Duration
                            </div>
                            <div class='col-xs-8 col-md-8 col-lg-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control durationsdsdsd numberlang' ".$property5." placeholder='0.0' value='". $sched[2] ."' id='complaintduration'>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='col-xs-6 col-md-6 col-lg-6'>
                        <div class='row form-group'>
                            <div class='col-xs-4 col-md-4 col-lg-4'>
                                Start Time
                            </div>
                            <div class='col-xs-8 col-md-8 col-lg-8'>
                                <div class='input-group'>
                                    <input type='time' class='form-control' id='complaintstarttime' ".$property2." value='". $val2 ."'>
                                    <label class='input-group-addon'><i class='fa fa-clock-o'></i></label>
                                </div>
                            </div>
                        </div>
                        <div class='row form-group'>
                            <div class='col-xs-4 col-md-4 col-lg-4'>
                                End Time
                            </div>
                            <div class='col-xs-8 col-md-8 col-lg-8'>
                                <div class='input-group'>
                                    <input type='time' class='form-control' ".$property4." value='". $val4 ."' id='complaintendtime'>
                                    <label class='input-group-addon'><i class='fa fa-clock-o'></i></label>
                                </div>
                            </div>
                        </div>
                        <div class='row form-group'>
                            <div class='col-xs-4 col-md-4 col-lg-4'>
                                Amount
                            </div>
                            <div class='col-xs-8 col-md-8 col-lg-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control halaga numberlang' ".$property6." placeholder='0.00' value='".$amount[0]."' id='complaintamount'>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='col-xs-12 col-md-12 col-lg-12'>
                        <div class='row form-group'>
                            <div class='col-xs-2 col-md-2 col-lg-2'>
                                Remarks
                            </div>
                            <div class='col-xs-10 col-md-10 col-lg-10'>
                                <textarea class='form-control' id='complaintremarks' style='height: 90px;resize: none;' ".$property7.">". $sched[3] ."</textarea>
                            </div>
                        </div>
                    </div>";
		break;

		case 'saveresolvingofcomplaint':
			$sql = " UPDATE tblcomplaints SET Time_Resolved = '". date('Y-m-d', strtotime($_POST['enddate'])) .' '. date('H:i:s', strtotime($_POST['endtime'])) ."', Duration = '". $_POST['duration'] ."', Complaint_Status = 'Resolved', remarks = '". $_POST['remarks'] ."' WHERE Complaint_Series_No = '". $_POST['csn'] ."' ";
			$res = mysql_query($sql, $connection);
			if($res == true){
				$sql2 = " UPDATE tblmaintenance_workorder SET enddate = '". date('Y-m-d', strtotime($_POST['enddate'])) ."', endtime = '". date('H:i:s', strtotime($_POST['endtime'])) ."', duration = '". $_POST['duration'] ."', xstatus = 'Resolved', remarks = '". $_POST['remarks'] ."', totalamount = '". $_POST['amount'] ."' WHERE Complaint_Series_No = '". $_POST['csn'] ."' ";
				$res2 = mysql_query($sql2, $connection);
				if($res2 == true){
					echo 1;
				}
			}
		break;

		case 'fncPostWorkOrder2':
			$WorkOrderInfo = mysql_fetch_array(mysql_query("SELECT xdate FROM tblmaintenance_workorder WHERE workorderid = '". $_POST['WorkorderID'] ."';", $connection));
			$CurrDate = date('Y-m-d', strtotime(getsysdate()));

			$Count = 0;
			$rowComplaint = mysql_fetch_array(mysql_query("SELECT TenantID, Complaint_Series_No, totalamount FROM tblmaintenance_workorder WHERE workorderid = '". $_POST['WorkorderID'] ."';", $connection));
			if($rowComplaint['Complaint_Series_No'] != ""){
				$rowtblcomplaint = mysql_fetch_array(mysql_query("SELECT Complaint_Code, Complete_Description FROM tblcomplaints WHERE Complaint_Series_No = '". $rowComplaint['Complaint_Series_No'] ."';", $connection)); 

					$Merchant_Code = mysql_fetch_array(mysql_query("SELECT merchant_code FROM tbltrans_tenants WHERE tenantid = '". $rowComplaint['TenantID'] ."';", $connection));

					$resinsertcomplaint = mysql_query("INSERT INTO tbltransaction SET tenantid = '". $rowComplaint['TenantID'] ."', xcode = '". $rowtblcomplaint['Complaint_Code'] ."', description = '". $rowtblcomplaint['Complaint_Series_No'] ."', xdescription = '". $rowtblcomplaint['Complaint_Series_No'] ."', amount = '". $rowComplaint['totalamount'] ."', qty = '1', balance = '". $rowComplaint['totalamount'] ."', totalamount = '". $rowComplaint['totalamount'] ."', userid = '". $_SESSION['MMS-UserID'] ."', xdate = '". $CurrDate ."', reference = '". $rowtblcomplaint['Complaint_Code'] ."', merchant_code = '". $Merchant_Code[0] ."';", $connection);
					if($resinsertcomplaint == true){
						$sqlpostcomplaint = "UPDATE tblmaintenance_workorder SET postingstatus = 'Posted', dateposted = '". $CurrDate ."' WHERE workorderid = '". $_POST['WorkorderID'] ."';";
						$respostcomplaint = mysql_query($sqlpostcomplaint, $connection);
						$Count++;
					}
			}else{
				$resTaskList = mysql_query("SELECT xcategory, xtaskid, meter_reading, sub_total, tenantid, reading_date, CurrentMeterUsage, MeterID FROM tblmaintenance_workorderlist WHERE workorderid = '". $_POST['WorkorderID'] ."';", $connection);
				while($rowTaskList = mysql_fetch_array($resTaskList)){

					$CategoryInfo = mysql_fetch_array(mysql_query("SELECT category, isFixed, FixedAmount, AddTask, isReading FROM tblmaintenance_category WHERE category_id = '". $rowTaskList['xcategory'] ."';", $connection));
					$TaskInfo = mysql_fetch_array(mysql_query("SELECT description FROM tblmaintenance_tasklist WHERE taskid = '". $rowTaskList['xtaskid'] ."';", $connection));
					$TenantInfo = mysql_fetch_array(mysql_query("SELECT a.mallID, b.isRent FROM tbltrans_tenants AS a INNER JOIN tbltrans_proposal AS b ON a.inqID = b.inquiryID AND a.ActiveProposal = b.proposalNum WHERE a.TenantID = '". $rowTaskList['tenantid'] ."';", $connection));

                	$getMultiplier = mysql_fetch_array(mysql_query("SELECT Multiplier FROM tblref_meter WHERE MeterID = '". $rowTaskList['MeterID'] ."';", $connection));

					$getSetup = explode("|", getrentvattype($TenantInfo['mallID']));
					$isVatable = $getSetup[1];
					$isInclusive = $getSetup[2];
					$VATPercent = floatval($getSetup[0]) / 100;

					if($TenantInfo['isRent'] == 0){
						if($isVatable == "yes"){
	                        if($isInclusive == "inc"){ //VAT IS INCLUSIVE
	                            $VATAmount = ( floatval($rowTaskList['sub_total']) / 1.12 ) * $VATPercent;
	                            $RentLessVAT = floatval($rowTaskList['sub_total']) - $VATAmount;
	                            $Amount = $RentLessVAT;
								$VAT = $VATAmount;
	                            $TotalAmount = $VAT + $Amount;
	                        }else{ //VAT IS EXCLUSIVE
	                            $VATAmount = floatval($rowTaskList['sub_total']) * $VATPercent;
	                            $RentPlusVAT = floatval($rowTaskList['sub_total']);
	                            $Amount = floatval($rowTaskList['sub_total']);
	                            $VAT = $VATAmount;
	                            $TotalAmount = floatval($rowTaskList['sub_total']) + $VATAmount;
	                        }
	                    }else{
	                    	$Amount = $rowTaskList['sub_total'];
	                        $VAT = "0.00";
	                        $TotalAmount = floatval($rowTaskList['sub_total']);
	                    }
                    }else{
                        $Amount = $rowTaskList['sub_total'];
                        $VAT = "0.00";
                        $TotalAmount = floatval($rowTaskList['sub_total']);
                    }

                    if($CategoryInfo['isReading'] == '2'){
	            		$BillingFactor = getUtilRate('Water', $TenantInfo['mallID'], $rowTaskList['reading_date']);
						$sqlInsertToBill = "INSERT INTO tbltransaction SET tenantid = '". $rowTaskList['tenantid'] ."', xcode = '". $rowTaskList['xtaskid'] ."', amount = '". $Amount ."', totalamount = '". $TotalAmount ."', vatamount = '". $VAT ."', qty = '". floatval($rowTaskList['meter_reading'] - $rowTaskList['CurrentMeterUsage']) * $getMultiplier['Multiplier'] ."', balance = '". $TotalAmount ."', xdate = '". $CurrDate ."', userid = '". $_SESSION['MMS-UserID'] ."', xdescription = '". $CategoryInfo['category'] ."', description = '". $CategoryInfo['category'] ."', reference = 'Reading Date: ". date('m/d/Y', strtotime($rowTaskList['reading_date'])) ."; ". number_format(floatval($rowTaskList['meter_reading'] - $rowTaskList['CurrentMeterUsage']) * $getMultiplier['Multiplier'], 2, '.', ',') ." @ ". number_format($BillingFactor, 2, '.', ','). " /m³';";
	            	}else if($CategoryInfo['isReading'] == '1'){
	            		$BillingFactor = getUtilRate('Electric', $TenantInfo['mallID'], $rowTaskList['reading_date']);
						$sqlInsertToBill = "INSERT INTO tbltransaction SET tenantid = '". $rowTaskList['tenantid'] ."', xcode = '". $rowTaskList['xtaskid'] ."', amount = '". $Amount ."', totalamount = '". $TotalAmount ."', vatamount = '". $VAT ."', qty = '". floatval($rowTaskList['meter_reading'] - $rowTaskList['CurrentMeterUsage']) * $getMultiplier['Multiplier'] ."', balance = '". $TotalAmount ."', xdate = '". $CurrDate ."', userid = '". $_SESSION['MMS-UserID'] ."', xdescription = '". $CategoryInfo['category'] ."', description = '". $CategoryInfo['category'] ."', reference = 'Reading Date: ". date('m/d/Y', strtotime($rowTaskList['reading_date'])) ."; ". number_format(floatval($rowTaskList['meter_reading'] - $rowTaskList['CurrentMeterUsage']) * $getMultiplier['Multiplier'], 2, '.', ',') ." @ ". number_format($BillingFactor, 2, '.', ',') ." /kwh';";
	            	}else if($CategoryInfo['isReading'] == '3'){
	            		$BillingFactor = getUtilRate('Gas', $TenantInfo['mallID'], $rowTaskList['reading_date']);
						$sqlInsertToBill = "INSERT INTO tbltransaction SET tenantid = '". $rowTaskList['tenantid'] ."', xcode = '". $rowTaskList['xtaskid'] ."', amount = '". $Amount ."', totalamount = '". $TotalAmount ."', vatamount = '". $VAT ."', qty = '". floatval($rowTaskList['meter_reading'] - $rowTaskList['CurrentMeterUsage']) * $getMultiplier['Multiplier'] ."', balance = '". $TotalAmount ."', xdate = '". $CurrDate ."', userid = '". $_SESSION['MMS-UserID'] ."', xdescription = '". $CategoryInfo['category'] ."', description = '". $CategoryInfo['category'] ."', reference = 'Reading Date: ". date('m/d/Y', strtotime($rowTaskList['reading_date'])) ."; ". number_format(floatval($rowTaskList['meter_reading'] - $rowTaskList['CurrentMeterUsage']) * $getMultiplier['Multiplier'], 2, '.', ',') ." @ ". number_format($BillingFactor, 2, '.', ',') ." /m³';";
	            	}else{
						$sqlInsertToBill = "INSERT INTO tbltransaction SET tenantid = '". $rowTaskList['tenantid'] ."', xcode = '". $rowTaskList['xtaskid'] ."', amount = '". $Amount ."', totalamount = '". $TotalAmount ."', vatamount = '". $VAT ."', qty = '1', balance = '". $TotalAmount ."', xdate = '". $CurrDate ."', userid = '". $_SESSION['MMS-UserID'] ."', xdescription = '". $TaskInfo['description'] ."', description = '". $CategoryInfo['category'] ." - ". $TaskInfo['description'] ."', reference = '". $CategoryInfo['category'] ."';";
	            	}
	            	$resInsertToBill = mysql_query($sqlInsertToBill, $connection);
	            	if($resInsertToBill == true){
						$resUpdateStatus = mysql_query("UPDATE tblmaintenance_workorder SET postingstatus = 'Posted', dateposted = '". $CurrDate ."' WHERE workorderid = '". $_POST['WorkorderID'] ."';", $connection);
						if($resUpdateStatus == true){
							$resUpdateStatus2 = mysql_query("UPDATE tblmaintenance_workorderlist SET xstatus = 'Posted', dateposted = '". $CurrDate ."' WHERE workorderid = '". $_POST['WorkorderID'] ."';", $connection);
						}
						$Count++;
	            	}
				}
			}
			if($Count >= 1){
				echo 1;
			}else{
				echo 2;
			}
		break;

		case 'showwodep':
			$res = mysql_query("SELECT groupid, groupname FROM tblref_groupaccess;", $connection);
			while($row = mysql_fetch_array($res)){
				echo "<option value='".$row[0]."'>".$row[1]."</option>";
			}
		break;

		case 'showwopersonnel':
			$res = mysql_query("SELECT userid, CONCAT(firstname, ' ', lastname) FROM tbluser WHERE groupaccess = '". $_POST['dep'] ."';", $connection);
			while($row = mysql_fetch_array($res)){
				echo "<option value='".$row[0]."'>".$row[1]."</option>";
			}
		break;

		case 'showmaincat':
			echo "<option value=''>-- Select Category --</option>";
			if($_POST['maintype'] == "" || $_POST['maintype'] == 'null' || $_POST['maintype'] == 'undefined'){
				$sql = "SELECT category_id, category FROM tblmaintenance_category;";
			}else{
				$sql = "SELECT category_id, category FROM tblmaintenance_category WHERE Maintenance_Type = '". $_POST['maintype'] ."';";
			}
			$res = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($res)){
				echo "<option value='".$row[0]."'>".$row[1]."</option>";
			}
		break;

		case 'getduration':
			$start = date('Y-m-d H:i:s', strtotime($_POST['datefrom'] . ' ' . $_POST['timefrom']));
			$end = date('Y-m-d H:i:s', strtotime($_POST['dateto'] . ' ' . $_POST['timeto']));
			$datetime1 = new DateTime($start);
			$datetime2 = new DateTime($end);
			$interval = $datetime1->diff($datetime2);
			$result = $interval->format('%Y-%m-%d %H:%i:%s');
			$minsec = date("i", strtotime($result));
			if(date('Y-m-d', strtotime($_POST['datefrom'])) == date('Y-m-d', strtotime($_POST['dateto']))){
				$hours = date("H", strtotime($result)); 
			}else{
				$hours = date("d", strtotime($result))*24 + date("H", strtotime($result)); 
			}
			if(date('H:i', strtotime($_POST['timefrom'])) < date('H:i', strtotime($_POST['timeto']))){
				echo $hours.".".$minsec;
			}else{
				echo "error";
			}
		break;
	}
?>
