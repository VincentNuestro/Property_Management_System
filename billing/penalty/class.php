<?php
	session_start();
    include('../../connect.php');
    switch ($_POST['form']){
    	case 'displaylistofpenalty':
		    $getFilters = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter FROM tblref_filters WHERE module = 'Penalty' AND userid = '". $_SESSION['MMS-UserID'] ."';", $connection));
		    $Search = explode("|", $getFilters["checked_value"]);
		    $Date = explode("|", $getFilters["datefilter"]);

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
		    	$DateFilter = "AND (a.xdate BETWEEN '". date("Y-m-d", strtotime($Date[0])) ."' AND '". date("Y-m-d", strtotime($Date[1])) ."')";
		    }else{
		    	$DateFilter = "";
		    }

    		$page = $_POST['page'];
			$limit = ($page-1) * 20;

    		$res = mysql_query("SELECT a.tenantid, a.reference, a.xcode, a.amount, a.vatamount, a.balance, a.xdate, b.tradename, a.id, a.isPosted, a.description, a.totalamount FROM tbltransaction AS a INNER JOIN tbltrans_tenants AS b ON a.tenantid = b.tenantid WHERE a.isPenalty = '1' ". $SearchFilter ." ". $DateFilter ." ". getMallAccess("b.mallID", "AND") ." ORDER BY a.xdatetime DESC LIMIT ".$limit.",20;", $connection);
    		while($row = mysql_fetch_array($res)){
    			if($row['isPosted'] == 1){
    				$DeleteButton = "disabled";
    			}else{
    				$DeleteButton = "";
    			}
    			echo 	"<tr>
							<td>". date('m/d/Y', strtotime($row['xdate'])) ."</td>
							<td>". $row['tenantid'] ."</td>
			   				<td>". $row['tradename'] ."</td>
			   				<td>". $row['xcode'] ."</td>
			   				<td>". $row['description'] ."</td>
			   				<td style='text-align: right;'>". number_format($row['amount'], "2", ".", ",") ."</td>
			   				<td style='text-align: right;'>". number_format($row['vatamount'], "2", ".", ",") ."</td>
			   				<td style='text-align: right;'>". number_format($row['balance'], "2", ".", ",") ."</td>
			   				<td style='text-align: right;'>". number_format($row['totalamount'], "2", ".", ",") ."</td>
			   				<td class='center' style='z-index: 0;'><button ". $DeleteButton ." class='btn btn-sm btn-danger hide isadmin select-deletepenalty btn-round' onclick='fncDeletePenalty(\"" . $row['id'] . "\");' title='Delete penalty' style='z-index: 0;margin: 2px;'><img src='assets/images/remove.png' style='width: 100%; height: auto;'></button></td>
						</tr>";
    		}
    	break;

    	case 'loadentriespenalties':
		    $getFilters = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter FROM tblref_filters WHERE module = 'Penalty' AND userid = '". $_SESSION['MMS-UserID'] ."';", $connection));
		    $Search = explode("|", $getFilters["checked_value"]);
		    $Date = explode("|", $getFilters["datefilter"]);

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
		    	$DateFilter = "AND (a.xdate BETWEEN '". date("Y-m-d", strtotime($Date[0])) ."' AND '". date("Y-m-d", strtotime($Date[1])) ."')";
		    }else{
		    	$DateFilter = "";
		    }

    		$page = $_POST['page'];
			$limit = ($page-1) * 20;

            if($_POST["page"] == ""){
                $page = 1;
            }else{
                $page = $_POST["page"];
            }

            $limit = ($page-1) * 20;
            $rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(a.tenantid) FROM tbltransaction AS a INNER JOIN tbltrans_tenants AS b ON a.tenantid = b.tenantid WHERE a.isPenalty = '1' ". $SearchFilter ." ". $DateFilter ." ". getMallAccess("b.mallID", "AND") .";", $connection));
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

		case "loadpagelistofpenalties":
		    $getFilters = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter FROM tblref_filters WHERE module = 'Penalty' AND userid = '". $_SESSION['MMS-UserID'] ."';", $connection));
		    $Search = explode("|", $getFilters["checked_value"]);
		    $Date = explode("|", $getFilters["datefilter"]);

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
		    	$DateFilter = "AND (a.xdate BETWEEN '". date("Y-m-d", strtotime($Date[0])) ."' AND '". date("Y-m-d", strtotime($Date[1])) ."')";
		    }else{
		    	$DateFilter = "";
		    }

		    $page = $_POST["page"];
			$rowCount = mysql_fetch_row(mysql_query("SELECT COUNT(a.tenantid) FROM tbltransaction AS a INNER JOIN tbltrans_tenants AS b ON a.tenantid = b.tenantid WHERE a.isPenalty = '1' ". $SearchFilter ." ". $DateFilter ." ". getMallAccess("b.mallID", "AND") .";", $connection));
			$rowsperpage = 20;
			$range = 3;
			$totalpages = ceil($rowCount[0] / $rowsperpage);
			$prevpage;
			$nextpage;
			// if not on page 1, don't show back links
			if($page > 1 ){
			   	echo "<li style='width:50px !important;' onclick='paginationpenalties(1)'><< First</li>";
			   	$prevpage = $page - 1;
			   	echo "<li style='width:70px !important;' onclick='paginationpenalties(". $prevpage .")'>< Previous</li>";
			}

			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if(($x > 0) && ($x <= $totalpages)){
    			    if($x == $page){
                        echo "<li id='pgpenalties" . $x . "' class='pgnumpenalties active' onclick='paginationpenalties(" . $x . ",". $x .")'>" . $x . "</li>";
                    }else{
    			        echo "<li id='pgpenalties" . $x . "' class='pgnumppenalties' onclick='paginationpenalties(" . $x . ",". $x .")'>" . $x . "</li>";
                    }
		       }
		    }
		    if($page < ($totalpages - $range)){
                echo "<li>...</li>";
            }

		    if ($page != $totalpages && $rowCount[0] != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='paginationpenalties(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='paginationpenalties(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'fncDeletePenalty':
			$PenaltyInfo = mysql_fetch_array(mysql_query("SELECT tenantid, amount, balance, xdate, description FROM tbltransaction WHERE id = '". $_POST['id'] ."'", $connection));
			if($PenaltyInfo['tenantid'] != ""){
				$Log .= "Tenant ID : ". $PenaltyInfo['tenantid'] ."|";
			}
			if($PenaltyInfo['PenaltyCode'] != ""){
				$Log .= "Penalty Code : ". $PenaltyInfo['PenaltyCode'] ."|";
			}
			if($PenaltyInfo['tenantid'] != ""){
				$Log .= "Penalty Description : ". $PenaltyInfo['description'] ."|";
			}
			if($PenaltyInfo['xdate'] != ""){
				$Log .= "Penalty Date : ". date('m/d/Y', strtotime($PenaltyInfo['xdate'])) ."|";
			}
			if($PenaltyInfo['amount'] != ""){
				$Log .= "Penalty Amount : ". number_format($PenaltyInfo['amount'], "2", ".", ",") ."|";
			}
			if($PenaltyInfo['balance'] != ""){
				$Log .= "Penalty Balance : ". number_format($PenaltyInfo['balance'], "2", ".", ",") ."|";
			}
			if($Log != ""){
				$tran_logs = create_logs_per_transaction("deleted a penalty.", "Billing Module", $Log, "", "DELETE", $PenaltyInfo['tenantid']);
			}
			$res = mysql_query("DELETE FROM tbltransaction WHERE id = '". $_POST['id'] ."';", $connection);
			if($res == true){
				echo 1;
			}else{
				echo 2;
			}
		break;

		case 'fncSelectPenalty':
			$mgaMeron = "";
			$arr = explode("|", $_POST['PenaltyList']);
			for ($i=0; $i <= count($arr)-2; $i++) { 
				$mgaMeron .= "'" . $arr[$i] . "'" . ",";
			}

			if($_POST['PenaltyList'] != ""){
				$FilterPenalty = "AND PenaltyCode NOT IN (". substr(trim($mgaMeron), 0, -1) .")";
			}else{
				$FilterPenalty = "";
			}
			$res = mysql_query("SELECT PenaltyCode, PenaltyDesc, Amount FROM tblref_penalty WHERE (PenaltyCode LIKE '%". $_POST['key'] ."%' OR PenaltyDesc LIKE '%". $_POST['key'] ."%') ". $FilterPenalty .";", $connection);
			while($row = mysql_fetch_array($res)){
				echo 	"<tr id='". $row['PenaltyCode'] ."' onclick='fncSelectedPenalty(\"". $row['PenaltyCode'] ."\", \"". $row['PenaltyDesc'] ."\", \"". number_format($row['Amount'], "2", ".", ",") ."\");'>
							<td>". $row['PenaltyCode'] ."</td>
							<td>". $row['PenaltyDesc'] ."</td>
							<td style='text-align: right;'>". number_format($row['Amount'], "2", ".", ",") ."</td>
						</tr>";
			}
		break;

		case 'fncgetSelectedPenalties':
			$InquiryID = mysql_fetch_array(mysql_query("SELECT inqID, mallID, ActiveProposal FROM tbltrans_tenants WHERE TenantID = '". $_POST['TenantID'] ."';", $connection));

			$ProposalInfo = mysql_fetch_array(mysql_query("SELECT monthlyDues, escalation_rate, year_start, year_basis, charges_list, vattype, vatpercent, isRent FROM tbltrans_proposal WHERE inquiryID = '". $InquiryID['inqID'] ."' AND proposalNum = '". $InquiryID['ActiveProposal'] ."';", $connection));

			$getSetup = explode("|", getrentvattype($InquiryID['mallID']));
			$isVatable = $getSetup[1];
			$isInclusive = $getSetup[2];
			$VATPercent = floatval($getSetup[0]) / 100;

			if($ProposalInfo['isRent'] == 0){
				if($isVatable == "yes"){
	                if($isInclusive == "inc"){ //VAT IS INCLUSIVE
	                    $VATAmount = ( floatval($_POST['Rate']) / 1.12 ) * $VATPercent;
	                    $RentLessVAT = floatval($_POST['Rate']) - $VATAmount;
	                    $Amount = $RentLessVAT;
						$VAT = $VATAmount;
	                    $TotalAmount = $VAT + $Amount;
	                }else{ //VAT IS EXCLUSIVE
	                    $VATAmount = floatval($_POST['Rate']) * $VATPercent;
	                    $RentPlusVAT = floatval($_POST['Rate']);
	                    $Amount = floatval($_POST['Rate']);
	                    $VAT = $VATAmount;
	                    $TotalAmount = floatval($_POST['Rate']) + $VATAmount;
	                }
	            }else{
	            	$Amount = $_POST['Rate'];
	                $VAT = "0.00";
	                $TotalAmount = floatval($_POST['Rate']);
	            }
            }else{
                $Amount = $_POST['Rate'];
                $VAT = "0.00";
                $TotalAmount = floatval($_POST['Rate']);
            }
			echo 	"<tr id='". $_POST['PenaltyCode'] ."' class='unselected'>
						<td>". $_POST['PenaltyCode'] ."</td>
						<td>". $_POST['Description'] ."</td>
						<td>". $_POST['Reference'] ."</td>
						<td style='text-align: right;'>". number_format($Amount, "2", ".", ",") ."</td>
						<td style='text-align: right;'>". number_format($VAT, "2", ".", ",") ."</td>
						<td style='text-align: right;'>". number_format($TotalAmount, "2", ".", ",") ."</td>
					</tr>";
		break;

		case 'PostPPCharges':
			$Machine_No = mysql_fetch_array(mysql_query("SELECT Machine_No FROM tblsys_setup;", $connection));
			$MerchantCode = mysql_fetch_array(mysql_query("SELECT merchant_code FROM tbltrans_tenants WHERE TenantID = '". $_POST['TenantID'] ."';", $connection));
			$arr = explode("@", $_POST['PenaltyList']);
			$count = 0;
			$PenaltyList = "";
			for($i = 0; $i <= COUNT($arr)-2 ; $i++){
				$arr2 = explode("|", $arr[$i]);
				$res = mysql_query("INSERT INTO tbltransaction SET tenantid = '". $_POST['TenantID'] ."', xcode = '". $arr2[0] ."', description = '". $arr2[1] ."', amount = '". floatval($arr2[3]) ."', vatamount = '". floatval($arr2[4]) ."', qty = '1', balance = '". floatval($arr2[3] + $arr2[4]) ."', xdate = '". date('Y-m-d', strtotime($_POST['xDate'])) ."', reference = '". $arr2[2] ."', totalamount = '". floatval($arr2[3] + $arr2[4]) ."', xdescription = '". $arr2[1] ."', userid = '". $_SESSION['MMS-UserID'] ."', Machine_No = '". $Machine_No['Machine_No'] ."', merchant_code = '". $MerchantCode['merchant_code'] ."', isPenalty = '1';", $connection);
				if($res == true){
					$count++;
                    $PenaltyList .=  "<br/>&emsp;&emsp;&emsp;&emsp;<span class='fa fa-angle-double-right blue'></span>&nbsp;". $arr2[0] . "<br/>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Description&nbsp;<span class='fa fa-angle-right blue'></span>&nbsp;". $arr2[1] ."<br/>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Reference&nbsp;<span class='fa fa-angle-right blue'></span>&nbsp;". $arr3[1] ."<br/>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Resolution&nbsp;<span class='fa fa-angle-right blue'></span>&nbsp;<br/>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Amount&nbsp;<span class='fa fa-angle-right blue'></span>&nbsp;". number_format($arr2[3], "2", ".", ",") ."<br/>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Vat Amount&nbsp;<span class='fa fa-angle-right blue'></span>&nbsp;". number_format($arr2[4], "2", ".", ",") ."<br/>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Total Amount&nbsp;<span class='fa fa-angle-right blue'></span>&nbsp;". number_format($arr2[3] + $arr2[4], "2", ".", ",");
				}
			}
		 	$arrHeader = ["Tenant ID", "Date", "Time", "Penalty"];
            $arrValue = [$_POST['TenantID'], date('m/d/Y', strtotime($_POST['xDate'])), date('H:i:s'), $PenaltyList];
            $tran_logs = create_logs_per_transaction("posted a penalty.", "Billing Module", createXinfo("INSERT", $arrHeader, "", $arrValue, "", "", ""), "" ,"ADD", $_POST['TenantID']);
			if($count > 0 ){
				echo "0|Penalty successfully posted to billing.|fncmdlClearPenalty";
			}else{
				echo "1|Failed to post penalty to billing.|";
			}
		break;
    }
?>