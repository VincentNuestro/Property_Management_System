<?php
    session_start();
	include("../connect.php");
	mkdir("../../Mall_Attachments/floorplan/", 0777, true);
	if(isset($_FILES["txtfile"]["name"])){
		$allowedext = array("image/jpg", "image/jpeg", "image/png", "image/bmp");
		$widthstr = "";
		$heightstr = "";
		if(in_array($_FILES["txtfile"]["type"], $allowedext)){
			$PrevFileName = mysql_fetch_array(mysql_query("SELECT ext FROM tblref_floorsetup WHERE floorid = '" . $_REQUEST["txtfloor2"] . "';", $connection));
			$ext = explode(".", $_FILES["txtfile"]["name"]);
			$FileName = $_REQUEST["txtfloor2"] ." ". date('m.d.Y H.i.s') . "." . end($ext);
			$resnewFileName = mysql_query("UPDATE tblref_floorsetup SET photo = '1', ext = '" . $FileName ."', width = '" . $_REQUEST["imgwidth"] . "', height = '" . $_REQUEST["imgheight"] . "' WHERE floorid = '" . $_REQUEST["txtfloor2"] . "';");
			if($resnewFileName == "1"){
				unlink("../../Mall_Attachments/floorplan/" . $PrevFileName['ext']);
				move_uploaded_file($_FILES["txtfile"]["tmp_name"], "../../Mall_Attachments/floorplan/" . $FileName);
				echo "|1";
			}else{ 
				echo "|Error: " . mysql_error() . "!"; 
			}
		}else{ 
			echo "|Error: Invalid File Format!" . $_FILES["txtfile"]["type"]; 
		}
	}
?>