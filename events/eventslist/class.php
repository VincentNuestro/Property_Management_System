<?php  
	session_start();
	include "../../connect.php";
	switch ($_POST['form']) {
		case 'tblListofevents':
			
			$page = $_POST["page"];
			$limit = ($page-1) * 20;
			$sql = "SELECT a.eventid, a.inquiryID, a.eventName,a.compCode, a.userAdded, a.dateAdded,a.proposalNum, a.RevType FROM event_header a, tbltrans_inquiry b WHERE a.inquiryID = b.Inquiry_ID ". getMallAccess("b.Mall_ID", "AND") ."  ORDER BY a.id  DESC LIMIT ".$limit.", 20;";
			$result = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($result)){
				$organizer = mysql_fetch_array(mysql_query("SELECT Company FROM tbltrans_company WHERE CompanyID = '".$row['compCode']."'  ",$connection));
				$created = mysql_fetch_array(mysql_query("SELECT CONCAT(lastname,', ',firstname) as fullname FROM tbluser WHERE userid = '".$row['userAdded']."' ",$connection));
				echo "	<tr>
							<td style='vertical-align: middle;'>". $row['eventid'] ."</td>
							<td style='vertical-align: middle;'>". $row['inquiryID'] ."</td>
							<td style='vertical-align: middle;' >Proposal ". $row['proposalNum'] ."</td>
							<td style='vertical-align: middle;'>". ucfirst($row["eventName"]) ."</td>
							<td style='vertical-align: middle;'>". $organizer["Company"] ."</td>
		                    <td style='vertical-align: middle;'>". $row['RevType'] ."</td>
		                    <td style='vertical-align: middle;'>". $created[0] ."</td>
							<td style='vertical-align: middle;'>".date('m/d/Y',strtotime($row['dateAdded']))."</td>
							<td style='vertical-align: middle;'><div class='btn-group'>";
										echo"<button class='btn btn-sm btn-gray hide  isadmin select-viewevents btn-round' onclick='frmeventformop(\"". $row['inquiryID'] ."\",1,\"".$row['compCode']."\",1,".$row['proposalNum'].")' title='View Event' style='margin: 2px;'><img src='assets/images/ticket.png' style='width: 100%; height: auto;' /></button>";					
									echo"</div>
							</td>
						</tr>";
			}
		break;

		case 'tblListofeventsEntries':
			$page = $_POST['page'];
           	$limit = ($page-1) * 20;
  			$rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM tbltrans_inquiry WHERE ". $StatFilter ." ". $SearchFilter ." ". $DateFilter ." ". getMallAccess("Mall_ID", "AND") .";", $connection));
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

		case 'tblListofeventsPagination':
			$page = $_POST["page"];
			$rowCount = mysql_fetch_row(mysql_query("SELECT COUNT(a.id) FROM event_header a, tbltrans_inquiry b  WHERE  a.inquiryID = b.Inquiry_ID ". getMallAccess("b.Mall_ID", "AND") .";", $connection));
			$rowsperpage = 20;
			$range = 3;
			$totalpages = ceil($rowCount[0] / $rowsperpage);
			$prevpage;
			$nextpage;
			if($page > 1 ){
			   echo "<li style='width:50px !important;' onclick='tblListofeventsPageFunc(1)'><< First</li>";
			   $prevpage = $page - 1;
			   echo "<li style='width:70px !important;' onclick='tblListofeventsPageFunc(". $prevpage .")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   	if (($x > 0) && ($x <= $totalpages)){
			      	if ($x == $page){
		   				echo "<li id='pgLA" . $x . "' class='pgnumLA active' onclick='tblListofeventsPageFunc(" . $x . ",". $x .")'>" . $x . "</li>"; 
		   			}else{
						echo "<li id='pgLA" . $x . "' class='pgnumLA' onclick='tblListofeventsPageFunc(" . $x . ",". $x .")'>" . $x . "</li>"; 
					}
		       	}
		    }
		    if($page < ($totalpages - $range)){ 
		    	echo "<li>...</li>"; 
		    }
		    if($page != $totalpages && $rowCount[0] != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='tblListofeventsPageFunc(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='tblListofeventsPageFunc(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;
		

		case 'saveapprovaleventsFilter':
			

			$filterdates = "";
			if($_POST['Date1']!="" && $_POST['Date2']!=""){
				$filterdates = " AND a.dateAdded BETWEEN '".date('Y-m-d',strtotime($_POST['Date1']))."' AND  '".date('Y-m-d',strtotime($_POST['Date2']))."' ";
			}
			
			$filtersearch = "";
			if($_POST['searchy']!=""){
				$searchyname =  explode("|", $_POST['checked']);
				if($searchyname[0]!=""){
					if($searchyname[0]=='Company'){
						$sname = "c.Company";
					}else{
						$sname = "a.RevType";
					}
					$filtersearch = " AND  ".$sname ." LIKE '%".$_POST['searchy']."%' ";
					if($searchyname[1]!=""){
						$filtersearch = " AND ( c.Company LIKE '%".$_POST['searchy']."%' OR a.RevType LIKE '%".$_POST['searchy']."%') ";
					}
				}	
			}
			
			$page = $_POST["page"];
			$limit = ($page-1) * 20;
			$sql = "SELECT a.eventid, a.inquiryID, a.eventName,a.compCode, a.userAdded, a.dateAdded,a.proposalNum, a.RevType FROM event_header a, tbltrans_inquiry b, tbltrans_company c WHERE a.inquiryID = b.Inquiry_ID AND a.compCode = c.CompanyID ".$filtersearch." ".$filterdates."  ". getMallAccess("b.Mall_ID", "AND") ."  ORDER BY a.id;";
			//echo $sql;
			$result = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($result)){
				$organizer = mysql_fetch_array(mysql_query("SELECT Company FROM tbltrans_company WHERE CompanyID = '".$row['compCode']."'  ",$connection));
				$created = mysql_fetch_array(mysql_query("SELECT CONCAT(lastname,', ',firstname) as fullname FROM tbluser WHERE userid = '".$row['userAdded']."' ",$connection));
				echo "	<tr>
							<td style='vertical-align: middle;'>". $row['eventid'] ."</td>
							<td style='vertical-align: middle;'>". $row['inquiryID'] ."</td>
							<td style='vertical-align: middle;' >Proposal ". $row['proposalNum'] ."</td>
							<td style='vertical-align: middle;'>". ucfirst($row["eventName"]) ."</td>
							<td style='vertical-align: middle;'>". $organizer["Company"] ."</td>
		                    <td style='vertical-align: middle;'>". $row['RevType'] ."</td>
		                    <td style='vertical-align: middle;'>". $created[0] ."</td>
							<td style='vertical-align: middle;'>".date('m/d/Y',strtotime($row['dateAdded']))."</td>
							<td style='vertical-align: middle;'><div class='btn-group'>";
										echo"<button class='btn btn-sm btn-gray hide  isadmin select-viewevents btn-round' onclick='frmeventformop(\"". $row['inquiryID'] ."\",1,\"".$row['compCode']."\",1,".$row['proposalNum'].")' title='View Event' style='margin: 2px;'><img src='assets/images/ticket.png' style='width: 100%; height: auto;' /></button>";					
									echo"</div>
							</td>
						</tr>";
			}			
		break;
	}
?>