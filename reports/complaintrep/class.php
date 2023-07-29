<?php
	session_start();
	include "../../connect.php";
	$filepath = mysql_fetch_array(mysql_query("SELECT dbsetup FROM tblsys_setup;", $connection)); //Get System Setup
	$tblPayment = tblPayment($filepath['dbsetup']);
	$tblVoid = tblVoid($filepath['dbsetup']);
	$tblDiscount = tblDiscount($filepath['dbsetup']);
	$tblSales = tblSales($filepath['dbsetup']);
	$tblHourly = tblHourly($filepath['dbsetup']);
	switch ($_POST['form']) {
		
		case 'dbcomplaint':
			$page = $_POST['page'];
			$limit = ($page-1) * 20;
			if($_POST['MallID'] == '' || $_POST['MallID'] == 'null'){
				$WithMall = getMallAccess("a.mallid", "AND");
			}else{
				$WithMall = "AND a.mallid = '". $_POST['MallID'] ."'";
			}
			$printcomplaint = mysql_fetch_array(mysql_query("SELECT TradeName, MallID, FloorID, UnitID, Date_Entry, UserID, xdate, Complaint_Code, Complete_Description, TenantID, Complaint_Status,  Time_Received, Time_Resolved, Priority_Status, Complaint_Series_No FROM tblcomplaints WHERE TenantID = '". $_POST['key']."';", $connection));
			$mallname = mysql_fetch_array(mysql_query("SELECT mallname FROM tblref_mall WHERE mallid = '". $printcomplaint[1] ."'; ", $connection));
			$floorname = mysql_fetch_array(mysql_query("SELECT floor FROM tblref_floorsetup WHERE FloorID = '". $printcomplaint[2] ."'; ", $connection));
			$unitname = mysql_fetch_array(mysql_query("SELECT unitname, buildingname FROM tblref_unit WHERE UnitID = '". $printcomplaint[3] ."'; ", $connection));
			$wingname = mysql_fetch_array(mysql_query("SELECT wingID, mallID FROM tblref_wing  WHERE mallid = '". $printcomplaint[1] ."'; ", $connection));
			$username2 = mysql_fetch_array(mysql_query("SELECT CONCAT(firstname, ' ', lastname) FROM tbluser WHERE userid = '". $printcomplaint['UserID'] ."';", $connection));
				echo 	"<tr>
							<td>". $printcomplaint[0]."</td>
							<td>". $printcomplaint['TenantID'] ."</td>
							<td>". $mallname['mallname'] ."</td>
							<td>". $wingname['wingID']."</td>
							<td>". $unitname['unitname']."</td>
							<td>". date('Y-m-d', strtotime($printcomplaint['xdate'])) ."</td>
							<td>". $printcomplaint[7]."</td>
							<td>". $printcomplaint[10]."</td>
							<td>". $printcomplaint[13]."</td>
						</tr>";	
		
		break;

		case 'getTenantName':
			$TenantName = mysql_fetch_array(mysql_query("SELECT tradename FROM tbltrans_tenants WHERE TenantID = '". $_POST['TenantID'] ."';", $connection));
			echo $TenantName['tradename'];
		break;

		case 'printcomplaint':
			$printcomplaint = mysql_fetch_array(mysql_query("SELECT TradeName, MallID, FloorID, UnitID, Date_Entry, UserID, xdate, Complaint_Code, Complete_Description, TenantID, Complaint_Status,  Time_Received, Time_Resolved, Priority_Status, Complaint_Series_No FROM tblcomplaints WHERE TenantID = '". $_POST['key']."';", $connection));
			$mallname = mysql_fetch_array(mysql_query("SELECT mallname FROM tblref_mall WHERE mallid = '". $printcomplaint[1] ."'; ", $connection));
			$floorname = mysql_fetch_array(mysql_query("SELECT floor FROM tblref_floorsetup WHERE FloorID = '". $printcomplaint[2] ."'; ", $connection));
			$unitname = mysql_fetch_array(mysql_query("SELECT unitname, buildingname FROM tblref_unit WHERE UnitID = '". $printcomplaint[3] ."'; ", $connection));
			$wingname = mysql_fetch_array(mysql_query("SELECT wingID, mallID FROM tblref_wing  WHERE mallid = '". $printcomplaint[1] ."'; ", $connection));
			$username2 = mysql_fetch_array(mysql_query("SELECT CONCAT(firstname, ' ', lastname) FROM tbluser WHERE userid = '". $printcomplaint['UserID'] ."';", $connection));
					?>  
					<style type="text/css">
						#hr{
							background: black !important; padding:2px;
						}
					</style>

					<center> <h2> <b>Complaint Report</b> </h2> </center>
					<table style='width:100%;'>
						<tr>
							<td id='hr'> </td>
						</tr>
					</table><br/>
					<table  style='width: 100%;' cellspacing='0' cellpadding='0'>
						<thead>
							<th style="border: 1px solid black; text-align: center; color: white; padding:3px !important;"> Store Name </th>
							<th style="border: 1px solid black; text-align: center; color: white; padding:5px !important;"> Tenant ID </th>
							<th style="border: 1px solid black; text-align: center; color: white; padding:3px !important;"> Mall Name </th>
							<th style="border: 1px solid black; text-align: center; color: white; padding:3px !important;"> Floor Name </th>
							<th style="border: 1px solid black; text-align: center; color: white; padding:3px !important;"> Wing Name </th>
							<th style="border: 1px solid black; text-align: center; color: white; padding:3px !important;"> Unit Name </th>
							<th style="border: 1px solid black; text-align: center; color: white; padding:5px !important;"> Complaint Date </th>
							<th style="border: 1px solid black; text-align: center; color: white; padding:5px !important;"> Complaint Code </th>
							<th style="border: 1px solid black; text-align: center; color: white; padding:5px !important;"> Complaint Status </th>
							<th style="border: 1px solid black; text-align: center; color: white; padding:5px !important;"> Priority  Status </th>
						</thead>
						<tbody>		
					<?php
					// while($row = mysql_fetch_array($res)){
						?>
						<tr id='<?php echo $row[0]; ?>'>
							<td style="border: 1px solid black; padding:5px;"><?php echo $printcomplaint[0]; ?></td>
							<td style="border: 1px solid black; padding:5px;"><?php echo $printcomplaint[9]; ?></td>
							<td style="border: 1px solid black; padding:5px;"><?php echo $mallname[0]; ?></td>
							<td style="border: 1px solid black; padding:5px;"><?php echo $floorname[0]; ?></td>
							<td style="border: 1px solid black; padding:5px;"><?php echo $wingname[0]; ?></td>
							<td style="border: 1px solid black; padding:5px;"><?php echo $unitname[0]; ?></td>
							<td style="border: 1px solid black; padding:5px;"><?php echo date('Y-m-d', strtotime($printcomplaint[6])); ?></td>
							<td style="border: 1px solid black; padding:5px;"><?php echo $printcomplaint[7]; ?></td>
							<td style="border: 1px solid black; padding:5px;"><?php echo $printcomplaint[10]; ?></td>
							<td style="border: 1px solid black; padding:5px;"><?php echo $printcomplaint[13]; ?></td>
						</tr>
						<?php
					// }
					?></tbody></table><?php
		break;

		case 'AutoConsolidatecomplaint':
			$printcomplaint = mysql_fetch_array(mysql_query("SELECT TradeName, MallID, FloorID, UnitID, Date_Entry, UserID, xdate, Complaint_Code, Complete_Description, TenantID, Complaint_Status,  Time_Received, Time_Resolved, Priority_Status, Complaint_Series_No FROM tblcomplaints WHERE TenantID = '". $_POST['tenant']."';", $connection));
			$mallname = mysql_fetch_array(mysql_query("SELECT mallname FROM tblref_mall WHERE mallid = '". $printcomplaint[1] ."'; ", $connection));
			$floorname = mysql_fetch_array(mysql_query("SELECT floor FROM tblref_floorsetup WHERE FloorID = '". $printcomplaint[2] ."'; ", $connection));
			$unitname = mysql_fetch_array(mysql_query("SELECT unitname, buildingname FROM tblref_unit WHERE UnitID = '". $printcomplaint[3] ."'; ", $connection));
			$wingname = mysql_fetch_array(mysql_query("SELECT wingID, mallID FROM tblref_wing  WHERE mallid = '". $printcomplaint[1] ."'; ", $connection));
			$username2 = mysql_fetch_array(mysql_query("SELECT CONCAT(firstname, ' ', lastname) FROM tbluser WHERE userid = '". $printcomplaint['UserID'] ."';", $connection));
			$data = "Store Name,Tenant ID,Mall Name,Floor Name,Wing Name,Unit Name,Complaint Date,Complaint Code,Complaint Status,Priority Status\r\n";
			// while($rowcomplaint = mysql_fetch_array($printcomplaint)) 
				$data .= str_replace(",","",$printcomplaint[0]).",".$printcomplaint[9].",".$mallname[0].",".$floorname[0].",".$wingname[0].",".$unitname[0].",".date('Y-m-d', strtotime($printcomplaint[6])).",".$printcomplaint[7].",".$printcomplaint[10].",".$printcomplaint[13]."\r\n";
			// }
			$filepath = mysql_fetch_array(mysql_query("SELECT filepath FROM tblsys_setup", $connection));
			$syspath = str_replace("\\", "/", $filepath[0]);
			if (!file_exists($syspath)){
				mkdir($syspath, 0777, true);
			}
			$file = $syspath."/ComplaintReport".date('mdY his').".csv";
			chmod($file, 0777);
			if (file_put_contents($file, $data)){
				create_logs_per_transaction('exported a Complaint Report to excel', 'Complaint Report', '', '', 'EXPORT', '');
				echo 1;
			}else{
				echo 0;
			}
		break;

		case 'getheaderprint':
			$template = mysql_fetch_array(mysql_query("SELECT template FROM tblsys_setup;", $connection));
			if($_POST['tenantid'] == "" && $_POST['mallID'] != ""){
				$row = mysql_fetch_array(mysql_query("SELECT mallname, malladdress, telephone_number, email, mall_image FROM tblref_mall WHERE mallid = '".$_POST["mallID"]."';", $connection));
				$path = "server/mall_image/";
			}else if($_POST['tenantid'] != "" && $_POST['mallID'] == ""){
				$mallid = mysql_fetch_array(mysql_query("SELECT mallID FROM tbltrans_tenants WHERE TenantID = '". $_POST['tenantid'] ."'", $connection));
				$row = mysql_fetch_array(mysql_query("SELECT mallname, malladdress, telephone_number, email, mall_image FROM tblref_mall WHERE mallid = '".$mallid[0]."';", $connection));
				$path = "server/mall_image/";
			}else{
		      	$row = mysql_fetch_array(mysql_query("SELECT corporatename, address, contactnumber, emailaddress, corporatelogo from tblsys_setup;", $connection));
		      	$path = "server/SysLogo/";
			}

			if($row[4] == ""){
                $image = "assets/images/noimage5.png";
            }else{
            	if(!file_exists($path.$row[4])){ 
					$image = "assets/images/noimage5.png";
				}else{
					$image = $path.$row[4];
				}
            }

			if($template[0] == "1"){
				echo "<tr>
				      	<td width='130px;padding:0px !important;'><img src='".$image."' style='height: 130px; width: 150px !important;margin: 10px;'></td>
				      	<td style='padding-top:0px;'>
				      		<p style='padding: 0px; display: block;margin:0px;'><h1>".$row[0]."</h1></p>
				      		<p style='padding: 0px; display: block;margin:0px;'>".$row[1]."</p>
				      		<p style='padding: 0px; display: block;margin:0px;'>".$row[2]."</p>
				      		<p style='padding: 0px; display: block;margin:0px;'>".$row[3]."</p>
				      	</td>
				      </tr>";
			}else{
				echo "<tr>
					  	<td colspan='3' align='center'><img src='".$image."' style='height: 130px; width: 150px !important;margin: 10px;'></td>
					  </tr>
					  <tr>
					  	<td colspan='3' align='center'>
					  		<p style='padding: 0px; display: block;margin:0px;'><h1>".$row[0]."</h1></p>
					  		<p style='padding: 0px; display: block;margin:0px;'>".$row[1]."</p>
					  		<p style='padding: 0px; display: block;margin:0px;'>".$row[2]."</p>
					  		<p style='padding: 0px; display: block;margin:0px;'>".$row[3]."</p>
					  	</td>
					  </tr>";
			}
		break;
		// ruth


		// case 'dbPayment':
		// 	$page = $_POST['page'];
		// 	$limit = ($page-1) * 20;
		// 	if($_POST['MallID'] == '' || $_POST['MallID'] == 'null'){
		// 		$WithMall = getMallAccess("a.mallid", "AND");
		// 	}else{
		// 		$WithMall = "AND a.mallid = '". $_POST['MallID'] ."'";
		// 	}
		// 	$TenantInfo = mysql_fetch_array(mysql_query("SELECT tradename, companyname, mallID, tradeID, tenanttype, revpercent, merchant_code, companyID FROM tbltrans_tenants WHERE TenantID = '". $_POST['key'] ."';", $connection));
		// 	$sql = mysql_fetch_array(mysql_query("SELECT xdate, description, amount, paymenttype, balance, reference FROM tbltransaction WHERE tenantid = '". $_POST['key'] ."' AND paymenttype = '' ORDER BY xdate DESC;",  $connection));
		// 	// echo $sql;
		// 	// while($row = mysql_fetch_array($sql)){
		// 		echo 	"<tr>
		// 					<td>". $TenantInfo['tradename']."</td>
		// 					<td>". date('m/d/Y', strtotime($sql['xdate'])) ."</td>
		// 					<td>". $sql['description'] ."</td>
		// 					<td style='text-align: center;'>". number_format($sql['amount'], "2", ".", ",") ."</td>
		// 					<td style='text-align: right;'>". number_format($sql['paymenttype'], "2", ".", ",") ."</td>
		// 					<td style='text-align: right;'>". number_format($sql['balance'], "2", ".", ",") ."</td>
		// 					<td>". $sql['reference'] ."</td>	
		// 				</tr>";	
		// break;

		case 'fncTSREntries':
				if($_POST["page"] == ""){
	               	$page = 1;
	           	}else{
	               	$page = $_POST["page"];
	           	}
	           	$limit = ($page-1) * 20;
	        	if($_POST['mallid'] == '' || $_POST['mallid'] == 'null'){
					$WithMall = getMallAccess("a.mallid", "AND");
				}else{
					$WithMall = "AND a.mallid = '". $_POST['mallid'] ."'";
				}
	           	if($_POST['ReportType'] == "dbSales"){
	            	$rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(a.id) FROM ". $tblSales[0] ." AS a LEFT JOIN tbltrans_tenants AS b ON a.tenantid = b.TenantID WHERE b.tradename LIKE '%". $_POST['key'] ."%' AND (a.".$tblSales[1]." BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['DateTo'])) ."') ".$WithMall.";", $connection));
	           	}else if($_POST['ReportType'] == "dbHour"){
	            	$rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(a.id) FROM ". $tblHourly[0] ." AS a LEFT JOIN tbltrans_tenants AS b ON a.tenantid = b.TenantID WHERE b.tradename LIKE '%". $_POST['key'] ."%' AND (a.".$tblHourly[1]." BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['DateTo'])) ."') ".$WithMall.";", $connection));
	           	}else if($_POST['ReportType'] == "dbPayment")
          
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

		case "fncTSRPage":
		    $page = $_POST["page"];
		    if($_POST['mallid'] == '' || $_POST['mallid'] == 'null'){
				$WithMall = getMallAccess("a.mallid", "AND");
			}else{
				$WithMall = "AND a.mallid = '". $_POST['mallid'] ."'";
			}
			if($_POST['ReportType'] == "dbSales"){
            	$rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(a.id) FROM ". $tblSales[0] ." AS a LEFT JOIN tbltrans_tenants AS b ON a.tenantid = b.TenantID WHERE b.tradename LIKE '%". $_POST['key'] ."%' AND (a.".$tblSales[1]." BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['DateTo'])) ."') ".$WithMall.";", $connection));
           	}else if($_POST['ReportType'] == "dbHour"){
            	$rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(a.id) FROM ". $tblHourly[0] ." AS a LEFT JOIN tbltrans_tenants AS b ON a.tenantid = b.TenantID WHERE b.tradename LIKE '%". $_POST['key'] ."%' AND (a.".$tblHourly[1]." BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['DateTo'])) ."') ".$WithMall.";", $connection));
           	}else if($_POST['ReportType'] == "dbPayment")
           	
			$rowsperpage = 20;
			$range = 3;
			$totalpages = ceil($rowCount[0] / $rowsperpage);
			if($page > 1 ){
			   	echo "<li style='width:50px !important;' onclick='TSRPagination(1, \"\", \"". $_POST['ReportType'] ."\")'><< First</li>";
			   	$prevpage = $page - 1;
			   	echo "<li style='width:70px !important;' onclick='TSRPagination(". $prevpage .", \"\", \"". $_POST['ReportType'] ."\")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if(($x > 0) && ($x <= $totalpages)){
    			    if($x == $page){
                        echo "<li id='pgTSRList" . $x . "' class='pgNumTSRList active' onclick='TSRPagination(" . $x . ",". $x .", \"". $_POST['ReportType'] ."\")'>" . $x . "</li>";
                    }else{
    			        echo "<li id='pgTSRList" . $x . "' class='pgNumTSRList' onclick='TSRPagination(" . $x . ",". $x .", \"". $_POST['ReportType'] ."\")'>" . $x . "</li>";
                    }
		       	}
		    }
		    if($page < ($totalpages - $range)){
                echo "<li>...</li>";
            }
		    if($page != $totalpages && $rowCount[0] != 0){
		       $nextpage = $page + 1;
		       echo "<li style='width:50px !important;' onclick='TSRPagination(". $nextpage .", ". $nextpage .", \"". $_POST['ReportType'] ."\")'>Next ></li>";
		       echo "<li style='width:50px !important;' onclick='TSRPagination(". $totalpages .", ". $totalpages .", \"". $_POST['ReportType'] ."\")'>Last >></li>";
		    }
		break;

		case 'fncLoadTenantList':
			if($_POST['MallID'] == '' || $_POST['MallID'] == 'null'){
				$WithMall = getMallAccess("a.mallid", "AND");
			}else{
				$WithMall = "AND a.mallid = '". $_POST['MallID'] ."'";
			}
			$res = mysql_query("SELECT a.tradename, a.TenantID, a.CompanyID, c.filename, a.tradeID FROM tbltrans_tenants AS a INNER JOIN tbltrans_tradename AS c ON a.tradeID = c.tradeID WHERE a.tradename LIKE '%". $_POST['key'] ."%' ". $WithMall .";", $connection);
			// echo $res;
			while($row = mysql_fetch_array($res)){
				if($row["filename"] == ""){
					$image = "assets/images/noimage5.png";
				}else{
					if(!file_exists("../../server/company/". $row["CompanyID"] ."/trades/". $row['tradeID'] ."/". $row["filename"])){ 
						$image = "assets/images/noimage5.png";
					}else{
						$image = "server/company/". $row["CompanyID"] ."/trades/". $row['tradeID'] ."/". $row["filename"];
					}
				}

				echo 	"<li class='dd-item dd2-item' style='cursor: pointer;' id='". $row[1] ."'>
                         	<div class='dd2-content'><label style='width:80%;'>". $row['tradename'] ."</label></div>
                     	</li>";
			}
		break;

		
		case 'fncLoadTreeMapData':
			if($_POST['MallID'] == '' || $_POST['MallID'] == 'null'){
				$WithMall = getMallAccess("a.mallid", "AND");
			}else{
				$WithMall = "AND a.mallid = '". $_POST['MallID'] ."'";
			}
			if($_POST['TenantID'] == '' || $_POST['TenantID'] == 'undefined'){
	       		$WithTenant = "";
			}else{
	       		$WithTenant = "a.tenantID = '". $_POST['TenantID'] ."' AND";
			}
			$sql = "SELECT a.TenantID, a.tradename, COALESCE(tot, 0) t FROM tbltrans_tenants a LEFT JOIN (SELECT SUM(". $tblSales[6] .") tot , `tenantID` FROM ". $tblSales[0] ." WHERE YEAR(". $tblSales[1] .") = '". $_POST['GraphYear'] ."' GROUP BY `tenantID`) b ON a.`TenantID` = b.`tenantID` WHERE ". $WithTenant ." (Status = 'Active' OR Status = 'ForEviction' OR Status = 'ForRenewal') ". $WithMall ." HAVING t != 0 ORDER BY tot DESC LIMIT ". $_POST["TreeMapCurrentPage"] ." , 20;";
			$sql2 = "SELECT a.TenantID, a.tradename, COALESCE(tot, 0) t FROM tbltrans_tenants a LEFT JOIN (SELECT SUM(". $tblSales[6] .") tot , `tenantID` FROM ". $tblSales[0] ." WHERE YEAR(". $tblSales[1] .") = '". $_POST['GraphYear'] ."' GROUP BY `tenantID`) b ON a.`TenantID` = b.`tenantID` WHERE ". $WithTenant ." (Status = 'Active' OR Status = 'ForEviction' OR Status = 'ForRenewal') ". $WithMall ." HAVING t != 0 ORDER BY tot DESC;";
			$res = mysql_query($sql, $connection);
			$RowNum = mysql_num_rows(mysql_query($sql2, $connection));
			$RowCount = explode(".", $RowNum / 20);
			while($row = mysql_fetch_array($res)){
				echo "#|". $row[0] ."|".  $row[1] ."|". number_format($row[2], "0", "", "") ."|". $RowCount[0]; 
			}
		break;

		case 'getMonthSales':
			$return_arr = array();
			if($_POST['MallID'] == '' || $_POST['MallID'] == 'null'){
				$WithMall = getMallAccess("mallid", "AND");
			}else{
				$WithMall = " AND mallid = '". $_POST['MallID'] ."'";
			}
			if($_POST['TenantID'] == "" || $_POST['TenantID'] == 'undefined'){
       			$WithTenant = "";
			}else{
       			$WithTenant = "tenantID = '". $_POST['TenantID'] ."' AND";
			}
			$number = cal_days_in_month(CAL_GREGORIAN, $_POST['month'], $_POST['year']);
			for($a = 1; $a <= $number; $a++){
				$row2 = mysql_fetch_array(mysql_query("SELECT SUM(". $tblSales[6] ."), SUM(". $tblSales[7] .") FROM ". $tblSales[0] ." WHERE ". $WithTenant ." YEAR(". $tblSales[1] .") = '". $_POST['year'] ."' AND MONTH(". $tblSales[1] .") = '". $_POST['month'] ."' AND DAY(". $tblSales[1] .") = '". $a ."' ". $WithMall .";", $connection));
				$row_array = floatval($row2[0]);
				array_push($return_arr, $row_array);
			}
			echo json_encode($return_arr);
		break;

		case 'getMonthDiscount':
			$return_arr = array();
			if($_POST['MallID'] == '' || $_POST['MallID'] == 'null'){
				$WithMall = getMallAccess("mallid", "AND");
			}else{
				$WithMall = " AND mallid = '". $_POST['MallID'] ."'";
			}
			if($_POST['TenantID'] == "" || $_POST['TenantID'] == 'undefined'){
       			$WithTenant = "";
			}else{
       			$WithTenant = "AND tenantID = '". $_POST['TenantID'] ."'";
			}
			$number = cal_days_in_month(CAL_GREGORIAN, $_POST['month'], $_POST['year']);
			for($a = 1; $a <= $number; $a++){
				$row2 = mysql_fetch_array(mysql_query("SELECT SUM(". $tblSales[6] ."), SUM(". $tblSales[7] .") FROM ". $tblSales[0] ." WHERE ". $WithTenant ." YEAR(". $tblSales[1] .") = '". $_POST['year'] ."' AND MONTH(". $tblSales[1] .") = '". $_POST['month'] ."' AND DAY(". $tblSales[1] .") = '". $a ."' ". $WithMall .";", $connection));
				$row_array = floatval($row2[1]);
				array_push($return_arr,$row_array);
			}
			echo json_encode($return_arr);
		break;

		case 'getMonthVoid':
			$return_arr = array();
			if($_POST['MallID'] == '' || $_POST['MallID'] == 'null'){
				$WithMall = getMallAccess("mallid", "AND");
			}else{
				$WithMall = " AND mallid = '". $_POST['MallID'] ."'";
			}
			if($_POST['TenantID'] == "" || $_POST['TenantID'] == 'undefined'){
       			$WithTenant = "";
			}else{
       			$WithTenant = "AND tenantID = '". $_POST['TenantID'] ."'";
			}
			$number = cal_days_in_month(CAL_GREGORIAN, $_POST['month'], $_POST['year']);
			for($a = 1; $a <= $number; $a++){
				$row3 = mysql_fetch_array(mysql_query("SELECT SUM(". $tblVoid[5] .") FROM ". $tblVoid[0] ." WHERE ". $WithTenant ." MONTH(". $tblVoid[1] .") = '". $_POST['month'] ."' AND YEAR(". $tblVoid[1] .") = '". $_POST['year'] ."' AND DAY(". $tblVoid[1] .") = '". $a ."' AND ". $WithMall .";", $connection));
				$row_array = floatval($row3[0]);
				array_push($return_arr, $row_array);				
			}
			echo json_encode($return_arr);
		break;

		case 'perhourtbl':
			if($_POST['MallID'] == '' || $_POST['MallID'] == 'null'){
				$WithMall = getMallAccess("mallid", "AND");
			}else{
				$WithMall = " AND mallid = '". $_POST['MallID'] ."'";
			}
			if($_POST['TenantID'] == "" || $_POST['TenantID'] == 'undefined'){
       			$WithTenant = "";
			}else{
       			$WithTenant = "tenantID = '". $_POST['TenantID'] ."' AND";
			}
			$res = mysql_query("SELECT ".$tblHourly[1].", ".$tblHourly[3].", ".$tblHourly[4]." FROM ".$tblHourly[0]." WHERE ". $WithTenant ." YEAR(".$tblHourly[1].") = '". $_POST['year'] ."' AND MONTH(".$tblHourly[1].") = '". $_POST['month'] ."' AND DAY(".$tblHourly[1].") = '". $_POST['dayNum'] ."' ".$WithMall." ORDER BY ".$tblHourly[3]." ASC;", $connection);
			while($row = mysql_fetch_array($res)){
				echo 	"<tr>
							<td>". date('F d, Y', strtotime($row[0])) ."</td>
							<td>". date('h:i A', strtotime($row[1])) ."</td>
							<td style='text-align: right;'>". number_format($row[2], 2, '.', ',') ."</td>
						</tr>";
			}	
		break;

		case 'getHourlySales':
			$return_arr = array();
			if($_POST['MallID'] == '' || $_POST['MallID'] == 'null'){
				$WithMall = getMallAccess("mallid", "AND");
			}else{
				$WithMall = " AND mallid = '". $_POST['MallID'] ."'";
			}
			if($_POST['TenantID'] == "" || $_POST['TenantID'] == 'undefined'){
       			$WithTenant = "";
			}else{
       			$WithTenant = "tenantID = '". $_POST['TenantID'] ."' AND";
			}
			$res = mysql_query("SELECT ". $tblHourly[1] .", ". $tblHourly[3] .", SUM(". $tblHourly[4] .") FROM ". $tblHourly[0] ." WHERE ". $WithTenant ." YEAR(". $tblHourly[1] .") = '". $_POST['year'] ."' AND MONTH(". $tblHourly[1] .") = '". $_POST['month'] ."' AND DAY(". $tblHourly[1] .") = '". $_POST['dayNum'] ."' ". $WithMall ." GROUP BY ". $tblHourly[3] ." ORDER BY ". $tblHourly[3] ." ASC;", $connection);
			while($row = mysql_fetch_array($res)){
				$row_array['name'] = date('g:iA', strtotime($row[1]));
				$row_array['y'] = floatval($row[2]);
				array_push($return_arr,$row_array);
			}
			echo json_encode($return_arr);
		break;

		case 'yearlypie':
			$display_arr = array();
			$return_arr = array();
			$xreturn_arr = array();
			$color[1] = "#FF0000";
			$color[2 ] = "#007ED9";
			$color[3] = "#AA00D9";
			$color[4] = "#D9B800";
			$color[5] = "#00D921";
			$color[6] = "#87FF8F";
			$color[7] = "#FA61FA";
			$color[8] = "#282829";
			$color[9] = "#D60059";
			$color[10] = "#1B5A87";
			$color[11] = "#852056";
			$color[12] = "#C4C4C2";
			$ctr = 0;
			if($_POST['MallID'] == '' || $_POST['MallID'] == 'null'){
				$WithMall = getMallAccess("a.mallid", "AND");
			}else{
				$WithMall = "AND a.mallid = '". $_POST['MallID'] ."'";
			}
			if($_POST['TenantID'] == '' || $_POST['TenantID'] == 'undefined'){
	       		$WithTenant = "";
			}else{
	       		$WithTenant = "a.tenantID = '". $_POST['TenantID'] ."' AND";
			}
			$sql = "SELECT a.tenantID, CONCAT(owner_lastname, ', ', owner_firstname), tradename , COALESCE(tot, 0) t FROM tbltrans_tenants a LEFT JOIN (SELECT SUM(". $tblSales[6] .") tot , `tenantID` FROM ". $tblSales[0] ." WHERE YEAR(". $tblSales[1] .") = '". $_POST['GraphYear'] ."' GROUP BY `tenantID`) b ON a.`TenantID` = b.`tenantID` WHERE ". $WithTenant ." (Status = 'Active' OR Status = 'ForEviction' OR Status = 'ForRenewal') ". $WithMall ." HAVING t != 0 ORDER BY tot DESC LIMIT ". $_POST['page']. " , ". $_POST['limit'] .";";
			$res = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($res)){
				$accronym = "";
				foreach(str_replace('(' , '' ,explode(' ', $row[2])) as $key => $value){
					$accronym .= $value[0];
				}
					$row_array['name'] = $row[2];
					$row_array['accronym'] = $accronym;
					$row_array['value'] = floatval($row[3]);
					$row_array['color'] = $color[$ctr];
					$row_array['id'] = $row[0];
					array_push($return_arr,$row_array);
					array_push($return_arr, array( "name" => $row[2] , "accronym" => $accronym , "parent" => $row[0] , "value" => floatval($row[3]) ) );
					$ctr ++;
			}
			echo json_encode($return_arr)."##".$ctr;
		break;

		case 'fncTotalYearSales':
			if($_POST['MallID'] == '' || $_POST['MallID'] == 'null'){
				$WithMall = getMallAccess("mallid", "AND");
			}else{
				$WithMall = "AND mallid = '". $_POST['MallID'] ."'";
			}
			if($_POST['TenantID'] == "" || $_POST['TenantID'] == 'undefined'){
       			$WithTenant = "";
			}else{
       			$WithTenant = "tenantID = '". $_POST['TenantID'] ."' AND";
			}
			for($a = 1; $a<= 12; $a++){
				$TotalSales = mysql_fetch_array(mysql_query("SELECT SUM(". $tblSales[6] .") FROM ". $tblSales[0] ." WHERE ". $WithTenant ." MONTH(". $tblSales[1] .") = '". $a ."' AND YEAR(". $tblSales[1] .") = '". $_POST['GraphYear'] ."' ". $WithMall .";", $connection));
				$TotalDiscount = mysql_fetch_array(mysql_query("SELECT SUM(". $tblDiscount[5] .") FROM ". $tblDiscount[0] ." WHERE ". $WithTenant ." MONTH(". $tblDiscount[1] .") = '". $a ."' AND YEAR(". $tblDiscount[1] .") = '". $_POST['GraphYear'] ."' ". $WithMall .";", $connection));
				$TotalVoid = mysql_fetch_array(mysql_query("SELECT SUM(". $tblVoid[5] .") FROM ". $tblVoid[0] ." WHERE ". $WithTenant ." MONTH(". $tblVoid[1] .") = '". $a ."' AND YEAR(". $tblVoid[1] .") = '". $_POST['GraphYear'] ."' ". $WithMall .";", $connection));
				echo 	"<div  class='container-fluid hidden-xs hidden-sm parangtr' style='border-bottom: 1px solid #999;'>
							<div class='col-md-2 col-md-offset-2'>". date('F', strtotime('2017-'. $a . '-01')) ."</div>
							<div class='col-md-2 text-right'> ". number_format($TotalSales[0], 2, '.', ',') ."</div>
							<div class='col-md-2 text-right'>". number_format($TotalDiscount[0], 2, '.', ',') ."</div>
							<div class='col-md-2 text-right'>". number_format($TotalVoid[0], 2, '.', ',') ."</div>
						</div>
						<div  class='container-fluid hidden-lg hidden-md parangtr' style='border-bottom: 1px solid #999;'>
							<div class='col-sm-9'>
								<div class='col-sm-12 col-xs-12'><b class='text-primary'>Month: </b> ". date('F', strtotime('2017-'. $a . '-01')) ."</div>
								<div class='col-sm-12 col-xs-12'><b class='text-primary'>Sales:</b> ". number_format($TotalSales[0], 2, '.', ',') ."</div>
								<div class='col-sm-12 col-xs-12'><b class='text-primary'>Discount: </b> ". number_format($TotalDiscount[0], 2, '.', ',') ."</div>
								<div class='col-sm-12 col-xs-12'><b class='text-primary'>Void:</b> ". number_format($TotalVoid[0], 2, '.', ',') ."</div>
							</div>
						</div>";
			}
		break;

		case 'fncMonthPie':
			$return_arr = array();
			$return_arr2 = array();
			$color[1] = "#FF0000";
			$color[2 ] = "#007ED9";
			$color[3] = "#AA00D9";
			$color[4] = "#D9B800";
			$color[5] = "#00D921";
			$color[6] = "#87FF8F";
			$color[7] = "#FA61FA";
			$color[8] = "#282829";
			$color[9] = "#D60059";
			$color[10] = "#1B5A87";
			$color[11] = "#852056";
			$color[12] = "#C4C4C2";
			$ctr = 1;
			if($_POST['MallID'] == '' || $_POST['MallID'] == 'null'){
				$WithMall = getMallAccess("mallid", "AND");
			}else{
				$WithMall = " AND mallid = '". $_POST['MallID'] ."' ";
			}
			if($_POST['TenantID'] == "" || $_POST['TenantID'] == 'undefined'){
				$dbSales = mysql_fetch_array(mysql_query("SELECT SUM(". $tblSales[6] ."), SUM(". $tblSales[7] .") FROM ". $tblSales[0] ." WHERE YEAR(". $tblSales[1] .") = '". $_POST['year'] ."' AND MONTH(". $tblSales[1] .") = '". $_POST['month'] ."' ". $WithMall .";", $connection));
				// $dbVoid = mysql_fetch_array(mysql_query("SELECT SUM(". $tblVoid[5] .") FROM ". $tblVoid[0] ." WHERE MONTH(". $tblVoid[1] .") = '". $_POST['month'] ."' AND YEAR(". $tblVoid[1] .") = '". $_POST['year'] ."' ". $WithMall .";", $connection));
				array_push($num_arr[$ctr], floatval($dbSales[0]));
				$row_array['name'] = "Sales";
				$row_array['y'] = floatval($dbSales[0]);
				$row_array['id'] = "";
				$row_array['color'] = "#3bc0c3";
				$row_array2['name'] = "Discount";
				$row_array2['y'] = floatval($dbSales[1]);
				$row_array2['id'] = "";
				$row_array2['color'] = "#dcdcdc";
				$row_array3['name'] = "Void";
				$row_array3['y'] = floatval($dbVoid[0]);
				$row_array3['id'] = "";
				$row_array3['color'] = "#1a2942";
				array_push($return_arr, $row_array);
				array_push($return_arr, $row_array2);
				array_push($return_arr, $row_array3);
				echo json_encode($return_arr);
			}else{
				$res = mysql_query("SELECT TenantID FROM tbltrans_tenants WHERE TenantID = '". $_POST['TenantID'] ."' ".$WithMall.";", $connection);
				while($row = mysql_fetch_array($res)){
					$dbSales = mysql_fetch_array(mysql_query("SELECT SUM(". $tblSales[6] ."), SUM(". $tblSales[7] .") FROM ". $tblSales[0] ." WHERE YEAR(". $tblSales[1] .") = '". $_POST['year'] ."' AND MONTH(". $tblSales[1] .") = '". $_POST['month'] ."' AND TenantID = '". $row[0] ."';", $connection));
					// $dbVoid = mysql_fetch_array(mysql_query("SELECT SUM(". $tblVoid[5] .") FROM ". $tblVoid[0] ." WHERE MONTH(". $tblVoid[1] .") = '". $_POST['month'] ."' AND YEAR(". $tblVoid[1] .") = '". $_POST['year'] ."' AND TenantID = '". $row[0] ."' ". $WithMall .";", $connection));
					array_push($num_arr[$ctr], floatval($dbSales[0]));
					$row_array['name'] = "Sales";
					$row_array['y'] = floatval($dbSales[0]);
					$row_array['id'] = $row[0];
					$row_array['color'] = "#3bc0c3";
					$row_array2['name'] = "Discount";
					$row_array2['y'] = floatval($dbSales[1]);
					$row_array2['id'] = $row[0];
					$row_array2['color'] = "#dcdcdc";
					$row_array3['name'] = "Void";
					$row_array3['y'] = floatval($dbVoid[0]);
					$row_array3['id'] = $row[0];
					$row_array3['color'] = "#1a2942";
					array_push($return_arr, $row_array);
					array_push($return_arr, $row_array2);
					array_push($return_arr, $row_array3);
					$ctr ++;
				}
				echo json_encode($return_arr);
			}
		break;

		case 'paymenttypeMonthTbl':
			if($_POST['MallID'] == '' || $_POST['MallID'] == 'null'){
				$WithMall = getMallAccess("mallid", "AND");
			}else{
				$WithMall = " AND mallid = '". $_POST['MallID'] ."'";
			}
			if($_POST['TenantID'] == "" || $_POST['TenantID'] == 'undefined'){
       			$WithTenant = "";
			}else{
       			$WithTenant = "AND tenantID = '". $_POST['TenantID'] ."'";
			}
			$res = mysql_query("SELECT ". $tblPayment[6] .", SUM(". $tblPayment[7] .") AS total FROM ". $tblPayment[0] ." WHERE YEAR(". $tblPayment[1] .") = '" . $_POST['year'] ."' AND MONTH(". $tblPayment[1] .") = '". $_POST['month'] ."' ". $WithTenant ." ". $WithMall ." GROUP BY ". $tblPayment[6] ." ORDER BY total DESC;", $connection);
			while($row = mysql_fetch_array($res)){
				echo 	"<tr>
							<td>". $row[0] ."</td>
							<td style='text-align: right;'>". number_format($row[1] , 2 , '.' , ',' ) ."</td>
						</tr>";
			}
		break;

		case 'fncShowTableInfo':
			if($_POST['TenantID'] == "" || $_POST['TenantID'] == 'undefined'){
				$WithTenant = "";
			}else{
				$WithTenant = "AND tenantID = '". $_POST['TenantID'] ."'";
			}
			if($_POST['ReportType'] == "Sales"){
				$res = mysql_query("SELECT ". $tblPayment[3] .", SUM(". $tblPayment[7] .") AS total FROM ". $tblPayment[0] ." WHERE YEAR(". $tblPayment[1] .") = '" . $_POST['year'] ."' AND MONTH(". $tblPayment[1] .") = '". $_POST['month'] ."' ". $WithTenant ." GROUP BY ". $tblPayment[3] ." ORDER BY total DESC;", $connection);
			}else if($_POST['ReportType'] == "Void"){
				$res = mysql_query("SELECT ". $tblVoid[4] .", SUM(". $tblVoid[5] .") AS total FROM ". $tblVoid[0] ." WHERE YEAR(". $tblVoid[1] .") = '". $_POST['year'] ."' AND MONTH(". $tblVoid[1] .") = '". $_POST['month'] ."' ". $WithTenant ." GROUP BY ". $tblVoid[4] ." ORDER BY total DESC;", $connection);
			}
			while($row = mysql_fetch_array($res)){
				echo 	"<tr>
							<td>". $row[0] ."</td>
							<td style='text-align: right;'>". number_format($row[1] , 2 , '.' , ',') ."</td>
						</tr>";
			}
		break;

		case 'fncNumofDays':
			$numday = array();
			$number = cal_days_in_month(CAL_GREGORIAN, $_POST['month'], $_POST['year']);
			for($a = 1; $a<= $number; $a++){
				array_push($numday, floatval($a));
			}
			echo json_encode($numday);
		break;
}
?>