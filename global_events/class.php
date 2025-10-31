<?php
	session_start();
	include("../connect.php");
	switch ($_POST['form']) {
		case 'getefacilities':
			echo "<option value=''>-Select Facility-</option>";
			$sql = "SELECT id,FacilitiesDesc FROM tblref_facilities ORDER BY FacilitiesDesc ASC";
			$result =  mysql_query($sql,$connection) or die(mysql_error());
			while ($row = mysql_fetch_array($result)) {
				echo "<option value='".$row['id']."'>".$row['FacilitiesDesc']."</option>";
			}
		break;

		case 'selectamountfacilities':
			$sql = "SELECT Amount FROM tblref_facilities WHERE id = '".$_POST['codex']."' ";
			$result = mysql_query($sql) or die(mysql_error());
			$row = mysql_fetch_array($result);
			echo number_format($row['Amount'],2);
		break;
		
		case 'getefsound':
			echo "<option value=''>-Select Sound & Personnel-</option>";
			$sql = "SELECT id,SoundnperDesc FROM tblref_soundnper ORDER BY SoundnperDesc ASC";
			$result =  mysql_query($sql,$connection) or die(mysql_error());
			while ($row = mysql_fetch_array($result)) {
				echo "<option value='".$row['id']."'>".$row['SoundnperDesc']."</option>";
			}
		break;

		case 'selectamountpersonnel':
			$sql = "SELECT Amount FROM tblref_soundnper WHERE id = '".$_POST['codex']."' ";
			$result = mysql_query($sql) or die(mysql_error());
			$row = mysql_fetch_array($result);
			echo number_format($row['Amount'],2);
		break;

		case 'getefmanpower':
			echo "<option value=''>-Select Manpower-</option>";
			$sql = "SELECT id,ManpowerDesc FROM tblref_manpower ORDER BY ManpowerDesc ASC";
			$result =  mysql_query($sql,$connection) or die(mysql_error());
			while ($row = mysql_fetch_array($result)) {
				echo "<option value='".$row['id']."'>".$row['ManpowerDesc']."</option>";
			}
		break;

		case 'selectamountmanpower':
			$sql = "SELECT Amount FROM tblref_manpower WHERE id = '".$_POST['codex']."' ";
			$result = mysql_query($sql) or die(mysql_error());
			$row = mysql_fetch_array($result);
			echo number_format($row['Amount'],2);
		break;

		case 'geteforganizer':
			echo "<option value=''>-Select Organizer-</option>";
			$sql = "SELECT id,OrganizermDesc FROM tblref_organizerm ORDER BY OrganizermDesc ASC";
			$result =  mysql_query($sql,$connection) or die(mysql_error());
			while ($row = mysql_fetch_array($result)) {
				echo "<option value='".$row['id']."'>".$row['OrganizermDesc']."</option>";
			}
		break;

		case 'getefpromotional':
			echo "<option value=''>-Select Organizer-</option>";
			$sql = "SELECT id,PromotionalpDesc FROM tblref_promotionalp ORDER BY PromotionalpDesc ASC";
			$result =  mysql_query($sql,$connection) or die(mysql_error());
			while ($row = mysql_fetch_array($result)) {
				echo "<option value='".$row['id']."'>".$row['PromotionalpDesc']."</option>";
			}
		break;
		
		case 'getcompanylistx':
			echo "<option value=''>-Select Organizer-</option>";
			$sql = "SELECT CompanyID,Company FROM tbltrans_company ORDER BY Company ASC ";
			$result = mysql_query($sql) or die(mysql_error());
			while ($row = mysql_fetch_array($result)) {
				echo "<option value='".$row['CompanyID']."'>".$row['Company']."</option>";
			}
		break;

		case 'fncSavesaveevents':
			$subID = "";
			$getLastForMonth = " SELECT eventid FROM event_header WHERE LEFT(eventid, 7) = '". date("Y-m", strtotime($_POST['txteventstartdate'])) ."' ORDER BY eventid DESC LIMIT 1 ";
			$resLastForMonth = mysql_query($getLastForMonth, $connection);
			$rowLastForMonth = mysql_fetch_array($resLastForMonth);

			if ( $rowLastForMonth[0] == "" ) {
				$subID = 1;
			}
			else {
				$arr = explode("-", $rowLastForMonth[0]);
				$subID = end($arr) + 1;
			}
			$subID2 = str_pad($subID, 6, 0, STR_PAD_LEFT);
			

			if($_POST['lblSNo']==""){
				$newID2 = date('Y-m', strtotime($_POST['txteventstartdate'])) . "-" . $subID2;

				if($_POST['proposalNum']!=""){
					$proposalNum = $_POST['proposalNum'];
				}else{
					$proposalNum = '1';
				}
				if($proposalNum ==0){
					$proposalNum = 1;
				}
				$sql = "
					INSERT INTO 
						event_header 
					SET
						eventid = '". $newID2 ."',
						inquiryid = '". $_POST['InquiryID'] ."',
						eventName = '". mysql_real_escape_string($_POST['txteventname']) ."',
						startdate = '". date('Y-m-d', strtotime($_POST['txteventstartdate'])) ."',
						enddate = '". date('Y-m-d', strtotime($_POST['txteventenddate'])) ."',
						compCode = '". mysql_real_escape_string($_POST['txteventorganizer']) ."',
						RevType = '". $_POST['txteventrevtype'] ."',
						userAdded = '". $_SESSION['MMS-UserID'] ."',
						dateAdded = NOW(),
						proposalNum = '".$proposalNum."',
						confirmdate = '".date('Y-m-d', strtotime($_POST['txteventconfirmdate']))."';
				";
			}else{
				$newID2 = $_POST['lblSNo'];
				$sql = "
					UPDATE 
						event_header 
					SET
						eventName = '". mysql_real_escape_string($_POST['txteventname']) ."',
						startdate = '". date('Y-m-d', strtotime($_POST['txteventstartdate'])) ."',
						enddate = '". date('Y-m-d', strtotime($_POST['txteventenddate'])) ."',
						compCode = '". mysql_real_escape_string($_POST['txteventorganizer']) ."',
						confirmdate = '".date('Y-m-d', strtotime($_POST['txteventconfirmdate']))."',
						RevType = '". $_POST['txteventrevtype'] ."' WHERE inquiryid = '".$_POST['InquiryID'] ."' AND eventid = '".$newID2."' ;
				";
			}

			$res = mysql_query($sql, $connection) or die(mysql_error());

			if ( $res == true ) {

				if($_POST['lblSNo']==""){
					$arrHeader = ["Event ID", "Inquiry ID", "Event Name", "Organizer", "Start Date", "End Date", "RevType"];
					$arrValue = [$newID2, $_POST['InquiryID'], $_POST['txteventname'], $_POST['txteventorganizer'], $_POST['txteventstartdate'], $_POST['txteventenddate'], $_POST['txteventrevtype']];
					$tran_logs = create_logs_per_transaction("created a new events.", "Events Module", createXinfo("INSERT", $arrHeader, "", $arrValue, "", "", ""), "" ,"ADD", $InquiryID);
				}else{
					$arrHeader = ["Event ID", "Inquiry ID", "Event Name", "Organizer", "Start Date", "End Date", "RevType"];
					$arrValue = [$newID2, $_POST['InquiryID'], $_POST['txteventname'], $_POST['txteventorganizer'], $_POST['txteventstartdate'], $_POST['txteventenddate'], $_POST['txteventrevtype']];
					$tran_logs = create_logs_per_transaction("updated an events.", "Event Module", createXinfo("UPDATE", $arrHeader, "", $arrValue, "", "", ""), "" ,"UPDATE", $_POST['InquiryID']);
				}

				$ar_mainevents = json_decode($_POST['mainevents']);
				if( isset($ar_mainevents) || !empty($ar_mainevents) ){
					$delvis = mysql_query("DELETE FROM event_dayactivity WHERE eventid = '".$newID2."' ");
					foreach($ar_mainevents as  $itemsx ) {

						$arrdate =  explode("-", preg_replace('/[\s]+/', ' ', $itemsx->col1));
						$sql1 = "INSERT INTO event_dayactivity SET eventid = '".$newID2."',actTitle = '".mysql_real_escape_string($itemsx->col2)."',starttime = '".date('H:i:s',strtotime($itemsx->col3))."' ,endtime = '".date('H:i:s',strtotime($itemsx->col4))."', statdate = '".date('Y-m-d',strtotime($arrdate[0]))."', enddate = '".date('Y-m-d',strtotime($arrdate[1]))."' ";
						$res1 = mysql_query( $sql1 , $connection );
					}
				}
				$ar_facilities = json_decode($_POST['arreventsfacilities']);
				if( isset($ar_facilities) || !empty($ar_facilities) ){
					$delvis = mysql_query("DELETE FROM event_facilities WHERE eventid = '".$newID2."' ");
					foreach($ar_facilities as  $itemsx ) {

						$sql1 = "INSERT INTO event_facilities SET eventid = '".$newID2."',facilityID = '".$itemsx->col0."',facility ='".$itemsx->col1."',qty = '".$itemsx->col3."',facilityUnit = '".$itemsx->col4."',facilityRemarks = '".$itemsx->col7."',facilityprice = '".$itemsx->col2."', facilitytotal = '".$itemsx->col6."',vat = '".$itemsx->col5."' ";
						$res1 = mysql_query( $sql1 , $connection );
					}
				}
				$ar_sound = json_decode($_POST['arreventssound']);
				if( isset($ar_sound) || !empty($ar_sound) ){
					$delvis = mysql_query("DELETE FROM event_soundsystem WHERE eventid = '".$newID2."' ");
					foreach($ar_sound as  $itemsx ) {
						$datex = explode("-", preg_replace('/[\s]+/', ' ', $itemsx->col6));
						$sql1 = "INSERT INTO event_soundsystem SET eventid = '".$newID2."',pCode = '".$itemsx->col0."',pName = '".$itemsx->col1."',pqty = '".$itemsx->col2."',pprice = '".$itemsx->col3."',ptotprice = '".$itemsx->col5."',pstarttime = '".$itemsx->col7."', pendtime = '".$itemsx->col8."',pneeds = '".$itemsx->col9."',premarks = '".$itemsx->col10."', soundstartdate =  '".date('Y-m-d',strtotime($datex[0]))."' , soundenddate =  '".date('Y-m-d',strtotime($datex[1]))."',vat = '".$itemsx->col4."' ";
						$res1 = mysql_query( $sql1 , $connection );
					}
				}
				$ar_manpower = json_decode($_POST['arreventsmanpower']);
				if( isset($ar_manpower) || !empty($ar_manpower) ){
					$delvis = mysql_query("DELETE FROM event_manpower WHERE eventid = '".$newID2."' ");
					foreach($ar_manpower as  $itemsx ) {

						$datex = explode("-", preg_replace('/[\s]+/', ' ', $itemsx->col7));
						$sql1 = "INSERT INTO event_manpower SET eventid = '".$newID2."',manpowercode = '".$itemsx->col0."',manpower = '".$itemsx->col1."',pax = '".$itemsx->col2."',mprice = '".$itemsx->col4."',totprice = '".$itemsx->col6."',starttime = '".$itemsx->col8."', endtime = '".$itemsx->col9."',need = '".$itemsx->col10."',remarks = '".$itemsx->col11."', mpstartdate =  '".date('Y-m-d',strtotime($datex[0]))."' , mpenddate =  '".date('Y-m-d',strtotime($datex[1]))."',vat = '".$itemsx->col5."', qty = '".$itemsx->col3."' ";
						$res1 = mysql_query( $sql1 , $connection );
					}
				}
				$ar_organizer = json_decode($_POST['arreventsorganizer']);
				if( isset($ar_organizer) || !empty($ar_organizer) ){
					$delvis = mysql_query("DELETE FROM event_organizer WHERE eventid = '".$newID2."' ");
					foreach($ar_organizer as  $itemsx ) {

						$sql1 = "INSERT INTO event_organizer SET eventid = '".$newID2."',orgCode = '".$itemsx->col0."',orgName = '".$itemsx->col1."',orgQty = '".$itemsx->col2."',orgUnit = '".$itemsx->col3."',orgRemarks = '".$itemsx->col4."' ";
						$res1 = mysql_query( $sql1 , $connection );
					}
				}
				$ar_promotional = json_decode($_POST['arreventspromotional']);
				if( isset($ar_promotional) || !empty($ar_promotional) ){
					$delvis = mysql_query("DELETE FROM event_promotional WHERE eventid = '".$newID2."' ");
					foreach($ar_promotional as  $itemsx ) {

						$sql1 = "INSERT INTO event_promotional SET eventid = '".$newID2."',promotionalid = '".$itemsx->col0."',promotionaldesc = '".$itemsx->col1."',remarks = '".$itemsx->col2."' ";
						$res1 = mysql_query( $sql1 , $connection );
					}
				}
				$ar_require = json_decode($_POST['arreventsrequirements']);
				if( isset($ar_require) || !empty($ar_require) ){
					$delvis = mysql_query("DELETE FROM event_attachments WHERE eventid = '".$newID2."' ");
					foreach($ar_require as  $itemsx ) {

						$sql1 = "INSERT INTO event_attachments SET eventid = '".$newID2."',name = '".$itemsx->col3."',path = '".$itemsx->col5."',ext = '".$itemsx->col4."' ";
						$res1 = mysql_query( $sql1 , $connection );
					}
				}
			}
			echo $res."|".$newID2;
		break;

		case 'getnametbls':
			$rowrefs  = mysql_fetch_array(mysql_query("SELECT ".$_POST['aname']." FROM ".$_POST['tbl']." WHERE id = '".$_POST['id']."'  ",$connection));
			echo $rowrefs[0];
		break;

		case 'formdisplayevents':
			$json_response_list = array();
			$json_response = array();
			$daytoday = array();
			$facilities = array();
			$soundner = array();
			$manpower = array();
			$organizer = array();
			$promotional = array();
			$requirements = array();


			$chckpros = mysql_fetch_array(mysql_query("SELECT eventid,eventName,RevType,userAdded,compCode,startdate,enddate,x_date,confirmdate FROM event_header WHERE inquiryid = '".$_POST['InquiryID']."' AND proposalNum = '".$_POST['proposalNum']."' ",$connection));
			if($chckpros[0]!=""){
				$propx = " AND proposalNum = '".$_POST['proposalNum']."' ";
			}else{
				$propx = "";
			}
			$sql = "SELECT eventid,eventName,RevType,userAdded,compCode,startdate,enddate,x_date,confirmdate FROM event_header WHERE inquiryid = '".$_POST['InquiryID']."'  ".$propx;
			//echo $sql;
			$result = mysql_query($sql,$connection) or die(mysql_error());
			$row = mysql_fetch_array($result);
				$json_response['eventid'] = $row['eventid'];
				$json_response['eventname'] = $row['eventName'];
				$json_response['RevType'] = $row['RevType'];
				$json_response['compCode'] = $row['compCode'];
				$json_response['startdate'] = date('m/d/Y',strtotime($row['startdate']));
				$json_response['enddate'] =  date('m/d/Y',strtotime($row['enddate']));
				$json_response['x_date'] = $row['x_date'];
				$json_response['confirmdate'] = date('m/d/Y',strtotime($row['confirmdate']));
				$user = mysql_fetch_array(mysql_query("SELECT CONCAT(lastname,', ',firstname) as fullname FROM tbluser WHERE userid = '".$row['userAdded']."' ",$connection));
				$json_response['userAdded'] = $user[0];

				$json_response['daytoday'] = array();
				$sqlday = mysql_query("SELECT actTitle,starttime,endtime,statdate,enddate FROM event_dayactivity WHERE eventid = '".$row['eventid']."' ORDER BY id ASC ",$connection);
				while ($rowday = mysql_fetch_array($sqlday)) {
					$daytoday['acts'] = $rowday['actTitle'];
					$daytoday['lows'] = "asd ooosd aoasodas";
					$daytoday['durationx'] = date('m/d/Y',strtotime($rowday['statdate']))." - ".date('m/d/Y',strtotime($rowday['enddate']));
					$daytoday['starttime'] = date('h:i A',strtotime($rowday['starttime']));
					$daytoday['endtime'] = date('h:i A',strtotime($rowday['endtime']));
					array_push($json_response['daytoday'],$daytoday);	
				}
				$json_response['facilities'] = array();
				$sqlday = mysql_query("SELECT facilityID,facility,qty,facilityUnit,facilityRemarks,facilityprice,facilitytotal,vat FROM event_facilities WHERE eventid = '".$row['eventid']."' ORDER BY id ASC ",$connection);
				while ($rowday = mysql_fetch_array($sqlday)) {
					$facilities['facilityID'] = $rowday['facilityID'];
					$facilities['facility'] = $rowday['facility'];
					$facilities['qty'] = $rowday['qty'];
					$facilities['facilityUnit'] = $rowday['facilityUnit'];
					$facilities['facilityRemarks'] = $rowday['facilityRemarks'];
					$facilities['facilityprice'] = number_format($rowday['facilityprice'],2);
					$facilities['vat'] = number_format($rowday['vat'],2);
					$facilities['facilitytotal'] = number_format($rowday['facilitytotal'],2);
					array_push($json_response['facilities'],$facilities);	
				}
				$json_response['soundner'] = array();
				$sqlday = mysql_query("SELECT pCode,pName,pprice,pqty,ptotprice,pstarttime,pendtime,pneeds,premarks,soundenddate,soundstartdate,vat FROM event_soundsystem WHERE eventid = '".$row['eventid']."' ORDER BY id ASC ",$connection);
				while ($rowday = mysql_fetch_array($sqlday)) {
					$soundner['pCode'] = $rowday['pCode'];
					$soundner['pName'] = $rowday['pName'];
					$soundner['pqty'] = $rowday['pqty'];
					$soundner['pstarttime'] = $rowday['pstarttime'];
					$soundner['pendtime'] = $rowday['pendtime'];
					$soundner['pneeds'] = $rowday['pneeds'];
					$soundner['premarks'] = $rowday['premarks'];
					$soundner['datex'] = date('m/d/Y',strtotime($rowday['soundstartdate']))." - ".date('m/d/Y',strtotime($rowday['soundenddate']));
					$soundner['ptotprice'] = number_format($rowday['ptotprice'],2);
					$soundner['pprice'] = number_format($rowday['pprice'],2);
					$soundner['vat'] = number_format($rowday['vat'],2);
					array_push($json_response['soundner'],$soundner);	
				}
				$json_response['manpower'] = array();
				$sqlday = mysql_query("SELECT manpowercode,manpower,pax,mprice,totprice,starttime,endtime,need,remarks,mpenddate,mpstartdate,vat,qty FROM event_manpower WHERE eventid = '".$row['eventid']."' ORDER BY id ASC ",$connection);
				while ($rowday = mysql_fetch_array($sqlday)) {
					$manpower['manpowercode'] = $rowday['manpowercode'];
					$manpower['qty'] = $rowday['qty'];
					$manpower['manpower'] = $rowday['manpower'];
					$manpower['pax'] = $rowday['pax'];
					$manpower['starttime'] = $rowday['starttime'];
					$manpower['endtime'] = $rowday['endtime'];
					$manpower['need'] = $rowday['need'];
					$manpower['remarks'] = $rowday['remarks'];
					$manpower['datex'] = date('m/d/Y',strtotime($rowday['mpstartdate']))." - ".date('m/d/Y',strtotime($rowday['mpenddate']));
					$manpower['mprice'] = number_format($rowday['mprice'],2);
					$manpower['totprice'] = number_format($rowday['totprice'],2);
					$manpower['vat'] = number_format($rowday['vat'],2);
					array_push($json_response['manpower'],$manpower);	
				}
				$json_response['organizer'] = array();
				$sqlday = mysql_query("SELECT orgCode,orgName,orgQty,orgUnit,orgRemarks  FROM event_organizer WHERE eventid = '".$row['eventid']."' ORDER BY id ASC ",$connection);
				while ($rowday = mysql_fetch_array($sqlday)) {
					$organizer['orgCode'] = $rowday['orgCode'];
					$organizer['orgName'] = $rowday['orgName'];
					$organizer['orgQty'] = $rowday['orgQty'];
					$organizer['orgUnit'] = $rowday['orgUnit'];
					$organizer['orgRemarks'] = $rowday['orgRemarks'];
					array_push($json_response['organizer'],$organizer);	
				}
				$json_response['promotional'] = array();
				$sqlday = mysql_query("SELECT promotionalid,promotionaldesc,remarks  FROM event_promotional WHERE eventid = '".$row['eventid']."' ORDER BY id ASC ",$connection);
				while ($rowday = mysql_fetch_array($sqlday)) {
					$promotional['promotionalid'] = $rowday['promotionalid'];
					$promotional['promotionaldesc'] = $rowday['promotionaldesc'];
					$promotional['remarks'] = $rowday['remarks'];
					array_push($json_response['promotional'],$promotional);	
				}
				$json_response['requirements'] = array();
				$sqlday = mysql_query("SELECT id,name,path,ext  FROM event_attachments WHERE eventid = '".$row['eventid']."' ORDER BY id ASC ",$connection);
				while ($rowday = mysql_fetch_array($sqlday)) {
					$requirements['id'] = $rowday['id'];
					$name = explode("-@@-", $rowday['name']);
					$requirements['name'] = $name[1];
					$requirements['path'] = $rowday['path'];
					$requirements['fullname'] = $rowday['name'];
					$requirements['ext'] = $rowday['ext'];
					array_push($json_response['requirements'],$requirements);	
				}

				array_push($json_response_list,$json_response);	
			

			$jsonData = json_encode($json_response_list); //JSON_PRETTY_PRINT
			echo $jsonData; 
		break;

		case 'fncLoadUnitevents':
			if($_POST['proposalNum']==""){
				$pros = mysql_fetch_array(mysql_query("SELECT ActiveProposal FROM tbltrans_inquiry WHERE Inquiry_ID = '".$_POST['InquiryID']."' ",$connection));
				$proposalNum = $pros[0];
			}else{
				$proposalNum = $_POST['proposalNum'];
			}
			if($proposalNum == 0){
				$proposalNum = 1;
			}
			$getunitdetails = mysql_fetch_array(mysql_query("SELECT proposalNum,monthlyDues,desiredDays FROM tbltrans_proposal  WHERE inquiryID = '".$_POST['InquiryID']."' AND proposalNum = '".$proposalNum."' "));


			$resgetUnitIDs = mysql_query("SELECT UnitID FROM tbltrans_proposal_unit WHERE InquiryID = '". $_POST['InquiryID'] ."' AND proposalNum = '". $getunitdetails[0] ."';", $connection);
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

					if(SysLeaseSetup('floorandunitmeasurement') == "Area"){
                    	$TotalArea = $rowUnitList['area'];
                    }else{
                    	$TotalArea = floatval($rowUnitList['sqm_height'] * $rowUnitList['sqm_width']);
                	}
	                    	
                	$UnitRent = $TotalArea * $rowUnitList['pricepersqmunitsetup'];
                	
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



		case 'loadtotalamountunits':

			if($_POST['proposalNum']==""){
				$pros = mysql_fetch_array(mysql_query("SELECT ActiveProposal FROM tbltrans_inquiry WHERE Inquiry_ID = '".$_POST['InquiryID']."' ",$connection));
				$proposalNum = $pros[0];
			}else{
				$proposalNum = $_POST['proposalNum'];
			}
			if($proposalNum == 0){
				$proposalNum = 1;
			}
			$getunitdetails = mysql_fetch_array(mysql_query("SELECT proposalNum,monthlyDues,desiredDays,vatpercent FROM tbltrans_proposal  WHERE inquiryID = '".$_POST['InquiryID']."' AND proposalNum = '".$proposalNum."' ",$connection));
			
			if($getunitdetails['desiredDays']==0){
				$getunitdetails['desiredDays'] = 1;
			}
			$vat =  ($getunitdetails['desiredDays'] * $getunitdetails['monthlyDues']) * ($getunitdetails['vatpercent'] / 100);
			$totalmonth = $getunitdetails['monthlyDues'] + $vat;
			$totals = $totalmonth * $getunitdetails['desiredDays'];
			echo number_format($totalmonth,2)."|".$getunitdetails['desiredDays']."|".number_format($totals,2);
		break;


		case 'printableevents':
			
			$unittotalsx = "";
			if($_POST['proposalNum']==""){
				$pros = mysql_fetch_array(mysql_query("SELECT ActiveProposal FROM tbltrans_inquiry WHERE Inquiry_ID = '".$_POST['InquiryID']."' ",$connection));
				$proposalNum = $pros[0];
			}else{
				$proposalNum = $_POST['proposalNum'];
			}
			if($proposalNum == 0){
				$proposalNum = 1;
			}

			$unittotalsx = "";
			$chckprosnum = mysql_fetch_array(mysql_query("SELECT proposalNum,monthlyDues,vatpercent,desiredDays,userid,1st_app FROM tbltrans_proposal  WHERE inquiryID = '".$_POST['InquiryID']."' AND proposalNum = '".$proposalNum."' ",$connection));
			if($chckprosnum['desiredDays']==0){
				$chckprosnum['desiredDays'] = 1;
			}
			
			$vat = ($chckprosnum['monthlyDues'] * $chckprosnum['desiredDays']) * ($chckprosnum['vatpercent'] / 100);
			$totalmonth = $chckprosnum['monthlyDues'];
			$totals = ($totalmonth * $chckprosnum['desiredDays']) + $vat;
			$events = mysql_fetch_array(mysql_query("SELECT eventid,eventName,startdate,enddate,compCode FROM event_header WHERE inquiryid = '".$_POST['InquiryID']."' AND eventid = '".$_POST['eventsid']."' "));
			$compname = mysql_fetch_array(mysql_query("SELECT Company FROM tbltrans_company WHERE CompanyID = '".$events['compCode']."' ",$connection));
			$res = mysql_query("SELECT facilityID,facility,qty,facilityUnit,facilityRemarks,facilityprice,facilitytotal,vat FROM event_facilities WHERE eventid = '".$events[0]."' ", $connection);
			$searchmallid = mysql_fetch_array(mysql_query("SELECT a.Mall_ID,b.mallname FROM tbltrans_inquiry a,tblref_mall b WHERE a.Mall_ID = b.mallid AND  a.Inquiry_ID = '".$_POST['InquiryID']."' ",$connection));
			$totalfacility = mysql_fetch_array(mysql_query("SELECT SUM(facilitytotal) as tot FROM event_facilities WHERE eventid = '".$events[0]."'",$connection));
			$totalsound = mysql_fetch_array(mysql_query("SELECT SUM(ptotprice) as tot FROM event_soundsystem WHERE eventid = '".$events[0]."'",$connection));
			$totalmanpower = mysql_fetch_array(mysql_query("SELECT SUM(totprice) as tot FROM event_soundsystem WHERE eventid = '".$events[0]."'",$connection));
			$grandtotal = $totals + $totalmanpower[0] + $totalsound[0] + $totalfacility[0];
				?>

			
				<table style='width:100%;'>
					<tr>
						<td><h4><b><?php echo $searchmallid['mallname']; ?></b></h4></td>
					</tr>
					<tr>
						<td><b>Event Package Breakdown Report</b></td>
					</tr>
				</table>
				<br>
				<table style='width:100%;'>
					<tr>
						<td>Name Of Event:</td>
						<td><b><?php echo ucfirst($events['eventName']);  ?></b></td>
						<td>Event No:</td>
						<td><b><?php echo $events['eventid'];  ?></b></td>
					</tr>
					<tr>
						<td>Organizer:</td>
						<td><b><?php echo $compname['Company'];  ?></b></td>
						<td>Date:</td>
						<td><b><?php echo date('m/d/Y',strtotime($events['startdate']))." - ".date('m/d/Y',strtotime($events['enddate']));  ?></b></td>
					</tr>
				</table><br/>


				<h4><b>GRAND TOTAL: <span style="color: red"><?php echo number_format($grandtotal,2); ?></span></b></h4>


				<b>SERVICES & FACILITIES</b>
				<table style='width:100%;'>
					<tr>
						<td id='hr'> </td>
					</tr>
				</table><br/>
				<table  style='width: 100%;' cellspacing='0' cellpadding='0'>
					<thead>
						<th style="border: 1px solid black; text-align: center; color: white; padding:3px !important;"> Facility/Service </th>
						<th style="border: 1px solid black; text-align: right; color: white; padding:5px !important;"> Price </th>
						<th style="border: 1px solid black; text-align: center; color: white; padding:3px !important;"> Qty </th>
						<th style="border: 1px solid black; text-align: center; color: white; padding:3px !important;"> Unit </th>
						<th style="border: 1px solid black; text-align: right; color: white; padding:3px !important;"> VAT </th>
						<th style="border: 1px solid black; text-align: right; color: white; padding:3px !important;"> Total Price </th>
						<th style="border: 1px solid black; text-align: center; color: white; padding:5px !important;"> Remarks </th>
					</thead>
					<tbody>
						
				<?php
				while($row = mysql_fetch_array($res)){
					$factotals += $row['facilitytotal'];
					?>
					<tr id='<?php echo $row[0]; ?>'>
						<td style="border: 1px solid black; padding:5px;"><?php echo $row['facility']; ?></td>
						<td style="border: 1px solid black; padding:5px;text-align: right;"><?php echo number_format($row['facilityprice'],2); ?></td>
						<td style="border: 1px solid black; padding:5px;text-align: center;"><?php echo $row['qty']; ?></td>
						<td style="border: 1px solid black; padding:5px;text-align: center;"><?php echo $row['facilityUnit']; ?></td>
						<td style="border: 1px solid black; padding:5px;text-align: right;"><?php echo number_format($row['vat'],2); ?></td>
						<td style="border: 1px solid black; padding:5px;text-align: right;"><?php echo number_format($row['facilitytotal'],2); ?></td>
						<td style="border: 1px solid black; padding:5px;"><?php echo $row['facilityRemarks']; ?></td>
					</tr>
					<?php
				}
				?></tbody></table>
					<p style="text-align: right;margin-top: 5px">
						<b> Subtotal: <?php echo number_format($factotals,2); ?></b>
					</p>
				<?php
			
				$ressound = mysql_query("SELECT pCode,pName,pqty,pprice,ptotprice,premarks,vat FROM event_soundsystem WHERE eventid = '".$events[0]."' ", $connection);
				?>  
				<style type="text/css">
					#hr{
						background: black !important; padding:2px;
					}
				</style>

				<b>SOUND SYSTEM PERSONNEL</b>
				<table style='width:100%;'>
					<tr>
						<td id='hr'> </td>
					</tr>
				</table><br/>
				<table  style='width: 100%;' cellspacing='0' cellpadding='0'>
					<thead>
						<th style="border: 1px solid black; text-align: center; color: white; padding:3px !important;"> Personnel </th>
						<th style="border: 1px solid black; text-align: right; color: white; padding:5px !important;"> Price </th>
						<th style="border: 1px solid black; text-align: center; color: white; padding:3px !important;"> Qty </th>
						<th style="border: 1px solid black; text-align: center; color: white; padding:3px !important;"> Unit </th>
						<th style="border: 1px solid black; text-align: right; color: white; padding:3px !important;"> VAT </th>
						<th style="border: 1px solid black; text-align: right; color: white; padding:3px !important;"> Total Price </th>
						<th style="border: 1px solid black; text-align: center; color: white; padding:5px !important;"> Remarks </th>
					</thead>
					<tbody>
						
				<?php
				while($rowsound = mysql_fetch_array($ressound)){
					$soundtotals += $rowsound['pprice'];
					?>
					<tr id='<?php echo $rowsound[0]; ?>'>
						<td style="border: 1px solid black; padding:5px;"><?php echo $rowsound['pName']; ?></td>
						<td style="border: 1px solid black; padding:5px;text-align: right;"><?php echo number_format($rowsound['pprice'],2); ?></td>
						<td style="border: 1px solid black; padding:5px;text-align: center;"><?php echo $rowsound['pqty']; ?></td>
						<td style="border: 1px solid black; padding:5px;text-align: center;"></td>
						<td style="border: 1px solid black; padding:5px;text-align: right;"><?php echo number_format($rowsound['vat'],2); ?></td>
						<td style="border: 1px solid black; padding:5px;text-align: right;"><?php echo number_format($rowsound['ptotprice'],2); ?></td>
						<td style="border: 1px solid black; padding:5px;"><?php echo $rowsound['premarks']; ?></td>
					</tr>
					<?php
				}
				?></tbody></table>
					<p style="text-align: right;margin-top: 5px">
						<b> Subtotal: <?php echo number_format($soundtotals,2); ?></b>
					</p>
				<?php

				$resmanpower = mysql_query("SELECT manpowercode,manpower,pax,mprice,totprice,remarks,vat,qty FROM event_manpower WHERE eventID = '".$events[0]."' ", $connection);
				?>  
				<b>MANPOWER</b>
				<table style='width:100%;'>
					<tr>
						<td id='hr'> </td>
					</tr>
				</table><br/>
				<table  style='width: 100%;' cellspacing='0' cellpadding='0'>
					<thead>
						<th style="border: 1px solid black; text-align: center; color: white; padding:3px !important;"> Manpower </th>
						<th style="border: 1px solid black; text-align: right; color: white; padding:5px !important;"> Price </th>
						<th style="border: 1px solid black; text-align: center; color: white; padding:3px !important;"> Qty </th>
						<th style="border: 1px solid black; text-align: center; color: white; padding:3px !important;"> Pax </th>
						<th style="border: 1px solid black; text-align: right; color: white; padding:3px !important;"> VAT </th>
						<th style="border: 1px solid black; text-align: right; color: white; padding:3px !important;"> Total Price </th>
						<th style="border: 1px solid black; text-align: center; color: white; padding:5px !important;"> Remarks </th>
					</thead>
					<tbody>
						
				<?php
				while($rowmanpower = mysql_fetch_array($resmanpower)){
					$manpowertotals += $rowmanpower['mprice'];
					?>
					<tr id='<?php echo $rowmanpower['manpowercode']; ?>'>
						<td style="border: 1px solid black; padding:5px;"><?php echo $rowmanpower['manpower']; ?></td>
						<td style="border: 1px solid black; padding:5px;text-align: right;"><?php echo number_format($rowmanpower['mprice'],2); ?></td>
						<td style="border: 1px solid black; padding:5px;text-align: center;"><?php echo $rowmanpower['qty']; ?></td>
						<td style="border: 1px solid black; padding:5px;text-align: center;"><?php echo $rowmanpower['pax']; ?></td>
						<td style="border: 1px solid black; padding:5px;text-align: right;"><?php echo number_format($rowmanpower['vat'],2); ?></td>
						<td style="border: 1px solid black; padding:5px;text-align: right;"><?php echo number_format($rowmanpower['totprice'],2); ?></td>
						<td style="border: 1px solid black; padding:5px;"><?php echo $rowm0anpower['remarks']; ?></td>
					</tr>
					<?php
				}
				?></tbody></table>
					<p style="text-align: right;margin-top: 5px">
						<b> Subtotal: <?php echo number_format($manpowertotals,2); ?></b>
					</p>
				<?php

				$resunit = mysql_query("SELECT a.UnitID,b.unitname FROM tbltrans_proposal_unit a,tblref_unit b  WHERE a.UnitID = b.unitid AND a.InquiryID = '". $_POST['InquiryID'] ."' AND a.proposalNum = '". $chckprosnum['proposalNum'] ."';", $connection);

				?>  

				<b>VENUE RENTAL</b>
				<table style='width:100%;'>
					<tr>
						<td id='hr'> </td>
					</tr>
				</table><br/>
				<table  style='width: 100%;' cellspacing='0' cellpadding='0'>
					<thead>
						<th style="border: 1px solid black; text-align: center; color: white; padding:3px !important;"> Unit Name </th>
						<th style="border: 1px solid black; text-align: right; color: white; padding:5px !important;"> Rate </th>
						<th style="border: 1px solid black; text-align: center; color: white; padding:3px !important;"> No. Of Days </th>
						<th style="border: 1px solid black; text-align: right; color: white; padding:3px !important;"> VAT </th>
						<th style="border: 1px solid black; text-align: right; color: white; padding:3px !important;"> Total Price </th>
					</thead>
					<tbody>
						
				<?php
				while($rowunitx = mysql_fetch_array($resunit)){		
					$unitnamex .= $unitname['unitname'].", ";
				}
				$vat = ($chckprosnum['monthlyDues'] * $chckprosnum['desiredDays']) * ($chckprosnum['vatpercent'] / 100);
				$totalmonth = $chckprosnum['monthlyDues'];
				$totals = ($totalmonth * $chckprosnum['desiredDays']) + $vat;

				?>
					<tr id='<?php echo $rowunitx['manpowercode']; ?>'>
						<td style="border: 1px solid black; padding:5px;"><?php echo substr_replace($unitnamex ,"", -2); ?></td>
						<td style="border: 1px solid black; padding:5px;text-align: right;"><?php echo number_format($chckprosnum['monthlyDues'],2); ?></td>
						<td style="border: 1px solid black; padding:5px;text-align: center;"><?php echo  $chckprosnum['desiredDays']." day(s)"; ?></td>
						<td style="border: 1px solid black; padding:5px;text-align: right;"><?php echo number_format($vat,2); ?></td>
						<td style="border: 1px solid black; padding:5px;text-align: right;"><?php echo number_format($totals,2); ?></td>
					</tr>
				</tbody></table>
					<p style="text-align: right;margin-top: 5px">
						<b> Subtotal: <?php echo number_format($totals,2); ?></b>
					</p>
				<?php
		break;


		case 'newprintevents':
			
			if($_POST['proposalNum']==""){
				$pros = mysql_fetch_array(mysql_query("SELECT ActiveProposal FROM tbltrans_inquiry WHERE Inquiry_ID = '".$_POST['InquiryID']."' ",$connection));
				$proposalNum = $pros[0];
			}else{
				$proposalNum = $_POST['proposalNum'];
			}
			if($proposalNum == 0){
				$proposalNum = 1;
			}

			$unittotalsx = "";
			$chckprosnum = mysql_fetch_array(mysql_query("SELECT proposalNum,monthlyDues,vatpercent,desiredDays,userid,1st_app FROM tbltrans_proposal  WHERE inquiryID = '".$_POST['InquiryID']."' AND proposalNum = '".$proposalNum."' "));
			$resunit = mysql_query("SELECT a.UnitID FROM tbltrans_proposal_unit a,tbltrans_proposal b WHERE a.inquiryID = b.InquiryID AND a.inquiryID = '".$_POST['InquiryID']."'  AND a.ProposalNum = '".$chckprosnum['proposalNum']."' ", $connection);
			while($rowunitx = mysql_fetch_array($resunit)){
					$unitname = mysql_fetch_array(mysql_query("SELECT unitname FROM tblref_unit WHERE unitid = '".$rowunitx['UnitID']."' ",$connection));
					$thisunittotal += $chckprosnum['monthlyDues'];
					
			}
			if($chckprosnum['desiredDays']==0){
				$chckprosnum['desiredDays'] = 1;
			}
			$vat = ($chckprosnum['monthlyDues'] * $chckprosnum['desiredDays']) * ($chckprosnum['vatpercent'] / 100);
			$unittotalsx = ($chckprosnum['monthlyDues'] * $chckprosnum['desiredDays']) + $vat;
			$Inquiry = mysql_fetch_array(mysql_query("SELECT Mall,BillerID,Mall_ID FROM tbltrans_inquiry WHERE Inquiry_ID = '".$_POST['InquiryID']."' ",$connection));
			$getmallsetup = mysql_fetch_array(mysql_query("SELECT eventsnotedbyid FROM mall_setup WHERE mall_id = '".$Inquiry['Mall_ID']."' ",$connection));
			$events = mysql_fetch_array(mysql_query("SELECT eventid,eventName,startdate,enddate,compCode,notedbyid,confirmdate,dateAdded FROM event_header WHERE eventid = '".$_POST['eventsid']."' "));
			$compname = mysql_fetch_array(mysql_query("SELECT Company FROM tbltrans_company WHERE CompanyID = '".$events['compCode']."' ",$connection));
			$res = mysql_query("SELECT facilityID,facility,qty,facilityUnit,facilityRemarks,facilityprice,facilitytotal,vat FROM event_facilities WHERE eventid = '".$events[0]."' ", $connection);
			$searchmallid = mysql_fetch_array(mysql_query("SELECT a.Mall_ID,b.mallname FROM tbltrans_inquiry a,tblref_mall b WHERE a.Mall_ID = b.mallid AND  a.Inquiry_ID = '".$_POST['InquiryID']."' ",$connection));
			$totalfacility = mysql_fetch_array(mysql_query("SELECT SUM(facilitytotal) as tot FROM event_facilities WHERE eventid = '".$events[0]."'"));
			$totalsound = mysql_fetch_array(mysql_query("SELECT SUM(ptotprice) as tot FROM event_soundsystem WHERE eventid = '".$events[0]."'"));
			$totalmanpower = mysql_fetch_array(mysql_query("SELECT SUM(totprice) as tot FROM event_manpower WHERE eventid = '".$events[0]."'"));
			$grandtotal = $unittotalsx + $totalmanpower[0] + $totalsound[0] + $totalfacility[0];

		
			$eventsdate = checkdateformat($events['startdate'],$events['enddate']);
			$sqlday = mysql_query("SELECT actTitle,starttime,endtime,statdate,enddate FROM event_dayactivity WHERE eventid = '".$events['eventid']."' ORDER BY id ASC ",$connection);
			while ($rowday = mysql_fetch_array($sqlday)) {
				$daytoday .= " ".date('h:i A',strtotime($rowday['starttime']))." To ".date('h:i A',strtotime($rowday['endtime']))." (".checkdateformat($rowday['statdate'],$rowday['enddate']).") &";
			}
			$daytoday = substr_replace($daytoday ,"", -1);
			$createdby = mysql_fetch_array(mysql_query("SELECT a.firstname,a.lastname,LEFT(a.middlename,1)  as mname,b.groupname,a.contactnumber FROM tbluser a,tblref_groupaccess b WHERE a.groupaccess = b.groupid AND  a.userid = '".$chckprosnum['userid']."' AND  a.groupaccess = b.groupid  ",$connection));
			$approved1 = mysql_fetch_array(mysql_query("SELECT a.firstname,a.lastname,LEFT(a.middlename,1)  as mname,b.groupname FROM tbluser a,tblref_groupaccess b WHERE  a.groupaccess = b.groupid AND a.userid = '".$chckprosnum['1st_app']."' AND  a.groupaccess = b.groupid  ",$connection));
			$conforme = mysql_fetch_array(mysql_query("SELECT a.firstname,a.lastname,LEFT(a.middlename,1)  as mname,b.groupname FROM tbluser a,tblref_groupaccess b WHERE a.groupaccess = b.groupid AND a.userid = '".$chckprosnum['1st_app']."' AND  a.groupaccess = b.groupid  ",$connection));

			$mallinfo = mysql_fetch_array(mysql_query("SELECT malladdress,email,telephone_number FROM tblref_mall WHERE mallid = '".$Inquiry['Mall_ID']."' ",$connection));
			$billprof = mysql_fetch_array(mysql_query("SELECT a.BillerName,a.BillingAddress,b.name,b.designation,b.Conlname FROM tblref_billprofile a,tbltrans_company_contact_person b WHERE a.BillerID = '".$Inquiry['BillerID']."' AND  a.BillerID = b.ConID AND b.isActive = 1 AND b.isPrimary = 1;" ,$connection));

			$sqlday = mysql_query("SELECT facilityID,facility,qty,facilityUnit,facilityRemarks,facilityprice,facilitytotal,vat FROM event_facilities WHERE eventid = '".$events['eventid']."' ORDER BY id ASC ",$connection);
			$facility = ""; 
			while ($rowday = mysql_fetch_array($sqlday)) {
				$facility .= "<li style='float: left; list-style: outside none none; width: 50%;'> ".$rowday['qty']." ".ucfirst($rowday['facility'])." </li>";
			}
			$sqlday = mysql_query("SELECT pCode,pName,pprice,pqty,ptotprice,pstarttime,pendtime,pneeds,premarks,soundenddate,soundstartdate,vat FROM event_soundsystem WHERE eventid = '".$events['eventid']."' ORDER BY id ASC ",$connection);
			$sound = "";
			while ($rowday = mysql_fetch_array($sqlday)) {
				$sound .= "<li style='float: left; list-style: outside none none; width: 50%;'> ".$rowday['pqty']." ".ucfirst($rowday['pName'])." - ".$rowday['pneeds']."</li>";
			}
			$sqlday = mysql_query("SELECT manpowercode,manpower,pax,mprice,totprice,starttime,endtime,need,remarks,mpenddate,mpstartdate,vat,qty FROM event_manpower WHERE eventid = '".$events['eventid']."' ORDER BY id ASC ",$connection);
			$manpower = "";
			while ($rowday = mysql_fetch_array($sqlday)) {
				$manpower .= "<li style='float: left; list-style: outside none none; width: 50%;'> ".$rowday['pax']." ".ucfirst($rowday['manpower'])." - ".$rowday['need']."</li>";
			}


			$resgetUnitIDs = mysql_query("SELECT a.UnitID,b.unitname FROM tbltrans_proposal_unit a,tblref_unit b  WHERE a.UnitID = b.unitid AND a.InquiryID = '". $_POST['InquiryID'] ."' AND a.proposalNum = '". $chckprosnum['proposalNum'] ."';", $connection);

			while($rowUnitIDs = mysql_fetch_array($resgetUnitIDs)){
				$UnitIDArr .= $rowUnitIDs['unitname'].", ";
			}

			$remarks = "";
			$sqlremarks = "SELECT xremarks FROM tbltrans_remarks WHERE xsource = 'events' AND inqID = '".$_POST['InquiryID']."' AND sourceid = '".$_POST['eventsid']."' ";
			$resremarks = mysql_query($sqlremarks,$connection);
			while ($rowremarks = mysql_fetch_array($resremarks)) {
				$remarks .= "<p><b>".ucfirst($rowremarks['xremarks'])."</b></p>";
			}


			if($events['notedbyid']==""){
				$eventsnoted = mysql_fetch_array(mysql_query("SELECT CONCAT(a.firstname,' ',LEFT(a.middlename,1),'. ',a.lastname) as fullname,a.userid,b.groupname FROM tbluser a,tblref_groupaccess b WHERE a.groupaccess = b.groupid AND a.userid  = '".$getmallsetup['eventsnotedbyid']."' ",$connection));
					$notedxby = $eventsnoted['fullname'];
					$posxby =   $eventsnoted['groupname'];				
			}else{
				$eventsnoted = mysql_fetch_array(mysql_query("SELECT CONCAT(a.firstname,' ',LEFT(a.middlename,1),'. ',a.lastname) as fullname,a.userid,b.groupname FROM tbluser a,tblref_groupaccess b WHERE a.groupaccess = b.groupid AND a.userid = '".$events['notedbyid']."' ",$connection));
				$notedxby = $eventsnoted['fullname'];
				$posxby =  $eventsnoted['groupname'];

			}

			?>
			<div style="font-size: 9pt;font-family:'arial'">
			<p><b><?php echo date('F d, Y',strtotime($events['dateAdded'])); ?></b></p>
			<br>
			<p>
				<b><?php echo $billprof ['name']; ?> </b><br>
				<b><?php echo $billprof ['designation']; ?> </b><br>
				<b><?php echo $billprof ['BillerName']; ?> </b><br>
			</p>
			<p>Dear Mr. / Ms. <?php echo $billprof ['Conlname']; ?> :</p>
			<p>Greetings from your homegrown Mall!</p>
			<p style="text-align: justify;">Thank you for your interest to have your event “<b><?php echo ucfirst($events['eventName']); ?></b>” on <b><?php echo $eventsdate; ?></b> from <b><?php echo $daytoday; ?></b> at <span><?php echo $Inquiry['Mall']; ?></span>.</p>
			<span>Please find quotation below: </span>
			<table  style="width: 100%;font-size: 9pt;font-family:'arial'" cellspacing='0' cellpadding='0'>
				<thead>
					<tr>
						<th style="border: 1px solid black; text-align: center; color: ; padding:3px !important;color: black !important"> LOCATION </th>
						<th style="border: 1px solid black; text-align: center; color: ; padding:5px !important;color: black !important"> AREA (sqm) </th>
						<th style="border: 1px solid black; text-align: center; color: ; padding:3px !important;color: black !important"> PACKAGE RATE (with VAT) </th>
						<th style="border: 1px solid black; text-align: center; color: white; padding:3px !important;color: black !important"> REMARKS </th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td style="border: 1px solid black; text-align: center; color: white; padding:3px !important;">
							<b><?php echo $UnitIDArr; ?></b>
						</td>
						<td style="border: 1px solid black; text-align: center; color: white; padding:3px !important;">
							<b>872.85sqm</b>
						</td>
						<?php 

							$vat = $grandtotal * (12/100);
							$amount = $grandtotal - $vat;

						?>
						<td style="border: 1px solid black; text-align: left; color: white; padding:3px !important;">
							<span>Amount:   Php  <?php echo number_format($amount,2); ?></span><br>
							<span><u>12% Vat:  Php    <?php echo number_format($vat,2); ?></u></span><br>
							<span><b>TOTAL:   Php <?php echo number_format($grandtotal,2); ?></b></span>
						</td>
						<td style="border: 1px solid black; text-align: left; color: white; padding:3px !important;">
							<?php echo $remarks; ?>
						</td>
					</tr>
					<tr>
						<td colspan="4" style="border: 1px solid black; padding:3px !important;">
							<b style="text-decoration: underline;">Inclusive of the following:</b><br>
							<ul style="display: inline-block;">
								<?php 
									echo $facility.$sound.$manpower;
								?>
							</ul>
						</td>
					</tr>
				</tbody>
			</table>
			<p style="text-align: justify;font-family: 'arial';font-size: 9pt ">Should you find the above proposal agreeable, kindly fax or send this letter to us with your signature on the space provided on or before <?php echo date("F d, Y",strtotime($events['confirmdate'])); ?>. Failure to respond on the said date will lead to CANCELLATION of your reserved booking. </p>
			<table style="margin-left: 50px;font-size: 9pt;font-family:'arial'">
				<tr>
					<td style="text-align: left;padding: 5px"><b>FAX NUMBER</b></td>
					<td><b>: NA</b></td>
				</tr>
				<tr>
					<td style="text-align: left;padding: 5px"><b>EMAIL ADDRESS</b></td>
					<td><b>: <?php echo $mallinfo['email']; ?></b></td>
				</tr>
				<tr>
					<td style="text-align: left;padding: 5px"><b>OFFICE ADDRESS</b></td>
					<td><b>: <?php echo $mallinfo['malladdress']; ?> </b></td>
				</tr>
			</table>
			<p style="text-align: justify;font-family: 'arial';font-size: 9pt">After your confirmation, we shall then proceed with the preparation of our Memorandum of Agreement. Should you need further assistance, the undersigned may be reached at the following contact numbers: <b><?php echo $mallinfo['telephone_number']; ?>  </b> or at  mobile no.  <b><?php echo $createdby['contactnumber']; ?></b>.</p>
			<br><br>
			<table style="width: 100%;font-size: 9pt;font-family:'arial'">
				<tr>
					<td style="width: 50%">
						<p><b>Very Truly Yours:</b></p><br>
						<p><b><?php echo strtoupper($createdby['firstname'])." ".strtoupper($createdby['mname']).". ".strtoupper($createdby['lastname']) ?></b></p>
						<p><?php echo $createdby['groupname']; ?></p>
					</td>
					<td style="width: 50%">
						<p><b>Checked by:</b></p><br>
						<p><b><?php echo strtoupper($approved1['firstname'])." ".strtoupper($approved1['mname']).". ".strtoupper($approved1['lastname']) ?></b></p>
						<p><?php echo $approved1['groupname']; ?></p>
					</td>
				</tr>
			</table>
			<br>
			<table style="width: 100%;font-size: 9pt;font-family:'arial'">
				<tr>
					<td valign="top" style="width: 50%">
						<p><b>Noted by:</b></p><br>
						<p><b><?php echo strtoupper($notedxby); ?></b></p>
						<p><?php echo $posxby; ?></p>
					</td>
					<td valign="top" style="width: 50%">
						<p><b>Conforme:</b></p><br>
						<p><b><?php echo strtoupper($billprof['name']); ?></b></p>
						<p><?php echo $billprof['designation']; ?><br>
						<?php echo $billprof['BillerName']; ?><br>
						<?php echo $billprof['BillingAddress']; ?><br>
						DATE: ______________</P>
					</td>
				</tr>
			</table>
			</div>
			<?php
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

		case 'fncLoadRemarksevents':
			$res = mysql_query("SELECT a.remID, a.xremarks, b.firstname, b.middlename, b.lastname, a.xdate, a.inqID FROM tbltrans_remarks AS a LEFT JOIN tbluser AS b ON a.userID = b.userid WHERE a.inqID = '". $_POST['InquiryID'] ."' AND a.xsource = 'events' AND a.sourceid = '".$_POST['eventsid']."'  ORDER BY a.xdate DESC;", $connection);
			$rowCount = mysql_num_rows($res);
			if($rowCount == 0){
        		echo "<div class='alert alert-info center'> No Remarks Found.. </div>";
			}else{
				while($row = mysql_fetch_array($res)){
				echo "<li class='dd-item dd2-item' id='module_1' style='cursor: pointer;'>
					    <div class='dd2-content'><small style='width:80%;font-size: 85%;display: inline-block;color:black !important;text-align:justify'>".$row["xremarks"]."</small>
					       <a href='#' title='Edit Company Profile' class='btnedit edisabled' style='float:right;padding-left:2px;display: inline-block;' onclick='edittranremarks_events(\"".$row["remID"]."\", \"".$row["inqID"]."\");'><i class='ace-icon fa fa-pencil' style='font-size:15px;'></i></a>
					       <a href='#' title='Delete Company Profile' class='btnedit edisabled' style='float:right;padding-left:2px;padding-right:4px;font-size:15px;display: inline-block;' onclick='deletetranremarks_events(\"".$row["remID"]."\", \"".$row["inqID"]."\");'><i class='ace-icon fa fa-remove' style='color:#b30000;'></i></a>
					       <br />
					       <br /><text style='font-size: 80%;font-weight: normal;margin:0px;'>Added by: ".$row["firstname"]." ".$row["lastname"]."</text><br />
					       		<text style='font-size: 80%;font-weight: normal;margin:0px;'>Date Added: ".date("F d, Y h:i:s A", strtotime($row["xdate"]))."</text>
					       	<br />
					    </div>
					  </li>";
				}
			}
		break;

		case 'getlistofuser':
			$getcurrentusernotedevents = mysql_fetch_array(mysql_query("SELECT notedbyid,notedbyname FROM event_header WHERE eventid = '".$_POST['eventsid']."' ",$connection));
			$inquiry = mysql_fetch_array(mysql_query("SELECT Mall_ID FROM tbltrans_inquiry WHERE Inquiry_ID = '".$_POST['InquiryID']."' ",$connection));
			if($getcurrentusernotedevents[0]!=""){
				$notedby = $getcurrentusernotedevents['eventsnotedbyid'];
			}else{
				$getmallsetup = mysql_fetch_array(mysql_query("SELECT eventsnotedbyid FROM mall_setup WHERE mall_id = '".$inquiry['Mall_ID']."' ",$connection));
				$notedby = $getmallsetup['eventsnotedbyid'];
			}
			$sql = "SELECT CONCAT(firstname,' ',LEFT(middlename,1),'. ',lastname) as fullname,userid FROM tbluser WHERE isActive = '1' ORDER BY lastname ASC";
			$result = mysql_query($sql,$connection);
			echo "<option value=''>-Blank-</option>";
			while ($row = mysql_fetch_array($result)) {
				if($notedby == $row['userid']){
					$selected = "selected";
				}else{
					$selected = "";
				}
				echo "<option value='".$row['userid']."' ".$selected.">".strtoupper($row['fullname'])."</option>";
			}
			echo "||".$notedby;
		break;

		case 'updatenotedby':
			$inquiry = mysql_fetch_array(mysql_query("SELECT Mall_ID FROM tbltrans_inquiry WHERE Inquiry_ID = '".$_POST['InquiryID']."' ",$connection));
			$getcurrentusernotedevents = mysql_fetch_array(mysql_query("SELECT notedby,notedbyname FROM event_header WHERE eventid = '".$_POST['eventsid']."' ",$connection));
			$user = mysql_fetch_array(mysql_query("SELECT CONCAT(firstname,' ',LEFT(middlename,1),'. ',lastname) as fullname,userid FROM tbluser WHERE userid = '".$_POST['userid']."' ",$connection));
			$updateby = mysql_query("UPDATE mall_setup SET eventsnotedbyid = '".$user['userid']."',eventsnotedbyname = '".$user['fullname']."' WHERE  mall_id = '".$inquiry['Mall_ID']."'  ",$connection);
			$updated2 = mysql_query("UPDATE event_header SET notedbyid = '".$user['userid']."',notedbyname  = '".$user['fullname']."' WHERE eventid = '".$_POST['eventsid']."'  ",$connection);
		break;

		case 'checkifhasalreadyevents':
			$inquiry = mysql_fetch_array(mysql_query("SELECT eventid,proposalNum FROM event_header WHERE inquiryid =  '".$_POST['InquiryID']."' ORDER BY proposalNum DESC LIMIT 1; ",$connection));
			if($inquiry[0]!=""){
				echo "1|".$inquiry[1];
			}else{
				echo 0;
			}
		break;

	}


	function checkdateformat($startdate,$enddate){
		$st = date('m',strtotime($startdate));
		$et = date('m',strtotime($enddate));
		$finaldate = "";
		if($st==$et){
			$date1 = date('d',strtotime($startdate));
			$date2 = date('d',strtotime($enddate));
			$month = date('F',strtotime($startdate));
			$year1 = date('Y',strtotime($startdate));
			$year2 = date('Y',strtotime($enddate));
			if($year1==$year2){
				if($date1==$date2){
					$finaldate = $month." ".$date1.", ".$year1;
				}else{
					$finaldate = $month." ".$date1." - ".$date2.", ".$year1;
				}
				
			}else{
				$finaldate = date('F d, Y',strtotime($startdate))." - ".date('F d, Y',strtotime($enddate));
			}

		}else{
			$finaldate = date('F d, Y',strtotime($startdate))." - ".date('F d, Y',strtotime($enddate));
		}

		return $finaldate;
	}
?>