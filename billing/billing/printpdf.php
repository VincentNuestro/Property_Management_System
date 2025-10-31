<?php
//============================================================+
// File name   : example_061.php
// Begin       : 2010-05-24
// Last Update : 2014-01-25
//
// Description : Example 061 for TCPDF class
//               XHTML + CSS
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: XHTML + CSS
 * @author Nicola Asuni
 * @since 2010-05-25
 */

// Include the main TCPDF library (search for installation path).
include('../assets/tcpdf/tcpdf.php');

class MYPDF extends TCPDF {
   //public function Header() {
   //     $this->SetY(5);
   //     $this->SetTextColor(126, 173, 247);
   //     $this->SetFont('helvetica', '', 8);
   //     // $headerPDF = '
   //     // 	<table style="width:100%;">
   //     // 		<tr>
   //     // 			<td style="width:20%" valign="top">
   //     // 				<img src="../images/logo2.png"/>
   //     // 				<br/>
   //     // 			</td>
   //     // 		</tr>
   //     // 	</table>
   //     // ';
   //     $headerPDF = '
   //
   //     ';
   //     $this->writeHTMLCell(0, 0, '', '', $headerPDF, 0, 1, 0, true, '', true);
   // }

   public function Footer() {
        $this->SetY(-39);
       $this->SetFont('helvetica', '', 8);
        $footerPDF = '';
        $this->writeHTMLCell(0, 0, '', '', $footerPDF, 0, 1, 0, false, '', false);
	   $this->Cell(350, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
       
    }
    //public function Header() {
    //    // Logo
    //    $image_file = K_PATH_IMAGES.'logo_example.jpg';
    //    $this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    //    // Set font
    //    $this->SetFont('helvetica', 'B', 20);
    //    // Title
    //    $this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    //}
    //
    //// Page footer
    //public function Footer() {
    //    // Position at 15 mm from bottom
    //    $this->SetY(-15);
    //    // Set font
    //    $this->SetFont('helvetica', 'I', 8);
    //    // Page number
    //    $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    //}



    
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Gatessoft Corp');
$pdf->SetTitle('');
$pdf->SetSubject('');
$pdf->SetKeywords('');

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 061', PDF_HEADER_STRING);
$pdf->setPrintHeader(false);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->SetAutoPageBreak(true, 55);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '', 10);

// add a page
$pdf->AddPage();

/* NOTE:
 * *********************************************************
 * You can load external XHTML using :
 *
 * $html = file_get_contents('/path/to/your/file.html');
 *
 * External CSS files will be automatically loaded.
 * Sometimes you need to fix the path of the external CSS.
 * *********************************************************
 */

	session_start();
	include('../connect.php');
		$filename = "Cashier's Audit ".date('F d, Y').".pdf";
		$template = mysql_fetch_array(mysql_query("SELECT template FROM tblsys_setup"));
			$row = mysql_fetch_array(mysql_query("SELECT mallname, malladdress, telephone_number, email, mall_image FROM tblref_mall WHERE mallid = '".$_GET["mallid"]."'"));
			if($template[0] == "1")
			{
				$header .=  '
						<table style="width: 100%;">
							<tbody>
								<tr>
							      	<td width="130px;padding:0px !important;"><img src="../../Mall_Attachments/mall_image/'.$row[4].' " style="height: 130px; width: 120px;"></td>
							      	<td>
							      		<span><h2>'. $row[0] .'</h2></span>
							      		<span>'. $row[1] .'</span>
							      		<span>'. $row[2] .'</span>
							      		<span>'. $row[3] .'</span>
							      	</td>
						      	</tr>
					      	</tbody>
				      	</table>';
			}
			else
			{
				$header .= '
						<table style="width: 100%;">
							<tbody>
								<tr>
							  		<td colspan="3" align="center"><img src="../../Mall_Attachments/mall_image/'. $row[4].' " style="height: 130px; width: 120px;"><br>
						  			<span style="font-size: 1.5em;font-weight: bold;">'. $row[0] .'</span><br><br>
							  		<span>'. $row[1] .'</span><br>
							  		<span>'. $row[2] .'</span><br>
							  		<span>'. $row[3] .'</span>
							  		</td>
						  		</tr>
						  	</tbody>
					    </table>';
			}

			$tableheader .= '<table style="width: 100%;">
							<thead>
								<tr>
			                    	<td style="background-color: #666;color: white;">Trade Name</td>
			                    	<td style="background-color: #666;color: white;">Description</td>
			                    	<td style="background-color: #666;color: white;">Date / Time</td>
			                    	<td style="background-color: #666;color: white;">Quantity</td>
			                    	<td style="background-color: #666;color: white;">User Name</td>
			                    	<td style="background-color: #666;color: white;">Amount</td>
			                    	<td style="background-color: #666;color: white;">Vat</td>
			                    	<td style="background-color: #666;color: white;">Total</td>
			                    </tr>
			                </thead>
	                    	<tbody>';

			// START OF FILTER BY USER
			if($_GET['user'] == ""){
				$users = $_GET['userlist'];
			}else{
				$users = $_GET['user'];
			}
			$arr = explode("|", $users);
			$userlist = "";
			$mn = 0;
			if(COUNT($arr) > 1){
				for ($m=0; $m <= count($arr)-2; $m++) { 
					$userlist .= "'" . $arr[$m] . "'" . ",";
					$mn++;
				}
			}else{
				$userlist = "'". $arr[0] ."''";
				$mn++;
			}

			if($mn > 0 && $userlist != "'''"){
				$userfilter = " AND (a.userid IN(". substr(trim($userlist), 0, -1) .")) ";
			}else{
				$userfilter = "";
			}
			// END OF FILTER BY USER

			// START OF FILTER BY PAYMENT TYPE
			if($_GET['paymenttype'] == ""){
				$paymenttypes = $_GET['paymenttypelist'];
			}else{
				$paymenttypes = $_GET['paymenttype'];
			}
			$arr2 = explode("|", $paymenttypes);
			$paymenttypelist = "";
			$jjdb = 0;
			if(COUNT($arr2) > 1){
				for ($j=0; $j <= count($arr2)-2; $j++) { 
					$paymenttypelist .= "'" . $arr2[$j] . "'" . ",";
					$jjdb++;
				}
			}else{
				$paymenttypelist = "'". $arr2[0] ."''";
				$jjdb++;
			}

			if($jjdb > 0 && $paymenttypelist != "'''"){
				$paymenttypefilter = " AND (a.paymenttype IN(". substr(trim($paymenttypelist), 0, -1) .")) ";
			}else{
				$paymenttypefilter = "";
			}
			// END OF FILTER BY PAYMENT TYPE

			// START OF DATE TIME FILTER
			if($_GET['timeFrom'] == ''){
				$timefrom = "00:00:00";
			}else{
				$timefrom = date('H:i:s', strtotime($_GET['timeFrom']));
			}

			if($_GET['timeTo'] == ''){
				$timeto = "23:59:59";
			}else{
				$timeto = date('H:i:s', strtotime($_GET['timeTo']));
			}

			$datefilter = "WHERE (a.xdatetime BETWEEN '". date('Y-m-d H:i:s', strtotime($_GET['dateFrom']." ".$timefrom)) ."' AND '". date('Y-m-d H:i:s', strtotime($_GET['dateTo']." ".$timeto)) ."') AND b.mallid = '". $_GET['mallid'] ."'";
			// END OF DATE TIME FILTER

			$filter = $datefilter.$userfilter.$paymenttypefilter;
			$sql = " SELECT b.tradename, a.description, a.xdatetime, a.qty, CONCAT(c.firstname, ' ', LEFT(c.middlename, 1), ' ', c.lastname), a.amount, a.vatamount, (a.amount + a.vatamount) FROM tbltransaction AS A INNER JOIN tbltrans_tenants AS b ON a.tenantid = b.tenantid INNER JOIN tbluser AS C ON a.userid = c.userid ".$filter." ";
			$res = mysql_query($sql, $connection);
			while($row = mysql_fetch_array($res)){
				$table .= '	<tr>
								<td>'. $row[0] .'</td>
								<td>'. $row[1] .'</td>
								<td>'. $row[2] .'</td>
								<td>'. $row[3] .'</td>
								<td>'. $row[4] .'</td>
								<td style="text-align: center;">'. number_format($row[5], "2", ".", ",") .'</td>
								<td style="text-align: center;">'. number_format($row[6], "2", ".", ",") .'</td>
								<td style="text-align: center;">'. number_format($row[7], "2", ".", ",") .'</td>
							</tr>';
			}

	        $tablefooter  .= '</tbody></table>';
// Set some content to print
$html = <<<EOD
$header
$tableheader
$table
$tablefooter
EOD;

// Print text using writeHTML()
$pdf->writeHTML($html, true, false, true, false, '');

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output($filename, 'I');

//============================================================+
// END OF FILE
//============================================================+
