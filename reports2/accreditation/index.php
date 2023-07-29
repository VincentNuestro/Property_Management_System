<style type="text/css">
	.parent2{
		height: 40vh;
	}
</style>
<div class="row">
  	<div class="col-md-12">
	    <div class="row form-group" style="margin-bottom: 0px;"> 
	      	<div class="col-md-2" style="padding-bottom: 5px;padding-left:0px;">
		        <span class="input-icon" style="width: 100%;">
		          	<input type="text" class="form-control" placeholder="Search" title="Search" id="txtsearchAccreditation">
		          	<i class="ace-icon fa fa-search nav-search-icon"></i>
		        </span>
	      	</div>
	      	<div class="col-md-3" style="padding-bottom: 5px;padding-left:0px;">
	        	<h5><a onclick="loadAccreditationFilter('Accreditation')" id="LINK_Accreditation_filter" class="popover-info" data-rel="popover" data-placement="bottom" title="Filter by" data-content='

		        <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
		          	<legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:95px;">&nbsp;&nbsp;Search by&nbsp;&nbsp;</legend>
		          	<div class="form-group row" style="margin:0px;">
			            <div class="col-md-6">
			              	<label>
				                <input name="form-field-srchbyaccred" class="ace ace-checkbox-2 complaint_module_filter" type="checkbox" value="a.TenantID" id="filter_a.TenantID">
				                <span class="lbl"> Tenant ID</span>
			              	</label>
			            </div>
			            <div class="col-md-6">
			              	<label>
				                <input name="form-field-srchbyaccred" class="ace ace-checkbox-2 complaint_module_filter" type="checkbox" value="b.tradename" id="filter_b.tradename">
				                <span class="lbl"> Trade Name</span>
			              	</label>                               
			            </div>
			            <div class="col-md-6">
			              	<label>
				                <input name="form-field-srchbyaccred" class="ace ace-checkbox-2 complaint_module_filter" type="checkbox" value="a.NameofPOSProvider" id="filter_a.NameofPOSProvider">
				                <span class="lbl"> Name of POS Provider</span>
			              	</label>                               
			            </div>
			            <div class="col-md-6">
			              	<label>
				                <input name="form-field-srchbyaccred" class="ace ace-checkbox-2 complaint_module_filter" type="checkbox" value="a.SoftwareVersion" id="filter_a.SoftwareVersion">
				                <span class="lbl"> Software Version</span>
			              	</label>                            
			            </div>
		          	</div>
		        </fieldset>

		        <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
		          	<legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:100px;">&nbsp;&nbsp;Filter Status&nbsp;&nbsp;</legend>
		          	<div class="form-group row" style="margin:0px;">
			            <div class="col-md-6" style="padding-right:0px;">
			              	<label class="label label-success arrowed-in-right arrowed" style="margin-bottom: 0px;height:22px;padding-left:4px;">
				                <input name="form-field-accredstat" class="ace" type="checkbox" value="Accredited" id="filter_Accredited">
				                <span class="lbl"> Accredited</span>
			              	</label>
			            </div>
			            <div class="col-md-6" style="padding-right:0px;">
			              	<label class="label label-warning arrowed-in-right arrowed" style="margin-bottom: 0px;height:22px;padding-left:4px;">
				                <input name="form-field-accredstat" class="ace" type="checkbox" value="Not Accredited" id="filter_Not Accredited">
				                <span class="lbl"> Not Accredited</span>
			              	</label>
			            </div>
		          	</div>
		        </fieldset>

		        <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;" id="div_date1">
		          	<legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:150px;">&nbsp;Date of Accreditation</legend>
		          	<div class="form-group row" style="margin:0px;">
			            <div class="form-group row" style="margin:0px;">
			              	<div class="form-group row" style="margin:0px;">
				                <div class="col-md-1"></div>
				                <div class="col-md-5">
				                  	<div class="input-group">
					                    <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
					                    <input class="form-control div_date1 date-picker" type="text" id="AccredDateFrom" data-provide="datepicker">
				                  	</div>                              
				                </div>
				                <div class="col-md-5">
				                  	<div class="input-group">
					                    <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
					                    <input class="form-control div_date1 date-picker" type="text" id="AccredDateTo" data-provide="datepicker">
				                  	</div>                              
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
		            	<button class="btn btn-xs btn-info btn-round" onclick="saveAccreditationFilter()" style="float:right;margin-bottom:10px;margin-right:10px;width:80px;">OK</button>
		        	</div>
		        </div>'>
		        <i class="fa fa-filter bigger-110"></i>&nbsp;&nbsp;Select Filter here</a></h5>
	      	</div>
	      	<div class="col-md-2" style="padding-bottom: 5px;padding-left:0px;">
	        	<a href="#" onclick="printaccreditation()" style="display: none;" class="hide isadmin select-printaudittrail"><i class="glyphicon glyphicon-print blue"></i>&nbsp;&nbsp;Print</a>
	      	</div>
	      	<div class="col-md-3"></div>
	      	<div class="col-md-2" style="padding-bottom: 5px;padding-right:0px;">
	        	<button class="btn btn-sm btn-info hide isadmin select-createnewscheduleforaccreditation btn-round" style="width: 100%;" onclick="CreateNewAccredSched()">New Schedule</button>
	      	</div>
	    </div>
	    <div class="row form-group" style="margin-bottom: 0px !important;">
	      	<div class="parent">
		        <table class="table table-bordered table-striped fixTable">
		          	<thead>
			            <tr>
			              	<th width="16%">Date of Accreditation</th>
			              	<th width="10%">Tenant ID</th>
			              	<th width="20%" class="thSysTenant">Trade Name</th>
			              	<th width="17%">Name of POS Provider</th>
			              	<th width="17%">Software Version</th>
			              	<th width="10%">Status</th>
			              	<th width="10%">Options</th>
			            </tr>
		          	</thead>
		          	<tbody id="tblAccreditationList"></tbody>
		        </table>
	      	</div>
	      	<table class="tabledash_footer table" style="margin: 0px !important;">
		        <thead>
		          	<tr>
			            <th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
			              	<font id="txtAccreditationEntries" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
			              	<input id="txt_userpageAccreditation" type="hidden">
			              	<ul id="ulPaginationAccreditation" class="pagination pull-right"></ul>
			            </th>
		          	</tr>
		        </thead>
	      	</table>
	    </div>
  	</div>
</div>

<div class="modal fade fade-scale" id="CreateNewAccredSched" role="dialog" area-hidden="true" data-keyboard="false" data-backdrop="static">
  	<div class="modal-dialog modal-lg" style="width: 85%;">
	    <div class="modal-content">
	      	<div class="modal-header">
	        	<button type="button" class="close" onclick='confirmSaveandClear();'>&times;</button>
	        	<h4 class="modal-title" style="font-size: 18px;">New Accreditation Schedule</h4>
	      	</div>
	      	<div class="modal-body" style="display: block;">
		        <div class="row">
		          	<div class="col-md-12">
			            <div class="row form-group">

			              	<!-- Tenant Information -->
			            	<div class="col-md-12">
			            		<div class="widget-container-col ui-sortable" id="widget-container-col-12">
									<div class="widget-box transparent ui-sortable-handle" id="widget-box-12">
										<div class="widget-header">
											<h4 class="widget-title">Tenant Information</h4>
											<!-- <div class="widget-toolbar no-border">
					                        	<a href="#" data-action="collapse" class="clicktoshowall" id="divTenantInformation">
					                          		<i class="ace-icon fa fa-chevron-down"></i>
					                        	</a>
					                      	</div> -->
										</div>
										<div class="widget-body">
											<div class="widget-main">
												<div class="row well">
						                          	<div class="row form-group">
							                            <div class="col-md-12">
							                              	<h4 class="green">Tenant Information</h4>
							                            </div>
						                          	</div>
						                          	<div class="row form-group">
					                          			<div class="col-md-2">
					                                  		Tenant ID
					                          			</div>
					                          			<div class="col-md-4"> 
					                                  		<select class="form-control AccredReq" id="txtAccredTenant"></select>
					                          			</div>
					                          			<div class="col-md-2 pull-right">
					                                		<input type="text" class="form-control date-picker AccredReq ViewAccred" value="<?php echo date('m/d/Y'); ?>" id="txtAccredDate">
					                          			</div>
					                          			<div class="col-md-2 pull-right">
					                                		Accreditation Date
					                          			</div>
						                          	</div>
						                          	<div class="row form-group frmEditOnly">
						                          		<div class="col-md-12">
						                          			<button class="btn btn-info btn-sm pull-right ViewAccred btn-round" onclick="InputAccredEntries();">Create New Logs</button>
						                          		</div>
						                          	</div>
						                          	<div class="row form-group frmEditOnly">
						                          		<div class="parent2">
					                          				<table class="table table-bordered table-striped fixTable">
					                          					<thead>
					                          						<tr>
					                          							<th width="15%">Date</th>
										        						<th width="15%">Time</th>
										        						<th width="15%">Result</th>
										        						<th width="55%" style="z-index: 1;">Attachments</th>
					                          						</tr>
					                          					</thead>
					                          					<tbody id="tblAccredLogs"></tbody>
					                          				</table>
						                          		</div>
						                          	</div>
						                        </div>
											</div>
										</div>
									</div>
								</div>
			            	</div>
			              
			              	<!-- Accreditation Information -->
			              	<div class="col-md-12">
				                <div class="widget-container-col ui-sortable" id="widget-container-col-12">
				                  	<div class="widget-box transparent ui-sortable-handle" id="widget-box-12">
					                    <div class="widget-header">
					                      	<h4 class="widget-title">Accreditation Information</h4>
					                      	<!-- <div class="widget-toolbar no-border">
					                        	<a href="#" data-action="collapse" class="clicktoshowall" id="divPOSInformation">
					                          		<i class="ace-icon fa fa-chevron-down"></i>
					                        	</a>
					                      	</div> -->
					                    </div>

					                    <div class="widget-body">
					                      	<div class="widget-main">
						                        <div class="row well">
						                          	<div class="row form-group">
						                           	 	<div class="col-md-6">
						                           	 		<div class="row form-group">
									                            <div class="col-md-12">
									                              	<h4 class="green">POS Information</h4>
									                            </div>
								                          	</div>
						                              		<div class="row form-group">
								                                <div class="col-md-4">
								                                  	Retail Partner Name
								                                </div>
								                                <div class="col-md-8">
								                                	<input type="text" class="form-control AccredReq ViewAccred" id="txtAccredPartnerName">
								                                </div>
						                              		</div>
						                              		<div class="row form-group">
								                                <div class="col-md-4">
								                                  	Name of POS Provider
								                                </div>
								                                <div class="col-md-8">
								                                	<input type="text" class="form-control AccredReq ViewAccred" id="txtAccredPosProvider">
								                                </div>
						                              		</div>
						                              		<div class="row form-group">
								                                <div class="col-md-4">
								                                  	Software Version
								                                </div>
								                                <div class="col-md-8">
								                                	<input type="text" class="form-control AccredReq ViewAccred" id="txtAccredSoftwareVersion">
								                                </div>
						                              		</div>
						                              		<div class="row form-group">
								                                <div class="col-md-4">
								                                  	Operating System
								                                </div>
								                                <div class="col-md-8">
								                                	<input type="text" class="form-control AccredReq ViewAccred" id="txtAccredOperatingSystem">
								                                </div>
						                              		</div>
						                              		<div class="row form-group">
								                                <div class="col-md-4">
								                                  	Number Of POS
								                                </div>
								                                <div class="col-md-8">
								                                	<input type="text" class="form-control AccredReq ViewAccred numonly" id="txtAccredNumberOfPOS">
								                                </div>
						                              		</div>
						                              		<div class="row form-group">
						                          				<div class="col-md-4">
						                          					Service Charge
						                          				</div>
						                          				<div class="col-md-8">
						                          					<div class="col-md-4">
						                          						<div class="radio">
										                                    <label>
										                                      	<input name="radServiceCharge" type="radio" class="ace radServiceCharge ViewAccred" id="ServiceChargeYes">
										                                      	<span class="lbl">&nbsp;Yes</span>
										                                    </label>
										                                </div>
						                          					</div>
						                          					<div class="col-md-4">
						                          						<div class="radio">
										                                    <label>
										                                      	<input name="radServiceCharge" type="radio" class="ace radServiceCharge ViewAccred" id="ServiceChargeNo">
										                                      	<span class="lbl">&nbsp;No</span>
										                                    </label>
										                                </div>
						                          					</div>
						                          					<div class="col-md-4">
						                          						<span class="block input-icon input-icon-right">
																			<input type="text" id="ServiceChargeVal" class="form-control numonly ViewAccred" readonly maxlength="2">
																			<i class="ace-icon fa fa-percent"></i>
																		</span>
						                          					</div>
						                          				</div>
						                          			</div>
						                          			<div class="row form-group">
						                          				<div class="col-md-4">
						                          					Local Tax
						                          				</div>
						                          				<div class="col-md-8">
						                          					<div class="col-md-4">
						                          						<div class="radio">
										                                    <label>
										                                      	<input name="radLocalTax" type="radio" class="ace radLocalTax ViewAccred" id="LocalTaxYes">
										                                      	<span class="lbl">&nbsp;Yes</span>
										                                    </label>
										                                </div>
						                          					</div>
						                          					<div class="col-md-4">
						                          						<div class="radio">
										                                    <label>
										                                      	<input name="radLocalTax" type="radio" class="ace radLocalTax ViewAccred" id="LocalTaxNo">
										                                      	<span class="lbl">&nbsp;No</span>
										                                    </label>
										                                </div>
						                          					</div>
						                          					<div class="col-md-4">
						                          						<span class="block input-icon input-icon-right">
																			<input type="text" id="LocalTaxVal" class="form-control numonly ViewAccred" readonly maxlength="2">
																			<i class="ace-icon fa fa-percent"></i>
																		</span>
						                          					</div>
						                          				</div>
						                          			</div>
						                            	</div>
						                            	<div class="col-md-6">
						                            		<div class="row form-group">
						                            			<div class="col-md-12">
                              										<h4 class="green">Nature of POS</h4>
						                            			</div>
						                            		</div>
							                              	<div class="row form-group">
								                                <div class="col-xs-6 col-md-6">
								                                  	<label>
									                                    <input name="form-field-checkbox" class="ace chkNatureOfPos ViewAccred" id="Food" value="Food" type="checkbox" />
									                                    <span class="lbl"> Food </span>
								                                  	</label>
								                                </div>
								                                <div class="col-xs-6 col-md-6">
								                                  	<label>
									                                    <input name="form-field-checkbox" class="ace chkNatureOfPos ViewAccred" id="Grocery" value="Grocery" type="checkbox" style="border-color: red;" />
									                                    <span class="lbl"> Grocery </span>
								                                  	</label>
								                                </div>
							                              	</div>
							                              	<div class="row form-group">
								                                <div class="col-xs-6 col-md-6">
								                                  	<label>
									                                    <input name="form-field-checkbox" class="ace chkNatureOfPos ViewAccred" id="Retail" value="Retail" type="checkbox" />
									                                    <span class="lbl"> Retail </span>
								                                  	</label>
								                                </div>
								                                <div class="col-xs-6 col-md-6">
								                                  	<label>
									                                    <input name="form-field-checkbox" class="ace chkNatureOfPos ViewAccred" id="Service" value="Service" type="checkbox" />
									                                    <span class="lbl"> Service </span>
								                                  	</label>
								                                </div>
							                              	</div>
							                              	<div class="row form-group">
								                                <div class="col-xs-6 col-md-6">
								                                  	<label>
									                                    <input name="form-field-checkbox" class="ace chkNatureOfPos ViewAccred" id="Pharmaceutical" value="Pharmaceutical" type="checkbox" />
									                                    <span class="lbl"> Pharmaceutical </span>
								                                  	</label>
								                                </div>
							                              	</div>
							                              	<div class="row form-group">
								                                <div class="col-md-12">
								                                  	<h4 class="green">CSV File Generator Requirements</h4>
								                                </div>
								                            </div>
								                            <div class="row form-group">
								                            	<div class="col-md-12">
								                                  	<label>
									                                    <input name="form-field-checkbox2" class="ace chkFileGeneratorStat ViewAccred" id="Automatic" type="checkbox" />
									                                    <span class="lbl"> Auto Generation of textfile upon end of day/Z-reading report </span>
								                                  	</label>
								                           	 	</div>
								                            	<div class="col-md-12">
								                                  	<label>
									                                    <input name="form-field-checkbox2" class="ace chkFileGeneratorStat ViewAccred" id="Manual" type="checkbox" />
									                                    <span class="lbl"> Manual generation of textfile with data back track capability </span>
								                                  	</label>
								                           	 	</div>
								                            </div>
								                            <div class="row form-group">
								                                <div class="col-md-12">
								                                  	Remarks
								                                </div>
								                                <div class="col-md-12">
								                                	<textarea style="height: 90px;resize: none;" class="form-control AccredReq ViewAccred" id="txtAccredRemarks"></textarea>
								                                </div>
						                              		</div>
						                            	</div>
						                            </div>
						                            <div class="row form-group">
						                            	<div class="col-md-3">
						                            		<div class="row form-group">
					                            				<div class="col-md-12">
                              										<h4 class="green">Contact Information</h4>
                              									</div>
					                            			</div>
							                            	<div class="row form-group" style="height: 300px;overflow-y: scroll;overflow-x: hidden;">
							                            		<div class="col-md-12">
							                            			<div class="row form-group">
							                            				<div class="col-md-4">
							                            					Mobile No.
							                            				</div>
							                            				<div class="col-md-8" id="txtMobileNumber"></div>
							                            			</div>
							                            			<div class="row form-group">
							                            				<div class="col-md-4">
							                            					Telephone No.
							                            				</div>
							                            				<div class="col-md-8" id="txtTelephoneNumber"></div>
							                            			</div>
						                            			</div>
						                            		</div>
							                            </div>
						                            	<div class="col-md-3">
						                            		<div class="row form-group">
					                            				<div class="col-md-12">
                              										<h4 class="green">Authorized Representatives</h4>
                              									</div>
					                            			</div>
					                            			<div class="row form-group" style="height: 300px;overflow-y: scroll;overflow-x: hidden;">
							                            		<div class="col-md-12">
							                            			<div class="row form-group">
							                            				<div class="col-md-12" id="txtAuthorizedRep"></div>
							                            			</div>
						                            			</div>
						                            		</div>
							                            </div>
							                            <div class="col-md-3">
							                            	<div class="row form-group">
							                            		<div class="col-md-12">
                              										<h4 class="green">Accreditor's Representative(s)</h4>
							                            		</div>
							                            	</div>
							                            	<div class="row form-group" style="height: 300px;overflow-y: scroll;overflow-x: hidden;">
							                            		<div class="col-md-12">
							                            			<div class="row form-group">
							                            				<div class="col-md-12" id="txtAccreditorsRep"></div>
							                            			</div>
						                            			</div>
						                            		</div>
							                            </div>
							                            <div class="col-md-3">
							                            	<div class="row form-group">
							                            		<div class="col-md-12">
							                            			<h4 class="green">Machine Number</h4>
							                            		</div>
							                            	</div>
							                            	<div class="row form-group" style="height: 300px;overflow-y: scroll;overflow-x: hidden;">
							                            		<div class="col-md-12">
							                            			<div class="row form-group">
					                            						<div class="col-md-12" id="txtMachineNumber"></div>
							                            			</div>
							                            		</div>
							                            	</div>
							                            </div>
							                        </div>
							                        <div class="row form-group">
						                            	<div class="col-md-6">
						                            		<div class="row form-group">
								                                <div class="col-md-10">
								                                  	<h4 class="green">Payment Types</h4>
								                                </div>
								                                <div class="col-md-2" style="margin-top: -9px;">
								                            		<button class="btn btn-xs btn-info pull-right ViewAccred btn-round" onclick='fncAccredPaymentTypes();$("#mdl_AccredPaymentType").modal("show");'>Browse Payment Types</button>
								                            	</div>
								                            </div>
								                            <div class="row form-group">
								                            	<div class="col-md-12">
									                            	<div style="height: 300px;">
									                          			<table class="table table-bordered table-striped fixTable">
									                          				<thead>
									                          					<tr>
									                          						<th width="95%">Paymant Type</th>
									                          						<th width="5%" style="z-index: 1;">Option</th>
									                          					</tr>
									                          				</thead>
									                          				<tbody id="tblAccredPaymentTypeList"></tbody>
									                          			</table>
									                          		</div>
									                          	</div>
								                            </div>
							                            </div>
							                            <div class="col-md-6">
							                            	<div class="row form-group">
							                            		<div class="col-md-12">
							                            			<h4 class="green">Documents</h4>
							                            		</div>
							                            	</div>
									                        <form id="frmAccreditation" name="frmAccreditation">
							                            		<div id="txtDocument" style="height: 300px;overflow-y: scroll;overflow-x: hidden;"></div>
							                            		<input type="hidden" id="AccredDocCount" name="AccredDocCount">
							                            		<input type="hidden" id="AccredID" name="AccredID">
									                       	</form>
							                            	<div class="row form-group">
							                            		 <div class="col-md-12">
								                                    <button class="btn btn-sm btn-success pull-right ViewAccred btn-round" onclick="div_AddNewFieldDocument()"><i class="fa fa-plus"></i> Add New Attachment</button>
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
		        </div>
	      	</div>
	      	<div class="modal-footer">
	        	<button class="btn btn-primary ViewAccred btn-sm btn-round" onclick="SaveNewAccredSched()"><i class="fa fa-check"></i>&nbsp;Save</button>
	      	</div>
	    </div>  
  	</div>
</div>

<div class="modal fade fade-scale" id="mdl_AccredPaymentType" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  	<div class="modal-dialog modal-md">
	    <div class="modal-content">
	      	<div class="modal-header">
	          	<button type="button" class="close" data-dismiss="modal">&times;</button>
	          	<h4 class="modal-title" style="font-size: 18px;">Select Payment Type</h4>
	      	</div>
	      	<div class="modal-body">
		        <div class="input-group col-xs-12 col-md-12 col-lg-12">
		          	<input type="text" class="form-control" id="txtsearchpaymenttype" onkeyup="tblpaymenttypelist()" placeholder="Search Payment Type">
		          	<span class="input-group-btn">
		            	<button type="button" class="btn btn-sm btn-success btn-round" onclick="$('#mdl_AddNewAccredRefPT').modal('show');">
		              		<span class="fa fa-plus" style="font-size: 15px;margin-top: 2px;"></span>
		            	</button>
		          	</span>
		        </div>
		        <div class="row">
		          	<div class=" col-xs-12 col-md-12 col-lg-12">
			            <div style="margin-top: 20px;height: 300px;"> 
			              	<table class="table table-bordered table-striped fixTable">
				                <thead>
				                  	<tr>
					                    <th width="30%">ID</th>
					                    <th width="70%">Payment Type</th>                   
				                  	</tr>
				                </thead>
				                <tbody id="mdl_tblAccredPaymentTypeList"></tbody>
			              	</table>
			            </div>
		          	</div>
		        </div>
	      	</div>
	      	<div class="modal-footer">
	            <button class="btn btn-sm btn-danger btn-round" onclick="$('#mdl_AccredPaymentType').modal('hide');">Close</button>
	      	</div>
	    </div>
  	</div>
</div>

<div class="modal fade fade-scale" id="mdl_AddNewAccredRefPT" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  	<div class="modal-dialog modal-sm">
    	<div class="modal-content">
	      	<div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title" style="font-size: 18px;">Add New Category</h4>
	      	</div>
	      	<div class="modal-body">
		        <div class="row container-fluid">
		          	<div class="col-xs-12 col-md-12 col-lg-12">
			            <div class="row form-group">
			              	<div class="col-xs-12 col-md-12 col-lg-12">
			                  	Payment Type ID
			              	</div>
		              		<div class="col-xs-12 col-md-12 col-lg-12">
		                  		<input type="text" class="form-control" id="txtAccreditationPaymentTypeID">
		              		</div>
		            	</div>
			            <div class="row form-group">
			              	<div class="col-xs-12 col-md-12 col-lg-12">
			                  	Payment Type Description
			              	</div>
			              	<div class="col-xs-12 col-md-12 col-lg-12">
			                  	<input type="text" class="form-control" id="txtAccreditationPaymentTypeDesc">
			              	</div>
			            </div>
		          	</div>
		        </div>
	      	</div>
	      	<div class="modal-footer">
		        <button class="btn btn-sm btn-primary btn-round" onclick="SaveNewAccredPTRef()"><i class="fa fa-check"></i>&nbsp;Save</button>
	      	</div>
	    </div>
  	</div>
</div>

<div class="modal fade fade-scale" id="mdl_AccredEntries" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  	<div class="modal-dialog modal-md">
    	<div class="modal-content">
	      	<div class="modal-header">
		        <button type="button" class="close" onclick="CloseAndClearNewLogsForm();">&times;</button>
		        <h4 class="modal-title" style="font-size: 18px;">New Accreditation Logs</h4>
	      	</div>
	      	<div class="modal-body">
	      		<div class="row">
	      			<div class="col-md-12">
			      		<div class="row form-group">
			      			<div class="col-md-12">
			      				<div class="widget-body">
			      					<div class="widget-main">
					      				<div class="row well">
					      					<div class="row form-group">
					      						<div class="col-md-6">
					      							<div class="row form-group">
					      								<div class="col-md-4">
					      									Date
					      								</div>
					      								<div class="col-md-8">
					      									<input type="text" class="form-control" id="txtNewAccredLogsDate" readonly>
					      								</div>
					      							</div>
					      							<div class="row form-group">
					      								<div class="col-md-4">
					      									Time
					      								</div>
					      								<div class="col-md-8">
					      									<input type="time" class="form-control" id="txtNewAccredLogsTime">
					      								</div>
					      							</div>
					      							<div class="row form-group">
					      								<div class="col-md-4">
					      									Result
					      								</div>
					      								<div class="col-md-4">
					      									<div class="radio">
																<label>
																	<input name="form-field-radio" type="radio" class="ace radAccredLogsResult" id="Passed" checked>
																	<span class="lbl"> Pass</span>
																</label>
															</div>
					      								</div>
					      								<div class="col-md-4">
					      									<div class="radio">
																<label>
																	<input name="form-field-radio" type="radio" class="ace radAccredLogsResult" id="Failed">
																	<span class="lbl"> Fail</span>
																</label>
															</div>
					      								</div>
					      							</div>
					      						</div>
					      						<div class="col-md-6">
					      							<div class="row form-group">
					      								<form id="frmAccreditation2" name="frmAccreditation2">
					      									<div id="div_AccredLogsAttachment" style="height: 120px;overflow-y: scroll;"></div>
					      									<input type="hidden" id="AccredDocCount2" name="AccredDocCount">
						                            		<input type="hidden" id="AccredID2" name="AccredID">
							                            	<input type="hidden" id="AccredLogsID" name="AccredLogsID">
									                   	</form>
					      							</div>
					      							<div class="row form-group">
					      								<div class="col-md-12">
		                									<button class="btn btn-sm btn-success pull-right btn-round" onclick="AppendAccredEntriesAttachment()"><i class="fa fa-plus"></i> Add New Attachment</button>
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
	      		<button class="btn btn-primary btn-sm btn-round" onclick="SaveNewAccredLogs();"><i class="fa fa-check"></i>&nbsp;Save</button>
	      	</div>
	    </div>
  	</div>
</div>

<?php  
	include("script.php");
?>