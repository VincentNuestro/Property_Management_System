<?php
	session_start();
    if(!isset($_SESSION['MMS-UserID'])){ 
    	header("Location:loginpage.php"); 
    }else{
        if(!file_exists("../ipaddress.txt")){
            file_put_contents("../ipaddress.txt", $_SESSION['GS-MMS']);
        }
    }

    include("connect.php");
    $checkaccess = mysql_fetch_array(mysql_query("SELECT DISTINCT module, moduletab FROM tblref_usergroupaccess WHERE groupid = '". $_SESSION['MMS-Access'] ."';", $connection));
    $checkifadmin = mysql_fetch_array(mysql_query("SELECT isadmin FROM tbluser WHERE userid = '". $_SESSION['MMS-UserID'] ."';", $connection));
    if($_SESSION['MMS-UserID'] == "GatessoftCorp" || $checkifadmin[0] == "1" || $_SESSION['MMS-UserID'] == "Superuser"){
    	$url = "dashboard";
    	$type = "";
    }else{
    	if($checkaccess[0] == ""){
    		$url = "AccessDenied";
    		$type = "";
    	}else if($checkaccess[0] == "dashboard"){
    		$url = "dashboard";
    		$type = "";
    	}else if($checkaccess[1] == "inquiry"){
    		$url = "inquiry";
    	}
    	// else if($checkaccess[0] == "leads"){
    	// 	$url = "leads";
    	// 	if($checkaccess[1] == "prospects"){
    	// 		$type = "prospects";
    	// 	}else if($checkaccess[1] == "awareness"){
    	// 		$type = "awareness";
    	// 	}else if($checkaccess[1] == "referral"){
    	// 		$type = "referral";
    	// 	}else if($checkaccess[1] == "inquiry"){
    	// 		$type = "inquiry";
    	// 	}else if($checkaccess[1] == "demo"){
    	// 		$type = "demo";
    	// 	}else if($checkaccess[1] == "proposal"){
    	// 		$type = "proposal";
    	// 	}else if($checkaccess[1] == "closingmeeting"){
    	// 		$type = "closingmeeting";
    	// 	}else if($checkaccess[1] == "contractsigning"){
    	// 		$type = "contractsigning";
    	// 	}else{
    	// 		$type = "";
    	// 	}
    	// }
    	else if($checkaccess[0] == "leasingapplication"){
			$url = "leasingapplication";
    		$type = "";
    	}else if($checkaccess[0] == "reservation"){
			$url = "reservation";
    		$type = "";
    	}else if($checkaccess[0] == "tenants"){
			$url = "tenants";
    		$type = "";
    	}else if($checkaccess[0] == "tenantportal"){
			$url = "tenantportal";
    		$type = "";
    	}else if($checkaccess[0] == "tenantrequest"){
			$url = "tenantrequest";
    		$type = "";
    	}else if($checkaccess[0] == "forapprovallist"){
			$url = "forapprovallist";
    		$type = "";
    	}else if($checkaccess[0] == "billing"){
			$url = "billing";
    		if($checkaccess[1] == "listofpenalty"){
    			$type = "listofpenalty";
    		}else if($checkaccess[1] == "listofpdc"){
    			$type = "listofpdc";
    		}
    	}else if($checkaccess[0] == "maintenance"){
			$url = "maintenance";
    		if($checkaccess[1] == "mcalendar"){
    			$type = "mcalendar";
    		}else if($checkaccess[1] == "mcomplaints"){
    			$type = "complaints";
    		}else if($checkaccess[1] == "maintenancebudget"){
    			$type = "budget";
    		}else if($checkaccess[1] == "asset"){
    			$type = "asset";
    		}
    	}else if($checkaccess[0] == "complaints"){
			$url = "complaints";
    		if($checkaccess[1] == "complaints"){
    			$type = "clist";
    		}else if($checkaccess[1] == "incidentreports"){
    			$type = "irlist";
    		}
    	}else if($checkaccess[0] == "reports"){
			$url = "reports";
    		if($checkaccess[1] == "tenantsalesreports"){
    			$type = "tsr";
    		}
    		// Added Ronaldo 2018-10-11
    		else if($checkaccess[1] == "leasingsalesreports"){
    			$type = "lrep";
    		}
    		// END Added Ronaldo 2018-10-11
    		else if($checkaccess[1] == "inquiryreports"){
    			$type = "ir";
    		}else if($checkaccess[1] == "applicationreports"){
    			$type = "ar";
    		}else if($checkaccess[1] == "unithistory"){
    			$type = "uh";
    		}else if($checkaccess[1] == "tenanthistory"){
    			$type = "th";
    		}else if($checkaccess[1] == "salesaudit"){
    			$type = "sa";
    		}else if($checkaccess[1] == "accreditation"){
    			$type = "accreditation";
    		}else if($checkaccess[1] == "audittrail"){
    			$type = "at";
    		}
    	}else if($checkaccess[0] == "filemonitoring"){
			$url = "filemonitoring";
    		$type = "";
    	}else if($checkaccess[0] == "baggagelogs"){
			$url = "baggagelogs";
    		$type = "";
    	}else if($checkaccess[0] == "visitorlogs"){
			$url = "visitorlogs";
    		$type = "";
    	}else if($checkaccess[0] == "systemsetup"){
			$url = "systemsetup";
    		if($checkaccess[1] == "referential"){
    			$type = "referential";
    		}else if($checkaccess[1] == "mallconfiguration"){
    			$type = "mallconfig";
    		}else if($checkaccess[1] == "termsandconditions"){
    			$type = "termsandconditions";
    		}else if($checkaccess[1] == "userandaccessibility"){
    			$type = "userandaccess";
    		}else if($checkaccess[1] == "companylist"){
    			$type = "companylist";
    		}else if($checkaccess[1] == "reporttemplates"){
    			$type = "reporttemplates";
    		}else if($checkaccess[1] == "maintenancechecklist"){
    			$type = "maintenancechecklist";
    		}else if($checkaccess[1] == "jdamapping"){
    			$type = "jdamapping";
    		}else if($checkaccess[1] == "reftenantspayment"){
    			$type = "reftenantspayment";
    		}
    	}else{
    		$url = "AccessDenied";
    		$type = "";
    	}
    }

    if(!isset($_SESSION['MMS-UserID'])){
		echo "<script>window.location = 'logout.php';</script>";
	}else{
		if(!isset($_REQUEST['url'])){
			if($type == ""){
				echo "<script>window.location = 'index.php?url=".$url."';</script>";
			}else{
				echo "<script>window.location = 'index.php?url=".$url."&type=".$type."';</script>";
			}
		}
	}
?>
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
		<!-- <link href="//fonts.googleapis.com/css?family=Roboto:100italic,100,300italic,300,400italic,400,500italic,500,700italic,700,900italic,900" rel="stylesheet" type="text/css"> -->

		<!-- text fonts -->
		<!-- <link rel="stylesheet" href="assets/css/fonts.googleapis.com.css" /> -->
		<!--<link rel="shortcut icon" type="images/x-icon" href="assets/images/ai1logo.png" />-->
		<!-- ace styles -->
		<link rel="stylesheet" href="assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />

		<link rel="stylesheet" href="assets/css/colorbox.min.css" />
		<link rel="stylesheet" href="assets/css/stylengtable.css" />
		<link rel="stylesheet" href="assets/css/ace-skins.min.css" />
		<link rel="stylesheet" href="assets/css/ace-rtl.min.css" />
		<link rel="stylesheet" href="assets/css/bootstrap-datepicker3.min.css" />
		<link rel="stylesheet" href="assets/css/bootstrap-timepicker.min.css" />
		<link rel="stylesheet" href="assets/css/daterangepicker.min.css" />
		<link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css" />
		<link rel="stylesheet" href="assets/css/bootstrap-colorpicker.min.css" />
		<link rel="stylesheet" href="assets/css/tablenav.css" />
		<!-- <link src="https://code.highcharts.com/css/highcharts.css"> -->
		<link rel="stylesheet" href="assets/css/bootstrap-colorpicker.min.css" />
		<link rel="stylesheet" href="assets/css/chosen.min.css" />
		<link rel="stylesheet" href="assets/css/select2.min.css" />

		<!-- ace settings handler -->
		<script src="assets/js/jquery-2.1.4.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/ace-extra.min.js"></script>
		<script src="assets/js/moment.min.js"></script>
		<script src="assets/js/daterangepicker.min.js"></script>
		<script src="assets/js/bootstrap-datetimepicker.min.js"></script>

		<script src="assets/js/jquery-ui.custom.min.js"></script>
		<script src="assets/js/jquery.easypiechart.min.js"></script>
		<script src="assets/js/jquery.sparkline.index.min.js"></script>
		<script src="assets/js/jquery.flot.min.js"></script>
		<script src="assets/js/jquery.flot.pie.min.js"></script>
		<script src="assets/js/jquery.flot.resize.min.js"></script>
		<script src="assets/js/jquery.nicescroll.min.js"></script>
		<script src="assets/js/bootstrap-tag.min.js"></script>
		<script src="assets/js/bootstrap-datepicker.min.js"></script>
		<script src="assets/js/bootstrap-timepicker.min.js"></script>
		<script src="assets/js/bootstrap-editable.min.js"></script>
		<script src="assets/js/ace-editable.min.js"></script>
		<script src="assets/js/jquery.maskedinput.min.js"></script>
		<script src="assets/js/bootstrap-colorpicker.min.js"></script>
		<script src="assets/js/chosen.jquery.min.js"></script>
		
		<!-- ace scripts -->
		<script src="assets/js/select2.min.js"></script>
		<script src="assets/js/ace-elements.min.js"></script>
		<script src="assets/js/ace.min.js"></script>
		<script src="assets/js/tree.min.js"></script>
		
		<script src="assets/js/highcharts.js" type="text/javascript"></script>
		<script src="assets/js/exporting.js" type="text/javascript"></script>
		<!-- <script src="assets/js/heatmap.js" type="text/javascript"></script> -->
		<script src="assets/js/treemap.js" type="text/javascript"></script>
		<!-- <script src="assets/js/grid-light.js" type="text/javascript"></script> -->
		<script src="assets/js/drilldown.js" type="text/javascript"></script>
		<script src="assets/js/tableHeadFixer.js"></script>
		<!-- <script src="assets/js/tablenav.js"></script> -->
		<script src="assets/js/jquery.colorbox.min.js"></script>
		<script src="assets/js/ckeditor/ckeditor.js"></script>
		
		<style>
		.modal-backdrop.in { 
			z-index: auto;
		}

		::-webkit-scrollbar-thumb {
		    -webkit-border-radius: 10px;
		    border-radius: 10px;
		    background: #cccccc;
		    -webkit-box-shadow: inset 0 0 6px #cccccc;
		}

		::-webkit-scrollbar-thumb:window-inactive {
		    background: #cccccc;
		}

		#mdlUserAccess .accordionmodaluser .aacordheader {
		    background: #438EB9 !important;
		    color: white !important;
		    font-weight: bold;
		} 

		.hoverx {
			cursor: pointer;
		}  


		@media only screen and (max-width: 900px) {
		    .hide_mobile{
		    	display: none;
			}
		}

		*{
			font-family: Arial;
			/*font-size: 13px;
			/*color: #333;*/
		}
		</style>
	</head>
	<body class="no-skin" id="sys_body">
		<div id="indexloadingscreen"></div>
		<div id="navbar" class="navbar navbar-default ace-save-state">
			<div class="navbar-container ace-save-state" id="navbar-container">
				<?php
				include("header/main_header.php");
				include("header/notification.php");
				include("setup/script.php");
				?>
			</div>
		</div>

		<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>

			<div id="sidebar" class="sidebar responsive ace-save-state">
				<script type="text/javascript">
					try{ace.settings.loadState('sidebar')}catch(e){}
				</script>
				<?php include("sidenav/sidenav_shortcuts.php"); ?>
				<?php include("sidenav/sidenav.php"); ?>
				<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
					<i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
				</div>
			</div>

			<div class="main-content">
				<div class="main-content-inner">
				<?php
				include("header/page_header.php");
				?>
					<div class="page-content" id="div_main_cont">
						<?php
							$softwaretype = mysql_fetch_array(mysql_query("SELECT softwaretype FROM tblsys_setup", $connection));
							if(!isset($_REQUEST['url'])){
								include "accessdenied.php";
							}else{
								if($_REQUEST['url'] == 'dashboard'){
									if($softwaretype[0] == 0){
										include "dashboard/index0.php";
									}else if($softwaretype[0] == 1){
										include "dashboard/index1.php";
									}else if($softwaretype[0] == 2){
										include "dashboard/index2.php";
									}else if($softwaretype[0] == 3){
										include "dashboard/index3.php";
									}else if($softwaretype[0] == 4){
										include "dashboard/index1.php";
									}else if($softwaretype[0] == 5){
										include "dashboard/index1.php";
									}else{
										include "dashboard/index0.php";
									}
								}else if($_REQUEST['url'] == 'inquiry'){
									include("inquiry/index.php");
								}
								// else if($_REQUEST['url'] == 'leads'){
								// 	include "leads/index.php";
								// }
								// else if($_REQUEST['url'] == 'inquiry'){
									// if($softwaretype[0] == 1){
									// 	include("leasingmodules/inquiry/index.php");
									// }else{
										// include("inquiry/inquiry.php");
									// }
								// }
								else if($_REQUEST['url'] == 'leasingapplication'){
									if($softwaretype[0] != 5){
										include "leasingapplication/index.php";
									}else{
										include "accessdenied.php";
									}
								}
								else if($_REQUEST['url'] == 'reservation'){
									// if($softwaretype[0] == 1){
									// 	include("leasingmodules/reservation/index.php");
									// }else{
										include("reservation/index.php");
									// }
								}else if($_REQUEST['url'] == 'tenants'){
									include "tenants/tenants.php";
								}else if($_REQUEST['url'] == 'tenantportal'){
									include "tenantportal/index.php";
								}else if($_REQUEST['url'] == 'tenantrequest'){
									include "tenants_request/index.php";
								}else if($_REQUEST['url'] == 'forapprovallist'){
									include "forapprovallist/index.php";
								}else if($_REQUEST['url'] == 'billing'){
									include "billing/index.php";
								}else if($_REQUEST['url'] == 'maintenance'){
									include "maintenance/index.php";
								}else if($_REQUEST['url'] == 'complaints'){
									include "complaints/index.php";
								}else if($_REQUEST['url'] == 'reports'){
									include "reports/index.php";
								}else if($_REQUEST['url'] == 'filemonitoring'){
									include "monitoring/monitoring.php";
								}else if($_REQUEST['url'] == 'accreditation'){
									include "accreditation/index.php";
								}else if($_REQUEST['url'] == 'baggagelogs'){
									include "itemsclaim/itemsclaiming.php";
								}else if($_REQUEST['url'] == 'visitorlogs'){
									include "visitorlogs/visitor.php";
								}else if($_REQUEST['url'] == 'floorplan'){
									include "floorplan/floorplan.php";
								}else if($_REQUEST['url'] == 'systemsetup'){
									include "setup/setup.php";
								}else if($_REQUEST['url'] == 'eventsmod'){
									include "events/index.php";
								}else{
									include "accessdenied.php";
								}
							}
						?>		
					</div>
				</div>
			</div>

			<div class="footer" style="padding-top: 100px !important;">
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
								<!--<img src="assets/images/ai1logo.png" height="35" width="30">-->
									Powered by 
									<a target="_blank" href="#" class="blue bolder">VinSoft Solution</a>
								</span>
							</div>
							<div class="col-md-2 col-xs-12"></div>
							<div class="col-md-2 col-xs-12">
								<table style="padding:0px;" class="pull-right">
									<tr style="padding:0px;"><td style="padding:0px;"><h6 class="smaller lighter black" style="text-align: right;display: inline-block;float: right;font-weight: bold;margin-bottom: 0px;">Ver 2.0.12.239.434</h6></td></tr>
									<tr style="padding:0px;"><td style="padding:0px;"><h6 class="smaller lighter black" style="text-align: left;display: inline-block;float: left;font-weight: bold;" id="txtServerIP"></h6></td></tr>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script type="text/javascript">
			// var idleTimer = null;
			// var idleState = false;
			// var idleWait = 1000000;
			// $(document).ready(function () {
			// 	$('*').bind('mousemove keydown scroll', function () {
			// 		clearTimeout(idleTimer);
			// 		if (idleState == true) {
			// 		// Reactivated event
			// 		window.location.replace('logout.php');
			// 		}
			// 		idleState = false;
			// 		idleTimer = setTimeout(function () {
			// 		// Idle Event
			// 		alert("You've been idle for " + idleWait/100000 + " mins. You were logged out!..");
			// 		idleState = true; }, idleWait);
			// 	});
			// 	$("body").trigger("mousemove");
			// });

		 	window.onbeforeunload = function(e) {
	      		// return e;
	    	};			

			window.onload=function(){
				// $("#sys_body").niceScroll({cursorcolor:"#999"});
				GetClock();
				fncCheckDate();
				setInterval(GetClock,1000);
				$.ajax({
					type: 'POST',
					url: 'mainclass.php',
					data: 'form=getsysdate',
					success: function(data){
						var arr = data.split("|");
						$("#sysdatetime").text(arr[0])
						$("#txtServerIP").text(arr[1]);
					}
				})
			}
			
			//LIVE DATE AND TIME
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
				loadnotifications();
				// checkConnection();
			}

			$(document).on('show.bs.modal', '.modal', function () {
			    var zIndex = 1040 + (10 * $('.modal:visible').length);
			    $(this).css('z-index', zIndex);
			    setTimeout(function() {
			        $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
			    }, 0);
			});

			var zIndex = Math.max.apply(null, Array.prototype.map.call(document.querySelectorAll('*'), function(el) {
			  return +el.style.zIndex;
			})) + 10;

			$(document).on('hidden.bs.modal', '.modal', function () {
			    $('.modal:visible').length && $(document.body).addClass('modal-open');
			});
		</script>

		<div class="modal fade fade-scale" id="mdl_EODReminder" role="dialog" area-hidden="true" data-keyboard="false" data-backdrop="static">
		    <div class="modal-dialog modal-sm" style="width: 50%;">   
		      	<div class="modal-content">
		      		<div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal">&times;</button>
		                <h4 class="modal-title" style="font-size: 18px;">End of Day Reminder</h4>
		            </div>
			        <div class="modal-body">
			           	<div class="row">
			           		<div class="col-md-12">
			           			<div class="well" style="height: 230px;">
			           				<div class="row form-group">
			           					<div class="col-md-12">
			           						<div class="alert alert-info">
						           				<h2 class="red center">System date is not same with the current date</h2>
						           			</div>
			           					</div>
			           				</div>
			           				<div class="row form-group">
			           					<div class="col-md-offset-2 col-md-2">
			           						<span class=" fa fa-clock-o fa-5x blue"></span>
			           					</div>
			           					<div class="col-md-6">
			           						<div class="row form-group">
			           							<div class="col-md-12">
					           						<div class="row form-group">
					           							<div class="col-md-12">
					           								<h4 id="txtchkSysDate"></h4>
					           							</div>
					           						</div>
			           							</div>
			           							<div class="col-md-12">
			           								<div class="row form-group">
					           							<div class="col-md-12">
			           										<h4 id="txtchkCurrDate"></h4>
					           							</div>
					           						</div>
			           							</div>
			           						</div>
			           					</div>
			           				</div>
			           			</div>
			           		</div>
			           	</div>
			        </div>
			        <div class="modal-footer">
	                   	<button class="btn btn-primary btn-sm btn-round" onclick="fncEOD();">Proceed EOD</button>
	                   	<button class="btn btn-danger btn-sm btn-round" data-dismiss="modal">Close</button>
                    </div>
		      	</div>
		    </div>
		</div>

		<div class="modal fade fade-scale" id="modal_login_eod" role="dialog" area-hidden="true" data-keyboard="false" data-backdrop="static">
		    <div class="modal-dialog modal-sm">   
		      	<div class="modal-content">
		      		<div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal" onclick="closemodalref2();">&times;</button>
		                <h4 class="modal-title" style="font-size: 18px;">Login</h4>
		            </div>
			        <div class="modal-body">
			            <div class="row form-group">
			                <div class="col-xs-12 col-md-3">
			                   Username
			                </div>
			                <div class="col-xs-12 col-md-9">
			                	<span class="block input-icon input-icon-right">
									<input type="text" class="form-control" id="txtlogin_username">
									<i class="ace-icon fa fa-user bigger-120" style="color: #286090;"></i>
								</span>
			                </div>
			            </div>
			            <div class="row form-group">
			                <div class="col-xs-12 col-md-3">
			                   Password
			                </div>
			                <div class="col-xs-12 col-md-9">
			                	<span class="block input-icon input-icon-right">
									<input type="password" class="form-control" id="txtlogin_password">
									<i class="ace-icon fa fa-lock bigger-120" style="color: #286090;"></i>
								</span>
			                </div>
			            </div>
			        </div>
			        <div class="modal-footer">
	                   <button class="btn btn-danger btn-sm btn-round" onclick="closemodalref2()">Cancel</button>
	                   <button class="btn btn-primary btn-sm btn-round" onclick="fncCheckUserAccess()">Login</button>
                    </div>
		      	</div>
		    </div>
		</div>

		<div class="modal fade fade-scale" id="mdlChecking" role="dialog" area-hidden="true" data-keyboard="false" data-backdrop="static">
		    <div class="modal-dialog modal-sm" style="width: 50%;">   
		      	<div class="modal-content">
		      		<div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal">&times;</button>
		                <h4 class="modal-title" style="font-size: 18px;">End of Day</h4>
		            </div>
			        <div class="modal-body">
			        	<div class="row">
			           		<div class="col-md-12">
			           			<div class="well">
			           				<div class="row form-group center">
			           					<div class="col-md-6">
					           				<h4 class="header green">Checking Arrival Tenant(s)</h4>
	           								<h6><span class="badge badge-success" id="chkEODTenantArrival"></span> record(s) found. Please occupy the arrival tenants first.</h6>
			           					</div>
			           					<div class="col-md-6">
					           				<h4 class="header green">Checking Expired Tenant(s)</h4>
	           								<h6><span class="badge badge-success" id="chkEODTenantExpired"></span> record(s) found. Confirm to proceed EOD process</h6>
			           					</div>
			           				</div>
			           				<!-- <div class="row form-group">
			           					<div class="col-md-5">
					           				<h5>Checking Arrival Tenant(s)</h5>
			           					</div>
			           					<div class="col-md-7">
			           						<div class="row form-group">
			           							<div class="col-md-12">
			           								<div class="progress pos-rel asdasdasd" data-percent="66%">
														<div class="progress-bar" style="width:66%;" id=""></div>
													</div>
			           							</div>
			           							<label class="col-md-12">
			           								<h6>4 record(s) found. Please occupy the arrival tenants first.</h6>
			           							</label>
			           						</div>
			           					</div>
			           					<div class="col-md-5">
					           				<h5>Checking Expired Tenant(s)</h5>
			           					</div>
			           					<div class="col-md-7">
			           						<div class="row form-group">
			           							<div class="col-md-12">
			           								<div class="progress pos-rel" data-percent="66%">
														<div class="progress-bar" style="width:66%;"></div>
													</div>
			           							</div>
			           							<label class="col-md-12">
			           								<h6>4 record(s) found. Please occupy the arrival tenants first.</h6>
			           							</label>
			           						</div>
			           					</div>
			           					<div class="col-md-5 hide">
					           				<h5>Updating Availability and Occupancy</h5>
			           					</div>
			           					<div class="col-md-7 hide">
			           						<div class="row form-group">
			           							<div class="col-md-12">
			           								<div class="progress pos-rel" data-percent="66%">
														<div class="progress-bar" style="width:66%;"></div>
													</div>
			           							</div>
			           						</div>
			           					</div>
			           					<div class="col-md-5 hide">
					           				<h5>Updating System Date</h5>
			           					</div>
			           					<div class="col-md-7 hide">
			           						<div class="row form-group">
			           							<div class="col-md-12">
			           								<div class="progress pos-rel" data-percent="66%">
														<div class="progress-bar" style="width:66%;"></div>
													</div>
			           							</div>
			           						</div>
			           					</div>
			           				</div> -->
			           			</div>
			           		</div>
			           	</div>
			        </div>
			        <div class="modal-footer">
	                   	<button class="btn btn-primary btn-sm btn-round" onclick="fncProceedEOD();">Proceed EOD</button>
	                   	<button class="btn btn-danger btn-sm btn-round" data-dismiss="modal">Close</button>
                    </div>
		      	</div>
		    </div>
		</div>

		<div class="modal fade fade-scale" id="mdl_EODFinal" role="dialog" area-hidden="true" data-keyboard="false" data-backdrop="static">
		    <div class="modal-dialog modal-sm">   
		      	<div class="modal-content">
			        <div class="modal-body">
			            <div class="row form-group" style="margin-bottom: 5px;">
			                <div class="col-xs-12 col-md-5" style="text-align: right;">
			                	System Date:
			                </div>
			                <div class="col-xs-12 col-md-7" style="text-align: left;">
			                    <label id="txtcurrdate" style="font-weight: bold;"></label>
			                </div>
			            </div>
			            <div class="row form-group" style="margin-bottom: 5px;">
			                <div class="col-xs-12 col-md-5" style="text-align: right;">
			                	Computer Date:
			                </div>
			                <div class="col-xs-12 col-md-7" style="text-align: left;">
			                    <label id="txtcompdate"></label>
			                </div>
			            </div>
						<div class="row form-group">
			                <div class="col-xs-12 col-md-5" style="text-align: right;">
			                	Processed by:
			                </div>
			                <div class="col-xs-12 col-md-7" style="text-align: left;">
			                    <label id="txtprocessdby"></label>
			                </div>
			            </div>
			        </div>
		      	</div>
		    </div>
		</div>

		<div class="modal fade fade-scale" id="loadingSync" data-backdrop="static" style="margin-top: 10% !important;">
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

		<div id="printable_div" style="display: none;">
		    <style type="text/css">
		        #printable_div_content table thead tr th{
		            background: grey !important;
		            color: white !important;
		        }
		    </style>
		    <div id="printable_div_header">
		        <table style="width: 100%;" cellspacing="0" cellpadding="0">
		            <tbody id="printable_divtemplate"></tbody>
		        </table>
		    </div>
		    <div id="printable_div_content">
		        <table style="width: 100%">
		            <thead>
		                <tr>
		                    <th>asdasd</th>
		                    <th>asdasd</th>
		                </tr>
		            </thead>
		            <tbody></tbody>
		        </table>
		    </div>
		</div>

		<script type="text/javascript">
			$(function(){
				$("#txtlogin_username").keyup(function(e){
					var x = event.keyCode;
					if(x == 13){ 
						fncCheckUserAccess(); 
					}
				});

				$("#txtlogin_password").keyup(function(e){
					var x = event.keyCode;
					if(x == 13){ 
						fncCheckUserAccess(); 
					}
				});
			})

			$(document).keydown(function(e) {
                var code = (e.keyCode ? e.keyCode : e.which);
                if(code == 49 && e.altKey){
                    // $(".modal").modal("hide");
                    // fncEOD();
                    // fncEODChecking("continue", "Jonas")

						// $("#mdlChecking").modal("show");
					 //    var xhr = new XMLHttpRequest();
					 //    xhr.open('POST', 'endofday.php', true);
					 //    xhr.upload.onprogress = function(e) {
					 //    	alert()
	     //    				if (e.lengthComputable) {
					 //            var percentComplete = (e.loaded / e.total) * 100;
					 //            $("#asdasdasd").css("width", percentComplete+"%");
				  //           	$(".asdasdasd").attr("data-percent", percentComplete+"%");
	     //   	 				}
					 //    };
					 //    xhr.onload = function() {
	    	// 				alert(xhr.responseText)
					 //    };
					 //    xhr.onreadystatechange = function() {
					 //  		$("#asdasdasd").css("width", "100%");
			   //          	$(".asdasdasd").attr("data-percent", "100%");
					 //  	};
                }
            });

   //          $(document).keydown(function(e) {
   //              var code = (e.keyCode ? e.keyCode : e.which);
   //              if(code == 50 && e.altKey){
   //                  $(".modal").modal("hide");
   //                  showoption();
   //              }
   //          });

   //          $(document).keydown(function(e) {
   //              var code = (e.keyCode ? e.keyCode : e.which);
   //              if(code == 51 && e.altKey){
   //                  $(".modal").modal("hide");
   //                  ShowSchedOption();
   //              }
   //          });

   //          $(document).keydown(function(e) {
   //              var code = (e.keyCode ? e.keyCode : e.which);
   //              if(code == 52 && e.altKey){
   //                  $(".modal").modal("hide");
   //                  viewmemotab();
   //              }
   //          });

   			function fncCheckDate(){
				$.ajax({
					type: 'POST',
					url: 'mainclass.php',
					data: 'form=checkeod',
					success:function(data){
						var arr = data.split("|");
						if(arr[0] == 1){
							$("#txtchkSysDate").text(arr[1]);
							$("#txtchkCurrDate").text(arr[2]);
							$("#mdl_EODReminder").modal("show");
						}else{
							$("#txtchkSysDate").text("");
							$("#txtchkCurrDate").text("");
							$("#mdl_EODReminder").modal("hide");
						}
					}
				})	
			}

   			function fncEODChecking(){
				$.ajax({
					type: 'POST',
					url: 'mainclass.php',
					data: 'form=fncEODChecking',
					beforeSend:function(){
	        			$('#indexloadingscreen').addClass('myspinner');
					},
					success: function(data){
	         			$('#indexloadingscreen').removeClass('myspinner');
						var arr = data.split("|");
						$("#mdlChecking").modal("show");
						$("#chkEODTenantArrival").text(arr[0]);
						$("#chkEODTenantExpired").text(arr[1]);
					}
				})
		  	}

			function fncEOD(){
			    $("#modal_login_eod").modal("show");
			    $("#txtlogin_username").css("border-color", "#D5D5D5");
				$("#txtlogin_password").css("border-color", "#D5D5D5");
				$("#txtlogin_username").val("");
				$("#txtlogin_password").val("");
			}

			function closemodalref2(){
		  		$("#modal_login_eod").modal("hide");
		  		fncCheckDate();
		  	}

		  	function fncCheckUserAccess(){
		  		var username = $("#txtlogin_username").val();
		  		var password = $("#txtlogin_password").val();
		  		if(username != "" && password != ""){
			  		$.ajax({
			  			type: 'POST',
			  			url: 'mainclass.php',
			  			data: '&username=' + username + '&password=' + password + '&form=fncCheckUserAccess',
			  			success: function(data){
			  				var arr = data.split("|");
			  				if(arr[0] == 1){
			  					$("#txtlogin_username").css("border-color", "#D5D5D5");
								$("#txtlogin_password").css("border-color", "#D5D5D5");
								$("#txtlogin_username").val("");
								$("#txtlogin_password").val("");
						  		$("#modal_login_eod").modal("hide");
			  					fncEODChecking();
			  				}else{
			  					setTimeout(function(){
									showmodal("alert", arr[1], "", null, "", null, "1");
								}, 500)
			  				}
			  			}
			  		})  			
		  		}else{
		  			if(username == "" && password == ""){
		  				$("#txtlogin_username").css("border-color", "#f2a696");
						$("#txtlogin_password").css("border-color", "#f2a696");
						setTimeout(function(){
							showmodal("alert", "Please enter username and password.", "focusto(\"txtlogin_username\")", null, "", null, "1");
						}, 500)
		  			}else if(username == "" && password != ""){
		  				$("#txtlogin_username").css("border-color", "#f2a696");
		  				$("#txtlogin_password").css("border-color", "#D5D5D5");
		  				$("#txtlogin_username").focus();
		  				setTimeout(function(){
		  					showmodal("alert", "Please enter username.", "focusto(\"txtlogin_username\")", null, "", null, "1");
						}, 500)
		  			}else if(username != "" && password == ""){
		  				$("#txtlogin_password").css("border-color", "#f2a696");
		  				$("#txtlogin_username").css("border-color", "#D5D5D5");
		  				$("#txtlogin_password").focus();
		  				setTimeout(function(){
		  					showmodal("alert", "Please enter password.", "focusto(\"txtlogin_password\")", null, "", null, "1");
						}, 500)
		  			}
		  		}
		  	}

		  	function fncProceedEOD(){
		  		$.ajax({
		  			type: 'POST',
		  			url: 'mainclass.php',
		  			data: 'form=proceed_endofday',
		  			beforeSend: function(){
                    	$(".modal").modal("hide");
                	},
		  			success: function(data){
		  				var arr = data.split("|");
	  					$("#txtcurrdate").text(arr[0]);
						$("#txtcompdate").text(arr[1]);
						$("#txtprocessdby").text(arr[2]);
						$("#mdl_EODFinal").modal("show");
		  			},complete:function(){
						setTimeout(function(){
							window.location = "logout.php";
						}, 5000)
					}
		  		})
		  	}

		  	function focusto(id){
		  		$("#alertmodal").modal("hide");
		  		$("#"+id).focus();
		  	}

			function autoSyncCSV(){
				$.ajax({
					type: 'POST',
					url: 'monitoring/class.php',
					data: 'form=autoSyncCSV',
					success:function(data){
						var arr = data.split("|");
						var SyncType = arr[1]; // Auto or Manual
						var DateFrom = arr[2];
						var DateTo = arr[3];
						var PathSetup = arr[4]; //Local or SFTP
						if(arr[0] == 1){
							if(PathSetup == ""){
								
							}else{
								if(PathSetup == "SFTP"){
									if(SyncType == "1"){
										$.ajax({
											type: 'POST',
											url: 'monitoring/syncclassSFTP.php',
											data: 'dateFrom=' + DateFrom + '&dateTo=' + DateTo + '&form=importcsvdaterange',
											beforeSend: function() {
												$("#loadingSync").modal("show");
											},
											success:function(data){
												$("#loadingSync").modal("hide");
												$.ajax({
													type: 'POST',
													url: 'monitoring/syncclassSFTP.php',
													data: 'form=deletethis',
													success:function(data){
														
													}
												})
												if(data == ""){
													
												}else{
													setTimeout(function(){
														showmodal("alert", "Files Successfully Synced.", "", null, "", null, "0");
													}, 500)
												}
											}
										})
									}else if(SyncType == "2"){
										alert("3")
										// $.ajax ({
										// 	type: 'POST',
										// 	url: 'monitoring/syncclassSFTP.php',
										// 	data: 'form=importcsvtoday',
										// 	beforeSend: function() {
										// 		$("#loadingSync").modal("show");
										// 	},
										// 	success: function(data) {
										// 		$("#loadingSync").modal("hide");
										// 		$.ajax({
										// 			type: 'POST',
										// 			url: 'monitoring/syncclassSFTP.php',
										// 			data: 'form=deletethis',
										// 			success:function(data){
														
										// 			}
										// 		})
										// 		if(data == "2"){
													
										// 		}else{
										// 			setTimeout(function(){
										// 				showmodal("alert", "Files Successfully Synced.", "", null, "", null, "0");
										// 			}, 500)
										// 		}
										// 	}
										// })
									}
								}else if(PathSetup == "Local"){
									if(SyncType == "1"){
										$.ajax ({
											type: 'POST',
											url: 'monitoring/syncclassLocal.php',
											data: 'dateFrom=' + DateFrom + '&dateTo=' + DateTo + '&form=importcsvdaterange',
											beforeSend: function() {
												$("#loadingSync").modal("show");
											},
											success: function(data) {
												$("#loadingSync").modal("hide");
												if(data == ""){
													
												}else{
													setTimeout(function(){
														showmodal("alert", "Files Successfully Synced.", "", null, "", null, "0");
													}, 500)
												}
											}
										})
									}else if(SyncType == "2"){
										$.ajax ({
											type: 'POST',
											url: 'monitoring/syncclassLocal.php',
											data: 'form=importcsvtoday',
											beforeSend: function() {
												$("#loadingSync").modal("show");
											},
											success: function(data) {
												$("#loadingSync").modal("hide");
												if(data == "2"){
													
												}else{
													setTimeout(function(){
														showmodal("alert", "Files Successfully Synced.", "", null, "", null, "0");
													}, 500)
												}
											}
										})
									}
								}
							}
						}
					}
				})
			}

			function checkConnection(){
				$.ajax({
					type: 'POST',
					url: 'mainclass.php',
					data: 'form=checkConnection',
					success: function(data){
						if(data != ""){
							$("#loadingSync").modal("hide");
						}
					}
				})
			}

			function isNumberKey(evt){
				evt = (evt) ? evt : window.event;
				var charCode = (evt.which) ? evt.which : evt.keyCode;
				if (charCode > 31 && (charCode < 48 || charCode > 57)) {
					if (charCode == 45 || charCode == 46) { return true; }
					else { return false; }
				}
				return true;
			}
		</script>

		<?php include("alert_modal/modal.php"); ?>
		<?php include("header/modal_notification.php"); ?>
		<?php include("scheduler/index.php"); ?>
	</body>
</html>
