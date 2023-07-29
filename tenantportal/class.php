<?php  
	session_start();
	include('../connect.php');
	$dbsetup = mysql_fetch_array(mysql_query("SELECT dbsetup FROM tblsys_setup WHERE id = '1' ", $connection));
	if($dbsetup[0] == "1"){
		$db_sales = "fdb_sales";
		$db_perhour = "fdb_perhour";
		$sales = ", SUM(fnmGTDlySls)";
		$sales2 = ", SUM(b.fnmGTDlySls)";
		$rawgross = ", SUM(b.fnmGTRwGrss)";
		$transdate = "b.fdtTrnsctn";
		$merchantcode = "b.fvcMrchntCd";
		$dlysls = "fnmGTDlySls";
		$transdate2 = "fdtTrnsctn";
		$PerHourSls = "fnmDlySls";
	}else{
		$db_sales = "sdb_sales";
		$db_perhour = "sdb_perhour";
		$sales = ", SUM(GTDlySls)";
		$sales2 = ", SUM(b.GTDlySls)";
		$rawgross = ", SUM(b.GTRwGrss)";
		$transdate = "b.DteTrnsctn";
		$merchantcode = "b.MrchntCd";
		$dlysls = "GTDlySls";
		$transdate2 = "Trnsctn";
		$PerHourSls = "DlySls";
	}

	switch ($_POST['form']) {
		case 'getdata':
			$return_arr = array();
			for($a = 1; $a <= 12; $a++){

				$sql = "SELECT SUM(".$dlysls.") FROM ".$db_sales." WHERE TenantID = '". $_POST['TenantID'] ."' AND YEAR(". $transdate2 .") = '". date('Y') ."' AND MONTH(". $transdate2 .") = '". $a ."'";
				$row = mysql_fetch_array(mysql_query($sql, $connection));
				$row_array['name'] = date('F', strtotime(date('Y')."-".$a."-01"));
				$row_array['y'] = floatval($row[0]);
				$row_array['drilldown'] = date('F', strtotime(date('Y')."-".$a."-01"));
				array_push($return_arr,$row_array);

			}
			echo json_encode($return_arr);
		break;

		case 'getMonthlyDD':
			$return_arr = array();
			for($month = 1; $month <= 12; $month++){
				$name_arr = array();
				for($day =1; $day <= date('t', strtotime(date('Y')."-".$month."-01")); $day++){
					$arr_day = array();
					$row_array['name'] = date('F', strtotime(date('Y')."-".$month."-".$day));
					$row_array['id'] = date('F', strtotime(date('Y')."-".$month."-".$day));

					$row = mysql_fetch_array(mysql_query("SELECT ".$dlysls." FROM ".$db_sales." WHERE TenantID = '". $_POST['TenantID'] ."' AND ". $transdate2 ." = '". date('Y-m-d', strtotime(date('Y')."-".$month."-".$day)) ."' ", $connection));

					$row_array2['name'] = date('d', strtotime(date('Y')."-".$month."-".$day));
					$row_array2['y'] = floatval($row[0]);

					array_push($name_arr,$row_array2);
				}
					$row_array['data'] = $name_arr;
					array_push($return_arr, $row_array);
			}
			echo json_encode($return_arr);
		break;

		case 'TenantInfo':
			$TenantInfo = mysql_fetch_array(mysql_query("SELECT a.TenantID, a.companyname, a.merchant_code, b.mallname, a.unitname, a.companyID, c.filename, a.tradeID FROM tbltrans_tenants AS a INNER JOIN tblref_mall AS b ON a.mallID = b.mallid INNER JOIN tbltrans_tradename AS c ON a.tradeID = c.tradeID WHERE a.TenantID = '". $_POST['TenantID'] ."'", $connection));
			if($TenantInfo[6] == ""){
				$image = "assets/images/noimage5.png";
			}else{
				if(!file_exists("../../Mall_Attachments/company/". $TenantInfo["companyID"] ."/trades/". $TenantInfo['tradeID'] ."/". $TenantInfo[6])){ 
					$image = "assets/images/noimage5.png";
				}else{
					$image = "../Mall_Attachments/company/". $TenantInfo["companyID"] ."/trades/". $TenantInfo['tradeID'] ."/". $TenantInfo[6];
				}
			}

			echo $TenantInfo['companyname'] . "|" . $TenantInfo['TenantID'] . "|" . $TenantInfo['merchant_code'] . "|" . $TenantInfo['mallname'] . "|" . $TenantInfo['unitname'] . "|" . $image;
		break;

		case 'showpendingcomplaints':
			$complaint = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM tblcomplaints WHERE TenantID = '". $_POST['TenantID'] ."'", $connection));
			echo $complaint[0];
		break;

		case 'showpendingworkorder':
			$workorder = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM tblmaintenance_workorder WHERE TenantID = '". $_POST['TenantID'] ."'", $connection));
			echo $workorder[0];
		break;

		case 'showpenalty':
			$penalty = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM tbltransaction WHERE TenantID = '". $_POST['TenantID'] ."' AND isPenalty = '1'", $connection));
			echo $penalty[0];
		break;

		case 'csvfolders':
				$tenant = mysql_fetch_array(mysql_query("SELECT merchant_code, mallid FROM tbltrans_tenants WHERE TenantID = '". $_POST['TenantID'] ."'", $connection));
				$filepath = mysql_fetch_array(mysql_query("SELECT filepath FROM tblsys_setup", $connection));
				$syspath = str_replace("\\", "/", $filepath[0]);

				echo "<li class='csvlist'><i class='fa fa-user green' style='color: #666633;'></i>&nbsp;&nbsp;".$tenant['merchant_code'];
					echo "<ul>";

						$sql = "SELECT sales, discount, void_refund, salesperhour, paymenttype, reportDate FROM db_syncfilestat WHERE TenantID = '". $_POST['TenantID'] ."' ORDER BY reportDate ASC";
						$res = mysql_query($sql, $connection);
						while($row = mysql_fetch_array($res)){

							echo "<li class='csvlist clickcsvlist'><i class='fa fa-folder-open' style='color: #ffcc66;'></i>&nbsp;&nbsp;".date('F d, Y', strtotime($row['reportDate']));
								echo "<ul>";

									if($row[1] == "1"){
										echo "<li class='csvlist'><i class='fa fa-file-excel-o green'></i>&nbsp;&nbsp;".$tenant[0].date('n', strtotime($row[5])).date('j', strtotime($row[5])).date('y', strtotime($row[5]))."D.csv</li>";
									}else{
										echo "<li class='csvlist'><i class='fa fa-file-excel-o red'></i>&nbsp;&nbsp;".$tenant[0].date('n', strtotime($row[5])).date('j', strtotime($row[5])).date('y', strtotime($row[5]))."D.csv</li>";
									}

									if($row[3] == "1"){
										echo "<li class='csvlist'><i class='fa fa-file-excel-o green'></i>&nbsp;&nbsp;".$tenant[0].date('n', strtotime($row[5])).date('j', strtotime($row[5])).date('y', strtotime($row[5]))."H.csv</li>";
									}else{
										echo "<li class='csvlist'><i class='fa fa-file-excel-o red'></i>&nbsp;&nbsp;".$tenant[0].date('n', strtotime($row[5])).date('j', strtotime($row[5])).date('y', strtotime($row[5]))."H.csv</li>";
									}

									if($row[4] == "1"){
										echo "<li class='csvlist'><i class='fa fa-file-excel-o green'></i>&nbsp;&nbsp;".$tenant[0].date('n', strtotime($row[5])).date('j', strtotime($row[5])).date('y', strtotime($row[5]))."P.csv</li>";
									}else{
										echo "<li class='csvlist'><i class='fa fa-file-excel-o red'></i>&nbsp;&nbsp;".$tenant[0].date('n', strtotime($row[5])).date('j', strtotime($row[5])).date('y', strtotime($row[5]))."P.csv</li>";
									}

									if($row[2] == "1"){
										echo "<li class='csvlist'><i class='fa fa-file-excel-o green'></i>&nbsp;&nbsp;".$tenant[0].date('n', strtotime($row[5])).date('j', strtotime($row[5])).date('y', strtotime($row[5]))."R.csv</li>";
									}else{
										echo "<li class='csvlist'><i class='fa fa-file-excel-o red'></i>&nbsp;&nbsp;".$tenant[0].date('n', strtotime($row[5])).date('j', strtotime($row[5])).date('y', strtotime($row[5]))."R.csv</li>";
									}

									if($row[0] == "1"){
										echo "<li class='csvlist'><i class='fa fa-file-excel-o green'></i>&nbsp;&nbsp;".$tenant[0].date('n', strtotime($row[5])).date('j', strtotime($row[5])).date('y', strtotime($row[5]))."S.csv</li>";
									}else{
										echo "<li class='csvlist'><i class='fa fa-file-excel-o red'></i>&nbsp;&nbsp;".$tenant[0].date('n', strtotime($row[5])).date('j', strtotime($row[5])).date('y', strtotime($row[5]))."S.csv</li>";
									}

								echo "</ul>";
							echo "</li>";
						}

					echo "</ul>";
				echo "</li>";
		break;

		case 'tbltptenantlist':
			$res = mysql_query("SELECT a.tradename, a.TenantID, a.CompanyID, c.filename, a.tradeID FROM tbltrans_tenants AS a INNER JOIN tbltrans_tradename AS c ON a.tradeID = c.tradeID WHERE a.tradename LIKE '%". $_POST['key'] ."%' AND (a.Status = 'Active' OR a.Status = 'ForEviction' OR a.Status = 'ForRenewal') AND a.ustatus = 'Occupied' ". getMallAccess("a.mallID", "AND") ."", $connection);
			while($row = mysql_fetch_array($res)){
				if($row["filename"] == ""){
					$image = "assets/images/noimage5.png";
				}else{
					if(!file_exists("../../Mall_Attachments/company/".$row["CompanyID"]."/trades/".$row['tradeID']."/".$row["filename"])){ 
						$image = "assets/images/noimage5.png";
					}else{
						$image = "../Mall_Attachments/company/".$row["CompanyID"]."/trades/".$row['tradeID']."/".$row["filename"];
					}
				}

				// echo "<li class='dd-item dd2-item' style='cursor: pointer;' onclick='loadinfo(\"". $row['TenantID'] ."\");'>
				// MODIFIED BY PETER - REMOVED THE ONCLICK FUNCTION TO ENABLE EACH FUNCTION FOR THE SELECTION OF TENANT
				// SEPTEMBER 8, 2019
				echo 	"<li class='dd-item dd2-item' style='cursor: pointer;' id='". $row['TenantID'] ."'>
                         	<div class='dd-handle dd2-handle' style='height:100%;'>
                             	<img src='".$image."' style='height:85%;width:85%;margin-bottom:3px !important;margin-top:3px !important;'>
                         	</div>
                         	<div class='dd2-content'><label style='width:80%;'>".$row['tradename']."</label></div>
                     	</li>";
			}
		break;

		case 'ConsolidateCSV':
			$StartDate = date('Y-m-d', strtotime('2017-'.$_POST['Month'].'-01'));
			$LastDay = date('t', strtotime($StartDate));
			$EndDate = date('Y-m-d', strtotime('2017-'.$_POST['Month'].'-'.$LastDay));
			$TenantInfo = " SELECT a.Contract_NumSAP, a.tradename, a.Company_CodeSAP, ".$rawgross." FROM tbltrans_tenants AS a INNER JOIN ".$db_sales." AS b ON a.TenantID = b.tenantid WHERE ".$transdate." BETWEEN '". $StartDate ."' AND '". $EndDate ."' ";
			$resTenantInfo = mysql_query($TenantInfo, $connection);
			while($rowTenantInfo = mysql_fetch_array($resTenantInfo)){
				echo 	"
							<tr>
								<td>".$rowTenantInfo[0]."</td>
								<td>".$rowTenantInfo[1]."</td>
								<td>".$rowTenantInfo[2]."</td>
								<td>".date('m/d/Y', strtotime($StartDate))."</td>
								<td>".date('m/d/Y', strtotime($EndDate))."</td>
								<td>".$rowTenantInfo[3]."</td>
							</tr>
						";
			}
			echo "|"."BBWM_Sales_".date('mdY', strtotime($StartDate))."_".date('mdY', strtotime($EndDate)).".csv";
		break;

		case 'DisableFields':
			$Stat = mysql_fetch_array(mysql_query("SELECT sales, discount, void_refund, salesperhour, paymenttype FROM db_syncfilestat WHERE reportDate = '". date('Y-m-d', strtotime($_POST['TargetDate'])) ."' AND tenantID = '". $_POST['TenantID'] ."'", $connection));
			echo $Stat['discount'] . "|" . $Stat['salesperhour'] . "|" . $Stat['paymenttype'] . "|" . $Stat['void_refund'] . "|" . $Stat['sales'];
		break;

		case 'generateSRDate':
			$pgCount = $_POST['pgCount'];

			$dateStarts = 0;
			if ( $pgCount == 0 ) {
				$dateStarts = 0;
			} else {
				$dateStarts = $pgCount * 10;
			}
			for ( $a = 1; $a <= 10; $a++ ) {
				$newdate =  date('Y-m-d', strtotime( $_POST['dateFrom'] . '+' . $dateStarts . ' day' ));
				$newdate2 = strtotime($newdate);
				$endDatez = strtotime($_POST['dateTo']);

				if ( $endDatez >= $newdate2 ) {
					$sql = " SELECT id, tenantid, fnmGTDlySls FROM fdb_sales WHERE fdtTrnsctn = '". $newdate ."' AND tenantid = '". $_POST['tenantid'] ."'; ";
					$res = mysql_query($sql, $connection);
					$row = mysql_fetch_array($res);

					if ( $row[0] != "" ) {
						?>
							<tr id="<?php echo $row[0]; ?>">
								<td><?php echo date('m/d/Y', strtotime($newdate)); ?></td>
								<td style="padding: 3px !important"><input maxlength="15" type="text" class="form-control numberslang" value="<?php echo number_format($row[2], 2); ?>"></td>
							</tr>
						<?php
					} else {
						?>
							<tr>
								<td><?php echo date('m/d/Y', strtotime($newdate)) ?></td>
								<td style="padding: 3px !important"><input maxlength="15" type="text" class="form-control numberslang" value=""></td>
							</tr>
						<?php
					}
				} else {
					?>
						<tr>
							<td></td>
							<td style="padding: 3px !important; height: 41px;">&nbsp;</td>
						</tr>
					<?php
				}

				$dateStarts++;
			}
		break;

		case 'generateSRDate_':
			$date1 = date_create(date('Y-m-d', strtotime($_POST['dateFrom'])));
			$date2 = date_create(date('Y-m-d', strtotime($_POST['dateTo'])));

			$diff = date_diff($date1, $date2);

			$diff2 = $diff->format("%a");

			$dateStarts = 0;
			for ( $a = 1; $a <= 20; $a++ ) {
				$newdate =  date('Y-m-d', strtotime( $_POST['dateFrom'] . '+' . $a . ' day' ));

				$sql = " SELECT id, tenantid, fnmGTDlySls FROM fdb_sales WHERE fdtTrnsctn = '". $newdate ."'; ";
				$res = mysql_query($sql, $connection);
				$row = mysql_fetch_array($res);

				if ( $row[0] != "" ) {
					?>
						<tr id="<?php echo $row[0]; ?>">
							<td><?php echo date('m/d/Y', strtotime($newdate)); ?></td>
							<td style="padding: 3px !important"><input maxlength="15" type="text" class="form-control numberslang" value="<?php echo number_format($row[2], 2); ?>"></td>
						</tr>
					<?php
				} else {
					?>
						<tr>
							<td><?php echo date('m/d/Y', strtotime($newdate)) ?></td>
							<td style="padding: 3px !important"><input maxlength="15" type="text" class="form-control numberslang" value=""></td>
						</tr>
					<?php
				}
			}
		break;

		case 'generateSalesPage':
			$Days = (strtotime($_POST["dateTo"]) - strtotime($_POST["dateFrom"])) / (60 * 60 * 24) + 1;
			$totalPage = ceil($Days / 10);
			$pano = explode(".", $totalPage);
			$page = $_POST['pgCount'] + 1;
			$range = 1;
			if($_POST['pgCount'] > 0){
				?>
					<li onclick="generateSRDate('0');"><< First</li>
					<li onclick="generateSRDate('<?php echo $_POST['pgCount'] - 1; ?>');">< Prev</li>
				<?php
			}

			for($i = ($page - $range); $i <= (($page + $range) + 1); $i++){
			   if(($i > 0) && ($i <= $totalPage)){
					if($i == $page){
						?>
							<li id="pgcomplaints<?php echo $i; ?>" class='pgnumpcomplaints active' onclick="generateSRDate('<?php echo $i - 1; ?>')"><?php echo $i; ?></li>
						<?php
					}else{
						?>
							<li id='pgcomplaints<?php echo $i; ?>' class='pgnumpcomplaints' onclick="generateSRDate('<?php echo $i - 1; ?>')"><?php echo $i; ?></li>
						<?php
					}
				}
			}
			if($page < ($totalPage - $range)){
				echo "<li>...</li>";
			}

			if(($_POST['pgCount'] >= 0) && (($_POST['pgCount'] + 1) != $totalPage )){
				?>
					<li onclick="generateSRDate('<?php echo $_POST['pgCount'] + 1; ?>');">Next  ></li>
					<li onclick="generateSRDate('<?php echo $totalPage - 1; ?>');">Last >></li>
				<?php
			}
		break;

		case 'getDates':
			echo date('m/d/Y', strtotime(getsysdate()));
		break;

		case 'saveSalesReport':
			$TenantInfo = mysql_fetch_array(mysql_query("SELECT a.TenantID, a.companyname, a.merchant_code, b.mallid, b.mallname, a.unitname, a.companyID, c.filename, a.tradeID FROM tbltrans_tenants AS a INNER JOIN tblref_mall AS b ON a.mallID = b.mallid INNER JOIN tbltrans_tradename AS c ON a.tradeID = c.tradeID WHERE a.TenantID = '". $_POST['tenantid'] ."'", $connection));
			if ( $_POST['id'] == "" ) {
				$sql = " INSERT INTO fdb_sales SET mallid = '" . $TenantInfo[3] . "', tenantid = '". $_POST['tenantid'] ."', fdtTrnsctn = '". date('Y-m-d', strtotime($_POST['selectedDate'])) ."', fvcMrchntCd = '". $TenantInfo[2] ."', fvcMrcntDsc = '". $TenantInfo[1] ."', fnmGTDlySls = '". $_POST['amt'] ."'; ";
				$res = mysql_query($sql, $connection);
			} else {
				$sql = " UPDATE fdb_sales SET mallid = '" . $TenantInfo[3] . "', tenantid = '". $_POST['tenantid'] ."', fdtTrnsctn = '". date('Y-m-d', strtotime($_POST['selectedDate'])) ."', fvcMrchntCd = '". $TenantInfo[2] ."', fvcMrcntDsc = '". $TenantInfo[1] ."', fnmGTDlySls = '". $_POST['amt'] ."' WHERE id = '". $_POST['id'] ."'; ";
				$res = mysql_query($sql, $connection);
			}

			if ( $res == true ) {
				echo 1;
			}
		break;

		case 'getTotalSales':
			$sql = " SELECT SUM(fnmGTDlySls) totSales FROM fdb_sales WHERE tenantid = '". $_POST['tenantid'] ."' AND (fdtTrnsctn BETWEEN '". date('Y-m-d', strtotime($_POST['dateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['dateTo'])) ."'); ";
			$res = mysql_query($sql, $connection);
			$row = mysql_fetch_array($res);

			echo number_format($row[0], 2);
		break;
	}
?>