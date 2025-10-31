<script type="text/javascript">
	$(function(){
        $(".fixTable").tableHeadFixer(); 
       	$("#txt_userpageorlist").val("1");
       	$("#txt_userpage").val("1");
		tbltenantlists();
		$("#txtpaymentccno1").keyup(function(){
		    var len = ($(this).val()).length;
		    if(len == 4){
		      	$("#txtpaymentccno2").focus();
		    }
		})
		$("#txtpaymentccno2").keyup(function(){
		    var len = ($(this).val()).length;
		    if(len == 4){
		      	$("#txtpaymentccno3").focus();
		    }
		})
		$("#txtpaymentccno3").keyup(function(){
		    var len = ($(this).val()).length;
		    if(len == 4){
		      	$("#txtpaymentccno4").focus();
		    }
		})
        $('.datepicker').datepicker({
            format: 'mm/dd/yyyy',
            startDate: '-3d'
        });
        $(".amount").change(function(){
            var x = ($(this).val()).replace(/,/g,"");
            var v = parseFloat(x||0);
            $(this).val(v.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
        });
        $(".date-picker").datepicker({
            autoHide: true,
            format: 'mm/dd/yyyy',
            todayHighlight: true
        });
        $(".numonly").keydown(function(event) {
            if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 190 || event.keyCode == 9 || event.keyCode == 188) {
            }else{
                if (event.keyCode < 48 || event.keyCode > 57 || event.keyCode == 17) {
                   event.preventDefault(); 
                }   
            }
        });
        $("#txtFPBillingParticulars").keydown(function(e){
            var code = (e.keyCode ? e.keyCode : e.which);
            if (code == 50 && e.shiftKey) {
               event.preventDefault(); 
            }
        });
        $("#txtsearchapplication").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
       			$("#txt_userpage").val("1");
				tbltenantlists(); 
			}else if(x == '8'){
                if($('#txtsearchapplication').val() == ""){
       				$("#txt_userpage").val("1");
                    tbltenantlists();
                }
            }
		});
       	$("#txtsearchpen").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
    			$("#txt_userpage10").val("1");
				displaylistofpenalty(); 
			}else if(x == '8'){
                if($('#txtsearchpen').val() == ""){
    				$("#txt_userpage10").val("1");
                    displaylistofpenalty();
                }
            }
		});
		$("#asdasdasd").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
        		$("#txt_userpagepdc").val("1");
				tbllistofpdc(); 
			}else if(x == '8'){
                if($('#asdasdasd').val() == ""){
        			$("#txt_userpagepdc").val("1");
                    tbllistofpdc();
                }
            }
		});
		$("#txtFPChargeListSearch").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				fncmdlAddCharge(); 
			}else if(x == '8'){
                if($('#txtFPChargeListSearch').val() == ""){
                    fncmdlAddCharge();
                }
            }
		});
		$("#txtSearchBevList").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				fncViewBevChargesList(); 
			}else if(x == '8'){
                if($('#txtSearchBevList').val() == ""){
                    fncViewBevChargesList();
                }
            }
		});
        var date = new Date();
		date.setDate(date.getDate() - 0);
		$('.jonas-date-picker').datepicker({
		    autoclose: true,
		    todayHighlight: true,
		    format: 'mm/dd/yyyy',
		    startDate: date
		});
		$('.txtBillUpload').ace_file_input({
			no_file:'No File ...',
			btn_choose:'Choose',
			btn_change:'Change',
			droppable:false,
			onchange:null,
			thumbnail:false
		});
		$("#tblCAPaymentType tr").each(function(){
    		$(this).click(function(){
				eto = $(this).find(".subcheckboxpaymenttype");
				if(eto.is(":checked")){
					eto.prop("checked", false);
					$(this).removeClass("selected");
				}else{
					eto.prop("checked", true);
					$(this).addClass("selected");
				}
			})
		})
		$('#btnSettlement button').click(function() {
		    $(this).addClass('active').siblings().removeClass('active');
    		$("#btnSettlementProceed").prop("disabled", false);
		});
	})

	function tbltenantlists(){
        var txtsearchapplication = $("#txtsearchapplication").val();
        var page = $("#txt_userpage").val();
        $.ajax({
            type: 'POST',
            url: 'billing/billing/class.php',
            data: 'txtsearchapplication=' + txtsearchapplication + '&page=' + page + '&form=tbltenantlists',
            beforeSend : function() {
                $('#indexloadingscreen').addClass('myspinner');
            },
            success: function(data){
                $('#indexloadingscreen').removeClass('myspinner');
                if(data != ""){
                    $("#tbltenantlists").html(data);
                }else{
                    $("#tbltenantlists").html("<tr><td colspan='7' style='text-align: center;'>No Data Found...</td></tr>");
                }
                loadentriesbilling();
                loadpagebilling();
            }
        });
    }

	function loadentriesbilling(){
        var page = $("#txt_userpage").val();
        var txtsearchapplication = $("#txtsearchapplication").val();
        $.ajax({
            type: 'POST',
            url: 'billing/billing/class.php',
            data: 'txtsearchapplication=' + txtsearchapplication + '&page=' + page  + '&form=loadentriesbilling',
            success: function(data){
                $("#txtbillingentries").text(data);
            }
        });
    }

    function loadpagebilling(){
        var page = $("#txt_userpage").val();
        var txtsearchapplication = $("#txtsearchapplication").val();
        $.ajax({
            type: 'POST',
            url: 'billing/billing/class.php',
            data: 'page=' + page + '&txtsearchapplication=' + txtsearchapplication + '&form=loadpagebilling',
            success: function(data){
                $("#ulpaginationbilling").html(data);
            }
        });
    }

    function pagination(page, pagenums){
        $(".pgnum").removeClass("active");
        $("#pg" + pagenums).addClass("active");
        $("#txt_userpage").val(page);
        tbltenantlists();
    }

    function OpenTransactionBilling(TenantID){
        $("#mdlTransactionBilling").modal("show");
    	$.ajax({
    		type: 'POST',
            url: 'billing/billing/class.php',
            data: 'TenantID=' + TenantID + '&form=OpenTransactionBilling',
            success: function(data){
            	var arr = data.split("|");
		        $("#txtbillingtenantid").text(TenantID);
            	$("#imglogo").attr("src", arr[0]);
            	$("#imglogo").attr("alt", arr[1]);
		        $("#txtbillingtradename").text(arr[1]);
		        $("#txtbillingcompanyname").text(arr[2]);
		        $("#txtbillingmallbranch").text(arr[3]);
		        $("#txtbillingstorecode").text(arr[4]);
		        $("#txtbillingtype").text(arr[5]);
                $("#windowtotal").text(arr[6]);                
            }, complete: function(){
            	$("#btnAdjCharge").prop("disabled", true);
				$("#btnAdjPayment").prop("disabled", true);
            	fncTransBillChargeList();
				fncTransBillPaymentList();
            }
    	})
    }

    function fncTransBillChargeList(){
    	var TenantID = $("#txtbillingtenantid").text();
    	$.ajax({
            type: 'POST',
            url: 'billing/billing/class.php',
            data: 'TenantID=' + TenantID + '&form=fncTransBillChargeList',
            success: function(data) {
                $("#TransBillChargeList").html(data);
            }, complete:function(){
            	$("#TransBillChargeList tr").each(function(){
					var eto = $(this);
					eto.find(".dipindot").click(function(){
						$("#TransBillChargeList tr").removeClass("selected");
						eto.addClass("selected");
	       	 			$("#btnAdjCharge").prop("disabled", false);
					})
				})
				$.ajax({
					type: 'POST',
		            url: 'billing/billing/class.php',
		            data: 'TenantID=' + TenantID + '&form=fncTransBillChargeList2',
		            success: function(data){
            			var arr = data.split("|");
		                $("#txtTotChargeAmount").text(arr[0]);
						$("#txtTotChargeTotalVAT").text(arr[1]);
		                $("#txtTotChargeTotalAmount").text(arr[2]);
		                $("#txtTotChargePaidAmount").text(arr[3]);
            			$("#txtTotChargeBalance").text(arr[4]);
		            }
				})
            }
        });
    }
					
    function fncTransBillPaymentList(){
    	var TenantID = $("#txtbillingtenantid").text();
    	$.ajax({
            type: 'POST',
            url: 'billing/billing/class.php',
            data: 'TenantID=' + TenantID + '&form=fncTransBillPaymentList',
            success: function(data) {
                $("#TransBillPaymentList").html(data);
            }, complete:function(){
            	$("#TransBillPaymentList tr").each(function(){
					var eto = $(this);
					eto.find(".dipindot").click(function(){
						$("#TransBillPaymentList tr").removeClass("selected");
						eto.addClass("selected");
        				$("#btnAdjPayment").prop("disabled", false);
					})
				})
				$.ajax({
					type: 'POST',
		            url: 'billing/billing/class.php',
		            data: 'TenantID=' + TenantID + '&form=fncTransBillPaymentList2',
		            success: function(data){
            			var arr = data.split("|");
            			$("#txtTotPaymentAmount").text(arr[0]);
						$("#txtTotPaymentApplied").text(arr[1]);
						$("#txtTotPaymentRemaining").text(arr[2]);
		            }
				})
            }
        });
    }

    function fncShowSettlement(){
    	$("#mdlSettlement").modal("show");
    	$("#btnSettlement button").removeClass("active");
    	$("#btnSettlementProceed").prop("disabled", true);
    }

    function fncConfirmAdvanceBill(){
    	setTimeout(function(){
			showmodal("confirm", "Are you sure you want to proceed?", "fncConfirmedAdvanceBill", null, "", null, "1");
		}, 500)
    }

    function fncConfirmedAdvanceBill(){
    	var TenantID = $("#txtbillingtenantid").text();
    	$("#btnSettlementProceed").button("loading");
    	$.ajax({
    		type: 'POST',
            url: 'billing/billing/class.php',
            data: 'TenantID=' + TenantID + '&form=fncConfirmedAdvanceBill',
            success: function(data){
    			$("#btnSettlementProceed").button("reset");
            	var arr = data.split("|");
            	if(arr[0] == "1"){
            		setTimeout(function(){
						showmodal("alert", arr[1], "fncAdvanceBillSuccess", null, "", null, "0");
					}, 500)
            	}else{
            		setTimeout(function(){
						showmodal("alert", arr[1], "", null, "", null, "1");
					}, 500)
            	}
            }
    	})
    }

    function fncAdvanceBillSuccess(){
    	$("#mdlSettlement").modal("hide");
    	var TenantID = $("#txtbillingtenantid").text();
    	$.ajax({
    		type: 'POST',
            url: 'billing/billing/class.php',
            data: 'TenantID=' + TenantID + '&form=OpenTransactionBilling',
            success: function(data){
            	var arr = data.split("|");
                $("#windowtotal").text(arr[6]);                
            }, complete: function(){
            	$("#btnAdjCharge").prop("disabled", true);
				$("#btnAdjPayment").prop("disabled", true);
            	fncTransBillChargeList();
				fncTransBillPaymentList();
            }
    	})
    }

    function fncmdlTBSoA(){
    	$("#mdlTBSoA").modal("show");
    	$("#txtTBSoACurrentBill").click();
    	$.ajax({
    		type: 'POST',
    		url: 'billing/billing/class.php',
    		data: 'form=getPostedPeriods',
    		success: function(data){
				$("#divtxtTBSoAPeriod .select2-selection").css('height','33px');
    			$("#txtTBSoAPeriod").html(data);
    		}, complete: function(){
    			$("#txtTBSoAPeriod").val([]).trigger("change");
    		}
    	})
    }

    function fncAllowSelectBP(Allow){
    	if(Allow == "Yes"){
    		$("#txtTBSoAPeriod").prop("disabled", false);
    	}else{
    		$("#txtTBSoAPeriod").prop("disabled", true);
    	}
    }

    function fncProceedPrint(){
    	var BillingPeriod = "";
    	$(".rdBillingPeriod").each(function(){
    		if($(this).is(":checked")){
    			BillingPeriod = $(this).val();
    		}
    	})
    	var SelectedPeriod = $("#txtTBSoAPeriod").val();
    	var TenantID = $("#txtbillingtenantid").text();
    	$.ajax({
    		type: 'POST',
    		url: 'billing/billing/class.php',
    		data: 'BillingPeriod=' + BillingPeriod + '&SelectedPeriod=' + SelectedPeriod + '&TenantID=' + TenantID + '&form=fncProceedPrint',
    		success: function(data){
    			var arr = data.split("|");
    			if(arr[0] == "1"){
					fncViewSOA(TenantID, arr[1], "View", "TransactionBilling");
    			}else{
    				setTimeout(function(){
						showmodal("alert", arr[1], "", null, "", null, "1");
					}, 500)
    			}
    		}
    	})
    }

//FAST POSTING FUNCTIONS START
	function fncmdlFastPosting(){
		$("#btnFastPosting").button("reset");
		$("#mdlFastPosting").modal("show");
		$("#txtFPTransDate").val("<?php echo date('m/d/Y', strtotime(getsysdate())); ?>");
		<?php if(SysLeaseSetup('softwaretype') == '5'){ ?>
		$("#txtFPTenant").html("<?php echo "<option value=''>-- Select Buyer --</option>"; ?>");
			;
		<?php }else{ ?>
		$("#txtFPTenant").html("<?php echo "<option value=''>-- Select Tenant --</option>"; ?>");
		<?php } ?>
		$("#txtFPTenant").val([]).trigger("change");
		$("#tbodyFPChargeList").html("");
		$(".txtFPHiddenValue").val("");
		$(".txtFPInitiateClear").val("");
		$("#txtFPTotalCharges").text("0.00");
		$("#txtFPBillingParticulars").val("");
		$("#txtFPBillingType").val("");
		showMallList();
	}

	function showMallList(){
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'form=tblref_mall',
			success:function(data){
				$("#txtFPMall").html(data);
			}, complete: function(){
				showTenantList();
			}
		})
	}

	function showTenantList(){
		var MallID = $("#txtFPMall").val();
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'MallID=' + MallID + '&form=showTenantList',
			success:function(data){
        		$("#divFPTenant .select2-selection").css('height','33px');
				$("#txtFPTenant").html(data);
			}
		})
	}

	function showTenantInfo(){
		var TenantID = $("#txtFPTenant").val();
		$.ajax({
			type: 'POST',
			url: 'billing/billing/class.php',
			data: 'TenantID=' + TenantID + '&form=showTenantInfo',
			success:function(data){
				var arr = data.split("|");
				$("#txtFPStatus").val(arr[0]);
				$("#txtFPBillingType").val(arr[1]);
			}
		})
	}

	function fncCheckTenantFirst(){
		var TenantID = $("#txtFPTenant").val();
		if(TenantID == ""){
			setTimeout(function(){
				showmodal("alert", "Please select the tenant you want to post the charges with.", "", null, "", null, "1");
			}, 500)
		}else{
			$('#mdlAddCharge').modal('show');
			fncmdlAddCharge();
		}
	}

	function fncmdlAddCharge(){
		var key = $("#txtFPChargeListSearch").val();
		var ChargeIDs = "";
		$("#tbodyFPChargeList tr").each(function(){
			ChargeIDs += $(this).attr("id") + "|";
		})
		$.ajax({
			type: 'POST',
			url: 'billing/billing/class.php',
			data: 'ChargeIDs=' + ChargeIDs + '&key=' + key + '&form=fncmdlAddCharge',
			success:function(data){
				if(data.trim() == ""){
                    $("#tblFPChargeList").html("<tr><td colspan='3' style='text-align: center;'>No Data Found...</td></tr>");
				}else{
					$("#tblFPChargeList").html(data);
					$("#tblFPChargeList tr").each(function(){
						$(this).click(function(){
							$("#tblFPChargeList tr").removeClass("selected");
							var tr = $(this).attr("id");
							$("#"+tr).addClass("selected");
						})
					})
				}
					
			},complete:function(){
				$(".txtFPHiddenValue").val("");
			}
		})
	}

	function getTotalAmountofCharge(){
		var subtotal  = 0;
		$("#tbodyFPChargeList tr").each(function(){
			subtotal += parseFloat($(this).find("td").eq(6).text().replace(/,/g,""));
		});
		$("#txtFPTotalCharges").text(subtotal.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
	}

	function getQtyorPrice(ChargeID, RateType, Rate, Description){
		$("#txtFPChargeCount").val("1")
		// if(RateType == "Other"){
		// 	$("#txtFPRate").removeAttr("readonly");
		// }else{
		// 	$("#txtFPRate").attr("readonly", "readonly");
		// }
		$("#mdlInputQuantity").modal("show");
		$("#txtFPChargeID").val(ChargeID);
		$("#txtFPRateType").val(RateType);
		$("#txtFPRate").val(Rate);
		$("#txtFPDescription").val(Description);
		getTotalAmount();
	}

	function getTotalAmount(){
		var Rate = $("#txtFPRate").val().replace(/,/g,"");
		var Qty = $("#txtFPChargeCount").val();
		$("#txtFPTotalAmount").val((parseFloat(Rate) * parseFloat(Qty)).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
	}

	function btnAddCount(btn){
		var calcVal = $("#txtFPChargeCount").val();
		if(btn != "C"){
			if(calcVal == "" || calcVal == "0"){
				$("#txtFPChargeCount").val(btn);
			}else{
				$("#txtFPChargeCount").val(calcVal+btn);
			}
		}else{
			$("#txtFPChargeCount").val(calcVal.slice(0, -1));
		}
	}

	function AddSelectedCharge(){
		$("#tbodyFPChargeList tr").unbind("click");
		var TenantID = $("#txtFPTenant").val();
		var ChargeID = $("#txtFPChargeID").val();
		var RateType = $("#txtFPRateType").val();
		var ChargeCount = $("#txtFPChargeCount").val();
		var ChargeAmount = $("#txtFPChargeAmount").val();
		var ChargeRate = $("#txtFPRate").val().replace(/,/g,"");
		var ChargeDescription = $("#txtFPDescription").val();
		var Particulars = $("#txtFPBillingParticulars").val();
		if(RateType == "Other" && ChargeAmount != "" && ChargeCount != "" && ChargeCount != "0"){
			$("#mdlInputQuantity").modal("hide");
			$("#mdlAddCharge").modal("hide");
			$.ajax({
				type: 'POST',
				url: 'billing/billing/class.php',
				data: 'TenantID=' + TenantID + '&ChargeID=' + ChargeID + '&RateType=' + RateType + '&ChargeCount=' + ChargeCount + '&ChargeAmount=' + ChargeAmount + '&ChargeRate=' + ChargeRate + '&ChargeDescription=' + ChargeDescription + '&Particulars=' + Particulars + '&form=AddSelectedCharge',
				success:function(data){
					$("#tbodyFPChargeList").append(data);
					$("#tbodyFPChargeList tr").each(function(){
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
				}, complete:function(){
					$(".txtFPHiddenValue").val("");
					$("#txtFPBillingParticulars").val("");
					getTotalAmountofCharge();
				}
			})
		}else{
			if(ChargeCount != "" && ChargeCount != "0"){
				var Total = ChargeRate * ChargeCount;
				$("#mdlInputQuantity").modal("hide");
				$("#mdlAddCharge").modal("hide");
				$.ajax({
					type: 'POST',
					url: 'billing/billing/class.php',
					data: 'TenantID=' + TenantID + '&ChargeID=' + ChargeID + '&RateType=' + RateType + '&ChargeCount=' + ChargeCount + '&ChargeAmount=' + ChargeAmount + '&ChargeRate=' + ChargeRate + '&ChargeDescription=' + ChargeDescription + '&Particulars=' + Particulars + '&form=AddSelectedCharge',
					success:function(data){
						$("#tbodyFPChargeList").append(data);
						$("#tbodyFPChargeList tr").each(function(){
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
					}, complete:function(){
						$(".txtFPHiddenValue").val("");
						$("#txtFPBillingParticulars").val("");
						getTotalAmountofCharge();
					}
				})
			}else{
				if(RateType == "Other" && ChargeAmount == ""){
					setTimeout(function(){
						showmodal("alert", "Please enter charge amount.", "", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", "Please enter quantity.", "", null, "", null, "0");
					}, 500)
				}
			}
		}
	}

	function btnFPSelectAll(){
		$("#tbodyFPChargeList tr").removeClass("unselected");
		$("#tbodyFPChargeList tr").addClass("selected");
	}

	function btnFPUnselectAll(){
		$("#tbodyFPChargeList tr").removeClass("selected");
		$("#tbodyFPChargeList tr").addClass("unselected");
	}

	function btnFPRemoveSelected(){
		var Count = 0;
		$("#tbodyFPChargeList tr").each(function(){
			if($(this).hasClass("selected")){
				Count++;
			}
		})
		if(Count >= 1){
			$("#tbodyFPChargeList tr").each(function(){
				if($(this).hasClass("selected")){
					$("#"+$(this).attr("id")).remove();
				}
			})
			getTotalAmountofCharge();
		}else{
			setTimeout(function(){
				showmodal("alert", "Select first Charge(s) to be removed.", "", null, "", null, "1");
			}, 500)
		}
	}

	function PostFPCharges(){
		$("#btnFastPosting").button("loading");
		var xDate = $("#txtFPTransDate").val();
		var TenantID = $("#txtFPTenant").val();
		var Particulars = $("#txtFPBillingParticulars").val();
		var ChargeList = "";
		$("#tbodyFPChargeList tr").each(function(){
			var ChargeCode = $(this).attr("id");
			var ChargeDesc = $(this).find("td").eq(1).text();
			var Particulars = $(this).find("td").eq(2).text()
			var Qty = $(this).find("td").eq(3).text()
			var Amount = $(this).find("td").eq(4).text().replace(/,/g,"");
			var VatAmount = $(this).find("td").eq(5).text().replace(/,/g,"");
			var TotalAmount =  $(this).find("td").eq(6).text().replace(/,/g,"");
			ChargeList += ChargeCode + "|" + ChargeDesc + "|" + Qty + "|" + Amount + "|" + VatAmount + "|" + TotalAmount + "|" + Particulars + "@";
		});
		if(TenantID != ""){
			if(ChargeList != ""){
				$.ajax({
					type: 'POST',
					url: 'billing/billing/class.php',
					data: 'xDate=' + xDate + '&TenantID=' + TenantID + '&ChargeList=' + ChargeList + '&Particulars=' + Particulars + '&form=PostFPCharges',
					success:function(data){
						$("#btnFastPosting").button("reset");
						var arr = data.split("|");
						setTimeout(function(){
							showmodal("alert", arr[1], arr[2], null, "", null, arr[0]);
						}, 500)
					}
				})
			}else{
				$("#btnFastPosting").button("reset");
				setTimeout(function(){
					showmodal("alert", "Please select the charges you want to post.", "", null, "", null, "1");
				}, 500)
			}
		}else{
			$("#btnFastPosting").button("reset");
			setTimeout(function(){
				showmodal("alert", "Please select the tenant you want to post the charges with.", "", null, "", null, "1");
			}, 500)
		}
	}

	function fncmdlClearCharge(){
		$("#tbodyFPChargeList").html("");
		$(".txtFPHiddenValue").val("");
		$(".txtFPInitiateClear").val("");
		$("#txtFPTotalCharges").text("0.00");
		$("#mdlFastPosting").modal("hide");
		tbltenantlists();
	}
//FAST POSTING FUNCTIONS END

//COLLECTION FUNCTIONS START
	function openpaymentmodule(){
		$("#divtxtpaymentexpdateMonth .select2-selection").css('height','33px');
        $("#divtxtpaymentexpdateYear .select2-selection").css('height','33px');
		showbanktype();
		showcardtype();
		showtxtinfostorename();
		fncShowPaymentType();
		$("#modal_PaymetModal").modal("show");
		loadbalancelist('', 'Yes');
		$("#txtinfostorename").val([]).trigger("change");
		$("#txtpaymenttype").val([]).trigger("change");
	}

	function fncShowPaymentType(){
		$.ajax({
			type: 'POST',
            url: 'mainclass.php',
            data: 'form=getPaymentType',
            success: function(data){
                $("#divtxtpaymenttype .select2-selection").css('height','33px');
            	$("#txtpaymenttype").html(data);
            }
		})
	}

	function showbanktype(){
    	$.ajax({
    		type: 'POST',
    		url: 'mainclass.php',
    		data: 'form=tblrefbank',
    		success: function(data){
                $("#divtxtbanknamefrom .select2-selection").css('height','33px');
                $("#divtxtpaymentbankname .select2-selection").css('height','33px');
    			$(".selectbanktype").html(data);
    		}
    	})
    }

    function showcardtype(){
    	$.ajax({
    		type: 'POST',
    		url: 'mainclass.php',
    		data: 'form=tblref_cardtype',
    		success: function(data){
                $("#divtxtcardtype .select2-selection").css('height','33px');
    			$("#txtcardtype").html(data);
    		}
    	})
    }

    function showtxtinfostorename(){
    	$.ajax({
    		type: 'POST',
    		url: 'billing/billing/class.php',
    		data: 'form=showtxtinfostorename',
    		success:function(data){    			
                $("#divtxtinfostorename .select2-selection").css('height','33px');
    			$("#txtinfostorename").html(data);
    		}
    	})
    }

    function loadbalancelist(tenantid, ReportType){
		$.ajax({
			type: 'POST',
			url: 'billing/billing/class.php',
			data: 'tenantid=' + tenantid + '&form=loadbalancelist',
			success: function(data) {
				$("#tblbalancelist").html(data);
				clickable();
				chkvalselected2();
				numonly();
				if(tenantid == ""){
					$("#btn_savingdorp").attr("onclick", "confirmsavedeposit()");
				}else{
					$("#btn_savingdorp").attr("onclick", "confirmsavepayment(\""+ ReportType +"\")");
				}
			}, complete: function(){
				$("#paymentmodal input:text").val("");
				$("#paymentmodal textarea").val("");
				$("#txtenteramount").text("0.00");
				$("#txtenterselected").text("0.00");
				$("#txtenterchange").text("0.00");
				$("#divAttachment").find("a").click();
				$("#txtpaymenttype").val("CASH|CASH").trigger("change");
			}
		});
	}

	function clickable(){
		$("#tblbalancelist tr").each(function(){
			$(this).click(function(){
				eto = $(this).find(".chk_inquiry_unittype");
				var amount_val = $("#txtpaymentamount").val();
				var amount = parseFloat(amount_val.replace(/,/g,"")||0);
				var remaining_val = $("#txtenterchange").text();
				var remaining = parseFloat(remaining_val.replace(/,/g,"")||0);
				var obj = $(this);
				var balance = parseFloat(obj.find(".hiddenamount").val()||0);
				var enteredamount = parseFloat((obj.find(".inputbal").val()).replace(/,/g,"")||0);
				var remainingamt = parseFloat(($("#txtenterchange").text()).replace(/,/g,"")||0);
				var total = 0;
				$("#tblbalancelist tr").each(function(){
					var objct = $(this);
					total += parseFloat((objct.find(".inputbal").val()).replace(/,/g,"")||0);
				});
				var batayan = eto.val();
				if(obj.find("input:checkbox").is(":checked") == false ) {
					eto.prop("checked", true);
					// if(batayan == "1"){
						if(amount == 0){ // if walang payment
							eto.prop("checked", false);
							obj.find("input:checkbox").removeAttr('checked');
							setTimeout(function(){
								showmodal("alert", "Enter payment amount first.", "", null, "", null, "1");
							}, 500)
							obj.find(".inputbal").attr("disabled", "disabled");
							breakdown("0.00");
						}else{ //if may payment
							if(remainingamt > 0){
								if(remainingamt >= balance){ //if mas malaki or equal yung remaining amt ng payment sa balance ng charge
									obj.find(".inputbal").val(balance.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
									obj.find(".inputbal").removeAttr("disabled");
									obj.find(".inputbal").focus();
									obj.find(".tdbalance").text("0.00");
									breakdown(balance);
									$(this).css("color","#FFF");
									$(this).css("background-color","#666");
								}else{
									// manual input
									obj.find(".inputbal").val("");
									obj.find(".inputbal").removeAttr("disabled");
									obj.find(".inputbal").focus();
									$(this).css("color","#FFF");
									$(this).css("background-color","#666");
								}						
							}else{
								obj.find("input:checkbox").removeAttr('checked');
								setTimeout(function(){
									showmodal("alert", "Insufficient amount.", "", null, "", null, "1");
								}, 500)
								obj.find(".inputbal").attr("disabled", "disabled");
							}
						}
					// }else{
					// 	showmodal("alert", "Please settle the oldest charges first.", "", null, "", null, "1");
					// }
				}else {
					eto.prop("checked", false);
					$(this).css("color","");
					$(this).css("background-color","");
					obj.find(".tdbalance").text((balance || 0).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
					obj.find(".inputbal").val("");
					obj.find(".inputbal").attr("disabled", "disabled");
					breakdown("0.00");
				}
				
			})
		})
	}

	function chkvalselected2(){
		$("#tblbalancelist tr .chk_inquiry_unittype").each(function(){
			$(this).change(function(){
				if($(this).is(":checked")){

				}else{
					breakdown("0.00");
				}
			})
		})
	}

	function numonly() {
       	$(".numonly").keydown(function(event) {
           	// Allow only backspace and delete
           	if(event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 190 || event.keyCode == 9 || event.keyCode == 188){
               	// let it happen, don't do anything
           	}else{
               	// Ensure that it is a number and stop the keypress
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

    function changepayment(type, ChangeCSS){
		var arr = type.split("|");
		if(ChangeCSS == 'Default'){
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
				$("#btncheckno").css("display", "none");
				$("#row_ex_date").css("display", "block");
				// enable/disable texts
				$(".checkgroup").attr("disabled", "disabled");
				$(".cardgroup").removeAttr("disabled");
				$("#txtpaymentamount").removeAttr("disabled");
				$("#btncheckno").attr("disabled", "disabled");
				$(".banktrans").attr("disabled", "disabled");
				$(".banktrans").css("display", "none");
				// $("#btnbrowsecashpayment").css("display", "none");			
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
				$("#btncheckno").css("display", "block");
				// enable/disable texts
				$(".checkgroup").attr("disabled", "disabled");
				$(".cardgroup").attr("disabled", "disabled");
				$("#txtpaymentamount").removeAttr("disabled");
				$("#btncheckno").attr("disabled", "disabled");
				$(".banktrans").removeAttr("disabled");
				$(".banktrans").css("display", "block");
				// $("#btnbrowsecashpayment").css("display", "none");
			}else if(arr[1] == "CHECK"){
				$(".ptcredcard").removeClass("thisisrequired");
				$(".ptdebcard").removeClass("thisisrequired");
				$(".ptbanktransfer").removeClass("thisisrequired");
				$(".ptcheck").addClass("thisisrequired");

				$(".checkgroup").css("display", "block");
				$(".cardgroup").css("display", "none");
				$("#btncheckno").css("display", "block");
				$(".checkgroup input[type=text]").val("");
				// enable/disable texts
				$(".checkgroup").removeAttr("disabled");
				$(".cardgroup").attr("disabled", "disabled");
				$("#btncheckno").removeAttr("disabled");
				$(".banktrans").attr("disabled", "disabled");
				$(".banktrans").css("display", "none");
				// $("#btnbrowsecashpayment").css("display", "none");
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
				$("#btncheckno").css("display", "block");
				// enable/disable texts
				$(".checkgroup").attr("disabled", "disabled");
				$(".cardgroup").attr("disabled", "disabled");
				$("#txtpaymentamount").removeAttr("disabled");
				$("#btncheckno").attr("disabled", "disabled");
				$(".banktrans").attr("disabled", "disabled");
				$(".banktrans").css("display", "none");
				// $("#btnbrowsecashpayment").css("display", "block");
			}
			$("#txtpaymentamount").removeAttr("readonly");
		}else{
			$(".ptcredcard").removeClass("thisisrequired");
			$(".ptdebcard").removeClass("thisisrequired");
			$(".ptbanktransfer").removeClass("thisisrequired");
			$(".ptcheck").removeClass("thisisrequired");

			$(".checkgroup").css("display", "none");
			$(".cardgroup").css("display", "none");
			$("#txtpaymentamount").css("display", "block");
			$("#btncheckno").css("display", "block");
			// enable/disable texts
			$(".checkgroup").attr("disabled", "disabled");
			$(".cardgroup").attr("disabled", "disabled");
			$("#txtpaymentamount").removeAttr("disabled");
			$("#btncheckno").attr("disabled", "disabled");
			$(".banktrans").attr("disabled", "disabled");
			$(".banktrans").css("display", "none");
		}
		var TenantID = $("#txtinfostorename").val();
		if(TenantID != ''){
			$("#btn_savingdorp").attr("onclick", "confirmsavepayment(\"Yes\")");
		}
		$(".depositamount").prop('checked',false);
		$(".select2-container").css('width', '100%');
		$("#txtpaymentorno").removeAttr("readonly");
		$("#txtpaymentremarks").removeAttr("readonly");
		$("#txtpaymentorno").val("");
		$("#txtpaymentremarks").val("");
		$("#btn_savingdorp").html("<i class='ace-icon fa fa-thumb-tack'></i>&nbsp;Post Payment");
	}

	function openchecklist(){
		$("#billingchecklistmodal").modal("show");
		$("#txtCheckListUserPage").val("1");
		getchecklist();
	}
	
	function getchecklist(){
        var page = $("#txtCheckListUserPage").val();
		var tenantid = $("#txtinfostorename").val();
		$.ajax({
            type: 'POST',
            url: 'billing/billing/class.php',
            data: 'page=' + page + '&tenantid=' + tenantid + '&form=getchecklist',
            success: function(data){
				$("#tblchecklist").html(data);
				fncCheckListEntries();
				fncCheckListPage();
            }
        });
	}

	function fncCheckListEntries(){
        var page = $("#txtCheckListUserPage").val();
		var tenantid  = $("#txtinfostorename").val();
        $.ajax({
            type: 'POST',
            url: 'billing/billing/class.php',
            data: 'tenantid=' + tenantid + '&page=' + page  + '&form=fncCheckListEntries',
            success: function(data){
                $("#txtCheckListEntries").text(data);
            }
        });
    }

    function fncCheckListPage(){
        var page = $("#txtCheckListUserPage").val();
		var tenantid  = $("#txtinfostorename").val();
        $.ajax({
            type: 'POST',
            url: 'billing/billing/class.php',
            data: 'tenantid=' + tenantid + '&page=' + page + '&form=fncCheckListPage',
            success: function(data){
                $("#txtCheckListPage").html(data);
            }
        });
    }

    function fncCheckListFunc(page, pagenums){
        $(".CheckListNum").removeClass("active");
        $("#CheckList" + pagenums).addClass("active");
        $("#txtCheckListUserPage").val(page);
        getchecklist();
    }

	function selectcheck(pdcdate, bank, checkno, amount){
		$("#txtpaymentamount").val(parseFloat(amount || 0).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
		$("#txtenterchange").text(parseFloat(amount || 0).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
		$("#txtpaymentcheckno").val(checkno);
		$("#txtpaymentcheckdate").val(pdcdate);
		$("#txtpaymentbankname").val(bank);
		$("#billingchecklistmodal").modal("hide");
		$("#txtenteramount").text(parseFloat(amount || 0).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
		numonly();
	}

	function confirmsavedeposit(){
		setTimeout(function(){
			showmodal("confirm", "Are you sure you want to deposit this amount?", "savedeposit", null, "", null, "1");
		}, 500)
	}

	function savedeposit(){
		var bilang = 0;
		$(".thisisrequired").each(function(){
			if($(this).val() == ""){
				alert($(this).attr("id"))
                bilang++;
            }
		})
		var paymenttype = $("#txtpaymenttype").val();
		var transdate = $("#txtinfotransdate").val();
		var arr = paymenttype.split("|");
		if(arr[1] == "CHECK"){
			var ccholder = "";
			var ccno = "";
			var expdate = "";
			var checkno = $("#txtpaymentcheckno").val();
			var checkdate = $("#txtpaymentcheckdate").val();
			var checkname = $("#txtpaymentcheckname").val();
			var bankname = $("#txtpaymentbankname").val();
			var namefrom = "";
			var nameto = "";
			var accfrom = "";
			var accto = "";
			var authno = "";
			var secno = "";
			var cardtype = "";							
		}else if(arr[1] == "CREDIT CARD"){
			var ccholder = $("#txtpaymentccholder").val();
			var ccno = $("#txtpaymentccno1").val() + "-" + $("#txtpaymentccno2").val() + "-" + $("#txtpaymentccno3").val() + "-" + $("#txtpaymentccno4").val();
			var expdate = $("#txtpaymentexpdateMonth").val() + " - " + $("#txtpaymentexpdateYear").val();
			var checkno = "";
			var checkdate = "";
			var checkname = "";
			var bankname = "";
			var namefrom = "";
			var nameto = "";
			var accfrom = "";
			var accto = "";
			var authno = $("#txtccauthno").val();
			var secno = $("#txtseccodeno").val();
			var cardtype = $("#txtcardtype").val();							
		}else if(arr[1] == "BANK DEPOSIT"){
			var ccholder = "";
			var ccno = "";
			var expdate = "";
			var checkno = "";
			var checkdate = "";
			var checkname = "";
			var bankname = "";
			var namefrom = $("#txtbanknamefrom").val();
			var nameto = $("#txtbanknameto").val();
			var accfrom = $("#txtbankaccfrom").val();
			var accto = $("#txtbankaccto").val();
			var authno = "";
			var secno = "";
			var cardtype = "";	
		}else{
			var ccholder = "";
			var ccno = "";
			var expdate = "";
			var checkno = "";
			var checkdate = "";
			var checkname = "";
			var bankname = "";
			var namefrom = "";
			var nameto = "";
			var accfrom = "";
			var accto = "";
			var authno = "";
			var secno = "";
			var cardtype = "";
		}
		var amount = ($("#txtpaymentamount").val()).replace(/,/g,"");
		var tenantid = $("#txtbillingtenantid").text();
		var orno = $("#txtpaymentorno").val();
		var remarks = $("#txtpaymentremarks").val();
		if(arr[1] != "" && amount != "" && bilang == 0){
			$.ajax({
				type: 'POST',
				url: 'billing/billing/class.php',
				data: 'tenantid=' + tenantid + '&PaymentTypeID=' + arr[0] + '&PaymentType=' + arr[1] + '&ccholder=' + ccholder + '&ccno=' + ccno + '&expdate=' + expdate + '&checkno=' + checkno + '&checkdate=' + checkdate + '&checkname=' + checkname + '&bankname=' + bankname + '&amount=' + amount + '&orno=' + orno + '&remarks=' + remarks + '&authno=' + authno + '&secno=' + secno + '&cardtype=' + cardtype + '&namefrom=' + namefrom + '&nameto=' + nameto + '&accfrom=' + accfrom + '&accto=' + accto + '&transdate=' + transdate + '&form=savedeposit',
				beforeSend : function() {
			      	$('#paymentmodalloadingscreen').addClass('myspinner');
			    },
			    success: function(data){
			      	$('#paymentmodalloadingscreen').removeClass('myspinner');
			      	var arr = data.split("|");
			      	if(arr[0] == "1"){
 						setTimeout(function(){
							showmodal("alert", arr[1], "closepaymentmodal2", "Yes|", "", null, "0");
						}, 500)
						getorinfo(orno);
			      	}else if(arr[0] == "3"){
						setTimeout(function(){
							showmodal("alert", arr[1], "", null, "", null, "0");
						}, 500)
			      	}else{
						setTimeout(function(){
							showmodal("alert", arr[1], "", null, "", null, "0");
						}, 500)
			      	}
				}
			})
		}else{
			setTimeout(function(){
				showmodal("alert", "Please fill all fields.", "", null, "", null, "1");
			}, 500)
		}
	}

	function closepaymentmodal(){
		$("#modal_PaymetModal").modal("hide");
		tbltenantlists();
		$("#tblbalancelist").html("");
	}

	function closepaymentmodal2(ReportType){
		$("#modal_PaymetModal").modal("hide");
		$("#tblbalancelist").html("");
		if(ReportType == "Yes"){
			$("#paymentOR").modal("show");
		}
		fncUploadBillAttachment();
	}

	function confirmsavepayment(ReportType){
		var balreamount = ($("#txtenterchange").text()).replace(/,/g,"");
		var tenantid = $("#txtinfostorename").val();
			if(balreamount == "0.00" || balreamount == "0" || balreamount == ""){
				setTimeout(function(){
					showmodal("confirm", "Are you sure you want to post this transaction?", "savepayment", ReportType+"|", "", null, "1");
				}, 500)
			}else if(tenantid != ""){
				setTimeout(function(){
					showmodal("confirm", "Are you sure you want to post this transaction?", "savepayment", ReportType+"|", "", null, "1");
				}, 500)
			}else{
				setTimeout(function(){
					showmodal("confirm", "You still have " + balreamount.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + " remaining amount do you still want to proceed?", "savepayment", ReportType+"|", "", null, "0");
				}, 500)
			}
	}

	function savepayment(ReportType){
		var bilang = 0;
		$(".thisisrequired").each(function(){
			if($(this).val() == ""){
                bilang = bilang +1;
	        	$(this).css("border-color","#f2a696");
            }else{
	          	$(this).css("border-color","#D5D5D5");
            }
		})
		var transdate = $("#txtinfotransdate").val();
		var paymenttype = $("#txtpaymenttype").val();
		var tenantid = $("#txtinfostorename").val();
		var amount = ($("#txtpaymentamount").val()).replace(/,/g,"");
		var orno = $("#txtpaymentorno").val();
		var remarks = $("#txtpaymentremarks").val();
		var selected = "";
		var arr = paymenttype.split("|");
		if(arr[1] == "CHECK"){
			var ccholder = "";
			var ccno = "";
			var expdate = "";
			var checkno = $("#txtpaymentcheckno").val();
			var checkdate = $("#txtpaymentcheckdate").val();
			var checkname = $("#txtpaymentcheckname").val();
			var bankname = $("#txtpaymentbankname").val();
			var namefrom = "";
			var nameto = "";
			var accfrom = "";
			var accto = "";
			var authno = "";
			var secno = "";
			var cardtype = "";							
		}else if(arr[1] == "CREDIT CARD"){
			var ccholder = $("#txtpaymentccholder").val();
			var ccno = $("#txtpaymentccno1").val() + "-" + $("#txtpaymentccno2").val() + "-" + $("#txtpaymentccno3").val() + "-" + $("#txtpaymentccno4").val();
			var expdate = $("#txtpaymentexpdateMonth").val() + " - " + $("#txtpaymentexpdateYear").val();
			var checkno = "";
			var checkdate = "";
			var checkname = "";
			var bankname = "";
			var namefrom = "";
			var nameto = "";
			var accfrom = "";
			var accto = "";
			var authno = $("#txtccauthno").val();
			var secno = $("#txtseccodeno").val();
			var cardtype = $("#txtcardtype").val();							
		}else if(arr[1] == "BANK DEPOSIT"){
			var ccholder = "";
			var ccno = "";
			var expdate = "";
			var checkno = "";
			var checkdate = "";
			var checkname = "";
			var bankname = "";
			var namefrom = $("#txtbanknamefrom").val();
			var nameto = $("#txtbanknameto").val();
			var accfrom = $("#txtbankaccfrom").val();
			var accto = $("#txtbankaccto").val();
			var authno = "";
			var secno = "";
			var cardtype = "";	
		}else{
			var ccholder = "";
			var ccno = "";
			var expdate = "";
			var checkno = "";
			var checkdate = "";
			var checkname = "";
			var bankname = "";
			var namefrom = "";
			var nameto = "";
			var accfrom = "";
			var accto = "";
			var authno = "";
			var secno = "";
			var cardtype = "";
		}
		$("#tblbalancelist tr").each(function(){
			if($(this).find("input:text").val() != "0.00" || $(this).find("input:text").val() != ""){
				if(($(this).find("input:text").val()).replace(/,/g,"") != 0){
					selected += $(this).attr("id") + "#" + $(this).find("input:text").val().replace(/,/g,"") + "#" + $(this).find(".tdbalance").text().replace(/,/g,"") + "|";
				}
			}
		});
		if(bilang == 0){
			$.ajax({
				type: 'POST',
				url: 'billing/billing/class.php',
				data: 'tenantid=' + tenantid + '&PaymentTypeID=' + arr[0] + '&PaymentType=' + arr[1] + '&ccholder=' + ccholder + '&ccno=' + ccno + '&expdate=' + expdate + '&checkno=' + checkno + '&checkdate=' + checkdate + '&checkname=' + checkname + '&bankname=' + bankname + '&amount=' + amount + '&orno=' + orno + '&remarks=' + remarks + '&authno=' + authno + '&secno=' + secno + '&cardtype=' + cardtype + '&namefrom=' + namefrom + '&nameto=' + nameto + '&accfrom=' + accfrom + '&accto=' + accto + '&transdate=' + transdate + '&selected=' + selected + '&ReportType=' + ReportType + '&form=savepayment',
				beforeSend : function() {
			      	$('#paymentmodalloadingscreen').addClass('myspinner');
			    },
			    success: function(data){
			      	$('#paymentmodalloadingscreen').removeClass('myspinner');
			      	var arr = data.split("|");
				    if(arr[0] == "1"){
 						setTimeout(function(){
							showmodal("alert", arr[1], "closepaymentmodal2", ReportType+"|", "", null, "0");
						}, 500)
						getorinfo(orno);
				    }else{
						setTimeout(function(){
							showmodal("alert", arr[1], "", null, "", null, "1");
						}, 500)
				    }
				}
			});
		}else{
			setTimeout(function(){
				showmodal("alert", "Please fill all fields.", "", null, "", null, "1");
			}, 500)
		}
	}

	function fncUploadBillAttachment(){
		var data = new FormData($('#frmBillAttachment')[0]);
      	$.ajax({
	        type: 'POST',
	        url: 'billing/billing/uploadBillAttachment.php',
	        data: data,
	        mimeType: 'multipart/form-data',
	        contentType: false,
	        cache: false,
	        processData: false,
	        success:function(data){

	        }
      	})
	}
	
	function computebalance(entered){
		var remainingamt = parseFloat(($("#txtenterchange").text()).replace(/,/g,"")||0);
		var laman = parseFloat(($("."+entered).val()).replace(/,/g,"")||0);
		var inputval = parseFloat(($("#"+entered).val()).replace(/,/g,"")||0);
		var enteredval = $("#"+entered).val();
		if(remainingamt >= enteredval){
			if(inputval > laman){
				setTimeout(function(){
	            	showmodal("alert", "You exceeded amount of balance.", "", null, "", null, "0");
   				}, 500)
				$("#"+entered).val("");
				$("#"+entered).focus();
				breakdown(enteredval);
			}else{
				breakdown(enteredval);
			}			
		}else{
			setTimeout(function(){
            	showmodal("alert", "Your remaining amount is not enough.", "", null, "", null, "1");
			}, 500)
			$("#"+entered).val("");
			$("#"+entered).focus();
		}

		$("#tblbalancelist tr").each(function(){
			var obj = $(this);
			var balance = parseFloat(obj.find(".hiddenamount").val() || 0);
			var input = parseFloat(obj.find(".inputbal").val() || 0);
			if(isNaN(obj.find(".inputbal").val() || 0)){
				input = "";	
			}
		
			if(input > balance){	
				obj.find(".inputbal").val("");	
			}else{
				var totalbal = balance - parseFloat((obj.find(".inputbal").val()).replace(/,/g,"") || 0);
				obj.find(".tdbalance").text((totalbal || 0).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
			}
		});
		
	}

	function breakdown(entered){
		var amount_val = $("#txtpaymentamount").val();
		var amount = parseFloat(amount_val.replace(/,/g,"")||0);
		var total = 0;
		$("#tblbalancelist tr").each(function(){
			var objct = $(this);
			total += parseFloat((objct.find(".inputbal").val()).replace(/,/g,"")||0);
		});

		var remaining = amount - total;
		$("#txtenterchange").text(remaining.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")); //change
		$("#txtenterselected").text(total.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")); //applied		
	}
	
	function enteramount(enteredAmount){
		$("#txtenteramount").text(parseFloat(enteredAmount).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
		$("#txtenterchange").text(parseFloat(enteredAmount).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
	}

	function loadtblorlist(action){
        var page = $("#txt_userpageorlist").val();
		var tenantid  = $("#txtinfostorename").val();
		var paymenttype = $("#txtpaymenttype").val();
		var arr = paymenttype.split("|");
		$("#modal_orlist").modal("show");
    	$.ajax({
    		type: 'POST',
    		url: 'billing/billing/class.php',
    		data: 'action=' + action + '&tenantid=' + tenantid + '&page=' + page + '&PaymentType=' + arr[0] + '&form=loadtblorlist',
    		success:function(data){
    			$("#tblorlist").html(data);
    		}, complete: function(){
    			// loadpageorlist();
				// loadentriesorlist();
    		}
    	})
    }

	function loadentriesorlist(){
        var page = $("#txt_userpageorlist").val();
		var tenantid  = $("#txtinfostorename").val();
        $.ajax({
            type: 'POST',
            url: 'billing/billing/class.php',
            data: 'tenantid=' + tenantid + '&page=' + page  + '&form=loadentriesorlist',
            success: function(data){
                $("#txtorlistentries").text(data);
            }
        });
    }

    function loadpageorlist(){
        var page = $("#txt_userpageorlist").val();
		var tenantid  = $("#txtinfostorename").val();
        $.ajax({
            type: 'POST',
            url: 'billing/billing/class.php',
            data: 'tenantid=' + tenantid + '&page=' + page + '&form=loadpageorlist',
            success: function(data){
                $("#ulpaginationorlist").html(data);
            }
        });
    }

    function paginationorlist(page, pagenums){
        $(".ORListPageNum").removeClass("active");
        $("#ORListPage" + pagenums).addClass("active");
        $("#txt_userpageorlist").val(page);
        loadtblorlist();
    }

    function selectcashorno(orno, amount, paymenttype){
    	// $("#txtpaymenttype").val(paymenttype).trigger('change');
    	// changepayment(paymenttype, 'Custom');
		$("#txtpaymentamount").val(parseFloat(amount).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
    	enteramount(amount);
    	$("#txtpaymentorno").val(orno);
		$("#modal_orlist").modal("hide");
		$("#txtpaymentamount").attr("readonly", "readonly");
		$("#txtpaymentorno").attr("readonly", "readonly");
		$("#txtpaymentremarks").attr("readonly", "readonly");
		$("#btn_savingdorp").attr("onclick", "confirmsavepayment(\"No\")");
		$("#btn_savingdorp").html("<i class='ace-icon fa fa-thumb-tack'></i>&nbsp;Apply Payment");
    }

    function closevieworlistwindow(){
    	$("#txtinfostorename").val("");
		$("#modal_orlist").modal("hide");
    }

    function getorinfo(orno){
        $.ajax({
            type: 'POST',
            url: 'billing/billing/class.php',
            data: 'orno=' + orno + '&form=gettblorinfo',
        success:function(data){
        		var arr = data.split("|");
                $("#tblpaymentorinfo").html(arr[0]);
				$("#paymentinfoTransDate").text(arr[1]);
				$("#paymentinfoPaymentType").text(arr[2]);
				$("#paymentinfoReceivedBy").text(arr[3]);
                $("#paymentinfoTenant").text(arr[4]);
				$("#paymentinfoPrintDate").text(arr[5]);
				$("#paymentinfoReceiptNo").text(orno);
				$.ajax({
		            type: 'POST',
		            url: 'mainclass.php',
		            data: 'tenantid=' + arr[6] + '&form=getheaderprint',
		        success:function(data2){
		                $("#template4").html(data2);
		            }
		        })
            }
        })
    }

    function printpaymentORContent(){
    	var toprint = $("#paymentORContent").html();
        var myheight = $(window).height();
        var mywidth = $(window).width();
        var popupWin = window.open("", "_blank", "height=" + myheight + ",width=" + mywidth + ",location=no,scrollbars=1,left=" + 20);
        popupWin.document.open();
        popupWin.document.write("<html><head><title></title></head><body onload='window.print();'>" + toprint + "</body></html>");
        popupWin.document.close();
    }

    function fncOpenmdlAdjustment(TableID){
    	$("#mdlAdjustment").modal("show");
    	if(TableID == "TransBillChargeList"){
    		$("#TransBillChargeList tr").each(function(){
	    		if($(this).hasClass("selected")){
	    			$("#txtAdjRecordID").val($(this).attr("id"));
					$("#txtAdjChargeDesc").val($(this).find("td").eq(1).text());
					$("#txtAdjChargeMaxAmount").val($(this).find("td").eq(8).text().replace(/,/g,""));
					$("#txtAdjChargeAmount").val($(this).find("td").eq(8).text());
	    		}
	        })
	        $("#txtisRefund").addClass("hide");
    	}else{
    		$("#TransBillPaymentList tr").each(function(){
	    		if($(this).hasClass("selected")){
	    			$("#txtAdjRecordID").val($(this).attr("id"));
					$("#txtAdjChargeDesc").val($(this).find("td").eq(1).text());
					$("#txtAdjChargeMaxAmount").val($(this).find("td").eq(6).text().replace(/,/g,"").replace(/-/g,""));
					$("#txtAdjChargeAmount").val($(this).find("td").eq(6).text().replace(/-/g,""));
	    		}
	        })
	        $("#txtisRefund").removeClass("hide");
    	}
        $("#txtAdjActiveTable").val(TableID);
        $("#txtAdjReference").val("");
    }

    function fncAdjCheckMaxAmount(){
    	var MaxAmount = $("#txtAdjChargeMaxAmount").val().replace(/,/g,"");
		var TenderedAmount = $("#txtAdjChargeAmount").val().replace(/,/g,"");
    	if(parseFloat(TenderedAmount) == 0){
    		setTimeout(function(){
				showmodal("alert", "Please enter a valid amount.", "fncRevertAdjAmount", null, "", null, "1");
			}, 500)
    	}else if(parseFloat(MaxAmount) >= parseFloat(TenderedAmount)){

    	}else{
    		setTimeout(function(){
				showmodal("alert", "Tendered amount must not be greater than "+ $("#txtAdjChargeMaxAmount").val().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") +".", "fncRevertAdjAmount", null, "", null, "1");
			}, 500)
    	}
    }

    function fncRevertAdjAmount(){
    	$("#txtAdjChargeAmount").val($("#txtAdjChargeMaxAmount").val().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
    }

    function fncPostAdjustment(){
		$("#btnPostAdjustment").button("loading");
    	var isRefund = "";
		if($("#isRefund").is(":checked")){
			isRefund = 1;
		}else{
			isRefund = 0;
		}
		var RecordID = $("#txtAdjRecordID").val();
		var ChargeDesc = $("#txtAdjChargeDesc").val();
		var Amount = $("#txtAdjChargeAmount").val().replace(/,/g,"");
		var Reference = $("#txtAdjReference").val();
		var TableID = $("#txtAdjActiveTable").val();
		var Count = 0;
		$(".txtAdjReq").each(function(){
			if($(this).val() == "" || $(this).val() == "0"){
				Count++;
				$(this).css("border-color", "#f2a696");
            }else{
               $(this).css("border-color", "#b5b5b5");
            }
		})
		if(Count == 0){
			$.ajax({
				type: 'POST',
				url: 'billing/billing/class.php',
				data: 'isRefund=' + isRefund + '&RecordID=' + RecordID + '&ChargeDesc=' + ChargeDesc + '&Amount=' + Amount + '&Reference=' + Reference + '&TableID=' + TableID + '&form=fncPostAdjustment',
				beforeSend: function(){
                	$('#PremdlAdjustment').addClass('myspinner');
				},
				success: function(data){
                	$('#PremdlAdjustment').removeClass('myspinner');
					$("#btnPostAdjustment").button("reset");
					if(data == "1"){
						setTimeout(function(){
							showmodal("alert", "Adjustment successfully saved.", "fncAdjSuccess", null, "", null, "0");
						}, 500)
					}else{
						setTimeout(function(){
							showmodal("alert", "Failed to save adjustment.", "", null, "", null, "0");
						}, 500)
					}
				}
			})
		}else{
			$("#btnPostAdjustment").button("reset");
			setTimeout(function(){
				showmodal("alert", "Please fill all fields.", "", null, "", null, "1");
			}, 500)
		}
    }

    function fncAdjSuccess(){
    	fncTransBillChargeList();
		fncTransBillPaymentList();
		$("#mdlAdjustment").modal("hide");
    }
//COLLECTION FUNCTIONS END


//CASHIER's AUDIT START
	function opencashieraudit(){
		$("#modal_opencashieraudit").modal("show");
		displayCAoptions();
	}

	function displayCAoptions(){
		$.ajax({
			type: 'POST',
			url: 'billing/billing/class.php',
			data: 'form=userlist',
			success:function(data){
				$("#CAuserlist").html(data);
			}
		})
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'form=tblref_mall',
			success:function(data){
				$("#CAmall").html(data);
			}
		})
	}

	function openmultiuserlist(){
		$("#modal_CAmultiuser").modal("show");
		thiswilluncheckalluser();
		$.ajax({
			type: 'POST',
			url: 'billing/billing/class.php',
			data: 'form=tbluserlist',
			success:function(data){
				$("#tblCAuserlist").html(data);
				$("#tblCAuserlist tr").each(function(){
	        		$(this).click(function(){
						eto = $(this).find(".subcheckboxuserlist");
						if(eto.is(":checked")){
							eto.prop("checked", false);
							$(this).removeClass("selected");
						}else{
							eto.prop("checked", true);
							$(this).addClass("selected");
						}
					})
				})
			}
		})
	}

	function openmultipaymenttype(){
		$("#modal_CAmultipaymenttype").modal("show");
		$(".thiswillcheckallpaymenttype").prop("checked", false);
	}

	function thiswillcheckalluser(){
		$(".subcheckboxuserlist").prop("checked", true);
		$("#tblCAuserlist tr").addClass("selected");
	}

	function thiswilluncheckalluser(){
		$(".subcheckboxuserlist").prop("checked", false);
		$("#tblCAuserlist tr").removeClass("selected");
	}

	function thiswillcheckallpaymenttype(){
		$(".subcheckboxpaymenttype").prop("checked", true);
		$("#tblCAPaymentType tr").addClass("selected");
	}

	function thiswilluncheckallpaymenttype(){
		$(".subcheckboxpaymenttype").prop("checked", false);
		$("#tblCAPaymentType tr").removeClass("selected");
	}

	function savecheckeduser(){
		var ids = "";
		$(".subcheckboxuserlist").each(function(){
			if($(this).is(":checked")){
				ids += this.value + "|";
			}
		})
		$("#userlistcontainer").val(ids);
		$("#modal_CAmultiuser").modal("hide");
		$("#CAuserlist").val("");
	}

	function savecheckedpaymenttype(){
		var ids = "";
		$(".subcheckboxpaymenttype").each(function(){
			if($(this).is(":checked")){
				ids += this.value + "|";
			}
		})
		$("#paymenttypecontainer").val(ids);
		$("#modal_CAmultipaymenttype").modal("hide");
		$("#CApaymenttypelist").val("");
	}

	function clearmultiuser(){
		$("#userlistcontainer").val("");
	}

	function clearmultipaymenttype(){
		$("#paymenttypecontainer").val("");
	}

	function previewCa(){
		var dateFrom = $("#CADateFrom").val();
		var dateTo = $("#CADateTo").val();
		var timeFrom = $("#CATimeFrom").val();
		var timeTo = $("#CATimeTo").val();
		var user = $("#CAuserlist").val();
		var paymenttype = $("#CApaymenttypelist").val();
		var userlist = $("#userlistcontainer").val();
		var paymenttypelist = $("#paymenttypecontainer").val();
		var mallid = $("#CAmall").val();
		if(mallid != ""){
			$.ajax({
				type: 'POST',
				url: 'billing/billing/class.php',
				data: 'dateFrom=' + dateFrom + '&dateTo=' + dateTo + '&timeFrom=' + timeFrom + '&timeTo=' + timeTo + '&user=' + user + '&paymenttype=' + paymenttype + '&userlist=' + userlist + '&paymenttypelist=' + paymenttypelist + '&mallid=' + mallid + '&form=previewCa',
				success:function(data){
					$("#modal_CApreviewres").modal("show");
					$("#tblCAprev").html(data);
				}
			})
		}else{
			setTimeout(function(){
				showmodal("alert", "Please select mall.", "", null, "", null, "1");
			}, 500)
		}
	}

	function headertemplate(){
		var mallID = $("#CAmall").val();
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'mallID=' + mallID + '&form=getheaderprint',
			success:function(data){
				$("#template3").html(data);
			}
		})
	}

	function ChoosePrintCA(){
		headertemplate();
		var dateFrom = $("#CADateFrom").val();
		var dateTo = $("#CADateTo").val();
		var timeFrom = $("#CATimeFrom").val();
		var timeTo = $("#CATimeTo").val();
		var user = $("#CAuserlist").val();
		var paymenttype = $("#CApaymenttypelist").val();
		var userlist = $("#userlistcontainer").val();
		var paymenttypelist = $("#paymenttypecontainer").val();
		var mallid = $("#CAmall").val();
		$.ajax({
			type: 'POST',
			url: 'billing/billing/class.php',
			data: 'dateFrom=' + dateFrom + '&dateTo=' + dateTo + '&timeFrom=' + timeFrom + '&timeTo=' + timeTo + '&user=' + user + '&paymenttype=' + paymenttype + '&userlist=' + userlist + '&paymenttypelist=' + paymenttypelist + '&mallid=' + mallid + '&form=previewCa',
			success:function(data){
				$("#tblCAprevprint").html(data);
				setTimeout(function(){
					ChoosePrintCA2();
				}, 500)
			}
		})
	}

	function ChoosePrintCA2(){
		var toprint = $("#div_forprint").html();
        var myheight = $(window).height();
        var mywidth = $(window).width();
        var popupWin = window.open("", "_blank", "height=" + myheight + ",width=" + mywidth + ",location=no,scrollbars=1,left=" + 20);
        popupWin.document.open();
        popupWin.document.write("<html><head><title></title></head><body onload='window.print();'>" + toprint + "</body></html>");
        popupWin.document.close();
	}

	function ChooseCSVCA(){
		var dateFrom = $("#CADateFrom").val();
		var dateTo = $("#CADateTo").val();
		var timeFrom = $("#CATimeFrom").val();
		var timeTo = $("#CATimeTo").val();
		var user = $("#CAuserlist").val();
		var paymenttype = $("#CApaymenttypelist").val();
		var userlist = $("#userlistcontainer").val();
		var paymenttypelist = $("#paymenttypecontainer").val();
		var mallid = $("#CAmall").val();
		$.ajax({
			type: 'POST',
			url: 'billing/billing/class.php',
			data: 'dateFrom=' + dateFrom + '&dateTo=' + dateTo + '&timeFrom=' + timeFrom + '&timeTo=' + timeTo + '&user=' + user + '&paymenttype=' + paymenttype + '&userlist=' + userlist + '&paymenttypelist=' + paymenttypelist + '&mallid=' + mallid + '&form=previewCSV',
			success:function(data){
				var arr = data.split("|");
				$("#tblCAprevCSV").html(arr[0]);
				setTimeout(function(){
					exportTableToCSV(arr[1]);
				}, 500)
			}
		})
	}

	function exportTableToCSV(filename){
		var csv = [];
	    var rows = document.querySelectorAll("#CAresCSV tr");
	    for (var i = 0; i < rows.length; i++) {
	        var row = [], cols = rows[i].querySelectorAll("#CAresCSV th, #CAresCSV td");
	        for (var j = 0; j < cols.length; j++) 
	            row.push(cols[j].innerText);
	        csv.push(row.join(","));        
	    }
	    // Download CSV file
	    downloadCSV(csv.join("\n"), filename);
	}

	function downloadCSV(csv, filename) {
	    var csvFile;
	    var downloadLink;
	    // CSV file
	    csvFile = new Blob([csv], {type: "text/csv"});
	    // Download link
	    downloadLink = document.createElement("a");
	    // File name
	    downloadLink.download = filename;
	    // Create a link to the file
	    downloadLink.href = window.URL.createObjectURL(csvFile);
	    // Hide download link
	    downloadLink.style.display = "none";
	    // Add the link to DOM
	    document.body.appendChild(downloadLink);
	    // Click download link
	    downloadLink.click();
	}

	function ChoosePDFCA(){
		var dateFrom = $("#CADateFrom").val();
		var dateTo = $("#CADateTo").val();
		var timeFrom = $("#CATimeFrom").val();
		var timeTo = $("#CATimeTo").val();
		var user = $("#CAuserlist").val();
		var paymenttype = $("#CApaymenttypelist").val();
		var userlist = $("#userlistcontainer").val();
		var paymenttypelist = $("#paymenttypecontainer").val();
		var mallid = $("#CAmall").val();
		window.open('billing/billing/printpdf.php?dateFrom=' + dateFrom + '&dateTo=' + dateTo + '&timeFrom=' + timeFrom + '&timeTo=' + timeTo + '&user=' + user + '&paymenttype=' + paymenttype + '&userlist=' + userlist + '&paymenttypelist=' + paymenttypelist + '&mallid=' + mallid);
	}
//CASHIER's AUDIT END

//STATEMENT OF ACCOUNTS START
	function fncShowModalForSOA(){
		$("#mdlSOA").modal("show");
		$(".disabledwhenclicked").prop("disabled", true);
        $(".txtgensoa").css("border-color","#D5D5D5");
        $(".datepickerdaily").css("border-color","#D5D5D5");
		$("#txtBillingPeriod").val([]).trigger("change");
		fncShowTenantList(); 
		loadtxtBillingPeriod();
		fncLoadPrevPeriods();
	}

	 function fncHideModalForSOA(){
    	$("#mdlSOA").modal("hide");
        $("#txtBillingPeriod").val([]).trigger("change");
    	$("#mdlSOA :input").val("");
    	$("#tbltenantperiodlist").html("");
    	$("#txtsoadateofbilling").text("");
    	$("#txtsoasoanoofbilling").text("");
    	$(".txtgensoa").val("");
    }

    function postselectedperiod(){
    	setTimeout(function(){
			showmodal("alert", "Please select a billing period first.", "", null, "", null, "1");
		}, 500)
    }

	function fncShowTenantList(){
    	$.ajax({
    		type: 'POST',
    		url: 'billing/billing/class.php',
    		data: 'form=showTenantList',
    		success: function(data){
    			$("#txtTenantID").html(data);
    		}
    	})
    	$.ajax({
    		type: 'POST',
    		url: 'billing/billing/class.php',
    		data: 'form=showUnitList',
    		success: function(data){
    			$("#txtUnitID").html(data);
    		}
    	})
    }

    function FillBillDates(){
		var BillingPeriod = $("#txtBillingPeriod").val();
		$.ajax({
			type: 'POST',
			url: 'billing/billing/class.php',
			data: 'BillingPeriod=' + BillingPeriod + '&form=FillBillDates',
			success:function(data){
				var arr = data.split("|");
				$("#txtPeriodFrom").val(arr[0]);
				$("#txtPeriodTo").val(arr[1]);
				$("#txtDueDate").val(arr[2]);
				if(arr[3] == "1"){
					$("#btnprocessingofsoa").prop("disabled", false);
				}else{
					$("#btnprocessingofsoa").prop("disabled", true);
				}
			}
		})
	}

	function loadBillingPeriod(){
		$.ajax({
			type: 'POST',
			url: 'billing/billing/class.php',
			data: 'form=loadBillingPeriod',
            success: function(data){
				$("#tblBillPeriodList").html(data);
				$(".cleartxtBP").val("");
				$("#txtBillSoAID").val("");
               	$(".cleartxtBP").css("border-color", "#b5b5b5");
			}, complete: function(){
				$("#tblBillPeriodList tr").each(function(){
					$(this).click(function(){
						$("#tblBillPeriodList tr").removeClass("selected");
						var tr = $(this).attr("id");
						$("#"+tr).addClass("selected");
						$('.btn-UpdateBP').css('display', 'block'); 
						$('.btn-SaveBP').css('display', 'none');
					})
				})
			}
		})
	}

	function fncBPisClicked(SoAID){
		$.ajax({
			type: 'POST',
			url: 'billing/billing/class.php',
			data: 'SoAID=' + SoAID + '&form=fncBPisClicked',
			success: function(data){
				var arr = data.split("|");
				$("#txtBillSoAID").val(SoAID);
				$("#txtBillMonth").val(arr[0]);
				$("#txtBillYear").val(arr[1]);
				$("#txtBillDueDate").val(arr[2]);
				$("#txtBillMonth").attr("disabled", "disabled");
				$("#txtBillYear").attr("disabled", "disabled");
			}
		})
	}

	function CancelUpdateBP(){
		$('.btn-UpdateBP').css('display', 'none'); 
		$('.btn-SaveBP').css('display', 'block');
		$(".cleartxtBP").val("");
		$("#txtBillSoAID").val("");
		$("#tblBillPeriodList tr").removeClass("selected");
		$("#txtBillMonth").removeAttr("disabled", "disabled");
		$("#txtBillYear").removeAttr("disabled", "disabled");
	}

	function loadtxtBillingPeriod(){
		$.ajax({
			type: 'POST',
			url: 'billing/billing/class.php',
			data: 'form=loadtxtBillingPeriod',
			success:function(data){
    			$("#divtxtBillingPeriod .select2-selection").css('height','33px');
				$("#txtBillingPeriod").html(data);
			}
		})
	}

	function SaveNewBillPeriod(){
		var SoAID = $("#txtBillSoAID").val();
		var Month = $("#txtBillMonth").val();
		var Year = $("#txtBillYear").val();
		var DueDate = $("#txtBillDueDate").val();
		var count = 0;
		$(".cleartxtBP").each(function(){
			if($(this).val() == ""){
				count++;
				$(this).css("border-color", "#f2a696");
            }else{
               $(this).css("border-color", "#b5b5b5");
            }
		})
		if(count == 0){
			$.ajax({
				type: 'POST',
				url: 'billing/billing/class.php',
				data: 'SoAID=' + SoAID + '&Month=' + Month + '&Year=' + Year + '&DueDate=' + DueDate + '&form=SaveNewBillPeriod',
				success:function(data){
					var arr = data.split("|");
					if(arr[0] == '1'){
						loadtxtBillingPeriod();
						setTimeout(function(){
							showmodal("alert", arr[1], "loadBillingPeriod", null, "", null, "0");
						}, 500)
					}else if(arr[0] == '2'){
						loadtxtBillingPeriod();
						CancelUpdateBP();
						setTimeout(function(){
							showmodal("alert", arr[1], "loadBillingPeriod", null, "", null, "0");
						}, 500)
					}else{
						setTimeout(function(){
							showmodal("alert", arr[1], "", null, "", null, "1");
						}, 500)
					}
				}, complete: function(){
					fncLoadPrevPeriods();
				}
			})
		}else{
			setTimeout(function(){
				showmodal("alert", "Please fill all fields.", "", null, "", null, "1");
			}, 500)
		}
	}

	function fncLoadPrevPeriods(){
		$.ajax({
			type: 'POST',
			url: 'billing/billing/class.php',
			data: 'form=fncLoadPrevPeriods',
			success: function(data){
				$("#tblPrevPeriods").html(data);
				$("#tblPrevPeriods tr").each(function(){
					$(this).click(function(){
						$("#tblPrevPeriods tr").removeClass("selected");
						var tr = $(this).attr("id");
						$("#"+tr).addClass("selected");
					})
				})
				$("#tblBillingSOAList").html("");
			}
		})
	}

	function loadTenantSOA(){
		var TenantID = $("#txtTenantID").val();
		$("#tblPrevPeriods tr").each(function(){
			if($(this).hasClass("selected")){
				$(this).click();
			}
		})
		$.ajax({
			type: 'POST',
			url: 'billing/billing/class.php',
			data: 'TenantID=' + TenantID + '&form=getTenantUnitID',
			success: function(data){
				$("#txtUnitID").val(data);
			}
		})
	}

	function fncLoadTenant(){
		var UnitID = $("#txtUnitID").val();
		$.ajax({
			type: 'POST',
			url: 'billing/billing/class.php',
			data: 'UnitID=' + UnitID + '&form=fncLoadTenant',
			success: function(data){
				$("#txtTenantID").val(data);
			}
		})
	}

	function fncShowSOAList(soaid, BillingPeriod, Status){
		if(Status == "1"){
			$("#btnPostSelected").prop("disabled", true);
		}else{
			$("#btnPostSelected").prop("disabled", false);
		}
		$("#txtBillingSOAID").text(soaid);
		$("#txtBillingSOAPeriod").text(BillingPeriod);
		var TenantID = $("#txtTenantID").val();
		$.ajax({
			type: 'POST',
			url: 'billing/billing/class.php',
			data: 'soaid=' + soaid + '&TenantID=' + TenantID + '&form=fncShowSOAList',
			success: function(data){
				if(data != ""){
                    $("#tblBillingSOAList").html(data);
                    $("#tblBillingSOAList tr").each(function(){
						var eto = $(this);
						var chkButton = eto.find(".chkprintsoatenant");
						eto.find(".tdSoA_Click").click(function(){
							if(chkButton.is(":checked")){
								chkButton.prop("checked", false);
								eto.removeClass("selected");
							}else{
								chkButton.prop("checked", true);
								eto.addClass("selected");
							}
						})
					})
                }else{
                    $("#tblBillingSOAList").html("<tr><td colspan='5' style='text-align: center;'>No Data Found...</td></tr>");
                }
			}
		})
	}

	function fncCheckAllSoA(){
		$(".chkprintsoatenant").prop("checked", true);
		$("#tblBillingSOAList tr").addClass("selected");
	}

	function fncUncheckAllSoA(){
		$(".chkprintsoatenant").prop("checked", false);
		$("#tblBillingSOAList tr").removeClass("selected");
	}

	function fncViewSOA(TenantID, SoAID, btnAction, ViewType){
		$.ajax({
			type: 'POST',
			url: 'billing/billing/class.php',
			data: 'TenantID=' + TenantID + '&SoAID=' + SoAID + '&ViewType=' + ViewType + '&form=fncPrintSingleSoa',
			success: function(data){
				$("#tblPrintSOAMulti").html(data);
    		}, complete: function(){
    			if(btnAction == "Print"){
            		btnPrintSOA();
            	}else{
					$("#mdlPreviewSOA").modal("show");
            	}
    		}
		})
	}

    function btnPrintSOA(){
		var toprint = $("#tblPrintSOAMulti").html();
		var myheight = $(window).height();
        var mywidth = $(window).width();
        var popupWin = window.open("", "_blank", "height=" + myheight + ",width=" + mywidth + ",location=no,scrollbars=1,left=" + 20);
		popupWin.document.open();
		popupWin.document.write("<html><head><title></title><style>*{font-family: 'Arial', Tahoma, sans-serif;}@media screen {div.divFooter {display: none;}}@media print { div.divFooter {position: fixed;bottom: 0;}}</style></head><body><div class='checklist'>" + toprint + "</div></body></html>");
		popupWin.print();
		popupWin.close();
	}

	function fncPreProcessSOA(){
		$("#btnprocessingofsoa").button("loading");
		var SoAID = $("#txtBillingPeriod").val();
		var DateFrom = $("#txtPeriodFrom").val();
		var DateTo = $("#txtPeriodTo").val();
		var DueDate = $("#txtDueDate").val();
		var count = 0;
		$(".txtgensoa").each(function(){
			if($(this).val() == ""){
				count++;
			}
		})
		if(count == 0){
			$.ajax({
				type: 'POST',
				url: 'billing/billing/class.php',
				data: 'SoAID=' + SoAID + '&DateFrom=' + DateFrom + '&DateTo=' + DateTo + '&DueDate=' + DueDate + '&form=fncPreProcessSOA',
				beforeSend: function(){
                	$('#soaloadingscreentenant').addClass('myspinner');
				},
				success: function(data){
                	$('#soaloadingscreentenant').removeClass('myspinner');
					$("#btnprocessingofsoa").button("reset");
					var arr = data.split("|");
					if(arr[0] == "1"){
						fncProcessSOA();
					}else if(arr[0] == "2"){
						$("#mdl_confProcessSOA").modal("show");
						$("#txtpreProcessWO").text(arr[1]);
						$("#txtpreProcessV").text(arr[2]);
					}else if(arr[0] == "3"){
						setTimeout(function(){
							showmodal("confirm", arr[1], "fncProcessSOA2", null, "", null, "0");
						}, 500)
					}else if(arr[0] == "4"){
						setTimeout(function(){
							showmodal("alert", arr[1], "", null, "", null, "1");
						}, 500)
					}else{
						setTimeout(function(){
							showmodal("alert", "Failed to process Statement of Accounts", "", null, "", null, "1");
						}, 500)
					}
				}
			})
		}else{
			$("#btnprocessingofsoa").button("reset");
			setTimeout(function(){
				showmodal("alert", "Please select the billing period you want to process.", "", null, "", null, "1");
			}, 500)
		}
	}

	function fncProcessSOA(){
		$("#mdl_confProcessSOA").modal("hide");
		$("#btnprocessingofsoa").button("loading");
		var TenantID = $("#txtTenantID").val();
		var SoAID = $("#txtBillingPeriod").val();
		var DateFrom = $("#txtPeriodFrom").val();
		var DateTo = $("#txtPeriodTo").val();
		var DueDate = $("#txtDueDate").val();
		$.ajax({
			type: 'POST',
			url: 'billing/billing/class.php',
			data: 'TenantID=' + TenantID + '&SoAID=' + SoAID + '&DateFrom=' + DateFrom + '&DateTo=' + DateTo + '&DueDate=' + DueDate + '&form=fncProcessSOA',
			beforeSend: function(){
            	$('#soaloadingscreentenant').addClass('myspinner');
			},
			success: function(data){
            	$('#soaloadingscreentenant').removeClass('myspinner');
				$("#btnprocessingofsoa").button("reset");
				var arr = data.split("|");
				if(arr[0] == 1){
					fncLoadPrevPeriods();
					setTimeout(function(){
						showmodal("alert", arr[1], "fncChangeActiveTR", SoAID+"|", "", null, "0");
					}, 500)
				}else if(arr[0] == 2){
					setTimeout(function(){
						showmodal("alert", arr[1], "", null, "", null, "1");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", "Failed to process Statement of Accounts", "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}

	function fncProcessSOA2(){
		$("#btnprocessingofsoa").button("loading");
		var TenantID = $("#txtTenantID").val();
		var SoAID = $("#txtBillingPeriod").val();
		var DateFrom = $("#txtPeriodFrom").val();
		var DateTo = $("#txtPeriodTo").val();
		var DueDate = $("#txtDueDate").val();
		$.ajax({
			type: 'POST',
			url: 'billing/billing/class.php',
			data: 'TenantID=' + TenantID + '&SoAID=' + SoAID + '&DateFrom=' + DateFrom + '&DateTo=' + DateTo + '&DueDate=' + DueDate + '&form=fncProcessSOA2',
			beforeSend: function(){
            	$('#soaloadingscreentenant').addClass('myspinner');
			},
			success: function(data){
            	$('#soaloadingscreentenant').removeClass('myspinner');
				var arr = data.split("|");
				$("#btnprocessingofsoa").button("reset");
				if(arr[0] == 1){
					setTimeout(function(){
						showmodal("alert", arr[1], "fncChangeActiveTR", SoAID+"|", "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", "Failed to process Statement of Accounts", "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}

	function fncChangeActiveTR(SoAID){
		$("#trPrev"+SoAID).click();
	}

	function fncCheckSelectedSOA(){
		var Checked = 0;
		$(".chkprintsoatenant").each(function(){
			if($(this).is(":checked")){
				Checked++;
			}
		})
		var SoAID = "";
		$("#tblPrevPeriods tr").each(function(){
			if($(this).hasClass("selected")){
				SoAID = $(this).attr("id").replace("trPrev", "");
			}
		});
    	var TenantIDs = "";
		$(".chkprintsoatenant").each(function(){
    		if($(this).is(":checked")){
				TenantIDs += $(this).val() + "|";
			}
    	})
		if(Checked == 0){
			setTimeout(function(){
				showmodal("alert", "No statement of account selected to be printed.", "", null, "", null, "1");
			}, 500)
		}else{
			$.ajax({
	    		type: 'POST',
	    		url: 'billing/billing/class.php',
	    		data: 'SoAID=' + SoAID + '&TenantIDs=' + TenantIDs + '&form=fncPrintMultipleSoa',
	    		success:function(data){
	    			$("#tblPrintSOAMulti").html(data);
	    		}, complete: function(){
    				var toprint = $("#tblPrintSOAMulti").html();
	    			var myheight = $(window).height();
			        var mywidth = $(window).width();
			        var popupWin = window.open("", "_blank", "height=" + myheight + ",width=" + mywidth + ",location=no,scrollbars=1,left=" + 20);
			        popupWin.document.open();
			        popupWin.document.write("<html><head><title></title><style>*{font-family: 'Arial';}</style></head><body onload='window.print();'>" + toprint + "</body></html>");
			        popupWin.document.close();
	    		}
	    	})
		}
    }

    function fncPostActivePeriod(){
    	var SoAID = "";
		$("#tblPrevPeriods tr").each(function(){
			if($(this).hasClass("selected")){
				SoAID = $(this).attr("id").replace("trPrev", "");
			}
		});
		if(SoAID == ""){
			setTimeout(function(){
				showmodal("alert", "Please select a billing period first.", "", null, "", null, "1");
			}, 500)
		}else{
			setTimeout(function(){
				showmodal("confirm", "Are you sure you want to post selected billing period.", "fncPostActivePeriod2", null, "", null, "1");
			}, 500)
			
		}
    }

    function fncPostActivePeriod2(){
    	var SoAID = "";
		$("#tblPrevPeriods tr").each(function(){
			if($(this).hasClass("selected")){
				SoAID = $(this).attr("id").replace("trPrev", "");
			}
		});
    	$.ajax({
			type: 'POST',
			url: 'billing/billing/class.php',
			data: 'SoAID=' + SoAID + '&form=fncPostActivePeriod',
			success: function(data){
				fncLoadPrevPeriods();
				loadtxtBillingPeriod();
			}, complete: function(){
				$("#txtBillingPeriod").val([]).trigger("change");
			}
		})
    }
//STATEMENT OF ACCOUNTS END

//IMPORTING OF BEVERAGE START
	function fncShowMdlImportBev(){
		$("#mdlImportBev").modal("show");
		$(".divImportBevHome").removeClass("hide");
        $(".divImportBevTab").addClass("hide");
        fncViewBevImportLogs();
	}

	 function fncImportBevTemplate(){
        $(".divImportBevHome").addClass("hide");
        $(".divImportBevTab").removeClass("hide");
    }

    function fncCancelImportBevTemplate(){
        $(".divImportBevHome").removeClass("hide");
        $(".divImportBevTab").addClass("hide");
    }

    function fncImportBevLogs(){
        var data = new FormData($('#frmImportBevTemplate')[0]);
        $.ajax({
            type: 'POST',
            url: 'Uploads/uploadBevLogs.php',
            data: data,
            mimeType: 'multipart/form-data',
            contentType: false,
            cache: false,
            processData: false,
            success:function(data){
            	var arr = data.split("|");
                if(arr[0] == 1){
                    setTimeout(function(){
                        showmodal("alert", arr[1], "fncClearUpload", null, "", null, "0");
                    }, 500)
                }else{
                    setTimeout(function(){
                        showmodal("alert", arr[1], "", null, "", null, "1");
                    }, 500)
                }
            }
        });
    }

    function fncClearUpload(){
    	$("#frmImportBevTemplate a").click();
    	fncCancelImportBevTemplate();
    	fncViewBevImportLogs();
    }

    function fncViewBevImportLogs(){
    	$.ajax({
    		type: 'POST',
    		url: 'billing/billing/class.php',
    		data: 'form=fncViewBevImportLogs',
    		success: function(data){
    			$("#tbodyBevImportLogs").html(data);
    		}
    	})
    }

    function fncPostCharges(UploadID){
    	setTimeout(function(){
			showmodal("confirm", "Are you sure you want to post all charges to billing?", "fncPostCharges2", UploadID+"|", "", null, "0");
		}, 500)
    }

    function fncPostCharges2(UploadID){
    	$.ajax({
    		type: 'POST',
    		url: 'billing/billing/class.php',
    		data: 'UploadID=' + UploadID + '&form=fncPostCharges',
    		success: function(data){
    			var arr = data.split("|");
                if(arr[0] == 1){
                    setTimeout(function(){
                        showmodal("alert", arr[1], "fncClearUpload", null, "", null, "0");
                    }, 500)
                }else{
                    setTimeout(function(){
                        showmodal("alert", arr[1], "", null, "", null, "1");
                    }, 500)
                }
    		}
    	})
    }

    function fncOpenBevChargesList(UploadID){
    	$("#txtBevUploadID").val(UploadID);
    	$("#mdlImportBevList").modal("show");
    	fncViewBevChargesList();
    }

    function fncViewBevChargesList(){
    	var key = $("#txtSearchBevList").val();
    	var UploadID = $("#txtBevUploadID").val();
    	$.ajax({
    		type: 'POST',
    		url: 'billing/billing/class.php',
    		data: 'UploadID=' + UploadID + '&key=' + key + '&form=fncViewBevChargesList',
    		success: function(data){
    			if(data != ""){
                    $("#tbodyBevImportChargeList").html(data);
                }else{
                    $("#tbodyBevImportChargeList").html("<tr><td colspan='8' style='text-align: center;'>No Data Found...</td></tr>");
                }
    		}
    	})
    }
//IMPORTING OF BEVERAGE END
</script>