<?php 
	session_start();
	include "../../../connect.php";
	switch ($_POST['form']) {
		case 'displayEmployee': 
			$page = $_POST['page'];
			$limit = ($page-1) * 20;
			$sql = "SELECT id, mallid, Code, Position, First_Name, Middle_Name, Last_Name, Department, tenant_code, CASE WHEN xstatus = 1 THEN 'Active' WHEN xstatus = 0 THEN 'Inactive' END empstat, ximageid, remarks FROM tblref_employee WHERE Code LIKE '%". $_POST['key'] ."%' OR Position LIKE '%". $_POST['key'] ."%' OR First_Name LIKE '%". $_POST['key'] ."%' OR Middle_Name LIKE '%". $_POST['key'] ."%' OR Last_Name LIKE '%". $_POST['key'] ."%' LIMIT ". $limit .",20;";
			$res = mysql_query($sql, $connection);
			while ( $row = mysql_fetch_array($res) ) {
				$MallName = mysql_fetch_array(mysql_query("SELECT mallname FROM tblref_mall WHERE mallid = '". $row[1] ."' "));
				$UnitName = mysql_fetch_array(mysql_query("SELECT tradename FROM tbltrans_tenants WHERE tenantid = '". $row[8] ."';"));
				$Department = mysql_fetch_array(mysql_query("SELECT description FROM tblmaintenance_department WHERE code = '". $row[7] ."' "));
				$Position = mysql_fetch_array(mysql_query("SELECT xposition FROM tblref_companyposition WHERE EmpPositionCode = '". $row['Position'] ."';", $connection));
					if(!file_exists("../../../../Mall_Attachments/employee/".$row[2]."/".$row[10])){ 
	                    $Image = "assets/images/noimage5.png";
	                }else{
	                    $Image = "../Mall_Attachments/employee/".$row[2]."/".$row[10];
	                }
				?>
					<tr id="<?php echo $row[0]; ?>">
						<td><?php echo $MallName[0]; ?></td>
						<td><?php echo $row[8]; ?></td>
						<td><?php echo $row[2]; ?></td>
						<td><?php echo $Department[0]; ?></td>
						<td><?php echo $Position['xposition']; ?></td>
						<td><?php echo $row[4]; ?></td>
						<td><?php echo $row[5]; ?></td>
						<td><?php echo $row[6]; ?></td>
						<td><?php echo $row[9]; ?></td>
						<td style="width: 5%">
							<center>
								<div class="btn-group">
									<img src="">
									<button class="btn btn-default btn-round btn-sm" Title="PrintID" onclick="showidemp('<?php echo $row[4] ?>','<?php echo $row[5] ?>','<?php echo $row[6] ?>','<?php echo $row[2] ?>','<?php echo $row[3]?>','<?php echo $Department[0]?>', '<?php echo $MallName[0] ?>', '<?php echo " $Image "; ?>', '<?php echo $UnitName[0]?>'); printid();"> <img src='assets/images/printer.png' style='width: 100%; height: auto;' /></button>
								</div>
							</center>
						</td>
					</tr>
				<?php
			}
		break;
	
		case 'loadEntriesEmployee':
			if($_POST["page"] == ""){
	            $page = 1;
	        }else{
	            $page = $_POST["page"];
	        }
    		$limit = ($page-1) * 20;
            $rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM tblref_employee WHERE Code LIKE '%". $_POST['key'] ."%' OR Position LIKE '%". $_POST['key'] ."%' OR First_Name LIKE '%". $_POST['key'] ."%' OR Middle_Name LIKE '%". $_POST['key'] ."%' OR Last_Name LIKE '%". $_POST['key'] ."%';", $connection));
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

		case "loadPageEmployee":
			$page = $_POST["page"];
			$rowCount = mysql_fetch_row(mysql_query("SELECT COUNT(id) FROM tblref_employee WHERE Code LIKE '%". $_POST['key'] ."%' OR Position LIKE '%". $_POST['key'] ."%' OR First_Name LIKE '%". $_POST['key'] ."%' OR Middle_Name LIKE '%". $_POST['key'] ."%' OR Last_Name LIKE '%". $_POST['key'] ."%';", $connection));
			$rowsperpage = 20;
			$range = 1;
			$totalpages = ceil($rowCount[0] / $rowsperpage);
			$prevpage;
			$nextpage;
			// if not on page 1, don't show back links
			if($page > 1 ){
			   	echo "<li style='width:50px !important;' onclick='fncPageEmployee(1)'><< First</li>";
			   	$prevpage = $page - 1;
			   	echo "<li style='width:70px !important;' onclick='fncPageEmployee(". $prevpage .")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if(($x > 0) && ($x <= $totalpages)){
    			    if($x == $page){
                        echo "<li id='pgEmployee" . $x . "' class='pgnumEmployee active' onclick='fncPageEmployee(" . $x . ",". $x .")'>" . $x . "</li>";
                    }else{
    			        echo "<li id='pgEmployee" . $x . "' class='pgnumEmployee' onclick='fncPageEmployee(" . $x . ",". $x .")'>" . $x . "</li>";
                    }
		       	}
		    }
		    if($page < ($totalpages - $range)){
                echo "<li>...</li>";
            }
		    if($page != $totalpages && $rowCount[0] != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='fncPageEmployee(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='fncPageEmployee(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'selectedEmployee':
			$sql = "SELECT mallid, Code, Position, First_Name, Middle_Name, Last_Name, Department, tenant_code, xstatus,remarks,ximageid FROM tblref_employee WHERE id = '". $_POST['id'] ."' ";
			$res = mysql_query($sql, $connection);
			$row = mysql_fetch_array($res);
			if(!file_exists("../../../../Mall_Attachments/employee/".$row[1]."/".$row[10])){ 
	                    $Image = "assets/images/noimage5.png";
	                }else{
	                    $Image = "../Mall_Attachments/employee/".$row[1]."/".$row[10];
	        }
			echo $row[0] . "|" . $row[1] . "|" . $row[2] . "|" . $row[3] . "|" . $row[4] . "|" . $row[5] . "|" . $row[6] . "|" . $row[7] . "|" . $row[8] . "|" . $row[9]. "|" . $Image . "|" . $row[10];
			mysql_close($connection);
		break;
		
		case 'saveEmployee':
			$check = " SELECT Code FROM tblref_employee WHERE Code = '". $_POST['Code'] ."' ";
			$rescheck = mysql_query($check, $connection);
			$rowcheck = mysql_fetch_array($rescheck);
			if($rowcheck[0] == ""){


				$sql = " INSERT INTO tblref_employee SET mallid = '". $_POST['mallid'] ."', Code = '". mysql_escape_string(strtoupper($_POST['Code'])) ."', Position = '". $_POST['Position'] ."', First_Name = '". mysql_escape_string(ucfirst($_POST['firstname'])) ."', Middle_Name = '". mysql_escape_string(ucfirst($_POST['middlename'])) ."', Last_Name = '". mysql_escape_string(ucfirst($_POST['lastname'])) ."', Department = '". $_POST['department'] ."', tenant_code = '". $_POST['txttenantcode'] ."', xstatus = '". $_POST['empstat'] ."', remarks = '". $_POST['remarks'] ."'; ";
				$res = mysql_query($sql, $connection) or die(mysql_error());
				if($res == true){
					echo 1;
				} else {
					echo $sql;
				}
			}else{
				echo "Code already exist.";
			}
		break;

		case 'updateEmployee':
			$sql = " UPDATE tblref_employee SET mallid = '". $_POST['mallid'] ."', Code = '". mysql_escape_string(strtoupper($_POST['Code'])) ."', Position = '". $_POST['Position'] ."', First_Name = '". mysql_escape_string(ucfirst($_POST['firstname'])) ."', Middle_Name = '". mysql_escape_string(ucfirst($_POST['middlename'])) ."', Last_Name = '". mysql_escape_string(ucfirst($_POST['lastname'])) ."', Department = '". $_POST['department'] ."', tenant_code = '". $_POST['tenantcodeedit'] ."', xstatus = '". $_POST['xstat'] ."', remarks = '". $_POST['xrem'] ."' WHERE id = '". $_POST['id'] ."' ";
			$res = mysql_query($sql, $connection);
			if($res == true){
				echo 1;
			}
		break;

		case 'deleteEmployee':
			$sql = " DELETE FROM tblref_employee WHERE id = '". $_POST['id'] ."' ";
			$res = mysql_query($sql, $connection);
			if($res == true){
				echo 1;
			}
		break;

		case 'clickUpdateEmployee':
			$res = mysql_query("SELECT COUNT(ViolatorID) FROM tblmaintenance_hrviolators WHERE ViolatorID = '". $_POST['Code'] ."'");
			$row = mysql_fetch_array($res, $connection);
			if($row[0] >= 1){
				echo 1;
			}else{
				echo 0;
			}
		break;

		case 'showEmpDepartment':
			echo "<option value=''>-- Select Department --</option>";
			$res = mysql_query("SELECT code, description FROM tblmaintenance_department", $connection);
			while($row = mysql_fetch_array($res)){
				echo "<option value='".$row[0]."'>".$row[1]."</option>";
			}
		break;

		case 'showEmpPosition':
			echo "<option value=''>-- Select Employee --</option>";
			$res = mysql_query("SELECT EmpPositionCode, xposition FROM tblref_companyposition WHERE EmpDepCode = '". $_POST['Department'] ."';", $connection);
			while($row = mysql_fetch_array($res)){
				echo "<option value='".$row[0]."'>".$row[1]."</option>";
			}
		break;

		case 'showEmpStatus':
			echo "<option value=''>-- Select Status --</option>";
			$res = mysql_query("SELECT code, description FROM tblmaintenance_department", $connection);
			while($row = mysql_fetch_array($res)){
				echo "<option value='".$row[0]."'>".$row[1]."</option>";
			}
		break;

		case 'showTenantcode':
			// echo "<option value=''>-- Select Tenant ID --</option>";
			$res = mysql_query("SELECT TenantID, tradename FROM tbltrans_tenants WHERE STATUS = 'Active' OR STATUS = 'ForEviction' OR STATUS = 'ForRenewal';", $connection);
			while($row = mysql_fetch_array($res)){
				echo "<option value='".$row[0]."'>".$row[1]."</option>";
			}
		break;

		case 'AutoConsolidateEmployee':
			$Classification = "SELECT id, mallid, Code, Position, First_Name, Middle_Name, Last_Name, Department FROM tblref_employee WHERE Code LIKE '%". $_POST['key'] ."%' OR Position LIKE '%". $_POST['key'] ."%' OR First_Name LIKE '%". $_POST['key'] ."%' OR Middle_Name LIKE '%". $_POST['key'] ."%' OR Last_Name LIKE '%". $_POST['key'] ."%' ";
			$resclassification = mysql_query($Classification, $connection);
			$data = "AssignedBuilding,Code,Department,Position,FirstName,MiddleName,LastName\r\n";
			while($rowclassification = mysql_fetch_array($resclassification)){
				$data .= $rowclassification[1].",".$rowclassification[2].",".$rowclassification[7].",".$rowclassification[3].",".$rowclassification[4].",".$rowclassification[5].",".$rowclassification[6]."\r\n";
			}
			$filepath = mysql_fetch_array(mysql_query("SELECT filepath FROM tblsys_setup", $connection));
			$syspath = str_replace("\\", "/", $filepath[0]);
			if (!file_exists($syspath)){
				mkdir($syspath, 0777, true);
			}
			$file = $syspath."Employee_".date('mdY').".csv";
			chmod($file, 0777);
			if (file_put_contents($file, $data)){
				create_logs_per_transaction('exported a referential to excel', 'Employee', '', '', 'EXPORT', '');
				echo 1;
			}else{
				echo 0;
			}
		break;
	}
?>