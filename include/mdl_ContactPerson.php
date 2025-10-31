<div class="modal fade fade-scale" role="dialog" id="edit_contactperson_modal">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" style="font-size: 18px;">Contact Person</h4>
			</div>
			<div class="modal-body">
            <input type="hidden" id="div_type_id">
				<div class="row form-group" style="display: block;">					
                    <div class="col-xs-12 col-md-6">
                        <div class="row form-group">
                            <div class="col-md-12">
                                <label>
                                    <input name="form-field-checkbox" type="checkbox" class="ace" id="chkCPAsPrimary">
                                    <span class="lbl"> Set as primary</span>
                                </label>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-xs-12 col-md-12">
                                Status
                            </div>
                            <div class="col-md-4">
                                <label>
                                    <input name="form-field-checkbox" type="radio" class="ace rdCPContactStat" value="Active" checked id="chkContactStatActive">
                                    <span class="lbl"> Active</span>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label>
                                    <input name="form-field-checkbox" type="radio" class="ace rdCPContactStat" value="Inactive">
                                    <span class="lbl"> Inactive</span>
                                </label>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-xs-12 col-md-12">
                                First Name
                            </div>
                            <div class="col-xs-12 col-md-12">
                                <input type="text" class="form-control" placeholder="First Name" id="txtcontact_fname_update">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-xs-12 col-md-12">
                                Middle Name
                            </div>
                            <div class="col-xs-12 col-md-12">
                                <input type="text" class="form-control" placeholder="Middle Name" id="txtcontact_mname_update">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-xs-12 col-md-12">
                                Last Name
                            </div>
                            <div class="col-xs-12 col-md-12">
                                <input type="text" class="form-control" placeholder="Last Name" id="txtcontact_lname_update">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-xs-12 col-md-12">
                                Address
                            </div>
                            <div class="col-xs-12 col-md-12">
                                <input type="text" style="background-color: white !important;" class="form-control home-address" id="txtcontact_address_update" onclick="loadaddressmodal(&quot;txtcontact_address_update&quot;)" onkeyup="loadaddressmodal('txtcontact_address_update')" placeholder="Click to add address..." readonly="">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-xs-12 col-md-12">
                                Company Position
                            </div>
                            <div class="col-xs-12 col-md-12">
                                <div class="input-group">
                                    <select class="form-control slctPosition" id="txtcontact_designation_update"></select>
                                    <div class="spinbox-buttons input-group-btn">         
                                      <button type="button" class="btn spinbox-up btn-sm btn-success" onclick="fncAddPosition()">
                                        <i class="icon-only  ace-icon ace-icon fa fa-plus bigger-110"></i>          
                                      </button>       
                                    </div>
                                </div>
                            </div>
                        </div>                        
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="row form-group">
                            <div class="col-md-12 col-xs-12">
                                <div class="image">
                                    <img class="img-thumbnail imageName form-control" src="assets/images/noimage5.png" id="imgtradeaccount_update" style="border: 2px solid #bdc3c7; margin-bottom: 8px;height: 178px;">
                                </div>
                                <form name="posting_profilepic_contactperson" id="posting_profilepic_contactperson" >
                                  <div style="display: none;"><input type="text" id="Bill_hidden_custid_update" name="contactID"><input type="text" id="Bill_hidden_custid_update_company" name="companyID"></div>
                                    <input id="file_upload_trade_update" name="file_upload_trade_update" class="form-control upload" type="file" onchange="showimgtrade_update();" accept="image/*"/>
                                </form>
                            </div>
                        </div>                        
                        <div class="row form-group">
                            <div class="col-xs-12 col-md-12">
                                Email Address
                            </div>
                            <div class="col-xs-12 col-md-12" id="div_add_contact_person_email_update"></div>
                        </div>
                        <div class="row form-group">
                            <div class="col-xs-12 col-md-12">
                                Mobile No
                            </div>
                            <div class="col-xs-12 col-md-12" id="div_add_contact_person_mobile_update"></div>
                        </div>
                        <div class="row form-group">
                            <div class="col-xs-12 col-md-12">
                                Telephone No
                            </div>
                            <div class="col-xs-12 col-md-12" id="div_add_contact_person_tele_update"></div>
                        </div>                        
                    </div>
                </div>
			</div>
			<div class="modal-footer" id="">
				<button type="button" class="btn btn-sm btn-primary btn-round" id="btn_savecontactperson" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving..."><i class="ace-icon fa fa-check"></i>&nbsp;Save</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(function(){
		loadcompanyposition_update();
	});

	function editthiscontactperson(idnum, comid){
        $("#btn_savecontactperson").button("reset");
        $("#Bill_hidden_custid_update").val("");
        $("#Bill_hidden_custid_update_company").val("");
        $("#btn_savecontactperson").attr("onclick", "savecontactperson_update(\""+idnum+"\", \""+comid+"\")");
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'id=' + idnum + '&form=editthiscontactperson',
			success: function(data){
				var arr = data.split("|");
				$("#edit_contactperson_modal").modal("show");
				$("#txtcontact_fname_update").val(arr[0]);
				$("#txtcontact_mname_update").val(arr[1]);
				$("#txtcontact_lname_update").val(arr[2]);
				$("#txtcontact_designation_update").val(arr[3]);
				$("#txtcontact_address_update").val(arr[4]);	
                $("#imgtradeaccount_update").attr("src", arr[5]);
                if(arr[6] == "1"){
                    $("#chkCPAsPrimary").prop("checked", true);
                }else{
                    $("#chkCPAsPrimary").prop("checked", false);
                }
                var isActive = "";
                if(arr[7] == '1'){
                    isActive = "Active";
                }else{
                    isActive = "Inactive";
                }
                $(".rdCPContactStat").each(function(){
                    if($(this).val() == isActive){
                        $(this).prop("checked", true);
                    }
                })
			}, complete: function(){
                autotrapfields();
            }
		});

		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'id=' + idnum + '&form=editthiscontactperson_contacts',
			success: function(data){
                var arr = data.split("#|")
				$("#div_add_contact_person_email_update").html(arr[0]);
                $("#div_add_contact_person_mobile_update").html(arr[1]);
                $("#div_add_contact_person_tele_update").html(arr[2]);
			}
		});
    }

    function savecontactperson_update(idnum, comID){
        $("#btn_savecontactperson").button("loading");
        var fname_update = $("#txtcontact_fname_update").val();
        var mname_update = $("#txtcontact_mname_update").val();
        var lname_update = $("#txtcontact_lname_update").val();
        var designation_update = $("#txtcontact_designation_update").val();
        var address_update = $("#txtcontact_address_update").val();
        var isPrimary = "";
        $("#chkCPAsPrimary").each(function(){
            if($(this).is(":checked")){
                isPrimary = "1";
            }else{
                isPrimary = "0";
            }
        })
        var isActive = "";
        $(".rdCPContactStat").each(function(){
            if($(this).is(":checked")){
                if($(this).val() == "Active"){
                    isActive = "1";
                }else{
                    isActive = "0";
                }
            }
        })
        $.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'id=' + idnum + '&fname=' + fname_update + '&mname=' + mname_update + '&lname=' + lname_update + '&designation=' + designation_update + '&add=' + address_update + '&isPrimary=' + isPrimary + '&isActive=' + isActive + '&BillerID=' + comID + '&form=savecontactperson_update',
            success: function(data){
                $("#btn_savecontactperson").button("reset");
                if(data == 1){
                    showmodal("alert", "Successfully Modified.", "", null, "", null, "0");
                }
            }
        });

        var div_add_contact_person_email_update = "";
        $("#div_add_contact_person_email_update input").each(function(){
            var this_value = $(this).val();
            if (!this_value.match(/^\s*$/) || this_value != ""){
                div_add_contact_person_email_update += this_value + "|";                    
            }
        });
        var div_add_contact_person_mobile_update = "";
        $("#div_add_contact_person_mobile_update input").each(function(){
            var this_value = $(this).val();  
            if (!this_value.match(/^\s*$/) || this_value != ""){
                div_add_contact_person_mobile_update += this_value + "|";       
            }   
        });
        var div_add_contact_person_tele_update = "";
        $("#div_add_contact_person_tele_update input").each(function(){
            var this_value = $(this).val(); 
            if (!this_value.match(/^\s*$/) || this_value != ""){
                div_add_contact_person_tele_update += this_value + "|"; 
            }  
        });
        $.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'id=' + idnum + '&email_update=' + div_add_contact_person_email_update + '&mobile_number=' + div_add_contact_person_mobile_update + '&tel_number=' + div_add_contact_person_tele_update + '&form=savecontactperson_update_contactnum',
            success: function(data){
                
            }
        });
        $("#Bill_hidden_custid_update").val(idnum);
        $("#Bill_hidden_custid_update_company").val(comID);
        var data = new FormData($('#posting_profilepic_contactperson')[0]);
        $.ajax({
            type: 'POST',
            url: 'Uploads/update_contact_profilepic.php',
            data: data,
            mimeType: 'multipart/form-data',
            contentType: false,
            cache: false,
            processData: false,
            success:function(data){
                loadexistingcontactpersons(comID)
            }
        });
    }

    function loadexistingcontactpersons(idcomp){
        var div = $("#div_type_id").val();
        $.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'companyID=' + idcomp + '&form=selectcontactpersons',
            success: function(data){
                $("#"+div).html(data);
            }, complete: function(){
                $("#edit_contactperson_modal").modal("hide");
            }
        })
    }

    function setvaluediv(){
        $("#div_type_id").val("div_inquiry_contact_person");
    }

    function showimgtrade_update(){
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("file_upload_trade_update").files[0]);

        oFReader.onload = function (oFREvent) {
            document.getElementById("imgtradeaccount_update").src = oFREvent.target.result;
        };
    }

	function loadcompanyposition_update(){
	    $.ajax({
	        type: 'POST',
	        url: 'mainclass.php',
	        data: 'form=loadcompanyposition',
	        success: function(data){
	            $("#txtcontact_designation_update").html(data);
	        }
	    })
	}
</script>