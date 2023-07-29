<?php 
session_start();
include("../../connect.php");
	switch ($_POST['form']) {
		case 'showLMResevationList':
			$cnt_fltr = 0;
		    $sql_filter = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'LMreservation' ", $connection));
		    $trby = explode("|", $sql_filter["checked_value"]);
		    $stat = explode("|", $sql_filter["bystat"]);
		    $date = explode("|", $sql_filter["datefilter"]);
		    $filter = "";
		    // filter for status
		    $cnt = 0; $chk = "";
		    for($a = 0; $a<=count($stat)-1; $a++){
		      	if($stat[$a] == "Inquired"){ 
		      		$con = "a.Status = 'Inquired'"; 
		      	}else if($stat[$a] == "Approved"){ 
		      		$con = "a.Status = 'Approved'"; 
		      	}else if($stat[$a] == "Reserved"){ 
		      		$con = "a.Status = 'Reserved'"; 
		      	}else if($stat[$a] == "Occupied"){
		      		$con = "a.Status = 'Occupied'"; 
		      	}else if($stat[$a] == "Cancelled"){
		      		$con = "a.Status = 'Cancelled'"; 
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

		    if($sql_filter['xcheck'] == "chkappdate"){
				$date_fltr = "(a.Date_Inquired BETWEEN '".date("Y-m-d", strtotime($date[0]))."' AND '".date("Y-m-d", strtotime($date[1]))."')";
			}else if($sql_filter['xcheck'] == "chkoccdate"){
				$date_fltr = "(a.Date_Inquired BETWEEN '".date("Y-m-d", strtotime($date[2]))."' AND '".date("Y-m-d", strtotime($date[3]))."')";
			}
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
		       $filterselected = "WHERE ".$Stat_fltr . "".$and."" . "". $date_fltr . "".$and2."" . $by_fltr;

		       	$page = $_POST['page'];
				$limit = ($page-1) * 20;

				$sql = " SELECT b.mallname, a.Fullname, c.unitname, a.Mobile_No, a.EmailAddress, a.Status, a.Date_Inquired, a.InquiryID, a.ApplicationID, a.UnitID FROM tbltransleasing_inquiry AS a INNER JOIN tblref_mall AS b ON a.MallID = b.mallid INNER JOIN tblref_unit AS c ON a.UnitID = c.unitid ".$filterselected." LIMIT ".$limit.",20 ";
				$res = mysql_query($sql, $connection);
				while($row = mysql_fetch_array($res)){

					$bypasscount = 0;
					$rescheckoverride = mysql_query("SELECT DISTINCT(xinfo) FROM tbllogs_per_trans WHERE inqid = '". $row['InquiryID'] ."' AND xaction = 'Override' ", $connection);
					while($checkforoverride = mysql_fetch_array($rescheckoverride)){
						$arr1 = explode("|", $checkforoverride[0]);

						$checkavail = mysql_fetch_array(mysql_query("SELECT requirements FROM tblref_applicationrequirements WHERE override = '1' AND requirements = '". $arr1[2] ."' ", $connection));
						if($checkavail[0] != ""){
							$bypasscount++;
						}else{
							$bypasscount = 0;
						}
					}

					$reqcount = mysql_fetch_array(mysql_query("SELECT COUNT(requirements) FROM tblref_applicationrequirements ", $connection));
					$reqcountsuccess = mysql_fetch_array(mysql_query("SELECT COUNT(reqid) FROM tbltrans_leasingapplicationreq WHERE reqID = '". $row['InquiryID'] ."' ", $connection));

					if($reqcount[0] == $reqcountsuccess[0]){
						$reqstat = "<h6 style='color:green;margin-top:3px;'><i class='fa fa-check bigger-110'></i>&nbsp;&nbsp;Completed</h6>";
					}else{
						$reqstat = "<h6 style='color:orange;margin-top:3px;'><i class='fa fa-remove bigger-110'></i>&nbsp;&nbsp;Incomplete</h6>";
					}

					$totalreq = $reqcountsuccess[0] + $bypasscount;

					if($totalreq == $reqcount[0]){
						$req_status = "Complete";
					}else{
						$req_status = "Incomplete";
					}

					if($row['Status'] == "Inquired"){
						$status = "<span class='label label-light arrowed-in-right arrowed' style='color: black;'>Inquired</span>";
					}else if($row['Status'] == "Approved"){
						$status = "<span class='label label-success arrowed-in-right arrowed' style='color: black;'>Approved</span>";
					}else if($row['Status'] == "Cancelled"){
						$status = "<span class='label label-danger arrowed-in-right arrowed' style='color: black;'>Cancelled</span>";
					}else if($row['Status'] == "Reserved"){
						$status = "<span class='label label-primary arrowed-in-right arrowed' style='color: black;'>Reserved</span>";
					}else if($row['Status'] == "Occupied"){
						$status = "<span class='label label-warning arrowed-in-right arrowed' style='color: black;'>Occupied</span>";
					}

					$occupy = "<button class='btn btn-yellow btn-xs' title='Occupy Unit' onclick='editinquiry(\"". $row["InquiryID"] ."\", \"Occupy\", \"". $row["ApplicationID"] ."\", \"". $row["UnitID"] ."\");' style='margin: 1px;'><img src='assets/images/key.png' style='width: 100%; height: auto;'></button>";

					$confirm = "<button class='btn btn-success btn-xs' title='Confirm Reservation' onclick='editinquiry(\"". $row["InquiryID"] ."\", \"Confirm\", \"". $row["ApplicationID"] ."\", \"". $row["UnitID"] ."\");' style='margin: 1px;'><img src='assets/images/like.png' style='width: 100%; height: auto;'></button>";

					$edit = "<button class='btn btn-info btn-xs' title='Edit Application' onclick='editinquiry(\"". $row["InquiryID"] ."\", \"Edit\", \"". $row["ApplicationID"] ."\", \"". $row["UnitID"] ."\");' style='margin: 1px;'><img src='assets/images/edit.png' style='width: 100%; height: auto;'></button>";

					$reinstate = "<button class='btn btn-purple btn-xs' title='Reinstate Application' onclick='editinquiry(\"". $row["InquiryID"] ."\", \"Reinstate\", \"". $row["ApplicationID"] ."\", \"". $row["UnitID"] ."\");' style='margin: 1px;'><img src='assets/images/calendar.png' style='width: 100%; height: auto;'></button>";

					$view = "<button class='btn btn-default btn-xs' title='View Application' onclick='editinquiry(\"". $row["InquiryID"] ."\", \"View\", \"". $row["ApplicationID"] ."\", \"". $row["UnitID"] ."\");' style='margin: 1px;'><img src='assets/images/view.png' style='width: 100%; height: auto;'></button>";

					$cancel = "<button class='btn btn-danger btn-xs' title='Cancel Application / Reservation' onclick='editinquiry(\"". $row["InquiryID"] ."\", \"Cancel\", \"". $row["ApplicationID"] ."\", \"". $row["UnitID"] ."\");' style='margin: 1px;'><img src='assets/images/calendar2.png' style='width: 100%; height: auto;'></button>";

					if($row['Status'] == "Approved" && $req_status == "Incomplete"){
						$buttons = $edit.$cancel.$view;
					}else if($row['Status'] == "Approved" && $req_status == "Complete"){
						$buttons = $confirm.$cancel.$view;
					}else if($row['Status'] == "Cancelled"){
						$buttons = $reinstate.$view;
					}else if($row['Status'] == "Reserved"){
						$buttons = $occupy.$view;
					}else{
						$buttons = $view;
					}

					echo 	"
								<tr>
									<td width='7%'>".date('m/d/Y', strtotime($row['Date_Inquired']))."</td>
									<td>".$row['mallname']."</td>
									<td>".$row['Fullname']."</td>
									<td>".$row['unitname']."</td>
									<td>".$row['Mobile_No']."</td>
									<td>".$row['EmailAddress']."</td>
									<td width='8%'>".$status."</td>
									<td width='10%'>".$reqstat."</td>
									<td width='10%'>".$buttons."</td>
								</tr>
							";
				}
			}
		break;

		case 'loadentriesLMres':
			$cnt_fltr = 0;
		    $sql_filter = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'LMreservation' ", $connection));
		    $trby = explode("|", $sql_filter["checked_value"]);
		    $stat = explode("|", $sql_filter["bystat"]);
		    $date = explode("|", $sql_filter["datefilter"]);
		    $filter = "";
		    // filter for status
		    $cnt = 0; $chk = "";
		    for($a = 0; $a<=count($stat)-1; $a++){
		      	if($stat[$a] == "Inquired"){ 
		      		$con = "a.Status = 'Inquired'"; 
		      	}else if($stat[$a] == "Approved"){ 
		      		$con = "a.Status = 'Approved'"; 
		      	}else if($stat[$a] == "Reserved"){ 
		      		$con = "a.Status = 'Reserved'"; 
		      	}else if($stat[$a] == "Occupied"){
		      		$con = "a.Status = 'Occupied'"; 
		      	}else if($stat[$a] == "Cancelled"){
		      		$con = "a.Status = 'Cancelled'"; 
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

		    if($sql_filter['xcheck'] == "chkappdate"){
				$date_fltr = "(a.Date_Inquired BETWEEN '".date("Y-m-d", strtotime($date[0]))."' AND '".date("Y-m-d", strtotime($date[1]))."')";
			}else if($sql_filter['xcheck'] == "chkoccdate"){
				$date_fltr = "(a.Date_Inquired BETWEEN '".date("Y-m-d", strtotime($date[2]))."' AND '".date("Y-m-d", strtotime($date[3]))."')";
			}
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
		    }
		    else{
		      	$by_fltr = $chk3;
		    }

		    if($cnt3 > 0){
		      	$and2 = " AND ";
		    }
		    else{
		      	$and2 = "";
		    }

		    if($cnt > 0 ){
		       	$filterselected = "WHERE ".$Stat_fltr . "".$and."" . "". $date_fltr . "".$and2."" . $by_fltr;
		       	if($_POST["page"] == ""){
	               	$page = 1;
	           	}else{
	               	$page = $_POST["page"];
	           	}

		        $limit = ($page-1) * 20;

				$sql = " SELECT COUNT(a.MallID) FROM tbltransleasing_inquiry AS a INNER JOIN tblref_mall AS b ON a.MallID = b.mallid INNER JOIN tblref_unit AS c ON a.UnitID = c.unitid ".$filterselected." ";
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

		case 'loadpageLMres':
			$cnt_fltr = 0;
		    $sql_filter = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'LMreservation' ", $connection));
		    $trby = explode("|", $sql_filter["checked_value"]);
		    $stat = explode("|", $sql_filter["bystat"]);
		    $date = explode("|", $sql_filter["datefilter"]);
		    $filter = "";
		    // filter for status
		    $cnt = 0; $chk = "";
		    for($a = 0; $a<=count($stat)-1; $a++){
		      	if($stat[$a] == "Inquired"){ 
		      		$con = "a.Status = 'Inquired'"; 
		      	}else if($stat[$a] == "Approved"){ 
		      		$con = "a.Status = 'Approved'"; 
		      	}else if($stat[$a] == "Reserved"){ 
		      		$con = "a.Status = 'Reserved'"; 
		      	}else if($stat[$a] == "Occupied"){
		      		$con = "a.Status = 'Occupied'"; 
		      	}else if($stat[$a] == "Cancelled"){
		      		$con = "a.Status = 'Cancelled'"; 
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

		    if($sql_filter['xcheck'] == "chkappdate"){
				$date_fltr = "(a.Date_Inquired BETWEEN '".date("Y-m-d", strtotime($date[0]))."' AND '".date("Y-m-d", strtotime($date[1]))."')";
			}else if($sql_filter['xcheck'] == "chkoccdate"){
				$date_fltr = "(a.Date_Inquired BETWEEN '".date("Y-m-d", strtotime($date[2]))."' AND '".date("Y-m-d", strtotime($date[3]))."')";
			}
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
		       	$filterselected = "WHERE ".$Stat_fltr . "".$and."" . "". $date_fltr . "".$and2."" . $by_fltr;
				$page = $_POST["page"];
				$sqlb = " SELECT COUNT(a.MallID) FROM tbltransleasing_inquiry AS a INNER JOIN tblref_mall AS b ON a.MallID = b.mallid INNER JOIN tblref_unit AS c ON a.UnitID = c.unitid ".$filterselected." "; 	
				$aa = mysql_query($sqlb, $connection);
				$nums = mysql_fetch_row($aa);
				$num = $nums[0];
				
				$rowsperpage = 20;
				$range = 3;
				$totalpages = ceil($num / $rowsperpage);
				$prevpage;
				$nextpage;
				// if not on page 1, don't show back links
				if($page > 1 ){
				   echo "<li style='width:50px !important;' onclick='paginationLM(1)'><< First</li>";
				   $prevpage = $page - 1;
				   echo "<li style='width:70px !important;' onclick='paginationLM(". $prevpage .")'>< Previous</li>";
				}

				for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
				   if (($x > 0) && ($x <= $totalpages)){
	    			    if ($x == $page){
	                        echo "<li id='pgLMres" . $x . "' class='pgnumpLMres active' onclick='paginationLM(" . $x . ",". $x .")'>" . $x . "</li>";
	                    }else{
	    			        echo "<li id='pgLMres" . $x . "' class='pgnumpLMres' onclick='paginationLM(" . $x . ",". $x .")'>" . $x . "</li>";
	                    }
			       }
			    }
			    if($page < ($totalpages - $range)){
	                echo "<li>...</li>";
	            }

			    if ($page != $totalpages && $num != 0){
			       	$nextpage = $page + 1;
			       	echo "<li style='width:50px !important;' onclick='paginationLM(". $nextpage .", ". $nextpage .")'>Next ></li>";
			       	echo "<li style='width:50px !important;' onclick='paginationLM(". $totalpages .", ". $totalpages .")'>Last >></li>";
			    }
			}
		break;

		case 'showtxtLMinqcomp':
			echo "<option value=''>-- Select Company --</option>";
			$res = mysql_query("SELECT mallid, mallname FROM tblref_mall WHERE mallstat = '1' ", $connection);
			while($row = mysql_fetch_array($res)){
				echo "<option value='". $row[0] ."'>".$row[1]."</option>";
			}
		break;

		case 'showtxtLMinqclass':
			echo "<option value=''>-- Select Classification</option>";
			$res = mysql_query("SELECT classificationID, classification FROM tblref_merchandise_class", $connection);
			while($row = mysql_fetch_array($res)){
				echo "<option value='". $row[0] ."'>".$row[1]."</option>";
			}
		break;

		case 'showtxtLMinqdep':
			echo "<option value=''>-- Select Department</option>";
			$res = mysql_query("SELECT departmentID, department FROM tblref_merchandise_depa WHERE class_ID = '". $_POST['classification'] ."'", $connection);
			while($row = mysql_fetch_array($res)){
				echo "<option value='". $row[0] ."'>".$row[1]."</option>";
			}
		break;

		case 'showtxtLMinqcat':
			echo "<option value=''>-- Select Category</option>";
			$res = mysql_query("SELECT categoryID, category FROM tblref_merchandisedep_cat WHERE dept_ID = '". $_POST['dep'] ."'", $connection);
			while($row = mysql_fetch_array($res)){
				echo "<option value='". $row[0] ."'>".$row[1]."</option>";
			}
		break;

		case 'showtxtLMinqwing':
			echo "<option value=''>-- Select Wing</option>";
			$res = mysql_query("SELECT wingid, wing FROM tblref_wing WHERE mallid = '". $_POST['mallid'] ."'", $connection);
			while($row = mysql_fetch_array($res)){
				echo "<option value='". $row[0] ."'>".$row[1]."</option>";
			}
		break;

		case 'showtxtLMinqfloor':
			echo "<option value=''>-- Select Floor --</option>";
			if($_POST["classification"] != ""){
				$sql = "SELECT DISTINCT(floorid) FROM tblref_unit WHERE mallid = '". $_POST["mallid"] ."' AND wingid = '". $_POST['wing'] ."' AND classid = '". $_POST["classification"] ."' AND depid = '". $_POST['dep'] ."' AND catid = '". $_POST['cat'] ."'";
				$result = mysql_query($sql, $connection);
				while($row = mysql_fetch_array($result)){
					$flrs .= $row["floorid"] . "|";
				}
				$condition = "";
				$flrid = explode("|", $flrs);
				for($i=0; $i<=count($flrid)-2; $i++){
					if($i == 0){
						$condition .= " WHERE floorid = '".$flrid[$i]."' ";
					}else{
						$condition .= " OR floorid = '".$flrid[$i]."' ";
					}
				}
			}else{
				$condition = "";
			}
			if($condition != ""){
				$queryflr = "SELECT floorid, floor FROM tblref_floorsetup ".$condition;
	        	$result_flr = mysql_query($queryflr, $connection);
				while($row = mysql_fetch_array($result_flr)){
					echo "<option value='".$row["floorid"]."'>".$row["floor"]."</option>";
				}
			}
		break;

		case 'showtxtLMinqunit':
			echo "<option value=''>-- Select Unit</option>";
			$res = mysql_query("SELECT unitid, unitname FROM tblref_unit WHERE mallid = '". $_POST['mallid'] ."' AND wingid = '". $_POST['wing'] ."' AND classid = '". $_POST['classification'] ."' AND depid = '". $_POST['dep'] ."' AND catid = '". $_POST['cat'] ."' AND floorid = '". $_POST['floorid'] ."' AND stats = 'vacant' ", $connection);
			while($row = mysql_fetch_array($res)){
				echo "<option value='". $row[0] ."'>".$row[1]."</option>";
			}
		break;

		case 'showtxtLMinqunitinfo':
			$unitinfo = mysql_fetch_array(mysql_query("SELECT sqmunitsetup, pricepersqmunitsetup, totalamountunitsetup, assocdues, mallid FROM tblref_unit WHERE unitid = '". $_POST['unitid'] ."' ", $connection));
			
			$totalmonthly = $unitinfo[3] + $unitinfo[2];
			echo $unitinfo[0] . "|" . number_format($unitinfo[1], '2', '.', ',') . "|" . number_format($unitinfo[2], '2', '.', ',') . "|" . number_format($unitinfo[3], '2', '.', ',');
		break;

		case 'showdateto':
			$mallsetup = mysql_fetch_array(mysql_query("SELECT spotperc, downperc, balanceperc, promo_disc, company_disc, standard_disc, reg_fee, doc_tax, trans_tax, legal_fee, WE_connection, misc_fee, vat_rent_type, vat_penalty_prcnt, typeofreservationfee, reservationfee, typeofretentionfee, retentionfee FROM mall_setup WHERE mall_id = '". $_POST['mallid'] ."'", $connection));

			$refDate = $_POST["dateFrom"];
			
				for ($x=1; $x<=$_POST['count']; $x++){
					$refDate = date( 'm/d/Y', strtotime($refDate . '+1 month') );
				}

			// List Price
			$totalmonthly = ($_POST['monthly'] + $_POST['assocdue']) * $_POST['count'];

			//Promo Discount
			$promodiscount = ($totalmonthly / 100) * $mallsetup['promo_disc'];
			$companydiscount = ($totalmonthly / 100) * $mallsetup['company_disc'];
			$standarddiscount = ($totalmonthly / 100) * $mallsetup['standard_disc'];
			$totaldiscount = $promodiscount + $companydiscount + $standarddiscount;

			// VAT
			if($mallsetup['vat_rent_type'] == "inc"){
				$vatamount = ($totalmonthly /100 ) * $mallsetup['vat_penalty_prcnt'];
				$vat = $totalmonthly - $vatamount;
				$totalcontractprice = $totalmonthly - $totaldiscount;
			}else if($mallsetup[12] == "exc"){
				$vatamount = ($totalmonthly /100 ) * $mallsetup['vat_penalty_prcnt'];
				$vat = $totalmonthly + $vatamount;
				$totalcontractprice = $vat - $totaldiscount;
			}

			// Other Charges
			$registrationfee = ($totalmonthly / 100) * $mallsetup['reg_fee'];
			$documentarytax = ($totalmonthly / 100) * $mallsetup['doc_tax'];
			$transfertax = ($totalmonthly / 100) * $mallsetup['trans_tax'];
			$legalfees = ($totalmonthly / 100) * $mallsetup['legal_fee'];
			$weconnection = ($totalmonthly / 100) * $mallsetup['WE_connection'];
			$miscfee = ($totalmonthly / 100) * $mallsetup['misc_fee'];
			$othercharges = $registrationfee + $documentarytax + $transfertax + $weconnection + $miscfee;

			// Total Amount Payable
			$totalamountpayable = $totalcontractprice + $othercharges;

			// Spot Down Payment
			$spotdownpayment = ($totalamountpayable / 100) * $mallsetup['spotperc'];

			// Net Down Payment
			$netdownpayment = ($totalamountpayable / 100) * $mallsetup['downperc'];

			// Balance
			$balance = ($totalamountpayable / 100) * $mallsetup['balanceperc'];

			// Reservation Fee
			if($mallsetup['typeofreservationfee'] == "Percent"){
				$reservationfee = ($spotdownpayment / 100) * $mallsetup['reservationfee'];
			}else{
				$reservationfee = $mallsetup['reservationfee'];
			}

			// Retention Fee
			if($mallsetup['typeofretentionfee'] == "Percent"){
				$retentionfee = ($spotdownpayment / 100) * $mallsetup['retentionfee'];
			}else{
				$retentionfee = $mallsetup['retentionfee'];
			}

			// Net Spot Payment
			$netspotpayment = $spotdownpayment - ($reservationfee + $retentionfee);

			echo $refDate . "|" . number_format($totalmonthly, '2', '.', ',') . "|" . number_format($promodiscount, '2', '.', ',') . "|" . number_format($companydiscount, '2', '.', ',') . "|" . number_format($standarddiscount, '2', '.', ',') . "|" . number_format($totaldiscount, '2', '.', ',') . "|" . number_format($vatamount, '2', '.', ',') . "|" . number_format($totalcontractprice, '2', '.', ',') . "|" . number_format($othercharges, '2', '.', ',') . "|" . number_format($totalamountpayable, '2', '.', ',') . "|" . number_format($spotdownpayment, '2', '.', ',') . "|" . number_format($netdownpayment, '2', '.', ',') . "|" . number_format($balance, '2', '.', ',') . "|" . number_format($reservationfee, '2', '.', ',') . "|" . number_format($retentionfee, '2', '.', ',') . "|" . number_format($netspotpayment, '2', '.', ',');

		break;

		case 'quickselect':
			$page = $_POST['page'];
			$limit = ($page-1) * 10;
			$res = mysql_query(" SELECT b.mallname, c.classification, d.department, e.category, f.wing, g.floor, a.unitname, a.mallid, a.classid, a.depid, a.catid, a.wingid, a.floorid, a.unitid FROM tblref_unit AS a INNER JOIN tblref_mall AS b ON a.mallid = b.mallid INNER JOIN tblref_merchandise_class AS c ON a.classid = c.classificationID INNER JOIN tblref_merchandise_depa AS d ON a.depid = d.departmentID INNER JOIN tblref_merchandisedep_cat AS e ON a.catid = e.categoryID INNER JOIN tblref_wing AS f ON a.wingid = f.wingid INNER JOIN tblref_floorsetup AS g ON a.floorid = g.floorid WHERE status = 'vacant' AND unitstat ='1' AND ( b.mallname LIKE '%". $_POST['key'] ."%' OR c.classification LIKE '%". $_POST['key'] ."%' OR d.department LIKE '%". $_POST['key'] ."%' OR e.category LIKE '%". $_POST['key'] ."%' OR f.wing LIKE '%". $_POST['key'] ."%' OR g.floor LIKE '%". $_POST['key'] ."%' OR a.unitname LIKE '%". $_POST['key'] ."%' ) LIMIT ".$limit.",10 ", $connection);
			while($row = mysql_fetch_array($res)){
				echo 	"
							<tr onclick='thechosen(\"".$row['mallid']."\", \"".$row['classid']."\", \"".$row['depid']."\", \"".$row['catid']."\", \"".$row['wingid']."\", \"".$row['floorid']."\", \"".$row['unitid']."\");'>
								<td>".$row['mallname']."</td>
								<td>".$row['classification']."</td>
								<td>".$row['department']."</td>
								<td>".$row['category']."</td>
								<td>".$row['wing']."</td>
								<td>".$row['floor']."</td>
								<td>".$row['unitname']."</td>
							</tr>
						";
			}
		break;

		case 'loadentriesquickselect':
			if($_POST["page"] == ""){
               	$page = 1;
           	}else{
               	$page = $_POST["page"];
           	}

	        $limit = ($page-1) * 10;
			$sql = " SELECT COUNT(b.mallname) FROM tblref_unit AS a INNER JOIN tblref_mall AS b ON a.mallid = b.mallid INNER JOIN tblref_merchandise_class AS c ON a.classid = c.classificationID INNER JOIN tblref_merchandise_depa AS d ON a.depid = d.departmentID INNER JOIN tblref_merchandisedep_cat AS e ON a.catid = e.categoryID INNER JOIN tblref_wing AS f ON a.wingid = f.wingid INNER JOIN tblref_floorsetup AS g ON a.floorid = g.floorid WHERE status = 'vacant' AND unitstat ='1' AND ( b.mallname LIKE '%". $_POST['key'] ."%' OR c.classification LIKE '%". $_POST['key'] ."%' OR d.department LIKE '%". $_POST['key'] ."%' OR e.category LIKE '%". $_POST['key'] ."%' OR f.wing LIKE '%". $_POST['key'] ."%' OR g.floor LIKE '%". $_POST['key'] ."%' OR a.unitname LIKE '%". $_POST['key'] ."%' ) ";
            $result = mysql_query($sql, $connection);
            $row = mysql_fetch_array($result);

            $rowsperpage = 10;
            $totalpages = ceil($row[0] / $rowsperpage);
            $upto = $limit + 10;
            $from = $limit + 1;
            if($page == $totalpages && $row[0] != 0){
                 echo "Showing " . $from . " to " . $row[0] . " of " . $row[0] . " entries";
            }else{
                if($row[0] == 0){
                   	echo "";
                }else if($row[0] <= 9 && $row[0] != 0){
                   	echo "Showing 1 to " . $row[0] . " of " . $row[0] . " entries";
                }else if($row[0] >= 10 && $row[0] != 0){
                   	echo "Showing " . $from . " to " . $upto . " of " . $row[0] . " entries";
                }
            }
		break;

		case 'loadpagequickselect':
			$page = $_POST["page"];
			$sqlb = " SELECT COUNT(b.mallname) FROM tblref_unit AS a INNER JOIN tblref_mall AS b ON a.mallid = b.mallid INNER JOIN tblref_merchandise_class AS c ON a.classid = c.classificationID INNER JOIN tblref_merchandise_depa AS d ON a.depid = d.departmentID INNER JOIN tblref_merchandisedep_cat AS e ON a.catid = e.categoryID INNER JOIN tblref_wing AS f ON a.wingid = f.wingid INNER JOIN tblref_floorsetup AS g ON a.floorid = g.floorid WHERE status = 'vacant' AND unitstat ='1' AND ( b.mallname LIKE '%". $_POST['key'] ."%' OR c.classification LIKE '%". $_POST['key'] ."%' OR d.department LIKE '%". $_POST['key'] ."%' OR e.category LIKE '%". $_POST['key'] ."%' OR f.wing LIKE '%". $_POST['key'] ."%' OR g.floor LIKE '%". $_POST['key'] ."%' OR a.unitname LIKE '%". $_POST['key'] ."%' ) "; 	
			$aa = mysql_query($sqlb, $connection);
			$nums = mysql_fetch_row($aa);
			$num = $nums[0];
			
			$rowsperpage = 10;
			$range = 3;
			$totalpages = ceil($num / $rowsperpage);
			$prevpage;
			$nextpage;
			// if not on page 1, don't show back links
			if($page > 1 ){
			   	echo "<li style='width:50px !important;' onclick='paginationquickselect(1)'><< First</li>";
			   	$prevpage = $page - 1;
			   	echo "<li style='width:70px !important;' onclick='paginationquickselect(". $prevpage .")'>< Previous</li>";
			}

			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if (($x > 0) && ($x <= $totalpages)){
    			    if ($x == $page){
                        echo "<li id='pgquickselect" . $x . "' class='pgnumquickselect active' onclick='paginationquickselect(" . $x . ",". $x .")'>" . $x . "</li>";
                    }else{
    			        echo "<li id='pgquickselect" . $x . "' class='pgnumquickselect' onclick='paginationquickselect(" . $x . ",". $x .")'>" . $x . "</li>";
                    }
		       	}
		    }
		    if($page < ($totalpages - $range)){
                echo "<li>...</li>";
            }

		    if ($page != $totalpages && $num != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='paginationquickselect(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='paginationquickselect(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'thechosen':
			$classification = '<option value="">-- Select Classification --</option>';
			$resclass = mysql_query("SELECT classificationID, classification FROM tblref_merchandise_class", $connection);
			while($rowclassification = mysql_fetch_array($resclass)){
				$classification .= "<option value='". $rowclassification['classificationID'] ."'>". $rowclassification['classification'] ."</option>";
			}

			$dep = '<option value="">-- Select Department --</option>';
			$querydep = "SELECT departmentID, department FROM tblref_merchandise_depa WHERE class_ID = '".$_POST['classification']."' ";
            $result_dep = mysql_query($querydep, $connection);
			while($rowdep = mysql_fetch_array($result_dep)){
				$dep .= "<option value='".$rowdep['departmentID']."'>".$rowdep['department']."</option>";
			}

            $cat = '<option value="">-- Select Category --</option>';
            $querycat = "SELECT categoryID, category FROM tblref_merchandisedep_cat WHERE dept_ID = '".$_POST['department']."' ";
            $result_cat = mysql_query($querycat, $connection);
            while($rowcat = mysql_fetch_array($result_cat)){
                $cat .= "<option value='".$rowcat['categoryID']."'>".$rowcat['category']."</option>";
            }

            $wing = '<option value="">-- Select Wing --</option>';
            $querywing = "SELECT wingID, wing FROM tblref_wing WHERE mallID = '".$_POST['mall']."' ";
            $result_wing = mysql_query($querywing, $connection);
            while($rowwing = mysql_fetch_array($result_wing)){
                $wing .= "<option value='".$rowwing["wingID"]."'>".$rowwing["wing"]."</option>";
            }

            $floor = '<option value="">-- Select Floor --</option>';
            $queryflr = "SELECT floorid, floor FROM tblref_floorsetup WHERE floorid = '".$_POST['floor']."' ";
        	$result_flr = mysql_query($queryflr, $connection);
			while($rowflr = mysql_fetch_array($result_flr)){
				$floor .= "<option value='".$rowflr["floorid"]."'>".$rowflr["floor"]."</option>";
			}

            $unit = '<option value="">-- Select Unit --</option>';
            $queryunit = "SELECT unitid, unitname FROM tblref_unit WHERE mallid = '". $_POST['mall'] ."' AND wingid = '". $_POST['wing'] ."' AND classid = '". $_POST['classification'] ."' AND depid = '". $_POST['department'] ."' AND catid = '". $_POST['category'] ."' AND floorid = '". $_POST['floor'] ."'";
        	$result_unit = mysql_query($queryunit, $connection);
			while($rowunit = mysql_fetch_array($result_unit)){
				$unit .= "<option value='".$rowunit["unitid"]."'>".$rowunit["unitname"]."</option>";
			}

            $unitinfo = mysql_fetch_array(mysql_query("SELECT sqmunitsetup, pricepersqmunitsetup, totalamountunitsetup, assocdues, mallid FROM tblref_unit WHERE unitid = '".$_POST['unit']."'"));

            echo $classification . "|" . $dep . "|" . $cat . "|" . $wing . "|" . $floor . "|" . $unit . "|" . $unitinfo[0] . "|" . number_format($unitinfo[1], '2', '.', ',') . "|" . number_format($unitinfo[2], '2', '.', ',') . "|" . number_format($unitinfo[3], '2', '.', ',');
		break;

		case 'selected_unit_amenities':
			$sql = "SELECT amenitiesID FROM tblref_unit_amenities WHERE unitID = '".$_POST["unit"]."'";
			$result = mysql_query($sql, $connection);
			$cnt = mysql_num_rows($result);
			if($cnt > 0){
				echo '<div class="alert alert-info"><table><tr><td><h4 class="blue smaller lighter">Amenities</h4></td></tr>';
			}
			while($row = mysql_fetch_array($result)){
				$sql2 = "SELECT amenitiesname FROM tblref_amenities WHERE amenitiesid = '".$row["amenitiesID"]."'";
				$result2 = mysql_query($sql2, $connection);
				$row2 = mysql_fetch_array($result2);
				if($row2["amenitiesname"] != ""){
					echo "<tr>
							<td>
							<div class='checkbox' style='margin:3px;'>
									<label>
										<i class='ace-icon fa fa-check'></i>&nbsp;&nbsp;
										<span class='lbl'> &nbsp;&nbsp;&nbsp;".$row2["amenitiesname"]."</span>
									</label>
								</div>
							</td>
						</tr>";
				}
			}
			if($cnt > 0){
				echo '</table></div>';
			}
			if($cnt == 0){
				echo '<div class="alert alert-info"><table><tr><td><h4 class="blue smaller lighter">This unit has no amenities included.</h4></td></tr></table></div>';
			}
		break;

		case 'showallpercentage':
			$UPBsetup = mysql_fetch_array(mysql_query("SELECT spotperc, downperc, balanceperc, promo_disc, company_disc, standard_disc, reg_fee, doc_tax, trans_tax, legal_fee, WE_connection, misc_fee, vat_rent_prcnt, vat_rent_type FROM mall_setup WHERE mall_id = '". $_POST['mallid'] ."'", $connection));

			if($UPBsetup[13] == "inc"){
				$vattype = " Inclusive VAT";
			}else if($UPBsetup[13] == "exc"){
				$vattype = " Exclusive VAT";
			}

			if($UPBsetup[0] == ""){
				$SpotPayment = "";
			}else{
				$SpotPayment = $UPBsetup[0] . "%";
			}

			if($UPBsetup[1] == ""){
				$DownPayment = "";
			}else{
				$DownPayment = $UPBsetup[1] . "%";
			}

			if($UPBsetup[2] == ""){
				$Balance = "";
			}else{
				$Balance = $UPBsetup[2] . "%";
			}

			if($UPBsetup[3] == ""){
				$PromoDiscount = "";
			}else{
				$PromoDiscount = $UPBsetup[3] . "%";
			}

			if($UPBsetup[4] == ""){
				$CompanyDiscount = "";
			}else{
				$CompanyDiscount = $UPBsetup[4] . "%";
			}

			if($UPBsetup[5] == ""){
				$StandardDiscount = "";
			}else{
				$StandardDiscount = $UPBsetup[5] . "%";
			}

			if($UPBsetup[12] == ""){
				$VAT = $vattype;
			}else{
				$VAT = "<label style='color: red;'>". $UPBsetup[12] . "%</label>" . $vattype;
			}

			echo $SpotPayment . "|" . $DownPayment . "|" . $Balance . "|" . $PromoDiscount . "|" . $CompanyDiscount . "|" . $StandardDiscount . "|" . $VAT;
		break;

		case 'saveLMinquiry':
	       	$InqPref = mysql_fetch_array(mysql_query("SELECT inqprefix FROM tblsys_setup", $connection));
			if($_POST['id'] == ""){
				$inquiryid = createidno($InqPref['inqprefix'], "tbltransleasing_inquiry", "InquiryID");
				$sql = "INSERT INTO tbltransleasing_inquiry SET InquiryID = '". $inquiryid ."', Date_Inquired = '". date('Y-m-d') ."', MallID = '". $_POST['Mall'] ."', WingID = '". $_POST['Wing'] ."', FloorID = '". $_POST['Floor'] ."', UnitID = '". $_POST['Unit'] ."', ClassificationID = '". $_POST['Classification'] ."', DepartmentID = '". $_POST['Department'] ."', CategoryID = '". $_POST['Category'] ."', First_Name = '". $_POST['FirstName'] ."', Middle_Name = '". $_POST['MiddleName'] ."', Last_Name = '". $_POST['LastName'] ."', Fullname = '". $_POST['FirstName'] ." " . $_POST['MiddleName'][0] . ". " .$_POST['LastName']. "', Gender = '". $_POST['Gender'] ."', Birthdate = '". date('Y-m-d', strtotime($_POST['Birthdate'])) ."', Civil_Status = '". $_POST['CivilStatus'] ."', Telephone_No = '". $_POST['Telephone'] ."', Mobile_No = '". $_POST['Mobile'] ."', EmailAddress = '". $_POST['EmailAddress'] ."', TIN = '". $_POST['TIN'] ."', Occupation = '". $_POST['Occupation'] ."', Citizenship = '". $_POST['Citizenship'] ."', Address = '". $_POST['Address'] ."', City = '". $_POST['City'] ."', Country = '". $_POST['Country'] ."', ZipCode = '". $_POST['ZipCode'] ."', Unit_Area = '". str_replace(",", "", $_POST['UnitArea']) ."', Price_Per_SQM = '". str_replace(",", "", $_POST['PricePerSQM']) ."', MonthlyDue = '". str_replace(",", "", $_POST['MonthlyDue']) ."', AssociationDue = '". str_replace(",", "", $_POST['AssociationDue']) ."', OccupancyDateFrom = '". date('Y-m-d', strtotime($_POST['OccupanyDateFrom'])) ."', OccupancyDateTo = '". date('Y-m-d', strtotime($_POST['OccupanyDateTo'])) ."', OccupancyMonthCount = '". $_POST['NoOfMonths'] ."', ListPrice = '". str_replace(",", "", $_POST['ListPrice']) ."', PromoDiscount = '". str_replace(",", "", $_POST['PromoDiscount']) ."', CompanyDiscount = '". str_replace(",", "", $_POST['CompanyDiscount']) ."', SpotDownPayment = '". str_replace(",", "", $_POST['SpotDownPayment']) ."', SpotDownPaymentDue = '". date('Y-m-d', strtotime($_POST['SpotDownPaymentDue'])) ."', ReservationFee = '". str_replace(",", "", $_POST['ReservationFee']) ."', ReservationFeeDue = '". date('Y-m-d', strtotime($_POST['ReservationFeeDue'])) ."', RetentionFee = '". str_replace(",", "", $_POST['RetentionFee']) ."', NetSpotPayment = '". str_replace(",", "", $_POST['NetSpotPayment']) ."', NetDownPayment = '". str_replace(",", "", $_POST['NetDownPayment']) ."', AmortNoOfMonths = '". $_POST['AmortNoOfMonths'] ."', AmortStartDate = '". date('Y-m-d', strtotime($_POST['AmortStartDate'])) ."', MonthlyAmort = '". str_replace(",", "", $_POST['MonthlyAmort']) ."', Balance = '". str_replace(",", "", $_POST['Balance']) ."', PaymentType = '". $_POST['PaymentType'] ."', ValidityOfPaymentScheme = '". date('Y-m-d', strtotime($_POST['ValidityOfPaymentScheme'])) ."', PaymentScheme = '". $_POST['PaymentScheme'] ."', SourceOfSale = '". $_POST['SourceOfSale'] ."', Reason4Buying = '". $_POST['Reason4Buying'] ."', TermsAndCondition = '". $_POST['Termids'] ."', UserID = '". $_SESSION['MMS-UserID'] ."', xdate = '". date('Y-m-d') ."', xtime = '". date('H:i:s') ."' ";
				$res = mysql_query($sql, $connection);
				if($res == true){
					echo "1|Inquiry successully saved.";
					$contact = explode("#", $_POST['ContactList']);
					for ($a=0; $a <= COUNT($contact)-2; $a++) { 
						$list = explode("|", $contact[$a]);
						$insertcontact = mysql_query("INSERT INTO tbltransleasing_contactlist SET InquiryID = '". $inquiryid ."', FirstName = '". $list[0] ."', MiddleName = '". $list[1] ."', LastName = '". $list[2] ."', CompanyPosition = '". $list[6] ."', Address = '". $list[3] ."', EmailAddress = '". $list[4] ."', MobileNo = '". $list[5] ."', TelephoneNo = '". $list[7] ."', xdate = '". date('Y-m-d') ."', xtime = '". date('H:i:s') ."'", $connection);
					}
				}else{
					echo "2|An error has occured while saving your inquiry.";
				}
			}else{
				$sql = "UPDATE tbltransleasing_inquiry SET MallID = '". $_POST['Mall'] ."', WingID = '". $_POST['Wing'] ."', FloorID = '". $_POST['Floor'] ."', UnitID = '". $_POST['Unit'] ."', ClassificationID = '". $_POST['Classification'] ."', DepartmentID = '". $_POST['Department'] ."', CategoryID = '". $_POST['Category'] ."', First_Name = '". $_POST['FirstName'] ."', Middle_Name = '". $_POST['MiddleName'] ."', Last_Name = '". $_POST['LastName'] ."', Fullname = '". $_POST['FirstName'] ." " . $_POST['MiddleName'][0] . ". " .$_POST['LastName']. "', Gender = '". $_POST['Gender'] ."', Birthdate = '". date('Y-m-d', strtotime($_POST['Birthdate'])) ."', Civil_Status = '". $_POST['CivilStatus'] ."', Telephone_No = '". $_POST['Telephone'] ."', Mobile_No = '". $_POST['Mobile'] ."', EmailAddress = '". $_POST['EmailAddress'] ."', TIN = '". $_POST['TIN'] ."', Occupation = '". $_POST['Occupation'] ."', Citizenship = '". $_POST['Citizenship'] ."', Address = '". $_POST['Address'] ."', City = '". $_POST['City'] ."', Country = '". $_POST['Country'] ."', ZipCode = '". $_POST['ZipCode'] ."', Unit_Area = '". str_replace(",", "", $_POST['UnitArea']) ."', Price_Per_SQM = '". str_replace(",", "", $_POST['PricePerSQM']) ."', MonthlyDue = '". str_replace(",", "", $_POST['MonthlyDue']) ."', AssociationDue = '". str_replace(",", "", $_POST['AssociationDue']) ."', OccupancyDateFrom = '". date('Y-m-d', strtotime($_POST['OccupanyDateFrom'])) ."', OccupancyDateTo = '". date('Y-m-d', strtotime($_POST['OccupanyDateTo'])) ."', OccupancyMonthCount = '". $_POST['NoOfMonths'] ."', ListPrice = '". str_replace(",", "", $_POST['ListPrice']) ."', PromoDiscount = '". str_replace(",", "", $_POST['PromoDiscount']) ."', CompanyDiscount = '". str_replace(",", "", $_POST['CompanyDiscount']) ."', SpotDownPayment = '". str_replace(",", "", $_POST['SpotDownPayment']) ."', SpotDownPaymentDue = '". date('Y-m-d', strtotime($_POST['SpotDownPaymentDue'])) ."', ReservationFee = '". str_replace(",", "", $_POST['ReservationFee']) ."', ReservationFeeDue = '". date('Y-m-d', strtotime($_POST['ReservationFeeDue'])) ."', RetentionFee = '". str_replace(",", "", $_POST['RetentionFee']) ."', NetSpotPayment = '". str_replace(",", "", $_POST['NetSpotPayment']) ."', NetDownPayment = '". str_replace(",", "", $_POST['NetDownPayment']) ."', AmortNoOfMonths = '". $_POST['AmortNoOfMonths'] ."', AmortStartDate = '". date('Y-m-d', strtotime($_POST['AmortStartDate'])) ."', MonthlyAmort = '". str_replace(",", "", $_POST['MonthlyAmort']) ."', Balance = '". str_replace(",", "", $_POST['Balance']) ."', PaymentType = '". $_POST['PaymentType'] ."', ValidityOfPaymentScheme = '". date('Y-m-d', strtotime($_POST['ValidityOfPaymentScheme'])) ."', PaymentScheme = '". $_POST['PaymentScheme'] ."', SourceOfSale = '". $_POST['SourceOfSale'] ."', Reason4Buying = '". $_POST['Reason4Buying'] ."', TermsAndCondition = '". $_POST['Termids'] ."', UserID = '". $_SESSION['MMS-UserID'] ."', xdate = '". date('Y-m-d') ."', xtime = '". date('H:i:s') ."' WHERE InquiryID = '". $_POST['id'] ."' ";
				$res = mysql_query($sql, $connection);
				if($res == true){
					echo "1|Inquiry successully updated.";
					$deletecontactlistfirst = mysql_query("DELETE FROM tbltransleasing_contactlist WHERE InquiryID = '". $_POST['id'] ."' ", $connection);
					if($deletecontactlistfirst == true){
						$contact = explode("#", $_POST['ContactList']);
						for ($a=0; $a <= COUNT($contact)-2; $a++) { 
							$list = explode("|", $contact[$a]);
							$insertcontact = mysql_query("INSERT INTO tbltransleasing_contactlist SET InquiryID = '". $_POST['id'] ."', FirstName = '". $list[0] ."', MiddleName = '". $list[1] ."', LastName = '". $list[2] ."', CompanyPosition = '". $list[6] ."', Address = '". $list[3] ."', EmailAddress = '". $list[4] ."', MobileNo = '". $list[5] ."', TelephoneNo = '". $list[7] ."', xdate = '". date('Y-m-d') ."', xtime = '". date('H:i:s') ."'", $connection);
						}
					}
				}else{
					echo "2|An error has occured while saving your inquiry.";
				}
			}
		break;

		case 'cancelLMappres':
			$res = mysql_query("UPDATE tbltransleasing_inquiry SET Status = 'Cancelled', Date_Dissapproved = '". date('Y-m-d') ."' WHERE InquiryID = '". $_POST['id'] ."' ", $connection);
			if($res == true){
				$unit = mysql_query("UPDATE tblref_unit SET status = 'Vacant', TenantID = '', TenantName = '', StartDate = '00-00-0000', EndDate = '00-00-0000' WHERE unitid = '". $_POST['unitid'] ."'", $connection);
				$unitlogs = mysql_query("DELETE FROM tblunit_statuslogs WHERE unitid = '". $_POST['unitid'] ."' ", $connection);
			}
		break;

		case 'reinstateLMappres':
			$res = mysql_query("UPDATE tbltransleasing_inquiry SET Status = 'Approved' WHERE InquiryID = '". $_POST['id'] ."' ", $connection);
		break;

		case 'confirmreservationLMappres':
			$inquiry = mysql_fetch_array(mysql_query("SELECT OccupancyDateFrom, OccupancyDateTo FROM tbltransleasing_inquiry WHERE InquiryID = '". $_POST['id'] ."'", $connection));
			$unitinfo = mysql_fetch_array(mysql_query("SELECT unitname FROM tblref_unit WHERE unitid = '". $_POST['unitid'] ."'", $connection));
			$res = mysql_query("UPDATE tbltransleasing_inquiry SET Status = 'Reserved' WHERE InquiryID = '". $_POST['id'] ."' ", $connection);
			if($res == true){

				$unit = mysql_query("UPDATE tblref_unit SET status = 'Reserved', TenantID = '', TenantName = '', StartDate = '". $inquiry[0] ."', EndDate = '". $inquiry[1] ."' WHERE unitid = '". $_POST['unitid'] ."'", $connection);

					$days = (strtotime($inquiry["OccupancyDateTo"]) - strtotime($inquiry["OccupancyDateFrom"])) / (60 * 60 * 24);
					$refDate = $inquiry["OccupancyDateFrom"];
					for ($x=1; $x<=$days+1; $x++){
						$refDate = date( 'Y-m-d', strtotime($refDate) );
						$selectlogs = "SELECT COUNT(*) FROM tblunit_statuslogs WHERE unitid = '".$_POST["unitid"]."' AND xdate = '".$refDate."'";
						$resultlogs = mysql_query($selectlogs, $connection);
						$logs = mysql_fetch_array($resultlogs);
						if($logs[0] == 0){

							$inserunitlogs = "INSERT INTO tblunit_statuslogs SET unitid = '". $_POST['unitid'] ."', unitname = '". $unitinfo[0] ."', xdate = '". $refDate ."', xtime = '". date('H:i:s') ."', status = 'Reserved' ";
							$result_logs = mysql_query($inserunitlogs);
						}else{
							$inserunitlogs = "UPDATE tblunit_statuslogs SET unitid = '". $_POST['unitid'] ."', unitname = '". $unitinfo[0] ."', xdate = '". $refDate ."', xtime = '". date('H:i:s') ."', status = 'Reserved' WHERE unitid = '". $_POST['unitid'] ."' AND xdate = '". $refDate ."' ";
							$result_logs = mysql_query($inserunitlogs);
						}
						$refDate = date( 'Y-m-d', strtotime($refDate . '+1 day') );
					}

			}
		break;

		case 'occupyLMappres':
			$inquiry = mysql_fetch_array(mysql_query("SELECT OccupancyDateFrom, OccupancyDateTo, OccupancyMonthCount, Fullname, MallID, First_Name, Middle_Name, Last_Name, ApplicationID, InquiryID, UnitID, TermsAndCondition, PaymentType FROM tbltransleasing_inquiry WHERE InquiryID = '". $_POST['id'] ."'", $connection));
			$unitinfo = mysql_fetch_array(mysql_query("SELECT unitname FROM tblref_unit WHERE unitid = '". $_POST['unitid'] ."'", $connection));
			$res = mysql_query("UPDATE tbltransleasing_inquiry SET Status = 'Occupied' WHERE InquiryID = '". $_POST['id'] ."' ", $connection);
			if($res == true){

				$tenantid = createidno("TENANT", "tbltrans_tenants", "TenantID");
				$contractid = createidno("CONTRACT", "tblcontract", "ContractID");

				$inserttenant = mysql_query("INSERT INTO tbltrans_tenants SET TenantID = '". $tenantid ."', mallID = '". $inquiry['MallID'] ."', owner_lastname = '". $inquiry['Last_Name'] ."', owner_firstname = '". $inquiry['First_Name'] ."', owner_midname = '". $inquiry['Middle_Name'] ."', appID = '". $inquiry['ApplicationID'] ."', inqID = '". $inquiry['InquiryID'] ."',tradename = '". $inquiry['Fullname'] ."', unitID = '". $inquiry['UnitID'] ."', unitname = '". $unitinfo[0] ."', datefrom = '". date('Y/m/d', strtotime($inquiry['OccupancyDateFrom'])) ."', dateto = '". date('Y/m/d', strtotime($inquiry['OccupancyDateTo'])) ."', Status = 'Active', noofmonths = '". $inquiry['OccupancyMonthCount'] ."', ustatus = 'Occupied', ContractID = '". $contractid ."', payment_type = '". $inquiry['PaymentType'] ."' ");

				$termsandconlist = explode("|", $inquiry['TermsAndCondition']);
				for ($i=0; $i <= count($termsandconlist)-2; $i++) { 
					$selectby1 = mysql_fetch_array(mysql_query("SELECT Group_Name, Term_Name, Description FROM tblcondition WHERE Term_ID = '". $termsandconlist[$i] ."' ", $connection));
					$gname .= $selectby1[0]."|";
					$tname .= $selectby1[1]."|";
					$cond .= $selectby1[2]."|";
				}
				$insertcontract = mysql_query("INSERT INTO tblcontract SET ContractID = '". $contractid ."', MallID = '". $inquiry['MallID'] ."', InquiryID = '". $inquiry['InquiryID'] ."', TenantID = '". $tenantid ."', datefrom = '". date('Y-m-d', strtotime($inquiry['OccupancyDateFrom'])) ."', dateto = '". date('Y-m-d', strtotime($inquiry['OccupancyDateTo'])) ."', unitid = '". $inquiry['UnitID'] ."', Group_Name = '". mysql_real_escape_string($gname) ."', Term_Name = '". mysql_real_escape_string($tname) ."', Conditions = '".  mysql_real_escape_string($cond) ."', ids  = '". $inquiry['TermsAndCondition'] ."' ");

				$unit = mysql_query("UPDATE tblref_unit SET status = 'Occupied', TenantID = '". $tenantid ."', TenantName = '". $inquiry['Fullname'] ."', StartDate = '". $inquiry[0] ."', EndDate = '". $inquiry[1] ."' WHERE unitid = '". $_POST['unitid'] ."'", $connection);

					$days = (strtotime($inquiry["OccupancyDateTo"]) - strtotime($inquiry["OccupancyDateFrom"])) / (60 * 60 * 24);
					$refDate = $inquiry["OccupancyDateFrom"];
					for ($x=1; $x<=$days+1; $x++){
						$refDate = date( 'Y/m/d', strtotime($refDate) );
						$selectlogs = "SELECT COUNT(*) FROM tblunit_statuslogs WHERE unitid = '".$_POST["unitid"]."' AND xdate = '".$refDate."'";
						$resultlogs = mysql_query($selectlogs, $connection);
						$logs = mysql_fetch_array($resultlogs);
						if($logs[0] == 0){

							$inserunitlogs = "INSERT INTO tblunit_statuslogs SET unitid = '". $_POST['unitid'] ."', unitname = '". $unitinfo[0] ."', xdate = '". $refDate ."', xtime = '". date('H:i:s') ."', status = 'Occupied', tenantid = '". $tenantid ."', tenantname = '". $inquiry['Fullname'] ."' ";
							$result_logs = mysql_query($inserunitlogs);
						}else{
							$inserunitlogs = "UPDATE tblunit_statuslogs SET unitid = '". $_POST['unitid'] ."', unitname = '". $unitinfo[0] ."', xdate = '". $refDate ."', xtime = '". date('H:i:s') ."', status = 'Occupied', tenantid = '". $tenantid ."', tenantname = '". $inquiry['Fullname'] ."' WHERE unitid = '". $_POST['unitid'] ."' AND xdate = '". $refDate ."' ";
							$result_logs = mysql_query($inserunitlogs);
						}
						$refDate = date( 'Y/m/d', strtotime($refDate . '+1 day') );
					}
			}
		break;

		case 'showinquiryinfo':
			$inquiry = mysql_fetch_array(mysql_query("SELECT First_Name, Middle_Name, Last_Name, Gender, Birthdate, Civil_Status, Telephone_No, Mobile_No, EmailAddress, TIN, Occupation, Citizenship, Address, City, Country, ZipCode, MallID, WingID, FloorID, UnitID, ClassificationID, DepartmentID, CategoryID, Unit_Area, Price_Per_SQM, MonthlyDue, AssociationDue, OccupancyDateFrom, OccupancyDateTo, OccupancyMonthCount, ListPrice, PromoDiscount, CompanyDiscount, SpotDownPayment, SpotDownPaymentDue, ReservationFee, ReservationFeeDue, RetentionFee, NetSpotPayment, NetDownPayment, AmortNoOfMonths, AmortStartDate, MonthlyAmort, Balance, PaymentType, ValidityOfPaymentScheme, PaymentScheme, SourceOfSale, Reason4Buying, Status, TermsAndCondition FROM tbltransleasing_inquiry WHERE InquiryID = '". $_POST['InquiryID'] ."' ", $connection));

			echo $inquiry['First_Name'] . "#" . $inquiry['Middle_Name'] . "#" . $inquiry['Last_Name'] . "#" . $inquiry['Gender'] . "#" . date('m/d/Y', strtotime($inquiry['Birthdate'])) . "#" . $inquiry['Civil_Status'] . "#" . $inquiry['Telephone_No'] . "#" . $inquiry['Mobile_No'] . "#" . $inquiry['EmailAddress'] . "#" . $inquiry['TIN'] . "#" . $inquiry['Occupation'] . "#" . $inquiry['Citizenship'] . "#" . $inquiry['Address'] . "#" . $inquiry['City'] . "#" . $inquiry['Country'] . "#" . $inquiry['ZipCode'] . "#" . $inquiry['MallID'] . "#" . $inquiry['WingID'] . "#" . $inquiry['FloorID'] . "#" . $inquiry['UnitID'] . "#" . $inquiry['ClassificationID'] . "#" . $inquiry['DepartmentID'] . "#" . $inquiry['CategoryID'] . "#" . date('m/d/Y', strtotime($inquiry['OccupancyDateFrom'])) . "#" . date('m/d/Y', strtotime($inquiry['OccupancyDateFrom'])) . "#" . $inquiry['OccupancyMonthCount'] . "#" . date('m/d/Y', strtotime($inquiry['SpotDownPaymentDue'])) . "#" . date('m/d/Y', strtotime($inquiry['ReservationFeeDue'])) . "#" . date('m/d/Y', strtotime($inquiry['AmortStartDate'])) . "#" . date('m/d/Y', strtotime($inquiry['ValidityOfPaymentScheme'])) . "#" . $inquiry['PaymentType'] . "#" . $inquiry['AmortNoOfMonths'] . "#" . $inquiry['PaymentScheme'] . "#" . $inquiry['SourceOfSale'] . "#" . $inquiry['Reason4Buying'] . "#" . $inquiry['TermsAndCondition'];
		break;

		case 'div_LMinqcontactlist':
			$res = mysql_query("SELECT CONCAT(FirstName, ' ', LEFT(MiddleName, 1), ' ', LastName), CompanyPosition, MobileNo, TelephoneNo, EmailAddress, Address, FirstName, MiddleName, LastName FROM tbltransleasing_contactlist WHERE InquiryID = '". $_POST['InquiryID'] ."' ", $connection);
			while($row = mysql_fetch_array($res)){
				echo 	"
							<tr class='trcontactlist' id='".$row['FirstName']."|".$row['MiddleName']."|".$row['LastName']."|".$row['Address']."|".$row['EmailAddress']."|".$row['MobileNo']."|".$row['CompanyPosition']."|".$row['TelephoneNo']."'>
								<td>".$row[0]."</td>
								<td>".$row[1]."</td>
								<td>".$row[2]."</td>
								<td>".$row[3]."</td>
								<td>".$row[4]."</td>
								<td>".$row[5]."</td>
							</tr>
						";
			}
		break;

		case 'showtblLMinqtermsandconditionlist':
			$page = $_POST['page'];
			$limit = ($page-1) * 10;

			if($_POST['group'] == ""){
				$filter = "";
			}else{
				$filter = "AND Group_ID = '". $_POST['group'] ."' ";
			}

			$res = mysql_query("SELECT Group_ID, Group_Name, Term_ID, Term_Name, Description FROM tblcondition WHERE stats = '1' ".$filter." LIMIT ".$limit.",10 ", $connection);
			while($row = mysql_fetch_array($res)){
				echo 	"
							<tr id='tr".$row[2]."'>
								<td style='display: none;'><input type='checkbox' value='". $row[2] ."' class='chkLMQselectedTAC chkLMQselectedTAC".$row[2]."'></td>
								<td>".$row[1]."</td>
								<td>".$row[3]."</td>
								<td>".$row[4]."</td>
							</tr>
						";
			}
		break;

		case 'loadentriesLMinqTAC':
			if($_POST['group'] == ""){
				$filter = "";
			}else{
				$filter = "AND Group_ID = '". $_POST['group'] ."' ";
			}

			if($_POST["page"] == ""){
               	$page = 1;
           	}else{
               	$page = $_POST["page"];
           	}

	        $limit = ($page-1) * 10;
			$sql = " SELECT COUNT(Group_ID) FROM tblcondition WHERE stats = '1' ".$filter." ";
            $result = mysql_query($sql, $connection);
            $row = mysql_fetch_array($result);
            $rowsperpage = 10;
            $totalpages = ceil($row[0] / $rowsperpage);
            $upto = $limit + 10;
            $from = $limit + 1;
            if($page == $totalpages && $row[0] != 0){
                 echo "Showing " . $from . " to " . $row[0] . " of " . $row[0] . " entries";
            }else{
                if($row[0] == 0){
                   	echo "";
                }else if($row[0] <= 9 && $row[0] != 0){
                   	echo "Showing 1 to " . $row[0] . " of " . $row[0] . " entries";
                }else if($row[0] >= 10 && $row[0] != 0){
                   	echo "Showing " . $from . " to " . $upto . " of " . $row[0] . " entries";
                }
            }
		break;

		case 'loadpageLMinqTAC':
			if($_POST['group'] == ""){
				$filter = "";
			}else{
				$filter = "AND Group_ID = '". $_POST['group'] ."' ";
			}
			$page = $_POST["page"];
			$sqlb = " SELECT COUNT(Group_ID) FROM tblcondition WHERE stats = '1' ".$filter." "; 	
			$aa = mysql_query($sqlb, $connection);
			$nums = mysql_fetch_row($aa);
			$num = $nums[0];
			
			$rowsperpage = 10;
			$range = 3;
			$totalpages = ceil($num / $rowsperpage);
			$prevpage;
			$nextpage;
			// if not on page 1, don't show back links
			if($page > 1 ){
			   	echo "<li style='width:50px !important;' onclick='paginationLMinqTAC(1)'><< First</li>";
			   	$prevpage = $page - 1;
			   	echo "<li style='width:70px !important;' onclick='paginationLMinqTAC(". $prevpage .")'>< Previous</li>";
			}

			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if (($x > 0) && ($x <= $totalpages)){
    			    if ($x == $page){
                        echo "<li id='pgLMinqTAC" . $x . "' class='pgnumLMinqTAC active' onclick='paginationLMinqTAC(" . $x . ",". $x .")'>" . $x . "</li>";
                    }else{
    			        echo "<li id='pgLMinqTAC" . $x . "' class='pgnumLMinqTAC' onclick='paginationLMinqTAC(" . $x . ",". $x .")'>" . $x . "</li>";
                    }
		       }
		    }
		    if($page < ($totalpages - $range)){
                echo "<li>...</li>";
            }

		    if ($page != $totalpages && $num != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='paginationLMinqTAC(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='paginationLMinqTAC(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'loadgroupselection':
			echo "<option value=''>All</option>";
			$res = mysql_query("SELECT Group_ID, Group_Name FROM tblgroups WHERE Status = '1'", $connection);
			while($row = mysql_fetch_array($res)){
				echo "<option value='".$row[0]."'>".$row[1]."</option>";
			}
		break;

		case 'addselection':
			if($_POST['InquiryID'] == ""){
				$arr = explode("|", $_POST['ids']);
			}else{
				$getids = mysql_fetch_array(mysql_query("SELECT TermsAndCondition FROM tbltransleasing_inquiry WHERE InquiryID = '". $_POST['InquiryID'] ."'", $connection));
				$arr = explode("|", $getids[0]);
			}
			for ($i=0; $i <= COUNT($arr)-1; $i++) { 
				$tac = mysql_fetch_array(mysql_query("SELECT Term_Name, Description FROM tblcondition WHERE Term_ID = '". $arr[$i] ."' ", $connection));

				?>
					<table>
						<tbody>
							<tr>
								<td width="20%" valign="top"><?php echo $tac[0]; ?></td>
								<td width="80%"><?php echo $tac[1]; ?></td>
							</tr>
							<tr></tr>
						</tbody>
					</table>
				<?php
			}
		break;

		case 'loadLMINQrequirements':
			$i = 0;
			$sql = "SELECT id, requirements, override FROM tblref_applicationrequirements";
			$result = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($result)){
				$sql2 = "SELECT filename, filetype, filename FROM tbltrans_leasingapplicationreq WHERE appID = '".$_POST["appid"]."' AND reqID = '".$_POST["inqid"]."' AND type_req_ID = '".$row["id"]."'";
				$result2 = mysql_query($sql2, $connection);
				$row2 = mysql_fetch_array($result2);
				$num = mysql_num_rows($result2);
				if($num == 0 && $row[2] == "0"){
					$i++;
					$id = "posting_commentreq_".$i;
					$file = '<div class="row">
							 	<div class="col-xs-4">'.$row["requirements"].'</div>
							 	<div class="col-xs-1"><i style="color:red;margin-top:5px;" class="ace-icon fa fa-remove bigger-120" id="'.$id.'_icon"></i></div>';
					$file .= '	<div class="col-xs-5" style="white-space: nowrap;text-overflow: ellipsis;overflow: hidden;">';
					$file .= '	<form name="posting_comment" class="form_lease_application_req" id="posting_commentreq_'.$i.'">
		                              <div style="display: none">
		                                <input type="text" name="txtaapid" class="txtaapid" value="'.$_POST["appid"].'">
		                                <input type="text" name="txtinqqid" class="txtinqqid" value="'.$_POST["inqid"].'">
		                              </div>
                                		<input type="file" class="upload_app_req id-input-file-2" name="attachment_filess" onchange="chkclippeddocx($(this))"/><input type="hidden" name="hiddenidss" value="'.$row["id"].'">
                              </form>
                              	</div>
                              </div>';
				}else if($num == 0 && $row[2] == "1"){
					$i++;
					$id = "posting_commentreq_".$i;
					$file = '<div class="row">
							 	<div class="col-xs-4">'.$row["requirements"].'</div>
							 	<div class="col-xs-1"><i style="color:red;margin-top:5px;" class="ace-icon fa fa-remove bigger-120" id="'.$id.'_icon"></i></div>';
					$file .= '	<div class="col-xs-5" style="white-space: nowrap;text-overflow: ellipsis;overflow: hidden;">';
						$file .= '	<form name="posting_comment" class="form_lease_application_req" id="posting_commentreq_'.$i.'">
			                              <div style="display: none">
			                                <input type="text" name="txtaapid" class="txtaapid" value="'.$_POST["appid"].'">
			                                <input type="text" name="txtinqqid" class="txtinqqid" value="'.$_POST["inqid"].'">
			                              </div>
	                                		<input type="file" class="upload_app_req id-input-file-2" name="attachment_filess" id="overridemoko'.$row["id"].'" onchange="chkclippeddocx($(this))"/><input type="hidden" name="hiddenidss" value="'.$row["id"].'">
	                              	</form>
                              	</div>
                              	<div class="col-xs-1"><button class="btn btn-xs btn-primary overridebutton" onclick="showmodal_login_override(\''.$row[0].'\', \''.$i.'\', \''.$_POST["appid"].'\', \''.$_POST["inqid"].'\');">Override</button></div>
                            </div>';
				}else{
					$file = '<div class="row">
							 <div class="col-xs-4">'.$row["requirements"].'</div><div class="col-xs-1"><i style="color:green;" class="ace-icon fa fa-check bigger-120"></i></div>';
					$file .= '<div class="col-xs-5" style="white-space: nowrap;text-overflow: ellipsis;overflow: hidden;">';
					$file .= '<button class="btn btn-xs btn-info imagebutton" style="padding:2px;margin-bottom:3px;margin-left:2px;display:inline;">
								<a href="server/Requirements/'.$_POST["appid"].'/'.$row["requirements"].'/'.$row2["filename"].'" download><i style="color:white !important;" class="ace-icon fa fa-arrow-down bigger-120"></i></a>
							  </button>';

							$linkimage = 'server/Requirements/'.$_POST["appid"].'/'.$row["requirements"].'/'.$row2["filename"];
							if($row2["filetype"] == "image/jpeg" || $row2["filetype"] == "image/png" || $row2["filetype"] == "image/jpg")
							{
								$file .= "<button class='btn btn-xs btn-purple imagebutton' style='padding:2px;margin-bottom:3px;margin-left:2px;display:inline;' onclick='load_req_image(\"". $linkimage ."\")' title='view image'>
									<i class='ace-icon fa fa-picture-o bigger-120'></i>
									</button>";
							}
							else
							{
								$file .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
							}

					$file .= '<p class="req_nam_'.$_POST["appid"].' req_already_added_na" id="'.$row2["filename"].'" style="font-size:11px;font-weight:normal;font-style:italic;display:inline;">&nbsp;&nbsp;'.$row2["filename"].'</p></div>
							</div>';
				}
				echo $file;
			}
		break;

		case 'confirmoverride':
			$sql = "SELECT count(userid), userid, CONCAT(lastname, ', ', firstname, ' ', middlename) FROM tbluser WHERE username = '" . $_POST["username"] . "' and password2 = '" . md5($_POST["password"]) . "' AND groupaccess = '0000004' ";
            $result = mysql_query($sql, $connection);
            $row = mysql_fetch_array($result);

            $ifnoaccess = mysql_fetch_array(mysql_query("SELECT COUNT(userid) FROM tbluser WHERE username = '" . $_POST["username"] . "' and password2 = '" . md5($_POST["password"]) . "' ", $connection));

            if($row[0] == "0" && $ifnoaccess[0] == "1"){
            	echo 3;
            }else if($row[0] == "0" && $ifnoaccess[0] == "0"){
            	echo 2;
            }else if($row[0] == "1" && $ifnoaccess[0] == "1"){
            	echo 1;
            	$reqname = mysql_fetch_array(mysql_query("SELECT requirements FROM tblref_applicationrequirements WHERE id = '". $_POST['id'] ."' ", $connection));
        		$sqlpertrans = "INSERT INTO tbllogs_per_trans SET LogID = '". createidno("LOG", "tbllogs_per_trans", "logID") ."', inqID = '". $_POST['inqid'] ."', appID = '". $_POST['appid'] ."', userid = '". $row[1] ."', username = '". $row[2] ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', remarks = '". $row[2] ." override an application requirement', module = 'Reservation Module', xinfo = '". $_POST['inqid']."|".$_POST["appid"]."|".$reqname[0]."|".$row[1] ."', xaction = 'Override' ";
				$respertrans = mysql_query($sqlpertrans, $connection);
				$reslogs = mysql_query($sqllogs, $connection);
            }
		break;

		case 'showLMinqCompanyPosition':
			echo "<option value=''>-- Select Position --</option>";
			$res = mysql_query("SELECT xposition FROM tblref_companyposition", $connection);
			while($row = mysql_fetch_array($res)){
				echo "<option value='". $row[0] ."'>".$row[0]."</option>";
			}
		break;

		case 'positionlist':
			$res = mysql_query("SELECT xposition FROM tblref_companyposition", $connection);
			while($row = mysql_fetch_array($res)){
				echo "	<tr style='width: 100%;display: table;table-layout: fixed;'>
							<td>".$row['xposition']."</td>
						</tr>
					";
			}
		break;

		case 'savenewcomppos':
			$res = mysql_query("INSERT INTO tblref_companyposition SET xposition = '". $_POST['xposition'] ."' ", $connection);
		break;
	}
?>