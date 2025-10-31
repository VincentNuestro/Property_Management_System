<div class="row form-group">
    <div class="col-xs-3"></div>
    <div class="col-xs-9">
        <div class="row form-group">
            <div class="col-md-2 col-xs-2 pull-right">
                <button href="#" class="btn btn-info btn-sm hide isadmin select-addnewcompany btn-round" style="width: 100% !important;" onclick="newcompany()">New Company</button>
            </div>
        </div>
    </div>
</div>
<div class="row form-group" style="margin-top: -20px;">
    <div class="col-xs-3">
        <div class="widget-box widget-color-blue2">
            <div class="widget-header">
                <h4 class="widget-title">Company List</h4>
            </div>
            <div class="widget-body">
                <div id="div_company_list_ol"></div>
                <div class="dd dd-draghandle cont" style="margin: 10px; height: 500px; overflow: hidden; outline: none;overflow-y: scroll;" tabindex="3">
                    <ol class="dd-list" id="companylist_ol"></ol>
                </div>
            </div>
        </div>        
    </div>
    <div class="col-xs-9">
        <div class="row form-group">
            <div class="col-md-3 col-xs-12">
                <div class="row form-group">
                    <img id="company_logo" class="img-responsive img-thumbnail" style="height: 200px; width: 100%;">
                </div>
            </div>
            <div class="col-md-9 col-xs-12">
                <h2 class="blue">
                    <span class="middle" id="txtcompany_name"></span>
                </h2>
                <div class="profile-user-info">
                    <div class="profile-info-row">
                        <div class="profile-info-name"> Industry </div>

                        <div class="profile-info-value">
                            <span id="txtcompany_industry"></span>
                        </div>
                    </div>
                    <div class="profile-info-row">
                        <div class="profile-info-name"> Address </div>

                        <div class="profile-info-value">
                            <span id="txtcompany_address"></span>
                        </div>
                    </div>
                    <?php if(SysLeaseSetup('isMultiCompSig') == '1'){ ?>
                    <div class="profile-info-row">
                        <div class="profile-info-name"> Signatories </div>

                        <div class="profile-info-value">
                            <span id="txtSignatories"></span>
                        </div>
                    </div>
                    <?php }else{ ?>
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Owner Name </div>

                            <div class="profile-info-value">
                                <span id="txtOwnerName"></span>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="profile-info-row">
                        <div class="profile-info-name"> &nbsp; </div>

                        <div class="profile-info-value">
                            <span></span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="col-md-4 col-xs-12">
                <div class="row form-group">
                    <div class="col-md-12"><h4 style="margin-top: 0px;margin-bottom: 0px;">Owner Name</h4></div>
                </div>
                <div class="row form-group">
                    <div class="col-md-4">First Name</div>
                    <div class="col-md-8"><input type="text" class="form-control input-sm" id="txtcompany_fname" readonly="" style="background-color: white !important;"></div>
                </div>
                <div class="row form-group">
                    <div class="col-md-4">Middle Name</div>
                    <div class="col-md-8"><input type="text" class="form-control input-sm" id="txtcompany_mname" readonly="" style="background-color: white !important;"></div>
                </div>
                <div class="row form-group">
                    <div class="col-md-4">Last Name</div>
                    <div class="col-md-8"><input type="text" class="form-control input-sm" id="txtcompany_lname" readonly="" style="background-color: white !important;"></div>
                </div>                
            </div> -->
        </div>
        <div class="row form-group">
            <div class="col-md-10">
                <h4 style="display: inline;color: #2679B5;"><i class="fa fa-filter bigger-110"></i>&nbsp;&nbsp;</h4>
                <h3 style="font-weight: bold;margin: 0px;color: #2679B5;display: inline;" class="hdrSysTenant">STORE LIST</h3>
            </div>
            <div class="col-md-2 col-xs-2">
                <a href="#" class="btn btn-info btn-sm hide isadmin select-addnewstore btnSysTenant btn-round" style="width: 100% !important;" onclick="addnewtradename()">New Store</a>
            </div>
        </div>
        <div class="row form-group">
            <div style="height: 22.1em;">
                <table class="table table-bordered table-hover fixTable">
                    <thead>
                        <tr>
                            <th style='width: 7%;'></th>
                            <th class="thSysTenant">Store Name</th>
                            <th style="width: 10%;">Merchant Code</th>
                        </tr>
                    </thead>
                    <tbody id="tbltradeinfolisthist"></tbody>
                </table>       
            </div>
        </div>
    </div>    
</div>

<div class="modal fade fade-scale" id="modal_newtradename" role="dialog" area-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title btnSysTenant" style="font-size: 18px;">Store Profile</h4>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-md-3">
                        <div class="row form-group">
                            <div class="col-md-12 col-xs-12">
                                <div class="image">
                                    <img class="img-thumbnail imageName form-control" src="assets/images/noimage5.png" id="imgtradeaccount" style="border: 2px solid #bdc3c7; margin-bottom: 8px;height: 160px;">
                                </div>
                                <form name="posting_profilepic_trade" id="posting_profilepic_trade" >
                                    <div style="display: none;"><input type="text" id="trade_hidden_companyID2" name="companyID">
                                    <input type="text" id="trade_hidden_tradeID" name="tradeID"></div>
                                    <input id="file_upload_trade" name="attachment_profilepic" class="form-control upload upload_app_req" type="file" onchange="showimgtrade();" accept="image/*"/>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="row form-group">
                            <div class="col-md-4 col-xs-12 thSysTenant">
                                Store Name
                            </div>
                            <div class="col-md-8 col-xs-12">
                                <input type="text" class="form-control text_new_trade" id="txttrade_tradename" onchange="GenerateMerchantCode(this.value)" onkeyup="GenerateMerchantCode(this.value)">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-xs-12 col-md-4">
                                Merchant Code
                            </div>
                            <div class="col-xs-12 col-md-8">
                                <input type="text" class="form-control text_new_trade" id="txtmerc_code" placeholder="Merchant Code" style="text-transform: uppercase;">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4 col-xs-12">
                                Company Name
                            </div>
                            <div class="col-md-8 col-xs-12">
                                <input id="txttrade_companyname" class="form-control text_new_trade" type="text" placeholder="Company Name" disabled="" style="background-color: white !important;"/>
                                <input type="hidden" id="txttrade_companyid">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4 col-xs-12">
                                Industry
                            </div>
                            <div class="col-md-8 col-xs-12">
                                <input type="text" class="form-control text_new_trade" style="background-color: white !important;" id="txttrade_tradeindustry" placeholder="Industry" disabled="true">
                            </div>
                        </div> 
                        <div class="row form-group">
                            <div class="col-md-4 col-xs-12">
                                Business Address<br /><h6 style="font-size:10px; font-style: italic;">(other than address in commercial center)</h6>
                            </div>
                            <div class="col-md-8 col-xs-12">
                                <textarea class="form-control text_new_trade" style="height: 70px;background-color: white !important;" id="txttrade_busadd" placeholder="Business Address" disabled="true"></textarea>
                            </div>
                        </div>   
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_new_store" class="btn btn-primary btn-sm btn-round" onclick="savetradename()"><i class="ace-icon fa fa-check"></i>&nbsp;Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" id="modal_addnewaddress" role="dialog" area-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <div class="row form-group" style="margin-top: 20px">
                <div class="col-md-8 col-xs-12" style="padding-right:0px;">
                    <table style="height: 100%;width: 100%;">
                        <tr>
                            <td>
                                <h6 style="font-size:10px; font-weight: bold;margin:2px;">Unit,Room number,Floor/Lot/Block/Phase, Village</h6>
                                <h6 style="font-size:10px; font-style: italic;margin:0px;">Ex. Blk 121 Lot 3 Phase II, Sta. Maria Village</h6>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" class="form-control" id="txtaddress_streetadd">
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-4 col-xs-12">
                    <table style="height: 100%;width: 100%;">
                        <tr>
                            <td>
                                <h6 style="font-size:10px; font-weight: bold;margin:2px;">City</h6>
                                <h6 style="font-size:10px; font-style: italic;margin:0px;">Ex. Muntinlupa City</h6>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input list="list_city_list" id="txtadd_city" class="form-control" type="text" li="txtbuss" placeholder="Type your city to search..." onkeyup="loadcityref()" />
                                <datalist id="list_city_list"></datalist>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
                <div class="row form-group" style="">
                    <div class="col-md-2 col-xs-12" style="padding-right:0px;"></div>
                    <div class="col-md-10 col-xs-12" style="">
                        <button type="button" class="btn btn-primary btn-sm btn-round" style="float: right;" id="okaddressbtn"><i class="ace-icon fa fa-check"></i>&nbsp;OK</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale bd-example-modal-sm" id="modal_new_referential" role="dialog" area-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" onclick="closemodalref()">&times;</button>
                <h4 class="modal-title" id="txtref_name">Select Facility</h4>
                <div class="row form-group">
                    <div class="col-xs-12 col-md-12">
                        <table table id="simple-table" class="table table-bordered table-hover" style="display: flex;flex-flow: column;height: 100%;width: 100%;margin-top: 10px !important;">
                            <tbody id="tblreflist" style="flex: 1 1 auto;display: block;height: 20em;overflow-x: hidden;"></tbody>
                        </table>
                        <hr />
                        <h6 class="modal-title" id="txtref_name2">New Facility</h6>
                        <h6 class="modal-title" style="font-size: 10px;font-style: italic;">(if not on the list)</h6>
                        <div class="input-group">
                            <input type="text" id="txtaddnewreferential" style="" class="form-control" placeholder="Add New" style="margin-top: 10px">  
                            <div class="spinbox-buttons input-group-btn">         
                                <button type="button" class="btn btn-success btn-sm btn-round" id="btnnewreferential" style="height: 34px;padding-top:2px;">&nbsp;Add&nbsp;
                                    <i class="icon-only  ace-icon ace-icon fa fa-plus bigger-110"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" role="dialog" id="edit_contactperson_modal">
    <div class="modal-dialog modal-lg" style="width: 85%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Contact Person</h4>
            </div>
            <div class="modal-body">
            <input type="hidden" id="div_type_id" name="">
                <div class="row form-group" style="display: block;" id="">
                    <div class="col-md-2 col-xs-12" style="padding:10px;padding-top: 0px;">
                        <div class="image">
                            <img class="img-thumbnail imageName form-control" src="assets/images/noimage5.png" id="imgtradeaccount_update" style="border: 2px solid #bdc3c7; margin-bottom: 8px;height: 160px;">
                        </div>
                        <form name="posting_profilepic_contactperson" id="posting_profilepic_contactperson" >
                          <div style="display: none;"><input type="text" id="trade_hidden_custid_update" name="contactID"><input type="text" id="trade_hidden_custid_update_company" name="companyID"></div>
                            <input id="file_upload_trade_update" name="file_upload_trade_update" class="form-control upload" type="file" onchange="showimgtrade_update();" accept="image/*"/>
                        </form>
                    </div>
                    <div class="col-xs-12 col-md-5">
                        <div class="row form-group">
                            <div class="col-xs-12 col-md-4">
                                Contact Name
                            </div>
                            <div class="col-xs-12 col-md-8">
                                <input type="text" class="form-control" placeholder="First Name" id="txtcontact_fname_update">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-xs-12 col-md-4">
                                
                            </div>
                            <div class="col-xs-12 col-md-8">
                                <input type="text" class="form-control" placeholder="Middle Name" id="txtcontact_mname_update">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-xs-12 col-md-4">
                                
                            </div>
                            <div class="col-xs-12 col-md-8">
                                <input type="text" class="form-control" placeholder="Last Name" id="txtcontact_lname_update">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-xs-12 col-md-4">
                                Company Position
                            </div>
                            <div class="col-xs-12 col-md-8">
                                <div class="input-group">
                                    <select class="form-control" id="txtcontact_designation_update"></select>
                                    <div class="spinbox-buttons input-group-btn">         
                                      <button type="button" class="btn spinbox-up btn-sm btn-success btn-round" onclick="loadreferentialmodal('position')">            
                                        <i class="icon-only  ace-icon ace-icon fa fa-plus bigger-110"></i>          
                                      </button>       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-5">
                        <div class="row form-group">
                            <div class="col-xs-12 col-md-4">
                                Address
                            </div>
                            <div class="col-xs-12 col-md-8">
                                <span class="input-icon" style="width: 100%;">
                                    <input type="text" style="background-color: white !important;" class="form-control home-address" id="txtcontact_address_update" onclick="loadaddressmodal('txtcontact_address_update')" onkeyup="loadaddressmodal('txtcontact_address_update')" placeholder="Click to add address..." readonly="">
                                <i class="ace-icon fa orange" id="txtcontact_address_update_icon"></i>
                                </span>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-xs-12 col-md-4">
                                Email Address
                            </div>
                            <div class="col-xs-12 col-md-8" id="div_add_contact_person_email_update">
                                <div class="input-group">
                                  <input type="text" id="div_add_contact_person_email_update" class="spinbox-input form-control email-address" placeholder="sample@yahoo.com">
                                    <div class="spinbox-buttons input-group-btn">         
                                      <button type="button" class="btn spinbox-up btn-sm btn-success btn-round" onclick="div_add_field('div_add_contact_person_email_update', 'emailaddress')">            
                                        <i class="icon-only ace-icon ace-icon fa fa-plus bigger-110"></i>          
                                      </button>       
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-xs-12 col-md-4">
                                Mobile No
                            </div>
                            <div class="col-xs-12 col-md-8" id="div_add_contact_person_mobile_update">
                                <div class="input-group">
                                  <input type="text" id="div_add_contact_person_mobile_update" class="spinbox-input form-control input-mask-phone" maxlength="11" placeholder="(999)-999-9999">
                                    <div class="spinbox-buttons input-group-btn">         
                                      <button type="button" class="btn spinbox-up btn-sm btn-success btn-round" onclick="div_add_field('div_add_contact_person_mobile_update', 'input-mask-phone')">            
                                        <i class="icon-only  ace-icon ace-icon fa fa-plus bigger-110"></i>          
                                      </button>       
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-xs-12 col-md-4">
                                Telephone No
                            </div>
                            <div class="col-xs-12 col-md-8" id="div_add_contact_person_tele_update">
                                <div class="input-group">
                                  <input type="text" id="div_add_contact_person_tele_update" class="spinbox-input form-control input-mask-tele" maxlength="11" placeholder="(99)-999-9999">
                                    <div class="spinbox-buttons input-group-btn">         
                                      <button type="button" class="btn spinbox-up btn-sm btn-success btn-round" onclick="div_add_field('div_add_contact_person_tele_update', 'input-mask-tele')">            
                                        <i class="icon-only  ace-icon ace-icon fa fa-plus bigger-110"></i>          
                                      </button>       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" id="">
                <button type="button" class="btn btn-primary btn-sm btn-round" id="btn_savecontactperson" onclick=""><i class="ace-icon fa fa-check"></i>&nbsp;Save</button>
            </div>
        </div>
    </div>
</div>

<div  class="modal fade fade-scale" id="modal_new_company" area-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;" id="modal_company_header">Company</h4>
            </div>
            <div class="modal-body" id="div_add_contact" style="display: block;">
                <div class="row form-group">
                    <div class="col-md-3 col-xs-12">
                        <div class="image">
                            <img class="img-thumbnail imageName form-control" src="assets/images/noimage5.png" id="imgaccount" style="border: 2px solid #bdc3c7; margin-bottom: 8px;height: 160px;">
                        </div>
                        <form name="posting_profilepic123123" id="posting_profilepic123123">
                            <div style="display: none"><input type="text" id="hidden_company_id" name="hidden_company_id"></div>
                            <input id="file_upload" name="attachment_profilepic" class="form-control upload" type="file" onchange="showimg();" accept="image/*">
                        </form>
                    </div>
                    <div class="col-md-9 col-xs-12">
                        <div class="row form-group">
                            <div class="col-xs-12 col-md-4">
                                Company Name
                            </div>
                            <div class="col-xs-12 col-md-8">
                                <input type="text" class="form-control text_reqcompany" id="txtcomp_name" placeholder="Company Name">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-xs-12 col-md-4">
                                Industry
                            </div>
                            <div class="col-xs-12 col-md-8">
                                <div class="input-group">
                                    <select class="form-control text_reqcompany" id="txtcomp_industry"></select>
                                    <div class="spinbox-buttons input-group-btn">         
                                      <button type="button" class="btn spinbox-up btn-sm btn-success btn-round" onclick="loadreferentialmodal('industry')">            
                                        <i class="icon-only  ace-icon ace-icon fa fa-plus bigger-110"></i>          
                                      </button>       
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-xs-12 col-md-4">
                                Business Address<br />
                                <h6 style="font-size:10px; font-style: italic;">(other than address in commercial center)</h6>
                            </div>
                            <div class="col-xs-12 col-md-8">
                                <span class="input-icon" style="width: 100%;">
                                    <textarea class="form-control text_reqcompany home-address" style="height: 50px; resize: none;" id="txtcomp_busadd" onclick="loadaddressmodal('txtcomp_busadd')" onkeyup="loadaddressmodal('txtcomp_busadd')" placeholder="Click to add address..."></textarea>
                                    <i class="ace-icon fa orange" id="txtcomp_busadd_icon"></i>
                                </span>
                            </div>
                        </div>                                                                                    
                    </div>
                </div>
                <?php if(SysLeaseSetup('isMultiCompSig') == '1'){ ?>
                <div class="row form-group" style="margin-bottom: 0px;">
                    <div class="col-md-12 col-xs-12">
                        <div class="well" id="div_CompSig">
                            <div class="row form-group">
                                <div class="col-xs-12">
                                    <div class="row form-group">
                                        <div class="col-md-12 col-xs-12">
                                            <h4 class="green smaller lighter">Company Signatory List </h4>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-1">
                                            First Name
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" id="txtCompSigFN">
                                        </div>
                                        <div class="col-md-1">
                                            Middle Name
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" id="txtCompSigMN">
                                        </div>
                                        <div class="col-md-1">
                                            Last Name
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" id="txtCompSigLN">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-sm btn-info pull-right btn-round" onclick="AddNewSignatory();">Add Signatory</button>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div style="height: 25vh;" class="col-md-12">
                                            <input type="hidden" id="txtCompSigCount">
                                            <table class="table table-bordered fixTable">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 30%;">First Name</th>
                                                        <th style="width: 30%;">Middle Name</th>
                                                        <th style="width: 30%;">Last Name</th>
                                                        <th style="width: 10%; z-index: 1;">Option</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbodyCompSigList"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?> 
                <div class="row form-group" style="margin-bottom: 0px;">
                    <div class="col-md-6 col-xs-12">
                        <div class="well">
                            <div class="row form-group">
                                <div class="col-md-12 col-xs-12">
                                    <h4 class="green smaller lighter">Billing Information</h4>
                                </div>
                            </div>
                            <div class="row form-group" style="display: block; height: 425px;overflow-y: scroll;">
                                <div class="col-md-12">
                                    <?php if(SysLeaseSetup('isMultiCompSig') == '0'){ ?>
                                    <div class="row form-group">
                                        <div class="col-md-4 col-xs-12">
                                            Owner's Name
                                        </div>
                                        <div class="col-md-8 col-xs-12">
                                            <input type="text" class="form-control text_reqcompany" placeholder="First Name" id="txtcomp_fname">
                                        </div>
                                    </div>  
                                    <div class="row form-group">
                                        <div class="col-md-4 col-xs-12"></div>
                                        <div class="col-md-8 col-xs-12">
                                            <input type="text" class="form-control text_reqcompany" placeholder="Middle Name" id="txtcomp_mname">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-4 col-xs-12"></div>
                                        <div class="col-md-8 col-xs-12">
                                            <input type="text" class="form-control text_reqcompany" placeholder="Last Name" id="txtcomp_lname">
                                        </div>
                                    </div> 
                                    <?php } ?> 
                                    <div class="row form-group">
                                        <div class="col-md-4 col-xs-12">
                                            Permanent Address
                                        </div>
                                        <div class="col-md-8 col-xs-12">
                                            <span class="input-icon" style="width: 100%;">
                                                <textarea class="form-control home-address" style="height: 50px; resize: none; background-color: white !important;" id="txtcomp_perm_add" onclick="loadaddressmodal('txtcomp_perm_add')" onkeyup="loadaddressmodal('txtcomp_perm_add')" placeholder="Click to add address..." readonly></textarea>
                                                 <i class="ace-icon fa orange" id="txtcomp_perm_add_icon"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-4 col-xs-12">
                                            Current Address
                                            <label>
                                                <input name="form-field-checkbox" class="ace ace-checkbox-2" type="checkbox" value="" id="curr_add" onclick="SameAddVal(this.id);">
                                                <span style="font-size: 10px;" class="lbl"> (Same as permanent address)</span>
                                            </label>
                                        </div>
                                        <div class="col-md-8 col-xs-12">
                                            <span class="input-icon" style="width: 100%;">
                                                <textarea class="form-control text_reqcompany home-address" style="height: 50px; resize: none; background-color: white !important;" id="txtcomp_curr_add" onclick="loadaddressmodal('txtcomp_curr_add')" onkeyup="loadaddressmodal('txtcomp_curr_add')" placeholder="Click to add address..." readonly></textarea>
                                                <i class="ace-icon fa orange" id="txtcomp_curr_add_icon"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-4 col-xs-12">
                                            Billing Address
                                            <label>
                                                <input name="form-field-checkbox" class="ace ace-checkbox-2" type="checkbox" value="" id="bill_add" onclick="SameAddVal(this.id);">
                                                <span style="font-size: 10px;" class="lbl"> (Same as permanent address)</span>
                                            </label>
                                        </div>
                                        <div class="col-md-8 col-xs-12">
                                            <span class="input-icon" style="width: 100%;">
                                                <textarea class="form-control text_reqcompany home-address" style="height: 50px; resize: none; background-color: white !important;" id="txtcomp_bill_add" onclick="loadaddressmodal('txtcomp_bill_add')" onkeyup="loadaddressmodal('txtcomp_bill_add')" placeholder="Click to add address..." readonly></textarea>
                                                <i class="ace-icon fa orange" id="txtcomp_bill_add_icon"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-4 col-xs-12">
                                            <div class="input-group">
                                              Telephone No
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-xs-12" id="add_tel_no_owner">
                                            <div class="input-group">
                                                <input type="text" id="add_tel_no_owner" class="spinbox-input form-control input-mask-tele" maxlength="11" placeholder="(99)-999-9999">
                                                <div class="spinbox-buttons input-group-btn">         
                                                    <button type="button" class="btn spinbox-up btn-sm btn-success btn-round" onclick="div_addtel_owner()">
                                                        <i class="icon-only  ace-icon ace-icon fa fa-plus bigger-110"></i>          
                                                    </button>       
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <div class="well" id="div_well_contacts">
                            <div class="row form-group">
                                <div class="col-md-12 col-xs-12">
                                    <h4 class="green smaller lighter">Company Contacts</h4>
                                </div>
                            </div> 
                            <div class="row form-group" style="display: block; height: 425px;overflow-y: scroll;" id="div_company_contacts">
                                <div class="col-xs-12">
                                    <div class="row form-group">
                                        <div class="col-md-4 col-xs-12">
                                            <div class="input-group">
                                                Mobile No
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-xs-12">
                                            <div class="input-group" id="company_contact_mobile" style="width: 100%;">
                                                <input type="text" id="company_contact_mobile" class="spinbox-input form-control input-mask-phone" maxlength="11" placeholder="(999)-999-9999">
                                                <div class="spinbox-buttons input-group-btn">         
                                                    <button type="button" class="btn spinbox-up btn-sm btn-success btn-round" onclick="div_add_field('company_contact_mobile', 'input-mask-phone')">            
                                                        <i class="icon-only  ace-icon ace-icon fa fa-plus bigger-110"></i>          
                                                    </button>       
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="row form-group">
                                        <div class="col-md-4 col-xs-12">
                                            <div class="input-group">
                                                Telephone No
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-xs-12">
                                            <div class="input-group" id="company_contact_tele" style="width: 100%;">
                                                <input type="text" id="company_contact_tele" class="spinbox-input form-control input-mask-tele" maxlength="11" placeholder="(99)-999-9999">
                                                <div class="spinbox-buttons input-group-btn">         
                                                    <button type="button" class="btn spinbox-up btn-sm btn-success btn-round" onclick="div_add_field('company_contact_tele', 'input-mask-tele')">            
                                                        <i class="icon-only  ace-icon ace-icon fa fa-plus bigger-110"></i>          
                                                    </button>       
                                                </div>
                                            </div>
                                        </div>
                                    </div>  
                                    <div class="row form-group">
                                        <div class="col-md-4 col-xs-12">
                                            <div class="input-group">
                                              Fax No
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-xs-12">
                                            <div class="input-group" id="company_contact_fax" style="width: 100%;">
                                                <input type="text" id="company_contact_fax" class="spinbox-input form-control input-mask-tele" maxlength="11" placeholder="(99)-999-9999">
                                                <div class="spinbox-buttons input-group-btn">         
                                                    <button type="button" class="btn spinbox-up btn-sm btn-success btn-round" onclick="div_add_field('company_contact_fax',  'input-mask-tele')">            
                                                        <i class="icon-only  ace-icon ace-icon fa fa-plus bigger-110"></i>          
                                                    </button>       
                                                </div>
                                            </div>
                                        </div>
                                    </div>  
                                    <div class="row form-group">
                                        <div class="col-md-4 col-xs-12">
                                            <div class="input-group">
                                                Email Address
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-xs-12">
                                            <div class="input-group" id="company_contact_email" style="width: 100%;">
                                                <input type="text" id="company_contact_email" onkeyup="" class="spinbox-input form-control email-address" placeholder="sample@yahoo.com">
                                                <div class="spinbox-buttons input-group-btn">         
                                                    <button type="button" class="btn spinbox-up btn-sm btn-success btn-round" onclick="div_add_field('company_contact_email', 'emailaddress')">            
                                                        <i class="icon-only  ace-icon ace-icon fa fa-plus bigger-110"></i>          
                                                    </button>       
                                                </div>
                                            </div>
                                            <span style="color: #DD5A43;" id="error_company_contact_email"></span>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-4 col-xs-12">
                                            <div class="input-group">
                                                Website
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-xs-12">
                                            <div class="input-group" id="company_contact_website" style="width: 100%;">
                                                <input type="text" id="company_contact_website" class="spinbox-input form-control website-input" placeholder="www.sample.com">
                                                <div class="spinbox-buttons input-group-btn">         
                                                    <button type="button" class="btn spinbox-up btn-sm btn-success btn-round" onclick="div_add_field('company_contact_website', 'website')">            
                                                        <i class="icon-only  ace-icon ace-icon fa fa-plus bigger-110"></i>          
                                                    </button>       
                                                </div>
                                            </div>
                                            <span style="color: #DD5A43;" id="error_company_contact_website"></span>
                                        </div>
                                    </div>  
                                </div>
                            </div>                                
                        </div>
                    </div>
                </div>
                <div class="row form-group" style="margin-bottom: 0px;">
                    <div class="col-md-12 col-xs-12">
                        <div class="well" id="div_well_contact_persons">
                            <div class="row form-group" style="border-bottom: 1px dotted #478FCA;">
                                 <div class="col-md-6 col-xs-6" style="padding-right: 0px;">
                                    <h4 class="green smaller lighter">Contact Persons</h4>
                                    <span style="color: #F89406;">NOTE: THIS INFORMATION IS NECESSARY</span>
                                </div>
                                <div class="col-md-6 col-xs-6" style="padding-left: 0px;">
                                    <h5 class="blue lighter less-margin">
                                        <a href="#" id="" style="float: right;" onclick="addnewcontactperson()">
                                        <i id="carret_icon_div" class="ace-icon fa fa-caret-up bigger-120"></i>
                                        </a>
                                    </h5>
                                </div>
                            </div>
                            <div class="row form-group" style="display: block;" id="div_addnewcontactperson">
                                <div class="col-xs-12 col-md-6">
                                    <div class="row form-group">
                                        <div class="col-xs-12 col-md-4">
                                            Contact Name
                                        </div>
                                        <div class="col-xs-12 col-md-8">
                                            <input type="text" class="form-control save_contact_per" placeholder="First Name" id="txtcontact_fname">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-xs-12 col-md-4">
                                            
                                        </div>
                                        <div class="col-xs-12 col-md-8">
                                            <input type="text" class="form-control" placeholder="Middle Name" id="txtcontact_mname">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-xs-12 col-md-4">
                                            
                                        </div>
                                        <div class="col-xs-12 col-md-8">
                                            <input type="text" class="form-control save_contact_per" placeholder="Last Name" id="txtcontact_lname">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-xs-12 col-md-4">
                                            Company Position
                                        </div>
                                        <div class="col-xs-12 col-md-8">
                                            <div class="input-group">
                                                <select class="form-control save_contact_per" id="txtcontact_designation"></select>
                                                <div class="spinbox-buttons input-group-btn">         
                                                    <button type="button" class="btn spinbox-up btn-sm btn-success btn-round" onclick="loadreferentialmodal('position')">
                                                        <i class="icon-only  ace-icon ace-icon fa fa-plus bigger-110"></i>          
                                                    </button>       
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <div class="row form-group">
                                        <div class="col-xs-12 col-md-4">
                                            Address
                                        </div>
                                        <div class="col-xs-12 col-md-8">
                                            <span class="input-icon" style="width: 100%;">
                                                <input type="text" style="background-color: white !important;" class="form-control home-address save_contact_per" id="txtcontact_address" onclick="loadaddressmodal('txtcontact_address')" onkeyup="loadaddressmodal('txtcontact_address')" placeholder="Click to add address..." readonly>
                                                <i class="ace-icon fa orange" id="txtcontact_address_icon"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-xs-12 col-md-4">
                                            Email Address
                                        </div>
                                        <div class="col-xs-12 col-md-8" id="div_add_contact_person_email">
                                            <div class="input-group">
                                                <input type="text" id="div_add_contact_person_email" class="spinbox-input form-control email-address" placeholder="sample@yahoo.com">
                                                <div class="spinbox-buttons input-group-btn">         
                                                    <button type="button" class="btn spinbox-up btn-sm btn-success btn-round" onclick="div_add_field('div_add_contact_person_email', 'emailaddress')">            
                                                        <i class="icon-only  ace-icon ace-icon fa fa-plus bigger-110"></i>          
                                                    </button>       
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-xs-12 col-md-4">
                                            Mobile No
                                        </div>
                                        <div class="col-xs-12 col-md-8" id="div_add_contact_person_mobile">
                                            <div class="input-group">
                                                <input type="text" id="div_add_contact_person_mobile" class="spinbox-input form-control input-mask-phone" maxlength="11" placeholder="(999)-999-9999">
                                                <div class="spinbox-buttons input-group-btn">         
                                                    <button type="button" class="btn spinbox-up btn-sm btn-success btn-round" onclick="div_add_field('div_add_contact_person_mobile', 'input-mask-phone')">            
                                                        <i class="icon-only  ace-icon ace-icon fa fa-plus bigger-110"></i>          
                                                    </button>       
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-xs-12 col-md-4">
                                            Telephone No
                                        </div>
                                        <div class="col-xs-12 col-md-8" id="div_add_contact_person_tele">
                                            <div class="input-group">
                                                <input type="text" id="div_add_contact_person_tele" class="spinbox-input form-control input-mask-tele" maxlength="11">
                                                <div class="spinbox-buttons input-group-btn">         
                                                    <button type="button" class="btn spinbox-up btn-sm btn-success btn-round" onclick="div_add_field('div_add_contact_person_tele', 'input-mask-tele')">            
                                                        <i class="icon-only  ace-icon ace-icon fa fa-plus bigger-110"></i>          
                                                    </button>       
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="hr hr-dotted"></div>
                                    <div class="clearfix">
                                        <button id="btn-save-contact-person" class="pull-right btn btn-sm btn-success btn-white btn-round" type="button" onclick="addcontactperson()">
                                            Save Contact Person
                                            <i class="ace-icon fa fa-plus icon-on-right bigger-110"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-12 col-xs-12" id="div_content_contact_person_list"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="modal_company_name" class="btn btn-primary btn-sm btn-round" onclick="savenewmall();"><i class="fa fa-check"></i>&nbsp;Save</button>
            </div>
        </div>
    </div>
</div>

<?php include("script.php"); ?>