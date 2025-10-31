<div class="row">
    <div class="col-md-12">
        <div class="row form-group" style="margin-bottom: 0px;">
            <div class="col-md-7 hidden-xs" style="padding-bottom: 5px;padding-left: 0px;"></div>
            <div class="col-md-3" style="padding-bottom: 5px;padding-left: 0px;">
                <div class="input-daterange input-group">
                    <input type="text" class="form-control date-picker" id="dateFrom7" value="<?php echo date('m/d/Y'); ?>">
                    <span class="input-group-addon">
                        <i class="fa fa-exchange"></i>
                    </span>
                    <input type="text" class="form-control date-picker" id="dateTo7" value="<?php echo date('m/d/Y'); ?>">
                </div>
                
            </div>
            <div class="col-md-1" style="padding-bottom: 5px;padding-left: 0px;">
                <button class="btn btn-sm btn-primary btn-round" onclick="showinquiryreport();"><i class="glyphicon glyphicon-search"></i>&nbsp;Go</button>
            </div>
            <div class="col-md-1 pull-right" style="padding-bottom: 5px;padding-left: 0px;">
                <h5 class="pull-right"><a onclick="loadmallselectinqr();" class="popover-info" data-rel="popover" data-placement="bottom" title="Print by" data-content='
                    <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
                        <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:105px;">&nbsp;&nbsp;Filter by Mall&nbsp;&nbsp;</legend>
                            <div class="form-group row" style="margin:0px;">
                                <select class="form-control malloption" id="printinqrbymall"></select>
                            </div>
                    </fieldset>

                    <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;" id="div_chkappdate">
                        <div class="form-group row" style="margin:0px;">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar bigger-110"></i>
                                    </span>
                                    <input class="form-control date-picker" type="text" id="dateFrominqr" data-provide="datepicker" value="<?php echo date('m/d/Y'); ?>">
                                </div>                
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar bigger-110"></i>
                                    </span>
                                    <input class="form-control date-picker" type="text" id="dateToinqr" data-provide="datepicker" value="<?php echo date('m/d/Y'); ?>">
                                </div>                
                            </div>
                        </div>
                    </fieldset>

                    <div class="form-group row" style="padding-left:8px;margin-bottom:0px;">
                        <div class="col-md-9" style="padding-right:0px;">
                            <div class="alert alert-info" style="padding-top:10px;padding-bottom:10px;">
                                <button class="close" data-dismiss="alert">
                                    <i class="ace-icon fa fa-times"></i>
                                </button>
                                Select the range of date you want to print.
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-xs btn-success btn-round" onclick="print_inq_report()" style="float:right;margin-bottom:10px;margin-right:10px;width:80px;">
                                Print
                            </button>
                        </div>
                    </div>'>
                <i class="glyphicon glyphicon-print bigger-110"></i>&nbsp;&nbsp;Print</a></h5>
            </div>
        </div>
        <div class="row form-group" style="margin-bottom: 0px !important;">
            <div class="parent">
                <table class="table table-bordered fixTable">
                    <thead>
                        <tr>
                            <th width='10%'>Inquiry ID<span class="btnsortdash-inquiry fa fa-sort bigger-130 pull-right" id="Inquiry_ID"></span></th>
                            <th width='10%'>Date Inquired<span class="btnsortdash-inquiry fa fa-sort bigger-130 pull-right" id="date_inquired"></span></th>
                            <th width='20%'>Company Name<span class="btnsortdash-inquiry fa fa-sort bigger-130 pull-right" id="Company_Name"></span></th>
                            <th width='20%' class="thSysTenant">Trade Name<span class="btnsortdash-inquiry fa fa-sort bigger-130 pull-right" id="Trade_Name"></span></th>
                            <th width='10%'>Unit Type<span class="btnsortdash-inquiry fa fa-sort bigger-130 pull-right" id="UnitType"></span></th>
                            <th width='10%'>Start Date<span class="btnsortdash-inquiry fa fa-sort bigger-130 pull-right" id="datefrom"></span></th>
                            <th width='10%'>End Date<span class="btnsortdash-inquiry fa fa-sort bigger-130 pull-right" id="dateto"></span></th>
                            <th width='10%'>Remarks<span class="btnsortdash-inquiry fa fa-sort bigger-130 pull-right" id="xremarks"></span></th>
                        </tr>
                    </thead>
                    <tbody id="inquirylist" ></tbody>
                </table>
            </div>
            <table class="tabledash_footer table" style="margin: 0px !important;">
                <thead>
                    <tr>
                        <th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
                            <font id="txtinq_reportentries" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
                            <input id="txt_userpage2" type="hidden">
                            <ul id="ulpaginationinq_report" class="pagination pull-right"></ul>
                        </th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div id="div_form_inq_report" style="display: none;">
    <table style="width: 100%;" cellspacing="0" cellpadding="0">
        <tbody id="templateinqr"></tbody>
    </table>
    <table cellspacing="0" style="width: 100%">
        <tr>
            <td align="right">
                <p style="font-size: 15px; margin-top: 5px;">From:&nbsp;&nbsp;<label id="dateFrom3a"></label>&nbsp;&nbsp;To&nbsp;&nbsp;<label id="dateTo3a"></label></p>
            </td>
        </tr>
        <tr>
            <td>
                <p style="font-size: 20px; font-weight: bold;background-color: #666;color: white;width: 100%;text-align: center;">Inquiry List</p>
            </td>
        </tr>
    </table>
    <table cellspacing="0" style="width: 100%;">
        <thead>
            <tr>
                <td>Date Inquired</h6></td>
                <td>Company Name</h6></td>
                <td class="thSysTenant">Trade Name</h6></td>
                <td>Unit Type</h6></td>
                <td>Start Date</h6></td>
                <td>End Date</h6></td>
                <td>Remarks</h6></td>
            </tr>
        <td colspan="8"><hr></td>
        </thead>
        <tbody id="inquirylist2"></tbody>
    </table>
</div>

<input type="hidden" id="InquirySortType" value="ASC">
<input type="hidden" id="InquirySortBy" value="date_inquired">

<script type="text/javascript">
    $(function(){
        $(".fixTable").tableHeadFixer();
        $("#txt_userpage2").val("1");
        showinquiryreport();
        loadentries2();
        $('[data-rel=tooltip]').tooltip();
        $('[data-rel=popover]').popover({html:true});
        $(".date-picker").datepicker({
            autoHide: true,
            format: 'mm/dd/yyyy',
            todayHighlight: true
        })

        $(function(){
            $('.btnsortdash-inquiry').click(function(){
                if($(this).hasClass("fa-sort-up")){
                    $(this).addClass("fa-sort-down").removeClass("fa-sort-up");
                    $("#InquirySortType").val("ASC");
                    $("#InquirySortBy").val(this.id);
                    showinquiryreport();
                }
                else if($(this).hasClass("fa-sort-down")){
                    $(this).addClass("fa-sort-up").removeClass("fa-sort-down");
                    $("#InquirySortType").val("DESC");
                    $("#InquirySortBy").val(this.id);
                    showinquiryreport();
                }else if($(this).hasClass("fa-sort")){
                    if($("#InquirySortType").val() == "ASC"){
                        $(this).addClass("fa-sort-up").removeClass("fa-sort-down");
                        $("#InquirySortType").val("DESC");
                        $("#InquirySortBy").val(this.id);
                        showinquiryreport();
                    }else{
                        $(this).addClass("fa-sort-down").removeClass("fa-sort-up");
                        $("#InquirySortType").val("ASC");
                        $("#InquirySortBy").val(this.id);
                        showinquiryreport();
                    }
                }
            });
        });
    })

    function showinquiryreport(){
        var InquirySortBy = $('#InquirySortBy').val();
        var InquirySortType = $('#InquirySortType').val();
        var dateFrom = $("#dateFrom7").val();
        var dateTo = $("#dateTo7").val();
        var page = $("#txt_userpage2").val();
        $.ajax({
            type: 'POST',
            url: 'reports/inquiry_report/class.php',
            data: 'dateFrom=' + dateFrom + '&dateTo=' + dateTo + '&page=' + page + '&InquirySortBy=' + InquirySortBy + '&InquirySortType=' + InquirySortType + '&form=showinquiryreport',
            beforeSend : function() {
                $('#indexloadingscreen').addClass('myspinner');
            },
            success: function(data){
                // alert(data);
                $('#indexloadingscreen').removeClass('myspinner');
                if(data.trim() != ""){
                    $("#inquirylist").html(data);
                }else{
                    $("#inquirylist").html("<tr><td colspan='8' style='text-align: center;'>No Data Found...</td></tr>");
                }
                loadentries2();
                loadpageinq_report();
            }
        })
    }

    function loadentries2(){
        var page = $("#txt_userpage2").val();
        var dateFrom = $("#dateFrom7").val();
        var dateTo = $("#dateTo7").val();
        $.ajax({
            type: 'POST',
            url: 'reports/inquiry_report/class.php',
            data: 'page=' + page + '&dateFrom=' + dateFrom + '&dateTo=' + dateTo + '&form=loadentries2',
            success: function(data){                
                $("#txtinq_reportentries").text(data);                
            }
        });
    }

    function loadpageinq_report(){
        var page = $("#txt_userpage2").val();
        var dateFrom = $("#dateFrom7").val();
        var dateTo = $("#dateTo7").val();
        $.ajax({
            type: 'POST',
            url: 'reports/inquiry_report/class.php',
            data: 'dateFrom=' + dateFrom +  '&dateTo=' + dateTo + '&page=' + page + '&form=loadpageinq_report',
            success: function(data){
                $("#ulpaginationinq_report").html(data);
            }
        });
    }

    function pagination55(page, pagenums){
        $(".pgnumpinq_report").removeClass("active");
        var value = "#" + pagenums;
        $("#pginq_report" + pagenums).addClass("active");
        $("#txt_userpage2").val(page);
        showinquiryreport();
    }

    function print_inq_report(){
        var dateFrom = $("#dateFrominqr").val();
        var dateTo = $("#dateToinqr").val();
        var mallid = $("#printinqrbymall").val();
        if(mallid != "" && mallid != null){
            $.ajax({
                type: 'POST',
                url: 'reports/inquiry_report/class.php',
                data: 'mallid=' + mallid + '&dateFrom=' + dateFrom + '&dateTo=' + dateTo + '&form=print_inq_report',
                success:function(data){
                    var arr = data.split("|");
                    $("#inquirylist2").html(arr[0]);
                    $("#dateFrom3a").text(arr[1]);
                    $("#dateTo3a").text(arr[2]);
                }, complete(){
                    $.ajax({
                        type: 'POST',
                        url: 'mainclass.php',
                        data: 'mallID=' + mallid + '&form=getheaderprint',
                        success:function(data){
                        $("#templateinqr").html(data);
                        var toprint = $("#div_form_inq_report").html();
                        var myheight = $(window).height()-40;
                        var mywidth = $(window).width()-40;
                        var popupWin = window.open("", "_blank", "height=" + myheight + ",width=" + mywidth + ",location=no,scrollbars=1,left=" + 20);
                        popupWin.document.open();
                        popupWin.document.write("<html><head><title></title><link rel='stylesheet' href='assets/font-awesome/4.5.0/css/font-awesome.min.css' /></head><body onload='window.print();'>" + toprint + "</body></html>");
                        popupWin.document.close();
                      }
                    })
                }
            })
        }else{
          showmodal("alert", "Please select mall.", "", null, "", null, "1");
        }
    }

    function loadmallselectinqr(){
        $.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'form=tblref_mall',
            success:function(data){
                $("#printinqrbymall").html(data);
            }
        })
    }
</script>