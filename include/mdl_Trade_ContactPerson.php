<div class="modal fade fade-scale" role="dialog" id="edit_trade_contactperson_modal">
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
                                    <input name="form-field-checkbox" type="checkbox" class="ace" id="chkContactCPAsPrimary">
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
                                    <input name="form-field-checkbox" type="radio" class="ace rdContactCPContactStat" value="Active" checked id="chkContactStatActive">
                                    <span class="lbl"> Active</span>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label>
                                    <input name="form-field-checkbox" type="radio" class="ace rdContactCPContactStat" value="Inactive">
                                    <span class="lbl"> Inactive</span>
                                </label>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-xs-12 col-md-12">
                                First Name
                            </div>
                            <div class="col-xs-12 col-md-12">
                                <input type="text" class="form-control" placeholder="First Name" id="txttrade_fname_update">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-xs-12 col-md-12">
                                Middle Name
                            </div>
                            <div class="col-xs-12 col-md-12">
                                <input type="text" class="form-control" placeholder="Middle Name" id="txttrade_mname_update">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-xs-12 col-md-12">
                                Last Name
                            </div>
                            <div class="col-xs-12 col-md-12">
                                <input type="text" class="form-control" placeholder="Last Name" id="txttrade_lname_update">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-xs-12 col-md-12">
                                Address
                            </div>
                            <div class="col-xs-12 col-md-12">
                                <input type="text" style="background-color: white !important;" class="form-control home-address" id="txttrade_address_update" onclick="loadaddressmodal(&quot;txttrade_address_update&quot;)" onkeyup="loadaddressmodal('txttrade_address_update')" placeholder="Click to add address..." readonly="">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-xs-12 col-md-12">
                                Company Position
                            </div>
                            <div class="col-xs-12 col-md-12">
                                <div class="input-group">
                                    <select class="form-control slctPosition" id="txttrade_designation_update"></select>
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
                                    <img class="img-thumbnail imageName form-control" src="assets/images/noimage5.png" id="imgtradecontact_update" style="border: 2px solid #bdc3c7; margin-bottom: 8px;height: 178px;">
                                </div>
                                <form name="posting_tradeprofilepic_contactperson" id="posting_tradeprofilepic_contactperson" >
                                    <div style="display: none;">
                                        <input type="text" id="trade_hidden_custid_update" name="txtcon_id">
                                        <input type="text" id="trade_hidden_custid_update_trade" name="txtcon_trade">
                                        <input type="text" name="txtcon_compid" id="trade_hidden_custid_update_company">
                                    </div>
                                    <input id="file_upload_trade_update_contact" name="attachment_profilepic" class="form-control upload" type="file" onchange="showimgtrade_updatecontact();" accept="image/*"/>
                                </form>
                            </div>
                        </div>                        
                        <div class="row form-group">
                            <div class="col-xs-12 col-md-12">
                                Email Address
                            </div>
                            <div class="col-xs-12 col-md-12" id="div_add_trade_contact_person_email_update"></div>
                        </div>
                        <div class="row form-group">
                            <div class="col-xs-12 col-md-12">
                                Mobile No
                            </div>
                            <div class="col-xs-12 col-md-12" id="div_add_trade_contact_person_mobile_update"></div>
                        </div>
                        <div class="row form-group">
                            <div class="col-xs-12 col-md-12">
                                Telephone No
                            </div>
                            <div class="col-xs-12 col-md-12" id="div_add_trade_contact_person_tele_update"></div>
                        </div>                        
                    </div>
                </div>
			</div>
			<div class="modal-footer" id="">
				<button type="button" class="btn btn-sm btn-primary btn-round" id="btn_savetradecontactperson" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving..."><i class="ace-icon fa fa-check"></i>&nbsp;Save</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(function(){
		loadcompanyposition_update();
	});

	function edittradecontactperson(ContactID, TradeID, CompanyID){
        $("#btn_savetradecontactperson").button("reset");
        $("#trade_hidden_custid_update").val("");
        $("#trade_hidden_custid_update_trade").val("");
        $("#btn_savetradecontactperson").attr("onclick", "savetradecontactperson_update(\""+ ContactID +"\", \""+ TradeID +"\", \""+ CompanyID +"\")");
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'id=' + ContactID + '&form=edittradecontactperson',
			success: function(data){
				var arr = data.split("|");
				$("#edit_trade_contactperson_modal").modal("show");
				$("#txttrade_fname_update").val(arr[0]);
				$("#txttrade_mname_update").val(arr[1]);
				$("#txttrade_lname_update").val(arr[2]);
				$("#txttrade_designation_update").val(arr[3]);
				$("#txttrade_address_update").val(arr[4]);	
                $("#imgtradecontact_update").attr("src", arr[5]);
                if(arr[6] == "1"){
                    $("#chkContactCPAsPrimary").prop("checked", true);
                }else{
                    $("#chkContactCPAsPrimary").prop("checked", false);
                }
                var isActive = "";
                if(arr[7] == "1"){
                    isActive = "Active";
                }else{
                    isActive = "Inactive";
                }
                $(".rdContactCPContactStat").each(function(){
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
			data: 'id=' + ContactID + '&form=edittradecontactperson_contacts',
			success: function(data){
                var arr = data.split("#|")
				$("#div_add_trade_contact_person_email_update").html(arr[0]);
                $("#div_add_trade_contact_person_mobile_update").html(arr[1]);
                $("#div_add_trade_contact_person_tele_update").html(arr[2]);
			}
		});
    }

    function savetradecontactperson_update(ContactID, TradeID, CompanyID){
        $("#btn_savetradecontactperson").button("loading");
        var fname_update = $("#txttrade_fname_update").val();
        var mname_update = $("#txttrade_mname_update").val();
        var lname_update = $("#txttrade_lname_update").val();
        var designation_update = $("#txttrade_designation_update").val();
        var address_update = $("#txttrade_address_update").val();
        var isPrimary = "";
        $("#chkContactCPAsPrimary").each(function(){
            if($(this).is(":checked")){
                isPrimary = "1";
            }else{
                isPrimary = "0";
            }
        })
        var isActive = "";
        $(".rdContactCPContactStat").each(function(){
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
            data: 'id=' + ContactID + '&fname=' + fname_update + '&mname=' + mname_update + '&lname=' + lname_update + '&designation=' + designation_update + '&add=' + address_update + '&isPrimary=' + isPrimary + '&isActive=' + isActive + '&TradeID=' + TradeID + '&form=savetradecontactperson_update',
            success: function(data){
                $("#btn_savetradecontactperson").button("reset");
                if(data == 1){
                    showmodal("alert", "Successfully Modified.", "loadAgainTradeContactList", TradeID+"|", "", null, "0");
                }
            }, complete: function(){
                fncUpdateContactImage();
            }
        });

        var div_add_trade_contact_person_email_update = "";
        $("#div_add_trade_contact_person_email_update input").each(function(){
            var this_value = $(this).val();
            if (!this_value.match(/^\s*$/) || this_value != ""){
                div_add_trade_contact_person_email_update += this_value + "|";                    
            }
        });
        var div_add_trade_contact_person_mobile_update = "";
        $("#div_add_trade_contact_person_mobile_update input").each(function(){
            var this_value = $(this).val();  
            if (!this_value.match(/^\s*$/) || this_value != ""){
                div_add_trade_contact_person_mobile_update += this_value + "|";       
            }   
        });
        var div_add_trade_contact_person_tele_update = "";
        $("#div_add_trade_contact_person_tele_update input").each(function(){
            var this_value = $(this).val(); 
            if (!this_value.match(/^\s*$/) || this_value != ""){
                div_add_trade_contact_person_tele_update += this_value + "|"; 
            }  
        });
        $.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'id=' + ContactID + '&email_update=' + div_add_trade_contact_person_email_update + '&mobile_number=' + div_add_trade_contact_person_mobile_update + '&tel_number=' + div_add_trade_contact_person_tele_update + '&form=savetradecontactperson_update_contactnum',
            success: function(data){
                
            }
        });
        $("#trade_hidden_custid_update").val(ContactID);
        $("#trade_hidden_custid_update_trade").val(TradeID);
        $("#trade_hidden_custid_update_company").val(CompanyID);
    }

    function fncUpdateContactImage(){
        var frmdata = new FormData($('#posting_tradeprofilepic_contactperson')[0]);
        $.ajax({
            type: 'POST',
            url: 'Uploads/upload_trade_contact.php',
            data: frmdata,
            mimeType: 'multipart/form-data',
            contentType: false,
            cache: false,
            processData: false,
            success:function(data){

            }
        });
    }

    function loadAgainTradeContactList(TradeID){
        $.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'id=' + TradeID + '&form=load_updatetrade_contactpersons',
            success: function(data) {
                $("#div_Trade_contact_person_list").html(data);
            }, complete: function(){
                $("#edit_trade_contactperson_modal").modal("hide");
            }
        })
    }


    function setvaluediv(){
        $("#div_type_id").val("div_inquiry_contact_person");
    }

    function showimgtrade_updatecontact(){
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("file_upload_trade_update_contact").files[0]);

        oFReader.onload = function (oFREvent) {
            document.getElementById("imgtradecontact_update").src = oFREvent.target.result;
        };
    }

	function loadcompanyposition_update(){
	    $.ajax({
	        type: 'POST',
	        url: 'mainclass.php',
	        data: 'form=loadcompanyposition',
	        success: function(data){
	            $("#txttrade_designation_update").html(data);
	        }
	    })
	}
</script>