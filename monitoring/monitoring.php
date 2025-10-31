<div class="page-header">
	<div class="row form-group" style="margin-bottom: 0px;padding-top:10px;background-color: #edf4f8;padding-bottom: 10px;">
      	<div class="col-md-3 col-xs-12">
          	<h1 style="font-weight: bold;">FILE MONITORING</h1>
      	</div>
      	<div class="col-md-9 col-xs-12">
            <div class="row form-group" style="margin-right: 1px;">
            	<span class="pull-right"><i class="center fa fa-flag orange bigger-120"></i>&nbsp;Not Accredited&nbsp;</span>
                <span class="pull-right"><i class="center fa fa-flag green bigger-120"></i>&nbsp;Accredited |&nbsp;</span>
                <span class="pull-right">&nbsp;Accreditation Status :&nbsp;</span>
			</div>
			<div class="row form-group" style="margin-right: 1px;">
				<span class="pull-right" title="SFTP account doesn't exist, username or password is wrong or connection failed."><i class="center fa fa-times-circle blue bigger-120"></i>&nbsp;Access Denied</span>
                <span class="pull-right" title="No file detected when file syncing is initiated"><i class="center fa fa-times-circle orange bigger-120"></i>&nbsp;File Not Found |&nbsp;</span>
				<span class="pull-right" title="CSV file doesn't meet the required standard"><i class="center fa fa-times-circle red bigger-120"></i>&nbsp;Failed |&nbsp;</span>
                <span class="pull-right" title="Successful upload"><i class="center fa fa-check-circle green bigger-120"></i>&nbsp;Success |&nbsp;</span>
                <span class="pull-right">&nbsp;Status :&nbsp;</span>
			</div>
      	</div>
  	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="row form-group" style="margin-bottom: 0px;">
			<div class="col-md-2" style="padding-bottom: 5px;padding-left: 0px;">
				<span class="input-icon" style="width: 100%;">
		            <input type="text" class="form-control" placeholder="Search" id="tenantName" title="Search">
		            <i class="ace-icon fa fa-search nav-search-icon"></i>
		        </span>
			</div>
			<div class="col-md-3" style="padding-bottom: 5px;padding-left: 0px;">
				<h5>
					<a onclick="loadFileMonitoringFilter('FileMonitoring')" id="LINK_FileMonitoring_filter" class="popover-info" data-rel="popover" data-placement="bottom" title="Filter by" data-content='
                        <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
                        	<legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:95px;">&nbsp;&nbsp;Search by&nbsp;&nbsp;</legend>
                            <div class="form-group row" style="margin:0px;">
                            	<div class="col-md-1"></div>
                                <div class="col-md-11">
                                    <label>
                                        <input name="form-field-checkboxtradename" class="ace ace-checkbox-2 complaint_module_filter" type="checkbox" value="b.tradename" id="filter_b.tradename">
                                    	<span class="lbl"> <span class="thSysTenant"></span></span>
                                    </label>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
                        	<legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:100px;">&nbsp;&nbsp;Filter Status&nbsp;&nbsp;</legend>
                            <div class="form-group row" style="margin:0px;">
                            	<div class="col-md-1"></div>
                                <div class="col-md-5" style="padding-right:0px;">
                                    <label>
                                        <input name="form-field-checkbox-csvcount" class="ace" type="checkbox" value="Complete" id="filter_Complete">
                                        <span class="lbl"> Complete</span>
                                    </label>
                                </div>
                                <div class="col-md-6" style="padding-right:0px;">
                                    <label>
                                        <input name="form-field-checkbox-csvcount" class="ace" type="checkbox" value="Incomplete" id="filter_Incomplete">
                                        <span class="lbl"> Incomplete</span>
                                    </label>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
                        	<legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:109px;">&nbsp;&nbsp;Tenant Status&nbsp;&nbsp;</legend>
                            <div class="form-group row" style="margin:0px;">
                            	<div class="col-md-1"></div>
                            	<div class="col-md-5" style="padding-right:0px;">
                            		<label style="margin-bottom: 0px;height:22px;padding-left:4px;">
										<input name="form-field-TenantStatus" class="ace" type="checkbox" value="Accredited" id="filter_Accredited">
	                                    <span class="lbl">&nbsp;<span class="fa fa-flag green bigger-120"></span>&nbsp;Accredited&nbsp;</span>
	                                </label>
								</div>
                                <div class="col-md-5" style="padding-right:0px;">
                            		<label style="margin-bottom: 0px;height:22px;padding-left:4px;">
                                        <input name="form-field-TenantStatus" class="ace" type="checkbox" value="NotAccredited" id="filter_NotAccredited">
	                                    <span class="lbl">&nbsp;<span class="fa fa-flag orange bigger-120"></span>&nbsp;Not Accredited&nbsp;</span>
                                    </label>
                                </div>
                            	<div class="col-md-1"></div>
                            </div>
                        </fieldset>

                        <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;" id="div_chkappdate">
                        	<legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:100px;">&nbsp;&nbsp;Date Range&nbsp;&nbsp;</legend>
                          	<div class="form-group row" style="margin:0px;">
	                            <div class="col-md-1"></div>
	                            <div class="col-md-5">
	                              	<div class="input-group">
		                                <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
		                                <input class="form-control date-picker" type="text" name="" id="transdatefrom" data-provide="datepicker">
	                              	</div>                
	                            </div>
	                            <div class="col-md-5">
	                              	<div class="input-group">
		                                <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
		                                <input class="form-control date-picker" type="text" name="" id="transdateto" data-provide="datepicker">
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
                            	<button class="btn btn-xs btn-info btn-round" onclick="saveFileMonitoringFilter()" style="float:right;margin-bottom:10px;margin-right:10px;width:80px;">OK</button>
                          	</div>
                        </div>'>
                        <i class="fa fa-filter bigger-110"></i>&nbsp;&nbsp;Select Filter here
                    </a>
             	</h5>
			</div>
			<div class="col-md-2" style="padding-bottom: 5px;padding-right: 0px;">
				<button class="btn btn-warning hide isadmin select-uploadfiles pull-right btn-sm btn-block btn-round" onclick="savecsv()" title="Sync files manually"><span class="fa fa-list"></span> Sync Files</button>
			</div>
			<div class="col-md-2" style="padding-bottom: 5px;padding-right: 0px;">
				<button class="btn btn-danger hide isadmin select-fmpostpenalty pull-right btn-sm btn-block btn-round" onclick="postPenalty()" title="Post a penalty to selected tenant/s"><span class="fa fa-paperclip"></span> Post Penalty</button>
			</div>
			<div class="col-md-2" style="padding-bottom: 5px;padding-right: 0px;">
				<button class="btn btn-success hide isadmin select-changesetup pull-right btn-sm btn-block btn-round" title="Set time of syncing files" onclick='modal_opensettingTIme();$("#settingTIme").modal("show");'><span class="glyphicon glyphicon-cog"></span> Setup</button>
			</div>
			<div class="col-md-1" style="padding-bottom: 5px;padding-left: 0px;">
				<h5 class="pull-right"><a onclick="showmallselection();" class="popover-info" data-rel="popover" data-placement="bottom" title="Print by" data-content='
		            <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
		                <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:130px;">&nbsp;&nbsp;Filter by <label class="txtSysBuilding">Mall</label>&nbsp;&nbsp;</legend>
	                    <div class="form-group row" style="margin:0px;">
	                        <select class="form-control" id="mallselect"></select>
	                    </div>
		            </fieldset>

		          	<fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;">
		              	<div class="form-group row" style="margin:0px;">
		                    <div class="col-md-6">
		                      <div class="input-group">
		                        <span class="input-group-addon">
		                          <i class="fa fa-calendar bigger-110"></i>
		                        </span>
		                        <input class="form-control date-picker" type="text" id="FMdateFrom" data-provide="datepicker" value="<?php echo date('m/d/Y'); ?>">
		                      </div>                
		                    </div>
		                    <div class="col-md-6">
		                      <div class="input-group">
		                        <span class="input-group-addon">
		                          <i class="fa fa-calendar bigger-110"></i>
		                        </span>
		                        <input class="form-control date-picker" type="text" id="FMdateTo" data-provide="datepicker" value="<?php echo date('m/d/Y'); ?>">
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
		                    <button class="btn btn-xs btn-success btn-round" onclick="printFMReports()" style="float:right;margin-bottom:10px;margin-right:10px;width:80px;">Print</button>
		                </div>
		            </div>'>
		        	<i class="glyphicon glyphicon-print bigger-110"></i>&nbsp;&nbsp;Print</a>
		    	</h5>			
			</div>
		</div>
		<div class="row form-group" style="margin-bottom: 0px !important;">
			<div class="parent">
				<table class="table table-bordered fixTable table-hover">
					<thead>
						<tr>
							<th width="2%" style="z-index: 1;">
								<center>
									<div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2" id="maincheckbox" onclick="tsekanlahat()">
										<label class="lbl" for="ace-settings-navbar"></label>
									</div>
								</center>
							</th>
							<th width="5%">Date<span class="btnsortdash-filemonitoring fa fa-sort bigger-130 pull-right" id="reportDate"></span></th>
		          			<th width="34%" class="thSysTenant">Tenant<span class="btnsortdash-filemonitoring fa fa-sort bigger-130 pull-right" id="tradename"></span></th>
							<th width="9%" style="z-index: 1;">Discount<span class="btnsortdash-filemonitoring fa fa-sort bigger-130 pull-right" id="discount"></span></th>
							<th width="9%" style="z-index: 1;">Hourly Sales<span class="btnsortdash-filemonitoring fa fa-sort bigger-130 pull-right" id="salesperhour"></span></th>
							<th width="9%" style="z-index: 1;">Return/Void<span class="btnsortdash-filemonitoring fa fa-sort bigger-130 pull-right" id="void_refund"></span></th>
		          			<th width="10%" style="z-index: 1;">Payment Types<span class="btnsortdash-filemonitoring fa fa-sort bigger-130 pull-right" id="paymenttype"></span></th>
							<th width="9%" style="z-index: 1;">Sales<span class="btnsortdash-filemonitoring fa fa-sort bigger-130 pull-right" id="sales"></span></th>
							<th width="15%">Penalty<span class="btnsortdash-filemonitoring fa fa-sort bigger-130 pull-right" id="penalty"></span></th>
						</tr>
					</thead>
					<tbody id="syncbody"></tbody>
	    		</table>
			</div>
			<table class="tabledash_footer table" style="margin: 0px !important;">
				<thead>
				  	<tr>
						<th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
							<font id="txtfilemonitoringenties" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
							<input id="txtfilemonitoringpages" type="hidden">
						  	<ul id="ulfilemonitoringpagination" class="pagination pull-right"></ul>
						</th>
				  	</tr>
				</thead>
		  	</table>
		</div>
	</div>
</div>

<div class="modal fade fade-scale" id="settingTIme">
	<div class="modal-dialog modal-xs">
		<div class="modal-content">
			<div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
        		<h4 class="modal-title" style="font-size: 18px;">File Syncing Setup</h4>
			</div>

			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12">
						<div class="container-fluid modules">
							<div class="panel panel-primary">
								<div class="panel-heading"></div>
								<div class="panel-body">
									<div class="row form-group">
										<div class="col-md-4">
											File Syncing Setup
										</div>
										<div class="col-md-8">
											<select class="form-control" onchange="filesyncsetup(this.value);" id="txtFileSyncType">
												<option value="1">Manual</option>
												<option value="0">Automatic</option>
											</select>
										</div>
									</div>
									<div class="row form-group">
										<div class="col-md-4">
											Source
										</div>
										<div class="col-md-8">
											<select class="form-control" id="slcCSVSource">
												<option value="Local">Local</option>
												<option value="SFTP">SFTP</option>
											</select>
										</div>
									</div>
				                    <fieldset style="border: 1px dotted #CCC;padding: 10px;" id="FileSyncManual">
				                      	<legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:96px;">&nbsp;&nbsp;Date Range&nbsp;&nbsp;</legend>
				                        <div class="form-group row" style="margin-bottom: 5px;">
				                        	<div class="col-md-12">				
												<div class="col-md-4">
													<div class="radio">
	                                                    <label>
	                                                        <input name="form-field-radio" type="radio" class="ace synctype" id="datetodaysync" name="synctype" value="2">
	                                                        <span class="lbl" style="color: #666;">&nbsp;&nbsp;Date Today</span>
	                                                    </label>
	                                                </div>
												</div>
											</div>
				                        	<div class="col-md-12">
												<div class="col-md-4">
													<div class="radio">
	                                                    <label>
	                                                        <input name="form-field-radio" type="radio" class="ace synctype" id="daterange" name="synctype" value="1">
	                                                        <span class="lbl" style="color: #666;">&nbsp;&nbsp;Date Range</span>
	                                                    </label>
	                                                </div>
												</div>
												<div class="pull right">
													<div class="col-md-4">
														<div class="input-group">
															<input type="text" class="form-control date-picker" id="dateFromsync" value="<?php echo date('m/d/Y'); ?>">
															<label class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
														</div>
													</div>
													<div class="col-md-4">
														<div class="input-group">
															<input type="text" class="form-control date-picker" id="dateTosync" value="<?php echo date('m/d/Y'); ?>">
															<label class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-12" id="FileSyncAuto">
												<div class="col-md-3">
													Syncing Time
												</div>
					                          	<div class="col-md-3">
													<select id="hours" class="form-control">
														<?php
															for ( $a = 1; $a<=12; $a++ ) {
																?>
																	<option value="<?php echo $a; ?>"><?php echo str_pad($a, 2, 0, STR_PAD_LEFT); ?></option>
																<?php
															}
														?>
													</select>
												</div>
												<div class="col-md-3">
													<select id="mins" class="form-control">
														<?php
															for ( $b = 0; $b<=59; $b++ ) {
																?>
																	<option value="<?php echo str_pad($b, 2, 0, STR_PAD_LEFT); ?>"><?php echo str_pad($b, 2, 0, STR_PAD_LEFT); ?></option>
																<?php
															}
														?>
													</select>
												</div>
												<div class="col-md-3">
													<select id="ampm" class="form-control">
														<option value="am">AM</option>
														<option value="pm">PM</option>
													</select>
												</div>
											</div>
				                        </div>                                            
				                    </fieldset>
				                    <fieldset style="border: 1px dotted #CCC;padding: 10px;display: none;">
				                      	<legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:70px;">&nbsp;&nbsp;Penalty&nbsp;&nbsp;</legend>
				                        <div class="form-group row" style="margin-bottom: 5px;">
				                        	<div class="col-md-4">
												Penalty (Unsync Files)
											</div>
				                          	<div class="col-md-8">
												<input type="text" class="form-control" id="UnsyncPenalty">
											</div>
				                        </div>                                            
				                    </fieldset>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="modal-footer">
				<button class="btn btn-primary btn-sm btn-round" onclick="saveTime()"><span class="fa fa-check"></span> Save</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade fade-scale" id="mdlPenaltyList" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Penalty List</h4>
            </div>
            <div class="modal-body">
                <div class="input-group col-xs-12 col-md-12 col-lg-12">
                    <input type="text" class="form-control" id="txtSchedSearchPenalty" placeholder="Search Penalty">
                </div>
                <div class="row">
                    <div class=" col-xs-12 col-md-12 col-lg-12">
                        <div style="margin-top: 20px;height: 500px;"> 
                        	<input type="hidden" id="txtCheckedPenalties">
                            <table class="table table-bordered table-hover fixTable">
                                <thead>
                                    <tr>
                                        <th style="width: 30%;">Code</th>
                                        <th style="width: 50%;">Description</th>                 
                                        <th style="width: 20%;">Amount</th>                 
                                    </tr>
                                </thead>
                                <tbody id="tblPenaltyList"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-sm btn-round" onclick="fncPostPenalties();">Post Selected</button>
            </div>
        </div>
    </div>
</div>

<div id="txtFileMonitoringPrint" style="display: none;">
 	<table style="width: 100%;" cellspacing="0" cellpadding="0">
      	<tbody id="template"></tbody>
  	</table>
	<span class="pull-right"><i class="center fa fa-times-circle bigger-120" style='color: #478FCA !important;'></i>&nbsp;Access Denied</span>
    <span class="pull-right"><i class="center fa fa-times-circle bigger-120" style='color: #FF892A !important;'></i>&nbsp;File Not Found |&nbsp;</span>
	<span class="pull-right"><i class="center fa fa-times-circle bigger-120" style='color: #A94442 !important;'></i>&nbsp;Failed |&nbsp;</span>
    <span class="pull-right"><i class="center fa fa-check-circle bigger-120" style='color: #3C763D !important;'></i>&nbsp;Success |&nbsp;</span>
    <span class="pull-right">&nbsp;Status :&nbsp;</span>
    <br>
  	<p style="font-size: 15px; text-align: right;">From:&nbsp;&nbsp;<label id="txtFileMonitoringPrintDateFrom"></label>&nbsp;&nbsp;To&nbsp;&nbsp;<label id="txtFileMonitoringPrintDateTo"></label></p>
  	<center style="font-size: 22px;font-weight: bold;background-color: #666;color: white;width: 100%;margin-top: -15px;">File Monitoring</center>
  	<table style="width: 100%;">
      	<thead>
          	<tr>
              	<td>Date</td>
              	<td class="thSysTenant">Tenant</td>
              	<td>Discount</td>
              	<td>Hourly Sales</td>
              	<td>Return/Void</td>
              	<td>Payment Types</td>
              	<td>Sales</td>
              	<td>Penalty</td>
          	</tr>
          	<td colspan="8"><hr></td>
      	</thead>
      	<tbody id="tblFileMonitoringPrint"></tbody>
  	</table>
</div>
<input type="hidden" id="FileMonitoringSortType" value="ASC">
<input type="hidden" id="FileMonitoringSortBy" value="tradename">
<?php include "script.php"; ?>