<div class="row">
	<div class="col-md-12">
		<div class="row form-group">
			<div class="col-md-2" style="padding-bottom: 5px;padding-left: 0px;">
				<span class="input-icon" style="width: 100%;">
					<input type="text" class="form-control" id="txtSearcMeter" title="Search" placeholder="Search">
					<i class="ace-icon fa fa-search nav-search-icon"></i>
				</span>
			</div>
			<div class="col-md-2" style="padding-bottom: 5px;padding-left:0px;">
				<h5>
					<a onclick="loadMeterFilter('MeterManagement')" id="LINK_MeterManagement_filter" class="popover-info" data-rel="popover" data-placement="bottom" title="Filter by" data-content='
					<fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px; ">
						<legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:80px;">&nbsp;&nbsp;Select by</legend>
						<div class="form-group row" style="margin:0px;">
							<div class="col-md-6">
								<label>
									<input name="form-field-MeterSearch" class="ace ace-checkbox-2 tenant_module_filter" type="checkbox" value="a.MeterID" id="filter_a.MeterID">
									<span class="lbl"> Meter ID</span>
								</label>
							</div>
							<div class="col-md-6">
								<label>
									<input name="form-field-MeterSearch" class="ace ace-checkbox-2 tenant_module_filter" type="checkbox" value="b.tradename" id="filter_b.tradename">
									<span class="lbl"> Assigned Tenant</span>
								</label>                            
							</div>
						</div>
					</fieldset>

					<fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
						<legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:99px;">&nbsp;&nbsp;Filter Status</legend>
						<div class="form-group row" style="margin:0px;">
							<div class="col-md-4">
								<label>
									<input name="form-field-MeterStat" class="ace" type="checkbox" value="Electric" id="filter_Electric">
									<span class="lbl"></span> <i class="fa fa-flash orange"></i> Electric
								</label>
							</div>
							<div class="col-md-4">
								<label>
									<input name="form-field-MeterStat" class="ace" type="checkbox" value="Water" id="filter_Water">
									<span class="lbl"></span> <i class="fa fa-tint blue"></i> Water
								</label>
							</div>
							<div class="col-md-4">
								<label>
									<input name="form-field-MeterStat" class="ace" type="checkbox" value="Gas" id="filter_Gas">
									<span class="lbl"></span> <i class="fa fa-fire red"></i> Gas
								</label>
							</div>
						</div>
					</fieldset>

					<!-- <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;" id="div_chkappdate">
						<legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:110px;">&nbsp;&nbsp;Date Created&nbsp;&nbsp;</legend>
						<div class="form-group row" style="margin:0px;">
							<div class="col-md-1"></div>
							<div class="col-md-5">
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-calendar bigger-110"></i>
									</span>
									<input class="form-control div_app date-picker" type="text" id="txtMeterDateFrom" data-provide="datepicker">
								</div>                
							</div>
							<div class="col-md-5">
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-calendar bigger-110"></i>
									</span>
									<input class="form-control div_app date-picker" type="text" id="txtMeterDateTo" data-provide="datepicker">
								</div>                
							</div>
							<div class="col-md-1"></div>
						</div>
					</fieldset> -->

					<div class="form-group row" style="padding-left:8px;margin-bottom:0px;">
						<div class="col-md-9" style="padding-right:0px;">
							<div class="alert alert-info" style="padding-top:10px;padding-bottom:10px;">
								<button class="close" data-dismiss="alert">
									<i class="ace-icon fa fa-times"></i>
								</button>
								Click "<b>OK</b>" to filter data and permanently save the filter selected.
							</div>
						</div>
						<div class="col-md-3">
							<button class="btn btn-xs btn-info btn-round" onclick="saveMeterFilter()" style="float:right;margin-bottom:10px;margin-right:10px;width:80px;">
								OK
							</button>
						</div>
					</div>'>
					<i class="fa fa-filter bigger-110"></i>&nbsp;&nbsp;Select Filter here
					</a>
				</h5>
			</div>
			<div class="col-md-4"></div>
			<div class="col-md-2" style="padding-bottom: 5px;padding-right: 0px;">
				<button class="btn btn-sm btn-info pull-right btn-block btn-round" onclick="fncAddNewMeter();" title="Create New Meter">Add New Meter</button>
			</div>
			<div class="col-md-2" style="padding-bottom: 5px;padding-right: 0px;">
				<button class="btn btn-sm btn-warning btn-block btn-round" onclick="$('#mdlTenantLastReading').modal('show'); $('#txtLastReadTenantListPage').val('1'); fncTenantLastReading();" title="Last Reading Setup">Last Reading Setup</button>
			</div>
			<div class="row form-group">
				<div class="col-md-12">
					<div class="parent">
						<table class="table table-bordered fixTable">
							<thead>
								<tr>
									<th style="width: 10%;">Date Created</th>
									<th style="width: 15%;">Meter ID</th>
									<th style="width: 15%;">Initial Reading</th>
									<th style="width: 5%;">Multiplier</th>
									<th style="width: 32%;" class="thSysTenant">Assigned Tenant</th>
									<th style="width: 10%;">Type</th>
									<th style="width: 13%;z-index: 1;">Options</th>
								</tr>
							</thead>
							<tbody id="tbodyMeterList"></tbody>
						</table>
					</div>
					<table class="tabledash_footer table" style="margin: 0px !important;">
						<thead>
							<tr>
								<th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
									<font id="txtMeterListEntries" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
									<input id="txtMeterListPage" type="hidden">
									<ul id="txtMeterListPagination" class="pagination pull-right"></ul>
								</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade fade-scale" id="mdlAddNewMeter" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" style="font-size: 18px;" id="hdrAddNewMeter">New Meter</h4>
			</div>
			<div class="modal-body">
				<!-- Start Modify Ronald 2019-01-03 -->
				<div class="row">
					<!-- <div class="container-fluid"> -->
						<div class="col-md-4">
							<div class="row form-group required">
								<label class="col-md-12">Type</label>
								<div class="col-md-12">
									<select class="form-control refMeterRequired" id="txtMeterType">
										<option value=''>-- Select Type --</option>
										<option value="Electric">Electric</option>
										<option value="Water">Water</option>
										<option value="Gas">Gas</option>
									</select>
								</div>
							</div>
							<div class="row form-group required">
								<label class="col-md-12">Meter ID</label>
								<div class="col-md-12">
									<input type="text" class="form-control refMeterRequired" id="txtMeterID">
								</div>
							</div>
							<div class="row form-group required">
								<label class="col-md-12">Initial Reading</label>
								<div class="col-md-12">
									<input type="text" class="form-control numberlang refMeterRequired" id="txtMeterUsage">
								</div>
							</div>
							<div class="row form-group required">
								<label class="col-md-12">Multiplier</label>
								<div class="col-md-12">
									<input type="text" class="form-control numberlang refMeterRequired" id="txtMeterMultiplier">
								</div>
							</div>
						</div>
						<div class="col-md-8" id="subMCorner">
							<div class="panel panel-default">
								<div class="panel-heading">
									<label>With Sub Meter</label>
									<input id="withSubM" type="checkbox" class="ace ace-switch ace-switch-3" name="">
									<span class="lbl middle"></span>
								</div>
								<div class="panel-body">
									<div class="row form-group">
										<div class="col-md-4">
											<label class="control-label">Sub Meter ID</label>
											<input type="text" class="col-md-12 form-control refSubMeterRequired" id="txtSubMeterID">
										</div>
										<div class="col-md-4">
											<label class="control-label">Initial Reading</label>
											<input type="text" class="col-md-12 form-control numberlang refSubMeterRequired" id="txtSubMeterusage">
										</div>
										<div class="col-md-3">
											<label class="control-label">Multiplier</label>
											<input type="text" class="col-md-12 form-control numberlang refSubMeterRequired" id="txtSubMeterMulti" maxlength="2">
										</div>
										<div class="col-md-1">
											<label class="control-label">&nbsp;</label>
											<button class="btn btn-primary btn-round" id="btnfncSaveSubMeterInfo" style="padding: 2px 5px 2px 5px;"><i class="fa fa-plus"></i></button>
										</div>
									</div>
									<div class="row form-group">
										<div style="max-height: 200px;min-height: 200px;" class="parent">
											<table class="table table-bordered table-hover fixTable">
												<thead>
													<tr>
														<th style="width: 30%;">Sub Meter ID</th>
														<th style="width: 30%;">Initial Reading</th>
														<th style="width: 30%;">Multiplier</th>
														<th style="width: 10%; z-index: 1;"></th>
													</tr>
												</thead>
												<tbody id="tblsubMeterList" style="max-height: 250px;"></tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					<!-- </div> -->
				</div>
				<!-- Start Modify Ronald 2019-01-03 -->
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary btn-sm btn-round" id="btnfncSaveMeterInfo"><i class="fa fa-check"></i>&nbsp;&nbsp;Save</button>
			</div>
		</div>
	</div>
</div>
<!-- START Added Ronald 2019-01-03 -->
<div class="modal fade fade-scale" id="mdleditsubmeter" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" style="font-size: 18px;">Edit Sub Meter</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<!-- <div class="container-fluid"> -->
					<div class="col-md-12">
						<div class="row form-group">
							<label class="col-md-12">Meter ID</label>
							<div class="col-md-12">
								<input type="text" class="form-control" id="txteditsubMeterID">
							</div>
						</div>
						<div class="row form-group">
							<label class="col-md-12">Initial Reading</label>
							<div class="col-md-12">
								<input type="text" class="form-control numberlang" id="txteditsubMeterUsage">
							</div>
						</div>
						<div class="row form-group">
							<label class="col-md-12">Multiplier</label>
							<div class="col-md-12">
								<input type="text" class="form-control numberlang" id="txteditsubMeterMultiplier" maxlength="2">
							</div>
						</div>
					</div>
					<!-- </div> -->
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary btn-sm btn-round" id="btnfncSaveEditsubMeterInfo"><i class="fa fa-check"></i>&nbsp;&nbsp;Save</button>
			</div>
		</div>
	</div>
</div>
<!-- END Added Ronald 2019-01-03 -->
<div class="modal fade fade-scale" id="mdlBrowseTenant" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div id="preLoadmdlBrowseTenant"></div>
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" style="font-size: 18px;">Select <?php if(SysLeaseSetup('softwaretype') == '5'){ echo "Buyer"; }else{ echo "Tenant"; } ?></h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-xs-4 col-md-4 col-lg-4">
						<span class="input-icon" style="width: 100%;">
							<input type="text" class="form-control" id="txtMeterSearchTenant" title="Search" placeholder="Search">
							<i class="ace-icon fa fa-search nav-search-icon"></i>
						</span>
					</div>
					<div class=" col-xs-12 col-md-12 col-lg-12">
						<div class="parent" style="margin-top: 10px;">
							<table class="table table-bordered table-hover fixTable">
								<thead>
									<tr>
										<th style="width: 17%;"><?php if(SysLeaseSetup('softwaretype') == '5'){ echo "Buyer"; }else{ echo "Tenant"; } ?> ID</th>
										<th style="width: 25%;" class="txtSysBuilding">Mall</th>
										<th style="width: 30%;" class="thSysTenant">Tenant</th>
										<th style="width: 20%;">Occupancy Date</th>
										<th style="width: 8%;">Status</th>
									</tr>
								</thead>
								<tbody id="tblMeterTenantList"></tbody>
							</table>
						</div>
						<table class="tabledash_footer table" style="margin: 0px !important;">
							<thead>
								<tr>
									<th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
										<font id="txtMeterTenantListEntries" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
										<input id="txtMeterTenantListPage" type="hidden">
										<ul id="txtMeterTenantListPagination" class="pagination pull-right"></ul>
									</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-danger btn-sm btn-round" onclick='$("#mdlBrowseTenant").modal("hide");'>Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade fade-scale" id="mdlInputLastReading" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" style="font-size: 18px;">Current Meter Reading</h4>
			</div>
			<div class="modal-body">
				<div class="input-group col-xs-12 col-md-12 col-lg-12">
					<input type="text" class="form-control numberlang" id="txtCurrentMeterReading" placeholder="Current Meter Reading" style="text-align: center;">
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary btn-sm btn-round" id="btnCurrentMeterReading"><i class="fa fa-check"></i>&nbsp;&nbsp;Save</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade fade-scale" id="mdlTenantLastReading" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div id="preLoadmdlTenantLastReading"></div>
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" style="font-size: 18px;">Last Meter Reading Setup</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-xs-4 col-md-4 col-lg-4">
						<span class="input-icon" style="width: 100%;">
							<input type="text" class="form-control" id="txtLastReadSearchTenant" title="Search" placeholder="Search">
							<i class="ace-icon fa fa-search nav-search-icon"></i>
						</span>
					</div>
					<div class=" col-xs-12 col-md-12 col-lg-12">
						<div class="parent" style="margin-top: 10px;">
							<table class="table table-bordered fixTable">
								<thead>
									<tr>
										<th style="width: 20%;" class="txtSysBuilding">Mall</th>
										<th style="width: 25%;" class="thSysTenant">Tenant</th>
										<th style="width: 14%;">Water</th>
										<th style="width: 14%;">Electric</th>
										<th style="width: 14%;">Gas</th>
										<th style="width: 13%;z-index: 1;">Option</th>
									</tr>
								</thead>
								<tbody id="tblLastReadTenantList"></tbody>
							</table>
						</div>
						<table class="tabledash_footer table" style="margin: 0px !important;">
							<thead>
								<tr>
									<th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
										<font id="txtLastReadTenantListEntries" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
										<input id="txtLastReadTenantListPage" type="hidden">
										<ul id="txtLastReadTenantListPagination" class="pagination pull-right"></ul>
									</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-danger btn-sm btn-round" onclick='$("#mdlTenantLastReading").modal("hide");'>Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade fade-scale" id="mdlMeterHistory" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" style="font-size: 18px;">Meter History</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-xs-4 col-md-4 col-lg-4">
						<span class="input-icon" style="width: 100%;">
							<input type="text" class="form-control" id="txtSearchHistory" title="Search" placeholder="Search">
							<i class="ace-icon fa fa-search nav-search-icon"></i>
						</span>
					</div>
					<div class="col-xs-6 col-md-6 col-lg-6">
						<div class="input-daterange input-group">
							<input type="text" class="form-control date-picker" value="<?php echo date('m/d/Y'); ?>" id="txtDateFromHistory">
							<span class="input-group-addon">
								<i class="fa fa-exchange"></i>
							</span>
							<input type="text" class="form-control date-picker" value="<?php echo date('m/d/Y'); ?>" id="txtDateToHistory">
						</div>
					</div>
					<div class="col-xs-2 col-md-2 col-lg-2">
						<button class="btn btn-sm btn-info btn-round" onclick="fncViewAssignedTenantHistory();"><i class="fa fa-search"></i> Go</button>
					</div>
				</div>
				<div class="row">
					<div class=" col-xs-12 col-md-12 col-lg-12">
						<input type="hidden" id="txtHiddenMeterID">
						<input type="hidden" id="txtHiddenMeterType">
						<div class="parent" style="margin-top: 10px;">
							<table class="table table-bordered fixTable">
								<thead>
									<tr>
										<th style="width: 20%;">Date</th>
										<th style="width: 50%;" class="thSysTenant">Tenant</th>
										<th style="width: 30%;">Initial Reading</th>
									</tr>
								</thead>
								<tbody id="tblMeterHistory"></tbody>
							</table>
						</div>
						<table class="tabledash_footer table" style="margin: 0px !important;">
							<thead>
								<tr>
									<th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
										<font id="txtMeterTenantListEntries" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
										<input id="txtMeterTenantListPage" type="hidden">
										<ul id="txtMeterTenantListPagination" class="pagination pull-right"></ul>
									</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-danger btn-sm btn-round" onclick='$("#mdlMeterHistory").modal("hide");'>Close</button>
			</div>
		</div>
	</div>
</div>
<?php include("script.php"); ?>