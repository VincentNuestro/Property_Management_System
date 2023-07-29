<?php
    session_start();
    include ('../../connect.php');
    switch ($_POST['form']) {
            case 'tblstorename':
                if($_SESSION['MMS-Designation']!='GatessoftCorp'){
                    $mallfilter = " AND mallID = '".$_SESSION['MMS-Designation']."' ";
                }
                $sql = "SELECT TenantID, mallID, inqID, tradeID, tradename, CompanyID, companyname, unitID, unitname, datefrom, dateto, Status, noofmonths, noofdays, monthly_dues, tenanttype, owner_firstname, owner_midname, owner_lastname FROM tbltrans_tenants WHERE tradename LIKE '%".$_POST['srchhistory']."%'   ".$mallfilter;
                $result = mysql_query($sql, $connection);
                while ($row = mysql_fetch_array($result)) {

                    $sql2 = "SELECT mallname FROM tblref_mall WHERE mallid = '".$row[1]."'";
                    $result2 = mysql_query($sql2, $connection);
                    $row2 = mysql_fetch_array($result2);

                    $sql3 = "SELECT filename FROM tbltrans_tradename WHERE tradeID = '".$row[3]."'";
                    $result3 = mysql_query($sql3, $connection);
                    $row3 = mysql_fetch_array($result3);

                    if($row3["filename"] == ""){
                        $img = "assets/images/noimage5.png";
                    }else{
                        if(!file_exists("../../../Mall_Attachments/company/".$row[5]."/trades/".$row[3]."/".$row3[0])){ 
                            $img = "assets/images/noimage5.png";
                        }else{
                            $img = "../Mall_Attachments/company/".$row[5]."/trades/".$row[3]."/".$row3[0];
                        }
                    }

                    echo "<tr onclick='thiscompany(\"".$row2[0]."\", \"".$row[5]."\", \"".$row[6]."\", \"".$row[4]."\", \"".$row[0]."\", \"".$row[16]."\", \"".$row[17]."\", \"".$row[18]."\", \"".$img."\",\"".$row[1]."\")'>
                            <td style='font-weight: 700;'><img style='margin-right: 5px;' class='img-circle' src='". $img ."' width='20px' height='20px' />  ". $row[4] ."</td>
                        </tr>";
                }
            break;

            case 'tblstoreunit':
            $sql = "SELECT tradeID, tradename, unitID, unitname, datefrom, dateto, noofmonths, noofdays, monthly_dues, Status, ustatus FROM tbltrans_tenants WHERE TenantID = '".$_POST['tid']."' ";
            $result = mysql_query($sql, $connection);
            while ($row = mysql_fetch_array($result)) {

                $sql2 ="SELECT floorid FROM tblref_unit WHERE unitid ='".$row[2]."'";
                $result2 = mysql_query($sql2, $connection);
                $row2 = mysql_fetch_array($result2);

                $sql3 ="SELECT * FROM tblref_floorsetup WHERE floorid ='".$row2[0]."'";
                $result3 = mysql_query($sql3, $connection);
                $row3 = mysql_fetch_array($result3);

                if($row[9] == "Active"){
                    $stat = "<span class='fa fa-flag' style='font-weight: 700; color: #DFE21A;'></span>";
                }else if($row[9] == "Inactive"){
                    $stat = "<span class='fa fa-flag' style='font-weight: 700; color: DarkGray;'></span>";
                }else if($row[9] == "ForRenewal"){
                    $stat = "<span class='fa fa-flag' style='font-weight: 700; color: #428BCA;'></span>";
                }else if($row[9] == "ForEviction"){
                    $stat = "<span class='fa fa-flag' style='font-weight: 700; color: red;'></span>";
                }
                else if($row[9] == "evicted"){
                    $stat = "<span class='fa fa-flag' style='font-weight: 700; color: grey;'></span>";
                }

                echo "
                    <tr>
                        <td width = '7%'>".ucfirst($row[10])."</td>
                        <td width = '14%'>".$row[1]."</td>
                        <td width = '8%'>".$row[2]."</td>
                        <td width = '10%'>".$row[3]."</td>
                        <td width = '14%'>".$row3[4]."</td>
                        <td width = '15%'>".$row[4]." - ".$row[5]."</td>
                        <td width = '18%'>".$row[6]." month(s) & ".$row[7]." day(s)</td>
                        <td width = '10%' align='right'>". number_format($row[8], '2','.',',')."</td>
                        <td width = '4%' align='center'>".$stat."</td>
                    </tr>
                ";
            }
            break;

            case 'tenantpaymenthistory':
                # code...
            break;

            case 'loadpaymentstype':
                $sql  = "SELECT PaymentTypeID, PaymentTypeDesc FROM tblref_pospaymenttype ORDER BY PaymentTypeDesc ASC ";
                $result = mysql_query($sql,$connection) or die(mysql_error()); 
                echo "<option value=''>-Select type-</option>";
                while ($row = mysql_fetch_array($result)) {
                    echo "<option value='".$row['PaymentTypeID']."'>".$row['PaymentTypeDesc']."</option>";
                }
            break;

            case 'addpayments2':
                $paymentTypeDesc = mysql_fetch_array(mysql_query("SELECT paymentTypeDesc FROM tblref_pospaymenttype WHERE PaymentTypeID = '". $_POST['txttpaymenttype'] ."';", $connection));
                $sql = "INSERT INTO tbl_tenantspayments SET tenantid = '". $_POST['tenantid'] ."',mallid = '". $_POST['mallid'] ."',storename = '".$_POST['storename']."',companyname = '".$_POST['compname']."',paymentdate = '".date('Y-m-d',strtotime($_POST['txttpaymentdate']))."',paymenttype = '".$_POST['txttpaymenttype']."',orno = '".$_POST['txttpaymentorno']."',amount = '".$_POST['txttpaymentamount']."',reference = '".$_POST['txttpaymentreference']."', xuser = '".$_SESSION['MMS-UserID'] ."',xdatetime =  NOW(), mallname = '".$_POST['mallname']."', balance = '". $_POST['txttpaymentamount'] ."', description = '". $paymentTypeDesc['paymentTypeDesc'] ."';";
                $reuslt = mysql_query($sql,$connection);
                echo $result;
            break;

            case 'loadpaymentsdetails':
                $sql = "SELECT amount,paymenttype,paymentdate,reference,xuser,xdatetime,orno,id,xstat FROM tbl_tenantspayments WHERE tenantid = '".$_POST['tenantid']."' AND mallid = '".$_POST['mallid']."' ORDER BY paymentdate DESC ";
                $result = mysql_query($sql,$connection) or die(mysql_error());
                while ($row = mysql_fetch_array($result)) {
                    $types = mysql_fetch_array(mysql_query("SELECT PaymentTypeDesc FROM tblref_pospaymenttype WHERE PaymentTypeID = '".$row['paymenttype']."' ",$connection));
                    $user = mysql_fetch_array(mysql_query("SELECT CONCAT(lastname,', ',firstname) as fullname FROM tbluser WHERE userid = '".$row['xuser']."' ",$connection));
                    if($row['xuser']=='GatessoftCorp'){
                        $user[0] = $row['xuser'];
                    }else{
                        $user[0] = $user[0];
                    }
                    echo "<tr>";
                    echo "<td>".date('m/d/Y',strtotime($row['paymentdate']))."</td>";
                    echo "<td>".$row['orno']."</td>";
                    echo "<td>".$types[0]."</td>";
                    echo "<td style='text-align:right'><b>".number_format($row['amount'],2)."</b></td>";
                    echo "<td>".strtoupper($row['reference'])."</td>";
                    echo "<td>".$user[0]."</td>";
                    echo "<td>".date('m/d/Y h:i A',strtotime($row['xdatetime']))."</td>";
                    if($row['xstat']==0){
                        echo "<td style='text-align:center'><a onclick='deletepayments(\"".$row['id']."\")' style='color:red'><i class='ace-icon glyphicon glyphicon-remove'></i></a></td>";
                    }else{
                        echo "<td style='text-align:center'></td>";
                    }
                    
                    echo "</tr>";
                }
            break;

            case 'deletepayments2':
                $sql = "DELETE FROM  tbl_tenantspayments  WHERE id = '".$_POST['ids']."' ";
                $result = mysql_query($sql,$connection) or die(mysql_error());
                echo $result;
            break;

    }
?>
