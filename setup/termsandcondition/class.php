<?php 
	session_start();
	include("../../connect.php");
	switch ($_POST['form']) {
		case 'addnewgroup':
			$groupname = $_POST['txttac_group'];
			$newid = createidno("GRP", "tblgroups", "Group_ID");
			$row = mysql_fetch_array(mysql_query("SELECT COUNT(Group_Name) FROM tblgroups WHERE Group_Name = '". $groupname ."';", $connection));
			if($row[0] == 0){
				$setid = " INSERT INTO tblgroups SET Group_ID = '". $newid ."', Group_Name = '". $_POST['txttac_group'] ."' ";
				$resultnew = mysql_query($setid, $connection);
				if($resultnew == true){
					echo 1;
				}
			}else {
				echo "The Group Name you entered is already existing.";
			}
		break;

		case 'saveterms':
			$termid = $_POST['txttac_terms'];
			$newid = createidno("TRN", "tblterms", "Term_No");
			$row = mysql_fetch_array(mysql_query("SELECT Group_Name FROM tblgroups WHERE Group_ID = '". $_POST['groupid'] ."';", $connection));
			$res2 = mysql_query("INSERT INTO tblterms SET Term_Name = '". mysql_real_escape_string($_POST['terms']) ."', Term_No = '". $newid ."', Group_ID = '". $_POST['groupid'] ."', Group_Name = '". $row[0] ."';", $connection) or die(mysql_error());
			if($res2 == true){
				$sql3 = "INSERT INTO tblcondition SET Term_ID = '". $newid ."', Term_Name = '". mysql_real_escape_string($_POST['terms']) ."', Description = '". mysql_real_escape_string($_POST['condition']) ."', Group_ID = '". $_POST['groupid'] ."', Group_Name = '". $row[0] ."';";
				$res3 = mysql_query($sql3, $connection);
				if($res3 == true){
					echo 1;
				}
			}
		break;

		case 'displaygroup':
			$page = $_POST['page'];
			$limit = ($page-1) * 20;
			if($_POST['groupname'] == "" || $_POST['groupname'] == null){
				$filter == "";
			}else{
				$filter = "AND Group_ID = '". $_POST['groupname'] ."'";
			}
			$res = mysql_query("SELECT Group_ID, Group_Name, Term_Name, Description, Stats, Term_ID FROM tblcondition WHERE ( Group_Name LIKE '%". $_POST['txttermsanconditionsearch'] ."%' OR Term_Name LIKE '%". $_POST['txttermsanconditionsearch'] ."%' OR Description LIKE '%". $_POST['txttermsanconditionsearch'] ."%') ".$info." ORDER BY STATS DESC LIMIT ".$limit.",20;", $connection) or die(mysql_error());
			while($row = mysql_fetch_array($res)){
				?>
					<tr  id="<?php echo $row[5]; ?>">		
						<td style="vertical-align: middle;" width="20%" class="groupname" ><?php echo $row[1]; ?></td>
						<td style="vertical-align: middle;" width="20%" class="tername"><?php echo $row[2]; ?></td>
						<td style="vertical-align: middle;" width="50%" class="condition"><?php echo $row[3]; ?></td>
						<td style="vertical-align: middle;" width="5%"><?php 
							if( $row[4] == 1 )	{	?>
								<span class="label label-lg label-success arrowed-in-right arrowed" style="z-index: 0;"><?php echo "Active"; ?></span>
							<?php 	}
							else {	?>
								<span class="label label-lg label-danger arrowed-in-right arrowed" style="z-index: 0;"><?php echo "Inactive"; ?></span>
							<?php 	}	?>
						</td>
						<input type="hidden" class="groupid" value="<?php echo $row[0]; ?>">
						<input type="hidden" class="statuss" value="<?php echo $row[4]; ?>">
						<td style="vertical-align: middle;" class='center' width="5%">
							<div class='btn-group'>
								<button class='btn btn-sm btn-info hide isadmin select-edittermsandconditions btn-round' style='z-index: 0;margin: 2px;' onclick='loadmodal_editgroup("<?php echo $row[5]; ?>", "<?php echo $row[0]; ?>")' id="edit" title='Edit'>
									<i class='fa fa-edit'></i>
								</button>
							</div>
						</td>
					</tr>			
				<?php	
			}
		break;

		case 'updategroup':
			$arr = explode("|", $_POST['id']);
			$res = mysql_query("UPDATE tblgroups SET Group_Name = '". mysql_real_escape_string($_POST['groupid']) ."' WHERE Group_ID = '". $arr[1] ."';", $connection);
			if($res == true){
				$res2 = mysql_query("UPDATE tblterms SET Term_Name = '". mysql_real_escape_string($_POST['terms']) ."', Group_ID = '". $arr[1] ."', Group_Name = '". mysql_real_escape_string($row[0]) ."' WHERE Term_No = '". $arr[0] ."';", $connection);
				if($res2 == true){
					$res3 = mysql_query("UPDATE tblcondition SET Group_Name = '". mysql_real_escape_string($_POST['groupid']) ."', Term_Name = '". mysql_real_escape_string($_POST['terms']) ."', Description = '". mysql_real_escape_string($_POST['condition']) ."', Stats = '". $_POST['stats'] ."' WHERE Term_ID = '". $arr[0] ."';", $connection);
					if($res3 == true){
						echo 1;
					}
				}
			}
		break;

		case 'displaygroupname':
			echo "<option value='' selected disabled>-- Select Group --</option>";
            $result = mysql_query("SELECT Group_ID, Group_Name FROM tblgroups;", $connection);
            while($row = mysql_fetch_array($result)){
                echo"<option value='". $row[0] ."'>".$row[1]."</option>";
            }
        break;
	
		case 'selectgroup':
			$row = mysql_fetch_array(mysql_query("SELECT Term_Name, Description FROM tblcondition WHERE Group_ID = '" .$_POST['id']. "';", $connection));
			echo $row[0] ."|". $row[1];
		break;
	
		case 'selectgroup2':
			$row = mysql_fetch_array(mysql_query("SELECT Term_Name, Description FROM tblcondition WHERE Group_ID = '" .$_POST['id']. "';", $connection));
			echo $row[0] ."|". $row[1];
		break;

		case 'filterbygroup2':
			echo "<option value=''>All</option>";
            $result = mysql_query("SELECT Group_ID, Group_Name FROM tblgroups;", $connection);
            while($row = mysql_fetch_array($result)){
                echo"<option value='". $row[0] ."'>".$row[1]."</option>";
            }
        break;

        case 'loadentries':
        	if($_POST['groupname'] == "" || $_POST['groupname'] == null){
				$groupname = "";
			}else{
				$groupname = "AND (Group_ID = '". $_POST['groupname'] ."')";
			}
           	if($_POST["page"] == ""){
               $page = 1;
           	}else{
               $page = $_POST["page"];
           	}
           	$limit = ($page-1) * 20;
            $rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM tblcondition WHERE ( Group_Name LIKE '%".$_POST['txttermsanconditionsearch']."%' OR Term_Name LIKE '%".$_POST['txttermsanconditionsearch']."%' OR Description LIKE '%".$_POST['txttermsanconditionsearch']."%') ".$groupname.";", $connection));
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

		case "loadpagetac":
           	if($_POST['groupname'] == "" || $_POST['groupname'] == null){
				$groupname = "";
			}else{
				$groupname = "AND (Group_ID = '". $_POST['groupname'] ."')";
			}
		    $statmo = " Stats LIKE '%".$_POST['jstat']."%' ";
		    $page = $_POST["page"];
			$nums = mysql_fetch_row(mysql_query("SELECT COUNT(*) FROM tblcondition WHERE ( Group_Name LIKE '%".$_POST['txttermsanconditionsearch']."%' OR Term_Name LIKE '%".$_POST['txttermsanconditionsearch']."%' OR Description LIKE '%".$_POST['txttermsanconditionsearch']."%') ".$groupname.";", $connection));
			$num = $nums[0];
			$rowsperpage = 20;
			$range = 3;
			$totalpages = ceil($num / $rowsperpage);
			$prevpage;
			$nextpage;
		    if($page > 1 ){
			   echo "<li style='width:50px !important;' onclick='pagination(1)'><< First</li>";
			   $prevpage = $page - 1;
			   echo "<li style='width:70px !important;' onclick='pagination(". $prevpage .")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   	if (($x > 0) && ($x <= $totalpages)){
			      	if ($x == $page){ 
				   		echo "<li id='pgtac" . $x . "' class='pgnumtac active' onclick='pagination(" . $x . ",". $x .")'>" . $x . "</li>"; 
				   	}else{
						echo "<li id='pgtac" . $x . "' class='pgnumtac' onclick='pagination(" . $x . ",". $x .")'>" . $x . "</li>"; 
					}
			    }
			}
		    if($page < ($totalpages - $range)){ 
		    	echo "<li>...</li>"; 
		    }
		    if ($page != $totalpages && $num != 0){
		       $nextpage = $page + 1;
		       echo "<li style='width:50px !important;' onclick='pagination(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       echo "<li style='width:50px !important;' onclick='pagination(". $totalpages .", ". $totalpages .")'>Last >></li>";
			}
		break;

		case 'loadeditgroup':
			$row = mysql_fetch_array(mysql_query("SELECT Group_ID, Group_Name, Term_Name, Description, Stats FROM tblcondition WHERE TERM_ID = '". $_POST['getid'] ."';", $connection));
			echo $row[0]. "|" . $row[1] . "|" . $row[2] . "|" . $row[3] . "|" . $row[4];
		break;
	}
?>