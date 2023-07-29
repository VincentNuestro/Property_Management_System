<style media="screen">
    @media screen {div.divFooter {display: none;}}

    .activated  td{
        color: #FFF !important;
        background-color: #428BCA !important;
    }

    #pdc label, #maintenance label{
        font-size: 13px !important;
    }
</style>
<div class="modal fade fade-scale" role="dialog" id="tenantinfo" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" style="width:85% !important;">
        <div class="modal-content" style="width:100% !important;">
            <div class="modal-header">
                <button type="button" class="close" onclick="closeinfo();">&times;</button>
                <h4 class="modal-title txtPanelHeader" style="font-size: 18px;">Tenant Information</h4>
                <input type="hidden" id="mallidprint">
                <input type="hidden" id="inqid">
                <input type="hidden" id="txtTenantTradeID">
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="tabbable tabs-left">
                            <ul class="nav nav-tabs" id="myTab">
                                <li class="active thistab">
                                    <a data-toggle="tab" href="#custdetail">
                                        <i class="green ace-icon fa fa-user bigger-120"></i>
                                        <?php if(SysLeaseSetup('softwaretype') == '5'){ echo "Buyer"; }else{ echo "Tenant"; } ?> Profile
                                    </a>
                                </li>

                                <li>
                                    <a onclick="tblcontactinfo();" data-toggle="tab" href="#contperson">
                                        <i class="green ace-icon fa fa-phone bigger-120"></i>
                                        Contact Person
                                    </a>
                                </li>

                                <li class="hide isadmin select-uploaddocu">
                                    <a onclick="tblrequirements(); showlistofdocs();" data-toggle="tab" href="#documents">
                                        <i class="green ace-icon fa fa-book bigger-120"></i>
                                        Requirements
                                    </a>
                                </li>

                                <li class="hide isadmin select-uploaddocu">
                                    <a onclick="showPermitList();tblpermits();" data-toggle="tab" href="#permits">
                                        <i class="green ace-icon fa fa-clipboard bigger-120"></i>
                                        Permits
                                    </a>
                                </li>

                               <!--  <li class="hide isadmin select-ViewModRent select-ModRent">
                                    <a onclick="fncPaymentSchedule();" data-toggle="tab" href="#PaymentSchedule">
                                        <i class="green ace-icon fa fa-calendar bigger-120"></i>
                                        Payment Schedule
                                    </a>
                                </li> -->

                               <!--  <li class="hide isadmin select-viewpaymenthistory">
                                    <a onclick="tblpaymenthistory();" data-toggle="tab" href="#PaymentHistory">
                                        <i class="green ace-icon fa fa-money bigger-120"></i>
                                        Payment History
                                    </a>
                                </li>

                                <li class="hide isadmin select-printsoa">
                                    <a onclick="tblsoa();" data-toggle="tab" href="#accdetails">
                                        <i class="green ace-icon fa fa-file-text bigger-120"></i>
                                        Statement Of Accounts
                                    </a>
                                </li>

                                <li class="hide isadmin select-clearingofpdc">
                                    <a onclick="tblpdc();tblpdc2();" data-toggle="tab" href="#pdc">
                                        <i class="green ace-icon fa fa-calendar-check-o bigger-120"></i>
                                        Post Dated Check
                                    </a>
                                </li> -->

                                <li class="hide isadmin select-printcontract">
                                    <a onclick="tblcontract();" data-toggle="tab" href="#contract">
                                        <i class="green ace-icon fa fa-certificate bigger-120"></i>
                                        Contract
                                    </a>
                                </li>

                                <li class="hide isadmin select-maintenancehistory">
                                    <a onclick="tblmaintenance();" data-toggle="tab" href="#maintenance">
                                        <i class="green ace-icon fa fa-wrench bigger-120"></i>
                                        Maintenance History
                                    </a>
                                </li>

                                <!-- <li class="hide isadmin select-constructionbond">
                                    <a onclick="displayconbond();" data-toggle="tab" href="#consbond">
                                        <i class="green ace-icon fa fa-file-archive-o bigger-120"></i>
                                        Construction Bond
                                    </a>
                                </li> -->

                                <li class="hide isadmin select-viewmemo">
                                    <a onclick="tbltenantmemolist();" data-toggle="tab" href="#memolist">
                                        <i class="green ace-icon fa fa-comment bigger-120"></i>
                                        Memo
                                    </a>
                                </li>

                                <li class="hide isadmin select-createcomplaints">
                                    <a onclick="tblcomplaints();" data-toggle="tab" href="#complaintslist">
                                        <i class="green ace-icon fa fa-frown-o bigger-120"></i>
                                        Complaint
                                    </a>
                                </li>

                                <?php if(SysLeaseSetup('softwaretype') != '5'){ ?>
                                <li class="hide isadmin select-tenantsportal">
                                    <a onclick="loadTPS();" data-toggle="tab" href="#TPSTab">
                                        <i class="green ace-icon fa fa-hdd-o bigger-120"></i>
                                        Tenant Portal
                                    </a>
                                </li>
                                <?php } ?>
                            </ul>

                            <div class="tab-content" style="display:block;">
                                <div id="custdetail" class="tab-pane fade in active">
                                    <div class="row form-group">
                                        <div class="col-xs-12 col-sm-3">
                                            <div class="row form-group">
                                                <div class="col-xs-12 col-sm-12">
                                                    <span class="profile-picture">
                                                        <img class="editable img-responsive" id="imgTenantPic" style="height: 200px;width: 100%;">
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-9">
                                            <div class="col-xs-12">
                                                <h2 class="blue header bolder" id="txtTenantTradeName"></h2>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="row form-group">
                                                    <div class="profile-user-info profile-user-info-striped">
                                                        <div class="profile-info-row">
                                                            <div class="profile-info-name" style="white-space: nowrap;"> <?php if(SysLeaseSetup('softwaretype') == '5'){ echo "Buyer"; }else{ echo "Tenant"; } ?> ID </div>
                                                            <div class="profile-info-value">
                                                                <span id="Tid"></span>
                                                                <input type="hidden" id="txtcompid">
                                                            </div>
                                                        </div>
                                                        <div class="profile-info-row">
                                                            <div class="profile-info-name" style="white-space: nowrap;"> Merchant Code </div>
                                                            <div class="profile-info-value">
                                                                <span id="merchant_code"></span>
                                                            </div>
                                                        </div>
                                                        <div class="profile-info-row">
                                                            <div class="profile-info-name" style="white-space: nowrap;"> Company Name </div>
                                                            <div class="profile-info-value">
                                                                <span id="company"></span>
                                                            </div>
                                                        </div>
                                                        <div class="profile-info-row">
                                                            <div class="profile-info-name" style="white-space: nowrap;"> Contact Person </div>
                                                            <div class="profile-info-value">
                                                                <span id="contactp"></span>
                                                            </div>
                                                        </div>
                                                        <div class="profile-info-row">
                                                            <div class="profile-info-name" style="white-space: nowrap;"> Billing Type </div>
                                                            <div class="profile-info-value">
                                                                <span id="billingttype"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="row form-group">
                                                    <div class="profile-user-info profile-user-info-striped">
                                                        <div class="profile-info-row">
                                                            <div class="profile-info-name" style="white-space: nowrap;"> Start Date </div>
                                                            <div class="profile-info-value">
                                                                <span id="Sdate"></span>
                                                            </div>
                                                        </div>
                                                        <div class="profile-info-row">
                                                            <div class="profile-info-name" style="white-space: nowrap;"> End Date </div>
                                                            <div class="profile-info-value">
                                                                <span id="Edate"></span>
                                                            </div>
                                                        </div>
                                                        <div class="profile-info-row">
                                                            <div class="profile-info-name" style="white-space: nowrap;"> Escalation Rate</div>
                                                            <div class="profile-info-value">
                                                                <span id="EscaRate"></span>
                                                            </div>
                                                        </div>
                                                        <div class="profile-info-row">
                                                            <div class="profile-info-name" style="white-space: nowrap;"> Year Start </div>
                                                            <div class="profile-info-value">
                                                                <span id="EscaYearStart"></span>
                                                            </div>
                                                        </div>
                                                        <div class="profile-info-row">
                                                            <div class="profile-info-name" style="white-space: nowrap;"> Year Basis </div>
                                                            <div class="profile-info-value">
                                                                <span id="EscaYearBasis"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-12">
                                            <div id="divTenantUnitList"></div>
                                        </div>
                                    </div>
                                </div>

                                <div id="contperson" class="tab-pane fade">
                                    <div class="row" id="user-profile-2">
                                        <div class="col-md-12">
                                            <button class="btn btn-xs btn-primary btn-round" onclick="$('#modalcontactperson').modal('show'); $('#modalcontactperson').find('input').val(''); removecontactphoto();">Add Contact </button>
                                            <div class="row">
                                                <div id="tblcontactinfo" style="padding: 5px;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="documents" class="tab-pane fade">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <form name="posting_comments" id="posting_comments">
                                                <div class="row form-group">
                                                    <label class="col-md-12">Requirement</label>
                                                    <div class="col-md-12">
                                                        <select id="docname" name="docname" class="form-control searchy_select"></select>
                                                        <input type="hidden" class="form-control input-sm" id="appidreq" name="appidreq" />
                                                        <input type="hidden" class="form-control input-sm" id="inqidreq" name="inqidreq" />
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <label class="col-md-12">Select Document</label>
                                                    <div class="col-md-12">
                                                        <input id="file_uploads" name="file_uploads" class="form-control upload_app_req" type="file"/>
                                                    </div>
                                                </div>         
                                                <div class="row form-group">
                                                    <label class="col-md-12"style="color: black !important;">Remarks</label>
                                                    <div class="col-md-12">
                                                        <textarea class="form-control" id="description" name="description" style="resize: none; height: 80px;"></textarea>
                                                    </div>
                                                </div>   
                                            </form>
                                            <div class="row form-group">
                                                <div class="col-md-12">
                                                    <div class="btn btn-sm btn-primary evict btn-block btn-round" onclick="savereq();"><span class="fa fa-plus"></span> ADD</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="row form-group">
                                                <div class="col-md-12">
                                                    <div class="parent">
                                                        <table class="table table-striped table-bordered fixTable">
                                                            <thead>
                                                                <tr>
                                                                    <th width="50%">Requirement</th>
                                                                    <th width="40%">Remarks</th>
                                                                    <th width="10%"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="tblrequirements"></tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="permits" class="tab-pane fade">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <form name="posting_permit" id="posting_permit">
                                                <div class="row form-group">
                                                    <label class="col-md-12">Permit</label>
                                                    <div class="col-md-12">
                                                        <select id="permitname" name="permitname" class="form-control searchy_select"></select>
                                                        <input type="hidden" class="form-control input-sm" id="appidper" name="appidper" />
                                                        <input type="hidden" class="form-control input-sm" id="inqidper" name="inqidper" />
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <label class="col-md-12">Select Document</label>
                                                    <div class="col-md-12">
                                                        <input id="permit_upload" name="permit_upload" class="form-control upload_app_req" type="file"/>
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <label class="col-md-12">Expiration Date</label>
                                                    <div class="col-md-12">
                                                        <input id="permit_expiration" name="permit_expiration" class="form-control date-picker" type="text" value="<?php echo date('m/d/Y'); ?>"/>
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <label class="col-md-12"style="color: black !important;">Remarks</label>
                                                    <div class="col-md-12">
                                                        <textarea class="form-control" id="PermitDescription" name="PermitDescription" style="resize: none; height: 80px;"></textarea>
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="row form-group">
                                                <div class="col-md-12">
                                                    <div class="btn btn-sm btn-primary btn-round" style="width: 100%;" onclick="savepermit();"><span class="fa fa-plus"></span> ADD</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="row form-group">
                                                <div class="col-md-12">
                                                    <div class="parent">
                                                        <table class="table table-striped table-bordered fixTable">
                                                            <thead>
                                                                <tr>
                                                                    <th width="45%">Permit</th>
                                                                    <th width="35%">Remarks</th>
                                                                    <th width="15%">Exp. Date</th>
                                                                    <th width="10%"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="tblpermits"></tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="PaymentSchedule" class="tab-pane fade">
                                    <div class="row form-group">
                                        <div class="col-md-12">
                                            <div id="divPaymentSchedule"></div>
                                        </div>
                                    </div>
                                </div>

                                <div id="PaymentHistory" class="tab-pane fade">
                                    <div class="row form-group" style="margin-bottom: 0px;">
                                        <div class="col-md-3 col-xs-4" style="padding-bottom: 5px;">
                                            <span class="input-icon" style="width: 100%;">
                                                <input type="text" class="form-control push-left" placeholder="Search" title="Search" id="txtSearchTPPaymentHistory">
                                                <i class="ace-icon fa fa-search nav-search-icon"></i>
                                            </span>
                                        </div>
                                        <div class="col-md-3 col-xs-4" style="padding-bottom: 5px;">
                                            <h5><a onclick="loadTenantsProfFilter('TMListPaymentHistory')" id="LINK_TMListPaymentHistory_filter" class="popover-info" data-rel="popover" data-placement="bottom" title="Filter by" data-content='
                                                <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
                                                <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:95px;">&nbsp;&nbsp;Search by&nbsp;&nbsp;</legend>
                                                    <div class="form-group row" style="margin:0px;">
                                                        <div class="col-md-6">
                                                            <label>
                                                                <input name="form-field-TPPaymentHistory" class="ace ace-checkbox-2" type="checkbox" value="description" id="filter_description">
                                                                <span class="lbl"> Description</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>
                                                                <input name="form-field-TPPaymentHistory" class="ace ace-checkbox-2" type="checkbox" value="paymenttype" id="filter_paymenttype">
                                                                <span class="lbl"> Payment Type</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>
                                                                <input name="form-field-TPPaymentHistory" class="ace ace-checkbox-2" type="checkbox" value="orno" id="filter_orno">
                                                                <span class="lbl"> O.R Number</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>
                                                                <input name="form-field-TPPaymentHistory" class="ace ace-checkbox-2" type="checkbox" value="paymentamount" id="filter_paymentamount">
                                                                <span class="lbl"> Amount</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </fieldset>

                                                <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;">
                                                <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:115px;">&nbsp;&nbsp;Payment Date&nbsp;&nbsp;</legend>
                                                    <div class="form-group row" style="margin:0px;">
                                                        <div class="col-md-1"></div>
                                                        <div class="col-md-5">
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                                                                <input class="form-control div_app date-picker" type="text" id="TPPaymentHistoryDateFrom" data-provide="datepicker">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                                                                <input class="form-control div_app date-picker" type="text" id="TPPaymentHistoryDateTo" data-provide="datepicker">
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
                                                    <button class="btn btn-xs btn-info btn-round" id="btnSaveFilterComplaints" style="float:right;margin-bottom:10px;margin-right:10px;width:80px;">OK</button>
                                                </div>'>
                                                <i class="fa fa-filter bigger-110"></i>&nbsp;&nbsp;Select Filter here</a>
                                            </h5>
                                        </div>
                                        <div class="col-md-1 col-xs-4 pull-right" style="padding-bottom: 5px;margin-top: 10px;">
                                            <a class="pull-right" onclick="printpaymenthistory();"><i class="glyphicon glyphicon-print" style="font-size: 20px;"></i></a>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-12">
                                            <div class="parent" id="paymenthistorytable">
                                                <table class="table table-striped table-bordered fixTable">
                                                    <thead>
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>Description</th>
                                                            <th>Payment Type</th>
                                                            <th>O.R Number</th>
                                                            <th>Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tblpaymenthistory"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="accdetails" class="tab-pane fade">
                                    <div class="row form-group" style="margin-bottom: 0px;">
                                        <div class="col-md-3 col-xs-4" style="padding-bottom: 5px;">
                                            <span class="input-icon" style="width: 100%;">
                                                <input type="text" class="form-control push-left" placeholder="Search" title="Search" id="txtSearchTPPDC">
                                                <i class="ace-icon fa fa-search nav-search-icon"></i>
                                            </span>
                                        </div>
                                        <div class="col-md-3 col-xs-4" style="padding-bottom: 5px;">
                                            <h5><a onclick="loadTenantsProfFilter('TMListSoA')" id="LINK_TMListSoA_filter" class="popover-info" data-rel="popover" data-placement="bottom" title="Filter by" data-content='
                                                <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
                                                <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:95px;">&nbsp;&nbsp;Search by&nbsp;&nbsp;</legend>
                                                    <div class="form-group row" style="margin:0px;">
                                                        <div class="col-md-6">
                                                            <label>
                                                                <input name="form-field-TPSoA" class="ace ace-checkbox-2" type="checkbox" value="soaid" id="filter_soaid">
                                                                <span class="lbl"> SOA ID</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>
                                                                <input name="form-field-TPSoA" class="ace ace-checkbox-2" type="checkbox" value="ctrlno" id="filter_ctrlno">
                                                                <span class="lbl"> Ctrl No.</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </fieldset>

                                                <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;">
                                                <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:105px;">&nbsp;&nbsp;Billign Period&nbsp;&nbsp;</legend>
                                                    <div class="form-group row" style="margin:0px;">
                                                        <div class="col-md-1"></div>
                                                        <div class="col-md-5">
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                                                                <input class="form-control div_app date-picker" type="text" id="TPSoADateFrom" data-provide="datepicker">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                                                                <input class="form-control div_app date-picker" type="text" id="TPSoADateTo" data-provide="datepicker">
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
                                                    <button class="btn btn-xs btn-info btn-round" id="btnSaveFilterComplaints" style="float:right;margin-bottom:10px;margin-right:10px;width:80px;">OK</button>
                                                </div>'>
                                                <i class="fa fa-filter bigger-110"></i>&nbsp;&nbsp;Select Filter here</a>
                                            </h5>
                                        </div>
                                        <div class="col-md-1 col-xs-4 pull-right" style="padding-bottom: 5px;margin-top: 10px;">
                                            <a class="pull-right" onclick="printallsoaheader();"><i class="glyphicon glyphicon-print" style="font-size: 20px;"></i></a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div id="soatable" class="parent">
                                                <table id="soatbl" class="table table-striped table-bordered fixTable">
                                                    <thead>
                                                        <tr>
                                                            <th>SOA ID</th>
                                                            <th>Ctrl No.</th>
                                                            <th>Billing Period</th>
                                                            <th>Penalty</th>
                                                            <th>Payment</th>
                                                            <th>Charges</th>
                                                            <th>Balance</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tblaccounthetails"></tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="modal fade fade-scale" role="dialog" id="modalviewtransall">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id='transtitle' style="font-size: 18px;">All Transactions</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="clearfix pull-right">
                    												<button class="btn btn-primary btn-sm btn-round" onclick="printallsoa();"><span class="fa fa-printer"></span> Print</button>
                                                                </div>
                                                                <br><br>
                                                                <div id="allsoatable" class="parent">
                                                                    <table id="allsoatbl" class="table table-striped table-bordered fixTable">
                                                                        <thead>
                                                                            <tr>
                                                                                <th width="17%">Date</th>
                                                                                <th width="15%"><?php if(SysLeaseSetup('softwaretype') == '5'){ echo "Buyer"; }else{ echo "Tenant"; } ?> ID</th>
                                                                                <th width="22%">Description</th>
                                                                                <th width="15%" align="right">Total Charges</th>
                                                                                <th width="12%" align="right">Penalty</th>
                                                                                <th width="12%" align="right">Payment</th>
                                                                                <th width="12%" align="right">Balance</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="tblviewtransall">

                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-sm btn-danger btn-round" onclick="$('#modalviewtransall').modal('hide'); cancelpdctransaction();" style="border-radius: 3px;">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

									</div>
                                </div>

                                <div id="pdc" class="tab-pane fade">
                                    <div class="row">
                                        <div class="col-md-1">
                                            Date Range
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-daterange input-group">
                                                <input type="text" class="form-control date-picker" id="pdcDateFrom" value="<?php echo date('m/d/Y'); ?>">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-exchange"></i>
                                                </span>
                                                <input type="text" class="form-control date-picker" id="pdcDateTo" value="<?php echo date('m/d/Y'); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <button class="btn btn-sm btn-info btn-round" onclick="tblpdc();tblpdc2();"><i class="fa fa-search"></i>&nbsp;Go</button>
                                        </div>
                                        <div class="col-md-6">
                                            <a onclick="printpdc();" class="pull-right"><i class="glyphicon glyphicon-print" style="font-size: 20px;"></i></a>
                                            <span class="pull-right"><i class='fa fa-circle red'></i>&nbsp;&nbsp;Insufficient Fund&nbsp;&nbsp;</span>
                                            <span class="pull-right"><i class='fa fa-circle green'></i>&nbsp;&nbsp;Cleared&nbsp;&nbsp;|</span>
                                            <span class="pull-right"><i class='fa fa-circle orange'></i>&nbsp;&nbsp;Pending&nbsp;&nbsp;|</span>
                                            <span class="pull-right">Check Status :&nbsp;&nbsp;</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div id="divpdc">
                                                <div class="parent">
                                                    <table class="table table-bordered fixTable">
                                                        <thead>
                                                            <tr>
                                                                <th width="15%">Check Date</th>
                                                                <th width="22%">Dep. Status</th>
                                                                <th width="20%">Depository Date</th>
                                                                <th width="17%">Check #</th>
                                                                <th width="8%">Status</th>
                                                                <th width="18%">Amount</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="tblpdc"></tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div style="border: 3px solid #e3e3e3; padding-left: 10px !important;">
                                                <br><br>
        										<div class="row">
                                                    <div class="col-md-6 ">
                                                        <div class="row">
                                                            <div class="form-group">
                                                                <label class="col-sm-4" style="font-size: 14px !important;">Account #</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" class="form-control input-sm" id="acctnum" readonly="true" style="background-color: #FFF !important; border: none; border-bottom:1px solid #e3e3e3; text-align: center; color: black !important;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="form-group">
                                                                <label class="col-sm-4" style="font-size: 14px !important;">Name</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" class="form-control input-sm" id="acctname" readonly="true" style="background-color: #FFF !important; border: none; border-bottom:1px solid #e3e3e3; text-align: center; color: black !important;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="col-sm-5" style="font-size: 14px !important;">Check #</label>
                                                            <div class="col-sm-7">
                                                                <input type="text" class="form-control input-sm" id="acccheckno" style="background-color: #FFF !important; border: none; border-bottom:1px solid #e3e3e3; text-align: center; font-weight: bold; color: red;" readonly="true">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-5" style="font-size: 14px !important;">PDC Date</label>
                                                            <div class="col-sm-7">
                                                                <input type="text" class="form-control input-sm" id="accpdcdate" readonly="true" style="background-color: #FFF !important; border: none; border-bottom:1px solid #e3e3e3; text-align: center; color: black !important;">
                                                            </div>
                                                        </div>
                                                    </div>
        										</div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <span style="font-size: 14px !important;">Pay to the order of <input type="text" id="accpayto" style="width: 50%; border: none; border-bottom:1px solid #e3e3e3; background-color: #FFF !important; font-size: 14px !important; color: black !important;" readonly="true"/> ₱ <input type="text" id="accamount" style="background-color: #FFF !important; text-align: right; border: none; border-bottom:1px solid #e3e3e3; width: 25%; font-size: 14px !important; color: black !important;" readonly="true" /><br><br><label id="amntwrd" style="border-bottom:1px solid #e3e3e3; text-transform: capitalize; color: red; font-weight: bold;"></label></span>
                                                        <br><br>
                                                        <label id="banko" style="text-transform: uppercase; color: red; font-weight: bold; font-size: 36px !important;"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <br><br>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <label class="col-sm-5">Bank Name</label>
                                                            <div class="col-sm-7">
                                                                <label class="form-control input-sm postpdcreq" id="accbank"  style="color: black !important; font-size: 14px;">
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <label class="col-sm-5">Received By</label>
                                                            <div class="col-sm-7">
                                                                <input type="text" class="form-control input-sm postpdcreq" id="accreceiveby">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <label class="col-sm-5">Depository</label>
                                                            <div class="col-sm-7">
                                                                <input type="text" class="form-control input-sm postpdcreq" id="accdepository">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <label class="col-sm-5">Dep. Status</label>
                                                            <div class="col-sm-7">
                                                                <input type="text" class="form-control input-sm" id="accstat" readonly="true">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <label class="col-sm-5">Check Status</label>
                                                            <div class="col-sm-7">
                                                                <select class="form-control input-sm postpdcreq" id="acccheckstat" style="color: black !important; font-size: 14px;">
                                                                    <optgroup label="Check Status">
                                                                        <option value="Cleared">Cleared</option>
                                                                        <option value="Close Account">Close Account</option>
                                                                        <option value="Check Replace">Check Replace</option>
                                                                        <option value="Pending" disabled>Pending</option>
                                                                        <option value="Insufficient Fund" disabled>Insufficient Fund</option>
                                                                    </optgroup>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <label class="col-sm-5">Depository Date</label>
                                                            <div class="col-sm-7">
                                                                <div class="input-group date" data-provide="datepicker">
                                                                    <div class="input-group-addon">
                                                                        <span class="fa fa-calendar bigger-110"></span>
                                                                    </div>
                                                                    <input type="text" class="form-control input-sm postpdcreq" value="<?php echo date('m/d/Y'); ?>"  id="accdatedep">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
    										<br>
    										<div class="row">
    											<div class="col-sm-12">
    												<div class="btn=group pull-right">
    													<button id="btnsavepdc" class="btn btn-success btn-sm btn-round" onclick="savepdctransaction();"><span class="fa fa-check"></span> Post</button>
                                                        <button class="btn btn-danger btn-sm btn-round" onclick="cancelpdctransaction();"><span class="fa fa-remove"></span> Cancel</button>
    												</div>
    											</div>
    										</div>
    									</div>
                                    </div>
                                </div>

                                <div id="pdc2" class="tab-pane fade">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div id="divpdc2">
                                                <table style="width: 100%;">
                                                    <tbody class="template"></tbody>
                                                </table>
                                                <p style="text-align: right;">
                                                    <span style="color: #303030;">Check Status :</span>&nbsp;&nbsp;&nbsp;
                                                    <span><span class='fa fa-circle' style='color: orange;'></span> Pending</span>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                                                    <span><span class='fa fa-circle' style='color: green;'></span> Cleared</span>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                                                    <span><span class='fa fa-circle' style='color: red;'></span> Insufficient Fund</span>
                                                </p>
                                                <center style="font-size: 22px;font-weight: bold;background-color: #666;color: white;width: 100%;margin-top: -15px;">List of PDC</center>
                                                <table id="pdctbl" style="width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th width="15%">Check Date</th>
                                                            <th width="22%">Dep. Status</th>
                                                            <th width="20%">Depository Date</th>
                                                            <th width="17%">Check #</th>
                                                            <th width="8%">Status</th>
                                                            <th width="18%">Amount</th>
                                                        </tr>
                                                        <tr><th colspan="6"><hr style="margin-top: -5px;"></th></tr>
                                                    </thead>
                                                    <tbody id="tblpdc2"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="contract" class="tab-pane fade">
                                    <div class="row form-group">
                                        <div class="col-md-offset-10 col-md-2">
                                            <button class="btn btn-round btn-info btn-sm btn-block" id="btnAddNewContract">Renew Contract</button>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-12">
                                            <div class="parent">
                                                <table class="table table-bordered table-striped fixTable">
                                                    <thead>
                                                        <tr>
                                                            <th>Contract ID</th>
                                                            <th>Date From</th>
                                                            <th>Date To</th>
                                                            <th width="15%">Preview/Print</th>
                                                            <tbody id="tblcontract"></tbody>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="maintenance" class="tab-pane fade">
                                    <div class="row form-group">
                                         <div class="col-md-2">
                                            Date Range
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-daterange input-group">
                                                <input type="text" class="form-control date-picker" id="maintenanceDateFrom" value="<?php echo date('m/d/Y'); ?>">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-exchange"></i>
                                                </span>
                                                <input type="text" class="form-control date-picker" id="maintenanceDateTo" value="<?php echo date('m/d/Y'); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <button class="btn btn-sm btn-info btn-round" onclick="tblmaintenance();"><i class="fa fa-search"></i>&nbsp;Go</button>
                                        </div>
                                        <div class="col-md-5 pull-right">
                                            <a class="pull-right" onclick="printtblmaintenance();"><i class="glyphicon glyphicon-print" style="font-size: 20px;"></i></a>
                                            <span class="pull-right"><i class="fa fa-circle green"></i> Resolved&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                            <span class="pull-right"><i class="fa fa-circle blue"></i> Ongoing&nbsp;&nbsp;|&nbsp;&nbsp;</span>
                                            <span class="pull-right"><i class="fa fa-circle orange"></i> Pending&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;</span>
                                            <span class="pull-right">Status :&nbsp;&nbsp;&nbsp;</span>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-12">
                                            <div class="parent">
                                                <table class="table table-striped table-bordered fixTable">
                                                    <thead>
                                                        <tr>
                                                            <th width="10%">Work Order No</th>
                                                            <th width="40%">Work Order Details</th>
                                                            <th width="20%">Assigned To</th>
                                                            <th width="10%">Status</th>
                                                            <th width="15%">Schedule</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tblmaintenance"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="consbond" class="tab-pane fade">
                                    <div class="row">
                                        <form name="posting_conbond" id="posting_conbond">
                                        <input type="hidden" name="conbondid" id="conbondid">
                                        <div class="col-md-6">
                                            <div class="row form-group">
                                                <label class="col-md-4">Construction Date</label>
                                                <div class="col-md-4">
                                                    <input type="text" class="jonas-date-picker form-control" id="condbonddatefrom" name="condbonddatefrom" value="<?php echo date('m/d/Y'); ?>">
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" class="jonas-date-picker form-control" id="condbonddateto" name="condbonddateto" value="<?php echo date('m/d/Y'); ?>">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <label class="col-md-4"style="color: black !important;">Description</label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control input-sm" id="conbonddesc" name="conbonddesc"style="color: black !important;"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row form-group">
                                                <label class="col-md-4">Select Document</label>
                                                <div class="col-md-8">
                                                    <input id="conbondupload" name="conbondupload" class="form-control" type="file"/>
                                                </div>
                                            </div>
                                        </form>
                                            <div class="row form-group">
                                                <div class="col-md-12">
                                                    <div class="btn btn-xs btn-primary btn-round" style="width: 100%;" onclick="saveconbond();"><span class="fa fa-plus"></span> ADD</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-10 pull-right">
                                            <div class="parent">
                                                <table class="table table-striped table-bordered fixTable">
                                                    <thead>
                                                        <tr>
                                                            <th width="31%">Start Date</th>
                                                            <th width="31%">End Date</th>
                                                            <th width="30%">Attached Document</th>
                                                            <th width="7%"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tblconbond"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="memolist" class="tab-pane fade">
                                    <div class="row form-group">
                                        <div class="col-md-12">
                                            <div class="parent">
                                                <table class="table table-bordered table-striped fixTable">
                                                    <thead>
                                                        <tr>
                                                            <th width="10%">Date</th>
                                                            <th width="30%">Subject</th>
                                                            <th width="55%">Content</th>
                                                            <th width="5%">Option</th>
                                                            <tbody id="tbltenantmemolist"></tbody>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="complaintslist" class="tab-pane fade">
                                    <div class="row" style="margin-bottom: 0px;">
                                        <div class="col-md-12" style="padding-bottom: 5px;">
                                            <span class="pull-right label label-xlg label-yellow arrowed-in-right arrowed">Low Priority</span>
                                            <span class="pull-right label label-xlg label-warning arrowed-in-right arrowed">Medium Priority</span>
                                            <span class="pull-right label label-xlg label-danger arrowed-in-right arrowed">High Priority</span>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-bottom: 0px;">
                                        <div class="col-md-3 col-xs-3" style="padding-bottom: 5px;">
                                            <span class="input-icon" style="width: 100%;">
                                                <input type="text" class="form-control push-left" placeholder="Search" title="Search" id="txtSearchTPComplaints">
                                                <i class="ace-icon fa fa-search nav-search-icon"></i>
                                            </span>
                                        </div>
                                        <div class="col-md-3 col-xs-3" style="padding-bottom: 5px;">
                                            <h5><a onclick="loadTenantsProfFilter('TMListComplaints')" id="LINK_TMListComplaints_filter" class="popover-info" data-rel="popover" data-placement="bottom" title="Filter by" data-content='
                                                <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
                                                <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:95px;">&nbsp;&nbsp;Search by&nbsp;&nbsp;</legend>
                                                    <div class="form-group row" style="margin:0px;">
                                                        <div class="col-md-6">
                                                            <label>
                                                                <input name="form-field-TPComplaints" class="ace ace-checkbox-2" type="checkbox" value="Complaint_Code" id="filter_Complaint_Code">
                                                                <span class="lbl"> Complaint Code</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>
                                                                <input name="form-field-TPComplaints" class="ace ace-checkbox-2" type="checkbox" value="Complete_Description" id="filter_Complete_Description">
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
                                                                <input name="form-field-TPComplaintStat" class="ace" type="checkbox" value="High" id="filter_High">
                                                                <span class="lbl"> High Priority</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-4" style="padding-right:0px;">
                                                            <label class="label label-lg label-warning arrowed-in-right arrowed">
                                                                <input name="form-field-TPComplaintStat" class="ace" type="checkbox" value="Medium" id="filter_Medium">
                                                                <span class="lbl"> Medium Priority</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="label label-lg label-yellow arrowed-in-right arrowed">
                                                                <input name="form-field-TPComplaintStat" class="ace" type="checkbox" value="Low" id="filter_Low">
                                                                <span class="lbl"> Low Priority</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </fieldset>

                                                <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
                                                <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:189px;">&nbsp;&nbsp;Filter by Complaint Status&nbsp;&nbsp;</legend>
                                                    <div class="form-group row" style="margin:0px;">
                                                        <div class="col-md-4" style="padding-right:0px;">
                                                            <label style="margin-bottom: 0px;height:22px;padding-left:4px;">
                                                                <input name="form-field-TPComplaintStatus" class="ace" type="checkbox" value="Resolved" id="filter_Resolved">
                                                                <span class="lbl"> Resolved</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-4" style="padding-right:0px;">
                                                            <label style="margin-bottom: 0px;height:22px;padding-left:4px;">
                                                                <input name="form-field-TPComplaintStatus" class="ace" type="checkbox" value="Ongoing" id="filter_Ongoing">
                                                                <span class="lbl"> Ongoing</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label style="margin-bottom:0px;height:22px;padding-left:4px">
                                                                <input name="form-field-TPComplaintStatus" class="ace" type="checkbox" value="Pending" id="filter_Pending">
                                                                <span class="lbl"> Pending</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </fieldset>

                                                <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;">
                                                <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:90px;">&nbsp;&nbsp;Date Entry&nbsp;&nbsp;</legend>
                                                    <div class="form-group row" style="margin:0px;">
                                                        <div class="col-md-1"></div>
                                                        <div class="col-md-5">
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                                                                <input class="form-control div_app date-picker" type="text" id="TPComplaintsDateFrom" data-provide="datepicker">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                                                                <input class="form-control div_app date-picker" type="text" id="TPComplaintsDateTo" data-provide="datepicker">
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
                                                    <button class="btn btn-xs btn-info btn-round" id="btnSaveFilterComplaints" style="float:right;margin-bottom:10px;margin-right:10px;width:80px;">OK</button>
                                                </div>'>
                                                <i class="fa fa-filter bigger-110"></i>&nbsp;&nbsp;Select Filter here</a>
                                            </h5>
                                        </div>
                                        <div class="col-md-6 col-xs-6">
                                            <a class="pull-right" onclick="printtblcomplaints();" style="margin-left: 10px;margin-top: 10px;"><i class="glyphicon glyphicon-print" style="font-size: 20px;"></i></a>
                                            <button class="btn btn-sm btn-info pull-right hide isadmin select-addcomplaint btn-round" onclick='NewTPComplaints();$("#mdl_NewTPComplaints").modal("show");'>New Complaint</button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="parent">
                                                <table class="table table-striped table-bordered fixTable">
                                                    <thead>
                                                        <tr>
                                                            <th>Complaint Code</th>
                                                            <th>Complaint Description</th>
                                                            <th>Date Received</th>
                                                            <th>Date Resolved</th>
                                                            <th>Resolved By</th>
                                                            <th>Complaint Status</th>
                                                            <th style="z-index: 1;">Priority Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tblcomplaints"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="TPSTab" class="tab-pane fade">
                                    <div class="row form-group">
                                        <div class="col-xs-12 col-sm-12 center">
                                            <div class="row form-group">
                                                <div class="col-sm-12">
                                                    <h4 class="blue header">Tenant Portal Account</h4>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-xs-12 col-md-6">
                                                    <label class="col-xs-12 col-sm-12">Username</label>
                                                    <div class="col-xs-12 col-sm-12">
                                                        <span class="input-icon input-icon-right">
                                                            <input type="text" class="form-control" id="Tusername" readonly="true">
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-md-6">
                                                    <label class="col-xs-12 col-sm-12">Password</label>
                                                    <div class="col-xs-12 col-sm-12">
                                                        <span class="input-icon input-icon-right">
                                                            <input type="password" class="form-control input-sm" id="Tpassword" readonly="true" style="color: black !important;width: 100%;">
                                                            <i class="ace-icon fa fa-eye blue" id="TpasswordIcon" onclick="viewpasswordoftenant();"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-xs-12 col-md-6">
                                                    <label class="col-xs-12 col-sm-12">Accredited?</label>
                                                    <div class="hidden-xs col-sm-3"></div>
                                                    <div class="col-xs-6 col-sm-3">
                                                        <div class="radio">
                                                            <label>
                                                                <input name="form-field-radio" type="radio" class="ace chkAccredStat" id="chkAccredStatYes" value="1" onclick="ChangeStatAccred(this.id);">
                                                                <span class="lbl">&nbsp;&nbsp;&nbsp;Yes</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-3">
                                                        <div class="radio">
                                                            <label>
                                                                <input name="form-field-radio" type="radio" class="ace chkAccredStat" id="chkAccredStatNo" value="0" onclick="ChangeStatAccred(this.id);">
                                                                <span class="lbl">&nbsp;&nbsp;&nbsp;No</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="hidden-xs col-sm-3"></div>
                                                </div>
                                                <div class="col-xs-12 col-md-6">
                                                    <div class="col-sm-2"></div>
                                                    <label class="col-xs-12 col-sm-12">Type of Upload</label>
                                                    <div class="hidden-xs col-sm-3"></div>
                                                    <div class="col-xs-6 col-sm-3">
                                                        <div class="radio">
                                                            <label>
                                                                <input name="form-field-radio2" type="radio" class="ace chkFileLocat" id="chkFileLocatLocal" value="Local" onclick="ChangeLocatAccred(this.id);">
                                                                <span class="lbl">&nbsp;&nbsp;&nbsp;Local</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-3">
                                                        <div class="radio">
                                                            <label>
                                                                <input name="form-field-radio2" type="radio" class="ace chkFileLocat" id="chkFileLocatSFTP" value="SFTP" onclick="ChangeLocatAccred(this.id);">
                                                                <span class="lbl">&nbsp;&nbsp;&nbsp;SFTP</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="hidden-xs col-sm-3"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 center">
                                            <div class="row form-group">
                                                <div class="col-sm-12">
                                                    <h4 class="blue header">SFTP Account</h4>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-xs-12 col-md-4">
                                                    <div class="col-xs-12 col-sm-12">
                                                        Username : 
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12">
                                                        <span class="input-icon input-icon-right">
                                                            <input type="text" class="form-control txtSFTPCred" readonly id="txtSFTPUser">
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-md-4">
                                                    <div class="col-xs-12 col-sm-12">
                                                        Password : 
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12">
                                                        <span class="input-icon input-icon-right">
                                                            <input type="password" class="form-control txtSFTPCred" readonly id="txtSFTPPass">
                                                            <i class="ace-icon fa fa-eye blue" id="SFTPpasswordIcon" onclick="viewpasswordofSFTP();"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-md-4">
                                                    <div class="col-xs-12 col-sm-12">
                                                        Number of Machine : 
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12">
                                                        <span class="input-icon input-icon-right">
                                                            <input type="text" class="form-control txtSFTPCred txtSysNumOnly" readonly id="txtSFTPMachine">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-sm-12">
                                                    <div class="btn-group pull-right">
                                                        <button class="btn btn-primary btn-sm btn-round" id="btnSaveNEdit" onclick="fncSaveNEdit();"></button>
                                                        <button class="btn btn-danger btn-sm btn-round" id="btnCancel" onclick="fncCancelEditNSave();" style="display: none;">Cancel</button>
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
                <div class="btn-group pull-left">
                    <label style="font-weight: bold;">Status:&nbsp;&nbsp; <span id="stathere"></span></label>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" role="dialog" id="modalcontactperson" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Add Contact Persssson</h4>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-md-6">
                        <div class="row form-group">
                            <label class="col-md-4">Last Name</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control txtConReq" id="lname">
                                <input type="hidden" class="form-control" id="conid">
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-4">First Name</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control txtConReq" id="fname" />
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-4">Middle Name</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control txtConReq" id="mname" />
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-4">Mobile No.</label>
                            <div class="col-md-8">
                                <div class="input-group" style="width: 100%;">
                                    <input type="text" class="mobno spinbox-input form-control input-mask-phone mobilenum txtConReq" id="txtConMob" >
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-4">Telephone No.</label>
                            <div class="col-md-8">
                                <div class="input-group" style="width: 100%;">
                                    <input type="text" id="txtConTel" class="telno spinbox-input form-control input-mask-tele telnum txtConReq">
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-4">Email</label>
                            <div class="col-md-8">
                                <input type="text" class="email form-control txtEmail txtConReq" id="txtConEmail">
                                <span class="errohere" style="color: red; font-weight: 700;"></span>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-4">Company Position</label>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <select class="form-control txtConReq slctPosition" id="designation"></select>
                                    <div class="spinbox-buttons input-group-btn">
                                      <button type="button" class="btn spinbox-up btn-sm btn-success" onclick="fncAddPosition()">
                                        <i class="icon-only  ace-icon ace-icon fa fa-plus bigger-110"></i>
                                      </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-4">Address</label>
                            <div class="col-md-8">
                                <textarea id="address" class="form-control txtConReq" style="resize: none;height: 80px;"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row form-group center">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <form method="post" name="posting_contactimage" id="posting_contactimage">
                                    <label class="myupload">
                                        <img class="img-responsive" src="#" id="imgcontact" style="display: none;">
                                        <input type="file" name="contactimage" id="contactimage" onChange="showimgcontact();" class="disableifheader" accept="image/*"/>
                                        <span class="fa fa-cloud-upload" style="font-size: 60px; color: #999;" id="txtconspan"></span>
                                        <h1 id="txtconclick">Click here to upload picture</h1>
                                    </label>
                                    <div class="btn btn-light btn-sm btn-round" id="btnremoveconpic" onclick="removecontactphoto();" style="width: auto; display: none;"><span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Remove Photo</div>
                                    <input type="hidden" class="conidpic" name="conidpic" id="conidpic" />
                                    <input type="hidden" class="comidpic" name="comidpic" id="comidpic" />
                                </form>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-sm btn-round" onclick="savecontactperson();"><i class="fa fa-check"></i> Save</button>
            </div>
        </div>
    </div>
</div>

<div id="printmaintenancehistory" style="display: none;">
    <div class="container-fluid">
    <table style="width: 100%;margin-top: 10px;">
        <tbody class="template"></tbody>
    </table>
    <p style="text-align: right;">
        <span>Status :&nbsp;&nbsp;</span>
        <span><i class="fa fa-circle" style="color: #69AA46;"></i> Resolved&nbsp;&nbsp;</span>
        <span><i class="fa fa-circle" style="color: #FF892A;"></i> Ongoing&nbsp;&nbsp;</span>
        <span><i class="fa fa-circle" style="color: #478FCA;"></i> Pending&nbsp;&nbsp;</span>
    </p>
    <center style="font-size: 22px;font-weight: bold;background-color: #666;color: white;width: 100%;margin-top: -15px;">Maintenance History</center>
    <table style="width: 100%;">
        <thead>
            <tr>
                <th width="20%">Work Order No</th>
                <th width="40%">Work Order Details</th>
                <th width="20%">Assigned To</th>
                <th width="10%">Status</th>
                <th width="10%">Schedule</th>
            </tr>
            <tr><th colspan="5"><hr style="margin-top: -5px;"></th></tr>
        </thead>
        <tbody id="tblprintmaintenancehistory"></tbody>
    </table>
    </div>
</div>

<div id="printpaymenthistory" style="display: none;">
    <div class="container-fluid">
    <table style="width: 100%;margin-top: 10px;">
        <tbody class="template"></tbody>
    </table>
    <p style="text-align: right;">
        <span>Status :&nbsp;&nbsp;</span>
        <span><i class="fa fa-circle" style="color: #69AA46;"></i> Resolved&nbsp;&nbsp;</span>
        <span><i class="fa fa-circle" style="color: #FF892A;"></i> Ongoing&nbsp;&nbsp;</span>
        <span><i class="fa fa-circle" style="color: #478FCA;"></i> Pending&nbsp;&nbsp;</span>
    </p>
    <center style="font-size: 22px;font-weight: bold;background-color: #666;color: white;width: 100%;margin-top: -15px;">Maintenance History</center>
    <table style="width: 100%;">
        <thead>
            <tr>
                <th width="20%">Date</th>
                <th width="20%">Description</th>
                <th width="20%">Payment Type</th>
                <th width="20%">O.R Number</th>
                <th width="20%">Amount</th>
            </tr>
            <tr><th colspan="5"><hr style="margin-top: -5px;"></th></tr>
        </thead>
        <tbody id="tblprintpaymenthistory"></tbody>
    </table>
    </div>
</div>

<div id="div_printallsoaheader" style="display: none;">
    <div class="container-fluid">
    <table style="width: 100%;margin-top: 10px;">
        <tbody class="template"></tbody>
    </table>
    <center style="font-size: 22px;font-weight: bold;background-color: #666;color: white;width: 100%;">List of Statement of Accounts</center>
    <table style="width: 100%;">
        <thead>
            <tr>
                <th>SOA ID</th>
                <th>Ctrl No.</th>
                <th>Billing Period</th>
                <th>Penalty</th>
                <th>Payment</th>
                <th>Charges</th>
                <th>Balance</th>
            </tr>
            <tr><th colspan="7"><hr style="margin-top: -5px;"></th></tr>
        </thead>
        <tbody id="tblaccounthetails2"></tbody>
    </table>
    </div>
</div>

<div class="modal fade fade-scale" id="modal_opensoa" role="dialog" area-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content ">
      <div class="modal-body">
          <button type="button" class="close" onclick="closemodalsoa()"><i class="fa fa-times"></i></button>
          <div class="row form-group">
              <div class="col-md-12 col-xs-12">
                <div id="reportcontainer2" style="margin-top: 10px; display: block;">
                    <center>
                        <div class="checklist" id="tblsoa2" style="width: 99%;margin-bottom: 0;">
                            <center>
                            <!-- header starts here -->
                                <table style="width: 100%;" cellspacing="0" cellpadding="0" style="display: none;">
                                    <tbody id="template2"></tbody>
                                </table>
                            <!-- header ends here ... -->

                            <!-- billing information starts here -->
                                <table style="width: 100%;" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="15%"><h6 style="font-weight: bold;margin: 3px;font-size: 12px;">BILL TO</h6></td>
                                        <td width="2%">:</td>
                                        <td width="46%"><h6 style="font-weight: normal;margin: 3px;font-size: 12px;" id="txtprint_storename"></h6></td>
                                        <td width="15%"><h6 style="font-weight: bold;margin: 3px;font-size: 12px;">CUT-OFF DATE</h6></td>
                                        <td width="2%">:</td>
                                        <td width="20%"><h6 style="font-weight: normal;margin: 3px;font-size: 12px;" id="txtprint_cutoff"></h6></td>
                                    </tr>
                                    <tr>
                                        <td width="15%"><h6 style="font-weight: bold;margin: 3px;font-size: 12px;">ASSIGNEE</h6></td>
                                        <td width="2%">:</td>
                                        <td width="46%"><h6 style="font-weight: normal;margin: 3px;font-size: 12px;" id="txtprint_assignee"></h6></td>
                                        <td width="15%"><h6 style="font-weight: bold;margin: 3px;font-size: 12px;">BILLING NO.</h6></td>
                                        <td width="2%">:</td>
                                        <td width="20%"><h6 style="font-weight: normal;margin: 3px;font-size: 12px;" id="txtprint_billingnumber"></h6></td>
                                    </tr>
                                    <tr>
                                        <td><h6 style="font-weight: bold;margin: 3px;font-size: 12px;">ADDRESS</h6></td>
                                        <td>:</td>
                                        <td><h6 style="font-weight: normal;margin: 3px;font-size: 12px;" id="txtprint_address"></h6></td>
                                        <td><h6 style="font-weight: bold;margin: 3px;font-size: 12px;">BILLING PERIOD</h6></td>
                                        <td>:</td>
                                        <td><h6 style="font-weight: normal;margin: 3px;font-size: 12px;" id="txtprint_billingperiod"></h6></td>
                                    </tr>
                                </table>
                            <!-- billing info ends here ... -->
                                <table style="width: 100%;margin-top: 10px;" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td colspan="4" align="center" style="background-color: #111109 !important;-webkit-print-color-adjust: exact;"><h6 style="font-weight: bold;margin: 3px;font-size: 12px;color: #ffffff !important;">STATEMENT OF ACCOUNT</h6></td>
                                    </tr>
                                </table>
                                <table style="width: 100%;margin-top: 10px;" cellspacing="0" cellpadding="0">
                                    <tr style="border-left:1px solid #111109;border-right:1px solid #111109;">
                                        <td style="background-color: #111109 !important;-webkit-print-color-adjust: exact;padding-left: 5px;" align="left">
                                            <h6 style="font-weight: bold;margin: 3px;font-size: 12px;color: #ffffff !important;">DATE</h6>
                                        </td>
                                        <td style="background-color: #111109 !important;-webkit-print-color-adjust: exact;" align="left">
                                            <h6 style="font-weight: bold;margin: 3px;font-size: 12px;color: #ffffff !important;">REFERENCE</h6>
                                        </td>
                                        <td style="background-color: #111109 !important;-webkit-print-color-adjust: exact;" align="left">
                                            <h6 style="font-weight: bold;margin: 3px;font-size: 12px;color: #ffffff !important;">TRANSACTION DETAILS</h6>
                                        </td>
                                        <td style="background-color: #111109 !important;-webkit-print-color-adjust: exact;padding-right: 5px;" align="right">
                                            <h6 style="font-weight: bold;margin: 3px;font-size: 12px;color: #ffffff !important;">AMOUNT</h6>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td style="font-weight: bold;margin: 3px;font-size: 12px;color: #111109;">
                                            TOTAL PREVIOUS BALANCES
                                        </td>
                                        <td style="font-weight: bold;margin: 3px;font-size: 12px;color: #111109;padding-right: 5px;" align="right">
                                            <label id="ttlprevblncs"></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="border-top: 2px solid #111109"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td style="font-weight: bold;margin: 3px;font-size: 12px;color: #111109;">
                                            TOTAL Penalty Charges (Account 31 days and over)
                                        </td>
                                        <td style="font-weight: bold;margin: 3px;font-size: 12px;color: #111109;padding-right: 5px;" align="right">
                                            <label id="ttlpenalty">0.00</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="border-top: 2px solid #111109"></td>
                                    </tr>
                                    <!-- previous balance ends here -->

                                    <!-- current charges starts here ... -->
                                    <tr style="border-left:1px solid #111109;border-right:1px solid #111109;">
                                        <td colspan="4" style="padding-left: 5px;">
                                            <h6 style="font-weight: bold;margin: 3px;font-size: 11px;color: #111109;">CURRENT CHARGES</h6>
                                        </td>
                                    </tr>
                                    <tbody style="border-left:1px solid #111109;border-right:1px solid #111109;border-bottom:1px solid #111109;" id="tblcurrchrges">
                                    </tbody>
                                    <!-- <tr style="border-left:1px solid #111109;border-right:1px solid #111109;">
                                        <td colspan="4" style="padding-left: 5px;">
                                            <h6 style="font-weight: bold;margin: 3px;font-size: 11px;color: #111109;">OTHER CHARGES</h6>
                                        </td>
                                    </tr>
                                    <tbody style="border-left:1px solid #111109;border-right:1px solid #111109;border-bottom:1px solid #111109;" id="tblotherchrges">
                                    </tbody> -->
                                    <tbody style="border-left:1px solid #111109;border-right:1px solid #111109;">
                                        <tr>
                                            <td colspan="2"></td>
                                            <td style="font-weight: bold;margin-top: 4px;margin-bottom: 3px;font-size: 12px;color: #111109;">
                                                TOTAL CURRENT CHARGES
                                            </td>
                                            <td style="font-weight: bold;margin: 3px;font-size: 12px;color: #111109;padding-right: 5px;" align="right">
                                                <label id="ttlcurrchrges"></label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" style="border-top: 2px solid #111109"></td>
                                        </tr>
                                    </tbody>
                                    <!-- current charges ends here ... -->

                                    <!-- payment and adjustments starts here ... -->
                                    <tr style="border-left:1px solid #111109;border-right:1px solid #111109;">
                                        <td colspan="4" style="padding-left: 5px;">
                                            <h6 style="font-weight: bold;margin: 3px;font-size: 11px;color: #111109;">PAYMENTS AND CREDIT ADJUSTMENT</h6>
                                        </td>
                                    </tr>
                                    <tbody style="border-left:1px solid #111109;border-right:1px solid #111109;border-bottom:1px solid #111109;" id="tblpymentcrdtadj">                     
                                    </tbody>
                                    <tbody style="border-left:1px solid #111109;border-right:1px solid #111109;border-bottom:1px solid #111109;">
                                        <tr>
                                            <td colspan="2"></td>
                                            <td style="font-weight: bold;margin-top: 4px;margin-bottom: 3px;font-size: 11px;color: #111109;">
                                                TOTAL PAYMENTS
                                            </td>
                                            <td style="font-weight: bold;margin: 3px;font-size: 11px;color: #111109;padding-right: 5px;" align="right">
                                                <label id="ttlpymentcrdtadj"></label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" style="border-top: 2px solid #111109"></td>
                                        </tr>
                                        <!-- payment and adjustments ends here ... -->

                                        <!-- breakdown starts here ... -->
                                        <tr>
                                            <td colspan="2" align="left" style="font-weight: bold;margin-top: 4px;margin-bottom: 3px;font-size: 11px;color: #111109;padding-left: 10px;">
                                                TOTAL PREVIOUS BALANCES
                                            </td>
                                            <td colspan="2" align="right" style="font-weight: bold;margin-top: 4px;margin-bottom: 3px;font-size: 11px;color: #111109;padding-right: 5px;">
                                                <label id="ttlprevblncs2"></label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" align="left" style="font-weight: bold;margin-top: 4px;margin-bottom: 3px;font-size: 11px;color: #111109;padding-left: 10px;">
                                                ADD: TOTAL CURRENT CHARGES
                                            </td>
                                            <td colspan="2" align="right" style="font-weight: bold;margin-top: 4px;margin-bottom: 3px;font-size: 11px;color: #111109;padding-right: 5px;">
                                                <label id="ttlcurrchrges2"></label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" align="left" style="font-weight: bold;margin-top: 4px;margin-bottom: 3px;font-size: 11px;color: #111109;padding-left: 10px;">
                                                LESS: TOTAL PAYMENTS
                                            </td>
                                            <td colspan="2" align="right" style="font-weight: bold;margin-top: 4px;margin-bottom: 3px;font-size: 11px;color: #111109;padding-right: 5px;">
                                                <label id="ttlpymentcrdtadj2"></label>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tbody style="width: 100%;border-collapse: collapse;">
                                        <tr>
                                            <td colspan="2" style="padding-right: 5px;background-color: #111109 !important;-webkit-print-color-adjust: exact;padding-left: 10px;" align="left">
                                                <h6 style="font-weight: bold;margin-top: 4px;margin-bottom: 3px;font-size: 12px;color: #ffffff !important;">
                                                    AMOUNT DUE
                                                </h6>
                                            </td>
                                            <td colspan="2" style="padding-left: 20px;background-color: #111109 !important;-webkit-print-color-adjust: exact;padding-right: 5px;" align="right">
                                                <h6 style="font-weight: bold;margin-top: 4px;margin-bottom: 3px;font-size: 12px;color: #ffffff !important;" id="ttlamtdue">
                                                     0.00
                                                </h6>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tbody>
                                        <tr>
                                            <td colspan="4">
                                                <table style="width: 100%;border-collapse: collapse;">
                                                    <tr>
                                                        <td colspan="4"><br/></td>
                                                    </tr>
                                                    <tr style="border-left:1px solid #111109;border-right:1px solid #111109;">
                                                        <td colspan="6" align="center" style="background-color: #111109 !important;-webkit-print-color-adjust: exact;"><h6 style="font-weight: bold;margin: 3px;font-size: 11px;color: #ffffff !important;">OVERDUE ACCOUNTS</h6></td>
                                                    </tr>
                                                    <tr  style="border-left:1px solid #111109;border-bottom:1px solid #111109;border-right:1px solid #111109;">
                                                        <td style="text-align: center;border-left:1px solid #111109;border-bottom:1px solid #111109;font-size: 12px;">AGING SUMMARY</td>
                                                        <td style="text-align: center;border-left:1px solid #111109;border-bottom:1px solid #111109;font-size: 12px;">CURRENT</td>
                                                        <td style="text-align: center;border-left:1px solid #111109;border-bottom:1px solid #111109;font-size: 12px;">1-30 DAYS</td>
                                                        <td style="text-align: center;border-left:1px solid #111109;border-bottom:1px solid #111109;font-size: 12px;">31-60 DAYS</td>
                                                        <td style="text-align: center;border-left:1px solid #111109;border-bottom:1px solid #111109;font-size: 12px;">61-90 DAYS</td>
                                                        <td style="text-align: center;border-left:1px solid #111109;border-bottom:1px solid #111109;border-right:1px solid #111109;font-size: 12px;">OVER 90 DAYS</td>
                                                    </tr>
                                                    <tr style="border-left:1px solid #111109;border-bottom:1px solid #111109;border-right:1px solid #111109;font-size: 12px;">
                                                        <td style="text-align: center;border-left:1px solid #111109;border-bottom:1px solid #111109;font-size: 12px;"></td>
                                                        <td style="text-align: center;border-left:1px solid #111109;border-bottom:1px solid #111109;font-size: 12px;" id="txtsoab00">0.00</td>
                                                        <td style="text-align: center;border-left:1px solid #111109;border-bottom:1px solid #111109;font-size: 12px;" id="txtsoab13">0.00</td>
                                                        <td style="text-align: center;border-left:1px solid #111109;border-bottom:1px solid #111109;font-size: 12px;" id="txtsoab36">0.00</td>
                                                        <td style="text-align: center;border-left:1px solid #111109;border-bottom:1px solid #111109;font-size: 12px;" id="txtsoab69">0.00</td>
                                                        <td style="text-align: center;border-left:1px solid #111109;border-bottom:1px solid #111109;border-right:1px solid #111109;font-size: 12px;" id="txtsoab99">0.00</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <!-- payment and adjustments ends here ... -->
                                    <tbody>
                                        <tr>
                                            <td colspan="4">
                                                <table style="width:100%;">
                                                    <tr>
                                                        <td width="25%">
                                                            <h6 style="font-weight: normal;margin: 3px;font-size: 10px;color: #111109;">Prepared by:</h6><br /><br />
                                                        </td>
                                                        <td width="25%">
                                                            <h6 style="font-weight: normal;margin: 3px;font-size: 10px;color: #111109;">Checked by:</h6><br /><br />
                                                        </td>
                                                        <td width="25%">
                                                            <h6 style="font-weight: normal;margin: 3px;font-size: 10px;color: #111109;">Approved by:</h6><br /><br />
                                                        </td>
                                                        <td width="25%">
                                                            <h6 style="font-weight: normal;margin: 3px;font-size: 10px;color: #111109;">Received by / Date Received:</h6><br /><br />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td width="25%" style="text-align: center;">
                                                        <label id="lblprepby"></label>
                                                            <hr style="border-color: #111109;width: 90%;margin:0px;">
                                                        </td>
                                                        <td width="25%" style="text-align: center;">
                                                        <label id="lblchkby"></label>
                                                            <hr style="border-color: #111109;width: 90%;margin:0px;">
                                                        </td>
                                                        <td width="25%" style="text-align: center;">
                                                        <label id="lblapprby"></label>
                                                            <hr style="border-color: #111109;width: 90%;margin:0px;">
                                                        </td>
                                                        <td width="25%" style="text-align: center;">
                                                        <label id="lblrcvdby"></label>
                                                            <hr style="border-color: #111109;width: 90%;margin:0px;">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td width="25%">
                                                            <h6 style="font-weight: normal;margin: 0px;font-size: 10px;color: #111109;text-align: center;">Billing, Credit and Collection</h6>
                                                        </td>
                                                        <td width="25%">
                                                            <h6 style="font-weight: normal;margin: 0px;font-size: 10px;color: #111109;text-align: center;">Authorized Signatory</h6>
                                                        </td>
                                                        <td width="25%">
                                                            <h6 style="font-weight: normal;margin: 0px;font-size: 10px;color: #111109;text-align: center;">Authorized Signatory</h6>
                                                        </td>
                                                        <td width="25%">
                                                            <h6 style="font-weight: normal;margin: 0px;font-size: 10px;color: #111109;text-align: center;">Signature over Printed Name</h6>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </center>
                            <div class="divFooter"><h6 id="print_footer"></h6></div>
                        </div>
                    </center>
                </div>                
              </div>
          </div>
          <div class="row form-group">
            <div class="col-md-2 col-xs-12" style="padding-right:0px;"></div>
            <div class="col-md-10 col-xs-12">
                <button type="button" class="btn btn-primary hide isadmin select-printsoa btn-round" style="float: right;" id="" onclick="printsoa()">&nbsp;Print</button>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade fade-scale" id="div_Contract" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-md-12">
                        <button type="button" class="close" data-dismiss="modal"><i class="ace-icon fa fa-times bigger-130"></i></button>
                        <div id="div_CustomContract"></div>
                    </div>
                </div>
                <div class="row form-group" style="display: none">
                    <button class="btn btn-primary pull-right btn-round" style="margin-right: 20px;" onclick="fncPrintCustomContract()">&nbsp;Print</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" id="div_ModRent" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick="" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Modify Rent</h4>
                <input type="hidden" id="txtModRentID">
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row form-group">
                            <label class="col-md-12">Billing Date</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control date-picker" id="txtModRentDate">
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-12">Revenue Percentage</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control txtSysNumOnly" id="txtModRentRevPerc">
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-12">Rent Amount</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control txtSysNumOnly txtSysCurrency" id="txtModRentAmount" style="text-align: right;">
                            </div>
                        </div>
                        <?php if(SysLeaseSetup('isAssocDues') == "1"){ ?>
                        <div class="row form-group">
                            <label class="col-md-12">Association Dues</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control txtSysNumOnly txtSysCurrency" id="txtModRentAssocDues" style="text-align: right;">
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-md btn-primary btn-round" onclick="fncSaveModRent();"><i class="fa fa-check"></i> Save</button>
            </div>
        </div>
    </div>
</div>