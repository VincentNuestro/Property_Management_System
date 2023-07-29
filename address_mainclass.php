<?php
	session_start();
	include("connect.php");
	switch($_POST["form"]){
		case "searchregion":
			$queryregion = mysql_query("SELECT a.regDesc FROM smms_refregion AS a JOIN smms_refprovince AS b ON a.regCode = b.regCode WHERE b.provDesc = '" .$_POST["val"] . "' ")or die(mysql_error());
            while($row = mysql_fetch_array($queryregion)){
            	echo $row[0];
          	}
		break;
		case "searchprovince":
			$queryprovince = mysql_query("SELECT a.provDesc FROM smms_refprovince AS a JOIN smms_refcitymun AS b ON a.provCode = b.provCode WHERE b.citymunDesc = '" .$_POST["val"] . "' ")or die(mysql_error());
          	while($row = mysql_fetch_array($queryprovince)){
            	echo $row[0];
          	}
		break;
		
		case "searchcity":
			$querycity = mysql_query("SELECT a.brgyDesc FROM smms_refbrgy AS a JOIN smms_refcitymun AS b ON a.citymunCode = b.citymunCode WHERE b.citymunDesc = '" .$_POST["val"] . "' ")or die(mysql_error());
            while($row = mysql_fetch_array($querycity)){
                $city = "<option ";
                $city .= "value='".$row['brgyDesc']."'/>"; 
                echo $city;
            }
		break;

		case "searchbarangay":
			$querybrgy = mysql_query("Select brgyDesc, citymunCode from smms_refbrgy")or die(mysql_error());
          	while($row = mysql_fetch_array($querybrgy)){
            	$brgy = "<option ";
           	 	$brgy .= "value='".$row['brgyDesc']."'/>"; 
            	echo $brgy;
          	}
		break;
	}
?>
