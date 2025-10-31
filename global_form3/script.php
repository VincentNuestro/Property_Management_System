<script type="text/javascript">
	$(function(){
		$(".date-picker").datepicker({
            autoHide: true,
            format: 'mm/dd/yyyy',
            todayHighlight: true
        });
        fncAllClassificationRef();
		fncAllSource();
		fncAllProcessOwner();
        $("#txtSearchNDTCharges").keyup(function(e){
            var x = event.keyCode;
            if(x == 13){ 
                showModalNDTAddCharges(); 
            }else if ( x == '8' ){
                if($('#txtSearchNDTCharges').val() == ""){
                    showModalNDTAddCharges();
                }
            }
        });
        $("#txtSearchRequirement").keyup(function(e){
            var x = event.keyCode;
            if(x == 13){ 
                showModalAddRequirements(); 
            }else if ( x == '8' ){
                if($('#txtSearchRequirement').val() == ""){
                    showModalAddRequirements();
                }
            }
        });
        $("#txtSearchPermit").keyup(function(e){
            var x = event.keyCode;
            if(x == 13){ 
                showModalAddPermits(); 
            }else if ( x == '8' ){
                if($('#txtSearchPermit').val() == ""){
                    showModalAddPermits();
                }
            }
        });
        $(".AccredStat").each(function(){
			$(this).click(function(){
				if($(this).attr("id") == "TagAsAccredited"){
					$(".POSCount").css("display", "block");
					$(".POSCount :input").addClass("PRORequired");
					$(".POSCount :input").addClass("TenantRequired");
					$(".POSCount :input").addClass("ReservationRequired");
				}else{
					$(".POSCount").css("display", "none");
					$(".POSCount :input").removeClass("PRORequired");
					$(".POSCount :input").removeClass("TenantRequired");
					$(".POSCount :input").removeClass("ReservationRequired");
				}
			})
		})
		$(".amount").change(function(){
            var x = ($(this).val()).replace(/,/g,"");
            var v = parseFloat(x||0);
            $(this).val(v.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
        });
        $("#txtGlobalCC1").keyup(function(){
		    var len = ($(this).val()).length;
		    if(len == 4){
		      	$("#txtGlobalCC2").focus();
		    }
		})
		$("#txtGlobalCC2").keyup(function(){
		    var len = ($(this).val()).length;
		    if(len == 4){
		      	$("#txtGlobalCC3").focus();
		    }
		})
		$("#txtGlobalCC3").keyup(function(){
		    var len = ($(this).val()).length;
		    if(len == 4){
		      	$("#txtGlobalCC4").focus();
		    }
		})
		$("#chkGlobalisDaily").click(function(){
			if($(this).is(":checked")){
				$("#txtNDTYearcount").attr("readonly", "readonly");
				$("#txtNDTMonthcount").attr("readonly", "readonly");
				$("#txtGlobalDayCount").removeAttr("readonly");
				$("#txtNDTYearcount").val("0");
				$("#txtNDTMonthcount").val("0");
				$("#txtProEscaRateStart").val("0");
				$("#txtProEscaYearBasis").val("0");
				$("#txtProEscalationRate").val("0");
			}else{
				$("#txtNDTYearcount").removeAttr("readonly");
				$("#txtNDTMonthcount").removeAttr("readonly");
				$("#txtGlobalDayCount").attr("readonly", "readonly");
				$("#txtGlobalDayCount").val("0");
			}
			getOccupancyDateTo();
		})
	})
	
	function fncNewInquiry(){
		$("#btnGlobalSave").button('reset');
		var MMS_Module = "<?php echo $_REQUEST['url']; ?>";
		$("#mdlAddNewInquiry").modal("show");
		$(".txtGlobalClear").val("");
		// $(".clicktoshowall").each(function(){
  //       	var id = this.id;
  //           if($("#"+id+" i").hasClass("fa fa-chevron-up")){
  //               $("#"+id).click();
  //           }
  //       })
		$("#btncreateevents").addClass("hide");
        $("#TagAsNotAccredited").click();
        $("#imgTenant").attr("src", "assets/images/noimage5.png");
        $("#divUnitInformation").html("<div class='alert alert-info center'> No Unit Selected... </div>");
        $("#div_inquiry_contact_numbers").html('<center><img src="assets/images/phone-receiver.png" style="margin: 20px;height: 120px; width: 120px;"><h3>No contacts yet.</h3></center>');
		$("#div_inquiry_contact_person").html('<center><img src="assets/images/network.png" style="margin: 20px;height: 120px; width: 120px;"><h3>No contact persons yet.</h3></center>');
		$("#divNewInquiryRemarks").addClass("hide");
        $("#divInqRemarks").html("<textarea class='form-control' id='txtSubLeadInqRemarks' style='resize: none;height: 100px;' maxlength='255'></textarea>");
        $("#txtNDTDepartment").html("<option value=''>-- Select Department --</option>");
        $("#txtNDTCategory").html("<option value=''>-- Select Category --</option>");
        DelProRentConsStarDate('0');
		$(".btnNDTMonthly").css("display", "none");
        $(".isCash").css("display", "none");
		$(".PTCHECK").css("display", "none");
        $(".updatedby_texts").css("display", "none");
        $(".modified_info").css("display", "none");
        $("#btnSend2Leasing").css("display", "none");
        $(".txtInqDisabled").prop("disabled",  false);
        $("#txtProRentFreeConsStartDate").val("<?php echo date('m/d/Y'); ?>");
        $("#txtNDTBillingType").val("Rent");
        $("#txtVATSetup").val("0");
        $(".txtGlobalZero").val("0");
        $(".txtGlobalZero2").val("0.00");
        $("#chkGlobalisDaily").prop("checked", false);
		$("#txtNDTYearcount").removeAttr("readonly");
		$("#txtNDTMonthcount").removeAttr("readonly");
		$("#txtGlobalDayCount").attr("readonly", "readonly");
		$("#txtGFAddedReq").val("1000000000");
		$("#txtGFAddedPer").val("1000000000");
		$.ajax({
			type: 'POST',
			url: 'global_form/class.php',
			data: 'form=getcardtype',
			success:function(data){
				$("#txtNDTCardType").html(data);
			}
		})
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'form=tblrefbank',
			success:function(data){
				$("#txtNDTBankFrom").html(data);
				$("#txtNDTBankTo").html(data);
			}
		})
		if(MMS_Module == "tenants"){			
			$.ajax({
				type: 'POST',
				url: 'global_form/class.php',
				data: 'form=getDefaultCharges',
				success:function(data){
					$("#tblNDTCharges").html(data);
				}, complete: function(){
					getTotalMonthlyCharges();
				}
			})
			// $.ajax({
			// 	type: 'POST',
			// 	url: 'global_form/class.php',
			// 	data: 'form=getreqlist',
			// 	success:function(data){
			// 		$("#div_modal_inquiry_requirements").html(data);
			// 	}, complete: function(){
			// 		fncSpecialScripts();
			// 	}
			// })
			// $.ajax({
			// 	type: 'POST',
			// 	url: 'global_form/class.php',
			// 	data: 'form=getperlist',
			// 	success:function(data){
			// 		$("#div_modal_inquiry_permits").html(data);
			// 	}, complete: function(){
			// 		fncSpecialScripts();
			// 		$('.date-picker').datepicker({
			// 		    autoclose: true,
			// 		    todayHighlight: true,
			// 		    format: 'mm/dd/yyyy',
			// 		});
			// 	}
			// })
			$(".divReqProposal").removeClass("hide");
			$(".divReqPerProposal").css("display", "none");
        	$(".divReqPerProposal2").css("display", "block");
		}else{
			$(".divReqProposal").addClass("hide");
			$(".divReqPerProposal").css("display", "block");
        	$(".divReqPerProposal2").css("display", "none");
		}
	}

	function fncSpecialScripts(){
    	var tag_input = $('#form-field-tags');
      	try{
        	tag_input.tag({
          		placeholder:tag_input.attr('placeholder'),
          		source: ace.vars['US_STATES'],
          	})
        	var $tag_obj = $('#form-field-tags').data('tag');
        	var index = $tag_obj.inValues('some tag');
        	$tag_obj.remove(index);
      	}
      	catch(e) {
        	tag_input.after('<textarea id="'+tag_input.attr('id')+'" name="'+tag_input.attr('name')+'" rows="3">'+tag_input.val()+'</textarea>').remove();
      	}
    	$('.upload_app_req').ace_file_input({
			no_file:'No File ...',
			btn_choose:'Choose',
			btn_change:'Change',
			droppable:false,
			onchange:null,
			thumbnail:false
	  	});
	  	$('.upload_app_permit').ace_file_input({
			no_file:'No File ...',
			btn_choose:'Choose',
			btn_change:'Change',
			droppable:false,
			onchange:null,
			thumbnail:false
	  	});
	  	$(".form_lease_application_req_2").each(function(){
		  	var form_id = $(this).attr("id");
		  	var inputfile = $(this).find(".upload_app_req");
		  	var empty = $(this).find("a[class='remove']");
		  	inputfile.click(function(){
			empty.click();
				$("#"+form_id+"_icon").removeClass("fa-check");
				$("#"+form_id+"_icon").addClass("fa-remove");
				$("#"+form_id+"_icon").css("color", "red");
		  	})
		  	empty.click(function(){
				$("#"+form_id+"_icon").removeClass("fa-check");
				$("#"+form_id+"_icon").addClass("fa-remove");
				$("#"+form_id+"_icon").css("color", "red");
		  	})
		});
	  	$(".form_lease_application_permit").each(function(){
		  	var form_id = $(this).attr("id");
		  	var inputfile = $(this).find(".upload_app_permit");
		  	var empty = $(this).find("a[class='remove']");
		  	inputfile.click(function(){
				empty.click();
				$("#"+form_id+"_icon").removeClass("fa-check");
				$("#"+form_id+"_icon").addClass("fa-remove");
				$("#"+form_id+"_icon").css("color", "red");
		  	})
		  	empty.click(function(){
				$("#"+form_id+"_icon").removeClass("fa-check");
				$("#"+form_id+"_icon").addClass("fa-remove");
				$("#"+form_id+"_icon").css("color", "red");
		  	})
		});
		$(".date-picker").datepicker({
            autoHide: true,
            format: 'mm/dd/yyyy',
            todayHighlight: true
        });
    }

	function fncCloseInquiry(){
		$("#mdlAddNewInquiry").modal("hide");
		var MMS_Module = "<?php echo $_REQUEST['url']; ?>";
		if(MMS_Module == 'inquiry'){
			loadtblSUbLeadsINQ();
		}else if(MMS_Module == 'leasingapplication'){
			tblListofApplication();
			// $("#btnLANewProposal").prop("disabled", false);
		}
	}

	function fncAllClassificationRef(){
        $.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'form=tblref_merchandise_class',
            success: function(data){
                $(".txtAllClassification").html(data);
            }
        })
    }

    function fncAllDepartmentRef(){
        var Classification = $("#txtInqClassification").val();
        $.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'Classification=' + Classification + '&form=fncAllDepartmentRef',
            success: function(data){
                $("#txtInqDepartment").html(data);
            }
        })
    }

    function fncAllCategoryRef(){
        var Department = $("#txtInqDepartment").val();
        $.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'Department=' + Department + '&form=fncAllCategoryRef',
            success: function(data){
                $("#txtInqCategory").html(data);
            }
        })
    }

    function fncAllSource(){
        $.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'form=fncAllSource',
            success: function(data){
                $(".txtAllSource").html(data);
            }
        })
    }

    function fncAllProcessOwner(){
        $.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'form=fncAllProcessOwner',
            success: function(data){
                $(".txtAllProcessOwner").html(data);
            }
        })
    }

    function fncAllDepartmentRef(){
        var Classification = $("#txtNDTClassification").val();
        $.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'Classification=' + Classification + '&form=fncAllDepartmentRef',
            success: function(data){
                $("#txtNDTDepartment").html(data);
            }
        })
    }

    function fncAllCategoryRef(){
        var Department = $("#txtNDTDepartment").val();
        $.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'Department=' + Department + '&form=fncAllCategoryRef',
            success: function(data){
                $("#txtNDTCategory").html(data);
            }
        })
    }

    function fncLoadTradeProfileList(){
		$("#mdlTradeList").modal("show");
		$("#txt_userpage_tenants").val("1");
		fncLoadTradeList();
	}

	function fncgetMonthDay(){
        var DateFrom = $("#txtNDTdateFrom").val();
        var DateTo = $("#txtNDTdateTo").val();
        if(DateTo != ''){
            $.ajax({
                type: 'POST',
                url: 'global_form/class.php',
                data: 'DateFrom=' + DateFrom + '&DateTo=' + DateTo + '&form=fncgetMonthDay',
                success: function(data){
                    var arr = data.split("|");
                    $("#txtNDTMonthcount").val(arr[0]);
                    $("#txtNDTYearcount").val(arr[1]);
                    $("#txtGlobalDayCount").val(arr[2]);
                }, complete: function(){
					fncgetPaymentSchedule();
                }
            })
        }
    }

	function getOccupancyDateTo(){
		var MonthCount = $("#txtNDTMonthcount").val();
		var YearCount = $("#txtNDTYearcount").val();
		var DayCount = $("#txtGlobalDayCount").val();
		var DateFrom = $("#txtNDTdateFrom").val();
		// if(MonthCount >= 1 || YearCount >= 1 || DayCount >= 1){
			$.ajax({
				type: 'POST',
				url: 'global_form/class.php',
				data: 'MonthCount=' + MonthCount + '&YearCount=' + YearCount + '&DayCount=' + DayCount + '&DateFrom=' + DateFrom + '&form=getOccupancyDateTo',
				success: function(data){
					$("#txtNDTdateTo").val(data);
				}, complete: function(){
					fncgetPaymentSchedule();
				}
			})
		// }
	}

	function fncgetPaymentSchedule(){
		var SelectedUnits = "";
		$(".txtASU").each(function(){
			SelectedUnits += $(this).val() +"|";
		})
		var Charges = "";
		$("#tblNDTCharges tr").each(function(){
			Charges += $(this).attr("id") + "|" + $(this).find(".getthisvalue").text().replace(/,/g, "") + "@";
		})
		if(SelectedUnits != "" && ( $("#txtNDTMonthcount").val() != 0 || $("#txtNDTYearcount").val() != 0 || $("#txtGlobalDayCount").val() != 0 ) ){
			var isDaily = "";
	        $("#chkGlobalisDaily").each(function(){
	        	if($(this).is(":checked")){
	        		isDaily = "daily";
	        	}
	        })
			var PaymentType = $("#txtNDTPaymentType").val();
			var RentAmount = ($("#txtNDTMonthlyRent").val()).replace(/,/g, "");
			var DateFrom = $("#txtNDTdateFrom").val();
			var DateTo = $("#txtNDTdateTo").val();
			var EscaRate = $("#txtProEscalationRate").val();
			var EscaStart = $("#txtProEscaRateStart").val();
			var EscaYearBasis = $("#txtProEscaYearBasis").val();
			var VATSetup = $("#txtVATSetup").val();
			var Escalation = "";
			var EscaRate = 0;
	        $("#tbodyEscalation tr").each(function(){
	        	EscaRate += parseFloat($(this).find(".txtEscalation").val());
	        	Escalation += $(this).find("td").eq(0).text() + "|" + EscaRate + "@";
	        })
			$.ajax({
				type: 'POST',
				url: 'global_form/class.php',
				data: 'RentAmount=' + RentAmount + '&SelectedUnits=' + SelectedUnits + '&PaymentType=' + PaymentType + '&DateFrom=' + DateFrom + '&DateTo=' + DateTo + '&Charges=' + Charges + '&EscaRate=' + EscaRate + '&EscaStart=' + EscaStart + '&EscaYearBasis=' + EscaYearBasis + '&VATSetup=' + VATSetup + '&isDaily=' + isDaily + '&Escalation=' + Escalation + '&form=fncgetPaymentSchedule',
				success: function(data){
					if(data == 1){
						setTimeout(function(){
							showmodal("alert", "Please check billing list first to generate payment schedule.", "", null, "", null, "1");
						}, 500)
					}else{
						$("#tblNDTPaymentSchedule").html(data);
						$(".numonly").keydown(function(event) {
				           	if(event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 190 || event.keyCode == 9 || event.keyCode == 188){
				            }else{
				                if (event.keyCode < 48 || event.keyCode > 57 || event.keyCode == 17) {
				                    event.preventDefault(); 
				                }   
				            }
				       	});
				       	$(".amount").change(function(){
				            var x = ($(this).val()).replace(/,/g,"");
				            var v = parseFloat(x||0);
				            $(this).val(v.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
				       	});
					}
				}, complete: function(){
					var totalAmount = 0;
					$("#tblNDTPaymentSchedule tr").each(function(){
						totalAmount += parseFloat($(this).find(".lblRentalCharges").text().replace(/,/g,""));
					})
					$("#txtNDTTotalAmount").text("Total Amount: "+totalAmount.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
				}
			})
		}else{
			$(".UnitInfoWasChanged").val("");
			$(".SomethingWasChanged").html("");
		}
	}

	function fncSaveFixedRent(){
		// $(".btnNDTMonthly").css("display", "none");
		fncgetPaymentSchedule();
		$("#txtNDTMonthlyRent").attr("readonly");
		var Rent = ($("#txtNDTMonthlyRent").val()).replace(/,/g, "");
		var SecDepMonth = $("#txtGlobalSecDepMonth").val();
		var ConBondMonth = $("#txtGlobalConBondMonth").val();
		var AdvMonth = $("#txtGlobalAdvMonth").val();
		var ExhMonth = $("#txtGlobalExhMonth").val();
		var Charges = $("#txtNDTMonthlyCharges").val().replace(/,/g, "");
		var Total = parseFloat(Rent) + parseFloat(Charges);
		var VATSetup = $("#txtVATSetup").val();
		// if(SecDepMonth == 0){
		// 	$("#txtGlobalSecDepAmount").val(parseFloat(Rent).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
		// }else{
			$("#txtGlobalSecDepAmount").val(parseFloat(SecDepMonth * Rent).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
		// }
		// if(ConBondMonth == 0){
		// 	$("#txtGlobalConBondAmount").val(parseFloat(Rent).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
		// }else{
			$("#txtGlobalConBondAmount").val(parseFloat(ConBondMonth * Rent).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
		// }
		$("#txtGlobalExhAmount").val(parseFloat(ExhMonth * Rent).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
		$.ajax({
			type: 'POST',
			url: 'global_form/class.php',
			data: '&Total=' + Total + '&AdvMonth=' + AdvMonth + '&VATSetup=' + VATSetup + '&form=getFixedAdvVAT',
			success: function(data){
				$("#txtGlobalAdvRent").val(data);
			}
		})
	}

	function fncChangeBillingType(type){
		if(type == "Rent or Share" || type == "Rent Rev" || type == "Share Only" || type == "Share Only2"){
			$(".divNDTPercentage").css("display", "inline-block");
			$("#txtNDTPercentage").addClass("PRORequired");
			$("#txtNDTPercentage").addClass("TenantRequired");
			$("#txtNDTPercentage").addClass("ReservationRequired");
			$("#txtNDTMonthlyRent").attr("readonly", "readonly");
			$(".btnNDTMonthly").css("display", "none");
			$("#txtNDTMonthlyRent").val($("#txtNDTMonthlyRentOrig").val());
			fncgetPaymentSchedule();
		}else if(type == "Fixed Rent"){
			$("#txtNDTMonthlyRent").removeAttr("readonly");
			$(".btnNDTMonthly").css("display", "block");
			$(".divNDTPercentage").css("display", "none");
			$("#txtNDTPercentage").removeClass("PRORequired");
			$("#txtNDTPercentage").removeClass("TenantRequired");
			$("#txtNDTPercentage").removeClass("ReservationRequired");
		}else{
			$("#txtNDTMonthlyRent").attr("readonly", "readonly");
			$(".btnNDTMonthly").css("display", "none");
			$(".divNDTPercentage").css("display", "none");
			$("#txtNDTPercentage").removeClass("PRORequired");
			$("#txtNDTPercentage").removeClass("TenantRequired");
			$("#txtNDTPercentage").removeClass("ReservationRequired");
			$("#txtNDTMonthlyRent").val($("#txtNDTMonthlyRentOrig").val());
			fncgetPaymentSchedule();
		}
		<?php if($_GET['url'] != 'inquiry'){ ?>
			fncgetRent();
		<?php } ?>
	}

	function DelProRentConsStarDate(kasunduan){
		var DateFrom = $("#txtNDTdateFrom").val();
		var StartDate = $("#txtProRentFreeCons").val();
		$.ajax({
			type: 'POST',
			url: 'global_form/class.php',
			data: 'DateFrom=' + DateFrom + '&StartDate=' + StartDate + '&form=DelProRentConsStarDate',
			success: function(data){
				$("#txtProRentFreeConsStartDate").val(data);
				if(kasunduan == 0){
					$("#divConsStartDate").css("display", "none");
					$("#txtProRentFreeConsStartDate").removeClass("NDTRequired");
				}else{
					$("#divConsStartDate").css("display", "block");
					$("#txtProRentFreeConsStartDate").addClass("NDTRequired");
				}
			}
		})
	}

	function showModalNDTAddCharges(){
		var VATSetup = $("#VattxtVATSetup").val();
		var ids = "";
		$("#tblNDTCharges tr").each(function(){
			ids += $(this).attr("id")+"|";
		})
		var key = $("#txtSearchNDTCharges").val();
		var isDaily = "";
        $("#chkGlobalisDaily").each(function(){
        	if($(this).is(":checked")){
        		isDaily = "daily";
        	}
        })
		$.ajax({
			type: 'POST',
			url: 'global_form/class.php',
			data: 'key=' + key + '&ids=' + ids + '&isDaily=' + isDaily + '&VATSetup=' + VATSetup + '&form=showModalNDTAddCharges',
			success: function(data){
				if(data.trim() == ""){
	                $("#tblNDTAddCharges").html("<tr><td colspan='4' style='text-align: center;'>No Data Found...</td></tr>");
				}else{
					$("#tblNDTAddCharges").html(data);
					$("#tblNDTAddCharges tr").each(function(){
						$(this).click(function(){
							$("#mdlAddSelectedCharge").modal("show");
							$("#txtACChargeCoe").val($(this).find(".ChargeID").text());
							$("#txtAcChargeDesc").val($(this).find(".ChargeDesc").text());
							$("#txtACOrigRate").val($(this).find(".OrigRate").text());
							$("#txtACAmount").val($(this).find(".OrigRate").text());
							$("#txtACUnit").val($(this).find(".ChargeType").text());
						})
					})  
				}
			}
		})
	}

	function fncAddSelectedCharge(){
		var ChargeCode = $("#txtACChargeCoe").val();
		var ChargesDesc = $("#txtAcChargeDesc").val();
		var ChargesRate = $("#txtACAmount").val();
		var ChargesRate2 = $("#txtACAmount").val().replace(/,/g, "");
		var ChargeType = $("#txtACUnit").val();
		$("#tblNDTCharges").append("<tr id=\""+ ChargeCode +"\">" +
										"<td>"+ ChargesDesc +"</td>" +
										"<td>"+ ChargeType +"</td>" +
										"<td>"+ ChargesRate +"</td>" +
										"<td class='hidden getthisvalue'>"+ ChargesRate2 +"</td>" +
										"<td style='text-align: center;z-index: 0;'><button class='btn btn-xs btn-danger btn-round' onclick='$(\"#"+ ChargeCode +"\").remove(); fncgetPaymentSchedule(); getTotalMonthlyCharges();'><i class='fa fa-trash-o'></i></button></td>" +
									"</tr>");
	    fncgetPaymentSchedule();
	    getTotalMonthlyCharges();
		$("#TR"+ ChargeCode).remove();
		$("#mdlAddSelectedCharge").modal("hide");
	}

	function showmodal_NDTtermsandcondition(){
		$("#modal_NDTtermsandcondition").modal("show");
		$("#txt_NDTTACselectuserpage").val("1");
		loadgroupselection();
	}

	function showtblLNDTtermsandconditionlist(){
		var group = $("#groupselection").val();
	    var page = $("#txt_NDTTACselectuserpage").val();
		$.ajax({
			type: 'POST',
			url: 'global_form/class.php',
			data: 'group=' + group + '&page=' + page + '&form=showtblLNDTtermsandconditionlist',
			beforeSend : function() {
	       		$('#NDTtermsandconditionloading').addClass('myspinner');
	      	},
		    success: function(data){
	        	$('#NDTtermsandconditionloading').removeClass('myspinner');
	        	 if(data != ""){
	                $("#tblNDTtermsandconditionlist").html(data);
	            }else{
	                $("#tblNDTtermsandconditionlist").html("<tr><td colspan='3' style='text-align: center;'>No Data Found...</td></tr>");
	            }
	            loadentriesNDTTAC();
				loadpageNDTTAC()
				highlightselected();
				checkSelected();
			}
		})
	}

	function highlightselected(){
		$("#tblNDTtermsandconditionlist tr").each(function(){
			$(this).click(function(){
				eto = $(this).find(".chkNDTselectedTAC");
				if(eto.is(":checked")){
					var ids = $("#sonyxperiax2017").val();
					eto.prop("checked", false);
					$("#sonyxperiax2017").val(ids.replace($(this).find(".chkNDTselectedTAC").val() + "|", ""));
					$(this).css("color","");
					$(this).css("background-color","");
				}else{
					var ids = $("#sonyxperiax2017").val();
					eto.prop("checked", true);
					ids += $(this).find(".chkNDTselectedTAC").val() + "|";
					$("#sonyxperiax2017").val(ids);
					$(this).css("color","#FFF");
					$(this).css("background-color","#666");
				}
			})
		})
	}

	function loadentriesNDTTAC(){
		var group = $("#groupselection").val();
	    var page = $("#txt_NDTTACselectuserpage").val();
	    $.ajax({
	        type: 'POST',
			url: 'global_form/class.php',
	        data: 'group=' + group + '&page=' + page + '&form=loadentriesNDTTAC',
	        success: function(data){
	            if(data == ""){
	                $("#txtLNDTTACenties").text("");
	            }else{
	                $("#txtLNDTTACenties").text(data);
	            }
	        }
	    });
	}

	function loadpageNDTTAC(){
		var group = $("#groupselection").val();
	    var page = $("#txt_NDTTACselectuserpage").val();
	    $.ajax({
	        type: 'POST',
			url: 'global_form/class.php',
	        data: 'group=' + group + '&page=' + page + '&form=loadpageNDTTAC',
	        success: function(data){
	            $("#ulLNDTTACpagination").html(data);
	        }
	    });
	}

	function paginationNDTTAC(page, pagenums){
	    $(".pgnumNDTTAC").removeClass("active");
	    $("#pgNDTTAC" + pagenums).addClass("active");
	    $("#txt_NDTTACselectuserpage").val(page);
	    showtblLNDTtermsandconditionlist();
	}

	function loadgroupselection(){
		$.ajax({
			type: 'POST',
			url: 'global_form/class.php',
			data: 'form=loadgroupselection',
			success:function(data){
				$("#groupselection").html(data);
			}, complete(){
				showtblLNDTtermsandconditionlist();
			}
		})
	}

	function checkSelected(){
		var allselected = $("#sonyxperiax2017").val();
		var arr = allselected.split("|");
		for ( var a = 0; a <= arr.length-2; a++ ) {
			$(".chkNDTselectedTAC" + arr[a]).prop("checked", true);
			$("#tr"+arr[a]).attr("style","background-color: #666 !important;color:#FFF !important");
		}
	}

	function addselection(){
		var ids = "";
		$(".chkNDTselectedTAC").each(function(){
			if($(this).is(":checked")){
				ids += this.value + "|";
			}	
		})
		$.ajax({
			type: 'POST',
			url: 'global_form/class.php',
			data: 'ids=' + ids + '&form=addselection',
			success:function(data){
				$("#div_termsandcondition").html(data);
				$("#modal_NDTtermsandcondition").modal("hide");
			}
		})
	}

    function showModalAddRequirements(){
        var ids = "";
        $("#tblProRequirements tr").each(function(){
            ids += $(this).attr("id")+"|";
        })
        var key = $("#txtSearchRequirement").val();
        var InquiryID = $("#txtGlobalFormInquiryID").val();
		var ProposalNum = $("#isProposal").val();
        $.ajax({
            type: 'POST',
			url: 'global_form/class.php',
            data: 'key=' + key + '&ids=' + ids + '&InquiryID=' + InquiryID + '&ProposalNum=' + ProposalNum + '&form=showModalAddRequirements',
            success:function(data){
                if(data.trim() == ""){
                    $("#tblAddRequirements").html("<tr><td colspan='2' style='text-align: center;'>No Data Found...</td></tr>");
                }else{
                    $("#tblAddRequirements").html(data);
                } 
            }
        })
    }

    function showModalAddPermits(){
        var ids = "";
        $("#tblProPermits tr").each(function(){
            ids += $(this).attr("id")+"|";
        })
        var key = $("#txtSearchPermit").val();
        var InquiryID = $("#txtGlobalFormInquiryID").val();
		var ProposalNum = $("#isProposal").val();
        $.ajax({
            type: 'POST',
			url: 'global_form/class.php',
            data: 'key=' + key + '&ids=' + ids + '&InquiryID=' + InquiryID + '&ProposalNum=' + ProposalNum + '&form=showModalAddPermits',
            success: function(data){
                if(data.trim() == ""){
                    $("#tblAddPermits").html("<tr><td colspan='2' style='text-align: center;'>No Data Found...</td></tr>");
                }else{
                    $("#tblAddPermits").html(data);
                }
            }
        })
    }

    function fncAddSelectedRequirement(RequirementID, ProposalStat){
    	var InquiryID = $("#txtGlobalFormInquiryID").val();
		var ProposalNum = $("#isProposal").val();
		var ReqCount = $("#txtGFAddedReq").val();
		$.ajax({
			type: 'POST',
			url: 'global_form/class.php',
			data: 'InquiryID=' + InquiryID + '&ProposalNum=' + ProposalNum + '&RequirementID=' + RequirementID + '&ReqCount=' + ReqCount + '&form=fncAddSelectedRequirement',
			beforeSend: function(){
	       		$('#frmLoadingGlobalFromSelectRequirement').addClass('myspinner');
			},
			success: function(data){
	        	$('#frmLoadingGlobalFromSelectRequirement').removeClass('myspinner');
				$("#div_modal_inquiry_requirements").append(data);
				fncSpecialScripts();
			}
		})
		$.ajax({
			type: 'POST',
			url: 'global_form/class.php',
			data: 'RequirementID=' + RequirementID + '&form=fncAddSelectedRequirement2',
			success: function(data){
				$("#tblProRequirements").append(data);
			}
		})
        $("#TRReq"+RequirementID).remove();
        $("#txtGFAddedReq").val(parseFloat(ReqCount) + 1);
    }

    function fncAddSelectedPermit(PermitID, ProposalStat){
    	var InquiryID = $("#txtGlobalFormInquiryID").val();
		var ProposalNum = $("#isProposal").val();
		var PerCount = $("#txtGFAddedPer").val();
		$.ajax({
			type: 'POST',
			url: 'global_form/class.php',
			data: 'InquiryID=' + InquiryID + '&ProposalNum=' + ProposalNum + '&PermitID=' + PermitID + '&PerCount=' + PerCount + '&form=fncAddSelectedPermit',
			beforeSend: function(){
	       		$('#frmLoadingGlobalFromSelectPermits').addClass('myspinner');
			},
			success: function(data){
	        	$('#frmLoadingGlobalFromSelectPermits').removeClass('myspinner');
				$("#div_modal_inquiry_permits").append(data);
				fncSpecialScripts();
			}
		})
		$.ajax({
			type: 'POST',
			url: 'global_form/class.php',
			data: 'PermitID=' + PermitID + '&form=fncAddSelectedPermit2',
			success: function(data){
				$("#tblProPermits").append(data);
			}
		})
        $("#TRPer"+PermitID).remove();
        $("#txtGFAddedPer").val(parseFloat(PerCount) + 1);
    }

	function fncSaveGlobalForm(btnAction){
		$("#btnGlobalSave").button('loading');
		var MMS_Module = "<?php echo $_REQUEST['url']; ?>";
		var Count = 0;
		if(MMS_Module == 'inquiry'){
			$(".INQRequired").each(function(){
	            if ($(this).val() == "" || $(this).val() == 'undefined' || $(this).val() == null){
	                $(this).css("border-color","#f2a696");
	                Count++;
	            }else{
	                $(this).css("border-color","#D5D5D5");
	            }
	        })
		}else if(MMS_Module == 'leasingapplication'){
			$(".PRORequired").each(function(){
				if ($(this).val() == "" || $(this).val() == 'undefined' || $(this).val() == null){
	                $(this).css("border-color","#f2a696");
	                Count++;
	            }else{
	                $(this).css("border-color","#D5D5D5");
	            }
			})
		}else if(MMS_Module == 'tenants'){
			$(".TenantRequired").each(function(){
				if ($(this).val() == "" || $(this).val() == 'undefined' || $(this).val() == null){
	                $(this).css("border-color","#f2a696");
	                Count++;
	            }else{
	                $(this).css("border-color","#D5D5D5");
	            }
			})
		}else if(MMS_Module == 'reservation'){
			$(".ReservationRequired").each(function(){
				if ($(this).val() == "" || $(this).val() == 'undefined' || $(this).val() == null){
	                $(this).css("border-color","#f2a696");
	                Count++;
	            }else{
	                $(this).css("border-color","#D5D5D5");
	            }
			})
		}

		var SelectedUnits = 0;
        $(".txtASU").each(function(){
            SelectedUnits++;
        });
       
        //Charges
        var Charges = "";
		$("#tblNDTCharges tr").each(function(){
			Charges += $(this).attr("id") + "|";
		})

		//Terms and Conditions
		var TermsAndCondition = $("#sonyxperiax2017").val();

        //Requirements and Permits
        var Requirements = "";
        $("#tblProRequirements tr").each(function(){
            Requirements += $(this).attr("id") + "|";
        })
        var Permits = "";
        $("#tblProPermits tr").each(function(){
            Permits += $(this).attr("id") + "|";
        })

        var ReqPermit = 0;
        <?php if(SysLeaseSetup('reqandpermit') == "1"){ ?> 
			ReqPermit++;
		<?php } ?>
		var BillContact = $("#div_TenantBillerContact").html();
        if(Count == 0){
    		if(MMS_Module == 'inquiry'){
				fncSaveGlobalForm2(btnAction);
			}else if(MMS_Module == 'leasingapplication'){
				if(BillContact == ""){
					$("#btnGlobalSave").button('reset');
					setTimeout(function(){
						showmodal("alert", "Please add alteast 1 billing contact.", "", null, "", null, "1");
					}, 500)
				}else{
					if(SelectedUnits == ""){
						$("#btnGlobalSave").button('reset');
		        		setTimeout(function(){
							showmodal("alert", "Please select unit.", "", null, "", null, "1");
						}, 500)
		        	}else{
						if(ReqPermit == 0){
		        			fncSaveGlobalForm2(btnAction);
						}else{
							if(Requirements == ""){
								$("#btnGlobalSave").button('reset');
								setTimeout(function(){
									showmodal("alert", "Please select requirements.", "", null, "", null, "1");
								}, 500)
							}else{
								if(Permits == ""){
									$("#btnGlobalSave").button('reset');
									setTimeout(function(){
										showmodal("alert", "Please select permits.", "", null, "", null, "1");
									}, 500)
								}else{
									fncSaveGlobalForm2(btnAction);
								}
							}
						}
					}
				}
			}else{
				if(SelectedUnits == ""){
					$("#btnGlobalSave").button('reset');
	        		setTimeout(function(){
						showmodal("alert", "Please select unit.", "", null, "", null, "1");
					}, 500)
	        	}else{
					if(ReqPermit == 0){
	        			fncSaveGlobalForm2(btnAction);
					}else{
						if(Requirements == ""){
							$("#btnGlobalSave").button('reset');
							setTimeout(function(){
								showmodal("alert", "Please select requirements.", "", null, "", null, "1");
							}, 500)
						}else{
							if(Permits == ""){
								$("#btnGlobalSave").button('reset');
								setTimeout(function(){
									showmodal("alert", "Please select permits.", "", null, "", null, "1");
								}, 500)
							}else{
								fncSaveGlobalForm2(btnAction);
							}
						}
					}
				}
			}
        }else{
			$("#btnGlobalSave").button('reset');
            setTimeout(function(){
                showmodal("alert", "Please fill all fields.", "", null, "", null, "1");
            }, 500)
        }
	}

	function fncSaveGlobalForm2(btnAction){
		var MMS_Module = "<?php echo $_REQUEST['url']; ?>";
		var Count = 0;
		// Tenant Information
		var InquiryID = $("#txtGlobalFormInquiryID").val();
		var TenantID = $("#txtGlobalFormTenantID").val();
		var isAmendment = $("#txtGlobalisAmendment").val();
		var ApplicationID = $("#txtGlobalFormApplicationID").val();
		var isProposal = $("#isProposal").val();
        var TradeID = $("#txtTradeID").val();
        var TradeName = $("#txtTradeName").val();
		var Merchant_Code = $("#txtMerchantCode").val();
        var CompanyID = $("#txtCompanyID").val();
        var CompanyName = $("#txtCompanyName").val();
        var IndustryID = $("#txtIndustryID").val();
        var ProcessOwner = $("#txtGForm-ProcessOwner").val();
        var Source = $("#txtGFrom-Source").val();
		var Classification = $("#txtNDTClassification").val();
        var Department = $("#txtNDTDepartment").val();
        var Category = $("#txtNDTCategory").val();
        var BillerID = $("#txtTenantBillID").val();
        var AccredStat = "";
		$(".AccredStat").each(function(){
			if($(this).is(":checked")){
				AccredStat = $(this).attr("id");
			}
		})
		var POSCount = $("#txtNDTPosCount").val();

        //Lease Information
        var DateFrom = $("#txtNDTdateFrom").val();
		var DateTo = $("#txtNDTdateTo").val();
		var YearTerm = $("#txtNDTYearcount").val();
		var MonthTerm = $("#txtNDTMonthcount").val();
		var DayTerm = $("#txtGlobalDayCount").val();
		
		var BillingType = $("#txtNDTBillingType").val();
		var BillPercent = $("#txtNDTPercentage").val();
		var SecDepMonth = $("#txtGlobalSecDepMonth").val();
		var ConBondMonth = $("#txtGlobalConBondMonth").val();
		var AdvMonth = $("#txtGlobalAdvMonth").val();
		var ExhMonth = $("#txtGlobalExhMonth").val();

        if(MMS_Module == 'inquiry'){
        	var Area = 0;
			var Rate = 0;
          	var MonthlyRent = 0;
          	var SecDep = 0;
			var ConBond = 0;
			var AdvRent = 0;
			var ExhBond = 0;
        }else{
        	var Area = $("#txtGlobalArea").val().replace(/,/g, "");
			var Rate = $("#txtGlobalRate").val().replace(/,/g, "");
          	var MonthlyRent = ($("#txtNDTMonthlyRent").val()).replace(/,/g, "");
          	var SecDep = $("#txtGlobalSecDepAmount").val().replace(/,/g, "");
			var ConBond = $("#txtGlobalConBondAmount").val().replace(/,/g, "");
			var AdvRent = $("#txtGlobalAdvRent").val().replace(/,/g, "");
			var ExhBond = $("#txtGlobalExhAmount").val().replace(/,/g, "");
        }
        var isDaily = "";
        $("#chkGlobalisDaily").each(function(){
        	if($(this).is(":checked")){
        		isDaily = "daily";
        	}
        })
		var EscaRate = $("#txtProEscalationRate").val();
		var EscaRateStart = $("#txtProEscaRateStart").val();
		var EscaYearBasis = $("#txtProEscaYearBasis").val();
		var RentFreeCon = $("#txtProRentFreeCons").val();
		var RentFreeConStartDate = $("#txtProRentFreeConsStartDate").val();
		var SelectedUnits = "";
        $(".txtASU").each(function(){
            SelectedUnits += $(this).val() + "|";
        });
        var isVATable = $("#txtVATSetup").val();

        //Charges
        var Charges = "";
		$("#tblNDTCharges tr").each(function(){
			Charges += $(this).attr("id") + "|" + $(this).find(".getthisvalue").text().replace(/,/g, "") + "@";
		})

		//Terms and Conditions
		var TermsAndCondition = $("#sonyxperiax2017").val();

        //Requirements and Permits
        var Requirements = "";
        $("#tblProRequirements tr").each(function(){
            Requirements += $(this).attr("id") + "|";
        })
        var Permits = "";
        $("#tblProPermits tr").each(function(){
            Permits += $(this).attr("id") + "|";
        })

        //Remarks
        if(InquiryID == ""){
            var Remarks = $("#txtSubLeadInqRemarks").val();
        }else{
            var Remarks = "";
        }
		var Escalation = "";
		var EscalatedRate = 0;
        $("#tbodyEscalation tr").each(function(){
        	EscalatedRate += parseFloat($(this).find(".txtEscalation").val());
        	Escalation += $(this).find("td").eq(0).text() + "|" + $(this).find(".txtEscalation").val() + "|" + EscalatedRate + "@";
        })
		$.ajax({
	        type: 'POST',
	        url: 'global_form/class.php',
	        data: 	'MMS_Module=' + MMS_Module +'&InquiryID=' + InquiryID + '&TenantID=' + TenantID + '&isAmendment=' + isAmendment + '&ApplicationID=' + ApplicationID + '&isProposal=' + isProposal +'&TradeID=' + TradeID + '&TradeName=' + TradeName + '&Merchant_Code=' + Merchant_Code + '&CompanyID=' + CompanyID + '&CompanyName=' + CompanyName + '&IndustryID=' + IndustryID + '&ProcessOwner=' + ProcessOwner + '&Source=' + Source + '&Classification=' + Classification + '&Department=' + Department + '&Category=' + Category + '&BillerID=' + BillerID + '&AccredStat=' + AccredStat +'&POSCount=' + POSCount + '&DateFrom=' + DateFrom + '&DateTo=' + DateTo + '&YearTerm=' + YearTerm + '&MonthTerm=' + MonthTerm + '&DayTerm=' + DayTerm + '&Area=' + Area + '&Rate=' + Rate + '&BillingType=' + BillingType + '&BillPercent=' + BillPercent + '&SecDepMonth=' + SecDepMonth + '&ConBondMonth=' + ConBondMonth + '&AdvMonth=' + AdvMonth + '&MonthlyRent=' + MonthlyRent + '&SecDep=' + SecDep + '&ConBond=' + ConBond + '&AdvRent=' + AdvRent + '&ExhMonth=' + ExhMonth + '&ExhBond=' + ExhBond + '&isDaily=' + isDaily + '&EscaRate=' + EscaRate + '&EscaRateStart=' + EscaRateStart + '&EscaYearBasis=' + EscaYearBasis + '&RentFreeCon=' + RentFreeCon + '&RentFreeConStartDate=' + RentFreeConStartDate + '&SelectedUnits=' + SelectedUnits + '&isVATable=' + isVATable + '&Charges=' + Charges + '&TermsAndCondition=' + TermsAndCondition + '&Requirements=' + Requirements + '&Permits=' + Permits + '&Remarks=' + Remarks + '&Escalation=' + Escalation + '&form=fncSaveGlobalForm',
	        beforeSend: function(){
				$('#frmLoadingGlobalFrom').addClass('myspinner');
			},
	        success:function(data){
                $('#frmLoadingGlobalFrom').removeClass('myspinner');
				$("#btnGlobalSave").button('reset');
	            var arr = data.split("|");
	            var Action = "";
	            var ActionArr = "";
	            if(arr[0] == 1){
	            	if(MMS_Module == 'inquiry'){
	            		Action = "fncCloseInquiry";
	            		ActionArr = "";
	            	}else if(MMS_Module == 'leasingapplication'){
	            		if(isProposal == ''){
	            			Action = "fncCloseInquiry";
	            			ActionArr = "";
	            		}else{
	            			Action = "fncCloseProposal";
	            			ActionArr = InquiryID+"|";
	            		}
	            		fncUploadReqAndPermit(InquiryID, ApplicationID);
	            	}else if(MMS_Module == 'tenants'){
	            		if(isAmendment == "1"){
	            			Action = "fncCloseNewContract";
		            		ActionArr = "";
	            		}else{
	            			Action = "fncCloseNewTenant";
		            		ActionArr = "";
	            		}
	            		fncUploadReqAndPermit(arr[2], arr[3]);
	            	}else if(MMS_Module == 'reservation'){
	            		Action = "fncCloseReservationUpdate";
	            		ActionArr = "";
	            		fncUploadReqAndPermit(InquiryID, ApplicationID);
	            	}
	            	if(btnAction == 'New'){
	            		setTimeout(function(){
	                        showmodal("alert", arr[1], Action, ActionArr, "", null, "0");
	                    }, 500)
	            	}
	            }else{
                    setTimeout(function(){
                        showmodal("alert", arr[1], "", null, "", null, "0");
                    }, 500)
	            }
	        }
	    })
	}

	function fncUploadReqAndPermit(InquiryID, ApplicationID){
		$(".txtRequirementInquiryID").val(InquiryID);
		$(".txtRequirementApplicationID").val(ApplicationID);
		$(".txtPermitInquiryID").val(InquiryID);
		$(".txtPermitApplicationID").val(ApplicationID);
		$(".form_lease_application_req_2").each(function(){
	    	var data = new FormData($('#'+$(this).attr("id"))[0]);
	    	$.ajax({
	      		type: 'POST',
	      		url: 'Uploads/uploadappreq.php',
	      		data: data,
	      		mimeType: 'multipart/form-data',
	      		contentType: false,
	      		cache: false,
	      		async: false,
	      		processData: false,
	      		success:function(data){

	      		}
    		});
        })
        $(".form_lease_application_permit").each(function(){
	    	var data = new FormData($('#'+$(this).attr("id"))[0]);
	    	$.ajax({
	      		type: 'POST',
	      		url: 'Uploads/uploadpermitreq.php',
	      		data: data,
	      		mimeType: 'multipart/form-data',
	      		contentType: false,
	      		cache: false,
	      		async: false,
	      		processData: false,
	      		success:function(data){
					
	      		}
    		});
        })
	}

	function fncEditGlobalFormInquiry(mdlAction, InquiryID, ApplicationID, LeadsID, TradeID, CompanyID, isProposal, ProposalStat, isEvent, TenantID, isAmendment){
		$("#btnGlobalSave").button('reset');
		var typeurl = "<?php echo $_GET['url']; ?>";
		if(isEvent == 0 && (typeurl == 'inquiry')){
			// $("#btncreateevents").css("margin-top", "10px");
			$("#btncreateevents").removeClass("hide");
			$("#btncreateevents").attr("onclick", "fnccreateeventsx(\""+ InquiryID +"\", \""+ isEvent +"\")");
		}else{
			// $("#btncreateevents").css("margin-top", "0px;");
			$("#btncreateevents").addClass("hide");
			$("#btncreateevents").attr("onclick", "");
		}
		$("#mdlAddNewInquiry").modal("show");
		$("#txtGlobalFormInquiryID").val(InquiryID);
		$("#txtGlobalFormApplicationID").val(ApplicationID);
		$("#isProposal").val(isProposal);
		$("#txtGlobalFormTenantID").val(TenantID);
		$("#txtGlobalisAmendment").val(isAmendment);
		$("#divNewInquiryRemarks").removeClass("hide");
        $("#btnSend2Leasing").css("display", "inline-block");
		$(".txtGlobalClear").css("border-color","#D5D5D5");
        fncLoadRemarks(InquiryID, TenantID);
        fncSelectTradeProfile(CompanyID, TradeID);
        fncLoadInqOtherInfo(InquiryID, ApplicationID, isProposal, ProposalStat, isAmendment);
        $.ajax({
            type: 'POST',
            url: 'global_form/class.php',
            data: 'InquiryID=' + InquiryID + '&form=fncInqUpdateInfo',
            success:function(data){
                var arr = data.split("|");
                $("#txtinq_createdby").text(arr[1]);
                $("#txtinq_datecreated").text(arr[0]);
                $("#txtinq_modifby").text(arr[3]);
                $("#txtinq_modifdate").text(arr[2]);
                if(arr[0] != "" || arr[1] != ""){
                    $(".updatedby_texts").css("display", "block");
                }else{
                    $(".updatedby_texts").css("display", "none");
                }
                if(arr[2] != "" || arr[3] != ""){
                    $(".modified_info").css("display", "block");
                }else{
                    $(".modified_info").css("display", "none");
                }
            }
        })
        if(ProposalStat == "1"){
        	$(".divReqPerProposal").css("display", "none");
        	$(".divReqPerProposal2").css("display", "block");
        }else{
        	$(".divReqPerProposal").css("display", "block");
        	$(".divReqPerProposal2").css("display", "none");
        }
        if(mdlAction == "1"){
            $(".txtInqDisabled").prop("disabled",  true);
        }else{
            $(".txtInqDisabled").prop("disabled",  false);
        }
        if(isAmendment == "1"){
        	$("#txtNDTdateFrom").prop("disabled", true);
        }else{
        	$("#txtNDTdateFrom").prop("disabled", false);
        }
	}

	function fncLoadInqOtherInfo(InquiryID, ApplicationID, isProposal, ProposalStat, isAmendment){
        $.ajax({
            type: 'POST',
            url: 'global_form/class.php',
            data: 'InquiryID=' + InquiryID + '&isProposal=' + isProposal + '&isAmendment=' + isAmendment + '&form=fncLoadInqOtherInfo',
            success: function(data){
                var arr = data.split("|");
                $("#txtGFrom-Source").val(arr[0]);
                $("#txtGForm-ProcessOwner").val(arr[1]);
                $("#txtNDTClassification").val(arr[2]);
            	fncChangeBillingType(arr[5]);
            	if(arr[5] == "" || arr[5] == 'undefined'){
	                $("#txtNDTBillingType").val("Rent");
	            }else{
                	$("#txtNDTBillingType").val(arr[5]);
            	}
				$("#txtNDTPercentage").val(arr[6]);
                $("#txtNDTdateFrom").val(arr[7]);
				$("#txtNDTdateTo").val(arr[8]);
				$("#txtNDTYearcount").val(arr[9]);
				$("#txtNDTMonthcount").val(arr[10]);
                $("#txtNDTMonthlyRent").val(arr[11]);
				$("#txtProEscalationRate").val(arr[12]);
				$("#txtProEscaRateStart").val(arr[13]);
				$("#txtProEscaYearBasis").val(arr[14]);
				$("#txtProRentFreeCons").val(arr[15]);
				DelProRentConsStarDate(arr[15]);
				// $("#txtProRentFreeConsStartDate").val(arr[16]);
                fncclickBillProfile(arr[17]);
                if(arr[18] == ""){
                	$("#txtVATSetup").val("0");
	            }else{
	                $("#txtVATSetup").val(arr[18]);
	            }
	            $("#txtGlobalSecDepMonth").val(arr[19]);
				$("#txtGlobalAdvMonth").val(arr[20]);
				$("#txtGlobalConBondMonth").val(arr[21]);
	            $("#txtGlobalSecDepAmount").val(arr[22]);
				$("#txtGlobalAdvRent").val(arr[23]);
				$("#txtGlobalConBondAmount").val(arr[24]);
				$("#txtGlobalDayCount").val(arr[25]);
				if(arr[26] == 'daily'){
					$("#chkGlobalisDaily").prop("checked", true);
					$("#txtNDTYearcount").attr("readonly", "readonly");
					$("#txtNDTMonthcount").attr("readonly", "readonly");
					$("#txtGlobalDayCount").removeAttr("readonly");
				}else{
					$("#chkGlobalisDaily").prop("checked", false);
					$("#txtNDTYearcount").removeAttr("readonly");
					$("#txtNDTMonthcount").removeAttr("readonly");
					$("#txtGlobalDayCount").attr("readonly", "readonly");
				}
                $("#txtGlobalArea").val(arr[27]);
				$("#txtGlobalRate").val(arr[28]);
				$("#txtGlobalExhMonth").val(arr[29]);
				$("#txtGlobalExhAmount").val(arr[30]);
                $.ajax({
                    type: 'POST',
                    url: 'mainclass.php',
                    data: 'Classification=' + arr[2] + '&form=fncAllDepartmentRef',
                    success: function(data){
                        $("#txtNDTDepartment").html(data);
                    }, complete: function(){
                        $("#txtNDTDepartment").val(arr[3]);
                        $.ajax({
                            type: 'POST',
                            url: 'mainclass.php',
                            data: 'Department=' + arr[3] + '&form=fncAllCategoryRef',
                            success: function(data){
                                $("#txtNDTCategory").html(data);
                            }, complete: function(){
                                $("#txtNDTCategory").val(arr[4]);
                            }
                        })
                    }
                })
            }, complete: function(){
        		<?php if($_GET['url'] != 'inquiry'){ ?>
	            	fncLoadEscalation(InquiryID, isProposal);
	                fncLoadUnitProposal(InquiryID, isProposal);
	                fncLoadChargeProposal(InquiryID, isProposal);
	                fncLoadTermsandCon(InquiryID, isProposal);
	                fncLoadPaymentList(InquiryID);
	                getTotalMonthlyCharges();
	                if(isAmendment == "1"){
	                	$.ajax({
							type: 'POST',
							url: 'global_form/class.php',
							data: 'form=getreqlist',
							success:function(data){
								$("#div_modal_inquiry_requirements").html(data);
							}, complete: function(){
								fncSpecialScripts();
							}
						})
						$.ajax({
							type: 'POST',
							url: 'global_form/class.php',
							data: 'form=getperlist',
							success:function(data){
								$("#div_modal_inquiry_permits").html(data);
							}, complete: function(){
								fncSpecialScripts();
							}
						})
	                }else{
	                	// if(ProposalStat == "1"){
							fncloadReqPerupload(InquiryID, isProposal, ApplicationID);
		                // }else{
		                	fncLoadPermits(InquiryID, isProposal);
		                	fncLoadRequirements(InquiryID, isProposal);
	                	// }
	                }
                <?php } ?>
            }
        })
    }

    function fncLoadEscalation(InquiryID, isProposal){
    	$.ajax({
    		type: 'POST',
    		url: 'global_form/class.php',
    		data: 'InquiryID=' + InquiryID + '&isProposal=' + isProposal + '&form=fncLoadEscalation',
    		success: function(data){
    			$("#tbodyEscalation").html(data);
    		}, complete: function(){
                fncgetPaymentSchedule();
    		}
    	})
    }

    function fncLoadUnitProposal(InquiryID, isProposal){
        var UnitIDs = "";
        $.ajax({
            type: 'POST',
            url: 'global_form/class.php',
            data: 'InquiryID=' + InquiryID + '&isProposal=' + isProposal + '&form=fncLoadUnitProposal',
            success: function(data){
                var arr = data.split("|");
                $("#divUnitInformation").html(arr[0]);
                // $("#txtNDTMonthlyRent").val(arr[1]);
                $("#txtNDTMonthlyRentOrig").val(arr[1]);
                UnitIDs = arr[2];
            }, complete: function(){
                var arr = UnitIDs.split("|");
                for(var i=0; i<=arr.length-1; i++){
                    var colorbox_params = {
                        rel: 'cbProUnitList-' + arr[i],
                        reposition: true,
                        scalePhotos: true,
                        scrolling: false,
                        title: false,
                        previous: '<i class="ace-icon fa fa-arrow-left"></i>',
                        next: '<i class="ace-icon fa fa-arrow-right"></i>',
                        close: '&times;',
                        current: '{current} of {total}',
                        maxWidth: '100%',
                        maxHeight: '100%',
                        onComplete: function(){
                            $.colorbox.resize();
                        }
                    }
                    $('[data-rel="cbProUnitList-'+ arr[i] +'"]').colorbox(colorbox_params);
                    $('#cboxLoadingGraphic').append("<i class='ace-icon fa fa-spinner orange'></i>");
                }
                fncgetPaymentSchedule();
            }
        })
    }

    function fncLoadChargeProposal(InquiryID, isProposal){
		var VATSetup = $("#VattxtVATSetup").val();
        $.ajax({
            type: 'POST',
            url: 'global_form/class.php',
            data: 'InquiryID=' + InquiryID + '&isProposal=' + isProposal + '&VATSetup' + VATSetup + '&form=fncLoadChargeProposal',
            success:function(data){
                $("#tblNDTCharges").html(data);
            }, complete: function(){
                fncgetPaymentSchedule();
                getTotalMonthlyCharges();
            }
        })        
    }

    function fncLoadTermsandCon(InquiryID, isProposal){
        $.ajax({
            type: 'POST',
            url: 'global_form/class.php',
            data: 'InquiryID=' + InquiryID + '&isProposal=' + isProposal + '&form=fncLoadTermsandCon',
            success:function(data){
                var arr = data.split("@");
                $("#div_termsandcondition").html(arr[0]);
                $("#sonyxperiax2017").val(arr[1]);
            }, complete: function(){
                checkSelected();
            }
        })  
    }

    function fncLoadRequirements(InquiryID, isProposal){
        $.ajax({
            type: 'POST',
            url: 'global_form/class.php',
            data: 'InquiryID=' + InquiryID + '&isProposal=' + isProposal + '&form=fncLoadRequirements',
            success:function(data){
                $("#tblProRequirements").html(data);
            }
        })
    }

    function fncLoadPermits(InquiryID, isProposal){
        $.ajax({
            type: 'POST',
            url: 'global_form/class.php',
            data: 'InquiryID=' + InquiryID + '&isProposal=' + isProposal + '&form=fncLoadPermits',
            success:function(data){
                $("#tblProPermits").html(data);
            }
        })
    }

    function fncloadReqPerupload(InquiryID, isProposal, ApplicationID){
    	$("#txtGFAddedReq").val("1000000000");
		$("#txtGFAddedPer").val("1000000000");
    	$.ajax({
			type: 'POST',
			url: 'global_form/class.php',
			data: 'InquiryID=' + InquiryID + '&isProposal=' + isProposal + '&ApplicationID=' + ApplicationID + '&form=fncloadReqUpload',
			success: function(data){
			  	$("#div_modal_inquiry_requirements").html(data);
			}, complete: function(){
				fncSpecialScripts();
			}
		})
		$.ajax({
			type: 'POST',
			url: 'global_form/class.php',
			data: 'InquiryID=' + InquiryID + '&isProposal=' + isProposal + '&ApplicationID=' + ApplicationID + '&form=fncloadPerUpload',
			success: function(data){
			  	$("#div_modal_inquiry_permits").html(data);
			}, complete: function(){
				fncSpecialScripts();
			}
		})
    }

    function fncLoadPaymentList(InquiryID){
    	$.ajax({
    		type: 'POST',
    		url: 'global_form/class.php',
    		data: '&InquiryID=' + InquiryID + '&form=fncLoadPaymentList',
    		success: function(data){
    			$("#tblResPayment").html(data);
    		}
    	})
	}

    function fncSendToLeasing(){
        setTimeout(function(){
            showmodal("confirm", "Are you sure you want to create proposal in this inquiry?", "fncSendToLeasing2", "", "", null, "1");
        }, 500)
    }

    function fncSendToLeasing2(){
        var InquiryID = $("#txtGlobalFormInquiryID").val();
		$("#btnSend2Leasing").button('loading');
        $.ajax({
            type: 'POST',
            url: 'global_form/class.php',
            data: 'InquiryID=' + InquiryID + '&form=fncSendToLeasing',
            success: function(data){
				$("#btnSend2Leasing").button('reset');
                if(data == 1){
                    setTimeout(function(){
                        showmodal("alert", "Proposal successfully created.", "fncCloseInquiry", null, "", null, "0");
                    }, 500)
                    fncSaveGlobalForm('UpdateOnly');
                }else{
                    setTimeout(function(){
                        showmodal("alert", "Failed send inquiry to leasing.", "", null, "", null, "1");
                    }, 500)
                }
            }
        });
    }

    function chkclippeddocx(thisfile){
	  	var sel = "";
	  	$(".req_already_added_na").each(function(){
	    	var added = $(this).attr("id");
	    	sel += added + "|";
	  	})
	  	$(".form_lease_application_req_2").each(function(){
	    	var form_id = $(this).attr("id");
	    	var inputfile = $(this).find(".upload_app_req");
	    	var empty = $(this).find("a[class='remove']");
	    	var thisicon = $(this).find(".icon-status-req");
	    	var files  = inputfile.prop("files");
	    	var names = $.map(files, function(val) { return val.name; });
	    	if(names != ""){
		        $("#"+form_id+"_icon").removeClass("fa-remove");
		        $("#"+form_id+"_icon").addClass("fa-check");
		        $("#"+form_id+"_icon").css("color", "green");
		        sel += names + "|";
	    	}else{

	    	}
	  	});
	    var files2  = thisfile.prop("files");    
	    var aso = $.map(files2, function(val) { return val.name; });
	    var arr = sel.split("|");
	    var i = 0;
	    var c = 0;
	    for(i=0; i<=arr.length-1; i++){
	      	if(aso == arr[i]){
	        	c++;
	      	}
	    }
	    if(c >= 2){
			setTimeout(function(){
				showmodal("alert", "Sorry, but you already attached the same file.", "", null, "", null, "1");
			}, 500)
	      	thisfile.click();
	    }
	}

	function chkclippeddocx2(thisfile){
	  	var sel = "";
	  	$(".req_already_added_na2").each(function(){
	    	var added = $(this).attr("id");
	    	sel += added + "|";
	  	})
	  	$(".form_lease_application_permit").each(function(){
	    	var form_id = $(this).attr("id");
	    	var inputfile = $(this).find(".upload_app_permit");
	    	var empty = $(this).find("a[class='remove']");
	    	var thisicon = $(this).find(".icon-status-permit");
	    	var files  = inputfile.prop("files");
	    	var names = $.map(files, function(val) { return val.name; });
	    	if(names != ""){
		        $("#"+form_id+"_icon").removeClass("fa-remove");
		        $("#"+form_id+"_icon").addClass("fa-check");
		        $("#"+form_id+"_icon").css("color", "green");
		        sel += names + "|";
	    	}else{

	    	}
	  	});
	    var files2  = thisfile.prop("files");    
	    var aso = $.map(files2, function(val) { return val.name; });
	    var arr = sel.split("|");
	    var i = 0;
	    var c = 0;
	    for(i=0; i<=arr.length-1; i++){
	      	if(aso == arr[i]){
	        	c++;
	      	}
	    }
	    if(c >= 2){
			setTimeout(function(){
				showmodal("alert", "Sorry, but you already attached the same file.", "", null, "", null, "1");
			}, 500)
	      	thisfile.click();
	    }
	}

	function fncAddPayment(){
		$("#mdl_NDTPayment").modal("show");
		$("#mdl_NDTPayment :input").val("");
		$.ajax({
			type: 'POST',
            url: 'mainclass.php',
            data: 'form=getPaymentType',
            success: function(data){
            	$("#txtGlobalPaymentType").html(data);
            }, complete: function(){
            	$("#txtGlobalPaymentType").val("CASH|CASH").trigger("change");
            }
		})
		$.ajax({
    		type: 'POST',
    		url: 'mainclass.php',
    		data: 'form=tblrefbank',
    		success: function(data){
    			$(".selectbanktype").html(data);
    		}
    	})
		$.ajax({
    		type: 'POST',
    		url: 'mainclass.php',
    		data: 'form=tblref_cardtype',
    		success: function(data){
    			$("#txtGlobalCardType").html(data);
    		}
    	})
	}

	function fncChangePaymentType(type){
		var arr = type.split("|");
		if(arr[1] == "CREDIT CARD"){
			$(".ptcredcard").addClass("thisisrequired");
			$(".ptdebcard").removeClass("thisisrequired");
			$(".ptbanktransfer").removeClass("thisisrequired");
			$(".ptcheck").removeClass("thisisrequired");

			$(".checkgroup").css("display", "none");
			$(".cardgroup").css("display", "block");
			$(".cardgroup input[type=text]").val("");
			$("#txtpaymentamount").css("display", "block");
			$("#txtpaymentamount").val("");
			$("#row_ex_date").css("display", "block");
			// enable/disable texts
			$(".checkgroup").attr("disabled", "disabled");
			$(".cardgroup").removeAttr("disabled");
			$("#txtpaymentamount").removeAttr("disabled");
			$(".banktrans").attr("disabled", "disabled");
			$(".banktrans").css("display", "none");
		}else if(arr[1] == "BANK DEPOSIT"){
			$(".ptcredcard").removeClass("thisisrequired");
			$(".ptdebcard").removeClass("thisisrequired");
			$(".ptbanktransfer").addClass("thisisrequired");
			$(".ptcheck").removeClass("thisisrequired");

			$(".checkgroup").css("display", "none");
			$(".cardgroup").css("display", "none");
			$(".checkgroup input[type=text]").val("");
			$(".cardgroup input[type=text]").val("");
			$("#txtpaymentamount").css("display", "block");
			$("#txtpaymentamount").val("");
			// enable/disable texts
			$(".checkgroup").attr("disabled", "disabled");
			$(".cardgroup").attr("disabled", "disabled");
			$("#txtpaymentamount").removeAttr("disabled");
			$(".banktrans").removeAttr("disabled");
			$(".banktrans").css("display", "block");
		}else if(arr[1] == "CHECK"){
			$(".ptcredcard").removeClass("thisisrequired");
			$(".ptdebcard").removeClass("thisisrequired");
			$(".ptbanktransfer").removeClass("thisisrequired");
			$(".ptcheck").addClass("thisisrequired");

			$(".checkgroup").css("display", "block");
			$(".cardgroup").css("display", "none");
			$(".checkgroup input[type=text]").val("");
			// enable/disable texts
			$(".checkgroup").removeAttr("disabled");
			$(".cardgroup").attr("disabled", "disabled");
			$(".banktrans").attr("disabled", "disabled");
			$(".banktrans").css("display", "none");
		}else{
			$(".ptcredcard").removeClass("thisisrequired");
			$(".ptdebcard").removeClass("thisisrequired");
			$(".ptbanktransfer").removeClass("thisisrequired");
			$(".ptcheck").removeClass("thisisrequired");

			$(".checkgroup").css("display", "none");
			$(".cardgroup").css("display", "none");
			$(".checkgroup input[type=text]").val("");
			$(".cardgroup input[type=text]").val("");
			$("#txtpaymentamount").css("display", "block");
			$("#txtpaymentamount").val("");
			// enable/disable texts
			$(".checkgroup").attr("disabled", "disabled");
			$(".cardgroup").attr("disabled", "disabled");
			$("#txtpaymentamount").removeAttr("disabled");
			$(".banktrans").attr("disabled", "disabled");
			$(".banktrans").css("display", "none");
		}
	}

	function fncSavePayment(){
		$("#btnPostPayment").button("loading");
		var PaymentType = $("#txtGlobalPaymentType").val();
		var arr = PaymentType.split("|");
		var Amount = $("#txtGlobalPayment").val().replace(/,/g, "");
		if(arr[1] == "CREDIT CARD"){
			var CardHolder = $("#txtGlobalCardType").val();
			var CardType = $("#txtGlobalCardHolder").val();
			var Authentication = $("#txtGlobalAuthNo").val();
			var SecurityCode = $("#txtGlobalSecCode").val();
			var CC = $("#txtGlobalCC1").val() + "-" + $("#txtGlobalCC2").val() + "-" + $("#txtGlobalCC3").val() + "-" + $("#txtGlobalCC4").val();
			var ExpiryDate = $("#txtGlobalExpDateMonth").val() + "-" + $("#txtGlobalExpDateYear").val();
			var BankFrom = "";
			var AccountFrom = "";
			var BankTo = "";
			var AccountTo = "";
			var CheckNo = "";
			var CheckDate = "";
			var CheckName = "";
			var CheckBank = "";
		}else if(arr[1] == "BANK DEPOSIT"){
			var CardHolder = "";
			var CardType = "";
			var Authentication = "";
			var SecurityCode = "";
			var CC = "";
			var ExpiryDate = "";
			var BankFrom = $("#txtGlobalBankFrom").val();
			var AccountFrom = $("#txtGlobalAccountFrom").val();
			var BankTo = $("#txtGlobalBankTo").val();
			var AccountTo = $("#txtGlobalAccoutnTo").val();
			var CheckNo = "";
			var CheckDate = "";
			var CheckName = "";
			var CheckBank = "";
		}else if(arr[1] == "CHECK"){
			var CardHolder = "";
			var CardType = "";
			var Authentication = "";
			var SecurityCode = "";
			var CC = "";
			var ExpiryDate = "";
			var BankFrom = "";
			var AccountFrom = "";
			var BankTo = "";
			var AccountTo = "";
			var CheckNo = $("#txtGlobalCheckNo").val();
			var CheckDate = $("#txtGlobalCheckDate").val();
			var CheckName = $("#txtGlobalCheckName").val();
			var CheckBank = $("#txtGlobalCheckBank").val();
		}else{
			var CardHolder = "";
			var CardType = "";
			var Authentication = "";
			var SecurityCode = "";
			var CC = "";
			var ExpiryDate = "";
			var BankFrom = "";
			var AccountFrom = "";
			var BankTo = "";
			var AccountTo = "";
			var CheckNo = "";
			var CheckDate = "";
			var CheckName = "";
			var CheckBank = "";
		}
		var orNo = $("#txtPaymentORNo").val();
		var Particulars = $("#txtPaymentParticulars").val();
		var InquiryID = $("#txtGlobalFormInquiryID").val();
		$.ajax({
			type: 'POST',
			url: 'global_form/class.php',
			data: 'PaymentTypeCode=' + arr[0] + '&PaymentType=' + arr[1] + '&Amount=' + Amount + '&CardHolder=' + CardHolder + '&CardType=' + CardType + '&Authentication=' + Authentication + '&SecurityCode=' + SecurityCode + '&CC=' + CC + '&ExpiryDate=' + ExpiryDate + '&BankFrom=' + BankFrom + '&AccountFrom=' + AccountFrom + '&BankTo=' + BankTo + '&AccountTo=' + AccountTo + '&CheckNo=' + CheckNo + '&CheckDate=' + CheckDate + '&CheckName=' + CheckName + '&CheckBank=' + CheckBank + '&orNo=' + orNo + '&Particulars=' + Particulars + '&InquiryID=' + InquiryID + '&form=fncSavePayment',
			success: function(data){
				$("#btnPostPayment").button("reset");
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", "Payment successfully posted.", "fncClosePaymentForm", InquiryID+"|", "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", "Failed to post payment.", "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}

	function fncClosePaymentForm(InquiryID){
		$("#mdl_NDTPayment").modal("hide");
		loadReservationList();
		fncLoadPaymentList(InquiryID);
	}

	function fncCreateContractConfirm(InquiryID, ProposalNum){
		setTimeout(function(){
			showmodal("confirm", "Are you sure you want to create a contract for this prospect tenant?.", "fncCreateContract", InquiryID+"|"+ProposalNum+"|", "", null, "0");
		}, 500)
	}

	function fncCreateContract(InquiryID, ProposalNum){
		$.ajax({
			type: 'POST',
			url: 'global_form/class.php',
			data: 'InquiryID=' + InquiryID + '&ProposalNum=' + ProposalNum + '&form=fncCreateContract',
			success: function(data){
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", "Contract successfully created.", "loadReservationList", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", "Failed to create contract.", "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}

	function fncViewContractStat(InquiryID, ContractID){
		$.ajax({
			type: 'POST',
			url: 'global_form/class.php',
			data: 'InquiryID=' + InquiryID + '&ContractID=' + ContractID + '&form=fncViewContractStat',
			success: function(data){
				$("#divContractStat").html(data);
			}, complete: function(){
				$("#mdlContractStat").modal("show");
				$("#btnContractApprove").attr("onclick", "fncChangeApproveContract(\""+ InquiryID +"\", \""+ ContractID +"\", \"Approve\")")
				$("#btnContractDisapprove").attr("onclick", "fncChangeApproveContract(\""+ InquiryID +"\", \""+ ContractID +"\", \"Disapprove\")")
			}
		})
	}

	function fncChangeContractStat(InquiryID, ContractID, Status){
		setTimeout(function(){
			showmodal("confirm", "Are you sure you want to "+ Status +" this prospect tenant?.", "fncChangeContractStat2", InquiryID+"|"+ContractID+"|"+Status+"|", "", null, "0");
		}, 500)
	}

	function fncChangeContractStat2(InquiryID, ContractID, Status){
		$("#mdlContractStat").modal("hide");
		$.ajax({
			type: 'POST',
			url: 'global_form/class.php',
			data: 'InquiryID=' + InquiryID + '&ContractID=' + ContractID + '&Status=' + Status + '&form=fncChangeContractStat2',
			success: function(data){
				var arr = data.split("|");
				if(arr[0] == 1){
					$("#mdl_ShowTenantID").modal("show");
					$("#txtReservationTenantID").text(arr[1]);
					setTimeout(function(){
						$("#mdl_ShowTenantID").modal("hide");
						$("#txtReservationTenantID").text("");
						loadReservationList();
					}, 8000)
				}else{
					setTimeout(function(){
						showmodal("alert", "Failed to create contract.", "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}

	function fncOccupyUnit(InquiryID, TenantID, isOccupy){
		setTimeout(function(){
			showmodal("confirm", "This action cannot be undone, do you want to proceed?", "fncOccupyUnit2", InquiryID+"|"+TenantID+"|"+isOccupy+"|", "", null, "0");
		}, 500)
	}

	function fncOccupyUnit2(InquiryID, TenantID, isOccupy){
		if(isOccupy == "1"){
			$.ajax({
				type: 'POST',
				url: 'global_form/class.php',
				data: 'InquiryID=' + InquiryID + '&TenantID=' + TenantID + '&form=fncOccupyUnit2',
				success: function(data){
					if(data == 1){
						setTimeout(function(){
							showmodal("alert", "Tenant status successfully occupied the unit(s).", "loadReservationList", null, "", null, "0");
						}, 500)
					}else{
						setTimeout(function(){
							showmodal("alert", "Failed to update tenant status.", "", null, "", null, "1");
						}, 500)
					}
				}
			})
		}else{
			setTimeout(function(){
				showmodal("alert", "Sorry but this tenant cannot occupy the unit yet.", "", null, "", null, "1");
			}, 500)
		}
	}

	function fncCancelApplication(InquiryID){
		setTimeout(function(){
			showmodal("confirm", "Are you sure you want to cancel this application?", "fncCancelApplication2", InquiryID+"|", "", null, "0");
		}, 500)
	}

	function fncCancelApplication2(InquiryID){
		$.ajax({
			type: 'POST',
			url: 'global_form/class.php',
			data: 'InquiryID=' + InquiryID + '&form=fncCancelApplication2',
			success: function(data){
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", "Application successfully cancelled.", "tblListofApplication", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", "Failed to cancel application.", "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}

	function fncPreviewProposal(InquiryID, TradeID, CompanyID, ProposalNum, LCode, DocType, ContractID){
		$.ajax({
            type: 'POST',
            url: 'global_form/class.php',
            data: 'InquiryID=' + InquiryID + '&TradeID=' + TradeID + '&CompanyID=' + CompanyID + '&ProposalNum=' + ProposalNum + '&LCode=' + LCode + '&DocType=' + DocType + '&ContractID=' + ContractID + '&form=fncPreviewProposal',
            success: function(data){
                $("#div_ProposalPreview").modal("show");
                $("#div_CustomProposal").html(data);
                $("#txtProposalHeader").text("Proposal "+ ProposalNum);
            }
        })
	}


	function fncPrintProposal(){
		var toPrint = document.getElementById("div_CustomProposal");
        var myheight = $(window).height();
        var mywidth = $(window).width();
        var popupWin = window.open("", "", "height=" + myheight + ",width=" + mywidth + ",location=no,scrollbars=1,left=" + 20);
            popupWin.document.open();
            popupWin.document.write('<html><title></title><body onload="window.print();">' );
            popupWin.document.write( toPrint.innerHTML);
            popupWin.document.write('</body></html>');
            popupWin.document.close();
	}

	function fncChangeSecDep(){
		var Rent = ($("#txtNDTMonthlyRent").val()).replace(/,/g, "");
		var SecDepMonth = $("#txtGlobalSecDepMonth").val();
		// if(SecDepMonth == 0){
		// 	$("#txtGlobalSecDepAmount").val(parseFloat(Rent).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
		// }else{
			$("#txtGlobalSecDepAmount").val(parseFloat(SecDepMonth * Rent).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
		// }
	}

	function fncChangeConBond(){
		var Rent = ($("#txtNDTMonthlyRent").val()).replace(/,/g, "");
		var ConBondMonth = $("#txtGlobalConBondMonth").val();
		// if(ConBondMonth == 0){
		// 	$("#txtGlobalConBondAmount").val(parseFloat(Rent).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
		// }else{
			$("#txtGlobalConBondAmount").val(parseFloat(ConBondMonth * Rent).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
		// }
	}

	function fncChangeExbBond(){
		var Rent = ($("#txtNDTMonthlyRent").val()).replace(/,/g, "");
		var ExhMonth = $("#txtGlobalExhMonth").val();
		// if(ConBondMonth == 0){
		// 	$("#txtGlobalConBondAmount").val(parseFloat(Rent).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
		// }else{
			$("#txtGlobalExhAmount").val(parseFloat(ExhMonth * Rent).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
		// }
	}

	function getTotalMonthlyCharges(){
		var totalAmount = 0;
		$("#tblNDTCharges tr").each(function(){
			totalAmount += parseFloat($(this).find(".getthisvalue").text());
		})
		$("#txtNDTMonthlyCharges").val(totalAmount.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
		fncSaveFixedRent();
	}

	function fncgetEscalationSched(){
		var DateFrom = $("#txtNDTdateFrom").val();
		var DateTo = $("#txtNDTdateTo").val();
		var EscaStart = $("#txtProEscaRateStart").val();
		var YearBasis = $("#txtProEscaYearBasis").val();
		var EscaRate = $("#txtProEscalationRate").val();
		if(EscaStart >= 1 && YearBasis >= 1 && EscaRate >= 1){
			$.ajax({
				type: 'POST',
				url: 'global_form/class.php',
				data: '&DateFrom=' + DateFrom + '&DateTo=' + DateTo + '&EscaStart=' + EscaStart + '&YearBasis=' + YearBasis + '&EscaRate=' + EscaRate + '&form=fncgetEscalationSched',
				success: function(data){
					$("#tbodyEscalation").html(data);
				}, complete: function(){
                	fncgetPaymentSchedule();
				}
			})
		}else{
			$("#tbodyEscalation").html("");
		}
	}

	function fncgetRent(){
		var BillingType = $("#txtNDTBillingType").val();
		if(BillingType == "Share Only" || BillingType == "Share Only2"){
			$("#txtNDTMonthlyRent").val("0.00");
			$("#txtGlobalRate2").removeClass("hide");
			$("#txtGlobalRate").attr("readonly", "readonly");
			$("#txtGlobalRate").addClass("hide");
		}else{
			var Area = $("#txtGlobalArea").val().replace(/,/g, "");
			var Rate = $("#txtGlobalRate").val().replace(/,/g, "");
			var totalRent = parseFloat(Area) * parseFloat(Rate);
			$("#txtNDTMonthlyRent").val(totalRent.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
			$("#txtGlobalRate").removeAttr("readonly");
			$("#txtGlobalRate").removeClass("hide");
			$("#txtGlobalRate2").addClass("hide");
		}
		fncSaveFixedRent();
	}

	function fncSelectReportType(InquiryID, ReportType, ProposalNum, ContractID){
        $("#mdlProposalselectprint").modal('show');
        $.ajax({
            type: 'POST',
            url: 'global_form/class.php',
            data: 'InquiryID=' + InquiryID + '&ReportType=' + ReportType + '&ProposalNum=' + ProposalNum + '&ContractID=' + ContractID + '&form=getLayoutList',
            success: function(data){
                $("#btnProposalxPreview").html(data);
            }
        })
    }
</script>