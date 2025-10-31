<div class="modal fade fade-scale" id="modal_loadcompany" role="dialog" area-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div id="preloadmodal_loadcompany"></div>
            <div class="modal-header" style="background-color: #438EB9;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Company List</h4>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-md-4 col-xs-12">
                        <span class="input-icon" style="width: 100%;">
                            <input type="text" class="form-control" placeholder="Search" id="txtsearchcompany">
                            <i class="ace-icon fa fa-search nav-search-icon"></i>
                        </span>
                    </div>
                    <div class="col-md-4 col-xs-12 pull-right">
                        <a href="#" id="btn_new_comany" class="btn btn-info btn-sm btn-round" style="width: 100% !important;" onclick="newcompany()">New Company</a>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-xs-12">
                        <div id="companytable" class="parent">
                            <table id="simple-table" class="table table-bordered table-hover fixTable">
                                <thead>
                                    <tr>
                                        <th style="width: 65%;">Company Name</th>
                                        <th style="width: 35%;">Industry</th>
                                        <th style="width: 5%;z-index: 1;">Option</th>
                                    </tr>
                                </thead>
                                <tbody id="tblcompanylist"></tbody>
                            </table>
                        </div>
                        <table class="tabledash_footer table" style="margin: 0px !important;">
                            <thead>
                                <tr>
                                    <th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
                                        <font id="txtentriescompanylist" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
                                        <input id="txt_userpage" type="hidden">
                                        <ul id="ulpaginationcompanylist" class="pagination pull-right"></ul>
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
    
<div  class="modal fade fade-scale" id="modal_new_company" area-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;" id="modal_company_header">Company</h4>
            </div>
            <div class="modal-body" id="div_add_contact" style="display: block;">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row form-group">

                            <div class="col-md-12" id="div_CompanyInfo">
                                <div class="widget-container-col ui-sortable" id="widget-container-buyerinfo">
                                    <div class="widget-box transparent ui-sortable-handle" id="widget-box-12">
                                        <div class="widget-header">
                                            <h4 class="widget-title">Company Information</h4>
                                        </div>
                                        <div class="widget-body">
                                            <div class="widget-main">
                                                <div class="row well">
                                                    <div class="row form-group">
                                                        <div class="col-md-3 col-xs-12">
                                                            <div class="row form-group">
                                                                <div class="image">
                                                                    <img class="img-thumbnail imageName form-control" src="assets/images/noimage5.png" id="imgaccount" style="border: 2px solid #bdc3c7; margin-bottom: 8px;height: 160px;">
                                                                </div>
                                                                <form name="posting_profilepic" id="posting_profilepic" >
                                                                    <div style="display: none"><input type="text" id="hidden_company_id" name="hidden_company_id"></div>
                                                                    <input id="file_upload" name="attachment_profilepic" class="form-control upload" type="file" onchange="showimg();" accept="image/*"/>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-9 col-xs-12">
                                                            <div class="row form-group">
                                                                <div class="col-md-6">
                                                                    <div class="row form-group">
                                                                        <div class="col-xs-12 col-md-12">
                                                                            Company Name
                                                                        </div>
                                                                        <div class="col-xs-12 col-md-12">
                                                                            <input type="text" class="form-control text_reqcompany" id="txtcomp_name" placeholder="Company Name">
                                                                        </div>
                                                                    </div>
                                                                    <div class="row form-group">
                                                                        <div class="col-md-12 col-xs-12">
                                                                            Fax No
                                                                        </div>
                                                                        <div class="col-md-12 col-xs-12">
                                                                            <div class="input-group div_company_contacts" id="company_contact_fax" style="width: 100%;"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row form-group">
                                                                        <div class="col-md-12 col-xs-12">
                                                                            Mobile No
                                                                        </div>
                                                                        <div class="col-md-12 col-xs-12">
                                                                            <div class="input-group div_company_contacts" id="company_contact_mobile" style="width: 100%;"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row form-group">
                                                                        <div class="col-md-12 col-xs-12">
                                                                            Telephone No
                                                                        </div>
                                                                        <div class="col-md-12 col-xs-12">
                                                                            <div class="input-group div_company_contacts" id="company_contact_tele" style="width: 100%;"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="row form-group">
                                                                        <div class="col-xs-12 col-md-12">
                                                                            Industry
                                                                        </div>
                                                                        <div class="col-xs-12 col-md-12">
                                                                            <div class="input-group">
                                                                                <select class="form-control" id="txtcomp_industry" placeholder="Industry"></select>
                                                                                <div class="spinbox-buttons input-group-btn">
                                                                                    <button type="button" class="btn spinbox-up btn-sm btn-success" onclick="fncAddIndustry();"><i class="icon-only  ace-icon ace-icon fa fa-plus bigger-110"></i></button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row form-group">
                                                                        <div class="col-md-12 col-xs-12">
                                                                            <div class="input-group">
                                                                                Website
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-12 col-xs-12">
                                                                            <div class="input-group div_company_contacts" id="company_contact_website" style="width: 100%;"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row form-group">
                                                                        <div class="col-md-12 col-xs-12">
                                                                            <div class="input-group">
                                                                                Email Address
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-12 col-xs-12">
                                                                            <div class="input-group div_company_contacts" id="company_contact_email" style="width: 100%;"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row form-group">
                                                                        <div class="col-xs-12 col-md-12">
                                                                            Business Address
                                                                        </div>
                                                                        <div class="col-xs-12 col-md-12">
                                                                            <span class="input-icon" style="width: 100%;">
                                                                                <textarea class="form-control home-address" style="height: 60px;resize: none;" id="txtcomp_busadd" onclick="loadaddressmodal('txtcomp_busadd')" onkeyup="loadaddressmodal('txtcomp_busadd')" placeholder="Click to add address..."></textarea>
                                                                            </span>
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

                            <div class="col-md-12" id="div_BillingInformation">
                                <div class="widget-container-col ui-sortable" id="widget-container-buyerinfo">
                                    <div class="widget-box transparent ui-sortable-handle collapsed" id="widget-box-12">
                                        <div class="widget-header">
                                            <h4 class="widget-title">Billing Information</h4>
                                            <div class="widget-toolbar no-border">
                                                <a href="#" data-action="collapse">
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
                                                                    Account Name
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <input type="text" class="form-control" id="txtBillAccountName" placeholder="Account Name">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="row form-group">
                                                                <div class="col-md-12">
                                                                    Telephone No
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <input type="text" class="form-control input-mask-tele" id="txtBillTelephone" placeholder="(99)-999-9999">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="row form-group">
                                                                <div class="col-md-12">
                                                                    Mobile No
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <input type="text" class="form-control input-mask-phone" id="txtBillMobile" placeholder="(99)-999-9999">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="row form-group">
                                                                <div class="col-md-12">
                                                                    Email Address
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <input type="text" class="form-control email-address" id="txtBillEmail" placeholder="sample@yahoo.com">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-md-3">
                                                            Permanent Address
                                                            <label>
                                                                <input name="form-field-checkbox" class="ace ace-checkbox-2 chkSameButton" type="checkbox" value="" id="perm_add" onclick="SameAddVal(this.id);">
                                                                <span style="font-size: 10px;" class="lbl"> (Same as business address)</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <span class="input-icon" style="width: 100%;">
                                                                <textarea class="form-control home-address" style="height: 50px; resize: none; background-color: white !important;" id="txtcomp_perm_add" onclick="loadaddressmodal('txtcomp_perm_add')" onkeyup="loadaddressmodal('txtcomp_perm_add')" placeholder="Click to add address..." readonly></textarea>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-md-3">
                                                            Current Address
                                                            <label>
                                                                <input name="form-field-checkbox" class="ace ace-checkbox-2 chkSameButton" type="checkbox" value="" id="curr_add" onclick="SameAddVal(this.id);">
                                                                <span style="font-size: 10px;" class="lbl"> (Same as business address)</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <span class="input-icon" style="width: 100%;">
                                                                <textarea class="form-control home-address" style="height: 50px; resize: none; background-color: white !important;" id="txtcomp_curr_add" onclick="loadaddressmodal('txtcomp_curr_add')" onkeyup="loadaddressmodal('txtcomp_curr_add')" placeholder="Click to add address..." readonly></textarea>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-md-3">
                                                            Billing Address
                                                            <label>
                                                                <input name="form-field-checkbox" class="ace ace-checkbox-2 chkSameButton" type="checkbox" value="" id="bill_add" onclick="SameAddVal(this.id);">
                                                                <span style="font-size: 10px;" class="lbl"> (Same as business address)</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <span class="input-icon" style="width: 100%;">
                                                                <textarea class="form-control home-address" style="height: 50px; resize: none; background-color: white !important;" id="txtcomp_bill_add" onclick="loadaddressmodal('txtcomp_bill_add')" onkeyup="loadaddressmodal('txtcomp_bill_add')" placeholder="Click to add address..." readonly></textarea>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row form-group">
                                                        <div class="col-xs-12 col-md-4">
                                                            <div class="row form-group">
                                                                <div class="col-md-12">
                                                                    <label>
                                                                        <input name="form-field-checkbox" type="checkbox" class="ace" id="chkAsPrimary">
                                                                        <span class="lbl"> Set as primary</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="row form-group">
                                                                <div class="col-xs-12 col-md-12">
                                                                    Contact Name
                                                                </div>
                                                                <div class="col-xs-12 col-md-12">
                                                                    <input type="text" class="form-control save_contact_per" placeholder="First Name" id="txtcontact_fname">
                                                                </div>
                                                            </div>
                                                            <div class="row form-group">
                                                                <div class="col-xs-12 col-md-12">
                                                                    <input type="text" class="form-control" placeholder="Middle Name" id="txtcontact_mname">
                                                                </div>
                                                            </div>
                                                            <div class="row form-group">
                                                                <div class="col-xs-12 col-md-12">
                                                                    <input type="text" class="form-control save_contact_per" placeholder="Last Name" id="txtcontact_lname">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-md-4">
                                                            <div class="row form-group">
                                                                <div class="col-md-6">
                                                                    <label>
                                                                        <input name="form-field-checkbox" type="radio" class="ace rdContactStat" value="Active" checked id="chkContactStatActive">
                                                                        <span class="lbl"> Active</span>
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label>
                                                                        <input name="form-field-checkbox" type="radio" class="ace rdContactStat" value="Inactive">
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
                                                                        <select class="form-control save_contact_per slctPosition" id="txtcontact_designation"></select>
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
                                                                    <textarea class="form-control" style="background-color: white !important; resize: none; height: 63px;" class="form-control home-address save_contact_per" id="txtcontact_address" onclick="loadaddressmodal('txtcontact_address')" onkeyup="loadaddressmodal('txtcontact_address')" placeholder="Click to add address..." readonly></textarea>
                                                                </div>
                                                            </div>                                                            
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="row form-group">
                                                                <div class="col-xs-12 col-md-12">
                                                                    Email Address
                                                                </div>
                                                                <div class="col-xs-12 col-md-12" id="div_add_contact_person_email"></div>
                                                            </div>
                                                            <div class="row form-group">
                                                                <div class="col-xs-12 col-md-12">
                                                                    Mobile No
                                                                </div>
                                                                <div class="col-xs-12 col-md-12" id="div_add_contact_person_mobile"></div>
                                                            </div>
                                                            <div class="row form-group">
                                                                <div class="col-xs-12 col-md-12">
                                                                    Telephone No
                                                                </div>
                                                                <div class="col-xs-12 col-md-12" id="div_add_contact_person_tele"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <button id="btn-save-contact-person" class="pull-right btn btn-sm btn-success btn-round" onclick="addcontactperson()">Add Contact</button>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-md-12 col-xs-12" id="div_content_contact_person_list"></div>
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
                <button id="modal_company_name" class="btn btn-sm btn-primary btn-round" onclick="savenewmall();" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving..."><i class="fa fa-check"></i>&nbsp;Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" id="mdlAddIndustry" role="dialog" area-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div id="preloadmodal_loadcompany"></div>
            <div class="modal-header" style="background-color: #438EB9;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Add Industry</h4>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <label class="col-md-12">Industry Code</label>
                    <div class="col-md-12">
                        <input type="text" class="form-control" id="txtInqIndustryCode">
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-12">Industry</label>
                    <div class="col-md-12">
                        <input type="text" class="form-control" id="txtInqIndustry">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-primary btn-round" onclick="fncSaveIndustry();" id="btnAddIndustry" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving..."><i class="fa fa-check"></i>&nbsp;Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale" id="mdlAddPosition" role="dialog" area-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div id="preloadmodal_loadcompany"></div>
            <div class="modal-header" style="background-color: #438EB9;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Add Position</h4>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <label class="col-md-12">Position</label>
                    <div class="col-md-12">
                        <input type="text" class="form-control" id="txtInqPosition">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-primary btn-round" onclick="fncSavePosition();" id="btnAddPosition" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving..."><i class="fa fa-check"></i>&nbsp;Save</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function(){
        $("#txtsearchcompany").keydown(function(e){
            var x = e.keyCode;
            if(x == 13){ 
                $("#txt_userpage").val("1");
                loadcompanylist(); 
            }else if(x == '8'){
                if($('#txtsearchcompany').val() == ""){
                    $("#txt_userpage").val("1");
                    loadcompanylist();
                }
            }
        });
        $(".home-address").keyup(function(){
            var value = $(this).val();
            var thisid = $(this).attr("id");
            if(value == ""){
                $(this).attr("onclick", "loadaddressmodal(\""+thisid+"\")");
                $(this).attr("onkeyup", "loadaddressmodal(\""+thisid+"\")");
            }
        });        
    });

    function loadcompanylist() {
        var txtsearchcompany = $("#txtsearchcompany").val();
        var page = $("#txt_userpage").val();
        $.ajax({
            type: 'POST',
            url: 'include/class.php',
            data: 'txtsearchcompany=' + txtsearchcompany + '&page=' + page + '&form=loadcompanylist',
            beforeSend: function(){
                $('#preloadmodal_loadcompany').addClass('myspinner');
            },
            success:function(data){
                $("#preloadmodal_loadcompany").removeClass("myspinner");
                if(data != ""){
                    $("#tblcompanylist").html(data);
                }else{
                    $("#tblcompanylist").html("<tr><td colspan='3' style='text-align: center;'>No Data Found...</td></tr>");
                }
            },
            complete: function(){
                loadentriescompanylist();
                loadpagecompanylist();
            }
        })
    }

    function loadentriescompanylist(){
        var page = $("#txt_userpage").val();
        var txtsearchcompany = $("#txtsearchcompany").val();
        $.ajax({
            type: 'POST',
            url: 'include/class.php',
            data: 'txtsearchcompany=' + txtsearchcompany + '&page=' + page  + '&form=loadentriescompanylist',
            success: function(data){
                $("#txtentriescompanylist").text(data);
            }
        });
    }

    function loadpagecompanylist(){
        var page = $("#txt_userpage").val();
        var txtsearchcompany = $("#txtsearchcompany").val();
        $.ajax({
            type: 'POST',
            url: 'include/class.php',
            data: 'page=' + page + '&txtsearchcompany=' + txtsearchcompany + '&form=loadpagecompanylist',
            success: function(data){
                $("#ulpaginationcompanylist").html(data);
            }
        });
    }
  
    function pagination(page, pagenums){
        $(".pgnum").removeClass("active");
        $("#pg" + pagenums).addClass("active");
        $("#txt_userpage").val(page);
        loadcompanylist();
    }

    function updatecompany(compid, BillerID){
        $("#txtCompSigFN").val("");
        $("#txtCompSigMN").val("");
        $("#txtCompSigLN").val("");
        $("#btn-save-contact-person").attr("onclick", "addcontactperson_update(\""+ BillerID +"\")");
        $("#div_type_id").val("div_content_contact_person_list");
        $("#posting_profilepic").html('<div style="display: none"><input type="text" id="hidden_company_id" name="hidden_company_id"></div><input id="file_upload" name="attachment_profilepic" class="form-control upload" type="file" onchange="showimg();" accept="image/*"/>');
        $('#file_upload').ace_file_input({
            no_file:'No File ...',
            btn_choose:'Choose',
            btn_change:'Change',
            droppable:false,
            onchange:null,
            thumbnail:false
        });
        $("#div_add_contact_person_email").html("<div class='input-group'><input type='text' class='spinbox-input form-control' placeholder='sample@yahoo.com'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success' onclick='div_add_field(\"div_add_contact_person_email\", \"emailaddress\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>");
        $("#div_add_contact_person_mobile").html("<div class='input-group'><input type='text' class='spinbox-input form-control input-mask-phone' maxlength='11' placeholder='(999)-999-9999'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success' onclick='div_add_field(\"div_add_contact_person_mobile\", \"input-mask-phone\")'> <i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>");
        $("#div_add_contact_person_tele").html("<div class='input-group'><input type='text' class='spinbox-input form-control input-mask-tele'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success' onclick='div_add_field(\"div_add_contact_person_tele\", \"input-mask-tele\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>");
        $("#modal_company_header").text("Update Company");
        $("#modal_new_company").modal("show");
        $("#modal_company_name").attr("onclick", "savenewmall_update(\""+compid+"\")");
        $.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'id=' + compid + '&form=load_updatecompany',
            success: function(data) {
                var arr = data.split("|");
                $("#txtcomp_name").val(arr[0]);
                $("#txtcomp_industry").val(arr[1]);
                $("#txtcomp_busadd").val(arr[2]);
                $("#txtcomp_perm_add").val(arr[3]);
                $("#txtcomp_curr_add").val(arr[4]);
                $("#txtcomp_bill_add").val(arr[5]);
                $("#imgaccount").attr("src", arr[6]);
                $("#txtBillAccountName").val(arr[7]);
                $("#txtBillTelephone").val(arr[8]);
                $("#txtBillMobile").val(arr[9]);
                $("#txtBillEmail").val(arr[10]);
                $("#div_add_contact .home-address").each(function(){
                    var thisid = $(this).attr("id");
                    if($(this).val() == ""){
                        $(this).attr("onclick", "loadaddressmodal(\""+thisid+"\")");
                        $(this).attr("onkeyup", "loadaddressmodal(\""+thisid+"\")");
                    }else{
                        $(this).attr("onclick", "");
                        $(this).attr("onkeyup", "");
                    }
                });
                $(".chkSameButton").prop("checked", false);
            }
        })
        $.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'id=' + compid + '&form=load_update_companycontacts',
            success: function(data) {
                var arr = data.split("#|");
                $("#company_contact_mobile").html(arr[0]);
                $("#company_contact_tele").html(arr[1]);
                $("#company_contact_fax").html(arr[2]);
                $("#company_contact_email").html(arr[3]);
                $("#company_contact_website").html(arr[4]);
                autotrapfields();
            }
        })
        $.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'id=' + BillerID + '&form=load_updatecompany_contactpersons',
            success: function(data) {
                $("#div_content_contact_person_list").html(data);
            }
        })
        // Company Signatories
        $.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'id=' + compid + '&form=loadupdatecompany_signatories',
            success: function(data) {
                var arr = data.split("|");
                $("#tbodyCompSigList").html(arr[0]);
                if(arr[1] == 0){
                    $("#txtCompSigCount").val("1");
                }else{
                    $("#txtCompSigCount").val(arr[1]);
                }
            }
        })
    }

    function savenewmall_update(compid){
        $("#modal_company_name").button('loading');
        $(".div_company_contacts input").each(function(){
            $(this).css("border-color","#D5D5D5");
        })
        $("#div_well_contacts").css("border-color","#D5D5D5");
        $("#div_well_contact_persons").css("border-color","#D5D5D5");
        var e = 0;
        $(".text_reqcompany").each(function(){
            if($(this).val() == ""){
                e++;
                $(this).css("border-color","#f2a696");
            }else{
                $(this).css("border-color","#D5D5D5");
            }
        })
        var f = 0;
        $(".div_company_contacts input").each(function(){
            if($(this).val() != ""){
                f++;
            }
        });
        var sigcount = 0;
        $("#tbodyCompSigList tr").each(function(){
            if($(this).find(".tdFirstName").text() != "" || $(this).find(".tdMiddleName").text() != "" || $(this).find(".tdLastName").text() != ""){
                sigcount++;
            }
        })
        if(e == 0 && f != 0){
            var name = $("#txtcomp_name").val();
            var industry = $("#txtcomp_industry").val();
            var busadd = $("#txtcomp_busadd").val();
            var perm_add = $("#txtcomp_perm_add").val();
            var curr_add = $("#txtcomp_curr_add").val();
            var bill_add = $("#txtcomp_bill_add").val();
            var BillAccountName = $("#txtBillAccountName").val();
            var BillTel = $("#txtBillTelephone").val();
            var BillMobile = $("#txtBillMobile").val();
            var BillEmail = $("#txtBillEmail").val();
            var contact_mobile = "";
            $("#company_contact_mobile input").each(function(){
                var mob = $(this).val();
                if(!mob.match(/^\s*$/) || mob != ""){
                    contact_mobile += mob + "|";
                }
            });
            var contact_tele = "";
            $("#company_contact_tele input").each(function(){
                var tel = $(this).val();
                if(!tel.match(/^\s*$/) || tel != ""){
                    contact_tele += tel + "|";
                }
            });
            var contact_fax = "";
            $("#company_contact_fax input").each(function(){
                var fax = $(this).val();
                if(!fax.match(/^\s*$/) || fax != ""){
                    contact_fax += fax + "|";
                }
            });
            var contact_email = "";
            $("#company_contact_email input").each(function(){
                var email = $(this).val();
                if(!email.match(/^\s*$/) || email != ""){
                    contact_email += email + "|";
                }
            });
            var contact_website = "";
            $("#company_contact_website input").each(function(){
                var web = $(this).val();
                if(!web.match(/^\s*$/) || web != ""){
                    contact_website += web + "|";
                }
            });
            var Signatories = "";
            $("#tbodyCompSigList tr").each(function(){
                if($(this).find(".tdFirstName").text() != "" || $(this).find(".tdMiddleName").text() != "" || $(this).find(".tdLastName").text() != ""){
                    Signatories += $(this).find(".tdFirstName").text() + "@" + $(this).find(".tdMiddleName").text() + "@" + $(this).find(".tdLastName").text() + "|";
                }
            })
            $.ajax({
                type: 'POST',
                url: 'mainclass.php',
                data: 'name=' + name + '&industry=' + industry + '&busadd=' + busadd + '&perm_add=' + perm_add + '&curr_add=' + curr_add + '&bill_add=' + bill_add + '&contact_mobile=' + contact_mobile + '&contact_tele=' + contact_tele + '&contact_fax=' + contact_fax + '&contact_email=' + contact_email + '&contact_website=' + contact_website + '&id=' + compid + '&Signatories=' + Signatories + '&BillAccountName=' + BillAccountName + '&BillTel=' + BillTel + '&BillMobile=' + BillMobile + '&BillEmail=' + BillEmail + '&form=savenewmall_update',
                success: function(data){
                    $("#modal_company_name").button('reset');
                    var arr = data.split("|");
                    if(arr[1] == "1"){
                        setTimeout(function(){
                            showmodal("alert", "New company successfully updated.", "loadcompanylist", null, "", null, "0");
                        }, 1000)
                        $("#modal_new_company").modal("hide");
                        sendprofilepic(arr[0]);
                        $(".div_company_contacts input").each(function(){
                            $(this).css("border-color","#D5D5D5");
                        });                        
                        $("#div_well_contacts").css("border-color","#D5D5D5");
                        $("#div_well_contact_persons").css("border-color","#D5D5D5");
                    }else{
                        setTimeout(function(){
                            showmodal("alert", "Failed to update company", "", null, "", null, "1");
                        }, 1000)
                    }
                }
            })
        }else{
            $("#modal_company_name").button('reset');
            setTimeout(function(){
                showmodal("alert", "Fill all required fields!", "", null, "", null, "0");
            }, 1000)
            $('.text_reqcompany').each(function() {
                if ( this.value === '' ) {
                    this.focus();
                    return false;
                }
            });
            if(f == 0){
                $("#div_well_contacts").css("border-color","#f2a696");                
            }else{
                $("#div_well_contacts").css("border-color","#D5D5D5");
            }
            if(sigcount == 0){
                $("#div_CompSig").css("border-color","#f2a696"); 
            }else{
                $("#div_CompSig").css("border-color","#D5D5D5");
            }
        }
    }

    function modal_loadcompany(){
        $("#txt_userpage").val("1");
        loadcompanylist();
        loadindustry();
        loadmodalcompanyposition();
        $("#modal_loadcompany").modal("show");
    }

    function newcompany(){
        $("#modal_company_name").button('reset');
        $("#btn-save-contact-person").attr("onclick", "addcontactperson()");
        $(".home-address").each(function(){
            var this_id = $(this).attr("id");
            $(this).attr("onclick", "loadaddressmodal(\""+this_id+"\")")
        })
        $("#posting_profilepic").html('<div style="display: none"><input type="text" id="hidden_company_id" name="hidden_company_id"></div><input id="file_upload" name="attachment_profilepic" class="form-control upload" type="file" onchange="showimg();" accept="image/*"/>');
        $('#file_upload').ace_file_input({
            no_file:'No File ...',
            btn_choose:'Choose',
            btn_change:'Change',
            droppable:false,
            onchange:null,
            thumbnail:false
        });
        $("#imgaccount").attr("src", "assets/images/noimage5.png");
        $(".text_reqcompany").val("");
        $("#modal_new_company").modal("show");
        $("#modal_company_header").text("New Company");
        $("#modal_company_name").attr("onclick", "savenewmall()");
        $(".home-address").val("");
        $("#txtcontact_address").attr("onclick", "loadaddressmodal(\"txtcontact_address\")");
        $("#txtcontact_address").attr("onkeyup", "loadaddressmodal(\"txtcontact_address\")");
        $("#txtcontact_address").css("background-color", "white !important");
        $("#txtcontact_fname").val("");
        $("#txtcontact_mname").val("");
        $("#txtcontact_lname").val("");
        $("#txtcontact_designation").val("");
        $("#txtcontact_address").val("");
        $("#tbodyCompSigList").html("");
        $("#txtCompSigFN").val("");
        $("#txtCompSigMN").val("");
        $("#txtCompSigLN").val("");
        $("#txtBillAccountName").val("");
        $("#txtBillTelephone").val("");
        $("#txtBillMobile").val("");
        $("#txtBillEmail").val("");
        $("#txtcomp_perm_add").val("");
        $("#txtcomp_curr_add").val("");
        $("#txtcomp_bill_add").val("");
        $(".chkSameButton").prop("checked", false);
        $("#chkContactStatActive").prop("checked", true);
        var div_add_contact_person_email = "div_add_contact_person_email";
        var person_email = "emailaddress";
        var div_add_contact_person_mobile = "div_add_contact_person_mobile";
        var person_mobile = "input-mask-phone";
        var div_add_contact_person_tele = "div_add_contact_person_tele";
        var person_tele = "input-mask-tele";
        $("#div_add_contact_person_email").html("<div class='input-group'><input type='text' class='spinbox-input form-control email-address' placeholder='sample@yahoo.com'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success' onclick='div_add_field(\""+div_add_contact_person_email+"\", \""+person_email+"\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>");
        $("#div_add_contact_person_mobile").html("<div class='input-group'><input type='text' class='spinbox-input form-control input-mask-phone' maxlength='11' placeholder='(999)-999-9999'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success' onclick='div_add_field(\""+div_add_contact_person_mobile+"\", \""+person_mobile+"\")'> <i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>");
        $("#div_add_contact_person_tele").html("<div class='input-group'><input type='text' class='spinbox-input form-control input-mask-tele' placeholder='(99)-999-9999'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success' onclick='div_add_field(\""+div_add_contact_person_tele+"\", \""+person_tele+"\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>");
        $("#div_add_contact_person_email input").attr("style", "border-color:#D5D5D5 !important");
        $("#div_add_contact_person_mobile input").attr("style", "border-color:#D5D5D5 !important");
        $("#div_add_contact_person_tele input").attr("style", "border-color:#D5D5D5 !important");
        $('.save_contact_per').each(function() {
            if ( $(this).val() ==  "") {
                $(this).attr("style", "border-color:#D5D5D5 !important;background-color:white !important;");
            }
        });
        $("#div_well_contacts").css("border-color", "#D5D5D5");
        $("#div_well_contact_persons").css("border-color", "#D5D5D5");
        $(".text_reqcompany").css("border-color", "#D5D5D5");
        $("#company_contact_mobile").html('<input type="text" id="company_contact_mobile" class="spinbox-input form-control input-mask-phone" maxlength="11" placeholder="(999)-999-9999"><div class="spinbox-buttons input-group-btn"><button type="button" class="btn spinbox-up btn-sm btn-success" onclick="div_add_field(\'company_contact_mobile\', \'input-mask-phone\')"><i class="icon-only  ace-icon ace-icon fa fa-plus bigger-110"></i></button></div>');
        $("#company_contact_tele").html('<input type="text" id="company_contact_tele" class="spinbox-input form-control input-mask-tele" placeholder="(99)-999-9999"> <div class="spinbox-buttons input-group-btn"><button type="button" class="btn spinbox-up btn-sm btn-success" onclick="div_add_field(\'company_contact_tele\', \'input-mask-tele\')"><i class="icon-only  ace-icon ace-icon fa fa-plus bigger-110"></i></button></div>');
        $("#company_contact_fax").html('<input type="text" id="company_contact_fax" class="spinbox-input form-control input-mask-tele" placeholder="(99)-999-9999"><div class="spinbox-buttons input-group-btn"><button type="button" class="btn spinbox-up btn-sm btn-success" onclick="div_add_field(\'company_contact_fax\', \'input-mask-tele\')"><i class="icon-only ace-icon ace-icon fa fa-plus bigger-110"></i></button></div>');
        $("#company_contact_email").html('<input type="text" id="company_contact_email" onkeyup="" class="spinbox-input form-control email-address" placeholder="sample@yahoo.com"><div class="spinbox-buttons input-group-btn"><button type="button" class="btn spinbox-up btn-sm btn-success" onclick="div_add_field(\'company_contact_email\', \'emailaddress\')"><i class="icon-only  ace-icon ace-icon fa fa-plus bigger-110"></i></button></div>');
        $("#company_contact_website").html('<input type="text" id="company_contact_website" class="spinbox-input form-control website-input" placeholder="www.sample.com"><div class="spinbox-buttons input-group-btn"><button type="button" class="btn spinbox-up btn-sm btn-success" onclick="div_add_field(\'company_contact_website\', \'website\')"><i class="icon-only ace-icon ace-icon fa fa-plus bigger-110"></i></button></div>');
        $("#div_content_contact_person_list").html("");
        $("#txtcontact_fname").val("");
        autotrapfields();
    }

    function selectthiscompanyforref(this_company, BillerID){
        $.ajax({
            type: 'POST',
            url: 'include/class.php',
            data: 'companyid=' + this_company + '&form=selectthiscompanyforref',
            success: function(data){
                var arr = data.split("|");
                $("#txtTradeCompanyName").val(arr[1]);
                $("#txtTradeIndustry").val(arr[2]);
                $("#txtTradeAddress").val(arr[3]);
                $("#txtTradeCompanyID").val(this_company);
                $("#txtTradeBillFName").val(arr[4]);
                $("#txtTradeBillMName").val(arr[5]);
                $("#txtTradeBillLName").val(arr[6]);
                $("#txtTradeBillAddress").val(arr[7]);
                $("#modal_loadcompany").modal("hide");
            }, complete: function(){
                fncclickBillProfile(BillerID)
            }
        })
    }

    function chkmobiledup(divthis, this_text){
        if(divthis == "company_contact_mobile"){
            var prompt_alert = "mobile number";
        }
        if(divthis == "company_contact_tele"){
            var prompt_alert = "telephone number";
        }
        if(divthis == "company_contact_fax"){
            var prompt_alert = "fax number";
        }
        if(divthis == "company_contact_email"){
            var prompt_alert = "email address";
        }
        if(divthis == "company_contact_website"){
            var prompt_alert = "website";
        }
        if(divthis == "div_add_contact_person_email" || divthis == "div_add_contact_person_email_update"){
            var prompt_alert = "email address";
        }
        if(divthis == "div_add_contact_person_mobile" || divthis == "div_add_contact_person_mobile_update"){
            var prompt_alert = "mobile number";
        }
        if(divthis == "div_add_contact_person_tele" || divthis == "div_add_contact_person_tele_update"){
            var prompt_alert = "telephone number";
        }
        var existing = "";
        $("#"+ divthis +" :input").each(function(){
            var mob = $(this).val();
            if(mob != ""){
                existing += mob + "|";
            }
        });
        var arr = existing.split("|");
        var i = 0;
        var c = 0;
        var etoyun = this_text.val();
        for(i=0; i<=arr.length-1; i++){
            if(etoyun == arr[i]){
                c++;
            }
        }
        if(c >= 2){
            setTimeout(function(){
                showmodal("alert", "Sorry, but you already entered the same"+prompt_alert, "", null, "", null, "1");
            }, 1000)
            this_text.val("");
            this_text.focus();
        }
    }

    function autotrapfields() {
        $('.email-address').each(function(){
            var getid = $(this).attr("id");
            $(this).focusout(function() {
                chkmobiledup(getid, $(this))
                var sEmail = $(this).val();
                if($.trim(sEmail).length == 0){
                    e.preventDefault();
                }
                if(validateEmail(sEmail)){
                    
                }else{
                    showmodal("alert", "Invalid Email Address", "", null, "", null, "1");
                    $(this).val("");
                    e.preventDefault();
                }
            });
        });
        $('.website-input').each(function(){
            var getid = $(this).attr("id");
            $(this).focusout(function() {
                chkmobiledup(getid, $(this))
                var sEmail = $(this).val();
                if($.trim(sEmail).length == 0){
                    e.preventDefault();
                }
                if(validatWebsite(sEmail)){
                    
                }else{
                    showmodal("alert", "Invalid website", "", null, "", null, "1");
                    $(this).val("")
                    e.preventDefault();
                }
            });
        });
        $.mask.definitions['~']='[+-]';
        $('.input-mask-date').mask('99/99/9999', {placeholder:" ",completed:function(){var idselected = $(this).attr("id");  chkmobiledup(idselected, $(this))}});
        $('.input-mask-phone').mask('(999) 999-9999', {placeholder:" ",completed:function(){var idselected = $(this).attr("id");  chkmobiledup(idselected, $(this))}});
        $('.input-mask-tele').mask('', {placeholder:" ",completed:function(){var idselected = $(this).attr("id");  chkmobiledup(idselected, $(this))}});
        $('.input-mask-eyescript').mask('~9.99 ~9.99 999');
        $(".input-mask-product").mask("a*-999-a999",{placeholder:" ",completed:function(){alert("You typed the following: "+this.val());}});
        $(".input-mask-tele").on('keypress', function (event) {
        var regex = new RegExp("^[-+() 0-9]+");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
            if (!regex.test(key)) {
                event.preventDefault();
                return false;
            }
        });
        $('.upload_app_req').ace_file_input({
            no_file:'No File ...',
            btn_choose:'Choose',
            btn_change:'Change',
            droppable:false,
            onchange:null,
            thumbnail:false
        });
        $('.upload').ace_file_input({
            no_file:'No File ...',
            btn_choose:'Choose',
            btn_change:'Change',
            droppable:false,
            onchange:null,
            thumbnail:false
        });
    }

    function addcontactperson_update(compid){
        var aff = "";
        var contact_firstname = $("#txtcontact_fname").val();
        var contact_middlename = $("#txtcontact_mname").val();
        var contact_lastname = $("#txtcontact_lname").val();
        var contact_designation = $("#txtcontact_designation").val();
        var contact_address = $("#txtcontact_address").val();
        var div_add_contact_person_email = "";
        $("#div_add_contact_person_email input").each(function(){
            var value = $(this).val();
            if(!value.match(/^\s*$/)){
                div_add_contact_person_email += value + "|";
            }
        });
        var div_add_contact_person_mobile = "";
        $("#div_add_contact_person_mobile input").each(function(){
            var value = $(this).val();
            if(!value.match(/^\s*$/)){
                div_add_contact_person_mobile += value + "|";
            }
        });
        var div_add_contact_person_tele = "";
        $("#div_add_contact_person_tele input").each(function(){
            var value = $(this).val();
            if(!value.match(/^\s*$/)){
                div_add_contact_person_tele += value + "|";
            }
        });
        var i = 0;
        $("div .div_contact_person").each(function(){
            i++;
        });
        var idimg = "imgaccount_"+i;
        var fileimg = "file_upload"+i;
        var fileform = "posting_profilepic"+i;
        var div_add_contact_person_email_a = "";
        $("#div_add_contact_person_email input").each(function(){
            var value = $(this).val();
            if(!value.match(/^\s*$/)){
                div_add_contact_person_email_a += "<p style='font-size: 10px; font-weight: normal;margin: 0px !important;font-style: underline;' class='contact_person_emailadd'>" + value + "</p>";
            }
        });
        var div_add_contact_person_mobile_a = "";
        $("#div_add_contact_person_mobile input").each(function(){
            var value = $(this).val();
            if(!value.match(/^\s*$/)){
                div_add_contact_person_mobile_a += "<p style='font-size: 12px; font-weight: normal;font-style: italic;margin: 0px !important;' class='contact_person_mobno'>" + value + "</p>";
            }
        });
        var div_add_contact_person_tele_a = "";
        $("#div_add_contact_person_tele input").each(function(){
            var value = $(this).val();
            if(!value.match(/^\s*$/)){
                div_add_contact_person_tele_a += "<p style='font-size: 12px; font-weight: normal;font-style: italic;margin: 0px !important;' class='contact_person_telno'>" + value + "</p>";
            }
        });
        var AsPrimary = "";
        $("#chkAsPrimary").each(function(){
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
        $(".rdContactStat").each(function(){
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
        if((contact_firstname != "" && !contact_firstname.match(/^\s*$/)) && (contact_lastname != "" && !contact_lastname.match(/^\s*$/)) && (contact_designation != "" && !contact_designation.match(/^\s*$/)) && (contact_address != "" && !contact_address.match(/^\s*$/)) && (div_add_contact_person_email != "" || div_add_contact_person_mobile != "" || div_add_contact_person_tele != "") ){
            $.ajax({
                type: 'POST',
                url: 'mainclass.php',
                data: 'id=' + compid + '&contact_firstname=' + contact_firstname + '&contact_middlename=' + contact_middlename + '&contact_lastname=' + contact_lastname + '&contact_designation=' + contact_designation + '&contact_address=' + contact_address + '&person_email=' + div_add_contact_person_email + '&person_mobile=' + div_add_contact_person_mobile + '&person_tele=' + div_add_contact_person_tele + '&form=addcontactperson_update',
                success: function(data){
                    var arr = data.split("|");
                    if(arr[0] == "1"){
                        aff += "<div class='col-md-4'><div class='alert alert-info div_contact_person save_this_div' id='contact_"+arr[1]+"'><div class='tools tools-left in'><a href='#' title='Edit Photo' class='btnedit' style='float:right;margin-bottom:8px;margin-top:8px;' onclick='editthiscontactperson(\""+arr[1]+"\", \""+compid+"\")'><i class='ace-icon fa fa-pencil'></i></a><a href='#' title='Remove Photo' class='btndelete' style='float:right;margin-right:5px;margin-bottom:8px;margin-top:8px;' onclick='removethiscontactperson(\""+arr[1]+"\")'><i class='ace-icon fa fa-times red'></i></a></div><center><div class='image'><img class='img-thumbnail imageName form-control' src='assets/images/noimage5.png' id='div_add_new_contact_per_edit' style='border: 2px solid #bdc3c7; margin-bottom: 8px;height: 160px;width:90%;'></div><form name='posting_profilepic_addnew_"+arr[1]+"' id='posting_profilepic_addnew_"+arr[1]+"' class='posting_profilepic'><div style='display:none;'><input type='text' name='contactID' id='txtcon_person_addnew_"+arr[1]+"' class='txtcon_person'><input type='text' name='companyID' id='txtcon_company_addnew_"+arr[1]+"' class='txtcon_company'></div><input id='posting_profilepic_addnew_input_"+arr[1]+"' name='file_upload_trade_update' class='form-control upload_app_req' type='file' onchange='showimg3(\"div_add_new_contact_per_edit\",\"posting_profilepic_addnew_input_"+arr[1]+"\", \""+arr[1]+"\", \""+compid+"\");' /></form></center><label style='font-size: 14px; font-weight: bold;margin: 0px !important;' class='contact_person_firstname'>"+contact_firstname+" </label>&nbsp;<label style='font-size: 14px; font-weight: bold;margin: 0px !important;' class='contact_person_middlename'>"+contact_middlename+"</label>&nbsp;<label style='font-size: 14px; font-weight: bold;margin: 0px !important;' class='contact_person_lastname'>"+contact_lastname+"</label><p style='font-size: 14px; font-weight: normal;margin: 0px !important;' class='contact_person_designation'>"+contact_designation+"</p><p style='font-size: 10px; font-weight: normal;margin: 0px !important;' class='address_person'>"+contact_address+"</p>"+div_add_contact_person_email_a+""+div_add_contact_person_mobile_a+""+div_add_contact_person_tele_a+"</div></div>";
                        $("#txtcontact_address").attr("onclick", "loadaddressmodal(\"txtcontact_address\")");
                        $("#txtcontact_address").attr("onkeyup", "loadaddressmodal(\"txtcontact_address\")");
                        $( aff ).appendTo( "#div_content_contact_person_list" );
                        $("#txtcontact_address").css("background-color", "white !important");
                        $("#txtcontact_fname").val("");
                        $("#txtcontact_mname").val("");
                        $("#txtcontact_lname").val("");
                        $("#txtcontact_designation").val("");
                        $("#txtcontact_address").val("");
                        var div_add_contact_person_email = "div_add_contact_person_email";
                        var person_email = "emailaddress";
                        var div_add_contact_person_mobile = "div_add_contact_person_mobile";
                        var person_mobile = "input-mask-phone";
                        var div_add_contact_person_tele = "div_add_contact_person_tele";
                        var person_tele = "input-mask-tele";
                        $("#div_add_contact_person_email").html("<div class='input-group'><input type='text' class='spinbox-input form-control email-address'  placeholder='sample@yahoo.com'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success' onclick='div_add_field(\""+div_add_contact_person_email+"\", \""+person_email+"\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>");
                        $("#div_add_contact_person_mobile").html("<div class='input-group'><input type='text' class='spinbox-input form-control input-mask-phone' maxlength='11' placeholder='(999)-999-9999'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success' onclick='div_add_field(\""+div_add_contact_person_mobile+"\", \""+person_mobile+"\")'> <i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>");
                        $("#div_add_contact_person_tele").html("<div class='input-group'><input type='text' class='spinbox-input form-control input-mask-tele' placeholder='(99)-999-9999'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success' onclick='div_add_field(\""+div_add_contact_person_tele+"\", \""+person_tele+"\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>");
                        $("#div_add_contact_person_email input").attr("style", "border-color:#D5D5D5 !important");
                        $("#div_add_contact_person_mobile input").attr("style", "border-color:#D5D5D5 !important");
                        $("#div_add_contact_person_tele input").attr("style", "border-color:#D5D5D5 !important");
                        $('.save_contact_per').each(function() {
                            if($(this).val() == ""){
                                $(this).attr("style", "border-color:#D5D5D5 !important;background-color:white !important;");
                            }
                        });
                    }else{
                        setTimeout(function(){
                            showmodal("alert", "This contact person is already existing.", "", null, "", null, "1");
                        }, 1000)
                        $("#div_add_contact_person_email input").attr("style", "border-color:#f2a696 !important");
                        $("#div_add_contact_person_mobile input").attr("style", "border-color:#f2a696 !important");
                        $("#div_add_contact_person_tele input").attr("style", "border-color:#f2a696 !important");
                        $('.save_contact_per').each(function(){
                            $(this).attr("style", "border-color:#f2a696 !important;background-color:white !important;");
                        });
                        $('.save_contact_per').each(function(){
                            this.focus();
                            return false;
                        });
                    }
                }, complete: function(){
                    autotrapfields();
                }
            })
        }else{
            if(div_add_contact_person_email == "" && div_add_contact_person_mobile == "" && div_add_contact_person_tele == ""){
                setTimeout(function(){
                    showmodal("alert", "Please enter atleast one contact information, and fill other required information.", "", null, "", null, "1");
                }, 1000)
                $("#div_add_contact_person_email input").attr("style", "border-color:#f2a696 !important");
                $("#div_add_contact_person_mobile input").attr("style", "border-color:#f2a696 !important");
                $("#div_add_contact_person_tele input").attr("style", "border-color:#f2a696 !important");
                $(".save_contact_per").each(function(){
                    if($(this).val() == ""){
                        $(this).attr("style", "border-color:#f2a696 !important;background-color:white !important;");
                    }
                });
                $('.save_contact_per').each(function(){
                    if(this.value === ''){
                        this.focus();
                        return false;
                    }
                });
            }else{
                setTimeout(function(){
                    showmodal("alert", "Fill all required fields.", "", null, "", null, "1");
                }, 1000)
                $('.save_contact_per').each(function(){
                    if($(this).val() ==  ""){
                        $(this).attr("style", "border-color:#f2a696 !important;background-color:white !important;");
                    }
                });
                $('.save_contact_per').each(function(){
                    if(this.value === ''){
                        this.focus();
                        return false;
                    }
                });
            }
        }
    }

    function validateEmail(sEmail) {
        var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if(filter.test(sEmail)){
            return true;
        }else{
            return false;
        }
    }

    function validatWebsite(sEmail) {
        var filter = /www.((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if(filter.test(sEmail)){
            return true;
        }else{
            return false;
        }
    }

    function loadindustry(){
        $.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'form=loadindustry',
            success: function(data){
                $("#txtcomp_industry").html(data);
            }
        })
    }

    function loadmodalcompanyposition(){
        $.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'form=loadcompanyposition',
            success: function(data){
                $(".slctPosition").html(data);
            }
        })
    }

    function showimg(){
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("file_upload").files[0]);
        oFReader.onload = function(oFREvent){
            document.getElementById("imgaccount").src = oFREvent.target.result;
        };
    }

    function savenewmall(){
        $("#modal_company_name").button('loading');
        $(".div_company_contacts input").each(function(){
            $(this).css("border-color","#D5D5D5");
        });
        $("#div_well_contacts").css("border-color","#D5D5D5");
        $("#div_well_contact_persons").css("border-color","#D5D5D5");
        var RequiredCount = 0;
        $(".text_reqcompany").each(function(){
            if($(this).val() == ""){
                RequiredCount++;
                $(this).css("border-color","#f2a696");
            }else{
                $(this).css("border-color","#D5D5D5");
            }
        });
        var RequireMobile = 0;
        $(".div_company_contacts #company_contact_mobile").each(function(){
            if($(this).val() != ''){
                RequireMobile++;
            }
        })
        if(RequireMobile == 0){
            $("#company_contact_mobile input").css("border-color","#f2a696");
        }else{
            $("#company_contact_mobile input").css("border-color","#D5D5D5");
        }
        var RequireTelephone = 0;
        $(".div_company_contacts #company_contact_tele").each(function(){
            if($(this).val() != ''){
                RequireTelephone++;
            }
        })
        if(RequireTelephone == 0){
            $("#company_contact_tele input").css("border-color","#f2a696");
        }else{
            $("#company_contact_tele input").css("border-color","#D5D5D5");
        }
        var i = 0;
        $("#div_content_contact_person_list .div_contact_person").each(function(){
            i++;
        });
        var sigcount = 0;
        $("#tbodyCompSigList tr").each(function(){
            if($(this).find(".tdFirstName").text() != "" || $(this).find(".tdMiddleName").text() != "" || $(this).find(".tdLastName").text() != ""){
                sigcount++;
            }
        })
        if(RequiredCount == 0 && RequireTelephone != 0 && RequireTelephone != 0){
            var name = $("#txtcomp_name").val();
            var industry = $("#txtcomp_industry").val();
            var fname = $("#txtcomp_fname").val();
            var busadd = $("#txtcomp_busadd").val();
            var perm_add = $("#txtcomp_perm_add").val();
            var curr_add = $("#txtcomp_curr_add").val();
            var bill_add = $("#txtcomp_bill_add").val();
            var BillAccountName = $("#txtBillAccountName").val();
            var BillTel = $("#txtBillTelephone").val();
            var BillMobile = $("#txtBillMobile").val();
            var BillEmail = $("#txtBillEmail").val();
            var contact_mobile = "";
            $("#company_contact_mobile input").each(function(){
                var mob = $(this).val();
                if(!mob.match(/^\s*$/) || mob != ""){
                    contact_mobile += mob + "|";
                }
            });
            var contact_tele = "";
            $("#company_contact_tele input").each(function(){
                var tel = $(this).val();
                if(!tel.match(/^\s*$/) || tel != ""){
                    contact_tele += tel + "|";
                }
            });
            var contact_fax = "";
            $("#company_contact_fax input").each(function(){
                var fax = $(this).val();
                if(!fax.match(/^\s*$/) || fax != ""){
                    contact_fax += fax + "|";
                }
            });
            var contact_email = "";
            $("#company_contact_email input").each(function(){
                var email = $(this).val();
                if(!email.match(/^\s*$/) || email != ""){
                    contact_email += email + "|";
                }
            });
            var contact_website = "";
            $("#company_contact_website input").each(function(){
                var web = $(this).val();
                if(!web.match(/^\s*$/) || web != ""){
                    contact_website += web + "|";
                }
            });
            var Signatories = "";
            $("#tbodyCompSigList tr").each(function(){
                if($(this).find(".tdFirstName").text() != "" || $(this).find(".tdMiddleName").text() != "" || $(this).find(".tdLastName").text() != ""){
                    Signatories += $(this).find(".tdFirstName").text() + "@" + $(this).find(".tdMiddleName").text() + "@" + $(this).find(".tdLastName").text() + "|";
                }
            })
            $.ajax({
                type: 'POST',
                url: 'mainclass.php',
                data: 'name=' + name + '&industry=' + industry + '&busadd=' + busadd + '&perm_add=' + perm_add + '&curr_add=' + curr_add + '&bill_add=' + bill_add + '&contact_mobile=' + contact_mobile + '&contact_tele=' + contact_tele + '&contact_fax=' + contact_fax + '&contact_email=' + contact_email + '&contact_website=' + contact_website + '&Signatories=' + Signatories + '&BillAccountName=' + BillAccountName + '&BillTel=' + BillTel + '&BillMobile=' + BillMobile + '&BillEmail=' + BillEmail + '&form=savenewmall',
                success: function(data){
                    $("#modal_company_name").button('reset');
                    var arr = data.split("|");
                    if(arr[1] == "1"){
                        setTimeout(function(){
                            showmodal("alert", "New company successfully saved.", "fncNewCompanySuccess", null, "", null, "0");
                        }, 1000)
                        sendprofilepic(arr[0]);
                        if(arr[2] != ''){
                            savecontactpersons(arr[2]);
                        }
                        $(".div_company_contacts input").each(function(){
                            $(this).css("border-color","#D5D5D5");
                        });
                        $("#div_well_contacts").css("border-color","#D5D5D5");
                        $("#div_well_contact_persons").css("border-color","#D5D5D5");                        
                    }else{
                        setTimeout(function(){
                            showmodal("alert", "Failed to save new company", "", null, "", null, "1");
                        }, 1000)
                    }
                }
            })
        }else{
            $("#modal_company_name").button('reset');
            setTimeout(function(){
                showmodal("alert", "Fill all required fields!", "", null, "", null, "1");
            }, 1000)
            $('.text_reqcompany').each(function() {
                if(this.value === ''){
                    this.focus();
                    return false;
                }
            });
            if(i == 0){
                $("#div_well_contact_persons").css("border-color","#f2a696"); 
            }else{
                $("#div_well_contact_persons").css("border-color","#D5D5D5");
            }
            if(sigcount == 0){
                $("#div_CompSig").css("border-color","#f2a696"); 
            }else{
                $("#div_CompSig").css("border-color","#D5D5D5");
            }
        }
    }

    function fncNewCompanySuccess(){
        $("#modal_new_company").modal("hide");
        loadcompanylist();
    }

    function savecontactpersons(compID){
        var i = 0;
        var e = 0;
        $("#div_content_contact_person_list .div_contact_person").each(function(){
            i++;
        });
        if(i == 0){
            // $("#modal_new_company").modal("hide");
            $("#div_content_contact_person_list").html("");
            loadcompanylist();
        }else{
            $("#div_content_contact_person_list .div_contact_person").each(function(){
                var isPrimary = $(this).find(".isPrimary");
                var isActive = $(this).find(".isActive");
                var firstname = $(this).find(".contact_person_firstname");
                var middlename = $(this).find(".contact_person_middlename");
                var lastname = $(this).find(".contact_person_lastname");
                var designation = $(this).find(".contact_person_designation");
                var address = $(this).find(".address_person");
                var email = $(this).find(".contact_person_emailadd");
                var mobile = $(this).find(".contact_person_mobno");
                var tele = $(this).find(".contact_person_telno");
                var form = $(this).find(".posting_profilepic");
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
                    data: 'id=' + compID + '&firstname_val=' + firstname_val + '&middlename_val=' + middlename_val + '&lastname_val=' + lastname_val + '&designation_val=' + designation_val + '&address_val=' + address_val + '&email_string=' + email_string + '&mobile_string=' + mobile_string + '&tele_string=' + tele_string + '&isPrimary=' + isPrimary_val + '&isActive=' + isActive_val + '&form=savecontactpersons',
                    success: function(data){
                        e++;
                        sendcontactpic(data, formselected, compID, i, e);
                    }
                })
            });
        }
    }

    function sendcontactpic(contactID, form, compid, i, e){
        $(".txtcon_person").val(contactID);
        $(".txtcon_company").val(compid);
        var data = new FormData($('#'+form)[0]);
        $.ajax({
            type: 'POST',
            url: 'Uploads/upload_app_contact.php',
            data: data,
            mimeType: 'multipart/form-data',
            contentType: false,
            cache: false,
            processData: false,
            success:function(data){
                
            }
        });
    }

    function sendprofilepic(custid){
        $("#hidden_company_id").val(custid);
        var data = new FormData($('#posting_profilepic')[0]);
        $.ajax({
            type:"POST",
            url:"Uploads/upload_app_profile.php",
            data: data,
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            success:function(data){
              
            }
        });
    }

    function removestr(str, del){
        var arr = str.split(del);
        for(var i = 0; i<arr.length; i++){
            str = str.replace(del, "");
        }
        return str;
    }

    function div_add_field(div, format){
        var div_addtel_owner = "";
        var i = 0;
        if(format == "emailaddress"){
            $("#"+div+" input").each(function(){
                var value = $(this).val();
                if(/(.+)@(.+){2,}\.(.+){2,}/.test(value)){
                    if(!value.match(/^\s*$/)){
                        div_addtel_owner += "<input type='text' id='"+div+"' class='form-control "+format+"' value='"+value+"' style='margin-bottom:5px;'>";
                    }else{
                        i++;
                    }
                }else{
                    $(this).val("");
                    i++;
                }
            });
        }else if(format == "website"){
            $("#"+div+" input").each(function(){
                var value = $(this).val();
                if( /www(.+){2,}\.(.+){2,}/.test(value) ){
                    if (!value.match(/^\s*$/)) {
                        div_addtel_owner += "<input type='text' id='"+div+"' class='form-control "+format+"' value='"+value+"' style='margin-bottom:5px;'>";
                    }else{
                        i++;
                    }
                }else{
                    $(this).val("");
                    i++;
                }
            });
        }else{
            $("#"+div+" input").each(function(){
                var value = $(this).val();
                if (!value.match(/^\s*$/)) {
                    div_addtel_owner += "<input type='text' id='"+div+"' class='form-control "+format+"' value='"+value+"' style='margin-bottom:5px;'>";
                }else{
                    i++;
                }
            });
        }

        if(i == 0){
            if(format == "input-mask-phone"){
                div_addtel_owner += "<div class='input-group' style='width:100%;'><input type='text' id='"+div+"' class='spinbox-input form-control "+format+"' placeholder='(999)-999-9999'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success' onclick='div_add_field(\""+div+"\",\""+format+"\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>";
            }
            if(format == "input-mask-tele"){
                div_addtel_owner += "<div class='input-group' style='width:100%;'><input type='text' id='"+div+"' class='spinbox-input form-control "+format+"' placeholder='(99)-999-9999'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success' onclick='div_add_field(\""+div+"\",\""+format+"\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>";
            }
            if(format == "emailaddress"){
                div_addtel_owner += "<div class='input-group' style='width:100%;'><input type='text' id='"+div+"' class='spinbox-input form-control email-address "+format+"' placeholder='sample@yahoo.com'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success' onclick='div_add_field(\""+div+"\",\""+format+"\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>";
            }
            if(format == "website"){
                div_addtel_owner += "<div class='input-group' style='width:100%;'><input type='text' id='"+div+"' class='spinbox-input form-control website-input "+format+"' placeholder='www.sample.com'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success' onclick='div_add_field(\""+div+"\",\""+format+"\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>";
            }
        }else{
            if(format == "input-mask-phone"){
                div_addtel_owner += "<div class='input-group' style='width:100%;'><input type='text' id='"+div+"' class='spinbox-input form-control "+format+"' style='border-color:#f2a696;' placeholder='(999)-999-9999'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success' onclick='div_add_field(\""+div+"\",\""+format+"\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>";
            }
            if(format == "input-mask-tele"){
                div_addtel_owner += "<div class='input-group' style='width:100%;'><input type='text' id='"+div+"' class='spinbox-input form-control "+format+"' style='border-color:#f2a696;' placeholder='(99)-999-9999'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success' onclick='div_add_field(\""+div+"\",\""+format+"\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>";
            }
            if(format == "emailaddress"){
                div_addtel_owner += "<div class='input-group' style='width:100%;'><input type='text' id='"+div+"' class='spinbox-input form-control email-address "+format+"' style='border-color:#f2a696;' placeholder='sample@yahoo.com'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success' onclick='div_add_field(\""+div+"\",\""+format+"\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>";

                $("#div_add_contact_person_email :input").each(function(){
                    $(this).focusout(function(){
                        chkmobiledup('div_add_contact_person_email', $(this));
                    });
                });
            }
            if(format == "website"){
                div_addtel_owner += "<div class='input-group' style='width:100%;'><input type='text' id='"+div+"' class='spinbox-input form-control website-input "+format+"' style='border-color:#f2a696;' placeholder='www.sample.com'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success' onclick='div_add_field(\""+div+"\",\""+format+"\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>";
            }
            setTimeout(function(){
                showmodal("alert", "Fill the field first with correct format required to add more.", "", null, "", null, "1");
            }, 1000)
        }
        $("#"+div).html(div_addtel_owner);
        autotrapfields();
    }

    function addcontactperson(){
        var aff = "";
        var contact_firstname = $("#txtcontact_fname").val();
        var contact_middlename = $("#txtcontact_mname").val();
        var contact_lastname = $("#txtcontact_lname").val();
        var contact_designation = $("#txtcontact_designation").val();
        var contact_address = $("#txtcontact_address").val();
        var AsPrimary = "";
        $("#chkAsPrimary").each(function(){
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
        $(".rdContactStat").each(function(){
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
        var div_add_contact_person_email = "";
        $("#div_add_contact_person_email input").each(function(){
            var value = $(this).val();
            if(!value.match(/^\s*$/)){
                div_add_contact_person_email += "<p style='font-size: 10px; font-weight: normal;margin: 0px !important;font-style: underline;' class='contact_person_emailadd'>" + value + "</p>";
            }
        });
        var div_add_contact_person_mobile = "";
        $("#div_add_contact_person_mobile input").each(function(){
            var value = $(this).val();
            if(!value.match(/^\s*$/)){
                div_add_contact_person_mobile += "<p style='font-size: 12px; font-weight: normal;font-style: italic;margin: 0px !important;' class='contact_person_mobno'>" + value + "</p>";
            }
        });
        var div_add_contact_person_tele = "";
        $("#div_add_contact_person_tele input").each(function(){
            var value = $(this).val();
            if(!value.match(/^\s*$/)){
                div_add_contact_person_tele += "<p style='font-size: 12px; font-weight: normal;font-style: italic;margin: 0px !important;' class='contact_person_telno'>" + value + "</p>";
            }
        });
        var i = 0;
        $("div .div_contact_person").each(function(){
            i++;
        });
        var idimg = "imgaccount_"+i;
        var fileimg = "file_upload"+i;
        var fileform = "posting_profilepic"+i;
        aff += "<div class='col-md-4'><div class='alert alert-"+ isActive +" div_contact_person save_this_div'>"+ AsPrimary +"<center><input type='hidden' class='isPrimary' value='"+ isPrimary +"'><input type='hidden' class='isActive' value='"+ isActive2 +"'><div class='image'><img class='img-thumbnail imageName form-control' src='assets/images/noimage5.png' id='"+idimg+"' style='border: 2px solid #bdc3c7; margin-bottom: 8px;height: 160px;width:90%;'></div><form name='posting_profilepic' id='"+fileform+"' class='posting_profilepic'><div style='display:none;'><input type='text' name='txtcon_person' class='txtcon_person'><input type='text' name='txtcon_company' class='txtcon_company'></div><input id='"+fileimg+"' name='attachment_profilepic' class='form-control upload_app_req' type='file' onchange='showimg2(\""+idimg+"\",\""+fileimg+"\");' /></form></center><label style='font-size: 14px; font-weight: bold;margin: 0px !important;' class='contact_person_firstname'>"+contact_firstname+" </label>&nbsp;<label style='font-size: 14px; font-weight: bold;margin: 0px !important;' class='contact_person_middlename'>"+contact_middlename+"</label>&nbsp;<label style='font-size: 14px; font-weight: bold;margin: 0px !important;' class='contact_person_lastname'>"+contact_lastname+"</label><p style='font-size: 14px; font-weight: normal;margin: 0px !important;' class='contact_person_designation'>"+contact_designation+"</p><p style='font-size: 10px; font-weight: normal;margin: 0px !important;' class='address_person'>"+contact_address+"</p>"+div_add_contact_person_email+""+div_add_contact_person_mobile+""+div_add_contact_person_tele+"</div></div>";
        if((contact_firstname != "" && !contact_firstname.match(/^\s*$/)) && (contact_lastname != "" && !contact_lastname.match(/^\s*$/)) && (contact_designation != "" && !contact_designation.match(/^\s*$/)) && (contact_address != "" && !contact_address.match(/^\s*$/)) && (div_add_contact_person_email != "" || div_add_contact_person_mobile != "" || div_add_contact_person_tele != "") ){
            $( aff ).appendTo( "#div_content_contact_person_list" );
            $("#txtcontact_fname").val("");
            $("#txtcontact_mname").val("");
            $("#txtcontact_lname").val("");
            $("#txtcontact_designation").val("");
            $("#txtcontact_address").val("");
            $("#chkAsPrimary").prop("checked", false);
            $("#chkContactStatActive").prop("checked", true);
            var div_add_contact_person_email = "div_add_contact_person_email";
            var person_email = "emailaddress";
            var div_add_contact_person_mobile = "div_add_contact_person_mobile";
            var person_mobile = "input-mask-phone";
            var div_add_contact_person_tele = "div_add_contact_person_tele";
            var person_tele = "input-mask-tele";
            $("#div_add_contact_person_email").html("<div class='input-group'><input type='text' class='spinbox-input form-control' placeholder='sample@yahoo.com'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success' onclick='div_add_field(\""+div_add_contact_person_email+"\", \""+person_email+"\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>");
            $("#div_add_contact_person_mobile").html("<div class='input-group'><input type='text' class='spinbox-input form-control input-mask-phone' maxlength='11' placeholder='(999)-999-9999'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success' onclick='div_add_field(\""+div_add_contact_person_mobile+"\", \""+person_mobile+"\")'> <i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>");
            $("#div_add_contact_person_tele").html("<div class='input-group'><input type='text' class='spinbox-input form-control input-mask-tele'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success' onclick='div_add_field(\""+div_add_contact_person_tele+"\", \""+person_tele+"\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>");
            $("#div_add_contact_person_email input").attr("style", "border-color:#D5D5D5 !important");
            $("#div_add_contact_person_mobile input").attr("style", "border-color:#D5D5D5 !important");
            $("#div_add_contact_person_tele input").attr("style", "border-color:#D5D5D5 !important");
            $('.save_contact_per').each(function(){
                if($(this).val() == ""){
                    $(this).attr("style", "border-color:#D5D5D5 !important");
                }
            });
        }else{
            if(div_add_contact_person_email == "" && div_add_contact_person_mobile == "" && div_add_contact_person_tele == ""){
                setTimeout(function(){
                    showmodal("alert", "Please enter atleast one contact information, and fill other required information.", "", null, "", null, "1");
                }, 1000)
                $("#div_add_contact_person_email input").attr("style", "border-color:#f2a696 !important");
                $("#div_add_contact_person_mobile input").attr("style", "border-color:#f2a696 !important");
                $("#div_add_contact_person_tele input").attr("style", "border-color:#f2a696 !important");
                $(".save_contact_per").each(function(){
                    if ( $(this).val() == ""){
                        $(this).attr("style", "border-color:#f2a696 !important");
                    }
                });
                $('.save_contact_per').each(function(){
                    if(this.value === ''){
                        this.focus();
                        return false;
                    }
                });
            }else{
                setTimeout(function(){
                    showmodal("alert", "Fill all required fields.", "", null, "", null, "1");
                }, 1000)
                $('.save_contact_per').each(function(){
                    if($(this).val() ==  ""){
                        $(this).attr("style", "border-color:#f2a696 !important");
                    }
                });
                $('.save_contact_per').each(function(){
                    if(this.value === ''){
                        this.focus();
                        return false;
                    }
                });
            }
        }
        autotrapfields();
    }

    function showimg2(imgid, fileid){
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById(fileid).files[0]);
        oFReader.onload = function (oFREvent) {
            document.getElementById(imgid).src = oFREvent.target.result;
        };
    }

    function showimg3(imgid, fileid, conID, comID){
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById(fileid).files[0]);
        oFReader.onload = function (oFREvent) {
            document.getElementById(imgid).src = oFREvent.target.result;
        };
        $("#txtcon_person_addnew_"+conID+"").val(conID);
        $("#txtcon_company_addnew_"+conID+"").val(comID);
        var data = new FormData($('#posting_profilepic_addnew_'+conID)[0]);
        $.ajax({
            type: 'POST',
            url: 'Uploads/update_contact_profilepic.php',
            data: data,
            mimeType: 'multipart/form-data',
            contentType: false,
            cache: false,
            processData: false,
            success:function(data){
                loadexistingcontactpersons(comID)
            }
        });
    }

    function removethiscontactperson(ContactID, CompanyID){
        setTimeout(function(){
            showmodal("confirm", "Are you sure you want to delete this contact person?", "removethiscontactperson2", ContactID+"|"+CompanyID+"|", "", null, "0");
        }, 1000)
    }

    function removethiscontactperson2(ContactID, CompanyID){
        $.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'ContactID=' + ContactID + '&form=removethiscontactperson2',
            success: function(data){
                if(data == 1){
                    $.ajax({
                        type: 'POST',
                        url: 'mainclass.php',
                        data: 'id=' + CompanyID + '&form=load_updatecompany_contactpersons',
                        success: function(data) {
                            $("#div_content_contact_person_list").html(data);
                        }
                    })
                }
            }
        })
    }

    function SameAddVal(id){
        var txtcomp_perm_add = $("#txtcomp_busadd").val();
        if($("#"+id).is(":checked")){
            if(txtcomp_perm_add != ""){
                $("#txtcomp_"+id).val(txtcomp_perm_add);
                // $("#txtcomp_"+id+"_icon").addClass("fa-map-marker");
                // $("#txtcomp_"+id+"_add").css("text-indent", "0.6em");
            }
        }else{
            $("#txtcomp_"+id).val("");
            // $("#txtcomp_"+id+"_icon").removeClass("fa-map-marker");
            // $("#txtcomp_"+id+"_add").css("text-indent", "");
        }
    }

    function AddNewSignatory(){
        var count = $("#txtCompSigCount").val();
        var FirstName = $("#txtCompSigFN").val();
        var MiddleName = $("#txtCompSigMN").val();
        var LastName = $("#txtCompSigLN").val();
        var dupcount = 0;
        $("#tbodyCompSigList tr").each(function(){
            if($(this).find(".tdFirstName").text() == FirstName && $(this).find(".tdMiddleName").text() == MiddleName && $(this).find(".tdLastName").text() == LastName){
                dupcount++;
            }
        })
        if(dupcount == 0){
            if(FirstName != "" || MiddleName != "" || LastName != ""){
                count = Number(count) + 1;
                $("#tbodyCompSigList").append(" <tr id='trCompSig"+count+"'> " +
                                                    "<td class='tdFirstName'>"+ FirstName +"</td> " +
                                                    "<td class='tdMiddleName'>"+ MiddleName +"</td> " +
                                                    "<td class='tdLastName'>"+ LastName +"</td> " +
                                                    "<td style='text-align: center;'><button class='btn btn-xs btn-danger btn-round' onclick='RemoveCompSig(\"trCompSig"+count+"\")' style='z-index: 0;'><i class='fa fa-trash-o'></i></button></td> " +
                                                "</tr>");
            $("#txtCompSigCount").val(count);
            }else{
                setTimeout(function(){
                  showmodal("alert", "Please enter the name of the signatory", "", null, "", null, "1");
                }, 1000)
            }
        }else{
            setTimeout(function(){
              showmodal("alert", "Signatory name already exist.", "", null, "", null, "1");
            }, 1000)
        }
    }

    function RemoveCompSig(id){
        $("#"+id).remove();
    }

    function fncAddIndustry(){
        $("#btnAddIndustry").button("reset");
        $("#mdlAddIndustry").modal("show");
        $("#txtInqIndustryCode").val("");
        $("#txtInqIndustry").val("");
    }

    function fncSaveIndustry(){
        $("#btnAddIndustry").button("loading");
        var indCode = $("#txtInqIndustryCode").val();
        var Industry = $("#txtInqIndustry").val();
        if(indCode != "" && Industry != ""){
            $.ajax({
                type: 'POST',
                url: 'include/class.php',
                data: 'indCode=' + indCode + '&Industry=' + Industry + '&form=fncSaveIndustry',
                success: function(data){
                    $("#btnAddIndustry").button("reset");
                    if(data == 1){
                        setTimeout(function(){
                            showmodal("alert", "Industry successfully saved.", "loadindustry", null, "", null, "0");
                        }, 1000)
                        $("#mdlAddIndustry").modal("hide");
                    }else if(data == 2){
                        setTimeout(function(){
                            showmodal("alert", "Industry code already exist.", "", null, "", null, "1");
                        }, 1000)
                    }else{
                        setTimeout(function(){
                            showmodal("alert", "Failed to save industry.", "", null, "", null, "1");
                        }, 1000)
                    }
                }
            })
        }else{
            $("#btnAddIndustry").button("reset");
            setTimeout(function(){
                showmodal("alert", "Please fill all fields.", "", null, "", null, "1");
            }, 1000)
        }
    }

    function fncAddPosition(){
        $("#btnAddPosition").button("reset");
        $("#mdlAddPosition").modal("show");
        $("#txtInqPosition").val("");
    }

    function fncSavePosition(){
        $("#btnAddPosition").button("loading");
        var Position = $("#txtInqPosition").val();
        if(Position != ""){
            $.ajax({
                type: 'POST',
                url: 'include/class.php',
                data: 'Position=' + Position + '&form=fncSavePosition',
                success: function(data){
                    $("#btnAddPosition").button("reset");
                    if(data == 1){
                        setTimeout(function(){
                            showmodal("alert", "Position successfully saved.", "loadmodalcompanyposition", null, "", null, "0");
                        }, 1000)
                        $("#mdlAddPosition").modal("hide");
                    }else if(data == 2){
                        setTimeout(function(){
                            showmodal("alert", "Position already exist.", "", null, "", null, "1");
                        }, 1000)
                    }else{
                        setTimeout(function(){
                            showmodal("alert", "Failed to save position.", "", null, "", null, "1");
                        }, 1000)
                    }
                }
            })
        }else{
            $("#btnAddPosition").button("reset");
            setTimeout(function(){
                showmodal("alert", "Please fill all fields.", "", null, "", null, "1");
            }, 1000)
        }
    }
</script>
