<?php
	session_start();
	include "../connect.php";
	switch ($_POST['form']) {
		case 'autoSyncCSV':
			$gettime = mysql_fetch_array(mysql_query("SELECT timetosave, synctype, datefrom, dateto, CSVSource, filesyncsetup FROM db_settimeupload;", $connection));
			if(date('H:i', strtotime($gettime['timetosave'])) == date('H:i') && $gettime['filesyncsetup'] == '0'){
				echo "1|". $gettime['synctype'] ."|". $gettime['datefrom'] ."|". $gettime['dateto'] ."|". $gettime['CSVSource'];
			}else{
				echo "2||||";
			}
		break;

		case 'syncbody':
			$filesetup = mysql_fetch_array(mysql_query("SELECT CSVSource FROM db_settimeupload;", $connection));
			$getFilters = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'FileMonitoring' AND userid = '". $_SESSION['MMS-UserID'] ."';", $connection));
            $Status = explode("|", $getFilters["bystat"]);
            $Status2 = explode("|", $getFilters["xcheck"]);
            $Search = explode("|", $getFilters["checked_value"]);
            $Date = explode("|", $getFilters["datefilter"]);

            // FILTER BY STATUS
            $StatusCount = 0; $SelectedStatus = "";
            for($a = 0; $a<=count($Status)-2; $a++){
            	if($Status[$a] == "Complete"){
		      		$StatusVal = "a.countSync = '5'";
		      	}else if($Status[$a] == "Incomplete"){
		      		$StatusVal = "a.countSync <= '4'"; 
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
                $StatFilter = "";
            }else{
                $StatFilter = "AND ". $getAllStatus;
            }

             // FILTER BY STATUS2
            $StatusCount2 = 0; $SelectedStatus2 = "";
            for($b = 0; $b<= COUNT($Status2)-2; $b++){
                if($Status2[$b] == "Accredited"){
		      		$StatusVal2 = "b.uploadingoffiles = '1'";
		      	}else if($Status2[$b] == "NotAccredited"){
		      		$StatusVal2 = "b.uploadingoffiles = '0'"; 
		      	}

                if($Status2[$b] != ""){
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
            if($Date[0] != "" && $Date[1] != ""){
                $DateFilter = "AND (a.reportDate BETWEEN '". date("Y-m-d", strtotime($Date[0])) ."' AND '". date("Y-m-d", strtotime($Date[1])) ."')";
            }else{
                $DateFilter = "";
            }

			$page = $_POST['page'];
			$limit = ($page-1) * 20;
			$db_settimeupload = mysql_fetch_array(mysql_query("SELECT penalty FROM db_settimeupload;", $connection));

			$sql = "SELECT a.reportDate, a.tenantID, a.sales, a.discount, a.void_refund, a.salesperhour, a.paymenttype, CONCAT(b.owner_lastname, ', ', b.owner_firstname), a.refno, a.penalty, a.uploaded, b.tradename, b.uploadingoffiles FROM db_syncfilestat as a INNER JOIN tbltrans_tenants as b ON a.tenantID = b.TenantID WHERE (b.Status = 'Active' OR b.Status = 'ForEviction' OR b.Status = 'ForRenewal') ". getMallAccess("b.mallID", "AND") ." ". $StatFilter ." ". $StatFilter2 ." ". $SearchFilter ." ". $DateFilter ." GROUP BY tradename ORDER BY ". $_POST['FileMonitoringSortBy'] ." ". $_POST['FileMonitoringSortType'] ." LIMIT ".$limit.",20;";
			$res = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($res)){

				if($row[12] == 1){
					$AccredStat = "<i class='center fa fa-flag green bigger-120'></i> ";
				}else{
					$AccredStat = "<i class='center fa fa-flag orange bigger-120'></i> ";
				}

				if($row['discount'] != 1 || $row['salesperhour'] != 1 || $row['void_refund'] != 1 || $row['paymenttype'] != 1 || $row['sales'] != 1){
					if($row['penalty'] == 0){
						$chkPenalty = 	"<center>
											<div class='ace-settings-item' style='display: none;'>
												<input type='checkbox' class='ace ace-checkbox-2 mgacheckbox' id='". $row[8] ."'>
												<label class='lbl' for='ace-settings-navbar'></label>
											</div>
											<label title='Click to sync files' class='fa fa-upload text-danger' onclick='syncfiles(\"". $row[8] ."\", \"". $filesetup[0] ."\");'></label>
										</center>";
						$chkPenalty2 = "";
					}else{
						if($row['uploaded'] == 0){
							$chkPenalty = "<center>
											<div class='ace-settings-item' style='display: none;'>
												<input type='checkbox' class='ace ace-checkbox-2 mgacheckbox' id='". $row[8] ."'>
												<label class='lbl' for='ace-settings-navbar'></label>
											</div>
											<label title='Click to sync files' class='fa fa-upload text-danger' onclick='syncfiles(\"". $row[8] ."\", \"". $filesetup[0] ."\");'></label>
										</center>";
							$chkPenalty2 = "";
						}else{
							$chkPenalty = "<label class='fa fa-upload text-success'></label>";
							$chkPenalty2 = "NotMe";
						}
					}
				}else{
					if($row['uploaded'] == 1){
						$chkPenalty = "<center><label class='fa fa-upload text-success'></label></center>";
						$chkPenalty2 = "NotMe";
					}else{
						$chkPenalty = "<center><label class='fa fa-check-circle text-success'></label></center>";
						$chkPenalty2 = "NotMe";
					}
				}

				if($row['discount'] == 3){
					$Discount = "<i class='center fa fa-times-circle blue bigger-120'></i>";
				}else if($row['discount'] == 2){
					$Discount = "<i class='center fa fa-times-circle orange bigger-120'></i>";
				}else if($row['discount'] == 1){
					$Discount = "<i class='center fa fa-check-circle green bigger-120'></i>";
				}else{
					$Discount = "<i class='center fa fa-times-circle red bigger-120'></i>";
				}

				if($row['salesperhour'] == 3){
					$HourlySales = "<i class='center fa fa-times-circle blue bigger-120'></i>";
				}else if($row['salesperhour'] == 2){
					$HourlySales = "<i class='center fa fa-times-circle orange bigger-120'></i>";
				}else if($row['salesperhour'] == 1){
					$HourlySales = "<i class='center fa fa-check-circle green bigger-120'></i>";
				}else{
					$HourlySales = "<i class='center fa fa-times-circle red bigger-120'></i>";
				}

				if($row['void_refund'] == 3){
					$Void = "<i class='center fa fa-times-circle blue bigger-120'></i>";
				}else if($row['void_refund'] == 2){
					$Void = "<i class='center fa fa-times-circle orange bigger-120'></i>";
				}else if($row['void_refund'] == 1){
					$Void = "<i class='center fa fa-check-circle green bigger-120'></i>";
				}else{
					$Void = "<i class='center fa fa-times-circle red bigger-120'></i>";
				}

				if($row['paymenttype'] == 3){
					$PaymentType = "<i class='center fa fa-times-circle blue bigger-120'></i>";
				}else if($row['paymenttype'] == 2){
					$PaymentType = "<i class='center fa fa-times-circle orange bigger-120'></i>";
				}else if($row['paymenttype'] == 1){
					$PaymentType = "<i class='center fa fa-check-circle green bigger-120'></i>";
				}else{
					$PaymentType = "<i class='center fa fa-times-circle red bigger-120'></i>";
				}

				if($row['sales'] == 3){
					$Sales = "<i class='center fa fa-times-circle blue bigger-120'></i>";
				}else if($row['sales'] == 2){
					$Sales = "<i class='center fa fa-times-circle orange bigger-120'></i>";
				}else if($row['sales'] == 1){
					$Sales = "<i class='center fa fa-check-circle green bigger-120'></i>";
				}else{
					$Sales = "<i class='center fa fa-times-circle red bigger-120'></i>";
				}

				echo 	"<tr class='". $chkPenalty2 ."'>
							<td style='z-index: 0;''>". $chkPenalty ."</td>
							<td>". date('m/d/Y', strtotime($row['reportDate'])) ."</td>
							<td>". $AccredStat . $row[11] ."</td>
							<td style='text-align: center;'>". $Discount ."</td>
							<td style='text-align: center;'>". $HourlySales ."</td>
							<td style='text-align: center;'>". $Void ."</td>
							<td style='text-align: center;'>". $PaymentType ."</td>
							<td style='text-align: center;'>". $Sales ."</td>
							<td>";
								$resPenalty = mysql_query("SELECT reference FROM tbltransaction WHERE xdescription LIKE '%". $row['refno'] ."%';", $connection);
								while($rowPenalty = mysql_fetch_array($resPenalty)){
									echo "<i class='center fa fa-square red bigger-120'></i> ". $rowPenalty['reference'] ."<br>";
								}
				echo		"</td>
						</tr>";
				
			}
		break;

		case 'loadfilemonitoringentries':
			$getFilters = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'FileMonitoring' AND userid = '". $_SESSION['MMS-UserID'] ."';", $connection));
            $Status = explode("|", $getFilters["bystat"]);
            $Status2 = explode("|", $getFilters["xcheck"]);
            $Search = explode("|", $getFilters["checked_value"]);
            $Date = explode("|", $getFilters["datefilter"]);

            // FILTER BY STATUS
            $StatusCount = 0; $SelectedStatus = "";
            for($a = 0; $a<=count($Status)-2; $a++){
                if($Status[$a] == "Complete"){
                    $StatusVal = "a.countSync = '5'";
                }else if($Status[$a] == "Incomplete"){
                    $StatusVal = "a.countSync <= '4'"; 
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
                $StatFilter = "";
            }else{
                $StatFilter = "AND ". $getAllStatus;
            }

             // FILTER BY STATUS2
            $StatusCount2 = 0; $SelectedStatus2 = "";
            for($b = 0; $b<= COUNT($Status2)-2; $b++){
                if($Status2[$b] == "Accredited"){
                    $StatusVal2 = "b.uploadingoffiles = '1'";
                }else if($Status2[$b] == "NotAccredited"){
                    $StatusVal2 = "b.uploadingoffiles = '0'"; 
                }

                if($Status2[$b] != ""){
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
            if($Date[0] != "" && $Date[1] != ""){
                $DateFilter = "AND (a.reportDate BETWEEN '". date("Y-m-d", strtotime($Date[0])) ."' AND '". date("Y-m-d", strtotime($Date[1])) ."')";
            }else{
                $DateFilter = "";
            }

			if($_POST["page"] == ""){
               	$page = 1;
           	}else{
               	$page = $_POST["page"];
           	}
           	$limit = ($page-1) * 20;
            $rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(a.reportDate) FROM db_syncfilestat as a INNER JOIN tbltrans_tenants as b ON a.tenantID = b.TenantID ". $filter ." AND (b.Status = 'Active' OR b.Status = 'ForEviction' OR b.Status = 'ForRenewal') ". getMallAccess("b.mallID", "AND") ." ". $StatFilter ." ". $StatFilter2 ." ". $SearchFilter ." ". $DateFilter .";", $connection));
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

		case 'loadpagefilemonitoring':
			$getFilters = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'FileMonitoring' AND userid = '". $_SESSION['MMS-UserID'] ."';", $connection));
            $Status = explode("|", $getFilters["bystat"]);
            $Status2 = explode("|", $getFilters["xcheck"]);
            $Search = explode("|", $getFilters["checked_value"]);
            $Date = explode("|", $getFilters["datefilter"]);

            // FILTER BY STATUS
            $StatusCount = 0; $SelectedStatus = "";
            for($a = 0; $a<=count($Status)-2; $a++){
                if($Status[$a] == "Complete"){
                    $StatusVal = "a.countSync = '5'";
                }else if($Status[$a] == "Incomplete"){
                    $StatusVal = "a.countSync <= '4'"; 
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
                $StatFilter = "";
            }else{
                $StatFilter = "AND ". $getAllStatus;
            }

             // FILTER BY STATUS2
            $StatusCount2 = 0; $SelectedStatus2 = "";
            for($b = 0; $b<= COUNT($Status2)-2; $b++){
                if($Status2[$b] == "Accredited"){
                    $StatusVal2 = "b.uploadingoffiles = '1'";
                }else if($Status2[$b] == "NotAccredited"){
                    $StatusVal2 = "b.uploadingoffiles = '0'"; 
                }

                if($Status2[$b] != ""){
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
            if($Date[0] != "" && $Date[1] != ""){
                $DateFilter = "AND (a.reportDate BETWEEN '". date("Y-m-d", strtotime($Date[0])) ."' AND '". date("Y-m-d", strtotime($Date[1])) ."')";
            }else{
                $DateFilter = "";
            }

			$page = $_POST["page"];
			$rowCount = mysql_fetch_row(mysql_query("SELECT COUNT(a.reportDate) FROM db_syncfilestat as a INNER JOIN tbltrans_tenants as b ON a.tenantID = b.TenantID ". $filter ." AND (b.Status = 'Active' OR b.Status = 'ForEviction' OR b.Status = 'ForRenewal') ". getMallAccess("b.mallID", "AND") ." ". $StatFilter ." ". $StatFilter2 ." ". $SearchFilter ." ". $DateFilter .";", $connection));
			$rowsperpage = 20;
			$range = 3;
			$totalpages = ceil($rowCount[0] / $rowsperpage);
			$prevpage;
			$nextpage;
			if($page > 1 ){
			   echo "<li style='width:50px !important;' onclick='paginationfilemonitoring(1)'><< First</li>";
			   $prevpage = $page - 1;
			   echo "<li style='width:70px !important;' onclick='paginationfilemonitoring(". $prevpage .")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if (($x > 0) && ($x <= $totalpages)){
    			    if ($x == $page){
                        echo "<li id='pgfilemonitoring" . $x . "' class='pgnumpfilemonitoring active' onclick='paginationfilemonitoring(" . $x . ",". $x .")'>" . $x . "</li>";
                    }else{
    			        echo "<li id='pgfilemonitoring" . $x . "' class='pgnumpfilemonitoring' onclick='paginationfilemonitoring(" . $x . ",". $x .")'>" . $x . "</li>";
                    }
		       }
		    }
		    if($page < ($totalpages - $range)){
                echo "<li>...</li>";
            }
		    if ($page != $totalpages && $rowCount[0] != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='paginationfilemonitoring(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='paginationfilemonitoring(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'saveTime2':
			if($_POST['synctype'] == "1"){
				if($_POST['dateFromsync'] == ""){
					$datefrom = "";
				}else{
					$datefrom = ", datefrom = '". date('Y-m-d', strtotime($_POST['dateFromsync'])) ."'";
				}
				if($_POST['dateTosync'] == ""){
					$dateto = "";
				}else{
					$dateto = ", dateto = '". date('Y-m-d', strtotime($_POST['dateTosync'])) ."'";
				}
			}else{
				$datefrom = "";
				$dateto = "";
			}
			$getRecCount = mysql_num_rows(mysql_query("SELECT timetosave FROM db_settimeupload;", $connection));
			if($getRecCount == 0){

				$sql = "INSERT INTO db_settimeupload SET timetosave = '". date('H:i', strtotime($_POST['wholeTime'])) ."', hours = '". $_POST['oras'] ."', minuto = '". $_POST['minuto'] ."', ampm = '". $_POST['ewan'] ."' , synctype = '". $_POST['synctype'] ."', filesyncsetup = '". $_POST['filesyncsetup'] ."', CSVSource = '". $_POST['CSVSource'] ."' ". $datefrom . $dateto .";";

				$Action1 = "ADD";
				if($_POST['filesyncsetup'] != ""){
					if($_POST['filesyncsetup'] == 1){
						$Log .= "File Syncing Setup : Manual|";
					}else{
						$Log .= "File Syncing Setup : Automatic|";
						if($_POST['wholeTime'] != ""){
							$Log .= "Syncing Time. : ". date('H:i', strtotime($_POST['wholeTime'])) ." ". $_POST['ewan'] ."|";
						}
					}
				}
				if($_POST['synctype'] != ""){
					if($_POST['synctype'] == "1"){
						$Log .= "Syncing Type : Date Range|";
						if($_POST['dateFromsync'] != ""){
							$Log .= "Date From : ". date('m/d/Y', strtotime($_POST['dateFromsync'])) ."|";
						}
						if($_POST['dateTosync'] != ""){
							$Log .= "Date To : ". date('m/d/Y', strtotime($_POST['dateTosync'])) ."|";
						}
					}else{
						$Log .= "Syncing Type : Date Today|";
					}
				}
				if($_POST['CSVSource'] != ""){
					$Log .= "Source : ". $_POST['CSVSource'] . "|";
				}
				
			}else{	
				$CurrentSetup = mysql_fetch_array(mysql_query("SELECT timetosave, hours, minuto, ampm, synctype, filesyncsetup, CSVSource, datefrom, dateto FROM db_settimeupload", $connection));

				$sql = "UPDATE db_settimeupload SET timetosave = '". date('H:i', strtotime($_POST['wholeTime'])) ."', hours = '". $_POST['oras'] ."', minuto = '". $_POST['minuto'] ."', ampm = '". $_POST['ewan'] ."' , synctype = '". $_POST['synctype'] ."', filesyncsetup = '". $_POST['filesyncsetup'] ."', CSVSource = '". $_POST['CSVSource'] ."' ". $datefrom . $dateto .";";
				$Action1 = "EDIT";

				if($CurrentSetup['filesyncsetup'] == 1){
					$CFileSyncSetup = "Manual";
				}else{
					$CFileSyncSetup = "Automatic";
				}

				if($_POST['filesyncsetup'] == 1){
					$FileSyncSetup = "Manual";
				}else{
					$FileSyncSetup = "Automatic";
				}

				if($CurrentSetup['synctype'] == 1){
					$CSyncType = "Date Range";
				}else{
					$CSyncType = "Date Today";
				}

				if($_POST['synctype'] == 1){
					$SyncType = "Date Range";
				}else{
					$SyncType = "Date Today";
				}

				if($CurrentSetup['filesyncsetup'] != $_POST['filesyncsetup']){
					if($CurrentSetup['filesyncsetup'] == ""){
						if($_POST['filesyncsetup'] == 1){
							$Log .= "File Syncing Setup : Manual|";
						}else{
							$Log .= "File Syncing Setup : Automatic|";
							if($_POST['wholeTime'] != ""){
								$Log .= "Syncing Time. : ". date('H:i', strtotime($_POST['wholeTime'])) ." ". $_POST['ewan'] ."|";
							}
						}
					}else{
						if($_POST['filesyncsetup'] == 1){
							$Log .= "File Syncing Setup : From ". $CFileSyncSetup ." To ". $FileSyncSetup ."|";
						}else{
							$Log .= "File Syncing Setup : From ". $CFileSyncSetup ." To ". $FileSyncSetup ."|";
							if($_POST['wholeTime'] != ""){
								$Log .= "Syncing Time. : From ". date('H:i', strtotime($CurrentSetup['timetosave'])) ." To ". date('H:i', strtotime($_POST['wholeTime'])) ." ". $_POST['ewan'] ."|";
							}
						}
					}
				}
				if($CurrentSetup['synctype'] != $_POST['synctype']){
					if($_POST['synctype'] == "1"){
						if($CurrentSetup['datefrom'] != "" && $CurrentSetup['datefrom'] != date('Y-m-d', strtotime($_POST['dateFromsync']))){
							$Log .= "Date From : From ". date('m/d/Y', strtotime($CurrentSetup['datefrom'])) ." To ". date('m/d/Y', strtotime($_POST['dateFromsync'])) ."|";
						}
						if($CurrentSetup['dateto'] != "" && $CurrentSetup['dateto'] != date('Y-m-d', strtotime($_POST['dateTosync']))){
							$Log .= "Date To : From ". date('m/d/Y', strtotime($CurrentSetup['dateto'])) ." To ". date('m/d/Y', strtotime($_POST['dateTosync'])) ."|";
						}
						$Log .= "Syncing Type : From ". $CSyncType ." To ". $SyncType ."|";
					}else{
						$Log .= "Syncing Type : From ". $CSyncType ." To ". $SyncType ."|";
					}
				}
				if($CurrentSetup['CSVSource'] != $_POST['CSVSource']){
					$Log .= "Source : From ". $CurrentSetup['CSVSource'] ." To ". $_POST['CSVSource'] ."|";
				}

			}

			$res = mysql_query($sql, $connection);
			if($res == true){
				if($Log != ""){
					$tran_logs = create_logs_per_transaction("modified the setup", "File Monitoring Module", $Log, "", $Action1, "");
				}
				echo 1;
			}
		break;

		case 'getTimeSync':
			$row = mysql_fetch_array(mysql_query("SELECT hours, minuto, ampm, datefrom, dateto, synctype, filesyncsetup, penalty, CSVSource FROM db_settimeupload;", $connection));

			if($row['datefrom'] == "" || $row['datefrom'] == "0000-00-00"){
				$firstdate = "";
			}else{
				$firstdate = date('m/d/Y', strtotime($row['datefrom']));
			}

			if($row['dateto'] == "" || $row['dateto'] == "0000-00-00"){
				$seconddate = "";
			}else{
				$seconddate = date('m/d/Y', strtotime($row['dateto']));
			}

			echo $row['hours'] ."|". $row['minuto'] ."|". $row['ampm'] ."|". $firstdate ."|". $seconddate ."|". $row['synctype'] ."|". $row['filesyncsetup'] ."|". number_format($row['penalty'], "2", ".", ",") ."|". $row['CSVSource'];
		break;

		case 'syncFiles':
			$row = mysql_fetch_array(mysql_query("SELECT timetosave FROM db_settimeupload;", $connection));
			if(date('H:i', strtotime($row[0])) == date('H:i')){
				echo 1;
			}
		break;

		case 'numLayout':
			$amount = str_replace(",", "", $_POST['amount']);
			echo number_format( $amount, "2", ".", ",");
		break;

		case 'mgaKulang':
			$res = mysql_query("SELECT a.refno FROM db_syncfilestat as a INNER JOIN tbltrans_tenants as b ON a.tenantID = b.TenantID WHERE CONCAT(b.owner_lastname, ', ', b.owner_firstname) LIKE '%". $_POST['tenantName'] ."%' AND a.reportDate BETWEEN '". date('Y-m-d', strtotime($_POST['dateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['dateTo'])) ."' AND a.countSync < 5;", $connection);
			while($row = mysql_fetch_array($res)){
				echo "|" . $row[0];
			}
		break;

		case 'fncPostPenalties':
			$arr = explode("|", $_POST['ToBePosted']);
			for($a = 0; $a <= COUNT($arr)-2; $a++){
				$SyncFileStatInfo = mysql_fetch_array(mysql_query("SELECT tenantID, reportDate FROM db_syncfilestat WHERE refno = '". $arr[$a] ."';", $connection));
				$MerchantCode = mysql_fetch_row(mysql_query("SELECT merchant_code FROM tbltrans_tenants WHERE TenantID = '". $SyncFileStatInfo['TenantID'] ."';", $connectio));
				$Penalties = explode("|", $_POST['chkPenalties']);
				for ($b = 0; $b <= COUNT($Penalties)-2; $b++) { 
					$PenaltyInfo = mysql_fetch_array(mysql_query("SELECT PenaltyCode, PenaltyDesc, Amount FROM tblref_penalty WHERE PenaltyCode = '". $Penalties[$b] ."'", $connection));
					$CheckPosted = mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM tbltransaction WHERE xdescription = 'Penalty-". $arr[$a] ."' AND reference = '". $PenaltyInfo['PenaltyCode'] ."';", $connection));
					if($CheckPosted[0] == 0){
						$resPostPenalty = mysql_query("INSERT INTO tbltransaction SET tenantid = '". $SyncFileStatInfo['tenantID'] ."', xcode = '". $PenaltyInfo['PenaltyCode'] ."', description = '". $PenaltyInfo['PenaltyDesc'] ." - ". date('m/d/Y', strtotime($SyncFileStatInfo['reportDate'])) ."', amount = '". $PenaltyInfo['Amount'] ."', qty = '1', balance = '". $PenaltyInfo['Amount'] ."', xdate = '". date('Y-m-d', strtotime(getsysdate())) ."', reference = '". $PenaltyInfo['PenaltyCode'] ."', totalamount = '". $PenaltyInfo['Amount'] ."', xdescription = 'Penalty-". $arr[$a] ."', userid = '". $_SESSION['MMS-UserID'] ."', isPenalty = '1', merchant_code = '". $MerchantCode['merchant_code'] ."';", $connection);
						if($resPostPenalty == true){

							if($arr[$a] != ""){
								$Log .= "Reference No. : ". $arr[$a] ."|";
							}
							if($SyncFileStatInfo['tenantID'] != ""){
								$Log .= "Tenant ID : ". $SyncFileStatInfo['tenantID'] ."|";
							}
							if($PenaltyInfo['PenaltyCode'] != ""){
								$Log .= "Penalty Code : ". $PenaltyInfo['PenaltyCode'] ."|";
							}
							if($PenaltyInfo['PenaltyDesc'] != ""){
								$Log .= "Penalty Description : ". $PenaltyInfo['PenaltyDesc'] ."|";
							}
							if($PenaltyInfo['Amount'] != ""){
								$Log .= "Penalty Amount : ". number_format($PenaltyInfo['Amount'], "2", ".", ",") ."|";
							}
							
							if($Log != ""){
								$tran_logs = create_logs_per_transaction("posted a penalty.", "File Monitoring Module", $Log, "", "ADD", $arr[$a]);
							}

							echo 1;
						}
					}else{
						echo 2;
					}
				}
			}
		break;

		case 'printFMReports':
			if($_POST['mallid'] == ""){
				$mallid = "";
			}else{
				$mallid = "b.mallID = '". $_POST['mallid'] ."' AND";
			}
			$db_settimeupload = mysql_fetch_array(mysql_query("SELECT penalty FROM db_settimeupload;", $connection));
			$sql = "SELECT a.reportDate, b.tradename, a.sales, a.discount, a.void_refund, a.salesperhour, a.paymenttype, a.penalty, a.refno FROM db_syncfilestat AS a INNER JOIN tbltrans_tenants AS b ON a.tenantID = b.TenantID WHERE ".$mallid." reportDate BETWEEN '". date('Y-m-d', strtotime($_POST['dateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['dateTo'])) ."' ORDER BY a.reportDate;";
			$res = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($res)){

				if($row['discount'] == 3){
					$Discount = "<i class='center fa fa-times-circle bigger-120' style='color: #478FCA !important;'></i>";
				}else if($row['discount'] == 2){
					$Discount = "<i class='center fa fa-times-circle bigger-120' style='color: #FF892A !important;'></i>";
				}else if($row['discount'] == 1){
					$Discount = "<i class='center fa fa-check-circle bigger-120' style='color: #3C763D !important;'></i>";
				}else{
					$Discount = "<i class='center fa fa-times-circle bigger-120' style='color: #A94442 !important'></i>";
				}

				if($row['salesperhour'] == 3){
					$HourlySales = "<i class='center fa fa-times-circle bigger-120' style='color: #478FCA !important;'></i>";
				}else if($row['salesperhour'] == 2){
					$HourlySales = "<i class='center fa fa-times-circle bigger-120' style='color: #FF892A !important;'></i>";
				}else if($row['salesperhour'] == 1){
					$HourlySales = "<i class='center fa fa-check-circle bigger-120' style='color: #3C763D !important;'></i>";
				}else{
					$HourlySales = "<i class='center fa fa-times-circle bigger-120' style='color: #A94442 !important'></i>";
				}

				if($row['void_refund'] == 3){
					$Void = "<i class='center fa fa-times-circle bigger-120' style='color: #478FCA !important;'></i>";
				}else if($row['void_refund'] == 2){
					$Void = "<i class='center fa fa-times-circle bigger-120' style='color: #FF892A !important;'></i>";
				}else if($row['void_refund'] == 1){
					$Void = "<i class='center fa fa-check-circle bigger-120' style='color: #3C763D !important;'></i>";
				}else{
					$Void = "<i class='center fa fa-times-circle bigger-120' style='color: #A94442 !important'></i>";
				}

				if($row['paymenttype'] == 3){
					$PaymentType = "<i class='center fa fa-times-circle bigger-120' style='color: #478FCA !important;'></i>";
				}else if($row['paymenttype'] == 2){
					$PaymentType = "<i class='center fa fa-times-circle bigger-120' style='color: #FF892A !important;'></i>";
				}else if($row['paymenttype'] == 1){
					$PaymentType = "<i class='center fa fa-check-circle bigger-120' style='color: #3C763D !important;'></i>";
				}else{
					$PaymentType = "<i class='center fa fa-times-circle bigger-120' style='color: #A94442 !important'></i>";
				}

				if($row['sales'] == 3){
					$Sales = "<i class='center fa fa-times-circle bigger-120' style='color: #478FCA !important;'></i>";
				}else if($row['sales'] == 2){
					$Sales = "<i class='center fa fa-times-circle bigger-120' style='color: #FF892A !important;'></i>";
				}else if($row['sales'] == 1){
					$Sales = "<i class='center fa fa-check-circle bigger-120' style='color: #3C763D !important;'></i>";
				}else{
					$Sales = "<i class='center fa fa-times-circle bigger-120' style='color: #A94442 !important'></i>";
				}

				echo 	"<tr>
							<td valign='top'>". date('m/d/Y', strtotime($row['reportDate'])) ."</td>
							<td valign='top'>". $row['tradename'] ."</td>
							<td valign='top' style='text-align: center;'>". $Discount ."</td>
							<td valign='top' style='text-align: center;'>". $HourlySales ."</td>
							<td valign='top' style='text-align: center;'>". $Void ."</td>
							<td valign='top' style='text-align: center;'>". $PaymentType ."</td>
							<td valign='top' style='text-align: center;'>". $Sales ."</td>
							<td>";
								$resPenalty = mysql_query("SELECT reference FROM tbltransaction WHERE xdescription LIKE '%". $row['refno'] ."%';", $connection);
								while($rowPenalty = mysql_fetch_array($resPenalty)){
									echo "<i class='center fa fa-square bigger-120' style='color: #A94442;'></i> ". $rowPenalty['reference'] ."<br>";
								}
			echo		"</td>
						</tr>";
			}
		    echo "|".date('F d, Y', strtotime($_POST['dateFrom']))."|".date('F d, Y', strtotime($_POST['dateTo']));
		break;

		case 'getSetupInfo':
			$FMSetup = mysql_fetch_array(mysql_query("SELECT synctype, datefrom, dateto, CSVSource FROM db_settimeupload", $connection));
			echo $FMSetup['synctype'] ."|". $FMSetup['datefrom'] ."|". $FMSetup['dateto'] ."|". $FMSetup['CSVSource'];
		break;

		case 'getCurrentlyPosted':
			$arr = explode("|", $_POST['TobePosted']);
			$PostedPenaltyList = "";
			$resPosetdPenalty = mysql_query("SELECT reference FROM tbltransaction WHERE xdescription LIKE '%". $arr[0] ."%';", $connection);
			while($rowPostedPenalty = mysql_fetch_array($resPosetdPenalty)){
				$PostedPenaltyList .= $rowPostedPenalty['reference'] ."|";
			}
			$Penalties = explode("|", $PostedPenaltyList);
			$PenaltyList = "";
			for ($b = 0; $b <= COUNT($Penalties)-2; $b++) { 
				$resPenalty = mysql_fetch_array(mysql_query("SELECT id FROM tblref_penalty WHERE PenaltyCode = '". $Penalties[$b] ."';", $connection));
				$PenaltyList .= $resPenalty['id'] . "|";
			}
			echo $PenaltyList;
		break;

		case 'postPenalty':
			$res = mysql_query("SELECT PenaltyCode, PenaltyDesc, Amount, id FROM tblref_penalty WHERE PenaltyCode LIKE '%". $_POST['key'] ."%' OR PenaltyDesc LIKE '%". $_POST['key'] ."%';", $connection);
			while($row = mysql_fetch_array($res)){
				echo 	"<tr id='trr". $row['id'] ."'>
							<td style='display: none;'><input type='checkbox' value='". $row['id'] ."' class='chkPenaltyCode chkPenaltyCode". $row['id'] ."' id='". $row['PenaltyCode'] ."'></td>
							<td>". $row['PenaltyCode'] ."</td>
							<td>". $row['PenaltyDesc'] ."</td>
							<td>". number_format($row['Amount'], "2", ".", ",") ."</td>
						</tr>";
			}
		break;
	}
?>