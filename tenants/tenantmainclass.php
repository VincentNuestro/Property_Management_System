<?php
    session_start();
    include('../connect.php');
    switch ($_POST['form']) {
        case 'counttenantstatus':
            $sql = "SELECT COUNT(id) FROM tbltrans_tenants WHERE Status = 'ForEviction'";
            $result = mysql_query($sql, $connection);
            $row = mysql_fetch_array($result);

            echo $row[0];
        break;

        case 'tbltenantlists':
            $getFilters = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'Tenant' AND userid = '". $_SESSION['MMS-UserID'] ."';", $connection));
            $Status = explode("|", $getFilters["bystat"]);
            $Search = explode("|", $getFilters["checked_value"]);
            $UnitType = explode("|", $getFilters["xcheck"]);
            $Date = explode("|", $getFilters["datefilter"]);

            // filter for status
            $StatusCount = 0; $SelectedStatus = "";
            for($a = 0; $a<=count($Status)-1; $a++){
                if($Status[$a] == "Active"){ 
                    $StatusVal = "Status = 'Active'"; 
                }else if($Status[$a] == "OnHold"){ 
                    $StatusVal = "Status = 'OnHold'"; 
                }else if($Status[$a] == "ExpiredLease"){ 
                    $StatusVal = "Status = 'ExpiredLease'"; 
                }else if($Status[$a] == "Terminated"){ 
                    $StatusVal = "Status = 'Terminated'"; 
                }
                if($Status[$a] != ""){
                    $StatusCount++;
                    if($StatusCount == 1){
                        $SelectedStatus .= $StatusVal;
                    }else{
                        $SelectedStatus .= " OR ".$StatusVal;
                    }
                }
            }
            if($StatusCount > 1){
                $getAllStatus = "(". $SelectedStatus .")";
            }else{
                $getAllStatus = $SelectedStatus;
            }

            if($getAllStatus == ""){
                $StatFilter = "Status = 'Active'";
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

            // FILTER BY UNIT TYPE
            $UnitStatusCount = 0; $UnitStatusVal = "";
            for($b = 0; $b<=count($UnitType)-1; $b++){
                if($UnitType[$b] != ""){
                    $UnitStatusCount++;
                    if($UnitStatusCount == 1){
                        $UnitStatusVal .= "ustatus = '". $UnitType[$b] ."'";
                    }else{
                        $UnitStatusVal .= " OR ustatus = '". $UnitType[$b] ."'";
                    }
                }
            }

            if($UnitStatusCount > 0){
                if($UnitStatusCount > 1){
                    $UnitStatusFilter = "AND (". $UnitStatusVal .")";
                }else{
                    $UnitStatusFilter = "AND ". $UnitStatusVal;
                }
            }else{
                if($UnitStatusCount > 1){
                    $UnitStatusFilter = "(". $UnitStatusVal .")";
                }else{
                    $UnitStatusFilter = $UnitStatusVal;
                }
            }

            // FILTER BY DATE RANGE
            if($Date[0] != "" && $Date[1] != ""){
                $DateFilter = "AND (datefrom BETWEEN '". date("Y-m-d", strtotime($Date[0])) ."' AND '". date("Y-m-d", strtotime($Date[1])) ."')";
            }else{
                $DateFilter = "";
            }

            $page = $_POST["page"];
            $limit = ($page-1) * 20;
            $res = mysql_query("SELECT TenantID, CONCAT(owner_firstname, ' ', LEFT(owner_midname, 1), '. ', owner_lastname), companyname, unitID, unitname, status, datefrom, dateto, noofmonths, monthly_dues, inqID, appID, noofdays, CompanyID, tradename, mallID, merchant_code, tenanttype, account_number, def_password, assoc_dues, ustatus, revpercent, tradeID, ustatus, ActiveProposal FROM tbltrans_tenants WHERE ". $StatFilter ." ". $SearchFilter ." ". $UnitStatusFilter ." ". $DateFilter ." ". getMallAccess("mallID", "AND") ." ORDER BY TenantID DESC LIMIT ".$limit.", 20;", $connection);
            while ($row = mysql_fetch_array($res)){

                $TradeImage = mysql_fetch_array(mysql_query("SELECT filename FROM tbltrans_tradename WHERE tradeID = '".$row['tradeID']."'", $connection));

                $Industry = mysql_fetch_array(mysql_query("SELECT b.Industry FROM tbltrans_inquiry AS a LEFT JOIN tblref_industry AS b ON a.Industry = b.Industry_ID WHERE a.Inquiry_ID = '". $row['inqID'] ."';", $connection));

                $getProposalStatus = mysql_fetch_array(mysql_query("SELECT stats FROM tbltrans_proposal WHERE ProposalNum = '". $row['ActiveProposal'] ."';", $connection));

                if($row['ustatus'] == 'Unoccupied'){
                    $Status = "<label class='label label-lg arrowed-in-right arrowed label-purple' style='z-index: 0;'>Arrival</label>";
                }else{
                    if($row[5] == "Active"){
                        $Status = "<label class='label label-lg arrowed-in-right arrowed label-success' style='z-index: 0;'>Active</label>";
                    }else if($row[5] == "OnHold"){
                        $Status = "<label class='label label-lg arrowed-in-right arrowed label-warning' style='z-index: 0;'>On Hold</label>";
                    }else if($row[5] == "ExpiredLease"){
                        $Status = "<label class='label label-lg arrowed-in-right arrowed label-danger' style='z-index: 0;'>Expired Lease</label>";
                    }else if($row[5] == "Terminated"){
                        $Status = "<label class='label label-lg arrowed-in-right arrowed label-inverse' style='z-index: 0;'>Terminated</label>";
                    }
                }

                if($TradeImage['filename'] == ""){
                    $img = "assets/images/noimage5.png";
                }else{
                    if(!file_exists("../../Mall_Attachments/company/". $row['CompanyID'] ."/trades/". $row['tradeID'] ."/". $TradeImage['filename'])){ 
                        $img = "assets/images/noimage5.png";
                    }else{
                        $img = "../Mall_Attachments/company/". $row['CompanyID'] ."/trades/". $row['tradeID'] ."/". $TradeImage['filename'];
                    }
                }

                $viewlogs = "<button class='btn btn-sm btn-default hide isadmin select-viewlogs btn-round' onclick='viewhistorytenant(\"". $row['TenantID'] ."\")' title='View Logs' style='margin: 2px;'><img src='assets/images/clock.png' style='width: 100%; height: auto;' /></button>";
                $reportsbtn = "<button class='btn hide btn-sm btn-default btn-round' onclick='printtenantinfo(\"". $row['TenantID'] ."\", \"". $row['inqID'] ."\");' style='margin: 2px;'><img src='assets/images/printer.png' style='width: 100%; height: auto;' title='Print Complaint'></button>";

                $UnitCount = 0;
                $UnitInfo = "";
                $resUnit = mysql_query("SELECT UnitID FROM tbltrans_proposal_unit WHERE InquiryID = '". $row['inqID'] ."' AND proposalNum = '". $row['ActiveProposal'] ."';", $connection);
                $UnitCount = mysql_num_rows($resUnit);
                if($UnitCount == 1){
                    $rowUnit = mysql_fetch_array($resUnit);
                    $UnitName = mysql_fetch_array(mysql_query("SELECT unitname FROM tblref_unit WHERE unitid = '". $rowUnit['UnitID'] ."';", $connection));
                        $UnitInfo = $UnitName['unitname'];
                }else if($UnitCount >= 2){
                    $UnitInfo .= "<label class='ilalabas'>";
                    while($rowUnit = mysql_fetch_array($resUnit)){
                        $UnitName = mysql_fetch_array(mysql_query("SELECT unitname FROM tblref_unit WHERE unitid = '". $rowUnit['UnitID'] ."';", $connection));
                        $UnitInfo .= "<span class='blue fa fa-angle-double-right'></span>&nbsp;".$UnitName['unitname'] ."<br>";
                    }
                    $UnitInfo .= "</label><label class='itatago'>Multiple</label>";
                }else{
                    $UnitInfo = "";
                }

                if($row['tenanttype'] == 'Rent'){
                    $BillingType = "Basic Rent/SQM";
                }else if($row['tenanttype'] == 'Fixed Rent'){
                    $BillingType = "Fixed Rent";
                }else if($row['tenanttype'] == 'Share Only'){
                    $BillingType = $row['revpercent'] ." % of Gross Sales";
                }else if($row['tenanttype'] == 'Share Only2'){
                    $BillingType = $row['revpercent'] ." % of Net Sales";
                }else if($row['tenanttype'] == 'Rent Rev'){
                    $BillingType = "Basic Rent/SQM + ". $row['revpercent'] ." % on GS";
                }else if($row['tenanttype'] == 'Rent or Share'){
                    $BillingType = "Basic Rent/SQM or ". $row['revpercent'] ." % on GS";
                }else{
                    $BillingType = "Basic Rent/SQM";
                }
                $checkifhasevent = mysql_fetch_array(mysql_query("SELECT id FROM event_header WHERE inquiryid = '". $row['inqID'] ."';",$connection));
                if($checkifhasevent[0]==""){
                    $events = 0;
                }else{
                    $events = 1;
                }

                $isProposalExist = mysql_num_rows(mysql_query("SELECT id FROM tbltrans_proposal WHERE inquiryID = '". $row['inqID'] ."';", $connection));
                if($isProposalExist == 0){  
                    $ActiveProposal = 0;
                }else{
                    $ActiveProposal = $row['ActiveProposal'];
                }
                echo    "<tr>
                            <td style='vertical-align: middle;'>". $row['TenantID'] ."</td>
                            <td style='vertical-align: middle;' class='batayan'>". $UnitInfo ."</td>
                            <td style='vertical-align: middle;'>". $row['merchant_code'] ."</td>
                            <td style='vertical-align: middle;'><img style='margin-right: 5px;' class='img-circle' src='". $img ."' width='25px' height='25px'> ". $row['tradename'] ."</td>
                            <td style='vertical-align: middle;'>". $row['companyname'] ."</td>
                            <td style='vertical-align: middle;'>". date('m/d/Y', strtotime($row['datefrom'])) ." - ". date('m/d/Y', strtotime($row['dateto'])) ."</td>
                            <td style='vertical-align: middle;'>". $BillingType ."</td>
                            <td style='vertical-align: middle;'>". $Industry['Industry'] ."</td>
                            <td style='vertical-align: middle; text-align: center;'>". $Status ."</td>
                            <td style='vertical-align: middle; z-index: 0;'>";

                               echo "<button class='btn btn-sm btn-info hide isadmin select-editapplication btn-round' onclick='fncEditGlobalFormInquiry(\"0\", \"". $row['inqID'] ."\", \"". $row['appID'] ."\", \"\", \"". $row['tradeID'] ."\", \"". $row['CompanyID'] ."\", \"". $ActiveProposal ."\", \"". $getProposalStatus['stats'] ."\", \"\", \"". $row['TenantID'] ."\")' title='Update Application' style='margin: 2px;'><img src='assets/images/edit.png' style='width: 100%; height: auto;' /></button>";

                                echo "<button class='btn btn-sm btn-default hide isadmin select-viewtenantlist btn-round' onclick='showinfo(\"". $row['TenantID'] ."\", \"". $row['inqID'] ."\", \"". $row['appID'] ."\", \"". $row['status'] ."\", \"". $row['mallID'] ."\", \"". $row['CompanyID'] ."\", \"". $row['tradeID'] ."\", \"". $row['ActiveProposal'] ."\", \"". $getProposalStatus['stats'] ."\");' title='View Information' style='margin: 2px;'><img src='assets/images/view.png' style='width: 100%; height: auto;' /></button>";

                                // echo "<button class='btn btn-sm btn-warning hide isadmin select-viewtenantlist btn-round' onclick='fncContractAmendmentList(\"". $row['TenantID'] ."\", \"". $row['inqID'] ."\", \"". $row['appID'] ."\", \"". $row['CompanyID'] ."\", \"". $row['tradeID'] ."\");' title='Contract Amendment' style='margin: 2px;'><img src='assets/images/contract.png' style='width: 100%; height: auto;' /></button>";


                                // echo "<button class='btn btn-sm btn-info hide isadmin select-updateapplication btn-round' onclick='fncEditGlobalFormInquiry(\"0\", \"". $row['Inquiry_ID'] ."\", \"". $row['Application_ID'] ."\", \"". $row['leadsID'] ."\", \"". $row['TradeID'] ."\", \"". $row['CompanyID'] ."\", \"". $getProposalStatus['proposalNum'] ."\", \"". $getProposalStatus['stats'] ."\")' title='Update Application' style='margin: 2px;'><img src='assets/images/edit.png' style='width: 100%; height: auto;' /></button>";
                            if($events==1){
                                echo"<button class='btn btn-sm btn-gray  isadmin select-viewevents btn-round' onclick='frmeventformop(\"". $row['Inquiry_ID'] ."\",".$events.",\"".$row['CompanyID']."\",1)' title='View Event' style='margin: 2px;'><img src='assets/images/ticket.png' style='width: 100%; height: auto;' /></button>";
                            }else{
                               
                            }


                echo        "</td>
                        </tr>";
            }
        break;

        case "loadTenantListPage":
            $getFilters = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'Tenant' AND userid = '". $_SESSION['MMS-UserID'] ."';", $connection));
            $Status = explode("|", $getFilters["bystat"]);
            $Search = explode("|", $getFilters["checked_value"]);
            $UnitType = explode("|", $getFilters["xcheck"]);
            $Date = explode("|", $getFilters["datefilter"]);

            // filter for status
            $StatusCount = 0; $SelectedStatus = "";
            for($a = 0; $a<=count($Status)-1; $a++){
                if($Status[$a] == "Active"){ 
                    $StatusVal = "Status = 'Active'"; 
                }else if($Status[$a] == "OnHold"){ 
                    $StatusVal = "Status = 'OnHold'"; 
                }else if($Status[$a] == "ExpiredLease"){ 
                    $StatusVal = "Status = 'ExpiredLease'"; 
                }else if($Status[$a] == "Terminated"){ 
                    $StatusVal = "Status = 'Terminated'"; 
                }
                if($Status[$a] != ""){
                    $StatusCount++;
                    if($StatusCount == 1){
                        $SelectedStatus .= $StatusVal;
                    }else{
                        $SelectedStatus .= " OR ".$StatusVal;
                    }
                }
            }
            if($StatusCount > 1){
                $getAllStatus = "(". $SelectedStatus .")";
            }else{
                $getAllStatus = $SelectedStatus;
            }

            if($getAllStatus == ""){
                $StatFilter = "Status = 'Active'";
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

            // FILTER BY UNIT TYPE
            $UnitStatusCount = 0; $UnitStatusVal = "";
            for($b = 0; $b<=count($UnitType)-1; $b++){
                if($UnitType[$b] != ""){
                    $UnitStatusCount++;
                    if($UnitStatusCount == 1){
                        $UnitStatusVal .= "ustatus = '". $UnitType[$b] ."'";
                    }else{
                        $UnitStatusVal .= " OR ustatus = '". $UnitType[$b] ."'";
                    }
                }
            }

            if($UnitStatusCount > 0){
                if($UnitStatusCount > 1){
                    $UnitStatusFilter = "AND (". $UnitStatusVal .")";
                }else{
                    $UnitStatusFilter = "AND ". $UnitStatusVal;
                }
            }else{
                if($UnitStatusCount > 1){
                    $UnitStatusFilter = "(". $UnitStatusVal .")";
                }else{
                    $UnitStatusFilter = $UnitStatusVal;
                }
            }

            // FILTER BY DATE RANGE
            if($Date[0] != "" && $Date[1] != ""){
                $DateFilter = "AND (datefrom BETWEEN '". date("Y-m-d", strtotime($Date[0])) ."' AND '". date("Y-m-d", strtotime($Date[1])) ."')";
            }else{
                $DateFilter = "";
            }

		    $page = $_POST["page"];
			$rowCount = mysql_fetch_row(mysql_query("SELECT COUNT(*) FROM tbltrans_tenants WHERE ". $StatFilter ." ". $SearchFilter ." ". $UnitStatusFilter ." ". $DateFilter ." ". getMallAccess("mallID", "AND") .";", $connection));
			$rowsperpage = 20;
			$range = 3;
			$totalpages = ceil($rowCount[0] / $rowsperpage);
			$prevpage;
			$nextpage;
			if($page > 1 ){
                echo "<li style='width:50px !important;' onclick='TenantListPageFunc(1)'><< First</li>";
			    $prevpage = $page - 1;
			    echo "<li style='width:70px !important;' onclick='TenantListPageFunc(". $prevpage .")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if (($x > 0) && ($x <= $totalpages)){
    			    if ($x == $page){
                        echo "<li id='pgTenantList" . $x . "' class='pgnumTenantList active' onclick='TenantListPageFunc(" . $x . ",". $x .")'>" . $x . "</li>";
                    }else{
    			        echo "<li id='pgTenantList" . $x . "' class='pgnumTenantList' onclick='TenantListPageFunc(" . $x . ",". $x .")'>" . $x . "</li>";
                    }
		        }
		    }
		    if($page < ($totalpages - $range)){
                echo "<li>...</li>";
            }
		    if ($page != $totalpages && $rowCount[0] != 0){
		        $nextpage = $page + 1;
		        echo "<li style='width:50px !important;' onclick='TenantListPageFunc(". $nextpage .", ". $nextpage .")'>Next ></li>";
		        echo "<li style='width:50px !important;' onclick='TenantListPageFunc(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

        case 'loadTenantListEntries':
            $getFilters = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'Tenant' AND userid = '". $_SESSION['MMS-UserID'] ."';", $connection));
            $Status = explode("|", $getFilters["bystat"]);
            $Search = explode("|", $getFilters["checked_value"]);
            $UnitType = explode("|", $getFilters["xcheck"]);
            $Date = explode("|", $getFilters["datefilter"]);

            // filter for status
            $StatusCount = 0; $SelectedStatus = "";
            for($a = 0; $a<=count($Status)-1; $a++){
                if($Status[$a] == "Active"){ 
                    $StatusVal = "Status = 'Active'"; 
                }else if($Status[$a] == "OnHold"){ 
                    $StatusVal = "Status = 'OnHold'"; 
                }else if($Status[$a] == "ExpiredLease"){ 
                    $StatusVal = "Status = 'ExpiredLease'"; 
                }else if($Status[$a] == "Terminated"){ 
                    $StatusVal = "Status = 'Terminated'"; 
                }
                if($Status[$a] != ""){
                    $StatusCount++;
                    if($StatusCount == 1){
                        $SelectedStatus .= $StatusVal;
                    }else{
                        $SelectedStatus .= " OR ".$StatusVal;
                    }
                }
            }
            if($StatusCount > 1){
                $getAllStatus = "(". $SelectedStatus .")";
            }else{
                $getAllStatus = $SelectedStatus;
            }

            if($getAllStatus == ""){
                $StatFilter = "Status = 'Active'";
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

            // FILTER BY UNIT TYPE
            $UnitStatusCount = 0; $UnitStatusVal = "";
            for($b = 0; $b<=count($UnitType)-1; $b++){
                if($UnitType[$b] != ""){
                    $UnitStatusCount++;
                    if($UnitStatusCount == 1){
                        $UnitStatusVal .= "ustatus = '". $UnitType[$b] ."'";
                    }else{
                        $UnitStatusVal .= " OR ustatus = '". $UnitType[$b] ."'";
                    }
                }
            }

            if($UnitStatusCount > 0){
                if($UnitStatusCount > 1){
                    $UnitStatusFilter = "AND (". $UnitStatusVal .")";
                }else{
                    $UnitStatusFilter = "AND ". $UnitStatusVal;
                }
            }else{
                if($UnitStatusCount > 1){
                    $UnitStatusFilter = "(". $UnitStatusVal .")";
                }else{
                    $UnitStatusFilter = $UnitStatusVal;
                }
            }

            // FILTER BY DATE RANGE
            if($Date[0] != "" && $Date[1] != ""){
                $DateFilter = "AND (datefrom BETWEEN '". date("Y-m-d", strtotime($Date[0])) ."' AND '". date("Y-m-d", strtotime($Date[1])) ."')";
            }else{
                $DateFilter = "";
            }

            if($_POST["page"] == ""){
               $page = 1;
            }else{
               $page = $_POST["page"];
            }
            $limit = ($page-1) * 20;
            $rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM tbltrans_tenants WHERE ". $StatFilter ." ". $SearchFilter ." ". $UnitStatusFilter ." ". $DateFilter ." ". getMallAccess("mallID", "AND") .";", $connection));
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

        case 'fncTenantInfo':
            $TenantInfo = mysql_fetch_array(mysql_query("SELECT datefrom, dateto, unitID, tradename, merchant_code, CompanyID, tenanttype, revpercent, MallID, owner_lastname, owner_firstname, owner_midname, noofmonths, noofdays, monthly_dues, assoc_dues, daily_dues, ActiveProposal FROM tbltrans_tenants WHERE TenantID = '". $_POST['TenantID'] ."';", $connection));
            $CompanyName = mysql_fetch_array(mysql_query("SELECT Company, automerchant_code FROM tbltrans_company WHERE CompanyID = '". $TenantInfo['CompanyID'] ."';", $connection));
            $TradeName = mysql_fetch_array(mysql_query("SELECT filename, tradeID FROM tbltrans_tradename WHERE companyID = '".$TenantInfo['CompanyID']."';", $connection));
            $ProposalInfo = mysql_fetch_array(mysql_query("SELECT escalation_rate, year_start, year_basis FROM tbltrans_proposal WHERE inquiryID = '". $_POST['InquiryID'] ."' AND proposalNum = '". $TenantInfo['ActiveProposal'] ."';", $connection));
            $getTradePrimaryContact = mysql_fetch_array(mysql_query("SELECT CASE WHEN MiddleName = '' OR MiddleName IS NULL THEN CONCAT(LastName, ', ', FirstName) ELSE CONCAT(LastName, ', ', FirstName, ' ', LEFT(MiddleName, '1'), '.') END FROM tbltrans_trade_contact_person WHERE TradeID = '". $TradeName['tradeID'] ."' AND isActive = '1' AND isPrimary = '1';", $connection));
            if($TradeName['filename'] == ""){
                $Image = "assets/images/noimage5.png";
            }else{
                if(!file_exists("../../Mall_Attachments/company/". $TenantInfo['CompanyID'] ."/trades/". $TradeName['tradeID'] ."/". $TradeName['filename'])){ 
                    $Image = "assets/images/noimage5.png";
                }else{
                    $Image = "../Mall_Attachments/company/". $TenantInfo['CompanyID'] ."/trades/". $TradeName['tradeID'] ."/". $TradeName['filename'];
                }
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

            if(SysLeaseSetup('automerchantcode') == "1"){
                $MerchantCode = $TenantInfo['merchant_code']."-".$CompanyName['automerchant_code'];
            }else{
                $MerchantCode = $TenantInfo['merchant_code'];
            }

            $TotalDaily =  floatval($TenantInfo['daily_dues']) * floatval($TenantInfo['noofdays']);
            $GrandTotal = $TotalMonthly + $TotalDaily;

            echo $Image . "|" . $TenantInfo['tradename'] . "|" . $MerchantCode . "|" . $CompanyName['Company'] . "|" . $getTradePrimaryContact[0] . "|" . $BillingType . "|" . date('m/d/Y', strtotime($TenantInfo['datefrom'])) . "|" . date('m/d/Y', strtotime($TenantInfo['dateto'])) . "|" . $ProposalInfo['escalation_rate'] . "%|" .  $ProposalInfo['year_start'] . "|" . $ProposalInfo['year_basis'];
        break;

        case 'fncTenantUnitLIst':
            $TenantInfo = mysql_fetch_array(mysql_query("SELECT datefrom, dateto, unitID, tradename, merchant_code, CompanyID, tenanttype, revpercent, MallID, owner_lastname, owner_firstname, owner_midname, noofmonths, noofdays, monthly_dues, assoc_dues, daily_dues, ActiveProposal, noofyears FROM tbltrans_tenants WHERE inqID = '". $_POST['InquiryID'] ."';", $connection));
            $resgetUnitList = mysql_query("SELECT UnitID FROM tbltrans_proposal_unit WHERE InquiryID = '". $_POST['InquiryID'] ."' AND proposalNum = '". $TenantInfo['ActiveProposal'] ."';", $connection);
            while ($rowgetUnitList = mysql_fetch_array($resgetUnitList)) {
                $UnitInfo = mysql_fetch_array(mysql_query("SELECT unitname, floorid, wingid, classid, depid, catid, typeofbusiness, area, sqmunitsetup, totalamountunitsetup, pricepersqmunitsetup, assocdues FROM tblref_unit WHERE unitid = '". $rowgetUnitList['UnitID'] ."';", $connection));
                $MallName = mysql_fetch_array(mysql_query("SELECT mallname FROM tblref_mall WHERE mallid = '". $TenantInfo['MallID'] ."';", $connection));
                $WingName = mysql_fetch_array(mysql_query("SELECT wing FROM tblref_wing WHERE wingID = '". $UnitInfo['wingid'] ."';", $connection));
                $FloorName = mysql_fetch_array(mysql_query("SELECT floor FROM tblref_floorsetup WHERE floorid = '". $UnitInfo['floorid'] ."';", $connection));
                $Classification = mysql_fetch_array(mysql_query("SELECT classification FROM tblref_merchandise_class WHERE classificationID = '". $UnitInfo['classid'] ."';", $connection));
                $Department = mysql_fetch_array(mysql_query("SELECT department FROM tblref_merchandise_depa WHERE departmentID = '". $UnitInfo['depid'] ."';", $connection));
                $Category = mysql_fetch_array(mysql_query("SELECT category FROM tblref_merchandisedep_cat WHERE categoryID = '". $UnitInfo['catid'] ."';", $connection));
                if(SysLeaseSetup('floorandunitmeasurement') == 'Area'){
                    $UnitArea = $UnitInfo['area'];
                }else{  
                    $UnitArea = $UnitInfo['sqmunitsetup'];
                }

                $TotalMonthly = (floatval($UnitInfo['totalamountunitsetup']) + floatval($UnitInfo['assocdues'])) * floatval($TenantInfo['noofmonths']);

                if($TenantInfo['noofdays'] >= 0){
                    $Daily = 0;
                    $refDate = date('m/d/Y', strtotime($TenantInfo['dateto'] .' -'. $TenantInfo['noofdays'] .'days'));
                    for ($x = 1; $x <= $TenantInfo['noofdays']; $x++) {
                        if(date('d', strtotime($refDate)) == date('t', strtotime($refDate))){
                            $AssocDues = floatval($UnitInfo['assocdues']);
                        }else{
                            $AssocDues = 0;
                        }
                        $DailyRate = floatval($UnitInfo['totalamountunitsetup']) / date('t', strtotime($refDate));
                        $Daily += $DailyRate + $AssocDues;
                        $refDate = date('m/d/Y', strtotime($refDate . '+1 day'));
                    }
                }
                
                echo    "<div class='widget-box widget-color-blue3 collapsed'>
                            <div class='widget-header'>
                                <h5 class='widget-title'>
                                    ". $UnitInfo['unitname'] ."
                                </h5>
                                <div class='widget-toolbar no-border'>
                                    <a href='#' data-action='collapse'>
                                        <i class='ace-icon fa fa-chevron-down'></i>
                                    </a>
                                </div>
                            </div>

                            <div class='widget-body' style='display: none;'>
                                <div class='widget-main'>
                                    <div class='row'>
                                        <div class='col-md-8'>
                                            <div class='col-md-12'>
                                                <h4 class='blue header bolder'>Unit Details</h4>
                                            </div>
                                            <div class='col-md-6'>
                                                <div class='row form-group'>
                                                    <div class='profile-user-info profile-user-info-striped'>
                                                        <div class='profile-info-row'>
                                                            <div class='profile-info-name'> <span class='txtSysBuilding'></span> </div>
                                                            <div class='profile-info-value'>
                                                                <span>". $MallName['mallname'] ."</span>
                                                            </div>
                                                        </div>
                                                        <div class='profile-info-row'>
                                                            <div class='profile-info-name'> Wing </div>
                                                            <div class='profile-info-value'>
                                                                <span>". $WingName['wing'] ."</span>
                                                            </div>
                                                        </div>
                                                        <div class='profile-info-row'>
                                                            <div class='profile-info-name'> Floor </div>
                                                            <div class='profile-info-value'>
                                                                <span>". $FloorName['floor'] ."</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class='col-md-6'>
                                                <div class='row form-group'>
                                                    <div class='profile-user-info profile-user-info-striped'>";
                        echo                            "<div class='profile-info-row'>
                                                            <div class='profile-info-name' style='white-space: nowrap;'> Unit Type </div>
                                                            <div class='profile-info-value'>
                                                                <span>". $UnitInfo['typeofbusiness'] ."</span>
                                                            </div>
                                                        </div>
                                                        <div class='profile-info-row'>
                                                            <div class='profile-info-name' style='white-space: nowrap;'> Unit Area </div>
                                                            <div class='profile-info-value'>
                                                                <span>". number_format($UnitArea, 0, ".", ",") ." SQM</span>
                                                            </div>
                                                        </div>
                                                        <div class='profile-info-row'>
                                                            <div class='profile-info-name'> Classification </div>
                                                            <div class='profile-info-value'>
                                                                <span>". $Classification['classification'] ."</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='col-md-4'>
                                            <div class='col-md-12'>
                                                <h4 class='blue header bolder'>Unit Occupancy</h4>
                                            </div>
                                            <div class='profile-user-info profile-user-info-striped'>
                                                <div class='profile-info-row'>
                                                    <div class='profile-info-name' style='white-space: nowrap;'> No. of Day(s) </div>
                                                    <div class='profile-info-value'>
                                                        <span>". floatval($TenantInfo['noofdays']) ."</span>
                                                    </div>
                                                </div>
                                                <div class='profile-info-row'>
                                                    <div class='profile-info-name' style='white-space: nowrap;'> No of Month(s) </div>
                                                    <div class='profile-info-value'>
                                                        <span>". floatval($TenantInfo['noofmonths']) ."</span>
                                                    </div>
                                                </div>
                                                 <div class='profile-info-row'>
                                                    <div class='profile-info-name' style='white-space: nowrap;'> No of Year(s) </div>
                                                    <div class='profile-info-value'>
                                                        <span>". floatval($TenantInfo['noofyears']) ."</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>";
            }
        break;

        case 'tblcontactinfo':
            $sql = "SELECT ContactID, CONCAT(LastName, ' ', LEFT(MiddleName, 1), '. ', FirstName) as conname, designation, LastName, MiddleName, FirstName, Address, filename FROM tbltrans_trade_contact_person WHERE TradeID = '". $_POST['TradeID'] ."';";
            $result = mysql_query($sql, $connection);
            while ($row = mysql_fetch_array($result)){

                if($row['filename'] == ""){
                    $img = "assets/images/noimage5.png";
                    $img2 = "";
                }else{
                    if(!file_exists("../../Mall_Attachments/company/". $_POST['CompanyID'] ."/trades/". $_POST['TradeID'] ."/contact_person/". $row['ContactID'] ."/". $row['filename'])){ 
                        $img = "assets/images/noimage5.png";
                        $img2 = "";
                    }else{
                        $img = "../Mall_Attachments/company/". $_POST['CompanyID'] ."/trades/". $_POST['TradeID'] ."/contact_person/". $row['ContactID'] ."/". $row['filename'];
                        $img2 = "../Mall_Attachments/company/". $_POST['CompanyID'] ."/trades/". $_POST['TradeID'] ."/contact_person/". $row['ContactID'] ."/". $row['filename'];
                    }
                }

                echo "<div class='col-md-2'>
                        <div class='profile-users clearfix' style='padding: 5px;'>
                            <div class='itemdiv memberdiv'>
                                <div class='inline pos-rel'>
                                    <div class='user'>
                                        <a href='#'>
                                            <img src='". $img ."' class='img-responsive img-thumbnail' style='height: 110px; width: 110px;' alt='". $row[1] ."' onclick='editcontactinfo(\"". $row['LastName'] ."\", \"". $row['FirstName'] ."\", \"". $row['MiddleName'] ."\", \"". $row['designation'] ."\", \"". $row['Address'] ."\", \"". $img2 ."\", \"". $row['ContactID'] ."\", \"". $row2['content'] ."\", \"". $row3['content'] ."\", \"". $row4['content'] ."\");'>
                                        </a>
                                    </div>
                                    <div class='body'>
                                        <div class='name' style='font-size: 16px;white-space: nowrap;'>
                                            <a href='#'>
                                                <span class='user-status status-online'></span>
                                                ". $row[1] ."
                                            </a>
                                        </div>
                                    </div>
                                    <div class='popover' style='padding: 10px;min-width: 250px !important;'>
                                        <div class='arrow'></div>
                                        <div class='popover-content'>
                                            <div class='bolder'>". $row['designation'] ."</div>";
                                            if($row['Address'] != ""){
                                                echo    "<div class='time'>
                                                            <i class='ace-icon fa fa-home middle bigger-120 orange2'></i>
                                                            <span span='grey'>". $row['Address'] ."</span>
                                                        </div>";
                                            }
                                            $result2 = mysql_query("SELECT type, content FROM tbltrans_trade_contact_person_list WHERE ContactID = '". $row['ContactID'] ."' AND TYPE = 'Mobile';", $connection);
                                            while($row2 = mysql_fetch_array($result2)){
                                                echo    "<div class='time'>
                                                            <i class='ace-icon fa fa-mobile fa-2x middle black'></i>
                                                            <span span='grey'>". $row2['content'] ."</span>
                                                        </div>";
                                            }
                                            $result3 = mysql_query("SELECT type, content FROM tbltrans_trade_contact_person_list WHERE ContactID = '". $row['ContactID'] ."' AND TYPE = 'Telephone';", $connection);
                                            while($row3 = mysql_fetch_array($result3)){
                                                echo    "<div class='time'>
                                                            <i class='ace-icon fa fa-phone fa-lg middle blue'></i>
                                                            <span span='grey'>". $row3['content'] ."</span>
                                                        </div>";
                                            }

                                            $result4 = mysql_query("SELECT type, content FROM tbltrans_trade_contact_person_list WHERE ContactID = '". $row['ContactID'] ."' AND TYPE = 'Email';", $connection);
                                            while($row4 = mysql_fetch_array($result4)){
                                                echo    "<div class='time'>
                                                            <i class='ace-icon fa fa-envelope middle fa-lg orange'></i>
                                                            <span span='grey'>". $row4['content'] ."</span>
                                                        </div>";
                                            }
                                echo    "</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>";
            }
        break;

        case 'savecontactperson':
            $custID = createidno("CON", "tbltrans_company_contact_person", "custID");

            if($_POST['conid'] == ""){
                $sql = "INSERT INTO tbltrans_company_contact_person SET custID = '".$custID."', ConID = '".$_POST['compid']."', name = '".$_POST['name']."', designation = '".$_POST['designation']."', Confname = '".$_POST['confname']."', Conmname = '".$_POST['conmname']."', Conlname = '".$_POST['conlname']."', address = '".$_POST['address']."' ";
                $result = mysql_query($sql, $connection);

                if($_POST['Mobile'] != ""){
                    $sqlNew ="INSERT INTO tbltrans_company_contact_person_contacts SET ConID = '".$custID."', type = 'mobile', content = '".$_POST['Mobile']."' ";
                    $resultNew = mysql_query($sqlNew, $connection);
                }

                if($_POST['Telephone'] != ""){
                    $sqlNew ="INSERT INTO tbltrans_company_contact_person_contacts SET ConID = '".$custID."', type = 'telephone', content = '".$_POST['Telephone']."' ";
                    $resultNew = mysql_query($sqlNew, $connection);
                }

                if($_POST['Email'] != ""){
                    $sqlNew ="INSERT INTO tbltrans_company_contact_person_contacts SET ConID = '".$custID."', type = 'email', content = '".$_POST['Email']."' ";
                    $resultNew = mysql_query($sqlNew, $connection);
                }

                echo "Contact person successfully added." . "|" . $custID . "|" . $_POST['compid'];
            }else{
                $sql = "UPDATE tbltrans_company_contact_person SET custID = '".$custID."', ConID = '".$_POST['compid']."', name = '".$_POST['name']."', designation = '".$_POST['designation']."', Confname = '".$_POST['confname']."', Conmname = '".$_POST['conmname']."', Conlname = '".$_POST['conlname']."', address = '".$_POST['address']."' WHERE custID = '".$_POST['conid']."' ";
                $result = mysql_query($sql, $connection);

                echo "Contact person has been modified.|";
            }
        break;

        case 'tblrequirements':
            $ActiveProposal = mysql_fetch_array(mysql_query("SELECT ActiveProposal FROM tbltrans_tenants WHERE TenantID = '". $_POST['TenantID'] ."';", $connection));
            $res = mysql_query("SELECT type_req_ID, filename, docname, docdesc, appID, filetype, reqID FROM tbltrans_leasingapplicationreq WHERE reqID = '". $_POST['InquiryID'] ."' AND ProposalNum = '". $ActiveProposal['ActiveProposal'] ."';", $connection);
            while($row = mysql_fetch_array($res)){
                $row2 = mysql_fetch_array(mysql_query("SELECT requirements FROM tblref_applicationrequirements WHERE id = '". $row[0] ."';", $connection));
                $docname = "";
                if($row[0] == ""){
                    $docname = $row[2];
                }else{
                    $docname = $row2[0];
                }
                $sql3 = "SELECT Status FROM tbltrans_tenants WHERE inqID = '". $_POST['InquiryID'] ."'";
                $res3 = mysql_query($sql3, $connection);
                $row3 = mysql_fetch_array($res3);
                    if($row3[0] == "Evicted" || $row3[0] == "Inactive"){
                        $evict ="disabled";
                        $action = "";
                    }else{
                        $evict = "";
                        $action = "href = '../Mall_Attachments/Requirements/". $row['reqID'] ."/". $docname ."/". $row[1] ."' download";
                    }
                $btn = "";
                $arr = explode("/", $row[5]);
                if($arr[0] != "image"){
                    $btn = "<a ".$action."><span class='btn-sm btn-info'><i class='fa fa-download'></i></span></a>";
                }else{
                    $imgname = "../Mall_Attachments/Requirements/". $row['reqID'] ."/". $docname ."/". $row[1];
                    $btn = "<a onclick='viewdocuimgindex(\"". $imgname ."\");'><span class='btn-sm btn-info'><i class='fa fa-eye'></i></span></a>";
                }
                echo    "<tr>
                            <td>". $docname ."</td>
                            <td>". $row[3] ."</td>
                            <td align='center'>". $btn ."</td>
                        </tr>";
            }
        break;

        case 'fncPaymentSchedule':
            $resgetUnitList = mysql_query("SELECT UnitID FROM tbltrans_inquiry_unit WHERE InquiryID = '". $_POST['InquiryID'] ."';", $connection);
            while ($rowgetUnitList = mysql_fetch_array($resgetUnitList)) {
                $UnitInfo = mysql_fetch_array(mysql_query("SELECT unitname, floorid, wingid, classid, depid, catid, typeofbusiness, area, sqmunitsetup, totalamountunitsetup, pricepersqmunitsetup, assocdues FROM tblref_unit WHERE unitid = '". $rowgetUnitList['UnitID'] ."';", $connection));
                echo    "<div class='widget-box widget-color-blue3 collapsed'>
                            <div class='widget-header'>
                                <h5 class='widget-title'>
                                    ". $UnitInfo['unitname'] ."
                                </h5>
                                <div class='widget-toolbar no-border'>
                                    <a href='#' data-action='collapse'>
                                        <i class='ace-icon fa fa-chevron-down'></i>
                                    </a>
                                </div>
                            </div>

                            <div class='widget-body' style='display: none;'>
                                <div class='widget-main no-padding'>
                                    <div class='row'>
                                        <div class='col-xs-12 col-sm-12'>
                                            <div class='parent'>
                                                <table class='table table-striped table-bordered fixTable'>
                                                    <thead>
                                                        <tr>
                                                            <th style='width: 15%;'>Billing Date</th>
                                                            <th style='width: 15%;' class='isRentOnly'>Rev. Percentage</th>
                                                            <th style='width: 20%;'>Rent Amount</th>";
                                                            if(SysLeaseSetup('isAssocDues') == '1'){
                echo                                        "<th style='width: 20%;'>Association Dues</th>";
                                                            }
                echo                                        "<th style='width: 20%;'>Total</th>
                                                            <th style='width: 10%;z-index: 1;' class='hide isadmin select-ModRent'>Options</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>";
                                                        $res = mysql_query("SELECT PayDate, RevPercentage, PayAmount, PayASsocDues, id, TenantiD FROM tblref_paymentsched WHERE UnitID = '". $rowgetUnitList['UnitID'] ."';", $connection);
                                                        while($row = mysql_fetch_array($res)){
                                                            $BillType = mysql_fetch_array(mysql_query("SELECT tenanttype FROM tbltrans_tenants WHERE TenantID = '". $row['TenantID'] ."';", $connection));
                                                            if($row['RevPercentage'] != 0){
                                                                $RevPerc = floatval($row['RevPercentage']) . " %";
                                                            }else{
                                                                $RevPerc = "";
                                                            }
                                                            if($BillType['tenanttype'] == "Rent"){
                                                                $AddClass = "hide";
                                                            }else{  
                                                                $AddClass = "";
                                                            }
                                                            echo    "<tr>
                                                                        <td>". date('m/d/Y', strtotime($row['PayDate'])) ."</td>
                                                                        <td class='". $AddClass ."'>". $RevPerc ."</td>
                                                                        <td style='text-align: right;'>". number_format($row['PayAmount'], 2, ".", ",") ."</td>";
                                                                        if(SysLeaseSetup('isAssocDues') == "1"){
                                                            echo        "<td style='text-align: right;'>". number_format($row['PayASsocDues'], 2, ".", ",") ."</td>";
                                                                        }
                                                            echo        "<td style='text-align: right;'>". number_format($row['PayAmount'] + $row['PayASsocDues'], 2, ".", ",") ."</td>
                                                                        <td style='z-index: 0;' class='center hide isadmin select-ModRent'>
                                                                            <div class='btn-group'>
                                                                                <button class='btn btn-sm btn-info btn-round' onclick='fncModRent(\"". $row["id"] ."\")' title='Modify Rent' style='margin: 2px;'><img src='assets/images/resume.png' style='width: 100%; height: auto;' /></button>
                                                                            </div>
                                                                        </td>
                                                                    </tr>";
                                                        }
                echo                    "           </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>";
            }
        break;

        case 'fncModRent':
            $ModRent = mysql_fetch_array(mysql_query("SELECT PayDate, RevPercentage, PayAmount, PayASsocDues FROM tblref_paymentsched WHERE id = '". $_POST['id'] ."';", $connection));
            echo date('m/d/Y', strtotime($ModRent['PayDate'])) . "|" . floatval($ModRent['RevPercentage']) . "|" . number_format($ModRent['PayAmount'], 2, ".", ",") . "|" . number_format($ModRent['PayASsocDues'], 2, ".", ",");
        break;

        case 'fncSaveModRent':
            if($_POST['SchedID'] != ''){
                //INSERT LOG FIRST - JONAS - 2/14/2019
                $arrHeader = ["Billing Date", "Revenue Percentage", "Rent Amount", "Association Dues"];
                $arrFields = ["PayDate", "PayAmount", "RevPercentage", "PayAssocDues"];
                $arrValue = [date('Y-m-d', strtotime($_POST['BillDate'])), $_POST['RentAmount'], $_POST['RevPerc'], $_POST['AssocDues'], $_POST['level']];
                $Logs = CreateLogsArray("UPDATE", $arrHeader, $arrFields, $arrValue, "tblref_paymentsched", "id", $_POST['SchedID']);
                if($Logs != ""){
                    $tran_logs = create_logs_per_transaction("modified a rent scehdule.", "Tenants", $Logs, "" ,"EDIT", $_POST['TenantID']);
                }
                //INSERT LOG FIRST - JONAS - 2/14/2019
                $res = mysql_query("UPDATE tblref_paymentsched SET PayDate = '". date('Y-m-d', strtotime($_POST['BillDate'])) ."', PayAmount = '". $_POST['RentAmount'] ."', RevPercentage = '". $_POST['RevPerc'] ."', PayAssocDues = '". $_POST['AssocDues'] ."' WHERE id = '". $_POST['SchedID'] ."';", $connection);
                if($res == true){
                    echo "1|Rent chedule successfully updated.";
                }
            }else{
                echo "2|Failed to update rent schedule.";
            }
        break;

        case 'tblpaymenthistory':
            $getFilters = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'TMListPaymentHistory';", $connection));
            $Search = explode("|", $getFilters["checked_value"]);
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
                $DateFilter = "AND (date_inquired BETWEEN '". date("Y-m-d", strtotime($Date[0])) ."' AND '". date("Y-m-d", strtotime($Date[1])) ."')";
            }else{
                $DateFilter = "";
            }

            $res = mysql_query("SELECT xdate, transdate, description, paymenttype, orno, amount FROM tbltransaction WHERE tenantid = '". $_POST['tenantid'] ."' AND amount LIKE '%-%' ". $SearchFilter ." ". $DateFilter .";", $connection);
            while($row = mysql_fetch_array($res)){
                $arr = explode("-", $row['amount']);

                if($row['xdate'] == ""){
                    $date = date('F d, Y', strtotime($row['transdate']));
                }else{
                    $date = date('F d, Y', strtotime($row['xdate']));
                }
                echo "<tr>
                        <td>".$date."</td>
                        <td>".$row['description']."</td>
                        <td>".$row['paymenttype']."</td>
                        <td>".$row['orno']."</td>
                        <td style='text-align: right;'>".number_format($arr[1], 2, ".", ",")."</td>
                    </tr>";
            }
        break;

        case 'tblsoa':
            $getFilters = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'TMListSoA';", $connection));
            $Search = explode("|", $getFilters["checked_value"]);
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
                $DateFilter = "AND (date_inquired BETWEEN '". date("Y-m-d", strtotime($Date[0])) ."' AND '". date("Y-m-d", strtotime($Date[1])) ."')";
            }else{
                $DateFilter = "";
            }

            $UnitID = mysql_fetch_array(mysql_query("SELECT unitid FROM tbltrans_tenants WHERE TenantID = '". $_POST['tenantid'] ."';", $connection));
            $getSetup = mysql_fetch_array(mysql_query("SELECT BillingSetup, MainUnit FROM tblref_unit WHERE unitid = '". $UnitID['unitid'] ."';", $connection));
            if($getSetup['BillingSetup'] == 'Merged'){
                if($getSetup['MainUnit'] == ""){
                    $mgaMeron = "";
                    $getSubUnits = mysql_query("SELECT TenantID FROM tblref_unit WHERE MainUnit = '". $UnitID['unitid'] ."';", $connection);
                    $SubUnitCount = mysql_num_rows($getSubUnits);
                    $SubUnitCount = mysql_num_rows($getSubUnits);
                    while($rowSubUnits = mysql_fetch_array($getSubUnits)){
                        $mgaMeron .= "'" . $rowSubUnits['TenantID'] . "'" . ",";
                    }
                    if($SubUnitCount >= 1){
                        $TenantFilter = "(TenantID IN (". substr(trim($mgaMeron), 0, -1) .") OR TenantID = '". $_POST['tenantid'] ."')";
                    }else{
                        $TenantFilter = "TenantID = '". $_POST['tenantid'] ."'";
                    }
                    $TenantID = $_POST['tenantid'];
                }else{
                    $MainTenantID = mysql_fetch_array(mysql_query("SELECT TenantID FROM tblref_unit WHERE unitid = '". $getSetup['MainUnit'] ."';", $connection));
                    $mgaMeron = "";
                    $getSubUnits = mysql_query("SELECT TenantID FROM tblref_unit WHERE MainUnit = '". $getSetup['MainUnit'] ."';", $connection);
                    $SubUnitCount = mysql_num_rows($getSubUnits);
                    $SubUnitCount = mysql_num_rows($getSubUnits);
                    while($rowSubUnits = mysql_fetch_array($getSubUnits)){
                        $mgaMeron .= "'" . $rowSubUnits['TenantID'] . "'" . ",";    
                    }
                    if($SubUnitCount >= 1){
                        $TenantFilter = "(TenantID IN (". substr(trim($mgaMeron), 0, -1) .") OR TenantID = '". $MainTenantID['TenantID'] ."')";
                        $TenantID = $MainTenantID['TenantID'];
                    }else{
                        $TenantFilter = "TenantID = '". $_POST['tenantid'] ."'";
                        $TenantID = $_POST['tenantid'];
                    }
                }
            }else{
                $TenantFilter = "TenantID = '". $_POST['tenantid'] ."'";
                $TenantID = $_POST['tenantid'];
            }
            $res = mysql_query("SELECT soaperiod, soaperiod2, duedate, SUM(penchrg), SUM(payment), SUM(Forwbal), SUM(currcharg), SUM(Currbal), soaid FROM dunn_tblsoaheader WHERE ". $TenantFilter ." ". $SearchFilter ." ". $DateFilter ." AND Posted = '1';", $connection);
            $num = mysql_num_rows($res);
            if($num == 0){

            }else{
                while($row = mysql_fetch_array($res)){
                    $maxid = "";
                    $str = strlen($row["ctrlno"]);
                    if($str == 1){ 
                        $maxid = "000" . $row["ctrlno"]; 
                    }else if($str == 2){ 
                        $maxid = "00" . $row["ctrlno"]; 
                    }else if($str == 3){ 
                        $maxid = "0" . $row["ctrlno"]; 
                    }else{ 
                        $maxid = $row["ctrlno"]; 
                    }
                    echo    "<tr>
                                <td>". $row['soaid'] ."</td>
                                <td>". $maxid ."</td>
                                <td>". date('m/d/Y', strtotime($row[1]))." - ". date('m/d/Y', strtotime($row[2])) ."</td>
                                <td>". number_format($row[3], "2",".",",") ."</td>
                                <td>". number_format($row[4], "2",".",",") ."</td>
                                <td>". number_format($row[5], "2",".",",") ."</td>
                                <td>". number_format($row[6], "2",".",",") ."</td>
                                <td style='text-align: center;' width='1%'><button class='btn btn-sm btn-primary btn-round' onclick='opensoa_separate(\"". $TenantID ."\", \"". $row['soaid'] ."\");'><i class='fa fa-eye'></i></button></td>
                            </tr>";
                }
            }
        break;

        case 'tblpdc':
			$sql = "SELECT pdcdate, lname, fname, depositorystat, checkstat, amount, pdcreceiptno, bank, checkno, chckreceivedby, depository, id, paymentstat, penalty, customerid, datedep FROM tbltrans_pdc WHERE customerid  = '".$_POST['id']."' AND pdcdate BETWEEN '". date('Y-m-d', strtotime($_POST['datefrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['dateto'])) ."' " ;
			$result = mysql_query($sql, $connection);
			while ($row = mysql_fetch_array($result)) {
                $row2 = mysql_fetch_array(mysql_query("SELECT companyname FROM tbltrans_tenants WHERE tenantID = '".$row['id']."'", $connection));
                $bankname = mysql_fetch_array(mysql_query("SELECT description FROM tblrefbank WHERE xcode = '". $row['bank'] ."'", $connection));
				$pdcamount = str_replace(',','',$row['amount']);
                        if($row[4] == "Insufficient Fund"){
                            $stat = "<span class='fa fa-circle' style='color: red;'></span>";
                        }else if($row[4] == "Cleared"){
                            $stat = "<span class='fa fa-circle' style='color: green;'></span>";
                        }else{
                            $stat = "<span class='fa fa-circle' style='color: orange;'></span>";
                        }

                        if($row['datedep'] == "" || $row['datedep'] == "0000-00-00"){
                            $datedep = "";
                        }else{
                            $datedep = date('m/d/Y', strtotime($row['datedep']));
                        }

    					echo "
    						<tr class='thisrow' onclick='choosepdc(\"". $row['pdcdate'] ."\", \"". $row['depositorystat'] ."\", \"". $row['lname'] ."\", \"". $row['fname'] ."\", \"". $row['checkno'] ."\", \"". $bankname['description'] ."\", \"". $row['chckreceivedby'] ."\", \"". $row['depository'] ."\", \"". floatval($row['amount']) ."\", \"". $row['checkstat'] ."\", \"". $row['id'] ."\", \"". $row['paymentstat'] ."\", \"". $pdctotal ."\", \"". $row['datedep'] ."\");'>
    							<td width='15%'>". date('m/d/Y', strtotime($row['pdcdate'])) ."</td>
    							<td width='22%'>". $row['depositorystat'] ."</td>
    							<td width='20%'>". $datedep ."</td>
                                <td width='17%'>". $row['checkno'] ."</td>
    							<td width='8%' align='center'>".$stat."</td>
                                <td width='18%' align='right'>". number_format($pdcamount, "2", ".", ",")."</td>
    						</tr>
    					";
			}
        break;

        case 'savepdctransaction':
            $sql = "UPDATE tbltrans_pdc SET chckreceivedby = '". $_POST['accreceiveby'] ."', depository = '".$_POST['accdepository']."', depositorystat = 'Deposited', checkstat = 'Cleared', datedep = '". date('Y-m-d', strtotime($_POST['accdatedep'])) ."' WHERE inquiryid = '". $_POST['id'] ."' AND pdcdate = '". $_POST['accpdcdate'] ."' ";
            $result = mysql_query($sql, $connection);
		break;

        case 'tblcontract':
            $res = mysql_query("SELECT datefrom, dateto, unitid, contractID, InquiryID FROM tblcontract WHERE tenantid = '". $_POST['tenantid'] ."';", $connection);
            while($row = mysql_fetch_array($res)){
                $InquiryInfo = mysql_fetch_array(mysql_query("SELECT ActiveProposal FROM tbltrans_inquiry WHERE Inquiry_ID = '". $row['InquiryID'] ."';", $connection));
                echo    "<tr>
                            <td>". $row[3] ."</td>
                            <td>". date('F d, Y', strtotime($row[0])) ."</td>
                            <td>". date('F d, Y', strtotime($row[1])) ."</td>
                            <td align='center'>
                                <button class='btn btn-default btn-sm btn-round' aria-expanded='false' onclick='fncSelectReportType(\"". $row['InquiryID'] ."\", \"LeaseContract\", \"". $InquiryInfo['ActiveProposal'] ."\", \"". $row['contractID'] ."\");' title='Print Proposal'><img src='assets/images/printer.png' style='width: 100%; height: auto;' /></button>
                            </td>
                        </tr>";
            }
        break;

        case 'tblmaintenance':
            $sql = "SELECT workorderid, workername, xstatus, xdate, Complaint_Series_No FROM tblmaintenance_workorder WHERE TenantID = '". $_POST['tenantid'] ."' AND xdate BETWEEN '". date('Y-m-d', strtotime($_POST['datefrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['dateto'])) ."'";
            $res = mysql_query($sql, $connection);
            while($row = mysql_fetch_array($res)){
                $complaints = mysql_fetch_array(mysql_query("SELECT Complaint_Status, Complaint_Code FROM tblcomplaints WHERE Complaint_Series_No = '". $row[4] ."' ", $connection));
                if ($row[2] == 'Pending') {
                    $stats = '<span class="label label-lg label-warning arrowed-in-right arrowed">'.$row[2].'</span>';
                }else if($row[2] == 'Resolved'){
                    $stats = '<span class="label label-lg label-success arrowed-in-right arrowed">'.$row[2].'</span>';
                }

                if($complaints[0] == "Ongoing"){
                    $complaintstatus = '<span class="blue fa fa-circle"></span>';
                }else{
                    $complaintstatus = '<span class="green fa fa-circle"></span>';
                }
                ?>  <tr>
                        <td><?php echo $row[0]; ?></td>
                        <td>
                            <?php 
                                if($row[4] == ""){
                                    $res2 = mysql_query("SELECT xcategory, taskstatus, xtaskid FROM tblmaintenance_workorderlist WHERE workorderid = '". $row[0] ."' ", $connection);
                                    while($joblist = mysql_fetch_array($res2)){
                                        $catname = mysql_fetch_array(mysql_query("SELECT category FROM tblmaintenance_category WHERE category_id = '". $joblist[0] ."' ", $connection));
                                        $taskname = mysql_fetch_array(mysql_query("SELECT description FROM tblmaintenance_tasklist WHERE taskid = '". $joblist[2] ."' ", $connection));
                                        if($joblist[2] == ""){
                                            $trabaho = $catname[0];
                                        }else{
                                            $trabaho = $taskname[0];
                                        }

                                        if($joblist[1] == 'Resolved'){
                                            $span = '<span class="fa fa-circle" style="color: #69AA46;"></span>';
                                        }else if($joblist[1] == 'Pending'){
                                            $span = '<span class="fa fa-circle" style="color: #FF892A;"></span>';
                                        }else if($joblist[1] == 'Ongoing'){
                                            $span = '<span class="fa fa-circle" style="color: #478FCA;"></span>';
                                        }
                                        echo $span." ".$trabaho."<br/>";
                                    }
                                }else{
                                    echo $complaintstatus." ".$complaints[1];
                                }
                            ?>
                        </td>
                        <td><?php echo $row[1]; ?></td>
                        <td><?php echo $stats; ?></td>
                        <td><?php echo date('F d, Y', strtotime($row[3])); ?></td>
                    </tr>
                <?php
            }
        break;

        case 'tblmaintenance2':
            $sql = "SELECT workorderid, workername, xstatus, startdate, Complaint_Series_No FROM tblmaintenance_workorder WHERE TenantID = '". $_POST['tenantid'] ."' AND xdate BETWEEN '". date('Y-m-d', strtotime($_POST['datefrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['dateto'])) ."'";
            $res = mysql_query($sql, $connection);
            while($row = mysql_fetch_array($res)){
                $complaints = mysql_fetch_array(mysql_query("SELECT Complaint_Status, Complaint_Code FROM tblcomplaints WHERE Complaint_Series_No = '". $row[4] ."' ", $connection));
                if ($row[2] == 'Pending') {
                    $stats = '<span class="label label-warning arrowed-in-right arrowed" style="color: black;">'.$row[2].'</span>';
                }else if($row[2] == 'Resolved'){
                    $stats = '<span class="label label-success arrowed-in-right arrowed" style="color: black;">'.$row[2].'</span>';
                }

                if($complaints[0] == "Ongoing"){
                    $complaintstatus = '<span class="fa fa-circle" style="color: #478FCA;"></span>';
                }else{
                    $complaintstatus = '<span class="fa fa-circle" style="color: #69AA46;"></span>';
                }
                ?>  <tr>
                        <td valign="top"><?php echo $row[0]; ?></td>
                        <td valign="top">
                            <?php 
                                if($row[4] == ""){
                                    $res2 = mysql_query("SELECT xcategory, taskstatus, xtaskid FROM tblmaintenance_workorderlist WHERE workorderid = '". $row[0] ."' ", $connection);
                                    while($joblist = mysql_fetch_array($res2)){
                                        $catname = mysql_fetch_array(mysql_query("SELECT category FROM tblmaintenance_category WHERE category_id = '". $joblist[0] ."' ", $connection));
                                        $taskname = mysql_fetch_array(mysql_query("SELECT description FROM tblmaintenance_tasklist WHERE taskid = '". $joblist[2] ."' ", $connection));
                                        if($joblist[2] == ""){
                                            $trabaho = $catname[0];
                                        }else{
                                            $trabaho = $taskname[0];
                                        }

                                        if($joblist[1] == 'Resolved'){
                                            $span = '<span class="fa fa-circle" style="color: #69AA46;"></span>';
                                        }else if($joblist[1] == 'Pending'){
                                            $span = '<span class="fa fa-circle" style="color: #FF892A;"></span>';
                                        }else if($joblist[1] == 'Ongoing'){
                                            $span = '<span class="fa fa-circle" style="color: #478FCA;"></span>';
                                        }
                                        echo $span." ".$trabaho."<br/>";
                                    }
                                }else{
                                    echo $complaintstatus." ".$complaints[1];
                                }
                            ?>
                        </td>
                        <td valign="top"><?php echo $row[1]; ?></td>
                        <td valign="top"><?php echo $stats; ?></td>
                        <td valign="top"><?php echo date('m/d/Y', strtotime($row[3])); ?></td>
                    </tr>
                <?php
            }
        break;

        case 'displayconbond':
            $res = mysql_query("SELECT datestart, enddate, description, filetype, filename FROM tblref_conbond WHERE TenantID = '". $_POST['tid'] ."'", $connection);
            while($row = mysql_fetch_array($res)){

                $status = mysql_fetch_array(mysql_query("SELECT Status, tradename FROM tbltrans_tenants WHERE TenantID = '".$_POST["tid"]."'", $connection));
                if($status[0] == "Evicted" || $status[0] == "Inactive"){
                    $evict ="disabled";
                    $action = "";
                }else{
                    $evict = "";
                    $action = "href = 'server/Construction Bond/".$status[1]."/".$row[4]."' download";
                }

                $btn = "";
                $arr = explode("/", $row[3]);
                if($arr[0] != "image"){
                    $btn = "
                    <a ".$action.">
                        <span class='btn-sm btn-info' ".$evict."><i class='fa fa-download'></i></span>
                    </a>
                    ";
                }else{
                    $imgname = "server/Construction Bond/".$status[1]."/".$row[4];
                    $btn = "
                    <a onclick='viewdocuimgindex(\"".$imgname."\");'>
                        <span class='btn-sm btn-info' ".$evict."><i class='fa fa-eye'></i></span>
                    </a>
                    ";
                    }

                echo    "
                            <tr>
                                <td>".date('m/d/Y', strtotime($row[0]))."</td>
                                <td>".date('m/d/Y', strtotime($row[1]))."</td>
                                <td>".$row[2]."</td>
                                <td>".$btn."</td>
                            </tr>
                        ";
            }
        break;

        case 'tbltenantmemolist':
            $res = mysql_query("SELECT MemoDate, MemoSubj, MemoContent, MemoID FROM tbltrans_memo WHERE TenantID = '". $_POST['tid'] ."'", $connection);
            while($row = mysql_fetch_array($res)){
                if(strlen($row[2]) >= 1000){
                    $content = substr($row[2], 0, 300)."...";
                }else{
                    $content = $row[2];
                }
                echo    "
                        <tr>
                            <td>". date('m/d/Y', strtotime($row[0])) ."</td>
                            <td>". $row[1] ."</td>
                            <td>". $content ."</td>
                            <td><button class='btn btn-sm btn-primary btn-round' title='View Memo' onclick='ViewMemoTenant(\"". $row['MemoID'] ."\", \"". $_POST['tid'] ."\");'><i class='fa fa-eye'></i></button></td>
                        </tr>
                        ";
            }
        break;

        case 'tblcomplaints':
            $getFilters = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'TMListComplaints';", $connection));
            $Status = explode("|", $getFilters["bystat"]);
            $Status2 = explode("|", $getFilters["xcheck"]);
            $Search = explode("|", $getFilters["checked_value"]);
            $Date = explode("|", $getFilters["datefilter"]);

            // FILTER BY STATUS
            $StatusCount = 0; $SelectedStatus = "";
            for($a = 0; $a<=count($Status)-2; $a++){
                if($Status[$a] == "High"){ 
                    $StatusVal = "Priority_Status = 'High'"; 
                }else if($Status[$a] == "Medium"){ 
                    $StatusVal = "Priority_Status = 'Medium'"; 
                }else if($Status[$a] == "Low"){
                    $StatusVal = "Priority_Status = 'Low'"; 
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
            for($a = 0; $a<=count($Status2)-2; $a++){
                if($Status2[$a] == "Resolved"){ 
                    $StatusVal2 = "Complaint_Status = 'Resolved'";
                }else if($Status2[$a] == "Pending"){
                    $StatusVal2 = "Complaint_Status = 'Pending'"; 
                }else if($Status2[$a] == "Ongoing"){
                    $StatusVal2 = "Complaint_Status = 'Ongoing'"; 
                }

                if($Status2[$a] != ""){
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
                $StatFilter2 = "AND Complaint_Status = 'Pending'"; 
            }else{
                $StatFilter2 = "AND ".$getAllStatus2;
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
                $DateFilter = "AND (Date_Entry BETWEEN '". date("Y-m-d", strtotime($Date[0])) ."' AND '". date("Y-m-d", strtotime($Date[1])) ."')";
            }else{
                $DateFilter = "";
            }

            $res = mysql_query("SELECT Complaint_Code, Complete_Description, Time_Received, Time_Resolved, ResolvedBy, Complaint_Status, Priority_Status FROM tblcomplaints WHERE TenantID = '". $_POST['tenantid'] ."' ". $StatFilter ." ". $StatFilter2 ." ". $SearchFilter ." ". $DateFilter .";", $connection);
            while($row = mysql_fetch_array($res)){
                if($row['Time_Received'] == "" || $row['Time_Received'] == "0000-00-00 00:00:00"){
                    $TimeReceived = "";
                }else{
                    $TimeReceived = date('m/d/Y h:i A', strtotime($row['Time_Received']));
                }

                if($row['Time_Resolved'] == "" || $row['Time_Resolved'] == "0000-00-00 00:00:00"){
                    $TimeResolved = "";
                }else{
                    $TimeResolved = date('m/d/Y h:i A', strtotime($row['Time_Resolved']));
                }

                if($row['Priority_Status'] == "High"){
                    $PrioStat = "<span class='label label-lg label-danger arrowed-in-right arrowed' style='z-index: 0;'>High Priority</span>";
                }else if($row['Priority_Status'] == "Medium"){
                    $PrioStat = "<span class='label label-lg label-warning arrowed-in-right arrowed' style='z-index: 0;'>Medium Priority</span>";
                }else if($row['Priority_Status'] == "Low"){
                    $PrioStat = "<span class='label label-lg label-yellow arrowed-in-right arrowed' style='z-index: 0;'>Low Priority</span>";
                }

                echo "  <tr>
                            <td>". $row['Complaint_Code'] ."</td>
                            <td>". $row['Complete_Description'] ."</td>
                            <td>". $TimeReceived ."</td>
                            <td>". $TimeResolved ."</td>
                            <td>". $row['resolvedby'] ."</td>
                            <td>". $row['Complaint_Status'] ."</td>
                            <td>". $PrioStat ."</td>
                        </tr>";
            }
        break;

        case 'loadComplaintCodes':
            echo "<option value=''>-- Select Complaints Code --</option>";
            $res = mysql_query("SELECT Complaints_Code, Complete_Description FROM tblcomplaintscode", $connection);
            while($row = mysql_fetch_array($res)){
                echo "<option value='". $row['Complaints_Code'] ."'>". $row['Complete_Description'] ."</option>";
            }
        break;

        case 'ShowPreDescription':
            $PreDesc = mysql_fetch_array(mysql_query("SELECT Complete_Description FROM tblcomplaintscode WHERE Complaints_Code = '". $_POST['ComplaintCode'] ."'", $connection));
            echo $PreDesc[0];
        break;

        case 'SaveNewComplaintCode':
            $IfExist = mysql_num_rows(mysql_query("SELECT id FROM tblcomplaintscode WHERE Complaints_Code = '". $_POST['Code'] ."'", $connection));
            if($IfExist == 0){
                $NewComplaintCode = mysql_query("INSERT INTO tblcomplaintscode SET Complaints_Code = '". $_POST['Code'] ."', Complete_Description = '". $_POST['Description'] ."', Priority_Status = '". $_POST['PrioStat'] ."'", $connection);
                if($NewComplaintCode == true){
                    echo "1|Complaint code successfully saved.";
                }
            }else{
                echo "2|Complaint code already exist.";
            }
        break;

        case 'SavenewTPComplaints':
            $PrioStat = mysql_fetch_array(mysql_query("SELECT Priority_Status FROM tblcomplaintscode WHERE Complaints_Code = '". $_POST['ComplaintCode'] ."'", $connection));
            $TInfo = mysql_fetch_array(mysql_query("SELECT tradename, unitID, mallID FROM tbltrans_tenants WHERE TenantID = '". $_POST['TenantID'] ."'", $connection));
            $UnitInfo = mysql_fetch_array(mysql_query("SELECT wingid, floorid FROM tblref_unit WHERE unitid = '". $TInfo['unitID'] ."'", $connection));
            $CompSeriesNo = createidno("CSN", "tblcomplaints", "Complaint_Series_No");
            $res = mysql_query("INSERT INTO tblcomplaints SET Complaint_Series_No = '". $CompSeriesNo ."', Complaint_Code = '". $_POST['ComplaintCode'] ."', Complete_Description = '". $_POST['ComplaintDesc'] ."', TenantID = '". $_POST['TenantID'] ."', Priority_Status = '". $PrioStat['Priority_Status'] ."', TradeName = '". $TInfo['tradename'] ."', MallID = '". $TInfo['mallID'] ."', WingID = '". $UnitInfo['wingid'] ."', FloorID = '". $UnitInfo['floorid'] ."', UnitID = '". $TInfo['unitID'] ."', userid = '". $_SESSION['MMS-UserID'] ."', Date_Entry = '". date('Y-m-d') ."'", $connection);
            if($res == true){
                echo "1|New complaint successfully saved.";
            }else{
                echo "2|Failed to save complaint";
            }
        break;

        case 'loadTPS':
            $TPS = mysql_fetch_array(mysql_query("SELECT SFTP_User, SFTP_Pass, TP_Setup, uploadingoffiles, def_password, withPOS FROM tbltrans_tenants WHERE TenantID = '". $_POST['TenantID'] ."'", $connection));
            echo $TPS['SFTP_User'] . "|" . $TPS['SFTP_Pass'] . "|" . $TPS['TP_Setup'] . "|" . $TPS['uploadingoffiles'] . "|" . $TPS['def_password'] . "|" . $TPS['withPOS'];
        break;

        case 'showlistofdocs':
            $ActiveProposal = mysql_fetch_array(mysql_query("SELECT ActiveProposal FROM tbltrans_tenants WHERE TenantID = '". $_POST['TenantID'] ."';", $connection));
            $ReqList = mysql_fetch_array(mysql_query("SELECT requirement_list FROM tbltrans_proposal WHERE inquiryID = '". $_POST['InquiryID'] ."' AND proposalNum = '". $ActiveProposal['ActiveProposal'] ."'", $connection));
            $mgaMeron = "";
            $arr = explode("|", $ReqList['requirement_list']);
            for ($i=0; $i <= count($arr)-2; $i++) { 
                $mgaMeron .= "'" . $arr[$i] . "'" . ",";
            }
            echo "<option value='' selected disabled>-- Select Requirement --</option>";
            $resreq = mysql_query("SELECT id, requirements FROM tblref_applicationrequirements ", $connection);
            while($rowreq = mysql_fetch_array($resreq)){
                echo "<option value='". $rowreq[0]."'>". $rowreq[1] ."</option>";
            }
        break;

        case 'ChangeStatAccred':
            $sql = "UPDATE tbltrans_tenants SET uploadingoffiles = '". $_POST['AccredStat'] ."' WHERE TenantID = '". $_POST['TenantID'] ."'";
            $res = mysql_query($sql, $connection);
        break;

        case 'ChangeLocatAccred':
            $sql = "UPDATE tbltrans_tenants SET TP_Setup = '". $_POST['Location'] ."' WHERE TenantID = '". $_POST['TenantID'] ."'";
            $res = mysql_query($sql, $connection);
        break;

        case 'fncSaveNEdit':
            $res = mysql_query("UPDATE tbltrans_tenants SET SFTP_User = '". $_POST['User'] ."', SFTP_Pass = '". $_POST['Pass'] ."', withPOS = '". $_POST['withPOS'] ."' WHERE TenantID = '". $_POST['TenantID'] ."';", $connection);
        break;

        case 'showPermitList':
            $ActiveProposal = mysql_fetch_array(mysql_query("SELECT ActiveProposal FROM tbltrans_tenants WHERE TenantID = '". $_POST['TenantID'] ."';", $connection));
            $PermitList = mysql_fetch_array(mysql_query("SELECT permit_list FROM tbltrans_proposal WHERE inquiryID = '". $_POST['InquiryID'] ."' AND AND proposalNum = '". $ActiveProposal['ActiveProposal'] ."';", $connection));
            $mgaMeron = "";
            $arr = explode("|", $PermitList['permit_list']);
            for ($i=0; $i <= count($arr)-2; $i++) { 
                $mgaMeron .= "'" . $arr[$i] . "'" . ",";
            }
            echo "<option value='' selected disabled>-- Select Permit --</option>";
            $resreq = mysql_query("SELECT id, DESCRIPTION FROM tblref_typeofpermits ", $connection);
            while($rowreq = mysql_fetch_array($resreq)){
                echo "<option value='". $rowreq[0]."'>". $rowreq[1] ."</option>";
            }
        break;

        case 'tblpermits':
            $PerList = mysql_fetch_array(mysql_query("SELECT proposalNum FROM tbltrans_proposal WHERE inquiryID = '". $_POST['InquiryID'] ."' AND stats = '1' ORDER BY ProposalNum DESC;", $connection));
            $result = mysql_query("SELECT documentid, filename, docname, docdesc, reqID, filetype, expirydate FROM tblref_tenantsdocs WHERE reqID = '". $_POST['InquiryID'] ."' AND ProposalNum = '". $PerList['proposalNum'] ."';", $connection);
            while ($row = mysql_fetch_array($result)) {
                $row2 = mysql_fetch_array(mysql_query("SELECT DESCRIPTION FROM tblref_typeofpermits WHERE id = '". $row[0] ."';", $connection));
                $docname = "";
                if($row[0] == ""){
                    $docname = $row[2];
                }else{
                    $docname = $row2[0];
                }
                $sql3 = "SELECT Status FROM tbltrans_tenants WHERE inqID = '". $_POST['InquiryID'] ."'";
                $res3 = mysql_query($sql3, $connection);
                $row3 = mysql_fetch_array($res3);
                    if($row3[0] == "Evicted" || $row3[0] == "Inactive"){
                        $evict ="disabled";
                        $action = "";
                    }else{
                        $evict = "";
                        $action = "href = '../Mall_Attachments/Permits/". $row['reqID'] ."/". $docname ."/". $row[1] ."' download";
                    }
                $btn = "";
                $arr = explode("/", $row[5]);
                if($arr[0] != "image"){
                    $btn = "<a ". $action ."><span class='btn-sm btn-info'><i class='fa fa-download'></i></span></a>";
                }else{
                    $imgname = "../Mall_Attachments/Permits/". $row['reqID'] ."/". $docname ."/". $row[1];
                    $btn = "<a onclick='viewdocuimgindex(\"". $imgname ."\");'><span class='btn-sm btn-info'><i class='fa fa-eye'></i></span></a>";
                }
                echo    "<tr>
                            <td>". $docname ."</td>
                            <td>". $row[3] ."</td>
                            <td>". date('m/d/Y', strtotime($row[6])) ."</td>
                            <td align='center'>
                                ". $btn ."
                            </td>
                        </tr>";
            }
        break;

        // tenantinforuth
        case 'printtenantinfo':
           $TenantInfo = mysql_fetch_array(mysql_query("SELECT datefrom, dateto, unitID, tradename, merchant_code, CompanyID, tenanttype, revpercent, MallID, owner_lastname, owner_firstname, owner_midname, noofmonths, noofdays, monthly_dues, assoc_dues, daily_dues, TenantID FROM tbltrans_tenants WHERE TenantID = '". $_POST['TenantID'] ."';", $connection));
            $CompanyName = mysql_fetch_array(mysql_query("SELECT Company, automerchant_code FROM tbltrans_company WHERE CompanyID = '". $TenantInfo['CompanyID'] ."';", $connection));
            $TradeName = mysql_fetch_array(mysql_query("SELECT filename, tradeID FROM tbltrans_tradename WHERE companyID = '".$TenantInfo['CompanyID']."';", $connection));
            $MallName = mysql_fetch_array(mysql_query("SELECT mallname FROM tblref_mall WHERE mallid = '". $TenantInfo['MallID'] ."';", $connection));
            $sqlUnit2 = "SELECT unitname, floorid, wingid, classid, depid, catid, typeofbusiness, area, sqmunitsetup, totalamountunitsetup, pricepersqmunitsetup FROM tblref_unit WHERE unitID = '". $TenantInfo['unitID'] ."' AND TenantID = '".$TenantInfo['TenantID']."';";
            $UnitInfo2 = mysql_fetch_array(mysql_query($sqlUnit2, $connection));
            $sqlUnit = " SELECT unitname, floorid, wingid, classid, depid, catid, typeofbusiness, area, sqmunitsetup, totalamountunitsetup, pricepersqmunitsetup  FROM tblref_unit WHERE unitname = '". $UnitInfo2['unitname'] ."';";
            $UnitInfo = mysql_fetch_array(mysql_query($sqlUnit, $connection));
             // echo $UnitInfo[0];
            $sqlWing = "SELECT wing FROM tblref_wing WHERE wingID = '". $UnitInfo['wingid'] ."';";
            $WingName = mysql_fetch_array(mysql_query($sqlWing, $connection));
            $FloorName = mysql_fetch_array(mysql_query("SELECT floor FROM tblref_floorsetup WHERE floorid = '". $UnitInfo['floorid'] ."';", $connection));
            $Classification = mysql_fetch_array(mysql_query("SELECT classification FROM tblref_merchandise_class WHERE classificationID = '". $UnitInfo['classid'] ."';", $connection));
            $Department = mysql_fetch_array(mysql_query("SELECT department FROM tblref_merchandise_depa WHERE departmentID = '". $UnitInfo['depid'] ."';", $connection));
            $Category = mysql_fetch_array(mysql_query("SELECT category FROM tblref_merchandisedep_cat WHERE categoryID = '". $UnitInfo['catid'] ."';", $connection));
            $ProposalInfo = mysql_fetch_array(mysql_query("SELECT escalation_rate, year_start, year_basis FROM tbltrans_proposal WHERE inquiryID = '". $_POST['InquiryID'] ."' AND stats = '1';", $connection));
            if($TradeName['filename'] == ""){
                $Image = "assets/images/noimage5.png";
            }else{
                if(!file_exists("../../Mall_Attachments/company/". $TenantInfo['CompanyID'] ."/trades/". $TradeName['tradeID'] ."/". $TradeName['filename'])){ 
                    $Image = "assets/images/noimage5.png";
                }else{
                    $Image = "../Mall_Attachments/company/". $TenantInfo['CompanyID'] ."/trades/". $TradeName['tradeID'] ."/". $TradeName['filename'];
                }
            }

            if($TenantInfo['tenanttype'] == "Rent | Rev"){
                $BillingType = "Rent + Rev" . " (" . $TenantInfo['revpercent'] . "%)";
            }else if($TenantInfo['tenanttype'] == "Rent or Share"){
                $BillingType = $TenantInfo['tenanttype'] . " (" . $TenantInfo['revpercent'] . "%)";
            }else{
                $BillingType = $TenantInfo['tenanttype'];
            }

            if($TenantInfo['owner_midname'] == ""){
                $ContactPerson = $TenantInfo['owner_firstname'] . " " . $TenantInfo['owner_lastname'];
            }else{
                $ContactPerson = $TenantInfo['owner_firstname'] . " " . $TenantInfo['owner_midname'][0] . " " . $TenantInfo['owner_lastname'];
            }

            if(SysLeaseSetup('floorandunitmeasurement') == 'Area'){
                $UnitArea = $UnitInfo['area'];
            }else{  
                $UnitArea = $UnitInfo['sqmunitsetup'];
            }

            if(SysLeaseSetup('automerchantcode') == "1"){
                $MerchantCode = $TenantInfo['merchant_code']."-".$CompanyName['automerchant_code'];
            }else{
                $MerchantCode = $TenantInfo['merchant_code'];
            }

            $TotalMonthly = (floatval($TenantInfo['monthly_dues']) + floatval($TenantInfo['assoc_dues'])) * floatval($TenantInfo['noofmonths']);
            $TotalDaily =  floatval($TenantInfo['daily_dues']) * floatval($TenantInfo['noofdays']);
            $GrandTotal = $TotalMonthly + $TotalDaily;

            echo $Image . "|" . $TenantInfo['tradename'] . "|" . $MerchantCode . "|" . $CompanyName['Company'] . "|" . $ContactPerson . "|" . $BillingType . "|" . date('m/d/Y', strtotime($TenantInfo['datefrom'])) . "|" . date('m/d/Y', strtotime($TenantInfo['dateto'])) . "|" . $MallName['mallname'] . "|" . $WingName['wing'] . "|" . $FloorName['floor'] . "|" . $UnitInfo['unitname'] . "|" . $UnitInfo['typeofbusiness'] . "|" . $Classification['classification'] . "|" . $Department['department'] . "|" . $Category['category'] . "|" . number_format($UnitArea, 0, ".", ",") . " SQM|" . number_format($UnitInfo['pricepersqmunitsetup'], 2, ".", ",") . "|" . number_format($UnitInfo['totalamountunitsetup'], 2, ".", ",") . "|" . floatval($TenantInfo['noofdays']) . "|" . floatval($TenantInfo[' noofmonths']) . "|" . number_format($TenantInfo['monthly_dues'], 2, ".", ",") . "|" . number_format($TenantInfo['assoc_dues'], 2, ".", ",") . "|" . number_format($GrandTotal, 2, ".", ",") . "|" . $ProposalInfo['escalation_rate'] . "%|" . $ProposalInfo['year_start'] . "|" . $ProposalInfo['year_basis'];
        break;

        case 'fncContractAmendmentList':
            $res = mysql_query("SELECT ContractID, date_created, created_by, AmendStat FROM tblcontract WHERE TenantID = '". $_POST['TenantID'] ."';", $connection);
            while($row = mysql_fetch_array($res)){
                $getUsername = mysql_fetch_array(mysql_query("SELECT CASE WHEN middlename = '' OR middlename IS NULL THEN CONCAT(lastname, ', ', firstname) ELSE CONCAT(lastname, ', ', firstname, ' ', LEFT(middlename, '1'), '.') END FROM tbluser WHERE userid = '". $row['created_by'] ."';", $connection));
                if($row['AmendStat'] == "Posted"){
                    $AmendStat = "<label class='label label-lg arrowed-in-right arrowed label-success' style='z-index: 0;'>Posted</label>";
                }else{
                    $AmendStat = "<label class='label label-lg arrowed-in-right arrowed label-warning' style='z-index: 0;'>Not Posted</label>";
                }
                echo    "<tr>
                            <td>". $row['ContractID'] ."</td>
                            <td>". date('m/d/Y', strtotime($row['date_created'])) ."</td>
                            <td>". $getUsername[0] ."</td>
                            <td>". $AmendStat ."</td>
                            <td></td>
                        </tr>";
            }
        break;
    }
?>
