<?php
	session_start();
	include "../../connect.php";
	$filepath = mysql_fetch_array(mysql_query("SELECT dbsetup FROM tblsys_setup;", $connection)); //Get System Setup
	$tblSales = tblSales($filepath['dbsetup']);
	switch ($_POST['form']) {
		case 'sayear':
			$res = mysql_query("SELECT DISTINCT(YEAR(". $tblSales[1] .")) FROM ". $tblSales[0] ." WHERE ". getMallAccess("mallid", "") .";", $connection);
			while($row = mysql_fetch_array($res)){				
				echo"<option value='". $row[0] ."'>". $row[0] ."</option>";
			}
		break;

		case 'saday':
			$month = $_POST['month'];
			if($month == "02"){
				echo "<option value=''>Choose Day</option><option>01</option> <option>02</option> <option>03</option> <option>04</option> <option>05</option><option>06</option> <option>07</option> <option>08</option> <option>09</option> <option>10</option><option>11</option> <option>12</option> <option>13</option> <option>14</option> <option>15</option><option>16</option> <option>17</option> <option>18</option> <option>19</option> <option>20</option><option>21</option> <option>22</option> <option>23</option> <option>24</option> <option>25</option><option>26</option> <option>27</option> <option>28</option> ";
			}else if($month == "01" || $month == "03" || $month == "05" || $month == "07" || $month == "08" || $month == "10" || $month == "12"){
				echo "<option value=''>Choose Day</option><option>01</option> <option>02</option> <option>03</option> <option>04</option> <option>05</option><option>06</option> <option>07</option> <option>08</option> <option>09</option> <option>10</option><option>11</option> <option>12</option> <option>13</option> <option>14</option> <option>15</option><option>16</option> <option>17</option> <option>18</option> <option>19</option> <option>20</option><option>21</option> <option>22</option> <option>23</option> <option>24</option> <option>25</option><option>26</option> <option>27</option> <option>28</option> <option>29</option> <option>30</option><option>31</option>";
			}else if($month == "04" || $month == "06" || $month == "09" || $month == "11"){
				echo "<option value=''>Choose Day</option><option>01</option> <option>02</option> <option>03</option> <option>04</option> <option>05</option><option>06</option> <option>07</option> <option>08</option> <option>09</option> <option>10</option><option>11</option> <option>12</option> <option>13</option> <option>14</option> <option>15</option><option>16</option> <option>17</option> <option>18</option> <option>19</option> <option>20</option><option>21</option> <option>22</option> <option>23</option> <option>24</option> <option>25</option><option>26</option> <option>27</option> <option>28</option> <option>29</option> <option>30</option>";
			}else{
				echo "<option value=''>Choose Day</option>";
			}
		break;

		case 'companysales':
			$row = mysql_fetch_array(mysql_query("SELECT corporatename FROM tblsys_setup;", $connection));
			$year = $_POST['year'];
			$month = $_POST['month'];
			$day = $_POST['day'];
			$date1 = $_POST['year']."-".$_POST['month']."-".$_POST['day'];
			if($year == "" && $month == "" && $day == ""){
				$sqlsales = " SELECT tenantid, ".$tblSales[1].", SUM(".$tblSales[4]."), SUM(".$tblSales[5]."), SUM(".$tblSales[6]."), SUM(".$tblSales[7]."), SUM(".$tblSales[7]."), SUM(".$tblSales[8]."), SUM(".$tblSales[9]."), SUM(".$tblSales[10]."), SUM(".$tblSales[11]."), SUM(".$tblSales[12]."), SUM(".$tblSales[13]."), SUM(".$tblSales[14]."), SUM(".$tblSales[15]."), SUM(".$tblSales[16]."), SUM(".$tblSales[17]."), SUM(".$tblSales[18]."), SUM(".$tblSales[19]."), SUM(".$tblSales[20]."), SUM(".$tblSales[21]."), SUM(".$tblSales[22]."), SUM(".$tblSales[23]."), SUM(".$tblSales[24]."), SUM(".$tblSales[25]."), SUM(".$tblSales[26]."), SUM(".$tblSales[27]."), SUM(".$tblSales[28]."), ".$tblSales[28].", SUM(".$tblSales[29]."), SUM(".$tblSales[30]."), SUM(".$tblSales[31].") FROM ".$tblSales[0]." WHERE ". getMallAccess("mallid", "") .";";
			}else if($year != "" && $month != "" && $day != ""){
				$sqlsales = " SELECT tenantid, ".$tblSales[1].", SUM(".$tblSales[4]."), SUM(".$tblSales[5]."), SUM(".$tblSales[6]."), SUM(".$tblSales[7]."), SUM(".$tblSales[7]."), SUM(".$tblSales[8]."), SUM(".$tblSales[9]."), SUM(".$tblSales[10]."), SUM(".$tblSales[11]."), SUM(".$tblSales[12]."), SUM(".$tblSales[13]."), SUM(".$tblSales[14]."), SUM(".$tblSales[15]."), SUM(".$tblSales[16]."), SUM(".$tblSales[17]."), SUM(".$tblSales[18]."), SUM(".$tblSales[19]."), SUM(".$tblSales[20]."), SUM(".$tblSales[21]."), SUM(".$tblSales[22]."), SUM(".$tblSales[23]."), SUM(".$tblSales[24]."), SUM(".$tblSales[25]."), SUM(".$tblSales[26]."), SUM(".$tblSales[27]."), SUM(".$tblSales[28]."), ".$tblSales[28].", SUM(".$tblSales[29]."), SUM(".$tblSales[30]."), SUM(".$tblSales[31].") FROM ".$tblSales[0]." WHERE ".$tblSales[1]." = '". $date1 ."' ". getMallAccess("mallid", "AND") .";";
			}else if($year != "" && $month != "" && $day == ""){
				$sqlsales = " SELECT tenantid, ".$tblSales[1].", SUM(".$tblSales[4]."), SUM(".$tblSales[5]."), SUM(".$tblSales[6]."), SUM(".$tblSales[7]."), SUM(".$tblSales[7]."), SUM(".$tblSales[8]."), SUM(".$tblSales[9]."), SUM(".$tblSales[10]."), SUM(".$tblSales[11]."), SUM(".$tblSales[12]."), SUM(".$tblSales[13]."), SUM(".$tblSales[14]."), SUM(".$tblSales[15]."), SUM(".$tblSales[16]."), SUM(".$tblSales[17]."), SUM(".$tblSales[18]."), SUM(".$tblSales[19]."), SUM(".$tblSales[20]."), SUM(".$tblSales[21]."), SUM(".$tblSales[22]."), SUM(".$tblSales[23]."), SUM(".$tblSales[24]."), SUM(".$tblSales[25]."), SUM(".$tblSales[26]."), SUM(".$tblSales[27]."), SUM(".$tblSales[28]."), ".$tblSales[28].", SUM(".$tblSales[29]."), SUM(".$tblSales[30]."), SUM(".$tblSales[31].") FROM ".$tblSales[0]." WHERE YEAR(".$tblSales[1].") = '". $year ."' AND MONTH(".$tblSales[1].") = '". $month ."' ". getMallAccess("mallid", "AND") .";";
			}else if($year != "" && $month == "" && $day == ""){
				$sqlsales = " SELECT tenantid, ".$tblSales[1].", SUM(".$tblSales[4]."), SUM(".$tblSales[5]."), SUM(".$tblSales[6]."), SUM(".$tblSales[7]."), SUM(".$tblSales[7]."), SUM(".$tblSales[8]."), SUM(".$tblSales[9]."), SUM(".$tblSales[10]."), SUM(".$tblSales[11]."), SUM(".$tblSales[12]."), SUM(".$tblSales[13]."), SUM(".$tblSales[14]."), SUM(".$tblSales[15]."), SUM(".$tblSales[16]."), SUM(".$tblSales[17]."), SUM(".$tblSales[18]."), SUM(".$tblSales[19]."), SUM(".$tblSales[20]."), SUM(".$tblSales[21]."), SUM(".$tblSales[22]."), SUM(".$tblSales[23]."), SUM(".$tblSales[24]."), SUM(".$tblSales[25]."), SUM(".$tblSales[26]."), SUM(".$tblSales[27]."), SUM(".$tblSales[28]."), ".$tblSales[28].", SUM(".$tblSales[29]."), SUM(".$tblSales[30]."), SUM(".$tblSales[31].") FROM ".$tblSales[0]." WHERE YEAR(".$tblSales[1].") = '". $year ."' ". getMallAccess("mallid", "AND") .";";
			}else{
				echo "1";
			}
			echo $sqlsales;
			$ressales = mysql_query($sqlsales, $connection);
			while($rowsales = mysql_fetch_array($ressales)){
				$table .= "
				<tr style='width: 100%;cursor: pointer !important;' onclick='mallsales();'>
				    <td style='text-align: left; width:1%; white-space:nowrap;'>". $row[0] ."</td>
					<td style='text-align: left; width:1%; white-space:nowrap;'>". $year ."</td>	
					<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[4], 2, '.', ',') ."</td>
					<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[5], 2, '.', ',') ."</td>
					<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[6], 2, '.', ',') ."</td>
					<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[7], 2, '.', ',') ."</td>
					<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[8], 2, '.', ',') ."</td>
					<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[9], 2, '.', ',') ."</td>
					<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[10], 2, '.', ',') ."</td>
					<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[11], 2, '.', ',') ."</td>
					<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[12], 2, '.', ',') ."</td>
					<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[13], 2, '.', ',') ."</td>
					<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[14], 2, '.', ',') ."</td>
					<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[15], 2, '.', ',') ."</td>
					<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[16], 2, '.', ',') ."</td>
					<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[17], 2, '.', ',') ."</td>
					<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[18], 2, '.', ',') ."</td>
					<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[19], 2, '.', ',') ."</td>
					<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[20], 2, '.', ',') ."</td>
					<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[21], 2, '.', ',') ."</td>
					<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[22], 2, '.', ',') ."</td>
					<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[23], 2, '.', ',') ."</td>
					<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[24], 2, '.', ',') ."</td>
					<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[25], 2, '.', ',') ."</td>
					<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[26], 2, '.', ',') ."</td>
					<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[27], 2, '.', ',') ."</td>
					<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[29], 2, '.', ',') ."</td>
					<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[30], 2, '.', ',') ."</td>
					<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[31], 2, '.', ',') ."</td>
				</tr>";
				$li .= "<li onclick='mall();'>".$row[0]."</li>";

				echo $table . "|" . $li . "|" . $row[0];
			}
		break;

		case 'mallsales':
			$res = mysql_query("SELECT mallid, mallname FROM tblref_mall;", $connection);
			while($row = mysql_fetch_array($res)){
				$year = $_POST['year'];
				$month = $_POST['month'];
				$day = $_POST['day'];
				$date1 = $_POST['year']."-".$_POST['month']."-".$_POST['day'];
				if($year == "" && $month == "" && $day == ""){
					$sqlsales = " SELECT tenantid, ".$tblSales[1].", SUM(".$tblSales[4]."), SUM(".$tblSales[5]."), SUM(".$tblSales[6]."), SUM(".$tblSales[7]."), SUM(".$tblSales[7]."), SUM(".$tblSales[8]."), SUM(".$tblSales[9]."), SUM(".$tblSales[10]."), SUM(".$tblSales[11]."), SUM(".$tblSales[12]."), SUM(".$tblSales[13]."), SUM(".$tblSales[14]."), SUM(".$tblSales[15]."), SUM(".$tblSales[16]."), SUM(".$tblSales[17]."), SUM(".$tblSales[18]."), SUM(".$tblSales[19]."), SUM(".$tblSales[20]."), SUM(".$tblSales[21]."), SUM(".$tblSales[22]."), SUM(".$tblSales[23]."), SUM(".$tblSales[24]."), SUM(".$tblSales[25]."), SUM(".$tblSales[26]."), SUM(".$tblSales[27]."), SUM(".$tblSales[28]."), ".$tblSales[28].", SUM(".$tblSales[29]."), SUM(".$tblSales[30]."), SUM(".$tblSales[31].") FROM ".$tblSales[0]." WHERE mallid = '". $row[0] ."' ". getMallAccess("mallid", "AND") .";";
				}else if($year != "" && $month != "" && $day != ""){
					$sqlsales = " SELECT tenantid, ".$tblSales[1].", SUM(".$tblSales[4]."), SUM(".$tblSales[5]."), SUM(".$tblSales[6]."), SUM(".$tblSales[7]."), SUM(".$tblSales[7]."), SUM(".$tblSales[8]."), SUM(".$tblSales[9]."), SUM(".$tblSales[10]."), SUM(".$tblSales[11]."), SUM(".$tblSales[12]."), SUM(".$tblSales[13]."), SUM(".$tblSales[14]."), SUM(".$tblSales[15]."), SUM(".$tblSales[16]."), SUM(".$tblSales[17]."), SUM(".$tblSales[18]."), SUM(".$tblSales[19]."), SUM(".$tblSales[20]."), SUM(".$tblSales[21]."), SUM(".$tblSales[22]."), SUM(".$tblSales[23]."), SUM(".$tblSales[24]."), SUM(".$tblSales[25]."), SUM(".$tblSales[26]."), SUM(".$tblSales[27]."), SUM(".$tblSales[28]."), ".$tblSales[28].", SUM(".$tblSales[29]."), SUM(".$tblSales[30]."), SUM(".$tblSales[31].") FROM ".$tblSales[0]." WHERE mallid = '". $row[0] ."' AND ".$tblSales[1]." = '". $date1 ."' ". getMallAccess("mallid", "AND") .";";
				}else if($year != "" && $month != "" && $day == ""){
					$sqlsales = " SELECT tenantid, ".$tblSales[1].", SUM(".$tblSales[4]."), SUM(".$tblSales[5]."), SUM(".$tblSales[6]."), SUM(".$tblSales[7]."), SUM(".$tblSales[7]."), SUM(".$tblSales[8]."), SUM(".$tblSales[9]."), SUM(".$tblSales[10]."), SUM(".$tblSales[11]."), SUM(".$tblSales[12]."), SUM(".$tblSales[13]."), SUM(".$tblSales[14]."), SUM(".$tblSales[15]."), SUM(".$tblSales[16]."), SUM(".$tblSales[17]."), SUM(".$tblSales[18]."), SUM(".$tblSales[19]."), SUM(".$tblSales[20]."), SUM(".$tblSales[21]."), SUM(".$tblSales[22]."), SUM(".$tblSales[23]."), SUM(".$tblSales[24]."), SUM(".$tblSales[25]."), SUM(".$tblSales[26]."), SUM(".$tblSales[27]."), SUM(".$tblSales[28]."), ".$tblSales[28].", SUM(".$tblSales[29]."), SUM(".$tblSales[30]."), SUM(".$tblSales[31].") FROM ".$tblSales[0]." WHERE mallid = '". $row[0] ."' AND YEAR(".$tblSales[1].") = '". $year ."' AND MONTH(".$tblSales[1].") = '". $month ."' ". getMallAccess("mallid", "AND") .";";
				}else if($year != "" && $month == "" && $day == ""){
					$sqlsales = " SELECT tenantid, ".$tblSales[1].", SUM(".$tblSales[4]."), SUM(".$tblSales[5]."), SUM(".$tblSales[6]."), SUM(".$tblSales[7]."), SUM(".$tblSales[7]."), SUM(".$tblSales[8]."), SUM(".$tblSales[9]."), SUM(".$tblSales[10]."), SUM(".$tblSales[11]."), SUM(".$tblSales[12]."), SUM(".$tblSales[13]."), SUM(".$tblSales[14]."), SUM(".$tblSales[15]."), SUM(".$tblSales[16]."), SUM(".$tblSales[17]."), SUM(".$tblSales[18]."), SUM(".$tblSales[19]."), SUM(".$tblSales[20]."), SUM(".$tblSales[21]."), SUM(".$tblSales[22]."), SUM(".$tblSales[23]."), SUM(".$tblSales[24]."), SUM(".$tblSales[25]."), SUM(".$tblSales[26]."), SUM(".$tblSales[27]."), SUM(".$tblSales[28]."), ".$tblSales[28].", SUM(".$tblSales[29]."), SUM(".$tblSales[30]."), SUM(".$tblSales[31].") FROM ".$tblSales[0]." WHERE mallid = '". $row[0] ."' AND YEAR(".$tblSales[1].") = '". $year ."' ". getMallAccess("mallid", "AND") .";";
				}else{
					echo "1";
				}
				$ressales = mysql_query($sqlsales, $connection);
				while($rowsales = mysql_fetch_array($ressales)){
					$table .= "
					<tr style='width: 100%;cursor: pointer !important;' onclick='wingsales(\"".  $row[0] ."\");'>
					    <td style='text-align: left; width:1%; white-space:nowrap;'>". $row[1] ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". $year ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[4], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[5], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[6], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[7], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[8], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[9], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[10], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[11], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[12], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[13], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[14], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[15], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[16], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[17], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[18], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[19], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[20], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[21], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[22], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[23], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[24], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[25], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[26], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[27], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[29], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[30], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[31], 2, '.', ',') ."</td>
					</tr>";
				}
				$mallname .= $row[1];
				echo $table . "|" .$mallname;
			}
		break;

		case 'wingsales':
			$year = $_POST['year'];
			$month = $_POST['month'];
			$day = $_POST['day'];
			$date1 = $_POST['year']."-".$_POST['month']."-".$_POST['day'];
			$rowmall = mysql_fetch_array(mysql_query("SELECT mallname FROM tblref_mall WHERE mallid = '". $_POST['mallid'] ."';", $connection));
			$res = mysql_query("SELECT wingID, wing FROM tblref_wing WHERE mallid = '". $_POST['mallid'] ."';", $connection);
			while($row = mysql_fetch_array($res)){
				if($year == "" && $month == "" && $day == ""){
					$sqlsales = " SELECT a.unitid, b.unitid, b.mallid, b.tenantid, c.tenantid, c.".$tblSales[1].", SUM(c.".$tblSales[4]."), SUM(c.".$tblSales[5]."), SUM(c.".$tblSales[6]."), SUM(c.".$tblSales[7]."), SUM(c.".$tblSales[8]."), SUM(c.".$tblSales[9]."), SUM(c.".$tblSales[10]."), SUM(c.".$tblSales[11]."), SUM(c.".$tblSales[12]."), SUM(c.".$tblSales[13]."), SUM(c.".$tblSales[14]."), SUM(c.".$tblSales[5]."), SUM(c.".$tblSales[16]."), SUM(c.".$tblSales[17]."), SUM(c.".$tblSales[18]."), SUM(c.".$tblSales[19]."), SUM(c.".$tblSales[20]."), SUM(c.".$tblSales[21]."), SUM(c.".$tblSales[22]."), SUM(c.".$tblSales[23]."), SUM(c.".$tblSales[24]."), SUM(c.".$tblSales[25]."), SUM(c.".$tblSales[26]."), SUM(c.".$tblSales[27]."), SUM(c.".$tblSales[28]."), SUM(c.".$tblSales[29]."), c.".$tblSales[30].", SUM(c.".$tblSales[31]."), SUM(c.".$tblSales[32]."), SUM(c.".$tblSales[33]."), a.wingid FROM tblref_unit AS a INNER JOIN tbltrans_tenants AS b ON a.unitid = b.unitid INNER JOIN ".$tblSales[0]." AS c ON b.tenantid = c.tenantid WHERE c.mallID = '". $_POST['mallid'] ."' AND a.wingid ='".$row[0]."' ". getMallAccess("c.mallid", "AND") .";";
				}else if($year != "" && $month != "" && $day != ""){
					$sqlsales = " SELECT a.unitid, b.unitid, b.mallid, b.tenantid, c.tenantid, c.".$tblSales[1].", SUM(c.".$tblSales[4]."), SUM(c.".$tblSales[5]."), SUM(c.".$tblSales[6]."), SUM(c.".$tblSales[7]."), SUM(c.".$tblSales[8]."), SUM(c.".$tblSales[9]."), SUM(c.".$tblSales[10]."), SUM(c.".$tblSales[11]."), SUM(c.".$tblSales[12]."), SUM(c.".$tblSales[13]."), SUM(c.".$tblSales[14]."), SUM(c.".$tblSales[5]."), SUM(c.".$tblSales[16]."), SUM(c.".$tblSales[17]."), SUM(c.".$tblSales[18]."), SUM(c.".$tblSales[19]."), SUM(c.".$tblSales[20]."), SUM(c.".$tblSales[21]."), SUM(c.".$tblSales[22]."), SUM(c.".$tblSales[23]."), SUM(c.".$tblSales[24]."), SUM(c.".$tblSales[25]."), SUM(c.".$tblSales[26]."), SUM(c.".$tblSales[27]."), SUM(c.".$tblSales[28]."), SUM(c.".$tblSales[29]."), c.".$tblSales[30].", SUM(c.".$tblSales[31]."), SUM(c.".$tblSales[32]."), SUM(c.".$tblSales[33]."), a.wingid FROM tblref_unit AS a INNER JOIN tbltrans_tenants AS b ON a.unitid = b.unitid INNER JOIN ".$tblSales[0]." AS c ON b.tenantid = c.tenantid  WHERE c.".$tblSales[1]." = '". $date1 ."' AND c.mallID = '". $_POST['mallid'] ."' AND a.wingid ='".$row[0]."' ". getMallAccess("c.mallid", "AND") .";";
				}else if($year != "" && $month != "" && $day == ""){
					$sqlsales = " SELECT a.unitid, b.unitid, b.mallid, b.tenantid, c.tenantid, c.".$tblSales[1].", SUM(c.".$tblSales[4]."), SUM(c.".$tblSales[5]."), SUM(c.".$tblSales[6]."), SUM(c.".$tblSales[7]."), SUM(c.".$tblSales[8]."), SUM(c.".$tblSales[9]."), SUM(c.".$tblSales[10]."), SUM(c.".$tblSales[11]."), SUM(c.".$tblSales[12]."), SUM(c.".$tblSales[13]."), SUM(c.".$tblSales[14]."), SUM(c.".$tblSales[5]."), SUM(c.".$tblSales[16]."), SUM(c.".$tblSales[17]."), SUM(c.".$tblSales[18]."), SUM(c.".$tblSales[19]."), SUM(c.".$tblSales[20]."), SUM(c.".$tblSales[21]."), SUM(c.".$tblSales[22]."), SUM(c.".$tblSales[23]."), SUM(c.".$tblSales[24]."), SUM(c.".$tblSales[25]."), SUM(c.".$tblSales[26]."), SUM(c.".$tblSales[27]."), SUM(c.".$tblSales[28]."), SUM(c.".$tblSales[29]."), c.".$tblSales[30].", SUM(c.".$tblSales[31]."), SUM(c.".$tblSales[32]."), SUM(c.".$tblSales[33]."), a.wingid FROM tblref_unit AS a INNER JOIN tbltrans_tenants AS b ON a.unitid = b.unitid INNER JOIN ".$tblSales[0]." AS c ON b.tenantid = c.tenantid  WHERE YEAR(c.".$tblSales[1].") = '". $year ."' AND MONTH(c.".$tblSales[1].") = '". $month ."' AND c.mallID = '". $_POST['mallid'] ."' AND a.wingid ='".$row[0]."' ". getMallAccess("c.mallid", "AND") .";";
				}else if($year != "" && $month == "" && $day == ""){
					$sqlsales = "SELECT a.unitid, b.unitid, b.mallid, b.tenantid, c.tenantid, c.".$tblSales[1].", SUM(c.".$tblSales[4]."), SUM(c.".$tblSales[5]."), SUM(c.".$tblSales[6]."), SUM(c.".$tblSales[7]."), SUM(c.".$tblSales[8]."), SUM(c.".$tblSales[9]."), SUM(c.".$tblSales[10]."), SUM(c.".$tblSales[11]."), SUM(c.".$tblSales[12]."), SUM(c.".$tblSales[13]."), SUM(c.".$tblSales[14]."), SUM(c.".$tblSales[5]."), SUM(c.".$tblSales[16]."), SUM(c.".$tblSales[17]."), SUM(c.".$tblSales[18]."), SUM(c.".$tblSales[19]."), SUM(c.".$tblSales[20]."), SUM(c.".$tblSales[21]."), SUM(c.".$tblSales[22]."), SUM(c.".$tblSales[23]."), SUM(c.".$tblSales[24]."), SUM(c.".$tblSales[25]."), SUM(c.".$tblSales[26]."), SUM(c.".$tblSales[27]."), SUM(c.".$tblSales[28]."), SUM(c.".$tblSales[29]."), c.".$tblSales[30].", SUM(c.".$tblSales[31]."), SUM(c.".$tblSales[32]."), SUM(c.".$tblSales[33]."), a.wingid FROM tblref_unit AS a INNER JOIN tbltrans_tenants AS b ON a.unitid = b.unitid INNER JOIN ".$tblSales[0]." AS c ON b.tenantid = c.tenantid  WHERE YEAR(c.".$tblSales[1].") = '". $year ."' AND c.mallID = '". $_POST['mallid'] ."' AND a.wingid ='".$row[0]."' ". getMallAccess("c.mallid", "AND") .";";
				}else{
					echo "1";
				}
				$ressales = mysql_query($sqlsales, $connection);
				while($rowsales = mysql_fetch_array($ressales)){
					$table .= "
					<tr style='width: 100%;cursor: pointer !important;' onclick='floorsales(\"".  $row[0] ."\");'>
					    <td style='text-align: left; width:1%; white-space:nowrap;'>". $row[1] ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". $year ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[8], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[9], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[10], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[11], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[12], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[13], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[15], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[16], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[17], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[18], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[19], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[20], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[21], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[22], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[23], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[24], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[25], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[26], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[27], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[28], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[29], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[30], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[31], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[32], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[33], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[34], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[35], 2, '.', ',') ."</td>
					</tr>";
				}
			}
			echo $table . "|" . $rowmall[0];
		break;

		case 'floorsales':
			$year = $_POST['year'];
			$month = $_POST['month'];
			$day = $_POST['day'];
			$date1 = $_POST['year']."-".$_POST['month']."-".$_POST['day'];

			$sqlwing = " SELECT wing FROM tblref_wing WHERE mallid = '". $_POST['mallid'] ."' AND wingid = '". $_POST['wingid'] ."' ";
			$reswing = mysql_query($sqlwing, $connection);
			$rowwing = mysql_fetch_array($reswing);

			$sql = " SELECT floorid, floor FROM tblref_floorsetup WHERE mallid = '". $_POST['mallid'] ."' AND  wingid = '". $_POST['wingid'] ."' "; 
			$res = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($res)){			

			if($year == "" && $month == "" && $day == ""){
				$sqlsales = "SELECT a.unitid, b.unitid, b.mallid, b.tenantid, c.tenantid, c.".$tblSales[1].", SUM(c.".$tblSales[4]."), SUM(c.".$tblSales[5]."), SUM(c.".$tblSales[6]."), SUM(c.".$tblSales[7]."), SUM(c.".$tblSales[8]."), SUM(c.".$tblSales[9]."), SUM(c.".$tblSales[10]."), SUM(c.".$tblSales[11]."), SUM(c.".$tblSales[12]."), SUM(c.".$tblSales[13]."), SUM(c.".$tblSales[14]."), SUM(c.".$tblSales[5]."), SUM(c.".$tblSales[16]."), SUM(c.".$tblSales[17]."), SUM(c.".$tblSales[18]."), SUM(c.".$tblSales[19]."), SUM(c.".$tblSales[20]."), SUM(c.".$tblSales[21]."), SUM(c.".$tblSales[22]."), SUM(c.".$tblSales[23]."), SUM(c.".$tblSales[24]."), SUM(c.".$tblSales[25]."), SUM(c.".$tblSales[26]."), SUM(c.".$tblSales[27]."), SUM(c.".$tblSales[28]."), SUM(c.".$tblSales[29]."), c.".$tblSales[30].", SUM(c.".$tblSales[31]."), SUM(c.".$tblSales[32]."), SUM(c.".$tblSales[33]."), a.wingid, a.floorid FROM tblref_unit AS a INNER JOIN tbltrans_tenants AS b ON a.unitid = b.unitid INNER JOIN ".$tblSales[0]." AS c ON b.tenantid = c.tenantid WHERE a.wingid = '". $_POST['wingid'] ."' AND a.floorid = '". $row[0] ."' AND c.mallid = '".$_POST['mallid']."' ". getMallAccess("c.mallid", "AND") .";";
			}
			else if($year != "" && $month != "" && $day != ""){
				$sqlsales = " SELECT a.unitid, b.unitid, b.mallid, b.tenantid, c.tenantid, c.".$tblSales[1].", SUM(c.".$tblSales[4]."), SUM(c.".$tblSales[5]."), SUM(c.".$tblSales[6]."), SUM(c.".$tblSales[7]."), SUM(c.".$tblSales[8]."), SUM(c.".$tblSales[9]."), SUM(c.".$tblSales[10]."), SUM(c.".$tblSales[11]."), SUM(c.".$tblSales[12]."), SUM(c.".$tblSales[13]."), SUM(c.".$tblSales[14]."), SUM(c.".$tblSales[5]."), SUM(c.".$tblSales[16]."), SUM(c.".$tblSales[17]."), SUM(c.".$tblSales[18]."), SUM(c.".$tblSales[19]."), SUM(c.".$tblSales[20]."), SUM(c.".$tblSales[21]."), SUM(c.".$tblSales[22]."), SUM(c.".$tblSales[23]."), SUM(c.".$tblSales[24]."), SUM(c.".$tblSales[25]."), SUM(c.".$tblSales[26]."), SUM(c.".$tblSales[27]."), SUM(c.".$tblSales[28]."), SUM(c.".$tblSales[29]."), c.".$tblSales[30].", SUM(c.".$tblSales[31]."), SUM(c.".$tblSales[32]."), SUM(c.".$tblSales[33]."), a.wingid, a.floorid FROM tblref_unit AS a INNER JOIN tbltrans_tenants AS b ON a.unitid = b.unitid INNER JOIN ".$tblSales[0]." AS c ON b.tenantid = c.tenantid WHERE c.".$tblSales[1]." = '". $date1 ."' AND a.wingid = '". $_POST['wingid'] ."' AND a.floorid = '". $row[0] ."' AND c.mallid = '".$_POST['mallid']."' ". getMallAccess("c.mallid", "AND") .";";
			}
			else if($year != "" && $month != "" && $day == ""){
				$sqlsales = " SELECT a.unitid, b.unitid, b.mallid, b.tenantid, c.tenantid, c.".$tblSales[1].", SUM(c.".$tblSales[4]."), SUM(c.".$tblSales[5]."), SUM(c.".$tblSales[6]."), SUM(c.".$tblSales[7]."), SUM(c.".$tblSales[8]."), SUM(c.".$tblSales[9]."), SUM(c.".$tblSales[10]."), SUM(c.".$tblSales[11]."), SUM(c.".$tblSales[12]."), SUM(c.".$tblSales[13]."), SUM(c.".$tblSales[14]."), SUM(c.".$tblSales[5]."), SUM(c.".$tblSales[16]."), SUM(c.".$tblSales[17]."), SUM(c.".$tblSales[18]."), SUM(c.".$tblSales[19]."), SUM(c.".$tblSales[20]."), SUM(c.".$tblSales[21]."), SUM(c.".$tblSales[22]."), SUM(c.".$tblSales[23]."), SUM(c.".$tblSales[24]."), SUM(c.".$tblSales[25]."), SUM(c.".$tblSales[26]."), SUM(c.".$tblSales[27]."), SUM(c.".$tblSales[28]."), SUM(c.".$tblSales[29]."), c.".$tblSales[30].", SUM(c.".$tblSales[31]."), SUM(c.".$tblSales[32]."), SUM(c.".$tblSales[33]."), a.wingid, a.floorid, c.mallid FROM tblref_unit AS a INNER JOIN tbltrans_tenants AS b ON a.unitid = b.unitid INNER JOIN ".$tblSales[0]." AS c ON b.tenantid = c.tenantid WHERE YEAR(c.".$tblSales[1].") = '". $year ."' AND MONTH(c.".$tblSales[1].") = '". $month ."' AND a.wingid = '". $_POST['wingid'] ."' AND a.floorid = '". $row[0] ."' AND c.mallid = '".$_POST['mallid']."' ". getMallAccess("c.mallid", "AND") .";";
			}
			else if($year != "" && $month == "" && $day == ""){
				$sqlsales = " SELECT a.unitid, b.unitid, b.mallid, b.tenantid, c.tenantid, c.".$tblSales[1].", SUM(c.".$tblSales[4]."), SUM(c.".$tblSales[5]."), SUM(c.".$tblSales[6]."), SUM(c.".$tblSales[7]."), SUM(c.".$tblSales[8]."), SUM(c.".$tblSales[9]."), SUM(c.".$tblSales[10]."), SUM(c.".$tblSales[11]."), SUM(c.".$tblSales[12]."), SUM(c.".$tblSales[13]."), SUM(c.".$tblSales[14]."), SUM(c.".$tblSales[5]."), SUM(c.".$tblSales[16]."), SUM(c.".$tblSales[17]."), SUM(c.".$tblSales[18]."), SUM(c.".$tblSales[19]."), SUM(c.".$tblSales[20]."), SUM(c.".$tblSales[21]."), SUM(c.".$tblSales[22]."), SUM(c.".$tblSales[23]."), SUM(c.".$tblSales[24]."), SUM(c.".$tblSales[25]."), SUM(c.".$tblSales[26]."), SUM(c.".$tblSales[27]."), SUM(c.".$tblSales[28]."), SUM(c.".$tblSales[29]."), c.".$tblSales[30].", SUM(c.".$tblSales[31]."), SUM(c.".$tblSales[32]."), SUM(c.".$tblSales[33]."), a.wingid, a.floorid FROM tblref_unit AS a INNER JOIN tbltrans_tenants AS b ON a.unitid = b.unitid INNER JOIN ".$tblSales[0]." AS c ON b.tenantid = c.tenantid  WHERE YEAR(c.".$tblSales[1].") = '". $year ."' AND a.wingid = '". $_POST['wingid'] ."' AND a.floorid = '". $row[0] ."' AND c.mallid = '".$_POST['mallid']."' ". getMallAccess("c.mallid", "AND") .";";
			}
			else {
				echo "1";
			}
				$ressales = mysql_query($sqlsales, $connection);
				//echo $sqlsales;
				while($rowsales = mysql_fetch_array($ressales)){
					$table .= "
					<tr style='width: 100%;cursor: pointer !important;' onclick='unittypesales(\"".  $row[0] ."\");'>
					    <td style='text-align: left; width:1%; white-space:nowrap;'>". $row[1] ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". $year ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[8], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[9], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[10], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[11], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[12], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[13], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[15], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[16], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[17], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[18], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[19], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[20], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[21], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[22], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[23], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[24], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[25], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[26], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[27], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[28], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[29], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[30], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[31], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[32], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[33], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[34], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[35], 2, '.', ',') ."</td>
					</tr>";
				}
			}
				echo $table . "|" . $rowwing[0];
		break;

		case 'unittypesales':
			$sqlfloor = " SELECT floor FROM tblref_floorsetup WHERE mallid = '". $_POST['mallid'] ."' AND wingid = '". $_POST['wingid'] ."' AND floorid = '". $_POST['floorid'] ."' ";
			$resfloor = mysql_query($sqlfloor, $connection);
			$rowfloor = mysql_fetch_array($resfloor);

			$sql = " SELECT DISTINCT(typeofbusiness) FROM tblref_unit WHERE mallid = '". $_POST['mallid'] ."' AND wingid = '". $_POST['wingid'] ."' AND floorid = '". $_POST['floorid'] ."' "; 
			$res = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($res)){

			$year = $_POST['year'];
			$month = $_POST['month'];
			$day = $_POST['day'];
			$date1 = $_POST['year']."-".$_POST['month']."-".$_POST['day'];

			if($year == "" && $month == "" && $day == ""){
				$sqlsales = "SELECT a.unitid, b.unitid, b.mallid, b.tenantid, c.tenantid, c.".$tblSales[1].", SUM(c.".$tblSales[4]."), SUM(c.".$tblSales[5]."), SUM(c.".$tblSales[6]."), SUM(c.".$tblSales[7]."), SUM(c.".$tblSales[8]."), SUM(c.".$tblSales[9]."), SUM(c.".$tblSales[10]."), SUM(c.".$tblSales[11]."), SUM(c.".$tblSales[12]."), SUM(c.".$tblSales[13]."), SUM(c.".$tblSales[14]."), SUM(c.".$tblSales[5]."), SUM(c.".$tblSales[16]."), SUM(c.".$tblSales[17]."), SUM(c.".$tblSales[18]."), SUM(c.".$tblSales[19]."), SUM(c.".$tblSales[20]."), SUM(c.".$tblSales[21]."), SUM(c.".$tblSales[22]."), SUM(c.".$tblSales[23]."), SUM(c.".$tblSales[24]."), SUM(c.".$tblSales[25]."), SUM(c.".$tblSales[26]."), SUM(c.".$tblSales[27]."), SUM(c.".$tblSales[28]."), SUM(c.".$tblSales[29]."), c.".$tblSales[30].", SUM(c.".$tblSales[31]."), SUM(c.".$tblSales[32]."), SUM(c.".$tblSales[33]."), a.wingid, a.floorid, a.typeofbusiness FROM tblref_unit AS a INNER JOIN tbltrans_tenants AS b ON a.unitid = b.unitid INNER JOIN ".$tblSales[0]." AS c ON b.tenantid = c.tenantid WHERE a.wingid = '". $_POST['wingid'] ."' AND a.floorid = '". $_POST['floorid'] ."'  and a.typeofbusiness = '". $row[0] ."' AND c.mallid='".$_POST['mallid']."' ". getMallAccess("c.mallid", "AND") .";";
			}
			else if($year != "" && $month != "" && $day != ""){
				$sqlsales = " SELECT a.unitid, b.unitid, b.mallid, b.tenantid, c.tenantid, c.".$tblSales[1].", SUM(c.".$tblSales[4]."), SUM(c.".$tblSales[5]."), SUM(c.".$tblSales[6]."), SUM(c.".$tblSales[7]."), SUM(c.".$tblSales[8]."), SUM(c.".$tblSales[9]."), SUM(c.".$tblSales[10]."), SUM(c.".$tblSales[11]."), SUM(c.".$tblSales[12]."), SUM(c.".$tblSales[13]."), SUM(c.".$tblSales[14]."), SUM(c.".$tblSales[5]."), SUM(c.".$tblSales[16]."), SUM(c.".$tblSales[17]."), SUM(c.".$tblSales[18]."), SUM(c.".$tblSales[19]."), SUM(c.".$tblSales[20]."), SUM(c.".$tblSales[21]."), SUM(c.".$tblSales[22]."), SUM(c.".$tblSales[23]."), SUM(c.".$tblSales[24]."), SUM(c.".$tblSales[25]."), SUM(c.".$tblSales[26]."), SUM(c.".$tblSales[27]."), SUM(c.".$tblSales[28]."), SUM(c.".$tblSales[29]."), c.".$tblSales[30].", SUM(c.".$tblSales[31]."), SUM(c.".$tblSales[32]."), SUM(c.".$tblSales[33]."), a.wingid, a.floorid, a.typeofbusiness FROM tblref_unit AS a INNER JOIN tbltrans_tenants AS b ON a.unitid = b.unitid INNER JOIN ".$tblSales[0]." AS c ON b.tenantid = c.tenantid WHERE c.".$tblSales[1]." = '". $date1 ."' AND a.wingid = '". $_POST['wingid'] ."' AND a.floorid = '". $_POST['floorid'] ."' and a.typeofbusiness = '". $row[0] ."' AND c.mallid='".$_POST['mallid']."' ". getMallAccess("c.mallid", "AND") .";";
			}
			else if($year != "" && $month != "" && $day == ""){
				$sqlsales = " SELECT a.unitid, b.unitid, b.mallid, b.tenantid, c.tenantid, c.".$tblSales[1].", SUM(c.".$tblSales[4]."), SUM(c.".$tblSales[5]."), SUM(c.".$tblSales[6]."), SUM(c.".$tblSales[7]."), SUM(c.".$tblSales[8]."), SUM(c.".$tblSales[9]."), SUM(c.".$tblSales[10]."), SUM(c.".$tblSales[11]."), SUM(c.".$tblSales[12]."), SUM(c.".$tblSales[13]."), SUM(c.".$tblSales[14]."), SUM(c.".$tblSales[5]."), SUM(c.".$tblSales[16]."), SUM(c.".$tblSales[17]."), SUM(c.".$tblSales[18]."), SUM(c.".$tblSales[19]."), SUM(c.".$tblSales[20]."), SUM(c.".$tblSales[21]."), SUM(c.".$tblSales[22]."), SUM(c.".$tblSales[23]."), SUM(c.".$tblSales[24]."), SUM(c.".$tblSales[25]."), SUM(c.".$tblSales[26]."), SUM(c.".$tblSales[27]."), SUM(c.".$tblSales[28]."), SUM(c.".$tblSales[29]."), c.".$tblSales[30].", SUM(c.".$tblSales[31]."), SUM(c.".$tblSales[32]."), SUM(c.".$tblSales[33]."), a.wingid, a.floorid, a.typeofbusiness FROM tblref_unit AS a INNER JOIN tbltrans_tenants AS b ON a.unitid = b.unitid INNER JOIN ".$tblSales[0]." AS c ON b.tenantid = c.tenantid WHERE YEAR(c.".$tblSales[1].") = '". $year ."' AND MONTH(c.".$tblSales[1].") = '". $month ."' AND a.wingid = '". $_POST['wingid'] ."' AND a.floorid = '". $_POST['floorid'] ."' and a.typeofbusiness = '". $row[0] ."' AND c.mallid='".$_POST['mallid']."' ". getMallAccess("c.mallid", "AND") .";";
			}
			else if($year != "" && $month == "" && $day == ""){
				$sqlsales = "SELECT a.unitid, b.unitid, b.mallid, b.tenantid, c.tenantid, c.".$tblSales[1].", SUM(c.".$tblSales[4]."), SUM(c.".$tblSales[5]."), SUM(c.".$tblSales[6]."), SUM(c.".$tblSales[7]."), SUM(c.".$tblSales[8]."), SUM(c.".$tblSales[9]."), SUM(c.".$tblSales[10]."), SUM(c.".$tblSales[11]."), SUM(c.".$tblSales[12]."), SUM(c.".$tblSales[13]."), SUM(c.".$tblSales[14]."), SUM(c.".$tblSales[5]."), SUM(c.".$tblSales[16]."), SUM(c.".$tblSales[17]."), SUM(c.".$tblSales[18]."), SUM(c.".$tblSales[19]."), SUM(c.".$tblSales[20]."), SUM(c.".$tblSales[21]."), SUM(c.".$tblSales[22]."), SUM(c.".$tblSales[23]."), SUM(c.".$tblSales[24]."), SUM(c.".$tblSales[25]."), SUM(c.".$tblSales[26]."), SUM(c.".$tblSales[27]."), SUM(c.".$tblSales[28]."), SUM(c.".$tblSales[29]."), c.".$tblSales[30].", SUM(c.".$tblSales[31]."), SUM(c.".$tblSales[32]."), SUM(c.".$tblSales[33]."), a.wingid, a.floorid, a.typeofbusiness FROM tblref_unit AS a INNER JOIN tbltrans_tenants AS b ON a.unitid = b.unitid INNER JOIN ".$tblSales[0]." AS c ON b.tenantid = c.tenantid  WHERE YEAR(c.".$tblSales[1].") = '". $year ."' AND a.wingid = '". $_POST['wingid'] ."' AND a.floorid = '". $_POST['floorid'] ."' and a.typeofbusiness = '". $row[0] ."' AND c.mallid='".$_POST['mallid']."' ". getMallAccess("c.mallid", "AND") .";";
			}
			else {
				echo "1";
			}
				$ressales = mysql_query($sqlsales, $connection);
				while($rowsales = mysql_fetch_array($ressales)){
					$table .= "
					<tr style='width: 100%;cursor: pointer !important;' onclick='unitsales(\"".  $row[0] ."\");'>
					    <td style='text-align: left; width:1%; white-space:nowrap;'>". $row[0] ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". $year ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[8], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[9], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[10], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[11], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[12], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[13], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[15], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[16], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[17], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[18], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[19], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[20], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[21], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[22], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[23], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[24], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[25], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[26], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[27], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[28], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[29], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[30], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[31], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[32], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[33], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[34], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[35], 2, '.', ',') ."</td>
					</tr>";
				}
			}
				echo $table . "|" . $rowfloor[0];
		break;

		case 'unitsales':
			$sqlunittype = " SELECT DISTINCT(typeofbusiness) FROM tblref_unit WHERE mallid = '". $_POST['mallid'] ."' AND wingid = '". $_POST['wingid'] ."' AND floorid = '". $_POST['floorid'] ."' ";
			$resunittype = mysql_query($sqlunittype);
			$rowunittype = mysql_fetch_array($resunittype);

			$sql = " SELECT unitid, unitname FROM tblref_unit WHERE mallid = '". $_POST['mallid'] ."' AND wingid = '". $_POST['wingid'] ."' AND floorid = '". $_POST['floorid'] ."' AND typeofbusiness = '". $_POST['unittype'] ."' "; 
			$res = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($res)){

			$year = $_POST['year'];
			$month = $_POST['month'];
			$day = $_POST['day'];
			$date1 = $_POST['year']."-".$_POST['month']."-".$_POST['day'];

			if($year == "" && $month == "" && $day == ""){
				$sqlsales = " SELECT a.unitid, b.unitid, b.mallid, b.tenantid, c.tenantid, c.".$tblSales[1].", SUM(c.".$tblSales[4]."), SUM(c.".$tblSales[5]."), SUM(c.".$tblSales[6]."), SUM(c.".$tblSales[7]."), SUM(c.".$tblSales[8]."), SUM(c.".$tblSales[9]."), SUM(c.".$tblSales[10]."), SUM(c.".$tblSales[11]."), SUM(c.".$tblSales[12]."), SUM(c.".$tblSales[13]."), SUM(c.".$tblSales[14]."), SUM(c.".$tblSales[5]."), SUM(c.".$tblSales[16]."), SUM(c.".$tblSales[17]."), SUM(c.".$tblSales[18]."), SUM(c.".$tblSales[19]."), SUM(c.".$tblSales[20]."), SUM(c.".$tblSales[21]."), SUM(c.".$tblSales[22]."), SUM(c.".$tblSales[23]."), SUM(c.".$tblSales[24]."), SUM(c.".$tblSales[25]."), SUM(c.".$tblSales[26]."), SUM(c.".$tblSales[27]."), SUM(c.".$tblSales[28]."), SUM(c.".$tblSales[29]."), c.".$tblSales[30].", SUM(c.".$tblSales[31]."), SUM(c.".$tblSales[32]."), SUM(c.".$tblSales[33]."), a.wingid, a.floorid, a.typeofbusiness FROM tblref_unit AS a INNER JOIN tbltrans_tenants AS b ON a.unitid = b.unitid INNER JOIN ".$tblSales[0]." AS c ON b.tenantid = c.tenantid WHERE a.wingid = '". $_POST['wingid'] ."' AND a.floorid = '". $_POST['floorid'] ."'  and a.typeofbusiness = '". $_POST['unittype'] ."' AND a.unitid = '". $row[0] ."' AND c.mallid ='".$_POST['mallid']."' ". getMallAccess("c.mallid", "AND") .";";
			}
			else if($year != "" && $month != "" && $day != ""){
				$sqlsales = " SELECT a.unitid, b.unitid, b.mallid, b.tenantid, c.tenantid, c.".$tblSales[1].", SUM(c.".$tblSales[4]."), SUM(c.".$tblSales[5]."), SUM(c.".$tblSales[6]."), SUM(c.".$tblSales[7]."), SUM(c.".$tblSales[8]."), SUM(c.".$tblSales[9]."), SUM(c.".$tblSales[10]."), SUM(c.".$tblSales[11]."), SUM(c.".$tblSales[12]."), SUM(c.".$tblSales[13]."), SUM(c.".$tblSales[14]."), SUM(c.".$tblSales[5]."), SUM(c.".$tblSales[16]."), SUM(c.".$tblSales[17]."), SUM(c.".$tblSales[18]."), SUM(c.".$tblSales[19]."), SUM(c.".$tblSales[20]."), SUM(c.".$tblSales[21]."), SUM(c.".$tblSales[22]."), SUM(c.".$tblSales[23]."), SUM(c.".$tblSales[24]."), SUM(c.".$tblSales[25]."), SUM(c.".$tblSales[26]."), SUM(c.".$tblSales[27]."), SUM(c.".$tblSales[28]."), SUM(c.".$tblSales[29]."), c.".$tblSales[30].", SUM(c.".$tblSales[31]."), SUM(c.".$tblSales[32]."), SUM(c.".$tblSales[33]."), a.wingid, a.floorid, a.typeofbusiness FROM tblref_unit AS a INNER JOIN tbltrans_tenants AS b ON a.unitid = b.unitid INNER JOIN ".$tblSales[0]." AS c ON b.tenantid = c.tenantid WHERE c.".$tblSales[1]." = '". $date1 ."' AND a.wingid = '". $_POST['wingid'] ."' AND a.floorid = '". $_POST['floorid'] ."' and a.typeofbusiness = '". $_POST['unittype'] ."' AND a.unitid = '". $row[0] ."' AND c.mallid ='".$_POST['mallid']."' ". getMallAccess("c.mallid", "AND") .";";
			}
			else if($year != "" && $month != "" && $day == ""){
				$sqlsales = " SELECT a.unitid, b.unitid, b.mallid, b.tenantid, c.tenantid, c.".$tblSales[1].", SUM(c.".$tblSales[4]."), SUM(c.".$tblSales[5]."), SUM(c.".$tblSales[6]."), SUM(c.".$tblSales[7]."), SUM(c.".$tblSales[8]."), SUM(c.".$tblSales[9]."), SUM(c.".$tblSales[10]."), SUM(c.".$tblSales[11]."), SUM(c.".$tblSales[12]."), SUM(c.".$tblSales[13]."), SUM(c.".$tblSales[14]."), SUM(c.".$tblSales[5]."), SUM(c.".$tblSales[16]."), SUM(c.".$tblSales[17]."), SUM(c.".$tblSales[18]."), SUM(c.".$tblSales[19]."), SUM(c.".$tblSales[20]."), SUM(c.".$tblSales[21]."), SUM(c.".$tblSales[22]."), SUM(c.".$tblSales[23]."), SUM(c.".$tblSales[24]."), SUM(c.".$tblSales[25]."), SUM(c.".$tblSales[26]."), SUM(c.".$tblSales[27]."), SUM(c.".$tblSales[28]."), SUM(c.".$tblSales[29]."), c.".$tblSales[30].", SUM(c.".$tblSales[31]."), SUM(c.".$tblSales[32]."), SUM(c.".$tblSales[33]."), a.wingid, a.floorid, a.typeofbusiness FROM tblref_unit AS a INNER JOIN tbltrans_tenants AS b ON a.unitid = b.unitid INNER JOIN ".$tblSales[0]." AS c ON b.tenantid = c.tenantid WHERE YEAR(c.".$tblSales[1].") = '". $year ."' AND MONTH(c.".$tblSales[1].") = '". $month ."' AND a.wingid = '". $_POST['wingid'] ."' AND a.floorid = '". $_POST['floorid'] ."' and a.typeofbusiness = '". $_POST['unittype'] ."' AND a.unitid = '". $row[0] ."' AND c.mallid ='".$_POST['mallid']."' ". getMallAccess("c.mallid", "AND") .";";
			}
			else if($year != "" && $month == "" && $day == ""){
				$sqlsales = " SELECT a.unitid, b.unitid, b.mallid, b.tenantid, c.tenantid, c.".$tblSales[1].", SUM(c.".$tblSales[4]."), SUM(c.".$tblSales[5]."), SUM(c.".$tblSales[6]."), SUM(c.".$tblSales[7]."), SUM(c.".$tblSales[8]."), SUM(c.".$tblSales[9]."), SUM(c.".$tblSales[10]."), SUM(c.".$tblSales[11]."), SUM(c.".$tblSales[12]."), SUM(c.".$tblSales[13]."), SUM(c.".$tblSales[14]."), SUM(c.".$tblSales[5]."), SUM(c.".$tblSales[16]."), SUM(c.".$tblSales[17]."), SUM(c.".$tblSales[18]."), SUM(c.".$tblSales[19]."), SUM(c.".$tblSales[20]."), SUM(c.".$tblSales[21]."), SUM(c.".$tblSales[22]."), SUM(c.".$tblSales[23]."), SUM(c.".$tblSales[24]."), SUM(c.".$tblSales[25]."), SUM(c.".$tblSales[26]."), SUM(c.".$tblSales[27]."), SUM(c.".$tblSales[28]."), SUM(c.".$tblSales[29]."), c.".$tblSales[30].", SUM(c.".$tblSales[31]."), SUM(c.".$tblSales[32]."), SUM(c.".$tblSales[33]."), a.wingid, a.floorid, a.typeofbusiness FROM tblref_unit AS a INNER JOIN tbltrans_tenants AS b ON a.unitid = b.unitid INNER JOIN ".$tblSales[0]." AS c ON b.tenantid = c.tenantid  WHERE YEAR(c.".$tblSales[1].") = '". $year ."' AND a.wingid = '". $_POST['wingid'] ."' AND a.floorid = '". $_POST['floorid'] ."' and a.typeofbusiness = '". $_POST['unittype'] ."' AND a.unitid = '". $row[0] ."' AND c.mallid ='".$_POST['mallid']."' ". getMallAccess("c.mallid", "AND") .";";
			}
			else {
				echo "1";
			}
				$ressales = mysql_query($sqlsales, $connection);
				while($rowsales = mysql_fetch_array($ressales)){
					$table .= "
					<tr style='width: 100%;cursor: pointer !important;' onclick='checkfilterofdate(\"".  $row[0] ."\");'>
					    <td style='text-align: left; width:1%; white-space:nowrap;'>". $row[1] ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". $year ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[8], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[9], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[10], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[11], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[12], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[13], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[15], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[16], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[17], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[18], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[19], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[20], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[21], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[22], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[23], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[24], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[25], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[26], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[27], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[28], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[29], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[30], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[31], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[32], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[33], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[34], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[35], 2, '.', ',') ."</td>
					</tr>";
				}
			}
				echo $table . "|" . $rowunittype[0];
		break;

		case 'tenantsales':
			$sqlunit = " SELECT unitname FROM tblref_unit WHERE mallid = '". $_POST['mallid'] ."' AND wingid = '". $_POST['wingid'] ."' AND floorid = '". $_POST['floorid'] ."' AND typeofbusiness = '". $_POST['unittype'] ."' "; 
			$resunit = mysql_query($sqlunit, $connection);
			$rowunit = mysql_fetch_array($resunit);

			$sql = " SELECT tenantid, tradename FROM tbltrans_tenants WHERE unitid = '". $_POST['unitid'] ."' "; 
			$res = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($res)){

				$sqlcheckpenalty = " SELECT xdescription, xdate, tenantid FROM tbltransaction WHERE tenantid = '". $row[0] ."' AND xdescription = 'Penalty' ";
				$rescheckpenalty = mysql_query($sqlcheckpenalty, $connection);
				$rowcheckpenalty = mysql_fetch_array($rescheckpenalty);

			$year = $_POST['year'];
			$month = $_POST['month'];
			$day = $_POST['day'];
			$date1 = $_POST['year']."-".$_POST['month']."-".$_POST['day'];

			if($year == "" && $month == "" && $day == ""){
				$sqlsales = " SELECT tenantid, ".$tblSales[1].", SUM(".$tblSales[4]."), SUM(".$tblSales[5]."), SUM(".$tblSales[6]."), SUM(".$tblSales[7]."), SUM(".$tblSales[7]."), SUM(".$tblSales[8]."), SUM(".$tblSales[9]."), SUM(".$tblSales[10]."), SUM(".$tblSales[11]."), SUM(".$tblSales[12]."), SUM(".$tblSales[13]."), SUM(".$tblSales[14]."), SUM(".$tblSales[15]."), SUM(".$tblSales[16]."), SUM(".$tblSales[17]."), SUM(".$tblSales[18]."), SUM(".$tblSales[19]."), SUM(".$tblSales[20]."), SUM(".$tblSales[21]."), SUM(".$tblSales[22]."), SUM(".$tblSales[23]."), SUM(".$tblSales[24]."), SUM(".$tblSales[25]."), SUM(".$tblSales[26]."), SUM(".$tblSales[27]."), SUM(".$tblSales[28]."), ".$tblSales[28].", SUM(".$tblSales[29]."), SUM(".$tblSales[30]."), SUM(".$tblSales[31].") FROM ".$tblSales[0]." WHERE tenantid = '". $row[0] ."' AND mallid = '".$_POST['mallid']."' ". getMallAccess("c.mallid", "AND") .";";
			}
			else if($year != "" && $month != "" && $day != ""){
				$sqlsales = " SELECT tenantid, ".$tblSales[1].", SUM(".$tblSales[4]."), SUM(".$tblSales[5]."), SUM(".$tblSales[6]."), SUM(".$tblSales[7]."), SUM(".$tblSales[7]."), SUM(".$tblSales[8]."), SUM(".$tblSales[9]."), SUM(".$tblSales[10]."), SUM(".$tblSales[11]."), SUM(".$tblSales[12]."), SUM(".$tblSales[13]."), SUM(".$tblSales[14]."), SUM(".$tblSales[15]."), SUM(".$tblSales[16]."), SUM(".$tblSales[17]."), SUM(".$tblSales[18]."), SUM(".$tblSales[19]."), SUM(".$tblSales[20]."), SUM(".$tblSales[21]."), SUM(".$tblSales[22]."), SUM(".$tblSales[23]."), SUM(".$tblSales[24]."), SUM(".$tblSales[25]."), SUM(".$tblSales[26]."), SUM(".$tblSales[27]."), SUM(".$tblSales[28]."), ".$tblSales[28].", SUM(".$tblSales[29]."), SUM(".$tblSales[30]."), SUM(".$tblSales[31].") FROM ".$tblSales[0]." WHERE ".$tblSales[1]." = '". $date1 ."' AND tenantid = '". $row[0] ."' AND mallid = '".$_POST['mallid']."' ". getMallAccess("c.mallid", "AND") .";";
			}
			else if($year != "" && $month != "" && $day == ""){
				$sqlsales = " SELECT tenantid, ".$tblSales[1].", SUM(".$tblSales[4]."), SUM(".$tblSales[5]."), SUM(".$tblSales[6]."), SUM(".$tblSales[7]."), SUM(".$tblSales[7]."), SUM(".$tblSales[8]."), SUM(".$tblSales[9]."), SUM(".$tblSales[10]."), SUM(".$tblSales[11]."), SUM(".$tblSales[12]."), SUM(".$tblSales[13]."), SUM(".$tblSales[14]."), SUM(".$tblSales[15]."), SUM(".$tblSales[16]."), SUM(".$tblSales[17]."), SUM(".$tblSales[18]."), SUM(".$tblSales[19]."), SUM(".$tblSales[20]."), SUM(".$tblSales[21]."), SUM(".$tblSales[22]."), SUM(".$tblSales[23]."), SUM(".$tblSales[24]."), SUM(".$tblSales[25]."), SUM(".$tblSales[26]."), SUM(".$tblSales[27]."), SUM(".$tblSales[28]."), ".$tblSales[28].", SUM(".$tblSales[29]."), SUM(".$tblSales[30]."), SUM(".$tblSales[31].") FROM ".$tblSales[0]." WHERE YEAR(".$tblSales[1].") = '". $year ."' AND MONTH(".$tblSales[1].") = '". $month ."' AND tenantid = '". $row[0] ."' AND mallid = '".$_POST['mallid']."' ". getMallAccess("c.mallid", "AND") .";";
			}
			else if($year != "" && $month == "" && $day == ""){
				$sqlsales = " SELECT tenantid, ".$tblSales[1].", SUM(".$tblSales[4]."), SUM(".$tblSales[5]."), SUM(".$tblSales[6]."), SUM(".$tblSales[7]."), SUM(".$tblSales[7]."), SUM(".$tblSales[8]."), SUM(".$tblSales[9]."), SUM(".$tblSales[10]."), SUM(".$tblSales[11]."), SUM(".$tblSales[12]."), SUM(".$tblSales[13]."), SUM(".$tblSales[14]."), SUM(".$tblSales[15]."), SUM(".$tblSales[16]."), SUM(".$tblSales[17]."), SUM(".$tblSales[18]."), SUM(".$tblSales[19]."), SUM(".$tblSales[20]."), SUM(".$tblSales[21]."), SUM(".$tblSales[22]."), SUM(".$tblSales[23]."), SUM(".$tblSales[24]."), SUM(".$tblSales[25]."), SUM(".$tblSales[26]."), SUM(".$tblSales[27]."), SUM(".$tblSales[28]."), ".$tblSales[28].", SUM(".$tblSales[29]."), SUM(".$tblSales[30]."), SUM(".$tblSales[31].") FROM ".$tblSales[0]." WHERE YEAR(".$tblSales[1].") = '". $year ."' AND tenantid = '". $row[0] ."' AND mallid = '".$_POST['mallid']."' ". getMallAccess("c.mallid", "AND") .";";
			}
			else {
				echo "1";
			}
				$ressales = mysql_query($sqlsales, $connection);
				while($rowsales = mysql_fetch_array($ressales)){
					
					echo "<tr style='width: 100%;' onclick='tenantsalesbymonth(\"".  $row[0] ."\")'>
					    <td style='text-align: left; width:1%; white-space:nowrap; cursor: pointer !important;'>". $row[1] ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap; cursor: pointer !important;'>". $year ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap; cursor: pointer !important;'>". number_format($rowsales[4], 2, '.', ',')."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[5], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[6], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[7], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[8], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[9], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[10], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[11], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[12], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[13], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[14], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[15], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[16], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[17], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[18], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[19], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[20], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[21], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[22], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[23], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[24], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[25], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[26], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[27], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[29], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[30], 2, '.', ',') ."</td>
						<td style='text-align: left; width:1%; white-space:nowrap;'>". number_format($rowsales[31], 2, '.', ',') ."</td>
						</tr>";
					 
				}
			}
			echo "|". $rowunit[0];
		break;

		case 'tenantsalesbymonth':
			$sql2 = " SELECT tenantid, tradename FROM tbltrans_tenants WHERE unitid = '". $_POST['unitid'] ."' "; 
			$res2 = mysql_query($sql2, $connection);
			$row2 = mysql_fetch_array($res2);

			$sqlunit = " SELECT unitname FROM tblref_unit WHERE mallid = '". $_POST['mallid'] ."' AND wingid = '". $_POST['wingid'] ."' AND floorid = '". $_POST['floorid'] ."' AND typeofbusiness = '". $_POST['unittype'] ."' "; 
			$resunit = mysql_query($sqlunit, $connection);
			$rowunit = mysql_fetch_array($resunit);

			$sql = " SELECT tenantid, tradename FROM tbltrans_tenants WHERE unitid = '". $_POST['unitid'] ."' "; 
			$res = mysql_query($sql, $connection);
			$countngid = 1;
			while($row = mysql_fetch_array($res)){

				$sqlcheckpenalty = " SELECT xdescription, xdate, tenantid FROM tbltransaction WHERE tenantid = '". $row[0] ."' AND xdescription = 'Penalty'";
				$rescheckpenalty = mysql_query($sqlcheckpenalty, $connection);
				$rowcheckpenalty = mysql_fetch_array($rescheckpenalty);

			$year = $_POST['year'];
			$month = $_POST['month'];
			$day = $_POST['day'];
			$date1 = $_POST['year']."-".$_POST['month']."-".$_POST['day'];

			if($year == "" && $month == "" && $day == ""){
				$sqlsales = " SELECT tenantid, ".$tblSales[1].", SUM(".$tblSales[4]."), SUM(".$tblSales[5]."), SUM(".$tblSales[6]."), SUM(".$tblSales[7]."), SUM(".$tblSales[7]."), SUM(".$tblSales[8]."), SUM(".$tblSales[9]."), SUM(".$tblSales[10]."), SUM(".$tblSales[11]."), SUM(".$tblSales[12]."), SUM(".$tblSales[13]."), SUM(".$tblSales[14]."), SUM(".$tblSales[15]."), SUM(".$tblSales[16]."), SUM(".$tblSales[17]."), SUM(".$tblSales[18]."), SUM(".$tblSales[19]."), SUM(".$tblSales[20]."), SUM(".$tblSales[21]."), SUM(".$tblSales[22]."), SUM(".$tblSales[23]."), SUM(".$tblSales[24]."), SUM(".$tblSales[25]."), SUM(".$tblSales[26]."), SUM(".$tblSales[27]."), SUM(".$tblSales[28]."), ".$tblSales[28].", SUM(".$tblSales[29]."), SUM(".$tblSales[30]."), SUM(".$tblSales[31].") FROM ".$tblSales[0]." WHERE mallid = '". $_POST['mallid'] ."' AND tenantid = '". $row[0] ."' ". getMallAccess("c.mallid", "AND") ." GROUP BY MONTH(".$tblSales[1].") ";
			}
			else if($year != "" && $month != "" && $day != ""){
				$sqlsales = " SELECT tenantid, ".$tblSales[1].", SUM(".$tblSales[4]."), SUM(".$tblSales[5]."), SUM(".$tblSales[6]."), SUM(".$tblSales[7]."), SUM(".$tblSales[7]."), SUM(".$tblSales[8]."), SUM(".$tblSales[9]."), SUM(".$tblSales[10]."), SUM(".$tblSales[11]."), SUM(".$tblSales[12]."), SUM(".$tblSales[13]."), SUM(".$tblSales[14]."), SUM(".$tblSales[15]."), SUM(".$tblSales[16]."), SUM(".$tblSales[17]."), SUM(".$tblSales[18]."), SUM(".$tblSales[19]."), SUM(".$tblSales[20]."), SUM(".$tblSales[21]."), SUM(".$tblSales[22]."), SUM(".$tblSales[23]."), SUM(".$tblSales[24]."), SUM(".$tblSales[25]."), SUM(".$tblSales[26]."), SUM(".$tblSales[27]."), SUM(".$tblSales[28]."), ".$tblSales[28].", SUM(".$tblSales[29]."), SUM(".$tblSales[30]."), SUM(".$tblSales[31].") FROM ".$tblSales[0]." WHERE mallid = '". $_POST['mallid'] ."' AND ".$tblSales[1]." = '". $date1 ."' AND tenantid = '". $row[0] ."' ". getMallAccess("c.mallid", "AND") ." GROUP BY MONTH(".$tblSales[1].") ";
			}
			else if($year != "" && $month != "" && $day == ""){
				$sqlsales = " SELECT tenantid, ".$tblSales[1].", SUM(".$tblSales[4]."), SUM(".$tblSales[5]."), SUM(".$tblSales[6]."), SUM(".$tblSales[7]."), SUM(".$tblSales[7]."), SUM(".$tblSales[8]."), SUM(".$tblSales[9]."), SUM(".$tblSales[10]."), SUM(".$tblSales[11]."), SUM(".$tblSales[12]."), SUM(".$tblSales[13]."), SUM(".$tblSales[14]."), SUM(".$tblSales[15]."), SUM(".$tblSales[16]."), SUM(".$tblSales[17]."), SUM(".$tblSales[18]."), SUM(".$tblSales[19]."), SUM(".$tblSales[20]."), SUM(".$tblSales[21]."), SUM(".$tblSales[22]."), SUM(".$tblSales[23]."), SUM(".$tblSales[24]."), SUM(".$tblSales[25]."), SUM(".$tblSales[26]."), SUM(".$tblSales[27]."), SUM(".$tblSales[28]."), ".$tblSales[28].", SUM(".$tblSales[29]."), SUM(".$tblSales[30]."), SUM(".$tblSales[31].") FROM ".$tblSales[0]." WHERE mallid = '". $_POST['mallid'] ."' AND YEAR(".$tblSales[1].") = '". $year ."' AND MONTH(".$tblSales[1].") = '". $month ."' AND tenantid = '". $row[0] ."' ". getMallAccess("c.mallid", "AND") ." GROUP BY MONTH(".$tblSales[1].") ";
			}
			else if($year != "" && $month == "" && $day == ""){
				$sqlsales = " SELECT tenantid, ".$tblSales[1].", SUM(".$tblSales[4]."), SUM(".$tblSales[5]."), SUM(".$tblSales[6]."), SUM(".$tblSales[7]."), SUM(".$tblSales[7]."), SUM(".$tblSales[8]."), SUM(".$tblSales[9]."), SUM(".$tblSales[10]."), SUM(".$tblSales[11]."), SUM(".$tblSales[12]."), SUM(".$tblSales[13]."), SUM(".$tblSales[14]."), SUM(".$tblSales[15]."), SUM(".$tblSales[16]."), SUM(".$tblSales[17]."), SUM(".$tblSales[18]."), SUM(".$tblSales[19]."), SUM(".$tblSales[20]."), SUM(".$tblSales[21]."), SUM(".$tblSales[22]."), SUM(".$tblSales[23]."), SUM(".$tblSales[24]."), SUM(".$tblSales[25]."), SUM(".$tblSales[26]."), SUM(".$tblSales[27]."), SUM(".$tblSales[28]."), ".$tblSales[28].", SUM(".$tblSales[29]."), SUM(".$tblSales[30]."), SUM(".$tblSales[31].") FROM ".$tblSales[0]." WHERE mallid = '". $_POST['mallid'] ."' AND YEAR(".$tblSales[1].") = '". $year ."' AND tenantid = '". $row[0] ."' ". getMallAccess("c.mallid", "AND") ." GROUP BY MONTH(".$tblSales[1].") ";
			}
			else {
				echo "1";
			}

				$ressales = mysql_query($sqlsales, $connection);
				while($rowsales = mysql_fetch_array($ressales)){

					$penaltydate = date('Y-m-d', strtotime($rowcheckpenalty[1]. '-1 month'));
					$labasmoko .= date('F', strtotime($rowsales[1]))." ".$year;
					?> <?php
					
					echo "<tr style='width: 100%;' onclick='tenantsalesbyday(\"".  date('m', strtotime($rowsales[1])) ."\",\"".  $row[0] ."\");'>"; ?>
					    <td style='text-align: left; width:1%; white-space:nowrap; cursor: pointer !important;'><?php echo $row[1]; ?></td>
					    <td style='text-align: left; width:1%; white-space:nowrap; cursor: pointer !important;'><?php echo date('F', strtotime($rowsales[1]))." ".$year; ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap; cursor: pointer !important;'><?php echo number_format($rowsales[4], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[5], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[6], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[7], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[8], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[9], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[10], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[11], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[12], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[13], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[14], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[15], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[16], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[17], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[18], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[19], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[20], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[21], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[22], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[23], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[24], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[25], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[26], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[27], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[29], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[30], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[31], 2, '.', ','); ?></td>
					</tr>
					<?php
				}
			}
			echo "|". $row2[1]." ".$year.$month.$day. "|" . $rowunit[0];
		break;

		case 'tenantsalesbyday':
			$year = $_POST['year'];
			$month = $_POST['month'];
			$day = $_POST['day'];
			$date1 = $_POST['year']."-".$_POST['month']."-".$_POST['day'];

			$sql = " SELECT tenantid, tradename FROM tbltrans_tenants WHERE tenantid = '". $_POST['tenantid'] ."' "; 
			$res = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($res)){

			if($year == "" && $month == "" && $day == ""){
				$sqlsales = " SELECT tenantid, ".$tblSales[1].", SUM(".$tblSales[4]."), SUM(".$tblSales[5]."), SUM(".$tblSales[6]."), SUM(".$tblSales[7]."), SUM(".$tblSales[7]."), SUM(".$tblSales[8]."), SUM(".$tblSales[9]."), SUM(".$tblSales[10]."), SUM(".$tblSales[11]."), SUM(".$tblSales[12]."), SUM(".$tblSales[13]."), SUM(".$tblSales[14]."), SUM(".$tblSales[15]."), SUM(".$tblSales[16]."), SUM(".$tblSales[17]."), SUM(".$tblSales[18]."), SUM(".$tblSales[19]."), SUM(".$tblSales[20]."), SUM(".$tblSales[21]."), SUM(".$tblSales[22]."), SUM(".$tblSales[23]."), SUM(".$tblSales[24]."), SUM(".$tblSales[25]."), SUM(".$tblSales[26]."), SUM(".$tblSales[27]."), SUM(".$tblSales[28]."), ".$tblSales[28].", SUM(".$tblSales[29]."), SUM(".$tblSales[30]."), SUM(".$tblSales[31].") FROM ".$tblSales[0]." WHERE mallid = '".$_POST['mallid']."' AND tenantid = '". $row[0] ."' AND YEAR(".$tblSales[1].") = '". $year ."' AND MONTH(".$tblSales[1].") = '". $_POST['tenantmonth'] ."' ". getMallAccess("c.mallid", "AND") ." GROUP BY Day(".$tblSales[1].") ";
			}
			else if($year != "" && $month != "" && $day != ""){
				$sqlsales = " SELECT tenantid, ".$tblSales[1].", SUM(".$tblSales[4]."), SUM(".$tblSales[5]."), SUM(".$tblSales[6]."), SUM(".$tblSales[7]."), SUM(".$tblSales[7]."), SUM(".$tblSales[8]."), SUM(".$tblSales[9]."), SUM(".$tblSales[10]."), SUM(".$tblSales[11]."), SUM(".$tblSales[12]."), SUM(".$tblSales[13]."), SUM(".$tblSales[14]."), SUM(".$tblSales[15]."), SUM(".$tblSales[16]."), SUM(".$tblSales[17]."), SUM(".$tblSales[18]."), SUM(".$tblSales[19]."), SUM(".$tblSales[20]."), SUM(".$tblSales[21]."), SUM(".$tblSales[22]."), SUM(".$tblSales[23]."), SUM(".$tblSales[24]."), SUM(".$tblSales[25]."), SUM(".$tblSales[26]."), SUM(".$tblSales[27]."), SUM(".$tblSales[28]."), ".$tblSales[28].", SUM(".$tblSales[29]."), SUM(".$tblSales[30]."), SUM(".$tblSales[31].") FROM ".$tblSales[0]." WHERE mallid = '".$_POST['mallid']."' AND tenantid = '". $row[0] ."' AND YEAR(".$tblSales[1].") = '". $year ."' AND MONTH(".$tblSales[1].") = '". $_POST['tenantmonth'] ."' ". getMallAccess("c.mallid", "AND") ." GROUP BY Day(".$tblSales[1].") ";
			}
			else if($year != "" && $month != "" && $day == ""){
				$sqlsales = " SELECT tenantid, ".$tblSales[1].", SUM(".$tblSales[4]."), SUM(".$tblSales[5]."), SUM(".$tblSales[6]."), SUM(".$tblSales[7]."), SUM(".$tblSales[7]."), SUM(".$tblSales[8]."), SUM(".$tblSales[9]."), SUM(".$tblSales[10]."), SUM(".$tblSales[11]."), SUM(".$tblSales[12]."), SUM(".$tblSales[13]."), SUM(".$tblSales[14]."), SUM(".$tblSales[15]."), SUM(".$tblSales[16]."), SUM(".$tblSales[17]."), SUM(".$tblSales[18]."), SUM(".$tblSales[19]."), SUM(".$tblSales[20]."), SUM(".$tblSales[21]."), SUM(".$tblSales[22]."), SUM(".$tblSales[23]."), SUM(".$tblSales[24]."), SUM(".$tblSales[25]."), SUM(".$tblSales[26]."), SUM(".$tblSales[27]."), SUM(".$tblSales[28]."), ".$tblSales[28].", SUM(".$tblSales[29]."), SUM(".$tblSales[30]."), SUM(".$tblSales[31].") FROM ".$tblSales[0]." WHERE mallid = '".$_POST['mallid']."' AND tenantid = '". $row[0] ."' AND YEAR(".$tblSales[1].") = '". $year ."' AND MONTH(".$tblSales[1].") = '". $_POST['tenantmonth'] ."' ". getMallAccess("c.mallid", "AND") ." GROUP BY Day(".$tblSales[1].") ";
			}
			else if($year != "" && $month == "" && $day == ""){
				$sqlsales = " SELECT tenantid, ".$tblSales[1].", SUM(".$tblSales[4]."), SUM(".$tblSales[5]."), SUM(".$tblSales[6]."), SUM(".$tblSales[7]."), SUM(".$tblSales[7]."), SUM(".$tblSales[8]."), SUM(".$tblSales[9]."), SUM(".$tblSales[10]."), SUM(".$tblSales[11]."), SUM(".$tblSales[12]."), SUM(".$tblSales[13]."), SUM(".$tblSales[14]."), SUM(".$tblSales[15]."), SUM(".$tblSales[16]."), SUM(".$tblSales[17]."), SUM(".$tblSales[18]."), SUM(".$tblSales[19]."), SUM(".$tblSales[20]."), SUM(".$tblSales[21]."), SUM(".$tblSales[22]."), SUM(".$tblSales[23]."), SUM(".$tblSales[24]."), SUM(".$tblSales[25]."), SUM(".$tblSales[26]."), SUM(".$tblSales[27]."), SUM(".$tblSales[28]."), ".$tblSales[28].", SUM(".$tblSales[29]."), SUM(".$tblSales[30]."), SUM(".$tblSales[31].") FROM ".$tblSales[0]." WHERE mallid = '".$_POST['mallid']."' AND tenantid = '". $row[0] ."' AND YEAR(".$tblSales[1].") = '". $year ."' AND MONTH(".$tblSales[1].") = '". $_POST['tenantmonth'] ."' ". getMallAccess("c.mallid", "AND") ." GROUP BY Day(".$tblSales[1].") ";
			}
			else {
				echo "1";
			}
				$ressales = mysql_query($sqlsales, $connection);
				//echo $sqlsales;
				while($rowsales = mysql_fetch_array($ressales)){
					?> 
					<?php echo "<tr style='width: 100%;'>"; ?>
					    <td style='text-align: left; width:1%; white-space:nowrap;'><?php echo $row[1]; ?></td>
					    <td style='text-align: left; width:1%; white-space:nowrap;'><?php echo date('F', strtotime($rowsales[1]))." ".date('d', strtotime($rowsales[1])).",".$year ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[4], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[5], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[6], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[7], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[8], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[9], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[10], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[11], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[12], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[13], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[14], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[15], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[16], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[17], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[18], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[19], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[20], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[21], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[22], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[23], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[24], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[25], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[26], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[27], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[29], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[30], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[31], 2, '.', ','); ?></td>
					</tr>";
				<?php
				}
			}

			echo "|". $row[1].date('F', strtotime($month))." ".$year. "|" ."Daily Sales For the month of ".date('F', strtotime($month))." ".$year ;
		break;

		case 'tenantsalesbyday3':
			$year = $_POST['year'];
			$month = $_POST['month'];
			$day = $_POST['day'];
			$date1 = $_POST['year']."-".$_POST['month']."-".$_POST['day'];

			$sql2 = " SELECT unitid, unitname FROM tblref_unit WHERE mallid = '". $_POST['mallid'] ."' AND wingid = '". $_POST['wingid'] ."' AND floorid = '". $_POST['floorid'] ."' AND typeofbusiness = '". $_POST['unittype'] ."' "; 
			$res2 = mysql_query($sql2, $connection);
			$row2 = mysql_fetch_array($res2);

			$sql3 = " SELECT tenantid, tradename FROM tbltrans_tenants WHERE unitid = '". $_POST['unitid'] ."' "; 
			$res3 = mysql_query($sql3, $connection);
			$row3 = mysql_fetch_array($res3);

			$sql = " SELECT tenantid, tradename FROM tbltrans_tenants WHERE unitid = '". $_POST['unitid'] ."' "; 
			$res = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($res)){

				$sqlcheckpenalty = " SELECT xdescription, xdate, tenantid FROM tbltransaction WHERE tenantid = '". $row[0] ."' AND xdescription = 'Penalty'";
				$rescheckpenalty = mysql_query($sqlcheckpenalty, $connection);
				$rowcheckpenalty = mysql_fetch_array($rescheckpenalty);

			$sqlsales = " SELECT tenantid, ".$tblSales[1].", SUM(".$tblSales[4]."), SUM(".$tblSales[5]."), SUM(".$tblSales[6]."), SUM(".$tblSales[7]."), SUM(".$tblSales[7]."), SUM(".$tblSales[8]."), SUM(".$tblSales[9]."), SUM(".$tblSales[10]."), SUM(".$tblSales[11]."), SUM(".$tblSales[12]."), SUM(".$tblSales[13]."), SUM(".$tblSales[14]."), SUM(".$tblSales[15]."), SUM(".$tblSales[16]."), SUM(".$tblSales[17]."), SUM(".$tblSales[18]."), SUM(".$tblSales[19]."), SUM(".$tblSales[20]."), SUM(".$tblSales[21]."), SUM(".$tblSales[22]."), SUM(".$tblSales[23]."), SUM(".$tblSales[24]."), SUM(".$tblSales[25]."), SUM(".$tblSales[26]."), SUM(".$tblSales[27]."), SUM(".$tblSales[28]."), ".$tblSales[28].", SUM(".$tblSales[29]."), SUM(".$tblSales[30]."), SUM(".$tblSales[31].") FROM ".$tblSales[0]." WHERE tenantid = '". $row[0] ."' AND ".$tblSales[1]." = '". $date1 ."' GROUP BY Day(".$tblSales[1].") ";
				$ressales = mysql_query($sqlsales, $connection);
				while($rowsales = mysql_fetch_array($ressales)){

					?>
					<?php echo "<tr style='width: 100%;' id='".  $row[0] ."'> "; ?>
					    <td style='text-align: left; width:1%; white-space:nowrap;'><?php echo $row[1]; ?></td>
					    <td style='text-align: left; width:1%; white-space:nowrap;'><?php echo date('F', strtotime($rowsales[1]))." ".date('d', strtotime($rowsales[1])).",".$year ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[4], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[5], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[6], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[7], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[8], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[9], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[10], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[11], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[12], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[13], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[14], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[15], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[16], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[17], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[18], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[19], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[20], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[21], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[22], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[23], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[24], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[25], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[26], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[27], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[29], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[30], 2, '.', ','); ?></td>
						<td style='text-align: left; width:1%; white-space:nowrap;'><?php echo number_format($rowsales[31], 2, '.', ','); ?></td>
					</tr>";
				<?php
				}
			}
			echo "|". $row3[1]. " (".date('F d, Y', strtotime($date1)).")". "|" . $row2[1];
		break;
	}
?>