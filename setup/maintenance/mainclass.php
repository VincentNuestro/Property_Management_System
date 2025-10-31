<?php
    session_start();
    include("../../connect.php");
	switch($_POST["form"]){
		case 'loadlist':
			$sql = mysql_query("SELECT mainid, xdesc FROM ref_maintenancemain", $connection);
			while($row = mysql_fetch_array($sql)){
                $catname = mysql_fetch_array(mysql_query("SELECT category FROM tblmaintenance_category WHERE category_id = '". $row[1] ."'", $connection));
				echo "<div class='widget-box widget-color-blue2' id='widget-box-9'>
                        <div class='widget-header'>
                            <h5 class='widget-title'>".$catname["category"]."</h5>

                            <div class='widget-toolbar'>
                                <a href='#' class='hide isadmin select-editmaintenancechecklist' onclick='editlist(\"".$row["mainid"]."\")'>
                                    <i class='1 ace-icon fa fa-pencil bigger-125 green'></i>
                                </a>
                                <a href='#' class='hide isadmin select-deletemaintenancechecklist' onclick='deletethisbox(\"".$row["mainid"]."\")'>
                                    <i class='1 ace-icon fa fa-times bigger-125 red'></i>
                                </a>
                                <a href='#' data-action='collapse'>
                                    <i class='1 ace-icon fa fa-chevron-up bigger-125'></i>
                                </a>
                            </div>

                            <div class='widget-toolbar no-border'>
                                <ul class='dropdown-menu dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close'>
                                    <li>
                                        <a href='#'>Action</a>
                                    </li>

                                    <li>
                                        <a href='#'>Another action</a>
                                    </li>

                                    <li>
                                        <a href='#'>Something else here</a>
                                    </li>

                                    <li class='divider'></li>

                                    <li>
                                        <a href='#'>Separated link</a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class='widget-body'>
                            <div class='widget-main' style='padding:0px;'>
                                <div class='form-group row' style='margin-bottom:0px;'>
                                    <div class='col-md-12'>
                                        <table id='simple-table' class='table  table-bordered table-hover' style='margin-bottom:0px;'>
                                            <thead>
                                                <tr>
                                                    <th style='background-color: #f2f2f2 !important;color:#707070;width:30%;'>Task</th>
                                                    <th style='background-color: #f2f2f2 !important;color:#707070;width:50%;'>Description</th>
                                                    <th style='background-color: #f2f2f2 !important;color:#707070;width:10%;'>Period</th>
                                                    <th style='background-color: #f2f2f2 !important;color:#707070;width:10%;'>Options</th>
                                                </tr>
                                            </thead>
                                            <tbody id='tblperiodreflist'>";
                                            	$sql2 = mysql_query("SELECT xtask, xdesc, xperiod FROM ref_maintenancemain_sub WHERE mainid = '".$row["mainid"]."'", $connection);
                                            	while($row2 = mysql_fetch_array($sql2)){
	                                            	echo"
	                                                <tr>
	                                                    <td style='width:35%;'>".$row2[0]."</td>
	                                                    <td style='width:50%;'>".$row2[1]."</td>
	                                                    <td style='width:10%;'>".$row2[2]."</td>
	                                                    <td style='width:5%;text-align: center;'><button class='btn btn-xs btn-danger hide isadmin select-deletemaintenancechecklist' title='Delete' onclick='deletethisline(\"".$row2[0]."\")'><img src='assets/images/remove.png' style='width:100%; height: auto;'></button></div></td>
	                                                </tr>";                                            		
                                            	}
                                            echo"</tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>";
			}
		break;

        case 'savesetup':
        if($_POST["id"] == ""){
            $arr = explode("#", $_POST["all"]);
            $mainid = createidno("ML", "ref_maintenancemain", "mainid");
            $insert = mysql_query("INSERT INTO ref_maintenancemain SET mainid = '".$mainid."', xdesc = '".$_POST["catname"]."', NOTIF_DAYS = '". $_POST['days'] ."'", $connection);
            $e = 0;
            for($i=0; $i<=count($arr)-2; $i++){
                $e++;
                $arr2 = explode("|", $arr[$i]);
                if($arr2[2] != 'undefined'){
                    $insert_children = mysql_query("INSERT INTO ref_maintenancemain_sub SET mainid = '".$mainid."', xtask = '".$arr2[0]."', xdesc = '".$arr2[1]."', xperiod = '".$arr2[2]."', xday = '".$arr2[3]."', xday_num = '".$arr2[4]."'", $connection);

                    $getid = mysql_query("SELECT id FROM ref_maintenancemain_sub WHERE mainid = '".$mainid."' AND xtask = '".$arr2[0]."', xdesc = '".$arr2[1]."' AND xperiod = '".$arr2[2]."' AND xday = '".$arr2[3]."' AND xday_num = '".$arr2[4]."'", $connection);

                    $dateexp = explode("-", $arr2[5]);
                    for($x=0; $x <= 4; $x++){
                        if($dateexp[$x] != ""){
                            $sql_insert_daily = mysql_fetch_array(mysql_query("INSERT INTO ref_maintenancemain_log SET LIid = '".$getid[0]."', mainid = '".$mainid."', xtask =  '".$arr2[0]."', xdesc =  '".$arr2[1]."', xdate = '".date("Y-m-d", strtotime($dateexp[$x]))."'", $connection));
                        }
                        
                    }
                }
            }

            if($e>0){
                echo "1";
            }            
        }else{
            $arr = explode("#", $_POST["all"]);
            $sqlupdate = " UPDATE ref_maintenancemain SET xdesc = '". $_POST["catname"] ."', NOTIF_DAYS = '". $_POST['days'] ."' WHERE mainid = '". $_POST['id'] ."' ";
            $resupdate = mysql_query($sqlupdate, $connection);
            if($resupdate = true){
                $sqldelete = " DELETE FROM ref_maintenancemain_sub WHERE mainid = '". $_POST['id'] ."' ";
                $resdelete = mysql_query($sqldelete, $connection);
                if($resdelete == true){
                    $f = 0;
                    for($i=0; $i<=count($arr)-2; $i++){
                        $f++;
                        $arr2 = explode("|", $arr[$i]);
                        $insert_children = mysql_query("INSERT INTO ref_maintenancemain_sub SET mainid = '".$_POST['id']."', xtask = '".$arr2[0]."', xdesc = '".$arr2[1]."', xperiod = '".$arr2[2]."', xday = '".$arr2[3]."', xday_num = '".$arr2[4]."'", $connection);

                        $getid = mysql_query("SELECT id FROM ref_maintenancemain_sub WHERE mainid = '".$_POST['id']."' AND xtask = '".$arr2[0]."', xdesc = '".$arr2[1]."' AND xperiod = '".$arr2[2]."' AND xday = '".$arr2[3]."' AND xday_num = '".$arr2[4]."'", $connection);

                        $dateexp = explode("-", $arr2[5]);
                        for($x=0; $x <= 4; $x++){
                            if($dateexp[$x] != ""){
                                $sql_insert_daily = mysql_fetch_array(mysql_query("INSERT INTO ref_maintenancemain_log SET LIid = '".$getid[0]."', mainid = '".$_POST['id']."', xtask =  '".$arr2[0]."', xdesc =  '".$arr2[1]."', xdate = '".date("Y-m-d", strtotime($dateexp[$x]))."'", $connection));
                            }
                            
                        }
                    }
                    if($f>0){
                        echo "1";
                    }  
                }
            }
        }
        break;

        case 'editlist':
            $data = "";
            $cat = mysql_fetch_array(mysql_query("SELECT xdesc FROM ref_maintenancemain WHERE mainid = '".$_POST["id"]."'"));
            $data .= $cat[0] . "#";
            $det = mysql_query("SELECT xtask, xdesc, xperiod, xday, xday_num FROM ref_maintenancemain_sub WHERE mainid = '".$_POST["id"]."'", $connection);
            while($details = mysql_fetch_array($det)){   
                $day = "";
                $day .='<option value=""></option>';
                if($details["xday"] == "Monday"){  
                    $day .='<option value="Monday" selected>Monday</option>';
                }else{ 
                    $day .='<option value="Monday">Monday</option>'; 
                }

                if($details["xday"] == "Tuesday"){ 
                    $day .='<option value="Tuesday" selected>Tuesday</option>'; 
                }else{ 
                    $day .='<option value="Tuesday">Tuesday</option>'; 
                }

                if($details["xday"] == "Wednesday"){ 
                    $day .='<option value="Wednesday" selected>Wednesday</option>'; 
                }else{ 
                    $day .='<option value="Wednesday">Wednesday</option>'; 
                }

                if($details["xday"] == "Thursday"){ 
                    $day .='<option value="Thursday" selected>Thursday</option>'; 
                }else{ 
                    $day .='<option value="Thursday">Thursday</option>'; 
                }

                if($details["xday"] == "Friday"){ 
                    $day .='<option value="Friday" selected>Friday</option>'; 
                }else{ 
                    $day .='<option value="Friday">Friday</option>'; 
                }

                if($details["xday"] == "Saturday"){ 
                    $day .='<option value="Saturday" selected>Saturday</option>'; 
                }else{ 
                    $day .='<option value="Saturday">Saturday</option>'; 
                }

                if($details["xday"] == "Sunday"){ 
                    $day .='<option value="Sunday" selected>Sunday</option>'; 
                }else{ 
                    $day .='<option value="Sunday">Sunday</option>'; 
                }


                $daynum = "";
                $daynum .= "<option value='' selected>Day</option>";
                for($i=1; $i<=31; $i++){
                    if(floatval($details["xday_num"]) == $i){
                        $daynum .= "<option value='".$i."' selected>".$i."</option>";
                    }else{
                        $daynum .= "<option value='".$i."'>".$i."</option>";
                    }
                }

                $datee = "";
                $querry = "SELECT xdate FROM ref_maintenancemain_log WHERE mainid = '".$_POST["id"]."'";
                $query_date = mysql_query($querry, $connection);
                while($get_date = mysql_fetch_array($query_date)){
                    $datee .= $get_date["xdate"] . "/";
                }
                $data .= $details["xtask"]."|".$details["xdesc"]."|".$details["xperiod"]."|".$day."|".$daynum."|".$datee."#";
            }
            echo $data;
        break;

        case 'deletethisline':
            $sql = "DELETE FROM ref_maintenancemain_sub WHERE xtask = '". $_POST['xtask'] ."' ";
            $res = mysql_query($sql, $connection);
            if($res == true){
                echo "Task deleted.";
            }
        break;

        case 'deletethisbox':
            $select = mysql_fetch_array(mysql_query("SElECT xdesc FROM ref_maintenancemain WHERE mainid = '". $_POST['mainid'] ."'",$connection));
            $catname = mysql_fetch_array(mysql_query("SELECT category FROM tblmaintenance_category WHERE category_id = '". $select[0] ."'", $connection));
            echo $catname[0];
        break;

        case 'deletethisbox2':
            $select = mysql_fetch_array(mysql_query("SElECT xdesc FROM ref_maintenancemain WHERE mainid = '". $_POST['mainid'] ."'",$connection));
            $catname = mysql_fetch_array(mysql_query("SELECT category FROM tblmaintenance_category WHERE category_id = '". $select[0] ."'", $connection));
            $sql = "DELETE FROM ref_maintenancemain WHERE mainid = '". $_POST['mainid'] ."' ";
            $res = mysql_query($sql, $connection);
            if($res == true){
                $sql2 = "DELETE FROM ref_maintenancemain_sub WHERE mainid = '". $_POST['mainid'] ."'";
                $res2 = mysql_query($sql2, $connection);
                if($res2 == true){
                    echo $catname[0]." deleted.";
                }
            }
        break;

        case 'showmaincat':
            echo "<option value=''>-- Select Category --</option>";
            $sql = "SELECT category_id, category FROM tblmaintenance_category";
            $res = mysql_query($sql, $connection);
            while($row = mysql_fetch_array($res)){
                echo "<option value='". $row[0] ."'>". $row[1] ."</option>";
            }
        break;

        case 'checkmaintype':
            $sql = mysql_fetch_array(mysql_query("SELECT Maintenance_Type FROM tblmaintenance_category WHERE category_id = '". $_POST['catid'] ."'", $connection));
            echo $sql[0];
        break;
	}
?>