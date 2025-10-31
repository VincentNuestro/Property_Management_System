<script type="text/javascript">
    $(function() {
        $(".fixTable").tableHeadFixer();
        loadcompanylo();
        autotrapfields();
        loadcompanyposition_update();
        $(".home-address").keyup(function(){
            var value = $(this).val();
            var thisid = $(this).attr("id");
            if(value == ""){
                $(this).attr("onclick", "loadaddressmodal(\""+thisid+"\")");
                $(this).attr("onkeyup", "loadaddressmodal(\""+thisid+"\")");
            }
        });
        $('.date-picker').datepicker({
            autoclose: true,
            todayHighlight: true,
            format:"mm/dd/yyyy"
        })
        $('[data-rel=tooltip]').tooltip();
        $('[data-rel=popover]').popover({html:true});
        <?php if(SysLeaseSetup('automerchantcode') == "1"){ ?>
            $(".isAutoMerchantCode").addClass("hide");
            $("#txtsqm_width").removeClass("req_unit");
        <?php }else{ ?>
            $(".isAutoMerchantCode").removeClass("hide");
            $("#txtArea").removeClass("req_unit");
        <?php } ?>
        $("#tbltradeinfolisthist").html("<tr><td colspan='3' style='text-align: center;'>No Data Found...</td></tr>");
    })

    function loadcompanylo(){
        $.ajax({
            type: 'POST',
            url: 'setup/profiles/class.php',
            data: 'form=loadcompanylo',
            beforeSend : function() {
                $('#indexloadingscreen').addClass('myspinner');
            },
            success: function(data){
                $('#indexloadingscreen').removeClass('myspinner');
                $("#companylist_ol").html(data)
            }
        })
    }

    function loadtenantlist(idnum){
        $.ajax({
            type: 'POST',
            url: 'setup/profiles/class.php',
            data: 'id=' + idnum + '&form=loadtardelist',
            beforeSend : function(){
                $('#indexloadingscreen').addClass('myspinner');
            },
            success: function(data){
                $('#indexloadingscreen').removeClass('myspinner');
                if(data != ""){
                    $("#tbltradeinfolisthist").html(data);
                }else{
                    $("#tbltradeinfolisthist").html("<tr><td colspan='3' style='text-align: center;'>No Data Found...</td></tr>");
                }
            }
        })
    }

    function loadinformationcomp(idnum){
        $.ajax({
            type: 'POST',
            url: 'setup/profiles/class.php',
            data: 'id=' + idnum + '&form=loadinformationcomp',
            success: function(data){
                var arr = data.split("|");
                $("#company_logo").attr("src", arr[3])
                $("#txtcompany_name").text(arr[0]);
                $("#txtcompany_industry").text(arr[1]);
                $("#txtcompany_address").text(arr[2]);
                $("#txtSignatories").html(arr[4]);
                $("#txtOwnerName").text(arr[5]);
                $("#txttrade_companyname").val(arr[0]);
                $("#txttrade_tradeindustry").val(arr[1]);
                $("#txttrade_busadd").val(arr[2]);
                loadtenantlist(idnum);
                $("#txttrade_companyid").val(idnum)
            }
        })
    }

    function updatecompany(compid) {
        loadinformationcomp(compid);
        loadindustry();
        loadcompanyposition();
        uploadcss();   
        $("#txtCompSigFN").val("");
        $("#txtCompSigMN").val("");
        $("#txtCompSigLN").val("");
        $("#btn-save-contact-person").attr("onclick", "addcontactperson_update(\""+compid+"\")");
        $("#div_type_id").val("div_content_contact_person_list");
        $('#file_upload123123').ace_file_input({
            no_file:'No File ...',
            btn_choose:'Choose',
            btn_change:'Change',
            droppable:false,
            onchange:null,
            thumbnail:false
        });
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
                if(arr[2] != ""){
                    $("#txtcomp_busadd_icon").addClass("fa-map-marker");
                    $("#txtcomp_busadd").css("text-indent", "0.6em");
                }
                $("#txtcomp_perm_add").val(arr[3]);
                if(arr[3] != ""){
                    $("#txtcomp_perm_add_icon").addClass("fa-map-marker");
                    $("#txtcomp_perm_add").css("text-indent", "0.6em");
                }
                $("#txtcomp_curr_add").val(arr[4]);
                if(arr[4] != ""){
                    $("#txtcomp_curr_add_icon").addClass("fa-map-marker");
                    $("#txtcomp_curr_add").css("text-indent", "0.6em");
                }
                $("#txtcomp_bill_add").val(arr[5]);
                if(arr[5] != ""){
                    $("#txtcomp_bill_add_icon").addClass("fa-map-marker");
                    $("#txtcomp_bill_add").css("text-indent", "0.6em");
                }
                $("#imgaccount").attr("src", arr[6]);
                $("#txtcomp_fname").val(arr[7]);
                $("#txtcomp_mname").val(arr[8]);
                $("#txtcomp_lname").val(arr[9]);
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
            }
        })
        // owner telephone number
        $.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'id=' + compid + '&form=load_updatecompany_ownertelno',
            success: function(data) {
                $("#add_tel_no_owner").html(data);
                telno();
                autotrapfields();
            }
        })
        // company contact number
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
                telno();
                autotrapfields();
            }
        }) 
        // company contact persons
        $.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'id=' + compid + '&form=load_updatecompany_contactpersons',
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
                    $("#error_"+this.id).text("");
                }else{
                    $("#error_"+this.id).text("Please enter a valid email address");
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
                    $("#error_"+this.id).text("");
                }else{
                    $("#error_"+this.id).text("Please enter a valid website");
                    $(this).val("")
                    e.preventDefault();
                }
            });
        });        
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


    function newcompany(){
        $("#btn-save-contact-person").attr("onclick", "addcontactperson()");
        $(".home-address").each(function(){
            var this_id = $(this).attr("id");
            $(this).attr("onclick", "loadaddressmodal(\""+this_id+"\")")
        })
        $("#posting_profilepic123123").html('<div style="display: none"><input type="text" id="hidden_company_id" name="hidden_company_id"></div><input id="file_upload" name="attachment_profilepic" class="form-control upload" type="file" onchange="showimg();" accept="image/*"/>');
        $('#file_upload123123').ace_file_input({
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
        loadindustry();
        loadcompanyposition();
        $("#txtcontact_fname").val("");
        $("#txtcontact_mname").val("");
        $("#txtcontact_lname").val("");
        $("#txtcontact_designation").val("");
        $("#txtcontact_address").val("");
        $("#tbodyCompSigList").html("");
        $("#txtCompSigFN").val("");
        $("#txtCompSigMN").val("");
        $("#txtCompSigLN").val("");
        uploadcss();   
        var div_add_contact_person_email = "div_add_contact_person_email";
        var person_email = "emailaddress";
        var div_add_contact_person_mobile = "div_add_contact_person_mobile";
        var person_mobile = "input-mask-phone";
        var div_add_contact_person_tele = "div_add_contact_person_tele";
        var person_tele = "input-mask-tele";
        $("#div_add_contact_person_email").html("<div class='input-group'><input type='text' id='spinner3' class='spinbox-input form-control email-address' placeholder='sample@yahoo.com'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success btn-round' onclick='div_add_field(\""+div_add_contact_person_email+"\", \""+person_email+"\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>");
        $("#div_add_contact_person_mobile").html("<div class='input-group'><input type='text' id='spinner3' class='spinbox-input form-control input-mask-phone' maxlength='11' placeholder='(999)-999-9999'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success btn-round' onclick='div_add_field(\""+div_add_contact_person_mobile+"\", \""+person_mobile+"\")'> <i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>");
        $("#div_add_contact_person_tele").html("<div class='input-group'><input type='text' id='spinner3' class='spinbox-input form-control input-mask-tele'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success btn-round' onclick='div_add_field(\""+div_add_contact_person_tele+"\", \""+person_tele+"\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>");
        $("#div_add_contact_person_email input").attr("style", "border-color:#D5D5D5 !important");
        $("#div_add_contact_person_mobile input").attr("style", "border-color:#D5D5D5 !important");
        $("#div_add_contact_person_tele input").attr("style", "border-color:#D5D5D5 !important");
        $('.save_contact_per').each(function() {
            if($(this).val() == ""){
                $(this).attr("style", "border-color:#D5D5D5 !important; background-color: white !important;");
            }
        });
        $("#txtcomp_busadd").css("text-indent", "");
        $("#txtcomp_busadd_icon").removeClass("fa-map-marker");
        $("#txtcomp_perm_add").css("text-indent", "");
        $("#txtcomp_perm_add_icon").removeClass("fa-map-marker");
        $("#txtcomp_curr_add").css("text-indent", "");
        $("#txtcomp_curr_add_icon").removeClass("fa-map-marker");
        $("#txtcomp_bill_add").css("text-indent", "");
        $("#txtcomp_bill_add_icon").removeClass("fa-map-marker");
        $("#txtcontact_address").css("text-indent", "");
        $("#txtcontact_address_icon").removeClass("fa-map-marker");
        $("#add_tel_no_owner").html('<div class="input-group"><input type="text" id="add_tel_no_owner" class="spinbox-input form-control input-mask-tele" placeholder="(99)-999-9999"><div class="spinbox-buttons input-group-btn"><button type="button" class="btn spinbox-up btn-sm btn-success btn-round" onclick="div_addtel_owner()"><i class="icon-only  ace-icon ace-icon fa fa-plus bigger-110"></i></button></div></div>');
        $("#company_contact_mobile").html('<input type="text" id="company_contact_mobile" class="spinbox-input form-control input-mask-phone" maxlength="11" placeholder="(999)-999-9999"><div class="spinbox-buttons input-group-btn"><button type="button" class="btn spinbox-up btn-sm btn-success btn-round" onclick="div_add_field(\'company_contact_mobile\', \'input-mask-phone\')"><i class="icon-only  ace-icon ace-icon fa fa-plus bigger-110"></i></button></div>');
        $("#company_contact_tele").html('<input type="text" id="company_contact_tele" class="spinbox-input form-control input-mask-tele" placeholder="(99)-999-9999"> <div class="spinbox-buttons input-group-btn"><button type="button" class="btn spinbox-up btn-sm btn-success btn-round" onclick="div_add_field(\'company_contact_tele\', \'input-mask-tele\')"><i class="icon-only  ace-icon ace-icon fa fa-plus bigger-110"></i></button></div>');
        $("#company_contact_fax").html('<input type="text" id="company_contact_fax" class="spinbox-input form-control input-mask-tele" placeholder="(99)-999-9999"><div class="spinbox-buttons input-group-btn"><button type="button" class="btn spinbox-up btn-sm btn-success btn-round" onclick="div_add_field(\'company_contact_fax\', \'input-mask-tele\')"><i class="icon-only ace-icon ace-icon fa fa-plus bigger-110"></i></button></div>');
        $("#company_contact_email").html('<input type="text" id="company_contact_email" onkeyup="" class="spinbox-input form-control email-address" placeholder="sample@yahoo.com"><div class="spinbox-buttons input-group-btn"><button type="button" class="btn spinbox-up btn-sm btn-success btn-round" onclick="div_add_field(\'company_contact_email\', \'emailaddress\')"><i class="icon-only  ace-icon ace-icon fa fa-plus bigger-110"></i></button></div>');
        $("#company_contact_website").html('<input type="text" id="company_contact_website" class="spinbox-input form-control website-input" placeholder="www.sample.com"><div class="spinbox-buttons input-group-btn"><button type="button" class="btn spinbox-up btn-sm btn-success btn-round" onclick="div_add_field(\'company_contact_website\', \'website\')"><i class="icon-only ace-icon ace-icon fa fa-plus bigger-110"></i></button></div>');
        $("#div_content_contact_person_list").html("");
        $("#txtcontact_fname").val("");
        telno();
        autotrapfields();
    }

    function telno(){
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
    }

    function addnewtradename(){
        if($("#txtcompany_name").text() == ""){
            setTimeout(function(){
                showmodal("alert", "Select company first.", "", null, "", null, "1");
            }, 1000)
        }else{
            $("#btn_new_store").attr("onclick", "savetradename()");
            $("#txttrade_tradename").attr("onchange", "GenerateMerchantCode(this.value, \"addnew\")")
            $("#modal_newtradename").modal("show");
            $("#txttrade_tradename").val("");
            $("#txtmerc_code").val("");
            $(".text_new_trade").css("border-color","#D5D5D5");
            $("#trade_hidden_companyID2").val("");
            $("#trade_hidden_tradeID").val("");
            $("#imgtradeaccount").attr("src", "assets/images/noimage5.png");
            $("#file_upload_trade").val("");
            $("#posting_profilepic_trade").html('<div style="display: none;"><input type="text" id="trade_hidden_companyID2" name="companyID"><input type="text" id="trade_hidden_tradeID" name="tradeID"></div><input id="file_upload_trade" name="attachment_profilepic" class="form-control upload upload_app_req" type="file" onchange="showimgtrade();" accept="image/*"/>');
            uploadcss();    
        }
    }

    function savetradename(){
        var e = 0;
        $(".text_new_trade").each(function(){
            if($(this).val() == ""){
                e++;
                $(this).css("border-color","#f2a696");
            }else{
                $(this).css("border-color","#D5D5D5");
            }
        });
        if(e == 0){ 
            var tradename = $("#txttrade_tradename").val();
            var companyname = $("#txttrade_companyname").val();
            var companyid = $("#txttrade_companyid").val();
            var merchant_code = $("#txtmerc_code").val();
            $.ajax({
                type: 'POST',
                url: 'mainclass.php',
                data: 'tradename=' + tradename + '&companyname=' + companyname + '&companyid=' + companyid + '&merchant_code=' + merchant_code + '&form=savetradename',
                success: function(data){
                    var arr = data.split("|");
                    sendprofilepic_trade(arr[1], arr[2]);
                    if(arr[0] == "1"){
                        setTimeout(function(){
                            showmodal("alert", "Successfully Updated!", "loadtenantlist", companyid+"|", "", null, "0");
                        }, 500)
                        $("#modal_newtradename").modal("hide");
                        $(".text_new_trade").css("border-color","#D5D5D5");
                    }else{
                        setTimeout(function(){
                            showmodal("alert", "Merchant Code already exist", "", null, "", null, "1");
                        }, 500)
                    }
                } 
            });
        }else{
            setTimeout(function(){
                showmodal("alert", "Fill all required fields.", "", null, "", null, "1");
            }, 500)
                $('.text_new_trade').each(function() {
                if(this.value === ''){
                    this.focus();
                    return false;
                }
            });
        }
    }

    function editstore(storeID, img, storename, comID, merchant_code){
        $("#imgtradeaccount").attr("src", img);
        $("#txttrade_tradename").val(storename);
        $("#txtmerc_code").val(merchant_code);
        $("#modal_newtradename").modal("show");
        $("#file_upload_trade").val("");
        $("#posting_profilepic_trade").html('<div style="display: none;"><input type="text" id="trade_hidden_companyID2" name="companyID"><input type="text" id="trade_hidden_tradeID" name="tradeID"></div><input id="file_upload_trade" name="attachment_profilepic" class="form-control upload upload_app_req" type="file" onchange="showimgtrade();" accept="image/*"/>');
        uploadcss();
        $("#btn_new_store").attr("onclick", "savetradename_update(\""+storeID+"\", \""+comID+"\")")
        $("#txttrade_tradename").attr("onchange", "GenerateMerchantCode(this.value, \"edit\")")
    }

    function savetradename_update(storeid, comid){
        var e = 0;
        $(".text_new_trade").each(function(){
            if($(this).val() == ""){
                e++;
                $(this).css("border-color","#f2a696");
            }else{
                $(this).css("border-color","#D5D5D5");
            }
        });
        if(e == 0){ 
            var tradename = $("#txttrade_tradename").val();
            var merchant_code = $("#txtmerc_code").val();
             $.ajax({
                type: 'POST',
                url: 'mainclass.php',
                data: 'tradename=' + tradename + '&companyid=' + comid + '&id=' + storeid + '&merchant_code=' + merchant_code + '&form=savetradename_update',
                success: function(data){
                    var arr = data.split("|");
                    if(arr[0] == "1"){
                        setTimeout(function(){
                            showmodal("alert", "Successfully Updated!", "sendprofilepic_trade", comid+"|"+storeid+"|", "", null, "0");
                        }, 500)
                        $("#modal_newtradename").modal("hide");
                        $(".text_new_trade").css("border-color","#D5D5D5");
                    }else{
                        setTimeout(function(){
                            showmodal("alert", "Merchant Code already exist", "", null, "", null, "1");
                        }, 500)
                    }
                }
            })
        }else{
            setTimeout(function(){
              showmodal("alert", "Fill all required fields.", "", null, "", null, "1");
            }, 500)
            $('.text_new_trade').each(function() {
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
            document.getElementById("imgtradeaccount").src = oFREvent.target.result;
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
                loadtenantlist(companyID);
            }
        });
    }

    function SameAddVal(id){
        var txtcomp_perm_add = $("#txtcomp_perm_add").val();
        if($("#"+id).is(":checked")){
            if(txtcomp_perm_add != ""){
                $("#txtcomp_"+id).val(txtcomp_perm_add);
                $("#txtcomp_"+id+"_icon").addClass("fa-map-marker");
                $("#txtcomp_"+id+"_add").css("text-indent", "0.6em");
            }
        }else{
            $("#txtcomp_"+id).val("");
            $("#txtcomp_"+id+"_icon").removeClass("fa-map-marker");
            $("#txtcomp_"+id+"_add").css("text-indent", "");
        }
    }

    function loadaddressmodal(this_ids){
        $("#txtaddress_streetadd").focus();
        $("#modal_addnewaddress").modal("show");
        $("#okaddressbtn").attr("onclick", "saveaddressmodalfunc(\""+this_ids+"\")");
    }

    function loadcityref(){
        var city = $("#txtadd_city").val();
        if(city != ""){
            $.ajax({
                type: 'POST',
                url: 'mainclass.php',
                data: 'city=' + city + '&form=loadcityref',
                success: function(data){
                    $("#list_city_list").html(data);
                }
            })      
        }
    }

    function saveaddressmodalfunc(this_id){
        var txtaddress_streetadd = $("#txtaddress_streetadd").val();
        var txtadd_city = $("#txtadd_city").val();
        if(txtaddress_streetadd == "" || txtadd_city == ""){
            setTimeout(function(){
                showmodal("alert", "Please fill all fields.", "", null, "", null, "1");
            }, 500)
            $("#txtaddress_streetadd").css("border-color","#f2a696");
            $("#txtadd_city").css("border-color","#f2a696");
            $("#"+this_id+"_icon").removeClass("fa-map-marker");
            $("#"+this_id).css("text-indent", "");
            $("#"+this_id).css("padding-left", "0px");
        }else{
            $("#txtaddress_streetadd").css("border-color","#D5D5D5");
            $("#txtadd_city").css("border-color","#D5D5D5");
            $("#"+this_id).css("text-indent", "0.6em");
            $("#"+this_id+"_icon").removeClass("fa-map-marker");
            $("#"+this_id+"_icon").addClass("fa-map-marker");
            $("#"+this_id).css("padding-left", "15px");
            $("#modal_addnewaddress").modal("hide");
            var txtaddress_streetadd = $("#txtaddress_streetadd").val();
            var txtadd_city = $("#txtadd_city").val();
            $("#"+this_id).val(txtaddress_streetadd + " " + txtadd_city);
            $("#txtaddress_streetadd").val("");
            $("#txtadd_city").val(""); 
            $("#"+this_id).focus();     
        }
    }

    function loadreferentialmodal(type){
        if(type == "position"){
            $("#txtref_name").text("Company Position");
            $("#txtref_name2").text("New Position");
            $("#btnnewreferential").attr("onclick", "savenewreferential('position')")
            $("#txtaddnewreferential").attr("placeholder", "Position Name");
        }else if(type == "industry"){
            $("#txtref_name").text("Industry");
            $("#txtref_name2").text("New Industry");
            $("#btnnewreferential").attr("onclick", "savenewreferential('industry')")
            $("#txtaddnewreferential").attr("placeholder", "Industry Name");
        }
        tblreflist(type)
        $("#modal_new_referential").modal("show");
    }

    function tblreflist(type){
        $.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'type=' + type + '&form=tblreflist',
            success: function(data){
                $("#tblreflist").html(data);
            }
        })
    }

    function savenewreferential(type){
        var ref = $("#txtaddnewreferential").val();
        if(ref == "" || ref.match(/^\s*$/)){
            setTimeout(function(){
                showmodal("alert", "Please fill all fields.", "", null, "", null, "1");
            }, 500)  
            $("#txtaddnewreferential").css("border-color", "#f2a696");  
            $("#txtaddnewreferential").val("");
            $("#txtaddnewreferential").focus();
        }else{
            $.ajax({
                type: 'POST',
                url: 'mainclass.php',
                data: 'type=' + type + '&ref=' + ref + '&form=savenewreferential',
                success: function(data){
                    if(data == 1){
                        $("#txtaddnewreferential").css("border-color", "#d5d5d5");
                        setTimeout(function(){
                            showmodal("alert", "Successfully added.", "", null, "", null, "0");
                        }, 500)
                        tblreflist(type);
                        if(type == "industry"){
                            loadindustry2(ref);            
                        }else if(type == "position"){
                            loadcompanyposition2(ref);
                        }          
                    }else if(data == 2){
                        setTimeout(function(){
                            showmodal("alert", "Already existing", "", null, "", null, "1");
                        }, 500)  
                        $("#txtaddnewreferential").css("border-color", "#f2a696");  
                        $("#txtaddnewreferential").val("");
                        $("#txtaddnewreferential").focus();
                    }
                }
            })   
        } 
    }

    function loadindustry2(ref){
        $.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'form=loadindustry',
            success: function(data){
                $("#txtaddnewreferential").css("border-color", "#d5d5d5");
                $("#txtcomp_industry").html(data);
                $("#txtcomp_industry").val(ref);
                $("#txtaddnewreferential").val("");
                $("#txtaddnewreferential").focus();
            }
        })    
    }

    function loadcompanyposition2(ref){
        $.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'form=loadcompanyposition',
            success: function(data){
                $("#txtaddnewreferential").css("border-color", "#d5d5d5");
                $("#txtcontact_designation").html(data);  
                $("#txtcontact_designation_update").html(data);
                $("#txtcontact_designation").val(ref); 
                $("#txtcontact_designation_update").val(ref);
                $("#txtaddnewreferential").val("");
                $("#txtaddnewreferential").focus();        
            }
        })
    }

    function closemodalref(){
        $("#modal_new_referential").modal("hide");
    }

    function editthiscontactperson(idnum, comid){
        $("#trade_hidden_custid_update").val("");
        $("#trade_hidden_custid_update_company").val("");
        $("#btn_savecontactperson").attr("onclick", "savecontactperson_update(\""+idnum+"\", \""+comid+"\")");
        $.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'id=' + idnum + '&form=editthiscontactperson',
            success: function(data){
                var arr = data.split("|");
                $("#edit_contactperson_modal").modal("show");
                $("#imgtradeaccount_update").attr("src", arr[7]);
                $("#txtcontact_fname_update").val(arr[0]);
                $("#txtcontact_mname_update").val(arr[1]);
                $("#txtcontact_lname_update").val(arr[2]);
                $("#txtcontact_designation_update").val(arr[5]);
                $("#txtcontact_address_update").val(arr[6]);    
                telno();            
            }
        });
        $.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'id=' + idnum + '&form=editthiscontactperson_contacts',
            success: function(data){
                var arr = data.split("#|")
                $("#div_add_contact_person_email_update").html(arr[0]);
                $("#div_add_contact_person_mobile_update").html(arr[1]);
                $("#div_add_contact_person_tele_update").html(arr[2]);
            }
        });
    }

    function savecontactperson_update(idnum, comID){
        var fname_update = $("#txtcontact_fname_update").val();
        var mname_update = $("#txtcontact_mname_update").val();
        var lname_update = $("#txtcontact_lname_update").val();
        var designation_update = $("#txtcontact_designation_update").val();
        var address_update = $("#txtcontact_address_update").val();
        $.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'id=' + idnum + '&fname=' + fname_update + '&mname=' + mname_update + '&lname=' + lname_update + '&designation=' + designation_update + '&add=' + address_update + '&form=savecontactperson_update',
            success: function(data){
                if(data == 1){
                    setTimeout(function(){
                        showmodal("alert", "Successfully Modified.", "", null, "", null, "0");
                    }, 1000)
                }
            }
        });
        var div_add_contact_person_email_update = "";
        $("#div_add_contact_person_email_update input").each(function(){
            var this_value = $(this).val();
            if(!this_value.match(/^\s*$/) || this_value != ""){
                div_add_contact_person_email_update += this_value + "|";                    
            }
        });
        var div_add_contact_person_mobile_update = "";
        $("#div_add_contact_person_mobile_update input").each(function(){
            var this_value = $(this).val();  
            if(!this_value.match(/^\s*$/) || this_value != ""){
                div_add_contact_person_mobile_update += this_value + "|";       
            }   
        });
        var div_add_contact_person_tele_update = "";
        $("#div_add_contact_person_tele_update input").each(function(){
            var this_value = $(this).val(); 
            if(!this_value.match(/^\s*$/) || this_value != ""){
                div_add_contact_person_tele_update += this_value + "|"; 
            }  
        });
        $.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'id=' + idnum + '&email_update=' + div_add_contact_person_email_update + '&mobile_number=' + div_add_contact_person_mobile_update + '&tel_number=' + div_add_contact_person_tele_update + '&form=savecontactperson_update_contactnum',
            success: function(data){

            }
        });
        $("#trade_hidden_custid_update").val(idnum);
        $("#trade_hidden_custid_update_company").val(comID);
        var data = new FormData($('#posting_profilepic_contactperson')[0]);
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
        }, 500)
        
    }

    function removethiscontactperson2(ContactID, CompanyID){
        $.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'ContactID=' + ContactID + '&form=removethiscontactperson',
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

    function loadexistingcontactpersons(idcomp){
        var div = $("#div_type_id").val();
        $.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'companyID=' + idcomp + '&form=selectcontactpersons',
            success: function(data){
                $("#"+div).html(data);
            }
        })
    }

    function setvaluediv(){
        $("#div_type_id").val("div_inquiry_contact_person");
    }

    function showimgtrade_update(){
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("file_upload_trade_update").files[0]);
        oFReader.onload = function (oFREvent) {
            document.getElementById("imgtradeaccount_update").src = oFREvent.target.result;
        };
    }

    function loadcompanyposition_update(){
        $.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'form=loadcompanyposition',
            success: function(data){
                $("#txtcontact_designation_update").html(data);
            }
        })
    }

    function savenewmall_update(compid){
        $("#div_company_contacts input").each(function(){
            $(this).css("border-color","#D5D5D5");
        }); 
        $("#add_tel_no_owner input").each(function(){
            $(this).css("border-color","#D5D5D5");
        });
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
        });
        var f = 0;
        $("#div_company_contacts input").each(function(){
            if($(this).val() != ""){
                f++;
            }
        });
        var g = 0;
        $("#add_tel_no_owner input").each(function(){
            if($(this).val() != ""){
                g++;
            }
        }); 
        var sigcount = 0;
        $("#tbodyCompSigList tr").each(function(){
            if($(this).find(".tdFirstName").text() != "" || $(this).find(".tdMiddleName").text() != "" || $(this).find(".tdLastName").text() != ""){
                sigcount++;
            }
        })
        var i = 1;
        // if(e == 0 && f != 0 && g != 0 && i != 0 <?php if(SysLeaseSetup('isMultiCompSig') == '1'){ ?> && sigcount != 0 <?php } ?>){ 
            var name = $("#txtcomp_name").val();
            var industry = $("#txtcomp_industry").val();
            var fname = $("#txtcomp_fname").val();
            var mname = $("#txtcomp_mname").val();
            var lname = $("#txtcomp_lname").val();
            var busadd = $("#txtcomp_busadd").val();
            var perm_add = $("#txtcomp_perm_add").val();
            var curr_add = $("#txtcomp_curr_add").val();
            var bill_add = $("#txtcomp_bill_add").val();
            var owner_tel_no = "";
            $("#add_tel_no_owner input").each(function(){
                var tel = $(this).val();
                if (!tel.match(/^\s*$/) || tel != ""){
                    owner_tel_no += tel + "|";
                }
            });
            var contact_mobile = "";
            $("#company_contact_mobile input").each(function(){
                var mob = $(this).val();
                if (!mob.match(/^\s*$/) || mob != ""){
                    contact_mobile += mob + "|";
                }            
            });
            var contact_tele = "";
            $("#company_contact_tele input").each(function(){
                var tel = $(this).val();
                if (!tel.match(/^\s*$/) || tel != ""){
                    contact_tele += tel + "|";
                }            
            });
            var contact_fax = "";
            $("#company_contact_fax input").each(function(){
                var fax = $(this).val();
                if (!fax.match(/^\s*$/) || fax != ""){
                    contact_fax += fax + "|";
                }            
            });
            var contact_email = "";
            $("#company_contact_email input").each(function(){
                var email = $(this).val();
                if (!email.match(/^\s*$/) || email != ""){
                    contact_email += email + "|";
                }            
            });
            var contact_website = "";
            $("#company_contact_website input").each(function(){
                var web = $(this).val();
                if (!web.match(/^\s*$/) || web != ""){
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
                data: 'name=' + name + '&industry=' + industry + '&busadd=' + busadd + '&fname=' + fname + '&mname=' + mname + '&lname=' + lname + '&perm_add=' + perm_add + '&curr_add=' + curr_add + '&bill_add=' + bill_add + '&owner_tel_no=' + owner_tel_no + '&contact_mobile=' + contact_mobile + '&contact_tele=' + contact_tele + '&contact_fax=' + contact_fax + '&contact_email=' + contact_email + '&contact_website=' + contact_website + '&id=' + compid + '&Signatories=' + Signatories + '&form=savenewmall_update',
                success: function(data){
                    var arr = data.split("|");
                    if(arr[1] == "1"){
                        setTimeout(function(){
                            showmodal("alert", "New company successfully updated.", "loadcompanylo", null, "", null, "0");
                        }, 1000)
                        sendprofilepic(arr[0]);   
                        savecontactpersons(arr[0]);
                        $("#div_company_contacts input").each(function(){
                            $(this).css("border-color","#D5D5D5");
                        }); 
                        $("#add_tel_no_owner input").each(function(){
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
        // }else{
        //     setTimeout(function(){
        //         showmodal("alert", "Fill all required fields!", "", null, "", null, "1");
        //     }, 1000)
        //     $('.text_reqcompany').each(function() {
        //         if ( this.value === '' ) {
        //             this.focus();
        //             return false;
        //         }
        //     });
        //     if(f == 0){
        //         $("#div_well_contacts").css("border-color","#f2a696");                
        //     }else{
        //         $("#div_well_contacts").css("border-color","#D5D5D5");
        //     }
        //     if(g == 0){
        //         $("#add_tel_no_owner input").each(function(){
        //             if($(this).val() == ""){
        //                 $(this).css("border-color","#f2a696");
        //             }else{
        //                 $(this).css("border-color","#D5D5D5");
        //             }
        //         }); 
        //     }else{
        //         $("#add_tel_no_owner").css("border-color","#D5D5D5");
        //     }
        //     if(i == 0){
        //         $("#div_well_contact_persons").css("border-color","#f2a696"); 
        //     }else{
        //         $("#div_well_contact_persons").css("border-color","#D5D5D5");
        //     }
        //     if(sigcount == 0){
        //         $("#div_CompSig").css("border-color","#f2a696"); 
        //     }else{
        //         $("#div_CompSig").css("border-color","#D5D5D5");
        //     }
        // }
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
                showmodal("alert", "Sorry, but you already entered the same "+prompt_alert+".", "", null, "", null, "0");
            }, 1000)
            this_text.val("");
            this_text.focus();
        }
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
        if((contact_firstname != "" && !contact_firstname.match(/^\s*$/)) && (contact_lastname != "" && !contact_lastname.match(/^\s*$/)) && (contact_designation != "" && !contact_designation.match(/^\s*$/)) && (contact_address != "" && !contact_address.match(/^\s*$/)) && (div_add_contact_person_email != "" || div_add_contact_person_mobile != "" || div_add_contact_person_tele != "") ){
            $.ajax({
                type: 'POST',
                url: 'mainclass.php',
                data: 'id=' + compid + '&contact_firstname=' + contact_firstname + '&contact_middlename=' + contact_middlename + '&contact_lastname=' + contact_lastname + '&contact_designation=' + contact_designation + '&contact_address=' + contact_address + '&person_email=' + div_add_contact_person_email + '&person_mobile=' + div_add_contact_person_mobile + '&person_tele=' + div_add_contact_person_tele + '&form=addcontactperson_update',
                success: function(data){
                    var arr = data.split("|");
                    if(arr[0] == "1"){
                        aff += "<div class='alert alert-info div_contact_person save_this_div' id='contact_"+arr[1]+"'><div class='tools tools-left in'><a href='#' title='Edit Photo' class='btnedit' style='float:right;margin-bottom:8px;margin-top:8px;' onclick='editthiscontactperson(\""+arr[1]+"\", \""+compid+"\")'><i class='ace-icon fa fa-pencil'></i></a><a href='#' title='Remove Photo' class='btndelete' style='float:right;margin-right:5px;margin-bottom:8px;margin-top:8px;' onclick='removethiscontactperson(\""+arr[1]+"\")'><i class='ace-icon fa fa-times red'></i></a></div><center><div class='image'><img class='img-thumbnail imageName form-control' src='assets/images/noimage5.png' id='div_add_new_contact_per_edit' style='border: 2px solid #bdc3c7; margin-bottom: 8px;height: 160px;width:90%;'></div><form name='posting_profilepic_addnew_"+arr[1]+"' id='posting_profilepic_addnew_"+arr[1]+"' class='posting_profilepic'><div style='display:none;'><input type='text' name='contactID' id='txtcon_person_addnew_"+arr[1]+"' class='txtcon_person'><input type='text' name='companyID' id='txtcon_company_addnew_"+arr[1]+"' class='txtcon_company'></div><input id='posting_profilepic_addnew_input_"+arr[1]+"' name='file_upload_trade_update' class='form-control upload_app_req' type='file' onchange='showimg3(\"div_add_new_contact_per_edit\",\"posting_profilepic_addnew_input_"+arr[1]+"\", \""+arr[1]+"\", \""+compid+"\");' accept='image/*'/></form></center><label style='font-size: 14px; font-weight: bold;margin: 0px !important;' class='contact_person_firstname'>"+contact_firstname+" </label>&nbsp;<label style='font-size: 14px; font-weight: bold;margin: 0px !important;' class='contact_person_middlename'>"+contact_middlename+"</label>&nbsp;<label style='font-size: 14px; font-weight: bold;margin: 0px !important;' class='contact_person_lastname'>"+contact_lastname+"</label><p style='font-size: 14px; font-weight: normal;margin: 0px !important;' class='contact_person_designation'>"+contact_designation+"</p><p style='font-size: 10px; font-weight: normal;margin: 0px !important;' class='address_person'>"+contact_address+"</p>"+div_add_contact_person_email_a+""+div_add_contact_person_mobile_a+""+div_add_contact_person_tele_a+"</div>";
                        $( aff ).appendTo( "#div_content_contact_person_list" );
                        $("#txtcontact_fname").val("");
                        $("#txtcontact_mname").val("");
                        $("#txtcontact_lname").val("");
                        $("#txtcontact_designation").val("");
                        $("#txtcontact_address").val("");
                        uploadcss();   
                        var div_add_contact_person_email = "div_add_contact_person_email";
                        var person_email = "emailaddress";
                        var div_add_contact_person_mobile = "div_add_contact_person_mobile";
                        var person_mobile = "input-mask-phone";
                        var div_add_contact_person_tele = "div_add_contact_person_tele";
                        var person_tele = "input-mask-tele";
                        $("#div_add_contact_person_email").html("<div class='input-group'><input type='text' id='spinner3' class='spinbox-input form-control email-address' placeholder='sample@yahoo.com'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success btn-round' onclick='div_add_field(\""+div_add_contact_person_email+"\", \""+person_email+"\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>");
                        $("#div_add_contact_person_mobile").html("<div class='input-group'><input type='text' id='spinner3' class='spinbox-input form-control input-mask-phone' maxlength='11' placeholder='(999)-999-9999'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success btn-round' onclick='div_add_field(\""+div_add_contact_person_mobile+"\", \""+person_mobile+"\")'> <i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>");
                        $("#div_add_contact_person_tele").html("<div class='input-group'><input type='text' id='spinner3' class='spinbox-input form-control input-mask-tele' placeholder='(99)-999-9999'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success btn-round' onclick='div_add_field(\""+div_add_contact_person_tele+"\", \""+person_tele+"\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>");
                        telno();  
                        $("#div_add_contact_person_email input").attr("style", "border-color:#D5D5D5 !important");
                        $("#div_add_contact_person_mobile input").attr("style", "border-color:#D5D5D5 !important");
                        $("#div_add_contact_person_tele input").attr("style", "border-color:#D5D5D5 !important");
                        $('.save_contact_per').each(function() {
                            if($(this).val() == ""){
                                $(this).attr("style", "border-color:#D5D5D5 !important; background-color: white !important;");
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
                            $(this).attr("style", "border-color:#f2a696 !important; background-color: white !important;");
                        }); 
                        $('.save_contact_per').each(function(){
                            this.focus();
                            return false;
                        });
                    }
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
                        $(this).attr("style", "border-color:#f2a696 !important; background-color: white !important;");
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
                    if($(this).val() == ""){
                        $(this).attr("style", "border-color:#f2a696 !important; background-color: white !important;");
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

    function loadcompanyposition(){
        $.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'form=loadcompanyposition',
            success: function(data){
                $("#txtcontact_designation").html(data);
            }
        })
    }

    var clicked2 = false;
    $("#div_addnewcontactperson").slideDown();
    clicked2 = true; 

    function addnewcontactperson(){
        if(clicked2){
            $("#div_addnewcontactperson").slideUp();
            $("#carret_icon_div").removeClass("fa-caret-down");
            $("#carret_icon_div").removeClass("fa-caret-up");
            $("#carret_icon_div").addClass("fa-caret-down");
            clicked2 = false;
        
        }else{
            $("#div_addnewcontactperson").slideDown();
            $("#div_addnewcontactperson").css("display", "block");
            $("#carret_icon_div").removeClass("fa-caret-down");
            $("#carret_icon_div").removeClass("fa-caret-up");
            $("#carret_icon_div").addClass("fa-caret-up");
            clicked2 = true;
        }
    }

    function showimg(){
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("file_upload").files[0]);
        oFReader.onload = function (oFREvent) {
            document.getElementById("imgaccount").src = oFREvent.target.result;
        };
    }

    function savenewmall(){
        $("#div_company_contacts input").each(function(){
            $(this).css("border-color","#D5D5D5");
        }); 
        $("#add_tel_no_owner input").each(function(){
            $(this).css("border-color","#D5D5D5");
        });
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
        });
        var f = 0;
        $("#div_company_contacts input").each(function(){
            if($(this).val() != ""){
                f++;
            }
        });
        var g = 0;
        $("#add_tel_no_owner input").each(function(){
            if($(this).val() != ""){
                g++;
            }
        }); 
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
        if(e == 0 && f != 0 && g != 0 && i != 0 <?php if(SysLeaseSetup('isMultiCompSig') == '1'){ ?> && sigcount != 0 <?php } ?>){ 
            var name = $("#txtcomp_name").val();
            var industry = $("#txtcomp_industry").val();
            var fname = $("#txtcomp_fname").val();
            var mname = $("#txtcomp_mname").val();
            var lname = $("#txtcomp_lname").val();
            var busadd = $("#txtcomp_busadd").val();
            var perm_add = $("#txtcomp_perm_add").val();
            var curr_add = $("#txtcomp_curr_add").val();
            var bill_add = $("#txtcomp_bill_add").val();
            var owner_tel_no = "";
            $("#add_tel_no_owner input").each(function(){
                var tel = $(this).val();
                if(!tel.match(/^\s*$/) || tel != ""){
                    owner_tel_no += tel + "|";
                }
            });
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
                data: 'name=' + name + '&industry=' + industry + '&busadd=' + busadd + '&fname=' + fname + '&mname=' + mname + '&lname=' + lname + '&perm_add=' + perm_add + '&curr_add=' + curr_add + '&bill_add=' + bill_add + '&owner_tel_no=' + owner_tel_no + '&contact_mobile=' + contact_mobile + '&contact_tele=' + contact_tele + '&contact_fax=' + contact_fax + '&contact_email=' + contact_email + '&contact_website=' + contact_website + '&Signatories=' + Signatories + '&form=savenewmall',
                success: function(data){
                    var arr = data.split("|");
                    if(arr[1] == "1"){
                        setTimeout(function(){
                            showmodal("alert", "New company successfully saved.", "loadcompanylo", null, "", null, "0");
                        }, 1000)
                        sendprofilepic(arr[0]);   
                        savecontactpersons(arr[0]);
                        $("#div_company_contacts input").each(function(){
                            $(this).css("border-color","#D5D5D5");
                        }); 
                        $("#add_tel_no_owner input").each(function(){
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
            setTimeout(function(){
                showmodal("alert", "Fill all required fields!", "", null, "", null, "1");
            }, 1000)
            $('.text_reqcompany').each(function() {
                if(this.value === ''){
                    this.focus();
                    return false;
                }
            });
            if(f == 0){
                $("#div_well_contacts").css("border-color","#f2a696");                
            }else{
                $("#div_well_contacts").css("border-color","#D5D5D5");
            }
            if(g == 0){
                $("#add_tel_no_owner input").each(function(){
                    if($(this).val() == ""){
                        $(this).css("border-color","#f2a696");
                    }else{
                        $(this).css("border-color","#D5D5D5");
                    }
                }); 
            }else{
                $("#add_tel_no_owner").css("border-color","#D5D5D5");
            }
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

    function savecontactpersons(compID){
        var i = 0;
        var e = 0;
        $("#div_content_contact_person_list .div_contact_person").each(function(){
            i++;
        });
        if(i == 0){
            $("#modal_new_company").modal("hide");
            $("#div_content_contact_person_list").html("");
        }else{
            $("#div_content_contact_person_list .div_contact_person").each(function(){
                var firstname = $(this).find(".contact_person_firstname");
                var middlename = $(this).find(".contact_person_middlename");
                var lastname = $(this).find(".contact_person_lastname");
                var designation = $(this).find(".contact_person_designation");
                var address = $(this).find(".address_person");
                var email = $(this).find(".contact_person_emailadd");
                var mobile = $(this).find(".contact_person_mobno");
                var tele = $(this).find(".contact_person_telno");
                var form = $(this).find(".posting_profilepic");
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
                    data: 'id=' + compID +  '&firstname_val=' + firstname_val + '&middlename_val=' + middlename_val + '&lastname_val=' + lastname_val + '&designation_val=' + designation_val + '&address_val=' + address_val + '&email_string=' + email_string + '&mobile_string=' + mobile_string + '&tele_string=' + tele_string + '&form=savecontactpersons',
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
                if(i == e){
                    $("#modal_new_company").modal("hide");
                    $("#div_content_contact_person_list").html("");
                }
            }
        });
    }

    function sendprofilepic(custid){
        $("#hidden_company_id").val(custid);
        var data = new FormData($("#posting_profilepic123123")[0]);
        $.ajax({
            type: 'POST',
            url: 'Uploads/upload_app_profile.php',
            data: data,
            mimeType: 'multipart/form-data',
            contentType: false,
            cache: false,
            processData: false,
            success:function(data){ 

            }
        });
    }

    function div_addtel_owner(){
        var div_addtel_owner = "";
        var i = 0;
        $("#add_tel_no_owner input").each(function(){
            var value = $(this).val();
            if (!value.match(/^\s*$/)) {
              div_addtel_owner += "<input type='text' class='form-control input-mask-tele' value='"+value+"' style='margin-bottom:5px;'>";
            }else{
              i++;
            }
        });
        if(i == 0){
            div_addtel_owner += "<div class='input-group'><input type='text' id='spinner3' class='spinbox-input form-control input-mask-tele'><div class='spinbox-buttons input-group-btn' placeholder='(99)-999-9999'><button type='button' class='btn spinbox-up btn-sm btn-success btn-round' onclick='div_addtel_owner()'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>";
        }else{
            div_addtel_owner += "<div class='input-group'><input type='text' id='spinner3' class='spinbox-input form-control input-mask-tele' style='border-color:#f2a696;' placeholder='(99)-999-9999'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success btn-round' onclick='div_addtel_owner()'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>";
            setTimeout(function(){
                showmodal("alert", "Fill the field first with correct format required to add more.", "", null, "", null, "0");
            }, 1000)
        }
        $("#add_tel_no_owner").html(div_addtel_owner);
        telno()
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
                if(/www(.+){2,}\.(.+){2,}/.test(value)){
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
                div_addtel_owner += "<div class='input-group' style='width:100%;'><input type='text' id='"+div+"' class='spinbox-input form-control "+format+"' placeholder='(999)-999-9999'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success btn-round' onclick='div_add_field(\""+div+"\",\""+format+"\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>";   
            }
            if(format == "input-mask-tele"){
                div_addtel_owner += "<div class='input-group' style='width:100%;'><input type='text' id='"+div+"' class='spinbox-input form-control "+format+"' placeholder='(99)-999-9999'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success btn-round' onclick='div_add_field(\""+div+"\",\""+format+"\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>";   
            }
            if(format == "emailaddress"){
                div_addtel_owner += "<div class='input-group' style='width:100%;'><input type='text' id='"+div+"' class='spinbox-input form-control email-address "+format+"' placeholder='sample@yahoo.com'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success btn-round' onclick='div_add_field(\""+div+"\",\""+format+"\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>";   
            }
            if(format == "website"){
                div_addtel_owner += "<div class='input-group' style='width:100%;'><input type='text' id='"+div+"' class='spinbox-input form-control website-input "+format+"' placeholder='www.sample.com'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success btn-round' onclick='div_add_field(\""+div+"\",\""+format+"\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>";            
            }
        }else{
            if(format == "input-mask-phone"){
                div_addtel_owner += "<div class='input-group' style='width:100%;'><input type='text' id='"+div+"' class='spinbox-input form-control "+format+"' style='border-color:#f2a696;' placeholder='(999)-999-9999'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success btn-round' onclick='div_add_field(\""+div+"\",\""+format+"\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>";            
            }
            if(format == "input-mask-tele"){
                div_addtel_owner += "<div class='input-group' style='width:100%;'><input type='text' id='"+div+"' class='spinbox-input form-control "+format+"' style='border-color:#f2a696;' placeholder='(99)-999-9999'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success btn-round' onclick='div_add_field(\""+div+"\",\""+format+"\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>"; 
            }
            if(format == "emailaddress"){
                div_addtel_owner += "<div class='input-group' style='width:100%;'><input type='text' id='"+div+"' class='spinbox-input form-control email-address "+format+"' style='border-color:#f2a696;' placeholder='sample@yahoo.com'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success btn-round' onclick='div_add_field(\""+div+"\",\""+format+"\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>"; 

                $("#div_add_contact_person_email :input").each(function(){
                    $(this).focusout(function(){
                        chkmobiledup('div_add_contact_person_email', $(this));
                    });
                });
            }
            if(format == "website"){
                div_addtel_owner += "<div class='input-group' style='width:100%;'><input type='text' id='"+div+"' class='spinbox-input form-control website-input "+format+"' style='border-color:#f2a696;' placeholder='www.sample.com'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success btn-round' onclick='div_add_field(\""+div+"\",\""+format+"\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>"; 
            }
            setTimeout(function(){
                showmodal("alert", "Fill the field first with correct format required to add more.", "", null, "", null, "0");
            }, 1000)
        }
        $("#"+div).html(div_addtel_owner);
        telno();
        autotrapfields();
    }  

    function addcontactperson(){
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
        aff += "<div class='alert alert-info div_contact_person save_this_div'><center><div class='image'><img class='img-thumbnail imageName form-control' src='assets/images/noimage5.png' id='"+idimg+"' style='border: 2px solid #bdc3c7; margin-bottom: 8px;height: 160px;width:90%;'></div><form name='posting_profilepic' id='"+fileform+"' class='posting_profilepic'><div style='display:none;'><input type='text' name='txtcon_person' class='txtcon_person'><input type='text' name='txtcon_company' class='txtcon_company'></div><input id='"+fileimg+"' name='attachment_profilepic' class='form-control upload_app_req' type='file' onchange='showimg2(\""+idimg+"\",\""+fileimg+"\");' accept='image/*'/></form></center><label style='font-size: 14px; font-weight: bold;margin: 0px !important;' class='contact_person_firstname'>"+contact_firstname+" </label>&nbsp;<label style='font-size: 14px; font-weight: bold;margin: 0px !important;' class='contact_person_middlename'>"+contact_middlename+"</label>&nbsp;<label style='font-size: 14px; font-weight: bold;margin: 0px !important;' class='contact_person_lastname'>"+contact_lastname+"</label><p style='font-size: 14px; font-weight: normal;margin: 0px !important;' class='contact_person_designation'>"+contact_designation+"</p><p style='font-size: 10px; font-weight: normal;margin: 0px !important;' class='address_person'>"+contact_address+"</p>"+div_add_contact_person_email+""+div_add_contact_person_mobile+""+div_add_contact_person_tele+"</div>";
        if((contact_firstname != "" && !contact_firstname.match(/^\s*$/)) && (contact_lastname != "" && !contact_lastname.match(/^\s*$/)) && (contact_designation != "" && !contact_designation.match(/^\s*$/)) && (contact_address != "" && !contact_address.match(/^\s*$/)) && (div_add_contact_person_email != "" || div_add_contact_person_mobile != "" || div_add_contact_person_tele != "") ){
            $( aff ).appendTo( "#div_content_contact_person_list" );
            uploadcss();
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
            $("#div_add_contact_person_email").html("<div class='input-group'><input type='text' id='spinner3' class='spinbox-input form-control' placeholder='sample@yahoo.com'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success btn-round' onclick='div_add_field(\""+div_add_contact_person_email+"\", \""+person_email+"\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>");
            $("#div_add_contact_person_mobile").html("<div class='input-group'><input type='text' id='spinner3' class='spinbox-input form-control input-mask-phone' maxlength='11' placeholder='(999)-999-9999'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success btn-round' onclick='div_add_field(\""+div_add_contact_person_mobile+"\", \""+person_mobile+"\")'> <i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>");
            $("#div_add_contact_person_tele").html("<div class='input-group'><input type='text' id='spinner3' class='spinbox-input form-control input-mask-tele'><div class='spinbox-buttons input-group-btn'><button type='button' class='btn spinbox-up btn-sm btn-success btn-round' onclick='div_add_field(\""+div_add_contact_person_tele+"\", \""+person_tele+"\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>");
            telno();
            $("#div_add_contact_person_email input").attr("style", "border-color:#D5D5D5 !important");
            $("#div_add_contact_person_mobile input").attr("style", "border-color:#D5D5D5 !important");
            $("#div_add_contact_person_tele input").attr("style", "border-color:#D5D5D5 !important");
            $('.save_contact_per').each(function() {
                if($(this).val() == ""){
                    $(this).attr("style", "border-color:#D5D5D5 !important; background-color: white !important;");
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
                    if($(this).val() == ""){
                        $(this).attr("style", "border-color:#f2a696 !important; background-color: white !important;");
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
                    showmodal("alert", "Fill all required fields.", "", null, "", null, "0");
                }, 1000)
                $('.save_contact_per').each(function(){
                    if($(this).val() ==  ""){
                        $(this).attr("style", "border-color:#f2a696 !important; background-color: white !important;");
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

    function uploadcss(){        
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

    function GenerateMerchantCode(CompanyName, Action){
        var Merchant_Code = CompanyName.replace(/[^\w\s]/gi, '').replace(/[_]/gi, '').replace(/[aeiou0123456789]/gi, '').substring(0,3).toUpperCase();
        <?php if(SysLeaseSetup('automerchantcode') == "1"){ ?>
            $.ajax({
                type: 'POST',
                url: 'mainclass.php',
                data: 'form=GenerateMerchantCode',
                success:function(data){
                    if(Action == "addnew"){
                        $("#txtmerc_code").val(Merchant_Code+data);
                    }else{
                        var arr = $("#txtmerc_code").val().split("-");
                        if(arr[1] == "" || arr[1] == "UNDEFINED"){
                            $("#txtmerc_code").val(Merchant_Code+data);
                        }else{
                            $("#txtmerc_code").val(Merchant_Code+"-"+arr[1]);
                        }
                    }
                }
            })
        <?php }else{ ?>
            $("#txtmerc_code").val(Merchant_Code);
        <?php } ?>
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
                }, 500)
            }
        }else{
            setTimeout(function(){
              showmodal("alert", "Signatory name already exist.", "", null, "", null, "1");
            }, 500)
        }
    }

    function RemoveCompSig(id){
        $("#"+id).remove();
    }
</script>