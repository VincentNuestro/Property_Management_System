<style>
    @media screen {div.divFooter {display: none;}}
    .paddleft{
        padding-left: 10px;
    }
    .paddright{
        padding-right: 5px;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="row form-group" style="margin-bottom: 0px;">
            <div class="col-md-2 col-xs-12" style="padding-bottom: 5px;padding-left: 0px;">
                <span class="input-icon" style="width: 100%;">
                    <input type="text" class="form-control" placeholder="Search"  title="Search" id="txtsearchapplication">
                    <i class="ace-icon fa fa-search nav-search-icon"></i>
                </span>
            </div>
            <div class="col-md-2 hidden-xs"></div>
             <div class="col-md-2 col-xs-12" style="padding-bottom: 5px;padding-right: 0px;">
                <button class="btn btn-success btn-sm hide isadmin select btn-round btn-block" onclick='fncShowMdlImportBev();'>&nbsp;Import Bev
                </button>
            </div>
            <div class="col-md-2 col-xs-12" style="padding-bottom: 5px;padding-right: 0px;">
                <button class="btn btn-danger btn-sm hide isadmin select-fastposting btn-round btn-block" onclick='fncmdlFastPosting();'>&nbsp;Fast Posting
                </button>
            </div>
            <div class="col-md-2 col-xs-6" style="padding-bottom: 5px;padding-right: 0px;">
                <button class="btn btn-warning btn-sm hide isadmin select-enterpayment btn-round btn-block" onclick="openpaymentmodule()">&nbsp;Collection
                </button>
            </div>
            <div class="col-md-2 col-xs-6" style="padding-bottom: 5px;padding-right: 0px;">
                 <button class="btn btn-purple btn-sm hide isadmin select-billingsoa btn-round btn-block" onclick="fncShowModalForSOA();">&nbsp;Billing
                </button>
            </div>
            <!-- <div class="col-md-2 col-xs-6" style="padding-bottom: 5px;padding-right: 0px;">
                <a href="#" class="btn btn-primary btn-sm hide isadmin select-cashieraudit btn-round btn-block" onclick='opencashieraudit();'>&nbsp;Cashier's Audit
                </a>
            </div>
            <div class="col-md-2 col-xs-6" style="padding-bottom: 5px;padding-right: 0px;">
                <a href="#" class="btn btn-success btn-sm hide isadmin select-vieworlist btn-round btn-block" onclick='$("#modal_orlist").modal("show");loadtblorlist("<?php echo "view"; ?>");'>&nbsp;Browse O.R List
                </a>
            </div> -->
        </div>
        <div class="row form-group" style="margin-bottom: 0px !important;">
            <div class="parent">
                <table id="simple-table" class="table table-bordered fixTable">
                    <thead>
                        <tr>
                            <th class="hide_mobile"><?php if(SysLeaseSetup('softwaretype') == '5'){ echo "Buyer"; }else{ echo "Tenant"; } ?> ID</th>
                            <th class="scroll thSysTenant">Store Name</th>
                            <th class="hide_mobile">Company</th>
                            <th class="scroll" style="z-index: 1;">Billing Type</th>
                            <th class="scroll">Total Balance</th>
                            <th class="hide_mobile" style="z-index: 1;">Options</th>
                        </tr>
                    </thead>
                    <tbody id="tbltenantlists"></tbody>
                </table>
            </div>
            <table class="tabledash_footer table" style="margin: 0px !important;">
                <thead>
                    <tr>
                        <th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
                            <font  id="txtbillingentries" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
                            <input  id="txt_userpage" type="hidden">
                            <ul id="ulpaginationbilling" class="pagination pull-right"></ul>
                        </th>
                    </tr>
                </thead>
            </table>
        </div> 
    </div>
</div>

<!-- TRANSACTION BILLING -->
<div class="modal fade fade-scale" id="mdlTransactionBilling" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" style="width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Transaction Billing</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-3">
                        <div id="imgledgerhere"><img class="img-responsive img-thumbnail" style="max-height: 200px; width: 100%;" id="imglogo" src=""></div>
                    </div>
                    <div class="col-md-9">  
                        <h2 class="blue">
                            <span class="middle" id="txtbillingtradename"></span>
                        </h2>
                        <div class="col-md-6">
                            <div class="profile-user-info">
                                <div class="profile-info-row">
                                    <div class="profile-info-name" style="white-space: nowrap;"> Company Name </div>

                                    <div class="profile-info-value">
                                        <span id="txtbillingcompanyname"></span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name txtSysBuilding">  </div>

                                    <div class="profile-info-value">
                                        <span id="txtbillingmallbranch"></span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> Billing Type </div>

                                    <div class="profile-info-value">
                                        <span id="txtbillingtype"></span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> &nbsp; </div>

                                    <div class="profile-info-value">
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="profile-user-info">
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> <?php if(SysLeaseSetup('softwaretype') == '5'){ echo "Buyer"; }else{ echo "Tenant"; } ?> ID </div>

                                    <div class="profile-info-value">
                                        <span id="txtbillingtenantid"></span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> Merchant Code </div>

                                    <div class="profile-info-value">
                                        <span id="txtbillingstorecode"></span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name" style="white-space: nowrap;"> Running Balance </div>

                                    <div class="profile-info-value">
                                        <span id="windowtotal"></span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> &nbsp; </div>

                                    <div class="profile-info-value">
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2 pull-right">
                        <button class="btn btn-purple btn-block btn-sm btn-round">Changes</button>
                    </div>
                    <div class="col-md-2 pull-right">
                        <button class="btn btn-primary btn-block btn-sm btn-round" onclick="fncmdlTBSoA();">Print SOA</button>
                    </div>
                    <div class="col-md-2 pull-right">
                        <button class="btn btn-success btn-block btn-sm btn-round" onclick="fncShowSettlement();">Settlement</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="widget-box widget-color-blue3 collapsed">
                            <div class="widget-header">
                                <h5 class="widget-title">Charges</h5>
                                <div class="widget-toolbar">
                                    <a href="#" data-action="collapse">
                                        <i class="ace-icon fa bigger-125 fa-chevron-down"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="widget-body" style="display: none;">
                                <div class="widget-main" style="padding:0px;">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="parent3">
                                                <table class="table table-bordered fixTable">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 10%;background-color: #6379AA;color: white;">Date</th>
                                                            <th style="width: 20%;background-color: #6379AA;color: white;">Charges</th>
                                                            <th style="width: 20%;background-color: #6379AA;color: white;">Reference</th>
                                                            <!-- <th style="width: 5%;background-color: #6379AA;color: white;display: none;">Quantity</th> -->
                                                            <th style="width: 10%;background-color: #6379AA;color: white;text-align: right;">Amount</th>
                                                            <th style="width: 10%;background-color: #6379AA;color: white;text-align: right;">VAT</th>
                                                            <th style="width: 10%;white-space: nowrap;background-color: #6379AA;color: white;text-align: right;">Total Amount</th>
                                                            <th style="width: 10%;white-space: nowrap;background-color: #6379AA;color: white;text-align: right;">Paid Amount</th>
                                                            <th style="width: 10%;background-color: #6379AA;color: white;text-align: right;">Balance</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="TransBillChargeList"></tbody>
                                                </table>
                                            </div>
                                            <table class="tabledash_footer table" style="margin: 0px !important;">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 48%;padding-top: 10px;padding-bottom: 10px;background-color: #6379AA;color: white;">
                                                            <button class="btn btn-sm btn-round btn-warning" onclick="fncOpenmdlAdjustment('TransBillChargeList');" id="btnAdjCharge" disabled>Rebate</button>
                                                        </th>
                                                        <th style="width: 10%;padding-top: 10px;padding-bottom: 10px;background-color: #6379AA;color: white;">
                                                            <font id="txtTotChargeAmount" class="pull-right" style="margin-left: 15px;font-weight: bold;font-weight: 8px !important;"></font>
                                                        </th>
                                                        <th style="width: 10%;padding-top: 10px;padding-bottom: 10px;background-color: #6379AA;color: white;">
                                                            <font id="txtTotChargeTotalVAT" class="pull-right" style="margin-left: 15px;font-weight: bold;font-weight: 8px !important;"></font>
                                                        </th>
                                                        <th style="width: 10%;padding-top: 10px;padding-bottom: 10px;background-color: #6379AA;color: white;">
                                                            <font id="txtTotChargeTotalAmount" class="pull-right" style="margin-left: 15px;font-weight: bold;font-weight: 8px !important;"></font>
                                                        </th>
                                                        <th style="width: 10%;padding-top: 10px;padding-bottom: 10px;background-color: #6379AA;color: white;">
                                                            <font id="txtTotChargePaidAmount" class="pull-right" style="margin-left: 15px;font-weight: bold;font-weight: 8px !important;"></font>
                                                        </th>
                                                        <th style="width: 10%;padding-top: 10px;padding-bottom: 10px;background-color: #6379AA;color: white;">
                                                            <font id="txtTotChargeBalance" class="pull-right" style="margin-left: 15px;font-weight: bold;font-weight: 8px !important;"></font>
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
                    <div class="col-md-12">
                        <div class="widget-box widget-color-blue3 collapsed">
                            <div class="widget-header">
                                <h5 class="widget-title">Payments</h5>
                                <div class="widget-toolbar">
                                    <a href="#" data-action="collapse">
                                        <i class="ace-icon fa bigger-125 fa-chevron-down"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="widget-body" style="display: none;">
                                <div class="widget-main" style="padding:0px;">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="parent3">
                                                <table class="table table-bordered fixTable">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 10%;background-color: #6379AA;color: white;">Date</th>
                                                            <th style="width: 25%;background-color: #6379AA;color: white;">Description</th>
                                                            <th style="width: 10%;background-color: #6379AA;color: white;">OR No.</th>
                                                            <th style="width: 20%;white-space: nowrap;background-color: #6379AA;color: white;">Reference</th>
                                                            <th style="width: 12%;background-color: #6379AA;color: white;text-align: right;">Amount</th>
                                                            <th style="width: 12%;background-color: #6379AA;color: white;text-align: right;">Applied Amount</th>
                                                            <th style="width: 11%;background-color: #6379AA;color: white;text-align: right;">Remaining</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="TransBillPaymentList"></tbody>
                                                </table>
                                            </div>
                                            <table class="tabledash_footer table" style="margin: 0px !important;">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 10%;padding-top: 10px;padding-bottom: 10px;background-color: #6379AA;color: white;">
                                                            <button class="btn btn-sm btn-round btn-warning" onclick="fncOpenmdlAdjustment('TransBillPaymentList');" id="btnAdjPayment" disabled>Rebate</button>
                                                        </th>
                                                        <th style="width: 25%;padding-top: 10px;padding-bottom: 10px;background-color: #6379AA;color: white;">
                                                            <font class="pull-right" style="margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
                                                        </th>
                                                        <th style="width: 10%;padding-top: 10px;padding-bottom: 10px;background-color: #6379AA;color: white;">
                                                            <font class="pull-right" style="margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
                                                        </th>
                                                        <th style="width: 20%;padding-top: 10px;padding-bottom: 10px;background-color: #6379AA;color: white;">
                                                            <font class="pull-right" style="margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
                                                        </th>
                                                        <th style="width: 12%;padding-top: 10px;padding-bottom: 10px;background-color: #6379AA;color: white;">
                                                            <font id="txtTotPaymentAmount" class="pull-right" style="margin-left: 15px;font-weight: bold;font-weight: 8px !important;"></font>
                                                        </th>
                                                        <th style="width: 12%;padding-top: 10px;padding-bottom: 10px;background-color: #6379AA;color: white;">
                                                            <font id="txtTotPaymentApplied" class="pull-right" style="margin-left: 15px;font-weight: bold;font-weight: 8px !important;"></font>
                                                        </th>
                                                        <th style="width: 11%;padding-top: 10px;padding-bottom: 10px;background-color: #6379AA;color: white;">
                                                            <font id="txtTotPaymentRemaining" class="pull-right" style="margin-left: 15px;font-weight: bold;font-weight: 8px !important;"></font>
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
            <div class="modal-footer"></div>
        </div>
    </div>
</div>

<!-- FAST POSTING -->
<div class="modal fade fade-scale" id="mdlFastPosting" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" style="width: 98%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Fast Posting</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-3 col-xs-12">
                        <div class="row form-group">
                            <div class="col-md-12">
                                <div class="widget-box widget-color-blue3">
                                    <div class="widget-header">
                                        <h5 class="widget-title txtPanelHeader">Tenant Information</h5>
                                    </div>
                                    <div class="widget-body">
                                        <div class="widget-main padding-6"> 
                                            <div class="well">
                                                <div class="row">
                                                    <div class="row form-group">
                                                        <label class="col-md-12">Transaction Date</label>
                                                        <div class="col-md-12">
                                                            <input type="text" class="form-control date-picker" style="background-color: white !important;" disabled id="txtFPTransDate">
                                                        </div>
                                                    </div>
                                                    <div class="row form-group <?php session_start(); if($_SESSION['MMS-Designation'] == "Superuser" || $_SESSION['MMS-Designation'] == "GatessoftCorp"){ }else{ ?> hide <?php } ?>">
                                                        <label class="col-md-12 txtSysBuilding"></label>
                                                        <div class="col-md-12">
                                                            <select class="form-control" id="txtFPMall" onchange="showTenantList();"></select>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <label class="col-md-12 thSysTenant">Tenant</label>
                                                        <div class="col-md-12" id="divFPTenant">
                                                            <select class="form-control txtFPInitiateClear searchy_select" id="txtFPTenant" onchange="showTenantInfo();" style="width: 100%;"></select>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-md-12">
                                                            <div class="row form-group">
                                                                <label class="col-md-12">Status</label>
                                                                <div class="col-md-12">
                                                                    <input type="text" class="form-control txtFPInitiateClear" style="background-color: white !important;" readonly id="txtFPStatus">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <label class="col-md-12">Billing Type</label>
                                                        <div class="col-md-12">
                                                            <input type="text" class="form-control txtFPInitiateClear" style="background-color: white !important;" readonly id="txtFPBillingType">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="widget-toolbox padding-8 clearfix">
                                        <button id="btnFastPosting" class="btn btn-primary btn-sm pull-right btn-round" style="float: right;" onclick="PostFPCharges()" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Posting Charges..."><i class="ace-icon fa fa-thumb-tack"></i>&nbsp;Post Charges</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9 col-xs-12">
                        <div class="row form-group">
                            <div class="col-md-12">
                                <div class="btn-group pull-right">
                                    <button class="btn btn-sm btn-info btn-round" onclick="fncCheckTenantFirst();">Add Charge</button>
                                    <button class="btn btn-sm btn-success btn-round" onclick="btnFPSelectAll();">Select All</button>
                                    <button class="btn btn-sm btn-warning btn-round" onclick="btnFPUnselectAll();">Unselect All</button>
                                    <button class="btn btn-sm btn-danger btn-round" onclick="btnFPRemoveSelected();">Remove Charge</button>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group" style="margin-top: -10px;">
                            <div class="col-md-12">
                                <div class="widget-box widget-color-blue3">
                                    <div class="widget-body" style="height: 390px;">
                                        <div class="widget-main" style="padding: 0px;">
                                            <div>
                                                <table class="table table-bordered table-hover fixTable">
                                                    <thead>
                                                        <tr>
                                                            <th style="background-color: #6379AA;color: white;width: 15%;">Date</th>
                                                            <th style="background-color: #6379AA;color: white;width: 20%;">Charges</th>
                                                            <th style="background-color: #6379AA;color: white;width: 15%;">Reference</th>
                                                            <th style="background-color: #6379AA;color: white;width: 5%;display: none;">Qty</th>
                                                            <th style="background-color: #6379AA;color: white;width: 13%;text-align: right;">Amount</th>
                                                            <th style="background-color: #6379AA;color: white;width: 13%;text-align: right;">VAT</th>
                                                            <th style="background-color: #6379AA;color: white;width: 14%;text-align: right;">Total Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbodyFPChargeList"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="widget-toolbox padding-8 clearfix">
                                        <div class="row">
                                            <div class="col-lg-9 col-xs-6" style="font-weight: bold;text-align: right;">
                                                <p style="margin-bottom: 0px; font-size: 19.5px;">Total Amount :</p>
                                            </div>
                                            <div class="col-lg-3 col-xs-6" style="font-weight: bold;">
                                                <p id="txtFPTotalCharges" style="text-align: right;margin-bottom: 0px; font-size: 19.5px;">0.00</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>      
                            </div>
                        </div>
                    </div>
                    <div class="form-group row" style="margin-bottom: 0px;">
                        <div class="col-lg-12 col-xs-12">
                            <div class="hr hr8 hr-double hr-dotted"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ADD CHARGE -->
<div class="modal fade fade-scale" id="mdlAddCharge" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Select Charges</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-4 col-md-4 col-lg-4">
                        <span class="input-icon" style="width: 100%;">
                            <input type="text" class="form-control" id="txtFPChargeListSearch" title="Search" placeholder="Search">
                            <i class="ace-icon fa fa-search nav-search-icon"></i>
                        </span>
                    </div>
                    <div class=" col-xs-12 col-md-12 col-lg-12">
                        <div class="parent" style="margin-top: 10px;">
                            <table class="table table-bordered table-hover fixTable">
                                <thead>
                                    <tr>
                                        <th style="width: 50%;">Charges</th>
                                        <th style="width: 25%;">Unit</th>
                                        <th style="width: 25%;">Rate</th>
                                    </tr>
                                </thead>
                                <tbody id="tblFPChargeList"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-danger btn-round" id="wotaskmodalclose" onclick='$("#addingofwotaskmodal").modal("hide");'>Close</button>
            </div>
        </div>
    </div>
</div>

<!-- ADD QUANTITY -->
<div class="modal fade fade-scale" id="mdlInputQuantity" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-sm" style="width: 30%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Post Charges</h4>
            </div>
            <div class="modal-body">
                <!-- <div class="row hide" id="div_FPOther">
                    <div class="col-md-12">
                        <fieldset style="margin-bottom: 10px;border: 1px solid #CCC;padding: 8px;margin-top: 0px;">
                            <legend class="green" style="border: none;margin-bottom: 0px;font-size: 16px; font-weight: normal;width:125px;">&nbsp;&nbsp;Enter Amount&nbsp;&nbsp;</legend>
                            <div class="row form-group">
                                <div class="col-md-12">
                                    <input type="text" class="form-control txtFPHiddenValue amount" style="text-align: right;" id="txtFPChargeAmount" onkeypress="return isNumberKey(event)">
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div> -->
                <div class="row">
                    <input type="hidden" class="txtFPHiddenValue" id="txtFPChargeID">
                    <input type="hidden" class="txtFPHiddenValue" id="txtFPRateType">
                    <div class="col-md-12">
                        <div class="row form-group">
                            <label class="col-md-12">Charge Name</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control txtFPHiddenValue" id="txtFPDescription" readonly style="background-color: white !important;">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-5">
                                <div class="row form-group">
                                    <label class="col-md-12">Rate</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control txtFPHiddenValue amount" id="txtFPRate" style="background-color: white !important;text-align: right;" onkeypress="return isNumberKey(event)" onkeyup="getTotalAmount();">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="row form-group">
                                    <label class="col-md-12">Quantity</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" style="background-color: white !important;text-align: center;" id="txtFPChargeCount" onkeypress="return isNumberKey(event)" onkeyup="getTotalAmount();">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="row form-group">
                                    <label class="col-md-12">Amount</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" readonly style="background-color: white !important;text-align: right;" id="txtFPTotalAmount">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row form-group">
                                    <label class="col-md-12">Reference</label>
                                    <div class="col-md-12">
                                        <textarea class="form-control" style="resize: none;height: 100px;" id="txtFPBillingParticulars"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-md-12 hide">
                        <div class="input-group col-xs-12 col-md-12 col-lg-12">
                            <input type="text" class="form-control" id="txtFPChargeCount" readonly style="background-color: white !important; text-align: right;">
                        </div>
                        <div class="row form-group" style="margin-top: 10px;margin-right: 5px;">
                            <div class="col-xs-4 col-md-4 col-lg-4">
                               <button class="btn btn-sm btn-block btn-app btn-light btn-round" onclick="btnAddCount('1');">1</button>
                            </div>
                            <div class="col-xs-4 col-md-4 col-lg-4">
                               <button class="btn btn-sm btn-block btn-app btn-light btn-round" onclick="btnAddCount('2');">2</button>
                            </div>
                            <div class="col-xs-4 col-md-4 col-lg-4">
                               <button class="btn btn-sm btn-block btn-app btn-light btn-round" onclick="btnAddCount('3');">3</button>
                            </div>
                        </div>
                        <div class="row form-group" style="margin-right: 5px;">
                            <div class="col-xs-4 col-md-4 col-lg-4">
                               <button class="btn btn-sm btn-block btn-app btn-light btn-round" onclick="btnAddCount('4');">4</button>
                            </div>
                            <div class="col-xs-4 col-md-4 col-lg-4">
                               <button class="btn btn-sm btn-block btn-app btn-light btn-round" onclick="btnAddCount('5');">5</button>
                            </div>
                            <div class="col-xs-4 col-md-4 col-lg-4">
                               <button class="btn btn-sm btn-block btn-app btn-light btn-round" onclick="btnAddCount('6');">6</button>
                            </div>
                        </div>
                        <div class="row form-group" style="margin-right: 5px;">
                            <div class="col-xs-4 col-md-4 col-lg-4">
                               <button class="btn btn-sm btn-block btn-app btn-light btn-round" onclick="btnAddCount('7');">7</button>
                            </div>
                            <div class="col-xs-4 col-md-4 col-lg-4">
                               <button class="btn btn-sm btn-block btn-app btn-light btn-round" onclick="btnAddCount('8');">8</button>
                            </div>
                            <div class="col-xs-4 col-md-4 col-lg-4">
                               <button class="btn btn-sm btn-block btn-app btn-light btn-round" onclick="btnAddCount('9');">9</button>
                            </div>
                        </div>
                        <div class="row form-group" style="margin-right: 5px;">
                            <div class="col-xs-4 col-md-4 col-lg-4">
                               <button class="btn btn-sm btn-block btn-app btn-light btn-round">&nbsp;</button>
                            </div>
                            <div class="col-xs-4 col-md-4 col-lg-4">
                               <button class="btn btn-sm btn-block btn-app btn-light btn-round" onclick="btnAddCount('0');">0</button>
                            </div>
                            <div class="col-xs-4 col-md-4 col-lg-4">
                               <button class="btn btn-sm btn-block btn-app btn-light btn-round" onclick="btnAddCount('C');">C</button>
                            </div>
                        </div>
                    </div> -->
                </div>              
            </div>
            <div class="modal-footer">
                <div class="btn-group">
                    <button class="btn btn-sm btn-primary btn-round" onclick="AddSelectedCharge();">Add</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- COLLECTION -->
<div class="modal fade fade-scale" id="modal_PaymetModal" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog" style="width: 98%;">
        <div class="modal-content">
        <div id="paymentmodalloadingscreen"></div>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" onclick="closepaymentmodal(); closevieworlistwindow();">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Collection</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="widget-box widget-color-blue3">
                            <div class="widget-header">
                                <h5 class="widget-title">Payment</h5>
                            </div>

                            <div class="widget-body">
                                <div class="widget-main padding-6"> 
                                    <div class="well" style="display: block;height:425px;overflow-y: auto;margin-bottom: 0px;overflow-x: hidden;">
                                        <div class="row form-group hide">
                                            <label class="col-md-4"></label>
                                            <div class="col-md-8">
                                                <input type="text" class="date-picker form-control" id="txtinfotransdate">
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <label class="col-md-12 thSysTenant"></label>
                                            <div class="col-md-12" id="divtxtinfostorename">
                                                <select class="form-control required_inq searchy_select" id="txtinfostorename" onchange="loadbalancelist(this.value, 'Yes');" style="width: 100%;" data-placeholder="-- Select <?php if(SysLeaseSetup('softwaretype') == '5'){ echo "Buyer"; }else if(SysLeaseSetup('softwaretype') == '0'){ echo "Store"; }else{ echo "Tenant"; } ?> --"></select>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <label class="col-md-12">Payment Type</label>
                                            <div class="col-md-12" id="divtxtpaymenttype">
                                                <select id="txtpaymenttype" class="form-control required_inq searchy_select" onchange="changepayment(this.value, 'Default');" style="width: 100%;" data-placeholder="-- Select Payment Type --"></select>
                                            </div>
                                        </div>
                                        <!-- BANK TRANSFER -->
                                        <div class="row form-group banktrans">
                                            <label class="col-md-12">Bank Name</label>
                                            <div class="col-md-12" id="divtxtbanknamefrom">
                                                <select id="txtbanknamefrom" class="form-control banktrans ptbanktransfer selectbanktype searchy_select" data-placeholder="-- Select Bank --"></select>
                                            </div>
                                        </div>
                                        <div class="row form-group banktrans">
                                            <label class="col-md-12">Acc No.</label>
                                            <div class="col-md-12">
                                                <input type="text" class="form-control banktrans ptbanktransfer" name="" id="txtbankaccfrom">
                                            </div>
                                        </div>
                                        <div class="row form-group hide">
                                            <label class="col-md-12">Bank Name</label>
                                            <div class="col-md-12">
                                                <select id="txtbanknameto" class="form-control searchy_select" data-placeholder="-- Select Bank --"></select>
                                            </div>
                                        </div>
                                        <div class="row form-group hide">
                                            <label class="col-md-12">Acc No.</label>
                                            <div class="col-md-12">
                                                <input type="text" class="form-control " name="" id="txtbankaccto">
                                            </div>
                                        </div>
                                        <!-- CREDIT OR DEBIT CARD -->
                                        <div class="row form-group cardgroup debcardgroup">
                                            <label class="col-md-12">Card Type</label>
                                            <div class="col-md-12" id="divtxtcardtype">
                                                <select id="txtcardtype" class="form-control cardgroup debcardgroup ptdebcard ptcredcard searchy_select" style="width: 100%;" data-placeholder="-- Card Type --"></select>
                                            </div>
                                        </div>
                                        <div class="row form-group cardgroup debcardgroup">
                                            <label class="col-md-12">Card Holder</label>
                                            <div class="col-md-12">
                                                <input id="txtpaymentccholder" class="form-control cardgroup debcardgroup ptdebcard ptcredcard" disabled>
                                            </div>
                                        </div>
                                        <div class="row form-group cardgroup debcardgroup">
                                            <label class="col-md-12">CC No</label>
                                            <div class="col-md-12">
                                                <div class="row form-group">
                                                    <div class="col-md-6">
                                                        <input id="txtpaymentccno1" class="form-control cardgroup debcardgroup ptdebcard ptcredcard" disabled onkeypress="return isNumberKey(event)" maxlength="4" style="text-align: center;">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input id="txtpaymentccno2" class="form-control cardgroup debcardgroup ptdebcard ptcredcard" disabled onkeypress="return isNumberKey(event)" maxlength="4" style="text-align: center;">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="row form-group">
                                                    <div class="col-md-6">
                                                        <input id="txtpaymentccno3" class="form-control cardgroup debcardgroup ptdebcard ptcredcard" disabled onkeypress="return isNumberKey(event)" maxlength="4" style="text-align: center;">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input id="txtpaymentccno4" class="form-control cardgroup debcardgroup ptdebcard ptcredcard" disabled onkeypress="return isNumberKey(event)" maxlength="4" style="text-align: center;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row form-group cardgroup debcardgroup">
                                            <label class="col-md-12">Authorization No.</label>
                                            <div class="col-md-12">
                                                <input id="txtccauthno" disabled class="form-control cardgroup debcardgroup ptdebcard ptcredcard" maxlength="6">
                                            </div>
                                        </div>
                                        <div class="row form-group cardgroup debcardgroup">
                                            <label class="col-md-12">
                                                <h6>Security Code</h6>
                                                <h6>CVV/CVC</h6>
                                            </label>
                                            <div class="col-md-12">
                                                <input id="txtseccodeno" disabled class="form-control cardgroup debcardgroup ptdebcard ptcredcard" maxlength="3">
                                            </div>
                                        </div>
                                        <div class="row form-group cardgroup" id="row_ex_date">
                                            <label class="col-md-12">Exp. Date</label>
                                            <div class="col-md-6" id="divtxtpaymentexpdateMonth">
                                                <select id="txtpaymentexpdateMonth" disabled class="form-control cardgroup ptcredcard searchy_select" style="width: 100%;">
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
                                            <div class="col-md-6" id="divtxtpaymentexpdateYear">
                                                <select id="txtpaymentexpdateYear" disabled class="form-control cardgroup ptcredcard searchy_select" style="width: 100%;">
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
                                            <label class="col-md-12">Check No.</label>
                                            <div class="col-md-12" style="padding-bottom: 6px;">
                                                <!-- <div class="input-group" id="" style="width: 100%;"> -->
                                                    <input type="text" id="txtpaymentcheckno" class="form-control checkgroup ptcheck" disabled>
                                                    <!-- <div class="spinbox-buttons input-group-btn" style="padding: 0px;">
                                                        <button class='btn btn-xs btn-gray btn-round' onclick="openchecklist();" style="height:32px !important;" disabled id="btncheckno"><i class='ace-icon fa fa-search bigger-120'></i></button>
                                                    </div>
                                                </div> -->
                                            </div>
                                        </div>
                                        <div class="row form-group checkgroup">
                                            <label class="col-md-12">Check Date</label>
                                            <div class="col-md-12">
                                                <input id="txtpaymentcheckdate" class="form-control date-picker checkgroup ptcheck" disabled>
                                            </div>
                                        </div>
                                        <div class="row form-group checkgroup">
                                            <label class="col-md-12">Check Name</label>
                                            <div class="col-md-12">
                                                <input id="txtpaymentcheckname" class="form-control checkgroup ptcheck" disabled>
                                            </div>
                                        </div>
                                        <div class="row form-group checkgroup">
                                            <label class="col-md-12">Bank Name</label>
                                            <div class="col-md-12" id="divtxtpaymentbankname">
                                                <select id="txtpaymentbankname" class="form-control checkgroup ptcheck selectbanktype searchy_select" style="width: 100%;" disabled data-placeholder="-- Select Bank --"></select>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <label class="col-md-12">Amount</label>
                                            <div class="col-md-12">
                                                <div class="input-group" style="width: 100%;">
                                                    <input id="txtpaymentamount" class="form-control amount thisisrequired" style="margin-bottom: 5px; text-align: right;background-color: white !important;" placeholder="0.00" onkeypress="return isNumberKey(event)" onkeyup="enteramount(this.value);">
                                                    <div class="spinbox-buttons input-group-btn" style="padding: 0px;">
                                                        <button class='btn btn-xs btn-gray btn-round' onclick='loadtblorlist("<?php echo "select"; ?>");' id="btnbrowsecashpayment" style="height:33.5px !important;margin-bottom: 4px;"><i class='ace-icon fa fa-search bigger-120'></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <form method="post" name="frmBillAttachment" id="frmBillAttachment">
                                        <div class="row form-group">
                                            <label class="col-md-12">O.R No.</label>
                                            <div class="col-md-12">
                                                <input id="txtpaymentorno" class="form-control thisisrequired" name="txtpaymentorno" style="background-color: white !important;" maxlength="20">
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <label class="col-md-12">Particulars</label>
                                            <div class="col-md-12">
                                                <textarea style="width: 100%; height: 100px;resize: none;background-color: white !important;" id="txtpaymentremarks"></textarea>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <label class="col-md-12">Attachment</label>
                                            <div class="col-md-12" id="divAttachment">
                                                <input type="file" class="txtBillUpload" id="txtBillAttachment" name="txtBillAttachment">
                                            </div>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-toolbox padding-8 clearfix">
                                <a href="#" id="btn_savingdorp" class="btn btn-primary btn-sm pull-right btn-round" style="float: right;" onclick="confirmsavedeposit()"><i class="ace-icon fa fa-thumb-tack"></i>&nbsp;Apply Payment</a>
                            </div>
                        </div>                  
                    </div>
                    <div class="col-md-9">
                        <div class="widget-box widget-color-blue3 collapsed">
                            <div class="widget-body" style="display: block;height: 527px;">
                                <div class="widget-main" style="padding:0px;">
                                    <div style="height: 520px;">
                                        <table class="table table-bordered table-hover fixTable">
                                            <thead>
                                                <tr>
                                                    <th style="border-left: 0px !important;background-color: #6379AA;color: white;display: none;"></th>
                                                    <th style="width: 10%;background-color: #6379AA;color: white;">Date</th>
                                                    <th style="width: 20%;background-color: #6379AA;color: white;">Charges</th>
                                                    <th style="white-space: nowrap;width: 15%;background-color: #6379AA;color: white;text-align: right;">Amount</th>
                                                    <th style="width: 15%;background-color: #6379AA;color: white;text-align: right;">VAT</th>
                                                    <th style="white-space: nowrap;width: 15%;background-color: #6379AA;color: white;text-align: right;">Total Amount</th>
                                                    <th style="width: 10%;background-color: #6379AA;color: white;text-align: right;">Balance</th>
                                                    <th style="width: 15%;border-right: 0px !important;background-color: #6379AA;color: white;text-align: right;">Payment</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tblbalancelist"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>                  
                    </div>
                    <div class="form-group row" style="margin-bottom: 0px;">
                        <div class="col-md-12">
                            <div class="hr hr8 hr-double hr-dotted"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="col-md-4" style="padding-right: 5px;">
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-5" style="text-align: left;">
                        </div>
                        <div class="col-md-4" style="text-align: left; font-weight: bold;text-align: right;">
                            <p style="margin-bottom: 0px;">Payment :</p>
                            <p style="margin-bottom: 0px;">Payment Applied :</p>
                            <p style="margin-bottom: 0px;">Remaining Amount :</p>
                        </div>
                        <div class="col-md-3" style="font-weight: bold;">
                            <p id="txtenteramount" style="text-align: right;margin-bottom: 0px;">0.00</p>
                            <p id="txtenterselected" style="text-align: right;margin-bottom: 0px;">0.00</p>
                            <p id="txtenterchange" style="text-align: right;margin-bottom: 0px;">0.00</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL CHECK LIST -->
<div class="modal fade fade-scale" id="billingchecklistmodal" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Check List</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-xs-12">
                        <input type="hidden" id="txtxdatepass">
                        <div class="parent">
                            <table class="table table-bordered table-striped fixTable">
                                <thead>
                                    <th>Check #</th>
                                    <th>PDC Date</th>
                                    <th>Bank</th>
                                    <th>Depository Status</th>
                                    <th>Check Status</th>
                                    <th>Amount</th>
                                </thead>
                                <tbody id="tblchecklist"></tbody>
                            </table>
                        </div>
                        <table class="tabledash_footer table" style="margin: 0px !important;">
                            <thead>
                                <tr>
                                    <th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
                                        <font style="float: left; color: white !important;margin-left: 15px;font-weight: normal;font-weight: 8px !important;" id="txtCheckListEntries"><br /></font>
                                        <input type="hidden" id="txtCheckListUserPage" class="form-control input-sm" style="width: 5%; text-align: center;">
                                        <ul id="txtCheckListPage" class="pagination pull-right"></ul>
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

<!-- View OR LIST -->
<div class="modal fade fade-scale" id="modal_orlist" role="dialog" area-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" style="width: 80%;">   
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Received Payments</h4>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-xs-12 col-md-12">
                        <div class="parent">
                            <table class="table table-bordered table-hover fixTable">
                                <th style="width: 10%;">Date</th>
                                <th style="width: 15%;">Description</th>
                                <th style="width: 15%;">Reference</th>
                                <th style="width: 10%;">O.R No.</th>
                                <th style="width: 15%; text-align: right;">Amount</th>
                                <th style="width: 15%; text-align: right;">Applied Amount</th>
                                <th style="width: 15%; text-align: right;">Remaining Amount</th>
                                <th style="width: 5%;">Attachment</th>
                                <tbody id="tblorlist"></tbody>
                            </table>
                        </div>
                        <table class="tabledash_footer table" style="margin: 0px !important;">
                            <thead>
                                <tr>
                                    <th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
                                        <font style="float: left; color: white !important;margin-left: 15px;font-weight: normal;font-weight: 8px !important;" id="txtorlistentries"><br /></font>
                                        <input type="hidden" id="txt_userpageorlist" class="form-control input-sm" style="width: 5%; text-align: center;">
                                        <ul id="ulpaginationorlist" class="pagination pull-right"></ul>
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

<!-- OR PREVIEW -->
<div class="modal fade fade-scale" id="paymentOR" role="dialog" area-hidden="true">
    <div class="modal-dialog modal-xs">   
        <div class="modal-content">
            <div class="modal-body">
                <div class="row form-group" id="paymentORContent">
                    <table style="width: 100%;">
                        <table style="width: 100%;">
                            <tbody id="template4"></tbody>
                        </table>
                        <tr><td><center><p style="font-size: 22px; font-weight: bold;background-color: #666;color: white;width: 100%;">Payment Receipt</p></center></td></tr>
                        <table style="width: 100%;margin-top: -10px;">
                            <tr>
                                <td style="font-weight: bold;width: 50%;">Tenant: <label id="paymentinfoTenant"></label></td>
                                <td style="font-weight: bold;width: 50%;">Receipt No: <label id="paymentinfoReceiptNo"></label></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;width: 50%;">Payment Type: <label id="paymentinfoPaymentType"></label></td>
                                <td style="font-weight: bold;width: 50%;">Transaction Date: <label id="paymentinfoTransDate"></label></td>
                            </tr>
                        </table>
                        <table style="width: 100%;margin-top: 5px;">
                            <thead>
                                <tr>
                                    <th style="width: 75%;background-color: #666;color: white;">Description</th>
                                    <th style="width: 25%;background-color: #666;color: white;">Amount</th>
                                </tr>
                            </thead>
                            <tbody id="tblpaymentorinfo"></tbody>
                        </table>
                        <table style="width: 100%;margin-top: 5px;">
                            <tr>
                                <td style="font-weight: bold;width: 50%;">Date: <label id="paymentinfoPrintDate"></label></td>
                                <td style="font-weight: bold;width: 50%;">Received By: <label id="paymentinfoReceivedBy"></label></td>
                            </tr>
                        </table>
                    </table>
                </div>
                <div class="row form-group">
                    <button class="btn btn-sm btn-primary pull-right btn-round" onclick="printpaymentORContent();">PRINT</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL CASHIER'S AUDIT -->
<div class="modal fade fade-scale" id="modal_opencashieraudit" role="dialog" area-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md">   
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Cashier's Audit</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
                            <legend class="green" style="border: none;margin-bottom: 0px;font-size: 16px; font-weight: normal;width:60px;">&nbsp;&nbsp;<label class="txtSysBuilding">Mall</label>&nbsp;&nbsp;</legend>
                            <div class="row form-group">
                                <div class="col-md-12">
                                    <div class="col-md-3">
                                        Select <label class="txtSysBuilding">Mall</label>
                                    </div>
                                    <div class="col-md-6">
                                        <select class="form-control" id="CAmall"></select>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
                            <legend class="green" style="border: none;margin-bottom: 0px;font-size: 16px; font-weight: normal;width:95px;">&nbsp;&nbsp;Date Filter&nbsp;&nbsp;</legend>
                            <div class="form-group row" style="margin:0px;">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        Date From
                                    </div>
                                    <div class="col-md-6">
                                        Time From
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <input class="form-control date-picker" id="CADateFrom" type="text" value='<?php echo date('m/d/Y'); ?>'>
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar bigger-110"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <input class="form-control date-picker" id="CADateTo" type="text" value='<?php echo date('m/d/Y'); ?>'>
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar bigger-110"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
                            <legend class="green" style="border: none;margin-bottom: 0px;font-size: 16px; font-weight: normal;width:100px;">&nbsp;&nbsp;Time Filter&nbsp;&nbsp;</legend>
                            <div class="form-group row" style="margin:0px;">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        Date To
                                    </div>
                                    <div class="col-md-6">
                                        Time To
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div class="input-group bootstrap-timepicker">
                                            <input id="CATimeFrom" type="time" class="form-control">
                                            <span class="input-group-addon">
                                                <i class="fa fa-clock-o bigger-110"></i>
                                            </span>
                                        </div>
                                    </div>  
                                    <div class="col-md-6">
                                        <div class="input-group bootstrap-timepicker">
                                            <input id="CATimeTo" type="time" class="form-control">
                                            <span class="input-group-addon">
                                                <i class="fa fa-clock-o bigger-110"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
                            <legend class="green" style="border: none;margin-bottom: 0px;font-size: 16px; font-weight: normal;width:50px;">&nbsp;&nbsp;User&nbsp;&nbsp;</legend>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="col-md-3" style="margin-top: 10px;">
                                        Select User
                                    </div>
                                    <div class="col-md-6">
                                        <select class="form-control" id="CAuserlist" onchange="clearmultiuser()"></select>
                                    </div>
                                    <div class="col-md-1">
                                        <button class="btn btn-primary btn-sm btn-round" title="Click to select multiple user" onclick="openmultiuserlist();"><i class="fa fa-users"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-12">
                                    <div class="col-md-3" style="margin-top: 10px;">
                                        Payment Type
                                    </div>
                                    <div class="col-md-6">
                                        <select class="form-control" id="CApaymenttypelist" onchange="clearmultipaymenttype()">
                                            <option value="">-- Select Payment Type --</option>
                                            <option value="Cash">Cash</option>
                                            <option value="Check">Check</option>
                                            <option value="Credit Card">Credit Card</option>
                                            <option value="Debit Card">Debit Card</option>
                                            <option value="Bank Transfer">Bank Transfer</option>
                                        </select>
                                    </div>
                                    <div class="col-md-1">
                                        <button class="btn btn-primary btn-sm btn-round" title="Click to select multiple payment type" onclick="openmultipaymenttype();"><i class="fa fa-list-alt"></i></button>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-primary btn-round" onclick="previewCa();"><i class="fa fa-eye"></i>&nbsp;Preview</button>
                <input type="hidden" id="userlistcontainer">
                <input type="hidden" id="paymenttypecontainer">
            </div>
        </div>
    </div>
</div>

<!-- MULTIPLE USER MODAL -->
<div class="modal fade fade-scale" id="modal_CAmultiuser" role="dialog" area-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xs">   
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">User List</h4>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-md-12">
                        <div class="btn-group pull-right">
                            <button class="btn btn-warning btn-sm btn-round" onclick="thiswillcheckalluser();">Check All</button>
                            <button class="btn btn-danger btn-sm btn-round" onclick="thiswilluncheckalluser();">Unheck All</button>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="parent">
                            <table class="table table-bordered table-hover fixTable">
                                <th>User ID</th>
                                <th>Name</th>
                                <tbody id="tblCAuserlist"></tbody>
                            </table>
                        </div>
                        <table class="tabledash_footer table" style="margin: 0px !important;">
                            <thead>
                                <tr>
                                    <th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
                                        <font style="float: left; color: white !important;margin-left: 15px;font-weight: normal;font-weight: 8px !important;" id="txtorlistentries"><br /></font>
                                        <input type="hidden" id="txt_userpageorlist" class="form-control input-sm" style="width: 5%; text-align: center;">
                                        <ul id="ulpaginationorlist" class="pagination pull-right"></ul>
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-primary btn-round" onclick="savecheckeduser();">Add Selected</button>
            </div>
        </div>
    </div>
</div>

<!-- MULTIPLE PAYMENT TYPE -->
<div class="modal fade fade-scale" id="modal_CAmultipaymenttype" role="dialog" area-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xs">   
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">List of Payment Types</h4>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-md-12">
                        <div class="btn-group pull-right">
                            <button class="btn btn-warning btn-sm btn-round" onclick="thiswillcheckallpaymenttype();">Check All</button>
                            <button class="btn btn-danger btn-sm btn-round" onclick="thiswilluncheckallpaymenttype();">Unheck All</button>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="parent2">
                            <table class="table table-bordered table-hover fixTable">
                                <th width="1%" style="display: none;">
                                    <div class="checkbox pull-right">
                                        <label>
                                            <input type="checkbox" class="ace thiswillcheckallpaymenttype" value="Cash" onclick="thiswillcheckallpaymenttype();">
                                            <span class="lbl"></span>
                                        </label>
                                    </div>
                                </th>
                                <th>Payment Type</th>
                                <tbody id="tblCAPaymentType"> 
                                    <tr>
                                        <td style="display: none;">
                                            <div class="checkbox pull-right">
                                                <label>
                                                    <input type="checkbox" class="ace subcheckboxpaymenttype" value="Cash">
                                                    <span class="lbl"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>Cash</td>
                                    </tr>
                                    <tr>
                                        <td style="display: none;">
                                            <div class="checkbox pull-right">
                                                <label>
                                                    <input type="checkbox" class="ace subcheckboxpaymenttype" value="Check">
                                                    <span class="lbl"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>Check</td>
                                    </tr>
                                    <tr>
                                        <td style="display: none;">
                                            <div class="checkbox pull-right">
                                                <label>
                                                    <input type="checkbox" class="ace subcheckboxpaymenttype" value="Credit Card">
                                                    <span class="lbl"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>Credit Card</td>
                                    </tr>
                                    <tr>
                                        <td style="display: none;">
                                            <div class="checkbox pull-right">
                                                <label>
                                                    <input type="checkbox" class="ace subcheckboxpaymenttype" value="Debit Card">
                                                    <span class="lbl"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>Debit Card</td>
                                    </tr>
                                    <tr>
                                        <td style="display: none;">
                                            <div class="checkbox pull-right">
                                                <label>
                                                    <input type="checkbox" class="ace subcheckboxpaymenttype" value="Bank Transfer">
                                                    <span class="lbl"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>Bank Transfer</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <table class="tabledash_footer table" style="margin: 0px !important;">
                            <thead>
                                <tr>
                                    <th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
                                        <font style="float: left; color: white !important;margin-left: 15px;font-weight: normal;font-weight: 8px !important;" id="txtorlistentries"><br /></font>
                                        <input type="hidden" id="txt_userpageorlist" class="form-control input-sm" style="width: 5%; text-align: center;">
                                        <ul id="ulpaginationorlist" class="pagination pull-right"></ul>
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-primary btn-round" onclick="savecheckedpaymenttype();">Add Selected</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" id="modal_CApreviewres" role="dialog" area-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 85%;">   
        <div class="modal-content">
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-md-12">
                        <table class="table table-bordered table-hover fixTable" style="width: 100%;">
                            <th>Trade Name</th>
                            <th>Description</th>
                            <th>Date / Time</th>
                            <th>Quantity</th>
                            <th>User Name</th>
                            <th>Amount</th>
                            <th>Vat</th>
                            <th>Total</th>
                            <tbody id="tblCAprev"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" onclick="ChoosePrintCA();" style="margin: 5px;" title="Print"><i class="glyphicon glyphicon-print fa-2x"></i></a>
                <a href="#" onclick="ChooseCSVCA();" style="margin: 5px;" title="Save as CSV"><i class="fa fa-file-excel-o fa-2x green"></i></a>
                <a href="#" onclick="ChoosePDFCA();" style="margin: 5px;" title="Save as PDF"><i class="fa fa-file-pdf-o fa-2x red"></i></a>
            </div>
        </div>
    </div>
</div>

<div id="div_forprint" style="display: none;">
    <div class="col-md-12">
        <table style="width: 100%;" cellspacing="0" cellpadding="0">
            <tbody id="template3"></tbody>
        </table>
        <table style="width: 100%;margin-top: 10px;">
            <thead>
                <tr style="background-color: #666;color: white;">   
                    <th>Trade Name</th>
                    <th>Description</th>
                    <th>Date / Time</th>
                    <th>Quantity</th>
                    <th>User Name</th>
                    <th>Amount</th>
                    <th>Vat</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody id="tblCAprevprint"></tbody>
        </table>
    </div>
</div>

<div id="div_forCSV" style="display: none;">
    <div class="col-md-12">
        <table style="width: 100%;" id="CAresCSV" >
            <th>Trade Name</th>
            <th>Description</th>
            <th>Date / Time</th>
            <th>Quantity</th>
            <th>User Name</th>
            <th>Amount</th>
            <th>Vat</th>
            <th>Total</th>
            <tbody id="tblCAprevCSV"></tbody>
        </table>
    </div>
</div>

<!-- STATEMENT OF ACCOUNTS -->
<div class="modal fade fade-scale" id="mdlSOA" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" style="width: 95%;">
        <div class="modal-content">
        <div id="soaloadingscreentenant"></div>
            <div class="modal-header">  
                <button type="button" class="close" data-dismiss="modal" onclick="fncHideModalForSOA()">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Billing</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="widget-box widget-color-blue3">
                            <div class="widget-header">
                                <h5 class="widget-title">Billing Actions</h5>
                            </div>
                            <div class="widget-body">
                                <div class="widget-main">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="row form-group hide">
                                                <div class="col-md-12 thSysTenant"></div>
                                                <div class="col-md-12">
                                                    <select class="form-control disabledwhenclicked" id="txtTenantID" onchange="loadTenantSOA()"></select>
                                                </div>
                                            </div>
                                            <div class="row form-group hide">
                                                <div class="col-md-12">Unit</div>
                                                <div class="col-md-12">
                                                    <select class="form-control disabledwhenclicked" id="txtUnitID" onchange="fncLoadTenant()"></select>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-12">
                                                    Billing Period
                                                </div>
                                                <div class="col-md-12" id="divtxtBillingPeriod">
                                                    <select class="form-control searchy_select" id="txtBillingPeriod" onchange="FillBillDates();" style="width: 100%;" data-placeholder="-- Select Period --"></select>
                                                </div>
                                            </div>
                                            <div class="row form-group hide">
                                                <div class="col-md-12">
                                                    Start Date
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="input-group">
                                                        <input class="form-control txtgensoa" id="txtPeriodFrom" type="text" readonly style="background-color: white !important;">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-calendar bigger-110"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row hide">
                                                <div class="col-md-12">
                                                    End Date
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="input-group">
                                                        <input class="form-control txtgensoa" id="txtPeriodTo" type="text" readonly style="background-color: white !important;">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-calendar bigger-110"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row form-group hide">
                                                <div class="col-md-12">
                                                    Due Date
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="input-group">
                                                        <input class="form-control txtgensoa" id="txtDueDate" type="text" readonly style="background-color: white !important;">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-calendar bigger-110"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row form-group">
                                                <div class="col-md-12 hidden-xs">&nbsp;</div>
                                                <div class="col-md-12">
                                                    <button class="btn btn-success btn-sm btn-block disabledwhenclicked btn-round" id="btnprocessingofsoa" onclick="fncPreProcessSOA();" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing...">Process SOA</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="widget-box widget-color-blue3">
                            <div class="widget-header">
                                <h5 class="widget-title">List of Billing Periods</h5>
                                <div class="widget-toolbar no-border">
                                    <button class="btn btn-yellow disabledwhenclicked btn-xs btn-round" id="btnPostSelected" onclick="fncPostActivePeriod();">
                                        <i class="ace-icon fa fa-thumb-tack bigger-110"></i>
                                        <span class="bigger-110" id="txtbtnposttenant">Post</span>
                                    </button>
                                </div>
                            </div>
                            <div class="widget-body" style="height: 60vh;">
                                <div class="widget-main"> 
                                    <div class="row form-group">
                                        <div class="col-md-12">
                                            <div style="height: 65vh;">
                                                <table class="table table-bordered table-hover fixTable">
                                                    <thead>
                                                        <tr>
                                                            <th>Billing Period</th>
                                                            <th>Due Date</th>
                                                            <th style="z-index: 1;">Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tblPrevPeriods"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="widget-box widget-color-blue3">
                            <div class="widget-header">
                                <h5 class="widget-title">List of Statement of Accounts</h5>
                                <div class="widget-toolbar no-border">
                                    <button class="btn btn-primary btn-xs btn-round" onclick="fncCheckSelectedSOA();"><i class="glyphicon glyphicon-print"></i>&nbsp;Print</button>
                                    <button class="btn btn-success btn-xs btn-round" onclick="fncCheckAllSoA();">Select All</button>
                                    <button class="btn btn-danger btn-xs btn-round" onclick="fncUncheckAllSoA();">Unselect All</button>
                                </div>
                            </div>
                            <div class="widget-body" style="height: 80vh;">
                                <div class="widget-main"> 
                                    <div class="form-group row">
                                        <div class="col-md-6 hide">
                                            <div class="row form-group">
                                                <div class="col-md-12">
                                                    Billing Period
                                                </div>
                                                <div class="col-md-12">
                                                    <label id="txtBillingSOAPeriod">&nbsp;</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 hide">
                                            <div class="row form-group">
                                                <div class="col-md-12">
                                                    SOA No.
                                                </div>
                                                <div class="col-md-12">
                                                    <label id="txtBillingSOAID">&nbsp;</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div style="height: 75vh;">
                                                <table class="table table-bordered table-hover fixTable">
                                                    <thead> 
                                                        <tr>
                                                            <th style="width: 10%;white-space: nowrap;">Ctrl No</th>
                                                            <th style="width: 20%;white-space: nowrap;"><?php if(SysLeaseSetup('softwaretype') == '5'){ echo "Buyer"; }else{ echo "Tenant"; } ?> ID</th>
                                                            <th style="width: 40%;white-space: nowrap;" class="thSysTenant">Store Name</th>
                                                            <th style="width: 15%;white-space: nowrap;text-align: right;">Current Balance</th>
                                                            <th style="width: 15%; z-index: 1;">Option</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tblBillingSOAList"></tbody>
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

<!-- BILLING PERIOD -->
<div class="modal fade fade-scale" id="mdl_AddBillingPeriod" role="dialog" area-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Billing Period</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5">
                        <div class="search-area well well-sm" style="padding-bottom: 0px;">
                            <div class="search-filter-header bg-primary">
                                <h5 class="smaller no-margin-bottom">
                                    <i class="ace-icon fa fa-sliders light-green bigger-130"></i>&nbsp;&nbsp; Create Billing Period
                                </h5>
                                <input type="hidden" id="txtBillSoAID">
                            </div>
                            <div class="space-10"></div>
                            <div class="widget-box" style="padding-top: 10px;padding-bottom: 10px;">
                                <div class="row form-group">
                                    <div class="col-md-4"><h6 style="margin-top:8px;margin-left: 8px;">Month</h6>
                                    </div>
                                    <div class="col-md-6">
                                        <select class="form-control cleartxtBP" id="txtBillMonth">
                                            <option value="">-- Month --</option>
                                            <option value="1">January</option>
                                            <option value="2">February</option>
                                            <option value="3">March</option>
                                            <option value="4">April</option>
                                            <option value="5">May</option>
                                            <option value="6">June</option>
                                            <option value="7">July</option>
                                            <option value="8">August</option>
                                            <option value="9">September</option>
                                            <option value="10">October</option>
                                            <option value="11">November</option>
                                            <option value="12">December</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-4"><h6 style="margin-top:8px;margin-left: 8px;">Year</h6></div>
                                    <div class="col-md-6">
                                        <select class="form-control cleartxtBP" id="txtBillYear">
                                            <option value="">-- Year --</option>
                                            <?php
                                                for($a = 5; $a >= 1; $a--){
                                                    $timestamp = strtotime('-'. $a .' years');
                                                    $forval1 = date('Y', $timestamp);
                                            ?>
                                                    <option value="<?php echo $forval1; ?>"><?php echo $forval1; ?></option>
                                            <?php
                                                }
                                            ?>
                                                    <option value="<?php echo date('Y'); ?>"><?php echo date('Y'); ?></option>
                                            <?php                       
                                                for($b = 1; $b <= 5; $b++){
                                                    $timestamp2 = strtotime('+'. $b .' years');
                                                    $forval2 = date('Y', $timestamp2);
                                            ?>
                                                    <option value="<?php echo $forval2; ?>"><?php echo $forval2; ?></option>
                                            <?php
                                                }
                                            ?>                                
                                        </select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-4"><h6 style="margin-top:8px;margin-left: 8px;">Due Date</h6>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <input class="form-control date-picker cleartxtBP" id="txtBillDueDate" type="text">
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar bigger-110"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>  
                            </div>
                            <div class="row form-group">
                                <div class="col-md-12">
                                    <div class="btn-group pull-right">
                                        <button class="btn btn-primary btn-sm btn-SaveBP btn-round" style="margin-top: 8px;float: right;" onclick="SaveNewBillPeriod();"><i class="fa fa-check"></i>&nbsp;Save</button>
                                        <button class="btn btn-danger btn-sm btn-UpdateBP btn-round" style="margin-top: 8px;float: right;" onclick="CancelUpdateBP();"><i class="fa fa-times"></i>&nbsp;Cancel</button>
                                        <button class="btn btn-success btn-sm btn-UpdateBP btn-round" style="margin-top: 8px;float: right;" onclick="SaveNewBillPeriod();"><i class="fa fa-check"></i>&nbsp;Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>  
                    </div>
                    <div class="col-md-7">
                        <div class="widget-box widget-color-blue3 collapsed">
                            <div class="widget-header">
                                <h4 class="widget-title">Billing Period List</h4>
                            </div>
                            <div class="widget-body" style="height: 239px;display: block;">
                                <div style="height: 239px;">
                                    <table class="table table-bordered fixTable">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #f2f2f2 !important;color: #707070;width: 25%;">Period</th>
                                                <th style="background-color: #f2f2f2 !important;color: #707070;width: 25%;">Start Date</th>
                                                <th style="background-color: #f2f2f2 !important;color: #707070;width: 25%;">End Date</th>
                                                <th style="background-color: #f2f2f2 !important;color: #707070;width: 25%;">Due Date</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tblBillPeriodList"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>  
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger btn-sm btn-round" onclick="$('#mdl_AddBillingPeriod').modal('hide'); $('.cleartxtBP').val('');">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" id="mdlPreviewSOA" role="dialog" area-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal"><i class="fa fa-times"></i></button>
                <div class="row form-group">
                    <div class="col-md-12 col-xs-12">
                        <div style="margin-top: 10px; display: block;">
                            <center>
                                <div class="checklist" id="tblPrintSOAMulti" style="width: 99%;margin-bottom: 0;"></div>
                            </center>
                        </div>                
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-12 col-xs-12">
                        <button type="button" class="btn btn-primary hide isadmin select-printsoa btn-round btn-sm" style="float: right;" id="" onclick="btnPrintSOA()">&nbsp;Print</button>
                    </div>
                 </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" id="mdl_confProcessSOA" role="dialog" area-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-sm" style="width: 30%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Billing</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 center">
                        <span class="fa fa-exclamation-triangle fa-5x red" style="margin-top: 40%;"></span>
                    </div>
                    <div class="col-md-8">
                        <div class="row form-group">
                            <div class="col-md-12">
                                <h6>There are still pending transactions that are not yet posted in the following modules.</h6>
                            </div>
                            <div class="col-md-12">
                                <h6>Work Order: <span class="bolder" id="txtpreProcessWO">0</span> record(s)</h6>
                                <h6>Violations: <span class="bolder" id="txtpreProcessV">0</span> record(s)</h6>
                            </div>
                            <div class="col-md-12">
                                <h6>Are you sure you want to proceed?</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-sm btn-round" onclick="fncProcessSOA();">Proceed</button>
                <button class="btn btn-danger btn-sm btn-round" onclick="$('#mdl_confProcessSOA').modal('hide');">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" id="mdlImportBev" area-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md" style="width: 60%;">   
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" onclick="">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Beverage Import Logs</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-3 pull-right divImportBevHome">
                        <button class="btn btn-round btn-sm btn-warning btn-block" onclick="fncImportBevTemplate();"><i class="fa fa-upload"></i>&nbsp;Upload File</button>
                    </div>
                    <div class="col-md-3 pull-right divImportBevTab">
                        <button class="btn btn-round btn-sm btn-danger btn-block" onclick="fncCancelImportBevTemplate();">Cancel</button>
                    </div>
                    <div class="col-md-3 pull-right divImportBevTab">
                       <button class="btn btn-round btn-sm btn-primary btn-block" onclick="fncImportBevLogs();">Import</button>
                    </div>
                    <div class="col-md-3 pull-right divImportBevTab">
                        <form name="frmImportBevTemplate" id="frmImportBevTemplate" class="frmImportBevTemplate">
                            <input id="txtImportedBevFile" name="txtImportedBevFile" class="form-control UserImage" type="file">
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" style="margin-top: 10px;">
                        <div class="parent">
                            <table class="table table-bordered table-striped fixTable">
                                <thead>
                                    <tr>
                                        <th style="width: 25%;">Update Date / Time</th>
                                        <th style="width: 25%;">User</th>
                                        <th style="width: 25%;">Billing Status</th>
                                        <th style="width: 25%;">Option</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyBevImportLogs"></tbody>
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

<div class="modal fade fade-scale" id="mdlImportBevList" area-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" style="width: 80%;">   
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" onclick="">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Beverage Charge List</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-3">
                        <span class="input-icon" style="width: 100%;">
                            <input type="text" class="form-control" placeholder="Search" id="txtSearchBevList">
                            <input type="hidden" id="txtBevUploadID">
                            <i class="ace-icon fa fa-search nav-search-icon"></i>
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" style="margin-top: 10px;">
                        <div class="parent">
                            <table class="table table-bordered table-striped fixTable">
                                <thead>
                                    <tr>
                                        <th style="width: 13%;">Transaction Date</th>
                                        <th style="width: 17%;">Tenant</th>
                                        <th style="width: 15%;">Reference</th>
                                        <th style="width: 15%;">Description</th>
                                        <th style="width: 10%;">Quantity</th>
                                        <th style="width: 10%; text-align: right;">Amount</th>
                                        <th style="width: 10%; text-align: right;">VAT</th>
                                        <th style="width: 10%; text-align: right;">Total</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyBevImportChargeList"></tbody>
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

<div class="modal fade fade-scale" id="mdlAdjustment" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
        <div id="PremdlAdjustment"></div>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Rebate</h4>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-md-12">
                        <label class="control-label">Charge</label>
                        <label class="pull-right" id="txtisRefund">
                            <input type="checkbox" class="ace" id="isRefund">
                            <span class="lbl middle padding-4"> is Refund?</span>
                        </label>
                    </div>
                    <div class="col-md-12">
                        <input type="hidden" id="txtAdjActiveTable">
                        <input type="hidden" id="txtAdjRecordID">
                        <input type="text" class="form-control" readonly id="txtAdjChargeDesc" style="background-color: white !important;">
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-12">Amount</label>
                    <div class="col-md-12">
                        <input type="hidden" class="form-control txtAdjReq" style="text-align: right;" id="txtAdjChargeMaxAmount">
                        <input type="text" class="form-control amount numonly" style="text-align: right;" id="txtAdjChargeAmount" onchange="fncAdjCheckMaxAmount();">
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-12">Reference</label>
                    <div class="col-md-12">
                        <textarea class="form-control txtAdjReq" style="height: 80px; resize: none;" maxlength="100" id="txtAdjReference"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-primary btn-round" id="btnPostAdjustment" onclick="fncPostAdjustment();" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Posting..."><i class="fa fa-thumb-tack"></i>&nbsp;Post</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" id="mdlSettlement" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Settlement</h4>
            </div>
            <div class="modal-body" id="div">
                <div class="row form-group">
                    <div class="col-md-12">
                        <div class="btn-group" id="btnSettlement" style="width: 100%;">
                            <button class="btn btn-success btn-xlg btn-block" title="Post rent charge including other charges for the current billing period.">Advance Bill</button>
                            <button class="btn btn-success btn-xlg btn-block hide" style="margin-top: 15px;">&nbsp;</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-primary btn-round" id="btnSettlementProceed" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Posting Charges..." onclick="fncConfirmAdvanceBill();">Proceed</button>
                <button class="btn btn-sm btn-danger btn-round" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" id="mdlTBSoA" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Print SOA</h4>
            </div>
            <div class="modal-body" id="div">
                <div class="row form-group">
                    <div class="col-md-12">
                       <div class="radio">
                            <label>
                                <input name="form-field-radio" type="radio" class="ace rdBillingPeriod" value="CurrentPeriod" id="txtTBSoACurrentBill" onclick="fncAllowSelectBP('No');">
                                <span class="lbl"> Current Billing Period</span>
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input name="form-field-radio" type="radio" class="ace rdBillingPeriod" value="PreviousPeriod" id="txtTBSoAPreviousBill" onclick="fncAllowSelectBP('No');">
                                <span class="lbl"> Previous Billing Period</span>
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input name="form-field-radio" type="radio" class="ace rdBillingPeriod" value="SelectedPeriod" id="txtTBSoASelectBill" onclick="fncAllowSelectBP('Yes');">
                                <span class="lbl"> Select Billing Period</span>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-10 col-md-offset-1" id="divtxtTBSoAPeriod">
                        <select class="form-control searchy_select" style="width: 100%;" data-placeholder="-- Select Billing Period --" id="txtTBSoAPeriod"></select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-primary btn-round" onclick="fncProceedPrint();">Proceed</button>
                <button class="btn btn-sm btn-danger btn-round" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php include("script.php"); ?>