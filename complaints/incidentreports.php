<div class="row">
	<div class="col-xs-12 col-md-12 col-lg-12">
		<div class="row form-group" style="margin-bottom: 0px;">
			<div class="col-md-2" style="padding-bottom: 5px;padding-left:0px;">
				<span class="input-icon" style="width: 100%;">
					<input type="text" class="form-control" placeholder="Search" title="Search" id="txtsearchhr">
					<i class="ace-icon fa fa-search nav-search-icon"></i>
				</span>
			</div>
			<div class="col-md-3" style="padding-bottom: 5px;padding-left:0px;">
				<h5><a onclick="loadHouseRulesFilter('HouseRules')" id="LINK_HouseRules_filter" class="popover-info" data-rel="popover" data-placement="bottom" title="Filter by" data-content='

				<fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
					<legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:95px;">&nbsp;&nbsp;Search by&nbsp;&nbsp;</legend>
					<div class="form-group row" style="margin:0px;">
						<div class="col-md-6">
							<label>
								<input name="form-field-checkbox-hrfilter" class="ace ace-checkbox-2 complaint_module_filter" type="checkbox" value="VSeriesNumber" id="filter_VSeriesNumber">
								<span class="lbl"> Violation Series Number</span>
							</label>                               
						</div>
						<div class="col-md-6">
							<label>
								<input name="form-field-checkbox-hrfilter" class="ace ace-checkbox-2 complaint_module_filter" type="checkbox" value="ViolatorName" id="filter_ViolatorName">
								<span class="lbl"> <?php if(SysLeaseSetup('softwaretype') == '5'){ echo "Buyer"; }else{ echo "Tenants"; } ?>/Employee Name</span>
							</label>
						</div>
					</div>
				</fieldset>

				<fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
					<legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:189px;">&nbsp;&nbsp;Filter by Violation Status&nbsp;&nbsp;</legend>
					<div class="form-group row" style="margin:0px;">
						<div class="col-md-2"></div>
						<div class="col-md-4" style="padding-right:0px;">
							<label class="label label-lg label-success arrowed-in-right arrowed">
								<input name="form-field-checkbox-hrstat" class="ace" type="checkbox" value="Resolved" id="filter_Resolved">
								<span class="lbl"> Resolved</span>
							</label>
						</div>
						<div class="col-md-4">
							<label class="label label-lg label-warning arrowed-in-right arrowed">
								<input name="form-field-checkbox-hrstat" class="ace" type="checkbox" value="Pending" id="filter_Pending">
								<span class="lbl"> Pending</span>
							</label>
						</div>
						<div class="col-md-2"></div>
					</div>
				</fieldset>

				<fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;" id="div_chkappdate">
					<legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:90px;">&nbsp;&nbsp;Date Entry&nbsp;&nbsp;</legend>
					<div class="form-group row" style="margin:0px;">
						<div class="col-md-1"></div>
						<div class="col-md-5">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
								<input class="form-control date-picker" type="text" name="" id="hrstart" data-provide="datepicker">
							</div>                
						</div>
						<div class="col-md-5">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
								<input class="form-control date-picker" type="text" name="" id="hrend" data-provide="datepicker">
							</div>                
						</div>
						<div class="col-md-1"></div>
					</div>
				</fieldset>

				<div class="form-group row" style="padding-left:8px;margin-bottom:0px;">
					<div class="col-md-9" style="padding-right:0px;">
						<div class="alert alert-info" style="padding-top:10px;padding-bottom:10px;">
							<button class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>
							Click "<b>OK</b>" to filter data and permanently save the filter selected.
						</div>
					</div>
					<div class="col-md-3">
						<button class="btn btn-xs btn-info btn-round" onclick="saveHouseRulesFilter()" style="float:right;margin-bottom:10px;margin-right:10px;width:80px;">OK</button>
					</div>
				</div>'>
				<i class="fa fa-filter bigger-110"></i>&nbsp;&nbsp;Select Filter here</a></h5>
			</div>
			<div class="col-md-4" style="padding-bottom: 5px;padding-left:0px;"></div>
			<div class="col-md-2" style="padding-bottom: 5px;padding-left:0px;">
				<button class="btn btn-sm btn-info btn-block hide isadmin select-createir pull-right btn-round" onclick="createviolation()">New Violation</button>
			</div>
			<div class="col-md-1 pull-right hide isadmin select-printir" style="padding-bottom: 5px;padding-left:0px;">
				<h5 class="center"><a onclick="showprintbyme()" class="popover-info" data-rel="popover" data-placement="bottom" title="Print by" data-content='
					<fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
						<legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:130px;">&nbsp;&nbsp;Filter by <label class="txtSysBuilding">Mall</label>&nbsp;&nbsp;</legend>
							<div class="form-group row" style="margin:0px;">
								<select class="form-control malloption" id="printbymehr"></select>
							</div>
					</fieldset>

					<fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;">
					<legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:100px;">&nbsp;&nbsp;Date Range&nbsp;&nbsp;</legend>
						<div class="form-group row" style="margin:0px;">
							<div class="col-md-6">
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-calendar bigger-110"></i>
									</span>
									<input class="form-control date-picker" type="text" id="dateFromhr" data-provide="datepicker" value="<?php echo date('m/d/Y'); ?>">
								</div>                
							</div>
							<div class="col-md-6">
								<div class="input-group">
									<span class="input-group-addon">
									<i class="fa fa-calendar bigger-110"></i>
									</span>
									<input class="form-control date-picker" type="text" id="dateTohr" data-provide="datepicker" value="<?php echo date('m/d/Y'); ?>">
								</div>                
							</div>
						</div>
					</fieldset>

					<div class="form-group row" style="padding-left:8px;margin-bottom:0px;">
						<div class="col-md-9" style="padding-right:0px;">
							<div class="alert alert-info" style="padding-top:10px;padding-bottom:10px;">
								<button class="close" data-dismiss="alert">
									<i class="ace-icon fa fa-times"></i>
								</button>
						  Select the range of date you want to print.
							</div>
						</div>
						<div class="col-md-3">
							<button class="btn btn-xs btn-success btn-round" onclick="printcomplaintshr()" style="float:right;margin-bottom:10px;margin-right:10px;width:80px;">
							Print
						</button>
					</div>'>
				<i class="glyphicon glyphicon-print bigger-110"></i>&nbsp;&nbsp;Print</a></h5>
			</div>
		</div>
		<div class="row form-group">
			<div class="parent">
				<table class="table table-bordered table-striped fixTable">
					<thead>
						<tr>
							<th style="width: 10%;">VSN<span class="btnsortdash-violations fa fa-sort bigger-130 pull-right" id="VSeriesNumber"></span></th>
							<th style="width: 17%;">Violator<span class="btnsortdash-violations fa fa-sort bigger-130 pull-right" id="ViolatorName"></span></th>
							<th style="width: 25%;">Violation/s2<span class="btnsortdash-violations fa fa-sort bigger-130 pull-right" id="Violation"></span></th>
							<th style="width: 9%;">Date<span class="btnsortdash-violations fa fa-sort bigger-130 pull-right" id="xdate"></span></th>
							<th style="width: 9%;">Time<span class="btnsortdash-violations fa fa-sort bigger-130 pull-right" id="xtime"></span></th>
							<th style="z-index: 1; width: 9%;">Status<span class="btnsortdash-violations fa fa-sort bigger-130 pull-right" id="xstatus"></span></th>
							<th style="width: 8%;">Added by<span class="btnsortdash-violations fa fa-sort bigger-130 pull-right" id="addedBy"></span></th>
							<th style="z-index: 1; width: 13%;">Options</th>
						</tr>
					</thead>
					<tbody id="tblviolation"></tbody>
				</table>
			</div>
			<table class="tabledash_footer table" style="margin: 0px !important;">
				<tr>
					<th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
						<font id="txthrentries" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
						<input id="txt_userpagehr" type="hidden">
						<ul id="ulpaginationhr" class="pagination pull-right"></ul>
					</th>
				</tr>
			</table>
		</div>
	</div>
</div>

<input type="hidden" id="ViolationsSortType" value="ASC">
<input type="hidden" id="ViolationsSortBy" value="VSeriesNumber">