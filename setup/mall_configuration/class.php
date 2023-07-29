<?php
	session_start();
	include("../../connect.php");
	$title = mysql_fetch_array(mysql_query("SELECT softwaretype FROM tblsys_setup;", $connection));
	if($title[0] == "0"){
		$label =  "Mall";
	}else if($title[0] == "1"){
		$label =  "Property";
	}else if($title[0] == "2"){
		$label =  "Building";
	}
	function columnLetter($c){
	    $c = intval($c);
	    if ($c <= 0) return '';
	    $letter = '';
	    while($c != 0){
	       $p = ($c - 1) % 26;
	       $c = intval(($c - $p) / 26);
	       $letter = chr(65 + $p) . $letter;
	    }
	    return $letter;
	}
	switch($_POST["form"]){	
		case 'fncSaveMallCompany':
			if($_POST['MallCompanyID'] == ''){
				$MallCompanyID = createidno("MCC", "tblref_mallcompany", "MallCompanyID");
				$Alert = "Mall Company successfully created.";
				$sqlMallCompany = "INSERT INTO tblref_mallcompany SET MallCompanyID = '". $MallCompanyID ."', MallCompanyName = '". mysql_escape_string($_POST['MallCompanyName']) ."', MallCompanyAbout = '". mysql_escape_string($_POST['MallCompanyAbout']) ."', MallCompanyMobile = '". mysql_escape_string($_POST['MallCompanyMobile']) ."', MallCompanyTelephone = '". mysql_escape_string($_POST['MallCompanyTelephone']) ."', MallCompanyEmailAdd = '". mysql_escape_string($_POST['MallCompanyEmail']) ."', MallCompanyAddress = '". mysql_escape_string($_POST['MallCompanyAddress']) ."', userid = '". $_SESSION['MMS-UserID'] ."';";
			}else{
				$MallCompanyID = $_POST['MallCompanyID'];
				$Alert = "Mall Company successfully updated.";
				$sqlMallCompany = "UPDATE tblref_mallcompany SET MallCompanyName = '". mysql_escape_string($_POST['MallCompanyName']) ."', MallCompanyAbout = '". mysql_escape_string($_POST['MallCompanyAbout']) ."', MallCompanyMobile = '". mysql_escape_string($_POST['MallCompanyMobile']) ."', MallCompanyTelephone = '". mysql_escape_string($_POST['MallCompanyTelephone']) ."', MallCompanyEmailAdd = '". mysql_escape_string($_POST['MallCompanyEmail']) ."', MallCompanyAddress = '". mysql_escape_string($_POST['MallCompanyAddress']) ."' WHERE MallCompanyID = '". $_POST['MallCompanyID'] ."';";
			}
			$resMallCompany = mysql_query($sqlMallCompany, $connection);
			if($resMallCompany == true){
				echo "1|".$Alert."|".$MallCompanyID;
			}else{
				if($_POST['MallCompanyID'] == ""){
					$ErrorAlert = "Failed to create mall company.";
				}else{
					$ErrorAlert = "Failed to update mall company.";
				}
				echo "2|".$ErrorAlert."|";
			}
		break;

		case 'fncloadMallCompanyList':
			$res = mysql_query("SELECT MallCompanyID, MallCompanyName, MallCompanyAbout, MallCompanyMobile, MallCompanyTelephone, MallCompanyEmailAdd, MallCompanyAddress, MallCompanyImage FROM tblref_mallcompany;", $connection);
			while($row = mysql_fetch_array($res)){
				if($row["MallCompanyImage"] == ""){
					$MallCompanyImage = "assets/images/noimage5.png";
				}else{
					if(!file_exists("../../../Mall_Attachments/Mall_Company/".$row["MallCompanyImage"])){ 
						$MallCompanyImage = "assets/images/noimage5.png";
					}else{
						$MallCompanyImage = "../Mall_Attachments/Mall_Company/".$row["MallCompanyImage"];
					}
				}
				echo 	"<div class='row'>
							<div class='col-xs-12 col-sm-3 center'>
								<span class='profile-picture'>
									<img class='editable img-responsive' alt='". $row['MallCompanyName'] ."' src='". $MallCompanyImage ."'>
								</span>
							</div>
							<div class='col-xs-12 col-sm-7'>
								<div class='row'>
									<div class='col-md-12'>
										<h4 class='blue header bolder'>". $row['MallCompanyName'] ."</h4>
									</div>
									<div class='col-md-12'>
										<div class='row form-group'>
											<div class='profile-user-info profile-user-info-striped'>
												<div class='profile-info-row'>
													<div class='profile-info-name'> About </div>
													<div class='profile-info-value'>
														<span>". $row['MallCompanyAbout'] ."</span>
													</div>
												</div>

												<div class='profile-info-row'>
													<div class='profile-info-name'> Mobile No </div>
													<div class='profile-info-value'>
														<span>". $row['MallCompanyMobile'] ."</span>
													</div>
												</div>

												<div class='profile-info-row'>
													<div class='profile-info-name'> Telephone No </div>
													<div class='profile-info-value'>
														<span>". $row['MallCompanyTelephone'] ."</span>
													</div>
												</div>

												<div class='profile-info-row'>
													<div class='profile-info-name'> Email Address </div>
													<div class='profile-info-value'>
														<span>". $row['MallCompanyEmailAdd'] ."</span>
													</div>
												</div>

												<div class='profile-info-row'>
													<div class='profile-info-name'> Address </div>
													<div class='profile-info-value'>
														<span>". $row['MallCompanyAddress'] ."</span>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class='col-xs-12 col-sm-2'>
                            	<button class='btn btn-light btn-sm hide isadmin select-editmallcompany btn-round' style='width: 100%; margin-bottom: 5px;' onclick='fncEditMallCompany(\"". $row["MallCompanyID"] ."\")'><span class='bigger-110 no-text-shadow'>Edit</span></button>
							</div>
						</div>
						<hr>";
			}
		break;

		case 'fncEditMallCompany':
			$MallCompanyInfo = mysql_fetch_array(mysql_query("SELECT MallCompanyName, MallCompanyAbout, MallCompanyMobile, MallCompanyTelephone, MallCompanyEmailAdd, MallCompanyAddress, MallCompanyImage FROM tblref_mallcompany WHERE MallCompanyID = '". $_POST['MallCompanyID'] ."';", $connection));
			if($MallCompanyInfo["MallCompanyImage"] == ""){
				$MallCompanyImage = "assets/images/noimage5.png";
			}else{
				if(!file_exists("../../../Mall_Attachments/Mall_Company/".$MallCompanyInfo["MallCompanyImage"])){ 
					$MallCompanyImage = "assets/images/noimage5.png";
				}else{
					$MallCompanyImage = "../Mall_Attachments/Mall_Company/".$MallCompanyInfo["MallCompanyImage"];
				}
			}
			echo $MallCompanyInfo['MallCompanyName'] . "|" . $MallCompanyInfo['MallCompanyAbout'] . "|" . $MallCompanyInfo['MallCompanyMobile'] . "|" . $MallCompanyInfo['MallCompanyTelephone'] . "|" . $MallCompanyInfo['MallCompanyEmailAdd'] . "|" . $MallCompanyInfo['MallCompanyAddress'] . "|" . $MallCompanyImage;
		break;

		case 'fncloadCompanyList':
			echo "<option value=''>-- Select Company --</option>";
			$res = mysql_query("SELECT MallCompanyID, MallCompanyName FROM tblref_mallcompany;", $connection);
			while($row = mysql_fetch_array($res)){
				echo "<option value='". $row['MallCompanyID'] ."'>". $row['MallCompanyName'] ."</option>";
			}
		break;

		case 'ifleasingisselected':
			$checksetup = mysql_fetch_array(mysql_query("SELECT softwaretype FROM tblsys_setup", $connection));
			echo $checksetup[0];
		break;

		case 'loaddivmalls':
			$count = 0;
			$sql = "SELECT mallid, mallname, malladdress, dateadded, mall_image, abouts, telephone_number, email, mallstat, corp_ID FROM tblref_mall";
			$softwaretype = mysql_fetch_array(mysql_query("SELECT softwaretype FROM tblsys_setup", $connection));
			if($softwaretype[0] == "0"){
				$text = "Mall Name";
			}else if($softwaretype[0] == "1"){
				$text = "Branch Name";
			}else if($softwaretype[0] == "2"){
				$text = "Building Name";
			}
			$res = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($res)){
				if($row["mall_image"] == ""){
					$MallImage = "assets/images/noimage5.png";
				}else{
					if(!file_exists("../../../Mall_Attachments/mall_image/".$row["mall_image"])){ 
						$MallImage = "assets/images/noimage5.png";
					}else{
						$MallImage = "../Mall_Attachments/mall_image/".$row["mall_image"];
					}
				}

				if($row['mallstat'] == "1"){
					$mStat = "info";
					$TextColor = "blue";
				}else{
					$mStat = "danger";
					$TextColor = "red";
				}

				if($count % 2 == 0) {
					$bgcolor = "#edf4f8";
				}else{
					$bgcolor = "";
				}

				$CompanyInfo = mysql_fetch_array(mysql_query("SELECT MallCompanyName FROM tblref_mallcompany WHERE MallCompanyID = '". $row['corp_ID'] ."';", $connection));

				echo 	"<div class='row'>
							<div class='col-xs-12 col-sm-3 center'>
								<span class='profile-picture'>
									<img class='editable img-responsive' alt='". $row['MallCompanyName'] ."' src='". $MallImage ."'>
								</span>
							</div>
							<div class='col-xs-12 col-sm-7'>
								<div class='row'>
									<div class='col-md-12'>
										<h4 class='blue header bolder'>". $row['mallname'] ."</h4>
									</div>
									<div class='col-md-12'>
										<div class='row form-group'>
											<div class='profile-user-info profile-user-info-striped'>
												<div class='profile-info-row'>
													<div class='profile-info-name'> Company </div>
													<div class='profile-info-value'>
														<span>". $CompanyInfo['MallCompanyName'] ."</span>
													</div>
												</div>

												<div class='profile-info-row'>
													<div class='profile-info-name'> Location </div>
													<div class='profile-info-value'>
														<span>". $row['malladdress'] ."</span>
													</div>
												</div>

												<div class='profile-info-row'>
													<div class='profile-info-name'> About </div>
													<div class='profile-info-value'>
														<span>". $row['abouts'] ."</span>
													</div>
												</div>

												<div class='profile-info-row'>
													<div class='profile-info-name'> Telephone No </div>
													<div class='profile-info-value'>
														<span>". $row['telephone_number'] ."</span>
													</div>
												</div>

												<div class='profile-info-row'>
													<div class='profile-info-name'> Email Address </div>
													<div class='profile-info-value'>
														<span>". $row['email'] ."</span>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class='col-xs-12 col-sm-2'>
                            	<button class='btn btn-light btn-sm hide isadmin select-editmallinformation btn-round' style='width: 100%; margin-bottom: 5px;' onclick='fncloadCompanyList(); editmall(\"".$row["mallid"]."\")'>
	                                        <span class='bigger-110 no-text-shadow'>Edit</span>
	                                    </button>
	                                    <button class='btn btn-info btn-sm hide isadmin select-configuremall btn-round' style='width: 100%; margin-bottom: 5px;' onclick='configuremall(\"".$row["mallid"]."\")'>
	                                        <span class='bigger-110 no-text-shadow'>Configure</span>
	                                    </button>";
	                                    if($row['mallstat'] == "1"){
	                                    	?> <button class='btn btn-warning btn-sm hide isadmin select-activateordeactivatemall btn-round' style='width: 100%; margin-bottom: 5px;' onclick='deletemall("<?php echo $row["mallid"]; ?>")'><span class='bigger-110 no-text-shadow'>Deactivate</span></button><?php
	                                    }else{
	                                    	?> <button class='btn btn-success btn-sm hide isadmin select-activateordeactivatemall btn-round' style='width: 100%; margin-bottom: 5px;' onclick='reactivate("<?php echo $row["mallid"]; ?>")'><span class='bigger-110 no-text-shadow'>Reactivate</span></button><?php
	                                    }
				echo		"</div>
						</div>
						<hr>";
					$count++;
			}
		break;

		case 'maxmallcount':
        	$row = mysql_fetch_array(mysql_query("SELECT maxnumofmall from tblsys_setup;", $connection));
        	echo $row[0];
        break;

        case 'loadmallcount':
        	$row = mysql_fetch_array(mysql_query("SELECT COUNT(*) from tblref_mall;", $connection));
			echo $row[0];
        break;

  		case 'editmallinformation':
			$sql = "SELECT mallid, mallname, malladdress, abouts, mall_image, telephone_number, email, tinnumber, TenantIDPref, corp_ID FROM tblref_mall WHERE mallid = '".$_POST["id"]."';";
			$result = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($result)){
				if($row["mall_image"] == ""){
					$image = "assets/images/noimage5.png";
				}else{
					if(!file_exists("../../../Mall_Attachments/mall_image/".$row["mall_image"])){ 
						$image = "assets/images/noimage5.png";
					}else{
						$image = "../Mall_Attachments/mall_image/".$row["mall_image"];
					}
				}
				echo $row["mallid"] . "|" . $row["mallname"] . "|" . $row["malladdress"] . "|" . $row["abouts"] . "|" . $image . "|" . $row[5] . "|" . $row[6] . "|" . $row[7] . "|" . $row['TenantIDPref'] . "|" . $row['corp_ID'];
			}
		break;

		case 'savemallupdate':
			$filepath = mysql_fetch_array(mysql_query("SELECT filepath, mallprefix FROM tblsys_setup;", $connection));
			if($_POST["id"] == ""){
				$mallid = createidno($filepath['mallprefix'], "tblref_mall", "mallid");
				$sql = "INSERT INTO tblref_mall SET mallid = '". $mallid ."', mallname = '". mysql_escape_string($_POST["name"]) ."', malladdress = '". mysql_escape_string($_POST["loc"]) ."', abouts = '". mysql_escape_string($_POST["abouts"]) ."', telephone_number = '". mysql_escape_string($_POST['telephone']) ."', email = '". mysql_escape_string($_POST['email']) ."', tinnumber = '". mysql_escape_string($_POST['tinnumber']) ."', dateadded = '". date('Y-m-d') ."', TenantIDPref = '". $_POST['TenantIDPref'] ."', corp_ID = '". $_POST['company'] ."';";
				$alert = "1|".$mallid . "|";
				if($filepath[0] != ""){
					$SetupRecord = mysql_query("INSERT INTO mall_setup SET mall_id = '". $mallid ."';", $connection);
					if (!file_exists($filepath[0].$mallid)) {
						mkdir($filepath[0].$mallid, 0777, true);
					}
				}
				//INSERT LOG FIRST - JONAS - 12/7/2018
				$arrHeader = ["Mall ID", "Mall Name", "Mall Address", "About", "Telephone Number", "E-mail", "TIN Number"];
				$arrValue = [$mallid, mysql_escape_string($_POST["name"]), mysql_escape_string($_POST["loc"]), mysql_escape_string($_POST["abouts"]), mysql_escape_string($_POST["telephone"]), mysql_escape_string($_POST["email"]), mysql_escape_string($_POST["tinnumber"])];
				$Logs = createXinfo("INSERT", $arrHeader, "", $arrValue, "", "", "");
				if($Logs != ""){
					$tran_logs = create_logs_per_transaction("added a " . $label . ".", $label . " Configuration", $Logs, "" ,"ADD", "");
				}
				//INSERT LOG FIRST - JONAS - 12/7/2018
			}else{
				$sql = "UPDATE tblref_mall SET mallname = '". mysql_escape_string($_POST["name"]) ."',  malladdress = '". mysql_escape_string($_POST["loc"]) ."', abouts = '". mysql_escape_string($_POST["abouts"]) ."', telephone_number = '". mysql_escape_string($_POST['telephone']) ."', email = '". mysql_escape_string($_POST['email']) ."', tinnumber = '". mysql_escape_string($_POST['tinnumber']) ."', TenantIDPref = '". $_POST['TenantIDPref'] ."', corp_ID = '". $_POST['company'] ."' WHERE mallid = '". $_POST["id"] ."';";
				$alert = "2|".$_POST["id"] . "|";
				if($filepath[0] != ""){
					if (!file_exists($filepath[0].$mallid)) {
						mkdir($filepath[0].$mallid, 0777, true);
					}
				}
				//INSERT UPDATE LOG FIRST - JONAS - 12/7/2018
				$arrHeader = ["Mall ID", "Mall Name", "Mall Address", "About", "Telephone Number", "E-mail", "TIN Number"];
				$arrFields = ["mallid", "mallname", "malladdress", "abouts", "telephone_number", "email", "tinnumber"];
				$arrValue = [$mallid, mysql_escape_string($_POST["name"]), mysql_escape_string($_POST["loc"]), mysql_escape_string($_POST["abouts"]), mysql_escape_string($_POST["telephone"]), mysql_escape_string($_POST["email"]), mysql_escape_string($_POST["tinnumber"])];
				$Logs = createXinfo("UPDATE", $arrHeader, $arrFields, $arrValue, "tblref_mall", getID("mallid", "tblref_mall", $_POST['id']), "");
				if($Logs != ""){
					$tran_logs = create_logs_per_transaction("modified a " . $label . ".", $label . " Configuration", $Logs, "" ,"UPDATE", "");
				}
				//INSERT UPDATE LOG FIRST - JONAS - 12/7/2018
			}
			$result = mysql_query($sql);
			if($result == true){
				echo $alert;
			}
		break;

		case 'deletemall':
			//INSERT DELETE LOG FIRST - JONAS - 12/7/2018
			$arrHeader = ["Mall ID", "Mall Name", "Mall Address", "About", "Telephone Number", "E-mail", "TIN Number"];
			$arrFields = ["mallid", "mallname", "malladdress", "abouts", "telephone_number", "email", "tinnumber"];
			$Logs = createXinfo("DELETE", $arrHeader, $arrFields, "", "tblref_mall", getID("mallid", "tblref_mall", $_POST['id']), "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("deactivated a " . $label . ".", $label . " Configuration", $Logs, "" ,"DELETED", "");
			}
			//INSERT DELETE LOG FIRST - JONAS - 12/7/2018
			$sql = "UPDATE tblref_mall SET mallstat = '0' WHERE mallid = '".$_POST["id"]."';";
			$result = mysql_query($sql, $connection);
			if($result == true){
				$sql2 = "UPDATE tblref_wing SET wingstat = '0' WHERE mallID = '".$_POST["id"]."';";
				$result2 = mysql_query($sql2, $connection);
				if($result2 == true){
					$sql3 = "UPDATE tblref_floorsetup SET floorstat = '0' WHERE mallid = '".$_POST["id"]."';";
					$result3 = mysql_query($sql3, $connection);
					if($result3 == true){
						$sql4 = "UPDATE tblref_unit SET unitstat = '0' WHERE mallid = '".$_POST["id"]."';";
						$result4 = mysql_query($sql4, $connection);
						if($result4 == true){
							echo 1;
						}
					}
				}
			}
		break;

		case 'reactivate':
			//INSERT DELETE LOG FIRST - JONAS - 12/7/2018
			$arrHeader = ["Mall ID", "Mall Name", "Mall Address", "About", "Telephone Number", "E-mail", "TIN Number"];
			$arrFields = ["mallid", "mallname", "malladdress", "abouts", "telephone_number", "email", "tinnumber"];
			$Logs = createXinfo("DELETE", $arrHeader, $arrFields, "", "tblref_mall", getID("mallid", "tblref_mall", $_POST['id']), "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("reactivated a " . $label . ".", $label . " Configuration", $Logs, "" ,"DELETED", "");
			}
			//INSERT DELETE LOG FIRST - JONAS - 12/7/2018
			$sql = "UPDATE tblref_mall SET mallstat = '1' WHERE mallid = '".$_POST["id"]."'";
			$result = mysql_query($sql, $connection);
			if($result == true){
				$sql2 = "UPDATE tblref_wing SET wingstat = '1' WHERE mallID = '".$_POST["id"]."'";
				$result2 = mysql_query($sql2, $connection);
				if($result2 == true){
					$sql3 = "UPDATE tblref_floorsetup SET floorstat = '1' WHERE mallid = '".$_POST["id"]."'";
					$result3 = mysql_query($sql3, $connection);
					if($result3 == true){
						$sql4 = "UPDATE tblref_unit SET unitstat = '1' WHERE mallid = '".$_POST["id"]."'";
						$result4 = mysql_query($sql4, $connection);
						if($result4 == true){
							echo 1;
						}
					}
				}
			}
		break;

		case 'savenewamenitiesref':
			$amenitiesid = createidno("A", "tblref_amenities", "amenitiesid");
			$sql = "INSERT INTO tblref_amenities (amenitiesid, amenitiesname, qty) VALUES('".$amenitiesid."', '". $_POST["newame"]. "', '".$_POST["radio"]."')";
			$result = mysql_query($sql, $connection);
			if($result == true){
				echo 1;
			}
		break;

		case 'loadaddedameni':
			$sql = "SELECT amenitiesid, amenitiesname, qty FROM tblref_amenities ".$_POST["amenities"]."";
			$result = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($result)){
				echo "<tr style='width: 100%;display: table;table-layout: fixed;'>
						<td style=''>
							<div class='checkbox' style='margin:3px;'>
								<label>
									<input name='form-field-checkbox' type='checkbox' class='ace amenities_chk' value='".$row["amenitiesid"]."' onchange='checkamenities(\"".$row["amenitiesid"]."\")' id='trsschk_".$row["amenitiesid"]."'>
									<span class='lbl' id='amenities_chk_".$row["amenitiesid"]."'> ".$row["amenitiesname"]."</span>
								</label>
							</div>
						</td>
					  </tr>";
				if($row["qty"] == "0"){

				}else if($row["qty"] == "1"){
					echo "<tr style='width: 100%;display: none;table-layout: fixed;' id='trss_".$row["amenitiesid"]."'>
							<td>
								<input type='text' class='form-control numonly' id='txtqty_".$row["amenitiesid"]."' style='width:95%;float:right;text-align:right;' placeholder='qty'>
							</td>
						  </tr>";
				}
			}
		break;

		case 'loadwing':
			$page = $_POST["page"];
			$limit = ($page-1) * 20;
			if($_POST["key"] != ""){
				$key = "AND wing LIKE '%".$_POST["key"]."%'";
			}else{
				$key = "";
			}
			$sql = "SELECT wingID, wing FROM tblref_wing WHERE mallID = '".$_POST["mallid"]."' ".$key." LIMIT ".$limit.", 20";
			$res = mysql_query($sql, $connection);
			$numres = mysql_num_rows($res);
			if($numres == 0){
				echo 	"<tr>
							<td colspan='5' style='text-align: center;'>No Data Found...</td>
						</tr>";
			}else{
				while($row = mysql_fetch_array($res)){
					echo "	<tr>
							 	<td>".$row["wing"]."</td>
							 	<td>
									<button class='btn btn-sm btn-info btn-round' style='z-index: 0px;' onclick='editrefwing(\"".$row["wingID"]."\")'>
										<img src='assets/images/edit.png' style='width: 100%; height: auto;' /></i>
									</button>
									<button class='btn btn-sm btn-danger btn-round' style='z-index: 0px;' onclick='delrefwing(\"".$row["wingID"]."\")'>
										<img src='assets/images/remove.png' style='width: 100%; height: auto;' />
									</button>
							 	</td>
						  	</tr>";
				}
			}
		break;

		case "loadpaginationwing":
			if($_POST["key"] != ""){
				$key = "AND wing LIKE '%".$_POST["key"]."%'";
			}else{
				$key = "";
			}
			$page = $_POST["page"];
			$sqlb = "SELECT COUNT(*) FROM tblref_wing WHERE mallID = '".$_POST["mallid"]."' ".$key."";
			$aa = mysql_query($sqlb, $connection);
			$nums = mysql_fetch_row($aa);
			$num = $nums[0];
			$rowsperpage = 20;
			$range = 3;
			$totalpages = ceil($num / $rowsperpage);
			$prevpage;
			$nextpage;
			if($page > 1 ){
			   	echo "<li style='width:50px !important;' onclick='getvalwing(1)'><< First</li>";
			   	$prevpage = $page - 1;
			   	echo "<li style='width:70px !important;' onclick='getvalwing(". $prevpage .")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   	if (($x > 0) && ($x <= $totalpages)){
			      	if ($x == $page){
		   				echo "<li id='pgptnts" . $x . "' class='pgnumptnts active' onclick='getvalwing(" . $x . ",". $x .")'>" . $x . "</li>"; 
		   			}else{
						echo "<li id='pgptnts" . $x . "' class='pgnumptnts' onclick='getvalwing(" . $x . ",". $x .")'>" . $x . "</li>"; }
		       		}
		    }
		    if($page < ($totalpages - $range)){ 
		    	echo "<li>...</li>"; 
		    }
		    if ($page != $totalpages && $num != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='getvalwing(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='getvalwing(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'loadentrieswing':
			if($_POST["key"] != ""){
				$key = "AND wing LIKE '%".$_POST["key"]."%'";
			}else{
				$key = "";
			}
			$sql = "SELECT COUNT(*) FROM tblref_wing WHERE mallID = '".$_POST["mallid"]."' ".$key."";
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
		break;

		case 'savewing':
			if($_POST["id"] == ""){
				$selectwing = "SELECT COUNT(*) FROM tblref_wing WHERE wing = '". $_POST["wingname"] ."' AND mallID = '". $_POST['mallid'] ."';";
				$resultwing = mysql_query($selectwing, $connection);
				$wingnum = mysql_fetch_array($resultwing);
				if($wingnum[0] == 0){
					$wingid = createidno("WING", "tblref_wing", "wingID");
					$insertwing = "INSERT INTO tblref_wing (wingID, wing, mallID) VALUES ('". $wingid ."', '". $_POST["wingname"] ."', '". $_POST["mallid"] ."');";
					$resultwing = mysql_query($insertwing, $connection);
					if($resultwing == true){
						echo 1;
					}else{
						echo 4;
					}
					//INSERT LOG FIRST - JONAS - 12/7/2018
					$arrHeader = ["Wing ID", "Wing", $label];
					$arrValue = [$wingid, $_POST['wingname'], $_POST['mallid']];
					$Logs = createXinfo("INSERT", $arrHeader, "", $arrValue, "", "", "");
					if($Logs != ""){
						$tran_logs = create_logs_per_transaction("added a wing.", $label . " Configuration", $Logs, "" ,"ADD", "");
					}
					//INSERT LOG FIRST - JONAS - 12/7/2018
				}else{
					echo 3;
				}
			}else{
				$selectwing = "SELECT COUNT(*) FROM tblref_wing WHERE wing = '". $_POST["wingname"] ."';";
				$resultwing = mysql_query($selectwing, $connection);
				$wingnum = mysql_fetch_array($resultwing);
				if($wingnum[0] == 0){
					//INSERT UPDATE LOG FIRST - JONAS - 12/7/2018
					$arrHeader = ["Wing ID", "Wing", $label];
					$arrFields = ["wingID", "wing", "mallID"];
					$arrValue = [$_POST["id"], $_POST['wingname'], $_POST['mallid']];
					$Logs = createXinfo("UPDATE", $arrHeader, $arrFields, $arrValue, "tblref_wing", getID("wingID", "tblref_wing", $_POST['id']), "");
					if($Logs != ""){
						$tran_logs = create_logs_per_transaction("modified a wing.", $label . " Configuration", $Logs, "" ,"UPDATE", "");
					}
					//INSERT UPDATE LOG FIRST - JONAS - 12/7/2018
					$insertwing = "UPDATE tblref_wing SET wing = '". $_POST["wingname"] ."' WHERE wingID = '". $_POST["id"] ."';";
					$resultwing = mysql_query($insertwing, $connection);
					if($resultwing == true){
						echo 2;
					}else{
						echo 4;
					}
				}else{
					echo 3;
				}
				
			}
		break;

		case 'editrefwing':
			$sql = "SELECT wingID, wing FROM tblref_wing WHERE wingID = '". $_POST["id"] ."'";
			$result = mysql_query($sql);
			$row = mysql_fetch_array($result);
			if($result == true){
				echo "|" . $row["wingID"] . "|" . $row["wing"] . "|";
			}
		break;

		case 'delrefwing':
			//INSERT DELETE LOG FIRST - JONAS - 12/7/2018
			$arrHeader = ["Wing ID", "Wing", $label];
			$arrFields = ["wingID", "wing", "mallID"];
			$Logs = createXinfo("DELETE", $arrHeader, $arrFields, "", "tblref_wing", getID("wingID", "tblref_wing", $_POST['id']), "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("deleted a wing.", $label . " Configuration", $Logs, "", "DELETE", "");
			}
			//INSERT DELETE LOG FIRST - JONAS - 12/7/2018
			$sql = "DELETE FROM tblref_wing WHERE wingID = '". $_POST["id"] ."'";
			$result = mysql_query($sql, $connection);
			if($result == true){
				echo "Successfully deleted.";
			}
		break;

		case 'loadfloors':
			$page = $_POST["page"];
			$limit = ($page-1) * 20;
			if($_POST["type"] != ""){
				$key = " AND wingid = '".$_POST["type"]."'";
			}else{
				$key = "";
			}
			$sql = "SELECT mallid, wingid, floor, floorid, width2, length2, minarea, TLA, GLA FROM tblref_floorsetup WHERE (floor LIKE '%".$_POST["key"]."%' OR floorid LIKE '%".$_POST["key"]."%') ".$key." LIMIT ".$limit.",20";
			$res = mysql_query($sql);
			$numres = mysql_num_rows($res);
			if($numres == 0){
				echo 	"<tr>
							<td colspan='5' style='text-align: center;'>No Data Found...</td>
						</tr>";
			}else{
				while($row = mysql_fetch_array($res)){
					$wing = mysql_fetch_array(mysql_query("SELECT wing FROM tblref_wing WHERE wingID = '". $row['wingid'] ."'", $connection));
					echo 	"<tr>
								<td class='scroll'>". $row["floor"] ."</td>
								<td class='hide_mobile'>". $wing["wing"] ."</td>";

					if(SysLeaseSetup('floorandunitmeasurement') == "Area"){
						echo 	"<td>" . floatval($row['TLA']) . " sqm.</td>
								<td class='hide_mobile'>" . floatval($row['GLA']) . " sqm.</td>";
					}else{
						echo 	"<td>" . floatval($row['width2']) . " m. x " . floatval($row['length2']) . " m.</td>
								<td class='hide_mobile'>" . floatval($row['minarea']) . " sqm.</td>";
					}			
						echo	"<td class='center'>
									<button class='btn btn-sm btn-info btn-round' style='z-index: 0;' onclick='editreffloor(\"".$row["floorid"]."\")'>
										<img src='assets/images/edit.png' style='width: 100%; height: auto;' /></i>
									</button>
									<button class='btn btn-sm btn-danger btn-round' style='z-index: 0;' onclick='delreffloor(\"".$row["floorid"]."\")'>
										<img src='assets/images/remove.png' style='width: 100%; height: auto;' />
									</button>
								</td>
							</tr>";
				}
			}
		break;

		case "loadpaginationflr":
			$page = $_POST["page"];
			if($_POST["type"] != ""){
				$key = " AND wingid = '".$_POST["type"]."'";
			}else{
				$key = "";
			}
			$sqlb = "SELECT COUNT(*) FROM tblref_floorsetup WHERE (floor LIKE '%".$_POST["key"]."%' OR floorid LIKE '%".$_POST["key"]."%') ".$key."";
			$aa = mysql_query($sqlb, $connection);
			$nums = mysql_fetch_row($aa);
			$num = $nums[0];
			$rowsperpage = 20;
			$range = 3;
			$totalpages = ceil($num / $rowsperpage);
			$prevpage;
			$nextpage;
			if($page > 1 ){
			   echo "<li style='width:50px !important;' onclick='getvalflr(1)'><< First</li>";
			   $prevpage = $page - 1;
			   echo "<li style='width:70px !important;' onclick='getvalflr(". $prevpage .")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			    if(($x > 0) && ($x <= $totalpages)){
			      	if($x == $page){
		   				echo "<li id='pgptnts" . $x . "' class='pgnumptnts active' onclick='getvalflr(" . $x . ",". $x .")'>" . $x . "</li>"; 
		   			}else{
						echo "<li id='pgptnts" . $x . "' class='pgnumptnts' onclick='getvalflr(" . $x . ",". $x .")'>" . $x . "</li>"; }
		        }
		    }
		    if($page < ($totalpages - $range)){
		    	echo "<li>...</li>";
		    }
		    if ($page != $totalpages && $num != 0){
		       $nextpage = $page + 1;
		       echo "<li style='width:50px !important;' onclick='getvalflr(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       echo "<li style='width:50px !important;' onclick='getvalflr(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'loadentriesflr':
			if($_POST["type"] != ""){
				$key = " AND wingid = '".$_POST["type"]."'";
			}else{
				$key = "";
			}
			if($_POST["page"] == ""){
               	$page = 1;
           	}else{
               	$page = $_POST["page"];
           	}
           	$limit = ($page-1) * 20;
			$sql = "SELECT COUNT(*) FROM tblref_floorsetup WHERE (floor LIKE '%".$_POST["key"]."%' OR floorid LIKE '%".$_POST["key"]."%') ".$key."";
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
		break;

		case 'editreffloor':
			$row = mysql_fetch_array(mysql_query("SELECT wingid, floor, floorid, width2, length2, minarea, TLA, GLA FROM tblref_floorsetup WHERE floorid = '" . $_POST["id"] . "'", $connection));

			echo $row["wingid"] . "|" . $row["floor"] . "|" . $row["floorid"] . "|" . number_format($row['width2'], 0, '.', ',') . "|" . number_format($row['length2'], 0, '.', ',') . "|" . number_format($row['minarea'], 0, '.', ',') . "|" . number_format($row['TLA'], 0, '.', ',') . "|" . number_format($row['GLA'], 0, '.', ',');
		break;

		case 'delreffloor':
			//INSERT DELETE LOG FIRST - JONAS - 12/7/2018
			$arrHeader = ["Floor ID", "Mall ID", "Wing ID", "Floor", "Width", "Length", "Minimum Area", "Total Leasable Area", "Gross Leasable Area"];
			$arrFields = ["floorid", "mallid", "wingid", "floor", "width2", "length2", "minarea", "TLA", "GLA"];
			$Logs = createXinfo("DELETE", $arrHeader, $arrFields, "", "tblref_floorsetup", getID("floorid", "tblref_floorsetup", $_POST['id']), "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("deleted a floor.", $label . " Configuration", $Logs, "", "DELETE", "");
			}
			//INSERT DELETE LOG FIRST - JONAS - 12/7/2018
			$sql = "DELETE FROM tblref_floorsetup WHERE floorid = '". $_POST["id"] ."'";
			$result = mysql_query($sql, $connection);
			if($result == true){
				echo "Successfully deleted.";
			}
		break;

		case 'savefloor':
			$datenow = getsysdate();
			if($_POST["floorid"] == ""){
				$selectfloor = "SELECT COUNT(*) FROM tblref_floorsetup WHERE floor = '". $_POST["floor"] ."' AND mallid = '". $_POST["mallid"] ."' AND wingid = '". $_POST["wingid"] ."'";
				$resultfloor = mysql_query($selectfloor, $connection);
				$floornum = mysql_fetch_array($resultfloor);
				if($floornum[0] == 0){
					$floorid = createidno("FLOOR", "tblref_floorsetup", "floorid");
					$insertflr = "INSERT INTO tblref_floorsetup SET floorid = '". $floorid ."', mallid = '". $_POST['mallid'] ."', wingid = '". $_POST['wingid'] ."', floor = '". $_POST['floor'] ."', width2 = '". $_POST['width'] ."', length2 = '". $_POST['length'] ."', minarea = '". $_POST['minarea'] ."', TLA = '". $_POST['TLA'] ."', GLA = '". $_POST['GLA'] ."'";
					$resultflr = mysql_query($insertflr, $connection);
					if($resultflr == true){
						echo "Successfully Added.";
					}else{
						echo "An error occured!";
					}
					//INSERT LOG FIRST - JONAS - 12/7/2018
					$arrHeader = ["Floor ID", "Mall ID", "Wing ID", "Floor", "Width", "Length", "Minimum Area", "Total Leasable Area", "Gross Leasable Area"];
					$arrValue = [$floorid, $_POST['mallid'], $_POST['wingid'], $_POST['floor'], $_POST['width'], $_POST['length'], $_POST['minarea'], $_POST['TLA'], $_POST['GLA']];
					$Logs = createXinfo("INSERT", $arrHeader, "", $arrValue, "", "", "");
					if($Logs != ""){
						$tran_logs = create_logs_per_transaction("added a new floor.", $label . " Configuration", $Logs, "" ,"ADD", "");
					}
					//INSERT LOG FIRST - JONAS - 12/7/2018
				}else{
					echo "Already Existing!";
				}
			}else{
				$select_floor = "SELECT floor FROM tblref_floorsetup WHERE floorid = '". $_POST["floorid"] ."' AND mallid = '". $_POST["mallid"] ."' AND wingid = '". $_POST["wingid"] ."'";
				$floorsel = mysql_query($select_floor, $connection);
				$sel = mysql_fetch_array($floorsel);
				if($sel["floor"] == $_POST["floor"]){
					$floorid = $_POST["floorid"];
					//INSERT UPDATE LOG FIRST - JONAS - 12/7/2018
					$arrHeader = ["Floor ID", "Mall ID", "Wing ID", "Floor", "Width", "Length", "Minimum Area", "Total Leasable Area", "Gross Leasable Area"];
					$arrFields = ["floorid", "mallid", "wingid", "floor", "width2", "length2", "minarea", "TLA", "GLA"];
					$arrValue = [$floorid, $_POST['mallid'], $_POST['wingid'], $_POST['floor'], $_POST['width'], $_POST['length'], $_POST['minarea'], $_POST['TLA'], $_POST['GLA']];
					$Logs = createXinfo("UPDATE", $arrHeader, $arrFields, $arrValue, "tblref_floorsetup", getID("floorid", "tblref_floorsetup", $floorid), "");
					if($Logs != ""){
						$tran_logs = create_logs_per_transaction("modified a floor.", $label . " Configuration", $Logs, "" ,"UPDATE", "");
					}
					//INSERT UPDATE LOG FIRST - JONAS - 12/7/2018
					$insertflr = "UPDATE tblref_floorsetup SET mallid = '". $_POST["mallid"] ."', wingid = '". $_POST["wingid"] ."', floor = '". $_POST["floor"] ."', width2 = '". $_POST['width'] ."', length2 = '". $_POST['length'] ."', minarea = '". $_POST['minarea'] ."', TLA = '". $_POST['TLA'] ."', GLA = '". $_POST['GLA'] ."' WHERE floorid = '" . $floorid . "'";
					$resultflr = mysql_query($insertflr, $connection);
					if($resultflr == true){
						$result = mysql_query($sql);
						echo "Successfully modified.";
					}
				}else{
					$selectfloor = "SELECT COUNT(*) FROM tblref_floorsetup WHERE floor = '". $_POST["floor"] ."' AND mallid = '". $_POST["mallid"] ."' AND wingid = '". $_POST["wingid"] ."'";
					$resultfloor = mysql_query($selectfloor, $connection);
					$floornum = mysql_fetch_array($resultfloor);
					if($floornum[0] == 0){
						$floorid = $_POST["floorid"];
						//INSERT UPDATE LOG FIRST - JONAS - 12/7/2018
						$arrHeader = ["Floor ID", "Mall ID", "Wing ID", "Floor", "Width", "Length", "Minimum Area", "Total Leasable Area", "Gross Leasable Area"];
						$arrFields = ["floorid", "mallid", "wingid", "floor", "width2", "length2", "minarea", "TLA", "GLA"];
						$arrValue = [$floorid, $_POST['mallid'], $_POST['wingid'], $_POST['floor'], $_POST['width'], $_POST['length'], $_POST['minarea'], $_POST['TLA'], $_POST['GLA']];
						$Logs = createXinfo("UPDATE", $arrHeader, $arrFields, $arrValue, "tblref_floorsetup", getID("floorid", "tblref_floorsetup", $floorid), "");
						if($Logs != ""){
							$tran_logs = create_logs_per_transaction("modified a floor.", $label . " Configuration", $Logs, "" ,"UPDATE", "");
						}
						//INSERT UPDATE LOG FIRST - JONAS - 12/7/2018
						$insertflr = "UPDATE tblref_floorsetup SET mallid = '". $_POST["mallid"] ."', wingid = '". $_POST["wingid"] ."', floor = '". $_POST["floor"] ."', width2 = '". $_POST['width'] ."', length2 = '". $_POST['length'] ."', minarea = '". $_POST['minarea'] ."', TLA = '". $_POST['TLA'] ."', GLA = '". $_POST['GLA'] ."' WHERE floorid = '" . $floorid . "'";
						$resultflr = mysql_query($insertflr, $connection);
						if($resultflr == true){
							$result = mysql_query($sql);
							echo "Successfully modified.";
						}
					}else{
						echo "Already Existing!";
					}
				}
			}
		break;

		case 'loadwingdetails':
			echo '<option value="">-- Select Wing --</option>';
			$sql = "SELECT wingID, wing FROM tblref_wing WHERE mallID = '".$_POST["id"]."'";
			$result = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($result)){
				echo "<option value='".$row["wingID"]."'>".$row["wing"]."</option>";
			}
		break;

		case 'loadrefflrdetails':
			$sql = "SELECT floor FROM tblref_flr";
			$result = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($result)){
				echo "<tr style='width: 100%;display: table;table-layout: fixed;'><td>".$row["floor"]."</td></tr>";
			}
		break;

		case 'loadwingdetails2':
			echo '<option value="">-- Select Wing --</option>';
			$sql = "SELECT wingID, wing FROM tblref_wing WHERE mallID = '".$_POST["id"]."'";
			$result = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($result)){
				echo "<option value='".$row["wingID"]."'>".$row["wing"]."</option>";
			}
		break;

		case 'loaddropflr':
			echo '<option value="">-- Select Floor --</option>';
			$sql = "SELECT floor FROM tblref_flr";
			$result = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($result)){
				echo "<option value='".$row["floor"]."'>".$row["floor"]."</option>";
			}
		break;

		case 'savereffloor':
			$sql = "SELECT COUNT(*) FROM tblref_flr WHERE floor = '".$_POST["flr"]."'";
			$result = mysql_query($sql, $connection);
			$row = mysql_fetch_array($result);
			if($row[0] == 0){
				//INSERT LOG FIRST - JONAS - 12/7/2018
				$arrHeader = ["Floor"];
				$arrValue = [$_POST['flr']];
				$Logs = createXinfo("INSERT", $arrHeader, "", $arrValue, "", "", "");
				if($Logs != ""){
					$tran_logs = create_logs_per_transaction("added a new floor.", $label . " Configuration", $Logs, "" ,"ADD", "");
				}
				//INSERT LOG FIRST - JONAS - 12/7/2018
				$sql2 = "INSERT INTO tblref_flr(floor)VALUES('".$_POST["flr"]."')";
				$result2 = mysql_query($sql2, $connection);
				if($result2 == true){
					echo 1;
				}
			}else{
				echo 2;
			}
		break;

		case 'loadtblamenitiesreflist':
			$sql = "SELECT amenitiesid, amenitiesname, qty FROM tblref_amenities";
			$result = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($result)){
				echo "<tr style='width: 100%;display: table;table-layout: fixed;'>
						<td style=''>
							<div class='checkbox' style='margin:3px;'>
								<label>
									<input name='form-field-checkbox' type='checkbox' class='ace amenities_chk' value='".$row["amenitiesid"]."' onchange='checkamenities(\"".$row["amenitiesid"]."\")' id='trsschk_".$row["amenitiesid"]."'>
									<span class='lbl' id='amenities_chk_".$row["amenitiesid"]."'> ".$row["amenitiesname"]."</span>
								</label>
							</div>
						</td>
					  </tr>";
				if($row["qty"] == "0"){

				}else if($row["qty"] == "1"){
					echo "<tr style='width: 100%;display: none;table-layout: fixed;' id='trss_".$row["amenitiesid"]."'>
							<td>
								<input type='text' class='form-control numonly' id='txtqty_".$row["amenitiesid"]."' style='width:95%;float:right;text-align:right;' placeholder='qty'>
							</td>
						  </tr>";
				}
			}
		break;

		case 'loadunit':
			$page = $_POST["page"];
			$limit = ($page-1) * 20;
			$sql = "SELECT unitid, unitname, buildingname, typeofbusiness, classificationname, sqmunitsetup, pricepersqmunitsetup, totalamountunitsetup, status, dateadded, mallid, floorid, wingid, depid, classid FROM tblref_unit WHERE (MainUnit IS NULL OR MainUnit = '') AND mallid = '". $_POST['mallid'] ."' AND unitname LIKE '%". $_POST["key"] ."%' LIMIT ". $limit .", 20;";
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result)){
				$row_floor = mysql_fetch_array(mysql_query("SELECT floor FROM tblref_floorsetup WHERE floorid = '". $row["floorid"] ."';", $connection));
				$row_wing = mysql_fetch_array(mysql_query("SELECT wing FROM tblref_wing WHERE wingID = '". $row["wingid"] ."';", $connection));
				$row_dept = mysql_fetch_array(mysql_query("SELECT department FROM tblref_merchandise_depa WHERE departmentID = '". $row['depid'] ."';", $connection));
				$getSubs = mysql_num_rows(mysql_query("SELECT MainUnit FROM tblref_unit WHERE MainUnit = '". $row['unitid'] ."';", $connection));
				$UnitClassification = mysql_fetch_array(mysql_query("SELECT UnitClassDesc FROM tblref_unitclass WHERE UnitClassID = '". $row['classid'] ."';", $connection));

				if($getSubs > 0){
					$ExpandButton = "<i id='iExpand". $row['unitid'] ."' class='ace-icon fa fa-angle-double-down fa-2x pull-right green' onclick='fncExpandSubs(\"". $row['unitid'] ."\")'></i>";
				}else{
					$ExpandButton = "";
				}

				if($row["status"] == "Vacant"){
					$UnitStatus = "<span class='label label-lg label-default arrowed-in-right arrowed' style='z-index: 0;'>Vacant</span>";
				}else if($row["status"] == "ForAwarding"){
					$UnitStatus = "<span class='label label-lg label-pink arrowed-in-right arrowed' style='z-index: 0;'>ForAwarding</span>";
				}else if($row["status"] == "Awarded"){
					$UnitStatus = "<span class='label label-lg label-purple arrowed-in-right arrowed' style='z-index: 0;'>Awarded</span>";
				}else if($row["status"] == "Confirmed"){
					$UnitStatus = "<span class='label label-lg label-primary arrowed-in-right arrowed' style='z-index: 0;'>Reserved</span>";
				}else if($row["status"] == "Occupied"){
					$UnitStatus = "<span class='label label-lg label-warning arrowed-in-right arrowed' style='z-index: 0;'>Occupied</span>";
				}else{
					$UnitStatus = "<span class='label label-lg label-default arrowed-in-right arrowed' style='z-index: 0;'>Vacant</span>";
				}

				echo 	"<tr>
						 	<td class='scroll'>". $row['unitname'] ."</td>
						 	<td class='hide_mobile'>". $row_wing['wing'] ."</td>
						 	<td class='hide_mobile'>". $row_floor['floor'] ."</td>
						 	<td class='hide_mobile'>". $row['typeofbusiness'] ."</td>
						 	<td class='hide_mobile'>". $UnitClassification['UnitClassDesc'] ."</td>
						 	<td style='z-index: 0;'>". $UnitStatus ."</td>
							<td class='center'>
								<button class='btn btn-sm btn-info btn-round' style='z-index: 0;' onclick='editrefunit(\"". $row['unitid'] ."\")'><img src='assets/images/edit.png' style='width: 100%; height: auto;' /></i></button>
								<button class='btn btn-sm btn-danger btn-round' style='z-index: 0;' onclick='delrefunit(\"". $row['unitid'] ."\")'><img src='assets/images/remove.png' style='width: 100%; height: auto;' /></button>
						 	</td>
					  	</tr>";
					// $res2 = mysql_query("SELECT unitname, floorid, wingid, unitid FROM tblref_unit WHERE MainUnit = '". $row['unitid'] ."';", $connection);
					// while($row2 = mysql_fetch_array($res2)){
					// 	echo 	"<tr style='display: none;' class='trList". $row['unitid'] ."'>
					// 				<td>". $row2['unitname'] ."</td>
					// 				<td>". $row_wing['wing'] ."</td>
					// 				<td>". $row_floor['floor'] ."</td>
					// 				<td>". $row['typeofbusiness'] ."</td>";
					// 				if(SysLeaseSetup('isClassification') == "1"){
					// 			 		echo "<td class='hide_mobile'>". $row['classificationname'] ."</td>";
					// 			 	}else{
					// 					if(SysLeaseSetup('isDepartment') == "1"){
					// 			 			echo "<td class='hide_mobile'>". $row_dept['department'] ."</td>";
					// 					}
					// 			 	}
					// 	echo		"<td>
					// 					<button class='btn btn-xs btn-info' style='z-index: 0;' onclick='fncEditSubUnit(\"". $row2['unitid'] ."\", \"". $row['unitid'] ."\")'><img src='assets/images/edit.png' style='width: 100%; height: auto;' /></i></button>
					// 					<button class='btn btn-xs btn-danger' style='z-index: 0;' onclick='fncDeleteSubUnit(\"". $row2['unitid'] ."\", \"". $row['unitid'] ."\")'><img src='assets/images/remove.png' style='width: 100%; height: auto;' /></button>
					// 				</td>
					// 			</tr>";
					// }
			}
		break;

		case "loadpaginationunit":
			$page = $_POST["page"];
			$rowCount = mysql_fetch_row(mysql_query("SELECT COUNT(*) FROM tblref_unit WHERE (MainUnit IS NULL OR MainUnit = '') AND mallid = '". $_POST["mallid"] ."' AND unitname LIKE '%".$_POST["key"]."%';", $connection));
			$NumRow = $rowCount[0];
			$rowsperpage = 20;
			$range = 3;
			$totalpages = ceil($NumRow / $rowsperpage);
			$prevpage;
			$nextpage;
			if($page > 1 ){
			   	echo "<li style='width:50px !important;' onclick='getvalunit(1)'><< First</li>";
			   	$prevpage = $page - 1;
			   	echo "<li style='width:70px !important;' onclick='getvalunit(". $prevpage .")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   	if (($x > 0) && ($x <= $totalpages)){
			      	if ($x == $page){
		   				echo "<li id='pgptnts" . $x . "' class='pgnumptnts active' onclick='getvalunit(" . $x . ",". $x .")'>" . $x . "</li>"; 
		   			}else{
						echo "<li id='pgptnts" . $x . "' class='pgnumptnts' onclick='getvalunit(" . $x . ",". $x .")'>" . $x . "</li>"; }
		       		}
		    }
		    if($page < ($totalpages - $range)){ 
		    	echo "<li>...</li>"; 
		    }
		    if ($page != $totalpages && $NumRow != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='getvalunit(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='getvalunit(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'loadentriesunit':
			$rowCount = mysql_fetch_row(mysql_query("SELECT COUNT(*) FROM tblref_unit WHERE (MainUnit IS NULL OR MainUnit = '') AND mallid = '". $_POST["mallid"] ."' AND unitname LIKE '%".$_POST["key"]."%';", $connection));
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

		case 'fncLoadUnitWing':
			echo "<option value=''>-- Select Wing --</option>";
			$res = mysql_query("SELECT wingID, wing FROM tblref_wing WHERE mallID = '". $_SESSION['MMS-Designation'] ."';", $connection);
			while($row = mysql_fetch_array($res)){
				echo "<option value='". $row['wingID'] ."'>". $row['wing'] ."</option>";
			}
		break;

		case 'fncLoadUnitFloor':
			echo "<option value=''>-- Select Floor --</option>";
			$res = mysql_query("SELECT floorid, floor FROM tblref_floorsetup WHERE wingid = '". $_POST['WingID'] ."';", $connection);
			while($row = mysql_fetch_array($res)){
				echo "<option value='". $row['floorid'] ."'>". $row['floor'] ."</option>";
			}
		break;

		case 'fncloadUnitClassfication':
			echo "<option value=''>-- Select Classification --</option>";
			$res = mysql_query("SELECT UnitClassID, UnitClassDesc FROM tblref_unitclass;", $connection);
			while($row = mysql_fetch_array($res)){
				echo "<option value='". $row['UnitClassID'] ."'>". $row['UnitClassDesc'] ."</option>";
			}
		break;

		case 'checkbustypevalue':
			$unitcount = mysql_fetch_array(mysql_query("SELECT COUNT(unitid) FROM tblref_unit WHERE typeofbusiness = '". $_POST['bus'] ."' AND mallid = '". $_POST['mallid'] ."';", $connection));
			if($_POST['bus'] == "SET"){
				$limittype = mysql_fetch_array(mysql_query("SELECT MaxSET FROM tblref_mall WHERE mallid = '". $_POST['mallid'] ."';", $connection));
			}else if($_POST['bus'] == "LCA"){
				$limittype = mysql_fetch_array(mysql_query("SELECT MaxLCA FROM tblref_mall WHERE mallid = '". $_POST['mallid'] ."';", $connection));
			}else{
				$limittype = 0;
			}

			if($_POST['bus'] == "LCA"){
                $unittype = "SET";
            }else if($_POST['bus'] == "SET"){
                $unittype = "LCA";
            }else{
                $unittype = "";
            }

			if($unitcount[0] >= $limittype[0]){
				echo 1;
			}
		break;

		case 'saveunit':
			$datenow = getsysdate();
			$row_wing = mysql_fetch_array(mysql_query("SELECT wing FROM tblref_wing WHERE wingID = '". $_POST["wingid"] ."';", $connection));
			$ttlsqm = floatval($_POST["sqm_width"]) * floatval($_POST["sqm_height"]);
        	if(SysLeaseSetup('floorandunitmeasurement') == "Area"){
				$total = floatval($_POST['txtArea']) * floatval($_POST["pricepersqm"]);
        	}else{
				$total = $ttlsqm * floatval($_POST["pricepersqm"]);
        	}
			$floor = mysql_fetch_array(mysql_query("SELECT floor FROM tblref_floorsetup WHERE floorid = '". $_POST['flrid'] ."';", $connection));
			if($_POST["id"] == ""){
				$unitnum = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM tblref_unit WHERE unitname = '". $_POST["unitname"] ."' AND mallid = '". $_POST["mallid"] ."' AND wingid = '". $_POST["wingid"] ."' AND floorid = '". $_POST["flrid"] ."';", $connection));
				if($unitnum[0] == 0){
					$amenities = explode("#", $_POST["amenities"]);
					for($i=1; $i<=count($amenities)-1; $i++){
						$arr = explode("|", $amenities[$i]);
						$resinsert = mysql_query("INSERT INTO tblref_unit_amenities (unitID, unit, amenitiesID, amenities)VALUES('". $unitid ."', '". $_POST["unitname"] ."', '". $arr[0] ."', '". $arr[1] ."');", $connection);
					}
					$unitid = createidno("U", "tblref_unit", "unitid");
					$resInsertUnit = mysql_query("INSERT INTO tblref_unit SET unitid = '". $unitid ."', unitname = '". $_POST["unitname"] ."', buildingname = '". $row_wing["wing"] ."', typeofbusiness = '". $_POST["bustype"] ."', sqmunitsetup = '". $ttlsqm ."', pricepersqmunitsetup = '". $_POST["pricepersqm"] ."', totalamountunitsetup = '". $total ."', status = 'Vacant', dateadded = '". $datenow ."', mallid = '". $_POST["mallid"] ."', floorid = '". $_POST["flrid"] ."', wingid = '". $_POST["wingid"] ."', sqm_width = '". $_POST["sqm_width"] ."', sqm_height = '". $_POST["sqm_height"] ."', assocdues = '". $_POST['assocdues'] ."', startDate = '". $datenow ."', area = '". floatval($_POST['txtArea']) ."', amenities = '". $_POST['amenities'] ."', BillingSetup = '". $_POST['BillingType'] ."', OtherUnitInfo = '". $_POST['ckEditorData'] ."', classid = '". $_POST['UnitClass'] ."';", $connection);
					if($resInsertUnit == true){
						//INSERT LOG FIRST - JONAS - 12/7/2018
						$arrHeader = ["Unit ID", "Unit Name", "Unit Type", "Wing", "Floor", "Facilities", "Area Width", "Area Length", "Area", "Unit Cost", "Association Dues"];
						$arrValue = [$unitid, $_POST['unitname'], $_POST['bustype'], $_POST['wingid'], $_POST['flrid'], getThisRealValue('amenitiesid', 'amenitiesname', 'tblref_amenities', str_replace('#','|',$_POST['amenities'])), $_POST["sqm_width"], $_POST["sqm_height"], floatval($_POST['txtArea']), number_format($total, 2, '.', ','), number_format($_POST['assocdues'], 2, '.', ',')];
						$Logs = createXinfo("INSERT", $arrHeader, "", $arrValue, "", "", "");
						if($Logs != ""){
							$tran_logs = create_logs_per_transaction("added a unit.", $label . " Configuration", $Logs, "" ,"ADD", "");
						}
						//INSERT LOG FIRST - JONAS - 12/7/2018
						// $result_logs = mysql_query("INSERT INTO tblunit_statuslogs (unitid, unitname, xdate, xtime, status)VALUES('". $unitid ."', '". $_POST["unitname"] ."', '". $datenow ."', '". date("H:i:s") ."', 'Vacant');", $connection);
						$amenities = explode("#", $_POST["amenities"]);
						for($i=1; $i<=count($amenities)-1; $i++){
							$arr = explode("|", $amenities[$i]);
							$resinsert = mysql_query("INSERT INTO tblref_unit_amenities (unitID, unit, amenitiesID, amenities)VALUES('". $unitid ."', '". $_POST["unitname"] ."', '". $arr[0] ."', '". $arr[1] ."');", $connection);
						}
						echo "1|Successfully Added.|".$unitid;
					}else{
						echo "4|An error occured!|";
					}
				}else{
					echo "3|Already Existing!|";
				}
			}else{
				$resultunit2 = mysql_query("SELECT unitname FROM tblref_unit WHERE unitid = '". $_POST["id"] ."' AND mallid = '". $_POST["mallid"] ."' AND wingid = '". $_POST["wingid"] ."' AND floorid = '". $_POST["flrid"] ."';", $connection);
				$unit2 = mysql_fetch_array($resultunit2);
				if($unit2["unitname"] == $_POST["unitname"]){
					//INSERT UPDATE LOG FIRST - JONAS - 12/7/2018
					$AmeList = "";
					$amenities2 = explode("#", $_POST["amenities"]);
					for($i=1; $i<=count($amenities2)-1; $i++){
						$arr = explode("|", $amenities2[$i]);
						$AmeList .= $arr[0] . "|";
					}
					$arrHeader = ["Unit ID", "Unit Name", "Unit Type", "Wing", "Floor", "Facilities", "Area Width", "Area Length", "Area", "Unit Cost", "Association Dues"];
					$arrFields = ["unitid", "unitname", "typeofbusiness", "wingid", "floorid", "amenities", "sqm_width", "sqm_height", "area", "totalamountunitsetup", "assocdues"];
					$arrValue = [$unitid, $_POST['unitname'], $_POST['bustype'], $_POST['wingid'], $_POST['flrid'], getThisRealValue('amenitiesid', 'amenitiesname', 'tblref_amenities', $AmeList), $_POST["sqm_width"], $_POST["sqm_height"], floatval($_POST['txtArea']), $total, $_POST['assocdues']];
					$Logs = createXinfo("UPDATE", $arrHeader, $arrFields, $arrValue, "tblref_unit", getID("unitid", "tblref_unit", $_POST['id']), "");
					if($Logs != ""){
						$tran_logs = create_logs_per_transaction("modified a unit.", $label . " Configuration", $Logs, "" ,"UPDATE", "");
					}
					//INSERT UPDATE LOG FIRST - JONAS - 12/7/2018
					$resUpdateUnit = mysql_query("UPDATE tblref_unit SET unitname = '".$_POST["unitname"]."', buildingname = '".$row_wing["wing"]."', typeofbusiness = '". $_POST["bustype"] ."', sqmunitsetup = '".$ttlsqm."', pricepersqmunitsetup = '".$_POST["pricepersqm"]."', totalamountunitsetup = '".$total."', mallid = '".$_POST["mallid"]."', floorid = '".$_POST["flrid"]."', wingid = '".$_POST["wingid"]."', sqm_width='".$_POST["sqm_width"]."', sqm_height='".$_POST["sqm_height"]."', assocdues = '". $_POST['assocdues'] ."', area = '". floatval($_POST['txtArea']) ."', amenities = '". $AmeList ."', BillingSetup = '". $_POST['BillingType'] ."', OtherUnitInfo = '". $_POST['ckEditorData'] ."', classid = '". $_POST['UnitClass'] ."' WHERE unitid = '". $_POST["id"] ."';", $connection);
					if($resUpdateUnit == true){
						echo "2|Successfully modified.|".$_POST["id"];
						$resdel = mysql_query("DELETE FROM tblref_unit_amenities WHERE unitID = '". $_POST["id"] ."';", $connection);
						$amenities = explode("#", $_POST["amenities"]);
						for($i=1; $i<=count($amenities)-1; $i++){
							$arr = explode("|", $amenities[$i]);
							$resinsert = mysql_query("INSERT INTO tblref_unit_amenities (unitID, unit, amenitiesID, amenities)VALUES('". $_POST["id"] ."', '". $_POST["unitname"] ."', '". $arr[0] ."', '". $arr[1] ."');", $connection);
						}
					}
					$UpdateSubBillSetup = mysql_query("UPDATE tblref_unit SET BillingSetup = '". $_POST['BillingType'] ."', OtherUnitInfo = '". $_POST['ckEditorData'] ."' WHERE MainUnit = '". $_POST['id'] ."';", $connection);
				}else{
					$InsertUnit = "SELECT COUNT(*) FROM tblref_unit WHERE unitname = '". $_POST["unitname"] ."' AND mallid = '".$_POST["mallid"]."' AND wingid = '". $_POST["wingid"] ."' AND floorid = '". $_POST["flrid"] ."';";
					$resInsertUnit = mysql_query($InsertUnit, $connection);
					$unitnum = mysql_fetch_array($resInsertUnit);
					if($unitnum[0] == 0){
						//INSERT UPDATE LOG FIRST - JONAS - 12/7/2018
						$AmeList = "";
						$amenities2 = explode("#", $_POST["amenities"]);
						for($i=1; $i<=count($amenities2)-1; $i++){
							$arr = explode("|", $amenities2[$i]);
							$AmeList .= $arr[0] . "|";
						}
						$arrHeader = ["Unit ID", "Unit Name", "Unit Type", "Wing", "Floor", "Facilities", "Area Width", "Area Length", "Area", "Unit Cost", "Association Dues"];
						$arrFields = ["unitid", "unitname", "typeofbusiness", "wingid", "floorid", "amenities", "sqm_width", "sqm_height", "area", "totalamountunitsetup", "assocdues"];
						$arrValue = [$unitid, $_POST['unitname'], $_POST['bustype'], $_POST['wingid'], $_POST['flrid'], $_POST['classid'], $_POST['depid'], $_POST['catid'], getThisRealValue('amenitiesid', 'amenitiesname', 'tblref_amenities', $AmeList), $_POST["sqm_width"], $_POST["sqm_height"], floatval($_POST['txtArea']), $total, $_POST['assocdues']];
						$Logs = createXinfo("UPDATE", $arrHeader, $arrFields, $arrValue, "tblref_unit", getID("unitid", "tblref_unit", $_POST['id']), "");
						if($Logs != ""){
							$tran_logs = create_logs_per_transaction("modified a unit.", $label . " Configuration", $Logs, "" ,"UPDATE", "");
						}
						//INSERT UPDATE LOG FIRST - JONAS - 12/7/2018
						$resUpdateUnit = mysql_query("UPDATE tblref_unit SET unitname = '".$_POST["unitname"]."', buildingname = '".$row_wing["wing"]."', typeofbusiness = '". $_POST["bustype"] ."', sqmunitsetup = '".$ttlsqm."', pricepersqmunitsetup = '".$_POST["pricepersqm"]."', totalamountunitsetup = '".$total."', mallid = '".$_POST["mallid"]."', floorid = '".$_POST["flrid"]."', wingid = '".$_POST["wingid"]."', sqm_width='".$_POST["sqm_width"]."', sqm_height='".$_POST["sqm_height"]."', assocdues = '". $_POST['assocdues'] ."', area = '". floatval($_POST['txtArea']) ."', amenities = '". $AmeList ."', BillingSetup = '". $_POST['BillingType'] ."', OtherUnitInfo = '". $_POST['ckEditorData'] ."', classid = '". $_POST['UnitClass'] ."' WHERE unitid = '". $_POST["id"] ."';", $connection);
						if($resUpdateUnit == true){
							echo "2|Successfully modified.|".$_POST["id"];
							$resdel = mysql_query("DELETE FROM tblref_unit_amenities WHERE unitID = '".$_POST["id"]."';", $connection);
							$amenities = explode("#", $_POST["amenities"]);
							for($i=1; $i<=count($amenities)-1; $i++){
								$arr = explode("|", $amenities[$i]);
								$resinsert = mysql_query("INSERT INTO tblref_unit_amenities (unitID, unit, amenitiesID, amenities)VALUES('". $_POST["id"] ."', '". $_POST["unitname"] ."', '". $arr[0] ."', '". $arr[1] ."');", $connection);
							}
						}
						$UpdateSubBillSetup = mysql_query("UPDATE tblref_unit SET BillingSetup = '". $_POST['BillingType'] ."', OtherUnitInfo = '". $_POST['ckEditorData'] ."' WHERE MainUnit = '". $_POST['id'] ."';", $connection);
					}else{
						echo "3|Already Existing!|".$_POST["id"];
					}
				}
			}
		break;

		case 'editrefunit':
			$UnitInfo = mysql_fetch_array(mysql_query("SELECT typeofbusiness, wingid, floorid, unitname, classid, depid, catid, sqm_width, sqm_height, area, photoext, mallid, pricepersqmunitsetup, assocdues, BillingSetup, OtherUnitInfo FROM tblref_unit WHERE unitid = '". $_POST['id'] ."'", $connection));
			if($UnitInfo['photoext'] == ""){
				$image = "assets/images/noimage5.png";
			}else{
				if(!file_exists("../../../Mall_Attachments/Unit Image/".$_POST['id'].".".$UnitInfo['photoext'])){ 
					$image = "assets/images/noimage5.png";
				}else{
					$image = "../Mall_Attachments/Unit Image/".$_POST['id'].".".$UnitInfo['photoext'];
				}
			}

			$UnitImages = "";
			$resUnitImages = mysql_query("SELECT ImageName FROM tblref_unitimage WHERE UnitID = '". $_POST['id'] ."';", $connection);
			while($rowUnitImages = mysql_fetch_array($resUnitImages)){
				if(file_exists("../../../Mall_Attachments/Unit Image/".$_POST['id']."/".$rowUnitImages['ImageName'])){ 
					$UnitImages .= "<li>
		                                <a href='../Mall_Attachments/Unit Image/".$_POST['id']."/".$rowUnitImages['ImageName'] ."' title='Photo Title' data-rel='colorbox' class='cboxElement'>
		                                    <img width='120' height='120' alt='120x120' src='../Mall_Attachments/Unit Image/".$_POST['id']."/".$rowUnitImages['ImageName'] ."'>
		                                </a>
		                            </li>";
				}
			}

			echo $UnitInfo['typeofbusiness'] . "|" . $UnitInfo['wingid'] . "|" . $UnitInfo['floorid'] . "|" . $UnitInfo['unitname'] . "|" . $UnitInfo['classid'] . "|" . $UnitInfo['depid'] . "|" . $UnitInfo['catid'] . "|" . floatval($UnitInfo['sqm_width']) . "|" . floatval($UnitInfo['sqm_height']) . "|" . floatval($UnitInfo['area']) . "|" . $UnitInfo['mallid'] . "|" . number_format($UnitInfo['pricepersqmunitsetup'], 2, '.', ',') . "|" . number_format($UnitInfo['assocdues'], 2, '.', ',') . "|" . $UnitInfo['photoext'] . "|" . $image . "|" . trim($UnitInfo['BillingSetup']) . "|" . $UnitImages . "|" . $UnitInfo['OtherUnitInfo'];
		break;

		case 'getallamenities':
        	$res = mysql_query("SELECT b.amenitiesname, a.amenitiesID, a.amenities FROM tblref_unit_amenities AS a LEFT JOIN tblref_amenities AS b ON a.amenitiesID = b.amenitiesid WHERE unitid = '". $_POST["id"] ."';", $connection);
        	while($row = mysql_fetch_array($res)){
	        	echo '<span class="tag tagval_'. $row["amenitiesID"] .'" id="span_'. $row["amenitiesID"] .'"> '. $row["amenitiesname"] .'<input type="hidden" value="'.$row["amenities"].'" class="qty_amenities"><input type="hidden" value="'. $row["amenitiesID"] .'" class="chosen_amenities"></span>';
        	}
        	echo '<br><label style="width: 100%;" onclick="addnewrefamenities()">Click to add amenities ..</label>';
        break;

		case 'loadmallls':
			echo '<option value="">-- Select Wing --</option>';
			$sql = "SELECT wingID, wing FROM tblref_wing WHERE mallID = '".$_POST["id"]."'";
			$result = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($result)){
				echo "<option value='".$row["wingID"]."'>".$row["wing"]."</option>";
			}
		break;

		case 'loadflrrrls':
			echo "<option value=''>-- Select Floor --</option>";
			$sql = "SELECT floorid, floor FROM tblref_floorsetup WHERE mallid = '".$_POST["id"]."'";
			$result = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($result)){
				echo "<option value='".$row["floorid"]."'>".$row["floor"]."</option>";
			}
		break;

		case 'loadflrrrls2':
			echo "<option value=''>-- Select Floor --</option>";
			$sql = "SELECT floorid, floor FROM tblref_floorsetup WHERE wingid = '".$_POST["id"]."'";
			$result = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($result)){
				echo "<option value='".$row["floorid"]."'>".$row["floor"]."</option>";
			}
		break;

		case 'delrefunit':
			$sql = "DELETE FROM tblref_unit WHERE unitid = '". $_POST["id"] ."';";
			$res = mysql_query($sql, $connection);
			if($res == true){
				echo "Successfully deleted.";
			}
		break;

		case 'loadwingflr':
			echo '<option value="">-- Select Wing --</option>';
			$queryflr = "SELECT wing, wingID FROM tblref_wing WHERE floorID = '".$_POST["id"]."'";
    		$result_flr = mysql_query($queryflr, $connection);
			while($row = mysql_fetch_array($result_flr)){
				echo "<option value='".$row["wingID"]."'>".$row["wing"]."</option>";
			}
		break;

		case 'load_billsetup':
			$sql = mysql_fetch_array(mysql_query("SELECT prepby, chkdby, apprby, rcvdby, mall_id, vatable_rent, vat_rent_type, vat_rent_prcnt, vatable_penalty, vat_penalty_type, vat_penalty_prcnt, penalty_type, penalty_amount, penalty_percent, depositperc FROM mall_setup WHERE mall_id = '".$_POST["mallid"]."';", $connection));
			echo $sql["prepby"] . "#" . $sql["chkdby"] . "#" . $sql["apprby"] . "#" . $sql["rcvdby"] . "#" . $sql["mall_id"] . "#" . $sql["vatable_rent"] . "#" . $sql["vat_rent_type"] . "#" . $sql["vat_rent_prcnt"] . "#" . $sql["vatable_penalty"] . "#" . $sql["vat_penalty_type"] . "#" . $sql["vat_penalty_prcnt"] . "#" . $sql["penalty_type"] . "#" . number_format($sql["penalty_amount"], 2, '.', ',') . "#" . $sql["penalty_percent"] . "#" . $sql['depositperc'];
		break;

		case 'fncSaveUnitClassification':
			$res = mysql_query("INSERT INTO tblref_unitclass SET UnitClassID = '". $_POST['UnitClassCode'] ."', UnitClassDesc = '". $_POST['UnitClassDesc'] ."';", $connection);
			if($res == true){
				echo 1;
			}else{
				echo 2;
			}
		break;

		case 'fncBillYear':
			echo "<option value=''>-- Select Year --</option>";
			$res = mysql_query("SELECT DISTINCT(BillYear) FROM tblref_billperiod WHERE MallID = '". $_POST['MallID'] ."';", $connection);
			while($row = mysql_fetch_array($res)){
				echo "<option value='". $row[0] ."'>". $row[0] ."</option>";
			}
		break;

		case 'fncGenerateCOPeriod':
			if($_POST['CutOffDate'] == 31){
				echo 	"<tr>
							<td style='vertical-align: middle;'>January-". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>01/01/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>01/31/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'><input type='text' class='date-picker form-control txtCUDateRequired input-sm txtCOPDueDate'></td>
						</tr>";
				echo 	"<tr>
							<td style='vertical-align: middle;'>February-". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>02/01/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>";
								if(checkdate(02,28,$_POST['CutOffYear']) == 1){
									echo "02/28/". $_POST['CutOffYear'];
								}else{
									echo "02/29/". $_POST['CutOffYear'];
								}
				echo		"</td>
							<td style='vertical-align: middle;'><input type='text' class='date-picker form-control txtCUDateRequired input-sm txtCOPDueDate'></td>
						</tr>";
				echo 	"<tr>
							<td style='vertical-align: middle;'>March-". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>03/01/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>03/31/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'><input type='text' class='date-picker form-control txtCUDateRequired input-sm txtCOPDueDate'></td>
						</tr>";
				echo 	"<tr>
							<td style='vertical-align: middle;'>April-". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>04/01/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>04/30/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'><input type='text' class='date-picker form-control txtCUDateRequired input-sm txtCOPDueDate'></td>
						</tr>";
				echo 	"<tr>
							<td style='vertical-align: middle;'>May-". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>05/01/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>05/31/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'><input type='text' class='date-picker form-control txtCUDateRequired input-sm txtCOPDueDate'></td>
						</tr>";
				echo 	"<tr>
							<td style='vertical-align: middle;'>June-". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>06/01/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>06/30/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'><input type='text' class='date-picker form-control txtCUDateRequired input-sm txtCOPDueDate'></td>
						</tr>";
				echo 	"<tr>
							<td style='vertical-align: middle;'>July-". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>07/01/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>07/31/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'><input type='text' class='date-picker form-control txtCUDateRequired input-sm txtCOPDueDate'></td>
						</tr>";
				echo 	"<tr>
							<td style='vertical-align: middle;'>August-". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>08/01/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>08/31/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'><input type='text' class='date-picker form-control txtCUDateRequired input-sm txtCOPDueDate'></td>
						</tr>";
				echo 	"<tr>
							<td style='vertical-align: middle;'>September-". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>09/01/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>09/30/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'><input type='text' class='date-picker form-control txtCUDateRequired input-sm txtCOPDueDate'></td>
						</tr>";
				echo 	"<tr>
							<td style='vertical-align: middle;'>October-". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>10/01/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>10/31/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'><input type='text' class='date-picker form-control txtCUDateRequired input-sm txtCOPDueDate'></td>
						</tr>";
				echo 	"<tr>
							<td style='vertical-align: middle;'>November-". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>11/01/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>11/30/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'><input type='text' class='date-picker form-control txtCUDateRequired input-sm txtCOPDueDate'></td>
						</tr>";
				echo 	"<tr>
							<td style='vertical-align: middle;'>December-". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>12/01/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>12/31/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'><input type='text' class='date-picker form-control txtCUDateRequired input-sm txtCOPDueDate'></td>
						</tr>";
			}else if($_POST['CutOffDate'] == 30){	
				echo 	"<tr>
							<td style='vertical-align: middle;'>January-". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>12/31/". floatval($_POST['CutOffYear']-1) ."</td>
							<td style='vertical-align: middle;'>01/30/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'><input type='text' class='date-picker form-control txtCUDateRequired input-sm txtCOPDueDate'></td>
						</tr>";
				echo 	"<tr>
							<td style='vertical-align: middle;'>February-". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>01/31/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>";
								if(checkdate(02,28,$_POST['CutOffYear']) == 1){
									echo "02/28/". $_POST['CutOffYear'];
								}else{
									echo "02/29/". $_POST['CutOffYear'];
								}
				echo		"</td>
							<td style='vertical-align: middle;'><input type='text' class='date-picker form-control txtCUDateRequired input-sm txtCOPDueDate'></td>
						</tr>";
				echo 	"<tr>
							<td style='vertical-align: middle;'>March-". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>03/01/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>03/30/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'><input type='text' class='date-picker form-control txtCUDateRequired input-sm txtCOPDueDate'></td>
						</tr>";
				echo 	"<tr>
							<td style='vertical-align: middle;'>April-". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>03/31/". $_POST['CutOffYear'] ."</td>
							<td>04/30/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'><input type='text' class='date-picker form-control txtCUDateRequired input-sm txtCOPDueDate'></td>
						</tr>";
				echo 	"<tr>
							<td style='vertical-align: middle;'>May-". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>05/01/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>05/30/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'><input type='text' class='date-picker form-control txtCUDateRequired input-sm txtCOPDueDate'></td>
						</tr>";
				echo 	"<tr>
							<td style='vertical-align: middle;'>June-". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>05/31/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>06/30/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'><input type='text' class='date-picker form-control txtCUDateRequired input-sm txtCOPDueDate'></td>
						</tr>";
				echo 	"<tr>
							<td style='vertical-align: middle;'>July-". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>07/01/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>07/30/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'><input type='text' class='date-picker form-control txtCUDateRequired input-sm txtCOPDueDate'></td>
						</tr>";
				echo 	"<tr>
							<td style='vertical-align: middle;'>August-". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>07/31/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>08/30/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'><input type='text' class='date-picker form-control txtCUDateRequired input-sm txtCOPDueDate'></td>
						</tr>";
				echo 	"<tr>
							<td style='vertical-align: middle;'>September-". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>08/31/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>09/30/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'><input type='text' class='date-picker form-control txtCUDateRequired input-sm txtCOPDueDate'></td>
						</tr>";
				echo 	"<tr>
							<td style='vertical-align: middle;'>October-". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>10/01/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>10/30/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'><input type='text' class='date-picker form-control txtCUDateRequired input-sm txtCOPDueDate'></td>
						</tr>";
				echo 	"<tr>
							<td style='vertical-align: middle;'>November-". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>10/31/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>11/30/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'><input type='text' class='date-picker form-control txtCUDateRequired input-sm txtCOPDueDate'></td>
						</tr>";
				echo 	"<tr>
							<td style='vertical-align: middle;'>December-". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>12/01/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>12/30/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'><input type='text' class='date-picker form-control txtCUDateRequired input-sm txtCOPDueDate'></td>
						</tr>";
			}else if($_POST['CutOffDate'] == 29){
				echo 	"<tr>
							<td style='vertical-align: middle;'>January-". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>12/". floatval($_POST['CutOffDate']+1) ."/". floatval($_POST['CutOffYear']-1) ."</td>
							<td style='vertical-align: middle;'>01/". $_POST['CutOffDate'] ."/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'><input type='text' class='date-picker form-control txtCUDateRequired input-sm txtCOPDueDate'></td>
						</tr>";
				echo 	"<tr>
							<td style='vertical-align: middle;'>February-". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>01/". floatval($_POST['CutOffDate']+1) ."/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>";
								if(checkdate(02,28,$_POST['CutOffYear']) == 1){
									echo "02/28/". $_POST['CutOffYear'];
								}else{
									echo "02/29/". $_POST['CutOffYear'];
								}
				echo		"</td>
							<td style='vertical-align: middle;'><input type='text' class='date-picker form-control txtCUDateRequired input-sm txtCOPDueDate'></td>
						</tr>";
				echo 	"<tr>
							<td style='vertical-align: middle;'>March-". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>";
								if(floatval($_POST['CutOffDate']+1) >= '28'){
									if(checkdate(02,28,$_POST['CutOffYear']) == 1){
										echo date('m/d/Y', strtotime("02/28/". $_POST['CutOffYear']));
									}else{
										echo date('m/d/Y', strtotime("02/29/". $_POST['CutOffYear']));
									}
								}else{
									echo "02/". floatval($_POST['CutOffDate']+1) ."/".$_POST['CutOffYear'];
								}
				echo		"</td>
							<td style='vertical-align: middle;'>03/". $_POST['CutOffDate'] ."/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'><input type='text' class='date-picker form-control txtCUDateRequired input-sm txtCOPDueDate'></td>
						</tr>";
				echo 	"<tr>
							<td style='vertical-align: middle;'>April-". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>03/". floatval($_POST['CutOffDate']+1) ."/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>04/". $_POST['CutOffDate'] ."/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'><input type='text' class='date-picker form-control txtCUDateRequired input-sm txtCOPDueDate'></td>
						</tr>";
				echo 	"<tr>
							<td style='vertical-align: middle;'>May-". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>04/". floatval($_POST['CutOffDate']+1) ."/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>05/". $_POST['CutOffDate'] ."/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'><input type='text' class='date-picker form-control txtCUDateRequired input-sm txtCOPDueDate'></td>
						</tr>";
				echo 	"<tr>
							<td>June-". $_POST['CutOffYear'] ."</td>
							<td>05/". floatval($_POST['CutOffDate']+1) ."/". $_POST['CutOffYear'] ."</td>
							<td>06/". $_POST['CutOffDate'] ."/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'><input type='text' class='date-picker form-control txtCUDateRequired input-sm txtCOPDueDate'></td>
						</tr>";
				echo 	"<tr>
							<td style='vertical-align: middle;'>July-". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>06/". floatval($_POST['CutOffDate']+1) ."/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>07/". $_POST['CutOffDate'] ."/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'><input type='text' class='date-picker form-control txtCUDateRequired input-sm txtCOPDueDate'></td>
						</tr>";
				echo 	"<tr>
							<td style='vertical-align: middle;'>August-". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>07/". floatval($_POST['CutOffDate']+1) ."/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>08/". $_POST['CutOffDate'] ."/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'><input type='text' class='date-picker form-control txtCUDateRequired input-sm txtCOPDueDate'></td>
						</tr>";
				echo 	"<tr>
							<td style='vertical-align: middle;'>September-". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>08/". floatval($_POST['CutOffDate']+1) ."/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>09/". $_POST['CutOffDate'] ."/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'><input type='text' class='date-picker form-control txtCUDateRequired input-sm txtCOPDueDate'></td>
						</tr>";
				echo 	"<tr>
							<td style='vertical-align: middle;'>October-". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>09/". floatval($_POST['CutOffDate']+1) ."/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>10/". $_POST['CutOffDate'] ."/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'><input type='text' class='date-picker form-control txtCUDateRequired input-sm txtCOPDueDate'></td>
						</tr>";
				echo 	"<tr>
							<td style='vertical-align: middle;'>November-". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>10/". floatval($_POST['CutOffDate']+1) ."/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>11/". $_POST['CutOffDate'] ."/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'><input type='text' class='date-picker form-control txtCUDateRequired input-sm txtCOPDueDate'></td>
						</tr>";
				echo 	"<tr>
							<td style='vertical-align: middle;'>December-". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>11/". floatval($_POST['CutOffDate']+1) ."/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>12/". $_POST['CutOffDate'] ."/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'><input type='text' class='date-picker form-control txtCUDateRequired input-sm txtCOPDueDate'></td>
						</tr>";
			}else{
				echo 	"<tr>
							<td style='vertical-align: middle;'>January-". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>12/". floatval($_POST['CutOffDate']+1) ."/". floatval($_POST['CutOffYear']-1) ."</td>
							<td style='vertical-align: middle;'>01/". $_POST['CutOffDate'] ."/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'><input type='text' class='date-picker form-control txtCUDateRequired input-sm txtCOPDueDate'></td>
						</tr>";
				echo 	"<tr>
							<td style='vertical-align: middle;'>February-". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>01/". floatval($_POST['CutOffDate']+1) ."/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>02/". $_POST['CutOffDate'] ."/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'><input type='text' class='date-picker form-control txtCUDateRequired input-sm txtCOPDueDate'></td>
						</tr>";
				echo 	"<tr>
							<td style='vertical-align: middle;'>March-". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>";
								if(floatval($_POST['CutOffDate']+1) >= '28'){
									if(checkdate(02,28,$_POST['CutOffYear']) == 1){
										echo date('m/d/Y', strtotime("02/28/". $_POST['CutOffYear']));
									}else{
										echo date('m/d/Y', strtotime("02/29/". $_POST['CutOffYear']));
									}
								}else{
									echo "02/". floatval($_POST['CutOffDate']+1) ."/".$_POST['CutOffYear'];
								}
				echo		"</td>
							<td style='vertical-align: middle;'>03/". $_POST['CutOffDate'] ."/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'><input type='text' class='date-picker form-control txtCUDateRequired input-sm txtCOPDueDate'></td>
						</tr>";
				echo 	"<tr>
							<td style='vertical-align: middle;'>April-". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>03/". floatval($_POST['CutOffDate']+1) ."/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>04/". $_POST['CutOffDate'] ."/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'><input type='text' class='date-picker form-control txtCUDateRequired input-sm txtCOPDueDate'></td>
						</tr>";
				echo 	"<tr>
							<td style='vertical-align: middle;'>May-". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>04/". floatval($_POST['CutOffDate']+1) ."/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>05/". $_POST['CutOffDate'] ."/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'><input type='text' class='date-picker form-control txtCUDateRequired input-sm txtCOPDueDate'></td>
						</tr>";
				echo 	"<tr>
							<td style='vertical-align: middle;'>June-". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>05/". floatval($_POST['CutOffDate']+1) ."/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>06/". $_POST['CutOffDate'] ."/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'><input type='text' class='date-picker form-control txtCUDateRequired input-sm txtCOPDueDate'></td>
						</tr>";
				echo 	"<tr>
							<td style='vertical-align: middle;'>July-". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>06/". floatval($_POST['CutOffDate']+1) ."/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>07/". $_POST['CutOffDate'] ."/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'><input type='text' class='date-picker form-control txtCUDateRequired input-sm txtCOPDueDate'></td>
						</tr>";
				echo 	"<tr>
							<td style='vertical-align: middle;'>August-". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>07/". floatval($_POST['CutOffDate']+1) ."/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>08/". $_POST['CutOffDate'] ."/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'><input type='text' class='date-picker form-control txtCUDateRequired input-sm txtCOPDueDate'></td>
						</tr>";
				echo 	"<tr>
							<td style='vertical-align: middle;'>September-". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>08/". floatval($_POST['CutOffDate']+1) ."/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>09/". $_POST['CutOffDate'] ."/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'><input type='text' class='date-picker form-control txtCUDateRequired input-sm txtCOPDueDate'></td>
						</tr>";
				echo 	"<tr>
							<td style='vertical-align: middle;'>October-". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>09/". floatval($_POST['CutOffDate']+1) ."/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>10/". $_POST['CutOffDate'] ."/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'><input type='text' class='date-picker form-control txtCUDateRequired input-sm txtCOPDueDate'></td>
						</tr>";
				echo 	"<tr>
							<td style='vertical-align: middle;'>November-". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>10/". floatval($_POST['CutOffDate']+1) ."/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>11/". $_POST['CutOffDate'] ."/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'><input type='text' class='date-picker form-control txtCUDateRequired input-sm txtCOPDueDate'></td>
						</tr>";
				echo 	"<tr>
							<td style='vertical-align: middle;'>December-". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>11/". floatval($_POST['CutOffDate']+1) ."/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'>12/". $_POST['CutOffDate'] ."/". $_POST['CutOffYear'] ."</td>
							<td style='vertical-align: middle;'><input type='text' class='date-picker form-control txtCUDateRequired input-sm txtCOPDueDate'></td>
						</tr>";
			}
		break;

		case 'fncSaveCutOffPeriod':
			$Success = 0;
			$PeriodDate = explode("@", $_POST['arrPeriod']);
			for($i = 0; $i <= COUNT($PeriodDate)-2; $i++){
				$arrDate = explode("|", $PeriodDate[$i]);
				$Bill = explode("-", $arrDate[0]);
				$ifExisting = mysql_num_rows(mysql_query("SELECT id FROM tblref_billperiod WHERE BillMonth = '". date('n', strtotime('2019-'.$Bill[0].'-01')) ."' AND BillYear = '". $Bill[1] ."' AND MallID = '". $_POST['MallID'] ."';", $connection));
				if($ifExisting >= 1){
					$Success--;
				}else{
					$SOANo = createctrlno("", "tblref_billperiod", "soaid");
					$SOAID = SysLeaseSetup('mallprefix') . "-" . $Bill[1] . "-" . date('m', strtotime($Bill[0])) . "-" . $SOANo;
					$res = mysql_query("INSERT INTO tblref_billperiod SET soaid = '". $SOAID ."', BillMonth = '". date('n', strtotime($Bill[0])) ."', BillYear = '". $Bill[1] ."', startDate = '". date('Y-m-d', strtotime($arrDate[1])) ."', EndDate = '". date('Y-m-d', strtotime($arrDate[2])) ."', DueDate = '". date('Y-m-d', strtotime($arrDate[3])) ."', MallID = '". $_POST['MallID'] ."';", $connection);
					if($res == true){
						$Success++;
					}
				}
			}
			if($Success >= 1){
				echo 1;
				$getMallName = mysql_fetch_array(mysql_query("SELECT mallname FROM tblref_mall WHERE mallid = '". $_POST['MallID'] ."';", $connection));
				$arrHeader = ["Mall ID", "Mall Name", "Cut-off Year", "Cut-off Date", "Due Date",];
	            $arrValue = [$_POST['MallID'], $getMallName['mallname'], $_POST['CutOffYear'], "Day ". $_POST['CutOffDate'] ." of the month", "Day ". $_POST['DueDate'] ." of the month"];
	            $tran_logs = create_logs_per_transaction("created a cut-off period.", "Mall Configuation", createXinfo("INSERT", $arrHeader, "", $arrValue, "", "", ""), "" ,"ADD", "");
			//INSERT LOG FIRST - JONAS - 3/13/2019
			}else{
				echo 2;
			}
		break;

		case 'fncLoadBillSetup':
			$res = mysql_query("SELECT BillMonth, BillYear, StartDate, EndDate, DueDate, Posted FROM tblref_billperiod WHERE MallID = '". $_POST['MallID'] ."' AND BillYear = '". $_POST['BillYear'] ."';", $connection);
			while($row = mysql_fetch_array($res)){
				echo 	"<tr>
							<td>". date('M', strtotime("2019-".str_pad($row['BillMonth'], 2, 0, STR_PAD_LEFT)."-01")) ."-". $row['BillYear'] ."</td>
							<td>". date('m/d/Y', strtotime($row['StartDate'])) ."</td>
							<td>". date('m/d/Y', strtotime($row['EndDate'])) ."</td>
							<td>". date('m/d/Y', strtotime($row['DueDate'])) ."</td>
						</tr>";
			}
		break;

		case 'savesoasign':
			$cnt = mysql_fetch_array(mysql_query("SELECT COUNT(mall_id) FROM mall_setup WHERE mall_id = '". $_POST["mallid"] ."';", $connection));
			if($cnt[0] == 0){
				//INSERT LOG FIRST - JONAS - 12/10/2018
				if($_POST['mallid'] != ""){
					$Logs .= "Mall ID : ". $_POST['mallid'] . "|";
				}
				$getMallName = mysql_fetch_array(mysql_query("SELECT mallname FROM tblref_mall WHERE mallid = '". $_POST['mallid'] ."';", $connection));
				if($getMallName['mallname'] != ""){
					$Logs .= "Mall Name : ". $getMallName['mallname'] . "|";
				}
				$arr = explode("|", $_POST['prep']);
				if($_POST['prep'] != ""){
					$Logs .= "Prepared By  : ". $arr[0] . ", " . $arr[1] . " " . $arr[2] . "|";
				}
				$arr2 = explode("|", $_POST['chkd']);
				if($_POST['chkd'] != ""){
					$Logs .= "Checked By  : ". $arr2[0] . ", " . $arr2[1] . " " . $arr2[2] . "|";
				}
				$arr3 = explode("|", $_POST['appr']);
				if($_POST['appr'] != ""){
					$Logs .= "Approved By  : ". $arr3[0] . ", " . $arr3[1] . " " . $arr3[2] . "|";
				}
				$arr3 = explode("|", $_POST['rcvd']);
				if($_POST['rcvd'] != ""){
					$Logs .= "Received By  : ". $arr3[0] . ", " . $arr3[1] . " " . $arr3[2] . "|";
				}
				if($Logs != ""){
					$tran_logs = create_logs_per_transaction("added a SoA Signatories.", $label . " Configuration", $Logs, "" ,"ADD", "");
				}
				//INSERT LOG FIRST - JONAS - 12/10/2018
				$sql = mysql_query("INSERT INTO mall_setup (prepby, chkdby, apprby, rcvdby, mall_id) VALUES('". $_POST["prep"] ."', '". $_POST["chkd"] ."', '". $_POST["appr"] ."', '". $_POST["rcvd"] ."', '". $_POST["mallid"] ."');", $connection);
				if($sql == true){
					echo 1;
				}
			}else{
				//INSERT LOG FIRST - JONAS - 12/10/2018
				$CurrentSig = mysql_fetch_array(mysql_query("SELECT prepby, chkdby, apprby, rcvdby FROM mall_setup WHERE mall_id = '". $_POST['mallid'] ."';", $connection));
				if($_POST['mallid'] != ""){
					$Logs .= "Mall ID : ". $_POST['mallid'] . "|";
				}
				$getMallName = mysql_fetch_array(mysql_query("SELECT mallname FROM tblref_mall WHERE mallid = '". $_POST['mallid'] ."';", $connection));
				if($getMallName['mallname'] != ""){
					$Logs .= "Mall Name : ". $getMallName['mallname'] . "|";
				}
				$arr = explode("|", $_POST['prep']);
				if($_POST['prep'] != ""){
					$Logs .= "Prepared By  : ". $arr[0] . ", " . $arr[1] . " " . $arr[2] . "|";
				}
				$arr2 = explode("|", $_POST['chkd']);
				if($_POST['chkd'] != ""){
					$Logs .= "Checked By  : ". $arr2[0] . ", " . $arr2[1] . " " . $arr2[2] . "|";
				}
				$arr3 = explode("|", $_POST['appr']);
				if($_POST['appr'] != ""){
					$Logs .= "Approved By  : ". $arr3[0] . ", " . $arr3[1] . " " . $arr3[2] . "|";
				}
				$arr3 = explode("|", $_POST['rcvd']);
				if($_POST['rcvd'] != ""){
					$Logs .= "Received By  : ". $arr3[0] . ", " . $arr3[1] . " " . $arr3[2] . "|";
				}
				if($Logs != ""){
					$tran_logs = create_logs_per_transaction("modified a SoA Signatories.", $label . " Configuration", $Logs, "" ,"UPDATE", "");
				}
				//INSERT LOG FIRST - JONAS - 12/10/2018
				$sql = mysql_query("UPDATE mall_setup SET prepby = '". $_POST["prep"] ."', chkdby = '". $_POST["chkd"] ."', apprby = '". $_POST["appr"] ."', rcvdby = '". $_POST["rcvd"] ."' WHERE mall_id = '". $_POST["mallid"] ."';", $connection);
				if($sql == true){
					echo 2;
				}
			}
		break;

		case 'save_vat_penalty_setup':
			$cnt = mysql_fetch_array(mysql_query("SELECT COUNT(mall_id) FROM mall_setup WHERE mall_id = '".$_POST["mallid"]."';", $connection));
			if($cnt[0] == 0){
				$sql = mysql_query("INSERT INTO mall_setup (vatable_rent, vat_rent_type, vat_rent_prcnt, vatable_penalty, vat_penalty_type, vat_penalty_prcnt, penalty_type, penalty_amount, penalty_percent, mall_id, depositperc) VALUES('". $_POST["rent_vatable"] ."', '". $_POST["rent_vattype"] ."', '". $_POST["rent_vatperc"] ."', '". $_POST["penalty_vatable"] ."', '". $_POST["penalty_vattype"] ."', '". $_POST["penalty_vatperc"] ."', '". $_POST["penalty_type"] ."', '". $_POST["penalty_amt"] ."', '". $_POST["penalty_perc"] ."', '". $_POST["mallid"] ."', '". $_POST['deposit_perc'] ."');", $connection);
				if($sql == true){
					echo 1;
				}
				if($_POST['mallid'] != ""){
					$Logs .= "Mall ID : ". $_POST['mallid'] . "|";
				}
				if($_POST['rent_vatable'] == "yes"){
					$Logs .= "is Rent VATable?  : Yes|";
				}else{
					$Logs .= "is Rent VATable?  : No|";
				}
				if($_POST['vat_penalty_prcnt'] == "exc"){
					$Logs .= "Rent VAT Type  : Exclusive|";
				}else{
					$Logs .= "Rent VAT Type  : Inclusive|";
				}
				if($_POST['rent_vatperc'] != "" || $_POST['rent_vatperc'] != 0){
					$Logs .= "Rent VAT Percent  : ". $_POST['rent_vatperc'] ."|";
				}
				if($_POST['penalty_vatable'] == "yes"){
					$Logs .= "is Penalty VATable?  : Yes|";
				}else{
					$Logs .= "is Penalty VATable? : No|";
				}
				if($_POST['penalty_vattype'] == "exc"){
					$Logs .= "Penalty VAT Type  : Exclusive|";
				}else{
					$Logs .= "Penalty VAT Type  : Inclusive|";
				}
				if($_POST['penalty_vatperc'] != "" || $_POST['penalty_vatperc'] != 0){
					$Logs .= "Rent VAT Percent  : ". $_POST['penalty_vatperc'] ."|";
				}
				if($_POST['penalty_type'] == "amount"){
					$Logs .= "is Penalty VATable?  : Amount|";
				}else{
					$Logs .= "is Penalty VATable? : Percent|";
				}
				if($_POST['penalty_amt'] != "" || $_POST['penalty_amt'] != 0){
					$Logs .= "Penalty Amount : ". $_POST['penalty_amt'] ."|";
				}
				if($_POST['penalty_perc'] != "" || $_POST['penalty_perc'] != 0){
					$Logs .= "Penalty Percent : ". $_POST['penalty_perc'] ."|";
				}
				if($Logs != ""){
					$tran_logs = create_logs_per_transaction("updated the Penalty and VAT setup.", $label . " Configuration", $Logs, "" ,"ADD", "");
				}
			}else{
				$sql = mysql_query("UPDATE mall_setup SET vatable_rent = '".$_POST["rent_vatable"]."', vat_rent_type = '".$_POST["rent_vattype"]."', vat_rent_prcnt = '".$_POST["rent_vatperc"]."', vatable_penalty = '".$_POST["penalty_vatable"]."', vat_penalty_type = '".$_POST["penalty_vattype"]."', vat_penalty_prcnt = '".$_POST["penalty_vatperc"]."', penalty_type = '".$_POST["penalty_type"]."', penalty_percent = '".$_POST["penalty_perc"]."', penalty_amount = '".$_POST["penalty_amt"]."', depositperc = '". $_POST['deposit_perc'] ."' WHERE mall_id = '".$_POST["mallid"]."';", $connection);
				if($sql == true){
					echo 2;
				}
				if($_POST['mallid'] != ""){
					$Logs .= "Mall ID : ". $_POST['mallid'] . "|";
				}
				if($_POST['rent_vatable'] == "yes"){
					$Logs .= "is Rent VATable?  : Yes|";
				}else{
					$Logs .= "is Rent VATable?  : No|";
				}
				if($_POST['vat_penalty_prcnt'] == "exc"){
					$Logs .= "Rent VAT Type  : Exclusive|";
				}else{
					$Logs .= "Rent VAT Type  : Inclusive|";
				}
				if($_POST['rent_vatperc'] != "" || $_POST['rent_vatperc'] != 0){
					$Logs .= "Rent VAT Percent  : ". $_POST['rent_vatperc'] ."|";
				}
				if($_POST['penalty_vatable'] == "yes"){
					$Logs .= "is Penalty VATable?  : Yes|";
				}else{
					$Logs .= "is Penalty VATable? : No|";
				}
				if($_POST['penalty_vattype'] == "exc"){
					$Logs .= "Penalty VAT Type  : Exclusive|";
				}else{
					$Logs .= "Penalty VAT Type  : Inclusive|";
				}
				if($_POST['penalty_vatperc'] != "" || $_POST['penalty_vatperc'] != 0){
					$Logs .= "Rent VAT Percent  : ". $_POST['penalty_vatperc'] ."|";
				}
				if($_POST['penalty_type'] == "amount"){
					$Logs .= "is Penalty VATable?  : Amount|";
				}else{
					$Logs .= "is Penalty VATable? : Percent|";
				}
				if($_POST['penalty_amt'] != "" || $_POST['penalty_amt'] != 0){
					$Logs .= "Penalty Amount : ". $_POST['penalty_amt'] ."|";
				}
				if($_POST['penalty_perc'] != "" || $_POST['penalty_perc'] != 0){
					$Logs .= "Penalty Percent : ". $_POST['penalty_perc'] ."|";
				}
				if($Logs != ""){
					$tran_logs = create_logs_per_transaction("updated the Penalty and VAT setup.", $label . " Configuration", $Logs, "" ,"ADD", "");
				}
			}
		break;

		case 'loadUPBsetup':
			$UPBsetup = mysql_fetch_array(mysql_query("SELECT spotperc, downperc, balanceperc, promo_disc ,company_disc ,standard_disc ,reg_fee ,doc_tax ,trans_tax ,legal_fee ,WE_connection ,misc_fee, typeofreservationfee, typeofretentionfee, reservationfee, retentionfee FROM mall_setup WHERE mall_id = '". $_POST['mallid'] ."';", $connection));
			echo $UPBsetup[0] . "|" . $UPBsetup[1] . "|" . $UPBsetup[2] . "|" . $UPBsetup[3] . "|" . $UPBsetup[4] . "|" . $UPBsetup[5] . "|" . $UPBsetup[6] . "|" . $UPBsetup[7] . "|" . $UPBsetup[8] . "|" . $UPBsetup[9] . "|" . $UPBsetup[10] . "|" . $UPBsetup[11] . "|" . $UPBsetup[12] . "|" . $UPBsetup[13] . "|" . $UPBsetup[14] . "|" . $UPBsetup[15];
		break;

		case 'saveUPB':
			$sql = "UPDATE mall_setup SET spotperc = '". $_POST['spot'] ."', downperc = '". $_POST['down'] ."', balanceperc = '". $_POST['balance'] ."', promo_disc = '". $_POST['promo'] ."', company_disc = '". $_POST['company'] ."', standard_disc = '". $_POST['standard'] ."', typeofreservationfee = '". $_POST['reservationtype'] ."', typeofretentionfee = '". $_POST['retentiontype'] ."',reservationfee = '". $_POST['reservationfee'] ."' ,retentionfee = '". $_POST['retentionfee'] ."'  WHERE mall_id = '". $_POST['mallid'] ."';";
			$res = mysql_query($sql, $connection);
			if($res == true){
				echo "1|Unit Price Breakdown setup saved.";
			}else{
				echo "2|Failed to save data.";
			}
		break;

		case 'saveothercharges':
			$sql = "UPDATE mall_setup SET reg_fee = '". $_POST['reg_fee'] ."', doc_tax = '". $_POST['doc_tax'] ."', trans_tax = '". $_POST['trans_tax'] ."', legal_fee = '". $_POST['legal_fee'] ."', WE_connection = '". $_POST['WE_connection'] ."', misc_fee = '". $_POST['misc_fee'] ."' WHERE mall_id = '". $_POST['mallid'] ."';";
			$res = mysql_query($sql, $connection);
			if($res == true){
				echo "1|Other Charges setup saved.";
			}else{
				echo "2|Failed to save data.";
			}
		break;

		case 'fnc_loadLeaseSignatories':
			$count = 0;
			$res = mysql_query("SELECT a.userid, c.groupname, a.Signatory FROM tblref_leasingsignatories AS a LEFT JOIN tbluser AS b ON a.userid = b.userid LEFT JOIN tblref_groupaccess AS c ON b.groupaccess = c.groupid WHERE a.mallid = '". $_POST['mallid'] ."' ORDER BY a.id;", $connection);
			while($row = mysql_fetch_array($res)){
                $count++;
				echo "	<div class='row form-group' id='divLease". $count ."'>
	                        <div class='col-xs-1 center'>
	                            <label>
	                                <input name='form-field-checkbox' type='checkbox' class='ace DisMePlease2 chkLeaseInfo' value='divLease". $count ."'>
	                                <span class='lbl'></span>
	                            </label>
	                        </div>
	                        <label class='col-md-1'>User</label>
	                        <div class='col-md-3'>
	                            <select class='form-control LesSigUser DisMePlease2' id='txtLeaseSigUser". $count ."' onchange='showGroupofUser(this.value, \"txtLeaseSigPosition". $count ."\")'>";
	                            	echo "<option value=''>-- Select Personnel --</option>";
									$res2 = mysql_query("SELECT userid, CONCAT(firstname, ' ', lastname), groupaccess FROM tbluser;", $connection);
									while($row2 = mysql_fetch_array($res2)){
										if($row[0] == $row2[0]){
											$selectthis = "selected";
										}else{
											$selectthis = "";
										}
						                echo "<option value='". $row2[0] ."@". $row2['groupaccess'] ."' ". $selectthis .">". $row2[1] ."</option>";
									}
	                    echo    "</select>
	                        </div>
	                        <label class='col-md-1'>Position</label>
	                        <div class='col-md-2'>
	                            <input type='text' class='form-control DisMePlease2' id='txtLeaseSigPosition". $count ."' value='". $row[1] ."' readonly>
	                        </div>
	                        <label class='col-md-1'>Signatory</label>
	                        <div class='col-md-2'>
	                            <input type='text' class='form-control LesSigUser DisMePlease2' id='txtLeaseSignatory". $count ."' value='". $row[2] ."'>
	                        </div>
	                    </div>";
			}
			echo "|" . $count;
		break;

		case 'slctUserSignatories':
           	echo "<option value=''>-- Select Personnel --</option>";
			$res = mysql_query("SELECT userid, CONCAT(firstname, ' ', lastname), groupaccess FROM tbluser;", $connection);
			while($row = mysql_fetch_array($res)){
                echo "<option value='". $row[0] ."@". $row['groupaccess'] ."'>". $row[1] ."</option>";
			}
		break;

		case 'showGroupofUser':
			$arr = explode("@", $_POST['explodethis']);
			$group = mysql_fetch_array(mysql_query("SELECT groupname FROM tblref_groupaccess WHERE groupid = '". $arr[1] ."';", $connection));
			echo $group[0];
		break;

		case 'SaveLeasingSignatories':
			$Truncate = mysql_query("DELETE FROM tblref_leasingsignatories WHERE mallid = '". $_POST['mallid'] ."';", $connection);
			if($Truncate == true){
				$arr = explode("#", $_POST['SigInfo']);
				for($x = 0; $x <= COUNT($arr)-2; $x++){
				$arr2 = explode("@", $arr[$x]);
				$arr3 = explode("|", $arr[$x]);
					if($arr2[0] != 'undefined' && $arr3[1] != 'undefined'){
						$res = mysql_query("INSERT INTO tblref_leasingsignatories SET userid = '". $arr2[0] ."', mallid = '". $_POST['mallid'] ."', Signatory = '". $arr3[1] ."';", $connection);
					}
				}
			}	
		break;

		case 'showmodal_BankInfo':
			$count = 1;
			$res = mysql_query("SELECT bankcode, accountnumber, accountname , isShow FROM tblref_mallbankinfo WHERE mallid = '". $_POST['mallid'] ."';", $connection);
			while($row = mysql_fetch_array($res)){
				echo "<div class='form-group row divBankList' id='divBankInfo". $count ."'>
                        <div class='col-md-1 center'>
                            <label>
                                <input name='form-field-checkbox' type='checkbox' class='ace DisMePlease chkBankInfo' value='divBankInfo". $count ."'>
                                <span class='lbl'></span>
                            </label>
                        </div>
                        <div class='col-md-3'>
                            Bank
                        </div>
                        <div class='col-md-3'>
                            Account Name
                        </div>
                        <div class='col-md-3'>
                            Account Number
                        </div>
                        <div class='col-md-2'>
                            Show in tenant
                        </div>
                        <div class='col-md-3'>
                            <select class='form-control DisMePlease BankList". $count ." thisbank'>
                            ";
                            echo "<option value=''>-- Select Bank --</option>";
								$res2 = mysql_query("SELECT xcode, description FROM tblrefbank;", $connection);
								while($row2 = mysql_fetch_array($res2)){
									if($row[0] == $row2[0]){
										$selectthis = "selected";
									}else{
										$selectthis = "";
									}
									echo "<option value='" . $row2[0] . "' ". $selectthis .">" . $row2[1] . "</option>";
								}
					$isChecked = "";

					// EDIT Ronald 2018-10-11

					if( $row[3] == 1 ){ $isChecked ='checked="checked"';}
                    echo    "</select>
                        </div>
                        <div class='col-md-3'>
                           <input type='text' class='form-control DisMePlease thisaccountname' value='". $row[2] ."'>
                        </div>
                        <div class='col-md-3'>
                           <input type='text' class='form-control DisMePlease thisaccount' value='". $row[1] ."'>
                        </div>
                        <div class='col-md-2'>
                            <label class='pull-center inline'>
								<input id='id-button-borders' ". $isChecked ." type='checkbox' class='isShowTenant DisMePlease ace ace-switch ace-switch-5'>
								<span class='lbl middle'></span>
							</label>
                        </div>
                    </div>";
                $count++;
			}

			echo "|" . $count;
		break;

		case 'SaveBankListinfo':
			$Truncate = mysql_query("DELETE FROM tblref_mallbankinfo WHERE mallid = '". $_POST['mallid'] ."';", $connection);
			if($Truncate == true){
				$arr = explode("#", $_POST['bankInfo']);
				for($x = 0; $x <= COUNT($arr)-2; $x++){
					$arr2 = explode("|", $arr[$x]);
					$bank = mysql_fetch_array(mysql_query("SELECT description FROM tblrefbank WHERE xcode = '". $arr2[0] ."';", $connection));
					// $res = mysql_query("INSERT INTO tblref_mallbankinfo SET mallid = '". $_POST['mallid'] ."', bankcode = '". $arr2[0] ."', bankdesc = '". $bank[0] ."', accountnumber = '". $arr2[1] ."', accountname = '". $arr2[2] ."'", $connection);
					// EDIT Ronald 2018-10-11
					$res = mysql_query("INSERT INTO tblref_mallbankinfo SET mallid = '". $_POST['mallid'] ."', bankcode = '". $arr2[0] ."', bankdesc = '". $bank[0] ."', accountnumber = '". $arr2[1] ."', accountname = '". $arr2[2] ."', isShow = '". $arr2[3] ."';", $connection);
				}
			}
		break;

		case 'SaveNewRate':
			if($_POST['RateID'] == ""){
				$sql = "INSERT INTO tblref_UtilRate SET mallid = '". $_POST['mallid'] ."', type = '". $_POST['UtilType'] ."', EffDate = '". date('Y-m-d', strtotime($_POST['EffDate'])) ."', DateAdded = '". date('Y-m-d') ."', UtilRate = '". $_POST['Rate'] ."', AdminFee = '". $_POST['AdminFee'] ."', AdminFeeType = '". $_POST['AdminFeeType'] ."';";
			}else{
				$sql = "UPDATE tblref_UtilRate SET mallid = '". $_POST['mallid'] ."', type = '". $_POST['UtilType'] ."', EffDate = '". date('Y-m-d', strtotime($_POST['EffDate'])) ."', UtilRate = '". $_POST['Rate'] ."', AdminFee = '". $_POST['AdminFee'] ."', AdminFeeType = '". $_POST['AdminFeeType'] ."' WHERE id = '". $_POST['RateID'] ."';";
			}
			$res = mysql_query($sql, $connection);
			if($res == true){
				echo "1";
			}else{
				echo "2";
			}
		break;

		case 'loadtbodyRateHistory':
			$res = mysql_query("SELECT DateAdded, EffDate, UtilRate, AdminFee, id, AdminFeeType FROM tblref_UtilRate WHERE mallid = '". $_POST['mallid'] ."' AND type = '". $_POST['UtilType'] ."' ORDER BY EffDate DESC;", $connection);
			while($row = mysql_fetch_array($res)){
				if($row['AdminFeeType'] == 1){
					$AdminFeeType = number_format($row['AdminFee'], 2, '.', ',');
				}else{
					$AdminFeeType = floatval($row['AdminFee']) ." %";
				}
				echo 	"<tr>
							<td>". date('m/d/Y', strtotime($row['DateAdded'])) ."</td>
							<td>". date('m/d/Y', strtotime($row['EffDate'])) ."</td>
							<td style='text-align: right;'>". number_format($row['UtilRate'], 5, '.', ',') ."</td>
							<td style='text-align: right;'>". $AdminFeeType ."</td>
							<td><button class='btn btn-sm btn-info btn-round' onclick='fncEditRate(\"". $_POST['UtilType'] ."\", \"". $row['id'] ."\");' title='Edit' style='margin: 2px;'><img src='assets/images/resume.png' style='width: 100%; height: auto;' /></button></td>
						</tr>";
			}
		break;

		case 'fncEditRate':
			$RateInfo = mysql_fetch_array(mysql_query("SELECT EffDate, UtilRate, AdminFee, AdminFeeType FROM tblref_UtilRate WHERE id = '". $_POST['id'] ."';", $connection));
			echo date('m/d/Y', strtotime($RateInfo['EffDate'])) . "|" . number_format($RateInfo['UtilRate'], 2, '.', ',') . "|" . floatval($RateInfo['AdminFee']) . "|" . $RateInfo['AdminFeeType'];
		break;

		case 'fncMinimumSetup':
			$MinSetup = mysql_fetch_array(mysql_query("SELECT MinElectric, MinWater, MinGas FROM mall_setup WHERE mall_id = '". $_POST['MallID'] ."';", $connection));
			if($_POST['UtilityType'] == "Electric"){
				echo number_format($MinSetup['MinElectric'], 2, '.', ',');
			}else if($_POST['UtilityType'] == "Water"){
				echo number_format($MinSetup['MinWater'], 2, '.', ',');
			}else if($_POST['UtilityType'] == "Gas"){
				echo number_format($MinSetup['MinGas'], 2, '.', ',');
			}
		break;

		case 'fncSaveMinimumSetup':
			if($_POST['UtilityType'] == "Electric"){
				$resUpdate = mysql_query("UPDATE mall_setup SET MinElectric = '". $_POST['Setup'] ."' WHERE mall_id = '". $_POST['MallID'] ."';", $connection);
			}else if($_POST['UtilityType'] == "Water"){
				$resUpdate = mysql_query("UPDATE mall_setup SET MinWater = '". $_POST['Setup'] ."' WHERE mall_id = '". $_POST['MallID'] ."';", $connection);
			}else if($_POST['UtilityType'] == "Gas"){
				$resUpdate = mysql_query("UPDATE mall_setup SET MinGas = '". $_POST['Setup'] ."' WHERE mall_id = '". $_POST['MallID'] ."';", $connection);
			}
			if($resUpdate == true){
				echo 1;
			}else{
				echo 2;
			}
		break;

		case 'fncSaveSubUnit':
			$PrevIncrement = mysql_fetch_array(mysql_query("SELECT unitid FROM tblref_unit WHERE mainunit = '". $_POST['UnitID'] ."' ORDER BY id DESC;", $connection));

			$SubUnitSuffix = "";
			if($PrevIncrement[0] == ''){
				$SubUnitSuffix = columnLetter('1');
			}else{
				$arr = explode("-", $PrevIncrement[0]);
				$ForIncrement = $arr[2];
				$ForIncrement++;
				$SubUnitSuffix = $ForIncrement;
			}

			if(SysLeaseSetup('floorandunitmeasurement') == "Area"){
				$getTotalAmount = floatval($_POST['UnitArea']) * floatval($_POST['UnitRate']);
			}else{
				$getTotalAmount = (floatval($_POST['UnitWidth']) * floatval($_POST['UnitLength'])) * floatval($_POST['UnitRate']);
			}

			$getMainUnitInfo = mysql_fetch_array(mysql_query("SELECT buildingname, typeofbusiness, classificationname, mallid, floorid, wingid, classid, depid, catid, amenities FROM tblref_unit WHERE unitid = '". $_POST['UnitID'] ."';", $connection));
 	
			$res = mysql_query("INSERT INTO tblref_unit SET unitid = '". $_POST['UnitID'] ."-". $SubUnitSuffix ."', unitname = '". $_POST['UnitName'] ."', buildingname = '". $getMainUnitInfo['buildingname'] ."', typeofbusiness = '". $getMainUnitInfo['typeofbusiness'] ."', classificationname = '". $getMainUnitInfo['classificationname'] ."', sqmunitsetup = '". floatval($_POST['UnitWidth']) * floatval($_POST['UnitLength']) ."', pricepersqmunitsetup = '". floatval($_POST['UnitRate']) ."', totalamountunitsetup = '". $getTotalAmount ."', status = 'Vacant', dateadded = '". getsysdate() ."', mallid = '". $getMainUnitInfo['mallid'] ."', floorid = '". $getMainUnitInfo['floorid'] ."', wingid = '". $getMainUnitInfo['wingid'] ."', classid = '". $getMainUnitInfo['classid'] ."', depid = '". $getMainUnitInfo['depid'] ."', catid = '". $getMainUnitInfo['catid'] ."', startDate = '". getsysdate() ."', sqm_width = '". floatval($_POST['UnitWidth']) ."', sqm_height = '". floatval($_POST['UnitLength']) ."', area = '". floatval($_POST['UnitArea']) ."', assocdues = '". $getMainUnitInfo['buildingname'] ."', amenities = '". $getMainUnitInfo['amenities'] ."', MainUnit = '". $_POST['UnitID'] ."', BillingSetup = '". $_POST['BillingType'] ."';", $connection);

			echo $SubUnitSuffix;
		break;

		case 'fncDeleteSubUnit2':
			$PrevImage = mysql_fetch_array(mysql_query("SELECT photoext FROM tblref_unit WHERE unitid = '". $_POST['SubUnitID'] ."';", $connection));
			$res = mysql_query("DELETE FROM tblref_unit WHERE unitid = '". $_POST['SubUnitID'] ."';", $connection);
			if($res == true){
				unlink("../../../Mall_Attachments/Unit Image/". $_POST['SubUnitID'] .".". $PrevImage['photoext']);
				echo 1;
			}
		break;

		case 'fncLoadSubUnitList':
			$resSubUnit = mysql_query("SELECT unitid, unitname, sqm_width, sqm_height, area, pricepersqmunitsetup, assocdues, photoext, sqmunitsetup FROM tblref_unit WHERE MainUnit = '". $_POST['UnitID'] ."';", $connection);
			while($rowSubUnit = mysql_fetch_array($resSubUnit)){
				if($rowSubUnit['photoext'] == ""){
					$imgSubUnit = "assets/images/noimage5.png";
				}else{
					if(!file_exists("../../../Mall_Attachments/Unit Image/". $rowSubUnit['unitid'] .".". $rowSubUnit['photoext'])){ 
						$imgSubUnit = "assets/images/noimage5.png";
					}else{
						$imgSubUnit = "../Mall_Attachments/Unit Image/". $rowSubUnit['unitid'] .".". $rowSubUnit['photoext'];
					}
				}
				if(SysLeaseSetup('isAssocDues') == "1"){
					$AssocDues = "<p style='font-size: 14px; margin: 0px !important;'>Rate : ". number_format($rowSubUnit['assocdues'], 2, '.', ',') ."</p>";
				}
				if(SysLeaseSetup('floorandunitmeasurement') == "Area"){
					$Area = floatval($rowSubUnit['area']);
				}else{
					$Area = floatval($rowSubUnit['sqm_width'] * $rowSubUnit['sqm_height']);
				}
				echo 	"<div class='col-md-4'>
							<div class='alert alert-info div_contact_person'>
								<div class='tools tools-left in'>
									<a href='#' title='Edit Photo' class='btnedit' style='float:right;margin-bottom:8px;margin-top:8px;' onclick='fncEditSubUnit(\"". $rowSubUnit["unitid"] ."\", \"". $_POST['UnitID'] ."\")'><i class='ace-icon fa fa-pencil'></i></a>
									<a href='#' title='Remove Photo' class='btndelete' style='float:right;margin-right:5px;margin-bottom:8px;margin-top:8px;' onclick='fncDeleteSubUnit(\"". $rowSubUnit["unitid"] ."\", \"". $_POST['UnitID'] ."\")'><i class='ace-icon fa fa-times red'></i></a>
								</div>
		                        <center>
		                            <div class='image'>
		                                <img id=''+ imgFile +'' class='img-thumbnail imageName form-control' src='". $imgSubUnit ."' style='border: 2px solid #bdc3c7; margin-bottom: 8px;height: 160px;width:90%;'>
		                            </div>
		                        </center>
		                        <p style='font-size: 14px; font-weight: bold;margin: 0px !important;'>Unit Name : ". $rowSubUnit['unitname'] ."</p>
		                        <p style='font-size: 14px; margin: 0px !important;'>Unit Area : ". number_format($Area, 2, '.', ',') ." SQM</p>
		                        <p style='font-size: 14px; margin: 0px !important;'>Rate : ". number_format($rowSubUnit['pricepersqmunitsetup'], 2, '.', ',') ."</p>
		                        ". $AssocDues ."
		                    </div>
		                </div>";
				}
		break;

		case 'fncEditSubUnit':
			$rowSubUnit = mysql_fetch_array(mysql_query("SELECT unitname, sqm_width, sqm_height, area, pricepersqmunitsetup, assocdues, photoext, sqmunitsetup FROM tblref_unit WHERE unitid = '". $_POST['SubUnitID'] ."';", $connection));
			if($rowSubUnit['photoext'] == ""){
				$imgSubUnit = "assets/images/noimage5.png";
			}else{
				if(!file_exists("../../../Mall_Attachments/Unit Image/". $_POST['SubUnitID'] .".". $rowSubUnit['photoext'])){ 
					$imgSubUnit = "assets/images/noimage5.png";
				}else{
					$imgSubUnit = "../Mall_Attachments/Unit Image/". $_POST['SubUnitID'] .".". $rowSubUnit['photoext'];
				}
			}
			echo $imgSubUnit . "|" . $rowSubUnit['unitname'] . "|" . floatval($rowSubUnit['sqm_width']) . "|" . floatval($rowSubUnit['sqm_height']) . "|" . number_format($rowSubUnit['area'], 2, '.', ',') . "|" . number_format($rowSubUnit['pricepersqmunitsetup'], 2, '.', ',') . "|" . number_format($rowSubUnit['assocdues'], 2, '.', ',');
		break;

		case 'fncEditSaveSubUnit':
			if(SysLeaseSetup('floorandunitmeasurement') == "Area"){
				$getTotalAmount = floatval($_POST['UnitArea']) * floatval($_POST['UnitRate']);
			}else{
				$getTotalAmount = (floatval($_POST['UnitWidth']) * floatval($_POST['UnitLength'])) * floatval($_POST['UnitRate']);
			}
			$res = mysql_query("UPDATE tblref_unit SET unitname = '". $_POST['UnitName'] ."', sqmunitsetup = '". floatval($_POST['UnitWidth']) * floatval($_POST['UnitLength']) ."', pricepersqmunitsetup = '". floatval($_POST['UnitRate']) ."', totalamountunitsetup = '". $getTotalAmount ."', sqm_width = '". floatval($_POST['UnitWidth']) ."', sqm_height = '". floatval($_POST['UnitLength']) ."', area = '". floatval($_POST['UnitArea']) ."', assocdues = '". $_POST['UnitAssocDues'] ."' WHERE unitid = '". $_POST['UnitID'] ."';", $connection);
			if($res == true){
				echo 1;
			}else{
				echo 2;
			}
		break;

		case 'fncDownloadTemplate':
			$UnitMeasurement = SysLeaseSetup('floorandunitmeasurement');
			$isAssocDues = SysLeaseSetup('isAssocDues');

			if($UnitMeasurement == 'Area' && $isAssocDues == 1){
				echo "setup/mall_configuration/Setup2.1.xlsx"."|"."MallConfig.xlsx";
			}else if($UnitMeasurement == 'LengthWidth' && $isAssocDues == 1){
				echo "setup/mall_configuration/Setup1.1.xlsx"."|"."MallConfig.xlsx";
			}else if($UnitMeasurement == 'Area' && $isAssocDues == 0){
				echo "setup/mall_configuration/Setup2.2.xlsx"."|"."MallConfig.xlsx";
			}else if($UnitMeasurement == 'LengthWidth' && $isAssocDues == 0){
				echo "setup/mall_configuration/Setup1.2.xlsx"."|"."MallConfig.xlsx";
			}else{
				echo "setup/mall_configuration/Setup2.1.xlsx"."|"."MallConfig.xlsx";
			}
		break;

		case 'fncDisplayMCLogs':
			$res = mysql_query("SELECT TransID, userid, TransDate, TransTime, FileType, MallID FROM tbltrans_mallconf WHERE MallID = '". $_POST['MallID'] ."';", $connection);
			while($row = mysql_fetch_array($res)){
				echo 	"<tr>
							<td>". date('m/d/Y h:i A', strtotime($row['TransDate'] ." ". $row['TransTime'])) ."</td>
							<td>". $row['userid'] ."</td>
							<td><a href='../Mall_Attachments/Mall Config/". $row['MallID'] ."/". $row['TransID'] .".". $row['FileType'] ."' download='MallConfig.xlsx' class='btn btn-info btn-sm btn-round'><i class='fa fa-download'></i> Download</a></td>
						</tr>";
			}
		break;

		case 'fncLoadChargesList':
			$mgaMeron = "";
			$arr = explode("|", $_POST['ids']);
			for ($i=0; $i <= count($arr)-2; $i++) { 
				$mgaMeron .= "'" . $arr[$i] . "'" . ",";
			}

			if($_POST['ids'] != ""){
				$tanong = "AND CHARGE_ID NOT IN (". substr(trim($mgaMeron), 0, -1) .")";
			}else{
				$tanong = "";
			}

			$res = mysql_query("SELECT CHARGE_ID, CHARGE_DESC, RATE_TYPE, RATE, OTHER_REASON, CHARGE_TYPE FROM tblref_refcharges WHERE CHARGE_DESC LIKE '%". $_POST['key'] ."%' ". $tanong ." ORDER BY CHARGE_DESC ASC;", $connection);
			while($row = mysql_fetch_array($res)){

				if($row['RATE_TYPE'] == "Other"){
					$Parusa = $row['OTHER_REASON'];
				}else if($row['RATE_TYPE'] == "Occurence"){
					$Parusa = number_format($row['RATE'], "2", ".", ",") . " " . $row['OTHER_REASON'];
				}else{
					$Parusa = number_format($row['RATE'], "2", ".", ","). " " . $row['RATE_TYPE'];
				}

				echo "	<tr id='TR". $row['CHARGE_ID'] ."'>
							<td class='ChargesID'>". $row['CHARGE_ID'] ."</td>
							<td class='ChargesDesc'>". $row['CHARGE_DESC'] ."</td>
							<td class='ChargeType'>". $row['CHARGE_TYPE'] ."</td>
							<td class='ChargesRate'>". $Parusa ."</td>
						</tr>";
			}
		break;

		case 'fncLoadAddCharges':
			$res = mysql_query("SELECT a.ChargeCode, b.CHARGE_DESC, b.CHARGE_TYPE, b.RATE_TYPE, b.RATE, b.OTHER_REASON FROM tblref_mall_addcharges AS a LEFT JOIN tblref_refcharges AS b ON a.ChargeCode = b.CHARGE_ID WHERE a.ChargeType = 'AddCharge' AND a.MallID = '". $_POST['MallID'] ."';", $connection);
			while($row = mysql_fetch_array($res)){
				if($row['RATE_TYPE'] == "Other"){
					$Parusa = $row['OTHER_REASON'];
				}else if($row['RATE_TYPE'] == "Occurence"){
					$Parusa = number_format($row['RATE'], "2", ".", ",") . " " . $row['OTHER_REASON'];
				}else{
					$Parusa = number_format($row['RATE'], "2", ".", ","). " " . $row['RATE_TYPE'];
				}
				echo 	"<tr id=\"AddChar-". $row['ChargeCode'] ."\">
							<td>". $row['ChargeCode'] ."</td>
							<td>". $row['CHARGE_DESC'] ."</td>
							<td>". $Parusa ."</td>
							<td style='text-align: center;z-index: 0;'><button class='btn btn-xs btn-danger btn-round' onclick='$(\"#AddChar-". $row['ChargeCode'] ."\").remove();'><i class='fa fa-trash-o'></i></button></td>
						</tr>";
			}
		break;

		case 'fncLoadOthCharges':
			$res = mysql_query("SELECT a.ChargeCode, b.CHARGE_DESC, b.CHARGE_TYPE, a.NoofMonths FROM tblref_mall_addcharges AS a LEFT JOIN tblref_refcharges AS b ON a.ChargeCode = b.CHARGE_ID WHERE a.ChargeType = 'OtherCharge' AND a.MallID = '". $_POST['MallID'] ."';", $connection);
			while($row = mysql_fetch_array($res)){
				if($row['RATE_TYPE'] == "Other"){
					$Parusa = $row['OTHER_REASON'];
				}else if($row['RATE_TYPE'] == "Occurence"){
					$Parusa = number_format($row['RATE'], "2", ".", ",") . " " . $row['OTHER_REASON'];
				}else{
					$Parusa = number_format($row['RATE'], "2", ".", ","). " " . $row['RATE_TYPE'];
				}
				echo 	"<tr id=\"AddChar-". $row['ChargeCode'] ."\">
							<td>". $row['ChargeCode'] ."</td>
							<td>". $row['CHARGE_DESC'] ."</td>
							<td>". $Parusa ."</td>
							<td>". $row['NoofMonths'] ."</td>
							<td style='text-align: center;z-index: 0;'><button class='btn btn-xs btn-danger btn-round' onclick='$(\"#AddChar-". $row['ChargeCode'] ."\").remove();'><i class='fa fa-trash-o'></i></button></td>
						</tr>";
			}
		break;

		case 'fncSaveAdditionalCharges':
			$SuccessCount = 0;
			if($_POST['AddCharges'] != ""){
				$DeleteEXisting = mysql_query("DELETE FROM tblref_mall_addcharges WHERE MallID = '".  $_POST['MallID'] ."' AND ChargeType = 'AddCharge';", $connection);
			}
			$arr = explode("|", $_POST['AddCharges']);
			for($a = 0; $a <= COUNT($arr)-2; $a++){
				$res = mysql_query("INSERT INTO tblref_mall_addcharges SET MallID = '". $_POST['MallID'] ."', ChargeCode = '". $arr[$a] ."', ChargeType = 'AddCharge';", $connection);
				$SuccessCount++;
			}
			echo $SuccessCount;
		break;

		case 'fncSaveOtherCharges':
			$SuccessCount = 0;
			if($_POST['OthCharges'] != ""){
				$DeleteEXisting = mysql_query("DELETE FROM tblref_mall_addcharges WHERE MallID = '".  $_POST['MallID'] ."' AND ChargeType = 'OtherCharge';", $connection);
			}
			$arr = explode("|", $_POST['OthCharges']);
			for($a = 0; $a <= COUNT($arr)-2; $a++){
				$arr2 = explode("@", $arr[$a]);
				$res = mysql_query("INSERT INTO tblref_mall_addcharges SET MallID = '". $_POST['MallID'] ."', ChargeCode = '". $arr2[0] ."', NoofMonths = '". $arr2[1] ."', ChargeType = 'OtherCharge';", $connection);
				$SuccessCount++;
			}
			echo $SuccessCount;
		break;
 	}
?>

			