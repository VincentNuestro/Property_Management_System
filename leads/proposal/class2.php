<?php
	session_start();
	include "../../connect.php";
	switch ($_POST['form']) {
		case 'fncPASSSelectUnit':
			$page = $_POST['page'];
			$limit = ($page-1) * 20;
			$sql = "SELECT unitid, unitname, max_num, Status FROM tblref_unit WHERE (MainUnit IS NULL OR MainUnit = '') AND typeofbusiness = '". $_POST['typeunit'] ."' AND (unitid LIKE '%". $_POST['key'] ."%' OR unitname LIKE '%". $_POST['key'] ."%') and mallid = '". $_POST['MallID'] ."' AND status = 'Vacant' LIMIT ". $limit .", 20;";
			$res = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($res)){
				echo "	<tr>
							<td onclick='SelectThisUnit2(\"". $row[0] ."\");'>". $row[0] ."</td>
							<td onclick='SelectThisUnit2(\"". $row[0] ."\");'>". $row[1] ."</td>
							<td style='z-index: 0;'><button class='btn btn-sm btn-default btn-round' onclick='ViewUnitInformation2(\"". $row["unitid"] ."\")' title='View Unit Details' style='margin: 2px;'><img src='assets/images/view.png' style='width: 100%; height: auto;' /></button></td>
						</tr>";
			}
		break;

		case 'fncPASSSelectUnitEntries':
			if($_POST["page"] == ""){
				$page = 1;
			}else{
				$page = $_POST["page"];
			}
			$limit = ($page-1) * 20;
			$rowCount = mysql_num_rows(mysql_query("SELECT id FROM tblref_unit WHERE (MainUnit IS NULL OR MainUnit = '') AND typeofbusiness = '". $_POST['typeunit'] ."' AND (unitid LIKE '%". $_POST['key'] ."%' OR unitname LIKE '%". $_POST['key'] ."%') and mallid = '". $_POST['MallID'] ."' AND status = 'Vacant';", $connection));
			$rowsperpage = 20;
			$totalpages = ceil($rowCount / $rowsperpage);
			$upto = $limit + 20;
			$from = $limit + 1;
			if($page == $totalpages && $rowCount != 0){
				echo "Showing " . $from . " to " . $rowCount . " of " . $rowCount . " entries";
			}else{
				if($rowCount == 0){
					echo "";
				}else if($rowCount <= 19 && $rowCount != 0){
					echo "Showing 1 to " . $rowCount . " of " . $rowCount . " entries";
				}else if($rowCount >= 20 && $rowCount != 0){
					echo "Showing " . $from . " to " . $upto . " of " . $rowCount . " entries";
				}
			}
		break;

		case 'fncPASSSelectUnitPagination':
			$page = $_POST["page"];
			$rowCount = mysql_num_rows(mysql_query("SELECT id FROM tblref_unit WHERE (MainUnit IS NULL OR MainUnit = '') AND typeofbusiness = '". $_POST['typeunit'] ."' AND (unitid LIKE '%". $_POST['key'] ."%' OR unitname LIKE '%". $_POST['key'] ."%') and mallid = '". $_POST['MallID'] ."' AND status = 'Vacant';", $connection));
			$rowsperpage = 20;
			$range = 3;
			$totalpages = ceil($rowCount / $rowsperpage);
			$prevpage;
			$nextpage;
			if($page > 1 ){
			   	echo "<li style='width:50px !important;' onclick='fncPASSSelectUnitPagination(1)'><< First</li>";
			   	$prevpage = $page - 1;
			   	echo "<li style='width:70px !important;' onclick='fncPASSSelectUnitPagination(". $prevpage .")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if (($x > 0) && ($x <= $totalpages)){
					if ($x == $page){
						echo "<li id='pgLeadsInqShrtctUnit" . $x . "' class='pgnumLeadsInqShrtctUnit active' onclick='fncPASSSelectUnitPagination(" . $x . ",". $x .")'>" . $x . "</li>";
					}else{
						echo "<li id='pgLeadsInqShrtctUnit" . $x . "' class='pgnumLeadsInqShrtctUnit' onclick='fncPASSSelectUnitPagination(" . $x . ",". $x .")'>" . $x . "</li>";
					}
				}
			}
			if($page < ($totalpages - $range)){
				echo "<li>...</li>";
			}
			if ($page != $totalpages && $rowCount != 0){
			   	$nextpage = $page + 1;
			   	echo "<li style='width:50px !important;' onclick='fncPASSSelectUnitPagination(". $nextpage .", ". $nextpage .")'>Next ></li>";
			   	echo "<li style='width:50px !important;' onclick='fncPASSSelectUnitPagination(". $totalpages .", ". $totalpages .")'>Last >></li>";
			}
		break;

		case 'ViewUnitInformation':
			$count = 0;
			echo 	"<div class='tabbable'>
                    	<ul class='nav nav-tabs'>";
			$resliUnitInformation = mysql_query("SELECT unitid, unitname FROM tblref_unit WHERE unitid = '". $_POST['UnitID'] ."' OR MainUnit = '". $_POST['UnitID'] ."';", $connection);
			while($rowliUnitInformation = mysql_fetch_array($resliUnitInformation)){
				if($count == 0){
					$liisActive = "active";
				}else{
					$liisActive = "";
				}
                echo 		"<li class='". $liisActive ."' onclick='fncChangeSelectID(\"". $rowliUnitInformation['unitid'] ."\")'>
                                <a data-toggle='tab' href='#Tabs". $rowliUnitInformation['unitid'] ."'>
                                    <i class='green ace-icon fa fa-home bigger-120'></i>
                                    ". $rowliUnitInformation['unitname'] ."
                                </a>
                        	</li>";
               $count++;
			}
        		echo 	"</ul>";
        		echo 	"<div class='tab-content' style='display: block;'>";
			$divcount = 0;
			$resdivUnitInformation = mysql_query("SELECT unitid, unitname, typeofbusiness, classid, depid, catid, mallid, wingid, floorid, sqmunitsetup, pricepersqmunitsetup, totalamountunitsetup, photoext, BillingSetup, MainUnit, assocdues FROM tblref_unit WHERE unitid = '". $_POST['UnitID'] ."' OR MainUnit = '". $_POST['UnitID'] ."';", $connection);
			while($rowdivUnitInformation = mysql_fetch_array($resdivUnitInformation)){

				if($rowdivUnitInformation['MainUnit'] != ""){
					$UnitID = $_POST['UnitID'];
				}else{
					$UnitID = $rowdivUnitInformation['unitid'];
				}

				if($divcount == 0){
					$divisActive = "in active";
				}else{
					$divisActive = "";
				}

				$Classification = mysql_fetch_array(mysql_query("SELECT classification FROM tblref_merchandise_class WHERE classificationID = '". $rowdivUnitInformation['classid'] ."'", $connection));
				$Department = mysql_fetch_array(mysql_query("SELECT department FROM tblref_merchandise_depa WHERE departmentID = '". $rowdivUnitInformation['depid'] ."'", $connection));
				$Category = mysql_fetch_array(mysql_query("SELECT category FROM tblref_merchandisedep_cat WHERE categoryID = '". $rowdivUnitInformation['catid'] ."'", $connection));
				$Wing = mysql_fetch_array(mysql_query("SELECT wing FROM tblref_wing WHERE wingID = '". $rowdivUnitInformation['wingid'] ."';", $connection));
				$Floor = mysql_fetch_array(mysql_query("SELECT floor FROM tblref_floorsetup WHERE floorid = '". $rowdivUnitInformation['floorid'] ."';", $connection));

				echo 		"<div id='Tabs". $rowdivUnitInformation['unitid'] ."' class='tab-pane fade ". $divisActive ."'>
                    			<div class='row'>
                    				<div class='col-md-12'>
                                        <ul class='ace-thumbnails clearfix' style='max-height: 270px;overflow-y: scroll;'>";
											$resUnitImages = mysql_query("SELECT ImageName FROM tblref_unitimage WHERE UnitID = '". $rowdivUnitInformation['unitid'] ."';", $connection);
											while($rowUnitImages = mysql_fetch_array($resUnitImages)){
												if(file_exists("../../server/Unit Image/".$UnitID."/".$rowdivUnitInformation['ImageName'])){ 
													echo 	"<li class='center' style='border-color: #CCC !important;'>
								                                <a href='server/Unit Image/".$UnitID."/".$rowUnitImages['ImageName'] ."' title='Photo Title' data-rel='colorbox' class='cboxElement'>
								                                    <img width='127' height='127' alt='127x127' src='server/Unit Image/".$UnitID."/".$rowUnitImages['ImageName'] ."' style='padding: 5px;'>
								                                </a>
								                            </li>";
												}
											}
                                echo    "</ul>
                    				</div>";
            				echo 	"<div class='col-md-6'>
										<h4 class='header blue'>Unit Information</h4>
				                        <div class='profile-user-info'>
				                        	<div class='profile-info-row'>
				                                <div class='profile-info-name' style='white-space: nowrap;'> Unit Type </div>
				                                <div class='profile-info-value'>
				                                    <span> ". $rowdivUnitInformation['typeofbusiness'] ." </span>
				                                </div>
				                            </div>
				                            <div class='profile-info-row'>
				                                <div class='profile-info-name' style='white-space: nowrap;'> Unit ID </div>
				                                <div class='profile-info-value'>
				                                    <span> ". $rowdivUnitInformation['unitid'] ." </span>
				                                </div>
				                            </div>";
				                            if(SysLeaseSetup('isClassification') == "1"){
			                     	echo 	"<div class='profile-info-row'>
				                                <div class='profile-info-name'> Classification </div>
				                                <div class='profile-info-value'>
				                                    <span> ". $Classification[0] ." </span>
				                                </div>
				                            </div>";
				                            }
				                            if(SysLeaseSetup('isDepartment') == "1"){
				                    echo 	"<div class='profile-info-row'>
				                         		<div class='profile-info-name'> Department </div>
				                                <div class='profile-info-value'>
				                                    <span> ". $Department[0] ." </span>
				                                </div>
				                            </div>";
				                            }
				                            if(SysLeaseSetup('isCategory') == '1'){
				                    echo  	"<div class='profile-info-row'>
				                				<div class='profile-info-name'> Category </div>
				                                <div class='profile-info-value'>
				                                    <span> ". $Category[0] ." </span>
				                                </div>
				                            </div>";
				                            }	
				                    echo 	"<div class='profile-info-row'>
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
				                            </div>
				                            <div class='profile-info-row'>
				                                <div class='profile-info-name' style='white-space: nowrap;'> Area </div>
				                                <div class='profile-info-value'>
				                                    <span> ". number_format($rowdivUnitInformation['sqmunitsetup'], "2", ".", ",") ." SQM</span>
				                                </div>
				                            </div>";
				                            if(SysLeaseSetup('softwaretype') != "5"){
				                    echo    "<div class='profile-info-row'>
				                                <div class='profile-info-name' style='white-space: nowrap;'> Billing Setup </div>
				                                <div class='profile-info-value'>
				                                    <span> ". $rowdivUnitInformation['BillingSetup'] ." </span>
				                                </div>
				                            </div>";
				                            }
				                    echo	"<div class='profile-info-row'>
				                             	<div class='profile-info-name'> Rate </div>
				                             	<div class='profile-info-value'>
				                                 	<span> ". number_format($rowdivUnitInformation['pricepersqmunitsetup'], "2", ".", ",") ." </span>
				                             	</div>
				                         	</div>";
				                            if(SysLeaseSetup('isAssocDues') == '1'){
				                    echo    "<div class='profile-info-row'>
				                             	<div class='profile-info-name' style='white-space: nowrap;'> Association Dues </div>
				                             	<div class='profile-info-value'>
				                                 	<span> ". number_format($rowdivUnitInformation['assocdues'], "2", ".", ",") ." </span>
				                             	</div>
				                         	</div>";
				                            }
				                    echo    "<div class='profile-info-row'>
				                    			<div class='profile-info-name'> &nbsp; </div>
				                             	<div class='profile-info-value'>
				                                 	<span></span>
				                             	</div>
				                         	</div>
				                        </div>
				                    </div>
									<div class=col-md-6>
				                        <div class=row form-group>
				                        	<h4 class='header blue'>Amenities</h4>
				                        </div>
				                        <div class='row form-group'>";
												$resAmenities = mysql_query("SELECT amenitiesID FROM tblref_unit_amenities WHERE unitID = '". $rowdivUnitInformation["unitid"] ."';", $connection);
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
													
													// if($cnt == 0){
													// 	echo '<div class="alert alert-info"><table><tr><td><h4 class="blue smaller lighter">This unit has no amenities included.</h4></td></tr></table></div>';
													// }
                    				echo"</div>
                    				</div>
                    			</div>
                    		</div>
                    		";	
               $divcount++;
			}
			$OtherInfo = mysql_fetch_array(mysql_query("SELECT OtherUnitInfo FROM tblref_unit WHERE unitid = '". $_POST['UnitID'] ."';", $connection));
				if($OtherInfo['OtherUnitInfo'] != ""){
	                echo 	"<div class='row'>
	                			<div class='col-md-12'>
	                				<h4 class='header blue'>Other Unit Information</h4>
	                			</div>
	                			<div class='col-md-12'>
	                				". $OtherInfo['OtherUnitInfo'] ."
	                			</div>
	                		</div>";
				}
	                echo	"<div class='row'>
	                			<div class='col-md-offset-5 col-md-2'>
	                				<button class='btn btn-primary btn-sm btn-block btn-round' id='btnChangeSelectID2' onclick='SelectThisUnit2(\"". $_POST['UnitID'] ."\")'>Select This Unit</button>
	                			</div>
	                		</div>
	                	</div>";
            echo 	"</div>";            	
		break;

		case 'fncgetAmortSched':
			if($_POST['getDowntype'] == "Percentage"){
				$DownPayment = floatval($_POST['Rate']) * ($_POST['Downpayment'] / 100);
			}else{
				$DownPayment = floatval($_POST['Downpayment']);
			}
			$Principal = floatval($_POST['Rate']);
			$Percentage = floatval($_POST['Perc'] / 100);
			$InterestRate = $Percentage / 12;
			$Payment = $_POST['Rate'] * $InterestRate * (pow(1 + $InterestRate, $_POST['Months']) / (pow(1 + $InterestRate, $_POST['Months']) - 1));
			$Test = 0;
			$StartDate = date('m/d/Y', strtotime($_POST['StartDate'].'+1 month'));
			for ($i = 1; $i <= floatval($_POST['Months']); $i++) { 
				if($i == 1){
					$DeductedPrincipal1 = $Principal;
					$Interest = $DeductedPrincipal1 * $InterestRate;
				}else{
					$Interest = $Test * $InterestRate;
					$DeductedPrincipal1 = $Test;
				}
				$DeductedPrincipal2 = $DeductedPrincipal1 - ($Payment - $Interest);
				echo 	"<tr>
							<td>". $StartDate ."</td>;
							<td style='text-align: right'>". number_format($DeductedPrincipal1, "2", ".", ",") ."</td>;
							<td style='text-align: right'>". number_format($Payment, "2", ".", ",") ."</td>;
							<td style='text-align: right'>". number_format($Interest, "2", ".", ",") ."</td>;
							<td style='text-align: right'>". number_format($Payment - $Interest, "2", ".", ",") ."</td>;
							<td style='text-align: right'>". str_replace("-", "", number_format($DeductedPrincipal2, "2", ".", ",")) ."</td>;
						</tr>";
						$Test = $DeductedPrincipal2;
				$StartDate = date('m/d/Y', strtotime($StartDate.'+1 month'));
			}
		break;

		case 'fncgetAmortSched2':
			if($_POST['getDowntype'] == "Percentage"){
				$DownPayment = floatval($_POST['Rate']) * ($_POST['Downpayment'] / 100);
			}else{
				$DownPayment = floatval($_POST['Downpayment']);
			}
			$Principal = floatval($_POST['Rate']);
			$Percentage = floatval($_POST['Perc'] / 100);
			$InterestRate = $Percentage / 12;
			$Payment = $_POST['Rate'] * $InterestRate * (pow(1 + $InterestRate, $_POST['Months']) / (pow(1 + $InterestRate, $_POST['Months']) - 1));
			$Test = 0;
			$StartDate = date('m/d/Y', strtotime($_POST['StartDate'].'+1 month'));
			for ($i = 1; $i <= floatval($_POST['Months']); $i++) { 
				if($i == 1){
					$DeductedPrincipal1 = $Principal;
					$Interest = $DeductedPrincipal1 * $InterestRate;
				}else{
					$Interest = $Test * $InterestRate;
					$DeductedPrincipal1 = $Test;
				}
				$DeductedPrincipal2 = $DeductedPrincipal1 - ($Payment - $Interest);
				echo 	"<tr>
							<td>". $StartDate ."</td>;
							<td style='text-align: right'>". number_format($DeductedPrincipal1, "2", ".", ",") ."</td>;
							<td style='text-align: right'>". number_format($Payment, "2", ".", ",") ."</td>;
							<td style='text-align: right'>". number_format($Interest, "2", ".", ",") ."</td>;
							<td style='text-align: right'>". number_format($Payment - $Interest, "2", ".", ",") ."</td>;
							<td style='text-align: right'>". str_replace("-", "", number_format($DeductedPrincipal2, "2", ".", ",")) ."</td>;
						</tr>";
						$Test = $DeductedPrincipal2;
				$StartDate = date('m/d/Y', strtotime($StartDate.'+1 month'));
			}
		break;

		case 'fncSavePASSProposal':
			if($_POST['id'] == ""){
				$res = mysql_query("INSERT INTO tbltrans_proposal_pass SET InquiryID = '". $_POST['InquiryID'] ."', MallID = '". $_POST['MallID'] ."', ClassID = '". $_POST['ClassID'] ."', DepID = '". $_POST['DepID'] ."', CatID = '". $_POST['CatID'] ."', WingID = '". $_POST['WingID'] ."', FloorID = '". $_POST['FloorID'] ."', UnitID = '". $_POST['unitID'] ."', UnitRate = '". $_POST['UnitRate'] ."', AssocDues = '". $_POST['AssocDues'] ."', Months = '". $_POST['Months'] ."', Percentage = '". $_POST['Percentage'] ."', DownpaymentType = '". $_POST['DPType'] ."', Downpayment = '". $_POST['DownPayment'] ."', OccupancyStartDate = '". date('Y-m-d', strtotime($_POST['OccuStartDate'])) ."', isMain = '1';", $connection);

			}else{
				$res = mysql_query("UPDATE tbltrans_proposal_pass SET MallID = '". $_POST['MallID'] ."', ClassID = '". $_POST['ClassID'] ."', DepID = '". $_POST['DepID'] ."', CatID = '". $_POST['CatID'] ."', WingID = '". $_POST['WingID'] ."', FloorID = '". $_POST['FloorID'] ."', UnitID = '". $_POST['unitID'] ."', UnitRate = '". $_POST['UnitRate'] ."', AssocDues = '". $_POST['AssocDues'] ."', Months = '". $_POST['Months'] ."', Percentage = '". $_POST['Percentage'] ."', DownpaymentType = '". $_POST['DPType'] ."', Downpayment = '". $_POST['DownPayment'] ."', OccupancyStartDate = '". date('Y-m-d', strtotime($_POST['OccuStartDate'])) ."' WHERE id = '". $_POST['id'] ."';", $connection);
			}
		break;

		case 'setDefault22':
			$res = mysql_query("UPDATE tbltrans_proposal_pass SET isMain = '0';", $connection);
			if($res == true){
				$res2 = mysql_query("UPDATE tbltrans_proposal_pass SET isMain = '1' WHERE id = '". $_POST['id']."';", $connection);
			}
		break;

		case 'fncPrintPASSProposal':
			$UnitIDS = mysql_fetch_array(mysql_query("SELECT wingid, floorid, classid, depid, catid, unitname, sqmunitsetup, totalamountunitsetup, assocdues, area, typeofbusiness FROM tblref_unit WHERE unitid = '". $_POST['UnitID'] ."';", $connection));
			$Wing = mysql_fetch_array(mysql_query("SELECT wing FROM tblref_wing WHERE wingID = '". $UnitIDS['wingid'] ."';", $connection));
			$Floor = mysql_fetch_array(mysql_query("SELECT floor FROM tblref_floorsetup WHERE floorid = '". $UnitIDS['floorid'] ."';", $connection));
			$Classification = mysql_fetch_array(mysql_query("SELECT classification FROM tblref_merchandise_class WHERE classificationID = '". $UnitIDS['classid'] ."';", $connection));
			$Department = mysql_fetch_array(mysql_query("SELECT department FROM tblref_merchandise_depa WHERE departmentID = '". $UnitIDS['depid'] ."';", $connection));
			$Category = mysql_fetch_array(mysql_query("SELECT category FROM tblref_merchandisedep_cat WHERE categoryID = '". $UnitIDS['catid'] ."';", $connection));

			if(SysLeaseSetup('floorandunitmeasurement') == 'Area'){
				$UnitArea = $UnitIDS['area'];
			}else{	
				$UnitArea = $UnitIDS['sqmunitsetup'];
			}

			$Amenities = "";
			$resAmenities = mysql_query("SELECT amenitiesID FROM tblref_unit_amenities WHERE unitID = '". $_POST["UnitID"] ."';", $connection);
			$cntAmenities = mysql_num_rows($resAmenities);
			if($cntAmenities == 0){
				$Amenities .=	"<tr>
									<td>This unit has no amenities.</td>
								</tr>";
			}else{
				while($rowAmenities = mysql_fetch_array($resAmenities)){
					$resAmenities2 = mysql_query("SELECT amenitiesname FROM tblref_amenities WHERE amenitiesid = '".$rowAmenities["amenitiesID"]."'", $connection);
					$rowAmenities2 = mysql_fetch_array($resAmenities2);
					if($rowAmenities2["amenitiesname"] != ""){
						$Amenities .=	"<tr>
											<td> - ". $rowAmenities2['amenitiesname'] ."</td>
										</tr>";
					}
				}
			}
			$asdasdasd = "";
			$OtherInfo = mysql_fetch_array(mysql_query("SELECT OtherUnitInfo FROM tblref_unit WHERE unitid = '". $_POST['UnitID'] ."';", $connection));
			if($OtherInfo['OtherUnitInfo'] != ""){
                $asdasdasd .= 	"<div class='row'>
		                			<div class='col-md-12'>
		                				". $OtherInfo['OtherUnitInfo'] ."
		                			</div>
		                		</div>";
			}

			echo $UnitIDS['typeofbusiness'] . "|" . $UnitIDS['unitname'] . "|" . $_POST['UnitID'] . "|" . $Classification[0] . "|" . $Department[0] . "|" . $Category[0] . "|" . $Wing[0] . "|" . $Floor[0] . "|" . number_format($UnitArea, "0", "", ",") . " SQM|" . number_format($UnitIDS['totalamountunitsetup'], "2", ".", ",") . "|" . number_format($UnitIDS['assocdues'], "2", ".", ",") . "|" . $Amenities . "|" . $asdasdasd;
		break;

		case 'getInquiry':
			$getInquiry = mysql_fetch_array(mysql_query("SELECT Trade_Name, Address, Company_ID FROM tbltrans_inquiry WHERE Inquiry_ID = '". $_POST['InquiryID'] ."';", $connection));
			$getContact = mysql_fetch_array(mysql_query("SELECT content FROM tbltrans_company_contacts WHERE CompanyID = '". $getInquiry['Company_ID'] ."';", $connection));
			echo $getInquiry['Trade_Name'] . "|" . $getInquiry['Address'] . "|" . $getContact['content'];
		break;
	}
?>