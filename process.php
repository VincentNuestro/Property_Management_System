<?php
	session_start();
	include("connect.php");
	// $res1 = mysql_query("SELECT app_by, Inquiry_ID FROM tbltrans_inquiry;", $connection);
	// while($row1 = mysql_fetch_array($res1)){
	// 	$row2 = mysql_fetch_array(mysql_query("SELECT userid FROM tbluser WHERE CONCAT(lastname, ', ', firstname, ' ', middlename) = '". $row1['app_by'] ."';", $connection));
	// 	$UpdateAwardSender = mysql_query("UPDATE tbltrans_inquiry SET userid_aw = '". $row2[0] ."' WHERE Inquiry_ID = '". $row1['Inquiry_ID'] ."';", $connection);
	// }

	// $res3 = mysql_query("SELECT billingtype, billingperc, Inquiry_ID FROM tbltrans_inquiry;", $connection);
	// while($row3 = mysql_fetch_array($res3)){
	// 	$UpdateProposal = mysql_query("UPDATE tbltrans_proposal SET billingtype = '". $row3['billingtype'] ."', billingperc = '". $row3['billingperc'] ."' WHERE inquiryID = '". $row3['Inquiry_ID'] ."';", $connection);
	// }

	// $res4 = mysql_query("SELECT 1st_app, ContractID FROM tblcontract;", $connection);
	// while($row4 = mysql_fetch_array($res4)){
	// 	$res5 = mysql_query("UPDATE tblcontract SET 2nd_app = '". $row4['1st_app'] ."', 3rd_app = '". $row4['1st_app'] ."' WHERE ContractID = '". $row4['ContractID'] ."';", $connection);
	// }

	// $res5 = mysql_query("TRUNCATE TABLE tblunit_statuslogs;", $connection);
	// $res6 = mysql_query("UPDATE tblref_unit SET TenantID = NULL, TenantName = NULL, StartDate = NULL, EndDate = NULL, status = 'Vacant';", $connection);
	// $res7 = mysql_query("TRUNCATE TABLE tbltrans_inquiry_unit;", $connection);
	// $res8 = mysql_query("SELECT c.Inquiry_ID, b.UnitID, a.ProposalNum, c.Status, c.datefrom, c.dateto, c.Trade_Name, c.TenantID FROM tbltrans_proposal AS a LEFT JOIN tbltrans_proposal_unit AS b ON a.InquiryID = b.InquiryID AND a.proposalNum = b.ProposalNum LEFT JOIN tbltrans_inquiry AS c ON a.InquiryID = c.Inquiry_ID WHERE a.isPrimary = '1' ORDER BY a.InquiryID;", $connection);
	// while($row8 = mysql_fetch_array($res8)){

 //        $getUnitName = mysql_fetch_array(mysql_query("SELECT unitname FROM tblref_unit WHERE unitid = '". $row8['UnitID'] ."';", $connection));

	// 	$res9 = mysql_query("INSERT INTO tbltrans_inquiry_unit SET InquiryID = '". $row8['Inquiry_ID'] ."', UnitID = '". $row8['UnitID'] ."';", $connection);

	// 	if($row8['Status'] == 'Occupied'){

	// 		$res10 = mysql_query("UPDATE tblref_unit SET Status = 'Occupied', TenantID = '". $row8[7] ."', TenantName = '". $row8['Trade_Name'] ."', StartDate = '". date('Y-m-d', strtotime($row8['datefrom'])) ."', EndDate = '". date('Y-m-d', strtotime($row8['dateto'])) ."' WHERE unitid = '". $row8['UnitID'] ."';", $connection);

	// 		$StartDate = date('Y-m-d', strtotime($row8['datefrom']));
 //            while (date('Y-m-d', strtotime($StartDate)) <= date('Y-m-d', strtotime($row8['dateto']))) {
 //                $resInsertLogs = mysql_query("INSERT INTO tblunit_statuslogs SET unitid = '". $row8['UnitID'] ."', unitname = '". $getUnitName['unitname'] ."', xdate = '". $StartDate ."', xtime = '". date('H:i:s') ."', status = 'Occupied', tenantid = '". $row8[7] ."', tenantname = '". $row8['Trade_Name'] ."', inquiryid = '". $row8['Inquiry_ID'] ."';", $connection);
 //                $StartDate = date('Y-m-d', strtotime($StartDate . '+1 day'));
 //            }

	// 	}else if($row8['Status'] == 'ForAwarding' || $row8['Status'] == 'Awarded'){

	// 		$res10 = mysql_query("UPDATE tblref_unit SET Status = 'ForAwarding' WHERE unitid = '". $row8['UnitID'] ."';", $connection);

	// 		$StartDate = date('Y-m-d', strtotime($row8['datefrom']));
 //            while (date('Y-m-d', strtotime($StartDate)) <= date('Y-m-d', strtotime($row8['dateto']))) {
 //                $resInsertLogs = mysql_query("INSERT INTO tblunit_statuslogs SET unitid = '". $row8['UnitID'] ."', unitname = '". $getUnitName['unitname'] ."', xdate = '". $StartDate ."', xtime = '". date('H:i:s') ."', status = 'ForAwarding', tenantid = '". $row8[7] ."', tenantname = '". $row8['Trade_Name'] ."', inquiryid = '". $row8['Inquiry_ID'] ."';", $connection);
 //                $StartDate = date('Y-m-d', strtotime($StartDate . '+1 day'));
 //            }

	// 	}

	// }

	// $ProCount = 1;
	// $resAllProposal = mysql_query("SELECT inquiryID, proposalNum, charges_list FROM tbltrans_proposal WHERE InquiryID NOT IN (SELECT InquiryID FROM tbltrans_procharges) AND charges_list != '';", $connection);
	// while($rowAllProposal = mysql_fetch_array($resAllProposal)){
	// 	$Charges = explode("|", $rowAllProposal['charges_list']);
	// 	for ($i = 0; $i <= COUNT($Charges) -2; $i++) { 
	// 		$getChargeInfo = mysql_fetch_array(mysql_query("SELECT CHARGE_ID, CHARGE_DESC, RATE_TYPE, RATE FROM tblref_refcharges WHERE CHARGE_ID = '". $Charges[$i] ."';", $connection));
	// 		$resInsertCharges = mysql_query("INSERT INTO tbltrans_procharges SET InquiryID = '". $rowAllProposal['inquiryID'] ."', ProposalNum = '". $rowAllProposal['proposalNum'] ."', ChargeCode = '". $getChargeInfo['CHARGE_ID'] ."', ChargeDesc = '". $getChargeInfo['CHARGE_DESC'] ."', ChargeType = '". $getChargeInfo['RATE'] ."', ChargeAmount = '". $getChargeInfo['RATE'] ."';", $connection);
	// 		if($resInsertCharges == true){
	// 			echo $ProCount . ". Inquiry ID: " . $rowAllProposal['inquiryID'] . " Proposal Number: ". $rowAllProposal['proposalNum'] ." - " . $getChargeInfo['CHARGE_ID'] . " - DONE.<br>";
	// 		}else{
	// 			echo $ProCount . ". Inquiry ID: " . $rowAllProposal['inquiryID'] . " Proposal Number: ". $rowAllProposal['proposalNum'] ." - " . $getChargeInfo['CHARGE_ID'] . " - Failed.<br>";
	// 		}
	// 		$ProCount++;
	// 	}
	// }

	$ChargeCount = 1;
	$resgetProposal = mysql_query("SELECT InquiryID, ProposalNum FROM tbltrans_proposal;", $connection);
	while($rowgetProposal = mysql_fetch_array($resgetProposal)){
		$resgetCharges = mysql_query("SELECT id, InquiryID, ProposalNum, ChargeCode, ChargeDesc, ChargeType, ChargeAmount FROM tbltrans_procharges WHERE InquiryID = '". $rowgetProposal['InquiryID'] ."' AND ProposalNum = '". $rowgetProposal['ProposalNum'] ."' AND (UnitID = '' OR UnitID IS NULL);", $connection);
		while($rowgetCharges = mysql_fetch_array($resgetCharges)){
			$resgetUnit = mysql_query("SELECT UnitID FROM tbltrans_proposal_unit WHERE InquiryID = '". $rowgetProposal['InquiryID'] ."' AND ProposalNum = '". $rowgetProposal['ProposalNum'] ."';", $connection);
			while($rowgetUnit = mysql_fetch_array($resgetUnit)){
				$resInsertCharge = mysql_query("INSERT INTO tbltrans_procharges SET InquiryID = '". $rowgetProposal['InquiryID'] ."', ProposalNum = '". $rowgetProposal['ProposalNum'] ."', ChargeCode = '". $rowgetCharges['ChargeCode'] ."', ChargeDesc = '". $rowgetCharges['ChargeDesc'] ."', ChargeType = '". $rowgetCharges['ChargeType'] ."', ChargeAmount = '". $rowgetCharges['ChargeAmount'] ."', UnitID = '". $rowgetUnit['UnitID'] ."';", $connection);
				$resInsertCharge2 = mysql_query("INSERT INTO tbltrans_chargeesca SET InquiryID = '". $rowgetProposal['InquiryID'] ."', ProposalNum = '". $rowgetProposal['ProposalNum'] ."', ChargeCode = '". $rowgetCharges['ChargeCode'] ."', UnitID = '". $rowgetUnit['UnitID'] ."';", $connection);
				if($resInsertCharge == true){
					$resDeleteCharge = mysql_query("DELETE FROM tbltrans_procharges WHERE id = '". $rowgetCharges['id'] ."';", $connection);
					if($resDeleteCharge == true){
						echo $ChargeCount . ". Inquiry ID: " . $rowgetProposal['InquiryID'] . " Proposal Number: ". $rowgetProposal['ProposalNum'] ." Unit ID ". $rowgetUnit['UnitID'] ." - " . $rowgetCharges['ChargeCode'] . " / DONE.<br>";
					}else{
						echo $ChargeCount . ". Inquiry ID: " . $rowgetProposal['InquiryID'] . " Proposal Number: ". $rowgetProposal['ProposalNum'] ." Unit ID ". $rowgetUnit['UnitID'] ." - " . $rowgetCharges['ChargeCode'] . " / Failed.<br>";
					}
					$ChargeCount++;
				}
			}
		}
	}

	$getBasicRentofEachProposal = mysql_query("SELECT InquiryID, ProposalNum, monthlyDues FROM tbltrans_proposal;", $connection);
	while($rowgetBasicRentofEachProposal = mysql_fetch_array($getBasicRentofEachProposal)){
		$ComputedEscalation = 0;
		$resGetEsca = mysql_query("SELECT id, EscaYear, EscaRate, AccuEscaRate FROM tbltrans_escalation WHERE InquiryID = '". $rowgetBasicRentofEachProposal['InquiryID'] ."' AND ProposalNum = '". $rowgetBasicRentofEachProposal['ProposalNum'] ."';", $connection);
		while($rowGetEsca = mysql_fetch_array($resGetEsca)){
			$Escalation = ($rowgetBasicRentofEachProposal['monthlyDues'] + $ComputedEscalation) * floatval($rowGetEsca['EscaRate'] / 100);
			$ComputedEscalation += $Escalation;
			$resUpdateEsca = mysql_query("UPDATE tbltrans_escalation SET EscaAmount = '". floatval($Escalation) ."', EscaTotal = '". floatval($rowgetBasicRentofEachProposal['monthlyDues'] + $ComputedEscalation) ."' WHERE id = '". $rowGetEsca['id'] ."';", $connection);
			echo "Inquiry ID: " . $rowgetBasicRentofEachProposal['InquiryID'] . " Proposal Number: ". $rowgetBasicRentofEachProposal['ProposalNum'] ." - " .$rowGetEsca['EscaYear']." Escalation: ". number_format($Escalation, 2, '.', ',') ." / Total: ". number_format(floatval($rowgetBasicRentofEachProposal['monthlyDues'] + $ComputedEscalation), 2, '.', ',') ."<br>";
		}
	}
?>