<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Mall Directory</title>
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="css/ol.css" rel="stylesheet" type="text/css">
<link href="css/style.css" rel="stylesheet" type="text/css">
<script src="js/jquery-1.11.3.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.nicescroll.min.js"></script>
<script src="js/ol.js"></script>
</head>
<body>
<script>
	var features;
	var source;
	var raster;
	var vector;
	var extent = [];
	var projection;
	var map;
	
	$(function(){
		$("body").niceScroll({
			cursorcolor: "#666",
			cursoropacitymax: 0.5,
			cursorwidth: "10px",
			background: "#dddddd",
			cursorborderradius: "0px",
			cursorborder: "0",
			autohidemode: false,
			cursorminheight: 30,
			horizrailenabled: false
		});
	});
</script>
<h1 class="main-title">Mall Directory Setup</h1>
<div class="row">
	<div class="col-sm-4">
        <div class="referential">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#link1" data-toggle="tab">Floor List</a></li>
                <li><a href="#link2" data-toggle="tab">Categories & Shops</a></li>
                <li><a href="#link3" data-toggle="tab">Others</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="link1">
                	<?php include("../mall_directory/floors.php"); ?>
                </div>
                <div class="tab-pane" id="link2">
                    <?php include("../mall_directory/categories.php"); ?>
                </div>
                <div class="tab-pane" id="link3">
                	<?php include("../mall_directory/others.php"); ?>
                </div>
            </div>
        </div>
	</div>
	<div class="col-sm-8">
    	<?php include("../mall_directory/floorsetup.php"); ?>
    </div>
</div>
<?php include("../mall_directory/modal.php"); ?>
</body>
</html>