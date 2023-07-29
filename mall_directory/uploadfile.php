<?php
	include("connect.php");
	if(isset($_FILES["txtfile"]["name"]))
	{
		$allowedext = array("image/jpg", "image/jpeg", "image/png", "image/bmp");
		if(in_array($_FILES["txtfile"]["type"], $allowedext))
		{
			$ext = explode(".", $_FILES["txtfile"]["name"]);
			$sql = "";
			if($_POST["txtfloorid"] == "")
			{
				$floorid = createidno("FLOOR", "mall_directory_floors", "floorid");
				$sql = "insert into mall_directory_floors(floorid, floorname, width, height, ext, dateadded) values('" . $floorid . "', '" . $_POST["txtfloorname"] . "', '" . $_POST["imgwidth"] . "', '" . $_POST["imgheight"] . "', '" . end($ext) . "', '" . date("Y-m-d") . "')";
			}
			else
			{
				$floorid = $_POST["floorid"];
				$sql = "update mall_directory_floors set floorname = ,'" . $_POST["txtfloorname"] . "' width = '" . $_POST["imgwidth"] . "', height = '" . $_POST["imgheight"] . "', ext = '" . end($ext) . "', dateadded = '" . date("Y-m-d") . "' where floorid = '" . $floorid . "'";
			}
			$result = mysql_query($sql);
			if($result == "1")
			{
				$_FILES["txtfile"]["name"] = $floorid . "." . end($ext);
				unlink("floors/" . $_FILES["txtfile"]["name"]);
				move_uploaded_file($_FILES["txtfile"]["tmp_name"], "floors/" . $_FILES["txtfile"]["name"]);
				echo "|1";
			}
			else
			{ echo "|Error: " . mysql_error() . "!"; }
		}
		else
		{ echo "|Error: Invalid File Format!" . $_FILES["txtfile"]["type"]; }
	}
?>