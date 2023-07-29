<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title id="titletext"></title>

		<meta name="description" content="overview &amp; stats" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />
		<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome-animation.min.css" />
		<link href="//fonts.googleapis.com/css?family=Roboto:100italic,100,300italic,300,400italic,400,500italic,500,700italic,700,900italic,900" rel="stylesheet" type="text/css">

		<!-- text fonts -->
		<link rel="stylesheet" href="assets/css/fonts.googleapis.com.css" />
		<link rel="shortcut icon" type="images/x-icon" href="assets/images/ai1logo.png" />
		<!-- ace styles -->
		<link rel="stylesheet" href="assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />

		<link rel="stylesheet" href="assets/css/stylengtable.css" />
		<link rel="stylesheet" href="assets/css/ace-skins.min.css" />
		<link rel="stylesheet" href="assets/css/ace-rtl.min.css" />
		<link rel="stylesheet" href="assets/css/tablenav.css" />

		<!-- ace settings handler -->
		<script src="assets/js/jquery-2.1.4.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/ace-extra.min.js"></script>
		<script src="assets/js/moment.min.js"></script>

		<script src="assets/js/jquery-ui.custom.min.js"></script>
		<!-- ace scripts -->
		<script src="assets/js/ace-elements.min.js"></script>
		<script src="assets/js/ace.min.js"></script>
		<style>		

		::-webkit-scrollbar-thumb {
		    -webkit-border-radius: 10px;
		    border-radius: 10px;
		    background: #cccccc;
		    -webkit-box-shadow: inset 0 0 6px #cccccc;
		}

		::-webkit-scrollbar-thumb:window-inactive {
		    background: #cccccc;
		}

		@media only screen and (max-width: 900px) {
		    .hide_mobile{
		    	display: none;
			}
		}

		*{
			/*font-family: Roboto;*/
			/*font-size: 13px;
			/*color: #333;*/
		}
		</style>
	</head>
	<body style="width: 100%;overflow-x: hidden;background-repeat: no-repeat;background-size: cover;" id="txtCompBGImage">
		<div class="row">
			<div class="col-md-1"></div>
			<div class="col-md-6" style="margin-top: 5%;">
				<h1 class="center txtLPColor" style="font-size: 50px;color: white;" id="txtCompName"></h1>
				<p class="txtLPColor" style="color: white;" id="txtCompAbout"></p>
				<p class="txtLPColor" style="color: white;">CONTACT US</p>
				<p class="txtLPColor" style="color: white;" id="txtCompAddress"></p>
				<p class="txtLPColor" style="color: white;" id="txtCompTelephone"></p>
				<p class="txtLPColor" style="color: white;" id="txtCompCellphone"></p>
				<p class="txtLPColor" style="color: white;" id="txtCompEmail"></p>
			</div>
			<div class="col-md-4">
				<div class="row">
					<div class="col-md-12">
						<img style="width: 100%;height: 40vh;" id="txtCompImage">				
					</div>
				</div>
				<div class="row form-group" style="margin-top: 5%;">
					<div class="col-md-12">
						<a class="btn btn-white btn-lg btn-block btn-round" style="background-color: transparent !important;" id="btnCompFirst"><b class="txtLPColor" id="txtCompSysBtn"></b></a>
					</div>
				</div>
				<div class="row form-group" style="margin-top: 5%;">
					<div class="col-md-12">
						<a class="btn btn-white btn-lg btn-block btn-round" style="background-color: transparent !important;" id="btnCompSecond"><b class="txtLPColor"> Tenant Portal System</b></a>
					</div>
				</div>
				<div class="row form-group" style="margin-top: 5%;">
					<div class="col-md-12">
						<div id="myCarousel" class="carousel slide" data-ride="carousel">
						  	<ol class="carousel-indicators">
						  		<?php
						  			include('connect.php');
						  			$Count = 0;
						  			$res = mysql_query("SELECT id FROM tblref_mall WHERE mallstat = '1';", $connection);
						  			while($row = mysql_fetch_array($res)){
										if($Count == 0){
											$SetActive = "active";
										}else{
											$SetActive = "";
										}
						  				echo 	"<li data-target='#myCarousel' data-slide-to='". $Count ."' class='". $SetActive ."'></li>";
							    	$Count++;
						  			}
						  		?>
						  	</ol>

						  	<div class="carousel-inner">
						  		<?php
						  			$Count2 = 0;
						  			$res = mysql_query("SELECT mall_image, mallname FROM tblref_mall WHERE mallstat = '1';", $connection);
						  			while($row = mysql_fetch_array($res)){
						  				if($row["mall_image"] == ""){
											$image = "assets/images/noimage5.png";
										}else{
											if(!file_exists("server/mall_image/". $row["mall_image"])){ 
												$image = "assets/images/noimage5.png";
											}else{
												$image = "server/mall_image/". $row["mall_image"];
											}
										}
										if($Count2 == 0){
											$SetActive = "active";
										}else{
											$SetActive = "";
										}
						  				echo 	"<div class='item ". $SetActive ."'>
							      					<img src='". $image ."' alt='". $row['mallname'] ."' style='height: 30vh; width: 100%;'>
							    				</div>";
							    	$Count2++;
						  			}
						  		?>
						  	</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-1"></div>
		</div>
	</body>
</html>
<script type="text/javascript">
	$(function(){
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'form=titletext',
			success: function(data){
				$("#titletext").text(data);
				$("#txtCompSysBtn").text(data);
			}
		})
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'form=frmLandingPage',
			success: function(data){
				var arr = data.split("|");
				$("#txtCompName").text(arr[0]);
				$("#txtCompAbout").text(arr[1]);
				$("#txtCompAddress").text(arr[2]);
				$("#txtCompTelephone").text(arr[3]);
				$("#txtCompCellphone").text(arr[4]);
				$("#txtCompEmail").text(arr[5]);
				$("#txtCompImage").attr("src", arr[6]);
				$("#txtCompImage").attr("alt", arr[0]);
				$("#txtCompBGImage").css("background-image", arr[7]);
				$(".txtLPColor").css("color", arr[8]);
				$("#btnCompFirst").attr("href", arr[9]);
				$("#btnCompSecond").attr("href", arr[10]);
			}
		})
	});
</script>