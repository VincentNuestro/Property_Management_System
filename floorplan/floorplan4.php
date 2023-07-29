<link href="assets/css/ol.css" rel="stylesheet" type="text/css">
<script src="assets/js/ol.js"></script>
<script src="assets/js/FileSaver.min.js"></script>
<?php
	include("../connect.php");
	$getpic = "SELECT ext, width, height FROM tblref_floorsetup WHERE floorid = '" . $_POST["floorid"] . "'";
	$pic =  mysql_fetch_array(mysql_query($getpic));
?>
<div class="page-header">
    <div class="row form-group" style="margin-bottom: 0px;padding-top:10px;background-color: #edf4f8;padding-bottom: 10px;">
        <div class="col-md-6">
            <h1 style="font-weight: bold;">FLOOR PLAN</h1>
        </div>
        <div class="col-md-6"></div>
    </div>
</div>

<div class="row">
	<div class="col-sm-12">
		<div class="row form-group">
			<div class="col-sm-2" id="div_left">
				<a class="btn btn-primary btn-sm btn-round" href="index.php?url=floorplan"><i class="fa fa-arrow-left fa-lg"></i> Back</a><br><br>
		        <h1 style="font-size: 20px; color: #666; font-weight: 400; margin-top: 0px;" id="FPMallNameHere">
		        	<br>
		        </h1>
		            <h1 style="font-size: 20px; color: #666; font-weight: 400; margin-top: 0px;"><small><?php echo $_POST["floorname"]; ?></small></h1>
		    	<div>
		        	<h4 class="text-primary">Legend:</h4>
		            <span class="label label-xlg label-light arrowed-right" style="display: block; margin-bottom: 5px;">Vacant</span>
		            <span class="label label-xlg label-success arrowed-right" style="display: block; margin-bottom: 5px;">Reserved</span>
		            <span class="label label-xlg label-warning arrowed-right" style="display: block; margin-bottom: 5px;">Occupied</span>
		            <span class="label label-xlg label-purple arrowed-right" style="display: block; margin-bottom: 5px;">Maintenance</span>
		            <span class="label label-xlg label-info arrowed-right" style="display: block; margin-bottom: 5px;">Renewal</span>
		            <span class="label label-xlg label-danger arrowed-right" style="display: block; margin-bottom: 5px;">For Eviction</span>
		            <span class="label label-xlg label-grey arrowed-right" style="display: block;">Late Payment</span>
		        </div>
		        <br>
		        <button class="btn btn-info btn-sm btn-round" id="show" onclick="$('#instructions').modal('show');"><span class="fa fa-navicon"></span>&nbsp;&nbsp;Show Instructions</button>
		    </div>
		    <div class="col-sm-10" style="text-align: center;" id="div_right">
		    	<div class="row">
		            <div class="col-sm-3"></div>
		            <div class="col-sm-6">
		                <h5 class="label label-xlg label-grey arrowed-in-right arrowed-in" id="txtplace">Place the unit now.</h5>
		                <h5 class="label label-xlg label-info arrowed-in-right arrowed-in" id="txtselected">Select a Unit</h5>
		            </div>
		            <div class="col-sm-3"></div>
		        </div>
		        <div style="border: solid 1px #999; padding: 5px; margin-bottom: 10px;"><div id="showcanvas" style="height: 500px;"></div></div>
		        <button class="btn btn-grey btn-sm hide isadmin select-setaddmarker btn-round" onclick="initdraw();"><i class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;Add/Place Unit</button>
		        <button class="btn btn-info btn-sm hide isadmin select-setmodifymarker btn-round" onclick="initmodify();"><i class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;Modify Unit</button>
		        <button id="export-png" class="btn btn-success btn-sm btn-round"><i class="fa fa-download"></i>&nbsp;&nbsp;Download PNG</button>
		    </div>
		</div>
	</div>
</div>

<div class="modal fade fade-scale" role="dialog" id="instructions">
	<div class="modal-dialog modal-sm">
    	<div class="modal-content">
        	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal">&times;</button>
            	<h4 class="modal-title" style="font-size: 18px;">Instructions</h4>
			</div>
            <div class="modal-body">
            	<div class="widget-box transparent">
                    <div class="widget-header">
                        <h4 class="widget-title">
                            Instructions
                        </h4>
                    </div>
                    <div class="widget-body">
                        <div class="widget-main padding-6 no-padding-left no-padding-right">
                            <ul>
                                <li>
                                    To add a unit:
                                    <ol>
                                        <li>Click '<span style="color: #06F;">Add/Place Unit</span>' button.</li>
                                        <li>Draw the unit coordinates.</li>
                                        <li>Select a unit from the list.</li>
                                    </ol>
                                </li>
                                <li>
                                    To modify unit coordinates:
                                    <ol>
                                        <li>Click '<span style="color: #06F;">Modify Unit</span>' button.</li>
                                        <li>Click and drag a part of the unit coordinates to change position or add vertices.</li>
                                        <li>Press '<span style="color: #06F;">Esc</span>' key to finish modifying.</li>
                                    </ol>
                                </li>
                                <li>Press '<span style="color: #06F;">Esc</span>' key to cancel current action.</li>
                                <li>
                                    To remove a unit:
                                    <ol>
                                        <li>Highlight a unit.</li>
                                        <li>Click '<span style="color: #F00;">Remove Unit</span>' button.</li>
                                    </ol>
                                </li>
                                <li>You can download a copy of your floorplan by clicking '<span style="color: #960;">Download</span>' button.</li>
                            </ul>
                        </div>
					</div>
                </div>
            </div>
		</div>
	</div>
</div>

<div class="modal fade fade-scale" role="dialog" id="assignunit">
	<div class="modal-dialog modal-sm">
    	<div class="modal-content">
        	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" onclick="removeunit2();">&times;</button>
            	<h4 class="modal-title" style="font-size: 18px;">Assign Unit</h4>
			</div>
            <div class="modal-body">
            	<input type="hidden" id="txtcoord">
                <span class="input-icon input-icon-right" style="margin: 10px; width: 92%;">
                    <input type="text" id="txtsearchunit" class="form-control input-large" onkeydown="loadunits();" placeholder="Search unit here..." style="width: 100%;">
                    <i class="ace-icon glyphicon glyphicon-search"></i>
                </span>
                <br>
                <div style="height: 322px; margin-right: 10px; overflow: scroll !important;" class="unitlist">
                    <ul class="list-group" id="unitlist"></ul>
                </div>
                <br>
            </div>
		</div>
	</div>
</div>

<div class="modal fade fade-scale" role="dialog" id="viewunit" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog modal-lg" style="width: 68%;">
    	<div class="modal-content">
        	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal">&times;</button>
            	<h4 class="modal-title" style="font-size: 18px;">Unit Information</h4>
			</div>
            <div class="modal-body">
            	<input type="hidden" id="txtunitid">
                <div class="tabbable">
                    <ul class="nav nav-tabs" id="myTab3">
                        <li class="active">
                            <a data-toggle="tab" href="#info1">
                                <i class="green ace-icon fa fa-info bigger-120"></i>
                                Unit Info.
                            </a>
                        </li>
                        <li onclick="unitstat();">
                            <a data-toggle="tab" href="#info2">
                                <i class="green ace-icon fa fa-building-o bigger-120"></i>
                                Activities
                            </a>
                        </li>
                        <li onclick="tenantstat();">
                            <a data-toggle="tab" href="#info3">
                                <i class="green ace-icon fa fa-users bigger-120"></i>
                                <?php if(SysLeaseSetup('softwaretype') == '5'){ echo "Buyer"; }else{ echo "Tenant"; } ?> History
                            </a>
                        </li>
                        <li onclick="showFPInquiryHistory();">
                            <a data-toggle="tab" href="#info4">
                                <i class="green ace-icon fa fa-phone bigger-120"></i>
                                Inquiry History
                            </a>
                        </li>
                        <li onclick="showSOAList();">
                            <a data-toggle="tab" href="#info5">
                                <i class="green ace-icon fa fa-book bigger-120"></i>
                                SOA
                            </a>
                        </li>
                        <li onclick="ShowMainLogs();">
                            <a data-toggle="tab" href="#info6">
                                <i class="green ace-icon fa fa-cog bigger-120"></i>
                                Maintanance
                            </a>
                        </li>
                        <li onclick="ShowComplaints();">
                            <a data-toggle="tab" href="#info7">
                                <i class="green ace-icon fa fa-exclamation-circle bigger-120"></i>
                                Complaints
                            </a>
                        </li>
                        <li onclick="loadincident();">
                            <a data-toggle="tab" href="#info8">
                                <i class="green ace-icon fa fa-info-circle bigger-120"></i>
                                Incident Reports
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="info1" class="tab-pane in active">
                        	<div class="row form-group">
                        		<div class="col-sm-12">
                        			<ul class='ace-thumbnails clearfix' style='max-height: 270px;overflow-y: scroll;' id="divFPUnitListContainer"></ul>
                        		</div>
                        	</div>
                        	<div class="row form-group">
							    <div class="col-sm-6">
							    	<div class="col-xs-11 label label-lg label-info arrowed-in arrowed-right">
										<b>Unit Information</b>
									</div>
			                        <div class='profile-user-info'>
			                        	<div class='profile-info-row'>
			                                <div class='profile-info-name' style='white-space: nowrap;'> Unit Name </div>
			                                <div class='profile-info-value'>
			                                    <span id="lunitname"></span>
			                                </div>
			                            </div>
			                        	<div class='profile-info-row'>
			                                <div class='profile-info-name' style='white-space: nowrap;'> Unit Type </div>
			                                <div class='profile-info-value'>
			                                    <span id="lUnitType"></span>
			                                </div>
			                            </div>
			                            <div class='profile-info-row'>
			                                <div class='profile-info-name' style='white-space: nowrap;'> Unit ID </div>
			                                <div class='profile-info-value'>
			                                    <span id="lUnitID"></span>
			                                </div>
			                            </div>
			                            <?php if(SysLeaseSetup('isClassification') == "1"){ ?>
		                     			<div class='profile-info-row'>
			                                <div class='profile-info-name'> Classification </div>
			                                <div class='profile-info-value'>
			                                    <span id="lClassification"></span>
			                                </div>
			                            </div>
			                            <?php } ?>
			                            <?php if(SysLeaseSetup('isDepartment') == "1"){ ?>
			                    		<div class='profile-info-row'>
			                         		<div class='profile-info-name'> Department </div>
			                                <div class='profile-info-value'>
			                                    <span id="lDepartment"></span>
			                                </div>
			                            </div>
			                            <?php } ?>
			                            <?php if(SysLeaseSetup('isCategory') == '1'){ ?>
			                    		<div class='profile-info-row'>
			                				<div class='profile-info-name'> Category </div>
			                                <div class='profile-info-value'>
			                                    <span id="lCategory"></span>
			                                </div>
			                            </div>
			                            <?php }	?>
			                            <div class="profile-info-row">
                                            <div class="profile-info-name"> <label class="txtSysBuilding"></label> </div>

                                            <div class="profile-info-value">
                                                <span id="lmall"></span>
                                            </div>
                                        </div>
			                    		<div class='profile-info-row'>
			                                <div class='profile-info-name' style='white-space: nowrap;'> Wing </div>
			                                <div class='profile-info-value'>
			                                    <span id="lwing"></span>
			                                </div>
			                            </div>
			                            <div class='profile-info-row'>
			                                <div class='profile-info-name' style='white-space: nowrap;'> Floor </div>
			                                <div class='profile-info-value'>
			                                    <span id="lfloor"></span>
			                                </div>
			                            </div>
			                            <div class='profile-info-row'>
			                                <div class='profile-info-name' style='white-space: nowrap;'> Area </div>
			                                <div class='profile-info-value'>
			                                    <span id="lArea"></span>
			                                </div>
			                            </div>
			                    		<div class='profile-info-row'>
			                             	<div class='profile-info-name'> Rate </div>
			                             	<div class='profile-info-value'>
			                                 	<span id="lRate"></span>
			                             	</div>
			                         	</div>
			                            <?php if(SysLeaseSetup('isAssocDues') == '1'){ ?>
			                    		<div class='profile-info-row'>
			                             	<div class='profile-info-name' style='white-space: nowrap;'> Association Dues </div>
			                             	<div class='profile-info-value'>
			                                 	<span id="lAssocDues"></span>
			                             	</div>
			                         	</div>
			                            <?php } ?>
			                    		<div class='profile-info-row'>
			                    			<div class='profile-info-name'> &nbsp; </div>
			                             	<div class='profile-info-value'>
			                                 	<span></span>
			                             	</div>
			                         	</div>
			                        </div>
							    </div>
							    <div class="col-sm-6">
							    	<div class="row">
							    		<div class="col-xs-11 label label-lg label-success arrowed-in arrowed-right">
											<b>Amenities</b>
										</div>
							    	</div>
							    	<div class="row">
										<ul class="list-unstyled spaced" id="divFPAmenities"></ul>
									</div>
							    	
							    	<!-- <div class="col-md-12">
							    		<div style="height: 50vh;">
							    			<table class="table table-bordered fixTable">
							    				<thead>
							    					<tr>
							    						<th>Amenities</th>
							    					</tr>
							    				</thead>
							    				<tbody id="divFPAmenities"></tbody>
							    			</table>
							    		</div>
							    	</div> -->
							    </div>
							</div>
							<!-- <div class="row form-group">
							    <div class="col-sm-8"></div>
							    <div class="col-sm-2">
							        <p style="font-size: 13px; font-weight: 400; color: #666; margin-top: 5px; margin-bottom: 5px;text-align: center;">Maximum:</p>
							        <p style="font-size: 20px; font-weight: 800; color: #333; margin-top: -10px;text-align: center;" id="max">0</p>
							    </div>
							    <div class="col-sm-2">
							        <p style="font-size: 13px; font-weight: 400; color: #666; margin-top: 5px; margin-bottom: 5px;text-align: center;">Remaining:</p>
							        <p style="font-size: 20px; font-weight: 800; color: #333; margin-top: -10px;text-align: center;" id="rem">0</p>
							    </div>
							</div> -->
							<div class="row form-group">
							    <div class="col-sm-12">
						       		<p style="font-size: 20px; font-weight: 400; color: #333;">Current <?php if(SysLeaseSetup('softwaretype') == '5'){ echo "Buyer"; }else{ echo "Tenant"; } ?></p>
							        <ul class="list-group" id="ctenantlist"></ul>
							    </div>
							</div>
							<div class="row form-group">
							    <div class="col-sm-4">
							        <center>
							            <button class="btn btn-white btn-round" id="txtwater"><span class="glyphicon glyphicon-tint"></span>&nbsp;&nbsp;Water Bill</button>
							        </center>
							    </div>
							    <div class="col-sm-4">
							        <center>
							            <button class="btn btn-white btn-round" id="txtelectric"><span class="fa fa-bolt bigger-110"></span>&nbsp;&nbsp;Electric Bill</button>
							        </center>
							    </div>
							    <div class="col-sm-4">
							        <center>
							            <button class="btn btn-white btn-round" id="txtfileicon"><span class="glyphicon glyphicon-file"></span>&nbsp;&nbsp;Sales File</button>
							        </center>
							    </div>
							</div>
                        </div>
                        <div id="info2" class="tab-pane">
                        	<div class="row" style="margin-bottom: 5px;">
							    <div class="col-sm-3">
							        <span class="input-icon" style="width: 100%;">
							            <input type="text" class="form-control" placeholder="Search" title="Search" id="txtsearchofunithistory">
							            <i class="ace-icon fa fa-search nav-search-icon"></i>
							        </span>
							    </div>
                                <div class="col-sm-3 hidden-xs"></div>
                                <div class="col-sm-4">
                                    <div class="input-daterange input-group">
                                        <input type="text" class="form-control date-picker" id="txtstartdate1" value="<?php echo date('m/d/Y'); ?>">
                                        <span class="input-group-addon">
                                            <i class="fa fa-exchange"></i>
                                        </span>
                                        <input type="text" class="form-control date-picker" id="txtenddate1" value="<?php echo date('m/d/Y'); ?>">
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <button class="btn btn-sm btn-primary btn-round" onclick="unitstat();"><i class="fa fa-search"></i> Go</button>
                                </div>
							</div>
                        	<div class="row">
							    <div class="col-sm-12">
							        <div class="parent">
							            <table class="table table-bordered table-striped fixTable">
							                <thead>
							                    <tr>
							                        <th style="width: 8%;">Date</th>
							                        <th style="width: 75%;" class="thSysTenant">Tenant Name</th>
							                        <th style="width: 7%;">Status</th>
							                        <th style="width: 10%; border-right: solid 1px #dddddd;">Bills/Sales</th>
							                    </tr>
							                </thead>
							                <tbody id="unitstatlist"></tbody>
							            </table>
							        </div>
							    </div>
							</div>
                        </div>
                        <div id="info3" class="tab-pane">
                        	<div class="row" style="margin-bottom: 5px;">
							    <div class="col-sm-3">
							        <span class="input-icon" style="width: 100%;">
							            <input type="text" class="form-control" placeholder="Search" title="Search" id="txtsearchoftenanthistory">
							            <i class="ace-icon fa fa-search nav-search-icon"></i>
							        </span>
							    </div>
                                <div class="col-sm-3 hidden-xs"></div>
                                <div class="col-sm-4">
                                    <div class="input-daterange input-group">
                                        <input type="text" class="form-control date-picker" id="txtstartdate2" value="<?php echo date('m/d/Y'); ?>">
                                        <span class="input-group-addon">
                                            <i class="fa fa-exchange"></i>
                                        </span>
                                        <input type="text" class="form-control date-picker" id="txtenddate2" value="<?php echo date('m/d/Y'); ?>">
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <button class="btn btn-sm btn-primary btn-round" onclick="tenantstat();"><i class="fa fa-search"></i> Go</button>
                                </div>
							</div>
							<div class="row">
							    <div class="col-sm-12">
							        <div class="parent">
							            <table class="table table-bordered table-hover fixTable">
							                <thead>
							                    <tr>
							                        <th style="width: 12%;"><?php if(SysLeaseSetup('softwaretype') == '5'){ echo "Buyer"; }else{ echo "Tenant"; } ?> ID</th>
							                        <th style="width: 28.5%;" class="thSysTenant">Tenant Name</th>
							                        <th style="width: 28.5%;">Company Name</th>
							                        <th style="width: 16%;">Occupancy Period</th>
							                        <th style="width: 15%;">Monthly Rent</th>
							                    </tr>
							                </thead>
							                <tbody id="tenantstatlist"></tbody>
							            </table>
							        </div>
							    </div>
							</div>
                        </div>
                        <div id="info4" class="tab-pane">
                        	<div class="row" style="margin-bottom: 5px;">
							    <div class="col-sm-3">
							        <span class="input-icon" style="width: 100%;">
							            <input type="text" class="form-control" placeholder="Search" title="Search" id="txtsearchinquiryhistory">
							            <i class="ace-icon fa fa-search nav-search-icon"></i>
							        </span>
							    </div>
						        <div class="col-sm-3 hide">
						            <button class="btn btn-sm btn-info btn-block btn-round" onclick="fncNewTenant('FloorPlan');">New Inquiry</button>
						        </div>
                                <div class="col-sm-3 hidden-xs"></div>
                                <div class="col-sm-4">
                                    <div class="input-daterange input-group">
                                        <input type="text" class="form-control date-picker" id="txtstartdate3" value="<?php echo date('m/d/Y'); ?>">
                                        <span class="input-group-addon">
                                            <i class="fa fa-exchange"></i>
                                        </span>
                                        <input type="text" class="form-control date-picker" id="txtenddate3" value="<?php echo date('m/d/Y'); ?>">
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <button class="btn btn-sm btn-primary btn-round" onclick="showFPInquiryHistory();"><i class="fa fa-search"></i> Go</button>
                                </div>
							</div>
							<div class="row">
							    <div class="col-sm-12">
							        <div class="parent">
							            <table class="table table-bordered table-hover fixTable">
							                <thead>
							                    <tr>
							                        <th style="width: 9%;">Date Inquired</th>
							                        <th style="width: 30%;" class="thSysTenant">Tenant Name</th>
							                        <th style="width: 30%;">Company Name</th>
							                        <th style="width: 16%;">Occupancy Period</th>
							                        <th style="width: 15%;">Montly Rent</th>
							                    </tr>
							                </thead>
							                <tbody id="unitInquiryList"></tbody>
							            </table>
							        </div>
							    </div>
							</div>
                        </div>
                        <div id="info5" class="tab-pane">
                        	<div class="row" style="margin-bottom: 5px;">
							    <div class="col-sm-3">
							        <span class="input-icon" style="width: 100%;">
							            <input type="text" class="form-control" placeholder="Search" title="Search" id="txtsearchsoa">
							            <i class="ace-icon fa fa-search nav-search-icon"></i>
							        </span>
							    </div>
							    <div class="col-sm-9">
							        
							    </div>
							</div>
                        	<div class="row" style="margin-bottom: 5px;">
								<div class="col-md-12">
									<div class="parent">
										<table class="table table-bordered table-striped fixTable">
											 <thead>
							                    <tr>
							                        <th style="width: 16%;">Billing Period</th>
							                        <th style="width: 13%;">SoA No.</th>
							                        <th style="width: 6%;">Ctrl No</th>
							                        <th style="width: 50%;" class="thSysTenant">Trade Name</th>
							                        <th style="text-align: right; width: 15%;">Current Balance</th>
							                    </tr>
							                </thead>
							                <tbody id="tblSoaList"></tbody>
										</table>
									</div>
								</div>
							</div>
                        </div>
                        <div id="info6" class="tab-pane">
                        	<div class="row" style="margin-bottom: 5px;">
								<div class="col-md-12">
									<div class="parent">
										<table class="table table-bordered table-striped fixTable">
											 <thead>
							                    <tr>
							                        <th style="width: 9%;">Task ID</th>
							                        <th style="width: 8%;">Date Entry</th>
							                        <th style="width: 20%;" class="thSysTenant">Trade Name</th>
							                        <th style="width: 35%;">Work Order Details</th>
							                        <th style="width: 20%;">Assigned To</th>
							                        <th style="width: 8%;">Status</th>
							                    </tr>
							                </thead>
							                <tbody id="tblwolist"></tbody>
										</table>
									</div>
								</div>
							</div>
                        </div>
                        <div id="info7" class="tab-pane">
                        	<div class="row" style="margin-bottom: 5px;">
							    <div class="col-md-12">
							        <div class="parent">
							            <table class="table table-bordered table-striped fixTable">
							                 <thead>
							                    <tr>
							                        <th style="width: 18%;">Complaint Code</th>
							                        <th style="width: 18%;">Complaint Description</th>
							                        <th style="width: 14%;">Date Received</th>
							                        <th style="width: 14%;">Date Resolved</th>
							                        <th style="width: 15%;">Resolved By</th>
							                        <th style="width: 11%;">Complaint Status</th>
							                        <th style="width: 10%;">Priority Status</th>
							                    </tr>
							                </thead>
							                <tbody id="tblfpComplaintsList"></tbody>
							            </table>
							        </div>
							    </div>
							</div>
                        </div>
                        <div id="info8" class="tab-pane">
                        	<div class="row" style="margin-bottom: 5px;">
							    <div class="col-md-12">
							        <div class="parent">
							            <table class="table table-bordered table-striped fixTable">
							                 <thead>
							                    <tr>
							                        <th style="width: 13%;">Violation Series No.</th>
							                        <th style="width: 20%;"><?php if(SysLeaseSetup('softwaretype') == '5'){ echo "Buyer"; }else{ echo "Tenant"; } ?>/Employee Name</th>
							                        <th style="width: 46%;">Violation/s</th>
							                        <th style="width: 8%;">Date</th>
							                        <th style="width: 8%;">Time</th>
							                        <th style="width: 8%;">Status</th>
							                    </tr>
							                </thead>
							                <tbody id="tblfpincidentreports"></tbody>
							            </table>
							        </div>
							    </div>
							</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            	<button class="btn btn-info btn-sm btn-round" onclick='viewcalendar();'><span class="glyphicon glyphicon-calendar"></span>&nbsp;&nbsp;Calendar View</button>
                <button class="btn btn-danger btn-sm hide isadmin select-setremovemarker btn-round" onclick="removeunit();"><span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Remove Unit</button>
            </div>
		</div>
	</div>
</div>

<script type="text/javascript">
	var draw;
	var modify;
	var selection;
	var num = 0;
	var featured = "";
	var features = new ol.Collection();
	var source = new ol.source.Vector({features: features});
	var added;
	var raster = new ol.layer.Tile({
		source: new ol.source.OSM()
	});
	
	var stroke = new ol.style.Style({
		stroke: new ol.style.Stroke({
			color: '#333',
			width: 1.5,
			lineCap: 'butt',
			lineDash: [5, 5]
		})
	});
		
	function textstyle(myname) {
		var text = new ol.style.Style({
			text: new ol.style.Text({
				font: '9px Roboto',
				fill: new ol.style.Fill({ color: '#000' }),
				offsetY: "10",
				stroke: new ol.style.Stroke({
					color: '#000',
					width: 0.5
				}),
				text: myname
			})
		});
		return text;
	}
	
	function fillstyle(status){
		var fillcolor = "";
		switch(status){
			case "Vacant": fillcolor = "rgba(231,231,231, 0.6)"; break;
			case "Reserved": fillcolor = "rgb(92, 184, 92)"; break;
			case "Occupied": fillcolor = "rgba(248,148,6, 0.6)"; break;
			case "Maintenance": fillcolor = "rgba(149,133,191, 0.6)"; break;
			case "ForRenewal": fillcolor = "rgba(58,135,173, 0.6)"; break;
			case "ForEviction": fillcolor = "rgba(209,91,71, 0.6)"; break;
			case "Late Payment": fillcolor = "rgba(160,160,160, 0.6)"; break;
			default: fillcolor = "rgba(231,231,231, 0.6)";
		}
		var mystyle = new ol.style.Style({
			fill: new ol.style.Fill({
				color: fillcolor
			})
		});
		return mystyle;
	}

	var vector = new ol.layer.Vector({
		source: source
	});
	  
	var extent = [0, 0, <?php echo $pic[1]; ?>, <?php echo $pic[2]; ?>];
	var projection = new ol.proj.Projection({
		code: 'xkcd-image',
		units: 'pixels',
		extent: extent
	});

	var map = new ol.Map({
		layers: [
			new ol.layer.Image({
			source: new ol.source.ImageStatic({
				attributions: '',
			  	url: '../Mall_Attachments/floorplan/<?php echo $pic[0]; ?>',
			  	projection: projection,
			  	imageExtent: extent
			}),
			opacity: 0.8
		  }),
		  vector
		],
		target: 'showcanvas',
		view: new ol.View({
			projection: projection,
		  	center: ol.extent.getCenter(extent),
		  	zoom: 2,
		  	maxZoom: 4
		})
	});
	
	loadpoints();
	
	function loadpoints(){
		source.clear(true);
		$.ajax({
			type: 'POST',
			url: 'floorplan/mcp_mainclass.php',
			data: 'floorid=<?php echo $_POST["floorid"]; ?>&form=loadpoints3',
			success: function(data) { 	
				var arr = data.split("#");
				for(var i=1; i<=arr.length-1; i++){
					var arr2 = arr[i].split("|");
					var thing = new ol.geom.Polygon(JSON.parse(arr2[6]));
					var featurething = new ol.Feature({
						geometry: thing
					});
					featurething.setId(arr2[1]);
					featurething.set("name", arr2[2]);
					featurething.setStyle([fillstyle(arr2[3]), stroke, textstyle(arr2[2])]);
					source.addFeature(featurething);
					// Sample marker
					var aa = featurething.getGeometry().getExtent();
					var oo = ol.extent.getCenter(aa);
					var iconStyle = new ol.style.Style({
						image: new ol.style.Icon(({
							anchor: [0.5, 1],
							size: [150, 150],
							opacity: 1,
							scale: 0.4,
							src: "../Mall_Attachments/company/" + arr2[4] + "/trades/" + arr2[5] + "/thumb.png"
						}))
					});
					var mfeature = new ol.Feature(new ol.geom.Point([parseFloat(oo[0]), parseFloat(oo[1])]));
					mfeature.setId("M-" + arr2[1]);
					mfeature.set("name", arr2[2]);
					mfeature.setStyle(iconStyle);
					source.addFeature(mfeature);
				}
			}
		})
	}
	
	vector.setMap(map);
	
	addselect();
	
	function addmodify(){
		modify = new ol.interaction.Modify({
			features: features,
			deleteCondition: function(event){
				return ol.events.condition.shiftKeyOnly(event) &&
				ol.events.condition.singleClick(event);
			}
		});
		
		modify.on('modifyend', function(event){
			var features = event.features.getArray();
			for(var i=0; i<features.length; i++)
			{
				var rev = features[i].getRevision();
				var id = features[i].getId();
				var name = features[i].get("name");
				if(rev != 3)
				{
					added = features[i];
					updateunit(id, name);
				}
			}
			map.removeInteraction(modify);
			map.addInteraction(selection);
		});
		
		map.addInteraction(modify);
	}

	function adddraw(){
		draw = new ol.interaction.Draw({
			features: features,
			type: ("Polygon")
		});
		
		draw.on('drawend', function(event){
			var coord = event.feature.getGeometry().getCoordinates();
			added = event.feature;
			$("#txtcoord").val(JSON.stringify(coord));
			$("#assignunit").modal("show");
			addselect();
		});
		
		map.addInteraction(draw);
	}
	
	function addselect(){
		map.removeInteraction(draw);
		map.removeInteraction(modify);
		selection = new ol.interaction.Select({
			condition: ol.events.condition.click
		});
		
		selection.on('select', function(evt){
			var selected = evt.selected;
			var deselected = evt.deselected;
			
			if(selected.length){
				selected.forEach(function(feature){
					if(feature.getId().toString() != "undefined"){
						selected = feature.getId().replace("M-", "");
						$("#txtselected").html("Selected Unit&nbsp;&nbsp;:&nbsp;&nbsp;<b>" + feature.get("name") + "</b>");
						featured = feature;
						addpointclick(selected);
					}
				});
			}
		});
		$("#txtplace").css("display", "none");
		$("#txtselected").css("display", "block");
		
		map.addInteraction(selection);
	}
	
	function initdraw(){
		map.removeInteraction(selection);
		adddraw();
		$("#txtplace").css("display", "block");
		$("#txtselected").css("display", "none");
	}
	
	function initmodify(){
		map.removeInteraction(selection);
		addmodify();
		$("#txtplace").css("display", "block");
		$("#txtselected").css("display", "none");
	}
	
	function removeunit(){ 
		showmodal("confirm", "Remove unit?", "removeunit1", null, "", null, "0"); 
	}
	
	function removeunit1(){
		$.ajax({
			type: 'POST',
			url: 'floorplan/mcp_mainclass.php',
			data: 'unitid=' + featured.getId().replace("M-", "") + '&form=removeunit3',
			success: function(data) {
				var arr = data.split("|");
				if(arr[1] == "1")
				{
					removeunit3(featured.getId().replace("M-", ""));
					loadunits();
					loadpoints();
					$("#viewunit").modal("hide");
				}
			}
		})
	}
	
	function removeunit2(){ 
		vector.getSource().removeFeature(added); 
	}
	
	function removeunit3(unitid){
		var features = source.getFeatures();
		if(features != null && features.length > 0){
			for(x in features){
				var id = features[x].getId().replace("M-", "");
				if(id == unitid){
					vector.getSource().removeFeature(features[x]);
					break;
				}
			}
		}
		map.removeInteraction(selection);
		addselect();
	}
	
	document.getElementById('export-png').addEventListener('click', function() {
		map.once('postcompose', function(event){
			var canvas = event.context.canvas;
			if(navigator.msSaveBlob){ 
				navigator.msSaveBlob(canvas.msToBlob(), "<?php echo $_POST['floorname']; ?>"); 
			}else{
				canvas.toBlob(function(blob){
					saveAs(blob, "<?php echo $_POST['floorname']; ?>");
				});
		  	}
		});
		map.renderSync();
	});
</script>

<?php 
	include("floorplanscript.php");
	include("fpsoamodal.php");
	include("../tenants/direct_tenant/direct_tenant_script.php");
	include("../tenants/direct_tenant/modal_application.php");
	include("../tenants/direct_tenant/modal_load_tenants.php"); // modal for adding of new tenant
    include("../tenants/direct_tenant/modal_new_tenant.php"); // modal for adding of new tenant
    include("../tenants/direct_tenant/modal_load_companies.php"); // modal for adding of new tenant
    include("../tenants/direct_tenant/modal_new_company.php"); // modal for adding of new tenant
    include("../tenants/direct_tenant/modal_new_address.php"); // modal for adding of new tenant
    include("../tenants/direct_tenant/modal_edit_contact_person.php"); // modal for adding of new tenant
?>