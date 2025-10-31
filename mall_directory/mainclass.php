<?php
	include("connect.php");
	switch($_POST["form"])
	{
		case "loadcategories":
			$sql = "select categoryid, categoryname, color from mall_directory_categories";
			$result = mysql_query($sql);
			$num = mysql_num_rows($result);
			if($num == 0)
			{ echo "<h4 class='nores'>No Categories added.</h4>"; }
			while($row = mysql_fetch_array($result))
			{
				$padding = "";
				$sql2 = "select shopid, shopname from mall_directory_shops where categoryid = '" . $row[0] . "'";
				$result2 = mysql_query($sql2);
				while($row2 = mysql_fetch_array($result2))
				{
					$padding .= "
					<li class='list-group-item' id='" . $row2[0] . "'>
						<p>" . $row2[1] . "</p>
						<span class='fa fa-minus-square delete'></span>
						<span class='fa fa-pencil-square edit'></span>
					</li>
					";
				}
				
				echo "
				<div class='panel panel-default category'>
					<div class='panel-heading heading' role='tab'>
						<a role='button' data-toggle='collapse' data-parent='#category' href='#" . $row[0] . "' aria-expanded='true' aria-controls='" . $row[0] . "'>
							<h4 class='panel-title' style='display: inline-block; margin-right: 20px;'>" . $row[1] . "</h4>
							<button class='btn btn-default btn-sm edit'>Edit</button>
							<button class='btn btn-default btn-sm remove'>Remove</button>
							<div style='background: " . $row[2] . "; margin: 3px; width: 25px; height: 25px; display: inline-block; float: right;'></div>
						</a>
					</div>
					<div id='" . $row[0] . "' class='panel-collapse collapse category-body' role='tabpanel'>
						<div class='panel-body'>
							<h5>List of Shops</h5>
							<ul class='list-group shops'>
								" . $padding . "
								<li class='list-group-item last'>
									<div class='input-group'>
										<input type='text' class='form-control text' placeholder='Add new shop'>
										<span class='input-group-addon add'>
											<span class='fa fa-plus'></span>
										</span>
									</div>
								</li>
							</ul>
						</div>
					</div>
				</div>
				";
			}
		break;
		case "editcategory":
			$sql = "select categoryname, color from mall_directory_categories where categoryid = '" . $_POST["categoryid"] . "'";
			$row = mysql_fetch_array(mysql_query($sql));
			echo "|" . $row[0] . "|" . str_replace("rgba", "rgb", str_replace(", 1)", ")", $row[1]));
		break;
		case "savecategory":
			$sql = "";
			$categoryid = "";
			if($_POST["categoryid"] == "")
			{
				$categoryid = createidno("CAT", "mall_directory_categories", "categoryid");
				$sql = "insert into mall_directory_categories(categoryid, categoryname, color, dateadded) values('" . $categoryid . "', '" . $_POST["categoryname"] . "', '" . $_POST["color"] . "', '" . date("Y-m-d") . "')";
			}
			else
			{
				$categoryid = $_POST["categoryid"];
				$sql = "update mall_directory_categories set categoryname = '" . $_POST["categoryname"] . "', color = '" . $_POST["color"] . "' dateadded = '" . date("Y-m-d") . "' where categoryid = '" . $categoryid . "'";
			}
			$result = mysql_query($sql);
			if($result == "1")
			{ echo "|1|" . $categoryid; }
			else
			{ echo "|Error: " . mysql_error() . "!"; }
		break;
		case "removecategory":
			$sql = "delete from mall_directory_categories where categoryid = '" . $_POST["categoryid"] . "'";
			$result = mysql_query($sql);
			$sql2 = "delete from mall_directory_shops where categoryid = '" . $_POST["categoryid"] . "'";
			$result2 = mysql_query($sql2);
			if($result == "1" && $result2 == "1")
			{ echo "|1"; }
			else
			{ echo "|Error: " . mysql_error() . "!"; }
		break;
		case "saveshop":
			$sql = "";
			$shopid = "";
			if($_POST["shopid"] == "")
			{
				$shopid = createidno("", "mall_directory_shops", "shopid");
				$sql = "insert into mall_directory_shops(shopid, shopname, categoryid, dateadded) values('" . $shopid . "', '" . $_POST["shopname"] . "', '" . $_POST["categoryid"] . "', '" . date("Y-m-d") . "')";
			}
			else
			{
				$shopid = $_POST["shopid"];
				$sql = "update mall_directory_shops set shopname = '" . $_POST["shopname"] . "', dateadded = '" . date("Y-m-d") . "' where shopid = '" . $shopid . "'";
			}
			$result = mysql_query($sql);
			if($result == "1")
			{ echo "|1|" . $shopid; }
			else
			{ echo "|Error: " . mysql_error() . "!"; }
		break;
		case "loadothers":
			$sql = "select otherid, othername from mall_directory_others";
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{
				echo "
				<li class='list-group-item' id='" . $row[0] . "'>
					<p>" . $row[1] . "</p>
					<span class='fa fa-minus-square delete'></span>
					<span class='fa fa-pencil-square edit'></span>
				</li>
				";
			}
			echo "
			<li class='list-group-item last'>
				<div class='input-group'>
					<input type='text' class='form-control text' placeholder='Add new'>
					<span class='input-group-addon' onClick='saveother();'>
						<span class='fa fa-plus'></span>
					</span>
				</div>
			</li>
			";
		break;
		case "saveother":
			$sql = "";
			$otherid = "";
			if($_POST["otherid"] == "")
			{
				$otherid = createidno("", "mall_directory_others", "otherid");
				$sql = "insert into mall_directory_others(otherid, othername, dateadded) values('" . $otherid . "', '" . $_POST["othername"] . "', '" . date("Y-m-d") . "')";
			}
			else
			{
				$otherid = $_POST["otherid"];
				$sql = "update mall_directory_others set othername = '" . $_POST["othername"] . "', dateadded = '" . date("Y-m-d") . "' where otherid = '" . $otherid . "'";
			}
			$result = mysql_query($sql);
			if($result == "1")
			{ echo "|1|" . $otherid; }
			else
			{ echo "|Error: " . mysql_error() . "!"; }
		break;
		case "removeother":
			$sql = "delete from mall_directory_others from otherid = '" . $_POST["otherid"] . "'";
			$result = mysql_query($sql);
			if($result == "1")
			{ echo "|1"; }
			else
			{ echo "|Error: " . mysql_error() . "!"; }
		break;
		case "loadfloors":
			$sql = "select floorid, floorname, ext, width, height from mall_directory_floors";
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{
				echo "
				<div class='row floor'>
					<div class='col-sm-4'>
						<p>" . $row[1] . "</p>
						<button class='btn btn-info' style='margin-bottom: 5px; width: 100px; text-align: left;' onclick='loadmap(\"" . $row[0] . "\", \"" . $row[1] . "\", \"" . $row[2] . "\", \"" . $row[3] . "\", \"" . $row[4] . "\");'><span class='fa fa-gears'></span>&nbsp;&nbsp;Setup</button>
						<button class='btn btn-danger' style='width: 100px; text-align: left;' onclick='removefloor(\"" . $row[0] . "\");'><span class='fa fa-remove'></span>&nbsp;&nbsp;Remove</button>
					</div>
					<div class='col-sm-8'><img class='img-responsive img' src='floors/" . $row[0] . "." . $row[2] . "'></div>
				</div>
				";
			}
		break;
		case "removefloor":
			$sql = "delete from mall_directory_floors where floorid = '" . $_POST["floorid"] . "'";
			$result = mysql_query($sql);
			if($result == "1")
			{ echo "|1"; }
			else
			{ echo "|Error: " . mysql_error() . "!"; }
		break;
		case "loadcategories2":
			$sql = "select categoryid, categoryname from mall_directory_categories";
			$result = mysql_query($sql);
			echo "<option value=''> -- Select Category -- </option>";
			while($row = mysql_fetch_array($result))
			{ echo "<option value='" . $row[0] . "'>" . $row[1] . "</option>"; }
		break;
		case "loadshops2":
			$sql = "select shopid, shopname from mall_directory_shops where categoryid = '" . $_POST["categoryid"] . "'";
			$result = mysql_query($sql);
			echo "<option value=''> -- Select Shop -- </option>";
			while($row = mysql_fetch_array($result))
			{ echo "<option value='" . $row[0] . "'>" . $row[1] . "</option>"; }
		break;
		case "loadfacilities2":
			$sql = "select otherid, othername from mall_directory_others";
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{ echo "<option value='" . $row[0] . "'>" . $row[1] . "</option>"; }
		break;
		case "loadcoordinates":
			$sql = "select a.coordid, a.shopid, b.shopname, b.categoryid, c.color, a.coord from mall_directory_shops_coordinates as a LEFT JOIN mall_directory_shops as b ON a.shopid = b.shopid LEFT JOIN mall_directory_categories as c ON a.categoryid = c.categoryid where a.floorid = '" . $_POST["floorid"] . "'";
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{ echo "#|" . $row[0] . "|" . $row[1] . "|" . $row[2] . "|" . $row[3] . "|" . $row[4] . "|" . $row[5]; }
		break;
		case "savecoordinate":
			$sql = "";
			if($_POST["coordid"] == "")
			{
				$coordid = createidno("S", "mall_directory_shops_coordinates", "coordid");
				$sql = "insert into mall_directory_shops_coordinates(floorid, categoryid, shopid, coordid, coord, dateadded) values('" . $_POST["floorid"] . "', '" . $_POST["categoryid"] . "', '" . $_POST["shopid"] . "', '" . $coordid . "', '" . $_POST["coord"] . "', '" . date("Y-m-d") . "')";
			}
			else
			{
				$coordid = $_POST["coordid"];
				$sql = "update mall_directory_shops_coordinates set coord = '" . $_POST["coord"] . "', dateadded = '" . date("Y-m-d") . "' where coordid = '" . $coordid . "'";
			}
			$result = mysql_query($sql);
			if($result == "1")
			{ echo "|1"; }
			else
			{ echo "|Error: " . mysql_error() . "!"; }
		break;
		case "loadcoordinates2":
			$sql = "select a.coordid, a.otherid, b.othername, a.lat, a.lon from mall_directory_other_coordinates as a LEFT JOIN mall_directory_others as b ON a.otherid = b.otherid where a.floorid = '" . $_POST["floorid"] . "'";
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{ echo "#|" . $row[0] . "|" . $row[1] . "|" . strtolower($row[2]) . "|" . $row[3] . "|" . $row[4]; }
		break;
		case "loadcoordinates3":
			$sql = "select a.routeid, a.shopid, b.shopname, a.coord from mall_directory_route as a LEFT JOIN mall_directory_shops as b ON a.shopid = b.shopid where a.floorid = '" . $_POST["floorid"] . "'";
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{ echo "#|" . $row[0] . "|" . $row[1] . "|" . $row[2] . "|" . $row[3]; }
		break;
		case "savecoordinate2":
			$sql = "";
			if($_POST["coordid"] == "")
			{
				$coordid = createidno("M", "mall_directory_other_coordinates", "coordid");
				$sql = "insert into mall_directory_other_coordinates(floorid, otherid, coordid, lat, lon, dateadded) values('" . $_POST["floorid"] . "', '" . $_POST["facilityid"] . "', '" . $coordid . "', '" . $_POST["lat"] . "', '" . $_POST["lon"] . "', '" . date("Y-m-d") . "')";
			}
			else
			{
				$coordid = $_POST["coordid"];
				$sql = "update mall_directory_other_coordinates set lat = '" . $_POST["lon"] . "', lon = '" . $_POST["lon"] . "', dateadded = '" . date("Y-m-d") . "' where coordid = '" . $coordid . "'";
			}
			$result = mysql_query($sql);
			if($result == "1")
			{ echo "|1"; }
			else
			{ echo "|Error: " . mysql_error() . "!"; }
		break;
		case "savecoordinate3":
			$sql = "";
			if($_POST["routeid"] == "")
			{
				$routeid = createidno("L", "mall_directory_route", "routeid");
				$sql = "insert into mall_directory_route(floorid, shopid, routeid, coord, dateadded) values('" . $_POST["floorid"] . "', '" . $_POST["shopid"] . "', '" . $routeid . "', '" . $_POST["coord"] . "', '" . date("Y-m-d") . "')";
			}
			else
			{
				$routeid = $_POST["routeid"];
				$sql = "update mall_directory_route set coord = '" . $_POST["coord"] . "', dateadded = '" . date("Y-m-d") . "' where routeid = '" . $routeid . "'";
			}
			$result = mysql_query($sql);
			if($result == "1")
			{ echo "|1"; }
			else
			{ echo "|Error: " . mysql_error() . "!"; }
		break;
	}
?>