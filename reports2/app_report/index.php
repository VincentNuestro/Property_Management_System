<div class="row">
    <div class="col-md-12">
        <div class="row form-group" style="margin-bottom: 0px;">
            <div class="col-md-7 hidden-xs" style="padding-bottom: 5px;padding-left: 0px;"></div>
            <div class="col-md-3" style="padding-bottom: 5px;padding-left: 0px;">
                <div class="input-daterange input-group">
                    <input type="text" class="form-control date-picker" id="dateFrom6" value="<?php echo date('m/d/Y'); ?>">
                    <span class="input-group-addon">
                        <i class="fa fa-exchange"></i>
                    </span>
                    <input type="text" class="form-control date-picker" id="dateTo6" value="<?php echo date('m/d/Y'); ?>">
                </div>
            </div>
            <div class="col-md-1">
                <button class="btn btn-sm btn-primary btn-round" onclick="showappreport();"><i class="glyphicon glyphicon-search"></i>&nbsp;Go</button>
            </div>
            <div class="col-md-1 pull-right" style="padding-bottom: 5px;padding-left: 0px;">
                <h5 class="pull-right"><a onclick="loadmallselectappr();" class="popover-info" data-rel="popover" data-placement="bottom" title="Print by" data-content='
                    <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;margin-top: 0px;">
                        <legend style="border: none;margin-bottom: 0px;font-size: 15px; font-weight: normal;width:105px;">&nbsp;&nbsp;Filter by Mall&nbsp;&nbsp;</legend>
                        <div class="form-group row" style="margin:0px;">
                            <select class="form-control malloption" id="printapprbymall"></select>
                        </div>
                    </fieldset>

                    <fieldset style="margin: 8px;border: 1px dotted #CCC;padding: 8px;" id="div_chkappdate">
                        <div class="form-group row" style="margin:0px;">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar bigger-110"></i>
                                    </span>
                                    <input class="form-control date-picker" type="text" id="dateFromappr" data-provide="datepicker" value="<?php echo date('m/d/Y'); ?>">
                                </div>                
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar bigger-110"></i>
                                    </span>
                                    <input class="form-control date-picker" type="text" id="dateToappr" data-provide="datepicker" value="<?php echo date('m/d/Y'); ?>">
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
                            <button class="btn btn-xs btn-success btn-round" onclick="print_app_report()" style="float:right;margin-bottom:10px;margin-right:10px;width:80px;">
                                Print
                            </button>
                        </div>
                    </div>'>
                <i class="glyphicon glyphicon-print bigger-110"></i>&nbsp;&nbsp;Print</a></h5>
            </div>
        </div>
        <div class="row form-group" style="margin-bottom: 0px !important;">
            <div class="parent">
                <table class="table table-bordered table-striped fixTable">
                    <thead>
                        <tr>
                            <th width='10%'>Application ID</th>
                            <th width='15%'>Application Date</th>
                            <th width='20%'>Company Name</th>
                            <th width='15%' class="thSysTenant">Trade Name</th>
                            <th width='10%'>Status</th>
                            <th width='8%'>Start Date</th>
                            <th width='8%'>End Date</th>
                            <th width='14%'>Remarks</th>
                        </tr>
                    </thead>
                    <tbody id="applicationList" ></tbody>
                </table>
            </div>
            <table class="tabledash_footer table" style="margin: 0px !important;">
                <thead>
                    <tr>
                        <th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
                            <font id="txtapp_reportentries" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
                            <input id="txt_userpage" type="hidden">
                            <ul id="ulpaginationapp_report" class="pagination pull-right"></ul>
                        </th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div class="checklist" id="div_form_app_report" style="display: none;">
    <table style="width: 100%;" cellspacing="0" cellpadding="0">
        <tbody id="templateappr"></tbody>
    </table>
    <table cellspacing="0" style="width: 100%">
        <tr>
            <td align="right">
                <p style="font-size: 15px; margin-top: 5px;">From:&nbsp;&nbsp;<label id="dateFrom312412"></label>&nbsp;&nbsp;To&nbsp;&nbsp;<label id="dateTo312412"></label></p>
            </td>
        </tr>
        <tr>
            <td>
                <center><p style="font-size: 22px; font-weight: bold;background-color: #666;color: white;width: 100%;">Application List</p></center>
            </td>
        </tr>
    </table>
    <table style="width:100%;">
        <thead>
            <tr>
                <td>APPLICATION DATE</td>
                <td>COMPANY NAME</td>
                <td class="thSysTenant">TRADE NAME</td>
                <td>STATUS</td>
                <td>START DATE</td>
                <td>END DATE</td>
                <td>REMARKS</td>
            </tr>
            <td colspan="8"><hr></td>
        </thead>
        <tbody id="appreportlist1"></tbody>
    </table>
</div>

<script type="text/javascript">
    $(function(){
        $(".fixTable").tableHeadFixer();
        $("#txt_userpage").val("1");
        showappreport();
        loadentriesappr_report();
        $(".date-picker").datepicker({
            autoHide: true,
            format: 'mm/dd/yyyy',
            todayHighlight: true
        })
    })  

    function showappreport(){
        var dateFrom = $("#dateFrom6").val();
        var dateTo = $("#dateTo6").val();
        var page = $("#txt_userpage").val();
        $.ajax({
            type: 'POST',
            url: 'reports/app_report/class.php',
            data: 'dateFrom=' + dateFrom + '&dateTo=' + dateTo + '&page=' + page + '&form=showappreport',
            beforeSend : function() {
                $('#indexloadingscreen').addClass('myspinner');
            },
            success: function(data){
                $('#indexloadingscreen').removeClass('myspinner');
                if(data.trim() != ""){
                    $("#applicationList").html(data);
                }else{
                    $("#applicationList").html("<tr><td colspan='8' style='text-align: center;'>No Data Found...</td></tr>");
                }
                loadentriesappr_report();
                loadpageapp_report();
            }
        })
    }

  function loadentriesappr_report(){
        var page = $("#txt_userpage").val();
        var dateFrom = $("#dateFrom6").val();
        var dateTo = $("#dateTo6").val();
        $.ajax({
            type: 'POST',
            url: 'reports/app_report/class.php',
            data: 'page=' + page + '&dateFrom=' + dateFrom + '&dateTo=' + dateTo + '&form=loadentriesappr_report',
            success: function(data){
                $("#txtapp_reportentries").text(data);
            }
        });
    }

function loadpageapp_report(){
        var page = $("#txt_userpage").val();
        var dateFrom = $("#dateFrom6").val();
        var dateTo = $("#dateTo6").val();
        $.ajax({
            type: 'POST',
            url: 'reports/app_report/class.php',
            data: 'dateFrom=' + dateFrom +  '&dateTo=' + dateTo + '&page=' + page + '&form=loadpageapp_report',
            success: function(data){
                $("#ulpaginationapp_report").html(data);
            }
        });
    }

    function pagination54(page, pagenums){
        $(".pgnumpapp_report").removeClass("active");
        var value = "#" + pagenums;
        $("#pgapp_report" + pagenums).addClass("active");
        $("#txt_userpage").val(page);
        showappreport();
        loadpageapp_report();
        loadentriesappr_report();
    }

    function print_app_report(){
        var dateFrom = $("#dateFromappr").val();
        var dateTo = $("#dateToappr").val();
        var mallid = $("#printapprbymall").val();
        if(mallid != "" && mallid != null){
            $.ajax({
                type: 'POST',
                url: 'reports/app_report/class.php',
                data: 'mallid=' + mallid + '&dateFrom=' + dateFrom + '&dateTo=' + dateTo + '&form=print_app_report',
                success:function(data){
                    var arr = data.split("|");
                    $("#appreportlist1").html(arr[0]);
                    $("#dateFrom312412").text(arr[1]);
                    $("#dateTo312412").text(arr[2]);
                },complete(){
                    $.ajax({
                        type: 'POST',
                        url: 'mainclass.php',
                        data: 'mallID=' + mallid + '&form=getheaderprint',
                        success:function(data){
                            $("#templateappr").html(data);
                            var toprint = $("#div_form_app_report").html();
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

    function loadmallselectappr(){
        $.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'form=tblref_mall',
            success:function(data){
                $("#printapprbymall").html(data);
            }
        })
    }
</script>