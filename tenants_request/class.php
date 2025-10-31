<?php  	
    session_start();
	include("../connect.php");
	switch ($_POST['form']) {
		case 'showTenantNames':
			$title = mysql_fetch_array(mysql_query("SELECT softwaretype FROM tblsys_setup;", $connection));
			if($title[0] == "5"){
				$label =  "Buyer";
			}else{
				$label =  "Tenant";
			}
			echo "<option value=''>-- Select ". $label ." --</option>";
			$res = mysql_query("SELECT TenantID, tradename FROM tbltrans_tenants WHERE (Status = 'Active' OR Status = 'ForEviction' OR Status = 'ForRenewal') AND ustatus = 'Occupied'", $connection);
			while($row = mysql_fetch_array($res)){
				echo "<option value='".$row[0]."'>".$row[1]."</option>";
			}	
		break;

		/*	START Michael Capistrano 09-09-2019*/
		case 'showTenantRequest':
				$res = mysql_query("SELECT TenantID, tradename FROM tbltrans_tenants WHERE (Status = 'Active' OR Status = 'ForEviction' OR Status = 'ForRenewal') AND ustatus = 'Occupied'", $connection);
					while($row = mysql_fetch_array($res)){
						echo "<option value=''>-- Select Tenant --</option>";				
						echo "<option value='".$row[0]."'>".$row[1]."</option>";
					}	
		break;

		case 'showTenantRequestCategory':
				echo "<option value=''>-- Select Category --</option>";
				$res = mysql_query("SELECT reqCatCode, reqCatDesc FROM tblreqcategory", $connection);
						while ($row = mysql_fetch_array($res)) {
							echo "<option value='".$row[0]."'>".$row[1]."</option>";
						}
		break;

		case 'showTenantCategoryTagInfo':
				echo "<option value=''>-- Select Tag --</option>"; 
				$res = mysql_query("SELECT tblreqcategory.reqCatCode, reqTagCode, reqTagDesc FROM tblreqtags,tblreqcategory WHERE tblreqcategory.reqCatCode ='".$_POST['RequestTag']."' AND tblreqcategory.reqCatCode = tblreqtags.reqCatCode", $connection);
					while ( $row = mysql_fetch_array( $res ) ) {
						echo "<option value='".$row[1]."'>".$row[2]."</option>";
					}
		break; 


		case 'showTenantCategoryTagApproval':
				echo "<option value=''>-- Select zxc --</option>"; 
				$res = mysql_query("SELECT reqCatCode, reqTagCode, reqTagAppr FROM tblreqtags WHERE reqTagCode ='".$_POST['reqTagAppr']."'", $connection);
					while ( $row = mysql_fetch_array( $res ) ) {
						echo "<option value='".$row[0]."'>".$row[1]."</option>";
					}
		break; 


		case 'TenantRequestInfo':
				$Info = mysql_fetch_array(mysql_query("SELECT TenantID, UnitID, mallID FROM tbltrans_tenants WHERE TenantID ='".$_POST['tenantid']."'", $connection));
				echo $Info['TenantID'] . "|" . $Info['UnitID'] ."|". $Info['mallID'];
		break; 
		/* END Michael Capistrano 09-09-2019*/

		case 'showTenantNamesInfo':
			$Info = mysql_fetch_array(mysql_query("SELECT owner_firstname, owner_midname, owner_lastname, unitid, mallID, TenantID, companyname, CompanyID FROM tbltrans_tenants WHERE TenantID = '". $_POST['tenantid'] ."'", $connection));
			$mallname = mysql_fetch_array(mysql_query("SELECT mallname FROM tblref_mall WHERE mallid = '". $Info['mallID'] ."'", $connection));
			$UnitInfo = mysql_fetch_array(mysql_query("SELECT buildingname, floorid, unitname, typeofbusiness, classificationname FROM tblref_unit WHERE unitid = '". $Info['unitid'] ."'", $connection));
			$Floor = mysql_fetch_array(mysql_query("SELECT floor FROM tblref_floorsetup WHERE floorid = '". $UnitInfo['floorid'] ."'", $connection));
			$mobile = mysql_fetch_array(mysql_query("SELECT content FROM tbltrans_company_contacts WHERE TYPE = 'mobile' AND CompanyID = '". $Info['CompanyID'] ."' LIMIT 1", $connection));
			$telephone = mysql_fetch_array(mysql_query("SELECT content FROM tbltrans_company_contacts WHERE TYPE = 'telephone' AND CompanyID = '". $Info['CompanyID'] ."' LIMIT 1", $connection));
			$email = mysql_fetch_array(mysql_query("SELECT content FROM tbltrans_company_contacts WHERE TYPE = 'email' AND CompanyID = '". $Info['CompanyID'] ."' LIMIT 1", $connection));
			echo $Info['owner_firstname'] . "|" . $Info['owner_midname'] . "|" . $Info['owner_lastname'] . "|" .$mallname['mallname'] . "|" . $UnitInfo['buildingname'] . "|" . $Floor['floor'] . "|" . $UnitInfo['unitname'] . "|" . $UnitInfo['typeofbusiness'] . "|" . $UnitInfo['classificationname'] . "|" . $Info['TenantID'] . "|" . $mobile['content'] . "|" . $telephone['content'] . "|" .$email['content'];
		break;

		case 'saverequest':
			$APPNO = createidno("TR", "tbltrans_tenantsrequest", "applicationno");
			$UnitID = mysql_fetch_array(mysql_query("SELECT unitid FROM tblref_unit WHERE TenantID = '". $_POST['TenantID'] ."'", $connection));
			$sql = "INSERT INTO 
			 SET TENANTID = '". $_POST['TenantID'] ."', APP_NO = '". $APPNO ."', APP_DATE = '". date('Y-m-d', strtotime($_POST['AppDate'])) ."', FIRST_NAME = '". $_POST['FName'] ."', MIDDLE_NAME = '". $_POST['MName'] ."', LAST_NAME = '". $_POST['LName'] ."', FULL_NAME = '". $_POST['FName'] . " " . $_POST['MName'] . " " . $_POST['LName'] ."', MOBILE_NUMBER = '". $_POST['MobileNumber'] ."', TELEPHONE_NUMBER = '". $_POST['Telephone'] ."', EMAIL_ADDRESS = '". $_POST['Email'] ."', MALL = '". $_POST['Mall'] ."' , WING = '". $_POST['Wing'] ."', FLOOR = '". $_POST['Floor'] ."', UNIT = '". $_POST['Unit'] ."', UNITID = '". $UnitID[0] ."', UNITTYPE = '". $_POST['UnitType'] ."', CLASSIFICATION = '". $_POST['Classification'] ."', SCOPE = '". $_POST['Scope'] ."', DETAILS = '". $_POST['Details'] ."'";
			$res = mysql_query($sql, $connection);	
			if($res == true){
				echo "1|Request successfully sent.";
			}else{
				echo "2|Sending request failed.";
			}
		break;

		/*START Michael Capistrano 09-10-2019*/
		case 'saveTenantRequest':
				$getTagStatus = mysql_fetch_array(mysql_query("SELECT reqTagAppr FROM tblreqtags WHERE reqTagCode = '". $_POST['RequestTag'] ."';", $connection));
				$getStat = "Pending";
				if ( $getTagStatus[0] == 0 ) {
					$getStat = "Approved";
		}
		$RequestID = createidno("REQ", "tbltrans_tenantsrequest", "RequestID");
		$sql = "INSERT INTO tbltrans_tenantsrequest SET TenantID = '". $_POST['TenantID'] ."', RequestID = '". $RequestID ."', ApplicationDate = '". date('Y-m-d', strtotime($_POST['ApplicationDate'])) ."', UnitID = '". $_POST['UnitID'] ."', MallID = '". $_POST['MallID'] ."', RequestCat = '". $_POST['RequestCat'] ."', RequestTag = '". $_POST['RequestTag'] ."', isApproval = '". $getTagStatus[0] ."', APP_STATUS = '".$getStat."', Remarks = '". $_POST['Remarks'] ."',notify = '".$_POST['chckboxnotify']."' ";
			$res = mysql_query($sql, $connection);
			if($res == true) {
				// -- count pang check lang to kung may attendee na nakalagay
				if( $_POST['visitors'] !="" ){
					$arr = explode("####", $_POST['visitors']);
					for ($i=1; $i <= count($arr)-1; $i++) { 
						$arr2 = explode("|", $arr[$i]);
						$sql1 = "INSERT INTO tbltrans_tenantsrequest_visitor SET RequestID = '".$RequestID."',fname = '".mysql_real_escape_string($arr2[2])."',lname = '".mysql_real_escape_string($arr2[3])."',idpres = '".mysql_real_escape_string($arr2[3])."' ,login = '".mysql_real_escape_string($arr[4])."' ,logout = '".mysql_real_escape_string($arr2[4])."' ";
						$res1 = mysql_query( $sql1 , $connection );
					}
					
				}

				if( $_POST['itemsx'] !="" ){
					$arr = explode("####", $_POST['itemsx']);
					for ($i=1; $i <= count($arr)-1; $i++) { 
						$arr2 = explode("|", $arr[$i]);
						$sql1 = "INSERT INTO tbltrans_tenantsrequest_items SET RequestID = '".$RequestID."',itemname = '".mysql_real_escape_string($arr2[1])."',qty = '".$arr2[2]."',unitx = '".$arr2[3]."' ,notes = '".mysql_real_escape_string($arr2[4])."' ";
						$res1 = mysql_query( $sql1 , $connection );
					}
					
				}

				echo "1|Request successfully sent.";   
			} else {
				echo "2|Sending request failed."; 
			}
		break;


		case 'displayTenantRequest':
				$ctr = 1;
				$sql = "SELECT a.id, a.ApplicationDate, b.tradename, b.unitname, c.reqCatDesc, d.reqTagDesc, a.isApproval, a.APP_STATUS FROM tbltrans_tenantsrequest a,tbltrans_tenants b, tblreqcategory c, tblreqtags d WHERE a.TenantID = b.TenantID AND c.reqCatCode = a.requestCat AND d.reqTagCode = a.requestTag ORDER BY a.xdatetime DESC;";
				$res = mysql_query($sql, $connection);
				while($row = mysql_fetch_array($res)){
					$forApp = "";
					if ( $row[7] == 1 ) {
						$forApp = "forApp";
					}
				?>
					<tr class="<?php echo $forApp; ?>" id="<?php echo $row[0]; ?>">
						<td><?php echo $ctr; ?></td>
						<td><?php echo $row[1]; ?></td>
						<td><?php echo utf8_encode($row[2]); ?></td>						
						<td><?php echo utf8_encode($row[3]); ?></td>
						<td><?php echo $row[4] ?></td>
						<td><?php echo $row[5] ?></td>
						<td>
							<?php 
							if($row['APP_STATUS'] == 'Pending'){ 
								echo '<span style="width:90px" class="label label-xlg label-warning arrowed-in-right arrowed pull-right">Pending</span>'; 
							} else {
								echo '<span style="width:90px" class="label label-xlg label-success arrowed-in-right arrowed pull-right">Approved</span>'; 
							} ?>
						</td>	
						<td>
							<?php 
								if($row[''] == 1){
									echo "";

								}
							?>
						</td>											
					</tr>
				<?php
				$ctr++;
			}
		break;


		/*END Michael Capistrano 09-10-2019*/

		case 'showtblrequestlist':
			$cnt_fltr = 0;

			$sql = " SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'TenantRequest'; ";
			$res = mysql_query($sql, $connection);
		    $sql_filter = mysql_fetch_array($res);
	        
	        $isAdmin = mysql_fetch_array(mysql_query("SELECT isAdmin FROM tbluser WHERE userid = '". $_SESSION['MMS-UserID'] ."'", $connection) or die(mysql_error()));
			$levelofapp = mysql_fetch_array(mysql_query("SELECT COUNT(module) FROM tblref_apprlist WHERE module = 'TR' ", $connection));
			$resTPAccess = mysql_query("SELECT CODE FROM tblref_apprlistperuser WHERE userid = '". $_SESSION['MMS-UserID'] ."' and module = 'TR';", $connection);
			while($rowTPAccess = mysql_fetch_array($resTPAccess)){
				$mgaMeron .= "'" . $rowTPAccess[0][1] . "'" . ",";
			}
			if($mgaMeron != ""){
				$ApprovalStagesss = "AND APPROVAL_STAGE IN (". substr(trim($mgaMeron), 0, -1) .")";
			}else{
				$ApprovalStagesss = "";
			}
		    $trby = explode("|", $sql_filter["checked_value"]);
		    $date = explode("|", $sql_filter["datefilter"]);
		    $stat = explode("|", $sql_filter["bystat"]);
		    $filter = "";

		    $cnt = 0; $chk = "";
		    for($a = 0; $a<=count($stat)-1; $a++){
		      	if($stat[$a] == "Approved"){ 
		      		$con = "APP_STATUS = 'Approved'"; 
		      	}else if($stat[$a] == "Disapproved"){ 
		      		$con = "APP_STATUS = 'Disapproved'"; 
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
		    }else if($cnt == 0){
		    	$Stat_fltr = "FALSE";
		    }else{
		      	$Stat_fltr = $chk;
		    }

		    // filter by date
		    $date_fltr = "(APP_DATE BETWEEN '".date("Y-m-d", strtotime($date[0]))."' AND '".date("Y-m-d", strtotime($date[1]))."')";
		    // filter by
		    $cnt2 = 0; $chk2 = "";
		    for($c = 0; $c<=count($trby)-1; $c++){
		      	if($trby[$c] != ""){
			        $cnt2++;
			        if($cnt2 == 1){
			          	$chk2 .= $trby[$c] . " LIKE '%".$_POST["key"]."%'";
			        }else{
			          	$chk2 .= " OR ". $trby[$c] . " LIKE '%".$_POST["key"]."%'";
			        }
		      	}
		    }

		    if($cnt2 > 1){
		      	$by_fltr = "(".$chk2.")";
		    }else{
		      	$by_fltr = $chk2;
		    }

		    if($cnt2 > 0){
		      	$and2 = " AND ";
		    }else{
		      	$and2 = "";
		    }

		    if($isAdmin[0] == "1"){
		    	if($sql_filter['xcheck'] == ""){
					$ApprovalStage = "";
		    	}else{
		    		$ApprovalStage = " AND IF( ".$Stat_fltr." , ".$Stat_fltr.", (APPROVAL_STAGE != ''))";	
		    	}
		    }else{
		    	if($sql_filter['xcheck'] == ""){
					$ApprovalStage = $ApprovalStagesss;
		    	}else{
		    		$ApprovalStage = " AND IF( ".$Stat_fltr." , ".$Stat_fltr.", (APPROVAL_STAGE = '". $sql_filter['xcheck'] ."') )";	
		    	}
		    }
		        			    
		    $filterselected = "WHERE ".$date_fltr.$and2.$by_fltr.$ApprovalStage;

		    $page = $_POST['page'];
			$limit = ($page-1) * 20;
			$res = mysql_query("SELECT APP_NO, APP_DATE, PERMIT_NO, ISSUED_DATE, TENANTID, FULL_NAME, UNIT, SCOPE, DETAILS, APPROVAL_STATUS, APP_STATUS, UNITID, TENANTID FROM tbltrans_tenantsrequest ".$filterselected." LIMIT ".$limit.", 20;", $connection);
			while($row = mysql_fetch_array($res)){
				$MallID = mysql_fetch_array(mysql_query("SELECT mallid FROM tblref_unit WHERE unitid = '". $row[11] ."'", $connection));
				$Tradename = mysql_fetch_array(mysql_query("SELECT tradename FROM tbltrans_tenants WHERE TenantID = '". $row['TENANTID'] ."';", $connection));
				if($row[1] == ""){
					$appdate = "";
				}else{
					$appdate = date('m/d/Y', strtotime($row[1]));
				}
				if($row[10] == "Approved"){
					$appstat = "<span class='label label-lg label-success arrowed-in-right arrowed' style='z-index: 0;'>Approved</span>";
					$hideme = "style='display: none;'";
				}else if($row[10] == "Disapproved"){
					$appstat = "<span class='label label-lg label-danger arrowed-in-right arrowed' style='z-index: 0;'>Disapproved</span>";
					$hideme = "style='display: none;'";
				}else{
					$appstat = "<span class='label label-lg label-warning arrowed-in-right arrowed' style='z-index: 0;'>Pending</span>";
					$hideme = "style='display: block;'";
				}
				echo 	"	
							<tr>
								<td width='1%'><input type='checkbox' ".$hideme." value='".$row[0]."' class='mainchkapptr'></td>
								<td width='8%'>".$row[0]."</td>
								<td width='9%'>".$appdate."</td>
								<td width='15%'>".$Tradename['tradename']."</td>
								<td width='15%'>".$row[6]."</td>
								<td width='4%'>".$row[7]."</td>
								<td width='30%'>".$row[8]."</td>
								<td width='8%'>".$row[9]." of ".$levelofapp[0]."</td>
								<td width='5%'>".$appstat."</td>
								<td width='5%' style='text-align: center;' class='isadmin hide select-printtenantrequest center'><button class='btn btn-sm btn-gray btn-round' onclick='printTR(\"". $row[0] ."\", \"". $MallID[0] ."\")' title='Print Inquiry' style='margin: 2px;z-index: 0;'><img src='assets/images/printer.png' style='width: 100%; height: auto;' /></button></td>
						";
			}
		break;

		case 'getapplevelcount':
	        $isAdmin = mysql_fetch_array(mysql_query("SELECT isAdmin FROM tbluser WHERE userid = '". $_SESSION['MMS-UserID'] ."'", $connection));
			echo "<option value=''>-- Select Level --</option>";
			if($isAdmin[0] == "1"){
				$getAccess = "";
			}else{
				$getAccess = "AND userid = '". $_SESSION['MMS-UserID'] ."'";
			}
			$sql = "SELECT code FROM tblref_apprlistperuser WHERE module = 'TR' ". $getAccess ." ORDER BY level ASC;";
			$res = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($res)){
				echo "<option value=".$row[0][1].">".$row[0][1]."</option>";
			}
		break;

		case 'loadapptrentries':
			$cnt_fltr = 0;
		    $sql_filter = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'TenantRequest' ", $connection));
	        $isAdmin = mysql_fetch_array(mysql_query("SELECT isAdmin FROM tbluser WHERE userid = '". $_SESSION['MMS-UserID'] ."'", $connection));
			$levelofapp = mysql_fetch_array(mysql_query("SELECT COUNT(module) FROM tblref_apprlist WHERE module = 'TR' ", $connection));
			$resTPAccess = mysql_query("SELECT CODE FROM tblref_apprlistperuser WHERE userid = '". $_SESSION['MMS-UserID'] ."' and module = 'TR';", $connection);
			while($rowTPAccess = mysql_fetch_array($resTPAccess)){
				$mgaMeron .= "'" . $rowTPAccess[0][1] . "'" . ",";
			}
			if($mgaMeron != ""){
				$ApprovalStagesss = "AND APPROVAL_STAGE IN (". substr(trim($mgaMeron), 0, -1) .")";
			}else{
				$ApprovalStagesss = "";
			}
		    $trby = explode("|", $sql_filter["checked_value"]);
		    $date = explode("|", $sql_filter["datefilter"]);
		    $stat = explode("|", $sql_filter["bystat"]);
		    $filter = "";

		    $cnt = 0; $chk = "";
		    for($a = 0; $a<=count($stat)-1; $a++){
		      	if($stat[$a] == "Approved"){ 
		      		$con = "APP_STATUS = 'Approved'"; 
		      	}else if($stat[$a] == "Disapproved"){ 
		      		$con = "APP_STATUS = 'Disapproved'"; 
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
		    }else if($cnt == 0){
		    	$Stat_fltr = "FALSE";
		    }else{
		      	$Stat_fltr = $chk;
		    }

		    // filter by date
		    $date_fltr = "(APP_DATE BETWEEN '".date("Y-m-d", strtotime($date[0]))."' AND '".date("Y-m-d", strtotime($date[1]))."')";
		    // filter by
		    $cnt2 = 0; $chk2 = "";
		    for($c = 0; $c<=count($trby)-1; $c++){
		      	if($trby[$c] != ""){
			        $cnt2++;
			        if($cnt2 == 1){
			          	$chk2 .= $trby[$c] . " LIKE '%".$_POST["key"]."%'";
			        }else{
			          	$chk2 .= " OR ". $trby[$c] . " LIKE '%".$_POST["key"]."%'";
			        }
		      	}
		    }

		    if($cnt2 > 1){
		      	$by_fltr = "(".$chk2.")";
		    }else{
		      	$by_fltr = $chk2;
		    }

		    if($cnt2 > 0){
		      	$and2 = " AND ";
		    }else{
		      	$and2 = "";
		    }

		    if($isAdmin[0] == "1"){
		    	if($sql_filter['xcheck'] == ""){
					$ApprovalStage = "";
		    	}else{
		    		$ApprovalStage = " AND IF( ".$Stat_fltr." , ".$Stat_fltr.", (APPROVAL_STAGE != ''))";	
		    	}
		    }else{
		    	if($sql_filter['xcheck'] == ""){
					$ApprovalStage = $ApprovalStagesss;
		    	}else{
		    		$ApprovalStage = " AND IF( ".$Stat_fltr." , ".$Stat_fltr.", (APPROVAL_STAGE = '". $sql_filter['xcheck'] ."') )";	
		    	}
		    }
		        			    
		    $filterselected = "WHERE ".$date_fltr.$and2.$by_fltr.$ApprovalStage;

           	if($_POST["page"] == ""){
               	$page = 1;
           	}else{
               	$page = $_POST["page"];
           	}

           	$limit = ($page-1) * 20;
            $rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM tbltrans_tenantsrequest ".$filterselected.";", $connection));
            $RowPerPage = 20;
            $totalpages = ceil($rowCount[0] / $RowPerPage);
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

		case "loadapptrpage":
			$cnt_fltr = 0;
		    $sql_filter = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'TenantRequest' ", $connection));
	        $isAdmin = mysql_fetch_array(mysql_query("SELECT isAdmin FROM tbluser WHERE userid = '". $_SESSION['MMS-UserID'] ."'", $connection));
			$levelofapp = mysql_fetch_array(mysql_query("SELECT COUNT(module) FROM tblref_apprlist WHERE module = 'TR' ", $connection));
			$resTPAccess = mysql_query("SELECT CODE FROM tblref_apprlistperuser WHERE userid = '". $_SESSION['MMS-UserID'] ."' and module = 'TR';", $connection);
			while($rowTPAccess = mysql_fetch_array($resTPAccess)){
				$mgaMeron .= "'" . $rowTPAccess[0][1] . "'" . ",";
			}
			if($mgaMeron != ""){
				$ApprovalStagesss = "AND APPROVAL_STAGE IN (". substr(trim($mgaMeron), 0, -1) .")";
			}else{
				$ApprovalStagesss = "";
			}
		    $trby = explode("|", $sql_filter["checked_value"]);
		    $date = explode("|", $sql_filter["datefilter"]);
		    $stat = explode("|", $sql_filter["bystat"]);
		    $filter = "";

		    $cnt = 0; $chk = "";
		    for($a = 0; $a<=count($stat)-1; $a++){
		      	if($stat[$a] == "Approved"){ 
		      		$con = "APP_STATUS = 'Approved'"; 
		      	}else if($stat[$a] == "Disapproved"){ 
		      		$con = "APP_STATUS = 'Disapproved'"; 
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
		    }else if($cnt == 0){
		    	$Stat_fltr = "FALSE";
		    }else{
		      	$Stat_fltr = $chk;
		    }

		    // filter by date
		    $date_fltr = "(APP_DATE BETWEEN '".date("Y-m-d", strtotime($date[0]))."' AND '".date("Y-m-d", strtotime($date[1]))."')";
		    // filter by
		    $cnt2 = 0; $chk2 = "";
		    for($c = 0; $c<=count($trby)-1; $c++){
		      	if($trby[$c] != ""){
			        $cnt2++;
			        if($cnt2 == 1){
			          	$chk2 .= $trby[$c] . " LIKE '%".$_POST["key"]."%'";
			        }else{
			          	$chk2 .= " OR ". $trby[$c] . " LIKE '%".$_POST["key"]."%'";
			        }
		      	}
		    }

		    if($cnt2 > 1){
		      	$by_fltr = "(".$chk2.")";
		    }else{
		      	$by_fltr = $chk2;
		    }

		    if($cnt2 > 0){
		      	$and2 = " AND ";
		    }else{
		      	$and2 = "";
		    }

		    if($isAdmin[0] == "1"){
		    	if($sql_filter['xcheck'] == ""){
					$ApprovalStage = "";
		    	}else{
		    		$ApprovalStage = " AND IF( ".$Stat_fltr." , ".$Stat_fltr.", (APPROVAL_STAGE != ''))";	
		    	}
		    }else{
		    	if($sql_filter['xcheck'] == ""){
					$ApprovalStage = $ApprovalStagesss;
		    	}else{
		    		$ApprovalStage = " AND IF( ".$Stat_fltr." , ".$Stat_fltr.", (APPROVAL_STAGE = '". $sql_filter['xcheck'] ."') )";	
		    	}
		    }
		        			    
		    $filterselected = "WHERE ".$date_fltr.$and2.$by_fltr.$ApprovalStage;
		    
		    $page = $_POST["page"];

            $rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM tbltrans_tenantsrequest ".$filterselected.";", $connection));
			$num = $rowCount[0];
			$rowsperpage = 20;
			$range = 3;
			$totalpages = ceil($num / $rowsperpage);
			$prevpage;
			$nextpage;
			// if not on page 1, don't show back links
			if($page > 1 ){
			   echo "<li style='width:50px !important;' onclick='paginationapptr(1)'><< First</li>";
			   $prevpage = $page - 1;
			   echo "<li style='width:70px !important;' onclick='paginationapptr(". $prevpage .")'>< Previous</li>";
			}

			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if (($x > 0) && ($x <= $totalpages)){
    			    if ($x == $page){
                        echo "<li id='pgcomplatspage" . $x . "' class='pgapptr active' onclick='paginationapptr(" . $x . ",". $x .")'>" . $x . "</li>";
                    }else{
    			        echo "<li id='pgcomplatspage" . $x . "' class='pgapptr' onclick='paginationapptr(" . $x . ",". $x .")'>" . $x . "</li>";
                    }
		       }
		    }
		    if($page < ($totalpages - $range)){
                echo "<li>...</li>";
            }

		    if ($page != $totalpages && $num != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='paginationapptr(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='paginationapptr(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'approvethis':
			$levelofapp = mysql_fetch_array(mysql_query("SELECT COUNT(module) FROM tblref_apprlist WHERE module = 'TR' ", $connection));
			$mgaiaapprove = explode("|", $_POST['ids']);
			for ($a=0; $a <= COUNT($mgaiaapprove)-2; $a++) { 
				$getprev = mysql_fetch_array(mysql_query(" SELECT APPROVAL_STATUS, APPROVAL_STAGE FROM tbltrans_tenantsrequest WHERE APP_NO = '". $mgaiaapprove[$a] ."' ", $connection));
				$stat = 0;
				$stage = 0;
				if($getprev[0] == 0){
					$stat  = $getprev[0] + 1;
					$stage = $getprev[1] + 1;
				}else{
					$stat  = $getprev[0] + 1;
					$stage = $getprev[1] + 1;
				}

				if($levelofapp[0] == $stat){
					$appstat = "Approved";
				}else{
					$appstat = "Pending";
				}

				$sql = "UPDATE tbltrans_tenantsrequest SET APPROVAL_STATUS = '". $stat ."', APPROVAL_STAGE = '". $stage ."', APP_STATUS = '". $appstat ."' WHERE APP_NO = '". $mgaiaapprove[$a] ."' ";
				$res = mysql_query($sql, $connection);
			}
		break;

		case 'disapprovethis':
			$mgaiaapprove = explode("|", $_POST['ids']);
			for ($a=0; $a <= COUNT($mgaiaapprove)-2; $a++) { 
				$sql = "UPDATE tbltrans_tenantsrequest SET APP_STATUS = 'Disapproved' WHERE APP_NO = '". $mgaiaapprove[$a] ."' ";
				$res = mysql_query($sql, $connection);
			}
		break;

		case 'printbydaterangeTR':
			$levelofapp = mysql_fetch_array(mysql_query("SELECT COUNT(module) FROM tblref_apprlist WHERE module = 'TR' ", $connection));
			$sql = " SELECT a.APP_NO, a.APP_DATE, a.PERMIT_NO, a.ISSUED_DATE, a.TENANTID, a.FULL_NAME, a.UNIT, a.SCOPE, a.DETAILS, a.APPROVAL_STATUS, a.APP_STATUS FROM tbltrans_tenantsrequest AS a LEFT JOIN tblref_unit AS b ON a.UNITID = b.unitid WHERE b.mallid = '". $_POST['mallid'] ."' AND a.APP_DATE BETWEEN '".date("Y-m-d", strtotime($_POST['datefrom']))."' AND '".date("Y-m-d", strtotime($_POST['dateto']))."' ";
					$res = mysql_query($sql, $connection);
				while( $row = mysql_fetch_array($res) ){

					if($row[1] == ""){
						$appdate = "";
					}else{
						$appdate = date('m/d/Y', strtotime($row[1]));
					}
					if($row[10] == "Approved"){
						$appstat = "<span class='label label-success arrowed-in-right arrowed'>Approved</span>";
						$hideme = "style='display: none;'";
					}else if($row[10] == "Disapproved"){
						$appstat = "<span class='label label-danger arrowed-in-right arrowed'>Disapproved</span>";
						$hideme = "style='display: none;'";
					}else{
						$appstat = "<span class='label label-warning arrowed-in-right arrowed'>Pending</span>";
						$hideme = "style='display: block;'";
					}
			
					?>
						<tr>
							<td><?php echo $appdate; ?></td>
							<td><?php echo $row[0]; ?></td>	
							<td><?php echo $row[5]; ?></td>
							<td><?php echo $row[6]; ?></td>
							<td><?php echo $row[7]; ?></td>
							<td><?php echo $row[9]." of ".$levelofapp[0]; ?></td>
							<td><?php echo $appstat; ?></td>
					<?php				
				}
				echo "|".date('F d, Y', strtotime($_POST['datefrom'])) . "|" . date('F d, Y', strtotime($_POST['dateto']));
		break;

		case 'printTR':
			$sql = "SELECT APP_DATE, TENANTID, FULL_NAME, MOBILE_NUMBER, TELEPHONE_NUMBER, EMAIL_ADDRESS, MALL, WING, FLOOR, UNIT, SCOPE, DETAILS FROM tbltrans_tenantsrequest WHERE APP_NO  = '". $_POST['appno'] ."'";
			$res = mysql_query($sql, $connection);
			$row = mysql_fetch_array($res);

			echo date('m/d/Y', strtotime($row[0])) . "|" . $row[1] . "|" . $row[2]. "|" . $row[3] . "|" . $row[4] . "|" . $row[5] . "|" . $row[6] . "|" . $row[7] . "|" . $row[8] . "|" . $row[9] . "|" . trim($row[10]) . "|" . $row[11];
		break;
	}
?>