<?php  
    session_start();
    include "../connect.php";
    switch ($_POST['form']) {
        case 'tblListofApplication':
            $getFilters = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'Application' AND userid = '". $_SESSION['MMS-UserID'] ."';", $connection));
            $Status = explode("|", $getFilters["bystat"]);
            $Search = explode("|", $getFilters["checked_value"]);
            $Unit = explode("|", $sql_filter["xcheck"]);
            $Date = explode("|", $getFilters["datefilter"]);

            $StatusCount = 0; $SelectedStatus = "";
            for($a = 0; $a<=count($Status)-1; $a++){
                if($Status[$a] == "Pending"){
                    $StatusVal = "(Status = 'Pending' AND S2Leasing = '1')"; 
                }else if($Status[$a] == "ForAwarding"){
                    $StatusVal = "(Status = 'ForAwarding')"; 
                }else if($Status[$a] == "Awarded"){
                    $StatusVal = "(Status = 'Awarded')"; 
                }else if($Status[$a] == "Confirmed"){
                    $StatusVal = "(Status = 'Confirmed')"; 
                }else if($Status[$a] == "Occupied"){
                    $StatusVal = "(Status = 'Occupied')"; 
                }else if($Status[$a] == "Cancelled"){
                    $StatusVal = "(Status = 'Cancelled')"; 
                }
                if($Status[$a] != ""){
                    $StatusCount++;
                    if($StatusCount == 1){
                        $SelectedStatus .= $StatusVal;
                    }else{
                        $SelectedStatus .= " OR ". $StatusVal;
                    }
                }
            }
            if($StatusCount > 1){
                $getAllStatus = "(". $SelectedStatus .")";
            }else{
                $getAllStatus = $SelectedStatus;
            }

            if($getAllStatus == ""){
                $StatFilter = "(Status = 'Pending' AND S2Leasing = '1')";
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
                $DateFilter = "AND (date_inquired BETWEEN '". date("Y-m-d", strtotime($Date[0])) ."' AND '". date("Y-m-d", strtotime($Date[1])) ."')";
            }else{
                $DateFilter = "";
            }

            $getProcessOwner = mysql_fetch_array(mysql_query("SELECT ProcessOwner FROM tbluser WHERE userid = '". $_SESSION['MMS-UserID'] ."';", $connection));
            if($getProcessOwner['ProcessOwner'] == '' || $getProcessOwner['ProcessOwner'] == null){
                $isProcessOwner = "";
            }else{
                $isProcessOwner = " AND inqPrcssOwnr = '". $getProcessOwner['ProcessOwner'] ."'";
            }
            
            $page = $_POST["page"];
            $limit = ($page-1) * 20;
            $sql = "SELECT TradeID, Company_ID, Inquiry_ID, UnitID, Application_ID, Trade_Name, Company_Name, Industry, Company_ID, date_inquired, Status, req_status, UnitType, Mall_ID, month_adv, leadsID, S2Leasing, forFinal, inqSource, inqPrcssOwnr, ActiveProposal FROM tbltrans_inquiry WHERE ". $StatFilter ." ". $SearchFilter ." ". $DateFilter ." ". $isProcessOwner ." ". getMallAccess("Mall_ID", "AND") ." AND isDirect = '0' AND isAmendment = '0' ORDER BY Inquiry_ID DESC LIMIT ".$limit.", 20;";
            $result = mysql_query($sql, $connection);
            while($row = mysql_fetch_array($result)){
                if($row["Status"] == "Pending" && ($row["forFinal"] == "1" || $row['S2Leasing'] == "1")){
                    $stat = "<span class='label label-lg label-pink arrowed-in-right arrowed' style='z-index: 0;'>Pending</span>";
                }else if($row["Status"] == "ForAwarding"){
                    $stat = "<span class='label label-lg label-yellow arrowed-in-right arrowed' style='z-index: 0;'>For Awarding</span>";
                }else if($row["Status"] == "Awarded"){
                    $stat = "<span class='label label-lg label-info arrowed-in-right arrowed' style='z-index: 0;'>Awarded</span>";
                }else if($row["Status"] == "Confirmed"){
                    $stat = "<span class='label label-lg label-success arrowed-in-right arrowed' style='z-index: 0;'>Confirmed</span>";
                }else if($row["Status"] == "Occupied"){
                    $stat = "<span class='label label-lg label-warning arrowed-in-right arrowed' style='z-index: 0;'>Occupied</span>";
                }else if($row["Status"] == "Cancelled"){
                    $stat = "<span class='label label-lg label-danger arrowed-in-right arrowed' style='z-index: 0;'>Cancelled</span>";
                }

                if($row["req_status"] == "Complete"){
                    $reqstat = "<h6 style='color:green;margin-top:3px;'><i class='fa fa-check bigger-110'></i>&nbsp;&nbsp;Complete</h6>";
                }else if($row["req_status"] == "Incomplete"){
                    $reqstat = "<h6 style='color:orange;margin-top:3px;'><i class='fa fa-remove bigger-110'></i>&nbsp;&nbsp;Incomplete</h6>";
                }

                $Source = mysql_fetch_array(mysql_query("SELECT source_desc FROM tblref_source WHERE source_code = '". $row['inqSource'] ."';", $connection));
                $ProcessOwner = mysql_fetch_array(mysql_query("SELECT deptDesc FROM tblref_process_owner WHERE deptCode = '". $row['inqPrcssOwnr'] ."';", $connection));
                $PrimaryContact = mysql_fetch_array(mysql_query("SELECT ContactID, FullName FROM tbltrans_trade_contact_person WHERE TradeID = '". $row['TradeID'] ."';", $connection));
                $PrimaryContact_Email = mysql_fetch_array(mysql_query("SELECT content FROM tbltrans_trade_contact_person_list WHERE ContactID = '". $PrimaryContact['ContactID'] ."' AND type = 'email';", $connection));
                $PrimaryContact_Mobile = mysql_fetch_array(mysql_query("SELECT content FROM tbltrans_trade_contact_person_list WHERE ContactID = '". $PrimaryContact['ContactID'] ."' AND type = 'mobile';", $connection));
                $PrimaryContact_Telephone = mysql_fetch_array(mysql_query("SELECT content FROM tbltrans_trade_contact_person_list WHERE ContactID = '". $PrimaryContact['ContactID'] ."' AND type = 'telephone';", $connection));
                $getProposalStatus = mysql_fetch_array(mysql_query("SELECT stats, proposalNum FROM tbltrans_proposal WHERE inquiryID = '". $row['Inquiry_ID'] ."' AND proposalNum = '". $row['ActiveProposal'] ."';", $connection));

                $UnitCount = 0;
                $UnitInfo = "";
                $resUnit = mysql_query("SELECT UnitID FROM tbltrans_inquiry_unit WHERE InquiryID = '". $row['Inquiry_ID'] ."';", $connection);
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

                $checkifhasevent = mysql_fetch_array(mysql_query("SELECT id FROM event_header WHERE inquiryid = '".$row['Inquiry_ID']."' ",$connection));
                if($checkifhasevent[0]==""){
                    $events = 0;
                }else{
                    $events = 1;
                }

                echo "  <tr>
                            <td style='vertical-align: middle;'>". $row['Inquiry_ID'] ."</td>
                            <td style='vertical-align: middle;'>". date('m/d/Y', strtotime($row["date_inquired"])) ."</td>
                            <td style='vertical-align: middle;' class='batayan'>". $UnitInfo ."</td>
                            <td style='vertical-align: middle;'>". $row["Trade_Name"] ."</td>
                            <td style='vertical-align: middle;'>". $row["Company_Name"] ."</td>
                            <td style='vertical-align: middle;'>". $PrimaryContact['FullName'] ."</td>
                            <td style='vertical-align: middle;'>". $PrimaryContact_Telephone['content'] ."</td>
                            <td style='vertical-align: middle;'>". $PrimaryContact_Mobile['content'] ."</td>
                            <td style='vertical-align: middle;'>". $PrimaryContact_Email['content'] ."</td>
                            <td style='vertical-align: middle;'>". $Source['source_desc'] ."</td>
                            <td style='vertical-align: middle;'>". $ProcessOwner['deptDesc'] ."</td>
                            <td style='vertical-align: middle;'>". $reqstat ."</td>
                            <td style='vertical-align: middle;'>". $stat ."</td>
                            <td style='vertical-align: middle;'><div class='btn-group'>";
                                    if($row['forFinal'] == 0 && $row['Status'] != 'Cancelled'){
                                        // echo "<button class='btn btn-sm btn-info hide isadmin select-editapplication btn-round' onclick='fncEditGlobalFormInquiry(\"0\", \"". $row['Inquiry_ID'] ."\", \"". $row['Application_ID'] ."\", \"". $row['leadsID'] ."\", \"". $row['TradeID'] ."\", \"". $row['Company_ID'] ."\", \"". $getProposalStatus['proposalNum'] ."\", \"". $getProposalStatus['stats'] ."\",\"".$events."\")' title='Update Application' style='margin: 2px;'><img src='assets/images/edit.png' style='width: 100%; height: auto;' /></button>";
                                    }

                                    /*Sendaward*/
                                    if($getProposalStatus['stats'] == '1' && ($row['Status'] == 'Pending')){
                                        echo "<button class='btn btn-sm btn-yellow hide isadmin select-editapplication btn-round' onclick='fncSendAwardNotice(\"". $row["Inquiry_ID"] ."\", \"". $row['Status'] ."\");' title='Award Tenant' style='margin: 2px;' id='btnSendAwardNotice' data-loading-text=\"<i class='fa fa-circle-o-notch fa-spin'></i>\"><img src='assets/images/award.png' style='width: 100%; height: auto;' /></button>";
                                    }

                                    if($row['Status'] != 'Cancelled'){
                                        echo "<button class='btn btn-sm btn-purple hide isadmin select-editapplication btn-round' onclick='fncBrowseProposalList(\"". $row["Inquiry_ID"] ."\", \"". $row['Company_ID'] ."\", \"". $row['TradeID'] ."\", \"". $row['forFinal'] ."\");' title='Lease Proposal' style='margin: 2px;'><img src='assets/images/resume.png' style='width: 100%; height: auto;' /></button>";
                                    }else{
                                        echo "<button class='btn btn-sm btn-purple hide isadmin select-editapplication btn-round' onclick='fncBrowseProposalList(\"". $row["Inquiry_ID"] ."\", \"". $row['Company_ID'] ."\", \"". $row['TradeID'] ."\", \"1\");' title='Lease Proposal' style='margin: 2px;'><img src='assets/images/resume.png' style='width: 100%; height: auto;' /></button>";
                                    }

                                    if($row['Status'] == 'Pending' || $row['Status'] == 'ForAwarding'){
                                        echo"<button class='btn btn-sm btn-danger hide isadmin select-viewapplicationlist btn-round' onclick='fncCancelApplication(\"". $row['Inquiry_ID'] ."\")' title='Cancel Application' style='margin: 2px;'><img src='assets/images/calendar.png' style='width: 100%; height: auto;' /></button>";
                                    }

                                    if($events == 1 && ($row['Status'] == 'Pending')){
                                        echo"<button class='btn btn-sm btn-gray hide  isadmin select-viewevents btn-round' onclick='frmeventformop(\"". $row['Inquiry_ID'] ."\",".$events.",\"".$row['Company_ID']."\",0,\"".$row['ActiveProposal']."\",\"".$getProposalStatus['stats']."\")' title='View Event' style='margin: 2px;'><img src='assets/images/ticket.png' style='width: 100%; height: auto;' /></button>";
                                    }elseif($events == 1 && ($row['Status'] != 'Pending')){
                                        echo"<button class='btn btn-sm btn-gray hide  isadmin select-viewevents btn-round' onclick='frmeventformop(\"". $row['Inquiry_ID'] ."\",".$events.",\"".$row['Company_ID']."\",1,\"".$row['ActiveProposal']."\",\"".$getProposalStatus['stats']."\")' title='View Event' style='margin: 2px;'><img src='assets/images/ticket.png' style='width: 100%; height: auto;' /></button>";
                                    }

                                    if($row['Status'] == 'Awarded'){
                                        echo "<button class='btn btn-default btn-sm btn-round' aria-expanded='false' onclick='fncSelectReportType(\"". $row['Inquiry_ID'] ."\", \"AwardNotice\", \"". $getProposalStatus['proposalNum'] ."\");' style='margin: 2px;' title='Print Award Notice'><img src='assets/images/printer.png' style='width: 100%; height: auto;' /></button>";
                                    }

                                        echo"<button class='btn btn-sm btn-gray hide isadmin select-applicationviewlogs btn-round' onclick='ViewTrasactionLogs(\"". $row["Inquiry_ID"] ."\")' title='View Logs' style='margin: 2px;'><img src='assets/images/clock.png' style='width: 100%; height: auto;' /></button>";
                                    echo"</div>
                            </td>
                        </tr>";
            }
        break;

        case 'tblListofApplicationEntries':
            $getFilters = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'Application' AND userid = '". $_SESSION['MMS-UserID'] ."';", $connection));
            $Status = explode("|", $getFilters["bystat"]);
            $Search = explode("|", $getFilters["checked_value"]);
            $Unit = explode("|", $sql_filter["xcheck"]);
            $Date = explode("|", $getFilters["datefilter"]);

            $StatusCount = 0; $SelectedStatus = "";
            for($a = 0; $a<=count($Status)-1; $a++){
                if($Status[$a] == "Pending"){
                    $StatusVal = "(Status = 'Pending' AND S2Leasing = '1')"; 
                }else if($Status[$a] == "ForAwarding"){
                    $StatusVal = "(Status = 'ForAwarding')"; 
                }else if($Status[$a] == "Awarded"){
                    $StatusVal = "(Status = 'Awarded')"; 
                }else if($Status[$a] == "Confirmed"){
                    $StatusVal = "(Status = 'Confirmed')"; 
                }else if($Status[$a] == "Occupied"){
                    $StatusVal = "(Status = 'Occupied')"; 
                }else if($Status[$a] == "Cancelled"){
                    $StatusVal = "(Status = 'Cancelled')"; 
                }
                if($Status[$a] != ""){
                    $StatusCount++;
                    if($StatusCount == 1){
                        $SelectedStatus .= $StatusVal;
                    }else{
                        $SelectedStatus .= " OR ". $StatusVal;
                    }
                }
            }
            if($StatusCount > 1){
                $getAllStatus = "(". $SelectedStatus .")";
            }else{
                $getAllStatus = $SelectedStatus;
            }

            if($getAllStatus == ""){
                $StatFilter = "(Status = 'Pending' AND S2Leasing = '1')";
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
                $DateFilter = "AND (date_inquired BETWEEN '". date("Y-m-d", strtotime($Date[0])) ."' AND '". date("Y-m-d", strtotime($Date[1])) ."')";
            }else{
                $DateFilter = "";
            }

            $getProcessOwner = mysql_fetch_array(mysql_query("SELECT ProcessOwner FROM tbluser WHERE userid = '". $_SESSION['MMS-UserID'] ."';", $connection));
            if($getProcessOwner['ProcessOwner'] == '' || $getProcessOwner['ProcessOwner'] == null){
                $isProcessOwner = "";
            }else{
                $isProcessOwner = " AND inqPrcssOwnr = '". $getProcessOwner['ProcessOwner'] ."'";
            }

            if($_POST["page"] == ""){ 
                $page = 1; 
            }else{ 
                $page = $_POST["page"]; 
            }
            $limit = ($page-1) * 20;
            $rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM tbltrans_inquiry WHERE ". $StatFilter ." ". $SearchFilter ." ". $DateFilter ." ". $isProcessOwner ." ". getMallAccess("Mall_ID", "AND") ." AND isDirect = '0' AND isAmendment = '0';", $connection));
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

        case 'tblListofApplicationPagination':
            $getFilters = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'Application' AND userid = '". $_SESSION['MMS-UserID'] ."';", $connection));
            $Status = explode("|", $getFilters["bystat"]);
            $Search = explode("|", $getFilters["checked_value"]);
            $Unit = explode("|", $sql_filter["xcheck"]);
            $Date = explode("|", $getFilters["datefilter"]);

            $StatusCount = 0; $SelectedStatus = "";
            for($a = 0; $a<=count($Status)-1; $a++){
                if($Status[$a] == "Pending"){
                    $StatusVal = "(Status = 'Pending' AND S2Leasing = '1')"; 
                }else if($Status[$a] == "ForAwarding"){
                    $StatusVal = "(Status = 'ForAwarding')"; 
                }else if($Status[$a] == "Awarded"){
                    $StatusVal = "(Status = 'Awarded')"; 
                }else if($Status[$a] == "Confirmed"){
                    $StatusVal = "(Status = 'Confirmed')"; 
                }else if($Status[$a] == "Occupied"){
                    $StatusVal = "(Status = 'Occupied')"; 
                }else if($Status[$a] == "Cancelled"){
                    $StatusVal = "(Status = 'Cancelled')"; 
                }
                if($Status[$a] != ""){
                    $StatusCount++;
                    if($StatusCount == 1){
                        $SelectedStatus .= $StatusVal;
                    }else{
                        $SelectedStatus .= " OR ". $StatusVal;
                    }
                }
            }
            if($StatusCount > 1){
                $getAllStatus = "(". $SelectedStatus .")";
            }else{
                $getAllStatus = $SelectedStatus;
            }

            if($getAllStatus == ""){
                $StatFilter = "(Status = 'Pending' AND S2Leasing = '1')";
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
                $DateFilter = "AND (date_inquired BETWEEN '". date("Y-m-d", strtotime($Date[0])) ."' AND '". date("Y-m-d", strtotime($Date[1])) ."')";
            }else{
                $DateFilter = "";
            }

            $getProcessOwner = mysql_fetch_array(mysql_query("SELECT ProcessOwner FROM tbluser WHERE userid = '". $_SESSION['MMS-UserID'] ."';", $connection));
            if($getProcessOwner['ProcessOwner'] == '' || $getProcessOwner['ProcessOwner'] == null){
                $isProcessOwner = "";
            }else{
                $isProcessOwner = " AND inqPrcssOwnr = '". $getProcessOwner['ProcessOwner'] ."'";
            }

            $page = $_POST["page"];
            $rowCount = mysql_fetch_row(mysql_query("SELECT COUNT(id) FROM tbltrans_inquiry WHERE ". $StatFilter ." ". $SearchFilter ." ". $DateFilter ." ". $isProcessOwner ." ". getMallAccess("Mall_ID", "AND") ." AND isDirect = '0' AND isAmendment = '0';", $connection));
            $rowsperpage = 20;
            $range = 3;
            $totalpages = ceil($rowCount[0] / $rowsperpage);
            $prevpage;
            $nextpage;
            if($page > 1 ){
               echo "<li style='width:50px !important;' onclick='tblListofApplicationPageFunc(1)'><< First</li>";
               $prevpage = $page - 1;
               echo "<li style='width:70px !important;' onclick='tblListofApplicationPageFunc(". $prevpage .")'>< Previous</li>";
            }
            for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
                if (($x > 0) && ($x <= $totalpages)){
                    if ($x == $page){
                        echo "<li id='pgLA" . $x . "' class='pgnumLA active' onclick='tblListofApplicationPageFunc(" . $x . ",". $x .")'>" . $x . "</li>"; 
                    }else{
                        echo "<li id='pgLA" . $x . "' class='pgnumLA' onclick='tblListofApplicationPageFunc(" . $x . ",". $x .")'>" . $x . "</li>"; 
                    }
                }
            }
            if($page < ($totalpages - $range)){ 
                echo "<li>...</li>"; 
            }
            if($page != $totalpages && $rowCount[0] != 0){
                $nextpage = $page + 1;
                echo "<li style='width:50px !important;' onclick='tblListofApplicationPageFunc(". $nextpage .", ". $nextpage .")'>Next ></li>";
                echo "<li style='width:50px !important;' onclick='tblListofApplicationPageFunc(". $totalpages .", ". $totalpages .")'>Last >></li>";
            }
        break;

        case 'fncgetProposalList':
            $resPro = mysql_query("SELECT proposalNum, stats, datecreated, date_approved, approved_by, isPrimary FROM tbltrans_proposal WHERE inquiryID = '". $_POST['InquiryID'] ."';", $connection);
            $cntPro = mysql_num_rows($resPro);
            if($cntPro == 0){
                $InquiryInfo = mysql_fetch_array(mysql_query("SELECT Inquiry_ID, Application_ID, leadsID, TradeID, Company_ID, date_inquired, Status FROM tbltrans_inquiry WHERE Inquiry_ID = '". $_POST['InquiryID'] ."';", $connection));
                if($InquiryInfo['Status'] == 'Cancelled'){
                    $isEdit = "1";
                }else{
                    $isEdit = "0";
                }
                /*Chechking if events exist*/
                $eventscheck = mysql_fetch_array(mysql_query("SELECT id FROM event_header WHERE inquiryid = '".$InquiryInfo['Inquiry_ID']."' AND proposalNum = '1' "));
                
                if($eventscheck[0]==""){
                    $eventstick = "grey";
                    $events = 0;
                    $eventholder = "Create Event";
                }else{
                    $eventstick = "green";
                    $events = 1;
                    $eventholder = "View Event";
                }

                if($events==1 && ($InquiryInfo['Status'] == 'Pending' )){
                    $disabledevents = 0;
                }elseif($events==0 && ($InquiryInfo['Status'] == 'Pending' )){
                    $disabledevents = 0;
                }else{
                    $disabledevents = 1;
                }
                               
                /*CLOSE*/
                echo    "<div class='col-md-4' style='margin-top: 10px; cursor: pointer !important;'>
                            <div class='alert alert-warning'>
                                <div class='row'>
                                    <div class='col-md-2 pull-right'><a class='fa fa-calendar-o fa-2x ".$eventstick."' style='cursor: pointer !important;' title='".$eventholder."' onclick='$(\"#mdlProposalList\").modal(\"hide\");frmeventformop(\"".$InquiryInfo['Inquiry_ID']."\",".$events.",\"".$InquiryInfo['Company_ID']."\",".$disabledevents.")'></a></div>
                                </div>
                                <center  onclick='fncEditGlobalFormInquiry(\"". $isEdit ."\", \"". $InquiryInfo['Inquiry_ID'] ."\", \"". $InquiryInfo['Application_ID'] ."\", \"". $InquiryInfo['leadsID'] ."\", \"". $InquiryInfo['TradeID'] ."\", \"". $InquiryInfo['Company_ID'] ."\", \"0\", \"\")'>
                                    <h4 class='header'>Proposal 1</h4>
                                    ". date('F d, Y', strtotime($InquiryInfo['date_inquired'])) ."
                                </center>
                            </div>
                        </div>";
            }else{
                while ($rowPro = mysql_fetch_array($resPro)) {
                    if($rowPro['stats'] == 1){
                        $alertColor = "info";
                    }else{
                        $alertColor = "warning";
                    }
                    $InquiryInfo = mysql_fetch_array(mysql_query("SELECT Inquiry_ID, Application_ID, leadsID, TradeID, Company_ID, forFinal, app_by, date_applied, Status FROM tbltrans_inquiry WHERE Inquiry_ID = '". $_POST['InquiryID'] ."';", $connection));

                    if($InquiryInfo['Status'] == 'Cancelled'){
                        $isEdit = "1";
                    }else{
                        $isEdit = $InquiryInfo['forFinal'];
                    }

                    /*Chechking if events exist*/
                    $eventscheck = mysql_fetch_array(mysql_query("SELECT id FROM event_header WHERE inquiryid = '".$InquiryInfo['Inquiry_ID']."' AND proposalNum = '".$rowPro['proposalNum']."' ",$connection));
                    if($eventscheck[0]==""){
                        $eventstick = "grey";
                        $events = 0;
                        $eventholder = "Create Event";
                    }else{
                        $eventstick = "green";
                        $events = 1;
                        $eventholder = "View Event";
                    }

                    if($events==1 && ($InquiryInfo['Status'] == 'Pending')){
                        $disabledevents = 0;
                    }elseif($events==0 && ($InquiryInfo['Status'] == 'Pending' )){
                        $disabledevents = 0;
                    }else{
                        $disabledevents = 1;
                    }

                    if($rowPro['stats'] == '1' && $eventscheck[0]==""){
                        $eventhide = " hide ";
                    }else{
                        $eventhide = "";
                    }
                       
                    /*CLOSE*/

                    if($rowPro['isPrimary'] == '1'){
                        $isPrimary = "<div class='row'>
                                        <div class='col-md-2 pull-left'><i class='fa fa-star fa-2x orange' title='Active Proposal'></i></div>
                                        <div class='col-md-2 pull-right ".$eventhide."'><a class='fa fa-calendar-o fa-2x ".$eventstick."' style='cursor: pointer !important;' title='".$eventholder."' onclick='$(\"#mdlProposalList\").modal(\"hide\");frmeventformop(\"".$InquiryInfo['Inquiry_ID']."\",".$events.",\"".$InquiryInfo['Company_ID']."\",".$disabledevents.",\"".$rowPro['proposalNum']."\",\"".$rowPro['stats']."\")'></a></div>
                                    </div>";
                    }else{
                        $isPrimary = "<div class='row'>
                                        <div class='col-md-2' pull-left><a class='fa fa-star fa-2x grey' style='cursor: pointer !important;' title='Set as Active Proposal' onclick='fncChangeActiveProposal(\"". $InquiryInfo['Inquiry_ID'] ."\", \"". $rowPro['proposalNum'] ."\")'></a></div>
                                        <div class='col-md-2 pull-right ".$eventhide."'><a class='fa fa-calendar-o fa-2x ".$eventstick."' style='cursor: pointer !important;' title='".$eventholder."' onclick='$(\"#mdlProposalList\").modal(\"hide\");frmeventformop(\"".$InquiryInfo['Inquiry_ID']."\",".$events.",\"".$InquiryInfo['Company_ID']."\",".$disabledevents.",\"".$rowPro['proposalNum']."\",\"".$rowPro['stats']."\")'></a></div>

                                     </div>";
                    }

                    if($rowPro['stats'] == '1'){
                        echo    "<div class='col-md-4' style='margin-top: 10px;'>
                                    <div class='alert alert-". $alertColor ."' style='cursor: pointer !important;'>
                                        ". $isPrimary ."
                                        <center onclick='fncEditGlobalFormInquiry(\"1\", \"". $InquiryInfo['Inquiry_ID'] ."\", \"". $InquiryInfo['Application_ID'] ."\", \"". $InquiryInfo['leadsID'] ."\", \"". $InquiryInfo['TradeID'] ."\", \"". $InquiryInfo['Company_ID'] ."\", \"". $rowPro['proposalNum'] ."\", \"". $rowPro['stats'] ."\")'>
                                            <h4 class='header'>Proposal ". $rowPro['proposalNum'] ."</h4>
                                            ". date('F d, Y', strtotime($rowPro['datecreated'])) ."
                                        </center>
                                        <center>
                                            <div class='row'>
                                                <div class='infobox infobox-blue' style='background-color: transparent !important;border: none !important;'>
                                                    <div class='infobox-icon'>
                                                        <i class='ace-icon fa fa-thumbs-o-up'></i>
                                                    </div>
                                                    <div class='infobox-data' style='margin-top: 5px;'>
                                                        <span class='infobox-data-number'>Approved</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class='row'>
                                                <div class='col-md-12'>
                                                    Approved by:
                                                </div>
                                                <div class='col-md-12 bolder'>
                                                    ". $rowPro['approved_by'] ."
                                                </div>
                                                <div class='col-md-12'>
                                                    Approved date:
                                                </div>
                                                <div class='col-md-12 bolder'>
                                                    ". date('m/d/Y h:i A', strtotime($rowPro['date_approved'])) ."
                                                </div>
                                            </div>
                                            <div class='row'>
                                                <div class='col-md-12'>
                                                    <button class='btn btn-default btn-sm btn-round' aria-expanded='false' onclick='fncSelectReportType(\"". $InquiryInfo['Inquiry_ID'] ."\", \"Proposal\", \"". $rowPro['proposalNum'] ."\");' title='Print Proposal'><img src='assets/images/printer.png' style='width: 100%; height: auto;' /></button>
                                                </div>
                                            </div>
                                        </center>
                                    </div>
                                </div>";
                                
                    }else{
                        echo    "<div class='col-md-4' style='margin-top: 10px;'>
                                    <div class='alert alert-". $alertColor ."'>
                                        ". $isPrimary ."
                                        <center style='cursor: pointer !important;' onclick='fncEditGlobalFormInquiry(\"". $isEdit ."\", \"". $InquiryInfo['Inquiry_ID'] ."\", \"". $InquiryInfo['Application_ID'] ."\", \"". $InquiryInfo['leadsID'] ."\", \"". $InquiryInfo['TradeID'] ."\", \"". $InquiryInfo['Company_ID'] ."\", \"". $rowPro['proposalNum'] ."\", \"\", \"\")'>
                                            <h4 class='header'>Proposal ". $rowPro['proposalNum'] ."</h4>
                                            ". date('F d, Y', strtotime($rowPro['datecreated'])) ."
                                        </center>
                                        <center class='hide'></br><a href='#' onclick='fncApproveProposal(\"". $InquiryInfo['Inquiry_ID'] ."\", \"". $rowPro['proposalNum'] ."\")' class='fa fa-thumbs-o-up bigger-160 blue' style='cursor: pointer !important;' title='Approve Proposal'></a></center>
                                    </div>
                                </div>";
                    }
                }
            }
        break;

        case 'fncApproveProposalGo':
            $resUpdateProposal = mysql_query("UPDATE tbltrans_proposal SET stats = '1', date_approved = '". date('Y-m-d H:iS') ."', approved_by = '". getusername() ."' WHERE inquiryID = '". $_POST['InquiryID'] ."' AND proposalNum = '". $_POST['isProposal'] ."';", $connection);
            $resUpdateInquiry = mysql_query("UPDATE tbltrans_inquiry SET ActiveProposal = '". $_POST['isProposal'] ."' WHERE Inquiry_ID = '". $_POST['InquiryID'] ."';", $connection);
            echo 1;
            $tran_logs = create_logs_per_transaction('approved a proposal', 'Leasing Module', '', '', 'UPDATE', $_POST['InquiryID']);
        break;

        case 'fncSendAwardNotice2':
            $isFailed = 0;
            $isSuccess = 0;
            $getInquiryInfo = mysql_fetch_array(mysql_query("SELECT datefrom, dateto FROM tbltrans_inquiry WHERE Inquiry_ID = '". $_POST['InquiryID'] ."';", $connection));
            $getUnitList = mysql_query("SELECT UnitID FROM tbltrans_inquiry_unit WHERE InquiryID = '". $_POST['InquiryID'] ."';", $connection);
            while($rowUnitList = mysql_fetch_array($getUnitList)){
                $reschkOCcupancy = mysql_query("SELECT STATUS FROM tblunit_statuslogs WHERE unitid = '". $rowUnitList['UnitID'] ."' AND xdate BETWEEN '". date('Y-m-d', strtotime($getInquiryInfo['datefrom'])) ."' AND '". date('Y-m-d', strtotime($getInquiryInfo['dateto'])) ."' GROUP BY STATUS ORDER BY STATUS ASC;", $connection);
                $chkOccupancy = mysql_fetch_array($reschkOCcupancy);
                $numOccupancy = mysql_num_rows($reschkOCcupancy);
                $getUnitName = mysql_fetch_array(mysql_query("SELECT unitname FROM tblref_unit WHERE unitid = '". $rowUnitList['UnitID'] ."';", $connection));
                if($numOccupancy == 0){
                    $StartDate = date('Y-m-d', strtotime($getInquiryInfo['datefrom']));
                    while (date('Y-m-d', strtotime($StartDate)) <= date('Y-m-d', strtotime($getInquiryInfo['dateto']))) {
                        $resInsertLogs = mysql_query("INSERT INTO tblunit_statuslogs SET unitid = '". $rowUnitList['UnitID'] ."', unitname = '". $getUnitName['unitname'] ."', xdate = '". $StartDate ."', xtime = '". date('H:i:s') ."', status = 'ForAwarding', inquiryid = '". $_POST['InquiryID'] ."';", $connection);
                        $isSuccess++;
                        $StartDate = date('Y-m-d', strtotime($StartDate . '+1 day'));
                    }
                    $AppPref = mysql_fetch_array(mysql_query("SELECT appprefix FROM tblsys_setup;", $connection));
                    $ApplicationID = createidno($AppPref['appprefix'], "tbltrans_appid", "app_id");
                    $res = mysql_query("UPDATE tbltrans_inquiry SET Status = 'ForAwarding', mod_by = '". getusername() ."', date_modified = '". date('Y-m-d H:i:s') ."', Application_ID = '". $ApplicationID ."', applicationDate = '". date('Y-m-d') ."', date_applied = '". date('Y-m-d H:i:s') ."', app_by = '". getusername() ."', forFinal = '1', awardstatus = 'Pending', userid_aw = '". $_SESSION['MMS-UserID'] ."' WHERE Inquiry_ID = '". $_POST['InquiryID'] ."';", $connection);
                    // INSERT LOGS JONAS 9/30/2019 START
                    $arrHeader = ["Inquiry ID", "Status"];
                    $arrValue = [$_POST['InquiryID'], "For Awarding"];
                    $tran_logs = create_logs_per_transaction("send an award notice.", "Leasing Module", createXinfo("UPDATE", $arrHeader, "", $arrValue, "", "", ""), "" ,"UPDATE", $_POST['InquiryID']);
                    // INSERT LOGS JONAS 9/30/2019 END
                }else if($chkOccupancy['STATUS'] == 'Vacant'){
                    $resUpdateLogs = mysql_query("UPDATE tblunit_statuslogs SET status = 'ForAwarding' WHERE unitid = '". $rowUnitList['UnitID'] ."';", $connection);
                        $isSuccess++;
                    $AppPref = mysql_fetch_array(mysql_query("SELECT appprefix FROM tblsys_setup;", $connection));
                    $ApplicationID = createidno($AppPref['appprefix'], "tbltrans_appid", "app_id");
                    $res = mysql_query("UPDATE tbltrans_inquiry SET Status = 'ForAwarding', mod_by = '". getusername() ."', date_modified = '". date('Y-m-d H:i:s') ."', Application_ID = '". $ApplicationID ."', applicationDate = '". date('Y-m-d') ."', date_applied = '". date('Y-m-d H:i:s') ."', app_by = '". getusername() ."', forFinal = '1', awardstatus = 'Pending', userid_aw = '". $_SESSION['MMS-UserID'] ."' WHERE Inquiry_ID = '". $_POST['InquiryID'] ."';", $connection);
                    // INSERT LOGS JONAS 9/30/2019 START
                    $arrHeader = ["Inquiry ID", "Status"];
                    $arrValue = [$_POST['InquiryID'], "For Awarding"];
                    $tran_logs = create_logs_per_transaction("send an award notice.", "Leasing Module", createXinfo("UPDATE", $arrHeader, "", $arrValue, "", "", ""), "" ,"UPDATE", $_POST['InquiryID']);
                    // INSERT LOGS JONAS 9/30/2019 END
                }else if($chkOccupancy['STATUS'] == 'Occupied' || $chkOccupancy['STATUS'] == 'ForAwarding' || $chkOccupancy['STATUS'] == 'Reserved' || $chkOccupancy['STATUS'] == 'Awarded'){
                    $isFailed++;
                }
            }
                
            if($isFailed == 0 && $isSuccess >= 1){
                echo "1|Approver succesfully notified.";
            }else if($isFailed >= 1 && $isSuccess == 0){
                echo "2|Sorry but selected unit is not available.";
            }else{
                echo "2|Failed to notify approver.";
            }
        break;

        case 'fncApproveAward':
            if($_POST['AwardStat'] == 'Approved'){
                $AwardStat = 'Awarded';
            }else{
                $AwardStat = 'Disapproved';
            }
            $res = mysql_query("UPDATE tbltrans_inquiry SET Status = '". $AwardStat ."', date_approved = '". date('Y-m-d H:i:s') ."', appr_by = '". getusername() ."' WHERE Inquiry_ID = '". $_POST['InquiryID'] ."';", $connection);
            // INSERT LOGS JONAS 9/30/2019 START
            $arrHeader = ["Inquiry ID", "Status"];
            $arrValue = [$_POST['InquiryID'], "Awarded"];
            $tran_logs = create_logs_per_transaction("updated an application status to awarded.", "Leasing Module", createXinfo("UPDATE", $arrHeader, "", $arrValue, "", "", ""), "" ,"UPDATE", $_POST['InquiryID']);
            // INSERT LOGS JONAS 9/30/2019 END
        break;

        case 'fncChangeActiveProposal2':
            $resUpdateInquiry = mysql_query("UPDATE tbltrans_inquiry SET ActiveProposal = '". $_POST['ProposalNum'] ."' WHERE Inquiry_ID = '". $_POST['InquiryID'] ."';", $connection);
            $getProposalInfo = mysql_fetch_array(mysql_query("SELECT dateFrom, dateTo, desiredYear, desiredMonths, desiredDays, monthlyDues FROM tbltrans_proposal WHERE InquiryID = '". $_POST['InquiryID'] ."' AND proposalNum = '". $_POST['ProposalNum'] ."';", $connection));
            $res = mysql_query("UPDATE tbltrans_inquiry SET date_modified = '". date('Y-m-d H:i:s') ."', mod_by = '". getusername() ."', datefrom = '". date('Y-m-d', strtotime($getProposalInfo['dateFrom'])) ."', dateto = '". date('Y-m-d', strtotime($getProposalInfo['dateTo'])) ."', billingtype = '". $getProposalInfo['BillingType'] ."', billingperc = '". $getProposalInfo['BillPercent'] ."', desired_noofmonths = '". $getProposalInfo['desiredMonths'] ."', desired_noofyears = '". $getProposalInfo['desiredYear'] ."', desired_noofdays = '". $getProposalInfo['desiredDays'] ."', monthly_dues = '". floatval($getProposalInfo['monthlyDues']) ."' WHERE Inquiry_ID = '". $_POST['InquiryID'] ."';", $connection);
            $resDeleteUnit = mysql_query("DELETE FROM tbltrans_inquiry_unit WHERE InquiryID = '". $_POST['InquiryID'] ."';", $connection);
            if($resDeleteUnit == true){
                $UnitList = "";
                $resgetProposalUnit = mysql_query("SELECT UnitID FROM tbltrans_proposal_unit WHERE InquiryID = '". $_POST['InquiryID'] ."' AND ProposalNum = '". $_POST['ProposalNum'] ."';", $connection);
                while($rowproposalUnit = mysql_fetch_array($resgetProposalUnit)){
                    $resInsertUnit = mysql_query("INSERT INTO tbltrans_inquiry_unit SET InquiryID = '". $_POST['InquiryID'] ."', UnitID = '". $rowproposalUnit[0] ."';", $connection);
                    $UnitName = mysql_fetch_array(mysql_query("SELECT unitname FROM tblref_unit WHERE unitID = '". $rowproposalUnit[0] ."';", $connection));
                    $UnitList .= "<br/>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;". $rowproposalUnit[0] ."&nbsp;<span class='fa fa-angle-right blue'></span>&nbsp;". $UnitName[0];
                }
            }
            $resUpdateProposal = mysql_query("UPDATE tbltrans_proposal SET isPrimary = '1' WHERE InquiryID = '". $_POST['InquiryID'] ."' AND proposalNum = '". $_POST['ProposalNum'] ."';", $connection);
            $resUpdateOthProposal = mysql_query("UPDATE tbltrans_proposal SET isPrimary = '0' WHERE InquiryID = '". $_POST['InquiryID'] ."' AND proposalNum != '". $_POST['ProposalNum'] ."';", $connection);
            if($resUpdateInquiry == true && $resUpdateProposal == true && $resUpdateOthProposal == true){
                echo 1;
            }else{
                echo 2;
            }
        break;
    }
?>