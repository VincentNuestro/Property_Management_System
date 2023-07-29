<?php
	session_start();
	include "../../../connect.php";
	switch ($_POST['form']) {
		case 'displayCat':
			$page = $_POST['page'];
			$limit = ($page-1) * 20;
			if(SysLeaseSetup['isClassification'] == "1" && SysLeaseSetup['isDepartment'] == "0" && $_POST['UnitCategorySortBy'] != "" && $_POST['UnitCategorySortType'] != ""){
				$sql = "SELECT b.classification, a.categoryID, a.category FROM tblref_merchandisedep_cat AS a LEFT JOIN tblref_merchandise_class AS b ON a.class_ID = b.classificationID WHERE a.category LIKE '%". $_POST['key']."%' OR b.classification LIKE '%". $_POST['key'] ."%' OR a.categoryID LIKE '%". $_POST['key'] ."%' GROUP BY a.categoryID ORDER BY ". $_POST['UnitCategorySortBy'] ." ". $_POST['UnitCategorySortType'] ." LIMIT ".$limit.",20;";
			}else{
				if(SysLeaseSetup['isDepartment'] == "1" && $_POST['ClassificationSortBy'] != "" && $_POST['ClassificationSortType'] != ""){
					$sql = "SELECT b.department, a.categoryID, a.category FROM tblref_merchandisedep_cat AS a LEFT JOIN tblref_merchandise_depa AS b ON a.dept_ID = b.departmentID WHERE a.category LIKE '%". $_POST['key']."%' OR b.department LIKE '%". $_POST['key'] ."%' OR a.categoryID LIKE '%". $_POST['key'] ."%' GROUP BY a.categoryID ORDER BY ". $_POST['UnitCategorySortBy'] ." ". $_POST['UnitCategorySortType'] ." LIMIT ".$limit.",20;";
					
					echo "SELECT b.department, a.categoryID, a.category FROM tblref_merchandisedep_cat AS a LEFT JOIN tblref_merchandise_depa AS b ON a.dept_ID = b.departmentID WHERE a.category LIKE '%". $_POST['key']."%' OR b.department LIKE '%". $_POST['key'] ."%' OR a.categoryID LIKE '%". $_POST['key'] ."%' GROUP BY a.categoryID ORDER BY ". $_POST['UnitCategorySortBy'] ." ". $_POST['UnitCategorySortType'] ." LIMIT ".$limit.",20;";
				}else{
					$sql = "SELECT categoryID, categoryID, category FROM tblref_merchandisedep_cat WHERE category LIKE '%". $_POST['key']."%' OR categoryID LIKE '%". $_POST['key'] ."%'GROUP BY categoryID ORDER BY ". $_POST['UnitCategorySortBy'] ." ". $_POST['UnitCategorySortType'] ." LIMIT ".$limit.",20;";
				}
			}
			$res = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($res)){
				?>
					<tr id="<?php echo $row[1]; ?>">
						<td><?php echo $row[1]; ?></td>
						<?php if(SysLeaseSetup('isClassification') == "1" || SysLeaseSetup('isDepartment') == "1"){ ?> <td><?php echo $row[0]; ?></td> <?php } ?>
						<td><?php echo utf8_encode($row[2]); ?></td>
					</tr>
				<?php
			}
			if(SysLeaseSetup('isClassification') == "1" && SysLeaseSetup('isDepartment') == "0"){
				$sql2 = "SELECT COUNT(a.id) FROM tblref_merchandisedep_cat AS a LEFT JOIN tblref_merchandise_class AS b ON a.class_ID = b.classificationID WHERE a.category LIKE '%". $_POST['key']."%' OR b.classification LIKE '%". $_POST['key'] ."%' OR a.categoryID LIKE '%". $_POST['key'] ."%';";
			}else{
				if(SysLeaseSetup('isDepartment') == "1"){
					$sql2 = "SELECT COUNT(a.id) FROM tblref_merchandisedep_cat AS a LEFT JOIN tblref_merchandise_depa AS b ON a.dept_ID = b.departmentID WHERE a.category LIKE '%". $_POST['key']."%' OR b.department LIKE '%". $_POST['key'] ."%' OR a.categoryID LIKE '%". $_POST['key'] ."%';";
				}else{
					$sql2 = "SELECT COUNT(id) FROM tblref_merchandisedep_cat WHERE category LIKE '%". $_POST['key']."%' OR categoryID LIKE '%". $_POST['key'] ."%';";
				}
			}
		break;

		case 'loadEntriesCategory':
			if($_POST["page"] == ""){
	            $page = 1;
	        }else{
	            $page = $_POST["page"];
	        }
    		$limit = ($page-1) * 20;
    		if(SysLeaseSetup('isClassification') == "1" && SysLeaseSetup('isDepartment') == "0"){
            		$rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(b.classification) FROM tblref_merchandisedep_cat AS a LEFT JOIN tblref_merchandise_class AS b ON a.class_ID = b.classificationID WHERE a.category LIKE '%". $_POST['key']."%' OR b.classification LIKE '%". $_POST['key'] ."%' OR a.categoryID LIKE '%". $_POST['key'] ."%'", $connection));
			}else{
				if(SysLeaseSetup('isDepartment') == "1"){
            		$rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(b.department) FROM tblref_merchandisedep_cat AS a LEFT JOIN tblref_merchandise_depa AS b ON a.dept_ID = b.departmentID WHERE a.category LIKE '%". $_POST['key']."%' OR b.department LIKE '%". $_POST['key'] ."%' OR a.categoryID LIKE '%". $_POST['key'] ."%'", $connection));
				}else{
            		$rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(categoryID) FROM tblref_merchandisedep_cat WHERE category LIKE '%". $_POST['key']."%' OR categoryID LIKE '%". $_POST['key'] ."%'", $connection));
				}
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

		case "loadPageCategory":
			$page = $_POST["page"];
			if(SysLeaseSetup('isClassification') == "1" && SysLeaseSetup('isDepartment') == "0"){
            		$rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(b.classification) FROM tblref_merchandisedep_cat AS a LEFT JOIN tblref_merchandise_class AS b ON a.class_ID = b.classificationID WHERE a.category LIKE '%". $_POST['key']."%' OR b.classification LIKE '%". $_POST['key'] ."%' OR a.categoryID LIKE '%". $_POST['key'] ."%'", $connection));
			}else{
				if(SysLeaseSetup('isDepartment') == "1"){
            		$rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(b.department) FROM tblref_merchandisedep_cat AS a LEFT JOIN tblref_merchandise_depa AS b ON a.dept_ID = b.departmentID WHERE a.category LIKE '%". $_POST['key']."%' OR b.department LIKE '%". $_POST['key'] ."%' OR a.categoryID LIKE '%". $_POST['key'] ."%'", $connection));
				}else{
            		$rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(categoryID) FROM tblref_merchandisedep_cat WHERE category LIKE '%". $_POST['key']."%' OR categoryID LIKE '%". $_POST['key'] ."%'", $connection));
				}
			}
			$rowsperpage = 20;
			$range = 1;
			$totalpages = ceil($rowCount[0] / $rowsperpage);
			$prevpage;
			$nextpage;
			// if not on page 1, don't show back links
			if($page > 1 ){
			   	echo "<li style='width:50px !important;' onclick='fncPageCatetory(1)'><< First</li>";
			   	$prevpage = $page - 1;
			   	echo "<li style='width:70px !important;' onclick='fncPageCatetory(". $prevpage .")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if(($x > 0) && ($x <= $totalpages)){
    			    if($x == $page){
                        echo "<li id='pgCategory" . $x . "' class='pgnumCategory active' onclick='fncPageCatetory(" . $x . ",". $x .")'>" . $x . "</li>";
                    }else{
    			        echo "<li id='pgCategory" . $x . "' class='pgnumCategory' onclick='fncPageCatetory(" . $x . ",". $x .")'>" . $x . "</li>";
                    }
		       	}
		    }
		    if($page < ($totalpages - $range)){
                echo "<li>...</li>";
            }
		    if($page != $totalpages && $rowCount[0] != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='fncPageCatetory(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='fncPageCatetory(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'selectedCat':
			$row = mysql_fetch_array(mysql_query("SELECT id, dept_ID, categoryID, category FROM tblref_merchandisedep_cat WHERE categoryID = '". $_POST['id'] ."';", $connection));
			echo $row[0] . "|" . utf8_encode($row[1]) . "|" . utf8_encode($row[2]) . "|" . utf8_encode($row[3]);
		break;

		case 'saveCat':
			$rowcheck = mysql_fetch_array(mysql_query("SELECT categoryID FROM tblref_merchandisedep_cat WHERE categoryID = '". $_POST['catCode'] ."';", $connection));
			// if($rowcheck[0] == ""){
			// 	$rowdesc = mysql_fetch_array(mysql_query("SELECT category FROM tblref_merchandisedep_cat WHERE category = '". $_POST['catDesc'] ."';", $connection));
			// 	if($rowdesc[0] == ""){
			// 		if(SysLeaseSetup('isClassification') == "1" && SysLeaseSetup('isDepartment') == "0"){
			// 			$isClassification = " class_ID = '". $_POST['classID'] ."', "; 
			// 			$isDepartment = "";
			// 			if($_POST['classID'] != ""){
			// 				$Logs .= "Classification Code : ". $_POST['classID'] . "|";
			// 			}
			// 		}else{
			// 			if(SysLeaseSetup('isDepartment') == "1"){
			// 				$isClassification = "";
			// 				$isDepartment = " dept_ID = '". $_POST['deptId'] ."', ";
			// 				if($_POST['deptId'] != ""){
			// 					$Logs .= "Department Code : ". $_POST['deptId'] . "|";
			// 				}
			// 			}
			// 		}
					$res = mysql_query("INSERT INTO tblref_merchandisedep_cat SET ". $isClassification.$isDepartment ." categoryID = '". mysql_escape_string(strtoupper($_POST['catCode'])) ."', category = '". mysql_escape_string(ucfirst($_POST['catDesc'])) ."';", $connection);
					if($res == true){
						echo 1;
					}
					if($_POST['catCode'] != ""){
						$Logs .= "Category Code : ". utf8_encode($_POST['catCode']) . "|";
					}
					// if($_POST['catDesc'] != ""){
					// 	$Logs .= "Category Description : ". utf8_encode($_POST['catDesc']) . "|";
					// }
					if($Logs != ""){
						$tran_logs = create_logs_per_transaction("added a new department referential.", "Referential Module", $Logs, "" ,"ADD", "");
					}
				// }else{
				// 	echo "Category Description already exist.";
				// }
			// }
			else{
				echo "Category Code already exist.";
			}
		break;

		case 'updateCat':
			$CurrentRef = mysql_fetch_array(mysql_query("SELECT class_ID, dept_ID, categoryID, category FROM tblref_merchandisedep_cat WHERE id = '". $_POST['hiddencatid'] ."';", $connection));
			if(SysLeaseSetup('isClassification') == "1" && SysLeaseSetup('isDepartment') == "0"){
				$isClassification = " class_ID = '". $_POST['classID'] ."', "; 
				$isDepartment = "";
				if($CurrentRef['class_ID'] == ""){
					$Logs .= "Classification Code : ". $_POST['classID'] . "|";
				}else{
					$Logs .= "Classification Code : From ". $CurrentRef['class_ID'] ." To ". $_POST['classID'] . "|";
				}
			}else{
				if(SysLeaseSetup('isDepartment') == "1"){
					$isClassification = "";
					$isDepartment = " dept_ID = '". $_POST['deptId'] ."', ";
					if($CurrentRef['dept_ID'] == ""){
						$Logs .= "Department Code : ". $_POST['deptId'] . "|";
					}else{
						$Logs .= "Department Code : From ". $CurrentRef['dept_ID'] ." To ". $_POST['deptId'] . "|";
					}
				}
			}
			$res = mysql_query("UPDATE tblref_merchandisedep_cat SET ". $isClassification.$isDepartment ." categoryID = '". mysql_escape_string(strtoupper($_POST['catCode'])) ."', category = '". mysql_escape_string(ucfirst($_POST['catDesc'])) ."' WHERE id = '". $_POST['hiddencatid'] ."';", $connection);
			if($res == true){
				echo 1;
				if($CurrentRef['categoryID'] != $_POST['catCode']){
					if($CurrentRef['categoryID'] == ""){
						$Logs .= "Category Code : ". $_POST['catCode'] . "|";
					}else{
						$Logs .= "Category Code : From ". $CurrentRef['categoryID'] ." To ". $_POST['catCode'] . "|";
					}
				}
				if($CurrentRef['category'] != $_POST['catDesc']){
					if($CurrentRef['category'] == ""){
						$Logs .= "Category Description : ". $_POST['catDesc'] . "|";
					}else{
						$Logs .= "Category Description : From ". $CurrentRef['category'] ." To ". $_POST['catDesc'] . "|";
					}
				}
				if($Logs != ""){
					$tran_logs = create_logs_per_transaction("modified a classification referential.", "Referential Module", $Logs, "" ,"UPDATE", "");
				}
			}
		break;

		case 'deleteCat':
			$CurrentRef = mysql_fetch_array(mysql_query("SELECT class_ID, dept_ID, categoryID, category FROM tblref_merchandisedep_cat WHERE categoryID = '". $_POST['catCode'] ."';", $connection));
			$sql = "DELETE FROM tblref_merchandisedep_cat WHERE categoryID = '". $_POST['catCode'] ."';";
			$res = mysql_query($sql, $connection);
			if($res == true){
				echo 1;
				if(SysLeaseSetup('isClassification') == "1" && SysLeaseSetup('isDepartment') == "0"){
					$Logs .= "Classification Code : ". $CurrentRef['class_ID'] . "|";
				}else{
					if(SysLeaseSetup('isDepartment') == "1"){
						$Logs .= "Department Code : ". $CurrentRef['dept_ID'] . "|";
					}
				}
				$Logs .= "Category Code : ". $CurrentRef['categoryID'] . "|";
				$Logs .= "Category Description : ". $CurrentRef['category'] . "|";
				if($Logs != ""){
					$tran_logs = create_logs_per_transaction("deleted a department referential.", "Referential Module", $Logs, "" ,"DELETE", "");
				}
			}
		break;

		case 'listUnitDept':
			echo "<option value=''>-- Select Department --</option>";
			$res = mysql_query("SELECT departmentID, department FROM tblref_merchandise_depa;", $connection);
			while($row = mysql_fetch_array($res)){
				echo "<option value='". $row[0] ."'>".$row[1]."</option>";
			}
		break;

		case 'clickUpdateCat':
			$row = mysql_fetch_array(mysql_query("SELECT COUNT(catid) FROM tblref_unit WHERE catid = '". $_POST['catCode'] ."';", $connection));
			if($row[0] >= 1){
				echo 1;
			}else{
				echo 0;
			}
		break;

		case 'listUnitClass':
			echo "<option value=''>-- Select Classification --</option>";
			$res = mysql_query("SELECT classificationID, classification FROM tblref_merchandise_class;", $connection);
			while($row = mysql_fetch_array($res)){
				echo "<option value='". $row[0] ."'>".$row[1]."</option>";
			}
		break;

		// xmer 09162019
		case 'AutoConsolidateUnitCategory':
			if(SysLeaseSetup('isClassification') == "1" && SysLeaseSetup('isDepartment') == "0"){
				$Category = "SELECT b.classification, a.categoryID, a.category FROM tblref_merchandisedep_cat AS a LEFT JOIN tblref_merchandise_class AS b ON a.class_ID = b.classificationID WHERE a.category LIKE '%". $_POST['key']."%' OR b.classification LIKE '%". $_POST['key'] ."%' OR a.categoryID LIKE '%". $_POST['key'] ."%' ORDER BY a.category ASC ";
			}else{
				if(SysLeaseSetup('isDepartment') == "1"){
					$Category = "SELECT b.department, a.categoryID, a.category FROM tblref_merchandisedep_cat AS a LEFT JOIN tblref_merchandise_depa AS b ON a.dept_ID = b.departmentID WHERE a.category LIKE '%". $_POST['key']."%' OR b.department LIKE '%". $_POST['key'] ."%' OR a.categoryID LIKE '%". $_POST['key'] ."%' ORDER BY a.category ASC ";
				}else{
					$Category = "SELECT categoryID, categoryID, category FROM tblref_merchandisedep_cat WHERE category LIKE '%". $_POST['key']."%' OR categoryID LIKE '%". $_POST['key'] ."%' ORDER BY category ASC ";
				}
			}

			$resclassification = mysql_query($Category, $connection);
			$data = "Code,Department,Description\r\n";
			while($rowclassification = mysql_fetch_array($resclassification)){
				$data .= $rowclassification[1].",".$rowclassification[0].",".$rowclassification[2]."\r\n";
			}
			$filepath = mysql_fetch_array(mysql_query("SELECT filepath FROM tblsys_setup", $connection));
			$syspath = str_replace("\\", "/", $filepath[0]);
			if (!file_exists($syspath)){
				mkdir($syspath, 0777, true);
			}
			$file = $syspath."Unit_Category_".date('mdY').".csv";
			chmod($file, 0777);
			if (file_put_contents($file, $data)){
			create_logs_per_transaction('exported a referential to excel', 'Unit Category', '', '', 'EXPORT', '');
				echo 1;
			}else{
				echo 0;
			}
		break;
		// xmer 09162019
	}
?>