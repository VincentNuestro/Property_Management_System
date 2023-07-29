<?php 
session_start();
include("../../connect.php");
	switch ($_POST["form"]) {
		case 'leadpositions':
				echo 	"<option selected disabled value=''>-- Select Position --</option>";
			$res = mysql_query("SELECT xposition FROM tblref_companyposition", $connection);
			while($row = mysql_fetch_array($res)){
				echo 	"<option value='". $row[0] ."'>". $row[0] ."</option>";
			}
		break;

		case 'leademployee':
				echo 	"<option selected disabled value=''>-- Select Person --</option>";
			$res = mysql_query("SELECT userid, CONCAT(firstname, ' ', lastname) FROM tbluser", $connection);
			while($row = mysql_fetch_array($res)){
				echo 	"<option value='". $row[0] ."'>". $row[1] ."</option>";
			}
		break;

		case 'tblleadslist':
		    $getFilters = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'Prospects';", $connection));
		    $Status = explode("|", $getFilters["bystat"]);
		    $Search = explode("|", $getFilters["checked_value"]);
		    $Date = explode("|", $getFilters["datefilter"]);

		    // FILTER BY STATUS
		    $StatusCount = 0; $SelectedStatus = "";
		    for($a = 0; $a<=count($Status)-1; $a++){
		      	if($Status[$a] == "Lead"){ 
		      		$StatusVal = "Status = 'Lead'"; 
		      	}else if($Status[$a] == "Inquired"){ 
		      		$StatusVal = "Status = 'Inquired'"; 
		      	}else if($Status[$a] == "Pending Application"){
		      		$StatusVal = "Status = 'Pending Application'"; 
		      	}else if($Status[$a] == "Approved Application"){
		      		$StatusVal = "Status = 'Approved Application'"; 
		      	}else if($Status[$a] == "Confirmed"){
		      		$StatusVal = "Status = 'Confirmed'"; 
		      	}else if($Status[$a] == "Occupied"){
		      		$StatusVal = "Status = 'Occupied'"; 
		      	}else if($Status[$a] == "Cancelled"){
		      		$StatusVal = "Status = 'Cancelled' || Status = 'Junked'"; 
		      	}else{
		      		$StatusVal = "Status = 'Lead'"; 
		      	}

		      	if($Status[$a] != ""){
		       		$StatusCount++;
			        if($StatusCount == 1){
			          	$SelectedStatus .= $StatusVal;
			        }else{
			          	$SelectedStatus .= " OR ".$StatusVal;
			        }
		      	}
		    }

		    if($StatusCount > 1){
		      	$getAllStatus = "(". $SelectedStatus .")";
		    }else{
		      	$getAllStatus = $SelectedStatus;
		    }

		    if($getAllStatus == ""){
		    	$StatFilter = "Status = 'Lead'";
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
		    	$DateFilter = "AND (xDate BETWEEN '". date("Y-m-d", strtotime($Date[0])) ."' AND '". date("Y-m-d", strtotime($Date[1])) ."')";
		    }else{
		    	$DateFilter = "";
		    }

			$Page = $_POST['page'];
			$Limit = ($Page-1) * 20;
			$res = mysql_query("SELECT leadsID, LeadsName, AssignedPerson, Position, Company_Name, Full_Name, xDATETIME, Status, TradeID, CompanyID FROM tbltrans_leads WHERE ". $StatFilter ." ". $SearchFilter ." ". $DateFilter ." ORDER BY xDATETIME DESC LIMIT ". $Limit .",20;", $connection);
			while($row = mysql_fetch_array($res)){

				$checkiftheresalreadyaninquiry = mysql_fetch_array(mysql_query("SELECT Inquiry_ID, Mall_ID, ClassID, DepartmentID, CategoryID, UnitID, Company_ID, TradeID, desired_noofmonths, month_adv, depamount, Status FROM tbltrans_inquiry WHERE leadsID = '". $row['leadsID'] ."'", $connection));
				$wingandfloor = mysql_fetch_array(mysql_query("SELECT floorid, wingid FROM tblref_unit WHERE unitid = '". $checkiftheresalreadyaninquiry[5] ."'", $connection));

				if($row['Status'] == "Lead"){
					$stat = "<span class='label label-lg label-purple arrowed-in-right arrowed' style='z-index: 0;'>Lead</span>";
				}else if($row['Status'] == "Inquired"){
	                $stat = "<span class='label label-lg label-light arrowed-in-right arrowed' style='z-index: 0;'>Inquired</span>";
				}else if($row['Status'] == "Pending Application"){
					$stat = "<span class='label label-lg label-pink arrowed-in-right arrowed' style='z-index: 0;'>Pending Application</span>";
				}else if($row['Status'] == "Approved Application"){
					$stat = "<span class='label label-lg label-info arrowed-in-right arrowed' style='z-index: 0;'>Approved Application</span>";
				}else if($row['Status'] == "Confirmed"){
					$stat = "<span class='label label-lg label-success arrowed-in-right arrowed' style='z-index: 0;'>Confirmed</span>";
				}else if($row['Status'] == "Occupied"){
					$stat = "<span class='label label-lg label-warning arrowed-in-right arrowed' style='z-index: 0;'>Occupied</span>";
				}else if($row['Status'] == "Cancelled"){
					$stat = "<span class='label label-lg label-danger arrowed-in-right arrowed' style='z-index: 0;'>Cancelled</span>";
				}else{
					$stat = "<span class='label label-lg label-danger arrowed-in-right arrowed' style='z-index: 0;'>Junked</span>";
				}

				if($row['Status'] == "Junked" || $row['Status'] == "Cancelled"){
					$btn = "<button class='btn btn-warning btn-sm select-reinstateprospects hide isadmin btn-round' title='Reinstate Lead' onclick='btnReinstateLead(\"". $row[0] ."\")' style='margin: 2px;'><img src='assets/images/calendar2.png' style='width: 100%; height: auto;' /></button>";
				}else{
					$btn = "<button class='btn btn-danger btn-sm select-deleteprospects hide isadmin btn-round' title='Junk Lead' onclick='btnJunkLead(\"". $row[0] ."\")' style='margin: 2px;'><img src='assets/images/calendar.png' style='width: 100%; height: auto;' /></button>";
				}

				echo 	"
							<tr>
								<td>". date('m/d/Y', strtotime($row['xDATETIME'])) ."</td>
								<td>". $row[1] ."</td>
								<td class='batayan'>";
									$chkact = mysql_fetch_array(mysql_query("SELECT COUNT(leadsID) FROM tbltrans_leads_activities WHERE leadsID = '". $row[0] ."'", $connection));
									if($chkact[0] > 0){
										$resact = mysql_query("SELECT SetDate, SetTime, Subject, ActivityID FROM tbltrans_leads_activities WHERE leadsID = '". $row[0] ."'", $connection);
										while($rowact = mysql_fetch_array($resact)){
											echo "<div title='Double-click to view details' ondblclick='EditActivity(\"".$rowact['ActivityID']."\");'><span class='fa fa-calendar yellow'></span> ".date('m/d/Y', strtotime($rowact['SetDate']))." ".date('H:i A', strtotime($rowact['SetTime']))."</div><br>";
										}
										echo "<a class='ilalabas' onclick='showmodal_newactivity(\"". $row['leadsID'] ."\", \"". $row['LeadsName'] ."\");'>Add Activity</a>";
									}else{
										echo "No Activities<br><a class='ilalabas' onclick='showmodal_newactivity(\"". $row['leadsID'] ."\", \"". $row['LeadsName'] ."\");'>Add Activity</a>";
									}
				echo	"		</td>
								<td>". $row[5] ."</td>
								<td>". $stat ."</td>
								<td class='center' style='z-index: 0;'>
									<div class='btn-group'>
										<button class='btn btn-info btn-sm hide isadmin select-editprospects btn-round' title='View/Edit Lead' onclick='editleads(\"". $row['leadsID'] ."\", \"". $row['Status'] ."\", \"". $row['TradeID'] ."\", \"". $row['CompanyID'] ."\", \"\")' style='margin: 2px;'><img src='assets/images/resume.png' style='width: 100%; height: auto;' /></button>
										".$btn."
										<button class='btn btn-sm btn-gray hide isadmin select-viewlogsprospects btn-round' onclick='ViewTrasactionLogs(\"". $row["leadsID"] ."\");' title='View Logs' style='margin: 2px;'><img src='assets/images/clock.png' style='width: 100%; height: auto;' /></button>
									</div>
								</td>
							</tr>
						";
			}
		break;

		case 'loadleadsentries':
			$getFilters = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'Prospects';", $connection));
		    $Status = explode("|", $getFilters["bystat"]);
		    $Search = explode("|", $getFilters["checked_value"]);
		    $Date = explode("|", $getFilters["datefilter"]);

		    // FILTER BY STATUS
		    $StatusCount = 0; $chk = "";
		    for($a = 0; $a<=count($Status)-1; $a++){
		      	if($Status[$a] == "Lead"){ 
		      		$StatusVal = "Status = 'Lead'"; 
		      	}else if($Status[$a] == "Inquired"){ 
		      		$StatusVal = "Status = 'Inquired'"; 
		      	}else if($Status[$a] == "Pending Application"){
		      		$StatusVal = "Status = 'Pending Application'"; 
		      	}else if($Status[$a] == "Approved Application"){
		      		$StatusVal = "Status = 'Approved Application'"; 
		      	}else if($Status[$a] == "Confirmed"){
		      		$StatusVal = "Status = 'Confirmed'"; 
		      	}else if($Status[$a] == "Occupied"){
		      		$StatusVal = "Status = 'Occupied'"; 
		      	}else if($Status[$a] == "Cancelled"){
		      		$StatusVal = "Status = 'Cancelled' || Status = 'Junked'"; 
		      	}else{
		      		$StatusVal = "Status = 'Lead'"; 
		      	}

		      	if($Status[$a] != ""){
		       		$StatusCount++;
			        if($StatusCount == 1){
			          	$SelectedStatus .= $StatusVal;
			        }else{
			          	$SelectedStatus .= " OR ".$StatusVal;
			        }
		      	}
		    }

		    if($StatusCount > 1){
		      	$getAllStatus = "(".$SelectedStatus.")";
		    }else{
		      	$getAllStatus = $SelectedStatus;
		    }

		    if($getAllStatus == ""){
		    	$StatFilter = "Status = 'Lead'";
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
		    	$DateFilter = "AND (xDate BETWEEN '". date("Y-m-d", strtotime($Date[0])) ."' AND '". date("Y-m-d", strtotime($Date[1])) ."')";
		    }else{
		    	$DateFilter = "";
		    }

           	if($_POST["page"] == ""){
               	$page = 1;
           	}else{
               	$page = $_POST["page"];
           	}
           	$limit = ($page-1) * 20;
            $rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM tbltrans_leads WHERE ". $StatFilter ." ". $SearchFilter ." ". $DateFilter .";", $connection));
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

		case "loadleadspage":
			$getFilters = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'Prospects';", $connection));
		    $Status = explode("|", $getFilters["bystat"]);
		    $Search = explode("|", $getFilters["checked_value"]);
		    $Date = explode("|", $getFilters["datefilter"]);

		    // FILTER BY STATUS
		    $StatusCount = 0; $chk = "";
		    for($a = 0; $a<=count($Status)-1; $a++){
		      	if($Status[$a] == "Lead"){ 
		      		$StatusVal = "Status = 'Lead'"; 
		      	}else if($Status[$a] == "Inquired"){ 
		      		$StatusVal = "Status = 'Inquired'"; 
		      	}else if($Status[$a] == "Pending Application"){
		      		$StatusVal = "Status = 'Pending Application'"; 
		      	}else if($Status[$a] == "Approved Application"){
		      		$StatusVal = "Status = 'Approved Application'"; 
		      	}else if($Status[$a] == "Confirmed"){
		      		$StatusVal = "Status = 'Confirmed'"; 
		      	}else if($Status[$a] == "Occupied"){
		      		$StatusVal = "Status = 'Occupied'"; 
		      	}else if($Status[$a] == "Cancelled"){
		      		$StatusVal = "Status = 'Cancelled' || Status = 'Junked'"; 
		      	}else{
		      		$StatusVal = "Status = 'Lead'"; 
		      	}

		      	if($Status[$a] != ""){
		       		$StatusCount++;
			        if($StatusCount == 1){
			          	$SelectedStatus .= $StatusVal;
			        }else{
			          	$SelectedStatus .= " OR ".$StatusVal;
			        }
		      	}
		    }

		    if($StatusCount > 1){
		      	$getAllStatus = "(".$SelectedStatus.")";
		    }else{
		      	$getAllStatus = $SelectedStatus;
		    }

		    if($getAllStatus == ""){
		    	$StatFilter = "Status = 'Lead'";
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
		    	$DateFilter = "AND (xDate BETWEEN '". date("Y-m-d", strtotime($Date[0])) ."' AND '". date("Y-m-d", strtotime($Date[1])) ."')";
		    }else{
		    	$DateFilter = "";
		    }

		    $page = $_POST["page"];
			$rowCount = mysql_fetch_row(mysql_query("SELECT COUNT(id) FROM tbltrans_leads WHERE ". $StatFilter ." ". $SearchFilter ." ". $DateFilter .";", $connection));
			$rowsperpage = 20;
			$range = 3;
			$totalpages = ceil($rowCount[0] / $rowsperpage);
			$prevpage;
			$nextpage;
			if($page > 1 ){
			   echo "<li style='width:50px !important;' onclick='paginationpros(1)'><< First</li>";
			   $prevpage = $page - 1;
			   echo "<li style='width:70px !important;' onclick='paginationpros(". $prevpage .")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   	if (($x > 0) && ($x <= $totalpages)){
    			    if ($x == $page){
                        echo "<li id='pgleads" . $x . "' class='pgnumleads active' onclick='paginationpros(" . $x . ",". $x .")'>" . $x . "</li>";
                    }else{
    			        echo "<li id='pgleads" . $x . "' class='pgnumleads' onclick='paginationpros(" . $x . ",". $x .")'>" . $x . "</li>";
                    }
		       	}
		    }
		    if($page < ($totalpages - $range)){
                echo "<li>...</li>";
            }
		    if ($page != $totalpages && $rowCount[0] != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='paginationpros(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='paginationpros(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'showmodal_newpersonnel':
			$title = mysql_fetch_array(mysql_query("SELECT softwaretype FROM tblsys_setup", $connection));
			if($title[0] == "0"){
				$label =  "Mall";
			}else if($title[0] == "1"){
				$label =  "Building";
			}else if($title[0] == "2"){
				$label =  "Building";
			}

				$mall = "<option value=''>-- Select ".$label." --</option>";
			$res = mysql_query("SELECT mallid, mallname FROM tblref_mall WHERE mallstat = '1'", $connection);
			while($row = mysql_fetch_array($res)){
				$mall .=	"
								<option value='". $row[0] ."'>". $row[1] ."</option>
							";
			}

				$position = "<option value=''>-- Select Position --</option>";
			$res2 = mysql_query("SELECT xposition FROM tblref_companyposition", $connection);
			while($row2 = mysql_fetch_array($res2)){
				$position .=	"
								<option value='". $row2[0] ."'>". $row2[0] ."</option>
							";
			}

				$department = "<option value=''>-- Select Department --</option>";
			$res3 = mysql_query("SELECT code, description FROM tblmaintenance_department", $connection);
			while($row3 = mysql_fetch_array($res3)){
				$department .=	"
								<option value='". $row3[0] ."'>". $row3[1] ."</option>
							";
			}


			echo $mall . "|" . $position . "|" . $department;
		break;

		case 'btnSaveNewLeadsActivity':
			$Activity = createidno("AID", "tbltrans_leads_activities", "ActivityID");
			$sql = "INSERT INTO tbltrans_leads_activities SET ActivityID = '". $Activity ."', leadsID = '". $_POST['leadsid'] ."', Subject = '". $_POST['Subject'] ."', Remarks = '". $_POST['Remarks'] ."', SetDate = '". date('Y-m-d', strtotime($_POST['ActDate'])) ."', SetTime = '". date('H:i:s', strtotime($_POST['ActTime'])) ."'";
			$res = mysql_query($sql, $connection);
			if($res == true){
				echo "1|Activity successfully scheduled.|".$Activity;

				if($_POST['leadsid'] != ""){
					$Log .= "Prospect ID : ". $_POST['leadsid'] . "|";
				}
				if($Activity != ""){
					$Log .= "Activity ID : ". $Activity . "|";
				}
				if($_POST['Subject'] != ""){
					$Log .= "Subject : ". $_POST['Subject'] . "|";
				}
				if($_POST['Remarks'] != ""){
					$Log .= "Remarks : ". $_POST['Remarks'] . "|";
				}
				if($_POST['ActDate'] != ""){
					$Log .= "Date : ". date('F d, Y', strtotime($_POST['ActDate'])) . "|";
				}
				if($_POST['ActTime'] != ""){
					$Log .= "Time : ". date('H:i A', strtotime($_POST['ActTime'])) . "|";
				}
				$arr = explode("|", $_POST['attachment']);
	   			for($a = 0; $a<=count($arr); $a++){
					if($arr[$a] != ""){
						$Log .= "Attachment : ". $arr[$a] . "|";
						$Log2 .= "Attachment : ". $arr[$a] . "|";
					}
				}
				if($Log != ""){
					$tran_logs = create_logs_per_transaction("created a new activity.", "Prospect Module", $Log, $Log2 ,"ADD", $_POST['leadsid']);
				}

			}else{
				echo "2|Failed to set actvity.";
			}
		break;

		case 'btnUpdateLeadsActivity':
			$PrevAct = mysql_fetch_array(mysql_query("SELECT Subject, Remarks, SetDate, SetTime FROM tbltrans_leads_activities WHERE ActivityID = '". $_POST['ActID'] ."'", $connection));

			$sql = "UPDATE tbltrans_leads_activities SET Subject = '". $_POST['Subject'] ."', Remarks = '". $_POST['Remarks'] ."', SetDate = '". date('Y-m-d', strtotime($_POST['ActDate'])) ."', SetTime = '". date('H:i:s', strtotime($_POST['ActTime'])) ."' WHERE ActivityID = '". $_POST['ActID'] ."'";
			$res = mysql_query($sql, $connection);
			if($res == true){
				echo "1|Activity successfully updated.|".$_POST['ActID'];

				if($PrevAct['Subject'] != $_POST['Subject']){
					if($PrevAct['Subject'] == ""){
						$Log .= "Subject : ". $_POST['Subject'] . "|";
					}else{
						$Log .= "Subject : From ". $PrevAct['Subject'] ." To ". $_POST['Subject'] . "|";
					}
				}
				if($PrevAct['Remarks'] != $_POST['Remarks']){
					if($PrevAct['Remarks'] == ""){
						$Log .= "Remarks : ". $_POST['Remarks'] . "|";
					}else{
						$Log .= "Remarks : From ". $PrevAct['Remarks'] ." To ". $_POST['Remarks'] . "|";
					}
				}
				if($PrevAct['SetDate'] != date('Y-m-d', strtotime($_POST['ActDate']))){
					if($PrevAct['SetDate'] == ""){
						$Log .= "Date : ". date('m/d/Y', strtotime($_POST['ActDate'])) . "|";
					}else{
						$Log .= "Date : From ". date('m/d/Y', strtotime($PrevAct['SetDate'])) ." To ". date('m/d/Y', strtotime($_POST['ActDate'])) . "|";
					}
				}
				if($PrevAct['SetTime'] != date('H:i:s', strtotime($_POST['ActTime']))){
					if($PrevAct['SetTime'] == ""){
						$Log .= "Time : From ". date('H:i A', strtotime($PrevAct['SetTime'])) ." To ". date('H:i A', strtotime($_POST['ActTime'])) . "|";
					}else{
						$Log .= "Time : From ". date('H:i A', strtotime($PrevAct['SetTime'])) ." To ". date('H:i A', strtotime($_POST['ActTime'])) . "|";
					}
				}

				$arr = explode("|", $_POST['attachment']);
	   			for($a = 0; $a<=count($arr); $a++){
					if($arr[$a] != ""){
						$Log .= "Attachment : ". $arr[$a] . "|";
						$Log2 .= "Attachment : ". $arr[$a] . "|";
					}
				}
				
				if($Log != ""){
					$tran_logs = create_logs_per_transaction("updated an activity.", "Prospect Module", $Log, $Log2 ,"ADD", $_POST['leadsid']);
				}

			}else{
				echo "2|Failed to update actvity.";
			}
		break;

		case 'EditActivity':
			$Activity = mysql_fetch_array(mysql_query("SELECT Subject, Remarks, SetDate, SetTime, leadsID FROM tbltrans_leads_activities WHERE ActivityID = '". $_POST['ActivityID'] ."'", $connection));
			$Lead = mysql_fetch_array(mysql_query("SELECT LeadsName FROM tbltrans_leads WHERE leadsID = '". $Activity['leadsID'] ."'", $connection));

			echo $Lead['LeadsName'] . "|" . $Activity['Subject'] . "|" . $Activity['Remarks'] . "|" . date('m/d/Y', strtotime($Activity['SetDate'])) . "|" . $Activity['SetTime'] . "|";


			$res = mysql_query("SELECT filename, filetype FROM tbltrans_leads_attachments WHERE ActivityID = '". $_POST['ActivityID'] ."' AND filetype != ''", $connection);
			while($row = mysql_fetch_array($res)){
				$path = "server/Leads/".$Activity['leadsID']."/".$_POST['ActivityID']."/".$row[0];
				$arr = explode("/", $row[1]);
				if($arr[0] != "image"){
					$btn = "<a href='".$path."' download class='btn btn-xs btn-info btn-round'><i class='fa fa-download'></i></a>";
	            }else{
	                $btn = "<a class='btn btn-xs btn-info btn-round' onclick='viewdocuimgindex(\"". $path ."\");'><i class='fa fa-eye'></i></a>";
	            }

				$actatt .= "	<div class='row form-group'>
									<div class='col-md-2'><b>Attachment</b></div>
									<div class='col-md-1'>".$btn."</div>
									<div class='col-md-9'>
										<p style='font-size:11px;font-weight:normal;font-style:italic;display:inline;'>&nbsp;&nbsp;".$row[0]."</p>
									</div>
							  	</div>";
			}

				$actatt .= "<div class='row form-group'><div class='col-md-2'><b>Attachment</b></div> <div class='col-md-5'><input type='file' class='leadsactivityattachment' id='memoattachment1' name='leadsactivityattachment1'></div></div>";
			echo $actatt . "|" . $Activity['leadsID'];
		break;

		case 'btnJunkLead':
			$res = mysql_query("UPDATE tbltrans_leads SET Status = 'Junked' WHERE leadsID = '". $_POST['leadsID'] ."' ", $connection);
			if($res == true){
				echo "1|Lead has been successfully sent to junk.";
				if($Logs != ""){
					$tran_logs = create_logs_per_transaction("sent a lead to junk.", "Prospect Module", "", "" ,"UPDATE", $_POST['leadsID']);
				}
			}else{
				echo "2|Failed to send lead to junk.";
			}
		break;

		case 'btnReinstateLead':
			$res = mysql_query("UPDATE tbltrans_leads SET Status = 'Lead' WHERE leadsID = '". $_POST['leadsID'] ."' ", $connection);
			if($res == true){
				echo "1|Lead has been successfully reinstated.";
				if($Logs != ""){
					$tran_logs = create_logs_per_transaction("reinstated a lead.", "Prospect Module", "", "" ,"UPDATE", $_POST['leadsID']);
				}
			}else{
				echo "2|Failed to reinstate lead.";
			}
		break;
	}
?>