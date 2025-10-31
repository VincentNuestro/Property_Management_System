<?php 
session_start();
	include ("../connect.php");
	switch ($_POST['form']) {
		case 'btnSaveLeads':
			$getusernameofthis = mysql_fetch_array(mysql_query("SELECT CONCAT(firstname, ' ', middlename, ' ', lastname) FROM tbluser WHERE userid = '". $_POST['AssignedPerson'] ."'", $connection));
			if($_POST['Position'] != "" && $_POST['Position'] != "null"){
				$Position = $_POST['Position'];
			}else{
				$Position = "";
			}
			if($_POST['Source'] != "" && $_POST['Source'] != "null"){
				$Source = $_POST['Source'];
			}else{
				$Source = "";
			}
			if($_POST['AssignedPerson'] != "" && $_POST['AssignedPerson'] != "null"){
				$AssignedPerson = $_POST['AssignedPerson'];
			}else{
				$AssignedPerson = "";
			}
			if($_POST['leadsID'] == ""){
				$LeadsID = createidno("LEADS", "tbltrans_leads", "leadsID");
				$sql = "INSERT INTO tbltrans_leads SET leadsID = '". $LeadsID ."', LeadsName = '". $_POST['LeadsName'] ."', AssignedPerson = '". $AssignedPerson ."', Position = '". $Position ."', Company_Name = '". $_POST['Company'] ."', First_Name = '". $_POST['FirstName'] ."', Middle_Name = '". $_POST['MiddleName'] ."', Last_Name = '". $_POST['LastName'] ."', Remarks = '". $_POST['Remarks'] ."', Source = '". $Source ."', Full_Name = '". $_POST['FirstName'] . " " . $_POST['MiddleName'] . " " . $_POST['LastName'] ."', TradeID = '". $_POST['TradeID'] ."', CompanyID = '". $_POST['CompanyID'] ."', xDate = '". date('Y-m-d') ."' ";
				$res = mysql_query($sql, $connection);
				if($res == true){

					if($LeadsID != ""){
						$Log .= "Prospect ID : ". $LeadsID . "|";
					}
					if($_POST['LeadsName'] != ""){
						$Log .= "Prospect Name : ". $_POST['LeadsName'] . "|";
					}
					if($_POST['FirstName'] != ""){
						$Log .= "First Name : ". $_POST['FirstName'] . "|";
					}
					if($_POST['MiddleName'] != ""){
						$Log .= "Middle Name : ". $_POST['MiddleName'] . "|";
					}
					if($_POST['LastName'] != ""){
						$Log .= "Last Name : ". $_POST['LastName'] . "|";
					}
					if($_POST['Position'] != "" && $_POST['Position'] != "null"){
						$Log .= "Position : ". $_POST['Position'] . "|";
					}
					if($_POST['Company'] != ""){
						$Log .= "Company : ". $_POST['Company'] . "|";
					}
					if($_POST['Remarks'] != ""){
						$Log .= "Remarks : ". $_POST['Remarks'] . "|";
					}
					if($_POST['Source'] != "" && $_POST['Source'] != "null"){
						$Log .= "Source : ". $_POST['Source'] . "|";
					}
					if($_POST['AssignedPerson'] != "" && $_POST['AssignedPerson'] != "null"){
						$Log .= "Assigned Person : ". $getusernameofthis[0] . "|";
					}

					$arr = explode("|", $_POST['attachment']);
		   			for($a = 0; $a<=count($arr); $a++){
						if($arr[$a] != ""){
							$Log .= "Attachment : ". $arr[$a] . "|";
							$Log2 .= "Attachment : ". $arr[$a] . "|";
						}
					}

					if($Log != ""){
						$tran_logs = create_logs_per_transaction("created a new prospect.", "Prospect Module", $Log, $Log2, "ADD", $LeadsID);
					}
					echo "1|Lead successfully added.|".$LeadsID;

				}else{
					echo "2|Failed to save new lead.";
				}
			}else{
				$prevleadsinfo = mysql_fetch_array(mysql_query("SELECT LeadsName, AssignedPerson, Position, Company_Name, First_Name, Middle_Name, Last_Name, Remarks, Source, Full_Name, TradeID, CompanyID FROM tbltrans_leads WHERE leadsID = '". $_POST['leadsID'] ."'", $connection));

				$sql = "UPDATE tbltrans_leads SET LeadsName = '". $_POST['LeadsName'] ."', AssignedPerson = '". $AssignedPerson ."', Position = '". $Position ."', Company_Name = '". $_POST['Company'] ."', First_Name = '". $_POST['FirstName'] ."', Middle_Name = '". $_POST['MiddleName'] ."', Last_Name = '". $_POST['LastName'] ."', Remarks = '". $_POST['Remarks'] ."', Source = '". $Source ."', Full_Name = '". $_POST['FirstName'] . " " . $_POST['MiddleName'] . " " . $_POST['LastName'] ."', TradeID = '". $_POST['TradeID'] ."', CompanyID = '". $_POST['CompanyID'] ."' WHERE leadsID = '". $_POST['leadsID'] ."' ";
				$res = mysql_query($sql, $connection);
				if($res == true){
					echo "1|Lead successfully updated.|".$_POST['leadsID'];

					$arr = explode("|", $_POST['attachment']);

					if($prevleadsinfo['LeadsName'] == $_POST['LeadsName'] && $prevleadsinfo['AssignedPerson'] == $_POST['AssignedPerson'] && $prevleadsinfo['Position'] == $_POST['Position'] && $prevleadsinfo['Company_Name'] == $_POST['Company'] && $prevleadsinfo['First_Name'] == $_POST['FirstName'] && $prevleadsinfo['Middle_Name'] == $_POST['MiddleName'] && $prevleadsinfo['Last_Name'] == $_POST['LastName'] && $prevleadsinfo['Remarks'] == $_POST['Remarks'] && $prevleadsinfo['Source'] == $_POST['Source'] && $prevleadsinfo['TradeID'] == $_POST['TradeID'] && $prevleadsinfo['CompanyID'] == $_POST['CompanyID'] && COUNT($arr) > 2){
					}else{

						if($prevleadsinfo['LeadsName'] != $_POST['LeadsName']){
							if($prevleadsinfo['LeadsName'] == ""){
								$Log .= "Prospect Name : ". $_POST['LeadsName'] . "|";
							}else{
								$Log .= "Prospect Name : From ". $prevleadsinfo['LeadsName'] ." To ". $_POST['LeadsName'] . "|";
							}
						}
						if($prevleadsinfo['First_Name'] != $_POST['FirstName']){
							if($prevleadsinfo['First_Name'] == ""){
								$Log .= "First Name : ". $_POST['FirstName'] . "|";
							}else{
								$Log .= "First Name : From ". $prevleadsinfo['First_Name'] ." To ". $_POST['FirstName'] . "|";
							}
						}
						if($prevleadsinfo['Middle_Name'] != $_POST['MiddleName']){
							if($prevleadsinfo['MiddleName'] == ""){
								$Log .= "Middle Name : ". $_POST['MiddleName'] . "|";
							}else{
								$Log .= "Middle Name : From ". $prevleadsinfo['Middle_Name'] ." To ". $_POST['MiddleName'] . "|";
							}
						}
						if($prevleadsinfo['Last_Name'] != $_POST['LastName']){
							if($prevleadsinfo['LastName'] == ""){
								$Log .= "Last Name : ". $_POST['LastName'] . "|";
							}else{
								$Log .= "Last Name : From ". $prevleadsinfo['Last_Name'] ." To ". $_POST['LastName'] . "|";
							}
						}
						if($prevleadsinfo['Position'] != $Position){
							if($prevleadsinfo['Position'] == ""){
								$Log .= "Position : ". $_POST['Position'] . "|";
							}else{
								$Log .= "Position : From ". $prevleadsinfo['Position'] ." To ". $_POST['Position'] . "|";
							}
						}
						if($prevleadsinfo['Company_Name'] != $_POST['Company']){
							if($prevleadsinfo['Company'] == ""){
								$Log .= "Company : ". $_POST['Company'] . "|";
							}else{
								$Log .= "Company : From ". $prevleadsinfo['Company_Name'] ." To ". $_POST['Company'] . "|";
							}
						}
						if($prevleadsinfo['Remarks'] != $_POST['Remarks']){
							if($prevleadsinfo['Remarks'] == ""){
								$Log .= "Remarks : ". $_POST['Remarks'] . "|";
							}else{
								$Log .= "Remarks : From ". $prevleadsinfo['Remarks'] ." To ". $_POST['Remarks'] . "|";
							}
						}
						if($prevleadsinfo['Source'] != $Source){
							if($prevleadsinfo['Source'] == ""){
								$Log .= "Source : ". $_POST['Source'] . "|";
							}else{
								$Log .= "Source : From ". $prevleadsinfo['Source'] ." To ". $_POST['Source'] . "|";
							}
						}
						if($prevleadsinfo['AssignedPerson'] != $AssignedPerson){
							if($prevleadsinfo['AssignedPerson'] == ""){
								$Log .= "Assigned Person : ". $getusernameofthis[0] . "|";
							}else{
								$Log .= "Assigned Person : From ". $prevleadsinfo['AssignedPerson'] ." To ". $getusernameofthis[0] . "|";
							}
						}

			   			for($a = 0; $a<=count($arr); $a++){
							if($arr[$a] != ""){
								$Log .= "Attachment : ". $arr[$a] . "|";
								$Log2 .= "Attachment : ". $arr[$a] . "|";
							}
						}

						if($Log != ""){
							$tran_logs = create_logs_per_transaction("updated a prospect.", "Prospect Module", $Log, $Log2 ,"UPDATE", $_POST['leadsID']);
						}
					}
					
				}else{
					echo "2|Failed to update lead.";
				}
			}
		break;

		case 'selectprospect':
			$prospect = mysql_fetch_array(mysql_query("SELECT AssignedPerson, Position, Source, Remarks FROM tbltrans_leads WHERE leadsID = '". $_POST['leadsID'] ."'", $connection));
			echo $prospect[0] . "|" . $prospect[1] . "|" . $prospect[2] . "|" . $prospect[3];
			$resattachment = mysql_query("SELECT filename, filetype FROM tbltrans_leads_attachments WHERE leadsID = '". $_POST['leadsID'] ."' AND ActivityID = '' AND SubLeadsID = '' ", $connection);
			while($rowattachment = mysql_fetch_array($resattachment)){
				$id = trim($_POST['leadsID']);
				$path = "server/Leads/".$id."/Attachment/".$rowattachment[0];
				$arr = explode("/", $rowattachment[1]);
				if($arr[0] != "image" && $arr[0] != ""){
					$btn = "<a href='".$path."' download class='btn btn-xs btn-info'><i class='fa fa-download'></i></a>";
	            }else if($arr[0] == "image"){
	                $btn = "<a class='btn btn-xs btn-info' onclick='viewdocuimgindex(\"". $path ."\");'><i class='fa fa-eye'></i></a>";
	            }else{
	            	$btn = "";
	            }
	            if($btn != ""){
					$leadsattachments .= "	<div class='row form-group'>
												<div class='col-md-1'>".$btn."</div>
												<div class='col-md-11'>
													<p style='font-size:11px;font-weight:normal;font-style:italic;display:inline;'>&nbsp;&nbsp;".$rowattachment[0]."</p>
												</div>
										  	</div>";
				}

			}

				$leadsattachments .= "<div class='col-md-12'><input type='file' class='leadsattachment DisMe' name='leadsattachment1'></div>";
			echo "|".$leadsattachments;
		break;

		case 'AddSubLeads':

			if($_POST['SubLeadsID'] == ""){
				if($_POST['module'] == "awareness"){
					$SubID = createidno("AWA", "tbltrans_leads_awareness", "AwarenessID");
					$sql = "INSERT INTO tbltrans_leads_awareness SET leadsID = '". $_POST['leadsID'] ."', AwarenessID = '". $SubID ."', Subject = '". $_POST['SubLeadsSubject'] ."', Details = '". $_POST['SUbLeadDetails'] ."', xDate = '". date('Y-m-d') ."' ";
					$module = "awareness";
					$module2 = "Awareness";
				}else if($_POST['module']== "referral"){
					$SubID = createidno("REF", "tbltrans_leads_referral", "ReferralID");
					$sql = "INSERT INTO tbltrans_leads_referral SET leadsID = '". $_POST['leadsID'] ."', ReferralID = '". $SubID ."', Subject = '". $_POST['SubLeadsSubject'] ."', Details = '". $_POST['SUbLeadDetails'] ."', xDate = '". date('Y-m-d') ."' ";
					$module = "referral";
					$module2 = "Referral";
				}else if($_POST['module'] == "demo"){
					$SubID = createidno("DEM", "tbltrans_leads_demo", "DemoID");
					$sql = "INSERT INTO tbltrans_leads_demo SET leadsID = '". $_POST['leadsID'] ."', DemoID = '". $SubID ."', Subject = '". $_POST['SubLeadsSubject'] ."', Details = '". $_POST['SUbLeadDetails'] ."', xDate = '". date('Y-m-d') ."' ";
					$module = "demo";
					$module2 = "Demo";
				}else if($_POST['module'] == "closingmeeting"){
					$SubID = createidno("CLM", "tbltrans_leads_closingmeeting", "ClosingMeetingID");
					$sql = "INSERT INTO tbltrans_leads_closingmeeting SET leadsID = '". $_POST['leadsID'] ."', ClosingMeetingID = '". $SubID ."', Subject = '". $_POST['SubLeadsSubject'] ."', Details = '". $_POST['SUbLeadDetails'] ."', xDate = '". date('Y-m-d') ."' ";
					$module = "closing meeting";
					$module2 = "Closing Meeting";
				}else if($_POST['module'] == "contractsigning"){
					$SubID = createidno("COS", "tbltrans_leads_contractsigning", "ContractSigningID");
					$sql = "INSERT INTO tbltrans_leads_contractsigning SET leadsID = '". $_POST['leadsID'] ."', ContractSigningID = '". $SubID ."', Subject = '". $_POST['SubLeadsSubject'] ."', Details = '". $_POST['SUbLeadDetails'] ."', xDate = '". date('Y-m-d') ."' ";
					$module = "contract signing";
					$module2 = "Contract Signing";
				}
				$res = mysql_query($sql, $connection);
				if($res == true){
					echo $SubID;

					if($_POST['leadsID'] != ""){
						$Log .= "Prospect ID : ". $_POST['leadsID'] . "|";
					}
					if($_POST['LeadsName'] != ""){
						$Log .= "Prospect Name : ". $_POST['LeadsName'] . "|";
					}
					if($SubID != ""){
						$Log .= $module2 ." ID : ". $SubID . "|";
					}
					if($_POST['SubLeadsSubject'] != ""){
						$Log .= $module2 ." Subject : ". $_POST['SubLeadsSubject'] . "|";
					}
					if($_POST['SUbLeadDetails'] != ""){
						$Log .= $module2 ." Details : ". $_POST['SUbLeadDetails'] . "|";
					}

					$arr = explode("|", $_POST['attachment']);
		   			for($a = 0; $a<=count($arr); $a++){
						if($arr[$a] != ""){
							$Log .= "Attachment : ". $arr[$a] . "|";
							$Log2 .= "Attachment : ". $arr[$a] . "|";
						}
					}

					if($Log != ""){
						$tran_logs = create_logs_per_transaction("created a new ". $module ." record.", $module2 . " Module", $Log, $Log2, "ADD", $_POST['leadsID']);
					}
				}
			}else{
				$PrevLeads = mysql_fetch_array(mysql_query("SELECT LeadsName FROM tbltrans_leads WHERE leadsID = '". $_POST['leadsID'] ."'", $connection));
				if($_POST['module'] == "awareness"){
					$prev = mysql_fetch_array(mysql_query("SELECT leadsID, Subject, Details FROM tbltrans_leads_awareness WHERE AwarenessID = '". $_POST['SubLeadsID'] ."'", $connection));
					$sql = "UPDATE tbltrans_leads_awareness SET leadsID = '". $_POST['leadsID'] ."', Subject = '". $_POST['SubLeadsSubject'] ."', Details = '". $_POST['SUbLeadDetails'] ."' WHERE AwarenessID = '". $_POST['SubLeadsID'] ."' ";
					$module = "an awareness";
					$module2 = "Awareness";
				}else if($_POST['module']== "referral"){
					$prev = mysql_fetch_array(mysql_query("SELECT leadsID, Subject, Details FROM tbltrans_leads_referral WHERE ReferralID = '". $_POST['SubLeadsID'] ."'", $connection));
					$sql = "UPDATE tbltrans_leads_referral SET leadsID = '". $_POST['leadsID'] ."', Subject = '". $_POST['SubLeadsSubject'] ."', Details = '". $_POST['SUbLeadDetails'] ."' WHERE ReferralID = '". $_POST['SubLeadsID'] ."' ";
					$module = "a referral";
					$module2 = "Referral";
				}else if($_POST['module'] == "demo"){
					$prev = mysql_fetch_array(mysql_query("SELECT leadsID, Subject, Details FROM tbltrans_leads_demo WHERE DemoID = '". $_POST['SubLeadsID'] ."'", $connection));
					$sql = "UPDATE tbltrans_leads_demo SET leadsID = '". $_POST['leadsID'] ."', Subject = '". $_POST['SubLeadsSubject'] ."', Details = '". $_POST['SUbLeadDetails'] ."' WHERE DemoID = '". $_POST['SubLeadsID'] ."' ";
					$module = "a demo";
					$module2 = "Demo";
				}else if($_POST['module'] == "closingmeeting"){
					$prev = mysql_fetch_array(mysql_query("SELECT leadsID, Subject, Details FROM tbltrans_leads_closingmeeting WHERE ClosingMeetingID = '". $_POST['SubLeadsID'] ."'", $connection));
					$sql = "UPDATE tbltrans_leads_closingmeeting SET leadsID = '". $_POST['leadsID'] ."', Subject = '". $_POST['SubLeadsSubject'] ."', Details = '". $_POST['SUbLeadDetails'] ."' WHERE ClosingMeetingID = '". $_POST['SubLeadsID'] ."' ";
					$module = "a closing meeting";
					$module2 = "Closing Meeting";
				}else if($_POST['module'] == "contractsigning"){
					$prev = mysql_fetch_array(mysql_query("SELECT leadsID, Subject, Details FROM tbltrans_leads_contractsigning WHERE ContractSigningID = '". $_POST['SubLeadsID'] ."'", $connection));
					$sql = "UPDATE tbltrans_leads_contractsigning SET leadsID = '". $_POST['leadsID'] ."', Subject = '". $_POST['SubLeadsSubject'] ."', Details = '". $_POST['SUbLeadDetails'] ."' WHERE ContractSigningID = '". $_POST['SubLeadsID'] ."' ";
					$module = "a contract signing";
					$module2 = "Contract Signing";
				}
				$res = mysql_query($sql, $connection);
				if($res == true){
					echo $_POST['SubLeadsID'];

					$arr = explode("|", $_POST['attachment']);
					if($prev['leadsID'] == $_POST['leadsID'] && $prev['Subject'] == $_POST['SubLeadsSubject'] && $prev['Details'] == $_POST['SUbLeadDetails'] && COUNT($arr) > 2){
					}else{

						if($prev['leadsID'] != $_POST['leadsID']){
							if($prev['leadsID'] == ""){
								$Log .= "Prospect ID : ". $_POST['leadsID'] . "|";
							}else{
								$Log .= "Prospect ID : From ". $prev['leadsID'] ." To ". $_POST['leadsID'] . "|";
							}
						}
						if($PrevLeads['LeadsName'] != $_POST['LeadsName']){
							if($PrevLeads['LeadsName'] == ""){
								$Log .= "Prospect Name : ". $_POST['LeadsName'] . "|";
							}else{
								$Log .= "Prospect Name : From ". $PrevLeads['LeadsName'] ." To ". $_POST['LeadsName'] . "|";
							}
						}
						if($prev['Subject'] != $_POST['SubLeadsSubject']){
							if($prev['Subject'] == ""){
								$Log .= $module2 ." Subject : ". $_POST['SubLeadsSubject'] . "|";
							}else{
								$Log .= $module2 ." Subject : From ". $prev['Subject'] ." To ". $_POST['SubLeadsSubject'] . "|";
							}
						}
						if($prev['Details'] != $_POST['SUbLeadDetails']){
							if($prev['Details'] == ""){
								$Log .= $module2 ." Details : ". $_POST['SUbLeadDetails'] . "|";
							}else{
								$Log .= $module2 ." Details : From ". $prev['Details'] ." To ". $_POST['SUbLeadDetails'] . "|";
							}
						}

			   			for($a = 0; $a<=count($arr); $a++){
							if($arr[$a] != ""){
								$Log .= "Attachment : ". $arr[$a] . "|";
								$Log2 .= "Attachment : ". $arr[$a] . "|";
							}
						}

						if($Log != ""){
							$tran_logs = create_logs_per_transaction("updated ". $module ." record.", $module2 . " Module", $Log, $Log2, "ADD", $_POST['leadsID']);
						}
					}
				}
			}
		break;


		case 'editleadsinfo':
			$leadsinfo = mysql_fetch_array(mysql_query("SELECT LeadsName, AssignedPerson, Position, Company_Name, First_Name, Middle_Name, Last_Name, Remarks, Source FROM tbltrans_leads WHERE leadsID = '". $_POST['leadsid'] ."'", $connection));

			$resattachment = mysql_query("SELECT filename, filetype FROM tbltrans_leads_attachments WHERE leadsID = '". $_POST['leadsid'] ."' AND ActivityID = '' AND SubLeadsID = '' ", $connection);
			while($rowattachment = mysql_fetch_array($resattachment)){
				$id = trim($_POST['leadsid']);
				$path = "server/Leads/".$id."/Attachment/".$rowattachment[0];
				$arr = explode("/", $rowattachment[1]);
				if($arr[0] != "image" && $arr[0] != ""){
					$btn = "<a href='".$path."' download class='btn btn-xs btn-info'><i class='fa fa-download'></i></a>";
	            }else if($arr[0] == "image"){
	                $btn = "<a class='btn btn-xs btn-info' onclick='viewdocuimgindex(\"". $path ."\");'><i class='fa fa-eye'></i></a>";
	            }else{
	            	$btn = "";
	            }

	            if($btn != ""){
					$leadsattachments .= "	<div class='row form-group'>
												<div class='col-md-1'>".$btn."</div>
												<div class='col-md-11'>
													<p style='font-size:11px;font-weight:normal;font-style:italic;display:inline;'>&nbsp;&nbsp;".$rowattachment[0]."</p>
												</div>
										  	</div>";
	            }
			}

				$leadsattachments .= "<div class='col-md-12'><input type='file' class='leadsattachment DisMe' name='leadsattachment1'></div>";


			echo $leadsinfo['LeadsName'] . "|" . $leadsinfo['Company_Name'] . "|" . $leadsinfo['Position'] . "|" . $leadsinfo['AssignedPerson'] . "|" . $leadsinfo['First_Name'] . "|" . $leadsinfo['Middle_Name'] . "|" . $leadsinfo['Last_Name'] . "|" . $leadsinfo['Remarks'] . "|" . $leadsinfo['Source'] . "|" . $leadsattachments;
		break;

		case 'EditSubLeads':
			$SubLeadsInfo = mysql_fetch_array(mysql_query("SELECT Subject, Details FROM tbltrans_leads_". $_POST['module'] ." WHERE ". $_POST['module'].'ID'. " = '". $_POST['SubLeadsID'] ."'", $connection));

			echo $SubLeadsInfo['Subject'] . "|" . $SubLeadsInfo['Details'];

			$resattachment = mysql_query("SELECT filename, filetype FROM tbltrans_leads_attachments WHERE leadsID = '". $_POST['leadsid'] ."' AND ActivityID = '' AND SubLeadsID = '". $_POST['SubLeadsID'] ."'", $connection);
			while($rowattachment = mysql_fetch_array($resattachment)){
				$id = trim($_POST['leadsid']);
				$path = "server/Leads/".$id."/".$_POST['SubLeadsID']."/".$rowattachment[0];
				$arr = explode("/", $rowattachment[1]);
				if($arr[0] != "image" && $arr[0] != ""){
					$btn = "<a href='".$path."' download class='btn btn-xs btn-info'><i class='fa fa-download'></i></a>";
	            }else if($arr[0] == "image"){
	                $btn = "<a class='btn btn-xs btn-info' onclick='viewdocuimgindex(\"". $path ."\");'><i class='fa fa-eye'></i></a>";
	            }else{
	            	$btn = "";
	            }

	            if($btn != ""){
					$leadsattachments .= "	<div class='row form-group'>
												<div class='col-md-1'>".$btn."</div>
												<div class='col-md-11'>
													<p style='font-size:11px;font-weight:normal;font-style:italic;display:inline;'>&nbsp;&nbsp;".$rowattachment[0]."</p>
												</div>
										  	</div>";
	            }
			}

				$leadsattachments .= "<div class='col-md-12'><input type='file' class='leadsattachment DisMe' name='leadsattachment1'></div>";
			echo "|".$leadsattachments;
		break;

		case 'tblAwarenessList':
			$res = mysql_query("SELECT xDATETIME, Subject, Details, AwarenessID FROM tbltrans_leads_awareness WHERE leadsID = '". $_POST['leadsid'] ."'", $connection);
			while($row = mysql_fetch_array($res)){
				echo 	"<tr>
							<td width='12%'>". date('m/d/Y', strtotime($row[0])) ."</td>
							<td width='28%'>". $row[1] ."</td>
							<td width='40%'>". $row[2] ."</td>
							<td width='20%'>";
								$resattachment = mysql_query("SELECT filename, filetype FROM tbltrans_leads_attachments WHERE leadsID = '". $_POST['leadsid'] ."' AND SubLeadsID = '". $row['AwarenessID'] ."'", $connection);
								while($rowattachment = mysql_fetch_array($resattachment)){
									$id = trim($_POST['leadsid']);
									$path = "server/Leads/".$id."/".$row['AwarenessID']."/".$rowattachment[0];
									$arr = explode("/", $rowattachment[1]);
									if($arr[0] != "image" && $arr[0] != ""){
										$btn = "<a href='".$path."' download class='btn btn-xs btn-info' style='margin: 2px;z-index: 0;'><i class='fa fa-download'></i></a>&nbsp;";
						            }else if($arr[0] == "image"){
						                $btn = "<a class='btn btn-xs btn-info' onclick='viewdocuimgindex(\"". $path ."\");' style='margin: 2px;z-index: 0;'><i class='fa fa-eye'></i></a>&nbsp;";
						            }else{
						            	$btn = "";
						            }

						            if($btn != ""){
										echo $btn.$rowattachment[0]."<br/>";
						            }
								}

				echo 		"</td>
						</tr>";
			}
		break;

		case 'tblReferralList':
			$res = mysql_query("SELECT xDATETIME, Subject, Details, ReferralID FROM tbltrans_leads_referral WHERE leadsID = '". $_POST['leadsid'] ."'", $connection);
			while($row = mysql_fetch_array($res)){
				echo 	"<tr>
							<td width='12%'>". date('m/d/Y', strtotime($row[0])) ."</td>
							<td width='28%'>". $row[1] ."</td>
							<td width='40%'>". $row[2] ."</td>
							<td width='20%'>";
								$resattachment = mysql_query("SELECT filename, filetype FROM tbltrans_leads_attachments WHERE leadsID = '". $_POST['leadsid'] ."' AND SubLeadsID = '". $row['ReferralID'] ."'", $connection);
								while($rowattachment = mysql_fetch_array($resattachment)){
									$id = trim($_POST['leadsid']);
									$path = "server/Leads/".$id."/".$row['ReferralID']."/".$rowattachment[0];
									$arr = explode("/", $rowattachment[1]);
									if($arr[0] != "image" && $arr[0] != ""){
										$btn = "<a href='".$path."' download class='btn btn-xs btn-info' style='margin: 2px;z-index: 0;'><i class='fa fa-download'></i></a>&nbsp;";
						            }else if($arr[0] == "image"){
						                $btn = "<a class='btn btn-xs btn-info' onclick='viewdocuimgindex(\"". $path ."\");' style='margin: 2px;z-index: 0;'><i class='fa fa-eye'></i></a>&nbsp;";
						            }else{
						            	$btn = "";
						            }

						            if($btn != ""){
										echo $btn.$rowattachment[0]."<br/>";
						            }
								}

				echo 		"</td>
						</tr>";
			}
		break;

		case 'tblDemoList':
			$res = mysql_query("SELECT xDATETIME, Subject, Details, DemoID FROM tbltrans_leads_demo WHERE leadsID = '". $_POST['leadsid'] ."'", $connection);
			while($row = mysql_fetch_array($res)){
				echo 	"<tr>
							<td width='12%'>". date('m/d/Y', strtotime($row[0])) ."</td>
							<td width='28%'>". $row[1] ."</td>
							<td width='40%'>". $row[2] ."</td>
							<td width='20%'>";
								$resattachment = mysql_query("SELECT filename, filetype FROM tbltrans_leads_attachments WHERE leadsID = '". $_POST['leadsid'] ."' AND SubLeadsID = '". $row['DemoID'] ."'", $connection);
								while($rowattachment = mysql_fetch_array($resattachment)){
									$id = trim($_POST['leadsid']);
									$path = "server/Leads/".$id."/".$row['DemoID']."/".$rowattachment[0];
									$arr = explode("/", $rowattachment[1]);
									if($arr[0] != "image" && $arr[0] != ""){
										$btn = "<a href='".$path."' download class='btn btn-xs btn-info' style='margin: 2px;z-index: 0;'><i class='fa fa-download'></i></a>&nbsp;";
						            }else if($arr[0] == "image"){
						                $btn = "<a class='btn btn-xs btn-info' onclick='viewdocuimgindex(\"". $path ."\");' style='margin: 2px;z-index: 0;'><i class='fa fa-eye'></i></a>&nbsp;";
						            }else{
						            	$btn = "";
						            }

						            if($btn != ""){
										echo $btn.$rowattachment[0]."<br/>";
						            }
								}

				echo 		"</td>
						</tr>";
			}
		break;

		case 'tblCLMList':
			$res = mysql_query("SELECT xDATETIME, Subject, Details, ClosingMeetingID FROM tbltrans_leads_closingmeeting WHERE leadsID = '". $_POST['leadsid'] ."'", $connection);
			while($row = mysql_fetch_array($res)){
				echo 	"<tr>
							<td width='12%'>". date('m/d/Y', strtotime($row[0])) ."</td>
							<td width='28%'>". $row[1] ."</td>
							<td width='40%'>". $row[2] ."</td>
							<td width='20%'>";
								$resattachment = mysql_query("SELECT filename, filetype FROM tbltrans_leads_attachments WHERE leadsID = '". $_POST['leadsid'] ."' AND SubLeadsID = '". $row['ClosingMeetingID'] ."'", $connection);
								while($rowattachment = mysql_fetch_array($resattachment)){
									$id = trim($_POST['leadsid']);
									$path = "server/Leads/".$id."/".$row['ClosingMeetingID']."/".$rowattachment[0];
									$arr = explode("/", $rowattachment[1]);
									if($arr[0] != "image" && $arr[0] != ""){
										$btn = "<a href='".$path."' download class='btn btn-xs btn-info' style='margin: 2px;z-index: 0;'><i class='fa fa-download'></i></a>&nbsp;";
						            }else if($arr[0] == "image"){
						                $btn = "<a class='btn btn-xs btn-info' onclick='viewdocuimgindex(\"". $path ."\");' style='margin: 2px;z-index: 0;'><i class='fa fa-eye'></i></a>&nbsp;";
						            }else{
						            	$btn = "";
						            }

						            if($btn != ""){
										echo $btn.$rowattachment[0]."<br/>";
						            }
								}

				echo 		"</td>
						</tr>";
			}
		break;

		case 'tblCOSList':
			$res = mysql_query("SELECT xDATETIME, Subject, Details, ContractSigningID FROM tbltrans_leads_contractsigning WHERE leadsID = '". $_POST['leadsid'] ."'", $connection);
			while($row = mysql_fetch_array($res)){
				echo 	"<tr>
							<td width='12%'>". date('m/d/Y', strtotime($row[0])) ."</td>
							<td width='28%'>". $row[1] ."</td>
							<td width='40%'>". $row[2] ."</td>
							<td width='20%'>";
								$resattachment = mysql_query("SELECT filename, filetype FROM tbltrans_leads_attachments WHERE leadsID = '". $_POST['leadsid'] ."' AND SubLeadsID = '". $row['ContractSigningID'] ."'", $connection);
								while($rowattachment = mysql_fetch_array($resattachment)){
									$id = trim($_POST['leadsid']);
									$path = "server/Leads/".$id."/".$row['ContractSigningID']."/".$rowattachment[0];
									$arr = explode("/", $rowattachment[1]);
									if($arr[0] != "image" && $arr[0] != ""){
										$btn = "<a href='".$path."' download class='btn btn-xs btn-info' style='margin: 2px;z-index: 0;'><i class='fa fa-download'></i></a>&nbsp;";
						            }else if($arr[0] == "image"){
						                $btn = "<a class='btn btn-xs btn-info' onclick='viewdocuimgindex(\"". $path ."\");' style='margin: 2px;z-index: 0;'><i class='fa fa-eye'></i></a>&nbsp;";
						            }else{
						            	$btn = "";
						            }

						            if($btn != ""){
										echo $btn.$rowattachment[0]."<br/>";
						            }
								}

				echo 		"</td>
						</tr>";
			}
		break;
	}
?>