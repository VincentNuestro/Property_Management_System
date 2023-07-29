<?php
	session_start();
	include "../../../connect.php";
	switch ($_POST['form']) {
		case 'displayRequestCategory':
			$page = $_POST['page'];
			$limit = ($page-1) * 20;
			$res = mysql_query("SELECT reqCatCode, reqCatDesc, id FROM tblreqcategory WHERE reqCatDesc LIKE '%". $_POST['key'] ."%' OR reqCatCode LIKE '%". $_POST['key'] ."%' GROUP BY reqCatCode ORDER BY ". $_POST['requestcatSortBy'] ." ". $_POST['requestcatSortType'] ." LIMIT ".$limit.",20;", $connection);
			while($row = mysql_fetch_array($res)){
				?>
					<tr id="<?php echo $row[2]; ?>">
						<td><?php echo $row[0]; ?></td>
						<td><?php echo utf8_encode($row[1]); ?></td>
					</tr>
				<?php
			}
		break;

		case 'loadEntriesRequestCategory':
			if($_POST["page"] == ""){
	            $page = 1;
	        }else{
	            $page = $_POST["page"];
	        }
    		$limit = ($page-1) * 20;
            $rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(reqCatCode) FROM tblreqcategory WHERE reqCatDesc LIKE '%". $_POST['key'] ."%' OR reqCatCode LIKE '%". $_POST['key'] ."%';", $connection));
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

		case "loadPageRequestCategory":
			$page = $_POST["page"];
			$rowCount = mysql_fetch_row(mysql_query("SELECT COUNT(reqCatCode) FROM tblreqcategory WHERE reqCatDesc LIKE '%". $_POST['key'] ."%' OR reqCatCode LIKE '%". $_POST['key'] ."%';", $connection));
			$rowsperpage = 20;
			$range = 1;
			$totalpages = ceil($rowCount[0] / $rowsperpage);
			$prevpage;
			$nextpage;
			// if not on page 1, don't show back links
			if($page > 1 ){
			   	echo "<li style='width:50px !important;' onclick='fncPageRequestCategory(1)'><< First</li>";
			   	$prevpage = $page - 1;
			   	echo "<li style='width:70px !important;' onclick='fncPageRequestCategory(". $prevpage .")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if(($x > 0) && ($x <= $totalpages)){
    			    if($x == $page){
                        echo "<li id='pgRequestCategory" . $x . "' class='pgnumRequestCategory active' onclick='fncPageRequestCategory(" . $x . ",". $x .")'>" . $x . "</li>";
                    }else{
    			        echo "<li id='pgRequestCategory" . $x . "' class='pgnumRequestCategory' onclick='fncPageRequestCategory(" . $x . ",". $x .")'>" . $x . "</li>";
                    }
		       	}
		    }
		    if($page < ($totalpages - $range)){
                echo "<li>...</li>";
            }
		    if($page != $totalpages && $rowCount[0] != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='fncPageRequestCategory(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='fncPageRequestCategory(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'selectedRequestCategory':
			$row = mysql_fetch_array(mysql_query("SELECT reqCatCode, reqCatDesc, id FROM tblreqcategory WHERE id = '". $_POST['id'] ."';", $connection));
			echo $row[0] . "|" . utf8_encode($row[1]) . "|" . $row[2];
		break;

		case 'saveRequestCategory':
			$arrHeader = ["RequestCategory Code", "RequestCategory Description"];
			$arrValue = [$_POST['RequestCategoryCode'], $_POST['RequestCategoryDesc']];
			$Logs = createXinfo("INSERT", $arrHeader, "", $arrValue, "", "", "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("added a new Request category referential.", "Referential Module", $Logs, "" ,"ADD", "");
			}
			$rowcheck = mysql_fetch_array(mysql_query("SELECT reqCatCode FROM tblreqcategory WHERE reqCatCode = '". $_POST['RequestCategoryCode'] ."';", $connection));
			if($rowcheck[0] == ""){
				// $rowdesc = mysql_fetch_array(mysql_query("SELECT reqCatDesc FROM tblreqcategory WHERE reqCatDesc = '". $_POST['RequestCategoryDesc'] ."';", $connection));
				// if($rowdesc[0] == ""){

					$res = mysql_query("INSERT INTO tblreqcategory SET reqCatCode = '". mysql_escape_string(strtoupper($_POST['RequestCategoryCode'])) ."', reqCatDesc = '". mysql_escape_string(ucfirst($_POST['RequestCategoryDesc'])) ."';", $connection);
					if($res == true){
						echo 1;
					}
				// }
				// else{
				// 	echo "Request Category Description already exist.";
				// }
			}else{
				echo "Request Category Code already exist.";
			}
		break;

		case 'updateRequestCategory':
			$arrHeader = ["RequestCategory Code", "RequestCategory Description"];
			$arrFields = ["reqCatCode", "reqCatDesc"];
			$arrValue = [$_POST['RequestCategoryCode'], $_POST['RequestCategoryDesc']];
			$Logs = createXinfo("UPDATE", $arrHeader, $arrFields, $arrValue, "tblreqcategory", $_POST['hiddenRequestCategoryid'], "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("modified an Request category referential.", "Referential Module", $Logs, "" ,"UPDATE", "1");
			}
			$CurrentRef = mysql_fetch_array(mysql_query("SELECT reqCatCode, reqCatDesc FROM tblreqcategory WHERE id = '". $_POST['hiddenRequestCategoryid'] ."';", $connection));
			$res = mysql_query("UPDATE tblreqcategory SET reqCatCode = '". mysql_escape_string(strtoupper($_POST['RequestCategoryCode'])) ."', reqCatDesc = '". mysql_escape_string(ucfirst($_POST['RequestCategoryDesc'])) ."' WHERE id = '". $_POST['hiddenRequestCategoryid'] ."';", $connection);
			if($res == true){
				echo 1;
			}
		break;

		case 'deleteRequestCategory':
			$arrHeader = ["RequestCategory Code", "RequestCategory Description"];
			$arrFields = ["reqCatCode", "reqCatDesc"];
			$Logs = createXinfo("DELETE", $arrHeader, $arrFields, "", "tblreqcategory", $_POST['RequestCategoryCode'], "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("deleted an request category referential.", "Referential Module", $Logs, "" ,"DELETE", "");
			}
			$CurrentRef = mysql_fetch_array(mysql_query("SELECT reqCatCode, reqCatDesc FROM tblreqcategory WHERE id = '". $_POST['RequestCategoryCode'] ."';", $connection));
			$res = mysql_query("DELETE FROM tblreqcategory WHERE id = '". $_POST['RequestCategoryCode'] ."';", $connection);
			if($res == true){
				echo 1;
			}
		break;

		case 'clickUpdateRequestCategory':
			$row = mysql_fetch_array(mysql_query("SELECT COUNT(reqCatDesc) FROM tblreqcategory WHERE reqCatDesc = '". $_POST['RequestCategoryCode'] ."';", $connection));
			if($row[0] >= 1){
				echo 1;
			}else{
				echo 0;
			}
		break;
	}
?>