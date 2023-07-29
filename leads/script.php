<script type="text/javascript">
	$(function(){
    	$(".fixTable").tableHeadFixer();
    	$("#browseProspectsPageCount").val("1");
	    $('.input-mask-phone').mask('(999) 999-9999');
    	 $(".input-mask-tele").on('keypress', function (event) {
        var regex = new RegExp("^[-+() 0-9]+");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
            if (!regex.test(key)) {
                event.preventDefault();
                return false;
            }
        });
    	$('.date-picker').datepicker({
	        autoclose: true,
	        todayHighlight: true,
	        format:"mm/dd/yyyy"
	    })
	    $('[data-rel=tooltip]').tooltip();
    	$('[data-rel=popover]').popover({html:true});
    	var date = new Date();
		date.setDate(date.getDate() - 0);
		$('.jonas-date-picker').datepicker({
		    autoclose: true,
		    todayHighlight: true,
		    format: 'mm/dd/yyyy',
		    startDate: date
		});
		leadpositions();
		leademployee();
		$("#txtsearchprospectlist").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				browseProspects(); 
			}else if ( x == '8' ){
				if($('#txtsearchprospectlist').val() == ""){
					browseProspects();
				}
			}
		});
	})

	function ShowAddNewLeads(){
		var module = "<?php echo $_GET['type']; ?>";
		$(".tblSubLeads").css("display", "none");
		if(module == "prospects"){
			$("#div_browseProspectlist").css("display", "none");
			$("#div_SubLeadsTAB").css("display", "none");
		}else{
			$("#div_SubLeadsTAB").css("display", "block");
			$("#div_browseProspectlist").css("display", "block");
			$("#leads_SubLeadsAttachment").html("<div class='col-md-12'><input type='file' class='leadsattachment' name='leadsattachment1'></div>");
		}
        $("#clicktoshowall").prop("checked", false);
        $(".clicktoshowall").each(function(){
        	var id = this.id;
            if($("#"+id+" i").hasClass("fa fa-chevron-up")){
                $("#"+id).click();
            }
        })
		$("#AddNewLeads").modal("show");
		trapinputfields();
		leadpositions();
		leademployee();
		$("#div_inquiry_contact_numbers").html('<center><img src="assets/images/phone-receiver.png" style="margin: 20px;height: 120px; width: 120px;"><h3>No contacts yet.</h3></center>');
		$("#div_inquiry_contact_person").html('<center><img src="assets/images/network.png" style="margin: 20px;height: 120px; width: 120px;"><h3>No contact persons yet.</h3></center>');
		$("#leads_attachment").html("<div class='col-md-12'><input type='file' class='leadsattachment' name='leadsattachment1'></div>");
		$('.leadsattachment').ace_file_input({
			no_file:'No File ...',
			btn_choose:'Choose',
			btn_change:'Change',
			droppable:false,
			onchange:null,
			thumbnail:false //| true | large
		});
		$("#leadsattachmentcount").val("1");
		$("#leadsSubLeadsttachmentcount").val("1");
		$(".btnLeadtoInquiry").css("display", "none");
		$(".DisMe").prop("disabled", false);
       	$(".LeadsReq").css("border-color", "#b5b5b5");
	}

	function editleads(leadsid, status, tradeID, companyID, SubLeadsID){
		var xmodule = "<?php echo $_GET['type']; ?>";
		if(xmodule == "prospects"){
			$("#div_browseProspectlist").css("display", "none");
			$("#div_SubLeadsTAB").css("display", "none");
			$(".tblSubLeads").css("display", "block");
			$.ajax({
				type: 'POST',
				url: 'leads/class.php',
				data: 'leadsid=' + leadsid + '&form=tblAwarenessList',
				success:function(data){
					$("#tblAwarenessList").html(data);
				}
			})
			$.ajax({
				type: 'POST',
				url: 'leads/class.php',
				data: 'leadsid=' + leadsid + '&form=tblReferralList',
				success:function(data){
					$("#tblReferralList").html(data);
				}
			})
			$.ajax({
				type: 'POST',
				url: 'leads/class.php',
				data: 'leadsid=' + leadsid + '&form=tblDemoList',
				success:function(data){
					$("#tblDemoList").html(data);
				}
			})
			$.ajax({
				type: 'POST',
				url: 'leads/class.php',
				data: 'leadsid=' + leadsid + '&form=tblCLMList',
				success:function(data){
					$("#tblCLMList").html(data);
				}
			})
			$.ajax({
				type: 'POST',
				url: 'leads/class.php',
				data: 'leadsid=' + leadsid + '&form=tblCOSList',
				success:function(data){
					$("#tblCOSList").html(data);
				}
			})
		}else{
			$(".tblSubLeads").css("display", "none");
			$("#div_SubLeadsTAB").css("display", "block");
			$("#div_browseProspectlist").css("display", "block");
			$("#leads_SubLeadsAttachment").html("<div class='col-md-12'><input type='file' class='leadsattachment' name='leadsattachment1'></div>");
			$("#frmSubLeadsID").val(leadsid);
			$("#frmSubLeadsModuleID").val(SubLeadsID);
			$.ajax({
				type: 'POST',
				url: 'leads/class.php',
				data: 'module=' + xmodule + '&SubLeadsID=' + SubLeadsID + '&leadsid=' + leadsid + '&form=EditSubLeads',
				success:function(data){
					var arr = data.split("|");
					$("#txtSubLeadsSubject").val(arr[0]);
					$("#txtSubLeadsDetails").val(arr[1]);
					$("#leads_SubLeadsAttachment").html(arr[2]);
					trapinputfields();
				}
			})
		}
		selecttenant(companyID, tradeID);
		$("#clicktoshowall").prop("checked", false);
        $(".clicktoshowall").each(function(){
        	var id = this.id;
            if($("#"+id+" i").hasClass("fa fa-chevron-up")){
                $("#"+id).click();
            }
        })
		$("#AddNewLeads").modal("show");
       	$(".LeadsReq").css("border-color", "#b5b5b5");
		$("#frmLeadsID").val(leadsid);
		$("#leadsattachmentcount").val("1");
		$("#leadsSubLeadsttachmentcount").val("1");
		$.ajax({
			type: 'POST',
			url: 'leads/class.php',
			data: 'leadsid=' + leadsid + ' &form=editleadsinfo',
			success:function(data){
				var arr = data.split("|");
				$("#txtLeadsName").val(arr[0]);
				$("#txtLeadsCompany").val(arr[1]);
				$("#txtLeadsPosition").val(arr[2])
				$("#txtLeadsAssignedPerson").val(arr[3]);
				$("#txtLeadsFN").val(arr[4]);
				$("#txtLeadsMN").val(arr[5]);
				$("#txtLeadsLN").val(arr[6]);
				$("#txtLeadsRemarks").val(arr[7]);
				$("#txtLeadsSource").val(arr[8]);
				
				$("#leads_attachment").html(arr[9]);
				trapinputfields();
			}, complete(){
				if(status == "Cancelled" || status == "Junked"){
					$(".DisMe").prop("disabled", true);
				}else{
					$(".DisMe").prop("disabled", false);
				}
			}
		})
	}

	function appendleadsattachment(){
    	var count = $("#leadsattachmentcount").val();
		count = Number(count) + 1;
		$("#leads_attachment").append("<div class='col-md-12'><input type='file' class='leadsattachment' name='leadsattachment"+count+"'></div>");
		$('.leadsattachment').ace_file_input({
			no_file:'No File ...',
			btn_choose:'Choose',
			btn_change:'Change',
			droppable:false,
			onchange:null,
			thumbnail:false //| true | large
		});
		$("#leadsattachmentcount").val(count);
    }

    function appendAWAleadsattachment(){
    	var count = $("#leadsSubLeadsttachmentcount").val();
		count = Number(count) + 1;
		$("#leads_SubLeadsAttachment").append("<div class='col-md-12'><input type='file' class='leadsattachment' name='leadsattachment"+count+"'></div>");
		$('.leadsattachment').ace_file_input({
			no_file:'No File ...',
			btn_choose:'Choose',
			btn_change:'Change',
			droppable:false,
			onchange:null,
			thumbnail:false //| true | large
		});
		$("#leadsSubLeadsttachmentcount").val(count);
    }

	function leadpositions(){
		$.ajax({
			type: 'POST',
			url: 'leads/prospects/class.php',
			data: 'form=leadpositions',
			success:function(data){
				$("#txtLeadsPosition").html(data);
			}
		})
	}

	function leademployee(){
		$.ajax({
			type: 'POST',
			url: 'leads/prospects/class.php',
			data: 'form=leademployee',
			success:function(data){
				$("#txtLeadsAssignedPerson").html(data);
			}
		})
	}

	function trapinputfields(){
	    $('.input-mask-phone').mask('(999) 999-9999');
    	$(".input-mask-tele").on('keypress', function (event) {
        var regex = new RegExp("^[-+() 0-9]+");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
            if (!regex.test(key)) {
                event.preventDefault();
                return false;
            }
        });
    	$('.date-picker').datepicker({
	        autoclose: true,
	        todayHighlight: true,
	        format:"mm/dd/yyyy"
	    })
	    $('.leadsattachment').ace_file_input({
			no_file:'No File ...',
			btn_choose:'Choose',
			btn_change:'Change',
			droppable:false,
			onchange:null,
			thumbnail:false //| true | large
		});
	}    

    function clicktoshowall(){
		$("#clicktoshowall").each(function(){
			if($(this).is(":checked")){
				$(".clicktoshowall").each(function(){
        			var id = this.id;
					if($("#"+id +" i").hasClass("fa fa-chevron-down")){
						$("#"+id).click();
					}
				})
			}else{
				$(".clicktoshowall").click();
			}
		})
	}

	function btnSaveLeads(){
		var lmodule = "<?php echo $_GET['type']; ?>";
        var leadsID = $("#frmLeadsID").val();
		var SubLeadsID = $("#frmSubLeadsModuleID").val();
		var CompanyID = $("#NewLeadsTradeID").val();
		var TradeID = $("#NewLeadsCompanyID").val();
        var LeadsName = $("#txtLeadsName").val();
		var Position = $("#txtLeadsPosition").val();
		var AssignedPerson = $("#txtLeadsAssignedPerson").val();
		var Company = $("#txtLeadsCompany").val();
		var FirstName = $("#txtLeadsFN").val();
		var MiddleName = $("#txtLeadsMN").val();
		var LastName = $("#txtLeadsLN").val();
		var Remarks = $("#txtLeadsRemarks").val();
		var Source = $("#txtLeadsSource").val();
		var SubLeadsSubject = $("#txtSubLeadsSubject").val();
		var SUbLeadDetails = $("#txtSubLeadsDetails").val();
		var attachment = "";
		$("#frmLeadsAttachments .leadsattachment").each(function(){
			attachment += $(this).val().replace("C:\\fakepath\\", "")+"|";
		});
		var Count = 0;
		$(".LeadsReq").each(function(){
			if($(this).val() == "" || $(this).val() == null){
				alert($(this).attr("id"))
				Count++;
                $(this).css("border-color", "#f2a696");
            }else{
               $(this).css("border-color", "#b5b5b5");
            }
		})
		if(Count == 0){
			$.ajax({
				type: 'POST',
				url: 'leads/class.php',
				data: 'CompanyID=' + CompanyID + '&TradeID=' + TradeID + '&leadsID=' + leadsID + '&LeadsName=' + LeadsName + '&Position=' + Position + '&AssignedPerson=' + AssignedPerson + '&Company=' + Company + '&FirstName=' + FirstName + '&MiddleName=' + MiddleName + '&LastName=' + LastName + '&Remarks=' + Remarks + '&Source=' + Source + '&attachment=' + attachment + '&form=btnSaveLeads',
				beforeSend : function() {
					$('#preloadmodalleads').addClass('myspinner');
				},
				success:function(data){
					$("#preloadmodalleads").removeClass("myspinner");
					var arr = data.split("|");
					if(arr[0] == "1"){
	    				$("#frmLeadsID").val(arr[2]);
						$("#frmSubLeadsID").val(arr[2]);
						setTimeout(function(){
							showmodal("alert", arr[1], "HideLeadsMainModal", null, "", null, "0");
			        		savefrmLeadsAttachments();

			        		if(lmodule != "Prospect"){
								var attachment2 = "";
			        			$("#leads_SubLeadsAttachment .leadsattachment").each(function(){
									attachment2 += $(this).val().replace("C:\\fakepath\\", "")+"|";
								});
			        			$.ajax({
			        				type: 'POST',
			        				url: 'leads/class.php',
			        				data: 'module=' + lmodule + '&leadsID=' + arr[2] + '&SubLeadsSubject=' + SubLeadsSubject + '&SUbLeadDetails=' + SUbLeadDetails + '&SubLeadsID=' + SubLeadsID + '&attachment=' + attachment2 + '&LeadsName=' + LeadsName + '&form=AddSubLeads',
			        				success:function(AWAData){
			        					$("#frmSubLeadsModuleID").val(AWAData);
			        					savefrmLeadsAwarenessAttachments();
			        				}
			        			})
			        		}

			        	}, 1000)
					}else{
						setTimeout(function(){
							showmodal("alert", arr[1], "", null, "", null, "1");
			        	}, 1000)
					}
				}
			})
		}else{
			setTimeout(function(){
				showmodal("alert", "Please fill all required fields.", "", null, "", null, "1");
        	}, 1000)
		}
	}

	function savefrmLeadsAttachments(){
    	var data = new FormData($('#frmLeadsAttachments')[0]);
		$.ajax({
	        type: 'POST',
	        url: 'leads/savefrmLeadsAttachments.php',
	        data: data,
	        mimeType: 'multipart/form-data',
	        contentType: false,
	        cache: false,
	        processData: false,
	        success:function(data){

	        }
	    })
	}

	function savefrmLeadsAwarenessAttachments(){
    	var data = new FormData($('#frmAWAAttachments')[0]);
		$.ajax({
	        type: 'POST',
	        url: 'leads/savefrmLeadsAwarenessAttachments.php',
	        data: data,
	        mimeType: 'multipart/form-data',
	        contentType: false,
	        cache: false,
	        processData: false,
	        success:function(data){

	        }
	    })
	}

	function HideLeadsMainModal(){
	    $("#AddNewLeads").modal("hide");
	    $("#AddNewLeads :input").val("");
		var module = "<?php echo $_GET['type']; ?>";
	    if(module == "prospects"){
	    	tblleadslist();
	    }else{
	    	tblSubLeadslist();
	    }
	}

	function browseProspects(){
	    var key = $("#txtsearchprospectlist").val();
		var page = $("#browseProspectsPageCount").val();
	    $.ajax({
	      	type: 'POST',
	      	url: 'mainclass.php',
	      	data: 'page=' + page + '&key=' + key + '&form=browseProspects',
	      	success:function(data){
	        	$("#tblprospectlist").html(data);
	        	browseProspectsEntries();
				browseProspectsPagination();
	      	}
	    })
	}

	function browseProspectsEntries() {
		var key = $("#txtsearchprospectlist").val();
		var page = $("#browseProspectsPageCount").val();
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'key=' + key + '&page=' + page + '&form=browseProspectsEntries',
			success: function(data){
				$("#browseProspectsEntries").text(data);
			}
		});
	}

	function browseProspectsPagination() {
	  var key = $("#txtsearchprospectlist").val();
	  var page = $("#browseProspectsPageCount").val();
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'key=' + key + '&page=' + page + '&form=browseProspectsPagination',
			success: function(data){
				$("#browseProspectsEntriesPage").html(data);
			}
		})
	}

	function browseProspectsPageFunc(page, pagenums) {
		$(".pgnumbrowseProspects").removeClass("active");
		$("#pgbrowseProspects" + pagenums).addClass("active");
		$("#browseProspectsPageCount").val(page);
		browseProspects();
	}

	function selectprospect(leadsID){
    	$("#modalProspectList").modal("hide");
    	$("#frmLeadsID").val(leadsID);
		$.ajax({
			type: 'POST',
			url: 'leads/class.php',
			data: 'leadsID=' + leadsID + '&form=selectprospect',
			success:function(data){
				var arr = data.split("|");
				$("#txtLeadsAssignedPerson").val(arr[0]);
				$("#txtLeadsPosition").val(arr[1]);
				$("#txtLeadsSource").val(arr[2]);
				$("#txtLeadsRemarks").val(arr[3]);
				$("#leads_attachment").html(arr[4]);
				trapinputfields();
			}
		})
	}
</script>