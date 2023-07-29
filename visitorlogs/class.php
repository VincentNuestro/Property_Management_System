<?php  
    session_start();
	include('../connect.php');
	switch($_POST['form']) {
		case 'savenewvisitlog':
        	$TransID = createidno("VL", "tbl_visitor", "TransID");
			$sql = "INSERT INTO tbl_visitor SET TransID = '". $TransID ."', VisitorID = '". $_POST['VisitorID'] ."', VisitorName = '". $_POST['VisitorName'] ."', ContactNumber = '". $_POST['ContactNumber'] ."', Address_Company = '". $_POST['Address'] ."', PurposeOfVisit = '". $_POST['PurposeofVisit'] ."', DateIn = '". date('Y-m-d') ."', TimeIn = '". date('H:i:s') ."', userid = '". $_SESSION['MMS-UserID'] ."'";
			$res = mysql_query($sql, $connection);
			if($res == true){
				echo "1|Visit log successfully added.";
			}else{
				echo "2|Failed to save visit log.";
			}
		break;

		case 'tblvisitorlog':
			$getFilters = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'VisitorLogs';", $connection));
		    $Status = explode("|", $getFilters["bystat"]);
		    $Search = explode("|", $getFilters["checked_value"]);
			$DateRangeType = explode("|", $sql_filter["xcheck"]);
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
			      	$SearchFilter = "(". $SearchVal .")";
			    }else{
			      	$SearchFilter = $SearchVal;
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
		    		$DateFilter = "(DepositDate BETWEEN '". date("Y-m-d", strtotime($Date[0])) ."' AND '". date("Y-m-d", strtotime($Date[1])) ."')";
			    }else{
			    	$DateFilter = "";
			    }
			}else{
				if($Date[2] != "" && $Date[3] != ""){
		    		$DateFilter = "(ClaimDate BETWEEN '". date("Y-m-d", strtotime($Date[2])) ."' AND '". date("Y-m-d", strtotime($Date[3])) ."')";
			    }else{
			    	$DateFilter = "";
			    }
			}

			if($SearchFilter == "" && $DateFilter == ""){
				$Filter = "";
			}else{
				if($SearchFilter != "" && $DateFilter == ""){
					$Filter = "WHERE ". $SearchFilter;
				}else if($SearchFilter == "" && $DateFilter != ""){
					$Filter = "WHERE ". $DateFilter;
				}else{
					$Filter = "WHERE ". $DateFilter ." AND ". $SearchFilter;
				}
			}
		
	       	$page = $_POST['page'];
			$limit = ($page-1) * 20;
			$sql = "SELECT TransID, VisitorID, VisitorName, ContactNumber, Address_Company, PurposeOfVisit, DateIn, TimeIn, DateOut, TimeOut FROM tbl_visitor ". $Filter ." GROUP BY VisitorID ORDER BY ". $_POST['VisitorLogsSortBy'] ." ". $_POST['VisitorLogsSortType'] ." LIMIT ".$limit.",20 ";
			$res = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($res)){

				if($row['DateOut'] == ""){
					$DateOut = "";
				}else{
					$DateOut = date('m/d/Y', strtotime($row['DateOut']));
				}

				if($row['TimeOut'] == ""){
					$TimeOut = "";
				}else{
					$TimeOut = date('h:i A', strtotime($row['TimeOut']));
				}

				if($row['DateOut'] == "" && $row['TimeOut'] == ""){
					$btnstat = "<button class='btn btn-sm btn-danger btn-round' onclick='visit_timeout(\"".$row["TransID"]."\");' title='Log out this visitor' style='margin: 2px;z-index: 0;'><i class='fa fa-sign-out'></i></button>";
				}else{
					$btnstat = "<span class='btn btn-sm btn-success btn-round' title='This visitor has already logged out.' style='margin: 2px;z-index: 0;'><i class='fa fa-sign-out'></i></span>";
				}

				echo 	"
						<tr>
							<td>".$row['VisitorID']."</td>
							<td>".$row['VisitorName']."</td>
							<td>".$row['ContactNumber']."</td>
							<td>".$row['Address_Company']."</td>
							<td>".$row['PurposeOfVisit']."</td>
							<td>".date('m/d/Y', strtotime($row['DateIn']))."</td>
							<td>".date('h:i A', strtotime($row['TimeIn']))."</td>
							<td>".$DateOut."</td>
							<td>".$TimeOut."</td>
							<td class='select-logoutvisitor hide isadmin center'>".$btnstat."</td>
						</tr>
						";
			}
		break;

		case 'visit_timeout':
			$sql = "UPDATE tbl_visitor SET DateOut = '". date('Y-m-d') ."', TimeOut = '". date('H:i:s') ."' WHERE TransID = '". $_POST['transid'] ."'";
			$res = mysql_query($sql, $connection);
			if($res == true){
				echo "1|You have successfully logged out.";
			}else{
				echo "2|Failed to log out.";
			}
		break;

		case 'loadvisitlogsentries':
			$getFilters = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'VisitorLogs';", $connection));
		    $Status = explode("|", $getFilters["bystat"]);
		    $Search = explode("|", $getFilters["checked_value"]);
			$DateRangeType = explode("|", $sql_filter["xcheck"]);
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
			      	$SearchFilter = "(". $SearchVal .")";
			    }else{
			      	$SearchFilter = $SearchVal;
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
		    		$DateFilter = "(DepositDate BETWEEN '". date("Y-m-d", strtotime($Date[0])) ."' AND '". date("Y-m-d", strtotime($Date[1])) ."')";
			    }else{
			    	$DateFilter = "";
			    }
			}else{
				if($Date[2] != "" && $Date[3] != ""){
		    		$DateFilter = "(ClaimDate BETWEEN '". date("Y-m-d", strtotime($Date[2])) ."' AND '". date("Y-m-d", strtotime($Date[3])) ."')";
			    }else{
			    	$DateFilter = "";
			    }
			}

			if($SearchFilter == "" && $DateFilter == ""){
				$Filter = "";
			}else{
				if($SearchFilter != "" && $DateFilter == ""){
					$Filter = "WHERE ". $SearchFilter;
				}else if($SearchFilter == "" && $DateFilter != ""){
					$Filter = "WHERE ". $DateFilter;
				}else{
					$Filter = "WHERE ". $DateFilter ." AND ". $SearchFilter;
				}
			}

           	if($_POST["page"] == ""){
               	$page = 1;
           	}else{
               	$page = $_POST["page"];
           	}
           	$limit = ($page-1) * 20;
            $rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM tbl_visitor ". $Filter.";", $connection));
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

		case "loadvisitlogspagination":
			$getFilters = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'VisitorLogs';", $connection));
		    $Status = explode("|", $getFilters["bystat"]);
		    $Search = explode("|", $getFilters["checked_value"]);
			$DateRangeType = explode("|", $sql_filter["xcheck"]);
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
			      	$SearchFilter = "(". $SearchVal .")";
			    }else{
			      	$SearchFilter = $SearchVal;
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
		    		$DateFilter = "(DepositDate BETWEEN '". date("Y-m-d", strtotime($Date[0])) ."' AND '". date("Y-m-d", strtotime($Date[1])) ."')";
			    }else{
			    	$DateFilter = "";
			    }
			}else{
				if($Date[2] != "" && $Date[3] != ""){
		    		$DateFilter = "(ClaimDate BETWEEN '". date("Y-m-d", strtotime($Date[2])) ."' AND '". date("Y-m-d", strtotime($Date[3])) ."')";
			    }else{
			    	$DateFilter = "";
			    }
			}

			if($SearchFilter == "" && $DateFilter == ""){
				$Filter = "";
			}else{
				if($SearchFilter != "" && $DateFilter == ""){
					$Filter = "WHERE ". $SearchFilter;
				}else if($SearchFilter == "" && $DateFilter != ""){
					$Filter = "WHERE ". $DateFilter;
				}else{
					$Filter = "WHERE ". $DateFilter ." AND ". $SearchFilter;
				}
			}

		    $page = $_POST["page"];
            $rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM tbl_visitor ". $Filter.";", $connection));
			$rowsperpage = 20;
			$range = 3;
			$totalpages = ceil($rowCount[0] / $rowsperpage);
			$prevpage;
			$nextpage;
			// if not on page 1, don't show back links
			if($page > 1 ){
			   echo "<li style='width:50px !important;' onclick='paginationvisitorlogs(1)'><< First</li>";
			   $prevpage = $page - 1;
			   echo "<li style='width:70px !important;' onclick='paginationvisitorlogs(". $prevpage .")'>< Previous</li>";
			}

			for($x = ($page - $range); $x < (($page + $range) + 1); $x++)
			{
			   if (($x > 0) && ($x <= $totalpages)){
    			    if ($x == $page){
                        echo "<li id='pgnumvisitlogs" . $x . "' class='pgvisitlogs active' onclick='paginationvisitorlogs(" . $x . ",". $x .")'>" . $x . "</li>";
                      }
    			    else{
    			        echo "<li id='pgnumvisitlogs" . $x . "' class='pgvisitlogs' onclick='paginationvisitorlogs(" . $x . ",". $x .")'>" . $x . "</li>";
                    }
		       }
		    }
		    if($page < ($totalpages - $range)){
                echo "<li>...</li>";
            }

		    if ($page != $totalpages && $rowCount[0] != 0){
		        $nextpage = $page + 1;
		        echo "<li style='width:50px !important;' onclick='paginationvisitorlogs(". $nextpage .", ". $nextpage .")'>Next ></li>";
		        echo "<li style='width:50px !important;' onclick='paginationvisitorlogs(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

      	case 'printmesenpai':
      		$sql = "SELECT VisitorID, VisitorName, ContactNumber, Address_Company, PurposeOfVisit, DateIn, TimeIn, DateOut, TimeOut FROM tbl_visitor WHERE ". $_POST['datetype'] ." BETWEEN '". date('Y-m-d', strtotime($_POST['dateFrom'])) ."' AND '". date('Y-m-d',strtotime($_POST['dateTo'])) ."' ";
      		echo $sql;
      		$res = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($res)){

				if($row['DateOut'] == ""){
					$DateOut = "";
				}else{
					$DateOut = date('m/d/Y', strtotime($row['DateOut']));
				}

				if($row['TimeOut'] == ""){
					$TimeOut = "";
				}else{
					$TimeOut = date('h:i A', strtotime($row['TimeOut']));
				}

				echo 	"
						<tr>
							<td>".$row['VisitorID']."</td>
							<td>".$row['VisitorName']."</td>
							<td>".$row['ContactNumber']."</td>
							<td>".$row['Address_Company']."</td>
							<td>".$row['PurposeOfVisit']."</td>
							<td width='10%'>".date('m/d/Y', strtotime($row['DateIn']))."</td>
							<td width='10%'>".date('h:i A', strtotime($row['TimeIn']))."</td>
							<td width='10%'>".$DateOut."</td>
							<td width='10%'>".$TimeOut."</td>
						</tr>
						";
			}
		    echo "|".date('F d, Y', strtotime($_POST['dateFrom']))."|".date('F d, Y', strtotime($_POST['dateTo']));
      	break;

	}
?>