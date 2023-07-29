<div class="modal fade fade-scale" id="modal_new_remarks" role="dialog" area-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md" style="margin-top: 10%;">   
        <div class="modal-content">
            <div class="modal-body">
            <button type="button" class="close" onclick="closenewremarkmodal()">&times;</button>
            <h4 class="modal-title" id="remtext_cont">New Remarks</h4>
            <input type="hidden" id="txtremID">
            <div class="row form-group" style="margin-top: 15px;">
                <div class="col-xs-12">
                    <textarea class="form-control" id="txtinq_remarks2" style="height: 100px;margin-bottom: 10px;"></textarea>
                    <button class="btn btn-info btn-sm btn-round" id="btn_savenewremark" style="float: right;" onclick="savenewremark()"><i class="ace-icon fa fa-check"></i>&nbsp;Save</button>
                </div>
            </div>
            </div>
        </div>
    </div>
</div> 

<script type="text/javascript">
    $(function(){
        $('#modal_new_remarks').on('shown.bs.modal', function() {
            $('#txtinq_remarks2').focus();
        })
        $("#btn_savenewremark").keydown(function(e){
            var x = e.keyCode;
            if(x == 13){ 
                $("#btn_savenewremark").click(); 
            }
        });
    })

    function loadremakrs(ids){
        $.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'id=' + ids + '&form=loadremakrs',
            success: function(data){
                $("#remarkslist_ol").html(data);
            }
        })
    }

    function addnewremarks(){
        $("#modal_new_remarks").modal("show");
        $("#txtinq_remarks2").val("");
        $("#txtremID").val("");
        $("#remtext_cont").text("New Remarks");
    }

    function closenewremarkmodal(){
        $("#modal_new_remarks").modal("hide");
    }

    function savenewremark(inqID){
        var remID = $("#txtremID").val();
        var remarks = $("#txtinq_remarks2").val();
        if(remarks != "" && !remarks.match(/^\s*$/)){
            $.ajax({
                type: 'POST',
                url: 'mainclass.php',
                data: 'inqID=' + inqID + '&remID=' + remID + '&remarks=' + remarks + '&form=savenewremark',
                success: function(data){
                    if(data == 1){
                        setTimeout(function(){
                            showmodal("alert", "Successfully added new remarks.", "loadremakrs", inqID+"|", "", null, "0");
                        }, 500)
                    }else if(data == 2){
                        setTimeout(function(){
                            showmodal("alert", "Successfully updated remarks.", "loadremakrs", inqID+"|", "", null, "0");
                        }, 500)
                    }else{
                        setTimeout(function(){
                            showmodal("alert", "An error occured.", "", null, "", null, "1");
                        }, 500)
                    }
                    $("#txtinq_remarks2").attr("style", "height: 100px;margin-bottom: 10px;border-color:#D5D5D5;");
                    $("#modal_new_remarks").modal("hide");
                }
            })       
        }else{
            setTimeout(function(){
                showmodal("alert", "Please enter remarks first.", "makefocus", null, "", null, "1");
            }, 500)
            $("#txtinq_remarks2").attr("style", "height: 100px;margin-bottom: 10px;border-color:#f2a696;");
        } 
    }

    function makefocus(){ 
        $("#txtinq_remarks2").focus(); 
    }

    function edittranremarks(remID, inqID){
        $("#remtext_cont").text("Update Remarks");
        $("#txtremID").val(remID);
        $.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'remID=' + remID + '&form=edittranremarks',
            success: function(data){
                $("#txtinq_remarks2").val(data);
                $("#modal_new_remarks").modal("show");
            }
        })
    }

    function deletetranremarks(remID, inqID){
        setTimeout(function(){
            showmodal("confirm", "Are you sure you want to delete this remarks? Click \"OK\" to proceed.", "proceed_deletetranremarks", remID+"|"+inqID+"|", "", null, "0");
        }, 500)
    }

    function proceed_deletetranremarks(remID, inqID){
        $.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'remID='+remID+'&form=deletetranremarks',
            success: function(data){
                if(data == 1){
                    setTimeout(function(){
                        showmodal("alert", "Successfully Deleted.", "loadremakrs", inqID+"|", "", null, "0");
                    }, 500)
                }
            }
        })
    }
</script>