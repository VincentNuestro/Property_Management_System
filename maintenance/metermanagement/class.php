<?php 
	session_start();
	include("../../connect.php");
	switch ($_POST['form']){
		case 'tblShowMeterList':
			$cnt_fltr = 0;
			$sql_filter = mysql_fetch_array(mysql_query("SELECT checked_value, bystat FROM tblref_filters WHERE module = 'MeterManagement' AND userid = '". $_SESSION['MMS-UserID'] ."';", $connection));
			$trby = explode("|", $sql_filter["checked_value"]);
			$stat = explode("|", $sql_filter["bystat"]);
			$filter = "";
			// filter for status
			$cnt = 0; $chk = "";
			for($a = 0; $a<=count($stat)-1; $a++){
				if($stat[$a] == "Electric"){ 
					$con = "a.MeterType = 'Electric'";
				}else if($stat[$a] == "Water"){ 
					$con = "a.MeterType = 'Water'";
				}else if($stat[$a] == "Gas"){
					$con = "a.MeterType = 'Gas'";
				}
				if($stat[$a] != ""){
					$cnt_fltr++;
					$cnt++;
					if($cnt == 1){
					  $chk .= $con;
					}else{
					  $chk .= " OR ".$con;
					}
				}
			}
			if($cnt > 1){
				$Stat_fltr = "(".$chk.")";
			}else{
				$Stat_fltr = $chk;
			}
			if($cnt > 0){
				$and = " AND ";
			}else{
				$and = "";
			}

			// filter by
			$cnt3 = 0; $chk3 = "";
			for($c = 0; $c<=count($trby)-1; $c++){
				if($trby[$c] != ""){
					$cnt_fltr++;
					$cnt3++;
					if($cnt3 == 1){
						$chk3 .= $trby[$c] . " LIKE '%".$_POST["key"]."%'";
					}else{
						$chk3 .= " OR ". $trby[$c] . " LIKE '%".$_POST["key"]."%'";
					}
				}
			}

			if($cnt3 > 1){
				$by_fltr = "(".$chk3.")";
			}else{
				$by_fltr = $chk3;
			}

			if($cnt > 0 ){
				$filterselected = $Stat_fltr.$and.$by_fltr;
				$page = $_POST['page'];
				$limit = ($page-1) * 20;
				// Modified by Ronald
				$res = mysql_query("SELECT a.date_added, a.CurrentMeterUsage, a.MeterID, a.Multiplier, b.tradename, a.MeterType, a.id, a.AssignedTenant, a.xSub, a.parentMeterID FROM tblref_meter AS a LEFT JOIN tbltrans_tenants AS b ON a.AssignedTenant = b.TenantID WHERE ". $filterselected ." LIMIT ". $limit .",20;", $connection);
				while($row = mysql_fetch_array($res)){
					if($row['MeterType'] == "Electric"){
						$Type = "<i class='fa fa-flash orange'></i> " . $row['MeterType'];
					}else if($row['MeterType'] == "Water"){
						$Type = "<i class='fa fa-tint blue'></i> " . $row['MeterType'];
					}else if($row['MeterType'] == "Gas"){
						$Type = "<i class='fa fa-fire red'></i> " . $row['MeterType'];
					}
					// Added By Ronald
					$assgnTenant = "";
					if( $row[8] != 1 ){
						$assgnTenant = "<button class='btn btn-sm btn-success btn-round btn-round' title='Assign Tenant' style='z-index: 0;margin: 2px;' onclick='fncAssignTenant(\"". $row['MeterID'] ."\", \"". $row['MeterType'] ."\", \"". $row['AssignedTenant'] ."\", \"". floatval($row['CurrentMeterUsage']) ."\")'><img src='assets/images/assigntenant.png' style='width: 100%; height: auto;' /></button>";
					}
					// Added By Ronald
					// Modified By Ronald
					echo 	"<tr>
								<td>". date('m/d/Y', strtotime($row['date_added'])) ."</td>
								<td>". $row['MeterID'] ."</td>
								<td>". floatval($row['CurrentMeterUsage']) ."</td>
								<td>". $row['Multiplier'] ."</td>
								<td>". $row['tradename'] ."</td>
								<td>". $Type ."</td>
								<td class='center'>
									<div class='btn-group' style='z-index: 0;'>
										<button class='btn btn-sm btn-info btn-round btn-round' title='Edit Meter Information' style='z-index: 0;margin: 2px;' onclick='fncEditMeterInfo(\"". $row['MeterID'] ."\", \"". $row['MeterType'] ."\", \"". $row['Multiplier'] ."\", \"". $row['id'] ."\", \"". floatval($row['CurrentMeterUsage']) ."\", \"". $row[8] ."\", \"". $row[9] ."\")'><img src='assets/images/edit.png' style='width: 100%; height: auto;' /></button>
										".$assgnTenant."
										<button class='btn btn-sm btn-danger btn-round btn-round' title='Delete Meter' style='z-index: 0;margin: 2px;' onclick='fncDeleteMeter(\"". $row['MeterID'] ."\")'><img src='assets/images/remove.png' style='width: 100%; height: auto;' /></button>
										<button class='btn btn-sm btn-gray btn-round btn-round' onclick='ViewAssignedTenantHistory(\"". $row["MeterID"] ."\", \"". $row['MeterType'] ."\")' title='View History' style='margin: 2px;'><img src='assets/images/clock.png' style='width: 100%; height: auto;' /></button>
									</div>
								</td>
							</tr>";
					// END Modified By Ronald
				}
			}
		break;

		case 'fncMeterListEntries':
			$cnt_fltr = 0;
			$sql_filter = mysql_fetch_array(mysql_query("SELECT checked_value, bystat FROM tblref_filters WHERE module = 'MeterManagement' AND userid = '". $_SESSION['MMS-UserID'] ."';", $connection));
			$trby = explode("|", $sql_filter["checked_value"]);
			$stat = explode("|", $sql_filter["bystat"]);
			$filter = "";
			// filter for status
			$cnt = 0; $chk = "";
			for($a = 0; $a<=count($stat)-1; $a++){
				if($stat[$a] == "Electric"){ 
					$con = "a.MeterType = 'Electric'";
				}else if($stat[$a] == "Water"){ 
					$con = "a.MeterType = 'Water'";
				}else if($stat[$a] == "Gas"){
					$con = "a.MeterType = 'Gas'";
				}
				if($stat[$a] != ""){
					$cnt_fltr++;
					$cnt++;
					if($cnt == 1){
					  $chk .= $con;
					}else{
					  $chk .= " OR ".$con;
					}
				}
			}
			if($cnt > 1){
				$Stat_fltr = "(".$chk.")";
			}else{
				$Stat_fltr = $chk;
			}
			if($cnt > 0){
				$and = " AND ";
			}else{
				$and = "";
			}

			// filter by
			$cnt3 = 0; $chk3 = "";
			for($c = 0; $c<=count($trby)-1; $c++){
				if($trby[$c] != ""){
					$cnt_fltr++;
					$cnt3++;
					if($cnt3 == 1){
						$chk3 .= $trby[$c] . " LIKE '%".$_POST["key"]."%'";
					}else{
						$chk3 .= " OR ". $trby[$c] . " LIKE '%".$_POST["key"]."%'";
					}
				}
			}

			if($cnt3 > 1){
				$by_fltr = "(".$chk3.")";
			}else{
				$by_fltr = $chk3;
			}

			if($cnt > 0 ){
				if($_POST["page"] == ""){
					$page = 1;
				}else{
					$page = $_POST["page"];
				}

				$limit = ($page-1) * 20;
				$filterselected = $Stat_fltr.$and.$by_fltr;
				$result = mysql_query("SELECT COUNT(a.id) FROM tblref_meter AS a LEFT JOIN tbltrans_tenants AS b ON a.AssignedTenant = b.TenantID WHERE ". $filterselected .";", $connection);
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
			}
		break;

		case "fncMeterListPage":
			$page = $_POST["page"];
			$cnt_fltr = 0;
			$sql_filter = mysql_fetch_array(mysql_query("SELECT checked_value, bystat FROM tblref_filters WHERE module = 'MeterManagement' AND userid = '". $_SESSION['MMS-UserID'] ."';", $connection));
			$trby = explode("|", $sql_filter["checked_value"]);
			$stat = explode("|", $sql_filter["bystat"]);
			$filter = "";
			// filter for status
			$cnt = 0; $chk = "";
			for($a = 0; $a<=count($stat)-1; $a++){
				if($stat[$a] == "Electric"){ 
					$con = "a.MeterType = 'Electric'";
				}else if($stat[$a] == "Water"){ 
					$con = "a.MeterType = 'Water'";
				}else if($stat[$a] == "Gas"){
					$con = "a.MeterType = 'Gas'";
				}
				if($stat[$a] != ""){
					$cnt_fltr++;
					$cnt++;
					if($cnt == 1){
					  $chk .= $con;
					}else{
					  $chk .= " OR ".$con;
					}
				}
			}
			if($cnt > 1){
				$Stat_fltr = "(".$chk.")";
			}else{
				$Stat_fltr = $chk;
			}
			if($cnt > 0){
				$and = " AND ";
			}else{
				$and = "";
			}

			// filter by
			$cnt3 = 0; $chk3 = "";
			for($c = 0; $c<=count($trby)-1; $c++){
				if($trby[$c] != ""){
					$cnt_fltr++;
					$cnt3++;
					if($cnt3 == 1){
						$chk3 .= $trby[$c] . " LIKE '%".$_POST["key"]."%'";
					}else{
						$chk3 .= " OR ". $trby[$c] . " LIKE '%".$_POST["key"]."%'";
					}
				}
			}

			if($cnt3 > 1){
				$by_fltr = "(".$chk3.")";
			}else{
				$by_fltr = $chk3;
			}

			if($cnt > 0 ){
				$filterselected = $Stat_fltr.$and.$by_fltr;
				$aa = mysql_query("SELECT COUNT(a.id) FROM tblref_meter AS a LEFT JOIN tbltrans_tenants AS b ON a.AssignedTenant = b.TenantID WHERE ". $filterselected .";", $connection);
				$nums = mysql_fetch_row($aa);
				$num = $nums[0];
				$rowsperpage = 20;
				$range = 3;
				$totalpages = ceil($num / $rowsperpage);
				$prevpage;
				$nextpage;
				// if not on page 1, don't show back links
				if($page > 1 ){
					echo "<li style='width:50px !important;' onclick='MeterListPagination(1)'><< First</li>";
					$prevpage = $page - 1;
					echo "<li style='width:70px !important;' onclick='MeterListPagination(". $prevpage .")'>< Previous</li>";
				}

				for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
				   if(($x > 0) && ($x <= $totalpages)){
						if($x == $page){
							echo "<li id='pgMeterList" . $x . "' class='pgNumMeterList active' onclick='MeterListPagination(" . $x . ",". $x .")'>" . $x . "</li>";
						}else{
							echo "<li id='pgMeterList" . $x . "' class='pgNumMeterList' onclick='MeterListPagination(" . $x . ",". $x .")'>" . $x . "</li>";
						}
					}
				}
				if($page < ($totalpages - $range)){
					echo "<li>...</li>";
				}
				if($page != $totalpages && $num != 0){
				   $nextpage = $page + 1;
				   echo "<li style='width:50px !important;' onclick='MeterListPagination(". $nextpage .", ". $nextpage .")'>Next ></li>";
				   echo "<li style='width:50px !important;' onclick='MeterListPagination(". $totalpages .", ". $totalpages .")'>Last >></li>";
				}
			}
		break;

		// Added By Ronald
		case 'viewSubMeter':
			$res = mysql_query( "SELECT meterid,currentmeterusage,multiplier FROM `tblref_meter` WHERE parentMeterID = '".$_POST['MeterID']."' AND MeterType = '".$_POST['MeterType']."'" );
			$subM=0;
			while ( $row = mysql_fetch_array( $res ) ) {
				$subM++;
				?>
				<tr id="subM<?php echo $subM; ?>">
					<td><?php echo $row[0];?></td>
					<td><?php echo $row[1];?></td>
					<td><?php echo $row[2];?></td>
					<td>
						<button class='btn btn-sm btn-danger btn-round btn-round' title='Delete Meter' style='z-index: 0;margin: 2px;' onclick='delsubmeter("subM<?php echo $subM; ?>");' ><img src='assets/images/remove.png' style='width: 100%; height: auto;'></button>
					</td>
				</tr>
				<?php
			}
		break;

		case 'fncSaveEditsubMeter':
			$CheckMeterID = mysql_num_rows(mysql_query("SELECT id FROM tblref_meter WHERE MeterID = '". $_POST['MeterID'] ."' AND MeterType = '". $_POST['MeterType'] ."' AND id != '". $_POST['id'] ."';", $connection));
			if($CheckMeterID == 0){
				$res = mysql_query("UPDATE tblref_meter SET MeterID = '". $_POST['MeterID'] ."', CurrentMeterUsage = '". floatval($_POST['MeterUsage']) ."', Multiplier = '". $_POST['Multiplier'] ."' WHERE id = '". $_POST['id'] ."';", $connection);
				if($res == true){
					echo 1;
				}else{
					echo 2;
				}
			}else{
				echo 3;
			}
		break;

		case 'checkMeterIDifExist':
			echo mysql_num_rows(mysql_query("SELECT id FROM tblref_meter WHERE MeterID = '". $_POST['MeterID'] ."' AND MeterType = '". $_POST['MeterType'] ."';", $connection));
		break;
		// END Added By Ronald

		// Modified By ronald
		// case 'fncSaveNewMeter':

		// 	$submeters = explode( '|##|' , $_POST['subMeters'] );

		// 	$CheckMeterID = mysql_num_rows(mysql_query("SELECT id FROM tblref_meter WHERE MeterID = '". $_POST['MeterID'] ."' AND MeterType = '". $_POST['MeterType'] ."';", $connection));

		// 	$stat = 1;

		// 	if($_POST['Action'] == "Add"){
		// 		if($CheckMeterID == 0){

		// 			mysql_query( "START TRANSACTION" , $connection );
		// 			mysql_query( "BEGIN" , $connection );

		// 			$res = mysql_query("INSERT INTO tblref_meter SET MeterID = '". $_POST['MeterID'] ."', CurrentMeterUsage = '". floatval($_POST['MeterUsage']) ."', Multiplier = '". $_POST['Multiplier'] ."', MeterType = '". $_POST['MeterType'] ."', date_added = '". date('Y-m-d') ."', xSub = '". $_POST['withSubM'] ."';", $connection) or $stat = 2;

		// 			if( count( $submeters ) > 0 ){
		// 				for( $i = 1; $i < count( $submeters ); $i++ ){
		// 					$subData = explode( '|#|' , $submeters[$i] );
		// 					if( mysql_num_rows(mysql_query("SELECT id FROM tblref_meter WHERE MeterID = '". $subData[0] ."' AND MeterType = '". $_POST['MeterType'] ."';", $connection) ) == 0 ){
		// 						$res2 = mysql_query("INSERT INTO tblref_meter SET MeterID = '". $subData[0] ."', CurrentMeterUsage = '". floatval($subData[1]) ."', Multiplier = '". $subData[2] ."', MeterType = '". $_POST['MeterType'] ."', date_added = '". date('Y-m-d') ."', parentMeterID = '". $_POST['MeterID'] ."';", $connection) or $stat = 2;
		// 					} else {
		// 						$stat = 3;
		// 					}
		// 				}
		// 			}

		// 			if( $stat == 1 ){
		// 				mysql_query( "COMMIT" , $connection );
		// 			} else {
		// 				mysql_query( "ROLLBACK" , $connection );
		// 			}
		// 			echo $stat;
		// 		}else{
		// 			echo 3;
		// 		}
		// 	}else{
		// 		if($CheckMeterID == 1){
		// 			mysql_query( "START TRANSACTION" , $connection );
		// 			mysql_query( "BEGIN" , $connection );
		// 			$res = mysql_query("UPDATE tblref_meter SET MeterID = '". $_POST['MeterID'] ."', CurrentMeterUsage = '". floatval($_POST['MeterUsage']) ."', Multiplier = '". $_POST['Multiplier'] ."', MeterType = '". $_POST['MeterType'] ."' , xSub = '". $_POST['withSubM'] ."' WHERE id = '". $_POST['id'] ."';", $connection);

		// 			mysql_query("DELETE FROM tblref_meter WHERE parentMeterID = '". $_POST['MeterID'] ."' AND MeterType = '".$_POST['MeterType']."'");

		// 			if( count( $submeters ) > 0 ){
		// 				for( $i = 1; $i < count( $submeters ); $i++ ){
		// 					$subData = explode( '|#|' , $submeters[$i] );

		// 					if( mysql_num_rows(mysql_query("SELECT id FROM tblref_meter WHERE MeterID = '". $subData[0] ."' AND MeterType = '". $_POST['MeterType'] ."';", $connection) ) == 0 ){

		// 						$res2 = mysql_query("INSERT INTO tblref_meter SET MeterID = '". $subData[0] ."', CurrentMeterUsage = '". floatval($subData[1]) ."', Multiplier = '". $subData[2] ."', MeterType = '". $_POST['MeterType'] ."', date_added = '". date('Y-m-d') ."', parentMeterID = '". $_POST['MeterID'] ."';", $connection) or $stat = 2;

		// 					} else {
		// 						$stat = 3;
		// 					}
		// 				}
		// 			}

		// 			if( $stat == 1 ){
		// 				mysql_query( "COMMIT" , $connection );
		// 			} else {
		// 				mysql_query( "ROLLBACK" , $connection );
		// 			}
		// 			echo $stat;
		// 		}else{
		// 			echo 3;
		// 		}
		// 	}
		// break;

		// ADDED BY PETER (FEB 14, 2019)
		case 'fncSaveNewMeter':

			$submeters = explode( '|##|' , $_POST['subMeters'] );

			$CheckMeterID = mysql_num_rows(mysql_query("SELECT id FROM tblref_meter WHERE MeterID = '". $_POST['MeterID'] ."' AND MeterType = '". $_POST['MeterType'] ."';", $connection));

			$stat = 1;

			if($_POST['Action'] == "Add"){
				if($CheckMeterID == 0){

					mysql_query( "START TRANSACTION" , $connection );
					mysql_query( "BEGIN" , $connection );

					$res = mysql_query("INSERT INTO tblref_meter SET MeterID = '". $_POST['MeterID'] ."', CurrentMeterUsage = '". floatval($_POST['MeterUsage']) ."', Multiplier = '". $_POST['Multiplier'] ."', MeterType = '". $_POST['MeterType'] ."', date_added = '". date('Y-m-d') ."', xSub = '". $_POST['withSubM'] ."';", $connection) or $stat = 2;

					if( count( $submeters ) > 0 ){
						for( $i = 1; $i < count( $submeters ); $i++ ){
							$subData = explode( '|#|' , $submeters[$i] );
							if( mysql_num_rows(mysql_query("SELECT id FROM tblref_meter WHERE MeterID = '". $subData[0] ."' AND MeterType = '". $_POST['MeterType'] ."';", $connection) ) == 0 ){
								$res2 = mysql_query("INSERT INTO tblref_meter SET MeterID = '". $subData[0] ."', CurrentMeterUsage = '". floatval($subData[1]) ."', Multiplier = '". $subData[2] ."', MeterType = '". $_POST['MeterType'] ."', date_added = '". date('Y-m-d') ."', parentMeterID = '". $_POST['MeterID'] ."';", $connection) or $stat = 2;
							} else {
								$stat = 3;
							}
						}
					}

					if( $stat == 1 ){
						mysql_query( "COMMIT" , $connection );
					} else {
						mysql_query( "ROLLBACK" , $connection );
					}
					echo $stat;
				}else{
					echo 3;
				}
			}else{
				if($CheckMeterID == 1){
					mysql_query( "START TRANSACTION" , $connection );
					mysql_query( "BEGIN" , $connection );
					$res = mysql_query("UPDATE tblref_meter SET MeterID = '". $_POST['MeterID'] ."', CurrentMeterUsage = '". floatval($_POST['MeterUsage']) ."', Multiplier = '". $_POST['Multiplier'] ."', MeterType = '". $_POST['MeterType'] ."' , xSub = '". $_POST['withSubM'] ."' WHERE id = '". $_POST['id'] ."';", $connection);

					mysql_query("DELETE FROM tblref_meter WHERE parentMeterID = '". $_POST['MeterID'] ."' AND MeterType = '".$_POST['MeterType']."'");

					if( count( $submeters ) > 0 ){
						for( $i = 1; $i < count( $submeters ); $i++ ){
							$subData = explode( '|#|' , $submeters[$i] );

							if( mysql_num_rows(mysql_query("SELECT id FROM tblref_meter WHERE MeterID = '". $subData[0] ."' AND MeterType = '". $_POST['MeterType'] ."';", $connection) ) == 0 ){

								$res2 = mysql_query("INSERT INTO tblref_meter SET MeterID = '". $subData[0] ."', CurrentMeterUsage = '". floatval($subData[1]) ."', Multiplier = '". $subData[2] ."', MeterType = '". $_POST['MeterType'] ."', date_added = '". date('Y-m-d') ."', parentMeterID = '". $_POST['MeterID'] ."';", $connection) or $stat = 2;

							} else {
								$stat = 3;
							}
						}
					}

					if( $stat == 1 ){
						mysql_query( "COMMIT" , $connection );
					} else {
						mysql_query( "ROLLBACK" , $connection );
					}
					echo $stat;
				}else{
					echo 3;
				}
			}
		break;

		case 'fncDeleteMeter':
			$res = mysql_query("DELETE a , b FROM tblref_meter a LEFT JOIN tblref_meter b ON a.MeterID = b.parentMeterID WHERE a.MeterID = '". $_POST['MeterID'] ."';", $connection);
			if($res == true){
				echo 1;
			}else{
				echo 2;
			}
		break;
		// END Modified By ronald

		case 'tblMeterTenantList':
			$page = $_POST['page'];
			$limit = ($page-1) * 20;
			$res = mysql_query("SELECT a.TenantID, b.mallname, a.tradename, a.Status, a.datefrom, a.dateto FROM tbltrans_tenants AS a LEFT JOIN tblref_mall AS b ON a.mallID = b.mallid WHERE (a.Status = 'Active' OR a.Status = 'ForEviction' OR a.Status = 'ForRenewal') AND (a.tradename LIKE '%". $_POST['key'] ."%' OR b.mallname LIKE '%". $_POST['key'] ."%') AND a.TenantID != '". $_POST['TenantID'] ."' ORDER BY a.tradename ASC LIMIT ".$limit.",20;", $connection);
			while($row = mysql_fetch_array($res)){
				echo 	"<tr onclick='fncAssigningConfirmation(\"". $_POST['MeterID'] ."\", \"". $_POST['MeterType'] ."\", \"". $row['tradename'] ."\", \"". $row['TenantID'] ."\", \"". $_POST['CurrentMeterUsage'] ."\");'>
							<td>". $row['TenantID'] ."</td>
							<td>". $row['mallname'] ."</td>
							<td>". $row['tradename'] ."</td>
							<td>Start Date: ". date('m/d/Y', strtotime($row['datefrom'])) ."<br>End Date: ". date('m/d/Y', strtotime($row['dateto'])) ."</td>
							<td>". $row['Status'] ."</td>
						</tr>";
			}
		break;

		case 'fncMeterTenantListEntries':
			if($_POST["page"] == ""){
				$page = 1;
			}else{
				$page = $_POST["page"];
			}

			$limit = ($page-1) * 20;
			$result = mysql_query("SELECT COUNT(a.TenantID) FROM tbltrans_tenants AS a LEFT JOIN tblref_mall AS b ON a.mallID = b.mallid WHERE (a.Status = 'Active' OR a.Status = 'ForEviction' OR a.Status = 'ForRenewal') AND (a.tradename LIKE '%". $_POST['key'] ."%' OR b.mallname LIKE '%". $_POST['key'] ."%') AND a.TenantID != '". $_POST['TenantID'] ."';", $connection);
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

		case "fncMeterTenantListPagination":
			$page = $_POST["page"];		    
			$aa = mysql_query("SELECT COUNT(a.TenantID) FROM tbltrans_tenants AS a LEFT JOIN tblref_mall AS b ON a.mallID = b.mallid WHERE (a.Status = 'Active' OR a.Status = 'ForEviction' OR a.Status = 'ForRenewal') AND (a.tradename LIKE '%". $_POST['key'] ."%' OR b.mallname LIKE '%". $_POST['key'] ."%') AND a.TenantID != '". $_POST['TenantID'] ."';", $connection);
			$nums = mysql_fetch_row($aa);
			$num = $nums[0];
			$rowsperpage = 20;
			$range = 3;
			$totalpages = ceil($num / $rowsperpage);
			$prevpage;
			$nextpage;
			// if not on page 1, don't show back links
			if($page > 1 ){
				echo "<li style='width:50px !important;' onclick='MeterTenantListPagination(1, \"\", \"". $_POST['MeterID'] ."\", \"". $_POST['MeterType'] ."\", \"". $_POST['TenantID'] ."\")'><< First</li>";
				$prevpage = $page - 1;
				echo "<li style='width:70px !important;' onclick='MeterTenantListPagination(". $prevpage .", \"\", \"". $_POST['MeterID'] ."\", \"". $_POST['MeterType'] ."\", \"". $_POST['TenantID'] ."\")'>< Previous</li>";
			}

			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if(($x > 0) && ($x <= $totalpages)){
					if($x == $page){
						echo "<li id='pgTenantList" . $x . "' class='pgNumTenantList active' onclick='MeterTenantListPagination(" . $x . ",". $x .", \"". $_POST['MeterID'] ."\", \"". $_POST['MeterType'] ."\", \"". $_POST['TenantID'] ."\")'>" . $x . "</li>";
					}else{
						echo "<li id='pgTenantList" . $x . "' class='pgNumTenantList' onclick='MeterTenantListPagination(" . $x . ",". $x .", \"". $_POST['MeterID'] ."\", \"". $_POST['MeterType'] ."\", \"". $_POST['TenantID'] ."\")'>" . $x . "</li>";
					}
				}
			}
			if($page < ($totalpages - $range)){
				echo "<li>...</li>";
			}
			if($page != $totalpages && $num != 0){
			   $nextpage = $page + 1;
			   echo "<li style='width:50px !important;' onclick='MeterTenantListPagination(". $nextpage .", ". $nextpage .", \"". $_POST['MeterID'] ."\", \"". $_POST['MeterType'] ."\", \"". $_POST['TenantID'] ."\")'>Next ></li>";
			   echo "<li style='width:50px !important;' onclick='MeterTenantListPagination(". $totalpages .", ". $totalpages .", \"". $_POST['MeterID'] ."\", \"". $_POST['MeterType'] ."\", \"". $_POST['TenantID'] ."\")'>Last >></li>";
			}
		break;

		case 'fncAssigningConfirmed':
			$CheckValidity = mysql_fetch_array(mysql_query("SELECT CurrentMeterUsage AS CurrentMeterUsage FROM tblref_meter WHERE MeterID = '". $_POST['MeterID'] ."' AND MeterType = '". $_POST['MeterType'] ."';", $connection));
			if(floatval($CheckValidity['CurrentMeterUsage']) <= floatval($_POST['CurrentMeter'])){

				$res = mysql_query("UPDATE tblref_meter SET AssignedTenant = '". $_POST['TenantID'] ."', CurrentMeterUsage = '". floatval($_POST['CurrentMeter']) ."' WHERE MeterID = '". $_POST['MeterID'] ."' AND MeterType = '". $_POST['MeterType'] ."';", $connection);

				$resInsertMeterLogs = mysql_query("INSERT INTO tblref_meterLogs SET MeterID = '". $_POST['MeterID'] ."', CurrentMeterUsage = '". floatval($_POST['CurrentMeter']) ."', MeterType = '". $_POST['MeterType'] ."', AssignedTenant = '". $_POST['TenantID'] ."', SysDate = '". date('Y-m-d', strtotime(getsysdate())) ."';", $connection);

				echo 1;
			}else{
				echo 2;
			}
		break;

		case 'fncTenantLastReading':
			$page = $_POST['page'];
			$limit = ($page-1) * 20;
			$res = mysql_query("SELECT a.TenantID, b.mallname, a.tradename, a.LMRWater, a.LMRElectric, a.LMRGas FROM tbltrans_tenants AS a LEFT JOIN tblref_mall AS b ON a.mallID = b.mallid WHERE (a.Status = 'Active' OR a.Status = 'ForEviction' OR a.Status = 'ForRenewal') AND (a.tradename LIKE '%". $_POST['key'] ."%' OR b.mallname LIKE '%". $_POST['key'] ."%') ORDER BY a.tradename ASC LIMIT ".$limit.",20;", $connection);
			while($row = mysql_fetch_array($res)){
				if($row['LMRWater'] == "" || $row['LMRWater'] == "1970-01-01"){
					$LastReadWater = "";
				}else{
					$LastReadWater = date('m/d/Y', strtotime($row['LMRWater']));
				}
				if($row['LMRElectric'] == "" || $row['LMRElectric'] == "1970-01-01"){
					$LastReadElectric = "";
				}else{
					$LastReadElectric = date('m/d/Y', strtotime($row['LMRElectric']));
				}
				if($row['LMRGas'] == "" || $row['LMRGas'] == "1970-01-01"){
					$LastReadGas = "";
				}else{
					$LastReadGas = date('m/d/Y', strtotime($row['LMRGas']));
				}
				echo 	"<tr>
							<td>". $row['mallname'] ."</td>
							<td>". $row['tradename'] ."</td>
							<td><label id='lblLastReadWater". $row['TenantID'] ."'>". $LastReadWater ."</label><input type='text' class='form-control date-picker' id='txtLastReadWater". $row['TenantID'] ."' style='display: none;' value='". $LastReadWater ."'></td>
							<td><label id='lblLastReadElectric". $row['TenantID'] ."'>". $LastReadElectric ."</label><input type='text' class='form-control date-picker' id='txtLastReadElectric". $row['TenantID'] ."' style='display: none;' value='". $LastReadElectric ."'></td>
							<td><label id='lblLastReadGas". $row['TenantID'] ."'>". $LastReadGas ."</label><input type='text' class='form-control date-picker' id='txtLastReadGas". $row['TenantID'] ."' style='display: none;' value='". $LastReadGas ."'></td>
							<td class='center'>
								<div class='btn-group' style='z-index: 0;'>
									<button class='btn btn-sm btn-info btn-round' title='Edit Record' id='btnEdit". $row['TenantID'] ."' style='z-index: 0;margin: 2px;' onclick='fncEditLastRead(\"". $row['TenantID'] ."\")'><img src='assets/images/edit.png' style='width: 100%; height: auto;' /></button>
									<button class='btn btn-sm btn-success btn-round' title='Assign Tenant' id='btnSave". $row['TenantID'] ."' style='z-index: 0;margin: 2px;display: none;' onclick='fncSaveLastRead(\"". $row['TenantID'] ."\")'><i class='fa fa-check bigger-120'></i></button>
									<button class='btn btn-sm btn-danger btn-round' title='Delete Meter' id='btnCancel". $row['TenantID'] ."' style='z-index: 0;margin: 2px;display: none;' onclick='fncCancelLastRead(\"". $row['TenantID'] ."\")'><i class='fa fa-times bigger-120'></i></button>
								</div>
							</td>
						</tr>";
			}
		break;

		case 'fncLastReadTenantListEntries':
			if($_POST["page"] == ""){
				$page = 1;
			}else{
				$page = $_POST["page"];
			}
			$limit = ($page-1) * 20;	
			$result = mysql_query("SELECT COUNT(a.TenantID) FROM tbltrans_tenants AS a LEFT JOIN tblref_mall AS b ON a.mallID = b.mallid WHERE (a.Status = 'Active' OR a.Status = 'ForEviction' OR a.Status = 'ForRenewal') AND (a.tradename LIKE '%". $_POST['key'] ."%' OR b.mallname LIKE '%". $_POST['key'] ."%');", $connection);
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

		case "fncLastReadTenantListPagination":
			$page = $_POST["page"];		    
			$aa = mysql_query("SELECT COUNT(a.TenantID) FROM tbltrans_tenants AS a LEFT JOIN tblref_mall AS b ON a.mallID = b.mallid WHERE (a.Status = 'Active' OR a.Status = 'ForEviction' OR a.Status = 'ForRenewal') AND (a.tradename LIKE '%". $_POST['key'] ."%' OR b.mallname LIKE '%". $_POST['key'] ."%');", $connection);
			$nums = mysql_fetch_row($aa);
			$num = $nums[0];
			$rowsperpage = 20;
			$range = 3;
			$totalpages = ceil($num / $rowsperpage);
			$prevpage;
			$nextpage;
			// if not on page 1, don't show back links
			if($page > 1 ){
				echo "<li style='width:50px !important;' onclick='LastReadTenantListPagination(1)'><< First</li>";
				$prevpage = $page - 1;
				echo "<li style='width:70px !important;' onclick='LastReadTenantListPagination(". $prevpage .")'>< Previous</li>";
			}

			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if(($x > 0) && ($x <= $totalpages)){
					if($x == $page){
						echo "<li id='pgLastReadTenantList" . $x . "' class='pgNumLastReadTenantList active' onclick='LastReadTenantListPagination(" . $x . ",". $x .")'>" . $x . "</li>";
					}else{
						echo "<li id='pgLastReadTenantList" . $x . "' class='pgNumLastReadTenantList' onclick='LastReadTenantListPagination(" . $x . ",". $x .")'>" . $x . "</li>";
					}
				}
			}
			if($page < ($totalpages - $range)){
				echo "<li>...</li>";
			}
			if($page != $totalpages && $num != 0){
			   $nextpage = $page + 1;
			   echo "<li style='width:50px !important;' onclick='LastReadTenantListPagination(". $nextpage .", ". $nextpage .")'>Next ></li>";
			   echo "<li style='width:50px !important;' onclick='LastReadTenantListPagination(". $totalpages .", ". $totalpages .")'>Last >></li>";
			}
		break;

		case 'fncSaveLastRead':
			if($_POST['LastReadWater'] == "" || $_POST['LastReadWater'] == "1970-01-01"){
				$LastReadWater = "";
			}else{
				$LastReadWater = date('m/d/Y', strtotime($_POST['LastReadWater']));
			}
			if($_POST['LastReadElectric'] == "" || $_POST['LastReadElectric'] == "1970-01-01"){
				$LastReadElectric = "";
			}else{
				$LastReadElectric = date('m/d/Y', strtotime($_POST['LastReadElectric']));
			}
			if($_POST['LastReadGas'] == "" || $_POST['LastReadGas'] == "1970-01-01"){
				$LastReadGas = "";
			}else{
				$LastReadGas = date('m/d/Y', strtotime($_POST['LastReadGas']));
			}
			$res = mysql_query("UPDATE tbltrans_tenants SET LMRWater = '". date('Y-m-d', strtotime($_POST['LastReadWater'])) ."', LMRElectric = '".  date('Y-m-d', strtotime($_POST['LastReadElectric'])) ."', LMRGas = '".  date('Y-m-d', strtotime($_POST['LastReadGas'])) ."' WHERE TenantID = '". $_POST['TenantID'] ."'", $connection);
			if($res == true){
				echo "1|". $LastReadWater ."|". $LastReadElectric ."|". $LastReadGas;
			}else{
				echo "2|||";
			}
		break;

		case 'ViewAssignedTenantHistory':
			$res = mysql_query("SELECT b.tradename, a.SysDate, a.CurrentMeterUsage FROM tblref_meterlogs AS a LEFT JOIN tbltrans_tenants AS b ON a.AssignedTenant = b.TenantID WHERE a.MeterID = '". $_POST['MeterID'] ."' AND a.MeterType = '". $_POST['MeterType'] ."' AND (b.tradename LIKE '%". $_POST['key'] ."%' OR a.CurrentMeterUsage LIKE '%". $_POST['key'] ."%') AND (a.SysDate BETWEEN '". date('Y-m-d', strtotime($_POST['DateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['DateTo'])) ."') ORDER BY a.SysDate DESC;", $connection);
			while($row = mysql_fetch_array($res)){
				echo    "<tr>
							<td>". date('m/d/Y', strtotime($row['SysDate'])) ."</td>
							<td>". $row['tradename'] ."</td>
							<td>". $row['CurrentMeterUsage'] ."</td>
						</tr>";
			}
		break;
	}
?>