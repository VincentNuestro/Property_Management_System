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
		case 'dbSales':
			$page = $_POST['page'];
			$limit = ($page-1) * 20;
			if($_POST['MallID'] == '' || $_POST['MallID'] == 'null'){
				$WithMall = getMallAccess("a.mallid", "AND");
			}else{
				$WithMall = "AND a.mallid = '". $_POST['MallID'] ."'";
			}
			$sql = "SELECT b.tradename, a.". $tblSales[1] .", a.". $tblSales[4] .", a.". $tblSales[5] .", a.". $tblSales[6] .", a.". $tblSales[7] .", a.". $tblSales[8] .", a.". $tblSales[9] .", a.". $tblSales[10] .",a.". $tblSales[11] .", a.". $tblSales[12] .", a.". $tblSales[13] .", a.". $tblSales[14] .", a.". $tblSales[15] .", a.". $tblSales[16] .", a.". $tblSales[17] .", a.". $tblSales[18] .", a.". $tblSales[19] .", a.". $tblSales[22] .", a.". $tblSales[23] .", a.". $tblSales[24] .", a.". $tblSales[25] .",  a.". $tblSales[26] .", a.". $tblSales[27] .", a.". $tblSales[28] .", a.". $tblSales[29] .", a.". $tblSales[31] .", a.". $tblSales[32] .", a.". $tblSales[33] ." FROM ". $tblSales[0] ." AS a LEFT JOIN tbltrans_tenants AS b ON a.tenantid = b.TenantID WHERE b.tradename LIKE '%". $_POST['key'] ."%' AND (a.". $tblSales[1] ." BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['DateTo'])) ."') ". $WithMall ." GROUP BY a.fdtTrnsctn ORDER BY ". $_POST['DailySalesSortBy'] ." ". $_POST['DailySalesSortType'] ." LIMIT ". $limit .",20;";
			// echo $sql;
			$res = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($res)){
				echo 	"<tr>
							<td style='white-space: nowrap;'>". $row[0] ."</td>
							<td style='white-space: nowrap;'>". date("m/d/Y", strtotime($row[1])) ."</td>
							<td style='white-space: nowrap;text-align: right;'>". number_format($row[2], 2, ".", ",") ."</td>
							<td style='white-space: nowrap;text-align: right;'>". number_format($row[3], 2, ".", ",") ."</td>
							<td style='white-space: nowrap;text-align: right;'>". number_format($row[4], 2, ".", ",") ."</td>
							<td style='white-space: nowrap;text-align: right;'>". number_format($row[5], 2, ".", ",") ."</td>
							<td style='white-space: nowrap;text-align: right;'>". number_format($row[6], 2, ".", ",") ."</td>
							<td style='white-space: nowrap;text-align: right;'>". number_format($row[7], 2, ".", ",") ."</td>
							<td style='white-space: nowrap;text-align: right;'>". number_format($row[8], 2, ".", ",") ."</td>
							<td style='white-space: nowrap;text-align: right;'>". number_format($row[9], 2, ".", ",") ."</td>
							<td style='white-space: nowrap;text-align: right;'>". number_format($row[10], 2, ".", ",") ."</td>
							<td style='white-space: nowrap;text-align: right;'>". number_format($row[11], 2, ".", ",") ."</td>
							<td style='white-space: nowrap;text-align: right;'>". number_format($row[12], 2, ".", ",") ."</td>
							<td style='white-space: nowrap;text-align: right;'>". number_format($row[13], 2, ".", ",") ."</td>
							<td style='white-space: nowrap;text-align: right;'>". number_format($row[14], 2, ".", ",") ."</td>
							<td style='white-space: nowrap;text-align: right;'>". number_format($row[15], 2, ".", ",") ."</td>
							<td style='white-space: nowrap;text-align: right;'>". number_format($row[16], 2, ".", ",") ."</td>
							<td style='white-space: nowrap;text-align: right;'>". number_format($row[17], 2, ".", ",") ."</td>
							<td style='white-space: nowrap;text-align: right;'>". number_format($row[18], 2, ".", ",") ."</td>
							<td style='white-space: nowrap;text-align: right;'>". number_format($row[19], 2, ".", ",") ."</td>
							<td style='white-space: nowrap;text-align: right;'>". number_format($row[20], 2, ".", ",") ."</td>
							<td style='white-space: nowrap;text-align: right;'>". number_format($row[21], 2, ".", ",") ."</td>
							<td style='white-space: nowrap;text-align: right;'>". number_format($row[22], 2, ".", ",") ."</td>
							<td style='white-space: nowrap;text-align: right;'>". number_format($row[23], 2, ".", ",") ."</td>
							<td style='white-space: nowrap;text-align: right;'>". number_format($row[24], 2, ".", ",") ."</td>
							<td style='white-space: nowrap;text-align: right;'>". number_format($row[25], 2, ".", ",") ."</td>
							<td style='white-space: nowrap;text-align: right;'>". number_format($row[26], 2, ".", ",") ."</td>
							<td style='white-space: nowrap;text-align: right;'>". number_format($row[27], 2, ".", ",") ."</td>
							<td style='white-space: nowrap;text-align: right;'>". number_format($row[28], 2, ".", ",") ."</td>
						</tr>";
			}
		break;

		case 'printtenantdailysales': 
			$res = mysql_query("SELECT b.tradename, a.". $tblSales[1] .", a.". $tblSales[4] .", a.". $tblSales[5] .", a.". $tblSales[6] .", a.". $tblSales[7] .", a.". $tblSales[8] .", a.". $tblSales[9] .", a.". $tblSales[10] .",a.". $tblSales[11] .", a.". $tblSales[12] .", a.". $tblSales[13] .", a.". $tblSales[14] .", a.". $tblSales[15] .", a.". $tblSales[16] .", a.". $tblSales[17] .", a.". $tblSales[18] .", a.". $tblSales[19] .", a.". $tblSales[22] .", a.". $tblSales[23] .", a.". $tblSales[24] .", a.". $tblSales[25] .",  a.". $tblSales[26] .", a.". $tblSales[27] .", a.". $tblSales[28] .", a.". $tblSales[29] .", a.". $tblSales[31] .", a.". $tblSales[32] .", a.". $tblSales[33] ." FROM ". $tblSales[0] ." AS a LEFT JOIN tbltrans_tenants AS b ON a.tenantid = b.TenantID WHERE b.tradename LIKE '%". $_POST['key'] ."%' AND (a.". $tblSales[1] ." BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['DateTo'])) ."') ". $WithMall ." GROUP BY ". $tblSales[1] ." ORDER BY ". $tblSales[1] . ";", $connection);
				?>  
				<style type="text/css">
					#hr{
						background: black !important; padding:2px;
					}
				</style>

				<center> <h2> <b>Daily Sales Report</b> </h2> </center>
				<table style='width:100%;'>
					<tr>
						<td id='hr'> </td>
					</tr>
				</table><br/>
				<table  style='width: 100%;' cellspacing='0' cellpadding='0'>
					<thead>
						<th style="border: 1px solid black; text-align: center; color: white; padding:3px !important;"> Store Name </th>
						<th style="border: 1px solid black; text-align: center; color: white; padding:5px !important;"> Transaction Date </th>
						<th style="border: 1px solid black; text-align: center; color: white; padding:3px !important;"> Old Grand Total </th>
						<th style="border: 1px solid black; text-align: center; color: white; padding:3px !important;"> New Grand Total </th>
						<th style="border: 1px solid black; text-align: center; color: white; padding:3px !important;"> Daily Sales </th>
						<th style="border: 1px solid black; text-align: center; color: white; padding:3px !important;"> Grand Total Discount </th>
						<th style="border: 1px solid black; text-align: center; color: white; padding:5px !important;"> Total Discount - SC </th>
						<th style="border: 1px solid black; text-align: center; color: white; padding:5px !important;"> Total Discount - PWD </th>
						<th style="border: 1px solid black; text-align: center; color: white; padding:5px !important;"> Total Discount - GPC </th>
						<th style="border: 1px solid black; text-align: center; color: white; padding:5px !important;"> Total Discount - VIP </th>
						<th style="border: 1px solid black; text-align: center; color: white; padding:5px !important;"> Total Discount - EMP </th>
						<th style="border: 1px solid black; text-align: center; color: white; padding:5px !important;"> Total Discount - REG </th>
						<th style="border: 1px solid black; text-align: center; color: white; padding:5px !important;"> Total Discount - OTH </th>
						<th style="border: 1px solid black; text-align: center; color: white; padding:5px !important;"> Total Refund </th>
						<th style="border: 1px solid black; text-align: center; color: white; padding:5px !important;"> Total Cancelled </th>
						<th style="border: 1px solid black; text-align: center; color: white; padding:5px !important;"> Total Sales Vat </th>
						<th style="border: 1px solid black; text-align: center; color: white; padding:5px !important;"> Total Sales Vat Exclusive </th>
						<th style="border: 1px solid black; text-align: center; color: white; padding:5px !important;"> Document Count </th>
						<th style="border: 1px solid black; text-align: center; color: white; padding:5px !important;"> Customer Count </th>
						<th style="border: 1px solid black; text-align: center; color: white; padding:5px !important;"> Senior Citizen Count </th>
						<th style="border: 1px solid black; text-align: center; color: white; padding:5px !important;"> Local Tax </th>
						<th style="border: 1px solid black; text-align: center; color: white; padding:5px !important;"> Service Charge </th>
						<th style="border: 1px solid black; text-align: center; color: white; padding:5px !important;"> Total Sales Non-Vat </th>
						<th style="border: 1px solid black; text-align: center; color: white; padding:5px !important;"> Raw Gross </th>
						<th style="border: 1px solid black; text-align: center; color: white; padding:5px !important;"> Daily Local Tax </th>
						<th style="border: 1px solid black; text-align: center; color: white; padding:5px !important;"> Total Payment Cash </th>
						<th style="border: 1px solid black; text-align: center; color: white; padding:5px !important;"> Total Payment Card </th>
						<th style="border: 1px solid black; text-align: center; color: white; padding:5px !important;"> Total Payment Others </th>
					</thead>
					<tbody>
						
				<?php
				while($row = mysql_fetch_array($res)){
					?>
					<tr id='<?php echo $row[0]; ?>'>
						<td style="border: 1px solid black; padding:5px;"><?php echo $row[0]; ?></td>
						<td style="border: 1px solid black; padding:5px;"><?php echo $row[1]; ?></td>
						<td style="border: 1px solid black; padding:5px;"><?php echo $row[2]; ?></td>
						<td style="border: 1px solid black; padding:5px;"><?php echo $row[3]; ?></td>
						<td style="border: 1px solid black; padding:5px;"><?php echo $row[4]; ?></td>
						<td style="border: 1px solid black; padding:5px;"><?php echo $row[5]; ?></td>
						<td style="border: 1px solid black; padding:5px;"><?php echo $row[6]; ?></td>
						<td style="border: 1px solid black; padding:5px;"><?php echo $row[7]; ?></td>
						<td style="border: 1px solid black; padding:5px;"><?php echo $row[8]; ?></td>
						<td style="border: 1px solid black; padding:5px;"><?php echo $row[9]; ?></td>
						<td style="border: 1px solid black; padding:5px;"><?php echo $row[10]; ?></td>
						<td style="border: 1px solid black; padding:5px;"><?php echo $row[11]; ?></td>
						<td style="border: 1px solid black; padding:5px;"><?php echo $row[12]; ?></td>
						<td style="border: 1px solid black; padding:5px;"><?php echo $row[13]; ?></td>
						<td style="border: 1px solid black; padding:5px;"><?php echo $row[14]; ?></td>
						<td style="border: 1px solid black; padding:5px;"><?php echo $row[15]; ?></td>
						<td style="border: 1px solid black; padding:5px;"><?php echo $row[16]; ?></td>
						<td style="border: 1px solid black; padding:5px;"><?php echo $row[17]; ?></td>
						<td style="border: 1px solid black; padding:5px;"><?php echo $row[18]; ?></td>
						<td style="border: 1px solid black; padding:5px;"><?php echo $row[19]; ?></td>
						<td style="border: 1px solid black; padding:5px;"><?php echo $row[20]; ?></td>
						<td style="border: 1px solid black; padding:5px;"><?php echo $row[21]; ?></td>
						<td style="border: 1px solid black; padding:5px;"><?php echo $row[22]; ?></td>
						<td style="border: 1px solid black; padding:5px;"><?php echo $row[23]; ?></td>
						<td style="border: 1px solid black; padding:5px;"><?php echo $row[24]; ?></td>
						<td style="border: 1px solid black; padding:5px;"><?php echo $row[25]; ?></td>
						<td style="border: 1px solid black; padding:5px;"><?php echo $row[26]; ?></td>
						<td style="border: 1px solid black; padding:5px;"><?php echo $row[27]; ?></td>
					</tr>
					<?php
				}
				?></tbody></table><?php
		break;

		case 'AutoConsolidatedailysales':
			$dailysales = "SELECT b.tradename, a.fdtTrnsctn, a.fnmGrndTtlOld, a.fnmGrndTtlNew, a.fnmGTDlySls, a.fnmGTDscnt, a.fnmGTDscntSNR, a.fnmGTDscntPWD, a.fnmGTDscntGPC, a.fnmGTDscntVIP, a.fnmGTDscntEMP, a.fnmGTDscntREG, a.fnmGTDscntOTH, a.fnmGTRfnd, a.fnmGTCncld, a.fnmGTSlsVAT, a.fnmGTVATSlsInclsv, a.fnmGTVATSlsExclsv, a.fnmGTCntDcmnt, a.fnmGTCntCstmr, a.fnmGTCntSnrCtzn, a.fnmGTLclTax, a.fnmGTSrvcChrg, a.fnmGTSlsNonVat, a.fnmGTRwGrss, a.fnmGTLclTaxDly, a.fnmGTPymntCSH, a.fnmGTPymntCRD, a.fnmGTPymntOTH FROM fdb_sales AS a LEFT JOIN tbltrans_tenants AS b ON a.tenantid = b.TenantID WHERE b.tradename LIKE '%". $_POST['tenant']."%' AND a.fdtTrnsctn BETWEEN '".date("Y-m-d", strtotime($_POST['datefrom']))."' AND '".date("Y-m-d", strtotime($_POST['dateto']))."' AND a.mallid = '".$_POST['mallid']."' GROUP BY a.fdtTrnsctn ORDER BY ". $_POST['DailySalesSortBy'] ." ". $_POST['DailySalesSortType'] .";";
			$condailysales = mysql_query($dailysales, $connection);
			$data = "Store Name,Transaction Date,Old Grand Total,New Grand Total,Daily Sales,Grand Total Discount,Total Discount-SC,Total Discount-PWD,Total Discount-GPC,Total Discount-VIP,Total Discount-EMP,Total Discount-REG,Total Discount-OTH,Total Refund,Total Cancelled,Total Sales Vat,Total Sales Vat Inclusive,Total Sales Vat Exclusive,Document Count,Customer Count,Senior Citizen Count,Local Tax,Service Charge,Total Sales Non-Vat,Raw Gross,Daily Local Tax,Total Payment Cash,Total Payment Card,Total Payment Others\r\n";
			while($rowdailysales = mysql_fetch_array($condailysales)){
				$data .= str_replace(",","", $rowdailysales[0]).",".$rowdailysales[1].",".$rowdailysales[2].",".$rowdailysales[3].",".$rowdailysales[4].",".$rowdailysales[5].",".$rowdailysales[6].",".$rowdailysales[7].",".$rowdailysales[8].",".$rowdailysales[9].",".$rowdailysales[10].",".$rowdailysales[11].",".$rowdailysales[12].",".$rowdailysales[13].",".$rowdailysales[14].",".$rowdailysales[15].",".$rowdailysales[16].",".$rowdailysales[17].",".$rowdailysales[18].",".$rowdailysales[19].",".$rowdailysales[20].",".$rowdailysales[21].",".$rowdailysales[22].",".$rowdailysales[23].",".$rowdailysales[24].",".$rowdailysales[25].",".$rowdailysales[26].",".$rowdailysales[27].",".$rowdailysales[28].",".$rowdailysales[29]."\r\n";
			}
			$filepath = mysql_fetch_array(mysql_query("SELECT filepath FROM tblsys_setup", $connection));
			$syspath = str_replace("\\", "/", $filepath[0]);
			if (!file_exists($syspath)){
				mkdir($syspath, 0777, true);
			}
			$file = $syspath."/DailySales_".date('mdY').".csv";
			chmod($file, 0777);
			if (file_put_contents($file, $data)){
				create_logs_per_transaction('exported a report to excel', 'Daily Sales', '', '', 'EXPORT', '');
				echo 1;
			}else{
				echo 0;
			}
		break;

		case 'dbSales_Total':
			if($_POST['mallid'] == '' || $_POST['mallid'] == 'null'){
				$WithMall = getMallAccess("a.mallid", "AND");
			}else{
				$WithMall = "AND a.mallid = '". $_POST['mallid'] ."'";
			}
			$TotalSales =  mysql_fetch_array(mysql_query("SELECT SUM(a.". $tblSales[4] ."), SUM(a.". $tblSales[5] ."), SUM(a.". $tblSales[6] ."), SUM(a.". $tblSales[7] ."), SUM(a.". $tblSales[8] ."), SUM(a.". $tblSales[9] ."), SUM(a.". $tblSales[10] ."), SUM(a.". $tblSales[11] ."), SUM(a.". $tblSales[12] ."), SUM(a.". $tblSales[13] ."), SUM(a.". $tblSales[14] ."), SUM(a.". $tblSales[15] ."), SUM(a.". $tblSales[16] ."), SUM(a.". $tblSales[17] ."), SUM(a.". $tblSales[18] ."), SUM(a.". $tblSales[19] ."), SUM(a.". $tblSales[22] ."), SUM(a.". $tblSales[23] ."), SUM(a.". $tblSales[24] ."), SUM(a.". $tblSales[25] ."),  SUM(a.". $tblSales[26] ."), SUM(a.". $tblSales[27] ."), SUM(a.". $tblSales[28] ."), SUM(a.". $tblSales[29] ."), SUM(a.". $tblSales[31] ."), SUM(a.". $tblSales[32] ."), SUM(a.". $tblSales[33] .") FROM ". $tblSales[0] ." AS a LEFT JOIN tbltrans_tenants AS b ON a.tenantid = b.TenantID WHERE b.tradename LIKE '%". $_POST['key'] ."%' AND (a.". $tblSales[1] ." BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['DateTo'])) ."') ". $WithMall .";", $connection));

			echo number_format($TotalSales[0], 2, ".", ",") ."|". number_format($TotalSales[1], 2, ".", ",") ."|". number_format($TotalSales[2], 2, ".", ",") ."|". number_format($TotalSales[3], 2, ".", ",") ."|". number_format($TotalSales[4], 2, ".", ",") ."|". number_format($TotalSales[5], 2, ".", ",") ."|". number_format($TotalSales[6], 2, ".", ",") ."|". number_format($TotalSales[7], 2, ".", ",") ."|". number_format($TotalSales[8], 2, ".", ",") ."|". number_format($TotalSales[9], 2, ".", ",") ."|". number_format($TotalSales[10], 2, ".", ",") ."|". number_format($TotalSales[11], 2, ".", ",") ."|". number_format($TotalSales[12], 2, ".", ",") ."|". number_format($TotalSales[13], 2, ".", ",") ."|". number_format($TotalSales[14], 2, ".", ",") ."|". number_format($TotalSales[15], 2, ".", ",") ."|". number_format($TotalSales[16], 2, ".", ",") ."|". number_format($TotalSales[17], 2, ".", ",") ."|". number_format($TotalSales[18], 2, ".", ",") ."|". number_format($TotalSales[19], 2, ".", ",") ."|". number_format($TotalSales[20], 2, ".", ",") ."|". number_format($TotalSales[21], 2, ".", ",") ."|". number_format($TotalSales[22], 2, ".", ",") ."|". number_format($TotalSales[23], 2, ".", ",") ."|". number_format($TotalSales[24], 2, ".", ",") ."|". number_format($TotalSales[25], 2, ".", ",") ."|". number_format($TotalSales[26], 2, ".", ",");
		break;

		case 'dbHour':
			$page = $_POST['page'];
			$limit = ($page-1) * 20;
			if($_POST['mallid'] == '' || $_POST['mallid'] == 'null'){
				$WithMall = getMallAccess("a.mallid", "AND");
			}else{
				$WithMall = "AND a.mallid = '". $_POST['mallid'] ."'";
			}
			$sql = "SELECT b.tradename, a.". $tblHourly[1] .", a.". $tblHourly[3] .", a.". $tblHourly[4] .", a.". $tblHourly[5] .", a.". $tblHourly[6] .", a.". $tblHourly[7] ." FROM ". $tblHourly[0] ." AS a LEFT JOIN tbltrans_tenants AS b ON a.tenantid = b.TenantID WHERE b.tradename LIKE '%". $_POST['key'] ."%' AND (a.". $tblHourly[1] ." BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['DateTo'])) ."') ". $WithMall ." GROUP BY ".$tblHourly[1]." ORDER BY ". $_POST['HourlySalesSortBy'] ." ". $_POST['HourlySalesSortType'] ."; LIMIT ". $limit .",20;";
			$res = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($res)){
				echo 	"<tr>
							<td style='white-space: nowrap;'>". $row[0] ."</td>
							<td style='white-space: nowrap;'>". date('m/d/Y', strtotime($row[1])) ."</td>
							<td style='white-space: nowrap;'>". date("h:i A", strtotime($row[2])) ."</td>
							<td style='white-space: nowrap;text-align: right;'>". number_format($row[3], 2, ".", ",") ."</td>
							<td style='white-space: nowrap;text-align: right;'>". number_format($row[4], 2, ".", ",") ."</td>
							<td style='white-space: nowrap;text-align: right;'>". number_format($row[5], 2, ".", ",") ."</td>
							<td style='white-space: nowrap;text-align: right;'>". number_format($row[6], 2, ".", ",") ."</td>
						</tr>";
			}
		break;

		case 'printtenantsalesreporthourly':
			$res = mysql_query("SELECT b.tradename, a.fdtTrnsctn, a.fvcHRLCd, a.fnmDlySls, a.fnmCntDcmnt, a.fnmCntCstmr, a.fnmCntSnrCtzn FROM fdb_perhour AS a LEFT JOIN tbltrans_tenants AS b ON a.tenantID = b.tenantID WHERE b.tradename LIKE '%".$_POST['tenant']."%' AND a.fdtTrnsctn BETWEEN '".date("Y-m-d", strtotime($_POST['datefrom']))."' AND '".date("Y-m-d", strtotime($_POST['dateto']))."' AND a.mallid = '".$_POST['mallid']."' ORDER BY fdtTrnsctn, fvcHRLCd;", $connection);
				?>  
				<style type="text/css">
					#hr{
						background: black !important; padding:2px;
					}
				</style>

				<center> <h2> <b>Hourly Sales Report</b> </h2> </center>
				<table style='width:100%;'>
					<tr>
						<td id='hr'> </td>
					</tr>
				</table><br/>
				<table  style='width: 100%;' cellspacing='0' cellpadding='0'>
					<thead>
						<th style="border: 1px solid black; text-align: center; color: white; padding:3px !important;"> Store Name </th>
						<th style="border: 1px solid black; text-align: center; color: white; padding:5px !important;"> Transaction Date </th>
						<th style="border: 1px solid black; text-align: center; color: white; padding:3px !important;"> Hour Code </th>
						<th style="border: 1px solid black; text-align: center; color: white; padding:3px !important;"> Daily Sales </th>
						<th style="border: 1px solid black; text-align: center; color: white; padding:3px !important;"> Document Count </th>
						<th style="border: 1px solid black; text-align: center; color: white; padding:3px !important;"> Customer Count </th>
						<th style="border: 1px solid black; text-align: center; color: white; padding:5px !important;"> Senior Citizen Count </th>
					</thead>
					<tbody>
						
				<?php
				while($row = mysql_fetch_array($res)){
					?>
					<tr id='<?php echo $row[0]; ?>'>
						<td style="border: 1px solid black; padding:5px;"><?php echo $row[0]; ?></td>
						<td style="border: 1px solid black; padding:5px;"><?php echo $row[1]; ?></td>
						<td style="border: 1px solid black; padding:5px;"><?php echo $row[2]; ?></td>
						<td style="border: 1px solid black; padding:5px;"><?php echo $row[3]; ?></td>
						<td style="border: 1px solid black; padding:5px;"><?php echo $row[4]; ?></td>
						<td style="border: 1px solid black; padding:5px;"><?php echo $row[5]; ?></td>
						<td style="border: 1px solid black; padding:5px;"><?php echo $row[6]; ?></td>
					</tr>
					<?php
				}
				?></tbody></table><?php
		break;

		case 'AutoConsolidatehourlysales':
			$hourlysales = "SELECT b.tradename, a.fdtTrnsctn, a.fvcHRLCd, a.fnmDlySls, a.fnmCntDcmnt, a.fnmCntCstmr, a.fnmCntSnrCtzn FROM fdb_perhour AS a LEFT JOIN tbltrans_tenants AS b ON a.tenantID = b.tenantID WHERE b.tradename LIKE '%". $_POST['tenant'] ."%' AND a.fdtTrnsctn BETWEEN '".date("Y-m-d", strtotime($_POST['datefrom']))."' AND '".date("Y-m-d", strtotime($_POST['dateto']))."' AND a.mallid = '".$_POST['mallid']."' ORDER BY fdtTrnsctn, fvcHRLCd ASC;";
			$hourlysales = mysql_query($hourlysales, $connection);
			$data = "Store Name,Transaction Date,Hour Code,Daily Sales,Document Count,Customer Count,Senior Citizen Count\r\n";
			while($rowhourlysales = mysql_fetch_array($hourlysales)){
				$data .= str_replace(",","", $rowhourlysales[0]).",".$rowhourlysales[1].",".$rowhourlysales[2].",".$rowhourlysales[3].",".$rowhourlysales[4].",".$rowhourlysales[5].",".$rowhourlysales[6]."\r\n";
			}
			$filepath = mysql_fetch_array(mysql_query("SELECT filepath FROM tblsys_setup", $connection));
			$syspath = str_replace("\\", "/", $filepath[0]);
			if (!file_exists($syspath)){
				mkdir($syspath, 0777, true);
			}
			$file = $syspath."/HourlySales_".date('mdY').".csv";
			chmod($file, 0777);
			if (file_put_contents($file, $data)){
				create_logs_per_transaction('exported a report to excel', 'Daily Sales Hourly', '', '', 'EXPORT', '');
				echo 1;
			}else{
				echo 0;
			}
		break;

		case 'dbPayment':
			$page = $_POST['page'];
			$limit = ($page-1) * 20;
			if($_POST['mallid'] == '' || $_POST['mallid'] == 'null'){
				$WithMall = getMallAccess("a.mallid", "AND");
			}else{
				$WithMall = "AND a.mallid = '". $_POST['mallid'] ."'";
			}
			$sql = "SELECT b.tradename, a.". $tblPayment[1] .", a.". $tblPayment[3] .", a.". $tblPayment[4] .", a.". $tblPayment[5] .", a.". $tblPayment[6] .", a.". $tblPayment[7] ." FROM ". $tblPayment[0] ." AS a LEFT JOIN tbltrans_tenants AS b ON a.tenantid = b.TenantID WHERE b.tradename LIKE '%". $_POST['key'] ."%' AND (a.". $tblPayment[1] ." BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['DateTo'])) ."') ". $WithMall ." GROUP BY a.fdtTrnsctn ORDER BY ". $_POST['PaymentSalesSortBy'] ." ". $_POST['PaymentSalesSortType'] ." LIMIT ". $limit .",20;";
			$res = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($res)){
				echo 	"<tr>
							<td style='white-space: nowrap;'>". $row[0] ."</td>
							<td style='white-space: nowrap;'>". date('m/d/Y', strtotime($row[1])) ."</td>
							<td style='white-space: nowrap;'>". $row[2] ."</td>
							<td style='white-space: nowrap;'>". $row[3] ."</td>
							<td style='white-space: nowrap;text-align: right;'>". number_format($row[4], 2, ".", ",") ."</td>
							<td style='white-space: nowrap;'>". $row[5] ."</td>
							<td style='white-space: nowrap;text-align: right;'>". number_format($row[6], 2, ".", ",") ."</td>
						</tr>";
			}
		break;

		case 'printdailypayment':
			$res = mysql_query("SELECT b.tradename, a.". $tblPayment[1] .", a.". $tblPayment[3] .", a.". $tblPayment[4] .", a.". $tblPayment[5] .", a.". $tblPayment[6] .", a.". $tblPayment[7] ." FROM ". $tblPayment[0] ." AS a LEFT JOIN tbltrans_tenants AS b ON a.tenantid = b.TenantID WHERE b.tradename LIKE '%". $_POST['tenant'] ."%' AND (a.". $tblPayment[1] ." BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['DateTo'])) ."') ". $WithMall ." ORDER BY ". $tblPayment[1] .";", $connection);
					?>  
					<style type="text/css">
						#hr{
							background: black !important; padding:2px;
						}
					</style>

					<center> <h2> <b>Daily Sales - Payment Report</b> </h2> </center>
					<table style='width:100%;'>
						<tr>
							<td id='hr'> </td>
						</tr>
					</table><br/>
					<table  style='width: 100%;' cellspacing='0' cellpadding='0'>
						<thead>
							<th style="border: 1px solid black; text-align: center; color: white; padding:3px !important;"> Store Name </th>
							<th style="border: 1px solid black; text-align: center; color: white; padding:5px !important;"> Transaction Date </th>
							<th style="border: 1px solid black; text-align: center; color: white; padding:3px !important;"> Payment Code </th>
							<th style="border: 1px solid black; text-align: center; color: white; padding:3px !important;"> Payment Description </th>
							<th style="border: 1px solid black; text-align: center; color: white; padding:3px !important;"> Payment Code Classification </th>
							<th style="border: 1px solid black; text-align: center; color: white; padding:3px !important;"> Payment Code Description </th>
							<th style="border: 1px solid black; text-align: center; color: white; padding:5px !important;"> Payment Amount </th>
						</thead>
						<tbody>
							
					<?php
					while($row = mysql_fetch_array($res)){
						?>
						<tr id='<?php echo $row[0]; ?>'>
							<td style="border: 1px solid black; padding:5px;"><?php echo $row[0]; ?></td>
							<td style="border: 1px solid black; padding:5px;"><?php echo $row[1]; ?></td>
							<td style="border: 1px solid black; padding:5px;"><?php echo $row[2]; ?></td>
							<td style="border: 1px solid black; padding:5px;"><?php echo $row[3]; ?></td>
							<td style="border: 1px solid black; padding:5px;"><?php echo $row[4]; ?></td>
							<td style="border: 1px solid black; padding:5px;"><?php echo $row[5]; ?></td>
							<td style="border: 1px solid black; padding:5px;"><?php echo $row[6]; ?></td>
						</tr>
						<?php
					}
					?></tbody></table><?php
		break;

		case 'AutoConsolidatepayment':
			$payment = "SELECT b.tradename, a.". $tblPayment[1] .", a.". $tblPayment[3] .", a.". $tblPayment[4] .", a.". $tblPayment[5] .", a.". $tblPayment[6] .", a.". $tblPayment[7] ." FROM ". $tblPayment[0] ." AS a LEFT JOIN tbltrans_tenants AS b ON a.tenantid = b.TenantID WHERE b.tradename LIKE '%". $_POST['tenant'] ."%' AND (a.". $tblPayment[1] ." BETWEEN '". date('Y-m-d', strtotime($_POST['datefrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['dateto'])) ."') ". $WithMall ." ORDER BY ". $tblPayment[1] .";";
			// echo $payment;
			$conpayment = mysql_query($payment, $connection);
			$data = "Store Name,Transaction Date,Payment Code,Payment Description,Payment Code Classification,Payment Code Description,Payment Amount\r\n";
			while($rowpayment = mysql_fetch_array($conpayment)){
				$data .= str_replace(",","",$rowpayment[0]).",".$rowpayment[1].",".$rowpayment[2].",".$rowpayment[3].",".$rowpayment[4].",".$rowpayment[5].",".$rowpayment[6]."\r\n";
				// echo $rowpayment[6];
			}
			$filepath = mysql_fetch_array(mysql_query("SELECT filepath FROM tblsys_setup", $connection));
			$syspath = str_replace("\\", "/", $filepath[0]);
			if (!file_exists($syspath)){
				mkdir($syspath, 0777, true);
			}
			$file = $syspath."/DailySalesPayment".date('mdY').".csv";
			chmod($file, 0777);
			if (file_put_contents($file, $data)){
				create_logs_per_transaction('exported a report to excel', 'Daily Sales Payment', '', '', 'EXPORT', '');
				echo 1;
			}else{
				echo 0;
			}
		break;

		case 'dbDiscount':
			$page = $_POST['page'];
			$limit = ($page-1) * 20;
			if($_POST['mallid'] == '' || $_POST['mallid'] == 'null'){
				$WithMall = getMallAccess("a.mallid", "AND");
			}else{
				$WithMall = "AND a.mallid = '". $_POST['mallid'] ."'";
			}
			$res = mysql_query("SELECT b.tradename, a.". $tblDiscount[1] .", a.". $tblDiscount[3] .", a.". $tblDiscount[4] .", a.". $tblDiscount[5] .", a.". $tblDiscount[6] .", a.". $tblDiscount[7] .", a.". $tblDiscount[8] ." FROM ". $tblDiscount[0] ." AS a LEFT JOIN tbltrans_tenants AS b ON a.tenantid = b.TenantID WHERE b.tradename LIKE '%". $_POST['key'] ."%' AND (a.". $tblDiscount[1] ." BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['DateTo'])) ."') ". $WithMall ."  GROUP BY a.fdtTrnsctn ORDER BY ". $_POST['DiscountSalesSortBy'] ." ". $_POST['DiscountSalesSortType'] ." LIMIT ". $limit .",20;", $connection);
			while($row = mysql_fetch_array($res)){
				echo 	"<tr>
							<td style='white-space: nowrap;'>". $row[0] ."</td>
							<td style='white-space: nowrap;'>". date('m/d/Y', strtotime($row[1])) ."</td>
							<td style='white-space: nowrap;'>". $row[2] ."</td>
							<td style='white-space: nowrap;text-align: right;'>". number_format($row[3], 2, ".", ",") ."</td>
							<td style='white-space: nowrap;text-align: right;'>". number_format($row[4], 2, ".", ",") ."</td>
							<td style='white-space: nowrap;text-align: right;'>". number_format($row[5], 2, ".", ",") ."</td>
							<td style='white-space: nowrap;text-align: right;'>". number_format($row[6], 2, ".", ",") ."</td>
							<td style='white-space: nowrap;text-align: right;'>". number_format($row[7], 2, ".", ",") ."</td>
						</tr>";
			}
		break;

		case 'printsalesdiscount':
			$res = mysql_query("SELECT b.tradename, a.". $tblDiscount[1] .", a.". $tblDiscount[3] .", a.". $tblDiscount[4] .", a.". $tblDiscount[5] .", a.". $tblDiscount[6] .", a.". $tblDiscount[7] .", a.". $tblDiscount[8] ." FROM ". $tblDiscount[0] ." AS a LEFT JOIN tbltrans_tenants AS b ON a.tenantid = b.TenantID WHERE b.tradename LIKE '%". $_POST['tenant'] ."%' AND (a.". $tblDiscount[1] ." BETWEEN '". date('Y-m-d', strtotime($_POST['datefrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['dateto'])) ."') ". $WithMall ." ORDER BY ".$tblDiscount[1].";", $connection);
					?>  
					<style type="text/css">
						#hr{
							background: black !important; padding:2px;
						}
					</style>

					<center> <h2> <b>Daily Sales - Discount Report</b> </h2> </center>
					<table style='width:100%;'>
						<tr>
							<td id='hr'> </td>
						</tr>
					</table><br/>
					<table  style='width: 100%;' cellspacing='0' cellpadding='0'>
						<thead>
							<th style="border: 1px solid black; text-align: center; color: white; padding:3px !important;"> Store Name </th>
							<th style="border: 1px solid black; text-align: center; color: white; padding:5px !important;"> Transaction Date </th>
							<th style="border: 1px solid black; text-align: center; color: white; padding:3px !important;"> Discount Code </th>
							<th style="border: 1px solid black; text-align: center; color: white; padding:3px !important;"> Discount Percentage </th>
							<th style="border: 1px solid black; text-align: center; color: white; padding:3px !important;"> Discount Amount </th>
							<th style="border: 1px solid black; text-align: center; color: white; padding:3px !important;"> Document Count </th>
							<th style="border: 1px solid black; text-align: center; color: white; padding:5px !important;"> Customer Count </th>
							<th style="border: 1px solid black; text-align: center; color: white; padding:5px !important;"> Serior Citizen Count </th>
						</thead>
						<tbody>
							
					<?php
					while($row = mysql_fetch_array($res)){
						?>
						<tr id='<?php echo $row[0]; ?>'>
							<td style="border: 1px solid black; padding:5px;"><?php echo $row[0]; ?></td>
							<td style="border: 1px solid black; padding:5px;"><?php echo $row[1]; ?></td>
							<td style="border: 1px solid black; padding:5px;"><?php echo $row[2]; ?></td>
							<td style="border: 1px solid black; padding:5px;"><?php echo $row[3]; ?></td>
							<td style="border: 1px solid black; padding:5px;"><?php echo $row[4]; ?></td>
							<td style="border: 1px solid black; padding:5px;"><?php echo $row[5]; ?></td>
							<td style="border: 1px solid black; padding:5px;"><?php echo $row[6]; ?></td>
							<td style="border: 1px solid black; padding:5px;"><?php echo $row[7]; ?></td>
						</tr>
						<?php
					}
					?></tbody></table><?php
		break;

		case 'AutoConsolidatediscount':
			$Discount = "SELECT b.tradename, a.". $tblDiscount[1] .", a.". $tblDiscount[3] .", a.". $tblDiscount[4] .", a.". $tblDiscount[5] .", a.". $tblDiscount[6] .", a.". $tblDiscount[7] .", a.". $tblDiscount[8] ." FROM ". $tblDiscount[0] ." AS a LEFT JOIN tbltrans_tenants AS b ON a.tenantid = b.TenantID WHERE b.tradename LIKE '%". $_POST['tenant'] ."%' AND (a.". $tblDiscount[1] ." BETWEEN '". date('Y-m-d', strtotime($_POST['datefrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['dateto'])) ."') ". $WithMall ." ORDER BY ".$tblDiscount[1].";";
			// echo $Discount;
			$condiscount = mysql_query($Discount, $connection);
			$data = "Store Name,Transaction Date,Discount Code,Discount Percentage,Discount Amount,Document Count,Customer Count,Senior Citizen Count\r\n";
			while($rowdiscount = mysql_fetch_array($condiscount)){
				$data .= str_replace(",","", $rowdiscount[0]).",".$rowdiscount[1].",".$rowdiscount[2].",".$rowdiscount[3].",".$rowdiscount[4].",".$rowdiscount[5].",".$rowdiscount[6].",".$rowdiscount[7]."\r\n";
			}
			$filepath = mysql_fetch_array(mysql_query("SELECT filepath FROM tblsys_setup", $connection));
			$syspath = str_replace("\\", "/", $filepath[0]);
			if (!file_exists($syspath)){
				mkdir($syspath, 0777, true);
			}
			$file = $syspath."/DailySalesDiscount".date('mdY').".csv";
			chmod($file, 0777);
			if (file_put_contents($file, $data)){
				create_logs_per_transaction('exported a report to excel', 'Daily Sales Discount', '', '', 'EXPORT', '');
				echo 1;
			}else{
				echo 0;
			}
		break;

		case 'dbVoid':
			$page = $_POST['page'];
			$limit = ($page-1) * 20;
			if($_POST['mallid'] == '' || $_POST['mallid'] == 'null'){
				$WithMall = getMallAccess("a.mallid", "AND");
			}else{
				$WithMall = "AND a.mallid = '". $_POST['mallid'] ."'";
			}
			$res = mysql_query("SELECT b.tradename, ".$tblVoid[1].", ".$tblVoid[3].", ".$tblVoid[4].", ".$tblVoid[5].", ".$tblVoid[6].", ".$tblVoid[7].", ".$tblVoid[8]." FROM ".$tblVoid[0]." AS a LEFT JOIN tbltrans_tenants AS b ON a.tenantid = b.TenantID WHERE b.tradename LIKE '%". $_POST['key'] ."%' AND (a.".$tblVoid[1]." BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['DateTo'])) ."') ".$WithMall." GROUP BY  fdtTrnsctn ORDER BY ". $_POST['VoidSalesSortBy'] ." ". $_POST['VoidSalesSortType'] ." LIMIT ". $limit .",20;", $connection);
			// echo "SELECT b.tradename, ".$tblVoid[1].", ".$tblVoid[3].", ".$tblVoid[4].", ".$tblVoid[5].", ".$tblVoid[6].", ".$tblVoid[7].", ".$tblVoid[8]." FROM ".$tblVoid[0]." AS a LEFT JOIN tbltrans_tenants AS b ON a.tenantid = b.TenantID WHERE b.tradename LIKE '%". $_POST['key'] ."%' AND (a.".$tblVoid[1]." BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['DateTo'])) ."') ".$WithMall." GROUP BY ".$tblVoid[1]." ORDER BY ". $_POST['VoidSalesSortBy'] ." ". $_POST['VoidSalesSortType'] ." LIMIT ". $limit .",20;";
				// ORDER BY ".$tblVoid[1]." LIMIT ". $limit .", 20;", $connection);

			while($row = mysql_fetch_array($res)){	
				echo 	"<tr>
							<td style='white-space: nowrap;'>". $row[0] ."</td>
							<td style='white-space: nowrap;'>". date('m/d/Y', strtotime($row[1])) ."</td>
							<td style='white-space: nowrap;'>". $row[2] ."</td>
							<td style='white-space: nowrap;'>". $row[3] ."</td>
							<td style='white-space: nowrap;text-align: right;'>". number_format($row[4], 2, ".", ",") ."</td>
							<td style='white-space: nowrap;text-align: right;'>". number_format($row[5], 2, ".", ",") ."</td>
							<td style='white-space: nowrap;text-align: right;'>". number_format($row[6], 2, ".", ",") ."</td>
							<td style='white-space: nowrap;text-align: right;'>". number_format($row[7], 2, ".", ",") ."</td>
						</tr>";
			}
		break;

		case 'printdailyrefund':
			$res = mysql_query("SELECT b.tradename, ".$tblVoid[1].", ".$tblVoid[3].", ".$tblVoid[4].", ".$tblVoid[5].", ".$tblVoid[6].", ".$tblVoid[7].", ".$tblVoid[8]." FROM ".$tblVoid[0]." AS a LEFT JOIN tbltrans_tenants AS b ON a.tenantid = b.TenantID WHERE b.tradename LIKE '%". $_POST['tenant'] ."%' AND (a.".$tblVoid[1]." BETWEEN '". date('Y-m-d', strtotime($_POST['datefrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['dateto'])) ."') ".$WithMall." ORDER BY ".$tblVoid[1].";", $connection);
					?>  
					<style type="text/css">
						#hr{
							background: black !important; padding:2px;
						}
					</style>

					<center> <h2> <b>Daily Sales - Refund / Cancelled Report</b> </h2> </center>
					<table style='width:100%;'>
						<tr>
							<td id='hr'> </td>
						</tr>
					</table><br/>
					<table  style='width: 100%;' cellspacing='0' cellpadding='0'>
						<thead>
							<th style="border: 1px solid black; text-align: center; color: white; padding:3px !important;"> Store Name </th>
							<th style="border: 1px solid black; text-align: center; color: white; padding:5px !important;"> Transaction Date </th>
							<th style="border: 1px solid black; text-align: center; color: white; padding:3px !important;"> Code </th>
							<th style="border: 1px solid black; text-align: center; color: white; padding:3px !important;"> Reason </th>
							<th style="border: 1px solid black; text-align: center; color: white; padding:3px !important;"> Amount </th>
							<th style="border: 1px solid black; text-align: center; color: white; padding:3px !important;"> Document Count </th>
							<th style="border: 1px solid black; text-align: center; color: white; padding:5px !important;"> Customer Count </th>
							<th style="border: 1px solid black; text-align: center; color: white; padding:5px !important;"> Serior Citizen Count </th>
						</thead>
						<tbody>
							
					<?php
					while($row = mysql_fetch_array($res)){
						?>
						<tr id='<?php echo $row[0]; ?>'>
							<td style="border: 1px solid black; padding:5px;"><?php echo $row[0]; ?></td>
							<td style="border: 1px solid black; padding:5px;"><?php echo $row[1]; ?></td>
							<td style="border: 1px solid black; padding:5px;"><?php echo $row[2]; ?></td>
							<td style="border: 1px solid black; padding:5px;"><?php echo $row[3]; ?></td>
							<td style="border: 1px solid black; padding:5px;"><?php echo $row[4]; ?></td>
							<td style="border: 1px solid black; padding:5px;"><?php echo $row[5]; ?></td>
							<td style="border: 1px solid black; padding:5px;"><?php echo $row[6]; ?></td>
							<td style="border: 1px solid black; padding:5px;"><?php echo $row[7]; ?></td>
						</tr>
						<?php
					}
					?></tbody></table><?php
		break;

		case 'AutoConsolidaterefund':
			$Refund = "SELECT b.tradename, ".$tblVoid[1].", ".$tblVoid[3].", ".$tblVoid[4].", ".$tblVoid[5].", ".$tblVoid[6].", ".$tblVoid[7].", ".$tblVoid[8]." FROM ".$tblVoid[0]." AS a LEFT JOIN tbltrans_tenants AS b ON a.tenantid = b.TenantID WHERE b.tradename LIKE '%". $_POST['tenant'] ."%' AND (a.".$tblVoid[1]." BETWEEN '". date('Y-m-d', strtotime($_POST['datefrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['dateto'])) ."') ".$WithMall." ORDER BY ".$tblVoid[1].";";;
			$conrefund = mysql_query($Refund, $connection);
			$data = "Store Name,Transaction Date,Code,Reason,Amount,Document Count,Customer Count,Senior Citizen Count\r\n";
			while($rowrefund = mysql_fetch_array($conrefund)){
				$data .= str_replace(",","",$rowrefund[0]).",".$rowrefund[1].",".$rowrefund[2].",".$rowrefund[3].",".$rowrefund[4].",".$rowrefund[5].",".$rowrefund[6].",".$rowrefund[7]."\r\n";
			}
			$filepath = mysql_fetch_array(mysql_query("SELECT filepath FROM tblsys_setup", $connection));
			$syspath = str_replace("\\", "/", $filepath[0]);
			if (!file_exists($syspath)){
				mkdir($syspath, 0777, true);
			}
			$file = $syspath."/DailySalesRefund".date('mdY').".csv";
			chmod($file, 0777);
			if (file_put_contents($file, $data)){
				create_logs_per_transaction('exported a report to excel', 'Daily Sales Refund', '', '', 'EXPORT', '');
				echo 1;
			}else{
				echo 0;
			}
		break;

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
           	}else if($_POST['ReportType'] == "dbPayment"){
            	$rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(a.id) FROM ". $tblPayment[0] ." AS a LEFT JOIN tbltrans_tenants AS b ON a.tenantid = b.TenantID WHERE b.tradename LIKE '%". $_POST['key'] ."%' AND (a.".$tblPayment[1]." BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['DateTo'])) ."') ".$WithMall.";", $connection));
           	}else if($_POST['ReportType'] == "dbDiscount"){
            	$rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(a.id) FROM ". $tblDiscount[0] ." AS a LEFT JOIN tbltrans_tenants AS b ON a.tenantid = b.TenantID WHERE b.tradename LIKE '%". $_POST['key'] ."%' AND (a.".$tblDiscount[1]." BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['DateTo'])) ."') ".$WithMall.";", $connection));
           	}else if($_POST['ReportType'] == "dbVoid"){
            	$rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(a.id) FROM ". $tblVoid[0] ." AS a LEFT JOIN tbltrans_tenants AS b ON a.tenantid = b.TenantID WHERE b.tradename LIKE '%". $_POST['key'] ."%' AND (a.".$tblVoid[1]." BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['DateTo'])) ."') ".$WithMall.";", $connection));
           	}
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
           	}else if($_POST['ReportType'] == "dbPayment"){
            	$rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(a.id) FROM ". $tblPayment[0] ." AS a LEFT JOIN tbltrans_tenants AS b ON a.tenantid = b.TenantID WHERE b.tradename LIKE '%". $_POST['key'] ."%' AND (a.".$tblPayment[1]." BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['DateTo'])) ."') ".$WithMall.";", $connection));
           	}else if($_POST['ReportType'] == "dbDiscount"){
            	$rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(a.id) FROM ". $tblDiscount[0] ." AS a LEFT JOIN tbltrans_tenants AS b ON a.tenantid = b.TenantID WHERE b.tradename LIKE '%". $_POST['key'] ."%' AND (a.".$tblDiscount[1]." BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['DateTo'])) ."') ".$WithMall.";", $connection));
           	}else if($_POST['ReportType'] == "dbVoid"){
            	$rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(a.id) FROM ". $tblVoid[0] ." AS a LEFT JOIN tbltrans_tenants AS b ON a.tenantid = b.TenantID WHERE b.tradename LIKE '%". $_POST['key'] ."%' AND (a.".$tblVoid[1]." BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['DateTo'])) ."') ".$WithMall.";", $connection));
           	}
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
			while($row = mysql_fetch_array($res)){
				if($row["filename"] == ""){
					$image = "assets/images/noimage5.png";
				}else{
					if(!file_exists("../../../Mall_Attachments/company/". $row["CompanyID"] ."/trades/". $row['tradeID'] ."/". $row["filename"])){ 
						$image = "assets/images/noimage5.png";
					}else{
						$image = "../Mall_Attachments/company/". $row["CompanyID"] ."/trades/". $row['tradeID'] ."/". $row["filename"];
					}
				}

				echo 	"<li class='dd-item dd2-item' style='cursor: pointer;' id='". $row[1] ."'>
                         	<div class='dd2-content'><label style='width:80%;'>". $row['tradename'] ."</label></div>
                     	</li>";
			}
		break;

		case 'getTenantName':
			$TenantName = mysql_fetch_array(mysql_query("SELECT tradename FROM tbltrans_tenants WHERE TenantID = '". $_POST['TenantID'] ."';", $connection));
			echo $TenantName['tradename'];
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
				$dbVoid = mysql_fetch_array(mysql_query("SELECT SUM(". $tblVoid[5] .") FROM ". $tblVoid[0] ." WHERE MONTH(". $tblVoid[1] .") = '". $_POST['month'] ."' AND YEAR(". $tblVoid[1] .") = '". $_POST['year'] ."' ". $WithMall .";", $connection));
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
					$dbVoid = mysql_fetch_array(mysql_query("SELECT SUM(". $tblVoid[5] .") FROM ". $tblVoid[0] ." WHERE MONTH(". $tblVoid[1] .") = '". $_POST['month'] ."' AND YEAR(". $tblVoid[1] .") = '". $_POST['year'] ."' AND TenantID = '". $row[0] ."' ". $WithMall .";", $connection));
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
			}else if($_POST['ReportType'] == "Discount"){
				$res = mysql_query("SELECT ". $tblDiscount[3] .", SUM(". $tblDiscount[5] .") total FROM ". $tblDiscount[0] ." WHERE YEAR(". $tblDiscount[1] .") = '". $_POST['year'] ."' AND MONTH(". $tblDiscount[1] .") = '". $_POST['month'] ."' ". $WithTenant ." GROUP BY ". $tblDiscount[3] ." ORDER BY total DESC;", $connection);
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

		case 'getheaderprint':
			$template = mysql_fetch_array(mysql_query("SELECT template FROM tblsys_setup;", $connection));

			if($_POST['tenantid'] == "" && $_POST['mallID'] != ""){
				$row = mysql_fetch_array(mysql_query("SELECT mallname, malladdress, telephone_number, email, mall_image FROM tblref_mall WHERE mallid = '".$_POST["mallID"]."';", $connection));
				$path = "../Mall_Attachments/mall_image/";
			}else if($_POST['tenantid'] != "" && $_POST['mallID'] == ""){
				$mallid = mysql_fetch_array(mysql_query("SELECT mallID FROM tbltrans_tenants WHERE TenantID = '". $_POST['tenantid'] ."'", $connection));
				$row = mysql_fetch_array(mysql_query("SELECT mallname, malladdress, telephone_number, email, mall_image FROM tblref_mall WHERE mallid = '".$mallid[0]."';", $connection));
				$path = "../Mall_Attachments/mall_image/";
			}else{
		      	$row = mysql_fetch_array(mysql_query("SELECT corporatename, address, contactnumber, emailaddress, corporatelogo from tblsys_setup;", $connection));
		      	$path = "../Mall_Attachments/SysLogo/";
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
	}
?>