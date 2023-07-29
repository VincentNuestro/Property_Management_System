<?php
	session_start();
	include "../../../connect.php";
	switch ($_POST['form']) {
		case 'displayIndustry':
			$page = $_POST['page'];
			$limit = ($page-1) * 20;
			$res = mysql_query("SELECT Industry_ID, Industry, id FROM tblref_industry WHERE Industry LIKE '%". $_POST['key'] ."%' OR Industry_ID LIKE '%". $_POST['key'] ."%' GROUP BY Industry_ID ORDER BY ". $_POST['IndustrySortBy'] ." ". $_POST['IndustrySortType'] ." LIMIT ".$limit.",20;", $connection);
			while($row = mysql_fetch_array($res)){
				?>
					<tr id="<?php echo $row[2]; ?>">
						<td><?php echo $row[0]; ?></td>
						<td><?php echo utf8_encode($row[1]); ?></td>
					</tr>
				<?php
			}
			
		break;

		case 'loadEntriesIndustry':
			if($_POST["page"] == ""){
	            $page = 1;
	        }else{
	            $page = $_POST["page"];
	        }
    		$limit = ($page-1) * 20;
            $rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(Industry_ID) FROM tblref_industry WHERE Industry LIKE '%". $_POST['key'] ."%' OR Industry_ID LIKE '%". $_POST['key'] ."%';", $connection));
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

		case "loadPageIndustry":
			$page = $_POST["page"];
			$rowCount = mysql_fetch_row(mysql_query("SELECT COUNT(Industry_ID) FROM tblref_industry WHERE Industry LIKE '%". $_POST['key'] ."%' OR Industry_ID LIKE '%". $_POST['key'] ."%';", $connection));
			$rowsperpage = 20;
			$range = 1;
			$totalpages = ceil($rowCount[0] / $rowsperpage);
			$prevpage;
			$nextpage;
			// if not on page 1, don't show back links
			if($page > 1 ){
			   	echo "<li style='width:50px !important;' onclick='fncPageIndustry(1)'><< First</li>";
			   	$prevpage = $page - 1;
			   	echo "<li style='width:70px !important;' onclick='fncPageIndustry(". $prevpage .")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if(($x > 0) && ($x <= $totalpages)){
    			    if($x == $page){
                        echo "<li id='pgIndustry" . $x . "' class='pgnumIndustry active' onclick='fncPageIndustry(" . $x . ",". $x .")'>" . $x . "</li>";
                    }else{
    			        echo "<li id='pgIndustry" . $x . "' class='pgnumIndustry' onclick='fncPageIndustry(" . $x . ",". $x .")'>" . $x . "</li>";
                    }
		       	}
		    }
		    if($page < ($totalpages - $range)){
                echo "<li>...</li>";
            }
		    if($page != $totalpages && $rowCount[0] != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='fncPageIndustry(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='fncPageIndustry(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'selectedIndustry':
			$row = mysql_fetch_array(mysql_query("SELECT Industry_ID, Industry, id FROM tblref_industry WHERE id = '". $_POST['id'] ."';", $connection));
			echo $row[0] . "|" . utf8_encode($row[1]) . "|" . $row[2];
		break;

		case 'saveIndustry':
			//INSERT LOG FIRST - JONAS - 12/7/2018
			$arrHeader = ["Industry Code", "Industry Description"];
			$arrValue = [$_POST['industryCode'], $_POST['industryDesc']];
			$Logs = createXinfo("INSERT", $arrHeader, "", $arrValue, "", "", "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("added a new industry referential.", "Referential Module", $Logs, "" ,"ADD", "");
			}
			//INSERT LOG FIRST - JONAS - 12/7/2018
			$rowcheck = mysql_fetch_array(mysql_query("SELECT Industry_ID FROM tblref_industry WHERE Industry_ID = '". $_POST['industryCode'] ."';", $connection));
			if($rowcheck[0] == ""){
				// $rowdesc = mysql_fetch_array(mysql_query("SELECT Industry FROM tblref_industry WHERE Industry = '". $_POST['industryDesc'] ."';", $connection));
				if($rowdesc[0] == ""){
					$res = mysql_query("INSERT INTO tblref_industry SET Industry_ID = '". mysql_escape_string(strtoupper($_POST['industryCode'])) ."', Industry = '". mysql_escape_string(ucfirst($_POST['industryDesc'])) ."';", $connection);
					if($res == true){
						echo 1;
					}
				}
				// else{
				// 	echo "Industry Description already exist.";
				// }
			}else{
				echo "Industry Code already exist.";
			}
		break;

		case 'updateIndustry':
			//INSERT UPDATE LOG FIRST - JONAS - 12/7/2018
			$arrHeader = ["Industry Code", "Industry Description"];
			$arrFields = ["Industry_ID", "Industry"];
			$arrValue = [$_POST['industryCode'], $_POST['industryDesc']];
			$Logs = createXinfo("UPDATE", $arrHeader, $arrFields, $arrValue, "tblref_industry", $_POST['hiddenindustryid'], "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("modified an industry referential.", "Referential Module", $Logs, "" ,"UPDATE", "1");
			}
			//INSERT UPDATE LOG FIRST - JONAS - 12/7/2018
			$CurrentRef = mysql_fetch_array(mysql_query("SELECT Industry_ID, Industry FROM tblref_industry WHERE id = '". $_POST['hiddenindustryid'] ."';", $connection));
			$res = mysql_query("UPDATE tblref_industry SET Industry_ID = '". mysql_escape_string(strtoupper($_POST['industryCode'])) ."', Industry = '". mysql_escape_string(ucfirst($_POST['industryDesc'])) ."' WHERE id = '". $_POST['hiddenindustryid'] ."';", $connection);
			if($res == true){
				echo 1;
			}
		break;

		case 'deleteIndustry':
			//INSERT DELETE LOG FIRST - JONAS - 12/7/2018
			$arrHeader = ["Industry Code", "Industry Description"];
			$arrFields = ["Industry_ID", "Industry"];
			$Logs = createXinfo("DELETE", $arrHeader, $arrFields, "", "tblref_industry", $_POST['industryCode'], "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("deleted an industry referential.", "Referential Module", $Logs, "" ,"DELETE", "");
			}
			//INSERT DELETE LOG FIRST - JONAS - 12/7/2018
			$CurrentRef = mysql_fetch_array(mysql_query("SELECT Industry_ID, Industry FROM tblref_industry WHERE id = '". $_POST['industryCode'] ."';", $connection));
			$res = mysql_query("DELETE FROM tblref_industry WHERE id = '". $_POST['industryCode'] ."';", $connection);
			if($res == true){
				echo 1;
			}
		break;

		case 'clickUpdateIndustry':
			$row = mysql_fetch_array(mysql_query("SELECT COUNT(industry) FROM tbltrans_company WHERE industry = '". $_POST['industryCode'] ."';", $connection));
			if($row[0] >= 1){
				echo 1;
			}else{
				echo 0;
			}
		break;

		case 'AutoConsolidateIndustry':
			$Industryunit = "SELECT Industry_ID, Industry FROM tblref_industry WHERE Industry LIKE '%". $_POST['key'] ."%' OR Industry_ID LIKE '%". $_POST['key'] ."%' ORDER BY Industry ASC ";

			$resindustry = mysql_query($Industryunit, $connection);
			$data = "Industry_ID,Industry\r\n";
			while($rowindustry = mysql_fetch_array($resindustry)){
				$data .= $rowindustry[0].",".$rowindustry[1]."\r\n";
			}
			$filepath = mysql_fetch_array(mysql_query("SELECT filepath FROM tblsys_setup", $connection));
			$syspath = str_replace("\\", "/", $filepath[0]);
			if (!file_exists($syspath)){
				mkdir($syspath, 0777, true);
			}
			$file = $syspath."Unit_Industry_".date('mdY').".csv";
			chmod($file, 0777);
			if (file_put_contents($file, $data)){
			create_logs_per_transaction('exported a referential to excel', 'Unit Industry', '', '', 'EXPORT', '');
				echo 1;
			}else{
				echo 0;
			}
		break;
	}
?>