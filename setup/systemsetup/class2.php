<?php
	include "../../connect.php";

	switch ($_POST['form']) {
		case 'uploadMall':
			$arr = explode("#||", $_POST['csvDetails']);
			$uploadResult = 1;

			$getUpload = " SELECT mall FROM tblref_csv_upload; ";
			$resUpload = mysql_query($getUpload, $connection);
			$rowUpload = mysql_fetch_array($resUpload);

			if ( $rowUpload[0] == 0 ) {
				for ( $a = 1; $a <= COUNT($arr)-1; $a++ ) {
					$arr2 = explode("|||", $arr[$a]);

					$sql = " INSERT INTO tblref_mall SET mallid = '". $arr2[0] ."', mallname = '". $arr2[1] ."', malladdress = '". mysql_real_escape_string($arr2[2]) ."', abouts = '". mysql_real_escape_string($arr2[3]) ."',  dateadded = '". date('Y-m-d') ."', telephone_number = '". $arr2[4] ."', email = '". $arr2[5] ."', mallstat = '". $arr2[6] ."', MaxLCA = '". $arr2[7] ."', MaxSET = '". $arr2[8] ."', tinnumber = '". $arr2[9] ."'; ";
					$res = mysql_query($sql, $connection);

					if ( $uploadResult == 1 ) {
						if ( $res == true ) {
							$uploadResult = 1;
						}

						else {
							$uploadResult = 0;
						}
					}
				}

				if ( $uploadResult == 1 ) {
					echo 1;
					$getUpload2 = " UPDATE tblref_csv_upload SET mall = 1; ";
					$resUpload2 = mysql_query($getUpload2, $connection);
				}

				else {
					echo 0;
				}
			}

			else {
				echo 2;
			}

			
		break;

		case 'category':
			$arr = explode("#||", $_POST['csvDetails']);
			$uploadResult = 1;

			$getUpload = " SELECT category FROM tblref_csv_upload; ";
			$resUpload = mysql_query($getUpload, $connection);
			$rowUpload = mysql_fetch_array($resUpload);

			if ( $rowUpload[0] == 0 ) {
				for ( $a = 1; $a <= COUNT($arr)-1; $a++ ) {
					$arr2 = explode("|||", $arr[$a]);

					$sql = " INSERT INTO tblmaintenance_category SET category_id = '". $arr2[0] ."', category = '". $arr2[1] ."', Maintenance_Type = '". $arr2[2] ."', isFixed = '". $arr2[3] ."', FixedAmount = '". $arr2[4] ."', AddTask = '". $arr2[5] ."'; ";
					$res = mysql_query($sql, $connection);

					if ( $uploadResult == 1 ) {
						if ( $res == true ) {
							$uploadResult = 1;
						}

						else {
							$uploadResult = 0;
						}
					}
				}

				if ( $uploadResult == 1 ) {
					echo 1;
					$getUpload2 = " UPDATE tblref_csv_upload SET category = 1; ";
					$resUpload2 = mysql_query($getUpload2, $connection);
				}

				else {
					echo 0;
				}
			}
			
			else {
				echo 2;
			}
		break;

		case 'classification':
			$arr = explode("#||", $_POST['csvDetails']);
			$uploadResult = 1;

			$getUpload = " SELECT classification FROM tblref_csv_upload; ";
			$resUpload = mysql_query($getUpload, $connection);
			$rowUpload = mysql_fetch_array($resUpload);

			if ( $rowUpload[0] == 0 ) {
				for ( $a = 1; $a <= COUNT($arr)-1; $a++ ) {
					$arr2 = explode("|||", $arr[$a]);

					$sql = " INSERT INTO tblref_merchandise_class SET classificationID = '". $arr2[0] ."', classification = '". $arr2[1] ."'; ";
					$res = mysql_query($sql, $connection);

					if ( $uploadResult == 1 ) {
						if ( $res == true ) {
							$uploadResult = 1;
						}

						else {
							$uploadResult = 0;
						}
					}
				}

				if ( $uploadResult == 1 ) {
					echo 1;
					$getUpload2 = " UPDATE tblref_csv_upload SET classification = 1; ";
					$resUpload2 = mysql_query($getUpload2, $connection);
				}

				else {
					echo 0;
				}
			}
			
			else {
				echo 2;
			}
		break;

		case 'classification':
			$arr = explode("#||", $_POST['csvDetails']);
			$uploadResult = 1;

			$getUpload = " SELECT classification FROM tblref_csv_upload; ";
			$resUpload = mysql_query($getUpload, $connection);
			$rowUpload = mysql_fetch_array($resUpload);

			if ( $rowUpload[0] == 0 ) {
				for ( $a = 1; $a <= COUNT($arr)-1; $a++ ) {
					$arr2 = explode("|||", $arr[$a]);

					$sql = " INSERT INTO tblref_merchandise_class SET classificationID = '". $arr2[0] ."', classification = '". $arr2[1] ."'; ";
					$res = mysql_query($sql, $connection);

					if ( $uploadResult == 1 ) {
						if ( $res == true ) {
							$uploadResult = 1;
						}

						else {
							$uploadResult = 0;
						}
					}
				}

				if ( $uploadResult == 1 ) {
					echo 1;
					$getUpload2 = " UPDATE tblref_csv_upload SET classification = 1; ";
					$resUpload2 = mysql_query($getUpload2, $connection);
				}

				else {
					echo 0;
				}
			}
			
			else {
				echo 2;
			}
		break;

		case 'wing':
			$arr = explode("#||", $_POST['csvDetails']);
			$uploadResult = 1;

			$getUpload = " SELECT wing FROM tblref_csv_upload; ";
			$resUpload = mysql_query($getUpload, $connection);
			$rowUpload = mysql_fetch_array($resUpload);

			if ( $rowUpload[0] == 0 ) {
				for ( $a = 1; $a <= COUNT($arr)-1; $a++ ) {
					$arr2 = explode("|||", $arr[$a]);

					$sql = " INSERT INTO tblref_wing SET wingID = '". $arr2[0] ."', wing = '". $arr2[1] ."', mallID = '". $arr2[2] ."', wingstat = '". $arr2[3] ."'; ";
					$res = mysql_query($sql, $connection);

					if ( $uploadResult == 1 ) {
						if ( $res == true ) {
							$uploadResult = 1;
						}

						else {
							$uploadResult = 0;
						}
					}
				}

				if ( $uploadResult == 1 ) {
					echo 1;
					$getUpload2 = " UPDATE tblref_csv_upload SET wing = 1; ";
					$resUpload2 = mysql_query($getUpload2, $connection);
				}

				else {
					echo 0;
				}
			}
			
			else {
				echo 2;
			}
		break;

		case 'floorName':
			$arr = explode("#||", $_POST['csvDetails']);
			$uploadResult = 1;

			$getUpload = " SELECT floorName FROM tblref_csv_upload; ";
			$resUpload = mysql_query($getUpload, $connection);
			$rowUpload = mysql_fetch_array($resUpload);

			if ( $rowUpload[0] == 0 ) {
				for ( $a = 1; $a <= COUNT($arr)-1; $a++ ) {
					$arr2 = explode("|||", $arr[$a]);

					$sql = " INSERT INTO tblref_flr SET floor = '". $arr2[0] ."'; ";
					$res = mysql_query($sql, $connection);

					if ( $uploadResult == 1 ) {
						if ( $res == true ) {
							$uploadResult = 1;
						}

						else {
							$uploadResult = 0;
						}
					}
				}

				if ( $uploadResult == 1 ) {
					echo 1;
					$getUpload2 = " UPDATE tblref_csv_upload SET floorName = 1; ";
					$resUpload2 = mysql_query($getUpload2, $connection);
				}

				else {
					echo 0;
				}
			}
			
			else {
				echo 2;
			}
		break;

		case 'floorSetup':
			$arr = explode("#||", $_POST['csvDetails']);
			$uploadResult = 1;

			$getUpload = " SELECT floorSetup FROM tblref_csv_upload; ";
			$resUpload = mysql_query($getUpload, $connection);
			$rowUpload = mysql_fetch_array($resUpload);

			if ( $rowUpload[0] == 0 ) {
				for ( $a = 1; $a <= COUNT($arr)-1; $a++ ) {
					$arr2 = explode("|||", $arr[$a]);

					$sql = " INSERT INTO tblref_floorsetup SET floorid = '". $arr2[0] ."', mallid = '". $arr2[1] ."', wingid = '". $arr2[2] ."', floor = '". $arr2[3] ."', width2 = '". $arr2[4] ."', length2 = '". $arr2[5] ."', minarea = '". $arr2[6] ."', floorstat = '". $arr2[7] ."'; ";
					$res = mysql_query($sql, $connection) or die(mysql_error());

					if ( $uploadResult == 1 ) {
						if ( $res == true ) {
							$uploadResult = 1;
						}

						else {
							$uploadResult = 0;
						}
					}
				}

				if ( $uploadResult == 1 ) {
					echo 1;
					$getUpload2 = " UPDATE tblref_csv_upload SET floorSetup = 1; ";
					$resUpload2 = mysql_query($getUpload2, $connection);
				}

				else {
					echo 0;
				}
			}
			
			else {
				echo 2;
			}
		break;

		case 'department':
			$arr = explode("#||", $_POST['csvDetails']);
			$uploadResult = 1;

			$getUpload = " SELECT department FROM tblref_csv_upload; ";
			$resUpload = mysql_query($getUpload, $connection);
			$rowUpload = mysql_fetch_array($resUpload);

			if ( $rowUpload[0] == 0 ) {
				for ( $a = 1; $a <= COUNT($arr)-1; $a++ ) {
					$arr2 = explode("|||", $arr[$a]);

					$sql = " INSERT INTO tblref_merchandise_depa SET class_ID = '". $arr2[0] ."', departmentID = '". $arr2[1] ."', department = '". $arr2[2] ."'; ";
					$res = mysql_query($sql, $connection) or die(mysql_error());

					if ( $uploadResult == 1 ) {
						if ( $res == true ) {
							$uploadResult = 1;
						}

						else {
							$uploadResult = 0;
						}
					}
				}

				if ( $uploadResult == 1 ) {
					echo 1;
					$getUpload2 = " UPDATE tblref_csv_upload SET department = 1; ";
					$resUpload2 = mysql_query($getUpload2, $connection);
				}

				else {
					echo 0;
				}
			}
			
			else {
				echo 2;
			}
		break;

		case 'industry':
			$arr = explode("#||", $_POST['csvDetails']);
			$uploadResult = 1;

			$getUpload = " SELECT industry FROM tblref_csv_upload; ";
			$resUpload = mysql_query($getUpload, $connection);
			$rowUpload = mysql_fetch_array($resUpload);

			if ( $rowUpload[0] == 0 ) {
				for ( $a = 1; $a <= COUNT($arr)-1; $a++ ) {
					$arr2 = explode("|||", $arr[$a]);

					$sql = " INSERT INTO tblref_industry SET Industry_ID = '". $arr2[0] ."', Industry = '". $arr2[1] ."'; ";
					$res = mysql_query($sql, $connection) or die(mysql_error());

					if ( $uploadResult == 1 ) {
						if ( $res == true ) {
							$uploadResult = 1;
						}

						else {
							$uploadResult = 0;
						}
					}
				}

				if ( $uploadResult == 1 ) {
					echo 1;
					$getUpload2 = " UPDATE tblref_csv_upload SET industry = 1; ";
					$resUpload2 = mysql_query($getUpload2, $connection);
				}

				else {
					echo 0;
				}
			}
			
			else {
				echo 2;
			}
		break;

		case 'amenities':
			$arr = explode("#||", $_POST['csvDetails']);
			$uploadResult = 1;

			$getUpload = " SELECT amenities FROM tblref_csv_upload; ";
			$resUpload = mysql_query($getUpload, $connection);
			$rowUpload = mysql_fetch_array($resUpload);

			if ( $rowUpload[0] == 0 ) {
				for ( $a = 1; $a <= COUNT($arr)-1; $a++ ) {
					$arr2 = explode("|||", $arr[$a]);

					$sql = " INSERT INTO tblref_amenities SET amenitiesid = '". $arr2[0] ."', amenitiesname = '". $arr2[1] ."', qty = '". $arr2[2] ."'; ";
					$res = mysql_query($sql, $connection) or die(mysql_error());

					if ( $uploadResult == 1 ) {
						if ( $res == true ) {
							$uploadResult = 1;
						}

						else {
							$uploadResult = 0;
						}
					}
				}

				if ( $uploadResult == 1 ) {
					echo 1;
					$getUpload2 = " UPDATE tblref_csv_upload SET amenities = 1; ";
					$resUpload2 = mysql_query($getUpload2, $connection);
				}

				else {
					echo 0;
				}
			}
			
			else {
				echo 2;
			}
		break;

		case 'unit':
			$arr = explode("#||", $_POST['csvDetails']);
			$uploadResult = 1;

			$getUpload = " SELECT unit FROM tblref_csv_upload; ";
			$resUpload = mysql_query($getUpload, $connection);
			$rowUpload = mysql_fetch_array($resUpload);

			if ( $rowUpload[0] == 0 ) {
				for ( $a = 1; $a <= COUNT($arr)-1; $a++ ) {
					$arr2 = explode("|||", $arr[$a]);

					$sql = " INSERT INTO tblref_unit SET unitid = '". $arr2[0] ."', unitname = '". $arr2[1] ."', buildingname = '". $arr2[2] ."', typeofbusiness = '". $arr2[3] ."', classificationname = '". $arr2[4] ."', sqmunitsetup = '". $arr2[5] ."', pricepersqmunitsetup = '". $arr2[6] ."', totalamountunitsetup = '". $arr2[7] ."', status = '". $arr2[8] ."', mallid = '". $arr2[9] ."', floorid = '". $arr2[10] ."', wingid = '". $arr2[11] ."', classid = '". $arr2[12] ."', depid = '". $arr2[13] ."', catid = '". $arr2[14] ."', tenantID = '". $arr2[15] ."', TenantName = '". $arr2[16] ."', startDate = '". date('Y-m-d', strtotime($arr2[17])) ."', endDate = '". date('Y-m-d', strtotime($arr2[18])) ."', electricStat = '". $arr2[19] ."', waterStat = '". $arr2[20] ."', txtStat = '". $arr2[21] ."', sqm_width = '". $arr2[22] ."', sqm_height = '". $arr2[23] ."', area = '". $arr2[24] ."', max_num = '". $arr2[25] ."', rem_num = '". $arr2[26] ."', unitstat = '". $arr2[27] ."', assocdues = '". $arr2[28] ."', reserveDate = '". $arr2[29] ."', amenities = '". $arr2[30] ."', MainUnit = '". $arr2[31] ."'; ";
					$res = mysql_query($sql, $connection) or die(mysql_error());

					if ( $uploadResult == 1 ) {
						if ( $res == true ) {
							$uploadResult = 1;
						}

						else {
							$uploadResult = 0;
						}
					}
				}

				if ( $uploadResult == 1 ) {
					echo 1;
					$getUpload2 = " UPDATE tblref_csv_upload SET unit = 1; ";
					$resUpload2 = mysql_query($getUpload2, $connection);
				}

				else {
					echo 0;
				}
			}
			
			else {
				echo 2;
			}
		break;

		case 'company':
			$arr = explode("#||", $_POST['csvDetails']);
			$uploadResult = 1;

			$getUpload = " SELECT company FROM tblref_csv_upload; ";
			$resUpload = mysql_query($getUpload, $connection);
			$rowUpload = mysql_fetch_array($resUpload);

			if ( $rowUpload[0] == 0 ) {
				for ( $a = 1; $a <= COUNT($arr)-1; $a++ ) {
					$arr2 = explode("|||", $arr[$a]);

					$sql = " INSERT INTO tbltrans_company SET CompanyID = '". $arr2[0] ."', Company = '". $arr2[1] ."', industry = '". $arr2[2] ."', businessAddress = '". $arr2[3] ."', owner_firstname = '". $arr2[4] ."', owner_middlename = '". $arr2[5] ."', owner_lastname = '". $arr2[6] ."', permanent_address = '". $arr2[7] ."', current_address = '". $arr2[8] ."', billing_address = '". $arr2[9] ."', merchant_code = '". $arr2[10] ."', automerchant_code = '". $arr2[11] ."'; ";
					$res = mysql_query($sql, $connection) or die(mysql_error());

					if ( $uploadResult == 1 ) {
						if ( $res == true ) {
							$uploadResult = 1;
						}

						else {
							$uploadResult = 0;
						}
					}
				}

				if ( $uploadResult == 1 ) {
					echo 1;
					$getUpload2 = " UPDATE tblref_csv_upload SET company = 1; ";
					$resUpload2 = mysql_query($getUpload2, $connection);
				}

				else {
					echo 0;
				}
			}
			
			else {
				echo 2;
			}
		break;
	}
?>