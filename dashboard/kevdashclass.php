<?php  
session_start();
include("../connect.php");
	$filepath = mysql_fetch_array(mysql_query("SELECT filepath, dbsetup, SFTPHost, SFTPPort FROM tblsys_setup;", $connection)); //Get System Setup
	switch ($_POST['form']) {
		case 'showdashapprovalpending':
			$chckrole = mysql_fetch_array(mysql_query("SELECT b.ulevel,b.role FROM tbluser a,tbltrans_hierarchy b WHERE a.groupaccess = b.role AND a.userid = '".$_SESSION['MMS-UserID']."' AND b.module = 'Tenants Request'   ",$connection));
			if($chckrole['ulevel']=='1'){
				$apps = "  AND a.1st_app = '' ";
			}elseif($chckrole['ulevel']=='2'){
				$apps = " AND a.1st_app != ''  AND a.2nd_app = '' ";
			}
			$count = mysql_fetch_array(mysql_query("SELECT COUNT(a.id) FROM tbltrans_tenantsrequest a,tbluser b,tbltrans_hierarchy c,tbltrans_tenants j, tblreqcategory k, tblreqtags l  WHERE a.xuser = b.userid AND  b.hierarchycode = c.hiecode  AND a.TenantID = j.TenantID AND k.reqCatCode = a.requestCat AND l.reqTagCode = a.requestTag AND (a.APP_STATUS != 'Approved' OR a.APP_STATUS != 'Disapproved')  AND c.role = '".$chckrole['role']."' AND c.module = 'Tenants Request' AND c.ulevel = '".$chckrole['ulevel']."'  ".$apps. " AND a.APP_STATUS != 'Disapproved' ORDER BY a.xdatetime DESC ",$connection));
			echo $count[0]."|";
		break;		
	}
?>