<?php 
	session_start();
	include "../../../connect.php";
	switch ($_POST['form']) {
		case 'saveDepartmentCat':
			$check = " SELECT code FROM tblmaintenance_department WHERE code = '". $_POST['DepartmentCatCode'] ."' ";
			$rescheck = mysql_query($check, $connection);
			$rowcheck = mysql_fetch_array($rescheck);
			if($rowcheck[0] == ""){
				$rowdesc = mysql_fetch_array(mysql_query("SELECT description FROM tblmaintenance_department WHERE description = '". $_POST['DepartmentCatDesc'] ."' "));
				if($rowdesc[0] == ""){
					$sql = " INSERT INTO tblmaintenance_department SET Code = '". mysql_escape_string(strtoupper($_POST['DepartmentCatCode'])) ."', description = '". mysql_escape_string(ucfirst($_POST['DepartmentCatDesc'])) ."' ";
					$res = mysql_query($sql, $connection);
					if($res == true){
						echo 1;
					}
				}else{
					echo "Description already exist.";
				}
			}else{
				echo "Code already exist.";
			}
		break;

		case 'updateDepartmentCat':
			$sql = " UPDATE tblmaintenance_department SET description = '". mysql_escape_string(ucfirst($_POST['DepartmentCatDesc'])) ."', code = '". mysql_escape_string(strtoupper($_POST['DepartmentCatCode'])) ."' WHERE id = '". $_POST['id'] ."' ";
			$res = mysql_query($sql, $connection);
			if($res == true){
				echo 1;
			}
		break;

		case 'showmainDepartment':
			if($_POST["page"] == ""){
	            $page = 1;
	        }else{
	            $page = $_POST["page"];
	        }
    		$limit = ($page-1) * 20;
			$sql = "SELECT id, code, description FROM tblmaintenance_department WHERE code LIKE '%". $_POST['key'] ."%' OR description LIKE '%". $_POST['key'] ."%' LIMIT ".$limit.",20;";
			$res = mysql_query($sql, $connection);
			while ( $row = mysql_fetch_array( $res ) ) {
				$mallname = mysql_fetch_array(mysql_query("SELECT mallname FROM tblref_mall WHERE mallid = '". $row[3] ."' "))
				?>
					<tr id="<?php echo $row[0]; ?>">
						<td><?php echo $row[1]; ?></td>
						<td><?php echo $row[2]; ?></td>
					</tr>
				<?php
			}
		break;

		case 'loadEntriesMainDepartment':
			if($_POST["page"] == ""){
	            $page = 1;
	        }else{
	            $page = $_POST["page"];
	        }
    		$limit = ($page-1) * 20;
            $rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM tblmaintenance_department WHERE code LIKE '%". $_POST['key'] ."%' OR description LIKE '%". $_POST['key'] ."%';", $connection));
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

		case "loadPageMainDepartment":
			$page = $_POST["page"];
			$rowCount = mysql_fetch_row(mysql_query("SELECT COUNT(id) FROM tblmaintenance_department WHERE code LIKE '%". $_POST['key'] ."%' OR description LIKE '%". $_POST['key'] ."%';", $connection));
			$rowsperpage = 20;
			$range = 1;
			$totalpages = ceil($rowCount[0] / $rowsperpage);
			$prevpage;
			$nextpage;
			// if not on page 1, don't show back links
			if($page > 1 ){
			   	echo "<li style='width:50px !important;' onclick='fncPageMainDepartment(1)'><< First</li>";
			   	$prevpage = $page - 1;
			   	echo "<li style='width:70px !important;' onclick='fncPageMainDepartment(". $prevpage .")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if(($x > 0) && ($x <= $totalpages)){
    			    if($x == $page){
                        echo "<li id='pgHouseRules" . $x . "' class='pgnumHouseRules active' onclick='fncPageMainDepartment(" . $x . ",". $x .")'>" . $x . "</li>";
                    }else{
    			        echo "<li id='pgHouseRules" . $x . "' class='pgnumHouseRules' onclick='fncPageMainDepartment(" . $x . ",". $x .")'>" . $x . "</li>";
                    }
		       	}
		    }
		    if($page < ($totalpages - $range)){
                echo "<li>...</li>";
            }
		    if($page != $totalpages && $rowCount[0] != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='fncPageMainDepartment(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='fncPageMainDepartment(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'selectedDepartmentCat':
			$sql = "SELECT code, description FROM tblmaintenance_department WHERE id = '". $_POST['id'] ."';";
			$res = mysql_query($sql, $connection);
			$row = mysql_fetch_array($res);
			echo $row[0] . "|" . $row[1];
		break;

		case 'clickDeleteDepartmentCat':
			$sql = "DELETE FROM tblmaintenance_department WHERE Code = '". $_POST['DepartmentCatCode'] ."';";
			$res = mysql_query($sql, $connection);
			if($res == true){
				echo 1;
			}
		break;

		case 'clickUpdateMainDepartment':
			$res = mysql_query("SELECT COUNT(Department) FROM tblref_employee WHERE Department = '". $_POST['DepartmentCatCode'] ."';");
			$row = mysql_fetch_array($res, $connection);
			if($row[0] >= 1){
				echo 1;
			}else{
				echo 0;
			}
		break;

		case 'AutoConsolidateDepartment':
			$dept2 = "SELECT code, description FROM tblmaintenance_department WHERE description LIKE '%". $_POST['key'] ."%' OR code LIKE '%". $_POST['key'] ."%' ORDER BY code ASC ";
			$resclassification = mysql_query($dept2, $connection);
			$data = "Code,Description\r\n";
			while($rowclassification = mysql_fetch_array($resclassification)){
				$data .= $rowclassification[0].",".$rowclassification[1]."\r\n";
			}
			$filepath = mysql_fetch_array(mysql_query("SELECT filepath FROM tblsys_setup", $connection));
			$syspath = str_replace("\\", "/", $filepath[0]);
			if (!file_exists($syspath)){
				mkdir($syspath, 0777, true);
			}
			$file = $syspath."EmployeeDepartment_".date('mdY').".csv";
			chmod($file, 0777);
			if (file_put_contents($file, $data)){
			create_logs_per_transaction('exported a referential to excel', 'DepartmentEmployee', '', '', 'EXPORT', '');
				echo 1;
			}else{
				echo 0;
			}
		break;
	}
 ?>