<?php 
    session_start();
    include("../../connect.php");
	switch ($_POST['form']) {
		case 'loadMainComplaints':
            $getFilters = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'Complaint';", $connection));
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
                $StatFilter2 = "Complaint_Status = 'Pending'"; 
            }else{
                $StatFilter2 = $getAllStatus2;
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

			$page = $_POST['page'];
			$limit = ($page-1) * 20;
			$res = mysql_query("SELECT TenantID, TradeName, Complaint_Code, Complete_Description, Time_Received, Time_Resolved, Complaint_Status, Priority_Status, MallID, Complaint_Series_No, UnitID FROM tblcomplaints WHERE ". $StatFilter ." ". $StatFilter2 ." ". $SearchFilter ." ". $DateFilter ." ORDER BY xdate DESC LIMIT ".$limit.",20;", $connection);
			while($row = mysql_fetch_array($res)){
				$assignperson = mysql_fetch_array(mysql_query("SELECT workername FROM tblmaintenance_workorder WHERE Complaint_Series_No = '". $row[0] ."' "));
				$unitname = mysql_fetch_array(mysql_query("SELECT Unitname FROM tblref_unit WHERE unitid = '". $row['UnitID'] ."'", $connection));
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

                if($row['Complaint_Status'] == "Resolved" || $row['Complaint_Status'] == "Ongoing"){
                	$disdis = "disabled";
                }else{
                	$disdis = "";
                }

                echo "	<tr>
							<td>". $row['TenantID'] ."</td>
							<td>". $row['TradeName'] ."</td>
							<td>". $row['Complaint_Code'] ."</td>
							<td>". $row['Complete_Description'] ."</td>
							<td>". $TimeReceived ."</td>
							<td>". $TimeResolved ."</td>
							<td>". $assignperson ."</td>
							<td>". $row['Complaint_Status'] ."</td>
							<td style='z-index: 0;'>". $PrioStat ."</td>
							<td class='center' style='z-index: 0;'>
                                <div class='btn-group'>
									<button ". $disdis ." class='btn btn-sm btn-primary hide isadmin select-createworkorderfromcomplaints btn-round' onclick='setcomplaintastask(\"". $row['TenantID'] ."\", \"". $row['Complaint_Code'] ."\", \"". $row['Complete_Description'] ."\", \"". $row['TradeName'] ."\", \"". $unitname['Unitname'] ."\", \"". $row['Complaint_Series_No'] ."\");' title='Create Work Order' style='margin: 2px;'><img src='assets/images/wrench.png' style='width: 100%; height: auto;'></button>
									<button class='btn btn-sm btn-default hide isadmin select-printcomplaint btn-round' onclick='printcomplaint(\"". $row['Complaint_Series_No'] ."\", \"". $row['MallID'] ."\");' title='Print Complaint' style='margin: 2px;'><img src='assets/images/printer.png' style='width: 100%; height: auto;'></button>
                                </div>
							</td>
						</tr>";
			}
		break;

		case 'loadMainComplaintsEntries':
			$getFilters = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'Complaint';", $connection));
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
                $StatFilter2 = "Complaint_Status = 'Pending'"; 
            }else{
                $StatFilter2 = $getAllStatus2;
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

	        if($_POST["page"] == ""){
	            $page = 1;
	        }else{
	            $page = $_POST["page"];
	        }
          	$limit = ($page-1) * 20;
            $rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM tblcomplaints WHERE ". $StatFilter ." ". $StatFilter2 ." ". $SearchFilter ." ". $DateFilter .";", $connection));
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

		case "loadMainComplaintsPage":
            $getFilters = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'Complaint';", $connection));
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
                $StatFilter2 = "Complaint_Status = 'Pending'"; 
            }else{
                $StatFilter2 = $getAllStatus2;
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

	    	$page = $_POST["page"];
			$rowCount = mysql_fetch_row(mysql_query("SELECT COUNT(id) FROM tblcomplaints WHERE ". $StatFilter ." ". $StatFilter2 ." ". $SearchFilter ." ". $DateFilter .";", $connection));
			$rowsperpage = 20;
			$range = 3;
			$totalpages = ceil($rowCount[0] / $rowsperpage);
			$prevpage;
			$nextpage;
			if($page > 1 ){
			   	echo "<li style='width:50px !important;' onclick='pagination(1)'><< First</li>";
			   	$prevpage = $page - 1;
			   	echo "<li style='width:70px !important;' onclick='pagination(". $prevpage .")'>< Previous</li>";
			}

			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   	if(($x > 0) && ($x <= $totalpages)){
    			    if($x == $page){
                        echo "<li id='pgcomplaints" . $x . "' class='pgnumpcomplaints active' onclick='pagination(" . $x . ",". $x .")'>" . $x . "</li>";
                    }else{
    			        echo "<li id='pgcomplaints" . $x . "' class='pgnumpcomplaints' onclick='pagination(" . $x . ",". $x .")'>" . $x . "</li>";
                    }
		        }
		    }
		    if($page < ($totalpages - $range)){
                echo "<li>...</li>";
            }

		    if($page != $totalpages && $rowCount[0] != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='pagination(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='pagination(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'savecomplaintsmodal':
			$jonumber = createidno("JO", "tblmaintenance_workorder", "workorderid");
			$ownername = mysql_fetch_array(mysql_query("SELECT CONCAT(owner_firstname, ' ' ,owner_lastname), tradename, mallID FROM tbltrans_tenants WHERE TenantID = '". $_POST['tenantid'] ."' ", $connection));
			$sql = " INSERT INTO tblmaintenance_workorder SET TenantID = '". $_POST['tenantid'] ."', xdate = '". date('Y-m-d') ."', xtime = '". date('H:i:s') ."', departmentid = '". $_POST['assignedperson'] ."', Complaint_Series_No = '". $_POST['complaint_series_no'] ."', startdate = '". date('Y-m-d', strtotime($_POST['datestart'])) ."', starttime = '". date('H:i:s', strtotime($_POST['starttime'])) ."', workorderid = '". $jonumber ."', ownername = '".$ownername[0]."', tradename = '". $ownername[1] ."', mallid = '". $ownername[2] ."' ";
			$res = mysql_query($sql, $connection);
			if($res == true){
				$sql2 = "UPDATE tblcomplaints SET Complaint_Status = 'Ongoing', Time_Received = '". date('Y-m-d H:i:s') ."' WHERE Complaint_Series_No = '". $_POST["complaint_series_no"] ."' ";
				$result2 = mysql_query($sql2, $connection);
				if($result2 == true){
					echo 1;
				}
			}
		break;
	}
?>