<?php
	session_start();
	include "../../../connect.php";
	switch ($_POST['form']) {
		case 'displayPaymentType':
			$page = $_POST['page'];
			$limit = ($page-1) * 20;
			$res = mysql_query("SELECT id, PaymentTypeID, PaymentTypeDesc, PaymentType FROM tblref_pospaymenttype WHERE PaymentTypeID LIKE '%". $_POST['key'] ."%' OR PaymentTypeDesc LIKE '%". $_POST['key'] ."%' GROUP BY PaymentTypeID ORDER BY ". $_POST['othPaymentSortBy'] ." ". $_POST['othPaymentSortType'] ." LIMIT ". $limit .",20;", $connection);
			while($row = mysql_fetch_array($res)){

				echo 	"<tr id='". $row['id'] ."'>
							<td>". $row['PaymentType'] ."</td>
							<td>". $row['PaymentTypeID'] ."</td>
							<td>". $row['PaymentTypeDesc'] ."</td>
						</tr>";
			}
		break;

		case 'loadEntriesPaymentType':
			if($_POST["page"] == ""){
	            $page = 1;
	        }else{
	            $page = $_POST["page"];
	        }
    		$limit = ($page-1) * 20;
            $rowCount = mysql_fetch_array(mysql_query("SELECT COUNT(PaymentTypeID) FROM tblref_pospaymenttype WHERE PaymentTypeID LIKE '%". $_POST['key'] ."%' OR PaymentTypeDesc LIKE '%". $_POST['key'] ."%';", $connection));
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

		case "loadPagePaymentType":
			$page = $_POST["page"];
			$rowCount = mysql_fetch_row(mysql_query("SELECT COUNT(PaymentTypeID) FROM tblref_pospaymenttype WHERE PaymentTypeID LIKE '%". $_POST['key'] ."%' OR PaymentTypeDesc LIKE '%". $_POST['key'] ."%';", $connection));
			$rowsperpage = 20;
			$range = 1;
			$totalpages = ceil($rowCount[0] / $rowsperpage);
			$prevpage;
			$nextpage;
			// if not on page 1, don't show back links
			if($page > 1 ){
			   	echo "<li style='width:50px !important;' onclick='fncPagePaymentType(1)'><< First</li>";
			   	$prevpage = $page - 1;
			   	echo "<li style='width:70px !important;' onclick='fncPagePaymentType(". $prevpage .")'>< Previous</li>";
			}
			for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
			   if(($x > 0) && ($x <= $totalpages)){
    			    if($x == $page){
                        echo "<li id='pgPaymentType" . $x . "' class='pgnumPaymentType active' onclick='fncPagePaymentType(" . $x . ",". $x .")'>" . $x . "</li>";
                    }else{
    			        echo "<li id='pgPaymentType" . $x . "' class='pgnumPaymentType' onclick='fncPagePaymentType(" . $x . ",". $x .")'>" . $x . "</li>";
                    }
		       	}
		    }
		    if($page < ($totalpages - $range)){
                echo "<li>...</li>";
            }
		    if($page != $totalpages && $rowCount[0] != 0){
		       	$nextpage = $page + 1;
		       	echo "<li style='width:50px !important;' onclick='fncPagePaymentType(". $nextpage .", ". $nextpage .")'>Next ></li>";
		       	echo "<li style='width:50px !important;' onclick='fncPagePaymentType(". $totalpages .", ". $totalpages .")'>Last >></li>";
		    }
		break;

		case 'selectedPaymentType':
			$row = mysql_fetch_array(mysql_query("SELECT PaymentTypeID, PaymentTypeDesc, PaymentType FROM tblref_pospaymenttype WHERE id = '". $_POST['id'] ."';", $connection));
			echo $row['PaymentType'] . "|" . $row['PaymentTypeID'] . "|" . $row['PaymentTypeDesc'];
		break;

		case 'fncSavePaymentType':
			$rowcheck = mysql_fetch_array(mysql_query("SELECT PaymentTypeID FROM tblref_pospaymenttype WHERE PaymentTypeID = '". $_POST['PaymentTypeCode'] ."';", $connection));
			if($rowcheck[0] == ""){
				$res = mysql_query("INSERT INTO tblref_pospaymenttype SET PaymentTypeID = '". mysql_escape_string(strtoupper($_POST['PaymentTypeCode'])) ."', PaymentTypeDesc = '". mysql_escape_string(ucfirst($_POST['PaymentTypeDesc'])) ."', PaymentType = '". $_POST['PaymentType'] ."';", $connection);
				if($res == true){
					echo 1;
					//INSERT LOG FIRST - JONAS - 12/5/2018
					$arrHeader = ["Payment Type", "Payment Type Code", "Payment Type Description"];
					$arrValue = [$_POST['PaymentType'], $_POST['PaymentTypeCode'], $_POST['PaymentTypeDesc']];
					$Logs = createXinfo("INSERT", $arrHeader, "", $arrValue, "", "", "");
					if($Logs != ""){
						$tran_logs = create_logs_per_transaction("added a payment type referential.", "Referential Module", $Logs, "" ,"ADD", "");
					}
					//INSERT LOG FIRST - JONAS - 12/5/2018
				}
			}else{
				echo "Payment Code already exist.";
			}
		break;

		case 'updatePaymentType':
			//INSERT UPDATE LOG FIRST - JONAS - 12/5/2018
			$arrHeader = ["Payment Type", "Payment Type Code", "Payment Type Description"];
			$arrValue = [$_POST['PaymentType'], $_POST['PaymentTypeCode'], $_POST['PaymentTypeDesc']];
			$Logs = createXinfo("UPDATE", $arrHeader, $arrFields, $arrValue, "tblref_pospaymenttype", $_POST['hiddenPaymentTypeid'], "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("modified a payment type referential.", "Referential Module", $Logs, "" ,"UPDATE", "");
			}
			//INSERT UPDATE LOG FIRST - JONAS - 12/5/2018
			$res = mysql_query("UPDATE tblref_pospaymenttype SET PaymentTypeID = '". mysql_escape_string(strtoupper($_POST['PaymentTypeCode'])) ."', PaymentTypeDesc = '". mysql_escape_string(ucfirst($_POST['PaymentTypeDesc'])) ."', PaymentType = '". $_POST['PaymentType'] ."' WHERE id = '". $_POST['hiddenPaymentTypeid'] ."';", $connection);
			if($res == true){
				echo 1;
			}
		break;

		case 'deleteBank':
			//INSERT DELETE LOG FIRST - JONAS - 12/5/2018
			$arrHeader = ["Payment Type", "Payment Type Code", "Payment Type Description"];
			$arrValue = [$_POST['PaymentType'], $_POST['PaymentTypeCode'], $_POST['PaymentTypeDesc']];
			$Logs = createXinfo("DELETE", $arrHeader, $arrFields, "", "tblref_pospaymenttype", $_POST['hiddenPaymentTypeid'], "");
			if($Logs != ""){
				$tran_logs = create_logs_per_transaction("deleted a bank referential.", "Referential Module", $Logs, "", "DELETE", "");
			}
			//INSERT DELETE LOG FIRST - JONAS - 12/5/2018
			$res = mysql_query("DELETE FROM tblref_pospaymenttype WHERE id = '". $_POST['hiddenPaymentTypeid'] ."';", $connection);
			if($res == true){
				echo 1;
			}
		break;

		case 'clickUpdatePaymentType':
			$tbltransaction = mysql_fetch_array(mysql_query("SELECT COUNT(xcode) FROM tbltransaction WHERE xcode = '". $_POST['PaymentCode'] ."'", $connection));
			if($tbltransaction[0] >= 1){
				echo 1;
			}else{
				echo 0;
			}
		break;

		case 'AutoConsolidatePaymentType':
			$Bank = "SELECT PaymentTypeID, PaymentTypeDesc, PaymentType FROM tblref_pospaymenttype WHERE PaymentTypeID LIKE '%". $_POST['key'] ."%' OR PaymentTypeDesc LIKE '%". $_POST['key'] ."%' ORDER BY PaymentTypeDesc ASC;";
			$resclassification = mysql_query($Bank, $connection);
			$data = "Payment Type,Payment Type Code, Payment Type Description\r\n";
			while($rowclassification = mysql_fetch_array($resclassification)){
				$data .= $rowclassification['PaymentType'].",".$rowclassification['PaymentTypeID'].",".$rowclassification['PaymentTypeDesc']."\r\n";
			}
			$filepath = mysql_fetch_array(mysql_query("SELECT filepath FROM tblsys_setup", $connection));
			$syspath = str_replace("\\", "/", $filepath[0]);
			if (!file_exists($syspath)){
				mkdir($syspath, 0777, true);
			}
			$file = $syspath."Payment_Type_".date('mdY').".csv";
			chmod($file, 0777);
			if (file_put_contents($file, $data)){
			create_logs_per_transaction('exported a referential to excel', 'Payment Type', '', '', 'EXPORT', '');
				echo 1;
			}else{
				echo 0;
			}
		break;
	}
?>