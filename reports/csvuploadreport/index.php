<div class="row">
  	<div class="col-md-12">
	    <div class="row form-group" style="margin-bottom: 0px;"> 
	      	<div class="col-md-2" style="padding-bottom: 5px;padding-left:0px;">
		        <span class="input-icon" style="width: 100%;">
		          	<input type="text" class="form-control" placeholder="Search" title="Search" id="txtsearchCSVUploadReports">
		          	<i class="ace-icon fa fa-search nav-search-icon"></i>
		        </span>
	      	</div>
	      	<div class="col-md-3" style="padding-bottom: 5px;padding-left:0px;">
	        	<h5>
					<a onclick="loadCSVUploadReportsFilter('CSVUploadReports')" id="LINK_CSVUploadReports_filter" class="popover-info" data-rel="popover" data-placement="bottom" title="Filter by" data-content='
                        <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
                        	<legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:95px;">&nbsp;&nbsp;Search by&nbsp;&nbsp;</legend>
                            <div class="form-group row" style="margin:0px;">
                                <div class="col-md-12">
                                    <label>
                                        <input name="form-field-checkboxtradename" class="ace ace-checkbox-2 complaint_module_filter" type="checkbox" value="b.tradename" id="filter_b.tradename">
                                        <span class="lbl"> Store Name </span>
                                    </label>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
                        	<legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:100px;">&nbsp;&nbsp;Filter Status&nbsp;&nbsp;</legend>
                            <div class="form-group row" style="margin:0px;">
                                <div class="col-md-6" style="padding-right:0px;">
                                    <label style="margin-bottom: 0px;height:22px;padding-left:4px;">
                                        <input name="form-field-checkbox-csvcount" class="ace" type="checkbox" value="Complete" id="filter_Complete">
                                        <span class="lbl"> Complete</span>
                                    </label>
                                </div>
                                <div class="col-md-6" style="padding-right:0px;">
                                    <label style="margin-bottom: 0px;height:22px;padding-left:4px;">
                                        <input name="form-field-checkbox-csvcount" class="ace" type="checkbox" value="Incomplete" id="filter_Incomplete">
                                        <span class="lbl"> Incomplete</span>
                                    </label>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;" id="div_chkappdate">
                        	<legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:100px;">&nbsp;&nbsp;Date Range&nbsp;&nbsp;</legend>
                          	<div class="form-group row" style="margin:0px;">
	                            <div class="col-md-1"></div>
	                            <div class="col-md-5">
	                              	<div class="input-group">
		                                <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
		                                <input class="form-control date-picker" type="text" name="" id="CSVURDateFrom" data-provide="datepicker">
	                              	</div>                
	                            </div>
	                            <div class="col-md-5">
	                              	<div class="input-group">
		                                <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
		                                <input class="form-control date-picker" type="text" name="" id="CSVURDateTo" data-provide="datepicker">
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
                            	<button class="btn btn-xs btn-info" onclick="saveCSVUploadReportsFilter()" style="float:right;margin-bottom:10px;margin-right:10px;width:80px;">OK</button>
                          	</div>
                        </div>'>
                        <i class="fa fa-filter bigger-110"></i>&nbsp;&nbsp;Select Filter here
                    </a>
             	</h5>
	      	</div>
	      	<div class="col-md-5" style="padding-bottom: 5px;padding-left:0px;"></div>
	      	<div class="col-md-2" style="padding-bottom: 5px;padding-left:0px;">
	        	<h5 class="pull-right"><a onclick="loadMallSelection();" class="popover-info" data-rel="popover" data-placement="bottom" title="Print by" data-content='
		            <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
		                <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:130px;">&nbsp;&nbsp;Filter by <label class="txtSysBuilding">Mall</label>&nbsp;&nbsp;</legend>
	                    <div class="form-group row" style="margin:0px;">
	                        <select class="form-control" id="txtMallSelection" onchange="loadTenantSelection();"></select>
	                    </div>
		            </fieldset>

		            <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
		                <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:119px;">&nbsp;&nbsp;Filter by Tenant</label>&nbsp;&nbsp;</legend>
	                    <div class="form-group row" style="margin:0px;">
	                        <select class="form-control" id="txtTenantSelection"></select>
	                    </div>
		            </fieldset>

		            <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
                    	<legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:100px;">&nbsp;&nbsp;Filter Status&nbsp;&nbsp;</legend>
                        <div class="form-group row" style="margin:0px;">
                            <div class="col-md-6" style="padding-right:0px;">
                                <label style="margin-bottom: 0px;height:22px;padding-left:4px;">
                                    <input name="form-field-checkbox-printCSVUR" class="ace" type="checkbox" value="Complete">
                                    <span class="lbl"> Complete</span>
                                </label>
                            </div>
                            <div class="col-md-6" style="padding-right:0px;">
                                <label style="margin-bottom: 0px;height:22px;padding-left:4px;">
                                    <input name="form-field-checkbox-printCSVUR" class="ace" type="checkbox" value="Incomplete">
                                    <span class="lbl"> Incomplete</span>
                                </label>
                            </div>
                        </div>
                    </fieldset>

		          	<fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;">
		              	<div class="form-group row" style="margin:0px;">
		                    <div class="col-md-6">
		                      <div class="input-group">
		                        <span class="input-group-addon">
		                          <i class="fa fa-calendar bigger-110"></i>
		                        </span>
		                        <input class="form-control date-picker" type="text" id="CSVURDateFrom" data-provide="datepicker" value="<?php echo date('m/d/Y'); ?>">
		                      </div>                
		                    </div>
		                    <div class="col-md-6">
		                      <div class="input-group">
		                        <span class="input-group-addon">
		                          <i class="fa fa-calendar bigger-110"></i>
		                        </span>
		                        <input class="form-control date-picker" type="text" id="CSVURDateTo" data-provide="datepicker" value="<?php echo date('m/d/Y'); ?>">
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
		                    <button class="btn btn-xs btn-success" onclick="printCSVUR()" style="float:right;margin-bottom:10px;margin-right:10px;width:80px;">Print</button>
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
			              	<th width="5%">Date</th>
			              	<th width="45%">Trade Name</th>
			              	<th width="10%" style="z-index: 1;">Sales</th>
			              	<th width="10%" style="z-index: 1;">Discount</th>
			              	<th width="10%" style="z-index: 1;">Void</th>
			              	<th width="10%" style="z-index: 1;">Sales/Hour</th>
			              	<th width="10%" style="z-index: 1;">Payment Types</th>
			            </tr>
		          	</thead>
		          	<tbody id="tblUploadReportList"></tbody>
		        </table>
	      	</div>
	      	<table class="tabledash_footer table" style="margin: 0px !important;">
		        <thead>
		          	<tr>
			            <th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
			              	<font id="txtCSVUploadReportsEntries" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
			              	<input id="txt_userpageCSVUploadReports" type="hidden">
			              	<ul id="ulPaginationCSVUploadReports" class="pagination pull-right"></ul>
			            </th>
		          	</tr>
		        </thead>
	      	</table>
	    </div>
  	</div>
</div>

<div id="div_CSVURPrint" style="display: none;">
	<table style="width: 100%;" cellspacing="0" cellpadding="0">
      	<tbody id="template"></tbody>
  	</table>
  	<p style="font-size: 15px; text-align: right;">From:&nbsp;&nbsp;<label id="txtCSVURPrintDateFrom"></label>&nbsp;&nbsp;To&nbsp;&nbsp;<label id="txtCSVURPrintDateTo"></label></p>
  	<center style="font-size: 22px;font-weight: bold;background-color: #666;color: white;width: 100%;margin-top: -15px;">CSV Upload Reports</center>
  	<table style="width: 100%;">
      	<thead>
          	<tr>
          		<td width="5%" style="text-align: center;">Date</td>
              	<td width="55%" style="text-align: center;">Trade Name</td>
              	<td width="8%" style="text-align: center;">Sales</td>
              	<td width="8%" style="text-align: center;">Discount</td>
              	<td width="8%" style="text-align: center;">Void</td>
              	<td width="8%" style="text-align: center;">Sales/Hour</td>
              	<td width="8%" style="text-align: center;">Payment Types</td>
          	</tr>
          	<td colspan="7"><hr></td>
      	</thead>
      	<tbody id="tblUploadReportListPrint"></tbody>
  	</table>
</div>

<?php  
	include("script.php");
?>