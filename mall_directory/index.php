<?php 
	session_start();
	include("connect.php"); 
?>
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
<body style="background: #eeecee;">
<script>
	var mainfloorid = "";
	var features;
	var source;
	var raster;
	var vector;
	var extent = [];
	var projection;
	var map;
	
	var stroke = new ol.style.Style({
		stroke: new ol.style.Stroke({
			color: '#333',
			width: 1.5
		})
	});
	
	var stroke2 = new ol.style.Style({
		stroke: new ol.style.Stroke({
			color: '#06F',
			width: 5
		})
	});
	
	function textstyle(myname)
	{
		var text = new ol.style.Style({
			text: new ol.style.Text({
				font: '10px Open Sans Light',
				fill: new ol.style.Fill({ color: '#FFF' }),
				stroke: new ol.style.Stroke({
					color: '#FFF',
					width: 0.5
				}),
				text: myname
			})
		});
		return text;
	}
	
	function fillstyle(color)
	{
		var fillcolor = color;
		var mystyle = new ol.style.Style({
			fill: new ol.style.Fill({
				color: fillcolor
			})
		});
		return mystyle;
	}
	
	$(function(){
		loadmap("FLOOR-0000001", "First Floor", "jpg", "1600", "1091");
		$("#resultlist").niceScroll({
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
	
	setInterval(function(){
		$("#showcanvas").width($(window).width());
		$("#showcanvas").height($(window).height() - $(".menu").height());
	}, 100);
	
	function loadmap(floorid, floorname, ext, width, height)
	{
		mainfloorid = floorid;
		$("#showcanvas").html("");
		features = new ol.Collection();
		source = new ol.source.Vector({features: features});
	
		raster = new ol.layer.Tile({
			source: new ol.source.OSM()
		});

		vector = new ol.layer.Vector({
			source: source
		});
		
		extent = [0, 0, parseFloat(width), parseFloat(height)];
	
		projection = new ol.proj.Projection({
			code: 'xkcd-image',
			units: 'pixels',
			extent: extent
		});

		map = new ol.Map({
			layers: [
				new ol.layer.Image({
				source: new ol.source.ImageStatic({
					attributions: '',
					url: 'floors/' + floorid + '.' + ext,
					projection: projection,
					imageExtent: extent
				}),
				opacity: 1
			  }),
			  vector
			],
			target: 'showcanvas',
			view: new ol.View({
				projection: projection,
				center: ol.extent.getCenter(extent),
				zoom: 2,
				maxZoom: 5
			})
		});
		
		vector.setMap(map);
	}
	
	function showfacilities()
	{
		$.ajax({
			type: 'POST',
			url: 'mainclass2.php',
			data: 'floorid=' + mainfloorid + '&form=loadfacilities',
			beforeSend:function(){
			},
			success: function(data) {
				$("#facilitylist2").html(data);
			}
		}).error(function() {
			alert(data);
		});
		$("#facilitylist").modal("show");
	}
	
	function loadfacilities(otherid)
	{
		source.clear(true)
		$.ajax({
			type: 'POST',
			url: 'mainclass2.php',
			data: 'floorid=' + mainfloorid + '&otherid=' + otherid + '&form=loadfacilities2',
			beforeSend:function(){
			},
			success: function(data) {
				var arr = data.split("#");
				for(var i=1; i<=arr.length-1; i++)
				{
					var arr2 = arr[i].split("|");
					var iconStyle = new ol.style.Style({
						image: new ol.style.Icon(({
							anchor: [0.5, 0.5],
							size: [100, 100],
							opacity: 1,
							scale: 0.3,
							src: "images/icons/" + arr2[3] + ".png"
						}))
					});
					var mfeature = new ol.Feature(new ol.geom.Point([parseFloat(arr2[4]), parseFloat(arr2[5])]));
					mfeature.set("id", arr2[1]);
					mfeature.set("name", arr2[3]);
					mfeature.setStyle(iconStyle);
					source.addFeature(mfeature);
				}
				$("#facilitylist").modal("hide");
			}
		}).error(function() {
			alert(data);
		});
	}
	
	function showcategories()
	{
		$.ajax({
			type: 'POST',
			url: 'mainclass2.php',
			data: 'floorid=' + mainfloorid + '&form=loadcategories',
			beforeSend:function(){
			},
			success: function(data) {
				$("#categorylist2").html(data);
			}
		}).error(function() {
			alert(data);
		});
		$("#categorylist").modal("show");
	}
	
	function selectcategory(categoryid, color)
	{
		source.clear(true);
		$.ajax({
			type: 'POST',
			url: 'mainclass2.php',
			data: 'floorid=' + mainfloorid + '&categoryid=' + categoryid + '&form=loadcoordinates',
			beforeSend:function(){
			},
			success: function(data) {
				var arr = data.split("#");
				for(var i=1; i<=arr.length-1; i++)
				{
					var arr2 = arr[i].split("|");
					var thing = new ol.geom.Polygon(JSON.parse(arr2[3]));
					var featurething = new ol.Feature({
						geometry: thing
					});
					featurething.setId(arr2[1]);
					featurething.set("name", arr2[2]);
					featurething.setStyle([fillstyle(color), stroke, textstyle(arr2[2])]);
					source.addFeature(featurething);
				}
				$("#categorylist").modal("hide");
			}
		}).error(function() {
			alert(data);
		});
	}
	
	function searchall()
	{
		searchall2("");
		$("#search").modal("show");
	}
	
	function searchall2(key)
	{
		$.ajax({
			type: 'POST',
			url: 'mainclass2.php',
			data: 'key=' + key + '&form=searchresult',
			beforeSend:function(){
			},
			success: function(data) {
				$("#resultlist").html(data);
				addresultclick();
			}
		}).error(function() {
			alert(data);
		});
	}
	
	function addresultclick()
	{
		$("#resultlist p").click(function(){
			var obj = $(this);
			loadshopcoordinates(obj.attr("id"));
		});
	}
	
	function loadshopcoordinates(shopid)
	{
		source.clear(true);
		$.ajax({
			type: 'POST',
			url: 'mainclass2.php',
			data: 'floorid=' + mainfloorid + '&shopid=' + shopid + '&form=loadshopcoordinates',
			beforeSend:function(){
			},
			success: function(data) {
				var arr = data.split("#");
				for(var i=1; i<=arr.length-1; i++)
				{
					var arr2 = arr[i].split("|");
					var thing = new ol.geom.Polygon(JSON.parse(arr2[4]));
					var featurething = new ol.Feature({
						geometry: thing
					});
					featurething.setId(arr2[1]);
					featurething.set("name", arr2[2]);
					featurething.setStyle([fillstyle(arr2[3]), stroke, textstyle(arr2[2])]);
					source.addFeature(featurething);
				}
				$("#search").modal("hide");
				loadshoproutes(shopid);
			}
		}).error(function() {
			alert(data);
		});
	}
	
	function loadshoproutes(shopid)
	{
		$.ajax({
			type: 'POST',
			url: 'mainclass2.php',
			data: 'floorid=' + mainfloorid + '&shopid=' + shopid + '&form=loadshoproutes',
			beforeSend:function(){
			},
			success: function(data) {
				var arr = data.split("#");
				for(var i=1; i<=arr.length-1; i++)
				{
					var arr2 = arr[i].split("|");
					var thing = new ol.geom.LineString(JSON.parse(arr2[3]));
					var lfeature = new ol.Feature({
						geometry: thing
					});
					lfeature.set("id", arr2[1]);
					lfeature.set("name", arr2[2]);
					lfeature.setStyle([stroke2]);
					source.addFeature(lfeature);
				}
			}
		}).error(function() {
			alert(data);
		});
	}
	
	function showfloors()
	{
		$.ajax({
			type: 'POST',
			url: 'mainclass2.php',
			data: 'floorid=' + mainfloorid + '&form=loadfloors',
			beforeSend:function(){
			},
			success: function(data) {
				$("#floorlist2").html(data);
			}
		}).error(function() {
			alert(data);
		});
		$("#floorlist").modal("show");
	}
</script>
<div class="page-header" style="margin-bottom: 10px;padding-top:10px;background-color: #edf4f8;padding-bottom: 10px;">
    <h1><b>COMPLAINTS</b></h1>
</div
	<div class="menu">
		<h1 class="main-title2">Mall Directory</h1>
	    <div class="button">
	        <button class="btn btn-default" onclick="showfloors();"><span class="fa fa-street-view"></span>&nbsp;&nbsp;Change Floor</button>
	        <button class="btn btn-default" onclick="showfacilities();"><span class="fa fa-info-circle"></span>&nbsp;&nbsp;Facilities</button>
	        <button class="btn btn-default" onclick="showcategories();"><span class="fa fa-filter"></span>&nbsp;&nbsp;Categories</button>
	        <button class="btn btn-default" onclick="searchall();"><span class="fa fa-search"></span>&nbsp;&nbsp;Search</button></button>
	    </div>
	</div>
	<div id="showcanvas"></div>

<div class="modal fade fade-scale selectcat" id="floorlist" role="dialog">
	<div class="modal-dialog">
    	<div class="modal-content">
        	<div class="modal-header">
            	<button class="btn btn-default btn-sm" onclick="$('#floorlist').modal('hide');"><span class="fa fa-close"></span></button>
      		</div>
      		<div class="modal-body">
            	<h1 class="filter-title">Change Floor</h1>
                <div class="row" id="floorlist2">
                </div>
                <br><br>
      		</div>
		</div>
	</div>
</div>
<div class="modal fade fade-scale selectcat" id="facilitylist" role="dialog">
	<div class="modal-dialog">
    	<div class="modal-content">
        	<div class="modal-header">
            	<button class="btn btn-default btn-sm" onclick="$('#facilitylist').modal('hide');"><span class="fa fa-close"></span></button>
      		</div>
      		<div class="modal-body">
            	<h1 class="filter-title">Find Facilities</h1>
                <div class="row" id="facilitylist2">
                </div>
                <br><br>
      		</div>
		</div>
	</div>
</div>
<div class="modal fade fade-scale selectcat" id="categorylist" role="dialog">
	<div class="modal-dialog">
    	<div class="modal-content">
        	<div class="modal-header">
            	<button class="btn btn-default btn-sm" onclick="$('#categorylist').modal('hide');"><span class="fa fa-close"></span></button>
      		</div>
      		<div class="modal-body">
            	<h1 class="filter-title">Filter by Category</h1>
                <div class="row" id="categorylist2">
                </div>
                <br><br>
      		</div>
		</div>
	</div>
</div>
<div class="modal fade fade-scale selectcat" id="search" role="dialog">
	<div class="modal-dialog modal-lg">
    	<div class="modal-content">
        	<div class="modal-header">
            	<button class="btn btn-default btn-sm" onclick="$('#search').modal('hide');"><span class="fa fa-close"></span></button>
      		</div>
      		<div class="modal-body">
            	<div class="row">
                	<div class="col-sm-1"></div>
                	<div class="col-sm-10">
                    	<h1 class="filter-title">Looking for something?</h1>
                        <div class="input-group">
                    		<input type="text" class="form-control txtsearch" placeholder="Type keyword here...">
                            <span class="input-group-addon"><span class="fa fa-keyboard-o" style="font-size: 20px; font-weight: 800;"></span></span>
                        </div>
                        <div class="row results" id="resultlist" style="height: 380px;">
                        </div>
                    </div>
                	<div class="col-sm-1"></div>
                </div>
      		</div>
		</div>
	</div>
</div>
</html>