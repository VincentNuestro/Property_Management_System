<?php  
	session_start();
	include "../../connect.php";
	switch ($_POST['form']) {
		case 'tblListofApplication':
			$chckrole = mysql_fetch_array(mysql_query("SELECT b.ulevel,b.role FROM tbluser a,tbltrans_hierarchy b WHERE a.groupaccess = b.role AND a.userid = '".$_SESSION['MMS-UserID']."' AND b.module = 'Awarding'   ",$connection));
			if($chckrole['ulevel']=='1'){
				$apps = "  AND a.1st_app_aw = '' ";
			}elseif($chckrole['ulevel']=='2'){
				$apps = " AND a.1st_app_aw != ''  AND a.2nd_app_aw = '' ";
			}
			$StatFilter = "(a.Status = 'ForAwarding') AND (a.awardstatus = '' OR a.awardstatus = 'Pending' OR a.awardstatus = 'Confirmed') ";

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
		    	$DateFilter = "AND (a.date_inquired BETWEEN '". date("Y-m-d", strtotime($Date[0])) ."' AND '". date("Y-m-d", strtotime($Date[1])) ."')";
		    }else{
		    	$DateFilter = "";
		    }
			
			$page = $_POST["page"];
			$limit = ($page-1) * 20;
			$sql = "SELECT a.TradeID, a.Company_ID, a.Inquiry_ID, a.UnitID, a.Application_ID, a.Trade_Name, a.Company_Name, a.Industry, a.Company_ID, a.date_inquired, a.Status, a.req_status, a.UnitType, a.Mall_ID, a.month_adv, a.leadsID, a.S2Leasing, a.forFinal, a.inqSource, a.inqPrcssOwnr, a.1st_app_aw, a.1st_date_aw, a.2nd_app_aw, a.2nd_date_aw, a.awardstatus, a.ActiveProposal FROM tbltrans_inquiry a,tbluser b,tbltrans_hierarchy c WHERE a.alluserid = b.userid AND b.hierarchycode = c.hiecode AND ". $StatFilter ." ". $SearchFilter ." ". $DateFilter ." ". getMallAccess("Mall_ID", "AND") ." AND a.isDirect = '0' AND a.isAmendment = '0' AND c.role = '".$chckrole['role']."' AND c.module = 'Awarding' AND c.ulevel = '".$chckrole['ulevel']."' ".$apps. " ORDER BY a.Inquiry_ID DESC LIMIT ".$limit.", 20;";
			$result = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($result)){
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
				}

				if($row["req_status"] == "Complete"){
					$reqstat = "<h6 style='color:green;margin-top:3px;'><i class='fa fa-check bigger-110'></i>&nbsp;&nbsp;Complete</h6>";
				}else if($row["req_status"] == "Incomplete"){
					$reqstat = "<h6 style='color:orange;margin-top:3px;'><i class='fa fa-remove bigger-110'></i>&nbsp;&nbsp;Incomplete</h6>";
				}

				$Source = mysql_fetch_array(mysql_query("SELECT source_desc FROM tblref_source WHERE source_code = '". $row['inqSource'] ."';", $connection));
                $ProcessOwner = mysql_fetch_array(mysql_query("SELECT deptDesc FROM tblref_process_owner WHERE deptCode = '". $row['inqPrcssOwnr'] ."';", $connection));
                $PrimaryContact = mysql_fetch_array(mysql_query("SELECT ContactID, FullName FROM tbltrans_trade_contact_person WHERE TradeID = '". $row['TradeID'] ."';", $connection));
                $PrimaryContact_Email = mysql_fetch_array(mysql_query("SELECT content FROM tbltrans_trade_contact_person_list WHERE ContactID = '". $PrimaryContact['ContactID'] ."' AND type = 'email';", $connection));
                $PrimaryContact_Mobile = mysql_fetch_array(mysql_query("SELECT content FROM tbltrans_trade_contact_person_list WHERE ContactID = '". $PrimaryContact['ContactID'] ."' AND type = 'mobile';", $connection));
                $PrimaryContact_Telephone = mysql_fetch_array(mysql_query("SELECT content FROM tbltrans_trade_contact_person_list WHERE ContactID = '". $PrimaryContact['ContactID'] ."' AND type = 'telephone';", $connection));
                $getProposalStatus = mysql_fetch_array(mysql_query("SELECT stats, proposalNum FROM tbltrans_proposal WHERE inquiryID = '". $row['Inquiry_ID'] ."' AND proposalNum = '". $row['ActiveProposal'] ."';", $connection));

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
                if($row["awardstatus"]=='' || $row['awardstatus']=='Pending'){
                	$appstatus = "<span class='label label-lg label-pink arrowed-in-right arrowed' style='z-index: 0;'>Pending</span>";
                }elseif($row["awardstatus"]=='Confirmed'){
                	$appstatus =  "<span class='label label-lg label-success arrowed-in-right arrowed' style='z-index: 0;'>Confirmed</span>";
                }elseif($row["awardstatus"]=='Disapprove' || $row["awardstatus"]=='Disapproved'){
                	$appstatus =  "<span class='label label-lg label-danger arrowed-in-right arrowed' style='z-index: 0;'>Disapproved</span>";
                }

                if($row['1st_app_aw']!=""){
                	$userapproved1 = mysql_fetch_array(mysql_query("SELECT CONCAT(lastname,', ',firstname) as fullname FROM tbluser WHERE userid = '".$row['1st_app_aw']."' "));
                }else{
                	$userapproved1[0] = "";
                }
                if($row['2nd_app_aw']!=""){
                	$userapproved2 = mysql_fetch_array(mysql_query("SELECT CONCAT(lastname,', ',firstname) as fullname FROM tbluser WHERE userid = '".$row['2nd_app_aw']."' "));
                }else{
                	$userapproved2[0] = "";
                }

                $checkifhasevent = mysql_fetch_array(mysql_query("SELECT id FROM event_header WHERE inquiryid = '".$row['Inquiry_ID']."' ",$connection));
                if($checkifhasevent[0]==""){
                    $events = 0;
                }else{
                    $events = 1;
                }
				echo "	<tr>
							<td style='vertical-align: middle;'>". $row['Inquiry_ID'] ."</td>
							<td style='vertical-align: middle;'>". date('m/d/Y', strtotime($row["date_inquired"])) ."</td>
							<td style='vertical-align: middle;' class='batayan'>". $UnitInfo ."</td>
							<td style='vertical-align: middle;'>". $row["Trade_Name"] ."</td>
							<td style='vertical-align: middle;'>". $row["Company_Name"] ."</td>
		                    <td style='vertical-align: middle;'>". $Source['source_desc'] ."</td>
		                    <td style='vertical-align: middle;'>". $ProcessOwner['deptDesc'] ."</td>
		                    <td style='vertical-align: middle;'>".$userapproved1[0]."</td>
		                    <td style='vertical-align: middle;'>".$row['1st_date_aw']."</td>
		                    <td style='vertical-align: middle;'>".$userapproved2[0]."</td>
		                    <td style='vertical-align: middle;'>".$row['2nd_date_aw']."</td>
							<td style='vertical-align: middle;'>". $stat ."</td>
							<td style='vertical-align: middle;'>". $appstatus ."</td>
							<td style='vertical-align: middle;'><div class='btn-group'>";
									if($row['forFinal'] == 0 && $row['Status'] != 'Cancelled'){
										echo "<button class='btn btn-sm btn-info  isadmin select-editapplication btn-round' onclick='fncEditGlobalFormInquiry(\"0\", \"". $row['Inquiry_ID'] ."\", \"". $row['Application_ID'] ."\", \"". $row['leadsID'] ."\", \"". $row['TradeID'] ."\", \"". $row['Company_ID'] ."\", \"". $getProposalStatus['proposalNum'] ."\", \"". $getProposalStatus['stats'] ."\")' title='Update Application' style='margin: 2px;'><img src='assets/images/edit.png' style='width: 100%; height: auto;' /></button>";
									}

									if($getProposalStatus['stats'] == '1' && ($row['Status'] == 'Pending' || $row['Status'] == 'ForAwarding')){
										echo "<button class='btn btn-sm btn-yellow  isadmin select-editapplication btn-round' onclick='fncSendAwardNotice(\"". $row["Inquiry_ID"] ."\", \"". $row['Status'] ."\");' title='Award Tenant' style='margin: 2px;'><img src='assets/images/award.png' style='width: 100%; height: auto;' /></button>";
									}									

									if($row['Status'] != 'Cancelled'){
										echo "<button class='btn btn-sm btn-purple  isadmin select-editapplication btn-round' onclick='fncBrowseProposalList(\"". $row["Inquiry_ID"] ."\", \"". $row['Company_ID'] ."\", \"". $row['TradeID'] ."\", \"". $row['forFinal'] ."\");' title='Lease Proposal' style='margin: 2px;'><img src='assets/images/resume.png' style='width: 100%; height: auto;' /></button>";
									}else{
										echo "<button class='btn btn-sm btn-purple  isadmin select-editapplication btn-round' onclick='fncBrowseProposalList(\"". $row["Inquiry_ID"] ."\", \"". $row['Company_ID'] ."\", \"". $row['TradeID'] ."\", \"1\");' title='Lease Proposal' style='margin: 2px;'><img src='assets/images/resume.png' style='width: 100%; height: auto;' /></button>";
									}


									if($events == 1){
		                                echo"<button class='btn btn-sm btn-gray isadmin select-viewevents btn-round' onclick='frmeventformop(\"". $row['Inquiry_ID'] ."\",".$events.",\"".$row['Company_ID']."\", 1)' title='View Event' style='margin: 2px;'><img src='assets/images/ticket.png' style='width: 100%; height: auto;' /></button>";
		                            }
		                            
                                    echo "<button class='btn btn-default btn-sm btn-round' aria-expanded='false' onclick='fncSelectReportType(\"". $row['Inquiry_ID'] ."\", \"AwardNotice\", \"". $getProposalStatus['proposalNum'] ."\");' style='margin: 2px;'><img src='assets/images/printer.png' style='width: 100%; height: auto;' /></button>";

									echo"</div>
							</td>
						</tr>";
			}
		break;

		case 'tblListofApplicationEntries':
			$chckrole = mysql_fetch_array(mysql_query("SELECT b.ulevel,b.role FROM tbluser a,tbltrans_hierarchy b WHERE a.groupaccess = b.role AND a.userid = '".$_SESSION['MMS-UserID']."' AND b.module = 'Awarding'   ",$connection));
			if($chckrole['ulevel']=='1'){
				$apps = "  AND a.1st_app_aw = '' ";
			}elseif($chckrole['ulevel']=='2'){
				$apps = " AND a.1st_app_aw != ''  AND a.2nd_app_aw = '' ";
			}
			$StatFilter = "(a.Status = 'ForAwarding') AND (a.awardstatus = '' OR a.awardstatus = 'Pending' OR a.awardstatus = 'Confirmed') ";

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
		    	$DateFilter = "AND (a.date_inquired BETWEEN '". date("Y-m-d", strtotime($Date[0])) ."' AND '". date("Y-m-d", strtotime($Date[1])) ."')";
		    }else{
		    	$DateFilter = "";
		    }

           	$limit = ($page-1) * 20;
  			$rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(a.id) FROM tbltrans_inquiry a,tbluser b,tbltrans_hierarchy c WHERE a.alluserid = b.userid AND b.hierarchycode = c.hiecode  AND  ". $StatFilter ." ". $SearchFilter ." ". $DateFilter ." ". getMallAccess("Mall_ID", "AND") ." AND a.isDirect = '0' AND a.isAmendment = '0' AND c.role = '".$chckrole['role']."' AND c.module = 'Awarding' AND c.ulevel = '".$chckrole['ulevel']."' ".$apps. ";", $connection));
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

		case 'tblListofApplicationPagination':
			$chckrole = mysql_fetch_array(mysql_query("SELECT b.ulevel,b.role FROM tbluser a,tbltrans_hierarchy b WHERE a.groupaccess = b.role AND a.userid = '".$_SESSION['MMS-UserID']."' AND b.module = 'Awarding'   ",$connection));
			if($chckrole['ulevel']=='1'){
				$apps = "  AND a.1st_app_aw = '' ";
			}elseif($chckrole['ulevel']=='2'){
				$apps = " AND a.1st_app_aw != ''  AND a.2nd_app_aw = '' ";
			}
			$StatFilter = "(a.Status = 'ForAwarding') AND (a.awardstatus = '' OR a.awardstatus = 'Pending' OR a.awardstatus = 'Confirmed') ";

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
		    	$DateFilter = "AND (a.date_inquired BETWEEN '". date("Y-m-d", strtotime($Date[0])) ."' AND '". date("Y-m-d", strtotime($Date[1])) ."')";
		    }else{
		    	$DateFilter = "";
		    }
			$page = $_POST["page"];
			$rowCount = mysql_fetch_row(mysql_query("SELECT COUNT(a.id) FROM tbltrans_inquiry a,tbluser b,tbltrans_hierarchy c WHERE a.alluserid = b.userid AND b.hierarchycode = c.hiecode  AND  ". $StatFilter ." ". $SearchFilter ." ". $DateFilter ." ". getMallAccess("Mall_ID", "AND") ." AND a.isDirect = '0' AND a.isAmendment = '0' AND c.role = '".$chckrole['role']."' AND c.module = 'Awarding' AND c.ulevel = '".$chckrole['ulevel']."' ".$apps. ";", $connection));
			$rowsperpage = 20;
			$range = 3;
			$totalpages = ceil($rowCount[0] / $rowsperpage);
			$prevpage;
			$nextpage;
			if($page > 1 ){
			   echo "<li style='width:50px !important;' onclick='tblListofApplicationPageFunc(1)'><< First</li>";
			   $prevpage = $page - 1;
			   echo "<li style='width:70px !important;' onclick='tblListofApplicationPageFunc(". $prevpage .")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   	if (($x > 0) && ($x <= $totalpages)){
			      	if ($x == $page){
		   				echo "<li id='pgLA" . $x . "' class='pgnumLA active' onclick='tblListofApplicationPageFunc(" . $x . ",". $x .")'>" . $x . "</li>"; 
		   			}else{
						echo "<li id='pgLA" . $x . "' class='pgnumLA' onclick='tblListofApplicationPageFunc(" . $x . ",". $x .")'>" . $x . "</li>"; 
					}
		       	}
		    }
		    if($page < ($totalpages - $range)){ 
		    	echo "<li>...</li>"; 
		    }
		    if($page != $totalpages && $rowCount[0] != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='tblListofApplicationPageFunc(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='tblListofApplicationPageFunc(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'fncgetProposalList':
			$resPro = mysql_query("SELECT proposalNum, stats, datecreated, date_approved, approved_by FROM tbltrans_proposal WHERE inquiryID = '". $_POST['InquiryID'] ."';", $connection);
			$cntPro = mysql_num_rows($resPro);
			if($cntPro == 0){
				$InquiryInfo = mysql_fetch_array(mysql_query("SELECT Inquiry_ID, Application_ID, leadsID, TradeID, Company_ID, date_inquired, Status FROM tbltrans_inquiry WHERE Inquiry_ID = '". $_POST['InquiryID'] ."';", $connection));
				if($InquiryInfo['Status'] == 'Cancelled'){
					$isEdit = "1";
				}else{
					$isEdit = "0";
				}
				echo 	"<div class='col-md-4' style='margin-top: 10px; cursor: pointer !important;' onclick='fncEditGlobalFormInquiry(\"". $isEdit ."\", \"". $InquiryInfo['Inquiry_ID'] ."\", \"". $InquiryInfo['Application_ID'] ."\", \"". $InquiryInfo['leadsID'] ."\", \"". $InquiryInfo['TradeID'] ."\", \"". $InquiryInfo['Company_ID'] ."\", \"0\", \"\")'>
							<div class='alert alert-warning'>
								<center>
									<h4 class='header'>Proposal 1</h4>
									". date('F d, Y', strtotime($InquiryInfo['date_inquired'])) ."
								</center>
							</div>
						</div>";
			}else{
				while ($rowPro = mysql_fetch_array($resPro)) {
					if($rowPro['stats'] == 1){
						$alertColor = "info";
					}else{
						$alertColor = "warning";
					}
					$InquiryInfo = mysql_fetch_array(mysql_query("SELECT Inquiry_ID, Application_ID, leadsID, TradeID, Company_ID, forFinal, app_by, date_applied, Status FROM tbltrans_inquiry WHERE Inquiry_ID = '". $_POST['InquiryID'] ."';", $connection));

					if($InquiryInfo['Status'] == 'Cancelled'){
						$isEdit = "1";
					}else{
						$isEdit = $InquiryInfo['forFinal'];
					}

					if($rowPro['stats'] == '1'){
						echo 	"<div class='col-md-4' style='margin-top: 10px;'>
									<div class='alert alert-". $alertColor ."' style='cursor: pointer !important;'>
										<center onclick='fncEditGlobalFormInquiry(\"". $isEdit ."\", \"". $InquiryInfo['Inquiry_ID'] ."\", \"". $InquiryInfo['Application_ID'] ."\", \"". $InquiryInfo['leadsID'] ."\", \"". $InquiryInfo['TradeID'] ."\", \"". $InquiryInfo['Company_ID'] ."\", \"". $rowPro['proposalNum'] ."\", \"". $rowPro['stats'] ."\")'>
											<h4 class='header'>Proposal ". $rowPro['proposalNum'] ."</h4>
											". date('F d, Y', strtotime($rowPro['datecreated'])) ."
										</center>
										<center>
											<div class='row'>
												<div class='infobox infobox-blue' style='background-color: transparent !important;border: none !important;'>
													<div class='infobox-icon'>
														<i class='ace-icon fa fa-thumbs-o-up'></i>
													</div>
													<div class='infobox-data' style='margin-top: 5px;'>
														<span class='infobox-data-number'>Approved</span>
													</div>
												</div>
											</div>
											<div class='row'>
												<div class='col-md-12'>
													Approved by:
												</div>
												<div class='col-md-12 bolder'>
													". $rowPro['approved_by'] ."
												</div>
												<div class='col-md-12'>
													Approved date:
												</div>
												<div class='col-md-12 bolder'>
													". date('m/d/Y h:i A', strtotime($rowPro['date_approved'])) ."
												</div>
											</div>
											<div class='row'>
												<div class='col-md-12'>
													<button class='btn btn-default btn-sm btn-round' aria-expanded='false' onclick='fncSelectReportType(\"". $InquiryInfo['Inquiry_ID'] ."\", \"Proposal\", \"". $rowPro['proposalNum'] ."\");'><img src='assets/images/printer.png' style='width: 100%; height: auto;' /></button>
												</div>
											</div>
										</center>
									</div>
								</div>";
					}else{
						echo 	"<div class='col-md-4' style='margin-top: 10px;'>
									<div class='alert alert-". $alertColor ."'>
										<center style='cursor: pointer !important;' onclick='fncEditGlobalFormInquiry(\"". $isEdit ."\", \"". $InquiryInfo['Inquiry_ID'] ."\", \"". $InquiryInfo['Application_ID'] ."\", \"". $InquiryInfo['leadsID'] ."\", \"". $InquiryInfo['TradeID'] ."\", \"". $InquiryInfo['Company_ID'] ."\", \"". $rowPro['proposalNum'] ."\", \"\")'>
											<h4 class='header'>Proposal ". $rowPro['proposalNum'] ."</h4>
											". date('F d, Y', strtotime($rowPro['datecreated'])) ."
										</center>
										<center></br><a href='#' onclick='fncApproveProposal(\"". $InquiryInfo['Inquiry_ID'] ."\", \"". $rowPro['proposalNum'] ."\")' class='fa fa-thumbs-o-up bigger-160 blue' style='cursor: pointer !important;' title='Approve Proposal'></a></center>
									</div>
								</div>";
					}
				}
			}
		break;

		case 'fncSendAwardNotice2':
			$AppPref = mysql_fetch_array(mysql_query("SELECT appprefix FROM tblsys_setup;", $connection));
			$ApplicationID = createidno($AppPref['appprefix'], "tbltrans_appid", "app_id");
			$res = mysql_query("UPDATE tbltrans_inquiry SET Status = 'ForAwarding', mod_by = '". getusername() ."', date_modified = '". date('Y-m-d H:i:s') ."', Application_ID = '". $ApplicationID ."', applicationDate = '". date('Y-m-d') ."', date_applied = '". date('Y-m-d H:i:s') ."', app_by = '". getusername() ."', forFinal = '1' WHERE Inquiry_ID = '". $_POST['InquiryID'] ."';", $connection);
			// INSERT LOGS JONAS 9/30/2019 START
			$arrHeader = ["Inquiry ID", "Status"];
			$arrValue = [$_POST['InquiryID'], "For Awarding"];
			$tran_logs = create_logs_per_transaction("updated an application status to for awarding.", "Leasing Module", createXinfo("UPDATE", $arrHeader, "", $arrValue, "", "", ""), "" ,"UPDATE", $_POST['InquiryID']);
			// INSERT LOGS JONAS 9/30/2019 END
		break;

		case 'fncApproveAward':
			$chckrole = mysql_fetch_array(mysql_query("SELECT b.ulevel,b.role FROM tbluser a,tbltrans_hierarchy b WHERE a.groupaccess = b.role AND a.userid = '". $_SESSION['MMS-UserID'] ."' AND b.module = 'Awarding';", $connection));
			$getlevel =  mysql_fetch_array(mysql_query("SELECT a.alluserid, b.hierarchycode, c.ulevel, a.1st_app_aw, a.2nd_app_aw, a.datefrom, a.dateto FROM tbltrans_inquiry a,tbluser b, tbltrans_hierarchy c WHERE a.alluserid = b.userid AND c.hiecode = b.hierarchycode AND a.Inquiry_ID = '". $_POST['InquiryID'] ."' AND c.role = '". $chckrole['role'] ."' AND c.module = 'Awarding'", $connection));
			$setups = "";
			$check2nd = mysql_fetch_array(mysql_query("SELECT id FROM tbltrans_hierarchy WHERE hiecode = '". $getlevel['hierarchycode'] ."' AND module = 'Awarding' AND ulevel = 2"));
			$add = $getlevel['ulevel'] + 1;
			$checklast = mysql_fetch_array(mysql_query("SELECT id FROM tbltrans_hierarchy WHERE hiecode = '". $getlevel['hierarchycode'] ."' AND module = 'Awarding' AND ulevel = ". $add));
			if($getlevel['ulevel']=='1'){
				$updates = ", 1st_app_aw = '". $_SESSION['MMS-UserID'] ."', 1st_date_aw = NOW()  ";
			}elseif($getlevel['ulevel']=='2'){
				$updates = ", 2nd_app_aw = '". $_SESSION['MMS-UserID'] ."', 2nd_date_aw = NOW() ";
			}else{
				$setups = "Please set hierarchy of approvers.";
			}
			
			if(($getlevel['ulevel'] == '1' && $check2nd[0] == "") || ($getlevel['ulevel'] != '1'  &&  $getlevel['ulevel'] != '' && $checklast[0] == "")){
				$stat = $AwardStat;
				$appstat = "Approved";
				if($_POST['AwardStat'] == 'Approve'){
					$stat = ", Status = 'Awarded' ";
					$appstat = "Approved";
				}else{
					$stat = ", Status = 'Disapproved' ";
					$appstat = "Approved";
				}

			}else{
				if($_POST['AwardStat'] == 'Approve'){
					$stat = "";
					$appstat = "Confirmed";
				}else{
					$stat = ", Status = 'Disapproved' ";
					$appstat = "Disapproved";
				}
				
			}
			
			if($appstat=="Approved"){
				$updates2 = " ,date_approved = '". date('Y-m-d H:i:s') ."', appr_by = '". getusername() ."' ";
			}else{
				$updates2 = "";
			}

			if($setups==""){
				$res = mysql_query("UPDATE tbltrans_inquiry SET awardstatus = '".$appstat."'  ".$stat.$updates.$updates2. "  WHERE Inquiry_ID = '". $_POST['InquiryID'] ."';", $connection);
				$arrHeader = ["Inquiry ID", "Status"];
				$arrValue = [$_POST['InquiryID'], "Awarded"];
				if($appstat == 'Approved'){
					$approvedmsg = "approved the application status to awarded.";
				}elseif($appstat == 'Confirmed'){
					$approvedmsg = "confirmed the aplication to be awarded.";
					$getUnits = mysql_query("SELECT UnitID FROM tbltrans_inquiry_unit WHERE InquiryID = '". $_POST['InquiryID'] ."';", $connection);
					while($rowUnits = mysql_fetch_array($getUnits)){
						$resUpdateUnit = mysql_query("UPDATE tblref_unit SET Status = 'Awarded', TenantName = '". $resgetInquiry['Trade_Name'] ."', startDate = '". date('Y-m-d', strtotime($getlevel['datefrom'])) ."', endDate = '". date('Y-m-d', strtotime($getlevel['dateto'])) ."' WHERE unitid = '". $rowUnits['UnitID'] ."';", $connection);

						$resUpdateUnitLogs = mysql_query("UPDATE tblunit_statuslogs SET status = 'Awarded', tenantname = '". $resgetInquiry['Trade_Name'] ."', inquiryid = '". $_POST['InquiryID'] ."' WHERE unitid = '". $rowUnits['UnitID'] ."' AND xdate BETWEEN '". date('Y-m-d', strtotime($getlevel['datefrom'])) ."' AND '". date('Y-m-d', strtotime($getlevel['dateto'])) ."';", $connection);
					}
				}
				$tran_logs = create_logs_per_transaction($approvedmsg, "Leasing Module", createXinfo("UPDATE", $arrHeader, "", $arrValue, "", "", ""), "" ,"UPDATE", $_POST['InquiryID']);
				
			}else{
				echo $setups;
			}
		break;

		case 'fncApproveProposalGo':
			$chckrole = mysql_fetch_array(mysql_query("SELECT b.ulevel,b.role FROM tbluser a,tbltrans_hierarchy b WHERE a.groupaccess = b.role AND a.userid = '".$_SESSION['MMS-UserID']."' AND b.module = 'Proposal'   ",$connection));
			$getlevel =  mysql_fetch_array(mysql_query("SELECT a.userid,b.hierarchycode,c.ulevel,a.1st_app,a.2nd_app FROM tbltrans_proposal a,tbluser b, tbltrans_hierarchy c WHERE a.userid = b.userid AND c.hiecode = b.hierarchycode   AND a.inquiryID = '".$_POST['InquiryID']."' AND a.proposalNum = '".$_POST['isProposal']."' AND c.role = '".$chckrole['role']."' AND c.module = 'Proposal'",$connection));
			$setups = "";
			$check2nd = mysql_fetch_array(mysql_query("SELECT id FROM tbltrans_hierarchy WHERE hiecode = '".$getlevel['hierarchycode']."' AND module = 'Proposal' AND ulevel = 2"));
			$add = $getlevel['ulevel'] + 1;
			$checklast = mysql_fetch_array(mysql_query("SELECT id FROM tbltrans_hierarchy WHERE hiecode = '".$getlevel['hierarchycode']."' AND module = 'Proposal' AND ulevel = ".$add));
			if($getlevel['ulevel']=='1'){
				$updates = ",1st_app = '".$_SESSION['MMS-UserID']."',1st_date = NOW()  ";
			}elseif($getlevel['ulevel']=='2'){
				$updates = ",2nd_app = '".$_SESSION['MMS-UserID']."',2nd_date = NOW() ";
			}else{
				$setups = "Please set hierarchy of approvers.";
			}
			if(($getlevel['ulevel']=='1' && $check2nd[0]=="") || ($getlevel['ulevel']!='1'  &&  $getlevel['ulevel']!=''  && $checklast[0]=="")){
				$stat = 1;
			}else{
				$stat = 0;
			}

			if($stat==1){
				$updates2 = " ,date_approved = NOW(), approved_by = '".$_SESSION['MMS-UserID']."' ";
			}else{
				$updates2 = "";
			}

			if($setups==""){
				$resUpdateProposal = mysql_query("UPDATE tbltrans_proposal SET stats = ".$stat." ".$updates.$updates2. "   WHERE inquiryID = '". $_POST['InquiryID'] ."' AND proposalNum = '". $_POST['isProposal'] ."' ;", $connection);
				echo 1;
				$tran_logs = create_logs_per_transaction('approved a proposal', 'Leasing Module', '', '', 'UPDATE', $_POST['InquiryID']);
			}else{
				echo $setups;
			}

			
		break;


		case 'saveAwardsapprovalFilter':
			$chckrole = mysql_fetch_array(mysql_query("SELECT b.ulevel,b.role FROM tbluser a,tbltrans_hierarchy b WHERE a.groupaccess = b.role AND a.userid = '".$_SESSION['MMS-UserID']."' AND b.module = 'Awarding'   ",$connection));
			if($chckrole['ulevel']=='1'){
				$apps = "1st_app_aw";
			}elseif($chckrole['ulevel']=='2'){
				$apps = "2nd_app_aw";
			}

			$filterstatusprop = "";
			$statusprop =  explode("|", $_POST['checked3']);
			for($i=0;$i<=count($statusprop);$i++){
				if($statusprop[$i]=='Pending'){
					$xtatx .= "  a.awardstatus = 'Pending' OR";
				}elseif($statusprop[$i]=='Approved'){
					$xtatx .= "  a.awardstatus = 'Approved' OR";
				}elseif($statusprop[$i]=='Confirmed'){
					$xtatx .= "  a.awardstatus = 'Confirmed' OR";
				}elseif($statusprop[$i]=='Disapproved'){
					$xtatx .= "  a.awardstatus = 'Disapproved' OR";
				}
			}
			
			if($xtatx!=""){
				$xtatx = substr($xtatx, 0, -2);
				$filterstatusprop = " AND ( ".$xtatx." ) ";
			}

			$filterdates = "";
			if($_POST['Date1']!="" && $_POST['Date2']!=""){
				$filterdates = " AND a.applicationDate BETWEEN '".date('Y-m-d',strtotime($_POST['Date1']))."' AND  '".date('Y-m-d',strtotime($_POST['Date2']))."' ";
			}
			
			$filtersearch = "";
			if($_POST['searchy']!=""){
				$searchyname =  explode("|", $_POST['checked']);
				if($searchyname[0]!=""){
					$filtersearch = " AND  ".$searchyname[0]." LIKE '%".$_POST['searchy']."%' ";
					if($searchyname[1]!=""){
						$filtersearch = " AND ( Trade_Name LIKE '%".$_POST['searchy']."%' OR Company_Name LIKE '%".$_POST['searchy']."%') ";
					}
				}	
			}

			$page = $_POST["page"];
			$limit = ($page-1) * 20;
			$sql = "SELECT a.TradeID, a.Company_ID, a.Inquiry_ID, a.UnitID, a.Application_ID, a.Trade_Name, a.Company_Name, a.Industry, a.Company_ID, a.date_inquired, a.Status, a.req_status, a.UnitType, a.Mall_ID, a.month_adv, a.leadsID, a.S2Leasing, a.forFinal, a.inqSource, a.inqPrcssOwnr, a.1st_app_aw, a.1st_date_aw, a.2nd_app_aw, a.2nd_date_aw, a.awardstatus, a.ActiveProposal FROM tbltrans_inquiry a,tbluser b,tbltrans_hierarchy c WHERE a.alluserid = b.userid AND b.hierarchycode = c.hiecode     ". getMallAccess("Mall_ID", "AND") ." AND c.role = '".$chckrole['role']."' AND c.module = 'Awarding' AND c.ulevel = '".$chckrole['ulevel']."' ".$filterstatusprop." ".$filterdates." ".$filtersearch."    ORDER BY a.Inquiry_ID DESC  ;";
		
			$result = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($result)){
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
				}

				if($row["req_status"] == "Complete"){
					$reqstat = "<h6 style='color:green;margin-top:3px;'><i class='fa fa-check bigger-110'></i>&nbsp;&nbsp;Complete</h6>";
				}else if($row["req_status"] == "Incomplete"){
					$reqstat = "<h6 style='color:orange;margin-top:3px;'><i class='fa fa-remove bigger-110'></i>&nbsp;&nbsp;Incomplete</h6>";
				}

				$Source = mysql_fetch_array(mysql_query("SELECT source_desc FROM tblref_source WHERE source_code = '". $row['inqSource'] ."';", $connection));
                $ProcessOwner = mysql_fetch_array(mysql_query("SELECT deptDesc FROM tblref_process_owner WHERE deptCode = '". $row['inqPrcssOwnr'] ."';", $connection));
                $PrimaryContact = mysql_fetch_array(mysql_query("SELECT ContactID, FullName FROM tbltrans_trade_contact_person WHERE TradeID = '". $row['TradeID'] ."';", $connection));
                $PrimaryContact_Email = mysql_fetch_array(mysql_query("SELECT content FROM tbltrans_trade_contact_person_list WHERE ContactID = '". $PrimaryContact['ContactID'] ."' AND type = 'email';", $connection));
                $PrimaryContact_Mobile = mysql_fetch_array(mysql_query("SELECT content FROM tbltrans_trade_contact_person_list WHERE ContactID = '". $PrimaryContact['ContactID'] ."' AND type = 'mobile';", $connection));
                $PrimaryContact_Telephone = mysql_fetch_array(mysql_query("SELECT content FROM tbltrans_trade_contact_person_list WHERE ContactID = '". $PrimaryContact['ContactID'] ."' AND type = 'telephone';", $connection));
                $getProposalStatus = mysql_fetch_array(mysql_query("SELECT stats, proposalNum FROM tbltrans_proposal WHERE inquiryID = '". $row['Inquiry_ID'] ."' AND proposalNum = '". $row['ActiveProposal'] ."';", $connection));

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
               
                $userapproved = mysql_fetch_array(mysql_query("SELECT CONCAT(lastname,', ',firstname) as fullname FROM tbluser WHERE userid = '".$row['1st_app_aw']."' "));
                if($row["awardstatus"]=='' || $row['awardstatus']=='Pending'){
                	$appstatus = "<span class='label label-lg label-pink arrowed-in-right arrowed' style='z-index: 0;'>Pending</span>";
                }elseif($row["awardstatus"]=='Confirmed'){
                	$appstatus =  "<span class='label label-lg label-warning arrowed-in-right arrowed' style='z-index: 0;'>Confirmed</span>";
                }elseif($row["awardstatus"]=='Disapprove' || $row["awardstatus"]=='Disapproved'){
                	$appstatus =  "<span class='label label-lg label-danger arrowed-in-right arrowed' style='z-index: 0;'>Disapproved</span>";
                }elseif($row["awardstatus"]=='Approved'){
                	$appstatus =  "<span class='label label-lg label-success arrowed-in-right arrowed' style='z-index: 0;'>Approved</span>";
                }

                if($row['1st_app_aw']!=""){
                	$userapproved1 = mysql_fetch_array(mysql_query("SELECT CONCAT(lastname,', ',firstname) as fullname FROM tbluser WHERE userid = '".$row['1st_app_aw']."' "));
                }else{
                	$userapproved1[0] = "";
                }
                if($row['2nd_app_aw']!=""){
                	$userapproved2 = mysql_fetch_array(mysql_query("SELECT CONCAT(lastname,', ',firstname) as fullname FROM tbluser WHERE userid = '".$row['2nd_app_aw']."' "));
                }else{
                	$userapproved2[0] = "";
                }

                $checkifhasevent = mysql_fetch_array(mysql_query("SELECT id FROM event_header WHERE inquiryid = '".$row['Inquiry_ID']."' ",$connection));
                if($checkifhasevent[0]==""){
                    $events = 0;
                }else{
                    $events = 1;
                }
				echo "	<tr>
							<td style='vertical-align: middle;'>". $row['Inquiry_ID'] ."</td>
							<td style='vertical-align: middle;'>". date('m/d/Y', strtotime($row["date_inquired"])) ."</td>
							<td style='vertical-align: middle;' class='batayan'>". $UnitInfo ."</td>
							<td style='vertical-align: middle;'>". $row["Trade_Name"] ."</td>
							<td style='vertical-align: middle;'>". $row["Company_Name"] ."</td>
		                    <td style='vertical-align: middle;'>". $Source['source_desc'] ."</td>
		                    <td style='vertical-align: middle;'>". $ProcessOwner['deptDesc'] ."</td>
		                    <td style='vertical-align: middle;'>".$userapproved1[0]."</td>
		                    <td style='vertical-align: middle;'>".$row['1st_date_aw']."</td>
		                    <td style='vertical-align: middle;'>".$userapproved2[0]."</td>
		                    <td style='vertical-align: middle;'>".$row['2nd_date_aw']."</td>
							<td style='vertical-align: middle;'>". $stat ."</td>
							<td style='vertical-align: middle;'>". $appstatus ."</td>
							<td style='vertical-align: middle;'><div class='btn-group'>";
																		
									
									if($row['forFinal'] == 0 && $row['Status'] != 'Cancelled'){
										echo "<button class='btn btn-sm btn-info  isadmin select-editapplication btn-round' onclick='fncEditGlobalFormInquiry(\"0\", \"". $row['Inquiry_ID'] ."\", \"". $row['Application_ID'] ."\", \"". $row['leadsID'] ."\", \"". $row['TradeID'] ."\", \"". $row['Company_ID'] ."\", \"". $getProposalStatus['proposalNum'] ."\", \"". $getProposalStatus['stats'] ."\")' title='Update Application' style='margin: 2px;'><img src='assets/images/edit.png' style='width: 100%; height: auto;' /></button>";
									}

									if($getProposalStatus['stats'] == '1' && ($row['Status'] == 'Pending' || $row['Status'] == 'ForAwarding') && $row[$apps]!=$_SESSION['MMS-UserID']){
										if(($apps=='1st_app' && $row['1st_app_aw']=="") || ($apps=='2nd_app' && $row['1st_app_aw']!="" && $row['2nd_app_aw']=="")) {
											echo "<button class='btn btn-sm btn-yellow  isadmin select-editapplication btn-round' onclick='fncSendAwardNotice(\"". $row["Inquiry_ID"] ."\", \"". $row['Status'] ."\");' title='Award Tenant' style='margin: 2px;'><img src='assets/images/award.png' style='width: 100%; height: auto;' /></button>";
										}
										
									}

									

									if($row['Status'] != 'Cancelled'){
										echo "<button class='btn btn-sm btn-purple  isadmin select-editapplication btn-round' onclick='fncBrowseProposalList(\"". $row["Inquiry_ID"] ."\", \"". $row['Company_ID'] ."\", \"". $row['TradeID'] ."\", \"". $row['forFinal'] ."\");' title='Lease Proposal' style='margin: 2px;'><img src='assets/images/resume.png' style='width: 100%; height: auto;' /></button>";
									}else{
										echo "<button class='btn btn-sm btn-purple  isadmin select-editapplication btn-round' onclick='fncBrowseProposalList(\"". $row["Inquiry_ID"] ."\", \"". $row['Company_ID'] ."\", \"". $row['TradeID'] ."\", \"1\");' title='Lease Proposal' style='margin: 2px;'><img src='assets/images/resume.png' style='width: 100%; height: auto;' /></button>";
									}

									if($events==1){
		                                echo"<button class='btn btn-sm btn-gray  isadmin select-viewevents btn-round' onclick='frmeventformop(\"". $row['Inquiry_ID'] ."\",".$events.",\"".$row['Company_ID']."\",1)' title='View Event' style='margin: 2px;'><img src='assets/images/ticket.png' style='width: 100%; height: auto;' /></button>";
		                            }else{
		                               
		                            }

										
									echo"</div>
							</td>
						</tr>";
			}			
		break;

		case 'fncReassessAward2':
			$res = mysql_query("UPDATE tbltrans_inquiry SET Status = 'Pending', mod_by = '', date_modified = NULL, Application_ID = '', applicationDate = NULL, date_applied = NULL, app_by = '', forFinal = '0', awardstatus = '',1st_app_aw = '',1st_date_aw = NULL,2nd_app_aw = '', 2nd_date_aw = NULL WHERE Inquiry_ID = '". $_POST['InquiryID'] ."';", $connection);
			$RemarksID = createidno("REM", "tbltrans_remarks", "remID");
			$remarksadd = mysql_query("INSERT INTO tbltrans_remarks SET remID = '". $RemarksID ."',inqID = '". $_POST['InquiryID'] ."',xremarks = '". mysql_real_escape_string($_POST['txtreassessremarks']) ."', UserID = '". $_SESSION['MMS-UserID'] ."' ") or die(mysql_error());

			$getInquiryInfo = mysql_fetch_array(mysql_query("SELECT datefrom, dateto FROM tbltrans_inquiry WHERE Inquiry_ID = '". $_POST['InquiryID'] ."';", $connection));
			$getUnitList = mysql_query("SELECT UnitID FROM tbltrans_inquiry_unit WHERE InquiryID = '". $_POST['InquiryID'] ."';", $connection);
			while($rowUnitList = mysql_fetch_array($getUnitList)){
				$resUpdateLogs = mysql_query("UPDATE tblunit_statuslogs SET status = 'Vacant' WHERE unitid = '". $rowUnitList['UnitID'] ."';", $connection);
			}
				
			$arrHeader = ["Inquiry ID", "Status"];
			$arrValue = [$_POST['InquiryID'], "For Awarding"];
			$tran_logs = create_logs_per_transaction("set this application to reassess. Remarks(".$_POST['txtreassessremarks'].") ", "Leasing Module", createXinfo("UPDATE", $arrHeader, "", $arrValue, "", "", ""), "" ,"UPDATE", $_POST['InquiryID']);
		break;
	}
?>