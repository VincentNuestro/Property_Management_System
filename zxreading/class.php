<?php 
	session_start();
	include "../connect.php";
	switch ($_POST['form']) {
		case 'showxreading':
			$cursysdate = mysql_fetch_array(mysql_query("SELECT eoddate FROM tbltrans_eod ORDER BY id DESC", $connection));
			$gsales = 0;
			$cashsales = 0;
			$checksales = 0;
			$cardsales = 0;
			$banksales = 0;
			$machineno = "";

			$sqlcompany = "SELECT corporatename, address, TIN_number, Machine_No, Telephone_Number FROM tblsys_setup";
			$rescompany = mysql_query($sqlcompany, $connection);
			$rowcompany = mysql_fetch_array($rescompany);

			if($_POST['alucard'] == ""){
				$machineno = "";
			}else{
				$machineno = '<label>Terminal :&nbsp;</label>'.$rowcompany[3];
			}

			// DISPLAY USER
			$sqluser = " SELECT CONCAT(firstname, ' ', LEFT(middlename, 1), '. ', lastname) FROM tbluser WHERE userid = '". $_SESSION['MMS-UserID'] ."' ";
			$resuser = mysql_query($sqluser, $connection);
			$rowuser = mysql_fetch_array($resuser);

			// DISPLAY BANKS
			$sqlbankname = " SELECT DISTINCT(bankname) FROM tbltransaction WHERE bankname != '' ";
			$resbankname = mysql_query($sqlbankname, $connection);
			while($rowbankname = mysql_fetch_array($resbankname)){

				if($_POST['alucard'] != ""){
					$sqlsalesofbnk = " SELECT sum(amount) FROM tbltransaction WHERE bankname = '". $rowbankname[0] ."' AND paymenttype = 'Check' AND Machine_No = '". $_POST['alucard'] ."' AND xdatetime LIKE '%". date('Y-m-d', strtotime($cursysdate[0])) ."%' ";
				}
				else{
					$sqlsalesofbnk = " SELECT sum(amount) FROM tbltransaction WHERE bankname = '". $rowbankname[0] ."' AND paymenttype = 'Check' AND xdatetime LIKE '%". date('Y-m-d', strtotime($cursysdate[0])) ."%' ";
				}
				$ressalesofbnk = mysql_query($sqlsalesofbnk, $connection);
				while($rowsalesofbnk = mysql_fetch_array($ressalesofbnk)){

					$arr = explode("-", $rowsalesofbnk[0]);

				$bank .= "
							<tr style='text-indent: 20px;'>
                                <td><strong>".$rowbankname[0]."</strong></td>
                                <td align='right'>".number_format($arr[1], 2, '.', ',')."</td>
                            </tr>
						";
				}
			}

			// DISPLAY CARD TYPES!
			$sqlcardtype = " SELECT DISTINCT(cardtype) FROM tbltransaction WHERE cardtype != ''";
			$rescardtype = mysql_query($sqlcardtype, $connection);
			while($rowcardtype = mysql_fetch_array($rescardtype)){

				if($_POST['alucard'] != ""){
					$sqlsalespercard = " SELECT SUM(amount) FROM tbltransaction WHERE cardtype = '". $rowcardtype[0] ."' AND paymenttype = 'Card' AND xdatetime LIKE '%". date('Y-m-d', strtotime($cursysdate[0])) ."%' AND Machine_No = '". $_POST['alucard'] ."' ";
				}
				else{
					$sqlsalespercard = " SELECT SUM(amount) FROM tbltransaction WHERE cardtype = '". $rowcardtype[0] ."' AND paymenttype = 'Card' AND xdatetime LIKE '%". date('Y-m-d', strtotime($cursysdate[0])) ."%' ";
				}
				$ressalespercard  = mysql_query($sqlsalespercard, $connection);
				while($rowsalespercard = mysql_fetch_array($ressalespercard)){
					$arr = explode("-", $rowsalespercard[0]);

					$card .= "
								<tr style='text-indent: 20px;'>
	                                <td><strong>".$rowcardtype[0]."</strong></td>
	                                <td align='right'>".number_format($arr[1], 2, '.', ',')."</td>
                            	</tr>
							";
				}
			}

			// DISPLAY SALES WITH PAYMENT TYPE AS CASH
			if($_POST['alucard'] != ""){
				$sqlcash = " SELECT amount FROM tbltransaction WHERE paymenttype = 'Cash' AND Machine_No = '". $_POST['alucard'] ."' AND xdatetime LIKE '%". date('Y-m-d', strtotime($cursysdate[0])) ."%' ";
			}
			else{
				$sqlcash = " SELECT amount FROM tbltransaction WHERE paymenttype = 'Cash' AND xdatetime LIKE '%". date('Y-m-d', strtotime($cursysdate[0])) ."%' ";
			}
			$rescash = mysql_query($sqlcash, $connection);
			while($rowcash = mysql_fetch_array($rescash)){
				$arr = explode("-", $rowcash[0]);
				$cashsales = $cashsales + $arr[1];
			}

			// DISPLAY SALES WITH PAYMENT TYPE AS CHECK
			if($_POST['alucard'] != ""){
				$sqlcheck = " SELECT amount FROM tbltransaction WHERE paymenttype = 'Check' AND Machine_No = '". $_POST['alucard'] ."' AND xdatetime LIKE '%". date('Y-m-d', strtotime($cursysdate[0])) ."%' ";
			}
			else{
				$sqlcheck = " SELECT amount FROM tbltransaction WHERE paymenttype = 'Check' AND xdatetime LIKE '%". date('Y-m-d', strtotime($cursysdate[0])) ."%' ";
			}
			$rescheck = mysql_query($sqlcheck, $connection);
			while($rowcheck = mysql_fetch_array($rescheck)){
				$arr = explode("-", $rowcheck[0]);
				$checksales = $checksales + $arr[1];
			}

			// DISPLAY SALES WITH PAYMENT TYPE AS CARD
			if($_POST['alucard'] != ""){
				$sqlcard = " SELECT amount FROM tbltransaction WHERE paymenttype = 'Card' AND Machine_No = '". $_POST['alucard'] ."' AND xdatetime LIKE '%". date('Y-m-d', strtotime($cursysdate[0])) ."%' ";
			}
			else{
				$sqlcard = " SELECT amount FROM tbltransaction WHERE paymenttype = 'Card' AND xdatetime LIKE '%". date('Y-m-d', strtotime($cursysdate[0])) ."%' ";
			}
			$rescard = mysql_query($sqlcard, $connection);
			while($rowcard = mysql_fetch_array($rescard)){
				$arr = explode("-", $rowcard[0]);
				$cardsales = $cardsales + $arr[1];
			}

			// <<<<<=====SALES=====>>>>>
			if($_POST['alucard'] != ""){
				$sqlgross = " SELECT amount FROM tbltransaction WHERE paymenttype != '' AND Machine_No = '". $_POST['alucard'] ."' AND xdatetime LIKE '%". date('Y-m-d', strtotime($cursysdate[0])) ."%' ";
			}
			else{
				$sqlgross = " SELECT amount FROM tbltransaction WHERE paymenttype != '' AND xdatetime LIKE '%". date('Y-m-d', strtotime($cursysdate[0])) ."%' ";
			}
			$resgross = mysql_query($sqlgross, $connection);
			while($rowgross = mysql_fetch_array($resgross)){
				$arr = explode("-", $rowgross[0]);
				$gsales = $gsales + $arr[1];
			}

			// <<<<<=====SALES=====>>>>>
			echo number_format($gsales, 2, '.', ',') . "|" . $rowuser[0] . "|" . number_format($checksales, 2, '.', ',') . "|" . $bank . "|" . number_format($cashsales, 2, '.', ',') . "|" . $rowcompany[0] . "|" . $_POST['alucard'] . "|" . $rowcompany[1] . "|" . $rowcompany[2] . "|" . $machineno . "|" . $rowcompany[4] . "|" . number_format($cardsales, 2, '.', ',') . "|" . $card;
		break;

		case 'showzreading':
			$gsales = 0;
			$cashsales = 0;
			$checksales = 0;
			$cardsales = 0;
			$cursysdate = mysql_fetch_array(mysql_query("SELECT eoddate FROM tbltrans_eod ORDER BY id DESC", $connection));

			$sqlcompany = "SELECT corporatename, address, TIN_number, Machine_No, Telephone_Number FROM tblsys_setup";
			$rescompany = mysql_query($sqlcompany, $connection);
			$rowcompany = mysql_fetch_array($rescompany);

			if($_POST['alucard'] == ""){
				$machineno = "";
			}else{
				$machineno = '<label>Terminal :&nbsp;</label>'.$rowcompany[3];
			}

			// DISPLAY USER
			$sqluser = " SELECT CONCAT(firstname, ' ', LEFT(middlename, 1), '. ', lastname) FROM tbluser WHERE userid = '". $_SESSION['MMS-UserID'] ."' ";
			$resuser = mysql_query($sqluser, $connection);
			$rowuser = mysql_fetch_array($resuser); 

			// GROSS SALES
			if($_POST['alucard'] != ""){
				$sqlgross = " SELECT amount FROM tbltransaction WHERE paymenttype != '' AND Machine_No = '". $_POST['alucard'] ."' AND xdatetime LIKE '%". date('Y-m-d', strtotime($cursysdate[0])) ."%' ";
			}
			else{
				$sqlgross = " SELECT amount FROM tbltransaction WHERE paymenttype != '' AND xdatetime LIKE '%". date('Y-m-d', strtotime($cursysdate[0])) ."%' ";
			}
			$resgross = mysql_query($sqlgross, $connection);
			while($rowgross = mysql_fetch_array($resgross)){
				$arr = explode("-", $rowgross[0]);
				$gsales = $gsales + $arr[1];
			}

			// DISPLAY SALES WITH PAYMENT TYPE AS CASH
			$sqlcash = " SELECT amount FROM tbltransaction WHERE paymenttype = 'Cash' AND xdatetime LIKE '%". date('Y-m-d', strtotime($cursysdate[0])) ."%' ";
			$rescash = mysql_query($sqlcash, $connection);
			while($rowcash = mysql_fetch_array($rescash)){
				$arr = explode("-", $rowcash[0]);
				$cashsales = $cashsales + $arr[1];
			}

			// DISPLAY SALES WITH PAYMENT TYPE AS CHECK
			$sqlcheck = " SELECT amount FROM tbltransaction WHERE paymenttype = 'Check' AND xdatetime LIKE '%". date('Y-m-d', strtotime($cursysdate[0])) ."%' ";
			$rescheck = mysql_query($sqlcheck, $connection);
			while($rowcheck = mysql_fetch_array($rescheck)){
				$arr = explode("-", $rowcheck[0]);
				$checksales = $checksales + $arr[1];
			}

			// DISPLAY SALES WITH PAYMENT TYPE AS CARD
			$sqlcard = " SELECT amount FROM tbltransaction WHERE paymenttype = 'Card' AND xdatetime LIKE '%". date('Y-m-d', strtotime($cursysdate[0])) ."%' ";
			$rescard = mysql_query($sqlcard, $connection);
			while($rowcard = mysql_fetch_array($rescard)){
				$arr = explode("-", $rowcard[0]);
				$cardsales = $cardsales + $arr[1];
			}

			// DISPLAY BANKS
			$sqlbankname = " SELECT DISTINCT(bankname) FROM tbltransaction WHERE bankname != '' ";
			$resbankname = mysql_query($sqlbankname, $connection);
			while($rowbankname = mysql_fetch_array($resbankname)){

				$sqlsalesofbnk = " SELECT sum(amount) FROM tbltransaction WHERE bankname = '". $rowbankname[0] ."' AND paymenttype = 'Check' AND xdatetime LIKE '%". date('Y-m-d', strtotime($cursysdate[0])) ."%' ";
				$ressalesofbnk = mysql_query($sqlsalesofbnk, $connection);
				while($rowsalesofbnk = mysql_fetch_array($ressalesofbnk)){

					$arr = explode("-", $rowsalesofbnk[0]);

				$bank .= "
							<tr style='text-indent: 20px;'>
                                <td><strong>".$rowbankname[0]."</strong></td>
                                <td align='right'>".number_format($arr[1], 2, '.', ',')."</td>
                            </tr>
						";
				}
			}

			// DISPLAY CARD TYPES!
			$sqlcardtype = " SELECT DISTINCT(cardtype) FROM tbltransaction WHERE cardtype != ''";
			$rescardtype = mysql_query($sqlcardtype, $connection);
			while($rowcardtype = mysql_fetch_array($rescardtype)){

				$sqlsalespercard = " SELECT SUM(amount) FROM tbltransaction WHERE cardtype = '". $rowcardtype[0] ."' AND paymenttype = 'Card' AND xdatetime LIKE '%". date('Y-m-d', strtotime($cursysdate[0])) ."%' ";
				$ressalespercard  = mysql_query($sqlsalespercard, $connection);
				while($rowsalespercard = mysql_fetch_array($ressalespercard)){
					$arr = explode("-", $rowsalespercard[0]);

					$card .= "
								<tr style='text-indent: 20px;'>
	                                <td><strong>".$rowcardtype[0]."</strong></td>
	                                <td align='right'>".number_format($arr[1], 2, '.', ',')."</td>
                            	</tr>
							";
				}
			}

			echo $rowcompany[0] . "|" . $rowcompany[1] . "|" . $rowcompany[2] . "|" . $rowcompany[4] . "|" . number_format($gsales, 2, '.', ',') . "|" . number_format($cashsales, 2, '.', ',') . "|" . number_format($checksales, 2, '.', ',') . "|" . number_format($cardsales, 2, '.', ',') . "|" . $card . "|" . $bank . "|"  . $rowuser[0];
		
		break;

		case 'trapzreading':
			$sqlzreadingstat = " SELECT zreadingstat FROM tblforzreading ";
			$reszreadingstat = mysql_query($sqlzreadingstat, $connection);
			$rowzreadingstat = mysql_fetch_array($reszreadingstat);

			if($rowzreadingstat[0] == '1'){
				echo "1"."|"."Z Reading is already printed.";
			}else{
			$sqlsetup = " SELECT Machine_No FROM tblsys_setup ";
			$ressetup = mysql_query($sqlsetup, $connection);
			$rowsetup = mysql_fetch_array($ressetup);

			$sqlopmachine = " SELECT COUNT(Machine_No) FROM tblloggedmachine WHERE Onprocess = '1' AND Machine_No != '". $rowsetup[0] ."' ";
			$resopmachine = mysql_query($sqlopmachine, $connection);
			$rowopmachine = mysql_fetch_array($resopmachine);

				if($rowopmachine[0] == '0'){
					echo 0;
				}else{
				echo "2"."|"."Some machine are still in use continue anyway?";
				}
			}
		break;

		case 'showmachinenumber':
			echo "<option value=''>Select Machine Number</option>";
			$sql = " SELECT Machine_No FROM tblmachine ";
			$res = mysql_query($sql, $connection);
			while ($row = mysql_fetch_array($res)) {
				echo "<option value='".$row[0]."'>".$row[0]."</option>";
			}
		break;

		case 'showprintofx':
			$cursysdate = mysql_fetch_array(mysql_query("SELECT eoddate FROM tbltrans_eod ORDER BY id DESC", $connection));
			$xlogid = createidno("X", "tblxreadinglogs", "XLogID");
			$sql = " INSERT INTO tblxreadinglogs SET XLogID = '". $xlogid ."', xsystemdate = '". date('Y-m-d', strtotime($cursysdate[0]))." ". date('H:i:s') ."', xcomputerdate = '". date('Y-m-d H:i:s') ."', xuser = '". $_SESSION['MMS-UserID'] ."' ";
			$res = mysql_query($sql, $connection);
			$row = mysql_fetch_array($res);
		break;

		case 'showprintofz':
			$cursysdate = mysql_fetch_array(mysql_query("SELECT eoddate FROM tbltrans_eod ORDER BY id DESC", $connection));
			$zlogid = createidno("Z", "tblzreadinglogs", "ZLogID");
			$sql = " INSERT INTO tblzreadinglogs SET ZLogID = '". $zlogid ."', zsystemdate = '". date('Y-m-d', strtotime($cursysdate[0]))." ". date('H:i:s') ."', zcomputerdate = '". date('Y-m-d H:i:s') ."', zuser = '". $_SESSION['MMS-UserID'] ."' ";
			$res = mysql_query($sql, $connection);
			$row = mysql_fetch_array($res);

			$sqlz = " UPDATE tblforzreading SET Zreading = '0' AND Zreadingstat = '1' ";
			$resz = mysql_query($sqlz, $connection);
			$rowz = mysql_fetch_array($resz);
		break;

		case 'forcelogout':
			$sqlsetup = " SELECT Machine_No FROM tblsys_setup ";
			$ressetup = mysql_query($sqlsetup, $connection);
			$rowsetup = mysql_fetch_array($ressetup);

			$sql = " UPDATE tblloggedmachine SET Onprocess = '0' WHERE Machine_No != '". $rowsetup[0] ."' ";
			$res = mysql_query($sql, $connection);
			$row = mysql_fetch_array($res);

			$sqlz = " UPDATE tblforzreading SET Zreading ='1' ";
			$resz = mysql_query($sqlz, $connection);
			$rowz = mysql_fetch_array($resz);

			$sql3 = " UPDATE tbluser SET loginstat = '0' WHERE userid != '". $_SESSION['MMS-UserID'] ."' ";
			$res3 = mysql_query($sql3, $connection);
			$row3 = mysql_fetch_array($res3);

			$sql2 = " UPDATE tblforzreading SET Zreading = '1' ";
			$res2 = mysql_query($sql2, $connection);
			$row3 = mysql_fetch_array($res2);
		break;

		case 'getcookie':
			echo $_SESSION['MMS-UserID'];
		break;

		case 'selectbasehan':
			$sql = " SELECT userid FROM tbluser WHERE loginstat = '1' ";
			$res = mysql_query($sql, $connection);
			$row = mysql_fetch_array($res);
			echo $row[0];
		break;

		case 'deletecookie':
			$sql = " SELECT Zreading FROM tblforzreading ";
			$res = mysql_query($sql, $connection);
			$row = mysql_fetch_array($res);
			echo $row[0];
		break;
	}	
?>