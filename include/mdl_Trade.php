<div class="modal fade fade-scale" id="mdlTradeList" role="dialog" area-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" style="width: 80%;">
        <div class="modal-content">
            <div id="preloadmdlTradeList"></div>
            <div class="modal-header" style="background-color: #438EB9;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title hdrSysTenant" style="font-size: 18px;">Store List</h4>
            </div>
            <div class="modal-body" id="modal-body-inquiry">
                <div class="row form-group">
                    <div class="col-md-3 col-xs-12">
                        <span class="input-icon" style="width: 100%;">
                            <input type="text" class="form-control" placeholder="Search" id="txtsearchtradename">
                            <i class="ace-icon fa fa-search nav-search-icon"></i>
                        </span>
                    </div>
                    <div class="col-md-2 col-xs-12 pull-right">
                        <a href="#" id="btnnew_store" class="btn btn-info btn-sm btnSysTenant btn-round" style="width: 100% !important;" onclick="fncAddNewTrade()">New Store</a>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-xs-12">
                        <div id="tradetable" class="parent">
                            <table class="table table-bordered table-hover fixTable">
                                <thead>
                                    <tr>
                                        <th style="width: 15%;">Merchant Code</th>
                                        <th style="width: 40%;" class="thSysTenant"></th>
                                        <th style="width: 40%">Company</th>
                                        <th style="z-index: 1; width: 5%;">Option</th>
                                    </tr>
                                </thead>
                                <tbody id="tbltradenamelist"></tbody>
                            </table>
                        </div>
                        <table class="tabledash_footer table" style="margin: 0px !important;">
                            <thead>
                                <tr>
                                    <th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
                                        <font id="txtentriesstorelist" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
                                        <input id="txt_userpage_tenants" type="hidden">
                                        <ul id="ulpaginationstorelist" class="pagination pull-right"></ul>
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

<div class="modal fade fade-scale" id="modal_newtradename" role="dialog" area-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;" id="hdrStoreProfile">Store</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row form-group">
                            <div class="col-md-12">
                                <div class="widget-container-col ui-sortable" id="widget-container-buyerinfo">
                                    <div class="widget-box transparent ui-sortable-handle" id="widget-box-12">
                                        <div class="widget-header"> 
                                            <h4 class="widget-title"><?php if(SysLeaseSetup('softwaretype') == '0'){ echo "Store"; }else if(SysLeaseSetup('softwaretype') == '5'){ echo "Buyer"; }else{ echo "Tenant"; } ?> Profile</h4>
                                        </div>
                                        <div class="widget-body">
                                            <div class="widget-main">
                                                <div class="row well">
                                                    <div class="row form-group">
                                                        <div class="col-md-12">
                                                            <div class="row form-group">
                                                                <h4 class="green">Tenant Information</h4>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="row form-group">
                                                                <div class="col-md-6">
                                                                    <div class="row form-group">
                                                                        <div class="col-md-12 col-xs-12 thSysTenant2">Store Name</div>
                                                                        <div class="col-md-12 col-xs-12"><input type="text" class="form-control text_new_trade" id="txtNewTradeName"></div>
                                                                    </div>
                                                                    <div class="row form-group">
                                                                        <div class="col-md-12 col-xs-12">Company Name</div>
                                                                        <div class="col-md-12 col-xs-12">
                                                                            <div class="input-group">
                                                                                <input type="text" class="form-control" placeholder="Company Name" id="txtTradeCompanyName" readonly style="background-color: white !important;">
                                                                                <span class="input-group-btn">
                                                                                    <button type="button" class="btn btn-white" title="Click here to browse company profiles" onclick="modal_loadcompany()">
                                                                                        <span class="fa fa-search bigger-110"></span>              
                                                                                    </button>
                                                                                </span>
                                                                            </div>
                                                                            <input type="hidden" id="txtTradeCompanyID">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="row form-group">
                                                                        <div class="col-xs-12 col-md-12">
                                                                            Merchant Code <span class="red">*</span>
                                                                        </div>
                                                                        <div class="col-xs-12 col-md-12">
                                                                            <input type="text" class="form-control text_new_trade" id="txtTradeMerchantID" placeholder="Merchant Code" style="text-transform: uppercase; background-color: white !important;">
                                                                        </div>
                                                                    </div>
                                                                    <div class="row form-group">
                                                                        <div class="col-md-12 col-xs-12">Industry</div>
                                                                        <div class="col-md-12 col-xs-12"><input type="text" class="form-control" id="txtTradeIndustry" placeholder="Industry" readonly style="background-color: white !important;"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="row form-group">
                                                                        <div class="col-md-12 col-xs-12">Business Address</div>
                                                                        <div class="col-md-12 col-xs-12">
                                                                            <textarea class="form-control" style="height: 70px; resize: none; background-color: white !important;" id="txtTradeAddress" placeholder="Business Address" readonly></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="row form-group">
                                                                <div class="col-md-12 col-xs-12">
                                                                    <div class="image">
                                                                        <img class="img-thumbnail imageName form-control" src="assets/images/noimage5.png" id="imgTradePicture" style="border: 2px solid #bdc3c7; margin-bottom: 8px;height: 186px;">
                                                                    </div>
                                                                    <form name="posting_profilepic_trade" id="posting_profilepic_trade" >
                                                                        <div style="display: none;"><input type="text" id="trade_hidden_companyID2" name="companyID">
                                                                        <input type="text" id="trade_hidden_tradeID" name="tradeID"></div>
                                                                        <input id="file_upload_trade" name="attachment_profilepic" class="form-control upload" type="file" onchange="showimgtrade();" accept="image/*"/>
                                                                    </form>
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
                                                                <div class="col-xs-12 col-md-4">
                                                                    <div class="row form-group">
                                                                        <div class="col-md-12">
                                                                            <label>
                                                                                <input name="form-field-checkbox" type="checkbox" class="ace" id="chkTradeAsPrimary">
                                                                                <span class="lbl"> Set as primary</span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row form-group">
                                                                        <div class="col-xs-12 col-md-12">
                                                                            Contact Name
                                                                        </div>
                                                                        <div class="col-xs-12 col-md-12">
                                                                            <input type="text" class="form-control trade_save_contact_per" placeholder="First Name" id="txtTradeFName">
                                                                        </div>
                                                                    </div>
                                                                    <div class="row form-group">
                                                                        <div class="col-xs-12 col-md-12">
                                                                            <input type="text" class="form-control" placeholder="Middle Name" id="txtTradeMName">
                                                                        </div>
                                                                    </div>
                                                                    <div class="row form-group">
                                                                        <div class="col-xs-12 col-md-12">
                                                                            <input type="text" class="form-control trade_save_contact_per" placeholder="Last Name" id="txtTradeLName">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-12 col-md-4">
                                                                    <div class="row form-group">
                                                                        <div class="col-md-6">
                                                                            <label>
                                                                                <input name="form-field-checkbox" type="radio" class="ace rdTradeContactStat" value="Active" checked id="chkTradeContactStatActive">
                                                                                <span class="lbl"> Active</span>
                                                                            </label>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label>
                                                                                <input name="form-field-checkbox" type="radio" class="ace rdTradeContactStat" value="Inactive">
                                                                                <span class="lbl"> Inactive</span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row form-group">
                                                                        <div class="col-xs-12 col-md-12">
                                                                            Company Position
                                                                        </div>
                                                                        <div class="col-xs-12 col-md-12">
                                                                            <div class="input-group">
                                                                                <select class="form-control trade_save_contact_per slctPosition" id="txtTradePosition"></select>
                                                                                <div class="spinbox-buttons input-group-btn">
                                                                                    <button type="button" class="btn spinbox-up btn-sm btn-success" onclick="fncAddPosition();">
                                                                                        <i class="icon-only  ace-icon ace-icon fa fa-plus bigger-110"></i>
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row form-group">
                                                                        <div class="col-xs-12 col-md-12">
                                                                            Address
                                                                        </div>
                                                                        <div class="col-xs-12 col-md-12">
                                                                            <textarea class="form-control" style="background-color: white !important; resize: none; height: 63px;" class="form-control home-address trade_save_contact_per" id="txtTradeConAddress" onclick="loadaddressmodal('txtTradeConAddress')" onkeyup="loadaddressmodal('txtTradeConAddress')" placeholder="Click to add address..." readonly></textarea>
                                                                        </div>
                                                                    </div>                                                            
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="row form-group">
                                                                        <div class="col-xs-12 col-md-12">
                                                                            Email Address
                                                                        </div>
                                                                        <div class="col-xs-12 col-md-12">
                                                                            <div class="input-group div_store_contacts" id="store_contact_email" style="width: 100%;"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row form-group">
                                                                        <div class="col-xs-12 col-md-12">
                                                                            Mobile No
                                                                        </div>
                                                                        <div class="col-xs-12 col-md-12">
                                                                            <div class="input-group div_store_contacts" id="store_contact_mobile" style="width: 100%;"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row form-group">
                                                                        <div class="col-xs-12 col-md-12">
                                                                            Telephone No
                                                                        </div>
                                                                        <div class="col-xs-12 col-md-12">
                                                                            <div class="input-group div_store_contacts" id="store_contact_tele" style="width: 100%;"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <button id="btn-trade-save-contact-person" class="pull-right btn btn-sm btn-success btn-round">Add Contact</button>
                                                                </div>
                                                            </div>
                                                            <div class="row form-group">
                                                                <div class="col-md-12 col-xs-12" id="div_Trade_contact_person_list"></div>
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
                                    <div class="widget-box transparent ui-sortable-handle collapsed" id="widget-box-12">
                                        <div class="widget-header"> 
                                            <h4 class="widget-title">Billing Information</h4>
                                            <div class="widget-toolbar">
                                                <a href="#" data-action="collapse">
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
                                                                    Account Name
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <input type="hidden" id="txtTradeBillID">
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control" placeholder="Account Name" id="txtTradeBillAccount" readonly style="background-color: white !important;">
                                                                        <span class="input-group-btn">
                                                                            <button type="button" class="btn btn-inverse btn-white" title="Click here to browse billing profiles" onclick="fncOpenBillingAccountList();">
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
                                                                    Billing Setup
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <select class="form-control" id="txtTradeBillingSetup">
                                                                        <option value="Individual">Individual</option>
                                                                        <option value="Merged">Merged</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-md-4">
                                                            <div class="row form-group">
                                                                <div class="col-md-12">
                                                                    Telephone No
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <input type="text" class="form-control input-mask-tele" id="txtTradeBillTele" placeholder="(99)-999-9999" readonly style="background-color: white !important;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="row form-group">
                                                                <div class="col-md-12">
                                                                    Mobile No
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <input type="text" class="form-control input-mask-tele" id="txtTradeBillMobi" placeholder="(99)-999-9999" readonly style="background-color: white !important;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="row form-group">
                                                                <div class="col-md-12">
                                                                    Email Address
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <input type="text" class="form-control input-mask-tele" id="txtTradeBillEmail" placeholder="sample@yahoo.com" readonly style="background-color: white !important;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-md-12">
                                                            Permanent Address
                                                        </div>
                                                        <div class="col-md-12">
                                                            <span class="input-icon" style="width: 100%;">
                                                                <textarea class="form-control home-address" style="height: 50px; resize: none; background-color: white !important;" id="txtTradeBillPerma" placeholder="Permanent Address" readonly></textarea>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-md-12">
                                                            Current Address
                                                        </div>
                                                        <div class="col-md-12">
                                                            <span class="input-icon" style="width: 100%;">
                                                                <textarea class="form-control home-address" style="height: 50px; resize: none; background-color: white !important;" id="txtTradeBillCurr" placeholder="Current Address" readonly></textarea>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-md-12">
                                                            Billing Address
                                                        </div>
                                                        <div class="col-md-12">
                                                            <span class="input-icon" style="width: 100%;">
                                                                <textarea class="form-control home-address" style="height: 50px; resize: none; background-color: white !important;" id="txtTradeBillBillingAddress" placeholder="Billing Address" readonly></textarea>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div id="div_TradeBillerContact"></div>
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
                <button class="btn btn-sm btn-primary btn-round" onclick="savetradename()" id="btn_modal_new_store" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving..."><i class="ace-icon fa fa-check"></i>&nbsp;Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" id="mdlBillingAccountList" role="dialog" area-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div id="preloadmdlTradeList"></div>
            <div class="modal-header" style="background-color: #438EB9;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Billing Account List</h4>
            </div>
            <div class="modal-body" id="modal-body-inquiry">
                <div class="row form-group">
                    <div class="col-md-3 col-xs-12">
                        <span class="input-icon" style="width: 100%;">
                            <input type="text" class="form-control" placeholder="Search" id="txtSearchBillProfile">
                            <i class="ace-icon fa fa-search nav-search-icon"></i>
                        </span>
                    </div>
                    <div class="col-md-2 col-xs-12 pull-right">
                        <!-- <a href="#" id="btnnew_store" class="btn btn-info btn-sm btnSysTenant btn-round" style="width: 100% !important;" onclick="fncAddNewTrade()">New Store</a> -->
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-xs-12">
                        <div id="tradetable" class="parent">
                            <table class="table table-bordered table-hover fixTable">
                                <thead>
                                    <tr>
                                        <th style="width: 30%;">Account Name</th>
                                        <th style="width: 20%">Telephone</th>
                                        <th style="width: 50%;">Billing Address</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyBillAccountList"></tbody>
                            </table>
                        </div>
                        <table class="tabledash_footer table" style="margin: 0px !important;">
                            <thead>
                                <tr>
                                    <th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
                                        <font id="txtBillAccountEntries" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
                                        <input id="txtBillAccountListPage" type="hidden">
                                        <ul id="ulPaginationBillAccount" class="pagination pull-right"></ul>
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

<script type="text/javascript">
    $(function(){
        $("#txt_userpage_tenants").val("1");
        $("#txtsearchtradename").keyup(function(e){
            var x = event.keyCode;
            if(x == 13){ 
                $("#txt_userpage_tenants").val("1");
                fncLoadTradeList(); 
            }else if(x == '8'){
                if($('#txtsearchtradename').val() == ""){
                    $("#txt_userpage_tenants").val("1");
                    fncLoadTradeList();
                }
            }
        });
        $("#txtSearchBillProfile").keyup(function(e){
            var x = event.keyCode;
            if(x == 13){ 
                $("#txtBillAccountListPage").val("1");
                fncLoadBillingAccountList(); 
            }else if(x == '8'){
                if($('#txtSearchBillProfile').val() == ""){
                    $("#txtBillAccountListPage").val("1");
                    fncLoadBillingAccountList();
                }
            }
        });
    });

    function fncLoadTradeList() {
        var page = $("#txt_userpage_tenants").val();
        var txtsearchtradename = $("#txtsearchtradename").val();
        $.ajax({
            type: 'POST',
            url: 'include/class.php',
            data: 'txtsearchtradename=' + txtsearchtradename + '&page=' + page + '&form=fncLoadTradeList',
            beforeSend: function(){
                $('#preloadmdlTradeList').addClass('myspinner');
            },
            success:function(data){
                $("#preloadmdlTradeList").removeClass("myspinner");
                if(data != ""){
                    $("#tbltradenamelist").html(data);
                }else{
                    $("#tbltradenamelist").html("<tr><td colspan='4' style='text-align: center;'>No Data Found...</td></tr>");
                }
            },
            complete: function(){
                fncTradePagination();
                fncTradeEntries();
            }
        })
    }

    function fncTradeEntries(){
        var page = $("#txt_userpage_tenants").val();
        var txtsearchtradename = $("#txtsearchtradename").val();
        $.ajax({
            type: 'POST',
            url: 'include/class.php',
            data: 'txtsearchtradename=' + txtsearchtradename + '&page=' + page  + '&form=fncTradeEntries',
            success: function(data){
                $("#txtentriesstorelist").text(data);
            }
        });
    }

    function fncTradePagination(){
        var page = $("#txt_userpage_tenants").val();
        var txtsearchtradename = $("#txtsearchtradename").val();
        $.ajax({
            type: 'POST',
            url: 'include/class.php',
            data: 'page=' + page + '&txtsearchtradename=' + txtsearchtradename + '&form=fncTradePagination',
            success: function(data){
                $("#ulpaginationstorelist").html(data);
            }
        });
    }

    function fncTradebtnPagination(page, pagenums){
        $(".pgnum").removeClass("active");
        $("#pg" + pagenums).addClass("active");
        $("#txt_userpage_tenants").val(page);
        fncLoadTradeList();
    }

    function fncEditTradeInfo(TradeID) {
        $("#chkTradeContactStatActive").prop("checked", true);
        loadmodalcompanyposition();
        $("#btn-trade-save-contact-person").attr("onclick", "fncAddTradeContact_Update(\""+ TradeID +"\")");
        $(".text_new_trade").css("border-color","#D5D5D5");
        $("#posting_profilepic_trade").html('<div style="display: none;"><input type="text" id="trade_hidden_companyID2" name="companyID"><input type="text" id="trade_hidden_tradeID" name="tradeID"></div><input id="file_upload_trade" name="attachment_profilepic" class="form-control upload" type="file" onchange="showimgtrade();" accept="image/*"/>');
        $("#modal_newtradename").modal("show");
        $("#hdrStoreProfile").text("Edit <?php if(SysLeaseSetup('softwaretype') == '0'){ echo "Store"; }else if(SysLeaseSetup('softwaretype') == '5'){ echo "Buyer"; }else{ echo "Tenant"; } ?> Profile")
        $("#btn_modal_new_store").attr("onclick", "savetradename_update(\""+ TradeID +"\")");
        $("#txtNewTradeName").attr("onchange", "GenerateMerchantCode(this.value, \"edit\")")
        $('#file_upload_trade').ace_file_input({
            no_file:'No File ...',
            btn_choose:'Choose',
            btn_change:'Change',
            droppable:false,
            onchange:null,
            thumbnail:false
        });
        $.ajax({
            type: 'POST',
            url: 'include/class.php',
            data: 'TradeID=' + TradeID + '&form=fncEditTradeInfo',
            success: function(data) {
                var arr = data.split("|");
                $("#imgTradePicture").attr("src", arr[0]);
                $("#imgTradePicture").attr("alt", arr[1]);
                $("#txtNewTradeName").val(arr[1]);
                $("#txtTradeMerchantID").val(arr[2])
                $("#txtTradeCompanyName").val(arr[3]);
                $("#txtTradeCompanyID").val(arr[4]);
                $("#txtTradeIndustry").val(arr[5]);
                $("#txtTradeAddress").val(arr[6]);
                $("#txtTradeBillingSetup").val(arr[7]);
                fncclickBillProfile(arr[8])
            }
        })
        $.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'id=' + TradeID + '&form=load_updatetrade_contactpersons',
            success: function(data) {
                $("#div_Trade_contact_person_list").html(data);
            }, complete: function(){
                $("#store_contact_mobile").html('<input type="text" id="store_contact_mobile" class="spinbox-input form-control input-mask-phone" maxlength="11" placeholder="(999)-999-9999"><div class="spinbox-buttons input-group-btn"><button type="button" class="btn spinbox-up btn-sm btn-success" onclick="div_add_field(\'store_contact_mobile\', \'input-mask-phone\')"><i class="icon-only  ace-icon ace-icon fa fa-plus bigger-110"></i></button></div>');
                $("#store_contact_email").html('<input type="text" id="store_contact_email" onkeyup="" class="spinbox-input form-control email-address" placeholder="sample@yahoo.com"><div class="spinbox-buttons input-group-btn"><button type="button" class="btn spinbox-up btn-sm btn-success" onclick="div_add_field(\'store_contact_email\', \'emailaddress\')"><i class="icon-only  ace-icon ace-icon fa fa-plus bigger-110"></i></button></div>');
                $("#store_contact_tele").html('<input type="text" id="store_contact_tele" class="spinbox-input form-control input-mask-tele" placeholder="(99)-999-9999"> <div class="spinbox-buttons input-group-btn"><button type="button" class="btn spinbox-up btn-sm btn-success" onclick="div_add_field(\'store_contact_tele\', \'input-mask-tele\')"><i class="icon-only  ace-icon ace-icon fa fa-plus bigger-110"></i></button></div>');
                autotrapfields();
            }
        })
    }

    function savetradename_update(storeid) {
        $("#btn_modal_new_store").button('loading');
        var e = 0;
        $(".text_new_trade").each(function(){
            if($(this).val() == ""){
                e++;
                $(this).css("border-color","#f2a696");
            }else{
                $(this).css("border-color","#D5D5D5");
            }
        });
        var f = 0;
         $("#div_Trade_contact_person_list .save_this_div").each(function(){
            f++;
        });
        if(e == 0 && f >= 1){
            var tradename = $("#txtNewTradeName").val();
            var companyid = $("#txtTradeCompanyID").val();
            var merchant_code = $("#txtTradeMerchantID").val();
            var BillSetup = $("#txtTradeBillingSetup").val();
            var BillerID = $("#txtTradeBillID").val();
            $.ajax({
                type: 'POST',
                url: 'mainclass.php',
                data: 'tradename=' + tradename + '&companyid=' + companyid + '&id=' + storeid + '&merchant_code=' + merchant_code + '&BillSetup=' + BillSetup + '&BillerID=' + BillerID + '&form=savetradename_update',
                success: function(data){
                    $("#btn_modal_new_store").button('reset');
                    var arr = data.split("|");
                    if(arr[0] == "1"){
                        setTimeout(function(){
                            showmodal("alert", "Successfully Updated!", "fncLoadTradeList", null, "", null, "0");
                        }, 500)
                        sendprofilepic_trade(arr[1], arr[2])
                    }else{
                        setTimeout(function(){
                            showmodal("alert", "Failed to update.", "", null, "", null, "1");
                        }, 500)
                    }
                    $("#modal_newtradename").modal("hide");
                    $(".text_new_trade").val("");
                    $(".text_new_trade").css("border-color","#D5D5D5");
                }
            })
        }else{
            $("#btn_modal_new_store").button('reset');
            if(e >= 1){
                setTimeout(function(){
                    showmodal("alert", "Fill all required fields!", "", null, "", null, "1");
                }, 500)
            }else{
                setTimeout(function(){
                    showmodal("alert", "You need to include atleast 1 contact person.", "", null, "", null, "1");
                }, 500)
            }
            $('.text_new_trade').each(function() {
                if(this.value === ''){
                    this.focus();
                    return false;
                }
            });
        }
    }

    function fncSelectTradeProfile(companyID, tradeID){
        $.ajax({
            type: 'POST',
            url: 'include/class.php',
            data: 'companyID=' + companyID + '&tradeID=' + tradeID + '&form=mdlTradeInfo',
            success:function(data){
                var arr = data.split("|");
                $("#txtTradeID").val(tradeID);
                $("#txtCompanyID").val(companyID);
                $("#txtTradeName").val(arr[0]);
                $("#txtCompanyName").val(arr[1]);
                $("#txtIndustryID").val(arr[2]);
                $("#txtIndustry").val(arr[3]);
                $("#txtMerchantCode").val(arr[4]);
                $("#txtAddress").val(arr[5]);
                $("#imgTenant").attr("src", arr[6]);
                $("#imgTenant").attr("alt", arr[0]);
                $("#txtTenantBillingSetup").val(arr[7]);
            }
        })
        $.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'tradeID=' + tradeID + '&form=fncgetTradeContact',
            success: function(data){
                if(data != ""){
                    $("#div_inquiry_contact_person").html(data);
                }else{
                    $("#div_inquiry_contact_person").html('<center><img src="assets/images/network.png" style="margin: 20px;height: 120px; width: 120px;"><h3>No contact persons yet.</h3></center>');
                }
            }
        })
        // $.ajax({
        //     type: 'POST',
        //     url: 'mainclass.php',
        //     data: 'tradeID=' + tradeID + '&form=fncgetBillInformation',
        //     success: function(data){
        //         var arr = data.split("|");
        //         $("#txtTenantBillingSetup").val(arr[0]);
        //         $("#txtTenantBillID").val(arr[1]);
        //         $("#txtTenantBillAccount").val(arr[2]);
        //         $("#txtTenantBillTele").val(arr[3]);
        //         $("#txtTenantBillPerma").val(arr[4]);
        //         $("#txtTenantBillCurr").val(arr[5]);
        //         $("#txtTenantBillBillingAddress").val(arr[6]);
        //         $("#txtTenantBillMobi").val(arr[7])
        //         $("#txtTenantBillEmail").val(arr[8])
        //         $.ajax({
        //             type: 'POST',
        //             url: 'mainclass.php',
        //             data: 'id=' + arr[1] + '&ViewType=Inquiry&ViewOnly=ViewOnly&form=load_updatecompany_contactpersons',
        //             success: function(data) {
        //                 if(data != ""){
        //                     $("#div_TenantBillerContact").html(data);
        //                 }else{
        //                     $("#div_TenantBillerContact").html('<center><img src="assets/images/network.png" style="margin: 20px;height: 120px; width: 120px;"><h3>No contact persons yet.</h3></center>');
        //                 }
        //             }
        //         })
        //     }
        // })
        $("#mdlTradeList").modal("hide");
    }

    function fncAddNewTrade(){
        $("#btn_modal_new_store").button('reset');
        $("#posting_profilepic_trade").html('<div style="display: none;"><input type="text" id="trade_hidden_companyID2" name="companyID"><input type="text" id="trade_hidden_tradeID" name="tradeID"></div><input id="file_upload_trade" name="attachment_profilepic" class="form-control upload" type="file" onchange="showimgtrade();" accept="image/*"/>');
        $('#file_upload_trade').ace_file_input({
            no_file:'No File ...',
            btn_choose:'Choose',
            btn_change:'Change',
            droppable:false,
            onchange:null,
            thumbnail:false
        });
        $("#modal_newtradename").modal("show");
        $("#hdrStoreProfile").text("New <?php if(SysLeaseSetup('softwaretype') == '0'){ echo "Store"; }else if(SysLeaseSetup('softwaretype') == '5'){ echo "Buyer"; }else{ echo "Tenant"; } ?> Profile")
        $("#btn-trade-save-contact-person").attr("onclick", "fncAddTradeContact()");
        $(".text_new_trade").val("");
        $("#txtTradeMerchantID").val("");
        $("#txtTradeCompanyID").val("");
        $("#txtTradeCompanyName").val("");
        $(".text_new_trade").css("border-color","#D5D5D5");
        $("#txtTradeBillingSetup").val("Individual");
        $("#trade_hidden_companyID2").val("");
        $("#trade_hidden_tradeID").val("");
        $("#imgTradePicture").attr("src", "assets/images/noimage5.png");
        $("#file_upload_trade").val("");
        $("#txtTradeBillID").val("");
        $("#txtTradeBillAccount").val("");
        $("#txtTradeBillingSetup").val("Individual");
        $("#txtTradeBillTele").val("");
        $("#txtTradeBillMobi").val("");
        $("#txtTradeBillEmail").val("");
        $("#txtTradeBillPerma").val("");
        $("#txtTradeBillCurr").val("");
        $("#txtTradeBillBillingAddress").val("");
        $("#chkTradeContactStatActive").prop("checked", true);
        $("#div_Trade_contact_person_list").html("");
        $("#btn_modal_new_store").attr("onclick", "savetradename()");
        $("#btn_new_store").attr("onclick", "savetradename()");
        $("#txtNewTradeName").attr("onchange", "GenerateMerchantCode(this.value, \"addnew\")");
        $("#store_contact_mobile").html('<input type="text" id="store_contact_mobile" class="spinbox-input form-control input-mask-phone" maxlength="11" placeholder="(999)-999-9999"><div class="spinbox-buttons input-group-btn"><button type="button" class="btn spinbox-up btn-sm btn-success" onclick="div_add_field(\'store_contact_mobile\', \'input-mask-phone\')"><i class="icon-only  ace-icon ace-icon fa fa-plus bigger-110"></i></button></div>');
        $("#store_contact_email").html('<input type="text" id="store_contact_email" onkeyup="" class="spinbox-input form-control email-address" placeholder="sample@yahoo.com"><div class="spinbox-buttons input-group-btn"><button type="button" class="btn spinbox-up btn-sm btn-success" onclick="div_add_field(\'store_contact_email\', \'emailaddress\')"><i class="icon-only  ace-icon ace-icon fa fa-plus bigger-110"></i></button></div>');
        $("#store_contact_tele").html('<input type="text" id="store_contact_tele" class="spinbox-input form-control input-mask-tele" placeholder="(99)-999-9999"> <div class="spinbox-buttons input-group-btn"><button type="button" class="btn spinbox-up btn-sm btn-success" onclick="div_add_field(\'store_contact_tele\', \'input-mask-tele\')"><i class="icon-only  ace-icon ace-icon fa fa-plus bigger-110"></i></button></div>');
        autotrapfields();
        loadmodalcompanyposition();
    }

    function savetradename(){
        $("#btn_modal_new_store").button('loading');
        var e = 0;
        $(".text_new_trade").each(function(){
            if($(this).val() == ""){
                e++;
                $(this).css("border-color","#f2a696");
            }else{
                $(this).css("border-color","#D5D5D5");
            }
        });
        var f = 0;
         $("#div_Trade_contact_person_list .save_this_div").each(function(){
            f++;
        });
        if(e == 0 && f >= 1){
            var tradename = $("#txtNewTradeName").val();
            var companyname = $("#txtTradeCompanyName").val();
            var companyid = $("#txtTradeCompanyID").val();
            var merchant_code = $("#txtTradeMerchantID").val();
            var BillSetup = $("#txtTradeBillingSetup").val();
            var BillerID = $("#txtTradeBillID").val();
            $.ajax({
                type: 'POST',
                url: 'mainclass.php',
                data: 'tradename=' + tradename + '&companyname=' + companyname + '&companyid=' + companyid + '&merchant_code=' + merchant_code + '&BillSetup=' + BillSetup + '&BillerID=' + BillerID + '&form=savetradename',
                success: function(data){
                    var arr = data.split("|");
                    $("#btn_modal_new_store").button('reset');
                    sendprofilepic_trade(arr[1], arr[2])
                    savetradecontactpersons(arr[1], arr[2]);
                    if(arr[0] == "1"){
                        setTimeout(function(){
                            showmodal("alert", "Successfully added!", "fncLoadTradeList", null, "", null, "0");
                        }, 500)
                        $("#modal_newtradename").modal("hide");
                        $(".text_new_trade").val("");
                        $(".text_new_trade").css("border-color","#D5D5D5");
                    }else if(arr[0] == "2"){
                        setTimeout(function(){
                            showmodal("alert", "Merchant code is already used.", "fncLoadTradeList", null, "", null, "1");
                        }, 500)
                    }else{
                        setTimeout(function(){
                            showmodal("alert", "Failed to save store profile.", "fncLoadTradeList", null, "", null, "1");
                        }, 500)
                    }
                }
            });
        }else{
            $("#btn_modal_new_store").button('reset');
            if(e >= 1){
                setTimeout(function(){
                    showmodal("alert", "Fill all required fields!", "", null, "", null, "1");
                }, 500)
            }else{
                setTimeout(function(){
                    showmodal("alert", "You need to include atleast 1 contact person.", "", null, "", null, "1");
                }, 500)
            }
            $('.text_new_trade').each(function(){
                if(this.value === ''){
                    this.focus();
                    return false;
                }
            });
        }
    }

    function showimgtrade(){
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("file_upload_trade").files[0]);
        oFReader.onload = function (oFREvent) {
            document.getElementById("imgTradePicture").src = oFREvent.target.result;
        };
    }

    function sendprofilepic_trade(companyID, tradeID){
        $("#trade_hidden_companyID2").val(companyID);
        $("#trade_hidden_tradeID").val(tradeID);
        var data = new FormData($('#posting_profilepic_trade')[0]);
        $.ajax({
            type: 'POST',
            url: 'Uploads/upload_app_trade.php',
            data: data,
            mimeType: 'multipart/form-data',
            contentType: false,
            cache: false,
            processData: false,
            success:function(data){
                
            }
        });
    }

    function GenerateMerchantCode(CompanyName, Action){
        var Merchant_Code = CompanyName.replace(/[^\w\s]/gi, '').replace(/[_]/gi, '').replace(/[aeiou0123456789]/gi, '').substring(0,3).toUpperCase();
        <?php if(SysLeaseSetup('automerchantcode') == "1"){ ?>
            $.ajax({
                type: 'POST',
                url: 'mainclass.php',
                data: 'form=GenerateMerchantCode',
                success:function(data){
                    if(Action == "addnew"){
                        $("#txtTradeMerchantID").val(Merchant_Code+data);
                    }else{
                        var arr = $("#txtTradeMerchantID").val().split("-");
                        if(arr[1] == "" || arr[1] == "UNDEFINED"){
                            $("#txtTradeMerchantID").val(Merchant_Code+data);
                        }else{
                            $("#txtTradeMerchantID").val(Merchant_Code+"-"+arr[1]);
                        }
                    }
                }
            })
        <?php }else{ ?>
            $("#txtTradeMerchantID").val(Merchant_Code);
        <?php } ?>
    }

    function fncOpenBillingAccountList(){
        $("#mdlBillingAccountList").modal("show");
        $("#txtBillAccountListPage").val("1");
        fncLoadBillingAccountList();
    }

    function fncLoadBillingAccountList(){
        var page = $("#txtBillAccountListPage").val();
        var key = $("#txtSearchBillProfile").val();
        $.ajax({
            type: 'POST',
            url: 'include/class.php',
            data: 'key=' + key + '&page=' + page + '&form=fncLoadBillingAccountList',
            success: function(data){
                if(data != ""){
                    $("#tbodyBillAccountList").html(data);
                }else{
                    $("#tbodyBillAccountList").html("<tr><td colspan='4' style='text-align: center;'>No Data Found...</td></tr>");
                }
            }, complete: function(){
                fncBillProfileEntries();
                fncBillProfilePagination();
            }
        })
    }

    function fncBillProfileEntries(){
        var page = $("#txtBillAccountListPage").val();
        var key = $("#txtSearchBillProfile").val();
        $.ajax({
            type: 'POST',
            url: 'include/class.php',
            data: 'txtSearchBillProfile=' + txtSearchBillProfile + '&page=' + page  + '&form=fncBillProfileEntries',
            success: function(data){
                $("#txtBillAccountEntries").text(data);
            }
        });
    }

    function fncBillProfilePagination(){
        var page = $("#txtBillAccountListPage").val();
        var key = $("#txtSearchBillProfile").val();
        $.ajax({
            type: 'POST',
            url: 'include/class.php',
            data: 'page=' + page + '&txtSearchBillProfile=' + txtSearchBillProfile + '&form=fncBillProfilePagination',
            success: function(data){
                $("#ulPaginationBillAccount").html(data);
            }
        });
    }

    function fncBillProfilebtnPagination(page, pagenums){
        $(".pgnum").removeClass("active");
        $("#pg" + pagenums).addClass("active");
        $("#txtBillAccountListPage").val(page);
        fncLoadBillingAccountList();
    }

    function fncclickBillProfile(BillerID){
        $.ajax({
            type: 'POST',
            url: 'include/class.php',
            data: 'BillerID=' + BillerID + '&form=fncclickBillProfile',
            success: function(data){
                var arr = data.split("|");
                $("#txtTradeBillID").val(BillerID);
                $("#txtTradeBillAccount").val(arr[0]);
                $("#txtTradeBillTele").val(arr[1]);
                $("#txtTradeBillPerma").val(arr[2]);
                $("#txtTradeBillCurr").val(arr[3]);
                $("#txtTradeBillBillingAddress").val(arr[4]);
                $("#txtTradeBillMobi").val(arr[5]);
                $("#txtTradeBillEmail").val(arr[6]);

                $("#txtTenantBillID").val(BillerID);
                $("#txtTenantBillAccount").val(arr[0]);
                $("#txtTenantBillTele").val(arr[1]);
                $("#txtTenantBillPerma").val(arr[2]);
                $("#txtTenantBillCurr").val(arr[3]);
                $("#txtTenantBillBillingAddress").val(arr[4]);
                $("#txtTenantBillMobi").val(arr[5]);
                $("#txtTenantBillEmail").val(arr[6]);
            }, complete: function(){
                $("#mdlBillingAccountList").modal("hide");
            }
        })
        $.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'id=' + BillerID + '&ViewOnly=ViewOnly&form=load_updatecompany_contactpersons',
            success: function(data) {
                if(data != ""){
                    $("#div_TradeBillerContact").html(data);
                }else{
                    $("#div_TradeBillerContact").html('<center><img src="assets/images/network.png" style="margin: 20px;height: 120px; width: 120px;"><h3>No contact persons yet.</h3></center>');
                }
            }
        })
        $.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'id=' + BillerID + '&ViewType=Inquiry&ViewOnly=ViewOnly&form=load_updatecompany_contactpersons',
            success: function(data) {
                if(data != ""){
                    $("#div_TenantBillerContact").html(data);
                }else{
                    $("#div_TenantBillerContact").html('<center><img src="assets/images/network.png" style="margin: 20px;height: 120px; width: 120px;"><h3>No contact persons yet.</h3></center>');
                }
            }
        })
    }

    function fncAddTradeContact(){
        var aff = "";
        var contact_firstname = $("#txtTradeFName").val();
        var contact_middlename = $("#txtTradeMName").val();
        var contact_lastname = $("#txtTradeLName").val();
        var contact_designation = $("#txtTradePosition").val();
        var contact_address = $("#txtTradeConAddress").val();
        var AsPrimary = "";
        $("#chkTradeAsPrimary").each(function(){
            if($(this).is(":checked")){
                isPrimary = "1";
                AsPrimary = "<span class='fa fa-star orange pull-left'></span><br>";
                if($(".save_this_div span").hasClass("fa fa-star")){
                    $(".fa-star").remove();
                    $(".isPrimary").val("0");
                }
            }else{
                AsPrimary = "";
                isPrimary = "0";
            }
        })
        var isActive = "";
        var isActive2 = "";
        $(".rdTradeContactStat").each(function(){
            if($(this).is(":checked")){
                if($(this).val() == "Active"){
                    isActive = "info";
                    isActive2 = "1";
                }else{
                    isActive = "warning";
                    isActive2 = "0";
                }
            }
        })
        var store_contact_email = "";
        $("#store_contact_email input").each(function(){
            var value = $(this).val();
            if(!value.match(/^\s*$/)){
                store_contact_email += "<p style='font-size: 10px; font-weight: normal;margin: 0px !important;font-style: underline;' class='trade_contact_person_emailadd'>" + value + "</p>";
            }
        });
        var store_contact_mobile = "";
        $("#store_contact_mobile input").each(function(){
            var value = $(this).val();
            if(!value.match(/^\s*$/)){
                store_contact_mobile += "<p style='font-size: 12px; font-weight: normal;font-style: italic;margin: 0px !important;' class='trade_contact_person_mobno'>" + value + "</p>";
            }
        });
        var store_contact_tele = "";
        $("#store_contact_tele input").each(function(){
            var value = $(this).val();
            if(!value.match(/^\s*$/)){
                store_contact_tele += "<p style='font-size: 12px; font-weight: normal;font-style: italic;margin: 0px !important;' class='trade_contact_person_telno'>" + value + "</p>";
            }
        });
        var i = 0;
        $("div .div_trade_contact_person").each(function(){
            i++;
        });
        var idimg = "tradeimgaccount_"+i;
        var fileimg = "tradecon_upload"+i;
        var fileform = "posting_tradeconpic"+i;
        aff += "<div class='col-md-4'><div class='alert alert-"+ isActive +" div_trade_contact_person save_this_div'>"+ AsPrimary +"<center><input type='hidden' class='isPrimary' value='"+ isPrimary +"'><input type='hidden' class='isActive' value='"+ isActive2 +"'><div class='image'><img class='img-thumbnail imageName form-control' src='assets/images/noimage5.png' id='"+idimg+"' style='border: 2px solid #bdc3c7; margin-bottom: 8px;height: 160px;width:90%;'></div><form name='posting_tradeconpic' id='"+fileform+"' class='posting_tradeconpic'><div style='display:none;'><input type='text' name='txtcon_id' class='txtcon_id'><input type='text' name='txtcon_trade' class='txtcon_trade'><input type='text' name='txtcon_compid' class='txtcon_compid'></div><input id='"+fileimg+"' name='attachment_profilepic' class='form-control upload_app_req' type='file' onchange='showimg2(\""+idimg+"\",\""+fileimg+"\");' /></form></center><label style='font-size: 14px; font-weight: bold;margin: 0px !important;' class='trade_contact_person_firstname'>"+contact_firstname+" </label>&nbsp;<label style='font-size: 14px; font-weight: bold;margin: 0px !important;' class='trade_contact_person_middlename'>"+contact_middlename+"</label>&nbsp;<label style='font-size: 14px; font-weight: bold;margin: 0px !important;' class='trade_contact_person_lastname'>"+contact_lastname+"</label><p style='font-size: 14px; font-weight: normal;margin: 0px !important;' class='trade_contact_person_designation'>"+contact_designation+"</p><p style='font-size: 10px; font-weight: normal;margin: 0px !important;' class='trade_address_person'>"+contact_address+"</p>"+store_contact_email+""+store_contact_mobile+""+store_contact_tele+"</div></div>";
        if((contact_firstname != "" && !contact_firstname.match(/^\s*$/)) && (contact_lastname != "" && !contact_lastname.match(/^\s*$/)) && (contact_designation != "" && !contact_designation.match(/^\s*$/)) && (contact_address != "" && !contact_address.match(/^\s*$/)) && (store_contact_email != "" || store_contact_mobile != "" || store_contact_tele != "") ){
            $( aff ).appendTo( "#div_Trade_contact_person_list" );
            $("#txtTradeFName").val("");
            $("#txtTradeMName").val("");
            $("#txtTradeLName").val("");
            $("#txtTradePosition").val("");
            $("#txtTradeConAddress").val("");
            $("#chkTradeAsPrimary").prop("checked", false);
            $("#chkTradeContactStatActive").prop("checked", true);
            var store_contact_email = "store_contact_email";
            var person_email = "emailaddress";
            var store_contact_mobile = "store_contact_mobile";
            var person_mobile = "input-mask-phone";
            var store_contact_tele = "store_contact_tele";
            var person_tele = "input-mask-tele";
            $("#store_contact_email").html("<div class='input-group'><input type='text' class='spinbox-input form-control' placeholder='sample@yahoo.com'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success' onclick='div_add_field(\""+store_contact_email+"\", \""+person_email+"\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>");
            $("#store_contact_mobile").html("<div class='input-group'><input type='text' class='spinbox-input form-control input-mask-phone' maxlength='11' placeholder='(999)-999-9999'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success' onclick='div_add_field(\""+store_contact_mobile+"\", \""+person_mobile+"\")'> <i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>");
            $("#store_contact_tele").html("<div class='input-group'><input type='text' class='spinbox-input form-control input-mask-tele'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success' onclick='div_add_field(\""+store_contact_tele+"\", \""+person_tele+"\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>");
            $("#store_contact_email input").attr("style", "border-color:#D5D5D5 !important");
            $("#store_contact_mobile input").attr("style", "border-color:#D5D5D5 !important");
            $("#store_contact_tele input").attr("style", "border-color:#D5D5D5 !important");
            $('.trade_save_contact_per').each(function(){
                if($(this).val() == ""){
                    $(this).attr("style", "border-color:#D5D5D5 !important");
                }
            });
        }else{
            if(store_contact_email == "" && store_contact_mobile == "" && store_contact_tele == ""){
                setTimeout(function(){
                    showmodal("alert", "Please enter atleast one contact information, and fill other required information.", "", null, "", null, "1");
                }, 1000)
                $("#store_contact_email input").attr("style", "border-color:#f2a696 !important");
                $("#store_contact_mobile input").attr("style", "border-color:#f2a696 !important");
                $("#store_contact_tele input").attr("style", "border-color:#f2a696 !important");
                $(".trade_save_contact_per").each(function(){
                    if ( $(this).val() == ""){
                        $(this).attr("style", "border-color:#f2a696 !important");
                    }
                });
                $('.trade_save_contact_per').each(function(){
                    if(this.value === ''){
                        this.focus();
                        return false;
                    }
                });
            }else{
                setTimeout(function(){
                    showmodal("alert", "Fill all required fields.", "", null, "", null, "1");
                }, 1000)
                $('.trade_save_contact_per').each(function(){
                    if($(this).val() ==  ""){
                        $(this).attr("style", "border-color:#f2a696 !important");
                    }
                });
                $('.trade_save_contact_per').each(function(){
                    if(this.value === ''){
                        this.focus();
                        return false;
                    }
                });
            }
        }
        autotrapfields();
    }

    function fncAddTradeContact_Update(TradeID){
        var aff = "";
        var contact_firstname = $("#txtTradeFName").val();
        var contact_middlename = $("#txtTradeMName").val();
        var contact_lastname = $("#txtTradeLName").val();
        var contact_designation = $("#txtTradePosition").val();
        var contact_address = $("#txtTradeConAddress").val();
        var store_contact_email = "";
        $("#store_contact_email input").each(function(){
            var value = $(this).val();
            if(!value.match(/^\s*$/)){
                store_contact_email += value + "|";
            }
        });
        var store_contact_mobile = "";
        $("#store_contact_mobile input").each(function(){
            var value = $(this).val();
            if(!value.match(/^\s*$/)){
                store_contact_mobile += value + "|";
            }
        });
        var store_contact_tele = "";
        $("#store_contact_tele input").each(function(){
            var value = $(this).val();
            if(!value.match(/^\s*$/)){
                store_contact_tele += value + "|";
            }
        });
        var i = 0;
        $("div .div_contact_person").each(function(){
            i++;
        });
        var idimg = "imgaccount_"+i;
        var fileimg = "file_upload"+i;
        var fileform = "posting_profilepic"+i;
        var store_contact_email_a = "";
        $("#store_contact_email input").each(function(){
            var value = $(this).val();
            if(!value.match(/^\s*$/)){
                store_contact_email_a += "<p style='font-size: 10px; font-weight: normal;margin: 0px !important;font-style: underline;' class='contact_person_emailadd'>" + value + "</p>";
            }
        });
        var div_add_contact_person_mobile_a = "";
        $("#store_contact_mobile input").each(function(){
            var value = $(this).val();
            if(!value.match(/^\s*$/)){
                div_add_contact_person_mobile_a += "<p style='font-size: 12px; font-weight: normal;font-style: italic;margin: 0px !important;' class='contact_person_mobno'>" + value + "</p>";
            }
        });
        var store_contact_tele_a = "";
        $("#store_contact_tele input").each(function(){
            var value = $(this).val();
            if(!value.match(/^\s*$/)){
                store_contact_tele_a += "<p style='font-size: 12px; font-weight: normal;font-style: italic;margin: 0px !important;' class='contact_person_telno'>" + value + "</p>";
            }
        });
        var AsPrimary = "";
        $("#chkTradeAsPrimary").each(function(){
            if($(this).is(":checked")){
                isPrimary = "1";
                AsPrimary = "<span class='fa fa-star orange pull-left'></span><br>";
                if($(".save_this_div span").hasClass("fa fa-star")){
                    $(".fa-star").remove();
                    $(".isPrimary").val("0");
                }
            }else{
                AsPrimary = "";
                isPrimary = "0";
            }
        })
        var isActive = "";
        var isActive2 = "";
        $(".rdTradeContactStat").each(function(){
            if($(this).is(":checked")){
                if($(this).val() == "Active"){
                    isActive = "info";
                    isActive2 = "1";
                }else{
                    isActive = "warning";
                    isActive2 = "0";
                }
            }
        })
        if((contact_firstname != "" && !contact_firstname.match(/^\s*$/)) && (contact_lastname != "" && !contact_lastname.match(/^\s*$/)) && (contact_designation != "" && !contact_designation.match(/^\s*$/)) && (contact_address != "" && !contact_address.match(/^\s*$/)) && (store_contact_email != "" || store_contact_mobile != "" || store_contact_tele != "") ){
            $.ajax({
                type: 'POST',
                url: 'mainclass.php',
                data: 'id=' + TradeID + '&contact_firstname=' + contact_firstname + '&contact_middlename=' + contact_middlename + '&contact_lastname=' + contact_lastname + '&contact_designation=' + contact_designation + '&contact_address=' + contact_address + '&person_email=' + store_contact_email + '&person_mobile=' + store_contact_mobile + '&person_tele=' + store_contact_tele + '&isPrimary=' + isPrimary + '&isActive=' + isActive2 + '&form=addtradecontactperson_update',
                success: function(data){
                    var arr = data.split("|");
                    if(arr[0] == "1"){
                        aff += "<div class='col-md-4'><div class='alert alert-"+ isActive +" div_contact_person save_this_div' id='contact_"+arr[1]+"'><div class='tools tools-left in'>"+ AsPrimary +"<a href='#' title='Edit Photo' class='btnedit' style='float:right;margin-bottom:8px;margin-top:8px;' onclick='edittradecontactperson(\""+arr[1]+"\", \""+TradeID+"\")'><i class='ace-icon fa fa-pencil'></i></a><a href='#' title='Remove Photo' class='btndelete' style='float:right;margin-right:5px;margin-bottom:8px;margin-top:8px;' onclick='removetradecontactperson(\""+arr[1]+"\")'><i class='ace-icon fa fa-times red'></i></a></div><center><div class='image'><img class='img-thumbnail imageName form-control' src='assets/images/noimage5.png' id='div_add_new_contact_per_edit' style='border: 2px solid #bdc3c7; margin-bottom: 8px;height: 160px;width:90%;'></div><form name='posting_profilepic_addnew_"+arr[1]+"' id='posting_profilepic_addnew_"+arr[1]+"' class='posting_profilepic'><div style='display:none;'><input type='text' name='contactID' id='txtcon_person_addnew_"+arr[1]+"' class='txtcon_person'><input type='text' name='companyID' id='txtcon_company_addnew_"+arr[1]+"' class='txtcon_company'></div><input id='posting_profilepic_addnew_input_"+arr[1]+"' name='file_upload_trade_update' class='form-control upload_app_req' type='file' onchange='showimg3(\"div_add_new_contact_per_edit\",\"posting_profilepic_addnew_input_"+arr[1]+"\", \""+arr[1]+"\", \""+TradeID+"\");' /></form></center><label style='font-size: 14px; font-weight: bold;margin: 0px !important;' class='contact_person_firstname'>"+contact_firstname+" </label>&nbsp;<label style='font-size: 14px; font-weight: bold;margin: 0px !important;' class='contact_person_middlename'>"+contact_middlename+"</label>&nbsp;<label style='font-size: 14px; font-weight: bold;margin: 0px !important;' class='contact_person_lastname'>"+contact_lastname+"</label><p style='font-size: 14px; font-weight: normal;margin: 0px !important;' class='contact_person_designation'>"+contact_designation+"</p><p style='font-size: 10px; font-weight: normal;margin: 0px !important;' class='address_person'>"+contact_address+"</p>"+store_contact_email_a+""+div_add_contact_person_mobile_a+""+store_contact_tele_a+"</div></div>";
                        $("#txtTradeConAddress").attr("onclick", "loadaddressmodal(\"txtTradeConAddress\")");
                        $("#txtTradeConAddress").attr("onkeyup", "loadaddressmodal(\"txtTradeConAddress\")");
                        $( aff ).appendTo( "#div_Trade_contact_person_list" );
                        $("#txtTradeConAddress").css("background-color", "white !important");
                        $("#txtTradeFName").val("");
                        $("#txtTradeMName").val("");
                        $("#txtTradeMName").val("");
                        $("#txtTradePosition").val("");
                        $("#txtTradeConAddress").val("");
                        var store_contact_email = "store_contact_email";
                        var person_email = "emailaddress";
                        var store_contact_mobile = "store_contact_mobile";
                        var person_mobile = "input-mask-phone";
                        var store_contact_tele = "store_contact_tele";
                        var person_tele = "input-mask-tele";
                        $("#store_contact_email").html("<div class='input-group'><input type='text' class='spinbox-input form-control email-address'  placeholder='sample@yahoo.com'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success' onclick='div_add_field(\""+store_contact_email+"\", \""+person_email+"\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>");
                        $("#store_contact_mobile").html("<div class='input-group'><input type='text' class='spinbox-input form-control input-mask-phone' maxlength='11' placeholder='(999)-999-9999'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success' onclick='div_add_field(\""+store_contact_mobile+"\", \""+person_mobile+"\")'> <i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>");
                        $("#store_contact_tele").html("<div class='input-group'><input type='text' class='spinbox-input form-control input-mask-tele' placeholder='(99)-999-9999'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success' onclick='div_add_field(\""+store_contact_tele+"\", \""+person_tele+"\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>");
                        $("#store_contact_email input").attr("style", "border-color:#D5D5D5 !important");
                        $("#store_contact_mobile input").attr("style", "border-color:#D5D5D5 !important");
                        $("#store_contact_tele input").attr("style", "border-color:#D5D5D5 !important");
                        $('.trade_save_contact_per').each(function() {
                            if($(this).val() == ""){
                                $(this).attr("style", "border-color:#D5D5D5 !important;background-color:white !important;");
                            }
                        });
                    }else{
                        setTimeout(function(){
                            showmodal("alert", "This contact person is already existing.", "", null, "", null, "1");
                        }, 1000)
                        $("#store_contact_email input").attr("style", "border-color:#f2a696 !important");
                        $("#store_contact_mobile input").attr("style", "border-color:#f2a696 !important");
                        $("#store_contact_tele input").attr("style", "border-color:#f2a696 !important");
                        $('.trade_save_contact_per').each(function(){
                            $(this).attr("style", "border-color:#f2a696 !important;background-color:white !important;");
                        });
                        $('.trade_save_contact_per').each(function(){
                            this.focus();
                            return false;
                        });
                    }
                }, complete: function(){
                    autotrapfields();
                }
            })
        }else{
            if(div_add_contact_person_email == "" && store_contact_mobile == "" && store_contact_tele == ""){
                setTimeout(function(){
                    showmodal("alert", "Please enter atleast one contact information, and fill other required information.", "", null, "", null, "1");
                }, 1000)
                $("#div_add_contact_person_email input").attr("style", "border-color:#f2a696 !important");
                $("#store_contact_mobile input").attr("style", "border-color:#f2a696 !important");
                $("#store_contact_tele input").attr("style", "border-color:#f2a696 !important");
                $(".trade_save_contact_per").each(function(){
                    if($(this).val() == ""){
                        $(this).attr("style", "border-color:#f2a696 !important;background-color:white !important;");
                    }
                });
                $('.trade_save_contact_per').each(function(){
                    if(this.value === ''){
                        this.focus();
                        return false;
                    }
                });
            }else{
                setTimeout(function(){
                    showmodal("alert", "Fill all required fields.", "", null, "", null, "1");
                }, 1000)
                $('.trade_save_contact_per').each(function(){
                    if($(this).val() ==  ""){
                        $(this).attr("style", "border-color:#f2a696 !important;background-color:white !important;");
                    }
                });
                $('.trade_save_contact_per').each(function(){
                    if(this.value === ''){
                        this.focus();
                        return false;
                    }
                });
            }
        }
    }

    function savetradecontactpersons(CompID, TradeID){
        var i = 0;
        var e = 0;
        $("#div_Trade_contact_person_list .div_trade_contact_person").each(function(){
            i++;
        });
        if(i == 0){
            $("#modal_new_company").modal("hide");
            $("#div_Trade_contact_person_list").html("");
            loadcompanylist();
        }else{
            $("#div_Trade_contact_person_list .div_trade_contact_person").each(function(){
                var isPrimary = $(this).find(".isPrimary");
                var isActive = $(this).find(".isActive");
                var firstname = $(this).find(".trade_contact_person_firstname");
                var middlename = $(this).find(".trade_contact_person_middlename");
                var lastname = $(this).find(".trade_contact_person_lastname");
                var designation = $(this).find(".trade_contact_person_designation");
                var address = $(this).find(".trade_address_person");
                var email = $(this).find(".trade_contact_person_emailadd");
                var mobile = $(this).find(".trade_contact_person_mobno");
                var tele = $(this).find(".trade_contact_person_telno");
                var form = $(this).find(".posting_tradeconpic");
                var isPrimary_val = isPrimary.val();
                var isActive_val = isActive.val();
                var firstname_val = firstname.text();
                var middlename_val = middlename.text();
                var lastname_val = lastname.text();
                var designation_val = designation.text();
                var address_val = address.text();
                var formselected = form.attr("id");
                var email_string = "";
                var mobile_string = "";
                var tele_string = ""
                for(var a=0; a<=email.length-1; a++){
                    email_string +=$( email[a]).text() + "|";
                }
                for(var b=0; b<=mobile.length-1; b++){
                    mobile_string +=$( mobile[b]).text() + "|";
                }
                for(var c=0; c<=tele.length-1; c++){
                    tele_string += $(tele[c]).text() + "|";
                }
                $.ajax({
                    type: 'POST',
                    url: 'mainclass.php',
                    data: 'id=' + TradeID + '&firstname_val=' + firstname_val + '&middlename_val=' + middlename_val + '&lastname_val=' + lastname_val + '&designation_val=' + designation_val + '&address_val=' + address_val + '&email_string=' + email_string + '&mobile_string=' + mobile_string + '&tele_string=' + tele_string + '&isPrimary=' + isPrimary_val + '&isActive=' + isActive_val + '&form=savetradecontactpersons',
                    success: function(data){
                        e++;
                        sendtradecontactpic(data, formselected, TradeID, i, e, CompID);
                    }
                })
            });
        }
    }

    function sendtradecontactpic(contactID, form, TradeID, i, e, CompID){
        $(".txtcon_id").val(contactID);
        $(".txtcon_trade").val(TradeID);
        $(".txtcon_compid").val(CompID)
        var data = new FormData($('#'+form)[0]);
        $.ajax({
            type: 'POST',
            url: 'Uploads/upload_trade_contact.php',
            data: data,
            mimeType: 'multipart/form-data',
            contentType: false,
            cache: false,
            processData: false,
            success:function(data){
                
            }
        });
    }

    function removetradecontactperson(ContactID, TradeID){
        setTimeout(function(){
            showmodal("confirm", "Are you sure you want to delete this contact person?", "removetradecontactperson2", ContactID+"|"+TradeID+"|", "", null, "0");
        }, 1000)
    }

    function removetradecontactperson2(ContactID, TradeID){
        $.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'ContactID=' + ContactID + '&form=removetradecontactperson',
            success: function(data){
                if(data == 1){
                    $.ajax({
                        type: 'POST',
                        url: 'mainclass.php',
                        data: 'id=' + TradeID + '&form=load_updatecompany_contactpersons',
                        success: function(data) {
                            $("#div_content_contact_person_list").html(data);
                        }
                    })
                }
            }
        })
    }
</script>
