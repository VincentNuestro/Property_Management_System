<script>
	$(function(){
		groupaccess();
		changesyslabel();
	});

	setTimeout(function(){
		changesyslabel();
	}, 3000)

	setInterval(function(){
		var modulex = "<?php if(isset($_GET['url'])){ echo $_GET['url']; } ?>";
		$.ajax ({
			type: 'POST',
			url: 'sidenav/class.php',
			data: 'form=groupaccess',
			success: function(data) {
				if(data == 1){
					$(".isadmin").removeClass("hide");
				}else{
					var arr = data.split("#");
					for(var a = 1; a <= arr.length-1; a++){
						var arr2 = arr[a].split("|");
						$(".select-"+arr2[0]).removeClass("hide");
						if((modulex=='leasingapplication' || modulex=='reservation' || modulex=='inquiry' || modulex=='forapprovallist')){
						  	if(arr2[0]==modulex){
						  		
						  		$(".select-"+arr2[1]).removeClass("hide");
						  	}
						}else{
							$(".select-"+arr2[1]).removeClass("hide");
						}	
						$(".select-"+arr2[2]).removeClass("hide");
					}
				}
			}
		})
		groupaccess();
		changesyslabel();
	}, 1000);
	
	
	function groupaccess(){
		var modulex = "<?php if(isset($_GET['url'])){ echo $_GET['url']; } ?>";
		$.ajax ({
			type: 'POST',
			url: 'sidenav/class.php',
			data: 'form=groupaccess',
			success: function(data){
				if(data == 1){
					$(".isadmin").removeClass("hide");
				}else{
					var arr = data.split("#");
					for(var a = 1; a <= arr.length-1; a++){
						var arr2 = arr[a].split("|");
						$(".select-" + arr2[0]).removeClass("hide");
						if((modulex == 'leasingapplication' || modulex == 'reservation' || modulex == 'inquiry' || modulex == 'forapprovallist')){
						  	if(arr2[0] == modulex){
						  		$(".select-" + arr2[1]).removeClass("hide");
						  	}
						}else{
							$(".select-" + arr2[1]).removeClass("hide");
						}	
						$(".select-" + arr2[2]).removeClass("hide");
					}
				}
			}
		})
	}

	function changesyslabel(){
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'form=changesyslabel',
			success: function(data){
				if(data == "0"){ // Mall Management System
					$(".txtSysBuilding").text("Mall");
					$(".txtSysBuildingPlaceholder").attr("placeholder", "Mall");
					$(".thSysTenant").text("Store Name");
					$(".thSysTenant2").html("Store Name <span class='red'>*</span>");					
					$(".btnSysTenant").text("New Store Profile");
					$(".hdrSysTenant").text("Store Profile List");
					$(".txtSysUnitInclusion").text("Facilities");
					$(".hdrSysUnitInclusion").text("Select Facilities");
					$(".HideForBuilding").addClass("hide");
					$(".RemoveRequiredForBuilding").removeClass("NDTRequired");
					$(".txtPanelHeader").text("Tenant Information");
				}else if(data == "1"){ // Property Managemenet System
					$(".txtSysBuilding").text("Property");
					$(".txtSysBuildingPlaceholder").attr("placeholder", "Property");
					$(".thSysTenant").text("Tenant Name");
					$(".thSysTenant2").html("Tenant Name <span class='red'>*</span>");					
					$(".btnSysTenant").text("New Tenant Profile");
					$(".hdrSysTenant").text("Tenant Profile List");
					$(".txtSysUnitInclusion").text("Amenities");
					$(".hdrSysUnitInclusion").text("Select Amenities");
					$(".HideForBuilding").addClass("hide");
					$(".RemoveRequiredForBuilding").removeClass("NDTRequired");
					$(".txtPanelHeader").text("Tenant Information");
				}else if(data == "2"){ // Building Management System
					$(".txtSysBuilding").text("Building");
					$(".txtSysBuildingPlaceholder").attr("placeholder", "Building");
					$(".thSysTenant").text("Tenant Name");
					$(".thSysTenant2").html("Tenant Name <span class='red'>*</span>");					
					$(".btnSysTenant").text("New Tenant Profile");
					$(".hdrSysTenant").text("Tenant Profile List");
					$(".txtSysUnitInclusion").text("Amenities");
					$(".hdrSysUnitInclusion").text("Select Amenities");
					$(".HideForBuilding").addClass("hide");
					$(".RemoveRequiredForBuilding").removeClass("NDTRequired");
					$(".txtPanelHeader").text("Tenant Information");
				}else if(data == "3"){ // Palengke Management System
					$(".txtSysBuilding").text("Palengke");
					$(".thSysTenant").text("Tenant Name");
					$(".thSysTenant2").html("Tenant Name <span class='red'>*</span>");					
					$(".txtSysBuildingPlaceholder").attr("placeholder", "Tenant Name");
					$(".btnSysTenant").text("New Tenant Profile");
					$(".hdrSysTenant").text("Tenant Profile List");
					$(".txtSysUnitInclusion").text("Facilities");
					$(".txtPanelHeader").text("Tenant Information");
				}else if(data == "4"){ // Memorial Management System
					$(".txtSysBuilding").text("Cemetery");
					$(".thSysTenant").text("Tenant Name");
					$(".thSysTenant2").html("Tenant Name <span class='red'>*</span>");					
					$(".txtSysBuildingPlaceholder").attr("placeholder", "Tenant Name");
					$(".btnSysTenant").text("New Tenant Profile");
					$(".hdrSysTenant").text("Tenant Profile List");
					$(".txtSysUnitInclusion").text("Amenities");
					$(".hdrSysUnitInclusion").text("Select Amenities");
					$(".txtPanelHeader").text("Tenant Information");
				}else if(data == "5"){ // Property Amortization & Sales System
					$(".txtSysBuilding").text("Property");
					$(".txtSysBuildingPlaceholder").attr("placeholder", "Property");
					$(".thSysTenant").text("Buyer Name");
					$(".thSysTenant2").html("Buyer Name <span class='red'>*</span>");					
					$(".btnSysTenant").text("New Buyer Profile");
					$(".hdrSysTenant").text("Buyer Profile List");
					$(".txtSysUnitInclusion").text("Amenities");
					$(".hdrSysUnitInclusion").text("Select Amenities");
					$(".HideForBuilding").addClass("hide");
					$(".RemoveRequiredForBuilding").removeClass("NDTRequired");
					$(".txtPanelHeader").text("Buyer Information");
				}else{ // Mall Management System
					$(".txtSysBuilding").text("Mall");
					$(".txtSysBuildingPlaceholder").attr("placeholder", "Mall");
					$(".thSysTenant").text("Store Name");
					$(".thSysTenant2").html("Store Name <span class='red'>*</span>");					
					$(".btnSysTenant").text("New Store Profile");
					$(".hdrSysTenant").text("Store Profile List");
					$(".txtSysUnitInclusion").text("Facilities");
					$(".hdrSysUnitInclusion").text("Select Facilities");
					$(".HideForBuilding").addClass("hide");
					$(".RemoveRequiredForBuilding").removeClass("NDTRequired");
					$(".txtPanelHeader").text("Tenant Information");
				}
			}
		})
	}
	
	function checkaccessfirst(module){
	    $.ajax({
		    type: 'POST',
		    url: 'mainclass.php',
		    data: 'module=' + module + '&form=checkaccessfirst',
		    success:function(data){
		        if(data == "viewunitcalendar"){
		          	selectnav(7);
		        }else if(data == "viewlcatenant"){
		          	selectnav(13);
		        }else if(data == "viewsettenant"){
		          	selectnav(14);
		        }else if(data == "1"){
		        	if(module == "tcalendar"){
		          		selectnav(7);
			        }else if(module == "fplca"){
			          	selectnav(13);
			        }else if(module == "fpset"){
			          	selectnav(14);
			        }
		        }else{
		          	showmodal("alert", "You are not allowed to access this feature.", "", null, "", null, "1");
		        }
		    }
	    })
 	}
</script>

<ul class="nav nav-list mynav">
	<li class="select-dashboard hide isadmin <?php if ( $_GET['url'] == 'dashboard' ) { ?> active <?php } ?>">
		<a href="index.php?url=dashboard">
			<i class="menu-icon fa fa-dashboard"></i>
			<span class="menu-text">Dashboard</span>
		</a>
		<b class="arrow"></b>
	</li>

	<!-- <li onclick="addclickclass($(this));">
		<a href="javascript:void(0)" onclick="selectnav(28)">
			<i class="menu-icon fa fa-map-o"></i>
			<span class="menu-text"> Mall Directory</span>
		</a>
		<b class="arrow"></b>
	</li> -->
	
	<!-- <li class="select-leads hide isadmin<?php if ( $_GET['url'] == 'leads' ) { ?> active <?php } ?>">
		<a href="index.php?url=leads" class="dropdown-toggle">
			<i class="menu-icon fa fa-archive"></i>
			<span class="menu-text">Leads</span>
			<b class="arrow fa fa-angle-down"></b>
		</a>
		<b class="arrow"></b>
		<ul class="submenu">
			<li class="select-prospects hide isadmin <?php if ( $_GET['type'] == 'prospects' ) { ?> active <?php } ?>">
				<a href="index.php?url=leads&type=prospects">
					<i class="menu-icon fa fa-caret-right"></i>
					<span class="menu-text">Prospects</span>
				</a>
				<b class="arrow"></b>
			</li>
			<li class="select-awareness hide isadmin <?php if ( $_GET['type'] == 'awareness' ) { ?> active <?php } ?>">
				<a href="index.php?url=leads&type=awareness">
					<i class="menu-icon fa fa-caret-right"></i>
					<span class="menu-text">Awareness</span>
				</a>
				<b class="arrow"></b>
			</li>
			<li class="select-referral hide isadmin <?php if ( $_GET['type'] == 'referral' ) { ?> active <?php } ?>">
				<a href="index.php?url=leads&type=referral">
					<i class="menu-icon fa fa-caret-right"></i>
					<span class="menu-text">Referral</span>
				</a>
				<b class="arrow"></b>
			</li>
			<li class="select-demo hide isadmin <?php if ( $_GET['type'] == 'demo' ) { ?> active <?php } ?>">
				<a href="index.php?url=leads&type=demo">
					<i class="menu-icon fa fa-caret-right"></i>
					<span class="menu-text">Demo</span>
				</a>
				<b class="arrow"></b>
			</li>
			<li class="select-closingmeeting hide isadmin <?php if ( $_GET['type'] == 'closingmeeting' ) { ?> active <?php } ?>">
				<a href="index.php?url=leads&type=closingmeeting">
					<i class="menu-icon fa fa-caret-right"></i>
					<span class="menu-text">Closing Meeting</span>
				</a>
				<b class="arrow"></b>
			</li>
			<li class="select-contractsigning hide isadmin <?php if ( $_GET['type'] == 'contractsigning' ) { ?> active <?php } ?>">
				<a href="index.php?url=leads&type=contractsigning">
					<i class="menu-icon fa fa-caret-right"></i>
					<span class="menu-text">Contract Signing</span>
				</a>
				<b class="arrow"></b>
			</li>
			<li class="select-inquiry hide isadmin <?php if ( $_GET['type'] == 'inquiry' ) { ?> active <?php } ?>">
				<a href="index.php?url=leads&type=inquiry">
					<i class="menu-icon fa fa-caret-right"></i>
					<span class="menu-text">Inquiry</span>
				</a>
				<b class="arrow"></b>
			</li>
			<li class="select-proposal hide isadmin <?php if ( $_GET['type'] == 'proposal' ) { ?> active <?php } ?>">
				<a href="index.php?url=leads&type=proposal">
					<i class="menu-icon fa fa-caret-right"></i>
					<span class="menu-text">Proposal</span>
				</a>
				<b class="arrow"></b>
			</li>
		</ul>
	</li> -->

	<li class="select-inquiry hide isadmin <?php if ( $_GET['url'] == 'inquiry' ) { ?> active <?php } ?>">
		<a href="index.php?url=inquiry">
			<i class="menu-icon fa fa-phone"></i>
			<span class="menu-text">Inquiry</span>
		</a>
		<b class="arrow"></b>
	</li>
	<?php if(SysLeaseSetup('softwaretype') != "5"){ ?> 
	<li class="select-leasingapplication hide isadmin <?php if ( $_GET['url'] == 'leasingapplication' ) { ?> active <?php } ?>">
		<a href="index.php?url=leasingapplication">
			<i class="menu-icon fa fa-folder-open"></i>
			<span class="menu-text">Leasing Application</span>
		</a>
		<b class="arrow"></b>
	</li>
  	<?php } ?>
	<li class="select-reservation hide isadmin <?php if ( $_GET['url'] == 'reservation' ) { ?> active <?php } ?>">
		<a href="index.php?url=reservation">
			<i class="menu-icon fa fa-clipboard"></i>
			<span class="menu-text">
				Reservation
				<span id="span_id_notif" class="badge badge-transparent tooltip-warning" title="">
					<i class='ace-icon fa fa-bell-o orange bigger-130'></i>
				</span>
			</span>
		</a>
		<b class="arrow"></b>
	</li>

	<li class="select-tenants hide isadmin <?php if ( $_GET['url'] == 'tenants' ) { ?> active <?php } ?>">
		<a href="index.php?url=tenants">
			<i class="menu-icon fa fa-users"></i>
			<span class="menu-text"> <?php if(SysLeaseSetup('softwaretype') == '5'){ echo "Buyer"; }else{ echo "Tenants"; } ?> </span>
		</a>

		<b class="arrow"></b>
	</li>

	<?php if(SysLeaseSetup('softwaretype') != '5'){ ?>
	<li class="select-tenantportal hide isadmin <?php if ( $_GET['url'] == 'tenantportal' ) { ?> active <?php } ?>">
		<a href="index.php?url=tenantportal">
			<i class="menu-icon fa fa-globe"></i>
			<span class="menu-text">Tenant Portal</span>
		</a>

		<b class="arrow"></b>
	</li>
	<?php } ?>

	<li class="select-tenantrequest hide isadmin <?php if ( $_GET['url'] == 'tenantrequest' ) { ?> active <?php } ?>">
		<a href="index.php?url=tenantrequest" class="dropdown-toggle">
			<i class="menu-icon fa fa-envelope"></i>
			<span class="menu-text"><?php if(SysLeaseSetup('softwaretype') == '5'){ echo "Buyer"; }else{ echo "Tenant"; } ?>'s Request</span>
			<b class="arrow fa fa-angle-down"></b>
		</a>
		<b class="arrow"></b>
		<ul class="submenu">
			<li class="select-billinglist hide isadmin <?php if ( $_GET['url'] == 'tenantrequest' && $_GET['type'] == 'trrequest') { ?> active <?php } ?>">
				<a href="index.php?url=tenantrequest&type=trrequest">
					<i class="menu-icon fa fa-caret-right"></i>
					<span class="menu-text">My Request</span>
				</a>
				<b class="arrow"></b>
			</li>
			<li class="select-listofpenalty hide isadmin <?php if ( $_GET['url'] == 'tenantrequest' && $_GET['type'] == 'trapproval') { ?> active <?php } ?>">
				<a href="index.php?url=tenantrequest&type=trapproval">
					<i class="menu-icon fa fa-caret-right"></i>
					<span class="menu-text">For Approval</span>
				</a>
				<b class="arrow"></b>
			</li>
		</ul>
	</li>

	<li class="select-forapprovallist hide isadmin <?php if ( $_GET['url'] == 'forapprovallist' ) { ?> active <?php } ?>">
		<a href="index.php?url=forapprovallist" class="dropdown-toggle">
			<i class="menu-icon fa fa-thumbs-up"></i></i>
			<span class="menu-text">For Approval</span>
			<b class="arrow fa fa-angle-down"></b>
		</a>
		<b class="arrow"></b>
		<ul class="submenu">
			<li class="select-viewproposallist hide isadmin <?php if ( $_GET['url'] == 'forapprovallist' && $_GET['type'] == 'proposalapprovallist') { ?> active <?php } ?>">
				<a href="index.php?url=forapprovallist&type=proposalapprovallist">
					<i class="menu-icon fa fa-caret-right"></i>
					<span class="menu-text">Proposals</span>
				</a>
				<b class="arrow"></b>
			</li>
			<li class="select-viewawardinglist hide isadmin <?php if ( $_GET['url'] == 'forapprovallist' && $_GET['type'] == 'awardnoticelist') { ?> active <?php } ?>">
				<a href="index.php?url=forapprovallist&type=awardnoticelist">
					<i class="menu-icon fa fa-caret-right"></i>
					<span class="menu-text">For Awarding</span>
				</a>
				<b class="arrow"></b>
			</li>
			<li class="select-viewcontractlist hide isadmin <?php if ( $_GET['url'] == 'forapprovallist' && $_GET['type'] == 'contractslist') { ?> active <?php } ?>">
				<a href="index.php?url=forapprovallist&type=contractslist">
					<i class="menu-icon fa fa-caret-right"></i>
					<span class="menu-text">Contracts</span>
				</a>
				<b class="arrow"></b>
			</li>
		</ul>
	</li>

	<li class="select-eventsmod hide  isadmin <?php if ( $_GET['url'] == 'eventsmod' ) { ?> active <?php } ?>">
		<a class="dropdown-toggle" href="#">
			<i class="menu-icon fa fa-gift"></i>
			<span class="menu-text"> Events </span>
			<b class="arrow fa fa-angle-down"></b>
		</a>
		<b class="arrow"></b>
		<ul class="submenu">
			<li class="select-vieweventscalendar hide isadmin <?php if ( $_GET['url'] == 'eventsmod' && $_GET['type'] == 'vieweventscalendar') { ?> active <?php } ?>">
				<a href="index.php?url=eventsmod&type=vieweventscalendar">Calendar</a>
			</li>
			<li class="select-vieweventslist hide isadmin <?php if ( $_GET['url'] == 'eventsmod' && $_GET['type'] == 'vieweventslist') { ?> active <?php } ?>">
				<a href="index.php?url=eventsmod&type=vieweventslist">List of Events</a>
			</li>
		</ul>
	</li>

	<li class="select-billing hide isadmin <?php if ( $_GET['url'] == 'billing' ) { ?> active <?php } ?>">
		<a href="index.php?url=billing" class="dropdown-toggle">
			<i class="menu-icon fa fa-usd"></i>
			<span class="menu-text">Billing</span>
			<b class="arrow fa fa-angle-down"></b>
		</a>
		<b class="arrow"></b>
		<ul class="submenu">
			<li class="select-billinglist hide isadmin <?php if ( $_GET['url'] == 'billing' && $_GET['type'] == '') { ?> active <?php } ?>">
				<a href="index.php?url=billing">
					<i class="menu-icon fa fa-caret-right"></i>
					<span class="menu-text">Billing List</span>
				</a>
				<b class="arrow"></b>
			</li>
			<li class="select-listofpenalty hide isadmin <?php if ( $_GET['type'] == 'listofpenalty' ) { ?> active <?php } ?>">
				<a href="index.php?url=billing&type=listofpenalty">
					<i class="menu-icon fa fa-caret-right"></i>
					<span class="menu-text">Penalty</span>
				</a>
				<b class="arrow"></b>
			</li>
			<li class="select-listofpdc hide isadmin <?php if ( $_GET['type'] == 'listofpdc' ) { ?> active <?php } ?>">
				<a href="index.php?url=billing&type=listofpdc">
					<i class="menu-icon fa fa-caret-right"></i>
					<span class="menu-text">List of PDC</span>
				</a>
				<b class="arrow"></b>
			</li>
		</ul>
	</li>

	<li class="select-maintenance hide isadmin <?php if ( $_GET['url'] == 'maintenance' ) { ?> active <?php } ?>">
		<a href="index.php?url=maintenance" class="dropdown-toggle">
			<i class="menu-icon fa fa-wrench"></i>
			<span class="menu-text">Maintenance</span>
			<b class="arrow fa fa-angle-down"></b>
		</a>
		<b class="arrow"></b>
		<ul class="submenu">
			<li class="select-maintenancewo hide isadmin <?php if ( $_GET['type'] == 'wolist' ) { ?> active <?php } ?>">
				<a href="index.php?url=maintenance&type=wolist">
					<i class="menu-icon fa fa-caret-right"></i>
					<span class="menu-text">Work Order</span>
				</a>
				<b class="arrow"></b>
			</li>

			<li class="select-metermanagement hide isadmin <?php if ( $_GET['type'] == 'metermanagement' ) { ?> active <?php } ?>">
				<a href="index.php?url=maintenance&type=metermanagement">
					<i class="menu-icon fa fa-caret-right"></i>
					<span class="menu-text">Meter Management</span>
				</a>
				<b class="arrow"></b>
			</li>

			<li class="select-mcomplaints hide isadmin <?php if ( $_GET['type'] == 'complaints' ) { ?> active <?php } ?>">
				<a href="index.php?url=maintenance&type=complaints">
					<i class="menu-icon fa fa-caret-right"></i>
					<span class="menu-text">Complaints</span>
				</a>
				<b class="arrow"></b>
			</li>

			<li class="select-maintenancebudget hide isadmin <?php if ( $_GET['type'] == 'budget' ) { ?> active <?php } ?>">
				<a href="index.php?url=maintenance&type=budget">
					<i class="menu-icon fa fa-caret-right"></i>
					<span class="menu-text">Maintenance Budget</span>
				</a>
				<b class="arrow"></b>
			</li>

			<!-- <li class=" isadmin<?php if ( $_GET['type'] == 'asset' ) { ?> active <?php } ?>">
				<a href="index.php?url=maintenance&type=asset">
					<i class="menu-icon fa fa-caret-right"></i>
					<span class="menu-text">Asset</span>
				</a>
				<b class="arrow"></b>
			</li> -->
		</ul>
	</li>	

	<li class="select-complaints hide isadmin <?php if ( $_GET['url'] == 'complaints' ) { ?> active <?php } ?>">
		<a href="index.php?url=complaints" class="dropdown-toggle">
			<i class="menu-icon fa fa-frown-o"></i>
			<span class="menu-text"> Complaints </span>
			<b class="arrow fa fa-angle-down"></b>
		</a>
		<b class="arrow"></b>
		<ul class="submenu">
			<li class="select-viewlistofcomplaints select-printcomplaints hide isadmin <?php if ( $_GET['type'] == 'clist' ) { ?> active <?php } ?>">
				<a href="index.php?url=complaints&type=clist">
					<i class="menu-icon fa fa-caret-right"></i>
					<span class="menu-text">Complaint List</span>
				</a>
				<b class="arrow"></b>
			</li>
			<li class="select-incidentreports hide isadmin <?php if ( $_GET['type'] == 'irlist' ) { ?> active <?php } ?>">
				<a href="index.php?url=complaints&type=irlist">
					<i class="menu-icon fa fa-caret-right"></i>
					<span class="menu-text">Violations</span>
				</a>
				<b class="arrow"></b>
			</li>
		</ul>
	</li>

	<li class="select-baggagelogs hide isadmin <?php if ( $_GET['url'] == 'baggagelogs' ) { ?> active <?php } ?>">
		<a href="index.php?url=baggagelogs">
			<i class="menu-icon fa fa-suitcase"></i>
			<span class="menu-text">Baggage Logs</span>
		</a>
		<b class="arrow"></b>
	</li>

	<li class="select-visitorlogs hide isadmin <?php if ( $_GET['url'] == 'visitorlogs' ) { ?> active <?php } ?>">
		<a href="index.php?url=visitorlogs">
			<i class="menu-icon fa fa-book"></i>
			<span class="menu-text"> Visitor Logs </span>
		</a>
		<b class="arrow"></b>
	</li>

	<?php if(SysLeaseSetup('softwaretype') != '5'){ ?>
	<li class="select-filemonitoring hide isadmin <?php if ( $_GET['url'] == 'filemonitoring' ) { ?> active <?php } ?>">
		<a href="index.php?url=filemonitoring">
			<i class="menu-icon fa fa-file-text"></i>
			<span class="menu-text">File Monitoring</span>
		</a>
		<b class="arrow"></b>
	</li>
  	<?php } ?>

	<li class="select-floorplan hide isadmin <?php if ( $_GET['url'] == 'floorplan' ) { ?> active <?php } ?>">
		<a href="index.php?url=floorplan">
			<i class="menu-icon fa fa-map"></i>
			<span class="menu-text"> Floor Plan </span>
		</a>
		<b class="arrow"></b>
	</li>

	<li class="select-reports hide isadmin <?php if ( $_GET['url'] == 'reports' ) { ?> active <?php } ?>">
		<a href="#" class="dropdown-toggle">
			<i class="menu-icon fa fa-pie-chart"></i>
			<span class="menu-text"> Reports</span>
			<b class="arrow fa fa-angle-down"></b>
		</a>
		<b class="arrow"></b>
		<ul class="submenu">
			<?php if(SysLeaseSetup('softwaretype') != '5'){ ?>
			<li class="select-tenantsalesreports hide isadmin <?php if ( $_GET['type'] == 'tsr' ) { ?> active <?php } ?>">
				<a href="index.php?url=reports&type=tsr">
					<i class="menu-icon fa fa-caret-right"></i>
					<span class="menu-text">Tenant Sales Reports</span>
				</a>
				<b class="arrow"></b>
			</li>
  			<?php } ?>

			
			<!-- Added Ronald 2018-10-11 -->
			<li class="select-leasingreports hide isadmin <?php if ( $_GET['type'] == 'lrep' ) { ?> active <?php } ?>">
				<a href="index.php?url=reports&type=lrep">
					<i class="menu-icon fa fa-caret-right"></i>
					<span class="menu-text">Leasing Reports</span>
				</a>
				<b class="arrow"></b>
			</li>
			<!-- END Added Ronald 2018-10-11 -->

			<!-- <li class="hide isadmin<?php if ( $_GET['type'] == 'csvur' ) { ?> active <?php } ?>">
				<a href="index.php?url=reports&type=csvur">
					<i class="menu-icon fa fa-caret-right"></i>
					<span class="menu-text">CSV Upload Reports</span>
				</a>
				<b class="arrow"></b>
			</li> -->

			<li class="select-inquiryreports hide isadmin <?php if ( $_GET['type'] == 'ir' ) { ?> active <?php } ?>">
				<a href="index.php?url=reports&type=ir">
					<i class="menu-icon fa fa-caret-right"></i>
					<span class="menu-text">Inquiry Reports</span>
				</a>
				<b class="arrow"></b>
			</li>

			<li class="select-applicationreports hide isadmin <?php if ( $_GET['type'] == 'ar' ) { ?> active <?php } ?>">
				<a href="index.php?url=reports&type=ar">
					<i class="menu-icon fa fa-caret-right"></i>
					<span class="menu-text">Application Reports</span>
				</a>
				<b class="arrow"></b>
			</li>

			<li class="select-unithistory hide isadmin <?php if ( $_GET['type'] == 'uh' ) { ?> active <?php } ?>">
				<a href="index.php?url=reports&type=uh">
					<i class="menu-icon fa fa-caret-right"></i>
					<span class="menu-text">Unit History</span>
				</a>
				<b class="arrow"></b>
			</li>

			<li class="select-tenanthistory hide isadmin <?php if ( $_GET['type'] == 'th' ) { ?> active <?php } ?>">
				<a href="index.php?url=reports&type=th">
					<i class="menu-icon fa fa-caret-right"></i>
					<span class="menu-text">Tenant History</span>
				</a>
				<b class="arrow"></b>
			</li>

			<?php if(SysLeaseSetup('softwaretype') != '5'){ ?>
			<li class="select-salesaudit hide isadmin <?php if ( $_GET['type'] == 'sa' ) { ?> active <?php } ?>">
				<a href="index.php?url=reports&type=sa">
					<i class="menu-icon fa fa-caret-right"></i>
					<span class="menu-text">Sales Audit</span>
				</a>
				<b class="arrow"></b>
			</li>

			<li class="select-accreditation hide isadmin <?php if ( $_GET['type'] == 'accreditation' ) { ?> active <?php } ?>">
				<a href="index.php?url=reports&type=accreditation">
					<i class="menu-icon fa fa-caret-right"></i>
					<span class="menu-text">Accreditation</span>
				</a>
				<b class="arrow"></b>
			</li>
  			<?php } ?>

			<li class="select-audittrail hide isadmin <?php if ( $_GET['type'] == 'at' ) { ?> active <?php } ?>">
				<a href="index.php?url=reports&type=at">
					<i class="menu-icon fa fa-caret-right"></i>
					<span class="menu-text">Audit Trail</span>
				</a>
				<b class="arrow"></b>
			</li>

			<!-- ruth -->
			<!-- <li class="select-tenantchargespayments hide isadmin <?php if ( $_GET['type'] == 'tcp' ) { ?> active <?php } ?>">
				<a href="index.php?url=reports&type=tcp">
					<i class="menu-icon fa fa-caret-right"></i>
					<span class="menu-text">Tenants Charges and Payments</span>
				</a>
				<b class="arrow"></b>
			</li>

			<li class="select-tenantsrentrep hide isadmin <?php if ( $_GET['type'] == 'rent' ) { ?> active <?php } ?>">
				<a href="index.php?url=reports&type=rent">
					<i class="menu-icon fa fa-caret-right"></i>
					<span class="menu-text">Tenants Rents</span>
				</a>
				<b class="arrow"></b>
			</li>

			<li class="select-tenantspenalty hide isadmin <?php if ( $_GET['type'] == 'tpenalty' ) { ?> active <?php } ?>">
				<a href="index.php?url=reports&type=tpenalty">
					<i class="menu-icon fa fa-caret-right"></i>
					<span class="menu-text">Tenants Penalty</span>
				</a>
				<b class="arrow"></b>
			</li>

			<li class="select-complaintrep hide isadmin <?php if ( $_GET['type'] == 'complaintrep' ) { ?> active <?php } ?>">
				<a href="index.php?url=reports&type=complaintrep">
					<i class="menu-icon fa fa-caret-right"></i>
					<span class="menu-text">Complaints Report</span>
				</a>
				<b class="arrow"></b>
			</li>

			<li class="select-violationrep hide isadmin <?php if ( $_GET['type'] == 'violationrep' ) { ?> active <?php } ?>">
				<a href="index.php?url=reports&type=violationrep">
					<i class="menu-icon fa fa-caret-right"></i>
					<span class="menu-text">Violation Report</span>
				</a>
				<b class="arrow"></b>
			</li> -->
		<!-- ruth -->
			
		</ul>
	</li>

	<li class="select-systemsetup hide isadmin <?php if ( $_GET['url'] == 'systemsetup' ) { ?> active <?php } ?>">
		<a href="#" class="dropdown-toggle">
			<i class="menu-icon fa fa-cogs"></i>
			<span class="menu-text"> System Setup </span>
			<b class="arrow fa fa-angle-down"></b>
		</a>
		<b class="arrow"></b>
		<ul class="submenu">
			<?php if ( $_SESSION['MMS-UserID'] == 'GatessoftCorp' || $_SESSION['MMS-UserID'] == 'Superuser') { ?> 
			<li class="<?php if ( $_GET['type'] == 'syssetup' ) { ?> active <?php } ?>">
				<a href="index.php?url=systemsetup&type=syssetup">
					<i class="menu-icon fa fa-caret-right"></i>
					<span class="menu-text">General Setup</span>
				</a>
				<b class="arrow"></b>
			</li>
			<?php } ?>


			<?php if(SysLeaseSetup('isJDAMapping') == '1'){ ?>
			<li class="select-jdaMapping hide isadmin <?php if ( $_GET['type'] == 'jdamapping' ) { ?> active <?php } ?>">
				<a href="index.php?url=systemsetup&type=jdamapping">
					<i class="menu-icon fa fa-caret-right"></i>
					<span class="menu-text">JDA Mapping</span>
				</a>
				<b class="arrow"></b>
			</li>
  			<?php } ?>

			<li class="select-reportTempaltes hide isadmin <?php if ( $_GET['type'] == 'reporttemplates' ) { ?> active <?php } ?>">
				<a href="index.php?url=systemsetup&type=reporttemplates">
					<i class="menu-icon fa fa-caret-right"></i>
					<span class="menu-text">Report Templates</span>
				</a>
				<b class="arrow"></b>
			</li>

			<?php if ( $_SESSION['MMS-UserID'] == 'GatessoftCorp') { ?> 
			<li class="select-ZapUti hide isadmin <?php if ( $_GET['type'] == 'zaputi' ) { ?> active <?php } ?>">
				<a href="index.php?url=systemsetup&type=zaputility">
					<i class="menu-icon fa fa-caret-right"></i>
					<span class="menu-text">Zap Utility</span>
				</a>
				<b class="arrow"></b>
			</li>
			<?php } ?>

			<li class="select-referentials hide isadmin <?php if ( $_GET['type'] == 'referential' ) { ?> active <?php } ?>">
				<a href="index.php?url=systemsetup&type=referential">
					<i class="menu-icon fa fa-caret-right"></i>
					<span class="menu-text">Referential</span>
				</a>
				<b class="arrow"></b>
			</li>

			<li class="select-mallconfiguration hide isadmin <?php if ( $_GET['type'] == 'mallconfig' ) { ?> active <?php } ?>">
				<a href="index.php?url=systemsetup&type=mallconfig">
					<i class="menu-icon fa fa-caret-right"></i>
					<span class="menu-text"><label class="txtSysBuilding">Mall</label> Configuration</span>
				</a>
				<b class="arrow"></b>
			</li>

			<!-- <li class="select-termsandconditions hide isadmin <?php if ( $_GET['type'] == 'termsandconditions' ) { ?> active <?php } ?>">
				<a href="index.php?url=systemsetup&type=termsandconditions">
					<i class="menu-icon fa fa-caret-right"></i>
					<span class="menu-text">Terms and Conditions</span>
				</a>
				<b class="arrow"></b>
			</li> -->

			<li class="select-userandaccessibility hide isadmin <?php if ( $_GET['type'] == 'userandaccess' ) { ?> active <?php } ?>">
				<a href="index.php?url=systemsetup&type=userandaccess">
					<i class="menu-icon fa fa-caret-right"></i>
					<span class="menu-text">User and Accessibility</span>
				</a>
				<b class="arrow"></b>
			</li>

			<li class="select-tenantspaymentxmod hide isadmin <?php if ( $_GET['type'] == 'reftenantspayment' ) { ?> active <?php } ?>">
				<a href="index.php?url=systemsetup&type=reftenantspayment">
					<i class="menu-icon fa fa-caret-right"></i>
					<span class="menu-text">Tenant's Payment</span>
				</a>
				<b class="arrow"></b>
			</li>

			<!-- <li class="select-companylist hide isadmin <?php if ( $_GET['type'] == 'companylist' ) { ?> active <?php } ?>">
				<a href="index.php?url=systemsetup&type=companylist">
					<i class="menu-icon fa fa-caret-right"></i>
					<span class="menu-text">Company List</span>
				</a>
				<b class="arrow"></b>
			</li> -->

			<!-- <li class="select-maintenancechecklist hide isadmin <?php if ( $_GET['type'] == 'maintenancechecklist' ) { ?> active <?php } ?>">
				<a href="index.php?url=systemsetup&type=maintenancechecklist">
					<i class="menu-icon fa fa-caret-right"></i>
					<span class="menu-text">Maintenance Checklist</span>
				</a>
				<b class="arrow"></b>
			</li> -->
		</ul>
	</li>

	<li onclick="inputnewhardcodeid();" style="display: none;">
		<a href="#">
			<i class="menu-icon fa fa-eye-slash"></i>
			<span class="menu-text">  </span>
		</a>
		<b class="arrow"></b>
	</li>
</ul>
<script type="text/javascript">	
	function selectnav(type) {
		if(type == 13){
			$("#div_main_cont").load("tenants/floorplan_2.php");
			$("#li_header_header a").text("LCA Units");	
		}else if(type == 14){
			$("#div_main_cont").load("floorplan/floorplan.php");
			$("#li_header_header a").text("SET Units");	
		}else if(type == 7){
			$("#div_main_cont").load("tenants/mcp.php");
			$("#li_header_header a").text("Calendar");	
		}
	}
</script>

<div class="modal fade" id="modal_forhardcoded" role="dialog" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" style="font-size: 18px;">Hardcoded ID</h4>
			</div>
			<div class="modal-body">
				<div class="container-fluid">
                    <div class="row form-group">
                        <div class="input-group">
                            <input type="text" class="form-control" id="txtsearchHCID">
                            <label class="input-group-addon"><span class="fa fa-search"></span></label>
                       </div>
                    </div>
                    <div class="row form-group">
                        <table class="table table-bordered">
                            <thead>
                               <tr>
                                  <th>ID</th>
                                  <th>Description</th>
                               </tr>
                            </thead>
                            <tbody id="tblHDCIDList"></tbody>
                            <tbody>
                              <tr>
                                <td colspan="4">
                                    <input type="hidden" id="bilang">
                                    <button id="btn-FirstHCIDPage" onclick="PaginationHCID('first')" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-fast-backward"></span></button>
                                    <button id="btn-SecondHCIDPage" onclick="PaginationHCID('prev')" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-backward"></span></button>
                                    <button id="btn-ThirdHCIDPage"onclick="PaginationHCID('next')" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-forward"></span></button>
                                    <button id="btn-FourthHCIDPage" onclick="PaginationHCID('last')" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-fast-forward"></span></button>
                                </td>
                              </tr>
                          </tbody>
                       </table>
                    </div>
                    <div class="row form-group" style="margin-left: 50px;margin-right: 50px;">
                        <div class="row form-group">
                            <div class="col-sm-3" style="margin-top: 10px;">
                                ID
                            </div>
                            <div class="col-sm-8">
                                <input type="text" class="form-control InputHCID" id="HardCodedID" readonly>
                                <input type="hidden" id="txtHGroupID">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-3" style="margin-top: 10px;">
                                Description
                            </div>
                            <div class="col-sm-8">
                                <input type="text" class="form-control InputHCID" id="HardCodedDescription" readonly>
                                <input type="hidden" id="txtHGroupID">
                            </div>
                        </div>
                    </div>
                </div>
			</div>
			<div class="modal-footer label-light">
				<div id="btn-defaultbtn">
                    <button class="btn btn-primary btn-sm" onclick="clickaddHCID();"><span class="fa fa-plus"></span>&nbsp;&nbsp;Add</button>
                    <button class="btn btn-success btn-sm" onclick="clickeditHCID();"><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;Edit</button>
                    <button  class="btn btn-danger btn-sm" onclick="clickdeleteHCID();"><span class="glyphicon glyphicon-trash"></span>&nbsp;&nbsp;Delete</button>
                    <button class="btn btn-danger btn-sm" onclick='$("#modal_forhardcoded").modal("hide");'><span class="fa fa-remove"></span>&nbsp;&nbsp;Close</button>
                </div>

                <div id="btn-addbtn" style="display: none;">
                    <button class="btn btn-sm btn-primary" onclick="saveaddHCID();"><span class="fa fa-check"></span> Save</button>

                    <button class="btn btn-sm btn-danger" onclick="canceladdHCID();"><span class="fa fa-remove"></span> Cancel</button>
                </div>

                <div id="btn-editbtn" style="display: none;">
                    <button class="btn btn-sm btn-primary" onclick="saveeditHCID();"><span class="fa fa-check"></span> Save</button>
                    <button class="btn btn-sm btn-danger" onclick="canceleditHCID();"><span class="fa fa-remove"></span> Cancel</button>
                </div>
			</div>
		</div>
	</div>
</div>
<input type="hidden" id="HCIDcounts">
<input type="hidden" id="HCIDselectedid">

<script type="text/javascript">
	$(function(){
		HCIDList();
		$("#txtsearchHCID").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				HCIDList(); 
			}else if(x == '8'){
                if($('#txtsearchHCID').val() == ""){
                    HCIDList();
                }
            }
		});
	})

	function inputnewhardcodeid(){
 		$("#modal_forhardcoded").modal("show");
 	}

 	var HDCIDCount = 0;

 	function HCIDList2() {
		HDCIDCount = 0;
		HCIDList();
	}

 	function HCIDList(){
 		var key = $("#txtsearchHCID").val();
 		$.ajax({
 			type: 'POST',
 			url: 'sidenav/class.php',
 			data: 'key=' + key + '&HDCIDCount=' + HDCIDCount + '&form=HCIDList',
 			success:function(data){
 				var arr = data.split("|");
				$("#tblHDCIDList").html(arr[0]);
				$("#HCIDcounts").val(arr[1]);
				HCIDListSelected();
				if(arr[1] == 0){
					$("#btn-FirstHCIDPage").attr("disabled", "disabled");
					$("#btn-SecondHCIDPage").attr("disabled", "disabled");
					$("#btn-ThirdHCIDPage").attr("disabled", "disabled");
					$("#btn-FourthHCIDPage").attr("disabled", "disabled");
				}else{
					if(HDCIDCount == 0){
						$("#btn-FirstHCIDPage").attr("disabled", "disabled");
						$("#btn-SecondHCIDPage").attr("disabled", "disabled");
						$("#btn-ThirdHCIDPage").removeAttr("disabled");
						$("#btn-FourthHCIDPage").removeAttr("disabled");
					}else if(HDCIDCount == $("#HCIDcounts").val() * 10){
						$("#btn-FirstHCIDPage").removeAttr("disabled");
						$("#btn-SecondHCIDPage").removeAttr("disabled");
						$("#btn-ThirdHCIDPage").attr("disabled", "disabled");
						$("#btn-FourthHCIDPage").attr("disabled", "disabled");
					}else{
						$("#btn-FirstHCIDPage").removeAttr("disabled");
						$("#btn-SecondHCIDPage").removeAttr("disabled");
						$("#btn-ThirdHCIDPage").removeAttr("disabled");
						$("#btn-FourthHCIDPage").removeAttr("disabled");
					}
				}
 			}
 		})
 	}

 	function PaginationHCID(txt) {
		if(txt == 'first'){
			HDCIDCount = 0;
			HCIDList();
		}else if(txt == "prev"){
			HDCIDCount = HDCIDCount - 10;
			HCIDList();
		}else if(txt == "next"){
			HDCIDCount = HDCIDCount + 10;
			HCIDList();
		}else{
			HDCIDCount = $("#HCIDcounts").val() * 10;
			HCIDList();
		}
	}

	function HCIDListSelected() {
		$("#tblHDCIDList tr").each(function(){
			$(this).click(function(){
				$("#tblHDCIDList tr").removeClass("bg-info");
				$(this).addClass("bg-info");
				selectedHCID(this.id);
				$("#HCIDselectedid").val(this.id);
			})
		})
	}

	function selectedHCID(id) {
		$.ajax ({
			type: 'POST',
			url: 'sidenav/class.php',
			data: 'id=' + id + '&form=selectedHCID',
			success: function(data) {
				var arr = data.split("|");
				$("#HCIDselectedid").val(arr[0]);
				$("#HardCodedID").val(arr[1]);
				$("#HardCodedDescription").val(arr[2]);
			}
		})
	}

 	function saveaddHCID(){
 		var id = $("#HardCodedID").val();
		var description = $("#HardCodedDescription").val();
		$.ajax({
			type: 'POST',
			url: 'sidenav/class.php',
			data: 'id=' + id + '&description=' + description + '&form=saveaddHCID',
			success:function(data){
				if(data == "1"){
                	setTimeout(function(){
		            	showmodal("alert", "Saved.", "canceladdHCID", null, "", null, "0");
	   				}, 500)
                }else{
					setTimeout(function(){
		            	showmodal("alert", "Saving failed.", "", null, "", null, "0");
	   				}, 500)
                }
			}
		})
 	}

 	function saveeditHCID(){
		var id = $("#HCIDselectedid").val();
 		var hcid = $("#HardCodedID").val();
		var description = $("#HardCodedDescription").val();
		$.ajax({
			type: 'POST',
			url: 'sidenav/class.php',
			data: 'id=' + id + '&hcid=' + hcid + '&description=' + description + '&form=updateaddHCID',
			success:function(data){
				if(data == "1"){
                	setTimeout(function(){
		            	showmodal("alert", "Saved.", "canceleditHCID", null, "", null, "0");
	   				}, 500)
                }else{
					setTimeout(function(){
		            	showmodal("alert", "Saving failed.", "", null, "", null, "0");
	   				}, 500)
                }
			}
		})
 	}

 	function clickdeleteHCID(){
 		var id = $("#HCIDselectedid").val();
		if(id == ""){
			setTimeout(function(){
            	showmodal("alert", "Select item you want to delete first.", "", null, "", null, "1");
			}, 500)
		}else{
			setTimeout(function(){
            	showmodal("confirm", "Are you sure you want to delete this record?", "clickdeleteHCID2", null, "", null, "1");
			}, 500)
		}
 	}

 	function clickdeleteHCID2(){
 		var id = $("#HCIDselectedid").val();
 		$.ajax({
 			type: 'POST',
 			url: 'sidenav/class.php',
 			data: 'id=' + id + '&form=clickdeleteHCID2',
 			success:function(data){
 				if(data == "1"){
                	setTimeout(function(){
		            	showmodal("alert", "Record deleted.", "canceladdHCID", null, "", null, "0");
	   				}, 500)
                }else{
					setTimeout(function(){
		            	showmodal("alert", "An error has occured.", "", null, "", null, "0");
	   				}, 500)
                }
 			}
 		})
 	}

 	function clickaddHCID(){
 		$("#btn-defaultbtn").css("display", "none");
		$("#btn-addbtn").css("display", "block");
		$("#btn-editbtn").css("display", "none");
		$(".InputHCID").removeAttr("readonly");
		$("#tblHDCIDList tr").unbind("click");
		$(".InputHCID").val("");
 	}

 	function clickeditHCID(){
		var id = $("#HCIDselectedid").val();
		if(id == ""){
			setTimeout(function(){
            	showmodal("alert", "Select item you want to edit first.", "", null, "", null, "1");
			}, 500)
		}else{
			$("#btn-defaultbtn").css("display", "none");
			$("#btn-addbtn").css("display", "none");
			$("#btn-editbtn").css("display", "block");
			$(".InputHCID").removeAttr("readonly");
			$("#tblHDCIDList tr").unbind("click");
		}
 	}

 	function canceladdHCID(){
 		$("#btn-defaultbtn").css("display", "block");
		$("#btn-addbtn").css("display", "none");
		$("#btn-editbtn").css("display", "none");
		$(".InputHCID").attr("readonly", "readonly");
		$(".InputHCID").val("");
		HCIDList();
 	}

 	function canceleditHCID(){
 		$("#btn-defaultbtn").css("display", "block");
		$("#btn-addbtn").css("display", "none");
		$("#btn-editbtn").css("display", "none");
		$(".InputHCID").attr("readonly", "readonly");
		$(".InputHCID").val("");
		HCIDList();
 	}
</script>