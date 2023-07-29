<?php
	session_start();
	include("../connect.php");
	switch ($_POST['form']) {
	//Unit List Start -- Jonathan Jonas Bondoc September 10, 2019
		case 'LeadsInqShrtctUnit':
			$page = $_POST['page'];
			$limit = ($page-1) * 20;
			if($_POST['UnitType'] == '' || $_POST['UnitType'] == null){
				$UnitType = "";
			}else{
				$UnitType = "AND typeofbusiness = '". $_POST['UnitType'] ."'";
			}

			if($_SESSION['MMS-Designation'] == "Superuser" || $_SESSION['MMS-Designation'] == "GatessoftCorp"){
				if($_POST['MallID'] == '' || $_POST['MallID'] == null){
					$MallID = "";
				}else{
					$MallID = "AND mallid = '". $_POST['MallID'] ."'";
				}
			}else{
				$MallID = "AND mallid = '". $_SESSION['MMS-Designation'] ."'";
			}
			$arr = explode("|", $_POST['UnitMainIDs']);
			for($i=0; $i <= count($arr)-2; $i++){ 
				$mgaMeron .= "'" . $arr[$i] . "'" . ",";
			}
			if($mgaMeron != ""){
				$NotThis = "AND unitid NOT IN (". substr(trim($mgaMeron), 0, -1) .")";
			}else{
				$NotThis = "";
			}
			$res = mysql_query("SELECT unitid, unitname, max_num, Status, typeofbusiness, mallid, classid FROM tblref_unit WHERE (MainUnit IS NULL OR MainUnit = '') AND (unitid LIKE '%". $_POST['key'] ."%' OR unitname LIKE '%". $_POST['key'] ."%') AND status = 'Vacant' ". $MallID . $UnitType . $NotThis ." LIMIT ". $limit .", 20;", $connection);
			while($row = mysql_fetch_array($res)){
				$MallName = mysql_fetch_array(mysql_query("SELECT mallname FROM tblref_mall WHERE mallid = '". $row['mallid'] ."';", $connection));
				$UnitClassification = mysql_fetch_array(mysql_query("SELECT UnitClassDesc FROM tblref_unitclass WHERE UnitClassID = '". $row['classid'] ."';", $connection));
				echo "	<tr>
							<td style='vertical-align: middle;'>". $UnitClassification['UnitClassDesc'] ."</td>
							<td style='vertical-align: middle;'>". $row['unitname'] ."</td>
							<td style='vertical-align: middle;'>". $row['typeofbusiness'] ."</td>
							<td style='z-index: 0;' class='center'>
								<button class='btn btn-sm btn-gray btn-round' onclick='ViewUnitInformation(\"". $row["unitid"] ."\")' title='View Unit Information' style='margin: 2px;'><img src='assets/images/view.png' style='width: 100%; height: auto;' /></button>
								<button class='btn btn-sm btn-round btn-info' title='Show subunit' onclick='fncAddSelectedUnit(\"". $row["unitid"] ."\", \"isSUMain\")'><i class='fa fa-share bigger-130'></i></button>
							</td>
						</tr>";
			}
		break;

		case 'LeadsInqShrtctUnitEntries':
			if($_POST["page"] == ""){
				$page = 1;
			}else{
				$page = $_POST["page"];
			}
			if($_POST['UnitType'] == '' || $_POST['UnitType'] == null){
				$UnitType = "";
			}else{
				$UnitType = "AND typeofbusiness = '". $_POST['UnitType'] ."'";
			}
			if($_POST['MallID'] == '' || $_POST['MallID'] == null){
				$MallID = "";
			}else{
				$MallID = "AND mallid = '". $_POST['MallID'] ."'";
			}
			$arr = explode("|", $_POST['UnitMainIDs']);
			for($i=0; $i <= count($arr)-2; $i++){ 
				$mgaMeron .= "'" . $arr[$i] . "'" . ",";
			}
			if($mgaMeron != ""){
				$NotThis = "AND unitid NOT IN (". substr(trim($mgaMeron), 0, -1) .")";
			}else{
				$NotThis = "";
			}
			$limit = ($page-1) * 20;
			$rowCount = mysql_num_rows(mysql_query("SELECT id FROM tblref_unit WHERE (MainUnit IS NULL OR MainUnit = '') AND (unitid LIKE '%". $_POST['key'] ."%' OR unitname LIKE '%". $_POST['key'] ."%') AND status = 'Vacant' ". $MallID . $UnitType . $NotThis .";", $connection));
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

		case 'LeadsInqShrtctUnitPagination':
			$page = $_POST["page"];
			if($_POST['UnitType'] == '' || $_POST['UnitType'] == null){
				$UnitType = "";
			}else{
				$UnitType = "AND typeofbusiness = '". $_POST['UnitType'] ."'";
			}
			if($_POST['MallID'] == '' || $_POST['MallID'] == null){
				$MallID = "";
			}else{
				$MallID = "AND mallid = '". $_POST['MallID'] ."'";
			}
			$arr = explode("|", $_POST['UnitMainIDs']);
			for($i=0; $i <= count($arr)-2; $i++){ 
				$mgaMeron .= "'" . $arr[$i] . "'" . ",";
			}
			if($mgaMeron != ""){
				$NotThis = "AND unitid NOT IN (". substr(trim($mgaMeron), 0, -1) .")";
			}else{
				$NotThis = "";
			}
			$rowCount = mysql_num_rows(mysql_query("SELECT id FROM tblref_unit WHERE (MainUnit IS NULL OR MainUnit = '') AND (unitid LIKE '%". $_POST['key'] ."%' OR unitname LIKE '%". $_POST['key'] ."%') AND status = 'Vacant' ". $MallID . $UnitType . $NotThis .";", $connection));
			$rowsperpage = 20;
			$range = 3;
			$totalpages = ceil($rowCount / $rowsperpage);
			$prevpage;
			$nextpage;
			if($page > 1 ){
			   	echo "<li style='width:50px !important;' onclick='btnLeadsInqShrtctUnit(1)'><< First</li>";
			   	$prevpage = $page - 1;
			   	echo "<li style='width:70px !important;' onclick='btnLeadsInqShrtctUnit(". $prevpage .")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if (($x > 0) && ($x <= $totalpages)){
					if ($x == $page){
						echo "<li id='pgLeadsInqShrtctUnit" . $x . "' class='pgnumLeadsInqShrtctUnit active' onclick='btnLeadsInqShrtctUnit(" . $x . ",". $x .")'>" . $x . "</li>";
					}else{
						echo "<li id='pgLeadsInqShrtctUnit" . $x . "' class='pgnumLeadsInqShrtctUnit' onclick='btnLeadsInqShrtctUnit(" . $x . ",". $x .")'>" . $x . "</li>";
					}
				}
			}
			if($page < ($totalpages - $range)){
				echo "<li>...</li>";
			}
			if ($page != $totalpages && $rowCount != 0){
			   	$nextpage = $page + 1;
			   	echo "<li style='width:50px !important;' onclick='btnLeadsInqShrtctUnit(". $nextpage .", ". $nextpage .")'>Next ></li>";
			   	echo "<li style='width:50px !important;' onclick='btnLeadsInqShrtctUnit(". $totalpages .", ". $totalpages .")'>Last >></li>";
			}
		break;

		case 'ViewUnitInformation':
			$arr = explode("|", $_POST['UnitSubIDs']);
			for ($i=0; $i <= count($arr)-2; $i++) { 
				$mgaMeron .= "'" . $arr[$i] . "'" . ",";
			}
			if($_POST['UnitSubIDs'] != ""){
				$NotThis = "OR (MainUnit = '". $_POST['UnitID'] ."' AND unitid NOT IN (". substr(trim($mgaMeron), 0, -1) ."))";
			}else{
				$NotThis = "OR MainUnit = '". $_POST['UnitID'] ."'";
			}

			$count = 0;
			echo 	"<div class='tabbable'>
                    	<ul class='nav nav-tabs'>";
			$resliUnitInformation = mysql_query("SELECT id, unitid, unitname FROM tblref_unit WHERE unitid = '". $_POST['UnitID'] ."' ". $NotThis .";", $connection);
			while($rowliUnitInformation = mysql_fetch_array($resliUnitInformation)){
				if($count == 0){
					$liisActive = "active";
				}else{
					$liisActive = "";
				}
                echo 		"<li class='". $liisActive ."' onclick='fncChangeSelectID(\"". $rowliUnitInformation['unitid'] ."\")'>
                                <a data-toggle='tab' href='#Tabs". $rowliUnitInformation['id'] ."'>
                                    <i class='green ace-icon fa fa-home bigger-120'></i>
                                    ". $rowliUnitInformation['unitname'] ."
                                </a>
                        	</li>";
               $count++;
			}
        		echo 	"</ul>";
        		echo 	"<div class='tab-content' style='display: block;'>";
			$divcount = 0;
			$resdivUnitInformation = mysql_query("SELECT unitid, unitname, typeofbusiness, classid, depid, catid, mallid, wingid, floorid, sqmunitsetup, pricepersqmunitsetup, totalamountunitsetup, photoext, BillingSetup, MainUnit, assocdues, id, sqm_width, sqm_height, area FROM tblref_unit WHERE unitid = '". $_POST['UnitID'] ."' ". $NotThis .";", $connection);
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

				echo 		"<div id='Tabs". $rowdivUnitInformation['id'] ."' class='tab-pane fade ". $divisActive ."'>
                    			<div class='row'>
                    				<div class='col-md-12'>";
                    				if($divcount == 0){
                echo    				"<ul class='ace-thumbnails clearfix' style='max-height: 270px;overflow-y: scroll;' id='divColorBox-". $rowdivUnitInformation['unitid'] ."'>";
											$resUnitImages = mysql_query("SELECT UnitID, ImageName FROM tblref_unitimage WHERE UnitID = '". $rowdivUnitInformation['unitid'] ."';", $connection);
											while($rowUnitImages = mysql_fetch_array($resUnitImages)){
												if(file_exists("../../Mall_Attachments/Unit Image/".$rowUnitImages['UnitID']."/".$rowUnitImages['ImageName'])){
													echo 	"<li class='center' style='border-color: #CCC !important;'>
								                                <a href='../Mall_Attachments/Unit Image/".$rowUnitImages['UnitID']."/".$rowUnitImages['ImageName'] ."' title='Photo Title' data-rel='colorbox' class='cboxElement'>
								                                    <img width='127' height='127' alt='". $rowUnitImages['ImageName'] ."' src='../Mall_Attachments/Unit Image/".$rowUnitImages['UnitID']."/".$rowUnitImages['ImageName'] ."' style='padding: 5px;'>
								                                </a>
								                            </li>";
												}
											}
                                echo    "</ul>";
                    				}else{
                    			echo	"<ul class='ace-thumbnails clearfix' style='max-height: 270px;overflow-y: scroll;' id='divColorBox-". $rowdivUnitInformation['unitid'] ."'></ul>";
                    				}
                    		echo    "</div>";
            				echo 	"<div class='col-md-6'>
            							<div class='col-md-12'>
											<h4 class='header blue'>Unit Information</h4>
										</div>
				                        <div class='profile-user-info profile-user-info-striped'>
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
				                            </div>
				                            <div class='profile-info-row'>
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
				                            </div>";
				                            if(SysLeaseSetup('floorandunitmeasurement') == "Area"){
				                            	echo " <div class='profile-info-row'>
							                                <div class='profile-info-name' style='white-space: nowrap;'> Area </div>
							                                <div class='profile-info-value'>
							                                    <span> ". number_format($rowdivUnitInformation['area'], "2", ".", ",") ." SQM</span>
							                                </div>
							                            </div>";
					                            }else{
				                            	echo " <div class='profile-info-row'>
							                                <div class='profile-info-name' style='white-space: nowrap;'> Length </div>
							                                <div class='profile-info-value'>
							                                    <span> ". number_format($rowdivUnitInformation['sqm_height'], "2", ".", ",") ." SQM</span>
							                                </div>
							                            </div><div class='profile-info-row'>
							                                <div class='profile-info-name' style='white-space: nowrap;'> Width </div>
							                                <div class='profile-info-value'>
							                                    <span> ". number_format($rowdivUnitInformation['sqm_width'], "2", ".", ",") ." SQM</span>
							                                </div>
							                            </div>";
				                            }
				                    	echo "<div class='profile-info-row'>
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
			                   	echo    "</div>
				                    </div>
									<div class='col-md-6'>
										<div class='row form-group'>
					                        <div class='col-md-12'>
					                        	<h4 class='header blue'>Amenities</h4>
					                        </div>
				                        ";
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
	                echo	"<div class='row' style='margin-top: 10px;'>
	                			<div class='col-md-offset-5 col-md-2'>
	                				<button class='btn btn-primary btn-sm btn-block btn-round' id='btnChangeSelectID' onclick='fncAddSelectedUnit(\"". $_POST['UnitID'] ."\", \"isSUMain\")'>Add Unit</button>
	                			</div>
	                		</div>
	                	</div>";
            echo 	"</div>";            	
		break;

		case 'fncAddSelectedUnit':
			$UnitInfo = mysql_fetch_array(mysql_query("SELECT wingid, floorid, classid, depid, catid, unitname, sqmunitsetup, sqm_width, sqm_height, pricepersqmunitsetup, area, assocdues, mallid, typeofbusiness FROM tblref_unit WHERE unitid = '". $_POST['UnitID'] ."';", $connection));

			$Classification = mysql_fetch_array(mysql_query("SELECT classification FROM tblref_merchandise_class WHERE classificationID = '". $UnitInfo['classid'] ."'", $connection));
			$Department = mysql_fetch_array(mysql_query("SELECT department FROM tblref_merchandise_depa WHERE departmentID = '". $UnitInfo['depid'] ."'", $connection));
			$Category = mysql_fetch_array(mysql_query("SELECT category FROM tblref_merchandisedep_cat WHERE categoryID = '". $UnitInfo['catid'] ."'", $connection));
			$Wing = mysql_fetch_array(mysql_query("SELECT wing FROM tblref_wing WHERE wingID = '". $UnitInfo['wingid'] ."';", $connection));
			$Floor = mysql_fetch_array(mysql_query("SELECT floor FROM tblref_floorsetup WHERE floorid = '". $UnitInfo['floorid'] ."';", $connection));

			echo 	"<div class='widget-box widget-color-blue3 ui-sortable-handle collapsed' id='SU_". $_POST['UnitID'] ."'>
						<div class='widget-header  widget-header-small'>
							<h5 class='widget-title'>
								". $UnitInfo['unitname'] ."
							</h5>
							<div class='widget-toolbar'>
								<a href='#' data-action='collapse'>
									<i class='ace-icon fa bigger-125 fa-chevron-down'></i>
								</a>
							</div>

							<div class='widget-toolbar no-border'>
								<label>
									<input type='checkbox' class='ace chkSelectedUnits ". $_POST['isSUMain'] ."' id='id-checkbox-vertical' value='". $_POST['UnitID'] ."'>
									<span class='lbl middle padding-4'></span>
								</label>
							</div>
						</div>

						<div class='widget-body' style='display: none;'>
							<div class='widget-main'>
								<div class='row'>";
            				echo   	"<div class='col-md-12'>
                						<ul class='ace-thumbnails clearfix' style='max-height: 270px;overflow-y: scroll;'>";
											$resUnitImages = mysql_query("SELECT UnitID, ImageName FROM tblref_unitimage WHERE UnitID = '". $_POST['UnitID'] ."';", $connection);
											while($rowUnitImages = mysql_fetch_array($resUnitImages)){
												if(file_exists("../../Mall_Attachments/Unit Image/".$rowUnitImages['UnitID']."/".$rowUnitImages['ImageName'])){
													echo 	"<li class='center' style='border-color: #CCC !important;'>
								                                <a href='../Mall_Attachments/Unit Image/".$rowUnitImages['UnitID']."/".$rowUnitImages['ImageName'] ."' title='Photo Title' data-rel='cbSelected-". $rowUnitImages['UnitID'] ."' class='cboxElement'>
								                                    <img width='70' height='70' alt='". $rowUnitImages['ImageName'] ."' src='../Mall_Attachments/Unit Image/".$rowUnitImages['UnitID']."/".$rowUnitImages['ImageName'] ."' style='padding: 5px;'>
								                                </a>
								                            </li>";
												}
											}
                                echo    "</ul>
                    				</div>";
            				echo 	"<div class='col-md-6'>
            							<div class='row'>
            								<div class='col-md-12'>
												<h4 class='header blue'>Unit Information</h4>
											</div>
					                        <div class='profile-user-info profile-user-info-striped'>
					                        	<div class='profile-info-row'>
					                                <div class='profile-info-name' style='white-space: nowrap;'> Unit Type </div>
					                                <div class='profile-info-value'>
					                                    <span> ". $UnitInfo['typeofbusiness'] ." </span>
					                                </div>
					                            </div>
					                            <div class='profile-info-row'>
					                                <div class='profile-info-name' style='white-space: nowrap;'> Unit No. </div>
					                                <div class='profile-info-value'>
					                                    <span> ". $UnitInfo['unitname'] ." </span>
					                                </div>
					                            </div>
					                            <div class='profile-info-row'>
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
					                            </div>";
					                            if(SysLeaseSetup('floorandunitmeasurement') == "Area"){
					                            	echo " <div class='profile-info-row'>
								                                <div class='profile-info-name' style='white-space: nowrap;'> Area </div>
								                                <div class='profile-info-value'>
								                                    <span> ". number_format($UnitInfo['area'], "2", ".", ",") ." SQM</span>
								                                </div>
								                            </div>";
					                            }else{
					                            	echo " <div class='profile-info-row'>
								                                <div class='profile-info-name' style='white-space: nowrap;'> Length </div>
								                                <div class='profile-info-value'>
								                                    <span> ". number_format($UnitInfo['sqm_height'], "2", ".", ",") ." SQM</span>
								                                </div>
								                            </div><div class='profile-info-row'>
								                                <div class='profile-info-name' style='white-space: nowrap;'> Width </div>
								                                <div class='profile-info-value'>
								                                    <span> ". number_format($UnitInfo['sqm_width'], "2", ".", ",") ." SQM</span>
								                                </div>
								                            </div>";
				                            	}
					                    echo 	"<div class='profile-info-row'>
					                             	<div class='profile-info-name'> Rate </div>
					                             	<div class='profile-info-value'>
					                                 	<span> ". number_format($UnitInfo['pricepersqmunitsetup'], "2", ".", ",") ." </span>
					                             	</div>
					                         	</div>";
					                            if(SysLeaseSetup('isAssocDues') == '1'){
					                    echo    "<div class='profile-info-row'>
					                             	<div class='profile-info-name' style='white-space: nowrap;'> Association Dues </div>
					                             	<div class='profile-info-value'>
					                                 	<span> ". number_format($UnitInfo['assocdues'], "2", ".", ",") ." </span>
					                             	</div>
					                         	</div>";
					                            }
					                    echo    "
					                        </div>
			                        	</div>
				                    </div>
									<div class=col-md-6>
										<div class='row form-group'>
					                        <div class='col-md-12'>
					                        	<h4 class='header blue'>Amenities</h4>
					                        </div>";
											$resAmenities = mysql_query("SELECT amenitiesID FROM tblref_unit_amenities WHERE unitID = '". $_POST['UnitID'] ."';", $connection);
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
                    				echo"</div>
                    				</div>";
                					$OtherInfo = mysql_fetch_array(mysql_query("SELECT OtherUnitInfo FROM tblref_unit WHERE unitid = '". $_POST['UnitID'] ."';", $connection));
									if($OtherInfo['OtherUnitInfo'] != ""){
					                echo 	"<div class='col-md-12'>
				                				<h4 class='header blue'>Other Unit Information</h4>
				                			</div>
				                			<div class='col-md-12'>
				                				". $OtherInfo['OtherUnitInfo'] ."
				                			</div>";
									}
            			echo 	"</div>
							</div>
						</div>
					</div>";
		break;

		case 'fncAddSelectedUnits':
			$arr = explode("|", $_POST['UnitIDs']);
			for ($i=0; $i <= count($arr)-2; $i++) { 
				$UnitIDArr .= "'" . $arr[$i] . "'" . ",";
			}
			if($_POST['UnitIDs'] != ""){
				$rowCount = 1;
				$TotalAmount = 0;
				$TotalArea = 0;
				$TotalPriceperSQM = 0;
				$resUnitInfo = mysql_query("SELECT wingid, floorid, classid, depid, catid, unitname, sqmunitsetup, sqm_width, sqm_height, pricepersqmunitsetup, area, assocdues, mallid, typeofbusiness, unitid, totalamountunitsetup FROM tblref_unit WHERE unitid IN (". substr(trim($UnitIDArr), 0, -1) .");", $connection);
				$UnitCount = mysql_num_rows($resUnitInfo);
				if($UnitCount == 0){
					echo "<div class='alert alert-info center'> No Unit Selected... </div>";
				}else{
					echo "<div class='row form-group'>";
					while($UnitInfo = mysql_fetch_array($resUnitInfo)){
						if(SysLeaseSetup('floorandunitmeasurement') == "Area"){
                        	$TotalArea += $UnitInfo['area'];
                        }else{
                        	$TotalArea += floatval($UnitInfo['sqm_height'] * $UnitInfo['sqm_width']);
                    	}
                    	$TotalAmount += $TotalArea * $UnitInfo['pricepersqmunitsetup'];
						$TotalPriceperSQM += $UnitInfo['pricepersqmunitsetup'];

						if($UnitCount % 2 == 0){
							$ColumnGrid = '6';
						}else{
							if($rowCount == $UnitCount){
								$ColumnGrid = '12';
							}else{
								$ColumnGrid = '6';
							}
						}
						
						$Classification = mysql_fetch_array(mysql_query("SELECT classification FROM tblref_merchandise_class WHERE classificationID = '". $UnitInfo['classid'] ."'", $connection));
						$Department = mysql_fetch_array(mysql_query("SELECT department FROM tblref_merchandise_depa WHERE departmentID = '". $UnitInfo['depid'] ."'", $connection));
						$Category = mysql_fetch_array(mysql_query("SELECT category FROM tblref_merchandisedep_cat WHERE categoryID = '". $UnitInfo['catid'] ."'", $connection));
						$Wing = mysql_fetch_array(mysql_query("SELECT wing FROM tblref_wing WHERE wingID = '". $UnitInfo['wingid'] ."';", $connection));
						$Floor = mysql_fetch_array(mysql_query("SELECT floor FROM tblref_floorsetup WHERE floorid = '". $UnitInfo['floorid'] ."';", $connection));

						echo 	"<div class='col-md-". $ColumnGrid ."'>
									<div class='widget-box widget-color-blue3 ui-sortable-handle collapsed'>
										<input type='hidden' class='txtASU' value='". $UnitInfo['unitid'] ."'>
										<div class='widget-header widget-header-small'>
											<h5 class='widget-title'>
												". $UnitInfo['unitname'] ."
											</h5>
											<div class='widget-toolbar'>
												<a href='#' data-action='collapse'>
													<i class='ace-icon fa bigger-125 fa-chevron-down'></i>
												</a>
											</div>
										</div>

										<div class='widget-body' style='display: none;'>
											<div class='widget-main'>
												<div class='row'>";
				            				echo   	"<div class='col-md-12'>
				                						<ul class='ace-thumbnails clearfix' style='max-height: 270px;overflow-y: scroll;'>";
															$resUnitImages = mysql_query("SELECT UnitID, ImageName FROM tblref_unitimage WHERE UnitID = '". $UnitInfo['unitid'] ."';", $connection);
															while($rowUnitImages = mysql_fetch_array($resUnitImages)){
																if(file_exists("../../Mall_Attachments/Unit Image/".$rowUnitImages['UnitID']."/".$rowUnitImages['ImageName'])){
																	echo 	"<li class='center' style='border-color: #CCC !important;'>
												                                <a href='../Mall_Attachments/Unit Image/".$rowUnitImages['UnitID']."/".$rowUnitImages['ImageName'] ."' title='Photo Title' data-rel='cbUnitList-". $rowUnitImages['UnitID'] ."' class='cboxElement'>
												                                    <img width='78' height='78' alt='". $rowUnitImages['ImageName'] ."' src='../Mall_Attachments/Unit Image/".$rowUnitImages['UnitID']."/".$rowUnitImages['ImageName'] ."' style='padding: 5px;'>
												                                </a>
												                            </li>";
																}
															}
				                                echo    "</ul>
				                    				</div>";
				            				echo 	"<div class='col-md-6'>
				            							<div class='row'>
				            								<div class='col-md-12'>
																<h4 class='header blue'>Unit Information</h4>
															</div>
									                        <div class='profile-user-info profile-user-info-striped'>
									                        	<div class='profile-info-row'>
									                                <div class='profile-info-name' style='white-space: nowrap;'> Unit Type </div>
									                                <div class='profile-info-value'>
									                                    <span> ". $UnitInfo['typeofbusiness'] ." </span>
									                                </div>
									                            </div>
									                            <div class='profile-info-row'>
									                                <div class='profile-info-name' style='white-space: nowrap;'> Unit No. </div>
									                                <div class='profile-info-value'>
									                                    <span> ". $UnitInfo['unitname'] ." </span>
									                                </div>
									                            </div>";
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
									                            </div>";
									                            if(SysLeaseSetup('floorandunitmeasurement') == "Area"){
									                            	echo " <div class='profile-info-row'>
												                                <div class='profile-info-name' style='white-space: nowrap;'> Area </div>
												                                <div class='profile-info-value'>
												                                    <span> ". number_format($UnitInfo['area'], "2", ".", ",") ." SQM</span>
												                                </div>
												                            </div>";
									                            }else{
									                            	echo " <div class='profile-info-row'>
												                                <div class='profile-info-name' style='white-space: nowrap;'> Length </div>
												                                <div class='profile-info-value'>
												                                    <span> ". number_format($UnitInfo['sqm_height'], "2", ".", ",") ." SQM</span>
												                                </div>
												                            </div><div class='profile-info-row'>
												                                <div class='profile-info-name' style='white-space: nowrap;'> Width </div>
												                                <div class='profile-info-value'>
												                                    <span> ". number_format($UnitInfo['sqm_width'], "2", ".", ",") ." SQM</span>
												                                </div>
												                            </div>";
								                            	}
									                       echo "<div class='profile-info-row'>
									                             	<div class='profile-info-name'> Rate </div>
									                             	<div class='profile-info-value'>
									                                 	<span> ". number_format($UnitInfo['pricepersqmunitsetup'], "2", ".", ",") ." </span>
									                             	</div>
									                         	</div>";
									                            if(SysLeaseSetup('isAssocDues') == '1'){
									                    echo    "<div class='profile-info-row'>
									                             	<div class='profile-info-name' style='white-space: nowrap;'> Association Dues </div>
									                             	<div class='profile-info-value'>
									                                 	<span> ". number_format($UnitInfo['assocdues'], "2", ".", ",") ." </span>
									                             	</div>
									                         	</div>";
									                            }
								                    echo    "</div>
								                   		</div>
								                    </div>
													<div class='col-md-6'>
								                        <div class='row form-group'>
								                        	<h4 class='header blue'>Amenities</h4>
								                        </div>
								                        <div class='row form-group'>";
															$resAmenities = mysql_query("SELECT amenitiesID FROM tblref_unit_amenities WHERE unitID = '". $UnitInfo['unitid'] ."';", $connection);
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
				                    				echo"</div>
				                    				</div>";
				                    				$OtherInfo = mysql_fetch_array(mysql_query("SELECT OtherUnitInfo FROM tblref_unit WHERE unitid = '". $UnitInfo['unitid'] ."';", $connection));
													if($OtherInfo['OtherUnitInfo'] != ""){
									                echo 	"<div class='col-md-12' style='margin-top: 10px;'>
									                			<div class='row'>
										                			<div class='col-md-12'>
									                					<h4 class='header blue'>Other Unit Information</h4>
									                				<div>
								                				</div>
								                			</div>
								                			<div class='col-md-12'>
									                			<div class='row'>
										                			<div class='col-md-12'>
									                					". $OtherInfo['OtherUnitInfo'] ."
								                					</div>
								                				</div>
								                			</div>";
								                	}
				                    	echo	"</div>
											</div>
										</div>
									</div>
								</div>";
						$rowCount++;
					}
					echo "</div>";
				}

	            if($UnitCount == 1){
	            	$TotalPriceperSQM2 = $TotalPriceperSQM;
	            	$TotalAmount2 = $TotalAmount;
	            }else{
	            	$TotalPriceperSQM2 = 0.00;
	            	$TotalAmount2 = 0.00;
	            }

				echo "|". number_format($TotalAmount2, 2, '.', ',') . "|" . number_format($TotalArea, 2, '.', ',') . "|" . number_format($TotalPriceperSQM2, 2, '.', ',');
			}
		break;

		case 'checkSelectedUnits':
			$arr = explode("|", $_POST['UnitIDs']);
			for ($i=0; $i <= count($arr)-2; $i++) { 
				$UnitIDArr .= "'" . $arr[$i] . "'" . ",";
			}
			if($_POST['UnitIDs'] != ""){
				$Mall = mysql_num_rows(mysql_query("SELECT mallid FROM tblref_unit WHERE unitid IN (". substr(trim($UnitIDArr), 0, -1) .") GROUP BY mallid;", $connection));
				$MallID = mysql_fetch_array(mysql_query("SELECT mallid FROM tblref_unit WHERE unitid IN (". substr(trim($UnitIDArr), 0, -1) .") GROUP BY mallid;", $connection));
				if($Mall == 1){
					echo "1|".$MallID['mallid'];
				}else{
					echo "2|You cannot select a unit on different mall.";
				}
			}else{
				echo "3|Please select a unit.";
			}
		break;

		case 'fncRemoveSUinList':
			$SubUnits = "";
			$res = mysql_query("SELECT unitid FROM tblref_unit WHERE MainUnit = '". $_POST['UnitID'] ."';", $connection);
			while($row = mysql_fetch_array($res)){
				$SubUnits .= $row['unitid'] . "|";
			}
			echo $SubUnits;
		break;
	//Unit List End -- Jonathan Jonas Bondoc September 10, 2019

	//Store List Start -- Jonathan Jonas Bondoc July 31, 2019
		case 'fncLoadTradeList':
			$page = $_POST['page'];
			$limit = ($page-1) * 20;
			$result = mysql_query("SELECT companyID, tradename, merchant_code, automerchant_code, tradeID FROM tbltrans_tradename WHERE tradename LIKE '%".$_POST['txtsearchtradename']."%' ORDER BY tradename LIMIT ". $limit .",20;", $connection);
			while($row = mysql_fetch_array($result)){
				$CompanyInfo = mysql_fetch_array(mysql_query("SELECT company FROM tbltrans_company WHERE companyID = '". $row['companyID'] ."';", $connection));
				if(SysLeaseSetup('automerchantcode') == "1"){
					if($row["merchant_code"] == "" && $row['automerchant_code'] == ""){
                    	$MerchantCode = "";
					}else{
                    	$MerchantCode = $row["merchant_code"] . "-" . $row['automerchant_code'];
					}
                }else{
                    $MerchantCode = $row["merchant_code"];
                }
				echo "	<tr>
							<td style='vertical-align: middle;' onclick='fncSelectTradeProfile(\"". $row['companyID'] ."\", \"". $row['tradeID'] ."\")'>". $MerchantCode ."</td>
							<td style='vertical-align: middle;' onclick='fncSelectTradeProfile(\"". $row['companyID'] ."\", \"". $row['tradeID'] ."\")'>". $row['tradename'] ."</label></td>
							<td style='vertical-align: middle;' onclick='fncSelectTradeProfile(\"". $row['companyID'] ."\", \"". $row['tradeID'] ."\")'>". $CompanyInfo['company'] ."</td>
							<td style='vertical-align: middle;'>
								<button class='btn btn-light btn-sm btn-round' onclick='fncEditTradeInfo(\"".$row["tradeID"]."\")'><i class='fa green fa-pencil bigger-110' style='display:inline;'></i></button>
							</td>
					  	</tr>";
			}
		break;

        case 'fncTradeEntries':
           	if($_POST["page"] == ""){
               	$page = 1;
           	}else{
               	$page = $_POST["page"];
           	}
           	$limit = ($page-1) * 20;
            $rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(tradeID) FROM tbltrans_tradename WHERE tradename LIKE '%".$_POST['txtsearchtradename']."%';", $connection));
            $rowsperpage = 20;
            $totalpages = ceil($rowCount[0] / $rowsperpage);
            $upto = $limit + 20;
            $from = $limit + 1;
            if($page == $totalpages && $rowCount[0] != 0){
                echo "Showing ". $from ." to ". $rowCount[0] ." of ". $rowCount[0] ." entries";
            }else{
                if($rowCount[0] == 0){
                   	echo "";
                }else if($rowCount[0] <= 19 && $rowCount[0] != 0){
                   	echo "Showing 1 to ". $rowCount[0] ." of ". $rowCount[0] ." entries";
                }else if($rowCount[0] >= 20 && $rowCount[0] != 0){
                   	echo "Showing ". $from ." to ". $upto ." of ". $rowCount[0] ." entries";
                }
            }
       	break;

		case "fncTradePagination":
		    $page = $_POST["page"];
			$rowCount = mysql_fetch_row(mysql_query("SELECT COUNT(tradeID) FROM tbltrans_tradename WHERE tradename LIKE '%".$_POST['txtsearchtradename']."%';", $connection));
			$rowsperpage = 20;
			$range = 3;
			$totalpages = ceil($rowCount[0] / $rowsperpage);
			$prevpage;
			$nextpage;
			if($page > 1 ){
			   	echo "<li style='width:50px !important;' onclick='fncTradebtnPagination(1)'><< First</li>";
			   	$prevpage = $page - 1;
			   	echo "<li style='width:70px !important;' onclick='fncTradebtnPagination(". $prevpage .")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if (($x > 0) && ($x <= $totalpages)){
    			    if ($x == $page){
                        echo "<li id='pg". $x ."' class='pgnum active' onclick='fncTradebtnPagination(". $x .",". $x .")'>". $x ."</li>";
                    }else{
    			        echo "<li id='pg". $x ."' class='pgnum' onclick='fncTradebtnPagination(". $x .",". $x .")'>". $x ."</li>";
                    }
		       	}
		    }
		    if($page < ($totalpages - $range)){
                echo "<li>...</li>";
            }
		    if ($page != $totalpages && $rowCount[0] != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='fncTradebtnPagination(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='fncTradebtnPagination(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

        case 'fncEditTradeInfo':
       		$row = mysql_fetch_array(mysql_query("SELECT tradename, companyID, filename, merchant_code, automerchant_code, BillSetup, BillID FROM tbltrans_tradename WHERE tradeID = '". $_POST["TradeID"] ."';", $connection));
       		$company = mysql_fetch_array(mysql_query("SELECT Company, industry, businessAddress FROM tbltrans_company WHERE CompanyID = '". $row["companyID"] ."';", $connection));
       		$Industry = mysql_fetch_array(mysql_query("SELECT Industry FROM tblref_industry WHERE Industry_ID = '". $company['industry'] ."';", $connection));
       		if($row["filename"] == ""){
				$StoreImage = "assets/images/noimage5.png";
			}else{
				if(!file_exists("../../Mall_Attachments/company/". $row["companyID"] ."/trades/". $_POST["TradeID"] ."/". $row["filename"])){
                	$StoreImage = "assets/images/noimage5.png";
				}else{
					$StoreImage = "../Mall_Attachments/company/". $row["companyID"] ."/trades/". $_POST["TradeID"] ."/". $row["filename"];
				}
			}

			if(SysLeaseSetup('automerchantcode') == "1"){
				if($row["merchant_code"] == "" && $row['automerchant_code'] == ""){
                	$MerchantCode = "";
				}else{
                	$MerchantCode = $row["merchant_code"] . "-" . $row['automerchant_code'];
				}
            }else{
                $MerchantCode = $row["merchant_code"];
            }

            echo $StoreImage . "|" . $row['tradename'] . "|" . $MerchantCode . "|" . $company["Company"] . "|" . $row['companyID'] . "|" . $Industry["Industry"] . "|" . $company["businessAddress"] . "|" . $row["BillSetup"] . "|" . $row['BillID'];
        break;

		case 'fncLoadBillingAccountList':
			$page = $_POST['page'];
			$limit = ($page-1) * 20;
			$res = mysql_query("SELECT BillerID, BillerName, Telephone, BillingAddress FROM tblref_billprofile WHERE BillerName LIKE '%". $_POST['key'] ."%' ORDER BY BillerName ASC LIMIT ".$limit.",20;", $connection);
			while($row = mysql_fetch_array($res)){
				echo 	"<tr onclick='fncclickBillProfile(\"". $row['BillerID'] ."\")'>
							<td>". $row['BillerName'] ."</td>
							<td>". $row['Telephone'] ."</td>
							<td>". $row['BillingAddress'] ."</td>
						</tr>";
			}
		break;

		case 'fncBillProfileEntries':
           	if($_POST["page"] == ""){
               	$page = 1;
           	}else{
               	$page = $_POST["page"];
           	}
           	$limit = ($page-1) * 20;
            $rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM tblref_billprofile WHERE BillerName LIKE '%".$_POST['key']."%';", $connection));
            $rowsperpage = 20;
            $totalpages = ceil($rowCount[0] / $rowsperpage);
            $upto = $limit + 20;
            $from = $limit + 1;
            if($page == $totalpages && $rowCount[0] != 0){
                echo "Showing ". $from ." to ". $rowCount[0] ." of ". $rowCount[0] ." entries";
            }else{
                if($rowCount[0] == 0){
                   	echo "";
                }else if($rowCount[0] <= 19 && $rowCount[0] != 0){
                   	echo "Showing 1 to ". $rowCount[0] ." of ". $rowCount[0] ." entries";
                }else if($rowCount[0] >= 20 && $rowCount[0] != 0){
                   	echo "Showing ". $from ." to ". $upto ." of ". $rowCount[0] ." entries";
                }
            }
       	break;

		case "fncBillProfilePagination":
		    $page = $_POST["page"];
			$rowCount = mysql_fetch_row(mysql_query("SELECT COUNT(id) FROM tblref_billprofile WHERE BillerName LIKE '%".$_POST['key']."%';", $connection));
			$rowsperpage = 20;
			$range = 3;
			$totalpages = ceil($rowCount[0] / $rowsperpage);
			$prevpage;
			$nextpage;
			if($page > 1 ){
			   	echo "<li style='width:50px !important;' onclick='fncBillProfilebtnPagination(1)'><< First</li>";
			   	$prevpage = $page - 1;
			   	echo "<li style='width:70px !important;' onclick='fncBillProfilebtnPagination(". $prevpage .")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if (($x > 0) && ($x <= $totalpages)){
    			    if ($x == $page){
                        echo "<li id='pg". $x ."' class='pgnum active' onclick='fncBillProfilebtnPagination(". $x .",". $x .")'>". $x ."</li>";
                    }else{
    			        echo "<li id='pg". $x ."' class='pgnum' onclick='fncBillProfilebtnPagination(". $x .",". $x .")'>". $x ."</li>";
                    }
		       	}
		    }
		    if($page < ($totalpages - $range)){
                echo "<li>...</li>";
            }
		    if ($page != $totalpages && $rowCount[0] != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='fncBillProfilebtnPagination(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='fncBillProfilebtnPagination(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'fncclickBillProfile':
			$rowBillInfo = mysql_fetch_array(mysql_query("SELECT BillerName, Telephone, BillingAddress, PermanentAddress, CurrentAddress, BillingAddress, Mobile, Email FROM tblref_billprofile WHERE BillerID = '". $_POST['BillerID'] ."';", $connection));
			echo $rowBillInfo['BillerName'] . "|" . $rowBillInfo['Telephone'] . "|" . $rowBillInfo['BillingAddress'] . "|" . $rowBillInfo['PermanentAddress'] . "|" . $rowBillInfo['CurrentAddress'] . "|" . $rowBillInfo['Mobile'] . "|" . $rowBillInfo['Email'];
		break;
	//Store List End -- Jonathan Jonas Bondoc July 31, 2019

	//Company List Start -- Jonathan Jonas Bondoc July 31, 2019
		case 'loadcompanylist':
			$page = $_POST['page'];
			$limit = ($page-1) * 20;
			$result = mysql_query("SELECT CompanyID, company, BillerID, industry FROM tbltrans_company WHERE Company LIKE '%". $_POST['txtsearchcompany'] ."%' OR CompanyID LIKE '%". $_POST['txtsearchcompany'] ."%';", $connection);
			while($row = mysql_fetch_array($result)){
				$IndustryInfo = mysql_fetch_array(mysql_query("SELECT Industry FROM tblref_industry WHERE Industry_ID = '". $row['industry'] ."';", $connection));
				echo "	<tr>
							<td style='vertical-align: middle;' onclick='selectthiscompanyforref(\"". $row["CompanyID"] ."\", \"". $row['BillerID'] ."\")'>".$row["company"]."</td>
							<td style='vertical-align: middle;' onclick='selectthiscompanyforref(\"". $row["CompanyID"] ."\", \"". $row['BillerID'] ."\")'>".$IndustryInfo["Industry"]."</td>
							<td style='z-index: 0; text-align: center;'><button class='btn btn-light btn-sm btn-round' onclick='updatecompany(\"".$row["CompanyID"]."\", \"". $row['BillerID'] ."\")'><i class='fa green fa-pencil bigger-110' style='display:inline;'></i></button></td>
					  	</tr>";
			}
		break;

		case 'loadentriescompanylist':
			$search = " (company LIKE '%". $_POST['txtsearchcompany'] ."%' OR businessaddress LIKE '%". $_POST['txtsearchcompany'] ."%')";
           	if($_POST["page"] == ""){
               $page = 1;
           	}else{
               $page = $_POST["page"];
           	}
           	$limit = ($page-1) * 20;
            $row = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM tbltrans_company WHERE Company LIKE '%". $_POST['txtsearchcompany'] ."%' OR CompanyID LIKE '%". $_POST['txtsearchcompany'] ."%';", $connection));
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
       break;

		case "loadpagecompanylist":
			$search = " (company LIKE '%". $_POST['txtsearchcompany'] ."%' OR businessaddress LIKE '%". $_POST['txtsearchcompany'] ."%')";
		    $page = $_POST["page"];
			$nums = mysql_fetch_row(mysql_query("SELECT COUNT(*) FROM tbltrans_company WHERE Company LIKE '%". $_POST['txtsearchcompany'] ."%' OR CompanyID LIKE '%". $_POST['txtsearchcompany'] ."%';", $connection));
			$num = $nums[0];
			$rowsperpage = 20;
			$range = 3;
			$totalpages = ceil($num / $rowsperpage);
			$prevpage;
			$nextpage;
			if($page > 1 ){
			   	echo "<li style='width:50px !important;' onclick='pagination(1)'><< First</li>";
			   	$prevpage = $page - 1;
			   	echo "<li style='width:70px !important;' onclick='pagination(". $prevpage .")'>< Previous</li>";
			}

			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if(($x > 0) && ($x <= $totalpages)){
    			    if($x == $page){
                        echo "<li id='pg" . $x . "' class='pgnum active' onclick='pagination(" . $x . ",". $x .")'>" . $x . "</li>";
                    }else{
    			        echo "<li id='pg" . $x . "' class='pgnum' onclick='pagination(" . $x . ",". $x .")'>" . $x . "</li>";
                    }
		       	}
		    }
		    if($page < ($totalpages - $range)){
                echo "<li>...</li>";
            }
		    if ($page != $totalpages && $num != 0){
		       $nextpage = $page + 1;
		       echo "<li style='width:50px !important;' onclick='pagination(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       echo "<li style='width:50px !important;' onclick='pagination(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;		

		case 'selectthiscompanyforref':
			$row = mysql_fetch_array(mysql_query("SELECT CompanyID, Company, industry, businessAddress, owner_firstname, owner_middlename, owner_lastname, billing_address FROM tbltrans_company WHERE CompanyID = '".$_POST["companyid"]."';", $connection));
			$IndustryInfo = mysql_fetch_array(mysql_query("SELECT Industry FROM tblref_industry WHERE Industry_ID = '". $row['industry'] ."';", $connection));
			echo $row["CompanyID"] . "|" . $row["Company"] . "|" . $IndustryInfo["Industry"] . "|" . $row["businessAddress"] . "|" . $row['owner_firstname'] . "|" . $row['owner_middlename'] . "|" . $row['owner_lastname'] . "|" . $row['billing_address'];
		break;

		case 'fncSaveIndustry':
			$getCount = mysql_num_rows(mysql_query("SELECT id FROM tblref_industry WHERE Industry = '". $_POST['indCode'] ."';", $connection));
			if($getCount == 0){
				$res = mysql_query("INSERT INTO tblref_industry SET Industry_ID = '". $_POST['indCode'] ."', Industry = '". $_POST['Industry'] ."';", $connection);
				if($res == true){
					echo 1;
				}else{
					echo 3;
				}
			}else{
				echo 2;
			}
		break;

		case 'fncSavePosition':
			$getCount = mysql_num_rows(mysql_query("SELECT id FROM tblref_companyposition WHERE xposition = '". $_POST['Position'] ."';", $connection));
			if($getCount == 0){
				$res = mysql_query("INSERT INTO tblref_companyposition SET xposition = '". $_POST['Position'] ."';", $connection);
				if($res == true){
					echo 1;
				}else{
					echo 3;
				}
			}else{
				echo 2;
			}
		break;
	//Company List End -- Jonathan Jonas Bondoc July 31, 2019

	//Inquiry Start - Jonathan Jonas Bondoc September 24, 2019
		case 'mdlTradeInfo':
			$TradeInfo = mysql_fetch_array(mysql_query("SELECT tradename, merchant_code, automerchant_code, filename, BillSetup FROM tbltrans_tradename WHERE tradeID = '". $_POST['tradeID'] ."';", $connection));
			$CompanyInfo = mysql_fetch_array(mysql_query("SELECT company, Industry, permanent_address, current_address, businessAddress FROM tbltrans_company WHERE CompanyID = '". $_POST['companyID'] ."';", $connection));
			$IndustryInfo = mysql_fetch_array(mysql_query("SELECT Industry FROM tblref_industry WHERE Industry_ID = '". $CompanyInfo['Industry'] ."';", $connection));
			

			if(SysLeaseSetup('automerchantcode') == "1"){
				if($TradeInfo["merchant_code"] == "" && $TradeInfo['automerchant_code'] == ""){
                	$MerchantCode = "";
				}else{
                	$MerchantCode = $TradeInfo["merchant_code"] . "-" . $TradeInfo['automerchant_code'];
				}
            }else{
                $MerchantCode = $TradeInfo["merchant_code"];
            }

            if($TradeInfo['filename'] == ""){
				$StoreImage = "assets/images/noimage5.png";
			}else{
				if(!file_exists("../../Mall_Attachments/company/". $_POST['companyID'] ."/trades/". $_POST['tradeID'] ."/". $TradeInfo['filename'])){ 
                	$StoreImage = "assets/images/noimage5.png";
				}else{
					$StoreImage = "../Mall_Attachments/company/". $_POST['companyID'] ."/trades/". $_POST['tradeID'] ."/". $TradeInfo['filename'];
				}
			}

			echo $TradeInfo['tradename'] . "|" . $CompanyInfo['company'] . "|" . $CompanyInfo['Industry'] . "|" . $IndustryInfo['Industry'] . "|" . $MerchantCode . "|" . $CompanyInfo['businessAddress'] . "|" . $StoreImage . "|" . $TradeInfo['BillSetup'];
		break;
	//Inquiry End - Jonathan Jonas Bondoc September 24, 2019
	}
?>