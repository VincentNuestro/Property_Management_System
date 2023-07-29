<?php 
session_start();
include "../../connect.php";
	switch ($_POST['form']) {
		case 'displayaudittrail':
            $page = $_POST['page'];
            $limit = ($page-1) * 20;
            if($_POST['filterbymodule'] == "" || $_POST['filterbymodule'] == "null"){
                $filterbymodule = "";
            }else{
                $filterbymodule = "AND module = '". $_POST['filterbymodule'] ."'";
            }
			$sql = "SELECT username, mytime, mydate, module, remarks, xinfo FROM tbllogs_per_trans WHERE mydate BETWEEN '". date('Y-m-d', strtotime($_POST['dateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['dateTo'])) ."' AND username LIKE '%". $_POST['txtaudittrail'] ."%' ". $filterbymodule ." ORDER BY timestamp desc LIMIT ". $limit .",20;";
			$res = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($res)){
				?>
				    <tr>		
    					<td><?php echo $row['username']; ?></td>
    					<td><?php echo date('h:i:A', strtotime($row['mytime'])); ?></td>
    					<td><?php echo date('m/d/Y', strtotime($row['mydate'])); ?></td>
    					<td><?php echo $row['module']; ?></td>
                        <td><?php echo $row['remarks']; ?></td>
    					<td><?php 
                            $arr = explode("|", $row['xinfo']);
                            for($x = 0; $x <= COUNT($arr)-2; $x++){
                                echo "<span class='fa fa-circle blue'></span>&nbsp;". $arr[$x] ."</br>";
                            }
                        ?></td>
                    </tr>
				<?php
			}
		break;

        case 'loadentries':
            if($_POST["page"] == ""){
                $page = 1;
            }else{
                $page = $_POST["page"];
            }
            $limit = ($page-1) * 20;
            if($_POST['filterbymodule'] == "" || $_POST['filterbymodule'] == "null"){
                $filterbymodule = "";
            }else{
                $filterbymodule = "AND module = '". $_POST['filterbymodule'] ."'";
            }
            $row = mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM tbllogs_per_trans WHERE mydate BETWEEN '". date('Y-m-d', strtotime($_POST['dateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['dateTo'])) ."' AND username LIKE '%". $_POST['txtaudittrail'] ."%' ". $filterbymodule .";", $connection));
            $rowsperpage = 20;
            $totalpages = ceil($row[0] / $rowsperpage);
            $upto = $limit + 20;
            $from = $limit + 1;
            if($page == $totalpages && $row[0] != 0){
                echo "Showing " . $from . " to " . $row[0] . " of " . $row[0] . " entries";
            }else{
                if($row[0] == 0){
                    echo "";
                }else if($row[0] <= 19 && $row[0] != 0){
                    echo "Showing 1 to " . $row[0] . " of " . $row[0] . " entries";
                }else if($row[0] >= 20 && $row[0] != 0){
                    echo "Showing " . $from . " to " . $upto . " of " . $row[0] . " entries";
                }
            }
        break;

        case "loadpageaudittrail":
            $page = $_POST["page"];
            if($_POST['filterbymodule'] == "" || $_POST['filterbymodule'] == "null"){
                $filterbymodule = "";
            }else{
                $filterbymodule = "AND module = '". $_POST['filterbymodule'] ."'";
            }
            $nums = mysql_fetch_row(mysql_query("SELECT COUNT(id) FROM tbllogs_per_trans WHERE mydate BETWEEN '". date('Y-m-d', strtotime($_POST['dateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['dateTo'])) ."' AND username LIKE '%". $_POST['txtaudittrail'] ."%' ". $filterbymodule .";", $connection));
            $num = $nums[0];
            $rowsperpage = 20;
            $range = 3;
            $totalpages = ceil($num / $rowsperpage);
            $prevpage;
            $nextpage;
            if($page > 1 ){
                echo "<li style='width:50px !important;' onclick='paginationAuditTrail(1)'><< First</li>";
                $prevpage = $page - 1;
                echo "<li style='width:70px !important;' onclick='paginationAuditTrail(". $prevpage .")'>< Previous</li>";
            }
            for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
                if (($x > 0) && ($x <= $totalpages)){
                    if ($x == $page){
                        echo "<li id='pgaudittrail" . $x . "' class='pgnumaudittrail active' onclick='paginationAuditTrail(" . $x . ",". $x .")'>" . $x . "</li>";
                    }else{
                        echo "<li id='pgaudittrail" . $x . "' class='pgnumaudittrail' onclick='paginationAuditTrail(" . $x . ",". $x .")'>" . $x . "</li>";
                    }
                }
            }
            if($page < ($totalpages - $range)){
                echo "<li>...</li>";
            }
            if ($page != $totalpages && $num != 0){
                $nextpage = $page + 1;
                echo "<li style='width:50px !important;' onclick='paginationAuditTrail(". $nextpage .", ". $nextpage .")'>Next ></li>";
                echo "<li style='width:50px !important;' onclick='paginationAuditTrail(". $totalpages .", ". $totalpages .")'>Last >></li>";
            }
        break;

		case 'printaudittrail':
			$sql = " SELECT username, mytime, mydate, module, xaction, xinfo FROM tbllogs_per_trans WHERE mydate BETWEEN '".date("Y-m-d", strtotime($_POST['dateFrom']))."' AND '".date("Y-m-d", strtotime($_POST['dateTo']))."' ORDER BY timestamp desc";
			$res = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($res)){
                echo        "<tr>
        		   				<td valign='top'>". $row['username'] ."</td>
        		   				<td valign='top'>". date('h:i:A', strtotime($row['mytime'])) ."</td>
        		   				<td valign='top'>". date('m/d/Y', strtotime($row['mydate'])) ."</td>
        		   				<td valign='top'>". $row['module'] ."</td>
        		   				<td valign='top'>". $row['xaction'] ."</td>
                                <td valign='top'>";
                                    $arr = explode("|", $row['xinfo']);
                                    for($x = 0; $x <= COUNT($arr)-2; $x++){
                                        echo "<span class='fa fa-circle' style='color: #478FCA;'></span>&nbsp;". $arr[$x] ."</br>";
                                    }
        		   		echo	"</td>
                            </tr>";
 			}
			echo "|" . date('F d, Y', strtotime($_POST['dateFrom'])) . "|" . date('F d, Y', strtotime($_POST['dateTo']));
		break;

        case 'loaddropdowndata':
            echo "<option value=''>All</option>";
            $sql = "SELECT DISTINCT(module) FROM tbllogs_per_trans;";
            $res = mysql_query($sql, $connection);
            while($row = mysql_fetch_array($res)){
                echo"<option value='". $row[0] ."'>".$row[0]."</option>";
            }
        break;
    }
?>