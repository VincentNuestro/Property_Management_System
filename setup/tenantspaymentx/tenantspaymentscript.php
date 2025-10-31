<script type="text/javascript">
    $(function(){
        tblstorename();
        loadpaymentstype();
        $(".fixTable").tableHeadFixer();
        $(".divinfo .readx").prop("readonly", true);
        $("#srchhistory").keyup(function(e){
            var x = event.keyCode;
            if(x == 13){ 
                tblstorename(); 
            }else if(x == '8'){
                if($('#srchhistory').val() == ""){
                    tblstorename();
                }
            }
        });
    });

    setTimeout(function(){
        tblstorename();
        $(".fixTable").tableHeadFixer();
        // $(".divinfo input").prop("disabled", true);
    }, 3000);

    function tblstorename() {
        var srchhistory = $("#srchhistory").val();
        $.ajax({
            type: 'POST',
           url: 'setup/tenantspaymentx/tenantpaymentclass.php',
            data: 'srchhistory=' + srchhistory + '&form=tblstorename',
            beforeSend : function() {
                $('#indexloadingscreen').addClass('myspinner');
            },
            success: function(data){
                $('#indexloadingscreen').removeClass('myspinner');
                if(data != ""){
                    $("#tblstorename").html(data);
                }else{
                    $("#tblstorename").html("<tr><td colspan='9' style='text-align: center;'>No Data Found...</td></tr>");
                }
                clicking();
            }
        });
    }

    function clicking(){
        $("#tblstorename tr").each(function(){
            $(this).click(function(){
                $("#tblstorename tr").removeClass("activated");
                $(this).addClass("activated");
            });
        });
    }

    function  thiscompany(mallname, compid, compname, storename, tid, fname, mname, lname, tradepic,mallid) {
        $("#mallname").val(mallname);
        $("#compid").val(compid);
        $("#compname").val(compname);
        $("#storename").val(storename);
        $("#tenantid").val(tid);
        $("#fname").val(fname);
        $("#lname").val(lname);
        $("#mname").val(mname);
        $("#historylogo").attr("src", tradepic);

        $(".mallname").text(mallname);
        $(".compid").text(compid);
        $(".compname").text(compname);
        $(".storename").text(storename);
        $(".tenantid").text(tid);
        $("#printlogo").attr("src", tradepic);
        $("#mallid").val(mallid);
        loadpaymentsdetails(mallid,tid);
       
    }

  

   


    /* Myadded */

    function loadpaymentstype(){
        $.ajax({
            type: 'POST',
            url: 'setup/tenantspaymentx/tenantpaymentclass.php',
            data: 'form=loadpaymentstype',
            beforeSend : function() {
               
            },
            success: function(data){
                 $("#txttpaymenttype").html(data);
            }
        });
    }

    function gettotalamount(valx){
        alert(valx.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
    }

    function addpayments(){
        var count = 0;
        $(".divinfo").find(".required").each(function(){
            var eto = $(this);
            var eto2 = eto.find(".form-control");
            if ( eto2.val() == "" ) {
                count = 1;
                eto.addClass("has-error");

                eto2.click(function(){
                    eto.removeClass("has-error");
                })
            }
        });

        if(count==0){
            $("#btnaddpayments").prop('disabled','disabled');
            setTimeout(function(){
                showmodal("confirm", "Are you sure you want to continue? Click \"Yes\" to proceed.", "addpayments2", "", "", null, "0");
            }, 100)
        }else{
            $("#btnaddpayments").prop('disabled',false);
        }
    }

    function addpayments2(){
        var txttpaymentdate = $("#txttpaymentdate").val();
        var txttpaymenttype = $("#txttpaymenttype").val();
        var txttpaymentreference = $("#txttpaymentreference").val();
        var tenantid = $("#tenantid").val();
        var storename = $("#storename").val();
        var compname = $("#compname").val();
        var mallid = $("#mallid").val();
        var mallname = $("#mallname").val();
        var txttpaymentorno = $("#txttpaymentorno").val();
        var txttpaymentamount = $("#txttpaymentamount").val();
        $.ajax({
            type: 'POST',
            url: 'setup/tenantspaymentx/tenantpaymentclass.php',
            data: 'txttpaymentdate=' + txttpaymentdate + '&txttpaymenttype=' + txttpaymenttype + '&txttpaymentreference=' + encodeURIComponent(txttpaymentreference) + '&tenantid=' + tenantid + '&storename=' + encodeURIComponent(storename) + '&compname=' + encodeURIComponent(compname) + '&mallid=' + mallid + '&mallname=' + mallname + '&txttpaymentorno=' + txttpaymentorno + '&txttpaymentamount=' + txttpaymentamount.replace(/,/g, "") + '&form=addpayments2',
            beforeSend : function() {
               
            },
            success: function(data){
                loadpaymentsdetails(mallid,tenantid);
                $("#btnaddpayments").prop('disabled',false);
                
            }
        });
    }

    function loadpaymentsdetails(mallid,tenantid){
        clearpayments();
        $.ajax({
            type: 'POST',
            url: 'setup/tenantspaymentx/tenantpaymentclass.php',
            data: 'mallid=' + mallid + '&tenantid=' + tenantid + '&form=loadpaymentsdetails',
            beforeSend : function() {},
            success: function(data){
                if(data==""){
                    $("#tbltenatspayment").html("<tr><td colspan='8' style='text-align:center'>No Data Found.</td></tr>");
                }else{
                    $("#tbltenatspayment").html(data);
                }
            }
        });
    }

    function clearpayments(){
        $("#txttpaymentdate").val('');
        $("#txttpaymenttype").val('');
        $("#txttpaymentreference").val('');
        $("#txttpaymentorno").val('');
        $("#txttpaymentamount").val('');
    }

    function deletepayments(ids){
        setTimeout(function(){
            showmodal("confirm", "Are you sure you want to delete this record? Click \"Yes\" to proceed.", "deletepayments2", ids+"|", "", null, "0");
        }, 100)
    }

    function deletepayments2(ids){
        var tenantid = $("#tenantid").val();
        var mallid = $("#mallid").val();
        $.ajax({
            type: 'POST',
            url: 'setup/tenantspaymentx/tenantpaymentclass.php',
            data: 'ids=' + ids + '&form=deletepayments2',
            beforeSend : function() {
               
            },
            success: function(data){
                if(data=='1'){
                    loadpaymentsdetails(mallid,tenantid);
                    $("#btnaddpayments").prop('disabled',false);
                }
                
                
            }
        });
    }

    function thisval(vals){
        $("#txttpaymentamount").val(number_format(parseFloat(vals), 2, '.', ','));
    }

    function addCommas(nStr)
    {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        x3 = x1 + x2;
        return x3;
    }

    number_format = function (number, decimals, dec_point, thousands_sep) {
        number = number.toFixed(decimals);

        var nstr = number.toString();
        nstr += '';
        x = nstr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? dec_point + x[1] : '';
        var rgx = /(\d+)(\d{3})/;

        while (rgx.test(x1))
            x1 = x1.replace(rgx, '$1' + thousands_sep + '$2');

        return x1 + x2;
    }
</script>
