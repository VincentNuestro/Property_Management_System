<?php  
	session_start();
	include("../../connect.php");
	switch($_POST['form']){
		case 'tblAccreditation':
			$getFilters = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'Accreditation';", $connection));
		    $Status = explode("|", $getFilters["bystat"]);
		    $Search = explode("|", $getFilters["checked_value"]);
			$UnitType = explode("|", $getFilters["xcheck"]);
		    $Date = explode("|", $getFilters["datefilter"]);

		    // FILTER BY STATUS
			$StatusCount = 0; $SelectedStatus = "";
			for($a = 0; $a<=count($Status)-2; $a++){
				if($Status[$a] == "Accredited"){ 
		      		$StatusVal = "a.DateOfCertification IS NOT NULL"; 
		      	}else if($Status[$a] == "Not Accredited"){ 
		      		$StatusVal = "a.DateOfCertification IS NULL"; 
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
		    	$StatFilter = "(a.DateOfCertification IS NOT NULL OR a.DateOfCertification IS NULL)";
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
		    if($Date[0] != "" && $Date[1] != ""){
		    	$DateFilter = "AND (a.DateOfAccreditation BETWEEN '". date("Y-m-d", strtotime($Date[0])) ."' AND '". date("Y-m-d", strtotime($Date[1])) ."')";
		    }else{
		    	$DateFilter = "";
		    }

			$page = $_POST['page'];
			$limit = ($page-1) * 20;
			$sql = "SELECT a.DateOfAccreditation, a.TenantID, b.tradename, a.NameofPOSProvider, a.SoftwareVersion, a.DateOfCertification, a.AccredID FROM tblaccreditation AS a LEFT JOIN tbltrans_tenants AS b ON a.TenantID = b.TenantID WHERE ". $StatFilter ." ". $SearchFilter ." ". $DateFilter ." GROUP BY TenantID ORDER BY ". $_POST['AccreditationSortBy'] ." ". $_POST['AccreditationSortType'] ." LIMIT ".$limit.",20";
			$res = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($res)){
				if($row[5] == "" || $row[5] == "0000-00-00"){
					$status = "<label class='label label-lg arrowed-in-right arrowed label-warning'>Not Accredited</label>";
					$btn = "<button class='btn btn-sm btn-info hide isadmin select-editinquiry btn-round' onclick='EorVAccreditation(\"". $row[6] ."\", \"Edit\")' title='Apply Leasing Application'><img src='assets/images/resume.png' style='width: 100%; height: auto;' /></button>";
				}else{
					$status = "<label class='label label-lg arrowed-in-right arrowed label-success'>Accredited</label>";
					$btn = "<button class='btn btn-sm btn-default hide isadmin select-editinquiry btn-round' onclick='EorVAccreditation(\"". $row[6] ."\", \"View\")' title='Apply Leasing Application'><img src='assets/images/view.png' style='width: 100%; height: auto;' /></button>";
				}
				echo "<tr>
						<td>". date('m/d/Y', strtotime($row[0])) ."</td>
						<td>". $row[1] ."</td>
						<td>". $row[2] ."</td>
						<td>". $row[3] ."</td>
						<td>". $row[4] ."</td>
						<td>". $status ."</td>
						<td>". $btn ."</td>
					</tr>";
			}
		break;

		case 'tblAccreditationEntries':
			$getFilters = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'Accreditation';", $connection));
		    $Status = explode("|", $getFilters["bystat"]);
		    $Search = explode("|", $getFilters["checked_value"]);
			$UnitType = explode("|", $getFilters["xcheck"]);
		    $Date = explode("|", $getFilters["datefilter"]);

		    // FILTER BY STATUS
			$StatusCount = 0; $SelectedStatus = "";
			for($a = 0; $a<=count($Status)-2; $a++){
				if($Status[$a] == "Accredited"){ 
		      		$StatusVal = "a.DateOfCertification IS NOT NULL"; 
		      	}else if($Status[$a] == "Not Accredited"){ 
		      		$StatusVal = "a.DateOfCertification IS NULL"; 
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
		    	$StatFilter = "(a.DateOfCertification IS NOT NULL OR a.DateOfCertification IS NULL)";
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
		    if($Date[0] != "" && $Date[1] != ""){
		    	$DateFilter = "AND (a.DateOfAccreditation BETWEEN '". date("Y-m-d", strtotime($Date[0])) ."' AND '". date("Y-m-d", strtotime($Date[1])) ."')";
		    }else{
		    	$DateFilter = "";
		    }

	       	if($_POST["page"] == ""){
               	$page = 1;
           	}else{
               	$page = $_POST["page"];
           	}
           	$limit = ($page-1) * 20;
            $rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(a.id) FROM tblaccreditation AS a LEFT JOIN tbltrans_tenants AS b ON a.tenantid = b.tenantid WHERE ". $StatFilter ." ". $SearchFilter ." ". $DateFilter .";", $connection));
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

		case "tblAccreditationPagination":
			$getFilters = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'Accreditation';", $connection));
		    $Status = explode("|", $getFilters["bystat"]);
		    $Search = explode("|", $getFilters["checked_value"]);
			$UnitType = explode("|", $getFilters["xcheck"]);
		    $Date = explode("|", $getFilters["datefilter"]);

		    // FILTER BY STATUS
			$StatusCount = 0; $SelectedStatus = "";
			for($a = 0; $a<=count($Status)-2; $a++){
				if($Status[$a] == "Accredited"){ 
		      		$StatusVal = "a.DateOfCertification IS NOT NULL"; 
		      	}else if($Status[$a] == "Not Accredited"){ 
		      		$StatusVal = "a.DateOfCertification IS NULL"; 
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
		    	$StatFilter = "(a.DateOfCertification IS NOT NULL OR a.DateOfCertification IS NULL)";
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
		    if($Date[0] != "" && $Date[1] != ""){
		    	$DateFilter = "AND (a.DateOfAccreditation BETWEEN '". date("Y-m-d", strtotime($Date[0])) ."' AND '". date("Y-m-d", strtotime($Date[1])) ."')";
		    }else{
		    	$DateFilter = "";
		    }

		    $page = $_POST["page"];
            $rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(a.id) FROM tblaccreditation AS a LEFT JOIN tbltrans_tenants AS b ON a.tenantid = b.tenantid WHERE ". $StatFilter ." ". $SearchFilter ." ". $DateFilter .";", $connection));
			$rowsperpage = 20;
			$range = 3;
			$totalpages = ceil($rowCount[0] / $rowsperpage);
			$prevpage;
			$nextpage;
			if($page > 1 ){
			   	echo "<li style='width:50px !important;' onclick='tblAccreditationFunc(1)'><< First</li>";
			   	$prevpage = $page - 1;
			   	echo "<li style='width:70px !important;' onclick='tblAccreditationFunc(". $prevpage .")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if (($x > 0) && ($x <= $totalpages)){
    			    if ($x == $page){
                        echo "<li id='pgaccreditation" . $x . "' class='pgnumpaccreditation active' onclick='tblAccreditationFunc(" . $x . ",". $x .")'>" . $x . "</li>";
                    }else{
    			        echo "<li id='pgaccreditation" . $x . "' class='pgnumpaccreditation' onclick='tblAccreditationFunc(" . $x . ",". $x .")'>" . $x . "</li>";
                    }
		       	}
		    }
		    if($page < ($totalpages - $range)){
                echo "<li>...</li>";
            }
		    if ($page != $totalpages && $rowCount[0] != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='tblAccreditationFunc(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='tblAccreditationFunc(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'ShowTenantList':
			echo "<option value=''>-- Select Tenant --</option>";
			$res = mysql_query("SELECT TenantID, tradename FROM tbltrans_tenants WHERE (Status = 'Active' OR Status = 'ForEviction' OR Status = 'ForRenewal') AND ustatus = 'Occupied';", $connection);
			while($row = mysql_fetch_array($res)){
				echo "<option value='". $row[0] ."'>". $row[1] ."</option>";
			}
		break;

		case 'fncAccredPaymentTypes':
			$mgaMeron = "";
			$arr = explode("|", $_POST['ids']);
			for ($i=0; $i <= count($arr)-2; $i++) { 
				$mgaMeron .= "'" . $arr[$i] . "'" . ",";
			}

			if($_POST['ids'] != ""){
				$tanong = "WHERE PaymentTypeID NOT IN (". substr(trim($mgaMeron), 0, -1) .")";
			}else{
				$tanong = "";
			}

			$res = mysql_query("SELECT PaymentTypeID, PaymentType FROM tblref_pospaymenttype ". $tanong ." ", $connection);
			while($row = mysql_fetch_array($res)){
				echo 	"<tr id='TR". $row[0] ."'>
							<td class='ptID'>". $row[0] ."</td>
							<td class='ptDESC'>". $row[1] ."</td>
						</tr>";
			}
		break;

		case 'SaveNewAccredPTRef':
			$checkexisting = mysql_fetch_array(mysql_query("SELECT COUNT(PaymentTypeID) FROM tblref_pospaymenttype WHERE PaymentTypeID = '". $_POST['PaymentTypeID'] ."' OR PaymentType = '". $_POST['PaymentTypeDesc'] ."' ", $connection));
			if($checkexisting[0] == 0){
				$sql = "INSERT INTO tblref_pospaymenttype SET PaymentTypeID = '". $_POST['PaymentTypeID'] ."', PaymentType = '". $_POST['PaymentTypeDesc'] ."' ";
				$res = mysql_query($sql, $connection);
				if($res == true){
					echo "1|New payment type successfully added.";
				}else{
					echo "2|Failed to save Payment Type.";
				}
			}else{
				echo "3|Payment type is already existing.";
			}
		break;

		case 'SaveNewAccredSched':
			$Tradename = mysql_fetch_array(mysql_query("SELECT tradename FROM tbltrans_tenants WHERE TenantID = '". $_POST['AccredTenant'] ."'", $connection));
			if($_POST['AccredID'] == ""){
				$AccredID = createidno("ACD", "tblaccreditation", "AccredID");
				$sql = "INSERT INTO tblaccreditation SET AccredID = '". $AccredID ."', TenantID = '". $_POST['AccredTenant'] ."', DateOfAccreditation = '". date('Y-m-d', strtotime($_POST['AccredDate'])) ."', RetailPartnerName = '". $_POST['AccredPartnerName'] ."', NameofPOSProvider = '". $_POST['AccredPosProvider'] ."', SoftwareVersion = '". $_POST['AccredSoftwareVersion'] ."', OperatingSystem = '". $_POST['AccredOperatingSystem'] ."', NumberofPOS = '". $_POST['AccredNumberOfPOS'] ."', NatureOfPos = '". $_POST['AccredNatureOfPos'] ."', TextfileGeneration = '". $_POST['AccredGeneratorStat'] ."', ServiceCharge = '". $_POST['ServiceCharge'] ."', LocalTax = '". $_POST['LocalTax'] ."', Remarks = '". $_POST['AccredRemarks'] ."', MobileNo = '". $_POST['AccredMobileNumbers'] ."', TelephoneNo = '". $_POST['AccredTelephoneNumbers'] ."', AuthorizedRepresentatives = '". $_POST['AccredAuthorizedRep'] ."', AccreditorsRepresentatives = '". $_POST['AccreditorsRep'] ."', MachineNo = '". $_POST['AccredMachineNumbers'] ."', PaymentType = '". $_POST['AccredPaymentTypes'] ."' ";
				$action = "saved";
			}else{
				$AccredID = $_POST['AccredID'];
				$sql = "UPDATE tblaccreditation SET DateOfAccreditation = '". date('Y-m-d', strtotime($_POST['AccredDate'])) ."', RetailPartnerName = '". $_POST['AccredPartnerName'] ."', NameofPOSProvider = '". $_POST['AccredPosProvider'] ."', SoftwareVersion = '". $_POST['AccredSoftwareVersion'] ."', OperatingSystem = '". $_POST['AccredOperatingSystem'] ."', NumberofPOS = '". $_POST['AccredNumberOfPOS'] ."', NatureOfPos = '". $_POST['AccredNatureOfPos'] ."', TextfileGeneration = '". $_POST['AccredGeneratorStat'] ."', ServiceCharge = '". $_POST['ServiceCharge'] ."', LocalTax = '". $_POST['LocalTax'] ."', Remarks = '". $_POST['AccredRemarks'] ."', MobileNo = '". $_POST['AccredMobileNumbers'] ."', TelephoneNo = '". $_POST['AccredTelephoneNumbers'] ."', AuthorizedRepresentatives = '". $_POST['AccredAuthorizedRep'] ."', AccreditorsRepresentatives = '". $_POST['AccreditorsRep'] ."', MachineNo = '". $_POST['AccredMachineNumbers'] ."', PaymentType = '". $_POST['AccredPaymentTypes'] ."' WHERE AccredID = '". $_POST['AccredID'] ."' ";
				$action = "updated";
			}
			$res = mysql_query($sql, $connection);
			if($res == true){
				echo "1|Accreditation schedule for ". $Tradename[0] . " successfully ".$action.".|".$AccredID;
			}
		break;

		case 'EorVAccreditation':
			$AccredInfo = mysql_fetch_array(mysql_query("SELECT TenantID, DateOfAccreditation, RetailPartnerName, NameofPOSProvider, SoftwareVersion, OperatingSystem, NumberofPOS, ServiceCharge, LocalTax, NatureOfPos, TextfileGeneration, Remarks, MobileNo, TelephoneNo, AuthorizedRepresentatives, AccreditorsRepresentatives, MachineNo, PaymentType FROM tblaccreditation WHERE AccredID = '". $_POST['AccredID'] ."'", $connection));

			$mgaMeron = "";
			$arr = explode("|", $AccredInfo['PaymentType']);
			for ($i=0; $i <= count($arr)-2; $i++) { 
				$mgaMeron .= "'" . $arr[$i] . "'" . ",";
			}

			if($AccredInfo['PaymentType'] != ""){
				$tanong = "WHERE PaymentTypeID IN (". substr(trim($mgaMeron), 0, -1) .")";
			}else{
				$tanong = "";
			}

			$res = mysql_query("SELECT PaymentTypeID, PaymentType FROM tblref_pospaymenttype ". $tanong ." ", $connection);
			while($row = mysql_fetch_array($res)){
				$PaymentTypes .= "<tr id='". $row[0] ."''>
									<td>". $row[1] ."</td>
									<td style='text-align: center;z-index: 0;'><button class='btn btn-xs btn-danger btn-round' onclick='$(\"#". $row[0] ."\").remove();'><i class='fa fa-trash-o'></i></button></td>
								</tr>";
			}

			$resAccredDocs = mysql_query("SELECT DocumentName, FileType, FileExt FROM tblaccreditationdocs WHERE AccredID = '". $_POST['AccredID'] ."' AND AccredLogsID IS NULL", $connection);
			while($rowAccredDocs = mysql_fetch_array($resAccredDocs)){
				$path = "../Mall_Attachments/Accreditation/".$_POST['AccredID']."/".$rowAccredDocs[0].".".$rowAccredDocs[2];
				$arr = explode("/", $rowAccredDocs[1]);
				if($arr[0] != "image" && $arr[0] != ""){
					$btn = "<a href='".$path."' download class='btn btn-xs btn-info btn-round'><i class='fa fa-download'></i></a>";
	            }else if($arr[0] == "image"){
	                $btn = "<a class='btn btn-xs btn-info btn-round' onclick='viewdocuimgindex(\"". $path ."\");'><i class='fa fa-eye'></i></a>";
	            }else{
	            	$btn = "";
	            }
	            if($btn != ""){
					$AccredDocuments .= "	<div class='row form-group'>
												<div class='col-md-7'>
													<input type='text' class='form-control' value='". $rowAccredDocs[0] ."' readonly>
												</div>
												<div class='col-md-5'>".$btn."</div>
										  	</div>";
	            }
			}

				$AccredDocuments .= "<div class='row form-group'>
										<div class='col-md-7'>
			            					<input type='text' class='form-control' name='AccredDocName1' placeholder='Document Name'>
			            				</div>
			            				<div class='col-md-5'>
			            					<input type='file' class='txtAccredDoc' name='AccredDoc1'>
			            				</div>
			            			</div>";


			echo $AccredInfo['TenantID'] . "@" . date('m/d/y', strtotime($AccredInfo['DateOfAccreditation'])) . "@" . $AccredInfo['RetailPartnerName'] . "@" . $AccredInfo['NameofPOSProvider'] . "@" . $AccredInfo['SoftwareVersion'] . "@" . $AccredInfo['OperatingSystem'] . "@" . $AccredInfo['NumberofPOS'] . "@" . $AccredInfo['ServiceCharge'] . "@" . $AccredInfo['LocalTax'] . "@" . $AccredInfo['NatureOfPos'] . "@" . $AccredInfo['TextfileGeneration'] . "@" . $AccredInfo['Remarks'] . "@" . $AccredInfo['MobileNo'] . "@" . $AccredInfo['TelephoneNo'] . "@" . $AccredInfo['AuthorizedRepresentatives'] . "@" . $AccredInfo['AccreditorsRepresentatives'] . "@" . $AccredInfo['MachineNo'] . "@" . $PaymentTypes . "@" . $AccredDocuments;
		break;

		case 'SaveNewAccredLogs':
			$AccredLogsID = createidno("ACDL", "tblaccreditationlogs", "AccredLogsID");
			$sql = " INSERT INTO tblaccreditationlogs SET AccredID = '". $_POST['AccredID'] ."', AccredLogsID = '". $AccredLogsID ."', AccredLogsDate = '". date('Y-m-d', strtotime($_POST['LogDate'])) ."', AccredLogsTime = '". date('H:i:s', strtotime($_POST['LogTime'])) ."', AccredLogsResult = '". $_POST['Result'] ."' ";
			$res = mysql_query($sql, $connection);
			if($res == true){
				echo "1|Accreditation logs successfully saved.|".$AccredLogsID;
				if($_POST['Result'] == "Passed"){
					$AccredInfo = mysql_fetch_array(mysql_query("SELECT NumberofPOS, TenantID FROM tblAccreditation WHERE AccredID = '". $_POST['AccredID'] ."'", $connection));
					$resUpdateAccredDate = mysql_query("UPDATE tblaccreditation SET DateOfCertification = '". date('Y-m-d') ."' WHERE AccredID = '". $_POST['AccredID'] ."'", $connection);
					$resUpdateTenant = mysql_query("UPDATE tbltrans_tenants SET withPOS = '". $AccredInfo['NumberofPOS'] ."', uploadingoffiles = '1' WHERE TenantID = '". $AccredInfo['TenantID'] ."'", $connection);
				}
			}else{
				echo "2|Failed to save accreditation logs.|";
			}
		break;

		case 'ShowtblAccredLogs':
			$res = mysql_query("SELECT AccredLogsDate, AccredLogsTime, AccredLogsResult, AccredLogsID FROM tblaccreditationlogs WHERE AccredID = '". $_POST['AccredID'] ."'", $connection);
			while($row = mysql_fetch_array($res)){
				echo "	<tr>
							<td>". date('m/d/Y', strtotime($row[0])) ."</td>
							<td>". date('h:i A', strtotime($row[1])) ."</td>
							<td>". $row[2] ."</td>
							<td style='z-index: 0;'>";
							$resAccredDocs = mysql_query("SELECT DocumentName, FileType, FileExt FROM tblaccreditationdocs WHERE AccredID = '". $_POST['AccredID'] ."' AND AccredLogsID = '". $row['AccredLogsID'] ."'", $connection);
							while($rowAccredDocs = mysql_fetch_array($resAccredDocs)){
								$path = "../Mall_Attachments/Accreditation/".$_POST['AccredID']."/".$row['AccredLogsID']."/".$rowAccredDocs[0];
								$arr = explode("/", $rowAccredDocs[1]);
								if($arr[0] != "image" && $arr[0] != ""){
									$btn = "<a href='".$path."' download class='btn btn-xs btn-info btn-round'><i class='fa fa-download'></i></a>";
					            }else if($arr[0] == "image"){
					                $btn = "<a class='btn btn-xs btn-info btn-round' onclick='viewdocuimgindex(\"". $path ."\");'><i class='fa fa-eye'></i></a>";
					            }else{
					            	$btn = "";
					            }
					            if($btn != ""){
									echo "	<div class='row form-group'>
											<div class='col-md-11'>
												<span class='fa fa-circle'></span>&nbsp;". $rowAccredDocs[0] ."
											</div>
											<div class='col-md-1'>".$btn."</div>
									  	</div>";
					            }
							}
						echo"</td>
						</tr>";
			}
		break;
	}
?> 