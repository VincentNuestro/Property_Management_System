<?php  	
    session_start();
	include("../../connect.php");
	switch ($_POST['form']) {
		
		case 'displaytenantreqapprovallist':
			$ctr = 1;
				$chckrole = mysql_fetch_array(mysql_query("SELECT b.ulevel,b.role FROM tbluser a,tbltrans_hierarchy b WHERE a.groupaccess = b.role AND a.userid = '".$_SESSION['MMS-UserID']."' AND b.module = 'Tenants Request'   ",$connection));
				if($chckrole['ulevel']=='1'){
					$apps = "  AND a.1st_app = '' ";
				}elseif($chckrole['ulevel']=='2'){
					$apps = " AND a.1st_app != ''  AND a.2nd_app = '' ";
				}
				$sql = "SELECT a.id, a.ApplicationDate, j.tradename, j.unitname, k.reqCatDesc, l.reqTagDesc, a.isApproval, a.APP_STATUS,a.RequestID,CONCAT(b.lastname,', ',b.firstname) as fullname FROM tbltrans_tenantsrequest a,tbluser b,tbltrans_hierarchy c,tbltrans_tenants j, tblreqcategory k, tblreqtags l  WHERE a.xuser = b.userid AND  b.hierarchycode = c.hiecode  AND a.TenantID = j.TenantID AND k.reqCatCode = a.requestCat AND l.reqTagCode = a.requestTag AND (a.APP_STATUS != 'Approved' OR a.APP_STATUS != 'Disapproved')  AND c.role = '".$chckrole['role']."' AND c.module = 'Tenants Request' AND c.ulevel = '".$chckrole['ulevel']."'  ".$apps. " AND a.APP_STATUS != 'Disapproved' ORDER BY a.xdatetime DESC ";

				$res = mysql_query($sql, $connection) or die(mysql_error($connection));
				while($row = mysql_fetch_array($res)){
					$forApp = "";
					if ( $row[7] == 1 ) {
						$forApp = "forApp";
					}
				?>
					<tr class="<?php echo $forApp; ?>" id="<?php echo $row['RequestID']; ?>">
						<td><?php echo $ctr; ?></td>
						<td><?php echo $row[1]; ?></td>
						<td><?php echo utf8_encode($row[2]); ?></td>						
						<td><?php echo utf8_encode($row[3]); ?></td>
						<td><?php echo $row[4]; ?></td>
						<td><?php echo $row[5]; ?></td>
						<td><?php echo $row['fullname']; ?></td>
						<td style="text-align: center">
							<?php 
							if($row['APP_STATUS'] == 'Pending'){ 
								echo '<span style="width:100px" class="label label-xlg label-warning arrowed-in-right arrowed ">Pending</span>'; 
							} elseif($row['APP_STATUS'] == 'Approved'){  
								echo '<span style="width:100px" class="label label-xlg label-success arrowed-in-right arrowed ">Approved</span>'; 
							} elseif($row['APP_STATUS'] == 'Confirmed'){  
								echo '<span style="width:100px" class="label label-xlg label-warning arrowed-in-right arrowed ">Confirmed</span>'; 
							} elseif($row['APP_STATUS'] == 'Disapproved'){  
								echo '<span style="width:100px" class="label label-xlg label-danger arrowed-in-right arrowed ">Disapproved</span>'; 
							} ?>
						</td>												
					</tr>
				<?php
				$ctr++;
			}
		break;

		case 'saveapprovetrequest':
			$chckrole = mysql_fetch_array(mysql_query("SELECT b.ulevel,b.role FROM tbluser a,tbltrans_hierarchy b WHERE a.groupaccess = b.role AND a.userid = '".$_SESSION['MMS-UserID']."' AND b.module = 'Tenants Request'   ",$connection));
			$getlevel =  mysql_fetch_array(mysql_query("SELECT a.xuser,b.hierarchycode,c.ulevel,a.1st_app,a.2nd_app FROM tbltrans_tenantsrequest a,tbluser b, tbltrans_hierarchy c WHERE a.xuser = b.userid AND c.hiecode = b.hierarchycode   AND a.RequestID = '".$_POST['txttenantrequet_id']."' AND c.role = '".$chckrole['role']."' AND c.module = 'Tenants Request'",$connection));
			$setups = "";
			$check2nd = mysql_fetch_array(mysql_query("SELECT id FROM tbltrans_hierarchy WHERE hiecode = '".$getlevel['hierarchycode']."' AND module = 'Tenants Request' AND ulevel = 2"));
			$add = $getlevel['ulevel'] + 1;
			$checklast = mysql_fetch_array(mysql_query("SELECT id FROM tbltrans_hierarchy WHERE hiecode = '".$getlevel['hierarchycode']."' AND module = 'Tenants Request' AND ulevel = ".$add));
			if($getlevel['ulevel']=='1'){
				$updates = ",1st_app = '".$_SESSION['MMS-UserID']."',1st_date = NOW(), 1st_marks = '".mysql_real_escape_string($_POST['appremarks'])."'  ";
			}elseif($getlevel['ulevel']=='2'){
				$updates = ",2nd_app = '".$_SESSION['MMS-UserID']."',2nd_date = NOW(), 2nd_marks = '".mysql_real_escape_string($_POST['appremarks'])."'  ";
			}else{
				$setups = "Please set hierarchy of approvers.";
			}
			if(($getlevel['ulevel']=='1' && $check2nd[0]=="") || ($getlevel['ulevel']!='1'  &&  $getlevel['ulevel']!=''  && $checklast[0]=="")){
				$stat = 'Approved';
			}else{
				$stat = 'Confirmed';
			}

			if($_POST['txttypeapproved']=='Approved'){
				$stat = $stat;
			}else{
				$stat = "Disapproved";
			}

			if($stat=='Approved'){
				$updates2 = " ,dateapproved = NOW(), lastapproved = '".$_SESSION['MMS-UserID']."' ";
			}else{
				$updates2 = "";
			}

			if($setups==""){
				$updaterequest = mysql_query("UPDATE  tbltrans_tenantsrequest SET APP_STATUS = '".$stat."'  ".$updates.$updates2. " WHERE RequestID = '".$_POST['txttenantrequet_id']."' ",$connection) or die(mysql_error());
				echo $updaterequest;
			}else{
				echo $setups;
			}
			

		break;
	}
?>