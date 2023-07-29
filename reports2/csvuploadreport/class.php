<?php
	session_start();
	include "../../connect.php";
	switch ($_POST['form']) {
		case 'ShowtblUploadReportList':
			$cnt_fltr = 0;
		    $sql_filter = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'CSVUploadReports' ", $connection));
		    $trby = explode("|", $sql_filter["checked_value"]);
		    $stat = explode("|", $sql_filter["bystat"]);
		    $unit = explode("|", $sql_filter["xcheck"]);
		    $date = explode("|", $sql_filter["datefilter"]);
		    $filter = "";
		    // filter for status
		    $cnt = 0; $chk = "";
		    for($a = 0; $a<=count($stat)-1; $a++){
		      	if($stat[$a] == "Complete"){
		      		$con = "a.countSync = '5'";
		      	}else if($stat[$a] == "Incomplete"){
		      		$con = "a.countSync <= '4'"; 
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
		      	$Stat_fltr = "(".$chk.")";
		    }else{
		      	$Stat_fltr = $chk;
		    }

		    if($cnt > 0){
		      	$and = " AND ";
		    }else{
		      	$and = "";
		    }

		    // filter by date
		    $date_fltr = "(a.reportDate BETWEEN '".date("Y-m-d", strtotime($date[0]))."' AND '".date("Y-m-d", strtotime($date[1]))."')";
		    // filter by
		    $cnt3 = 0; $chk3 = "";
		    for($c = 0; $c<=count($trby)-1; $c++){
		      	if($trby[$c] != ""){
			        $cnt_fltr++;
			        $cnt3++;
			        if($cnt3 == 1){
			          	$chk3 .= $trby[$c] . " LIKE '%".$_POST["key"]."%'";
			        }else{
			          	$chk3 .= " OR ". $trby[$c] . " LIKE '%".$_POST["key"]."%'";
			        }
		      	}
		    }

		    if($cnt3 > 1){
		      	$by_fltr = "(".$chk3.")";
		    }else{
		      	$by_fltr = $chk3;
		    }

		    if($cnt3 > 0){
		      	$and2 = " AND ";
		    }else{
		      	$and2 = "";
		    }

		    if($cnt > 0 ){
		       	$filter = "WHERE ".$Stat_fltr.$and.$date_fltr.$and2.$by_fltr." AND (b.Status = 'Active' OR b.Status = 'ForEviction' OR b.Status = 'ForRenewal')";
		       	$page = $_POST['page'];
				$limit = ($page-1) * 20;
				$res = mysql_query("SELECT a.reportDate, b.tradename, a.sales, a.discount, a.void_refund, a.salesperhour, a.paymenttype FROM db_syncfilestat AS a INNER JOIN tbltrans_tenants AS b ON a.tenantID = b.tenantID ".$filter." ORDER BY a.reportDate LIMIT ".$limit.",20", $connection);
				while($row = mysql_fetch_array($res)){

					if($row[2] == 1){
						$sales = "<span class='glyphicon glyphicon-ok-sign text-success'></span>";
					}else{
						$sales = "<span class='glyphicon glyphicon-remove-sign text-danger'></span>";
					}

					if($row[3] == 1){
						$discount = "<span class='glyphicon glyphicon-ok-sign text-success'></span>";
					}else{
						$discount = "<span class='glyphicon glyphicon-remove-sign text-danger'></span>";
					}

					if($row[4] == 1){
						$void = "<span class='glyphicon glyphicon-ok-sign text-success'></span>";
					}else{
						$void = "<span class='glyphicon glyphicon-remove-sign text-danger'></span>";
					}

					if($row[5] == 1){
						$perhour = "<span class='glyphicon glyphicon-ok-sign text-success'></span>";
					}else{
						$perhour = "<span class='glyphicon glyphicon-remove-sign text-danger'></span>";
					}

					if($row[6] == 1){
						$paymenttype = "<span class='glyphicon glyphicon-ok-sign text-success'></span>";
					}else{
						$paymenttype = "<span class='glyphicon glyphicon-remove-sign text-danger'></span>";
					}

					echo "	<tr>
								<td>". date('m/d/Y', strtotime($row[0])) ."</td>
								<td>". $row[1] ."</td>
								<td style='text-align: center;z-index: 0;'>". $sales ."</td>
								<td style='text-align: center;z-index: 0;'>". $discount ."</td>
								<td style='text-align: center;z-index: 0;'>". $void ."</td>
								<td style='text-align: center;z-index: 0;'>". $perhour ."</td>
								<td style='text-align: center;z-index: 0;'>". $paymenttype ."</td>
							</tr>";
				}
			}
		break;

		case 'tblUploadReportListEntries':
			$cnt_fltr = 0;
		    $sql_filter = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'CSVUploadReports' ", $connection));
		    $trby = explode("|", $sql_filter["checked_value"]);
		    $stat = explode("|", $sql_filter["bystat"]);
		    $unit = explode("|", $sql_filter["xcheck"]);
		    $date = explode("|", $sql_filter["datefilter"]);
		    $filter = "";
		    // filter for status
		    $cnt = 0; $chk = "";
		    for($a = 0; $a<=count($stat)-1; $a++){
		      	if($stat[$a] == "Complete"){
		      		$con = "a.countSync = '5'";
		      	}else if($stat[$a] == "Incomplete"){
		      		$con = "a.countSync <= '4'"; 
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
		      	$Stat_fltr = "(".$chk.")";
		    }else{
		      	$Stat_fltr = $chk;
		    }

		    if($cnt > 0){
		      	$and = " AND ";
		    }else{
		      	$and = "";
		    }

		    // filter by date
		    $date_fltr = "(a.reportDate BETWEEN '".date("Y-m-d", strtotime($date[0]))."' AND '".date("Y-m-d", strtotime($date[1]))."')";
		    // filter by
		    $cnt3 = 0; $chk3 = "";
		    for($c = 0; $c<=count($trby)-1; $c++){
		      	if($trby[$c] != ""){
			        $cnt_fltr++;
			        $cnt3++;
			        if($cnt3 == 1){
			          	$chk3 .= $trby[$c] . " LIKE '%".$_POST["key"]."%'";
			        }else{
			          	$chk3 .= " OR ". $trby[$c] . " LIKE '%".$_POST["key"]."%'";
			        }
		      	}
		    }

		    if($cnt3 > 1){
		      	$by_fltr = "(".$chk3.")";
		    }else{
		      	$by_fltr = $chk3;
		    }

		    if($cnt3 > 0){
		      	$and2 = " AND ";
		    }else{
		      	$and2 = "";
		    }

		    if($cnt > 0 ){
		       $filter = "WHERE ".$Stat_fltr.$and.$date_fltr.$and2.$by_fltr." AND (b.Status = 'Active' OR b.Status = 'ForEviction' OR b.Status = 'ForRenewal')";

				if($_POST["page"] == ""){
	               	$page = 1;
	           	}else{
	               	$page = $_POST["page"];
	           	}

	           	$limit = ($page-1) * 20;
	            $sql = "SELECT COUNT(a.reportDate) FROM db_syncfilestat AS a INNER JOIN tbltrans_tenants AS b ON a.tenantID = b.tenantID ".$filter."";
	            $result = mysql_query($sql, $connection);
	            $row = mysql_fetch_array($result);
	            $rowsperpage = 20;
	            $totalpages = ceil($row[0] / $rowsperpage);
	            $upto = $limit + 20;
	            $from = $limit + 1;
	            if($page == $totalpages && $row[0] != 0){
	                echo "Showing " . $from . " to " . $row[0] . " of " . $row[0] . " entries";
	            }else{
	                if($row[0] == 0){
	                   	echo "";
	                }else if($row[0] <= 19 && $row[0] != 0){
	                   	echo "Showing 1 to " . $row[0] . " of " . $row[0] . " entries";
	                }else if($row[0] >= 20 && $row[0] != 0){
	                   	echo "Showing " . $from . " to " . $upto . " of " . $row[0] . " entries";
	                }
	            }
	        }
		break;

		case 'tblUploadReportListPagination':
			$cnt_fltr = 0;
		    $sql_filter = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'CSVUploadReports' ", $connection));
		    $trby = explode("|", $sql_filter["checked_value"]);
		    $stat = explode("|", $sql_filter["bystat"]);
		    $unit = explode("|", $sql_filter["xcheck"]);
		    $date = explode("|", $sql_filter["datefilter"]);
		    $filter = "";
		    // filter for status
		    $cnt = 0; $chk = "";
		    for($a = 0; $a<=count($stat)-1; $a++){
		      	if($stat[$a] == "Complete"){
		      		$con = "a.countSync = '5'";
		      	}else if($stat[$a] == "Incomplete"){
		      		$con = "a.countSync <= '4'"; 
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
		      	$Stat_fltr = "(".$chk.")";
		    }else{
		      	$Stat_fltr = $chk;
		    }

		    if($cnt > 0){
		      	$and = " AND ";
		    }else{
		      	$and = "";
		    }

		    // filter by date
		    $date_fltr = "(a.reportDate BETWEEN '".date("Y-m-d", strtotime($date[0]))."' AND '".date("Y-m-d", strtotime($date[1]))."')";
		    // filter by
		    $cnt3 = 0; $chk3 = "";
		    for($c = 0; $c<=count($trby)-1; $c++){
		      	if($trby[$c] != ""){
			        $cnt_fltr++;
			        $cnt3++;
			        if($cnt3 == 1){
			          	$chk3 .= $trby[$c] . " LIKE '%".$_POST["key"]."%'";
			        }else{
			          	$chk3 .= " OR ". $trby[$c] . " LIKE '%".$_POST["key"]."%'";
			        }
		      	}
		    }

		    if($cnt3 > 1){
		      	$by_fltr = "(".$chk3.")";
		    }else{
		      	$by_fltr = $chk3;
		    }

		    if($cnt3 > 0){
		      	$and2 = " AND ";
		    }else{
		      	$and2 = "";
		    }

		    if($cnt > 0 ){
		       $filter = "WHERE ".$Stat_fltr.$and.$date_fltr.$and2.$by_fltr." AND (b.Status = 'Active' OR b.Status = 'ForEviction' OR b.Status = 'ForRenewal')";
				$page = $_POST["page"];
	        	$sqlb = " SELECT COUNT(a.reportDate) FROM db_syncfilestat AS a INNER JOIN tbltrans_tenants AS b ON a.tenantID = b.tenantID ".$filter." ";
				$aa = mysql_query($sqlb, $connection);
				$nums = mysql_fetch_row($aa);
				$num = $nums[0];
				$rowsperpage = 20;
				$range = 3;
				$totalpages = ceil($num / $rowsperpage);
				$prevpage;
				$nextpage;
				if($page > 1 ){
				   echo "<li style='width:50px !important;' onclick='tblUploadReportListPageFunc(1)'><< First</li>";
				   $prevpage = $page - 1;
				   echo "<li style='width:70px !important;' onclick='tblUploadReportListPageFunc(". $prevpage .")'>< Previous</li>";
				}
				for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
				   if (($x > 0) && ($x <= $totalpages)){
	    			    if ($x == $page){
	                        echo "<li id='pgfileCSVUploadReports" . $x . "' class='pgnumpCSVUploadReports active' onclick='tblUploadReportListPageFunc(" . $x . ",". $x .")'>" . $x . "</li>";
	                    }else{
	    			        echo "<li id='pgfileCSVUploadReports" . $x . "' class='pgnumpCSVUploadReports' onclick='tblUploadReportListPageFunc(" . $x . ",". $x .")'>" . $x . "</li>";
	                    }
			       }
			    }
			    if($page < ($totalpages - $range)){
	                echo "<li>...</li>";
	            }
			    if ($page != $totalpages && $num != 0){
			       $nextpage = $page + 1;
			       echo "<li style='width:50px !important;' onclick='tblUploadReportListPageFunc(". $nextpage .", ". $nextpage .")'>Next ></li>";
			       echo "<li style='width:50px !important;' onclick='tblUploadReportListPageFunc(". $totalpages .", ". $totalpages .")'>Last >></li>";
			    }
			}
		break;

		case 'loadTenantSelection':
			echo "<option value=''>-- Select Tenant --</option>";
			$res = mysql_query("SELECT tenantID, tradename FROM tbltrans_tenants WHERE mallID = '". $_POST['mallid'] ."' AND (Status = 'Active' OR Status = 'ForEviction' OR Status = 'ForRenewal') AND ustatus = 'Occupied' ORDER BY tradename", $connection);
			while($row = mysql_fetch_array($res)){
				echo "<option value='" . $row[0] . "'>" . $row[1] . "</option>";
			}
		break;

		case 'printCSVUR':
			if($_POST['Mall'] == ""){
				$MallFilter = "";
			}else{
				$MallFilter = "AND b.mallID = '". $_POST['Mall'] ."'";
			}
			if($_POST['Tenant'] == ""){
				$TenantFilter = "";
			}else{
				$TenantFilter = "AND a.tenantID = '". $_POST['Tenant'] ."'";
			}

			$arr = explode("|", $_POST['Stat']);
			if($arr[0] == "Complete" && $arr[1] == "Incomplete"){
				$StatFilter = "";
			}else if($arr[0] == "Complete" && $arr[1] == ""){
				$StatFilter = "AND a.countSync = '5'";
			}else if($arr[0] == "Incomplete" && $arr[1] == ""){
				$StatFilter = "AND a.countSync <= '4'";
			}else{
				$StatFilter = "";
			}

			$sql = "SELECT a.reportDate, b.tradename, a.sales, a.discount, a.void_refund, a.salesperhour, a.paymenttype FROM db_syncfilestat AS a INNER JOIN tbltrans_tenants AS b ON a.tenantID = b.tenantID WHERE a.reportDate BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['DateTo'])) ."' ". $MallFilter . $TenantFilter . $StatFilter ." ORDER BY a.reportDate";
			$res = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($res)){

				if($row[2] == 1){
					$sales = "<i class='fa fa-check-circle' style='color: #3c763d;'></i>";
				}else{
					$sales = "<i class='fa fa-times-circle' style='color: #a94442;'></i>";
				}

				if($row[3] == 1){
					$discount = "<i class='fa fa-check-circle' style='color: #3c763d;'></i>";
				}else{
					$discount = "<i class='fa fa-times-circle' style='color: #a94442;'></i>";
				}

				if($row[4] == 1){
					$void = "<i class='fa fa-check-circle' style='color: #3c763d;'></i>";
				}else{
					$void = "<i class='fa fa-times-circle' style='color: #a94442;'></i>";
				}

				if($row[5] == 1){
					$perhour = "<i class='fa fa-check-circle' style='color: #3c763d;'></i>";
				}else{
					$perhour = "<i class='fa fa-times-circle' style='color: #a94442;'></i>";
				}

				if($row[6] == 1){
					$paymenttype = "<i class='fa fa-check-circle' style='color: #3c763d;'></i>";
				}else{
					$paymenttype = "<i class='fa fa-times-circle' style='color: #a94442;'></i>";
				}

				echo "	<tr>
							<td valign='top'>". date('m/d/Y', strtotime($row[0])) ."</td>
							<td>". $row[1] ."</td>
							<td style='text-align: center;z-index: 0;'>". $sales ."</td>
							<td style='text-align: center;z-index: 0;'>". $discount ."</td>
							<td style='text-align: center;z-index: 0;'>". $void ."</td>
							<td style='text-align: center;z-index: 0;'>". $perhour ."</td>
							<td style='text-align: center;z-index: 0;'>". $paymenttype ."</td>
						</tr>";
			}

			echo "|" . date('m/d/Y', strtotime($_POST['DateFrom'])) . "|" . date('m/d/Y', strtotime($_POST['DateTo']));
		break;
	}
?> 