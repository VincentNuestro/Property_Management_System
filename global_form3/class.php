<?php
	session_start();
	include("../connect.php");
	switch ($_POST['form']) {
		case 'fncgetMonthDay':
			$DateFrom = $_POST['DateFrom'];
			$DateTo = $_POST['DateTo'];
			$Diff = abs(strtotime($DateTo) - strtotime($DateFrom));
			$inYear = floor($Diff / ( 365 * 60 * 60 * 24));
			$inMonths = floor(($Diff - $inYear * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
			if(date('Y-m-d', strtotime($_POST['DateTo'])) == date('Y-m-d', strtotime($DateFrom))){
				$inDays = 1;
			}else{
				$inDays = floor(($Diff - $inYear * 365 * 60 * 60 * 24 - $inMonths * 30 * 60 * 60 * 24) / (60 * 60 * 24));
			}

			echo $inMonths ."|". $inYear . "|" . floatval($inDays + 1);
		break;

		case 'getOccupancyDateTo':
			$RefDate = $_POST['DateFrom'];
			if($_POST['DayCount'] > 0 && $_POST['DayCount'] != ''){
				$PlusDay = " +". $_POST['DayCount'] ." day";
			}else{
				$PlusDay = "";
			}
			if($_POST['YearCount'] > 0 && $_POST['YearCount'] != ''){
				$PlusYear = " +". $_POST['YearCount'] ." year";
			}else{
				$PlusYear = "";
			}
			if($_POST['MonthCount'] > 0 && $_POST['MonthCount'] != ''){
				$PlusMonth = " +". $_POST['MonthCount'] ."month";
			}else{
				$PlusMonth = "";
			}
			$RefDate = date('Y-m-d', strtotime($RefDate . $PlusMonth . $PlusYear . $PlusDay));
			// if(SysLeaseSetup('isOccupancy') == '1'){
				$isOccupancy = ' -1 day';
			// }else{
			// 	$isOccupancy = '';
			// }
			if(($_POST['DayCount'] == 0 || $_POST['DayCount'] == '') && ($_POST['YearCount'] == 0 || $_POST['YearCount'] == '') && ($_POST['MonthCount'] == 0 || $_POST['MonthCount'] == '')){
				echo $_POST['DateFrom'];
			}else{
				echo date('m/d/Y', strtotime($RefDate.$isOccupancy));
			}
		break;

		case 'fncgetPaymentSchedule':
			$header = explode("|", getrentvattype($_SESSION['MMS-Designation']));
			$isVatable = $header[1];
			$isInclusive = $header[2];
			$VATPercent = floatval($header[0]) / 100;
			if($_POST['isDaily'] == 'daily'){
				$mgaMeron = "";
				$arr = explode("|", $_POST['Charges']);
				for ($i=0; $i <= count($arr)-2; $i++) { 
					$mgaMeron .= "'" . $arr[$i] . "'" . ",";
				}
				$mgaUnits = "";
				$arr = explode("|", $_POST['SelectedUnits']);
				for ($i=0; $i <= count($arr)-2; $i++) { 
					$mgaUnits .= "'" . $arr[$i] . "'" . ",";
				}
	            $TotalArea = 0;
				$resUnitArea = mysql_query("SELECT area, sqm_width, sqm_height FROM tblref_unit WHERE unitid IN (". substr(trim($mgaUnits), 0, -1) .");", $connection);
				while($rowArea = mysql_fetch_array($resUnitArea)){
                    if(SysLeaseSetup('floorandunitmeasurement') == "Area"){
                    	$AreaVal = floatval($rowArea['area']);
                    }else{
                    	$AreaVal = floatval($rowArea['sqm_width']) * floatval($rowArea['sqm_height']);
                    }
					$TotalArea += $AreaVal;
				}
				$StartDate = date('m/d/Y', strtotime($_POST['DateFrom']));
				$NumberofDays = (strtotime($_POST["DateTo"]) - strtotime($_POST["DateFrom"])) / (60 * 60 * 24);
				for ($i = 0; $i <= $NumberofDays; $i++) { 
					// $DailyRent = floatval($_POST['RentAmount']) / date('t', strtotime($StartDate));
					$DailyRent = floatval($_POST['RentAmount']);
					if($_POST['VATSetup'] == 0){
						if($isVatable == "yes"){
	                        if($isInclusive == "inc"){ //VAT IS INCLUSIVE
	                            $VATAmount = ( floatval($DailyRent) / 1.12 ) * $VATPercent;
	                            $RentLessVAT = floatval($DailyRent) - $VATAmount;
	                            $Rent = $RentLessVAT;
								$VAT = $VATAmount;
	                            $TotalRent = $VAT + $Rent;
	                            $Adjustment = 0;
	                        }else{ //VAT IS EXCLUSIVE
	                            $VATAmount = floatval($DailyRent) * $VATPercent;
	                            $RentPlusVAT = floatval($DailyRent);
	                            $Rent = floatval($DailyRent);
	                            $VAT = $VATAmount;
	                            $TotalRent = floatval($DailyRent) + $VATAmount;
	                            $Adjustment = 0;
	                        }
	                    }else{
	                        $Rent = $DailyRent;
	                        $VAT = "0.00";
	                        $TotalRent = floatval($DailyRent);
	                        $Adjustment = 0;
	                    }
	                }else{
	                	$Rent = $DailyRent;
                        $VAT = "0.00";
                        $TotalRent = floatval($DailyRent);
                        $Adjustment = 0;
	                }
	                
					echo '<tr id="'. date("m/d/Y", strtotime($StartDate)) .'" class="unselected">
							<td style="display: none;"><input type"hidden" class="txtChargeDate" value="'. $row['EndDate'] .'"><input type"hidden" class="txtChargeCode" value="Rent ('. date("F Y", strtotime($row["BillYear"]."-".$row["BillMonth"]."-01")) .')"></td>
							<td>'. date("m/d/Y", strtotime($StartDate)) .'</td>
							<td>Rent ('. date("F d, Y", strtotime($StartDate)) .')</td>
							<td style="text-align: right;">'. number_format($Rent, 2, '.', ',') .'</td>
							<td style="text-align: right;">'. number_format(0, 2, '.', ',') .'</td>
							<td style="text-align: right;">'. number_format(0, 2, '.', ',') .'</td>
							<td style="text-align: right;">'. number_format(0, 2, '.', ',') .'</td>
							<td style="text-align: right;">'. number_format($VATAmount, 2, '.', ',') .'</td>';
					echo	'<td style="text-align: right;" class="lblRentalCharges">'. number_format($TotalRent, 2, '.', ',') .'</td>
						</tr>';
					
					$resCharges = mysql_query("SELECT CHARGE_DESC, RATE, CHARGE_ID, RATE_TYPE FROM tblref_refcharges WHERE CHARGE_ID IN (". substr(trim($mgaMeron), 0, -1) .");", $connection);
					while($rowCharges = mysql_fetch_array($resCharges)){
						if($rowCharges['RATE_TYPE'] == 'Fixed'){
							$isFixedArr[] = $rowCharges['CHARGE_ID'];
						}
						if($rowCharges['RATE_TYPE'] == "Persqm"){
		            		$ChargeAmount = floatval($rowCharges['RATE']) * floatval($TotalArea);
		            	}else if($rowCharges['RATE_TYPE'] == "Daily"){
		            		$ChargeAmount = floatval($rowCharges['RATE']) * floatval($Days);
		            	}else if($rowCharges['RATE_TYPE'] == "Fixed"){
		            		$ChargeAmount = floatval($rowCharges['RATE']);
		            	}else{
		            		$ChargeAmount = floatval($rowCharges['RATE']);
		            	}

						if($_POST['VATSetup'] == 0){
							if($isVatable == "yes"){
		                        if($isInclusive == "inc"){ //VAT IS INCLUSIVE
		                            $VATAmount = ( floatval($ChargeAmount) / 1.12 ) * $VATPercent;
		                            $RentLessVAT = floatval($ChargeAmount) - $VATAmount;
		                            $Rent = $RentLessVAT;
									$VAT = $VATAmount;
		                            $TotalRent = $VAT + $Rent;
		                        }else{ //VAT IS EXCLUSIVE
		                            $VATAmount = floatval($ChargeAmount) * $VATPercent;
		                            $RentPlusVAT = floatval($ChargeAmount);
		                            $Rent = floatval($ChargeAmount);
		                            $VAT = $VATAmount;
		                            $TotalRent = floatval($ChargeAmount) + $VATAmount;
		                        }
		                    }else{
		                        $Rent = $ChargeAmount;
		                        $VAT = "0.00";
		                        $TotalRent = floatval($ChargeAmount);
		                    }
		                }else{
		                	$Rent = $ChargeAmount;
	                        $VAT = "0.00";
	                        $TotalRent = floatval($ChargeAmount);
		                }
						// if(in_array($isFixedArr, trim($rowCharges['CHARGE_ID']))){
							echo '<tr id="'.date("m/d/Y", strtotime($StartDate)).'" class="unselected">
									<td style="display: none;"><input type"hidden" class="txtChargeDate" value="'. $row['EndDate'] .'"><input type"hidden" class="txtChargeCode" value="'. $rowCharges['CHARGE_ID'] .'"></td>
									<td>'. date("m/d/Y", strtotime($StartDate)) .'</td>
									<td>'. $rowCharges['CHARGE_DESC'] .'</td>
									<td style="text-align: right;">'. number_format($Rent, 2, '.', ',') .'</td>
									<td style="text-align: right;">0%</td>
									<td style="text-align: right;">0.00</td>
									<td style="text-align: right;">'. number_format(0, 2, '.', ',') .'</td>
									<td style="text-align: right;">'. number_format($VATAmount, 2, '.', ',') .'</td>';
							echo	'<td style="text-align: right;" class="lblRentalCharges">'. number_format($TotalRent, 2, '.', ',') .'</td>
								</tr>';
							echo "2</br>";
						// }else{
							
						// }
					}
					$StartDate = date('m/d/Y', strtotime($StartDate .'+1 day'));
				}
			}else{
				$Escalation = 0;
				$EscalationRate = "0%";
				$isFixedArr = array();
				if(date('Y-m-d', strtotime($_POST['DateFrom'])) <= date('Y-m-d', strtotime(getsysdate()))){
					$DateFrom = date('Y-m-d', strtotime(getsysdate()));
				}else{
					$DateFrom = date('Y-m-d', strtotime($_POST['DateFrom']));
				}

				$res = mysql_query("SELECT DueDate, BillMonth, BillYear, StartDate, EndDate, MallID FROM tblref_billperiod WHERE id BETWEEN (SELECT id FROM tblref_billperiod WHERE '". $DateFrom ."' BETWEEN StartDate AND EndDate) AND (SELECT id FROM tblref_billperiod WHERE '". date('Y-m-d', strtotime($_POST['DateTo'])) ."' BETWEEN StartDate AND EndDate);", $connection);
				$chkBillPeriod = mysql_num_rows($res);
				if($chkBillPeriod == 0){
					echo 1;
				}else{
					while($row = mysql_fetch_array($res)){
						
						$Days = (strtotime($row["EndDate"]) - strtotime($row["StartDate"])) / (60 * 60 * 24) + 1;
						$OccupiedDaysCount = (strtotime($_POST["DateTo"]) - strtotime($_POST["DateFrom"])) / (60 * 60 * 24) + 1;

						// $getTenure = abs(strtotime(date('Y-m-d', strtotime($row['EndDate']))) - strtotime(date('Y-m-d', strtotime($_POST['DateFrom']))));
						// $Tenure = floor($getTenure / (365*60*60*24));
						// if(floatval($Tenure) >= floatval($_POST['EscaStart'])){
						// 	if($_POST['EscaYearBasis'] == 1){
						// 		$Escalation = floatval($_POST['RentAmount']) * (floatval($_POST['EscaRate'] * (($Tenure + 1) - $_POST['EscaStart']))  / 100);
						// 	}else{
						// 		if($_POST['EscaYearBasis'] % 2){
						// 			$Escalation = floatval($_POST['RentAmount']) * (floatval($_POST['EscaRate'] * round($Tenure/ $_POST['EscaYearBasis'], 0, PHP_ROUND_HALF_UP))  / 100);
						// 		}else{
						// 			$Escalation = floatval($_POST['RentAmount']) * (floatval($_POST['EscaRate'] * round($Tenure/ $_POST['EscaYearBasis'], 0, PHP_ROUND_HALF_DOWN))  / 100);
						// 		}
						// 	}
						// }else{
						// }

						$Escalation2 = explode("@", $_POST['Escalation']);
						for ($i = 0; $i <= COUNT($Escalation2) -2; $i++) { 
							$arr = explode("|", $Escalation2[$i]);
							if(date('F Y', strtotime($arr[0])) == date("F Y", strtotime($row['EndDate']))){
								$Escalation = $_POST['RentAmount'] * floatval($arr[1] / 100);
								$EscalationRate = $arr[1] ."%";
							}
						}

						$RentAmount = $_POST['RentAmount'] + $Escalation;
						if($OccupiedDaysCount >= $Days){
							$RentBasedonDays = $RentAmount;
							if($_POST['VATSetup'] == 0){
								if($isVatable == "yes"){
			                        if($isInclusive == "inc"){ //VAT IS INCLUSIVE
			                            $VATAmount = ( floatval($RentAmount) / 1.12 ) * $VATPercent;
			                            $RentLessVAT = floatval($RentAmount) - $VATAmount;
			                            $Rent = $RentLessVAT;
										$VAT = $VATAmount;
			                            $TotalRent = $VAT + $Rent;
			                            $Adjustment = 0;
			                        }else{ //VAT IS EXCLUSIVE
			                            $VATAmount = floatval($RentAmount) * $VATPercent;
			                            $RentPlusVAT = floatval($RentAmount);
			                            $Rent = floatval($RentAmount);
			                            $VAT = $VATAmount;
			                            $TotalRent = floatval($RentAmount) + $VATAmount;
			                            $Adjustment = 0;
			                        }
			                    }else{
			                        $Rent = $RentAmount;
			                        $VAT = "0.00";
			                        $TotalRent = floatval($RentAmount);
			                        $Adjustment = 0;
			                    }
			                }else{
			                	$Rent = $RentAmount;
		                        $VAT = "0.00";
		                        $TotalRent = floatval($RentAmount);
		                        $Adjustment = 0;
			                }
						}else{
							$RentBasedonDays = $RentAmount / $Days * $OccupiedDaysCount;
							if($_POST['VATSetup'] == 0){
								if($isVatable == "yes"){
			                        if($isInclusive == "inc"){ //VAT IS INCLUSIVE
			                            $VATAmount = ( floatval($RentBasedonDays) / 1.12 ) * $VATPercent;
			                            $RentLessVAT = floatval($RentBasedonDays) - $VATAmount;
			                            $Rent = $RentLessVAT;
										$VAT = $VATAmount;
			                            $TotalRent = $VAT + $RentBasedonDays;
			                            $Adjustment = $RentAmount - $Rent;
			                        }else{ //VAT IS EXCLUSIVE
			                            $VATAmount = floatval($RentBasedonDays) * $VATPercent;
			                            $RentPlusVAT = floatval($RentBasedonDays);
			                            $Rent = floatval($RentBasedonDays);
			                            $VAT = $VATAmount;
			                            $TotalRent = floatval($RentBasedonDays) + $VATAmount;
			                            $Adjustment = $RentAmount - $Rent;
			                        }
			                    }else{
			                        $Rent = $RentBasedonDays;
			                        $VAT = "0.00";
			                        $TotalRent = floatval($RentBasedonDays);
			                        $Adjustment = $RentAmount - $Rent;
			                    }
			                }else{
			                	$Rent = $RentBasedonDays;
		                        $VAT = "0.00";
		                        $TotalRent = floatval($RentBasedonDays);
		                        $Adjustment = $RentAmount - $Rent;
			                }
						}

						if($Adjustment >= 1){
							$Adjustment2 = "-".$Adjustment;
						}else{
							$Adjustment2 = 0;
						}

						echo '<tr id="'. date("m/d/Y", strtotime($row['DueDate'])) .'" class="unselected">
								<td style="display: none;"><input type"hidden" class="txtChargeDate" value="'. $row['EndDate'] .'"><input type"hidden" class="txtChargeCode" value="Rent ('. date("F Y", strtotime($row["BillYear"]."-".$row["BillMonth"]."-01")) .')"></td>
								<td>'. date("m/d/Y", strtotime($row['DueDate'])) .'</td>
								<td>Rent ('. date("F Y", strtotime($row["BillYear"]."-".$row["BillMonth"]."-01")) .')</td>
								<td style="text-align: right;">'. number_format($Rent, 2, '.', ',') .'</td>
								<td style="text-align: right;">'. $EscalationRate .'</td>
								<td style="text-align: right;">'. number_format($Escalation, 2, '.', ',') .'</td>
								<td style="text-align: right;">'. number_format($Adjustment2, 2, '.', ',') .'</td>
								<td style="text-align: right;">'. number_format($VATAmount, 2, '.', ',') .'</td>';
						echo	'<td style="text-align: right;" class="lblRentalCharges">'. number_format($TotalRent, 2, '.', ',') .'</td>
							</tr>';

						$mgaUnits = "";
						$arr = explode("|", $_POST['SelectedUnits']);
						for ($i=0; $i <= count($arr)-2; $i++) { 
							$mgaUnits .= "'" . $arr[$i] . "'" . ",";
						}
			            $TotalArea = 0;
						$resUnitArea = mysql_query("SELECT area, sqm_width, sqm_height FROM tblref_unit WHERE unitid IN (". substr(trim($mgaUnits), 0, -1) .");", $connection);
						while($rowArea = mysql_fetch_array($resUnitArea)){
                            if(SysLeaseSetup('floorandunitmeasurement') == "Area"){
                            	$AreaVal = floatval($rowArea['area']);
                            }else{
                            	$AreaVal = floatval($rowArea['sqm_width']) * floatval($rowArea['sqm_height']);
                            }
							$TotalArea += $AreaVal;
						}

						$mgaMeron = "";
						$ChargeAmount = 0;
						$arr = explode("@", $_POST['Charges']);
						for ($i=0; $i <= count($arr)-2; $i++) { 
							$arr2 = explode("|", $arr[$i]);
							$rowCharges = mysql_fetch_array(mysql_query("SELECT CHARGE_DESC, RATE, CHARGE_ID, RATE_TYPE FROM tblref_refcharges WHERE CHARGE_ID = '". $arr2[0] ."';", $connection));
							if($rowCharges['RATE_TYPE'] == 'Fixed'){
								$isFixedArr[] = $rowCharges['CHARGE_ID'];
							}
							if($rowCharges['RATE_TYPE'] == "Persqm"){
			            		$ChargeAmount = floatval($arr2[1]) * floatval($TotalArea);
			            	}else if($rowCharges['RATE_TYPE'] == "Daily"){
			            		$ChargeAmount = floatval($arr2[1]) * floatval($Days);
			            	}else if($rowCharges['RATE_TYPE'] == "Fixed"){
			            		$ChargeAmount = floatval($arr2[1]);
			            	}else{
			            		$ChargeAmount = floatval($arr2[1]);
			            	}

							if($_POST['VATSetup'] == 0){
								if($isVatable == "yes"){
			                        if($isInclusive == "inc"){ //VAT IS INCLUSIVE
			                            $VATAmount = ( floatval($ChargeAmount) / 1.12 ) * $VATPercent;
			                            $RentLessVAT = floatval($ChargeAmount) - $VATAmount;
			                            $Rent = $RentLessVAT;
										$VAT = $VATAmount;
			                            $TotalRent = $VAT + $Rent;
			                        }else{ //VAT IS EXCLUSIVE
			                            $VATAmount = floatval($ChargeAmount) * $VATPercent;
			                            $RentPlusVAT = floatval($ChargeAmount);
			                            $Rent = floatval($ChargeAmount);
			                            $VAT = $VATAmount;
			                            $TotalRent = floatval($ChargeAmount) + $VATAmount;
			                        }
			                    }else{
			                        $Rent = $ChargeAmount;
			                        $VAT = "0.00";
			                        $TotalRent = floatval($ChargeAmount);
			                    }
			                }else{
			                	$Rent = $ChargeAmount;
		                        $VAT = "0.00";
		                        $TotalRent = floatval($ChargeAmount);
			                }
							// if(in_array($isFixedArr, trim($rowCharges['CHARGE_ID']))){
								echo '<tr id="'.date("m/d/Y", strtotime($row['DueDate'])).'" class="unselected">
										<td style="display: none;"><input type"hidden" class="txtChargeDate" value="'. $row['EndDate'] .'"><input type"hidden" class="txtChargeCode" value="'. $rowCharges['CHARGE_ID'] .'"></td>
										<td>'. date("m/d/Y", strtotime($row['DueDate'])) .'</td>
										<td>'. $rowCharges['CHARGE_DESC'] .'</td>
										<td style="text-align: right;">'. number_format($Rent, 2, '.', ',') .'</td>
										<td style="text-align: right;">0%</td>
										<td style="text-align: right;">0.00</td>
										<td style="text-align: right;">'. number_format(0, 2, '.', ',') .'</td>
										<td style="text-align: right;">'. number_format($VATAmount, 2, '.', ',') .'</td>';
								echo	'<td style="text-align: right;" class="lblRentalCharges">'. number_format($TotalRent, 2, '.', ',') .'</td>
									</tr>';
								echo "2</br>";
							// }else{
								
							// }
						}
					}
				}
			}
		break;

		case 'getDefaultCharges':
			$res = mysql_query("SELECT CHARGE_ID, CHARGE_DESC, RATE_TYPE, RATE, OTHER_REASON, CHARGE_TYPE FROM tblref_refcharges WHERE isDefault = '1' ", $connection);
			while($row = mysql_fetch_array($res)){

				if($row['RATE_TYPE'] == "Other"){
					$Parusa = $row['OTHER_REASON'];
				}else if($row['RATE_TYPE'] == "Occurence"){
					$Parusa = number_format($row['RATE'], "2", ".", ",") . " " . $row['OTHER_REASON'];
				}else{
					$Parusa = number_format($row['RATE'], "2", ".", ",") . " " . $row['RATE_TYPE'];
				}

				echo "<tr id='". $row['CHARGE_ID'] ."'>
							<td>". $row['CHARGE_DESC'] ."</td>
							<td>". $row['CHARGE_TYPE'] ."</td>
							<td>". $Parusa ."</td>
							<td class='hidden getthisvalue'>". floatval($row['RATE']) ."</td>
							<td style='text-align: center;z-index: 0;'><button class='btn btn-xs btn-danger isFinal btn-round' onclick='$(\"#". $row['CHARGE_ID'] ."\").remove(); fncgetPaymentSchedule();'><i class='fa fa-trash-o'></i></button></td>
						</tr>";

			}
		break;

		case 'getreqlist':
			$i = 0;
			$res = mysql_query("SELECT id, requirements, override FROM tblref_applicationrequirements;", $connection);
			while($row = mysql_fetch_array($res)){
				$i++;
				$id = "posting_commentreq_". $i;
				echo '	<div class="row">
						 	<label class="col-xs-8">'. $row["requirements"] .'</label>
						 	<div class="col-xs-1 center"><i style="color:red;margin-top:5px;" class="ace-icon fa fa-remove bigger-120" id="'. $id .'_icon"></i></div>
							<div class="col-xs-3" style="white-space: nowrap;text-overflow: ellipsis;overflow: hidden;">
							<form name="posting_comment" class="form_lease_application_req_2" id="posting_commentreq_'. $i .'">
	                                <input type="hidden" name="txtRequirementInquiryID" class="txtRequirementInquiryID">
	                                <input type="hidden" name="txtRequirementApplicationID" class="txtRequirementApplicationID">
	                                <input type="hidden" name="txtProposalNum" class="txtProposalNum" value="1">
	                            	<input type="file" class="LeasingApplicationRequirement DisablePayInfo2 txtReservationReq2 upload_app_req" name="attachment_filess" id="overridemoko'. $row["id"] .'" onchange="chkclippeddocx($(this))"/>
	                        		<input type="hidden" name="hiddenidss" value="'. $row["id"] .'">
	                      		</form>
	                      	</div>
	                    </div>';
            }
		break;

		case 'getperlist':
			$i = 0;
	        $res = mysql_query("SELECT id, DESCRIPTION FROM tblref_typeofpermits;", $connection);
	        while($row = mysql_fetch_array($res)){
				$i++;
				$id = "posting_commentpermit_".$i;
				echo 	'<div class="row">
						 	<label class="col-xs-5">'.$row["DESCRIPTION"].'</label>
						 	<div class="col-xs-1">Exp. Date</div>
							<form name="posting_comment" class="form_lease_application_permit" id="posting_commentpermit_'.$i.'">
                          	<div class="col-xs-2">
                          		<input type="text" name="expiry_date" class="date-picker form-control DisablePayInfo2 txtReservationReq2" value="'. date('m/d/Y') .'">
                          	</div>
						 	<div class="col-xs-1 center">
						 		<i style="color:red;margin-top:5px;" class="ace-icon fa fa-remove bigger-120" id="'.$id.'_icon"></i>
						 	</div>
							<div class="col-xs-3" style="white-space: nowrap;text-overflow: ellipsis;overflow: hidden;">
                                <input type="hidden" name="txtPermitInquiryID" class="txtPermitInquiryID">
                                <input type="hidden" name="txtPermitApplicationID" class="txtPermitApplicationID">
                                <input type="hidden" name="txtPermitProposalNum" class="txtPermitProposalNum" value="1">
                                <input type="file" class="upload_app_permit DisablePayInfo2 txtReservationReq2" name="attachment_filess" id="overridepermit'.$row['id'].'" onchange="chkclippeddocx2($(this))"/>
                                <input type="hidden" name="hiddenidss" value="'.$row["id"].'">
                            </div>
                          	</form>
                        </div>';
	        }
		break;

		case 'DelProRentConsStarDate':
			echo date('m/d/Y', strtotime($_POST['DateFrom']. '-'. $_POST['StartDate'] .'day'));
		break;

		case 'showModalNDTAddCharges':
			$header = explode("|", getrentvattype($_SESSION['MMS-Designation']));
			$isVatable = $header[1];
			$isInclusive = $header[2];
			$VATPercent = floatval($header[0]) / 100;
			$mgaMeron = "";
			$arr = explode("|", $_POST['ids']);
			for ($i=0; $i <= count($arr)-2; $i++) { 
				$mgaMeron .= "'" . $arr[$i] . "'" . ",";
			}

			if($_POST['ids'] != ""){
				$tanong = "AND CHARGE_ID NOT IN (". substr(trim($mgaMeron), 0, -1) .")";
			}else{
				$tanong = "";
			}

			if($_POST['isDaily'] == 'daily'){
				$FilterRate = "Daily";
			}else{
				$FilterRate = "Monthly";
			}
			$res = mysql_query("SELECT CHARGE_ID, CHARGE_DESC, RATE_TYPE, RATE, OTHER_REASON, CHARGE_TYPE FROM tblref_refcharges WHERE CHARGE_DESC LIKE '%". $_POST['key'] ."%' ". $tanong ." ORDER BY CHARGE_DESC ASC ", $connection);
			while($row = mysql_fetch_array($res)){

				if($row['RATE_TYPE'] == "Other"){
					$Parusa = $row['OTHER_REASON'];
					$Rate = 0.00;
					$RateType = $row['OTHER_REASON'];
				}else if($row['RATE_TYPE'] == "Occurence"){
					$Parusa = number_format($row['RATE'], "2", ".", ",") . " " . $row['OTHER_REASON'];
					$Rate = number_format($row['RATE'], "2", ".", ",");
					$RateType = $row['OTHER_REASON'];
				}else{
					$Parusa = number_format($row['RATE'], "2", ".", ","). " " . $row['RATE_TYPE'];
					$Rate = number_format($row['RATE'], "2", ".", ",");
					$RateType = $row['RATE_TYPE'];
				}

				// if($_POST['VATSetup'] == 0){
				// 	if($isVatable == "yes"){
	   //                  if($isInclusive == "inc"){ //VAT IS INCLUSIVE
	   //                      $VATAmount = ( floatval($row['RATE']) / 1.12 ) * $VATPercent;
	   //                      $RentLessVAT = floatval($row['RATE']) - $VATAmount;
	   //                      $Rent = $RentLessVAT;
				// 			$VAT = $VATAmount;
	   //                      $ChargeAmount = $VAT + $Rent;
	   //                  }else{ //VAT IS EXCLUSIVE
	   //                      $VATAmount = floatval($row['RATE']) * $VATPercent;
	   //                      $RentPlusVAT = floatval($row['RATE']);
	   //                      $Rent = floatval($row['RATE']);
	   //                      $VAT = $VATAmount;
	   //                      $ChargeAmount = floatval($row['RATE']) + $VATAmount;
	   //                  }
	   //              }else{
	   //                  $Rent = $row['RATE'];
	   //                  $VAT = "0.00";
	   //                  $ChargeAmount = floatval($row['RATE']);
	   //              }
	   //          }else{
	   //          	$Rent = $row['RATE'];
	   //              $VAT = "0.00";
	                $ChargeAmount = floatval($row['RATE']);
	            // }

				echo "	<tr id='TR". $row['CHARGE_ID'] ."'>
							<td class='ChargeID'>". $row['CHARGE_ID'] ."</td>
							<td class='ChargeDesc'>". $row['CHARGE_DESC'] ."</td>
							<td>". $row['CHARGE_TYPE'] ."</td>
							<td>". $Parusa ."</td>
							<td class='hide OrigRate'>". $Rate ."</td>
							<td class='hide ChargeType'>". $RateType ."</td>
						</tr>";
			}
		break;

		case 'showtblLNDTtermsandconditionlist':
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
								<td style='display: none;'><input type='checkbox' value='". $row[2] ."' class='chkNDTselectedTAC chkNDTselectedTAC".$row[2]."'></td>
								<td>".$row[1]."</td>
								<td>".$row[3]."</td>
								<td>".$row[4]."</td>
							</tr>
						";
			}
		break;

		case 'loadentriesNDTTAC':
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

		case 'loadpageNDTTAC':
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
			   echo "<li style='width:50px !important;' onclick='paginationNDTTAC(1)'><< First</li>";
			   $prevpage = $page - 1;
			   echo "<li style='width:70px !important;' onclick='paginationNDTTAC(". $prevpage .")'>< Previous</li>";
			}

			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if (($x > 0) && ($x <= $totalpages)){
    			    if ($x == $page){
                        echo "<li id='pgNDTTAC" . $x . "' class='pgnumNDTTAC active' onclick='paginationNDTTAC(" . $x . ",". $x .")'>" . $x . "</li>";
                    }else{
    			        echo "<li id='pgNDTTAC" . $x . "' class='pgnumNDTTAC' onclick='paginationNDTTAC(" . $x . ",". $x .")'>" . $x . "</li>";
                    }
		       	}
		    }
		    if($page < ($totalpages - $range)){
                echo "<li>...</li>";
            }

		    if ($page != $totalpages && $num != 0){
		       $nextpage = $page + 1;
		       echo "<li style='width:50px !important;' onclick='paginationNDTTAC(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       echo "<li style='width:50px !important;' onclick='paginationNDTTAC(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'loadgroupselection':
			echo "<option value=''>-- Select Group Name --</option>";
			$res = mysql_query("SELECT Group_ID, Group_Name FROM tblgroups WHERE Status = '1'", $connection);
			while($row = mysql_fetch_array($res)){
				echo "<option value='".$row[0]."'>".$row[1]."</option>";
			}
		break;

		case 'addselection':
			$arr = explode("|", $_POST['ids']);
			for ($i=0; $i <= COUNT($arr)-2; $i++) { 
				$tac = mysql_fetch_array(mysql_query("SELECT Term_Name, Description FROM tblcondition WHERE Term_ID = '". $arr[$i] ."' ", $connection));
				?>
					<tr>
						<td width="20%" valign="top"><?php echo $tac[0]; ?></td>
						<td width="80%"><?php echo $tac[1]; ?></td>
					</tr>
				<?php
			}
		break;

		case 'fncLoadInqOtherInfo':
			$InqInfo = mysql_fetch_array(mysql_query("SELECT inqSource, inqPrcssOwnr, ClassID, DepartmentID, CategoryID, billingtype, billingperc, BillerID, Mall_ID FROM tbltrans_inquiry WHERE Inquiry_ID = '". $_POST['InquiryID'] ."';", $connection));
			$ProposalInfo = mysql_fetch_array(mysql_query("SELECT dateFrom, dateTo, desiredYear, desiredMonths, monthlyDues, escalation_rate, year_start, year_basis, rent_free_construction, rent_free_construction_start_date, construction_deposit_terms, security_deposit_terms, advance_terms, security_deposit, advance_payment, construction_deposit, desiredDays, isRent, paymentTerms, unitArea, unitRate, exhibit_bond, exhibit_terms, billingtype, billingperc FROM tbltrans_proposal WHERE inquiryID = '". $_POST['InquiryID'] ."' AND proposalNum = '". $_POST['isProposal'] ."';", $connection));

			if($_POST['isAmendment'] == "1"){	
				if($ProposalInfo['dateTo'] == '' || $ProposalInfo['dateTo'] == '1970-01-01'){
					$DateFrom = date('m/d/Y');
				}else{
					$DateFrom = date('m/d/Y', strtotime($ProposalInfo['dateTo']));
				}

				$DateTo = date('m/d/Y', strtotime(getsysdate()));
			}else{
				if($ProposalInfo['dateFrom'] == '' || $ProposalInfo['dateFrom'] == '1970-01-01'){
					$DateFrom = date('m/d/Y');
				}else{
					$DateFrom = date('m/d/Y', strtotime($ProposalInfo['dateFrom']));
				}

				if($ProposalInfo['dateTo'] == '' || $ProposalInfo['dateTo'] == '1970-01-01'){
					$DateTo = date('m/d/Y');
				}else{
					$DateTo = date('m/d/Y', strtotime($ProposalInfo['dateTo']));
				}
			}

			if($ProposalInfo['billingperc'] == 'undefined' || $ProposalInfo['billingperc'] == ''){
				$BillingPercent = "";
			}else{
				$BillingPercent = $ProposalInfo['billingperc'];
			}

			if($ProposalInfo['rent_free_construction_start_date'] == '' || $ProposalInfo['rent_free_construction_start_date'] == '1970-01-01'){
				$RFCSDate = "";
			}else{
				$RFCSDate = date('m/d/Y', strtotime($ProposalInfo['rent_free_construction_start_date']));
			}

			echo $InqInfo['inqSource'] . "|" . 
			$InqInfo['inqPrcssOwnr'] . "|" . 
			$InqInfo['ClassID'] . "|" . 
			$InqInfo['DepartmentID'] . "|" . 
			$InqInfo['CategoryID'] . "|" . 
			$ProposalInfo['billingtype'] . "|" . 
			$BillingPercent . "|" . 
			$DateFrom . "|" . 
			$DateTo . "|" . 
			floatval($ProposalInfo['desiredYear']) . "|" . 
			floatval($ProposalInfo['desiredMonths']) . "|" . 
			number_format($ProposalInfo['monthlyDues'], 2, '.', ',') . "|" . 
			floatval($ProposalInfo['escalation_rate']) . "|" . 
			floatval($ProposalInfo['year_start']) . "|" . 
			floatval($ProposalInfo['year_basis']) . "|" . 
			$ProposalInfo['rent_free_construction'] . "|" . 
			$RFCSDate . "|" . 
			$InqInfo['BillerID'] . "|" . 
			$ProposalInfo['isRent'] . "|" . 
			floatval($ProposalInfo['security_deposit_terms']) . "|" . 
			floatval($ProposalInfo['advance_terms']) . "|" . 
			floatval($ProposalInfo['construction_deposit_terms']) . "|" . 
			number_format($ProposalInfo['security_deposit'], 2, '.', ',') . "|" . 
			number_format($ProposalInfo['advance_payment'], 2, '.', ',') . "|" . 
			number_format($ProposalInfo['construction_deposit'], 2, '.', ',') . "|" . 
			floatval($ProposalInfo['desiredDays']) . "|" . 
			$ProposalInfo['paymentTerms'] . "|" .
			number_format($ProposalInfo['unitArea'], 2, '.', ',') . "|" .
			number_format($ProposalInfo['unitRate'], 2, '.', ',') . "|" .
			floatval($ProposalInfo['exhibit_terms']) . "|" .
			number_format($ProposalInfo['exhibit_bond'], 2, '.', ',');
		break;

		case 'fncSaveGlobalForm':
			$Mall = mysql_fetch_array(mysql_query("SELECT mallname, corp_ID, TenantIDPref FROM tblref_mall WHERE mallid = '". $_SESSION['MMS-Designation'] ."';", $connection));
			$MerchantCode = mysql_fetch_array(mysql_query("SELECT merchant_code FROM tbltrans_tradename WHERE tradeID = '". $_POST['TradeID'] ."';", $connection));
	       	$SysPrefix = mysql_fetch_array(mysql_query("SELECT inqprefix, appprefix FROM tblsys_setup;", $connection));
	       	if($_POST['AccredStat'] == "TagAsAccredited"){
				$TPSStat = '1';
				$POSCount = $_POST['POSCount'];
			}else{
				$TPSStat = '0';
				$POSCount = '0';
			}
			$termsandconlist = explode("|", $_POST['TermsAndCondition']);
			for ($a = 0; $a <= count($termsandconlist)-2; $a++) { 
				$selectby1 = mysql_fetch_array(mysql_query("SELECT Group_Name, Term_Name, Description FROM tblcondition WHERE Term_ID = '". $termsandconlist[$a] ."';", $connection));
				$gname .= $selectby1[0]."|";
				$tname .= $selectby1[1]."|";
				$cond .= $selectby1[2]."|";
			}
			if($_POST['isVATable'] == 0){
				$VATSetup = "VATable";
			}else if($_POST['isVATable'] == 1){
				$VATSetup = "Non-VATable";
			}else if($_POST['isVATable'] == 2){
				$VATSetup = "Zero Rated";
			}
			$isDirect = 0;
			if($_POST['InquiryID']== ""){
				if($_POST['MMS_Module'] == 'tenants'){
					$TenantID = createidno_permall($Mall['TenantIDPref'], "tbltrans_tenants", "TenantID");
					$ApplicationID = createidno($SysPrefix['appprefix'], "tbltrans_appid", "app_id");
					$ContractID = createidno("CONTRACT", "tblcontract", "ContractID");
					$Status = "Occupied";
					$AddQuery = ", Application_ID = '". $ApplicationID ."', TenantID = '". $TenantID ."', date_approved = '". date('Y-m-d H:i:s') ."', date_applied = '". date('Y-m-d H:i:s') ."', billingtype = '". $_POST['BillingType'] ."', billingperc = '". $_POST['BillPercent'] ."', desired_noofyears = '". $_POST['YearTerm'] ."', desired_noofmonths = '". $_POST['MonthTerm'] ."', forFinal = '1', S2Leasing = '1', date_confirmed = '". date('Y-m-d H:i:s') ."', monthly_dues = '". floatval($_POST['MonthlyRent']) ."', datefrom = '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."', dateto = '". date('Y-m-d', strtotime($_POST['DateTo'])) ."', applicationDate = '". date('Y-m-d') ."', Status = '". $Status ."', app_by = '". getusername() ."', mod_by = '". getusername() ."', appr_by = '". getusername() ."', desired_noofdays = '". $_POST['DayTerm'] ."', payment_terms = '". $_POST['isDaily'] ."', contractID = '". $ContractID."', 1st_app_aw = '". $_SESSION['MMS-UserID'] ."', 1st_date_aw = '". date('Y-m-d H:i:s') ."', 2nd_app_aw = '". $_SESSION['MMS-UserID'] ."', 2nd_date_aw = '". date('Y-m-d H:i:s') ."', awardstatus = 'Approved', alluserid = '". $_SESSION['MMS-UserID'] ."', ActiveProposal = '1', isDirect = '1', userid_aw = '". $_SESSION['MMS-UserID'] ."'";

					$arr = explode("|", $_POST['SelectedUnits']);
					for($i=0; $i <= count($arr)-2; $i++){
						$getUnitStatus = mysql_fetch_array(mysql_query("SELECT STATUS FROM tblunit_statuslogs WHERE unitid = '". $arr[$i] ."' AND xdate BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['DateTo'])) ."' GROUP BY STATUS ORDER BY STATUS ASC;", $connection));
						if($getUnitStatus[0] != "" && $getUnitStatus[0] != "Vacant"){
							$isDirect++;
						}
					}
				}else{
					$TenantID = "";
					$ApplicationID = "";
					$ContractID = "";
					$Status = "Pending";
					$AddQuery = "";
					$isDirect = 0;
				}

				if($isDirect == 0){
					$InquiryID = createidno($SysPrefix['inqprefix'], "tbltrans_inquiry", "Inquiry_ID");
					$sql = "INSERT INTO tbltrans_inquiry SET Inquiry_ID = '". $InquiryID ."', Mall = '". $Mall['mallname'] ."', Mall_ID = '". $_SESSION['MMS-Designation'] ."', TradeID = '". $_POST['TradeID'] ."', Trade_Name = '". $_POST['TradeName'] ."', Company_ID = '". $_POST['CompanyID'] ."', Company_Name = '". $_POST['CompanyName'] ."', Industry = '". $_POST['IndustryID'] ."', User_ID = '". $_SESSION['MMS-UserID'] ."', date_inquired = '". date('Y-m-d') ."', time_inquired = '". date('H:i:s') ."', inq_by = '". getusername() ."', merchant_code = '". $MerchantCode['merchant_code'] ."', leadsID = '". $_POST['LeadsID'] ."', ClassID = '". $_POST['Classification'] ."', DepartmentID = '". $_POST['Department'] ."', CategoryID = '". $_POST['Category'] ."', inqSource = '". $_POST['Source'] ."', inqPrcssOwnr = '". $_POST['ProcessOwner'] ."', mallCompanyID = '". $Mall['corp_ID'] ."', BillerID = '". $_POST['BillerID'] ."'". $AddQuery .";";
					$res = mysql_query($sql, $connection);
					if($res == true){

						if($_POST['Remarks'] != ""){
							$RemarksID = createidno("REM", "tbltrans_remarks", "remID");
							$res = mysql_query("INSERT INTO tbltrans_remarks(remID, inqID, xremarks, xdate, userID)VALUES('". $RemarksID ."', '". $InquiryID ."', '". $_POST['Remarks'] ."', '". date(getsysdate()." H:i:s") ."', '". $_SESSION['MMS-UserID'] ."');", $connection);
						}

						if($_POST['MMS_Module'] == 'inquiry'){
							// INSERT LOGS JONAS 9/30/2019 START
							$arrHeader = ["Leads ID", "Inquiry ID", "Trade ID", "Trade Name", "Merchant Code", "Company ID", "Company Name", "Industry ID", "Process Owner", "Source", "Classification", "Department", "Category", "Mall ID", "Mall Name"];
							$arrValue = [$_POST['LeadsID'], $InquiryID, $_POST['TradeID'], $_POST['TradeName'], $MerchantCode['merchant_code'], $_POST['CompanyID'], $_POST['CompanyName'], $_POST['IndustryID'], $_POST['ProcessOwner'], $_POST['Source'], $_POST['Classification'], $_POST['Department'], $_POST['Category'], $_SESSION['MMS-Designation'], $Mall['mallname']];
							$tran_logs = create_logs_per_transaction("created a new inquiry.", "Inquiry Module", createXinfo("INSERT", $arrHeader, "", $arrValue, "", "", ""), "" ,"ADD", $InquiryID);
							// INSERT LOGS JONAS 9/30/2019 END
						}

						if($_POST['MMS_Module'] == 'tenants'){
							echo "1|New tenant has been created.|". $InquiryID . "|" . $ApplicationID;
						}else if($_POST['MMS_Module'] == 'proposal'){
							echo "1|New proposal has been saved.";
						}else{
							echo "1|New inquiry has been saved.";
						}
					}else{
						echo "2|Failed to save inquiry.";
					}

					if($_POST['MMS_Module'] == 'tenants'){

						$filepath = mysql_fetch_array(mysql_query("SELECT filepath, dbsetup FROM tblsys_setup;", $connection));
						$SystemSetupPath = str_replace("\\", "/", $filepath['filepath']);

						if(!file_exists($SystemSetupPath . $_SESSION['MMS-Designation'] ."/". $MerchantCode['merchant_code'])){
							mkdir($SystemSetupPath . $_SESSION['MMS-Designation'] ."/". $MerchantCode['merchant_code'], 0777, true);
						}

						$resDirectTenant = mysql_query("INSERT INTO tbltrans_tenants SET TenantID = '". $TenantID ."', mallID = '". $_SESSION['MMS-Designation'] ."', appID = '". $ApplicationID ."', inqID = '". $InquiryID ."', tradeID = '". $_POST['TradeID'] ."', tradename = '". $_POST['TradeName'] ."', CompanyID = '". $_POST['CompanyID'] ."', companyname = '". $_POST['CompanyName'] ."', datefrom = '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."', dateto = '". date('Y-m-d', strtotime($_POST['DateTo'])) ."', Status = 'Active', noofmonths = '". $_POST['MonthTerm'] ."', noofyears = '". $_POST['YearTerm'] ."', ustatus = 'Occupied', tenanttype = '". $_POST['BillingType'] ."', revpercent = '". $_POST['BillPercent'] ."', merchant_code = '". $MerchantCode['merchant_code'] ."', ContractID = '". $ContractID ."', withPOS = '". $POSCount ."', uploadingoffiles = '". $TPSStat ."', mallCompanyID = '". $Mall['corp_ID'] ."', ClassID = '". $_POST['Classification'] ."', DepartmentID = '". $_POST['Department'] ."', CategoryID = '". $_POST['Category'] ."', inqSource = '". $_POST['Source'] ."', inqPrcssOwnr = '". $_POST['ProcessOwner'] ."', BillerID = '". $_POST['BillerID'] ."', monthly_dues = '". floatval($_POST['MonthlyRent']) ."', noofdays = '". $_POST['DayTerm'] ."', payment_terms = '". $_POST['isDaily'] ."', ActiveProposal = '1', isDirect = '1';", $connection);

						$resContract = mysql_query("INSERT INTO tblcontract SET ContractID = '". $ContractID ."', MallID = '". $_SESSION['MMS-Designation'] ."', InquiryID = '". $InquiryID ."', TenantID = '". $TenantID ."', datefrom = '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."', dateto = '". date('Y-m-d', strtotime($_POST['DateTo'])) ."', Group_Name = '". mysql_real_escape_string($gname) ."', Term_Name = '". mysql_real_escape_string($tname) ."', ids = '". $_POST['TermsAndCondition'] ."', Conditions = '".  mysql_real_escape_string($cond) ."', appr_id1 = '". $_SESSION['MMS-UserID'] ."', appr_user1 = '". getusername() ."', appr_date1 = '". date('Y-m-d H:i:s') ."', appr_id2 = '". $_SESSION['MMS-UserID'] ."', appr_user2 = '". getusername() ."', appr_date2 = '". date('Y-m-d H:i:s') ."', ContractStat = 'Approved', 1st_app = '". $_SESSION['MMS-UserID'] ."', 1st_date = '". date('Y-m-d H:i:s') ."', 2nd_app = '". $_SESSION['MMS-UserID'] ."', 2nd_date = '". date('Y-m-d H:i:s') ."', 3rd_app = '". $_SESSION['MMS-UserID'] ."', 3rd_date = '". date('Y-m-d H:i:s') ."', date_created = '". date('Y-m-d') ."', created_by = '". $_SESSION['MMS-UserID'] ."', AmendStat = 'Not Posted', ProposalNum = '1', isDirect = '1';", $connection);

						$Escalation2 = explode("@", $_POST['Escalation']);
						for ($i = 0; $i <= COUNT($Escalation2) -2; $i++) { 
							$arr = explode("|", $Escalation2[$i]);
							$resInsertEscalation = mysql_query("INSERT INTO tbltrans_escalation SET InquiryID = '". $InquiryID ."', ProposalNum = '1', EscaYear = '". $arr[0] ."', EscaRate = '". $arr[1] ."', AccuEscaRate = '". $arr[2] ."';", $connection);
						}

						$Charges = explode("@", $_POST['Charges']);
						for ($i = 0; $i <= COUNT($Charges) -2; $i++) { 
							$arr = explode("|", $Charges[$i]);
							$getChargeInfo = mysql_fetch_array(mysql_query("SELECT CHARGE_DESC, RATE_TYPE, CHARGE_ID FROM tblref_refcharges WHERE CHARGE_ID = '". $arr[0] ."';", $connection));
							$resInsertCharges = mysql_query("INSERT INTO tbltrans_procharges SET InquiryID = '". $InquiryID ."', ProposalNum = '1', ChargeCode = '". $arr[0] ."', ChargeDesc = '". $getChargeInfo['CHARGE_DESC'] ."', ChargeType = '". $getChargeInfo['RATE_TYPE'] ."', ChargeAmount = '". $arr[1] ."';", $connection);
							$ChargesList .=  "<br/>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;". $getChargeName['CHARGE_ID'] ."&nbsp;<span class='fa fa-angle-right blue'></span>&nbsp;". $getChargeName['CHARGE_DESC'];
						}

						$resDirectProposal = mysql_query("INSERT INTO tbltrans_proposal SET proposalNum = '1', inquiryID = '". $InquiryID ."', dateFrom = '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."', dateTo = '". date('Y-m-d', strtotime($_POST['DateTo'])) ."', desiredMonths = '". $_POST['MonthTerm'] ."', desiredYear = '". $_POST['YearTerm'] ."', escalation_rate = '". $_POST['EscaRate'] ."', year_start = '". $_POST['EscaRateStart'] ."', year_basis = '". $_POST['EscaYearBasis'] ."', rent_free_construction = '". $_POST['RentFreeCon'] ."', rent_free_construction_start_date = '". date('Y-m-d', strtotime($_POST['RentFreeConStartDate'])) ."', requirement_list = '". $_POST['Requirements'] ."', permit_list = '". $_POST['Permits'] ."', terms_condition = '". $_POST['TermsAndCondition'] ."', terms_condition_group = '". mysql_real_escape_string($gname) ."', terms_condition_term = '". mysql_real_escape_string($tname) ."', terms_condition_cond = '". mysql_real_escape_string($cond) ."', isRent = '". $_POST['isVATable'] ."', monthlyDues = '". floatval($_POST['MonthlyRent']) ."', datecreated = '". getsysdate() ."', userid = '". $_SESSION['MMS-UserID'] ."', desiredDays = '". $_POST['DayTerm'] ."', paymentTerms = '". $_POST['isDaily'] ."', construction_deposit_terms = '". $_POST['ConBondMonth'] ."', security_deposit_terms = '". $_POST['SecDepMonth'] ."', advance_terms = '". $_POST['AdvMonth'] ."', security_deposit = '". $_POST['SecDep'] ."', advance_payment = '". $_POST['AdvRent'] ."', construction_deposit = '". $_POST['ConBond'] ."', unitArea = '". $_POST['Area'] ."', unitRate = '". $_POST['Rate'] ."', exhibit_bond = '". $_POST['ExhBond'] ."', exhibit_terms = '". $_POST['ExhMonth'] ."', stats = '1', date_approved = '". date('Y-m-d H:i:s') ."', approved_by = '". getusername() ."', isPrimary = '1', billingtype = '". $_POST['BillingType'] ."', billingperc = '". $_POST['BillPercent'] ."', isDirect = '1', 1st_app = '". $_SESSION['MMS-UserID'] ."', 1st_date = '". date('Y-m-d H:i:s') ."';", $connection);

						$RequirementList = "";
						$arr = explode("|", $_POST['Requirements']);
						for($i=0; $i <= count($arr)-2; $i++){
							$UnitName = mysql_fetch_array(mysql_query("SELECT unitname FROM tblref_unit WHERE unitID = '". $arr[$i] ."';", $connection));

							$RequirementList .= "<br/>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;". $arr[$i] ."&nbsp;<span class='fa fa-angle-right blue'></span>&nbsp;". $UnitName[0];

							$resInsertProposalUnit = mysql_query("INSERT INTO tbltrans_proposal_unit SET InquiryID = '". $InquiryID ."', UnitID = '". $arr[$i] ."', ProposalNum = '1';", $connection);
						}

						$UnitList = "";
						$arr = explode("|", $_POST['SelectedUnits']);
						for($i=0; $i <= count($arr)-2; $i++){
							$UnitName = mysql_fetch_array(mysql_query("SELECT unitname FROM tblref_unit WHERE unitID = '". $arr[$i] ."';", $connection));

							$UnitList .= "<br/>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;". $arr[$i] ."&nbsp;<span class='fa fa-angle-right blue'></span>&nbsp;". $UnitName[0];

							$resInsertProposalUnit = mysql_query("INSERT INTO tbltrans_proposal_unit SET InquiryID = '". $InquiryID ."', UnitID = '". $arr[$i] ."', ProposalNum = '1';", $connection);

							$resInsertInquiryUnit = mysql_query("INSERT INTO tbltrans_inquiry_unit SET InquiryID = '". $InquiryID ."', UnitID = '". $arr[$i] ."';", $connection);

							$resInsertUnit = mysql_query("UPDATE tblref_unit SET status = 'Occupied', TenantID = '". $TenantID ."', TenantName = '". $_POST['TradeName'] ."', startDate = '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."', endDate = '". date('Y-m-d', strtotime($_POST['DateTo'])) ."' WHERE unitid = '". $arr[$i] ."';", $connection);

							$StartDate = date('Y-m-d', strtotime($_POST['DateFrom']));
				            while (date('Y-m-d', strtotime($StartDate)) <= date('Y-m-d', strtotime($_POST['DateTo']))) {
				            	$chkUnitLogs = mysql_num_rows(mysql_query("SELECT id FROM tblunit_statuslogs WHERE unitid = '". $arr[$i] ."' AND xdate = '". $StartDate ."';", $connection));
				            	if($chkUnitLogs == 0){
				                	$resInsertLogs = mysql_query("INSERT INTO tblunit_statuslogs SET unitid = '". $arr[$i] ."', unitname = '". $UnitName['unitname'] ."', xdate = '". $StartDate ."', xtime = '". date('H:i:s') ."', status = 'Occupied', tenantid = '". $TenantID ."', tenantname = '". $_POST['TradeName'] ."', inquiryid = '". $InquiryID ."';", $connection);
				            	}else{
				                	$resInsertLogs = mysql_query("UPDATE tblunit_statuslogs SET status = 'Occupied', tenantid = '". $TenantID ."', tenantname = '". $_POST['TradeName'] ."', inquiryid = '". $InquiryID ."' WHERE unitid = '". $arr[$i] ."' AND xdate = '". $StartDate ."';", $connection);
				            	}
				                $StartDate = date('Y-m-d', strtotime($StartDate . '+1 day'));
				            }
						}

						// INSERT LOGS JONAS 9/30/2019 START
						$arrHeader = ["Tenant ID", "Inquiry ID", "Application ID", "Leads ID", "Trade ID", "Company ID", "Contract ID", "Trade Name", "Merchant Code", "Company Name", "Industry ID", "Classification", "Department", "Category", "Mall Company", "Mall ID", "Mall Name", "Start Date", "End Date", "Year", "Months", "Days", "Billing Type", "Billing Percentage", "Accredited?", "Number of POS", "Monthly Due", "Source", "Process Owner", "Payment Term", "Rent Free Construction", "Rent Free Construction Start Date", "Construction Deposit Month", "Construction Deposit Amount", "Security Deposit Month", "Security Deposit Amount", "Exhibit Bond Month", "Exhibit Bond Amount", "Advance Payment Month", "Advance Payment Amount", "VAT Setup", "Unit Area", "Unit Rate", "Charges List", "Unit"];
						$arrValue = [$TenantID, $InquiryID, $ApplicationID, $_POST['LeadsID'], $_POST['TradeID'], $_POST['CompanyID'], $ContractID, $_POST['TradeName'], $MerchantCode['merchant_code'], $_POST['CompanyName'], $_POST['IndustryID'], $_POST['Classification'], $_POST['Department'], $_POST['Category'], $Mall['corp_ID'], $_SESSION['MMS-Designation'], $Mall['mallname'], date('Y-m-d', strtotime($_POST['DateFrom'])), date('Y-m-d', strtotime($_POST['DateTo'])), $_POST['YearTerm'], $_POST['MonthTerm'], $_POST['DayTerm'], $_POST['BillingType'], $_POST['BillPercent'], $TPSStat, $POSCount, number_format($_POST['MonthlyRent'], "2", ".", ","), $_POST['Source'], $_POST['ProcessOwner'], $_POST['isDaily'], $_POST['RentFreeCon'],  date('Y-m-d', strtotime($_POST['RentFreeConStartDate'])), $_POST['ConBondMonth'], number_format($_POST['ConBond'], "2", ".", ","), $_POST['SecDepMonth'], number_format($_POST['SecDep'], "2", ".", ","), $_POST['ExhMonth'], number_format($_POST['ExhBond'], "2", ".", ","), $_POST['AdvMonth'], number_format($_POST['AdvRent'], "2", ".", ","), $VATSetup, $_POST['Area'], $_POST['Rate'], $ChargesList, $UnitList];
						$tran_logs = create_logs_per_transaction("created a direct tenant.", "Inquiry Module", createXinfo("INSERT", $arrHeader, "", $arrValue, "", "", ""), "" ,"INSERT", $InquiryID);
						// INSERT LOGS JONAS 9/30/2019 END
					}
				}else{
					echo "2|Failed to create new tenant as selected unit is not available.";
				}
			}else{

				if($_POST['isAmendment'] == "1"){
					$getAmendCount = mysql_num_rows(mysql_query("SELECT id FROM tblcontract WHERE TenantID = '". $_POST['TenantID'] ."';", $connection));
					$getFirstID = mysql_fetch_array(mysql_query("SELECT ContractID, InquiryID FROM tblcontract WHERE tenantid = '". $_POST['TenantID'] ."' ORDER BY id ASC;", $connection));
					$LastProposalNum = mysql_fetch_array(mysql_query("SELECT proposalNum FROM tbltrans_proposal WHERE inquiryID = '". $getFirstID['InquiryID'] ."' AND isAmendment = '0' ORDER BY proposalNum DESC LIMIT 1;", $connection));
					$TenantOccupancy = mysql_fetch_array(mysql_query("SELECT datefrom, dateto FROM tbltrans_tenants WHERE TenantID = '". $_POST['TenantID'] ."';", $connection));

					$UnitList = "";
					$resUpdateUnitStatus = mysql_query("SELECT UnitID FROM tbltrans_inquiry_unit WHERE InquiryID = '". $_POST['InquiryID'] ."';", $connection);
					while($rowUpdateUnitStatus = mysql_fetch_array($resUpdateUnitStatus)){

						$resUpdateUnit = mysql_query("UPDATE tblref_unit SET status = 'Vacant', TenantID = NULL, TenantName = NULL, startDate = NULL, endDate = NULL WHERE unitid = '". $rowUpdateUnitStatus['UnitID'] ."';", $connection);

	                	$resUpdateLogs = mysql_query("UPDATE tblunit_statuslogs SET status = 'Vacant', tenantid = NULL, tenantname = NULL, inquiryid = NULL WHERE unitid = '". $rowUpdateUnitStatus['UnitID'] ."' AND xdate BETWEEN '". date('Y-m-d', strtotime($TenantOccupancy['datefrom'])) ."' AND '". date('Y-m-d', strtotime($TenantOccupancy['dateto'])) ."';", $connection);
	                }
	                
					$arr = explode("|", $_POST['SelectedUnits']);
					for($i=0; $i <= count($arr)-2; $i++){
						$resInsertInquiryUnit = mysql_query("INSERT INTO tbltrans_inquiry_unit SET InquiryID = '". $_POST['InquiryID'] ."-". $getAmendCount ."', UnitID = '". $arr[$i] ."';", $connection);
						$UnitName = mysql_fetch_array(mysql_query("SELECT unitname FROM tblref_unit WHERE unitID = '". $arr[$i] ."';", $connection));
						$UnitList .= "<br/>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;". $arr[$i] ."&nbsp;<span class='fa fa-angle-right blue'></span>&nbsp;". $UnitName[0];

						$resUpdateUnit = mysql_query("UPDATE tblref_unit SET status = 'Occupied', TenantID = '". $_POST['TenantID'] ."', TenantName = '". $_POST['TradeName'] ."', startDate = '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."', endDate = '". date('Y-m-d', strtotime($_POST['DateTo'])) ."' WHERE unitid = '". $arr[$i] ."';", $connection);
						
						$StartDate = date('Y-m-d', strtotime($_POST['DateFrom']));
			            while(date('Y-m-d', strtotime($StartDate)) <= date('Y-m-d', strtotime($_POST['DateTo']))){
			            	$chkUnitLogs = mysql_num_rows(mysql_query("SELECT id FROM tblunit_statuslogs WHERE unitid = '". $arr[$i] ."' AND xdate = '". $StartDate ."';", $connection));
			            	if($chkUnitLogs == 0){
			                	$resInsertLogs = mysql_query("INSERT INTO tblunit_statuslogs SET unitid = '". $arr[$i] ."', unitname = '". $UnitName['unitname'] ."', xdate = '". $StartDate ."', xtime = '". date('H:i:s') ."', status = 'Occupied', tenantid = '". $_POST['TenantID'] ."', tenantname = '". $_POST['TradeName'] ."', inquiryid = '". $getFirstID['InquiryID'] ."-". $getAmendCount ."';", $connection);
			            	}else{
			                	$resInsertLogs = mysql_query("UPDATE tblunit_statuslogs SET status = 'Occupied', tenantid = '". $_POST['TenantID'] ."', tenantname = '". $_POST['TradeName'] ."', inquiryid = '". $getFirstID['InquiryID'] ."-". $getAmendCount ."' WHERE unitid = '". $arr[$i] ."' AND xdate = '". $StartDate ."';", $connection);
			            	}
			                $StartDate = date('Y-m-d', strtotime($StartDate . '+1 day'));
			            }
					}

					$Charges = explode("@", $_POST['Charges']);
					for ($i = 0; $i <= COUNT($Charges) -2; $i++) { 
						$arr = explode("|", $Charges[$i]);
						$getChargeInfo = mysql_fetch_array(mysql_query("SELECT CHARGE_DESC, RATE_TYPE, CHARGE_ID FROM tblref_refcharges WHERE CHARGE_ID = '". $arr[0] ."';", $connection));
						$resInsertCharges = mysql_query("INSERT INTO tbltrans_procharges SET InquiryID = '". $getFirstID['InquiryID'] ."-". $getAmendCount ."', ProposalNum = '". floatval($LastProposalNum[0] + 1) ."', ChargeCode = '". $arr[0] ."', ChargeDesc = '". $getChargeInfo['CHARGE_DESC'] ."', ChargeType = '". $getChargeInfo['RATE_TYPE'] ."', ChargeAmount = '". $arr[1] ."';", $connection);
					}

					$resInsertInquiry = mysql_query("INSERT INTO tbltrans_inquiry SET Inquiry_ID = '". $getFirstID['InquiryID'] ."-". $getAmendCount ."', Mall = '". $Mall['mallname'] ."', Mall_ID = '". $_SESSION['MMS-Designation'] ."', TradeID = '". $_POST['TradeID'] ."', Trade_Name = '". $_POST['TradeName'] ."', Company_ID = '". $_POST['CompanyID'] ."', Company_Name = '". $_POST['CompanyName'] ."', Industry = '". $_POST['IndustryID'] ."', User_ID = '". $_SESSION['MMS-UserID'] ."', date_inquired = '". date('Y-m-d') ."', time_inquired = '". date('H:i:s') ."', inq_by = '". getusername() ."', merchant_code = '". $MerchantCode['merchant_code'] ."', leadsID = '". $_POST['LeadsID'] ."', ClassID = '". $_POST['Classification'] ."', DepartmentID = '". $_POST['Department'] ."', CategoryID = '". $_POST['Category'] ."', inqSource = '". $_POST['Source'] ."', inqPrcssOwnr = '". $_POST['ProcessOwner'] ."', mallCompanyID = '". $Mall['corp_ID'] ."', BillerID = '". $_POST['BillerID'] ."', Application_ID = '". $_POST['ApplicationID'] ."', TenantID = '". $_POST['TenantID'] ."', date_approved = '". date('Y-m-d H:i:s') ."', date_applied = '". date('Y-m-d H:i:s') ."', billingtype = '". $_POST['BillingType'] ."', billingperc = '". $_POST['BillPercent'] ."', desired_noofyears = '". $_POST['YearTerm'] ."', desired_noofmonths = '". $_POST['MonthTerm'] ."', forFinal = '1', S2Leasing = '1', date_confirmed = '". date('Y-m-d H:i:s') ."', monthly_dues = '". floatval($_POST['MonthlyRent']) ."', datefrom = '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."', dateto = '". date('Y-m-d', strtotime($_POST['DateTo'])) ."', applicationDate = '". date('Y-m-d') ."', Status = '". $Status ."', app_by = '". getusername() ."', mod_by = '". getusername() ."', appr_by = '". getusername() ."', desired_noofdays = '". $_POST['DayTerm'] ."', payment_terms = '". $_POST['isDaily'] ."', contractID = '". $getFirstID['ContractID'] ."-". $getAmendCount ."', 1st_app_aw = '". $_SESSION['MMS-UserID'] ."', 1st_date_aw = '". date('Y-m-d H:i:s') ."', 2nd_app_aw = '". $_SESSION['MMS-UserID'] ."', 2nd_date_aw = '". date('Y-m-d H:i:s') ."', awardstatus = 'Approved', alluserid = '". $_SESSION['MMS-UserID'] ."', ActiveProposal = '". floatval($LastProposalNum[0] + 1) ."', isAmendment = '1', userid_aw = '". $_SESSION['MMS-UserID'] ."';", $connection);

					$resUpdateTenant = mysql_query("UPDATE tbltrans_tenants SET inqID = '". $getFirstID['InquiryID'] ."-". $getAmendCount ."', tradeID = '". $_POST['TradeID'] ."', tradename = '". $_POST['TradeName'] ."', CompanyID = '". $_POST['CompanyID'] ."', companyname = '". $_POST['CompanyName'] ."', dateto = '". date('Y-m-d', strtotime($_POST['DateTo'])) ."', Status = 'Active', noofmonths = '". $_POST['MonthTerm'] ."', noofyears = '". $_POST['YearTerm'] ."', ustatus = 'Occupied', tenanttype = '". $_POST['BillingType'] ."', revpercent = '". $_POST['BillPercent'] ."', merchant_code = '". $MerchantCode['merchant_code'] ."', ContractID = '". $getFirstID['ContractID'] ."-". $getAmendCount ."', withPOS = '". $POSCount ."', uploadingoffiles = '". $TPSStat ."', mallCompanyID = '". $Mall['corp_ID'] ."', ClassID = '". $_POST['Classification'] ."', DepartmentID = '". $_POST['Department'] ."', CategoryID = '". $_POST['Category'] ."', inqSource = '". $_POST['Source'] ."', inqPrcssOwnr = '". $_POST['ProcessOwner'] ."', BillerID = '". $_POST['BillerID'] ."', monthly_dues = '". floatval($_POST['MonthlyRent']) ."', noofdays = '". $_POST['DayTerm'] ."', payment_terms = '". $_POST['isDaily'] ."', ActiveProposal = '". floatval($LastProposalNum[0] + 1) ."' WHERE TenantID = '". $_POST['TenantID'] ."';", $connection);

					$resInsertContract = mysql_query("INSERT INTO tblcontract SET ContractID = '". $getFirstID['ContractID'] ."-". $getAmendCount ."', MallID = '". $_SESSION['MMS-Designation'] ."', InquiryID = '". $getFirstID['InquiryID'] ."-". $getAmendCount ."', TenantID = '". $_POST['TenantID'] ."', datefrom = '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."', dateto = '". date('Y-m-d', strtotime($_POST['DateTo'])) ."', Group_Name = '". mysql_real_escape_string($gname) ."', Term_Name = '". mysql_real_escape_string($tname) ."', ids = '". $_POST['TermsAndCondition'] ."', Conditions = '".  mysql_real_escape_string($cond) ."', appr_id1 = '". $_SESSION['MMS-UserID'] ."', appr_user1 = '". getusername() ."', appr_date1 = '". date('Y-m-d H:i:s') ."', appr_id2 = '". $_SESSION['MMS-UserID'] ."', appr_user2 = '". getusername() ."', appr_date2 = '". date('Y-m-d H:i:s') ."', ContractStat = 'Approved', 1st_app = '". $_SESSION['MMS-UserID'] ."', 1st_date = '". date('Y-m-d H:i:s') ."', 2nd_app = '". $_SESSION['MMS-UserID'] ."', 2nd_date = '". date('Y-m-d H:i:s') ."', 3rd_app = '". $_SESSION['MMS-UserID'] ."', 3rd_date = '". date('Y-m-d H:i:s') ."', date_created = '". date('Y-m-d') ."', created_by = '". $_SESSION['MMS-UserID'] ."', AmendStat = 'Not Posted', ProposalNum = '". floatval($LastProposalNum[0] + 1) ."';", $connection);

					$resInsertProposal = mysql_query("INSERT INTO tbltrans_proposal SET proposalNum = '". floatval($LastProposalNum[0] + 1) ."', inquiryID = '". $getFirstID['InquiryID'] ."-". $getAmendCount ."', dateFrom = '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."', dateTo = '". date('Y-m-d', strtotime($_POST['DateTo'])) ."', desiredMonths = '". $_POST['MonthTerm'] ."', desiredYear = '". $_POST['YearTerm'] ."', escalation_rate = '". $_POST['EscaRate'] ."', year_start = '". $_POST['EscaRateStart'] ."', year_basis = '". $_POST['EscaYearBasis'] ."', rent_free_construction = '". $_POST['RentFreeCon'] ."', rent_free_construction_start_date = '". date('Y-m-d', strtotime($_POST['RentFreeConStartDate'])) ."', requirement_list = '". $_POST['Requirements'] ."', permit_list = '". $_POST['Permits'] ."', terms_condition = '". $_POST['TermsAndCondition'] ."', terms_condition_group = '". mysql_real_escape_string($gname) ."', terms_condition_term = '". mysql_real_escape_string($tname) ."', terms_condition_cond = '". mysql_real_escape_string($cond) ."', isRent = '". $_POST['isVATable'] ."', monthlyDues = '". floatval($_POST['MonthlyRent']) ."', datecreated = '". getsysdate() ."', userid = '". $_SESSION['MMS-UserID'] ."', desiredDays = '". $_POST['DayTerm'] ."', paymentTerms = '". $_POST['isDaily'] ."', construction_deposit_terms = '". $_POST['ConBondMonth'] ."', security_deposit_terms = '". $_POST['SecDepMonth'] ."', advance_terms = '". $_POST['AdvMonth'] ."', security_deposit = '". $_POST['SecDep'] ."', advance_payment = '". $_POST['AdvRent'] ."', construction_deposit = '". $_POST['ConBond'] ."', unitArea = '". $_POST['Area'] ."', unitRate = '". $_POST['Rate'] ."', exhibit_bond = '". $_POST['ExhBond'] ."', exhibit_terms = '". $_POST['ExhMonth'] ."', billingtype = '". $_POST['BillingType'] ."', billingperc = '". $_POST['BillPercent'] ."', isAmendment = '1', date_approved = '". date('Y-m-d') ."', approved_by = '". getusername() ."';", $connection);

					$UnitList = "";
					$arr = explode("|", $_POST['SelectedUnits']);
					for($i=0; $i <= count($arr)-2; $i++){
						$resInsertUnit = mysql_query("INSERT INTO tbltrans_proposal_unit SET InquiryID = '". $getFirstID['InquiryID'] ."-". $getAmendCount ."', UnitID = '". $arr[$i] ."', ProposalNum = '". floatval($LastProposalNum[0] + 1) ."';", $connection);
						$UnitName = mysql_fetch_array(mysql_query("SELECT unitname FROM tblref_unit WHERE unitID = '". $arr[$i] ."';", $connection));
						$UnitList .= "<br/>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;". $arr[$i] ."&nbsp;<span class='fa fa-angle-right blue'></span>&nbsp;". $UnitName[0];
					}

					if($resInsertInquiry == true && $resUpdateTenant == true && $resInsertContract == true && $resInsertProposal == true){
						echo "1|New contract successfully created.";
					}

				}else{

					$UpdateInquiry = 0;
					if($_POST['MMS_Module'] != 'inquiry'){
						if($_POST['isProposal'] == "0"){

							$UpdateInquiry = 0;
							$LastProposalNum = mysql_fetch_array(mysql_query("SELECT proposalNum FROM tbltrans_proposal WHERE inquiryID = '". $_POST['InquiryID'] ."' AND isAmendment = '0' ORDER BY proposalNum DESC LIMIT 1;", $connection));
							if($LastProposalNum[0] == "" || $LastProposalNum[0] == "0"){
								$isPrimary = "1";
							}else{
								$isPrimary = "0";
							}

							$isDirect = mysql_fetch_array(mysql_query("SELECT isDirect FROM tbltrans_tenants WHERE TenantID = '". $_POST['TenantID'] ."';", $connection));

							if($_POST['TenantID'] == ""){
								$isApproved = "";
							}else{
								$isApproved = ", date_approved = '". date('Y-m-d H:i:s') ."', approved_by = '". getusername() ."', 1st_app = '". $_SESSION['MMS-UserID'] ."', 1st_date = '". getsysdate() ."'";
							}

							$resDirectProposal = mysql_query("INSERT INTO tbltrans_proposal SET proposalNum = '". floatval($LastProposalNum[0] + 1) ."', inquiryID = '". $_POST['InquiryID'] ."', dateFrom = '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."', dateTo = '". date('Y-m-d', strtotime($_POST['DateTo'])) ."', desiredMonths = '". $_POST['MonthTerm'] ."', desiredYear = '". $_POST['YearTerm'] ."', escalation_rate = '". $_POST['EscaRate'] ."', year_start = '". $_POST['EscaRateStart'] ."', year_basis = '". $_POST['EscaYearBasis'] ."', rent_free_construction = '". $_POST['RentFreeCon'] ."', rent_free_construction_start_date = '". date('Y-m-d', strtotime($_POST['RentFreeConStartDate'])) ."', requirement_list = '". $_POST['Requirements'] ."', permit_list = '". $_POST['Permits'] ."', terms_condition = '". $_POST['TermsAndCondition'] ."', terms_condition_group = '". mysql_real_escape_string($gname) ."', terms_condition_term = '". mysql_real_escape_string($tname) ."', terms_condition_cond = '". mysql_real_escape_string($cond) ."', isRent = '". $_POST['isVATable'] ."', monthlyDues = '". floatval($_POST['MonthlyRent']) ."', datecreated = '". getsysdate() ."', userid = '". $_SESSION['MMS-UserID'] ."', desiredDays = '". $_POST['DayTerm'] ."', paymentTerms = '". $_POST['isDaily'] ."', construction_deposit_terms = '". $_POST['ConBondMonth'] ."', security_deposit_terms = '". $_POST['SecDepMonth'] ."', advance_terms = '". $_POST['AdvMonth'] ."', security_deposit = '". $_POST['SecDep'] ."', advance_payment = '". $_POST['AdvRent'] ."', construction_deposit = '". $_POST['ConBond'] ."', unitArea = '". $_POST['Area'] ."', unitRate = '". $_POST['Rate'] ."', exhibit_bond = '". $_POST['ExhBond'] ."', exhibit_terms = '". $_POST['ExhMonth'] ."', isPrimary = '". $isPrimary ."', billingtype = '". $_POST['BillingType'] ."', billingperc = '". $_POST['BillPercent'] ."', isDirect = '". $isDirect['isDirect'] ."'". $isApproved .";", $connection);

							$Escalation2 = explode("@", $_POST['Escalation']);
							for ($i = 0; $i <= COUNT($Escalation2) -2; $i++) { 
								$arr = explode("|", $Escalation2[$i]);
								$resInsertEscalation = mysql_query("INSERT INTO tbltrans_escalation SET InquiryID = '". $_POST['InquiryID'] ."', ProposalNum = '". floatval($LastProposalNum[0] + 1) ."', EscaYear = '". $arr[0] ."', EscaRate = '". $arr[1] ."', AccuEscaRate = '". $arr[2] ."';", $connection);
							}

							$UnitList = "";
							$arr = explode("|", $_POST['SelectedUnits']);
							for($i=0; $i <= count($arr)-2; $i++){
								$resInsertUnit = mysql_query("INSERT INTO tbltrans_proposal_unit SET InquiryID = '". $_POST['InquiryID'] ."', UnitID = '". $arr[$i] ."', ProposalNum = '". floatval($LastProposalNum[0] + 1) ."';", $connection);
								$UnitName = mysql_fetch_array(mysql_query("SELECT unitname FROM tblref_unit WHERE unitID = '". $arr[$i] ."';", $connection));
								$UnitList .= "<br/>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;". $arr[$i] ."&nbsp;<span class='fa fa-angle-right blue'></span>&nbsp;". $UnitName[0];
							}

							$Charges = explode("@", $_POST['Charges']);
							for ($i = 0; $i <= COUNT($Charges) -2; $i++) { 
								$arr = explode("|", $Charges[$i]);
								$getChargeInfo = mysql_fetch_array(mysql_query("SELECT CHARGE_DESC, RATE_TYPE, CHARGE_ID FROM tblref_refcharges WHERE CHARGE_ID = '". $arr[0] ."';", $connection));
								$resInsertCharges = mysql_query("INSERT INTO tbltrans_procharges SET InquiryID = '". $_POST['InquiryID'] ."', ProposalNum = '". floatval($LastProposalNum[0] + 1) ."', ChargeCode = '". $arr[0] ."', ChargeDesc = '". $getChargeInfo['CHARGE_DESC'] ."', ChargeType = '". $getChargeInfo['RATE_TYPE'] ."', ChargeAmount = '". $arr[1] ."';", $connection);
								$ChargesList .=  "<br/>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;". $getChargeInfo['CHARGE_ID'] ."&nbsp;<span class='fa fa-angle-right blue'></span>&nbsp;". $getChargeInfo['CHARGE_DESC'];
							}

							if($LastProposalNum[0] == "" || $LastProposalNum[0] == "0"){
								$arr = explode("|", $_POST['SelectedUnits']);
								for($i=0; $i <= count($arr)-2; $i++){
									$resInsertUnit = mysql_query("INSERT INTO tbltrans_inquiry_unit SET InquiryID = '". $_POST['InquiryID'] ."', UnitID = '". $arr[$i] ."';", $connection);
									$UnitName = mysql_fetch_array(mysql_query("SELECT unitname FROM tblref_unit WHERE unitID = '". $arr[$i] ."';", $connection));
								}
							}else{
								if($isPrimary == "1"){
									$resDeleteUnit = mysql_query("DELETE FROM tbltrans_inquiry_unit WHERE InquiryID = '". $_POST['InquiryID'] ."';", $connection);
									if($resDeleteUnit == true){
										$arr = explode("|", $_POST['SelectedUnits']);
										for($i=0; $i <= count($arr)-2; $i++){
											$resInsertUnit = mysql_query("INSERT INTO tbltrans_inquiry_unit SET InquiryID = '". $_POST['InquiryID'] ."', UnitID = '". $arr[$i] ."';", $connection);
											$UnitName = mysql_fetch_array(mysql_query("SELECT unitname FROM tblref_unit WHERE unitID = '". $arr[$i] ."';", $connection));
										}
									}
								}
							}

							$RequirementList = "";
							$arr = explode("|", $_POST['Requirements']);
							for($i=0; $i <= count($arr)-2; $i++){
								$getRequirementName = mysql_fetch_array(mysql_query("SELECT id, requirements FROM tblref_applicationrequirements WHERE id = '". $arr[$i] ."';", $connection));
								$RequirementList .=  "<br/>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;". $getRequirementName[0] ."&nbsp;<span class='fa fa-angle-right blue'></span>&nbsp;". $getRequirementName[1];
							}

							$PermitList = "";
							$arr = explode("|", $_POST['Permits']);
							for($i=0; $i <= count($arr)-2; $i++){
								$getPermitName = mysql_fetch_array(mysql_query("SELECT id, DESCRIPTION FROM tblref_typeofpermits WHERE id = '". $arr[$i] ."';", $connection));
								$PermitList .=  "<br/>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;". $getPermitName[0] ."&nbsp;<span class='fa fa-angle-right blue'></span>&nbsp;". $getPermitName[1];
							}

							// INSERT LOGS JONAS 9/30/2019 START
							$arrHeader = ["Proposal", "Leads ID", "Inquiry ID", "Trade ID", "Trade Name", "Merchant Code", "Company ID", "Company Name", "Industry ID", "Process Owner", "Source", "Classification", "Department", "Category", "Mall ID", "Mall Name", "Start Date", "End Date", "Months", "Year", "Escalation Rate", "Year Start", "Year Basis", "Rent Free Construction", "Rent Free Construction Start Date", "is rent VATable?", "VAT Type", "VAT Percent", "Monthly Rent", "Unit", "Charges List", "Requirements", "Permits"];
							$arrValue = [$_POST['isProposal'], $_POST['LeadsID'], $_POST['InquiryID'], $_POST['TradeID'], $_POST['TradeName'], $MerchantCode['merchant_code'], $_POST['CompanyID'], $_POST['CompanyName'], $_POST['IndustryID'], $_POST['ProcessOwner'], $_POST['Source'], $_POST['Classification'], $_POST['Department'], $_POST['Category'], $_SESSION['MMS-Designation'], $Mall['mallname'], date('Y-m-d', strtotime($_POST['DateFrom'])), date('Y-m-d', strtotime($_POST['DateTo'])), $_POST['MonthTerm'], $_POST['YearTerm'], $_POST['EscaRate'], $_POST['EscaRateStart'], $_POST['EscaYearBasis'], $_POST['RentFreeCon'],  date('Y-m-d', strtotime($_POST['RentFreeConStartDate'])), $VATSetup, number_format($_POST['MonthlyRent'], "2", ".", ","), $UnitList, $ChargesList, $RequirementList, $PermitList];
							$tran_logs = create_logs_per_transaction("created a new proposal.", "Inquiry Module", createXinfo("INSERT", $arrHeader, "", $arrValue, "", "", ""), "" ,"INSERT", $_POST['InquiryID']);
							// INSERT LOGS JONAS 9/30/2019 END
						}else if($_POST['isProposal'] >= 1){

							$ProposalStat = mysql_fetch_array(mysql_query("SELECT stats, isPrimary FROM tbltrans_proposal WHERE inquiryID = '". $_POST['InquiryID'] ."' AND proposalNum = '". $_POST['isProposal'] ."';", $connection));
							if($ProposalStat['isPrimary'] == '1'){
								$UpdateInquiry = 0;
							}else{
								$UpdateInquiry = 1;
							}

							// if($ProposalStat['stats'] == '1'){
							// 	$PermitandRequirement = "";
							// }else{
								$PermitandRequirement = ", requirement_list = '". $_POST['Requirements'] ."', permit_list = '". $_POST['Permits'] ."'";
							// }

							$resDirectProposal = mysql_query("UPDATE tbltrans_proposal SET dateFrom = '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."', dateTo = '". date('Y-m-d', strtotime($_POST['DateTo'])) ."', desiredMonths = '". $_POST['MonthTerm'] ."', desiredYear = '". $_POST['YearTerm'] ."', escalation_rate = '". $_POST['EscaRate'] ."', year_start = '". $_POST['EscaRateStart'] ."', year_basis = '". $_POST['EscaYearBasis'] ."', rent_free_construction = '". $_POST['RentFreeCon'] ."', rent_free_construction_start_date = '". date('Y-m-d', strtotime($_POST['RentFreeConStartDate'])) ."', terms_condition = '". $_POST['TermsAndCondition'] ."', terms_condition_group = '". mysql_real_escape_string($gname) ."', terms_condition_term = '". mysql_real_escape_string($tname) ."', terms_condition_cond = '". mysql_real_escape_string($cond) ."', isRent = '". $_POST['isVATable'] ."', monthlyDues = '". floatval($_POST['MonthlyRent']) ."', desiredDays = '". $_POST['DayTerm'] ."', paymentTerms = '". $_POST['isDaily'] ."', construction_deposit_terms = '". $_POST['ConBondMonth'] ."', security_deposit_terms = '". $_POST['SecDepMonth'] ."', advance_terms = '". $_POST['AdvMonth'] ."', security_deposit = '". $_POST['SecDep'] ."', advance_payment = '". $_POST['AdvRent'] ."', construction_deposit = '". $_POST['ConBond'] ."', unitArea = '". $_POST['Area'] ."', unitRate = '". $_POST['Rate'] ."', exhibit_bond = '". $_POST['ExhBond'] ."', exhibit_terms = '". $_POST['ExhMonth'] ."', billingtype = '". $_POST['BillingType'] ."', billingperc = '". $_POST['BillPercent'] ."' ". $PermitandRequirement ." WHERE inquiryID = '". $_POST['InquiryID'] ."' AND proposalNum = '". $_POST['isProposal'] ."';", $connection);

							$resDeleteEscalation = mysql_query("DELETE FROM tbltrans_escalation WHERE InquiryID = '". $_POST['InquiryID'] ."' AND ProposalNum = '". $_POST['isProposal'] ."';", $connection);
							$Escalation2 = explode("@", $_POST['Escalation']);
							for ($i = 0; $i <= COUNT($Escalation2) -2; $i++) { 
								$arr = explode("|", $Escalation2[$i]);
								$resInsertEscalation = mysql_query("INSERT INTO tbltrans_escalation SET InquiryID = '". $_POST['InquiryID'] ."', ProposalNum = '". $_POST['isProposal'] ."', EscaYear = '". $arr[0] ."', EscaRate = '". $arr[1] ."', AccuEscaRate = '". $arr[2] ."';", $connection);
							}

							$resDeleteUnit = mysql_query("DELETE FROM tbltrans_proposal_unit WHERE InquiryID = '". $_POST['InquiryID'] ."' AND ProposalNum = '". $_POST['isProposal'] ."';", $connection);
							if($resDeleteUnit == true){
								$UnitList = "";
								$arr = explode("|", $_POST['SelectedUnits']);
								for($i=0; $i <= count($arr)-2; $i++){
									$resInsertUnit = mysql_query("INSERT INTO tbltrans_proposal_unit SET InquiryID = '". $_POST['InquiryID'] ."', UnitID = '". $arr[$i] ."', ProposalNum = '". $_POST['isProposal'] ."';", $connection);
									$UnitName = mysql_fetch_array(mysql_query("SELECT unitname FROM tblref_unit WHERE unitID = '". $arr[$i] ."';", $connection));
									$UnitList .= "<br/>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;". $arr[$i] ."&nbsp;<span class='fa fa-angle-right blue'></span>&nbsp;". $UnitName[0];
								}
							}

							$resDeleteCharges = mysql_query("DELETE FROM tbltrans_procharges WHERE InquiryID = '". $_POST['InquiryID'] ."' AND ProposalNum = '". $_POST['isProposal'] ."';", $connection);
							if($resDeleteCharges == true){
								$Charges = explode("@", $_POST['Charges']);
								for ($i = 0; $i <= COUNT($Charges) -2; $i++) { 
									$arr = explode("|", $Charges[$i]);
									$getChargeInfo = mysql_fetch_array(mysql_query("SELECT CHARGE_DESC, RATE_TYPE, CHARGE_ID FROM tblref_refcharges WHERE CHARGE_ID = '". $arr[0] ."';", $connection));
									$resInsertCharges = mysql_query("INSERT INTO tbltrans_procharges SET InquiryID = '". $_POST['InquiryID'] ."', ProposalNum = '". $_POST['isProposal'] ."', ChargeCode = '". $arr[0] ."', ChargeDesc = '". $getChargeInfo['CHARGE_DESC'] ."', ChargeType = '". $getChargeInfo['RATE_TYPE'] ."', ChargeAmount = '". $arr[1] ."';", $connection);
									$ChargesList .=  "<br/>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;". $getChargeInfo['CHARGE_ID'] ."&nbsp;<span class='fa fa-angle-right blue'></span>&nbsp;". $getChargeInfo['CHARGE_DESC'];
								}
							}

							$RequirementList = "";
							$arr = explode("|", $_POST['Requirements']);
							for($i=0; $i <= count($arr)-2; $i++){
								$getRequirementName = mysql_fetch_array(mysql_query("SELECT id, requirements FROM tblref_applicationrequirements WHERE id = '". $arr[$i] ."';", $connection));
								$RequirementList .=  "<br/>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;". $getRequirementName[0] ."&nbsp;<span class='fa fa-angle-right blue'></span>&nbsp;". $getRequirementName[1];
							}

							$PermitList = "";
							$arr = explode("|", $_POST['Permits']);
							for($i=0; $i <= count($arr)-2; $i++){
								$getPermitName = mysql_fetch_array(mysql_query("SELECT id, DESCRIPTION FROM tblref_typeofpermits WHERE id = '". $arr[$i] ."';", $connection));
								$PermitList .=  "<br/>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;". $getPermitName[0] ."&nbsp;<span class='fa fa-angle-right blue'></span>&nbsp;". $getPermitName[1];
							}

							// INSERT LOGS JONAS 9/30/2019 START
							$arrHeader = ["Proposal", "Leads ID", "Inquiry ID", "Trade ID", "Trade Name", "Merchant Code", "Company ID", "Company Name", "Industry ID", "Process Owner", "Source", "Classification", "Department", "Category", "Mall ID", "Mall Name", "Start Date", "End Date", "Months", "Year", "Escalation Rate", "Year Start", "Year Basis", "Rent Free Construction", "Rent Free Construction Start Date", "is rent VATable?", "VAT Type", "VAT Percent", "Monthly Rent", "Unit", "Charges List", "Requirements", "Permits"];
							$arrValue = [$_POST['isProposal'], $_POST['LeadsID'], $_POST['InquiryID'], $_POST['TradeID'], $_POST['TradeName'], $MerchantCode['merchant_code'], $_POST['CompanyID'], $_POST['CompanyName'], $_POST['IndustryID'], $_POST['ProcessOwner'], $_POST['Source'], $_POST['Classification'], $_POST['Department'], $_POST['Category'], $_SESSION['MMS-Designation'], $Mall['mallname'], date('Y-m-d', strtotime($_POST['DateFrom'])), date('Y-m-d', strtotime($_POST['DateTo'])), $_POST['MonthTerm'], $_POST['YearTerm'], $_POST['EscaRate'], $_POST['EscaRateStart'], $_POST['EscaYearBasis'], $_POST['RentFreeCon'],  date('Y-m-d', strtotime($_POST['RentFreeConStartDate'])), $VATSetup, number_format($_POST['MonthlyRent'], "2", ".", ","), $UnitList, $ChargesList, $RequirementList, $PermitList];
							$tran_logs = create_logs_per_transaction("updated a proposal.", "Inquiry Module", createXinfo("UPDATE", $arrHeader, "", $arrValue, "", "", ""), "" ,"UPDATE", $_POST['InquiryID']);
							// INSERT LOGS JONAS 9/30/2019 END
						}
					}

					if($_POST['MMS_Module'] == 'tenants' && ($_POST['TenantID'] != '' || $_POST['TenantID'] != 'undefined')){
						$TenantOccupancy = mysql_fetch_array(mysql_query("SELECT datefrom, dateto FROM tbltrans_tenants WHERE TenantID = '". $_POST['TenantID'] ."';", $connection));

						$UnitList = "";
						$resUpdateUnitStatus = mysql_query("SELECT UnitID FROM tbltrans_inquiry_unit WHERE InquiryID = '". $_POST['InquiryID'] ."';", $connection);
						while($rowUpdateUnitStatus = mysql_fetch_array($resUpdateUnitStatus)){

							$resUpdateUnit = mysql_query("UPDATE tblref_unit SET status = 'Vacant', TenantID = NULL, TenantName = NULL, startDate = NULL, endDate = NULL WHERE unitid = '". $rowUpdateUnitStatus['UnitID'] ."';", $connection);

		                	$resUpdateLogs = mysql_query("UPDATE tblunit_statuslogs SET status = 'Vacant', tenantid = NULL, tenantname = NULL, inquiryid = NULL WHERE unitid = '". $rowUpdateUnitStatus['UnitID'] ."' AND xdate BETWEEN '". date('Y-m-d', strtotime($TenantOccupancy['datefrom'])) ."' AND '". date('Y-m-d', strtotime($TenantOccupancy['dateto'])) ."';", $connection);
		                }

		                $resDeleteUnit = mysql_query("DELETE FROM tbltrans_inquiry_unit WHERE InquiryID = '". $_POST['InquiryID'] ."';", $connection);
						if($resDeleteUnit == true){
							$arr = explode("|", $_POST['SelectedUnits']);
							for($i=0; $i <= count($arr)-2; $i++){
								$resInsertInquiryUnit = mysql_query("INSERT INTO tbltrans_inquiry_unit SET InquiryID = '". $_POST['InquiryID'] ."', UnitID = '". $arr[$i] ."';", $connection);
								$UnitName = mysql_fetch_array(mysql_query("SELECT unitname FROM tblref_unit WHERE unitID = '". $arr[$i] ."';", $connection));
								$UnitList .= "<br/>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;". $arr[$i] ."&nbsp;<span class='fa fa-angle-right blue'></span>&nbsp;". $UnitName[0];

								$resUpdateUnit = mysql_query("UPDATE tblref_unit SET status = 'Occupied', TenantID = '". $_POST['TenantID'] ."', TenantName = '". $_POST['TradeName'] ."', startDate = '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."', endDate = '". date('Y-m-d', strtotime($_POST['DateTo'])) ."' WHERE unitid = '". $arr[$i] ."';", $connection);
								
								$StartDate = date('Y-m-d', strtotime($_POST['DateFrom']));
					            while(date('Y-m-d', strtotime($StartDate)) <= date('Y-m-d', strtotime($_POST['DateTo']))){
					            	$chkUnitLogs = mysql_num_rows(mysql_query("SELECT id FROM tblunit_statuslogs WHERE unitid = '". $arr[$i] ."' AND xdate = '". $StartDate ."';", $connection));
					            	if($chkUnitLogs == 0){
					                	$resInsertLogs = mysql_query("INSERT INTO tblunit_statuslogs SET unitid = '". $arr[$i] ."', unitname = '". $UnitName['unitname'] ."', xdate = '". $StartDate ."', xtime = '". date('H:i:s') ."', status = 'Occupied', tenantid = '". $_POST['TenantID'] ."', tenantname = '". $_POST['TradeName'] ."', inquiryid = '". $InquiryID ."';", $connection);
					            	}else{
					                	$resInsertLogs = mysql_query("UPDATE tblunit_statuslogs SET status = 'Occupied', tenantid = '". $_POST['TenantID'] ."', tenantname = '". $_POST['TradeName'] ."', inquiryid = '". $InquiryID ."' WHERE unitid = '". $arr[$i] ."' AND xdate = '". $StartDate ."';", $connection);
					            	}
					                $StartDate = date('Y-m-d', strtotime($StartDate . '+1 day'));
					            }
							}
						}

						$resDirectTenant = mysql_query("UPDATE tbltrans_tenants SET tradeID = '". $_POST['TradeID'] ."', tradename = '". $_POST['TradeName'] ."', CompanyID = '". $_POST['CompanyID'] ."', companyname = '". $_POST['CompanyName'] ."', datefrom = '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."', dateto = '". date('Y-m-d', strtotime($_POST['DateTo'])) ."', Status = 'Active', noofmonths = '". $_POST['MonthTerm'] ."', noofyears = '". $_POST['YearTerm'] ."', ustatus = 'Occupied', tenanttype = '". $_POST['BillingType'] ."', revpercent = '". $_POST['BillPercent'] ."', merchant_code = '". $MerchantCode['merchant_code'] ."', withPOS = '". $POSCount ."', uploadingoffiles = '". $TPSStat ."', mallCompanyID = '". $Mall['corp_ID'] ."', ClassID = '". $_POST['Classification'] ."', DepartmentID = '". $_POST['Department'] ."', CategoryID = '". $_POST['Category'] ."', inqSource = '". $_POST['Source'] ."', inqPrcssOwnr = '". $_POST['ProcessOwner'] ."', BillerID = '". $_POST['BillerID'] ."', monthly_dues = '". floatval($_POST['MonthlyRent']) ."', noofdays = '". $_POST['DayTerm'] ."', payment_terms = '". $_POST['isDaily'] ."' WHERE TenantID = '". $_POST['TenantID'] ."';", $connection);

						$resContract = mysql_query("UPDATE tblcontract SET datefrom = '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."', dateto = '". date('Y-m-d', strtotime($_POST['DateTo'])) ."', Group_Name = '". mysql_real_escape_string($gname) ."', Term_Name = '". mysql_real_escape_string($tname) ."', ids = '". $_POST['TermsAndCondition'] ."', Conditions = '".  mysql_real_escape_string($cond) ."';", $connection);
					}

					if($UpdateInquiry == 0){
						$res = mysql_query("UPDATE tbltrans_inquiry SET TradeID = '". $_POST['TradeID'] ."', Trade_Name = '". $_POST['TradeName'] ."', Company_ID = '". $_POST['CompanyID'] ."', Company_Name = '". $_POST['CompanyName'] ."', Industry = '". $_POST['IndustryID'] ."', merchant_code = '". $MerchantCode['merchant_code'] ."', date_modified = '". date('Y-m-d H:i:s') ."', mod_by = '". getusername() ."', leadsID = '". $_POST['LeadsID'] ."', ClassID = '". $_POST['Classification'] ."', DepartmentID = '". $_POST['Department'] ."', CategoryID = '". $_POST['Category'] ."', inqSource = '". $_POST['Source'] ."', inqPrcssOwnr = '". $_POST['ProcessOwner'] ."', mallCompanyID = '". $Mall['corp_ID'] ."', datefrom = '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."', dateto = '". date('Y-m-d', strtotime($_POST['DateTo'])) ."', billingtype = '". $_POST['BillingType'] ."', billingperc = '". $_POST['BillPercent'] ."', desired_noofmonths = '". $_POST['MonthTerm'] ."', desired_noofyears = '". $_POST['YearTerm'] ."', BillerID = '". $_POST['BillerID'] ."', monthly_dues = '". floatval($_POST['MonthlyRent']) ."', desired_noofdays = '". $_POST['DayTerm'] ."' WHERE Inquiry_ID = '". $_POST['InquiryID'] ."';", $connection);
						if($res == true){
							// $UpdateLeads = mysql_query("UPDATE tbltrans_leads SET Status = 'Inquired' WHERE leadsID = '". $_POST['LeadsID'] ."'", $connection);

							if($_POST['MMS_Module'] == 'inquiry'){
								echo "1|Inquiry successfully updated.";
							}else if($_POST['MMS_Module'] == 'leasingapplication'){
								echo "1|Leasing Application successfully updated.|". $_POST['InquiryID'] . "|" . $_POST['ApplicationID'];
							}else if($_POST['MMS_Module'] == 'reservation'){
								echo "1|Reservation successfully updated.|". $_POST['InquiryID'] . "|" . $_POST['ApplicationID'];
							}else if($_POST['MMS_Module'] == 'tenants'){
								echo "1|Tenant information successfully updated.|". $_POST['InquiryID'] . "|" . $_POST['ApplicationID'];
							}else{
								echo "1|Proposal successfully updated.|". $_POST['InquiryID'] . "|" . $_POST['ApplicationID'];
							}						

							// INSERT LOGS JONAS 9/30/2019 START
							$arrHeader = ["Leads ID", "Inquiry ID", "Trade ID", "Trade Name", "Merchant Code", "Company ID", "Company Name", "Industry ID", "Process Owner", "Source", "Classification", "Department", "Category", "Mall ID", "Mall Name", "Unit"];
							$arrValue = [$_POST['LeadsID'], $InquiryID, $_POST['TradeID'], $_POST['TradeName'], $MerchantCode['merchant_code'], $_POST['CompanyID'], $_POST['CompanyName'], $_POST['IndustryID'], $_POST['ProcessOwner'], $_POST['Source'], $_POST['Classification'], $_POST['Department'], $_POST['Category'], $_SESSION['MMS-Designation'], $Mall['mallname'], fncBreakdownArray($_POST['SelectedUnits'])];
							$tran_logs = create_logs_per_transaction("updated an inquiry.", "Inquiry Module", createXinfo("UPDATE", $arrHeader, "", $arrValue, "", "", ""), "" ,"UPDATE", $_POST['InquiryID']);
							// INSERT LOGS JONAS 9/30/2019 END

						}else{
							echo "2|Failed to update inquiry.";
						}
					}else{
						echo "1|Proposal successfully updated.|". $_POST['InquiryID'] . "|" . $_POST['ApplicationID'];
					}
				}
			}
		break;

		case 'fncSendToLeasing':
			$leadsInfo = mysql_fetch_array(mysql_query("SELECT leadsID FROM tbltrans_inquiry WHERE Inquiry_ID = '". $_POST['InquiryID'] ."';", $connection));
			// $CheckProposal = mysql_num_rows(mysql_query("SELECT proposalNum FROM tbltrans_proposal WHERE inquiryID = '". $_POST['InquiryID'] ."' AND stats = '1';", $connection));
			// if($CheckProposal == 1){
				// $AppPref = mysql_fetch_array(mysql_query("SELECT appprefix FROM tblsys_setup;", $connection));
				// $ApplicationID = createidno($AppPref['appprefix'], "tbltrans_appid", "app_id");

				// ----- Creating of logs

				// $arrHeader = ["Applied By","Generated ID","Date Applied"];
				// $arrFields = ["app_by","Application_ID","date_applied"];
				// $arrValue = [getusername(),$ApplicationID,date('Y-m-d H:i:s')];
				// $Logs = createXinfo( "INSERT" , $arrHeader , $arrFields , $arrValue , "tbltrans_proposal" , "" , "" );

				// -----

				$sql = "UPDATE tbltrans_inquiry SET S2Leasing = '1', mod_by = '". getusername() ."', date_modified = '". date('Y-m-d H:i:s') ."' WHERE Inquiry_ID = '". $_POST['InquiryID'] ."';";
				$res = mysql_query($sql, $connection);
				if($res == true){
					$UpdateLeads = mysql_query("UPDATE tbltrans_leads SET Status = 'Pending Application' WHERE leadsID = '". $leadsInfo['leadsID'] ."';", $connection);
					// if($Logs != ""){
					// 	$tran_logs = create_logs_per_transaction("send proposal to leasing application module.", "Proposal Module", $Logs, "" ,"ADD", $_POST['InquiryID']);
					// }
					echo 1;

					// INSERT LOGS JONAS 8/13/2019 START
					$tran_logs = create_logs_per_transaction('send an inquiry to leasing application', 'Inquiry Module', '', '', 'UPDATE', $_POST['InquiryID']);
					// INSERT LOGS JONAS 8/13/2019 END
				}
			// }else{
			// 	echo 2;
			// }
		break;

		case 'fncLoadEscalation':
			$resGetEscalation = mysql_query("SELECT EscaYear, EscaRate FROM tbltrans_escalation WHERE InquiryID = '". $_POST['InquiryID'] ."' AND ProposalNum = '". $_POST['isProposal'] ."';", $connection);
			while ($rowEscalation = mysql_fetch_array($resGetEscalation)) {
				echo 	"<tr>
							<td style='text-align: center; vertical-align: middle;'>". $rowEscalation['EscaYear'] ."</td>
							<td style='text-align: center; vertical-align: middle;z-index: 0;'>
									<span class='input-icon input-icon-right'>
			                            <input type='text' class='form-control txtEscalation' style='background-color: white !important; border-color: rgb(213, 213, 213);background: transparent !important; border: 0px;text-align: center;' onkeypress='return isNumberKey(event);' onchange='fncgetPaymentSchedule();' onkeyup='fncgetPaymentSchedule();' value='". floatval($rowEscalation['EscaRate']) ."'>
			                            <i class='ace-icon fa fa-percent' style='z-index: 0;'></i>
			                        </span>
								</td>
						</tr>";
			}
		break;

		case 'fncLoadUnitProposal':
			$resgetUnitIDs = mysql_query("SELECT UnitID FROM tbltrans_proposal_unit WHERE InquiryID = '". $_POST['InquiryID'] ."' AND proposalNum = '". $_POST['isProposal'] ."';", $connection);
			while($rowUnitIDs = mysql_fetch_array($resgetUnitIDs)){
				$UnitIDArr .= "'" . $rowUnitIDs[0] . "'" . ",";
				$UnitIDArr2 .= $rowUnitIDs[0]."|";
			}

			$rowCount = 1;
			$TotalAmount = 0;
			$resUnitInfo = mysql_query("SELECT wingid, floorid, classid, depid, catid, unitname, sqmunitsetup, sqm_width, sqm_height, pricepersqmunitsetup, area, assocdues, mallid, typeofbusiness, unitid, totalamountunitsetup FROM tblref_unit WHERE unitid IN (". substr(trim($UnitIDArr), 0, -1) .");", $connection);
			$UnitCount = mysql_num_rows($resUnitInfo);
			if($UnitCount == 0){
				echo "<div class='alert alert-info center'> No Unit Selected... </div>";
			}else{
				echo "<div class='row form-group'>";
				while($UnitInfo = mysql_fetch_array($resUnitInfo)){
					$TotalAmount += $UnitInfo['totalamountunitsetup'];
					if($UnitCount % 2 == 0){
						$ColumnGrid = '6';
					}else{
						if($rowCount == $UnitCount){
							$ColumnGrid = '12';
						}else{
							$ColumnGrid = '6';
						}
					}
					$Classification = mysql_fetch_array(mysql_query("SELECT classification FROM tblref_merchandise_class WHERE classificationID = '". $UnitInfo['classid'] ."'", $connection));
					$Department = mysql_fetch_array(mysql_query("SELECT department FROM tblref_merchandise_depa WHERE departmentID = '". $UnitInfo['depid'] ."'", $connection));
					$Category = mysql_fetch_array(mysql_query("SELECT category FROM tblref_merchandisedep_cat WHERE categoryID = '". $UnitInfo['catid'] ."'", $connection));
					$Wing = mysql_fetch_array(mysql_query("SELECT wing FROM tblref_wing WHERE wingID = '". $UnitInfo['wingid'] ."';", $connection));
					$Floor = mysql_fetch_array(mysql_query("SELECT floor FROM tblref_floorsetup WHERE floorid = '". $UnitInfo['floorid'] ."';", $connection));

					echo 	"<div class='col-md-". $ColumnGrid ."'>
								<div class='widget-box widget-color-blue3 ui-sortable-handle collapsed'>
									<input type='hidden' class='txtASU' value='". $UnitInfo['unitid'] ."'>
									<div class='widget-header widget-header-small'>
										<h5 class='widget-title'>
											". $UnitInfo['unitname'] ."
										</h5>
										<div class='widget-toolbar'>
											<a href='#' data-action='collapse'>
												<i class='ace-icon fa bigger-125 fa-chevron-down'></i>
											</a>
										</div>
									</div>

									<div class='widget-body' style='display: none;'>
										<div class='widget-main'>
											<div class='row'>";
			            				echo   	"<div class='col-md-12'>
			                						<ul class='ace-thumbnails clearfix' style='max-height: 270px;overflow-y: scroll;'>";
														$resUnitImages = mysql_query("SELECT UnitID, ImageName FROM tblref_unitimage WHERE UnitID = '". $UnitInfo['unitid'] ."';", $connection);
														while($rowUnitImages = mysql_fetch_array($resUnitImages)){
															if(file_exists("../Mall_Attachments/Unit Image/".$rowUnitImages['UnitID']."/".$rowUnitImages['ImageName'])){
																echo 	"<li class='center' style='border-color: #CCC !important;'>
											                                <a href='../Mall_Attachments/Unit Image/".$rowUnitImages['UnitID']."/".$rowUnitImages['ImageName'] ."' title='Photo Title' data-rel='cbProUnitList-". $rowUnitImages['UnitID'] ."' class='cboxElement'>
											                                    <img width='78' height='78' alt='". $rowUnitImages['ImageName'] ."' src='../Mall_Attachments/Unit Image/".$rowUnitImages['UnitID']."/".$rowUnitImages['ImageName'] ."' style='padding: 5px;'>
											                                </a>
											                            </li>";
															}
														}
			                                echo    "</ul>
			                    				</div>";
			            				echo 	"<div class='col-md-6'>
			            							<div class='row'>
			            								<div class='col-md-12'>
															<h4 class='header blue'>Unit Information</h4>
														</div>
								                        <div class='profile-user-info profile-user-info-striped'>
								                        	<div class='profile-info-row'>
								                                <div class='profile-info-name' style='white-space: nowrap;'> Unit Type </div>
								                                <div class='profile-info-value'>
								                                    <span> ". $UnitInfo['typeofbusiness'] ." </span>
								                                </div>
								                            </div>
								                            <div class='profile-info-row'>
								                                <div class='profile-info-name' style='white-space: nowrap;'> Unit ID </div>
								                                <div class='profile-info-value'>
								                                    <span> ". $UnitInfo['unitid'] ." </span>
								                                </div>
								                            </div>
								                            <div class='profile-info-row'>
								                                <div class='profile-info-name' style='white-space: nowrap;'> Wing </div>
								                                <div class='profile-info-value'>
								                                    <span> ". $Wing[0] ." </span>
								                                </div>
								                            </div>
								                            <div class='profile-info-row'>
								                                <div class='profile-info-name' style='white-space: nowrap;'> Floor </div>
								                                <div class='profile-info-value'>
								                                    <span> ". $Floor[0] ." </span>
								                                </div>
								                            </div>";
								                            if(SysLeaseSetup('floorandunitmeasurement') == "Area"){
								                            	echo " <div class='profile-info-row'>
											                                <div class='profile-info-name' style='white-space: nowrap;'> Area </div>
											                                <div class='profile-info-value'>
											                                    <span> ". number_format($UnitInfo['area'], "0", "", ",") ." SQM</span>
											                                </div>
											                            </div>";
								                            }else{
								                            	echo " <div class='profile-info-row'>
											                                <div class='profile-info-name' style='white-space: nowrap;'> Length </div>
											                                <div class='profile-info-value'>
											                                    <span> ". number_format($UnitInfo['sqm_height'], "0", "", ",") ." SQM</span>
											                                </div>
											                            </div><div class='profile-info-row'>
											                                <div class='profile-info-name' style='white-space: nowrap;'> Width </div>
											                                <div class='profile-info-value'>
											                                    <span> ". number_format($UnitInfo['sqm_width'], "0", "", ",") ." SQM</span>
											                                </div>
											                            </div>";
								                            }
								                    echo    "<div class='profile-info-row'>
								                             	<div class='profile-info-name'> Rate </div>
								                             	<div class='profile-info-value'>
								                                 	<span> ". number_format($UnitInfo['pricepersqmunitsetup'], "2", ".", ",") ." </span>
								                             	</div>
								                         	</div>";
								                            if(SysLeaseSetup('isAssocDues') == '1'){
								                    echo    "<div class='profile-info-row'>
								                             	<div class='profile-info-name' style='white-space: nowrap;'> Association Dues </div>
								                             	<div class='profile-info-value'>
								                                 	<span> ". number_format($UnitInfo['assocdues'], "2", ".", ",") ." </span>
								                             	</div>
								                         	</div>";
								                            }
							                    echo    "</div>
							                   		</div>
							                    </div>
												<div class='col-md-6'>
							                        <div class='row form-group'>
							                        	<h4 class='header blue'>Amenities</h4>
							                        </div>
							                        <div class='row form-group'>";
														$resAmenities = mysql_query("SELECT amenitiesID FROM tblref_unit_amenities WHERE unitID = '". $UnitInfo['unitid'] ."';", $connection);
														$cntAmenities = mysql_num_rows($resAmenities);
														if($cntAmenities == 0){
															echo 	"<div class='col-md-12'>
																		<i class='ace-icon fa fa-times bigger-150 red'></i>&nbsp;&nbsp;This unit has no amenities.
																	</div>";
														}else{
															while($rowAmenities = mysql_fetch_array($resAmenities)){
																$resAmenities2 = mysql_query("SELECT amenitiesname FROM tblref_amenities WHERE amenitiesid = '".$rowAmenities["amenitiesID"]."'", $connection);
																$rowAmenities2 = mysql_fetch_array($resAmenities2);
																if($rowAmenities2["amenitiesname"] != ""){
																	echo 	"<div class='col-md-12'>
																				<i class='ace-icon fa fa-check bigger-150 blue'></i>&nbsp;&nbsp;". $rowAmenities2["amenitiesname"] ."
																			</div>";
																}
															}
														}
			                    				echo"</div>
			                    				</div>";
			                    				$OtherInfo = mysql_fetch_array(mysql_query("SELECT OtherUnitInfo FROM tblref_unit WHERE unitid = '". $UnitInfo['unitid'] ."';", $connection));
												if($OtherInfo['OtherUnitInfo'] != ""){
								                echo 	"<div class='col-md-12' style='margin-top: 10px;'>
								                			<div class='row'>
									                			<div class='col-md-12'>
								                					<h4 class='header blue'>Other Unit Information</h4>
								                				<div>
							                				</div>
							                			</div>
							                			<div class='col-md-12'>
								                			<div class='row'>
									                			<div class='col-md-12'>
								                					". $OtherInfo['OtherUnitInfo'] ."
							                					</div>
							                				</div>
							                			</div>";
							                	}
			                    	echo	"</div>
										</div>
									</div>
								</div>
							</div>";
					$rowCount++;
				}
				echo "</div>";
			}

			echo "|".number_format($TotalAmount, 2, '.', ',') . "|" . $UnitIDArr2;
		break;

		case 'fncInqUpdateInfo':
			$sql = mysql_fetch_array(mysql_query("SELECT date_inquired, inq_by, date_modified, mod_by, time_inquired FROM tbltrans_inquiry WHERE Inquiry_ID = '". $_POST['InquiryID'] ."'", $connection));
			if($sql[0] == ""){
				$datecreated = "";
			}else{
				$datecreated = date("F d, Y h:i A", strtotime($sql[0].$sql[4]));
			}

			if($sql[2] == ""){
				$datemodified = "";
			}else{
				$datemodified = date("F d, Y h:i A", strtotime($sql[2]));
			}
			echo $datecreated . "|" . $sql[1] . "|" . $datemodified . "|" . $sql[3];
		break;	

		case 'fncLoadChargeProposal':
			$header = explode("|", getrentvattype($_SESSION['MMS-Designation']));
			$isVatable = $header[1];
			$isInclusive = $header[2];
			$VATPercent = floatval($header[0]) / 100;
			
			$res = mysql_query("SELECT ChargeCode, ChargeDesc, ChargeType, ChargeAmount FROM tbltrans_procharges WHERE InquiryID = '". $_POST['InquiryID'] ."' AND ProposalNum = '". $_POST['isProposal'] ."';", $connection);
			while($row = mysql_fetch_array($res)){
				$getChargeInfo = mysql_fetch_array(mysql_query("SELECT CHARGE_DESC, RATE_TYPE, CHARGE_ID, OTHER_REASON FROM tblref_refcharges WHERE CHARGE_ID = '". $row['ChargeCode'] ."';", $connection));

				// if($_POST['VATSetup'] == 0){
				// 	if($isVatable == "yes"){
	   //                  if($isInclusive == "inc"){ //VAT IS INCLUSIVE
	   //                      $VATAmount = ( floatval($row['RATE']) / 1.12 ) * $VATPercent;
	   //                      $RentLessVAT = floatval($row['RATE']) - $VATAmount;
	   //                      $Rent = $RentLessVAT;
				// 			$VAT = $VATAmount;
	   //                      $ChargeAmount = $VAT + $Rent;
	   //                  }else{ //VAT IS EXCLUSIVE
	   //                      $VATAmount = floatval($row['RATE']) * $VATPercent;
	   //                      $RentPlusVAT = floatval($row['RATE']);
	   //                      $Rent = floatval($row['RATE']);
	   //                      $VAT = $VATAmount;
	   //                      $ChargeAmount = floatval($row['RATE']) + $VATAmount;
	   //                  }
	   //              }else{
	   //                  $Rent = $row['RATE'];
	   //                  $VAT = "0.00";
	   //                  $ChargeAmount = floatval($row['RATE']);
	   //              }
	   //          }else{
	   //          	$Rent = $row['RATE'];
	   //              $VAT = "0.00";
	                $ChargeAmount = floatval($row['ChargeAmount']);
	            // }

				if($getChargeInfo['RATE_TYPE'] == "Other"){
					$Parusa = $getChargeInfo['OTHER_REASON'];
				}else if($getChargeInfo['RATE_TYPE'] == "Occurence"){
					$Parusa = number_format($row['ChargeAmount'], "2", ".", ",") . " " . $getChargeInfo['OTHER_REASON'];
				}else{
					$Parusa = number_format($row['ChargeAmount'], "2", ".", ",") . " " . $getChargeInfo['RATE_TYPE'];
				}

				echo "<tr id='". $row['ChargeCode'] ."'>
							<td>". $getChargeInfo['CHARGE_DESC'] ."</td>
							<td>". $row['ChargeType'] ."</td>
							<td>". $Parusa ."</td>
							<td class='hidden getthisvalue'>". $ChargeAmount ."</td>
							<td style='text-align: center;z-index: 0;'><button class='btn btn-xs btn-danger isFinal btn-round txtInqDisabled' onclick='$(\"#". $row['ChargeCode'] ."\").remove(); fncgetPaymentSchedule(); getTotalMonthlyCharges();'><i class='fa fa-trash-o'></i></button></td>
						</tr>";

			}
		break;

		case 'fncLoadTermsandCon':
			$rowTermsCons = mysql_fetch_array(mysql_query("SELECT terms_condition FROM tbltrans_proposal WHERE InquiryID = '". $_POST['InquiryID'] ."' AND proposalNum = '". $_POST['isProposal'] ."';", $connection));
			$arr = explode("|", $rowTermsCons['terms_condition']);
			for ($i=0; $i <= count($arr)-2; $i++) { 
				$TermsandCondition .= "'" . $arr[$i] . "'" . ",";
			}
			$res = mysql_query("SELECT Term_Name, Description FROM tblcondition WHERE Term_ID IN (". substr(trim($TermsandCondition), 0, -1) .");", $connection);
			while($row = mysql_fetch_array($res)){
				echo 	"<tr>
							<td>". $row['Term_Name'] ."</td>
							<td>". $row['Description'] ."</td>
						</tr>";
			}	
			echo "@".$rowTermsCons['terms_condition'];
		break;

		case 'showModalAddRequirements':
			$ProposalInfo = mysql_fetch_array(mysql_query("SELECT stats FROM tbltrans_proposal WHERE inquiryID = '". $_POST['InquiryID'] ."' AND proposalNum = '". $_POST['ProposalNum'] ."';", $connection));
			$mgaMeron = "";
			$arr = explode("|", $_POST['ids']);
			for ($i=0; $i <= count($arr)-2; $i++) { 
				$mgaMeron .= "'" . $arr[$i] . "'" . ",";
			}
			if($_POST['ids'] != ""){
				$tanong = "AND id NOT IN (". substr(trim($mgaMeron), 0, -1) .")";
			}else{
				$tanong = "";
			}
			$res = mysql_query("SELECT id, requirements FROM tblref_applicationrequirements WHERE requirements LIKE '%". $_POST['key'] ."%' ". $tanong ." ORDER BY requirements ASC ", $connection);
			while($row = mysql_fetch_array($res)){
				echo "	<tr id='TRReq". $row['id'] ."' onclick='fncAddSelectedRequirement(\"". $row['id'] ."\", \"". $ProposalInfo['stats'] ."\");'>
							<td class='RequirementsDesc'>". $row['requirements'] ."</td>
							<td class='hide RequirementsID'>". $row['id'] ."</td>
						</tr>";
			}
		break;

		case 'showModalAddPermits':
			$ProposalInfo = mysql_fetch_array(mysql_query("SELECT stats FROM tbltrans_proposal WHERE inquiryID = '". $_POST['InquiryID'] ."' AND proposalNum = '". $_POST['ProposalNum'] ."';", $connection));
			$mgaMeron = "";
			$arr = explode("|", $_POST['ids']);
			for ($i=0; $i <= count($arr)-2; $i++) { 
				$mgaMeron .= "'" . $arr[$i] . "'" . ",";
			}
			if($_POST['ids'] != ""){
				$tanong = "AND id NOT IN (". substr(trim($mgaMeron), 0, -1) .")";
			}else{
				$tanong = "";
			}
			$res = mysql_query("SELECT id, DESCRIPTION FROM tblref_typeofpermits WHERE DESCRIPTION LIKE '%". $_POST['key'] ."%' ". $tanong ." ORDER BY DESCRIPTION ASC ", $connection);
			while($row = mysql_fetch_array($res)){
				echo "	<tr id='TRPer". $row['id'] ."' onclick='fncAddSelectedPermit(\"". $row['id'] ."\", \"". $ProposalInfo['stats'] ."\")'>
							<td class='RequirementsDesc'>". $row['DESCRIPTION'] ."</td>
							<td class='hide RequirementsID'>". $row['id'] ."</td>
						</tr>";
			}
		break;

		case 'fncAddSelectedRequirement':
			$ReqInfo = mysql_fetch_array(mysql_query("SELECT id, requirements FROM tblref_applicationrequirements WHERE id = '". $_POST['RequirementID'] ."';", $connection));
			$ProposalInfo = mysql_fetch_array(mysql_query("SELECT stats FROM tbltrans_proposal WHERE inquiryID = '". $_POST['InquiryID'] ."' AND proposalNum = '". $_POST['ProposalNum'] ."';", $connection));
			// if($ProposalInfo['stats'] == "1"){
				echo 	"<div class='row divReq". $ReqInfo['id'] ."'>
						 	<label class='col-xs-7'>". $ReqInfo['requirements'] ."</label>
						 	<div class='col-xs-1 center'><i style='color:red;margin-top:5px;' class='ace-icon fa fa-remove bigger-120' id='posting_commentreq_". $_POST['ReqCount'] ."_icon'></i></div>
							<div class='col-xs-3' style='white-space: nowrap;text-overflow: ellipsis;overflow: hidden;'>
								<form name='posting_comment' class='form_lease_application_req_2' id='posting_commentreq_". $_POST['ReqCount'] ."'>
	                                <input type='hidden' name='txtRequirementInquiryID' class='txtRequirementInquiryID' value='". $_POST['InquiryID'] ."'>
	                                <input type='hidden' name='txtRequirementApplicationID' class='txtRequirementApplicationID' value='". $_POST['InquiryID'] ."'>
	                                <input type='hidden' name='txtProposalNum' class='txtProposalNum' value='". $_POST['ProposalNum'] ."'>
                                	<input type='file' class='". $class ." DisablePayInfo2 txtReservationReq2 upload_app_req id-input-file-2' name='attachment_filess' id='overridemoko". $ReqInfo['id'] ."' onchange='chkclippeddocx($(this))'/>
                            		<input type='hidden' name='hiddenidss' value='". $ReqInfo['id'] ."'>
                          		</form>
                          	</div>
                          	<div class='col-xs-1'><button class='btn btn-xs btn-danger btn-round' onclick='$(\".divReq". $ReqInfo['id'] ."\").remove();'><i class='fa fa-trash-o'></i></button></div>
                        </div>";
			// }
        break;

		case 'fncAddSelectedRequirement2':
			$ReqInfo = mysql_fetch_array(mysql_query("SELECT id, requirements FROM tblref_applicationrequirements WHERE id = '". $_POST['RequirementID'] ."';", $connection));
			echo 	"<tr class='divReq". $_POST['RequirementID'] ."' id='". $_POST['RequirementID'] ."'>
                        <td>". $ReqInfo['requirements'] ."</td>
                        <td style='text-align: center;z-index: 0;'><button class='btn btn-xs btn-danger btn-round' onclick='$(\".divReq". $_POST['RequirementID'] ."\").remove();'><i class='fa fa-trash-o'></i></button></td>
                    </tr>";
		break;

		case 'fncAddSelectedPermit':
			$PerInfo = mysql_fetch_array(mysql_query("SELECT id, DESCRIPTION FROM tblref_typeofpermits WHERE id = '". $_POST['PermitID'] ."';", $connection));
			$ProposalInfo = mysql_fetch_array(mysql_query("SELECT stats FROM tbltrans_proposal WHERE inquiryID = '". $_POST['InquiryID'] ."' AND proposalNum = '". $_POST['ProposalNum'] ."';", $connection));
			// if($ProposalInfo['stats'] == "1"){
				echo 	"<div class='row divPer". $PerInfo['id'] ."'>
						 	<label class='col-xs-4'>". $PerInfo['DESCRIPTION'] ."</label>
						 	<div class='col-xs-1'>Exp. Date</div>
							<form name='posting_comment' class='form_lease_application_permit' id='posting_commentpermit_". $_POST['PerCount'] ."'>
	                          	<div class='col-xs-2'>
	                          		<input type='text' name='expiry_date' class='date-picker form-control DisablePayInfo2 txtReservationReq2' value='". date('m/d/Y') ."'>
	                          	</div>
							 	<div class='col-xs-1 center'>
							 		<i style='color:red;margin-top:5px;' class='ace-icon fa fa-remove bigger-120' id='posting_commentpermit_". $_POST['PerCount'] ."_icon'></i>
							 	</div>
								<div class='col-xs-3' style='white-space: nowrap;text-overflow: ellipsis;overflow: hidden;'>
		                            <input type='hidden' name='txtPermitInquiryID' class='txtPermitInquiryID' value='". $_POST['InquiryID'] ."'>
	                                <input type='hidden' name='txtPermitApplicationID' class='txtPermitInquiryID' value='". $_POST['InquiryID'] ."'>
	                                <input type='hidden' name='txtPermitProposalNum' class='txtPermitProposalNum' value='". $_POST['ProposalNum'] ."'>
	                                <input type='file' class='upload_app_permit id-input-file-2 DisablePayInfo2 txtReservationReq2' name='attachment_filess' id='overridepermit". $PerInfo['id'] ."' onchange='chkclippeddocx2($(this))'/>
	                                <input type='hidden' name='hiddenidss' value='". $PerInfo['id']."'>
	                            </div>
                          	</form>
                          	<div class='col-xs-1'><button class='btn btn-xs btn-danger btn-round' onclick='$(\".divPer". $PerInfo['id'] ."\").remove();'><i class='fa fa-trash-o'></i></button></div>
                        </div>";
			// }
		break;

		case 'fncAddSelectedPermit2':
			$PerInfo = mysql_fetch_array(mysql_query("SELECT id, DESCRIPTION FROM tblref_typeofpermits WHERE id = '". $_POST['PermitID'] ."';", $connection));
			echo 	"<tr class='divPer". $_POST['PermitID'] ."' id='". $_POST['PermitID'] ."'>
                        <td>". $PerInfo['DESCRIPTION'] ."</td>
                        <td style='text-align: center;z-index: 0;'><button class='btn btn-xs btn-danger btn-round' onclick='$(\".divPer". $_POST['PermitID'] ."\").remove();'><i class='fa fa-trash-o'></i></button></td>
                    </tr>";
		break;

		case 'fncLoadRequirements':
			$rowRequirements = mysql_fetch_array(mysql_query("SELECT requirement_list FROM tbltrans_proposal WHERE InquiryID = '". $_POST['InquiryID'] ."' AND proposalNum = '". $_POST['isProposal'] ."';", $connection));
			$arr = explode("|", $rowRequirements['requirement_list']);
			for ($i=0; $i <= count($arr)-2; $i++) { 
				$Requirements .= "'" . $arr[$i] . "'" . ",";
			}
			$res = mysql_query("SELECT id, requirements FROM tblref_applicationrequirements WHERE id IN (". substr(trim($Requirements), 0, -1) .") ", $connection);
			while($row = mysql_fetch_array($res)){
				echo "	<tr class='divReq". $row['id'] ."' id='". $row['id'] ."'>
						<td>". $row['requirements'] ."</td>
						<td style='text-align: center;z-index: 0;'><button class='btn btn-xs btn-danger isFinal btn-round' onclick='$(\".divReq". $row['id'] ."\").remove();'><i class='fa fa-trash-o'></i></button></td>
					</tr>";
			}
		break;

		case 'fncLoadPermits':
			$rowPermits = mysql_fetch_array(mysql_query("SELECT permit_list FROM tbltrans_proposal WHERE InquiryID = '". $_POST['InquiryID'] ."' AND proposalNum = '". $_POST['isProposal'] ."';", $connection));
			$arr = explode("|", $rowPermits['permit_list']);
			for ($i=0; $i <= count($arr)-2; $i++) { 
				$Permits .= "'" . $arr[$i] . "'" . ",";
			}
			$res = mysql_query("SELECT id, DESCRIPTION FROM tblref_typeofpermits WHERE id IN (". substr(trim($Permits), 0, -1) .") ", $connection);
			while($row = mysql_fetch_array($res)){
				echo "	<tr class='divPer". $row['id'] ."' id='". $row['id'] ."'>
						<td>". $row['DESCRIPTION'] ."</td>
						<td style='text-align: center;z-index: 0;'><button class='btn btn-xs btn-danger isFinal btn-round' onclick='$(\".divPer". $row['id'] ."\").remove();'><i class='fa fa-trash-o'></i></button></td>
					</tr>";
			}
		break;

		case 'fncloadReqUpload':
			$i = 0;
			$reqList = mysql_fetch_array(mysql_query("SELECT requirement_list FROM tbltrans_proposal WHERE inquiryID = '". $_POST['InquiryID'] ."' AND proposalNum = '". $_POST['isProposal'] ."';", $connection));
			$arr = explode("|", $reqList[0]);
			for ($k = 0; $k <= COUNT($arr)-2; $k++) { 
				$res = mysql_query("SELECT filename, filetype FROM tbltrans_leasingapplicationreq WHERE reqID = '". $_POST["InquiryID"] ."' AND type_req_ID = '". $arr[$k] ."' AND proposalNum = '". $_POST['isProposal'] ."';", $connection);
				$Requirement = mysql_fetch_array($res);
				$ReqNum = mysql_num_rows($res);

				$row = mysql_fetch_array(mysql_query("SELECT id, requirements, override FROM tblref_applicationrequirements WHERE id = '". $arr[$k] .";'", $connection));

				$linkimage = '../Mall_Attachments/Requirements/'.$_POST["InquiryID"].'/'.$row["requirements"].'/'.$Requirement["filename"];
				if($Requirement["filetype"] == "image/jpeg" || $Requirement["filetype"] == "image/png" || $Requirement["filetype"] == "image/jpg"){
					$view = "<button class='btn btn-xs btn-purple btn-round' style='padding:3px; margin-bottom:4px; display:inline;' onclick='viewdocuimgindex(\"". $linkimage ."\")' title='view image'><i class='ace-icon fa fa-picture-o bigger-120'></i></button>";
				}else{
					$view = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				}

				if($ReqNum == 0){
					$i++;
					$id = "posting_commentreq_". $i;
					echo 	"<div class='row divReq". $arr[$k] ."'>
							 	<label class='col-xs-7'>". $row['requirements'] ."</label>
							 	<div class='col-xs-1 center'><i style='color:red;margin-top:5px;' class='ace-icon fa fa-remove bigger-120' id='". $id ."_icon'></i></div>
								<div class='col-xs-3' style='white-space: nowrap;text-overflow: ellipsis;overflow: hidden;'>
								<form name='posting_comment' class='form_lease_application_req_2' id='posting_commentreq_". $i ."'>
		                                <input type='hidden' name='txtRequirementInquiryID' class='txtRequirementInquiryID' value='". $_POST['InquiryID'] ."'>
		                                <input type='hidden' name='txtRequirementApplicationID' class='txtRequirementApplicationID' value='". $_POST['InquiryID'] ."'>
		                                <input type='hidden' name='txtProposalNum' class='txtProposalNum' value='". $_POST['isProposal'] ."'>
	                                	<input type='file' class='". $class ." DisablePayInfo2 txtReservationReq2 upload_app_req id-input-file-2' name='attachment_filess' id='overridemoko". $row['id'] ."' onchange='chkclippeddocx($(this))'/>
                                		<input type='hidden' name='hiddenidss' value='". $row['id'] ."'>
                              		</form>
                              	</div>
                              	<div class='col-xs-1'><button class='btn btn-xs btn-danger btn-round' onclick='$(\".divReq". $arr[$k] ."\").remove();'><i class='fa fa-trash-o'></i></button></div>
                            </div>";
				}else{
					echo 	"<div class='row'>
								<label class='col-xs-7'>". $row['requirements'] ."</label>
								<div class='col-xs-1 center'><i style='color:green;' class='ace-icon fa fa-check bigger-120'></i></div>
								<div class='col-xs-3' style='white-space: nowrap;text-overflow: ellipsis;overflow: hidden;'>
									<p class='req_nam_'". $_POST['appid'] ."' req_already_added_na' id='". $Requirement['filename'] ."' style='font-size:11px;font-weight:normal;font-style:italic;display:inline;'>&nbsp;&nbsp;". $Requirement['filename'] ."</p>
								</div>
								<div class='col-xs-1'>
									<div class='btn-group'>
										<button class='btn btn-xs btn-info btn-round' style='margin-bottom:3px; display:inline;'>
											<a href='../Mall_Attachments/Requirements/". $_POST['appid'] ."/". $row['requirements'] ."/". $Requirement['filename'] ."' download><i style='color:white !important;' class='ace-icon fa fa-download bigger-120'></i></a>
										  </button>
										". $view ."
									</div>
								</div>
							</div>";
				}
			}
		break;

		case 'fncloadPerUpload':
			$i = 0;
			$reqList = mysql_fetch_array(mysql_query("SELECT permit_list FROM tbltrans_proposal WHERE inquiryID = '". $_POST['InquiryID'] ."' AND proposalNum = '". $_POST['isProposal'] ."';", $connection));
			$arr = explode("|", $reqList[0]);
			for ($k = 0; $k <= COUNT($arr)-2; $k++) { 
				$sql = "SELECT filename, filetype, expirydate FROM tblref_tenantsdocs WHERE reqID = '". $_POST["InquiryID"] ."' AND documentid = '". $arr[$k] ."' AND proposalNum = '". $_POST['isProposal'] ."';";
				$res = mysql_query($sql, $connection);
				$Permit = mysql_fetch_array($res);
				$ReqNum = mysql_num_rows($res);

				$row = mysql_fetch_array(mysql_query("SELECT id, DESCRIPTION, override FROM tblref_typeofpermits WHERE id = '". $arr[$k] ."'", $connection));

				$linkimage = '../Mall_Attachments/Permits/'. $_POST["InquiryID"] .'/'. $row["DESCRIPTION"] .'/'. $Permit["filename"];
				if($Permit["filetype"] == "image/jpeg" || $Permit["filetype"] == "image/png" || $Permit["filetype"] == "image/jpg"){
					$view = "<button class='btn btn-xs btn-purple btn-round' style='padding:3px; margin-bottom:4px; display:inline;' onclick='viewdocuimgindex(\"". $linkimage ."\")' title='view image'><i class='ace-icon fa fa-picture-o bigger-120'></i></button>";
				}else{
					$view = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				}

				if($ReqNum == 0){
					$i++;
					$id = "posting_commentpermit_". $i;
					echo 	"<div class='row divPer". $arr[$k] ."'>
							 	<label class='col-xs-4'>". $row["DESCRIPTION"] ."</label>
							 	<div class='col-xs-1'>Exp. Date</div>
								<form name='posting_comment' class='form_lease_application_permit' id='posting_commentpermit_". $i ."'>
                              	<div class='col-xs-2'>
                              		<input type='text' name='expiry_date' class='date-picker form-control DisablePayInfo2 txtReservationReq2' value='". date('m/d/Y') ."'>
                              	</div>
							 	<div class='col-xs-1 center'>
							 		<i style='color:red;margin-top:5px;' class='ace-icon fa fa-remove bigger-120' id='". $id ."_icon'></i>
							 	</div>
								<div class='col-xs-3' style='white-space: nowrap;text-overflow: ellipsis;overflow: hidden;'>
		                            <input type='hidden' name='txtPermitInquiryID' class='txtPermitInquiryID' value='". $_POST['InquiryID'] ."'>
	                                <input type='hidden' name='txtPermitApplicationID' class='txtPermitInquiryID' value='". $_POST["InquiryID"] ."'>
	                                <input type='hidden' name='txtPermitProposalNum' class='txtPermitProposalNum' value='". $_POST["isProposal"] ."'>
	                                <input type='file' class='upload_app_permit id-input-file-2 DisablePayInfo2 txtReservationReq2' name='attachment_filess' id='overridepermit". $row['id'] ."' onchange='chkclippeddocx2($(this))'/>
	                                <input type='hidden' name='hiddenidss' value='". $row['id'] ."'>
	                            </div>
                              	</form>
                              	<div class='col-xs-1'><button class='btn btn-xs btn-danger btn-round' onclick='$(\".divPer". $arr[$k] ."\").remove();'><i class='fa fa-trash-o'></i></button></div>
                            </div>";
				}else{
					echo 	"<div class='row'>
							 	<label class='col-xs-4'>". $row['DESCRIPTION'] ."</label>
							 	<div class='col-xs-1'>Exp. Date</div>
                              	<div class='col-xs-2'>
                              		". date('m/d/Y', strtotime($Permit['expirydate'])) ."
                              	</div>
                              	<div class='col-xs-1 center'>
							 		<i style='color:green;' class='ace-icon fa fa-check bigger-120'></i>
							 	</div>
								<div class='col-xs-3' style='white-space: nowrap;text-overflow: ellipsis;overflow: hidden;'>
									<p class='req_nam_". $_POST['appid'] ." req_already_added_na2' id='". $Permit["filename"] ."' style='font-size:11px;font-weight:normal;font-style:italic;display:inline;'>&nbsp;&nbsp;". $Permit['filename'] ."</p>
								</div>
								<div class='col-xs-1'>
									<div class='btn-group'>
										<button class='btn btn-xs btn-info btn-round' style='margin-bottom:3px; display:inline;'><a href='../Mall_Attachments/Permits/". $_POST['appid'] ."/". $row['DESCRIPTION'] ."/". $Permit['filename'] ."' download><i style='color:white !important;' class='ace-icon fa fa-download bigger-120'></i></a></button>
										". $view ."
									</div>
								</div>
							</div>";
				}
			}
		break;

		case 'fncSavePayment':
			$MachineNo = mysql_fetch_array(mysql_query("SELECT Machine_No FROM tblsys_setup;", $connection));
			$PaymentType = mysql_fetch_array(mysql_query("SELECT PaymentTypeDesc, PaymentType FROM tblref_pospaymenttype WHERE PaymentTypeID = '". $_POST['PaymentTypeCode'] ."';", $connection));
			$res = mysql_query("INSERT INTO tbltransaction SET InquiryID = '". $_POST['InquiryID'] ."', xcode = '". $_POST['PaymentTypeCode'] ."', description = '". $PaymentType['PaymentTypeDesc'] ."', amount = '-". $_POST['Amount'] ."', qty = '1', paymentamount = '-". $_POST['Amount'] ."', balance = '-". $_POST['Amount'] ."', xdate = '". getsysdate() ."', reference = '". $_POST['Particulars'] ."', xdatetime = '". date('Y-m-d H:i:s') ."', paymenttype = '". $_POST['PaymentType'] ."', cardholder = '". $_POST['CardHolder'] ."', ccno = '". $_POST['CC'] ."', expdate = '". $_POST['ExpiryDate'] ."', checkno = '". $_POST['CheckNo'] ."', checkdate = '". $_POST['CheckDate'] ."', checkname = '". $_POST['CheckName'] ."', bankname = '". $_POST['CheckBank'] ."', cardtype = '". $_POST['CardType'] ."', authno = '". $_POST['Authentication'] ."', secno = '". $_POST['SecurityCode'] ."', orno = '". $_POST['orNo'] ."', totalamount = '-". $_POST['Amount'] ."', bnkfrom = '". $_POST['BankFrom'] ."', bnkto = '". $_POST['BankTo'] ."', accnofrom = '". $_POST['AccountFrom'] ."', accnoto = '". $_POST['AccountTo'] ."', xdescription = '". $_POST['Particulars'] ."', userid = '". $_SESSION['MMS-UserID'] ."', Machine_No = '". $MachineNo['Machine_No'] ."';", $connection);
			if($res == true){
				echo 1;
				// INSERT LOGS JONAS 10/4/2019 START
				$arrHeader = ["Inquiry ID", "Payment Type", "Amount", "OR Number", "Reference", "Card Holder", "Card Type", "Authentication", "Security Code", "CC", "Expiry Date", "Bank From", "Bank From Account Number", "Bank To", "Bank To Account Number", "Check Number", "Check Date", "Check Name", "Check Bank"];
				$arrValue = [$_POST['InquiryID'], $_POST['PaymentTypeCode'], $_POST['Amount'], $_POST['orNo'], $_POST['Particulars'], $_POST['CardHolder'], $_POST['CardType'], $_POST['Authentication'], $_POST['CC'], $_POST['SecurityCode'], $_POST['ExpiryDate'], $_POST['BankFrom'], $_POST['AccountFrom'], $_POST['BankTo'], $_POST['AccountTo'], $_POST['CheckNo'], $_POST['CheckDate'], $_POST['CheckName'], $_POST['CheckBank']];
				$tran_logs = create_logs_per_transaction("posted a payment.", "Reservation Module", createXinfo("INSERT", $arrHeader, "", $arrValue, "", "", ""), "" ,"INSERT", $_POST['InquiryID']);
				// INSERT LOGS JONAS 10/4/2019 END
			}else{
				echo 2;
			}
		break;

		case 'fncLoadPaymentList':
			$res = mysql_query("SELECT xdate, xdescription, orno, xcode, amount FROM tbltransaction WHERE InquiryID = '". $_POST['InquiryID'] ."';", $connection);
			while($row = mysql_fetch_array($res)){
			$PaymentType = mysql_fetch_array(mysql_query("SELECT PaymentTypeDesc FROM tblref_pospaymenttype WHERE PaymentTypeID = '". $row['xcode'] ."';", $connection));
				echo 	"<tr>
							<td>". date('m/d/Y', strtotime($row['xdate'])) ."</td>
							<td>". $PaymentType['PaymentTypeDesc'] ."</td>
							<td>". $row['xdescription'] ."</td>
							<td>". $row['orno'] ."</td>
							<td style='text-align: right;'>". str_replace("-", "", number_format($row['amount'], 2, '.', ',')) ."</td>
						</tr>";
			}
		break;

		case 'fncCreateContract':
			$ContractID = createidno("CONTRACT", "tblcontract", "ContractID");
			$InquiryInfo = mysql_fetch_array(mysql_query("SELECT datefrom, dateto FROM tbltrans_inquiry WHERE Inquiry_ID = '". $_POST['InquiryID'] ."';", $connection));
			$ProposalInfo = mysql_fetch_array(mysql_query("SELECT terms_condition, terms_condition_group, terms_condition_term, terms_condition_cond FROM tbltrans_proposal WHERE inquiryID = '". $_POST['InquiryID'] ."' AND ProposalNum = '". $_POST['ProposalNum'] ."';", $connection));
			$res = mysql_query("INSERT INTO tblcontract SET ContractID = '". $ContractID ."', MallID = '". $_SESSION['MMS-Designation'] ."', InquiryID = '". $_POST['InquiryID'] ."', TenantID = '', datefrom = '". date('Y-m-d', strtotime($InquiryInfo['datefrom'])) ."', dateto = '". date('Y-m-d', strtotime($InquiryInfo['dateto'])) ."', Group_Name = '". mysql_real_escape_string($ProposalInfo['terms_condition_group']) ."', Term_Name = '". mysql_real_escape_string($ProposalInfo['terms_condition_term']) ."', Conditions = '". mysql_real_escape_string($ProposalInfo['terms_condition_cond']) ."', ids = '". $ProposalInfo['terms_condition'] ."', ContractStat = 'Pending', appr_id1 = '". $_SESSION['MMS-UserID'] ."', appr_user1 = '". getusername() ."', appr_date1 = '". date('Y-m-d H:i:s') ."', date_created = '". date('Y-m-d') ."', created_by = '". $_SESSION['MMS-UserID'] ."', AmendStat = 'Not Posted', ProposalNum = '". $_POST['ProposalNum'] ."';", $connection);
			if($res == true){
				// $resUpdateInquiry = mysql_query("UPDATE tbltrans_inquiry SET contractID = '". $ContractID ."' WHERE Inquiry_ID = '". $_POST['InquiryID'] ."';", $connection);
				echo 1;
				// INSERT LOGS JONAS 10/4/2019 START
				$arrHeader = ["Inquiry ID", "Contract ID"];
				$arrValue = [$_POST['InquiryID'], $ContractID];
				$tran_logs = create_logs_per_transaction("created a contract.", "Reservation Module", createXinfo("INSERT", $arrHeader, "", $arrValue, "", "", ""), "" ,"INSERT", $_POST['InquiryID']);
				// INSERT LOGS JONAS 10/4/2019 END
			}else{
				echo 2;
			}
		break;

		case 'fncViewContractStat':
			$ContractInfo = mysql_fetch_array(mysql_query("SELECT appr_id1, appr_user1, appr_date1 FROM tblcontract WHERE ContractID = '". $_POST['ContractID'] ."';", $connection));
			echo 	"<div class='alert alert-warning'>
						<div class='row center'>
							<div class='col-md-12'>
								Contract Created by:
							</div>
							<div class='col-md-12 bolder'>
								". $ContractInfo['appr_user1'] ."
							</div>
							<div class='col-md-12'>
								Date Created:
							</div>
							<div class='col-md-12 bolder'>
								". date('m/d/Y h:i A', strtotime($ContractInfo['appr_date1'])) ."
							</div>
						</div>
					</div>";
		break;

		case 'fncChangeContractStat2':
			if($_POST['Status'] == 'Approved'){
				$resgetInquiry = mysql_fetch_array(mysql_query("SELECT Application_ID, Mall, Mall_ID, TradeID, Trade_Name, Company_ID, Company_Name, ClassID, DepartmentID, CategoryID, datefrom, dateto, billingtype, billingperc, desired_noofmonths, desired_noofyears, merchant_code, monthly_dues, assoc_dues, mallCompanyID, inqSource, inqPrcssOwnr, BillerID, ActiveProposal FROM tbltrans_inquiry WHERE Inquiry_ID = '". $_POST['InquiryID'] ."';", $connection));
				$TenantPrefix = mysql_fetch_array(mysql_query("SELECT TenantIDPref FROM tblref_mall WHERE mallid = '". $resgetInquiry['Mall_ID'] ."';", $connection));
				$TenantID = createidno_permall($TenantPrefix['TenantIDPref'], "tbltrans_tenants", "TenantID");
				$resInquiry = mysql_query("UPDATE tbltrans_inquiry SET Status = 'Confirmed', date_confirmed = '". date('Y-m-d H:i:s') ."', TenantID = '". $TenantID ."', contractID = '". $ContractID ."' WHERE Inquiry_ID = '". $_POST['InquiryID'] ."';", $connection);

				$resTenant = mysql_query("INSERT INTO tbltrans_tenants SET TenantID = '". $TenantID ."', mallID = '". $resgetInquiry['Mall_ID'] ."', owner_lastname = '". $resgetInquiry[''] ."', owner_firstname = '". $resgetInquiry[''] ."', owner_midname = '". $resgetInquiry[''] ."', appID = '". $resgetInquiry['Application_ID'] ."', inqID = '". $_POST['InquiryID'] ."', tradeID = '". $resgetInquiry['TradeID'] ."', tradename = '". $resgetInquiry['Trade_Name'] ."', CompanyID = '". $resgetInquiry['Company_ID'] ."', companyname = '". $resgetInquiry['Company_Name'] ."', datefrom = '". $resgetInquiry['datefrom'] ."', dateto = '". $resgetInquiry['dateto'] ."', Status = 'Active', noofyears = '". $resgetInquiry['desired_noofyears'] ."', noofmonths = '". $resgetInquiry['desired_noofmonths'] ."', ustatus = 'Unoccupied', tenanttype = '". $resgetInquiry['billingtype'] ."', revpercent = '". $resgetInquiry['billingperc'] ."', merchant_code = '". $resgetInquiry['merchant_code'] ."', ContractID = '". $ContractID ."', monthly_dues = '". $resgetInquiry['monthly_dues'] ."', assoc_dues = '". $resgetInquiry['assoc_dues'] ."', mallCompanyID = '". $resgetInquiry['mallCompanyID'] ."', ClassID = '". $resgetInquiry['ClassID'] ."', DepartmentID = '". $resgetInquiry['DepartmentID'] ."', CategoryID = '". $resgetInquiry['CategoryID'] ."', inqSource = '". $resgetInquiry['inqSource'] ."', inqPrcssOwnr = '". $resgetInquiry['inqPrcssOwnr'] ."', BillerID = '". $resgetInquiry['BillerID'] ."', ActiveProposal = '". $resgetInquiry['ActiveProposal'] ."';", $connection);
				$getUnits = mysql_query("SELECT UnitID FROM tbltrans_inquiry_unit WHERE InquiryID = '". $_POST['InquiryID'] ."';", $connection);
				while($rowUnits = mysql_fetch_array($getUnits)){
					$resUpdateUnit = mysql_query("UPDATE tblref_unit SET Status = 'Reserverd', TenantID = '". $TenantID ."', TenantName = '". $resgetInquiry['Trade_Name'] ."', startDate = '". date('Y-m-d', strtotime($resgetInquiry['datefrom'])) ."', endDate = '". date('Y-m-d', strtotime($resgetInquiry['dateto'])) ."' WHERE unitid = '". $rowUnits['UnitID'] ."';", $connection);

					$resUpdateUnitLogs = mysql_query("UPDATE tblunit_statuslogs SET status = 'Reserverd', tenantid = '". $TenantID ."', tenantname = '". $resgetInquiry['Trade_Name'] ."' WHERE unitid = '". $rowUnits['UnitID'] ."' AND xdate BETWEEN '". date('Y-m-d', strtotime($resgetInquiry['datefrom'])) ."' AND '". date('Y-m-d', strtotime($resgetInquiry['dateto'])) ."';", $connection);
				}

			}
			$resContact = mysql_query("UPDATE tblcontract SET ContractStat = '". $_POST['Status'] ."', appr_id2 = '". $_SESSION['MMS-UserID'] ."', appr_user2 = '". getusername() ."', appr_date2 = '". date('Y-m-d H:i:s') ."' WHERE ContractID = '". $_POST['ContractID'] ."' AND InquiryID = '". $_POST['InquiryID'] ."';", $connection);
			if($resContact == true){
				echo "1|".$TenantID;
				// INSERT LOGS JONAS 10/4/2019 START
				if($_POST['Status'] == 'Approved'){
					$Classification = mysql_fetch_array(mysql_query("SELECT classification FROM tblref_merchandise_class WHERE classificationID = '". $resgetInquiry['ClassID'] ."'", $connection));
					$Department = mysql_fetch_array(mysql_query("SELECT department FROM tblref_merchandise_depa WHERE departmentID = '". $resgetInquiry['DepartmentID'] ."'", $connection));
					$Category = mysql_fetch_array(mysql_query("SELECT category FROM tblref_merchandisedep_cat WHERE categoryID = '". $resgetInquiry['CategoryID'] ."'", $connection));
					$arrHeader = ["Inquiry ID", "Contract ID", "Tenant ID", "Mall ID", "Mall", "Application ID", "Trade ID", "Trade Name", "Company ID", "Company Name", "Start Date", "End Date", "Number of Years", "Number of Months", "Billing Type", "Billing Percentage", "Merchant Code", "Mall Company ID", "Classification", "Department", "Category", "Source", "Process Owner", "Biller ID"];
					$arrValue = [$_POST['InquiryID'], $ContractID, $TenantID, $resgetInquiry['Mall_ID'], $resgetInquiry['Mall'], $resgetInquiry['Application_ID'], $resgetInquiry['TradeID'], $resgetInquiry['Trade_Name'], $resgetInquiry['Company_ID'], $resgetInquiry['Company_Name'], date('m/d/Y', strtotime($resgetInquiry['datefrom'])), date('m/d/Y', strtotime($resgetInquiry['dateto'])), $resgetInquiry['desired_noofyears'], $resgetInquiry['desired_noofmonths'], $resgetInquiry['billingtype'], $resgetInquiry['billingperc'], $resgetInquiry['merchant_code'], $resgetInquiry['mallCompanyID'], $Classification['classification'], $Department['department'], $Category['category'], $resgetInquiry['inqSource'], $resgetInquiry['inqPrcssOwnr'], $resgetInquiry['BillerID']];
					$tran_logs = create_logs_per_transaction("confirmed a contract.", "Reservation Module", createXinfo("UPDATE", $arrHeader, "", $arrValue, "", "", ""), "" ,"UPDATE", $_POST['InquiryID']);
				}else{
					$arrHeader = ["Inquiry ID", "Contract ID"];
					$arrValue = [$_POST['InquiryID'], $ContractID];
					$tran_logs = create_logs_per_transaction("disapproved a contract.", "Reservation Module", createXinfo("UPDATE", $arrHeader, "", $arrValue, "", "", ""), "" ,"UPDATE", $_POST['InquiryID']);
				}
				// INSERT LOGS JONAS 10/4/2019 END
			}else{
				echo "2|";
			}
		break;

		case 'fncOccupyUnit2':
			$resUpdateInquiry = mysql_query("UPDATE tbltrans_inquiry SET Status = 'Occupied' WHERE Inquiry_ID = '". $_POST['InquiryID'] ."';", $connection);
			$resUpdateTenant = mysql_query("UPDATE tbltrans_tenants SET ustatus = 'Occupied' WHERE TenantID = '". $_POST['TenantID'] ."';", $connection);
			$resUpdatePayments = mysql_query("UPDATE tbltransaction SET tenantid = '". $_POST['TenantID'] ."' WHERE InquiryID = '". $_POST['InquiryID'] ."';", $connection);
			$TenantInfo = mysql_fetch_array(mysql_query("SELECT tradename, datefrom, dateto FROM tbltrans_tenants WHERE TenantID = '". $_POST['TenantID'] ."';", $connection));
			$getUnits = mysql_query("SELECT UnitID FROM tbltrans_inquiry_unit WHERE InquiryID = '". $_POST['InquiryID'] ."';", $connection);
			while($rowUnits = mysql_fetch_array($getUnits)){
				$resUpdateUnit = mysql_query("UPDATE tblref_unit SET Status = 'Occupied', TenantID = '". $_POST['TenantID'] ."', TenantName = '". $TenantInfo['tradename'] ."', startDate = '". $TenantInfo['datefrom'] ."', endDate = '". $TenantInfo['dateto'] ."' WHERE unitid = '". $rowUnits['UnitID'] ."';", $connection);

				$resUpdateUnitLogs = mysql_query("UPDATE tblunit_statuslogs SET status = 'Occupied', tenantid = '". $_POST['TenantID'] ."', tenantname = '". $TenantInfo['tradename'] ."', inquiryid = '". $_POST['InquiryID'] ."' WHERE unitid = '". $rowUnits['UnitID'] ."' AND xdate BETWEEN '". date('Y-m-d', strtotime($TenantInfo['datefrom'])) ."' AND '". date('Y-m-d', strtotime($TenantInfo['dateto'])) ."';", $connection);

			}
			// INSERT LOGS JONAS 10/4/2019 START
			$arrHeader = ["Inquiry ID", "Tenant ID"];
			$arrValue = [$_POST['InquiryID'], $_POST['TenantID']];
			$tran_logs = create_logs_per_transaction("initiated tenant occupancy.", "Reservation Module", createXinfo("UPDATE", $arrHeader, "", $arrValue, "", "", ""), "" ,"UPDATE", $_POST['InquiryID']);
			// INSERT LOGS JONAS 10/4/2019 END
			if($resUpdateInquiry == true && $resUpdateTenant == true){
				echo 1;
			}else{
				echo 2;
			}
		break;

		case 'fncCancelApplication2':
			$resUpdateInquiry = mysql_query("UPDATE tbltrans_inquiry SET Status = 'Cancelled' WHERE Inquiry_ID = '". $_POST['InquiryID'] ."';", $connection);
			// INSERT LOGS JONAS 10/4/2019 START
			$arrHeader = ["Inquiry ID", "Tenant ID"];
			$arrValue = [$_POST['InquiryID'], $_POST['TenantID']];
			$tran_logs = create_logs_per_transaction("cancelled an application.", "Leasing Module", createXinfo("UPDATE", $arrHeader, "", $arrValue, "", "", ""), "" ,"UPDATE", $_POST['InquiryID']);
			// INSERT LOGS JONAS 10/4/2019 END
			if( $resUpdateInquiry == true){
				echo 1;
			}else{
				echo 2;
			}
		break;

		case 'getLayoutList':
			$inquirysel =  mysql_fetch_array(mysql_query("SELECT TradeID, Company_ID FROM tbltrans_inquiry WHERE Inquiry_ID = '".$_POST['InquiryID']."' ",$connection));
			$resContractLayout = mysql_query("SELECT LCode FROM tblref_contract WHERE LType = '". $_POST['ReportType'] ."';", $connection);
			while ($rowContractLayout = mysql_fetch_array($resContractLayout)) {
				echo "<p class='alert alert-info' style='cursor:pointer' onclick='fncPreviewProposal(\"". $_POST['InquiryID'] ."\",\"". $inquirysel['TradeID'] ."\",\"". $inquirysel['Company_ID'] ."\",\"". $_POST['ProposalNum'] ."\", \"". $rowContractLayout['LCode'] ."\", \"". $_POST['ReportType'] ."\", \"". $_POST['ContractID'] ."\");'>". $rowContractLayout['LCode'] ."</p>";
			}
		break;

		case 'fncPreviewProposal':
            $ContractLayout = mysql_fetch_array(mysql_query("SELECT LContent FROM tblref_contract WHERE LType = '". $_POST['DocType'] ."' AND LCode = '". $_POST['LCode'] ."';", $connection));
            
            $InquiryInfo = mysql_fetch_array(mysql_query("SELECT billingtype, billingperc, desired_noofmonths, desired_noofyears, datefrom, Mall, Mall_ID, dateto, BillerID, 1st_app_aw, 1st_date_aw, 2nd_app_aw, 2nd_date_aw, date_applied, userid_aw, ClassID, DepartmentID, CategoryID FROM tbltrans_inquiry WHERE Inquiry_ID = '". $_POST['InquiryID'] ."';", $connection));

            $ProposalInfo = mysql_fetch_array(mysql_query("SELECT escalation_rate, year_start, year_basis, construction_deposit, construction_deposit_terms, security_deposit, security_deposit_terms, advance_terms, advance_payment, userid, datefrom, dateto, desiredYear, desiredMonths, desiredDays, 1st_app, 1st_date, charges_list, datecreated, monthlyDues, billingtype, billingperc, unitArea, isRent, date_approved, rent_free_construction_start_date, exhibit_bond, exhibit_terms FROM tbltrans_proposal WHERE InquiryID = '". $_POST['InquiryID'] ."' AND proposalNum = '". $_POST['ProposalNum'] ."';", $connection));

            $ContractInfo = mysql_fetch_array(mysql_query("SELECT 1st_app, 1st_date, 2nd_app, 2nd_date, 3rd_app, 3rd_date FROM tblcontract WHERE ContractID = '". $_POST['ContractID'] ."';", $connection));

            $TradeInfo = mysql_fetch_array(mysql_query("SELECT tradename FROM tbltrans_tradename WHERE tradeID = '". $_POST['TradeID'] ."';", $connection));

            $CompanyInfo = mysql_fetch_array(mysql_query("SELECT company, industry, businessAddress FROM tbltrans_company WHERE CompanyID = '". $_POST['CompanyID'] ."';", $connection));

            $Industry = mysql_fetch_array(mysql_query("SELECT Industry FROM tblref_industry WHERE Industry_ID = '". $CompanyInfo['industry'] ."';", $connection));

            $getTradePrimaryContact = mysql_fetch_array(mysql_query("SELECT LastName, Designation FROM tbltrans_trade_contact_person WHERE TradeID = '". $_POST['TradeID'] ."';", $connection));

            $MallName = mysql_fetch_array(mysql_query("SELECT mallname, malladdress, telephone_number, corp_ID FROM tblref_mall WHERE mallid = '". $InquiryInfo['Mall_ID'] ."';", $connection));

            $MallCompany = mysql_fetch_array(mysql_query("SELECT MallCompanyName FROM tblref_mallcompany WHERE MallCompanyID = '". $MallName['corp_ID'] ."';", $connection));

            $Classification = mysql_fetch_array(mysql_query("SELECT classification FROM tblref_merchandise_class WHERE classificationID = '". $InquiryInfo['ClassID'] ."';", $connection));

            $Department = mysql_fetch_array(mysql_query("SELECT department FROM tblref_merchandise_depa WHERE departmentID = '". $InquiryInfo['DepartmentID'] ."';", $connection));

            $Category = mysql_fetch_array(mysql_query("SELECT category FROM tblref_merchandisedep_cat WHERE categoryID = '". $InquiryInfo['CategoryID'] ."';", $connection));

            $ProCreatedby = mysql_fetch_array(mysql_query("SELECT CONCAT(a.firstname, ' ', a.lastname), a.emailaddress, a.contactnumber, b.groupname FROM tbluser AS a, tblref_groupaccess AS b WHERE a.groupaccess = b.groupid AND a.userid = '". $ProposalInfo['userid'] ."';", $connection));

            $ProApprovedby = mysql_fetch_array(mysql_query("SELECT CONCAT(a.firstname, ' ', a.lastname), a.emailaddress, a.contactnumber, b.groupname FROM tbluser AS a, tblref_groupaccess AS b WHERE a.groupaccess = b.groupid AND a.userid = '". $ProposalInfo['1st_app'] ."';", $connection));

            $AwNFirstApprover = mysql_fetch_array(mysql_query("SELECT CONCAT(a.firstname, ' ', a.lastname), a.emailaddress, a.contactnumber, b.groupname FROM tbluser AS a, tblref_groupaccess AS b WHERE a.groupaccess = b.groupid AND a.userid = '". $InquiryInfo['1st_app_aw'] ."';", $connection));

            $AwNSecondApprover = mysql_fetch_array(mysql_query("SELECT CONCAT(a.firstname, ' ', a.lastname), a.emailaddress, a.contactnumber, b.groupname FROM tbluser AS a, tblref_groupaccess AS b WHERE a.groupaccess = b.groupid AND a.userid = '". $InquiryInfo['2nd_app_aw'] ."';", $connection));

            $ContractFirstApprover = mysql_fetch_array(mysql_query("SELECT CONCAT(a.firstname, ' ', a.lastname), a.emailaddress, a.contactnumber, b.groupname FROM tbluser AS a, tblref_groupaccess AS b WHERE a.groupaccess = b.groupid AND a.userid = '". $ContractInfo['1st_app'] ."';", $connection));

            $ContractSecondApprover = mysql_fetch_array(mysql_query("SELECT CONCAT(a.firstname, ' ', a.lastname), a.emailaddress, a.contactnumber, b.groupname FROM tbluser AS a, tblref_groupaccess AS b WHERE a.groupaccess = b.groupid AND a.userid = '". $ContractInfo['2nd_app'] ."';", $connection));

            $ContractThirdApprover = mysql_fetch_array(mysql_query("SELECT CONCAT(a.firstname, ' ', a.lastname), a.emailaddress, a.contactnumber, b.groupname FROM tbluser AS a, tblref_groupaccess AS b WHERE a.groupaccess = b.groupid AND a.userid = '". $ContractInfo['3rd_app'] ."';", $connection));

            $AwNNotificationSender = mysql_fetch_array(mysql_query("SELECT CONCAT(a.firstname, ' ', a.lastname), a.emailaddress, a.contactnumber, b.groupname FROM tbluser AS a, tblref_groupaccess AS b WHERE a.groupaccess = b.groupid AND a.userid = '". $InquiryInfo['userid_aw'] ."';", $connection));

   //          $getCUSA = "";
   //          $arrCUSA = array('CUS1', 'CUS2');
			// $arr = explode("|", $ProposalInfo['charges_list']);
			// for ($i=0; $i <= count($arr)-2; $i++) { 
			// 	if(in_array($arr[$i], $arrCUSA)){
			// 		$getCUSA = $arr[$i];
			// 	}
			// }

			// $getACU = "";
   //          $arrACU = array('ACU1', 'ACU2');
			// $arr = explode("|", $ProposalInfo['charges_list']);
			// for ($i=0; $i <= count($arr)-2; $i++) { 
			// 	if(in_array($arr[$i], $arrACU)){
			// 		$getACU = $arr[$i];
			// 	}
			// }

            $getCUSA2 = mysql_fetch_array(mysql_query("SELECT ChargeAmount, ChargeType FROM tbltrans_procharges WHERE ChargeCode IN('CUS1', 'CUS2') AND InquiryID = '". $_POST['InquiryID'] ."' AND proposalNum = '". $_POST['ProposalNum'] ."';", $connection));

            if($getCUSA2['ChargeType'] == "Persqm"){
            	$CUSARateType = "per sqm";
            }else{
            	$CUSARateType = $getCUSA2['ChargeType'];
            }

            $getACU2 = mysql_fetch_array(mysql_query("SELECT ChargeAmount, ChargeType FROM tbltrans_procharges WHERE ChargeCode IN ('ACU1', 'ACU2') AND InquiryID = '". $_POST['InquiryID'] ."' AND proposalNum = '". $_POST['ProposalNum'] ."';", $connection));

            if($getACU2['ChargeType'] == "Persqm"){
            	$ACURateType = "per sqm";
            }else{
            	$ACURateType = $getACU2['ChargeType'];
            }

           	$StackedEscaRate = 0;
            $Count = 2;
            $EscalatedRate = 0;
            $LastEscalation = "";
            $Escalation = "<table align='center' cellspacing='0' style='width: 600px; border: 1px solid black;; border-collapse: collapse;'>
            					<tr>
            						<td style='border-right: 1px solid black;padding: 5px;width: 35%;text-align: center;font-size: 7pt;font-family: Arial;'>AGREED RENTAL SCHEME</td>
            						<td style='width: 65%;'></td
            					</tr>";
            					if($ProposalInfo['billingtype'] == "Share Only"){
									$Escalation .= 	"<tr>
							            				<td style='border-right: 1px solid black;padding-bottom: 10px;text-align: center;font-size: 7pt;font-family: Arial;'>Year 1</td>
							            				<td style='padding-bottom: 10px;text-align: center;font-size: 7pt;font-family: Arial;'>". floatval($ProposalInfo['escalation_rate']) ."% of Total Gross Sales + 12% VAT</td>
							            			</tr>";
            					}else if($ProposalInfo['billingtype'] == "Share Only2"){
									$Escalation .= 	"<tr>
							            				<td style='border-right: 1px solid black;padding-bottom: 10px;text-align: center;font-size: 7pt;font-family: Arial;'>Year 1</td>
							            				<td style='padding-bottom: 10px;text-align: center;font-size: 7pt;font-family: Arial;'>". floatval($ProposalInfo['escalation_rate']) ."% of Total Net Sales + 12% VAT</td>
							            			</tr>";
            					}else{
            						$Escalation .= 	"<tr>
							            				<td style='border-right: 1px solid black;padding-bottom: 10px;text-align: center;font-size: 7pt;font-family: Arial;'>Year 1</td>
							            				<td style='padding-bottom: 10px;text-align: center;font-size: 7pt;font-family: Arial;'>". number_format(floatval($ProposalInfo['monthlyDues']), 2, '.', ',') ." + 12% VAT</td>
							            			</tr>";
            					}
            $resEscalation = mysql_query("SELECT a.EscaRate, a.EscaYear, b.billingtype, b.billingperc, b.monthlyDues, b.datefrom FROM tbltrans_escalation AS a LEFT JOIN tbltrans_proposal AS b ON a.inquiryID = b.InquiryID AND a.proposalNum = b.ProposalNum WHERE a.InquiryID = '". $_POST['InquiryID'] ."' AND a.ProposalNum = '". $_POST['ProposalNum'] ."';", $connection);
            while($rowEscalation = mysql_fetch_array($resEscalation)){
            	if($Count == 2){
            		// $YearStart = date('Y', strtotime($rowEscalation['datefrom'])) ." - ". explode(" ",$rowEscalation['EscaYear'])[1];
            		// $LastEscalation = explode(" ", $rowEscalation['EscaYear'])[1];
            		$EscalatedRate = floatval($rowEscalation['monthlyDues']);
            	}else{
            		// $YearStart = $LastEscalation ." - ". explode(" ",$rowEscalation['EscaYear'])[1];
            		// $LastEscalation = explode(" ", $rowEscalation['EscaYear'])[1];
            		$EscalatedRate = $EscalatedRate;
            	}
            	if($rowEscalation['billingtype'] == "Share Only"){
            		$Escalation .= 	"<tr>
			            				<td style='border-right: 1px solid black;padding-bottom: 10px;text-align: center;font-size: 7pt;font-family: Arial;'>Year ". $Count ."</td>
			            				<td style='padding-bottom: 10px;text-align: center;font-size: 7pt;font-family: Arial;'>". floatval($rowEscalation['EscaRate']) ."% of Total Gross Sales + 12% VAT</td>
			            			</tr>";
            	}if($rowEscalation['billingtype'] == "Share Only2"){
            		$Escalation .= 	"<tr>
			            				<td style='border-right: 1px solid black;padding-bottom: 10px;text-align: center;font-size: 7pt;font-family: Arial;'>Year ". $Count ."</td>
			            				<td style='padding-bottom: 10px;text-align: center;font-size: 7pt;font-family: Arial;'>". floatval($rowEscalation['EscaRate']) ."% of Total Net Sales + 12% VAT</td>
			            			</tr>";
            	}else{
            		$Esca = $EscalatedRate * floatval($rowEscalation['EscaRate'] / 100);
            		$Escalated = $EscalatedRate + $Esca;
            		$Escalation .= 	"<tr>
			            				<td style='border-right: 1px solid black;padding-bottom: 10px;text-align: center;font-size: 7pt;font-family: Arial;'>Year ". $Count ."</td>
			            				<td style='padding-bottom: 10px;text-align: center;font-size: 7pt;font-family: Arial;'>". number_format(floatval($Escalated), 2, '.', ',') ." + 12% VAT</td>
			            			</tr>";
            	}
        		$EscalatedRate = floatval($Escalated);
            	$Count++;
            }
            $Escalation .= 		"<tr>
            						<td style='border-right: 1px solid black;padding: 5px;text-align: center;font-size: 7pt;font-family: Arial;'></td>
		            				<td style='padding-bottom: 10px;text-align: center;font-size: 7pt;font-family: Arial;font-style: italic;'>*". $ProposalInfo['escalation_rate'] ."% escalation applicable on the second year and every year thereafter</td>
            					</tr>	
            				</table>";

            $BillContactMain = mysql_fetch_array(mysql_query("SELECT CONCAT(Confname, ' ', Conlname), designation, Confname, Conlname, Conmname FROM tbltrans_company_contact_person WHERE ConID = '". $InquiryInfo['BillerID'] ."' AND isPrimary = '1' AND isActive = '1';", $connection));

            $UnitList = "";
            $resUnit = mysql_query("SELECT UnitID FROM tbltrans_proposal_unit WHERE InquiryID = '". $_POST['InquiryID'] ."' AND ProposalNum = '". $_POST['ProposalNum'] ."';", $connection);
            $UnitCount = mysql_num_rows($resUnit);
            if($UnitCount == 1){
            	$rowUnit = mysql_fetch_array($resUnit);
            	$UnitName = mysql_fetch_array(mysql_query("SELECT unitname, area, totalamountunitsetup FROM tblref_unit WHERE unitid = '". $rowUnit['UnitID'] ."';", $connection));
            	$UnitList .= $UnitName['unitname'];
            }else{
            	$Count = 1;
				while($rowUnit = mysql_fetch_array($resUnit)){
	            	$UnitName = mysql_fetch_array(mysql_query("SELECT unitname, area, totalamountunitsetup FROM tblref_unit WHERE unitid = '". $rowUnit['UnitID'] ."';", $connection));
	            	if($Count == $UnitCount){
	            		$UnitList .= $UnitName['unitname'];
	            	}else{
	            		$UnitList .= $UnitName['unitname'] .", ";
	            	}
	            	$Count++;
	            }
            }

            if($ProposalInfo['desiredYear'] >= 1){
            	$YearTerm = $ProposalInfo['desiredYear'] ." Year(s)";
            }else{
            	$YearTerm = "";
            }

            if($ProposalInfo['desiredMonths'] >= 1){
            	$MonthTerm = $ProposalInfo['desiredMonths'] ." Month(s)";
            }else{
            	$MonthTerm = "";
            }

            if($ProposalInfo['desiredDays'] >= 1){
            	$DayTerm = $ProposalInfo['desiredDays'] ." Day(s)";
            }else{
            	$DayTerm = "";
            }

        	$LeaseTerm = $YearTerm ." ". $MonthTerm ." ". $DayTerm;

        	 if($ProposalInfo['billingtype'] == 'Rent'){
                $RentalScheme = "Basic Rent/SQM";
            }else if($ProposalInfo['billingtype'] == 'Fixed Rent'){
                $RentalScheme = "Fixed Rent";
            }else if($ProposalInfo['billingtype'] == 'Share Only'){
                $RentalScheme = $ProposalInfo['billingperc'] ." % of Gross Sales";
            }else if($ProposalInfo['billingtype'] == 'Share Only2'){
                $RentalScheme = $ProposalInfo['billingperc'] ." % of Net Sales";
            }else if($ProposalInfo['billingtype'] == 'Rent Rev'){
                $RentalScheme = "Basic Rent/SQM + ". $ProposalInfo['billingperc'] ." % on GS";
            }else if($ProposalInfo['billingtype'] == 'Rent or Share'){
                $RentalScheme = "Basic Rent/SQM or ". $ProposalInfo['billingperc'] ." % on GS";
            }else{
                $RentalScheme = "Basic Rent/SQM";
            }

            $header = explode("|", getrentvattype($InquiryInfo['Mall_ID']));
			$isVatable = $header[1];
			$isInclusive = $header[2];
			$VATPercent = floatval($header[0]) / 100;
            if($ProposalInfo['isRent'] == 0){
				if($isVatable == "yes"){
                    if($isInclusive == "inc"){ //VAT IS INCLUSIVE
                        $VATAmount = ( floatval($ProposalInfo['monthlyDues']) / 1.12 ) * $VATPercent;
                        $RentLessVAT = floatval($ProposalInfo['monthlyDues']) - $VATAmount;
                        $Rent = $RentLessVAT;
						$VAT = $VATAmount;
                        $TotalRent = $VAT + $Rent;
                        $Adjustment = 0;
                    }else{ //VAT IS EXCLUSIVE
                        $VATAmount = floatval($ProposalInfo['monthlyDues']) * $VATPercent;
                        $RentPlusVAT = floatval($ProposalInfo['monthlyDues']);
                        $Rent = floatval($ProposalInfo['monthlyDues']);
                        $VAT = $VATAmount;
                        $TotalRent = floatval($ProposalInfo['monthlyDues']) + $VATAmount;
                        $Adjustment = 0;
                    }
                }else{
                    $Rent = $ProposalInfo['monthlyDues'];
                    $VAT = "0.00";
                    $TotalRent = floatval($ProposalInfo['monthlyDues']);
                    $Adjustment = 0;
                }
            }else{
            	$Rent = $ProposalInfo['monthlyDues'];
                $VAT = "0.00";
                $TotalRent = floatval($ProposalInfo['monthlyDues']);
                $Adjustment = 0;
            }

			$Replace1 = str_replace("|TradeName|", $TradeInfo['tradename'], $ContractLayout['LContent']);
			$Replace2 = str_replace("|CompanyName|", $CompanyInfo['company'], $Replace1);
			$Replace3 = str_replace("|CompanyAddress|", $CompanyInfo['businessAddress'], $Replace2);
			$Replace4 = str_replace("|Industry|", $Industry['Industry'], $Replace3);
			$Replace5 = str_replace("|UnitList|", $UnitList, $Replace4);
			$Replace6 = str_replace("|UnitListArea|", number_format(floatval($ProposalInfo['unitArea']), 2, '.', ',') ." SQM", $Replace5);
			$Replace7 = str_replace("|MonthlyRent|", number_format(floatval($ProposalInfo['monthlyDues']), 2, '.', ','), $Replace6);
			$Replace8 = str_replace("|LeaseTerm|", $LeaseTerm, $Replace7);
			$Replace9 = str_replace("|LeaseStartDate|", date('F d, Y', strtotime($ProposalInfo['datefrom'])), $Replace8);
			$Replace10 = str_replace("|CurrentDate|", date('F d, Y'), $Replace9);
			$Replace11 = str_replace("|TradePrimaryConName|", $getTradePrimaryContact['LastName'], $Replace10);
			$Replace12 = str_replace("|TradePrimaryConDesig|", $getTradePrimaryContact['Designation'], $Replace11);
			$Replace13 = str_replace("|MallName|", $MallName['mallname'], $Replace12);
			$Replace14 = str_replace("|MallAddress|", $MallName['malladdress'], $Replace13);
			$Replace15 = str_replace("|EscaRate|", $ProposalInfo['escalation_rate'], $Replace14);
			$Replace16 = str_replace("|ConDepAmount|", number_format(floatval($ProposalInfo['construction_deposit']), 2, '.', ','), $Replace15);
			$Replace17 = str_replace("|ConDepMonth|", $ProposalInfo['construction_deposit_terms'], $Replace16);
			$Replace18 = str_replace("|SecDepAmount|", number_format(floatval($ProposalInfo['security_deposit']), 2, '.', ','), $Replace17);
			$Replace19 = str_replace("|SecDepMonth|", $ProposalInfo['security_deposit_terms'], $Replace18);
			$Replace20 = str_replace("|AdvAmount|", number_format(floatval($ProposalInfo['advance_payment']), 2, '.', ','), $Replace19);
			$Replace21 = str_replace("|AdvMonth|", $ProposalInfo['advance_terms'], $Replace20);
			$Replace22 = str_replace("|ProposalPrepareBy|", $ProCreatedby[0], $Replace21);
			$Replace23 = str_replace("|ProposalPreparedByEmail|", $ProCreatedby['emailaddress'], $Replace22);
			$Replace24 = str_replace("|ProposalPreparedByMobile|", $ProCreatedby['contactnumber'], $Replace23);
			$Replace25 = str_replace("|LeaseTerminationDate|", date('F d, Y', strtotime($ProposalInfo['dateto'])), $Replace24);
			$Replace26 = str_replace("|getCUSA|", number_format(floatval($getCUSA2['ChargeAmount']), 2, '.', ',') . " " . $CUSARateType, $Replace25);
			$Replace27 = str_replace("|getACU|", number_format(floatval($getACU2['ChargeAmount']), 2, '.', ',') . " " . $ACURateType, $Replace26);
			$Replace28 = str_replace("|BillProContactName|", $BillContactMain[0], $Replace27);
			$Replace29 = str_replace("|BillProContactDesignation|", $BillContactMain[1], $Replace28);
			$Replace30 = str_replace("|ProposalFirstApprover|", $ProApprovedby[0], $Replace29);
			$Replace31 = str_replace("|ProposalFirstApprovalDate|", date('F d, Y', strtotime($ProposalInfo['1st_date'])), $Replace30);
			$Replace32 = str_replace("|ProposalPreparedByRole|", $ProCreatedby['groupname'], $Replace31);
			$Replace33 = str_replace("|ProposalFirstApproverRole|", $ProApprovedby['groupname'], $Replace32);
			$Replace34 = str_replace("|ProposalCreateDate|", date('F d, Y', strtotime($ProposalInfo['datecreated'])), $Replace33);
			$Replace35 = str_replace("|BillProContactFirstName|", $BillContactMain['Confname'], $Replace34);
			$Replace36 = str_replace("|BillProContactMiddleName|", $BillContactMain['Conmname'], $Replace35);
			$Replace37 = str_replace("|BillProContactLastName|", $BillContactMain['Conlname'], $Replace36);
			$Replace38 = str_replace("|MallTelephone|", $MallName['telephone_number'], $Replace37);
			$Replace39 = str_replace("|MonthlyRentVAT|", number_format(floatval($TotalRent), 2, '.', ','), $Replace38);
			$Replace40 = str_replace("|RentalScheme|", strtoupper($RentalScheme), $Replace39);
			$Replace41 = str_replace("|AwardNoticeSentDate|", date('F d, Y', strtotime($InquiryInfo['date_applied'])), $Replace40);
			$Replace42 = str_replace("|TurnOverDate|", date('F d, Y', strtotime($ProposalInfo['rent_free_construction_start_date'])), $Replace41);
			$Replace43 = str_replace("|TotalConBondAmount|", number_format(floatval($ProposalInfo['construction_deposit']), 2, '.', ','), $Replace42);
			$Replace44 = str_replace("|TotalConBondWords|", ucwords(numberTowords(floatval($ProposalInfo['construction_deposit_terms']))), $Replace43);
			$Replace45 = str_replace("|TotalSecDepAmount|", number_format(floatval($ProposalInfo['security_deposit']), 2, '.', ','), $Replace44);
			$Replace46 = str_replace("|TotalSecDepWords|", ucwords(numberTowords(floatval($ProposalInfo['security_deposit']))), $Replace45);
			$Replace47 = str_replace("|TotalAdvAmount|", number_format(floatval($ProposalInfo['advance_payment']), 2, '.', ','), $Replace46);
			$Replace48 = str_replace("|TotalAdvWords|", ucwords(numberTowords(floatval($ProposalInfo['advance_payment']))), $Replace47);
			$Replace49 = str_replace("|AwardFirstApprover|", $AwNFirstApprover[0], $Replace48);
			$Replace50 = str_replace("|AwardFirstApprovalDate|", date('F d, Y', strtotime($InquiryInfo['1st_date_aw'])), $Replace49);
			$Replace51 = str_replace("|AwardSecondApprover|", $AwNSecondApprover[0], $Replace50);
			$Replace52 = str_replace("|AwardSecondApprovalDate|", date('F d, Y', strtotime($InquiryInfo['2nd_date_aw'])), $Replace51);
			$Replace53 = str_replace("|MallCompanyName|", $MallCompany['MallCompanyName'], $Replace52);
			$Replace54 = str_replace("|ContractSeriesNo|", $_POST['ContractID'], $Replace53);
			$Replace55 = str_replace("|ExhBondMonth|", $ProposalInfo['exhibit_bond'], $Replace54);
			$Replace56 = str_replace("|ExhBondAmount|", number_format(floatval($ProposalInfo['exhibit_terms']), 2, '.', ','), $Replace55);
			$Replace57 = str_replace("|ConDepMonthinWords|", ucwords(numberTowords($ProposalInfo['construction_deposit_terms'])), $Replace56);
			$Replace58 = str_replace("|SecDepMonthinWords|", ucwords(numberTowords($ProposalInfo['security_deposit_terms'])), $Replace57);
			$Replace59 = str_replace("|AdvMonthinWords|", ucwords(numberTowords($ProposalInfo['advance_terms'])), $Replace58);
			$Replace60 = str_replace("|ExhBondMonthinWords|", ucwords(numberTowords($ProposalInfo['exhibit_bond'])), $Replace59);
			$Replace61 = str_replace("|ContractFirstApprover|", $ContractFirstApprover[0], $Replace60);
			$Replace62 = str_replace("|ContractFirstApproverDate|", date('F d, Y', strtotime($ContractInfo['1st_date'])), $Replace61);
			$Replace63 = str_replace("|ContractSecondApprover|", $ContractSecondApprover[0], $Replace62);
			$Replace64 = str_replace("|ContractSecondApproverDate|", date('F d, Y', strtotime($ContractInfo['2nd_date'])), $Replace63);
			$Replace65 = str_replace("|ContractThirdApprover|", $ContractThirdApprover[0], $Replace64);
			$Replace66 = str_replace("|ContractThirdApproverDate|", date('F d, Y', strtotime($ContractInfo['3rd_date'])), $Replace65);
			$Replace67 = str_replace("|EscalationSetup|", $Escalation, $Replace66);
			$Replace68 = str_replace("|AwardFirstApproverRole|", $AwNFirstApprover['groupname'], $Replace67);
			$Replace69 = str_replace("|AwardSecondApproverRole|", $AwNSecondApprover['groupname'], $Replace68);
			$Replace70 = str_replace("|ContractFirstApproverRole|", $ContractFirstApprover['groupname'], $Replace69);
			$Replace71 = str_replace("|ContractSecondApproverRole|", $ContractSecondApprover['groupname'], $Replace70);
			$Replace72 = str_replace("|ContractThirdApproverRole|", $ContractThirdApprover['groupname'], $Replace71);
			$Replace73 = str_replace("|AwardSenderName|", $AwNNotificationSender[0], $Replace72);
			$Replace74 = str_replace("|AwardSenderRole|", $AwNNotificationSender['groupname'], $Replace73);
			$Replace75 = str_replace("|Classification|", $Classification['classification'], $Replace74);
			$Replace76 = str_replace("|Department|", $Department['department'], $Replace75);
			$Replace77 = str_replace("|Category|", $Category['category'], $Replace76);

			echo $Replace77;
		break;

		case 'fncgetEscalationSched':
			$StartYear = date('Y', strtotime($_POST['DateFrom']));
			$EndYear = date('Y', strtotime($_POST['DateTo']));
			$YearStart = floatval($StartYear + $_POST['EscaStart']);

			$DateFrom = $_POST['DateFrom'];
			$DateTo = $_POST['DateTo'];
			$Diff = abs(strtotime($DateTo) - strtotime($DateFrom));
			$inYear = floor($Diff / ( 365 * 60 * 60 * 24));
			$inMonths = floor(($Diff - $inYear * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));

			if($inYear >= 1){
				for ($i = $YearStart; $i <= $EndYear; $i+=$_POST['YearBasis']) { 
					echo 	"<tr>
								<td style='text-align: center; vertical-align: middle;'>". date('F', strtotime($_POST['DateFrom'])) ." ". $i ."</td>
								<td style='text-align: center; vertical-align: middle;z-index: 0;'>
									<span class='input-icon input-icon-right'>
			                            <input type='text' class='form-control txtEscalation' style='background-color: white !important; border-color: rgb(213, 213, 213);background: transparent !important; border: 0px;text-align: center;' onkeypress='return isNumberKey(event);' onchange='fncgetPaymentSchedule();' onkeyup='fncgetPaymentSchedule();' value='". $_POST['EscaRate'] ."'>
			                            <i class='ace-icon fa fa-percent' style='z-index: 0;'></i>
			                        </span>
								</td>
							</tr>";
				}
			}
		break;

		case 'getFixedAdvVAT':
			$header = explode("|", getrentvattype($_SESSION['MMS-Designation']));
			$isVatable = $header[1];
			$isInclusive = $header[2];
			$VATPercent = floatval($header[0]) / 100;
			if($_POST['VATSetup'] == 0){
				if($isVatable == "yes"){
                    if($isInclusive == "inc"){ //VAT IS INCLUSIVE
                        $VATAmount = ( floatval($_POST['Total']) / 1.12 ) * $VATPercent;
                        $RentLessVAT = floatval($_POST['Total']) - $VATAmount;
                        $Rent = $RentLessVAT;
						$VAT = $VATAmount;
                        $TotalAmount = $VAT + $Rent;
                        $Adjustment = 0;
                    }else{ //VAT IS EXCLUSIVE
                        $VATAmount = floatval($_POST['Total']) * $VATPercent;
                        $RentPlusVAT = floatval($_POST['Total']);
                        $Rent = floatval($_POST['Total']);
                        $VAT = $VATAmount;
                        $TotalAmount = floatval($_POST['Total']) + $VATAmount;
                        $Adjustment = 0;
                    }
                }else{
                    $Rent = $_POST['Total'];
                    $VAT = "0.00";
                    $TotalAmount = floatval($_POST['Total']);
                    $Adjustment = 0;
                }
            }else{
            	$Rent = $_POST['Total'];
                $VAT = "0.00";
                $TotalAmount = floatval($_POST['Total']);
                $Adjustment = 0;
            }

            // if($_POST['AdvMonth'] == 0 || $_POST['AdvMonth'] == ''){
            // 	echo number_format($TotalAmount, 2, '.', ',');
            // }else{
            	echo number_format($TotalAmount * $_POST['AdvMonth'], 2, '.', ',');
            // }

		break;
	}
?>