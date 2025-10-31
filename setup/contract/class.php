<?php
	session_start();
	include("../../connect.php");
	switch ($_POST['form']){
		case 'fncLayoutList':
			$res = mysql_query("SELECT LCode, LDesc, LContent, id, LType FROM tblref_contract WHERE LCode LIKE '%". $_POST['key'] ."%' OR LDesc LIKE '%". $_POST['key'] ."%';", $connection);
			while($row = mysql_fetch_array($res)){
				echo 	"<tr>
							<td>". $row['LType'] ."</td>
							<td>". $row['LCode'] ."</td>
							<td>". $row['LDesc'] ."</td>
							<td style='text-align: center; z-index: 0;' class='hide isadmin select-editreportTempaltes select-deletereportTempaltes'>
								<div class='btn-group'>
									<button class='btn btn-sm btn-info btn-round isadmin hide select-editreportTempaltes' onclick='fncEditLayout(\"". $row["id"] ."\")' title='Edit Contract Layout' style='margin: 2px;'><img src='assets/images/resume.png' style='width: 100%; height: auto;' /></button>
									<button class='btn btn-danger btn-sm btn-round isadmin hide select-deletereportTempaltes' title='Delete Layout' onclick='fncDeleteLayout(\"". $row['id'] ."\")' style='margin: 2px;'><img src='assets/images/remove.png' style='width: 100%; height: auto;' /></button>
								</div>
							</td>
						</tr>";
			}
		break;

		case 'fncCLayoutEntries':
  			$rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM tblref_contract WHERE LCode LIKE '%". $_POST['key'] ."%' OR LDesc LIKE '%". $_POST['key'] ."%';", $connection));
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

		case "fncCLayoutPagination":
			$page = $_POST["page"];
			$rowCount = mysql_fetch_row(mysql_query("SELECT COUNT(id) FROM tblref_contract WHERE LCode LIKE '%". $_POST['key'] ."%' OR LDesc LIKE '%". $_POST['key'] ."%';", $connection));
			$num = $rowCount[0];
			$rowsperpage = 20;
			$range = 3;
			$totalpages = ceil($num / $rowsperpage);
			$prevpage;
			$nextpage;
			if($page > 1 ){
			   	echo "<li style='width:50px !important;' onclick='ClickPaginationFunc(1)'><< First</li>";
			   	$prevpage = $page - 1;
			   	echo "<li style='width:70px !important;' onclick='ClickPaginationFunc(". $prevpage .")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   	if (($x > 0) && ($x <= $totalpages)){
			      	if ($x == $page){
		   				echo "<li id='pgCLayout" . $x . "' class='pgnumCLayout active' onclick='ClickPaginationFunc(" . $x . ",". $x .")'>" . $x . "</li>";
		   			}else{
						echo "<li id='pgCLayout" . $x . "' class='pgnumCLayout' onclick='ClickPaginationFunc(" . $x . ",". $x .")'>" . $x . "</li>"; 
					}
		       	}
		    }
		    if($page < ($totalpages - $range)){ 
		    	echo "<li>...</li>"; 
		    }
		    if ($page != $totalpages && $num != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='ClickPaginationFunc(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='ClickPaginationFunc(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'fncSaveLayout':
			if($_POST['LayoutID'] == ''){
				$res = mysql_query("INSERT INTO tblref_contract SET LContent = '". $_POST['ckEditorData'] ."', LCode = '". $_POST['Code'] ."', LDesc = '". $_POST['Desc'] ."', LType = '". $_POST['ContractType'] ."';", $connection);
			}else{
				$res = mysql_query("UPDATE tblref_contract SET LContent = '". $_POST['ckEditorData'] ."', LCode = '". $_POST['Code'] ."', LDesc = '". $_POST['Desc'] ."', LType = '". $_POST['ContractType'] ."' WHERE id = '". $_POST['LayoutID'] ."';", $connection);
			}
			if($res == true){
				echo 1;
			}else{
				echo 2;
			}
		break;

		case 'fncEditLayout':
			$return_arr = array();
			$LayoutInfo = mysql_fetch_array(mysql_query("SELECT LCode, LDesc, LContent, LType FROM tblref_contract WHERE id = '". $_POST['id'] ."';", $connection));
			array_push($return_arr, $LayoutInfo['LCode'], $LayoutInfo['LDesc'], htmlspecialchars_decode($LayoutInfo['LContent']), $LayoutInfo['LType']);

			echo json_encode($return_arr);
		break;

		case 'fncDeleteLayout':
			$res = mysql_query("DELETE FROM tblref_contract WHERE id = '". $_POST['id'] ."';", $connection);
			if($res == true){
				echo 1;
			}else{
				echo 2;
			}
		break;
	}
?>