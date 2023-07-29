<div class="row">
	<div class="col-xs-12 col-md-12 col-lg-12">
		<div class="row form-group" style="margin-bottom: 0px;"> 
			<div class="col-md-2" style="padding-bottom: 5px;padding-left:0px;">
				<span class="input-icon" style="width: 100%;">
					<input type="text" class="form-control" placeholder="Search" title="Search" id="txtSearchComplaints">
					<i class="ace-icon fa fa-search nav-search-icon"></i>
				</span>
			</div>
			<div class="col-md-3" style="padding-bottom: 5px;padding-left:0px;">
				<h5><a onclick="loadComplaintsFilter('Complaints')" id="LINK_Complaints_filter" class="popover-info" data-rel="popover" data-placement="bottom" title="Filter by" data-content='

					<fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
						<legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:95px;">&nbsp;&nbsp;Search by&nbsp;&nbsp;</legend>
						<div class="form-group row" style="margin:0px;">
							<div class="col-md-6">
								<label>
									<input name="form-field-checkbox" class="ace ace-checkbox-2 complaint_module_filter" type="checkbox" value="TenantID" id="filter_TenantID">
									<span class="lbl"> <?php if(SysLeaseSetup('softwaretype') == '5'){ echo "Buyer"; }else{ echo "Tenants"; } ?> ID</span>
								</label>
							</div>
							<div class="col-md-6">
								<label>
									<input name="form-field-checkbox" class="ace ace-checkbox-2 complaint_module_filter" type="checkbox" value="Complaint_Code" id="filter_Complaint_Code">
									<span class="lbl"> Complaint Code</span>
								</label>                               
							</div>
							<div class="col-md-6">
								<label>
									<input name="form-field-checkbox" class="ace ace-checkbox-2 complaint_module_filter" type="checkbox" value="TradeName" id="filter_TradeName">
                                    <span class="lbl"> <span class="thSysTenant"></span></span>
								</label>                            
							</div>
							<div class="col-md-6">
								<label>
									<input name="form-field-checkbox" class="ace ace-checkbox-2 complaint_module_filter" type="checkbox" value="Complete_Description" id="filter_Complete_Description">
									<span class="lbl"> Complaint Description</span>
								</label>                            
							</div>
						</div>
					</fieldset>

					<fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
						<legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:100px;">&nbsp;&nbsp;Filter Status&nbsp;&nbsp;</legend>
					  	<div class="form-group row" style="margin:0px;">
							<div class="col-md-4" style="padding-right:0px;">
							  	<label class="label label-lg label-danger arrowed-in-right arrowed">
									<input name="form-field-checkbox-pstat" class="ace" type="checkbox" value="High" id="filter_High">
									<span class="lbl"> High Priority</span>
							  	</label>
							</div>
							<div class="col-md-4" style="padding-right:0px;">
						 	 	<label class="label label-lg label-warning arrowed-in-right arrowed">
									<input name="form-field-checkbox-pstat" class="ace" type="checkbox" value="Medium" id="filter_Medium">
									<span class="lbl"> Medium Priority</span>
						 	 	</label>
							</div>
							<div class="col-md-4">
						  		<label class="label label-lg label-yellow arrowed-in-right arrowed">
									<input name="form-field-checkbox-pstat" class="ace" type="checkbox" value="Low" id="filter_Low">
									<span class="lbl" style"color:#333;"> Low Priority</span>
						  		</label>
							</div>
					  	</div>
					</fieldset>

					<fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
						<legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:189px;">&nbsp;&nbsp;Filter by Complaint Status&nbsp;&nbsp;</legend>
						<div class="form-group row" style="margin:0px;">
							<div class="col-md-4" style="padding-right:0px;">
								<label>
									<input name="form-field-checkbox-angbawatisaaymaykarapatangmamili" class="ace" type="checkbox" value="Resolved" id="filter_Resolved">
									<span class="lbl"> Resolved</span>
								</label>
							</div>
							<div class="col-md-4" style="padding-right:0px;">
								<label>
									<input name="form-field-checkbox-angbawatisaaymaykarapatangmamili" class="ace" type="checkbox" value="Ongoing" id="filter_Ongoing">
									<span class="lbl"> Ongoing</span>
								</label>
							</div>
							<div class="col-md-4">
								<label>
									<input name="form-field-checkbox-angbawatisaaymaykarapatangmamili" class="ace" type="checkbox" value="Pending" id="filter_Pending">
									<span class="lbl"> Pending</span>
								</label>
							</div>
						</div>
					</fieldset>

					<fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;" id="div_chkappdate">
						<legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:90px;">&nbsp;&nbsp;Date Entry&nbsp;&nbsp;</legend>
					  	<div class="form-group row" style="margin:0px;">
							<div class="col-md-1"></div>
							<div class="col-md-5">
							  	<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
									<input class="form-control date-picker" type="text" id="dateentrystart" data-provide="datepicker">
							  	</div>                
							</div>
							<div class="col-md-5">
						  		<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
									<input class="form-control date-picker" type="text" id="dateentryend" data-provide="datepicker">
						  		</div>                
							</div>
							<div class="col-md-1"></div>
					  	</div>
					</fieldset>

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
							<button class="btn btn-xs btn-info btn-round" onclick="saveComplaintsFilter()" style="float:right;margin-bottom:10px;margin-right:10px;width:80px;">OK</button>
					  	</div>
					</div>'>
					<i class="fa fa-filter bigger-110"></i>&nbsp;&nbsp;Select Filter here</a>
				</h5>
			</div>
			<div class="col-md-4" style="padding-bottom: 5px;padding-left:0px;"></div>
			<div class="col-md-2" style="padding-bottom: 5px;padding-left:0px;">
				<button class="btn btn-sm btn-info btn-block hide isadmin select-addcomplaints btn-round" onclick='NewTPComplaints();$("#mdl_NewTPComplaints").modal("show")'>New Complaint</button>
			</div>
			<div class="col-md-1" style="padding-bottom: 5px;padding-left:0px;">
			   <h5 class="center"><a onclick="showprintbyme();" class="popover-info hide isadmin select-printcomplaints" data-rel="popover" data-placement="bottom" title="Print by" data-content='
					<fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
					<legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:130px;">&nbsp;&nbsp;Filter by <label class="txtSysBuilding">Mall</label>&nbsp;&nbsp;</legend>
						<div class="form-group row" style="margin:0px;">
							<select class="form-control malloption" id="printbymec"></select>
						</div>
					</fieldset>

				  	<fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;" id="div_chkappdate">
					  	<div class="form-group row" style="margin:0px;">
							<div class="col-md-6">
							  	<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
									<input class="form-control date-picker" type="text" id="dateFrom" data-provide="datepicker" value="<?php echo date('m/d/Y'); ?>">
							  	</div>                
							</div>
							<div class="col-md-6">
							  	<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
									<input class="form-control date-picker" type="text" id="dateTo" data-provide="datepicker" value="<?php echo date('m/d/Y'); ?>">
							  	</div>                
							</div>
					  	</div>
					</fieldset>
					<div class="form-group row" style="padding-left:8px;margin-bottom:0px;">
						<div class="col-md-9" style="padding-right:0px;">
							<div class="alert alert-info" style="padding-top:10px;padding-bottom:10px;">
								<button class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>
						  		Select the range of date you want to print.
							</div>
						</div>
						<div class="col-md-3">
							<button class="btn btn-xs btn-success btn-round" onclick="printcomplaints()" style="float:right;margin-bottom:10px;margin-right:10px;width:80px;">Print</button>
						</div>
					</div>'>
					<i class="glyphicon glyphicon-print bigger-110"></i>&nbsp;&nbsp;Print</a>
				</h5>
			</div>
		</div>
		<div class="row form-group" style="margin-bottom: 0px !important;">
			<div class="parent">
				<table class="table table-bordered table-striped fixTable">
					<thead>
						<tr>
							<th width="10%"><?php if(SysLeaseSetup('softwaretype') == '5'){ echo "Buyer"; }else{ echo "Tenants"; } ?> ID<span class="btnsortdash-complaintslist fa fa-sort bigger-130 pull-right" id="TenantID"></span></th>
							<th width="10%" class="thSysTenant">Trade Name<span class="btnsortdash-complaintslist fa fa-sort bigger-130 pull-right" id="TradeName"></span></th>
							<th width="10%">Complaint Code<span class="btnsortdash-complaintslist fa fa-sort bigger-130 pull-right" id="Complaint_Code"></span></th>
							<th width="15%">Complaint Description<span class="btnsortdash-complaintslist fa fa-sort bigger-130 pull-right" id="Complete_Description"></span></th>
							<th width="10%">Date & Time Start<span class="btnsortdash-complaintslist fa fa-sort bigger-130 pull-right" id="Time_Received"></span></th>
							<th width="10%">Date & Time End<span class="btnsortdash-complaintslist fa fa-sort bigger-130 pull-right" id="Time_Resolved"></span></th>
							<th width="10%">Assigned Person<span class="btnsortdash-complaintslist fa fa-sort bigger-130 pull-right" id=""></span></th>
							<th width="10%">Complaint Status<span class="btnsortdash-complaintslist fa fa-sort bigger-130 pull-right" id="Complaint_Status"></span></th>
							<th width="10%">Priority Status</th>
							<th width="5%" class="isadmin hide select-printcomplaints" style="z-index: 1;">Options</th>
						</tr>
					</thead>
					<tbody id="tblcomplaints" ></tbody>
				</table>
			</div>
			<table class="tabledash_footer table" style="margin: 0px !important;">
				<thead>
				  	<tr>
						<th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
							<font id="txtComplaintsEntries" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
							<input id="txtComplaintsPageCount" type="hidden">
						  	<ul id="ulPageComplaints" class="pagination pull-right"></ul>
						</th>
				  	</tr>
				</thead>
		  	</table>
		</div>
	</div>
</div>

<div class="modal fade fade-scale" role="dialog" id="mdl_NewTPComplaints">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick='$("#mdl_NewTPComplaints").modal("hide");$("#mdl_NewTPComplaints :input").val("");'>&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">New Complaint</h4>
            </div>
            <div class="modal-body">
            	<div class="row form-group">
            		<div class="col-md-4 thSysTenant">
            			Tenant
            		</div>
            		<div class="col-md-8">
            			<select class="form-control ComplaintsReq" id="txtTPTenantID"></select>
            		</div>
            	</div>
                <div class="row form-group">
                    <div class="col-md-4">
                       Complaint Code
                    </div>
                    <div class="col-md-8">
                        <div class="input-group">
                            <select class="form-control ComplaintsReq" id="txtTPComplaints" onchange="ShowPreDescription(this.value);"></select>
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-sm btn-success" onclick="AddTPComplaintCode()">
                                    <span class="fa fa-plus"></span>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-4">
                        Complaint Description
                    </div>
                    <div class="col-md-8">
                        <textarea class="form-control ComplaintsReq" style="height: 100px;resize: none;" id="txtTPDescription"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-sm btn-round" onclick="SavenewTPComplaints();"><span class="fa fa-check"></span> Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" role="dialog" id="mdl_NewTPComplaintCode">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick='$("#mdl_NewTPComplaintCode").modal("hide");$("#txtTPAddComplaints").val("");$("#txtTPAddDescription").val("");'>&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">New Complaint</h4>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-md-4">
                       Complaint Code
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control ComplaintsReq2" id="txtTPAddComplaints">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-4">
                        Complaint Description
                    </div>
                    <div class="col-md-8">
                        <textarea class="form-control ComplaintsReq2" style="height: 100px;resize: none;" id="txtTPAddDescription"></textarea>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-4">
                        Priority Status
                    </div>
                    <div class="col-md-8">
                        <div class="col-md-4">
                            <div class="radio">
                                <label>
                                    <input name="form-field-radio" type="radio" class="ace radPrioStat" value="High">
                                    <span class="lbl">&nbsp;High</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="radio">
                                <label>
                                    <input name="form-field-radio" type="radio" class="ace radPrioStat" value="Medium">
                                    <span class="lbl">&nbsp;Medium</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="radio">
                                <label>
                                    <input name="form-field-radio" type="radio" class="ace radPrioStat" value="Low" checked>
                                    <span class="lbl">&nbsp;Low</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-sm btn-round" onclick="SaveNewComplaintCode();"><span class="fa fa-check"></span> Save</button>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="ComplaintsListSortType" value="ASC">
<input type="hidden" id="ComplaintsListSortBy" value="Complaint_Code">