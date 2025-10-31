<div class="page-header">
    <div class="row form-group" style="margin-bottom: 0px;padding-top:10px;background-color: #edf4f8;padding-bottom: 10px;">
        <div class="col-md-3">
            <h1 style="font-weight: bold;">LEASING APPLICATION</h1>
        </div>
        <div class="col-md-9">
            <!-- <span class='pull-right arrowed-in-right arrowed label label-xlg label-danger'>Disapproved Application</span> -->
            <!-- <span class='pull-right arrowed-in-right arrowed label label-xlg label-danger'>Cancelled Reservation</span> -->
            <span class='pull-right arrowed-in-right arrowed label label-xlg label-warning'>Occupied</span>
            <span class='pull-right arrowed-in-right arrowed label label-xlg label-success'>Confirmed</span>
            <span class='pull-right arrowed-in-right arrowed label label-xlg label-info'>Approved Application</span>
            <span class='pull-right arrowed-in-right arrowed label label-xlg label-yellow'>For Approval</span>
            <span class='pull-right arrowed-in-right arrowed label label-xlg label-pink'>Pending Application</span>
            <span class='label label-xlg label-inverse arrowed-in-right arrowed pull-right bold'>Inquired</span>
        </div>
    </div>
</div>


<div class="row">
  	<div class="col-md-12">
		<div class="row form-group" style="margin-bottom: 0px;">
		  	<div class="col-md-2 col-xs-12" style="padding-bottom: 5px;padding-left: 0px;">
				<span class="input-icon" style="width: 100%;">
				  	<input type="text" class="form-control" id="txtSearchSubLeadsPRO" title="Search" placeholder="Search">
				  	<i class="ace-icon fa fa-search nav-search-icon"></i>
				</span>
		  	</div>
		  	<div class="col-md-4" style="padding-bottom: 5px;padding-left:0px;">
			  	<h5><a onclick="loadProposalFilter('Proposal')" id="LINK_Proposal_filter" class="popover-info" data-rel="popover" data-placement="bottom" title="Filter by" data-content='
					<fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
				  		<legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:80px;">&nbsp;&nbsp;Search by</legend>
						<div class="form-group row" style="margin:0px;">
						  	<div class="col-md-4">
								<label>
								   	<input name="form-field-SubLeadsPRO" class="ace ace-checkbox-2 inquiry_module_filter" type="checkbox" value="Company_Name" id="filter_Company_Name">
								   	<span class="lbl"> Company</span>
								</label>
						  	</div>
						  	<div class="col-md-4">
								<label>
									<input name="form-field-SubLeadsPRO" class="ace ace-checkbox-2 inquiry_module_filter" type="checkbox" value="Trade_Name" id="filter_Trade_Name">
                                    <span class="lbl"> <span class="thSysTenant"></span></span>
								</label>
						  	</div>
						  	<div class="col-md-4">
								<label>
									<input name="form-field-SubLeadsPRO" class="ace ace-checkbox-2 inquiry_module_filter" type="checkbox" value="Address" id="filter_Address">
									<span class="lbl"> Address</span>
								</label>
						  	</div>
						</div>
					</fieldset>

					<fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
					  	<legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:93px;">&nbsp;&nbsp;Filter Status</legend>
					  	<div class="form-group row" style="margin:0px;">
						  	<div class="col-md-6">
								<label class="label label-lg label-light arrowed-in-right arrowed">
								  	<input name="form-field-SubLeadsPROStat" class="ace" type="checkbox" value="Inquired" id="filter_Inquired">
								  	<span class="lbl"> Inquired</span>
								</label>
						  	</div>
						  	<div class="col-md-6">
								<label class="label label-lg label-pink arrowed-in-right arrowed">
								  	<input name="form-field-SubLeadsPROStat" class="ace" type="checkbox" value="Pending" id="filter_Pending">
								  	<span class="lbl"> Pending Application</span>
								</label>
						  	</div>
						</div>
						<div class="form-group row" style="margin:0px;">
						  	<div class="col-md-6">
								<label class="label label-lg label-info arrowed-in-right arrowed">
								  	<input name="form-field-SubLeadsPROStat" class="ace" type="checkbox" value="Approved" id="filter_Approved">
								  	<span class="lbl"> Approved Application</span>
								</label>
						  	</div>
						  	<div class="col-md-6">
								<label class="label label-lg label-success arrowed-in-right arrowed">
								  	<input name="form-field-SubLeadsPROStat" class="ace" type="checkbox" value="Confirmed" id="filter_Confirmed">
								  	<span class="lbl"> Confirmed</span>
								</label>
						  	</div>
						</div>
						<div class="form-group row" style="margin:0px;">
						  	<div class="col-md-6">
								<label class="label label-lg label-warning arrowed-in-right arrowed">
								  	<input name="form-field-SubLeadsPROStat" class="ace" type="checkbox" value="Occupied" id="filter_Occupied">
								  	<span class="lbl"> Occupied</span>
								</label>
						  	</div>
						  	<div class="col-md-6">
								<label class="label label-lg label-danger arrowed-in-right arrowed">
								  	<input name="form-field-SubLeadsPROStat" class="ace" type="checkbox" value="Disapproved" id="filter_Disapproved">
								  	<span class="lbl"> Disapproved</span>
								</label>
						  	</div>
						</div>
					</fieldset>

					<fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;" id="div_chkappdate">
				  		<legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:100px;">&nbsp;&nbsp;Inquiry Date&nbsp;&nbsp;</legend>
						<div class="form-group row" style="margin:0px;">
						  	<div class="col-md-1"></div>
						  	<div class="col-md-5">
								<div class="input-group">
								  	<span class="input-group-addon">
										<i class="fa fa-calendar bigger-110"></i>
								  	</span>
								  	<input class="form-control div_app date-picker" type="text" id="txtSubLeadsPROStartDate" data-provide="datepicker">
								</div>
						  	</div>
						  	<div class="col-md-5">
								<div class="input-group">
								  	<span class="input-group-addon">
										<i class="fa fa-calendar bigger-110"></i>
								  	</span>
								  	<input class="form-control div_app date-picker" type="text" id="txtSubLeadsPROEndDate" data-provide="datepicker">
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
						  	<button class="btn btn-xs btn-info btn-round" onclick="saveProposalFilter()" style="float:right;margin-bottom:10px;margin-right:10px;width:80px;">OK</button>
						</div>
					</div>'><i class="fa fa-filter bigger-110"></i>&nbsp;&nbsp;Select Filter here</a></h5>
		  	</div>
		  	<div class="col-md-4" style="padding-bottom: 5px;text-align: right;"></div>
		  	<div class="col-md-2 col-xs-12" style="padding-bottom: 5px;padding-right: 0px;"></div>
		</div>
		<div class="row form-group" style="margin-bottom: 0px !important;">
		  	<div class="parent">
				<table id="simple-table" class="table table-bordered fixTable">
				  	<thead>
						<tr>
						  	<th style='width: 10%;'>Inquiry Date</th>
						  	<th style='width: 15%;' class="txtSysBuilding">Branch</th>
						  	<th style='width: 16%;' class="thSysTenant">Name</th>
						  	<th style='width: 16%;' class="hide_mobile">Company Name</th>
						  	<th style='width: 15%;' class="hide_mobile">Industry</th>
						  	<th style='width: 15%; z-index: 1;' class="hide_mobile">Status</th>
						  	<th style='width: 13%; z-index: 1;'>Option</th>
						</tr>
				  	</thead>
				  	<tbody id="tblSUbLeadsPRO"></tbody>
				</table>
		  	</div>
		  	<table class="tabledash_footer table" style="margin: 0px !important;">
				<thead>
				  	<tr>
						<th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
							<font id="txtSubLeadsProEnt" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
							<input id="SubLeadsPROPageCount" type="hidden">
						  	<ul id="ulSubLeadsProPage" class="pagination pull-right"></ul>
						</th>
				  	</tr>
				</thead>
		  	</table>
		</div>
  	</div>
</div>

<div class="modal fade fade-scale" id="modal_addnewinquiry" role="dialog" area-hidden="true" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog modal-lg" id="modal_div_inquiry" style="width: 80%;">
		<div class="modal-content">
			<div id="inquiryloadingscreen"></div>
			<div class="modal-header">
				<button type="button" class="close" onclick="CloseSubLeadsPro()">&times;</button>
				<h4 class="modal-title" id="div_modal_title_inquiry" style="font-family: Roboto;font-size: 18px;">Inquiry Information</h4>
				<input type="hidden" id="txtSubLeadsProStat">
			</div>
			<div class="modal-body" id="div_view_inquiry_modal">
				<div class="row">
					<div class="col-md-12">
						<div class="row form-group">
							<!-- <div class="col-md-12">
								<div class="checkbox pull-right">
									<label>
										<input type="checkbox" id="clicktoshowall" class="ace" onclick="clicktoshowall()">
										<span class="lbl" style="color: #666;font-weight: bold;">&nbsp;Expand All</span>
									</label>
								</div>
							</div> -->
							<div class="col-md-12">
								<div class="widget-container-col ui-sortable" id="widget-container-buyerinfo">
									<div class="widget-box transparent ui-sortable-handle" id="widget-box-12">
										<div class="widget-header"> 
											<h4 class="widget-title txtPanelHeader">Tenant Information</h4>
											<!-- <div class="widget-toolbar no-border">
												<a href="#" data-action="collapse" class="clicktoshowall" id="NDTTenantInformation">
													<i class="ace-icon fa fa-chevron-down"></i>
												</a>
											</div> -->
										</div>
										<div class="widget-body">
											<div class="widget-main">
												<div class="row well">
													<div class="row form-group">
														<div class="col-md-12">
															<h4 class="green txtPanelHeader">Tenant Information</h4>
														</div>
														<div class="col-md-4">
															<div class="row form-group">
																<div class="col-md-12 col-xs-12 thSysTenant">
																	Store Name
																</div>
																<div class="col-md-12 col-xs-12">
																	<input type="text" id="txtinq_tradename" class="form-control required_inq div_businessinfo" style="background-color: white !important;" readonly>
																</div>
															</div>
														</div>
														<div class="col-md-4">
															<div class="row form-group">
																<div class="col-md-12 col-xs-12">
																	Company
																</div>
																<div class="col-md-12 col-xs-12">
																	<input type="text" id="txtinq_companyname" class="form-control required_inq div_businessinfo" placeholder="Company Name" style="background-color: white !important;" readonly>
																</div>
															</div>
														</div>
														<div class="col-md-4">
															<div class="row form-group">
																<div class="col-md-12 col-xs-12">
																	Industry
																</div>
																<div class="col-md-12 col-xs-12">
																	<input type="text" id="txtinq_industryname" class="form-control required_inq div_businessinfo" placeholder="Select Industry" style="background-color: white !important;" readonly>
																</div>
															</div>
														</div>
														<div class="col-md-4 col-sm-4 col-xs-12 col-lg-4">
															<div class="row form-group">
																<div class="col-md-12">
																	Classification
																</div>
																<div class="col-md-12">
																	<select class="form-control txtAllClassification" id="txtInqClassification" onchange="fncAllDepartmentRef();" disabled style="background-color: white !important;"></select>
																</div>
															</div>
														</div>
														<div class="col-md-4 col-sm-4 col-xs-12 col-lg-4">
															<div class="row form-group">
																<div class="col-md-12">
																	Department
																</div>
																<div class="col-md-12">
																	<select class="form-control txtAllDepartment" id="txtInqDepartment" onchange="fncAllCategoryRef();" disabled style="background-color: white !important;"></select>
																</div>
															</div>
														</div>
														<div class="col-md-4 col-sm-4 col-xs-12 col-lg-4">
															<div class="row form-group">
																<div class="col-md-12">
																	Category
																</div>
																<div class="col-md-12">
																	<select class="form-control txtAllCategory" id="txtInqCategory" disabled style="background-color: white !important;"></select>
																</div>
															</div>
														</div>
														<div class="col-md-4 col-sm-4 col-xs-12 col-lg-4">
															<div class="row form-group">
																<div class="col-md-12">
																	Process Owner
																</div>
																<div class="col-md-12">
																	<select class="form-control txtAllProcessOwner" id="txtInqProcessOwner" disabled style="background-color: white !important;"></select>
																</div>
															</div>
														</div>
														<div class="col-md-4 col-sm-4 col-xs-12 col-lg-4">
															<div class="row form-group">
																<div class="col-md-12">
																	Source
																</div>
																<div class="col-md-12">
																	<select class="form-control txtAllSource" id="txtInqSource" disabled style="background-color: white !important;"></select>
																</div>
															</div>
														</div>
														<div class="col-md-12 col-xs-12">
															<div class="row form-group">
																<div class="col-xs-12">
																	<h4 class="green">Contact Persons</h4>
																</div>
															</div>
															<div class="row form-group">
																<div class="col-xs-12" style="display: inline-block;" id="div_inquiry_contact_person"></div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="widget-container-col ui-sortable" id="widget-container-buyerinfo">
									<div class="widget-box transparent ui-sortable-handle" id="widget-box-12">
										<div class="widget-header">
											<h4 class="widget-title">List of Proposals</h4>
											<!-- <div class="widget-toolbar no-border">
												<a href="#" data-action="collapse" class="clicktoshowall" id="INQcontactInfo">
													<i class="ace-icon fa fa-chevron-down"></i>
												</a>
											</div> -->
										</div>
										<div class="widget-body">
											<div class="widget-main">
												<div class="row well">
													<div class="row form-group">
														<div class="col-md-12 col-xs-12">
															<button class="btn btn-info btn-sm pull-right frmProDis hide isadmin select-addproposal btn-round" onclick="addNewProposal()">Add Proposal</button>
														</div>
													</div>
													<div class="row form-group">
														<div class="col-md-12 col-xs-12">
															<div class="parent2">
																<table class="table table-bordered fixTable">
																	<?php if(SysLeaseSetup('softwaretype') == "5"){ ?>
																		<thead>
																			<th width="<?php if(SysLeaseSetup('isAssocDues') == "1"){ ?> 20% <?php }else{ ?> 35% <?php } ?>">Unit</th>
																			<th width="15%">Occupancy Date</th>
																			<th width="10%">Terms</th>
																			<th width="10%">Rate</th>
																			<th width="10%">Interest</th>
																			<?php if(SysLeaseSetup('isAssocDues') == "1"){ ?>
																			<th width="15%">Association Dues</th>
																			<?php } ?>
																			<th width="10%">Status</th>
																			<th width="10%">Print</th>
																		</thead>
																	<?php }else{ ?>	
																		<thead>
																			<th width="<?php if(SysLeaseSetup('isAssocDues') == "1"){ ?> 20% <?php }else{ ?> 35% <?php } ?>">Unit</th>
																			<th width="13%">Date From</th>
																			<th width="13%">Date To</th>
																			<th width="15%">Monthly Dues</th>
																			<?php if(SysLeaseSetup('isAssocDues') == "1"){ ?>
																			<th width="15%">Association Dues</th>
																			<?php } ?>
																			<th width="10%">Status</th>
																			<th width="14%">Print</th>
																		</thead>
																	<?php } ?>
																	<tbody id="tblproposals"></tbody>
																</table>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="widget-container-col ui-sortable" id="widget-container-buyerinfo">
									<div class="widget-box transparent ui-sortable-handle" id="widget-box-12">
										<div class="widget-header">
											<h4 class="widget-title">Remarks</h4>
											<!-- <div class="widget-toolbar no-border">
												<a href="#" data-action="collapse" class="clicktoshowall" id="INQRemarks">
													<i class="ace-icon fa fa-chevron-down"></i>
												</a>
											</div> -->
										</div>
										<div class="widget-body">
											<div class="widget-main">
												<div class="row well">
													<div class="row form-group" id="divNewInquiryRemarks">
														<div class="col-md-12">
															<button class="btn btn-sm btn-info pull-right btn-round" id="btnaddnewreeeeem" onclick="addnewremarks()"><i class="ace-icon fa fa-thumb-tack"></i>&nbsp;Add New Remarks</button>
														</div>
													</div>
													<div class="row form-group">
	                                                    <div class="col-md-12">
	                                                    	<div id="divInqRemarks"></div>
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
				</div>
			</div>
			<div class="modal-footer">
				<div class="row form-group" style="margin-bottom: 0px;">
					<div class="col-md-4" style="padding-top: 5px;">
						<label class="updatedby_texts">
							<small class="text-success pull-left">
								<b>Created by:</b>&nbsp;<i id="txtinq_createdby"></i>
							</small>
							<small class="text-success pull-left">
								<b>Date Created:</b>&nbsp;<i id="txtinq_datecreated"></i>
							</small>
						</label>
					</div>
					<div class="col-md-4 pull-left" style="padding-top: 5px;">
						<label class="modified_info">
							<small class="text-success pull-left">
								<b>Modified by:</b>&nbsp;<i id="txtinq_modifby"></i>
							</small>
							<small class="text-success pull-left">
								<b>Date Modified:</b>&nbsp;<i id="txtinq_modifdate"></i>
							</small>
						</label>
					</div>
					<div class="col-md-4">
						<!-- <button type="button" class="btn btn-primary frmProDis" id="btn_saveinquiry" onclick="saveinquiry()"><i class="ace-icon fa fa-check"></i>&nbsp;Save</button> -->
						<button class="btn btn-primary btn-sm frmProDis hide isadmin select-closeproposal btn-round" id="btn_finaloffer" onclick="sendFinalOffer()"><span class="fa fa-send"></span> Send to Leasing</button>
						<button class="btn btn-primary btn-sm frmProDis hide isadmin select-closeproposal btn-round" id="btn_sendReservation" onclick="fncSendReservation()"><span class="fa fa-send"></span> Send to Reservation</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade fade-scale" role="dialog" id="modalshortcutunit" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div id="preloadshortcutunit"></div>
			<div class="modal-header">
				<button type="button" class="close" onclick="$('#modalshortcutunit').modal('hide');">×</button>
				<h4 class="modal-title" style="font-family: Roboto;font-size: 18px;">List of Units</h4>
			</div>
			<div class="modal-body">
				<div class="row form-group" style="padding-left:0px; margin-bottom: 0px !important;">
					<div class="col-md-4">
						<select id="txtProMallID" class="form-control" onchange="$('#shortcutuserpage').val('1'); LeadsProShrtctUnit();"></select>
					</div>
					<div class="col-md-4">
						<span class="input-icon" style="width: 100%;">
	                        <input type="text" class="form-control" placeholder="Search Unit" id="searchshortcutunit">
	                        <i class="ace-icon fa fa-search nav-search-icon"></i>
	                    </span>
					</div>
					<div class="col-md-4">
						<div class="col-md-6">
							<div class="radio">
								<label style="white-space: nowrap;">
									<input name="rdoShortucutUnit" type="radio" class="ace rdoShortucutUnit" value="SET" onclick="$('#shortcutuserpage').val('1'); LeadsProShrtctUnit();" checked>
									<span class="lbl">&nbsp;SET</span>
								</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="radio">
								<label style="white-space: nowrap;">
									<input name="rdoShortucutUnit" type="radio" class="ace rdoShortucutUnit" value="LCA" onclick="$('#shortcutuserpage').val('1'); LeadsProShrtctUnit();">
									<span class="lbl">&nbsp;LCA</span>
								</label>
							</div>
						</div>
					</div>
				</div>
				<div class="row form-group" style="margin-bottom: 0px !important;">
		        	<div class="col-md-12">
						<div class="parent">
							<table class="table table-hover table-bordered fixTable">
								<thead>
									<th width='20%'>Unit ID</th>
									<th width='80%'>Unit Name</th>
								</thead>
								<tbody id="tblselectshortcutunit"></tbody>
							</table>
						</div>
						<table class="tabledash_footer table" style="margin: 0px !important;">
			              	<thead>
				                <tr>
				                  	<th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
					                    <font id="shortcutentries" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
					                    <input id="shortcutuserpage" type="hidden">
					                    <ul id="ulshortcutpagination" class="pagination pull-right"></ul>
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

<div class="modal fade fade-scale" role="dialog" id="mdl_ProUnitInfo" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" onclick="$('#mdl_ProUnitInfo').modal('hide');">×</button>
				<h4 class="modal-title" style="font-family: Roboto;font-size: 18px;">Select Unit</h4>
			</div>
			<div class="modal-body">
				<div class="row form-group">
					<div class="col-md-12">
						<div id="divProUnitListContainer"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
	include("script.php");
	include("mdl_unit_information.php");
	include("mdl_PASS.php");
	include("include/mdl_Remarks.php");
	include("proposal_print.php");
?>