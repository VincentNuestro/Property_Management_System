<?php
    session_start();
	include "../connect.php";
	switch ($_POST['form']) {
		case 'loadReservationList':
			$getFilters = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'Reservation' AND userid = '". $_SESSION['MMS-UserID'] ."';", $connection));
		    $Status = explode("|", $getFilters["bystat"]);
		    $Search = explode("|", $getFilters["checked_value"]);
			$DateRangeType = explode("|", $getFilters["xcheck"]);
		    $Date = explode("|", $getFilters["datefilter"]);

		    // FILTER BY STATUS
			$StatusCount = 0; $SelectedStatus = "";
			for($a = 0; $a<=count($Status)-2; $a++){
				if($Status[$a] == "Tentative"){ 
					$StatusVal = "Status = 'Awarded'"; 
				}else if($Status[$a] == "Confirmed"){ 
					$StatusVal = "Status = 'Confirmed'"; 
				}else if($Status[$a] == "Cancelled"){
				 	$StatusVal = "Status = 'Cancelled'"; 
				}else if($Status[$a] == "Occupied"){ 
					$StatusVal = "Status = 'Occupied'"; 
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
		    	$StatFilter = "Status = 'Awarded'";
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
			for($b = 0; $b<=count($Unit)-1; $b++){
				if($Unit[$b] != ""){
					$UnitStatusCount++;
					if($UnitStatusCount == 1){
						$UnitStatusVal .= "UnitType = '". $Unit[$b] ."'";
					}else{
						$UnitStatusVal .= " OR UnitType = '". $Unit[$b] ."'";
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
			if($getFilters["xcheck"] == "chkoccdate"){
				if($Date[0] != "" && $Date[1] != ""){
		    		$DateFilter = "AND (datefrom BETWEEN '". date("Y-m-d", strtotime($Date[0])) ."' AND '". date("Y-m-d", strtotime($Date[1])) ."')";
			    }else{
			    	$DateFilter = "";
			    }
				$OrderDate = "datefrom";
			}else{
				if($Date[2] != "" && $Date[3] != ""){
		    		$DateFilter = "AND (date_approved BETWEEN '". date("Y-m-d", strtotime($Date[2])) ."' AND '". date("Y-m-d", strtotime($Date[3])) ."')";
			    }else{
			    	$DateFilter = "";
			    }
				$OrderDate = "date_approved";
			}

			$getProcessOwner = mysql_fetch_array(mysql_query("SELECT ProcessOwner FROM tbluser WHERE userid = '". $_SESSION['MMS-UserID'] ."';", $connection));
		    if($getProcessOwner['ProcessOwner'] == '' || $getProcessOwner['ProcessOwner'] == null){
		    	$isProcessOwner = "";
		    }else{
		    	$isProcessOwner = " AND inqPrcssOwnr = '". $getProcessOwner['ProcessOwner'] ."'";
		    }
		    
			$page = $_POST["page"];
			$limit = ($page-1) * 20;
			$result = mysql_query("SELECT Inquiry_ID, Application_ID, TradeID, Trade_Name, Company_ID, Company_Name, DepartmentID, CategoryID, datefrom, dateto, date_approved, Status, inqSource, inqPrcssOwnr, leadsID, TenantID, req_status, ActiveProposal FROM tbltrans_inquiry WHERE ". $StatFilter ." ". $SearchFilter ." ". $UnitStatusFilter ." ". $DateFilter ." ". $isProcessOwner ." ". getMallAccess("Mall_ID", "AND") ." AND isDirect = '0' AND isAmendment = '0' ORDER BY Inquiry_ID DESC LIMIT ". $limit .",20;", $connection);
			while ($row = mysql_fetch_array($result)) {
				if($row["Status"] == "Cancelled"){
					$stat = "<span class='label label-lg label-danger arrowed-in-right arrowed' style='z-index: 0;'>Cancelled</span>";
				}else if($row["Status"] == "Confirmed"){
					$stat = "<span class='label label-lg label-success arrowed-in-right arrowed' style='z-index: 0;'>Confirmed</span>";
				}else if($row["Status"] == "Awarded"){
					$stat = "<span class='label label-lg label-purple arrowed-in-right arrowed' style='z-index: 0;'>Tentative</span>";
				}else if($row["Status"] == "Occupied"){
					$stat = "<span class='label label-lg label-warning arrowed-in-right arrowed' style='z-index: 0;'>Occupied</span>";
				}

				$Source = mysql_fetch_array(mysql_query("SELECT source_desc FROM tblref_source WHERE source_code = '". $row['inqSource'] ."';", $connection));
                $ProcessOwner = mysql_fetch_array(mysql_query("SELECT deptDesc FROM tblref_process_owner WHERE deptCode = '". $row['inqPrcssOwnr'] ."';", $connection));
                $PrimaryContact = mysql_fetch_array(mysql_query("SELECT ContactID, FullName FROM tbltrans_trade_contact_person WHERE TradeID = '". $row['TradeID'] ."';", $connection));
                $PrimaryContact_Email = mysql_fetch_array(mysql_query("SELECT content FROM tbltrans_trade_contact_person_list WHERE ContactID = '". $PrimaryContact['ContactID'] ."' AND type = 'email';", $connection));
                $PrimaryContact_Mobile = mysql_fetch_array(mysql_query("SELECT content FROM tbltrans_trade_contact_person_list WHERE ContactID = '". $PrimaryContact['ContactID'] ."' AND type = 'mobile';", $connection));
                $PrimaryContact_Telephone = mysql_fetch_array(mysql_query("SELECT content FROM tbltrans_trade_contact_person_list WHERE ContactID = '". $PrimaryContact['ContactID'] ."' AND type = 'telephone';", $connection));
                $getProposalStatus = mysql_fetch_array(mysql_query("SELECT stats, proposalNum FROM tbltrans_proposal WHERE inquiryID = '". $row['Inquiry_ID'] ."' AND proposalNum = '". $row['ActiveProposal'] ."';", $connection));
                $ContractStat = mysql_fetch_array(mysql_query("SELECT ContractStat, ContractID FROM tblcontract WHERE InquiryID = '". $row['Inquiry_ID'] ."';", $connection));
                $CheckPayment = mysql_num_rows(mysql_query("SELECT id FROM tbltransaction WHERE InquiryID = '". $row['Inquiry_ID'] ."';", $connection));
                $TenantStatus = mysql_fetch_array(mysql_query("SELECT ustatus FROM tbltrans_tenants WHERE TenantID = '". $row['TenantID'] ."';", $connection));
                $UnitCount = 0;
                $UnitInfo = "";
                $resUnit = mysql_query("SELECT UnitID FROM tbltrans_inquiry_unit WHERE InquiryID = '". $row['Inquiry_ID'] ."';", $connection);
                $UnitCount = mysql_num_rows($resUnit);
                if($UnitCount == 1){
                	$rowUnit = mysql_fetch_array($resUnit);
                	$UnitName = mysql_fetch_array(mysql_query("SELECT unitname FROM tblref_unit WHERE unitid = '". $rowUnit['UnitID'] ."';", $connection));
	                	$UnitInfo = $UnitName['unitname'];
                }else if($UnitCount >= 2){
                	$UnitInfo .= "<label class='ilalabas'>";
                	while($rowUnit = mysql_fetch_array($resUnit)){
                		$UnitName = mysql_fetch_array(mysql_query("SELECT unitname FROM tblref_unit WHERE unitid = '". $rowUnit['UnitID'] ."';", $connection));
	                	$UnitInfo .= "<span class='blue fa fa-angle-double-right'></span>&nbsp;".$UnitName['unitname'] ."<br>";
	                }
                	$UnitInfo .= "</label><label class='itatago'>Multiple</label>";
                }else{
                	$UnitInfo = "";
                }
                if(date('Y-m-d', strtotime($row['datefrom'])) == date('Y-m-d', strtotime(getsysdate()))){
                	$isOccupy = 1;
                }else{
                	$isOccupy = 0;
                }
                if($row["req_status"] == "Complete"){
					$reqstat = "<h6 style='color:green;margin-top:3px;'><i class='fa fa-check bigger-110'></i>&nbsp;&nbsp;Complete</h6>";
				}else if($row["req_status"] == "Incomplete"){
					$reqstat = "<h6 style='color:orange;margin-top:3px;'><i class='fa fa-remove bigger-110'></i>&nbsp;&nbsp;Incomplete</h6>";
				}
				$checkifhasevent = mysql_fetch_array(mysql_query("SELECT id FROM event_header WHERE inquiryid = '".$row['Inquiry_ID']."' ",$connection));
                if($checkifhasevent[0]==""){
                	$events = 0;
                }else{
                	$events = 1;
                }
                if( ($events ==1)  && ($row['Status'] == 'Pending')){
                	$isdisabled = 0;
                }else{
                	$isdisabled = 1;
                }
				echo "<tr>
						<td style='vertical-align: middle;'>". $row['Inquiry_ID'] ."</td>
						<td style='vertical-align: middle;'>". date('m/d/Y', strtotime($row['date_approved'])) ."</td>
						<td style='vertical-align: middle;' class='batayan'>". $UnitInfo ."</td>
						<td style='vertical-align: middle;'>". $row['Trade_Name'] ."</td>
						<td style='vertical-align: middle;'>". $row['Company_Name'] ."</td>
						<td style='vertical-align: middle;'>". $PrimaryContact['FullName'] ."</td>
	                    <td style='vertical-align: middle;'>". $PrimaryContact_Telephone['content'] ."</td>
	                    <td style='vertical-align: middle;'>". $PrimaryContact_Mobile['content'] ."</td>
	                    <td style='vertical-align: middle;'>". $PrimaryContact_Email['content'] ."</td>
	                    <td style='vertical-align: middle;'>". $Source['source_desc'] ."</td>
	                    <td style='vertical-align: middle;'>". $ProcessOwner['deptDesc'] ."</td>
						<td style='vertical-align: middle;'>". date('m/d/Y', strtotime($row['datefrom'])) ." - ". date('m/d/Y', strtotime($row['dateto'])) ."</td>
						<td style='z-index: 0; vertical-align: middle;'>". $reqstat."</td>
						<td style='z-index: 0; vertical-align: middle;'>". $stat."</td>
						<td style='vertical-align: middle;'>";
							// if ($row["Status"] == "Cancelled"){
							// 	echo"<button class='btn btn-sm btn-yellow hide isadmin select-reinstatereservation btn-round' onclick='EditReservation(\"". $row["TradeID"] ."\",\"". $row["Company_ID"] ."\",\"". $row["Inquiry_ID"] ."\",\"". $row["UnitID"] ."\",\"". $row["Application_ID"] ."\",\"". $row["Mall_ID"] ."\", \"Reinstate\")' title='Reinstate Reservation' style='margin: 2px;'><img src='assets/images/calendar2.png' style='width: 100%; height: auto;' /></button>";
							// }
							if($row["Status"] == "Awarded" && $ContractStat['ContractStat'] == ""){
								echo "<button class='btn btn-sm btn-info hide isadmin select-updateapplication btn-round' onclick='fncEditGlobalFormInquiry(\"0\", \"". $row['Inquiry_ID'] ."\", \"". $row['Application_ID'] ."\", \"". $row['leadsID'] ."\", \"". $row['TradeID'] ."\", \"". $row['Company_ID'] ."\", \"". $getProposalStatus['proposalNum'] ."\", \"". $getProposalStatus['stats'] ."\")' title='Update Application' style='margin: 2px;'><img src='assets/images/edit.png' style='width: 100%; height: auto;' /></button>";
							}
							if($row["Status"] == "Confirmed" && $TenantStatus['ustatus'] == 'Unoccupied'){
								echo"<button class='btn btn-sm btn-yellow hide isadmin select-occupyreservation btn-round' onclick='fncOccupyUnit(\"". $row["Inquiry_ID"] ."\", \"". $row["TenantID"] ."\", \"". $isOccupy ."\")' title='Occupy' style='margin: 2px;'><img src='assets/images/key.png' style='width: 100%; height: auto;' /></button>";
							}
							if($ContractStat['ContractStat'] == "" && $CheckPayment >= 1){
								echo"<button class='btn btn-sm btn-warning hide isadmin select-createcontract btn-round' onclick='fncCreateContractConfirm(\"". $row["Inquiry_ID"] ."\", \"". $getProposalStatus['proposalNum'] ."\")' title='Create Contract' style='margin: 2px;'><img src='assets/images/contract.png' style='width: 100%; height: auto;' /></button>";
							}else if($ContractStat['ContractStat'] == "Pending"){
								//echo"<button class='btn btn-sm btn-warning hide isadmin select-viewlogs btn-round' onclick='fncViewContractStat(\"". $row["Inquiry_ID"] ."\", \"". $ContractStat['ContractID'] ."\")' title='Approve Contract' style='margin: 2px;'><img src='assets/images/contract.png' style='width: 100%; height: auto;' /></button>";
							}else if($ContractStat['ContractStat'] == "Approved"){
								echo"<button class='btn btn-sm btn-default hide isadmin select-printcontract btn-round' onclick='fncPreviewContract(\"". $row["Inquiry_ID"] ."\", \"". $row['TenantID'] ."\", \"". $ContractStat['ContractID'] ."\", \"1\")' title='Print Contract' style='margin: 2px;'><img src='assets/images/printer.png' style='width: 100%; height: auto;' /></button>";

							}
							if($events==1 && ($row['Status'] == 'Pending')){
                            	echo"<button class='btn btn-sm btn-gray hide  isadmin select-viewevents btn-round' onclick='frmeventformop(\"". $row['Inquiry_ID'] ."\",".$events.",\"".$row['Company_ID']."\",0,\"".$row['ActiveProposal']."\",1)' title='View Event' style='margin: 2px;'><img src='assets/images/ticket.png' style='width: 100%; height: auto;' /></button>";
                            }elseif($events==1 && ($row['Status'] != 'Pending')){
                            	echo"<button class='btn btn-sm btn-gray hide  isadmin select-viewevents btn-round' onclick='frmeventformop(\"". $row['Inquiry_ID'] ."\",".$events.",\"".$row['Company_ID']."\",1,\"".$row['ActiveProposal']."\",1)' title='View Event' style='margin: 2px;'><img src='assets/images/ticket.png' style='width: 100%; height: auto;' /></button>";
                            }

							
								echo "<button class='btn btn-sm btn-default hide isadmin select-editapplication btn-round' onclick='fncEditGlobalFormInquiry(\"1\", \"". $row['Inquiry_ID'] ."\", \"". $row['Application_ID'] ."\", \"". $row['leadsID'] ."\", \"". $row['TradeID'] ."\", \"". $row['Company_ID'] ."\", \"". $getProposalStatus['proposalNum'] ."\", \"". $getProposalStatus['stats'] ."\")' title='View Reservation' style='margin: 2px;'><img src='assets/images/view.png' style='width: 100%; height: auto;' /></button>";
								echo"<button class='btn btn-sm btn-gray hide isadmin select-viewlogs btn-round' onclick='ViewTrasactionLogs(\"". $row["Inquiry_ID"] ."\")' title='View Logs' style='margin: 2px;'><img src='assets/images/clock.png' style='width: 100%; height: auto;' /></button>";
						echo"
						</td>
					</tr>";
			}
		break;

		case 'loadReservationEntries':
			$getFilters = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'Reservation' AND userid = '". $_SESSION['MMS-UserID'] ."';", $connection));
		    $Status = explode("|", $getFilters["bystat"]);
		    $Search = explode("|", $getFilters["checked_value"]);
			$DateRangeType = explode("|", $getFilters["xcheck"]);
		    $Date = explode("|", $getFilters["datefilter"]);

		    // FILTER BY STATUS
			$StatusCount = 0; $SelectedStatus = "";
			for($a = 0; $a<=count($Status)-2; $a++){
				if($Status[$a] == "Tentative"){ 
					$StatusVal = "Status = 'Awarded'"; 
				}else if($Status[$a] == "Confirmed"){ 
					$StatusVal = "Status = 'Confirmed'"; 
				}else if($Status[$a] == "Cancelled"){
				 	$StatusVal = "Status = 'Cancelled'"; 
				}else if($Status[$a] == "Occupied"){ 
					$StatusVal = "Status = 'Occupied'"; 
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
		    	$StatFilter = "Status = 'Awarded'";
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
			for($b = 0; $b<=count($Unit)-1; $b++){
				if($Unit[$b] != ""){
					$UnitStatusCount++;
					if($UnitStatusCount == 1){
						$UnitStatusVal .= "UnitType = '". $Unit[$b] ."'";
					}else{
						$UnitStatusVal .= " OR UnitType = '". $Unit[$b] ."'";
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
			if($getFilters["xcheck"] == "chkoccdate"){
				if($Date[0] != "" && $Date[1] != ""){
		    		$DateFilter = "AND (datefrom BETWEEN '". date("Y-m-d", strtotime($Date[0])) ."' AND '". date("Y-m-d", strtotime($Date[1])) ."')";
			    }else{
			    	$DateFilter = "";
			    }
				$OrderDate = "datefrom";
			}else{
				if($Date[2] != "" && $Date[3] != ""){
		    		$DateFilter = "AND (date_approved BETWEEN '". date("Y-m-d", strtotime($Date[2])) ."' AND '". date("Y-m-d", strtotime($Date[3])) ."')";
			    }else{
			    	$DateFilter = "";
			    }
				$OrderDate = "date_approved";
			}

			if($_POST["page"] == ""){ 
				$page = 1; 
			}else{ 
				$page = $_POST["page"]; 
			}
           	$limit = ($page-1) * 20;
			$getProcessOwner = mysql_fetch_array(mysql_query("SELECT ProcessOwner FROM tbluser WHERE userid = '". $_SESSION['MMS-UserID'] ."';", $connection));
		    if($getProcessOwner['ProcessOwner'] == '' || $getProcessOwner['ProcessOwner'] == null){
		    	$isProcessOwner = "";
		    }else{
		    	$isProcessOwner = " AND inqPrcssOwnr = '". $getProcessOwner['ProcessOwner'] ."'";
		    }

  			$rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM tbltrans_inquiry WHERE ". $StatFilter ." ". $SearchFilter ." ". $UnitStatusFilter ." ". $DateFilter ." ". $isProcessOwner ." ". getMallAccess("Mall_ID", "AND") ." AND isDirect = '0' AND isAmendment = '0';", $connection));
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

		case "loadReservationPagination":
			$getFilters = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'Reservation' AND userid = '". $_SESSION['MMS-UserID'] ."';", $connection));
		    $Status = explode("|", $getFilters["bystat"]);
		    $Search = explode("|", $getFilters["checked_value"]);
			$DateRangeType = explode("|", $getFilters["xcheck"]);
		    $Date = explode("|", $getFilters["datefilter"]);

		    // FILTER BY STATUS
			$StatusCount = 0; $SelectedStatus = "";
			for($a = 0; $a<=count($Status)-2; $a++){
				if($Status[$a] == "Tentative"){ 
					$StatusVal = "Status = 'Awarded'"; 
				}else if($Status[$a] == "Confirmed"){ 
					$StatusVal = "Status = 'Confirmed'"; 
				}else if($Status[$a] == "Cancelled"){
				 	$StatusVal = "Status = 'Cancelled'"; 
				}else if($Status[$a] == "Occupied"){ 
					$StatusVal = "Status = 'Occupied'"; 
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
		    	$StatFilter = "Status = 'Awarded'";
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
			for($b = 0; $b<=count($Unit)-1; $b++){
				if($Unit[$b] != ""){
					$UnitStatusCount++;
					if($UnitStatusCount == 1){
						$UnitStatusVal .= "UnitType = '". $Unit[$b] ."'";
					}else{
						$UnitStatusVal .= " OR UnitType = '". $Unit[$b] ."'";
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
			if($getFilters["xcheck"] == "chkoccdate"){
				if($Date[0] != "" && $Date[1] != ""){
		    		$DateFilter = "AND (datefrom BETWEEN '". date("Y-m-d", strtotime($Date[0])) ."' AND '". date("Y-m-d", strtotime($Date[1])) ."')";
			    }else{
			    	$DateFilter = "";
			    }
				$OrderDate = "datefrom";
			}else{
				if($Date[2] != "" && $Date[3] != ""){
		    		$DateFilter = "AND (date_approved BETWEEN '". date("Y-m-d", strtotime($Date[2])) ."' AND '". date("Y-m-d", strtotime($Date[3])) ."')";
			    }else{
			    	$DateFilter = "";
			    }
				$OrderDate = "date_approved";
			}

			$getProcessOwner = mysql_fetch_array(mysql_query("SELECT ProcessOwner FROM tbluser WHERE userid = '". $_SESSION['MMS-UserID'] ."';", $connection));
		    if($getProcessOwner['ProcessOwner'] == '' || $getProcessOwner['ProcessOwner'] == null){
		    	$isProcessOwner = "";
		    }else{
		    	$isProcessOwner = " AND inqPrcssOwnr = '". $getProcessOwner['ProcessOwner'] ."'";
		    }

			$page = $_POST["page"];
			$rowCount = mysql_fetch_row(mysql_query("SELECT COUNT(id) FROM tbltrans_inquiry WHERE ". $StatFilter ." ". $SearchFilter ." ". $UnitStatusFilter ." ". $DateFilter ." ". $isProcessOwner ." ". getMallAccess("Mall_ID", "AND") ." AND isDirect = '0' AND isAmendment = '0';", $connection));
			$rowsperpage = 20;
			$range = 3;
			$totalpages = ceil($rowCount[0] / $rowsperpage);
			$prevpage;
			$nextpage;
			if($page > 1 ){
			   	echo "<li style='width:50px !important;' onclick='ClickPaginationFunc(1)'><< First</li>";
			   	$prevpage = $page - 1;
			   	echo "<li style='width:70px !important;' onclick='ClickPaginationFunc(". $prevpage .")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   	if (($x > 0) && ($x <= $totalpages)){
			      	if ($x == $page){
		   				echo "<li id='pgReservation" . $x . "' class='pgnumReservation active' onclick='ClickPaginationFunc(" . $x . ",". $x .")'>" . $x . "</li>";
		   			}else{
						echo "<li id='pgReservation" . $x . "' class='pgnumReservation' onclick='ClickPaginationFunc(" . $x . ",". $x .")'>" . $x . "</li>"; 
					}
		       	}
		    }
		    if($page < ($totalpages - $range)){ 
		    	echo "<li>...</li>"; 
		    }
		    if ($page != $totalpages && $rowCount[0] != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='ClickPaginationFunc(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='ClickPaginationFunc(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;
	}
?>