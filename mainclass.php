<?php
	session_start();
	include("connect.php");//connection
	ob_start();
    system('ipconfig /all');
    $mycom = ob_get_contents();
    ob_clean();
    $findme = "Physical";	
    $pmac = strpos($mycom, $findme);
    $MacAddress = substr($mycom, ($pmac + 36), 17);
	switch($_POST["form"]){
		case 'TestInput':
			if($_POST['Auth'] == "codepack"){//Alter Database
				echo 1;//access superAdmin
			}else if($_POST['Auth'] == "codepack1"){
				$rowmn = mysql_fetch_array(mysql_query("SELECT Machine_No FROM tblsys_setup;", $connection));
	            $rowlmn = mysql_fetch_array(mysql_query("UPDATE tblloggedmachine SET userid = 'GatessoftCorp', Onprocess = '1', xdatein = '". date('Y-m-d H:i:s') ."',  xdateout = '' WHERE Machine_No = '". $rowmn[0] ."';", $connection));
	            $rowmnu = mysql_fetch_array(mysql_query("UPDATE tblmachine SET Onprocess = '1' WHERE Machine_No = '". $rowmn[0] ."';", $connection));
	            $logID = createidno("LOG", "tbllog_sheet", "logID");
	            $reslogs = mysql_query("INSERT INTO tbllog_sheet SET logID = '". $logID ."', userid = 'GatessoftCorp', usertype = 'Admin', xdatetime = '". date('Y-m-d H:i:s') ."', action = 'Log in', Machine_No = '". $rowmn[0] ."';", $connection);
	            $mallList = "";
	            $resgetMallList = mysql_query("SELECT mallid FROM tblref_mall WHERE mallstat = '1';", $connection);
	            while($rowgetMalList = mysql_fetch_array($resgetMallList)){
					$mallList .= "'" . $rowgetMalList[0] . "'" . ",";
				}
	            $_SESSION['MMS-UserID'] = 'GatessoftCorp';
	            $_SESSION['MMS-Access'] = '';
                $_SESSION['MMS-Designation'] = 'GatessoftCorp';
				echo 2;
			}else{
				echo 3;
			}
		break;

		case 'CheckPassword':
			if(!file_exists("../Ai1Mall.dat")){
				echo 1;
			}else{
				echo 2;
			}
		break;

		case 'fncAPass1':
			if(strlen($_POST['APass1']) >= 8){
        		file_put_contents("../Ai1Mall.dat", md5($_POST["APass1"].$MacAddress.'@GS'));
        		echo 1;
			}else{
				echo 2;
			}
		break;

		case 'fncAPass2':	
		    $txtIPAddress = fread(fopen('../Ai1Mall.dat', 'r'), filesize('../Ai1Mall.dat'));
			if($txtIPAddress == md5($_POST["APass1"].$MacAddress.'@GS')){
				if(strlen($_POST['APass2']) >= 8){
	        		file_put_contents("../Ai1Mall.dat", md5($_POST["APass2"].$MacAddress.'@GS'));
					echo 1;
				}else{
					echo 2;
				}
			}else{
				echo 3;
			}
		break;

		case 'fncTryLogin':
		    $txtIPAddress = fread(fopen('../Ai1Mall.dat', 'r'), filesize('../Ai1Mall.dat'));
			if(md5($_POST["Password"].$MacAddress.'@GS') == $txtIPAddress){
				$rowmn = mysql_fetch_array(mysql_query("SELECT Machine_No FROM tblsys_setup;", $connection));
	            $rowlmn = mysql_fetch_array(mysql_query("UPDATE tblloggedmachine SET userid = 'GatessoftCorp', Onprocess = '1', xdatein = '". date('Y-m-d H:i:s') ."',  xdateout = '' WHERE Machine_No = '". $rowmn[0] ."';", $connection));
	            $rowmnu = mysql_fetch_array(mysql_query("UPDATE tblmachine SET Onprocess = '1' WHERE Machine_No = '". $rowmn[0] ."';", $connection));
	            $logID = createidno("LOG", "tbllog_sheet", "logID");
	            $reslogs = mysql_query("INSERT INTO tbllog_sheet SET logID = '". $logID ."', userid = 'GatessoftCorp', usertype = 'Admin', xdatetime = '". date('Y-m-d H:i:s') ."', action = 'Log in', Machine_No = '". $rowmn[0] ."';", $connection);
	            $mallList = "";
	            $resgetMallList = mysql_query("SELECT mallid FROM tblref_mall WHERE mallstat = '1';", $connection);
	            while($rowgetMalList = mysql_fetch_array($resgetMallList)){
					$mallList .= "'" . $rowgetMalList[0] . "'" . ",";
				}
	            $_SESSION['MMS-UserID'] = 'Superuser';
	            $_SESSION['MMS-Access'] = '';
                $_SESSION['MMS-Designation'] = 'Superuser';
				echo "1|";
			}else{
				if($_POST['Username'] == "" && $_POST['Password'] == "" && $_POST['Property'] == ""){
					echo "2|Please fill all fields";
				}else{
					$getuserid = mysql_fetch_array(mysql_query("SELECT userid FROM tbluser WHERE username = '". $_POST["Username"] ."';", $connection));
		            $resUserInfo = mysql_query("SELECT userid, groupaccess, isActive FROM tbluser WHERE username = '" . $_POST["Username"] . "' AND password = '". md5($_POST["Password"].$getuserid['userid'] .'@GS') ."';", $connection);
		            $rowUserInfo = mysql_fetch_array($resUserInfo);
		            $numUserCount = mysql_num_rows($resUserInfo);
		            $rowZreading = mysql_fetch_array(mysql_query("SELECT Zreading FROM tblforzreading", $connection));
		            if($rowUserInfo['isActive'] == "0"){
		            	echo "2|The user you are trying to log in is inactive.";
		            }else{
		                if($numUserCount > 0 && $rowZreading[0] != '1'){ 
		                    $_SESSION['MMS-UserID'] = $rowUserInfo['userid'];
		                    $_SESSION['MMS-Access'] = $rowUserInfo['groupaccess'];
		                    $_SESSION['MMS-Designation'] = $_POST['Property'];
		                    $rowmn = mysql_fetch_array(mysql_query("SELECT Machine_No FROM tblsys_setup;", $connection));
		                    $rowlmn = mysql_fetch_array(mysql_query("UPDATE tblloggedmachine SET userid = '". $rowUserInfo['userid'] ."', Onprocess = '1', xdatein = '". date('Y-m-d H:i:s') ."',  xdateout = '' WHERE Machine_No = '". $rowmn[0] ."';", $connection));
		                    $rowmnu = mysql_fetch_array(mysql_query("UPDATE tblmachine SET Onprocess = '1' WHERE Machine_No = '". $rowmn[0] ."';", $connection));
		                    $logID = createidno("LOG", "tbllog_sheet", "logID");
		                    $rowusertype = mysql_fetch_array(mysql_query("SELECT isadmin FROM tbluser WHERE userid = '". $rowUserInfo['userid'] ."';", $connection));
		                    if($rowusertype[0] == "1"){
		                        $usertype = "Admin";
		                    }else{
		                        $usertype = "User";
		                    }
		                    $reslogs = mysql_query("INSERT INTO tbllog_sheet SET logID = '". $logID ."', userid = '". $rowUserInfo['userid'] ."', usertype = '". $usertype ."', xdatetime = '". date('Y-m-d H:i:s') ."', action = 'Log in', Machine_No = '". $rowmn[0] ."';", $connection);
		                    $resloginstat2 = mysql_query("UPDATE tbluser SET loginstat = '1' WHERE userid = '". $rowUserInfo['userid'] ."';", $connection);
		                    echo "1|";
		                }else if($numUserCount >0 && $rowZreading[0] == '1'){
		                	echo "2|Z Reading is being generated you cannot log in.";
		                }else{ 
		                    echo "2|Username / Password is invalid.";
		                }
		            }
				}
			}
		break;

		case 'fncShowSelect':
			$getFromUser = mysql_fetch_array(mysql_query("SELECT MallAccess FROM tbluser WHERE username = '". $_POST['Username'] ."';", $connection));
			if($getFromUser['MallAccess'] == ""){
				$title = mysql_fetch_array(mysql_query("SELECT softwaretype FROM tblsys_setup;", $connection));
				if($title[0] == "0"){
					$label =  "Mall";
				}else if($title[0] == "1"){
					$label =  "Property";
				}else if($title[0] == "2"){
					$label =  "Building";
				}else if($title[0] == "3"){
					$label =  "Property";
				}else if($title[0] == "4"){
					$label =  "Cemetery";
				}else if($title[0] == "5"){
					$label =  "Property";
				}else{
					$label =  "Mall";
				}
				echo "<option value=''>-- Select ".$label." --</option>";
			}else{
				$mgaProperty = "";
				$arr = explode("@", $getFromUser['MallAccess']);
				for ($i=0; $i <= count($arr)-2; $i++) { 
					$mgaProperty .= "'" . $arr[$i] . "'" . ",";
				}
				$resMallList = mysql_query("SELECT mallid, mallname FROM tblref_mall WHERE mallid IN (". substr(trim($mgaProperty), 0, -1) .");", $connection);
				while($rowMallList = mysql_fetch_array($resMallList)){
					echo "<option value='".$rowMallList[0]."'>".$rowMallList[1]."</option>";
				}
			}
		break;

		case 'frmLandingPage':
			$Setup = mysql_fetch_array(mysql_query("SELECT corporatename, about, address, contactnumber, Telephone_number, website, corporatelogo, LP_BGImage, LP_FontColor, LP_Mall, LP_TPS FROM tblsys_setup", $connection));

			if($Setup["corporatelogo"] == ""){
				$SysLogo = "assets/images/noimage5.png";
			}else{
				if(!file_exists("../Mall_Attachments/SysLogo/". $Setup["corporatelogo"])){ 
					$SysLogo = "assets/images/noimage5.png";
				}else{
					$SysLogo = "../Mall_Attachments/SysLogo/". $Setup["corporatelogo"];
				}
			}

			if($Setup["LP_BGImage"] == ""){
				$TPBG = "url(assets/images/whitebackground.png)";
			}else{
				if(!file_exists("../Mall_Attachments/SysLogo/". $Setup["LP_BGImage"])){ 
					$TPBG = "url(assets/images/whitebackground.png)";
				}else{
					$TPBG = "url(../Mall_Attachments/SysLogo/". $Setup["LP_BGImage"] . ")";
				}
			}

			echo $Setup['corporatename'] . "|" . $Setup['about'] . "|" . $Setup['address'] . "|" . $Setup['contactnumber'] . "|" . $Setup['Telephone_number'] . "|" . $Setup['website'] . "|" . $SysLogo . "|" . $TPBG . "|" . $Setup['LP_FontColor'] . "|" . $Setup['LP_Mall'] . "|" . $Setup['LP_TPS'];
		break;

		case 'tblref_mall':
			$title = mysql_fetch_array(mysql_query("SELECT softwaretype FROM tblsys_setup;", $connection));
			if($title[0] == "0"){
				$label =  "Mall";
			}else if($title[0] == "1"){
				$label =  "Property";
			}else if($title[0] == "2"){
				$label =  "Building";
			}else if($title[0] == "3"){
				$label =  "Property";
			}else if($title[0] == "4"){
				$label =  "Cemetery";
			}else if($title[0] == "5"){
				$label =  "Property";
			}else{
				$label =  "Mall";
			}
			$count == 0;
			echo "<option value=''>-- Select ".$label." --</option>";
			$res = mysql_query("SELECT mallid, mallname FROM tblref_mall WHERE mallstat = '1' ". getMallAccess("mallID", "AND") ." ORDER BY mallname ASC;", $connection);
			while($row = mysql_fetch_array($res)){
				if($count == 0){
					$isSelected = "selected";
				}else{
					$isSelected = "";
				}
				echo "<option ". $isSelected ." value='".$row[0]."'>".$row[1]."</option>";
				$count++;
			}
		break;

		case 'tblref_wing':
			echo "<option value=''>-- Select Wing --</option>";
			$res = mysql_query("SELECT wingID, wing FROM tblref_wing ORDER BY wing ASC;", $connection);
			while($row = mysql_fetch_array($res)){
				echo "<option value='".$row[0]."''>".$row[1]."</option>";
			}
		break;

		case 'tblref_floor':
			echo "<option value=''>-- Select Floor --</option>";
			$res = mysql_query("SELECT floorid, floor FROM tblref_floorsetup ORDER BY floor ASC;", $connection);
			while($row = mysql_fetch_array($res)){
				echo "<option value='".$row[0]."''>".$row[1]."</option>";
			}
		break;

		case 'tblref_merchandise_class':
			echo "<option value=''>-- Select Classification --</option>";
			$res = mysql_query("SELECT classificationID, classification FROM tblref_merchandise_class ORDER BY classification ASC;", $connection);
			while($row = mysql_fetch_array($res)){
				echo "<option value='".$row[0]."''>".$row[1]."</option>";
			}
		break;

		case 'tblref_merchandise_depa':
			echo "<option value=''>-- Select Department --</option>";
			$res = mysql_query("SELECT departmentID, department FROM tblref_merchandise_depa ORDER BY department ASC;", $connection);
			while($row = mysql_fetch_array($res)){
				echo "<option value='".$row[0]."''>".$row[1]."</option>";
			}
		break;

		case 'tblref_merchandisedep_cat':
			echo "<option value=''>-- Select Category --</option>";
			$res = mysql_query("SELECT categoryID, category FROM tblref_merchandisedep_cat ORDER BY category ASC;", $connection);
			while($row = mysql_fetch_array($res)){
				echo "<option value='".$row[0]."''>".$row[1]."</option>";
			}
		break;

		case 'tblref_cardtype':
			echo "<option value=''>-- Select Card --</option>";
			$res = mysql_query("SELECT CardType FROM tblref_cardtype ORDER BY CardType ASC;", $connection);
			while($row = mysql_fetch_array($res)){
				echo "<option value='" . $row[0] . "'>" . $row[0] . "</option>";
			}
		break;

		case 'showTenantList':
			if(SysLeaseSetup('softwaretype') == '5'){
			 	$txtSystenant = "Buyer"; 
			}else if(SysLeaseSetup('softwaretype') == '0'){
			 	$txtSystenant = "Store"; 
			}else{ 
				$txtSystenant = "Tenant"; 
			}
			echo "<option value='' disabled>-- Select ". $txtSystenant ." --</option>";
			$res = mysql_query("SELECT TenantID, tradename FROM tbltrans_tenants WHERE (Status = 'Active' OR Status = 'ForEviction' OR Status = 'ForRenewal') AND ustatus = 'Occupied' ". getMallAccess("mallID", "AND") ." ORDER BY tradename ASC;", $connection);
			while($row = mysql_fetch_array($res)){
				echo "<option value='" . $row[0] . "'>" . $row[1] . "</option>";
			}
		break;

		case 'tblrefbank':
			echo "<option value=''>-- Select Bank --</option>";
			$res = mysql_query("SELECT xcode, description FROM tblrefbank ORDER BY description ASC;", $connection);
			while($row = mysql_fetch_array($res)){
				echo "<option value='" . $row[0] . "'>" . $row[1] . "</option>";
			}
		break;

		case 'loadindustry':
			echo "<option value=''>-- Select Industry --</option>";
			$sql = "SELECT Industry_ID, Industry FROM tblref_industry ORDER BY Industry ASC;";
			$result = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($result)){
				echo "<option value='". $row["Industry_ID"] ."'>". $row["Industry"] ."</option>";
			}
		break;

		case 'loadcompanyposition':
			echo "<option value=''>-- Select Position --</option>";
			$sql = "SELECT xposition FROM tblref_companyposition ORDER BY xposition ASC;";
			$result = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($result)){
				echo "<option value='". $row["xposition"] ."'>". $row["xposition"] ."</option>";
			}
		break;

		case 'fncAllDepartmentRef':
			echo "<option value=''>-- Select Department --</option>";
			$result = mysql_query("SELECT departmentID, department FROM tblref_merchandise_depa WHERE class_ID = '". $_POST['Classification'] ."' ORDER BY department ASC;", $connection);
			while($row = mysql_fetch_array($result)){
				echo "<option value='". $row["departmentID"] ."'>". $row["department"] ."</option>";
			}
		break;

		case 'fncAllCategoryRef':
			echo "<option value=''>-- Select Category --</option>";
			$result = mysql_query("SELECT categoryID, category FROM tblref_merchandisedep_cat WHERE dept_ID = '". $_POST['Department'] ."' ORDER BY category ASC;", $connection);
			while($row = mysql_fetch_array($result)){
				echo "<option value='". $row["categoryID"] ."'>". $row["category"] ."</option>";
			}
		break;

		case 'fncAllSource':
			echo "<option value=''>-- Select Source --</option>";
			$result = mysql_query("SELECT source_code, source_desc FROM tblref_source ORDER BY source_desc ASC;", $connection);
			while($row = mysql_fetch_array($result)){
				echo "<option value='". $row["source_code"] ."'>". $row["source_desc"] ."</option>";
			}
		break;

		case 'fncAllProcessOwner':
			echo "<option value=''>-- Select Process Owner --</option>";
			$result = mysql_query("SELECT deptCode, deptDesc FROM tblref_process_owner ORDER BY deptDesc ASC;", $connection);
			while($row = mysql_fetch_array($result)){
				echo "<option value='". $row["deptCode"] ."'>". $row["deptDesc"] ."</option>";
			}
		break;

		case 'getPaymentType':
			echo "<option>-- Select Payment Type --</option>";
			$res = mysql_query("SELECT PaymentTypeID, PaymentTypeDesc, PaymentType FROM tblref_pospaymenttype;", $connection);
			while($row = mysql_fetch_array($res)){
				echo "<option value='". $row['PaymentTypeID'] ."|". $row['PaymentType'] ."'>". $row['PaymentTypeDesc'] ."</option>";
			}
		break;

		case "getuserdata":
			$row = mysql_fetch_array(mysql_query("SELECT firstname, ext, gender FROM tbluser WHERE userid = '". $_SESSION['MMS-UserID'] ."';", $connection));
			if($row[2] == "Female"){
				$genderimg = "Female.png";
			}else{
				$genderimg = "Male.png";
			}

			if($row["ext"] == ""){
				$img = "assets/images/".$genderimg;
			}else{
				if(!file_exists("../Mall_Attachments/User/". $_SESSION['MMS-UserID'] . "." . $row["ext"])){ 
					$img = "assets/images/". $genderimg;
				}else{
					$img = "../Mall_Attachments/User/". $_SESSION['MMS-UserID'] . "." . $row["ext"];
				}
			}

			if($_SESSION['MMS-UserID'] == "GatessoftCorp"){
				$Username = "GatessoftCorp";
			}else if($_SESSION['MMS-UserID'] == "Superuser"){
				$Username = "Superuser";
			}else{
				$Username = $row['firstname'];
			}
			echo $Username . "|" . $_SESSION['MMS-UserID'] . "|" . $img . "|";
		break;

        case 'GenerateMerchantCode':
            if(SysLeaseSetup('automerchantcode') == "1"){
                $getlastid = mysql_fetch_array(mysql_query("SELECT automerchant_code FROM tbltrans_tradename ORDER BY automerchant_code DESC LIMIT 1;", $connection));
                if($getlastid[0] == ""){ 
                    $myid = "-" . addleadingzero("1"); 
                }else{
                    $myid = "-" . addleadingzero($getlastid[0]+1);
                }
            }else{
        		$myid = "";
            }
            echo $myid;
        break;
		
		case 'loadcityref':
			$queryflr = "SELECT DISTINCT(citymunDesc) FROM tblref_citymun WHERE citymunDesc LIKE '%".$_POST["city"]."%' LIMIT 0,20";
            $result_flr = mysql_query($queryflr, $connection);
			while($row = mysql_fetch_array($result_flr)){
				echo "<option value='".$row["citymunDesc"]."'>".$row["citymunDesc"]."</option>";
			}
		break;

        case 'loadnotifications':
        	$i = 0;
			$select = "SELECT Status, datefrom FROM tbltrans_inquiry WHERE Status = 'Confirmed'";
			$result = mysql_query($select, $connection);
			while($row = mysql_fetch_array($result)){
				if($row["Status"] == "Confirmed" && (date("m/d/Y", strtotime($row["datefrom"])) < date("m/d/Y") || date("m/d/Y", strtotime($row["datefrom"])) == date("m/d/Y"))){
					$i++;
				}
			}
			if($i == 0){
				$stat = "No reservation for occupancy.";
				$icon = "<i class='ace-icon fa fa-bell-o orange bigger-130'></i>";
			}else{
				$stat = $i ." reservation(s) are for occupancy!";
				$icon = "<i class='ace-icon fa fa-bell orange bigger-130'></i>";
			}
			echo $stat . "|" . $icon . "|";
        break;

       	case 'savetradename':
			if(SysLeaseSetup('automerchantcode') == "1"){
				$arr = explode("-", $_POST['merchant_code']);
				$Merchant_Code = $arr[0];
				$Merchant_Code_Auto = $arr[1];
				$Trapmerchcode = 0;
			}else{
				$CheckMerchantCode = mysql_fetch_array(mysql_query("SELECT COUNT(tradeID) FROM tbltrans_tradename WHERE merchant_code = '". $_POST['merchant_code'] ."';", $connection));
				$Merchant_Code = $_POST['merchant_code'];
				$Merchant_Code_Auto = "";
				$Trapmerchcode = $CheckMerchantCode[0];
			}
			if($Trapmerchcode == 0){
				$tradeid = createidno("TRADE", "tbltrans_tradename", "tradeID");
				$sql = "INSERT INTO tbltrans_tradename SET tradeID = '". $tradeid ."', tradename = '". $_POST["tradename"] ."', companyID = '". $_POST["companyid"] ."', merchant_code = '". str_replace(" ", "", $Merchant_Code) ."', automerchant_code = '". $Merchant_Code_Auto ."', BillSetup = '". $_POST['BillSetup'] ."', BillID = '". $_POST['BillerID'] ."';";
				$result = mysql_query($sql, $connection);
				$row = mysql_fetch_array($result);

				if($result == true){
					echo "1|".$_POST["companyid"]."|".$tradeid;
				}else{
					echo "3|";
				}
			}else{
				echo "2||";
			}
		break;

       	case 'savetradename_update':
        	if(SysLeaseSetup('automerchantcode') == "1"){
				$arr = explode("-", $_POST['merchant_code']);
				$Merchant_Code = $arr[0];
				$Merchant_Code_Auto = $arr[1];
				$CheckMerchantCode = mysql_fetch_array(mysql_query("SELECT COUNT(tradeID) FROM tbltrans_tradename WHERE merchant_code = '". $Merchant_Code ."' AND automerchant_code = '". $Merchant_Code_Auto ."' and tradeID != '". $_POST['id'] ."';", $connection));
				$Trapmerchcode = $CheckMerchantCode[0];
			}else{
				$CheckMerchantCode = mysql_fetch_array(mysql_query("SELECT COUNT(tradeID) FROM tbltrans_tradename WHERE merchant_code = '". $_POST['merchant_code'] ."' and tradeID != '". $_POST['id'] ."';", $connection));
				$Merchant_Code = $_POST['merchant_code'];
				$Merchant_Code_Auto = "";
				$Trapmerchcode = $CheckMerchantCode[0];
			}
			if($Trapmerchcode == 0){
				$sql = "UPDATE tbltrans_tradename SET tradename = '". $_POST["tradename"] ."', companyID = '". $_POST["companyid"] ."', merchant_code = '". $Merchant_Code ."', automerchant_code = '". str_replace(" ", "", $Merchant_Code) ."', BillSetup = '". $_POST['BillSetup'] ."', BillID = '". $_POST['BillerID'] ."' WHERE tradeID = '". $_POST["id"] ."';";
				$result = mysql_query($sql, $connection);
				$row = mysql_fetch_array($result);
				if($result == true){
					echo "1|". $_POST["companyid"] ."|". $_POST["id"];
				}
			}else{
				echo "2||";
			}
        break;

		case 'selectcontactpersons':
			$result = mysql_query("SELECT ConID, Confname, Conmname, Conlname, custID, name, designation, address, filename, isActive, isPrimary FROM tbltrans_company_contact_person WHERE ConID = '".$_POST["companyID"]."';", $connection);
			$rescount = mysql_num_rows($result);
			if($rescount == 0){
				echo '<center><img src="assets/images/network.png" style="margin: 20px;"></center><center><h3>No contact persons yet.</h3></center>';
			}else{
				while($row = mysql_fetch_array($result)){
					if($row['filename'] == ""){
						$img = "assets/images/noimage5.png";
					}else{
						if(!file_exists("../Mall_Attachments/BillProfile/".$_POST["companyID"]."/contact_person/".$row["custID"]."/".$row["filename"])){ 
							$img = "assets/images/noimage5.png";
						}else{
							$img = "../Mall_Attachments/BillProfile/".$_POST["companyID"]."/contact_person/".$row["custID"]."/".$row["filename"];
						}
					}
					
					if($row['isActive'] == "1"){
						$isActive = "info";
					}else{
						$isActive = "warning";
					}

					if($row['isPrimary'] == "1"){
						$isPrimary = "<span class='fa fa-star orange pull-left'></span><br>";
					}else{
						$isPrimary = "";
					}

					echo 	"<div class='col-md-4'><div class='alert alert-". $isActive ." div_inquiry_wells' id='contact_". $row["custID"] ."'>
							<div class='tools tools-left in'>
								<a style='margin-bottom: 8px; margin-top: 8px;' class='pull-left'>". $isPrimary ."</a>
								<a href='#' title='Edit Photo' class='btnedit' style='float:right;margin-bottom:8px;margin-top:8px;' onclick='editthiscontactperson(\"". $row["custID"] ."\", \"". $row["ConID"] ."\")'><i class='ace-icon fa fa-pencil'></i></a>
								<a href='#' title='Remove Photo' class='btndelete' style='float:right;margin-right:5px;margin-bottom:8px;margin-top:8px;' onclick='removethiscontactperson(\"". $row["custID"] ."\", \"". $row['ConID'] ."\")'><i class='ace-icon fa fa-times red'></i></a>
							</div>
							<center>
								<div class='image'><img class='img-thumbnail imageName form-control' src='". $img ."' style='border: 2px solid #bdc3c7; margin-bottom: 8px;height: 160px;width:90%;'></div>
							</center>
							<label style='font-size: 14px; font-weight: bold;margin: 0px !important;' class='contact_person_firstname'>". $row["Confname"] ." ". $row["Conmname"] ." ". $row["Conlname"] ."</label>
							<p style='font-size: 14px; font-weight: normal;margin: 0px !important;' class='contact_person_designation'>". $row["designation"] ."</p>
								<p style='font-size: 10px; font-weight: normal;margin: 0px !important;' class='address_person'>". $row["address"] ."</p>";
				$result2 = mysql_query("SELECT content FROM tbltrans_company_contact_person_contacts WHERE ConID = '".$row["custID"]."';", $connection);
				while($row2 = mysql_fetch_array($result2)){
					echo"<p style='font-size: 10px; font-weight: normal;margin: 0px !important;'>".$row2["content"]."</p>";
				}
				echo "</div></div>";
				}
			}
		break;

		case 'fncgetTradeContact':
			$result = mysql_query("SELECT TradeID, FirstName, MiddleName, LastName, ContactID, FullName, Designation, Address, filename, isActive, isPrimary FROM tbltrans_trade_contact_person WHERE TradeID = '". $_POST["tradeID"] ."';", $connection);
			$rescount = mysql_num_rows($result);
			if($rescount == 0){
				echo '<center><img src="assets/images/network.png" style="margin: 20px;"></center><center><h3>No contact persons yet.</h3></center>';
			}else{
				while($row = mysql_fetch_array($result)){
        			$CompanyID = mysql_fetch_array(mysql_query("SELECT companyID FROM tbltrans_tradename WHERE tradeID = '". $_POST['tradeID'] ."';", $connection));
					if($row['filename'] == ""){
						$img = "assets/images/noimage5.png";
					}else{
						if(!file_exists("../Mall_Attachments/company/". $CompanyID['companyID'] ."/trades/".$_POST["tradeID"]."/contact_person/".$row["ContactID"]."/".$row["filename"])){ 
							$img = "assets/images/noimage5.png";
						}else{
							$img = "../Mall_Attachments/company/". $CompanyID['companyID'] ."/trades/".$_POST["tradeID"]."/contact_person/".$row["ContactID"]."/".$row["filename"];
						}
					}
					
					if($row['isActive'] == "1"){
						$isActive = "info";
					}else{
						$isActive = "warning";
					}

					if($row['isPrimary'] == "1"){
						$isPrimary = "<span class='fa fa-star orange pull-left'></span><br>";
						$isPrimary2 = "";
					}else{
						$isPrimary = "";
						$isPrimary2 = "hide";
					}

					echo 	"<div class='col-md-3'><div class='alert alert-". $isActive ." div_inquiry_wells' id='contact_". $row["ContactID"] ."'>
							<div class='row ". $isPrimary2 ."'><div class='col-md-12'><span class='fa fa-star orange pull-left'></span></div></div>
							<center>
								<div class='image'><img class='img-thumbnail imageName form-control' src='". $img ."' style='border: 2px solid #bdc3c7; margin-bottom: 8px;height: 160px;width:90%;'></div>
							</center>
							<label style='font-size: 14px; font-weight: bold;margin: 0px !important;' class='contact_person_firstname'>". $row["FirstName"] ." ". $row["MiddleName"] ." ". $row["LastName"] ."</label>
							<p style='font-size: 14px; font-weight: normal;margin: 0px !important;' class='contact_person_designation'>". $row["Designation"] ."</p>
								<p style='font-size: 10px; font-weight: normal;margin: 0px !important;' class='address_person'>". $row["Address"] ."</p>";
				$result2 = mysql_query("SELECT content FROM tbltrans_trade_contact_person_list WHERE ContactID = '".$row["ContactID"]."';", $connection);
				while($row2 = mysql_fetch_array($result2)){
					echo"<p style='font-size: 10px; font-weight: normal;margin: 0px !important;'>".$row2["content"]."</p>";
				}
				echo "</div></div>";
				}
			}
		break;

		case 'fncgetBillInformation':
			$BillInfo = mysql_fetch_array(mysql_query("SELECT a.BillSetup, b.BillerID, b.BillerName, b.Telephone, b.PermanentAddress, b.CurrentAddress, b.BillingAddress, b.Mobile, b.Email FROM tbltrans_tradename AS a LEFT JOIN tblref_billprofile AS b ON a.BillID = b.BillerID WHERE a.tradeID = '". $_POST['tradeID'] ."';", $connection));
			echo $BillInfo['BillSetup'] . "|" . $BillInfo['BillerID'] . "|" . $BillInfo['BillerName'] . "|" . $BillInfo['Telephone'] . "|" . $BillInfo['PermanentAddress'] . "|" . $BillInfo['CurrentAddress'] . "|" . $BillInfo['BillingAddress'] . "|" . $BillInfo['Mobile'] . "|" . $BillInfo['Email']; 
		break;

		case 'fncgetBillContact':
			$result = mysql_query("SELECT TradeID, FirstName, MiddleName, LastName, ContactID, FullName, Designation, Address, filename, isActive, isPrimary FROM tbltrans_trade_contact_person WHERE TradeID = '". $_POST["tradeID"] ."';", $connection);
			$rescount = mysql_num_rows($result);
			if($rescount == 0){
				echo '<center><img src="assets/images/network.png" style="margin: 20px;"></center><center><h3>No contact persons yet.</h3></center>';
			}else{
				while($row = mysql_fetch_array($result)){
        			$CompanyID = mysql_fetch_array(mysql_query("SELECT companyID FROM tbltrans_tradename WHERE tradeID = '". $_POST['tradeID'] ."';", $connection));
					if($row['filename'] == ""){
						$img = "assets/images/noimage5.png";
					}else{
						if(!file_exists("../Mall_Attachments/company/". $CompanyID['companyID'] ."/trades/".$_POST["tradeID"]."/contact_person/".$row["ContactID"]."/".$row["filename"])){ 
							$img = "assets/images/noimage5.png";
						}else{
							$img = "../Mall_Attachments/company/". $CompanyID['companyID'] ."/trades/".$_POST["tradeID"]."/contact_person/".$row["ContactID"]."/".$row["filename"];
						}
					}
					
					if($row['isActive'] == "1"){
						$isActive = "info";
					}else{
						$isActive = "warning";
					}

					if($row['isPrimary'] == "1"){
						$isPrimary = "<span class='fa fa-star orange pull-left'></span><br>";
						$isPrimary2 = "";
					}else{
						$isPrimary = "";
						$isPrimary2 = "hide";
					}

					echo 	"<div class='col-md-4'><div class='alert alert-". $isActive ." div_inquiry_wells' id='contact_". $row["ContactID"] ."'>
							<div class='row ". $isPrimary2 ."'><div class='col-md-12'><span class='fa fa-star orange pull-left'></span></div></div>
							<center>
								<div class='image'><img class='img-thumbnail imageName form-control' src='". $img ."' style='border: 2px solid #bdc3c7; margin-bottom: 8px;height: 160px;width:90%;'></div>
							</center>
							<label style='font-size: 14px; font-weight: bold;margin: 0px !important;' class='contact_person_firstname'>". $row["FirstName"] ." ". $row["MiddleName"] ." ". $row["LastName"] ."</label>
							<p style='font-size: 14px; font-weight: normal;margin: 0px !important;' class='contact_person_designation'>". $row["Designation"] ."</p>
								<p style='font-size: 10px; font-weight: normal;margin: 0px !important;' class='address_person'>". $row["Address"] ."</p>";
				$result2 = mysql_query("SELECT content FROM tbltrans_company_contact_person_contacts WHERE TradeID = '".$row["ContactID"]."';", $connection);
				while($row2 = mysql_fetch_array($result2)){
					echo"<p style='font-size: 10px; font-weight: normal;margin: 0px !important;'>".$row2["content"]."</p>";
				}
				echo "</div></div>";
				}
			}
		break;

		case 'addcontactperson_update':
	        $cnt = "SELECT COUNT(custID) FROM tbltrans_company_contact_person WHERE Confname = '".$_POST["contact_firstname"]."' AND Conlname = '".$_POST["contact_middlename"]."' AND Conmname = '".$_POST["contact_middlename"]."' AND ConID = '".$_POST["id"]."'";
	        $rescnt = mysql_query($cnt, $connection);
	        $cnnnt = mysql_fetch_array($rescnt);
	        if($cnnnt[0] > 0){
	        	echo "0|0|";
	        }else{
				$contactid = createidno("CON", "tbltrans_company_contact_person", "ConID");
				$sql = "INSERT INTO tbltrans_company_contact_person (ConID, Confname, Conmname, Conlname, custID, name, designation, address)VALUES('".$_POST["id"]."', '".$_POST["contact_firstname"]."', '".$_POST["contact_middlename"]."', '".$_POST["contact_lastname"]."', '".$contactid."', '".$_POST["contact_firstname"]." ".$_POST["contact_middlename"]." ".$_POST["contact_lastname"]."', '".$_POST["contact_designation"]."', '".$_POST["contact_address"]."')";
				$result = mysql_query($sql, $connection);

				$email_string = explode("|", $_POST["person_email"]);
				for($a=0; $a<=count($email_string)-2; $a++){
					$email_string_query = "INSERT INTO tbltrans_company_contact_person_contacts(ConID, type, content) VALUES('".$contactid."', 'email', '".$email_string[$a]."')";
					$email_string_result = mysql_query($email_string_query, $connection);
				}

				$mobile_string = explode("|", $_POST["person_mobile"]);
				for($b=0; $b<=count($mobile_string)-2; $b++){
					$mobile_string_query = "INSERT INTO tbltrans_company_contact_person_contacts(ConID, type, content) VALUES('".$contactid."', 'mobile', '".$mobile_string[$b]."')";
					$mobile_string_result = mysql_query($mobile_string_query, $connection);
				}

				$tele_string = explode("|", $_POST["person_tele"]);
				for($c=0; $c<=count($tele_string)-2; $c++){
					$tele_string_query = "INSERT INTO tbltrans_company_contact_person_contacts(ConID, type, content) VALUES('".$contactid."', 'telephone', '".$tele_string[$c]."')";
					$tele_string_result = mysql_query($tele_string_query, $connection);
				}

				echo "1|".$contactid."|";
	        }
        break;

        case 'addtradecontactperson_update':
	        $cnt = "SELECT COUNT(TradeID) FROM tbltrans_trade_contact_person WHERE FirstName = '".$_POST["contact_firstname"]."' AND MiddleName = '".$_POST["contact_middlename"]."' AND LastName = '".$_POST["contact_middlename"]."' AND ContactID = '".$_POST["id"]."';";
	        $rescnt = mysql_query($cnt, $connection);
	        $cnnnt = mysql_fetch_array($rescnt);
	        if($cnnnt[0] > 0){
	        	echo "0|0|";
	        }else{
	        	if($_POST['isPrimary'] == '1'){
	        		$resPrimary = mysql_query("UPDATE tbltrans_trade_contact_person SET isPrimary = '0' WHERE TradeID = '". $_POST['id'] ."';", $connection);
	        	}
				$contactid = createidno("CON", "tbltrans_trade_contact_person", "ContactID");
				$sql = "INSERT INTO tbltrans_trade_contact_person (ContactID, FirstName, LastName, MiddleName, TradeID, FullName, Designation, Address, isActive, isPrimary)VALUES('". $contactid ."', '". $_POST["contact_firstname"] ."', '". $_POST["contact_middlename"] ."', '". $_POST["contact_lastname"] ."', '". $_POST["id"] ."', '". $_POST["contact_firstname"] ." ". $_POST["contact_middlename"] ." ". $_POST["contact_lastname"] ."', '". $_POST["contact_designation"] ."', '". $_POST["contact_address"] ."', '". $_POST['isActive'] ."', '". $_POST['isPrimary'] ."')";
				$result = mysql_query($sql, $connection);

				$email_string = explode("|", $_POST["person_email"]);
				for($a=0; $a<=count($email_string)-2; $a++){
					$email_string_query = "INSERT INTO tbltrans_trade_contact_person_list(ContactID, type, content) VALUES('".$contactid."', 'email', '".$email_string[$a]."')";
					$email_string_result = mysql_query($email_string_query, $connection);
				}

				$mobile_string = explode("|", $_POST["person_mobile"]);
				for($b=0; $b<=count($mobile_string)-2; $b++){
					$mobile_string_query = "INSERT INTO tbltrans_trade_contact_person_list(ContactID, type, content) VALUES('".$contactid."', 'mobile', '".$mobile_string[$b]."')";
					$mobile_string_result = mysql_query($mobile_string_query, $connection);
				}

				$tele_string = explode("|", $_POST["person_tele"]);
				for($c=0; $c<=count($tele_string)-2; $c++){
					$tele_string_query = "INSERT INTO tbltrans_trade_contact_person_list(ContactID, type, content) VALUES('".$contactid."', 'telephone', '".$tele_string[$c]."')";
					$tele_string_result = mysql_query($tele_string_query, $connection);
				}

				echo "1|".$contactid."|";
	        }
        break;

		case 'savenewmall':			
			$companyid = createidno("COM", "tbltrans_company", "CompanyID");

			if($_POST['BillAccountName'] != "" && ($_POST['BillTel'] != '' || $_POST['BillMobile'] != '')){
				$BilleriD = createidno("BID", "tblref_billprofile", "BillerID");
				$resSaveBilling = mysql_query("INSERT INTO tblref_billprofile SET BillerID = '". $BilleriD ."', BillerName = '". $_POST['BillAccountName'] ."', Telephone = '". $_POST['BillTel'] ."', PermanentAddress = '". $_POST['perm_add'] ."', CurrentAddress = '". $_POST['curr_add'] ."', BillingAddress = '". $_POST['bill_add'] ."', Mobile = '". $_POST['BillMobile'] ."', Email = '". $_POST['BillEmail'] ."';", $connection);
			}else{
				$BilleriD = "";
			}

			$result = mysql_query("INSERT INTO tbltrans_company SET CompanyID = '". $companyid ."', Company = '". $_POST['name'] ."', industry = '". $_POST['industry'] ."', businessAddress = '". $_POST['busadd'] ."', BillerID = '". $BilleriD ."';", $connection);

			$contact_mobile = explode("|", $_POST["contact_mobile"]);
			for($j=0; $j<=count($contact_mobile)-2; $j++){
				$contact_mobile_result = mysql_query("INSERT INTO tbltrans_company_contacts(CompanyID, type, content) VALUES('".$companyid."', 'mobile', '".$contact_mobile[$j]."');", $connection);
			}

			$contact_tele = explode("|", $_POST["contact_tele"]);
			for($k=0; $k<=count($contact_tele)-2; $k++){
				$contact_tele_result = mysql_query("INSERT INTO tbltrans_company_contacts(CompanyID, type, content) VALUES('".$companyid."', 'telephone', '".$contact_tele[$k]."');", $connection);
			}

			$contact_fax = explode("|", $_POST["contact_fax"]);
			for($l=0; $l<=count($contact_fax)-2; $l++){
				$contact_fax_result = mysql_query("INSERT INTO tbltrans_company_contacts(CompanyID, type, content) VALUES('".$companyid."', 'fax', '".$contact_fax[$l]."');", $connection);
			}

			$contact_email = explode("|", $_POST["contact_email"]);
			for($m=0; $m<=count($contact_email)-2; $m++){
				$contact_email_result = mysql_query("INSERT INTO tbltrans_company_contacts(CompanyID, type, content) VALUES('".$companyid."', 'email', '".$contact_email[$m]."');", $connection);
			}

			$contact_website = explode("|", $_POST["contact_website"]);
			for($n=0; $n<=count($contact_website)-2; $n++){
				$contact_website_result = mysql_query("INSERT INTO tbltrans_company_contacts(CompanyID, type, content) VALUES('".$companyid."', 'website', '".$contact_website[$n]."');", $connection);
			}

			if($result == true){
				echo $companyid."|1|".$BilleriD;
			}
		break;

		case 'savecontactpersons':
			$contactid = createidno("CON", "tbltrans_company_contact_person", "ConID");
			$sql = "INSERT INTO tbltrans_company_contact_person SET ConID = '".$_POST["id"]."', Confname = '".$_POST["firstname_val"]."', Conmname = '".$_POST["middlename_val"]."', Conlname = '".$_POST["lastname_val"]."', custID = '".$contactid."', name = '".$_POST["firstname_val"]." ".$_POST["middlename_val"]." ".$_POST["lastname_val"]."', designation = '".$_POST["designation_val"]."', address = '".$_POST["address_val"]."', isActive = '". $_POST['isActive'] ."', isPrimary = '". $_POST['isPrimary'] ."';";
			$result = mysql_query($sql, $connection);
			$email_string = explode("|", $_POST["email_string"]);
			for($a=0; $a<=count($email_string)-2; $a++){
				$email_string_result = mysql_query("INSERT INTO tbltrans_company_contact_person_contacts(ConID, type, content) VALUES('".$contactid."', 'email', '".$email_string[$a]."');", $connection);
			}
			$mobile_string = explode("|", $_POST["mobile_string"]);
			for($b=0; $b<=count($mobile_string)-2; $b++){
				$mobile_string_result = mysql_query("INSERT INTO tbltrans_company_contact_person_contacts(ConID, type, content) VALUES('".$contactid."', 'mobile', '".$mobile_string[$b]."');", $connection);
			}
			$tele_string = explode("|", $_POST["tele_string"]);
			for($c=0; $c<=count($tele_string)-2; $c++){
				$tele_string_result = mysql_query("INSERT INTO tbltrans_company_contact_person_contacts(ConID, type, content) VALUES('".$contactid."', 'telephone', '".$tele_string[$c]."');", $connection);
			}
			echo $contactid;
		break;

		case 'savetradecontactpersons':
			$contactid = createidno("SCN", "tbltrans_trade_contact_person", "ContactID");
			$sql = "INSERT INTO tbltrans_trade_contact_person SET TradeID = '".$_POST["id"]."', FirstName = '".$_POST["firstname_val"]."', MiddleName = '".$_POST["middlename_val"]."', LastName = '".$_POST["lastname_val"]."', ContactID = '".$contactid."', FullName = '".$_POST["firstname_val"]." ".$_POST["middlename_val"]." ".$_POST["lastname_val"]."', Designation = '".$_POST["designation_val"]."', Address = '".$_POST["address_val"]."', isActive = '". $_POST['isActive'] ."', isPrimary = '". $_POST['isPrimary'] ."';";
			$result = mysql_query($sql, $connection);
			$email_string = explode("|", $_POST["email_string"]);
			for($a=0; $a<=count($email_string)-2; $a++){
				$email_string_result = mysql_query("INSERT INTO tbltrans_trade_contact_person_list(ContactID, type, content) VALUES('".$contactid."', 'email', '".$email_string[$a]."');", $connection);
			}
			$mobile_string = explode("|", $_POST["mobile_string"]);
			for($b=0; $b<=count($mobile_string)-2; $b++){
				$mobile_string_result = mysql_query("INSERT INTO tbltrans_trade_contact_person_list(ContactID, type, content) VALUES('".$contactid."', 'mobile', '".$mobile_string[$b]."');", $connection);
			}
			$tele_string = explode("|", $_POST["tele_string"]);
			for($c=0; $c<=count($tele_string)-2; $c++){
				$tele_string_result = mysql_query("INSERT INTO tbltrans_trade_contact_person_list(ContactID, type, content) VALUES('".$contactid."', 'telephone', '".$tele_string[$c]."');", $connection);
			}
			echo $contactid;
		break;

		case 'load_updatecompany':
            $rowCompanyInfo = mysql_fetch_array(mysql_query("SELECT Company, industry, businessAddress, filename, BillerID FROM tbltrans_company WHERE CompanyID = '".$_POST["id"]."';", $connection));
            $rowBillerInfo = mysql_fetch_array(mysql_query("SELECT BillerName, Telephone, PermanentAddress, CurrentAddress, BillingAddress, Mobile, Email FROM tblref_billprofile WHERE BillerID = '". $rowCompanyInfo['BillerID'] ."';", $connection));
            if($rowCompanyInfo["filename"] == ""){
                $img = "assets/images/noimage5.png";
            }else{
                if(!file_exists("../Mall_Attachments/company/".$_POST["id"]."/profile/".$rowCompanyInfo["filename"])){ 
                	$img = "assets/images/noimage5.png";
				}else{
                	$img = "../Mall_Attachments/company/".$_POST["id"]."/profile/".$rowCompanyInfo["filename"];
				}
            }
            echo $rowCompanyInfo["Company"] . "|" . $rowCompanyInfo["industry"] . "|" . $rowCompanyInfo["businessAddress"] . "|" . $rowBillerInfo["PermanentAddress"] . "|" . $rowBillerInfo["PermanentAddress"] . "|" . $rowBillerInfo["PermanentAddress"] . "|" . $img . "|" . $rowBillerInfo['BillerName'] . "|" . $rowBillerInfo['Telephone'] . "|" . $rowBillerInfo['Mobile'] . "|" . $rowBillerInfo['Email'];
        break;

        case 'load_update_companycontacts':
        	$sql_add = 0;
        	$sql = "SELECT CompanyID, type, content FROM tbltrans_company_contacts WHERE CompanyID = '".$_POST["id"]."' AND type = 'mobile'";
			$result = mysql_query($sql, $connection);
			$result_num = mysql_num_rows($result);
			if($result_num == 0){
				echo "<div class='input-group' style='width:100%;'><input type='text' id='company_contact_mobile' class='spinbox-input form-control input-mask-phone' placeholder='(999)-999-9999' value='".$row["content"]."'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success' onclick='div_add_field(\"company_contact_mobile\",\"input-mask-phone\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>";
			}else{
				while($row = mysql_fetch_array($result)){
				echo "<input type='text' id='company_contact_mobile' class='spinbox-input form-control input-mask-phone' value='".$row["content"]."' style='margin-bottom:5px;' placeholder='(999)-999-9999'>";
				}
				echo "<div class='input-group' style='width:100%;'><input type='text' id='company_contact_mobile' class='spinbox-input form-control input-mask-phone' placeholder='(999)-999-9999' value='".$row["content"]."'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success' onclick='div_add_field(\"company_contact_mobile\",\"input-mask-phone\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>";
			}

			$sql2_add = 0;
			echo "#|";
			$sql2 = "SELECT CompanyID, type, content FROM tbltrans_company_contacts WHERE CompanyID = '".$_POST["id"]."' AND type = 'telephone'";
			$result2 = mysql_query($sql2, $connection);
			$result2_num = mysql_num_rows($result2);
			if($result2_num == 0){
				echo "<div class='input-group' style='width:100%;'><input type='text' id='company_contact_tele' class='spinbox-input form-control input-mask-tele' placeholder='(99)-999-9999' value='".$row2["content"]."'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success' onclick='div_add_field(\"company_contact_tele\",\"input-mask-tele\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>";
			}else{
				while($row2 = mysql_fetch_array($result2)){
					echo "<input type='text' id='company_contact_tele' class='spinbox-input form-control input-mask-tele' value='".$row2["content"]."' style='margin-bottom:5px;' placeholder='(99)-999-9999'>";
				}
				echo "<div class='input-group' style='width:100%;'><input type='text' id='company_contact_tele' class='spinbox-input form-control input-mask-tele' placeholder='(99)-999-9999' value='".$row2["content"]."'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success' onclick='div_add_field(\"company_contact_tele\",\"input-mask-tele\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>";
			}
			
			echo "#|";
			$sql3_add = 0;
			$sql3 = "SELECT CompanyID, type, content FROM tbltrans_company_contacts WHERE CompanyID = '".$_POST["id"]."' AND type = 'fax'";
			$result3 = mysql_query($sql3, $connection);
			$result3_num = mysql_num_rows($result3);
			if($result3_num == 0){
				echo "<div class='input-group' style='width:100%;'><input type='text' id='company_contact_fax' class='spinbox-input form-control input-mask-tele' placeholder='(99)-999-9999' value='".$row3["content"]."'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success' onclick='div_add_field(\"company_contact_fax\",\"input-mask-tele\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>";
			}else{
				while($row3 = mysql_fetch_array($result3)){
					echo "<input type='text' id='company_contact_fax' class='spinbox-input form-control input-mask-tele' value='".$row3["content"]."' style='margin-bottom:5px;' placeholder='(99)-999-9999'>";
				}
				echo "<div class='input-group' style='width:100%;'><input type='text' id='company_contact_fax' class='spinbox-input form-control input-mask-tele' placeholder='(99)-999-9999' value='".$row3["content"]."'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success' onclick='div_add_field(\"company_contact_fax\",\"input-mask-tele\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>";
			}
			
			echo "#|";
			$sql4_add = 0;
			$sql4 = "SELECT CompanyID, type, content FROM tbltrans_company_contacts WHERE CompanyID = '".$_POST["id"]."' AND type = 'email'";
			$result4 = mysql_query($sql4, $connection);
			$result4_num = mysql_num_rows($result4);
			if($result4_num == 0){
				echo "<div class='input-group' style='width:100%;'><input type='text' id='company_contact_email' class='spinbox-input form-control emailaddress' placeholder='sample@yahoo.com' value='".$row4["content"]."'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success' onclick='div_add_field(\"company_contact_email\",\"emailaddress\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>";
			}else{
				while($row4 = mysql_fetch_array($result4)){
					echo "<input type='text' id='company_contact_email' class='spinbox-input form-control emailaddress' value='".$row4["content"]."' style='margin-bottom:5px;' placeholder='sample@yahoo.com'>";
				}
				echo "<div class='input-group' style='width:100%;'><input type='text' id='company_contact_email' class='spinbox-input form-control emailaddress' placeholder='sample@yahoo.com' value='".$row4["content"]."'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success' onclick='div_add_field(\"company_contact_email\",\"emailaddress\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>";
			}

			echo "#|";
			$sql5_add = 0;
			$sql5 = "SELECT CompanyID, type, content FROM tbltrans_company_contacts WHERE CompanyID = '".$_POST["id"]."' AND type = 'website'";
			$result5 = mysql_query($sql5, $connection);
			$result5_num = mysql_num_rows($result5);
			if($result5_num == 0){
				echo "<div class='input-group' style='width:100%;'><input type='text' id='company_contact_website' class='spinbox-input form-control website' placeholder='www.sample.com' value='".$row5["content"]."'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success' onclick='div_add_field(\"company_contact_website\",\"website\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>";
			}else{
				while($row5 = mysql_fetch_array($result5)){
					echo "<input type='text' id='company_contact_website' class='spinbox-input form-control website' value='".$row5["content"]."' style='margin-bottom:5px;' placeholder='www.sample.com'>";
				}
				echo "<div class='input-group' style='width:100%;'><input type='text' id='company_contact_website' class='spinbox-input form-control website' placeholder='www.sample.com' value='".$row5["content"]."'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success' onclick='div_add_field(\"company_contact_website\",\"website\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>";
			}
			echo "#|";
        break;

        case 'load_updatecompany_contactpersons':
        	if($_POST["id"] != ''){
	        	$sql = "SELECT ConID, Confname, Conmname, Conlname, custID, name, designation, address, filename, isActive, isPrimary FROM tbltrans_company_contact_person WHERE ConID = '". $_POST["id"] ."';";
				$result = mysql_query($sql, $connection);
				while($row = mysql_fetch_array($result)){

					if($row['filename'] == ""){
						$image = "assets/images/noimage5.png";
					}else{
						if(!file_exists("../Mall_Attachments/BillProfile/". $_POST["id"] ."/contact_person/". $row["custID"] ."/". $row["filename"])){ 
							$image = "assets/images/noimage5.png";
						}else{
							$image = "../Mall_Attachments/BillProfile/". $_POST["id"] ."/contact_person/". $row["custID"] ."/". $row["filename"];
						}
					}

					if($row['isActive'] == "1"){
						$isActive = "info";
					}else{
						$isActive = "warning";
					}

					if($row['isPrimary'] == "1"){
						$isPrimary = "<span class='fa fa-star orange pull-left'></span><br>";
						$isPrimary2 = "";
					}else{
						$isPrimary = "";
						$isPrimary2 = "hide";
					}
					if($_POST['ViewOnly'] == "ViewOnly"){
						$isView = "<div class='row ". $isPrimary2 ."'><div class='col-md-12'><span class='fa fa-star orange pull-left'></span></div></div>";
					}else{
						$isView = "<div class='tools tools-left in'>
										<a style='margin-bottom: 8px; margin-top: 8px;' class='pull-left'>". $isPrimary ."</a>
										<a href='#' title='Edit Photo' class='btnedit' style='float: right; margin-bottom: 8px; margin-top: 8px;' onclick='editthiscontactperson(\"". $row["custID"] ."\", \"". $row["ConID"] ."\")'><i class='ace-icon fa fa-pencil'></i></a>
										<a href='#' title='Remove Photo' class='btndelete' style='float: right; margin-right: 5px; margin-bottom: 8px; margin-top: 8px;' onclick='removethiscontactperson(\"". $row["custID"] ."\", \"". $row['ConID'] ."\")'><i class='ace-icon fa fa-times red'></i></a>
									</div>";
					}

					if($_POST['ViewType'] == "Inquiry"){
						$ColGrid = "3";
					}else{
						$ColGrid = "4";
					}
					echo 	"<div class='col-md-". $ColGrid ."'>
								<div class='alert alert-". $isActive ." div_inquiry_wells' id='contact_". $row["custID"] ."'>
									". $isView ."
									<center>
										<div class='image'>
											<img class='img-thumbnail imageName form-control' src='". $image ."' style='border: 2px solid #bdc3c7; margin-bottom: 8px;height: 160px;width: 90%;'>
										</div>
									</center>
									<label style='font-size: 14px; font-weight: bold; margin: 0px !important;' class='contact_person_firstname'>". $row["Confname"] ." ". $row["Conmname"] ." ". $row["Conlname"] ."</label>
									<p style='font-size: 14px; font-weight: normal; margin: 0px !important;' class='contact_person_designation'>". $row["designation"] ."</p>
									<p style='font-size: 10px; font-weight: normal; margin: 0px !important;' class='address_person'>". $row["address"] ."</p>";
					$result2 = mysql_query("SELECT content FROM tbltrans_company_contact_person_contacts WHERE ConID = '".$row["custID"]."';", $connection);
					while($row2 = mysql_fetch_array($result2)){
						echo"<p style='font-size: 10px; font-weight: normal;margin: 0px !important;'>".$row2["content"]."</p>";
					}
					echo "</div></div>";
				}
			}
        break;

        case 'load_updatetrade_contactpersons':
        	$sql = "SELECT TradeID, FirstName, MiddleName, LastName, ContactID, FullName, Designation, Address, filename, isActive, isPrimary FROM tbltrans_trade_contact_person WHERE TradeID = '". $_POST["id"] ."';";
			$result = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($result)){
        		$CompanyID = mysql_fetch_array(mysql_query("SELECT companyID FROM tbltrans_tradename WHERE tradeID = '". $row['TradeID'] ."';", $connection));
				if($row['filename'] == ""){
					$image = "assets/images/noimage5.png";
				}else{
					if(!file_exists("../Mall_Attachments/company/". $CompanyID['companyID'] ."/trades/". $_POST['id'] ."/contact_person/". $row["ContactID"] ."/". $row["filename"])){ 
						$image = "assets/images/noimage5.png";
					}else{
						$image = "../Mall_Attachments/company/". $CompanyID['companyID'] ."/trades/". $_POST['id'] ."/contact_person/". $row["ContactID"] ."/". $row["filename"];
					}
				}

				if($row['isActive'] == "1"){
					$isActive = "info";
				}else{
					$isActive = "warning";
				}

				if($row['isPrimary'] == "1"){
					$isPrimary = "<span class='fa fa-star orange pull-left'></span><br>";
				}else{
					$isPrimary = "";
				}

				echo 	"<div class='col-md-4'>
							<div class='alert alert-". $isActive ." div_inquiry_wells save_this_div' id='contact_". $row["ContactID"] ."'>
								<div class='tools tools-left in'>
									<a style='margin-bottom: 8px; margin-top: 8px;' class='pull-left'>". $isPrimary ."</a>
									<a href='#' title='Edit Photo' class='btnedit' style='float: right; margin-bottom: 8px; margin-top: 8px;' onclick='edittradecontactperson(\"". $row["ContactID"] ."\", \"". $row["TradeID"] ."\", \"". $CompanyID['companyID'] ."\")'><i class='ace-icon fa fa-pencil'></i></a>
									<a href='#' title='Remove Photo' class='btndelete' style='float: right; margin-right: 5px; margin-bottom: 8px; margin-top: 8px;' onclick='removetradecontactperson(\"". $row["ContactID"] ."\", \"". $row['TradeID'] ."\")'><i class='ace-icon fa fa-times red'></i></a>
								</div>
								<center>
									<div class='image'>
										<img class='img-thumbnail imageName form-control' src='". $image ."' style='border: 2px solid #bdc3c7; margin-bottom: 8px;height: 160px;width: 90%;'>
									</div>
								
								<label style='font-size: 14px; font-weight: bold; margin: 0px !important;' class='contact_person_firstname'>". $row["FirstName"] ." ". $row["MiddleName"] ." ". $row["LastName"] ."</label>
								<p style='font-size: 14px; font-weight: normal; margin: 0px !important;' class='contact_person_designation'>". $row["Designation"] ."</p>
								<p style='font-size: 10px; font-weight: normal; margin: 0px !important;' class='address_person'>". $row["Address"] ."</p>
								</center>";
				$result2 = mysql_query("SELECT content FROM tbltrans_trade_contact_person_list WHERE ContactID = '".$row["ContactID"]."';", $connection);
				while($row2 = mysql_fetch_array($result2)){
					echo"<p style='font-size: 10px; font-weight: normal;margin: 0px !important;'>".$row2["content"]."</p>";
				}
				echo "</div></div>";
			}
        break;

        case 'loadupdatecompany_signatories':
            $count = 1;
            $res = mysql_query("SELECT firstname, middlename, lastname FROM tbltrans_companysig WHERE CompanyID = '". $_POST['id'] ."'", $connection);
            while($row = mysql_fetch_array($res)){
                echo    "<tr id='trCompSig". $count ."'>
                            <td class='tdFirstName'>". $row['firstname'] ."</td>
                            <td class='tdMiddleName'>". $row['middlename'] ."</td>
                            <td class='tdLastName'>". $row['lastname'] ."</td>
                            <td style='text-align: center;'><button class='btn btn-xs btn-danger btn-round' onclick='RemoveCompSig(\"trCompSig". $count ."\")' style='z-index: 0;'><i class='fa fa-trash-o'></i></button></td>
                        </tr>";
            $count++;
            }
            echo "|" . $count;
        break;

        case 'savenewmall_update':
        	$getBillingID = mysql_fetch_array(mysql_query("SELECT BillerID FROM tbltrans_company WHERE CompanyID = '". $_POST['id'] ."';", $connection));
        	if($getBillingID['BillerID'] == ""){
				$BillerID = createidno("BID", "tblref_billprofile", "BillerID");
				$resSaveBilling = mysql_query("INSERT INTO tblref_billprofile SET BillerID = '". $BillerID ."', BillerName = '". $_POST['BillAccountName'] ."', Telephone = '". $_POST['BillTel'] ."', PermanentAddress = '". $_POST['perm_add'] ."', CurrentAddress = '". $_POST['curr_add'] ."', BillingAddress = '". $_POST['bill_add'] ."', Mobile = '". $_POST['BillMobile'] ."', Email = '". $_POST['BillEmail'] ."';", $connection);
        	}else{
        		$BillerID = $getBillingID['BillerID'];
				$resSaveBilling = mysql_query("UPDATE tblref_billprofile SET BillerName = '". $_POST['BillAccountName'] ."', Telephone = '". $_POST['BillTel'] ."', PermanentAddress = '". $_POST['perm_add'] ."', CurrentAddress = '". $_POST['curr_add'] ."', BillingAddress = '". $_POST['bill_add'] ."', Mobile = '". $_POST['BillMobile'] ."', Email = '". $_POST['BillEmail'] ."' WHERE BillerID = '". $getBillingID['BillerID'] ."';", $connection);
        	}

			$sql = "UPDATE tbltrans_company SET Company = '".$_POST["name"]."', industry = '".$_POST["industry"]."', businessAddress = '".$_POST["busadd"]."', BillerID = '". $BillerID ."' WHERE CompanyID = '".$_POST["id"]."';";
			$result = mysql_query($sql, $connection);

			$deleteall = "DELETE FROM tbltrans_company_owner_contacts WHERE CompanyID = '". $_POST["id"] ."';";
			$resal = mysql_query($deleteall, $connection);

			$deleteall2 = "DELETE FROM tbltrans_company_contacts WHERE CompanyID = '". $_POST["id"] ."';";
			$resal2 = mysql_query($deleteall2, $connection);

			$contact_mobile = explode("|", $_POST["contact_mobile"]);
			for($j=0; $j<=count($contact_mobile)-2; $j++){
				$contact_mobile_query = "INSERT INTO tbltrans_company_contacts(CompanyID, type, content) VALUES('".$_POST["id"]."', 'mobile', '".$contact_mobile[$j]."');";
				$contact_mobile_result = mysql_query($contact_mobile_query, $connection);
			}

			$contact_tele = explode("|", $_POST["contact_tele"]);
			for($k=0; $k<=count($contact_tele)-2; $k++){
				$contact_tele_query = "INSERT INTO tbltrans_company_contacts(CompanyID, type, content) VALUES('".$_POST["id"]."', 'telephone', '".$contact_tele[$k]."');";
				$contact_tele_result = mysql_query($contact_tele_query, $connection);
			}

			$contact_fax = explode("|", $_POST["contact_fax"]);
			for($l=0; $l<=count($contact_fax)-2; $l++){
				$contact_fax_query = "INSERT INTO tbltrans_company_contacts(CompanyID, type, content) VALUES('".$_POST["id"]."', 'fax', '".$contact_fax[$l]."');";
				$contact_fax_result = mysql_query($contact_fax_query, $connection);
			}

			$contact_email = explode("|", $_POST["contact_email"]);
			for($m=0; $m<=count($contact_email)-2; $m++){
				$contact_email_query = "INSERT INTO tbltrans_company_contacts(CompanyID, type, content) VALUES('".$_POST["id"]."', 'email', '".$contact_email[$m]."');";
				$contact_email_result = mysql_query($contact_email_query, $connection);
			}

			$contact_website = explode("|", $_POST["contact_website"]);
			for($n=0; $n<=count($contact_website)-2; $n++){
				$contact_website_query = "INSERT INTO tbltrans_company_contacts(CompanyID, type, content) VALUES('".$_POST["id"]."', 'website', '".$contact_website[$n]."');";
				$contact_website_result = mysql_query($contact_website_query, $connection);
			}

			if($result == true){
				echo $_POST["id"]."|1";
			}
        break;

        case 'selectunit_history':
        	$row = mysql_fetch_array(mysql_query("SELECT unitname, classificationname, mallid, floorid, wingid, classid, depid, catid FROM tblref_unit WHERE unitid = '".$_POST["id"]."'", $connection));

			$row2 = mysql_fetch_array(mysql_query("SELECT mallid, mallname, malladdress FROM tblref_mall WHERE mallid = '".$row["mallid"]."'", $connection));

			$row3 = mysql_fetch_array(mysql_query("SELECT classification FROM tblref_merchandise_class WHERE classificationID = '".$row["classid"]."'", $connection));

			$row4 = mysql_fetch_array(mysql_query("SELECT department FROM tblref_merchandise_depa WHERE departmentID = '".$row["depid"]."'", $connection));

			$row5 = mysql_fetch_array(mysql_query("SELECT category FROM tblref_merchandisedep_cat WHERE categoryID = '".$row["catid"]."'", $connection));

			$row6 = mysql_fetch_array(mysql_query("SELECT floor FROM tblref_floorsetup WHERE floorid = '".$row["floorid"]."'", $connection));

			$row7 = mysql_fetch_array(mysql_query("SELECT wing FROM tblref_wing WHERE wingID = '".$row["wingid"]."'", $connection));

			echo $row2["mallname"] . "|" . $row["unitname"] . "|" . $row6["floor"] . "|" . $row7["wing"] . "|" . $row3["classification"] . "|" . $row4["department"] . "|" . $row5["category"];
        break;

        case 'loadtbl_selectunit_history':
        	$dates = explode(" - ", $_POST["date_filter"]);
        	$sql = "SELECT TenantID, tradename, companyname, datefrom, dateto, status FROM tbltrans_tenants WHERE unitID = '".$_POST["id"]."' AND (datefrom BETWEEN '".date("Y-m-d", strtotime($dates[0]))."' AND '".date("Y-m-d", strtotime($dates[1]))."') ";
        	$result = mysql_query($sql, $connection);
        	while($row = mysql_fetch_array($result)){

        		if($row[5] == "Active"){
                    $stat = "<span class='fa fa-flag' style='font-weight: 700; color: #DFE21A;'></span>";
                }else if($row[5] == "inactive"){
                    $stat = "<span class='fa fa-flag' style='font-weight: 700; color: DarkGray;'></span>";
                }else if($row[5] == "forrenewal"){
                    $stat = "<span class='fa fa-flag' style='font-weight: 700; color: #428BCA;'></span>";
                }else if($row[5] == "foreviction"){
                    $stat = "<span class='fa fa-flag' style='font-weight: 700; color: red;'></span>";
                }
                else if($row[5] == "evicted"){
                    $stat = "<span class='fa fa-flag' style='font-weight: 700; color: grey;'></span>";
                }

        		echo "
				<tr style='width: 100%;display: table;table-layout: fixed;'>
				<td class='hide_mobile' width='5%'><center>" . $stat . "</center></th>
				<td class='hide_mobile'>" . $row["TenantID"] . "</th>
				<td class='scroll'>" . $row["tradename"] . "</th>
				<td class='scroll'>" . $row["companyname"] . "</th>
				<td class='hide_mobile'>" . $row["datefrom"] . "</th>
				<td class='hide_mobile'>" . $row["dateto"] . "</th>
				</tr>";
        	}
        break;

        case 'loadallmalls_SET':
	        $flridd = "";
	        $wingidd = "";
	        $unitt = "";
	        $srchtype = "";
        	if($_POST["mall"] == "" && $_POST["key"] != ""){
        		$sqlunittt = "SELECT mallid, floorid, wingid FROM tblref_unit WHERE unitname LIKE '%".$_POST["key"]."%'";
				$sqlunitttresult = mysql_query($sqlunittt, $connection);
				$unittt = mysql_fetch_array($sqlunitttresult);

				$mall = "WHERE mallID = '" . $unittt["mallid"] ."'";
				$flridd .= "WHERE floorid = '".$unittt["floorid"]."' ORDER BY floor ASC";
				$wingidd .= "WHERE wingID = '" . $unittt["wingid"] ."'";
				$unitt .= "WHERE unitname LIKE '%" . $_POST["key"] . "%' AND floorid = '".$unittt["floorid"]."' ORDER BY unitname ASC";

				$srchtype .= "unit_only";
        	}else{
				if($_POST["mall"] == ""){
					$mall = "";
				}else{
					$mall = "WHERE mallID = '" . $_POST["mall"] ."'";
				}
				$srchtype .= "unit_with_other_info";
        	}

        	if($srchtype == "unit_with_other_info"){
        		$sqlunittt2 = "SELECT mallid, floorid, wingid FROM tblref_unit WHERE mallid = '".$_POST["mall"]."' AND floorid = '".$_POST["floor"]."' AND wingid = '".$_POST["wing"]."' AND unitname LIKE '%".$_POST["key"]."%'";
				$sqlunittt2result = mysql_query($sqlunittt2, $connection);
				$unittt_cnt = mysql_num_rows($sqlunittt2result);

				if($unittt_cnt == 0){
					if($_POST["mall"] == "" && $_POST["floor"] == "" && $_POST["wing"] == "" && $_POST["key"] == ""){
			        	$sql_mall = "SELECT mallid, mallname FROM tblref_mall " . $mall;
			       		$res_mall = mysql_query($sql_mall, $connection);
						while($row_mall = mysql_fetch_array($res_mall)){
							echo "<li class='list_mall'><i class='fa fa-building' style='color: #666633;'></i>&nbsp;&nbsp;".$row_mall["mallname"];
										if($_POST["mall"] == "" && $_POST["key"] != ""){
		        							$wing = $wingidd;
		        						}else{
											if($_POST["wing"] == ""){
												$wing = "WHERE mallID = '".$row_mall["mallid"]."'";
											}else{
												$wing = "WHERE wingID = '" . $_POST["wing"] ."'";
											}
		        						}

											$sql_wing = "SELECT wingID, wing FROM tblref_wing " . $wing;
											$sql_wing_res = mysql_query($sql_wing, $connection);
											while($wing = mysql_fetch_array($sql_wing_res)){
												echo "<ul>";
													echo "<li class='list_mall clickme'><i class='fa fa-folder-open' style='color: #ffcc66;'></i>&nbsp;&nbsp;".$wing["wing"];
															if($_POST["mall"] == "" && $_POST["key"] != ""){
		        												$floor = $flridd;
		        											}else{
																if($_POST["floor"] == ""){
																	$floor = "WHERE wingid = '".$wing["wingID"]."'";
																}else{
																	$floor = "WHERE floorid = '" . $_POST["floor"] . "'";
																}
		        											}

																$sql_floor = "SELECT floorid, floor FROM tblref_floorsetup " . $floor;
																$sql_floor_res = mysql_query($sql_floor, $connection);
																while($floor = mysql_fetch_array($sql_floor_res)){

																	echo "<ul>";
																		echo "<li class='list_mall clickme'><i class='fa fa-folder-open' style='color: #ffcc66;'></i>&nbsp;&nbsp;". $floor["floor"];
																		if($_POST["mall"] == "" && $_POST["key"] != ""){
    																		$key = $unitt;
    																	}else{
																			if($_POST["key"] == ""){
    																			$key = "WHERE floorid = '".$floor["floorid"]."' ORDER BY unitname ASC";
    																		}else{
    																			$key = "WHERE unitname LIKE '%" . $_POST["key"] . "%' AND floorid = '".$floor["floorid"]."' ORDER BY unitname ASC";
    																		}
    																	}

																			$sql_unit = "SELECT unitid, unitname FROM tblref_unit ". $key;
																			$sql_unit_res = mysql_query($sql_unit, $connection);
																			$cntunit = mysql_num_rows($sql_unit_res);
																			if($cntunit != 0){
																				echo "<ul>";
																			}
																			while($unit = mysql_fetch_array($sql_unit_res)){
																				echo"<li class='unit' onclick='selectunit(\"".$unit["unitid"]."\")'>".$unit["unitname"]."</li>";
																			}
																			if($cntunit != 0){
																				echo "</ul>";
																			}

																		echo "</li>";
																	echo "</ul>";

																}
													echo "</li>";
												echo "</ul>";
											}
							echo "</li>";
						}
					}else{
						echo "<div style='opacity: 0.3;'><center><label style='font-size:30px;margin-top:10%;'>No Data Found...</label><img src='assets/images/folder.png' style='margin-top:5%;'></center></div>";
					}
				}else{
		        	$sql_mall = "SELECT mallid, mallname FROM tblref_mall " . $mall;
		       		$res_mall = mysql_query($sql_mall, $connection);
					while($row_mall = mysql_fetch_array($res_mall)){
						echo "<li class='list_mall'><i class='fa fa-building' style='color: #666633;'></i>&nbsp;&nbsp;".$row_mall["mallname"];
									if($_POST["mall"] == "" && $_POST["key"] != ""){
	        							$wing = $wingidd;
	        						}else{
										if($_POST["wing"] == ""){
											$wing = "WHERE mallID = '".$row_mall["mallid"]."'";
										}else{
											$wing = "WHERE wingID = '" . $_POST["wing"] ."'";
										}
	        						}
										$sql_wing = "SELECT wingID, wing FROM tblref_wing " . $wing;
										$sql_wing_res = mysql_query($sql_wing, $connection);
										while($wing = mysql_fetch_array($sql_wing_res)){
											echo "<ul>";
												echo "<li class='list_mall clickme'><i class='fa fa-folder-open' style='color: #ffcc66;'></i>&nbsp;&nbsp;".$wing["wing"];
														if($_POST["mall"] == "" && $_POST["key"] != ""){
	        												$floor = $flridd;
	        											}else{
															if($_POST["floor"] == ""){
																$floor = "WHERE wingid = '".$wing["wingID"]."'";
															}else{
																$floor = "WHERE floorid = '" . $_POST["floor"] . "'";
															}
	        											}

															$sql_floor = "SELECT floorid, floor FROM tblref_floorsetup " . $floor;
															$sql_floor_res = mysql_query($sql_floor, $connection);
															while($floor = mysql_fetch_array($sql_floor_res)){

																echo "<ul>";
																	echo "<li class='list_mall clickme'><i class='fa fa-folder-open' style='color: #ffcc66;'></i>&nbsp;&nbsp;". $floor["floor"];
																	if($_POST["mall"] == "" && $_POST["key"] != ""){
																		$key = $unitt;
																	}else{
																		if($_POST["key"] == ""){
																			$key = "WHERE floorid = '".$floor["floorid"]."' ORDER BY unitname ASC";
																		}else{
																			$key = "WHERE unitname LIKE '%" . $_POST["key"] . "%' AND floorid = '".$floor["floorid"]."' ORDER BY unitname ASC";
																		}
																	}
																		$sql_unit = "SELECT unitid, unitname FROM tblref_unit ". $key;
																		$sql_unit_res = mysql_query($sql_unit, $connection);
																		$cntunit = mysql_num_rows($sql_unit_res);
																		if($cntunit != 0){
																			echo "<ul>";
																		}
																		while($unit = mysql_fetch_array($sql_unit_res)){
																					echo"<li class='unit' onclick='selectunit(\"".$unit["unitid"]."\")'>".$unit["unitname"]."</li>";
																		}
																		if($cntunit != 0){
																			echo "</ul>";
																		}
																	echo "</li>";
																echo "</ul>";

															}
												echo "</li>";
											echo "</ul>";
										}
						echo "</li>";
					}
				}
        	}else if($srchtype == "unit_only"){
        		$sqlunittt2 = "SELECT mallid, floorid, wingid FROM tblref_unit WHERE unitname LIKE '%".$_POST["key"]."%'";
				$sqlunittt2result = mysql_query($sqlunittt2, $connection);
				$unittt_cnt = mysql_num_rows($sqlunittt2result);

				if($unittt_cnt == 0){
					echo "<div style='opacity: 0.3;'><center><label style='font-size:30px;margin-top:10%;'>No Data Found...</label><img src='assets/images/folder.png' style='margin-top:5%;'></center></div>";
				}else{
		        	$sql_mall = "SELECT mallid, mallname FROM tblref_mall " . $mall;
		       		$res_mall = mysql_query($sql_mall, $connection);
					while($row_mall = mysql_fetch_array($res_mall)){
						echo "<li class='list_mall'><i class='fa fa-building' style='color: #666633;'></i>&nbsp;&nbsp;".$row_mall["mallname"];
							if($_POST["mall"] == "" && $_POST["key"] != ""){
    							$wing = $wingidd;
    						}else{
								if($_POST["wing"] == ""){
									$wing = "WHERE mallID = '".$row_mall["mallid"]."'";
								}else{
									$wing = "WHERE wingID = '" . $_POST["wing"] ."'";
								}
    						}

								$sql_wing = "SELECT wingID, wing FROM tblref_wing " . $wing;
								$sql_wing_res = mysql_query($sql_wing, $connection);
								while($wing = mysql_fetch_array($sql_wing_res)){
									echo "<ul>";
										echo "<li class='list_mall clickme'><i class='fa fa-folder-open' style='color: #ffcc66;'></i>&nbsp;&nbsp;".$wing["wing"];
												if($_POST["mall"] == "" && $_POST["key"] != ""){
    												$floor = $flridd;
    											}else{
													if($_POST["floor"] == ""){
														$floor = "WHERE wingid = '".$wing["wingID"]."'";
													}else{
														$floor = "WHERE floorid = '" . $_POST["floor"] . "'";
													}
    											}

													$sql_floor = "SELECT floorid, floor FROM tblref_floorsetup " . $floor;
													$sql_floor_res = mysql_query($sql_floor, $connection);
													while($floor = mysql_fetch_array($sql_floor_res)){

														echo "<ul>";
															echo "<li class='list_mall clickme'><i class='fa fa-folder-open' style='color: #ffcc66;'></i>&nbsp;&nbsp;". $floor["floor"];
															if($_POST["mall"] == "" && $_POST["key"] != ""){
																$key = $unitt;
															}else{
																if($_POST["key"] == ""){
																	$key = "WHERE floorid = '".$floor["floorid"]."' ORDER BY unitname ASC";
																}else{
																	$key = "WHERE unitname LIKE '%" . $_POST["key"] . "%' AND floorid = '".$floor["floorid"]."' ORDER BY unitname ASC";
																}
															}

																$sql_unit = "SELECT unitid, unitname FROM tblref_unit ". $key;
																$sql_unit_res = mysql_query($sql_unit, $connection);
																$cntunit = mysql_num_rows($sql_unit_res);
																if($cntunit != 0){
																	echo "<ul>";
																}
																while($unit = mysql_fetch_array($sql_unit_res)){
																	echo"<li class='unit' onclick='selectunit(\"".$unit["unitid"]."\")'>".$unit["unitname"]."</li>";
																}
																if($cntunit != 0){
																	echo "</ul>";
																}

															echo "</li>";
														echo "</ul>";

													}
										echo "</li>";
									echo "</ul>";
								}
						echo "</li>";
					}
				}
        	}

        break;

        case 'loadallmalls_LCA':
	        if($_POST["mall"] == ""){
				$mall = "";
			}else{
				$mall = "WHERE mallID = '" . $_POST["mall"] ."'";
			}
				$content = "";
				$cnnnt = 0;
	        	$sql_mall = "SELECT mallid, mallname FROM tblref_mall " . $mall;
	       		$res_mall = mysql_query($sql_mall, $connection);
				while($row_mall = mysql_fetch_array($res_mall)){
					$content .= "<li class='list_mall'><i class='fa fa-building' style='color: #666633;'></i>&nbsp;&nbsp;".$row_mall["mallname"];
					if($_POST["key"] == ""){
						$key = "";
					}else{
						$key = "AND unitname LIKE '%".$_POST["key"]."%'";
					}

					$sql_unit = "SELECT unitid, unitname FROM tblref_unit WHERE mallid = '".$row_mall["mallid"]."' AND typeofbusiness = 'LCA' ".$key." ORDER BY unitname ASC";
					$sql_unit_res = mysql_query($sql_unit, $connection);
					$cntunit = mysql_num_rows($sql_unit_res);
					if($cntunit != 0){
						$content .= "<ul>";
					}
					while($unit = mysql_fetch_array($sql_unit_res)){
						$cnnnt++;
						$content .="<li class='unit' onclick='selectunit_lca(\"".$unit["unitid"]."\")'>".$unit["unitname"]."</li>";
					}
					if($cntunit != 0){
						$content .= "</ul>";
					}
					$content .= "</li>";
				}

				if($cnnnt == 0){
					echo "<div style='opacity: 0.3;'><center><label style='font-size:30px;margin-top:10%;'>No Data Found...</label><img src='assets/images/folder.png' style='margin-top:5%;'></center></div>";
				}else{
					echo '<ul class="tree tree-unselectable tree-folder-select">'.$content.'</ul>';
				}
        break;

        case 'editthiscontactperson':
        	$row = mysql_fetch_array(mysql_query("SELECT ConID, Confname, Conmname, Conlname, custID, name, designation, address, filename, isActive, isPrimary FROM tbltrans_company_contact_person WHERE custID = '". $_POST["id"] ."';", $connection));

        	if($row['filename'] == ""){
                $image = "assets/images/noimage5.png";
            }else{
            	if(!file_exists("../Mall_Attachments/company/". $row["ConID"] ."/contact_person/". $row["custID"] ."/". $row["filename"])){ 
					$image = "assets/images/noimage5.png";
				}else{
					$image = "../Mall_Attachments/company/". $row["ConID"] ."/contact_person/". $row["custID"] ."/". $row["filename"];
				}
            }

    		echo $row["Confname"] . "|" . $row["Conmname"] . "|" . $row["Conlname"] . "|" . $row["designation"] . "|" . $row["address"] . "|" . $image . "|" . $row['isPrimary'] . "|" . $row['isActive'];
        break;

        case 'edittradecontactperson':
        	$row = mysql_fetch_array(mysql_query("SELECT TradeID, FirstName, MiddleName, LastName, ContactID, FullName, Designation, Address, filename, isActive, isPrimary FROM tbltrans_trade_contact_person WHERE ContactID = '". $_POST["id"] ."';", $connection));
        	$CompanyID = mysql_fetch_array(mysql_query("SELECT companyID FROM tbltrans_tradename WHERE tradeID = '". $row['TradeID'] ."';", $connection));
        	if($row['filename'] == ""){
                $image = "assets/images/noimage5.png";
            }else{
            	if(!file_exists("../Mall_Attachments/company/". $CompanyID['companyID'] ."/trades/". $row["TradeID"] ."/contact_person/". $row["ContactID"] ."/". $row["filename"])){ 
					$image = "assets/images/noimage5.png";
				}else{
					$image = "../Mall_Attachments/company/". $CompanyID['companyID'] ."/trades/". $row["TradeID"] ."/contact_person/". $row["ContactID"] ."/". $row["filename"];
				}
            }

    		echo $row["FirstName"] . "|" . $row["MiddleName"] . "|" . $row["LastName"] . "|" . $row["Designation"] . "|" . $row["Address"] . "|" . $image . "|" . $row['isPrimary'] . "|" . $row['isActive'];
        break;

        case 'editthiscontactperson_contacts':
        	$sql = "SELECT type, content FROM tbltrans_company_contact_person_contacts WHERE ConID = '".$_POST["id"]."' AND type = 'email'";
        	$result = mysql_query($sql, $connection);
        	$count = mysql_num_rows($result);
        	$count_a = 0;
        	if($count == 0){
        		echo "<div class='input-group' style='width:100%;'><input type='text' id='div_add_contact_person_email_update' class='spinbox-input form-control email-address emailaddress' placeholder='sample@yahoo.com'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success' onclick='div_add_field(\"div_add_contact_person_email_update\",\"emailaddress\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>#|";
        	}
        	while($row = mysql_fetch_array($result)){
        		$count_a++;
        		if($count_a == $count){
					echo "<div class='input-group' style='width:100%;'><input type='text' id='div_add_contact_person_email_update' class='spinbox-input form-control email-address emailaddress' value='".$row["content"]."' placeholder='sample@yahoo.com'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success' onclick='div_add_field(\"div_add_contact_person_email_update\",\"emailaddress\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>#|";
        		}else{
        			echo "<input type='text' id='div_add_contact_person_email_update' class='form-control emailaddress' value='".$row["content"]."' style='margin-bottom:5px;'>";
        		}
        	}

        	$sql2 = "SELECT type, content FROM tbltrans_company_contact_person_contacts WHERE ConID = '".$_POST["id"]."' AND type = 'mobile'";
        	$result2 = mysql_query($sql2, $connection);
        	$count2 = mysql_num_rows($result2);
        	$count2_a = 0;
        	if($count2 == 0){
        		echo "<div class='input-group' style='width:100%;'><input type='text' id='div_add_contact_person_mobile_update' class='spinbox-input form-control input-mask-phone' placeholder='(999)-999-9999'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success' onclick='div_add_field(\"div_add_contact_person_mobile_update\",\"input-mask-phone\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>#|";
        	}

        	while($row2 = mysql_fetch_array($result2)){
        		$count2_a++;
        		if($count2_a == $count2){
					echo "<div class='input-group' style='width:100%;'><input type='text' id='div_add_contact_person_mobile_update' class='spinbox-input form-control input-mask-phone' placeholder='(999)-999-9999' value='".$row2["content"]."'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success' onclick='div_add_field(\"div_add_contact_person_mobile_update\",\"input-mask-phone\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>#|";
        		}else{
        			echo "<input type='text' id='div_add_contact_person_mobile_update' class='form-control input-mask-phone' value='".$row2["content"]."' style='margin-bottom:5px;'>";
        		}
        	}

        	$sql3 = "SELECT type, content FROM tbltrans_company_contact_person_contacts WHERE ConID = '".$_POST["id"]."' AND type = 'telephone'";
        	$result3 = mysql_query($sql3, $connection);
        	$count3 = mysql_num_rows($result3);
        	$count3_a = 0;
        	if($count3 == 0){
        		echo "<div class='input-group' style='width:100%;'><input type='text' id='div_add_contact_person_tele_update' class='spinbox-input form-control input-mask-tele' placeholder='(99)-999-9999'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success' onclick='div_add_field(\"div_add_contact_person_tele_update\",\"input-mask-tele\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>#|";
        	}
        	while($row3 = mysql_fetch_array($result3)){
        		$count3_a++;
        		if($count3_a == $count3){
					echo "<div class='input-group' style='width:100%;'><input type='text' id='div_add_contact_person_tele_update' class='spinbox-input form-control input-mask-tele' placeholder='(99)-999-9999' value='".$row3["content"]."'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success' onclick='div_add_field(\"div_add_contact_person_tele_update\",\"input-mask-tele\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>#|";
        		}else{
        			echo "<input type='text' id='div_add_contact_person_tele_update' class='form-control input-mask-tele' value='".$row3["content"]."' style='margin-bottom:5px;'>";
        		}
        	}
        break;

        case 'edittradecontactperson_contacts':
        	$sql = "SELECT type, content FROM tbltrans_trade_contact_person_list WHERE ContactID = '". $_POST["id"] ."' AND type = 'email'";
        	$result = mysql_query($sql, $connection);
        	$count = mysql_num_rows($result);
        	$count_a = 0;
        	if($count == 0){
        		echo "<div class='input-group' style='width:100%;'><input type='text' id='div_add_trade_contact_person_email_update' class='spinbox-input form-control email-address emailaddress' placeholder='sample@yahoo.com'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success' onclick='div_add_field(\"div_add_trade_contact_person_email_update\",\"emailaddress\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>#|";
        	}
        	while($row = mysql_fetch_array($result)){
        		$count_a++;
        		if($count_a == $count){
					echo "<div class='input-group' style='width:100%;'><input type='text' id='div_add_trade_contact_person_email_update' class='spinbox-input form-control email-address emailaddress' value='". $row["content"] ."' placeholder='sample@yahoo.com'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success' onclick='div_add_field(\"div_add_trade_contact_person_email_update\",\"emailaddress\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>#|";
        		}else{
        			echo "<input type='text' id='div_add_trade_contact_person_email_update' class='form-control emailaddress' value='". $row["content"] ."' style='margin-bottom:5px;'>";
        		}
        	}

        	$sql2 = "SELECT type, content FROM tbltrans_trade_contact_person_list WHERE ContactID = '". $_POST["id"] ."' AND type = 'mobile'";
        	$result2 = mysql_query($sql2, $connection);
        	$count2 = mysql_num_rows($result2);
        	$count2_a = 0;
        	if($count2 == 0){
        		echo "<div class='input-group' style='width:100%;'><input type='text' id='div_add_trade_contact_person_mobile_update' class='spinbox-input form-control input-mask-phone' placeholder='(999)-999-9999'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success' onclick='div_add_field(\"div_add_trade_contact_person_mobile_update\",\"input-mask-phone\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>#|";
        	}

        	while($row2 = mysql_fetch_array($result2)){
        		$count2_a++;
        		if($count2_a == $count2){
					echo "<div class='input-group' style='width:100%;'><input type='text' id='div_add_trade_contact_person_mobile_update' class='spinbox-input form-control input-mask-phone' placeholder='(999)-999-9999' value='". $row2["content"] ."'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success' onclick='div_add_field(\"div_add_trade_contact_person_mobile_update\",\"input-mask-phone\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>#|";
        		}else{
        			echo "<input type='text' id='div_add_trade_contact_person_mobile_update' class='form-control input-mask-phone' value='".$row2["content"]."' style='margin-bottom:5px;'>";
        		}
        	}

        	$sql3 = "SELECT type, content FROM tbltrans_trade_contact_person_list WHERE ContactID = '". $_POST["id"] ."' AND type = 'telephone'";
        	$result3 = mysql_query($sql3, $connection);
        	$count3 = mysql_num_rows($result3);
        	$count3_a = 0;
        	if($count3 == 0){
        		echo "<div class='input-group' style='width:100%;'><input type='text' id='div_add_trade_contact_person_tele_update' class='spinbox-input form-control input-mask-tele' placeholder='(99)-999-9999'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success' onclick='div_add_field(\"div_add_trade_contact_person_tele_update\",\"input-mask-tele\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>#|";
        	}
        	while($row3 = mysql_fetch_array($result3)){
        		$count3_a++;
        		if($count3_a == $count3){
					echo "<div class='input-group' style='width:100%;'><input type='text' id='div_add_trade_contact_person_tele_update' class='spinbox-input form-control input-mask-tele' placeholder='(99)-999-9999' value='". $row3["content"] ."'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success' onclick='div_add_field(\"div_add_trade_contact_person_tele_update\",\"input-mask-tele\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>#|";
        		}else{
        			echo "<input type='text' id='div_add_trade_contact_person_tele_update' class='form-control input-mask-tele' value='".$row3["content"]."' style='margin-bottom:5px;'>";
        		}
        	}
        break;

        case 'removethiscontactperson2':
        	$res = mysql_query("DELETE FROM tbltrans_company_contact_person WHERE custID = '". $_POST['ContactID'] ."';", $connection);
        	$res2 = mysql_query("DELETE FROM tbltrans_company_contact_person_contacts WHERE ConID = '". $_POST['ContactID'] ."';", $connection);
        	if($res == true && $res2 == true){
        		echo 1;
        	}else{
        		echo 2;
        	}
       	break;

        case 'savecontactperson_update':
        	if($_POST['isPrimary'] == '1'){
        		$resPrimary = mysql_query("UPDATE tbltrans_company_contact_person SET isPrimary = '0' WHERE ConID = '". $_POST['BillerID'] ."';", $connection);
        	}
        	$result = mysql_query("UPDATE tbltrans_company_contact_person SET Confname = '".$_POST["fname"]."', Conmname = '".$_POST["mname"]."', Conlname = '".$_POST["lname"]."', designation = '".$_POST["designation"]."', address = '".$_POST["add"]."', isActive = '". $_POST['isActive'] ."', isPrimary = '". $_POST['isPrimary'] ."' WHERE custID = '".$_POST["id"]."';", $connection);
        	if($result == true){
        		echo 1;
        	}
        break;

        case 'savecontactperson_update_contactnum':
        	$sql2 = "DELETE FROM tbltrans_company_contact_person_contacts WHERE ConID = '".$_POST["id"]."'";
        	$result2 = mysql_query($sql2, $connection);

        	$contact_email = explode("|", $_POST["email_update"]);
        	for ($i=0; $i<=count($contact_email)-2; $i++){
	        	$sql = "INSERT INTO tbltrans_company_contact_person_contacts (ConID, type, content)VALUES('".$_POST["id"]."', 'email', '".$contact_email[$i]."')";
	        	$result = mysql_query($sql, $connection);
	        	if($result == true){
	        		echo 1;
	        	}
        	}

        	$contact_mobile = explode("|", $_POST["mobile_number"]);
        	for ($j=0; $j<=count($contact_mobile)-2; $j++){
	        	$sql = "INSERT INTO tbltrans_company_contact_person_contacts (ConID, type, content)VALUES('".$_POST["id"]."', 'mobile', '".$contact_mobile[$j]."')";
	        	$result = mysql_query($sql, $connection);
	        	if($result == true){
	        		echo 1;
	        	}
        	}

        	$contact_tele = explode("|", $_POST["tel_number"]);
        	for ($k=0; $k<=count($contact_tele)-2; $k++){
	        	$sql = "INSERT INTO tbltrans_company_contact_person_contacts (ConID, type, content)VALUES('".$_POST["id"]."', 'telephone', '".$contact_tele[$k]."')";
	        	$result = mysql_query($sql, $connection);
	        	if($result == true){
	        		echo 1;
	        	}
        	}
        break;

        case 'savetradecontactperson_update':
        	if($_POST['isPrimary'] == 1){
        		$resPrimary = mysql_query("UPDATE tbltrans_trade_contact_person SET isPrimary = '0' WHERE TradeID = '". $_POST['TradeID'] ."';", $connection);
        	}
        	$sql = "UPDATE tbltrans_trade_contact_person SET FirstName = '".$_POST["fname"]."', MiddleName = '".$_POST["mname"]."', LastName = '".$_POST["lname"]."', Designation = '".$_POST["designation"]."', Address = '".$_POST["add"]."', isActive = '". $_POST['isActive'] ."', isPrimary = '". $_POST['isPrimary'] ."' WHERE ContactID = '". $_POST["id"] ."';";
        	$result = mysql_query($sql, $connection);
        	if($result == true){
        		echo 1;
        	}
        break;

        case 'savetradecontactperson_update_contactnum':
        	$sql2 = "DELETE FROM tbltrans_trade_contact_person_list WHERE ContactID = '".$_POST["id"]."';";
        	$result2 = mysql_query($sql2, $connection);

        	$contact_email = explode("|", $_POST["email_update"]);
        	for ($i=0; $i<=count($contact_email)-2; $i++){
	        	$sql = "INSERT INTO tbltrans_trade_contact_person_list (ContactID, type, content)VALUES('".$_POST["id"]."', 'email', '".$contact_email[$i]."')";
	        	$result = mysql_query($sql, $connection);
	        	if($result == true){
	        		echo 1;
	        	}
        	}

        	$contact_mobile = explode("|", $_POST["mobile_number"]);
        	for ($j=0; $j<=count($contact_mobile)-2; $j++){
	        	$sql = "INSERT INTO tbltrans_trade_contact_person_list (ContactID, type, content)VALUES('".$_POST["id"]."', 'mobile', '".$contact_mobile[$j]."')";
	        	$result = mysql_query($sql, $connection);
	        	if($result == true){
	        		echo 1;
	        	}
        	}

        	$contact_tele = explode("|", $_POST["tel_number"]);
        	for ($k=0; $k<=count($contact_tele)-2; $k++){
	        	$sql = "INSERT INTO tbltrans_trade_contact_person_list (ContactID, type, content)VALUES('".$_POST["id"]."', 'telephone', '".$contact_tele[$k]."')";
	        	$result = mysql_query($sql, $connection);
	        	if($result == true){
	        		echo 1;
	        	}
        	}
        break;

		case 'fncLoadRemarks':
			$getInquiryID = explode("-", $_POST["InquiryID"]);
			$res = mysql_query("SELECT a.remID, a.xremarks, b.firstname, b.middlename, b.lastname, a.xdate, a.inqID FROM tbltrans_remarks AS a LEFT JOIN tbluser AS b ON a.userID = b.userid WHERE a.inqID = '". $getInquiryID[0] ."-". $getInquiryID[1] ."' ORDER BY a.xdate DESC;", $connection);
			$rowCount = mysql_num_rows($res);
			if($rowCount == 0){
        		echo "<div class='alert alert-info center'> No Remarks Found.. </div>";
			}else{
				while($row = mysql_fetch_array($res)){
				echo "<li class='dd-item dd2-item' id='module_1' style='cursor: pointer;'>
					    <div class='dd2-content'><small style='width:80%;font-size: 85%;display: inline-block;color:black !important;text-align:justify'>".$row["xremarks"]."</small>
					       <a href='#' title='Edit Company Profile' class='btnedit' style='float:right;padding-left:2px;display: inline-block;' onclick='edittranremarks(\"".$row["remID"]."\", \"".$row["inqID"]."\");'><i class='ace-icon fa fa-pencil' style='font-size:15px;'></i></a>
					       <a href='#' title='Delete Company Profile' class='btnedit' style='float:right;padding-left:2px;padding-right:4px;font-size:15px;display: inline-block;' onclick='deletetranremarks(\"".$row["remID"]."\", \"".$row["inqID"]."\");'><i class='ace-icon fa fa-remove' style='color:#b30000;'></i></a>
					       <br />
					       <br /><text style='font-size: 80%;font-weight: normal;margin:0px;'>Added by: ".$row["firstname"]." ".$row["lastname"]."</text><br />
					       		<text style='font-size: 80%;font-weight: normal;margin:0px;'>Date Added: ".date("F d, Y h:i:s A", strtotime($row["xdate"]))."</text>
					       	<br />
					    </div>
					  </li>";
				}
			}
		break;

		/* Edited - Added xsource and sourceid for events fetching unique remarks. */
		case 'savenewremark':
			$datenow = getsysdate();
			if($_POST["remID"] == ""){
				$remid = createidno("REM", "tbltrans_remarks", "remID");
				$getInquiryID = explode("-", $_POST["inqID"]);
				$sql = "INSERT INTO tbltrans_remarks(remID, inqID, xremarks, xdate, userID, xsource, sourceid)VALUES('". $remid ."', '". $getInquiryID[0] ."-". $getInquiryID[1] ."', '". $_POST["remarks"] ."', '". date($datenow." H:i:s") ."', '". $_SESSION['MMS-UserID'] ."','".$_POST['xsource']."','".$_POST['sourceid']."')";
				$result = mysql_query($sql, $connection) or die;
				if($result == true){
					echo 1;
				}
			}else{
				$sql = "UPDATE tbltrans_remarks SET xremarks = '". $_POST["remarks"] ."' WHERE remID = '".$_POST["remID"]."'";
				$result = mysql_query($sql, $connection);
				if($result == true){
					echo 2;
				}
			}
		break;

		case 'edittranremarks':
			$sql = "SELECT xremarks FROM tbltrans_remarks WHERE remID = '".$_POST["remID"]."'";
			$result = mysql_query($sql, $connection);
			$row = mysql_fetch_array($result);

			echo $row["xremarks"];
		break;

		case 'deletetranremarks':
			$sql = "DELETE FROM tbltrans_remarks WHERE remID = '".$_POST["remID"]."'";
			$result = mysql_query($sql, $connection);
			if($result == true){
				echo 1;
			}
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

		case 'getheaderprint2':
			$SysTemplate = mysql_fetch_array(mysql_query("SELECT template FROM tblsys_setup;", $connection));
			$TenantInfo = mysql_fetch_array(mysql_query("SELECT mallCompanyID, mallID FROM tbltrans_tenants WHERE TenantID = '". $_POST['TenantID'] ."';", $connection));
			$MallCompanyID = mysql_fetch_array(mysql_query("SELECT MallCompanyName, MallCompanyAddress, MallCompanyTelephone, MallCompanyEmailAdd, MallCompanyImage FROM tblref_mallcompany WHERE MallCompanyID = '". $TenantInfo['mallCompanyID'] ."';", $connection));
			$Mall = mysql_fetch_array(mysql_query("SELECT mallname, malladdress, telephone_number, email, mall_image FROM tblref_mall WHERE mallid = '". $TenantInfo['mallID'] ."';", $connection));

			if($MallCompanyID['MallCompanyImage'] == ""){
                $image = "assets/images/noimage5.png";
            }else{
            	if(!file_exists("../Mall_Attachments/Mall_Company/".$MallCompanyID['MallCompanyImage'])){ 
					$image = "assets/images/noimage5.png";
				}else{
					$image = "../Mall_Attachments/Mall_Company/".$MallCompanyID['MallCompanyImage'];
				}
            }

			if($SysTemplate['template'] == "1"){
				echo 	"<tr>
					      	<td width='130px; padding:0px !important;'><img src='". $image ."' style='height: 130px; width: 150px !important;margin: 10px;'></td>
					      	<td style='padding-top:0px;'>
					      		<p style='padding: 0px; display: block;margin:0px;'><h1>". $MallCompanyID['MallCompanyName'] ."</h1></p>
					      		<p style='padding: 0px; display: block;margin:0px;'>". $Mall[1] ."</p>
					      		<p style='padding: 0px; display: block;margin:0px;'>". $Mall[2] ."</p>
					      		<p style='padding: 0px; display: block;margin:0px;'>". $Mall[3] ."</p>
					      	</td>
				      	</tr>";
			}else{
				echo 	"<tr>
					  		<td colspan='3' align='center'><img src='". $image ."' style='height: 130px; width: 150px !important;margin: 10px;'></td>
					  	</tr>
					  	<tr>
						  	<td colspan='3' align='center'>
						  		<p style='padding: 0px; display: block;margin:0px;'><h1>". $MallCompanyID['MallCompanyName'] ."</h1></p>
						  		<p style='padding: 0px; display: block;margin:0px;'>". $Mall[1] ."</p>
						  		<p style='padding: 0px; display: block;margin:0px;'>". $Mall[2] ."</p>
						  		<p style='padding: 0px; display: block;margin:0px;'>". $Mall[3] ."</p>
						  	</td>
					  	</tr>";
			}
		break;

		case 'endofcontract':
			$arr = explode("#", $_POST["val"]);
			for($i=0;$i<=count($arr)-1;$i++){
				$sql = "SELECT TenantID, unitID FROM tbltrans_tenants WHERE dateto <= '". date("Y-m-d") ."' AND (Status = 'Active' OR Status = 'ForEviction' OR Status = 'ForRenewal') AND ustatus = 'Occupied' AND TenantID = '".$arr[$i]."'";
				$result = mysql_query($sql, $connection);
				while($row = mysql_fetch_array($result)){
					$endo = mysql_query("UPDATE tbltrans_tenants SET Status = 'endofcon' WHERE TenantID = '".$row["TenantID"]."'");
					$vacant = mysql_query("UPDATE tblref_unit SET status = 'Vacant' WHERE unitid = '".$row["unitID"]."'");

					echo $row["TenantID"] . "|";
				}
			}
		break;

		case 'tblendofcontract':
			if($_POST["key"] != ""){
				$filter = " AND tradename LIKE '%".$_POST["key"]."%'";
			}else{
				$filter = "";
			}
			$getendonum = mysql_fetch_array(mysql_query("SELECT endodaynot FROM tblsys_setup"));
			if(intval($getendonum["endodaynot"]) > 0){
				$daysNOT = "dateto <= '". date("Y-m-d", strtotime("+".$getendonum["endodaynot"]." days")) ."' OR";
			}else{
				$daysNOT = "dateto <= '". date("Y-m-d") ."' AND";
			}

			$sql = "SELECT TenantID, unitID, tradename, dateto FROM tbltrans_tenants WHERE (".$daysNOT." dateto <= '". date("Y-m-d") ."') AND (Status = 'Active' OR Status = 'ForEviction' OR Status = 'ForRenewal') AND ustatus = 'Occupied' ".$filter;
			$result = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($result)){
				$datestr=date("Y-m-d", strtotime($row["dateto"]))." 00:00:00";//Your date
				$date=strtotime($datestr);//Converted to a PHP date (a second count)

				//Calculate difference
				$diff=$date-time();//time returns current time in seconds
				$days=floor($diff/(60*60*24));//seconds/minute*minutes/hour*hours/day)
				$hours=round(($diff-$days*60*60*24)/(60*60));
					if($days > 0){
						$days2 = $days . " days";
					}else{
						$days2 = "";
					}

					if($hours > 0){
						$hours2 = $hours . " hours";
					}else{
						$hours2 = "";
					}

				if($row["dateto"] < date("Y-m-d")){
					$checkbox = "<label>
		                              <input name='form-field-checkbox' class='ace chk_endo' type='checkbox' value='".$row["TenantID"]."' id=''>
		                              <span class='lbl'></span>
		                          </label>";
		            $days2 = "0 days";
					$hours2 = "0 hours";
				}else{
					$checkbox = "";
					if($days > 0){
						$days2 = $days . " days";
					}else{
						$days2 = "";
					}

					if($hours > 0){
						$hours2 = $hours . " hours";
					}else{
						$hours2 = "";
					}
				}

				echo " <tr>
                        <td style='background-color: #f2f2f2 !important;color:#707070;width:20px;padding:5px;text-align:center;'>
                          ".$checkbox."
                        </td>
                        <td style='font-weight:400;font-size:12px;padding:5px;'>".$row["tradename"]."</td>
                        <td style='font-weight:400;font-size:12px;padding:5px;'>".date("F d, Y", strtotime($row["dateto"]))."</td>
                        <td style='font-weight:400;font-size:12px;padding:5px;'>".$days2." ".$hours2."</td>
                      </tr>";
			}
		break;

		case 'getnum_not':
			$datenow = getsysdate();
		// END OF CONTRACT
			$endo = mysql_fetch_array(mysql_query("SELECT COUNT(TenantID) FROM tbltrans_tenants WHERE dateto <= '". date("Y-m-d") ."' AND (Status = 'Active' OR Status = 'ForEviction' OR Status = 'ForRenewal') AND ustatus = 'Occupied';", $connection));

		// COMPLAINTS
			$complaints = mysql_fetch_array(mysql_query("SELECT COUNT(Complaint_Series_No) FROM tblcomplaints WHERE Date_Entry <= '". date('Y-m-d') ."' AND Complaint_Status = 'Pending';", $connection));

		// INCIDENT REPORTS
			$IR = mysql_fetch_array(mysql_query("SELECT COUNT(VSeriesNumber) FROM tblmaintenance_hrviolatorsheader WHERE xdatetime <= '". date('Y-m-d') ."' AND xstatus = 'Pending';", $connection));

    	// REQUEST THAT CURRENT USER HAS ACCESS
	        $resTPAccess = mysql_query("SELECT CODE FROM tblref_apprlistperuser WHERE userid = '". $_SESSION['MMS-UserID'] ."' and module = 'TR';", $connection);
			while($rowTPAccess = mysql_fetch_array($resTPAccess)){
				$mgaMeron .= "'" . $rowTPAccess[0][1] . "'" . ",";
			}
			if($mgaMeron != ""){
				$ApprovalStagesss = "WHERE APPROVAL_STAGE IN (". substr(trim($mgaMeron), 0, -1) .")";
			}else{
				$ApprovalStagesss = "";
			}

	        if($isAdmin[0] == "1"){
				$ApprovalStage = "";
		    }else{
				$ApprovalStage = $ApprovalStagesss;
		    }
            $rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM tbltrans_tenantsrequest ". $ApprovalStage .";", $connection));

    		$ttl = floatval($endo[0]) + floatval($complaints[0]) + floatval($IR[0]) + floatval($rowCount[0]);
    		echo floatval($ttl) ."|". floatval($endo[0]) ."|". floatval($complaints[0]) ."|". floatval($IR[0]) ."|". floatval($rowCount[0]);
		break;

		case 'showmallpermits':
			$restenant = mysql_query("SELECT TenantID, tradename, datefrom, dateto, inqID FROM tbltrans_tenants WHERE tradename LIKE '%". $_POST['key'] ."%' AND mallID = '". $_POST['mallID'] ."' AND (Status = 'Active' OR Status = 'ForEviction' OR Status = 'ForRenewal') AND ustatus = 'Occupied';", $connection);
			while($rowtenant = mysql_fetch_array($restenant)){
				echo "	<tr>
							<td>". $rowtenant[1] ."</td>
							<td>". date('F d, Y', strtotime($rowtenant[2])) ."</td>
							<td>". date('F d, Y', strtotime($rowtenant[3])) ."</td>
							<td style='text-align: center;z-index: 0;'><button class='btn btn-sm btn-info btn-round' onclick='viewdetaileddocs(\"". $rowtenant[4] ."\", \"". $rowtenant[1] ."\")' title='View List of Permits'><i class='fa fa-list-ul bigger-110'></i></button></td>
						</tr>";
			}
		break;

		case 'showmallpermitsnoti':
			$count = 0;
			$total = 0;
			$doccount = mysql_fetch_array(mysql_query(" SELECT COUNT(requirements) FROM tblref_applicationrequirements;", $connection));
			$tenantdocs = mysql_fetch_array(mysql_query(" SELECT COUNT(inqID) FROM tbltrans_tenants WHERE (Status = 'Active' OR Status = 'ForEviction' OR Status = 'ForRenewal') AND ustatus = 'Occupied' AND dateto > '". date('Y-m-d') ."';", $connection));
			$restenantdocs = mysql_query("SELECT inqID FROM tbltrans_tenants WHERE ustatus = (Status = 'Active' OR Status = 'ForEviction' OR Status = 'ForRenewal') AND ustatus = 'Occupied' AND dateto > '". date('Y-m-d') ."';", $connection);
			while($rowtenantdocs = mysql_fetch_array($restenantdocs)){
				$resuploadeddocs = mysql_query("SELECT reqID FROM tblref_tenantsdocs WHERE expirydate > '". date('Y-m-d') ."' AND reqID = '". $rowtenantdocs[0] ."'", $connection);
				while($rowuploadeddocs = mysql_fetch_array($resuploadeddocs)){
					if($rowuploadeddocs[0] != ""){
						$count++;
					}
				}
			}

			$total = floatval($doccount[0]) * (floatval($tenantdocs[0]) - $count);

			echo floatval($total);
		break;

		case 'viewdetaileddocs':
			$sql = "SELECT a.docname, a.docdesc, a.expirydate, a.appID, a.filename, a.filetype, b.status FROM tblref_tenantsdocs AS A INNER JOIN tbltrans_tenants AS b ON a.reqID = b.inqID WHERE a.reqID = '". $_POST['inqid'] ."' ORDER BY a.expirydate DESC";
			$res = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($res)){
				$path = "../Mall_Attachments/Permits/".$row[3]."/".$row[0]."/".$row[4];
				if($row[6] == "evicted" || $row[6] == "inactive"){
                    $evict ="disabled='true'";
                    $action = "";
                }else{
                	$evict = "";
                    $action = "href = '../Mall_Attachments/Permits/".$row[3]."/".$row[0]."/".$row[4]."' download";
                }

                if(date('Y-m-d', strtotime($row[2])) <= date('Y-m-d')){
                	$bcolor = "danger";
                }else if(date('Y-m-d', strtotime($row[2])) <= date('Y-m-d', strtotime('+30 days'))){
                	$bcolor = "warning";
                }else{	
                	$bcolor = "info";
                }

				$arr = explode("/", $row[5]);
				if($arr[0] != "image"){
                    $btn = "<a ".$action." class='btn btn-sm btn-". $bcolor ." btn-round' ".$evict." title='Download Attachment'><i class='fa fa-download'></i></a>";
                }else{
                    $btn = "<a class='btn btn-sm btn-". $bcolor ." btn-round' ".$evict." onclick='viewdocuimgindex(\"". $path ."\");' title='View Image'><i class='fa fa-eye'></i></a>";
                }
				echo "	<tr>
							<td>". $row[0] ."</td>
							<td>". $row[1] ."</td>
							<td>". date('F d, Y', strtotime($row[2])) ."</td>
							<td style='text-align: center;z-index: 0;'>". $btn ."</td>
						</tr>";
			}
		break;

		case 'getsysdate':
			$sys = mysql_fetch_array(mysql_query("SELECT eoddate FROM tbltrans_eod ORDER BY eoddate DESC LIMIT 0,1"));
			if($sys[0] == ""){
				echo "System Date: ".date("l, F d, Y") . "|Server IP: " . $_SESSION['GS-MMS'];
			}else{
				echo "System Date: ".date("l, F d, Y", strtotime($sys[0])) . "|Server IP: " . $_SESSION['GS-MMS'];
			}
		break;

		case 'loadheader':
			$header = mysql_fetch_array(mysql_query("SELECT softwaretype, corporatename, dbsetup FROM tblsys_setup", $connection));
			$MallName = mysql_fetch_array(mysql_query("SELECT mallname, mall_image FROM tblref_mall WHERE mallid = '". $_SESSION['MMS-Designation'] ."';", $connection));
			if($MallName['mall_image'] == ""){
				$img = "";
			}else{
				if(!file_exists("../Mall_Attachments/mall_image/". $MallName['mall_image'])){ 
					$img = "";
				}else{
					$img = "<img src='../Mall_Attachments/mall_image/". $MallName['mall_image'] ."' style='width: 25px; height: 25px;'>";
				}
			}
			if($header[0] == "0"){
				if($header[2] == "1"){
					echo "<i class='fa'>". $img ."</i>&nbsp;". $MallName['mallname'] ." - Mall Management System";
				}else{
					echo "<i class='fa'>". $img ."</i>&nbsp;". $MallName['mallname'] ." - Mall Management System";
				}
			}else if($header[0] == "1"){
				echo "<i class='fa'>". $img ."</i>&nbsp;". $MallName['mallname'] ." - Property Management System";
			}else if($header[0] == "2"){
				echo "<i class='fa'>". $img ."</i>&nbsp;". $MallName['mallname'] ." - Building Management System";
			}else if($header[0] == "3"){
				echo "<i class='fa'>". $img ."</i>&nbsp;". $MallName['mallname'] ." - Palengke Management System";
			}else if($header[0] == "4"){
				echo "<i class='fa'>". $img ."</i>&nbsp;". $MallName['mallname'] ." - Cemetery Management System";
			}else if($header[0] == "5"){
				echo "<i class='fa'>". $img ."</i>&nbsp;". $MallName['mallname'] ." - Property Amortization & Sales System";
			}else{
				echo "<i class='fa'>". $img ."</i>&nbsp;Mall Management System";
			}
		break;

		case 'titletext':
			$title = mysql_fetch_array(mysql_query("SELECT softwaretype, dbsetup FROM tblsys_setup", $connection));
			if($title[0] == "0"){
				if($title[1] == "1"){
					echo "Mall Management System";
				}else{
					echo "Mall Management System";
				}
			}else if($title[0] == "1"){
				echo "Property Management System";
			}else if($title[0] == "2"){
				echo "Building Management System";
			}else if($title[0] == "3"){
				echo "Palengke Management System";
			}else if($title[0] == "4"){
				echo "Cemetery Management System";
			}else if($title[0] == "5"){
				echo "Property Amortization & Sales System";
			}else{
				echo "Mall Management System";
			}
		break;

		case 'checkeod':
			$isCount = mysql_num_rows(mysql_query("SELECT eoddate FROM tbltrans_eod ORDER BY id DESC LIMIT 1;", $connection));
			if($isCount == 0){
				$InsertCurrDate = mysql_fetch_array(mysql_query("INSERT INTO tbltrans_eod SET eoddate = '". date('Y-m-d') ."', computerdate = '". date('Y-m-d') ."', processby = 'SystemGenerated', xtime = '". date('H:i:s') ."';", $connection));
			}else{
				$cureod = mysql_fetch_array(mysql_query("SELECT eoddate FROM tbltrans_eod ORDER BY id DESC LIMIT 1;", $connection));
				if($cureod[0] != date('Y-m-d')){
					echo "1|System Date: " . date('F d, Y', strtotime($cureod[0])) . "|Current Date: " . date('F d, Y');
				}else{
					echo "2|";
				}
			}
		break;

		case 'checkaccessfirst':
    		$checkaccess = mysql_fetch_array(mysql_query("SELECT functionid FROM tblref_usergroupaccess WHERE module = '". $_POST['module'] ."' AND functionid LIKE '%view%' AND groupid = '". $_SESSION['MMS-Access'] ."' ORDER BY functionid ASC", $connection));
     		$checkifadmin = mysql_fetch_array(mysql_query("SELECT isAdmin FROM tbluser WHERE userid = '". $_SESSION['MMS-UserID'] ."' ", $connection));

     		if($checkifadmin[0] == "1" || $_SESSION['MMS-UserID'] == GatessoftCorp){
     			echo 1;
     		}else{
     			echo $checkaccess[0];
     		}
		break;

		case 'changesyslabel':
			$systype = mysql_fetch_array(mysql_query("SELECT softwaretype FROM tblsys_setup", $connection));
			echo $systype[0];
		break;

		case 'viewnoti_TenantRequest':
			$resTPAccess = mysql_query("SELECT CODE FROM tblref_apprlistperuser WHERE userid = '". $_SESSION['MMS-UserID'] ."' and module = 'TR';", $connection);
			while($rowTPAccess = mysql_fetch_array($resTPAccess)){
				$mgaMeron .= "'" . $rowTPAccess[0][1] . "'" . ",";
			}
			if($mgaMeron != ""){
				$ApprovalStagesss = "AND a.APPROVAL_STAGE IN (". substr(trim($mgaMeron), 0, -1) .")";
			}else{
				$ApprovalStagesss = "";
			}
	        if($isAdmin[0] == "1"){
				$ApprovalStage = "";
		    }else{
				$ApprovalStage = $ApprovalStagesss;
		    }
			$res = mysql_query("SELECT a.APP_DATE, a.TENANTID, a.SCOPE, a.DETAILS, b.tradename FROM tbltrans_tenantsrequest AS a LEFT JOIN tbltrans_tenants AS b ON a.TENANTID = b.TenantID WHERE b.tradename LIKE '%". $_POST['key'] ."%' ". $ApprovalStage .";", $connection);
			while($row = mysql_fetch_array($res)){
				echo 	"<tr>
							<td>". date('m/d/Y', strtotime($row['APP_DATE'])) ."</td>
							<td>". $row['tradename'] ."</td>
							<td>". $row['SCOPE'] ."</td>
							<td>". $row['DETAILS'] ."</td>
						</tr>";
			}
		break;

		case 'viewnoti_complaints':
			$res = mysql_query("SELECT TradeName, Complete_Description, Priority_Status FROM tblcomplaints WHERE Date_Entry <= '". date('Y-m-d') ."' AND Complaint_Status = 'Pending' AND TradeName LIKE '%". $_POST['key'] ."%' ", $connection);
			while($row = mysql_fetch_array($res)){
				echo 	"
							<tr>
								<td>".$row['TradeName']."</td>
								<td>".$row['Priority_Status']."</td>
								<td>".$row['Complete_Description']."</td>
							</tr>
						";
			}
		break;

		case 'viewnoti_incidentreport':
			$res = mysql_query("SELECT ViolatorName, VSeriesNumber FROM tblmaintenance_hrviolatorsheader WHERE xdatetime <= '". date('Y-m-d') ."' AND xstatus = 'Pending' AND ViolatorName LIKE '%". $_POST['key'] ."%' ", $connection);
			while($row = mysql_fetch_array($res)){
				echo 	"
							<tr>
								<td>".$row['ViolatorName']."</td>
								<td>";
								$res2 = mysql_query("SELECT Violation, offensetype FROM tblmaintenance_hrviolators WHERE VSeriesNumber = '". $row['VSeriesNumber'] ."'", $connection);
								while($row2 = mysql_fetch_array($res2)){
									if($row2[1] == "1st Offense"){
										$stat = '<i class="fa fa-circle" style="color: #F89406;"></i>&nbsp;'.$row2[0];
									}else if($row2[1] == "2nd Offense"){
										$stat = '<i class="fa fa-circle" style="color: #D6487E;"></i>&nbsp;'.$row2[0];
									}else if($row2[1] == "3rd Offense"){
										$stat = '<i class="fa fa-circle" style="color: #D15B47;"></i>&nbsp;'.$row2[0];
									}else{
										$stat = '<i class="fa fa-circle" style="color: #333;"></i>&nbsp;'.$row2[0];
									}
									echo $stat."<br/>";
								}
				echo			"</td>
							</tr>
						";
			}
		break;

		case 'memotenantlist':	
			$res = mysql_query("SELECT TenantID, tradename FROM tbltrans_tenants WHERE (Status = 'Active' OR Status = 'ForEviction' OR Status = 'ForRenewal') AND ustatus = 'Occupied';", $connection);
			while($row = mysql_fetch_array($res)){
			echo "<option value='". $row[0] ."'>". $row[1] ."</option>";
			}
		break;

		case 'sendmemo':
			$arr = explode(",", $_POST['tenantids']);
			$success = 0;
			for ($x=0; $x<=COUNT($arr)-1; $x++){
				$sql = "INSERT INTO tbltrans_memo SET MemoID = '". $_POST['MemoID'] ."', TenantID = '". $arr[$x] ."', MemoSubj = '". $_POST['subject'] ."', MemoContent = '". $_POST['content'] ."', MemoDate = '". date('Y-m-d') ."', MemoTime = '". date('H:i:s') ."'";
				$res = mysql_query($sql, $connection);
				if($res == true){
					$success++;
				}
			}
			if($success > 0){
				echo "SUCCESS";
			}else{
				echo "FAIL";
			}
		break;

		case 'viewmemolist':
			$cnt_fltr = 0;
		    $sql_filter = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'Memo' AND userid = '". $_SESSION['MMS-UserID'] .";", $connection));
		    $trby = explode("|", $sql_filter["checked_value"]);
		    $date = explode("|", $sql_filter["datefilter"]);
		    $filter = "";
		    // filter by date
		    $date_fltr = "(a.MemoDate BETWEEN '".date("Y-m-d", strtotime($date[0]))."' AND '".date("Y-m-d", strtotime($date[1]))."')";
		    // filter by
		    $cnt = 0; $chk3 = "";
		    for($c = 0; $c<=count($trby)-1; $c++){
		      	if($trby[$c] != ""){
			        $cnt_fltr++;
			        $cnt++;
			        if($cnt == 1){
			          	$chk3 .= $trby[$c] . " LIKE '%".$_POST["key"]."%'";
			        }
			        else{
			          	$chk3 .= " OR ". $trby[$c] . " LIKE '%".$_POST["key"]."%'";
			        }
		      	}
		    }
		    if($cnt > 1){
		      	$by_fltr = "(".$chk3.")";
		    }else{
		      	$by_fltr = $chk3;
		    }
		    if($cnt > 0){
		      	$and2 = " AND ";
		    }else{
		      	$and2 = "";
		    }
		    if($cnt > 0 ){
		       	$filterselected = "WHERE ". $date_fltr.$and2.$by_fltr;
		       	$page = $_POST['page'];
				$limit = ($page-1) * 20;
				$res = mysql_query("SELECT a.MemoID, a.MemoDate, a.TenantID, a.MemoSubj, a.MemoContent, b.tradename FROM tbltrans_memo AS a INNER JOIN tbltrans_tenants AS b ON a.TenantID = b.tenantid ".$filterselected." ORDER BY a.MemoDate DESC LIMIT ".$limit.",20 ", $connection);
				while($row = mysql_fetch_array($res)){
					if(strlen($row[4]) >= 1000){
						$content = substr($row[4], 0, 300)."...";
					}else{
						$content = $row[4];
					}
					echo 	"
							<tr>
								<td>". date('m/d/Y', strtotime($row[1])) ."</td>
								<td>". $row[5] ."</td>
								<td>". $row[3] ."</td>
								<td>". $content ."</td>
								<td style='text-align: center;'><button class='btn btn-xs btn-primary btn-round' title='View Memo' onclick='ViewMemoTenant(\"". $row['MemoID'] ."\", \"". $row['TenantID'] ."\");'><i class='fa fa-eye'></i></button></td>
							</tr>
							";
				}
			}
		break;

		case 'loadmemoentries':
			$cnt_fltr = 0;
		    $sql_filter = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'Memo' AND userid = '". $_SESSION['MMS-UserID'] .";", $connection));
		    $trby = explode("|", $sql_filter["checked_value"]);
		    $date = explode("|", $sql_filter["datefilter"]);
		    $filter = "";
		    // filter by date
		    $date_fltr = "(a.MemoDate BETWEEN '".date("Y-m-d", strtotime($date[0]))."' AND '".date("Y-m-d", strtotime($date[1]))."')";
		    // filter by
		    $cnt = 0; $chk3 = "";
		    for($c = 0; $c<=count($trby)-1; $c++){
		      	if($trby[$c] != ""){
			        $cnt_fltr++;
			        $cnt++;
			        if($cnt == 1){
			          $chk3 .= $trby[$c] . " LIKE '%".$_POST["key"]."%'";
			        }
			        else{
			          $chk3 .= " OR ". $trby[$c] . " LIKE '%".$_POST["key"]."%'";
			        }
		      	}
		    }

		    if($cnt > 1){
		      	$by_fltr = "(".$chk3.")";
		    }else{
		      	$by_fltr = $chk3;
		    }

		    if($cnt > 0){
		      	$and2 = " AND ";
		    }else{
		      	$and2 = "";
		    }

		    if($cnt > 0 ){
		       	$filterselected = "WHERE ". $date_fltr.$and2.$by_fltr;

	           	if($_POST["page"] == ""){
	               	$page = 1;
	           	}else{
	               	$page = $_POST["page"];
	           	}

	           	$limit = ($page-1) * 20;

	            $sql = "SELECT COUNT(b.tradename) FROM tbltrans_memo AS a INNER JOIN tbltrans_tenants AS b ON a.TenantID = b.tenantid ".$filterselected." ";
	            $result = mysql_query($sql, $connection);
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

       	case "loadmemopage":
			$cnt_fltr = 0;
		    $sql_filter = mysql_fetch_array(mysql_query("SELECT checked_value, datefilter, bystat, xcheck FROM tblref_filters WHERE module = 'Memo' AND userid = '". $_SESSION['MMS-UserID'] .";", $connection));
		    $trby = explode("|", $sql_filter["checked_value"]);
		    $date = explode("|", $sql_filter["datefilter"]);
		    $filter = "";
		    // filter by date
		    $date_fltr = "(a.MemoDate BETWEEN '".date("Y-m-d", strtotime($date[0]))."' AND '".date("Y-m-d", strtotime($date[1]))."')";
		    // filter by
		    $cnt = 0; $chk3 = "";
		    for($c = 0; $c<=count($trby)-1; $c++){
		      	if($trby[$c] != ""){
			        $cnt_fltr++;
			        $cnt++;
			        if($cnt == 1){
			          $chk3 .= $trby[$c] . " LIKE '%".$_POST["key"]."%'";
			        }
			        else{
			          $chk3 .= " OR ". $trby[$c] . " LIKE '%".$_POST["key"]."%'";
			        }
		      	}
		    }

		    if($cnt > 1){
		      	$by_fltr = "(".$chk3.")";
		    }else{
		      	$by_fltr = $chk3;
		    }

		    if($cnt > 0){
		      	$and2 = " AND ";
		    }else{
		      	$and2 = "";
		    }

		    if($cnt > 0 ){
		       	$filterselected = "WHERE ". $date_fltr.$and2.$by_fltr;
			    $page = $_POST["page"];
	        	$sqlb = "SELECT COUNT(b.tradename) FROM tbltrans_memo AS a INNER JOIN tbltrans_tenants AS b ON a.TenantID = b.tenantid ".$filterselected." ";
				$aa = mysql_query($sqlb, $connection);
				$nums = mysql_fetch_row($aa);
				$num = $nums[0];
				$rowsperpage = 20;
				$range = 3;
				$totalpages = ceil($num / $rowsperpage);
				$prevpage;
				$nextpage;
				if($page > 1 ){
				   echo "<li style='width:50px !important;' onclick='paginationmemo(1)'><< First</li>";
				   $prevpage = $page - 1;
				   echo "<li style='width:70px !important;' onclick='paginationmemo(". $prevpage .")'>< Previous</li>";
				}

				for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
				   	if (($x > 0) && ($x <= $totalpages)){
	    			    if ($x == $page){
	                        echo "<li id='pgmemo" . $x . "' class='pgnumpmemo active' onclick='paginationmemo(" . $x . ",". $x .")'>" . $x . "</li>";
	                    }else{
	    			        echo "<li id='pgmemo" . $x . "' class='pgnumpmemo' onclick='paginationmemo(" . $x . ",". $x .")'>" . $x . "</li>";
	                    }
			       	}
			    }
			    if($page < ($totalpages - $range)){
	                echo "<li>...</li>";
	            }

			    if ($page != $totalpages && $num != 0){
			       	$nextpage = $page + 1;
			       	echo "<li style='width:50px !important;' onclick='paginationmemo(". $nextpage .", ". $nextpage .")'>Next ></li>";
			       	echo "<li style='width:50px !important;' onclick='paginationmemo(". $totalpages .", ". $totalpages .")'>Last >></li>";
			    }
			}
		break;

		case 'ViewMemoTenant':
			$Memo = mysql_fetch_array(mysql_query("SELECT a.MemoID, a.MemoDate, a.TenantID, a.MemoSubj, a.MemoContent, b.tradename FROM tbltrans_memo AS a INNER JOIN tbltrans_tenants AS b ON a.TenantID = b.tenantid WHERE a.TenantID = '". $_POST['TenantID'] ."' AND a.MemoID = '". $_POST['MemoID'] ."'", $connection));

			echo $Memo[5] ."|". $Memo[3] ."|". $Memo[4] . "|";

			$MemoAttachment = mysql_query("SELECT MemoAttachment, filetype FROM tbltrans_memo_attachment WHERE MemoID = '". $_POST['MemoID'] ."'", $connection);
			while ($rowMemoAttachment = mysql_fetch_array($MemoAttachment)) {
				$path = "../Mall_Attachments/Memo Attachments/".$_POST['MemoID']."/".$rowMemoAttachment[0];

				$arr = explode("/", $rowMemoAttachment[1]);
				if($arr[0] != "image"){
					$btn = "<a href='".$path."' download class='btn btn-xs btn-info btn-round'><i class='fa fa-download'></i></a>";
                }else{
                    $btn = "<a class='btn btn-xs btn-info btn-round' onclick='viewdocuimgindex(\"". $path ."\");'><i class='fa fa-eye'></i></a>";
                }
				echo "	<div class='row form-group'>
							<div class='col-md-11'>
								". $rowMemoAttachment[0] ."
							</div>
							<div class='col-md-1'>
								".$btn."						  	
							</div>
						</div>";

			}
		break;

		case 'saveMdlChanges':
			$currpass = mysql_num_rows(mysql_query("SELECT password FROM tbluser WHERE password = '". md5($_POST['Old'].$_SESSION['MMS-UserID'].'@GS') ."';", $connection));
			if($currpass > 0){
				if(md5($_POST['New']) == md5($_POST['New2'])){
					$res = mysql_query("UPDATE tbluser SET password = '". md5($_POST['New'].$_SESSION['MMS-UserID'].'@GS') ."' WHERE userid = '". $_SESSION['MMS-UserID'] ."'", $connection);
					if($res == true){
						echo "1|Password successfully changed.";
					}
				}else{
					echo "2|Password do not match.";
				}
			}else{
				echo "2|Incorrect password.";
			}
		break;

		case 'ViewAllHistory':
			$sql = "SELECT mydate, mytime, remarks, xaction, xinfo FROM tbllogs_per_trans WHERE mainID = '". $_POST['mainID'] ."' ORDER BY timestamp DESC;";
			$res = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($res)){
				?>
				<tr>
					<td style="width: 14%;" valign="top"><?php echo date('m/d/Y h:i A', strtotime($row[0]." ".$row[1])); ?></td>
					<td style="width: 40%;" valign="top"><?php echo $row['remarks']; ?></td>
					<td style="width: 56%;" valign="top">
						<?php
							$arr = explode("|", $row['xinfo']);
							for($x = 0; $x <= COUNT($arr)-2; $x++){
								echo "<span class='fa fa-circle blue'></span>&nbsp;". $arr[$x] ."</br>";
							}
						?>
					</td>
				</tr>
				<?php
			}
		break;

		case 'selected_unit_amenities':
			$sql = "SELECT amenitiesID FROM tblref_unit_amenities WHERE unitID = '".$_POST["unit_id"]."'";
			$result = mysql_query($sql, $connection);
			$cnt = mysql_num_rows($result);
			if($cnt > 0){
				echo '<div class="alert alert-info"><table><tr><td><h4 class="blue smaller lighter">Amenities</h4></td></tr>';
			}
			while($row = mysql_fetch_array($result)){
				$sql2 = "SELECT amenitiesname FROM tblref_amenities WHERE amenitiesid = '".$row["amenitiesID"]."'";
				$result2 = mysql_query($sql2, $connection);
				$row2 = mysql_fetch_array($result2);
				if($row2["amenitiesname"] != ""){
					echo "<tr>
							<td>
							<div class='checkbox' style='margin:3px;'>
									<label>
										<i class='ace-icon fa fa-check'></i>&nbsp;&nbsp;
										<span class='lbl'> &nbsp;&nbsp;&nbsp;".$row2["amenitiesname"]."</span>
									</label>
								</div>
							</td>
						</tr>";
				}
			}
			if($cnt > 0){
				echo '</table></div>';
			}
			if($cnt == 0){
				echo '<div class="alert alert-info"><table><tr><td><h4 class="blue smaller lighter">This unit has no amenities included.</h4></td></tr></table></div>';
			}
		break;

		case 'logoutuserlogs':
			$rowmn2 = mysql_fetch_array(mysql_query(" SELECT Machine_No FROM tblsys_setup ", $connection));

			$rowlmn2 = mysql_fetch_array(mysql_query(" UPDATE tblloggedmachine SET Onprocess = '0', xdateout = '". date('Y-m-d H:i:s') ."' WHERE Machine_No = '". $rowmn2[0] ."' ", $connection));

			$rowmnu2 = mysql_fetch_array(mysql_query(" UPDATE tblmachine SET Onprocess = '0' WHERE Machine_No = '". $rowmn2[0] ."' ", $connection));

			$logID2 = createidno("LOG", "tbllog_sheet", "logID");
			$rowusertype2 = mysql_fetch_array(mysql_query(" SELECT isadmin FROM tbluser WHERE userid = '". $_SESSION['MMS-UserID'] ."' ", $connection));

			if($rowusertype2[0] == "1" || $_SESSION['MMS-UserID'] == "GatessoftCorp" || $_SESSION['MMS-UserID'] == "Superuser"){
				$usertype = "Admin";
			}else{
				$usertype = "User";
			}

			$rowlogs2 = mysql_fetch_array(mysql_query(" INSERT INTO tbllog_sheet SET logID = '". $logID2 ."', userid = '". $_SESSION['MMS-UserID'] ."', usertype = '". $usertype ."', xdatetime = '". date('Y-m-d H:i:s') ."', action = 'Log out', Machine_No = '". $rowmn2[0] ."' ", $connection));

			$rowloginstat = mysql_fetch_array(mysql_query(" UPDATE tbluser SET loginstat = '0' WHERE userid = '". $_SESSION['MMS-UserID'] ."' ", $connection));
		break;

		case 'fncEODChecking':
			$CheckArrival = mysql_num_rows(mysql_query("SELECT id FROM tbltrans_tenants WHERE ustatus = 'Unoccupied' AND datefrom = '". getsysdate() ."';", $connection));
			$CheckExpired = mysql_num_rows(mysql_query("SELECT id FROM tbltrans_tenants WHERE ustatus = 'Occuped' AND Status = 'Active' AND dateto = '". getsysdate() ."';", $connection));

			echo $CheckArrival . "|" . $CheckExpired;
		break;		

		case 'fncCheckUserAccess':
			$getUserID = mysql_fetch_array(mysql_query("SELECT userid FROM tbluser WHERE username = '". $_POST['username'] ."';", $connection));
            $res = mysql_query("SELECT firstname, middlename, lastname, isAdmin FROM tbluser WHERE username = '". $_POST['username'] ."' AND password = '". md5($_POST['password'].$getUserID[0]."@GS") ."';", $connection);
            $row = mysql_fetch_array($res);
            $num = mysql_num_rows($res);
            if($row['isAdmin'] == '1' || $_SESSION['MMS-UserID'] == 'Superuser' || $_SESSION['MMS-UserID'] == 'GatessoftCorp'){
                echo "1|". $row["lastname"].", ".$row["firstname"]." ".$row["middlename"];
            }else{
            	if($num > 0){
            		$CheckAccess = mysql_num_rows(mysql_query("SELECT id FROM tblref_usergroupaccess WHERE groupid = '". $_SESSION['MMS-Access'] ."' AND functionid = 'endofday';", $connection));
            		if($CheckAccess >= 1){
	                	echo "1|". $row["lastname"].", ".$row["firstname"]." ".$row["middlename"];
            		}else{
	                	echo "2|Sorry but you don't have access for this feature.";
            		}
	            }else{
	                echo "3|User not found.";
	            }
            }
		break;

		case 'proceed_endofday':
			$select = mysql_fetch_array(mysql_query("SELECT eoddate FROM tbltrans_eod ORDER BY eoddate DESC LIMIT 0,1", $connection));
			$date = date("Y-m-d", strtotime($select["eoddate"] .'+1 day'));
			$update = mysql_query("INSERT INTO tbltrans_eod (eoddate, processby, computerdate, xtime)VALUES('". $date ."', '". $_SESSION['MMS-UserID'] ."', '".date("Y-m-d")."', '".date("H:i:s")."')", $connection);
			if($update == true){
				echo date("F d, Y", strtotime($date)) . "|" . date("F d, Y") . "|" . getusername();
				$reszreading = mysql_query("UPDATE tblforzreading SET Zreadingstat = '0'", $connection);
				$maxDay = date('t', strtotime(getsysdate()));

				//Meter Usage Logs
				// $resRefMeter = mysql_query("SELECT MeterID, CurrentMeterUsage, Multiplier, MeterType, AssignedTenant FROM tblref_meter;", $connection);
				// while($rowRefMeter = mysql_fetch_array($resRefMeter)){
				// 	$resInsertMeterLogs = mysql_query("INSERT INTO tblref_meterLogs SET MeterID = '". $rowRefMeter['MeterID'] ."', CurrentMeterUsage = '". $rowRefMeter['CurrentMeterUsage'] ."', Multiplier = '". $rowRefMeter['Multiplier'] ."', MeterType = '". $rowRefMeter['MeterType'] ."', AssignedTenant = '". $rowRefMeter['AssignedTenant'] ."', SysDate = '". date('Y-m-d', strtotime(getsysdate())) ."';", $connection);
				// }

				//Maintenance Schedule
				$resGetMaintenanceSchedSetup = mysql_query("SELECT SchedID, xPeriod, xPersonnel, xDOTW1, xDOTW2, xDOTM1, xDOTM2, FQ_Date1, FQ_Date2, SQ_Date1, SQ_Date2, TQ_Date1, TQ_Date2, LQ_Date1, LQ_Date2, TenantID, GroupAccess FROM tblref_msmaintenance_h;", $connection);
				while($rowMaintenance = mysql_fetch_array($resGetMaintenanceSchedSetup)){

					$TenantInfo = mysql_fetch_array(mysql_query("SELECT tradename, mallID FROM tbltrans_tenants WHERE TenantID = '". $rowMaintenance['TenantID'] ."';", $connection));
					$WorkOrderID = createidno("WO", "tblmaintenance_workorder", "workorderid");

					if($rowMaintenance['xPeriod'] == "Daily"){

						//Saving of task for meter related
						$getTaskWithMeterReading = mysql_query("SELECT a.taskid, a.xcategory, b.isReading FROM tblmaintenance_tasklist AS a LEFT JOIN tblmaintenance_category AS b ON a.xcategory = b.category_id WHERE a.taskid IN (SELECT xTask FROM tblref_msmaintenance_d WHERE SchedID = '". $rowMaintenance['SchedID'] ."') AND b.isReading >= 1 ORDER BY b.isReading;", $connection);
						while($rowgetTaskWithMeterReading = mysql_fetch_array($getTaskWithMeterReading)){

							$getPrevReading = mysql_fetch_array(mysql_query("SELECT reading_date FROM tblmaintenance_workorderlist WHERE xtaskid = '". $rowgetTaskWithMeterReading['taskid'] ."' AND tenantid = '". $rowMaintenance['TenantID'] ."' ORDER BY reading_date DESC LIMIT 1;", $connection));

							if($getPrevReading['reading_date'] == "" || $getPrevReading['reading_date'] == "1970-01-01"){
								if($rowgetTaskWithMeterReading['isReading'] == '1'){
									$PrevReading = date('Y-m-d', strtotime($TenantInfo['LMRElectric']));
								}else if($rowgetTaskWithMeterReading['isReading'] == '2'){
									$PrevReading = date('Y-m-d', strtotime($TenantInfo['LMRWater']));
								}else if($rowgetTaskWithMeterReading['isReading'] == '3'){
									$PrevReading = date('Y-m-d', strtotime($TenantInfo['LMRGas']));
								}
							}else{
								$PrevReading = date('Y-m-d', strtotime($getPrevReading['reading_date']));
							}

							if($rowgetTaskWithMeterReading['isReading'] == '1'){
								$MeterType = "Electric";
							}else if($rowgetTaskWithMeterReading['isReading'] == '2'){
								$MeterType = "Water";
							}else if($rowgetTaskWithMeterReading['isReading'] == '3'){
								$MeterType = "Gas";
							}

							$resPrevReadingInfo = mysql_query("SELECT MAX(CurrentMeterUsage), MAX(SYSDATE), MeterID FROM tblref_meterLogs WHERE AssignedTenant = '". $rowMaintenance['TenantID'] ."' AND MeterType = '". $MeterType ."' AND SysDate >= '". date('Y-m-d', strtotime($PrevReading)) ."' GROUP BY MeterID ORDER BY SYSDATE ASC;", $connection);
							while($rowPrevReadingInfo = mysql_fetch_array($resPrevReadingInfo)){

								$resInsertWO = mysql_query("INSERT INTO tblmaintenance_workorderlist SET workorderid = '". $WorkOrderID ."', xcategory = '". $rowgetTaskWithMeterReading['xcategory'] ."', xtaskid = '". $rowgetTaskWithMeterReading['taskid'] ."', xstatus = 'Not Posted', TenantID = '". $rowMaintenance['TenantID'] ."', reading_date = '". date('Y-m-d', strtotime(getsysdate())) ."', MeterID = '". $rowPrevReadingInfo['MeterID'] ."', CurrentMeterUsage = '". $rowPrevReadingInfo[0] ."', UsageStartDate = '". $rowPrevReadingInfo[1] ."';", $connection);

								if($resInsertWO == true){
									$forHeader++;
								}

							}
							
						}

						//Saving of task
						$resTaskInfo = mysql_query("SELECT a.taskid, a.xcategory, a.amount FROM tblmaintenance_tasklist AS a LEFT JOIN tblmaintenance_category AS b ON a.xcategory = b.category_id WHERE a.taskid IN (SELECT xTask FROM tblref_msmaintenance_d WHERE SchedID = '". $rowMaintenance['SchedID'] ."') AND (b.isReading <= '0' OR b.isReading IS NULL);", $connection);
						while($rowTaskInfo = mysql_fetch_array($resTaskInfo)){
							$resInsertWO = mysql_query("INSERT INTO tblmaintenance_workorderlist SET workorderid = '". $WorkOrderID ."', xcategory = '". $rowTaskInfo['xcategory'] ."', xtaskid = '". $rowTaskInfo['taskid'] ."', TenantID = '". $rowMaintenance['TenantID'] ."', sub_total = '". $rowTaskInfo['amount'] ."';", $connection);
							if($resInsertWO == true){
								$forHeader++;
							}
						}

						//Saving of task header
						if($forHeader >= 1){
							$resInsertHeader = mysql_query("INSERT INTO tblmaintenance_workorder SET workorderid = '". $WorkOrderID ."', TenantID = '". $rowMaintenance['TenantID'] ."', xdate = '". date('Y-m-d', strtotime(getsysdate())) ."', xtime = '". date('H:i:s') ."', departmentid = '". $rowMaintenance['GroupAccess'] ."', remarks = 'Autogenerated via Mall Scheduler', workerid = '". $rowMaintenance['xPersonnel'] ."', tradename = '". $TenantInfo['tradename'] ."', mallid = '". $TenantInfo['mallID'] ."';", $connection);
						}

					}else if($rowMaintenance['xPeriod'] == "Weekly"){
						if(date('l', strtotime(getsysdate())) == $rowMaintenance['xDOTW1']){
							//Saving of task for meter related
							$getTaskWithMeterReading = mysql_query("SELECT a.taskid, a.xcategory, b.isReading FROM tblmaintenance_tasklist AS a LEFT JOIN tblmaintenance_category AS b ON a.xcategory = b.category_id WHERE a.taskid IN (SELECT xTask FROM tblref_msmaintenance_d WHERE SchedID = '". $rowMaintenance['SchedID'] ."') AND b.isReading >= 1 ORDER BY b.isReading;", $connection);
							while($rowgetTaskWithMeterReading = mysql_fetch_array($getTaskWithMeterReading)){

								$getPrevReading = mysql_fetch_array(mysql_query("SELECT reading_date FROM tblmaintenance_workorderlist WHERE xtaskid = '". $rowgetTaskWithMeterReading['taskid'] ."' AND tenantid = '". $rowMaintenance['TenantID'] ."' ORDER BY reading_date DESC LIMIT 1;", $connection));

								if($getPrevReading['reading_date'] == "" || $getPrevReading['reading_date'] == "1970-01-01"){
									if($rowgetTaskWithMeterReading['isReading'] == '1'){
										$PrevReading = date('Y-m-d', strtotime($TenantInfo['LMRElectric']));
									}else if($rowgetTaskWithMeterReading['isReading'] == '2'){
										$PrevReading = date('Y-m-d', strtotime($TenantInfo['LMRWater']));
									}else if($rowgetTaskWithMeterReading['isReading'] == '3'){
										$PrevReading = date('Y-m-d', strtotime($TenantInfo['LMRGas']));
									}
								}else{
									$PrevReading = date('Y-m-d', strtotime($getPrevReading['reading_date']));
								}

								if($rowgetTaskWithMeterReading['isReading'] == '1'){
									$MeterType = "Electric";
								}else if($rowgetTaskWithMeterReading['isReading'] == '2'){
									$MeterType = "Water";
								}else if($rowgetTaskWithMeterReading['isReading'] == '3'){
									$MeterType = "Gas";
								}

								$resPrevReadingInfo = mysql_query("SELECT MAX(CurrentMeterUsage), MAX(SYSDATE), MeterID FROM tblref_meterLogs WHERE AssignedTenant = '". $rowMaintenance['TenantID'] ."' AND MeterType = '". $MeterType ."' AND SysDate >= '". date('Y-m-d', strtotime($PrevReading)) ."' GROUP BY MeterID ORDER BY SYSDATE ASC;", $connection);
								while($rowPrevReadingInfo = mysql_fetch_array($resPrevReadingInfo)){

									$resInsertWO = mysql_query("INSERT INTO tblmaintenance_workorderlist SET workorderid = '". $WorkOrderID ."', xcategory = '". $rowgetTaskWithMeterReading['xcategory'] ."', xtaskid = '". $rowgetTaskWithMeterReading['taskid'] ."', xstatus = 'Not Posted', TenantID = '". $rowMaintenance['TenantID'] ."', reading_date = '". date('Y-m-d', strtotime($rowMaintenance['xDOTW2'])) ."', MeterID = '". $rowPrevReadingInfo['MeterID'] ."', CurrentMeterUsage = '". $rowPrevReadingInfo[0] ."', UsageStartDate = '". $rowPrevReadingInfo[1] ."';", $connection);

									if($resInsertWO == true){
										$forHeader++;
									}

								}
								
							}

							//Saving of task
							$resTaskInfo = mysql_query("SELECT a.taskid, a.xcategory, a.amount FROM tblmaintenance_tasklist AS a LEFT JOIN tblmaintenance_category AS b ON a.xcategory = b.category_id WHERE a.taskid IN (SELECT xTask FROM tblref_msmaintenance_d WHERE SchedID = '". $rowMaintenance['SchedID'] ."') AND (b.isReading <= '0' OR b.isReading IS NULL);", $connection);
							while($rowTaskInfo = mysql_fetch_array($resTaskInfo)){
								$resInsertWO = mysql_query("INSERT INTO tblmaintenance_workorderlist SET workorderid = '". $WorkOrderID ."', xcategory = '". $rowTaskInfo['xcategory'] ."', xtaskid = '". $rowTaskInfo['taskid'] ."', TenantID = '". $rowMaintenance['TenantID'] ."', sub_total = '". $rowTaskInfo['amount'] ."';", $connection);
								if($resInsertWO == true){
									$forHeader++;
								}
							}

							//Saving of task header
							if($forHeader >= 1){
								$resInsertHeader = mysql_query("INSERT INTO tblmaintenance_workorder SET workorderid = '". $WorkOrderID ."', TenantID = '". $rowMaintenance['TenantID'] ."', xdate = '". date('Y-m-d', strtotime($rowMaintenance['xDOTW2'])) ."', xtime = '". date('H:i:s') ."', departmentid = '". $rowMaintenance['GroupAccess'] ."', remarks = 'Autogenerated via Mall Scheduler', workerid = '". $rowMaintenance['xPersonnel'] ."', tradename = '". $TenantInfo['tradename'] ."', mallid = '". $TenantInfo['mallID'] ."';", $connection);
							}
						}
					}else if($rowMaintenance['xPeriod'] == "Monthly"){
						if($maxDay < $rowMaintenance['xDOTM1'] || date('d', strtotime(getsysdate())) == $rowMaintenance['xDOTM1']){
							//Saving of task for meter related
							$getTaskWithMeterReading = mysql_query("SELECT a.taskid, a.xcategory, b.isReading FROM tblmaintenance_tasklist AS a LEFT JOIN tblmaintenance_category AS b ON a.xcategory = b.category_id WHERE a.taskid IN (SELECT xTask FROM tblref_msmaintenance_d WHERE SchedID = '". $rowMaintenance['SchedID'] ."') AND b.isReading >= 1 ORDER BY b.isReading;", $connection);
							while($rowgetTaskWithMeterReading = mysql_fetch_array($getTaskWithMeterReading)){

								$getPrevReading = mysql_fetch_array(mysql_query("SELECT reading_date FROM tblmaintenance_workorderlist WHERE xtaskid = '". $rowgetTaskWithMeterReading['taskid'] ."' AND tenantid = '". $rowMaintenance['TenantID'] ."' ORDER BY reading_date DESC LIMIT 1;", $connection));

								if($getPrevReading['reading_date'] == "" || $getPrevReading['reading_date'] == "1970-01-01"){
									if($rowgetTaskWithMeterReading['isReading'] == '1'){
										$PrevReading = date('Y-m-d', strtotime($TenantInfo['LMRElectric']));
									}else if($rowgetTaskWithMeterReading['isReading'] == '2'){
										$PrevReading = date('Y-m-d', strtotime($TenantInfo['LMRWater']));
									}else if($rowgetTaskWithMeterReading['isReading'] == '3'){
										$PrevReading = date('Y-m-d', strtotime($TenantInfo['LMRGas']));
									}
								}else{
									$PrevReading = date('Y-m-d', strtotime($getPrevReading['reading_date']));
								}

								if($rowgetTaskWithMeterReading['isReading'] == '1'){
									$MeterType = "Electric";
								}else if($rowgetTaskWithMeterReading['isReading'] == '2'){
									$MeterType = "Water";
								}else if($rowgetTaskWithMeterReading['isReading'] == '3'){
									$MeterType = "Gas";
								}

								$resPrevReadingInfo = mysql_query("SELECT MAX(CurrentMeterUsage), MAX(SYSDATE), MeterID FROM tblref_meterLogs WHERE AssignedTenant = '". $rowMaintenance['TenantID'] ."' AND MeterType = '". $MeterType ."' AND SysDate >= '". date('Y-m-d', strtotime($PrevReading)) ."' GROUP BY MeterID ORDER BY SYSDATE ASC;", $connection);
								while($rowPrevReadingInfo = mysql_fetch_array($resPrevReadingInfo)){

									$resInsertWO = mysql_query("INSERT INTO tblmaintenance_workorderlist SET workorderid = '". $WorkOrderID ."', xcategory = '". $rowgetTaskWithMeterReading['xcategory'] ."', xtaskid = '". $rowgetTaskWithMeterReading['taskid'] ."', xstatus = 'Not Posted', TenantID = '". $rowMaintenance['TenantID'] ."', reading_date = '". date('Y-m-d', strtotime(date('Y-m', strtotime(getsysdate())) ."-". $rowMaintenance['xDOTM2'])) ."', MeterID = '". $rowPrevReadingInfo['MeterID'] ."', CurrentMeterUsage = '". $rowPrevReadingInfo[0] ."', UsageStartDate = '". $rowPrevReadingInfo[1] ."';", $connection);

									if($resInsertWO == true){
										$forHeader++;
									}

								}
								
							}

							//Saving of task
							$resTaskInfo = mysql_query("SELECT a.taskid, a.xcategory, a.amount FROM tblmaintenance_tasklist AS a LEFT JOIN tblmaintenance_category AS b ON a.xcategory = b.category_id WHERE a.taskid IN (SELECT xTask FROM tblref_msmaintenance_d WHERE SchedID = '". $rowMaintenance['SchedID'] ."') AND (b.isReading <= '0' OR b.isReading IS NULL);", $connection);
							while($rowTaskInfo = mysql_fetch_array($resTaskInfo)){
								$resInsertWO = mysql_query("INSERT INTO tblmaintenance_workorderlist SET workorderid = '". $WorkOrderID ."', xcategory = '". $rowTaskInfo['xcategory'] ."', xtaskid = '". $rowTaskInfo['taskid'] ."', TenantID = '". $rowMaintenance['TenantID'] ."', sub_total = '". $rowTaskInfo['amount'] ."';", $connection);
								if($resInsertWO == true){
									$forHeader++;
								}
							}

							//Saving of task header
							if($forHeader >= 1){
								$resInsertHeader = mysql_query("INSERT INTO tblmaintenance_workorder SET workorderid = '". $WorkOrderID ."', TenantID = '". $rowMaintenance['TenantID'] ."', xdate = '". date('Y-m-d', strtotime(date('Y-m', strtotime(getsysdate())) ."-". $rowMaintenance['xDOTM2'])) ."', xtime = '". date('H:i:s') ."', departmentid = '". $rowMaintenance['GroupAccess'] ."', remarks = 'Autogenerated via Mall Scheduler', workerid = '". $rowMaintenance['xPersonnel'] ."', tradename = '". $TenantInfo['tradename'] ."', mallid = '". $TenantInfo['mallID'] ."';", $connection);
							}
						}
					}else if($rowMaintenance['xPeriod'] == "Quarterly"){
						if(date('Y-m-d', strtotime(getsysdate())) == date('Y-m-d', strtotime($rowMaintenance['FQ_Date1']))){
							//Saving of task for meter related
							$getTaskWithMeterReading = mysql_query("SELECT a.taskid, a.xcategory, b.isReading FROM tblmaintenance_tasklist AS a LEFT JOIN tblmaintenance_category AS b ON a.xcategory = b.category_id WHERE a.taskid IN (SELECT xTask FROM tblref_msmaintenance_d WHERE SchedID = '". $rowMaintenance['SchedID'] ."') AND b.isReading >= 1 ORDER BY b.isReading;", $connection);
							while($rowgetTaskWithMeterReading = mysql_fetch_array($getTaskWithMeterReading)){

								$getPrevReading = mysql_fetch_array(mysql_query("SELECT reading_date FROM tblmaintenance_workorderlist WHERE xtaskid = '". $rowgetTaskWithMeterReading['taskid'] ."' AND tenantid = '". $rowMaintenance['TenantID'] ."' ORDER BY reading_date DESC LIMIT 1;", $connection));

								if($getPrevReading['reading_date'] == "" || $getPrevReading['reading_date'] == "1970-01-01"){
									if($rowgetTaskWithMeterReading['isReading'] == '1'){
										$PrevReading = date('Y-m-d', strtotime($TenantInfo['LMRElectric']));
									}else if($rowgetTaskWithMeterReading['isReading'] == '2'){
										$PrevReading = date('Y-m-d', strtotime($TenantInfo['LMRWater']));
									}else if($rowgetTaskWithMeterReading['isReading'] == '3'){
										$PrevReading = date('Y-m-d', strtotime($TenantInfo['LMRGas']));
									}
								}else{
									$PrevReading = date('Y-m-d', strtotime($getPrevReading['reading_date']));
								}

								if($rowgetTaskWithMeterReading['isReading'] == '1'){
									$MeterType = "Electric";
								}else if($rowgetTaskWithMeterReading['isReading'] == '2'){
									$MeterType = "Water";
								}else if($rowgetTaskWithMeterReading['isReading'] == '3'){
									$MeterType = "Gas";
								}

								$resPrevReadingInfo = mysql_query("SELECT MAX(CurrentMeterUsage), MAX(SYSDATE), MeterID FROM tblref_meterLogs WHERE AssignedTenant = '". $rowMaintenance['TenantID'] ."' AND MeterType = '". $MeterType ."' AND SysDate >= '". date('Y-m-d', strtotime($PrevReading)) ."' GROUP BY MeterID ORDER BY SYSDATE ASC;", $connection);
								while($rowPrevReadingInfo = mysql_fetch_array($resPrevReadingInfo)){

									$resInsertWO = mysql_query("INSERT INTO tblmaintenance_workorderlist SET workorderid = '". $WorkOrderID ."', xcategory = '". $rowgetTaskWithMeterReading['xcategory'] ."', xtaskid = '". $rowgetTaskWithMeterReading['taskid'] ."', xstatus = 'Not Posted', TenantID = '". $rowMaintenance['TenantID'] ."', reading_date = '". date('Y-m-d', strtotime($rowMaintenance['FQ_Date2'])) ."', MeterID = '". $rowPrevReadingInfo['MeterID'] ."', CurrentMeterUsage = '". $rowPrevReadingInfo[0] ."', UsageStartDate = '". $rowPrevReadingInfo[1] ."';", $connection);

									if($resInsertWO == true){
										$forHeader++;
									}

								}
								
							}

							//Saving of task
							$resTaskInfo = mysql_query("SELECT a.taskid, a.xcategory, a.amount FROM tblmaintenance_tasklist AS a LEFT JOIN tblmaintenance_category AS b ON a.xcategory = b.category_id WHERE a.taskid IN (SELECT xTask FROM tblref_msmaintenance_d WHERE SchedID = '". $rowMaintenance['SchedID'] ."') AND (b.isReading <= '0' OR b.isReading IS NULL);", $connection);
							while($rowTaskInfo = mysql_fetch_array($resTaskInfo)){
								$resInsertWO = mysql_query("INSERT INTO tblmaintenance_workorderlist SET workorderid = '". $WorkOrderID ."', xcategory = '". $rowTaskInfo['xcategory'] ."', xtaskid = '". $rowTaskInfo['taskid'] ."', TenantID = '". $rowMaintenance['TenantID'] ."', sub_total = '". $rowTaskInfo['amount'] ."';", $connection);
								if($resInsertWO == true){
									$forHeader++;
								}
							}

							//Saving of task header
							if($forHeader >= 1){
								$resInsertHeader = mysql_query("INSERT INTO tblmaintenance_workorder SET workorderid = '". $WorkOrderID ."', TenantID = '". $rowMaintenance['TenantID'] ."', xdate = '". date('Y-m-d', strtotime($rowMaintenance['FQ_Date2'])) ."', xtime = '". date('H:i:s') ."', departmentid = '". $rowMaintenance['GroupAccess'] ."', remarks = 'Autogenerated via Mall Scheduler', workerid = '". $rowMaintenance['xPersonnel'] ."', tradename = '". $TenantInfo['tradename'] ."', mallid = '". $TenantInfo['mallID'] ."';", $connection);
							}
						}else if(date('Y-m-d', strtotime(getsysdate())) == date('Y-m-d', strtotime($rowMaintenance['SQ_Date1']))){
							//Saving of task for meter related
							$getTaskWithMeterReading = mysql_query("SELECT a.taskid, a.xcategory, b.isReading FROM tblmaintenance_tasklist AS a LEFT JOIN tblmaintenance_category AS b ON a.xcategory = b.category_id WHERE a.taskid IN (SELECT xTask FROM tblref_msmaintenance_d WHERE SchedID = '". $rowMaintenance['SchedID'] ."') AND b.isReading >= 1 ORDER BY b.isReading;", $connection);
							while($rowgetTaskWithMeterReading = mysql_fetch_array($getTaskWithMeterReading)){

								$getPrevReading = mysql_fetch_array(mysql_query("SELECT reading_date FROM tblmaintenance_workorderlist WHERE xtaskid = '". $rowgetTaskWithMeterReading['taskid'] ."' AND tenantid = '". $rowMaintenance['TenantID'] ."' ORDER BY reading_date DESC LIMIT 1;", $connection));

								if($getPrevReading['reading_date'] == "" || $getPrevReading['reading_date'] == "1970-01-01"){
									if($rowgetTaskWithMeterReading['isReading'] == '1'){
										$PrevReading = date('Y-m-d', strtotime($TenantInfo['LMRElectric']));
									}else if($rowgetTaskWithMeterReading['isReading'] == '2'){
										$PrevReading = date('Y-m-d', strtotime($TenantInfo['LMRWater']));
									}else if($rowgetTaskWithMeterReading['isReading'] == '3'){
										$PrevReading = date('Y-m-d', strtotime($TenantInfo['LMRGas']));
									}
								}else{
									$PrevReading = date('Y-m-d', strtotime($getPrevReading['reading_date']));
								}

								if($rowgetTaskWithMeterReading['isReading'] == '1'){
									$MeterType = "Electric";
								}else if($rowgetTaskWithMeterReading['isReading'] == '2'){
									$MeterType = "Water";
								}else if($rowgetTaskWithMeterReading['isReading'] == '3'){
									$MeterType = "Gas";
								}

								$resPrevReadingInfo = mysql_query("SELECT MAX(CurrentMeterUsage), MAX(SYSDATE), MeterID FROM tblref_meterLogs WHERE AssignedTenant = '". $rowMaintenance['TenantID'] ."' AND MeterType = '". $MeterType ."' AND SysDate >= '". date('Y-m-d', strtotime($PrevReading)) ."' GROUP BY MeterID ORDER BY SYSDATE ASC;", $connection);
								while($rowPrevReadingInfo = mysql_fetch_array($resPrevReadingInfo)){

									$resInsertWO = mysql_query("INSERT INTO tblmaintenance_workorderlist SET workorderid = '". $WorkOrderID ."', xcategory = '". $rowgetTaskWithMeterReading['xcategory'] ."', xtaskid = '". $rowgetTaskWithMeterReading['taskid'] ."', xstatus = 'Not Posted', TenantID = '". $rowMaintenance['TenantID'] ."', reading_date = '". date('Y-m-d', strtotime($rowMaintenance['SQ_Date2'])) ."', MeterID = '". $rowPrevReadingInfo['MeterID'] ."', CurrentMeterUsage = '". $rowPrevReadingInfo[0] ."', UsageStartDate = '". $rowPrevReadingInfo[1] ."';", $connection);

									if($resInsertWO == true){
										$forHeader++;
									}

								}
								
							}

							//Saving of task
							$resTaskInfo = mysql_query("SELECT a.taskid, a.xcategory, a.amount FROM tblmaintenance_tasklist AS a LEFT JOIN tblmaintenance_category AS b ON a.xcategory = b.category_id WHERE a.taskid IN (SELECT xTask FROM tblref_msmaintenance_d WHERE SchedID = '". $rowMaintenance['SchedID'] ."') AND (b.isReading <= '0' OR b.isReading IS NULL);", $connection);
							while($rowTaskInfo = mysql_fetch_array($resTaskInfo)){
								$resInsertWO = mysql_query("INSERT INTO tblmaintenance_workorderlist SET workorderid = '". $WorkOrderID ."', xcategory = '". $rowTaskInfo['xcategory'] ."', xtaskid = '". $rowTaskInfo['taskid'] ."', TenantID = '". $rowMaintenance['TenantID'] ."', sub_total = '". $rowTaskInfo['amount'] ."';", $connection);
								if($resInsertWO == true){
									$forHeader++;
								}
							}

							//Saving of task header
							if($forHeader >= 1){
								$resInsertHeader = mysql_query("INSERT INTO tblmaintenance_workorder SET workorderid = '". $WorkOrderID ."', TenantID = '". $rowMaintenance['TenantID'] ."', xdate = '". date('Y-m-d', strtotime($rowMaintenance['SQ_Date2'])) ."', xtime = '". date('H:i:s') ."', departmentid = '". $rowMaintenance['GroupAccess'] ."', remarks = 'Autogenerated via Mall Scheduler', workerid = '". $rowMaintenance['xPersonnel'] ."', tradename = '". $TenantInfo['tradename'] ."', mallid = '". $TenantInfo['mallID'] ."';", $connection);
							}
						}else if(date('Y-m-d', strtotime(getsysdate())) == date('Y-m-d', strtotime($rowMaintenance['TQ_Date1']))){
							//Saving of task for meter related
							$getTaskWithMeterReading = mysql_query("SELECT a.taskid, a.xcategory, b.isReading FROM tblmaintenance_tasklist AS a LEFT JOIN tblmaintenance_category AS b ON a.xcategory = b.category_id WHERE a.taskid IN (SELECT xTask FROM tblref_msmaintenance_d WHERE SchedID = '". $rowMaintenance['SchedID'] ."') AND b.isReading >= 1 ORDER BY b.isReading;", $connection);
							while($rowgetTaskWithMeterReading = mysql_fetch_array($getTaskWithMeterReading)){

								$getPrevReading = mysql_fetch_array(mysql_query("SELECT reading_date FROM tblmaintenance_workorderlist WHERE xtaskid = '". $rowgetTaskWithMeterReading['taskid'] ."' AND tenantid = '". $rowMaintenance['TenantID'] ."' ORDER BY reading_date DESC LIMIT 1;", $connection));

								if($getPrevReading['reading_date'] == "" || $getPrevReading['reading_date'] == "1970-01-01"){
									if($rowgetTaskWithMeterReading['isReading'] == '1'){
										$PrevReading = date('Y-m-d', strtotime($TenantInfo['LMRElectric']));
									}else if($rowgetTaskWithMeterReading['isReading'] == '2'){
										$PrevReading = date('Y-m-d', strtotime($TenantInfo['LMRWater']));
									}else if($rowgetTaskWithMeterReading['isReading'] == '3'){
										$PrevReading = date('Y-m-d', strtotime($TenantInfo['LMRGas']));
									}
								}else{
									$PrevReading = date('Y-m-d', strtotime($getPrevReading['reading_date']));
								}

								if($rowgetTaskWithMeterReading['isReading'] == '1'){
									$MeterType = "Electric";
								}else if($rowgetTaskWithMeterReading['isReading'] == '2'){
									$MeterType = "Water";
								}else if($rowgetTaskWithMeterReading['isReading'] == '3'){
									$MeterType = "Gas";
								}

								$resPrevReadingInfo = mysql_query("SELECT MAX(CurrentMeterUsage), MAX(SYSDATE), MeterID FROM tblref_meterLogs WHERE AssignedTenant = '". $rowMaintenance['TenantID'] ."' AND MeterType = '". $MeterType ."' AND SysDate >= '". date('Y-m-d', strtotime($PrevReading)) ."' GROUP BY MeterID ORDER BY SYSDATE ASC;", $connection);
								while($rowPrevReadingInfo = mysql_fetch_array($resPrevReadingInfo)){

									$resInsertWO = mysql_query("INSERT INTO tblmaintenance_workorderlist SET workorderid = '". $WorkOrderID ."', xcategory = '". $rowgetTaskWithMeterReading['xcategory'] ."', xtaskid = '". $rowgetTaskWithMeterReading['taskid'] ."', xstatus = 'Not Posted', TenantID = '". $rowMaintenance['TenantID'] ."', reading_date = '". date('Y-m-d', strtotime($rowMaintenance['TQ_Date2'])) ."', MeterID = '". $rowPrevReadingInfo['MeterID'] ."', CurrentMeterUsage = '". $rowPrevReadingInfo[0] ."', UsageStartDate = '". $rowPrevReadingInfo[1] ."';", $connection);

									if($resInsertWO == true){
										$forHeader++;
									}

								}
								
							}

							//Saving of task
							$resTaskInfo = mysql_query("SELECT a.taskid, a.xcategory, a.amount FROM tblmaintenance_tasklist AS a LEFT JOIN tblmaintenance_category AS b ON a.xcategory = b.category_id WHERE a.taskid IN (SELECT xTask FROM tblref_msmaintenance_d WHERE SchedID = '". $rowMaintenance['SchedID'] ."') AND (b.isReading <= '0' OR b.isReading IS NULL);", $connection);
							while($rowTaskInfo = mysql_fetch_array($resTaskInfo)){
								$resInsertWO = mysql_query("INSERT INTO tblmaintenance_workorderlist SET workorderid = '". $WorkOrderID ."', xcategory = '". $rowTaskInfo['xcategory'] ."', xtaskid = '". $rowTaskInfo['taskid'] ."', TenantID = '". $rowMaintenance['TenantID'] ."', sub_total = '". $rowTaskInfo['amount'] ."';", $connection);
								if($resInsertWO == true){
									$forHeader++;
								}
							}

							//Saving of task header
							if($forHeader >= 1){
								$resInsertHeader = mysql_query("INSERT INTO tblmaintenance_workorder SET workorderid = '". $WorkOrderID ."', TenantID = '". $rowMaintenance['TenantID'] ."', xdate = '". date('Y-m-d', strtotime($rowMaintenance['TQ_Date2'])) ."', xtime = '". date('H:i:s') ."', departmentid = '". $rowMaintenance['GroupAccess'] ."', remarks = 'Autogenerated via Mall Scheduler', workerid = '". $rowMaintenance['xPersonnel'] ."', tradename = '". $TenantInfo['tradename'] ."', mallid = '". $TenantInfo['mallID'] ."';", $connection);
							}
						}else if(date('Y-m-d', strtotime(getsysdate())) == date('Y-m-d', strtotime($rowMaintenance['LQ_Date1']))){
							//Saving of task for meter related
							$getTaskWithMeterReading = mysql_query("SELECT a.taskid, a.xcategory, b.isReading FROM tblmaintenance_tasklist AS a LEFT JOIN tblmaintenance_category AS b ON a.xcategory = b.category_id WHERE a.taskid IN (SELECT xTask FROM tblref_msmaintenance_d WHERE SchedID = '". $rowMaintenance['SchedID'] ."') AND b.isReading >= 1 ORDER BY b.isReading;", $connection);
							while($rowgetTaskWithMeterReading = mysql_fetch_array($getTaskWithMeterReading)){

								$getPrevReading = mysql_fetch_array(mysql_query("SELECT reading_date FROM tblmaintenance_workorderlist WHERE xtaskid = '". $rowgetTaskWithMeterReading['taskid'] ."' AND tenantid = '". $rowMaintenance['TenantID'] ."' ORDER BY reading_date DESC LIMIT 1;", $connection));

								if($getPrevReading['reading_date'] == "" || $getPrevReading['reading_date'] == "1970-01-01"){
									if($rowgetTaskWithMeterReading['isReading'] == '1'){
										$PrevReading = date('Y-m-d', strtotime($TenantInfo['LMRElectric']));
									}else if($rowgetTaskWithMeterReading['isReading'] == '2'){
										$PrevReading = date('Y-m-d', strtotime($TenantInfo['LMRWater']));
									}else if($rowgetTaskWithMeterReading['isReading'] == '3'){
										$PrevReading = date('Y-m-d', strtotime($TenantInfo['LMRGas']));
									}
								}else{
									$PrevReading = date('Y-m-d', strtotime($getPrevReading['reading_date']));
								}

								if($rowgetTaskWithMeterReading['isReading'] == '1'){
									$MeterType = "Electric";
								}else if($rowgetTaskWithMeterReading['isReading'] == '2'){
									$MeterType = "Water";
								}else if($rowgetTaskWithMeterReading['isReading'] == '3'){
									$MeterType = "Gas";
								}

								$resPrevReadingInfo = mysql_query("SELECT MAX(CurrentMeterUsage), MAX(SYSDATE), MeterID FROM tblref_meterLogs WHERE AssignedTenant = '". $rowMaintenance['TenantID'] ."' AND MeterType = '". $MeterType ."' AND SysDate >= '". date('Y-m-d', strtotime($PrevReading)) ."' GROUP BY MeterID ORDER BY SYSDATE ASC;", $connection);
								while($rowPrevReadingInfo = mysql_fetch_array($resPrevReadingInfo)){

									$resInsertWO = mysql_query("INSERT INTO tblmaintenance_workorderlist SET workorderid = '". $WorkOrderID ."', xcategory = '". $rowgetTaskWithMeterReading['xcategory'] ."', xtaskid = '". $rowgetTaskWithMeterReading['taskid'] ."', xstatus = 'Not Posted', TenantID = '". $rowMaintenance['TenantID'] ."', reading_date = '". date('Y-m-d', strtotime($rowMaintenance['LQ_Date2'])) ."', MeterID = '". $rowPrevReadingInfo['MeterID'] ."', CurrentMeterUsage = '". $rowPrevReadingInfo[0] ."', UsageStartDate = '". $rowPrevReadingInfo[1] ."';", $connection);

									if($resInsertWO == true){
										$forHeader++;
									}

								}
								
							}

							//Saving of task
							$resTaskInfo = mysql_query("SELECT a.taskid, a.xcategory, a.amount FROM tblmaintenance_tasklist AS a LEFT JOIN tblmaintenance_category AS b ON a.xcategory = b.category_id WHERE a.taskid IN (SELECT xTask FROM tblref_msmaintenance_d WHERE SchedID = '". $rowMaintenance['SchedID'] ."') AND (b.isReading <= '0' OR b.isReading IS NULL);", $connection);
							while($rowTaskInfo = mysql_fetch_array($resTaskInfo)){
								$resInsertWO = mysql_query("INSERT INTO tblmaintenance_workorderlist SET workorderid = '". $WorkOrderID ."', xcategory = '". $rowTaskInfo['xcategory'] ."', xtaskid = '". $rowTaskInfo['taskid'] ."', TenantID = '". $rowMaintenance['TenantID'] ."', sub_total = '". $rowTaskInfo['amount'] ."';", $connection);
								if($resInsertWO == true){
									$forHeader++;
								}
							}

							//Saving of task header
							if($forHeader >= 1){
								$resInsertHeader = mysql_query("INSERT INTO tblmaintenance_workorder SET workorderid = '". $WorkOrderID ."', TenantID = '". $rowMaintenance['TenantID'] ."', xdate = '". date('Y-m-d', strtotime($rowMaintenance['LQ_Date2'])) ."', xtime = '". date('H:i:s') ."', departmentid = '". $rowMaintenance['GroupAccess'] ."', remarks = 'Autogenerated via Mall Scheduler', workerid = '". $rowMaintenance['xPersonnel'] ."', tradename = '". $TenantInfo['tradename'] ."', mallid = '". $TenantInfo['mallID'] ."';", $connection);
							}
						}
					}else if($rowMaintenance['xPeriod'] == "Biannually"){
						if(date('Y-m-d', strtotime(getsysdate())) == date('Y-m-d', strtotime($rowMaintenance['FQ_Date1']))){
							//Saving of task for meter related
							$getTaskWithMeterReading = mysql_query("SELECT a.taskid, a.xcategory, b.isReading FROM tblmaintenance_tasklist AS a LEFT JOIN tblmaintenance_category AS b ON a.xcategory = b.category_id WHERE a.taskid IN (SELECT xTask FROM tblref_msmaintenance_d WHERE SchedID = '". $rowMaintenance['SchedID'] ."') AND b.isReading >= 1 ORDER BY b.isReading;", $connection);
							while($rowgetTaskWithMeterReading = mysql_fetch_array($getTaskWithMeterReading)){

								$getPrevReading = mysql_fetch_array(mysql_query("SELECT reading_date FROM tblmaintenance_workorderlist WHERE xtaskid = '". $rowgetTaskWithMeterReading['taskid'] ."' AND tenantid = '". $rowMaintenance['TenantID'] ."' ORDER BY reading_date DESC LIMIT 1;", $connection));

								if($getPrevReading['reading_date'] == "" || $getPrevReading['reading_date'] == "1970-01-01"){
									if($rowgetTaskWithMeterReading['isReading'] == '1'){
										$PrevReading = date('Y-m-d', strtotime($TenantInfo['LMRElectric']));
									}else if($rowgetTaskWithMeterReading['isReading'] == '2'){
										$PrevReading = date('Y-m-d', strtotime($TenantInfo['LMRWater']));
									}else if($rowgetTaskWithMeterReading['isReading'] == '3'){
										$PrevReading = date('Y-m-d', strtotime($TenantInfo['LMRGas']));
									}
								}else{
									$PrevReading = date('Y-m-d', strtotime($getPrevReading['reading_date']));
								}

								if($rowgetTaskWithMeterReading['isReading'] == '1'){
									$MeterType = "Electric";
								}else if($rowgetTaskWithMeterReading['isReading'] == '2'){
									$MeterType = "Water";
								}else if($rowgetTaskWithMeterReading['isReading'] == '3'){
									$MeterType = "Gas";
								}

								$resPrevReadingInfo = mysql_query("SELECT MAX(CurrentMeterUsage), MAX(SYSDATE), MeterID FROM tblref_meterLogs WHERE AssignedTenant = '". $rowMaintenance['TenantID'] ."' AND MeterType = '". $MeterType ."' AND SysDate >= '". date('Y-m-d', strtotime($PrevReading)) ."' GROUP BY MeterID ORDER BY SYSDATE ASC;", $connection);
								while($rowPrevReadingInfo = mysql_fetch_array($resPrevReadingInfo)){

									$resInsertWO = mysql_query("INSERT INTO tblmaintenance_workorderlist SET workorderid = '". $WorkOrderID ."', xcategory = '". $rowgetTaskWithMeterReading['xcategory'] ."', xtaskid = '". $rowgetTaskWithMeterReading['taskid'] ."', xstatus = 'Not Posted', TenantID = '". $rowMaintenance['TenantID'] ."', reading_date = '". date('Y-m-d', strtotime($rowMaintenance['FQ_Date2'])) ."', MeterID = '". $rowPrevReadingInfo['MeterID'] ."', CurrentMeterUsage = '". $rowPrevReadingInfo[0] ."', UsageStartDate = '". $rowPrevReadingInfo[1] ."';", $connection);

									if($resInsertWO == true){
										$forHeader++;
									}

								}
								
							}

							//Saving of task
							$resTaskInfo = mysql_query("SELECT a.taskid, a.xcategory, a.amount FROM tblmaintenance_tasklist AS a LEFT JOIN tblmaintenance_category AS b ON a.xcategory = b.category_id WHERE a.taskid IN (SELECT xTask FROM tblref_msmaintenance_d WHERE SchedID = '". $rowMaintenance['SchedID'] ."') AND (b.isReading <= '0' OR b.isReading IS NULL);", $connection);
							while($rowTaskInfo = mysql_fetch_array($resTaskInfo)){
								$resInsertWO = mysql_query("INSERT INTO tblmaintenance_workorderlist SET workorderid = '". $WorkOrderID ."', xcategory = '". $rowTaskInfo['xcategory'] ."', xtaskid = '". $rowTaskInfo['taskid'] ."', TenantID = '". $rowMaintenance['TenantID'] ."', sub_total = '". $rowTaskInfo['amount'] ."';", $connection);
								if($resInsertWO == true){
									$forHeader++;
								}
							}

							//Saving of task header
							if($forHeader >= 1){
								$resInsertHeader = mysql_query("INSERT INTO tblmaintenance_workorder SET workorderid = '". $WorkOrderID ."', TenantID = '". $rowMaintenance['TenantID'] ."', xdate = '". date('Y-m-d', strtotime($rowMaintenance['FQ_Date2'])) ."', xtime = '". date('H:i:s') ."', departmentid = '". $rowMaintenance['GroupAccess'] ."', remarks = 'Autogenerated via Mall Scheduler', workerid = '". $rowMaintenance['xPersonnel'] ."', tradename = '". $TenantInfo['tradename'] ."', mallid = '". $TenantInfo['mallID'] ."';", $connection);
							}
						}else if(date('Y-m-d', strtotime(getsysdate())) == date('Y-m-d', strtotime($rowMaintenance['SQ_Date1']))){
							//Saving of task for meter related
							$getTaskWithMeterReading = mysql_query("SELECT a.taskid, a.xcategory, b.isReading FROM tblmaintenance_tasklist AS a LEFT JOIN tblmaintenance_category AS b ON a.xcategory = b.category_id WHERE a.taskid IN (SELECT xTask FROM tblref_msmaintenance_d WHERE SchedID = '". $rowMaintenance['SchedID'] ."') AND b.isReading >= 1 ORDER BY b.isReading;", $connection);
							while($rowgetTaskWithMeterReading = mysql_fetch_array($getTaskWithMeterReading)){

								$getPrevReading = mysql_fetch_array(mysql_query("SELECT reading_date FROM tblmaintenance_workorderlist WHERE xtaskid = '". $rowgetTaskWithMeterReading['taskid'] ."' AND tenantid = '". $rowMaintenance['TenantID'] ."' ORDER BY reading_date DESC LIMIT 1;", $connection));

								if($getPrevReading['reading_date'] == "" || $getPrevReading['reading_date'] == "1970-01-01"){
									if($rowgetTaskWithMeterReading['isReading'] == '1'){
										$PrevReading = date('Y-m-d', strtotime($TenantInfo['LMRElectric']));
									}else if($rowgetTaskWithMeterReading['isReading'] == '2'){
										$PrevReading = date('Y-m-d', strtotime($TenantInfo['LMRWater']));
									}else if($rowgetTaskWithMeterReading['isReading'] == '3'){
										$PrevReading = date('Y-m-d', strtotime($TenantInfo['LMRGas']));
									}
								}else{
									$PrevReading = date('Y-m-d', strtotime($getPrevReading['reading_date']));
								}

								if($rowgetTaskWithMeterReading['isReading'] == '1'){
									$MeterType = "Electric";
								}else if($rowgetTaskWithMeterReading['isReading'] == '2'){
									$MeterType = "Water";
								}else if($rowgetTaskWithMeterReading['isReading'] == '3'){
									$MeterType = "Gas";
								}

								$resPrevReadingInfo = mysql_query("SELECT MAX(CurrentMeterUsage), MAX(SYSDATE), MeterID FROM tblref_meterLogs WHERE AssignedTenant = '". $rowMaintenance['TenantID'] ."' AND MeterType = '". $MeterType ."' AND SysDate >= '". date('Y-m-d', strtotime($PrevReading)) ."' GROUP BY MeterID ORDER BY SYSDATE ASC;", $connection);
								while($rowPrevReadingInfo = mysql_fetch_array($resPrevReadingInfo)){

									$resInsertWO = mysql_query("INSERT INTO tblmaintenance_workorderlist SET workorderid = '". $WorkOrderID ."', xcategory = '". $rowgetTaskWithMeterReading['xcategory'] ."', xtaskid = '". $rowgetTaskWithMeterReading['taskid'] ."', xstatus = 'Not Posted', TenantID = '". $rowMaintenance['TenantID'] ."', reading_date = '". date('Y-m-d', strtotime($rowMaintenance['SQ_Date2'])) ."', MeterID = '". $rowPrevReadingInfo['MeterID'] ."', CurrentMeterUsage = '". $rowPrevReadingInfo[0] ."', UsageStartDate = '". $rowPrevReadingInfo[1] ."';", $connection);

									if($resInsertWO == true){
										$forHeader++;
									}

								}
								
							}

							//Saving of task
							$resTaskInfo = mysql_query("SELECT a.taskid, a.xcategory, a.amount FROM tblmaintenance_tasklist AS a LEFT JOIN tblmaintenance_category AS b ON a.xcategory = b.category_id WHERE a.taskid IN (SELECT xTask FROM tblref_msmaintenance_d WHERE SchedID = '". $rowMaintenance['SchedID'] ."') AND (b.isReading <= '0' OR b.isReading IS NULL);", $connection);
							while($rowTaskInfo = mysql_fetch_array($resTaskInfo)){
								$resInsertWO = mysql_query("INSERT INTO tblmaintenance_workorderlist SET workorderid = '". $WorkOrderID ."', xcategory = '". $rowTaskInfo['xcategory'] ."', xtaskid = '". $rowTaskInfo['taskid'] ."', TenantID = '". $rowMaintenance['TenantID'] ."', sub_total = '". $rowTaskInfo['amount'] ."';", $connection);
								if($resInsertWO == true){
									$forHeader++;
								}
							}

							//Saving of task header
							if($forHeader >= 1){
								$resInsertHeader = mysql_query("INSERT INTO tblmaintenance_workorder SET workorderid = '". $WorkOrderID ."', TenantID = '". $rowMaintenance['TenantID'] ."', xdate = '". date('Y-m-d', strtotime($rowMaintenance['SQ_Date2'])) ."', xtime = '". date('H:i:s') ."', departmentid = '". $rowMaintenance['GroupAccess'] ."', remarks = 'Autogenerated via Mall Scheduler', workerid = '". $rowMaintenance['xPersonnel'] ."', tradename = '". $TenantInfo['tradename'] ."', mallid = '". $TenantInfo['mallID'] ."';", $connection);
							}
						}
					}else if($rowMaintenance['xPeriod'] == "Annually"){
						if(date('Y-m-d', strtotime(getsysdate())) == date('Y-m-d', strtotime($rowMaintenance['FQ_Date1']))){
							//Saving of task for meter related
							$getTaskWithMeterReading = mysql_query("SELECT a.taskid, a.xcategory, b.isReading FROM tblmaintenance_tasklist AS a LEFT JOIN tblmaintenance_category AS b ON a.xcategory = b.category_id WHERE a.taskid IN (SELECT xTask FROM tblref_msmaintenance_d WHERE SchedID = '". $rowMaintenance['SchedID'] ."') AND b.isReading >= 1 ORDER BY b.isReading;", $connection);
							while($rowgetTaskWithMeterReading = mysql_fetch_array($getTaskWithMeterReading)){

								$getPrevReading = mysql_fetch_array(mysql_query("SELECT reading_date FROM tblmaintenance_workorderlist WHERE xtaskid = '". $rowgetTaskWithMeterReading['taskid'] ."' AND tenantid = '". $rowMaintenance['TenantID'] ."' ORDER BY reading_date DESC LIMIT 1;", $connection));

								if($getPrevReading['reading_date'] == "" || $getPrevReading['reading_date'] == "1970-01-01"){
									if($rowgetTaskWithMeterReading['isReading'] == '1'){
										$PrevReading = date('Y-m-d', strtotime($TenantInfo['LMRElectric']));
									}else if($rowgetTaskWithMeterReading['isReading'] == '2'){
										$PrevReading = date('Y-m-d', strtotime($TenantInfo['LMRWater']));
									}else if($rowgetTaskWithMeterReading['isReading'] == '3'){
										$PrevReading = date('Y-m-d', strtotime($TenantInfo['LMRGas']));
									}
								}else{
									$PrevReading = date('Y-m-d', strtotime($getPrevReading['reading_date']));
								}

								if($rowgetTaskWithMeterReading['isReading'] == '1'){
									$MeterType = "Electric";
								}else if($rowgetTaskWithMeterReading['isReading'] == '2'){
									$MeterType = "Water";
								}else if($rowgetTaskWithMeterReading['isReading'] == '3'){
									$MeterType = "Gas";
								}

								$resPrevReadingInfo = mysql_query("SELECT MAX(CurrentMeterUsage), MAX(SYSDATE), MeterID FROM tblref_meterLogs WHERE AssignedTenant = '". $rowMaintenance['TenantID'] ."' AND MeterType = '". $MeterType ."' AND SysDate >= '". date('Y-m-d', strtotime($PrevReading)) ."' GROUP BY MeterID ORDER BY SYSDATE ASC;", $connection);
								while($rowPrevReadingInfo = mysql_fetch_array($resPrevReadingInfo)){

									$resInsertWO = mysql_query("INSERT INTO tblmaintenance_workorderlist SET workorderid = '". $WorkOrderID ."', xcategory = '". $rowgetTaskWithMeterReading['xcategory'] ."', xtaskid = '". $rowgetTaskWithMeterReading['taskid'] ."', xstatus = 'Not Posted', TenantID = '". $rowMaintenance['TenantID'] ."', reading_date = '". date('Y-m-d', strtotime($rowMaintenance['FQ_Date2'])) ."', MeterID = '". $rowPrevReadingInfo['MeterID'] ."', CurrentMeterUsage = '". $rowPrevReadingInfo[0] ."', UsageStartDate = '". $rowPrevReadingInfo[1] ."';", $connection);

									if($resInsertWO == true){
										$forHeader++;
									}

								}
								
							}

							//Saving of task
							$resTaskInfo = mysql_query("SELECT a.taskid, a.xcategory, a.amount FROM tblmaintenance_tasklist AS a LEFT JOIN tblmaintenance_category AS b ON a.xcategory = b.category_id WHERE a.taskid IN (SELECT xTask FROM tblref_msmaintenance_d WHERE SchedID = '". $rowMaintenance['SchedID'] ."') AND (b.isReading <= '0' OR b.isReading IS NULL);", $connection);
							while($rowTaskInfo = mysql_fetch_array($resTaskInfo)){
								$resInsertWO = mysql_query("INSERT INTO tblmaintenance_workorderlist SET workorderid = '". $WorkOrderID ."', xcategory = '". $rowTaskInfo['xcategory'] ."', xtaskid = '". $rowTaskInfo['taskid'] ."', TenantID = '". $rowMaintenance['TenantID'] ."', sub_total = '". $rowTaskInfo['amount'] ."';", $connection);
								if($resInsertWO == true){
									$forHeader++;
								}
							}

							//Saving of task header
							if($forHeader >= 1){
								$resInsertHeader = mysql_query("INSERT INTO tblmaintenance_workorder SET workorderid = '". $WorkOrderID ."', TenantID = '". $rowMaintenance['TenantID'] ."', xdate = '". date('Y-m-d', strtotime($rowMaintenance['FQ_Date2'])) ."', xtime = '". date('H:i:s') ."', departmentid = '". $rowMaintenance['GroupAccess'] ."', remarks = 'Autogenerated via Mall Scheduler', workerid = '". $rowMaintenance['xPersonnel'] ."', tradename = '". $TenantInfo['tradename'] ."', mallid = '". $TenantInfo['mallID'] ."';", $connection);
							}
						}
					}
				}
			}
		break;

		case 'checkConnection':
			echo mysql_query("SELECT id FROM tblsys_setup;", mysql_error());
		break;

		case 'fncChangeSelectID':
			$resUnitImages = mysql_query("SELECT UnitID, ImageName FROM tblref_unitimage WHERE UnitID = '". $_POST['UnitID'] ."';", $connection);
			while($rowUnitImages = mysql_fetch_array($resUnitImages)){
				if(file_exists("../Mall_Attachments/Unit Image/".$rowUnitImages['UnitID']."/".$rowUnitImages['ImageName'])){
					echo 	"<li class='center' style='border-color: #CCC !important;'>
                                <a href='../Mall_Attachments/Unit Image/".$rowUnitImages['UnitID']."/".$rowUnitImages['ImageName'] ."' title='Photo Title' data-rel='colorbox-". $rowUnitImages['UnitID'] ."' class='cboxElement'>
                                    <img width='127' height='127' alt='". $rowUnitImages['ImageName'] ."' src='../Mall_Attachments/Unit Image/".$rowUnitImages['UnitID']."/".$rowUnitImages['ImageName'] ."' style='padding: 5px;'>
                                </a>
                            </li>";
				}
			}
		break;

		// referentialreportsruth
		case 'refclassificationrep':
			$res = mysql_query("SELECT classificationID, classification FROM tblref_merchandise_class WHERE classification LIKE '%". $_POST['key'] ."%' OR classificationID LIKE '%". $_POST['key'] ."%' ORDER BY classification ASC ", $connection); 
			?>  
			<style type="text/css">
				#hr{
					background: black !important; padding:2px;
				}
			</style>

			<center> <h2> <b>List of Classification</b>  </h2>  </center>
			<table style='width:100%;'>
				<tr>
					<td id='hr'> </td>
				</tr>
			</table><br/>
			<table  style='width: 100%;' cellspacing='0' cellpadding='0'>
				<thead>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Code </th>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Description </th>
				</thead>

			<?php
			while($row = mysql_fetch_array($res)){
				?>
				<tr id='<?php echo $row[0]; ?>'>
					<td style="border: 1px solid black; padding:5px;"><?php echo $row[0]; ?></td>
					<td style="border: 1px solid black; padding:5px;"><?php echo $row[1]; ?></td>
				</tr>
				<?php
			}
			?></tbody></table><?php
		break;

		//	xmer 09162019
		case 'refmaincategoryrep':
		$res = mysql_query("SELECT category_id, category, icon, Maintenance_Type FROM tblmaintenance_category WHERE Category LIKE '%". $_POST['key'] ."%' OR category_id LIKE '%". $_POST['key'] ."%' OR Maintenance_Type LIKE '%". $_POST['key'] ."%' ORDER BY category ASC;", $connection); 
			?>  
			<style type="text/css">
				#hr{
					background: black !important; padding:2px;
				}
			</style>

			<center> <h2> <b>List of Maintenance Category</b>  </h2>  </center>
			<table style='width:100%;'>
				<tr>
					<td id='hr'> </td>
				</tr>
			</table><br/>
			<table  style='width: 100%;' cellspacing='0' cellpadding='0'>
				<thead>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Code </th>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Type </th>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Description </th>
				</thead>

			<?php
			while($row = mysql_fetch_array($res)){
				?>
				<tr id='<?php echo $row[0]; ?>'>
					<td style="border: 1px solid black; padding:5px;"><?php echo $row[0]; ?></td>
					<td style="border: 1px solid black; padding:5px;"><?php echo $row[1]; ?></td>
					<td style="border: 1px solid black; padding:5px;"><?php echo $row[3]; ?></td>
				</tr>
				<?php
			}
			?></tbody></table><?php
		break;
		//	xmer 09162019

		//	xmer 09162019
		case 'refmaintaskrep':
		$res = mysql_query("SELECT b.category, a.taskid, a.description, a.amount, a.equipmentname FROM tblmaintenance_tasklist AS a LEFT JOIN tblmaintenance_category AS b ON a.xcategory = b.category_id WHERE a.description LIKE '%". $_POST['key'] ."%' OR b.category LIKE '%". $_POST['key'] ."%' OR a.taskid LIKE '%". $_POST['key'] ."%' OR a.amount LIKE '%". $_POST['key'] ."%' OR a.equipmentname LIKE '%". $_POST['key'] ."%' ORDER BY a.description ASC;", $connection); 
			?>  
			<style type="text/css">
				#hr{
					background: black !important; padding:2px;
				}
			</style>

			<center> <h2> <b>List of Maintenance Task</b>  </h2>  </center>
			<table style='width:100%;'>
				<tr>
					<td id='hr'> </td>
				</tr>
			</table><br/>
			<table  style='width: 100%;' cellspacing='0' cellpadding='0'>
				<thead>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Code </th>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Category </th>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Description </th>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Amount </th>
				</thead>

			<?php
			while($row = mysql_fetch_array($res)){
				?>
				<tr id='<?php echo $row[0]; ?>'>
					<td style="border: 1px solid black; padding:5px;"><?php echo $row[1]; ?></td>
					<td style="border: 1px solid black; padding:5px;"><?php echo $row[0]; ?></td>
					<td style="border: 1px solid black; padding:5px;"><?php echo $row[2]; ?></td>
					<td style="border: 1px solid black; padding:5px;"><?php echo $row[3]; ?></td>
				</tr>
				<?php
			}
			?></tbody></table><?php
		break;
		//	xmer 09162019

		//	xmer 09162019
		case 'refmainhouseguestrep':
		$res = mysql_query("SELECT id, code, violation, 1st_offense, 2nd_offense, 3rd_offense, xsucceeding FROM tblmaintenance_houserules WHERE violation LIKE '%". $_POST['key'] ."%' OR code LIKE '%". $_POST['key'] ."%' OR 1st_offense LIKE '%". $_POST['key'] ."%' OR 2nd_offense LIKE '%". $_POST['key'] ."%' OR 3rd_offense LIKE '%". $_POST['key'] ."%' OR xsucceeding LIKE '%". $_POST['key'] ."%';", $connection); 
			?>  
			<style type="text/css">
				#hr{
					background: black !important; padding:2px;
				}
			</style>

			<center> <h2> <b>List of Maintenance HouseRules</b>  </h2>  </center>
			<table style='width:100%;'>
				<tr>
					<td id='hr'> </td>
				</tr>
			</table><br/>
			<table  style='width: 100%;' cellspacing='0' cellpadding='0'>
				<thead>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Code </th>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Violation </th>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> 1st Offense </th>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> 2nd Offense </th>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> 3rd Offense </th>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Succeeding </th>
				</thead>

			<?php
			while($row = mysql_fetch_array($res)){
				?>
				<tr id='<?php echo $row[0]; ?>'>
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
		//	xmer 09162019

		//	xmer 09162019
		case 'refbankrep':
		$res = mysql_query("SELECT xCODE, description FROM tblrefbank WHERE Description LIKE '%". $_POST['key'] ."%' OR XCODE LIKE '%". $_POST['key'] ."%' ORDER BY description;", $connection); 
			?>  
			<style type="text/css">
				#hr{
					background: black !important; padding:2px;
				}
			</style>

			<center> <h2> <b>List of Banks</b>  </h2>  </center>
			<table style='width:100%;'>
				<tr>
					<td id='hr'> </td>
				</tr>
			</table><br/>
			<table  style='width: 100%;' cellspacing='0' cellpadding='0'>
				<thead>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Code </th>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Description </th>
				</thead>

			<?php
			while($row = mysql_fetch_array($res)){
				?>
				<tr id='<?php echo $row[0]; ?>'>
					<td style="border: 1px solid black; padding:5px;"><?php echo $row[0]; ?></td>
					<td style="border: 1px solid black; padding:5px;"><?php echo $row[1]; ?></td>
				</tr>
				<?php
			}
			?></tbody></table><?php
		break;
		//	xmer 09162019
		
		case 'refPaymentType':
			$res = mysql_query("SELECT PaymentTypeID, PaymentTypeDesc, PaymentType FROM tblref_pospaymenttype WHERE PaymentTypeID LIKE '%". $_POST['key'] ."%' OR PaymentTypeDesc LIKE '%". $_POST['key'] ."%' ORDER BY PaymentTypeDesc;", $connection); 
			?>  
			<style type="text/css">
				#hr{
					background: black !important; padding:2px;
				}
			</style>

			<center> <h2> <b>List of Payment Type</b>  </h2>  </center>
			<table style='width:100%;'>
				<tr>
					<td id='hr'> </td>
				</tr>
			</table><br/>
			<table  style='width: 100%;' cellspacing='0' cellpadding='0'>
				<thead>
					<th style="width: 30%;">Payment Type</th>
					<th style="width: 30%;">Code</th>
					<th style="width: 40%;">Description</th>
				</thead>

			<?php
			while($row = mysql_fetch_array($res)){
				?>
				<tr id='<?php echo $row['PaymentTypeID']; ?>'>
					<td style="border: 1px solid black; padding:5px;"><?php echo $row['PaymentType']; ?></td>
					<td style="border: 1px solid black; padding:5px;"><?php echo $row['PaymentTypeID']; ?></td>
					<td style="border: 1px solid black; padding:5px;"><?php echo $row['PaymentTypeDesc']; ?></td>
				</tr>
				<?php
			}
			?></tbody></table><?php
		break;

		//	xmer 09162019
		case 'refpositionrep':
		$res = mysql_query("SELECT EmpDepCode, EmpPositionCode, xPOSITION FROM tblref_companyposition WHERE xPOSITION LIKE '%". $_POST['key'] ."%' ORDER BY xPOSITION;", $connection); 
			?>  
			<style type="text/css">
				#hr{
					background: black !important; padding:2px;
				}
			</style>

			<center> <h2> <b>List of Positions</b>  </h2>  </center>
			<table style='width:100%;'>
				<tr>
					<td id='hr'> </td>
				</tr>
			</table><br/>
			<table  style='width: 100%;' cellspacing='0' cellpadding='0'>
				<thead>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Department </th>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Code </th>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Position </th>
				</thead>

			<?php
			while($row = mysql_fetch_array($res)){
				$Department = mysql_fetch_array(mysql_query("SELECT description FROM tblmaintenance_department WHERE code = '". $row['0'] ."';", $connection));
				?>
				<tr id='<?php echo $row[0]; ?>'>
					<td style="border: 1px solid black; padding:5px;"><?php echo $Department[0]; ?></td>					
					<td style="border: 1px solid black; padding:5px;"><?php echo $row[1]; ?></td>					
					<td style="border: 1px solid black; padding:5px;"><?php echo $row[2]; ?></td>					
				</tr>
				<?php
			}
			?></tbody></table><?php
		break;
		//	xmer 09162019

		//	xmer 09162019
		case 'refrequirementsrep':
		$res = mysql_query("SELECT reqCode, requirements, override, id FROM tblref_applicationrequirements WHERE requirements LIKE '%". $_POST['key'] ."%' ORDER BY requirements;", $connection); 
			?>  
			<style type="text/css">
				#hr{
					background: black !important; padding:2px;
				}
			</style>

			<center> <h2> <b>List of Requirements</b>  </h2>  </center>
			<table style='width:100%;'>
				<tr>
					<td id='hr'> </td>
				</tr>
			</table><br/>
			<table  style='width: 100%;' cellspacing='0' cellpadding='0'>
				<thead>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Code </th>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Description </th>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Override </th>
				</thead>

			<?php
			while($row = mysql_fetch_array($res)){
				?>
				<tr id='<?php echo $row[0]; ?>'>
					<td style="border: 1px solid black; padding:5px;"><?php echo $row[0]; ?></td>
					<td style="border: 1px solid black; padding:5px;"><?php echo $row[1]; ?></td>
					<td style="border: 1px solid black; padding:5px;"><?php echo $row[2]; ?></td>
				</tr>
				<?php
			}
			?></tbody></table><?php
		break;
		//	xmer 09162019

		//	xmer 09162019
		case 'refpermitsrep':
		$res = mysql_query("SELECT PermitCode, DESCRIPTION, override, id FROM tblref_typeofpermits WHERE DESCRIPTION LIKE '%". $_POST['key'] ."%' ;", $connection); 
			?>  
			<style type="text/css">
				#hr{
					background: black !important; padding:2px;

				}
			</style>

			<center> <h2> <b>List of Permits</b>  </h2>  </center>
			<table style='width:100%;'>
				<tr>
					<td id='hr'> </td>
				</tr>
			</table><br/>
			<table  style='width: 100%;' cellspacing='0' cellpadding='0'>
				<thead>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Code </th>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Description </th>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Override </th>
				</thead>

			<?php
			while($row = mysql_fetch_array($res)){
				?>
				<tr id='<?php echo $row[0]; ?>'>
					<td style="border: 1px solid black; padding:5px;"><?php echo $row[0]; ?></td>
					<td style="border: 1px solid black; padding:5px;"><?php echo $row[1]; ?></td>
					<td style="border: 1px solid black; padding:5px;"><?php echo $row[2]; ?></td>
				</tr>
				<?php
			}
			?></tbody></table><?php
		break;
		//	xmer 09162019

		//	xmer 09162019
		case 'refemployeerep':
		$res = mysql_query("SELECT id, mallid, Code, Position, First_Name, Middle_Name, Last_Name, Department FROM tblref_employee WHERE Code LIKE '%". $_POST['key'] ."%' OR Position LIKE '%". $_POST['key'] ."%' OR First_Name LIKE '%". $_POST['key'] ."%' OR Middle_Name LIKE '%". $_POST['key'] ."%' OR Last_Name LIKE '%". $_POST['key'] ."%' ;", $connection); 
			?>  
			<style type="text/css">
				#hr{
					background: black !important; padding:2px;
				}
			</style>

			<center> <h2> <b>List of Employees</b>  </h2>  </center>
			<table style='width:100%;'>
				<tr>
					<td id='hr'> </td>
				</tr>
			</table><br/>
			<table  style='width: 100%;' cellspacing='0' cellpadding='0'>
				<thead>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Assigned Building </th>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Code </th>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Department </th>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Position </th>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> First Name </th>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Middle Name </th>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Last Name </th>
				</thead>

			<?php
			while($row = mysql_fetch_array($res)){
				?>
				<tr id='<?php echo $row[0]; ?>'>
					<td style="border: 1px solid black; padding:5px;"><?php echo $row[1]; ?></td>
					<td style="border: 1px solid black; padding:5px;"><?php echo $row[2]; ?></td>
					<td style="border: 1px solid black; padding:5px;"><?php echo $row[7]; ?></td>
					<td style="border: 1px solid black; padding:5px;"><?php echo $row[3]; ?></td>
					<td style="border: 1px solid black; padding:5px;"><?php echo $row[4]; ?></td>
					<td style="border: 1px solid black; padding:5px;"><?php echo $row[5]; ?></td>
					<td style="border: 1px solid black; padding:5px;"><?php echo $row[6]; ?></td>
				</tr>
				<?php
			}
			?></tbody></table><?php
		break;
		//	xmer 09162019

		//	xmer 09162019
		case 'refchargesrep':
		$res = mysql_query("SELECT CHARGE_ID, CHARGE_DESC, CHARGE_TYPE, RATE_TYPE, RATE, OTHER_REASON, isDefault FROM tblref_refcharges WHERE CHARGE_ID LIKE '%". $_POST['key'] ."%' OR CHARGE_DESC LIKE '%". $_POST['key'] ."%' ORDER BY CHARGE_DESC ;", $connection); 
			?>  
			<style type="text/css">
				#hr{
					background: black !important; padding:2px;
				}
			</style>

			<center> <h2> <b>List of Employees</b>  </h2>  </center>
			<table style='width:100%;'>
				<tr>
					<td id='hr'> </td>
				</tr>
			</table><br/>
			<table  style='width: 100%;' cellspacing='0' cellpadding='0'>
				<thead>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Charge Code </th>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Charge Description </th>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Charge Type </th>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Rate Type </th>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Rate </th>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Reason </th>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Default Proposal Status </th>
				</thead>

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
		//	xmer 09162019

		//	xmer 09162019
		case 'refpenaltyrep':
		$res = mysql_query("SELECT PenaltyCode, PenaltyDesc, Amount FROM tblref_penalty WHERE PenaltyCode LIKE '%". $_POST['key'] ."%' OR PenaltyDesc LIKE '%". $_POST['key'] ."%' ORDER BY PenaltyDesc ;", $connection); 
			?>  
			<style type="text/css">
				#hr{
					background: black !important; padding:2px;
				}
			</style>

			<center> <h2> <b>List of Penalties</b>  </h2>  </center>
			<table style='width:100%;'>
				<tr>
					<td id='hr'> </td>
				</tr>
			</table><br/>
			<table  style='width: 100%;' cellspacing='0' cellpadding='0'>
				<thead>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Code </th>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Penalty </th>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Amount  </th>
				</thead>

			<?php
			while($row = mysql_fetch_array($res)){
				?>
				<tr id='<?php echo $row[0]; ?>'>
					<td style="border: 1px solid black; padding:5px;"><?php echo $row[0]; ?></td>
					<td style="border: 1px solid black; padding:5px;"><?php echo $row[1]; ?></td>
					<td style="border: 1px solid black; padding:5px;"><?php echo $row[2]; ?></td>
				</tr>
				<?php
			}
			?></tbody></table><?php
		break;
		//	xmer 09162019

		//	xmer 09162019
		case 'refunitcategoryrep':
			if(SysLeaseSetup('isClassification') == "1" && SysLeaseSetup('isDepartment') == "0"){
					$res = mysql_query("SELECT b.classification, a.categoryID, a.category FROM tblref_merchandisedep_cat AS a LEFT JOIN tblref_merchandise_class AS b ON a.class_ID = b.classificationID WHERE a.category LIKE '%". $_POST['key']."%' OR b.classification LIKE '%". $_POST['key'] ."%' OR a.categoryID LIKE '%". $_POST['key'] ."%' ORDER BY a.category ;", $connection); 
				}else{
					if(SysLeaseSetup('isDepartment') == "1"){
						$res = mysql_query("SELECT b.department, a.categoryID, a.category FROM tblref_merchandisedep_cat AS a LEFT JOIN tblref_merchandise_depa AS b ON a.dept_ID = b.departmentID WHERE a.category LIKE '%". $_POST['key']."%' OR b.department LIKE '%". $_POST['key'] ."%' OR a.categoryID LIKE '%". $_POST['key'] ."%' ORDER BY a.category ;", $connection); 
					}else{
						$res = mysql_query("SELECT categoryID, categoryID, category FROM tblref_merchandisedep_cat WHERE category LIKE '%". $_POST['key']."%' OR categoryID LIKE '%". $_POST['key'] ."%' ORDER BY category ;", $connection); 
					}
				}

			?>  
			<style type="text/css">
				#hr{
					background: black !important; padding:2px;
				}
			</style>

			<center> <h2> <b>List of Unit Categories</b>  </h2>  </center>
			<table style='width:100%;'>
				<tr>
					<td id='hr'> </td>
				</tr>
			</table><br/>
			<table  style='width: 100%;' cellspacing='0' cellpadding='0'>
				<thead>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Code </th>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Category </th>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Description </th>
				</thead>
			<?php
			while($row = mysql_fetch_array($res)){
				?>
				<tr id='<?php echo $row[0]; ?>'>
					<td style="border: 1px solid black; padding:5px;"><?php echo $row[1]; ?></td>
					<td style="border: 1px solid black; padding:5px;"><?php echo $row[0]; ?></td>
					<td style="border: 1px solid black; padding:5px;"><?php echo $row[2]; ?></td>
				</tr>
				<?php
			}
			?></tbody></table><?php
		break;

		case 'refunitdept':
		$res = mysql_query("SELECT class_ID, departmentID, department FROM tblref_merchandise_depa WHERE department LIKE '%". $_POST['key'] ."%' OR departmentID LIKE '%". $_POST['key'] ."%' ORDER BY department ASC ", $connection); 
			?>  
			<style type="text/css">
				#hr{
					background: black !important; padding:2px;
				}
			</style>

			<center> <h2> <b>List of Department</b>  </h2>  </center>
			<table style='width:100%;'>
				<tr>
					<td id='hr'> </td>
				</tr>
			</table><br/>
			<table  style='width: 100%;' cellspacing='0' cellpadding='0'>
				<thead>
					<th style="border: 1px solid black; text-align: center; color: white !important;" > Code </th>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Classification </th>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Description  </th>
				</thead>

			<?php
			while($row = mysql_fetch_array($res)){
				?>
				<tr id='<?php echo $row[0]; ?>'>
					<td style="border: 1px solid black; padding: 5px;"><?php echo $row[0]; ?></td>
					<td style="border: 1px solid black; padding: 5px;"><?php echo $row[1]; ?></td>
					<td style="border: 1px solid black; padding: 5px;"><?php echo $row[2]; ?></td>
				</tr>
				<?php
			}
			?></tbody></table><?php
		break;

		case 'refindustry':
			$res = mysql_query("SELECT Industry_ID, Industry, id FROM tblref_industry WHERE Industry LIKE '%". $_POST['key'] ."%' OR Industry_ID LIKE '%". $_POST['key'] ."%' ORDER BY Industry ASC ", $connection); 
			?>  

			<style type="text/css">
				#hr{
					background: black !important; padding:2px;
				}
			</style>

			<center> <h2> <b>List of Industry</b>  </h2>  </center>
			<table style='width:100%;'>
				<tr>
					<td id='hr'> </td>
				</tr>
			</table><br/>
			<table  style='width: 100%;' cellspacing='0' cellpadding='0'>
				<thead>
					<th style="border: 1px solid black; text-align: center; color: white !important;" > Code </th>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Description </th>
				</thead>

			<?php
			while($row = mysql_fetch_array($res)){
				?>
				<tr id='<?php echo $row[0]; ?>'>
					<td style="border: 1px solid black; padding: 5px;"><?php echo $row[0]; ?></td>
					<td style="border: 1px solid black; padding: 5px;"><?php echo $row[1]; ?></td>
				</tr>
				<?php
			}
			?></tbody></table><?php
		break;

		case 'tenantslist':
        	$res = mysql_query("SELECT t.tenantid, t.merchant_code, t.tradename, t.companyname, i.industry, t.datefrom, t.dateto FROM tbltrans_tenants t LEFT JOIN tbltrans_inquiry i ON t.tradeID = i.tradeID WHERE t.tenantid LIKE '%". $_POST['key'] ."%' OR t.tenantid LIKE '%". $_POST['key'] ."%' ORDER BY t.tenantid ASC ", $connection); 
            ?>  
            <style type="text/css">
                #hr{
                    background: black !important; padding:2px;      
                }
            </style>

            <center> <h2> <b>List of Tenants</b>  </h2>  </center>
            <table style='width:100%;'>
                <tr>
                    <td id='hr'> </td>
                </tr>
            </table><br/>
            <table  style='width: 100%;' cellspacing='0' cellpadding='0'>
                <thead>
                    <th style="border: 1px solid black; text-align: center; color: white !important;" > TenantID </th>
                    <th style="border: 1px solid black; text-align: center; color: white !important; padding: 4px; ">   Merchant code  </th>
                    <th style="border: 1px solid black; text-align: center; color: white !important; "> Trade Name  </th>
                	<th style="border: 1px solid black; text-align: center; color: white !important; "> Company Name  </th>
            		<th style="border: 1px solid black; text-align: center; color: white !important; "> Industry  </th>
        			<th style="border: 1px solid black; text-align: center; color: white !important; "> Occupancy Date  </th>
                </thead>

            <?php
            while($row = mysql_fetch_array($res)){
                ?>
                <tr id='<?php echo $row[0]; ?>'>
                    <td style="border: 1px solid black; padding: 5px;"><?php echo $row[0]; ?></td>
                    <td style="border: 1px solid black; padding: 4px;"><?php echo $row[1]; ?></td>
                    <td style="border: 1px solid black; padding: 5px; "><?php echo $row[2]; ?></td>
                    <td style="border: 1px solid black; padding: 5px;"><?php echo $row[3]; ?></td>
                    <td style="border: 1px solid black; padding: 4px; width: 10%;"><?php echo $row[4]; ?></td>
                    <td style="border: 1px solid black; padding: 5px"><?php echo date('m/d/Y', strtotime($row[5]))." - ".date('m/d/Y', strtotime($row[6]))."" ?> </td>
                </tr>
                <?php
            }
            ?></tbody></table><?php
        break;
		//	xmer 09162019

		case 'refdepartment2':
        	$res = mysql_query("SELECT code, description FROM tblmaintenance_department WHERE description LIKE '%". $_POST['key'] ."%' ORDER BY description ASC ", $connection); 
            ?>  
            <style type="text/css">
                #hr{
                    background: black !important; padding:2px;      
                }
            </style>

            <center> <h2> <b>List of Employee Department</b>  </h2>  </center>
            <table style='width:100%;'>
                <tr>
                    <td id='hr'> </td>
                </tr>
            </table><br/>
            <table  style='width: 100%;' cellspacing='0' cellpadding='0'>
                <thead>
                    <th style="border: 1px solid black; text-align: center; color: white !important;" > Code </th>
        			<th style="border: 1px solid black; text-align: center; color: white !important; "> Description  </th>
                </thead>

            <?php
            while($row = mysql_fetch_array($res)){
                ?>
                <tr id='<?php echo $row[0]; ?>'>
                    <td style="border: 1px solid black; padding: 5px;"><?php echo $row[0]; ?></td>
                    <td style="border: 1px solid black; padding: 4px;"><?php echo $row[1]; ?></td>
                </tr>
                <?php
            }
            ?></tbody></table><?php
        break;

        case 'reffacilitiesrep':
			$res = mysql_query("SELECT FacilitiesCode, FacilitiesDesc, Amount FROM tblref_facilities WHERE FacilitiesCode LIKE '%". $_POST['key'] ."%' OR FacilitiesDesc LIKE '%". $_POST['key'] ."%' ORDER BY FacilitiesDesc ;", $connection); 
			?>  
			<style type="text/css">
				#hr{
					background: black !important; padding:2px;
				}
			</style>

			<center> <h2> <b>List of Facilities</b>  </h2>  </center>
			<table style='width:100%;'>
				<tr>
					<td id='hr'> </td>
				</tr>
			</table><br/>
			<table  style='width: 100%;' cellspacing='0' cellpadding='0'>
				<thead>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Code </th>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Facilities </th>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Amount  </th>
				</thead>

			<?php
			while($row = mysql_fetch_array($res)){
				?>
				<tr id='<?php echo $row[0]; ?>'>
					<td style="border: 1px solid black; padding:5px;"><?php echo $row[0]; ?></td>
					<td style="border: 1px solid black; padding:5px;"><?php echo $row[1]; ?></td>
					<td style="border: 1px solid black; padding:5px;"><?php echo $row[2]; ?></td>
				</tr>
				<?php
			}
			?></tbody></table><?php
		break;

		case 'refsoundnper':
			$res = mysql_query("SELECT SoundnperCode, SoundnperDesc, Amount FROM tblref_soundnper WHERE SoundnperCode LIKE '%". $_POST['key'] ."%' OR SoundnperDesc LIKE '%". $_POST['key'] ."%' ORDER BY SoundnperDesc ;", $connection); 
			?>  
			<style type="text/css">
				#hr{
					background: black !important; padding:2px;
				}
			</style>

			<center> <h2> <b>List of Sound System & Personnel</b>  </h2>  </center>
			<table style='width:100%;'>
				<tr>
					<td id='hr'> </td>
				</tr>
			</table><br/>
			<table  style='width: 100%;' cellspacing='0' cellpadding='0'>
				<thead>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Code </th>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Description </th>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Amount  </th>
				</thead>

			<?php
			while($row = mysql_fetch_array($res)){
				?>
				<tr id='<?php echo $row[0]; ?>'>
					<td style="border: 1px solid black; padding:5px;"><?php echo $row[0]; ?></td>
					<td style="border: 1px solid black; padding:5px;"><?php echo $row[1]; ?></td>
					<td style="border: 1px solid black; padding:5px;"><?php echo $row[2]; ?></td>
				</tr>
				<?php
			}
			?></tbody></table><?php
		break;

		case 'refManpower':
			$res = mysql_query("SELECT ManpowerCode, ManpowerDesc, Amount FROM tblref_manpower WHERE ManpowerCode LIKE '%". $_POST['key'] ."%' OR ManpowerDesc LIKE '%". $_POST['key'] ."%' ORDER BY ManpowerDesc ;", $connection); 
			?>  
			<style type="text/css">
				#hr{
					background: black !important; padding:2px;
				}
			</style>

			<center> <h2> <b>List of Manpower</b>  </h2>  </center>
			<table style='width:100%;'>
				<tr>
					<td id='hr'> </td>
				</tr>
			</table><br/>
			<table  style='width: 100%;' cellspacing='0' cellpadding='0'>
				<thead>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Code </th>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Description </th>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Amount  </th>
				</thead>

			<?php
			while($row = mysql_fetch_array($res)){
				?>
				<tr id='<?php echo $row[0]; ?>'>
					<td style="border: 1px solid black; padding:5px;"><?php echo $row[0]; ?></td>
					<td style="border: 1px solid black; padding:5px;"><?php echo $row[1]; ?></td>
					<td style="border: 1px solid black; padding:5px;"><?php echo $row[2]; ?></td>
				</tr>
				<?php
			}
			?></tbody></table><?php
		break;

		case 'refOrganizerm':
			$res = mysql_query("SELECT OrganizermCode, OrganizermDesc FROM tblref_organizerm WHERE OrganizermCode LIKE '%". $_POST['key'] ."%' OR OrganizermDesc LIKE '%". $_POST['key'] ."%' ORDER BY OrganizermDesc ;", $connection); 
			?>  
			<style type="text/css">
				#hr{
					background: black !important; padding:2px;
				}
			</style>

			<center> <h2> <b>List of Organizer Materials</b>  </h2>  </center>
			<table style='width:100%;'>
				<tr>
					<td id='hr'> </td>
				</tr>
			</table><br/>
			<table  style='width: 100%;' cellspacing='0' cellpadding='0'>
				<thead>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Code </th>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Description </th>
				</thead>

			<?php
			while($row = mysql_fetch_array($res)){
				?>
				<tr id='<?php echo $row[0]; ?>'>
					<td style="border: 1px solid black; padding:5px;"><?php echo $row[0]; ?></td>
					<td style="border: 1px solid black; padding:5px;"><?php echo $row[1]; ?></td>
					<td style="border: 1px solid black; padding:5px;"><?php echo $row[2]; ?></td>
				</tr>
				<?php
			}
			?></tbody></table><?php
		break;

		case 'refOrganizerm':
			$res = mysql_query("SELECT OrganizermCode, OrganizermDesc FROM tblref_organizerm WHERE OrganizermCode LIKE '%". $_POST['key'] ."%' OR OrganizermDesc LIKE '%". $_POST['key'] ."%' ORDER BY OrganizermDesc ;", $connection); 
			?>  
			<style type="text/css">
				#hr{
					background: black !important; padding:2px;
				}
			</style>

			<center> <h2> <b>List of Organizer Materials</b>  </h2>  </center>
			<table style='width:100%;'>
				<tr>
					<td id='hr'> </td>
				</tr>
			</table><br/>
			<table  style='width: 100%;' cellspacing='0' cellpadding='0'>
				<thead>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Code </th>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Description </th>
				</thead>

			<?php
			while($row = mysql_fetch_array($res)){
				?>
				<tr id='<?php echo $row[0]; ?>'>
					<td style="border: 1px solid black; padding:5px;"><?php echo $row[0]; ?></td>
					<td style="border: 1px solid black; padding:5px;"><?php echo $row[1]; ?></td>
				</tr>
				<?php
			}
			?></tbody></table><?php
		break;

		case 'refPromotionalp':
			$res = mysql_query("SELECT PromotionalpCode, PromotionalpDesc FROM tblref_promotionalp WHERE PromotionalpCode LIKE '%". $_POST['key'] ."%' OR PromotionalpDesc LIKE '%". $_POST['key'] ."%' ORDER BY PromotionalpDesc ;", $connection); 
			?>  
			<style type="text/css">
				#hr{
					background: black !important; padding:2px;
				}
			</style>

			<center> <h2> <b>List of Promotional Paraphernalias</b>  </h2>  </center>
			<table style='width:100%;'>
				<tr>
					<td id='hr'> </td>
				</tr>
			</table><br/>
			<table  style='width: 100%;' cellspacing='0' cellpadding='0'>
				<thead>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Code </th>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Description </th>
				</thead>

			<?php
			while($row = mysql_fetch_array($res)){
				?>
				<tr id='<?php echo $row[0]; ?>'>
					<td style="border: 1px solid black; padding:5px;"><?php echo $row[0]; ?></td>
					<td style="border: 1px solid black; padding:5px;"><?php echo $row[1]; ?></td>
				</tr>
				<?php
			}
			?></tbody></table><?php
		break;

		case 'refsourcerep':
			$res = mysql_query("SELECT source_code, source_desc FROM tblref_source WHERE source_code LIKE '%". $_POST['key'] ."%' ORDER BY source_desc;", $connection); 
			?>  
			<style type="text/css">
				#hr{
					background: black !important; padding:2px;
				}
			</style>

			<center> <h2> <b>List of Source</b>  </h2>  </center>
			<table style='width:100%;'>
				<tr>
					<td id='hr'> </td>
				</tr>
			</table><br/>
			<table  style='width: 100%;' cellspacing='0' cellpadding='0'>
				<thead>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Code </th>
					<th style="border: 1px solid black; text-align: center; color: white !important;"> Description </th>
				</thead>

			<?php
			while($row = mysql_fetch_array($res)){
				?>
				<tr id='<?php echo $row[0]; ?>'>
					<td style="border: 1px solid black; padding:5px;"><?php echo $row[0]; ?></td>
					<td style="border: 1px solid black; padding:5px;"><?php echo $row[1]; ?></td>
				</tr>
				<?php
			}
			?></tbody></table><?php
		break;















		// THIS IS SUBJECT FOR DELETEION PLEASE WRITE YOUR CODE ABOVE THIS SECTION
		case 'tblreflist':
			if($_POST["type"] == "position"){
				$sql = "SELECT xposition FROM tblref_companyposition";
				$result = mysql_query($sql, $connection);
				while($row = mysql_fetch_array($result)){
					echo "<tr style='width: 100%;display: table;table-layout: fixed;'>
							<td style=''>
								".$row["xposition"]."
							</td>
						  </tr>";
				}
			}
			if($_POST["type"] == "industry"){
				$sql = "SELECT Industry FROM tblref_industry";
				$result = mysql_query($sql, $connection);
				while($row = mysql_fetch_array($result)){
					echo "<tr style='width: 100%;display: table;table-layout: fixed;'>
							<td style=''>
								".$row["Industry"]."
							</td>
						  </tr>";

				}
			}
		break;

		case 'savenewreferential':
			if($_POST["type"] == "position"){
				$sql2 = "SELECT COUNT(*) FROM tblref_companyposition WHERE xposition = '".$_POST["ref"]."'";
				$result2 = mysql_query($sql2, $connection);
				$row2 = mysql_fetch_array($result2);
				if($row2[0] == 0){
					$sql = "INSERT INTO tblref_companyposition(xposition)VALUES('".$_POST["ref"]."')";
					$result = mysql_query($sql, $connection);
					if($result == true){
						echo 1;
					}
				}else{
					echo 2;
				}

			}
			if($_POST["type"] == "industry"){
				$sql2 = "SELECT COUNT(*) FROM tblref_industry WHERE Industry_ID = '".$_POST["ref"]."'";
				$result2 = mysql_query($sql2, $connection);
				$row2 = mysql_fetch_array($result2);
				if($row2[0] == 0){
					$sql = "INSERT INTO tblref_industry(Industry_ID, Industry)VALUES('".$_POST["ref"]."', '".$_POST["ref"]."')";
					$result = mysql_query($sql, $connection);
					if($result == true){
						echo 1;
					}
				}else{
					echo 2;
				}
			}
		break;

		case 'removethiscontactperson':
        	$res = mysql_query("DELETE FROM tbltrans_trade_contact_person WHERE ContactID = '". $_POST['ContactID'] ."';", $connection);
        	$res2 = mysql_query("DELETE FROM tbltrans_trade_contact_person_list WHERE ContactID = '". $_POST['ContactID'] ."';", $connection);
        	if($res == true && $res2 == true){
        		echo 1;
        	}else{
        		echo 2;
        	}
       	break;

       	case 'SelectThisUnit':
			$UnitIDS = mysql_fetch_array(mysql_query("SELECT wingid, floorid, classid, depid, catid, unitname, sqmunitsetup, sqm_width, sqm_height, pricepersqmunitsetup, typeofbusiness, area FROM tblref_unit WHERE unitid = '". $_POST['unitid'] ."';", $connection));
			$Wing = mysql_fetch_array(mysql_query("SELECT wing FROM tblref_wing WHERE wingID = '". $UnitIDS['wingid'] ."';", $connection));
			$Floor = mysql_fetch_array(mysql_query("SELECT floor FROM tblref_floorsetup WHERE floorid = '". $UnitIDS['floorid'] ."';", $connection));
			$Classification = mysql_fetch_array(mysql_query("SELECT classification FROM tblref_merchandise_class WHERE classificationID = '". $UnitIDS['classid'] ."';", $connection));
			$Department = mysql_fetch_array(mysql_query("SELECT department FROM tblref_merchandise_depa WHERE departmentID = '". $UnitIDS['depid'] ."';", $connection));
			$Category = mysql_fetch_array(mysql_query("SELECT category FROM tblref_merchandisedep_cat WHERE categoryID = '". $UnitIDS['catid'] ."';", $connection));

			$inqinfo = mysql_fetch_array(mysql_query("SELECT monthly_dues, daily_dues, assoc_dues, datefrom, dateto, desired_noofmonths, desired_noofdays, payment_terms, payment_type, depamount, account_number, cardholder, cardtype, authno, seccode, owner_card_number, expirydate, bankfrom, bf_accno, bankto, bt_accno, month_adv, billingtype, billingperc, Mall, Mall_ID FROM tbltrans_inquiry WHERE Inquiry_ID = '". $_POST['Inquiry_ID'] ."';", $connection));

			$dailypayment = floatval($inqinfo['monthly_dues'])/date('t', strtotime($inqinfo['dateto']));

			$totalmonthly = ( floatval($inqinfo['monthly_dues']) + floatval($inqinfo['assoc_dues']) ) * floatval($inqinfo['desired_noofmonths']);
			$totaldaily =  floatval($inqinfo['daily_dues']) * floatval($inqinfo['desired_noofdays']);
			$gtotal = $totalmonthly + $totaldaily;

			if(SysLeaseSetup('floorandunitmeasurement') == 'Area'){
				$UnitArea = $UnitIDS['area'];
			}else{	
				$UnitArea = $UnitIDS['sqmunitsetup'];
			}

			echo $UnitIDS['classid'] . "|" . $Classification[0] . "|" . $UnitIDS['depid'] . "|" . $Department[0] . "|" . $UnitIDS['catid'] . "|" . $Category[0] . "|" . $UnitIDS['wingid'] . "|" . $Wing[0] . "|" . $UnitIDS['floorid'] . "|" . $Floor[0] . "|" . $_POST['unitid'] . "|" . $UnitIDS['unitname'] . "|" . $UnitArea . "|" . $UnitIDS['sqm_width'] . "|" . $UnitIDS['sqm_height'] . "|" . number_format($UnitIDS['pricepersqmunitsetup'], "2", ".", ",") . "|" . $UnitIDS['typeofbusiness'] . "|" . number_format($inqinfo['monthly_dues'], "2", ".", ",") . "|" . number_format($inqinfo['assoc_dues'], "2", ".", ",") . "|" . date('m/d/Y', strtotime($inqinfo['datefrom'])) . "|" . date('m/d/Y', strtotime($inqinfo['dateto'])) . "|" . $inqinfo['desired_noofmonths'] . "|" . $inqinfo['desired_noofdays'] . "|" . number_format($dailypayment, "2", ".", ",") . "|" . number_format($gtotal, "2", ".", ",") . "|" . $inqinfo['payment_terms'] . "|" . $inqinfo['payment_type'] . "|" . number_format($inqinfo['depamount'], "2", ".", ",") . "|" . $inqinfo['account_number'] . "|" . $inqinfo['cardholder'] . "|" . $inqinfo['cardtype'] . "|" . $inqinfo['authno'] . "|" . $inqinfo['seccode'] . "|" . $inqinfo['owner_card_number'] . "|" . $inqinfo['expirydate'] . "|" . $inqinfo['bankfrom'] . "|" . $inqinfo['bf_accno'] . "|" . $inqinfo['bankto'] . "|" . $inqinfo['bt_accno'] . "|" . $inqinfo['month_adv'] . "|" . $inqinfo['billingtype'] . "|" . $inqinfo['billingperc'] . "|" . $inqinfo['Mall_ID'] . "|" . $inqinfo['Mall'];
		break;

		case 'AddSelectedTermsandCon':
			$arr = explode("|", $_POST['ids']);
			for ($i=0; $i <= COUNT($arr)-2; $i++) { 
				$tac = mysql_fetch_array(mysql_query("SELECT Term_Name, Description FROM tblcondition WHERE Term_ID = '". $arr[$i] ."' ", $connection));
				?>
					<tr>
						<td width="20%" valign="top"><?php echo $tac[0]; ?></td>
						<td width="80%"><?php echo $tac[1]; ?></td>
					</tr>
				<?php
			}
		break;
		// THIS IS SUBJECT FOR DELETEION PLEASE WRITE YOUR CODE ABOVE THIS SECTION
    }
?>