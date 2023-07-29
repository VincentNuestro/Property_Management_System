<div class="row">
        <div class="well">
            <div class="form-group row">
                <div class="col-md-11"></div>
                <div class="col-md-1">
                    <button class="btn btn-info btn-sm hide isadmin select-addnewmaintenancechecklist btn-block" onclick="newlistmaksanjsnajkns()">
                         <span class="bigger-110 no-text-shadow">Add List</span>
                    </button>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-12" style="display: block;height: 60vh;overflow-y: scroll;overflow-x:hidden;">
                    <div id="div_maintenancelist"></div>
                </div>
            </div>
        </div>
</div>

<div class="modal fade fade-scale" id="modal_inq_newlist" role="dialog" area-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-sm" style="width:25%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" onclick="closemodal();">&times;</button>
                <h4 class="modal-title" style="font-size: 18px;">Maintenance List</h4>
            </div>
            <div class="modal-body">
                <div class="form-group row" style="margin-bottom: 5px;">
                    <div class="col-md-12" style="font-weight: bold; font-size:15px;">Category Name</div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <select id="txtcatname" class="form-control" onchange="checkmaintype(this.value);"></select>
                    </div>
                    <input type="hidden" id="njznc" name="">
                </div>
                <div class="form-group row" id="isPreventive" style="display: none;">
                    <div class="col-md-8">
                        Number of day(s) notification should pop out prior to scheduled preventive maintenance.
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="txtNotifDays">
                    </div>
                </div>
                <div id="div_tasklist" style="display: block; height: 28em;overflow-y: auto;overflow-x: hidden;"></div>
                <div class="form-group row" style="margin-bottom: 5px;margin-top: 10px;">
                    <div class="col-md-8"></div>
                    <div class="col-md-4">
                        <button class="btn btn-success btn-sm" style="float: right;" onclick="addnew()">
                             <i class="bigger-110 no-text-shadow">Add Task</i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn_saveinquiry" onclick="savesetup()"><i class="ace-icon fa fa-check"></i>&nbsp;Save</button>
            </div>
        </div>
    </div>
</div>

<script>
$(function(){
    loadlist();
    showmaincat();
})
    var dateToday = new Date();
    $('.date-picker').datepicker({
        autoclose: true,
        todayHighlight: true,
        format:"mm/dd/yyyy"
    })

function loadlist(){
    $.ajax({
        type: 'POST',
        url: 'setup/maintenance/mainclass.php',
        data: 'form=loadlist',
        success: function(data){
            $("#div_maintenancelist").html(data);
            $(".fa-chevron-up").each(function(){
                $(this).click();
            })
        }
    })
}
  
function newlistmaksanjsnajkns(){
    $("#njznc").val("");
    $("#modal_inq_newlist").modal("show");
    $("#txtcatname").val("");
    $("#txtNotifDays").val("");
    $("#isPreventive").css("display", "none");
    $("#div_tasklist").html('<div class="well well-sm"><div class="form-group row"><div class="col-md-12"><div class="form-group row" style="margin-bottom: 5px;"><div class="col-md-5" style="font-weight: bold; font-size:15px;">Task List</div><div class="col-md-7"></div></div><div class="form-group row" style="margin-bottom: 5px;"><div class="col-md-12"><input type="text" class="form-control liTask" name="" placeholder="Task"></div></div><div class="form-group row" style="margin-bottom: 5px;"><div class="col-md-12"><textarea class="form-control liDescription" placeholder="Description"></textarea></div></div><br><div class="form-group row" style="margin-bottom: 5px;"><div class="col-md-12" style="font-weight: bold; font-size:15px;">Period</div></div><div class="form-group row tblperiods" style="margin-bottom: 5px;"><div class="col-md-12"><table style="width: 100%;"><tr><td><label><input name="form-field-radio1" type="radio" class="ace" value="Daily" onclick="loaddetails(\'daily\', $(this))"><span class="lbl">&nbsp;Daily</span></label></td><td><label><input name="form-field-radio1" type="radio" class="ace" value="Weekly" onclick="loaddetails(\'weekly\', $(this))"><span class="lbl">&nbsp;Weekly</span></label></td><td><label><input name="form-field-radio1" type="radio" class="ace" value="Monthly" onclick="loaddetails(\'monthly\', $(this))"><span class="lbl">&nbsp;Monthly</span></label></td>  </tr><tr><td><label><input name="form-field-radio1" type="radio" class="ace" value="Quarterly" onclick="loaddetails(\'quarterly\', $(this))"><span class="lbl">&nbsp;Quarterly</span></label></td><td><label><input name="form-field-radio1" type="radio" class="ace" value="Biannually" onclick="loaddetails(\'biannually\', $(this))"><span class="lbl">&nbsp;Biannually</span></label></td><td><label><input name="form-field-radio1" type="radio" class="ace" value="Annually" onclick="loaddetails(\'annually\', $(this))"><span class="lbl">&nbsp;Annually</span></label></td></tr></table></div></div><br><div class="form-group row" style="margin-bottom: 5px;"><div class="col-md-12" style="font-weight: bold; font-size:15px;">Specify Day (when list will display)</div></div>  <div class="form-group row" style="margin-bottom: 5px;"><div class="col-md-4" style="padding-right:5px;"><select disabled class="form-control day non-daily weekly non-monthly non-quarterly non-biannually non-annually"><option value="Monday">Monday</option><option value="Tuesday">Tuesday</option><option value="Wednesday">Wednesday</option><option value="Thursday">Thursday</option><option value="Friday">Friday</option><option value="Saturday">Saturday</option><option value="Sunday">Sunday</option></select></div><div class="col-md-3" style="padding-right:5px;padding-left:5px;"><select disabled class="form-control spefday non-daily non-weekly monthly non-quarterly non-biannually non-annually"><option value="">day</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option></select></div><div class="col-md-5" style="padding-left:5px;"><input disabled class="form-control date-picker datesel non-daily non-weekly non-monthly quarterly biannually annually" type="text" name=""  data-provide="datepicker" placeholder="mm/dd/yyyy"></div></div><div class="form-group row" style="margin-bottom: 5px;"><div class="col-md-7" style="padding-right:5px;"></div><div class="col-md-5" style="padding-left:5px;"><input disabled class="form-control date-picker datesel2 non-daily non-weekly non-monthly quarterly biannually non-annually" type="text" name=""  data-provide="datepicker" placeholder="mm/dd/yyyy"></div></div><div class="form-group row" style="margin-bottom: 5px;"><div class="col-md-7" style="padding-right:5px;"></div><div class="col-md-5" style="padding-left:5px;"><input disabled class="form-control date-picker datesel3 non-daily non-weekly non-monthly quarterly non-biannually non-annually" type="text" name=""  data-provide="datepicker" placeholder="mm/dd/yyyy"></div></div> <div class="form-group row" style="margin-bottom: 5px;"><div class="col-md-7" style="padding-right:5px;"></div><div class="col-md-5" style="padding-left:5px;"><input disabled class="form-control date-picker datesel4 non-daily non-weekly non-monthly quarterly non-biannually non-annually" type="text" name=""  data-provide="datepicker" placeholder="mm/dd/yyyy"></div></div></div></div></div>'); 
}  

function closemodal(){
    $("#modal_inq_newlist").modal("hide");
}

function addnew(){
    var i = 0;
    $("#div_tasklist .well").each(function(){i++;})
    i+=1;
    var existing = $("#div_tasklist").html();
    var aff = '<div class="well well-sm"><div class="form-group row"><div class="col-md-12"><div class="form-group row" style="margin-bottom: 5px;"><div class="col-md-5" style="font-weight: bold; font-size:15px;">Task List</div><div class="col-md-7"></div></div><div class="form-group row" style="margin-bottom: 5px;"><div class="col-md-12"><input type="text" class="form-control liTask" name="" placeholder="Task"></div></div><div class="form-group row" style="margin-bottom: 5px;"><div class="col-md-12"><textarea class="form-control liDescription" placeholder="Description"></textarea></div></div><br><div class="form-group row" style="margin-bottom: 5px;"><div class="col-md-12" style="font-weight: bold; font-size:15px;">Period</div></div><div class="form-group row tblperiods" style="margin-bottom: 5px;"><div class="col-md-12"><table style="width: 100%;"><tr><td><label><input name="form-field-radio'+i+'" type="radio" class="ace" value="Daily" onclick="loaddetails(\'daily\', $(this))"><span class="lbl">&nbsp;Daily</span></label></td><td><label><input name="form-field-radio'+i+'" type="radio" class="ace" value="Weekly" onclick="loaddetails(\'weekly\', $(this))"><span class="lbl">&nbsp;Weekly</span></label></td><td><label><input name="form-field-radio'+i+'" type="radio" class="ace" value="Monthly" onclick="loaddetails(\'monthly\', $(this))"><span class="lbl">&nbsp;Monthly</span></label></td>  </tr><tr><td><label><input name="form-field-radio'+i+'" type="radio" class="ace" value="Quarterly" onclick="loaddetails(\'quarterly\', $(this))"><span class="lbl">&nbsp;Quarterly</span></label></td><td><label><input name="form-field-radio'+i+'" type="radio" class="ace" value="Biannually" onclick="loaddetails(\'biannually\', $(this))"><span class="lbl">&nbsp;Biannually</span></label></td><td><label><input name="form-field-radio'+i+'" type="radio" class="ace" value="Annually" onclick="loaddetails(\'annually\', $(this))"><span class="lbl">&nbsp;Annually</span></label></td></tr></table></div></div><br><div class="form-group row" style="margin-bottom: 5px;"><div class="col-md-12" style="font-weight: bold; font-size:15px;">Specify Day (when list will display)</div></div>  <div class="form-group row" style="margin-bottom: 5px;"><div class="col-md-4" style="padding-right:5px;"><select disabled class="form-control day non-daily weekly non-monthly non-quarterly non-biannually non-annually"><option value="Monday">Monday</option><option value="Tuesday">Tuesday</option><option value="Wednesday">Wednesday</option><option value="Thursday">Thursday</option><option value="Friday">Friday</option><option value="Saturday">Saturday</option><option value="Sunday">Sunday</option></select></div><div class="col-md-3" style="padding-right:5px;padding-left:5px;"><select disabled class="form-control spefday non-daily non-weekly monthly non-quarterly non-biannually non-annually"><option value="">day</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option></select></div><div class="col-md-5" style="padding-left:5px;"><input disabled class="form-control date-picker datesel non-daily non-weekly non-monthly quarterly biannually annually" type="text" name=""  data-provide="datepicker" placeholder="mm/dd/yyyy"></div></div><div class="form-group row" style="margin-bottom: 5px;"><div class="col-md-7" style="padding-right:5px;"></div><div class="col-md-5" style="padding-left:5px;"><input disabled class="form-control date-picker datesel2 non-daily non-weekly non-monthly quarterly biannually non-annually" type="text" name=""  data-provide="datepicker" placeholder="mm/dd/yyyy"></div></div><div class="form-group row" style="margin-bottom: 5px;"><div class="col-md-7" style="padding-right:5px;"></div><div class="col-md-5" style="padding-left:5px;"><input disabled class="form-control date-picker datesel3 non-daily non-weekly non-monthly quarterly non-biannually non-annually" type="text" name=""  data-provide="datepicker" placeholder="mm/dd/yyyy"></div></div> <div class="form-group row" style="margin-bottom: 5px;"><div class="col-md-7" style="padding-right:5px;"></div><div class="col-md-5" style="padding-left:5px;"><input disabled class="form-control date-picker datesel4 non-daily non-weekly non-monthly quarterly non-biannually non-annually" type="text" name=""  data-provide="datepicker" placeholder="mm/dd/yyyy"></div></div></div></div></div>';
   $( aff ).appendTo( "#div_tasklist" ); 
}

function savesetup(){
    var id = $("#njznc").val();
    var catname = $("#txtcatname").val();
    var days = $("#txtNotifDays").val();
    var all = "";
    var i=1;
    $("#div_tasklist .well").each(function(){
        var liTask = ($(this).find(".liTask")).val();
        var liDescription = ($(this).find(".liDescription")).val();
        var selected = ($(this).find("input[name='form-field-radio"+i+"'][type='radio']:checked")).val();
        var day = ($(this).find(".day")).val();
        var spefday = ($(this).find(".spefday")).val();
        var date = ($(this).find(".datesel")).val();
        var date2 = ($(this).find(".datesel2")).val();
        var date3 = ($(this).find(".datesel3")).val();
        var date4 = ($(this).find(".datesel4")).val();
        all += liTask+"|"+liDescription+"|"+selected+"|"+day+"|"+spefday+"|"+date+"-"+date2+"-"+date3+"-"+date4+"#";
        i++;
    })
    $.ajax({
        type: 'POST',
        url: 'setup/maintenance/mainclass.php',
        data: 'catname=' + catname + '&all=' + all + '&id=' + id + '&days=' + days + '&form=savesetup',
        success: function(data){
            if(data == "1"){
                $("#modal_inq_newlist").modal("hide");
                loadlist()
            }
        }
    })
}

function loaddetails(eto, eto_na){
    var hahxj = eto_na.closest( '.well' );
    hahxj.find("."+eto).prop("disabled", false);
    hahxj.find(".non-"+eto).prop("disabled", true);
    hahxj.find("."+eto).val("");
    hahxj.find(".non-"+eto).val("");
}

function editlist(id){
    $("#njznc").val(id);
    $.ajax({
        type: 'POST',
        url: 'setup/maintenance/mainclass.php',
        data: 'id=' + id + '&form=editlist',
        success: function(data){
            var arr = data.split("#");
            $("#txtcatname").val(arr[0]);
            var disp = "";
            var x = 1;
            for(var i = 1; i<=arr.length-2; i++){
                var arr2 = arr[i].split("|");
                var dateselected = arr2[5].split("/");

                if(arr2[2] == "Daily"){ 
                    var chkDaily = "checked"; 
                    var chkWeekly = ""; 
                    var daydis = "disabled"; 
                    var chkMonthly = ""; 
                    var monthdis = "disabled";
                    var chkQuarterly = ""; 
                    var enablemoto = "disabled";
                    var var1 = "";
                    var var2 = "";
                    var var3 = "";
                    var var4 = "";
                    var chkBiannually = ""; 
                    var enablemoto2 = "disabled";
                    var chkAnnually = ""; 
                    var enablemoto3 = "disabled";
                }else if(arr2[2] == "Weekly"){ 
                    var chkWeekly = "checked"; 
                    var daydis = ""; 
                    var chkMonthly = ""; 
                    var monthdis = "disabled";
                    var chkQuarterly = ""; 
                    var enablemoto = "disabled";
                    var var1 = "";
                    var var2 = "";
                    var var3 = "";
                    var var4 = "";
                    var chkBiannually = ""; 
                    var enablemoto2 = "disabled";
                    var chkAnnually = ""; 
                    var enablemoto3 = "disabled";
                }else if(arr2[2] == "Monthly"){ 
                    var chkMonthly = "checked"; 
                    var monthdis = ""; 
                    var chkDaily = ""; 
                    var chkWeekly = ""; 
                    var daydis = "disabled";
                    var chkQuarterly = ""; 
                    var enablemoto = "disabled";
                    var var1 = "";
                    var var2 = "";
                    var var3 = "";
                    var var4 = "";
                    var chkBiannually = ""; 
                    var enablemoto2 = "disabled";
                    var chkAnnually = ""; 
                    var enablemoto3 = "disabled";
                }else if(arr2[2] == "Quarterly"){ 
                    var chkQuarterly = "checked"; 
                    var enablemoto = "";
                    var var1 = " value='"+dateselected[0]+"'";
                    var var2 = " value='"+dateselected[1]+"'";
                    var var3 = " value='"+dateselected[2]+"'";
                    var var4 = " value='"+dateselected[3]+"'";
                    var chkDaily = ""; 
                    var chkWeekly = ""; 
                    var daydis = "disabled";
                    var chkMonthly = ""; 
                    var monthdis = "disabled";
                    var chkBiannually = ""; 
                    var enablemoto2 = "";
                    var chkAnnually = ""; 
                    var enablemoto3 = "";
                }else if(arr2[2] == "Biannually"){ 
                    var chkBiannually = "checked";
                    var enablemoto2 = "";
                    var var1 = " value='"+dateselected[0]+"'";
                    var var2 = " value='"+dateselected[1]+"'";
                    var var3 = "";
                    var var4 = ""; 
                    var chkDaily = ""; 
                    var chkWeekly = ""; 
                    var daydis = "disabled";
                    var chkMonthly = ""; 
                    var monthdis = "disabled";
                    var chkQuarterly = ""; 
                    var enablemoto = "disabled";
                    var chkAnnually = ""; 
                    var enablemoto3 = "";
                }else if(arr2[2] == "Annually"){ 
                    var chkAnnually = "checked"; 
                    var enablemoto3 = "";
                    var var1 = " value='"+dateselected[0]+"'";
                    var var2 = "";
                    var var3 = "";
                    var var4 = "";
                    var chkDaily = ""; 
                    var chkWeekly = ""; 
                    var daydis = "disabled";
                    var chkMonthly = ""; 
                    var monthdis = "disabled";
                    var chkQuarterly = ""; 
                    var enablemoto = "disabled";
                    var chkBiannually = ""; 
                    var enablemoto2 = "";
                }else{ 
                    var chkAnnually = ""; 
                    var enablemoto3 = "disabled";
                    var var1 = "";
                    var var2 = "";
                    var var3 = "";
                    var var4 = "";
                    var chkDaily = ""; 
                    var chkWeekly = ""; 
                    var daydis = "disabled";
                    var chkMonthly = ""; 
                    var monthdis = "disabled";
                    var chkQuarterly = ""; 
                    var enablemoto = "disabled";
                    var chkBiannually = ""; 
                    var enablemoto2 = "disabled";
                    var chkAnnually = ""; 
                    var enablemoto3 = "disabled";
                }

                var selectedmonths = arr2[3];

                disp += '<div class="well well-sm"><div class="form-group row"><div class="col-md-12"><div class="form-group row" style="margin-bottom: 5px;"><div class="col-md-5" style="font-weight: bold; font-size:15px;">Task List</div><div class="col-md-7"></div></div><div class="form-group row" style="margin-bottom: 5px;"><div class="col-md-12"><input type="text" class="form-control liTask" name="" placeholder="Task" value="'+arr2[0]+'"></div></div><div class="form-group row" style="margin-bottom: 5px;"><div class="col-md-12"><textarea class="form-control liDescription" placeholder="Description">'+arr2[1]+'</textarea></div></div><br><div class="form-group row" style="margin-bottom: 5px;"><div class="col-md-12" style="font-weight: bold; font-size:15px;">Period</div></div><div class="form-group row tblperiods" style="margin-bottom: 5px;"><div class="col-md-12"><table style="width: 100%;"><tr><td><label><input name="form-field-radio'+x+'" type="radio" class="ace" value="Daily" onclick="loaddetails(\'daily\', $(this))" '+chkDaily+'><span class="lbl">&nbsp;Daily</span></label></td><td><label><input name="form-field-radio'+x+'" type="radio" class="ace" value="Weekly" onclick="loaddetails(\'weekly\', $(this))" '+chkWeekly+'><span class="lbl">&nbsp;Weekly</span></label></td><td><label><input name="form-field-radio'+x+'" type="radio" class="ace" value="Monthly" onclick="loaddetails(\'monthly\', $(this))" '+chkMonthly+'><span class="lbl">&nbsp;Monthly</span></label></td>  </tr><tr><td><label><input name="form-field-radio'+x+'" type="radio" class="ace" value="Quarterly" onclick="loaddetails(\'quarterly\', $(this))" '+chkQuarterly+'><span class="lbl">&nbsp;Quarterly</span></label></td><td><label><input name="form-field-radio'+x+'" type="radio" class="ace" value="Biannually" onclick="loaddetails(\'biannually\', $(this))" '+chkBiannually+'><span class="lbl">&nbsp;Biannually</span></label></td><td><label><input name="form-field-radio'+x+'" type="radio" class="ace" value="Annually" onclick="loaddetails(\'annually\', $(this))" '+chkAnnually+'><span class="lbl">&nbsp;Annually</span></label></td></tr></table></div></div><br><div class="form-group row" style="margin-bottom: 5px;"><div class="col-md-12" style="font-weight: bold; font-size:15px;">Specify Day (when list will display)</div></div><div class="form-group row" style="margin-bottom: 5px;"><div class="col-md-4" style="padding-right:5px;"><select '+daydis+' class="form-control day non-daily weekly non-monthly non-quarterly non-biannually non-annually">'+selectedmonths+'</select></div><div class="col-md-3" style="padding-right:5px;padding-left:5px;"><select '+monthdis+' class="form-control spefday non-daily non-weekly monthly non-quarterly non-biannually non-annually">'+arr2[4]+'</select></div><div class="col-md-5" style="padding-left:5px;"><input '+enablemoto2+' '+enablemoto3+' '+var1+' class="form-control date-picker datesel non-daily non-weekly non-monthly quarterly biannually annually" type="text" name=""  data-provide="datepicker" placeholder="mm/dd/yyyy"></div></div><div class="form-group row" style="margin-bottom: 5px;"><div class="col-md-7" style="padding-right:5px;"></div><div class="col-md-5" style="padding-left:5px;"><input '+enablemoto2+' '+enablemoto3+' '+var2+' class="form-control date-picker datesel2 non-daily non-weekly non-monthly quarterly biannually non-annually" type="text" name=""  data-provide="datepicker" placeholder="mm/dd/yyyy"></div></div><div class="form-group row" style="margin-bottom: 5px;"><div class="col-md-7" style="padding-right:5px;"></div><div class="col-md-5" style="padding-left:5px;"><input '+enablemoto+' '+enablemoto2+' '+enablemoto3+' '+var3+' class="form-control date-picker datesel3 non-daily non-weekly non-monthly quarterly non-biannually non-annually" type="text" name=""  data-provide="datepicker" placeholder="mm/dd/yyyy"></div></div> <div class="form-group row" style="margin-bottom: 5px;"><div class="col-md-7" style="padding-right:5px;"></div><div class="col-md-5" style="padding-left:5px;"><input '+enablemoto+' '+enablemoto2+' '+enablemoto3+' '+var3+' class="form-control date-picker datesel4 non-daily non-weekly non-monthly quarterly non-biannually non-annually" type="text" name=""  data-provide="datepicker" placeholder="mm/dd/yyyy"></div></div></div></div></div>';
                x++;
            }
            $("#div_tasklist").html(disp);
            $("#modal_inq_newlist").modal("show");
        }
    })  
}

function deletethisline(xtask){
    $.ajax({
        type: 'POST',
        url: 'setup/maintenance/mainclass.php',
        data: 'xtask=' + xtask + '&form=deletethisline',
        success:function(data){
            setTimeout(function(){
                showmodal("alert", data, "loadlist", null, "", null, "0");
            }, 1000)
        }
    })
}

function deletethisbox(mainid){
    $.ajax({
        type: 'POST',
        url: 'setup/maintenance/mainclass.php',
        data: 'mainid=' + mainid + '&form=deletethisbox',
        success:function(data){
            setTimeout(function(){
                showmodal("confirm", "Are you sure you want to delete "+data+" ?", "deletethisbox2", mainid+"|", "", null, "0");
            }, 1000)
        }
    })
}

function deletethisbox2(mainid){
    $.ajax({
        type: 'POST',
        url: 'setup/maintenance/mainclass.php',
        data: 'mainid=' + mainid + '&form=deletethisbox2',
        success:function(data){
            setTimeout(function(){
                showmodal("alert", data, "loadlist", null, "", null, "0");
            }, 1000)
        }
    })
}

function showmaincat(){
    $.ajax({
        type: 'POST',
        url: 'setup/maintenance/mainclass.php',
        data: 'form=showmaincat',
        success:function(data){
            $("#txtcatname").html(data);
        }
    })
}

function checkmaintype(catid){
    $.ajax({
        type: 'POST',
        url: 'setup/maintenance/mainclass.php',
        data: 'catid=' + catid + '&form=checkmaintype',
        success:function(data){
            if(data == "Preventive"){
                $("#isPreventive").css("display", "block");
            }else{
                $("#isPreventive").css("display", "none");
            }
        }
    })
}
</script>