<div class="modal fade fade-scale" id="mdlAddNewInquiry" role="dialog" area-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" style="width: 80%;">
        <div class="modal-content">
            <div id="frmLoadingGlobalFrom"></div>
            <div class="modal-header">
                <button type="button" class="close" onclick="fncCloseInquiry()">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;"><?php if($_REQUEST['url'] == 'inquiry'){ echo 'Inquiry'; }else if($_REQUEST['url'] == 'leasingapplication'){ echo 'Leasing Application'; }else if($_REQUEST['url'] == 'reservation'){ echo 'Reservation'; }else{ echo 'Tenant'; }?></h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="txtGlobalFormInquiryID" class="txtGlobalClear">
                <input type="hidden" id="txtGlobalFormApplicationID" class="txtGlobalClear">
                <input type="hidden" id="isProposal" class="txtGlobalClear">
                <input type="hidden" id="txtTenantBillID" class="txtGlobalClear">
                <input type="hidden" id="txtGlobalFormTenantID" class="txtGlobalClear">
                <input type="hidden" id="txtGlobalisAmendment" class="txtGlobalClear">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row form-group">

                            <div class="col-md-12 hide">
                                <div class="checkbox pull-right">
                                    <label>
                                        <input type="checkbox" id="clicktoshowall" onclick="clicktoshowall();" class="ace">
                                        <span class="lbl" style="color: #666;font-weight: bold;">&nbsp;Expand All</span>
                                    </label>
                                </div>
                            </div>

                            <!--Tenant Information -->
                            <div class="col-md-12 hide isadmin select-tenantinformation">
                                <div class="widget-container-col ui-sortable" id="widget-container-buyerinfo">
                                    <div class="widget-box transparent ui-sortable-handle" id="widget-box-12">
                                        <div class="widget-header">
                                            <h4 class="widget-title txtPanelHeader">Tenant Information</h4>
                                            <input type="hidden" id="txtNDTHLeadsID">
                                        </div>
                                        <div class="widget-body">
                                            <div class="widget-main">
                                                <div class="row well">
                                                    <div class="row form-group">
                                                        <div class="col-md-12">
                                                            <h4 class="green txtPanelHeader">Tenant Information</h4>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="row form-group">
                                                                <div class="col-md-6">
                                                                    <div class="row form-group">
                                                                        <label class="col-md-12 thSysTenant2"></label>
                                                                        <div class="col-md-12">
                                                                            <input type="hidden" id="txtTradeID" class="txtGlobalClear">
                                                                            <div class="input-group">
                                                                                <input type="text" class="form-control INQRequired PRORequired TenantRequired ReservationRequired txtGlobalClear" id="txtTradeName" readonly style="background-color: white !important;" placeholder="<?php if(SysLeaseSetup('softwaretype') == '5'){ echo "Buyer Name"; }else if(SysLeaseSetup('softwaretype') == '0'){ echo "Store Name"; }else{ echo "Tenant Name"; } ?>">
                                                                                <span class="input-group-btn">
                                                                                    <button type="button" class="btn btn-inverse btn-white txtInqDisabled" title="Click here to browse <?php if(SysLeaseSetup('softwaretype') == '5'){ echo "buyer profiles"; }else if(SysLeaseSetup('softwaretype') == '0'){ echo "store profiles"; }else{ echo "store profiles"; } ?>" onclick="fncLoadTradeProfileList();">
                                                                                        <span class="fa fa-search bigger-110"></span>
                                                                                    </button>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="row form-group">
                                                                        <label class="col-md-12">Merchant Code <span class="red">*</span></label>
                                                                        <div class="col-md-12">
                                                                            <input type="text" class="form-control INQRequired PRORequired TenantRequired ReservationRequired txtGlobalClear" placeholder="Merchant Code" id="txtMerchantCode" readonly style="background-color: white !important;">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="row form-group">
                                                                        <label class="col-md-12">Company <span class="red divReqProposal">*</span></label>
                                                                        <div class="col-md-12">
                                                                            <input type="hidden" id="txtCompanyID" class="txtGlobalClear">
                                                                            <input type="text" class="form-control PRORequired TenantRequired ReservationRequired txtGlobalClear" placeholder="Company Name" readonly id="txtCompanyName" style="background-color: white !important;">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="row form-group">
                                                                        <label class="col-md-12">Industry <span class="red divReqProposal">*</span></label>
                                                                        <div class="col-md-12">
                                                                            <input type="hidden" id="txtIndustryID" class="txtGlobalClear">
                                                                            <input type="text" class="form-control PRORequired TenantRequired ReservationRequired txtGlobalClear" placeholder="Industry" readonly id="txtIndustry" style="background-color: white !important;">
                                                                        </div>
                                                                    </div>    
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="row form-group">
                                                                        <label class="col-md-12">Process Owner <span class="red">*</span></label>
                                                                        <div class="col-md-12">
                                                                            <select class="form-control INQRequired PRORequired TenantRequired ReservationRequired txtInqDisabled txtAllProcessOwner txtGlobalClear" id="txtGForm-ProcessOwner" style="background-color: white !important;"></select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="row form-group">
                                                                        <label class="col-md-12">Source <span class="red">*</span></label>
                                                                        <div class="col-md-12">
                                                                            <select class="form-control INQRequired PRORequired TenantRequired ReservationRequired txtInqDisabled txtAllSource txtGlobalClear" id="txtGFrom-Source" style="background-color: white !important;"></select>
                                                                        </div>
                                                                    </div>
                                                                </div>                                                                
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="row form-group">
                                                                <div class="col-md-12">
                                                                    <div class="image">
                                                                        <img id="imgTenant" class="form-control img-thumbnail" style="border: 2px solid #bdc3c7; margin-bottom: 8px;height: 200px;width: 100%;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="row form-group">
                                                                <div class="col-md-4">
                                                                    <div class="row form-group">
                                                                        <label class="col-md-12">Classification <span class="red divReqProposal">*</span></label>
                                                                        <div class="col-md-12">
                                                                            <select class="form-control txtAllClassification PRORequired TenantRequired ReservationRequired txtInqDisabled txtGlobalClear" id="txtNDTClassification" onchange="fncAllDepartmentRef();" style="background-color: white !important;"></select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="row form-group">
                                                                        <label class="col-md-12">Department <span class="red divReqProposal">*</span></label>
                                                                        <div class="col-md-12">
                                                                            <select class="form-control txtAllDepartment PRORequired TenantRequired ReservationRequired txtInqDisabled txtGlobalClear" id="txtNDTDepartment" onchange="fncAllCategoryRef();" style="background-color: white !important;"></select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="row form-group">
                                                                        <label class="col-md-12">Category <span class="red divReqProposal">*</span></label>
                                                                        <div class="col-md-12">
                                                                            <select class="form-control txtAllCategory PRORequired TenantRequired ReservationRequired txtInqDisabled txtGlobalClear" id="txtNDTCategory" style="background-color: white !important;"></select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 <?php if($_GET['url'] != 'tenants'){ echo "hide"; } ?>">
                                                                    <div class="row form-group">
                                                                        <div class="col-md-7">
                                                                            <label class="col-md-12">Tag as Accredited?</label>
                                                                            <div class="col-md-6">
                                                                                <div class="radio">
                                                                                    <label>
                                                                                        <input name="AccredStat" type="radio" class="ace AccredStat" id="TagAsAccredited">
                                                                                        <span class="lbl">&nbsp;Yes</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="radio">
                                                                                    <label>
                                                                                        <input name="AccredStat" type="radio" class="ace AccredStat" id="TagAsNotAccredited">
                                                                                        <span class="lbl">&nbsp;No</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-5">
                                                                            <label class="col-md-12 POSCount" style="display: none;">POS Count</label>
                                                                            <div class="col-md-12 POSCount" style="display: none;">
                                                                                <input type="text" class="form-control txtGlobalClear" id="txtNDTPosCount" onkeypress="return isNumberKey(event)">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="row form-group">
                                                                <div class="col-md-12">
                                                                    <h4 class="green">Contact Persons</h4>
                                                                </div>
                                                            </div>
                                                            <div class="row form-group">
                                                                <div class="col-md-12" id="div_inquiry_contact_person"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php if($_GET['url'] != 'inquiry'){ ?>
                            <!-- Billing Information -->
                            <div class="col-md-12 hide isadmin select-billinginformation">
                                <div class="widget-container-col ui-sortable" id="widget-container-buyerinfo">
                                    <div class="widget-box transparent ui-sortable-handle collapsed" id="widget-box-12">
                                        <div class="widget-header">
                                            <h4 class="widget-title">Billing Information</h4>
                                            <div class="widget-toolbar no-border">
                                                <a href="#" data-action="collapse" class="clicktoshowall" id="GForm-BillingInfo">
                                                    <i class="ace-icon fa fa-chevron-down"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="widget-body" style="display: none;">
                                            <div class="widget-main">
                                                <div class="row well">
                                                    <div class="row form-group">
                                                        <div class="col-md-6">
                                                            <div class="row form-group">
                                                                <div class="col-md-12">
                                                                    Account Name <span class="red divReqProposal">*</span>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control PRORequired TenantRequired ReservationRequired txtGlobalClear" placeholder="Account Name" id="txtTenantBillAccount" readonly style="background-color: white !important;">
                                                                        <span class="input-group-btn">
                                                                            <button type="button" class="btn btn-inverse btn-white txtInqDisabled" title="Click here to browse billing profiles" onclick="fncOpenBillingAccountList();">
                                                                                <span class="fa fa-search bigger-110"></span>
                                                                            </button>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="row form-group">
                                                                <div class="col-md-12">
                                                                    Billing Setup <span class="red divReqProposal">*</span>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <input type="text" id="txtTenantBillingSetup" class="form-control PRORequired TenantRequired ReservationRequired txtGlobalClear" readonly style="background-color: white !important;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-md-4">
                                                            <div class="row form-group">
                                                                <div class="col-md-12">
                                                                    Telephone No <span class="red divReqProposal">*</span>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <input type="text" class="form-control input-mask-tele PRORequired TenantRequired ReservationRequired txtGlobalClear" id="txtTenantBillTele" placeholder="(99)-999-9999" readonly style="background-color: white !important;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="row form-group">
                                                                <div class="col-md-12">
                                                                    Mobile No <span class="red divReqProposal">*</span>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <input type="text" class="form-control input-mask-phone PRORequired TenantRequired ReservationRequired txtGlobalClear" id="txtTenantBillMobi" placeholder="(99)-999-9999" readonly style="background-color: white !important;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="row form-group">
                                                                <div class="col-md-12">
                                                                    Email Address <span class="red divReqProposal">*</span>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <input type="text" class="form-control input-mask-tele PRORequired TenantRequired ReservationRequired txtGlobalClear" id="txtTenantBillEmail" placeholder="(99)-999-9999" readonly style="background-color: white !important;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-md-12">
                                                            Permanent Address <span class="red divReqProposal">*</span>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <span class="input-icon" style="width: 100%;">
                                                                <textarea class="form-control PRORequired TenantRequired ReservationRequired txtGlobalClear" style="height: 50px; resize: none; background-color: white !important;" id="txtTenantBillPerma" placeholder="Permanent Address" readonly></textarea>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-md-12">
                                                            Current Address <span class="red divReqProposal">*</span>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <span class="input-icon" style="width: 100%;">
                                                                <textarea class="form-control PRORequired TenantRequired ReservationRequired txtGlobalClear" style="height: 50px; resize: none; background-color: white !important;" id="txtTenantBillCurr" placeholder="Current Address" readonly></textarea>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-md-12">
                                                            Billing Address <span class="red divReqProposal">*</span>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <span class="input-icon" style="width: 100%;">
                                                                <textarea class="form-control PRORequired TenantRequired ReservationRequired txtGlobalClear" style="height: 50px; resize: none; background-color: white !important;" id="txtTenantBillBillingAddress" placeholder="Billing Address" readonly></textarea>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-md-12">
                                                            <div class="row form-group">
                                                                <div id="div_TenantBillerContact"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>

                            <?php if($_GET['url'] != 'inquiry'){ ?>
                            <!-- Lease Information -->
                            <div class="col-md-12 hide isadmin select-leaseinformation">
                                <div class="widget-container-col ui-sortable" id="widget-container-col-12">
                                    <div class="widget-box transparent ui-sortable-handle collapsed" id="widget-box-12">
                                        <div class="widget-header">
                                            <h4 class="widget-title">Lease Information</h4>
                                            <div class="widget-toolbar no-border">
                                                <a href="#" data-action="collapse" class="clicktoshowall" id="GForm-LeaseInformation">
                                                    <i class="ace-icon fa fa-chevron-down"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="widget-body">
                                            <div class="widget-main">
                                                <div class="row well">
                                                    <div class="row form-group" id="divAddUnitReq">
                                                        <div class="col-md-12">
                                                            <div class="row form-group">
                                                                <div class="col-md-2">
                                                                    <h4 class="green">Assigned Unit(s)</h4>
                                                                </div>
                                                                <div class="col-md-2 pull-right">
                                                                    <button class="btn btn-primary btn-xs btn-round btn-block txtInqDisabled" onclick="fncSelectUnit();">Add Unit</button>
                                                                </div>
                                                            </div>
                                                            <div class="row form-group">
                                                                <div class="col-md-12">
                                                                    <div id="divUnitInformation"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row form-group">
                                                        <div class="grid3">
                                                            <div class="row form-group">
                                                                <div class="col-md-6">
                                                                    <div class="row form-group">
                                                                        <label class="col-md-12">Start of Lease <span class="red divReqProposal">*</span></label>
                                                                        <div class="col-md-12">
                                                                            <input type="text" onchange="getOccupancyDateTo(); fncgetEscalationSched();" class="form-control date-picker jonas-date-picker PRORequired TenantRequired ReservationRequired txtInqDisabled" id="txtNDTdateFrom" value='<?php echo date('m/d/Y'); ?>' readonly style="background-color: white !important;">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="row form-group">
                                                                        <label class="col-md-12" style="white-space: nowrap;">Lease Termination Date <span class="red divReqProposal">*</span></label>
                                                                        <div class="col-md-12">
                                                                            <input type="text" class="form-control date-picker PRORequired TenantRequired ReservationRequired txtInqDisabled txtGlobalClear" readonly id="txtNDTdateTo" style="background-color: white !important;" onchange="fncgetMonthDay(); fncgetEscalationSched();">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="row form-group">
                                                                        <label class="col-md-12">Rental Scheme <span class="red divReqProposal">*</span></label>
                                                                        <div class="col-md-12">
                                                                            <select class="form-control PRORequired TenantRequired ReservationRequired txtInqDisabled" id="txtNDTBillingType" onchange="fncChangeBillingType(this.value);" style="background-color: white !important;">
                                                                                <option value="Rent">Basic Rent/SQM</option>
                                                                                <option value="Fixed Rent">Fixed Rent</option>
                                                                                <option value="Share Only">% on Gross Sales</option>
                                                                                <option value="Share Only2">% on Net Sales</option>
                                                                                <option value="Rent Rev">Basic Rent/SQM + % on GS</option>
                                                                                <option value="Rent or Share">Basic Rent/SQM or % on GS</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="row form-group">
                                                                        <label class="col-md-12">Area</label>
                                                                        <div class="col-md-12">
                                                                            <input type="text" class="form-control PRORequired TenantRequired ReservationRequired txtInqDisabled txtGlobalZero" id="txtGlobalArea" style="text-align: right;background-color: white !important;" readonly>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <div class="row form-group">
                                                                        <label class="col-md-12">Rate / SQM</label>
                                                                        <div class="col-md-12">
                                                                            <input type="text" class="form-control amount PRORequired TenantRequired ReservationRequired txtInqDisabled txtGlobalZero2" id="txtGlobalRate" style="text-align: right;" onchange="fncgetRent();" onkeyup="fncgetRent();" onkeypress="return isNumberKey(event)">
                                                                            <input type="text" class="form-control hide" id="txtGlobalRate2" value="0.00" readonly style="text-align: right;background-color: white !important;">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="row form-group">
                                                                        <label class="col-md-12 divNDTPercentage" style="display: none;">% of Sales</label>
                                                                        <div class="col-md-12 divNDTPercentage" style="display: none;">
                                                                            <span class="input-icon input-icon-right" id="txtNDTPercentagedisplay">
                                                                                <input type="text" class="form-control txtInqDisabled txtGlobalClear" maxlength="2" id="txtNDTPercentage" style="background-color: white !important;" onkeypress="return isNumberKey(event)">
                                                                                <i class="ace-icon fa fa-percent"></i>
                                                                            </span>
                                                                        </div>
                                                                        <label class="col-md-12 btnNDTMonthly">&nbsp;</label>
                                                                        <div class="col-md-12 btnNDTMonthly">
                                                                            <button class="btn btn-sm btn-primary btn-block btn-round txtInqDisabled" onclick="fncSaveFixedRent();"><i class="fa fa-check"></i></button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <div class="row form-group">
                                                                        <label class="col-md-12">Rent</label>
                                                                        <div class="col-md-12">
                                                                            <input type="text" class="form-control amount txtInqDisabled txtGlobalZero2" readonly style="background-color: white !important; text-align: right;" id="txtNDTMonthlyRent" onkeypress="return isNumberKey(event)">
                                                                            <input type="hidden" class="form-control txtGlobalZero2" readonly style="background-color: white !important; text-align: right;" id="txtNDTMonthlyRentOrig">
                                                                            <input type="hidden" class="form-control txtGlobalZero2" readonly style="background-color: white !important; text-align: right;" id="txtNDTMonthlyCharges">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="row form-group">
                                                                        <label class="col-md-12">VAT Setup</label>
                                                                        <div class="col-md-12">
                                                                            <select class="form-control txtInqDisabled ReservationRequired TenantRequired txtGlobalClear" id="txtVATSetup" style="background-color: white !important;" onchange="fncgetPaymentSchedule(); fncSaveFixedRent();">
                                                                                <option value='0'>VATable</option>
                                                                                <option value='1'>Non-VATable</option>
                                                                                <option value='2'>Zero Rated</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="row form-group">
                                                                        <div class="col-md-7">
                                                                            <div class="row form-group">
                                                                                <label class="col-md-12" style="white-space: nowrap;">Rent-Free Construction <span class="red divReqProposal">*</span></label>
                                                                                <div class="col-md-12">
                                                                                    <select class="form-control PRORequired TenantRequired ReservationRequired txtInqDisabled txtGlobalClear" id="txtProRentFreeCons" onchange="DelProRentConsStarDate(this.value)" style="background-color: white !important;">
                                                                                        <option value=''>-- Select Terms --</option>
                                                                                        <option value="0">Not Applicable</option>
                                                                                        <option value="15">15 Days</option>
                                                                                        <option value="30">30 Days</option>
                                                                                        <option value="45">45 Days</option>
                                                                                        <option value="60">60 Days</option>
                                                                                        <option value="75">75 Days</option>
                                                                                        <option value="90">90 Days</option>
                                                                                        <option value="105">105 Days</option>
                                                                                        <option value="120">120 Days</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-5">
                                                                            <div class="row form-group" id="divConsStartDate">
                                                                                <label class="col-md-12">Start Date</label>
                                                                                <div class="col-md-12">
                                                                                    <input type="text" class="form-control date-picker txtInqDisabled txtGlobalClear" id="txtProRentFreeConsStartDate" style="background-color: white !important;">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="grid3">
                                                            <div class="row form-group">
                                                                <div class="col-md-6">
                                                                    <div class="row form-group">
                                                                        <label class="col-md-12">Year(s)</label>
                                                                        <div class="col-md-12">
                                                                            <input type="text" class="form-control txtInqDisabled txtGlobalZero" id="txtNDTYearcount" onkeyup="getOccupancyDateTo(); fncgetEscalationSched();" onchange="getOccupancyDateTo(); fncgetEscalationSched();" maxlength="3" style="background-color: white !important;" onkeypress="return isNumberKey(event)">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="row form-group">
                                                                        <label class="col-md-12">Month(s)</label>
                                                                        <div class="col-md-12">
                                                                            <input type="text" class="form-control txtInqDisabled txtGlobalZero" onkeyup="getOccupancyDateTo(); fncgetEscalationSched();" onchange="getOccupancyDateTo(); fncgetEscalationSched();" id="txtNDTMonthcount" maxlength="3" style="background-color: white !important;" onkeypress="return isNumberKey(event)">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="row form-group">
                                                                        <label class="col-md-12">&nbsp;</label>
                                                                        <div class="col-md-12">
                                                                            <label>
                                                                                <input name="form-field-checkbox" type="checkbox" class="ace" id="chkGlobalisDaily" style="background-color: white !important;" maxlength="2">
                                                                                <span class="lbl"> Daily?</span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="row form-group">
                                                                        <label class="col-md-12">Day(s)</label>
                                                                        <div class="col-md-12">
                                                                            <input type="text" class="form-control txtInqDisabled txtGlobalZero" style="background-color: white !important;" onkeypress="return isNumberKey(event)" id="txtGlobalDayCount" onkeyup="getOccupancyDateTo(); fncgetEscalationSched();" onchange="getOccupancyDateTo(); fncgetEscalationSched();">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="row form-group">
                                                                        <label class="col-md-12">Month(s)</label>
                                                                        <div class="col-md-12">
                                                                            <input type="text" class="form-control PRORequired TenantRequired ReservationRequired txtInqDisabled txtGlobalZero" style="background-color: white !important;" id="txtGlobalSecDepMonth" onchange="fncChangeSecDep();" onkeyup="fncChangeSecDep();">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <div class="row form-group">
                                                                        <label class="col-md-12">Security Deposit</label>
                                                                        <div class="col-md-12">
                                                                            <input type="text" class="form-control amount PRORequired TenantRequired ReservationRequired txtInqDisabled txtGlobalZero2" style="background-color: white !important;text-align: right;" id="txtGlobalSecDepAmount" onkeypress="return isNumberKey(event)">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="row form-group">
                                                                        <label class="col-md-12">Month(s)</label>
                                                                        <div class="col-md-12">
                                                                            <input type="text" class="form-control PRORequired TenantRequired ReservationRequired txtInqDisabled txtGlobalZero" style="background-color: white !important;" id="txtGlobalAdvMonth" onkeyup="fncSaveFixedRent();" onchange="fncSaveFixedRent();">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <div class="row form-group">
                                                                        <label class="col-md-12">Advance Rent</label>
                                                                        <div class="col-md-12">
                                                                            <input type="text" class="form-control amount PRORequired TenantRequired ReservationRequired txtInqDisabled txtGlobalZero2" style="background-color: white !important;text-align: right;" id="txtGlobalAdvRent" onkeypress="return isNumberKey(event)">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="row form-group">
                                                                        <label class="col-md-12">Month(s)</label>
                                                                        <div class="col-md-12">
                                                                            <input type="text" class="form-control PRORequired TenantRequired ReservationRequired txtInqDisabled txtGlobalZero" style="background-color: white !important;" id="txtGlobalConBondMonth" onchange="fncChangeConBond();" onkeyup="fncChangeConBond();">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <div class="row form-group">
                                                                        <label class="col-md-12">Construction Bond</label>
                                                                        <div class="col-md-12">
                                                                            <input type="text" class="form-control amount PRORequired TenantRequired ReservationRequired txtInqDisabled txtGlobalZero2" style="background-color: white !important;text-align: right;" id="txtGlobalConBondAmount" onkeypress="return isNumberKey(event)">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="row form-group">
                                                                        <label class="col-md-12">Month(s)</label>
                                                                        <div class="col-md-12">
                                                                            <input type="text" class="form-control PRORequired TenantRequired ReservationRequired txtInqDisabled txtGlobalZero" style="background-color: white !important;" id="txtGlobalExhMonth" onkeyup="fncChangeExbBond();" onchange="fncChangeExbBond();">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <div class="row form-group">
                                                                        <label class="col-md-12">Exhibit Bond</label>
                                                                        <div class="col-md-12">
                                                                            <input type="text" class="form-control amount PRORequired TenantRequired ReservationRequired txtInqDisabled txtGlobalZero2" style="background-color: white !important;text-align: right;" id="txtGlobalExhAmount" onkeypress="return isNumberKey(event)">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="grid3">
                                                            <div class="row form-group">
                                                                <div class="col-md-12">
                                                                    <div class="row form-group">
                                                                        <div class="col-md-4">
                                                                            <div class="row form-group">
                                                                                <label class="col-md-12" style="white-space: nowrap;">Year Start <span class="red divReqProposal">*</span></label>
                                                                                <div class="col-md-12">
                                                                                    <span class="input-icon input-icon-right">
                                                                                        <input type="text" class="form-control PRORequired TenantRequired ReservationRequired txtInqDisabled txtGlobalZero" id="txtProEscaRateStart" maxlength="2" style="background-color: white !important;" onkeyup="fncgetEscalationSched(); fncgetPaymentSchedule();" onkeypress="return isNumberKey(event)">
                                                                                        <i class="ace-icon fa fa-question-circle blue hide" title="Based on occupancy"></i>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="row form-group">
                                                                                <label class="col-md-12" style="white-space: nowrap;">Year Basis <span class="red divReqProposal">*</span></label>
                                                                                <div class="col-md-12">
                                                                                    <span class="input-icon input-icon-right">
                                                                                        <input type="text" class="form-control PRORequired TenantRequired ReservationRequired txtInqDisabled txtGlobalZero" id="txtProEscaYearBasis" maxlength="2" style="background-color: white !important;" onkeyup="fncgetEscalationSched(); fncgetPaymentSchedule();" onkeypress="return isNumberKey(event)">
                                                                                        <i class="ace-icon fa fa-question-circle blue hide" title="Based on occupancy"></i>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="row form-group">
                                                                                <label class="col-md-12" style="white-space: nowrap;">Escalation Rate <span class="red divReqProposal">*</span></label>
                                                                                <div class="col-md-12">
                                                                                    <span class="input-icon input-icon-right">
                                                                                        <input type="text" class="form-control PRORequired TenantRequired ReservationRequired txtInqDisabled txtGlobalZero" id="txtProEscalationRate" style="background-color: white !important;" onkeyup="fncgetEscalationSched(); fncgetPaymentSchedule();" onkeypress="return isNumberKey(event)">
                                                                                        <i class="ace-icon fa fa-percent"></i>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="row form-group">
                                                                        <div class="col-md-12">
                                                                            <div style="height: 35vh;">
                                                                                <table class="table table-bordered table-striped fixTable">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th style="width: 50%;text-align: center;vertical-align: middle;">Year</th>
                                                                                            <th style="width: 50%;text-align: center;vertical-align: middle;z-index: 1;">Escalation Rate</th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody id="tbodyEscalation"></tbody>
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
                                    </div>
                                </div>
                            </div>
                            <?php } ?>

                            <?php if($_GET['url'] != 'inquiry'){ ?>
                            <!-- Payment Schedule -->
                            <div class="col-md-12 hide isadmin select-paymentschedule">
                                <div class="widget-container-col ui-sortable" id="widget-container-buyerinfo">
                                    <div class="widget-box transparent ui-sortable-handle collapsed" id="widget-box-12">
                                        <div class="widget-header">
                                            <h4 class="widget-title">Payment Schedule</h4>
                                            <div class="widget-toolbar no-border">
                                                <a href="#" data-action="collapse" class="clicktoshowall" id="GForm-PaymentSchedule">
                                                    <i class="ace-icon fa fa-chevron-down"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="widget-body" style="display: none;">
                                            <div class="widget-main">
                                                <div class="row well">
                                                    <div class="row form-group">
                                                        <div class="col-md-12">
                                                            <div class="parent2">
                                                                <div id="LoadPaySchedule"></div>
                                                                <table class="table table-bordered table-hover fixTable">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Date of Payment</th>
                                                                            <th>Charges</th>
                                                                            <th style="text-align: right;">Amount</th>
                                                                            <th style="text-align: right;">Escalation Rate</th>
                                                                            <th style="text-align: right;">Escalation</th>
                                                                            <th style="text-align: right;">Adjustment</th>
                                                                            <th>VAT</th>
                                                                            <?php if(SysLeaseSetup('isAssocDues') == "1"){ ?> 
                                                                            <th style="text-align: right;">Assoc. Due</th>
                                                                            <?php } ?>
                                                                            <th style="text-align: right;">Total</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="tblNDTPaymentSchedule" class="SomethingWasChanged ClearTableUponOpening"></tbody>
                                                                </table>
                                                            </div>
                                                            <table class="tabledash_footer table">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
                                                                            <font class="pull-right" id="txtNDTTotalAmount" style="margin-left: 15px;font-weight: bold;font-weight: 8px !important;"></font>
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <?php if($_GET['url'] == 'reservation'){ ?>
                                                    <div class="row form-group">
                                                        <div class="col-md-12">
                                                            <div class="row form-group">
                                                                <div class="col-md-12">
                                                                    <button class="btn btn-sm btn-primary pull-right btn-round txtInqDisabled" onclick='fncAddPayment();'>Add Payment</button>
                                                                </div>
                                                            </div>
                                                            <div class="row form-group">
                                                                <div class="col-md-12">
                                                                    <div style="height: 40vh;">
                                                                        <table class="table table-striped table-bordered table-hover fixTable">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Date of Payment</th>
                                                                                    <th>Payment Type</th>
                                                                                    <th>Reference</th>
                                                                                    <th>O.R No</th>
                                                                                    <th>Amount</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody id="tblResPayment"></tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>

                            <?php if($_GET['url'] != 'inquiry'){ ?>
                            <!-- Charges -->
                            <div class="col-md-12 hide isadmin select-charges">
                                <div class="widget-container-col ui-sortable" id="widget-container-requirements">
                                    <div class="widget-box transparent ui-sortable-handle collapsed" id="widget-box-12">
                                        <div class="widget-header">
                                            <h4 class="widget-title">Charges</h4>
                                            <div class="widget-toolbar no-border">
                                                <a href="#" data-action="collapse" class="clicktoshowall" id="GForm-Charges">
                                                    <i class="ace-icon fa fa-chevron-down"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="widget-body" style="display: none;">
                                            <div class="widget-main">
                                                <div class="row well">
                                                    <div class="row form-group">
                                                        <div class="col-md-12">
                                                            <div class="row form-group">
                                                                <div class="col-md-12">
                                                                    <button class="btn btn-sm btn-primary pull-right btn-round txtInqDisabled" onclick='showModalNDTAddCharges();$("#mdl_NDTAddCharges").modal("show");'>Add Charges</button>
                                                                </div>
                                                            </div>
                                                            <div class="row form-group">
                                                                <div class="col-md-12">
                                                                    <div style="height: 40vh;">
                                                                        <table class="table table-striped table-bordered table-hover fixTable">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th style="width: 40%;">Charge Description</th>
                                                                                    <th style="width: 25%;">Charge Type</th>
                                                                                    <th style="width: 25%;">Rate</th>
                                                                                    <th style="width: 10%;z-index: 1;">Option</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody id="tblNDTCharges"></tbody>
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
                            </div>
                            <?php } ?>

                            <?php if($_GET['url'] != 'inquiry'){ ?>
                            <!-- Requirements & Payment Status -->
                            <div class="col-md-12 hide isadmin select-requirementspermits">
                                <div class="widget-container-col ui-sortable" id="widget-container-requirements">
                                    <div class="widget-box transparent ui-sortable-handle collapsed" id="widget-box-12">
                                        <div class="widget-header">
                                            <h4 class="widget-title">Requirements and Permits</h4>
                                            <div class="widget-toolbar no-border">
                                                <a href="#" data-action="collapse" class="clicktoshowall" id="GForm-ReqPer">
                                                    <i class="ace-icon fa fa-chevron-down"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="widget-body" style="display: none;">
                                            <div class="widget-main">
                                                <div class="row well">
                                                    <div class="row form-group divReqPerProposal">
                                                        <div class="col-md-6">
                                                            <div class="row form-group">
                                                                <div class="col-md-12">
                                                                    <button class="btn btn-sm btn-primary btn-round pull-right txtInqDisabled" onclick='showModalAddRequirements();$("#mdl_AddRequirements").modal("show");'>Add Requirement</button>
                                                                </div>
                                                            </div>
                                                            <div class="row form-group">
                                                                <div class="col-md-12">
                                                                    <div class="parent">
                                                                        <table class="table table-striped table-bordered fixTable">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th style="width: 80%;">Requirements</th>
                                                                                    <th style="width: 20%;z-index: 1">Option</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody id="tblProRequirements"></tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="row form-group">
                                                                <div class="col-md-12">
                                                                    <button class="btn btn-sm btn-primary btn-round pull-right txtInqDisabled" onclick='showModalAddPermits();$("#mdl_AddPermits").modal("show");'>Add Permit</button>
                                                                </div>
                                                            </div>
                                                            <div class="row form-group">
                                                                <div class="col-md-12">
                                                                    <div class="parent">
                                                                        <table class="table table-striped table-bordered fixTable">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th style="width: 80%;">Permits</th>
                                                                                    <th style="width: 20%;z-index: 1">Option</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody id="tblProPermits"></tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group divReqPerProposal2">
                                                        <div class="col-md-12">
                                                            <div class="row form-group">
                                                                <div class="col-md-10">
                                                                    <h4 class="green">Requirements</h4>
                                                                    <input type="hidden" id="txtGFAddedReq">
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <button class="btn btn-sm btn-block btn-primary btn-round pull-right txtInqDisabled" onclick='showModalAddRequirements();$("#mdl_AddRequirements").modal("show");'>Add Requirement</button>
                                                                </div>
                                                            </div>
                                                            <div class="row form-group">
                                                                <div class="col-md-12" style="display: block;height: 279.4px;overflow-y: scroll;" id="div_modal_inquiry_requirements"></div>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="col-md-12">
                                                            <div class="row form-group">
                                                                <div class="col-md-10">
                                                                    <h4 class="green">Permits</h4>
                                                                    <input type="hidden" id="txtGFAddedPer">
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <button class="btn btn-sm btn-block btn-primary btn-round pull-right txtInqDisabled" onclick='showModalAddPermits();$("#mdl_AddPermits").modal("show");'>Add Permit</button>
                                                                </div>
                                                            </div>
                                                            <div class="row form-group">
                                                                <div class="col-md-12" style="display: block;height: 279.4px;overflow-y: scroll;" id="div_modal_inquiry_permits"></div>
                                                            </div>
                                                        </div>
                                                    </div>                                             
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>

                            <?php if($_GET['url'] == 'NotAvailable'){ ?>
                            <!-- Terms & Conditions -->
                            <div class="col-md-12 hide isadmin select-termsandconditions">
                                <div class="widget-container-col ui-sortable" id="widget-container-termsandconditions">
                                    <div class="widget-box transparent ui-sortable-handle collapsed" id="widget-box-12">
                                        <div class="widget-header">
                                            <h4 class="widget-title">Terms and Conditions</h4>
                                            <div class="widget-toolbar no-border">
                                                <a href="#" data-action="collapse" class="clicktoshowall" id="GForm-TermsAndCondition">
                                                  <i class="ace-icon fa fa-chevron-down"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="widget-body" style="display: none;">
                                            <div class="widget-main">
                                                <div class="row well">
                                                    <div class="row form-group">
                                                        <div class="col-md-12">
                                                            <button class="btn btn-primary btn-sm pull-right btn-round txtInqDisabled" onclick="showmodal_NDTtermsandcondition();">Add Terms and Conditions</button>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-md-12">
                                                            <div class="parent2">
                                                                <table class="table table-striped table-bordered fixTable">
                                                                    <thead>
                                                                        <tr>
                                                                            <th width="30%">Term Name</th>
                                                                            <th>Condition</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="div_termsandcondition"></tbody>
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
                            <?php } ?>

                            <div class="col-md-12 hide isadmin select-remarks">
                                <div class="widget-container-col ui-sortable" id="widget-container-buyerinfo">
                                    <div class="widget-box transparent ui-sortable-handle collapsed" id="widget-box-12">
                                        <div class="widget-header">
                                            <h4 class="widget-title">Remarks</h4>
                                            <div class="widget-toolbar no-border">
                                                <a href="#" data-action="collapse" class="clicktoshowall" id="GForm-Remarks">
                                                    <i class="ace-icon fa fa-chevron-down"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="widget-body" style="display: none;">
                                            <div class="widget-main">
                                                <div class="row well">
                                                    <div class="row form-group" id="divNewInquiryRemarks">
                                                        <div class="col-md-12">
                                                            <button class="btn btn-sm btn-primary pull-right btn-round" id="btnaddnewreeeeem" onclick="addnewremarks()">&nbsp;Add New Remarks</button>
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
                    <div class="col-md-6">
                        <div class="row form-group">
                            <div class="col-md-6">
                                <label class="updatedby_texts">
                                    <small class="text-success pull-left">
                                        <b>Created by:</b>&nbsp;<i id="txtinq_createdby"></i>
                                    </small>
                                    <small class="text-success pull-left">
                                        <b>Date Created:</b>&nbsp;<i id="txtinq_datecreated"></i>
                                    </small>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="modified_info">
                                    <small class="text-success pull-left">
                                        <b>Modified by:</b>&nbsp;<i id="txtinq_modifby"></i>
                                    </small>
                                    <small class="text-success pull-left">
                                        <b>Date Modified:</b>&nbsp;<i id="txtinq_modifdate"></i>
                                    </small>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 pull-right">
                        <button id="btnGlobalSave" class="btn btn-primary btn-sm btn-round btn-block txtInqDisabled" onclick="fncSaveGlobalForm('New');" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving..."><i class="ace-icon fa fa-check"></i>&nbsp;Save</button>
                    </div>
                     <?php if($_GET['url'] == 'inquiry'){ ?>
                    <div class="col-md-2 pull-right">
                        <button class="btn btn-success btn-sm btn-round btn-block txtInqDisabled" id="btnSend2Leasing" onclick="fncSendToLeasing();" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Creating..."><span class="fa fa-send"></span>&nbsp;Create Proposal</button>
                    </div>
                    <?php } ?>
                    <div class="col-md-2 pull-right" id="btncreateevents">
                        <button class="btn btn-warning btn-sm btn-round hide isadmin select-createevents btn-block txtInqDisabled"><span class="fa fa-pencil-square-o"></span>&nbsp;Create Events</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" role="dialog" id="modal_NDTtermsandcondition" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" style="width: 85%;">
        <div class="modal-content">
            <div id="NDTtermsandconditionloading"></div>
            <div class="modal-header">
                <button type="button" class="close" onclick="$('#modal_NDTtermsandcondition').modal('hide');">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Terms and Conditions</h4>
                <input type="hidden" class="txtGlobalClear" id="sonyxperiax2017">
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-md-12">
                        Group
                    </div>
                    <div class="col-md-3">
                        <select id="groupselection" onchange="showtblLNDTtermsandconditionlist();" class="form-control required"></select>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-12">
                        <div class="parent">
                            <table class="table table-hover table-bordered fixTable">
                                <thead>
                                    <tr>
                                        <th width='15%'>Group Name</th>
                                        <th width='30%'>Term Name</th>
                                        <th width='55%'>Condition</th>
                                    </tr>
                                </thead>
                                <tbody id="tblNDTtermsandconditionlist"></tbody>
                            </table>
                        </div>
                        <table class="tabledash_footer table" style="margin: 0px !important;">
                            <thead>
                                <tr>
                                    <th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
                                        <font id="txtLNDTTACenties" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
                                        <input id="txt_NDTTACselectuserpage" type="hidden">
                                        <ul id="ulLNDTTACpagination" class="pagination pull-right"></ul>
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm btn-round" onclick="addselection()"><i class="ace-icon fa fa-check"></i>&nbsp;Add Selected</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" id="mdl_NDTAddCharges" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Select Charges</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <span class="input-icon" style="width: 100%;">
                            <input type="text" class="form-control" id="txtSearchNDTCharges" title="Search" placeholder="Search">
                            <i class="ace-icon fa fa-search nav-search-icon"></i>
                        </span>
                    </div>
                    <div class=" col-xs-12 col-md-12 col-lg-12">
                        <div style="margin-top: 10px;" class="parent"> 
                            <table class="table table-bordered table-hover fixTable">
                                <thead>
                                    <tr>
                                        <th style="width: 20%;">Charge Code</th>
                                        <th style="width: 40%;">Charge Description</th>
                                        <th style="width: 20%;">Charge Type</th>
                                        <th style="width: 20%;">Rate</th>                   
                                    </tr>
                                </thead>
                                <tbody id="tblNDTAddCharges"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger btn-sm btn-round" onclick="$('#mdl_NDTAddCharges').modal('hide');">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" id="mdl_AddRequirements" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div id="frmLoadingGlobalFromSelectRequirement"></div>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Select Requirements</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-4 col-md-4 col-lg-4">
                        <span class="input-icon" style="width: 100%;">
                            <input type="text" class="form-control" id="txtSearchRequirement" title="Search" placeholder="Search">
                            <i class="ace-icon fa fa-search nav-search-icon"></i>
                        </span>
                    </div>
                    <div class="col-xs-12 col-md-12 col-lg-12">
                        <div style="margin-top: 10px;" class="parent"> 
                            <table class="table table-bordered table-hover fixTable">
                                <thead>
                                    <tr>
                                        <th style="width: 100%;">Requirement</th>                   
                                    </tr>
                                </thead>
                                <tbody id="tblAddRequirements"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger btn-sm btn-round" onclick="$('#mdl_AddRequirements').modal('hide');">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" id="mdl_AddPermits" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div id="frmLoadingGlobalFromSelectPermits"></div>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Select Permits</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-4 col-md-4 col-lg-4">
                        <span class="input-icon" style="width: 100%;">
                            <input type="text" class="form-control" id="txtSearchPermit" title="Search" placeholder="Search">
                            <i class="ace-icon fa fa-search nav-search-icon"></i>
                        </span>
                    </div>
                    <div class="col-xs-12 col-md-12 col-lg-12">
                        <div style="margin-top: 10px;" class="parent"> 
                            <table class="table table-bordered table-hover fixTable">
                                <thead>
                                    <tr>
                                        <th style="width: 100%;">Permits</th>                   
                                    </tr>
                                </thead>
                                <tbody id="tblAddPermits"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger btn-sm btn-round" onclick="$('#mdl_AddPermits').modal('hide');">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" id="mdl_NDTPayment" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Payment</h4>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-xs-12">
                        <div class="row form-group">
                            <label class="col-sm-12">Payment Type</label>
                            <div class="col-sm-12">
                                <select id="txtGlobalPaymentType" class="form-control required_inq searchy_select" onchange="fncChangePaymentType(this.value);"></select>
                            </div>
                        </div>
                        <!-- BANK TRANSFER -->
                        <div class="row form-group banktrans">
                            <label class="col-sm-12">Bank Name</label>
                            <div class="col-sm-12">
                                <select id="txtGlobalBankFrom" class="form-control banktrans ptbanktransfer selectbanktype"></select>
                            </div>
                        </div>
                        <div class="row form-group banktrans">
                            <label class="col-sm-12">Acc No.</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control banktrans ptbanktransfer" id="txtGlobalAccountFrom">
                            </div>
                        </div>
                        <div class="row form-group banktrans">
                            <label class="col-sm-12">Bank Name</label>
                            <div class="col-sm-12">
                                <select id="txtGlobalBankTo" class="form-control banktrans ptbanktransfer selectbanktype"></select>
                            </div>
                        </div>
                        <div class="row form-group banktrans">
                            <label class="col-sm-12">Acc No.</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control banktrans ptbanktransfer" id="txtGlobalAccoutnTo">
                            </div>
                        </div>
                        <!-- CREDIT OR DEBIT CARD -->
                        <div class="row form-group cardgroup debcardgroup">
                            <label class="col-sm-12">Card Type</label>
                            <div class="col-sm-12">
                                <select id="txtGlobalCardType" class="form-control cardgroup debcardgroup ptdebcard ptcredcard"></select>
                            </div>
                        </div>
                        <div class="row form-group cardgroup debcardgroup">
                            <label class="col-sm-12">Card Holder</label>
                            <div class="col-sm-12">
                                <input id="txtGlobalCardHolder" class="form-control cardgroup debcardgroup ptdebcard ptcredcard" disabled>
                            </div>
                        </div>
                        <div class="row form-group cardgroup debcardgroup">
                            <label class="col-sm-12">CC No</label>
                            <div class="col-sm-12">
                                <div class="row form-group">
                                    <div class="col-md-6">
                                        <input id="txtGlobalCC1" class="form-control cardgroup debcardgroup ptdebcard ptcredcard" disabled onkeypress="return isNumberKey(event)" maxlength="4" style="text-align: center;">
                                    </div>
                                    <div class="col-md-6">
                                        <input id="txtGlobalCC2" class="form-control cardgroup debcardgroup ptdebcard ptcredcard" disabled onkeypress="return isNumberKey(event)" maxlength="4" style="text-align: center;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="row form-group">
                                    <div class="col-md-6">
                                        <input id="txtGlobalCC3" class="form-control cardgroup debcardgroup ptdebcard ptcredcard" disabled onkeypress="return isNumberKey(event)" maxlength="4" style="text-align: center;">
                                    </div>
                                    <div class="col-md-6">
                                        <input id="txtGlobalCC4" class="form-control cardgroup debcardgroup ptdebcard ptcredcard" disabled onkeypress="return isNumberKey(event)" maxlength="4">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group cardgroup debcardgroup">
                            <label class="col-sm-12">Authorization No.</label>
                            <div class="col-sm-12">
                                <input id="txtGlobalAuthNo" disabled class="form-control cardgroup debcardgroup ptdebcard ptcredcard" maxlength="6">
                            </div>
                        </div>
                        <div class="row form-group cardgroup debcardgroup">
                            <label class="col-sm-12">
                                <h6>Security Code</h6>
                                <h6>CVV/CVC</h6>
                            </label>
                            <div class="col-sm-12">
                                <input id="txtGlobalSecCode" disabled class="form-control cardgroup debcardgroup ptdebcard ptcredcard" maxlength="3">
                            </div>
                        </div>
                        <div class="row form-group cardgroup" id="row_ex_date">
                            <label class="col-sm-12">Exp. Date</label>
                            <div class="col-sm-4">
                                <select id="txtGlobalExpDateMonth" disabled class="form-control cardgroup ptcredcard">
                                    <option value="01">01</option>
                                    <option value="02">02</option>
                                    <option value="03">03</option>
                                    <option value="04">04</option>
                                    <option value="05">05</option>
                                    <option value="06">06</option>
                                    <option value="07">07</option>
                                    <option value="08">08</option>
                                    <option value="09">09</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <select id="txtGlobalExpDateYear" disabled class="form-control cardgroup ptcredcard">
                                    <option value="<?php echo date('Y'); ?>"><?php echo date('Y'); ?></option>
                                        <?php                       
                                        for($b = 1; $b <= 10; $b++){
                                            $timestamp2 = strtotime('+'. $b .' years');
                                            $forval2 = date('Y', $timestamp2);
                                            ?>
                                                <option value="<?php echo $forval2; ?>"><?php echo $forval2; ?></option>
                                            <?php
                                        } ?>
                                </select>
                            </div>
                        </div>
                        <!-- CHECK -->
                        <div class="row form-group checkgroup">
                            <label class="col-sm-12">Check No.</label>
                            <div class="col-sm-12">
                                <input type="text" id="txtGlobalCheckNo" class="form-control checkgroup ptcheck" style="" disabled>
                            </div>
                        </div>
                        <div class="row form-group checkgroup">
                            <label class="col-sm-12">Check Date</label>
                            <div class="col-sm-12">
                                <input id="txtGlobalCheckDate" class="form-control date-picker checkgroup ptcheck" disabled>
                            </div>
                        </div>
                        <div class="row form-group checkgroup">
                            <label class="col-sm-12">Check Name</label>
                            <div class="col-sm-12">
                                <input id="txtGlobalCheckName" class="form-control checkgroup ptcheck" disabled>
                            </div>
                        </div>
                        <div class="row form-group checkgroup">
                            <label class="col-sm-12">Bank Name</label>
                            <div class="col-sm-12">
                                <select id="txtGlobalCheckBank" class="form-control checkgroup ptcheck selectbanktype" disabled></select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-12">Amount</label>
                            <div class="col-sm-12">
                                <input id="txtGlobalPayment" class="form-control amount thisisrequired" placeholder="0.00" onkeypress="return isNumberKey(event)" style="text-align: right;">
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-12">O.R. No.</label>
                            <div class="col-sm-12">
                                <input id="txtPaymentORNo" class="form-control thisisrequired"name="txtpaymentorno">
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-12">Reference</label>
                            <div class="col-sm-12">
                                <textarea style="width: 100%; height: 100px;resize: none;" id="txtPaymentParticulars"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="btnPostPayment" class="btn btn-primary btn-sm btn-round" onclick="fncSavePayment();" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Posting Payment...">Post Payment</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" id="mdlContractStat" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Contract Approval</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div id="divContractStat"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success btn-sm btn-round" id="btnContractApprove">Approve</button>
                <button class="btn btn-danger btn-sm btn-round" id="btnContractDisapprove">Disapprove</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" id="mdl_ShowTenantID" role="dialog" area-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xs" style="width: 30%;">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-md-12">
                        <center><h3>Your <?php if(SysLeaseSetup('softwaretype') == '5'){ echo "Buyer"; }else{ echo "Tenants"; } ?> Code is:</h3></center>
                    </div>
                    <div class="col-md-12">
                        <center><h2 style="font-weight:bold;" id="txtReservationTenantID"></h2></center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" id="mdlProposalselectprint" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Select Report Layout</h4>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-md-12">
                        <div id="btnProposalxPreview"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" id="div_ProposalPreview" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;" id="<!-- txtProposalHeader -->"></h4>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-md-1 pull-right">
                        <button class="btn btn-primary btn-round btn-sm" onclick="fncPrintProposal()">Print</button>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-12">
                        <div id="div_CustomProposal"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" id="mdlAddSelectedCharge" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-sm" style="width: 30%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Add Charge</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row form-group">
                            <label class="col-md-12">Charge Code</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" id="txtACChargeCoe" readonly style="background-color: white !important;">
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-12">Charge Description</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" id="txtAcChargeDesc" readonly style="background-color: white !important;">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-6">
                                <div class="row form-group">
                                    <label class="col-md-12">Original Rate</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" readonly id="txtACOrigRate" style="background-color: white !important;text-align: right;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row form-group">
                                    <label class="col-md-12">Amount</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control amount" style="background-color: white !important;text-align: right;" id="txtACAmount" onkeypress="return isNumberKey(event)">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row form-group">
                                    <label class="col-md-12">Unit</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" readonly id="txtACUnit" style="background-color: white !important;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>              
            </div>
            <div class="modal-footer">
                <div class="btn-group">
                    <button class="btn btn-sm btn-primary btn-round" onclick="fncAddSelectedCharge();">Add</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("script.php"); ?>
<?php include("include/mdl_Address.php"); ?>
<?php include("include/mdl_Company.php"); ?>
<?php include("include/mdl_ContactPerson.php"); ?>
<?php include("include/mdl_Remarks.php"); ?>
<?php include("include/mdl_Trade.php"); ?>
<?php include("include/mdl_Trade_ContactPerson.php"); ?>
<?php include("include/mdl_UnitInfo.php"); ?>