<script type="text/javascript">
    $(function(){
        CKEDITOR.replace('txtOtherUnitInfo');
        $(".fixTable").tableHeadFixer();
        fncloadMallCompanyList();
        fncloadCompanyList();
        numonly();
        $('#txtUnMCitType option[value=SET]').prop('selected','selected');
        $(".input-mask-tele").on('keypress', function (event) {
        var regex = new RegExp("^[-+() 0-9]+");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
            if (!regex.test(key)) {
                event.preventDefault();
                return false;
            }
        });
        $('.input-mask-phone').mask('(999) 999-9999');
        $(".fixTable").tableHeadFixer();
        $('.email-address').each(function(){
            $(this).focusout(function() {
                var sEmail = $(this).val();
                if($.trim(sEmail).length == 0){
                    e.preventDefault();
                    $(this).css("border-color","#D5D5D5");
                }
                if(validateEmail(sEmail)){
                    $(this).css("border-color","#D5D5D5");
                }else{
                    $(this).css("border-color","#f2a696");
                    setTimeout(function(){
                        showmodal("alert", "The email address you entered is in invalid format.", "", null, "", null, "1");
                    }, 500)
                    e.preventDefault();
                }
            });
        });
        $(".date-picker").datepicker({
            autoHide: true,
            format: 'mm/dd/yyyy',
            todayHighlight: true
        })
        $('.upper').keyup(function() {
            $(this).val($(this).val().toUpperCase());
        });
        $("#txtsearchwingref").keyup(function(e){
            var x = event.keyCode;
            if(x == 13){ 
                $("#txt_wingpage").val("1");
                loadwing(); 
            }else if(x == '8'){
                if($('#txtsearchwingref').val() == ""){
                    $("#txt_wingpage").val("1");
                    loadwing();
                }
            }
        });
        $("#txtsearchfloormc").keyup(function(e){
            var x = event.keyCode;
            if(x == 13){ 
                $('#txt_flrpage').val('1'); 
                loadfloors(); 
            }else if(x == '8'){
                if($('#txtsearchfloormc').val() == ""){
                    $('#txt_flrpage').val('1'); 
                    loadfloors();
                }
            }
        });
        $("#txtsearchamenities").keyup(function(e){
            var x = event.keyCode;
            if(x == 13){ 
                $("#txt_unitpage").val("1");
                loadunit(); 
            }else if(x == '8'){
                if($('#txtsearchamenities').val() == ""){
                    $("#txt_unitpage").val("1");
                    loadunit();
                }
            }
        });
        <?php if(SysLeaseSetup('floorandunitmeasurement') == "Area"){ ?>
            $(".isLengthWidth").css("display", "none");
            $(".isArea").css("display", "block");
            $("#txtTLA").addClass("txtreq_flr");
            $("#txtGLA").addClass("txtreq_flr");
            $("#txtwidth").removeClass("txtreq_flr");
            $("#txtlength").removeClass("txtreq_flr");
            $("#txtminarea").removeClass("txtreq_flr");

            $("#txtMCUnitArea").addClass("req_unit");
            $("#txtMCUnitLength").removeClass("req_unit");
            $("#txtMCUnitWidth").removeClass("req_unit");

            $("#txtSubUnitArea").addClass("txtSubUnitInfo");
            $("#txtSubUnitLength").removeClass("txtSubUnitInfo");
            $("#txtSubUnitWidth").removeClass("txtSubUnitInfo");
        <?php }else{ ?>
            $(".isLengthWidth").css("display", "block");
            $(".isArea").css("display", "none");
            $("#txtwidth").addClass("txtreq_flr");
            $("#txtlength").addClass("txtreq_flr");
            $("#txtminarea").addClass("txtreq_flr");
            $("#txtTLA").removeClass("txtreq_flr");
            $("#txtGLA").removeClass("txtreq_flr");

            $("#txtMCUnitArea").removeClass("req_unit");
            $("#txtMCUnitLength").addClass("req_unit");
            $("#txtMCUnitWidth").addClass("req_unit");

            $("#txtSubUnitArea").removeClass("txtSubUnitInfo");
            $("#txtSubUnitLength").addClass("txtSubUnitInfo");
            $("#txtSubUnitWidth").addClass("txtSubUnitInfo");
        <?php } ?>        
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'form=ifleasingisselected',
            success:function(data){
                if(data == "1"){
                    $("#ifleasingisselected").css("display", "block");
                }else{
                    $("#ifleasingisselected").css("display", "none");
                }
            }
        })
        $('#txtUnitImage').ace_file_input({
            style: 'well',
            btn_choose: 'Drop files here or click to choose',
            btn_change: null,
            no_icon: 'ace-icon fa fa-cloud-upload',
            droppable: true,
            thumbnail: 'small'//large | fit
            //,icon_remove:null//set null, to hide remove/reset button
            /**,before_change:function(files, dropped) {
                //Check an example below
                //or examples/file-upload.html
                return true;
            }*/
            /**,before_remove : function() {
                return true;
            }*/
            ,
            preview_error : function(filename, error_code) {
                //name of the file that failed
                //error_code values
                //1 = 'FILE_LOAD_FAILED',
                //2 = 'IMAGE_LOAD_FAILED',
                //3 = 'THUMBNAIL_FAILED'
                //alert(error_code);
            }
    
        }).on('change', function(){
            //console.log($(this).data('ace_input_files'));
            //console.log($(this).data('ace_input_method'));
        });
        $('.UserImage').ace_file_input({
            no_file:'No File ...',
            btn_choose:'Choose',
            btn_change:'Change',
            droppable:false,
            onchange:null,
            thumbnail:false
        });
        $(".rdAdminFeeType").click(function(){
            if($(this).is(":checked")){
                if($(this).val() == 0){
                    $(".AdminFeeTypeHide1").addClass("input-icon-right");
                    $(".AdminFeeTypeHide2").addClass("fa-percent");
                }else{
                    $(".AdminFeeTypeHide1").removeClass("input-icon-right");
                    $(".AdminFeeTypeHide2").removeClass("fa-percent");
                }
            }
        })
    });

    function validateEmail(sEmail){
        var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if(filter.test(sEmail)){
            return true;
        }else{
            return false;
        }
    }

    function numonly(){
       $(".numonly").keydown(function(event) {
            if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 190 || event.keyCode == 9 || event.keyCode == 188) {
            }else{
                if (event.keyCode < 48 || event.keyCode > 57 || event.keyCode == 17) {
                   event.preventDefault(); 
                }   
            }
        });
        $(".amount").change(function(){
            var x = ($(this).val()).replace(/,/g,"");
            var v = parseFloat(x||0);
            $(this).val(v.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
       });
        $(".amount2").change(function(){
            var x = ($(this).val()).replace(/,/g,"");
            var v = parseFloat(x||0);
            $(this).val(v.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
       });
    }

    function filecss(){        
        var tag_input = $('#form-field-tags');
        try{
            tag_input.tag({
                placeholder:tag_input.attr('placeholder'),
                source: ace.vars['US_STATES'],
            })
            var $tag_obj = $('#form-field-tags').data('tag');
            var index = $tag_obj.inValues('some tag');
            $tag_obj.remove(index);
        }
        catch(e) {
            tag_input.after('<textarea id="'+tag_input.attr('id')+'" name="'+tag_input.attr('name')+'" rows="3">'+tag_input.val()+'</textarea>').remove();
        }
        $('.upload_app_req').ace_file_input({
          no_file:'No File ...',
          btn_choose:'Choose',
          btn_change:'Change',
          droppable:false,
          onchange:null,
          thumbnail:false 
        });
    }

//Mall Company Start
    function fncMallNewCompany(){
        $("#mdlNewMallCompany").modal("show");
        $(".txtClearMallCompany").val("");
        $(".txtMallCompanyReq").css("border-color","#D5D5D5");
        $("#imgMallCompanyImage").attr("src", "assets/images/noimage5.png")
        $("#frmMallCompanyImage").find("a").click();
        $("#hrMallCompany").text("New Company");
    }

    function fncShowCompanyImage(){
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("txtMallCompanyImage").files[0]);
        oFReader.onload = function (oFREvent) {
            document.getElementById("imgMallCompanyImage").src = oFREvent.target.result;
        };
    }

    function fncSaveMallCompany(){
        var MallCompanyID = $("#txtMallCompanyID").val();
        var MallCompanyName = $("#txtMallCompanyName").val();
        var MallCompanyAbout = $("#txtMallCompanyAbout").val();
        var MallCompanyMobile = $("#txtMallCompanyMobile").val();
        var MallCompanyTelephone = $("#txtMallCompanyTelephone").val();
        var MallCompanyEmail = $("#txtMallCompanyEmail").val();
        var MallCompanyAddress = $("#txtMallCompanyAddress").val();
        var Count = 0;
        $(".txtMallCompanyReq").each(function(){
            if($(this).val() == ""){
                Count++;
            }
        })
        if(Count == 0){
            $.ajax({
                type: 'POST',
                url: 'setup/mall_configuration/class.php',
                data: '&MallCompanyID=' + MallCompanyID + '&MallCompanyName=' + MallCompanyName + '&MallCompanyAbout=' + MallCompanyAbout + '&MallCompanyMobile=' + MallCompanyMobile + '&MallCompanyTelephone=' + MallCompanyTelephone + '&MallCompanyEmail=' + MallCompanyEmail + '&MallCompanyAddress=' + MallCompanyAddress + '&form=fncSaveMallCompany',
                success: function(data){
                    var arr = data.trim().split("|");
                    if(arr[0].trim() == "1"){
                        setTimeout(function(){
                            showmodal("alert", arr[1].trim(), "fncMallCompanyImage", arr[2].trim()+"|", "", null, "0");
                        }, 500)
                    }else{
                        setTimeout(function(){
                            showmodal("alert", arr[1].trim(), "", null, "", null, "1");
                        }, 500)
                    }
                }

            })
        }else{
            setTimeout(function(){
                showmodal("alert", "Please fill all fields.", "", null, "", null, "1");
            }, 500)
        }
    }

    function fncMallCompanyImage(MallCompanyID){
        $("#txtMallCompanyID").val(MallCompanyID);
        var data = new FormData($('#frmMallCompanyImage')[0]);
        $.ajax({
            type: 'POST',
            url: 'Uploads/uploadmallcompany.php',
            data: data,
            mimeType: 'multipart/form-data',
            contentType: false,
            cache: false,
            processData: false,
            success: function(data){
                $("#mdlNewMallCompany").modal("hide");
                $(".txtClearMallCompany").val("");
                $(".txtMallCompanyReq").css("border-color","#D5D5D5");
                $("#imgMallCompanyImage").attr("src", "assets/images/noimage5.png")
                $("#frmMallCompanyImage").find("a").click();
                fncloadMallCompanyList();
            }
        })
    }

    function fncloadMallCompanyList(){
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'form=fncloadMallCompanyList',
            success: function(data){
                $("#div_MallCompany").html(data);
            }
        })
    }

    function fncEditMallCompany(MallCompanyID){
        $("#mdlNewMallCompany").modal("show");
        $("#hrMallCompany").text("Edit Company");
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'MallCompanyID=' + MallCompanyID + '&form=fncEditMallCompany',
            success: function(data){
                var arr = data.split("|");
                $("#txtMallCompanyID").val(MallCompanyID);
                $("#txtMallCompanyName").val(arr[0]);
                $("#txtMallCompanyAbout").val(arr[1]);
                $("#txtMallCompanyMobile").val(arr[2]);
                $("#txtMallCompanyTelephone").val(arr[3]);
                $("#txtMallCompanyEmail").val(arr[4]);
                $("#txtMallCompanyAddress").val(arr[5]);
                $("#imgMallCompanyImage").attr("src", arr[6]);
            }
        })
    }
//Mall Company End

//Mall Config Start
    function fncloadCompanyList(){
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'form=fncloadCompanyList',
            success: function(data){
                $(".searchy_select").select2();
                $(".select2-selection").css('height','33px');
                $("#txtmall_Company").html(data);
            }
        })
    }

    function loadmalls(){
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'form=loaddivmalls',
            beforeSend : function() {
                $('#indexloadingscreen').addClass('myspinner');
            },
            success: function(data){
                $('#indexloadingscreen').removeClass('myspinner');
                $("#div_malls").html(data);
                loadmallcurrentmallcount();
            }
        })
    }

    function savenewamenitiesref(){
        var newame =  $("#txtaddnewrefame").val();
        var radio = $('input[name="count_type"]:checked').val();
        if(newame != "" && radio != ""){
            $.ajax({
                type: 'POST',
                url: 'setup/mall_configuration/class.php',
                data: 'newame=' + newame + '&radio=' + radio + '&form=savenewamenitiesref',
                success: function(data){
                    if(data == 1){
                        loadaddedameni();
                        loadtblamenitiesreflist();
                    }
                }
            })
        }else{
            setTimeout(function(){
                showmodal("alert", "All fields are required to be filled.", "", null, "", null, "1");
            }, 500)
        }
    }

    function loadmallcurrentmallcount(){
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'form=loadmallcount',
            success: function(data){
                $("#currentmallcount").val(data);
            }
        })
    }

    function loadaddedameni(){
        var amenities = "WHERE ";
        var i = 0;
        $("#tblamenitiesreflist .amenities_chk").each(function(){
            var values = $(this).attr("value");
            i++;
            if(i == 1){
                amenities += "amenitiesid != '"+values+"' ";
            }else{
                amenities += "AND amenitiesid != '"+values+"' ";
            }
            
        });
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'amenities=' + amenities + '&form=loadaddedameni',
            success: function(data){
                $( data ).appendTo( "#tblamenitiesreflist" );
                $("input[name='count_type']").prop("selected", false);
                $("#txtaddnewrefame").val("");
                numonly()
            }
        })
    }

    function configuremall(id){
        $("#txtmall_id").val(id);
        $("#txtImportMallID").val(id);
        $("#txt_wingpage").val("1");
        loadwing();
        $("#modalconfiguremodal").modal("show");
        $("#div_tex_header_con").text("Configure");
    }

    function showimg123(){
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("file_upload").files[0]);
        oFReader.onload = function (oFREvent) {
            document.getElementById("img_mallinfo").src = oFREvent.target.result;
        };
    }

    function newmall(){
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'form=maxmallcount',
            success: function(data){
                var mc = $("#currentmallcount").val();
                if(mc < data ){
                    $(".mall-info").val("");
                    $("#txtmall_id").val("");
                    $("#img_mallinfo").prop("src", "assets/images/noimage5.png");
                    $("#posting_profilepic").css("display", "inline");
                    $("#btn_changedp").css("display", "none");
                    $("#mdlNewMall").modal("show");
                    $("#div_tex_header_con").text("New");
                    $("#posting_profilepic").html('<div style="display: none;"><input type="text" id="txtmallid_forms" name="txtmallid_forms"></div><input id="file_upload" name="attachment_profilepic" class="form-control upload_app_req" type="file" style="margin-top: 20px;" onchange="showimg123();" accept="image/*"/>');
                    filecss();
                    fncloadCompanyList();
                }else{
                    setTimeout(function(){
                        showmodal("alert", "Maximum number of mall already reached.", "", null, "", null, "0");
                    }, 500)
                }
            }
        })
    }

    function editmall(id){
        $("#txtmall_id").val(id);
        $("#posting_profilepic").html('<div style="display: none;"><input type="text" id="txtmallid_forms" name="txtmallid_forms"></div><input id="file_upload" name="attachment_profilepic" class="form-control upload_app_req" type="file" style="margin-top: 20px;" onchange="showimg123();" accept="image/*"/>');
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'id=' + id + '&form=editmallinformation',
            success: function(data){
                var arr = data.split("|");
                $("#img_mallinfo").prop("src", arr[4]);
                $("#posting_profilepic").css("display", "none");
                $("#btn_changedp").css("display", "inline");
                $("#txtmall_name").val(arr[1]);
                $("#txtmall_loc").val(arr[2]);
                $("#txtmall_abouts").val(arr[3]);
                $("#txtmall_telephone").val(arr[5]);
                $("#txtmall_email").val(arr[6]);
                $("#txtmall_tinnum").val(arr[7]);
                $("#txtmallTenantIDPref").val(arr[8].trim());
                $("#txtmall_Company").val([arr[9].trim()]).trigger('change');
                filecss();
                $("#mdlNewMall").modal("show");
                $("#div_tex_header_con").text("Edit");
            }
        })
    }

    function updateaccdp(){
      $("#posting_profilepic").css("display", "inline");
      $("#btn_changedp").css("display", "none");
    }

    function savemallupdate(){
        var id = $("#txtmall_id").val();
        var company = $("#txtmall_Company").val();
        var name = $("#txtmall_name").val();
        var loc = $("#txtmall_loc").val();
        var abouts = $("#txtmall_abouts").val();
        var telephone = $("#txtmall_telephone").val();
        var email = $("#txtmall_email").val();
        var tinnumber = $("#txtmall_tinnum").val();
        var TenantIDPref = $("#txtmallTenantIDPref").val();
        var countinput = 0;
        $("#mdlNewMall .required").each(function() {
            if($(this).val() == ""){
                countinput++;
                $(this).css("border-color","#f2a696");
            }else{
                $(this).css("border-color","#D5D5D5");
            }
        })
        if(countinput == 0){
            $.ajax({
                type: 'POST',
                url: 'setup/mall_configuration/class.php',
                data: 'tinnumber=' + tinnumber + '&id=' + id + '&company=' + company + '&name=' + name + '&loc=' + loc + '&abouts=' + abouts + '&telephone=' + telephone + '&email=' + email + '&TenantIDPref=' + TenantIDPref + '&form=savemallupdate',
                success: function(data){
                    var arr = data.split("|");
                    if(arr[0] == "2"){
                        setTimeout(function(){
                            showmodal("alert", "Mall successfully modified.", "", null, "", null, "0");
                        }, 500)
                        sendData(arr[1])
                        $("#mdlNewMall").modal("hide");
                    }else if(arr[0] == "1"){
                        setTimeout(function(){
                            showmodal("alert", "Mall successfully added.", "", null, "", null, "0");
                        }, 500)
                        sendData(arr[1]);
                        $(".mall-info").val("");
                        $("#txtmall_id").val("");
                        $("#img_mallinfo").prop("src", "assets/images/noimage5.png");
                        $("#posting_profilepic").css("display", "inline");
                        $("#btn_changedp").css("display", "none");
                        $("#posting_profilepic").html('<div style="display: none;"><input type="text" id="txtmallid_forms" name="txtmallid_forms"></div><input id="file_upload" name="attachment_profilepic" class="form-control upload_app_req" type="file" style="margin-top: 20px;" onchange="showimg123();" accept="image/*"/>');
                        filecss();
                        loadmallcurrentmallcount();
                        $("#mdlNewMall").modal("hide");
                    }
                }
            })
        }else{
            setTimeout(function(){
                showmodal("alert", "Please fill all fields.", "", null, "", null, "1");
            }, 500)
        }
    }

    function deletemall(id){
        $("#dimakita").val(id);
        setTimeout(function(){
            showmodal("confirm", "Deactivate this mall?", "deletemall2", null, "", null,0);
        }, 500)
    }

    function deletemall2(){
        var id = $("#dimakita").val();
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'id=' + id + '&form=deletemall',
            success: function(data){
                if(data == 1){
                    setTimeout(function(){
                        showmodal("alert", "Mall successfully deactivated.", "loadmalls", null, "", null, 0);
                    }, 1000)
                }
            }
        })        
    }

    function reactivate(id){
        $("#dimakita").val(id);
        setTimeout(function(){
            showmodal("confirm", "Deactivate this mall?", "reactivate2", null, "", null,0);
        }, 500)
    }

    function reactivate2(){
        var id = $("#dimakita").val();
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'id=' + id + '&form=reactivate',
            success: function(data){
                if(data == 1){
                    setTimeout(function(){
                        showmodal("alert", "Mall successfully reactivated.", "loadmalls", null, "", null, 0);
                    }, 1000)
                }
            }
        })        
    }

    function sendData(mallid){
        $("#txtmallid_forms").val(mallid);
        var data = new FormData($('#posting_profilepic')[0]);
        $.ajax({
            type:"POST",
            url:"setup/mall_configuration/uploadmallpic.php",
            data: data,
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            success:function(data){
                loadmalls();
            }
        });
    }
//Mall Config END

// WING FUNCTIONS START
    function loadwing(){
        var key = $("#txtsearchwingref").val();
        var page = $("#txt_wingpage").val();
        var mallid = $("#txtmall_id").val();
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'key=' + key + '&page=' + page + '&mallid=' + mallid + '&form=loadwing',
            beforeSend : function() {
                $('#divParent').addClass('myspinner');
            },
            success: function(data){
                $('#divParent').removeClass('myspinner');
                $("#tblwinglist").html(data);
                loadpaginationwing();
                loadentrieswing();                  
            }
        })
    }

    function loadpaginationwing(){
        var key = $("#txtsearchwingref").val();
        var page = $("#txt_wingpage").val();
        var mallid = $("#txtmall_id").val();
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'key=' + key + '&page=' + page + '&mallid=' + mallid + '&form=loadpaginationwing',
            success: function(data){
                $("#ulpaginationwing").html(data);
            }
        })
    }

    function getvalwing(page, pagenums){
        $(".pgnumptnts").removeClass("active");
        $("#pgptnts" + pagenums).addClass("active");
        $("#txt_wingpage").val(page);
        loadwing();
    }

    function loadentrieswing(){
        var key = $("#txtsearchwingref").val();
        var page = $("#txt_wingpage").val();
        var mallid = $("#txtmall_id").val();
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'key=' + key + '&page=' + page + '&mallid=' + mallid + '&form=loadentrieswing',
            success: function(data){
                $("#txtwingentries").text(data);
            }
        });
    }  

    function loadmodal_wing(){
        $("#modal_addnewwing").modal("show");
        $(".text_wing").val("");
    }  

    function savewing(){
        var i = 0;
        $(".req_wing").each(function(){
            if($(this).val() == "" || ($(this).val()).match(/^\s*$/)){
                i++;
                $(this).css("border-color","#f2a696");
            }else{
                $(this).css("border-color","#D5D5D5");
            }
        });
        if(i == 0){
            var wingname = $("#txtwingname").val();
            var mallid = $("#txtmall_id").val();
            var id = $("#txtrefwing").val();
            $.ajax({
                type: 'POST',
                url: 'setup/mall_configuration/class.php',
                data: 'mallid=' + mallid + '&wingname=' + wingname + '&id=' + id + '&form=savewing',
                success: function(data){
                    if(data.trim() == "1"){
                        $(".req_wing").css("border-color","#D5D5D5");
                        setTimeout(function(){
                            showmodal("alert", "Successfully added.", "loadwing", null, "", null, "0");
                        }, 500)
                        $(".req_wing").val("");
                        // $("#modal_addnewwing").modal("hide");
                    }else if(data.trim() == "2"){
                        $(".req_wing").css("border-color","#D5D5D5");
                        setTimeout(function(){
                            showmodal("alert", "Successfully modified.", "loadwing", null, "", null, "0");
                        }, 500)
                        $(".req_wing").val("");
                        $("#modal_addnewwing").modal("hide");
                    }else if(data.trim() == "3"){
                        $(".req_wing").css("border-color","#D5D5D5");
                        setTimeout(function(){
                            showmodal("alert", "Already existing!", "", null, "", null, "1");
                        }, 500)
                        $(".req_wing").val("");
                    }else{
                        $(".req_wing").css("border-color","#D5D5D5");
                        setTimeout(function(){
                            showmodal("alert", "Failed to save.", "", null, "", null, "1");
                        }, 500)
                        $(".req_wing").val("");
                    }
                }
            })
        }else{
            setTimeout(function(){
                showmodal("alert", "Please fill all fields.", "", null, "", null, "1");
            }, 500)
            $('.req_wing').each(function() {
                if ( this.value === '' ) {
                    this.focus();
                    return false;
                }
            });
        }
    }

    function editrefwing(wing){
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'id=' + wing + '&form=editrefwing',
            success: function(data){
                var arr = data.split("|");
                $("#txtwingname").val(arr[2]);
                $("#txtrefwing").val(arr[1]);
                $("#modal_addnewwing").modal("show");   
            }
        })
    }

    function delrefwing(wing){
        setTimeout(function(){
            showmodal("confirm", "Are you sure you want to delete this wing?", "delrefwing2", wing+"|", "", null, "0");
        }, 500)
    }

    function delrefwing2(wing){
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'id=' + wing + '&form=delrefwing',
            success: function(data){
                loadwing();
            }
        })
    }

    function closemodalwing(){
        $('#modal_addnewwing').modal('hide');
    }
// WING FUNCTIONS END

//FLOOR FUNCTIONS START
    function refFloorFunc(){
        $('#txt_flrpage').val('1'); 
        loadwingdet(); 
        loadwingdetails(); 
        loaddropflr(); 
        setTimeout(function(){
            loadfloors();
        }, 1000)
    }

    function loadfloors(){
        var key = $("#txtsearchfloormc").val();
        var type = $("#txtfilterby").val();
        var page = $("#txt_flrpage").val();
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'key=' + key + '&type=' + type + '&page=' + page + '&form=loadfloors',
            beforeSend : function() {
                $('#divParent').addClass('myspinner');
            },
            success: function(data){
                $('#divParent').removeClass('myspinner');
                $("#tblfloorslist").html(data);
                loadpaginationflr();
                loadentriesflr();
            }
        })
    }

    function loadpaginationflr(){
        var key = $("#txtsearchfloormc").val();
        var type = $("#txtfilterby").val();
        var page = $("#txt_flrpage").val();
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'key=' + key + '&type=' + type + '&page=' + page + '&form=loadpaginationflr',
            success: function(data){
                $("#ulpaginationflr").html(data);
            }
        })
    }

    function getvalflr(page, pagenums){
        $(".pgnumptnts").removeClass("active");
        $("#pgptnts" + pagenums).addClass("active");
        $("#txt_flrpage").val(page);
        loadfloors();
    }

    function loadentriesflr(){
        var key = $("#txtsearchfloormc").val();
        var type = $("#txtfilterby").val();
        var page = $("#txt_flrpage").val();
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'key=' + key + '&type=' + type + '&page=' + page + '&form=loadentriesflr',
            success: function(data){
                $("#txtflrentries").text(data);
            }
        })
    }                       

    function editreffloor(floor){
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'id=' + floor + '&form=editreffloor',
            success: function(data){
                var arr = data.split("|");
                $("#txtwings").val(arr[0]);
                $("#txtfloor").val(arr[1]);
                $("#txtreffloor").val(arr[2]);
                <?php if(SysLeaseSetup('floorandunitmeasurement') == "Area"){ ?>
                    $("#txtTLA").val(arr[6]);
                    $("#txtGLA").val(arr[7]);
                <?php }else{ ?>
                    $("#txtwidth").val(arr[3]);
                    $("#txtlength").val(arr[4]);
                    $("#txtminarea").val(arr[5]);
                <?php } ?>
                $("#modal_addnewfloor").modal("show");  
            }
        })
    }

    function delreffloor(floor){
        setTimeout(function(){
            showmodal("confirm", "Are you sure you want to delete this floor?", "delreffloor2", floor+"|", "", null, "0");
        }, 500)
    }

    function delreffloor2(floor){
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'id=' + floor + '&form=delreffloor',
            success: function(data){
                loadfloors();
            }
        })
    }

    function savefloor(){
        var i = 0;
        $(".txtreq_flr").each(function(){
            if($(this).val() == "" || ($(this).val()).match(/^\s*$/)){
                i++;
                $(this).css("border-color","#f2a696");
            }else{
                $(this).css("border-color","#D5D5D5");
            }
        });

        if(i == 0){        
            var wingid = $("#txtwings").val();
            var floorid = $("#txtreffloor").val();
            var floor = $("#txtfloor").val();
            var mallid = $("#txtmall_id").val();
            var width = $("#txtwidth").val();
            var length = $("#txtlength").val();
            var minarea = $("#txtminarea").val();
            var TLA = $("#txtTLA").val();
            var GLA = $("#txtGLA").val();
            $.ajax({
                type: 'POST',
                url: 'setup/mall_configuration/class.php',
                data: 'floor=' + floor + '&floorid=' + floorid + '&wingid=' + wingid + '&mallid=' + mallid + '&width=' + width + '&length=' + length + '&minarea=' + minarea + '&TLA=' + TLA + '&GLA=' + GLA + '&form=savefloor',
                success: function(data){
                    if(data == "Already Existing."){
                        $(".txtreq_flr").css("border-color","#f2a696");
                        setTimeout(function(){
                            showmodal("alert", data, "", null, "", null, "1");
                        }, 500)
                    }else if(data == "Successfully modified."){
                        $(".txtreq_flr").css("border-color","#D5D5D5");
                        setTimeout(function(){
                            showmodal("alert", data, "", null, "", null, "0");
                        }, 500)
                        $(".txtreq_flr").val("");
                        loadfloors();                   
                    }else{
                        $(".txtreq_flr").css("border-color","#D5D5D5");
                        setTimeout(function(){
                            showmodal("alert", data, "", null, "", null, "0");
                        }, 500)
                        $(".txtreq_flr").val("");
                        loadfloors();                   
                    }
                }
            })
        }else{
            setTimeout(function(){
                showmodal("alert", "Please fill all fields.", "", null, "", null, "1");
            }, 500)
            $('.txtreq_flr').each(function() {
                if ( this.value === '' ) {
                    this.focus();
                    return false;
                }
            });
        }
    }

    function loadmodal_floor(){
        $("#modal_addnewfloor").modal("show");
        $(".text_floor").val("");
        var filter = $("#txtfilterby").val();
        $("#txtwings").val(filter);
    }

    function cloaseflrmodal(){
        $("#modal_addnewfloor").modal("hide");
    }

    function cloaseflrmodal2(){
         $("#modal_addnewreffloor").modal("hide");
    }    

    function loadwingdetails(){
        var ids = $("#txtmall_id").val();
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'id=' + ids + '&form=loadwingdetails',
            success: function(data){
                $("#txtwings").html(data);
            }
        })
    }

    function loadrefflrdetails(){
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'form=loadrefflrdetails',
            success: function(data){
                $("#tblfloorsreflist").html(data);
            }
        })
    }

    function loadwingdet(){
        var ids = $("#txtmall_id").val();
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'id=' + ids + '&form=loadwingdetails2',
            success: function(data){
                $("#txtfilterby").html(data);
                $('select[name=txtfilterby] option:eq(1)').attr('selected', 'selected');
            }
        })
    }

    function loaddropflr(){
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'form=loaddropflr',
            success: function(data){
                $("#txtfloor").html(data);
            }
        })
    }

    function loaddropflr2(cont){
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'form=loaddropflr',
            success: function(data){
                $("#txtfloor").html(data);
                $('#txtfloor option[value="'+cont+'"]').prop('selected','selected');
            }
        })
    }

    function addnewreffloor(){
        loadrefflrdetails();
        $("#modal_addnewreffloor").modal("show");
    }

    function savereffloor(){
        var flr = $("#txtaddnewrefflr").val();
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'flr=' + flr + '&form=savereffloor',
            success: function(data){
                if(data == 1){
                    loadrefflrdetails();
                    loaddropflr2(flr);
                    $("#modal_addnewreffloor").modal("hide");
                }else if(data == 2){
                    setTimeout(function(){
                        showmodal("alert", "Floor is already existing.", "", null, "", null, "1");
                    }, 500)
                }
            }
        })
    }
//FLOOR FUNCTIONS END

// UNIT FUNCTIONS START
    function refUnitFunc(){
        $("#txt_unitpage").val("1");
        loadunit();
    }

    function addnewrefamenities(){
        $("input[name='count_type']").prop("selected", false);
        $("#txtaddnewrefame").val("");
        $("#modal_addnewrefamenities").modal("show");
        loadtblamenitiesreflist();
    }

    function closemodalrefam(){
        $("#modal_addnewrefamenities").modal("hide");
    }

    function checkamenities(chk){
        if($("#trsschk_"+chk).is(":checked")){
             $("#trss_"+chk).css("display", "table");
        }else{
            $("#trss_"+chk).css("display", "none");
        }
    }

    function addamenitiesselected(){
        var a = 0;
        var b = 0;
        var c = 0;
        var amenities = "";
        $("#tblamenitiesreflist .amenities_chk").each(function(){
            if($(this).is(":checked")){
                c++
                var value = $(this).attr("value");
                var lbl = $("#amenities_chk_"+value).text();
                var qty = $("#txtqty_"+value).val();
                if(qty == undefined){
                    var thisqty = "1";
                }else{
                    a++;
                    if(qty == "" || qty.match(/^\s*$/)){

                    }else{
                        b++;
                        var thisqty = qty;
                    }
                }
                if(a == b){
                    amenities += '<span class="tag tagval_'+value+'" id="span_'+value+'">'+lbl+'<button type="button" class="close">×</button><input type="hidden" value="'+thisqty+'" class="qty_amenities"><input type="hidden" value="'+value+'" class="chosen_amenities"></span>';
                }else{
                   
                }
            }
        });
        if(a == b){
            if(c == 0){
                showmodal("alert", "Check first your chosen amenity.", "", null, "", null, "1");
            }else{
                $("#div_amenitiesselected").html(amenities + '<br/><label style="width: 100%;" onclick="addnewrefamenities()">Click to add facilities ..</label></div>');
                $("#modal_addnewrefamenities").modal("hide");                
            }
        }else{
            showmodal("alert", "Please enter qty.", "", null, "", null, "1");
        }      
    }

    function loadtblamenitiesreflist(){
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'form=loadtblamenitiesreflist',
            success: function(data){
                $("#tblamenitiesreflist").html(data);
                numonly();
            }
        })
    }

    function loadunit(){
        var key = $("#txtsearchamenities").val();
        var page = $("#txt_unitpage").val();
        var mallid = $("#txtmall_id").val();
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'key=' + key + '&page=' + page + '&mallid=' + mallid + '&form=loadunit',
            beforeSend : function() {
                $('#divParent').addClass('myspinner');
            },
            success: function(data){
                $('#divParent').removeClass('myspinner');
                $("#tblunitlist").html(data);
                loadpaginationunit();
                loadentriesunit();
            }
        })
    }

    function loadpaginationunit(){
        var key = $("#txtsearchamenities").val();
        var page = $("#txt_unitpage").val();
        var mallid = $("#txtmall_id").val();
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'key=' + key + '&page=' + page + '&mallid=' + mallid + '&form=loadpaginationunit',
            success: function(data){
                $("#ulpaginationunit").html(data);
            }
        });
    }

    function loadentriesunit(){
        var key = $("#txtsearchamenities").val();
        var page = $("#txt_unitpage").val();
        var mallid = $("#txtmall_id").val();
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'key=' + key + '&page=' + page + '&mallid=' + mallid + '&form=loadentriesunit',
            success: function(data){
                $("#txtunitentries").text(data);
            }           
        });
    } 

    function getvalunit(page, pagenums){
        $(".pgnumptnts").removeClass("active");
        $("#pgptnts" + pagenums).addClass("active");
        $("#txt_unitpage").val(page);
        loadunit();
    }

    function checkbustypevalue(){
        var mallid = $("#txtmall_id").val();
        var bus = $("#txtMCUnitType").val();
        if(bus == "LCA"){
            $("#txtMCUnitWing").removeClass("req_unit");
            $("#txtMCUnitFloor").removeClass("req_unit");
        }else if(bus == "SET"){
            $("#txtMCUnitWing").removeClass("req_unit");
            $("#txtMCUnitFloor").removeClass("req_unit");   
            $("#txtMCUnitWing").addClass("req_unit");
            $("#txtMCUnitFloor").addClass("req_unit");            
        }
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'bus=' + bus + '&mallid=' + mallid + '&form=checkbustypevalue',
            success:function(data){
                if(data == "1"){
                    setTimeout(function(){
                        showmodal("alert", "Maximum limit of "+ bus +" units for this mall already reached", "", null, "", null, "1");
                    }, 500)
                    $("#txtMCUnitType").val("");
                }
            }
        })
    }

    function getallamenities(unitid){
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'id=' + unitid + '&form=getallamenities',
            success: function(data){
                $("#div_amenitiesselected").html(data);
            }
        })
    }

    function loadmallls(mallid, selectedwing){
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'id=' + mallid + '&form=loadmallls',
            success: function(data){
                $("#txtMCUnitWing").html(data);
            }, complete: function(){
                $("#txtMCUnitWing").val(selectedwing).trigger("change"); 
            }
        })
    }

    function delrefunit(unit){
        setTimeout(function(){
            showmodal("confirm", "Are you sure you want to delete this unit?", "delrefunit2", unit+"|", "", null, "0");
        }, 500)
    }

    function delrefunit2(floor){
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'id=' + unit + '&form=delrefunit',
            success: function(data){
                loadunit();
            }
        })
    }

    function fncExpandSubs(UnitID){
        if($("#iExpand"+UnitID).hasClass("fa-angle-double-down")){
            $(".trList"+UnitID).css("display", "table-row");
            $("#iExpand"+UnitID).removeClass("fa-angle-double-down");
            $("#iExpand"+UnitID).addClass("fa-angle-double-up");
        }else{
            $(".trList"+UnitID).css("display", "none");
            $("#iExpand"+UnitID).removeClass("fa-angle-double-up");
            $("#iExpand"+UnitID).addClass("fa-angle-double-down");
        }
    }

    function loadwingflr2(flrid, selected){
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'id=' + flrid + '&form=loadwingflr',
            success: function(data){
                $("#txtwing").html(data);
                $("#txtwing").val(selected);
            }
        })  
    }

    function saveunit(){
        var i = 0;
        $(".req_unit").each(function(){
            if($(this).val() == "" || ($(this).val()).match(/^\s*$/)){
                i++;
                $(this).css("border-color","#f2a696");
            }else{
                $(this).css("border-color","#D5D5D5");
            }
        });
        if(i == 0){ 
            var id = $("#txtrefunit").val();
            var flrid = $("#txtMCUnitFloor").val();
            var wingid = $("#txtMCUnitWing").val();
            var UnitClass = $("#txtMCUnitClass").val();
            var depid = $("#txtdepartments").val();
            var catid = $("#txtcategories").val();
            var sqm_height = $("#txtMCUnitLength").val();
            var sqm_width = $("#txtMCUnitWidth").val();
            var pricepersqm = $("#txtMCUnitRate").val().replace(/,/g, "");
            <?php if(SysLeaseSetup('isAssocDues') == "1"){ ?>
            var assocdues = $("#txtMCAssocDues").val().replace(/,/g, "");
            <?php }else{ ?>
            var assocdues = 0;
            <?php } ?>
            var bldgname = $("#txtMCUnitWing").val();
            var bldgid = $("#txtMCUnitWing").attr("value");
            var unitname = $("#txtMCUnitName").val();
            var bustype = $("#txtMCUnitType").val();
            var mallid = $("#txtmall_id").val();
            var amenities = "";
            $("#div_amenitiesselected .tag").each(function(){
                var qty = $(this).find(".qty_amenities");
                var chosen = $(this).find(".chosen_amenities");
                var qtyval = qty.val(); 
                var chosenval = chosen.val(); 
                amenities += "#"+chosenval+"|"+qtyval+"|";
            });
            var txtArea = $("#txtMCUnitArea").val();
            var BillingType = "Individual";
            // $(".UnitBillingSetup").each(function(){
            //     if($(this).is(":checked")){
            //         BillingType = $(this).val();
            //     }
            // })
            var ckEditorData = CKEDITOR.instances['txtOtherUnitInfo'].getData();
            $.ajax({
                type: 'POST',
                url: 'setup/mall_configuration/class.php',
                data: 'id=' + id + '&mallid=' + mallid + '&flrid=' + flrid + '&wingid=' + wingid + '&sqm_height=' + sqm_height + '&sqm_width=' + sqm_width + '&pricepersqm=' + pricepersqm + '&bldgid=' + bldgid + '&unitname=' + unitname + '&UnitClass=' + UnitClass + '&bustype=' + bustype + '&amenities=' + amenities + '&depid=' + depid + '&catid=' + catid + '&assocdues=' + assocdues + '&txtArea=' + txtArea + '&BillingType=' + BillingType + '&ckEditorData=' + encodeURIComponent(ckEditorData) + '&form=saveunit',
                success: function(data){
                    var arr = data.split("|");
                    if(arr[0] == 1){
                        setTimeout(function(){
                            showmodal("alert", arr[1], "fncResetFields", null, "", null, "0");
                        }, 500)
                        fncSaveSubUnit(arr[2].trim());
                        uploadfrmUnitPhoto(arr[2].trim());
                    }else if(arr[0] == 2){
                        setTimeout(function(){
                            showmodal("alert", arr[1], "fncCloseUnitModal", null, "", null, "0");
                        }, 500)
                        fncSaveSubUnit(arr[2].trim());
                        uploadfrmUnitPhoto(arr[2].trim());
                    }else{
                        setTimeout(function(){
                            showmodal("alert", arr[1], "", null, "", null, "1");
                        }, 500)
                    }
                }
            })
        }else{
            setTimeout(function(){
                showmodal("alert", "Fill all required fields.", "", null, "", null, "1");
            }, 500)
            $('.req_unit').each(function() {
                if(this.value === ''){
                    this.focus();
                    return false;
                }
            });
        }
    }

    function uploadfrmUnitPhoto(unitid){
        $("#refunitid").val(unitid);
        var data = new FormData($('#frmUnitPhoto')[0]);
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/uploadunitpic.php',
            data: data,
            mimeType: 'multipart/form-data',
            contentType: false,
            cache: false,
            processData: false,
            success:function(data){
                // $("#modal_addnewunit").modal("hide");
            }
        });
    }

    function fncSaveSubUnit(UnitID){
        var SubUnitCount = 0;
        var SuccessCount = 0;
        var BillingType = "Individual";
        // $(".UnitBillingSetup").each(function(){
        //     if($(this).is(":checked")){
        //         BillingType = $(this).val();
        //     }
        // })
        $("#div_SubUnitList .div_SubUnit").each(function(){
            SubUnitCount++;
        });
        if(SubUnitCount == 0){
            $("#div_SubUnitList").html("");
        }else{
            $("#div_SubUnitList .div_SubUnit").each(function(){
                var UnitName = $(this).find(".lblUnitName").text();
                var UnitLength = $(this).find(".txtUnitLength").val();
                var UnitWidth = $(this).find(".txtUnitWidth").val();
                var UnitArea = $(this).find(".txtUnitArea").val().replace(/,/g, "");
                var UnitRate = $(this).find(".lblUnitRate").text().replace(/,/g, "");
                var AssocDues = $(this).find(".lblUnitAssocDues").text();
                var ImageForm = $(this).find(".frmSubUnitImage").attr("id");
                var frmSubUnitID = $(this).find(".txtSubUnitID").attr("id");
                $.ajax({
                    type: 'POST',
                    url: 'setup/mall_configuration/class.php',
                    data: 'UnitID=' + UnitID +  '&UnitName=' + UnitName + '&UnitLength=' + UnitLength + '&UnitWidth=' + UnitWidth + '&UnitArea=' + UnitArea + '&UnitRate=' + UnitRate + '&AssocDues=' + AssocDues + '&SubUnitCount=' + SubUnitCount + '&BillingType=' + BillingType + '&form=fncSaveSubUnit',
                    success: function(data){
                        $("#"+frmSubUnitID).val(UnitID+"-"+data);
                        SuccessCount++;
                    }, complete: function(){
                        fncUploadSUbUnitImage(ImageForm, SubUnitCount, SuccessCount);
                    }
                })    
            });
        }
    }

    function fncUploadSUbUnitImage(Form, SubUnitCount, SuccessCount){
        var data = new FormData($('#'+Form)[0]);
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/uploadsubunitpic.php',
            data: data,
            mimeType: 'multipart/form-data',
            contentType: false,
            cache: false,
            processData: false,
            success:function(data){
                 if(SubUnitCount == SuccessCount){
                    $("#div_SubUnitList").html("");
                }
            }
        })
    }

    function editrefunit(unit){
        $("#modal_addnewunit").modal("show");
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'id=' + unit + '&form=editrefunit',
            beforeSend: function(){
                $("#divtxtMCUnitWing .select2-selection").css('height','33px');
                $("#divtxtMCUnitFloor .select2-selection").css('height','33px');
                $("#divtxtMCUnitType .select2-selection").css('height','33px');
                $("#divtxtMCUnitClass .select2-selection").css('height','33px');
            },
            success: function(data){
                var arr = data.trim().split("|");
                $("#txtMCUnitType").val(arr[0]);
                $("#txtmall_id").val(arr[10]);
                $.ajax({
                    type: 'POST',
                    url: 'setup/mall_configuration/class.php',
                    data: 'id=' + arr[10] + '&form=loadmallls',
                    success: function(data){
                        $("#txtMCUnitWing").html(data);
                    }, complete: function(){
                        $("#txtMCUnitWing").val(arr[1]).trigger("change"); 
                        $.ajax({
                            type: 'POST',
                            url: 'setup/mall_configuration/class.php',
                            data: 'WingID=' + arr[1] + '&form=fncLoadUnitFloor',
                            success: function(FloorList){
                                $("#txtMCUnitFloor").html(FloorList);
                            }, complete: function(){
                                $(".searchy_select").select2();
                                $("#txtMCUnitFloor").val(arr[2]).trigger("change"); 
                            }
                        })
                    }
                })
                $("#txtMCUnitName").val(arr[3]);
                getallamenities(unit);
                $("#txtMCUnitWidth").val(arr[7]);
                $("#txtMCUnitLength").val(arr[8]);
                $("#txtMCUnitArea").val(arr[9]);
                $("#txtMCUnitRate").val(arr[11]);
                $("#txtMCAssocDues").val(arr[12]);
                $("#txtrefunit").val(unit);
                $("#imgMainUnitImage").attr("src", arr[14]);
                fncLoadSubUnitList(unit);
                $("#ulUnitImages").html(arr[16]);
                CKEDITOR.instances['txtOtherUnitInfo'].setData(arr[17]);
                $.ajax({
                    type: 'POST',
                    url: 'setup/mall_configuration/class.php',
                    data: 'form=fncloadUnitClassfication',
                    success: function(data){
                        $(".searchy_select").select2();
                        $("#txtMCUnitClass").html(data);
                    }, complete: function(){
                        $("#txtMCUnitClass").val(arr[4]).trigger("change");
                    }
                })
            }, complete: function(){
                $(".txtSubUnitInfo").val("");
                $(".remove").click();
                $('.Unit-Image').ace_file_input({
                    no_file:'No File ...',
                    btn_choose:'Choose',
                    btn_change:'Change',
                    droppable:false,
                    onchange:null,
                    thumbnail:false
                });
                var colorbox_params = {
                    rel: 'colorbox',
                    reposition: true,
                    scalePhotos: true,
                    scrolling: false,
                    title: false,
                    previous: '<i class="ace-icon fa fa-arrow-left"></i>',
                    next: '<i class="ace-icon fa fa-arrow-right"></i>',
                    close: '&times;',
                    current: '{current} of {total}',
                    maxWidth: '100%',
                    maxHeight: '100%',
                    onComplete: function(){
                        $.colorbox.resize();
                    }
                }
                $('[data-rel="colorbox"]').colorbox(colorbox_params);
                $('#cboxLoadingGraphic').append("<i class='ace-icon fa fa-spinner orange'></i>");
            }
        })
    }

    function fncDeleteSubUnit(SubUnitID, UnitID){
        setTimeout(function(){
            showmodal("confirm", "Are you sure you want to delete sub unit?", "fncDeleteSubUnit2", SubUnitID+"|"+UnitID+"|", "", null, "0");
        }, 500)
    }

    function fncDeleteSubUnit2(SubUnitID, UnitID){
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'SubUnitID=' + SubUnitID + '&UnitID' + UnitID + '&form=fncDeleteSubUnit2',
            success: function(data){
                if(data == 1){
                    setTimeout(function(){
                        showmodal("alert", "Sub unit successfully deleted.", "fncLoadSubUnitList", UnitID+"|", "", null, "0");
                    }, 500)
                }else{
                    setTimeout(function(){
                        showmodal("alert", "Failed to delete sub unit.", "", null, "", null, "1");
                    }, 500)
                }
            }
        })
    }

    function fncEditSubUnit(SubUnitID, UnitID){
        $("#modal_EditSubUnit").modal("show");
        $("#SubEditUnitID").val(SubUnitID);
        $("#txtEditMainUnitID").val(UnitID);
        $(".remove").click();
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'SubUnitID=' + SubUnitID + '&form=fncEditSubUnit',
            success: function(data){
                var arr = data.split("|");
                $("#imgEditSUbUnitImage").attr("src", arr[0]);
                $("#imgEditSUbUnitImage").attr("alt", arr[1]);
                $("#txtEditSubUnitName").val(arr[1]);
                $("#txtEditSubUnitLength").val(arr[2]);
                $("#txtEditSubUnitWidth").val(arr[3]);
                $("#txtEditSubUnitArea").val(arr[4]);
                $("#txtEditSubUnitRate").val(arr[5]);
                $("#txtEditSubUnitAssocDues").val(arr[6]);
            }, complete: function(){
                $('.Unit-Image').ace_file_input({
                    no_file:'No File ...',
                    btn_choose:'Choose',
                    btn_change:'Change',
                    droppable:false,
                    onchange:null,
                    thumbnail:false
                });
            }
        })
    }

    function fncEditSaveSubUnit(){
        var UnitID = $("#SubEditUnitID").val();
        var UnitName = $("#txtEditSubUnitName").val();
        var UnitLength = $("#txtEditSubUnitLength").val().replace(/,/g, "");
        var UnitWidth = $("#txtEditSubUnitWidth").val().replace(/,/g, "");
        var UnitArea = $("#txtEditSubUnitArea").val().replace(/,/g, "");
        var UnitRate = $("#txtEditSubUnitRate").val().replace(/,/g, "");
        var UnitAssocDues = $("#txtEditSubUnitAssocDues").val();
        var MainUnitID = $("#txtEditMainUnitID").val();
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'UnitID=' + UnitID + '&UnitName=' + UnitName + '&UnitLength=' + UnitLength + '&UnitWidth=' + UnitWidth + '&UnitArea=' + UnitArea + '&UnitRate=' + UnitRate + '&UnitAssocDues=' + UnitAssocDues + '&form=fncEditSaveSubUnit',
            success: function(data){
                if(data == 1){
                    setTimeout(function(){
                        showmodal("alert", "Sub unit information successfully updated.", "fncLoadSubUnitList", MainUnitID+"|", "", null, "0");
                    }, 500)
                    fncUploadSUbUnitImage('frmEditSubUnitImage', '0', '1');
                }else{
                    setTimeout(function(){
                        showmodal("alert", "Failed to update sub unit information.", "", null, "", null, "1");
                    }, 500)
                }
            }
        })
    }

    function fncLoadSubUnitList(UnitID){
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'UnitID=' + UnitID + '&form=fncLoadSubUnitList',
            success: function(data){
                $("#div_SubUnitList").html(data);
            }, complete: function(){
                $("#modal_EditSubUnit").modal("hide");
                loadunit();
            }
        })        
    }

    function loadmodal_unit(){
        $("#modal_addnewunit").modal("show");
        $("#ulUnitImages").html("");
        $("#div_amenitiesselected").html('<br/><label style="width: 100%;" onclick="addnewrefamenities()">Click to add facilities ..</label></div>');
        $("#imgMainUnitImage").attr("src", "assets/images/noimage5.png");
        $("#frmMainUnitImage").html("<input id='fileUnitImage' name='fileUnitImage' class='form-control Unit-Image' type='file' onchange='fncMainUnitImage();' accept='image/*'>");
        $(".remove").click();
        $("#refunitid").val("");
        $(".text_unit").val("");
        $("#div_SubUnitList").html("");
        $('.Unit-Image').ace_file_input({
            no_file:'No File ...',
            btn_choose:'Choose',
            btn_change:'Change',
            droppable:false,
            onchange:null,
            thumbnail:false
        });
        $('input:radio[value="Individual"]').attr('checked', 'checked');
        $("#clicktoshowall").prop("checked", false);
        $("#clicktoshowall").prop("disabled", false);
        $(".clicktoshowall").each(function(){
            var id = this.id;
            if($("#"+id+" i").hasClass("fa fa-chevron-up")){
                $("#"+id).click();
            }
        })
        CKEDITOR.instances['txtOtherUnitInfo'].setData('');
        fncLoadUnitWing();
        fncloadUnitClassfication();
    }

    function fncCloseUnitModal(){
        $("#modal_addnewunit").modal("hide");
        loadunit();
    }

    function fncLoadUnitWing(){
        var flrid = $("#txtMCUnitFloor").val();
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'id=' + flrid + '&form=fncLoadUnitWing',
            success: function(data){
                $(".searchy_select").select2();
                $("#divtxtMCUnitWing .select2-selection").css('height','33px');
                $("#divtxtMCUnitFloor .select2-selection").css('height','33px');
                $("#divtxtMCUnitType .select2-selection").css('height','33px');
                $("#divtxtMCUnitClass .select2-selection").css('height','33px');
                $("#txtMCUnitWing").html(data);
            }
        })  
    }

    function fncLoadUnitFloor(){
        var WingID = $("#txtMCUnitWing").val();
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'WingID=' + WingID + '&form=fncLoadUnitFloor',
            success: function(data){
                $(".searchy_select").select2();
                $("#divtxtMCUnitFloor .select2-selection").css('height','33px');
                $("#txtMCUnitFloor").html(data);
            }
        })
    }

    function fncloadUnitClassfication(){
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'form=fncloadUnitClassfication',
            success: function(data){
                $("#txtMCUnitClass").html(data);
            }
        })
    }

    function fncResetFields(){
        $("#div_amenitiesselected").html('<br/><label style="width: 100%;" onclick="addnewrefamenities()">Click to add facilities ..</label></div>');
        $("#imgMainUnitImage").attr("src", "assets/images/noimage5.png");
        $("#frmMainUnitImage").html("<input id='fileUnitImage' name='fileUnitImage' class='form-control Unit-Image' type='file' onchange='fncMainUnitImage();' accept='image/*'>");
        $(".remove").click();
        $("#refunitid").val("");
        $(".text_unit").val("");
        $("#div_SubUnitList").html("");
        loadunit();
    }

    function fncMainUnitImage(){
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("txtfileunit").files[0]);
        oFReader.onload = function (oFREvent) {
            document.getElementById("imgMainUnitImage").src = oFREvent.target.result;
        };
    }

    function clicktoshowall(){
        $("#clicktoshowall").each(function(){
            if($(this).is(":checked")){
                $(".clicktoshowall").each(function(){
                    var id = this.id;
                    if($("#"+id +" i").hasClass("fa fa-chevron-down")){
                        $("#"+id).click();
                    }
                })
            }else{
                $(".clicktoshowall").click();
            }
        })
    }

    function fncSaveAddUnit(){
        var Count = 0;
        $(".txtSubUnitInfo").each(function(){
            if($(this).val() == "" || $(this).val() == 0){
                Count++;
                $(this).css("border-color", "#f2a696");
            }else{
                $(this).css("border-color", "#D5D5D5");
            }
        });
        if(Count == 0){
            setTimeout(function(){
                showmodal("confirm", "Are you sure you want to add sub unit?", "fncSaveAddUnit2", null, "", null, "0");
            }, 500)
        }else{
            setTimeout(function(){
                showmodal("alert", "Please fill all fields.", "", null, "", null, "1");
            }, 500)
        }
    }

    function fncSaveAddUnit2(){
        var UnitName = $("#txtSubUnitName").val();
        var UnitArea = $("#txtSubUnitArea").val();
        var UnitLength = $("#txtSubUnitLength").val();
        var UnitWidth = $("#txtSubUnitWidth").val();
        var UnitRate = $("#txtSubUnitRate").val();
        var UnitAssocDues = $("#txtSubUnitAssocDues").val();
        var Area = "";
        <?php if(SysLeaseSetup('floorandunitmeasurement') == "Area"){ ?>
            Area = UnitArea + " SQM";
        <?php }else{ ?>
            Area = parseFloat(UnitLength) * parseFloat(UnitWidth) + " SQM";
        <?php } ?>
        var AssocDues = "";
        <?php if(SysLeaseSetup('isAssocDues') == "1"){ ?>
            AssocDues = '<p style="font-size: 14px; margin: 0px !important;">Association Dues : <label id="lblUnitAssocDues">'+ UnitAssocDues +'</label></p>';
        <?php } ?>
        var i = 0;
        $("div .div_SubUnit").each(function(){
            i++;
        });
        var imgID = "imgSubUnit"+i;
        var imgFile = "imgFile"+i;
        var SubUnitID = "txtSubUnit"+i;
        var frmUnitImage = "frmSubUnitImage"+i;
        $("#div_SubUnitList").append('<div class="col-md-4">' +
                                        '<div class="alert alert-info div_contact_person div_SubUnit">' +
                                            '<center>' +
                                                '<div class="image">' +
                                                    '<img id="'+ imgFile +'" class="img-thumbnail imageName form-control" src="assets/images/noimage5.png" style="border: 2px solid #bdc3c7; margin-bottom: 8px;height: 160px;width:90%;">' +
                                                '</div>' +
                                                '<form name="frmSubUnitImage" id="'+ frmUnitImage +'" class="frmSubUnitImage">' +
                                                    '<input id="'+ SubUnitID +'" name="txtSubUnitID" type="hidden" class="txtSubUnitID"> ' +
                                                    '<input id="'+ imgID +'" onchange="showSubUnitImage(\''+ imgFile +'\', \''+ imgID +'\')" name="fileSubUnitImage" class="form-control Unit-Image" type="file" accept="image/*"/>' +
                                                '</form>' +
                                            '</center>' +
                                            '<p style="font-size: 14px; font-weight: bold;margin: 0px !important;">Unit Name : <label class="lblUnitName" style="font-size: 14px; font-weight: bold;">'+ UnitName +'</label></p>' +
                                            '<p style="font-size: 14px; margin: 0px !important;">Area (SQM) : <label class="lblUnitArea">'+ Area +'</label><input type="hidden" class="txtUnitLength" value="'+ UnitLength +'"><input type="hidden" class="txtUnitWidth" value="'+ UnitWidth +'"><input type="hidden" class="txtUnitArea" value="'+ UnitArea +'"></p>' +
                                            '<p style="font-size: 14px; margin: 0px !important;">Rate : <label class="lblUnitRate">'+ UnitRate +'</label></p>' +
                                            AssocDues +
                                        '</div>' +
                                    '</div>');
        $('.Unit-Image').ace_file_input({
            no_file:'No File ...',
            btn_choose:'Choose',
            btn_change:'Change',
            droppable:false,
            onchange:null,
            thumbnail:false
        });
    }

    function showSubUnitImage(imgFile, imgID){
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById(imgID).files[0]);
        oFReader.onload = function (oFREvent) {
            document.getElementById(imgFile).src = oFREvent.target.result;
        };
    }

    function fncAddNewUnitClass(){
        $("#mdlNewUnitClassification").modal("show");
        $("#txtMCUnitClassCode").val("");
        $("#txtMCUnitClassDesc").val("");
    }

    function fncSaveUnitClassification(){
        var UnitClassCode = $("#txtMCUnitClassCode").val();
        var UnitClassDesc = $("#txtMCUnitClassDesc").val();
        if(UnitClassCode == "" && UnitClassDesc == ""){
            setTimeout(function(){
                showmodal("alert", "Please fill all fields.", "", null, "", null, "1");
            }, 500)
        }else{
            $.ajax({
                type: 'POST',
                url: 'setup/mall_configuration/class.php',
                data: 'UnitClassCode=' + UnitClassCode + '&UnitClassDesc=' + UnitClassDesc + '&form=fncSaveUnitClassification',
                success: function(data){
                    if(data == 1){
                        setTimeout(function(){
                            showmodal("alert", "Unit Classification successfully added.", "fncCloseNewUnitClass", null, "", null, "0");
                        }, 500)
                    }else{
                        setTimeout(function(){
                            showmodal("alert", "Failed to save unit classification.", "", null, "", null, "1");
                        }, 500)
                    }
                }
            })
        }
    }

    function fncCloseNewUnitClass(){
        $("#mdlNewUnitClassification").modal("hide");
        fncloadUnitClassfication();
    }
// UNIT FUNCTIONS END

// SETUP FUCNTIONS START
    $(function(){
        // $("#tbdywidget_billing :input").prop("disabled", true);
        // $("#tbdywidget_vatpen :input").prop("disabled", true);
        $("#tbdywidget_maintenance :input").prop("disabled", true);
        $("#tbdywidget_assdues :input").prop("disabled", true);
        $("#tbdywidget_leasingupb :input").prop("disabled", true);
        $("#tbdywidget_leasingdiscount :input").prop("disabled", true);
        $("#tbdywidget_leasingothercharges :input").prop("disabled", true);
    })

    function modal_billsetup(){
        $("#modal_billsetup").modal("show");
        var mallid = $("#txtmall_id").val();
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'mallid=' + mallid + '&form=load_billsetup',
            success: function(data){
                var arr = data.split("#");
                var preparedby = arr[0].split("|");
                var chkedby = arr[1].split("|");
                var approvedby = arr[2].split("|");
                var receivedby = arr[3].split("|");
                $("#txtpreparedby_lname").val(preparedby[0]);
                $("#txtpreparedby_fname").val(preparedby[1]);
                $("#txtpreparedby_mname").val(preparedby[2]);
                $("#txtchkedby_lname").val(chkedby[0]);
                $("#txtchkedby_fname").val(chkedby[1]);
                $("#txtchkedby_mname").val(chkedby[2]);
                $("#txtapprovedby_lname").val(approvedby[0]);
                $("#txtapprovedby_fname").val(approvedby[1]);
                $("#txtapprovedby_mname").val(approvedby[2]);
                $("#txtreceivedby_lname").val(receivedby[0]);
                $("#txtreceivedby_fname").val(receivedby[1]);
                $("#txtreceivedby_mname").val(receivedby[2]);
                if(arr[5] == "no"){
                    $("#vatsetupno").click();
                }else{
                    $("#vatsetupyes").click();
                }
                $("#slct_rentvattype").val(arr[6]);
                $("#txtrentvatperc").val(arr[7]);
                if(arr[8] == "no"){
                    $("#triggeredno").click();
                }else{
                    $("#triggeredyes").click();
                }
                $("#slct_penaltypevattype").val(arr[9]);
                $("#txtpenaltyvatperc").val(arr[10]);
                if(arr[11] == "amount"){
                    // $("#txtpenalty_amt").attr("readonly", "readonly");
                    // $("#txtpenalty_perc").removeAttr("readonly");
                    $("#penaltytypeamount").prop("checked", true);
                }else{
                    // $("#txtpenalty_amt").removeAttr("readonly");
                    // $("#txtpenalty_perc").attr("readonly", "readonly");
                    $("#penaltytypepercent").prop("checked", true);
                }
                $("#txtpenalty_amt").val(arr[12]);
                $("#txtpenalty_perc").val(arr[13]);
                //$("#txtdeposit_perc").val(arr[14]);
            }
        })
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'MallID=' + mallid + '&form=fncBillYear',
            success: function(data){
                $("#txtBillSetupYear").html(data);
            }, complete: function(){
                fncLoadBillSetup();
            }
        })
        fncLoadAddCharges();
        fncLoadOthCharges();
    }

    function fncLoadAddCharges(){
        var MallID = $("#txtmall_id").val();
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'MallID=' + MallID + '&form=fncLoadAddCharges',
            success: function(data){
                if(data.trim() == ""){
                    $("#tbodyAdditionalCharges").html("<tr><td colspan='4' style='text-align: center;'>No Data Found...</td></tr>");
                }else{
                    $("#tbodyAdditionalCharges").html(data);
                }
            }
        })
    }

    function fncLoadOthCharges(){
        var MallID = $("#txtmall_id").val();
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'MallID=' + MallID + '&form=fncLoadOthCharges',
            success: function(data){
                if(data.trim() == ""){
                    $("#tbodyOtherCharges").html("<tr><td colspan='4' style='text-align: center;'>No Data Found...</td></tr>");
                }else{
                    $("#tbodyOtherCharges").html(data);
                }
            }
        })
    }

    function fncRentPenaltyType(PType){
        if(PType == "percent"){
            $("#txtpenalty_amt").val("0.00");
        }else{
            $("#txtpenalty_perc").val("0.00");
        }
    }

    function fncVATSetup(PType){
        if(PType == "yes"){
            $("#txtrentvatperc").val("0");
        }else{
            $("#txtrentvatperc").val("0");
        }
    }

    function fncOpenChargesList(table){
        $('#modal_AddCharges').modal('show');
        $("#txtSearchAddCharges").val("");
        $("#txtSearchAddCharges").keyup(function(e){
            var x = event.keyCode;
            if(x == 13){ 
                fncLoadChargesList(table); 
            }else if(x == '8'){
                if($('#txtSearchAddCharges').val() == ""){
                    fncLoadChargesList(table);
                }
            }
        });
        fncLoadChargesList(table);
    }

    function fncLoadChargesList(table){
        var ids = "";
        $("#"+table+" tr").each(function(){
            ids += $(this).attr("id").split("-")[1] +"|";
        })
        var key = $("#txtSearchAddCharges").val();
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'table=' + table + '&key=' + key + '&ids=' + ids + '&form=fncLoadChargesList',
            success: function(data){
                if(data.trim() == ""){
                    $("#tblMCAddCharges").html("<tr><td colspan='4' style='text-align: center;'>No Data Found...</td></tr>");
                }else{
                    $("#tblMCAddCharges").html(data);
                    $("#tblMCAddCharges tr").each(function(){
                        $(this).click(function(){
                            var id = $(this).find(".ChargesID").text();
                            var ChargesDesc = $(this).find(".ChargesDesc").text();
                            var ChargesRate = $(this).find(".ChargesRate").text();
                            if(table == 'tbodyOtherCharges'){
                                $("#modal_MonthQuantity").modal("show");
                                $("#txtFPChargeCount").val("0");
                                $("#txtOthChargesID").val(id);
                                $("#txtOthChargesDesc").val(ChargesDesc);
                                $("#txtOthChargesRate").val(ChargesRate);
                            }else{
                                $("#"+ table).append("<tr id=\"AddChar-"+ id +"\">" +
                                                                "<td>"+ id +"</td>" +
                                                                "<td>"+ ChargesDesc +"</td>" +
                                                                "<td>"+ ChargesRate +"</td>" +
                                                                "<td style='text-align: center;z-index: 0;'><button class='btn btn-xs btn-danger btn-round' onclick='$(\"#AddChar-"+id+"\").remove();'><i class='fa fa-trash-o'></i></button></td>" +
                                                            "</tr>");
                                $("#"+$(this).attr("id")).remove();
                            }
                        })
                    })
                }
            }
        })
    }

    function fncbtnAddMnthCount(btn){
        var calcVal = $("#txtFPChargeCount").val();
        if(btn != "C"){
            if(calcVal == "" || calcVal == "0"){
                $("#txtFPChargeCount").val(btn);
            }else{
                $("#txtFPChargeCount").val(calcVal+btn);
            }
        }else{
            $("#txtFPChargeCount").val(calcVal.slice(0, -1));
        }
    }

    function fncAddOtherChargesrow(){
        var ChargeID = $("#txtOthChargesID").val();
        var ChargesDesc = $("#txtOthChargesDesc").val();
        var ChargesRate = $("#txtOthChargesRate").val();
        var MonthCount = $("#txtFPChargeCount").val();
        $("#tbodyOtherCharges").append(  "<tr id=\"OthChar-"+ ChargeID +"\">" +
                                            "<td>"+ ChargeID +"</td>" +
                                            "<td>"+ ChargesDesc +"</td>" +
                                            "<td>"+ ChargesRate +"</td>" +
                                            "<td>"+ MonthCount +" Month(s)</td>" +
                                            "<td style='text-align: center;z-index: 0;'><button class='btn btn-xs btn-danger btn-round' onclick='$(\"#OthChar-"+ChargeID+"\").remove();'><i class='fa fa-trash-o'></i></button></td>" +
                                        "</tr>");
        $("#TR"+ChargeID).remove();
        $("#modal_MonthQuantity").modal("hide");
    }

    function fncSaveAdditionalCharges(){
        var MallID = $("#txtmall_id").val();
        var AddCharges = "";
        $("#tbodyAdditionalCharges tr").each(function(){
            AddCharges += $(this).attr("id").split("-")[1] + "|";
        })
        if(AddCharges == ""){
            setTimeout(function(){
                showmodal("alert", "No data to save.", "", null, "", null, "1");
            }, 500)
        }else{
            $.ajax({
                type: 'POST',
                url: 'setup/mall_configuration/class.php',
                data: 'AddCharges=' + AddCharges + '&MallID=' + MallID + '&form=fncSaveAdditionalCharges',
                success: function(data){
                    if(data >= 1){
                        setTimeout(function(){
                            showmodal("alert", "Additional charges successfully saved.", "", null, "", null, "0");
                        }, 500)
                    }else{
                        setTimeout(function(){
                            showmodal("alert", "Failed to save additional charges.", "", null, "", null, "1");
                        }, 500)
                    }
                }
            })
        }
    }
    
    function fncSaveOtherCharges(){
        var MallID = $("#txtmall_id").val();
        var OthCharges = "";
        $("#tbodyOtherCharges tr").each(function(){
            OthCharges += $(this).attr("id").split("-")[1] + "@" + $(this).find("td").eq(3).text().split(" ")[0] + "|";
        })
        if(OthCharges == ""){
            setTimeout(function(){
                showmodal("alert", "No data to save.", "", null, "", null, "1");
            }, 500)
        }else{
            $.ajax({
                type: 'POST',
                url: 'setup/mall_configuration/class.php',
                data: 'OthCharges=' + OthCharges + '&MallID=' + MallID + '&form=fncSaveOtherCharges',
                success: function(data){
                    if(data >= 1){
                        setTimeout(function(){
                            showmodal("alert", "Other charges successfully saved.", "", null, "", null, "0");
                        }, 500)
                    }else{
                        setTimeout(function(){
                            showmodal("alert", "Failed to save other charges.", "", null, "", null, "1");
                        }, 500)
                    }
                }
            })
        }
    }

    function fncAddNewCOPeriod(){
        $("#mdl_BillingCycle").modal("show");
        $("#tbodyGenCutOff").html("");
    }

    function fncCloseNewCOPeriod(){
        $("#mdl_BillingCycle").modal("hide");
        var MallID = $("#txtmall_id").val();
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'MallID=' + MallID + '&form=fncBillYear',
            success: function(data){
                $("#txtBillSetupYear").html(data);
            }
        })
    }

    function fncGenerateCOPeriod(){
        var CutOffYear = $("#txtBCCutoffYear").val();
        var CutOffDate = $("#txtBCCutoffDate").val();
        var DueDate = $("#txtBCCutoffDueDate").val();
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'CutOffYear=' + CutOffYear + '&CutOffDate=' + CutOffDate + '&DueDate=' + DueDate + '&form=fncGenerateCOPeriod',
            success: function(data){
                $("#tbodyGenCutOff").html(data);
            }, complete: function(){
                $(".date-picker").datepicker({
                    autoHide: true,
                    format: 'mm/dd/yyyy',
                    todayHighlight: true
                })
            }
        })
    }

    function fncSaveCutOffPeriod(){
        var MallID = $("#txtmall_id").val();
        var arrPeriod = "";
        $("#tbodyGenCutOff tr").each(function(){
            arrPeriod += $(this).find("td").eq(0).text() + "|" + $(this).find("td").eq(1).text() + "|" + $(this).find("td").eq(2).text() + "|" + $(this).find(".txtCOPDueDate").val() + "@";
        })
        var CutOffYear = $("#txtBCCutoffYear").val();
        var CutOffDate = $("#txtBCCutoffDate").val();
        var DueDate = $("#txtBCCutoffDueDate").val();
        var COUNT = 0;
        $(".txtCUDateRequired").each(function(){
            if($(this).val() == ''){
                COUNT++;
                $(this).css("border-color","#f2a696");
            }else{
                $(this).css("border-color","#D5D5D5");
            }
        })
        if(COUNT == 0){
            if(arrPeriod != ""){
                $.ajax({
                    type: 'POST',
                    url: 'setup/mall_configuration/class.php',
                    data: 'CutOffYear=' + CutOffYear + '&CutOffDate=' + CutOffDate + '&DueDate=' + DueDate + '&MallID=' + MallID + '&arrPeriod=' + arrPeriod + '&form=fncSaveCutOffPeriod',
                    success: function(data){
                        if(data == 1){
                            setTimeout(function(){
                                showmodal("alert", "Cut-off period successfully saved.", "fncCloseNewCOPeriod", null, "", null, "0");
                            }, 500)
                        }else{
                            setTimeout(function(){
                                showmodal("alert", "Cut-off period for this year already exist.", "", null, "", null, "1");
                            }, 500)
                        }
                    }
                })
            }else{
                setTimeout(function(){
                    showmodal("alert", "Please generate a billing period first.", "", null, "", null, "1");
                }, 500)
            }
        }else{
            setTimeout(function(){
                showmodal("alert", "Please fill all dute date fields.", "", null, "", null, "1");
            }, 500)
        }
    }

    function fncLoadBillSetup(){
        var MallID = $("#txtmall_id").val();
        var BillYear = $("#txtBillSetupYear").val();
        $.ajax({
            type: 'POSt',
            url: 'setup/mall_configuration/class.php',
            data: 'BillYear=' + BillYear + '&MallID=' + MallID + '&form=fncLoadBillSetup',
            success: function(data){
                if(data.trim() != ""){
                    $("#tbodyBillPeriod").html(data);
                }else{
                    $("#tbodyBillPeriod").html("<tr><td colspan='4' style='text-align: center;'>No Data Found...</td></tr>");
                }
            }
        })
    }

    function closesetupbill(){
        $("#modal_billsetup").modal("hide");
    }

    function enable_edit1(){
        $("#tbdywidget_billing :input").prop("disabled", false);
    }

    function savesoasign(){
        var preparedby_lname = $("#txtpreparedby_lname").val();
        var preparedby_fname = $("#txtpreparedby_fname").val();
        var preparedby_mname = $("#txtpreparedby_mname").val();
        var chkedby_lname = $("#txtchkedby_lname").val();
        var chkedby_fname = $("#txtchkedby_fname").val();
        var chkedby_mname = $("#txtchkedby_mname").val();
        var approvedby_lname = $("#txtapprovedby_lname").val();
        var approvedby_fname = $("#txtapprovedby_fname").val();
        var approvedby_mname = $("#txtapprovedby_mname").val();
        var receivedby_lname = $("#txtreceivedby_lname").val();
        var receivedby_fname = $("#txtreceivedby_fname").val();
        var receivedby_mname = $("#txtreceivedby_mname").val();
        var mallid = $("#txtmall_id").val();
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'prep=' + preparedby_lname + '|' + preparedby_fname + '|' + preparedby_mname +  '&chkd=' + chkedby_lname + '|' + chkedby_fname + '|' + chkedby_mname + '&appr=' + approvedby_lname + '|' + approvedby_fname + '|' + approvedby_mname + '&rcvd=' + receivedby_lname + '|' + receivedby_fname + '|' + receivedby_mname + '&mallid=' + mallid + '&form=savesoasign',
            success: function(data){
                    setTimeout(function(){
                        showmodal("alert", "You have successfully saved changes on the setup.", "", null, "", null, "0");
                    }, 500)
            }
        })
    }

    function save_vat_penalty_setup(){
        var rent_vatable = "";
        $(".MCisRentVATable").each(function(){
            if($(this).is(":checked")){
                rent_vatable = $(this).val();
            }            
        })
        var penalty_type = "";
        $(".MCisRentPenaltyVATable").each(function(){
            if($(this).is(":checked")){
                penalty_type = $(this).val();
            }            
        })
        var rent_vattype = $("#slct_rentvattype").val();
        var rent_vatperc = $("#txtrentvatperc").val();
        var penalty_vatable = $("input[name='penalty_vatable']").val();
        var penalty_vattype = $("#slct_penaltypevattype").val();
        var penalty_vatperc = $("#txtpenaltyvatperc").val();
        var penalty_amt = $("#txtpenalty_amt").val();
        var penalty_perc = $("#txtpenalty_perc").val();
        var mallid = $("#txtmall_id").val();
        var deposit_perc = 0; //$("#txtdeposit_perc").val();
        var trap1 = 0;
        var trap2 = 0;
        var trap3 = 0;
        if($("#vatsetupyes").is(":checked")){
            trap1 = 1;
        }
        if($("#triggeredyes").is(":checked")){
            trap2 = 1;
        }
        if($("#penaltytypepercent").is(":checked")){
            trap3 = 1;
        }
        if(trap1 == "1" && rent_vatperc == "0"){
            setTimeout(function(){
                showmodal("alert", "Penalty percentage must be greater than zero.", "", null, "", null, "0");
            }, 500)
        }else{
            if(trap2 == "1" && penalty_vatperc == "0"){
                setTimeout(function(){
                    showmodal("alert", "Penalty percentage must be greater than zero.", "", null, "", null, "0");
                }, 500)
            }else{
                if(trap3 == "1" && penalty_perc == "0"){
                    setTimeout(function(){
                        showmodal("alert", "Penalty percentage must be greater than zero.", "", null, "", null, "0");
                    }, 500)
                }else{
                    // if(deposit_perc != "0"){
                        $.ajax({
                            type: 'POST',
                            url: 'setup/mall_configuration/class.php',
                            data: 'rent_vatable=' + rent_vatable + '&rent_vattype=' + rent_vattype + '&rent_vatperc=' + rent_vatperc + '&penalty_vatable=' + penalty_vatable + '&penalty_vattype=' + penalty_vattype + '&penalty_vatperc=' + penalty_vatperc + '&penalty_type=' + penalty_type + '&penalty_amt=' + penalty_amt + '&penalty_perc=' + penalty_perc + '&mallid=' + mallid + '&deposit_perc=' + deposit_perc + '&form=save_vat_penalty_setup',
                            success: function(data){
                                setTimeout(function(){
                                    showmodal("alert", "You have successfully saved changes on the setup.", "", null, "", null, "0");
                                }, 500)
                            }
                        })
                    // }else{
                    //     showmodal("alert", "Deposit percentage must be greater than zero.", "", null, "", null, "0");
                    // }
                }
            } 
        }
    }

     function modal_maintenancesetup(){
        $("#modal_maintenancesetup").modal("show");
        loadtbodyRateHistory('Water');
    }

    function closemodal_maintenancesetup(){
        $("#modal_maintenancesetup").modal("hide");       
    }

    function AddNewRate(type){
        if(type == "Water"){
            $("#txtSpecificRateHeader").text("New Water Rate");
            $("#btnSaveNewRate").attr("onclick", "SaveNewRate(\""+type+"\")");
        }else if(type == "Electric"){
            $("#txtSpecificRateHeader").text("New Electric Rate");
            $("#btnSaveNewRate").attr("onclick", "SaveNewRate(\""+type+"\")");
        }else if(type == "Gas"){
            $("#txtSpecificRateHeader").text("New Gas Rate");
            $("#btnSaveNewRate").attr("onclick", "SaveNewRate(\""+type+"\")");
        }
        $("#modal_NewRate").modal("show");
        $("#txtRateID").val("");
        $("#txtNewRateEffDate").val("<?php echo date('m/d/Y'); ?>");
        $("#txtNewRateCost").val("0.00");
        $("#txtNewAdminFee").val("0");
        $("#txtAdminFee1").click();
    }

    function closemdlNewRate(){
        $("#modal_NewRate").modal("hide");
    }

    function SaveNewRate(UtilType){
        var RateID = $("#txtRateID").val();
        var EffDate = $("#txtNewRateEffDate").val();
        var Rate = $("#txtNewRateCost").val().replace(/,/g, "");
        var AdminFee = $("#txtNewAdminFee").val().replace(/,/g, "");
        var mallid = $("#txtmall_id").val();
        var AdminFeeType = "";
        $(".rdAdminFeeType").each(function(){
            if($(this).is(":checked")){
                AdminFeeType = $(this).val();
            }
        })
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'UtilType=' + UtilType + '&EffDate=' + EffDate + '&Rate=' + Rate + '&mallid=' + mallid + '&AdminFee=' + AdminFee + '&RateID=' + RateID + '&AdminFeeType=' + AdminFeeType + '&form=SaveNewRate',
            success:function(data){
                if(data.trim() == "1"){
                    setTimeout(function(){
                        showmodal("alert", "New rate successfully saved.", "loadtbodyRateHistory", UtilType+"|", "", null, "0");
                    }, 500)
                }else{
                    setTimeout(function(){
                        showmodal("alert", "Failed to save new rate.", "", null, "", null, "0");
                    }, 500)
                }
            }
        })
    }

    function loadtbodyRateHistory(UtilType){
        $("#modal_NewRate").modal("hide");
        var mallid = $("#txtmall_id").val();
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'UtilType=' + UtilType + '&mallid=' + mallid + '&form=loadtbodyRateHistory',
            success:function(data){
                if(UtilType == "Water"){
                    $("#tbodyWaterHistory").html(data);
                }else if(UtilType == "Electric"){
                    $("#tbodyElectricHistory").html(data);
                }else if(UtilType == "Gas"){
                    $("#tbodyGasHistory").html(data);
                }
            }
        })
    }

    function fncEditRate(UtilType, id){
        if(UtilType == "Water"){
            $("#txtSpecificRateHeader").text("Edit Water Rate");
            $("#btnSaveNewRate").attr("onclick", "SaveNewRate(\""+UtilType+"\")");
        }else if(UtilType == "Electric"){
            $("#txtSpecificRateHeader").text("Edit Electric Rate");
            $("#btnSaveNewRate").attr("onclick", "SaveNewRate(\""+UtilType+"\")");
        }else if(UtilType == "Gas"){
            $("#txtSpecificRateHeader").text("Edit Gas Rate");
            $("#btnSaveNewRate").attr("onclick", "SaveNewRate(\""+UtilType+"\")");
        }
        $("#modal_NewRate").modal("show");
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'id=' + id + '&form=fncEditRate',
            success: function(data){
                var arr = data.split("|");
                $("#txtNewRateEffDate").val(arr[0].trim());
                $("#txtNewRateCost").val(arr[1].trim());
                $("#txtNewAdminFee").val(arr[2].trim());
                $("#txtRateID").val(id);
                if(arr[3].trim() == "1"){
                    $("#txtAdminFee2").click();
                    $(".AdminFeeTypeHide1").removeClass("input-icon-right");
                    $(".AdminFeeTypeHide2").removeClass("fa-percent");
                }else{
                    $("#txtAdminFee1").click();
                    $(".AdminFeeTypeHide1").addClass("input-icon-right");
                    $(".AdminFeeTypeHide2").addClass("fa-percent");
                }
            }
        })
    }

    function fncMinimumSetup(UtilityType){
        if(UtilityType == "Water"){
            $("#hdrMinimumSetup").text("Min. Water Consumption Charge");
            $("#btnSaveMinimumSetup").attr("onclick", "fncSaveMinimumSetup(\""+UtilityType+"\")");
        }else if(UtilityType == "Electric"){
            $("#hdrMinimumSetup").text("Min. Electric Consumption Charge");
            $("#btnSaveMinimumSetup").attr("onclick", "fncSaveMinimumSetup(\""+UtilityType+"\")");
        }else if(UtilityType == "Gas"){
            $("#hdrMinimumSetup").text("Min. Gas Consumption Charge");
            $("#btnSaveMinimumSetup").attr("onclick", "fncSaveMinimumSetup(\""+UtilityType+"\")");
        }
        $("#modal_NewMinimumSetup").modal("show");
        var MallID = $("#txtmall_id").val();
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'MallID=' + MallID + '&UtilityType=' + UtilityType + '&form=fncMinimumSetup',
            success: function(data){
                $("#txtMinimumSetup").val(data.trim());
            }
        })
    }

    function fncSaveMinimumSetup(UtilityType){
        var Setup = $("#txtMinimumSetup").val().replace(/,/g,"");
        var MallID = $("#txtmall_id").val();
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'Setup=' + Setup + '&UtilityType=' + UtilityType + '&MallID=' + MallID + '&form=fncSaveMinimumSetup',
            success: function(data){
                if(data == 1){
                    setTimeout(function(){
                        showmodal("alert", "Minimum consumption setup successfully saved.", "fncCloseMdlMinimumSetup", null, "", null, "0");
                    }, 500)
                }else{
                    setTimeout(function(){
                        showmodal("alert", "Failed to save mininum consumption setup.", "", null, "", null, "1");
                    }, 500)
                }
            }
        })
    }

    function fncCloseMdlMinimumSetup(){
        $("#modal_NewMinimumSetup").modal("hide");
    }

    function modal_leasingsetup(){
        $("#modal_leasingsetup").modal("show");
        var mallid = $("#txtmall_id").val();
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'mallid=' + mallid + '&form=loadUPBsetup',
            success:function(data){
                var arr = data.split("|");
                $("#txtupbspot").val(arr[0]);
                $("#txtupbdown").val(arr[1]);
                $("#txtupbbal").val(arr[2]);
                $("#txtldpd").val(arr[3]);
                $("#txtldcd").val(arr[4]);
                $("#txtldsd").val(arr[5]);
                $("#txtocrf").val(arr[6]);
                $("#txtocdt").val(arr[7]);
                $("#txtoctt").val(arr[8]);
                $("#txtoclf").val(arr[9]);
                $("#txtocwec").val(arr[10]);
                $("#txtocmf").val(arr[11]);
                $(".chkreservationtype").each(function(){
                    if($(this).val() == arr[12]){
                        $(this).prop("checked", true);
                    }
                })
                $(".chkretentiontype").each(function(){
                    if($(this).val() == arr[13]){
                        $(this).prop("checked", true);
                    }
                })
                $("#txtupbreservationfee").val(arr[14]);
                $("#txtupbretentionfee").val(arr[15]);
            }
        })
    }

    function closemodal_leasingsetup(){
        $("#modal_leasingsetup").modal("hide");
    }

    function saveUPB(){
        var spot = $("#txtupbspot").val();
        var down = $("#txtupbdown").val();
        var balance = $("#txtupbbal").val();
        var mallid = $("#txtmall_id").val();    
        var promo = $("#txtldpd").val();
        var company = $("#txtldcd").val();
        var standard = $("#txtldsd").val();
        var reservationfee = $("#txtupbreservationfee").val();
        var retentionfee = $("#txtupbretentionfee").val();
        var reservationtype = "";
        var retentiontype = "";
        $(".chkreservationtype").each(function(){
            if( $(this).is(":checked") == true ) {
                reservationtype = this.value;
            }
        })
        $(".chkretentiontype").each(function(){
            if( $(this).is(":checked") == true ) {
                retentiontype = this.value;
            }
        })
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'mallid=' + mallid + '&spot=' + spot + '&down=' + down + '&balance=' + balance + '&promo=' + promo + '&company=' + company + '&standard=' + standard + '&reservationtype=' + reservationtype + '&retentiontype=' + retentiontype + '&reservationfee=' + reservationfee + '&retentionfee=' + retentionfee + '&form=saveUPB',
            success:function(data){
                var arr = data.split("|");
                if(arr[0] == "1"){
                    setTimeout(function(){
                        showmodal("alert", arr[1], "success5", null, "", null, "0");
                    }, 500)
                }else{
                    setTimeout(function(){
                        showmodal("alert", arr[1], "", null, "", null, "1");
                    }, 500)
                }
            }
        })
    }
      
    function saveothercharges(){
        var reg_fee = $("#txtocrf").val();
        var doc_tax = $("#txtocdt").val();
        var trans_tax = $("#txtoctt").val();
        var legal_fee = $("#txtoclf").val();
        var WE_connection = $("#txtocwec").val();
        var misc_fee = $("#txtocmf").val();
        var mallid = $("#txtmall_id").val();    
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'mallid=' + mallid + '&reg_fee=' + reg_fee + '&doc_tax=' + doc_tax + '&trans_tax=' + trans_tax + '&legal_fee=' + legal_fee + '&WE_connection=' + WE_connection + '&misc_fee=' + misc_fee + '&form=saveothercharges',
            success:function(data){
                var arr = data.split("|");
                if(arr[0] == "1"){
                    setTimeout(function(){
                        showmodal("alert", arr[1], "success7", null, "", null, "0");
                    }, 500)
                }else{
                    setTimeout(function(){
                        showmodal("alert", arr[1], "", null, "", null, "1");
                    }, 500)
                }
            }
        })
    }

    function fnc_LeaseSignatories(){
        $("#modal_LeaseSignatories").modal("show");
        $("#LeasingSignatoriesCount").val("1");
        var mallid = $("#txtmall_id").val();
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'mallid=' + mallid + '&form=fnc_loadLeaseSignatories',
            success: function(data){
                var arr = data.split("|");
                $("#LeasingSignatoriesCount").val(arr[1]);
                if(arr[1] > 1){
                    $("#div_LeaseSignatories").html(arr[0]);
                }else{
                    $("#div_LeaseSignatories").html('<div class="row form-group" id="divLease1"> ' +
                                                        '<div class="col-xs-1 center">' +
                                                            '<label>' +
                                                                '<input name="form-field-checkbox" type="checkbox" class="ace chkLeaseInfo DisMePlease2" value="divLease1">' +
                                                                '<span class="lbl"></span>' +
                                                            '</label>' +
                                                        '</div>' +
                                                        '<label class="col-md-1">User</label> ' +
                                                        '<div class="col-md-3"> ' +
                                                            '<select class="form-control LesSigUser DisMePlease2" id="txtLeaseSigUser1" onchange="showGroupofUser(this.value, \'txtLeaseSigPosition1\')"></select> ' +
                                                        '</div> ' +
                                                        '<label class="col-md-1">Position</label> ' +
                                                        '<div class="col-md-2"> ' +
                                                            '<input type="text" class="form-control DisMePlease2" id="txtLeaseSigPosition1" readonly> ' +
                                                        '</div> ' +
                                                        '<label class="col-md-1">Signatory</label> ' +
                                                        '<div class="col-md-2"> ' +
                                                            '<input type="text" class="form-control DisMePlease2" id="txtLeaseSignatory1"> ' +
                                                        '</div> ' +
                                                    '</div>');
                    slctUserSignatories();
                }
                $("#btnLeasingSignatories").prop("disabled", true);
                $("#pangeditLS").addClass("glyphicon-edit");
                $("#pangeditLS").removeClass("glyphicon-remove");
                $("#pangeditLS").css("color", "white");
            },complete:function(){
                $(".DisMePlease2").prop("disabled", true);
            }
        })
    }

    function showGroupofUser(val, id){
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'explodethis=' + val + '&form=showGroupofUser',
            success:function(data){
                $("#"+id).val(data);
            }
        })
    }

    function slctUserSignatories(){
        var count = $("#LeasingSignatoriesCount").val();
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'form=slctUserSignatories',
            success:function(data){
                $("#txtLeaseSigUser"+count).html(data);
            }
        })
    }

    function EnableLeaseSignatoriesEdit(){
        $("#pangeditLS").attr("onclick", "DisableLeaseSignatoriesEdit();");
        $(".DisMePlease2").prop("disabled", false);
        $("#pangeditLS").removeClass("glyphicon-edit");
        $("#pangeditLS").addClass("glyphicon-remove");
        $("#pangeditLS").css("color", "red");
    }

    function DisableLeaseSignatoriesEdit(){
        $("#pangeditLS").attr("onclick", "EnableLeaseSignatoriesEdit();");
        $(".DisMePlease2").prop("disabled", true);
        $("#pangeditLS").addClass("glyphicon-edit");
        $("#pangeditLS").removeClass("glyphicon-remove");
        $("#pangeditLS").css("color", "white");
    }

    function AppendSignatories(){
        var count = $("#LeasingSignatoriesCount").val();
        count = Number(count) + 1;
        $("#LeasingSignatoriesCount").val(count);
        $("#div_LeaseSignatories").append('<div class="row form-group" id="divLease'+count+'"> ' +
                                                '<div class="col-xs-1 center">' +
                                                    '<label>' +
                                                        '<input name="form-field-checkbox" type="checkbox" class="ace DisMePlease2 chkLeaseInfo" value="RemoveSignatories'+count+'">' +
                                                        '<span class="lbl"></span>' +
                                                    '</label>' +
                                                '</div>' +
                                                '<label class="col-md-1">User</label> ' +
                                                '<div class="col-md-3"> ' +
                                                    '<select class="form-control LesSigUser DisMePlease2" id="txtLeaseSigUser'+count+'" onchange="showGroupofUser(this.value, \'txtLeaseSigPosition'+count+'\')"></select> ' +
                                                '</div> ' +
                                                '<label class="col-md-1">Position</label> ' +
                                                '<div class="col-md-2"> ' +
                                                    '<input type="text" class="form-control DisMePlease2" id="txtLeaseSigPosition'+count+'" readonly> ' +
                                                '</div> ' +
                                                '<label class="col-md-1">Signatory</label> ' +
                                                '<div class="col-md-2"> ' +
                                                    '<input type="text" class="form-control DisMePlease2" id="txtLeaseSignatory'+count+'"> ' +
                                                '</div> ' +
                                            '</div>');
        slctUserSignatories();
    }

    function RemoveSignatories(){
        $(".chkLeaseInfo").each(function(){
            if($(this).is(":checked")){
                $("#"+$(this).val()).remove();
            }
        })
    }

    function fnc_XLeaseSignatories(){
        $("#modal_LeaseSignatories").modal("hide");
        $("#LeasingSignatoriesCount").val("1");
    }

    function SaveLeasingSignatories(){
        var mallid = $("#txtmall_id").val();
        var count = $("#LeasingSignatoriesCount").val();
        var SigInfo = "";
        for (var i = 1; i <= count; i++) {
            SigInfo += $("#txtLeaseSigUser"+i).val() + "|" + $("#txtLeaseSignatory"+i).val() + "#";
        }
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'mallid=' + mallid + '&SigInfo=' + SigInfo + '&form=SaveLeasingSignatories',
            success:function(data){
                setTimeout(function(){
                    showmodal("alert", "You have successfully saved changes on the setup.", "fnc_XLeaseSignatories", null, "", null, "0");
                }, 500)
            }
        })
    }

    function RemoveLeaseInfo(){
        $(".chkBankInfo").each(function(){
            if($(this).is(":checked")){
                $("#"+$(this).val()).remove();
            }
        })
    }

    function showmodal_BankInfo(){
        DisableDisMePlease();
        var mallid = $("#txtmall_id").val();
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'mallid=' + mallid + '&form=showmodal_BankInfo',
            success:function(data){
                var arr = data.split("|");
                $("#BankInfoRowCount").val(arr[1]);
                if(arr[1] > 1){
                    $("#BankListInfo").html(arr[0]);
                }else{
                    // Edit Ronald 2018-10-11
                    $("#BankListInfo").html('<div class="form-group row divBankList" id="divBankInfo1">' +
                                                '<div class="col-md-1 center">' +
                                                    '<label>' +
                                                        '<input name="form-field-checkbox" type="checkbox" class="ace DisMePlease chkBankInfo" value="divBankInfo1">' +
                                                        '<span class="lbl"></span>' +
                                                    '</label>' +
                                                '</div>' +
                                                '<div class="col-md-3">' +
                                                    'Bank' +
                                                '</div>' +
                                                '<div class="col-md-3">' +
                                                    'Account Name' +
                                                '</div>' +
                                                '<div class="col-md-3">' +
                                                    'Account Number' +
                                                '</div>' +
                                                '<div class="col-xs-2">' +
                                                    'Show in tenant' +
                                                '</div>' +
                                                '<div class="col-md-3">' +
                                                    '<select class="form-control DisMePlease BankList1 thisbank"></select>' +
                                                '</div>' +
                                                '<div class="col-md-3">' +
                                                   '<input type="text" class="form-control DisMePlease thisaccountname">' +
                                                '</div>' +
                                                 '<div class="col-md-3">' +
                                                   '<input type="text" class="form-control DisMePlease thisaccount">' +
                                                '</div>' +
                                                '<div class="col-md-2">'+
                                                    '<label class="pull-center inline">'+
                                                        '<input id="id-button-borders" type="checkbox" class="isShowTenant DisMePlease ace ace-switch ace-switch-5">'+
                                                        '<span class="lbl middle"></span>'+
                                                    '</label>'+
                                                '</div>'+
                                            '</div>');
                }
            },complete:function(){
                $(".DisMePlease").prop("disabled", true);
                BankList();
            }
        })
    }

    function BankList(){
        var count = $("#BankInfoRowCount").val();
        $.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'form=tblrefbank',
            success:function(data){
                $(".BankList"+count).html(data);
            }
        })
    }

    function AppendBankInfo(){
        // Edit Ronald 2018-10-11
        var count = $("#BankInfoRowCount").val();
        count = Number(count) + 1;
        $("#BankInfoRowCount").val(count);
        $("#BankListInfo").append('<div class="form-group row divBankList" id="divBankInfo'+count+'">' +
                                    '<div class="col-xs-1 center">' +
                                        '<label>' +
                                            '<input name="form-field-checkbox" type="checkbox" class="ace DisMePlease chkBankInfo" value="divBankInfo'+count+'">' +
                                            '<span class="lbl"></span>' +
                                        '</label>' +
                                    '</div>' +
                                    '<div class="col-xs-3">' +
                                        'Bank' +
                                    '</div>' +
                                    '<div class="col-xs-3">' +
                                        'Account Name' +
                                    '</div>' +
                                    '<div class="col-xs-3">' +
                                        'Account Number' +
                                    '</div>' +
                                    '<div class="col-xs-2">' +
                                        'Show in tenant' +
                                    '</div>' +
                                    '<div class="col-xs-3">' +
                                        '<select class="form-control DisMePlease BankList'+count+' thisbank"></select>' +
                                    '</div>' +
                                     '<div class="col-xs-3">' +
                                       '<input type="text" class="form-control DisMePlease thisaccountname">' +
                                    '</div>' +
                                     '<div class="col-xs-3">' +
                                       '<input type="text" class="form-control DisMePlease thisaccount">' +
                                    '</div>' +
                                    '<div class="col-md-2">'+
                                        '<label class="pull-center inline">'+
                                            '<input id="id-button-borders" type="checkbox" class="isShowTenant DisMePlease ace ace-switch ace-switch-5">'+
                                            '<span class="lbl middle"></span>'+
                                        '</label>'+
                                    '</div>'+
                                '</div>');
        BankList();
    }

    function RemoveBankInfo(){
        $(".chkBankInfo").each(function(){
            if($(this).is(":checked")){
                $("#"+$(this).val()).remove();
            }
        })
    }

    function SaveBankListinfo(){
        // Edit Ronald 2018-10-11
        var mallid = $("#txtmall_id").val();
        var bankInfo = "";
        $(".divBankList").each(function(){
            // if($(this).find(".thisbank").val() != "" || $(this).find(".thisaccount").val() != ""){
            //     bankInfo += $(this).find(".thisbank").val() + "|" + $(this).find(".thisaccount").val() + "|" + $(this).find(".thisaccountname").val() + "#";
            // }
            if($(this).find(".thisbank").val() != "" || $(this).find(".thisaccount").val() != ""){
                var Stat = 0;
                if( $(this).find(".isShowTenant").is(':checked') == true ){
                    Stat = 1;
                }
                bankInfo += $(this).find(".thisbank").val() + "|" + $(this).find(".thisaccount").val() + "|" + $(this).find(".thisaccountname").val() + "|" + Stat + "#";
            }
        })
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'mallid=' + mallid + '&bankInfo=' + bankInfo + '&form=SaveBankListinfo',
            success:function(data){
                setTimeout(function(){
                    showmodal("alert", "Bank account information successfully saved.", "closemodal_BankInfo", null, "", null, "0");
                }, 500)
            }
        })
    }

    function closemodal_BankInfo(){
        $("#BankInfoRowCount").val("1");
        $("#modal_BankInfo").modal("hide");
        $("#BankListInfo").html("");
    }

    function EnableDisMePlease(){
        $("#pangeditBankInfo").attr("onclick", "DisableDisMePlease();");
        $(".DisMePlease").prop("disabled", false);
        $("#pangeditBankInfo").removeClass("fa-edit");
        $("#pangeditBankInfo").addClass("fa-times");
        $("#pangeditBankInfo").css("color", "red");
    }

    function DisableDisMePlease(){
        $("#pangeditBankInfo").attr("onclick", "EnableDisMePlease();");
        $(".DisMePlease").prop("disabled", true);
        $("#pangeditBankInfo").addClass("fa-edit");
        $("#pangeditBankInfo").removeClass("fa-times");
        $("#pangeditBankInfo").css("color", "white");
    }
// SETUP SCRIPTS START

// IMPORT MALL CONFIGURATION START
    function fncDownloadTemplate(){
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'form=fncDownloadTemplate',
            success: function(data){
                var arr = data.split("|");
                $("#btnDLTemplate").attr("href", arr[0].trim());
                $("#btnDLTemplate").attr("download", arr[1].trim());
            }, complete: function(){
                $('#modal_ImportMallConf').modal('show');
                $(".divImportHome").removeClass("hide");
                $(".divImportTab").addClass("hide");
                fncDisplayMCLogs();
            }
        })
    }

    function fncImportTemplate(){
        $(".divImportHome").addClass("hide");
        $(".divImportTab").removeClass("hide");
    }

    function fncCancelImport(){
        $(".divImportHome").removeClass("hide");
        $(".divImportTab").addClass("hide");
    }

    function fncImportGo(){
        var data = new FormData($('#frmImportExcel')[0]);
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/uploadmallconfig.php',
            data: data,
            mimeType: 'multipart/form-data',
            contentType: false,
            cache: false,
            processData: false,
            success:function(data){
                if(data == 1){
                    setTimeout(function(){
                        showmodal("alert", "Bank account information successfully saved.", "fncResetImport", null, "", null, "0");
                    }, 500)
                }else{
                    setTimeout(function(){
                        showmodal("alert", "Bank account information successfully saved.", "", null, "", null, "1");
                    }, 500)
                }
            }
        });
    }

    function fncResetImport(){
        $("#frmImportExcel a").click();
        fncCancelImport();
        fncDisplayMCLogs();
    }

    function fncDisplayMCLogs(){
        var DateFrom = $("#txtMCDateFrom").val();
        var DateTo = $("#txtMCDateTo").val();
        var MallID = $("#txtImportMallID").val();
        $.ajax({
            type: 'POST',
            url: 'setup/mall_configuration/class.php',
            data: 'MallID=' + MallID + '&DateFrom=' + DateFrom + '&DateTo=' + DateTo + '&form=fncDisplayMCLogs',
            success: function(data){
                if(data != ""){
                    $("#tbodyMCLogs").html(data);
                }else{
                    $("#tbodyMCLogs").html("<tr><td colspan='3' style='text-align: center;'>No Data Found...</td></tr>");
                }
            }
        })
    }
// IMPORT MALL CONFIGURATION END
</script>