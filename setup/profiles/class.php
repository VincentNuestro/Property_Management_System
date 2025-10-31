<?php
    session_start();
    include("../../connect.php");
    switch($_POST["form"]){    
    case 'loadcompanylo':
            $sql = "SELECT CompanyID, Company, industry, businessAddress, owner_firstname, owner_middlename, owner_lastname, permanent_address, current_address, billing_address, filename FROM tbltrans_company;";
            $result = mysql_query($sql, $connection);
            while($row = mysql_fetch_array($result)){
                if($row["filename"] == ""){
                    $image = "assets/images/noimage5.png";
                }else{
                    if(!file_exists("../../server/company/". $row["CompanyID"] ."/profile/". $row["filename"])){ 
                        $image = "assets/images/noimage5.png";
                    }else{
                        $image = "server/company/". $row["CompanyID"] ."/profile/". $row["filename"];
                    }
                }
                echo "<li class='dd-item dd2-item' id='module_1' style='cursor: pointer;'>
                        <div class='dd-handle dd2-handle' style='height:100%;' onclick='loadinformationcomp(\"". $row["CompanyID"] ."\")'>
                            <img src='". $image ."' style='height:100%;width:85%;margin-bottom:3px !important;margin-top:3px !important;'>
                        </div>
                        <div class='dd2-content'><label style='width:80%;' onclick='loadinformationcomp(\"". $row["CompanyID"] ."\")'>". $row["Company"] ."</label>
                            <a href='#' title='Edit Company Profile' class='btnedit hide isadmin select-editcompany' style='float:right;' onclick='updatecompany(\"". $row["CompanyID"] ."\");'><i class='ace-icon fa fa-pencil fa-2x'></i></a>
                        </div>
                    </li>";
            }
        break;

        case 'loadtardelist':
            $sql = "SELECT tradename, companyID, tradeID, filename, merchant_code, automerchant_code FROM tbltrans_tradename WHERE companyID = '". $_POST["id"] ."';";
            $result = mysql_query($sql, $connection);
            while($row = mysql_fetch_array($result)){
                if($row["filename"] == ""){
                    $image = "assets/images/noimage5.png";
                }else{
                    if(!file_exists("../../server/company/".$row["companyID"]."/trades/".$row["tradeID"]."/".$row["filename"])){ 
                        $image = "assets/images/noimage5.png";
                    }else{
                        $image = "server/company/".$row["companyID"]."/trades/".$row["tradeID"]."/".$row["filename"];
                    }
                }

                if(SysLeaseSetup('automerchantcode') == "1"){
                    if($row["merchant_code"] == "" && $row['automerchant_code'] == ""){
                        $MerchantCode = "";
                    }else{
                        $MerchantCode = $row["merchant_code"] . "-" . $row['automerchant_code'];
                    }
                }else{
                    $MerchantCode = $row["merchant_code"];
                }

                $groupaccess = mysql_fetch_array(mysql_query("SELECT isadmin, groupaccess FROM tbluser WHERE userid = '". $_SESSION['MMS-UserID'] ."';", $connection));

                if($groupaccess[0] == 1 || $_SESSION['MMS-UserID'] == 'GatessoftCorp' || $_SESSION['MMS-UserID'] == 'Superuser'){
                    $button = "onclick='editstore(\"".$row["tradeID"]."\", \"".$image."\", \"".$row["tradename"]."\", \"".$row["companyID"]."\", \"". $MerchantCode ."\")'";
                }else{
                    $checkaccess = mysql_fetch_array(mysql_query("SELECT COUNT(functionid) FROM tblref_usergroupaccess WHERE groupid = '". $groupaccess[1] ."' AND functionid = 'editcompany' AND module = 'systemsetup';", $connection));
                    if($checkaccess[0] > 0){
                        $button = "onclick='editstore(\"".$row["tradeID"]."\", \"".$image."\", \"".$row["tradename"]."\", \"".$row["companyID"]."\", \"". $row['merchant_code'] ."\")'";
                    }else{
                        $button = "";
                    }
                }
                
                echo "  <tr ".$button.">
                            <td width='7%'><img src='". $image ."' style='width:50px;height:50px;'></th>
                            <td>". $row["tradename"] ."</th>
                            <td>". $MerchantCode ."</th>
                        </tr>";
            }
        break;

        case 'loadinformationcomp':
            $sql = "SELECT CompanyID, Company, industry, businessAddress, owner_firstname, owner_middlename, owner_lastname, permanent_address, current_address, billing_address, filename FROM tbltrans_company WHERE CompanyID = '".$_POST["id"]."';";
            $result = mysql_query($sql, $connection);
            $row = mysql_fetch_array($result);

            if($row["filename"] == ""){
                $image = "assets/images/noimage5.png";
            }else{
                if(!file_exists("../../server/company/".$row["CompanyID"]."/profile/".$row["filename"])){ 
                    $image = "assets/images/noimage5.png";
                }else{
                    $image = "server/company/".$row["CompanyID"]."/profile/".$row["filename"];
                }
            }

            $res2 = mysql_query("SELECT firstname, middlename, lastname FROM tbltrans_companysig WHERE CompanyID = '". $_POST['id'] ."';", $connection);
            while($row2 = mysql_fetch_array($res2)){
                if($row2['middlename'] == ""){
                    $Name = $row2['firstname'] . " " . $row2['lastname'];
                }else{
                    $Name = $row2['firstname'] . " " . $row2['middlename'][0] . ". ".$row2['lastname'];
                }
                $Signatories .= $Name."</br>";
            }

            if($row['owner_middlename'] == ""){
                $Name2 = $row['owner_firstname'] . " " . $row['owner_lastname'];
            }else{
                $Name2 = $row['owner_firstname'] . " " . $row['owner_middlename'][0] . ". ".$row['owner_lastname'];
            }

            echo $row["Company"] . "|" . $row["industry"] . "|" . $row["businessAddress"] . "|" . $image . "|" . $Signatories . "|" . $Name2;
        break;
    }
?>