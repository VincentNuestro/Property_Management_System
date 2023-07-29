<?php
	session_start();
	include("../connect.php");
	switch($_POST["form"]){
		case "getdetails":
			$sql = "SELECT tenantid, tenantname, electricstat, waterstat, txtstat, status FROM tblunit_statuslogs WHERE unitid = '" . $_POST["unitid"] . "' AND xdate = '" . $_POST["mydate"] . "'";
			$row = mysql_fetch_array(mysql_query($sql));
			echo "|" . $row[0] . "|" . $row[1] . "|" . $row[2] . "|" . $row[3] . "|" . $row[4] . "|" . $row[5];
		break;

		case "getdetails2":
			$arr = explode("-", $_POST["mydate"]);
			$sql = "SELECT tenantid, tenantname FROM tblunit_statuslogs WHERE unitid = '" . $_POST["unitid"] . "' AND MONTH(xdate) = '" . $arr[0] . "' AND YEAR(xdate) = '" . $arr[1] . "' GROUP BY tenantid";
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result)){ 
				echo "#|" . $row[0] . "|" . $row[1]; 
			}
		break;

		case "loadwing":
			$sql = "SELECT wingID, wing FROM tblref_wing WHERE mallID = '" . $_POST["mallid"] . "'";
			$result = mysql_query($sql);
			echo "<option value=''>Choose Wing</option>";
			while($row = mysql_fetch_array($result)){ 
				echo "<option value='" . $row[0] . "'>" . $row[1] . "</option>"; 
			}
		break;

		case "loadfloor":
			$sql = "SELECT floorid, floor FROM tblref_floorsetup WHERE wingid = '" . $_POST["wingid"] . "'";
			$result = mysql_query($sql);
			echo "<option value=''>Choose Floor</option>";
			while($row = mysql_fetch_array($result)){ 
				echo "<option value='" . $row[0] . "'>" . $row[1] . "</option>"; 
			}
		break;

		case "filterunit":
			$adder = "";
			if($_POST["mallid"] != ""){ 
				$adder .= " AND a.mallid = '" . $_POST["mallid"] . "'"; 
			}
			if($_POST["wingid"] != ""){ 
				$adder .= " AND a.wingid = '" . $_POST["wingid"] . "'"; 
			}
			if($_POST["floorid"] != ""){ 
				$adder .= " AND a.floorid = '" . $_POST["floorid"] . "'"; 
			}
			$sql = "SELECT a.unitid, a.unitname, a.typeofbusiness, a.buildingname, b.floor, a.status FROM tblref_unit as a LEFT JOIN tblref_floorsetup as b ON a.floorid = b.floorid WHERE a.unitname LIKE '" . $_POST["key"] . "%' AND a.typeofbusiness = '" . $_POST["type"] . "'" . $adder;
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result)){
				echo "
				<tr id='" . $row[0] . "'>
					<td style='height: 100px;'>
						<h5 style='margin: 5px;'><a href='#'><span class='glyphicon glyphicon-home'></span>&nbsp;&nbsp;" . $row[1] . "</a></h5>
						<b style='margin: 0px; margin-left: 25px; margin-top: 0px; font-size: 12px; color: #333;'>&nbsp;" . $row[2] . "</b>
						<p style='margin: 0px; margin-left: 25px; margin-top: 0px; font-size: 12px; color: #666;'>&nbsp;" . $row[3] . "</p>
						<p style='margin: 0px; margin-left: 25px; margin-top: 0px; font-size: 12px; color: #666;'>&nbsp;" . $row[4] . "</p>
					</td>
				</tr>
				";
			}
		break;

		case "tenantdetails":
			$sql = "";
			echo "||";
			$sql2 = "SELECT a.unitname, b.mallname, a.buildingname, c.floor FROM tblref_unit as a LEFT JOIN tblref_mall as b ON a.mallid = b.mallid LEFT JOIN tblref_floorsetup as c ON a.floorid = c.floorid WHERE a.unitid = '" . $_POST["unitid"] . "'";
			$row2 = mysql_fetch_array(mysql_query($sql2));
			echo "|" . $row2[0] . "|" . $row2[1] . "|" . $row2[2] . "|" . $row2[3];
			$sql3 = "";
			echo "||";
		break;

		case "checkphoto":
			$sql = mysql_query("SELECT photo, ext FROM tblref_floorsetup WHERE floorid = '" . $_POST["floorid"] . "'");
			$row = mysql_fetch_array($sql);
			if($row[0] == "1"){ 
				echo "|1|../Mall_Attachments/floorplan/". $row['ext'];
			}else{ 
				echo "|0"; 
			}
		break;

		case "loadfloorplan":
			$sql = "";
			if($_POST["mallid"] != ""){ 
				$sql = "SELECT mallid FROM tblref_floorsetup WHERE mallid = '" . $_POST["mallid"] . "' AND photo = '1' GROUP BY mallid"; 
			}else{ 
				$sql = "SELECT mallid FROM tblref_floorsetup WHERE photo = '1' GROUP BY mallid"; 
			}
			$result = mysql_query($sql);
			$num = mysql_num_rows($result);
			if($num == 0){ 
				echo "<li class='col-xs-12 col-sm-12' style='padding: 15px; border: none;'><h3 style='text-align: center; font-size: 30px; font-weight: 300; color: #666;'>No Photos Found.</h3></li>";
			}else{
				while($row = mysql_fetch_array($result)){
					$getmall = "SELECT mallname FROM tblref_mall WHERE mallid = '" . $row[0] . "'";
					$mall = mysql_fetch_array(mysql_query($getmall));
					echo "<h2 class='malltxt'>" . $mall[0] . "</h2>";
					$sql2 = "";
					if($_POST["wingid"] == ""){ 
						$sql2 = "SELECT wingid FROM tblref_floorsetup WHERE mallid = '" . $row[0] . "' AND photo = '1' GROUP BY wingid"; 
					}else{
						$sql2 = "SELECT wingid FROM tblref_floorsetup WHERE mallid = '" . $row[0] . "' AND wingid = '" . $_POST["wingid"] . "' AND photo = '1' GROUP BY wingid"; 
					}
					$result2 = mysql_query($sql2);
					while($row2 = mysql_fetch_array($result2)){
						$getwing = "SELECT wing FROM tblref_wing WHERE wingID = '" . $row2[0] . "'";
						$wing = mysql_fetch_array(mysql_query($getwing));
						echo "<h3 class='wingtxt'><span class='glyphicon glyphicon-star'></span>&nbsp;&nbsp;" . $wing[0] . "</h3>";
						$sql3 = "";
						if($_POST["mallid"] == ""){ 
							$sql3 = "SELECT floorid, ext, floor, wingid, mallid FROM tblref_floorsetup WHERE mallid = '" . $row[0] . "' AND wingid = '" . $row2[0] . "' AND photo = '1'"; 
						}else{
							if($_POST["wingid"] == ""){ 
								$sql3 = "SELECT floorid, ext, floor, wingid, mallid FROM tblref_floorsetup WHERE mallid = '" . $_POST["mallid"] . "' AND wingid = '" . $row2[0] . "' AND photo = '1'"; 
							}else{ 
								$sql3 = "SELECT floorid, ext, floor, wingid, mallid FROM tblref_floorsetup WHERE mallid = '" . $_POST["mallid"] . "' AND wingid = '" . $_POST["wingid"] . "' AND photo = '1'"; 
							}
						}
						$result3 = mysql_query($sql3);
						$num3 = mysql_num_rows($result3);
						if($num3 == 0){ 
							echo "<h5 style='margin-left: 15px;'>No Data Found...</h5>"; 
						}
						while($row3 = mysql_fetch_array($result3)){

							if($row3["ext"] == ""){
								$FPImage = "<img style='width: 100%;height: 250px;' src='assets/images/noimage5.png' />";
							}else{
								if(!file_exists("../../Mall_Attachments/floorplan/". $row3[1])){ 
									$FPImage = "<img style='width: 100%;height: 250px;' src='assets/images/noimage5.png' />";
								}else{
									$FPImage = "<img style='width: 400px;height: 250px;' src='../Mall_Attachments/floorplan/". $row3[1] ."'/>";
								}
							}
							echo "
							<li class='col-xs-3 col-sm-3' style='padding: 0px; float: none; display: inline-block; vertical-align: top; margin: 0px; margin-left: 10px; margin-bottom: 10px; border: solid 1px #666;' id='" . $row3[0] . "|". $row3[4] . "|" . $row3[3] . "'>
								<a href='#' data-rel='colorbox' onClick='viewdetails(\"" . $row3[0] . "\", \"" . $row3[2] . "\");'>
									". $FPImage ."
									<div class='tags'>
										<span class='label-holder'>
											<span class='label label-danger'>" . $row3[2] . "</span>
										</span>
									</div>
								</a>
								<div class='tools tools-left in'>
									<a href='#' title='Edit Photo' class='btnedit select-seteditfloorplant hide isadmin'><i class='ace-icon fa fa-pencil'></i></a>
									<a href='#' title='Remove Photo' class='btndelete select-setremovefloorplant hide isadmin'><i class='ace-icon fa fa-times red'></i></a>
								</div>
							</li>
							";
						}
					}
				}
			}
		break;

		case "loadfloorplan2":
			if($_POST["mallid"] == ""){
				if($_POST["wingid"] == ""){ 
					$sql = "SELECT a.floorid, b.mallname, c.wing, a.floor, b.mallid, c.wingid FROM tblref_floorsetup AS a LEFT JOIN tblref_mall AS b ON a.mallid = b.mallid LEFT JOIN tblref_wing AS c ON a.wingid = c.wingID GROUP BY floorid ORDER BY ". $_POST['FloorplanSortBy'] ." ". $_POST['FloorplanSortType'] .";"; 
				}else{ 
					$sql = "SELECT a.floorid, b.mallname, c.wing, a.floor, b.mallid, c.wingid FROM tblref_floorsetup AS a LEFT JOIN tblref_mall AS b ON a.mallid = b.mallid LEFT JOIN tblref_wing AS c ON a.wingid = c.wingID WHERE c.wingID = '" . $_POST["wingid"] . "' GROUP BY floorid ORDER BY ". $_POST['FloorplanSortBy'] ." ". $_POST['FloorplanSortType'] .";"; 
				}
			}else{
				if($_POST["wingid"] == ""){ 
					$sql = "SELECT a.floorid, b.mallname, c.wing, a.floor, b.mallid, c.wingid FROM tblref_floorsetup AS a LEFT JOIN tblref_mall AS b ON a.mallid = b.mallid LEFT JOIN tblref_wing AS c ON a.wingid = c.wingID WHERE b.mallid = '" . $_POST["mallid"] . "' GROUP BY floorid ORDER BY ". $_POST['FloorplanSortBy'] ." ". $_POST['FloorplanSortType'] .";"; 
				}else{ 
					$sql = "SELECT a.floorid, b.mallname, c.wing, a.floor, b.mallid, c.wingid FROM tblref_floorsetup AS a LEFT JOIN tblref_mall AS b ON a.mallid = b.mallid LEFT JOIN tblref_wing AS c ON a.wingid = c.wingID WHERE b.mallid = '" . $_POST["mallid"] . "' AND c.wingID = '" . $_POST["wingid"] . "' GROUP BY floorid ORDER BY ". $_POST['FloorplanSortBy'] ." ". $_POST['FloorplanSortType'] .";"; 
				}
			}
			$result = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($result)){
				echo 	"
							<tr id='" . $row[0] . "'>
								<td style='width: 25%;'>" . $row[1] . "</td>
								<td style='width: 25%;'>" . $row[2] . "</td>
								<td style='width: 25%;'>" . $row[3] . "</td>
								<td style='width: 25%;z-index: 0;' class='option'><button class='btn btn-info btn-xs hide isadmin select-seteditfloorplant btn-round' onclick='editfloor(\"" . $row[0] . "\", \"" . $row[4] . "\", \"" . $row[5] . "\",);'><span class='fa fa-edit'></span>&nbsp;&nbsp;Edit</button></td>
							</tr>
						";
			}
		break;

		case "unitdetails":
			$json_response_list = array();
			$json_response = array();
			$UnitInformation = mysql_fetch_array(mysql_query("SELECT unitid, unitname, typeofbusiness, classid, depid, catid, mallid, wingid, floorid, sqmunitsetup, pricepersqmunitsetup, totalamountunitsetup, photoext, BillingSetup, MainUnit, assocdues, id FROM tblref_unit WHERE unitid = '". $_POST['unitid'] ."';", $connection));
			$UnitLogs = mysql_fetch_array(mysql_query("SELECT electricstat, txtstat, waterstat FROM tblunit_statuslogs WHERE unitid = '". $_POST['unitid'] ."' AND xdate = '". date('Y-m-d', strtotime(getsysdate())) ."';", $connection));
			$Classification = mysql_fetch_array(mysql_query("SELECT classification FROM tblref_merchandise_class WHERE classificationID = '". $UnitInformation['classid'] ."'", $connection));
			$Department = mysql_fetch_array(mysql_query("SELECT department FROM tblref_merchandise_depa WHERE departmentID = '". $UnitInformation['depid'] ."'", $connection));
			$Category = mysql_fetch_array(mysql_query("SELECT category FROM tblref_merchandisedep_cat WHERE categoryID = '". $UnitInformation['catid'] ."'", $connection));
			$Wing = mysql_fetch_array(mysql_query("SELECT wing FROM tblref_wing WHERE wingID = '". $UnitInformation['wingid'] ."';", $connection));
			$Floor = mysql_fetch_array(mysql_query("SELECT floor FROM tblref_floorsetup WHERE floorid = '". $UnitInformation['floorid'] ."';", $connection));
			$Mall = mysql_fetch_array(mysql_query("SELECT mallname FROM tblref_mall WHERE mallid = '". $UnitInformation['mallid'] ."';", $connection));

			$row = mysql_fetch_array(mysql_query("SELECT a.unitname, b.mallname, e.wing, c.floor, d.waterstat, d.electricstat, d.txtstat, a.max_num, a.rem_num, a.photoext FROM tblref_unit as a LEFT JOIN tblref_mall as b ON a.mallid = b.mallid LEFT JOIN tblref_floorsetup as c ON a.floorid = c.floorid LEFT JOIN tblunit_statuslogs as d ON a.unitid = d.unitid LEFT JOIN tblref_wing as e ON a.wingid = e.wingid WHERE a.unitid = '" . $_POST["unitid"] . "' AND d.xdate = '" . getsysdate() . "';", $connection));

			if($row[9] == ""){
				$image = "assets/images/noimage5.png";
			}else{
				if(!file_exists("../../Mall_Attachments/Unit Image/". $_POST['unitid'] .".". $row[9])){ 
					$image = "assets/images/noimage5.png";
				}else{
					$image = "../Mall_Attachments/Unit Image/". $_POST['unitid'] .".". $row[9];
				}
			}

			if(SysLeaseSetup('floorandunitmeasurement') == 'Area'){
                $UnitArea = $UnitInformation['area'];
            }else{  
                $UnitArea = $UnitInformation['sqmunitsetup'];
            }

			$json_response['UnitName'] = $UnitInformation['unitname'];
			$json_response['UnitType'] = $UnitInformation['typeofbusiness'];
			$json_response['UnitID'] = $UnitInformation['unitid'];
			$json_response['Classification'] = $Classification['classification'];
			$json_response['Department'] = $Department['department'];
			$json_response['Category'] = $Category['category'];
			$json_response['MallName'] = $Mall['mallname'];
			$json_response['Wing'] = $Wing['wing'];
			$json_response['Floor'] = $Floor['floor'];
			$json_response['Area'] = number_format($UnitArea, 0, ".", ",");
			$json_response['Rate'] = number_format($UnitInformation['pricepersqmunitsetup'], 2, ".", ",");
			$json_response['AssocDues'] = number_format($UnitInformation['assocdues'], 2, ".", ",");
			$json_response['WaterStat'] = $UnitLogs['waterstat'];
			$json_response['ElectricStat'] = $UnitLogs['electricstat'];
			$json_response['TxtStat'] = $UnitLogs['txtstat'];
			array_push($json_response_list, $json_response);		
			echo json_encode($json_response_list);
		break;

		case 'FPUnitImages':
			$resUnitImages = mysql_query("SELECT UnitID, ImageName FROM tblref_unitimage WHERE UnitID = '". $_POST['UnitID'] ."';", $connection);
			while($rowUnitImages = mysql_fetch_array($resUnitImages)){
				if(file_exists("../../Mall_Attachments/Unit Image/".$rowUnitImages['UnitID']."/".$rowUnitImages['ImageName'])){
					echo 	"<li class='center' style='border-color: #CCC !important;'>
                                <a href='../Mall_Attachments/Unit Image/".$rowUnitImages['UnitID']."/".$rowUnitImages['ImageName'] ."' title='Photo Title' data-rel='colorbox-FP". $rowUnitImages['UnitID'] ."' class='cboxElement'>
                                    <img width='127' height='127' alt='". $rowUnitImages['ImageName'] ."' src='../Mall_Attachments/Unit Image/".$rowUnitImages['UnitID']."/".$rowUnitImages['ImageName'] ."' style='padding: 5px;'>
                                </a>
                            </li>";
				}
			}
		break;

		case 'selected_unit_amenities':
			$sql = "SELECT amenitiesID FROM tblref_unit_amenities WHERE unitID = '".$_POST["unit_id"]."'";
			$result = mysql_query($sql, $connection);
			$cnt = mysql_num_rows($result);
			if($cnt == 0){
				echo '<li>This unit has no amenities included.</li>';
			}else{
				while($row = mysql_fetch_array($result)){
					$sql2 = "SELECT amenitiesname FROM tblref_amenities WHERE amenitiesid = '".$row["amenitiesID"]."'";
					$result2 = mysql_query($sql2, $connection);
					$row2 = mysql_fetch_array($result2);
					if($row2["amenitiesname"] != ""){
						echo 	"<li>
									<i class='ace-icon fa fa-caret-right green'></i>". $row2["amenitiesname"] ."
								</li>";
					}
				}
			}
		break;

		case "ctenantstat":
			$sql = "SELECT tradename, companyname, TenantID, datefrom, dateto, companyID, tradeID FROM tbltrans_tenants WHERE unitID = '" . $_POST["unitid"] . "';";
			$result = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($result)){
				$sql2 = "SELECT * FROM tblunit_statuslogs WHERE unitid = '" . $_POST["unitid"] . "' AND tenantid = '" . $row[2] . "' AND status = 'occupied' AND xdate = '" . date("Y-m-d") . "';";
				$num2 = mysql_num_rows(mysql_query($sql2));
				$filename = mysql_fetch_array(mysql_query("SELECT filename FROM tbltrans_tradename WHERE companyID = '". $row[5] ."';", $connection));

				if($filename["filename"] == ""){
					$image = "assets/images/noimage5.png";
				}else{
					if(!file_exists("../Mall_Attachments/company/".$row[5]."/trades/".$row[6]."/".$filename[0])){
						$image = "assets/images/noimage5.png";
					}else{
						$image = "../Mall_Attachments/company/".$row[5]."/trades/".$row[6]."/".$filename[0];
					}
				}

				if($num2 > 0){
					echo "<li class='list-group-item'><img style='margin-right: 5px;' class='img-circle' src='". $image ."' width='20px' height='20px'>&nbsp;&nbsp;" . $row[0] . " - <small>" . $row[1] . "</small><div class='pull-right'>FROM: " . date("m/d/Y", strtotime($row[3])) . " - TO: " . date("m/d/Y", strtotime($row[4])) . "</div></li>";
				}
			}
		break;

		case "unitstat":
			$sql = "SELECT xdate, tenantname, status, waterstat, electricstat, txtstat, gasstat FROM tblunit_statuslogs WHERE unitid = '" . $_POST["unitid"] . "' AND xdate BETWEEN '" . date('Y-m-d', strtotime($_POST['startdate'])) . "' AND '" . date('Y-m-d', strtotime($_POST['enddate'])) . "' AND tenantname LIKE '%". $_POST['key'] ."%'";
			$res = mysql_query($sql);
			$num = mysql_num_rows($res);
			if($num == 0){ 
				echo "<tr><td colspan='4' style='text-align: center;'>No Data Found...</td></tr>"; 
			}else{
				while($row = mysql_fetch_array($res)){
					$padding = "";
					if($row[3] == "1"){ 
						$padding .= "<label style='margin-right: 10px;' class='label-white'><span class='fa fa-tint fa-2x blue'></span></label>"; 
					}
					if($row[4] == "1"){ 
						$padding .= "<label style='margin-right: 10px;' class='label-white'><span class='fa fa-bolt fa-2x orange'></span></label>"; 
					}
					if($row[5] == "1"){ 
						$padding .= "<label style='margin-right: 10px;' class='label-white'><span class='fa fa-file-text fa-2x grey'></span></label>"; 
					}
					echo "<tr>
							<td>". date("m/d/Y", strtotime($row[0])) ."</td>
							<td>". $row[1] ."</td>
							<td>". $row[2] ."</td>
							<td>". $padding ."</td>
						</tr>";
				}
			}
		break;

		case "tenantstat":
			$res = mysql_query("SELECT TenantID, tradename, companyname, datefrom, dateto, monthly_dues FROM tbltrans_tenants WHERE unitID = '". $_POST["unitid"] ."' AND (tradename LIKE '%". $_POST['key'] ."%' OR companyname LIKE '%". $_POST['key'] ."%') AND (datefrom BETWEEN '". date('Y/m/d', strtotime($_POST['startdate'])) ."' AND '". date('Y/m/d', strtotime($_POST['enddate'])) ."')", $connection);
			$num = mysql_num_rows($res);
			if($num == 0){ 
				echo "<tr><td colspan='5' style='text-align: center;'>No Data Found...</td></tr>"; 
			}else{
				while($row = mysql_fetch_array($res)){
					echo "<tr>
							<td>".$row[0]."</td>
							<td>".$row[1]."</td>
							<td>".$row[2]."</td>
							<td>".date('m/d/Y', strtotime($row[3]))." - ".date('m/d/Y', strtotime($row[4]))."</td>
							<td style='text-align: right;'>".number_format($row[5], "2", ".", ",")."</td>
						</tr>";
				}
			}
		break;

		case 'showFPInquiryHistory':
			$res = mysql_query("SELECT date_inquired, Trade_Name, Company_Name, datefrom, dateto, monthly_dues FROM tbltrans_inquiry WHERE UnitID = '". $_POST['UnitID'] ."' AND Application_ID = '' AND (date_inquired BETWEEN '". date('Y-m-d', strtotime($_POST['startdate'])) ."' AND '". date('Y-m-d', strtotime($_POST['enddate'])) ."') AND (Trade_Name LIKE '%". $_POST['key'] ."%' OR Company_Name LIKE '%". $_POST['key'] ."%')", $connection);
			$num = mysql_num_rows($res);
			if($num == 0){ 
				echo "<tr><td colspan='6' style='text-align: center;'>No Data Found...</td></tr>"; 
			}else{
				while($row = mysql_fetch_array($res)){
					echo "<tr>
							<td>". date('m/d/Y', strtotime($row[0])) ."</td>
							<td>". $row[1] ."</td>
							<td>". $row[2] ."</td>
							<td>". date('m/d/Y', strtotime($row[3])) . " - " . date('m/d/Y', strtotime($row[4])) . "</td>
							<td style='text-align: right;'>". $row[5] ."</td>
						</tr>
					";
				}
			}
		break;

		case 'showSOAList':
			$res = mysql_query("SELECT a.soaid, a.soaperiod, a.soaperiod2, a.ctrlno, a.Currbal, a.tenantid, c.tradename FROM dunn_tblsoaheader as a LEFT JOIN tblref_unit as b ON a.TenantID = b.TenantID LEFT JOIN tbltrans_tenants AS c ON a.TenantID = c.TenantID WHERE a.isMerchant = '0' and b.unitid = '" . $_POST["UnitID"] . "' AND (a.soaid LIKE '%". $_POST['key'] ."%' OR c.tradename LIKE '%". $_POST['key'] ."%')", $connection);
			$num = mysql_num_rows($res);
			if($num == 0){ 
				echo "<tr><td colspan='6' style='text-align: center;'>No Data Found...</td></tr>"; 
			}else{
				while($row = mysql_fetch_array($res)){
					$maxid = "";
					$str = strlen($row[3]);
					if($str == 1){ 
						$maxid = "000" . $row[3]; 
					}elseif($str == 2){ 
						$maxid = "00" . $row[3]; 
					}elseif($str == 3){ 
						$maxid = "0" . $row[3]; 
					}else{ 
						$maxid = $row[3]; 
					}
					echo "<tr onclick='opensoa_separatetenant(\"" . $row[5] . "\", \"" . $row[0] . "\");'>
							<td>". date('m/d/Y', strtotime($row[1])) . " - " . date('m/d/Y', strtotime($row[2])) . "</td>
							<td>". $row[0] ."</td>
							<td>". $maxid ."</td>
							<td>". $row[6] ."</td>
							<td style='text-align: right;'>". number_format($row[4], 2, ".", ",") ."</td>
						</tr>";
				}
			}
		break;

		case 'ShowMainLogs':
			$res = mysql_query("SELECT a.workorderid, a.xdate, a.ownername, a.workername, a.xstatus FROM tblmaintenance_workorder AS a LEFT JOIN tblref_unit AS b ON a.TenantID = b.TenantID WHERE b.unitid = '". $_POST['UnitID'] ."'", $connection);
			$num = mysql_num_rows($res);
			if($num == 0){ 
				echo "<tr><td colspan='6' style='text-align: center;'>No Data Found...</td></tr>"; 
			}else{
				while($row = mysql_fetch_array($res)){
					if($row[4] == "Resolved"){ 
						$stat2 = "<span class='label label-lg label-success arrowed-in-right arrowed'>" . $row[4] . "</span>"; 
					}else{ 
						$stat2 = "<span class='label label-lg label-warning arrowed-in-right arrowed'>" . $row[4] . "</span>"; 
					}
					echo "	<tr>
								<td>". $row[0] ."</td>
								<td>". date('m/d/Y', strtotime($row[1])) ."</td>
								<td>". $row[2] ."</td>
								<td>". $row[3] ."</td>
								<td>". $row[3] ."</td>
								<td>". $stat2 ."</td>
							</tr>";
				}
			}
		break;

		case 'ShowComplaints':
			$res = mysql_query("SELECT a.Complaint_Code, a.Complete_Description, a.Time_Received, a.Time_Resolved, a.ResolvedBy, a.Complaint_Status, a.Priority_Status FROM tblcomplaints AS a LEFT JOIN tblref_unit AS b ON a.TenantID = b.TenantID WHERE b.unitid = '". $_POST['UnitID'] ."'", $connection);
			$num = mysql_num_rows($res);
			if($num == 0){ 
				echo "<tr><td colspan='7' style='text-align: center;'>No Data Found...</td></tr>"; 
			}else{
	            while($row = mysql_fetch_array($res)){
	                if($row['Time_Received'] == "" || $row['Time_Received'] == "0000-00-00 00:00:00"){
	                    $TimeReceived = "";
	                }else{
	                    $TimeReceived = date('m/d/Y h:i A', strtotime($row['Time_Received']));
	                }

	                if($row['Time_Resolved'] == "" || $row['Time_Resolved'] == "0000-00-00 00:00:00"){
	                    $TimeResolved = "";
	                }else{
	                    $TimeResolved = date('m/d/Y h:i A', strtotime($row['Time_Resolved']));
	                }

	                if($row['Priority_Status'] == "High"){
	                    $PrioStat = "<span class='label label-lg label-danger arrowed-in-right arrowed' style='z-index: 0;'>High Priority</span>";
	                }else if($row['Priority_Status'] == "Medium"){
	                    $PrioStat = "<span class='label label-lg label-warning arrowed-in-right arrowed' style='z-index: 0;'>Medium Priority</span>";
	                }else if($row['Priority_Status'] == "Low"){
	                    $PrioStat = "<span class='label label-lg label-yellow arrowed-in-right arrowed' style='z-index: 0;'>Low Priority</span>";
	                }

	                echo "  <tr>
	                            <td>". $row['Complaint_Code'] ."</td>
	                            <td>". $row['Complete_Description'] ."</td>
	                            <td>". $TimeReceived ."</td>
	                            <td>". $TimeResolved ."</td>
	                            <td>". $row['resolvedby'] ."</td>
	                            <td>". $row['Complaint_Status'] ."</td>
	                            <td>". $PrioStat ."</td>
	                        </tr>";
	            }
	        }
		break;

		case 'loadincident':
			$sql = "SELECT VSeriesNumber, ViolatorID, ViolatorName, xstatus, xdate, xtime, xtype FROM tblmaintenance_hrviolatorsheader AS a LEFT JOIN tblref_unit AS b ON a.ViolatorID = b.TenantID WHERE b.unitid = '". $_POST['UnitID'] ."'";
			$res = mysql_query($sql, $connection);
			$num = mysql_num_rows($res);
			if($num == 0){ 
				echo "<tr><td colspan='6' style='text-align: center;'>No Data Found...</td></tr>"; 
			}else{
				while($row = mysql_fetch_array($res)){
					if($row[3] == "Resolved"){ 
						$stat2 = "<span class='label label-lg label-success arrowed-in-right arrowed'>" . $row[3] . "</span>"; 
					}else{ 
						$stat2 = "<span class='label label-lg label-warning arrowed-in-right arrowed'>" . $row[3] . "</span>"; 
					}
					$stradd1 = "";
					$res2 = mysql_query("SELECT Violation, offensetype FROM tblmaintenance_hrviolators WHERE VSeriesNumber = '" . $row[0] . "';");
					while($row2 = mysql_fetch_array($res2)){
						if($row2[1] == "1st Offense"){ 
							$stradd1 .= "<i class='fa fa-circle' style='color: #F89406;'></i>&nbsp;" . $row2[0] . "<br>"; 
						}else if($row2[1] == "2nd Offense"){ 
							$stradd1 .= "<i class='fa fa-circle' style='color: #D6487E;'></i>&nbsp;" . $row2[0] . "<br>"; 
						}else if($row2[1] == "3rd Offense"){ 
							$stradd1 .= "<i class='fa fa-circle' style='color: #D15B47;'></i>&nbsp;" . $row2[0] . "<br>"; 
						}else{ 
							$stradd1 .= "<i class='fa fa-circle' style='color: #333;'></i>&nbsp;" . $row2[0] . "<br>"; 
						}
					}
					echo "<tr>
							<td>". $row[0] ."</td>
							<td>". $row[2] ."</td>
							<td>". $stradd1 ."</td>
							<td>". date("m/d/Y", strtotime($row[4])) ."</td>
							<td>". date("h:i A", strtotime($row[5])) ."</td>
							<td>". $stat2 ."</td>
						</tr>";		
				}	
			}
		break;

		case "editfloor":
			$sql = "SELECT ext, mallid, wingid FROM tblref_floorsetup WHERE floorid = '" . $_POST["floorid"] . "'";
			$row = mysql_fetch_array(mysql_query($sql));
			echo "|" . $row[0]."|".$row[1]."|<option value=''>-- Select Wing --</option>";

			$reswing = mysql_query("SELECT wingID, wing FROM tblref_wing WHERE mallID = '". $row[1] ."'", $connection);
			while($rowwing = mysql_fetch_array($reswing)){
				echo "<option value='". $rowwing[0] ."'>". $rowwing[1] ."</option>";
			}
			echo "|<option value=''>-- Select Floor --</option>";
			$resfloor = mysql_query("SELECT floorid, floor FROM tblref_floorsetup WHERE wingid = '". $row[2] ."'", $connection);
			while($rowfloor = mysql_fetch_array($resfloor)){
				echo "<option value='". $rowfloor[0] ."'>". $rowfloor[1] ."</option>";
			}
		break;

		case "removefloor":
			$getext = "SELECT ext FROM tblref_floorsetup WHERE floorid = '" . $_POST["floorid"] . "'";
			$ext = mysql_fetch_array(mysql_query($getext));
			$sql = "UPDATE tblref_floorsetup set photo = '0', ext = NULL, width = '0', height ='0' WHERE floorid = '". $_POST['floorid'] ."'";
			$result = mysql_query($sql);
			if($result == "1"){
				unlink("../../../Mall_Attachments/floorplan/". $_POST["floorid"] .".". $ext[0]);
				echo "|1";
			}else{ 
				echo "|Error: " . mysql_error() . "!"; 
			}
		break;

		case "getunittype":
			$sql = "SELECT mallid, wingid, floorid, typeofbusiness FROM tblref_unit WHERE unitid = '" . $_POST["unitid"] . "'";
			$row = mysql_fetch_array(mysql_query($sql));
			echo "|" . $row[0] . "|" . $row[1] . "|" . $row[2] . "|" . $row[3];
		break;

		case "loadunits2":
			$sql = "SELECT unitid, unitname, status FROM tblref_unit WHERE floorid = '". $_POST["floorid"] ."' AND unitname LIKE '%" . $_POST["key"] . "%';";
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result)){
				$sql2 = "SELECT * FROM tblref_unitplot WHERE unitid = '" . $row[0] . "'";
				$num2 = mysql_num_rows(mysql_query($sql2));
				if($num2 == 0){ 
					echo "<li class='list-group-item' onclick='addunit(\"" . $row[0] . "\", \"" . $row[1] . "\", \"" . $row[2] . "\");' style='margin-left: 10px; cursor: pointer;' id='" . $row[0] . "'><span class='glyphicon glyphicon-road green'></span>&nbsp;&nbsp;&nbsp;&nbsp;" . $row[1] . "</li>"; 
				}
			}
		break;

		case "saveplot3":
			$sql = "";
			$getget = "SELECT * FROM tblref_unitplot WHERE unitid = '" . $_POST["unitid"] . "'";
			$get = mysql_num_rows(mysql_query($getget));
			if($get > 0){ 
				$sql = "UPDATE tblref_unitplot set coord = '" . $_POST["coord"] . "', dateadded = '" . date("Y-m-d") . "' WHERE unitid = '" . $_POST["unitid"] . "';";
			}else{
				$getget2 = "SELECT floorid, unitname, status FROM tblref_unit WHERE unitid = '" . $_POST["unitid"] . "';";
				$get2 = mysql_fetch_array(mysql_query($getget2));
				$sql = "INSERT into tblref_unitplot(floorid, unitid, unitname, status, coord, dateadded) values('" . $get2[0] . "', '" . $_POST["unitid"] . "', '" . $get2[1] . "', '" . $get2[2] . "', '" . $_POST["coord"] . "', '" . date("Y-m-d") . "');";
			}
			$result = mysql_query($sql);
			if($result == "1"){ 
				echo "1";
			}else{ 
				echo "Error: " . mysql_error() . "!"; 
			}
		break;

		case "loadpoints3":
			$sql = "SELECT unitid, unitname, status, coord FROM tblref_unitplot WHERE floorid = '" . $_POST["floorid"] . "'";
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result)){
				$sql2 = "SELECT b.CompanyID, b.tradeID FROM tblref_unit as a LEFT JOIN tbltrans_tenants as b ON a.TenantID = b.TenantID WHERE a.unitid = '" . $row[0] . "'";
				$row2 = mysql_fetch_array(mysql_query($sql2));
				echo "#|" . $row[0] . "|" . $row[1] . "|" . $row[2] . "|" . $row2[0] . "|" . $row2[1] . "|" . $row[3];
			}
		break;

		case "removeunit3":
			$sql = "delete FROM tblref_unitplot WHERE unitid = '" . $_POST["unitid"] . "'";
			$result = mysql_query($sql);
			if($result == "1"){ 
				echo "|1|"; 
			}else{ 
				echo "|Error: " . mysql_error() . "!"; 
			}
		break;

		case 'FPMallNameHere':
			$mallid = mysql_fetch_array(mysql_query("SELECT a.mallname FROM tblref_mall AS a INNER JOIN tblref_unit AS b ON a.mallid = b.mallid WHERE b.floorid = '". $_POST['floorid'] ."' ", $connection));
				echo $mallid[0];
		break;
	}
?>	