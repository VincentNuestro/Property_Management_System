<?php
	session_start();
	include("../../connect.php");
	switch($_POST['form']){
		case 'fncShowAssetList':
			$page = $_POST['page'];
			$limit = ($page-1) * 20;
			$res = mysql_query("SELECT AssetNo, AssetDesc, Ownership, AcqusitionDate, AssetStatus, AssetImage FROM tblref_asset WHERE AssetNo LIKE '%". $_POST['key'] ."%' OR AssetDesc LIKE '%". $_POST['key'] ."%' OR Ownership LIKE '%". $_POST['key'] ."%' ORDER BY AcqusitionDate DESC LIMIT ". $limit .",20;", $connection);
			while($row = mysql_fetch_array($res)){
				if($row['AssetImage'] == ""){
					$AssetImage = "assets/images/noimage5.png";
				}else{
					if(!file_exists("../../../Mall_Attachments/Asset/". $row['AssetImage'])){ 
		            	$AssetImage = "assets/images/noimage5.png";
					}else{
						$AssetImage = "../Mall_Attachments/Asset/". $row['AssetImage'];
					}
				}
				echo 	"<tr>
							<td><img class='editable img-responsive img-circle img-thumbnail' src='". $AssetImage ."' style='height: 80px;width: 100%;'></td>
							<td style='vertical-align: middle;'>". $row['AssetNo'] ."</td>
							<td style='vertical-align: middle;'>". $row['AssetDesc'] ."</td>
							<td style='vertical-align: middle;'>". $row['Ownership'] ."</td>
							<td style='vertical-align: middle;'>". date('m/d/Y', strtotime($row['AcqusitionDate'])) ."</td>
							<td style='vertical-align: middle;'>". $row['AssetStatus'] ."</td>
							<td style='text-align: center; vertical-align: middle;''>
								<div class='btn-group'>
									<button class='btn btn-sm btn-info btn-round' title='View Asset Information' onclick='editAssetInfo(\"". $row['AssetNo'] ."\")' style='margin: 2px;'><img src='assets/images/edit.png' style='width: 100%; height: auto;' /></button>
									<button class='btn btn-sm btn-round' title='View Asset Information' onclick='openmdlAssetInfo(\"". $row['AssetNo'] ."\")' style='margin: 2px;'><img src='assets/images/view.png' style='width: 100%; height: auto;' /></button>
								</div>
							</td>
						</tr>";
			}
		break;

		case 'fncAssetListEntries':
	        if($_POST["page"] == ""){
	            $page = 1;
	        }else{
	            $page = $_POST["page"];
	        }
          	$limit = ($page-1) * 20;
            $rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM tblref_asset WHERE AssetNo LIKE '%". $_POST['key'] ."%' OR AssetDesc LIKE '%". $_POST['key'] ."%' OR Ownership LIKE '%". $_POST['key'] ."%';", $connection));
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

		case "fncAssetListPage":
	    	$page = $_POST["page"];
			$rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM tblref_asset WHERE AssetNo LIKE '%". $_POST['key'] ."%' OR AssetDesc LIKE '%". $_POST['key'] ."%' OR Ownership LIKE '%". $_POST['key'] ."%';", $connection));
			$rowsperpage = 20;
			$range = 3;
			$totalpages = ceil($rowCount[0] / $rowsperpage);
			$prevpage;
			$nextpage;
			if($page > 1 ){
			   	echo "<li style='width:50px !important;' onclick='fncAssetListPageFunc(1)'><< First</li>";
			   	$prevpage = $page - 1;
			   	echo "<li style='width:70px !important;' onclick='fncAssetListPageFunc(". $prevpage .")'>< Previous</li>";
			}

			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   	if(($x > 0) && ($x <= $totalpages)){
    			    if($x == $page){
                        echo "<li id='pgAssetList" . $x . "' class='pgNumAssetList active' onclick='fncAssetListPageFunc(" . $x . ",". $x .")'>" . $x . "</li>";
                    }else{
    			        echo "<li id='pgAssetList" . $x . "' class='pgNumAssetList' onclick='fncAssetListPageFunc(" . $x . ",". $x .")'>" . $x . "</li>";
                    }
		        }
		    }
		    if($page < ($totalpages - $range)){
                echo "<li>...</li>";
            }

		    if($page != $totalpages && $rowCount[0] != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='fncAssetListPageFunc(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='fncAssetListPageFunc(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'fncSaveAsset':
			if($_POST['isEdit'] == "New Asset"){
				$CheckAssetNo = mysql_fetch_row(mysql_query("SELECT COUNT(AssetNo) FROM tblref_asset WHERE AssetNo = '". $_POST['ControlNo'] ."'", $connection));
				if($CheckAssetNo[0] == 0){
					$res = mysql_query("INSERT INTO tblref_asset SET AssetNo = '". $_POST['ControlNo'] ."', AssetDesc = '". $_POST['AssetName'] ."', AssetCategory = '". $_POST['Category'] ."', AssetClass = '". $_POST['Class'] ."', AssetBrand = '". $_POST['Brand'] ."', AssetColor = '". $_POST['Color'] ."', AssetSerial = '". $_POST['Serial'] ."', AssetBarcode = '". $_POST['Barcode'] ."', AssetSupplier = '". $_POST['Supplier'] ."', AssetDimension = '". $_POST['AssetDimension'] ."', AssetStatus = '". $_POST['Status'] ."', AssetDepartment = '". $_POST['Department'] ."', AssetHolder = '". $_POST['AssetHolder'] ."', AssetLocation = '". $_POST['Location'] ."', AssetQuantity = '". $_POST['AssetQuantity'] ."', AssetUnits = '". $_POST['AssetUnit'] ."', AcquisitionAmount = '". $_POST['AcquisitionAmount'] ."', LifeInYears = '". $_POST['LifeinYears'] ."', DepreciatedCost = '". $_POST['DepreciatedCost'] ."', SalvageAmount = '". $_POST['SalvageAmount'] ."', ParentUnit = '". $_POST['ParentUnit'] ."', AcqusitionDate = '". date('Y-m-d', strtotime($_POST['AcquisitionDate'])) ."', Ownership = '". $_POST['Ownership'] ."';", $connection);
					if($res == true){
						echo "1|New asset successfully saved.";
					}else{
						echo "2|Failed to save new asset.";
					}
				}else{
					echo "2|Asset control number already exists.";
				}
			}else{
				$res = mysql_query("UPDATE tblref_asset SET AssetDesc = '". $_POST['AssetName'] ."', AssetCategory = '". $_POST['Category'] ."', AssetClass = '". $_POST['Class'] ."', AssetBrand = '". $_POST['Brand'] ."', AssetColor = '". $_POST['Color'] ."', AssetSerial = '". $_POST['Serial'] ."', AssetBarcode = '". $_POST['Barcode'] ."', AssetSupplier = '". $_POST['Supplier'] ."', AssetDimension = '". $_POST['AssetDimension'] ."', AssetStatus = '". $_POST['Status'] ."', AssetDepartment = '". $_POST['Department'] ."', AssetHolder = '". $_POST['AssetHolder'] ."', AssetLocation = '". $_POST['Location'] ."', AssetQuantity = '". $_POST['AssetQuantity'] ."', AssetUnits = '". $_POST['AssetUnit'] ."', AcquisitionAmount = '". $_POST['AcquisitionAmount'] ."', LifeInYears = '". $_POST['LifeinYears'] ."', DepreciatedCost = '". $_POST['DepreciatedCost'] ."', SalvageAmount = '". $_POST['SalvageAmount'] ."', ParentUnit = '". $_POST['ParentUnit'] ."', AcqusitionDate = '". date('Y-m-d', strtotime($_POST['AcquisitionDate'])) ."', Ownership = '". $_POST['Ownership'] ."' WHERE AssetNo = '". $_POST['ControlNo'] ."';", $connection);
				if($res == true){
					echo "1|Asset successfully updated.";
				}else{
					echo "2|Failed to update asset.";
				}
			}
		break;

		case 'fncAssetInfo':
			$AssetInfo = mysql_fetch_array(mysql_query("SELECT AssetDesc, AssetCategory, AssetClass, AssetBrand, AssetColor, AssetSerial, AssetBarcode, AssetSupplier, AssetDimension, AssetStatus, AssetDepartment, AssetHolder, AssetLocation, AssetQuantity, AssetUnits, AcquisitionAmount, LifeInYears, DepreciatedCost, SalvageAmount, ParentUnit, AcqusitionDate, Ownership, AssetImage FROM tblref_asset WHERE AssetNo = '". $_POST['AssetNo'] ."';", $connection));

			if($AssetInfo['AssetImage'] == ""){
				$AssetImage = "assets/images/noimage5.png";
				$NoImage = "1";
			}else{
				if(!file_exists("../../../Mall_Attachments/Asset/". $AssetInfo['AssetImage'])){ 
	            	$AssetImage = "assets/images/noimage5.png";
					$NoImage = "1";
				}else{
					$AssetImage = "../Mall_Attachments/Asset/". $AssetInfo['AssetImage'];
					$NoImage = "2";
				}
			}

			echo $AssetImage . "|" . $AssetInfo['AssetDesc'] . "|" . date('m/d/Y', strtotime($AssetInfo['AcqusitionDate'])) . "|" . number_format($AssetInfo['AcquisitionAmount'], 2, '.', ',') . "|" . $AssetInfo['AssetStatus'] . "|" . $AssetInfo['AssetCategory'] . "|" . $AssetInfo['AssetColor'] . "|" . $AssetInfo['AssetSupplier'] . "|" . $AssetInfo['AssetDepartment'] . "|" . $AssetInfo['AssetLocation'] . "|" . number_format($AssetInfo['LifeInYears'], 2, '.', ',') . "|" . $AssetInfo['AssetClass'] . "|" . $AssetInfo['AssetSerial'] . "|" . $AssetInfo['AssetDimension'] . "|" . $AssetInfo['Ownership'] . "|" . number_format($AssetInfo['AssetQuantity'], 2, '.', ',') . "|" . number_format($AssetInfo['DepreciatedCost'], 2, '.', ',') . "|" . $AssetInfo['AssetBrand'] . "|" . $AssetInfo['AssetBarcode'] . "|" . $AssetInfo['ParentUnit'] . "|" . $AssetInfo['AssetHolder'] . "|" . $AssetInfo['AssetUnits'] . "|" . number_format($AssetInfo['SalvageAmount'], 2, '.', ',') . "|" . $NoImage;
		break;

		case 'fncAssetComponents':
			$res = mysql_query("SELECT AssetNo, AssetDesc, Ownership, AcqusitionDate, AssetStatus, AssetImage FROM tblref_asset WHERE ParentUnit = '". $_POST['AssetNo'] ."';", $connection);
			while($row = mysql_fetch_array($res)){
				if($row['AssetImage'] == ""){
					$AssetImage = "assets/images/noimage5.png";
				}else{
					if(!file_exists("../../../Mall_Attachments/Asset/". $row['AssetImage'])){ 
		            	$AssetImage = "assets/images/noimage5.png";
					}else{
						$AssetImage = "../Mall_Attachments/Asset/". $row['AssetImage'];
					}
				}
				echo 	"<tr>
							<td><img class='editable img-responsive img-circle img-thumbnail' src='". $AssetImage ."' style='height: 80px;width: 100%;'></td>
							<td style='vertical-align: middle;'>". $row['AssetNo'] ."</td>
							<td style='vertical-align: middle;'>". $row['AssetDesc'] ."</td>
							<td style='vertical-align: middle;'>". $row['Ownership'] ."</td>
							<td style='vertical-align: middle;'>". date('m/d/Y', strtotime($row['AcqusitionDate'])) ."</td>
							<td style='vertical-align: middle;'>". $row['AssetStatus'] ."</td>
						</tr>";
			}
		break;

		case 'fncShowslctComponents':
			echo "<option value=''>-- Select Component --</option>";
			$res = mysql_query("SELECT AssetNo, AssetDesc FROM tblref_asset WHERE AssetNo != '". $_POST['AssetNo'] ."';", $connection);
			while($row = mysql_fetch_array($res)){
				echo "<option value='". $row['AssetNo'] ."'>". $row['AssetDesc'] ."</option>";
			}
		break;

		case 'fncSaveAllExpense':
			if($_POST['isEdit'] == "Edit Asset Maintenance"){
				$res = mysql_query("UPDATE tblasset_maintenance_h SET JODate = '". date('Y-m-d', strtotime($_POST['JODate'])) ."', JOStatus = '". $_POST['JOStatus'] ."', ItemCondition = '". $_POST['ItemCondition'] ."', AssignedPerson = '". $_POST['AssignedPerson'] ."' WHERE JONumber = '". $_POST['JONumber'] ."' AND AssetNo = '". $_POST['AssetNo'] ."';", $connection);
				$res2 = mysql_query("DELETE FROM tblasset_maintenance_d WHERE JONumber = '". $_POST['JONumber'] ."';", $connection);
				if($res == true && $res2 == true){
					$arr = explode("#", $_POST['ExpenseList']);
					for ($i = 0; $i <= COUNT($arr)-2 ; $i++) { 
						$arr2 = explode("|", $arr[$i]);
						$res2 = mysql_query("INSERT INTO tblasset_maintenance_d SET JONumber = '". $_POST['JONumber'] ."', ExpenseDate = '". date('Y-m-d', strtotime($arr2[0])) ."', ExpenseType = '". $arr2[1] ."', ExpenseQty = '". $arr2[2] ."', ExpenseAmount = '". floatval($arr2[3]) ."', ExpenseOR = '". $arr2[4] ."', ExpenseRemarks = '". $arr2[5] ."';", $connection);
					}
					echo "1|Asset maintenance successfully updated.";
				}else{
					echo "2|Failed to update asset maintenance.";
				}
			}else{
				$checkExistingJONumber = mysql_fetch_array(mysql_query("SELECT COUNT(JONumber) FROM tblasset_maintenance_h WHERE JONumber = '". $_POST['JONumber'] ."';", $connection));
				if($checkExistingJONumber[0] == 0){
					$res = mysql_query("INSERT INTO tblasset_maintenance_h SET AssetNo = '". $_POST['AssetNo'] ."', JONumber = '". $_POST['JONumber'] ."', JODate = '". date('Y-m-d', strtotime($_POST['JODate'])) ."', JOStatus = '". $_POST['JOStatus'] ."', ItemCondition = '". $_POST['ItemCondition'] ."', AssignedPerson = '". $_POST['AssignedPerson'] ."';", $connection);
					if($res == true){
						$arr = explode("#", $_POST['ExpenseList']);
						for ($i = 0; $i <= COUNT($arr)-2 ; $i++) { 
							$arr2 = explode("|", $arr[$i]);
							$res2 = mysql_query("INSERT INTO tblasset_maintenance_d SET JONumber = '". $_POST['JONumber'] ."', ExpenseDate = '". date('Y-m-d', strtotime($arr2[0])) ."', ExpenseType = '". $arr2[1] ."', ExpenseQty = '". $arr2[2] ."', ExpenseAmount = '". floatval($arr2[3]) ."', ExpenseOR = '". $arr2[4] ."', ExpenseRemarks = '". $arr2[5] ."';", $connection);
						}
						echo "1|Asset maintenance successfully added.";
					}else{
						echo "2|Failed to add asset maintenance.";
					}
				}else{
					echo "2|Asset control number already exists.";
				}
			}
		break;

		case 'fncAssetMaintenance':
			$res = mysql_query("SELECT JONumber, JODate, JOStatus, ItemCondition, AssignedPerson FROM tblasset_maintenance_h WHERE AssetNo = '". $_POST['AssetNo'] ."' AND (JONumber LIKE '%". $_POST['key'] ."%' OR JOStatus LIKE '%". $_POST['key'] ."%' OR ItemCondition LIKE '%". $_POST['key'] ."%' OR AssignedPerson LIKE '%". $_POST['key'] ."%');", $connection);
			while($row = mysql_fetch_array($res)){
				$TotalExpense = mysql_fetch_array(mysql_query("SELECT SUM(ExpenseAmount) FROM tblasset_maintenance_d WHERE JONumber = '". $row['JONumber'] ."'", $connection));
				if($row['JOStatus'] == "Done"){
					$btn = "<button class='btn btn-sm btn-round' title='View Asset Information' onclick='fncNewAssetMaintenance(\"". $row['JONumber'] ."\", \"View\")' style='margin: 2px;'><img src='assets/images/view.png' style='width: 100%; height: auto;' /></button>";
				}else{
					$btn = "<button class='btn btn-sm btn-info btn-round' title='View/Edit Job Order' onclick='fncNewAssetMaintenance(\"". $row['JONumber'] ."\", \"Edit\")' style='margin: 2px;'><img src='assets/images/edit.png' style='width: 100%; height: auto;' /></button></div>";
				}
				echo 	"<tr>
							<td>". $row['JONumber'] ."</td>
							<td>". date('m/d/Y', strtotime($row['JODate'])) ."</td>
							<td>". $row['AssignedPerson'] ."</td>
							<td>". $row['JOStatus'] ."</td>
							<td>". $row['ItemCondition'] ."</td>
							<td style='text-align: right;'>". number_format($TotalExpense[0], 2, '.', ',') ."</td>
							<td><div class='btn-group'>". $btn ."</td>
						</tr>";
			}
		break;

		case 'fncEditAssetMaintenance':
			$MaintenanceInfo = mysql_fetch_array(mysql_query("SELECT JONumber, JODate, JOStatus, ItemCondition, AssignedPerson FROM tblasset_maintenance_h WHERE JONumber = '". $_POST['JONumber'] ."';", $connection));
			echo $MaintenanceInfo['JONumber'] . "|" . $MaintenanceInfo['JODate'] . "|" . $MaintenanceInfo['JOStatus'] . "|" . $MaintenanceInfo['ItemCondition'] . "|" . $MaintenanceInfo['AssignedPerson'] . "|";
			$Count = 1;
			$resMaintenanceInfo2 = mysql_query("SELECT ExpenseDate, ExpenseType, ExpenseQty, ExpenseAmount, ExpenseOR, ExpenseRemarks FROM tblasset_maintenance_d WHERE JONumber = '". $MaintenanceInfo['JONumber'] ."'", $connection);
			while($rowMaintenanceInfo2 = mysql_fetch_array($resMaintenanceInfo2)){
				echo 	"<tr id='AssetMain". $Count ."'>
							<td>". date('m/d/Y', strtotime($rowMaintenanceInfo2['ExpenseDate'])) ."</td>
							<td>". $rowMaintenanceInfo2['ExpenseType'] ."</td>
							<td>". number_format($rowMaintenanceInfo2['ExpenseQty'], 2, '.', ',') ."</td>
							<td>". number_format($rowMaintenanceInfo2['ExpenseAmount'], 2, '.', ',') ."</td>
							<td>". $rowMaintenanceInfo2['ExpenseOR'] ."</td>
							<td>". $rowMaintenanceInfo2['ExpenseRemarks'] ."</td>
							<td><button class='btn btn-xs btn-danger btn-round' onclick='$(\"#AssetMain". $Count ."\").remove();'><i class='fa fa-trash-o'></i></button></td>
						</tr>";
						$Count++;
			}
		break;
	}
?>

