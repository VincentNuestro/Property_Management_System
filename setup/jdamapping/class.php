<?php
	session_start();
	include("../../connect.php");
	switch ($_POST['form']){
	// COMPANY
		case 'fncShowJDACompany':
			$page = $_POST['page'];
			$limit = ($page-1) * 20;
			$res = mysql_query("SELECT MallCompanyID, MallCompanyName, JDA_CompanyCode FROM tblref_mallcompany WHERE MallCompanyName LIKE '%". $_POST['key'] ."%' ORDER BY MallCompanyName ASC LIMIT ".$limit.",20;", $connection);
			while ($row = mysql_fetch_array($res)) {
				echo 	"<tr id='". $row['MallCompanyID'] ."|". $row['JDA_CompanyCode'] ."'>
							<td>". $row['MallCompanyID'] ."</td>
							<td>". $row['MallCompanyName'] ."</td>
							<td>". $row['JDA_CompanyCode'] ."</td>
						</tr>";
			}
		break;

		case 'fncLoadJDACompanyEntries':
			if($_POST["page"] == ""){
	            $page = 1;
	        }else{
	            $page = $_POST["page"];
	        }
    		$limit = ($page-1) * 20;
            $rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM tblref_mallcompany WHERE MallCompanyName LIKE '%". $_POST['key'] ."%';", $connection));
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

		case "fncLoadJDACompanyPageNum":
			$page = $_POST["page"];
			$rowCount = mysql_fetch_row(mysql_query("SELECT COUNT(id) FROM tblref_mallcompany WHERE MallCompanyName LIKE '%". $_POST['key'] ."%';", $connection));
			$rowsperpage = 20;
			$range = 1;
			$totalpages = ceil($rowCount[0] / $rowsperpage);
			$prevpage;
			$nextpage;
			// if not on page 1, don't show back links
			if($page > 1 ){
			   	echo "<li style='width:50px !important;' onclick='fncLoadJDACompanyPageFunc(1)'><< First</li>";
			   	$prevpage = $page - 1;
			   	echo "<li style='width:70px !important;' onclick='fncLoadJDACompanyPageFunc(". $prevpage .")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if(($x > 0) && ($x <= $totalpages)){
    			    if($x == $page){
                        echo "<li id='pgJDACompany" . $x . "' class='pgnumJDACompany active' onclick='fncLoadJDACompanyPageFunc(" . $x . ",". $x .")'>" . $x . "</li>";
                    }else{
    			        echo "<li id='pgJDACompany" . $x . "' class='pgnumJDACompany' onclick='fncLoadJDACompanyPageFunc(" . $x . ",". $x .")'>" . $x . "</li>";
                    }
		       	}
		    }
		    if($page < ($totalpages - $range)){
                echo "<li>...</li>";
            }
		    if($page != $totalpages && $rowCount[0] != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='fncLoadJDACompanyPageFunc(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='fncLoadJDACompanyPageFunc(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'fncClickSaveJDACompany':
			$chkifExisting = mysql_num_rows(mysql_query("SELECT id FROM tblref_mallcompany WHERE JDA_CompanyCode = '". mysql_escape_string(strtoupper($_POST['JDACode'])) ."' AND MallCompanyID != '". $_POST['CompanyID'] ."';", $connection));
			if($chkifExisting >= 1){
				echo 2;
			}else{
				$res = mysql_query("UPDATE tblref_mallcompany SET JDA_CompanyCode = '". mysql_escape_string(strtoupper($_POST['JDACode'])) ."' WHERE MallCompanyID = '". $_POST['CompanyID'] ."';", $connection);
				if($res == true){
					echo 1;
				}else{
					echo 3;
				}
			}
		break;
	// COMPANY

	// MALL
		case 'fncShowJDAMall':
			$page = $_POST['page'];
			$limit = ($page-1) * 20;
			$res = mysql_query("SELECT mallid, mallname, corp_ID, JDAMall_Code FROM tblref_mall WHERE mallname LIKE '%". $_POST['key'] ."%' ORDER BY mallname ASC LIMIT ".$limit.",20;", $connection);
			while ($row = mysql_fetch_array($res)) {
				$JDAMallComp = mysql_fetch_array(mysql_query("SELECT MallCompanyName FROM tblref_mallcompany WHERE MallCompanyID = '". $row['corp_ID'] ."';", $connection));
				echo 	"<tr id='". $row['mallid'] ."|". $row['JDAMall_Code'] ."'>
							<td>". $row['mallid'] ."</td>
							<td>". $row['mallname'] ."</td>
							<td>". $JDAMallComp['MallCompanyName'] ."</td>
							<td>". $row['JDAMall_Code'] ."</td>
						</tr>";
			}
		break;

		case 'fncLoadJDAMallEntries':
			if($_POST["page"] == ""){
	            $page = 1;
	        }else{
	            $page = $_POST["page"];
	        }
    		$limit = ($page-1) * 20;
            $rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM tblref_mall WHERE mallname LIKE '%". $_POST['key'] ."%';", $connection));
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

		case "fncLoadJDAMallPageNum":
			$page = $_POST["page"];
			$rowCount = mysql_fetch_row(mysql_query("SELECT COUNT(id) FROM tblref_mall WHERE mallname LIKE '%". $_POST['key'] ."%';", $connection));
			$rowsperpage = 20;
			$range = 1;
			$totalpages = ceil($rowCount[0] / $rowsperpage);
			$prevpage;
			$nextpage;
			// if not on page 1, don't show back links
			if($page > 1 ){
			   	echo "<li style='width:50px !important;' onclick='fncLoadJDAMallPageFunc(1)'><< First</li>";
			   	$prevpage = $page - 1;
			   	echo "<li style='width:70px !important;' onclick='fncLoadJDAMallPageFunc(". $prevpage .")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if(($x > 0) && ($x <= $totalpages)){
    			    if($x == $page){
                        echo "<li id='pgJDAMall" . $x . "' class='pgnumJDAMall active' onclick='fncLoadJDAMallPageFunc(" . $x . ",". $x .")'>" . $x . "</li>";
                    }else{
    			        echo "<li id='pgJDAMall" . $x . "' class='pgnumJDAMall' onclick='fncLoadJDAMallPageFunc(" . $x . ",". $x .")'>" . $x . "</li>";
                    }
		       	}
		    }
		    if($page < ($totalpages - $range)){
                echo "<li>...</li>";
            }
		    if($page != $totalpages && $rowCount[0] != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='fncLoadJDAMallPageFunc(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='fncLoadJDAMallPageFunc(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'fncClickSaveJDAMall':
			$chkifExisting = mysql_num_rows(mysql_query("SELECT id FROM tblref_mall WHERE JDAMall_Code = '". mysql_escape_string(strtoupper($_POST['JDACode'])) ."' AND mallid != '". $_POST['MallID'] ."';", $connection));
			if($chkifExisting >= 1){
				echo 2;
			}else{
				$res = mysql_query("UPDATE tblref_mall SET JDAMall_Code = '". mysql_escape_string(strtoupper($_POST['JDACode'])) ."' WHERE mallid = '". $_POST['MallID'] ."';", $connection);
				if($res == true){
					echo 1;
				}else{
					echo 3;
				}
			}
		break;
	// MALL

	// TENANT
		case 'fncShowJDATenant':
			$page = $_POST['page'];
			$limit = ($page-1) * 20;
			$res = mysql_query("SELECT TenantID, tradename, companyname, JDATenant_Code, isVendor, VendorCode, VendorLocation, JDA_Comp_ID, Beg_Date, Beg_Balance FROM tbltrans_tenants WHERE tradename LIKE '%". $_POST['key'] ."%' ORDER BY tradename ASC LIMIT ".$limit.",20;", $connection);
			while ($row = mysql_fetch_array($res)) {
				if($row['Beg_Date'] == '' || $row['Beg_Date'] == '1970-01-01'){
					$BegDate = "";
				}else{
					$BegDate = date('m/d/Y', strtotime($row['Beg_Date']));
				}
				if($row['isVendor'] == "1"){
					$isVendor = "Yes";
				}else{
					$isVendor = "No";
				}
				echo 	"<tr id='". $row['TenantID'] ."|". $row['JDATenant_Code'] ."|". $row['isVendor'] ."|". $row['VendorCode'] ."|". $row['VendorLocation'] ."|". $row['JDA_Comp_ID'] ."|". $BegDate ."|". number_format($row['Beg_Balance'], 2, '.', ',') ."'>
							<td>". $row['TenantID'] ."</td>
							<td>". $row['tradename'] ."</td>
							<td>". $row['companyname'] ."</td>
							<td>". $row['JDATenant_Code'] ."</td>
							<td>". $isVendor ."</td>
							<td>". $row['VendorCode'] ."</td>
							<td>". $row['VendorLocation'] ."</td>
							<td>". $row['JDA_Comp_ID'] ."</td>
							<td>". $BegDate ."</td>
							<td style='text-align: right;'>". number_format($row['Beg_Balance'], 2, '.', ',') ."</td>
						</tr>";
			}
		break;

		case 'fncLoadJDATenantEntries':
			if($_POST["page"] == ""){
	            $page = 1;
	        }else{
	            $page = $_POST["page"];
	        }
    		$limit = ($page-1) * 20;
            $rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM tbltrans_tenants WHERE tradename LIKE '%". $_POST['key'] ."%';", $connection));
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

		case "fncLoadJDATenantPageNum":
			$page = $_POST["page"];
			$rowCount = mysql_fetch_row(mysql_query("SELECT COUNT(id) FROM tbltrans_tenants WHERE tradename LIKE '%". $_POST['key'] ."%';", $connection));
			$rowsperpage = 20;
			$range = 1;
			$totalpages = ceil($rowCount[0] / $rowsperpage);
			$prevpage;
			$nextpage;
			// if not on page 1, don't show back links
			if($page > 1 ){
			   	echo "<li style='width:50px !important;' onclick='fncLoadJDATenantPageFunc(1)'><< First</li>";
			   	$prevpage = $page - 1;
			   	echo "<li style='width:70px !important;' onclick='fncLoadJDATenantPageFunc(". $prevpage .")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if(($x > 0) && ($x <= $totalpages)){
    			    if($x == $page){
                        echo "<li id='pgJDATenant" . $x . "' class='pgnumJDATenant active' onclick='fncLoadJDATenantPageFunc(" . $x . ",". $x .")'>" . $x . "</li>";
                    }else{
    			        echo "<li id='pgJDATenant" . $x . "' class='pgnumJDATenant' onclick='fncLoadJDATenantPageFunc(" . $x . ",". $x .")'>" . $x . "</li>";
                    }
		       	}
		    }
		    if($page < ($totalpages - $range)){
                echo "<li>...</li>";
            }
		    if($page != $totalpages && $rowCount[0] != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='fncLoadJDATenantPageFunc(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='fncLoadJDATenantPageFunc(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'fncClickSaveJDATenant':
			// $chkifExisting = mysql_num_rows(mysql_query("SELECT id FROM tbltrans_tenants WHERE JDATenant_Code = '". mysql_escape_string(strtoupper($_POST['JDACode'])) ."' AND TenantID != '". $_POST['TenantID'] ."';", $connection));
			// if($chkifExisting >= 1){
			// 	echo 2;
			// }else{
				// $getCompanyID = mysql_fetch_array(mysql_query("SELECT CompanyID FROM tbltrans_tenants WHERE TenantID = '". $_POST['TenantID'] ."'"))
				// $resCompany = mysql_fetch_array(mysql_query("SELECT JDA_Comp_ID FROM tbltrans_company WHERE ", $connection)); 

				$res = mysql_query("UPDATE tbltrans_tenants SET JDATenant_Code = '". mysql_escape_string(strtoupper($_POST['JDACode'])) ."', isVendor = '". $_POST['isVendor'] ."', VendorCode = '". mysql_escape_string(strtoupper($_POST['VendorCode'])) ."', JDA_Comp_ID = '". mysql_escape_string(strtoupper($_POST['CompID'])) ."', Beg_Date = '". date('Y-m-d', strtotime($_POST['Beg_Date'])) ."', Beg_Balance = '". floatval($_POST['Beg_Balance']) ."', VendorLocation = '". mysql_escape_string(strtoupper($_POST['VendorLocation'])) ."' WHERE TenantID = '". $_POST['TenantID'] ."';", $connection);
				if($res == true){
					echo 1;
				}else{
					echo 3;
				}
			// }
		break;
	// TENANT

	// PAYMENT TYPE
		case 'fncShowJDAPaymentType':
			$page = $_POST['page'];
			$limit = ($page-1) * 20;
			$res = mysql_query("SELECT PaymentTypeID, PaymentTypeDesc, PaymentType, JDA_Pay_Code, Dr_COA, Cr_COA FROM tblref_pospaymenttype WHERE PaymentTypeDesc LIKE '%". $_POST['key'] ."%' ORDER BY PaymentTypeDesc ASC LIMIT ".$limit.",20;", $connection);
			while ($row = mysql_fetch_array($res)) {
				echo 	"<tr id='". $row['PaymentTypeID'] ."|". $row['JDA_Pay_Code'] ."|". $row['Dr_COA'] ."|". $row['Cr_COA'] ."'>
							<td>". $row['PaymentTypeID'] ."</td>
							<td>". $row['PaymentTypeDesc'] ."</td>
							<td>". $row['PaymentType'] ."</td>
							<td>". $row['JDA_Pay_Code'] ."</td>
						</tr>";
			}
		break;

		case 'fncLoadJDAPaymentTypeEntries':
			if($_POST["page"] == ""){
	            $page = 1;
	        }else{
	            $page = $_POST["page"];
	        }
    		$limit = ($page-1) * 20;
            $rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM tblref_pospaymenttype WHERE PaymentTypeDesc LIKE '%". $_POST['key'] ."%';", $connection));
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

		case "fncLoadJDAPaymentTypePageNum":
			$page = $_POST["page"];
			$rowCount = mysql_fetch_row(mysql_query("SELECT COUNT(id) FROM tblref_pospaymenttype WHERE PaymentTypeDesc LIKE '%". $_POST['key'] ."%';", $connection));
			$rowsperpage = 20;
			$range = 1;
			$totalpages = ceil($rowCount[0] / $rowsperpage);
			$prevpage;
			$nextpage;
			// if not on page 1, don't show back links
			if($page > 1 ){
			   	echo "<li style='width:50px !important;' onclick='fncLoadJDAPaymentTypePageFunc(1)'><< First</li>";
			   	$prevpage = $page - 1;
			   	echo "<li style='width:70px !important;' onclick='fncLoadJDAPaymentTypePageFunc(". $prevpage .")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if(($x > 0) && ($x <= $totalpages)){
    			    if($x == $page){
                        echo "<li id='pgJDAPaymentType" . $x . "' class='pgnumJDAPaymentType active' onclick='fncLoadJDAPaymentTypePageFunc(" . $x . ",". $x .")'>" . $x . "</li>";
                    }else{
    			        echo "<li id='pgJDAPaymentType" . $x . "' class='pgnumJDAPaymentType' onclick='fncLoadJDAPaymentTypePageFunc(" . $x . ",". $x .")'>" . $x . "</li>";
                    }
		       	}
		    }
		    if($page < ($totalpages - $range)){
                echo "<li>...</li>";
            }
		    if($page != $totalpages && $rowCount[0] != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='fncLoadJDAPaymentTypePageFunc(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='fncLoadJDAPaymentTypePageFunc(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'fncClickSaveJDAPaymentType':
			$chkifExisting = mysql_num_rows(mysql_query("SELECT id FROM tblref_pospaymenttype WHERE JDAPaymentType_Code = '". mysql_escape_string(strtoupper($_POST['JDACode'])) ."' AND PaymentTypeID != '". $_POST['PaymentTypeID'] ."';", $connection));
			if($chkifExisting >= 1){
				echo 2;
			}else{
				$res = mysql_query("UPDATE tblref_pospaymenttype SET JDA_Pay_Code = '". mysql_escape_string(strtoupper($_POST['JDA_Pay_Code'])) ."', Dr_COA = '". mysql_escape_string(strtoupper($_POST['Dr_COA'])) ."', Cr_COA = '". mysql_escape_string(strtoupper($_POST['Cr_COA'])) ."' WHERE PaymentTypeID = '". $_POST['PaymentTypeID'] ."';", $connection);
				if($res == true){
					echo 1;
				}else{
					echo 3;
				}
			}
		break;
	// PAYMENT TYPE

	// Maintenance
		case 'fncShowJDAMaintenance':
			$page = $_POST['page'];
			$limit = ($page-1) * 20;
			$res = mysql_query("SELECT xcategory, taskid, description, LssrMjr, LssrMnr, LssrCOAStore, VndrMjr, VndrMnr, VndrCOAStore, WthTaxRate FROM tblmaintenance_tasklist WHERE description LIKE '%". $_POST['key'] ."%' ORDER BY description ASC LIMIT ".$limit.",20;", $connection);
			while ($row = mysql_fetch_array($res)) {
				$Category = mysql_fetch_array(mysql_query("SELECT category FROM tblmaintenance_category WHERE category_id = '". $row['xcategory'] ."';", $connection));
				echo 	"<tr id='". $row['taskid'] ."|". $row['LssrMjr'] ."|". $row['LssrMnr'] ."|". $row['LssrCOAStore'] ."|". $row['VndrMjr'] ."|". $row['VndrMnr'] ."|". $row['VndrCOAStore'] ."|". number_format($row['WthTaxRate'], 2, '.', ',') ."'>
							<td>". $Category['category'] ."</td>
							<td>". $row['taskid'] ."</td>
							<td>". $row['description'] ."</td>
							<td>". $row['LssrMjr'] ."</td>
							<td>". $row['LssrMnr'] ."</td>
							<td>". $row['LssrCOAStore'] ."</td>
							<td>". $row['VndrMjr'] ."</td>
							<td>". $row['VndrMnr'] ."</td>
							<td>". $row['VndrCOAStore'] ."</td>
							<td style='text-align: right;'>". number_format($row['WthTaxRate'], 2, '.', ',') ."</td>
						</tr>";
			}
		break;

		case 'fncLoadJDAMaintenanceEntries':
			if($_POST["page"] == ""){
	            $page = 1;
	        }else{
	            $page = $_POST["page"];
	        }
    		$limit = ($page-1) * 20;
            $rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM tblmaintenance_tasklist WHERE description LIKE '%". $_POST['key'] ."%';", $connection));
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

		case "fncLoadJDAMaintenancePageNum":
			$page = $_POST["page"];
			$rowCount = mysql_fetch_row(mysql_query("SELECT COUNT(id) FROM tblmaintenance_tasklist WHERE description LIKE '%". $_POST['key'] ."%';", $connection));
			$rowsperpage = 20;
			$range = 1;
			$totalpages = ceil($rowCount[0] / $rowsperpage);
			$prevpage;
			$nextpage;
			// if not on page 1, don't show back links
			if($page > 1 ){
			   	echo "<li style='width:50px !important;' onclick='fncLoadJDAMaintenancePageFunc(1)'><< First</li>";
			   	$prevpage = $page - 1;
			   	echo "<li style='width:70px !important;' onclick='fncLoadJDAMaintenancePageFunc(". $prevpage .")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if(($x > 0) && ($x <= $totalpages)){
    			    if($x == $page){
                        echo "<li id='pgJDAMaintenance" . $x . "' class='pgnumJDAMaintenance active' onclick='fncLoadJDAMaintenancePageFunc(" . $x . ",". $x .")'>" . $x . "</li>";
                    }else{
    			        echo "<li id='pgJDAMaintenance" . $x . "' class='pgnumJDAMaintenance' onclick='fncLoadJDAMaintenancePageFunc(" . $x . ",". $x .")'>" . $x . "</li>";
                    }
		       	}
		    }
		    if($page < ($totalpages - $range)){
                echo "<li>...</li>";
            }
		    if($page != $totalpages && $rowCount[0] != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='fncLoadJDAMaintenancePageFunc(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='fncLoadJDAMaintenancePageFunc(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'fncClickSaveJDAMaintenance':
			$chkifExisting = mysql_num_rows(mysql_query("SELECT id FROM tblmaintenance_tasklist WHERE JDACharges_Code = '". mysql_escape_string(strtoupper($_POST['JDACode'])) ."' AND taskid != '". $_POST['TaskID'] ."';", $connection));
			if($chkifExisting >= 1){
				echo 2;
			}else{
				$res = mysql_query("UPDATE tblmaintenance_tasklist SET LssrMjr = '". mysql_escape_string(strtoupper($_POST['LssrMjr'])) ."', LssrMnr = '". mysql_escape_string(strtoupper($_POST['LssrMnr'])) ."', LssrCOAStore = '". mysql_escape_string(strtoupper($_POST['LssrCOAStore'])) ."', VndrMjr = '". mysql_escape_string(strtoupper($_POST['VndrMjr'])) ."', VndrMnr = '". mysql_escape_string(strtoupper($_POST['VndrMnr'])) ."', VndrCOAStore = '". mysql_escape_string(strtoupper($_POST['VndrCOAStore'])) ."', WthTaxRate = '". floatval($_POST['WthTaxRate']) ."' WHERE taskid = '". $_POST['TaskID'] ."';", $connection);
				if($res == true){
					echo 1;
				}else{
					echo 3;
				}
			}
		break;
	// Maintenance

	// CHARGES
		case 'fncShowJDACharges':
			$page = $_POST['page'];
			$limit = ($page-1) * 20;
			$res = mysql_query("SELECT CHARGE_ID, CHARGE_DESC, LssrMjr, LssrMnr, LssrCOAStore, VndrMjr, VndrMnr, VndrCOAStore, WthTaxRate FROM tblref_refcharges WHERE CHARGE_DESC LIKE '%". $_POST['key'] ."%' ORDER BY CHARGE_DESC ASC LIMIT ".$limit.",20;", $connection);
			while ($row = mysql_fetch_array($res)) {
				echo 	"<tr id='". $row['CHARGE_ID'] ."|". $row['LssrMjr'] ."|". $row['LssrMnr'] ."|". $row['LssrCOAStore'] ."|". $row['VndrMjr'] ."|". $row['VndrMnr'] ."|". $row['VndrCOAStore'] ."|". number_format($row['WthTaxRate'], 2, '.', ',') ."'>
							<td>". $row['CHARGE_ID'] ."</td>
							<td>". $row['CHARGE_DESC'] ."</td>
							<td>". $row['LssrMjr'] ."</td>
							<td>". $row['LssrMnr'] ."</td>
							<td>". $row['LssrCOAStore'] ."</td>
							<td>". $row['VndrMjr'] ."</td>
							<td>". $row['VndrMnr'] ."</td>
							<td>". $row['VndrCOAStore'] ."</td>
							<td style='text-align: right;'>". number_format($row['WthTaxRate'], 2, '.', ',') ."</td>
						</tr>";
			}
		break;

		case 'fncLoadJDAChargesEntries':
			if($_POST["page"] == ""){
	            $page = 1;
	        }else{
	            $page = $_POST["page"];
	        }
    		$limit = ($page-1) * 20;
            $rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM tblref_refcharges WHERE CHARGE_DESC LIKE '%". $_POST['key'] ."%';", $connection));
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

		case "fncLoadJDAChargesPageNum":
			$page = $_POST["page"];
			$rowCount = mysql_fetch_row(mysql_query("SELECT COUNT(id) FROM tblref_refcharges WHERE CHARGE_DESC LIKE '%". $_POST['key'] ."%';", $connection));
			$rowsperpage = 20;
			$range = 1;
			$totalpages = ceil($rowCount[0] / $rowsperpage);
			$prevpage;
			$nextpage;
			// if not on page 1, don't show back links
			if($page > 1 ){
			   	echo "<li style='width:50px !important;' onclick='fncLoadJDAChargesPageFunc(1)'><< First</li>";
			   	$prevpage = $page - 1;
			   	echo "<li style='width:70px !important;' onclick='fncLoadJDAChargesPageFunc(". $prevpage .")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if(($x > 0) && ($x <= $totalpages)){
    			    if($x == $page){
                        echo "<li id='pgJDACharges" . $x . "' class='pgnumJDACharges active' onclick='fncLoadJDAChargesPageFunc(" . $x . ",". $x .")'>" . $x . "</li>";
                    }else{
    			        echo "<li id='pgJDACharges" . $x . "' class='pgnumJDACharges' onclick='fncLoadJDAChargesPageFunc(" . $x . ",". $x .")'>" . $x . "</li>";
                    }
		       	}
		    }
		    if($page < ($totalpages - $range)){
                echo "<li>...</li>";
            }
		    if($page != $totalpages && $rowCount[0] != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='fncLoadJDAChargesPageFunc(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='fncLoadJDAChargesPageFunc(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'fncClickSaveJDACharges':
			$chkifExisting = mysql_num_rows(mysql_query("SELECT id FROM tblref_refcharges WHERE JDACharges_Code = '". mysql_escape_string(strtoupper($_POST['JDACode'])) ."' AND CHARGE_ID != '". $_POST['ChargesID'] ."';", $connection));
			if($chkifExisting >= 1){
				echo 2;
			}else{
				$res = mysql_query("UPDATE tblref_refcharges SET LssrMjr = '". mysql_escape_string(strtoupper($_POST['LssrMjr'])) ."', LssrMnr = '". mysql_escape_string(strtoupper($_POST['LssrMnr'])) ."', LssrCOAStore = '". mysql_escape_string(strtoupper($_POST['LssrCOAStore'])) ."', VndrMjr = '". mysql_escape_string(strtoupper($_POST['VndrMjr'])) ."', VndrMnr = '". mysql_escape_string(strtoupper($_POST['VndrMnr'])) ."', VndrCOAStore = '". mysql_escape_string(strtoupper($_POST['VndrCOAStore'])) ."', WthTaxRate = '". floatval($_POST['WthTaxRate']) ."' WHERE CHARGE_ID = '". $_POST['ChargesID'] ."';", $connection);
				if($res == true){
					echo 1;
				}else{
					echo 3;
				}
			}
		break;
	// CHARGES

	// VIOLATIONS
		case 'fncShowJDAViolations':
			$page = $_POST['page'];
			$limit = ($page-1) * 20;
			$res = mysql_query("SELECT Code, Violation, LssrMjr, LssrMnr, LssrCOAStore, VndrMjr, VndrMnr, VndrCOAStore, WthTaxRate FROM tblmaintenance_houserules WHERE Violation LIKE '%". $_POST['key'] ."%' ORDER BY Violation ASC LIMIT ".$limit.",20;", $connection);
			while ($row = mysql_fetch_array($res)) {
				echo 	"<tr id='". $row['Code'] ."|". $row['LssrMjr'] ."|". $row['LssrMnr'] ."|". $row['LssrCOAStore'] ."|". $row['VndrMjr'] ."|". $row['VndrMnr'] ."|". $row['VndrCOAStore'] ."|". number_format($row['WthTaxRate'], 2, '.', ',') ."'>
							<td>". $row['Code'] ."</td>
							<td>". $row['Violation'] ."</td>
							<td>". $row['LssrMjr'] ."</td>
							<td>". $row['LssrMnr'] ."</td>
							<td>". $row['LssrCOAStore'] ."</td>
							<td>". $row['VndrMjr'] ."</td>
							<td>". $row['VndrMnr'] ."</td>
							<td>". $row['VndrCOAStore'] ."</td>
							<td style='text-align: right;'>". number_format($row['WthTaxRate'], 2, '.', ',') ."</td>
						</tr>";
			}
		break;

		case 'fncLoadJDAViolationsEntries':
			if($_POST["page"] == ""){
	            $page = 1;
	        }else{
	            $page = $_POST["page"];
	        }
    		$limit = ($page-1) * 20;
            $rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM tblmaintenance_houserules WHERE Violation LIKE '%". $_POST['key'] ."%';", $connection));
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

		case "fncLoadJDAViolationsPageNum":
			$page = $_POST["page"];
			$rowCount = mysql_fetch_row(mysql_query("SELECT COUNT(id) FROM tblmaintenance_houserules WHERE Violation LIKE '%". $_POST['key'] ."%';", $connection));
			$rowsperpage = 20;
			$range = 1;
			$totalpages = ceil($rowCount[0] / $rowsperpage);
			$prevpage;
			$nextpage;
			// if not on page 1, don't show back links
			if($page > 1 ){
			   	echo "<li style='width:50px !important;' onclick='fncLoadJDAViolationsPageFunc(1)'><< First</li>";
			   	$prevpage = $page - 1;
			   	echo "<li style='width:70px !important;' onclick='fncLoadJDAViolationsPageFunc(". $prevpage .")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if(($x > 0) && ($x <= $totalpages)){
    			    if($x == $page){
                        echo "<li id='pgJDAViolations" . $x . "' class='pgnumJDAViolations active' onclick='fncLoadJDAViolationsPageFunc(" . $x . ",". $x .")'>" . $x . "</li>";
                    }else{
    			        echo "<li id='pgJDAViolations" . $x . "' class='pgnumJDAViolations' onclick='fncLoadJDAViolationsPageFunc(" . $x . ",". $x .")'>" . $x . "</li>";
                    }
		       	}
		    }
		    if($page < ($totalpages - $range)){
                echo "<li>...</li>";
            }
		    if($page != $totalpages && $rowCount[0] != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='fncLoadJDAViolationsPageFunc(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='fncLoadJDAViolationsPageFunc(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'fncClickSaveJDAViolations':
			$chkifExisting = mysql_num_rows(mysql_query("SELECT id FROM tblmaintenance_houserules WHERE JDAViolations_Code = '". mysql_escape_string(strtoupper($_POST['JDACode'])) ."' AND Code != '". $_POST['ViolationsID'] ."';", $connection));
			if($chkifExisting >= 1){
				echo 2;
			}else{
				$res = mysql_query("UPDATE tblmaintenance_houserules SET LssrMjr = '". mysql_escape_string(strtoupper($_POST['LssrMjr'])) ."', LssrMnr = '". mysql_escape_string(strtoupper($_POST['LssrMnr'])) ."', LssrCOAStore = '". mysql_escape_string(strtoupper($_POST['LssrCOAStore'])) ."', VndrMjr = '". mysql_escape_string(strtoupper($_POST['VndrMjr'])) ."', VndrMnr = '". mysql_escape_string(strtoupper($_POST['VndrMnr'])) ."', VndrCOAStore = '". mysql_escape_string(strtoupper($_POST['VndrCOAStore'])) ."', WthTaxRate = '". floatval($_POST['WthTaxRate']) ."' WHERE Code = '". $_POST['ViolationsID'] ."';", $connection);
				if($res == true){
					echo 1;
				}else{
					echo 3;
				}
			}
		break;
	// VIOLATIONS

	// PENALTIES
		case 'fncShowJDAPenalties':
			$page = $_POST['page'];
			$limit = ($page-1) * 20;
			$res = mysql_query("SELECT PenaltyCode, PenaltyDesc, LssrMjr, LssrMnr, LssrCOAStore, VndrMjr, VndrMnr, VndrCOAStore, WthTaxRate FROM tblref_penalty WHERE PenaltyDesc LIKE '%". $_POST['key'] ."%' ORDER BY PenaltyDesc ASC LIMIT ".$limit.",20;", $connection);
			while ($row = mysql_fetch_array($res)) {
				echo 	"<tr id='". $row['PenaltyCode'] ."|". $row['LssrMjr'] ."|". $row['LssrMnr'] ."|". $row['LssrCOAStore'] ."|". $row['VndrMjr'] ."|". $row['VndrMnr'] ."|". $row['VndrCOAStore'] ."|". number_format($row['WthTaxRate'], 2, '.', ',') ."'>
							<td>". $row['PenaltyCode'] ."</td>
							<td>". $row['PenaltyDesc'] ."</td>
							<td>". $row['LssrMjr'] ."</td>
							<td>". $row['LssrMnr'] ."</td>
							<td>". $row['LssrCOAStore'] ."</td>
							<td>". $row['VndrMjr'] ."</td>
							<td>". $row['VndrMnr'] ."</td>
							<td>". $row['VndrCOAStore'] ."</td>
							<td style='text-align: right;'>". number_format($row['WthTaxRate'], 2, '.', ',') ."</td>
						</tr>";
			}
		break;

		case 'fncLoadJDAPenaltiesEntries':
			if($_POST["page"] == ""){
	            $page = 1;
	        }else{
	            $page = $_POST["page"];
	        }
    		$limit = ($page-1) * 20;
            $rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM tblref_penalty WHERE Violation LIKE '%". $_POST['key'] ."%';", $connection));
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

		case "fncLoadJDAPenaltiesPageNum":
			$page = $_POST["page"];
			$rowCount = mysql_fetch_row(mysql_query("SELECT COUNT(id) FROM tblref_penalty WHERE Violation LIKE '%". $_POST['key'] ."%';", $connection));
			$rowsperpage = 20;
			$range = 1;
			$totalpages = ceil($rowCount[0] / $rowsperpage);
			$prevpage;
			$nextpage;
			// if not on page 1, don't show back links
			if($page > 1 ){
			   	echo "<li style='width:50px !important;' onclick='fncLoadJDAPenaltiesPageFunc(1)'><< First</li>";
			   	$prevpage = $page - 1;
			   	echo "<li style='width:70px !important;' onclick='fncLoadJDAPenaltiesPageFunc(". $prevpage .")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if(($x > 0) && ($x <= $totalpages)){
    			    if($x == $page){
                        echo "<li id='pgJDAPenalties" . $x . "' class='pgnumJDAPenalties active' onclick='fncLoadJDAPenaltiesPageFunc(" . $x . ",". $x .")'>" . $x . "</li>";
                    }else{
    			        echo "<li id='pgJDAPenalties" . $x . "' class='pgnumJDAPenalties' onclick='fncLoadJDAPenaltiesPageFunc(" . $x . ",". $x .")'>" . $x . "</li>";
                    }
		       	}
		    }
		    if($page < ($totalpages - $range)){
                echo "<li>...</li>";
            }
		    if($page != $totalpages && $rowCount[0] != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='fncLoadJDAPenaltiesPageFunc(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='fncLoadJDAPenaltiesPageFunc(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'fncClickSaveJDAPenalties':
			$chkifExisting = mysql_num_rows(mysql_query("SELECT id FROM tblref_penalty WHERE JDA_Penalty_Code = '". mysql_escape_string(strtoupper($_POST['JDA_Penalty_Code'])) ."' AND PenaltyCode != '". $_POST['PenaltiesID'] ."';", $connection));
			if($chkifExisting >= 1){
				echo 2;
			}else{
				$res = mysql_query("UPDATE tblref_penalty SET LssrMjr = '". mysql_escape_string(strtoupper($_POST['LssrMjr'])) ."', LssrMnr = '". mysql_escape_string(strtoupper($_POST['LssrMnr'])) ."', LssrCOAStore = '". mysql_escape_string(strtoupper($_POST['LssrCOAStore'])) ."', VndrMjr = '". mysql_escape_string(strtoupper($_POST['VndrMjr'])) ."', VndrMnr = '". mysql_escape_string(strtoupper($_POST['VndrMnr'])) ."', VndrCOAStore = '". mysql_escape_string(strtoupper($_POST['VndrCOAStore'])) ."', WthTaxRate = '". floatval($_POST['WthTaxRate']) ."' WHERE PenaltyCode = '". $_POST['PenaltiesID'] ."';", $connection);
				if($res == true){
					echo 1;
				}else{
					echo 3;
				}
			}
		break;
	// PENALTIES

	// CHARGES
		case 'fncShowJDAEvents':
			$page = $_POST['page'];
			$limit = ($page-1) * 20;
			$res = mysql_query("SELECT EVCode, EVDesc, LssrMjr, LssrMnr, LssrCOAStore, VndrMjr, VndrMnr, VndrCOAStore, WthTaxRate, id FROM tbltrans_events WHERE EVDesc LIKE '%". $_POST['key'] ."%' ORDER BY EVDesc ASC LIMIT ".$limit.",20;", $connection);
			while ($row = mysql_fetch_array($res)) {
				echo 	"<tr id='". $row['id'] ."|". $row['EVCode'] ."|". $row['LssrMjr'] ."|". $row['LssrMnr'] ."|" . $row['LssrCOAStore'] ."|". $row['VndrMjr'] ."|". $row['VndrMnr'] ."|". $row['VndrCOAStore'] ."|". number_format($row['WthTaxRate'], 2, '.', ',') ."'>
							<td>". $row['EVCode'] ."</td>
							<td>". $row['EVDesc'] ."</td>
							<td>". $row['LssrMjr'] ."</td>
							<td>". $row['LssrMnr'] ."</td>
							<td>". $row['LssrCOAStore'] ."</td>
							<td>". $row['VndrMjr'] ."</td>
							<td>". $row['VndrMnr'] ."</td>
							<td>". $row['VndrCOAStore'] ."</td>
							<td style='text-align: right;'>". number_format($row['WthTaxRate'], 2, '.', ',') ."</td>
						</tr>";

			}
		break;

		case 'fncLoadJDAEventsEntries':
			if($_POST["page"] == ""){
	            $page = 1;
	        }else{
	            $page = $_POST["page"];
	        }
    		$limit = ($page-1) * 20;
            $rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM tbltrans_events WHERE EVDesc LIKE '%". $_POST['key'] ."%';", $connection));
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

		case "fncLoadJDAEventsPageNum":
			$page = $_POST["page"];
			$rowCount = mysql_fetch_row(mysql_query("SELECT COUNT(id) FROM tbltrans_events WHERE EVDesc LIKE '%". $_POST['key'] ."%';", $connection));
			$rowsperpage = 20;
			$range = 1;
			$totalpages = ceil($rowCount[0] / $rowsperpage);
			$prevpage;
			$nextpage;
			// if not on page 1, don't show back links
			if($page > 1 ){
			   	echo "<li style='width:50px !important;' onclick='fncLoadJDAEventsPageFunc(1)'><< First</li>";
			   	$prevpage = $page - 1;
			   	echo "<li style='width:70px !important;' onclick='fncLoadJDAEventsPageFunc(". $prevpage .")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if(($x > 0) && ($x <= $totalpages)){
    			    if($x == $page){
                        echo "<li id='pgJDAEvents" . $x . "' class='pgnumJDAEvents active' onclick='fncLoadJDAEventsPageFunc(" . $x . ",". $x .")'>" . $x . "</li>";
                    }else{
    			        echo "<li id='pgJDAEvents" . $x . "' class='pgnumJDAEvents' onclick='fncLoadJDAEventsPageFunc(" . $x . ",". $x .")'>" . $x . "</li>";
                    }
		       	}
		    }
		    if($page < ($totalpages - $range)){
                echo "<li>...</li>";
            }
		    if($page != $totalpages && $rowCount[0] != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='fncLoadJDAEventsPageFunc(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='fncLoadJDAEventsPageFunc(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'fncClickSaveJDAEvents':
			$chkifExisting = mysql_num_rows(mysql_query("SELECT id FROM tbltrans_events;", $connection));
			if($chkifExisting == 0){
				$res = mysql_query("INSERT INTO tbltrans_events SET EVCode = '". mysql_escape_string(strtoupper($_POST['EventCode'])) ."', EVDesc = '". mysql_escape_string(strtoupper($_POST['EventDesc'])) ."', LssrMjr = '". mysql_escape_string(strtoupper($_POST['LssrMjr'])) ."', LssrMnr = '". mysql_escape_string(strtoupper($_POST['LssrMnr'])) ."', LssrCOAStore = '". mysql_escape_string(strtoupper($_POST['LssrCOAStore'])) ."', VndrMjr = '". mysql_escape_string(strtoupper($_POST['VndrMjr'])) ."', VndrMnr = '". mysql_escape_string(strtoupper($_POST['VndrMnr'])) ."', VndrCOAStore = '". mysql_escape_string(strtoupper($_POST['VndrCOAStore'])) ."', WthTaxRate = '". floatval($_POST['WthTaxRate']) ."';", $connection);
				if($res == true){
					echo 1;
				}else{
					echo 3;
				}
			}else{
				$res = mysql_query("UPDATE tbltrans_events SET EVCode = '". mysql_escape_string(strtoupper($_POST['EventCode'])) ."', LssrMjr = '". mysql_escape_string(strtoupper($_POST['LssrMjr'])) ."', LssrMnr = '". mysql_escape_string(strtoupper($_POST['LssrMnr'])) ."', LssrCOAStore = '". mysql_escape_string(strtoupper($_POST['LssrCOAStore'])) ."', VndrMjr = '". mysql_escape_string(strtoupper($_POST['VndrMjr'])) ."', VndrMnr = '". mysql_escape_string(strtoupper($_POST['VndrMnr'])) ."', VndrCOAStore = '". mysql_escape_string(strtoupper($_POST['VndrCOAStore'])) ."', WthTaxRate = '". floatval($_POST['WthTaxRate']) ."';", $connection);
				if($res == true){
					echo 1;
				}else{
					echo 3;
				}
			}
		break;
	// CHARGES
	}
?>
