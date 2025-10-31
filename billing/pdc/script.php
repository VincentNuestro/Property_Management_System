<script type="text/javascript">
    $(function(){
        $(".fixTable").tableHeadFixer(); 
        $("#txt_userpagepdc").val("1");
        $(".date-picker").datepicker({
            autoHide: true,
            format: 'mm/dd/yyyy',
            todayHighlight: true
        });
        $('[data-rel=tooltip]').tooltip();
        $('[data-rel=popover]').popover({html:true});
        tbllistofpdc();
        $("#asdasdasd").keyup(function(e){
            var x = event.keyCode;
            if(x == 13){ 
                $("#txt_userpagepdc").val("1");
                tbllistofpdc(); 
            }else if ( x == '8' ){
                if($('#asdasdasd').val() == ""){
                    $("#txt_userpagepdc").val("1");
                    tbllistofpdc();
                }
            }
        });
    })

    function printkomamamo2(){
        var dateFrom = $("#dateFrom").val();
        var dateTo = $("#dateTo").val();
        var mallid = $("#printbymec2").val();
        $.ajax({
            type: 'POST',
            url: 'billing/pdc/class.php',
            data: 'dateFrom=' + dateFrom + '&dateTo=' + dateTo + '&form=printkomamamo',
            success:function(data){
                var arr = data.split("|");
                $("#dateFrom2").text(arr[1]);
                $("#dateTo2").text(arr[2]);
                $("#contentngmamamo").html(arr[0]);
                if(mallid != "" && mallid != null){
                    $.ajax({
                        type: 'POST',
                        url: 'mainclass.php',
                        data: 'mallID='+ mallid + '&form=getheaderprint',
                        success:function(data){
                            $("#template5").html(data);
                            var toPrint = document.getElementById("div_form_printngmamamo");
                            var myheight = $(window).height()-40;
                            var mywidth = $(window).width()-40;
                            var popupWin = window.open("", "_blank", "height=" + myheight + ",width=" + mywidth + ",location=no,scrollbars=1,left=" + 20);
                            popupWin.document.open();
                            popupWin.document.write('<html><link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" /><header style="font-size: 16px; font-weight: 700;"></header><br><body onload="window.print();">' );
                            popupWin.document.write( toPrint.innerHTML);
                            popupWin.document.write('</body></html>');
                            popupWin.document.close();
                        }
                    });
                }else{
                    setTimeout(function(){
                        showmodal("alert", "Please select mall.", "", null, "", null, "1");
                    }, 1000)
                }
            }
        });
    }

    function showprintbyme2(){
        $.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'form=tblref_mall',
            success:function(data){
                $("#printbymec2").html(data);
            }
        })
    }

    function pdcdate(){
        var eto = $("#pdcdate");
        if(eto.is(":checked")){
            $("#depdate").prop("checked", false);
            $("#div_chkdepdate").css("background-color", "#f5f5f0");
            $("#div_chkpdcdate").css("background-color", "white");
            $(".div_apppdc").prop("disabled", false);
            $(".div_appdep").prop("disabled", true);
        }else{
            $("#pdcdate").prop("checked", true);
        }
    }

    function depdate(){
        var eto = $("#depdate");
        if(eto.is(":checked")){
            $("#pdcdate").prop("checked", false);
            $("#div_chkpdcdate").css("background-color", "#f5f5f0");
            $("#div_chkdepdate").css("background-color", "white");
            $(".div_appdep").prop("disabled", false);
            $(".div_apppdc").prop("disabled", true);
        }else{
            $("#depdate").prop("checked",true);
        }
    }

    function LoadPDCFilter(module){
        $.ajax({
            type: 'POST',
            url: 'filter/class.php',
            data: 'module=' + module + '&form=loadFilters',
            success: function(data){
                var arr = data.split("#");
                var arr2 = arr[0].split("|");
                var arr3 = arr[1].split("|");
                var arr4 = arr[2].split("@");
                var arr5 = arr4[0].split("|");
                var arr6 = arr4[1].split("|");
                for(var i=0; i<=arr2.length; i++){
                    $('input:checkbox[id="filter_'+arr2[i]+'"][value="'+arr2[i]+'"]').attr('checked', 'checked');
                }
                $("#txtstartpdc").val(arr3[0]);
                $("#txtendpdc").val(arr3[1]);
                $("#depstartpdc").val(arr3[2]);
                $("#dependpdc").val(arr3[3]);
                for(var i=0; i<=arr5.length-1; i++){
                    $('input:checkbox[id="filter_'+arr5[i]+'"][value="'+arr5[i]+'"]').attr('checked', 'checked');
                }    
                for(var i=0; i<=arr6.length-1; i++){
                    $('input:checkbox[id="filter_'+arr6[i]+'"][value="'+arr6[i]+'"]').attr('checked', 'checked');
                }  
                if(arr[3] == "pdcdate"){
                    $("#pdcdate").prop("checked", true);
                    pdcdate();
                }else{
                    $("#depdate").prop("checked", true);
                    depdate();
                }
            }
        })
    }

    function savePDCFilter(){
        var Date1 = $("#txtstartpdc").val();
        var Date2 = $("#txtendpdc").val();
        var Date3 = $("#depstartpdc").val();
        var Date4 = $("#dependpdc").val();
        var module = "PDCList";
        var checked = "";
        $('input:checkbox[name="form-field-checkboxpdc"]').each(function(){
            if($(this).is(":checked")){
                var value = $(this).attr("value");   
                checked += value + "|";
            }
        })
        var checked2 = "";
        $('input:checkbox[name="form-field-checkboxpdc"]').each(function(){
            var value2 = $(this).attr("value");
            checked2 += value2 + "|";                           
        }) 
        var checked31 = "";
        $('input:checkbox[name="form-field-checkboxdep"]').each(function(){
            if($(this).is(":checked")){
                var value31 = $(this).attr("value"); 
                checked31 += value31 + "|";  
            }
        })
        var checked41 = "";
        $('input:checkbox[name="form-field-checkboxcheck"]').each(function(){
            if($(this).is(":checked")){
                var value41 = $(this).attr("value");
                checked41 += value41 + "|";
            }
        }) 
        var checked3 = checked31+"@"+checked41;
        if($("#pdcdate").is(":checked")){ var xcheck = "pdcdate"; }
        if($("#depdate").is(":checked")){ var xcheck = "depdate"; } 
        $.ajax({
            type: 'POST',
            url: 'filter/class.php',
            data: 'module=' + module +  '&checked=' + checked +  '&checked2=' + checked2 +  '&checked3=' + checked3 + '&Date1=' + Date1 + '&Date2=' + Date2 + '&Date3=' +Date3+ '&Date4=' +Date4+ '&xcheck=' + xcheck + '&form=saveFilters',
            success: function(data){
                $("#LINK_PDC_filter").click();
                tbllistofpdc();
            }
        })
    }

    function tbllistofpdc(){
        var dateFrom = $("#pdcdateFrom").val();
        var dateTo = $("#pdcdateTo").val();
        var page = $("#txt_userpagepdc").val();
        var search = $('#asdasdasd').val();
        $.ajax({
            type: 'POST',
            url: 'billing/pdc/class.php',
            data: 'dateFrom=' + dateFrom + '&dateTo=' + dateTo + '&page=' + page + '&search='+ search +'&form=tbllistofpdc',
            beforeSend : function() {
                $('#indexloadingscreen').addClass('myspinner');
            },
            success: function(data){
                $('#indexloadingscreen').removeClass('myspinner');
                if(data != ""){
                    $("#tbllistofpdc").html(data);
                }else{
                    $("#tbllistofpdc").html("<tr><td colspan='11' style='text-align: center;'>No Data Found...</td></tr>");
                }
                loadentriespdc();
                loadpagespdc();
            }
        });
    }

    function loadentriespdc(){
        var search = $('#asdasdasd').val();
        var page = $("#txt_userpagepdc").val();
        $.ajax({
            type: 'POST',
            url: 'billing/pdc/class.php',
            data: 'search=' + search + '&page=' + page + '&form=loadentriespdc',
            success: function(data){
                if(data == ""){
                    $("#txtbillingentriespdc").text("");
                }else{
                    $("#txtbillingentriespdc").text(data);
                }
            }
        });
    }

    function loadpagespdc(){
        var search = $('#asdasdasd').val();
        var page = $("#txt_userpagepdc").val();
        $.ajax({
            type: 'POST',
            url: 'billing/pdc/class.php',
            data: 'search=' + search + '&page=' + page + '&form=loadpagespdc',
            success: function(data){
                $("#ulpaginationlistofpdc").html(data);
            }
        });
    }

    function paginationpdc(page, pagenums){
        $(".pgnumpdc").removeClass("active");
        var value = "#" + pagenums;
        $("#pgpdc" + pagenums).addClass("active");
        $("#txt_userpagepdc").val(page);
        tbllistofpdc();
    }

    function editfield(checkno){
        $("#edit"+checkno).css("display", "none");
        $("#confirm"+checkno).css("display", "block");
        $("#cancel"+checkno).css("display", "block");
        $('#tddepositorystat'+checkno).on('change',function(){
            if($("#tddepositorystat"+checkno).val()==='Deposited'){
                $("#tdcheckstat"+checkno).val("Cleared");
            }else{
    
            }
        });
        $.ajax({
            type: 'POST',
            url: 'billing/pdc/class.php',
            data: 'checkno=' + checkno + '&form=editfield',
            success:function(data){
                var arr = data.split("|");
                $("#tdcheckstat"+checkno).html(arr[0]);
                $("#tdamount"+checkno).html(arr[1]);
                $("#tddepositorystat"+checkno).html(arr[2]);
                $("#tddepository"+checkno).html(arr[3]);
                $("#tdreceivedby"+checkno).html(arr[4]);
                $("#tddatedep"+checkno).html(arr[5]);
            }
        });
    }

    function canceledit(checkno){
        $("#edit"+checkno).css("display", "block");
        $("#confirm"+checkno).css("display", "none");
        $("#cancel"+checkno).css("display", "none");
        $.ajax({
            type: 'POST',
            url: 'billing/pdc/class.php',
            data: 'checkno=' + checkno + '&form=cancelfield',
            success:function(data){
                var arr = data.split("|");
                $("#tdamount"+checkno).html(arr[0]);
                $("#tddepositorystat"+checkno).html(arr[1]);
                $("#tdcheckstat"+checkno).html(arr[2]);
                $("#tddepository"+checkno).html(arr[3]);
                $("#tdreceivedby"+checkno).html(arr[4]);
                $("#tddatedep"+checkno).html(arr[5]);
            }
        })
    }

    function saveeditedpdc(checkno){
        var amount = $("#amount"+checkno).val();
        var depositorystat = $("#depositorystat"+checkno).val();
        var checkstat = $("#checkstat"+checkno).val();
        var depository = $('#depository'+checkno).val();
        var received = $('#received'+checkno).val();
        var datedep = $('#date'+checkno).val();
        if(amount == "" || depository == "" || received == ""){
            showmodal("alert", "Please fill all fields.", "", null, "", null, "1");
        }else{
            $.ajax({
                type: 'POST',
                url: 'billing/pdc/class.php',
                data: '&checkno=' + checkno + '&amount=' + amount + '&depositorystat=' + depositorystat + '&checkstat=' + checkstat + '&depository='+ depository+'&datedep='+    datedep+'&received='+received+'&form=saveeditedpdc',
                success:function(data){
                $("#edit"+checkno).css("display", "block");
                $("#confirm"+checkno).css("display", "none");
                $("#cancel"+checkno).css("display", "none");
                var arr = data.split("|");
                $("#tdamount"+checkno).html(arr[0]);
                $("#tddepositorystat"+checkno).html(arr[1]);
                $("#tdcheckstat"+checkno).html(arr[2]);
                $("#tddepository"+checkno).html(arr[3]);
                $("#tdreceivedby"+checkno).html(arr[4]);
                $("#tddatedep"+checkno).html(arr[5]);
                }
          })
        }
    }
</script>