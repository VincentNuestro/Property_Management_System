<script type="text/javascript">
    $(function(){
        tblstorename();
        $(".fixTable").tableHeadFixer();
        $(".divinfo input").prop("readonly", true);
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

        $(function(){
            $('.btnsortdash-tenanthistory').click(function(){
                if($(this).hasClass("fa-sort-up")){
                    $(this).addClass("fa-sort-down").removeClass("fa-sort-up");
                    $("#TenantHistorySortType").val("ASC");
                    $("#TenantHistorySortBy").val(this.id);
                    tblstorename();
                }
                else if($(this).hasClass("fa-sort-down")){
                    $(this).addClass("fa-sort-up").removeClass("fa-sort-down");
                    $("#TenantHistorySortType").val("DESC");
                    $("#TenantHistorySortBy").val(this.id);
                    tblstorename();
                }else if($(this).hasClass("fa-sort")){
                    if($("#ManpowerSortType").val() == "ASC"){
                        $(this).addClass("fa-sort-up").removeClass("fa-sort-down");
                        $("#TenantHistorySortType").val("DESC");
                        $("#TenantHistorySortBy").val(this.id);
                        tblstorename();
                    }else{
                        $(this).addClass("fa-sort-down").removeClass("fa-sort-up");
                        $("#TenantHistorySortType").val("ASC");
                        $("#TenantHistorySortBy").val(this.id);
                        tblstorename();
                    }
                }
            });
        });
    });

    setTimeout(function(){
        tblstorename();
        $(".fixTable").tableHeadFixer();
        // $(".divinfo input").prop("disabled", true);
    }, 3000);

    function tblstorename() {
        var TenantHistorySortBy = $('#TenantHistorySortBy').val();
        var TenantHistorySortType = $('#TenantHistorySortType').val();
        var srchhistory = $("#srchhistory").val();
        $.ajax({
            type: 'POST',
            url: 'reports/tenantshistory/historymainclass.php',
            data: 'srchhistory=' + srchhistory + '&TenantHistorySortBy=' + TenantHistorySortBy + '&TenantHistorySortType=' + TenantHistorySortType +  '&form=tblstorename',
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

    function  thiscompany(mallname, compid, compname, storename, tid, fname, mname, lname, tradepic) {
        $("#mallname").val(mallname);
        $("#compid").val(compid);
        $("#compname").val(compname);
        $("#storename").val(storename);
        $("#tenantid").val(tid);
        $("#fname").val(fname);
        $("#lname").val(lname);
        $("#mname").val(mname);
        $("#historylogo").attr("src", tradepic);
        tblstoreunit(tid);

        $(".mallname").text(mallname);
        $(".compid").text(compid);
        $(".compname").text(compname);
        $(".storename").text(storename);
        $(".tenantid").text(tid);
        $(".fname").text(fname);
        $(".lname").text(lname);
        $(".mname").text(mname);
        $("#printlogo").attr("src", tradepic);
        $.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'tenantid=' + tid + '&form=getheaderprint',
            success:function(data){
                $("#template").html(data);
            }
        })
    }

    function tblstoreunit(tid) {
        var tid = tid;

        $.ajax({
            type: 'POST',
            url: 'reports/tenantshistory/historymainclass.php',
            data: 'tid=' + tid + '&form=tblstoreunit',
             beforeSend : function() {
                $('#indexloadingscreen').addClass('myspinner');
            },
            success: function(data){
                $('#indexloadingscreen').removeClass('myspinner');
                 $("#tblstoreunit").html(data);
                 $("#printtblstoreunit").html(data);
             }
        });
    }

    function printhistory(){
        var laman = $("#tblstoreunit tr").length;
        if(laman == 0){
            setTimeout(function(){
                showmodal("alert", "Sorry, no data found.", "", null, "", null, "1");
            }, 500)
        }else{
            $.ajax({
                type: 'POST',
                url: 'mainclass.php',
                data: 'form=getheaderprint',
                success:function(data){
                    $("#template").html(data);
                }, complete(){
                    var toPrint = document.getElementById("historyreportgo");
                    var popupWin = window.open('', '_blank', 'width=900,height=500,location=no,');
                    popupWin.document.open();
                    popupWin.document.write('<html><title>Tenant History Report</title><link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" /><body onload="window.print();">' );
                    popupWin.document.write( toPrint.innerHTML);
                    popupWin.document.write('</body></html>');
                    popupWin.document.close();
                }
            })
        }
    }
</script>
