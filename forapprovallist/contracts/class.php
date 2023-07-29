<?php
    session_start();
	include "../../connect.php";
	switch ($_POST['form']) {
		case 'loadReservationList':
			$chckrole = mysql_fetch_array(mysql_query("SELECT b.ulevel,b.role FROM tbluser a,tbltrans_hierarchy b WHERE a.groupaccess = b.role AND a.userid = '".$_SESSION['MMS-UserID']."' AND b.module = 'Contract';",$connection));
			if($chckrole['ulevel']=='1'){
				$apps = "  AND b.1st_app = '' ";
			}elseif($chckrole['ulevel']=='2'){
				$apps = " AND b.1st_app != ''  AND b.2nd_app = '' ";
			}elseif($chckrole['ulevel']=='3'){
				$apps = " AND b.1st_app != ''  AND b.2nd_app != '' AND b.3rd_app = '' ";
			}
			$StatFilter = "(a.Status = 'Awarded')";


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
						$UnitStatusVal .= "a.UnitType = '". $Unit[$b] ."'";
					}else{
						$UnitStatusVal .= " OR a.UnitType = '". $Unit[$b] ."'";
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
		    		$DateFilter = "AND (a.datefrom BETWEEN '". date("Y-m-d", strtotime($Date[0])) ."' AND '". date("Y-m-d", strtotime($Date[1])) ."')";
			    }else{
			    	$DateFilter = "";
			    }
				$OrderDate = "datefrom";
			}else{
				if($Date[2] != "" && $Date[3] != ""){
		    		$DateFilter = "AND (a.date_approved BETWEEN '". date("Y-m-d", strtotime($Date[2])) ."' AND '". date("Y-m-d", strtotime($Date[3])) ."')";
			    }else{
			    	$DateFilter = "";
			    }
				$OrderDate = "a.date_approved";
			}
		    
			$page = $_POST["page"];
			$limit = ($page-1) * 20;
			$sql = "SELECT a.Inquiry_ID, a.Application_ID, a.TradeID, a.Trade_Name, a.Company_ID, a.Company_Name, a.DepartmentID, a.CategoryID, a.datefrom, a.dateto, a.date_approved, a.Status, a.inqSource, a.inqPrcssOwnr, a.leadsID, a.TenantID,b.ContractStat,b.1st_app,b.1st_date, b.2nd_app, b.2nd_date, b.3rd_app, b.3rd_date, a.ActiveProposal FROM tbltrans_inquiry a,tblcontract b,tbluser c,tbltrans_hierarchy d WHERE a.Inquiry_ID = b.InquiryID AND a.alluserid = c.userid AND c.hierarchycode = d.hiecode  AND ". $StatFilter ." ". $SearchFilter ." ". $UnitStatusFilter ." ". $DateFilter ." ". getMallAccess("a.Mall_ID", "AND") ." AND a.isDirect = '0' AND a.isAmendment = '0' AND d.role = '".$chckrole['role']."' AND d.module = 'Contract' AND d.ulevel = '".$chckrole['ulevel']."'  ".$apps. " AND (b.ContractStat = 'Pending' OR b.ContractStat = 'Confirmed')  ORDER BY a.Inquiry_ID DESC LIMIT ". $limit .",20;";
			$result = mysql_query($sql, $connection);
			while ($row = mysql_fetch_array($result)) {
				if($row["ContractStat"] == "Pending"){
					$stat = "<span class='label label-lg label-danger arrowed-in-right arrowed' style='z-index: 0;'>Pending</span>";
				}else if($row["ContractStat"] == "Confirmed"){
					$stat = "<span class='label label-lg label-success arrowed-in-right arrowed' style='z-index: 0;'>Confirmed</span>";
				}else if($row["ContractStat"] == "Approved"){
					$stat = "<span class='label label-lg label-purple arrowed-in-right arrowed' style='z-index: 0;'>Approved</span>";
				}else if($row["ContractStat"] == "Disapproved"){
					$stat = "<span class='label label-lg label-warning arrowed-in-right arrowed' style='z-index: 0;'>Disapproved</span>";
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
                }else{
                	$UnitInfo .= "<label class='ilalabas'>";
                	while($rowUnit = mysql_fetch_array($resUnit)){
                		$UnitName = mysql_fetch_array(mysql_query("SELECT unitname FROM tblref_unit WHERE unitid = '". $rowUnit['UnitID'] ."';", $connection));
	                	$UnitInfo .= $UnitName['unitname'] ."<br>";
	                }
                	$UnitInfo .= "</label><label class='itatago'>Multiple</label>";
                }
                if($row['datefrom'] == getsysdate()){
                	$isOccupy = 1;
                }else{
                	$isOccupy = 0;
                }
 				if($row['1st_app']!=""){
                	$userapproved1 = mysql_fetch_array(mysql_query("SELECT CONCAT(lastname,', ',firstname) as fullname FROM tbluser WHERE userid = '".$row['1st_app']."' "));
                }else{
                	$userapproved1[0] = "";
                }
                if($row['2nd_app']!=""){
                	$userapproved2 = mysql_fetch_array(mysql_query("SELECT CONCAT(lastname,', ',firstname) as fullname FROM tbluser WHERE userid = '".$row['2nd_app']."' "));
                }else{
                	$userapproved2[0] = "";
                }
                if($row['3rd_date']!=""){
                	$userapproved2 = mysql_fetch_array(mysql_query("SELECT CONCAT(lastname,', ',firstname) as fullname FROM tbluser WHERE userid = '".$row['3rd_date']."' "));
                }else{
                	$userapproved3[0] = "";
                }
                $checkifhasevent = mysql_fetch_array(mysql_query("SELECT id FROM event_header WHERE inquiryid = '".$row['Inquiry_ID']."' ",$connection));
                if($checkifhasevent[0]==""){
                    $events = 0;
                }else{
                    $events = 1;
                }
				echo "<tr>
						<td style='vertical-align: middle;'>". $row['Inquiry_ID'] ."</td>
						<td style='vertical-align: middle;'>". date('m/d/Y', strtotime($row['date_approved'])) ."</td>
						<td style='vertical-align: middle;' class='batayan'>". $UnitInfo ."</td>
						<td style='vertical-align: middle;'>". $row['Trade_Name'] ."</td>
						<td style='vertical-align: middle;'>". $row['Company_Name'] ."</td>						
						<td style='vertical-align: middle;'>". date('m/d/Y', strtotime($row['datefrom'])) ." - ". date('m/d/Y', strtotime($row['dateto'])) ."</td>
						<td style='vertical-align: middle;'>".$userapproved1[0]."</td>
						<td style='vertical-align: middle;'>".$row['1st_date']."</td>
						<td style='vertical-align: middle;'>".$userapproved2[0]."</td>
						<td style='vertical-align: middle;'>".$row['2nd_date']."</td>
						<td style='vertical-align: middle;'>".$userapproved3[0]."</td>
						<td style='vertical-align: middle;'>".$row['3rd_date']."</td>
						<td style='z-index: 0; vertical-align: middle;'></td>
						<td style='z-index: 0; vertical-align: middle;'>". $stat."</td>
						<td style='vertical-align: middle;'>";
							
							
							echo"<button class='btn btn-sm btn-warning  isadmin select-viewlogs btn-round' onclick='fncViewContractStatapp(\"". $row["Inquiry_ID"] ."\", \"". $ContractStat['ContractID'] ."\")' title='Approve Contract' style='margin: 2px;'><img src='assets/images/contract.png' style='width: 100%; height: auto;' /></button>";

                            echo "<button class='btn btn-default btn-sm btn-round' aria-expanded='false' onclick='fncSelectReportType(\"". $row['Inquiry_ID'] ."\", \"LeaseContract\", \"". $getProposalStatus['proposalNum'] ."\");' style='margin: 2px;'><img src='assets/images/printer.png' style='width: 100%; height: auto;' /></button>";

							echo "<button class='btn btn-sm btn-default  isadmin select-editapplication btn-round' onclick='fncEditGlobalFormInquiry(\"1\", \"". $row['Inquiry_ID'] ."\", \"". $row['Application_ID'] ."\", \"". $row['leadsID'] ."\", \"". $row['TradeID'] ."\", \"". $row['Company_ID'] ."\", \"". $getProposalStatus['proposalNum'] ."\", \"". $getProposalStatus['stats'] ."\")' title='View Reservation' style='margin: 2px;'><img src='assets/images/view.png' style='width: 100%; height: auto;' /></button>";
							if($events==1){
                                echo"<button class='btn btn-sm btn-gray  isadmin select-viewevents btn-round' onclick='frmeventformop(\"". $row['Inquiry_ID'] ."\",".$events.",\"".$row['Company_ID']."\",1)' title='View Event' style='margin: 2px;'><img src='assets/images/ticket.png' style='width: 100%; height: auto;' /></button>";
                            }else{
                               
                            }
								
						echo"
						</td>
					</tr>";
			}
		break;

		case 'loadReservationEntries':
			$chckrole = mysql_fetch_array(mysql_query("SELECT b.ulevel,b.role FROM tbluser a,tbltrans_hierarchy b WHERE a.groupaccess = b.role AND a.userid = '".$_SESSION['MMS-UserID']."' AND b.module = 'Contract';",$connection));
			if($chckrole['ulevel']=='1'){
				$apps = "  AND b.1st_app = '' ";
			}elseif($chckrole['ulevel']=='2'){
				$apps = " AND b.1st_app != ''  AND b.2nd_app = '' ";
			}elseif($chckrole['ulevel']=='3'){
				$apps = " AND b.1st_app != ''  AND b.2nd_app != '' AND b.3rd_app = '' ";
			}
			$StatFilter = "(a.Status = 'Awarded')";


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
						$UnitStatusVal .= "a.UnitType = '". $Unit[$b] ."'";
					}else{
						$UnitStatusVal .= " OR a.UnitType = '". $Unit[$b] ."'";
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
		    		$DateFilter = "AND (a.datefrom BETWEEN '". date("Y-m-d", strtotime($Date[0])) ."' AND '". date("Y-m-d", strtotime($Date[1])) ."')";
			    }else{
			    	$DateFilter = "";
			    }
				$OrderDate = "datefrom";
			}else{
				if($Date[2] != "" && $Date[3] != ""){
		    		$DateFilter = "AND (a.date_approved BETWEEN '". date("Y-m-d", strtotime($Date[2])) ."' AND '". date("Y-m-d", strtotime($Date[3])) ."')";
			    }else{
			    	$DateFilter = "";
			    }
				$OrderDate = "a.date_approved";
			}

			if($_POST["page"] == ""){ 
				$page = 1; 
			}else{ 
				$page = $_POST["page"]; 
			}
  			$rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(a.id) FFROM tbltrans_inquiry a,tblcontract b,tbluser c,tbltrans_hierarchy d WHERE a.Inquiry_ID = b.InquiryID AND a.alluserid = c.userid AND c.hierarchycode = d.hiecode  AND ". $StatFilter ." ". $SearchFilter ." ". $UnitStatusFilter ." ". $DateFilter ." ". getMallAccess("a.Mall_ID", "AND") ." AND a.isDirect = '0' AND a.isAmendment = '0' AND d.role = '".$chckrole['role']."' AND d.module = 'Contract' AND d.ulevel = '".$chckrole['ulevel']."'  ".$apps. " AND (b.ContractStat = 'Pending' OR b.ContractStat = 'Confirmed');", $connection));
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
			$chckrole = mysql_fetch_array(mysql_query("SELECT b.ulevel,b.role FROM tbluser a,tbltrans_hierarchy b WHERE a.groupaccess = b.role AND a.userid = '".$_SESSION['MMS-UserID']."' AND b.module = 'Contract';",$connection));
			if($chckrole['ulevel']=='1'){
				$apps = "  AND b.1st_app = '' ";
			}elseif($chckrole['ulevel']=='2'){
				$apps = " AND b.1st_app != ''  AND b.2nd_app = '' ";
			}elseif($chckrole['ulevel']=='3'){
				$apps = " AND b.1st_app != ''  AND b.2nd_app != '' AND b.3rd_app = '' ";
			}
			$StatFilter = "(a.Status = 'Awarded')";


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
						$UnitStatusVal .= "a.UnitType = '". $Unit[$b] ."'";
					}else{
						$UnitStatusVal .= " OR a.UnitType = '". $Unit[$b] ."'";
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
		    		$DateFilter = "AND (a.datefrom BETWEEN '". date("Y-m-d", strtotime($Date[0])) ."' AND '". date("Y-m-d", strtotime($Date[1])) ."')";
			    }else{
			    	$DateFilter = "";
			    }
				$OrderDate = "datefrom";
			}else{
				if($Date[2] != "" && $Date[3] != ""){
		    		$DateFilter = "AND (a.date_approved BETWEEN '". date("Y-m-d", strtotime($Date[2])) ."' AND '". date("Y-m-d", strtotime($Date[3])) ."')";
			    }else{
			    	$DateFilter = "";
			    }
				$OrderDate = "a.date_approved";
			}

			$page = $_POST["page"];
			$rowCount = mysql_fetch_row(mysql_query("SELECT COUNT(a.id) FROM tbltrans_inquiry a,tblcontract b,tbluser c,tbltrans_hierarchy d WHERE a.Inquiry_ID = b.InquiryID AND a.alluserid = c.userid AND c.hierarchycode = d.hiecode  AND ". $StatFilter ." ". $SearchFilter ." ". $UnitStatusFilter ." ". $DateFilter ." ". getMallAccess("a.Mall_ID", "AND") ." AND a.isDirect = '0' AND a.isAmendment = '0' AND d.role = '".$chckrole['role']."' AND d.module = 'Contract' AND d.ulevel = '".$chckrole['ulevel']."'  ".$apps. " AND (b.ContractStat = 'Pending' OR b.ContractStat = 'Confirmed');", $connection));
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


		case 'fncChangeApproveContract2':
			$chckrole = mysql_fetch_array(mysql_query("SELECT b.ulevel,b.role FROM tbluser a,tbltrans_hierarchy b WHERE a.groupaccess = b.role AND a.userid = '".$_SESSION['MMS-UserID']."' AND b.module = 'Contract'   ",$connection));
			$getlevel =  mysql_fetch_array(mysql_query("SELECT a.alluserid,c.hierarchycode,d.ulevel,b.1st_app,b.2nd_app FROM tbltrans_inquiry a,tblcontract b,tbluser c,tbltrans_hierarchy d WHERE a.Inquiry_ID = b.InquiryID AND a.alluserid = c.userid AND c.hierarchycode = d.hiecode  AND b.InquiryID = '".$_POST['InquiryID']."'  AND d.role = '".$chckrole['role']."' AND d.module = 'Contract'",$connection));
			$setups = "";
			$check2nd = mysql_fetch_array(mysql_query("SELECT id FROM tbltrans_hierarchy WHERE hiecode = '".$getlevel['hierarchycode']."' AND module = 'Contract' AND ulevel = 2"));
			$add = $getlevel['ulevel'] + 1;
			$checklast = mysql_fetch_array(mysql_query("SELECT id FROM tbltrans_hierarchy WHERE hiecode = '".$getlevel['hierarchycode']."' AND module = 'Contract' AND ulevel = ".$add));
			if($getlevel['ulevel']=='1'){
				$updates = ",1st_app = '".$_SESSION['MMS-UserID']."',1st_date = NOW()  ";
			}elseif($getlevel['ulevel']=='2'){
				$updates = ",2nd_app = '".$_SESSION['MMS-UserID']."',2nd_date = NOW() ";
			}elseif($getlevel['ulevel']=='3'){
				$updates = ",3rd_app = '".$_SESSION['MMS-UserID']."',3rd_date = NOW() ";
			}else{
				$setups = "Please Setup Hierarchy of Approvers.";
			}
			if(($getlevel['ulevel']=='1' && $check2nd[0]=="") || ($getlevel['ulevel']!='1'  &&  $getlevel['ulevel']!=''  && $checklast[0]=="")){
				$stat = 'Approved';
			}else{
				$stat = 'Confirmed';
			}

			if($_POST['Status'] == 'Approve'){
				$stat = $stat;
			}else{
				$stat = "Disapproved";
			}

			if($setups==""){
				if($stat== 'Approved'){
					$resgetInquiry = mysql_fetch_array(mysql_query("SELECT Application_ID, Mall, Mall_ID, TradeID, Trade_Name, Company_ID, Company_Name, ClassID, DepartmentID, CategoryID, datefrom, dateto, billingtype, billingperc, desired_noofmonths, desired_noofyears, merchant_code, monthly_dues, assoc_dues, mallCompanyID, inqSource, inqPrcssOwnr, BillerID, ActiveProposal FROM tbltrans_inquiry WHERE Inquiry_ID = '". $_POST['InquiryID'] ."';", $connection));
					$TenantPrefix = mysql_fetch_array(mysql_query("SELECT TenantIDPref FROM tblref_mall WHERE mallid = '". $resgetInquiry['Mall_ID'] ."';", $connection));
					$TenantID = createidno_permall($TenantPrefix['TenantIDPref'], "tbltrans_tenants", "TenantID");
					$resInquiry = mysql_query("UPDATE tbltrans_inquiry SET Status = 'Confirmed', date_confirmed = '". date('Y-m-d H:i:s') ."', TenantID = '". $TenantID ."', contractID = '". $_POST['ContractID'] ."' WHERE Inquiry_ID = '". $_POST['InquiryID'] ."';", $connection);

					$resTenant = mysql_query("INSERT INTO tbltrans_tenants SET TenantID = '". $TenantID ."', mallID = '". $resgetInquiry['Mall_ID'] ."', owner_lastname = '". $resgetInquiry[''] ."', owner_firstname = '". $resgetInquiry[''] ."', owner_midname = '". $resgetInquiry[''] ."', appID = '". $resgetInquiry['Application_ID'] ."', inqID = '". $_POST['InquiryID'] ."', tradeID = '". $resgetInquiry['TradeID'] ."', tradename = '". $resgetInquiry['Trade_Name'] ."', CompanyID = '". $resgetInquiry['Company_ID'] ."', companyname = '". $resgetInquiry['Company_Name'] ."', datefrom = '". $resgetInquiry['datefrom'] ."', dateto = '". $resgetInquiry['dateto'] ."', Status = 'Active', noofyears = '". $resgetInquiry['desired_noofyears'] ."', noofmonths = '". $resgetInquiry['desired_noofmonths'] ."', ustatus = 'Unoccupied', tenanttype = '". $resgetInquiry['billingtype'] ."', revpercent = '". $resgetInquiry['billingperc'] ."', merchant_code = '". $resgetInquiry['merchant_code'] ."', ContractID = '". $_POST['ContractID'] ."', monthly_dues = '". $resgetInquiry['monthly_dues'] ."', assoc_dues = '". $resgetInquiry['assoc_dues'] ."', mallCompanyID = '". $resgetInquiry['mallCompanyID'] ."', ClassID = '". $resgetInquiry['ClassID'] ."', DepartmentID = '". $resgetInquiry['DepartmentID'] ."', CategoryID = '". $resgetInquiry['CategoryID'] ."', inqSource = '". $resgetInquiry['inqSource'] ."', inqPrcssOwnr = '". $resgetInquiry['inqPrcssOwnr'] ."', BillerID = '". $resgetInquiry['BillerID'] ."', ActiveProposal = '". $resgetInquiry['ActiveProposal'] ."';", $connection);

					$updateunit = mysql_query("SELECT unitID FROM tbltrans_inquiry_unit WHERE InquiryID = '".$_POST['InquiryID']."'");
					while ($rowunitup = mysql_fetch_array($updateunit)) {
						$updatestatusunit = mysql_fetch_array(mysql_query("UPDATE tblref_unit SET status = 'Reserved' WHERE unitid = '".$rowunitup[0]."' "));
					}
				}
				$resContact = mysql_query("UPDATE tblcontract SET ContractStat = '". $stat ."', appr_id2 = '". $_SESSION['MMS-UserID'] ."', appr_user2 = '". getusername() ."', appr_date2 = '". date('Y-m-d H:i:s') ."' ".$updates." WHERE ContractID = '". $_POST['ContractID'] ."' AND InquiryID = '". $_POST['InquiryID'] ."';", $connection);
				if($resContact == true){
					echo "1|".$TenantID;
					// INSERT LOGS JONAS 10/4/2019 START
					if($stat == 'Approved'){
						$Classification = mysql_fetch_array(mysql_query("SELECT classification FROM tblref_merchandise_class WHERE classificationID = '". $resgetInquiry['ClassID'] ."'", $connection));
						$Department = mysql_fetch_array(mysql_query("SELECT department FROM tblref_merchandise_depa WHERE departmentID = '". $resgetInquiry['DepartmentID'] ."'", $connection));
						$Category = mysql_fetch_array(mysql_query("SELECT category FROM tblref_merchandisedep_cat WHERE categoryID = '". $resgetInquiry['CategoryID'] ."'", $connection));
						$arrHeader = ["Inquiry ID", "Contract ID", "Tenant ID", "Mall ID", "Mall", "Application ID", "Trade ID", "Trade Name", "Company ID", "Company Name", "Start Date", "End Date", "Number of Years", "Number of Months", "Billing Type", "Billing Percentage", "Merchant Code", "Mall Company ID", "Classification", "Department", "Category", "Source", "Process Owner", "Biller ID"];
						$arrValue = [$_POST['InquiryID'], $_POST['ContractID'], $TenantID, $resgetInquiry['Mall_ID'], $resgetInquiry['Mall'], $resgetInquiry['Application_ID'], $resgetInquiry['TradeID'], $resgetInquiry['Trade_Name'], $resgetInquiry['Company_ID'], $resgetInquiry['Company_Name'], date('m/d/Y', strtotime($resgetInquiry['datefrom'])), date('m/d/Y', strtotime($resgetInquiry['dateto'])), $resgetInquiry['desired_noofyears'], $resgetInquiry['desired_noofmonths'], $resgetInquiry['billingtype'], $resgetInquiry['billingperc'], $resgetInquiry['merchant_code'], $resgetInquiry['mallCompanyID'], $Classification['classification'], $Department['department'], $Category['category'], $resgetInquiry['inqSource'], $resgetInquiry['inqPrcssOwnr'], $resgetInquiry['BillerID']];
						$tran_logs = create_logs_per_transaction("confirmed a contract.", "Reservation Module", createXinfo("UPDATE", $arrHeader, "", $arrValue, "", "", ""), "" ,"UPDATE", $_POST['InquiryID']);
					}else{
						$arrHeader = ["Inquiry ID", "Contract ID"];
						$arrValue = [$_POST['InquiryID'], $_POST['ContractID']];
						$tran_logs = create_logs_per_transaction($stat." a contract.", "Reservation Module", createXinfo("UPDATE", $arrHeader, "", $arrValue, "", "", ""), "" ,"UPDATE", $_POST['InquiryID']);
					}
					// INSERT LOGS JONAS 10/4/2019 END
				}else{
					echo "2|";
				}

			}else{
				echo $setups."|";
			}
			
		break;

		case 'saveContractappFilter':
			$chckrole = mysql_fetch_array(mysql_query("SELECT b.ulevel,b.role FROM tbluser a,tbltrans_hierarchy b WHERE a.groupaccess = b.role AND a.userid = '".$_SESSION['MMS-UserID']."' AND b.module = 'Contract'   ",$connection));
			if($chckrole['ulevel']=='1'){
				$apps = "1st_app";
			}elseif($chckrole['ulevel']=='2'){
				$apps = "2nd_app";
			}elseif($chckrole['ulevel']=='3'){
				$apps = "3rd_app";
			}

			$filterstatusprop = "";
			$statusprop =  explode("|", $_POST['checked3']);
			for($i=0;$i<=count($statusprop);$i++){
				if($statusprop[$i]=='Pending'){
					$xtatx .= "  b.ContractStat = 'Pending' OR";
				}elseif($statusprop[$i]=='Approved'){
					$xtatx .= "  b.ContractStat = 'Approve' OR b.ContractStat = 'Approved' OR";
				}elseif($statusprop[$i]=='Disapproved'){
					$xtatx .= "  b.ContractStat = 'Disapproved' OR b.ContractStat = 'Disapprove' OR";
				}elseif($statusprop[$i]=='Confirmed'){
					$xtatx .= "  b.ContractStat = 'Confirmed' OR";
				}
			}
			

			if($xtatx!=""){
				$xtatx = substr($xtatx, 0, -2);
				$filterstatusprop = " AND ( ".$xtatx." ) ";
			}

			// FILTER BY DATE RANGE
			if($getFilters["xcheck"] == "chkoccdate"){
				if($Date[0] != "" && $Date[1] != ""){
		    		$DateFilter = "AND (a.datefrom BETWEEN '". date("Y-m-d", strtotime($Date[0])) ."' AND '". date("Y-m-d", strtotime($Date[1])) ."')";
			    }else{
			    	$DateFilter = "";
			    }
				$OrderDate = "datefrom";
			}else{
				if($Date[2] != "" && $Date[3] != ""){
		    		$DateFilter = "AND (a.date_approved BETWEEN '". date("Y-m-d", strtotime($Date[2])) ."' AND '". date("Y-m-d", strtotime($Date[3])) ."')";
			    }else{
			    	$DateFilter = "";
			    }
				$OrderDate = "a.date_approved";
			}
		    
			$page = $_POST["page"];
			$limit = ($page-1) * 20;
			$sql = "SELECT a.Inquiry_ID, a.Application_ID, a.TradeID, a.Trade_Name, a.Company_ID, a.Company_Name, a.DepartmentID, a.CategoryID, a.datefrom, a.dateto, a.date_approved, a.Status, a.inqSource, a.inqPrcssOwnr, a.leadsID, a.TenantID, b.ContractStat, b.1st_app, b.2nd_app, b.1st_date, b.2nd_date, b.3rd_app, b.3rd_date, a.ActiveProposal FROM tbltrans_inquiry a,tblcontract b,tbluser c,tbltrans_hierarchy d WHERE a.Inquiry_ID = b.InquiryID AND a.alluserid = c.userid AND c.hierarchycode = d.hiecode   ". getMallAccess("a.Mall_ID", "AND") ." AND d.role = '".$chckrole['role']."' AND d.module = 'Contract' AND d.ulevel = '".$chckrole['ulevel']."' ".$filterstatusprop." ".$filterdates." ".$filtersearch."  ".$DateFilter."  ORDER BY a.Inquiry_ID DESC ";
			$result = mysql_query($sql, $connection);
			
			while ($row = mysql_fetch_array($result)) {
				if($row["ContractStat"] == "Pending"){
					$appstat = "<span class='label label-lg label-danger arrowed-in-right arrowed' style='z-index: 0;'>Pending</span>";
				}else if($row["ContractStat"] == "Confirmed"){
					$appstat = "<span class='label label-lg label-success arrowed-in-right arrowed' style='z-index: 0;'>Confirmed</span>";
				}else if($row["ContractStat"] == "Approved" || $row["ContractStat"] == "Approve"){
					$appstat = "<span class='label label-lg label-success arrowed-in-right arrowed' style='z-index: 0;'>Approved</span>";
				}else if($row["ContractStat"] == "Disapproved" || $row["ContractStat"] == "Disapprove"){
					$appstat = "<span class='label label-lg label-danger arrowed-in-right arrowed' style='z-index: 0;'>Disapproved</span>";
				}

				if($row["Status"] == "Pending" && ($row["forFinal"] == "1" || $row['S2Leasing'] == "1")){
					$stat = "<span class='label label-lg label-pink arrowed-in-right arrowed' style='z-index: 0;'>Pending</span>";
				}else if($row["Status"] == "ForAwarding"){
					$stat = "<span class='label label-lg label-yellow arrowed-in-right arrowed' style='z-index: 0;'>For Awarding</span>";
				}else if($row["Status"] == "Awarded"){
					$stat = "<span class='label label-lg label-info arrowed-in-right arrowed' style='z-index: 0;'>Awarded</span>";
				}else if($row["Status"] == "Confirmed"){
					$stat = "<span class='label label-lg label-success arrowed-in-right arrowed' style='z-index: 0;'>Confirmed</span>";
				}else if($row["Status"] == "Occupied"){
					$stat = "<span class='label label-lg label-warning arrowed-in-right arrowed' style='z-index: 0;'>Occupied</span>";
				}else if($row["Status"] == "Cancelled"){
					$stat = "<span class='label label-lg label-danger arrowed-in-right arrowed' style='z-index: 0;'>Cancelled</span>";
				}else if($row["Status"] == "Disapprove" || $row["Status"] == "Disapproved"){
					$stat = "<span class='label label-lg label-danger arrowed-in-right arrowed' style='z-index: 0;'>Disapproved</span>";
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
                }else{
                	$UnitInfo .= "<label class='ilalabas'>";
                	while($rowUnit = mysql_fetch_array($resUnit)){
                		$UnitName = mysql_fetch_array(mysql_query("SELECT unitname FROM tblref_unit WHERE unitid = '". $rowUnit['UnitID'] ."';", $connection));
	                	$UnitInfo .= $UnitName['unitname'] ."<br>";
	                }
                	$UnitInfo .= "</label><label class='itatago'>Multiple</label>";
                }
                if($row['datefrom'] == getsysdate()){
                	$isOccupy = 1;
                }else{
                	$isOccupy = 0;
                }
                if($row['1st_app']!=""){
                	$userapproved1 = mysql_fetch_array(mysql_query("SELECT CONCAT(lastname,', ',firstname) as fullname FROM tbluser WHERE userid = '".$row['1st_app']."' "));
                }else{
                	$userapproved1[0] = "";
                }
                if($row['2nd_app']!=""){
                	$userapproved2 = mysql_fetch_array(mysql_query("SELECT CONCAT(lastname,', ',firstname) as fullname FROM tbluser WHERE userid = '".$row['2nd_app']."' "));
                }else{
                	$userapproved2[0] = "";
                }
                if($row['3rd_app']!=""){
                	$userapproved3 = mysql_fetch_array(mysql_query("SELECT CONCAT(lastname,', ',firstname) as fullname FROM tbluser WHERE userid = '".$row['3rd_app']."' "));
                }else{
                	$userapproved3[0] = "";
                }
                $checkifhasevent = mysql_fetch_array(mysql_query("SELECT id FROM event_header WHERE inquiryid = '".$row['Inquiry_ID']."' ",$connection));
                if($checkifhasevent[0]==""){
                    $events = 0;
                }else{
                    $events = 1;
                }
				echo "<tr>
						<td style='vertical-align: middle;'>". $row['Inquiry_ID'] ."</td>
						<td style='vertical-align: middle;'>". date('m/d/Y', strtotime($row['date_approved'])) ."</td>
						<td style='vertical-align: middle;' class='batayan'>". $UnitInfo ."</td>
						<td style='vertical-align: middle;'>". $row['Trade_Name'] ."</td>
						<td style='vertical-align: middle;'>". $row['Company_Name'] ."</td>						
						<td style='vertical-align: middle;'>". date('m/d/Y', strtotime($row['datefrom'])) ." - ". date('m/d/Y', strtotime($row['dateto'])) ."</td>
						<td style='vertical-align: middle;'>".$userapproved1[0]."</td>
						<td style='vertical-align: middle;'>".$row['1st_date']."</td>
						<td style='vertical-align: middle;'>".$userapproved2[0]."</td>
						<td style='vertical-align: middle;'>".$row['2nd_date']."</td>
						<td style='vertical-align: middle;'>".$userapproved3[0]."</td>
						<td style='vertical-align: middle;'>".$row['3rd_date']."</td>
						<td style='z-index: 0; vertical-align: middle;'>".$appstat."</td>
						<td style='z-index: 0; vertical-align: middle;'>". $stat."</td>
						<td style='vertical-align: middle;'>";
							
							if(($row['ContractStat']=="Pending" || $row['ContractStat']=="Confirmed") && $row[$apps]!=$_SESSION['MMS-UserID']){
								if(($apps=='1st_app' && $row['1st_app']=="") || ($apps=='2nd_app' && $row['1st_app']!="" && $row['2nd_app']=="") || ($apps=='3rd_app' && $row['1st_app']!="" && $row['2nd_app']!="" && $row['3rd_app']=="")) {
									echo"<button class='btn btn-sm btn-warning  isadmin select-viewlogs btn-round' onclick='fncViewContractStatapp(\"". $row["Inquiry_ID"] ."\", \"". $ContractStat['ContractID'] ."\")' title='Approve Contract' style='margin: 2px;'><img src='assets/images/contract.png' style='width: 100%; height: auto;' /></button>";
								}	
							}
							echo"<button class='btn btn-sm btn-default  isadmin select-viewlogs btn-round' onclick='fncPreviewContract(\"". $row["Inquiry_ID"] ."\", \"". $row['TenantID'] ."\", \"". $ContractStat['ContractID'] ."\", \"1\")' title='Print Contract' style='margin: 2px;'><img src='assets/images/printer.png' style='width: 100%; height: auto;' /></button>";
							echo "<button class='btn btn-sm btn-default  isadmin select-editapplication btn-round' onclick='fncEditGlobalFormInquiry(\"1\", \"". $row['Inquiry_ID'] ."\", \"". $row['Application_ID'] ."\", \"". $row['leadsID'] ."\", \"". $row['TradeID'] ."\", \"". $row['Company_ID'] ."\", \"". $getProposalStatus['proposalNum'] ."\", \"". $getProposalStatus['stats'] ."\")' title='View Reservation' style='margin: 2px;'><img src='assets/images/view.png' style='width: 100%; height: auto;' /></button>";
							if($events==1){
                                echo"<button class='btn btn-sm btn-gray  isadmin select-viewevents btn-round' onclick='frmeventformop(\"". $row['Inquiry_ID'] ."\",".$events.",\"".$row['Company_ID']."\",1)' title='View Event' style='margin: 2px;'><img src='assets/images/ticket.png' style='width: 100%; height: auto;' /></button>";
                            }else{
                               
                            }	
						echo"
						</td>
					</tr>";
			}
		break;

		case 'fncChangeReassessContract2':
			$res = mysql_query("UPDATE tbltrans_inquiry SET Status = 'Awarded',date_confirmed = NULL, TenantID = '', contractID = '' WHERE Inquiry_ID = '". $_POST['InquiryID'] ."';", $connection) or die(mysql_error());
			$res2 = mysql_query("DELETE FROM tblcontract WHERE InquiryID = '". $_POST['InquiryID'] ."' AND ContractID = '".$_POST['ContractID']."';", $connection) or die(mysql_error());
			$RemarksID = createidno("REM", "tbltrans_remarks", "remID");
			$remarksadd = mysql_query("INSERT INTO tbltrans_remarks SET remID = '".$RemarksID."',inqID = '".$_POST['InquiryID']."',xremarks = '".mysql_real_escape_string($_POST['txtreassessremarks'])."', UserID = '".$_SESSION['MMS-UserID']."' ") or die(mysql_error());
			$arrHeader = ["Inquiry ID", "Status"];
			$arrValue = [$_POST['InquiryID'], "For Confirmed"];
			$tran_logs = create_logs_per_transaction("set this application to reassess. Remarks(".$_POST['txtreassessremarks'].") ", "Reservation Module", createXinfo("UPDATE", $arrHeader, "", $arrValue, "", "", ""), "" ,"UPDATE", $_POST['InquiryID']);
			
		break;

	}
?>