<?php 
session_start();
include "../../connect.php";
	switch ($_POST['form']) {
		case 'savesystemsetup':
			$checksetup = mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM tblsys_setup;", $connection));
			$machineno = mysql_fetch_array(mysql_query("SELECT COUNT(Machine_No) FROM tblmachine WHERE Machine_No = '". $_POST['machineno'] ."';", $connection));
			if($machineno[0] != 0){
				echo "1|Machine number already existing";
			}else{
				if($checksetup[0] == "0"){
					$sql = "INSERT INTO tblsys_setup SET corporatename = '". $_POST['name'] ."', about = '". $_POST['about'] ."', address = '". $_POST['address'] ."', contactnumber = '". $_POST['mobilenum'] ."', emailaddress = '". $_POST['email'] ."', maxnumofmall = '". $_POST['numofmall'] ."', template = '". $_POST['template'] ."', mallprefix = '". $_POST['mallprefix'] ."', inqprefix = '". $_POST['inqprefix'] ."', appprefix = '". $_POST['appprefix'] ."', TIN_number = '". $_POST['tin'] ."', Telephone_number = '". $_POST['telephone'] ."', Fax_number = '". $_POST['fax'] ."', website = '". $_POST['website'] ."', Machine_No = '". $_POST['machineno'] ."', Serial_No = '". $_POST['serialno'] ."', Accreditation_No = '". $_POST['accreditation'] ."', softwaretype = '". $_POST['softwaretype'] ."', filepath = '". mysql_real_escape_string($_POST['csvpath']) ."', dbsetup = '". $_POST['dbsetup'] ."', SFTPHost = '". mysql_real_escape_string($_POST['Host']) ."', SFTPPort = '". $_POST['Port'] ."';";

					$arrHeader = ["Corporate Name", "About", "Address", "Contact Number", "Email Address", "Max Number of Mall", "Template", "Mall ID Prefix", "Inquiry ID Prefix", "Application ID Prefix", "TIN Number", "Telephone Number", "Fax Number", "Website", "Machine_No", "Serial Number", "Accreditation Number", "CSV File Path", "Database Setup", "SFTP Host", "SFTP Port"];

					$arrFields = ["corporatename", "about", "address", "contactnumber", "emailaddress", "maxnumofmall", "template", "mallprefix", "inqprefix", "appprefix", "TIN_number", "Telephone_number", "Fax_number", "website", "Machine_No", "Serial_No", "Accreditation_No", "filepath", "dbsetup", "SFTPHost", "SFTPPort"];

					$arrValue = [$_POST['name'], $_POST['about'], $_POST['address'], $_POST['mobilenum'], $_POST['email'], $_POST['numofmall'], $_POST['template'], $_POST['mallprefix'], $_POST['inqprefix'], $_POST['appprefix'], $_POST['tin'], $_POST['telephone'], $_POST['fax'], $_POST['website'], $_POST['machineno'], $_POST['serialno'], $_POST['accreditation'], $_POST['csvpath'], $_POST['dbsetup'], $_POST['Host'], $_POST['Port']];

					$Logs = createXinfo("INSERT", $arrHeader, $arrFields, $arrValue, "tblsys_setup", "", "");
					if($Logs != ""){
						$tran_logs = create_logs_per_transaction("modified the company profile setup.", "System Setup", $Logs, "" ,"ADD", "");
					}
				}else{
					$sql = "UPDATE tblsys_setup SET corporatename = '". $_POST['name'] ."', about = '". $_POST['about'] ."', address = '". $_POST['address'] ."', contactnumber = '". $_POST['mobilenum'] ."', emailaddress = '". $_POST['email'] ."', maxnumofmall = '". $_POST['numofmall'] ."', template = '". $_POST['template'] ."', mallprefix = '". $_POST['mallprefix'] ."', inqprefix = '". $_POST['inqprefix'] ."', appprefix = '". $_POST['appprefix'] ."', TIN_number = '". $_POST['tin'] ."', Telephone_number = '". $_POST['telephone'] ."', Fax_number = '". $_POST['fax'] ."', website = '". $_POST['website'] ."', Machine_No = '". $_POST['machineno'] ."', Serial_No = '". $_POST['serialno'] ."', Accreditation_No = '". $_POST['accreditation'] ."', softwaretype = '". $_POST['softwaretype'] ."', filepath = '". mysql_real_escape_string($_POST['csvpath']) ."', dbsetup = '". $_POST['dbsetup'] ."', SFTPHost = '". mysql_real_escape_string($_POST['Host']) ."', SFTPPort = '". $_POST['Port'] ."';";

					$arrHeader = ["Corporate Name", "About", "Address", "Contact Number", "Email Address", "Max Number of Mall", "Template", "Mall ID Prefix", "Inquiry ID Prefix", "Application ID Prefix", "TIN Number", "Telephone Number", "Fax Number", "Website", "Machine_No", "Serial Number", "Accreditation Number", "CSV File Path", "Database Setup", "SFTP Host", "SFTP Port"];

					$arrFields = ["corporatename", "about", "address", "contactnumber", "emailaddress", "maxnumofmall", "template", "mallprefix", "inqprefix", "appprefix", "TIN_number", "Telephone_number", "Fax_number", "website", "Machine_No", "Serial_No", "Accreditation_No", "filepath", "dbsetup", "SFTPHost", "SFTPPort"];

					$arrValue = [$_POST['name'], $_POST['about'], $_POST['address'], $_POST['mobilenum'], $_POST['email'], $_POST['numofmall'], $_POST['template'], $_POST['mallprefix'], $_POST['inqprefix'], $_POST['appprefix'], $_POST['tin'], $_POST['telephone'], $_POST['fax'], $_POST['website'], $_POST['machineno'], $_POST['serialno'], $_POST['accreditation'], $_POST['csvpath'], $_POST['dbsetup'], $_POST['Host'], $_POST['Port']];

					$Logs = createXinfo("UPDATE", $arrHeader, $arrFields, $arrValue, "tblsys_setup", "1", "");
					if($Logs != ""){
						$tran_logs = create_logs_per_transaction("modified the company profile setup.", "System Setup", $Logs, "" ,"UPDATE", "1");
					}
				}
				$res = mysql_query($sql, $connection);
				if($res == true){
					echo "2|Setup configuration successful";
					if (!file_exists($_POST['csvpath'])) {
						mkdir($_POST['csvpath'], 0777, true);
					}
				}else{
					echo "3|An error has occured";
				}
			}
		break;

		case 'loadsetup':
			$row = mysql_fetch_array(mysql_query("SELECT corporatename, about, address, contactnumber, emailaddress, maxnumofmall, template, corporatelogo, id, mallprefix, inqprefix, appprefix, TIN_number, Telephone_number, Fax_number, website, Machine_No, Serial_No, Accreditation_No, softwaretype, filepath, dbsetup, SFTPHost, SFTPPort FROM tblsys_setup;", $connection));

			if($row['corporatelogo'] == ""){
				$img = "assets/images/noimage5.png";
			}else{
				$img = "../Mall_Attachments/SysLogo/".$row['corporatelogo'];
			}

			if($row['softwaretype'] == ""){
				$SoftwareType = 0;
			}else{
				$SoftwareType = $row['softwaretype'];
			}

			echo "|" . $row['corporatename'] . "|" . $row['about'] . "|" . $row['address'] . "|" . $row['contactnumber'] . "|" . $row['emailaddress'] . "|" . $row['maxnumofmall'] . "|" . $row['template'] . "|" . $img . "|" . $row['id'] . "|" . $row['mallprefix'] . "|" . $row['inqprefix'] . "|" . $row['appprefix'] . "|" . $row['corporatelogo'] . "|" . $row['TIN_number'] . "|" . $row['Telephone_number'] . "|" . $row['Fax_number'] . "|" . $row['website'] . "|" . $row['Machine_No'] . "|" . $row['Serial_No'] . "|" . $row['Accreditation_No'] . "|" . $SoftwareType . "|" . $row['filepath'] . "|" . $row['dbsetup'] . "|" . $row['SFTPHost'] . "|" . $row['SFTPPort'];
		break;

		case 'testconnection':
			$servername = $_POST['HostAddress'];
			$username = $_POST['Username'];
			$password = $_POST['Password'];

			$connection2 = mysql_connect($servername, $username, $password);
			if (!$connection2) {
				die('3');
			}else{
			  	$existing = mysql_fetch_array(mysql_query("SELECT COUNT(HostAddress) FROM tblsys_connsetup;", $connection));
			  	if($existing[0] == "0"){
			  		$sql = "INSERT INTO tblsys_connsetup SET HostAddress = '". mysql_escape_string($_POST['HostAddress']) ."', Username = '". mysql_escape_string($_POST['Username']) ."', Password = '". mysql_escape_string($_POST['Password']) ."', Port = '". mysql_escape_string($_POST['Port']) ."';";
			  	}else{
			  		$sql = "UPDATE tblsys_connsetup SET HostAddress = '". mysql_escape_string($_POST['HostAddress']) ."', Username = '". mysql_escape_string($_POST['Username']) ."', Password = '". mysql_escape_string($_POST['Password']) ."', Port = '". mysql_escape_string($_POST['Port']) ."';";
			  	}
			  	$res = mysql_query($sql, $connection);
			  	if($res == true){
			  		echo 1;
			  	}else{
			  		echo 2;
			  	}
			}
		break;

		case 'loadconnectionsetup':
			$connsetup = mysql_fetch_array(mysql_query("SELECT HostAddress, Username, Password, Port FROM tblsys_connsetup;", $connection));
			echo $connsetup[0] . "|" . $connsetup[1] . "|" . $connsetup[2] . "|" . $connsetup[3];
		break;

		case 'SaveLeaseSys':
			$CurrentSetup = mysql_fetch_array(mysql_query("SELECT id, reqandpermit, adjustoccupancy, automerchantcode, floorandunitmeasurement, vatsetup, isClassification, isDepartment, isCategory, isAssocDues, isMultiCompSig, isOccupancy, isJDAMapping FROM tblsys_setup;", $connection));
			if($CurrentSetup['id'] == ""){
				$res = mysql_query("INSERT INTO tblsys_setup SET reqandpermit = '". $_POST['Setup1'] ."', adjustoccupancy = '". $_POST['Setup2'] ."', automerchantcode = '". $_POST['Setup3'] ."', floorandunitmeasurement = '". $_POST['FlrUnit'] ."', vatsetup = '". $_POST['Setup4'] ."', isClassification = '". $_POST['isClassification'] ."', isDepartment = '". $_POST['isDepartment'] ."', isCategory = '". $_POST['isCategory'] ."', isAssocDues = '". $_POST['isAssocDues'] ."', isMultiCompSig = '". $_POST['isMultiCompSig'] ."', isOccupancy = '". $_POST['isOccupancy'] ."', isJDAMapping = '". $_POST['JDAMapping'] ."';", $connection);
				if($res == true){
					echo "1";
				}
				if($_POST['Setup1'] != ""){
					if($_POST['Setup1'] == 1){
						$Setup1 = "Yes";
					}else{
						$Setup1 = "No";
					}
					$Logs .= "Require selection of permits and requirements in proposal : ". $Setup1 . "|";
				}
				if($_POST['Setup2'] != ""){
					if($_POST['Setup2'] == 1){
						$Setup2 = "Yes";
					}else{
						$Setup2 = "No";
					}
					$Logs .= "Adjust occupancy period based on Occupy Unit button : ". $Setup2 . "|";
				}
				if($_POST['Setup3'] != ""){
					if($_POST['Setup3'] == 1){
						$Setup3 = "Yes";
					}else{
						$Setup3 = "No";
					}
					$Logs .= "Auto generate merchant code : ". $Setup3 . "|";
				}
				if($_POST['FlrUnit'] != ""){
					$Logs .= "Floor / Unit Measurement : ". $_POST['FlrUnit'] . "|";
				}
				if($_POST['isClassification'] != ""){
					if($_POST['isClassification'] == 1){
						$isClassification = "Yes";
					}else{
						$isClassification = "No";
					}
					$Logs .= "Show Classification : ". $isClassification . "|";
				}
				if($_POST['isDepartment'] != ""){
					if($_POST['isDepartment'] == 1){
						$isDepartment = "Yes";
					}else{
						$isDepartment = "No";
					}
					$Logs .= "Show Department : ". $isDepartment . "|";
				}
				if($_POST['isCategory'] != ""){
					if($_POST['isCategory'] == 1){
						$isCategory = "Yes";
					}else{
						$isCategory = "No";
					}
					$Logs .= "Show Department : ". $isCategory . "|";
				}
				if($_POST['isAssocDues'] != ""){
					if($_POST['isAssocDues'] == 1){
						$isAssocDues = "Yes";
					}else{
						$isAssocDues = "No";
					}
					$Logs .= "Include Association Dues : ". $isAssocDues . "|";
				}
				if($_POST['isMultiCompSig'] != ""){
					if($_POST['isMultiCompSig'] == 1){
						$isMultiCompSig = "Yes";
					}else{
						$isMultiCompSig = "No";
					}
					$Logs .= "Allow Multiple Signatory on Company Profile : ". $isMultiCompSig . "|";
				}
				if($_POST['isOccupancy'] != ""){
					if($_POST['isOccupancy'] == 1){
						$Setup1 = "Yes";
					}else{
						$Setup1 = "No";
					}
					$Logs .= "Deduct 1 Day to Occupancy Period : ". $Setup1 . "|";
				}
				if($_POST['JDAMapping'] != ""){
					if($_POST['JDAMapping'] == 1){
						$JDAMapping = "Yes";
					}else{
						$JDAMapping = "No";
					}
					$Logs .= "Allow JDA Mapping : ". $JDAMapping . "|";
				}
				if($Logs != ""){
					$tran_logs = create_logs_per_transaction("modified other setup.", "System Setup", $Logs, "" ,"ADD", "");
				}
			}else{
				$res = mysql_query("UPDATE tblsys_setup SET reqandpermit = '". $_POST['Setup1'] ."', adjustoccupancy = '". $_POST['Setup2'] ."', automerchantcode = '". $_POST['Setup3'] ."', floorandunitmeasurement = '". $_POST['FlrUnit'] ."', vatsetup = '". $_POST['Setup4'] ."', isClassification = '". $_POST['isClassification'] ."', isDepartment = '". $_POST['isDepartment'] ."', isCategory = '". $_POST['isCategory'] ."', isAssocDues = '". $_POST['isAssocDues'] ."', isMultiCompSig = '". $_POST['isMultiCompSig'] ."', isOccupancy = '". $_POST['isOccupancy'] ."', isJDAMapping = '". $_POST['JDAMapping'] ."';", $connection);
				if($res == true){
					echo "1";
				}
				if($CurrentSetup['reqandpermit'] != $_POST['Setup1']){
					if($CurrentSetup['reqandpermit'] == 1){
						$Variable1 = "Yes";
					}else{
						$Variable1 = "No";
					}
					if($_POST['Setup1'] == 1){
						$Variable2 = "Yes";
					}else{
						$Variable2 = "No";
					}
					if($CurrentSetup['reqandpermit'] == ""){
						$Logs .= "Require selection of permits and requirements in proposal : ". $Variable2 . "|";
					}else{
						$Logs .= "Require selection of permits and requirements in proposal : From ". $Variable1 ." To ". $Variable2 . "|";
					}
				}
				if($CurrentSetup['adjustoccupancy'] != $_POST['Setup2']){
					if($CurrentSetup['adjustoccupancy'] == 1){
						$Variable1 = "Yes";
					}else{
						$Variable1 = "No";
					}
					if($_POST['Setup2'] == 1){
						$Variable2 = "Yes";
					}else{
						$Variable2 = "No";
					}
					if($CurrentSetup['adjustoccupancy'] == ""){
						$Logs .= "Adjust occupancy period based on Occupy Unit button : ". $Variable2 . "|";
					}else{
						$Logs .= "Adjust occupancy period based on Occupy Unit button : From ". $Variable1 ." To ". $Variable2 . "|";
					}
				}
				if($CurrentSetup['automerchantcode'] != $_POST['Setup3']){
					if($CurrentSetup['automerchantcode'] == 1){
						$Variable1 = "Yes";
					}else{
						$Variable1 = "No";
					}
					if($_POST['Setup3'] == 1){
						$Variable2 = "Yes";
					}else{
						$Variable2 = "No";
					}
					if($CurrentSetup['automerchantcode'] == ""){
						$Logs .= "Auto generate merchant code : ". $Variable2 . "|";
					}else{
						$Logs .= "Auto generate merchant code : From ". $Variable1 ." To ". $Variable2 . "|";
					}
				}
				if($CurrentSetup['floorandunitmeasurement'] != $_POST['FlrUnit']){
					if($CurrentSetup['floorandunitmeasurement'] == ""){
						$Logs .= "Floor / Unit Measurement : ". $_POST['FlrUnit'] . "|";
					}else{
						$Logs .= "Floor / Unit Measurement : From ". $CurrentSetup['floorandunitmeasurement'] ." To ". $_POST['FlrUnit'] . "|";
					}
				}
				if($CurrentSetup['vatsetup'] != $_POST['Setup4']){
					if($CurrentSetup['vatsetup'] == 1){
						$Variable1 = "Yes";
					}else{
						$Variable1 = "No";
					}
					if($_POST['Setup4'] == 1){
						$Variable2 = "Yes";
					}else{
						$Variable2 = "No";
					}
					if($CurrentSetup['vatsetup'] == ""){
						$Logs .= "VAT Setup : ". $Variable2 . "|";
					}else{
						$Logs .= "VAT Setup : From ". $Variable1 ." To ". $Variable2 . "|";
					}
				}
				if($CurrentSetup['isClassification'] != $_POST['isClassification']){
					if($CurrentSetup['isClassification'] == 1){
						$Variable1 = "Yes";
					}else{
						$Variable1 = "No";
					}
					if($_POST['isClassification'] == 1){
						$Variable2 = "Yes";
					}else{
						$Variable2 = "No";
					}
					if($CurrentSetup['isClassification'] == ""){
						$Logs .= " :Show Classification ". $Variable2 . "|";
					}else{
						$Logs .= " :Show Classification From ". $Variable1 ." To ". $Variable2 . "|";
					}
				}
				if($CurrentSetup['isDepartment'] != $_POST['isDepartment']){
					if($CurrentSetup['isDepartment'] == 1){
						$Variable1 = "Yes";
					}else{
						$Variable1 = "No";
					}
					if($_POST['isDepartment'] == 1){
						$Variable2 = "Yes";
					}else{
						$Variable2 = "No";
					}
					if($CurrentSetup['isDepartment'] == ""){
						$Logs .= "Show Department : ". $Variable2 . "|";
					}else{
						$Logs .= "Show Department : From ". $Variable1 ." To ". $Variable2 . "|";
					}
				}
				if($CurrentSetup['isCategory'] != $_POST['isCategory']){
					if($CurrentSetup['isCategory'] == 1){
						$Variable1 = "Yes";
					}else{
						$Variable1 = "No";
					}
					if($_POST['isCategory'] == 1){
						$Variable2 = "Yes";
					}else{
						$Variable2 = "No";
					}
					if($CurrentSetup['isCategory'] == ""){
						$Logs .= "Show Category : ". $Variable2 . "|";
					}else{
						$Logs .= "Show Category : From ". $Variable1 ." To ". $Variable2 . "|";
					}
				}
				if($CurrentSetup['isAssocDues'] != $_POST['isAssocDues']){
					if($CurrentSetup['isAssocDues'] == 1){
						$Variable1 = "Yes";
					}else{
						$Variable1 = "No";
					}
					if($_POST['isAssocDues'] == 1){
						$Variable2 = "Yes";
					}else{
						$Variable2 = "No";
					}
					if($CurrentSetup['isAssocDues'] == ""){
						$Logs .= "Include Association Dues : ". $Variable2 . "|";
					}else{
						$Logs .= "Include Association Dues : From ". $Variable1 ." To ". $Variable2 . "|";
					}
				}
				if($CurrentSetup['isMultiCompSig'] != $_POST['isMultiCompSig']){
					if($CurrentSetup['isMultiCompSig'] == 1){
						$Variable1 = "Yes";
					}else{
						$Variable1 = "No";
					}
					if($_POST['isMultiCompSig'] == 1){
						$Variable2 = "Yes";
					}else{
						$Variable2 = "No";
					}
					if($CurrentSetup['isMultiCompSig'] == ""){
						$Logs .= "Allow Multiple Signatory on Company Profile : ". $Variable2 . "|";
					}else{
						$Logs .= "Allow Multiple Signatory on Company Profile : From ". $Variable1 ." To ". $Variable2 . "|";
					}
				}
				if($CurrentSetup['isOccupancy'] != $_POST['isOccupancy']){
					if($CurrentSetup['isOccupancy'] == 1){
						$Variable1 = "Yes";
					}else{
						$Variable1 = "No";
					}
					if($_POST['isOccupancy'] == 1){
						$Variable2 = "Yes";
					}else{
						$Variable2 = "No";
					}
					if($CurrentSetup['isOccupancy'] == ""){
						$Logs .= "Deduct 1 Day to Occupancy Period : ". $Variable2 . "|";
					}else{
						$Logs .= "Deduct 1 Day to Occupancy Period : From ". $Variable1 ." To ". $Variable2 . "|";
					}
				}
				if($CurrentSetup['isJDAMapping'] != $_POST['JDAMapping']){
					if($CurrentSetup['isJDAMapping'] == 1){
						$Variable1 = "Yes";
					}else{
						$Variable1 = "No";
					}
					if($_POST['JDAMapping'] == 1){
						$Variable2 = "Yes";
					}else{
						$Variable2 = "No";
					}
					if($CurrentSetup['isJDAMapping'] == ""){
						$Logs .= "Allow JDA Mapping : ". $Variable2 . "|";
					}else{
						$Logs .= "Allow JDA Mapping : From ". $Variable1 ." To ". $Variable2 . "|";
					}
				}
				if($Logs != ""){
					$tran_logs = create_logs_per_transaction("modified other setup.", "System Setup", $Logs, "" ,"UPDATE", "1");
				}
			}
		break;

		case 'loadLeaseSys':
			$LeaseSys = mysql_fetch_array(mysql_query("SELECT reqandpermit, adjustoccupancy, automerchantcode, floorandunitmeasurement, vatsetup, isClassification, isDepartment, isCategory, isAssocDues, isMultiCompSig, isOccupancy, isJDAMapping FROM tblsys_setup", $connection));
			echo $LeaseSys['reqandpermit'] . "|" . $LeaseSys['adjustoccupancy'] . "|" . $LeaseSys['automerchantcode'] . "|" . $LeaseSys['floorandunitmeasurement'] . "|" . $LeaseSys['vatsetup'] . "|" . $LeaseSys['isClassification'] . "|" . $LeaseSys['isDepartment'] . "|" . $LeaseSys['isCategory'] . "|" . $LeaseSys['isAssocDues'] . "|" . $LeaseSys['isMultiCompSig'] . "|" . $LeaseSys['isOccupancy'] . "|" . $LeaseSys['isJDAMapping'];
		break;

		case 'fncSaveLPSetup':
			$CurrentSetup = mysql_fetch_array(mysql_query("SELECT id, LP_Mall, LP_TPS, LP_FontColor FROM tblsys_setup;", $connection));
			if($CurrentSetup['id'] == ""){
				$res = mysql_query("INSERT INTO tblsys_setup SET LP_Mall = '". $_POST['FirstBtn'] ."', LP_TPS = '". $_POST['SecondBtn'] ."', LP_FontColor = '". $_POST['FontColor'] ."';", $connection);				
				if($_POST['FirstBtn'] != ""){
					$Logs .= "First Button URL : ". $_POST['FirstBtn'] . "|";
				}
				if($_POST['SecondBtn'] != ""){
					$Logs .= "Second Button URL : ". $_POST['SecondBtn'] . "|";
				}
				if($_POST['FontColor'] != ""){
					$Logs .= "Font Color : ". $_POST['FontColor'] . "|";
				}
				if($Logs != ""){
					$tran_logs = create_logs_per_transaction("modified landing page setup.", "System Setup", $Logs, "" ,"ADD", "");
				}
			}else{
				$res = mysql_query("UPDATE tblsys_setup SET LP_Mall = '". $_POST['FirstBtn'] ."', LP_TPS = '". $_POST['SecondBtn'] ."', LP_FontColor = '". $_POST['FontColor'] ."';", $connection);
				if($CurrentSetup['LP_Mall'] != $_POST['FirstBtn']){
					if($CurrentSetup['LP_Mall'] == ""){
						$Logs .= "First Button URL : ". $_POST['FirstBtn'] . "|";
					}else{
						$Logs .= "First Button URL : From ". $CurrentSetup['LP_Mall'] ." To ". $_POST['FirstBtn'] . "|";
					}
				}
				if($CurrentSetup['LP_TPS'] != $_POST['SecondBtn']){
					if($CurrentSetup['LP_TPS'] == ""){
						$Logs .= "Second Button URL : ". $_POST['SecondBtn'] . "|";
					}else{
						$Logs .= "Second Button URL : From ". $CurrentSetup['LP_TPS'] ." To ". $_POST['SecondBtn'] . "|";
					}
				}
				if($CurrentSetup['LP_FontColor'] != $_POST['FontColor']){
					if($CurrentSetup['LP_FontColor'] == ""){
						$Logs .= "First Button URL : ". $_POST['FontColor'] . "|";
					}else{
						$Logs .= "First Button URL : From ". $CurrentSetup['LP_FontColor'] ." To ". $_POST['FontColor'] . "|";
					}
				}
				if($Logs != ""){
					$tran_logs = create_logs_per_transaction("modified landing page setup.", "System Setup", $Logs, "" ,"UPDATE", "1");
				}
			}
			if($res == true){
				echo 1;
			}else{
				echo 2;
			}
		break;

		case 'fncLoadLPSetup':
			$LPSys = mysql_fetch_array(mysql_query("SELECT LP_Mall, LP_TPS, LP_FontColor FROM tblsys_setup;", $connection));
			echo $LPSys['LP_Mall'] . "|" . $LPSys['LP_TPS'] . "|" . $LPSys['LP_FontColor'];
		break;
	}
?>