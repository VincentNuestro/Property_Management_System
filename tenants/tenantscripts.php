<script type="text/javascript">
    $(function(){
        $(".fixTable").tableHeadFixer();
        $("#txt_userpage_tenants").val("1");
        $("#txtLoadTenantPageCount").val("1");
        $("#txt_userpagepertenant").val("1");
        $("#acccheckstat").val("");
        tbltenantlists();
        $("#txtsearchtenantlist").keyup(function(e){
            var x = event.keyCode;
            if(x == 13){ 
                $("#txtLoadTenantPageCount").val("1");
                tbltenantlists(); 
            }else if(x == '8'){
                if($('#txtsearchtenantlist').val() == ""){
                    $("#txtLoadTenantPageCount").val("1");
                    tbltenantlists();
                }
            }
        });
        $("#txtSearchTPPaymentHistory").keyup(function(e){
            var x = event.keyCode;
            if(x == 13){ 
                tblpaymenthistory(); 
            }else if(x == '8'){
                if($('#txtSearchTPPaymentHistory').val() == ""){
                    tblpaymenthistory();
                }
            }
        });
        $("#txtSearchTPComplaints").keyup(function(e){
            var x = event.keyCode;
            if(x == 13){ 
                tblcomplaints(); 
            }else if(x == '8'){
                if($('#txtSearchTPComplaints').val() == ""){
                    tblcomplaints();
                }
            }
        });
        $("#txtSearchTPPDC").keyup(function(e){
            var x = event.keyCode;
            if(x == 13){ 
                tblsoa(); 
            }else if(x == '8'){
                if($('#txtSearchTPPDC').val() == ""){
                    tblsoa();
                }
            }
        });
        var counter = 0;
        var interval = setInterval(function() {
            counter++;
            if (counter == 1){
                tbltenantlists();
                $.ajax({
                    type: 'POST',
                    url: 'tenants/tenantmainclass.php',
                    data: '&form=counttenantstatus',
                    success: function(data){
                        if(data > 0){
                            $("#cntnotify").text(data);
                            $("#modalnotify").modal("show");
                        }
                    }
                });
            }
            
        }, 1000);
        loadinputTrap();
        $(".txtSysNumOnly").keydown(function(event) {
            if(event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 190 || event.keyCode == 9 || event.keyCode == 188){

            }else{
                if (event.keyCode < 48 || event.keyCode > 57 || event.keyCode == 17) {
                    event.preventDefault(); 
                }   
            }
        });
        $(".txtSysCurrency").change(function(){
            var x = ($(this).val()).replace(/,/g,"");
            var v = parseFloat(x||0);
            $(this).val(v.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
        });
        $('[data-rel=tooltip]').tooltip();
        $('[data-rel=popover]').popover({html:true});
        $(".date-picker").datepicker({
            autoHide: true,
            format: 'mm/dd/yyyy',
            todayHighlight: true
        });
        $.mask.definitions['~']='[+-]';
        $('.input-mask-date').mask('99/99/9999');
        $('.input-mask-month').mask('99/99/9999');
        $('.input-mask-phone').mask('(999) 999-9999');
        // $('.input-mask-tele').mask('(99)-999-9999');
        $('.input-mask-eyescript').mask('~9.99 ~9.99 999');
        $(".input-mask-product").mask("a*-999-a999",{placeholder:" ",completed:function(){alert("You typed the following: "+this.val());}});
        timeemail();
        // American Numbering System
        var th = ['','thousand','million', 'billion','trillion'];
        // uncomment this line for English Number System
        // var th = ['','thousand','million', 'milliard','billion'];
        var dg = ['zero','one','two','three','four', 'five','six','seven','eight','nine']; var tn = ['ten','eleven','twelve','thirteen', 'fourteen','fifteen','sixteen', 'seventeen','eighteen','nineteen']; var tw = ['twenty','thirty','forty','fifty', 'sixty','seventy','eighty','ninety']; function toWords(s){s = s.toString(); s = s.replace(/[\, ]/g,''); if (s != parseFloat(s)) return 'not a number'; var x = s.indexOf('.'); if (x == -1) x = s.length; if (x > 15) return 'too big'; var n = s.split(''); var str = ''; var sk = 0; for (var i=0; i < x; i++) {if ((x-i)%3==2) {if (n[i] == '1') {str += tn[Number(n[i+1])] + ' '; i++; sk=1;} else if (n[i]!=0) {str += tw[n[i]-2] + ' ';sk=1;}} else if (n[i]!=0) {str += dg[n[i]] +' '; if ((x-i)%3==0) str += 'hundred ';sk=1;} if ((x-i)%3==1) {if (sk) str += th[(x-i-1)/3] + ' ';sk=0;}} if (x != s.length) {var y = s.length; str += 'point '; for (var i=x+1; i<y; i++) str += dg[n[i]] +' ';} return str.replace(/\s+/g,' ');}
    });

    function tbltenantlists(){
        var page = $("#txtLoadTenantPageCount").val();
        var key = $("#txtsearchtenantlist").val();
        $.ajax({
            type: 'POST',
            url: 'tenants/tenantmainclass.php',
            data: 'page=' + page + '&key=' + key+ '&form=tbltenantlists',
            beforeSend : function() {
                $('#indexloadingscreen').addClass('myspinner');
            },
            success: function(data){
                $('#indexloadingscreen').removeClass('myspinner');
                if(data != ""){
                    $("#tbltenantlists").html(data);
                }else{
                    $("#tbltenantlists").html("<tr><td colspan='10' style='text-align: center;'>No Data Found...</td></tr>");
                }
                loadTenantListPage();
                loadTenantListEntries();
            }
        });
    }

    function loadTenantListPage(){
        var page = $("#txtLoadTenantPageCount").val();
        var key = $("#txtsearchtenantlist").val();
        $.ajax({
            type: 'POST',
            url: 'tenants/tenantmainclass.php',
            data: 'page=' + page + '&key=' + key + '&form=loadTenantListPage',
            success: function(data){
                $("#ulTenantListPageCont").html(data);
            }
        });
    }

    function loadTenantListEntries(){
        var page = $("#txtLoadTenantPageCount").val();
        var key = $("#txtsearchtenantlist").val();
        $.ajax({
            type: 'POST',
            url: 'tenants/tenantmainclass.php',
            data: 'page=' + page + '&key=' + key + '&form=loadTenantListEntries',
            success: function(data){
                $("#txtTenantListEntries").text(data);
            }
        });
    }

    function TenantListPageFunc(page, pagenums){
        $(".pgTenantList").removeClass("active");
        $("#pgnumTenantList" + pagenums).addClass("active");
        $("#txtLoadTenantPageCount").val(page);
        tbltenantlists();
    }

    function loadTenantsFilter(module){
        $.ajax({
            type: 'POST',
            url: 'filter/class.php',
            data: 'module=' + module + '&form=loadFilters',
            success: function(data){
                var datas = data.split("#");
                var arr = datas[0].split("|");
                var arr2 = datas[1].split("|");
                var arr3 = datas[2].split("|");
                var arr4 = datas[3].split("|");
                for(var i=0; i<=arr.length-1; i++){
                    $('input:checkbox[id="filter_'+arr[i]+'"][value="'+arr[i]+'"]').attr('checked', 'checked');
                }
                $("#contractstart").val(arr2[0]);
                $("#contractend").val(arr2[1]);
                for(var i=0; i<=arr3.length-1; i++){
                    $('input:checkbox[id="filter_'+arr3[i]+'"][value="'+arr3[i]+'"]').attr('checked', 'checked');
                }
                for(var i=0; i<=arr4.length-1; i++){
                    $('input:checkbox[id="filter_'+arr4[i]+'"][value="'+arr4[i]+'"]').attr('checked', 'checked');
                }
            }
        })
    }

    function saveTenantFilter(){
        var module = "Tenant";
        var checked = "";
        $('input:checkbox[name="form-field-checkboxtttttttt"]').each(function(){
            if($(this).is(":checked")){
                var value = $(this).attr("value");
                checked += value + "|";
            }
        })

        var checked2 = "";
        $('input:checkbox[name="form-field-checkboxtttttttt"]').each(function(){
            var value2 = $(this).attr("value");
            checked2 += value2 + "|";
        })

        var checked3 = "";
        $('input:checkbox[name="form-field-checkbox-stado"]').each(function(){
            if($(this).is(":checked")){
                var value3 = $(this).attr("value");
                checked3 += value3 + "|";
            }
        })

        var xcheck = "";
        $('input:checkbox[name="form-field-checkbox-tstatus"]').each(function(){
            if($(this).is(":checked")){
                var value3 = $(this).attr("value");
                xcheck += value3 + "|";
            }
        })
        var Date1 = $("#contractstart").val();
        var Date2 = $("#contractend").val();

        $.ajax({
            type: 'POST',
            url: 'filter/class.php',
            data: 'module=' + module + '&checked=' + checked + '&checked2=' + checked2 + '&checked3=' + checked3 + '&xcheck=' + xcheck + '&Date1=' + Date1 + '&Date2=' + Date2 + '&form=saveFilters',
            success: function(data){
                tbltenantlists()
                $("#LINK_Tenant_filter").click();
            }
        })
    }

    function showinfo(tenantid, inquiryid, applicationid, stat, mallid, CompanyID, TradeID, isProposal, ProposalStat){
        $("#btnSaveNEdit").text('Edit')
        $("#mallidprint").val(mallid);
        $("#Tid").text(tenantid);
        $("#inqid").val(inquiryid);
        $("#inqidreq").val(inquiryid);
        $("#inqidper").val(inquiryid);
        $("#appidper").val(applicationid);
        $("#appidreq").val(applicationid);
        $("#txtcompid").val(CompanyID);
        $("#txtTenantTradeID").val(TradeID);
        malltemplate();
        fncTenantInfo();
        if(stat == "Active"){
            $("#stathere").html("<span class='fa fa-flag' style='font-weight: 700; color: #DFE21A;'></span>&nbsp;&nbsp;Active");
        }else if(stat == "Inactive"){
            $("#stathere").html("<span class='fa fa-flag' style='font-weight: 700; color: DarkGray;'></span>&nbsp;&nbsp;In-active");
        }else if(stat == "ForRenewal"){
            $("#stathere").html("<span class='fa fa-flag' style='font-weight: 700; color: #428BCA;'></span>&nbsp;&nbsp;For Renewal");
        }else if(stat == "ForEviction"){
            $("#stathere").html("<span class='fa fa-flag' style='font-weight: 700; color: red;'></span>&nbsp;&nbsp;For Eviction");
        }else{
            $("#stathere").html("<span class='fa fa-flag' style='font-weight: 700; color: grey;'></span>&nbsp;&nbsp;Evicted");
        }
        $("#btnAddNewContract").attr("onclick", "fncEditGlobalFormInquiry(\"0\", \""+ inquiryid +"\", \""+ applicationid +"\", \"\", \""+ TradeID +"\", \""+ CompanyID +"\", \""+ isProposal +"\", \""+ ProposalStat +"\", '0', \""+ tenantid +"\", \"1\")");
        $("#tenantinfo").modal('show');
    }

    function loadTenantsProfFilter(module){
        $.ajax({
            type: 'POST',
            url: 'filter/class.php',
            data: 'module=' + module + '&form=loadFilters',
            success: function(data){
                var datas = data.split("#");
                var arr = datas[0].split("|");
                var arr2 = datas[1].split("|");
                var arr3 = datas[2].split("|");
                var arr4 = datas[3].split("|");
                for(var i=0; i<=arr.length-1; i++){
                    $('input:checkbox[id="filter_'+arr[i]+'"][value="'+arr[i]+'"]').attr('checked', 'checked');
                }
                if(module == "TMListComplaints"){
                    $("#TPComplaintsDateFrom").val(arr2[0]);
                    $("#TPComplaintsDateTo").val(arr2[1]);
                    $("#btnSaveFilterComplaints").attr("onclick", "saveTenantsProfFilter('TMListComplaints')");
                }else if(module == "TMListPaymentHistory"){
                    $("#TPPaymentHistoryDateFrom").val(arr2[0]);
                    $("#TPPaymentHistoryDateTo").val(arr2[1]);
                    $("#btnSaveFilterComplaints").attr("onclick", "saveTenantsProfFilter('TMListPaymentHistory')");
                }else if(module == "TMListSoA"){
                    $("#TPSoADateFrom").val(arr2[0]);
                    $("#TPSoADateTo").val(arr2[1]);
                    $("#btnSaveFilterComplaints").attr("onclick", "saveTenantsProfFilter('TMListSoA')");
                }
                for(var i=0; i<=arr3.length-1; i++){
                    $('input:checkbox[id="filter_'+arr3[i]+'"][value="'+arr3[i]+'"]').attr('checked', 'checked');
                }
                for(var i=0; i<=arr4.length-1; i++){
                    $('input:checkbox[id="filter_'+arr4[i]+'"][value="'+arr4[i]+'"]').attr('checked', 'checked');
                }
            }
        })
    }

    function saveTenantsProfFilter(module){
        if(module == "TMListComplaints"){
            var checked = "";
            $('input:checkbox[name="form-field-TPComplaints"]').each(function(){
                if($(this).is(":checked")){
                    var value = $(this).attr("value");
                    checked += value + "|";
                }
            })
            var checked2 = "";
            $('input:checkbox[name="form-field-TPComplaints"]').each(function(){
                var value2 = $(this).attr("value");
                checked2 += value2 + "|";
            })
            var checked3 = "";
            $('input:checkbox[name="form-field-TPComplaintStat"]').each(function(){
                if($(this).is(":checked")){
                    var value3 = $(this).attr("value");
                    checked3 += value3 + "|";
                }
            })
            var xcheck = "";
            $('input:checkbox[name="form-field-TPComplaintStatus"]').each(function(){
                if($(this).is(":checked")){
                    var value3 = $(this).attr("value");
                    xcheck += value3 + "|";
                }
            })
            var Date1 = $("#TPComplaintsDateFrom").val();
            var Date2 = $("#TPComplaintsDateTo").val();
        }else if(module == "TMListPaymentHistory"){
            var checked = "";
            $('input:checkbox[name="form-field-TPPaymentHistory"]').each(function(){
                if($(this).is(":checked")){
                    var value = $(this).attr("value");
                    checked += value + "|";
                }
            })
            var checked2 = "";
            $('input:checkbox[name="form-field-TPPaymentHistory"]').each(function(){
                var value2 = $(this).attr("value");
                checked2 += value2 + "|";
            })
            var checked3 = "";
            var xcheck = "";
            var Date1 = $("#TPPaymentHistoryDateFrom").val();
            var Date2 = $("#TPPaymentHistoryDateTo").val();
        }else if(module == "TMListSoA"){
            var checked = "";
            $('input:checkbox[name="form-field-TPSoA"]').each(function(){
                if($(this).is(":checked")){
                    var value = $(this).attr("value");
                    checked += value + "|";
                }
            })
            var checked2 = "";
            $('input:checkbox[name="form-field-TPSoA"]').each(function(){
                var value2 = $(this).attr("value");
                checked2 += value2 + "|";
            })
            var checked3 = "";
            var xcheck = "";
            var Date1 = $("#TPSoADateFrom").val();
            var Date2 = $("#TPSoADateTo").val();
        }else{
            var checked = "";
            var checked2 = "";
            var checked3 = "";
            var xcheck = "";
            var Date1 = "";
            var Date2 = "";
        }
        $.ajax({
            type: 'POST',
            url: 'filter/class.php',
            data: 'module=' + module + '&checked=' + checked + '&checked2=' + checked2 + '&checked3=' + checked3 + '&xcheck=' + xcheck + '&Date1=' + Date1 + '&Date2=' + Date2 + '&form=saveFilters',
            success: function(data){
                $("#LINK_"+module+"_filter").click();
                if(module == "TMListComplaints"){
                    tblcomplaints();
                }else if(module == "TMListPaymentHistory"){
                    tblpaymenthistory();
                }else if(module == "TMListSoA"){
                    tblsoa();
                }
            }
        })
    }

    //Tenant Information Profile
    function fncTenantInfo(){
        var TenantID = $("#Tid").text();
        var InquiryID = $("#inqid").val();
        $.ajax({
            type: 'POST',
            url: 'tenants/tenantmainclass.php',
            data: 'TenantID=' + TenantID + '&InquiryID=' + InquiryID + '&form=fncTenantInfo',
            success:function(data){
                var arr = data.split("|");
                $("#imgTenantPic").attr("src", arr[0]);
                $("#imgTenantPic").attr("alt", arr[1]);
                $("#txtTenantTradeName").text(arr[1]);
                $("#merchant_code").text(arr[2]);
                $("#company").text(arr[3]);
                $("#contactp").text(arr[4]);
                $("#billingttype").text(arr[5]);
                $("#Sdate").text(arr[6]);
                $("#Edate").text(arr[7]);
                $("#EscaRate").text(arr[8]);
                $("#EscaYearStart").text(arr[9]);
                $("#EscaYearBasis").text(arr[10]);
            }
        });
        $.ajax({
            type: 'POST',
            url: 'tenants/tenantmainclass.php',
            data: 'InquiryID=' + InquiryID + '&form=fncTenantUnitLIst',
            success: function(data){
                $("#divTenantUnitList").html(data);
            }
        })
    }

    // CONTACT INFO START
    function tblcontactinfo(){
        var TradeID = $("#txtTenantTradeID").val();
        var CompanyID = $("#txtcompid").val();
        $.ajax({
            type: 'POST',
            url: 'tenants/tenantmainclass.php',
            data: 'TradeID=' + TradeID + '&CompanyID=' + CompanyID + '&form=tblcontactinfo',
            success: function(data){
                $("#tblcontactinfo").html(data);
            }, complete(){
                $('#user-profile-2 .memberdiv').on('mouseenter touchstart', function(){
                    var $this = $(this);
                    var $parent = $this.closest('.tab-pane');
                    var off1 = $parent.offset();
                    var w1 = $parent.width();
                    var off2 = $this.offset();
                    var w2 = $this.width();
                    var place = 'left';
                    if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) place = 'right';
                    $this.find('.popover').removeClass('right left').addClass(place);
                }).on('click', function(e) {
                    e.preventDefault();
                })

            }
        });
    }

    function editcontactinfo(lname, fname, mname, position, address, img, conid, mobile, telephone, email) {
        $("#imgcontact").attr("src", img);
        $("#lname").val(lname);
        $("#conid").val(conid);
        $("#fname").val(fname);
        $("#mname").val(mname);
        $("#designation").val(position);
        $("#address").val(address);
        $("#txtConMob").val(mobile);
        $("#txtConTel").val(telephone);
        $("#txtConEmail").val(email);
        if(img != ""){
            $("#imgcontact").css("display", "block");
            $("#txtconspan").css("display", "none");
            $("#txtconclick").css("display", "none");
            $("#btnremoveconpic").css("display", "inline-block");
        }else{
            removecontactphoto();
        }
        $("#modalcontactperson").modal("show");
    }

    function showimgcontact(){
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("contactimage").files[0]);

        oFReader.onload = function (oFREvent) {
            $("#imgcontact").css("display", "block");
            $("#txtconspan").css("display", "none");
            $("#txtconclick").css("display", "none");
            document.getElementById("imgcontact").src = oFREvent.target.result;
            $("#btnremoveconpic").css("display", "inline-block");
        };
    }

    function removecontactphoto(){
        $("#btnremoveconpic").css("display", "none");
        $("#imgcontact").attr("src", "#");
        $("#imgcontact").css("display", "none");
        $("#txtconspan").css("display", "block");
        $("#txtconclick").css("display", "block");
        $("#contactimage").val("");
    }

    function validateEmail(sEmail) {
        var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if(filter.test(sEmail)){
            return true;
        }else{
            return false;
        }
    }

    function timeemail(){
        $('.txtEmail').each(function(){
            $(this).focusout(function() {
                var sEmail = $(this).val();
                if ($.trim(sEmail).length == 0) {
                    $(this).focus();
                    $(".errohere").text("Please enter valid email address");
                    e.preventDefault();
                }
                if (validateEmail(sEmail)) {
                    $(".errohere").hide();
                }else {
                    $(this).focus();
                    $(".errohere").text("Invalid Email Address");
                    e.preventDefault();
                }
            });
        });
    }

    function removeinfo(type){
        $(".new"+type).remove();
    }

    function savecontactperson(){
        var Tid = $("#Tid").text();
        var inqid = $("#inqid").val();
        var conid = $("#conid").val();
        var compid = $("#txtcompid").val();
        var name = $("#fname").val() + " " + $("#mname").val() +", "+$("#lname").val();
        var confname = $("#fname").val();
        var conmname = $("#mname").val();
        var conlname = $("#lname").val();
        var designation = $("#designation").val();
        var address = $("#address").val();
        var Mobile  = $("#txtConMob").val();
        var Telephone = $("#txtConTel").val();
        var Email = $("#txtConEmail").val();
        var count = 0;
        $(".txtConReq").each(function(){
            if($(this).val() == ""){
                $(this).css("border-color","#f2a696");
                count++;
            }else{
                $(this).css("border-color","#D5D5D5");
            }
        })
        if(count == 0){
            $.ajax({
                type: 'POST',
                url: 'tenants/tenantmainclass.php',
                data: 'Tid='+ Tid + '&conid=' + conid + '&compid=' + compid + '&name=' + name + '&confname=' + confname + '&conmname=' + conmname + '&conlname=' + conlname + '&Mobile=' + Mobile + '&Telephone=' + Telephone + '&Email=' + Email + '&designation=' + designation + '&address=' + address + '&form=savecontactperson',
                success:function(data){
                    var arr = data.split("|");
                    setTimeout(function(){
                        showmodal("alert", arr[0], "", null, "", null, "0");
                    }, 1000)
                    sendData2(arr[1], arr[2]);
                    tblcontactinfo();
                    $("#modalcontactperson").find("input").val("");
                    $("#modalcontactperson").modal('hide');
                }
            });
        }else{
            setTimeout(function(){
                showmodal("alert", "Please fill all fields.", "", null, "", null, "0");
            }, 500)
        }
    }

    function sendData2(con, com){
        var compid = $("#txtcompid").val();
        $("#conidpic").val(con);
        $("#comidpic").val(compid);
        var data = new FormData($('#posting_contactimage')[0]);
        $.ajax({
            type:"POST",
            url:"tenants/uploadpic.php",
            data: data,
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            success:function(data){

            }
        });
    }
    // CONTACT INFO END

    // REQUIREMENTS START
    function tblrequirements(){
        var TenantID = $("#Tid").text();
        var InquiryID = $("#inqidreq").val();
        $.ajax({
            type: 'POST',
            url: 'tenants/tenantmainclass.php',
            data: 'InquiryID=' + InquiryID + '&TenantID=' + TenantID + '&form=tblrequirements',
            success: function(data){
                $("#tblrequirements").html(data);
                $("#description").val("");
                $("#file_uploads").val("");
            }
        });
    }

    function savereq(){
        var docname = $("#docname").val();
        var filename = $("#file_uploads")[0].files.length;
        if(docname == "" || docname == null){
            setTimeout(function(){
                showmodal("alert", "Please select the type of requirement you want to upload.", "", null, "", null, "1");
            }, 1000)
        }else{
            if(filename == 1){
                setTimeout(function(){
                    showmodal("confirm", "Save document?", "savereq2", null, "", null, "1");
                }, 1000)
            }else{
                setTimeout(function(){
                    showmodal("alert", "Please select a file you want to upload.", "", null, "", null, "1");
                }, 1000)
            }
        }
    }

    function savereq2(){
        var data = new FormData($('#posting_comments')[0]);
        $.ajax({
            type: "POST",
            url: "tenants/uploadreq.php",
            data: data,
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            success:function(data){
                setTimeout(function(){
                    showmodal("alert", data, "tblrequirements", null, "", null, "0");
                }, 1000)
            }
        });
    }
    // REQUIREMENTS END

    // PAYMENT SCHEDULE START
    function fncPaymentSchedule(){
        var tid = $("#Tid").text();
        var inqid = $("#inqid").val();
        $.ajax({
            type: 'POST',
            url: 'tenants/tenantmainclass.php',
            data: 'TenantID=' + tid + '&InquiryID=' + inqid + '&form=fncPaymentSchedule',
            success: function(data){
                var arr = data.split("|");
                $("#divPaymentSchedule").html(data);
            },
            complete: function(){
                $("#div_ModRent").modal("hide");
                $(".fixTable").tableHeadFixer();
            }
        })
    }

    function fncModRent(id){
        $("#div_ModRent").modal("show");
        $("#txtModRentID").val(id);
        $.ajax({
            type: 'POST',
            url: 'tenants/tenantmainclass.php',
            data: 'id=' + id + '&form=fncModRent',
            success: function(data){
                var arr = data.split("|");
                $("#txtModRentDate").val(arr[0]);
                $("#txtModRentRevPerc").val(arr[1]);
                $("#txtModRentAmount").val(arr[2]);
                $("#txtModRentAssocDues").val(arr[3]);
            }
        })
    }

    function fncSaveModRent(){
        var TenantID = $("#Tid").text();
        var SchedID = $("#txtModRentID").val();
        var BillDate = $("#txtModRentDate").val();
        var RevPerc = $("#txtModRentRevPerc").val();
        var RentAmount = $("#txtModRentAmount").val().replace(/,/g, "");
        <?php if(SysLeaseSetup('isAssocDues') == "1"){ ?>
        var AssocDues = $("#txtModRentAssocDues").val().replace(/,/g, "");
        <?php }else{ ?>
        var AssocDues = 0;
        <?php } ?>
        $.ajax({
            type: 'POST',
            url: 'tenants/tenantmainclass.php',
            data: 'SchedID=' + SchedID + '&BillDate=' + BillDate + '&RevPerc=' + RevPerc + '&RentAmount=' + RentAmount + '&AssocDues=' + AssocDues + '&TenantID=' + TenantID + '&form=fncSaveModRent',
            success: function(data){
                var arr = data.split("|");
                if(arr[0] == 1){
                    setTimeout(function(){
                        showmodal("alert", arr[1], "fncPaymentSchedule", null, "", null, "0");
                    }, 1000)
                }else{
                    setTimeout(function(){
                        showmodal("alert", arr[1], "", null, "", null, "1");
                    }, 1000)
                }
            }
        })
    }    
    // PAYMENT SCHEDULE END

    // PAYMENT HISTORY START
    function tblpaymenthistory(){
        var tid = $("#Tid").text();
        var key = $("#txtSearchTPPaymentHistory").val();
        $.ajax({
            type: 'POST',
            url: 'tenants/tenantmainclass.php',
            data: 'key=' + key + '&tenantid=' + tid + '&form=tblpaymenthistory',
            success:function(data){
                if(data != ""){
                    $("#tblpaymenthistory").html(data);
                }else{
                    $("#tblpaymenthistory").html("<tr><td colspan='5' style='text-align: center;'>No Data Found...</td></tr>");
                }
            }
        })
    }
    
    function printpaymenthistory(){
        var tenantid = $("#Tid").text();
        $.ajax({
            type: 'POST',
            url: 'tenants/tenantmainclass.php',
            data: 'tenantid=' + tenantid + '&form=tblpaymenthistory',
            success:function(data){
                $("#tblprintpaymenthistory").html(data);
                if(data == 0){
                    setTimeout(function(){
                        showmodal("alert", "Sorry, No data found.", "", null, "", null, "0");
                    }, 1000)
                }else{
                    var toPrint = document.getElementById("printpaymenthistory");
                    var myheight = $(window).height()-40;
                    var mywidth = $(window).width()-40;
                    var popupWin = window.open("", "Maintenance", "height=" + myheight + ",width=" + mywidth + ",location=no,scrollbars=1,left=" + 20);
                        popupWin.document.open();
                        popupWin.document.write('<html><title>Maintenance</title><link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" /><style>@media print{ table{ page-break-after:auto } tr{ page-break-inside:avoid; page-break-after:auto } td{ page-break-inside:avoid; page-break-after:auto } thead{ display:table-header-group } tfoot{ display:table-footer-group } }</style><body onload="window.print();">' );
                        popupWin.document.write( toPrint.innerHTML);
                        popupWin.document.write('</body></html>');
                        popupWin.document.close();
                }
            }
        })
    }
    // PAYMENT HISTORY END

    // STATEMENT OF ACCOUNTS START
    function tblsoa(){
        var tid = $("#Tid").text();
        var datefrom = $("#TSoADateFrom").val();
        var dateto = $("#TSoADateTo").val();
        var key = $("#txtSearchTPPDC").val();
        $.ajax({
            type: 'POST',
            url: 'tenants/tenantmainclass.php',
            data: 'key=' + key + '&datefrom=' + datefrom + '&dateto=' + dateto + '&tenantid=' + tid + '&form=tblsoa',
            success:function(data){
                if(data != ""){
                    $("#tblaccounthetails").html(data);
                }else{
                    $("#tblaccounthetails").html("<tr><td colspan='8' style='text-align: center;'>No Data Found...</td></tr>");
                }
            }
        })
    }

    function opensoa_separate(tenantid, soaid){
        $("#modal_opensoa").modal("show");
        $.ajax({
            type: 'POST',
            url: 'billing/billing/class.php',
            data: 'tenantid=' + tenantid + '&soaid=' + soaid + '&form=getTenantInfo',
            success: function(data){
                var arr = data.split("|");
                $("#txtprint_storename").text(arr[0]);
                $("#txtprint_address").text(arr[1]);
                $("#txtprint_cutoff").text(arr[2]);
                // $("#print_footer").html(arr[3])
                $("#txtprint_billingperiod").text(arr[4]);
                $("#txtprint_assignee").text(arr[5]);
                $("#txtprint_billingnumber").text(arr[6]);
                // current charges
                $.ajax({
                    type: 'POST',
                    url: 'billing/billing/class.php',
                    data: 'tenantid=' + tenantid + '&soaid=' + soaid + '&form=getCurrentCharges',
                    success: function(data){
                        $("#tblcurrchrges").html(data);
                    }
                });
                // other charges
                $.ajax({
                    type: 'POST',
                    url: 'billing/billing/class.php',
                    data: 'tenantid=' + tenantid + '&soaid=' + soaid + '&form=getOtherCharges',
                    success:function(data){
                        $("#tblotherchrges").html(data);
                    }
                })
                // payments
                $.ajax({
                    type: 'POST',
                    url: 'billing/billing/class.php',
                    data: 'tenantid=' + tenantid + '&soaid=' + soaid + '&form=getPayments',
                    success: function(data){
                        $("#tblpymentcrdtadj").html(data);
                    }
                });
                // breakdowns
                $.ajax({
                    type: 'POST',
                    url: 'billing/billing/class.php',
                    data: 'tenantid=' + tenantid + '&soaid=' + soaid + '&form=getBreakdowns',
                    success: function(data){
                        var arr = data.split("|");
                        $("#ttlprevblncs").text(arr[0]);
                        $("#ttlprevblncs2").text(arr[0]);
                        $("#ttlcurrchrges2").text(arr[1]);
                        $("#ttlcurrchrges").text(arr[1]);
                        $("#ttlpymentcrdtadj").text(arr[2]);
                        $("#ttlpymentcrdtadj2").text(arr[2]);
                        $("#ttlpenalty").text(arr[3]);
                        $("#ttlamtdue").text(arr[4]);
                    }
                })
                // Aging
                $.ajax({
                    type: 'POST',
                    url: 'billing/billing/class.php',
                    data: 'tenantid=' + tenantid + '&soaid=' + soaid + '&form=getAging',
                    success:function(data){
                        var arr = data.split("|");
                        $("#txtsoab00").text(arr[0]);
                        $("#txtsoab13").text(arr[1]);
                        $("#txtsoab36").text(arr[2]);
                        $("#txtsoab69").text(arr[3]);
                        $("#txtsoab99").text(arr[4]);
                    }
                })
                // SIGNATORIES
                $.ajax({
                    type: 'POST',
                    url: 'billing/billing/class.php',
                    data: 'tenantid=' + tenantid + '&form=getSignatories',
                    success:function(data){
                        var arr = data.split("#");
                        $("#lblprepby").text(arr[0]);
                        $("#lblchkby").text(arr[1]);
                        $("#lblapprby").text(arr[2]);
                        $("#lblrcvdby").text(arr[3]);
                    }
                })
            }
        })
        $.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'tenantid=' + tenantid + '&form=getheaderprint',
        success:function(data){
                $("#template2").html(data);
            }
        })
    }

    function closemodalsoa(){
        $(".companyname").text("");
        $(".companyaddress").text("");
        $("#labelimg").attr("src", "");
        $("#txtprint_storename").text("")
        $("#txtprint_cutoff").text("")
        $("#txtprint_assignee").text("")
        $("#txtprint_address").text("")
        $("#tblreportcontent").html("");
        $("#tblprevblncs").html("");
        $("#tblcurrchrges").html("");
        $("#tblpymentcrdtadj").html("");
        $("#ttlprevblncs").text("");
        $("#ttlcurrchrges").text("");
        $("#ttlpymentcrdtadj").text("");
        $("#ttlprevblncs2").text("");
        $("#ttlcurrchrges2").text("");
        $("#ttlpymentcrdtadj2").text("");
        $("#ttlamtdue").text("");
        $("#ttlamtvat").text("");
        $("#modal_opensoa").modal("hide");
        $("#txtprint_billingperiod").text("");
    }

    function printallsoaheader(){
        var tid = $("#Tid").text();
        $.ajax({
            type: 'POST',
            url: 'tenants/tenantmainclass.php',
            data: 'tenantid=' + tid + '&form=tblsoa',
            success:function(data){
                $("#tblaccounthetails2").html(data);       
                if(data == 0){
                    setTimeout(function(){
                        showmodal("alert", "Sorry, No data found.", "", null, "", null, "0");
                    }, 1000)
                }else{
                    var toPrint = document.getElementById("div_printallsoaheader");
                    var myheight = $(window).height()-40;
                    var mywidth = $(window).width()-40;
                    var popupWin = window.open("", "SOA", "height=" + myheight + ",width=" + mywidth + ",location=no,scrollbars=1,left=" + 20);
                    popupWin.document.open();
                    popupWin.document.write('<html><title>Statement of Accounts</title><link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" /><style>@media print{ table{ page-break-after:auto } tr{ page-break-inside:avoid; page-break-after:auto } td{ page-break-inside:avoid; page-break-after:auto } thead{ display:table-header-group } tfoot{ display:table-footer-group } }</style><body onload="window.print();">' );
                    popupWin.document.write( toPrint.innerHTML);
                    popupWin.document.write('</body></html>');
                    popupWin.document.close();
                }         
            }
        })
    }

    function printsoa(){
        var toprint = $("#tblsoa2").html();
        var myheight = $(window).height()-40;
        var mywidth = $(window).width()-40;
        var popupWin = window.open("", "Statement of Accounts", "height=" + myheight + ",width=" + mywidth + ",location=no,scrollbars=1,left=" + 20);
        popupWin.document.open();
        popupWin.document.write("<html><head><title></title><style>*{font-family: 'Segoe UI', Tahoma, sans-serif; font-size:10px !important;}@media screen {div.divFooter {display: none;}}@media print { div.divFooter {position: fixed;bottom: 0;}}</style></head><body><div class='checklist'>" + toprint + "</div></body></html>");
        popupWin.print();
        popupWin.close();
    }
    // STATEMENT OF ACCOUNTS END

    // PDC TAB START
    function tblpdc(){
        var id = $("#Tid").text();
        var datefrom = $("#pdcDateFrom").val();
        var dateto = $("#pdcDateTo").val();
        $.ajax({
            type: 'POST',
            url: 'tenants/tenantmainclass.php',
            data: 'datefrom=' + datefrom + '&dateto=' + dateto + '&id=' + id + '&form=tblpdc',
            success: function(data){
                if(data != ""){
                    $("#tblpdc").html(data);
                }else{
                    $("#tblpdc").html("<tr><td colspan='6' style='text-align: center;'>No Data Found...</td></tr>");
                }
                thisrow();
            }
        });
    }

    function tblpdc2(){
        var id = $("#Tid").text();
        var datefrom = $("#pdcDateFrom").val();
        var dateto = $("#pdcDateTo").val();
        $.ajax({
            type: 'POST',
            url: 'tenants/tenantmainclass.php',
            data: 'datefrom=' + datefrom + '&dateto=' + dateto + '&id=' + id + '&form=tblpdc',
            success: function(data){
                $("#tblpdc2").html(data);
            }
        });
    }

    function choosepdc(pdcdate, accstat, lname, fname, checkno, bank, rcvby, depo, amount, stat, id, total1, total, depdate){
        var id = $("#inqidreq").val();
        if(stat == "Cleared"){
            $("#btnsavepdc").prop('disabled', true);
            $("#accbank").prop('disabled', true);
            $("#accreceiveby").prop('disabled', true);
            $("#accdepository").prop('disabled', true);
            $("#acccheckstat").prop('disabled', true);
        }else{
            $("#btnsavepdc").prop('disabled', false);
            $("#accbank").prop('disabled', false);
            $("#accreceiveby").prop('disabled', false);
            $("#accdepository").prop('disabled', false);
            $("#acccheckstat").prop('disabled', false);
        }
        $("#accpdcdate").val(pdcdate);
        $("#accbank").text(bank);
        $("#banko").text(bank);
        $("#acctname").val(fname+" "+lname);
        $("#accreceiveby").val(rcvby);
        $("#acccheckstat").val(stat);
        $("#accstat").val(accstat);
        $("#accamount").val(Number(amount).toLocaleString()+".00");
        $("#acccheckno").val(checkno);
        $("#accdepository").val(depo);
        $("#acctotal").val(total);
        $("#accdatedep").val(depdate);
        $("#amntwrd").text(toWords(amount)+" Pesos.");
    }

    function thisrow(){
        $(".thisrow").each(function(){
            $(this).click(function(){
                $(".thisrow").removeClass("activated");
                $(this).addClass("activated");
            });
        });
    }

    function cancelpdctransaction(){
        $('#pdc').find(".form-control").val("");
        $("#accamount").val("");
        $("#amntwrd").text("");
        $("#banko").text("");
        $('.thisrow').removeClass('activated');
    }

    function savepdctransaction(){
        var acccheckno = $("#acccheckno").val();
        var opt = $('#acccheckstat option:selected').map(function() {
            return this.value;
        }).get();
        var bilang = 0;
        $(".postpdcreq").each(function(){
            if($(this).val() == "" && $(this).text() == ""){
                bilang++;
                $(this).css("border-color","#f2a696");
            }else{
                $(this).css("border-color","#D5D5D5");
            }
        })
        if(opt != "Pending"){
            if(bilang != "0"){
                setTimeout(function(){
                    showmodal("alert", "Please fill all fields.", "", null, "", null, "1");
                }, 1000)
            }else{
                setTimeout(function(){
                    showmodal("confirm", "Do you want to clear the PDC check no: "+acccheckno+"?", "savepdctransaction2", null, "", null, "1");
                }, 1000)
            }
        }else{
            setTimeout(function(){
                showmodal("alert", "Change the check status to be cleared.", "", null, "", null, "0");
            }, 1000)
        }
    }

    function savepdctransaction2(){
        var id = $("#inqidreq").val();
        var tid = $("#Tid").text();
        var acctname = $("#acctname").val();
        var accpdcdate = $("#accpdcdate").val();
        var accbank = $("#accbank").text();
        var accreceiveby = $("#accreceiveby").val();
        var acccheckstat = $("#acccheckstat").val();
        var accstat = $("#accstat").val();
        var accamount = $("#accamount").val();
        var acccheckno = $("#acccheckno").val();
        var accdepository = $("#accdepository").val();
        var acctotal = $("#acctotal").val();
        var accdatedep = $("#accdatedep").val();
        $.ajax({
            type: 'POST',
            url: 'tenants/tenantmainclass.php',
            data: 'id=' + id + '&tid=' + tid + '&acctname=' + acctname + '&accpdcdate=' + accpdcdate + '&accbank=' + accbank + '&accreceiveby=' + accreceiveby + '&acccheckstat=' + acccheckstat + '&accstat=' + accstat + '&accamount=' + accamount + '&acccheckno=' + acccheckno + '&accdepository=' + accdepository + '&acctotal=' + acctotal + '&accdatedep=' + accdatedep + '&form=savepdctransaction',
            success: function(data){
                $(".postpdcreq").val("");
                tblpdc();
            }
        });
    }

    function printpdc(){
        var laman = $("#tblpdc tr").length;
        if(laman == 0){
            setTimeout(function(){
                showmodal("alert", "Sorry, No data found.", "", null, "", null, "0");
            }, 1000)
        }else{
            var toPrint = document.getElementById("divpdc2");
            var myheight = $(window).height()-40;
            var mywidth = $(window).width()-40;
            var popupWin = window.open("", "PDC", "height=" + myheight + ",width=" + mywidth + ",location=no,scrollbars=1,left=" + 20);
            popupWin.document.open();
            popupWin.document.write('<html><title>PDC Reports</title><link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" /><style>@media print{ table{ page-break-after:auto } tr{ page-break-inside:avoid; page-break-after:auto } td{ page-break-inside:avoid; page-break-after:auto } thead{ display:table-header-group } tfoot{ display:table-footer-group } }</style><body onload="window.print();">' );
            popupWin.document.write( toPrint.innerHTML);
            popupWin.document.write('</body></html>');
            popupWin.document.close();
        }
    }
    // PDC TAB END

    // CONTRACT START
    function tblcontract(){
        var tid = $("#Tid").text();
        var inqid = $("#inqid").val();
        $.ajax({
            type: 'POST',
            url: 'tenants/tenantmainclass.php',
            data: 'tenantid=' + tid + '&inquiryid=' + inqid + '&form=tblcontract',
            success: function(data){
                if(data != ""){
                    $("#tblcontract").html(data);
                }else{
                    $("#tblcontract").html("<tr><td colspan='4' style='text-align: center;'>No Data Found...</td></tr>");
                }
            }
        });
    }

    function tblcontractinfo(tid, type){
        $.ajax({
            type: 'POST',
            url: 'tenants/tenantmainclass.php',
            data:  'tenantid=' + tid + '&type=' + type + '&form=tblcontractinfo',
            success: function(data){
                var arr = data.split("|");
                $("#unitaddress").text(arr[4]);
                $("#tenant_ID").text(arr[3]);
                $("#storename").text(arr[0]);
                $("#address2").text(arr[6]);
                $("#authorizedsignatory").text(arr[2]);
                $("#contactnumbers").text(arr[11]);
                $("#natureofbusiness").text(arr[12]);
                $("#classification").text(arr[12]);
                $("#leaseunitfloor").text(arr[9]);
                $("#monthlyrent").text(arr[8]);
                $("#leaseperiod").text(arr[10]);
            }
        })
    }

    function printcontract(){
        var laman = $("#viewcontract tr").length;
        if(laman == 0){
            setTimeout(function(){
                showmodal("alert", "Sorry, No data found.", "", null, "", null, "0");
            }, 1000)
        }else{
            var toPrint = document.getElementById("viewcontract");
            var myheight = $(window).height()-40;
            var mywidth = $(window).width()-40;
            var popupWin = window.open("", "Contract", "height=" + myheight + ",width=" + mywidth + ",location=no,scrollbars=1,left=" + 20);
                popupWin.document.open();
                popupWin.document.write('<html><title>Contract</title><style>@media print{ table{ page-break-after:auto } tr{ page-break-inside:avoid; page-break-after:auto } td{ page-break-inside:avoid; page-break-after:auto } thead{ display:table-header-group } tfoot{ display:table-footer-group } }</style><body onload="window.print();">' );
                popupWin.document.write( toPrint.innerHTML);
                popupWin.document.write('</body></html>');
                popupWin.document.close();
        }
    }

    function fncPrintCustomContract(){
        var toPrint = document.getElementById("div_Contract");
        var myheight = $(window).height()-40;
        var mywidth = $(window).width()-40;
        var popupWin = window.open("", "Contract", "height=" + myheight + ",width=" + mywidth + ",location=no,scrollbars=1,left=" + 20);
            popupWin.document.open();
            popupWin.document.write('<html><title>Contract</title><style>@media print{ table{ page-break-after:auto } tr{ page-break-inside:avoid; page-break-after:auto } td{ page-break-inside:avoid; page-break-after:auto } thead{ display:table-header-group } tfoot{ display:table-footer-group } }</style><body onload="window.print();">' );
            popupWin.document.write( toPrint.innerHTML);
            popupWin.document.write('</body></html>');
            popupWin.document.close();
    }
    // CONTRACT END

    // MAINTENANCE START
    function tblmaintenance(){
        var tid = $("#Tid").text();
        var datefrom = $("#maintenanceDateFrom").val();
        var dateto = $("#maintenanceDateTo").val();
        $.ajax({
            type: 'POST',
            url: 'tenants/tenantmainclass.php',
            data: 'datefrom=' + datefrom + '&dateto=' + dateto + '&tenantid=' + tid + '&form=tblmaintenance',
            success:function(data){
                if(data != ""){
                    $("#tblmaintenance").html(data);
                }else{
                    $("#tblmaintenance").html("<tr><td colspan='5' style='text-align: center;'>No Data Found...</td></tr>");
                }
            }
        })
    }

    function printtblmaintenance(){
        var tenantid = $("#Tid").text();
        var datatefrom = $("#maintenanceDateFrom").val();
        var dateto = $("#maintenanceDateTo").val();
        $.ajax({
            type: 'POST',
            url: 'tenants/tenantmainclass.php',
            data: 'datefrom=' + datefrom + '&dateto=' + dateto + '&tenantid=' + tenantid + '&form=tblmaintenance2',
            success:function(data){
                $("#tblprintmaintenancehistory").html(data);
                if(data == 0){
                    setTimeout(function(){
                        showmodal("alert", "Sorry, No data found.", "", null, "", null, "0");
                    }, 1000)
                }else{
                    var toPrint = document.getElementById("printmaintenancehistory");
                    var myheight = $(window).height()-40;
                    var mywidth = $(window).width()-40;
                    var popupWin = window.open("", "Maintenance", "height=" + myheight + ",width=" + mywidth + ",location=no,scrollbars=1,left=" + 20);
                        popupWin.document.open();
                        popupWin.document.write('<html><title>Maintenance</title><link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" /><style>@media print{ table{ page-break-after:auto } tr{ page-break-inside:avoid; page-break-after:auto } td{ page-break-inside:avoid; page-break-after:auto } thead{ display:table-header-group } tfoot{ display:table-footer-group } }</style><body onload="window.print();">' );
                        popupWin.document.write( toPrint.innerHTML);
                        popupWin.document.write('</body></html>');
                        popupWin.document.close();
                }
            }
        })
    }
    // MAINTENANCE END

    // CONSTRUCTION BOND START
    function displayconbond(){
        var tid = $("#Tid").text();
        $.ajax({
            type: 'POST',
            url: 'tenants/tenantmainclass.php',
            data: 'tid=' + tid + '&form=displayconbond',
            success:function(data){
                if(data != ""){
                    $("#tblconbond").html(data);
                }else{
                    $("#tblconbond").html("<tr><td colspan='4' style='text-align: center;'>No Data Found...</td></tr>");
                }
            }
        })
    }

    function saveconbond(){
        setTimeout(function(){
            showmodal("confirm", "Save Construction Bond?", "saveconbond2", null, "", null, "1");
        }, 1000)
    }

    function saveconbond2(){
        var data = new FormData($('#posting_conbond')[0]);
        $.ajax({
            type:"POST",
            url:"tenants/uploadconbond.php",
            data: data,
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            success:function(data){
                var arr = data.split("|");
                if(arr[0] == "1"){
                    setTimeout(function(){
                        showmodal("alert", arr[1], "displayconbond", null, "", null, "0");
                    }, 1000)
                }else{
                    setTimeout(function(){
                        showmodal("alert", arr[1], "", null, "", null, "1");
                    }, 1000)
                }
            }
        });
    }
    // CONSTRUCTION BOND END

    // MEMO START
    function tbltenantmemolist(){
        var tid = $("#Tid").text();
        $.ajax({
            type: 'POST',
            url: 'tenants/tenantmainclass.php',
            data: 'tid=' + tid + '&form=tbltenantmemolist',
            success:function(data){
                if(data != ""){
                    $("#tbltenantmemolist").html(data);
                }else{
                    $("#tbltenantmemolist").html("<tr><td colspan='4' style='text-align: center;'>No Data Found...</td></tr>");
                }
            }
        })
    }
    // MEMO END

    // COMPLAINTS START
    function tblcomplaints(){
        var key = $("#txtSearchTPComplaints").val();
        var tenantid = $("#Tid").text();
        $.ajax({
            type: 'POST',
            url: 'tenants/tenantmainclass.php',
            data: 'key=' + key + '&tenantid=' + tenantid + '&form=tblcomplaints',
            success:function(data){
                if(data != ""){
                    $("#tblcomplaints").html(data);
                }else{
                    $("#tblcomplaints").html("<tr><td colspan='8' style='text-align: center;'>No Data Found...</td></tr>");
                }
                $("#mdl_NewTPComplaints").modal("hide");
            }
        })
    }

    function NewTPComplaints(){
        $("#mdl_NewTPComplaintCode").modal("hide");
        $.ajax({
            type: 'POST',
            url: 'tenants/tenantmainclass.php',
            data: 'form=loadComplaintCodes',
            success:function(data){
                $("#txtTPComplaints").html(data);
                $("#txtTPComplaints").val("");
                $("#txtTPDescription").val("");
                $("#txtTPAddComplaints").val("");
                $("#txtTPAddDescription").val("");
            }
        })
    }

    function ShowPreDescription(val){
        $.ajax({
            type: 'POST',
            url: 'tenants/tenantmainclass.php',
            data: 'ComplaintCode=' + val + '&form=ShowPreDescription',
            success:function(data){
                $("#txtTPDescription").val(data);
            }
        })
    }

    function AddTPComplaintCode(){
        $("#mdl_NewTPComplaintCode").modal("show");
    }

    function SaveNewComplaintCode(){
        var Code = $("#txtTPAddComplaints").val();
        var Description = $("#txtTPAddDescription").val();
        var PrioStat = "";
        $(".radPrioStat").each(function(){
            if($(this).is(":checked")){
                PrioStat = $(this).val();
            }
        })
        var count = 0;
        $(".newComplaintCodeReq").each(function(){
            if($(this).val() == ""){
                $(this).css("border-color","#f2a696");
                count++;
            }else{
                $(this).css("border-color","#D5D5D5");
            }
        })
        if(count == 0){
            if(PrioStat != ""){
                $.ajax({
                    type: 'POST',
                    url: 'tenants/tenantmainclass.php',
                    data: 'Code=' + Code + '&Description=' + Description + '&PrioStat=' + PrioStat + '&form=SaveNewComplaintCode',
                    success:function(data){
                        var arr = data.split("|");
                        if(arr[0] == 1){
                            setTimeout(function(){
                                showmodal("alert", arr[1], "NewTPComplaints", null, "", null, "0");
                            }, 500)
                        }else{
                            setTimeout(function(){
                                showmodal("alert", arr[1], "", null, "", null, "1");
                            }, 500)
                        }
                    }
                })
            }else{
                setTimeout(function(){
                    showmodal("alert", "Please select priority status.", "", null, "", null, "1");
                }, 500)
            }
        }else{
            setTimeout(function(){
                showmodal("alert", "Please fill all fields.", "", null, "", null, "1");
            }, 500)
        }
    }

    function SavenewTPComplaints(){
        var ComplaintCode = $("#txtTPComplaints").val();
        var ComplaintDesc = $("#txtTPDescription").val();
        var TenantID = $("#Tid").text();
        var count = 0;
        $(".newComplaintCodeReq2").each(function(){
            if($(this).val() == "" || $(this).val() == "undefined"){
                $(this).css("border-color","#f2a696");
                count++;
            }else{
                $(this).css("border-color","#D5D5D5");
            }
        })
        if(count == 0){
            $.ajax({
                type: 'POST',
                url: 'tenants/tenantmainclass.php',
                data: 'ComplaintCode=' + ComplaintCode + '&ComplaintDesc=' + ComplaintDesc + '&TenantID=' + TenantID + '&form=SavenewTPComplaints',
                success:function(data){
                    var arr = data.split("|");
                    if(arr[0] == 1){
                        setTimeout(function(){
                            showmodal("alert", arr[1], "tblcomplaints", null, "", null, "0");
                        }, 500)
                    }else{
                        setTimeout(function(){
                            showmodal("alert", arr[1], "", null, "", null, "1");
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

    function printtblcomplaints(){
        var tenantid = $("#Tid").text();
        var key = $("#txtSearchTPComplaints").val();

    }
    // COMPLAINTS END

    //TPS START
    function loadTPS(){
        var TenantID = $("#Tid").text();
        $(".chkFileLocat").prop("checked", false);
        $.ajax({
            type: 'POST',
            url: 'tenants/tenantmainclass.php',
            data: 'TenantID=' + TenantID + '&form=loadTPS',
            success: function(data){
                var arr = data.split("|");
                $("#txtSFTPUser").val(arr[0]);
                $("#txtSFTPPass").val(arr[1]);
                $(".chkFileLocat").each(function(){
                    if($(this).val() == arr[2]){
                        $(this).prop("checked", true);
                    }
                })
                $(".chkAccredStat").each(function(){
                    if($(this).val() == arr[3]){
                        $(this).prop("checked", true);
                    }
                })
                $("#Tusername").val(TenantID);
                $("#Tpassword").val(arr[4]);
                $("#txtSFTPMachine").val(arr[5]);
            }
        })
    }
    //TPS END

    function malltemplate(){
        var mallID = $("#mallidprint").val();
        $.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'mallID=' + mallID + '&form=getheaderprint',
            success:function(data){
                $(".template").html(data);
            }
        })
    }

    function closeinfo() {
        $('#tenantinfo').modal('hide');
        cancelpdctransaction();
        $(".thistab:first-child").children('a').click();
        $("#accdatedep").val("<?php echo date('m/d/Y'); ?>");
    }


    function loadinputTrap(){
        $('.upload_app_req').ace_file_input({
            no_file:'No File ...',
            btn_choose:'Choose',
            btn_change:'Change',
            droppable:false,
            onchange:null,
            thumbnail:false //| true | large
        });
    }

    function showlistofdocs(){
        var TenantID = $("#Tid").text();
        var InquiryID = $("#inqid").val();
        var ApplicationID = $("#appidreq").val();
        $.ajax({
            type: 'POST',
            url: 'tenants/tenantmainclass.php',
            data: '&ApplicationID=' + ApplicationID + '&InquiryID=' + InquiryID + '&TenantID=' + TenantID + '&form=showlistofdocs',
            success:function(data){
                $("#docname").html(data);
            }
        })
    }

    function viewpasswordoftenant(){
        $("#TpasswordIcon").each(function(){
            if($(this).hasClass("fa fa-eye")){
                $("#Tpassword").attr("type", "text");
                $(this).removeClass("fa fa-eye");
                $(this).addClass("fa fa-eye-slash");
            }else{
                $("#Tpassword").attr("type", "password");
                $(this).removeClass("fa fa-eye-slash");
                $(this).addClass("fa fa-eye");
            }
        })
    }

    function ChangeStatAccred(id){
        var AccredStat = 0;
        var TenantID = $("#Tid").text();
        if(id == "chkAccredStatYes"){
            AccredStat = 1;
        }else{
            AccredStat = 0;
        }
        $.ajax({
            type: 'POST',
            url: 'tenants/tenantmainclass.php',
            data: 'TenantID=' + TenantID + '&AccredStat=' + AccredStat + '&form=ChangeStatAccred',
            success:function(data){
                tbltenantlists();
            }
        })
    }

    function ChangeLocatAccred(id){
        var Location = 0;
        var TenantID = $("#Tid").text();
        if(id == "chkFileLocatLocal"){
            Location = "Local";
        }else{
            Location = "SFTP";
        }
        $.ajax({
            type: 'POST',
            url: 'tenants/tenantmainclass.php',
            data: 'TenantID=' + TenantID + '&Location=' + Location + '&form=ChangeLocatAccred',
            success:function(data){
                // tbltenantlists();
            }
        })
    }

    function fncSaveNEdit(){
        var btnlbl = $("#btnSaveNEdit").text();
        if(btnlbl == 'Edit'){
            $("#btnSaveNEdit").text('Save');
            $("#btnCancel").css("display", "block");
            $(".txtSFTPCred").removeAttr("readonly");
        }else if(btnlbl == 'Save'){
            $("#btnSaveNEdit").text('Edit');
            $("#btnCancel").css("display", "none");
            $(".txtSFTPCred").attr("readonly", "readonly");
            var User = $("#txtSFTPUser").val();
            var Pass = $("#txtSFTPPass").val();
            var withPOS = $("#txtSFTPMachine").val();
            var TenantID = $("#Tid").text();
            $.ajax({
                type: 'POST',
                url: 'tenants/tenantmainclass.php',
                data: 'User=' + encodeURIComponent(User) + '&Pass=' + encodeURIComponent(Pass) + '&TenantID=' + TenantID + '&withPOS=' + encodeURIComponent(withPOS) + '&form=fncSaveNEdit',
                success:function(data){
                    
                }
            })
        }
    }

    function fncCancelEditNSave(){
        $("#btnSaveNEdit").text('Edit');
        $("#btnCancel").css("display", "none");
        $(".txtSFTPCred").attr("readonly", "readonly");
    }

    function viewpasswordofSFTP(){
        $("#SFTPpasswordIcon").each(function(){
            if($(this).hasClass("fa fa-eye")){
                $("#txtSFTPPass").attr("type", "text");
                $(this).removeClass("fa fa-eye");
                $(this).addClass("fa fa-eye-slash");
            }else{
                $("#txtSFTPPass").attr("type", "password");
                $(this).removeClass("fa fa-eye-slash");
                $(this).addClass("fa fa-eye");
            }
        })
    }

    function showPermitList(){
        var InquiryID = $("#inqid").val();
        var TenantID = $("#Tid").text();
        $.ajax({
            type: 'POST',
            url: 'tenants/tenantmainclass.php',
            data: 'InquiryID=' + InquiryID + '&TenantID=' + TenantID + '&form=showPermitList',
            success:function(data){
                $("#permitname").html(data);
            }
        })
    }

    function savepermit(){
        var permitname = $("#permitname").val();
        var permitfile = $("#permit_upload")[0].files.length;
        var permitexp = $("#permit_expiration").val();
        if(permitname == '' || permitname == null){
            setTimeout(function(){
                showmodal("alert", "Please select the type of permit you want to upload.", "", null, "", null, "1");
            }, 1000)
        }else{
            if(permitfile == 1){
                if(permitexp == ""){
                    setTimeout(function(){
                        showmodal("alert", "Please select the expiration date of your permit.", "", null, "", null, "1");
                    }, 1000)
                }else{
                    setTimeout(function(){
                        showmodal("confirm", "Save document?", "savepermit2", null, "", null, "1");
                    }, 1000)
                }
                
            }else{
                setTimeout(function(){
                    showmodal("alert", "Please select a file you want to upload.", "", null, "", null, "1");
                }, 1000)
            }
        }
    }

    function savepermit2(){
        var data = new FormData($('#posting_permit')[0]);
        $.ajax({
            type:"POST",
            url:"tenants/uploadpermit.php",
            data: data,
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            success:function(data){
                setTimeout(function(){
                    showmodal("alert", data, "tblpermits", null, "", null, "0");
                }, 1000)
            }
        });
    }

    function tblpermits(){
        var InquiryID = $("#inqid").val();
        $.ajax({
            type: 'POST',
            url: 'tenants/tenantmainclass.php',
            data: 'InquiryID=' + InquiryID + '&form=tblpermits',
            success:function(data){
                $("#tblpermits").html(data);
                $("#PermitDescription").val("");
                $("#permit_upload").val("");
            }
        })
    }

    function getheaderprint(mallid,classN,condition){
        var cond = JSON.parse( condition ).join('&');
        var toprint = "";
        $.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'mallID=' + mallid + '&form=getheaderprint',
            success:function(data){
                $("#printable_divtemplate").html(data);
                
            }, complete: function(){
                $.ajax({
                    type: 'POST',
                    url: 'mainclass.php',
                    data: cond + '&form='+classN,
                    success:function(data){
                         $("#printable_div_content").html(data);
                        toprint = $("#printable_div").html();   
                        var myheight = $(window).height()-40;
                        var mywidth = $(window).width()-40;
                        var popupWin = window.open("", "_blank", "height=" + myheight + ",width=" + mywidth + ",location=no,scrollbars=1,left=" + 20);
                        popupWin.document.open();
                        popupWin.document.write("<html><head><link rel='stylesheet' href='assets/css/bootstrap.min.css' /><title></title></head><body onload='window.print();'>" + toprint + "</body></html>");
                        popupWin.document.close();
                    }
                })
            }
        })
    }

    function fncCloseNewTenant(){
        tbltenantlists();
        $("#mdlAddNewInquiry").modal("hide");
    }

    function fncCloseNewContract(){
        tblcontract();
        tbltenantlists();
        $("#mdlAddNewInquiry").modal("hide");
    }

    function printtenantinfo(TenantID, inqID, companynem, conperson, biltype, startdet, enddate, escalate, yrstart, yrbasis, mallnem, wing, flr, unittype, unitarea, classi, dept, cate, prcsqm, unitprc){
        // alert(TenantID);
        $.ajax({
            type: 'POST',
            url: 'tenants/tenantmainclass.php',
            data: 'TenantID=' + TenantID + '&inqID=' + inqID + '&companynem=' +companynem+ '&conperson=' +conperson+ '&biltype=' +biltype+ '&startdet=' +startdet+ '&enddate=' + enddate + '&escalate=' + escalate + '&yrstart=' + yrstart + '&yrbasis=' + yrbasis + '&mallnem=' + mallnem + '&wing=' + wing + '&flr=' + flr + '&unittype=' + unittype + '&unitarea=' + unitarea + '&classi=' + classi + '&dept=' + dept + '&cate=' + cate + '&prcsqm=' + prcsqm +'&unitprc=' + unitprc + '&form=printtenantinfo', 
            success:function(data){
                var arr = data.split("|");
                // alert(data);
                $("#tenantid2").text(TenantID);
                $("#merchcode").text(arr[2]);
                $("#companynem").text(arr[3]);
                $("#conperson").text(arr[4]);
                $("#biltype").text(arr[5]);
                $("#startdet").text(arr[6]);
                $("#enddate").text(arr[7]);
                $("#escalate").text(arr[24]);
                $("#yrstart").text(arr[25]);
                $("#yrbasis").text(arr[26]);
                $("#mallnem").text(arr[8]);
                $("#wing").text(arr[9]);
               
                $("#flr").text(arr[10]);
           
                $("#unittype").text(arr[12]);
                
                $("#unitarea").text(arr[12]);

                $("#classi").text(arr[13]);
                $("#dept").text(arr[14]);
                $("#cate").text(arr[15])
                
                $("#prcsqm").text(arr[16]);
                $("#unitprc").text(arr[17]);
                 // $("#printable_div_content").html(data);
                toprint = $("#printtenantinfo").html();   
                var myheight = $(window).height()-40;
                var mywidth = $(window).width()-40;
                var popupWin = window.open("", "_blank", "height=" + myheight + ",width=" + mywidth + ",location=no,scrollbars=1,left=" + 20);
                popupWin.document.open();
                popupWin.document.write("<html><head><link rel='stylesheet' href='assets/css/bootstrap.min.css' /><title></title></head><body onload='setTimeout(function(){window.print();},);'>" + toprint + "</body></html>");
                popupWin.document.close();
            }
        });
    }

    //Ammendment
    function fncContractAmendmentList(TenantID, InquiryID, ApplicationID, CompanyID, TradeID){
        $("#mdlAmendment").modal("show");
        $.ajax({
            type: 'POST',
            url: 'tenants/tenantmainclass.php',
            data: 'TenantID=' + TenantID + '&InquiryID=' + InquiryID + '&ApplicationID=' + ApplicationID + '&CompanyID=' + CompanyID + '&TradeID=' + TradeID + '&form=fncContractAmendmentList',
            success: function(data){
                $("#tbodyAmendmentList").html(data);
            }
        })
    }
</script>
