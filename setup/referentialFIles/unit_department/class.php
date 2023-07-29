<?php
	session_start();
	include "../../../connect.php";
	switch ($_POST['form']) {
		case 'displayDept':
			$page = $_POST['page'];
			$limit = ($page-1) * 20;
			if(SysLeaseSetup['isClassification'] == '1' && $_POST['UnitDepartmentSortType'] != "" && $_POST['UnitDepartmentSortBy'] != ""){
				$res = mysql_query("SELECT b.classification, a.departmentID, a.department FROM tblref_merchandise_depa AS a LEFT JOIN tblref_merchandise_class AS b ON a.class_ID = b.classificationID WHERE a.department LIKE '%". $_POST['key'] ."%' OR b.classification LIKE '%". $_POST['key'] ."%' OR a.departmentID LIKE '%". $_POST['key'] ."%' GROUP BY a.departmentID ORDER BY ". $_POST['UnitDepartmentSortBy'] ." ". $_POST['UnitDepartmentSortType'] ."LIMIT ".$limit.",20;", $connection);
			}else{
				$res = mysql_query("SELECT id, departmentID, department FROM tblref_merchandise_depa WHERE department LIKE '%". $_POST['key'] ."%' OR departmentID LIKE '%". $_POST['key'] ."%'GROUP BY departmentID LIMIT ".$limit.",20;", $connection);
			}
			while($row = mysql_fetch_array($res)){
				?>
					<tr id="<?php echo $row[1]; ?>">
						<td><?php echo $row[1]; ?></td>
						<?php if(SysLeaseSetup('isClassification') == "1"){ ?> <td><?php echo $row[0]; ?></td> <?php } ?>
						<td><?php echo utf8_encode($row[2]); ?></td>
					</tr>
				<?php
			}
		break;

		case 'loadEntriesDepartment':
			if($_POST["page"] == ""){
	            $page = 1;
	        }else{
	            $page = $_POST["page"];
	        }
    		$limit = ($page-1) * 20;
			if(SysLeaseSetup('isClassification') == '1'){
            	$rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(a.id) FROM tblref_merchandise_depa AS a LEFT JOIN tblref_merchandise_class AS b ON a.class_ID = b.classificationID WHERE a.department LIKE '%". $_POST['key'] ."%' OR b.classification LIKE '%". $_POST['key'] ."%' OR a.departmentID LIKE '%". $_POST['key'] ."%';", $connection));
            }else{
				$rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM tblref_merchandise_depa WHERE department LIKE '%". $_POST['key'] ."%' OR departmentID LIKE '%". $_POST['key'] ."%' ORDER BY department ASC LIMIT ".$limit.",20;", $connection));
			}
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

		case "loadPageDepartment":
			$page = $_POST["page"];
			if(SysLeaseSetup('isClassification') == '1'){
				$rowCount = mysql_fetch_row(mysql_query("SELECT COUNT(a.id) FROM tblref_merchandise_depa AS a LEFT JOIN tblref_merchandise_class AS b ON a.class_ID = b.classificationID WHERE a.department LIKE '%". $_POST['key'] ."%' OR b.classification LIKE '%". $_POST['key'] ."%' OR a.departmentID LIKE '%". $_POST['key'] ."%';", $connection));
			}else{
				$rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM tblref_merchandise_depa WHERE department LIKE '%". $_POST['key'] ."%' OR departmentID LIKE '%". $_POST['key'] ."%' ORDER BY department ASC LIMIT ".$limit.",20;", $connection));
			}
			$rowsperpage = 20;
			$range = 1;
			$totalpages = ceil($rowCount[0] / $rowsperpage);
			$prevpage;
			$nextpage;
			// if not on page 1, don't show back links
			if($page > 1 ){
			   	echo "<li style='width:50px !important;' onclick='fncPageDepartment(1)'><< First</li>";
			   	$prevpage = $page - 1;
			   	echo "<li style='width:70px !important;' onclick='fncPageDepartment(". $prevpage .")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if(($x > 0) && ($x <= $totalpages)){
    			    if($x == $page){
                        echo "<li id='pgDepartment" . $x . "' class='pgnumDepartment active' onclick='fncPageDepartment(" . $x . ",". $x .")'>" . $x . "</li>";
                    }else{
    			        echo "<li id='pgDepartment" . $x . "' class='pgnumDepartment' onclick='fncPageDepartment(" . $x . ",". $x .")'>" . $x . "</li>";
                    }
		       	}
		    }
		    if($page < ($totalpages - $range)){
                echo "<li>...</li>";
            }
		    if($page != $totalpages && $rowCount[0] != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='fncPageDepartment(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='fncPageDepartment(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'selectedDept':
			$row = mysql_fetch_array(mysql_query("SELECT id, class_ID, departmentID, department FROM tblref_merchandise_depa WHERE departmentID = '". $_POST['id'] ."';", $connection));
			echo $row[0] . "|" . utf8_encode($row[1]) . "|" . utf8_encode($row[2]) . "|" . utf8_encode($row[3]);
		break;

		case 'saveDept':
			$rescheck = mysql_query("SELECT departmentID FROM tblref_merchandise_depa WHERE departmentID = '". $_POST['deptCode'] ."';", $connection);
			$rowcheck = mysql_fetch_array($rescheck);
			if($rowcheck[0] == ""){
				$rowdesc = mysql_fetch_array(mysql_query("SELECT department FROM tblref_merchandise_depa WHERE department = '". $_POST['deptDesc'] ."';", $connection));
				if($rowdesc[0] == ""){
					if(SysLeaseSetup('isClassification') == "1"){
						$isClassification = " class_ID = '". $_POST['depclassId'] ."', "; 
						if($_POST['depclassId'] != ""){
							$Logs .= "Classification Code : ". $_POST['depclassId'] . "|";
						}
					}
					$res = mysql_query("INSERT INTO tblref_merchandise_depa SET ". $isClassification ." departmentID = '". mysql_escape_string(strtoupper($_POST['deptCode'])) ."', department = '". mysql_escape_string(ucfirst($_POST['deptDesc'])) ."';", $connection);
					if($res == true){
						echo 1;
					}
					if($_POST['deptCode'] != ""){
						$Logs .= "Department Description : ". utf8_encode($_POST['deptCode']) . "|";
					}
					if($_POST['deptDesc'] != ""){
						$Logs .= "Department Description : ". utf8_encode($_POST['deptDesc']) . "|";
					}
					if($Logs != ""){
						$tran_logs = create_logs_per_transaction("added a new department referential.", "Referential Module", $Logs, "" ,"ADD", "");
					}
				}else{
					echo "Department Description already exist.";
				}
			}else{
				echo "Department Code already exist.";
			}
		break;

		case 'updateDept':
			$CurrentRef = mysql_fetch_array(mysql_query("SELECT class_ID, departmentID, department FROM tblref_merchandise_depa WHERE id = '". $_POST['hiddendeptid'] ."';", $connection));
			if(SysLeaseSetup('isClassification') == "1"){
				$isClassification = " class_ID = '". $_POST['depclassId'] ."', "; 
				if($CurrentRef['class_ID'] == ""){
					$Logs .= "Classification Code : ". $_POST['depclassId'] . "|";
				}else{
					$Logs .= "Classification Code : From ". $CurrentRef['class_ID'] ." To ". $_POST['depclassId'] . "|";
				}
			}
			$res = mysql_query("UPDATE tblref_merchandise_depa SET ". $isClassification ." departmentID = '". mysql_escape_string(strtoupper($_POST['deptCode'])) ."', department = '". mysql_escape_string(ucfirst($_POST['deptDesc'])) ."' WHERE id = '". $_POST['hiddendeptid'] ."';", $connection);
			if($res == true){
				echo 1;
				if($CurrentRef['departmentID'] != $_POST['deptCode']){
					if($CurrentRef['departmentID'] == ""){
						$Logs .= "Department Code : ". $_POST['deptCode'] . "|";
					}else{
						$Logs .= "Department Code : From ". $CurrentRef['departmentID'] ." To ". $_POST['deptCode'] . "|";
					}
				}
				if($CurrentRef['department'] != $_POST['deptDesc']){
					if($CurrentRef['department'] == ""){
						$Logs .= "Department Description : ". $_POST['deptDesc'] . "|";
					}else{
						$Logs .= "Department Description : From ". $CurrentRef['department'] ." To ". $_POST['deptDesc'] . "|";
					}
				}
				if($Logs != ""){
					$tran_logs = create_logs_per_transaction("modified a classification referential.", "Referential Module", $Logs, "" ,"UPDATE", "");
				}
			}
		break;

		case 'deleteClass':
			$CurrentRef = mysql_fetch_array(mysql_query("SELECT class_ID, departmentID, department FROM tblref_merchandise_depa WHERE departmentID = '". $_POST['deptCode'] ."';", $connection));
			$res = mysql_query("DELETE FROM tblref_merchandise_depa WHERE departmentID = '". $_POST['deptCode'] ."';", $connection);
			if($res == true){
				echo 1;
				$Logs .= "Classification Code : ". $CurrentRef['class_ID'] . "|";
				$Logs .= "Department Code : ". $CurrentRef['departmentID'] . "|";
				$Logs .= "Department Description : ". $CurrentRef['department'] . "|";
				if($Logs != ""){
					$tran_logs = create_logs_per_transaction("deleted a department referential.", "Referential Module", $Logs, "" ,"DELETE", "");
				}
			}
		break;

		case 'listClassification':
			echo "<option value=''>-- Select Classification --</option>";
			$res = mysql_query("SELECT classificationID, classification FROM tblref_merchandise_class;", $connection);
			while($row = mysql_fetch_array($res)){
				echo "<option value='". $row[0] ."'>".$row[1]."</option>";
			}
		break;

		case 'clickUpdateDept':
			$row = mysql_fetch_array(mysql_query("SELECT COUNT(depid) FROM tblref_unit WHERE depid = '". $_POST['deptCode'] ."';", $connection));
			if($row[0] >= 1){
				echo 1;
			}else{
				echo 0;
			}
		break;

		case 'AutoConsolidateDepartmentunit':
			$departmentunit = "SELECT class_ID, departmentID, department FROM tblref_merchandise_depa WHERE department LIKE '%". $_POST['key'] ."%' OR departmentID LIKE '%". $_POST['key'] ."%' ORDER BY departmentID ASC ";

			$resdeptunit = mysql_query($departmentunit, $connection);
			$data = "class_ID,departmentID,department\r\n";
			while($rowdepartment = mysql_fetch_array($resdeptunit)){
				$data .= $rowdepartment[0].",".$rowdepartment[1].",".$rowdepartment[2]."\r\n";
			}
			$filepath = mysql_fetch_array(mysql_query("SELECT filepath FROM tblsys_setup", $connection));
			$syspath = str_replace("\\", "/", $filepath[0]);
			if (!file_exists($syspath)){
				mkdir($syspath, 0777, true);
			}
			$file = $syspath."Unit_Department_".date('mdY').".csv";
			chmod($file, 0777);
			if (file_put_contents($file, $data)){
			create_logs_per_transaction('exported a referential to excel', 'Unit Department', '', '', 'EXPORT', '');
				echo 1;
			}else{
				echo 0;
			}
		break;
	}
?>