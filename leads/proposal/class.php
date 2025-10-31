<?php  
	session_start();
	include "../../connect.php";
	switch ($_POST['form']) {
		case "loadtblSUbLeadsPRO":
			$getFilters = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'Proposal' AND userid = '". $_POST['MMS-UserID'] ."';", $connection));
		    $Status = explode("|", $getFilters["bystat"]);
		    $Search = explode("|", $getFilters["checked_value"]);
			$UnitType = explode("|", $getFilters["xcheck"]);
		    $Date = explode("|", $getFilters["datefilter"]);

		    // FILTER BY STATUS
			$StatusCount = 0; $SelectedStatus = "";
			for($a = 0; $a<=count($Status)-2; $a++){
				if($Status[$a] == "Inquired"){ 
					$StatusVal = "(Status = 'Pending' AND Application_ID = '')"; 
				}else if($Status[$a] == "Pending"){
					$StatusVal = "((Status = 'Pending' AND Application_ID != '') OR (Status = 'For Approval' AND Application_ID != ''))"; 
				}else if($Status[$a] == "Disapproved"){ 
					$StatusVal = "(Status = 'Disapproved' AND Application_ID != '') "; 
				}else if($Status[$a] == "Approved"){ 
					$StatusVal = "(Status = 'Tentative') "; 
				}else if($Status[$a] == "Confirmed"){ 
					$StatusVal = "(Status = 'Confirmed') "; 
				}else if($Status[$a] == "Cancelled"){
				 	$StatusVal = "(Status = 'Cancelled') "; 
				}else if($Status[$a] == "Occupied"){ 
					$StatusVal = "(Status = 'Occupied') "; 
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
		    	$StatFilter = "(Status = 'Pending' AND Application_ID = '')";
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
			
		    // FILTER BY UNIT TYPE
			$UnitStatusCount = 0; $UnitStatusVal = "";
			for($b = 0; $b<=count($UnitType)-1; $b++){
				if($UnitType[$b] != ""){
					$UnitStatusCount++;
					if($UnitStatusCount == 1){
						$UnitStatusVal .= "UnitType = '". $UnitType[$b] ."'";
					}else{
						$UnitStatusVal .= " OR UnitType = '". $UnitType[$b] ."'";
					}
				}
			}

			if($UnitStatusCount > 0){
		      	if($UnitStatusCount > 1){
			      	$UnitStatusFilter = "AND (". $UnitStatusVal .")";
			    }else{
			      	$UnitStatusFilter = "AND ". $UnitStatusVal;
			    }
		    }else{
		      	if($UnitStatusCount > 1){
			      	$UnitStatusFilter = "(". $UnitStatusVal .")";
			    }else{
			      	$UnitStatusFilter = $UnitStatusVal;
			    }
		    }

		    // FILTER BY DATE RANGE
		    if($Date[0] != "" && $Date[1] != ""){
		    	$DateFilter = "AND (date_inquired BETWEEN '". date("Y-m-d", strtotime($Date[0])) ."' AND '". date("Y-m-d", strtotime($Date[1])) ."')";
		    }else{
		    	$DateFilter = "";
		    }

			$page = $_POST["page"];
            $Limit  = ($page-1) * 20;
            $result = mysql_query("SELECT Inquiry_ID, Application_ID, Mall, Mall_ID, Trade_Name, Company_Name, Industry, Address, TradeID, Company_ID, UnitID, Status, UnitType, forFinal, date_inquired FROM tbltrans_inquiry WHERE ". $StatFilter ." ". $SearchFilter ." ". $UnitStatusFilter ." ". $DateFilter ." ". getMallAccess("Mall_ID", "AND") ." ORDER BY date_inquired DESC LIMIT ". $Limit .", 20;", $connection);
            while($row = mysql_fetch_array($result)){
                if($row["Application_ID"] == ""){
                    $function = "leaseapplication(\"". $row["Inquiry_ID"] ."\")";
                    $title = "Create Leasing Application";
                }else{
                    $function = "loadapplication(\"". $row["Inquiry_ID"] ."\", \"". $row["Application_ID"] ."\");loadtelno_application(\"". $row["Inquiry_ID"] ."\", \"". $row["Application_ID"] ."\");loadaffiliate_application(\"". $row["Inquiry_ID"] ."\", \"". $row["Application_ID"] ."\");";
                    $title = "Edit Leasing Application";
                }

                if($row["Status"] == "Pending" && $row["Application_ID"] == ""){
                    $stat = "<span class='label label-lg label-inverse arrowed-in-right arrowed' style='z-index: 0;'>Inquired</span>";
                }else if($row["Application_ID"] != "" && ($row["Status"] == "Pending" || $row["Status"] == "For Approval")){
                    $stat = "<span class='label label-lg label-pink arrowed-in-right arrowed' style='z-index: 0;'>Pending Application</span>";
                }else if($row["Application_ID"] != "" && $row["Status"] == "Disapproved"){
                    $stat = "<span class='label label-lg label-danger arrowed-in-right arrowed' style='z-index: 0;'>Disapproved Application</span>";
                }else if($row["Status"] == "Tentative"){
                    $stat = "<span class='label label-lg label-info arrowed-in-right arrowed' style='z-index: 0;'>Approved Application</span>";
                }else if($row["Status"] == "Confirmed"){
                    $stat = "<span class='label label-lg label-success arrowed-in-right arrowed' style='z-index: 0;'>Confirmed</span>";
                }else if($row["Status"] == "Occupied"){
                    $stat = "<span class='label label-lg label-warning arrowed-in-right arrowed' style='z-index: 0;'>Occupied</span>";
                }else if($row["Status"] == "Cancelled"){
                    $stat = "<span class='label label-lg label-danger arrowed-in-right arrowed' style='z-index: 0;'>Cancelled Reservation</span>";
                }
                $Industry = mysql_fetch_array(mysql_query("SELECT industry FROM tblref_industry WHERE Industry_ID = '". $row['Industry'] ."';", $connection));
                echo 	"
		                <tr id='" . $row["Inquiry_ID"] . "'>
		                    <td class='scroll'>". date('m/d/Y', strtotime($row['date_inquired'])) ."</td>
		                    <td class='scroll'>". $row["Mall"] ."</td>
		                    <td class='scroll'>". $row["Trade_Name"] ."</td>
		                    <td class='hide_mobile'>". $row["Company_Name"] ."</td>
		                    <td class='hide_mobile'>". $Industry["industry"] ."</td>
		                    <td class='hide_mobile'>". $stat ."</td>
		                    <td style='z-index: 0;'>";
		                            if( ($row["Application_ID"] == "") && ($row['forFinal'] != 1) ){
		                                echo"<button class='btn btn-sm btn-info hide isadmin select-editproposal btn-round' onclick='EditSubLeadsPro(\"". $row["TradeID"] ."\", \"". $row["Company_ID"] ."\", \"". $row["Inquiry_ID"] ."\", \"". $row["UnitID"] ."\", \"". $row['Mall_ID'] ."\", \"". $row['UnitType'] ."\",\"apply\")' title='Lease Proposal' style='margin: 2px;'><img src='assets/images/resume.png' style='width: 100%; height: auto;' /></button>";
		                            }
		                            echo"<button class='btn btn-sm btn-gray hide isadmin select-viewproposal btn-round' onclick='EditSubLeadsPro(\"". $row["TradeID"] ."\", \"". $row["Company_ID"] ."\", \"". $row["Inquiry_ID"] ."\", \"". $row["UnitID"] ."\", \"". $row['Mall_ID'] ."\", \"". $row['UnitType'] ."\",\"view\")' title='View Lease Proposal' style='margin: 2px;'><img src='assets/images/view.png' style='width: 100%; height: auto;' /></button>";

		                            // EDIT Ronaldo 10222018
		                            echo"<button class='btn btn-sm btn-gray hided isadmin select-viewlogsproposal btn-round' onclick='ViewTrasactionLogs(\"". $row["Inquiry_ID"] ."\")' title='View Logs' style='margin: 2px;'><img src='assets/images/clock.png' style='width: 100%; height: auto;' /></button>";
		                            // END EDIT Ronaldo 10222018
                echo 		"</td>
		                </tr>
                		";
            }
		break;

		case 'loadtblSUbLeadsPROEntries':
			$getFilters = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'Proposal';", $connection));
		    $Status = explode("|", $getFilters["bystat"]);
		    $Search = explode("|", $getFilters["checked_value"]);
			$UnitType = explode("|", $getFilters["xcheck"]);
		    $Date = explode("|", $getFilters["datefilter"]);

		    // FILTER BY STATUS
			$StatusCount = 0; $SelectedStatus = "";
			for($a = 0; $a<=count($Status)-2; $a++){
				if($Status[$a] == "Inquired"){ 
					$StatusVal = "(Status = 'Pending' AND Application_ID = '')"; 
				}else if($Status[$a] == "Pending"){
					$StatusVal = "((Status = 'Pending' AND Application_ID != '') OR (Status = 'For Approval' AND Application_ID != ''))"; 
				}else if($Status[$a] == "Disapproved"){ 
					$StatusVal = "(Status = 'Disapproved' AND Application_ID != '') "; 
				}else if($Status[$a] == "Approved"){ 
					$StatusVal = "(Status = 'Tentative') "; 
				}else if($Status[$a] == "Confirmed"){ 
					$StatusVal = "(Status = 'Confirmed') "; 
				}else if($Status[$a] == "Cancelled"){
				 	$StatusVal = "(Status = 'Cancelled') "; 
				}else if($Status[$a] == "Occupied"){ 
					$StatusVal = "(Status = 'Occupied') "; 
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
		    	$StatFilter = "(Status = 'Pending' AND Application_ID = '')";
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
			
		    // FILTER BY SEARCHED KEYWORD
			$UnitStatusCount = 0; $UnitStatusVal = "";
			for($b = 0; $b<=count($UnitType)-1; $b++){
				if($UnitType[$b] != ""){
					$UnitStatusCount++;
					if($UnitStatusCount == 1){
						$UnitStatusVal .= "UnitType = '". $UnitType[$b] ."'";
					}else{
						$UnitStatusVal .= " OR UnitType = '". $UnitType[$b] ."'";
					}
				}
			}

			if($UnitStatusCount > 0){
		      	if($UnitStatusCount > 1){
			      	$UnitStatusFilter = "AND (". $UnitStatusVal .")";
			    }else{
			      	$UnitStatusFilter = "AND ". $UnitStatusVal;
			    }
		    }else{
		      	if($UnitStatusCount > 1){
			      	$UnitStatusFilter = "(". $UnitStatusVal .")";
			    }else{
			      	$UnitStatusFilter = $UnitStatusVal;
			    }
		    }

		    // FILTER BY DATE RANGE
		    if($Date[0] != "" && $Date[1] != ""){
		    	$DateFilter = "AND (date_inquired BETWEEN '". date("Y-m-d", strtotime($Date[0])) ."' AND '". date("Y-m-d", strtotime($Date[1])) ."')";
		    }else{
		    	$DateFilter = "";
		    }

			if($_POST["page"] == ""){ 
				$page = 1; 
			}else{ 
				$page = $_POST["page"]; 
			}
    		$limit = ($page-1) * 20;
  			$rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM tbltrans_inquiry WHERE ". $StatFilter ." ". $SearchFilter ." ". $UnitStatusFilter ." ". $DateFilter ." ". getMallAccess("Mall_ID", "AND") .";", $connection));
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

		case "loadtblSUbLeadsPROPagination":
			$getFilters = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'Proposal';", $connection));
		    $Status = explode("|", $getFilters["bystat"]);
		    $Search = explode("|", $getFilters["checked_value"]);
			$UnitType = explode("|", $getFilters["xcheck"]);
		    $Date = explode("|", $getFilters["datefilter"]);

		    // FILTER BY STATUS
			$StatusCount = 0; $SelectedStatus = "";
			for($a = 0; $a<=count($Status)-2; $a++){
				if($Status[$a] == "Inquired"){ 
					$StatusVal = "(Status = 'Pending' AND Application_ID = '')"; 
				}else if($Status[$a] == "Pending"){
					$StatusVal = "((Status = 'Pending' AND Application_ID != '') OR (Status = 'For Approval' AND Application_ID != ''))"; 
				}else if($Status[$a] == "Disapproved"){ 
					$StatusVal = "(Status = 'Disapproved' AND Application_ID != '') "; 
				}else if($Status[$a] == "Approved"){ 
					$StatusVal = "(Status = 'Tentative') "; 
				}else if($Status[$a] == "Confirmed"){ 
					$StatusVal = "(Status = 'Confirmed') "; 
				}else if($Status[$a] == "Cancelled"){
				 	$StatusVal = "(Status = 'Cancelled') "; 
				}else if($Status[$a] == "Occupied"){ 
					$StatusVal = "(Status = 'Occupied') "; 
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
		    	$StatFilter = "(Status = 'Pending' AND Application_ID = '')";
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
			
		    // FILTER BY SEARCHED KEYWORD
			$UnitStatusCount = 0; $UnitStatusVal = "";
			for($b = 0; $b<=count($UnitType)-1; $b++){
				if($UnitType[$b] != ""){
					$UnitStatusCount++;
					if($UnitStatusCount == 1){
						$UnitStatusVal .= "UnitType = '". $UnitType[$b] ."'";
					}else{
						$UnitStatusVal .= " OR UnitType = '". $UnitType[$b] ."'";
					}
				}
			}

			if($UnitStatusCount > 0){
		      	if($UnitStatusCount > 1){
			      	$UnitStatusFilter = "AND (". $UnitStatusVal .")";
			    }else{
			      	$UnitStatusFilter = "AND ". $UnitStatusVal;
			    }
		    }else{
		      	if($UnitStatusCount > 1){
			      	$UnitStatusFilter = "(". $UnitStatusVal .")";
			    }else{
			      	$UnitStatusFilter = $UnitStatusVal;
			    }
		    }

		    // FILTER BY DATE RANGE
		    if($Date[0] != "" && $Date[1] != ""){
		    	$DateFilter = "AND (date_inquired BETWEEN '". date("Y-m-d", strtotime($Date[0])) ."' AND '". date("Y-m-d", strtotime($Date[1])) ."')";
		    }else{
		    	$DateFilter = "";
		    }

			$page = $_POST["page"];
			$rowCount = mysql_fetch_row(mysql_query("SELECT COUNT(id) FROM tbltrans_inquiry WHERE ". $StatFilter ." ". $SearchFilter ." ". $UnitStatusFilter ." ". $DateFilter ." ". getMallAccess("Mall_ID", "AND") .";", $connection));
			$rowsperpage = 20;
			$range = 3;
			$totalpages = ceil($rowCount[0] / $rowsperpage);
			$prevpage;
			$nextpage;
			if($page > 1 ){
			   	echo "<li style='width:50px !important;' onclick='loadtblSUbLeadsPROPageFunc(1)'><< First</li>";
			   	$prevpage = $page - 1;
			   	echo "<li style='width:70px !important;' onclick='loadtblSUbLeadsPROPageFunc(". $prevpage .")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   	if (($x > 0) && ($x <= $totalpages)){
			      	if ($x == $page){
		   				echo "<li id='pgptnts" . $x . "' class='pgnumptnts active' onclick='loadtblSUbLeadsPROPageFunc(" . $x . ",". $x .")'>" . $x . "</li>"; 
		   			}else{
						echo "<li id='pgptnts" . $x . "' class='pgnumptnts' onclick='loadtblSUbLeadsPROPageFunc(" . $x . ",". $x .")'>" . $x . "</li>"; }
		      		}
		    }
		    if($page < ($totalpages - $range)){ 
		    	echo "<li>...</li>"; 
		    }
		    if ($page != $totalpages && $rowCount[0] != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='loadtblSUbLeadsPROPageFunc(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='loadtblSUbLeadsPROPageFunc(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'displayProposal':
			if(SysLeaseSetup('softwaretype') == "5"){	
				$res = mysql_query("SELECT id, UnitID, UnitRate, AssocDues, Months, Percentage, DownpaymentType, Downpayment, OccupancyStartDate, isMain, MallID FROM tbltrans_proposal_pass WHERE InquiryID = '". $_POST['inquiryID'] ."';", $connection);
				while($row = mysql_fetch_array($res)){
				$UnitName = mysql_fetch_array(mysql_query("SELECT unitname, typeofbusiness FROM tblref_unit WHERE unitid = '". $row['UnitID'] ."';", $connection));

				if($row['DownpaymentType'] == "Percentage"){
					$Downpayment = number_format($row['Downpayment'], "0", "", "");
				}else{
					$Downpayment = number_format($row['Downpayment'], "2", ".", ",");
				}

				if($row['isMain'] == "1"){
					$Status = "Active";
				}else{
					$Status = "<button class='btn btn-sm btn-success btn-round' onclick='setDefault2(\"". $row['id'] ."\")'>Set as Active</button>";
				}

				$tdFunction = "onclick='fncModProPASS(\"". $row['id'] ."\", \"". $row['UnitID'] ."\", \"". $UnitName['typeofbusiness'] ."\", \"". $row['MallID'] ."\" , \"". date('m/d/Y', strtotime($row['OccupancyStartDate'])) ."\", \"". number_format($row['Months'], "0", "", "") ."\", \"". number_format($row['Percentage'], "0", "", "") ."\", \"". $row['DownpaymentType'] ."\", \"". $Downpayment ."\")';";
 
					echo 	"<tr>
								<td ". $tdFunction .">". $UnitName['unitname'] ."</td>
								<td ". $tdFunction .">". date('m/d/Y', strtotime($row['OccupancyStartDate'])) ."</td>
								<td ". $tdFunction .">". number_format($row['Months'], "0", "", "") ."</td>
								<td ". $tdFunction .">". number_format($row['UnitRate'], "2", ".", ",") ."</td>
								<td ". $tdFunction .">". number_format($row['Percentage'], "0", "", "") ."</td>
								<td ". $tdFunction .">". number_format($row['AssocDues'], "2", ".", ",") ."</td>
								<td>". $Status ."</td>
								<td style='text-align: center;'><button class='btn btn-sm btn-gray btn-round' title='Print Proposal' onclick='fncPrintPASSProposal(\"". $row['id'] ."\", \"". $_POST['inquiryID'] ."\", \"". $row['MallID'] ."\", \"". $row['UnitID'] ."\", \"". $row['Months'] ."\", \"". $row['Percentage'] ."\", \"". $row['UnitRate'] ."\", \"". $row['OccupancyStartDate'] ."\", \"". $row['DownpaymentType'] ."\", \"". $row['Downpayment'] ."\")'><img src='assets/images/printer.png' style='width: 100%; height: auto;' /></button></td>
							</tr>";
				}
			}else{
				$num = mysql_num_rows(mysql_query("SELECT proposalNum FROM tbltrans_proposal WHERE inquiryID = '". $_POST['inquiryID'] ."';", $connection));
				$ownername = mysql_fetch_array(mysql_query("SELECT CONCAT(b.owner_firstname, ' ', b.owner_lastname) FROM tbltrans_inquiry AS a LEFT JOIN tbltrans_company AS b ON a.Company_ID = b.CompanyID;", $connection));
				if($num == 0){
					$row = mysql_fetch_array(mysql_query("SELECT UnitID, UnitType, dateFrom, dateTo, desired_noofmonths, monthly_dues, daily_dues, assoc_dues, payment_terms, payment_type, datefrom, dateto, desired_noofmonths, desired_noofdays, forFinal, Mall_ID, Trade_Name, Mall FROM tbltrans_inquiry WHERE Inquiry_ID = '". $_POST['inquiryID'] ."' ", $connection));

					$rowUnitName = mysql_fetch_array(mysql_query("SELECT unitname, floorid, sqmunitsetup, pricepersqmunitsetup, totalamountunitsetup, mallid, area FROM tblref_unit WHERE unitid = '". $row[0] ."'", $connection));

					$rowFloorName = mysql_fetch_array(mysql_query("SELECT floor FROM tblref_floorsetup WHERE floorid = '". $rowUnitName['floorid'] ."'", $connection));

					if($row['desired_noofdays'] == 0){
						$LeasePeriod = $row['desired_noofmonths'] . " months";
					}else{
						$LeasePeriod = $row['desired_noofmonths'] . " months and " . $row['desired_noofdays'] . " days";
					}

					if($row[2] == "0000-00-00" || $row[2] == ""){
						$dateFrom = "";
					}else{
						$dateFrom = date('m/d/Y', strtotime($row[2]));
					}

					if($row[3] == "0000-00-00" || $row[3] == ""){
						$dateTo = "";
					}else{
						$dateTo = date('m/d/Y', strtotime($row[3]));
					}

					if(SysLeaseSetup('floorandunitmeasurement') == 'Area'){
						$FloorArea = $rowUnitName['area'];
					}else{
						$FloorArea = $rowUnitName['sqmunitsetup'];
					}

					$onclick = "onclick='selectProUnitInfo(\"". $_POST['inquiryID'] . "\", \"". $row['UnitID'] ."\", \"0\", \"". $row['UnitType'] ."\", \"". $_POST['type'] ."\")'";
					
					echo "<tr class='kulayan'>
							<td ". $onclick .">". $rowUnitName[0] ."</td>
							<td ". $onclick .">". $dateFrom ."</td>
							<td ". $onclick .">". $dateTo ."</td>
							<td ". $onclick ." align='right'>". number_format($row[5], 2) ."</td>";
							if(SysLeaseSetup('isAssocDues') == "1"){
								echo "<td ". $onclick ." align='right'>". number_format($row[7], 2) ."</td>";
							}
					echo 	"<td ". $onclick .">Default</td>
							<td align='center'>
								<div class='btn-group'>
									<button class='btn btn-info btn-sm btn-round' onclick='printProposal(\"". $row['Mall_ID'] ."\", \"". $ownername[0] ."\", \"". $row['Trade_Name'] ."\", \"". $rowFloorName['floor'] ."\", \"". $row['Mall'] ."\", \"". $rowUnitName['unitname'] ."\", \"". number_format($FloorArea, "0", "", ",") ." sqm\", \"". $LeasePeriod ."\", \" ₱". number_format($rowUnitName['pricepersqmunitsetup'], "2", ".", ",") ." / sqm / month or ₱ " . number_format($rowUnitName['totalamountunitsetup'], "2", ".", ",") ." / month\", \"\",	 \"\", \"". $row['payment_type'] ."\", \"\", \"\", \"\", \"\", \"\", \"\", \"". $_POST['inquiryID'] ."\", \"0\", \"All\");'>Print All</button>
									<button data-toggle='dropdown' class='btn btn-info btn-sm dropdown-toggle btn-round' aria-expanded='false'>
										<span class='ace-icon fa fa-caret-down icon-only'></span>
									</button>
									<ul class='dropdown-menu dropdown-info dropdown-menu-right'>
										<li>
											<a href='#' onclick='printProposal(\"". $row['Mall_ID'] ."\", \"". $ownername[0] ."\", \"". $row['Trade_Name'] ."\", \"". $rowFloorName['floor'] ."\", \"". $row['Mall'] ."\", \"". $rowUnitName['unitname'] ."\", \"". number_format($FloorArea, "0", "", ",") ." sqm\", \"". $LeasePeriod ."\", \" ₱". number_format($rowUnitName['pricepersqmunitsetup'], "2", ".", ",") ." / sqm / month or ₱ " . number_format($rowUnitName['totalamountunitsetup'], "2", ".", ",") ." / month\", \"\",	 \"\", \"". $row['payment_type'] ."\", \"\", \"\", \"\", \"\", \"\", \"\", \"". $_POST['inquiryID'] ."\", \"0\", \"Charges\");'>Charges</a>
										</li>
										<li>
											<a href='#' onclick='printProposal(\"". $row['Mall_ID'] ."\", \"". $ownername[0] ."\", \"". $row['Trade_Name'] ."\", \"". $rowFloorName['floor'] ."\", \"". $row['Mall'] ."\", \"". $rowUnitName['unitname'] ."\", \"". number_format($FloorArea, "0", "", ",") ." sqm\", \"". $LeasePeriod ."\", \" ₱". number_format($rowUnitName['pricepersqmunitsetup'], "2", ".", ",") ." / sqm / month or ₱ " . number_format($rowUnitName['totalamountunitsetup'], "2", ".", ",") ." / month\", \"\",	 \"\", \"". $row['payment_type'] ."\", \"\", \"\", \"\", \"\", \"\", \"\", \"". $_POST['inquiryID'] ."\", \"0\", \"Requirements\");'>Requirements And Permits</a>
										</li>
										<li>
											<a href='#' onclick='printProposal(\"". $row['Mall_ID'] ."\", \"". $ownername[0] ."\", \"". $row['Trade_Name'] ."\", \"". $rowFloorName['floor'] ."\", \"". $row['Mall'] ."\", \"". $rowUnitName['unitname'] ."\", \"". number_format($FloorArea, "0", "", ",") ." sqm\", \"". $LeasePeriod ."\", \" ₱". number_format($rowUnitName['pricepersqmunitsetup'], "2", ".", ",") ." / sqm / month or ₱ " . number_format($rowUnitName['totalamountunitsetup'], "2", ".", ",") ." / month\", \"\",	 \"\", \"". $row['payment_type'] ."\", \"\", \"\", \"\", \"\", \"\", \"\", \"". $_POST['inquiryID'] ."\", \"0\", \"TermsAndConditions\");'>Terms And Conditions Only</a>
										</li>
									</ul>
								</div>
							</td>				
						</tr>";
				}else{
					$res = mysql_query("SELECT unitID, unitType, dateFrom, dateTo, desiredMonths, monthlyDues, dailyDues, assocDues, stats, id, desiredDays,  escalation_rate, year_start, rent_free_construction, construction_deposit, security_deposit, payment_schedule, charges_list, requirement_list, paymentType, paymentTerms, permit_list, construction_deposit_type, security_deposit_type, construction_deposit_terms, security_deposit_terms, vattype, rent_free_construction_start_date, year_basis, terms_condition, proposalNum FROM tbltrans_proposal WHERE inquiryID = '". $_POST['inquiryID'] ."'", $connection);
					while($row = mysql_fetch_array($res)){

						$rowUnitName = mysql_fetch_array(mysql_query("SELECT unitname, floorid, sqmunitsetup, pricepersqmunitsetup, totalamountunitsetup, mallid, area FROM tblref_unit WHERE unitid = '". $row[0] ."'", $connection));		

						$rowFloorName = mysql_fetch_array(mysql_query("SELECT floor FROM tblref_floorsetup WHERE floorid = '". $rowUnitName['floorid'] ."'", $connection));

						$inqinfo = mysql_fetch_array(mysql_query("SELECT payment_terms, payment_type, forFinal, Mall_ID, Trade_Name, Mall FROM tbltrans_inquiry WHERE Inquiry_ID = '". $_POST['inquiryID'] ."'", $connection));

						if($row['dateFrom'] == "0000-00-00" || $row['dateFrom'] == ""){
							$dateFrom = "";
						}else{
							$dateFrom = date('m/d/Y', strtotime($row['dateFrom']));
						}

						if($row['dateTo'] == "0000-00-00" || $row['dateTo'] == ""){
							$dateTo = "";
						}else{
							$dateTo = date('m/d/Y', strtotime($row['dateTo']));
						}

						if($row['stats'] == 1){
							$kulayan = "kulayan";
						}else{
							$kulayan = "";
						}

						if($_POST['type'] == "view"){
							$disme = "disabled";
						}else{
							$disme = "";
						}

						if($row['desiredDays'] == 0){
							$LeasePeriod = $row['desiredMonths'] . " months";
						}else{
							$LeasePeriod = $row['desiredMonths'] . " months and " . $row['desiredDays'] . " days";
						}

						if($row['security_deposit_type'] == "Fixed"){
							$SecurityDeposit = "₱ " . number_format($row['security_deposit'], "2", ".", ",");
						}else{
							$SecurityDeposit = "Equivalent to ". floatval($row['security_deposit']) . " Month(s) basic rent. Payable ". $row['security_deposit_terms'] ." days after the issuance of Certificate of Award. Refundable upon expiration of the Contract of Lease";
						}

						if($row['construction_deposit_type'] == "Fixed"){
							$ConstructionDeposit = "₱ " . number_format($row['security_deposit'], "2", ".", ",");
						}else{
							$ConstructionDeposit = "Equivalent to " . floatval($row['security_deposit']) . " Month(s) basic rent. Refundable ". floatval($row['construction_deposit_terms']) ." days upon completion of renovation works and compliance to refund policy";
						}

						$Adv = explode("#", $row['payment_schedule']);
				      	for($a = 0; $a <= COUNT($Adv)-2; $a++){
							$Adv2 = explode("P", $Adv[$a]);
				      	}

				      	if($row['vattype'] == "inc"){
				      		$VATType = "(inclusive of VAT)";
				      	}else{
				      		$VATType = "(exclusive of VAT)";
				      	}

				      	if(SysLeaseSetup('floorandunitmeasurement') == 'Area'){
							$FloorArea = $rowUnitName['area'];
						}else{
							$FloorArea = $rowUnitName['sqmunitsetup'];
						}

						if($row['rent_free_construction'] == 0){
							$RentFreeCons = "Not Applicable";
						}else{
							$RentFreeCons = $row['rent_free_construction'] . " days starting ". date('F d, Y', strtotime($row['rent_free_construction_start_date']));
						}

				      	$AdvanceRent = "Equivalent to ". floatval(COUNT($Adv)-1) . " month(s) rent ". $VATType;

						$onclick = "onclick='selectProUnitInfo(\"". $_POST['inquiryID'] . "\", \"". $row['unitID'] ."\", \"". $row['id'] ."\", \"". $row['unitType'] ."\", \"". $_POST['type'] ."\")'";

						if($row['stats'] == 1){
							$isActive = "Active";
						}else{
							$isActive = "<button class='btn btn-sm btn-success btn-round' ". $disme ." onclick='setDefault(\"". $row['id'] ."\")'>Set as active</button>";
						}

						if($row['year_basis'] > 0 && $row['year_basis'] != ""){
							$Escalation = $row['escalation_rate'] . "% annually starting Year " . $row['year_start'] . " applied every " . $row['year_basis'] . " year";
						}else{
							$Escalation = $row['escalation_rate'] . "% annually starting Year " . $row['year_start'];
						}

						echo "<tr class='". $kulayan ."'>
									<td  ". $onclick .">". $rowUnitName[0] ."</td>
									<td  ". $onclick .">". $dateFrom ."</td>
									<td  ". $onclick .">". $dateTo ."</td>
									<td  ". $onclick ." align='right'>". number_format($row[5], 2) ."</td>";
									if(SysLeaseSetup('isAssocDues') == "1"){
										echo "<td ". $onclick ." align='right'>". number_format($row[7], 2) ."</td>";
									}
							echo 	"<td>". $isActive ."</td>
									<td align='center'>
										<div class='btn-group'>
											<button class='btn btn-info btn-sm btn-round' onclick='printProposal(\"". $inqinfo['Mall_ID'] ."\", \"". $ownername[0] ."\", \"". $inqinfo['Trade_Name'] ."\", \"". $rowFloorName['floor'] ."\", \"". $inqinfo['Mall'] ."\", \"". $rowUnitName['unitname'] ."\", \"". number_format($FloorArea, "0", "", ",") ." sqm\", \"". $LeasePeriod ."\", \"₱ ". number_format($rowUnitName['pricepersqmunitsetup'], "2", ".", ",") ." / sqm / month or ₱ " . number_format($rowUnitName['totalamountunitsetup'], "2", ".", ",") ." / month\", \"". $RentFreeCons ."\", \"". $Escalation ."\", \"". $row['paymentType'] ."\", \"". $ConstructionDeposit ."\", \"". $AdvanceRent ."\",\"". $SecurityDeposit ."\", \"". $row['charges_list'] ."\", \"". $row['requirement_list'] ."\", \"". $row['permit_list'] ."\", \"". $_POST['inquiryID'] ."\", \"". $row['proposalNum'] ."\", \"All\");'>Print All</button>
											<button data-toggle='dropdown' class='btn btn-info btn-sm dropdown-toggle btn-round' aria-expanded='false'>
												<span class='ace-icon fa fa-caret-down icon-only'></span>
											</button>
											<ul class='dropdown-menu dropdown-info dropdown-menu-right'>
												<li>											
													<a href='#' onclick='printProposal(\"". $inqinfo['Mall_ID'] ."\", \"". $ownername[0] ."\", \"". $inqinfo['Trade_Name'] ."\", \"". $rowFloorName['floor'] ."\", \"". $inqinfo['Mall'] ."\", \"". $rowUnitName['unitname'] ."\", \"". number_format($FloorArea, "0", "", ",") ." sqm\", \"". $LeasePeriod ."\", \"₱ ". number_format($rowUnitName['pricepersqmunitsetup'], "2", ".", ",") ." / sqm / month or ₱ " . number_format($rowUnitName['totalamountunitsetup'], "2", ".", ",") ." / month\", \"". $RentFreeCons ."\", \"". $Escalation ."\", \"". $row['paymentType'] ."\", \"". $ConstructionDeposit ."\", \"". $AdvanceRent ."\",\"". $SecurityDeposit ."\", \"". $row['charges_list'] ."\", \"". $row['requirement_list'] ."\", \"". $row['permit_list'] ."\", \"". $_POST['inquiryID'] ."\", \"". $row['proposalNum'] ."\", \"Charges\");'>Charges</a>
												</li>
												<li>
													<a href='#' onclick='printProposal(\"". $inqinfo['Mall_ID'] ."\", \"". $ownername[0] ."\", \"". $inqinfo['Trade_Name'] ."\", \"". $rowFloorName['floor'] ."\", \"". $inqinfo['Mall'] ."\", \"". $rowUnitName['unitname'] ."\", \"". number_format($FloorArea, "0", "", ",") ." sqm\", \"". $LeasePeriod ."\", \"₱ ". number_format($rowUnitName['pricepersqmunitsetup'], "2", ".", ",") ." / sqm / month or ₱ " . number_format($rowUnitName['totalamountunitsetup'], "2", ".", ",") ." / month\", \"". $RentFreeCons ."\", \"". $Escalation ."\", \"". $row['paymentType'] ."\", \"". $ConstructionDeposit ."\", \"". $AdvanceRent ."\",\"". $SecurityDeposit ."\", \"". $row['charges_list'] ."\", \"". $row['requirement_list'] ."\", \"". $row['permit_list'] ."\", \"". $_POST['inquiryID'] ."\", \"". $row['proposalNum'] ."\", \"Requirements\");'>Requirements And Permits</a>
												</li>
												<li>
													<a href='#' onclick='printProposal(\"". $inqinfo['Mall_ID'] ."\", \"". $ownername[0] ."\", \"". $inqinfo['Trade_Name'] ."\", \"". $rowFloorName['floor'] ."\", \"". $inqinfo['Mall'] ."\", \"". $rowUnitName['unitname'] ."\", \"". number_format($FloorArea, "0", "", ",") ." sqm\", \"". $LeasePeriod ."\", \"₱ ". number_format($rowUnitName['pricepersqmunitsetup'], "2", ".", ",") ." / sqm / month or ₱ " . number_format($rowUnitName['totalamountunitsetup'], "2", ".", ",") ." / month\", \"". $RentFreeCons ."\", \"". $Escalation ."\", \"". $row['paymentType'] ."\", \"". $ConstructionDeposit ."\", \"". $AdvanceRent ."\",\"". $SecurityDeposit ."\", \"". $row['charges_list'] ."\", \"". $row['requirement_list'] ."\", \"". $row['permit_list'] ."\", \"". $_POST['inquiryID'] ."\", \"". $row['proposalNum'] ."\", \"TermsAndConditions\");'>Terms And Conditions</a>
												</li>
											</ul>
										</div>
									</td>
								</tr>";
					}
				}
			}
		break;

		case 'DisplayProInfo':
			$ProInfo = mysql_fetch_array(mysql_query("SELECT unitType, dateFrom, dateTo, desiredMonths, desiredDays, monthlyDues, dailyDues, assocDues, paymentType, paymentTerms, escalation_rate, year_start, rent_free_construction, construction_deposit, construction_deposit_terms, security_deposit, security_deposit_terms, advance_terms, payment_schedule, charges_list, requirement_list, permit_list, terms_condition, isRent, vattype, vatpercent, construction_deposit_type, security_deposit_type, year_basis, rent_free_construction_start_date, BillingStartDate FROM tbltrans_proposal WHERE inquiryID = '". $_POST['inquiryID'] ."' AND id = '". $_POST['ProID'] ."' ", $connection));

			if($ProInfo['construction_deposit_type'] == "Monthly"){
				$ConsDep = floatval($ProInfo['construction_deposit']);
			}else{
				$ConsDep = number_format($ProInfo['construction_deposit'], "2", ".", ",");
			}

			if($ProInfo['security_deposit_type'] == "Monthly"){
				$SecDep = floatval($ProInfo['security_deposit']);
			}else{
				$SecDep = number_format($ProInfo['security_deposit'], "2", ".", ",");
			}

			echo date('m/d/Y', strtotime($ProInfo['dateFrom']))
			 . "@" . date('m/d/Y', strtotime($ProInfo['dateTo']))
			 . "@" . $ProInfo['desiredMonths']
			 . "@" . $ProInfo['desiredDays']
			 . "@" . floatval($ProInfo['monthlyDues'])
			 . "@" . floatval($ProInfo['dailyDues'])
			 . "@" . floatval($ProInfo['assocDues'])
			 . "@" . $ProInfo['paymentType']
			 . "@" . $ProInfo['paymentTerms']
			 . "@" . $ProInfo['escalation_rate']
			 . "@" . $ProInfo['year_start']
			 . "@" . $ProInfo['rent_free_construction']
			 . "@" . $ConsDep
			 . "@" . $ProInfo['construction_deposit_terms']
			 . "@" . $SecDep
			 . "@" . $ProInfo['security_deposit_terms']
			 . "@" . $ProInfo['advance_terms']
			 . "@" . $ProInfo['payment_schedule']
			 . "@" . $ProInfo['charges_list']
			 . "@" . $ProInfo['requirement_list']
			 . "@" . $ProInfo['permit_list']
			 . "@" . trim($ProInfo['terms_condition'])
			 . "@" . $ProInfo['isRent']
			 . "@" . $ProInfo['vattype']
			 . "@" . $ProInfo['vatpercent']
			 . "@" . $ProInfo['construction_deposit_type']
			 . "@" . $ProInfo['security_deposit_type']
			 . "@" . $ProInfo['year_basis']
			 . "@" . date('m/d/Y', strtotime($ProInfo['rent_free_construction_start_date']))
			 . "@" . date('m/d/Y', strtotime($ProInfo['BillingStartDate']));
		break;

		case 'LeadsProShrtctUnit':
			$page = $_POST['page'];
			$limit = ($page-1) * 20;
			$sql = "SELECT unitid, unitname, max_num, Status FROM tblref_unit WHERE (MainUnit IS NULL OR MainUnit = '') AND typeofbusiness = '". $_POST['UnitType'] ."' AND (unitid LIKE '%". $_POST['key'] ."%' OR unitname LIKE '%". $_POST['key'] ."%') AND mallid = '". $_POST['MallID'] ."' AND status = 'Vacant' LIMIT ". $limit .", 20;";
			$res = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($res)){
				echo "	<tr onclick='ViewUnitInformation(\"". $row["unitid"] ."\")'>
							<td>". $row[0] ."</td>
							<td>". $row[1] ."</td>
						</tr>";
			}
		break;

		case 'LeadsProShrtctUnitEntries':
			if($_POST["page"] == ""){
				$page = 1;
			}else{
				$page = $_POST["page"];
			}
			$limit = ($page-1) * 20;
			$rowCount = mysql_num_rows(mysql_query("SELECT id FROM tblref_unit WHERE (MainUnit IS NULL OR MainUnit = '') AND typeofbusiness = '". $_POST['UnitType'] ."' AND (unitid LIKE '%". $_POST['key'] ."%' OR unitname LIKE '%". $_POST['key'] ."%') AND mallid = '". $_POST['MallID'] ."' AND status = 'Vacant';", $connection));
			$rowsperpage = 20;
			$totalpages = ceil($rowCount / $rowsperpage);
			$upto = $limit + 20;
			$from = $limit + 1;
			if($page == $totalpages && $rowCount != 0){
				echo "Showing " . $from . " to " . $rowCount . " of " . $rowCount . " entries";
			}else{
				if($rowCount == 0){
					echo "";
				}else if($rowCount <= 19 && $rowCount != 0){
					echo "Showing 1 to " . $rowCount . " of " . $rowCount . " entries";
				}else if($rowCount >= 20 && $rowCount != 0){
					echo "Showing " . $from . " to " . $upto . " of " . $rowCount . " entries";
				}
			}
		break;

		case 'LeadsProShrtctUnitPagination':
			$page = $_POST["page"];
			$rowCount = mysql_num_rows(mysql_query("SELECT id FROM tblref_unit WHERE (MainUnit IS NULL OR MainUnit = '') AND typeofbusiness = '". $_POST['UnitType'] ."' AND (unitid LIKE '%". $_POST['key'] ."%' OR unitname LIKE '%". $_POST['key'] ."%') AND mallid = '". $_POST['MallID'] ."' AND status = 'Vacant';", $connection));
			$rowsperpage = 20;
			$range = 3;
			$totalpages = ceil($rowCount / $rowsperpage);
			$prevpage;
			$nextpage;
			if($page > 1 ){
			   	echo "<li style='width:50px !important;' onclick='btnLeadsProShrtctUnit(1)'><< First</li>";
			   	$prevpage = $page - 1;
			   	echo "<li style='width:70px !important;' onclick='btnLeadsProShrtctUnit(". $prevpage .")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if (($x > 0) && ($x <= $totalpages)){
					if ($x == $page){
						echo "<li id='pgLeadsInqShrtctUnit" . $x . "' class='pgnumLeadsInqShrtctUnit active' onclick='btnLeadsProShrtctUnit(" . $x . ",". $x .")'>" . $x . "</li>";
					}else{
						echo "<li id='pgLeadsInqShrtctUnit" . $x . "' class='pgnumLeadsInqShrtctUnit' onclick='btnLeadsProShrtctUnit(" . $x . ",". $x .")'>" . $x . "</li>";
					}
				}
			}
			if($page < ($totalpages - $range)){
				echo "<li>...</li>";
			}
			if ($page != $totalpages && $rowCount != 0){
			   	$nextpage = $page + 1;
			   	echo "<li style='width:50px !important;' onclick='btnLeadsProShrtctUnit(". $nextpage .", ". $nextpage .")'>Next ></li>";
			   	echo "<li style='width:50px !important;' onclick='btnLeadsProShrtctUnit(". $totalpages .", ". $totalpages .")'>Last >></li>";
			}
		break;

		case 'SelectThisUnit':
			$UnitIDS = mysql_fetch_array(mysql_query("SELECT wingid, floorid, classid, depid, catid, unitname, sqmunitsetup, sqm_width, sqm_height, pricepersqmunitsetup, totalamountunitsetup, assocdues, area, typeofbusiness, mallid FROM tblref_unit WHERE unitid = '". $_POST['unitid'] ."';", $connection));
			$Wing = mysql_fetch_array(mysql_query("SELECT wing FROM tblref_wing WHERE wingID = '". $UnitIDS['wingid'] ."';", $connection));
			$Floor = mysql_fetch_array(mysql_query("SELECT floor FROM tblref_floorsetup WHERE floorid = '". $UnitIDS['floorid'] ."';", $connection));
			$Classification = mysql_fetch_array(mysql_query("SELECT classification FROM tblref_merchandise_class WHERE classificationID = '". $UnitIDS['classid'] ."';", $connection));
			$Department = mysql_fetch_array(mysql_query("SELECT department FROM tblref_merchandise_depa WHERE departmentID = '". $UnitIDS['depid'] ."';", $connection));
			$Category = mysql_fetch_array(mysql_query("SELECT category FROM tblref_merchandisedep_cat WHERE categoryID = '". $UnitIDS['catid'] ."';", $connection));
			$Mall = mysql_fetch_array(mysql_query("SELECT mallname FROM tblref_mall WHERE mallid = '". $UnitIDS['mallid'] ."';", $connection));

			if(SysLeaseSetup('floorandunitmeasurement') == 'Area'){
				$UnitArea = $UnitIDS['area'];
			}else{	
				$UnitArea = $UnitIDS['sqmunitsetup'];
			}

			echo $UnitIDS['classid'] . "|" . $Classification[0] . "|" . $UnitIDS['depid'] . "|" . $Department[0] . "|" . $UnitIDS['catid'] . "|" . $Category[0] . "|" . $UnitIDS['wingid'] . "|" . $Wing[0] . "|" . $UnitIDS['floorid'] . "|" . $Floor[0] . "|" . $_POST['unitid'] . "|" .  $UnitIDS['unitname'] . "|" . floatval($UnitArea) . "|" . floatval($UnitIDS['sqm_width']) . "|" . floatval($UnitIDS['sqm_height']) . "|" . number_format($UnitIDS['pricepersqmunitsetup'], "2", ".", ",") . "|" . number_format($UnitIDS['totalamountunitsetup'], "2", ".", ",") . "|" . number_format($UnitIDS['assocdues'], "2", ".", ",") . "|" . number_format(floatval($UnitIDS['totalamountunitsetup']) + floatval($UnitIDS['assocdues']), "2", ".", ",") . "|" . $UnitIDS['mallid'] . "|" . $Mall[0] . "|" . $UnitIDS['typeofbusiness'];
		break;

		case 'showOccupancyDateTo':
			$refDate = $_POST["datefrom"];
			$Months = intval($_POST["months"]);
			$Days = intval($_POST["days"]);
			$TotalMonthly = floatval($_POST['monthlydues']) + floatval($_POST['assocdues']);
			$TotalAmount = 0;
			if($_POST["UnitType"] == "LCA"){
				if($_POST['days'] > 0 && $_POST['days'] != ''){
					$PlusDay = " +". $_POST['days'] ."day";
				}else{
					$PlusDay = "";
				}
				if($_POST['months'] > 0 && $_POST['months'] != ''){
					$PlusMonth = " +". $_POST['months'] ."month";
				}else{
					$PlusMonth = "";
				}
			
				$refDate = date('Y-m-d', strtotime($refDate . $PlusMonth . $PlusDay));

				$Daily = floatval($_POST['monthlydues']) / date('t', strtotime($refDate));

				if($Days != ""){
					$TotalAmount = ($TotalMonthly * $Months) + ($Daily * floatval($Days));
				}else{
					$TotalAmount = $TotalMonthly * $Months;
				}
			}else{
				$refDate = date( 'm/d/Y', strtotime($refDate . '+'. $Months .' month') );
				$TotalAmount += $TotalMonthly * $Months;
			}

			// if(SysLeaseSetup('isOccupancy') == '1'){
				$isOccupancy = ' -1 day';
			// }else{
			// 	$isOccupancy = '';
			// }

			echo date('m/d/Y', strtotime($refDate.$isOccupancy)) . "|" . number_format($TotalAmount, "2", ".", ",") . "|" . number_format($Daily, "2", ".", ",") . "|" . number_format($TotalMonthly, "2", ".", ",");
		break;

		case 'EditSubLeadsPro':
			$sql = mysql_fetch_array(mysql_query("SELECT date_inquired, inq_by, date_modified, mod_by, time_inquired FROM tbltrans_inquiry WHERE Inquiry_ID = '". $_POST['InquiryID'] ."'", $connection));
			if($sql[0] == ""){
				$datecreated = "";
			}else{
				$datecreated = date("F d, Y h:i:s A", strtotime($sql[0].$sql[4]));
			}

			if($sql[2] == ""){
				$datemodified = "";
			}else{
				$datemodified = date("F d, Y h:i:s A", strtotime($sql[2]));
			}
			echo $datecreated . "|" . $sql[1] . "|" . $datemodified . "|" . $sql[3];
		break;

		case 'saveProposal':
			$sql = "SELECT proposalNum, stats FROM tbltrans_proposal WHERE inquiryID = '". $_POST['inquiryID'] ."' ORDER BY ID DESC LIMIT 1;";
			$res = mysql_query($sql, $connection);
			$row = mysql_fetch_array($res);
			$sql2 = "";
			if($row[0] == ""){
				$termsandconlist = explode("|", $_POST['TermsandCon']);
				for ($i=0; $i <= count($termsandconlist)-2; $i++) { 
					$selectby1 = mysql_fetch_array(mysql_query("SELECT Group_Name, Term_Name, Description FROM tblcondition WHERE Term_ID = '". $termsandconlist[$i] ."';", $connection));
					$gname .= $selectby1[0]."|";
					$tname .= $selectby1[1]."|";
					$cond .= $selectby1[2]."|";
				}
				$res2 = mysql_query("INSERT INTO tbltrans_proposal SET proposalNum = '1', inquiryID = '". $_POST['inquiryID'] ."', unitID = '". $_POST['unitID'] ."', unitType = '". $_POST['UnitType'] ."', dateFrom = '". date('Y-m-d', strtotime($_POST['dateFrom'])) ."', dateTo = '". date('Y-m-d', strtotime($_POST['dateTo'])) ."', desiredMonths = '". $_POST['monthnum'] ."', desiredDays = '". $_POST['daynum'] ."', monthlyDues = '". $_POST['monthlyDues'] ."', dailyDues = '". $_POST['dailyDues'] ."', assocDues = '". $_POST['assocDues'] ."', paymentType = '". $_POST['pymenttype'] ."', paymentTerms = '". $_POST['pymentterms'] ."', escalation_rate = '". $_POST['EscalationRate'] ."', year_start = '". $_POST['EscaRateStart'] ."', rent_free_construction = '". $_POST['RentFreeCons'] ."', construction_deposit = '". $_POST['ConBondMonth'] ."', security_deposit = '". $_POST['SecurityDeposit'] ."', payment_schedule = '". $_POST['SelectedAdv'] ."', charges_list = '". $_POST['Charges'] ."', requirement_list = '". $_POST['Requirements'] ."', permit_list = '". $_POST['Permits'] ."', construction_deposit_terms = '". $_POST['ConBondMonthTerms'] ."', security_deposit_terms = '". $_POST['SecurityDepositTerms'] ."', advance_terms = '". $_POST['AdvanceMonthAmountTerms'] ."', terms_condition = '". $_POST['TermsandCon'] ."', isRent = '". $_POST['isRent'] ."', vattype = '". $_POST['VatType'] ."', vatpercent = '". $_POST['VatPercent'] ."', construction_deposit_type = '". $_POST['isConDeposit'] ."', security_deposit_type = '". $_POST['isSecDeposit'] ."', stats = '1', year_basis = '". $_POST['EscaYearBasis'] ."', rent_free_construction_start_date = '". date('Y-m-d', strtotime($_POST['RentFreeConsStartDate'])) ."', terms_condition_group = '". mysql_escape_string($gname) ."', terms_condition_term = '". mysql_escape_string($tname) ."', terms_condition_cond = '". mysql_escape_string($cond) ."', BillingStartDate = '". date('Y-m-d', strtotime($_POST['BillStartDate'])) ."';", $connection);

				$arrHeader = ["Proposal Number", "Inquiry ID", "Unit ID", "Unit Type", "Date From", "Date To", "Desired Months", "Desired Days", "Monthly Dues", "Daily Dues", "Association Dues", "Payment Type", "Payment Terms", "Escalation Rate", "Year Start", "Rent Free Construction", "Construction Deposit", "Security Deposit", "Advance Payment Schedule", "Charges List", "Requirement List", "Permit List", "Construction Deposit Terms", "Security Deposit Terms", "Advance Terms", "Terms Condition", "Is Rent", "VAT Type", "VAT Percent", "Construction Deposit Type", "Security Deposit Type", "Year Basis", "Rent Free Construction Start Date", "Terms Condition Group", "Terms Condition Term", "Terms Condition Cond", "Billing Start Date"];

				$arrFields = ["proposalNum", "inquiryID", "unitID", "unitType", "dateFrom", "dateTo", "desiredMonths", "desiredDays", "monthlyDues", "dailyDues", "assocDues", "paymentType", "paymentTerms", "escalation_rate", "year_start", "rent_free_construction", "construction_deposit", "security_deposit", "payment_schedule", "charges_list", "requirement_list", "permit_list", "construction_deposit_terms", "security_deposit_terms", "advance_terms", "terms_condition", "isRent", "vattype", "vatpercent", "construction_deposit_type", "security_deposit_type", "year_basis", "rent_free_construction_start_date", "terms_condition_group", "terms_condition_term", "terms_condition_cond", "BillingStartDate"];

				$arrValue = ["1", $_POST['inquiryID'], $_POST['unitID'], $_POST['UnitType'], date('Y-m-d', strtotime($_POST['dateFrom'])), date('Y-m-d', strtotime($_POST['dateTo'])), $_POST['monthnum'], $_POST['daynum'], $_POST['monthlyDues'], $_POST['dailyDues'], $_POST['assocDues'], $_POST['pymenttype'], $_POST['pymentterms'], $_POST['EscalationRate'], $_POST['EscaRateStart'], $_POST['RentFreeCons'], $_POST['ConBondMonth'], $_POST['SecurityDeposit'], separateConDates($_POST['SelectedAdv']), getThisRealValue('charge_ID', 'charge_desc', 'tblref_refcharges', $_POST['Charges']), getThisRealValue('id', 'requirements', 'tblref_applicationrequirements', $_POST['Requirements'] ), getThisRealValue('id', 'description', 'tblref_typeofpermits', $_POST['Permits']), $_POST['ConBondMonthTerms'], $_POST['SecurityDepositTerms'], $_POST['AdvanceMonthAmountTerms'], $_POST['TermsandCon'], $_POST['isRent'], $_POST['VatType'], $_POST['VatPercent'], $_POST['isConDeposit'], $_POST['isSecDeposit'], $_POST['EscaYearBasis'], date('Y-m-d', strtotime($_POST['RentFreeConsStartDate'])), $gname, $tname, $cond, date('Y-m-d', strtotime($_POST['BillStartDate']))];

				$Logs = createXinfo("INSERT", $arrHeader, $arrFields, $arrValue, "tbltrans_proposal", $_POST['id'], "");

				if($res2 == true){
					$sqlInq = "UPDATE tbltrans_inquiry SET Mall_ID = '". $_POST['MallID'] ."', unitID = '". $_POST['unitID'] ."', unitType = '". $_POST['UnitType'] ."', datefrom = '". date('Y-m-d', strtotime($_POST['dateFrom'])) ."', dateto = '". date('Y-m-d', strtotime($_POST['dateTo'])) ."', desired_noofdays = '". $_POST['daynum'] ."', desired_noofmonths = '". $_POST['monthnum'] ."', payment_terms = '". $_POST['pymentterms'] ."', payment_type = '". $_POST['pymenttype'] ."', monthly_dues = '". $_POST['monthlyDues'] ."', daily_dues = '". $_POST['dailyDues'] ."', assoc_dues = '". $_POST['assocDues'] ."', mod_by = '". getusername() ."', date_modified = '". date('Y-m-d H:i:s') ."', depamount = '". $_POST['SecurityDeposit'] ."', month_adv = '". $_POST['SelectedAdv'] ."' WHERE inquiry_ID = '". $_POST['inquiryID'] ."';";
					$resInq = mysql_query($sqlInq, $connection);
					if($resInq == true){
						echo 1;
					}
					if($Logs != ""){
						$tran_logs = create_logs_per_transaction("created a new proposal.", "Proposal Module", $Logs, "" ,"ADD", $_POST['inquiryID']);
					}
				}
			}else{
				$checkstat = mysql_fetch_array(mysql_query("SELECT stats FROM tbltrans_proposal WHERE id = '". $_POST['id'] ."'", $connection));
				$termsandconlist = explode("|", $_POST['TermsandCon']);
				for ($i=0; $i <= count($termsandconlist)-2; $i++) { 
					$selectby1 = mysql_fetch_array(mysql_query("SELECT Group_Name, Term_Name, Description FROM tblcondition WHERE Term_ID = '". $termsandconlist[$i] ."' ", $connection));
					$gname .= $selectby1[0]."|";
					$tname .= $selectby1[1]."|";
					$cond .= $selectby1[2]."|";
				}
				if($_POST['id'] == ""){
					$newNum = $row[0] + 1;
					$res3 = mysql_query("INSERT INTO tbltrans_proposal SET proposalNum = '". $newNum ."', inquiryID = '". $_POST['inquiryID'] ."', unitID = '". $_POST['unitID'] ."', unitType = '". $_POST['UnitType'] ."', dateFrom = '". date('Y-m-d', strtotime($_POST['dateFrom'])) ."', dateTo = '". date('Y-m-d', strtotime($_POST['dateTo'])) ."', desiredMonths = '". $_POST['monthnum'] ."', desiredDays = '". $_POST['daynum'] ."', monthlyDues = '". $_POST['monthlyDues'] ."', dailyDues = '". $_POST['dailyDues'] ."', assocDues = '". $_POST['assocDues'] ."', paymentType = '". $_POST['pymenttype'] ."', paymentTerms = '". $_POST['pymentterms'] ."', escalation_rate = '". $_POST['EscalationRate'] ."', year_start = '". $_POST['EscaRateStart'] ."', rent_free_construction = '". $_POST['RentFreeCons'] ."', construction_deposit = '". $_POST['ConBondMonth'] ."', security_deposit = '". $_POST['SecurityDeposit'] ."', payment_schedule = '". $_POST['SelectedAdv'] ."', charges_list = '". $_POST['Charges'] ."', requirement_list = '". $_POST['Requirements'] ."', permit_list = '". $_POST['Permits'] ."', construction_deposit_terms = '". $_POST['ConBondMonthTerms'] ."', security_deposit_terms = '". $_POST['SecurityDepositTerms'] ."', advance_terms = '". $_POST['AdvanceMonthAmountTerms'] ."', terms_condition = '". $_POST['TermsandCon'] ."', isRent = '". $_POST['isRent'] ."', vattype = '". $_POST['VatType'] ."', vatpercent = '". $_POST['VatPercent'] ."', construction_deposit_type = '". $_POST['isConDeposit'] ."', security_deposit_type = '". $_POST['isSecDeposit'] ."', year_basis = '". $_POST['EscaYearBasis'] ."', rent_free_construction_start_date = '". date('Y-m-d', strtotime($_POST['RentFreeConsStartDate'])) ."', terms_condition_group = '". mysql_escape_string($gname) ."', terms_condition_term = '". mysql_escape_string($tname) ."', terms_condition_cond = '". mysql_escape_string($cond) ."', BillingStartDate = '". date('Y-m-d', strtotime($_POST['BillStartDate'])) ."';", $connection);

					$arrHeader = ["Proposal Number", "Inquiry ID", "Unit ID", "Unit Type", "Date From", "Date To", "Desired Months", "Desired Days", "Monthly Dues", "Daily Dues", "Association Dues", "Payment Type", "Payment Terms", "Escalation Rate", "Year Start", "Rent Free Construction", "Construction Deposit", "Security Deposit", "Payment Schedule", "Charges List", "Requirement List", "Permit List", "Construction Deposit Terms", "Security Deposit Terms", "Advance Terms", "Terms Condition", "Is Rent", "VAT Type", "VAT Percent", "Construction Deposit Type", "Security Deposit Type", "Year Basis", "Rent Free Construction Start Date", "Group", "Terms", "Conditions", ];

					$arrFields = ["proposalNum", "inquiryID", "unitID", "unitType", "dateFrom", "dateTo", "desiredMonths", "desiredDays", "monthlyDues", "dailyDues", "assocDues", "paymentType", "paymentTerms", "escalation_rate", "year_start", "rent_free_construction", "construction_deposit", "security_deposit", "payment_schedule", "charges_list", "requirement_list", "permit_list", "construction_deposit_terms", "security_deposit_terms", "advance_terms", "terms_condition", "isRent", "vattype", "vatpercent", "construction_deposit_type", "security_deposit_type", "year_basis", "rent_free_construction_start_date", "terms_condition_group", "terms_condition_term", "terms_condition_cond"];

					$arrValue = [$newNum, $_POST['inquiryID'], $_POST['unitID'], $_POST['UnitType'], date('Y-m-d', strtotime($_POST['dateFrom'])), date('Y-m-d', strtotime($_POST['dateTo'])), $_POST['monthnum'], $_POST['daynum'], $_POST['monthlyDues'], $_POST['dailyDues'], $_POST['assocDues'], $_POST['pymenttype'], $_POST['pymentterms'], $_POST['EscalationRate'], $_POST['EscaRateStart'], $_POST['RentFreeCons'], $_POST['ConBondMonth'], $_POST['SecurityDeposit'], separateConDates($_POST['SelectedAdv']), getThisRealValue('charge_ID', 'charge_desc', 'tblref_refcharges', $_POST['Charges']), getThisRealValue('id', 'requirements', 'tblref_applicationrequirements', $_POST['Requirements']), getThisRealValue('id', 'description', 'tblref_typeofpermits', $_POST['Permits']), $_POST['ConBondMonthTerms'], $_POST['SecurityDepositTerms'], $_POST['AdvanceMonthAmountTerms'], $_POST['TermsandCon'], $_POST['isRent'], $_POST['VatType'], $_POST['VatPercent'], $_POST['isConDeposit'], $_POST['isSecDeposit'], $_POST['EscaYearBasis'], date('Y-m-d', strtotime($_POST['RentFreeConsStartDate'])), $gname, $tname, $cond];
					
					$Logs = createXinfo("INSERT", $arrHeader, $arrFields, $arrValue, "tbltrans_proposal", $_POST['id'], "");
					if($res3 == true){
						echo 1;
						if($Logs != ""){
							$tran_logs = create_logs_per_transaction("created a new proposal.", "Proposal Module", $Logs, "" ,"ADD", $_POST['inquiryID']);
						}
					}
				}else{
					//----- For Update only, Pag sa Inserting/Adding hindi na need to.
					$multiple = array();

					array_push($multiple, array('payment_schedule', $_POST['SelectedAdv']));
					array_push($multiple, array('charges_list', $_POST['Charges']));
					array_push($multiple, array('requirement_list', $_POST['Requirements']));
					array_push($multiple, array('permit_list', $_POST['Permits']));
					// -----

					// ----- Needed to generate logs

					$arrHeader = ["Inquiry ID", "Unit ID", "Unit Type", "Date From", "Date To", "Desired Months", "Desired Days", "Monthly Dues", "Daily Dues", "Association Dues", "Payment Type", "Payment Terms", "Escalation Rate", "Year Start", "Rent Free Construction", "Construction Deposit", "Security Deposit", "Advance Payment Schedule", "Charges List", "Requirement List", "Permit List", "Construction Deposit Terms", "Security Deposit Terms", "Advance Terms", "Terms Condition", "Is Rent", "VAT Type", "VAT Percent", "Construction Deposit Type", "Security Deposit Type", "Year Basis", "Rent Free Construction Start Date", "Group", "Terms", "Conditions"];

					$arrFields = ["inquiryID", "unitID", "unitType", "dateFrom", "dateTo", "desiredMonths", "desiredDays", "monthlyDues", "dailyDues", "assocDues", "paymentType", "paymentTerms", "escalation_rate", "year_start", "rent_free_construction", "construction_deposit", "security_deposit", "payment_schedule", "charges_list", "requirement_list", "permit_list", "construction_deposit_terms", "security_deposit_terms", "advance_terms", "terms_condition", "isRent", "vattype", "vatpercent", "construction_deposit_type", "security_deposit_type", "year_basis", "rent_free_construction_start_date", "terms_condition_group", "terms_condition_term", "terms_condition_cond"];

					$arrValue = [$_POST['inquiryID'], $_POST['unitID'], $_POST['UnitType'], date('Y-m-d',  strtotime($_POST['dateFrom'])), date('Y-m-d',  strtotime($_POST['dateTo'])), $_POST['monthnum'], $_POST['daynum'], $_POST['monthlyDues'], $_POST['dailyDues'], $_POST['assocDues'], $_POST['pymenttype'], $_POST['pymentterms'], $_POST['EscalationRate'], $_POST['EscaRateStart'], $_POST['RentFreeCons'], $_POST['ConBondMonth'], $_POST['SecurityDeposit'], separateConDates($_POST['SelectedAdv']), getThisRealValue('charge_ID', 'charge_desc', 'tblref_refcharges', $_POST['Charges']), getThisRealValue('id', 'requirements', 'tblref_applicationrequirements', $_POST['Requirements']), getThisRealValue('id', 'description', 'tblref_typeofpermits', $_POST['Permits'] ), $_POST['ConBondMonthTerms'], $_POST['SecurityDepositTerms'],$_POST['AdvanceMonthAmountTerms'],$_POST['TermsandCon'],$_POST['isRent'],$_POST['VatType'],$_POST['VatPercent'], $_POST['isConDeposit'], $_POST['isSecDeposit'], $_POST['EscaYearBasis'], date('Y-m-d', strtotime($_POST['RentFreeConsStartDate'])), $gname, $tname, $cond];
					
					$Logs = createXinfo("UPDATE", $arrHeader, $arrFields, $arrValue, "tbltrans_proposal", $_POST['id'], $multiple);
					// -----
					$res4 = mysql_query("UPDATE tbltrans_proposal SET inquiryID = '". $_POST['inquiryID'] ."', unitID = '". $_POST['unitID'] ."', unitType = '". $_POST['UnitType'] ."', dateFrom = '". date('Y-m-d', strtotime($_POST['dateFrom'])) ."', dateTo = '". date('Y-m-d', strtotime($_POST['dateTo'])) ."', desiredMonths = '". $_POST['monthnum'] ."', desiredDays = '". $_POST['daynum'] ."', monthlyDues = '". $_POST['monthlyDues'] ."', dailyDues = '". floatval($_POST['dailyDues']) ."', assocDues = '". $_POST['assocDues'] ."', paymentType = '". $_POST['pymenttype'] ."', paymentTerms = '". $_POST['pymentterms'] ."', escalation_rate = '". $_POST['EscalationRate'] ."', year_start = '". $_POST['EscaRateStart'] ."', rent_free_construction = '". $_POST['RentFreeCons'] ."', construction_deposit = '". $_POST['ConBondMonth'] ."', security_deposit = '". $_POST['SecurityDeposit'] ."', payment_schedule = '". $_POST['SelectedAdv'] ."', charges_list = '". $_POST['Charges'] ."', requirement_list = '". $_POST['Requirements'] ."', permit_list = '". $_POST['Permits'] ."', construction_deposit_terms = '". $_POST['ConBondMonthTerms'] ."', security_deposit_terms = '". $_POST['SecurityDepositTerms'] ."', advance_terms = '". $_POST['AdvanceMonthAmountTerms'] ."', terms_condition = '". $_POST['TermsandCon'] ."', isRent = '". $_POST['isRent'] ."', vattype = '". $_POST['VatType'] ."', vatpercent = '". $_POST['VatPercent'] ."', construction_deposit_type = '". $_POST['isConDeposit'] ."', security_deposit_type = '". $_POST['isSecDeposit'] ."', year_basis = '". $_POST['EscaYearBasis'] ."', rent_free_construction_start_date = '". date('Y-m-d', strtotime($_POST['RentFreeConsStartDate'])) ."', terms_condition_group = '". mysql_escape_string($gname) ."', terms_condition_term = '". mysql_escape_string($tname) ."', terms_condition_cond = '". mysql_escape_string($cond) ."', BillingStartDate = '". date('Y-m-d', strtotime($_POST['BillStartDate'])) ."' WHERE id = '". $_POST['id'] ."';", $connection);
					if($res4 == true){
						if($checkstat['stats'] == '1'){
							$sqlInq = "UPDATE tbltrans_inquiry SET Mall_ID = '". $_POST['MallID'] ."', unitID = '". $_POST['unitID'] ."', unitType = '". $_POST['UnitType'] ."', datefrom = '". date('Y-m-d', strtotime($_POST['dateFrom'])) ."', dateto = '". date('Y-m-d', strtotime($_POST['dateTo'])) ."', desired_noofdays = '". $_POST['daynum'] ."', desired_noofmonths = '". $_POST['monthnum'] ."', payment_terms = '". $_POST['pymentterms'] ."', payment_type = '". $_POST['pymenttype'] ."', monthly_dues = '". floatval($_POST['monthlyDues']) ."', daily_dues = '". floatval($_POST['dailyDues']) ."', assoc_dues = '". floatval($_POST['assocDues']) ."', mod_by = '". getusername() ."', date_modified = '". date('Y-m-d H:i:s') ."', depamount = '". floatval($_POST['SecurityDeposit']) ."', month_adv = '". $_POST['SelectedAdv'] ."', depamount = '". $_POST['SecurityDeposit'] ."', month_adv = '". $_POST['SelectedAdv'] ."' WHERE inquiry_ID = '". $_POST['inquiryID'] ."';";
							$resInq = mysql_query($sqlInq, $connection);
						}
						if($Logs != ""){
							$tran_logs = create_logs_per_transaction("updated a previous proposal.", "Proposal Module", $Logs, "" ,"UPDATE", $_POST['inquiryID']);
						}
						echo 2;
					}
				}
			}
		break;

		case 'setDefault':
			$sql0 = " UPDATE tbltrans_proposal SET stats = '0' WHERE inquiryID = '". $_POST['inquiryID'] ."' ";
			$res0 = mysql_query($sql0, $connection);

			if($res0 == true){
				$sql = " UPDATE tbltrans_proposal SET stats = '1' WHERE id = '". $_POST['id'] ."' ";
				$res = mysql_query($sql, $connection);

				if($res == true){
					$sql2 = " SELECT unitID, unitType, dateFrom, dateTo, desiredMonths, desiredDays, monthlyDues, dailyDues, assocDues, paymentType, paymentTerms, security_deposit, payment_schedule FROM tbltrans_proposal WHERE id = '". $_POST['id'] ."' ";
					$res2 = mysql_query($sql2, $connection);
					$row2 = mysql_fetch_array($res2);

					$unitinfo = mysql_fetch_array(mysql_query("SELECT classid, depid, catid, mallid FROM tblref_unit WHERE unitid = '". $row2['unitID'] ."'", $connection));
					$mallname = mysql_fetch_array(mysql_query("SELECT mallname FROM tblref_mall WHERE mallid = '". $unitinfo['mallid'] ."'", $connection));

					$sqlInq = " UPDATE tbltrans_inquiry SET unitID = '". $row2[0] ."', unitType = '". $row2[1] ."', datefrom = '". date('Y-m-d', strtotime($row2[2])) ."', dateto = '". date('Y-m-d', strtotime($row2[3])) ."', desired_noofdays = '". $row2[5] ."', desired_noofmonths = '". $row2[4] ."', payment_terms = '". $row2[10] ."', payment_type = '". $row2[9] ."', monthly_dues = '". $row2[6] ."', daily_dues = '". $row2[7] ."', assoc_dues = '". $row2[8] ."', Mall = '". $mallname['mallname'] ."', Mall_ID = '". $unitinfo['mallid'] ."', ClassID = '". $unitinfo['classid'] ."', DepartmentID = '". $unitinfo['depid'] ."', CategoryID = '". $unitinfo['catid'] ."', mod_by = '". getusername() ."', date_modified = '". date('Y-m-d H:i:s') ."', depamount = '". $row2['security_deposit'] ."', month_adv = '". $row2['payment_schedule'] ."' WHERE inquiry_ID = '". $_POST['inquiryID'] ."' ";
					$resInq = mysql_query($sqlInq, $connection);
					if($resInq == true){
						echo 1;
					}
				}
			}
		break;

		case 'sendFinalOffer':
			$leadsInfo = mysql_fetch_array(mysql_query("SELECT leadsID FROM tbltrans_inquiry WHERE Inquiry_ID = '". $_POST['inquiryID'] ."' ", $connection));
			$CheckProposal = mysql_num_rows(mysql_query("SELECT proposalNum FROM tbltrans_proposal WHERE inquiryID = '". $_POST['inquiryID'] ."' AND stats = '1'", $connection));
			if($CheckProposal == 1){
				$AppPref = mysql_fetch_array(mysql_query("SELECT appprefix FROM tblsys_setup", $connection));
				$ApplicationID = createidno($AppPref['appprefix'], "tbltrans_appid", "app_id");

				// ----- Creating of logs

				$arrHeader = ["Applied By","Generated ID","Date Applied"];

				$arrFields = ["app_by","Application_ID","date_applied"];

				$arrValue = [getusername(),$ApplicationID,date('Y-m-d H:i:s')];
				
				$Logs = createXinfo( "INSERT" , $arrHeader , $arrFields , $arrValue , "tbltrans_proposal" , "" , "" );

				// -----

				$sql = " UPDATE tbltrans_inquiry SET forFinal = '1', mod_by = '". getusername() ."', date_modified = '". date('Y-m-d H:i:s') ."', Application_ID = '". $ApplicationID ."', applicationDate = '". date('Y-m-d') ."', date_applied = '". date('Y-m-d H:i:s') ."', app_by = '". getusername() ."' WHERE Inquiry_ID = '". $_POST['inquiryID'] ."' ";
				$res = mysql_query($sql, $connection);
				if($res == true){
					$UpdateLeads = mysql_query("UPDATE tbltrans_leads SET Status = 'Pending Application' WHERE leadsID = '". $leadsInfo['leadsID'] ."'", $connection);
					if($Logs != ""){
						$tran_logs = create_logs_per_transaction("send proposal to leasing application module.", "Proposal Module", $Logs, "" ,"ADD", $_POST['inquiryID']);
					}
					echo 1;
				}
			}else{
				echo 2;
			}
		break;

		case 'SubLeadsProViewHistory':
			$sql = " SELECT username, mydate, mytime, module, xaction FROM tbllogs_per_trans WHERE inqID = '". $_POST['inquiryID'] ."' ";
			$res = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($res)){
				?>
				<tr>
					<td width="20%"><?php echo $row[0]; ?></td>
					<td width="20%"><?php echo date('m/d/Y', strtotime($row[1])); ?></td>
					<td width="20%"><?php echo date('H:i A', strtotime($row[2])); ?></td>
					<td width="20%"><?php echo $row[3]; ?></td>
					<td width="20%"><?php echo $row[4]; ?></td>
				</tr>
				<?php
			}
		break;

		case 'selecttenant':
			$CompanyName = mysql_fetch_array(mysql_query("SELECT a.Company, b.Industry FROM tbltrans_company as a LEFT JOIN tblref_industry as b ON a.industry = b.Industry_ID WHERE a.CompanyID = '". $_POST['companyID'] ."' ", $connection));
			$tradename = mysql_fetch_array(mysql_query("SELECT tradename FROM tbltrans_tradename WHERE tradeID = '". $_POST['tradeID'] ."'", $connection));
			echo $tradename[0] . "|" . $CompanyName[0] . "|" . $CompanyName[1];
		break;

		case 'showModalAddCharges':
			$mgaMeron = "";
			$arr = explode("|", $_POST['ids']);
			for ($i=0; $i <= count($arr)-2; $i++) { 
				$mgaMeron .= "'" . $arr[$i] . "'" . ",";
			}

			if($_POST['ids'] != ""){
				$tanong = "AND CHARGE_ID NOT IN (". substr(trim($mgaMeron), 0, -1) .")";
			}else{
				$tanong = "";
			}
			$res = mysql_query("SELECT CHARGE_ID, CHARGE_DESC, RATE_TYPE, RATE, OTHER_REASON FROM tblref_refcharges WHERE CHARGE_DESC LIKE '%". $_POST['key'] ."%' ". $tanong ." ORDER BY CHARGE_DESC ASC ", $connection);
			while($row = mysql_fetch_array($res)){

				if($row['RATE_TYPE'] == "Other"){
					$Parusa = $row['OTHER_REASON'];
				}else if($row['RATE_TYPE'] == "Occurence"){
					$Parusa = number_format($row['RATE'], "2", ".", ",") . " " . $row['OTHER_REASON'];
				}else{
					$Parusa = number_format($row['RATE'], "2", ".", ","). " " . $row['RATE_TYPE'];
				}

				echo "	<tr id='TR". $row['CHARGE_ID'] ."'>
							<td class='ChargesDesc'>". $row['CHARGE_DESC'] ."</td>
							<td class='ChargesRate'>". $Parusa ."</td>
							<td class='hide ChargesID'>". $row['CHARGE_ID'] ."</td>
						</tr>";
			}
		break;

		case 'getcharges_list':
			$mgaMeron = "";
			$arr = explode("|", $_POST['charges_list']);
			for ($i=0; $i <= count($arr)-2; $i++) { 
				$mgaMeron .= "'" . $arr[$i] . "'" . ",";
			}

			if($_POST['charges_list'] != ""){
				$charge_list = "OR CHARGE_ID IN (". substr(trim($mgaMeron), 0, -1) .")";
			}else{
				$charge_list = "";
			}

			$res = mysql_query("SELECT CHARGE_ID, CHARGE_DESC, RATE_TYPE, RATE, OTHER_REASON FROM tblref_refcharges WHERE isDefault = '1' ". $charge_list ." ", $connection);
			while($row = mysql_fetch_array($res)){

				if($row['RATE_TYPE'] == "Other"){
					$Parusa = $row['OTHER_REASON'];
				}else if($row['RATE_TYPE'] == "Occurence"){
					$Parusa = number_format($row['RATE'], "2", ".", ",") . " " . $row['OTHER_REASON'];
				}else{
					$Parusa = number_format($row['RATE'], "2", ".", ","). " " . $row['RATE_TYPE'];
				}

				echo "<tr id='". $row['CHARGE_ID'] ."'>
						<td>". $row['CHARGE_DESC'] ."</td>
						<td>". $Parusa ."</td>
						<td style='text-align: center;z-index: 0;'><button class='btn btn-xs btn-danger isFinal btn-round' onclick='$(\"#". $row['CHARGE_ID'] ."\").remove();'><i class='fa fa-trash-o'></i></button></td>
					</tr>";
			}
		break;

		case 'getcharges_list2':
			$mgaMeron = "";
			$arr = explode("|", $_POST['charges_list']);
			for ($i=0; $i <= count($arr)-2; $i++) { 
				$mgaMeron .= "'" . $arr[$i] . "'" . ",";
			}

			if($_POST['charges_list'] != ""){
				$res = mysql_query("SELECT CHARGE_ID, CHARGE_DESC, RATE_TYPE, RATE, OTHER_REASON FROM tblref_refcharges WHERE CHARGE_TYPE = 'Operational Charges' AND CHARGE_ID IN (". substr(trim($mgaMeron), 0, -1) .") ", $connection);
				while($row = mysql_fetch_array($res)){
					
					if($row['RATE_TYPE'] == "Other"){
						$Parusa = $row['OTHER_REASON'];
					}else if($row['RATE_TYPE'] == "Occurence"){
						$Parusa = number_format($row['RATE'], "2", ".", ",") . " " . $row['OTHER_REASON'];
					}else{
						$Parusa = number_format($row['RATE'], "2", ".", ","). " " . $row['RATE_TYPE'];
					}

					echo "<tr>
							<td style='border: 1px solid black;'>". $row['CHARGE_DESC'] ."</td>
							<td style='border: 1px solid black;'>". $Parusa ."</td>
						</tr>";
				}
			}
		break;

		case 'getcharges_list3':
			$mgaMeron = "";
			$arr = explode("|", $_POST['charges_list']);
			for ($i=0; $i <= count($arr)-2; $i++) { 
				$mgaMeron .= "'" . $arr[$i] . "'" . ",";
			}

			if($_POST['charges_list'] != ""){
				$res = mysql_query("SELECT CHARGE_ID, CHARGE_DESC, RATE_TYPE, RATE, OTHER_REASON FROM tblref_refcharges WHERE CHARGE_TYPE = 'Conditional Charges' AND CHARGE_ID IN (". substr(trim($mgaMeron), 0, -1) .") ", $connection);
				while($row = mysql_fetch_array($res)){

					if($row['RATE_TYPE'] == "Other"){
						$Parusa = $row['OTHER_REASON'];
					}else if($row['RATE_TYPE'] == "Occurence"){
						$Parusa = number_format($row['RATE'], "2", ".", ",") . " " . $row['OTHER_REASON'];
					}else{
						$Parusa = number_format($row['RATE'], "2", ".", ","). " " . $row['RATE_TYPE'];
					}

					echo "<tr>
							<td style='border: 1px solid black;'>". $row['CHARGE_DESC'] ."</td>
							<td style='border: 1px solid black;'>". $Parusa ."</td>
						</tr>";
				}
			}
		break;

		case 'getrequirement_list':
			$mgaMeron = "";
			$arr = explode("|", $_POST['requirement_list']);
			for ($i=0; $i <= count($arr)-2; $i++) { 
				$mgaMeron .= "'" . $arr[$i] . "'" . ",";
			}
			
			$res = mysql_query("SELECT id, requirements FROM tblref_applicationrequirements WHERE id IN (". substr(trim($mgaMeron), 0, -1) .") ", $connection);
			while($row = mysql_fetch_array($res)){

				echo "	<tr id=\"". $row['id'] ."\">
						<td>". $row['requirements'] ."</td>
						<td style='text-align: center;z-index: 0;'><button class='btn btn-xs btn-danger isFinal btn-round' onclick='$(\"#". $row['id'] ."\").remove();'><i class='fa fa-trash-o'></i></button></td>
					</tr>";
			}
		break;

		case 'getpermit_list':
			$mgaMeron = "";
			$arr = explode("|", $_POST['permit_list']);
			for ($i=0; $i <= count($arr)-2; $i++) { 
				$mgaMeron .= "'" . $arr[$i] . "'" . ",";
			}
			$res = mysql_query("SELECT id, DESCRIPTION FROM tblref_typeofpermits WHERE id IN (". substr(trim($mgaMeron), 0, -1) .") ", $connection);
			while($row = mysql_fetch_array($res)){

				echo "	<tr id=\"". $row['id'] ."\">
						<td>". $row['DESCRIPTION'] ."</td>
						<td style='text-align: center;z-index: 0;'><button class='btn btn-xs btn-danger isFinal btn-round' onclick='$(\"#". $row['id'] ."\").remove();'><i class='fa fa-trash-o'></i></button></td>
					</tr>";
			}
		break;

		case 'getProPaySched':
			if($_POST['UnitType'] == "SET"){
				$PlusDay = "";
			}else{
				if($_POST['noofdays'] > 0 && $_POST['noofdays'] != ''){
					$PlusDay = " +". $_POST['noofdays'] ."day";
				}else{
					$PlusDay = "";
				}
			}
			if($_POST['noofmonths'] > 0 && $_POST['noofmonths'] != ''){
				$PlusMonth = " +". $_POST['noofmonths'] ."month";
			}else{
				$PlusMonth = "";
			}
			
			$StartDate = date('Y-m-d', strtotime($_POST['BillingStartDate']));
			$EndDate = date('Y-m-d', strtotime($StartDate . $PlusMonth . $PlusDay));
			$Months = ((date('Y', strtotime($EndDate)) - date('Y', strtotime($StartDate))) * 12) + (date('m', strtotime($EndDate)) - date('m', strtotime($StartDate)));
			$Days = (strtotime($EndDate) - strtotime($StartDate)) / (60 * 60 * 24);
			$refDate = date('m/d/Y', strtotime($StartDate));
			
			if($_POST['UnitType'] == "SET"){

				if($_POST['PTerms'] == "daily"){

					for ($x = 1; $x <= $Days; $x++) {
						if(date('d', strtotime($refDate)) == date('t', strtotime($refDate))){
							$AssocDues = $_POST['assocdues'];
						}else{
							$AssocDues = 0;
						}
						$Daily = $_POST['monthlydue'] / date('t', strtotime($refDate));
						echo '<tr id="'. date("m/d/Y", strtotime($refDate)) .'" class="unselected">
								<td style="display: none;">
									<label>
										<input name="form-field-checkbox" class="chk_advpyment" type="checkbox">
										<span class="lbl"></span>
									</label>
								</td>
								<td width="20%" class="dipwede">
									'. date("m/d/Y", strtotime($refDate)) .'
								</td>
								<td width="20%" style="text-align: right;" class="dipwede"><label class="lbladvpyment">0.00</label><input type="text" class="form-control numonly amount txtadvpyment" style="text-align:right;display:none;" placeholder="0.00"></td>
								<td width="20%" style="text-align: right;" class="dipwede">'. number_format($Daily, 2, '.', ',') .'</td>';
								if(SysLeaseSetup('isAssocDues') == "1"){
									echo '<td width="20%" style="text-align: right;" class="dipwede">'. number_format($AssocDues, 2, '.', ',') .'</td>';
								}
						echo	'<td width="20%" style="text-align: right;" class="lblamntsetup dipwede">'. number_format($Daily+$AssocDues, 2, '.', ',') .'</td>
							</tr>';
						$refDate = date('m/d/Y', strtotime($refDate . '+1 day'));
					}

				}else if($_POST['PTerms'] == "1time"){

					$Total = $_POST['monthlydue'] + $_POST['assocdues'];
					for ($x = 1; $x <= $months; $x++) {
						$TMonthly += $_POST['monthlydue'];
						$AMonthly += $_POST['assocdues'];
						$GTotal += $Total;
					}
					echo 	'<tr id="'. date("m/d/Y", strtotime($StartDate)) .'-'. date("m/d/Y", strtotime($EndDate)) .'" class="unselected">
								<td style="display: none;">
									<label>
										<input name="form-field-checkbox" class="chk_advpyment" type="checkbox">
										<span class="lbl"></span>
									</label>
								</td>
								<td width="20%" class="dipwede">
									'. date("m/d/Y", strtotime($StartDate)) .' - '. date("m/d/Y", strtotime($EndDate . '-1 day')) .'
								</td>
								<td width="20%" style="text-align: right;"><label class="lbladvpyment">0.00</label><input type="text" class="form-control numonly amount txtadvpyment" style="text-align:right;display:none;" placeholder="0.00"></td>
								<td width="20%" style="text-align: right;" class="dipwede">'. number_format($TMonthly, 2, '.', ',') .'</td>';
								if(SysLeaseSetup('isAssocDues') == "1"){
									echo '<td width="20%" style="text-align: right;" class="dipwede">'. number_format($AMonthly, 2, '.', ',') .'</td>';
								}
					echo		'<td width="20%" style="text-align: right;" class="lblamntsetup dipwede">'. number_format($GTotal, 2, '.', ',') .'</td>
							</tr>';

				}else if($_POST['PTerms'] == "monthly"){

					for ($x = 1; $x <= $Months; $x++) {
						echo '<tr id="'. date("m/d/Y", strtotime($refDate)) .'" class="unselected">
								<td style="display: none;">
									<label>
										<input name="form-field-checkbox" class="chk_advpyment" type="checkbox">
										<span class="lbl"></span>
									</label>
								</td>
								<td width="20%" class="dipwede">
									'. date("m/d/Y", strtotime($refDate)) .'
								</td>
								<td width="20%" style="text-align: right;" class="dipwede"><label class="lbladvpyment">0.00</label><input type="text" class="form-control numonly amount txtadvpyment" style="text-align:right;display:none;" placeholder="0.00"></td>
								<td width="20%" style="text-align: right;" class="dipwede">'. number_format($_POST['monthlydue'], 2, '.', ',') .'</td>';
								if(SysLeaseSetup('isAssocDues') == "1"){
									echo '<td width="20%" style="text-align: right;" class="dipwede">'. number_format($_POST['assocdues'], 2, '.', ',') .'</td>';
								}
						echo	'<td width="20%" style="text-align: right;" class="lblamntsetup dipwede">'. number_format($_POST['monthlydue']+$_POST['assocdues'], 2, '.', ',') .'</td>
							</tr>';
						$refDate = date('m/d/Y', strtotime($refDate . '+1 month'));
					}

				}

			}else{

				if($_POST['PTerms'] == "daily"){

					for ($x = 1; $x <= $Days; $x++) {
						if(date('d', strtotime($refDate)) == date('t', strtotime($refDate))){
							$assocdues = $_POST['assocdues'];
						}else{
							$assocdues = 0;
						}
						$Daily = $_POST['monthlydue'] / date('t', strtotime($refDate));
						echo '<tr id="'. date("m/d/Y", strtotime($refDate)) .'" class="unselected">
								<td style="display: none;">
									<label>
										<input name="form-field-checkbox" class="chk_advpyment" type="checkbox">
										<span class="lbl"></span>
									</label>
								</td>
								<td width="20%" class="dipwede">
									'. date("m/d/Y", strtotime($refDate)) .'
								</td>
								<td width="20%" style="text-align: right;" class="dipwede"><label class="lbladvpyment">0.00</label><input type="text" class="form-control numonly amount txtadvpyment" style="text-align:right;display:none;" placeholder="0.00"></td>
								<td width="20%" style="text-align: right;" class="dipwede">'. number_format($Daily, 2, '.', ',') .'</td>';
								if(SysLeaseSetup('isAssocDues') == "1"){
									echo '<td width="20%" style="text-align: right;" class="dipwede">'. number_format($assocdues, 2, '.', ',') .'</td>';
								}
						echo	'<td width="20%" style="text-align: right;" class="lblamntsetup dipwede">'. number_format($Daily+$assocdues, 2, '.', ',') .'</td>
							</tr>';
						$refDate = date('m/d/Y', strtotime($refDate . '+1 day'));
					}

				}else if($_POST['PTerms'] == "1time"){

					$TMonthly = 0;
					$AMonthly = 0;
					$Total = $_POST['monthlydue'] + $_POST['assocdues'];
					for ($x = 1; $x <= $_POST['desired_noofmonths']; $x++) {
						$TMonthly += $_POST['monthlydue'];
						$AMonthly += $_POST['assocdues'];
					}
					$refDate2 = date('m/d/Y', strtotime($refDate . '+ '. $_POST['desired_noofmonths'] .' month'));
					for ($x = 1; $x <= $_POST['noofdays']; $x++) {
						$Daily = $_POST['monthlydue'] / date('t', strtotime($refDate2));
						if(date('d', strtotime($refDate2)) == date('t', strtotime($refDate2))){
							$AMonthly += $_POST['assocdues'];
						}
						$TMonthly += $Daily;
						$refDate2 = date('m/d/Y', strtotime($refDate2 . '+1 day'));
					}
					$GTotal = $TMonthly + $AMonthly;
					echo 	'<tr id="'.date("m/d/Y", strtotime($date1)).'-'.date("m/d/Y", strtotime($date2)).'" class="unselected">
								<td style="display: none;">
									<label>
										<input name="form-field-checkbox" class="chk_advpyment" type="checkbox">
										<span class="lbl"></span>
									</label>
								</td>
								<td width="20%" class="dipwede">
									'. date("m/d/Y", strtotime($StartDate)) .' - '. date("m/d/Y", strtotime($EndDate . '-1 day')) .'
								</td>
								<td width="20%" style="text-align: right;"><label class="lbladvpyment">0.00</label><input type="text" class="form-control numonly amount txtadvpyment" style="text-align:right;display:none;" placeholder="0.00"></td>
								<td width="20%" style="text-align: right;" class="dipwede">'. number_format($TMonthly, 2, '.', ',') .'</td>';
								if(SysLeaseSetup('isAssocDues') == "1"){
									echo '<td width="20%" style="text-align: right;" class="dipwede">'. number_format($AMonthly, 2, '.', ',') .'</td>';
								}
						echo	'<td width="20%" style="text-align: right;" class="lblamntsetup dipwede">'. number_format($GTotal, 2, '.', ',') .'	</td>
							</tr>';

				}else if($_POST['PTerms'] == "monthly"){

					for ($x = 1; $x <= $_POST['noofmonths']; $x++) {
						echo '<tr id="'. date("m/d/Y", strtotime($refDate)) .'" class="unselected">
								<td style="display: none;">
									<label>
										<input name="form-field-checkbox" class="chk_advpyment" type="checkbox">
										<span class="lbl"></span>
									</label>
								</td>
								<td width="20%" class="dipwede">
									'. date("m/d/Y", strtotime($refDate)) .'
								</td>
								<td width="20%" style="text-align: right;" class="dipwede"><label class="lbladvpyment">0.00</label><input type="text" class="form-control numonly amount txtadvpyment" style="text-align:right;display:none;" placeholder="0.00"></td>
								<td width="20%" style="text-align: right;" class="dipwede">'. number_format($_POST['monthlydue'], 2, '.', ',') .'</td>';
								if(SysLeaseSetup('isAssocDues') == "1"){
									echo '<td width="20%" style="text-align: right;" class="dipwede">'. number_format($_POST['assocdues'], 2, '.', ',') .'</td>';
								}
						echo 	'<td width="20%" style="text-align: right;" class="lblamntsetup dipwede">'. number_format($_POST['monthlydue'] + $_POST['assocdues'], 2, '.', ',') .'</td>
							</tr>';
						$refDate = date('m/d/Y', strtotime($refDate . '+1 month'));
					}

					if($_POST['noofdays'] != 0){
						$refDate = date('m/d/Y', strtotime($refDate));
						for ($x = 1; $x <= $_POST['noofdays']; $x++) {
							if(date('d', strtotime($refDate)) == date('t', strtotime($refDate))){
								$assocdues = $_POST['assocdues'];
							}else{
								$assocdues = 0;
							}
							$daily = $_POST['monthlydue'] / date('t', strtotime($refDate));
							echo '<tr id="'. date("m/d/Y", strtotime($refDate)) .'" class="unselected">
									<td style="display: none;">
										<label>
											<input name="form-field-checkbox" class="chk_advpyment" type="checkbox">
											<span class="lbl"></span>
										</label>
									</td>
									<td width="20%" class="dipwede">
										'. date("m/d/Y", strtotime($refDate)) .'
									</td>
									<td width="20%" style="text-align: right;" class="dipwede"><label class="lbladvpyment">0.00</label><input type="text" class="form-control numonly amount txtadvpyment" style="text-align:right;display:none;" placeholder="0.00"></td>
									<td width="20%" style="text-align: right;" class="dipwede">'. number_format($daily, 2, '.', ',') .'</td>';
									if(SysLeaseSetup('isAssocDues') == "1"){
										echo '<td width="20%" style="text-align: right;" class="dipwede">'. number_format($assocdues, 2, '.', ',') .'</td>';
									}
							echo	'<td width="20%" style="text-align: right;" class="lblamntsetup dipwede">'. number_format($daily+$assocdues, 2, '.', ',') .'</td>
								</tr>';
							$refDate = date('m/d/Y', strtotime($refDate . '+1 day'));
						}
					}

				}
			}
		break;

		case 'showModal_mdl_ProTermsAndCon':
			echo "<option value=''>-- Select Group Name --</option>";
			$res = mysql_query("SELECT Group_ID, Group_Name FROM tblgroups WHERE Status = '1'", $connection);
			while($row = mysql_fetch_array($res)){
				echo "<option value='".$row[0]."'>".$row[1]."</option>";
			}
		break;

		case 'loadModalTermsandCond':
			$page = $_POST['page'];
			$limit = ($page-1) * 10;

			if($_POST['key'] == ""){
				$filter = "";
			}else{
				$filter = "AND Group_ID = '". $_POST['key'] ."' ";
			}

			$res = mysql_query("SELECT Group_ID, Group_Name, Term_ID, Term_Name, Description FROM tblcondition WHERE stats = '1' ".$filter." LIMIT ".$limit.",10 ", $connection);
			while($row = mysql_fetch_array($res)){
				echo 	"	<tr id='tr".$row[2]."'>
								<td style='display: none;'><input type='checkbox' value='". $row[2] ."' class='chkProselectedTAC chkProselectedTAC".$row[2]."'></td>
								<td>".$row[1]."</td>
								<td>".$row[3]."</td>
								<td>".$row[4]."</td>
							</tr>";
			}
		break;

		case 'getRentAssoc':
			$Unit = mysql_fetch_array(mysql_query("SELECT totalamountunitsetup, assocdues FROM tblref_unit WHERE unitid = '". $_POST['UnitID'] ."'", $connection));
			echo floatval($Unit['totalamountunitsetup']) . "|" . floatval($Unit['assocdues']);
		break;

		case 'PrintReqList':
			$mgaMeron = "";
			$arr = explode("|", $_POST['reqlist']);
			for($i=0; $i <= count($arr)-2; $i++){ 
				$mgaMeron .= "'" . $arr[$i] . "'" . ",";
			}
			$res = mysql_query("SELECT id, requirements FROM tblref_applicationrequirements WHERE id IN (". substr(trim($mgaMeron), 0, -1) .") ", $connection);
			while($row = mysql_fetch_array($res)){
				echo "	<tr>
							<td style='border: 1px solid black;'></td>
							<td style='border: 1px solid black;'>". $row['requirements'] ."</td>
						</tr>";
			}
		break;

		case 'PrintPerList':
			$mgaMeron = "";
			$arr = explode("|", $_POST['perlist']);
			for($i=0; $i <= count($arr)-2; $i++){ 
				$mgaMeron .= "'" . $arr[$i] . "'" . ",";
			}
			$res = mysql_query("SELECT id, DESCRIPTION FROM tblref_typeofpermits WHERE id IN (". substr(trim($mgaMeron), 0, -1) .") ", $connection);
			while($row = mysql_fetch_array($res)){
				echo "	<tr>
							<td style='border: 1px solid black;'></td>
							<td style='border: 1px solid black;'>". $row['DESCRIPTION'] ."</td>
						</tr>";
			}
		break;

		case 'PrintProTermsandCond':
			$sql3 = " SELECT terms_condition_term, terms_condition_cond FROM tbltrans_proposal WHERE inquiryID = '". $_POST['inquiryID'] ."' AND proposalNum = '". $_POST['proposalNum'] ."' ";
            $res3 = mysql_query($sql3, $connection);
            $row3 = mysql_fetch_array($res3);

            $arr = explode("|", $row3[0]);
            $arr2 = explode("|", $row3[1]);
            for($a = 0;$a <= count($arr)-2;$a++){
                ?>
                    <tr>
                        <td style="vertical-align: top;"><?php echo $arr[$a]; ?></td>
                        <td><?php echo $arr2[$a]; ?></td>
                    </tr>
                <?php
            }
		break;

		case 'PrintProSigList':
			$res = mysql_query("SELECT userid FROM tblref_leasingsignatories WHERE mallid = '". $_POST['mallid'] ."' AND MOD(id,2) <> 0", $connection);
			while($row = mysql_fetch_array($res)){
				$username = mysql_fetch_array(mysql_query("SELECT firstname, middlename, lastname, groupaccess FROM tbluser WHERE userid = '". $row['userid'] ."'", $connection));
				if($username['middlename'] == ""){
					$FullName = $username['firstname'] . " " . $username['lastname'];
				}else{
					$FullName = $username['firstname'] . " ". $username['middlename'][0] ." " . $username['lastname'];
				}
				$GroupAccess = mysql_fetch_array(mysql_query("SELECT groupname FROM tblref_groupaccess WHERE groupid = '". $username['groupaccess'] ."'", $connection));
				echo 	"<tr>
			                <td style='width: 50%; border-top: 1px solid black;'></td>
			                <td style='width: 50%;'></td>
			            </tr>
			            <tr>
			                <td style='width: 50%;text-align: center;'>". $FullName ."</td>
			                <td style='width: 50%;'></td>
			            </tr>
			            <tr>
			                <td style='width: 50%;text-align: center;padding-bottom: 40px;'>". $GroupAccess[0] ."</td>
			                <td style='width: 50%;'></td>
			            </tr>";
			}
		break;

		case 'PrintProSigList2':
			$res = mysql_query("SELECT userid FROM tblref_leasingsignatories WHERE mallid = '". $_POST['mallid'] ."' AND MOD(id,2) = 0", $connection);
			while($row = mysql_fetch_array($res)){
				$username = mysql_fetch_array(mysql_query("SELECT firstname, middlename, lastname, groupaccess FROM tbluser WHERE userid = '". $row['userid'] ."'", $connection));
				if($username['middlename'] == ""){
					$FullName = $username['firstname'] . " " . $username['lastname'];
				}else{
					$FullName = $username['firstname'] . " ". $username['middlename'][0] ." " . $username['lastname'];
				}
				$GroupAccess = mysql_fetch_array(mysql_query("SELECT groupname FROM tblref_groupaccess WHERE groupid = '". $username['groupaccess'] ."'", $connection));
				echo 	"<tr>
			                <td style='width: 50%;'></td>
			                <td style='width: 50%; border-top: 1px solid black;'></td>
			            </tr>
			            <tr>
			                <td style='width: 50%;'></td>
			                <td style='width: 50%;text-align: center;'>". $FullName ."</td>
			            </tr>
			            <tr>
			                <td style='width: 50%;'></td>
			                <td style='width: 50%;text-align: center;padding-bottom: 40px;'>". $GroupAccess[0] ."</td>
			            </tr>";
			}
		break;
	}
?>	