<?php
	include("connect.php");
	switch($_POST["form"])
	{
		case "loadfloors":
			$sql = "select floorid, ext, floorname, width, height from mall_directory_floors";
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{
				echo "<div class='col-sm-6 col-xs-6'><img class='img-responsive' style='border: solid 2px #dddddd; margin: 5px; cursor: pointer;' src='floors/" . $row[0] . "." . $row[1] . "' onclick='loadmap(\"" . $row[0] . "\", \"" . $row[2] . "\", \"" . $row[1] . "\", \"" . $row[3] . "\", \"" . $row[4] . "\"); $(\"#floorlist\").modal(\"hide\");'></div>";
			}
		break;
		case "loadfacilities":
			$sql = "select a.otherid, a.othername, COUNT(b.coordid) from mall_directory_others as a LEFT JOIN mall_directory_other_coordinates as b ON a.otherid = b.otherid where b.floorid = '" . $_POST["floorid"] . "' GROUP BY a.otherid";
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{
				echo "<div class='col-sm-6' style='margin-top: 5px;'><button class='btn btn-default' onclick='loadfacilities(\"" . $row[0] . "\");'>" . $row[1] . " (" . $row[2] . ")</button></div>";
			}
		break;
		case "loadfacilities2":
			$sql = "select a.coordid, a.otherid, b.othername, a.lat, a.lon from mall_directory_other_coordinates as a LEFT JOIN mall_directory_others as b ON a.otherid = b.otherid where a.floorid = '" . $_POST["floorid"] . "' and a.otherid = '" . $_POST["otherid"] . "'";
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{ echo "#|" . $row[0] . "|" . $row[1] . "|" . strtolower($row[2]) . "|" . $row[3] . "|" . $row[4]; }
		break;
		case "loadcoordinates":
			$sql = "select a.coordid, b.shopname, a.coord from mall_directory_shops_coordinates as a LEFT JOIN mall_directory_shops as b ON a.shopid = b.shopid where a.floorid = '" . $_POST["floorid"] . "' and a.categoryid = '" . $_POST["categoryid"] . "'";
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{ echo "#|" . $row[0] . "|" . $row[1] . "|" . $row[2]; }
		break;
		case "loadcategories":
			$sql = "select a.categoryid, a.categoryname, a.color, COUNT(b.coordid) from mall_directory_categories as a LEFT JOIN mall_directory_shops_coordinates as b ON a.categoryid = b.categoryid where b.floorid = '" . $_POST["floorid"] . "' GROUP BY a.categoryid";
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{
				echo "<div class='col-sm-6' style='margin-top: 5px;'><button class='btn btn-default' onclick='selectcategory(\"" . $row[0] . "\", \"" . $row[2] . "\");'>" . $row[1] . " (" . $row[3] . ")</button></div>";
			}
		break;
		case "searchresult":
			$sql = "select a.categoryid, b.categoryname from mall_directory_shops_coordinates as a LEFT JOIN mall_directory_categories as b ON a.categoryid = b.categoryid LEFT JOIN mall_directory_shops as c ON a.shopid = c.shopid where c.shopname LIKE '%" . $_POST["key"] . "%' GROUP BY a.categoryid";
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{
				$padding = "";
				$sql2 = "select a.shopid, b.shopname, COUNT(a.shopid) from mall_directory_shops_coordinates as a LEFT JOIN mall_directory_shops as b ON a.shopid = b.shopid where a.categoryid = '" . $row[0] . "' and b.shopname LIKE '%" . $_POST["key"] . "%' GROUP BY a.shopid";
				$result2 = mysql_query($sql2);
				while($row2 = mysql_fetch_array($result2))
				{
					$padding .= "<p id='" . $row2[0] . "'><span class='fa fa-bookmark'></span>&nbsp;&nbsp;" . $row2[1] . " (" . $row2[2] . ")</p>";
				}
				echo "
				<div class='col-sm-6'>
					<h3>" . $row[1] . "</h3>
					<div>
					" . $padding . "
					</div>
				</div>";
			}
		break;
		case "loadshopcoordinates":
			$sql = "select a.coordid, b.shopname, c.color, a.coord from mall_directory_shops_coordinates as a LEFT JOIN mall_directory_shops as b ON a.shopid = b.shopid LEFT JOIN mall_directory_categories as c ON a.categoryid = c.categoryid where a.floorid = '" . $_POST["floorid"] . "' and a.shopid = '" . $_POST["shopid"] . "'";
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{ echo "#|" . $row[0] . "|" . $row[1] . "|" . $row[2] . "|" . $row[3]; }
		break;
		case "loadshoproutes":
			$sql = "select a.routeid, c.shopname, a.coord from mall_directory_route as a LEFT JOIN mall_directory_shops_coordinates as b ON a.shopid = b.coordid LEFT JOIN mall_directory_shops as c ON b.shopid = c.shopid where b.floorid = '" . $_POST["floorid"] . "' and b.shopid = '" . $_POST["shopid"] . "'";
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{ echo "#|" . $row[0] . "|" . $row[1] . "|" . $row[2]; }
		break;
	}
?>