<script>
	var start = false;
	var main_floorid = "";
	var draw;
	var added;
	var selection;
	var featured;
	var clicked = false;
	
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
	
	$(function(){
		$(window).keydown(function(event){
			var x = event.keyCode;
			if(x == 27)
			{ allowselection(); }
		});
		allowselection();
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
	
	function fillstyle(categoryid, color)
	{
		var fillcolor = color;
		var mystyle = new ol.style.Style({
			fill: new ol.style.Fill({
				color: fillcolor
			})
		});
		return mystyle;
	}
	
	function loadmap(floorid, floorname, ext, width, height)
	{
		main_floorid = floorid;
		start = true;
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
		loadcoordinates();
	}
	
	function loadcoordinates()
	{
		source.clear(true);
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'floorid=' + main_floorid + '&form=loadcoordinates',
			beforeSend:function(){
			},
			success: function(data) {
				var arr = data.split("#");
				for(var i=1; i<=arr.length-1; i++)
				{
					var arr2 = arr[i].split("|");
					var thing = new ol.geom.Polygon(JSON.parse(arr2[6]));
					var featurething = new ol.Feature({
						geometry: thing
					});
					featurething.setId(arr2[1]);
					featurething.set("name", arr2[3]);
					featurething.setStyle([fillstyle(arr2[4], arr2[5]), stroke, textstyle(arr2[3])]);
					source.addFeature(featurething);
				}
				loadcoordinates2();
			}
		}).error(function() {
			alert(data);
		});
	}
	
	function loadcoordinates2()
	{
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'floorid=' + main_floorid + '&form=loadcoordinates2',
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
				loadcoordinates3();
			}
		}).error(function() {
			alert(data);
		});
	}
	
	function loadcoordinates3()
	{
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'floorid=' + main_floorid + '&form=loadcoordinates3',
			beforeSend:function(){
			},
			success: function(data) {
				var arr = data.split("#");
				for(var i=1; i<=arr.length-1; i++)
				{
					var arr2 = arr[i].split("|");
					var thing = new ol.geom.LineString(JSON.parse(arr2[4]));
					var lfeature = new ol.Feature({
						geometry: thing
					});
					lfeature.set("id", arr2[1]);
					lfeature.set("name", arr2[3]);
					lfeature.setStyle([stroke2]);
					source.addFeature(lfeature);
				}
				allowselection();
			}
		}).error(function() {
			alert(data);
		});
	}
	
	function plotshop()
	{
		if(start != true)
		{ alert("Please Select a Floor First."); }
		else
		{
			loadcategories2();
			loadshops2("");
			$("#plotshop").modal("show");
		}
	}
	
	function loadcategories2()
	{
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'form=loadcategories2',
			beforeSend:function(){
			},
			success: function(data) {
				$("#txtcategories").html(data);
			}
		}).error(function() {
			alert(data);
		});
	}
	
	function loadshops2(categoryid)
	{
		if(categoryid == "")
		{ $("#txtshops").prop("disabled", true); }
		else
		{ $("#txtshops").prop("disabled", false); }
		
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'categoryid=' + categoryid + '&form=loadshops2',
			beforeSend:function(){
			},
			success: function(data) {
				$("#txtshops").html(data);
			}
		}).error(function() {
			alert(data);
		});
	}
	
	function plotfacility()
	{
		if(start != true)
		{ alert("Please Select a Floor First."); }
		else
		{
			loadfacility2();
			$("#plotfacility").modal("show");
		}
	}
	
	function loadfacility2()
	{
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'form=loadfacilities2',
			beforeSend:function(){
			},
			success: function(data) {
				$("#txtfacilities").html(data);
			}
		}).error(function() {
			alert(data);
		});
	}
	
	function plotfacility2()
	{
		clicked = true;
		var a = map.on('click', function(evt){
			var coord = evt.coordinate;
			savecoordinate2(coord[0], coord[1], clicked);
			map.unByKey(a);
		});
	}
	
	function plotshop2(){
		draw = new ol.interaction.Draw({
			features: features,
			type: ("Polygon")
		});
		
		draw.on('drawend', function(event){
			var coord = event.feature.getGeometry().getCoordinates();
			added = event.feature;
			$("#txtcoord").val(JSON.stringify(coord));
			showmodal("confirm", "Save Coordinate for this shop?", "savecoordinate", null, "", null, "0");
		});
		
		map.addInteraction(draw);
	}
	
	function allowselection()
	{
		map.removeInteraction(draw);
		selection = new ol.interaction.Select({
			condition: ol.events.condition.click
		});
		
		selection.on('select', function(evt){
			var selected = evt.selected;
			var deselected = evt.deselected;
			
			if(selected.length)
			{
				selected.forEach(function(feature){
					if(feature.getId().toString() != "undefined")
					{
						selected = feature.getId();
						featured = feature;
						var geom = featured.getGeometry().getExtent();
						var center = ol.extent.getCenter(geom);
						plotshop3(center, selected);
					}
				});
			}
		});
		
		map.addInteraction(selection);
	}
	
	function plotshop3(center, selected){
		draw = new ol.interaction.Draw({
			features: features,
			type: ("LineString")
		});
		
		draw.on('drawend', function(event){
			var coord = event.feature.getGeometry().getCoordinates();
			added = event.feature;
			coord[0] = center;
			$("#txtcoord").val(JSON.stringify(coord));
			var arr = [];
			arr.push(selected);
			showmodal("confirm", "Save Route?", "savecoordinate3", arr, "", null, "0");
		});
		
		map.addInteraction(draw);
	}
	
	function savecoordinate()
	{
		var categoryid = $("#txtcategories").val();
		var shopid = $("#txtshops").val();
		var coord = $("#txtcoord").val();
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'coordid=&floorid=' + main_floorid + '&categoryid=' + categoryid + '&shopid=' + shopid + '&coord=' + coord + '&form=savecoordinate',
			beforeSend:function(){
			},
			success: function(data) {
				var arr = data.split("|");
				if(arr[1] == "1")
				{
					showmodal("alert", "Coordinate has been plotted.", "", null, "", null, "0");
					loadcoordinates();
				}
				else
				{ alert(arr[1]); }
			}
		}).error(function() {
			alert(data);
		});
	}
	
	function savecoordinate2(lat, lon)
	{
		if(clicked == true)
		{
			var facilityid = $("#txtfacilities").val();
			$.ajax({
				type: 'POST',
				url: 'mainclass.php',
				data: 'coordid=&floorid=' + main_floorid + '&facilityid=' + facilityid + '&lat=' + lat + '&lon=' + lon + '&form=savecoordinate2',
				beforeSend:function(){
				},
				success: function(data) {
					var arr = data.split("|");
					if(arr[1] == "1")
					{
						showmodal("alert", "Coordinate has been plotted.", "", null, "", null, "0");
						loadcoordinates();
						clicked = false;
					}
					else
					{ alert(arr[1]); }
				}
			}).error(function() {
				alert(data);
			});
		}
	}
	
	function savecoordinate3(shopid)
	{
		var coord = $("#txtcoord").val();
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'routeid=&floorid=' + main_floorid + '&shopid=' + shopid + '&coord=' + coord + '&form=savecoordinate3',
			beforeSend:function(){
			},
			success: function(data) {
				var arr = data.split("|");
				if(arr[1] == "1")
				{
					showmodal("alert", "Route has been created.", "", null, "", null, "0");
					loadcoordinates();
					clicked = false;
				}
				else
				{ alert(arr[1]); }
			}
		}).error(function() {
			alert(data);
		});
	}
</script>
<div class="row">
	<div class="col-sm-6">
    	<h2 class="floor-title">Floor Plan Setup</h2>
		<p class="floor-subtitle">Select a floor on floor list</p>
    </div>
	<div class="col-sm-6">
    	<div class="btn-group" style="margin-top: 30px;">
        	<button class="btn btn-info" onClick="plotshop();"><span class="fa fa-shopping-bag"></span>&nbsp;&nbsp;Plot Shop</button>
        	<button class="btn btn-success" onClick="plotfacility();"><span class="fa fa-users"></span>&nbsp;&nbsp;Plot Facility</button>
        </div>
        <button class="btn btn-default" onClick="$('#instructions').modal('show');" style="margin-top: 30px;"><span class="fa fa-info-circle"></span>&nbsp;&nbsp;Show Instructions</button>
    </div>
</div>
<div id="showcanvas" style="margin: 10px; border: solid 1px #dddddd; min-height: 450px;">
</div>
<div class="modal fade fade-scale" id="plotshop" role="dialog">
	<div class="modal-dialog">
    	<div class="modal-content">
        	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal"><span class="fa fa-close"></span></button>
                <h4 class="modal-title">Plot Shops</h4>
      		</div>
      		<div class="modal-body">
            	<div class="row">
                	<div class="col-sm-3"><p>Select Category</p></div>
                	<div class="col-sm-9"><select class="form-control" id="txtcategories" onChange="loadshops2(this.value);"></select></div>
                </div>
            	<div class="row" style="margin-top: 5px;">
                	<div class="col-sm-3"><p>Select Shop</p></div>
                	<div class="col-sm-9"><select class="form-control" id="txtshops" disabled></select></div>
                </div>
                <input type="hidden" id="txtcoord">
      		</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onClick="$('#plotshop').modal('hide'); plotshop2();">Submit</button>
      		</div>
		</div>
	</div>
</div>
<div class="modal fade fade-scale" id="plotfacility" role="dialog">
	<div class="modal-dialog modal-sm">
    	<div class="modal-content">
        	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal"><span class="fa fa-close"></span></button>
                <h4 class="modal-title">Plot Facility</h4>
      		</div>
      		<div class="modal-body">
            	<div class="row">
                	<div class="col-sm-5"><p>Select Facility</p></div>
                	<div class="col-sm-7"><select class="form-control" id="txtfacilities"></select></div>
                </div>
      		</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onClick="$('#plotfacility').modal('hide'); plotfacility2();">Submit</button>
      		</div>
		</div>
	</div>
</div>
<div class="modal fade fade-scale" id="instructions" role="dialog">
	<div class="modal-dialog">
    	<div class="modal-content">
        	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal"><span class="fa fa-close"></span></button>
                <h4 class="modal-title">Instructions</h4>
      		</div>
      		<div class="modal-body">
            	<div class="instructions">
                <ul class="list-group">
                    <li class="list-group-item">
                    	<h4>Plotting a shop</h4>
                        <p>Click Plot Shop button</p>
                        <p>Select a shop</p>
                        <p>Draw the area of the shop</p>
                    </li>
                    <li class="list-group-item">
                    	<h4>Plotting a facility</h4>
                        <p>Click Plot Facility button</p>
                        <p>Select a facility</p>
                        <p>Click the point where the facility is located</p>
                    </li>
                    <li class="list-group-item">
                    	<h4>Creating a Route</h4>
                        <p>Click a shop you want to create a route</p>
                        <p>Draw the route and finish it at the entrance</p>
                        <p>Double click to finish the drawing</p>
                    </li>
                </ul>
                </div>
      		</div>
		</div>
	</div>
</div>