<?php
	session_start();
	include "../../../connect.php";
	switch ($_POST['form']) {
		case 'displayPosition':
			$page = $_POST['page'];
			$limit = ($page-1) * 20;
			$res = mysql_query("SELECT EmpDepCode, EmpPositionCode, xPOSITION, id FROM tblref_companyposition WHERE xPOSITION LIKE '%". $_POST['key'] ."%' ORDER BY xPOSITION ASC LIMIT ". $limit .",20;", $connection);
			while($row = mysql_fetch_array($res)){
				$Department = mysql_fetch_array(mysql_query("SELECT description FROM tblmaintenance_department WHERE code = '". $row['0'] ."';", $connection));
				?>
					<tr id="<?php echo $row['id']; ?>">
						<td><?php echo $Department[0]; ?></td>
						<td><?php echo $row[1]; ?></td>
						<td><?php echo $row[2]; ?></td>
					</tr>
				<?php
			}
		break;

		case 'loadEntriesPosition':
			if($_POST["page"] == ""){
	            $page = 1;
	        }else{
	            $page = $_POST["page"];
	        }
    		$limit = ($page-1) * 20;
            $rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(xPOSITION) FROM tblref_companyposition WHERE xPOSITION LIKE '%". $_POST['key'] ."%';", $connection));
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

		case "loadPagePosition":
			$page = $_POST["page"];
			$rowCount = mysql_fetch_row(mysql_query("SELECT COUNT(xPOSITION) FROM tblref_companyposition WHERE xPOSITION LIKE '%". $_POST['key'] ."%';", $connection));
			$rowsperpage = 20;
			$range = 1;
			$totalpages = ceil($rowCount[0] / $rowsperpage);
			$prevpage;
			$nextpage;
			// if not on page 1, don't show back links
			if($page > 1 ){
			   	echo "<li style='width:50px !important;' onclick='fncPagePosition(1)'><< First</li>";
			   	$prevpage = $page - 1;
			   	echo "<li style='width:70px !important;' onclick='fncPagePosition(". $prevpage .")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if(($x > 0) && ($x <= $totalpages)){
    			    if($x == $page){
                        echo "<li id='pgPosition" . $x . "' class='pgnumPosition active' onclick='fncPagePosition(" . $x . ",". $x .")'>" . $x . "</li>";
                    }else{
    			        echo "<li id='pgPosition" . $x . "' class='pgnumPosition' onclick='fncPagePosition(" . $x . ",". $x .")'>" . $x . "</li>";
                    }
		       	}
		    }
		    if($page < ($totalpages - $range)){
                echo "<li>...</li>";
            }
		    if($page != $totalpages && $rowCount[0] != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='fncPagePosition(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='fncPagePosition(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'selectedPosition':
			$row = mysql_fetch_array(mysql_query("SELECT id, EmpDepCode, EmpPositionCode, xPOSITION FROM tblref_companyposition WHERE id = '". $_POST['id'] ."';", $connection));
			echo $row['id'] . "|" . $row['EmpDepCode'] . "|" . $row['EmpPositionCode'] . "|" . $row['xPOSITION'];
		break;

		case 'savePosition':
			//INSERT LOG FIRST - JONAS - 12/5/2018
			$arrHeader = ["Position"];
			$arrValue = [$_POST['positionDesc']];
			$Logs = createXinfo("INSERT", $arrHeader, "", $arrValue, "", "", "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("added a new position referential.", "Referential Module", $Logs, "" ,"ADD", "");
			}
			//INSERT LOG FIRST - JONAS - 12/5/2018
			$rowcheck = mysql_fetch_array(mysql_query("SELECT xPOSITION, EmpDepCode FROM tblref_companyposition WHERE EmpPositionCode = '". $_POST['PositionCode'] ."';", $connection));
			if($rowcheck[0] == ""){
				$sql = "INSERT INTO tblref_companyposition SET xPosition = '". mysql_escape_string(ucfirst($_POST['positionDesc'])) ."', EmpDepCode = '". $_POST['deptdesc'] ."', EmpPositionCode = '". mysql_escape_string(strtoupper($_POST['PositionCode'])) ."';";
				$res = mysql_query($sql, $connection);

				if($res == true){
					echo 1;
				}
			}else{
				echo "Description already exist.";
			}
		break;

		case 'updatePosition':
			//INSERT UPDATE LOG FIRST - JONAS - 12/5/2018
			$arrHeader = ["Position"];
			$arrFields = ["xPosition"];
			$arrValue = [utf8_encode($_POST['positionDesc'])];
			$Logs = createXinfo("UPDATE", $arrHeader, $arrFields, $arrValue, "tblref_companyposition", $_POST['hiddenpositionid'], "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("modified a position referential.", "Referential Module", $Logs, "" ,"UPDATE", "");
			}
			//INSERT UPDATE LOG FIRST - JONAS - 12/5/2018
			$res = mysql_query("UPDATE tblref_companyposition SET xPosition = '". mysql_escape_string(ucfirst($_POST['positionDesc'])) ."', EmpDepCode = '". $_POST['deptdesc'] ."', EmpPositionCode = '". mysql_escape_string(strtoupper($_POST['PositionCode'])) ."' WHERE id = '". $_POST['hiddenpositionid'] ."';", $connection);
			if($res == true){
				echo 1;
			}
		break;

		case 'deletePosition':
			//INSERT DELETE LOG FIRST - JONAS - 12/5/2018
			$arrHeader = ["Position"];
			$arrFields = ["xPosition"];
			$Logs = createXinfo("DELETE", $arrHeader, $arrFields, "", "tblref_companyposition", $_POST['hiddenpositionid'], "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("deleted a position referential.", "Referential Module", $Logs, "", "DELETE", "");
			}
			//INSERT DELETE LOG FIRST - JONAS - 12/5/2018
			$res = mysql_query("DELETE FROM tblref_companyposition WHERE id = '". $_POST['hiddenpositionid'] ."';", $connection);
			if($res == true){
				echo 1;
			}
		break;

		case 'showDepartment':
			$res = mysql_query("SELECT code, description FROM tblmaintenance_department", $connection);
			echo $res[0];
			while($row = mysql_fetch_array($res)){
				echo "<option value='".$row[0]."'>".$row[1]."</option>";
			}
		break;

		case 'AutoConsolidatePosition':
			$Position = "SELECT EmpDepCode, EmpPositionCode, xPOSITION FROM tblref_companyposition WHERE xPOSITION LIKE '%". $_POST['key'] ."%' ORDER BY xPOSITION ASC ";
			$resclassification = mysql_query($Position, $connection);
			$data = "Department,PositionCode,Position\r\n";
			while($rowclassification = mysql_fetch_array($resclassification)){
				$data .= $rowclassification[0].",".$rowclassification[1].",".$rowclassification[2]."\r\n";
			}
			$filepath = mysql_fetch_array(mysql_query("SELECT filepath FROM tblsys_setup", $connection));
			$syspath = str_replace("\\", "/", $filepath[0]);
			if (!file_exists($syspath)){
				mkdir($syspath, 0777, true);
			}
			$file = $syspath."Position_".date('mdY').".csv";
			chmod($file, 0777);
			if (file_put_contents($file, $data)){
			create_logs_per_transaction('exported a referential to excel', 'Position', '', '', 'EXPORT', '');
				echo 1;
			}else{
				echo 0;
			}
		break;
	}
?>