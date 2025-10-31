<?php 
	session_start();
	include('../connect.php');
	switch($_POST['form']) {
		case 'showdepositlist':
			$getFilters = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'BaggageLogs';", $connection));
		    $Status = explode("|", $getFilters["bystat"]);
		    $Search = explode("|", $getFilters["checked_value"]);
			$DateRangeType = explode("|", $sql_filter["xcheck"]);
		    $Date = explode("|", $getFilters["datefilter"]);

		    // FILTER BY STATUS
			$StatusCount = 0; $SelectedStatus = "";
			for($a = 0; $a<=count($Status)-2; $a++){
				if($Status[$a] == "Deposited"){ 
		      		$StatusVal = "Status = 'Deposited'"; 
		      	}else if($Status[$a] == "Claimed"){ 
		      		$StatusVal = "Status = 'Claimed'"; 
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
		    	$StatFilter = "Status = 'Deposited'";
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
			if($getFilters["xcheck"] == "filterdatebydepdate"){
				if($Date[0] != "" && $Date[1] != ""){
		    		$DateFilter = "AND (DepositDate BETWEEN '". date("Y-m-d", strtotime($Date[0])) ."' AND '". date("Y-m-d", strtotime($Date[1])) ."')";
			    }else{
			    	$DateFilter = "";
			    }
			}else{
				if($Date[2] != "" && $Date[3] != ""){
		    		$DateFilter = "AND (ClaimDate BETWEEN '". date("Y-m-d", strtotime($Date[2])) ."' AND '". date("Y-m-d", strtotime($Date[3])) ."')";
			    }else{
			    	$DateFilter = "";
			    }
			}

	       	$page = $_POST['page'];
			$limit = ($page-1) * 20;	
			$sql = " SELECT TransactionID, CardID, Name, Description, Notes, Quantity, DepositDate, DepositTime, ClaimDate, ClaimTime, Status FROM tbltrans_items WHERE ". $StatFilter ." ". $SearchFilter ." ". $DateFilter ." GROUP BY CardID ORDER BY ". $_POST['BaggageLogsSortBy'] ." ". $_POST['BaggageLogsSortType'] ." LIMIT ".$limit.",20 ";
			// ORDER BY xdatetime ASC
			$res = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($res)){
				if($row['Status'] == "Deposited"){
					$status = "<span class='label label-lg label-warning arrowed-in-right arrowed'>Deposited</span>";
					$btnstat = "<button class='btn btn-sm btn-danger btn-round' onclick='claimitem(\"".$row["TransactionID"]."\");' title='Claim Item' style='margin: 2px;'><i class='fa fa-times'></i></button>";
				}else{
					$status = "<span class='label label-lg label-success arrowed-in-right arrowed'>Claimed</span>";
					$btnstat = "<button class='btn btn-sm btn-success btn-round' title='Claimed Item' style='margin: 2px;'><i class='fa fa-check'></i></button>";
				}

				if($row['ClaimDate'] == ""){
					$claimdate = "";
				}else{
					$claimdate = date('m/d/Y', strtotime($row['ClaimDate']));
				}

				if($row['ClaimTime'] == ""){
					$claimtime = "";
				}else{
					$claimtime = date('h:i A', strtotime($row['ClaimTime']));
				}

				echo 	"<tr>
							<td width='5%'>".$row['CardID']."</td>
							<td width='15%'>".$row['Name']."</td>
							<td width='20%'>".$row['Description']."</td>
							<td width='5%'>".date('m/d/Y', strtotime($row['DepositDate']))."</td>
							<td width='5%'>".date('h:i A', strtotime($row['DepositTime']))."</td>
							<td width='5%'>".$claimdate."</td>
							<td width='5%'>".$claimtime."</td>
							<td width='1%'>".$status."</td>
							<td width='2%' class='hide isadmin select-claimitem center'>".$btnstat."</td>
						</tr>";
			}
		break;

		case 'loaditemlistentries':
			$getFilters = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'BaggageLogs';", $connection));
		    $Status = explode("|", $getFilters["bystat"]);
		    $Search = explode("|", $getFilters["checked_value"]);
			$DateRangeType = explode("|", $sql_filter["xcheck"]);
		    $Date = explode("|", $getFilters["datefilter"]);

		    // FILTER BY STATUS
			$StatusCount = 0; $SelectedStatus = "";
			for($a = 0; $a<=count($Status)-2; $a++){
				if($Status[$a] == "Deposited"){ 
		      		$StatusVal = "Status = 'Deposited'"; 
		      	}else if($Status[$a] == "Claimed"){ 
		      		$StatusVal = "Status = 'Claimed'"; 
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
		    	$StatFilter = "Status = 'Deposited'";
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
			if($getFilters["xcheck"] == "filterdatebydepdate"){
				if($Date[0] != "" && $Date[1] != ""){
		    		$DateFilter = "AND (DepositDate BETWEEN '". date("Y-m-d", strtotime($Date[0])) ."' AND '". date("Y-m-d", strtotime($Date[1])) ."')";
			    }else{
			    	$DateFilter = "";
			    }
			}else{
				if($Date[2] != "" && $Date[3] != ""){
		    		$DateFilter = "AND (ClaimDate BETWEEN '". date("Y-m-d", strtotime($Date[2])) ."' AND '". date("Y-m-d", strtotime($Date[3])) ."')";
			    }else{
			    	$DateFilter = "";
			    }
			}

           	if($_POST["page"] == ""){
               	$page = 1;
           	}else{
               	$page = $_POST["page"];
           	}

           	$limit = ($page-1) * 20;
            $rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM tbltrans_items WHERE ". $StatFilter ." ". $SearchFilter ." ". $DateFilter .";", $connection));
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

		case "loaditemlistpagination":
			$getFilters = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'BaggageLogs';", $connection));
		    $Status = explode("|", $getFilters["bystat"]);
		    $Search = explode("|", $getFilters["checked_value"]);
			$DateRangeType = explode("|", $sql_filter["xcheck"]);
		    $Date = explode("|", $getFilters["datefilter"]);

		    // FILTER BY STATUS
			$StatusCount = 0; $SelectedStatus = "";
			for($a = 0; $a<=count($Status)-2; $a++){
				if($Status[$a] == "Deposited"){ 
		      		$StatusVal = "Status = 'Deposited'"; 
		      	}else if($Status[$a] == "Claimed"){ 
		      		$StatusVal = "Status = 'Claimed'"; 
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
		    	$StatFilter = "Status = 'Deposited'";
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
			if($getFilters["xcheck"] == "filterdatebydepdate"){
				if($Date[0] != "" && $Date[1] != ""){
		    		$DateFilter = "AND (DepositDate BETWEEN '". date("Y-m-d", strtotime($Date[0])) ."' AND '". date("Y-m-d", strtotime($Date[1])) ."')";
			    }else{
			    	$DateFilter = "";
			    }
			}else{
				if($Date[2] != "" && $Date[3] != ""){
		    		$DateFilter = "AND (ClaimDate BETWEEN '". date("Y-m-d", strtotime($Date[2])) ."' AND '". date("Y-m-d", strtotime($Date[3])) ."')";
			    }else{
			    	$DateFilter = "";
			    }
			}

		    $page = $_POST["page"];
            $rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM tbltrans_items WHERE ". $StatFilter ." ". $SearchFilter ." ". $DateFilter .";", $connection));
			$rowsperpage = 20;
			$range = 3;
			$totalpages = ceil($rowCount[0] / $rowsperpage);
			$prevpage;
			$nextpage;
			if($page > 1 ){
			   	echo "<li style='width:50px !important;' onclick='paginationitemlist(1)'><< First</li>";
			   	$prevpage = $page - 1;
			   	echo "<li style='width:70px !important;' onclick='paginationitemlist(". $prevpage .")'>< Previous</li>";
			}

			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if (($x > 0) && ($x <= $totalpages)){
    			    if ($x == $page){
                        echo "<li id='pgitemlist" . $x . "' class='pgnumitemlist active' onclick='paginationitemlist(" . $x . ",". $x .")'>" . $x . "</li>";
                    }else{
    			        echo "<li id='pgitemlist" . $x . "' class='pgnumitemlist' onclick='paginationitemlist(" . $x . ",". $x .")'>" . $x . "</li>";
                    }
		       }
		    }
		    if($page < ($totalpages - $range)){
                	echo "<li>...</li>";
            }

		    if ($page != $totalpages && $rowCount[0] != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='paginationitemlist(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='paginationitemlist(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'savedeposititem':
            $TransactionID = createidno("TRANS", "tbltrans_items", "TransactionID");
			$sql = "INSERT INTO tbltrans_items SET TransactionID = '". $TransactionID ."', CardID = '". $_POST['CardID'] ."', Name = '". $_POST['Name'] ."', Description = '". $_POST['Description'] ."', Notes = '". $_POST['Notes'] ."', Quantity = '". $_POST['Quantity'] ."', DepositDate = '". date('Y-m-d') ."', DepositTime = '". date('H:i:s') ."', userid = '". $_SESSION['MMS-UserID'] ."' ";
			$res = mysql_query($sql, $connection);
			if($res == true){
				echo "1|Item deposit successfull.";
			}else{
				echo "2|Failed to save transaction.";
			}
		break;

		case 'claimitem':
			$res = mysql_query("UPDATE tbltrans_items SET ClaimDate = '". date('Y-m-d') ."', ClaimTime = '". date('H:i:s') ."', Status = 'Claimed' WHERE TransactionID = '". $_POST['transid'] ."'", $connection);
			if($res == true){
				echo "1|Item successfully claimed.";
			}else{
				echo "1|Failed to claim item.";
			}
		break;

		case 'showtxtItemListMall':
			$res = mysql_query("SELECT mallid, mallname FROM tblref_mall WHERE mallstat = '1'", $connection);
			while($row = mysql_fetch_array($res)){
				echo "<option value='". $row[0] ."'>". $row[1] ."</option>";
			}
		break;

		case 'printmesenpai':
			$cnt = 0; $chk = "";
			$stat = explode("|", $_POST['stat']);
		    for($a = 0; $a<=count($stat)-2; $a++){
		      	if($stat[$a] == "Deposited"){ 
		      		$con = "Status = 'Deposited'"; 
		      	}else if($stat[$a] == "Claimed"){ 
		      		$con = "Status = 'Claimed'"; 
		      	}
		      	if($stat[$a] != ""){
		        	$cnt_fltr++;
		        	$cnt++;
			        if($cnt == 1){
			          	$chk .= $con;
			        }else{
			          	$chk .= " OR ".$con;
			        }
		      	}
		    }

		    if($cnt > 1){
		      	$status = "(".$chk.")";
		    }else{
		      	$status = $chk;
		    }

		    if($cnt > 0){
		      	$and = " AND ";
		    }else{
		      	$and = "";
		    }

		    $sql = "SELECT TransactionID, CardID, Name, Description, Notes, Quantity, DepositDate, DepositTime, ClaimDate, ClaimTime, Status FROM tbltrans_items WHERE (". $_POST['datetype'] ." BETWEEN '". date('Y-m-d', strtotime($_POST['dateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['dateTo'])) ."') ".$and." ".$status." ";
		    echo $sql;
		    $res = mysql_query($sql, $connection);
		    while($row = mysql_fetch_array($res)){
		    	if($row['Status'] == "Deposited"){
					$status = "<span class='label label-warning arrowed-in-right arrowed'>Deposited</span>";
					$btnstat = "";
				}else{
					$status = "<span class='label label-success arrowed-in-right arrowed'>Claimed</span>";
					$btnstat = "disabled";
				}

				if($row['ClaimDate'] == ""){
					$claimdate = "";
				}else{
					$claimdate = date('m/d/Y', strtotime($row['ClaimDate']));
				}

				if($row['ClaimTime'] == ""){
					$claimtime = "";
				}else{
					$claimtime = date('h:i A', strtotime($row['ClaimTime']));
				}

		    	echo 	"
							<tr>
								<td>".$row['CardID']."</td>
								<td>".$row['Name']."</td>
								<td>".$row['Description']."</td>
								<td width='10%'>".date('m/d/Y', strtotime($row['DepositDate']))."</td>
								<td width='10%'>".date('h:i A', strtotime($row['DepositTime']))."</td>
								<td width='10%'>".$claimdate."</td>
								<td width='10%'>".$claimtime."</td>
								<td>".$status."</td>
							</tr>
						";
		    }
		    echo "|".date('F d, Y', strtotime($_POST['dateFrom']))."|".date('F d, Y', strtotime($_POST['dateTo']));
		break;
	}
?>



