<div class="page-header">
    <div class="row form-group" style="margin-bottom: 0px;padding-top:10px;background-color: #edf4f8;padding-bottom: 10px;">
        <div class="col-md-3">
            <h1 style="font-weight: bold;">INQUIRY</h1>
        </div>
        <div class="col-md-9">
            <!-- <span class='pull-right arrowed-in-right arrowed label label-xlg label-danger'>Disapproved Application</span> -->
            <!-- <span class='pull-right arrowed-in-right arrowed label label-xlg label-danger'>Cancelled Reservation</span> -->
            <span class='pull-right arrowed-in-right arrowed label label-xlg label-warning'>Occupied</span>
            <span class='pull-right arrowed-in-right arrowed label label-xlg label-success'>Confirmed</span>
            <span class='pull-right arrowed-in-right arrowed label label-xlg label-info'>Awarded</span>
            <span class='pull-right arrowed-in-right arrowed label label-xlg label-yellow'>For Awarding</span>
            <span class='pull-right arrowed-in-right arrowed label label-xlg label-pink'>Pending</span>
                <span class='label label-xlg label-inverse arrowed-in-right arrowed pull-right bold'>Inquired</span>
        </div>
    </div>
</div>

<div class="row">
  	<div class="col-md-12">
		<div class="row form-group" style="margin-bottom: 0px;">
		  	<div class="col-md-2 col-xs-12" style="padding-bottom: 5px;padding-left: 0px;">
				<span class="input-icon" style="width: 100%;">
				  	<input type="text" class="form-control" id="txtSearchSubLeadsINQ" title="Search" placeholder="Search">
				  	<i class="ace-icon fa fa-search nav-search-icon"></i>
				</span>
		  	</div>
		  	<div class="col-md-4" style="padding-bottom: 5px;padding-left:0px;">
			  	<h5><a onclick="loadLInquiryFilter('LInquiry')" id="LINK_LInquiry_filter" class="popover-info" data-rel="popover" data-placement="bottom" title="Filter by" data-content='
					<fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
						<legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:95px;">&nbsp;&nbsp;Search by&nbsp;&nbsp;</legend>
						<div class="form-group row" style="margin:0px;">
						  	<div class="col-md-6">
								<label>
								   	<input name="form-field-SubLeadsINQ" class="ace ace-checkbox-2 inquiry_module_filter" type="checkbox" value="Company_Name" id="filter_Company_Name">
								   	<span class="lbl"> Company</span>
								</label>
						  	</div>
						  	<div class="col-md-6">
								<label>
									<input name="form-field-SubLeadsINQ" class="ace ace-checkbox-2 inquiry_module_filter" type="checkbox" value="Trade_Name" id="filter_Trade_Name">
                                    <span class="lbl"> <span class="thSysTenant"></span></span>
								</label>
						  	</div>
						</div>
					</fieldset>

					<fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
					  	<legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:100px;">&nbsp;&nbsp;Filter Status&nbsp;&nbsp;</legend>
						<div class="form-group row" style="margin:0px;">
						  	<div class="col-md-4">
								<label class="label label-inverse arrowed-in-right arrowed label-lg">
								  	<input name="form-field-SubLeadsINQStat" class="ace" type="checkbox" value="Inquired" id="filter_Inquired">
								  	<span class="lbl"> Inquired</span>
								</label>
						  	</div>
						  	<div class="col-md-4">
								<label class="label label-pink arrowed-in-right arrowed label-lg">
								  	<input name="form-field-SubLeadsINQStat" class="ace" type="checkbox" value="Pending" id="filter_Pending">
								  	<span class="lbl"> Pending</span>
								</label>
						  	</div>
						  	<div class="col-md-4">
                                <label class="label label-lg label-yellow arrowed-in-right arrowed">
                                    <input name="form-field-SubLeadsINQStat" class="ace" type="checkbox" value="ForAwarding" id="filter_ForAwarding">
                                    <span class="lbl"> For Awarding</span>
                                </label>
                            </div>
						</div>
						<div class="form-group row" style="margin:0px;">
						  	<div class="col-md-4">
								<label class="label label-info arrowed-in-right arrowed label-lg">
								  	<input name="form-field-SubLeadsINQStat" class="ace" type="checkbox" value="Awarded" id="filter_Awarded">
								  	<span class="lbl"> Awarded</span>
								</label>
						  	</div>
						  	<div class="col-md-4">
								<label class="label label-success arrowed-in-right arrowed label-lg">
								  	<input name="form-field-SubLeadsINQStat" class="ace" type="checkbox" value="Confirmed" id="filter_Confirmed">
								  	<span class="lbl"> Confirmed</span>
								</label>
						  	</div>
						  	<div class="col-md-4">
								<label class="label label-warning arrowed-in-right arrowed label-lg">
								  	<input name="form-field-SubLeadsINQStat" class="ace" type="checkbox" value="Occupied" id="filter_Occupied">
								  	<span class="lbl"> Occupied</span>
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
								  	<span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
								  	<input class="form-control div_app date-picker" type="text" name="" id="txtSubLeadsINQStartDate" data-provide="datepicker">
								</div>
						  	</div>
						  	<div class="col-md-5">
								<div class="input-group">
								  	<span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
								  	<input class="form-control div_app date-picker" type="text" name="" id="txtSubLeadsINQEndDate" data-provide="datepicker">
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
						  	<button class="btn btn-xs btn-info btn-round" onclick="saveLInquiryFilter()" style="float:right;margin-bottom:10px;margin-right:10px;width:80px;">OK</button>
						</div>
				  	</div>'><i class="fa fa-filter bigger-110"></i>&nbsp;&nbsp;Select Filter here</a></h5>
		  	</div>
			<div class="col-md-4" style="padding-bottom: 5px;text-align: right;"></div>
		  	<div class="col-md-2 col-xs-12" style="padding-bottom: 5px;padding-right: 0px;">
				<a href="#" class="btn btn-info btn-sm hide isadmin select-addinquiry btn-round" style="width: 100% !important;" onclick="fncNewInquiry();">New Inquiry</a>
		  	</div>
		</div>
		<div class="row form-group" style="margin-bottom: 0px !important;">
		  	<div class="parent">
				<table class="table table-bordered fixTable">
				  	<thead>
						<tr>
						  	<th>Inquiry Date<span class="btnsortdash-inquiry fa fa-sort bigger-130 pull-right" id="date_inquired"></span></th>
						  	<th class="thSysTenant">Name<span class="btnsortdash-inquiry fa fa-sort bigger-130 pull-right" id="Trade_Name"></span></th>
						  	<th class="hide_mobile">Company Name<span class="btnsortdash-inquiry fa fa-sort bigger-130 pull-right" id="Company_Name"></span></th>
						  	<th>Contact Person<span class="btnsortdash-inquiry fa fa-sort bigger-130 pull-right" id="content"></span></th>
						  	<th>Telephone No.<span class="btnsortdash-inquiry fa fa-sort bigger-130 pull-right" id="content"></span></th>
						  	<th>Mobile No.<span class="btnsortdash-inquiry fa fa-sort bigger-130 pull-right" id="content"></span></th>
						  	<th>Email<span class="btnsortdash-inquiry fa fa-sort bigger-130 pull-right" id="content"></span></th>
						  	<th>Source<span class="btnsortdash-inquiry fa fa-sort bigger-130 pull-right" id="inqSource"></span></th>
						  	<th>Process Owner<span class="btnsortdash-inquiry fa fa-sort bigger-130 pull-right" id="deptDesc"></span></th>
						  	<th style='z-index: 1;' class="hide_mobile">Status<span class="btnsortdash-inquiry fa fa-sort bigger-130 pull-right" id="STATUS"></span></th>
						  	<th style='z-index: 1;'>Option</th>
						</tr>
				  	</thead>
				  	<tbody id="tblSUbLeadsINQ"></tbody>
				</table>
		  	</div>
		  	<table class="tabledash_footer table" style="margin: 0px !important;">
	            <thead>
	                <tr>
	                  	<th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
		                    <font id="txtSubLeadsInqEnt" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
		                    <input id="SubLeadsINQPageCount" type="hidden">
		                    <ul id="ulSubLeadsInqPage" class="pagination pull-right"></ul>
	                  	</th>
	                </tr>
              	</thead>
            </table>
		</div>
  	</div>
</div>

	<input type="hidden" id="InquirySortType" value="ASC">
	<input type="hidden" id="InquirySortBy" value="date_inquired">
<?php
	include("global_form/index.php");
	include("global_events/index.php");
	include("script.php");
?>