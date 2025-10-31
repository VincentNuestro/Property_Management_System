<?php
    session_start();
	include "../../connect.php";
	switch($_POST['form']){
        case 'showappreport':
            $page = $_POST['page'];
            $limit = ($page-1) * 20;
            $sql = "SELECT Application_ID, applicationDate, Company_Name, Trade_Name, Status, datefrom, dateto, Inquiry_ID FROM tbltrans_inquiry WHERE applicationDate BETWEEN '". date('Y-m-d', strtotime($_POST['dateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['dateTo'])) ."' AND Status = 'Pending' ". getMallAccess("Mall_ID", "AND") ." ORDER BY applicationDate DESC LIMIT ".$limit.",20;";
            $res = mysql_query($sql, $connection);
            while($row = mysql_fetch_array($res)){
                if($row['datefrom'] == "" || $row['datefrom'] == "1970-01-01"){
                    $DateFrom = "";
                }else{
                    $DateFrom = date('m/d/Y', strtotime($row['datefrom']));
                }

                if($row['dateto'] == "" || $row['dateto'] == "1970-01-01"){
                    $DateTo = "";
                }else{
                    $DateTo = date('m/d/Y', strtotime($row['dateto']));
                }
                echo "<tr>
                        <td width='10%'>". $row['Application_ID'] ."</td>
                        <td width='10%'>". date("m/d/Y", strtotime($row['applicationDate'])) ."</td>
                        <td width='20%'>". $row['Company_Name'] ."</td>
                        <td width='20%'>". $row['Trade_Name'] ."</td>
                        <td width='10%'>". $row['Status'] ."</td>
                        <td width='8%'>". $DateFrom ."</td>
                        <td width='8%'>". $DateTo ."</td>
                        <td width='14%'>";
                            $sql1 = "SELECT xremarks FROM tbltrans_remarks WHERE inqID = '". $row['Inquiry_ID'] ."';";
                            $res1 = mysql_query($sql1, $connection);
                            while($row1 = mysql_fetch_array($res1)){
                                if($row1['xremarks'] != ''){
                                    echo "<span class='fa fa-circle'></span>"." ". $row1[0] ."<br/>";
                                }
                            }
                echo    "</td>
                    </tr>";
            }
        break;

        case 'loadentriesappr_report':
            if($_POST["page"] == ""){
                $page = 1;
            }else{
                $page = $_POST["page"];
            }
            $limit = ($page-1) * 20;
            $sql = "SELECT COUNT(*) FROM tbltrans_inquiry WHERE applicationDate BETWEEN '". date('Y-m-d', strtotime($_POST['dateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['dateTo'])) ."' AND Status = 'Pending' ". getMallAccess("Mall_ID", "AND") .";";
            $result = mysql_query($sql, $connection);
            $row = mysql_fetch_array($result);
            $rowsperpage = 20;
            $totalpages = ceil($row[0] / $rowsperpage);
            $upto = $limit + 20;
            $from = $limit + 1;
            if($page == $totalpages && $row[0] != 0){
                echo "Showing " . $from . " to " . $row[0] . " of " . $row[0] . " entries";
            }else{
                if($row[0] == 0){
                    echo "";
                }else if($row[0] <= 19 && $row[0] != 0){
                    echo "Showing 1 to " . $row[0] . " of " . $row[0] . " entries";
                }else if($row[0] >= 20 && $row[0] != 0){
                    echo "Showing " . $from . " to " . $upto . " of " . $row[0] . " entries";
                }
            }
        break;

        case "loadpageapp_report":
            $page = $_POST["page"];
            $sqlb = "SELECT COUNT(*) FROM tbltrans_inquiry WHERE applicationDate BETWEEN '". date('Y-m-d', strtotime($_POST['dateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['dateTo'])) ."' AND Status = 'Pending' ". getMallAccess("Mall_ID", "AND") .";";
            $aa = mysql_query($sqlb, $connection);
            $nums = mysql_fetch_row($aa);
            $num = $nums[0];
            $rowsperpage = 20;
            $range = 3;
            $totalpages = ceil($num / $rowsperpage);
            $prevpage;
            $nextpage;
            if($page > 1 ){
                echo "<li style='width:50px !important;' onclick='pagination54(1)'><< First</li>";
                $prevpage = $page - 1;
                echo "<li style='width:70px !important;' onclick='pagination54(". $prevpage .")'>< Previous</li>";
            }
            for($x = ($page - $range); $x < (($page + $range) + 1); $x++){
                if (($x > 0) && ($x <= $totalpages)){
                    if ($x == $page){
                        echo "<li id='pgapp_report" . $x . "' class='pgnumpapp_report active' onclick='pagination54(" . $x . ",". $x .")'>" . $x . "</li>";
                    }else{
                        echo "<li id='pgapp_report" . $x . "' class='pgnumpapp_report' onclick='pagination54(" . $x . ",". $x .")'>" . $x . "</li>";
                    }
                }
            }
            if($page < ($totalpages - $range)){
                echo "<li>...</li>";
            }
            if ($page != $totalpages && $num != 0){
                $nextpage = $page + 1;
                echo "<li style='width:50px !important;' onclick='pagination54(". $nextpage .", ". $nextpage .")'>Next ></li>";
                echo "<li style='width:50px !important;' onclick='pagination54(". $totalpages .", ". $totalpages .")'>Last >></li>";
            }
        break;

        case 'print_app_report':
            $sql = "SELECT Application_ID, applicationDate, Company_Name, Trade_Name, Status, datefrom, dateto, Inquiry_ID FROM tbltrans_inquiry WHERE applicationDate BETWEEN '". date('Y-m-d', strtotime($_POST['dateFrom'])) ."' AND '". date('Y-m-d', strtotime($_POST['dateTo'])) ."' AND mall_id = '". $_POST['mallid'] ."' AND Status = 'Pending' ORDER BY applicationDate;";
            $res = mysql_query($sql, $connection);
            while($row = mysql_fetch_array($res)){

                echo "<tr>
                        <td style='width: 15%;' valign='top'>". date("F d, Y", strtotime($row[1])) ."</td>
                        <td style='width: 25%;' valign='top'>". $row[2] ."</td>
                        <td style='width: 20%;' valign='top'>". $row[3] ."</td>
                        <td style='width: 10%;' valign='top'>". $row[4] ."</td>
                        <td style='width: 13%;' valign='top'>". $row[5] ."</td>
                        <td style='width: 13%;' valign='top'>". $row[6] ."</td>
                        <td style='width: 14%;' valign='top'>";
                            $sql1 = "SELECT xremarks FROM tbltrans_remarks WHERE inqID = '". $row['Inquiry_ID'] ."';";
                            $res1 = mysql_query($sql1, $connection);
                            while($row1 = mysql_fetch_array($res1)){
                                if($row1['xremarks'] != ''){
                                    echo "<span class='fa fa-circle'></span>"." ". $row1[0] ."<br/>";
                                }
                            }
                echo    "</td>
                    </tr>";
              }

            echo "|" . date('F d, Y', strtotime($_POST['dateFrom'])) . "|" . date('F d, Y', strtotime($_POST['dateTo']));
        break;
    }
?>		

