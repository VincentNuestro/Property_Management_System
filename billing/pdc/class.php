<?php
	session_start();
    include('../../connect.php');
    switch ($_POST['form']){
    	case 'tbllistofpdc':
			$getFilters = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'PDCList';", $connection));
		    $Status = explode("@", $getFilters["bystat"]);
		    $Search = explode("|", $getFilters["checked_value"]);
		    $Date = explode("|", $getFilters["datefilter"]);

		    // FILTER BY STATUS
		    $MainStatus = explode("|", $Status[0]);
			$StatusCount = 0; $SelectedStatus = "";
			for($a = 0; $a<=count($MainStatus)-2; $a++){
				if($MainStatus[$a] == "Deposited"){ 
					$StatusVal = "a.depositorystat = 'Deposited'";
				}else if($MainStatus[$a] == "For Deposit"){
					$StatusVal = "a.depositorystat = 'For Deposit'"; 
				}

				if($MainStatus[$a] != ""){
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
		    	$StatFilter = "a.depositorystat = 'For Deposit'";
		    }else{
		    	$StatFilter = $getAllStatus;
		    }

		     // FILTER BY STATUS2
		    $MainStatus2 = explode("|", $Status[1]);
			$StatusCount2 = 0; $SelectedStatus2 = "";
			for($a = 0; $a<=count($MainStatus2)-2; $a++){
				if($MainStatus2[$a] == "Cleared"){ 
					$StatusVal2 = "a.checkstat = 'Cleared'";
				}else if($MainStatus2[$a] == "Pending"){
					$StatusVal2 = "a.checkstat = 'Pending'"; 
				}

				if($MainStatus2[$a] != ""){
					$StatusCount2++;
					if($StatusCount2 == 1){
						$SelectedStatus2 .= $StatusVal2;
					}else{
						$SelectedStatus2 .= " OR " . $StatusVal2;
					}
				}
			}

			if($StatusCount2 > 1){
		      	$getAllStatus2 = "(". $SelectedStatus2 .")";
		    }else{
		      	$getAllStatus2 = $SelectedStatus2;
		    }

		    if($getAllStatus2 == ""){
		    	$StatFilter2 = "";
		    }else{
		    	$StatFilter2 = "AND ". $getAllStatus2;
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
			if($getFilters["xcheck"] == "pdcdate"){
				if($Date[0] != "" && $Date[1] != ""){
		    		$DateFilter = "AND (a.pdcdate BETWEEN '". date("Y-m-d", strtotime($Date[0])) ."' AND '". date("Y-m-d", strtotime($Date[1])) ."')";
			    }else{
			    	$DateFilter = "";
			    }
			}else{
				if($Date[2] != "" && $Date[3] != ""){
		    		$DateFilter = "AND (a.datedep BETWEEN '". date("Y-m-d", strtotime($Date[2])) ."' AND '". date("Y-m-d", strtotime($Date[3])) ."')";
			    }else{
			    	$DateFilter = "";
			    }
			}

			$page = $_POST['page'];
			$limit = ($page-1) * 20;
			$sql = "SELECT a.customerid, a.pdcdate, a.amount, a.depositorystat, a.checkstat, a.bank, a.checkno, a.penalty, a.chckreceivedby,a.depository,a.datedep, b.tradename FROM tbltrans_pdc AS a LEFT JOIN tbltrans_tenants AS b ON b.TenantID = a.customerid WHERE ". $StatFilter ." ". $SearchFilter ." ". $StatFilter2 ." ". $DateFilter ." LIMIT ".$limit.",20;";
			$res = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($res)){
			    	if($row[1] == "" || $row[1] == "0000-00-00"){
			    		$pdcdate = "";
			    	}else{
			    		$pdcdate = date('m/d/Y', strtotime($row[1]));
			    	}

			    	if($row[10] == "" || $row[10] == "0000-00-00"){
			 			$datedep = "";
			    	}else{
			 			$datedep = date('m/d/Y', strtotime($row[10]));
			    	}

			 		echo	"<tr>
			 				<td width='5%'>". $pdcdate ."</td>
			 				<td width='13%'>". $row['tradename'] ."</td>
			 				<td width='10%' id='tdamount". $row[6] ."'>". number_format($row[2], "2", ".", ",") ."</td>
			 				<td width='12%' id='tddepositorystat". $row[6] ."'>". $row[3] ."</td>
			 				<td width='10%' id='tdcheckstat". $row[6] ."'>". $row[4] ."</td>
			 				<td width='5%'>". $row[5] ."</td>
			 				<td width='5%'>". $row[6] ."</td>
			 				<td width='5%' id='tddepository". $row[6] ."'>". $row['depository'] ."</td>
			 				<td width='5%' id='tdreceivedby". $row[6] ."'>". $row['chckreceivedby'] ."</td>
			 				<td width='5%' id='tddatedep". $row[6] ."'>". $datedep ."</td>
		 					<td width='5%' class='center'>
		 						<div class='btn-group'>
		 							<button class='btn btn-sm btn-info btn-round' id='edit". $row[6] ."' onclick='editfield(\"". $row[6] ."\");' title='Edit' style='margin: 2px;z-index: 0;'><i class='ace-icon fa fa-pencil bigger-120' style='padding:1px;' ></i></button>
                                 	<button class='btn btn-sm btn-success btn-round' id='confirm". $row[6] ."' style='display:none;margin: 2px;z-index: 0;' onclick='saveeditedpdc(\"". $row[6] ."\");' title='Confirm'><i class='ace-icon fa fa-check bigger-110'></i></button>
                                 	<button class='btn btn-sm btn-danger btn-round' id='cancel". $row[6] ."' style='display:none;margin: 2px;z-index: 0;' onclick='canceledit(\"". $row[6] ."\");' title='Cancel'><i class='ace-icon fa fa-times bigger-120' style='padding:1px;'></i></button>
		 						</div>
			 				</td>
			 			</tr>";
			}
		break;

		case 'loadentriespdc':
			$getFilters = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'PDCList';", $connection));
		    $Status = explode("@", $getFilters["bystat"]);
		    $Search = explode("|", $getFilters["checked_value"]);
		    $Date = explode("|", $getFilters["datefilter"]);

		    // FILTER BY STATUS
		    $MainStatus = explode("|", $Status[0]);
			$StatusCount = 0; $SelectedStatus = "";
			for($a = 0; $a<=count($MainStatus)-2; $a++){
				if($MainStatus[$a] == "Deposited"){ 
					$StatusVal = "a.depositorystat = 'Deposited'";
				}else if($MainStatus[$a] == "For Deposit"){
					$StatusVal = "a.depositorystat = 'For Deposit'"; 
				}

				if($MainStatus[$a] != ""){
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
		    	$StatFilter = "a.depositorystat = 'For Deposit'";
		    }else{
		    	$StatFilter = $getAllStatus;
		    }

		     // FILTER BY STATUS2
		    $MainStatus2 = explode("|", $Status[1]);
			$StatusCount2 = 0; $SelectedStatus2 = "";
			for($a = 0; $a<=count($MainStatus2)-2; $a++){
				if($MainStatus2[$a] == "Cleared"){ 
					$StatusVal2 = "a.checkstat = 'Cleared'";
				}else if($MainStatus2[$a] == "Pending"){
					$StatusVal2 = "a.checkstat = 'Pending'"; 
				}

				if($MainStatus2[$a] != ""){
					$StatusCount2++;
					if($StatusCount2 == 1){
						$SelectedStatus2 .= $StatusVal2;
					}else{
						$SelectedStatus2 .= " OR " . $StatusVal2;
					}
				}
			}

			if($StatusCount2 > 1){
		      	$getAllStatus2 = "(". $SelectedStatus2 .")";
		    }else{
		      	$getAllStatus2 = $SelectedStatus2;
		    }

		    if($getAllStatus2 == ""){
		    	$StatFilter2 = "";
		    }else{
		    	$StatFilter2 = "AND ". $getAllStatus2;
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
			if($getFilters["xcheck"] == "pdcdate"){
				if($Date[0] != "" && $Date[1] != ""){
		    		$DateFilter = "AND (a.pdcdate BETWEEN '". date("Y-m-d", strtotime($Date[0])) ."' AND '". date("Y-m-d", strtotime($Date[1])) ."')";
			    }else{
			    	$DateFilter = "";
			    }
			}else{
				if($Date[2] != "" && $Date[3] != ""){
		    		$DateFilter = "AND (a.datedep BETWEEN '". date("Y-m-d", strtotime($Date[2])) ."' AND '". date("Y-m-d", strtotime($Date[3])) ."')";
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
            $rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(a.pdcdate) FROM tbltrans_pdc AS a LEFT JOIN tbltrans_tenants AS b ON b.TenantID = a.customerid WHERE ". $StatFilter ." ". $SearchFilter ." ". $StatFilter2 ." ". $DateFilter .";", $connection));
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

		case "loadpagespdc":
			$getFilters = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'PDCList';", $connection));
		    $Status = explode("@", $getFilters["bystat"]);
		    $Search = explode("|", $getFilters["checked_value"]);
		    $Date = explode("|", $getFilters["datefilter"]);

		    // FILTER BY STATUS
		    $MainStatus = explode("|", $Status[0]);
			$StatusCount = 0; $SelectedStatus = "";
			for($a = 0; $a<=count($MainStatus)-2; $a++){
				if($MainStatus[$a] == "Deposited"){ 
					$StatusVal = "a.depositorystat = 'Deposited'";
				}else if($MainStatus[$a] == "For Deposit"){
					$StatusVal = "a.depositorystat = 'For Deposit'"; 
				}

				if($MainStatus[$a] != ""){
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
		    	$StatFilter = "a.depositorystat = 'For Deposit'";
		    }else{
		    	$StatFilter = $getAllStatus;
		    }

		     // FILTER BY STATUS2
		    $MainStatus2 = explode("|", $Status[1]);
			$StatusCount2 = 0; $SelectedStatus2 = "";
			for($a = 0; $a<=count($MainStatus2)-2; $a++){
				if($MainStatus2[$a] == "Cleared"){ 
					$StatusVal2 = "a.checkstat = 'Cleared'";
				}else if($MainStatus2[$a] == "Pending"){
					$StatusVal2 = "a.checkstat = 'Pending'"; 
				}

				if($MainStatus2[$a] != ""){
					$StatusCount2++;
					if($StatusCount2 == 1){
						$SelectedStatus2 .= $StatusVal2;
					}else{
						$SelectedStatus2 .= " OR " . $StatusVal2;
					}
				}
			}

			if($StatusCount2 > 1){
		      	$getAllStatus2 = "(". $SelectedStatus2 .")";
		    }else{
		      	$getAllStatus2 = $SelectedStatus2;
		    }

		    if($getAllStatus2 == ""){
		    	$StatFilter2 = "";
		    }else{
		    	$StatFilter2 = "AND ". $getAllStatus2;
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
			if($getFilters["xcheck"] == "pdcdate"){
				if($Date[0] != "" && $Date[1] != ""){
		    		$DateFilter = "AND (a.pdcdate BETWEEN '". date("Y-m-d", strtotime($Date[0])) ."' AND '". date("Y-m-d", strtotime($Date[1])) ."')";
			    }else{
			    	$DateFilter = "";
			    }
			}else{
				if($Date[2] != "" && $Date[3] != ""){
		    		$DateFilter = "AND (a.datedep BETWEEN '". date("Y-m-d", strtotime($Date[2])) ."' AND '". date("Y-m-d", strtotime($Date[3])) ."')";
			    }else{
			    	$DateFilter = "";
			    }
			}

		    $page = $_POST["page"];
            $rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(a.pdcdate) FROM tbltrans_pdc AS a LEFT JOIN tbltrans_tenants AS b ON b.TenantID = a.customerid WHERE ". $StatFilter ." ". $SearchFilter ." ". $StatFilter2 ." ". $DateFilter .";", $connection));
			$rowsperpage = 20;
			$range = 3;
			$totalpages = ceil($rowCount[0] / $rowsperpage);
			$prevpage;
			$nextpage;
			// if not on page 1, don't show back links
			if($page > 1 ){
			   	echo "<li style='width:50px !important;' onclick='paginationpdc(1)'><< First</li>";
			   	$prevpage = $page - 1;
			   	echo "<li style='width:70px !important;' onclick='paginationpdc(". $prevpage .")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if (($x > 0) && ($x <= $totalpages)){
    			    if ($x == $page){
                        echo "<li id='pgpdc" . $x . "' class='pgnumpdc active' onclick='paginationpdc(" . $x . ",". $x .")'>" . $x . "</li>";
                    }else{
    			        echo "<li id='pgpdc" . $x . "' class='pgnumppdc' onclick='paginationpdc(" . $x . ",". $x .")'>" . $x . "</li>";
                    }
		       	}
		    }
		    if($page < ($totalpages - $range)){
                echo "<li>...</li>";
            }
		    if ($page != $totalpages && $rowCount[0] != 0){
		       $nextpage = $page + 1;
		       echo "<li style='width:50px !important;' onclick='paginationpdc(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       echo "<li style='width:50px !important;' onclick='paginationpdc(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'editfield':
			$sql = " SELECT amount, depositorystat, checkstat, penalty, checkno, depository, chckreceivedby, datedep FROM tbltrans_pdc WHERE checkno = '".$_POST['checkno']."' ";
			$res = mysql_query($sql, $connection);
			$row = mysql_fetch_array($res);
			$asd .= "<select id='"."checkstat".$row[4]."'>";
						echo $asd; ?>
							<?php if($row[2] == "Pending") {?>
                                <option value='Pending'>Pending</option>
                                <option value='Close Account'>Close Account</option>
                                <option value='Check Replace'>Check Replace</option>
                                <option value='Cleared'>Cleared</option>
                            <?php } else if($row[2] == "Cleared") { ?>
                            	<option value='Cleared'>Cleared</option>
                                <option value='Close Account'>Close Account</option>
                                <option value='Check Replace'>Check Replace</option>
                                <option value='Pending'>Pending</option>
                            <?php } else if($row[2] == "Check Replace") { ?>
                                <option value='Check Replace'>Check Replace</option>
                                <option value='Close Account'>Close Account</option>
                            	<option value='Cleared'>Cleared</option>
                                <option value='Pending'>Pending</option>
                            <?php } else if($row[2] == "Close Account") {?>
                                <option value='Close Account'>Close Account</option>
                            	<option value='Check Replace'>Check Replace</option>
                            	<option value='Cleared'>Cleared</option>
                                <option value='Pending'>Pending</option>
                            <?php } ?>
                        </select>
                       	<?php

			echo  "|";

			echo "<input type='text' size='11' id='"."amount".$row[4]."' value='".$row[0]."'>". "|";

			$zxc .= "<select id='"."depositorystat".$row[4]."'>";
				echo $zxc; ?>
				<?php if($row[1] == "For Deposit"){ ?>
					<option value='For Deposit'>For Deposit</option>
                    <option value='Deposited'>Deposited</option>
				<?php }else{ ?>
                    <option value='Deposited'>Deposited</option>
					<option value='For Deposit'>For Deposit</option>
				<?php } ?>
				</select>
				<?php 

			echo "|";

			if($row['datedep'] == "" || $row['datedep'] == "0000-00-00"){
				$datedep = date('m/d/Y', strtotime(getsysdate()));
		   	}else{
				$datedep = date('m/d/Y', strtotime($row['datedep']));
		   	}

			echo "<input type='text' size='11' class='form-control' id='"."depository".$row[4]."' value='".$row['depository']."'>". "|" . "<input type='text' size='11' class='form-control' id='"."received".$row[4]."' value='".$row['chckreceivedby']."'>" . "|" . 
			"<input type='text' class='form-control date-picker' id='"."date".$row[4]."' data-provide='datepicker' value='".$datedep."'>";
		break;

		case 'cancelfield':
			$sql = " SELECT amount, depositorystat, checkstat, penalty, checkno ,depository, chckreceivedby, datedep  FROM tbltrans_pdc WHERE checkno = '".$_POST['checkno']."' ";
			$res = mysql_query($sql, $connection);
			$row = mysql_fetch_array($res);

		   	if($row['datedep'] == "" || $row['datedep'] == "0000-00-00"){
				$datedep = "";
		   	}else{
				$datedep = date('m/d/Y', strtotime($row['datedep']));
		   	}

			echo number_format($row[0], "2", ".", ",") . "|" . $row[1] . "|" . $row[2] . "|" . $row[5] . "|" . $row[6] . "|" . $datedep;
		break;

		case 'saveeditedpdc':
			$sql = " UPDATE tbltrans_pdc SET amount = '". $_POST['amount'] ."', depositorystat = '". $_POST['depositorystat'] ."', checkstat = '". $_POST['checkstat'] ."', depository = '". $_POST['depository'] ."', datedep = '".date("Y-m-d", strtotime($_POST['datedep']))."', chckreceivedby = '". $_POST['received'] ."' WHERE checkno = '". $_POST['checkno'] ."' ";
			$res = mysql_query($sql, $connection);
			$row = mysql_fetch_array($res);

			if($_POST['datedep'] == "" || $_POST['datedep'] == "0000-00-00"){
				$datedep = "";
		   	}else{
				$datedep = date('m/d/Y', strtotime($_POST['datedep']));
		   	}

			echo $_POST['amount'] . "|" . $_POST['depositorystat'] . "|" . $_POST['checkstat'] . "|" . $_POST['depository'] . "|" . $_POST['received'] . "|" . $datedep;
		break;

		case 'printkomamamo':
        	$sql = " SELECT a.customerid, a.pdcdate, a.amount, a.depositorystat, a.checkstat, a.bank, a.checkno, a.penalty, a.chckreceivedby, a.depository,a.datedep ,b.tradename FROM tbltrans_pdc AS a LEFT JOIN tbltrans_tenants AS b ON b.TenantID = a.customerid WHERE a.pdcdate BETWEEN '".date("Y-m-d", strtotime($_POST['dateFrom']))."' AND '".date("Y-m-d", strtotime($_POST['dateTo']))."' ";
             $res = mysql_query($sql, $connection);
             if(!$res){echo mysql_error($connection);}
             else{
                while($row = mysql_fetch_array($res)){
                echo 
                    "<tr>
                        <td>" .$row[1]. "</td>
                        <td>" .$row[11]. "</td>
                        <td style='text-align: right;'>" .$row[2]. "</td>
                        <td>" .$row[3]. "</td>
                        <td>" .$row[4]. "</td>
                        <td>" .$row[5]. "</td>
                        <td>" .$row[6]. "</td>
                        <td>" .$row[9]. "</td>
                        <td>" .$row[8]. "</td>
                        <td>" .$row[10]. "</td>
                    </tr>
                    ";
            	}
            	echo "|". date('F d, Y', strtotime($_POST['dateFrom'])) . "|" . date('F d, Y', strtotime($_POST['dateTo']));
            }
        break;
    }
?>