<style type="text/css">
.parent2 {
    height: 45vh;
}
.parent3 {
    height: 26vh;
}
</style>
<!-- START OF PAGE HEADER -->
<div class="page-header">
  	<div class="row form-group" style="margin-bottom: 0px;padding-top:10px;background-color: #edf4f8;padding-bottom: 10px;">
      	<div class="col-md-2 col-xs-12">
          	<h1 style="font-weight: bold;">RESERVATION</h1>
          	<h6 style="color:#2679B5;">&nbsp;&nbsp;&nbsp;List of Reservation</h6>
      	</div>
      	<div class="col-md-2"></div>
      	<div class="col-md-8 col-xs-12">
	        <div class="row form-group">
	          	<span class='pull-right label label-danger arrowed-in-right arrowed' style="margin-right: 10px;color: black;">Cancelled</span>
	          	<span class='pull-right label label-warning arrowed-in-right arrowed' style="margin-right: 5px;color: black;">Occupied</span>
	          	<span class='pull-right label label-primary arrowed-in-right arrowed' style="margin-right: 5px;color: black;">Reserved</span>
	          	<span class='pull-right label label-success arrowed-in-right arrowed' style="margin-right: 5px;color: black;">Approved</span>
	          	<span class="pull-right">All Status :&nbsp;</span>
	        </div>
      	</div>
  	</div>
</div>
<!-- END OF PAGE HEADER -->
<!-- START OF MAIN PAGE -->
<div class="row">
	<div class="col-xs-12">
		<div class="row form-group" style="margin-bottom: 0px;">
			<div class="col-md-2 col-xs-12" style="padding-bottom: 5px;padding-left: 0px;">
				<span class="input-icon" style="width: 100%;">
		        	<input type="text" class="form-control" id="txtsearchLMreservation" title="Search" placeholder="Search" onkeyup="showtblleasinginquirylist();">
		        	<i class="ace-icon fa fa-search nav-search-icon"></i>
		        </span>
		    </div>
	      	<div class="col-md-4" style="padding-bottom: 5px;padding-left:0px;">
	          	<h5><a onclick="loadLMReservationFilter('LMreservation')" id="LINK_Reservation_filter" class="popover-info" data-rel="popover" data-placement="bottom" title="Filter by" data-content='
		            <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
		              	<legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:95px;">&nbsp;&nbsp;Select by&nbsp;&nbsp;</legend>
		                <div class="form-group row" style="margin:0px;">
			                <div class="col-md-4">
			                    <label>
			                       <input name="form-field-checkboxlmres" class="ace ace-checkbox-2" type="checkbox" value="b.mallname" id="filter_b.mallname">
			                       <span class="lbl"> Company</span>
			                    </label>
			                </div>
		                  	<div class="col-md-4">
		                    	<label>
		                        	<input name="form-field-checkboxlmres" class="ace ace-checkbox-2" type="checkbox" value="a.Fullname" id="filter_a.Fullname">
		                        	<span class="lbl"> Name</span>
		                    	</label>
		                  	</div>
		                  	<div class="col-md-4">
		                    	<label>
		                        	<input name="form-field-checkboxlmres" class="ace ace-checkbox-2" type="checkbox" value="c.unitname" id="filter_c.unitname">
		                        	<span class="lbl"> Unit</span>
		                    	</label>
		                  	</div>
		                  	<div class="col-md-4">
			                    <label>
			                        <input name="form-field-checkboxlmres" class="ace ace-checkbox-2" type="checkbox" value="a.Mobile_No" id="filter_a.Mobile_No">
			                        <span class="lbl"> Mobile Number</span>
			                    </label>
		                  	</div>
			                <div class="col-md-4">
			                    <label>
			                        <input name="form-field-checkboxlmres" class="ace ace-checkbox-2" type="checkbox" value="a.EmailAddress" id="filter_a.EmailAddress">
			                        <span class="lbl"> Email Address</span>
			                    </label>
			                </div>
		                </div>
		            </fieldset>
	            
		            <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
		              	<legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:100px;">&nbsp;&nbsp;Filter Status&nbsp;&nbsp;</legend>
		                <div class="form-group row" style="margin:0px;">
		                  	<div class="col-md-3" style="padding-right:0px;">
		                    	<label class="label label-success" style="margin-bottom: 0px;height:22px;padding-left:4px;color: black;">
		                      		<input name="form-field-checkboxlmresstat" class="ace" type="checkbox" value="Approved" id="filter_Approved">
		                      		<span class="lbl"> Approved</span>
		                    	</label>
		                  	</div>
		                  	<div class="col-md-3" style="padding-right:0px;">
		                    	<label class="label label-primary" style="margin-bottom: 0px;height:22px;padding-left:4px;color: black;">
		                      		<input name="form-field-checkboxlmresstat" class="ace" type="checkbox" value="Reserved" id="filter_Reserved">
		                      		<span class="lbl"> Reserved</span>
		                    	</label>
		                  	</div>
		                  	<div class="col-md-3" style="padding-right:0px;">
		                    	<label class="label label-warning" style="margin-bottom: 0px;height:22px;padding-left:4px;color: black;">
		                      		<input name="form-field-checkboxlmresstat" class="ace" type="checkbox" value="Occupied" id="filter_Occupied">
		                      		<span class="lbl"> Occupied</span>
		                    	</label>
		                  	</div>
		                  	<div class="col-md-3">
		                    	<label class="label label-danger" style="margin-bottom: 0px;height:22px;padding-left:4px;color: black;">
			                      	<input name="form-field-checkboxlmresstat" class="ace" type="checkbox" value="Cancelled" id="filter_Cancelled">
			                      	<span class="lbl"> Cancelled</span>
		                    	</label>
		                  	</div>
		                </div>
		            </fieldset>

	            	<fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;" id="div_chkappdate">
	              		<legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:130px;">&nbsp;&nbsp;Application Date&nbsp;&nbsp;</legend>
		                <div class="form-group row" style="margin:0px;">
		                  	<div class="col-md-1">
	  							<label style="margin-top:5px;">
							        <input name="form-field-checkbox" class="ace ace-checkbox-2" type="checkbox" value="" id="chkappdate" onclick="chkappdate();showLMResevationList;">
							        <span class="lbl"></span>
						    	</label>
	  						</div>
		                  	<div class="col-md-5">
			                    <div class="input-group">
				                    <span class="input-group-addon">
				                        <i class="fa fa-calendar bigger-110"></i>
				                    </span>
				                    <input class="form-control div_app date-picker" type="text" name="" id="txtLMappresDateFrom" data-provide="datepicker">
				                </div>
			                </div>
		                  	<div class="col-md-5">
		                    	<div class="input-group">
		                      		<span class="input-group-addon">
		                        	<i class="fa fa-calendar bigger-110"></i>
			                      	</span>
			                      	<input class="form-control div_app date-picker" type="text" name="" id="txtLMappresDateTo" data-provide="datepicker">
		                    	</div>
		                  	</div>
	                  	<div class="col-md-1"></div>
		                </div>
	              	</fieldset>

	              	<fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;" id="div_chkoccdate">
	              		<legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:130px;">&nbsp;&nbsp;Occupancy Date&nbsp;&nbsp;</legend>
		                <div class="form-group row" style="margin:0px;">
		                  	<div class="col-md-1">
	  							<label style="margin-top:5px;">
							        <input name="form-field-checkbox" class="ace ace-checkbox-2" type="checkbox" value="" id="chkoccdate" onclick="chkoccdate();showLMResevationList;">
							        <span class="lbl"></span>
						    	</label>
	  						</div>
		                  	<div class="col-md-5">
			                    <div class="input-group">
				                    <span class="input-group-addon">
				                        <i class="fa fa-calendar bigger-110"></i>
				                    </span>
				                    <input class="form-control div_occ date-picker" type="text" name="" id="txtLMoccresDateFrom" data-provide="datepicker">
				                </div>
			                </div>
		                  	<div class="col-md-5">
		                    	<div class="input-group">
		                      		<span class="input-group-addon">
		                        	<i class="fa fa-calendar bigger-110"></i>
			                      	</span>
			                      	<input class="form-control div_occ date-picker" type="text" name="" id="txtLMoccresDateTo" data-provide="datepicker">
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
	                  		<button class="btn btn-xs btn-info" onclick="saveLMReservationFilter()" style="float:right;margin-bottom:10px;margin-right:10px;width:80px;">
	                      		OK
	                  		</button>
	                	</div>
	              	</div>'><i class="fa fa-filter bigger-110"></i>&nbsp;&nbsp;Select Filter here</a></h5>
	      </div>
      	<div>
	        <div class="col-md-4" style="padding-bottom: 5px;text-align: right;"></div>
	        <div class="col-md-2 col-xs-12" style="padding-bottom: 5px;padding-right: 0px;">
			    <!-- <button class="btn btn-info btn-sm hide isadmin select-addinquiry" style="width: 100% !important;" onclick="showleaseinquiryform();">New Inquiry</button> -->
	        </div>
	    </div>
		  	<div class="row form-group" style="margin-bottom: 0px !important;">
        		<div class="col-xs-12 col-md-12 col-lg-12">
	    			<div class="parent">
	    				<table id="simple-table" class="table table-bordered table-hover fixTable">
		        			<thead>
		        				<tr>
		                  			<th>Date Inquired</th>
		        					<th>Company</th>
				                  	<th>Name</th>
				                  	<th>Unit</th>
		        					<th>Mobile Number</th>
		        					<th>Email</th>
		        					<th>Status</th>
		        					<th>Requirement Status</th>
		        					<th>Option</th>
		        				</tr>
		        			</thead>
		        			<tbody id="tblleasingreservationlist"></tbody>
		        		</table>
	          		</div>
	          		<table class="tabledash_footer table" style="margin: 0px !important;">
						<thead>
						  	<tr>
								<th id="th_tabledash_footer" style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
									<font id="txtLMresenties" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
									<input id="txt_LMresuserpage" type="hidden">
								  	<ul id="ulLMrespagination" class="pagination pull-right"></ul>
								</th>
						  	</tr>
						</thead>
				  	</table>
  		  		</div>
      		</div>
	  	</div>
  	</div>
</div>

<!-- START OF MODAL FOR INQUIRY FORM -->
<div class="modal fade fade-scale" id="modalleaseinquiryform" role="dialog" area-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-lg" style="width: 85%;">
    <div class="modal-content">
      <div id="loadleasinquiryform"></div>
      <div class="modal-header">
        <button type="button" class="close" onclick="hideleaseinquiryform()">&times;</button>
        <h4 class="modal-title" style="font-family: Roboto;font-size: 18px;">New Inquiry</h4>
        <input type="hidden" id="LMinquiryIDforUpdate">
        <input type="hidden" id="LMUnitIDforUpdate">
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="row form-group">

            	<div class="col-md-12">
	                <div class="checkbox pull-right">
	                  <label>
	                      <input type="checkbox" id="clicktoshowall" onclick="clicktoshowall();">
	                      <span class="lbl" style="color: #666;font-weight: bold;">&nbsp;Expand All</span>
	                  </label>
	                </div>
	              </div>

              <!-- Buyer Information -->
              <div class="col-md-12">
                <div class="widget-container-col ui-sortable" id="widget-container-buyerinfo">
                  <div class="widget-box transparent ui-sortable-handle collapsed" id="widget-box-12">
                    <div class="widget-header">
                      <h4 class="widget-title">Buyer Information</h4>

                      <div class="widget-toolbar no-border">
                        <a href="#" data-action="collapse" class="clicktoshowall">
                          <i class="ace-icon fa fa-chevron-down"></i>
                        </a>
                      </div>
                    </div>

                    <div class="widget-body" style="display: none;">
                      <div class="widget-main">
                        <div class="row well">

                          <div class="col-md-12">
                            <div class="col-md-4">
                              First Name
                            </div>
                            <div class="col-md-4">
                              Middle Name
                            </div>
                            <div class="col-md-4">
                              Last Name
                            </div>
                          </div>

                          <div class="col-md-12">
                            <div class="col-md-4">
                              <input type="text" class="form-control mustclearfirst" id="txtLMFirstName">
                            </div>
                            <div class="col-md-4">
                              <input type="text" class="form-control mustclearfirst" id="txtLMMiddleName">
                            </div>
                            <div class="col-md-4">
                              <input type="text" class="form-control mustclearfirst" id="txtLMLastName">
                            </div>
                          </div>

                          <div class="col-md-12" style="margin-top: 5px;">
                            <div class="col-md-2">
                              Gender
                            </div>
                            <div class="col-md-2">
                              Date of Birth
                            </div>
                            <div class="col-md-2">
                              Civil Status
                            </div>
                            <div class="col-md-2">
                              Telephone No
                            </div>
                            <div class="col-md-2">
                              Mobile No
                            </div>
                            <div class="col-md-2">
                              Email Address
                            </div>
                          </div>

                          <div class="col-md-12">
                            <div class="col-md-2">
                              <div class="radio">
                                  <label>
                                      <input name="form-field-radio" type="radio" class="ace chkLMGender" id="Male" value="Male">
                                      <span class="lbl" style="color: #666;">&nbsp;&nbsp;Male</span>
                                  </label>
                                  <label>
                                      <input name="form-field-radio" type="radio" class="ace chkLMGender" id="Female" value="Female">
                                      <span class="lbl" style="color: #666;">&nbsp;&nbsp;Female</span>
                                  </label>
                              </div>
                            </div>
                            <div class="col-md-2">
                              <input type="text" class="form-control mustclearfirst jonas-date-picker" id="txtLMBirthdate" value='<?php echo date('m/d/Y'); ?>'>
                            </div>
                            <div class="col-md-2">
                              <select class="form-control mustclearfirst" id="txtLMCivilStatus">
                                <option value="" selected disabled>-- Select Civil Status --</option>
                                <option value="Single">Single</option>
                                <option value="Single">Married</option>
                                <option value="Single">Divorced</option>
                                <option value="Single">Separated</option>
                                <option value="Single">Widowed</option>
                              </select>
                            </div>
                            <div class="col-md-2">
                              <input type="text" class="form-control mustclearfirst  input-mask-tele" placeholder="(000) 000-0000" id="txtLMTelephone">
                            </div>
                            <div class="col-md-2">
                              <input type="text" class="form-control mustclearfirst input-mask-phone" placeholder="(00)-000-0000" id="txtLMMobile">
                            </div>
                            <div class="col-md-2">
                              <input type="text" class="form-control mustclearfirst email-address" placeholder="sample@yahoo.com" id="txtLMEmailAddress">
                            </div>
                          </div>

                          <div class="col-md-12" style="margin-top: 5px;">
                            <div class="col-md-2">
                              Tax Identification No.
                            </div>
                            <div class="col-md-2">
                              Occupation
                            </div>
                            <div class="col-md-4">
                              Citizenship(Indicate both if dual citizenship)
                            </div>
                            <div class="col-md-4"></div>
                          </div>

                          <div class="col-md-12">
                            <div class="col-md-2">
                              <input type="text" class="form-control mustclearfirst" id="txtLMTIN">
                            </div>
                            <div class="col-md-2">
                              <input type="text" class="form-control mustclearfirst" id="txtLMOccupation">
                            </div>
                            <div class="col-md-4">
                              <input type="text" class="form-control mustclearfirst" id="txtLMCitizenship">
                            </div>
                            <div class="col-md-4"></div>
                          </div>

                          <div class="col-md-12" style="margin-top: 5px;">
                            <div class="col-md-6">
                              Address
                            </div>
                            <div class="col-md-2">
                              City
                            </div>
                            <div class="col-md-2">
                              Country
                            </div>
                            <div class="col-md-2">
                              Zip Code
                            </div>
                          </div>

                          <div class="col-md-12">
                            <div class="col-md-6">
                              <input list="list_address_list" type="text" class="form-control mustclearfirst" id="txtLMAddress">
                              <datalist id="list_address_list"></datalist>
                            </div>
                            <div class="col-md-2">
                              <input list="inq_citylist" type="text" class="form-control mustclearfirst" id="txtLMCity" onkeyup="loadcityref(this.value);">
                              <datalist id="inq_citylist"></datalist>
                            </div>
                            <div class="col-md-2">
                              <input list="list_address_list" type="text" class="form-control mustclearfirst" id="txtLMCountry">
                              <datalist id="list_address_list"></datalist>
                            </div>
                            <div class="col-md-2">
                              <input type="text" class="mustclearfirst" id="txtLMZip">
                            </div>
                          </div>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Contact Information -->
              <div class="col-md-12">
                <div class="widget-container-col ui-sortable" id="widget-container-buyerinfo">
                  <div class="widget-box transparent ui-sortable-handle collapsed" id="widget-box-12">
                    <div class="widget-header">
                      <h4 class="widget-title">Contact Information</h4>

                      <div class="widget-toolbar no-border">
                        <a href="#" data-action="collapse" class="clicktoshowall">
                          <i class="ace-icon fa fa-chevron-down"></i>
                        </a>
                      </div>
                    </div>

                    <div class="widget-body" style="display: none;">
                      <div class="widget-main">
                        <div class="row well">

                          <div class="col-md-6">
                            <div class="row form-group">
                              <h4 class="green">Add New Contact</h4>
                            </div>

                            <div class="row form-group">
                              <div class="col-md-2">
                                Contact Name
                              </div>
                              <div class="col-md-4">
                                <input type="text" class="form-control txtlminqContactinfo" placeholder="First Name" id="txtLMinqContactFirstName" tabindex="1">
                              </div>
                              <div class="col-md-2">
                                Address
                              </div>
                              <div class="col-md-4">
                                <input type="text" class="form-control txtlminqContactinfo" placeholder="Address" id="txtLMinqContactAddress" tabindex="5">
                              </div>
                            </div>

                            <div class="row form-group">
                              <div class="col-md-2">
                                
                              </div>
                              <div class="col-md-4">
                                <input type="text" class="form-control txtlminqContactinfo" placeholder="Middle Name" id="txtLMinqContactMiddleName" tabindex="2">
                              </div>
                              <div class="col-md-2">
                                Email Address
                              </div>
                              <div class="col-md-4">
                                <input type="text" class="form-control email-address txtlminqContactinfo" placeholder="Email Address" id="txtLMinqContactEmailAddress" tabindex="6">
                              </div>
                            </div>

                            <div class="row form-group">
                              <div class="col-md-2">
                                
                              </div>
                              <div class="col-md-4">
                                <input type="text" class="form-control txtlminqContactinfo" placeholder="Last Name" id="txtLMinqContactLastName" tabindex="3">
                                
                              </div>
                              <div class="col-md-2">
                                Mobile No
                              </div>
                              <div class="col-md-4">
                                <input type="text" class="form-control input-mask-phone txtlminqContactinfo" placeholder="(000)-000-0000" id="txtLMinqContactMobileNo" tabindex="7">
                              </div>
                            </div>

                            <div class="row form-group">
                              <div class="col-md-2" style="white-space: nowrap;">
                                Company Position
                              </div>
                              <div class="col-md-4">
                                <div class="input-group">
                                  <select class="form-control txtlminqContactinfo" id="txtLMinqContactCompanyPosition" tabindex="4"></select>
                                    <div class="spinbox-buttons input-group-btn">         
                                      <button type="button" class="btn spinbox-up btn-sm btn-success" onclick="showmodal_addnewposition()">            
                                        <i class="icon-only  ace-icon ace-icon fa fa-plus bigger-110"></i>          
                                      </button>       
                                    </div>
                                </div>
                              </div>
                              <div class="col-md-2">
                                Telephone No
                              </div>
                              <div class="col-md-4">
                                <input type="text" class="form-control input-mask-tele txtlminqContactinfo" placeholder="(00)-000-0000" id="txtLMinqContactTelephoneNo" tabindex="8">
                              </div>
                            </div>

                            <div class="row form-group">
                              <div class="col-md-12">
                                <button id="btn-save-contact-person" class="pull-right btn btn-sm btn-success btn-white btn-round" type="button" onclick="LMinqaddcontactperson()" tabindex="9">Save Contact Person<i class="ace-icon fa fa-plus icon-on-right bigger-110"></i></button>
                              </div>
                            </div>

                          </div>

                          <div class="col-md-6">
                            <div class="row form-group">
                              <h4 class="green">Contact Persons</h4>
                            </div>
                            <div class="row form-group">
                              <div class="col-md-12">
                                <div class="parent3">
                                  <table class="table table-hover table-striped fixTable" style="white-space: nowrap;">
                                    <thead>
                                      <tr>
                                        <td>Name</td>
                                        <td>Company Position</td>
                                        <td>Mobile No</td>
                                        <td>Telephone No</td>
                                        <td>Email Address</td>
                                        <td>Address</td>
                                      </tr>
                                    </thead>
                                    <tbody id="div_LMinqcontactlist"></tbody>
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
              </div>

              <!-- Unit Information -->
              <div class="col-md-12">
                <div class="widget-container-col ui-sortable" id="widget-container-unitinfo">
                  <div class="widget-box transparent ui-sortable-handle collapsed" id="widget-box-12">
                    <div class="widget-header">
                      <h4 class="widget-title">Unit Information</h4>
                      <input type="hidden" id="txtidmall">
                      <input type="hidden" id="txtidwing">
                      <input type="hidden" id="txtidclassification">
                      <input type="hidden" id="txtiddepartment">
                      <input type="hidden" id="txtidcategory">
                      <div class="widget-toolbar no-border">
                        <a href="#" data-action="collapse" class="clicktoshowall">
                          <i class="ace-icon fa fa-chevron-down"></i>
                        </a>
                      </div>
                    </div>

                    <div class="widget-body" style="display: none;">
                      <div class="widget-main">
                        <div class="row well">

                          <div class="col-md-12">
                            <div class="col-md-4">
                              <div class="row form-group">
                                <h4 class="green">Select Unit</h4>
                              </div>
                              <div class="row form-group">
                                <div class="col-md-4">
                                  <!-- Select Unit -->
                                </div>
                                <div class="col-md-8">
                                  <button class="btn btn-primary btn-block btn-sm" onclick="quickselect();"><i class="fa fa-level-up"></i> Shortcut</button>
                                </div>
                              </div>
                              <div class="row form-group">
                                <div class="col-md-4">
                                  Company
                                </div>
                                <div class="col-md-8">
                                  <select class="form-control mustclearfirst" id="txtLMinqcomp" onchange="showtxtLMinqclass(this.value);"></select>
                                </div>
                              </div>
                              <div class="row form-group">
                                <div class="col-md-4">
                                  Classification
                                </div>
                                <div class="col-md-8">
                                  <select class="form-control mustclearfirst" disabled id="txtLMinqclass" onchange="showtxtLMinqdep(this.value);"></select>
                                </div>
                              </div>
                              <div class="row form-group">
                                <div class="col-md-4">
                                  Department
                                </div>
                                <div class="col-md-8">
                                  <select class="form-control mustclearfirst" disabled id="txtLMinqdep" onchange="showtxtLMinqcat(this.value);"></select>
                                </div>
                              </div>
                              <div class="row form-group">
                                <div class="col-md-4">
                                  Category
                                </div>
                                <div class="col-md-8">
                                  <select class="form-control mustclearfirst" disabled id="txtLMinqcat" onchange="showtxtLMinqwing(this.value);"></select>
                                </div>
                              </div>
                              <div class="row form-group">
                                <div class="col-md-4">
                                  Wing/Bldg
                                </div>
                                <div class="col-md-8">
                                  <select class="form-control mustclearfirst" disabled id="txtLMinqwing" onchange="showtxtLMinqfloor(this.value);"></select>
                                </div>
                              </div>
                              <div class="row form-group">
                                <div class="col-md-4">
                                  Floor
                                </div>
                                <div class="col-md-8">
                                  <select class="form-control mustclearfirst" disabled id="txtLMinqfloor" onchange="showtxtLMinqunit(this.value);"></select>
                                </div>
                              </div>
                              <div class="row form-group">
                                <div class="col-md-4">
                                  Unit
                                </div>
                                <div class="col-md-8">
                                  <select class="form-control mustclearfirst" disabled id="txtLMinqunit" onchange="showtxtLMinqunitinfo(this.value);"></select>
                                </div>
                              </div>
                            </div>

                            <div class="col-md-4">
                              <div class="row form-group">
                                <h4 class="green">Unit Information</h4>
                              </div>
                              <div class="row form-group">
                                <div class="col-md-4">
                                  Unit Area
                                </div>
                                <div class="col-md-8">
                                  <input type="text" class="form-control mustclearfirst setvalzero" readonly id="txtLMunitarea" style="text-align: right;">
                                </div>
                              </div>
                              <div class="row form-group">
                                <div class="col-md-4">
                                  Price Per SQM
                                </div>
                                <div class="col-md-8">
                                  <input type="text" class="form-control mustclearfirst setvalzero" readonly id="txtLMppsqm" style="text-align: right;">
                                </div>
                              </div>
                              <div class="row form-group">
                                <div class="col-md-4">
                                  Monthly Due
                                </div>
                                <div class="col-md-1">
                                  <button class="btn btn-success btn-xs" style="display: none;" id="btnsavemonthlydue" onclick="savemonthlydue();"><i class="fa fa-check"></i></button>
                                </div>
                                <div class="col-md-7">
                                  <input type="text" class="form-control mustclearfirst setvalzero" readonly id="txtLMmonthlydue" style="text-align: right;" ondblclick="editmonthlydue(this.id);">
                                </div>
                              </div>
                              <div class="row form-group">
                                <div class="col-md-4">
                                  Association Due
                                </div>
                                <div class="col-md-1">
                                  <button class="btn btn-success btn-xs" style="display: none;" id="btnsaveassocdue" onclick="saveassocdue();"><i class="fa fa-check"></i></button>
                                </div>
                                <div class="col-md-7">
                                  <input type="text" class="form-control mustclearfirst setvalzero" readonly id="txtLMassociationdue" style="text-align: right;" ondblclick="editassocdue(this.id);">
                                </div>
                              </div>
                              <div class="row form-group">
                                <div class="col-md-4">
                                  Occupancy Date
                                </div>
                                <div class="col-md-4">
                                  <input type="text" class="form-control mustclearfirst jonas-date-picker" id="txtLMdateFrom" value='<?php echo date('m/d/Y'); ?>'>
                                </div>
                                <div class="col-md-4">
                                  <input type="text" class="form-control mustclearfirst setvalblank" id="txtLMdateTo" readonly>
                                </div>
                              </div>
                              <div class="row form-group">
                                <div class="col-md-4">
                                  No of Months
                                </div>
                                <div class="col-md-2">
                                  <input type="text" class="form-control mustclearfirst" onkeyup="showdateto();" id="txtLMmonthcount" maxlength="3" placeholder="0">
                                </div>
                                
                              </div>
                            </div>

                            <div class="col-md-4">
                              <div class="row form-group">
                                <h4 class="green">Amenities</h4>
                              </div>
                              <div class="row form-group">
                                <div id="tblamenities"></div>
                              </div>
                            </div>

                          </div>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div> 

              <!-- Terms of Payment -->
              <div class="col-md-12">
                <div class="widget-container-col ui-sortable" id="widget-container-paymentterms">
                  <div class="widget-box transparent ui-sortable-handle collapsed" id="widget-box-12">
                    <div class="widget-header">
                      <h4 class="widget-title">Terms of Payment</h4>

                      <div class="widget-toolbar no-border">
                        <a href="#" data-action="collapse" class="clicktoshowall">
                          <i class="ace-icon fa fa-chevron-down"></i>
                        </a>
                      </div>
                    </div>

                    <div class="widget-body" style="display: none;">
                      <div class="widget-main">
                        <div class="row well">

                          <div class="col-md-12">

                            <div class="col-md-6">
                              <div class="row form-group">
                                <h4 class="green">Unit Computation</h4>
                              </div>

                              <div class="row form-group">
                                <div class="col-md-4">
                                  List Price
                                </div>  
                                <div class="col-md-1"></div>
                                <div class="col-md-6">
                                  <input type="text" class="form-control mustclearfirst" id="txtListPrice" readonly>
                                </div>
                              </div>

                              <div class="row form-group">
                                <div class="col-md-4">
                                  <label style="color: red;" id="txtLMPD">5%</label> Promo Discount
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-6">
                                  <input type="text" class="form-control mustclearfirst" id="txtPromoDiscount" readonly>
                                </div>
                              </div>

                              <div class="row form-group">
                                <div class="col-md-4">
                                  <label style="color: red;" id="txtLMCD">5%</label> Company Discount
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-6">
                                  <input type="text" class="form-control mustclearfirst" id="txtCompanyDiscount" readonly>
                                </div>
                              </div>

                              <div class="row form-group">
                                <div class="col-md-4">
                                  <label style="color: red;" id="txtLMSD">5%</label> Standard Discount
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-6">
                                  <input type="text" class="form-control mustclearfirst" id="txtStandardDiscount" readonly>
                                </div>
                              </div>

                              <div class="row form-group">
                                <div class="col-md-4">
                                  Total Discounts
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-6">
                                  <input type="text" class="form-control mustclearfirst" id="txtTotalDiscount" readonly>
                                </div>
                              </div>

                              <div class="row form-group">
                                <div class="col-md-4">
                                  <div id="txtLMVAT">VAT</div>
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-6">
                                  <input type="text" class="form-control mustclearfirst" id="txtAddVat" readonly>
                                </div>
                              </div>

                              <div class="row form-group">
                                <div class="col-md-4">
                                  Total Contract Price
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-6">
                                  <input type="text" class="form-control mustclearfirst" id="txtTotalContractPrice" readonly>
                                </div>
                              </div>

                              <div class="row form-group">
                                <div class="col-md-4">
                                  Other Charges
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-6">
                                  <input type="text" class="form-control mustclearfirst" id="txtOtherCharges" readonly>
                                </div>
                              </div>

                              <div class="row form-group">
                                <div class="col-md-4">
                                  Total Amount Payable
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-6">
                                  <input type="text" class="form-control mustclearfirst" id="txtTotalAmountPayable" readonly>
                                </div>
                              </div>

                            </div>

                            <div class="col-md-6">
                              <div class="row form-group">
                                <h4 class="green">Payment Scheme Details</h4>
                              </div>

                              <div class="row form-group">
                                <div class="col-md-3"></div>
                                <div class="col-md-3">
                                  <div class="checkbox">
                                    <label>
                                        <input name="form-field-checkbox" type="radio" class="ace chkPaymentScheme" value="SpotCash">
                                        <span class="lbl" style="color: #666;">&nbsp;&nbsp;Spot Cash</span>
                                    </label>
                                  </div>
                                </div>
                                <div class="col-md-3">
                                  <div class="checkbox">
                                    <label>
                                        <input name="form-field-checkbox" type="radio" class="ace chkPaymentScheme" value="DefferedCash">
                                        <span class="lbl" style="color: #666;">&nbsp;&nbsp;Deffered Cash</span>
                                    </label>
                                  </div>
                                </div>
                                <div class="col-md-4">
                                  <div class="checkbox">
                                    <label>
                                        <input name="form-field-checkbox" type="radio" class="ace chkPaymentScheme" value="Installment">
                                        <span class="lbl" style="color: #666;">&nbsp;&nbsp;Installment</span>
                                    </label>
                                  </div>
                                </div>
                              </div>

                              <div class="row form-group">
                                <div class="col-md-3">
                                  <label style="color: red;" id="txtLMSDP">5%</label> Spot Down Payment
                                </div>
                                <div class="col-md-4">
                                  <input type="text" class="form-control mustclearfirst" id="txtSpotDownPayment" readonly>
                                </div>
                                <div class="col-md-2">
                                  Due Date
                                </div>
                                <div class="col-md-3">
                                  <input type="text" class="form-control mustclearfirst jonas-date-picker" value='<?php echo date('m/d/Y'); ?>' id="txtSpotDownPaymentDueDate">
                                </div>
                              </div>

                              <div class="row form-group">
                                <div class="col-md-3">
                                  Reservation Fee
                                </div>
                                <div class="col-md-4">
                                  <input type="text" class="form-control mustclearfirst" id="txtReservationFee" readonly>
                                </div>
                                <div class="col-md-2">
                                  Due Date
                                </div>
                                <div class="col-md-3">
                                  <input type="text" class="form-control mustclearfirst jonas-date-picker" value='<?php echo date('m/d/Y'); ?>' id="txtReservationFeeDueDate">
                                </div>
                              </div>

                              <div class="row form-group">
                                <div class="col-md-3">
                                  Retention Fee
                                </div>
                                <div class="col-md-4">
                                  <input type="text" class="form-control mustclearfirst" id="txtRetentionFee" readonly>
                                </div>
                              </div>

                              <div class="row form-group">
                                <div class="col-md-3">
                                  Net Spot Payment
                                </div>
                                <div class="col-md-4">
                                  <input type="text" class="form-control mustclearfirst" id="txtNetSpotPayment" readonly>
                                </div>
                              </div>

                              <div class="row form-group">
                                <div class="col-md-3">
                                  <label style="color: red;" id="txtLMNDP">5%</label> Net Down Payment
                                </div>
                                <div class="col-md-4">
                                  <input type="text" class="form-control mustclearfirst" id="txtNetDownPayment" readonly>
                                </div>
                                <div class="col-md-2">
                                  Due Date
                                </div>
                                <div class="col-md-3">

                                </div>
                              </div>
                              <div class="row form-group">
                                <div class="col-md-3">
                                  
                                </div>
                                <div class="col-md-2">
                                  No of Mos.
                                </div>
                                <div class="col-md-2">
                                  <input type="text" class="form-control mustclearfirst" id="txtAmortNoOfMonths" onkeyup="getamort();">
                                </div>
                                <div class="col-md-2">
                                  Starting Due Date
                                </div>
                                <div class="col-md-3">
                                  <input type="text" class="form-control mustclearfirst jonas-date-picker" value='<?php echo date('m/d/Y'); ?>' id="txtLMAmortStartDate">
                                </div>
                              </div>
                              <div class="row form-group">
                                <div class="col-md-3">
                                  
                                </div>
                                <div class="col-md-4">
                                  Monthly Amortization
                                </div>
                                <div class="col-md-5">
                                  <input type="text" class="form-control mustclearfirst" id="txtMonthlyAmortization" readonly>
                                </div>
                              </div>

                              <div class="row form-group">
                                <div class="col-md-3">
                                  <label style="color: red;" id="txtLMB">5%</label> Balance
                                </div>
                                <div class="col-md-4">
                                  <input type="text" class="form-control mustclearfirst" id="txtBalance" readonly>
                                </div>
                                <div class="col-md-2">
                                  Payment Type
                                </div>
                                <div class="col-md-3">
                                  <select class="form-control mustclearfirst" id="txtPaymentType">
                                    <option value="Cash">Cash</option>
                                    <option value="Check">Check</option>
                                    <option value="Credit Card">Credit Card</option>
                                    <option value="Debit Card">Debit Card</option>
                                    <option value="Bank Transfer">Bank Transfer</option>
                                  </select>
                                </div>
                              </div>

                              <div class="row form-group">
                                <div class="col-md-7">
                                  Validity Date of Payment Scheme
                                </div>
                                <div class="col-md-4">
                                  <input type="text" class="form-control mustclearfirst jonas-date-picker" value='<?php echo date('m/d/Y'); ?>' id="txtValidityDateOfPaymentScheme">
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

              <!-- Terms & Conditions -->
              <div class="col-md-12">
                <div class="widget-container-col ui-sortable" id="widget-container-col-12">
                  <div class="widget-box transparent ui-sortable-handle collapsed" id="widget-box-12">
                    <div class="widget-header">
                      <h4 class="widget-title">Terms & Conditions</h4>

                      <div class="widget-toolbar no-border">
                        <a href="#" data-action="collapse" class="clicktoshowall">
                          <i class="ace-icon fa fa-chevron-down"></i>
                        </a>
                      </div>
                    </div>

                    <div class="widget-body" style="display: none;">
                      <div class="widget-main">
                        <div class="row well">

                          <div class="col-md-12">
                            <div class="row form-group">
                              <div class="col-md-12">
                                <button class="btn btn-primary btn-sm pull-right" onclick="showmodal_LMINQtermsandcondition();">Browse Terms and Conditions</button>
                                <h4 class="green" style="text-align: center;">Terms and Condition</h4>
                              </div>
                            </div>
                            <div class="row form-group">
                              <div id="div_termsandcondition"></div>
                            </div>
                          </div>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Requirements -->
              <div class="col-md-12">
                <div class="widget-container-col ui-sortable" id="widget-container-col-12">
                  <div class="widget-box transparent ui-sortable-handle collapsed" id="widget-box-12">
                    <div class="widget-header">
                      <h4 class="widget-title">Requirements</h4>

                      <div class="widget-toolbar no-border">
                        <a href="#" data-action="collapse" class="clicktoshowall">
                          <i class="ace-icon fa fa-chevron-down"></i>
                        </a>
                      </div>
                    </div>

                    <div class="widget-body" style="display: none;">
                      <div class="widget-main">
                        <div class="row well">

                          <div class="col-md-12">
                            <div class="row form-group">
                               <h4 class="green">Requirements</h4>
                               <input type="hidden" id="overridecount" value='0'>
                            </div>
                            <div class="row form-group">
                            	<div class="col-md-6">
                            		<div id="div_resrequirements"></div>
                            	</div>
                            </div>
                          </div>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Others -->
              <div class="col-md-12">
                <div class="widget-container-col ui-sortable" id="widget-container-col-12">
                  <div class="widget-box transparent ui-sortable-handle collapsed" id="widget-box-12">
                    <div class="widget-header">
                      <h4 class="widget-title">Others</h4>

                      <div class="widget-toolbar no-border">
                        <a href="#" data-action="collapse" class="clicktoshowall">
                          <i class="ace-icon fa fa-chevron-down"></i>
                        </a>
                      </div>
                    </div>

                    <div class="widget-body" style="display: none;">
                      <div class="widget-main">
                        <div class="row well">

                            <div class="col-md-12">
                              <div class="row form-group">
                                <h4 class="green">Source of Sale</h4>
                              </div>
                              <div class="row form-group">
                                <div class="col-md-2">
                                  <div class="checkbox">
                                    <label>
                                        <input name="form-field-checkbox" type="checkbox" class="ace chkSourceofSale" value="Booth">
                                        <span class="lbl" style="color: #666;">&nbsp;&nbsp;Booth / Showroom</span>
                                    </label>
                                  </div>
                                </div>
                                <div class="col-md-2">
                                  <div class="checkbox">
                                    <label>
                                        <input name="form-field-checkbox" type="checkbox" class="ace chkSourceofSale" value="Event">
                                        <span class="lbl" style="color: #666;">&nbsp;&nbsp;Event</span>
                                    </label>
                                  </div>
                                </div>
                                <div class="col-md-2">
                                  <div class="checkbox">
                                    <label>
                                        <input name="form-field-checkbox" type="checkbox" class="ace chkSourceofSale" value="Advertisement">
                                        <span class="lbl" style="color: #666;">&nbsp;&nbsp;Advertisement</span>
                                    </label>
                                  </div>
                                </div>
                                <div class="col-md-2">
                                  <div class="checkbox">
                                    <label>
                                        <input name="form-field-checkbox" type="checkbox" class="ace chkSourceofSale" value="RepeatBuyer">
                                        <span class="lbl" style="color: #666;">&nbsp;&nbsp;Repeat Buyer</span>
                                    </label>
                                  </div>
                                </div>
                                <div class="col-md-2">
                                  <div class="checkbox">
                                    <label>
                                        <input name="form-field-checkbox" type="checkbox" class="ace chkSourceofSale" value="Internet">
                                        <span class="lbl" style="color: #666;">&nbsp;&nbsp;Internet</span>
                                    </label>
                                  </div>
                                </div>
                                <div class="col-md-2">
                                  <div class="checkbox">
                                    <label>
                                        <input name="form-field-checkbox" type="checkbox" class="ace chkSourceofSale" value="Email">
                                        <span class="lbl" style="color: #666;">&nbsp;&nbsp;E-mail</span>
                                    </label>
                                  </div>
                                </div>
                              </div>
                              <div class="row form-group">
                                <div class="col-md-2">
                                  <div class="checkbox">
                                    <label>
                                        <input name="form-field-checkbox" type="checkbox" class="ace chkSourceofSale" value="Flyer">
                                        <span class="lbl" style="color: #666;">&nbsp;&nbsp;Flyer</span>
                                    </label>
                                  </div>
                                </div>
                                <div class="col-md-2">
                                  <div class="checkbox">
                                    <label>
                                        <input name="form-field-checkbox" type="checkbox" class="ace chkSourceofSale" value="Referral">
                                        <span class="lbl" style="color: #666;">&nbsp;&nbsp;Referral</span>
                                    </label>
                                  </div>
                                </div>
                                <div class="col-md-2">
                                  <div class="checkbox">
                                    <label>
                                        <input name="form-field-checkbox" type="checkbox" class="ace chkSourceofSale" value="Employee">
                                        <span class="lbl" style="color: #666;">&nbsp;&nbsp;Employee</span>
                                    </label>
                                  </div>
                                </div>
                                <div class="col-md-2">
                                  <div class="checkbox">
                                    <label>
                                        <input name="form-field-checkbox" type="checkbox" class="ace chkSourceofSale" value="Broker">
                                        <span class="lbl" style="color: #666;">&nbsp;&nbsp;Broker / Agent</span>
                                    </label>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="col-md-12">
                              <div class="row form-group">
                                <h4 class="green">Reason For Buying / Leasing</h4>
                              </div>
                              <div class="row form-group">
                                <div class="col-md-2">
                                  <div class="checkbox">
                                    <label>
                                        <input name="form-field-checkbox" type="checkbox" class="ace chkReason4Buying" value="PrimaryHome">
                                        <span class="lbl" style="color: #666;">&nbsp;&nbsp;Primary Home</span>
                                    </label>
                                  </div>
                                </div>
                                <div class="col-md-2">
                                  <div class="checkbox">
                                    <label>
                                        <input name="form-field-checkbox" type="checkbox" class="ace chkReason4Buying" value="SecondaryHome">
                                        <span class="lbl" style="color: #666;">&nbsp;&nbsp;Secondary Home</span>
                                    </label>
                                  </div>
                                </div>
                                <div class="col-md-2">
                                  <div class="checkbox">
                                    <label>
                                        <input name="form-field-checkbox" type="checkbox" class="ace chkReason4Buying" value="ForRental">
                                        <span class="lbl" style="color: #666;">&nbsp;&nbsp;For Rental / Resale</span>
                                    </label>
                                  </div>
                                </div>
                                <div class="col-md-2">
                                  <div class="checkbox">
                                    <label>
                                        <input name="form-field-checkbox" type="checkbox" class="ace chkReason4Buying" value="ForFamilyMember">
                                        <span class="lbl" style="color: #666;">&nbsp;&nbsp;For Other Family Members</span>
                                    </label>
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
        <button class="btn btn-primary" id="LMRESbtnforsaving" onclick="saveLMinquiry()"><i class="ace-icon fa fa-check"></i>&nbsp;Save</button>
        <button class="btn btn-warning" id="LMRESbtnforoccupying" onclick="confirmoccupyLMappres()"><i class="ace-icon fa fa-check"></i>&nbsp;Occupy Unit</button>
        <button class="btn btn-primary" id="LMRESbtnforconfirmation" onclick="confirmconfirmLMappres()" style="display: none;"><i class="ace-icon fa fa-check"></i>&nbsp;Confirm Reservation</button>
        <button class="btn btn-danger" id="LMRESbtnforcancelling" style="display: none;" onclick="confirmcalcelLMappres()"><i class="ace-icon fa fa-times"></i>&nbsp;Cancel Reservation</button>
        <button class="btn btn-warning" id="LMRESbtnforreinstating" style="display: none;" onclick="confirmreinstateLMappres()"><i class="ace-icon fa fa-refresh"></i>&nbsp;Reinstate</button>

      </div>
    </div>
  </div>
</div>
<!-- END OF MODAL FOR INQUIRY FORM -->

<!-- START OF QUICK SELECT MODAL -->
<div class="modal fade fade-scale" role="dialog" id="modal_quickselect">
  <div class="modal-dialog modal-lg" style="width: 98%;">
    <div class="modal-content">
      <div id="quickselectloading"></div>
      <div class="modal-header">
        <button type="button" class="close" onclick="$('#modal_quickselect').modal('hide');">×</button>
        <h4 class="modal-title" style="font-family: Roboto;font-size: 18px;">Select Unit</h4>
      </div>
      <div class="modal-body">
        <div class="row form-group">
          <label class="col-md-1" style="margin-top: 5px;">Search Unit</label>
          <div class="col-md-2">
              <input type="text" class="form-control" id="txtsearchLMqs" title="Search" onkeyup="quickselect();">
          </div>
        </div>
        <div class="row">
          <div class="parent">
            <table class="table table-bordered fixTable">
              <thead>
                  <tr>
                      <th width='15%'>Company</th>
                      <th width='15%'>Classification</th>
                      <th width='15%'>Department</th>
                      <th width='15%'>Category</th>
                      <th width='15%'>Wing</th>
                      <th width='10%'>Floor</th>
                      <th width='15%'>Unit</th>
                  </tr>
              </thead>
              <tbody id="tblunitlist"></tbody>
            </table>
          </div>
          	<table class="tabledash_footer table" style="margin: 0px !important;">
				<thead>
				  	<tr>
						<th id="th_tabledash_footer" style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
							<font id="txtquickselectenties" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
							<input id="txt_quickselectuserpage" type="hidden">
						  	<ul id="ulquickselectpagination" class="pagination pull-right"></ul>
						</th>
				  	</tr>
				</thead>
		  	</table>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- END OF QUICK SELECT MODAL -->

<!-- START OF QUICK SELECT MODAL -->
<div class="modal fade fade-scale" role="dialog" id="modal_LMINQtermsandcondition">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    <div id="LMINQtermsandconditionloading"></div>
      <div class="modal-header">
        <button type="button" class="close" onclick="$('#modal_LMINQtermsandcondition').modal('hide');">×</button>
        <h4 class="modal-title" style="font-family: Roboto;font-size: 18px;">Terms and Conditions</h4>
        <input type="hidden" id="sonyxperiax">
      </div>
      <div class="modal-body">
        <div class="row form-group">
        <div class="col-md-3" style="padding-top: 5px;">
            Filter by Group Name:
        </div>
        <div class="col-md-4" style="padding-top: 5px;">
          <select id="groupselection" onchange="showtblLMinqtermsandconditionlist();" class="form-control required"> <option value="">All</option></select>
        </div>
      </div>
        <div class="row">
          <div class="parent">
            <table class="table table-hover table-bordered fixTable">
              <thead>
                <tr>
                    <th width='15%'>Group</th>
                    <th width='20%'>Term Name</th>
                    <th width='35%'>Condition</th>
                </tr>
              </thead>
              <tbody id="tblLMinqtermsandconditionlist"></tbody>
            </table>
          </div>
          <table class="tabledash_footer table" style="margin: 0px !important;">
            <thead>
              <tr>
                <input type="hidden" id="txt_LMinqTACselectuserpage">
                <th id="th_tabledash_footer" width="" colspan="7" style="width: 911px;padding-top: 15px;padding-bottom: 15px;">
                <font style="float: left; color: white !important;margin-left: 15px;font-weight: normal;font-weight: 8px !important;" id="txtLMinqTACenties"><br /></font>
                    <ul id="ulLMinqTACpagination" class="pagination pull-right"></ul>
                </th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="addselection()"><i class="ace-icon fa fa-check"></i>&nbsp;Add Selected</button>
      </div>
    </div>
  </div>
</div>
<!-- END OF QUICK SELECT MODAL -->

<div class="modal fade fade-scale" id="modal_login_override" role="dialog" area-hidden="true" data-keyboard="false" data-backdrop="static">
  	<div class="modal-dialog modal-sm">   
    	<div class="modal-content">
		    <div class="modal-body">
		        <button type="button" class="close" onclick="hidemodal_login_override()">×</button>
		        <h4 class="modal-title" id="txtref_name">Login</h4><br>
		        <div class="row form-group">
		            <div class="col-xs-12 col-md-3">
		                Username
		            </div>
		            <div class="col-xs-12 col-md-9">
		                <span class="input-icon">
		          			<input type="text" class="form-control" name="" id="txtoverrideusername">
		          			<i class="ace-icon fa fa-user blue"></i>
		        		</span>
		            </div>
		        </div>
		        <div class="row form-group">
		            <div class="col-xs-12 col-md-3">
		                Password
		            </div>
		            <div class="col-xs-12 col-md-9">
		                <span class="input-icon">
		        	 		<input type="password" class="form-control" name="" id="txtoverridepassword">
		          			<i class="ace-icon fa fa-lock blue"></i>
		        		</span>
		            </div>
		        </div>
		        <div class="row form-group" style="margin-bottom: 0px;">
		        	<div class="col-xs-12 col-md-6">
		                <button class="btn btn-info btn-sm btn-block" id="btnshowoverridemodal">Login</button>
		            </div>
		            <div class="col-xs-12 col-md-6">
		                <button class="btn btn-danger btn-sm btn-block" onclick="hidemodal_login_override()">Cancel</button>
		            </div>
		        </div>
		    </div>
    	</div>
  	</div>
</div>


<div class="modal fade fade-scale" id="modal_view_image" role="dialog" area-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body" style="" id="modal-body-leasingapp2">
        <div class="row form-group">
          <div class="col-xs-12">
            <br/>
            <center id='content_img'>
              <div class="easyzoom easyzoom--overlay easyzoom--with-toggle">
                  <a id="img_viewed2" href="">
                      <img id="img_viewed" src="" alt="" width="380" height="400" />
                  </a>
              </div>
            </center>  
            <br/>
          </div>    
        </div>
      </div>
      <div class="modal-footer">
      <br /><br />
          <button style="display: none;" class="toggle btn btn-md btn-info" data-active="true"><i style='color:white !important;' class='ace-icon fa fa-search-minus bigger-120'></i></button>
      </div> 
    </div>
  </div>
</div>
<?php 
	include("script.php");
?>