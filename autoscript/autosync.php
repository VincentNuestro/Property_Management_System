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
							<div class="row form-group">
								<div class="col-md-12">
									<div class="btn-group">
		               	 				<button data-toggle="dropdown" class="btn btn-primary btn-white dropdown-toggle" aria-expanded="false">
											Export
											<i class="ace-icon fa fa-angle-down icon-on-right"></i>
										</button>
										<ul class="dropdown-menu">
											<li>
												<a href="#" onclick="ExportReport('Print')">Print</a>
											</li>
											<li>
												<a href="#" onclick="ExportReport('CSV')">CSV</a>
											</li>
											<!-- <li>
												<a href="#">PDF</a>
											</li> -->
										</ul>
									</div>
				                	<span class="pull-right" title="SFTP account doesn't exist, username or password is wrong or connection failed."><i class="center fa fa-times-circle blue bigger-120"></i>&nbsp;Access Denied</span>
					                <span class="pull-right" title="No file detected when file syncing is initiated"><i class="center fa fa-times-circle orange bigger-120"></i>&nbsp;File Not Found |&nbsp;</span>
									<span class="pull-right" title="CSV file doesn't meet the required standard"><i class="center fa fa-times-circle red bigger-120"></i>&nbsp;Failed |&nbsp;</span>
					                <span class="pull-right" title="Successful upload"><i class="center fa fa-check-circle green bigger-120"></i>&nbsp;Success |&nbsp;</span>
					                <span class="pull-right">&nbsp;Status :&nbsp;</span>
								</div>
							</div>
							<div class="row form-group">
								<div class="col-md-12" id="divUploadLogs">
									<table class="table table-bordered">
										<thead>
											<tr>
												<th style="width: 10%;">Date</th>
												<th style="width: 10%;">Mall</th>
												<th style="width: 20%;">Tenant</th>
												<th style="width: 10%;">Discount</th>
												<th style="width: 10%;">Hourly Sales</th>
												<th style="width: 10%;">Return/Void</th>
												<th style="width: 10%;">Payment Type</th>
												<th style="width: 10%;">Sales</th>
											</tr>
										</thead>
										<tbody id="tblUploadLogs"></tbody>
									</table>
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

		<div class="modal fade fade-scale" id="SepMdl_loadingSync" data-backdrop="static" style="margin-top: 10% !important;">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-body row">
						<div class="container-fluid">
							<center>
								<h3>Please wait while files are syncing...</h3>
								<span class="fa fa-spinner fa-spin fa-5x fa-fw" style="font-size: 100px;"></span>
							</center>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>

<div style="display: none;">
    <div class="col-md-12">
        <table style="width: 100%;" id="tblExportReportCSV">
            <th>Date</th>
            <th>Mall</th>
            <th>Tenant</th>
            <th>Discount</th>
            <th>Hourly Sales</th>
            <th>Return/Void</th>
            <th>Payment Type</th>
            <th>Sales</th>
            <tbody id="tbodyExportReportCSV"></tbody>
        </table>
    </div>
</div>

<div id="divExportReportLogs" style="display: none;">
    <table style="width: 100%;" cellspacing="0" cellpadding="0">
        <tbody id="template"></tbody>
    </table>
    <table style="width: 100%;">
        <thead>
            <tr>
                <td>Date</td>
                <td>Mall</td>
                <td>Tenant</td>
                <td>Discount</td>
                <td>Hourly Sales</td>
                <td>Return/Void</td>
                <td>Payment Type</td>
                <td>Sales</td>
            </tr>
            <td colspan="8"><hr></td>
        </thead>
        <tbody id="tbodyExportReportLogs"></tbody>
    </table>
</div>

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
			data: 'form=FetchScript',
			beforeSend: function(){
				$("#SepMdl_loadingSync").modal("show");
			},
			success: function(data){
				$("#SepMdl_loadingSync").modal("hide");
			},
			complete:function(){
				$.ajax({
					type: 'POST',
					url: 'class.php',
					data: 'form=clearCSV',
					success: function(data){
						showLogs();
					}
				})
			}
		})
	})

	function showLogs(){
		$.ajax({
			type: 'POST',
			url: 'class.php',
			data: 'form=showLogs',
			success: function(data){
				$("#tblUploadLogs").html(data);				
			}
		})
	}

	function ExportReport(type){
		$.ajax({
			type: 'POST',
			url: 'class.php',
			data: 'type=' + type + '&form=ExportReport',
			success: function(data){
				if(type == "CSV"){
					$("#tbodyExportReportCSV").html(data);
				}else{
					var arr = data.split("|");
					$("#template").html(arr[0]);
					$("#tbodyExportReportLogs").html(arr[1]);
				}
			}, complete: function(){
				if(type == "CSV"){
					exportTableToCSVTSR("Exported Reports.csv");
				}else{
					var toprint = $("#divExportReportLogs").html();
			        var myheight = $(window).height()-40;
			        var mywidth = $(window).width()-40;
			        var popupWin = window.open("", "_blank", "height=" + myheight + ",width=" + mywidth + ",location=no,scrollbars=1,left=" + 20);
			        popupWin.document.open();
			        popupWin.document.write("<html><head><title></title><link rel='stylesheet' href='../assets/font-awesome/4.5.0/css/font-awesome.min.css' /></head><body onload='window.print();'>" + toprint + "</body></html>");
			        popupWin.document.close();
				}
			}
		})
	}

	function exportTableToCSVTSR(filename){
		var csv = [];
	    var rows = document.querySelectorAll("#tblExportReportCSV tr");
	    for (var i = 0; i < rows.length; i++) {
	        var row = [], cols = rows[i].querySelectorAll("#tblExportReportCSV th, #tblExportReportCSV td");
	        for (var j = 0; j < cols.length; j++) 
	            row.push(cols[j].innerText);
	        csv.push(row.join(","));        
	    }
	    downloadCSVTSR(csv.join("\n"), filename);
	}

	function downloadCSVTSR(csv, filename) {
	    var csvFile;
	    var downloadLink;
	    csvFile = new Blob([csv], {type: "text/csv"});
	    downloadLink = document.createElement("a");
	    downloadLink.download = filename;
	    downloadLink.href = window.URL.createObjectURL(csvFile);
	    downloadLink.style.display = "block";
	    document.body.appendChild(downloadLink);
	    downloadLink.click();
	}
</script>