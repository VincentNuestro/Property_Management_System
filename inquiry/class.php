<?php
	session_start();
	include "../connect.php";
	switch ($_POST['form']) {
		case 'loadtblSUbLeadsINQ':
			$getFilters = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'LInquiry' AND userid = '". $_SESSION['MMS-UserID'] ."';", $connection));
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
					$StatusVal = "((Status = 'Pending' AND Application_ID != '') OR (Status = 'ForAwarding' AND Application_ID != ''))"; 
				}else if($Status[$a] == "Awarded"){ 
					$StatusVal = "(Status = 'Awarded') "; 
				}else if($Status[$a] == "Confirmed"){ 
					$StatusVal = "(Status = 'Confirmed') "; 
				}else if($Status[$a] == "Occupied"){ 
					$StatusVal = "(Status = 'Occupied') "; 
				}else if($Status[$a] == "Cancelled"){ 
					$StatusVal = "(Status = 'Cancelled') "; 
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
			
		    $getProcessOwner = mysql_fetch_array(mysql_query("SELECT ProcessOwner FROM tbluser WHERE userid = '". $_SESSION['MMS-UserID'] ."';", $connection));
		    if($getProcessOwner['ProcessOwner'] == '' || $getProcessOwner['ProcessOwner'] == null){
		    	$isProcessOwner = "";
		    }else{
		    	$isProcessOwner = " AND inqPrcssOwnr = '". $getProcessOwner['ProcessOwner'] ."'";
		    }
			$checkifhasevent = mysql_fetch_array(mysql_query("SELECT id FROM event_header WHERE inquiryid = '".$row['Inquiry_ID']."' ",$connection));
            if($checkifhasevent[0]==""){
            	$events = 0;
            }else{
            	$events = 1;
            }

			$page = $_POST["page"];
            $limit = ($page-1) * 20;
            $res = mysql_query("SELECT Inquiry_ID, Application_ID, Trade_Name, Company_Name, Industry, Address, TradeID, Company_ID, Status, S2Leasing, leadsID, date_inquired, ClassID, DepartmentID, CategoryID, inqSource, inqPrcssOwnr FROM tbltrans_inquiry WHERE ". $StatFilter ." ". $SearchFilter ." ". $UnitStatusFilter ." ". $DateFilter ." ". $isProcessOwner ." ". getMallAccess("Mall_ID", "AND") ." AND isDirect = '0' AND isAmendment = '0' GROUP BY date_inquired ORDER BY ". $_POST['InquirySortBy'] ." ". $_POST['InquirySortType'] ." LIMIT ". $limit .",20;", $connection);
            while($row = mysql_fetch_array($res)){
                if($row["Application_ID"] == ""){
                    $function = "leaseapplication(\"". $row["Inquiry_ID"] ."\")";
                    $title = "Create Leasing Application";
                }else{
                    $function = "loadapplication(\"". $row["Inquiry_ID"] ."\", \"". $row["Application_ID"] ."\");loadtelno_application(\"". $row["Inquiry_ID"] ."\", \"". $row["Application_ID"] ."\");loadaffiliate_application(\"". $row["Inquiry_ID"] ."\", \"". $row["Application_ID"] ."\");";
                    $title = "Edit Leasing Application";
                }

                if($row["Status"] == "Pending" && $row["S2Leasing"] == "0"){
                    $stat = "<span class='label label-lg label-inverse arrowed-in-right arrowed' style='z-index: 0;'>Inquired</span>";
                }else if($row["Status"] == "Pending" && $row["S2Leasing"] == "1"){
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

                $Source = mysql_fetch_array(mysql_query("SELECT source_desc FROM tblref_source WHERE source_code = '". $row['inqSource'] ."';", $connection));
                $ProcessOwner = mysql_fetch_array(mysql_query("SELECT deptDesc FROM tblref_process_owner WHERE deptCode = '". $row['inqPrcssOwnr'] ."';", $connection));
                $PrimaryContact = mysql_fetch_array(mysql_query("SELECT ContactID, FullName FROM tbltrans_trade_contact_person WHERE TradeID = '". $row['TradeID'] ."';", $connection));
                $PrimaryContact_Email = mysql_fetch_array(mysql_query("SELECT content FROM tbltrans_trade_contact_person_list WHERE ContactID = '". $PrimaryContact['ContactID'] ."' AND type = 'email';", $connection));
                $PrimaryContact_Mobile = mysql_fetch_array(mysql_query("SELECT content FROM tbltrans_trade_contact_person_list WHERE ContactID = '". $PrimaryContact['ContactID'] ."' AND type = 'mobile';", $connection));
                $PrimaryContact_Telephone = mysql_fetch_array(mysql_query("SELECT content FROM tbltrans_trade_contact_person_list WHERE ContactID = '". $PrimaryContact['ContactID'] ."' AND type = 'telephone';", $connection));
                $checkifhasevent = mysql_fetch_array(mysql_query("SELECT id FROM event_header WHERE inquiryid = '".$row['Inquiry_ID']."' ",$connection));
                if($checkifhasevent[0]==""){
                	$events = 0;
                }else{
                	$events = 1;
                }
                if( ($events ==1)  && ($row['Status'] == 'Pending' || $row['Status'] == 'ForAwarding')){
                	$isdisabled = 0;
                }else{
                	$isdisabled = 1;
                }
                echo 	"
		                <tr id='". $row["Inquiry_ID"] ."'>
		                    <td style='vertical-align: middle;'>". date('m/d/Y', strtotime($row['date_inquired'])) ."</td>
		                    <td style='vertical-align: middle;'>". $row["Trade_Name"] ."</td>
		                    <td style='vertical-align: middle;'>". $row["Company_Name"] ."</td>
		                    <td style='vertical-align: middle;'>". $PrimaryContact['FullName'] ."</td>
		                    <td style='vertical-align: middle;'>". $PrimaryContact_Telephone['content'] ."</td>
		                    <td style='vertical-align: middle;'>". $PrimaryContact_Mobile['content'] ."</td>
		                    <td style='vertical-align: middle;'>". $PrimaryContact_Email['content'] ."</td>
		                    <td style='vertical-align: middle;'>". $Source['source_desc'] ."</td>
		                    <td style='vertical-align: middle;'>". $ProcessOwner['deptDesc'] ."</td>
		                    <td style='z-index: 0; vertical-align: middle;'>". $stat ."</td>
		                    <td style='z-index: 0; vertical-align: middle;'>";
		                            if($row["S2Leasing"] == "0"){
		                                echo"<button class='btn btn-sm btn-info hide isadmin select-editinquiry btn-round' onclick='fncEditGlobalFormInquiry(\"0\", \"". $row['Inquiry_ID'] ."\", \"". $row['Application_ID'] ."\", \"". $row['leadsID'] ."\", \"". $row['TradeID'] ."\", \"". $row['Company_ID'] ."\", \"0\", \"0\",\"".$events."\")' title='Edit Inquiry' style='margin: 2px;'><img src='assets/images/edit.png' style='width: 100%; height: auto;' /></button>";
		                            }
		                            // echo"<button class='btn btn-sm btn-gray hide isadmin select-printinquiry btn-round' onclick='loadprintinfo(\"". $row["TradeID"] ."\", \"". $row["Company_ID"] ."\",\"". $row["Inquiry_ID"] ."\",\"". $row["UnitID"] ."\", \"".$row["Mall_ID"]."\")' title='Print Inquiry'>
		                                // <img src='assets/images/printer.png' style='width: 100%; height: auto;' />
		                                // </button>";
		                            echo"<button class='btn btn-sm btn-gray hide isadmin select-viewinquiry btn-round' onclick='fncEditGlobalFormInquiry(\"1\", \"". $row['Inquiry_ID'] ."\", \"". $row['Application_ID'] ."\", \"". $row['leadsID'] ."\", \"". $row['TradeID'] ."\", \"". $row['Company_ID'] ."\", \"0\", \"0\")' title='View Inquiry' style='margin: 2px;'><img src='assets/images/view.png' style='width: 100%; height: auto;' /></button>";
		                            echo"<button class='btn btn-sm btn-gray hide isadmin select-viewlogsinquiry btn-round' onclick='ViewTrasactionLogs(\"". $row["Inquiry_ID"] ."\", \"". $row['inqSource'] ."\", \"". $row['inqPrcssOwnr'] ."\")' title='View Logs' style='margin: 2px;'><img src='assets/images/clock.png' style='width: 100%; height: auto;' /></button>";

		                            if($events==1){
		                            	echo"<button class='btn btn-sm btn-gray hide  isadmin  select-viewevents btn-round' onclick='frmeventformop(\"". $row['Inquiry_ID'] ."\",".$events.",\"".$row['Company_ID']."\",".$isdisabled.")' title='View Event' style='margin: 2px;'><img src='assets/images/ticket.png' style='width: 100%; height: auto;' /></button>";
		                            }
                    echo 	"</td>
		                </tr>
                		";
            }
		break;

		case 'loadtblSUbLeadsINQEntries':
			$getFilters = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'LInquiry' AND userid = '". $_SESSION['MMS-UserID'] ."';", $connection));
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
					$StatusVal = "((Status = 'Pending' AND Application_ID != '') OR (Status = 'ForAwarding' AND Application_ID != ''))"; 
				}else if($Status[$a] == "Awarded"){ 
					$StatusVal = "(Status = 'Awarded') "; 
				}else if($Status[$a] == "Confirmed"){ 
					$StatusVal = "(Status = 'Confirmed') "; 
				}else if($Status[$a] == "Occupied"){ 
					$StatusVal = "(Status = 'Occupied') "; 
				}else if($Status[$a] == "Cancelled"){ 
					$StatusVal = "(Status = 'Cancelled') "; 
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
    		$limit = ($page-1) * 20;
  			$rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(id)  FROM tbltrans_inquiry WHERE ". $StatFilter ." ". $SearchFilter ." ". $UnitStatusFilter ." ". $DateFilter ." ". $isProcessOwner ." ". getMallAccess("Mall_ID", "AND") ." AND isDirect = '0' AND isAmendment = '0';", $connection));
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

		case "loadtblSUbLeadsINQPagination":
			$getFilters = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'LInquiry' AND userid = '". $_SESSION['MMS-UserID'] ."';", $connection));
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
					$StatusVal = "((Status = 'Pending' AND Application_ID != '') OR (Status = 'ForAwarding' AND Application_ID != ''))"; 
				}else if($Status[$a] == "Awarded"){ 
					$StatusVal = "(Status = 'Awarded') "; 
				}else if($Status[$a] == "Confirmed"){ 
					$StatusVal = "(Status = 'Confirmed') "; 
				}else if($Status[$a] == "Occupied"){ 
					$StatusVal = "(Status = 'Occupied') "; 
				}else if($Status[$a] == "Cancelled"){ 
					$StatusVal = "(Status = 'Cancelled') "; 
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
			   	echo "<li style='width:50px !important;' onclick='SubLeadsInqPageFunc(1)'><< First</li>";
			   	$prevpage = $page - 1;
			   	echo "<li style='width:70px !important;' onclick='SubLeadsInqPageFunc(". $prevpage .")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   	if (($x > 0) && ($x <= $totalpages)){
			      	if ($x == $page){
		   				echo "<li id='pgSubLeadsInqPageFunc" . $x . "' class='pgnumSubLeadsInqPageFunc active' onclick='SubLeadsInqPageFunc(" . $x . ",". $x .")'>" . $x . "</li>"; 
		   			}else{
						echo "<li id='pgSubLeadsInqPageFunc" . $x . "' class='pgnumSubLeadsInqPageFunc' onclick='SubLeadsInqPageFunc(" . $x . ",". $x .")'>" . $x . "</li>"; }
		      		}
		    }
		    if($page < ($totalpages - $range)){ 
		    	echo "<li>...</li>"; 
		    }
		    if ($page != $totalpages && $rowCount[0] != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='SubLeadsInqPageFunc(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='SubLeadsInqPageFunc(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;
	}
?>