<script type="text/javascript">
    $(function(){
        $(".fixTable").tableHeadFixer(); 
        $("#txt_userpage10").val("1");
        $('[data-rel=tooltip]').tooltip();
        $('[data-rel=popover]').popover({html:true});
        $(".date-picker").datepicker({
            autoHide: true,
            format: 'mm/dd/yyyy',
            todayHighlight: true
        });
        displaylistofpenalty();
        $("#txtsearchpen").keyup(function(e){
            var x = event.keyCode;
            if(x == 13){ 
                $("#txt_userpage10").val("1");
                displaylistofpenalty(); 
            }else if ( x == '8' ){
                if($('#txtsearchpen').val() == ""){
                    $("#txt_userpage10").val("1");
                    displaylistofpenalty();
                }
            }
        });
        $(".amount").change(function(){
            var x = ($(this).val()).replace(/,/g,"");
            var v = parseFloat(x||0);
            $(this).val(v.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
        });
        $("#txtBillSearchTenant").keyup(function(e){
            var x = event.keyCode;
            if(x == 13){ 
                fncBrowseTenantList(); 
            }else if ( x == '8' ){
                if($('#txtBillSearchTenant').val() == ""){
                    fncBrowseTenantList();
                }
            }
        });
        $("#txtBillSearchPenalty").keyup(function(e){
            var x = event.keyCode;
            if(x == 13){ 
                fncSelectPenalty(); 
            }else if ( x == '8' ){
                if($('#txtBillSearchPenalty').val() == ""){
                    fncSelectPenalty();
                }
            }
        });
        $("#txtPPBillingParticulars").keydown(function(e){
            var code = (e.keyCode ? e.keyCode : e.which);
            if (code == 50 && e.shiftKey) {
               event.preventDefault(); 
            }
        });
    })

    function displaylistofpenalty(){
        var page = $("#txt_userpage10").val();
        var key = $("#txtsearchpen").val();
        $.ajax({
            type: 'POST',
            url: 'billing/penalty/class.php',
            data: 'key=' + key + '&page=' + page + '&form=displaylistofpenalty',
            beforeSend : function() {
                $('#indexloadingscreen').addClass('myspinner');
            },
            success: function(data){
                $('#indexloadingscreen').removeClass('myspinner');
                if(data != ""){
                    $("#tbllistofpenalties").html(data);
                }else{
                    $("#tbllistofpenalties").html("<tr><td colspan='7' style='text-align: center;'>No Data Found...</td></tr>");
                }
                loadentriespenalties();
                loadpagespenalties();
            }
        })
    }

    function loadentriespenalties(){
        var page = $("#txt_userpage10").val();
        var key = $("#txtsearchpen").val();
            $.ajax({
                type: 'POST',
                url: 'billing/penalty/class.php',
                data: 'key=' + key + '&page=' + page + '&form=loadentriespenalties',
                success: function(data){
                    $("#txtbillingentries123").text(data);
                }
            });
        }

    function loadpagespenalties(){
        var page = $("#txt_userpage10").val();
        var key = $("#txtsearchpen").val();
            $.ajax({
                type: 'POST',
                url: 'billing/penalty/class.php',
                data: 'key=' + key + '&page=' + page + '&form=loadpagelistofpenalties',
                success: function(data){
                    $("#ulpaginationlistofpenalties").html(data);
                }
            });
        }

    function paginationpenalties(page, pagenums){
        $(".pgnumpenalties").removeClass("active");
        $("#pgpenalties" + pagenums).addClass("active");
        $("#txt_userpage10").val(page);
        displaylistofpenalty();
    }

    function showcreatenewpenalty(){
        $("#createnewpenalty").modal("show");
        $("#txtPPTransDate").val('<?php echo date('m/d/Y'); ?>');
        fncPenaltyTenant();
    }

    function closeandclear(){
        $("#createnewpenalty").modal("hide");
        $("#createnewpenalty :input").val("");
        $("#tbodyTenantList").html("");
        $("#tbodyPenaltyList").html("");
        displaylistofpenalty();
    }

    function savePenaltyFilter(){
        var module = "Penalty";
        var checked = "";
        $('input:checkbox[name="form-field-checkboxpen"]').each(function(){
            if($(this).is(":checked")){
                var value = $(this).attr("value");
                checked += value + "|";
            }
        })
        var checked2 = "";
        $('input:checkbox[name="form-field-checkboxpen"]').each(function(){
                var value2 = $(this).attr("value");
                checked2 += value2 + "|";
        })
        var Date1 = $("#pendatefrom").val();
        var Date2 = $("#pendateto").val();
        $.ajax({
            type: 'POST',
            url: 'filter/class.php',
            data: 'module=' + module + '&checked=' + checked + '&checked2=' + checked2 + '&Date1=' + Date1 + '&Date2=' + Date2 + '&form=saveFilters',
            success: function(data){
                displaylistofpenalty();
                $("#LINK_Penalty_filter").click();
            }
        })
    }

    function loadPenaltyFilter(module){
        $.ajax({
            type: 'POST',
            url: 'filter/class.php',
            data: 'module=' + module + '&form=loadFilters',
            success: function(data){
                var datas = data.split("#");
                var arr = datas[0].split("|");
                var arr2 = datas[1].split("|");
                for(var i=0; i<=arr.length-1; i++){
                    $('input:checkbox[id="filter_'+arr[i]+'"][value="'+arr[i]+'"]').attr('checked', 'checked');
                }
                $("#pendatefrom").val(arr2[0]);
                $("#pendateto").val(arr2[1]);
            }
        })
    }

    function fncDeletePenalty(id){
        setTimeout(function(){
            showmodal("confirm", "Do you want to delete this penalty?.", "fncDeletePenalty2", id+"|", "", null, "1");
        }, 500)
    }

    function fncDeletePenalty2(id){
        $.ajax({
            type: 'POST',
            url: 'billing/penalty/class.php',
            data: 'id=' + id + '&form=fncDeletePenalty',
            success: function(data){
                if(data == 1){
                    setTimeout(function(){
                        showmodal("alert", "Penalty successfully deleted.", "displaylistofpenalty", null, "", null, "0");
                    }, 500)
                }else{
                    setTimeout(function(){
                        showmodal("alert", "Failed to delete penalty", "", null, "", null, "0");
                    }, 500) 
                }
            }
        })
    }

    function fncSelectPenalty(){
        var key = $("#txtBillSearchPenalty").val();
        var PenaltyList = "";
        $("#tbodyPenaltyList tr").each(function(){
            PenaltyList += $(this).attr("id") + "|";
        })
        $.ajax({
            type: 'POST',
            url: 'billing/penalty/class.php',
            data: 'key=' + key + '&PenaltyList=' + PenaltyList + '&form=fncSelectPenalty',
            success: function(data){
                $("#tblBillPenaltyList").html(data);
                $("#tblBillPenaltyList tr").each(function(){
                    $(this).click(function(){
                        $("#tblBillPenaltyList tr").removeClass("selected");
                        var tr = $(this).attr("id");
                        $("#"+tr).addClass("selected");
                    })
                })
            }
        })
    }

    function fncgetSelectedPenalties(){
        $("#mdlBillPenaltyList").modal("hide");
        $("#mdlPenaltyInfo").modal("hide");
        var PenaltyCode = $("#txtPPCode").val();
        var TenantID = $("#txtPPTenant").val();
        var Description = $("#txtPPDescription").val();
        var Rate = parseFloat($("#txtPPRate").val().replace(/,/g,""));
        var Reference = $("#txtPPBillingParticulars").val();
        $.ajax({
            type: 'POST',
            url: 'billing/penalty/class.php',
            data: 'TenantID=' + TenantID + '&PenaltyCode=' + PenaltyCode + '&Description=' + Description + '&Rate=' + Rate + '&Reference=' + Reference + '&form=fncgetSelectedPenalties',
            success: function(data){
                $("#tbodyPenaltyList").append(data.trim());
                $("#tbodyPenaltyList tr").each(function(){
                    $(this).click(function(){
                        if($(this).hasClass("selected")){
                            $(this).removeClass("selected");
                            $(this).addClass("unselected");
                        }else{
                            $(this).removeClass("unselected");
                            $(this).addClass("selected");
                        }
                    })
                })
            }, complete: function(){
                getTotalAmountofPenalty();
            }
        })
    }

    function fncPenaltyTenant(){
        $.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'form=showTenantList',
            success: function(data){
                $("#txtPPTenant").html(data);
            }
        })
    }

    function showTenantInfo(){
        var TenantID = $("#txtPPTenant").val();
        $.ajax({
            type: 'POST',
            url: 'billing/billing/class.php',
            data: 'TenantID=' + TenantID + '&form=showTenantInfo',
            success:function(data){
                var arr = data.split("|");
                $("#txtPPStatus").val(arr[0]);
                $("#txtPPBillingType").val(arr[1]);
            }
        })
    }

    function btnPPSelectAll(){
        $("#tbodyPenaltyList tr").removeClass("unselected");
        $("#tbodyPenaltyList tr").addClass("selected");
    }

    function btnPPUnselectAll(){
        $("#tbodyPenaltyList tr").removeClass("selected");
        $("#tbodyPenaltyList tr").addClass("unselected");
    }

    function btnPPRemoveSelected(){
        var Count = 0;
        $("#tbodyPenaltyList tr").each(function(){
            if($(this).hasClass("selected")){
                Count++;
            }
        })
        if(Count >= 1){
            $("#tbodyPenaltyList tr").each(function(){
                if($(this).hasClass("selected")){
                    $("#"+$(this).attr("id")).remove();
                }
            })
            getTotalAmountofPenalty();
        }else{
            setTimeout(function(){
                showmodal("alert", "Select first penalty to be removed.", "", null, "", null, "1");
            }, 500)
        }
    }

    function getTotalAmountofPenalty(){
        var subtotal  = 0;
        $("#tbodyPenaltyList tr").each(function(){
            subtotal += parseFloat($(this).find("td").eq(5).text().replace(/,/g,""));
        });
        $("#txtPPTotalCharges").text(subtotal.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
    }

    function fncCheckPTenantFirst(){
        var TenantID = $("#txtPPTenant").val();
        if(TenantID == ""){
            setTimeout(function(){
                showmodal("alert", "Please select the tenant you want to post the penalty with.", "", null, "", null, "1");
            }, 500)
        }else{
            $('#txtBillSearchTenant').val(''); 
            fncSelectPenalty(); 
            $('#mdlBillPenaltyList').modal('show');
        }
    }

    function PostPPCharges(){
        var xDate = $("#txtPPTransDate").val();
        var TenantID = $("#txtPPTenant").val();
        var PenaltyList = "";
        $("#tbodyPenaltyList tr").each(function(){
            var PenaltyCode = $(this).attr("id");
            var PenaltyDesc = $(this).find("td").eq(1).text();
            var Particulars = $(this).find("td").eq(2).text();
            var Amount = $(this).find("td").eq(3).text().replace(/,/g,"");
            var VatAmount = $(this).find("td").eq(4).text().replace(/,/g,"");
            var TotalAmount =  $(this).find("td").eq(5).text().replace(/,/g,"");
            PenaltyList += PenaltyCode + "|" + PenaltyDesc + "|" + Particulars + "|" + Amount + "|" + VatAmount + "|" + TotalAmount + "@";
        });
        if(TenantID != ""){
            if(PenaltyList != ""){
                $.ajax({
                    type: 'POST',
                    url: 'billing/penalty/class.php',
                    data: 'xDate=' + xDate + '&TenantID=' + TenantID + '&PenaltyList=' + PenaltyList + '&form=PostPPCharges',
                    success:function(data){
                        var arr = data.split("|");
                        setTimeout(function(){
                            showmodal("alert", arr[1], arr[2], null, "", null, arr[0]);
                        }, 500)
                    }
                })
            }else{
                setTimeout(function(){
                    showmodal("alert", "Please select the penalty you want to post.", "", null, "", null, "1");
                }, 500)
            }
        }else{
            setTimeout(function(){
                showmodal("alert", "Please select the tenant you want to post the penalty with.", "", null, "", null, "1");
            }, 500)
        }
    }

    function fncSelectedPenalty(PenaltyCode, PenaltyDesc, PenaltyAmount){
        $("#mdlPenaltyInfo").modal("show");
        $("#txtPPCode").val(PenaltyCode);
        $("#txtPPDescription").val(PenaltyDesc);
        $("#txtPPRate").val(PenaltyAmount);
        $("#txtPPBillingParticulars").val("");
    }

    function fncmdlClearPenalty(){
        $("#tbodyPenaltyList").html("");
        $(".txtPPHiddenValue").val("");
        $(".txtPPInitiateClear").val("");
        $("#createnewpenalty").modal("hide");
        displaylistofpenalty();
    }
</script>