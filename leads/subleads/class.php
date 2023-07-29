<?php 
session_start();
include("../../connect.php");
	switch ($_POST["form"]) {
		case 'tblSubLeadslist':
		    $getFilters = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = '". $_POST['module'] ."' ", $connection));
		    $Status = explode("|", $getFilters["bystat"]);
		    $Search = explode("|", $getFilters["checked_value"]);
		    $Date = explode("|", $getFilters["datefilter"]);

		    // FILTER BY STATUS
		    $StatusCount = 0; $chk = "";
		    for($a = 0; $a<=count($Status)-1; $a++){
		      	if($Status[$a] == "Lead"){ 
		      		$StatusVal = "b.Status = 'Lead'"; 
		      	}else if($Status[$a] == "Inquired"){ 
		      		$StatusVal = "b.Status = 'Inquired'"; 
		      	}else if($Status[$a] == "Pending Application"){
		      		$StatusVal = "b.Status = 'Pending Application'"; 
		      	}else if($Status[$a] == "Approved Application"){
		      		$StatusVal = "b.Status = 'Approved Application'"; 
		      	}else if($Status[$a] == "Confirmed"){
		      		$StatusVal = "b.Status = 'Confirmed'"; 
		      	}else if($Status[$a] == "Occupied"){
		      		$StatusVal = "b.Status = 'Occupied'"; 
		      	}else if($Status[$a] == "Cancelled"){
		      		$StatusVal = "b.Status = 'Cancelled' || Status = 'Junked'"; 
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
		    	$StatFilter = "b.Status = 'Lead'";
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
		    	$DateFilter = "AND (a.xDate BETWEEN '". date("Y-m-d", strtotime($Date[0])) ."' AND '". date("Y-m-d", strtotime($Date[1])) ."')";
		    }else{
		    	$DateFilter = "";
		    }

	       	$page = $_POST['page'];
			$limit = ($page-1) * 20;
	       	if($_POST['module'] == "awareness"){
	       		$sql = "SELECT a.leadsID, a.AwarenessID, a.Subject, a.Details, a.xDATETIME, b.LeadsName, b.Status, b.TradeID, b.CompanyID FROM tbltrans_leads_awareness AS a LEFT JOIN tbltrans_leads AS b ON a.leadsID = b.leadsID WHERE ". $StatFilter ." ". $SearchFilter ." ". $DateFilter ." ORDER BY xDATETIME ASC LIMIT ".$limit.",20;";
	       		$btntitle = "Awareness";
	       		$userandacce1 = "editawareness";
	       		$userandacce2 = "deleteawareness";
	       		$userandacce3 = "viewlogsawareness";
	       	}else if($_POST['module'] == "referral"){
	       		$sql = "SELECT a.leadsID, a.ReferralID, a.Subject, a.Details, a.xDATETIME, b.LeadsName, b.Status, b.TradeID, b.CompanyID FROM tbltrans_leads_referral AS a LEFT JOIN tbltrans_leads AS b ON a.leadsID = b.leadsID WHERE ". $StatFilter ." ". $SearchFilter ." ". $DateFilter ." ORDER BY xDATETIME ASC LIMIT ".$limit.",20;";
	       		$btntitle = "Referral";
	       		$userandacce1 = "editreferral";
	       		$userandacce2 = "deletereferral";
	       		$userandacce3 = "viewlogsreferral";
	       	}else if($_POST['module'] == "demo"){
	       		$sql = "SELECT a.leadsID, a.DemoID, a.Subject, a.Details, a.xDATETIME, b.LeadsName, b.Status, b.TradeID, b.CompanyID FROM tbltrans_leads_demo AS a LEFT JOIN tbltrans_leads AS b ON a.leadsID = b.leadsID WHERE ". $StatFilter ." ". $SearchFilter ." ". $DateFilter ." ORDER BY xDATETIME ASC LIMIT ".$limit.",20;";
	       		$btntitle = "Demo";
	       		$userandacce1 = "editdemo";
	       		$userandacce2 = "deletedemo";
	       		$userandacce3 = "viewlogsdemo";
	       	}else if($_POST['module'] == "closingmeeting"){
	       		$sql = "SELECT a.leadsID, a.ClosingMeetingID, a.Subject, a.Details, a.xDATETIME, b.LeadsName, b.Status, b.TradeID, b.CompanyID FROM tbltrans_leads_closingmeeting AS a LEFT JOIN tbltrans_leads AS b ON a.leadsID = b.leadsID WHERE ". $StatFilter ." ". $SearchFilter ." ". $DateFilter ." ORDER BY xDATETIME ASC LIMIT ".$limit.",20;";
	       		$btntitle = "Closing Meeting";
	       		$userandacce1 = "editclosingmeeting";
	       		$userandacce2 = "deleteclosingmeeting";
	       		$userandacce3 = "viewlogsclosingmeeting";
	       	}else if($_POST['module'] == "contractsigning"){
	       		$sql = "SELECT a.leadsID, a.ContractSigningID, a.Subject, a.Details, a.xDATETIME, b.LeadsName, b.Status, b.TradeID, b.CompanyID FROM tbltrans_leads_contractsigning AS a LEFT JOIN tbltrans_leads AS b ON a.leadsID = b.leadsID WHERE ". $StatFilter ." ". $SearchFilter ." ". $DateFilter ." ORDER BY xDATETIME ASC LIMIT ".$limit.",20;";
	       		$btntitle = "Contract Signing";
	       		$userandacce1 = "editcontractsigning";
	       		$userandacce2 = "deletecontractsigning";
	       		$userandacce3 = "viewlogscontractsigning";
	       	}
			$res = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($res)){
				$leadsinfo = mysql_fetch_array(mysql_query("SELECT LeadsName, Status, TradeID, CompanyID FROM tbltrans_leads WHERE leadsID = '". $row['leadsID'] ."';", $connection));

				if($leadsinfo['Status'] == "Lead"){
					$stat = "<span class='label label-lg label-purple arrowed-in-right arrowed' style='z-index: 0;'>Lead</span>";
				}else if($leadsinfo['Status'] == "Inquired"){
	                $stat = "<span class='label label-lg label-light arrowed-in-right arrowed' style='z-index: 0;'>Inquired</span>";
				}else if($leadsinfo['Status'] == "Pending Application"){
					$stat = "<span class='label label-lg label-pink arrowed-in-right arrowed' style='z-index: 0;'>Pending Application</span>";
				}else if($leadsinfo['Status'] == "Approved Application"){
					$stat = "<span class='label label-lg label-info arrowed-in-right arrowed' style='z-index: 0;'>Approved Application</span>";
				}else if($leadsinfo['Status'] == "Confirmed"){
					$stat = "<span class='label label-lg label-success arrowed-in-right arrowed' style='z-index: 0;'>Confirmed</span>";
				}else if($leadsinfo['Status'] == "Occupied"){
					$stat = "<span class='label label-lg label-warning arrowed-in-right arrowed' style='z-index: 0;'>Occupied</span>";
				}else if($leadsinfo['Status'] == "Cancelled"){
					$stat = "<span class='label label-lg label-danger arrowed-in-right arrowed' style='z-index: 0;'>Cancelled</span>";
				}else{
					$stat = "<span class='label label-lg label-danger arrowed-in-right arrowed' style='z-index: 0;'>Junked</span>";
				}

				echo 	"<tr>
							<td>". date('m/d/Y', strtotime($row['xDATETIME'])) ."</td>
							<td>". $leadsinfo['LeadsName'] ."</td>
							<td>". $row['Subject'] ."</td>
							<td>". $row['Details'] ."</td>
							<td>". $stat ."</td>
							<td class='center' style='z-index: 0;'>
								<div class='btn-group'>
									<button class='btn btn-info btn-sm hide isadmin select-". $userandacce1 ." btn-round' title='View/Edit ". $btntitle ."' onclick='editleads(\"". $row['leadsID'] ."\", \"". $leadsinfo['Status'] ."\", \"". $leadsinfo['TradeID'] ."\", \"". $leadsinfo['CompanyID'] ."\", \"". $row[1] ."\")' style='margin: 2px;'><img src='assets/images/resume.png' style='width: 100%; height: auto;' /></button>
									<button class='btn btn-danger btn-sm hide isadmin select-". $userandacce2 ." btn-round' title='Delete ". $btntitle ."' onclick='btnDeleteSubLeads(\"". $row[1] ."\")' style='margin: 2px;'><img src='assets/images/remove.png' style='width: 100%; height: auto;' /></button>
									<button class='btn btn-sm btn-gray hide isadmin select-viewlogsprospects btn-round' onclick='ViewTrasactionLogs(\"". $row["leadsID"] ."\");' title='View Logs' style='margin: 2px;'><img src='assets/images/clock.png' style='width: 100%; height: auto;' /></button>
								</div>
							</td>
						</tr>";
			}
		break;

		case 'loadSubLeadsentries':
			$getFilters = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = '". $_POST['module'] ."' ", $connection));
		    $Status = explode("|", $getFilters["bystat"]);
		    $Search = explode("|", $getFilters["checked_value"]);
		    $Date = explode("|", $getFilters["datefilter"]);

		    // FILTER BY STATUS
		    $StatusCount = 0; $chk = "";
		    for($a = 0; $a<=count($Status)-1; $a++){
		      	if($Status[$a] == "Lead"){ 
		      		$StatusVal = "b.Status = 'Lead'"; 
		      	}else if($Status[$a] == "Inquired"){ 
		      		$StatusVal = "b.Status = 'Inquired'"; 
		      	}else if($Status[$a] == "Pending Application"){
		      		$StatusVal = "b.Status = 'Pending Application'"; 
		      	}else if($Status[$a] == "Approved Application"){
		      		$StatusVal = "b.Status = 'Approved Application'"; 
		      	}else if($Status[$a] == "Confirmed"){
		      		$StatusVal = "b.Status = 'Confirmed'"; 
		      	}else if($Status[$a] == "Occupied"){
		      		$StatusVal = "b.Status = 'Occupied'"; 
		      	}else if($Status[$a] == "Cancelled"){
		      		$StatusVal = "b.Status = 'Cancelled' || Status = 'Junked'"; 
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
		    	$DateFilter = "AND (a.xDate BETWEEN '". date("Y-m-d", strtotime($Date[0])) ."' AND '". date("Y-m-d", strtotime($Date[1])) ."')";
		    }else{
		    	$DateFilter = "";
		    }

           	if($_POST["page"] == ""){
               	$page = 1;
           	}else{
               	$page = $_POST["page"];
           	}
           	$limit = ($page-1) * 20;
           	if($_POST['module'] == "awareness"){
            	$rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(a.id) FROM tbltrans_leads_awareness AS a LEFT JOIN tbltrans_leads AS b ON a.leadsID = b.leadsID WHERE ". $StatFilter ." ". $SearchFilter ." ". $DateFilter .";", $connection));
	       	}else if($_POST['module'] == "referral"){
            	$rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(a.id) FROM tbltrans_leads_referral AS a LEFT JOIN tbltrans_leads AS b ON a.leadsID = b.leadsID WHERE ". $StatFilter ." ". $SearchFilter ." ". $DateFilter .";", $connection));
	       	}else if($_POST['module'] == "demo"){
            	$rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(a.id) FROM tbltrans_leads_demo AS a LEFT JOIN tbltrans_leads AS b ON a.leadsID = b.leadsID WHERE ". $StatFilter ." ". $SearchFilter ." ". $DateFilter .";", $connection));
	       	}else if($_POST['module'] == "closingmeeting"){
            	$rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(a.id) FROM tbltrans_leads_closingmeeting AS a LEFT JOIN tbltrans_leads AS b ON a.leadsID = b.leadsID WHERE ". $StatFilter ." ". $SearchFilter ." ". $DateFilter .";", $connection));
	       	}else if($_POST['module'] == "contractsigning"){
            	$rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(a.id) FROM tbltrans_leads_contractsigning AS a LEFT JOIN tbltrans_leads AS b ON a.leadsID = b.leadsID WHERE ". $StatFilter ." ". $SearchFilter ." ". $DateFilter .";", $connection));
	       	}
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

		case "loadSubLeadspage":
			$getFilters = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = '". $_POST['module'] ."' ", $connection));
		    $Status = explode("|", $getFilters["bystat"]);
		    $Search = explode("|", $getFilters["checked_value"]);
		    $Date = explode("|", $getFilters["datefilter"]);

		    // FILTER BY STATUS
		    $StatusCount = 0; $chk = "";
		    for($a = 0; $a<=count($Status)-1; $a++){
		      	if($Status[$a] == "Lead"){ 
		      		$StatusVal = "b.Status = 'Lead'"; 
		      	}else if($Status[$a] == "Inquired"){ 
		      		$StatusVal = "b.Status = 'Inquired'"; 
		      	}else if($Status[$a] == "Pending Application"){
		      		$StatusVal = "b.Status = 'Pending Application'"; 
		      	}else if($Status[$a] == "Approved Application"){
		      		$StatusVal = "b.Status = 'Approved Application'"; 
		      	}else if($Status[$a] == "Confirmed"){
		      		$StatusVal = "b.Status = 'Confirmed'"; 
		      	}else if($Status[$a] == "Occupied"){
		      		$StatusVal = "b.Status = 'Occupied'"; 
		      	}else if($Status[$a] == "Cancelled"){
		      		$StatusVal = "b.Status = 'Cancelled' || Status = 'Junked'"; 
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
		    	$DateFilter = "AND (a.xDate BETWEEN '". date("Y-m-d", strtotime($Date[0])) ."' AND '". date("Y-m-d", strtotime($Date[1])) ."')";
		    }else{
		    	$DateFilter = "";
		    }

		    $page = $_POST["page"];
		    if($_POST['module'] == "awareness"){
            	$rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(a.id) FROM tbltrans_leads_awareness AS a LEFT JOIN tbltrans_leads AS b ON a.leadsID = b.leadsID WHERE ". $StatFilter ." ". $SearchFilter ." ". $DateFilter .";", $connection));
	       	}else if($_POST['module'] == "referral"){
            	$rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(a.id) FROM tbltrans_leads_referral AS a LEFT JOIN tbltrans_leads AS b ON a.leadsID = b.leadsID WHERE ". $StatFilter ." ". $SearchFilter ." ". $DateFilter .";", $connection));
	       	}else if($_POST['module'] == "demo"){
            	$rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(a.id) FROM tbltrans_leads_demo AS a LEFT JOIN tbltrans_leads AS b ON a.leadsID = b.leadsID WHERE ". $StatFilter ." ". $SearchFilter ." ". $DateFilter .";", $connection));
	       	}else if($_POST['module'] == "closingmeeting"){
            	$rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(a.id) FROM tbltrans_leads_closingmeeting AS a LEFT JOIN tbltrans_leads AS b ON a.leadsID = b.leadsID WHERE ". $StatFilter ." ". $SearchFilter ." ". $DateFilter .";", $connection));
	       	}else if($_POST['module'] == "contractsigning"){
            	$rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(a.id) FROM tbltrans_leads_contractsigning AS a LEFT JOIN tbltrans_leads AS b ON a.leadsID = b.leadsID WHERE ". $StatFilter ." ". $SearchFilter ." ". $DateFilter .";", $connection));
	       	}
			$rowsperpage = 20;
			$range = 3;
			$totalpages = ceil($rowCount[0] / $rowsperpage);
			$prevpage;
			$nextpage;
			if($page > 1 ){
			   	echo "<li style='width:50px !important;' onclick='fncSubLeadPagination(1)'><< First</li>";
			   	$prevpage = $page - 1;
			   	echo "<li style='width:70px !important;' onclick='fncSubLeadPagination(". $prevpage .")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   	if (($x > 0) && ($x <= $totalpages)){
    			    if ($x == $page){
                        echo "<li id='pgSubLeads" . $x . "' class='pgnumSubLeads active' onclick='fncSubLeadPagination(" . $x . ",". $x .")'>" . $x . "</li>";
                    }else{
    			        echo "<li id='pgSubLeads" . $x . "' class='pgnumSubLeads' onclick='fncSubLeadPagination(" . $x . ",". $x .")'>" . $x . "</li>";
                    }
		       	}
		    }
		    if($page < ($totalpages - $range)){
                	echo "<li>...</li>";
            }
		    if ($page != $totalpages && $rowCount[0] != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='fncSubLeadPagination(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='fncSubLeadPagination(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'btnDeleteSubLeads':
			if($_POST['module'] == "awareness"){
				$subinfo = mysql_fetch_array(mysql_query("SELECT Subject, Details FROM tbltrans_leads_awareness WHERE AwarenessID = '". $_POST['SubLeadsID'] ."'", $connection));
				$module = "an awareness";
				$module2 = "Awareness";
			}else if($_POST['module']== "referral"){
				$subinfo = mysql_fetch_array(mysql_query("SELECT Subject, Details FROM tbltrans_leads_referral WHERE AwarenessID = '". $_POST['SubLeadsID'] ."'", $connection));
				$module = "a referral";
				$module2 = "Referral";
			}else if($_POST['module'] == "demo"){
				$subinfo = mysql_fetch_array(mysql_query("SELECT Subject, Details FROM tbltrans_leads_demo WHERE AwarenessID = '". $_POST['SubLeadsID'] ."'", $connection));
				$module = "a demo";
				$module2 = "Demo";
			}else if($_POST['module'] == "closingmeeting"){
				$subinfo = mysql_fetch_array(mysql_query("SELECT Subject, Details FROM tbltrans_leads_closingmeeting WHERE AwarenessID = '". $_POST['SubLeadsID'] ."'", $connection));
				$module = "a closing meeting";
				$module2 = "Closing Meeting";
			}else if($_POST['module'] == "contractsigning"){
				$subinfo = mysql_fetch_array(mysql_query("SELECT Subject, Details FROM tbltrans_leads_contractsigning WHERE AwarenessID = '". $_POST['SubLeadsID'] ."'", $connection));
				$module = "a contract signing";
				$module2 = "Contract Signing";
			}
			$res = mysql_query("DELETE FROM tbltrans_leads_". $_POST['module'] ." WHERE ". $_POST['module']."ID" ." = '". $_POST['SubLeadsID'] ."' ", $connection);
			if($res == true){
				echo "1|". $_POST['module'] ." successfully deleted.";

				if($_POST['leadsID'] != ""){
					$Log .= "Prospect ID : ". $_POST['leadsID'] . "|";
				}
				if($_POST['LeadsName'] != ""){
					$Log .= "Prospect Name : ". $_POST['LeadsName'] . "|";
				}
				if($SubID != ""){
					$Log .= $module2 ." ID : ". $SubID . "|";
				}
				if($_POST['SubLeadsSubject'] != ""){
					$Log .= $module2 ." Subject : ". $_POST['SubLeadsSubject'] . "|";
				}
				if($_POST['SUbLeadDetails'] != ""){
					$Log .= $module2 ." Details : ". $_POST['SUbLeadDetails'] . "|";
				}

				$Log2 = "";

				if($Log != ""){
					$tran_logs = create_logs_per_transaction("deleted ". $module ." record.", $module2 . " Module", $Log, $Log2, "DELETE", $_POST['leadsID']);
				}

			}else{
				echo "2|Failed to delete ". $_POST['module'] .".";
			}
		break;

		
	}
?>