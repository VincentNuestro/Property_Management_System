<?php
	session_start();
    include('../../connect.php');
	$filepath = mysql_fetch_array(mysql_query("SELECT dbsetup FROM tblsys_setup;", $connection)); //Get System Setup
	$tblSales = tblSales($filepath['dbsetup']);
	function columnLetter($c){
	    $c = intval($c);
	    if ($c <= 0) return '';
	    $letter = '';
	    while($c != 0){
	       $p = ($c - 1) % 26;
	       $c = intval(($c - $p) / 26);
	       $letter = chr(65 + $p) . $letter;
	    }
	    return $letter;
	}
    switch ($_POST['form']){
		case 'tbltenantlists':
			$page = $_POST['page'];
			$limit = ($page-1) * 20;
			$sql = "SELECT TenantID, tradename, companyname, tenanttype, revpercent, merchant_code, companyID, tradeID, mallid FROM tbltrans_tenants WHERE (Status = 'Active' OR Status = 'ForEviction' OR Status = 'ForRenewal') AND ustatus = 'Occupied' AND ( tradename LIKE '%". $_POST['txtsearchapplication'] ."%' OR  TenantID LIKE '%". $_POST['txtsearchapplication'] ."%' OR companyname LIKE '%". $_POST['txtsearchapplication'] ."%') ". getMallAccess("mallID", "AND") ." ORDER BY tradename ASC LIMIT ". $limit .",20;";
			$result = mysql_query($sql, $connection);
			while ($row = mysql_fetch_array($result)){

				$RunningBalance = mysql_fetch_array(mysql_query("SELECT SUM(balance) FROM tbltransaction WHERE tenantid = '".$row['TenantID']."';", $connection));

				if($row['revpercent'] != ""){ 
					$percent = $row['revpercent'] .  "% Revenue"; 
				}else{ 
					$percent = ""; 
				}

				if($row['tenanttype'] == 'Rent'){
					$BillingType = "<span class='label label-lg label-info arrowed-in-right arrowed' style='z-index: 0;'><i class='ace-icon fa fa-tag bigger-80'></i>&nbsp;&nbsp;Basic Rent/SQM&nbsp;</span>"; 
	            }else if($row['tenanttype'] == 'Fixed Rent'){
					$BillingType = "<span class='label label-lg label-success arrowed-in-right arrowed' style='z-index: 0;'><i class='ace-icon fa fa-tag bigger-80'></i>&nbsp;&nbsp;Fixed Rent&nbsp;</span>"; 
	            }else if($row['tenanttype'] == 'Share Only'){
					$BillingType = "<span class='label label-lg label-yellow arrowed-in-right arrowed' style='z-index: 0;'><i class='ace-icon fa fa-tag bigger-80'></i>&nbsp;&nbsp;". $row['revpercent'] ." % of GS&nbsp;</span>"; 
	            }else if($row['tenanttype'] == 'Rent Rev'){
					$BillingType = "<span class='label label-lg label-purple arrowed-in-right arrowed' style='z-index: 0;'><i class='ace-icon fa fa-tag bigger-80'></i>&nbsp;&nbsp;Basic Rent/SQM + ". $row['revpercent'] ." % of GS&nbsp;</span>"; 
	            }else if($row['tenanttype'] == 'Rent or Share'){
					$BillingType = "<span class='label label-lg label-pink arrowed-in-right arrowed' style='z-index: 0;'><i class='ace-icon fa fa-tag bigger-80'></i>&nbsp;&nbsp;Basic Rent/SQM or ". $row['revpercent'] ." % of GS&nbsp;</span>"; 
	            }else{
					$BillingType = "<span class='label label-lg label-info arrowed-in-right arrowed' style='z-index: 0;'><i class='ace-icon fa fa-tag bigger-80'></i>&nbsp;&nbsp;Basic Rent/SQM&nbsp;</span>"; 
	            }
				
				echo 	"<tr>
							<td width='15%' class='hide_mobile'>". $row['TenantID'] ."</td>
							<td width='20%' class='scroll'>". $row['tradename'] ."</td>
							<td width='20%' class='hide_mobile'>" . $row['companyname'] ."</td>
							<td width='10%' class='scroll' align='center'>". $BillingType ."</td>
							<td width='15%' class='scroll' align='right'>". number_format($RunningBalance[0], "2", ".", ",") ."</td>
							<td width='5%' class='hide_mobile center' style='z-index: 0;'>
								<button class='btn btn-sm btn-grey hide isadmin select-viewlisttransaction btn-round' onclick='OpenTransactionBilling(\"". $row["TenantID"] ."\");'><img src='assets/images/invoice.png' style='width: 100%; height: auto;' /></button>
							</td>
						</tr>";
			}
		break;

		case 'loadentriesbilling':
           	if($_POST["page"] == ""){
               $page = 1;
           	}else{
               $page = $_POST["page"];
           	}
           	$limit = ($page-1) * 20;
            $sql = "SELECT COUNT(TenantID) FROM tbltrans_tenants WHERE (Status = 'Active' OR Status = 'ForEviction' OR Status = 'ForRenewal') AND ustatus = 'Occupied' AND ( tradename LIKE '%". $_POST['txtsearchapplication'] ."%' OR  TenantID LIKE '%". $_POST['txtsearchapplication'] ."%' OR companyname LIKE '%". $_POST['txtsearchapplication'] ."%') ". getMallAccess("mallID", "AND") .";";
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
        break;

		case "loadpagebilling":
		    $page = $_POST["page"];
	    	$sqlb = "SELECT COUNT(TenantID) FROM tbltrans_tenants WHERE (Status = 'Active' OR Status = 'ForEviction' OR Status = 'ForRenewal') AND ustatus = 'Occupied' AND ( tradename LIKE '%". $_POST['txtsearchapplication'] ."%' OR  TenantID LIKE '%". $_POST['txtsearchapplication'] ."%' OR companyname LIKE '%". $_POST['txtsearchapplication'] ."%') ". getMallAccess("mallID", "AND") .";";
			$aa = mysql_query($sqlb, $connection);
			$nums = mysql_fetch_row($aa);
			$num = $nums[0];
			$rowsperpage = 20;
			$range = 3;
			$totalpages = ceil($num / $rowsperpage);
			$prevpage;
			$nextpage;
			if($page > 1 ){
			   	echo "<li style='width:50px !important;' onclick='pagination(1)'><< First</li>";
			   	$prevpage = $page - 1;
			   	echo "<li style='width:70px !important;' onclick='pagination(". $prevpage .")'>< Previous</li>";
			}

			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   	if (($x > 0) && ($x <= $totalpages)){
				    if ($x == $page){
	                    echo "<li id='pg" . $x . "' class='pgnum active' onclick='pagination(" . $x . ",". $x .")'>" . $x . "</li>";
	                }else{
				        echo "<li id='pg" . $x . "' class='pgnum' onclick='pagination(" . $x . ",". $x .")'>" . $x . "</li>";
	                }
		       	}
		    }
		    if($page < ($totalpages - $range)){
	            echo "<li>...</li>";
	        }
		    if ($page != $totalpages && $num != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='pagination(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='pagination(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'OpenTransactionBilling':
			$TenantInfo = mysql_fetch_array(mysql_query("SELECT tradename, companyname, mallID, tradeID, tenanttype, revpercent, merchant_code, companyID FROM tbltrans_tenants WHERE TenantID = '". $_POST['TenantID'] ."';", $connection));

			$RunningBalance = mysql_fetch_array(mysql_query("SELECT SUM(balance), SUM(totalamount), SUM(paymentamount), SUM(vatamount), SUM(amount) FROM tbltransaction WHERE tenantid = '". $_POST['TenantID'] ."' AND amount > 0;", $connection));

			$TotalPayment = mysql_fetch_array(mysql_query("SELECT SUM(amount), SUM(balance) FROM tbltransaction WHERE tenantid = '". $_POST['TenantID'] ."' AND (paymenttype IS NOT NULL AND paymenttype != '');", $connection));

			$MallName = mysql_fetch_array(mysql_query("SELECT mallname FROM tblref_mall WHERE mallid = '". $TenantInfo['mallID'] ."';", $connection));

			$FileName = mysql_fetch_array(mysql_query("SELECT filename FROM tbltrans_tradename WHERE tradeID = '". $TenantInfo['tradeID'] ."';", $connection));

			$AutoMerchant = mysql_fetch_array(mysql_query("SELECT automerchant_code FROM tbltrans_company WHERE CompanyID = '". $TenantInfo['companyID'] ."';", $connection));

			if($FileName['filename'] == ""){
                $img = "assets/images/noimage5.png";
            }else{
                if(!file_exists("../../../Mall_Attachments/company/". $TenantInfo["companyID"] ."/trades/". $TenantInfo["tradeID"] ."/". $FileName["filename"])){ 
                    $img = "assets/images/noimage5.png";
                }else{
                    $img = "../Mall_Attachments/company/". $TenantInfo["companyID"] ."/trades/". $TenantInfo["tradeID"] ."/". $FileName["filename"];
                }
            }

            if(SysLeaseSetup('automerchantcode') == "1"){
        		$MerchantCode = $TenantInfo['merchant_code']."-".$AutoMerchant['automerchant_code'];
        	}else{
        		$MerchantCode = $TenantInfo['merchant_code'];
        	}

            if($TenantInfo['tenanttype'] == 'Rent'){
                $BillingType = "Basic Rent/SQM";
            }else if($TenantInfo['tenanttype'] == 'Fixed Rent'){
                $BillingType = "Fixed Rent";
            }else if($TenantInfo['tenanttype'] == 'Share Only'){
                $BillingType = $TenantInfo['revpercent'] ." % of Gross Sales";
            }else if($TenantInfo['tenanttype'] == 'Share Only2'){
                $BillingType = $TenantInfo['revpercent'] ." % of Net Sales";
            }else if($TenantInfo['tenanttype'] == 'Rent Rev'){
                $BillingType = "Basic Rent/SQM + ". $TenantInfo['revpercent'] ." % on GS";
            }else if($TenantInfo['tenanttype'] == 'Rent or Share'){
                $BillingType = "Basic Rent/SQM or ". $TenantInfo['revpercent'] ." % on GS";
            }else{
                $BillingType = "Basic Rent/SQM";
            }

            if($RunningBalance[0] <= 0){	
            	$TotalBalance = number_format(0, "2", ".", ",");
            }else{
            	$TotalBalance = number_format($RunningBalance[0], "2", ".", ",");
            }

            echo $img . "|" . 
            $TenantInfo['tradename'] . "|" . 
            $TenantInfo['companyname'] . "|" . 
            $MallName['mallname'] . "|" . 
            $MerchantCode . "|" . 
            $BillingType . "|" . 
            number_format($RunningBalance[0], "2", ".", ",") . "|" . 
            number_format(str_replace("-", "", floatval($TotalPayment[0])), "2", ".", ",") . "|" . 
            number_format(str_replace("-", "", $TotalPayment[0] - $TotalPayment[1]), "2", ".", ",") . "|" . 
            number_format(str_replace("-", "", floatval($TotalPayment[1])), "2", ".", ",") . "|" . 
            $TotalBalance . "|" . 
            number_format($RunningBalance[1], "2", ".", ",") . "|" .
            number_format($RunningBalance[2], "2", ".", ",") . "|" .
            number_format($RunningBalance[3], "2", ".", ",") . "|" .
            number_format($RunningBalance[4], "2", ".", ",");
		break;

		case 'TransBillChargeList':
			$res = mysql_query("SELECT xdate, description, qty, amount, vatamount, totalamount, balance, reference FROM tbltransaction WHERE tenantid = '". $_POST['TenantID'] ."' AND (paymenttype IS NULL OR paymenttype = '') ORDER BY xdate DESC;", $connection);
			echo "SELECT xdate, description, qty, amount, vatamount, totalamount, balance, reference FROM tbltransaction WHERE tenantid = '". $_POST['TenantID'] ."' AND (paymenttype IS NULL OR paymenttype = '') ORDER BY xdate DESC;";
			while($row = mysql_fetch_array($res)){
				echo 	"<tr>
							<td>". date('m/d/Y', strtotime($row['xdate'])) ."</td>
							<td>". $row['description'] ."</td>
							<td>". $row['reference'] ."</td>
							<td style='text-align: center;display: none;'>". $row['qty'] ."</td>
							<td style='text-align: right;'>". number_format($row['amount'], "2", ".", ",") ."</td>
							<td style='text-align: right;'>". number_format($row['vatamount'], "2", ".", ",") ."</td>
							<td style='text-align: right;'>". number_format($row['totalamount'], "2", ".", ",") ."</td>
							<td style='text-align: right;'>". number_format(str_replace("-" ,"", $row['balance'] - $row['totalamount']), "2", ".", ",") ."</td>
							<td style='text-align: right;'>". number_format($row['balance'], "2", ".", ",") ."</td>
						</tr>";
			}
		break;

		case 'TransBillPaymentList':
			$res = mysql_query("SELECT xdate, description, amount, paymenttype, balance, reference FROM tbltransaction WHERE tenantid = '". $_POST['TenantID'] ."' AND (paymenttype IS NOT NULL AND paymenttype != '') ORDER BY xdate DESC;", $connection);
			while($row = mysql_fetch_array($res)){
				echo 	"<tr>
							<td>". date('m/d/Y', strtotime($row['xdate'])) ."</td>
							<td>". $row['description'] ."</td>
							<td>". $row['reference'] ."</td>
							<td style='text-align: right;'>". number_format(str_replace("-", "", $row['amount']), "2", ".", ",") ."</td>
							<td style='text-align: right;'>". number_format(str_replace("-", "", $row['balance'] - $row['amount']), "2", ".", ",") ."</td>
							<td style='text-align: right;'>". number_format(str_replace("-", "", $row['balance']), "2", ".", ",") ."</td>
						</tr>";
			}
		break;

		case 'showTenantInfo':
			$TenantInfo = mysql_fetch_array(mysql_query("SELECT a.Status, a.tenanttype, a.revpercent, b.unitname FROM tbltrans_tenants AS a LEFT JOIN tblref_unit AS b ON a.unitID = b.unitid WHERE a.TenantID = '". $_POST['TenantID'] ."';", $connection));

            if($TenantInfo['tenanttype'] == 'Rent'){
                $BillingType = "Basic Rent/SQM";
            }else if($TenantInfo['tenanttype'] == 'Fixed Rent'){
                $BillingType = "Fixed Rent";
            }else if($TenantInfo['tenanttype'] == 'Share Only'){
                $BillingType = $TenantInfo['revpercent'] ." % of Gross Sales";
            }else if($TenantInfo['tenanttype'] == 'Share Only2'){
                $BillingType = $TenantInfo['revpercent'] ." % of Net Sales";
            }else if($TenantInfo['tenanttype'] == 'Rent Rev'){
                $BillingType = "Basic Rent/SQM + ". $TenantInfo['revpercent'] ." % on GS";
            }else if($TenantInfo['tenanttype'] == 'Rent or Share'){
                $BillingType = "Basic Rent/SQM or ". $TenantInfo['revpercent'] ." % on GS";
            }else{
                $BillingType = "Basic Rent/SQM";
            }

			echo $TenantInfo['Status'] . "|" . $BillingType;
		break;

		case 'fncmdlAddCharge':
			$mgaMeron = "";
			$arr = explode("|", $_POST['ChargeIDs']);
			for ($i=0; $i <= count($arr)-2; $i++) { 
				$mgaMeron .= "'" . $arr[$i] . "'" . ",";
			}

			if($_POST['ChargeIDs'] != ""){
				$tanong = "AND CHARGE_ID NOT IN (". substr(trim($mgaMeron), 0, -1) .")";
			}else{
				$tanong = "";
			}
			$res = mysql_query("SELECT CHARGE_ID, CHARGE_DESC, RATE_TYPE, RATE, OTHER_REASON FROM tblref_refcharges WHERE CHARGE_DESC LIKE '%". $_POST['key'] ."%' ". $tanong ." ORDER BY CHARGE_DESC ASC;", $connection);
			while($row = mysql_fetch_array($res)){

				if($row['RATE_TYPE'] == "Occurence" || $row['RATE_TYPE'] == "Other"){
					$Unit = $row['OTHER_REASON'];
				}else{
					$Unit = $row['RATE_TYPE'];
				}

				echo "	<tr id='TR". $row['CHARGE_ID'] ."' onclick='getQtyorPrice(\"". $row['CHARGE_ID'] ."\", \"". $row['RATE_TYPE'] ."\", \"". number_format($row['RATE'], "2", ".", ",") ."\", \"". $row['CHARGE_DESC'] ."\")'>
							<td>". $row['CHARGE_DESC'] ."</td>
							<td>". $Unit ."</td>
							<td style='text-align: right;'>". number_format($row['RATE'], "2", ".", ",") ."</td>";
			}
		break;

		case 'AddSelectedCharge':
			if($_POST['RateType'] == "Other"){
				$Rate = floatval($_POST['ChargeAmount']) * $_POST['ChargeCount'];
			}else{
				$Rate = floatval($_POST['ChargeRate']) * $_POST['ChargeCount'];
			}

			$TenantInfo = mysql_fetch_array(mysql_query("SELECT a.mallID, b.isRent FROM tbltrans_tenants AS a INNER JOIN tbltrans_proposal AS b ON a.inqID = b.inquiryID AND a.ActiveProposal = b.proposalNum WHERE a.TenantID = '". $_POST['TenantID'] ."';", $connection));
			$getSetup = explode("|", getrentvattype($TenantInfo['mallID']));
			$isVatable = $getSetup[1];
			$isInclusive = $getSetup[2];
			$VATPercent = floatval($getSetup[0]) / 100;
			if($TenantInfo['isRent'] == 0){
				if($isVatable == "yes"){
	                if($isInclusive == "inc"){ //VAT IS INCLUSIVE
	                    $VATAmount = ( floatval($Rate) / 1.12 ) * $VATPercent;
	                    $RentLessVAT = floatval($Rate) - $VATAmount;
	                    $Amount = $RentLessVAT;
						$VAT = $VATAmount;
	                    $TotalAmount = $VAT + $Amount;
	                }else{ //VAT IS EXCLUSIVE
	                    $VATAmount = floatval($Rate) * $VATPercent;
	                    $RentPlusVAT = floatval($Rate);
	                    $Amount = floatval($Rate);
	                    $VAT = $VATAmount;
	                    $TotalAmount = floatval($Rate) + $VATAmount;
	                }
	            }else{
	            	$Amount = $Rate;
	                $VAT = "0.00";
	                $TotalAmount = floatval($Rate);
	            }
            }else{
                $Amount = $Rate;
                $VAT = "0.00";
                $TotalAmount = floatval($Rate);
            }

			echo 	"<tr id='". $_POST['ChargeID'] ."' class='unselected'>
						<td>". date('m/d/Y', strtotime(getsysdate())) ."</td>
						<td>". $_POST['ChargeDescription'] ."</td>
						<td>". $_POST['Particulars'] ."</td>
						<td style='text-align: center;display: none;'>". $_POST['ChargeCount'] ."</td>
						<td style='text-align: right;'>". number_format($Amount, "2", ".", ",") ."</td>
						<td style='text-align: right;'>". number_format($VAT, "2", ".", ",") ."</td>
						<td style='text-align: right;'>". number_format($TotalAmount, "2", ".", ",") ."</td>
					</tr>";
		break;

		case 'PostFPCharges':
			$Machine_No = mysql_fetch_array(mysql_query("SELECT Machine_No FROM tblsys_setup;", $connection));
			$MerchantCode = mysql_fetch_array(mysql_query("SELECT merchant_code FROM tbltrans_tenants WHERE TenantID = '". $_POST['TenantID'] ."';", $connection));
			$arr = explode("@", $_POST['ChargeList']);
			$count = 0;
			for($i = 0; $i <= COUNT($arr)-2 ; $i++){
				$arr2 = explode("|", $arr[$i]);
				$res = mysql_query("INSERT INTO tbltransaction SET tenantid = '". $_POST['TenantID'] ."', xcode = '". $arr2[0] ."', description = '". $arr2[1] ."', amount = '". floatval($arr2[3]) ."', vatamount = '". floatval($arr2[4]) ."', qty = '". $arr2[2] ."', balance = '". floatval($arr2[3] + $arr2[4]) ."', xdate = '". date('Y-m-d', strtotime($_POST['xDate'])) ."', reference = '". $arr2[6] ."', totalamount = '". floatval($arr2[3] + $arr2[4]) ."', xdescription = '". $arr2[1] ."', userid = '". $_SESSION['MMS-UserID'] ."', Machine_No = '". $Machine_No['Machine_No'] ."', merchant_code = '". $MerchantCode['merchant_code'] ."';", $connection);
				if($res == true){
					$count++;
				}
			}
			if($count > 0 ){
				echo "0|Charges successfully posted to billing.|fncmdlClearCharge";
			}else{
				echo "1|Failed to post charges to billing.|";
			}
		break;

		case 'getorno':
			$getprefix = mysql_fetch_array(mysql_query("SELECT mallprefix FROM tblsys_setup;", $connection));
			$selectlastid = mysql_fetch_array(mysql_query("SELECT orno FROM tbltransaction WHERE orno != '' ORDER BY ID DESC LIMIT 1;", $connection));
			if($selectlastid[0] == ""){
				echo $getprefix[0] ."-". addleadingzero("1");
			}else{
				$arr = explode("-", $selectlastid[0]);
				echo $getprefix[0] ."-". addleadingzero($arr[1]+1);
			}
		break;

		case 'showtxtinfostorename':
       		$title = mysql_fetch_array(mysql_query("SELECT softwaretype FROM tblsys_setup;", $connection));
			if($title[0] == "5"){
				$label =  "Buyer";
			}else{
				$label =  "Tenant";
			}
			echo "<option value=''>-- Select ". $label ." --</option>";
       		$res = mysql_query("SELECT tenantid, tradename FROM tbltrans_tenants WHERE (Status = 'Active' OR Status = 'ForEviction' OR Status = 'ForRenewal') AND ustatus = 'Occupied' ". getMallAccess("mallID", "AND") ." ORDER BY tradename ASC;", $connection);
       		while($row = mysql_fetch_array($res)){
       			echo "<option value='".$row[0]."'>".$row[1]."</option>";
       		}
   		break;

   		case 'loadbalancelist':
			$sql = "SELECT id, xcode, description, xdate, balance, id, amount, xdescription, vatamount FROM tbltransaction WHERE tenantid = '" . $_POST['tenantid'] . "' AND balance != '0.00' AND balance NOT LIKE '%-%' ORDER BY xdate ASC;";
			$result = mysql_query($sql, $connection);
			while ($row = mysql_fetch_array($result)) {
				$oldestbalance = mysql_fetch_array(mysql_query("SELECT xdate FROM tbltransaction WHERE tenantid = '" . $_POST['tenantid'] . "' AND balance != '0.00' AND balance NOT LIKE '%-%' ORDER BY xdate ASC LIMIT 0,1;", $connection));

				if(date('Y-m-d', strtotime($row[3])) == date('Y-m-d', strtotime($oldestbalance[0]))){
					$bayarin = "1";
				}else{
					$bayarin = "0";
				}

				if($row["description"] == "Monthly Rent"){
					$details = "monthly_rent";
				}else{
					$details = "other_charges";
				}
				echo 	"<tr id='". $row['id'] ."'>
							<td style='border-left: 0px !important;display: none;'><input name='form-field-checkbox2[1][]' class='ace ace-checkbox-2 chk_inquiry_unittype' type='checkbox' id='".$details."' value='0'><span class='lbl'></span></label></td>
							<td class='date_added'>". date("m/d/Y", strtotime($row['xdate'])) ."</td>
							<td class='date_desc'><input type='hidden' class='hiddenamount bal_".$row["id"]."' value='" . $row['balance'] . "'>". $row['description'] ."</td>
							<td align='right'>". number_format($row['amount'], 2, '.', ',') ."</td>
							<td align='right'>". number_format($row['vatamount'], 2, '.', ',') ."</td>
							<td align='right'>". number_format((floatval($row['vatamount'])+floatval($row['amount'])), 2, '.', ',') ."</td>
							<td align='right' class='tdbalance'>" . number_format($row['balance'], 2, '.', ',') ."</td>
							<td style='border-right: 0px !important;'><input type='text' value='' style='text-align: right;' disabled  onchange='computebalance(this.id);' id='bal_". $row["id"] ."' class='inputbal form-control amount numonly' placeholder='0.00'></td>
						</tr>";
			}
		break;

		case 'getchecklist':
			$page = $_POST['page'];
			$limit = ($page-1) * 20;
			$sql = "SELECT pdcdate, checkstat, depositorystat, bank, checkno, amount FROM tbltrans_pdc WHERE customerid = '" . $_POST['tenantid'] . "' AND paymentstat = '0' AND checkstat = 'Cleared' LIMIT ". $limit .",20;";
			$result = mysql_query($sql, $connection);
			while ($row = mysql_fetch_array($result)) {
				echo "
					<tr id='". $row[4] . "' onclick='selectcheck(\"".date('m/d/Y', strtotime($row[0]))."\", \"".$row[3]."\", \"".$row[4]."\", \"".$row[5]."\");'>
						<td>". $row[4] ."</td>
						<td>". date('m/d/Y', strtotime($row[0])) ."</td>
						<td>". $row[3] ."</td>
						<td>". $row[2] ."</td>
						<td>". $row[1] ."</td>
						<td>". number_format($row[5], 2, '.', ',') ."</td>
					</tr>
				";
			}
		break;

		case 'fncCheckListEntries':
           	if($_POST["page"] == ""){
               	$page = 1;
           	}else{
               	$page = $_POST["page"];
           	}
           	$limit = ($page-1) * 20;
            $sql = "SELECT COUNT(*) FROM tbltrans_pdc WHERE customerid = '" . $_POST['tenantid'] . "' AND paymentstat = '0' AND checkstat = 'Cleared';";
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
        break;

		case "fncCheckListPage":
		    $page = $_POST["page"];
	    	$sqlb = "SELECT COUNT(*) FROM tbltrans_pdc WHERE customerid = '" . $_POST['tenantid'] . "' AND paymentstat = '0' AND checkstat = 'Cleared';";
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
			   echo "<li style='width:50px !important;' onclick='fncCheckListFunc(1)'><< First</li>";
			   $prevpage = $page - 1;
			   echo "<li style='width:70px !important;' onclick='fncCheckListFunc(". $prevpage .")'>< Previous</li>";
			}

			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if (($x > 0) && ($x <= $totalpages)){
				    if($x == $page){
	                    echo "<li id='CheckList" . $x . "' class='CheckListNum active' onclick='fncCheckListFunc(" . $x . ",". $x .")'>" . $x . "</li>";
	                }else{
				        echo "<li id='CheckList" . $x . "' class='CheckListNum' onclick='fncCheckListFunc(" . $x . ",". $x .")'>" . $x . "</li>";
	                }
		       }
		    }
		    if($page < ($totalpages - $range)){
	            echo "<li>...</li>";
	        }

		    if ($page != $totalpages && $num != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='fncCheckListFunc(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='fncCheckListFunc(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'savedeposit':
			$checkor = mysql_fetch_array(mysql_query("SELECT orno FROM tbltransaction WHERE orno = '". $_POST['orno'] ."';", $connection));
			if($checkor[0] == ""){
				if($_POST["checkdate"] != ""){
					$chkdate = date("Y-m-d", strtotime($_POST['checkdate']));
				}else{
					$chkdate = "";
				}
				$datenow = getsysdate();
				$year = date('Y', strtotime($datenow));
				$month = date('m', strtotime($datenow));
				$Machine_No = mysql_fetch_array(mysql_query("SELECT Machine_No FROM tblsys_setup"));

				if($_POST['transdate'] == ""){
					$transdate = "";
					$xdate = ", xdate = '". date('Y-m-d', strtotime(getsysdate())) ."' ";
				}else{
					$transdate = ", transdate = '". date('Y-m-d', strtotime($_POST['transdate'])) ."'";
					$xdate = "";
				}

				$PaymentType = mysql_fetch_array(mysql_query("SELECT PaymentTypeDesc FROM tblref_pospaymenttype WHERE PaymentTypeID = '". $_POST['PaymentTypeID'] ."';", $connection));

				$sql = "INSERT INTO tbltransaction SET tenantid = '" . $_POST["tenantid"] . "', xcode = '". $_POST['PaymentTypeID'] ."', description = '". $PaymentType['PaymentTypeDesc'] ."', reference = '". $_POST['remarks'] ."', amount = '-" . $_POST["amount"] . "', qty = '1', xdatetime = '" . date("Y-m-d H:i:s") . "', paymenttype = '" . $_POST["PaymentTypeID"] . "', totalamount = '-". $_POST['amount'] ."', orno = '". $_POST['orno'] ."', userid = '". $_SESSION['MMS-UserID'] ."', Machine_No = '". $Machine_No[0] ."', isdeposit = '1', paymentamount = '-". $_POST['amount'] ."', balance = '-". $_POST['amount'] ."', xdescription = '". $PaymentType['PaymentTypeDesc'] ."', checkno = '". $_POST['checknno'] ."', checkdate = '". $chkdate ."', bankname = '". $_POST['bankname'] ."', checkname = '". $_POST['checkname'] ."', cardholder = '" . $_POST["ccholder"] . "', ccno = '" . $_POST["ccno"] . "', expdate = '" . date('Y-m-d', strtotime($_POST["expdate"])) . "', authno = '". $_POST['authno'] ."', secno = '". $_POST['secno'] ."', cardtype = '". $_POST["cardtype"] ."', bnkfrom = '". $_POST["namefrom"] ."', bnkto = '". $_POST["nameto"] ."', accnofrom = '". $_POST["accfrom"] ."', accnoto = '". $_POST["accto"] ."' ". $transdate . $xdate .";";
				$result = mysql_query($sql, $connection);
				if($result == true){
					echo "1|Deposit success.|".$_POST['orno'];
				}else{
					echo "2|An error has occured.";
				}
			}else{
				echo "3|O.R No already existing.";	
			}
		break;

		case 'savepayment':
			$checkor = mysql_fetch_array(mysql_query("SELECT orno FROM tbltransaction WHERE orno = '". $_POST['orno'] ."';", $connection));
			$Machine_No = mysql_fetch_array(mysql_query("SELECT Machine_No FROM tblsys_setup;", $connection));
			$tenantinfo = mysql_fetch_array(mysql_query("SELECT inqID, owner_firstname, owner_lastname, merchant_code FROM tbltrans_tenants WHERE TenantID = '". $_POST['tenantid'] ."';", $connection));
			$PaymentType = mysql_fetch_array(mysql_query("SELECT PaymentTypeDesc FROM tblref_pospaymenttype WHERE PaymentTypeID = '". $_POST['PaymentTypeID'] ."';", $connection));
			if($_POST['transdate'] == ""){
				$xdate = ", xdate = '". date('Y-m-d', strtotime(getsysdate())) ."'";
				$transdate = "";
			}else{
				$xdate = "";
				$transdate = ", transdate = '". date('Y-m-d', strtotime($_POST['transdate'])) ."'";
			}
			if($checkor[0] == ""){
				if($_POST['PaymentType'] == "CHECK"){
					if($_POST["checkdate"] != ""){
						$chkdate = date("Y-m-d", strtotime($_POST['checkdate']));
					}else{
						$chkdate = "";
					}

					$payment = 0;
					$sukli = 0;

					if($_POST['selected'] == ""){
						$rescheckpayment = mysql_query("INSERT INTO tbltransaction SET tenantid = '". $_POST['tenantid'] ."', xcode = '". $_POST['PaymentTypeID'] ."', description = '". $PaymentType['PaymentTypeDesc'] ."', amount = '-". $_POST['amount'] ."', qty = '1', paymentamount = '-". $_POST['amount'] ."', balance = '-". $_POST['amount'] ."', userid = '". $_SESSION['MMS-UserID'] ."', Machine_No = '". $Machine_No[0] ."', totalamount = '-". $_POST['amount'] ."', reference = '". $_POST['remarks'] ."', xdescription = '". $PaymentType['PaymentTypeDesc'] ."', paymenttype = '". $_POST['PaymentTypeID'] ."', checkdate = '". date('Y-m-d', strtotime($_POST['checkdate'])) ."', checkname = '". $_POST['checkname'] ."', bankname = '". $_POST['bankname'] ."', orno = '". $_POST['orno'] ."' ". $transdate . $xdate .";", $connection);
						if($rescheckpayment == true){
							echo "1|Transaction successfully proccessed.|".$_POST['orno'];
							$updatetblpdc = mysql_query("UPDATE tbltrans_pdc SET paymentstat = '1', pdcreceiptno = '". $_POST['orno'] ."' WHERE customerid = '". $_POST['tenantid'] ."' AND checkno = '". $_POST['checkno'] ."';", $connection);
						}else{
							echo "2|Failed to process transaction.";
						}
					}else{
						$listahan = explode("|", $_POST['selected']);
						for($i=0; $i <= COUNT($listahan)-2; $i++){ 
							$arr = explode("#", $listahan[$i]);
							$payment += $arr[1];
							$sukli = floatval($_POST['amount']) - $payment;
							$resupdatebal = mysql_query("UPDATE tbltransaction SET paymentamount = '-" . $arr[1] . "', balance = '" . $arr[2] . "' WHERE tenantid = '" . $_POST['tenantid'] . "' AND id = '" . $arr[0] . "';", $connection);
							if($resupdatebal == true){
								echo "1|Charges successfully paid.|".$_POST['orno'];		
								$PaymentInfo = mysql_fetch_array(mysql_query("SELECT tenantid, xcode, description, amount, qty, paymentamount, vatamount, balance, xdate, reference, totalamount FROM tbltransaction WHERE id = '". $arr[0] ."';", $connection));
							 	$getMall = mysql_fetch_array(mysql_query("SELECT a.mallID FROM tbltrans_tenants AS a LEFT JOIN tblref_mall AS b ON a.mallID = b.mallid WHERE a.TenantID = '". $PaymentInfo['tenantid'] ."';", $connection));
							 	$InsertAppLog = mysql_query("INSERT INTO tbltrans_paymentapplogs SET TenantID = '". $PaymentInfo['tenantid'] ."', MallID = '". $getMall['mallID'] ."', xcode = '". $PaymentInfo['xcode'] ."', description = '". $PaymentInfo['description'] ."', qty = '". $PaymentInfo['qty'] ."', xdate = '". $PaymentInfo['xdate'] ."', PaymentAmount = '". $PaymentInfo['paymentamount'] ."', PaymentOR = '". $_POST['orno'] ."', Amount = '". $PaymentInfo['amount'] ."', VATAmount = '". $PaymentInfo['vatamount'] ."', TotalAmount = '". $PaymentInfo['totalamount'] ."', Balance = '". $PaymentInfo['balance'] ."', Reference = '". $PaymentInfo['reference'] ."', UserID = '". $_SESSION['MMS-UserID'] ."', PaymentTypeID = '". $_POST['PaymentTypeID'] ."', PaymentTypeDesc = '". $PaymentType['PaymentTypeDesc'] ."';", $connection);						
							}else{
								echo "2|Failed to settle charges.";
							}
						}
						$updatetblpdc = mysql_query("UPDATE tbltrans_pdc SET paymentstat = '1', pdcreceiptno = '". $_POST['orno'] ."' WHERE customerid = '". $_POST['tenantid'] ."' AND checkno = '". $_POST['checkno'] ."';", $connection);
						if($sukli >= 0){
							$res = mysql_query("INSERT INTO tbltransaction SET tenantid = '". $_POST['tenantid'] ."', xcode = '". $_POST['PaymentTypeID'] ."', description = '". $PaymentType['PaymentTypeDesc'] ."', amount = '-". $_POST['amount'] ."', qty = '1', paymentamount = '-". $sukli ."', balance = '-". $sukli ."', userid = '". $_SESSION['MMS-UserID'] ."', Machine_No = '". $Machine_No[0] ."', reference = '". $_POST['remarks'] ."', xdescription = '". $PaymentType['PaymentTypeDesc'] ."', orno = '". $_POST['orno'] ."', paymenttype = '". $_POST['PaymentTypeID'] ."', checkdate = '". date('Y-m-d', strtotime($_POST['checkdate'])) ."', checkname = '". $_POST['checkname'] ."', bankname = '". $_POST['bankname'] ."', totalamount = '-". $_POST['amount'] ."' ". $transdate . $xdate .";", $connection);
							if($res == true){
								echo "1|Transaction successfully proccessed.".$_POST['orno'];
							}else{
								echo "2|Failed to process transaction.";
							}
						}
					}
				}else if($_POST['PaymentType'] == "CREDIT CARD"){
					$payment = 0;
					$sukli = 0;

					if($_POST['selected'] == ""){
						$rescreditpayment = mysql_query("INSERT INTO tbltransaction SET tenantid = '". $_POST['tenantid'] ."', xcode = '". $_POST['PaymentTypeID'] ."', description = '". $PaymentType['PaymentTypeDesc'] ."', amount = '-". $_POST['amount'] ."', qty = '1', paymentamount = '-". $_POST['amount'] ."', balance = '-". $_POST['amount'] ."', userid = '". $_SESSION['MMS-UserID'] ."', Machine_No = '". $Machine_No[0] ."', reference = '". $_POST['remarks'] ."', xdescription = '". $PaymentType['PaymentTypeDesc'] ."', paymenttype = '". $_POST['PaymentTypeID'] ."', cardtype = '". $_POST['cardtype'] ."', cardholder = '". $_POST['ccholder'] ."', ccno = '". $_POST['ccno'] ."', authno = '". $_POST['authno'] ."', secno = '". $_POST['secno'] ."', expdate = '". date('Y-m-d', strtotime($_POST['expdate'])) ."', orno = '". $_POST['orno'] ."', totalamount = '-". $_POST['amount'] ."' ". $transdate . $xdate .";", $connection);
						if($rescreditpayment == true){
							echo "1|Transaction successfully proccessed.|".$_POST['orno'];
						}else{
							echo "2|Failed to process transaction.";
						}
					}else{
						$listahan = explode("|", $_POST['selected']);
						for($i=0; $i <= COUNT($listahan)-2; $i++){ 
							$arr = explode("#", $listahan[$i]);
							$payment += $arr[1];
							$sukli = floatval($_POST['amount']) - $payment;
							$resupdatebal = mysql_query("UPDATE tbltransaction SET paymentamount = '-" . $arr[1] . "', balance = '" . $arr[2] . "' WHERE tenantid = '" . $_POST['tenantid'] . "' AND id = '" . $arr[0] . "';", $connection);
							if($resupdatebal == true){
								echo "1|Charges successfully paid.|".$_POST['orno'];
								$PaymentInfo = mysql_fetch_array(mysql_query("SELECT tenantid, xcode, description, amount, qty, paymentamount, vatamount, balance, xdate, reference, totalamount FROM tbltransaction WHERE id = '". $arr[0] ."';", $connection));
							 	$getMall = mysql_fetch_array(mysql_query("SELECT a.mallID FROM tbltrans_tenants AS a LEFT JOIN tblref_mall AS b ON a.mallID = b.mallid WHERE a.TenantID = '". $PaymentInfo['tenantid'] ."';", $connection));
							 	$InsertAppLog = mysql_query("INSERT INTO tbltrans_paymentapplogs SET TenantID = '". $PaymentInfo['tenantid'] ."', MallID = '". $getMall['mallID'] ."', xcode = '". $PaymentInfo['xcode'] ."', description = '". $PaymentInfo['description'] ."', qty = '". $PaymentInfo['qty'] ."', xdate = '". $PaymentInfo['xdate'] ."', PaymentAmount = '". $PaymentInfo['paymentamount'] ."', PaymentOR = '". $_POST['orno'] ."', Amount = '". $PaymentInfo['amount'] ."', VATAmount = '". $PaymentInfo['vatamount'] ."', TotalAmount = '". $PaymentInfo['totalamount'] ."', Balance = '". $PaymentInfo['balance'] ."', Reference = '". $PaymentInfo['reference'] ."', UserID = '". $_SESSION['MMS-UserID'] ."', PaymentTypeID = '". $_POST['PaymentTypeID'] ."', PaymentTypeDesc = '". $PaymentType['PaymentTypeDesc'] ."';", $connection);
							}else{
								echo "2|Failed to settle charges.";
							}
						}
						if($sukli >= 0){
							$res = mysql_query("INSERT INTO tbltransaction SET tenantid = '". $_POST['tenantid'] ."', xcode = '". $_POST['PaymentTypeID'] ."', description = '". $PaymentType['PaymentTypeDesc'] ."', amount = '-". $_POST['amount'] ."', qty = '1', paymentamount = '-". $sukli ."', balance = '-". $sukli ."', userid = '". $_SESSION['MMS-UserID'] ."', Machine_No = '". $Machine_No[0] ."', reference = '". $_POST['remarks'] ."', xdescription = '". $PaymentType['PaymentTypeDesc'] ."', orno = '". $_POST['orno'] ."', paymenttype = '". $_POST['PaymentTypeID'] ."', cardtype = '". $_POST['cardtype'] ."', cardholder = '". $_POST['ccholder'] ."', ccno = '". $_POST['ccno'] ."', authno = '". $_POST['authno'] ."', secno = '". $_POST['secno'] ."', expdate = '". date('Y-m-d', strtotime($_POST['expdate'])) ."', totalamount = '-". $_POST['amount'] ."' ". $transdate . $xdate .";", $connection);
							if($res == true){
								echo "1|Transaction successfully proccessed.".$_POST['orno'];
							}else{
								echo "2|Failed to process transaction.";
							}
						}
					}
				}else if($_POST['PaymentType'] == "BANK DEPOSIT"){
					$payment = 0;
					$sukli = 0;

					if($_POST['selected'] == ""){
						$resbanktransferpayment = mysql_query("INSERT INTO tbltransaction SET tenantid = '". $_POST['tenantid'] ."', xcode = '". $_POST['PaymentTypeID'] ."', description = '". $PaymentType['PaymentTypeDesc'] ."', amount = '-". $_POST['amount'] ."', qty = '1', paymentamount = '-". $_POST['amount'] ."', balance = '-". $_POST['amount'] ."', userid = '". $_SESSION['MMS-UserID'] ."', Machine_No = '". $Machine_No[0] ."', reference = '". $_POST['remarks'] ."', paymenttype = '". $_POST['PaymentTypeID'] ."', bnkfrom = '". $_POST['namefrom'] ."', bnkto = '". $_POST['nameto'] ."', accnofrom = '". $_POST['accfrom'] ."', accnoto = '". $_POST['accto'] ."', xdescription = '". $PaymentType['PaymentTypeDesc'] ."', orno = '". $_POST['orno'] ."', totalamount = '-". $_POST['amount'] ."' ". $transdate . $xdate .";", $connection);
						if($resbanktransferpayment == true){
							echo "1|Transaction successfully proccessed.|".$_POST['orno'];
						}else{
							echo "2|Failed to process transaction.";
						}
					}else{
						$listahan = explode("|", $_POST['selected']);
						for($i=0; $i <= COUNT($listahan)-2; $i++){ 
							$arr = explode("#", $listahan[$i]);
							$payment += $arr[1];
							$sukli = floatval($_POST['amount']) - $payment;
							$resupdatebal = mysql_query("UPDATE tbltransaction SET paymentamount = '-" . $arr[1] . "', balance = '" . $arr[2] . "' WHERE tenantid = '" . $_POST['tenantid'] . "' AND id = '" . $arr[0] . "';", $connection);
							if($resupdatebal == true){
								echo "1|Charges successfully paid.|".$_POST['orno'];
								$PaymentInfo = mysql_fetch_array(mysql_query("SELECT tenantid, xcode, description, amount, qty, paymentamount, vatamount, balance, xdate, reference, totalamount FROM tbltransaction WHERE id = '". $arr[0] ."';", $connection));
							 	$getMall = mysql_fetch_array(mysql_query("SELECT a.mallID FROM tbltrans_tenants AS a LEFT JOIN tblref_mall AS b ON a.mallID = b.mallid WHERE a.TenantID = '". $PaymentInfo['tenantid'] ."';", $connection));
							 	$InsertAppLog = mysql_query("INSERT INTO tbltrans_paymentapplogs SET TenantID = '". $PaymentInfo['tenantid'] ."', MallID = '". $getMall['mallID'] ."', xcode = '". $PaymentInfo['xcode'] ."', description = '". $PaymentInfo['description'] ."', qty = '". $PaymentInfo['qty'] ."', xdate = '". $PaymentInfo['xdate'] ."', PaymentAmount = '". $PaymentInfo['paymentamount'] ."', PaymentOR = '". $_POST['orno'] ."', Amount = '". $PaymentInfo['amount'] ."', VATAmount = '". $PaymentInfo['vatamount'] ."', TotalAmount = '". $PaymentInfo['totalamount'] ."', Balance = '". $PaymentInfo['balance'] ."', Reference = '". $PaymentInfo['reference'] ."', UserID = '". $_SESSION['MMS-UserID'] ."', PaymentTypeID = '". $_POST['PaymentTypeID'] ."', PaymentTypeDesc = '". $PaymentType['PaymentTypeDesc'] ."';", $connection);
							}else{
								echo "2|Failed to settle charges.";
							}
						}
						if($sukli >= 0){
							$res = mysql_query("INSERT INTO tbltransaction SET tenantid = '". $_POST['tenantid'] ."', xcode = '". $_POST['PaymentTypeID'] ."' description = '". $PaymentType['PaymentTypeDesc'] ."', amount = '-". $_POST['amount'] ."', qty = '1', paymentamount = '". $sukli ."', balance = '-". $sukli ."', userid = '". $_SESSION['MMS-UserID'] ."', Machine_No = '". $Machine_No[0] ."', reference = '". $_POST['remarks'] ."', orno = '". $_POST['orno'] ."', paymenttype = '". $_POST['PaymentTypeID'] ."', bnkfrom = '". $_POST['namefrom'] ."', bnkto = '". $_POST['nameto'] ."', accnofrom = '". $_POST['accfrom'] ."', accnoto = '". $_POST['accto'] ."', xdescription = '". $PaymentType['PaymentTypeDesc'] ."', totalamount = '-". $_POST['amount'] ."' ". $transdate . $xdate .";", $connection);
							if($res == true){
								echo "1|Transaction successfully proccessed.".$_POST['orno'];
							}else{
								echo "2|Failed to process transaction.";
							}
						}
					}
				}else{
					$payment = 0;
					$sukli = 0;

					if($_POST['selected'] == ""){
						$resinsertpayment = mysql_query("INSERT INTO tbltransaction SET tenantid = '". $_POST['tenantid'] ."', xcode = '". $_POST['PaymentTypeID'] ."', description = '". $PaymentType['PaymentTypeDesc'] ."', amount = '-". floatval($_POST['amount']) ."', totalamount = '-". floatval($_POST['amount']) ."',  paymentamount = '-". floatval($_POST['amount']) ."', paymenttype = '". $_POST['PaymentTypeID'] ."', userid = '". $_SESSION['MMS-UserID'] ."', Machine_No = '". $Machine_No[0] ."', balance = '-". floatval($_POST['amount']) ."', qty = '1', reference = '". $_POST['remarks'] ."', xdescription = '". $PaymentType['PaymentTypeDesc'] ."', orno = '". $_POST['orno'] ."' ". $transdate . $xdate .";", $connection);
						if($resinsertpayment == true){
							echo "1|Transaction successfully proccessed.|".$_POST['orno'];
						}else{
							echo "2|Failed to process transaction.";
						}
					}else{
						$listahan = explode("|", $_POST['selected']);
						for($i=0; $i <= COUNT($listahan)-2; $i++){ 
							$arr = explode("#", $listahan[$i]);
							$payment += $arr[1];
							$sukli = floatval($_POST['amount']) - $payment;
							$resupdatebal = mysql_query("UPDATE tbltransaction SET paymentamount = '-" . $arr[1] . "', balance = '" . $arr[2] . "' WHERE tenantid = '" . $_POST['tenantid'] . "' AND id = '" . $arr[0] . "';", $connection);
							if($resupdatebal == true){
								echo "1|Charges successfully paid.|".$_POST['orno'];
								$PaymentInfo = mysql_fetch_array(mysql_query("SELECT tenantid, xcode, description, amount, qty, paymentamount, vatamount, balance, xdate, reference, totalamount FROM tbltransaction WHERE id = '". $arr[0] ."';", $connection));
							 	$getMall = mysql_fetch_array(mysql_query("SELECT a.mallID FROM tbltrans_tenants AS a LEFT JOIN tblref_mall AS b ON a.mallID = b.mallid WHERE a.TenantID = '". $PaymentInfo['tenantid'] ."';", $connection));
							 	$InsertAppLog = mysql_query("INSERT INTO tbltrans_paymentapplogs SET TenantID = '". $PaymentInfo['tenantid'] ."', MallID = '". $getMall['mallID'] ."', xcode = '". $PaymentInfo['xcode'] ."', description = '". $PaymentInfo['description'] ."', qty = '". $PaymentInfo['qty'] ."', xdate = '". $PaymentInfo['xdate'] ."', PaymentAmount = '". $PaymentInfo['paymentamount'] ."', PaymentOR = '". $_POST['orno'] ."', Amount = '". $PaymentInfo['amount'] ."', VATAmount = '". $PaymentInfo['vatamount'] ."', TotalAmount = '". $PaymentInfo['totalamount'] ."', Balance = '". $PaymentInfo['balance'] ."', Reference = '". $PaymentInfo['reference'] ."', UserID = '". $_SESSION['MMS-UserID'] ."', PaymentTypeID = '". $_POST['PaymentTypeID'] ."', PaymentTypeDesc = '". $PaymentType['PaymentTypeDesc'] ."';", $connection);
							}else{
								echo "2|Failed to settle charges.";
							}
						}
						if($sukli >= 0){
							$ressukli = mysql_query("INSERT INTO tbltransaction SET tenantid = '". $_POST['tenantid'] ."', xcode = '". $_POST['PaymentTypeID'] ."', description = '". $PaymentType['PaymentTypeDesc'] ."', amount = '-". $_POST['amount'] ."', totalamount = '-". $_POST['amount'] ."', paymenttype = '". $_POST['PaymentTypeID'] ."', userid = '". $_SESSION['MMS-UserID'] ."', Machine_No = '". $Machine_No[0] ."', balance = '-". $sukli ."', paymentamount = '-". $_POST['amount'] ."', qty = '1', reference = '". $_POST['remarks'] ."', xdescription = '". $PaymentType['PaymentTypeDesc'] ."', orno = '". $_POST['orno'] ."' ". $transdate . $xdate .";", $connection);
						}
					}
				}
			}else{
				if($_POST['ReportType'] == "Yes"){
					echo "2|O.R number already exist.";
				}else{
					if($_POST['selected'] == ""){
						echo "2|Please select charges you want to pay.";
					}else{
						$payment = 0;
						$sukli = 0;
						$listahan = explode("|", $_POST['selected']);
						for($i=0; $i <= COUNT($listahan)-2; $i++){ 
							$arr = explode("#", $listahan[$i]);
							$payment += $arr[1];
							$sukli = floatval($_POST['amount']) - $payment;
							$resupdatebal = mysql_query("UPDATE tbltransaction SET paymentamount = '-" . $arr[1] . "', balance = '" . $arr[2] . "' WHERE tenantid = '" . $_POST['tenantid'] . "' AND id = '" . $arr[0] . "';", $connection);
							if($resupdatebal == true){
								echo "1|Charges successfully paid.|".$_POST['orno'];
								$PaymentInfo = mysql_fetch_array(mysql_query("SELECT tenantid, xcode, description, amount, qty, paymentamount, vatamount, balance, xdate, reference, totalamount FROM tbltransaction WHERE id = '". $arr[0] ."';", $connection));
							 	$getMall = mysql_fetch_array(mysql_query("SELECT a.mallID FROM tbltrans_tenants AS a LEFT JOIN tblref_mall AS b ON a.mallID = b.mallid WHERE a.TenantID = '". $PaymentInfo['tenantid'] ."';", $connection));
							 	$InsertAppLog = mysql_query("INSERT INTO tbltrans_paymentapplogs SET TenantID = '". $PaymentInfo['tenantid'] ."', MallID = '". $getMall['mallID'] ."', xcode = '". $PaymentInfo['xcode'] ."', description = '". $PaymentInfo['description'] ."', qty = '". $PaymentInfo['qty'] ."', xdate = '". $PaymentInfo['xdate'] ."', PaymentAmount = '". $PaymentInfo['paymentamount'] ."', PaymentOR = '". $_POST['orno'] ."', Amount = '". $PaymentInfo['amount'] ."', VATAmount = '". $PaymentInfo['vatamount'] ."', TotalAmount = '". $PaymentInfo['totalamount'] ."', Balance = '". $PaymentInfo['balance'] ."', Reference = '". $PaymentInfo['reference'] ."', UserID = '". $_SESSION['MMS-UserID'] ."', PaymentTypeID = '". $_POST['PaymentTypeID'] ."', PaymentTypeDesc = '". $PaymentType['PaymentTypeDesc'] ."';", $connection);
							}else{
								echo "2|Failed to settle charges.";
							}
						}
						if($sukli >= 0){
							$ressukli = mysql_query("UPDATE tbltransaction SET balance = '-". $sukli ."' WHERE orno = '". $_POST['orno'] ."';", $connection);
						}
					}
				}
			}
		break;

		case 'loadtblorlist':
   			$page = $_POST['page'];
			$limit = ($page-1) * 20;
			if($_POST['tenantid'] == "" || $_POST['tenantid'] == 'null' || $_POST['tenantid'] == 'undefined'){
				$maytenant = "AND TenantID = ''";
			}else{
				$maytenant = "AND TenantID = '". $_POST['tenantid'] ."' ";
			}

			if($_POST['PaymentType'] == "" || $_POST['PaymentType'] == 'null' || $_POST['PaymentType'] == 'undefined'){
				$paymenttype = " AND paymenttype = ''";
			}else{
				$paymenttype = " AND paymenttype = '". $_POST['PaymentType'] ."' ";
			}
   			$res = mysql_query("SELECT id, description, xdate, balance, orno, reference, transdate, image_file_name, amount, xcode FROM tbltransaction WHERE amount < 0 AND balance < 0 ". $maytenant . $paymenttype .";", $connection);
   			while($row = mysql_fetch_array($res)){

   				if($row['xdate'] == ""){
   					$date = date('m/d/Y', strtotime($row['transdate']));
   				}else{
   					$date = date('m/d/Y', strtotime($row['xdate']));
   				}

   				if($_POST['action'] == "select"){
   					echo "<tr onclick='selectcashorno(\"". $row['orno'] ."\", \"". number_format(str_replace("-", "", $row['balance']), 2, ".", ",") ."\", \"". $row['xcode']."|".$row['description'] ."\");'>";
   				}else{
   					echo "<tr>";
   				}

   				if($row['image_file_name'] == ""){
   					$btn = "";
   				}else{
   					$arr2 = explode(".", $row['image_file_name']);
	   				$FileTypes = array('bmp', 'jpg', 'jpeg', 'gif', 'png');
					if(in_array($arr2[1], $FileTypes)){
	                    $btn = "<a class='btn btn-sm btn-info btn-round' onclick='viewdocuimgindex(\"../Mall_Attachments/Billing/". $row['image_file_name'] ."\");' title='View Image'><i class='fa fa-eye'></i></a>";
	                }else{
	                    $btn = "<a href='../Mall_Attachments/Billing/". $row['image_file_name'] ."' download class='btn btn-sm btn-info btn-round' title='Download Attachment'><i class='fa fa-download'></i></a>";
	                }
   				}
   				echo "
   						<td>". $date ."</td>
   						<td>". $row['description'] ."</td>
   						<td>". $row['reference'] ."</td>
   						<td>". $row['orno'] ."</td>
   						<td style='text-align: right;'>". number_format(str_replace("-", "", $row['amount']), 2, ".", ",") ."</td>
   						<td style='text-align: right;'>". number_format(str_replace("-", "", $row['balance'] - $row['amount']), 2, ".", ",") ."</td>
   						<td style='text-align: right;'>". number_format(str_replace("-", "", $row['balance']), 2, ".", ",") ."</td>
   						<td style='text-align: center;'>". $btn ."</td>
   					</tr>";
   			}

   			$resExPayment = mysql_query("SELECT paymentdate, reference, orno, amount, balance FROM tbl_tenantspayments WHERE balance > 0 ". $maytenant . $paymenttype .";", $connection);
   			while($rowExPayment = mysql_fetch_array($resExPayment)){
   				$getPaymentTypeDesc = mysql_fetch_array(mysql_query("SELECT PaymentTypeDesc FROM tblref_pospaymenttype WHERE PaymentTypeID = '". $rowExPayment['xcode'] ."';", $connection));
   				if($_POST['action'] == "select"){
   					echo "<tr onclick='selectcashorno(\"". $rowExPayment['orno'] ."\", \"". number_format(str_replace("-", "", $rowExPayment['balance']), 2, ".", ",") ."\", \"". $rowExPayment['xcode']."|".$getPaymentTypeDesc['PaymentTypeDesc'] ."\");'>";
   				}else{
   					echo "<tr>";
   				}
   				echo "
   						<td>". date('m/d/Y', strtotime($rowExPayment['paymentdate'])) ."</td>
   						<td>". $rowExPayment['description'] ."</td>
   						<td>". $rowExPayment['reference'] ."</td>
   						<td>". $rowExPayment['orno'] ."</td>
   						<td style='text-align: right;'>". number_format(str_replace("-", "", $rowExPayment['amount']), 2, ".", ",") ."</td>
   						<td style='text-align: right;'>". number_format(str_replace("-", "", $rowExPayment['balance'] - $rowExPayment['amount']), 2, ".", ",") ."</td>
   						<td style='text-align: right;'>". number_format(str_replace("-", "", $rowExPayment['balance']), 2, ".", ",") ."</td>
   						<td></td>
   					</tr>";
   			}
		break;

		case 'loadentriesorlist':
           	if($_POST["page"] == ""){
               	$page = 1;
           	}else{
               	$page = $_POST["page"];
           	}

           	$limit = ($page-1) * 20;

           	if($_POST['tenantid'] == "" || $_POST['tenantid'] == 'null' || $_POST['tenantid'] == 'undefined'){
				$maytenant = "AND TenantID = ''";
			}else{
				$maytenant = "AND TenantID = '". $_POST['tenantid'] ."' ";
			}

            $sql = "SELECT COUNT(*) FROM tbltransaction WHERE isdeposit = '1' AND balance != '0.00'  AND balance LIKE '%-%' ". $maytenant .";";
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
        break;

		case "loadpageorlist":
		    $page = $_POST["page"];
		    if($_POST['tenantid'] == "" || $_POST['tenantid'] == 'null' || $_POST['tenantid'] == 'undefined'){
				$maytenant = "AND TenantID = ''";
			}else{
				$maytenant = "AND TenantID = '". $_POST['tenantid'] ."' ";
			}

	    	$sqlb = "SELECT COUNT(*) FROM tbltransaction WHERE isdeposit = '1' AND balance != '0.00'  AND balance LIKE '%-%' ". $maytenant .";";
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
			   echo "<li style='width:50px !important;' onclick='paginationorlist(1)'><< First</li>";
			   $prevpage = $page - 1;
			   echo "<li style='width:70px !important;' onclick='paginationorlist(". $prevpage .")'>< Previous</li>";
			}

			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if (($x > 0) && ($x <= $totalpages)){
				    if($x == $page){
	                    echo "<li id='ORListPage" . $x . "' class='ORListPageNum active' onclick='paginationorlist(" . $x . ",". $x .")'>" . $x . "</li>";
	                }else{
				        echo "<li id='ORListPage" . $x . "' class='ORListPageNum' onclick='paginationorlist(" . $x . ",". $x .")'>" . $x . "</li>";
	                }
		       }
		    }
		    if($page < ($totalpages - $range)){
	            echo "<li>...</li>";
	        }

		    if ($page != $totalpages && $num != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='paginationorlist(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='paginationorlist(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'gettblorinfo':
			$totalpayment = 0;
			$sqlorinfo = "SELECT description, paymentamount FROM tbltransaction WHERE orno = '". $_POST['orno'] ."';";
			$resorinfo = mysql_query($sqlorinfo, $connection);
			while($roworinfo = mysql_fetch_array($resorinfo)){
				echo 	"
						<tr>
							<td style='width=75%;'>".$roworinfo['description']."</td>
							<td style='text-align: right;width=25%;'>".number_format($roworinfo['paymentamount'], 2, '.', ',')."</td>
						</tr>
						";
				$totalpayment += floatval($roworinfo['paymentamount']);
			}
				echo 	"
							<tr>
								<td style='border-top: 1px solid black;width=75%;'>Total Amount</td>
								<td style='text-align: right;border-top: 1px solid black;width=25%;'>".number_format($totalpayment, 2, '.', ',')."</td>
							</tr>
						";

			$moreorinfo = mysql_fetch_array(mysql_query("SELECT xdatetime, transdate, paymenttype, userid, tenantid, id FROM tbltransaction WHERE orno = '". $_POST['orno'] ."' ORDER BY id DESC LIMIT 0,1", $connection));
			$tradename = mysql_fetch_row(mysql_query("SELECT tradename FROM tbltrans_tenants WHERE TenantID = '". $moreorinfo[4] ."'", $connection));
			$username = mysql_fetch_array(mysql_query("SELECT CONCAT(firstname, ' ', lastname) FROM tbluser WHERE userid = '". $moreorinfo[3] ."'", $connection));
			if($moreorinfo[1] == ""){
				$ordate = date('m/d/Y', strtotime($moreorinfo[0]));
			}else{
				$ordate = date('m/d/Y', strtotime($moreorinfo[1]));
			}

			echo "|" . $ordate . "|" . $moreorinfo[2] . "|" . $username[0] . "|" . $tradename[0] . "|" . date('m/d/Y') . "|" . $moreorinfo[4];
		break;

		case 'userlist':
			echo "<option value=''>-- Select User --</option>";
			$res = mysql_query("SELECT userid, CONCAT(firstname, ' ', LEFT(middlename, 1), ' ', lastname) FROM tbluser", $connection);
			while($row = mysql_fetch_array($res)){
				echo "<option value='".$row[0]."'>".$row[1]."</option>";
			}
		break;

		case 'tbluserlist':
			$res = mysql_query("SELECT userid, CONCAT(firstname, ' ', LEFT(middlename, 1), ' ', lastname) FROM tbluser;", $connection);
			while($row = mysql_fetch_array($res)){
				echo "	<tr>
							<td style='display: none;'><input type='checkbox' class='subcheckboxuserlist' value='". $row[0] ."'></td>
							<td>".$row[0]."</td>
							<td>".$row[1]."</td>
						</tr>
					";
			}
		break;

		case 'previewCa':
			// START OF FILTER BY USER
			if($_POST['user'] == ""){
				$users = $_POST['userlist'];
			}else{
				$users = $_POST['user'];
			}
			$arr = explode("|", $users);
			$userlist = "";
			$mn = 0;
			if(COUNT($arr) > 1){
				for ($m=0; $m <= count($arr)-2; $m++) { 
					$userlist .= "'" . $arr[$m] . "'" . ",";
					$mn++;
				}
			}else{
				$userlist = "'". $arr[0] ."''";
				$mn++;
			}

			if($mn > 0 && $userlist != "'''"){
				$userfilter = " AND (a.userid IN(". substr(trim($userlist), 0, -1) .")) ";
			}else{
				$userfilter = "";
			}
			// END OF FILTER BY USER

			// START OF FILTER BY PAYMENT TYPE
			if($_POST['paymenttype'] == ""){
				$paymenttypes = $_POST['paymenttypelist'];
			}else{
				$paymenttypes = $_POST['paymenttype'];
			}
			$arr2 = explode("|", $paymenttypes);
			$paymenttypelist = "";
			$jjdb = 0;
			if(COUNT($arr2) > 1){
				for ($j=0; $j <= count($arr2)-2; $j++) { 
					$paymenttypelist .= "'" . $arr2[$j] . "'" . ",";
					$jjdb++;
				}
			}else{
				$paymenttypelist = "'". $arr2[0] ."''";
				$jjdb++;
			}

			if($jjdb > 0 && $paymenttypelist != "'''"){
				$paymenttypefilter = " AND (a.paymenttype IN(". substr(trim($paymenttypelist), 0, -1) .")) ";
			}else{
				$paymenttypefilter = "";
			}
			// END OF FILTER BY PAYMENT TYPE

			// START OF DATE TIME FILTER
			if($_POST['timeFrom'] == ''){
				$timefrom = "00:00:00";
			}else{
				$timefrom = date('H:i:s', strtotime($_POST['timeFrom']));
			}

			if($_POST['timeTo'] == ''){
				$timeto = "23:59:59";
			}else{
				$timeto = date('H:i:s', strtotime($_POST['timeTo']));
			}

			$datefilter = "WHERE (a.xdatetime BETWEEN '". date('Y-m-d H:i:s', strtotime($_POST['dateFrom']." ".$timefrom)) ."' AND '". date('Y-m-d H:i:s', strtotime($_POST['dateTo']." ".$timeto)) ."') AND b.mallid = '". $_POST['mallid'] ."' ";
			// END OF DATE TIME FILTER

			$filter = $datefilter.$userfilter.$paymenttypefilter;
			$sql = " SELECT b.tradename, a.description, a.xdatetime, a.qty, CONCAT(c.firstname, ' ', LEFT(c.middlename, 1), ' ', c.lastname), a.amount, a.vatamount, (a.amount + a.vatamount) FROM tbltransaction AS A INNER JOIN tbltrans_tenants AS b ON a.tenantid = b.tenantid INNER JOIN tbluser AS C ON a.userid = c.userid ".$filter." ";
			$res = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($res)){
				echo "	<tr>
								<td>".$row[0]."</td>
								<td>".$row[1]."</td>
								<td>".$row[2]."</td>
								<td>".$row[3]."</td>
								<td>".$row[4]."</td>
								<td style='text-align: center;'>".number_format($row[5], "2", ".", ",")."</td>
								<td style='text-align: center;'>".number_format($row[6], "2", ".", ",")."</td>
								<td style='text-align: center;'>".number_format($row[7], "2", ".", ",")."</td>
							</tr>";
			}
		break;

		case 'previewCSV':
			// START OF FILTER BY USER
			if($_POST['user'] == ""){
				$users = $_POST['userlist'];
			}else{
				$users = $_POST['user'];
			}
			$arr = explode("|", $users);
			$userlist = "";
			$mn = 0;
			if(COUNT($arr) > 1){
				for ($m=0; $m <= count($arr)-2; $m++) { 
					$userlist .= "'" . $arr[$m] . "'" . ",";
					$mn++;
				}
			}else{
				$userlist = "'". $arr[0] ."''";
				$mn++;
			}

			if($mn > 0 && $userlist != "'''"){
				$userfilter = " AND (a.userid IN(". substr(trim($userlist), 0, -1) .")) ";
			}else{
				$userfilter = "";
			}
			// END OF FILTER BY USER

			// START OF FILTER BY PAYMENT TYPE
			if($_POST['paymenttype'] == ""){
				$paymenttypes = $_POST['paymenttypelist'];
			}else{
				$paymenttypes = $_POST['paymenttype'];
			}
			$arr2 = explode("|", $paymenttypes);
			$paymenttypelist = "";
			$jjdb = 0;
			if(COUNT($arr2) > 1){
				for ($j=0; $j <= count($arr2)-2; $j++) { 
					$paymenttypelist .= "'" . $arr2[$j] . "'" . ",";
					$jjdb++;
				}
			}else{
				$paymenttypelist = "'". $arr2[0] ."''";
				$jjdb++;
			}

			if($jjdb > 0 && $paymenttypelist != "'''"){
				$paymenttypefilter = " AND (a.paymenttype IN(". substr(trim($paymenttypelist), 0, -1) .")) ";
			}else{
				$paymenttypefilter = "";
			}
			// END OF FILTER BY PAYMENT TYPE

			// START OF DATE TIME FILTER
			if($_POST['timeFrom'] == ''){
				$timefrom = "00:00:00";
			}else{
				$timefrom = date('H:i:s', strtotime($_POST['timeFrom']));
			}

			if($_POST['timeTo'] == ''){
				$timeto = "23:59:59";
			}else{
				$timeto = date('H:i:s', strtotime($_POST['timeTo']));
			}

			$datefilter = "WHERE (a.xdatetime BETWEEN '". date('Y-m-d H:i:s', strtotime($_POST['dateFrom']." ".$timefrom)) ."' AND '". date('Y-m-d H:i:s', strtotime($_POST['dateTo']." ".$timeto)) ."') AND b.mallid = '". $_POST['mallid'] ."'";
			// END OF DATE TIME FILTER

			$filter = $datefilter.$userfilter.$paymenttypefilter;
			$sql = " SELECT b.tradename, a.description, a.xdatetime, a.qty, CONCAT(c.firstname, ' ', LEFT(c.middlename, 1), ' ', c.lastname), a.amount, a.vatamount, (a.amount + a.vatamount) FROM tbltransaction AS A INNER JOIN tbltrans_tenants AS b ON a.tenantid = b.tenantid INNER JOIN tbluser AS C ON a.userid = c.userid ".$filter." ";
			$res = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($res)){
				echo "	<tr>
								<td>".$row[0]."</td>
								<td>".$row[1]."</td>
								<td>".$row[2]."</td>
								<td>".$row[3]."</td>
								<td>".$row[4]."</td>
								<td style='text-align: center;'>".$row[5]."</td>
								<td style='text-align: center;'>".$row[6]."</td>
								<td style='text-align: center;'>".$row[7]."</td>
							</tr>";
			}
			echo "|"."Cashier's Audit ".date('F d, Y').".csv";
		break;

		case 'showTenantList':
			$title = mysql_fetch_array(mysql_query("SELECT softwaretype FROM tblsys_setup;", $connection));
			if($title[0] == "5"){
				$label =  "Buyer";
			}else{
				$label =  "Tenant";
			}
			echo "<option value=''>-- Select ". $label ." --</option>";
 			$res = mysql_query("SELECT TenantID, tradename FROM tbltrans_tenants WHERE (Status = 'Active' OR Status = 'ForEviction' OR Status = 'ForRenewal') AND ustatus = 'Occupied' ". getMallAccess("mallID", "AND") .";", $connection);
 			while($row = mysql_fetch_array($res)){
 				echo "<option value='". $row[0] ."'>".$row[1]."</option>";
 			}
		break;

		case 'showUnitList':
 			echo "<option value=''>-- Select Unit --</option>";
 			$res = mysql_query("SELECT unitid, unitname FROM tblref_unit WHERE Status = 'Occupied' ". getMallAccess("mallid", "AND") .";", $connection);
 			while($row = mysql_fetch_array($res)){
 				echo "<option value='". $row[0] ."'>".$row[1]."</option>";
 			}
		break;

		case 'loadBillingPeriod':
			$res = mysql_query("SELECT BillMonth, BillYear, StartDate, EndDate, DueDate, soaid FROM tblref_billperiod", $connection);
			while($row = mysql_fetch_array($res)){
				echo 	"<tr id='tr-". $row['soaid'] ."' onclick='fncBPisClicked(\"". $row['soaid'] ."\")'>
							<td>". date('F Y', strtotime($row['BillYear'] . "-" . $row['BillMonth'] . "-01")) ."</td>
							<td>". date('m/d/Y', strtotime($row['StartDate'])) ."</td>
							<td>". date('m/d/Y', strtotime($row['EndDate'])) ."</td>
							<td>". date('m/d/Y', strtotime($row['DueDate'])) ."</td>
						</tr>";
			}
		break;

		case 'fncBPisClicked':
			$BPInfo = mysql_fetch_array(mysql_query("SELECT BillMonth, BillYear, DueDate FROM tblref_billperiod WHERE soaid = '". $_POST['SoAID'] ."';", $connection));
			echo $BPInfo['BillMonth'] . "|" . $BPInfo['BillYear'] . "|" . date('m/d/Y', strtotime($BPInfo['DueDate']));
		break;

		case 'FillBillDates':
			$BillingPeriod = mysql_fetch_array(mysql_query("SELECT StartDate, EndDate, DueDate FROM tblref_billperiod WHERE soaid = '". $_POST['BillingPeriod'] ."';", $connection));

			if($BillingPeriod['StartDate'] == "" || $BillingPeriod['StartDate'] == "1970-01-01"){
				$StartDate = "";
			}else{
				$StartDate = date('m/d/Y', strtotime($BillingPeriod['StartDate']));
			}

			if($BillingPeriod['EndDate'] == "" || $BillingPeriod['EndDate'] == "1970-01-01"){
				$EndDate = "";
			}else{
				$EndDate = date('m/d/Y', strtotime($BillingPeriod['EndDate']));
			}

			if($BillingPeriod['DueDate'] == "" || $BillingPeriod['DueDate'] == "1970-01-01"){
				$DueDate = "";
			}else{
				$DueDate = date('m/d/Y', strtotime($BillingPeriod['DueDate']));
			}

			echo $StartDate . "|" . $EndDate . "|" . $DueDate . "|";
		break;

		case 'SaveNewBillPeriod':
			if($_POST['SoAID'] == ""){
				$ifExisting = mysql_num_rows(mysql_query("SELECT id FROM tblref_billperiod WHERE BillMonth = '". $_POST['Month'] ."' AND BillYear = '". $_POST['Year'] ."';", $connection));
				if($ifExisting == 0){
					$StartDate = date('Y-m-d', strtotime($_POST['Year'] . "-" . str_pad($_POST['Month'], 2, 0, STR_PAD_LEFT) . "-01"));
					$EndDate = date('Y-m-d', strtotime($_POST['Year'] . "-" . str_pad($_POST['Month'], 2, 0, STR_PAD_LEFT) . "-" . date('t', strtotime($StartDate))));
					if($EndDate <= date('Y-m-d', strtotime($_POST['DueDate']))){
						$SOANo = createctrlno("", "tblref_billperiod", "soaid");
						$SOAID = SysLeaseSetup('mallprefix') . "-" . $_POST['Year'] . "-" . str_pad($_POST['Month'], 2, 0, STR_PAD_LEFT) . "-" . $SOANo;
						$res = mysql_query("INSERT INTO tblref_billperiod SET soaid = '". $SOAID ."', BillMonth = '". $_POST['Month'] ."', BillYear = '". $_POST['Year'] ."', StartDate = '". date('Y-m-d', strtotime($StartDate)) ."', EndDate = '". date('Y-m-d', strtotime($EndDate)) ."', DueDate = '". date('Y-m-d', strtotime($_POST['DueDate'])) ."';", $connection);
						if($res == true){
							echo "1|Billing period successfully saved.";
						}
					}else{
						echo "3|Billing period must be less than the due date.";
					}
				}else{
					echo "4|Billing period with selected month and year already exist.";
				}
			}else{
				$isitPRocessed = mysql_fetch_array(mysql_query("SELECT Processed FROM tblref_billperiod WHERE soaid = '". $_POST['SoAID'] ."';", $connection));
				if($isitPRocessed['Processed'] == "0"){
					$res = mysql_query("UPDATE tblref_billperiod SET DueDate = '". date('Y-m-d', strtotime($_POST['DueDate'])) ."' WHERE soaid = '". $_POST['SoAID'] ."';", $connection);
					if($res == true){
						echo "2|Billing period successfully updated.";
					}
				}else{
					echo "5|Billing period is already processed.";
				}
			}
		break;

		case 'loadtxtBillingPeriod':
			$getFirstProcess = mysql_fetch_array(mysql_query("SELECT id FROM tblref_billperiod WHERE Processed = '1' ". getMallAccess("mallID", "AND") ." ORDER BY DueDate LIMIT 1;", $connection));
			if($getFirstProcess['id'] == ""){
				$FirstProcessed = "";
			}else{
				$FirstProcessed = "AND id >= '". $getFirstProcess['id'] ."'";
			}
			$PrevStat = 0;
			echo "<option>-- Select Period --</option>";
			$res = mysql_query("SELECT soaid, BillMonth, BillYear, Processed, Posted FROM tblref_billperiod WHERE Posted = '0' ". $FirstProcessed ." ". getMallAccess("mallID", "AND") .";", $connection);
			while($row = mysql_fetch_array($res)){
				echo "<option value='". $row['soaid'] ."'>". date('F Y', strtotime($row['BillYear'] . "-" . $row['BillMonth'] . "-01")) ."</option>";
			}
		break;

		case 'fncLoadPrevPeriods':
			$res = mysql_query("SELECT soaid, StartDate, EndDate, DueDate, Posted FROM tblref_billperiod WHERE Processed = '1' ". getMallAccess("mallID", "AND") ." ORDER BY DueDate ASC;", $connection);
			while($row = mysql_fetch_array($res)){
				if($row['Posted'] == '1'){
					$SOAStatus = "<span class='label label-lg label-success arrowed-in-right arrowed' style='z-index: 0;'>Posted</span>";
				}else{
					$SOAStatus = "<span class='label label-lg label-warning arrowed-in-right arrowed' style='z-index: 0;'>Not Posted</span>";
				}
				echo 	"<tr onclick='fncShowSOAList(\"". $row['soaid'] ."\", \"". date('m/d/Y', strtotime($row["StartDate"])) . " - " . date('m/d/Y', strtotime($row["EndDate"])) ."\", \"". $row['Posted'] ."\")' id='trPrev". $row['soaid'] ."'>
							<td> From: ". date('m/d/Y', strtotime($row['StartDate'])) ."</br>To: ". date('m/d/Y', strtotime($row['EndDate'])) ."</td>
							<td>". date('m/d/Y', strtotime($row['DueDate'])) ."</td>
							<td>". $SOAStatus ."</td>
						</tr>";
			}
		break;

		case 'fncShowSOAList':
			if($_POST['TenantID'] == ""){
				$WithTenant = "";
			}else{
				$WithTenant = "AND tenantid = '". $_POST['TenantID'] ."'";
			}

			$mgaMeron = "";
			$resTenant = mysql_query("SELECT TenantID, TenantName, startDate FROM tblref_unit WHERE Status = 'Occupied' AND CASE WHEN BillingSetup = 'Individual' THEN BillingSetup = 'Individual' ELSE (MainUnit IS NULL OR MainUnit = '') END ". $WithTenant .";", $connection);
			while($rowTenant = mysql_fetch_array($resTenant)){
				$mgaMeron .= "'" . $rowTenant['TenantID'] . "'" . ",";
			}

			if($mgaMeron == ""){
				$TenantList = "";
			}else{
				$TenantList = " AND TenantID IN (". substr(trim($mgaMeron), 0, -1) .")";
			}
			$CurrentBalance = 0;
			$res = mysql_query("SELECT tenantid, tenantname, Currbal, ctrlno, soaid FROM dunn_tblsoaheader WHERE soaid = '". $_POST['soaid'] ."' ORDER BY ctrlno;", $connection);
			while($row = mysql_fetch_array($res)){
				$MaxID = "";
				$str = strlen($row["ctrlno"]);
				if($str == 1){ 
					$MaxID = "000" . $row["ctrlno"]; 
				}else if($str == 2){ 
					$MaxID = "00" . $row["ctrlno"]; 
				}else if($str == 3){ 
					$MaxID = "0" . $row["ctrlno"]; 
				}else{ 
					$MaxID = $row["ctrlno"]; 
				}
				echo 	"<tr>
							<td style='display: none;'><input name='form-field-checkbox' type='checkbox' class='chkprintsoatenant' value='". $row['tenantid'] ."' style='z-index: 0;'></td>
							<td style='vertical-align: middle;' class='tdSoA_Click'>". $MaxID ."</td>
							<td style='vertical-align: middle;' class='tdSoA_Click'>". $row['tenantid'] ."</td>
							<td style='vertical-align: middle;' class='tdSoA_Click'>". $row['tenantname'] ."</td>
							<td style='vertical-align: middle;text-align: right;' class='tdSoA_Click'>". number_format($row['Currbal'], 2, '.', ',') ."</td>
							<td style='vertical-align: middle;' class='center'><div class='btn-group'>
									<button class='btn btn-sm btn-info btn-round' title='Print Statement of Account' onclick='fncViewSOA(\"". $row['tenantid'] ."\", \"". $row['soaid'] ."\", \"View\")' style='margin: 2px;'><img src='assets/images/view.png' style='width: 100%; height: auto;' /></button>
									<button class='btn btn-sm btn-grey btn-round' title='Print Statement of Account' onclick='fncViewSOA(\"". $row['tenantid'] ."\", \"". $row['soaid'] ."\", \"Print\")' style='margin: 2px;'><img src='assets/images/printer.png' style='width: 100%; height: auto;' /></button>
								</div>
							</td>
						</tr>";
			}
		break;

		case 'getTenantInfo':
			$TenantInfo = mysql_fetch_array(mysql_query("SELECT tradename, CompanyID, BillerID, datefrom, dateto, tradeID from tbltrans_tenants where tenantid = '" . $_POST['tenantid'] . "';", $connection));
			
			$CompanyAddress = mysql_fetch_array(mysql_query("SELECT businessAddress from tbltrans_company where CompanyID = '" . $TenantInfo['CompanyID'] . "';", $connection));

			$SoAInfo = mysql_fetch_array(mysql_query("SELECT billno, soaperiod2 FROM dunn_tblsoaheader WHERE soaid = '". $_POST['soaid'] ."' AND tenantid = '". $_POST['tenantid'] ."';", $connection));

			$BillerInfo = mysql_fetch_array(mysql_query("SELECT BillerName, BillingAddress FROM tblref_billprofile WHERE BillerID = '". $TenantInfo['BillerID'] ."';", $connection));

			$getPrimaryContact = mysql_fetch_array(mysql_query("SELECT CASE WHEN MiddleName = '' OR MiddleName IS NULL THEN CONCAT(LastName, ', ', FirstName) ELSE CONCAT(LastName, ', ', FirstName, ' ', LEFT(MiddleName, '1'), '.') END FROM tbltrans_trade_contact_person WHERE tradeID = '". $TenantInfo['tradeID'] ."' AND isActive = '1' AND isPrimary = '1';", $connection));

			echo $TenantInfo['tradename'] . "|" . date('F d, Y', strtotime($SoAInfo["soaperiod2"])) . "|" . strtoupper($BillerInfo['BillerName']) . "|" . $SoAInfo['billno'] . "|" . strtoupper($BillerInfo['BillingAddress']) . "|" . date('F d, Y', strtotime($TenantInfo["datefrom"])) . "|" . $getPrimaryContact[0] . "|" . date('F d, Y', strtotime($TenantInfo["dateto"]));
		break;

    	case 'getCurrentCharges':
    		$BillingSetup = mysql_fetch_array(mysql_query("SELECT BillingSetup FROM tblref_unit WHERE tenantid = '". $_POST['tenantid'] ."';", $connection));
    		$resCurrentCharges = mysql_query("SELECT xcode, description, vatamount, amount, SUM(vatamount + amount), xdate, reference FROM dunn_tblsoadetails WHERE soaNo = '". $_POST['soaid'] ."' AND tenantid = '". $_POST['tenantid'] ."' AND (paymenttype IS NULL OR paymenttype = '') GROUP BY id;", $connection);
    		while($rowCurrentCharges = mysql_fetch_array($resCurrentCharges)){
    			echo "<tr>
						<td style='font-weight: normal;margin: 3px;font-size: 12px;padding-left: 10px;' align='left'>". date('m/d/Y', strtotime($rowCurrentCharges['xdate'])) . "</td>
						<td style='font-weight: normal;margin: 3px;font-size: 12px;' align='left'>". $rowCurrentCharges['reference'] ."</td>
						<td style='font-weight: normal;margin: 3px;font-size: 12px;' align='left'>". $rowCurrentCharges['description'] ."</td>
						<td style='font-weight: normal;margin: 3px;font-size: 12px;padding-right: 5px;' align='right'>". number_format($rowCurrentCharges['amount'], "2", ".", ",") ."</td>
						<td style='font-weight: normal;margin: 3px;font-size: 12px;padding-right: 5px;' align='right'>". number_format($rowCurrentCharges['vatamount'], "2", ".", ",") ."</td>
						<td style='font-weight: normal;margin: 3px;font-size: 12px;padding-right: 5px;' align='right'>". number_format($rowCurrentCharges[4], "2", ".", ",") ."</td>
					</tr>";
    		}
    	break;

    	case 'getOtherCharges':
    // 		$BillingSetup = mysql_fetch_array(mysql_query("SELECT BillingSetup FROM tblref_unit WHERE tenantid = '". $_POST['tenantid'] ."';", $connection));
    // 		if($BillingSetup['BillingSetup'] == "Merged"){
    // 			$getMainUnit = mysql_fetch_array(mysql_query("SELECT unitid FROM tbltrans_tenants WHERE TenantID = '". $_POST['tenantid'] ."';", $connection));
	   //  		$mgaMeron = "";
	   //  		$getSubUnits = mysql_query("SELECT TenantID FROM tblref_unit WHERE MainUnit = '". $getMainUnit['unitid'] ."';", $connection);
				// $SubUnitCount = mysql_num_rows($getSubUnits);
	   //  		while($rowSubUnits = mysql_fetch_array($getSubUnits)){
				// 	$mgaMeron .= "'" . $rowSubUnits['TenantID'] . "'" . ",";
	   //  		}

	   //  		if($SubUnitCount >= 1){
				// 	$TenantQuery = "(TenantID IN (". substr(trim($mgaMeron), 0, -1) .") OR TenantID = '". $_POST['tenantid'] ."')";
				// }else{
				// 	$TenantQuery = "TenantID = '". $rowUnit['TenantID'] ."'";
				// }

				// $resgetSoAHeader = mysql_query("SELECT billno, tenantid FROM dunn_tblsoaheader WHERE ". $TenantQuery ." AND soaid = '". $_POST['soaid'] ."';", $connection);
				// while($rowGetSoAHeader = mysql_fetch_array($resgetSoAHeader)){
	   //  			$SubTotal = 0;
		  //   		$resOtherCharges = mysql_query("SELECT xcode, description, SUM(vatamount + amount), xdate, reference, xdescription, qty FROM dunn_tblsoadetails WHERE soaNo = '". $_POST['soaid'] ."' AND tenantid = '". $rowGetSoAHeader['tenantid'] ."' AND paymenttype = '' AND (description NOT LIKE '%Rent%' AND description NOT LIKE '%Association Dues%' AND description NOT LIKE '%Penalty%') GROUP BY id;", $connection);
				// 	$rowNum = mysql_num_rows($resOtherCharges);
				// 	if($rowNum == 0){
				// 	}else{
		  //   			echo "<tr>
				// 				<td></td>
				// 				<td></td>
				// 				<td style='font-weight: bold;margin: 3px;font-size: 14px;' align='left'>". $rowGetSoAHeader['billno'] ."</td>
				// 				<td></td>
				// 			</tr>";
			 //    		while($resOtherCharges = mysql_fetch_array($resOtherCharges)){
			 //    			if($resOtherCharges['description'] == "Monthly Rent" || $resOtherCharges['description'] == "Daily Rent"){
			 //    				$ChargeDescription = $resOtherCharges['description'] ." - ". $resOtherCharges['xdescription'];
			 //    			}else{
			 //    				$ChargeDescription = $resOtherCharges['description'];
			 //    			}
			 //    			echo "<tr>
				// 					<td style='font-weight: normal;margin: 3px;font-size: 12px;padding-left: 10px;' align='left'>". date("m/d/Y", strtotime($resOtherCharges['xdate'])) . "</td>
				// 					<td style='font-weight: normal;margin: 3px;font-size: 12px;' align='left'>". $resOtherCharges['reference'] ."</td>
				// 					<td style='font-weight: normal;margin: 3px;font-size: 12px;' align='left'>". $ChargeDescription ."</td>
				// 					<td style='font-weight: normal;margin: 3px;font-size: 12px;padding-right: 5px;' align='right'>". number_format($resOtherCharges[2], "2", ".", ",") ."</td>
				// 				</tr>";
				// 			$SubTotal += $resOtherCharges[2];
			 //    		}
			 //    		echo "<tr>
				// 				<td></td>
				// 				<td></td>
				// 				<td style='font-weight: normal;margin: 3px;font-size: 12px;' align='left'>Sub-total</td>
				// 				<td style='border-top: 1px solid black;font-weight: bold;margin: 3px;font-size: 12x;' align='right'>". number_format($SubTotal, "2", ".", ",") ."</td>
				// 			</tr>";
			 //    	}
				// }
		  //   }else{
		    	$resOtherCharges = mysql_query("SELECT xcode, description, SUM(vatamount + amount), xdate, reference, xdescription, qty FROM dunn_tblsoadetails WHERE soaNo = '". $_POST['soaid'] ."' AND tenantid = '". $_POST['tenantid'] ."' AND paymenttype = '' AND (description NOT LIKE '%Rent%' AND description NOT LIKE '%Association Dues%' AND description NOT LIKE '%Penalty%') GROUP BY id;", $connection);
	    		while($resOtherCharges = mysql_fetch_array($resOtherCharges)){
	    			if($resOtherCharges['description'] == "Monthly Rent" || $resOtherCharges['description'] == "Daily Rent"){
	    				$ChargeDescription = $resOtherCharges['description'] ." - ". $resOtherCharges['xdescription'];
	    			}else{
	    				$ChargeDescription = $resOtherCharges['description'];
	    			}
	    			echo "<tr>
							<td style='font-weight: normal;margin: 3px;font-size: 12px;padding-left: 10px;' align='left'>". date("m/d/Y", strtotime($resOtherCharges['xdate'])) . "</td>
							<td style='font-weight: normal;margin: 3px;font-size: 12px;' align='left'>". $resOtherCharges['reference'] ."</td>
							<td style='font-weight: normal;margin: 3px;font-size: 12px;' align='left'>". $ChargeDescription ."</td>
							<td style='font-weight: normal;margin: 3px;font-size: 12px;padding-right: 5px;' align='right'>". number_format($resOtherCharges[2], "2", ".", ",") ."</td>
						</tr>";
	    		}
		    // }
    	break;

    	case 'getPayments':
    		$sql_get_due = mysql_fetch_array(mysql_query("SELECT duedate, soaperiod FROM dunn_tblsoaheader WHERE soaid = '". $_POST['soaid'] ."';", $connection));
			$TenantQuery = "TenantID = '". $_POST['tenantid'] ."'";
    		$resPayment = mysql_query("SELECT xcode, description, amount, qty, balance, xdate, reference, xdescription FROM dunn_tblsoadetails WHERE tenantid = '". $_POST['tenantid'] ."' AND (paymenttype IS NOT NULL AND paymenttype != '') AND xdate BETWEEN '".date("Y-m-d", strtotime($sql_get_due["soaperiod"]))."' AND '".date("Y-m-d", strtotime($sql_get_due["duedate"]))."';", $connection);
    		while($rowPayment = mysql_fetch_array($resPayment)){
    			echo "<tr>
						<td style='font-weight: normal;margin: 3px;font-size: 12px;padding-left: 10px;' align='left'>" . date("m/d/Y", strtotime($rowPayment[5])) . "</td>
						<td style='font-weight: normal;margin: 3px;font-size: 12px;' align='left'>" . $rowPayment[6] ."</td>
						<td style='font-weight: normal;margin: 3px;font-size: 12px;' align='left'>" . $rowPayment[1] ."</td>
						<td style='font-weight: normal;margin: 3px;font-size: 12px;padding-right: 5px;' align='right'>" . number_format(str_replace("-", "", $rowPayment[2]), "2", ".", ",") ."</td>
						<td style='font-weight: normal;margin: 3px;font-size: 12px;padding-right: 5px;' align='right'>0.00</td>
						<td style='font-weight: normal;margin: 3px;font-size: 12px;padding-right: 5px;' align='right'>" . number_format(str_replace("-", "", $rowPayment[2]), "2", ".", ",") ."</td>
					</tr>";
    		}
    	break;

    	case 'getBreakdowns':
			$TenantQuery = "AND TenantID = '". $_POST['tenantid'] ."'";

			$SoAHeader = mysql_fetch_array(mysql_query("SELECT SUM(currcharg), SUM(penchrg), SUM(Forwbal), SUM(payment) FROM dunn_tblsoaheader WHERE soaid = '". $_POST["soaid"] ."' ". $TenantQuery .";", $connection));

			$PrevBalance = mysql_fetch_array(mysql_query("SELECT SUM(b13 + b36 + b69 + b99) FROM dunn_tblsoaheader WHERE soaid = '". $_POST["soaid"] ."' ". $TenantQuery .";", $connection));

    		$TotalCurrentCharges = mysql_fetch_array(mysql_query("SELECT SUM(amount), SUM(vatamount), SUM(totalamount) FROM dunn_tblsoadetails WHERE soano = '". $_POST['soaid'] ."' ". $TenantQuery ." AND (paymenttype IS NULL OR paymenttype = '');", $connection));

    		$totalpayment = mysql_fetch_array(mysql_query("SELECT SUM(totalamount) FROM dunn_tblsoadetails WHERE soano = '". $_POST['soaid'] ."' ". $TenantQuery ." AND (paymenttype IS NOT NULL AND paymenttype != '');", $connection));

    		$AmountDue = floatval((floatval($SoAHeader[2]) + floatval($SoAHeader[1]) + floatval($SoAHeader[0])) - floatval(str_replace("-", "", $SoAHeader[3])));

    		if($AmountDue <= 0){
				$AmountDue = 0;
    		}else{
				$AmountDue = $AmountDue;
    		}

    		if(str_replace("-", "", $totalpayment[0]) >= 1){
    			$TotalPaymentAmount = "(". number_format(str_replace("-", "", $totalpayment[0]), "2", ".", ",") .")";
    		}else{
    			$TotalPaymentAmount = "0.00";
    		}

			echo number_format($PrevBalance[0], "2", ".", ",") . "|" . number_format($TotalCurrentCharges[2], "2", ".", ",") . "|" . $TotalPaymentAmount . "|" . number_format($SoAHeader['penchrg'], "2", ".", ",") . "|" . number_format($AmountDue, "2", ".", ",") . "|" . number_format($TotalCurrentCharges[0], "2", ".", ",") . "|" . number_format($TotalCurrentCharges[1], "2", ".", ",");
    	break;    

    	case 'getAging':
    		$BillingSetup = mysql_fetch_array(mysql_query("SELECT BillingSetup FROM tblref_unit WHERE tenantid = '". $_POST['tenantid'] ."';", $connection));
    		if($BillingSetup['BillingSetup'] == "Merged"){
    			$getMainUnit = mysql_fetch_array(mysql_query("SELECT unitid FROM tbltrans_tenants WHERE TenantID = '". $_POST['tenantid'] ."';", $connection));
    			$mgaMeron = "";
	    		$getSubUnits = mysql_query("SELECT TenantID FROM tblref_unit WHERE MainUnit = '". $getMainUnit['unitid'] ."';", $connection);
				$SubUnitCount = mysql_num_rows($getSubUnits);
	    		while($rowSubUnits = mysql_fetch_array($getSubUnits)){
					$mgaMeron .= "'" . $rowSubUnits['TenantID'] . "'" . ",";
	    		}

	    		if($SubUnitCount >= 1){
					$TenantQuery = "(TenantID IN (". substr(trim($mgaMeron), 0, -1) .") OR TenantID = '". $_POST['tenantid'] ."') AND";
				}else{
					$TenantQuery = "TenantID = '". $rowUnit['TenantID'] ."' AND";
				}
			}else{
				$TenantQuery = "TenantID = '". $_POST['tenantid'] ."' AND";
			}
    		$row = mysql_fetch_array(mysql_query("SELECT SUM(b00), SUM(b13), SUM(b36), SUM(b69), SUM(b99), SUM(currcharg) FROM dunn_tblsoaheader WHERE ". $TenantQuery ." soaid = '". $_POST['soaid'] ."';", $connection));

    		if($row[0] == "0"){
    			$b00 = $row[5];
    		}else{
    			$b00 = $row[0];
    		}

    			echo number_format($b00, "2", ".", ",") ."|". number_format($row[1], "2", ".", ",") ."|" .number_format($row[2], "2", ".", ",") ."|". number_format($row[3], "2", ".", ",") ."|". number_format($row[4], "2", ".", ",");
   		break;

		case 'getSignatories':
			$mallid = mysql_fetch_array(mysql_query("SELECT mallid FROM tbltrans_tenants WHERE tenantid = '". $_POST['tenantid'] ."';", $connection));
			$signatories = mysql_fetch_array(mysql_query("SELECT prepby, chkdby, apprby, rcvdby FROM mall_setup WHERE mall_id = '". $mallid[0] ."';", $connection));
			$arr = explode("|", $signatories[0]);
				$prep = $arr[1]. " " .substr($arr[2], 0, 1). ". " .$arr[0]; 
			$arr2 = explode("|", $signatories[1]);
				$chkdby = $arr2[1]. " " .substr($arr2[2], 0, 1). ". " .$arr2[0];
			$arr3 = explode("|", $signatories[2]);
				$apprby = $arr3[1]. " " .substr($arr3[2], 0, 1). ". " .$arr3[0];
			$arr4 = explode("|", $signatories[3]);
				$rcvdby = $arr4[1]. " " .substr($arr4[2], 0, 1). ". " .$arr4[0];

			echo $prep . "#" . $chkdby . "#" . $apprby . "#" . $rcvdby;	
		break;

		case 'fncPreProcessSOA':
			$CheckPendingWO = mysql_num_rows(mysql_query("SELECT id FROM tblmaintenance_workorder WHERE postingstatus = 'Not Posted' AND xdate BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['DateTo'])) ."';", $connection));
			$CheckPendingViolations = mysql_num_rows(mysql_query("SELECT id FROM tblmaintenance_hrviolatorsheader WHERE isPosted = '0' AND xdate BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['DateTo'])) ."';", $connection));
			$PrevStat = mysql_fetch_array(mysql_query("SELECT Posted FROM tblref_billperiod WHERE DueDate < '". date('Y-m-d', strtotime($_POST['DueDate'])) ."' ORDER BY DueDate DESC LIMIT 1;", $connection));
			$getFirstProcess = mysql_fetch_array(mysql_query("SELECT id FROM tblref_billperiod WHERE Processed = '1' ". getMallAccess("mallID", "AND") ." ORDER BY DueDate LIMIT 1;", $connection));

			$CheckPeriodStat = mysql_fetch_array(mysql_query("SELECT Posted, Processed FROM tblref_billperiod WHERE soaid = '". $_POST['SoAID'] ."';", $connection));
			if($CheckPeriodStat['Posted'] == 1){
				echo "4|Statement of Accounts for this period is already posted and cannot be reprocessed anymore.|";
			}else{
				if($CheckPeriodStat['Processed'] == 0){
					if($CheckPendingWO == 0 && $CheckPendingViolations == 0){
						echo "1|";
					}else{
						echo "2|". floatval($CheckPendingWO) ."|". floatval($CheckPendingViolations);
					}
				}else{
					echo "3|Statement of Accounts for this period is already posted and cannot be reprocessed anymore.|";
				}
			}
		break;

		case 'fncProcessSOA':
			// if($_POST['TenantID'] == ""){
			// 	$WithTenant = "";
			// }else{
			// 	$WithTenant = "AND a.TenantID = '". $_POST['TenantID'] ."'";
			// }

			// $CheckPeriodStat = mysql_fetch_array(mysql_query("SELECT Posted, Processed FROM tblref_billperiod WHERE soaid = '". $_POST['SoAID'] ."';", $connection));
			// if($CheckPeriodStat['Posted'] == 1){
			// 	echo "2|Statement of Accounts for this period is already posted and cannot be reprocessed anymore.|";
			// }else{
			// 	if($CheckPeriodStat['Processed'] == 0){
					$ctrlno = 0;
					$ctrlno2 = 0;
					$resGetActiveTenants = mysql_query("SELECT TenantID, tradename, merchant_code, monthly_dues, tenanttype, revpercent, mallID, inqID, datefrom, dateto, ActiveProposal, Beg_Balance, Beg_Date FROM tbltrans_tenants WHERE ". $WithTenant ." (datefrom >= '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND datefrom <= '". date('Y-m-d', strtotime($_POST['DateTo'])) ."' OR dateto >= '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND dateto <= '". date('Y-m-d', strtotime($_POST['DateTo'])) ."' OR datefrom < '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND datefrom < '". date('Y-m-d', strtotime($_POST['DateTo'])) ."' AND dateto > '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND dateto > '". date('Y-m-d', strtotime($_POST['DateTo'])) ."') AND (Status = 'Active' OR Status = 'ForEviction' OR Status = 'ForRenewal') AND ustatus = 'Occupied' ". getMallAccess("mallID", "AND") .";", $connection);
					while($rowActiveTenants = mysql_fetch_array($resGetActiveTenants)){

						$Days = (strtotime($_POST["DateTo"]) - strtotime($_POST["DateFrom"])) / (60 * 60 * 24) + 1;

						$ProposalInfo = mysql_fetch_array(mysql_query("SELECT monthlyDues, escalation_rate, year_start, year_basis, charges_list, vattype, vatpercent, isRent, proposalNum FROM tbltrans_proposal WHERE inquiryID = '". $rowActiveTenants['inqID'] ."' AND proposalNum = '". $rowActiveTenants['ActiveProposal'] ."';", $connection));
						$getSetup = explode("|", getrentvattype($rowActiveTenants['mallID']));
						$isVatable = $getSetup[1];
						$isInclusive = $getSetup[2];
						$VATPercent = floatval($getSetup[0]) / 100;

						$getEscalation = mysql_fetch_array(mysql_query("SELECT MAX(EscaTotal) FROM tbltrans_escalation WHERE InquiryID = '". $rowActiveTenants['inqID'] ."' AND ProposalNum = '". $ProposalInfo['proposalNum'] ."' AND STR_TO_DATE(EscaYear, '%M %Y') <= '". date('Y-m-d', strtotime($_POST['DateTo'])) ."';", $connection));
						$EscalatedRent = floatval($getEscalation[0]);

						if($EscalatedRent == 0){
							$MonthlyRent = floatval($rowActiveTenants['monthly_dues']);
						}else{
							$MonthlyRent = floatval($EscalatedRent);
						}

						// POSTING OF RENTAL CHARGES
						if($rowActiveTenants['tenanttype'] == 'Rent'){
			                $resCharges = mysql_query("SELECT tenantid from tbltransaction WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND xcode = 'Rent' AND isMerchant = '0' AND xdate BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['DateTo'])) ."';", $connection);
							$countCharges = mysql_num_rows($resCharges);
							if($countCharges === 0){

								if($ProposalInfo['isRent'] == "0"){
									if($isVatable == "yes"){
						                if($isInclusive == "inc"){ //VAT IS INCLUSIVE
						                    $VATAmount = ( floatval($MonthlyRent) / 1.12 ) * $VATPercent;
						                    $RentLessVAT = floatval($MonthlyRent) - $VATAmount;
						                    $Amount = $RentLessVAT;
											$VAT = $VATAmount;
						                    $TotalAmount = $VAT + $Amount;
						                }else{ //VAT IS EXCLUSIVE
						                    $VATAmount = floatval($MonthlyRent) * $VATPercent;
						                    $RentPlusVAT = floatval($MonthlyRent);
						                    $Amount = floatval($MonthlyRent);
						                    $VAT = $VATAmount;
						                    $TotalAmount = floatval($MonthlyRent) + $VATAmount;
						                }
						            }else{
						            	$Amount = $MonthlyRent;
						                $VAT = "0.00";
						                $TotalAmount = floatval($MonthlyRent);
						            }
					            }else{
					                $Amount = $MonthlyRent;
					                $VAT = "0.00";
					                $TotalAmount = floatval($MonthlyRent);
					            }
								$SaveTransaction = mysql_query("INSERT INTO tbltransaction SET tenantid = '". $rowActiveTenants["TenantID"] ."', description = 'Rent', amount = '". floatval($MonthlyRent) ."', vatamount = '". $VAT ."', balance = '". $TotalAmount ."', totalamount = '". $TotalAmount ."', qty = 1, xdate = '". date("Y-m-d", strtotime($_POST['DateTo'])) ."', tenanttype = '". $rowActiveTenants["tenanttype"] ."', revpercent = '". $rowActiveTenants["revpercent"] ."', xdescription = 'Basic Rent/SQM', userid = '". $_SESSION['MMS-UserID'] ."', xcode = 'Rent', reference = 'Rent (". date('F Y', strtotime($_POST['DateTo'])) .")', Machine_No = '". SysLeaseSetup('Machine_No') ."', merchant_code = '". $rowActiveTenants['merchant_code'] ."', UnitID = '". $rowUnitList['UnitID'] ."';", $connection);
							}
			            }else if($rowActiveTenants['tenanttype'] == 'Fixed Rent'){
			                $resCharges = mysql_query("SELECT tenantid from tbltransaction WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND xcode = 'Rent' AND isMerchant = '0' AND xdate BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['DateTo'])) ."';", $connection);
							$countCharges = mysql_num_rows($resCharges);
							if($countCharges === 0){
								
								if($ProposalInfo['isRent'] == "0"){
									if($isVatable == "yes"){
						                if($isInclusive == "inc"){ //VAT IS INCLUSIVE
						                    $VATAmount = ( floatval($MonthlyRent) / 1.12 ) * $VATPercent;
						                    $RentLessVAT = floatval($MonthlyRent) - $VATAmount;
						                    $Amount = $RentLessVAT;
											$VAT = $VATAmount;
						                    $TotalAmount = $VAT + $Amount;
						                }else{ //VAT IS EXCLUSIVE
						                    $VATAmount = floatval($MonthlyRent) * $VATPercent;
						                    $RentPlusVAT = floatval($MonthlyRent);
						                    $Amount = floatval($MonthlyRent);
						                    $VAT = $VATAmount;
						                    $TotalAmount = floatval($MonthlyRent) + $VATAmount;
						                }
						            }else{
						            	$Amount = $MonthlyRent;
						                $VAT = "0.00";
						                $TotalAmount = floatval($MonthlyRent);
						            }
					            }else{
						                $Amount = $MonthlyRent;
						                $VAT = "0.00";
						                $TotalAmount = floatval($MonthlyRent);
					            }
								
								$SaveTransaction = mysql_query("INSERT INTO tbltransaction SET tenantid = '". $rowActiveTenants["TenantID"] ."', description = 'Rent', amount = '". floatval($MonthlyRent) ."', vatamount = '". $VAT ."', balance = '". $TotalAmount ."', totalamount = '". $TotalAmount ."', qty = 1, xdate = '". date("Y-m-d", strtotime($_POST['DateTo'])) ."', tenanttype = '". $rowActiveTenants["tenanttype"] ."', revpercent = '". $rowActiveTenants["revpercent"] ."', xdescription = 'Fixed Rent', userid = '". $_SESSION['MMS-UserID'] ."', xcode = 'Rent', reference = 'Rent (". date('F Y', strtotime($_POST['DateTo'])) .")', Machine_No = '". SysLeaseSetup('Machine_No') ."', merchant_code = '". $rowActiveTenants['merchant_code'] ."', UnitID = '". $rowUnitList['UnitID'] ."';", $connection);
							}
			            }else if($rowActiveTenants['tenanttype'] == 'Share Only'){
			                $resCharges = mysql_query("SELECT tenantid from tbltransaction WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND xcode = 'Rent' AND isMerchant = '0' AND xdate BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['DateTo'])) ."';", $connection);
							$countCharges = mysql_num_rows($resCharges);
							if($countCharges === 0){

								$TotalRevenue = mysql_fetch_array(mysql_query("SELECT SUM(". $tblSales[6] .") FROM ". $tblSales[0] ." WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND ". $tblSales[1] ." BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND  '". date('Y-m-d', strtotime($_POST['DateTo'])) ."';", $connection));
								$RevenuePercentage = floatval($TotalRevenue[0]) * (floatval($rowActiveTenants["revpercent"]) /100);

								if($ProposalInfo['isRent'] == "0"){
									if($isVatable == "yes"){
						                if($isInclusive == "inc"){ //VAT IS INCLUSIVE
						                    $VATAmount = ( floatval($RevenuePercentage) / 1.12 ) * $VATPercent;
						                    $RentLessVAT = floatval($RevenuePercentage) - $VATAmount;
						                    $Amount = $RentLessVAT;
											$VAT = $VATAmount;
						                    $TotalAmount = $VAT + $Amount;
						                }else{ //VAT IS EXCLUSIVE
						                    $VATAmount = floatval($RevenuePercentage) * $VATPercent;
						                    $RentPlusVAT = floatval($RevenuePercentage);
						                    $Amount = floatval($RevenuePercentage);
						                    $VAT = $VATAmount;
						                    $TotalAmount = floatval($RevenuePercentage) + $VATAmount;
						                }
						            }else{
						            	$Amount = $RevenuePercentage;
						                $VAT = "0.00";
						                $TotalAmount = floatval($RevenuePercentage);
						            }
					            }else{
					                $Amount = $RevenuePercentage;
					                $VAT = "0.00";
					                $TotalAmount = floatval($RevenuePercentage);
					            }
								
								$SaveTransaction = mysql_query("INSERT INTO tbltransaction SET tenantid = '". $rowActiveTenants["TenantID"] ."', description = 'Rent', amount = '". $RevenuePercentage ."', vatamount = '". $VAT ."', balance = '". $TotalAmount ."', totalamount = '". $TotalAmount ."', qty = 1, xdate = '". date("Y-m-d", strtotime($_POST['DateTo'])) ."', tenanttype = '". $rowActiveTenants["tenanttype"] ."', revpercent = '". $rowActiveTenants["revpercent"] ."', xdescription = '". $rowActiveTenants["revpercent"] ."% of Gross Sales', userid = '". $_SESSION['MMS-UserID'] ."', xcode = 'Rent', reference = '". $rowActiveTenants["revpercent"] ."% of ". number_format($TotalRevenue[0], "2", ".", ",") ." (". date('F Y', strtotime($_POST['DateTo'])) .")', Machine_No = '". SysLeaseSetup('Machine_No') ."', merchant_code = '". $rowActiveTenants['merchant_code'] ."', UnitID = '". $rowUnitList['UnitID'] ."';", $connection);
							}
			            }else if($rowActiveTenants['tenanttype'] == 'Share Only2'){
			                $resCharges = mysql_query("SELECT tenantid from tbltransaction WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND xcode = 'Rent' AND isMerchant = '0' AND xdate BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['DateTo'])) ."';", $connection);
							$countCharges = mysql_num_rows($resCharges);
							if($countCharges === 0){

								$TotalRevenue = mysql_fetch_array(mysql_query("SELECT SUM(". $tblSales[6] .") FROM ". $tblSales[0] ." WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND ". $tblSales[1] ." BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND  '". date('Y-m-d', strtotime($_POST['DateTo'])) ."';", $connection));
								$RevenuePercentage = floatval($TotalRevenue[0]) * (floatval($rowActiveTenants["revpercent"]) /100);

								if($ProposalInfo['isRent'] == "0"){
									if($isVatable == "yes"){
						                if($isInclusive == "inc"){ //VAT IS INCLUSIVE
						                    $VATAmount = ( floatval($RevenuePercentage) / 1.12 ) * $VATPercent;
						                    $RentLessVAT = floatval($RevenuePercentage) - $VATAmount;
						                    $Amount = $RentLessVAT;
											$VAT = $VATAmount;
						                    $TotalAmount = $VAT + $Amount;
						                }else{ //VAT IS EXCLUSIVE
						                    $VATAmount = floatval($RevenuePercentage) * $VATPercent;
						                    $RentPlusVAT = floatval($RevenuePercentage);
						                    $Amount = floatval($RevenuePercentage);
						                    $VAT = $VATAmount;
						                    $TotalAmount = floatval($RevenuePercentage) + $VATAmount;
						                }
						            }else{
						            	$Amount = $RevenuePercentage;
						                $VAT = "0.00";
						                $TotalAmount = floatval($RevenuePercentage);
						            }
					            }else{
					                $Amount = $RevenuePercentage;
					                $VAT = "0.00";
					                $TotalAmount = floatval($RevenuePercentage);
					            }
								
								$SaveTransaction = mysql_query("INSERT INTO tbltransaction SET tenantid = '". $rowActiveTenants["TenantID"] ."', description = 'Rent', amount = '". $RevenuePercentage ."', vatamount = '". $VAT ."', balance = '". $TotalAmount ."', totalamount = '". $TotalAmount ."', qty = 1, xdate = '". date("Y-m-d", strtotime($_POST['DateTo'])) ."', tenanttype = '". $rowActiveTenants["tenanttype"] ."', revpercent = '". $rowActiveTenants["revpercent"] ."', xdescription = '". $rowActiveTenants["revpercent"] ."% of Net Sales', userid = '". $_SESSION['MMS-UserID'] ."', xcode = 'Rent', reference = '". $rowActiveTenants["revpercent"] ."% of ". number_format($TotalRevenue[0], "2", ".", ",") ." (". date('F Y', strtotime($_POST['DateTo'])) .")', Machine_No = '". SysLeaseSetup('Machine_No') ."', merchant_code = '". $rowActiveTenants['merchant_code'] ."', UnitID = '". $rowUnitList['UnitID'] ."';", $connection);
							}
			            }else if($rowActiveTenants['tenanttype'] == 'Rent Rev'){
			                $resCharges = mysql_query("SELECT tenantid from tbltransaction WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND xcode = 'Rent' AND isMerchant = '0' AND xdate BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['DateTo'])) ."';", $connection);
							$countCharges = mysql_num_rows($resCharges);
							if($countCharges === 0){
								if($ProposalInfo['isRent'] == "0"){
									if($isVatable == "yes"){
						                if($isInclusive == "inc"){ //VAT IS INCLUSIVE
						                    $VATAmount = ( floatval($MonthlyRent) / 1.12 ) * $VATPercent;
						                    $RentLessVAT = floatval($MonthlyRent) - $VATAmount;
						                    $Amount = $RentLessVAT;
											$VAT = $VATAmount;
						                    $TotalAmount = $VAT + $Amount;
						                }else{ //VAT IS EXCLUSIVE
						                    $VATAmount = floatval($MonthlyRent) * $VATPercent;
						                    $RentPlusVAT = floatval($MonthlyRent);
						                    $Amount = floatval($MonthlyRent);
						                    $VAT = $VATAmount;
						                    $TotalAmount = floatval($MonthlyRent) + $VATAmount;
						                }
						            }else{
						            	$Amount = $MonthlyRent;
						                $VAT = "0.00";
						                $TotalAmount = floatval($MonthlyRent);
						            }
					            }else{
					                $Amount = $MonthlyRent;
					                $VAT = "0.00";
					                $TotalAmount = floatval($MonthlyRent);
					            }
								
								$SaveTransaction = mysql_query("INSERT INTO tbltransaction SET tenantid = '". $rowActiveTenants["TenantID"] ."', description = 'Rent', amount = '". floatval($MonthlyRent) ."', vatamount = '". $VAT ."', balance = '". $TotalAmount ."', totalamount = '". $TotalAmount ."', qty = 1, xdate = '". date("Y-m-d", strtotime($_POST['DateTo'])) ."', tenanttype = '". $rowActiveTenants["tenanttype"] ."', revpercent = '". $rowActiveTenants["revpercent"] ."', xdescription = 'Basic Rent/SQM', userid = '". $_SESSION['MMS-UserID'] ."', xcode = 'Rent', reference = 'Rent (". date("F Y", strtotime($_POST['DateTo'])) .")', Machine_No = '". SysLeaseSetup('Machine_No') ."', merchant_code = '". $rowActiveTenants['merchant_code'] ."', UnitID = '". $rowUnitList['UnitID'] ."';", $connection);

								$TotalRevenue = mysql_fetch_array(mysql_query("SELECT SUM(". $tblSales[6] .") FROM ". $tblSales[0] ." WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND ". $tblSales[1] ." BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND  '". date('Y-m-d', strtotime($_POST['DateTo'])) ."';", $connection));
								$RevenuePercentage = floatval($TotalRevenue[0]) * (floatval($rowActiveTenants["revpercent"]) /100);

								if($ProposalInfo['isRent'] == "0"){
									if($isVatable == "yes"){
						                if($isInclusive == "inc"){ //VAT IS INCLUSIVE
						                    $VATAmount = ( floatval($RevenuePercentage) / 1.12 ) * $VATPercent;
						                    $RentLessVAT = floatval($RevenuePercentage) - $VATAmount;
						                    $Amount = $RentLessVAT;
											$VAT = $VATAmount;
						                    $TotalAmount = $VAT + $Amount;
						                }else{ //VAT IS EXCLUSIVE
						                    $VATAmount = floatval($RevenuePercentage) * $VATPercent;
						                    $RentPlusVAT = floatval($RevenuePercentage);
						                    $Amount = floatval($RevenuePercentage);
						                    $VAT = $VATAmount;
						                    $TotalAmount = floatval($RevenuePercentage) + $VATAmount;
						                }
						            }else{
						            	$Amount = $RevenuePercentage;
					                	$VAT = "0.00";
					                	$TotalAmount = floatval($RevenuePercentage);
						            }
					            }else{
					                $Amount = $RevenuePercentage;
					                $VAT = "0.00";
					                $TotalAmount = floatval($RevenuePercentage);
					            }

								$SaveTransaction = mysql_query("INSERT INTO tbltransaction SET tenantid = '". $rowActiveTenants["TenantID"] ."', description = 'Rent', amount = '". $RevenuePercentage ."', vatamount = '". $VAT ."', balance = '". $TotalAmount ."', totalamount = '". $TotalAmount ."', qty = 1, xdate = '". date("Y-m-d", strtotime($_POST['DateTo'])) ."', tenanttype = '". $rowActiveTenants["tenanttype"] ."', revpercent = '". $rowActiveTenants["revpercent"] ."', xdescription = '". $rowActiveTenants["revpercent"] ."% of Gross Sales', userid = '". $_SESSION['MMS-UserID'] ."', xcode = 'Rent', reference = '". $rowActiveTenants["revpercent"] ."% of ". number_format($TotalRevenue[0], "2", ".", ",") ." (". date('F Y', strtotime($_POST['DateTo'])) .")', merchant_code = '". $rowActiveTenants['merchant_code'] ."', UnitID = '". $rowUnitList['UnitID'] ."';", $connection);
							}
			            }else if($rowActiveTenants['tenanttype'] == 'Rent or Share'){
			                $resCharges = mysql_query("SELECT tenantid from tbltransaction WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND xcode = 'Rent' AND isMerchant = '0' AND xdate BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['DateTo'])) ."';", $connection);
							$countCharges = mysql_num_rows($resCharges);
							if($countCharges === 0){
								$TotalRent = 0;
								$resUnitList = mysql_query("SELECT a.UnitID, b.pricepersqmunitsetup, b.area, b.sqm_height, b.sqm_width FROM tbltrans_inquiry_unit AS a LEFT JOIN tblref_unit AS b ON a.UnitID = b.unitid WHERE a.InquiryID = '". $rowActiveTenants['inqID'] ."';", $connection);
								while($rowUnitList = mysql_fetch_array($resUnitList)){

									if(SysLeaseSetup('floorandunitmeasurement') == "Area"){
			                        	$TotalArea = $rowUnitList['area'];
			                        }else{
			                        	$TotalArea = floatval($rowUnitList['sqm_height'] * $rowUnitList['sqm_width']);
			                    	}

			                    	$TotalRent += $TotalArea * $rowUnitList['pricepersqmunitsetup'];
								}

								$TotalRevenue = mysql_fetch_array(mysql_query("SELECT SUM(". $tblSales[6] .") FROM ". $tblSales[0] ." WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND ". $tblSales[1] ." BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND  '". date('Y-m-d', strtotime($_POST['DateTo'])) ."';", $connection));
								$RevenuePercentage = floatval($TotalRevenue[0]) * (floatval($rowActiveTenants["revpercent"]) /100);

								if($MonthlyRent > $RevenuePercentage){
									$Rent = $MonthlyRent;
								}else{
									$Rent = $RevenuePercentage;
								}

								if($ProposalInfo['isRent'] == "0"){
									if($isVatable == "yes"){
						                if($isInclusive == "inc"){ //VAT IS INCLUSIVE
						                    $VATAmount = ( floatval($Rent) / 1.12 ) * $VATPercent;
						                    $RentLessVAT = floatval($Rent) - $VATAmount;
						                    $Amount = $RentLessVAT;
											$VAT = $VATAmount;
						                    $TotalAmount = $VAT + $Amount;
						                }else{ //VAT IS EXCLUSIVE
						                    $VATAmount = floatval($Rent) * $VATPercent;
						                    $RentPlusVAT = floatval($Rent);
						                    $Amount = floatval($Rent);
						                    $VAT = $VATAmount;
						                    $TotalAmount = floatval($Rent) + $VATAmount;
						                }
						            }else{
						            	$Amount = $Rent;
						                $VAT = "0.00";
						                $TotalAmount = floatval($Rent);
						            }
					            }else{
					                $Amount = $Rent;
					                $VAT = "0.00";
					                $TotalAmount = floatval($Rent);
					            }
								
								if($MonthlyRent > $RevenuePercentage){
									if($ProposalInfo['isRent'] == "0"){
										if($isVatable == "yes"){
							                if($isInclusive == "inc"){ //VAT IS INCLUSIVE
							                    $VATAmount = ( floatval($MonthlyRent) / 1.12 ) * $VATPercent;
							                    $RentLessVAT = floatval($MonthlyRent) - $VATAmount;
							                    $Amount = $RentLessVAT;
												$VAT = $VATAmount;
							                    $TotalAmount = $VAT + $Amount;
							                }else{ //VAT IS EXCLUSIVE
							                    $VATAmount = floatval($MonthlyRent) * $VATPercent;
							                    $RentPlusVAT = floatval($MonthlyRent);
							                    $Amount = floatval($MonthlyRent);
							                    $VAT = $VATAmount;
							                    $TotalAmount = floatval($MonthlyRent) + $VATAmount;
							                }
							            }else{
							            	$Amount = $MonthlyRent;
							                $VAT = "0.00";
							                $TotalAmount = floatval($MonthlyRent);
							            }
						            }else{
						                $Amount = $MonthlyRent;
						                $VAT = "0.00";
						                $TotalAmount = floatval($MonthlyRent);
						            }
									
									$SaveTransaction = mysql_query("INSERT INTO tbltransaction SET tenantid = '". $rowActiveTenants["TenantID"] ."', description = 'Rent', amount = '". floatval($MonthlyRent) ."', vatamount = '". $VAT ."', balance = '". $TotalAmount ."', totalamount = '". $TotalAmount ."', qty = 1, xdate = '". date("Y-m-d", strtotime($_POST['DateTo'])) ."', tenanttype = '". $rowActiveTenants["tenanttype"] ."', revpercent = '". $rowActiveTenants["revpercent"] ."', xdescription = 'Basic Rent/SQM', userid = '". $_SESSION['MMS-UserID'] ."', xcode = 'Rent', reference = 'Rent (". date("F Y", strtotime($_POST['DateTo'])) .")', Machine_No = '". SysLeaseSetup('Machine_No') ."', merchant_code = '". $rowActiveTenants['merchant_code'] ."', UnitID = '". $rowUnitList['UnitID'] ."';", $connection);
								}else{
									$SaveTransaction = mysql_query("INSERT INTO tbltransaction SET tenantid = '". $rowActiveTenants["TenantID"] ."', description = 'Rent', amount = '". $RevenuePercentage ."', vatamount = '". $VAT ."', balance = '". $TotalAmount ."', totalamount = '". $TotalAmount ."', qty = 1, xdate = '". date("Y-m-d", strtotime($_POST['DateTo'])) ."', tenanttype = '". $rowActiveTenants["tenanttype"] ."', revpercent = '". $rowActiveTenants["revpercent"] ."', xdescription = '". $rowActiveTenants["revpercent"] ."% of Gross Sales', userid = '". $_SESSION['MMS-UserID'] ."', xcode = 'Rent', reference = '". $rowActiveTenants["revpercent"] ."% of ". number_format($TotalRevenue[0], "2", ".", ",") ." (". date('F Y', strtotime($_POST['DateTo'])) .")', Machine_No = '". SysLeaseSetup('Machine_No') ."', merchant_code = '". $rowActiveTenants['merchant_code'] ."', UnitID = '". $rowUnitList['UnitID'] ."';", $connection);
								}
							}
			            }else{
			                $resCharges = mysql_query("SELECT tenantid from tbltransaction WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND xcode = 'Rent' AND isMerchant = '0' AND xdate BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['DateTo'])) ."';", $connection);
							$countCharges = mysql_num_rows($resCharges);
							if($countCharges === 0){
								
								if($ProposalInfo['isRent'] == "0"){
									if($isVatable == "yes"){
						                if($isInclusive == "inc"){ //VAT IS INCLUSIVE
						                    $VATAmount = ( floatval($MonthlyRent) / 1.12 ) * $VATPercent;
						                    $RentLessVAT = floatval($MonthlyRent) - $VATAmount;
						                    $Amount = $RentLessVAT;
											$VAT = $VATAmount;
						                    $TotalAmount = $VAT + $Amount;
						                }else{ //VAT IS EXCLUSIVE
						                    $VATAmount = floatval($MonthlyRent) * $VATPercent;
						                    $RentPlusVAT = floatval($MonthlyRent);
						                    $Amount = floatval($MonthlyRent);
						                    $VAT = $VATAmount;
						                    $TotalAmount = floatval($MonthlyRent) + $VATAmount;
						                }
						            }else{
						            	$Amount = $MonthlyRent;
						                $VAT = "0.00";
						                $TotalAmount = floatval($MonthlyRent);
						            }
					            }else{
					                $Amount = $MonthlyRent;
					                $VAT = "0.00";
					                $TotalAmount = floatval($MonthlyRent);
					            }
								
								$SaveTransaction = mysql_query("INSERT INTO tbltransaction SET tenantid = '". $rowActiveTenants["TenantID"] ."', description = 'Rent', amount = '". floatval($MonthlyRent) ."', vatamount = '". $VAT ."', balance = '". $TotalAmount ."', totalamount = '". $TotalAmount ."', qty = 1, xdate = '". date("Y-m-d", strtotime($_POST['DateTo'])) ."', tenanttype = '". $rowActiveTenants["tenanttype"] ."', revpercent = '". $rowActiveTenants["revpercent"] ."', xdescription = 'Basic Rent/SQM', userid = '". $_SESSION['MMS-UserID'] ."', xcode = 'Rent', reference = 'Rent (". date('F Y', strtotime($_POST['DateTo'])) .")', Machine_No = '". SysLeaseSetup('Machine_No') ."', merchant_code = '". $rowActiveTenants['merchant_code'] ."', UnitID = '". $rowUnitList['UnitID'] ."';", $connection);
							}
			            }

			            // POSTING OF MONTHLY CHARGES
						$resProCharges = mysql_query("SELECT ChargeCode, ChargeAmount, ChargeType, UnitID, ChargeDesc FROM tbltrans_procharges WHERE InquiryID = '". $rowActiveTenants['inqID'] ."' AND ProposalNum = '". $rowActiveTenants['ActiveProposal'] ."';", $connection);
						while($rowProCharges = mysql_fetch_array($resProCharges)){

							$rowEscaBR = mysql_fetch_array(mysql_query("SELECT MAX(EscaTotal), UnitID, ChargeCode FROM tbltrans_chargeesca_br WHERE InquiryID = '". $rowActiveTenants['inqID'] ."' AND ProposalNum = '". $rowActiveTenants['ActiveProposal'] ."' AND STR_TO_DATE(EscaYear, '%M %Y') <= '". date('Y-m-d', strtotime($_POST['DateTo'])) ."' AND ChargeCode = '". $rowProCharges['ChargeCode'] ."';", $connection));
							$EscalatedChargeAmount = floatval($rowEscaBR[0]);

			            	$UnitInfo = mysql_fetch_array(mysql_query("SELECT area, sqm_width, sqm_height FROM tblref_unit WHERE unitid = '". $rowProCharges['UnitID'] ."';", $connection));

			            	if(SysLeaseSetup('floorandunitmeasurement') == "Area"){
                            	$TotalArea = floatval($UnitInfo['area']);
                            }else{
                            	$TotalArea = floatval($UnitInfo['sqm_width']) * floatval($UnitInfo['sqm_height']);
                            }

			            	if($EscalatedChargeAmount == 0){
								if($rowProCharges['ChargeType'] == "Persqm"){
				            		$ChargeAmount = floatval($rowProCharges['ChargeAmount']) * floatval($TotalArea);
				            		$Qty = floatval($TotalArea);
				            	}else if($rowProCharges['ChargeType'] == "Daily"){
				            		$ChargeAmount = floatval($rowProCharges['ChargeAmount']) * floatval($Days);
				            		$Qty = floatval($Days);
				            	}else if($rowProCharges['ChargeType'] == "Fixed"){
				            		$ChargeAmount = floatval($rowProCharges['ChargeAmount']);
				            		$Qty = 1;
				            	}else{
				            		$ChargeAmount = floatval($rowProCharges['ChargeAmount']);
				            		$Qty = 1;
				            	}
							}else{
								$ChargeAmount = floatval($EscalatedChargeAmount);
			            		$Qty = 1;
							}

			            	if($ProposalInfo['isRent'] == "0"){
								if($isVatable == "yes"){
					                if($isInclusive == "inc"){ //VAT IS INCLUSIVE
					                    $VATAmount = ( floatval($ChargeAmount) / 1.12 ) * $VATPercent;
					                    $RentLessVAT = floatval($ChargeAmount) - $VATAmount;
					                    $Amount = $RentLessVAT;
										$VAT = $VATAmount;
					                    $TotalAmount = $VAT + $Amount;
					                }else{ //VAT IS EXCLUSIVE
					                    $VATAmount = floatval($ChargeAmount) * $VATPercent;
					                    $RentPlusVAT = floatval($ChargeAmount);
					                    $Amount = floatval($ChargeAmount);
					                    $VAT = $VATAmount;
					                    $TotalAmount = floatval($ChargeAmount) + $VATAmount;
					                }
					            }else{
					            	$Amount = $ChargeAmount;
					                $VAT = "0.00";
					                $TotalAmount = floatval($ChargeAmount);
					            }
				            }else{
				                $Amount = $ChargeAmount;
				                $VAT = "0.00";
				                $TotalAmount = floatval($ChargeAmount);
				            }
				            $CheckifPosted = mysql_num_rows(mysql_query("SELECT id FROM tbltransaction WHERE tenantid = '". $rowActiveTenants["TenantID"] ."' AND xdescription = 'Monthly - ". $rowProCharges['ChargeDesc'] ."' AND isMerchant = '0' AND xdate BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['DateTo'])) ."' AND UnitID = '". $rowProCharges['UnitID'] ."';", $connection));
				            if($CheckifPosted == 0){				            	
								$SaveTransaction = mysql_query("INSERT INTO tbltransaction SET tenantid = '". $rowActiveTenants["TenantID"] ."', description = '". $rowProCharges['ChargeDesc'] ."', amount = '". $Amount ."', vatamount = '". $VAT ."', balance = '". $TotalAmount ."', totalamount = '". $TotalAmount ."', qty = '". $Qty ."', xdate = '". date("Y-m-d", strtotime($_POST['DateTo'])) ."', tenanttype = '". $rowActiveTenants["tenanttype"] ."', revpercent = '". $rowActiveTenants["revpercent"] ."', xdescription = 'Monthly - ". $rowProCharges['ChargeDesc'] ."', userid = '". $_SESSION['MMS-UserID'] ."', xcode = '". $rowProCharges['ChargeCode'] ."', reference = '". $rowProCharges['ChargeDesc'] ."', Machine_No = '". SysLeaseSetup('Machine_No') ."', merchant_code = '". $rowActiveTenants['merchant_code'] ."', UnitID = '". $rowProCharges['UnitID'] ."';", $connection);
				            }
						}

						$chkBegBalance = mysql_num_rows(mysql_query("SELECT id FROM tbltransaction WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND xcode = 'BEG_BAL';", $connection));
						if($chkBegBalance == 0){
							$VATAmount = ( floatval($rowActiveTenants['Beg_Balance']) / 1.12 ) * $VATPercent;
		                    $RentLessVAT = floatval($rowActiveTenants['Beg_Balance']) - $VATAmount;
		                    $Amount = $RentLessVAT;
							$VAT = $VATAmount;
		                    $TotalAmount = $VAT + $Amount;
							$SaveTransaction = mysql_query("INSERT INTO tbltransaction SET tenantid = '". $rowActiveTenants["TenantID"] ."', description = 'BEGINNING BALANCE', amount = '". $Amount ."', vatamount = '". $VAT ."', balance = '". $TotalAmount ."', totalamount = '". $TotalAmount ."', qty = '1', xdate = '". date("Y-m-d", strtotime($rowActiveTenants['Beg_Date'])) ."', tenanttype = '". $rowActiveTenants["tenanttype"] ."', revpercent = '". $rowActiveTenants["revpercent"] ."', xdescription = 'BEGINNING BALANCE', userid = '". $_SESSION['MMS-UserID'] ."', xcode = 'BEG_BAL', reference = 'BEGINNING BAL. (". date("F Y", strtotime($rowActiveTenants['Beg_Date'])) .")', Machine_No = '". SysLeaseSetup('Machine_No') ."', merchant_code = '". $rowActiveTenants['merchant_code'] ."', UnitID = '". $rowProCharges['UnitID'] ."';", $connection);
						}

						// PAYMENT LEFT
						$PaymentLeft = mysql_fetch_array(mysql_query("SELECT pleft FROM dunn_tblsoaheader WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND duedate < '". date('Y-m-d', strtotime($_POST['DueDate'])) ."' ORDER BY duedate DESC LIMIT 1;", $connection));

						// TOTAL PAYMENT MADE WITHIN THE BILLING PERIOD
						$TotalPayment = mysql_fetch_array(mysql_query("SELECT SUM(totalamount) FROM tbltransaction WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND amount < 0 AND (xdate BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '".date("Y-m-d", strtotime($_POST["DueDate"]))."') AND (SoAID IS NULL OR SoAID = '');", $connection));

						// Total PREVIOUS ALANCE
						$TotalPrevBal = mysql_fetch_array(mysql_query("SELECT SUM(balance) FROM tbltransaction WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND xdate < '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND (paymenttype IS NULL OR paymenttype = '') AND isPenalty = '0';", $connection));

						//Current BALANCE
						$CurrBal = mysql_fetch_array(mysql_query("SELECT SUM(totalamount) FROM tbltransaction WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND xdate BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['DateTo'])) ."' AND (paymenttype IS NULL OR paymenttype = '') AND isPenalty = '0';", $connection));

						// 1 - 30 DAYS
						$PrevBal13 = mysql_fetch_array(mysql_query("SELECT SUM(balance) FROM tbltransaction WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND (xdate BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'].'-30 day')) ."' AND '". date('Y-m-d', strtotime($_POST['DateFrom'].'-1 day')) ."') AND (paymenttype IS NULL OR paymenttype = '') AND isPenalty = '0';", $connection));

						// 31 - 60 DAYS
						$PrevBal36 = mysql_fetch_array(mysql_query("SELECT SUM(balance) FROM tbltransaction WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND (xdate BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'].'-60 day')) ."' AND '". date('Y-m-d', strtotime($_POST['DateFrom'].'-31 day')) ."') AND (paymenttype IS NULL OR paymenttype = '') AND isPenalty = '0';", $connection));

						// 61 - 90 DAYS
						$PrevBal69 = mysql_fetch_array(mysql_query("SELECT SUM(balance) FROM tbltransaction WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND (xdate BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'].'-90 day')) ."' AND '". date('Y-m-d', strtotime($_POST['DateFrom'].'-61 day')) ."') AND (paymenttype IS NULL OR paymenttype = '') AND isPenalty = '0';", $connection));

						// OVER 91 DAYS
						$PrevBal91 = mysql_fetch_array(mysql_query("SELECT SUM(balance) FROM tbltransaction WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND xdate <= '". date('Y-m-d', strtotime($_POST['DateFrom'].'-91 day')) ."' AND (paymenttype IS NULL OR paymenttype = '') AND isPenalty = '0';", $connection));

						$OtherCharges = mysql_fetch_array(mysql_query("SELECT SUM(totalamount) FROM tbltransaction WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND (xdate BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['DateTo'])) ."') AND paymenttype = '' AND (description NOT LIKE '%Rent%' AND description NOT LIKE '%Association Dues%') AND (paymenttype IS NULL OR paymenttype = '') AND isPenalty = '0';", $connection));

						$TotalRentalCharges = mysql_fetch_array(mysql_query("SELECT SUM(totalamount) FROM tbltransaction WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND (xdate BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['DateTo'])) ."') AND paymenttype = '' AND (description LIKE '%Rent%' OR description LIKE '%Association Dues%') AND (paymenttype IS NULL OR paymenttype = '') AND isPenalty = '0';", $connection));

						$TotalRevenue = mysql_fetch_array(mysql_query("SELECT SUM(". $tblSales[6] .") FROM ". $tblSales[0] ." WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND (". $tblSales[1] ." BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['DateTo'])) ."');", $connection));

						$CurrentPenalty = mysql_fetch_array(mysql_query("SELECT SUM(totalamount) FROM tbltransaction WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND xdate BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['DateTo'])) ."' AND (paymenttype IS NULL OR paymenttype = '') AND isPenalty = '1';", $connection));

						$PrevPenalty = mysql_fetch_array(mysql_query("SELECT SUM(balance) FROM tbltransaction WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND xdate < '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND (paymenttype IS NULL OR paymenttype = '') AND isPenalty = '1';", $connection));

						$PaymentRunning = floatval($TotalPayment[0]) + floatval($PaymentLeft[0]); //Payment TOTAL
						$CurrentTotalPayment = floatval($TotalPayment[0]) + floatval($PaymentLeft[0]); //Current Total Payment
						$CurrentCharge = floatval($CurrBal[0]) + floatval($CurrentPenalty[0]); //CURRENT CHARGES

						// OVER 90 DAYS
						if($PaymentRunning > 0){
							$Balance91 = $PrevBal91[0] - $PaymentRunning;
						}else{
							$Balance91 = $PrevBal91[0];
						}
						if($Balance91 < 0){
							$PaymentRunning = $Balance91 * -1;
							$Balance91 = 0;
						}else{
							$PaymentRunning = 0;
						}

						// 61 TO 90 DAYS
						if($PaymentRunning > 0){
							$Balance69 = $PrevBal69[0] - $PaymentRunning;
						}else{
							$Balance69 = $PrevBal69[0];
						}
						if($Balance69 < 0){
							$PaymentRunning = $Balance69 * -1;
							$Balance69 = 0;
						}else{
							$PaymentRunning = 0;
						}

						// 31 TO 60 DAYS
						if($PaymentRunning > 0){
							$Balance36 = $PrevBal36[0] - $PaymentRunning;
						}else{
							$Balance36 = $PrevBal36[0];
						}
						if($Balance36 < 0){
							$PaymentRunning = $Balance36 * -1;
							$Balance36 = 0;
						}else{
							$PaymentRunning = 0;
						}

						// CURRENT CHARGES
						if($PaymentRunning > 0){
							$Balance13 = $PrevBal13[0] - $PaymentRunning;
						}else{
							$Balance13 = $PrevBal13[0];
						}
						if($Balance13 < 0){
							$PaymentRunning = $Balance13 * -1;
							$Balance13 = 0;
						}else{
							$PaymentRunning = 0;
						}

						$Balance00 = $CurrBal[0] - $PaymentRunning; // current
						if($Balance00 < 0){
							$PaymentRunning = $Balance00 * -1;
							$Balance00 = 0;
						}else{
							$PaymentRunning = 0;
						}

						$CurrBalance = (floatval($Balance00) + floatval($Balance13) + floatval($Balance36) + floatval($Balance69) + floatval($Balance91) + floatval($CurrentPenalty[0]) + floatval($PrevPenalty[0])) - $PaymentRunning;
						if($CurrBalance < 0){
							$PaymentRunning = $CurrBalance * -1;
							$CurrBalance = 0;
						}else{
							$PaymentRunning = 0;
						}

						$isSubUnit = mysql_fetch_array(mysql_query("SELECT MainUnit, BillingSetup FROM tblref_unit WHERE TenantID = '". $rowActiveTenants['TenantID'] ."';", $connection));
						if($isSubUnit['BillingSetup'] == "Merged"){
							if($isSubUnit['MainUnit'] == ""){
								$ctrlno2 = 0;
								$ctrlno++;
								$Contain = $ctrlno;
								$BillNo = $_POST['SoAID'] ."-". $Contain;
							}else{
								$ctrlno2++;
								$Contain = columnLetter($ctrlno2);
								$BillNo = $_POST['SoAID'] ."-". $ctrlno.$Contain;
							}
						}else{
							$ctrlno2 = 0;
							$ctrlno++;
							$Contain = $ctrlno;
							$BillNo = $_POST['SoAID'] ."-". $Contain;
						}

						if(floatval(($TotalPrevBal[0] + $PrevPenalty[0]) - floatval(str_replace("-", "", $TotalPayment[0]))) < 0){
							$ForwardingBalance = (floatval($TotalPrevBal[0]) + floatval($PrevPenalty[0]));
						}else{
							$ForwardingBalance = (floatval($TotalPrevBal[0]) + floatval($PrevPenalty[0])) - floatval($TotalPayment[0]);
						}

						//UPDATING BALANCES ON tbltransaction
						// $PaymentRunning2 = floatval($TotalPayment[0]) + floatval($PaymentLeft[0]);
						// if($PaymentRunning2 > 0){
						// 	$resGetChargeWithBalance = mysql_query("SELECT balance, id, paymentamount FROM tbltransaction WHERE xdate <= '". date('Y-m-d', strtotime($_POST['DateTo'])) ."' AND tenantid = '" . $rowActiveTenants['TenantID'] . "' AND balance > 0 ORDER BY id ASC;", $connection);
						// 	while($rowChargesWithBalance = mysql_fetch_array($resGetChargeWithBalance)){

						// 		if($PaymentRunning2 > 0){
						// 			$Balance = $rowChargesWithBalance[0] - $PaymentRunning2;
						// 		}else{
						// 			$Balance = $rowChargesWithBalance[0];
						// 		}

						// 		if($Balance < 0){
						// 			$PaymentAmount = $rowChargesWithBalance[0];
						// 			$PaymentRunning2 = $Balance * -1;
						// 			$Balance = 0;
						// 		}else{
						// 			$PaymentAmount = $PaymentRunning2;
						// 			$PaymentRunning2 = 0;
						// 			$Balance = $Balance;
						// 		}

						// 		$updatebal = mysql_query("UPDATE tbltransaction SET balance = '". $Balance ."', paymentamount = '". floatval($PaymentAmount + $rowChargesWithBalance['paymentamount']) ."' WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND id = '". $rowChargesWithBalance[1] ."';", $connection);
						// 	}
						// }

						// $NewCurrBal = 0;
						// $resGetHeaderWithBalance = mysql_query("SELECT id, Currbal FROM dunn_tblsoaheader WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' ORDER BY duedate ASC;", $connection);
						// while($rowHeaderWithBalance = mysql_fetch_array($resGetHeaderWithBalance)){
						// 	if($CurrentTotalPayment > 0){
						// 		$NewCurrBal = $rowHeaderWithBalance['Currbal'] - $CurrentTotalPayment;
						// 	}else{
						// 		$NewCurrBal = $rowHeaderWithBalance['Currbal'];
						// 	}

						// 	if($NewCurrBal < 0){
						// 		$CurrentTotalPayment = $NewCurrBal * -1;
						// 		$NewCurrBal = 0;
						// 	}else{
						// 		$CurrentTotalPayment = 0;
						// 	}

						// 	$resUpdateHeader = mysql_query("UPDATE dunn_tblsoaheader SET Currbal = '". $NewCurrBal ."' WHERE id = '". $rowHeaderWithBalance['id'] ."';", $connection);

						// }

						// $ZeroAllPayment = mysql_query("UPDATE tbltransaction SET balance = 0 WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND paymenttype != '' AND xdate <= '". date('Y-m-d', strtotime($_POST['DueDate'])) ."' AND (SoAID IS NULL OR SoAID = '');", $connection);

						$SOAHeader = mysql_query("INSERT INTO dunn_tblsoaheader SET soaid = '". $_POST['SoAID'] ."', tenantid = '". $rowActiveTenants['TenantID'] ."', tenantname = '". $rowActiveTenants['tradename'] ."', totalamount = '". floatval($CurrentCharge + $ForwardingBalance) ."', createdby = '". getusername() ."', datecreated = '". getsysdate() ."', duedate = '". date('Y-m-d', strtotime($_POST['DueDate'])) ."', tenantdues = '". floatval($TotalRentalCharges[0]) ."', revenue = '". floatval($TotalRevenue[0]) ."', Forwbal = '". floatval($ForwardingBalance) ."', currbal = '". floatval($CurrBalance) ."', payment = '". floatval($TotalPayment[0]) ."', currcharg = '". floatval($CurrentCharge) ."', hperiod = 'Not Posted', billno = '". $BillNo ."', ctrlno = '". $Contain ."', b13 = '". floatval($Balance13) ."', b36 = '". floatval($Balance36) ."', b69 = '". floatval($Balance69) ."', b99 = '". floatval($Balance91) ."', b00 = '". floatval($Balance00) ."', pleft = '". $PaymentRunning ."', penchrg = '". floatval($CurrentPenalty[0] + $PrevPenalty[0]) ."', soaperiod = '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."', soaperiod2 = '". date('Y-m-d', strtotime($_POST['DateTo'])) ."', Merchant_Code = '". $rowActiveTenants['merchant_code'] ."';", $connection);
						if($SOAHeader == true){
							// GET ALL CHARGES FOR THIS PERIOD
			    			$getAllCharges = mysql_query("SELECT tenantid, xcode, description, amount, qty, paymentamount, vatamount, balance, xdate, reference, xdatetime, isPenalty, paymenttype, cardholder, ccno, expdate, checkno, checkdate, checkname, bankname, cardtype, authno, secno, orno, totalamount, tenanttype, revpercent, bnkfrom, bnkto, accnofrom, accnoto, xdescription, isMerchant, merchant_code, id FROM tbltransaction WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND xdate BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['DateTo'])) ."' AND amount > 0;", $connection);
			    			while($rowAllCharges = mysql_fetch_array($getAllCharges)){
			    				$InsertCharges = mysql_query("INSERT INTO dunn_tblsoadetails SET soaNo = '". $_POST['SoAID'] ."', tenantid = '". $rowAllCharges['tenantid'] ."', xcode = '". $rowAllCharges['xcode'] ."', description = '". $rowAllCharges['description'] ."', amount = '". $rowAllCharges['amount'] ."', qty = '". $rowAllCharges['qty'] ."', paymentamount = '". $rowAllCharges['paymentamount'] ."', vatamount = '". $rowAllCharges['vatamount'] ."', balance = '". $rowAllCharges['balance'] ."', xdate = '". $rowAllCharges['xdate'] ."', reference = '". $rowAllCharges['reference'] ."', xdatetime = '". $rowAllCharges['xdatetime'] ."', isPenalty = '". $rowAllCharges['isPenalty'] ."', paymenttype = '". $rowAllCharges['paymenttype'] ."', cardholder = '". $rowAllCharges['cardholder'] ."', ccno = '". $rowAllCharges['ccno'] ."', expdate = '". $rowAllCharges['expdate'] ."', checkno = '". $rowAllCharges['checkno'] ."', checkdate = '". $rowAllCharges['checkdate'] ."', checkname = '". $rowAllCharges['checkname'] ."', bankname = '". $rowAllCharges['bankname'] ."', cardtype = '". $rowAllCharges['cardtype'] ."', authno = '". $rowAllCharges['authno'] ."', secno = '". $rowAllCharges['secno'] ."', orno = '". $rowAllCharges['orno'] ."', totalamount = '". $rowAllCharges['totalamount'] ."', tenanttype = '". $rowAllCharges['tenanttype'] ."', revpercent = '". $rowAllCharges['revpercent'] ."', bnkfrom = '". $rowAllCharges['bnkfrom'] ."', bnkto = '". $rowAllCharges['bnkto'] ."', accnofrom = '". $rowAllCharges['accnofrom'] ."', accnoto = '". $rowAllCharges['accnoto'] ."', xdescription = '". $rowAllCharges['xdescription'] ."', isMerchant = '". $rowAllCharges['isMerchant'] ."', merchant_code = '". $rowAllCharges['merchant_code'] ."';", $connection);
			    				$resUpdateSoaID = mysql_query("UPDATE tbltransaction SET SoAID = '". $_POST['SoAID'] ."' WHERE id = '". $rowAllCharges['id'] ."';", $connection);
			    			}

		    				// GET ALL POSTED PAYMENT FOR THIS PERIOD
		    				$getAllPayments = mysql_query("SELECT tenantid, xcode, description, amount, qty, paymentamount, vatamount, balance, xdate, transdate, reference, xdatetime, isPenalty, paymenttype, cardholder, ccno, expdate, checkno, checkdate, checkname, bankname, cardtype, authno, secno, orno, totalamount, tenanttype, revpercent, bnkfrom, bnkto, accnofrom, accnoto, xdescription, isMerchant, merchant_code, id FROM tbltransaction WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND xdate BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['DueDate'])) ."' AND amount < 0;", $connection);
		    				while($rowAllPayments = mysql_fetch_array($getAllPayments)){
		    					if($rowAllPayments['xdate'] == ""){
			    					$PaymentDate = $rowAllPayments["transdate"];
			    				}else{
			    					$PaymentDate = $rowAllPayments["xdate"];
			    				}
			    				$InsertCharges = mysql_query("INSERT INTO dunn_tblsoadetails SET soaNo = '". $_POST['SoAID'] ."', tenantid = '". $rowAllPayments['tenantid'] ."', xcode = '". $rowAllPayments['xcode'] ."', description = '". $rowAllPayments['description'] ."', amount = '". $rowAllPayments['amount'] ."', qty = '". $rowAllPayments['qty'] ."', paymentamount = '". $rowAllPayments['paymentamount'] ."', vatamount = '". $rowAllPayments['vatamount'] ."', balance = '". $rowAllPayments['balance'] ."', xdate = '". $PaymentDate ."', reference = '". $rowAllPayments['reference'] ."', xdatetime = '". $rowAllPayments['xdatetime'] ."', isPenalty = '". $rowAllPayments['isPenalty'] ."', paymenttype = '". $rowAllPayments['paymenttype'] ."', cardholder = '". $rowAllPayments['cardholder'] ."', ccno = '". $rowAllPayments['ccno'] ."', expdate = '". $rowAllPayments['expdate'] ."', checkno = '". $rowAllPayments['checkno'] ."', checkdate = '". $rowAllPayments['checkdate'] ."', checkname = '". $rowAllPayments['checkname'] ."', bankname = '". $rowAllPayments['bankname'] ."', cardtype = '". $rowAllPayments['cardtype'] ."', authno = '". $rowAllPayments['authno'] ."', secno = '". $rowAllPayments['secno'] ."', orno = '". $rowAllPayments['orno'] ."', totalamount = '". $rowAllPayments['totalamount'] ."', tenanttype = '". $rowAllPayments['tenanttype'] ."', revpercent = '". $rowAllPayments['revpercent'] ."', bnkfrom = '". $rowAllPayments['bnkfrom'] ."', bnkto = '". $rowAllPayments['bnkto'] ."', accnofrom = '". $rowAllPayments['accnofrom'] ."', accnoto = '". $rowAllPayments['accnoto'] ."', xdescription = '". $rowAllPayments['xdescription'] ."', isMerchant = '". $rowAllPayments['isMerchant'] ."', merchant_code = '". $rowAllPayments['merchant_code'] ."';", $connection);
			    				$resUpdateSoaID = mysql_query("UPDATE tbltransaction SET SoAID = '". $_POST['SoAID'] ."' WHERE id = '". $rowAllCharges['id'] ."';", $connection);
		    				}

		    				// UPDATE PERIOD STATUS
		    				$res = mysql_query("UPDATE tblref_billperiod SET Processed = '1' WHERE soaid = '". $_POST['SoAID'] ."';", $connection);
		    				echo "1|Statement of Account were successfully processed.|";
						}

					}
			// 	}else{
			// 		echo "3|Statement of Accounts for this period is already processed, are you sure you want to reprocess Statement of Accounts for this period?|";
			// 	}
			// }
		break;

		case 'fncProcessSOA2':
			if($_POST['TenantID'] == ""){
				$WithTenant = "";
			}else{
				$WithTenant = "AND a.TenantID = '". $_POST['TenantID'] ."'";
			}

			$Success = 0;
			$resGetActiveTenants = mysql_query("SELECT TenantID, tradename, merchant_code, monthly_dues, tenanttype, revpercent, mallID, inqID, datefrom, dateto, ActiveProposal FROM tbltrans_tenants WHERE ". $WithTenant ." (datefrom >= '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND datefrom <= '". date('Y-m-d', strtotime($_POST['DateTo'])) ."' OR dateto >= '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND dateto <= '". date('Y-m-d', strtotime($_POST['DateTo'])) ."' OR datefrom < '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND datefrom < '". date('Y-m-d', strtotime($_POST['DateTo'])) ."' AND dateto > '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND dateto > '". date('Y-m-d', strtotime($_POST['DateTo'])) ."') AND (Status = 'Active' OR Status = 'ForEviction' OR Status = 'ForRenewal') AND ustatus = 'Occupied' ". getMallAccess("mallID", "AND") .";", $connection);
			while($rowActiveTenants = mysql_fetch_array($resGetActiveTenants)){

				$ProposalInfo = mysql_fetch_array(mysql_query("SELECT monthlyDues, escalation_rate, year_start, year_basis, charges_list, vattype, vatpercent, isRent, proposalNum FROM tbltrans_proposal WHERE inquiryID = '". $rowActiveTenants['inqID'] ."' AND proposalNum = '". $rowActiveTenants['ActiveProposal'] ."';", $connection));

				$getSetup = explode("|", getrentvattype($rowActiveTenants['mallID']));
				$isVatable = $getSetup[1];
				$isInclusive = $getSetup[2];
				$VATPercent = floatval($getSetup[0]) / 100;

				$getEscalation = mysql_fetch_array(mysql_query("SELECT MAX(EscaTotal) FROM tbltrans_escalation WHERE InquiryID = '". $rowActiveTenants['inqID'] ."' AND ProposalNum = '". $ProposalInfo['proposalNum'] ."' AND STR_TO_DATE(EscaYear, '%M %Y') <= '". date('Y-m-d', strtotime($_POST['DateTo'])) ."';", $connection));
				$EscalatedRent = floatval($getEscalation[0]);

				if($EscalatedRent == 0){
					$MonthlyRent = floatval($rowActiveTenants['monthly_dues']);
				}else{
					$MonthlyRent = floatval($EscalatedRent);
				}

				// POSTING OF RENTAL CHARGES
				if($rowActiveTenants['tenanttype'] == 'Rent'){
	                $resCharges = mysql_query("SELECT tenantid from tbltransaction WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND xcode = 'Rent' AND isMerchant = '0' AND xdate BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['DateTo'])) ."';", $connection);
					$countCharges = mysql_num_rows($resCharges);
					if($countCharges === 0){

						if($ProposalInfo['isRent'] == "0"){
							if($isVatable == "yes"){
				                if($isInclusive == "inc"){ //VAT IS INCLUSIVE
				                    $VATAmount = ( floatval($MonthlyRent) / 1.12 ) * $VATPercent;
				                    $RentLessVAT = floatval($MonthlyRent) - $VATAmount;
				                    $Amount = $RentLessVAT;
									$VAT = $VATAmount;
				                    $TotalAmount = $VAT + $Amount;
				                }else{ //VAT IS EXCLUSIVE
				                    $VATAmount = floatval($MonthlyRent) * $VATPercent;
				                    $RentPlusVAT = floatval($MonthlyRent);
				                    $Amount = floatval($MonthlyRent);
				                    $VAT = $VATAmount;
				                    $TotalAmount = floatval($MonthlyRent) + $VATAmount;
				                }
				            }else{
				            	$Amount = $MonthlyRent;
				                $VAT = "0.00";
				                $TotalAmount = floatval($MonthlyRent);
				            }
			            }else{
			                $Amount = $MonthlyRent;
			                $VAT = "0.00";
			                $TotalAmount = floatval($MonthlyRent);
			            }
						$SaveTransaction = mysql_query("INSERT INTO tbltransaction SET tenantid = '". $rowActiveTenants["TenantID"] ."', description = 'Rent', amount = '". floatval($MonthlyRent) ."', vatamount = '". $VAT ."', balance = '". $TotalAmount ."', totalamount = '". $TotalAmount ."', qty = 1, xdate = '". date("Y-m-d", strtotime($_POST['DateTo'])) ."', tenanttype = '". $rowActiveTenants["tenanttype"] ."', revpercent = '". $rowActiveTenants["revpercent"] ."', xdescription = 'Basic Rent/SQM', userid = '". $_SESSION['MMS-UserID'] ."', xcode = 'Rent', reference = 'Rent (". date('F Y', strtotime($_POST['DateTo'])) .")', Machine_No = '". SysLeaseSetup('Machine_No') ."', merchant_code = '". $rowActiveTenants['merchant_code'] ."', UnitID = '". $rowUnitList['UnitID'] ."';", $connection);
					}
	            }else if($rowActiveTenants['tenanttype'] == 'Fixed Rent'){
	                $resCharges = mysql_query("SELECT tenantid from tbltransaction WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND xcode = 'Rent' AND isMerchant = '0' AND xdate BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['DateTo'])) ."';", $connection);
					$countCharges = mysql_num_rows($resCharges);
					if($countCharges === 0){
						
						if($ProposalInfo['isRent'] == "0"){
							if($isVatable == "yes"){
				                if($isInclusive == "inc"){ //VAT IS INCLUSIVE
				                    $VATAmount = ( floatval($MonthlyRent) / 1.12 ) * $VATPercent;
				                    $RentLessVAT = floatval($MonthlyRent) - $VATAmount;
				                    $Amount = $RentLessVAT;
									$VAT = $VATAmount;
				                    $TotalAmount = $VAT + $Amount;
				                }else{ //VAT IS EXCLUSIVE
				                    $VATAmount = floatval($MonthlyRent) * $VATPercent;
				                    $RentPlusVAT = floatval($MonthlyRent);
				                    $Amount = floatval($MonthlyRent);
				                    $VAT = $VATAmount;
				                    $TotalAmount = floatval($MonthlyRent) + $VATAmount;
				                }
				            }else{
				            	$Amount = $MonthlyRent;
				                $VAT = "0.00";
				                $TotalAmount = floatval($MonthlyRent);
				            }
			            }else{
				                $Amount = $MonthlyRent;
				                $VAT = "0.00";
				                $TotalAmount = floatval($MonthlyRent);
			            }
						
						$SaveTransaction = mysql_query("INSERT INTO tbltransaction SET tenantid = '". $rowActiveTenants["TenantID"] ."', description = 'Rent', amount = '". floatval($MonthlyRent) ."', vatamount = '". $VAT ."', balance = '". $TotalAmount ."', totalamount = '". $TotalAmount ."', qty = 1, xdate = '". date("Y-m-d", strtotime($_POST['DateTo'])) ."', tenanttype = '". $rowActiveTenants["tenanttype"] ."', revpercent = '". $rowActiveTenants["revpercent"] ."', xdescription = 'Fixed Rent', userid = '". $_SESSION['MMS-UserID'] ."', xcode = 'Rent', reference = 'Rent (". date('F Y', strtotime($_POST['DateTo'])) .")', Machine_No = '". SysLeaseSetup('Machine_No') ."', merchant_code = '". $rowActiveTenants['merchant_code'] ."', UnitID = '". $rowUnitList['UnitID'] ."';", $connection);
					}
	            }else if($rowActiveTenants['tenanttype'] == 'Share Only'){
	                $resCharges = mysql_query("SELECT tenantid from tbltransaction WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND xcode = 'Rent' AND isMerchant = '0' AND xdate BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['DateTo'])) ."';", $connection);
					$countCharges = mysql_num_rows($resCharges);
					if($countCharges === 0){

						$TotalRevenue = mysql_fetch_array(mysql_query("SELECT SUM(". $tblSales[6] .") FROM ". $tblSales[0] ." WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND ". $tblSales[1] ." BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND  '". date('Y-m-d', strtotime($_POST['DateTo'])) ."';", $connection));
						$RevenuePercentage = floatval($TotalRevenue[0]) * (floatval($rowActiveTenants["revpercent"]) /100);

						if($ProposalInfo['isRent'] == "0"){
							if($isVatable == "yes"){
				                if($isInclusive == "inc"){ //VAT IS INCLUSIVE
				                    $VATAmount = ( floatval($RevenuePercentage) / 1.12 ) * $VATPercent;
				                    $RentLessVAT = floatval($RevenuePercentage) - $VATAmount;
				                    $Amount = $RentLessVAT;
									$VAT = $VATAmount;
				                    $TotalAmount = $VAT + $Amount;
				                }else{ //VAT IS EXCLUSIVE
				                    $VATAmount = floatval($RevenuePercentage) * $VATPercent;
				                    $RentPlusVAT = floatval($RevenuePercentage);
				                    $Amount = floatval($RevenuePercentage);
				                    $VAT = $VATAmount;
				                    $TotalAmount = floatval($RevenuePercentage) + $VATAmount;
				                }
				            }else{
				            	$Amount = $RevenuePercentage;
				                $VAT = "0.00";
				                $TotalAmount = floatval($RevenuePercentage);
				            }
			            }else{
			                $Amount = $RevenuePercentage;
			                $VAT = "0.00";
			                $TotalAmount = floatval($RevenuePercentage);
			            }
						
						$SaveTransaction = mysql_query("INSERT INTO tbltransaction SET tenantid = '". $rowActiveTenants["TenantID"] ."', description = 'Rent', amount = '". $RevenuePercentage ."', vatamount = '". $VAT ."', balance = '". $TotalAmount ."', totalamount = '". $TotalAmount ."', qty = 1, xdate = '". date("Y-m-d", strtotime($_POST['DateTo'])) ."', tenanttype = '". $rowActiveTenants["tenanttype"] ."', revpercent = '". $rowActiveTenants["revpercent"] ."', xdescription = '". $rowActiveTenants["revpercent"] ."% of Gross Sales', userid = '". $_SESSION['MMS-UserID'] ."', xcode = 'Rent', reference = '". $rowActiveTenants["revpercent"] ."% of ". number_format($TotalRevenue[0], "2", ".", ",") ." (". date('F Y', strtotime($_POST['DateTo'])) .")', Machine_No = '". SysLeaseSetup('Machine_No') ."', merchant_code = '". $rowActiveTenants['merchant_code'] ."', UnitID = '". $rowUnitList['UnitID'] ."';", $connection);
					}
	            }else if($rowActiveTenants['tenanttype'] == 'Share Only2'){
	                $resCharges = mysql_query("SELECT tenantid from tbltransaction WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND xcode = 'Rent' AND isMerchant = '0' AND xdate BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['DateTo'])) ."';", $connection);
					$countCharges = mysql_num_rows($resCharges);
					if($countCharges === 0){

						$TotalRevenue = mysql_fetch_array(mysql_query("SELECT SUM(". $tblSales[6] .") FROM ". $tblSales[0] ." WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND ". $tblSales[1] ." BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND  '". date('Y-m-d', strtotime($_POST['DateTo'])) ."';", $connection));
						$RevenuePercentage = floatval($TotalRevenue[0]) * (floatval($rowActiveTenants["revpercent"]) /100);

						if($ProposalInfo['isRent'] == "0"){
							if($isVatable == "yes"){
				                if($isInclusive == "inc"){ //VAT IS INCLUSIVE
				                    $VATAmount = ( floatval($RevenuePercentage) / 1.12 ) * $VATPercent;
				                    $RentLessVAT = floatval($RevenuePercentage) - $VATAmount;
				                    $Amount = $RentLessVAT;
									$VAT = $VATAmount;
				                    $TotalAmount = $VAT + $Amount;
				                }else{ //VAT IS EXCLUSIVE
				                    $VATAmount = floatval($RevenuePercentage) * $VATPercent;
				                    $RentPlusVAT = floatval($RevenuePercentage);
				                    $Amount = floatval($RevenuePercentage);
				                    $VAT = $VATAmount;
				                    $TotalAmount = floatval($RevenuePercentage) + $VATAmount;
				                }
				            }else{
				            	$Amount = $RevenuePercentage;
				                $VAT = "0.00";
				                $TotalAmount = floatval($RevenuePercentage);
				            }
			            }else{
			                $Amount = $RevenuePercentage;
			                $VAT = "0.00";
			                $TotalAmount = floatval($RevenuePercentage);
			            }
						
						$SaveTransaction = mysql_query("INSERT INTO tbltransaction SET tenantid = '". $rowActiveTenants["TenantID"] ."', description = 'Rent', amount = '". $RevenuePercentage ."', vatamount = '". $VAT ."', balance = '". $TotalAmount ."', totalamount = '". $TotalAmount ."', qty = 1, xdate = '". date("Y-m-d", strtotime($_POST['DateTo'])) ."', tenanttype = '". $rowActiveTenants["tenanttype"] ."', revpercent = '". $rowActiveTenants["revpercent"] ."', xdescription = '". $rowActiveTenants["revpercent"] ."% of Net Sales', userid = '". $_SESSION['MMS-UserID'] ."', xcode = 'Rent', reference = '". $rowActiveTenants["revpercent"] ."% of ". number_format($TotalRevenue[0], "2", ".", ",") ." (". date('F Y', strtotime($_POST['DateTo'])) .")', Machine_No = '". SysLeaseSetup('Machine_No') ."', merchant_code = '". $rowActiveTenants['merchant_code'] ."', UnitID = '". $rowUnitList['UnitID'] ."';", $connection);
					}
	            }else if($rowActiveTenants['tenanttype'] == 'Rent Rev'){
	                $resCharges = mysql_query("SELECT tenantid from tbltransaction WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND xcode = 'Rent' AND isMerchant = '0' AND xdate BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['DateTo'])) ."';", $connection);
					$countCharges = mysql_num_rows($resCharges);
					if($countCharges === 0){
						if($ProposalInfo['isRent'] == "0"){
							if($isVatable == "yes"){
				                if($isInclusive == "inc"){ //VAT IS INCLUSIVE
				                    $VATAmount = ( floatval($MonthlyRent) / 1.12 ) * $VATPercent;
				                    $RentLessVAT = floatval($MonthlyRent) - $VATAmount;
				                    $Amount = $RentLessVAT;
									$VAT = $VATAmount;
				                    $TotalAmount = $VAT + $Amount;
				                }else{ //VAT IS EXCLUSIVE
				                    $VATAmount = floatval($MonthlyRent) * $VATPercent;
				                    $RentPlusVAT = floatval($MonthlyRent);
				                    $Amount = floatval($MonthlyRent);
				                    $VAT = $VATAmount;
				                    $TotalAmount = floatval($MonthlyRent) + $VATAmount;
				                }
				            }else{
				            	$Amount = $MonthlyRent;
				                $VAT = "0.00";
				                $TotalAmount = floatval($MonthlyRent);
				            }
			            }else{
			                $Amount = $MonthlyRent;
			                $VAT = "0.00";
			                $TotalAmount = floatval($MonthlyRent);
			            }
						
						$SaveTransaction = mysql_query("INSERT INTO tbltransaction SET tenantid = '". $rowActiveTenants["TenantID"] ."', description = 'Rent', amount = '". floatval($MonthlyRent) ."', vatamount = '". $VAT ."', balance = '". $TotalAmount ."', totalamount = '". $TotalAmount ."', qty = 1, xdate = '". date("Y-m-d", strtotime($_POST['DateTo'])) ."', tenanttype = '". $rowActiveTenants["tenanttype"] ."', revpercent = '". $rowActiveTenants["revpercent"] ."', xdescription = 'Basic Rent/SQM', userid = '". $_SESSION['MMS-UserID'] ."', xcode = 'Rent', reference = 'Rent (". date("F Y", strtotime($_POST['DateTo'])) .")', Machine_No = '". SysLeaseSetup('Machine_No') ."', merchant_code = '". $rowActiveTenants['merchant_code'] ."', UnitID = '". $rowUnitList['UnitID'] ."';", $connection);

						$TotalRevenue = mysql_fetch_array(mysql_query("SELECT SUM(". $tblSales[6] .") FROM ". $tblSales[0] ." WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND ". $tblSales[1] ." BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND  '". date('Y-m-d', strtotime($_POST['DateTo'])) ."';", $connection));
						$RevenuePercentage = floatval($TotalRevenue[0]) * (floatval($rowActiveTenants["revpercent"]) /100);

						if($ProposalInfo['isRent'] == "0"){
							if($isVatable == "yes"){
				                if($isInclusive == "inc"){ //VAT IS INCLUSIVE
				                    $VATAmount = ( floatval($RevenuePercentage) / 1.12 ) * $VATPercent;
				                    $RentLessVAT = floatval($RevenuePercentage) - $VATAmount;
				                    $Amount = $RentLessVAT;
									$VAT = $VATAmount;
				                    $TotalAmount = $VAT + $Amount;
				                }else{ //VAT IS EXCLUSIVE
				                    $VATAmount = floatval($RevenuePercentage) * $VATPercent;
				                    $RentPlusVAT = floatval($RevenuePercentage);
				                    $Amount = floatval($RevenuePercentage);
				                    $VAT = $VATAmount;
				                    $TotalAmount = floatval($RevenuePercentage) + $VATAmount;
				                }
				            }else{
				            	$Amount = $RevenuePercentage;
			                	$VAT = "0.00";
			                	$TotalAmount = floatval($RevenuePercentage);
				            }
			            }else{
			                $Amount = $RevenuePercentage;
			                $VAT = "0.00";
			                $TotalAmount = floatval($RevenuePercentage);
			            }

						$SaveTransaction = mysql_query("INSERT INTO tbltransaction SET tenantid = '". $rowActiveTenants["TenantID"] ."', description = 'Rent', amount = '". $RevenuePercentage ."', vatamount = '". $VAT ."', balance = '". $TotalAmount ."', totalamount = '". $TotalAmount ."', qty = 1, xdate = '". date("Y-m-d", strtotime($_POST['DateTo'])) ."', tenanttype = '". $rowActiveTenants["tenanttype"] ."', revpercent = '". $rowActiveTenants["revpercent"] ."', xdescription = '". $rowActiveTenants["revpercent"] ."% of Gross Sales', userid = '". $_SESSION['MMS-UserID'] ."', xcode = 'Rent', reference = '". $rowActiveTenants["revpercent"] ."% of ". number_format($TotalRevenue[0], "2", ".", ",") ." (". date('F Y', strtotime($_POST['DateTo'])) .")', merchant_code = '". $rowActiveTenants['merchant_code'] ."', UnitID = '". $rowUnitList['UnitID'] ."';", $connection);
					}
	            }else if($rowActiveTenants['tenanttype'] == 'Rent or Share'){
	                $resCharges = mysql_query("SELECT tenantid from tbltransaction WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND xcode = 'Rent' AND isMerchant = '0' AND xdate BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['DateTo'])) ."';", $connection);
					$countCharges = mysql_num_rows($resCharges);
					if($countCharges === 0){
						$TotalRent = 0;
						$resUnitList = mysql_query("SELECT a.UnitID, b.pricepersqmunitsetup, b.area, b.sqm_height, b.sqm_width FROM tbltrans_inquiry_unit AS a LEFT JOIN tblref_unit AS b ON a.UnitID = b.unitid WHERE a.InquiryID = '". $rowActiveTenants['inqID'] ."';", $connection);
						while($rowUnitList = mysql_fetch_array($resUnitList)){

							if(SysLeaseSetup('floorandunitmeasurement') == "Area"){
	                        	$TotalArea = $rowUnitList['area'];
	                        }else{
	                        	$TotalArea = floatval($rowUnitList['sqm_height'] * $rowUnitList['sqm_width']);
	                    	}

	                    	$TotalRent += $TotalArea * $rowUnitList['pricepersqmunitsetup'];
						}

						$TotalRevenue = mysql_fetch_array(mysql_query("SELECT SUM(". $tblSales[6] .") FROM ". $tblSales[0] ." WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND ". $tblSales[1] ." BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND  '". date('Y-m-d', strtotime($_POST['DateTo'])) ."';", $connection));
						$RevenuePercentage = floatval($TotalRevenue[0]) * (floatval($rowActiveTenants["revpercent"]) /100);

						if($MonthlyRent > $RevenuePercentage){
							$Rent = $MonthlyRent;
						}else{
							$Rent = $RevenuePercentage;
						}

						if($ProposalInfo['isRent'] == "0"){
							if($isVatable == "yes"){
				                if($isInclusive == "inc"){ //VAT IS INCLUSIVE
				                    $VATAmount = ( floatval($Rent) / 1.12 ) * $VATPercent;
				                    $RentLessVAT = floatval($Rent) - $VATAmount;
				                    $Amount = $RentLessVAT;
									$VAT = $VATAmount;
				                    $TotalAmount = $VAT + $Amount;
				                }else{ //VAT IS EXCLUSIVE
				                    $VATAmount = floatval($Rent) * $VATPercent;
				                    $RentPlusVAT = floatval($Rent);
				                    $Amount = floatval($Rent);
				                    $VAT = $VATAmount;
				                    $TotalAmount = floatval($Rent) + $VATAmount;
				                }
				            }else{
				            	$Amount = $Rent;
				                $VAT = "0.00";
				                $TotalAmount = floatval($Rent);
				            }
			            }else{
			                $Amount = $Rent;
			                $VAT = "0.00";
			                $TotalAmount = floatval($Rent);
			            }
						
						if($MonthlyRent > $RevenuePercentage){
							if($ProposalInfo['isRent'] == "0"){
								if($isVatable == "yes"){
					                if($isInclusive == "inc"){ //VAT IS INCLUSIVE
					                    $VATAmount = ( floatval($MonthlyRent) / 1.12 ) * $VATPercent;
					                    $RentLessVAT = floatval($MonthlyRent) - $VATAmount;
					                    $Amount = $RentLessVAT;
										$VAT = $VATAmount;
					                    $TotalAmount = $VAT + $Amount;
					                }else{ //VAT IS EXCLUSIVE
					                    $VATAmount = floatval($MonthlyRent) * $VATPercent;
					                    $RentPlusVAT = floatval($MonthlyRent);
					                    $Amount = floatval($MonthlyRent);
					                    $VAT = $VATAmount;
					                    $TotalAmount = floatval($MonthlyRent) + $VATAmount;
					                }
					            }else{
					            	$Amount = $MonthlyRent;
					                $VAT = "0.00";
					                $TotalAmount = floatval($MonthlyRent);
					            }
				            }else{
				                $Amount = $MonthlyRent;
				                $VAT = "0.00";
				                $TotalAmount = floatval($MonthlyRent);
				            }
							
							$SaveTransaction = mysql_query("INSERT INTO tbltransaction SET tenantid = '". $rowActiveTenants["TenantID"] ."', description = 'Rent', amount = '". floatval($MonthlyRent) ."', vatamount = '". $VAT ."', balance = '". $TotalAmount ."', totalamount = '". $TotalAmount ."', qty = 1, xdate = '". date("Y-m-d", strtotime($_POST['DateTo'])) ."', tenanttype = '". $rowActiveTenants["tenanttype"] ."', revpercent = '". $rowActiveTenants["revpercent"] ."', xdescription = 'Basic Rent/SQM', userid = '". $_SESSION['MMS-UserID'] ."', xcode = 'Rent', reference = 'Rent (". date("F Y", strtotime($_POST['DateTo'])) .")', Machine_No = '". SysLeaseSetup('Machine_No') ."', merchant_code = '". $rowActiveTenants['merchant_code'] ."', UnitID = '". $rowUnitList['UnitID'] ."';", $connection);
						}else{
							$SaveTransaction = mysql_query("INSERT INTO tbltransaction SET tenantid = '". $rowActiveTenants["TenantID"] ."', description = 'Rent', amount = '". $RevenuePercentage ."', vatamount = '". $VAT ."', balance = '". $TotalAmount ."', totalamount = '". $TotalAmount ."', qty = 1, xdate = '". date("Y-m-d", strtotime($_POST['DateTo'])) ."', tenanttype = '". $rowActiveTenants["tenanttype"] ."', revpercent = '". $rowActiveTenants["revpercent"] ."', xdescription = '". $rowActiveTenants["revpercent"] ."% of Gross Sales', userid = '". $_SESSION['MMS-UserID'] ."', xcode = 'Rent', reference = '". $rowActiveTenants["revpercent"] ."% of ". number_format($TotalRevenue[0], "2", ".", ",") ." (". date('F Y', strtotime($_POST['DateTo'])) .")', Machine_No = '". SysLeaseSetup('Machine_No') ."', merchant_code = '". $rowActiveTenants['merchant_code'] ."', UnitID = '". $rowUnitList['UnitID'] ."';", $connection);
						}
					}
	            }else{
	                $resCharges = mysql_query("SELECT tenantid from tbltransaction WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND xcode = 'Rent' AND isMerchant = '0' AND xdate BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['DateTo'])) ."';", $connection);
					$countCharges = mysql_num_rows($resCharges);
					if($countCharges === 0){
						
						if($ProposalInfo['isRent'] == "0"){
							if($isVatable == "yes"){
				                if($isInclusive == "inc"){ //VAT IS INCLUSIVE
				                    $VATAmount = ( floatval($MonthlyRent) / 1.12 ) * $VATPercent;
				                    $RentLessVAT = floatval($MonthlyRent) - $VATAmount;
				                    $Amount = $RentLessVAT;
									$VAT = $VATAmount;
				                    $TotalAmount = $VAT + $Amount;
				                }else{ //VAT IS EXCLUSIVE
				                    $VATAmount = floatval($MonthlyRent) * $VATPercent;
				                    $RentPlusVAT = floatval($MonthlyRent);
				                    $Amount = floatval($MonthlyRent);
				                    $VAT = $VATAmount;
				                    $TotalAmount = floatval($MonthlyRent) + $VATAmount;
				                }
				            }else{
				            	$Amount = $MonthlyRent;
				                $VAT = "0.00";
				                $TotalAmount = floatval($MonthlyRent);
				            }
			            }else{
			                $Amount = $MonthlyRent;
			                $VAT = "0.00";
			                $TotalAmount = floatval($MonthlyRent);
			            }
						
						$SaveTransaction = mysql_query("INSERT INTO tbltransaction SET tenantid = '". $rowActiveTenants["TenantID"] ."', description = 'Rent', amount = '". floatval($MonthlyRent) ."', vatamount = '". $VAT ."', balance = '". $TotalAmount ."', totalamount = '". $TotalAmount ."', qty = 1, xdate = '". date("Y-m-d", strtotime($_POST['DateTo'])) ."', tenanttype = '". $rowActiveTenants["tenanttype"] ."', revpercent = '". $rowActiveTenants["revpercent"] ."', xdescription = 'Basic Rent/SQM', userid = '". $_SESSION['MMS-UserID'] ."', xcode = 'Rent', reference = 'Rent (". date('F Y', strtotime($_POST['DateTo'])) .")', Machine_No = '". SysLeaseSetup('Machine_No') ."', merchant_code = '". $rowActiveTenants['merchant_code'] ."', UnitID = '". $rowUnitList['UnitID'] ."';", $connection);
					}
	            }

	            // POSTING OF MONTHLY CHARGES
				$resProCharges = mysql_query("SELECT ChargeCode, ChargeAmount, ChargeType, UnitID, ChargeDesc FROM tbltrans_procharges WHERE InquiryID = '". $rowActiveTenants['inqID'] ."' AND ProposalNum = '". $rowActiveTenants['ActiveProposal'] ."';", $connection);
				while($rowProCharges = mysql_fetch_array($resProCharges)){

					$rowEscaBR = mysql_fetch_array(mysql_query("SELECT MAX(EscaTotal), UnitID, ChargeCode FROM tbltrans_chargeesca_br WHERE InquiryID = '". $rowActiveTenants['inqID'] ."' AND ProposalNum = '". $rowActiveTenants['ActiveProposal'] ."' AND STR_TO_DATE(EscaYear, '%M %Y') <= '". date('Y-m-d', strtotime($_POST['DateTo'])) ."' AND ChargeCode = '". $rowProCharges['ChargeCode'] ."';", $connection));
					$EscalatedChargeAmount = floatval($rowEscaBR[0]);

	            	$UnitInfo = mysql_fetch_array(mysql_query("SELECT area, sqm_width, sqm_height FROM tblref_unit WHERE unitid = '". $rowProCharges['UnitID'] ."';", $connection));

	            	if(SysLeaseSetup('floorandunitmeasurement') == "Area"){
                    	$TotalArea = floatval($UnitInfo['area']);
                    }else{
                    	$TotalArea = floatval($UnitInfo['sqm_width']) * floatval($UnitInfo['sqm_height']);
                    }

	            	if($EscalatedChargeAmount == 0){
						if($rowProCharges['ChargeType'] == "Persqm"){
		            		$ChargeAmount = floatval($rowProCharges['ChargeAmount']) * floatval($TotalArea);
		            		$Qty = floatval($TotalArea);
		            	}else if($rowProCharges['ChargeType'] == "Daily"){
		            		$ChargeAmount = floatval($rowProCharges['ChargeAmount']) * floatval($Days);
		            		$Qty = floatval($Days);
		            	}else if($rowProCharges['ChargeType'] == "Fixed"){
		            		$ChargeAmount = floatval($rowProCharges['ChargeAmount']);
		            		$Qty = 1;
		            	}else{
		            		$ChargeAmount = floatval($rowProCharges['ChargeAmount']);
		            		$Qty = 1;
		            	}
					}else{
						$ChargeAmount = floatval($EscalatedChargeAmount);
	            		$Qty = 1;
					}

	            	if($ProposalInfo['isRent'] == "0"){
						if($isVatable == "yes"){
			                if($isInclusive == "inc"){ //VAT IS INCLUSIVE
			                    $VATAmount = ( floatval($ChargeAmount) / 1.12 ) * $VATPercent;
			                    $RentLessVAT = floatval($ChargeAmount) - $VATAmount;
			                    $Amount = $RentLessVAT;
								$VAT = $VATAmount;
			                    $TotalAmount = $VAT + $Amount;
			                }else{ //VAT IS EXCLUSIVE
			                    $VATAmount = floatval($ChargeAmount) * $VATPercent;
			                    $RentPlusVAT = floatval($ChargeAmount);
			                    $Amount = floatval($ChargeAmount);
			                    $VAT = $VATAmount;
			                    $TotalAmount = floatval($ChargeAmount) + $VATAmount;
			                }
			            }else{
			            	$Amount = $ChargeAmount;
			                $VAT = "0.00";
			                $TotalAmount = floatval($ChargeAmount);
			            }
		            }else{
		                $Amount = $ChargeAmount;
		                $VAT = "0.00";
		                $TotalAmount = floatval($ChargeAmount);
		            }
		            $CheckifPosted = mysql_num_rows(mysql_query("SELECT id FROM tbltransaction WHERE tenantid = '". $rowActiveTenants["TenantID"] ."' AND xcode = '". $rowProCharges['ChargeCode'] ."' AND isMerchant = '0' AND xdate BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['DateTo'])) ."' AND UnitID = '". $rowProCharges['UnitID'] ."';", $connection));
		            if($CheckifPosted == 0){
						$SaveTransaction = mysql_query("INSERT INTO tbltransaction SET tenantid = '". $rowActiveTenants["TenantID"] ."', description = '". $rowProCharges['ChargeDesc'] ."', amount = '". $Amount ."', vatamount = '". $VAT ."', balance = '". $TotalAmount ."', totalamount = '". $TotalAmount ."', qty = '". $Qty ."', xdate = '". date("Y-m-d", strtotime($_POST['DateTo'])) ."', tenanttype = '". $rowActiveTenants["tenanttype"] ."', revpercent = '". $rowActiveTenants["revpercent"] ."', xdescription = 'Monthly - ". $rowProCharges['ChargeDesc'] ."', userid = '". $_SESSION['MMS-UserID'] ."', xcode = '". $rowProCharges['ChargeCode'] ."', reference = '". $rowProCharges['ChargeDesc'] ."', Machine_No = '". SysLeaseSetup('Machine_No') ."', merchant_code = '". $rowActiveTenants['merchant_code'] ."', UnitID = '". $rowProCharges['UnitID'] ."';", $connection);
		            }
				}

				$chkBegBalance = mysql_num_rows(mysql_query("SELECT id FROM tbltransaction WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND xcode = 'BEG_BAL';", $connection));
				if($chkBegBalance == 0){
					$VATAmount = ( floatval($rowActiveTenants['Beg_Balance']) / 1.12 ) * $VATPercent;
                    $RentLessVAT = floatval($rowActiveTenants['Beg_Balance']) - $VATAmount;
                    $Amount = $RentLessVAT;
					$VAT = $VATAmount;
                    $TotalAmount = $VAT + $Amount;
					$SaveTransaction = mysql_query("INSERT INTO tbltransaction SET tenantid = '". $rowActiveTenants["TenantID"] ."', description = 'BEGINNING BALANCE', amount = '". $Amount ."', vatamount = '". $VAT ."', balance = '". $TotalAmount ."', totalamount = '". $TotalAmount ."', qty = '1', xdate = '". date("Y-m-d", strtotime($rowActiveTenants['Beg_Date'])) ."', tenanttype = '". $rowActiveTenants["tenanttype"] ."', revpercent = '". $rowActiveTenants["revpercent"] ."', xdescription = 'BEGINNING BALANCE', userid = '". $_SESSION['MMS-UserID'] ."', xcode = 'BEG_BAL', reference = 'BEGINNING BAL. (". date("F Y", strtotime($rowActiveTenants['Beg_Date'])) .")', Machine_No = '". SysLeaseSetup('Machine_No') ."', merchant_code = '". $rowActiveTenants['merchant_code'] ."', UnitID = '". $rowProCharges['UnitID'] ."';", $connection);
				}

				// PAYMENT LEFT
				$PaymentLeft = mysql_fetch_array(mysql_query("SELECT pleft, payment, Forwbal, currcharg, Currbal FROM dunn_tblsoaheader WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND duedate < '". date('Y-m-d', strtotime($_POST['DueDate'])) ."' ORDER BY duedate DESC LIMIT 1;", $connection));

				$CtrlNo = mysql_fetch_array(mysql_query("SELECT ctrlno FROM dunn_tblsoaheader WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND soaid = '". $_POST['SoAID'] ."';", $connection));

				$PrevCtrlNo = mysql_fetch_array(mysql_query("SELECT ctrlno FROM dunn_tblsoaheader WHERE soaid = '". $_POST['SoAID'] ."' ORDER BY ctrlno DESC;"));

				// TOTAL PAYMENT MADE WITHIN THE BILLING PERIOD
				$TotalPayment = mysql_fetch_array(mysql_query("SELECT SUM(totalamount) FROM tbltransaction WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND amount < 0 AND (xdate BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '".date("Y-m-d", strtotime($_POST["DueDate"]))."') AND SoAID = '". $_POST['SoAID'] ."';", $connection));

				// TOTAL UNPROCESSED PAYMENT MADE WITHIN THE BILLING PERIOD
				$TotalNewPayment = mysql_fetch_array(mysql_query("SELECT SUM(totalamount) FROM tbltransaction WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND amount < 0 AND (xdate BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '".date("Y-m-d", strtotime($_POST["DueDate"]))."') AND (SoAID IS NULL OR SoAID = '');", $connection));

				// Total PREVIOUS ALANCE
				$TotalPrevBal = mysql_fetch_array(mysql_query("SELECT SUM(balance) FROM tbltransaction WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND xdate < '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND (paymenttype IS NULL OR paymenttype = '') AND isPenalty = '0';", $connection));

				//Current CHARGE
				$CurrCharge = mysql_fetch_array(mysql_query("SELECT SUM(totalamount) FROM tbltransaction WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND xdate BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['DateTo'])) ."' AND (paymenttype IS NULL OR paymenttype = '') AND isPenalty = '0';", $connection));

				//Current BALANCE
				$CurrBal = mysql_fetch_array(mysql_query("SELECT SUM(balance) FROM tbltransaction WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND xdate BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['DateTo'])) ."' AND (paymenttype IS NULL OR paymenttype = '') AND isPenalty = '0';", $connection));

				// 1 - 30 DAYS
				$PrevBal13 = mysql_fetch_array(mysql_query("SELECT SUM(balance) FROM tbltransaction WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND (xdate BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'].'-30 day')) ."' AND '". date('Y-m-d', strtotime($_POST['DateFrom'].'-1 day')) ."') AND (paymenttype IS NULL OR paymenttype = '') AND isPenalty = '0';", $connection));

				// 31 - 60 DAYS
				$PrevBal36 = mysql_fetch_array(mysql_query("SELECT SUM(balance) FROM tbltransaction WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND (xdate BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'].'-60 day')) ."' AND '". date('Y-m-d', strtotime($_POST['DateFrom'].'-31 day')) ."') AND (paymenttype IS NULL OR paymenttype = '') AND isPenalty = '0';", $connection));

				// 61 - 90 DAYS
				$PrevBal69 = mysql_fetch_array(mysql_query("SELECT SUM(balance) FROM tbltransaction WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND (xdate BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'].'-90 day')) ."' AND '". date('Y-m-d', strtotime($_POST['DateFrom'].'-61 day')) ."') AND (paymenttype IS NULL OR paymenttype = '') AND isPenalty = '0';", $connection));

				// OVER 91 DAYS
				$PrevBal91 = mysql_fetch_array(mysql_query("SELECT SUM(balance) FROM tbltransaction WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND xdate <= '". date('Y-m-d', strtotime($_POST['DateFrom'].'-91 day')) ."' AND (paymenttype IS NULL OR paymenttype = '') AND isPenalty = '0';", $connection));

				$OtherCharges = mysql_fetch_array(mysql_query("SELECT SUM(totalamount) FROM tbltransaction WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND (xdate BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['DateTo'])) ."') AND paymenttype = '' AND (description NOT LIKE '%Rent%' AND description NOT LIKE '%Association Dues%') AND (paymenttype IS NULL OR paymenttype = '') AND isPenalty = '0';", $connection));

				$TotalRentalCharges = mysql_fetch_array(mysql_query("SELECT SUM(totalamount) FROM tbltransaction WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND (xdate BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['DateTo'])) ."') AND paymenttype = '' AND (description LIKE '%Rent%' OR description LIKE '%Association Dues%') AND (paymenttype IS NULL OR paymenttype = '') AND isPenalty = '0';", $connection));

				$TotalRevenue = mysql_fetch_array(mysql_query("SELECT SUM(". $tblSales[6] .") FROM ". $tblSales[0] ." WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND (". $tblSales[1] ." BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['DateTo'])) ."');", $connection));

				$CurrentPenalty = mysql_fetch_array(mysql_query("SELECT SUM(totalamount) FROM tbltransaction WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND xdate BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['DateTo'])) ."' AND (paymenttype IS NULL OR paymenttype = '') AND isPenalty = '1';", $connection));

				$PrevPenalty = mysql_fetch_array(mysql_query("SELECT SUM(balance) FROM tbltransaction WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND xdate < '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND (paymenttype IS NULL OR paymenttype = '') AND isPenalty = '1';", $connection));

				$PaymentRunning = floatval($PaymentLeft[0]) + floatval($TotalNewPayment[0]); //Payment TOTAL
				$CurrentTotalPayment = floatval($TotalPayment[0]) + floatval($PaymentLeft[0]) + floatval($TotalNewPayment[0]); //Current Total Payment
				$CurrentCharge = floatval($CurrBal[0]) + floatval($CurrentPenalty[0]); //CURRENT CHARGES

				// OVER 90 DAYS
				if($PaymentRunning > 0){
					$Balance91 = $PrevBal91[0] - $PaymentRunning;
				}else{
					$Balance91 = $PrevBal91[0];
				}
				if($Balance91 < 0){
					$PaymentRunning = $Balance91 * -1;
					$Balance91 = 0;
				}else{
					$PaymentRunning = 0;
				}

				// 61 TO 90 DAYS
				if($PaymentRunning > 0){
					$Balance69 = $PrevBal69[0] - $PaymentRunning;
				}else{
					$Balance69 = $PrevBal69[0];
				}
				if($Balance69 < 0){
					$PaymentRunning = $Balance69 * -1;
					$Balance69 = 0;
				}else{
					$PaymentRunning = 0;
				}

				// 31 TO 60 DAYS
				if($PaymentRunning > 0){
					$Balance36 = $PrevBal36[0] - $PaymentRunning;
				}else{
					$Balance36 = $PrevBal36[0];
				}
				if($Balance36 < 0){
					$PaymentRunning = $Balance36 * -1;
					$Balance36 = 0;
				}else{
					$PaymentRunning = 0;
				}

				// CURRENT CHARGES
				if($PaymentRunning > 0){
					$Balance13 = $PrevBal13[0] - $PaymentRunning;
				}else{
					$Balance13 = $PrevBal13[0];
				}
				if($Balance13 < 0){
					$PaymentRunning = $Balance13 * -1;
					$Balance13 = 0;
				}else{
					$PaymentRunning = 0;
				}

				$Balance00 = $CurrBal[0] - $PaymentRunning;
				if($Balance00 < 0){
					$PaymentRunning = $Balance00 * -1;
					$Balance00 = 0;
				}else{
					$PaymentRunning = 0;
				}

				$CurrBalance = (floatval($Balance00) + floatval($Balance13) + floatval($Balance36) + floatval($Balance69) + floatval($Balance91) + floatval($CurrentPenalty[0]) + floatval($PrevPenalty[0])) - $PaymentRunning;

				if($CurrBalance < 0){
					$PaymentRunning = $CurrBalance * -1;
					$CurrBalance = 0;
				}else{
					$PaymentRunning = 0;
				}

				if($CtrlNo['ctrlno'] == ""){
					$CtrlNo = floatval($PrevCtrlNo['ctrlno']) + 1;
				}else{
					$CtrlNo = $CtrlNo['ctrlno'];
				}

				//UPDATING BALANCE ON tbltransaction
				// $PaymentRunning2 = floatval($TotalNewPayment[0]);
				// if($PaymentRunning2 > 0){
				// 	$resGetChargeWithBalance = mysql_query("SELECT balance, id, paymentamount FROM tbltransaction WHERE xdate <= '". date('Y-m-d', strtotime($_POST['DateTo'])) ."' AND tenantid = '" . $rowActiveTenants['TenantID'] . "' AND balance > 0 ORDER BY id ASC;", $connection);
				// 	while($rowChargesWithBalance = mysql_fetch_array($resGetChargeWithBalance)){

				// 		if($PaymentRunning2 > 0){
				// 			$Balance = $rowChargesWithBalance[0] - $PaymentRunning2;
				// 		}else{
				// 			$Balance = $rowChargesWithBalance[0];
				// 		}
				// 		if($Balance < 0){
				// 			$PaymentAmount = $rowChargesWithBalance[0];
				// 			$PaymentRunning2 = $Balance * -1;
				// 			$Balance = 0;
				// 		}else{
				// 			$PaymentAmount = $PaymentRunning2;
				// 			$PaymentRunning2 = 0;
				// 			$Balance = $Balance;
				// 		}

				// 		$updatebal = mysql_query("UPDATE tbltransaction SET balance = '". $Balance ."', paymentamount = '". floatval($PaymentAmount + $rowChargesWithBalance['paymentamount']) ."' WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND id = '". $rowChargesWithBalance[1] ."';", $connection);
				// 	}
				// }

				// $NewCurrBal = 0;
				// $resGetHeaderWithBalance = mysql_query("SELECT id, Currbal FROM dunn_tblsoaheader WHERE tenantid = '". $rowActiveTenants['TenantID'] ."'  ORDER BY duedate ASC;", $connection);
				// while($rowHeaderWithBalance = mysql_fetch_array($resGetHeaderWithBalance)){
				// 	if($CurrentTotalPayment > 0){
				// 		$NewCurrBal = $rowHeaderWithBalance['Currbal'] - $CurrentTotalPayment;
				// 	}else{
				// 		$NewCurrBal = $rowHeaderWithBalance['Currbal'];
				// 	}
				// 	if($NewCurrBal < 0){
				// 		$CurrentTotalPayment = $NewCurrBal * -1;
				// 		$NewCurrBal = 0;
				// 	}else{
				// 		$CurrentTotalPayment = 0;
				// 	}
				// 	$resUpdateHeader = mysql_query("UPDATE dunn_tblsoaheader SET Currbal = '". $NewCurrBal ."' WHERE id = '". $rowHeaderWithBalance['id'] ."';", $connection);

				// }

				$DeleteHeader = mysql_query("DELETE FROM dunn_tblsoaheader WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND soaid = '". $_POST['SoAID'] ."';", $connection);
				$DeleteDetails = mysql_query("DELETE FROM dunn_tblsoadetails WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND soano = '". $_POST['SoAID'] ."';", $connection);

				// $ZeroAllPayment = mysql_query("UPDATE tbltransaction SET balance = 0, SoAID = '". $_POST['SoAID'] ."' WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND paymenttype != '' AND xdate <= '". date('Y-m-d', strtotime($_POST['DueDate'])) ."' AND (SoAID IS NULL OR SoAID = '');", $connection);

				$SOAHeader = mysql_query("INSERT INTO dunn_tblsoaheader SET soaid = '". $_POST['SoAID'] ."', tenantid = '". $rowActiveTenants['TenantID'] ."', tenantname = '". $rowActiveTenants['tradename'] ."', totalamount = '". floatval($CurrCharge[0] + $ForwardingBalance + $CurrentPenalty[0]) ."', createdby = '". getusername() ."', datecreated = '". getsysdate() ."', duedate = '". date('Y-m-d', strtotime($_POST['DueDate'])) ."', tenantdues = '". floatval($TotalRentalCharges[0]) ."', revenue = '". floatval($TotalRevenue[0]) ."', Forwbal = '". floatval($ForwardingBalance) ."', currbal = '". floatval($CurrBalance) ."', payment = '". floatval($TotalPayment[0] + $TotalNewPayment[0]) ."', currcharg = '". floatval($CurrCharge[0] + $CurrentPenalty[0]) ."', hperiod = 'Not Posted', billno = '". $_POST['SoAID'] ."-". $CtrlNo ."', ctrlno = '". $CtrlNo ."', b13 = '". floatval($Balance13) ."', b36 = '". floatval($Balance36) ."', b69 = '". floatval($Balance69) ."', b99 = '". floatval($Balance91) ."', b00 = '". floatval($Balance00) ."', pleft = '". $PaymentRunning ."', penchrg = '". floatval($CurrentPenalty[0] + $PrevPenalty[0]) ."', soaperiod = '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."', soaperiod2 = '". date('Y-m-d', strtotime($_POST['DateTo'])) ."', Merchant_Code = '". $rowActiveTenants['merchant_code'] ."';", $connection);
				if($SOAHeader == true){
					// GET ALL CHARGES FOR THIS PERIOD
	    			$getAllCharges = mysql_query("SELECT tenantid, xcode, description, amount, qty, paymentamount, vatamount, balance, xdate, reference, xdatetime, isPenalty, paymenttype, cardholder, ccno, expdate, checkno, checkdate, checkname, bankname, cardtype, authno, secno, orno, totalamount, tenanttype, revpercent, bnkfrom, bnkto, accnofrom, accnoto, xdescription, isMerchant, merchant_code, id FROM tbltransaction WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND xdate BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['DateTo'])) ."' AND amount > 0;", $connection);
	    			while($rowAllCharges = mysql_fetch_array($getAllCharges)){
	    				$InsertCharges = mysql_query("INSERT INTO dunn_tblsoadetails SET soaNo = '". $_POST['SoAID'] ."', tenantid = '". $rowAllCharges['tenantid'] ."', xcode = '". $rowAllCharges['xcode'] ."', description = '". $rowAllCharges['description'] ."', amount = '". $rowAllCharges['amount'] ."', qty = '". $rowAllCharges['qty'] ."', paymentamount = '". $rowAllCharges['paymentamount'] ."', vatamount = '". $rowAllCharges['vatamount'] ."', balance = '". $rowAllCharges['balance'] ."', xdate = '". $rowAllCharges['xdate'] ."', reference = '". $rowAllCharges['reference'] ."', xdatetime = '". $rowAllCharges['xdatetime'] ."', isPenalty = '". $rowAllCharges['isPenalty'] ."', paymenttype = '". $rowAllCharges['paymenttype'] ."', cardholder = '". $rowAllCharges['cardholder'] ."', ccno = '". $rowAllCharges['ccno'] ."', expdate = '". $rowAllCharges['expdate'] ."', checkno = '". $rowAllCharges['checkno'] ."', checkdate = '". $rowAllCharges['checkdate'] ."', checkname = '". $rowAllCharges['checkname'] ."', bankname = '". $rowAllCharges['bankname'] ."', cardtype = '". $rowAllCharges['cardtype'] ."', authno = '". $rowAllCharges['authno'] ."', secno = '". $rowAllCharges['secno'] ."', orno = '". $rowAllCharges['orno'] ."', totalamount = '". $rowAllCharges['totalamount'] ."', tenanttype = '". $rowAllCharges['tenanttype'] ."', revpercent = '". $rowAllCharges['revpercent'] ."', bnkfrom = '". $rowAllCharges['bnkfrom'] ."', bnkto = '". $rowAllCharges['bnkto'] ."', accnofrom = '". $rowAllCharges['accnofrom'] ."', accnoto = '". $rowAllCharges['accnoto'] ."', xdescription = '". $rowAllCharges['xdescription'] ."', isMerchant = '". $rowAllCharges['isMerchant'] ."', merchant_code = '". $rowAllCharges['merchant_code'] ."';", $connection);
	    				$resUpdateSoaID = mysql_query("UPDATE tbltransaction SET SoAID = '". $_POST['SoAID'] ."' WHERE id = '". $rowAllCharges['id'] ."';", $connection);
	    			}

    				// GET ALL POSTED PAYMENT FOR THIS PERIOD
    				$getAllPayments = mysql_query("SELECT tenantid, xcode, description, amount, qty, paymentamount, vatamount, balance, xdate, transdate, reference, xdatetime, isPenalty, paymenttype, cardholder, ccno, expdate, checkno, checkdate, checkname, bankname, cardtype, authno, secno, orno, totalamount, tenanttype, revpercent, bnkfrom, bnkto, accnofrom, accnoto, xdescription, isMerchant, merchant_code, id FROM tbltransaction WHERE tenantid = '". $rowActiveTenants['TenantID'] ."' AND xdate BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['DueDate'])) ."' AND amount < 0;", $connection);
    				while($rowAllPayments = mysql_fetch_array($getAllPayments)){
    					if($rowAllPayments['xdate'] == ""){
	    					$PaymentDate = $rowAllPayments["transdate"];
	    				}else{
	    					$PaymentDate = $rowAllPayments["xdate"];
	    				}
	    				$InsertCharges = mysql_query("INSERT INTO dunn_tblsoadetails SET soaNo = '". $_POST['SoAID'] ."', tenantid = '". $rowAllPayments['tenantid'] ."', xcode = '". $rowAllPayments['xcode'] ."', description = '". $rowAllPayments['description'] ."', amount = '". $rowAllPayments['amount'] ."', qty = '". $rowAllPayments['qty'] ."', paymentamount = '". $rowAllPayments['paymentamount'] ."', vatamount = '". $rowAllPayments['vatamount'] ."', balance = '". $rowAllPayments['balance'] ."', xdate = '". $PaymentDate ."', reference = '". $rowAllPayments['reference'] ."', xdatetime = '". $rowAllPayments['xdatetime'] ."', isPenalty = '". $rowAllPayments['isPenalty'] ."', paymenttype = '". $rowAllPayments['paymenttype'] ."', cardholder = '". $rowAllPayments['cardholder'] ."', ccno = '". $rowAllPayments['ccno'] ."', expdate = '". $rowAllPayments['expdate'] ."', checkno = '". $rowAllPayments['checkno'] ."', checkdate = '". $rowAllPayments['checkdate'] ."', checkname = '". $rowAllPayments['checkname'] ."', bankname = '". $rowAllPayments['bankname'] ."', cardtype = '". $rowAllPayments['cardtype'] ."', authno = '". $rowAllPayments['authno'] ."', secno = '". $rowAllPayments['secno'] ."', orno = '". $rowAllPayments['orno'] ."', totalamount = '". $rowAllPayments['totalamount'] ."', tenanttype = '". $rowAllPayments['tenanttype'] ."', revpercent = '". $rowAllPayments['revpercent'] ."', bnkfrom = '". $rowAllPayments['bnkfrom'] ."', bnkto = '". $rowAllPayments['bnkto'] ."', accnofrom = '". $rowAllPayments['accnofrom'] ."', accnoto = '". $rowAllPayments['accnoto'] ."', xdescription = '". $rowAllPayments['xdescription'] ."', isMerchant = '". $rowAllPayments['isMerchant'] ."', merchant_code = '". $rowAllPayments['merchant_code'] ."';", $connection);
	    				$resUpdateSoaID = mysql_query("UPDATE tbltransaction SET SoAID = '". $_POST['SoAID'] ."' WHERE id = '". $rowAllCharges['id'] ."';", $connection);
    				}
    				$Success++;
				}
			}
			if($Success >= 1){
				echo "1|Statement of Account were successfully processed.|";
			}
		break;

		case 'chkcheckedsoatenant':
			$arr = explode("|", $_POST['TenantIDs']);
			for($i=0; $i <= COUNT($arr)-2; $i++){

				// $BillingSetup = mysql_fetch_array(mysql_query("SELECT BillingSetup FROM tblref_unit WHERE tenantid = '". $arr[$i] ."';", $connection));
	   //  		if($BillingSetup['BillingSetup'] == "Merged"){
	   //  			$getMainUnit = mysql_fetch_array(mysql_query("SELECT unitid FROM tbltrans_tenants WHERE TenantID = '". $arr[$i] ."';", $connection));
	   //  			$mgaMeron = "";
		  //   		$getSubUnits = mysql_query("SELECT TenantID FROM tblref_unit WHERE MainUnit = '". $getMainUnit['unitid'] ."';", $connection);
				// 	$SubUnitCount = mysql_num_rows($getSubUnits);
		  //   		while($rowSubUnits = mysql_fetch_array($getSubUnits)){
				// 		$mgaMeron .= "'" . $rowSubUnits['TenantID'] . "'" . ",";
		  //   		}

		  //   		if($SubUnitCount >= 1){
				// 		$TenantQuery = "(TenantID IN (". substr(trim($mgaMeron), 0, -1) .") OR TenantID = '". $arr[$i] ."')";
				// 	}else{
				// 		$TenantQuery = "TenantID = '". $rowUnit['TenantID'] ."'";
				// 	}
				// }else{
					$TenantQuery = "TenantID = '". $arr[$i] ."'";
				// }

			$SysTemplate = mysql_fetch_array(mysql_query("SELECT template FROM tblsys_setup;", $connection));
			$TenantInfo = mysql_fetch_array(mysql_query("SELECT mallCompanyID, mallID FROM tbltrans_tenants WHERE TenantID = '". $arr[$i] ."';", $connection));
			$MallCompanyID = mysql_fetch_array(mysql_query("SELECT MallCompanyName, MallCompanyAddress, MallCompanyTelephone, MallCompanyEmailAdd, MallCompanyImage FROM tblref_mallcompany WHERE MallCompanyID = '". $TenantInfo['mallCompanyID'] ."';", $connection));
			$Mall = mysql_fetch_array(mysql_query("SELECT mallname, malladdress, telephone_number, email, mall_image FROM tblref_mall WHERE mallid = '". $TenantInfo['mallID'] ."';", $connection));

            if($MallCompanyID['MallCompanyImage'] == ""){
                $image = "assets/images/noimage5.png";
            }else{
            	if(!file_exists("../Mall_Attachments/Mall_Company/".$MallCompanyID['MallCompanyImage'])){ 
					$image = "assets/images/noimage5.png";
				}else{
					$image = "../Mall_Attachments/Mall_Company/".$MallCompanyID['MallCompanyImage'];
				}
            }

			if($SysTemplate['template'] == "1"){
				$printheader =	"<tr>
							      	<td width='130px; padding:0px !important;'><img src='". $image ."' style='height: 130px; width: 150px !important;margin: 10px;'></td>
							      	<td style='padding-top:0px;'>
							      		<p style='padding: 0px; display: block;margin:0px;'><h1>". $MallCompanyID['MallCompanyName'] ."</h1></p>
							      		<p style='padding: 0px; display: block;margin:0px;'>". $Mall[1] ."</p>
							      		<p style='padding: 0px; display: block;margin:0px;'>". $Mall[2] ."</p>
							      		<p style='padding: 0px; display: block;margin:0px;'>". $Mall[3] ."</p>
							      	</td>
						      	</tr>";
			}else{
				$printheader =	"<tr>
							  		<td colspan='3' align='center'><img src='". $image ."' style='height: 130px; width: 150px !important;margin: 10px;'></td>
							  	</tr>
							  	<tr>
								  	<td colspan='3' align='center'>
								  		<p style='padding: 0px; display: block;margin:0px;'><h1>". $MallCompanyID['MallCompanyName'] ."</h1></p>
								  		<p style='padding: 0px; display: block;margin:0px;'>". $Mall[1] ."</p>
								  		<p style='padding: 0px; display: block;margin:0px;'>". $Mall[2] ."</p>
								  		<p style='padding: 0px; display: block;margin:0px;'>". $Mall[3] ."</p>
								  	</td>
							  	</tr>";
			}

				$TenantInfo = mysql_fetch_array(mysql_query("SELECT tradename, CompanyID, BillerID, datefrom, dateto, tradeID FROM tbltrans_tenants WHERE TenantID = '". $arr[$i] ."';", $connection));

				$getPrimaryContact = mysql_fetch_array(mysql_query("SELECT CASE WHEN MiddleName = '' OR MiddleName IS NULL THEN CONCAT(LastName, ', ', FirstName) ELSE CONCAT(LastName, ', ', FirstName, ' ', LEFT(MiddleName, '1'), '.') END FROM tbltrans_trade_contact_person WHERE tradeID = '". $TenantInfo['tradeID'] ."' AND isActive = '1' AND isPrimary = '1';", $connection));

				$BillerInfo = mysql_fetch_array(mysql_query("SELECT BillerName, BillingAddress FROM tblref_billprofile WHERE BillerID = '". $TenantInfo['BillerID'] ."';", $connection));

				$compadd = mysql_fetch_array(mysql_query("SELECT businessAddress from tbltrans_company where CompanyID = '" . $TenantInfo['CompanyID'] . "';", $connection));

				$soaheader = mysql_fetch_array(mysql_query("SELECT duedate, soaperiod2, billno, soaperiod, SUM(currcharg), SUM(Forwbal), SUM(payment), SUM(penchrg), SUM(Currbal) FROM dunn_tblsoaheader WHERE ". $TenantQuery ." AND soaid = '". $_POST['SoAID'] ."';", $connection));

    			$aging = mysql_fetch_array(mysql_query("SELECT SUM(b00), SUM(b13), SUM(b36), SUM(b69), SUM(b99) FROM dunn_tblsoaheader WHERE soaid = '". $_POST['SoAID'] ."' AND ". $TenantQuery .";", $connection));

	    		$totalcurrentcharges = mysql_fetch_array(mysql_query("SELECT SUM(totalamount) FROM dunn_tblsoadetails WHERE soano = '". $_POST['SoAID'] ."' AND (paymenttype IS NULL OR paymenttype = '') AND ". $TenantQuery .";", $connection));

	    		$totalpayment = mysql_fetch_array(mysql_query("SELECT SUM(totalamount) FROM dunn_tblsoadetails WHERE soano = '". $_POST['SoAID'] ."' AND (paymenttype IS NOT NULL AND paymenttype != '') AND ". $TenantQuery .";", $connection));

				$PrevBalance = mysql_fetch_array(mysql_query("SELECT SUM(b13 + b36 + b69 + b99) FROM dunn_tblsoaheader WHERE soaid = '". $_POST["soaid"] ."' ". $TenantQuery .";", $connection));

    			if($aging[0] == ""){
	    			$currcharg = $soaheader[4];
	    		}else{
	    			$currcharg = $aging[0];
	    		}

				$signatories = mysql_fetch_array(mysql_query("SELECT prepby, chkdby, apprby, rcvdby FROM mall_setup WHERE mall_id = '". $mallid[0] ."';", $connection));

				$arrprep = explode("|", $signatories[0]);
					$prep = $arrprep[1]. " " .substr($arrprep[2], 0, 1). ". " .$arrprep[0]; 
				$arrchecked = explode("|", $signatories[1]);
					$chkdby = $arrchecked[1]. " " .substr($arrchecked[2], 0, 1). ". " .$arrchecked[0];
				$arrappr = explode("|", $signatories[2]);
					$apprby = $arrappr[1]. " " .substr($arrappr[2], 0, 1). ". " .$arrappr[0];
				$arrrcvd = explode("|", $signatories[3]);
					$rcvdby = $arrrcvd[1]. " " .substr($arrrcvd[2], 0, 1). ". " .$arrrcvd[0];

				if(SysLeaseSetup('softwaretype') == '5'){
				 	$txtSystenant = "BUYER NAME"; 
				}else if(SysLeaseSetup('softwaretype') == '0'){
				 	$txtSystenant = "STORE NAME"; 
				}else{ 
					$txtSystenant = "TENANT NAME"; 
				}

				echo "
						<div style='width: 100%;margin-bottom: 0;'>
							<center>
								<table style='width: 100%;'>
									<tbody>". $printheader ."</tbody>
								</table>

								<table style='width: 100%;' cellpadding='0' cellspacing='0'>
									<tr>
										<td width='23%'><h6 style='font-weight: bold;margin: 3px;font-size: 12px;'>". $txtSystenant ."</h6></td>
										<td width='2%'>:</td>
										<td width='30%'><h6 style='font-weight: normal;margin: 3px;font-size: 12px;'>". $TenantInfo['tradename'] ."</h6></td>
										<td width='23%'><h6 style='font-weight: bold;margin: 3px;font-size: 12px;'>CUT-OFF DATE</h6></td>
										<td width='2%'>:</td>
										<td width='20%'><h6 style='font-weight: normal;margin: 3px;font-size: 12px;'>". date('F d, Y', strtotime($soaheader[0])) ."</h6></td>
									</tr>
									<tr>
										<td><h6 style='font-weight: bold;margin: 3px;font-size: 12px;'>BILL TO</h6></td>
										<td>:</td>
										<td><h6 style='font-weight: normal;margin: 3px;font-size: 12px;'>". $BillerInfo['BillerName'] ."</h6></td>
										<td><h6 style='font-weight: bold;margin: 3px;font-size: 12px;'>BILLING NO.</h6></td>
										<td>:</td>
										<td><h6 style='font-weight: normal;margin: 3px;font-size: 12px;'>". $soaheader['billno'] ."</h6></td>
									</tr>
									<tr>
										<td><h6 style='font-weight: bold;margin: 3px;font-size: 12px;'>ADDRESS</h6></td>
										<td>:</td>
										<td><h6 style='font-weight: normal;margin: 3px;font-size: 12px;'>". $BillerInfo['BillingAddress'] ."</h6></td>
										<td><h6 style='font-weight: bold;margin: 3px;font-size: 12px;'>COMMENCEMENT DATE</h6></td>
										<td>:</td>
										<td><h6 style='font-weight: normal;margin: 3px;font-size: 12px;'>". date('F d, Y', strtotime($TenantInfo['datefrom'])) ."</h6></td>
									</tr>
									<tr>
										<td><h6 style='font-weight: bold;margin: 3px;font-size: 12px;'>CONTACT PERSON</h6></td>
										<td>:</td>
										<td><h6 style='font-weight: normal;margin: 3px;font-size: 12px;'>". $getPrimaryContact[0] ."</h6></td>
										<td><h6 style='font-weight: bold;margin: 3px;font-size: 12px;'>COMMENCEMENT DATE</h6></td>
										<td>:</td>
										<td><h6 style='font-weight: normal;margin: 3px;font-size: 12px;'>". date('F d, Y', strtotime($TenantInfo['dateto'])) ."</h6></td>
									</tr>
								</table>
								<table style='width: 100%;margin-top: 10px;' cellspacing='0' cellpadding='0'>
									<tr>
										<td colspan='4' align='center' style='background-color: #111109 !important;-webkit-print-color-adjust: exact;'><h6 style='font-weight: bold;margin: 3px;font-size: 12px;color: #ffffff !important;'>STATEMENT OF ACCOUNT</h6></td>
									</tr>
								</table>
								<table style='width: 100%;margin-top: 10px;' cellspacing='0' cellpadding='0'>
									<tr style='border-left:1px solid #111109;border-right:1px solid #111109;'>
										<td style='background-color: #111109 !important;-webkit-print-color-adjust: exact;padding-left: 5px;' align='left'>
											<h6 style='font-weight: bold;margin: 3px;font-size: 12px;color: #ffffff !important;'>DATE</h6>
										</td>
										<td style='background-color: #111109 !important;-webkit-print-color-adjust: exact;' align='left'>
											<h6 style='font-weight: bold;margin: 3px;font-size: 12px;color: #ffffff !important;'>REFERENCE</h6>
										</td>
										<td style='background-color: #111109 !important;-webkit-print-color-adjust: exact;' align='left'>
											<h6 style='font-weight: bold;margin: 3px;font-size: 12px;color: #ffffff !important;'>TRANSACTION DETAILS</h6>
										</td>
										<td style='background-color: #111109 !important;-webkit-print-color-adjust: exact;padding-right: 5px;' align='right'>
											<h6 style='font-weight: bold;margin: 3px;font-size: 12px;color: #ffffff !important;'>AMOUNT</h6>
										</td>
									</tr>
									<tr>
										<td colspan='2'></td>
										<td style='font-weight: bold;margin: 3px;font-size: 12px;color: #111109;'>
											TOTAL PREVIOUS BALANCES
										</td>
										<td style='font-weight: bold;margin: 3px;font-size: 12px;color: #111109;padding-right: 5px;' align='right'>
											". number_format($PrevBalance[0], "2", ".", ",") ."
										</td>
									</tr>
									<tr>
										<td colspan='4' style='border-top: 2px solid #111109'></td>
									</tr>
									<tr>
										<td colspan='2'></td>
										<td style='font-weight: bold;margin: 3px;font-size: 12px;color: #111109;'>
											TOTAL Penalty Charges (Account 31 days and over)
										</td>
										<td style='font-weight: bold;margin: 3px;font-size: 12px;color: #111109;padding-right: 5px;' align='right'>
											". number_format($soaheader[7], "2", ".", ",") ."
										</td>
									</tr>
									<tr>
										<td colspan='4' style='border-top: 2px solid #111109'></td>
									</tr>
									<tbody style='border-left:1px solid #111109;border-right:1px solid #111109;border-bottom:1px solid #111109;'>
										<tr>
											<td colspan='4' style='padding-left: 5px;'>
												<h6 style='font-weight: bold;margin: 3px;font-size: 11px;color: #111109;'>CURRENT CHARGES</h6>
											</td>
										</tr>";
							    		$resCharges = mysql_query("SELECT xcode, description, amount, qty, SUM(vatamount + amount), xdate, reference, xdescription FROM dunn_tblsoadetails WHERE ". $TenantQuery ." AND soano = '". $_POST['SoAID'] ."' AND paymenttype = '' AND amount > 0 GROUP BY id;", $connection);
							    		while($rowCharges = mysql_fetch_array($resCharges)){
							    			if($rowCharges['description'] == "Monthly Rent" || $rowCharges['description'] == "Daily Rent"){
							    				$ChargeDescription =  $rowCharges['description'] ." - ". $rowCharges['xdescription'];
							    			}else{
							    				$ChargeDescription =  $rowCharges['description'];
							    			}
							    			echo "<tr>
													<td style='font-weight: normal;margin: 3px;font-size: 11px;padding-left: 10px;' align='left'>". date("m/d/Y", strtotime($rowCharges[5])) ."</td>
													<td style='font-weight: normal;margin: 3px;font-size: 11px;' align='left'>". $rowCharges[6] ."</td>
													<td style='font-weight: normal;margin: 3px;font-size: 11px;' align='left'>". $ChargeDescription ."</td>
													<td style='font-weight: normal;margin: 3px;font-size: 11px;padding-right: 5px;' align='right'>" . number_format($rowCharges[4], "2", ".", ",") ."</td>
												</tr>";
								    	}
							echo	"</tbody>
									<tbody style='border-left:1px solid #111109;border-right:1px solid #111109;'>
										<tr>
											<td colspan='2'></td>
											<td style='font-weight: bold;margin-top: 4px;margin-bottom: 3px;font-size: 12px;color: #111109;'>
												TOTAL CURRENT CHARGES
											</td>
											<td align='right' style='font-weight: bold;margin: 3px;font-size: 12px;color: #111109;padding-right: 5px;'>
												". number_format($totalcurrentcharges[0], "2", ".", ",") ."
											</td>
										</tr>
										<tr>
											<td colspan='4' style='border-top: 2px solid #111109'></td>
										</tr>
										<tr style='border-left:1px solid #111109;border-right:1px solid #111109;'>
											<td colspan='4' style='padding-left: 5px;'>
												<h6 style='font-weight: bold;margin: 3px;font-size: 11px;color: #111109;'>PAYMENTS AND CREDIT ADJUSTMENT</h6>
											</td>
										</tr>
									</tbody>
									<tbody style='border-left:1px solid #111109;border-right:1px solid #111109;border-bottom:1px solid #111109;'>";
									    $resPayment = mysql_query("SELECT xcode, description, amount, qty, balance, xdate, reference, xdescription FROM dunn_tblsoadetails WHERE ". $TenantQuery ." AND (paymenttype IS NOT NULL AND paymenttype != '') AND soano = '". $_POST['SoAID'] ."';", $connection);
								    	while($rowPayment = mysql_fetch_array($resPayment)){
							    			echo "<tr>
													<td style='font-weight: normal;margin: 3px;font-size: 11px;padding-left: 10px;' align='left'>" . date("m/d/Y", strtotime($rowPayment[5])) . "</td>
													<td style='font-weight: normal;margin: 3px;font-size: 11px;' align='left'>" . $rowPayment[6] ."</td>
													<td style='font-weight: normal;margin: 3px;font-size: 11px;' align='left'>" . $rowPayment[7] ."</td>
													<td style='font-weight: normal;margin: 3px;font-size: 11px;padding-right: 5px;' align='right'>" . number_format(str_replace("-", "", $rowPayment[2]), "2", ".", ",") ."</td>
												</tr>";
										}
							echo "</tbody>
									<tbody style='border-left:1px solid #111109;border-right:1px solid #111109;border-bottom:1px solid #111109;'>
										<tr>
											<td colspan='2'></td>
											<td style='font-weight: bold;margin-top: 4px;margin-bottom: 3px;font-size: 12px;color: #111109;'>
												TOTAL PAYMENTS
											</td>
											<td style='font-weight: bold;margin: 3px;font-size: 12px;color: #111109;padding-right: 5px;' align='right'>
												". number_format($totalpayment[0], "2", ".", ",") ."
											</td>
										</tr>
										<tr>
											<td colspan='4' style='border-bottom: 2px solid #111109'></td>
										</tr>
										<tr>
											<td colspan='2' align='left' style='font-weight: bold;margin-top: 4px;margin-bottom: 3px;font-size: 12px;color: #111109;padding-left: 10px;'>
												TOTAL PREVIOUS BALANCES
											</td>
											<td colspan='2' align='right' style='font-weight: bold;margin-top: 4px;margin-bottom: 3px;font-size: 12px;color: #111109;padding-right: 5px;'>
												". number_format($PrevBalance[0], "2", ".", ",") ."
											</td>
										</tr>
										<tr>
											<td colspan='2' align='left' style='font-weight: bold;margin-top: 4px;margin-bottom: 3px;font-size: 12px;color: #111109;padding-left: 10px;'>
												ADD: TOTAL CURRENT CHARGES
											</td>
											<td colspan='2' align='right' style='font-weight: bold;margin-top: 4px;margin-bottom: 3px;font-size: 12px;color: #111109;padding-right: 5px;'>
												". number_format($totalcurrentcharges[0], "2", ".", ",") ."
											</td>
										</tr>
										<tr>
											<td colspan='2' align='left' style='font-weight: bold;margin-top: 4px;margin-bottom: 3px;font-size: 12px;color: #111109;padding-left: 10px;'>
												LESS: TOTAL PAYMENTS
											</td>
											<td colspan='2' align='right' style='font-weight: bold;margin-top: 4px;margin-bottom: 3px;font-size: 12px;color: #111109;padding-right: 5px;'>
												(". number_format($totalpayment[0], "2", ".", ",") .")
											</td>
										</tr>
									</tbody>
									<tbody style='width: 100%; border-collapse: collapse;'>
										<tr>
											<td colspan='2' style='padding-right: 5px;background-color: #111109 !important;-webkit-print-color-adjust: exact;padding-left: 10px;' align='left'>
												<h6 style='font-weight: bold;margin-top: 4px;margin-bottom: 3px;font-size: 12px;color: #ffffff;'>
													AMOUNT DUE
												</h6>
											</td>
											<td colspan='2' style='padding-left: 20px;background-color: #111109 !important;-webkit-print-color-adjust: exact;padding-right: 5px;' align='right'>
												<h6 style='font-weight: bold;margin-top: 4px;margin-bottom: 3px;font-size: 12px;color: #ffffff !important;'>
													". number_format($soaheader[8] - str_replace("-", "", $soaheader[6]), "2", ".", ",") ."
												</h6>
											</td>
										</tr>
									</tbody>
									<tbody>
										<tr>
											<td colspan='4'>
												<table style='width: 100%; border-collapse: collapse;margin-top: 10px;'>
													<tr style='border-left:1px solid #111109;border-right:1px solid #111109;'>
														<td colspan='6' align='center' style='background-color: #111109 !important;-webkit-print-color-adjust: exact;'><h6 style='font-weight: bold;margin: 3px;font-size: 12px;color: #ffffff !important;'>OVERDUE ACCOUNTS</h6></td>
													</tr>
													<tr  style='border-left:1px solid #111109;border-bottom:1px solid #111109;border-right:1px solid #111109;'>
														<td style='text-align: center;border-left:1px solid #111109;border-bottom:1px solid #111109;font-size: 12px;'>AGING SUMMARY</td>
														<td style='text-align: center;border-left:1px solid #111109;border-bottom:1px solid #111109;font-size: 12px;'>CURRENT</td>
														<td style='text-align: center;border-left:1px solid #111109;border-bottom:1px solid #111109;font-size: 12px;'>1-30 DAYS</td>
														<td style='text-align: center;border-left:1px solid #111109;border-bottom:1px solid #111109;font-size: 12px;'>31-60 DAYS</td>
														<td style='text-align: center;border-left:1px solid #111109;border-bottom:1px solid #111109;font-size: 12px;'>61-90 DAYS</td>
														<td style='text-align: center;border-left:1px solid #111109;border-bottom:1px solid #111109;border-right:1px solid #111109;font-size: 12px;'>OVER 90 DAYS</td>
													</tr>
													<tr style='border-left:1px solid #111109;border-bottom:1px solid #111109;border-right:1px solid #111109;'>
														<td style='text-align: center;border-left:1px solid #111109;border-bottom:1px solid #111109;font-size: 12px;'></td>
														<td style='text-align: center;border-left:1px solid #111109;border-bottom:1px solid #111109;font-size: 12px;'>". number_format($aging[0], "2", ".", ",") ."</td>
														<td style='text-align: center;border-left:1px solid #111109;border-bottom:1px solid #111109;font-size: 12px;'>". number_format($aging[1], "2", ".", ",") ."</td>
														<td style='text-align: center;border-left:1px solid #111109;border-bottom:1px solid #111109;font-size: 12px;'>". number_format($aging[2], "2", ".", ",") ."</td>
														<td style='text-align: center;border-left:1px solid #111109;border-bottom:1px solid #111109;font-size: 12px;'>". number_format($aging[3], "2", ".", ",") ."</td>
														<td style='text-align: center;border-left:1px solid #111109;border-bottom:1px solid #111109;border-right:1px solid #111109;font-size: 12px;'>". number_format($aging[4], "2", ".", ",") ."</td>
													</tr>
												</table>
											</td>
										</tr>
									</tbody>

									<tbody>
										<tr>
											<td colspan='4'>
												<table style='width:100%;'>
													<tr>
														<td width='25%'>
															<h6 style='font-weight: normal;margin: 3px;font-size: 11px;color: #111109;'>Prepared by:</h6><br /><br />
														</td>
														<td width='25%'>
															<h6 style='font-weight: normal;margin: 3px;font-size: 11px;color: #111109;'>Checked by:</h6><br /><br />
														</td>
														<td width='25%'>
															<h6 style='font-weight: normal;margin: 3px;font-size: 11px;color: #111109;'>Approved by:</h6><br /><br />
														</td>
														<td width='25%'>
															<h6 style='font-weight: normal;margin: 3px;font-size: 11px;color: #111109;'>Received by / Date Received:</h6><br /><br />
														</td>
													</tr>
													<tr>
														<td width='25%' style='text-align: center;'>
														<label>". $prep ."</label>
															<hr style='border-color: #111109;width: 90%;margin:0px;'>
														</td>
														<td width='25%' style='text-align: center;'>
														<label>". $chkdby ."</label>
															<hr style='border-color: #111109;width: 90%;margin:0px;'>
														</td>
														<td width='25%' style='text-align: center;'>
														<label>". $apprby ."</label>
															<hr style='border-color: #111109;width: 90%;margin:0px;'>
														</td>
														<td width='25%' style". $rcvdby ."</label-lgel>
															<hr style='border-color: #111109;width: 90%;margin:0px;'>
														</td>
													</tr>
													<tr>
														<td width='25%'>
															<h6 style='font-weight: normal;margin: 0px;font-size: 11px;color: #111109;text-align: center;'>Billing, Credit and Collection</h6>
														</td>
														<td width='25%'>
															<h6 style='font-weight: normal;margin: 0px;font-size: 11px;color: #111109;text-align: center;'>Authorized Signatory</h6>
														</td>
														<td width='25%'>
															<h6 style='font-weight: normal;margin: 0px;font-size: 11px;color: #111109;text-align: center;'>Authorized Signatory</h6>
														</td>
														<td width='25%'>
															<h6 style='font-weight: normal;margin: 0px;font-size: 11px;color: #111109;text-align: center;'>Signature over Printed Name</h6>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</tbody>
								</table>
							</center>
							<div class='divFooter'><h6 id='print_footer'></h6></div>
						</div>
						<div style='page-break-after: always;'></div>
				";
			}
		break;

		case 'fncPostActivePeriod':
			$res = mysql_query("UPDATE tblref_billperiod SET Posted = '1' WHERE soaid = '". $_POST['SoAID'] ."';", $connection);
			$res2 = mysql_query("UPDATE dunn_tblsoaheader SET hperiod = 'Posted' WHERE soaid = '". $_POST['SoAID'] ."';", $connection);
			$res3 = mysql_query("UPDATE tbltransaction SET isPosted = '1' WHERE soaid = '". $_POST['SoAID'] ."';", $connection);
			if($res == true && $res2 == true && $res3 == true){
				echo 1;
			}else{
				echo 2;
			}
		break;

		case 'getTenantUnitID':
			$UnitID = mysql_fetch_array(mysql_query("SELECT unitid FROM tbltrans_tenants WHERE TenantID = '". $_POST['TenantID'] ."';", $connection));
			echo $UnitID['unitid'];
		break;

		case 'fncLoadTenant':
			$TenantID = mysql_fetch_array(mysql_query("SELECT TenantID FROM tbltrans_tenants WHERE unitid = '". $_POST['UnitID'] ."';", $connection));
			echo $TenantID['TenantID'];
		break;

		case 'fncViewBevImportLogs':
			$res = mysql_query("SELECT UploadID, UploadDate, UploadTime, UploadStatus, UserID FROM tbltrans_BevLogs;", $connection);
			while($row = mysql_fetch_array($res)){
				$getUsername = mysql_fetch_array(mysql_query("SELECT CASE WHEN middlename = '' OR middlename IS NULL THEN CONCAT(lastname, ', ', firstname) ELSE CONCAT(lastname, ', ', firstname, ' ', LEFT(middlename, '1'), '.') END FROM tbluser WHERE userid = '". $row['UserID'] ."';", $connection));
				if($row['UploadStatus'] == 'Not Posted'){
					$BillingStatus = "<span class='label label-lg label-danger arrowed-in-right arrowed' style='z-index: 0;'>Not Posted</span>";
					$PostingButton = ""; 
	            }else{
					$BillingStatus = "<span class='label label-lg label-primary arrowed-in-right arrowed' style='z-index: 0;'>Posted</span>"; 
					$PostingButton = "disabled"; 
	            }
				echo 	"<tr>
							<td>". date('m/d/Y H:i A', strtotime($row['UploadDate'] ." ". $row['UploadTime'])) ."</td>
							<td>". $getUsername[0] ."</td>
							<td>". $BillingStatus ."</td>
							<td>
								<button class='btn btn-default btn-sm isadmin btn-round' title='Post Charges' onclick='fncOpenBevChargesList(\"".  $row['UploadID'] ."\");' style='margin: 2px;'><img src='assets/images/view.png' style='width: 100%; height: auto;' /></button>
								<button ". $PostingButton ." class='btn btn-warning btn-sm isadmin btn-round' title='Post Charges' onclick='fncPostCharges(\"".  $row['UploadID'] ."\")' style='margin: 2px;'><i class='fa fa-bank'></i></button>
							</td>
						</tr>";
			}
		break;

		case 'fncPostCharges':
			$Success = 0;
			$Machine_No = mysql_fetch_array(mysql_query("SELECT Machine_No FROM tblsys_setup;", $connection));
			$resGetCharges = mysql_query("SELECT Trans_Date, TenantID, Trans_Code, Trans_Desc, Quantity, Trans_Amount, Trans_VAT, Trans_TotAmount, Reference, Mall_ID FROM tbltrans_BevList WHERE UploadID = '". $_POST['UploadID'] ."';", $connection);
			while($rowGetCharges = mysql_fetch_array($resGetCharges)){
				$TenantInfo = mysql_fetch_array(mysql_query("SELECT TenantID, merchant_code, inqID FROM tbltrans_tenants WHERE JDATenant_Code = '". $rowGetCharges['TenantID'] ."';", $connection));
				$resInsertTransaction = mysql_query("INSERT INTO tbltransaction SET TenantID = '". $TenantInfo['TenantID'] ."', xcode = '". $rowGetCharges['Trans_Code'] ."', description = '". $rowGetCharges['Trans_Desc'] ."', amount = '". $rowGetCharges['Trans_Amount'] ."', qty = '". $rowGetCharges['Quantity'] ."', vatamount = '". $rowGetCharges['Trans_VAT'] ."', balance = '". $rowGetCharges['Trans_TotAmount'] ."', totalamount = '". $rowGetCharges['Trans_TotAmount'] ."', xdate = '". $rowGetCharges['Trans_Date'] ."', reference = '". $rowGetCharges['Reference'] ."', xdescription = '". $rowGetCharges['Trans_Desc'] ."', userid = '". $_SESSION['MMS-UserID'] ."', Machine_No = '". $Machine_No['Machine_No'] ."', merchant_code = '". $TenantInfo['merchant_code'] ."', InquiryID = '". $TenantInfo['inqID'] ."';", $connection);
				if($resInsertTransaction == true){
					$Success++;
				}
			}
			if($Success >= 1){
				$UpdateLogsStat = mysql_query("UPDATE tbltrans_BevLogs SET UploadStatus = 'Posted' WHERE UploadID = '". $_POST['UploadID'] ."';", $connection);
				echo "1|Charges successfully posted to billing.";
			}else{
				echo "2|Failed to post charges to billing.";
			}
		break;

		case 'fncViewBevChargesList':
			$res = mysql_query("SELECT a.Trans_Date, b.tradename, a.Trans_Desc, a.Quantity, a.Trans_Amount, a.Trans_VAT, a.Trans_TotAmount, a.Reference FROM tbltrans_bevlist AS a LEFT JOIN tbltrans_tenants AS b ON a.TenantID = b.JDATenant_Code WHERE UploadID = '". $_POST['UploadID'] ."' AND b.tradename LIKE '%". $_POST['key'] ."%';", $connection);
			while($row = mysql_fetch_array($res)){
				echo 	"<tr>
							<td>". date('m/d/Y', strtotime($row['Trans_Date'])) ."</td>
							<td>". $row['tradename'] ."</td>
							<td>". $row['Reference'] ."</td>
							<td>". $row['Trans_Desc'] ."</td>
							<td>". floatval($row['Quantity']) ."</td>
							<td style='text-align: right;'>". number_format($row['Trans_Amount'], 2, '.', ',') ."</td>
							<td style='text-align: right;'>". number_format($row['Trans_VAT'], 2, '.', ',') ."</td>
							<td style='text-align: right;'>". number_format($row['Trans_TotAmount'], 2, '.', ',') ."</td>
						</tr>";
			}
		break;
	}	
?>