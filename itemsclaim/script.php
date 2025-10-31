<script type="text/javascript">
    $(function(){
        $(".fixTable").tableHeadFixer();
        $('[data-rel=tooltip]').tooltip();
        $('[data-rel=popover]').popover({html:true});
        $("#txtItemListPage").val("1");
        showdepositlist();
        $("#txtItemListKey").keyup(function(e){
            var x = event.keyCode;
            if(x == 13){ 
                $("#txtItemListPage").val("1");
                showdepositlist(); 
            }else if(x == '8'){
                if($('#txtItemListKey').val() == ""){
                    $("#txtItemListPage").val("1");
                    showdepositlist();
                }
            }
        });

        $(function(){
            $('.btnsortdash-baggagelogs').click(function(){
                if($(this).hasClass("fa-sort-up")){
                    $(this).addClass("fa-sort-down").removeClass("fa-sort-up");
                    $("#BaggageLogsSortType").val("ASC");
                    $("#BaggageLogsSortBy").val(this.id);
                    showdepositlist();
                }
                else if($(this).hasClass("fa-sort-down")){
                    $(this).addClass("fa-sort-up").removeClass("fa-sort-down");
                    $("#BaggageLogsSortType").val("DESC");
                    $("#BaggageLogsSortBy").val(this.id);
                    showdepositlist();
                }else if($(this).hasClass("fa-sort")){
                    if($("#BaggageLogsSortType").val() == "ASC"){
                        $(this).addClass("fa-sort-up").removeClass("fa-sort-down");
                        $("#BaggageLogsSortType").val("DESC");
                        $("#BaggageLogsSortBy").val(this.id);
                        showdepositlist();
                    }else{
                        $(this).addClass("fa-sort-down").removeClass("fa-sort-up");
                        $("#BaggageLogsSortType").val("ASC");
                        $("#BaggageLogsSortBy").val(this.id);
                        showdepositlist();
                    }
                }
            });
        });
    })

    function openmodal_deposititem(){
        $("#modal_deposititem").modal("show");
        $("#modal_deposititem :input").val("");
        showdepositlist();
    }

    function closemodal_deposititem(){
        $("#modal_deposititem").modal("hide");
        $("#modal_deposititem :input").val("");
        $(".deposit_required").css("border-color","#D5D5D5");
        showdepositlist();
    }

    function savedeposititem(){
        var CardID = $("#txtCardID").val();
        var Quantity = $("#txtQuantity").val();
        var Name = $("#txtNames").val();
        var Description = $("#txtItemDescription").val();
        var Notes = $("#txtNotes").val();
        var count = 0;
        $(".deposit_required").each(function(){
            if($(this).val() == ""){
                count++;
                $(this).css("border-color","#f2a696");
            }else{
                $(this).css("border-color","#D5D5D5");
            }
        })
        if(count == 0){
            $.ajax({
                type: 'POST',
                url: 'itemsclaim/class.php',
                data: 'CardID=' + CardID + '&Quantity=' + Quantity + '&Name=' + Name + '&Description=' + Description + '&Notes=' + Notes + '  &form=savedeposititem',
                beforeSend : function(){
                    $("#depositloading").addClass('myspinner');
                },
                success:function(data){
                    $("#depositloading").removeClass('myspinner');
                    var arr = data.split("|");
                    if(arr[0] == "1"){
                        setTimeout(function(){
                            showmodal("alert", arr[1], "closemodal_deposititem", null, "", null, "0");
                        }, 100)
                    }else{
                        setTimeout(function(){
                          showmodal("alert", arr[1], "", null, "", null, "0");
                        }, 100)
                    }
                }
            })
        }else{
            setTimeout(function(){
                showmodal("alert", "Please fill all fields.", "", null, "", null, "0");
            }, 100)
        }
    }

    function showdepositlist(){
        var BaggageLogsSortBy = $('#BaggageLogsSortBy').val();
        var BaggageLogsSortType = $('#BaggageLogsSortType').val();
        var key = $("#txtItemListKey").val();
        var page = $("#txtItemListPage").val();
        $.ajax({
            type: 'POST',
            url: 'itemsclaim/class.php',
            data: 'page=' + page + '&key=' + key + '&BaggageLogsSortBy=' + BaggageLogsSortBy + '&BaggageLogsSortType=' + BaggageLogsSortType + '&form=showdepositlist',
            beforeSend : function() {
                $('#indexloadingscreen').addClass('myspinner');
            },
            success: function(data){
                $('#indexloadingscreen').removeClass('myspinner');
                if(data.trim() != ""){
                    $("#tbldepositlist").html(data);
                }else{
                    $("#tbldepositlist").html("<tr><td colspan='9' style='text-align: center;'>No Data Found...</td></tr>");
                }
                loaditemlistentries();
                loaditemlistpagination();
            }
        })
    }

    function loaditemlistentries(){
        var page = $("#txtItemListPage").val();
        var key = $("#txtItemListKey").val();
        $.ajax({
            type: 'POST',
            url: 'itemsclaim/class.php',
            data: 'key=' + key + '&page=' + page + '&form=loaditemlistentries',
            success: function(data){
                if(data == ""){
                    $("#txtItemListEntries").text("");
                }else{
                    $("#txtItemListEntries").text(data);
                }
            }
        })
    }

    function loaditemlistpagination(){
        var page = $("#txtItemListPage").val();
        var key = $("#txtItemListKey").val();
        $.ajax({
            type: 'POST',
            url: 'itemsclaim/class.php',
            data: 'key=' + key + '&page=' + page + '&form=loaditemlistpagination',
            success: function(data){
                $("#ulPaginationItemList").html(data);
            }
        })
    }

    function paginationitemlist(page, pagenums){
        $(".pgnumitemlist").removeClass("active");
        $("#pgitemlist" + pagenums).addClass("active");
        $("#txtItemListPage").val(page);
        showdepositlist();
    }

    function checkfirstdate(){
        var eto = $("#chkdepositcheck");
        if(eto.is(":checked")){
            $("#chkclaimcheck").prop("checked", false);
            $("#div_claimed").css("background-color", "#f5f5f0");
            $("#div_deposited").css("background-color", "white");
            $(".div_depo").prop("disabled", false);
            $(".div_claim").prop("disabled", true);
        }else{
            $("#chkdepositcheck").prop("checked", true);
        }
    }

    function checksecdate(){
        var eto = $("#chkclaimcheck");
        if(eto.is(":checked")){
            $("#chkdepositcheck").prop("checked", false);
            $("#div_deposited").css("background-color", "#f5f5f0");
            $("#div_claimed").css("background-color", "white");
            $(".div_claim").prop("disabled", false);
            $(".div_depo").prop("disabled", true);
        }else{
            $("#chkclaimcheck").prop("checked", true);
        }
    }

    function checkfirstdate2(){
        var eto = $("#chkdepositcheck2");
        if(eto.is(":checked")){
            $("#chkclaimcheck2").prop("checked", false);
            $("#div_claimed2").css("background-color", "#f5f5f0");
            $("#div_deposited2").css("background-color", "white");
            $(".div_depo2").prop("disabled", false);
            $(".div_claim2").prop("disabled", true);
        }else{
            $("#chkdepositcheck2").prop("checked", true);
        }
    }

    function checksecdate2(){
        var eto = $("#chkclaimcheck2");
        if(eto.is(":checked")){
            $("#chkdepositcheck2").prop("checked", false);
            $("#div_deposited2").css("background-color", "#f5f5f0");
            $("#div_claimed2").css("background-color", "white");
            $(".div_claim2").prop("disabled", false);
            $(".div_depo2").prop("disabled", true);
        }else{
            $("#chkclaimcheck2").prop("checked", true);
        }
    }

    function saveBaggageLogsFilter(){
        var Date1 = $("#depositstart").val();
        var Date2 = $("#depositend").val();
        var Date3 = $("#claimstart").val();
        var Date4 = $("#claimend").val();
        var module = "BaggageLogs";
        var checked = "";
        $('input:checkbox[name="form-field-checkboxselect"]').each(function(){
            if($(this).is(":checked")){
                var value = $(this).attr("value");
                checked += value + "|";
            }
        })
        var checked2 = "";
        $('input:checkbox[name="form-field-checkboxselect"]').each(function(){
            var value2 = $(this).attr("value");
            checked2 += value2 + "|";
        }) 
        var checked3 = "";
        $('input:checkbox[name="form-field-checkboxstat"]').each(function(){
            if($(this).is(":checked")){
                var value3 = $(this).attr("value");
                checked3 += value3 + "|";
            }
        })     
        if($("#chkdepositcheck").is(":checked")){ var xcheck = "filterdatebydepdate"; }
        if($("#chkclaimcheck").is(":checked")){ var xcheck = "filterdatebyclaimdate"; }  
        $.ajax({
            type: 'POST',
            url: 'filter/class.php',
            data: 'module=' + module + '&checked=' + checked + '&checked2=' + checked2 + '&checked3=' + checked3 + '&Date1=' + Date1 + '&Date2=' +  Date2 + '&Date3=' + Date3 + '&Date4=' + Date4 + '&xcheck=' + xcheck + '&form=saveFilters', 
            success: function(data){
                showdepositlist();
                $("#LINK_BaggageLogs_filter").click();
            }
        })
    }

    function loadBaggageLogsFilter(module){
        $.ajax({
            type: 'POST',
            url: 'filter/class.php',
            data: 'module=' + module + '&form=loadFilters',
            success: function(data){
                var arr = data.split("#");
                var arr2 = arr[0].split("|");
                for(var i=0; i<=arr2.length-2; i++){
                    $('input:checkbox[id="filter_'+arr2[i]+'"][value="'+arr2[i]+'"]').attr('checked', 'checked');
                }
                var arr3 = arr[1].split("|");
                $("#depositstart").val(arr3[0]);
                $("#depositend").val(arr3[1]);
                $("#claimstart").val(arr3[2]);
                $("#claimend").val(arr3[3]);
                arr4 = arr[2].split("|");
                for(var i=0; i<=arr4.length-1; i++){
                    $('input:checkbox[id="filter_'+arr4[i]+'"][value="'+arr4[i]+'"]').attr('checked', 'checked');
                }
                if(arr[3] == "filterdatebydepdate"){
                    $("#chkdepositcheck").prop("checked", true);
                    checkfirstdate();
                }else{
                    $("#chkclaimcheck").prop("checked", true);
                    checksecdate();
                }
            }
        })
    }

    function claimitem(transid){
        showmodal("confirm", "Do you want to claim this item?", "confirmedclaimitem", transid+"|", "", null, "0");
    }

    function confirmedclaimitem(transid){
        $.ajax({
            type: 'POST',
            url: 'itemsclaim/class.php',
            data: 'transid=' + transid + '&form=claimitem',
            success:function(data){
                var arr = data.split("|");
                if(arr[0] == "1"){
                    setTimeout(function(){
                        showmodal("alert", arr[1], "showdepositlist", null, "", null, "0");
                    }, 100)
                }else{
                    setTimeout(function(){
                        showmodal("alert", arr[1], "", null, "", null, "0");
                    }, 100)
                }
            }
        })
    }

    function printbyfilter(){
        $.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'form=getheaderprint',
            success:function(data){
                $("#template").html(data);
                $("#chkdepositcheck2").click();
            }
        })
    }

    function printmesenpai(){
        var stat = "";
        $(".chkfilterbystat").each(function(){
            if($(this).is(":checked")){
                var value = $(this).attr("value");
                stat += value + "|";
            }
        })
        if($("#chkdepositcheck2").is(":checked")){ 
            var dateFrom = $("#depositstart2").val();
            var dateTo = $("#depositend2").val();
            var datetype = "DepositDate";
        }
        if($("#chkclaimcheck2").is(":checked")){ 
            var dateFrom = $("#claimstart2").val();
            var dateTo = $("#claimend2").val();
            var datetype = "ClaimDate";
        }
        $.ajax({
            type: 'POST',
            url: 'itemsclaim/class.php',
            data: 'stat=' + stat + '&dateFrom=' + dateFrom + '&dateTo=' + dateTo + '&datetype=' + datetype + '&form=printmesenpai',
            success:function(data){
                var arr = data.split("|");
                $("#tblItemListPrint").html(arr[0]);
                $("#txtItemListPrintDateFrom").text(arr[1]);
                $("#txtItemListPrintDateTo").text(arr[2]);
                    var toprint = $("#txtItemListPrint").html();
                    var myheight = $(window).height()-40;
                    var mywidth = $(window).width()-40;
                    var popupWin = window.open("", "_blank", "height=" + myheight + ",width=" + mywidth + ",location=no,scrollbars=1,left=" + 20);
                    popupWin.document.open();
                    popupWin.document.write("<html><head><title></title></head><body onload='window.print();'>" + toprint + "</body></html>");
                    popupWin.document.close();
            }
        })
    }
</script>