<!-- MODAL FOR CREATING A VIOLATION -->
<div class="modal fade fade-scale" id="modalviolation" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog modal-lg" style="width: 90%;">
		<div class="modal-content">
			<div id="preMdlViolation"></div>
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" onclick="closeandclearviolationcreationmodal();">&times;</button>
				<h4 class="modal-title" style="font-size: 18px;">Create Violation Ticket</h4>
			</div>
			<div class="modal-body">
				<div class="row form-group">
					<div class="col-md-4">
						<div class="widget-box widget-color-blue3">
							<div class="widget-header">
								<h5 class="widget-title">Tenant List</h5>
							</div>
							<div class="widget-body">
								<div class="widget-main">
									<div class="row">
										<div class="col-xs-12 col-md-5 col-lg-5 pull-right">
											<button class="btn btn-sm btn-primary btn-block btn-round" onclick="fncIRLoadMall(); $('#mdlViolatorList').modal('show');">Add Tenant</button>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12" style="margin-top: 10px;">
											<div class="parent2">
												<table class="table table-bordered table-striped fixTable">
													<thead>
														<tr>
															<!-- ruth1312020 -->
															<th style="width: 90%;">Tenant<span class="btnsortdash-tenantlist fa fa-sort bigger-130 pull-right" id="c"></span></th>
															<th style="width: 10%; z-index: 1;">Options</th>
														</tr>
													</thead>
													<tbody id="tbodySelVioList"></tbody>
												</table>
											</div>
											<table class="tabledash_footer table" style="margin: 0px !important;">
												<thead>
													<tr>
														<th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
															<font id="txtleadsentries" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
															<input id="leadspages" type="hidden">
															<ul id="ulpaginationleads" class="pagination pull-right"></ul>
														</th>
													</tr>
												</thead>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-8">
						<div class="widget-box widget-color-blue3">
							<div class="widget-header">
								<h5 class="widget-title">Violation List</h5>
							</div>
							<div class="widget-body">
								<div class="widget-main">
									<div class="row">
										<div class="col-xs-12 col-md-2 col-lg-2 pull-right">
											<button class="btn btn-sm btn-primary btn-block btn-round" onclick="modalviolationselection();">Add Violation</button>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12" style="margin-top: 10px;">
											<div class="parent2">
												<table class="table table-bordered table-striped fixTable">
													<thead>
														<tr>
															<th style="width: 15%;">Code<span class="btnsortdash-violationlist fa fa-sort bigger-130 pull-right" id="CODE"></span></th>
															<th style="width: 40%;">Violation<span class="btnsortdash-violationlist fa fa-sort bigger-130 pull-right" id="Violation"></span></th>
															<th style="width: 35%;">Remarks<span class="btnsortdash-violationlist fa fa-sort bigger-130 pull-right" id="Remarks"></span></th>
															<th style="width: 10%;z-index: 1;">Option</th>
														</tr>
													</thead>
													<tbody id="tbodyIRVioList"></tbody>
												</table>
											</div>
											<table class="tabledash_footer table" style="margin: 0px !important;">
												<thead>
													<tr>
														<th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
															<font  id="txtcomplaintsentries" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
															<input  id="txt_userpage" type="hidden">
															<ul id="ulpaginationcomplaint" class="pagination pull-right"></ul>
														</th>
													</tr>
												</thead>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-sm btn-primary btn-round" onclick='saveviolationticket();'><i class="fa fa-check"></i> Save</button>
			</div>
		</div>
	</div>
</div>

<!-- MODAL FOR ADDING REMARKS -->
<div class="modal fade fade-scale" id="mdlAddRemarks" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" style="font-size: 18px;">Remarks</h4>
			</div>
			<div class="modal-body">
				<form id="frmIRRemarksAttachments" name="frmIRRemarksAttachments">
					<div class="row form-group">
						<div class="col-md-12">
							Remarks
						</div>
						<div class="col-md-12">
							<textarea class="form-control" style="height: 100px; resize: none;" id="txtIRRemarks" name="txtIRRemarks" maxlength="255"></textarea>
						</div>
					</div>
					<div class="row form-group">
						<div class="row form-group">
							<div class="col-md-12">
								<div id="divIRAttachment"></div>
							</div>
						</div>
						<input type="hidden" id="txtIRAttachCount" name="txtIRAttachCount">
						<input type="hidden" id="txtIRAttachVSN" name="txtIRAttachVSN">
						<input type="hidden" id="txtIRAttachHRCode" name="txtIRAttachHRCode">
						<input type="hidden" id="txtIRRemarksCode" name="txtIRRemarksCode">
					</div>
				</form>
				<div class="row form-group" style="margin-top: -10px;">
					<div class="col-md-12">
						<button class="btn btn-sm btn-success pull-right btn-round btnRemarks" onclick="fncAppendAttachmentDIV()"><i class="fa fa-plus"></i> Add New Attachment</button>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-sm btn-primary btn-round btnRemarks" onclick="fncSaveIRRemarks();"><i class="fa fa-check"></i> Save</button>
			</div>
		</div>
	</div>
</div>

<!-- MODAL FOR ADDING A VIOLATOR -->
<div class="modal fade fade-scale" id="mdlViolatorList" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" style="font-size: 18px;"><?php if(SysLeaseSetup('softwaretype') == '5'){ echo "Buyer"; }else{ echo "Tenant"; } ?> List</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-4">
						<span class="input-icon" style="width: 100%;">
							<input type="text" class="form-control" placeholder="Search" title="Search" id="txtSearchViolator">
							<i class="ace-icon fa fa-search nav-search-icon"></i>
						</span>
					</div>
					<div class="col-md-4">
						<select id="txtIRSelectMall" class="form-control" onchange="fncIRLoadViolators();"></select>
					</div>
					<div class="col-md-12" style="margin-top: 10px;">
						<div class="parent2">
							<table class="table table-bordered table-striped fixTable">
								<thead>
									<tr>
										<th width="25%"><?php if(SysLeaseSetup('softwaretype') == '5'){ echo "Buyer"; }else{ echo "Tenant"; } ?> ID2<span class="btnsortdash-tenantlist fa fa-sort bigger-130 pull-right" id="TenantID"></span></th>
										<th width="75%" class="thSysTenant"><span class="btnsortdash-tenantlist fa fa-sort bigger-130 pull-right" id="tradename"></span></th>
									</tr>
								</thead>
								<tbody id="tbodyIRTenantList"></tbody>
							</table>
						</div>
						<table class="tabledash_footer table" style="margin: 0px !important;">
							<thead>
								<tr>
									<th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
										<font  id="txtcomplaintsentries" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
										<input  id="txt_userpage" type="hidden">
										<ul id="ulpaginationcomplaint" class="pagination pull-right"></ul>
									</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-sm btn-danger btn-round" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<!-- MODAL FOR SELECTING A VIOLATION -->
<div class="modal fade fade-scale" id="modalviolationselection" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog modal-lg" style="width:85% !important;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" style="font-size: 18px;">List of Violations</h4>
			</div>
			<div class="modal-body">
				<div class="row form-group">
					<div class="col-xs-12 col-md-12 col-lg-12">
						<div class="parent">
							<table class="table table-bordered table-hover fixTable">
								<thead>
									<tr>
										<th style="display: none;"></th>
										<th width="10%">Code</th>
										<th width="40%">Violation</th>
										<th width="10%">1st Offense</th>
										<th width="10%">2nd Offense</th>
										<th width="10%">3rd Offense</th>
										<th width="10%">Succeeding</th>
									</tr>
								</thead>
								<tbody id="tblviolationlist"></tbody>
							</table>
						</div>
						<table class="tabledash_footer table" style="margin: 0px !important;">
							<thead>
								<tr>
									<th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
										<font style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
										<input type="hidden">
										<ul class="pagination pull-right"></ul>
									</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-sm btn-danger btn-round" onclick="$('#modalviolationselection').modal('hide');">Close</button>
			</div>
		</div>
	</div>
</div>

<!-- MODAL FOR RESOLVING VIOLATION -->
<div class="modal fade fade-scale" id="viewticketmodal" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog modal-lg" style="width: 90%;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" onclick="tblviolation();">&times;</button>
				<h4 class="modal-title" style="font-size: 18px;">Violations</h4>
			</div>
			<div class="modal-body">
				<div class="row form-group" style="margin-top: -20px;">
					<div class="col-md-12">
						<h2 class="header bolder blue center" id="lblIRTenantName"></h2>
					</div>
					<div class="col-md-4">
						<div class="row form-group">
							<div class="profile-user-info profile-user-info-striped">
								<div class="profile-info-row">
									<div class="profile-info-name"> VSN </div>
									<div class="profile-info-value">
										<span id="lblIRVSN"></span>
									</div>
								</div>
								<!-- <div class="profile-info-row">
									<div class="profile-info-name"> Unit No. </div>
									<div class="profile-info-value">
										<span id="lblIRUnitNo"></span>
									</div>
								</div> -->
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="row form-group">
							<div class="profile-user-info profile-user-info-striped">
								<div class="profile-info-row">
									<div class="profile-info-name"> Date </div>
									<div class="profile-info-value">
										<span id="lblIRDate"></span>
									</div>
								</div>
								<!-- <div class="profile-info-row">
									<div class="profile-info-name"> Unit No. </div>
									<div class="profile-info-value">
										<span id="lblIRUnitNo"></span>
									</div>
								</div> -->
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="row form-group">
							<div class="profile-user-info profile-user-info-striped">
								
								<div class="profile-info-row">
									<div class="profile-info-name"> Time </div>
									<div class="profile-info-value">
										<span id="lblIRTime"></span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row form-group" style="margin-top: -15px;">
					<div class="col-xs-12 col-md-12 col-lg-12">
						<div class="parent2">
							<table class="table table-bordered table-striped fixTable">
								<thead>
									<tr>
										<th style="width: 18%;">Violation</th>
										<th style="width: 10%;">Violation Level</th>
										<th style="width: 15%;">Offense Description</th>
										<th style="width: 10%;">Fine</th>
										<th style="width: 10%;">Status</th>
										<th style="width: 15%;">Remarks</th>
										<th style="width: 15%;">Response</th>
										<th style="width: 7%;">Option</th>
									</tr>
								</thead>
								<tbody id="tblticketinformation"></tbody>
							</table>
						</div>
						<table class="tabledash_footer table" style="margin: 0px !important;">
							<thead>
								<tr>
									<th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
										<label class="pull-right" id="modaltxttamount"></label>
									</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-sm btn-warning hide select- btn-round" id="btnpostingsabilling" onclick="checkmunabagopost();">Post To Billing</button>
			</div>
		</div>
	</div>
</div>
<!-- MODAL FOR ADDING RESOLUTION -->
<div class="modal fade fade-scale" id="modalAddReso" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div id="premodalAddReso"></div>
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" style="font-size: 18px;">Response</h4>
			</div>
			<div class="modal-body">
				<form id="frmIRRespoAttachments" name="frmIRRespoAttachments">
					<div class="row form-group">
						<div class="col-md-12">
							Response
						</div>
						<div class="col-md-12">
							<textarea class="form-control" style="height: 100px; resize: none;" id="modaltxtReso" name="modaltxtReso" maxlength="255"></textarea>
						</div>
					</div>
					<div class="row form-group">
						<div class="row form-group">
							<div class="col-md-12">
								<div id="divIRAttachmentResp"></div>
							</div>
						</div>
						<input type="hidden" id="txtIRAttachCountRes" name="txtIRAttachCountRes">
						<input type="hidden" id="txtIRAttachVSNRes" name="txtIRAttachVSNRes">
						<input type="hidden" id="txtIRAttachHRCodeRes" name="txtIRAttachHRCodeRes">
						<input type="hidden" id="txtIRRespoCode" name="txtIRRespoCode">
					</div>
				</form>
				<div class="row form-group" style="margin-top: -10px;">
					<div class="col-md-12">
						<button class="btn btn-sm btn-success pull-right btn-round btnResponse" onclick="fncAppendAttachmentDIVResp()"><i class="fa fa-plus"></i> Add New Attachment</button>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-sm btn-primary btn-round btnResponse" onclick="savemodalAddReso();"><i class="fa fa-check"></i> Save</button>
			</div>
		</div>
	</div>
</div>
<!-- MODAL FOR MODIFYING VIOLATION -->
<div class="modal fade fade-scale" id="mdlModifyViolation" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div id="premodalAddReso"></div>
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" style="font-size: 18px;">Update Status</h4>
			</div>
			<div class="modal-body">
				<div class="row form-group">
					<div class="col-md-12">
						Fine 
					</div>
					<div class="col-md-12">
						<input type="text" class="form-control numberslang" style="text-align: right !important;" id="txtchargeamount">
						<input type="hidden" id="txtModVSN">
						<input type="hidden" id="txtModVCode">
					</div>
				</div>
				<div class="row form-group">
					<div class="col-md-12">
						Status 
					</div>
					<div class="col-md-12">
						<div class="radio">
							<label>
								<input id="radPending" name="form-field-radio-stat" type="radio" class="ace rdViolationStatus" value='Pending'>
								<span class="lbl"> Pending</span>
							</label>
							<label>
								<input id="radResolve" name="form-field-radio-stat" type="radio" class="ace rdViolationStatus" value='Resolved'>
								<span class="lbl"> Resolved</span>
							</label>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-sm btn-info btn-round btnResponse" id="s2bill" onclick="fncSaveModifiedViolation();"><i class="fa fa-check"></i> Save & Post to Billing</button>
				<button class="btn btn-sm btn-primary btn-round btnResponse" id="snorm" onclick="fncSaveModifiedViolation();"><i class="fa fa-check"></i> Save</button>
			</div>
		</div>
	</div>
</div>

<input type="hidden" id="TenantListSortType" value="ASC">
<input type="hidden" id="TenantListSortBy" value="tradename">

<input type="hidden" id="ViolationListSortType" value="ASC">
<input type="hidden" id="ViolationListSortBy" value="Code">

<!-- <input type="hidden" id="AddTenantSortType" value="ASC">
<input type="hidden" id="AddTenantSortBy" value="TenantID"> -->
