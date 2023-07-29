<?php
    session_start();
    include ('../../connect.php');
    switch ($_POST['form']) {
            case 'tblstorename':
                $sql = "SELECT TenantID, mallID, inqID, tradeID, tradename, CompanyID, companyname, unitID, unitname, datefrom, dateto, Status, noofmonths, noofdays, monthly_dues, tenanttype, owner_firstname, owner_midname, owner_lastname FROM tbltrans_tenants WHERE tradename LIKE '%".$_POST['srchhistory']."%' ". getMallAccess("mallID", "AND") ." ";
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

                    echo "<tr onclick='thiscompany(\"".$row2[0]."\", \"".$row[5]."\", \"".$row[6]."\", \"".$row[4]."\", \"".$row[0]."\", \"".$row[16]."\", \"".$row[17]."\", \"".$row[18]."\", \"".$img."\")'>
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

    }
?>
