<?php
	session_start();
	include("../../connect.php");
	function rrmdir($dir) { 
	   	if (is_dir($dir)) { 
	     	$objects = scandir($dir); 
	     	foreach ($objects as $object) { 
	       		if ($object != "." && $object != "..") { 
	         		if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object); 
	       		} 
	     	} 
	     	reset($objects); 
	     	rmdir($dir); 
	   	} 
	} 
	switch ($_POST['form']){
		case 'fncProceedTruncate':
			$name = mysql_fetch_array(mysql_query("SELECT firstname, middlename, lastname FROM tbluser WHERE userid = '". $_SESSION['MMS-UserID'] ."';"));
	       	if($_SESSION['MMS-UserID'] == "GatessoftCorp"){
	       		$username = "Gatessoft Corp";
	       	}else if($_SESSION['MMS-UserID'] == "Superuser"){
	       		$username = "Superuser";
	       	}else{
	       		$username = $name["lastname"].", ".$name["firstname"]." ".$name["middlename"];
	       	}

			$arr = explode("|", $_POST['Checked']);
			$Count = 0;
			for ($i=0; $i <= COUNT($arr)-2; $i++) {
				switch($arr[$i]){
					case 'chk-Classification':
						$resTruncate1 = mysql_query("TRUNCATE TABLE tblref_merchandise_class;", $connection);
						$Count++;
						if($resTruncate1 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tblref_merchandise_class', xmodule = 'Classification';", $connection);
						}
					break;

					case 'chk-Department':
						$resTruncate1 = mysql_query("TRUNCATE TABLE tblref_merchandise_depa;", $connection);
						$Count++;
						if($resTruncate1 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tblref_merchandise_depa', xmodule = 'Department';", $connection);
						}
					break;

					case 'chk-Category':
						$resTruncate1 = mysql_query("TRUNCATE TABLE tblref_merchandisedep_cat;", $connection);
						$Count++;
						if($resTruncate1 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tblref_merchandisedep_cat', xmodule = 'Category';", $connection);
						}
					break;

					case 'chk-Industry':
						$resTruncate1 = mysql_query("TRUNCATE TABLE tblref_industry;", $connection);
						$Count++;
						if($resTruncate1 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tblref_industry', xmodule = 'Industry';", $connection);
						}
					break;

					case 'chk-FloorPlan':
						$resTruncate1 = mysql_query("TRUNCATE TABLE tblref_unitplot;", $connection);
						$resTruncate2 = mysql_query("TRUNCATE TABLE tblref_flr;", $connection);
						$Count++;
						if($resTruncate1 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tblref_unitplot', xmodule = 'Floorplan';", $connection);
							rrmdir("../../../Mall_Attachments/floorplan");
						}
						if($resTruncate2 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tblref_flr', xmodule = 'Floorplan';", $connection);
						}
					break;

					case 'chk-MaintenanceCategory':
						$resTruncate1 = mysql_query("TRUNCATE TABLE tblmaintenance_category;", $connection);
						$Count++;
						if($resTruncate1 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tblmaintenance_category', xmodule = 'Maintenance Category';", $connection);
							rrmdir("../../../Mall_Attachments/Maintenance/Category");
						}
					break;

					case 'chk-MaintenanceTask':
						$resTruncate1 = mysql_query("TRUNCATE TABLE tblmaintenance_tasklist;", $connection);
						$Count++;
						if($resTruncate1 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tblmaintenance_tasklist', xmodule = 'Maintenance Task';", $connection);
						}
					break;

					case 'chk-MaintenanceEquipment':
						$resTruncate1 = mysql_query("DELETE FROM tblmaintenance_equip WHERE xcategory = 'Equipment';", $connection);
						$Count++;
						if($resTruncate1 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tblmaintenance_equip', xmodule = 'Equipment';", $connection);
						}
					break;

					case 'chk-MaintenanceBudget':
						$resTruncate1 = mysql_query("TRUNCATE TABLE tblref_budget;", $connection);
						$Count++;
						if($resTruncate1 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tblref_budget', xmodule = 'Budget';", $connection);
						}
					break;

					case 'chk-Meter':
						$resTruncate1 = mysql_query("TRUNCATE TABLE tblref_meter;", $connection);
						$resTruncate2 = mysql_query("TRUNCATE TABLE tblref_meterlogs;", $connection);
						$Count++;
						if($resTruncate1 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tblref_meter', xmodule = 'Meter';", $connection);
						}
						if($resTruncate2 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tblref_meterlogs', xmodule = 'Meter Logs';", $connection);
						}
					break;

					case 'chk-SecurityandCommunicationSystem':
						$resTruncate1 = mysql_query("DELETE FROM tblmaintenance_equip WHERE xcategory = 'Security and Communication System';", $connection);
						$Count++;
						if($resTruncate1 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tblmaintenance_equip', xmodule = 'Security and Communication System';", $connection);
						}
					break;

					case 'chk-Facilities':
						$resTruncate1 = mysql_query("DELETE FROM tblmaintenance_equip WHERE xcategory = 'Facilities';", $connection);
						$Count++;
						if($resTruncate1 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tblmaintenance_equip', xmodule = 'Facilities';", $connection);
						}
					break;

					case 'chk-HouseRules':
						$resTruncate1 = mysql_query("TRUNCATE TABLE tblmaintenance_houserules;", $connection);
						$Count++;
						if($resTruncate1 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tblmaintenance_houserules', xmodule = 'House Rules';", $connection);
						}
					break;

					case 'chk-BankName':
						$resTruncate1 = mysql_query("TRUNCATE TABLE tblrefbank;", $connection);
						$Count++;
						if($resTruncate1 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tblrefbank', xmodule = 'Bank Name';", $connection);
						}
					break;

					case 'chk-Position':
						$resTruncate1 = mysql_query("TRUNCATE TABLE tblref_companyposition;", $connection);
						$Count++;
						if($resTruncate1 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tblref_companyposition', xmodule = 'Position';", $connection);
						}
					break;

					case 'chk-Requirements':
						$resTruncate1 = mysql_query("TRUNCATE TABLE tblref_applicationrequirements;", $connection);
						$Count++;
						if($resTruncate1 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tblref_applicationrequirements', xmodule = 'Requirements';", $connection);
						}
					break;

					case 'chk-Permits':
						$resTruncate1 = mysql_query("TRUNCATE TABLE tblref_typeofpermits;", $connection);
						$Count++;
						if($resTruncate1 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tblref_typeofpermits', xmodule = 'Permits';", $connection);
						}
					break;

					case 'chk-Charges':
						$resTruncate1 = mysql_query("TRUNCATE TABLE tblref_refcharges;", $connection);
						$Count++;
						if($resTruncate1 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tblref_refcharges', xmodule = 'Charges';", $connection);
						}
					break;

					case 'chk-Penalty':
						$resTruncate1 = mysql_query("TRUNCATE TABLE tblref_penalty;", $connection);
						$Count++;
						if($resTruncate1 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tblref_penalty', xmodule = 'Penalty';", $connection);
						}
					break;

					case 'chk-TermsandConditions':
						$resTruncate1 = mysql_query("TRUNCATE TABLE tblgroups;", $connection);
						$resTruncate2 = mysql_query("TRUNCATE TABLE tblterms;", $connection);
						$resTruncate3 = mysql_query("TRUNCATE TABLE tblcondition;", $connection);
						$resDelete = mysql_query("DELETE FROM refrecordid WHERE tablename = 'tblgroups' OR tablename = 'tblterms' OR tablename = 'tblcondition';", $connection);
						$Count++;
						if($resTruncate1 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tblgroups', xmodule = 'Terms and Conditions';", $connection);
						}
						if($resTruncate2 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tblterms', xmodule = 'Terms and Conditions';", $connection);
						}
						if($resTruncate3 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tblcondition', xmodule = 'Terms and Conditions';", $connection);
						}
					break;

					case 'chk-ComplaintCodes':
						$resTruncate = mysql_query("TRUNCATE TABLE tblcomplaintscode;", $connection);
						$Count++;
					break;

					case 'chk-Leads':
						$resTruncate1 = mysql_query("TRUNCATE TABLE tbltrans_leads;", $connection);
						$resTruncate2 = mysql_query("TRUNCATE TABLE tbltrans_leads_activities;", $connection);
						$resTruncate3 = mysql_query("TRUNCATE TABLE tbltrans_leads_attachments;", $connection);
						$resTruncate4 = mysql_query("TRUNCATE TABLE tbltrans_leads_awareness;", $connection);
						$resTruncate5 = mysql_query("TRUNCATE TABLE tbltrans_leads_closingmeeting;", $connection);
						$resTruncate6 = mysql_query("TRUNCATE TABLE tbltrans_leads_contractsigning;", $connection);
						$resTruncate7 = mysql_query("TRUNCATE TABLE tbltrans_leads_demo;", $connection);
						$resTruncate8 = mysql_query("TRUNCATE TABLE tbltrans_leads_referral;", $connection);
						$resDelete = mysql_query("DELETE FROM refrecordid WHERE tablename = 'tbltrans_leads' OR tablename = 'tbltrans_leads_activities' OR tablename = 'tbltrans_leads_attachments' OR tablename = 'tbltrans_leads_awareness' OR tablename = 'tbltrans_leads_closingmeeting' OR tablename = 'tbltrans_leads_contractsigning' OR tablename = 'tbltrans_leads_demo' OR tablename = 'tbltrans_leads_referral';", $connection);
						$Count++;
						rrmdir("../../../Mall_Attachments/Leads");
						if($resTruncate1 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tbltrans_leads', xmodule = 'Leads';", $connection);
						}
						if($resTruncate2 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tbltrans_leads_activities', xmodule = 'Leads';", $connection);
						}
						if($resTruncate3 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tbltrans_leads_attachments', xmodule = 'Leads';", $connection);
						}
						if($resTruncate4 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tbltrans_leads_awareness', xmodule = 'Leads';", $connection);
						}
						if($resTruncate5 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tbltrans_leads_closingmeeting', xmodule = 'Leads';", $connection);
						}
						if($resTruncate6 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tbltrans_leads_contractsigning', xmodule = 'Leads';", $connection);
						}
						if($resTruncate7 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tbltrans_leads_demo', xmodule = 'Leads';", $connection);
						}
						if($resTruncate8 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tbltrans_leads_referral', xmodule = 'Leads';", $connection);
						}
					break;

					case 'chk-InquiryTenants':
						$resTruncate1 = mysql_query("TRUNCATE TABLE tbltrans_inquiry;", $connection);
						$resTruncate2 = mysql_query("TRUNCATE TABLE tbltrans_appid;", $connection);
						$resTruncate3 = mysql_query("TRUNCATE TABLE tbltrans_tenants;", $connection);
						$resTruncate4 = mysql_query("TRUNCATE TABLE tblcontract;", $connection);
						$resTruncate5 = mysql_query("TRUNCATE TABLE tbltrans_company;", $connection);
						$resTruncate6 = mysql_query("TRUNCATE TABLE tbltrans_company_contact_person;", $connection);
						$resTruncate7 = mysql_query("TRUNCATE TABLE tbltrans_company_contact_person_contacts;", $connection);
						$resTruncate8 = mysql_query("TRUNCATE TABLE tbltrans_company_contacts;", $connection);
						$resTruncate9 = mysql_query("TRUNCATE TABLE tbltrans_company_owner_contacts;", $connection);
						$resTruncate10 = mysql_query("TRUNCATE TABLE tbltrans_companysig;", $connection);
						$resTruncate11 = mysql_query("TRUNCATE TABLE tbltrans_remarks;", $connection);
						$resTruncate12 = mysql_query("TRUNCATE TABLE tbltrans_tradename;", $connection);
						$resTruncate13 = mysql_query("TRUNCATE TABLE tblaccreditation;", $connection);
						$resTruncate14 = mysql_query("TRUNCATE TABLE tblaccreditationdocs;", $connection);
						$resTruncate15 = mysql_query("TRUNCATE TABLE tblaccreditationlogs;", $connection);
						$resDelete = mysql_query("DELETE FROM refrecordid WHERE tablename = 'tbltrans_tenants' OR tablename = 'tbltrans_inquiry' OR tablename = 'tblcontract' OR tablename = 'tbltrans_company' OR tablename = 'tbltrans_company_contact_person' OR tablename = 'tbltrans_tradename' OR tablename = 'tbltrans_remarks' OR tablename = 'tblaccreditation' OR tablename = 'tblaccreditationlogs';", $connection);
						$Count++;
						rrmdir("../../../Mall_Attachments/company");
						rrmdir("../../../Mall_Attachments/Permits");
						rrmdir("../../../Mall_Attachments/Requirements");
						if($resTruncate1 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tbltrans_inquiry', xmodule = 'Tenants';", $connection);
						}
						if($resTruncate2 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tbltrans_appid', xmodule = 'Tenants';", $connection);
						}
						if($resTruncate3 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tbltrans_tenants', xmodule = 'Tenants';", $connection);
						}
						if($resTruncate4 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tblcontract', xmodule = 'Tenants';", $connection);
						}
						if($resTruncate5 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tbltrans_company', xmodule = 'Tenants';", $connection);
						}
						if($resTruncate6 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tbltrans_company_contact_person', xmodule = 'Tenants';", $connection);
						}
						if($resTruncate7 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tbltrans_company_contact_person_contacts', xmodule = 'Tenants';", $connection);
						}
						if($resTruncate8 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tbltrans_company_contacts', xmodule = 'Tenants';", $connection);
						}
						if($resTruncate9 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tbltrans_company_owner_contacts', xmodule = 'Tenants';", $connection);
						}
						if($resTruncate10 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tbltrans_companysig', xmodule = 'Tenants';", $connection);
						}
						if($resTruncate11 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tbltrans_remarks', xmodule = 'Tenants';", $connection);
						}
						if($resTruncate12 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tbltrans_tradename', xmodule = 'Tenants';", $connection);
						}
						if($resTruncate13 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tblaccreditation', xmodule = 'Tenants';", $connection);
						}
						if($resTruncate14 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tblaccreditationdocs', xmodule = 'Tenants';", $connection);
						}
						if($resTruncate15 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tblaccreditationlogs', xmodule = 'Tenants';", $connection);
						}
					break;

					case 'chk-TenantsRequest':
						$resTruncate1 = mysql_query("TRUNCATE TABLE tbltrans_tenantsrequest;", $connection);
						$Count++;
						if($resTruncate1 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tbltrans_tenantsrequest', xmodule = 'Tenant Request';", $connection);
						}
					break;

					case 'chk-Billing':
						$resTruncate1 = mysql_query("TRUNCATE TABLE tblref_billperiod;", $connection);
						$resTruncate2 = mysql_query("TRUNCATE TABLE tblref_msbilling;", $connection);
						$resTruncate3 = mysql_query("TRUNCATE TABLE tbltransaction;", $connection);
						$resTruncate4 = mysql_query("TRUNCATE TABLE dunn_soadate;", $connection);
						$resTruncate5 = mysql_query("TRUNCATE TABLE dunn_tblsoadetails;", $connection);
						$resTruncate6 = mysql_query("TRUNCATE TABLE dunn_tblsoaheader;", $connection);
						$resTruncate7 = mysql_query("TRUNCATE TABLE tbltrans_pdc;", $connection);
						$resDelete = mysql_query("DELETE FROM refrecordid WHERE tablename = 'dunn_tblsoaheader';", $connection);
						$Count++;
						rrmdir("../../../Mall_Attachments/Billing");
						if($resTruncate1 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tblref_billperiod', xmodule = 'Billing';", $connection);
						}
						if($resTruncate2 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tblref_msbilling', xmodule = 'Billing';", $connection);
						}
						if($resTruncate3 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tbltransaction', xmodule = 'Billing';", $connection);
						}
						if($resTruncate4 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate dunn_soadate', xmodule = 'Billing';", $connection);
						}
						if($resTruncate5 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate dunn_tblsoadetails', xmodule = 'Billing';", $connection);
						}
						if($resTruncate6 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate dunn_tblsoaheader', xmodule = 'Billing';", $connection);
						}
						if($resTruncate7 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tbltrans_pdc', xmodule = 'Billing';", $connection);
						}
					break;

					case 'chk-Maintenance':
						$resTruncate1 = mysql_query("TRUNCATE TABLE tblmaintenance_workorder;", $connection);
						$resTruncate2 = mysql_query("TRUNCATE TABLE tblmaintenance_workorderlist;", $connection);
						$resTruncate3 = mysql_query("TRUNCATE TABLE tblref_msmaintenance_h;", $connection);
						$resTruncate4 = mysql_query("TRUNCATE TABLE tblref_msmaintenance_d;", $connection);
						$resDelete = mysql_query("DELETE FROM refrecordid WHERE tablename = 'tblmaintenance_workorder' OR tablename = 'tblref_MSMaintenance_h';", $connection);
						$Count++;
						rrmdir("../../../Mall_Attachments/Maintenance/Reading");
						rrmdir("../../../Mall_Attachments/Maintenance/Signature");
						if($resTruncate1 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tblmaintenance_workorder', xmodule = 'Maintenance';", $connection);
						}
						if($resTruncate2 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tblmaintenance_workorderlist', xmodule = 'Maintenance';", $connection);
						}
						if($resTruncate3 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tblref_msmaintenance_h', xmodule = 'Maintenance';", $connection);
						}
						if($resTruncate4 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tblref_msmaintenance_d', xmodule = 'Maintenance';", $connection);
						}
					break;

					case 'chk-Complaints':
						$resTruncate = mysql_query("TRUNCATE TABLE tblcomplaints;", $connection);
						$resDelete = mysql_query("DELETE FROM refrecordid WHERE tablename = 'tblcomplaints';", $connection);
						$Count++;
						if($resTruncate1 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tblcomplaints', xmodule = 'Complaints';", $connection);
						}
					break;

					case 'chk-MallConfig':
						$resTruncate1 = mysql_query("TRUNCATE TABLE mall_setup;", $connection);
						$resTruncate2 = mysql_query("TRUNCATE TABLE tblref_amenities;", $connection);
						$resTruncate3 = mysql_query("TRUNCATE TABLE tblref_floorsetup;", $connection);
						$resTruncate4 = mysql_query("TRUNCATE TABLE tblref_mall;", $connection);
						$resTruncate5 = mysql_query("TRUNCATE TABLE tblref_mallbankinfo;", $connection);
						$resTruncate6 = mysql_query("TRUNCATE TABLE tblref_unit;", $connection);
						$resTruncate7 = mysql_query("TRUNCATE TABLE tblref_unit_amenities;", $connection);
						$resTruncate8 = mysql_query("TRUNCATE TABLE tblref_unitplot;", $connection);
						$resTruncate9 = mysql_query("TRUNCATE TABLE tblref_wing;", $connection);
						$resTruncate10 = mysql_query("TRUNCATE TABLE tblunit_statuslogs;", $connection);
						$resDelete = mysql_query("DELETE FROM refrecordid WHERE tablename = 'tblref_amenities' OR tablename = 'tblref_floorsetup' OR tablename = 'tblref_floorsetup' OR tablename = 'tblref_mall' OR tablename = 'tblref_wing' OR tablename = 'tblref_unit';", $connection);
						$Count++;
						rrmdir("../../../Mall_Attachments/mall_image");
						rrmdir("../../../Mall_Attachments/Unit Image");
						if($resTruncate1 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate mall_setup', xmodule = 'Mall Configuration';", $connection);
						}
						if($resTruncate2 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tblref_amenities', xmodule = 'Mall Configuration';", $connection);
						}
						if($resTruncate3 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tblref_floorsetup', xmodule = 'Mall Configuration';", $connection);
						}
						if($resTruncate4 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tblref_mall', xmodule = 'Mall Configuration';", $connection);
						}
						if($resTruncate5 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tblref_mallbankinfo', xmodule = 'Mall Configuration';", $connection);
						}
						if($resTruncate6 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tblref_unit', xmodule = 'Mall Configuration';", $connection);
						}
						if($resTruncate7 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tblref_unit_amenities', xmodule = 'Mall Configuration';", $connection);
						}
						if($resTruncate8 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tblref_unitplot', xmodule = 'Mall Configuration';", $connection);
						}
						if($resTruncate9 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tblref_wing', xmodule = 'Mall Configuration';", $connection);
						}
						if($resTruncate10 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tblunit_statuslogs', xmodule = 'Mall Configuration';", $connection);
						}
					break;

					case 'chk-UserAcce':
						$resTruncate1 = mysql_query("TRUNCATE TABLE tblref_usergroupaccess;", $connection);
						$resTruncate2 = mysql_query("TRUNCATE TABLE tbluser;", $connection);
						$resTruncate3 = mysql_query("TRUNCATE TABLE tblref_apprlistperuser;", $connection);
						$resTruncate4 = mysql_query("TRUNCATE TABLE tblref_groupaccess;", $connection);
						$resDelete = mysql_query("DELETE FROM refrecordid WHERE tablename = 'tbluser' OR tablename = 'tblref_groupaccess';", $connection);
						$Count++;
						rrmdir("../../../Mall_Attachments/User");
						if($resTruncate1 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tblref_usergroupaccess', xmodule = 'User and Accessibilities';", $connection);
						}
						if($resTruncate2 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tbluser', xmodule = 'User and Accessibilities';", $connection);
						}
						if($resTruncate3 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tblref_apprlistperuser', xmodule = 'User and Accessibilities';", $connection);
						}
						if($resTruncate4 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tblref_groupaccess', xmodule = 'User and Accessibilities';", $connection);
						}
					break;

					case 'chk-AuditTrail':
						$resTruncate = mysql_query("TRUNCATE TABLE tbllog_sheet;", $connection);
						$resDelete = mysql_query("DELETE FROM refrecordid WHERE tablename = 'tbllog_sheet';", $connection);
						$Count++;
						if($resTruncate1 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tbllog_sheet', xmodule = 'Audit Trail';", $connection);
						}
					break;

					case 'chk-FileMonitoring':
						$resTruncate1 = mysql_query("TRUNCATE TABLE fdb_discount;", $connection);
						$resTruncate2 = mysql_query("TRUNCATE TABLE fdb_not_paymenttypes;", $connection);
						$resTruncate3 = mysql_query("TRUNCATE TABLE fdb_paymenttypes;", $connection);
						$resTruncate4 = mysql_query("TRUNCATE TABLE fdb_perhour;", $connection);
						$resTruncate5 = mysql_query("TRUNCATE TABLE fdb_sales;", $connection);
						$resTruncate6 = mysql_query("TRUNCATE TABLE fdb_salesbymn;", $connection);
						$resTruncate7 = mysql_query("TRUNCATE TABLE fdb_void;", $connection);
						$resTruncate8 = mysql_query("TRUNCATE TABLE sdb_discount;", $connection);
						$resTruncate9 = mysql_query("TRUNCATE TABLE sdb_not_paymenttypes;", $connection);
						$resTruncate10 = mysql_query("TRUNCATE TABLE sdb_paymenttypes;", $connection);
						$resTruncate11 = mysql_query("TRUNCATE TABLE sdb_perhour;", $connection);
						$resTruncate12 = mysql_query("TRUNCATE TABLE sdb_sales;", $connection);
						$resTruncate13 = mysql_query("TRUNCATE TABLE sdb_salesbymn;", $connection);
						$resTruncate14 = mysql_query("TRUNCATE TABLE sdb_void;", $connection);
						$resTruncate15 = mysql_query("TRUNCATE TABLE db_syncfilestat;", $connection);
						$resTruncate16 = mysql_query("TRUNCATE TABLE db_settimeupload;", $connection);
						$Count++;
						if($resTruncate1 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate fdb_discount', xmodule = 'File Monitoring';", $connection);
						}
						if($resTruncate2 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate fdb_not_paymenttypes', xmodule = 'File Monitoring';", $connection);
						}
						if($resTruncate3 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate fdb_paymenttypes', xmodule = 'File Monitoring';", $connection);
						}
						if($resTruncate4 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate fdb_perhour', xmodule = 'File Monitoring';", $connection);
						}
						if($resTruncate5 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate fdb_sales', xmodule = 'File Monitoring';", $connection);
						}
						if($resTruncate6 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate fdb_salesbymn', xmodule = 'File Monitoring';", $connection);
						}
						if($resTruncate7 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate fdb_void', xmodule = 'File Monitoring';", $connection);
						}
						if($resTruncate8 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate sdb_discount', xmodule = 'File Monitoring';", $connection);
						}
						if($resTruncate9 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate sdb_not_paymenttypes', xmodule = 'File Monitoring';", $connection);
						}
						if($resTruncate10 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate sdb_paymenttypes', xmodule = 'File Monitoring';", $connection);
						}
						if($resTruncate11 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate sdb_perhour', xmodule = 'File Monitoring';", $connection);
						}
						if($resTruncate12 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate sdb_sales', xmodule = 'File Monitoring';", $connection);
						}
						if($resTruncate13 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate sdb_salesbymn', xmodule = 'File Monitoring';", $connection);
						}
						if($resTruncate14 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate sdb_void', xmodule = 'File Monitoring';", $connection);
						}
						if($resTruncate15 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate db_syncfilestat', xmodule = 'File Monitoring';", $connection);
						}
						if($resTruncate16 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate db_settimeupload', xmodule = 'File Monitoring';", $connection);
						}
					break;

					case 'chk-BaggageLogs':
						$resTruncate1 = mysql_query("TRUNCATE TABLE tbltrans_items;", $connection);
						$resDelete = mysql_query("DELETE FROM refrecordid WHERE tablename = 'tbltrans_items';", $connection);
						$Count++;
						if($resTruncate1 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tbltrans_items', xmodule = 'Baggage Logs';", $connection);
						}
					break;

					case 'chk-VisitorLogs':
						$resTruncate1 = mysql_query("TRUNCATE TABLE tbl_visitor;", $connection);
						$resDelete = mysql_query("DELETE FROM refrecordid WHERE tablename = 'tbl_visitor';", $connection);
						$Count++;
						if($resTruncate1 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tbl_visitor', xmodule = 'Visitor Logs';", $connection);
						}
					break;

					case 'chk-UserLogs':
						$resTruncate1 = mysql_query("TRUNCATE TABLE tbllog_sheet;", $connection);
						$resDelete = mysql_query("DELETE FROM refrecordid WHERE tablename = 'tbllog_sheet';", $connection);
						$Count++;
						if($resTruncate1 == true){
							//INSERT LOG FIRST - JONAS - 2/4/2019
							$LogID = createidno("LOG", "tbllogs_zaputility", "logID");
							$Logs = mysql_query("INSERT INTO tbllogs_zaputility SET logID = '". $LogID ."', userid = '". $_SESSION['MMS-UserID'] ."', username = '". $username ."', mydate = '". date('Y-m-d') ."', mytime = '". date('H:i:s') ."', xinfo = 'Truncate tbllog_sheet', xmodule = 'User Logs';", $connection);
						}
					break;	
				}
			}


			//INSERT LOG FIRST - JONAS - 12/7/2018
			if($Count >= 1){
				echo 1;
			}else{
				echo 2;
			}
		break;
	}

?>