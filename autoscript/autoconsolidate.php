<!DOCTYPE html>
<html>
	<head>
		<title id="txtTabTitle"></title>
		<meta charset="utf-8" />
		<meta name="description" content="overview &amp; stats" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
		<link rel="shortcut icon" type="images/x-icon" href="../assets/images/ai1logo.png" />
		<link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="../assets/font-awesome/4.5.0/css/font-awesome.min.css" />
		<link rel="stylesheet" href="../assets/font-awesome/4.5.0/css/font-awesome-animation.min.css" />
		<link href="//fonts.googleapis.com/css?family=Roboto:100italic,100,300italic,300,400italic,400,500italic,500,700italic,700,900italic,900" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="../assets/css/fonts.googleapis.com.css" />
		<link rel="stylesheet" href="../assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />
		<link rel="stylesheet" href="../assets/css/stylengtable.css" />
		<link rel="stylesheet" href="../assets/css/ace-skins.min.css" />
		<link rel="stylesheet" href="../assets/css/ace-rtl.min.css" />
		<script src="../assets/js/jquery-2.1.4.min.js"></script>
		<script src="../assets/js/bootstrap.min.js"></script>
		<script src="../assets/js/jquery-ui.custom.min.js"></script>
		<script src="../assets/js/moment.min.js"></script>
	</head>
	<style type="text/css">
		::-webkit-scrollbar-thumb {
		    -webkit-border-radius: 10px;
		    border-radius: 10px;
		    background: #cccccc;
		    -webkit-box-shadow: inset 0 0 6px #cccccc;
		}

		::-webkit-scrollbar-thumb:window-inactive {
		    background: #cccccc;
		}
	</style>

	<body class="no-skin">
		<div id="navbar" class="navbar navbar-default ace-save-state">
			<div class="navbar-container ace-save-state" id="navbar-container">
				<div class="navbar-header pull-left">
					<a href="index.php" class="navbar-brand">
						<small id="systemheader">
							<i class="fa"></i>
						</small>
					</a>
				</div>
			</div>
		</div>

		<div class="main-container ace-save-state" id="main-container">
			<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
						
					</div>
					<div class="page-content">
						<div class="row">
							<div class="col-md-12">
								<div class="error-container">
									<div class="well">
										<h1 class="grey lighter smaller">
											<span class="blue bigger-125">
												<i class="ace-icon fa fa-calendar"></i>
											</span>
											Monthly Consolidation of CSV Files
										</h1>

										<hr />
										<div class="space"></div>

										<div>
											<ul class="list-unstyled spaced inline bigger-110 margin-15">
												<li>
													<i class="ace-icon fa fa-check blue"></i>
													Total sales of all tenants from <label id="txtDateFrom"></label> to <label id="txtDateTo"></label> has been successfully consolidated.
												</li>

												<li>
													<i class="ace-icon fa fa-check blue"></i>
													Consolidated sales CSV is at <label id="txtPath"></label>.
												</li>
											</ul>
										</div>

										<hr />
										<div class="space"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="footer">
				<div class="footer-inner">
					<div class="footer-content">
						<div class="form-group row"> 
							<div class="col-md-4 col-xs-12">
								<table style="padding:0px;">
									<tr style="padding:0px;"><td style="padding:0px;"><h6 class="smaller lighter black" style="text-align: left;display: inline-block;float: left;font-weight: bold;margin-bottom: 0px;" id="computerdatetime"></h6></td></tr>
									<tr style="padding:0px;"><td style="padding:0px;"><h6 class="smaller lighter black" style="text-align: left;display: inline-block;float: left;font-weight: bold;" id="sysdatetime"></h6></td></tr>
								</table>								
							</div>
							<div class="col-md-4 col-xs-12">
								<span class="bigger-120" style="display: inline-block;">
								<img src="../assets/images/ai1logo.png" height="35" width="30">
									Powered by 
									<a target="_blank" href="http://www.gatessoftcorp.com" class="blue bolder">Gatessoft Corporation</a>
								</span>
							</div>
							<div class="col-md-2 col-xs-12">
							</div>
							<div class="col-md-2 col-xs-12">
								<h6 class="smaller lighter black pull-right" style="text-align: left;display: inline-block;float: left;font-weight: bold;">Ver 2.0.12.239.113</h6>
							</div>
						</div>
					</div>
				</div>
			</div>
			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div>

	</body>
</html>

<script type="text/javascript">
	window.onload=function(){
		GetClock();
		setInterval(GetClock,1000);
		$.ajax({
			type: 'POST',
			url: 'class.php',
			data: 'form=getsysdate',
			success: function(data){
				$("#sysdatetime").text(data)
			}
		})
	}
	
	tday=new Array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
	tmonth=new Array("January","February","March","April","May","June","July","August","September","October","November","December");
	function GetClock(){
		var d=new Date();
		var nday=d.getDay(),nmonth=d.getMonth(),ndate=d.getDate(),nyear=d.getYear();
		if(nyear<1000) nyear+=1900;
		var nhour=d.getHours(),nmin=d.getMinutes(),nsec=d.getSeconds(),ap;

		if(nhour==0){
			ap=" AM";nhour=12;
		}else if(nhour<12){
			ap=" AM";
		}else if(nhour==12){
			ap=" PM";
		}else if(nhour>12){
			ap=" PM";nhour-=12;
		}

		if(nmin<=9) nmin="0"+nmin;
		if(nsec<=9) nsec="0"+nsec;

		$('computerdatetime').text("Computer Date: "+""+tday[nday]+", "+tmonth[nmonth]+" "+ndate+", "+nyear+" "+nhour+":"+nmin+":"+nsec+ap+"");
		document.getElementById('computerdatetime').innerHTML="Computer Date: "+""+tday[nday]+", "+tmonth[nmonth]+" "+ndate+", "+nyear+" "+nhour+":"+nmin+":"+nsec+ap+"";
	}

	$(function(){
		$.ajax({
			type: 'POST',
			url: 'class.php',
			data: 'form=txtSysHeader',
			success:function(data){
				$("#systemheader").html(data);
			}
		})	
		$.ajax({
			type: 'POST',
			url: 'class.php',
			data: 'form=txtTabTitle',
			success:function(data){
				$("#txtTabTitle").text(data);
			}
		})
		$.ajax({
			type: 'POST',
			url: 'class.php',
			data: 'form=AutoConsolidate',
			success:function(data){
				var arr = data.split("|");
				$("#txtDateFrom").text(arr[0]);
				$("#txtDateTo").text(arr[1]);
				$("#txtPath").text(arr[2]);
			}
		})
	})
</script>