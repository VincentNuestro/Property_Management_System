<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=720, user-scalable=no">

<!-- <title>Raphael Paint</title> -->
<link rel="shortcut icon" type="image/x-icon" href="../../assets/images/ai1logo.png" />
<style>
#canvas_container {  
	position: fixed;
	left: 30px;
	top: 140px;
	width: 660px;
	height: 1050px;
    border: 1px solid #aaa;  
}

#tools {
	text-align: center;
	margin-left: 20px;
	width: 97%;
}

.ui-field-contain .ui-controlgroup-controls {
	width: 100% !important;
}

.ui-slider-track.ui-mini .ui-slider-handle {
	height: 30px !important;
	width: 30px !important;
	margin: -16px 0 0 -7px !important;
}

.ui-slider-track.ui-mini .ui-slider-handle .ui-btn-inner {
	margin: 0 !important;
}

#move-scale-rotate {
	margin-left: 30px;
	vertical-align: middle;
}

#rotate-div {
	width: 400px;
	margin-left: 10px;
	z-index: 2;
	position: absolute;
}

.transformations { 
	width: 200px; 
	height: 50px;
	margin: 5px;
	text-align: center;
	font-size: 20px;
}

#color-picker {
	position: absolute;
	left: 360px;
	top: 160px;
	width: 300px;
	background-color: rgba(255, 255, 255, 0.8);
}

#output { 
	text-align: center;
	-webkit-border-radius: 0 !important;
	border-radius: 0 !important;
}

div.ui-input-text {
	padding: 0 !important;
}

.tools-icon {
	height: 35px;
	width: 35px;
}

#arrow-label {
	background-image: url(css/images/tools/arrow.png);
	background-size: 35px 35px;
    background-repeat: no-repeat; 
    border: none !important;
    border-radius: 3px !important;
}

#rect-label {
	background-image: url(css/images/tools/rect.png);
	background-size: 35px 35px;
    background-repeat: no-repeat; 
    border: none !important;
    border-radius: 3px !important;
}

#square-label {
	background-image: url(css/images/tools/square.png);
	background-size: 35px 35px;
    background-repeat: no-repeat; 
    border: none !important;
    border-radius: 3px !important;
}

#triangle-label {
	background-image: url(css/images/tools/triangle.png);
	background-size: 35px 35px;
    background-repeat: no-repeat; 
    border: none !important;
    border-radius: 3px !important;
}

#circle-label {
	background-image: url(css/images/tools/circle.png);
	background-size: 35px 35px;
    background-repeat: no-repeat; 
    border: none !important;
    border-radius: 3px !important;
}

#ellipse-label {
	background-image: url(css/images/tools/ellipse.png);
	background-size: 35px 35px;
    background-repeat: no-repeat; 
    border: none !important;
    border-radius: 3px !important;
}

#star-label {
	background-image: url(css/images/tools/star.png); 
	background-size: 35px 35px;
    background-repeat: no-repeat;
    border: none !important;
    border-radius: 3px !important;
}

#eraser-label {
	background-image: url(css/images/tools/eraser.png);
	background-size: 35px 35px;
    background-repeat: no-repeat; 
    border: none !important;
    border-radius: 3px !important;
}

#fill-color-label {
	background-image: url(css/images/tools/fill.png);
	background-size: 35px 35px;
    background-repeat: no-repeat; 
    border: none !important;
    border-radius: 3px !important;
}

#stroke-color-label {
	background-image: url(css/images/tools/stroke.png);
	background-size: 35px 35px;
    background-repeat: no-repeat; 
    border: none !important;
    border-radius: 3px !important;
}

#clear-label {
	background-image: url(css/images/tools/clear_canvas.png); 
	background-size: 35px 35px;
    background-repeat: no-repeat; 
    border: none !important;
    border-radius: 3px !important;
}
</style>
<link rel="stylesheet" href="css/jquery.mobile-1.3.0.css" />
<script src="js/lib/external/jquery-1.9.0.js"></script>
<script src="js/lib/external/jquery.mobile-1.3.0.js"></script>
<script src="js/lib/tlib/tlib.js"></script>
<script src="js/lib/tlib/tlib.logger.js"></script>
<script src="js/lib/external/raphael-min.js"></script>
<script src="js/lib/external/colorpicker.js"></script>
<script src="js/transforms.js"></script>
<script src="js/config.js"></script>
<script src="js/shapeDrawer.js"></script>
<script src="js/raphaelPaint.js"></script>
<script src="js/main.js"></script>

</head>

<body>
	<div class="row form-group" data-role="page" data-theme="d">
		<!-- <div data-role="header" data-theme="d">
			<a href="" id="close" data-role="button" data-icon="delete" data-theme="d" data-iconpos="right">Close</a>
			<h1>Raphael Paint</h1>
		</div> -->
		
		<div id="tools" data-role="fieldcontain">
			<fieldset data-role="controlgroup" data-type="horizontal" style="margin-bottom: 0px !important;">
				
						<input id="arrow" type="radio" name="options" class="paint-tool" checked="checked" /> <label for="arrow" id="arrow-label" class="tools-icon" style="margin: 2px;"></label>
				
						<input id="rectangle" type="radio" name="options" class="paint-tool" /> <label for="rectangle" id="rect-label" class="tools-icon" style="margin: 2px;"></label>
				
						<input id="square" type="radio" name="options" class="paint-tool" /> <label for="square" id="square-label" class="tools-icon" style="margin: 2px;"></label>
				
						<input id="triangle" type="radio" name="options" class="paint-tool" /> <label for="triangle" id="triangle-label" class="tools-icon" style="margin: 2px;"></label>
				
						<input id="circle" type="radio" name="options" class="paint-tool" /> <label for="circle" id="circle-label" class="tools-icon" style="margin: 2px;"></label>
					
				
						<input id="ellipse" type="radio" name="options" class="paint-tool" /> <label for="ellipse" id="ellipse-label" class="tools-icon" style="margin: 2px;"></label>
					
				
						<input id="star" type="radio" name="options" class="paint-tool" /><label for="star" id="star-label" class="tools-icon" style="margin: 2px;"></label>
					
				
						<input id="eraser" type="radio" name="options" class="paint-tool" /><label for="eraser" id="eraser-label" class="tools-icon" style="margin: 2px;"></label>
					
				
						<input id="fillColor" type="radio" name="color" class="paint-tool" /><label for="fillColor" id="fill-color-label" class="tools-icon" style="margin: 2px;"></label>
						
				
						<input id="strokeColor" type="radio" name="color" class="paint-tool" /><label for="strokeColor" id="stroke-color-label" class="tools-icon" style="margin: 2px;"></label>
						
				
						<input id="clear" type="radio" name="options" class="paint-tool" /><label for="clear" id="clear-label" class="tools-icon" style="margin: 2px;"></label>
			
					
				
			</fieldset>
		</div>

		<div id="move-scale-rotate">
			<fieldset data-role="controlgroup" data-type="horizontal">
				<input type="radio" name="operation" class="transformations" id="move" checked="checked" /> <label for="move">Move</label> 
				<input type="radio" name="operation" class="transformations" id="scale" /> <label for="scale">Scale</label> 
				<input type="radio" name="operation" class="transformations" id="rotate" /> <label for="rotate">Rotate</label>
			</fieldset>
			<div id="rotate-div">
				<input type="range" id="rot-slider" name="rot-slider" min="0" max="360" value="0" data-mini="true" step="1" />
			</div>
		</div>
	
		<div id="canvas_container" style="width: 600px;height: 600px;"></div>
		
		<div id="color-picker">
			<input type="text" id="output" >
			<a href="" id="cp-close" data-role="button" data-theme="d" data-mini="true">Ok</a>
		</div>
	</div>
</body>
</html>