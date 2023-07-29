<?php
	session_start();
	include "../../../connect.php";
	switch ($_POST['form']) {
		case 'showRequestCategory':
			echo "<option> -- Select Category -- </option>";
			$res = mysql_query("SELECT reqCatCode, reqCatDesc FROM tblreqcategory", $connection);
			while($row = mysql_fetch_array($res)){
				echo "<option value='".$row[0]."'>".$row[1]."</option>";
			}	
		break;

		case 'displayRequestTags':
			$page = $_POST['page'];
			$limit = ($page-1) * 20;


/*			$res = mysql_query("SELECT  reqTagCode, reqCatCode, reqTagDesc, reqTagAppr, id FROM tblreqtags WHERE reqTagDesc LIKE '%". $_POST['key'] ."%' OR reqTagCode LIKE '%". $_POST['key'] ."%' OR reqCatCode LIKE '%". $_POST['key'] ."%' ORDER BY reqTagCode ASC LIMIT ".$limit.",20;", $connection);*/

			$res = mysql_query("SELECT tblreqtags.reqTagCode, tblreqtags.reqCatCode, tblreqtags.reqTagDesc, tblreqtags.reqTagAppr, tblreqtags.id, tblreqcategory.reqCatDesc FROM tblreqtags LEFT JOIN tblreqcategory ON tblreqtags.reqCatCode =  tblreqcategory.reqCatCode WHERE tblreqtags.reqTagDesc LIKE '%". $_POST['key'] ."%' OR tblreqtags.reqTagCode LIKE '%". $_POST['key'] ."%' OR tblreqtags.reqCatCode LIKE '%". $_POST['key']."%' OR tblreqcategory.reqCatDesc LIKE '%". $_POST['key'] ."%' GROUP BY tblreqtags.reqTagCode ORDER BY ". $_POST['RequesttagSortBy'] ." ". $_POST['RequesttagSortType'] ." LIMIT ". $limit .",20;", $connection);

			while($row = mysql_fetch_array($res)){
				?>
					<tr id="<?php echo $row['id']; ?>">
						<td><?php echo $row['reqTagCode']; ?></td>
						<td><?php echo $row['reqCatDesc']; ?></td>
						<td><?php echo utf8_encode($row['reqTagDesc']); ?></td>
						<td>
							<?php 
							if($row['reqTagAppr'] == 1){
								echo '<font color="#299528">YES</font>'; 
							} else {
								echo '<font color="red">NO</font>'; 
							} ?>
						</td>												
					</tr>
				<?php
			}
		break;

		case 'loadEntriesRequestTags':
			if($_POST["page"] == ""){
	            $page = 1;
	        }else{
	            $page = $_POST["page"];
	        }
    		$limit = ($page-1) * 20;
            $rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(reqTagCode) FROM tblreqtags WHERE reqTagDesc LIKE '%". $_POST['key'] ."%' OR reqTagCode LIKE '%". $_POST['key'] ."%' OR reqCatCode LIKE '%". $_POST['key'] ."%';", $connection));
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

		case "loadPageRequestTags":
			$page = $_POST["page"];
			$rowCount = mysql_fetch_row(mysql_query("SELECT COUNT(reqTagCode) FROM tblreqtags WHERE reqTagDesc LIKE '%". $_POST['key'] ."%' OR reqTagCode LIKE '%". $_POST['key'] ."%' OR reqCatCode LIKE '%". $_POST['key'] ."%';", $connection));
			$rowsperpage = 20;
			$range = 1;
			$totalpages = ceil($rowCount[0] / $rowsperpage);
			$prevpage;
			$nextpage;

			if($page > 1 ){
			   	echo "<li style='width:50px !important;' onclick='fncPageRequestTags(1)'><< First</li>";
			   	$prevpage = $page - 1;
			   	echo "<li style='width:70px !important;' onclick='fncPageRequestTags(". $prevpage .")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if(($x > 0) && ($x <= $totalpages)){
    			    if($x == $page){
                        echo "<li id='pgRequestTags" . $x . "' class='pgnumRequestTags active' onclick='fncPageRequestTags(" . $x . ",". $x .")'>" . $x . "</li>";
                    }else{
    			        echo "<li id='pgRequestTags" . $x . "' class='pgnumRequestTags' onclick='fncPageRequestTags(" . $x . ",". $x .")'>" . $x . "</li>";
                    }
		       	}
		    }
		    if($page < ($totalpages - $range)){
                echo "<li>...</li>";
            }
		    if($page != $totalpages && $rowCount[0] != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='fncPageRequestTags(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='fncPageRequestTags(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'selectedRequestTags':
			$row = mysql_fetch_array(mysql_query("SELECT  reqTagCode, reqCatCode, reqTagDesc, reqTagAppr, id FROM tblreqtags WHERE id = '". $_POST['id'] ."';", $connection));
			echo $row[0] . "|" . $row[1] . "|" . utf8_encode($row[2]) . "|" . $row[3] . "|". $row[4];
		break;

		case 'saveRequestTags':
			$arrHeader = ["Request Tags Code","Request Category Code", "Request Tags Description", "Requires Approval"];
			$arrValue = [$_POST['RequestTagsCode'], $_POST['RequestTagsCat'], $_POST['RequestTagsDesc'], $_POST['RequestTagsAppr']];
			$Logs = createXinfo("INSERT", $arrHeader, "", $arrValue, "", "", "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("added a new Tag referential.", "Referential Module", $Logs, "" ,"ADD", "");
			}
			$rowcheck = mysql_fetch_array(mysql_query("SELECT reqTagDesc FROM tblreqtags WHERE reqTagCode = '". $_POST['RequestTagsCode'] ."';", $connection));
			if($rowcheck[0] == ""){
				$res = mysql_query("INSERT INTO tblreqtags SET reqTagCode = '". mysql_escape_string(strtoupper($_POST['RequestTagsCode'])) ."', reqTagDesc = '". mysql_escape_string(ucfirst($_POST['RequestTagsDesc'])) ."', reqCatCode = '". $_POST['RequestTagsCat'] ."', reqTagAppr = '". $_POST['RequestTagsAppr'] ."';", $connection);
				if($res == true){
					echo 1;
				}
			}else{
				echo "Tag Code already exist.";
			}
		break;

		case 'clickUpdateRequestTags':
			$row = mysql_fetch_array(mysql_query("SELECT COUNT(reqTagCode) FROM tblreqtags WHERE reqTagCode = '". $_POST['RequestTagsCode'] ."';", $connection));
			if($row[0] >= 1){
				echo 1;
			}else{
				echo 0;
			}
		break;


		case 'updateRequestTags':
			$arrHeader = ["Request Tags Code","Request Category Code", "Request Tags Description", "Requires Approval"];
			$arrFields = [ "reqTagCode", "reqCatCode", "reqTagDesc", "reqTagAppr"];
			$arrValue = [$_POST['RequestTagsCode'], $_POST['RequestTagsCat'], $_POST['RequestTagsDesc'], $_POST['RequestTagsAppr']];
			$Logs = createXinfo("UPDATE", $arrHeader, $arrFields, $arrValue, "tblreqtags", $_POST['hiddenRequestTagsid'], "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("modified an Request Tags referential.", "Referential Module", $Logs, "" ,"UPDATE", "1");
			}
			$CurrentRef = mysql_fetch_array(mysql_query("SELECT reqTagCode, reqCatCode, reqTagDesc, reqTagAppr FROM tblreqtags WHERE id = '". $_POST['hiddenRequestTagsid'] ."';", $connection));
			$res = mysql_query("UPDATE tblreqtags SET reqTagCode = '". mysql_escape_string(strtoupper($_POST['RequestTagsCode'])) ."', reqCatCode = '". $_POST['RequestTagsCat'] ."', reqTagDesc = '". mysql_escape_string(ucfirst($_POST['RequestTagsDesc'])) ."' , reqTagAppr = '". $_POST['RequestTagsAppr'] ."' WHERE id = '". $_POST['hiddenRequestTagsid'] ."';", $connection);
			if($res == true){
				echo 1;
			}
		break;

		case 'deleteRequestTags':
			$arrHeader = ["Request Tags Code","Request Category Code", "Request Tags Description", "Requires Approval"];
			$arrFields = [ "reqTagCode", "reqCatCode", "reqTagDesc", "reqTagAppr"];
			$Logs = createXinfo("DELETE", $arrHeader, $arrFields, "", "tblreqtags", $_POST['RequestTagsCode'], "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("deleted an request tag referential.", "Referential Module", $Logs, "" ,"DELETE", "");
			}
			$CurrentRef = mysql_fetch_array(mysql_query("SELECT reqTagCode, reqCatCode, reqTagDesc, reqTagAppr FROM tblreqtags WHERE id = '". $_POST['RequestTagsCode'] ."';", $connection));
			$res = mysql_query("DELETE FROM tblreqtags WHERE id = '". $_POST['RequestTagsCode'] ."';", $connection);
			if($res == true){
				echo 1;
			}
		break;
	} 
?>
